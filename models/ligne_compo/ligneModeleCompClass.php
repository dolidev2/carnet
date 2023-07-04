<?php

    class ligneModeleCompClass
    {
        private $id_mod_comp;
        private $modele;
        private $modele_comp;
        private $creat;
        private $mod;

        public function __construct($data)
        {
            $this->id_mod_comp = $data['id'];
            $this->modele = $data['modele'];
            $this->modele_comp = $data['modele_comp'];
            $this->creat_mod_comp = $data['creat'];
            $this->mod_comp = $data['mod'];
        }

        /**
         * @return mixed
         */
        public function getModele()
        {
            return $this->modele;
        }

        /**
         * @param mixed $modele
         */
        public function setModele($modele): void
        {
            $this->modele = $modele;
        }

        /**
         * @return mixed
         */
        public function getIdModComp()
        {
            return $this->id_mod_comp;
        }

        /**
         * @param mixed $id_mod_comp
         */
        public function setIdModComp($id_mod_comp): void
        {
            $this->id_mod_comp = $id_mod_comp;
        }

        /**
         * @return mixed
         */
        public function getModeleComp()
        {
            return $this->modele_comp;
        }

        /**
         * @param mixed $modele_comp
         */
        public function setModeleComp($modele_comp): void
        {
            $this->modele_comp = $modele_comp;
        }

        /**
         * @return mixed
         */
        public function getCreat()
        {
            return $this->creat;
        }

        /**
         * @param mixed $creat
         */
        public function setCreat($creat): void
        {
            $this->creat = $creat;
        }

        /**
         * @return mixed
         */
        public function getMod()
        {
            return $this->mod;
        }

        /**
         * @param mixed $mod
         */
        public function setMod($mod): void
        {
            $this->mod = $mod;
        }
    }