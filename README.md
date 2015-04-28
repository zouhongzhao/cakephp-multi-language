# cakephp-multi-language
动态切换多语言以及Auth用法

这是在cakephp开发中遇到的一些经典问题,做个备忘。

#主要功能

* 多语言切换 主要是改 $this->Session->write('Config.language', $lang),Configure::write('Config.language',$lang);
  view部分见/app/View/Elements/Common/nav.ctp
  php处理部分见app/Controller/DashboardController.php
  
* 控制器(app/Controller)里创建子目录(api)。声明的部分在app/Config/settings.php
  App::build(array('Controller' => array(ROOT.DS.'app/Controller/Api/')));
  
* 使用cakephp自带的功能强大的CakeEmail，以及view设置

* 使用Auth类验证登录


