<?php

namespace ShopBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Class CreateUserCommand
 * @package ShopBundle\Command
 */
class CreateUserCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            // Nom de la commande (après " php bin/console ")
            ->setName('shop:create-user')
            // Définition d'un argument
            ->addArgument('username', InputArgument::OPTIONAL, 'The username of the user.', null)
            // Description courte affichée avec "php bin/console list"
            ->setDescription('Creates new users.')
            // Description longue affichée avec l'option "--help"
            ->setHelp("This command allows you to create new users.");
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $usernameValidator = function ($answer) {
            $answer = trim($answer);
            if (4 > strlen($answer)) {
                throw new \RuntimeException(
                    'Veuillez saisir un nom d\'utilisateur d\'au moins 3 caractères'
                );
            }

            return $answer;
        };

        // If the username command argument has been provided
        $username = $input->getArgument('username');
        if (0 < strlen($username)) {
            $username = $usernameValidator($username);
        } else {
            // Username question
            $usernameQuestion = new Question('Username: ');
            $usernameQuestion->setValidator($usernameValidator);
            $usernameQuestion->setMaxAttempts(3);

            // Ask for username
            $username = $helper->ask($input, $output, $usernameQuestion);
        }


        // Password question
        $passwordQuestion = new Question('Password: ');
        $passwordQuestion->setValidator(function ($answer) {
            $answer = trim($answer);
            if (4 > strlen($answer)) {
                throw new \RuntimeException(
                    'Veuillez saisir un mot de passe d\'au moins 3 caractères'
                );
            }

            return $answer;
        });
        $passwordQuestion->setHidden(true);
        $passwordQuestion->setMaxAttempts(3);

        // Ask for password
        $password = $helper->ask($input, $output, $passwordQuestion);


        // Roles question
        $question = new ChoiceQuestion(
            'Roles: ',
            array('ROLE_USER', 'ROLE_ADMIN'/*, 'ROLE_SUPER_ADMIN'*/),
            0
        );
        $question->setErrorMessage('Role "%s" is invalid.');

        $role = $helper->ask($input, $output, $question);

        $this
            ->getContainer()
            ->get('shop.service.user_manager')
            ->createUser($username, $password, [$role]);

        $output->writeln('User has been successfully created !');
    }
}
