# upc-may-2016
Curso ZF UPC Mayo 2016


# Modificaciones en http.conf

 Tipicamente en /Some/path/zend/apache/conf/httpd.conf
 
1. Document Root
	DocumentRoot "C:\www"

2. Directivas de directorio para document root

<code>	
	<Directory "C:\www">
    #
    # Possible values for the Options directive are "None", "All",
    # or any combination of:
    #   Indexes Includes FollowSymLinks SymLinksifOwnerMatch ExecCGI MultiViews
    #
    # Note that "MultiViews" must be named *explicitly* --- "Options All"
    # doesn't give it to you.
    #
    # The Options directive is both complicated and important.  Please see
    # http://httpd.apache.org/docs/2.2/mod/core.html#options
    # for more information.
    #
    Options Indexes FollowSymLinks
    #
    # AllowOverride controls what directives may be placed in .htaccess files.
    # It can be "All", "None", or any combination of the keywords:
    #   Options FileInfo AuthConfig Limit
    #
    AllowOverride All
    #
    # Controls who can get stuff from this server.
    #
    Order allow,deny
    Allow from all
	</Directory>
</code>
 
 
# Configuracion del VirtualHost

<code>

	<VirtualHost *:80>
	    ServerAdmin agustincl@gmail.com
	    DocumentRoot "C:\www\proyecto1\public"
	    ServerName proyecto1.local
	    ErrorLog "C:\Program Files\Zend\Apache2\logs/proyecto1.local-error_log"
	    CustomLog "C:\Program Files\Zend\Apache2\logs/proyecto1.local-access_log" common
		<Directory "C:\www\proyecto1\public">
	    		Options Indexes FollowSymLinks
	    		AllowOverride All
	    		Order allow,deny
	    		Allow from all
		</Directory>
	</VirtualHost>

</code>

