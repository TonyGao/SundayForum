<?php

/**
 * (c) Tony Gao <linuxertony@163.com>
 *
 * For the full copyright and license information, please view the License
 * file that was distributed with this source code.
 */

namespace App\APIController\Utils;

use Aws\S3\S3Client;
use App\Entity\TempObjectFile;
use Aws\S3\Exception\S3Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Post related methods controller
 * @Route("/file")
 */
class FileController extends AbstractController
{
  private $security;

  public function __construct(Security $security)
  {
    $this->security = $security;
  }

  /**
   * upload an image
   * @Route("/image/upload", methods="POST", name="image_upload")
   */
  public function uploadImage(Request $request, S3Client $s3): JsonResponse
  {
    $image = $request->files->get('image');

    if (empty($image)) {
      return new JsonResponse(['success' => 0]);
    }

    $url = $s3->getObjectUrl($this->getParameter('aws_public_bucket'), 'abc123456.png');
    dump($url);

    $fileName = time() . uniqid() . '.' . $image->getClientOriginalExtension();
    try {
      $result = $s3->putObject([
        'Bucket' => $this->getParameter('aws_public_bucket'),
        'Key' => $fileName,
        'Body' => $stream,
      ]);

      /**
       * As editor.js response
       */
      $response = [
        'success' => 1,
        'file' => ['url' => $result['ObjectURL']]
      ];

      return new JsonResponse($response);
    } catch (S3Exception $e) {
      dump($e);
      return new JsonResponse(['success' => 0]);
    }
    //  $url = $s3->getObjectUrl('sundayforum', 'abc123456.png');
    //  return $this->render('forum/post/create.html.twig');
  }

  /**
   * get pre-signed url for uploading
   * @Route("/getpresigned", methods="GET", name="file_get_presigned_url")
   */
  public function getPreSignedURL(Request $request, S3Client $s3, EntityManagerInterface $em): JsonResponse
  {
    $extension = $request->get("extension");
    $operationID = $request->get("operationID");
    $fileName = time() . uniqid() . '.' . $extension;

    try {
      $cmd = $s3->getCommand('PutObject', [
        'Bucket' => $this->getParameter('aws_public_bucket'),
        'Key' => $fileName
      ]);
      $getCmd = $s3->getCommand('GetObject', [
        'Bucket' => $this->getParameter('aws_public_bucket'),
        'Key' => $fileName
      ]);
      $req = $s3->createPresignedRequest($cmd, '+20 minutes');
      $presignedUrl = (string)$req->getUri();

      $getReq = $s3->createPresignedRequest($getCmd, '+20 minutes');
      $getUrl = (string)$getReq->getUri();

      $tempObject = new TempObjectFile();
      $tempObject->setObjectKey($fileName)
        ->setOperationID($operationID);

      $em->persist($tempObject);
      $em->flush();

      return new JsonResponse([
        'success' => true,
        'preSignedURL' => $presignedUrl,
        'getUrl' => $getUrl,
        'objectKey' => $fileName,
      ]);
    } catch (S3Exception $e) {
      return new JsonResponse([
        'success' => false,
        'message' => $e
      ]);
    }
  }

  /**
   * delete sepecific file object
   * @Route("/deleteObject", methods="DELETE", name="file_delete_object")
   */
  public function deleteObject(Request $request, S3Client $s3): JsonResponse
  {
    try {
      $result = $s3->deleteObject([
        'Bucket' => $this->getParameter('aws_public_bucket'),
        'Key' => $request->get("objectKey")
      ]);
    } catch (S3Exception $e) {
      return new JsonResponse([
        'success' => false,
        'message' => $e
      ]);
    }
  }
}
