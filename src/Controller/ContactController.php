<?php
namespace App\Controller;

use App\Form\ContactType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET','POST'])]
    public function index(Request $request, MailerInterface $mailer, LoggerInterface $logger): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $d = $form->getData(); // nom, prenom, email, telephone, sujet, message

            $to = 'max80ad@gmail.com';           // destinataire final
            $from = 'no-reply@dpformation.fr';     // expéditeur autorisé par ton SMTP
            $reply = $d['email'];                   // adresse du visiteur

            $plain = sprintf(
                "De: %s %s\nEmail: %s\nTéléphone: %s\n\nMessage:\n%s",
                $d['prenom'], $d['nom'], $d['email'], $d['telephone'] ?? '—', $d['message']
            );

            $email = (new Email())
                ->from($from)
                ->replyTo($reply)
                ->to($to)
                ->subject('[Site] '.$d['sujet'])
                ->text($plain)
                ->html($this->renderView('emails/contact.html.twig', ['d' => $d]));

            try {
                $mailer->send($email);
                $this->addFlash('success', 'Merci, votre message a bien été envoyé.');
                return $this->redirectToRoute('app_contact');
            } catch (TransportExceptionInterface $e) {
                $logger->error('Erreur d’envoi email', ['exception' => $e]);
                $this->addFlash('danger', "L'envoi a échoué : ".$e->getMessage());
            }
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}
