<?php
/**
 * Dough Flow Budget Forecasting System
 *
 * @author    Brad Neeley
 * @copyright Copyright (c) 2017
 * @license   All rights reserved
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Account;
use AppBundle\Form\Type\AccountType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render(
            'default/index.html.twig',
            [
                'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR
            ]
        );
    }

    /**
     * @param Request $request
     *
     * @Route("/account/create", name="create_account")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAccountAction(Request $request)
    {
        $form = $this->createForm(AccountType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $data = $form->getData();
                $em   = $this->getDoctrine()->getManager();
                $account = new Account();
                $account->setName($data['name']);
                $account->setType($data['type']);

                $em->persist($account);
                $em->flush();

                return $this->redirectToRoute('list_accounts');
            }
        }

        return $this->render(
            ':default:editAccount.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/accounts", name="list_accounts")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAccountsAction()
    {
        $em       = $this->getDoctrine()->getManager();
        $repo     = $em->getRepository(Account::class);
        $accounts = $repo->findAll();

        return $this->render(
            ':default:listAccounts.html.twig',
            [
                'accounts' => $accounts
            ]
        );
    }
}
