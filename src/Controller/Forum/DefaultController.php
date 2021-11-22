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

class DefaultController extends AbstractController
{
    /**
     * @Route("/", methods="GET", name="index_page")
     */
    public function index(Request $request): Response
    {
        return $this->render('forum/default.html.twig');
    }
}