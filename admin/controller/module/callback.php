<?php
class ControllerModuleCallback extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/callback');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting('callback', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		//dop_positions
		$this->data['text_header_top'] = $this->language->get('text_header_top');
		$this->data['text_header_top_left'] = $this->language->get('text_header_top_left');
		$this->data['text_header_top_right'] = $this->language->get('text_header_top_right');			
		$this->data['text_slider_top'] = $this->language->get('text_slider_top');
		$this->data['text_slider_left'] = $this->language->get('text_slider_left');
		$this->data['text_slider_right'] = $this->language->get('text_slider_right');
		$this->data['text_slider_content'] = $this->language->get('text_slider_content');
		$this->data['text_slider_content_left'] = $this->language->get('text_slider_content_left');
		$this->data['text_slider_content_right'] = $this->language->get('text_slider_content_right');						
		$this->data['text_footer_top'] = $this->language->get('text_footer_top');
		$this->data['text_footer_top_left'] = $this->language->get('text_footer_top_left');
		$this->data['text_footer_top_right'] = $this->language->get('text_footer_top_right');			
		$this->data['text_footer_bottom'] = $this->language->get('text_footer_bottom');
		$this->data['text_footer_bottom_left'] = $this->language->get('text_footer_bottom_left');
		$this->data['text_footer_bottom_right'] = $this->language->get('text_footer_bottom_right');
		//end_dop_positions
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/callback', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/callback', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['modules'] = array();
		
		if (isset($this->request->post['callback_module'])) {
			$this->data['modules'] = $this->request->post['callback_module'];
		} elseif ($this->config->get('callback_module')) { 
			$this->data['modules'] = $this->config->get('callback_module');
		}	
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/callback.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
				
		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/callback')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>