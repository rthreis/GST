<?php
/**
 * File :	InterventionRepository.php
 * Bundle : MdyGstBundle
 * Path :	src/Mdy/GstBundle/Entity
 * Since :	--
 * Update :	29/01/2016
 * Author :	R. Threis
 */
namespace Mdy\GstBundle\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
class InterventionRepository extends EntityRepository
{
	public function findComplete($id){
		$qb =  $this->createQueryBuilder('inter')
					->leftJoin('inter.lieu', 'lieu')
					->addSelect('lieu')
					->leftJoin('inter.equipes', 'equipe')
					->addSelect('equipe')
					;
		return $qb->getQuery()->getResult();
	}
	
	public function getNext($intervention){
		$qb = $this->createQueryBuilder('inter');
		$nextNumero = $intervention->getNumero()+1;
		$qb->andWhere($qb->expr()->eq('inter.numero', ':suivant'));
		$qb->setParameter('suivant', $nextNumero);
		return $qb->getQuery()->getResult();
	}
	
	public function getPrevious($intervention){
		$qb = $this->createQueryBuilder('inter');
		$previousNumero = $intervention->getNumero()-1;
		$qb->andWhere($qb->expr()->eq('inter.numero', ':suivant'));
		$qb->setParameter('suivant', $previousNumero);
		return $qb->getQuery()->getResult();
	}
	
	public function getExport(){
		$qb =  $this->createQueryBuilder('inter');
		$qb->andWhere($qb->expr()->isNull('inter.printed '))
					->leftJoin('inter.equipes', 'equipe')
					->addSelect('equipe')
					;
		$qb->andWhere($qb->expr()->isNotNull('equipe'))
					;
		$qb = $this->whereNotCloture($qb);
		return $qb->getQuery()->getResult();
	}
	
	public function myFindAll($filter, $equipe, $nombreParPage, $page, $role){
		$qb = $this->createQueryBuilder('inter');
		
		if( $role == "ROLE_DIRECTEUR"){
			$qb = $this->whereRoleDirecteur($qb, $filter, $equipe);
		}
		elseif( $role == "ROLE_ECHEVIN" ) {
			$qb = $this->whereRoleEchevin($qb, $filter, $equipe);
		}
		else{
			$qb = $this->whereRole($qb, $filter, $equipe);
		}
		$qb->setFirstResult(($page-1) * $nombreParPage)
			->setMaxResults($nombreParPage);
		return new Paginator($qb);
		// return $qb->getQuery()->getResult();
	}
	
	public function getIntervention($page, Intervention $intervention){
		$qb = $this->createQueryBuilder('inter');
		$qb->orderBy('inter.id');
		$qb->setFirstResult($intervention.id)
			->setMaxResults(1);
		return new Paginator($qb);
	}
	
	private function whereRoleDirecteur(\Doctrine\ORM\QueryBuilder $qb, $filter, $equipe){
		if( $filter == "none" ){
			$qb->leftJoin('inter.approbations', 'appro')
				->addSelect('appro');
			$qb->andWhere($qb->expr()->eq('inter.accDirReq', 'true'));
			$nots = $this->toExclude("ROLE_DIRECTEUR");
			if( !empty($nots)){
				$qb->andWhere($qb->expr()->notIn('inter.id', $nots));
			}
			// $qb = $this->whereNotPrinted($qb);
			$qb = $this->whereNotCloture($qb);
			$qb = $this->whereNotDeleted($qb);
		}
		elseif( $filter == "nack" ){
			$qb = $this->whereNotAcknoledged($qb);
			$qb = $this->whereNotDeleted($qb);
		}
		elseif( $filter == "ack" ){
			$qb = $this->whereAcknoledged($qb);
			$qb = $this->whereNotCloture($qb);
			$qb = $this->whereNotDeleted($qb);
		}
		elseif( $filter == "clos"){
			$qb = $this->whereCloture($qb);
			$qb = $this->whereNotDeleted($qb);
		}
		elseif( $filter == "prin" ){
			$qb = $this->whereAcknoledged($qb);
			$qb = $this->wherePrinted($qb);
			$qb = $this->whereNotCloture($qb);
			$qb = $this->whereNotDeleted($qb);
		}
		elseif( $filter == "del"){
			$qb = $this->whereDeleted($qb);
		}
		return $qb;
	}
	
	private function whereRoleEchevin(\Doctrine\ORM\QueryBuilder $qb, $filter, $equipe){
		if( $filter == "none" ){
			$qb->leftJoin('inter.approbations', 'appro')
				->addSelect('appro');
			$qb->andWhere($qb->expr()->eq('inter.accEchReq', 'true'));
			$nots = $this->toExclude("ROLE_ECHEVIN");
			if( !empty($nots)){
				$qb->andWhere($qb->expr()->notIn('inter.id', $nots));
			}
			// $qb = $this->whereNotPrinted($qb);
			$qb = $this->whereNotCloture($qb);
			$qb = $this->whereNotDeleted($qb);
		}
		elseif( $filter == "nack" ){
			$qb = $this->whereNotAcknoledged($qb);
			$qb = $this->whereNotDeleted($qb);
		}
		elseif( $filter == "ack" ){
			$qb = $this->whereAcknoledged($qb);
			$qb = $this->whereNotCloture($qb);
			$qb = $this->whereNotDeleted($qb);
		}
		elseif( $filter == "clos"){
			$qb = $this->whereCloture($qb);
			$qb = $this->whereNotDeleted($qb);
		}
		elseif( $filter == "prin" ){
			$qb = $this->whereAcknoledged($qb);
			$qb = $this->wherePrinted($qb);
			$qb = $this->whereNotCloture($qb);
			$qb = $this->whereNotDeleted($qb);
		}
		elseif( $filter == "del"){
			$qb = $this->whereDeleted($qb);
		}
		return $qb;
	}
	
	private function whereRole(\Doctrine\ORM\QueryBuilder $qb , $filter, $equipe){
		$qb = $this->joinEquipe($qb);
		if( $filter == "none"){
			$qb = $this->joinCloture($qb);
			$qb = $this->whereNotPrinted($qb);
			$qb = $this->whereNotAssigned($qb);
			$qb = $this->whereNotCloture($qb);
		}
		elseif( $filter == "nack" ){
			$qb = $this->joinApprobation($qb);
			$qb = $this->joinCloture($qb);
			$qb = $this->whereNotAcknoledged($qb);
			$qb = $this->whereNotCloture($qb);
			$qb = $this->whereNotDeleted($qb);
		}
		elseif( $filter == "ack" ){
			$qb = $this->joinApprobation($qb);
			$qb = $this->joinCloture($qb);
			$qb = $this->whereAcknoledged($qb);
			$qb = $this->whereNotCloture($qb);
			$qb = $this->whereNotDeleted($qb);
		}
		elseif( $filter == "clos") {
			$qb = $this->joinCloture($qb);
			$qb = $this->whereCloture($qb);
			$qb = $this->whereNotDeleted($qb);
		}
		elseif( $filter == "prin" ){
			$qb = $this->joinCloture($qb);
			$qb = $this->wherePrinted($qb);
			$qb = $this->whereNotCloture($qb);
			$qb = $this->whereNotDeleted($qb);
		}
		elseif( $filter == "nprin"){
			$qb = $this->whereNotPrinted($qb);
			$qb = $this->whereNotDeleted($qb);
		}
		elseif( $filter == "nass") {
			$qb = $this->whereNotAssigned($qb);
			$qb = $this->whereNotDeleted($qb);
		}
		elseif( $filter == "del" ) {
			$qb = $this->whereDeleted($qb);
		}
		if( $equipe != 0){
			$qb = $this->filterEquipe($qb, $equipe);
		}
		
		return $qb;
	}
	
	private function filterEquipe($qb, $equipe){
		$qb = $qb->andWhere($qb->expr()->eq('equipe.id', ':equipe'))
				->setParameter('equipe', $equipe);
		return $qb;
	}
	
	private function joinEquipe(\Doctrine\ORM\QueryBuilder $qb){
		$qb = $qb->leftJoin('inter.equipes', 'equipe');
		return $qb;
	}
	
	private function joinCloture(\Doctrine\ORM\QueryBuilder $qb){
		$qb = $qb->leftJoin('inter.clotures', 'cloture');
		return $qb;
	}
	
	private function joinApprobation(\Doctrine\ORM\QueryBuilder $qb){
		$qb = $qb->leftJoin('inter.approbations', 'approbation');
		return $qb;
	}
	
	public function whereCloture(\Doctrine\ORM\QueryBuilder $qb){
		$qb = $qb->andWhere($qb->expr()->isNotNull('cloture.id'));
		return $qb;
	}
	
	public function whereNotCloture(\Doctrine\ORM\QueryBuilder $qb){
		$qb = $qb->andWhere($qb->expr()->isNull('cloture.id'));
		return $qb;
	}
	
	private function whereNotAssigned(\Doctrine\ORM\QueryBuilder $qb){
		$qb = $qb->andWhere($qb->expr()->isNull('equipe.id'));
		return $qb;
	}
	
	private function whereAssigned(\Doctrine\ORM\QueryBuilder $qb){
		$qb = $qb->andWhere($qb->expr()->isNotNull('equipe.id'));
		return $qb;
	}
	
	private function whereNotPrinted(\Doctrine\ORM\QueryBuilder $qb){
		$qb = $qb->andWhere($qb->expr()->isNull('inter.printed'));
		return $qb;
	}
	
	private function wherePrinted(\Doctrine\ORM\QueryBuilder $qb){
		$qb = $qb->andWhere($qb->expr()->isNotNull('inter.printed'));
		return $qb;
	}
	
	private function whereAcknoledged(\Doctrine\ORM\QueryBuilder $qb){
		$qb = $qb->andWhere($qb->expr()->isNotNull('approbation.id'))
				->andWhere('inter.accEchReq = true OR inter.accDirReq = true');
		return $qb;
	}
	
	private function whereNotAcknoledged(\Doctrine\ORM\QueryBuilder $qb){
		$qb = $qb->andWhere($qb->expr()->isNull('approbation.id'))
				->andWhere('inter.accEchReq = true OR inter.accDirReq = true');
		return $qb;
	}
	
	public function whereDeleted(\Doctrine\ORM\QueryBuilder $qb){
		$qb->andWhere($qb->expr()->isNotNull('inter.deletedAt'));
		return $qb;
	}
	
	public function whereNotDeleted(\Doctrine\ORM\QueryBuilder $qb){
		$qb->andWhere($qb->expr()->isNull('inter.deletedAt'));
		return $qb;
	}
	
	/**
	*@param $toExclude string : valeur du ROLE à exclure de la recherche
	*@return array : tableau contenant les id des demandes que l'on doit exclure de la recherche
	*/
	private function toExclude($toExclude){
		$subquery = $this->createQueryBuilder('inter');
		$subquery->select('inter.id')
				->leftJoin('inter.approbations', 'approbation')
				->andWhere($subquery->expr()->like('approbation.roleApprobateur', ':exclus'))
				->setParameter('exclus', $toExclude)
				;
		$excluded = $subquery->getQuery()->getScalarResult();
		$nots = array_map('current', $excluded);
		return $nots;
	}
	
	public function whereDirecteur(\Doctrine\ORM\QueryBuilder $qb, $role){
		$qb->andWhere('approbation.roleApprobateur NOT LIKE :role OR approbation.id is null')
			->setParameter('role', $role);
		
		// $subquery = $this->createQueryBuilder('inter');
		// $subquery->select('inter.id')
				// ->leftJoin('inter.approbations', 'approbation')
				// ->andWhere($subquery->expr()->eq('inter.accEchReq', 'true'))
				// ->andWhere('approbation.roleApprobateur LIKE :exclus')
				// ->setParameter('exclus', $role)
				// ;
		// $nots = array_map('current', $subquery->getQuery()->getScalarResult());
		// $qb->andWhere('inter.accEchReq = true')
			// ->andWhere('approbation.roleApprobateur NOT LIKE :role OR approbation.id is null')
			// ->setParameter('role', "ROLE_ECHEVIN");
		// if( !empty($nots)){
			// $qb->andWhere($qb->expr()->notIn('inter.id', implode(',', $nots)));
		// }
		return $qb;
	}
	
	public function whereEchevin(\Doctrine\ORM\QueryBuilder $qb, $role){
		$subquery = $this->createQueryBuilder('inter');
		$subquery->select('inter.id')
				->leftJoin('inter.approbations', 'approbation')
				->andWhere($subquery->expr()->eq('inter.accDirReq', 'true'))
				->andWhere('approbation.roleApprobateur LIKE :exclus')
				->setParameter('exclus', $role)
				;
		$excluded = $subquery->getQuery()->getScalarResult();
		$nots = array_map('current', $excluded);
		$qb->andWhere('inter.accEchReq = true')
			->andWhere('approbation.roleApprobateur NOT LIKE :role OR approbation.id is null')
			->setParameter('role', "ROLE_DIRECTEUR");
		if( !empty($nots)){
			$qb->andWhere($qb->expr()->notIn('inter.id', implode(',',$nots)));
		}
		return $qb;
	}
	
	public function findByParameter($intervention){
		$qb = $this->createQueryBuilder('inter');
		$numero = $intervention['numero'];
		$objet = $intervention['objet'];
		$demandeur = $intervention['demandeur'];
		$cloture = $intervention['cloture'];
		$dateDebut = $intervention['lowerDate'];
		$dateFin = $intervention['upperDate'];
		if( !empty($numero)){
			$qb->andWhere('inter.numero = :id')
				->setParameter('id', $numero);
		}
		else{
			if( !empty($objet)){
				$objet = str_replace(' ', '%', $objet);
				$objet = "%".$objet."%";
				$qb->orWhere('inter.objet LIKE :objet')
				->setParameter('objet', $objet);
			}
			if( !empty($demandeur)){
				$qb->orWhere('inter.demandeur LIKE :demandeur')
				->setParameter('demandeur', "%".$demandeur."%");
			}
			if( $cloture == 0){
				$qb->andWhere($qb->expr()->isNull('inter.dateCloture'));
			}
			elseif( $cloture == 2 ){
				$qb->andWhere($qb->expr()->isNotNull('inter.dateCloture'));
			}
		}
		return $qb->getQuery()->getResult();
	}
	
	public function statInLi(){
		$qb = $this->createQueryBuilder('inter');
		$qb->select('lieu.nom as nom', 'count(inter.id) as total')
			->leftJoin('inter.lieu', 'lieu')
			->andWhere($qb->expr()->isNull('inter.deletedAt'))
			->andWhere($qb->expr()->isNull('lieu.deletedAt'))
			->groupBy('lieu.nom');
		return $qb->getQuery()->getResult();
	}
	
	public function statEqLi(){
		$qb = $this->_em->createQuery("SELECT lieu.nom as nomLieu, equipe.nom as nomEquipe, count(inter.id) as nbInterventions
										FROM MdyGstBundle:Intervention AS inter JOIN inter.lieu lieu
										JOIN inter.equipes equipe
										WHERE inter.deletedAt IS NULL
										AND lieu.deletedAt IS NULL
										AND equipe.deletedAt IS NULL
										GROUP BY lieu.id, equipe.id
										");
		return $qb->getResult();
	}
	
	public function getLastNumero(){
		$qb = $this->_em->createQuery("SELECT max(i.numero) as dernier FROM MdyGstBundle:Intervention as i");
		$dernier = $qb->getSingleResult();
		return $dernier['dernier']+1;
	}
}
