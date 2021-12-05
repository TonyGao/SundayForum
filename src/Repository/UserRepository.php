<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserLoaderInterface
{
    /**
     * There are three types for user identifier so far.
     * 1, username
     * 2, emails
     * 3, phone
     */
    protected $userIdentifier;

    public function __construct(ManagerRegistry $registry, string $userIdentifier)
    {
        parent::__construct($registry, User::class);
        $this->userIdentifier = $userIdentifier;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * Load identifier for user login
     */
    public function loadUserByIdentifier(string $identifier): ?User
    {
        $em = $this->getEntityManager();

        // Detemine the parameters for user identifier type
        $userIds = explode(',', $this->userIdentifier);

        $qb = $em->createQueryBuilder();
        $qb->select('u')
            ->from('App\Entity\User', 'u')
            ->orWhere('u.'.$userIds[0].' = :query');

        if (count($userIds) > 1) {
            $countIdx = count($userIds) - 1;
            for($i = 1; $i <= $countIdx; $i++) {
                $qb->orWhere('u.'.$userIds[$i].' = :query');
            }
        }
        
        $user = $qb->setParameter('query', $identifier)
                   ->getQuery()
                   ->getOneOrNullResult();

        if ($user !== null) {
            if ($user->isVerified()) {
                return $user;
            } else {
                throw new CustomUserMessageAuthenticationException('The email for the user register is not verified');
            }
        }

        return $user;
    }

    /** @deprecated since Symfony 5.3 */
    public function loadUserByUsername(string $usernameOrEmail): ?User
    {
        return $this->loadUserByIdentifier($usernameOrEmail);
    }
}
