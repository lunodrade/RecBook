<?php

//  define('SHOW_VARIABLES', 1);
//  define('DEBUG_LEVEL', 1);

//  error_reporting(E_ALL ^ E_NOTICE);
//  ini_set('display_errors', 'On');

set_include_path('.' . PATH_SEPARATOR . get_include_path());


include_once dirname(__FILE__) . '/' . 'components/utils/system_utils.php';

//  SystemUtils::DisableMagicQuotesRuntime();

SystemUtils::SetTimeZoneIfNeed('America/Argentina/Buenos_Aires');

function GetGlobalConnectionOptions()
{
    return array(
  'server' => 'localhost',
  'port' => '3306',
  'username' => 'root',
  'database' => 'recbooks'
);
}

function HasAdminPage()
{
    return false;
}

function GetPageGroups()
{
    $result = array('Default');
    return $result;
}

function GetPageInfos()
{
    $result = array();
    $result[] = array('caption' => 'Tabela Generos', 'short_caption' => 'Tabela Generos', 'filename' => 'generos.php', 'name' => 'tb_generos', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Tabela Likes', 'short_caption' => 'Tabela Likes', 'filename' => 'likes.php', 'name' => 'tb_likes', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Tabela Livros', 'short_caption' => 'Tabela Livros', 'filename' => 'livros.php', 'name' => 'tb_livros', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Tabela Tags', 'short_caption' => 'Tabela Tags', 'filename' => 'tags.php', 'name' => 'tb_tags', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Tabela Tagslivros', 'short_caption' => 'Tabela Tagslivros', 'filename' => 'tagslivros.php', 'name' => 'tb_tagslivros', 'group_name' => 'Default', 'add_separator' => false);
    $result[] = array('caption' => 'Tabela Usuarios', 'short_caption' => 'Tabela Usuarios', 'filename' => 'usuarios.php', 'name' => 'tb_usuarios', 'group_name' => 'Default', 'add_separator' => false);
    return $result;
}

function GetPagesHeader()
{
    return
    '';
}

function GetPagesFooter()
{
    return
        ''; 
    }

function ApplyCommonPageSettings(Page $page, Grid $grid)
{
    $page->SetShowUserAuthBar(false);
    $page->OnCustomHTMLHeader->AddListener('Global_CustomHTMLHeaderHandler');
    $page->OnGetCustomTemplate->AddListener('Global_GetCustomTemplateHandler');
    $grid->BeforeUpdateRecord->AddListener('Global_BeforeUpdateHandler');
    $grid->BeforeDeleteRecord->AddListener('Global_BeforeDeleteHandler');
    $grid->BeforeInsertRecord->AddListener('Global_BeforeInsertHandler');
}

/*
  Default code page: 1252
*/
function GetAnsiEncoding() { return 'windows-1252'; }

function Global_CustomHTMLHeaderHandler($page, &$customHtmlHeaderText)
{

}

function Global_GetCustomTemplateHandler($part, $mode, &$result, &$params, Page $page = null)
{

}

function Global_BeforeUpdateHandler($page, $rowData, &$cancel, &$message, $tableName)
{

}

function Global_BeforeDeleteHandler($page, $rowData, &$cancel, &$message, $tableName)
{

}

function Global_BeforeInsertHandler($page, $rowData, &$cancel, &$message, $tableName)
{

}

function GetDefaultDateFormat()
{
    return 'Y-m-d';
}

function GetFirstDayOfWeek()
{
    return 0;
}

function GetEnableLessFilesRunTimeCompilation()
{
    return false;
}



?>