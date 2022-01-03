<?php

/**
 * (c) Tony Gao <linuxertony@163.com>
 * 
 * For the full copyright and license information, please view the License
 * file that was distributed with this source code.
 */

 namespace App\Controller\Forum;

 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\HttpFoundation\Request;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\Routing\Annotation\Route;
 use Aws\S3\S3Client;

 /**
  * Post related methods controller
  */
 class PostController extends AbstractController
 {
     /**
      * @Route("/post/create", methods="GET", name="post_create")
      */
     public function createPost(Request $request): Response
     {
         return $this->render('forum/post/create.html.twig');
     }
 }