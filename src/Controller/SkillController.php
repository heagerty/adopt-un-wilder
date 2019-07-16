<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Repository\SkillRepository;
use App\Repository\StudentRepository;
use App\Service\Slugify;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;




/**
 * @Route("/skill")
 */
class SkillController extends AbstractController
{
    /**
     * @Route("/", name="skill_index", methods={"GET"})
     */
    public function index(SkillRepository $skillRepository): Response
    {
        return $this->render('skill/index.html.twig', [
            'skills' => $skillRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="skill_new", methods={"GET","POST"})
     */
    public function new(Request $request, Slugify $slugify): Response
    {
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $slug = $slugify->generate($skill->getName());
            $skill->setSlug($slug);

            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute('skill_index');
        }

        return $this->render('skill/new.html.twig', [
            'skill' => $skill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="skill_show", methods={"GET"})
     */
    public function show(Skill $skill): Response
    {
        return $this->render('skill/show.html.twig', [
            'skill' => $skill,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="skill_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Skill $skill): Response
    {
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('skill_index', [
                'id' => $skill->getId(),
            ]);
        }

        return $this->render('skill/edit.html.twig', [
            'skill' => $skill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="skill_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Skill $skill): Response
    {
        if ($this->isCsrfTokenValid('delete'.$skill->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($skill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('skill_index');
    }

    /**
     * @Route("/search/", name="skill_search", methods={"POST"})
     *
     **/


    public function skillSearch(Request $request): Response
    {

        $data = $request->request->all();


            $repository = $this->getDoctrine()->getRepository(Skill::class);

            //$search = $request->request->get('search');

            $skill = $repository->findOneBy([
                'name' => $data['search'],

            ]);

            $skills = $repository->findAll();

            $students = $skill->getStudents();


            return $this->render('skill/skill_search.html.twig', [
                'students' => $students,
                'skills' => $skills,
            ]);

    }

    /**
     * @Route("/search/{name}", name="skill_pill", methods={"POST, GET"})
     *
     **/


    public function skillPill($name): Response
    {


        $repository = $this->getDoctrine()->getRepository(Skill::class);

        //$search = $request->request->get('search');

        $skill = $repository->findOneBy([
            'name' => $name,
        ]);
        $skills = $repository->findAll();

        $students = $skill->getStudents();


        return $this->render('skill/skill_search.html.twig', [
            'students' => $students,
            'skills' => $skills,
        ]);

    }
}
