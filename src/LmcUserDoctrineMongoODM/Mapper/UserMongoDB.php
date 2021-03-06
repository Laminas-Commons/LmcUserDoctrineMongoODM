<?php

namespace LmcUserDoctrineMongoODM\Mapper;

use Doctrine\ODM\MongoDB\DocumentManager,
    LmcUserDoctrineMongoODM\Options\ModuleOptions;

class UserMongoDB implements \LmcUser\Mapper\UserInterface
{
    /**
     * @var \Doctrine\ODM\DocumentManager
     */
    protected $dm;
    
    /**
     * @var \LmcUserDoctrineMongoODM\Options\ModuleOptions
     */
    protected $options;
    
    public function __construct(DocumentManager $dm, ModuleOptions $options)
    {
        $this->dm      = $dm;
        $this->options = $options;
    }

    public function findByEmail($email)
    {
        $dm = $this->getDocumentManager();
        $class = $this->options->getUserEntityClass();
        $user = $dm->getRepository($class)->findOneBy(array('email' => $email));
        return $user;
    }

    public function findByUsername($username)
    {
        $dm = $this->getDocumentManager();
        $class = $this->options->getUserEntityClass();
        $user = $dm->getRepository($class)->findOneBy(array('username' => $username));
        return $user;
    }
    
    public function findById($id)
    {
        $dm = $this->getDocumentManager();
        $class = $this->options->getUserEntityClass();
        $user = $dm->getRepository($class)->findOneBy(array('id' => $id));
        return $user;
    }

    public function getDocumentManager()
    {
        return $this->dm;
    }

    public function setDocumentManager(DocumentManager $dm)
    {
        $this->dm = $dm;
        return $this;
    }

    public function getUserRepository()
    {
    	$class = LmcUser::getOption('user_entity_class');
        return $this->getDocumentManager()->getRepository($class);
    }
    
    public function persist($document)
    {
        $dm = $this->getDocumentManager();
        $dm->persist($document);
        $dm->flush();
    }
    
    public function insert(\LmcUser\Entity\UserInterface $user)
    {
        $this->dm->persist($user);
        $this->dm->flush();
    }

    public function update(\LmcUser\Entity\UserInterface $user)
    {

        $this->dm->persist($user);
        $this->dm->flush();
    }
}
