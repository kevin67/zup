<?php
class Right
{
    // Attributs
    private $_id;
    private $_label;
    private $_panelAdmin;
	private $_requestManager;
    private $_dataExaminer;
    private $_recruitmentManager;
	private $_rightsManager;
    
    public function __construct(array $data)
    { 
        $this->_id = $data['id'];
        $this->_label = $data['label']; 
        $this->_panelAdmin 			= ($data['panelAdmin']			== 1);
        $this->_requestManager 		= ($data['requestManager']		== 1);
        $this->_dataExaminer 		= ($data['dataExaminer']		== 1);
        $this->_recruitmentManager 	= ($data['recruitmentManager']	== 1);
        $this->_rightsManager 		= ($data['rightsManager']		== 1);
    }

    // Méthodes de lecture
    public function getId()
    { 
        return $this->_id; 
    } 

    public function getLabel()
    { 
        return $this->_label; 
    } 

    public function getPanelAdmin()
    { 
        return $this->_panelAdmin; 
    }
	
    public function getRequestManager()
    { 
        return $this->_requestManager; 
    } 

    public function getDataExaminer()
    { 
        return $this->_dataExaminer; 
    } 

    public function getRecruitmentManager()
    { 
        return $this->_recruitmentManager; 
    }

    public function getRightsManager()
    { 
        return $this->_rightsManager; 
    }
}
?>