<?php
// src/Mdy/GstBundle/DataFixtures/ORM/Lieux.php

namespace Mdy\GstBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mdy\GstBundle\Entity\Equipe;

class Equipes implements FixtureInterface{
	public function load(ObjectManager $manager){
		$listEquipes = array(
					array('nom' => 'Ardoisiers'),
					array('nom' => 'Balayeuse'),
					array('nom' => 'Chauffagiste'),
					array('nom' => 'Cimetière'),
					array('nom' => 'Concierge'),
					array('nom' => 'Electriciens'),
					array('nom' => 'Jardinage'),
					array('nom' => 'Maçons'),
					array('nom' => 'Menuisiers'),
					array('nom' => 'Peintres'),
					array('nom' => 'Propreté'),
					array('nom' => 'Voirie'),
					array('nom' => 'Volante')
					);
		foreach ($listEquipes as $i => $equipe){
			$equip = new Equipe();
			$equip->setNom($equipe['nom']);
			$manager->persist($equip);
		}
		$manager->flush();
	}
}