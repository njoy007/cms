<?php

class Application_Form_BugReportForm extends Zend_Form
{

    public function init()
    {
    	// author textbox
    	$author = new Zend_Form_Element_Text('author');
    	$author->setLabel('Enter your name:')
    			->setRequired(true)
    			->setAttrib('size', 30);
    			
    	$email = new Zend_Form_Element_Text('email');
    	$email->setLabel('Your email address:')
    			->setRequired(true)
    			->addValidator('EmailAddress', true)
    			->addFilter('StringTrim')
    			//->addFilter('LowerCase')
    			->setAttrib('size', 40);
    	
    	$date = new Zend_Form_Element_Text('date');
    	$date->setLabel('Date the issue occured (mm-dd-yyyy): ')
    			->setRequired(true)
    			->addValidator(new Zend_Validate_Date('MM-DD-YYYY'))
    			->setAttrib('size', 20);

    	$url = new Zend_Form_Element_Text('url');
    	$url->setLabel('Issue URL:')
    		->setRequired(true)
    		->setAttrib('size', 50);
    		
    	$description = new Zend_Form_Element_Textarea('description');
    	$description->setLabel('Issue description:')
    				->setRequired(true)
    				->setAttrib('cols', 50)
    				->setAttrib('rows', 4);
    	
    	$priority = new Zend_Form_Element_Select('priority');
    	$priority->setLabel('Issue priority')
    			->setRequired(true)
    			->addMultiOptions(array(
    					'low' => 'Low',
    					'med' => 'Med',
    					'high' => 'High'
    					));
    					
    	$status = new Zend_Form_Element_Select('status');
    	$status->setLabel('Current status:')
    			->setRequired(true)
    			->addMultiOptions(array(
    					'new' => 'New',
    					'in progress' => 'In Progress',
    					'resolved' => 'Resolved'
    					));

    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel('Submit');
    	
    	$this->addElement($author)
    		->addElement($email)
    		->addElement($date)
    		->addElement($url)
    		->addElement($description)
    		->addElement($priority)
    		->addElement($status)
    		->addElement($submit);
    }


}

