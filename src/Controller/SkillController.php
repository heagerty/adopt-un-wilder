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

        $skills = $skillRepository->findAll();


        //TODO rewrite search as 'OR' to return both students that know Git and Mary Git

        //sucker searches:

        $lowerSearch = 'x '.strtolower($data['search']);


        if (strpos($lowerSearch, 'american') != 0) {
            $student = $studentRepository->findOneBy([
                'firstname' => 'casey',
            ]);

            $students[] = $student;

            return $this->render('skill/skill_search.html.twig', [
                'students' => $students,
                'skills' => $skills,
            ]);
        }

        if (strpos($lowerSearch, 'girl') != 0) {
            $student = $studentRepository->findOneBy([
                'firstname' => 'francesca',
            ]);

            $students[] = $student;

            return $this->render('skill/skill_search.html.twig', [
                'students' => $students,
                'skills' => $skills,
            ]);
        }

        if (strpos($lowerSearch, 'boy') != 0) {
            $student = $studentRepository->findOneBy([
                'firstname' => 'casey',
            ]);

            $students[] = $student;

            return $this->render('skill/skill_search.html.twig', [
                'students' => $students,
                'skills' => $skills,
            ]);
        }



            //test if search is a skill:
        if ($skillRepository->findOneBy(['name' => $data['search']])) {
            $skill = $skillRepository->findOneBy([
                'name' => $data['search'],
            ]);


            $studentsBySkill = $skill->getStudents();



//            return $this->render('skill/skill_search.html.twig', [
//                'students' => $students,
//                'skills' => $skills,
//            ]);
        }

        //test if search is a student - firstname:
        if ($studentRepository->findBy(['firstname' => $data['search']])) {
            $studentsByFirstname = $studentRepository->findBy([
                'firstname' => $data['search'],
            ]);
        }


        //test if search is a student - lastname:
        if ($studentRepository->findBy(['lastname' => $data['search']])) {
            $studentsByLastname = $studentRepository->findBy([
                'lastname' => $data['search'],
            ]);
        }


        $students = $studentRepository->findAll();

        $studentsFound = [];


        //test if search is a student - full name:
        foreach($students as $studentFullName) {
            $firstname = $studentFullName->getFirstname();
            $lastname = $studentFullName->getLastname();
            $fullname1 = strtolower($firstname.' '.$lastname);
            $fullname2 = strtolower($lastname.' '.$firstname);

            $lcSearch = strtolower($data['search']);

            if ($lcSearch == $fullname1 || $lcSearch == $fullname2 ) {
                $studentsFound[] = $studentFullName;
            }

        }





            //$studentsFound = [];

            foreach ($students as $student) {
                if(isset($studentsBySkill) && $studentsBySkill->contains($student)) {
                    $studentsFound[] = $student;
                    }
                if(isset($studentsByFirstname) && in_array($student, $studentsByFirstname) && !in_array($student, $studentsFound)) {
                    $studentsFound[] = $student;
                }
                if(isset($studentsByLastname) &&  in_array($student, $studentsByLastname) && !in_array($student, $studentsFound)) {
                    $studentsFound[] = $student;
                }
            }

            return $this->render('skill/skill_search.html.twig', [
                'students' => $studentsFound,
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
        $interestedStudents = $skill->getInterestedStudents();

        if (count($students) == 0) {
            $students = $interestedStudents;
        }




        return $this->render('skill/skill_search.html.twig', [
            'students' => $students,
            'interestedStudents' => $interestedStudents,
            'skills' => $skills,
            'searchedSkill' => $skill,
        ]);

    }
}
