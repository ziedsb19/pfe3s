<?php

namespace DashBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tpwsystem
 *
 * @ORM\Table(name="tpwsystem")
 * @ORM\Entity
 */
class Tpwsystem
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="AvCpu", type="integer", nullable=true)
     */
    private $avcpu;

    /**
     * @var integer
     *
     * @ORM\Column(name="DvCpu", type="integer", nullable=true)
     */
    private $dvcpu;

    /**
     * @var string
     *
     * @ORM\Column(name="LrcId", type="string", length=255, nullable=true)
     */
    private $lrcid;

    /**
     * @var string
     *
     * @ORM\Column(name="LrrId", type="string", length=255, nullable=true)
     */
    private $lrrid;

    /**
     * @var integer
     *
     * @ORM\Column(name="MemBuffers", type="integer", nullable=true)
     */
    private $membuffers;

    /**
     * @var integer
     *
     * @ORM\Column(name="MemCached", type="integer", nullable=true)
     */
    private $memcached;

    /**
     * @var integer
     *
     * @ORM\Column(name="MemFree", type="integer", nullable=true)
     */
    private $memfree;

    /**
     * @var integer
     *
     * @ORM\Column(name="MemTotal", type="integer", nullable=true)
     */
    private $memtotal;

    /**
     * @var integer
     *
     * @ORM\Column(name="MemUsed", type="integer", nullable=true)
     */
    private $memused;

    /**
     * @var integer
     *
     * @ORM\Column(name="MemUsedBC", type="integer", nullable=true)
     */
    private $memusedbc;

    /**
     * @var integer
     *
     * @ORM\Column(name="MxCpu", type="integer", nullable=true)
     */
    private $mxcpu;

    /**
     * @var integer
     *
     * @ORM\Column(name="RamDirUsed", type="integer", nullable=true)
     */
    private $ramdirused;

    /**
     * @var string
     *
     * @ORM\Column(name="Uptimesys", type="string", length=255, nullable=true)
     */
    private $uptimesys;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set avcpu
     *
     * @param integer $avcpu
     *
     * @return Tpwsystem
     */
    public function setAvcpu($avcpu)
    {
        $this->avcpu = $avcpu;

        return $this;
    }

    /**
     * Get avcpu
     *
     * @return integer
     */
    public function getAvcpu()
    {
        return $this->avcpu;
    }

    /**
     * Set dvcpu
     *
     * @param integer $dvcpu
     *
     * @return Tpwsystem
     */
    public function setDvcpu($dvcpu)
    {
        $this->dvcpu = $dvcpu;

        return $this;
    }

    /**
     * Get dvcpu
     *
     * @return integer
     */
    public function getDvcpu()
    {
        return $this->dvcpu;
    }

    /**
     * Set lrcid
     *
     * @param string $lrcid
     *
     * @return Tpwsystem
     */
    public function setLrcid($lrcid)
    {
        $this->lrcid = $lrcid;

        return $this;
    }

    /**
     * Get lrcid
     *
     * @return string
     */
    public function getLrcid()
    {
        return $this->lrcid;
    }

    /**
     * Set lrrid
     *
     * @param string $lrrid
     *
     * @return Tpwsystem
     */
    public function setLrrid($lrrid)
    {
        $this->lrrid = $lrrid;

        return $this;
    }

    /**
     * Get lrrid
     *
     * @return string
     */
    public function getLrrid()
    {
        return $this->lrrid;
    }

    /**
     * Set membuffers
     *
     * @param integer $membuffers
     *
     * @return Tpwsystem
     */
    public function setMembuffers($membuffers)
    {
        $this->membuffers = $membuffers;

        return $this;
    }

    /**
     * Get membuffers
     *
     * @return integer
     */
    public function getMembuffers()
    {
        return $this->membuffers;
    }

    /**
     * Set memcached
     *
     * @param integer $memcached
     *
     * @return Tpwsystem
     */
    public function setMemcached($memcached)
    {
        $this->memcached = $memcached;

        return $this;
    }

    /**
     * Get memcached
     *
     * @return integer
     */
    public function getMemcached()
    {
        return $this->memcached;
    }

    /**
     * Set memfree
     *
     * @param integer $memfree
     *
     * @return Tpwsystem
     */
    public function setMemfree($memfree)
    {
        $this->memfree = $memfree;

        return $this;
    }

    /**
     * Get memfree
     *
     * @return integer
     */
    public function getMemfree()
    {
        return $this->memfree;
    }

    /**
     * Set memtotal
     *
     * @param integer $memtotal
     *
     * @return Tpwsystem
     */
    public function setMemtotal($memtotal)
    {
        $this->memtotal = $memtotal;

        return $this;
    }

    /**
     * Get memtotal
     *
     * @return integer
     */
    public function getMemtotal()
    {
        return $this->memtotal;
    }

    /**
     * Set memused
     *
     * @param integer $memused
     *
     * @return Tpwsystem
     */
    public function setMemused($memused)
    {
        $this->memused = $memused;

        return $this;
    }

    /**
     * Get memused
     *
     * @return integer
     */
    public function getMemused()
    {
        return $this->memused;
    }

    /**
     * Set memusedbc
     *
     * @param integer $memusedbc
     *
     * @return Tpwsystem
     */
    public function setMemusedbc($memusedbc)
    {
        $this->memusedbc = $memusedbc;

        return $this;
    }

    /**
     * Get memusedbc
     *
     * @return integer
     */
    public function getMemusedbc()
    {
        return $this->memusedbc;
    }

    /**
     * Set mxcpu
     *
     * @param integer $mxcpu
     *
     * @return Tpwsystem
     */
    public function setMxcpu($mxcpu)
    {
        $this->mxcpu = $mxcpu;

        return $this;
    }

    /**
     * Get mxcpu
     *
     * @return integer
     */
    public function getMxcpu()
    {
        return $this->mxcpu;
    }

    /**
     * Set ramdirused
     *
     * @param integer $ramdirused
     *
     * @return Tpwsystem
     */
    public function setRamdirused($ramdirused)
    {
        $this->ramdirused = $ramdirused;

        return $this;
    }

    /**
     * Get ramdirused
     *
     * @return integer
     */
    public function getRamdirused()
    {
        return $this->ramdirused;
    }

    /**
     * Set uptimesys
     *
     * @param string $uptimesys
     *
     * @return Tpwsystem
     */
    public function setUptimesys($uptimesys)
    {
        $this->uptimesys = $uptimesys;

        return $this;
    }

    /**
     * Get uptimesys
     *
     * @return string
     */
    public function getUptimesys()
    {
        return $this->uptimesys;
    }
}
