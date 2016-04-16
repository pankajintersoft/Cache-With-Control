# Cache-With-Control
'Cache With Control' a Joomla Plugin to control cache

Cache With Control plugin for very usefull for developers and for others as well. Its some time required that we do not want any particular page or component to be cached. Default joomla do not provide the functionality to disable cache for any particular page or component or view of a component.

This Jommla Plugin is a combination of default joomla cache plugin plus cache control plugin. By installing this plugin you can get both of functionality (cache and specify pages those need not to be cached). Separate cache control plugin is not capable of restrict page caching in joomla. Using Cache With Control Plugin you can also tell joomla about pages or component or views that need not be cached on the website...

Basic requirement for this plugin is that, Default cache plugin will need to be disabled for installing Cache With Control Plugin.

This plugin disable cache of specific pages or component or views as cache control plugin done. Along with this, Its also disable joomla page  cache of specific pages or component or views, which is not done by cache control plugin.

Adding rules for disable cache for specific pages or component or views is very easy.

1. option=com_content
2. option=com_content&view=article
3. option=com_content&view=article&id=1

1. First rule will disable cache for component com_content.
2. Second rule will disable cache for view article of component com_content.
3. Third rule will disable cache for joomla article which having id=1

You can write as many rules as you want separated by new line.

#cache, 
#cache control,
#cache plugin, 
#cache with control, 
#disable cache, 
#joomla cache, 
#no cache, 
#page cache, 
#paging cache, 
#restrict page cache, 
#stop page cache
