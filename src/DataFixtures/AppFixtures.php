<?php

namespace App\DataFixtures;

use App\Entity\Civility;
use App\Entity\Company;
use App\Entity\EvalQuestion;
use App\Entity\EvalScore;
use App\Entity\EvalYn;
use App\Entity\Participant;
use App\Entity\Question;
use App\Entity\Response;
use App\Entity\Session;
use App\Entity\Trainer;
use App\Entity\Training;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $civility = ['M.', 'Mme'];
        $civilityArray = [];
        foreach ($civility as $item){
            $civ = new Civility();
            $civ->setTitle($item);
            $civilityArray[] = $civ;
            $manager->persist($civ);
        }

        /*$companyArray = [];
        for ($i=0; $i<10; $i++) {
            $company = new Company();
            $company->setEmail($faker->email);
            $company->setName($faker->name);
            $manager->persist($company);
            $companyArray[] = $company;
        }*/

        $evalQuestion = ['Formation prévue dans mon agenda par mon établissement ou ma collectivité',
                        'Utile pour renforcer mes connaissances professionnelles ou personnelles',
                        'Elle était nécessaire pour acquérir de nouvelles compétences',
                        'J’étais motivé (e) pour suivre ce module',
                        'Estimez-vous que la formation était en adéquation avec vos attentes ?',
                        'Recommanderiez-vous cette formation à vos collègues de travail ou amis(es) ?',
                        'Les techniques d\'enseignement ont-elles favorisé votre apprentissage ? ',
                        'Qualité des supports pédagogiques ',
                        'Animation de la formation par le ou les intervenants ?',
                        'Progression de la formation (durée, rythme, alternance théorie/pratique)'
        ];
        foreach ($evalQuestion as $item){
            $question = new EvalQuestion();
            $question->setQuestion($item);
            $manager->persist($question);
        }

        for ($i=0; $i<4; $i++) {
            $score = new EvalScore();
            $score->setScore($i+1);
            $manager->persist($score);
        }

        $evalYN = ['oui', 'non'];
        foreach ($evalYN as $item){
            $yn = new EvalYn();
            $yn->setResponse($item);
            $manager->persist($yn);
        }

        $questionQCM = ['Une personne est identifiée en arrêt cardiaque si :',
                        'L’ensemble des bons numéros aux services d’urgence et de secours en France sont :',
                        'À propos du défibrillateur et du massage cardiaque :'
        ];
        foreach ($questionQCM as $item) {
            $quesQCM = new Question();
            $quesQCM->setText($item);
            $manager->persist($quesQCM);
        }

        $response = ['Elle tousse.' => 1,
                    'Elle ne respire pas et ne répond pas.' => 2,
                    'Elle répond de façon complètement incohérente aux questions.' => 3,
                    '15 ; 18 ; 112 ; (114)' => 4,
                    '13 ; 14 ; 15' => 5,
                    '12 ; 17 ; 218' => 6,
                    'Le défibrillateur remplace le massage cardiaque dès sa mise en place.' => 7,
                    'Le massage cardiaque doit être débuté avant l’arrivée du défibrillateur, et maintenu durant la réanimation en suivant les consignes du défibrillateur.' => 8,
                    'Le massage cardiaque se pratique en appuyant doucement et lentement sur le côté de la poitrine, et le défibrillateur devra être retiré durant le massage.' => 9
        ];
        foreach ($response as $item => $number) {
            $resp = new Response();
            $resp->setText($item);
            $resp->setNumber($number);
            $manager->persist($resp);
        }

        /*$trainerArray = [];
        for ($i=0; $i<3; $i++) {
            $trainer = new Trainer;
            $trainer->setFirstname($faker->firstName);
            $trainer->setLastname($faker->lastName);
            $manager->persist($trainer);
            $trainerArray[] = $trainer;
        }

        $sessionArray = [];
        for ($i=0; $i<3; $i++) {
            $session = new Session();
            $session->setCompany($faker->randomElement($companyArray));
            $session->setStartDate($faker->dateTime);
            $session->setIsArchived(false);
            $session->setEndDate($faker->dateTime);
            $session->setConnectionNumber(3);
            $manager->persist($session);
            $sessionArray[] = $session;
        }


        $training = new Training();
        $training->setSession($faker->randomElement($sessionArray));
        $training->setTrainer($faker->randomElement($trainerArray));
        $training->setTitle('LUF');
        $training->setFaceDate($faker->dateTime);
        $training->setHours(3);
        $manager->persist($training);


        for ($i=0; $i<3; $i++) {
            $participant = new Participant();
            $participant->setCivility($faker->randomElement($civilityArray));
            $participant->setFirstname($faker->firstName);
            $participant->setLastname($faker->lastName);
            $participant->setEmail($faker->email);
            $participant->setSession($faker->randomElement($sessionArray));
            $manager->persist($participant);
        }*/

        $user = new User();
        $user->setEmail('varaponegaire@gmail.com');
        $user->setPassword($this->encoder->encodePassword($user,'azerty'));
        $user->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);

        $manager->flush();
    }
}
