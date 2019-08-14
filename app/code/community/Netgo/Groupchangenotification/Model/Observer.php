<?php
class Netgo_Groupchangenotification_Model_Observer
{
    public function changeGroup(Varien_Event_Observer $observer){
        $customer = $observer->getEvent()->getCustomer();
		
		$status = Mage::getStoreConfig('groupchangenotification/groupchangenotification/gcnenable');
		if($status == 1){
        /* Code for old customer */
        if($customer->getId()){
			$template_id = 'group_change_template';
            if($customer->getOrigData('group_id')!= $customer->getData('group_id')){
                
                $groupname = Mage::getModel('customer/group')->load($customer->getData('group_id'))->getCustomerGroupCode();
                $name= $customer->getName();
						
            $to= $customer->getEmail();
			$customer_name   = $name;
			$email_template  = Mage::getModel('core/email_template')->loadDefault($template_id);
			$email_template_variables = array(
										'customer_name' => $customer_name,
										'groupname' => $groupname
										);
			$sender_name = Mage::getStoreConfig(Mage_Core_Model_Store::XML_PATH_STORE_STORE_NAME);
			$sender_email = Mage::getStoreConfig('trans_email/ident_general/email');
			$email_template->setSenderName($sender_name);
			$email_template->setSenderEmail($sender_email);
			
			$email_template->send($to, $customer_name, $email_template_variables);
			
        }else{

        }
    }
	}
	}
}