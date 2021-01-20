<?php


namespace App\Form;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Class AddUserToTournamentType
 * @package App\Form
 */
class AddUserToTournamentType extends AbstractType
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('usersToAdd', Select2EntityType::class, [
                'mapped'               => false,
                'label'                => 'Add users',
                'class'                => User::class,
                'remote_route'         => 'add-user-to-tournament',
                'multiple'             => true,
                'required'             => false,
                'placeholder'          => 'Type name or email',
                'scroll'               => true,
                'minimum_input_length' => 3,
                'attr'                 => [
                    'class' => 'darkmode',
                ],
            ]);

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_token_id' => 'form_intention',
        ]);
    }
}