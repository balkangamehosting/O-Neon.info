#include amxmodx


#define PLUGIN "JailBreak Server menu"
#define VERSION "1.0"
#define AUTHOR ""

public plugin_init()

{
register_plugin(PLUGIN, VERSION, AUTHOR)
register_clcmd("chooseteam", "server_menu" )
}
public server_menu(id)
{

new i_Menu = menu_create("rWanteD JB w| rMeni", "MMENU" )
menu_additem(i_Menu, "wResetuj Skor", "1", 0)
menu_additem(i_Menu, "wProdavnica", "2", 0)
menu_additem(i_Menu, "wPromeni tim", "3", 0)
menu_additem(i_Menu, "wPmodmenu^n", "4", 0)
menu_additem(i_Menu, "yVIP Info", "5", 0)
menu_additem(i_Menu, "yPravila", "6", 0)
menu_additem(i_Menu, "yLista Servera^n", "7", 0)
menu_additem(i_Menu, "rVIP Menu", "8", 0)
menu_additem(i_Menu, "rSimon Menu^n", "9", 0)
menu_additem(i_Menu, "wIzadji", "0", 0)

menu_setprop(i_Menu, MPROP_PERPAGE, 0)
menu_display(id, i_Menu, 0)

return PLUGIN_HANDLED
}
public MMENU(id, menu, item)
{
if (item == MENU_EXIT)
{
menu_destroy(menu)

return PLUGIN_HANDLED
}
new s_Data[6], s_Name[64], i_Access, i_Callback

menu_item_getinfo(menu, item, i_Access, s_Data, charsmax(s_Data), s_Name, charsmax(s_Name), i_Callback)

new i_Key = str_to_num(s_Data)

switch(i_Key)
{

case 1:
{
client_cmd(id, "say /rs")
}
case 2:
{
client_cmd(id, "say /shop")
}
case 3:
{
client_cmd(id, "promenitim")
}
case 4:
{
client_cmd(id, "pmodmenu")
}
case 5:
{
client_cmd(id, "say /vip")
}
case 6:
{
client_cmd(id, "say /pomoc")
}
case 7:
{
client_cmd(id, "say /server")
}
case 8:
{
client_cmd(id, "say /vipmenu")
}
case 9:
{
client_cmd(id, "say /menu")
}
}

menu_destroy(menu)
return PLUGIN_HANDLED
}
                                    