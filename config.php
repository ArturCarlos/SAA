<?php

    /** caminho absoluto para a pasta do sistema **/
    if ( !defined('ABSPATH') )
        define('ABSPATH', dirname(__FILE__) . '/');

    /** caminho no server para o sistema **/
    if (!defined('BASEURL')){
        define('BASEURL', '/SAA/');
    }

    /** O nome do banco de dados */ 
    define('DB_NAME', 'db_saa');

    /** Usuário do banco de dados MySQL */ 
    define('DB_USER', 'root');

    /** Senha do banco de dados MySQL */ 
    define('DB_PASSWORD', '');

    /** nome do host do MySQL */ 
    define('DB_HOST', 'localhost');


    /** caminhos dos alertas de operacoes**/
    define('ALERT_MSG', ABSPATH . 'inc/alert.php');

    /** caminhos dos templates de header do usuário administrador**/
    define('HEADER_TEMPLATE', ABSPATH . 'inc/header_administrador.php');

    /** caminhos dos templates de header do usuário operador**/
    define('HEADER_TEMPLATE_OPERACIONAL', ABSPATH . 'inc/header_operacional.php');
    
    /** caminhos dos templates de header do usuário comum**/
    define('HEADER_TEMPLATE_PUBLIC', ABSPATH . 'inc/header_public.php');

    /** caminhos dos templates de footer dos usuário**/
    define('FOOTER_TEMPLATE', ABSPATH . 'inc/footer.php');

    /** caminho do arquivo de banco de dados **/	
    if ( !defined('DBAPI') )		
        define('DBAPI', ABSPATH . 'inc/database.php');
    
    /** caminho para as funções do usuário **/
    if ( !defined('LOGIN') )		
        define('LOGIN', ABSPATH . 'model/login/funcoes.php');
    
    /** caminho para as funções do usuário **/
    if ( !defined('USUARIO') )		
        define('USUARIO', ABSPATH . 'model/usuario/funcoes.php');
    
    /** caminho para as funções do patrimônio **/
    if ( !defined('PATRIMONIO') )		
        define('PATRIMONIO', ABSPATH . 'model/patrimonio/funcoes.php');
    
    /** caminho para as funções do setor **/
    if ( !defined('SETOR') )		
        define('SETOR', ABSPATH . 'model/setor/funcoes.php');
    
    /** caminho para as funções do local **/
    if ( !defined('LOCAL') )		
        define('LOCAL', ABSPATH . 'model/local/funcoes.php');
