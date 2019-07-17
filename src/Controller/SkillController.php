<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Entity\Student;
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


            $skillRepository = $this->getDoctrine()->getRepository(Skill::class);
            $studentRepository = $this->getDoctrine()->getRepository(Student::class);

        //TODO add 'smart search' feature to search.

        //sucker searches:
        if (strtolower($data['search']) == 'that fucking american') {
            $student = $studentRepository->findOneBy([
                'firstname' => 'casey',
            ]);

            $id = $student->getId();
            return $this->redirectToRoute('student_show', [
                'id' => $id,
            ]);
        }

        if (strtolower($data['search']) == 'party girl') {
            $student = $studentRepository->findOneBy([
                'firstname' => 'Francesca',
            ]);

            $id = $student->getId();
            return $this->redirectToRoute('student_show', [
                'id' => $id,
            ]);
        }


            //test if search is a skill:
        if ($skillRepository->findOneBy(['name' => $data['search']])) {
            $skill = $skillRepository->findOneBy([
                'name' => $data['search'],
            ]);

            $skills = $skillRepository->findAll();
            $students = $skill->getStudents();

            return $this->render('skill/skill_search.html.twig', [
                'students' => $students,
                'skills' => $skills,
            ]);
        }

        //test if search is a student - firstname:
        if ($studentRepository->findOneBy(['firstname' => $data['search']])) {
            $student = $studentRepository->findOneBy([
                'firstname' => $data['search'],
            ]);

            $id = $student->getId();


            return $this->redirectToRoute('student_show', [
                'id' => $id,

            ]);
        }

        //test if search is a student - lastname:
        if ($studentRepository->findOneBy(['lastname' => $data['search']])) {
            $student = $studentRepository->findOneBy([
                'lastname' => $data['search'],
            ]);

            $id = $student->getId();


            return $this->redirectToRoute('student_show', [
                'id' => $id,
            ]);
        }

            //$skill = $skillRepository->findOneBy([
            //    'name' => $data['search'],
            //]);


            $skills = $skillRepository->findAll();
            $students = $studentRepository->findAll();

            return $this->render('skill/skill_search.html.twig', [
                'students' => $students,
                'skills' => $skills,
            ]);

    }

    /**
     * @param string $slug The slugger
     *
     * @Route("/search/{slug<^[a-z0-9-]+$>}", name="skill_pill")
     *
     * @return Response A response instance
     **/


    public function skillPill(?string $slug): Response
    {


        $repository = $this->getDoctrine()->getRepository(Skill::class);

        //$search = $request->request->get('search');

        $skill = $repository->findOneBy([
            'slug' => $slug,
        ]);
        $skills = $repository->findAll();

        $students = $skill->getStudents();


        return $this->render('skill/skill_search.html.twig', [
            'students' => $students,
            'skills' => $skills,
        ]);

    }
}
