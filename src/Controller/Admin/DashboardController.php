<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\EvcProduct;
use App\Entity\EvcCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class DashboardController extends AbstractDashboardController
{

	public function __construct(protected Security $security)
    {
        
    }
	
	#[Route('/admin', name: 'admin')]
    public function index(): Response
    {
       	return $this->render('admin/index.html.twig');
	   	//return parent::index();
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Easyadmin');
    }

	public function configureCrud(): Crud
    {
        $crud = Crud::new()
			->showEntityActionsInlined()
        ;
        if(isset($_GET['crudAction'])) {
            if ($_GET['crudAction'] === Action::EDIT || $_GET['crudAction'] === Action::NEW) {
                $crud->setSearchFields(null);
            }
        }

		return $crud;
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToCrud('Components', 'fa fa-question-circle', EvcCategory::class)
                ->setPermission('ROLE_SUPER_ADMIN'),
            MenuItem::linkToCrud('Products', 'fa fa-question-circle', EvcProduct::class),
            MenuItem::linkToCrud('Categories', 'fa fa-question-circle', EvcCategory::class)
        ];
    }

}
