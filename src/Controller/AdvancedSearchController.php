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

        if (!in_array('Orléans', $campuses) && $campuses != []) {
            return $this->render('advanced_search/results.html.twig', [
                'rankedStudents' => [],
            ]);
        }

        $skills = array_diff($searchTerms, $campuses);

        //var_dump($skills);
        //var_dump($campuses);

        $skillRepository = $this->getDoctrine()->getRepository(Skill::class);
        $studentRepository = $this->getDoctrine()->getRepository(Student::class);

        $allStudents = $studentRepository->findAll();

        $studentRank = [];
        $maxSkills = count($skills);

        foreach($allStudents as $student) {

            //skills I have
            $username = $student->getUsername();
            $mySkills = $student->getSkills();
            $mySkillsToLearn = $student->getSkillsToLearn();

            $skillsArray = [];
            foreach ($mySkills as $mySkill) {
                $skillsArray[] = $mySkill->getSlug();  //was getName()
            }

            $skillsToLearnArray = [];
            foreach ($mySkillsToLearn as $mySkill) {
                $skillsToLearnArray[] = $mySkill->getSlug();   //was getName()
            }

            $matchingSkills = array_intersect($skills, $skillsArray);
            $matchingSkillsToLearn = array_intersect($skills, $skillsToLearnArray);

            $skillCount = count($matchingSkills) + (count($matchingSkillsToLearn)/2);

            if ($skillCount > 0) {

                $percent = round(100 * $skillCount/$maxSkills);
                $studentRank[$username] = $percent;

            }


        }

         arsort($studentRank);


        foreach ($studentRank as $key => $value) {
            $studentFromRank = $studentRepository->findBy([
                'username' => $key,
            ]);


            $studentResults[] = [$studentFromRank[0], $value];


        }




        return $this->render('advanced_search/results.html.twig', [
            'rankedStudents' => $studentResults,
        ]);


    }
}
