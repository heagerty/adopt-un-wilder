<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdvancedSearchController extends AbstractController

{

    const CAMPUSES = ['Orléans', 'Tours', 'Paris', 'Bordeaux', 'Lyon', 'La Loupe'];

    /**
     * @Route("/advanced/search", name="advanced_search")
     */
    public function index()
    {

        $skillRepository = $this->getDoctrine()->getRepository(Skill::class);
        $skills = $skillRepository->findAll();

        return $this->render('advanced_search/search.html.twig', [
            'controller_name' => 'AdvancedSearchController',
            'skills' => $skills,
            'campuses' => self::CAMPUSES,
        ]);
    }


    /**
     * @Route("/advanced/search/results", name="search_results", methods={"POST"})
     *
     **/


    public function skillSearch(Request $request): Response
    {

        $data = $request->request->all();
        $searchTerms = array_keys($data);

        $campuses = [];

        foreach($searchTerms as $searchTerm) {
            if (in_array($searchTerm, self::CAMPUSES)) {
                $campuses[] = $searchTerm;
            }
        }

        $skills = array_diff($searchTerms, $campuses);

        //var_dump($skills);
        //var_dump($campuses);

        $skillRepository = $this->getDoctrine()->getRepository(Skill::class);
        $studentRepository = $this->getDoctrine()->getRepository(Student::class);

        $allStudents = $studentRepository->findAll();

        $studentRank = [];

        foreach($allStudents as $student) {
            $username = $student->getUsername();
            $mySkills = $student->getSkills();
            $skillsArray = [];
            foreach ($mySkills as $mySkill) {
                $skillsArray[] = $mySkill->getName();
            }

            $matchingSkills = array_intersect($skills, $skillsArray);


            $skillCount = count($matchingSkills);
            if ($skillCount > 0) {
                $studentRank[$username] = $skillCount;
            }
        }

         arsort($studentRank);


        //TODO take ranked list of student usernames and reconvert them into students to send to the view.

        foreach ($studentRank as $key => $value) {
            $studentFromRank = $studentRepository->findBy([
                'username' => $key,
            ]);

            $studentResults[] = $studentFromRank[0];
        }




        return $this->render('advanced_search/results.html.twig', [
            'rankedStudents' => $studentResults,
        ]);


    }
}
