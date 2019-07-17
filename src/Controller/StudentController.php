<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use App\Service\Codewars;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/students")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/index", name="student_index", methods={"GET"})
     */
    public function index(StudentRepository $studentRepository): Response
    {
        return $this->render('student/index.html.twig', [
            'students' => $studentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/", name="students", methods={"GET"})
     */
    public function publicIndex(StudentRepository $studentRepository): Response
    {
        return $this->render('student/students.html.twig', [
            'students' => $studentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="student_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('student_index');
        }

        return $this->render('student/new.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="student_show", methods={"GET"})
     */
    public function show(Student $student, Codewars $codewars): Response
    {

        $kata = [];
        $honor = 0;

        if (null == ($student->getCodewarsId())) {
            return $this->render('student/show.html.twig', [
                'student' => $student,
                'honor' => 0,
                //'kata' => [],
            ]);
        }
        $codewarsId = $student->getCodewarsId();
        $honor = $codewars->getHonor($codewarsId);
        //$kata = $codewars->getKata($codewarsId);


        return $this->render('student/show.html.twig', [
            'student' => $student,
            'honor' => $honor,
            //'kata' => $kata,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="student_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Student $student): Response
    {
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('student_index', [
                'id' => $student->getId(),
            ]);
        }

        return $this->render('student/edit.html.twig', [
            'student' => $student,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="student_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Student $student): Response
    {
        if ($this->isCsrfTokenValid('delete'.$student->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($student);
            $entityManager->flush();
        }

        return $this->redirectToRoute('student_index');
    }


    /**
     * @Route("/showtest/{id}", name="test_show", methods={"GET"})
     */
    public function showtest(Student $student, Codewars $codewars): Response
    {

        $kata = [];
        $honor = 0;

        if (null == ($student->getCodewarsId())) {
            return $this->render('student/show.html.twig', [
                'student' => $student,
                'honor' => 0,
                //'kata' => [],
            ]);
        }
        //$codewarsId = $student->getCodewarsId();
        //$honor = $codewars->getHonor($codewarsId);
        //$kata = $codewars->getKata($codewarsId);


        return $this->render('student/student_profile.html.twig', [
            'student' => $student,
            'honor' => $honor,
            //'kata' => $kata,
        ]);
    }
}
