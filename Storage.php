<?php
/**
 * Created by PhpStorm.
 * User: chapin
 * Date: 11/3/16
 * Time: 6:49 PM
 */

namespace Awesome;

require_once 'Config.php';

use Awesome\Config;

class Storage
{

	private $useLocalDb;


	/**
	 * Storage constructor.
	 * @param string $config
	 */
	public function __construct($config = '')
	{
		$this->useLocalDb = true;
		$this->db = new \mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);

	}

	/**
	 * @param string $query
	 * @param array $params
	 * @param array $types
	 * @return bool
	 */
	public function prepare($query, $params, $types)
	{
		if ($this->useLocalDb)
		{
			$this->stmt = $this->db->prepare($query);
			$this->stmt->bind_param(implode('', $types), implode(',', $params));
			return true;
		}


		$valueCollection = new ValueTypeCollection;
		for ($i = 0; $i < count($params); $i++)
		{

			if ($types[$i] == 's')
			{
				$valueType = new ValueString($params[$i]);
			}
			elseif ($types[$i] == 'i')
			{
				$valueType = new ValueInt($params[$i]);
			}
			$valueCollection->addItem($valueType);
		}
		$this->params = $params;
		$this->stmt = $this->db->prepare($query, $valueCollection);
		return true;
	}


	public function execute()
	{
		if ($this->useLocalDb)
		{
			$this->stmt->execute();
			return $this->stmt->get_result();
		}

		$result =  $this->stmt->exec(implode(",", $this->params));
		if ($result->numrows > 0)
		{
			return $result->getlist();
		}
	}


	public function load($id)
	{
		$query = "SELECT * FROM MailManagerRecipient WHERE userId = ?";
		$stmt = $this->db->prepare($query);
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_assoc();
	}

	public function loadRoom() {
		$query = "SELECT title, top, bottom, `left`, `right` FROM rooms";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		$stmt->bind_result($title, $top, $bottom, $left, $right);
		$stmt->fetch();
		return ['title' => $title, 'top' => $top, 'bottom' => $bottom, 'left' => $left, 'right' => $right];
	}

	public function save(Recipient $r)
	{

		$sql = "INSERT MailManagerRecipient (
			UserId, firstName, lastName, email, country, currency, timezone, isFoundry,
			isAffiliate, isMLSSubscriber, value,
					CreativeCharacters, InYourFace, RisingStars, Newsletters, Trending)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
				ON DUPLICATE KEY UPDATE country=?, currency=?, firstName=?,
					lastName=?, email=?, timezone=?, isFoundry=?, isAffiliate=?, isMLSSubscriber=?, value=?,
					CreativeCharacters=?, InYourFace=?, RisingStars=?, Newsletters=?, Trending=?";
		$stmt = $this->db->prepare($sql);

		$stmt->bind_param('issssssiiidiiisissssssiiidiiisi',
				$r->userId, $r->firstName, $r->lastName, $r->email, $r->country, $r->currency,
				$r->timezone, $r->isFoundry, $r->isAffiliate, $r->isMLSSubscriber, $r->value->value,
				$r->CreativeCharacters, $r->InYourFace, $r->RisingStars,
				$r->Newsletters, $r->Trending,

				$r->country, $r->currency, $r->firstName, $r->lastName, $r->email,
				$r->timezone, $r->isFoundry, $r->isAffiliate, $r->isMLSSubscriber, $r->value->value,
				$r->CreativeCharacters, $r->InYourFace, $r->RisingStars,
				$r->Newsletters, $r->Trending
		);
		return $stmt->execute();
	}


}