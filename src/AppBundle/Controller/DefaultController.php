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
    const FLASH_SUCCESS = 'success';

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
     * @param int     $id
     *
     * @Route("/account/create", name="create_account")
     * @Route("/account/{id}/edit", name="edit_account", requirements={"id" = "\d+"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAccountAction(Request $request, int $id = null)
    {
        $em      = $this->getDoctrine()->getManager();
        if ($id) {
            $repo    = $em->getRepository(Account::class);
            $account = $repo->find($id);

            if (is_null($account)) {
                return $this->redirectToRoute('list_accounts');
            }

            $options = ['action' => $this->generateUrl('edit_account', ['id' => $id])];
            $form    = $this->createForm(AccountType::class, $account, $options);
        } else {
            $account = new Account();
            $options       = ['action' => $this->generateUrl('create_account')];
            $form          = $this->createForm(AccountType::class, $account, $options);
        }

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($account);
                $em->flush();

                $this->addFlash(
                    static::FLASH_SUCCESS,
                    "Your changes for the {$account->getName()} account have been saved"
                );

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
