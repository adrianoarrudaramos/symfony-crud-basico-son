<?php

namespace App\Controller;

use App\Entity\Produto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class HelloController extends AbstractController
{
  /**
   * @return Response
   * 
   * @Route("hello_world")
   */
  public function world()
  {
    return new Response(
      "<html><body><h1>Hello World!</h1></body></html>"
    );
  }

  /**
   * @return Response
   * 
   * @Route("mostrar-mensagem")
   */
  public function mensagem()
  {
    return $this->render("hello/mensagem.html.twig", [
      'mensagem' => "Olá School of Net! Adriano topzera"
    ]);
  }

  /**
   * @return Response
   * 
   * @Route("cadastrar-produto")
   */
  public function produto()
  {
    $em = $this->getDoctrine()->getManager();
    $produto = new Produto();
    $produto->setNome("Xbox")
      ->setPreco(2300.00);
    $em->persist($produto);
    $em->flush();

    return new Response("O produto " . $produto->getId() . " foi criado.");
  }

  /**
   * @return Response
   * 
   * @Route("formulario")
   */
  public function formulario(Request $request)
  {
    $produto = new Produto();
    $form = $this->createFormBuilder($produto)
      ->add('nome', TextType::class)
      ->add('preco', TextType::class)
      ->add('enviar', SubmitType::class, ['label' => "Salvar"])
      ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      return new Response("Formulário está ok!");
    }

    return $this->render("hello/formulario.html.twig", [
      'form' => $form->createView()
    ]);
  }
}
