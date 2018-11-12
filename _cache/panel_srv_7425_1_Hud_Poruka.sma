#include <amxmodx>

#define PLUGIN    "Datum i vreme"
#define VERSION    "1.0"
#define AUTHOR    "BraT^SteLe"
#define EDITOR "BraT^SteLe"

#define UPDATE_RATE 1.0

new admin_num = 0;
new broj_vipova = 0;
new nextmap[32]

public plugin_init() {
	register_plugin(PLUGIN, VERSION, AUTHOR);
	set_task(UPDATE_RATE,"UpdateTime",_,_,_,"b");
	set_task(20.0,"proveri_admine",_,_,_,"b");
	set_task(20.0,"proveri_vipove",_,_,_,"b");
}

public UpdateTime(){
	new Time[54];
	get_time("Datum:%d/%m/%Y^nVreme:%H:%M:%S",Time,53);
	get_cvar_string("amx_nextmap",nextmap,31) 
	new szMapName[34]
	get_mapname(szMapName, charsmax(szMapName));
	set_hudmessage(0, 155, 225, 0.80, 0.05, 0, 1.0, 1.5, 0.0, 0.0, 2);
	show_hudmessage(0, "^nHawaii DeatHRuN^n54.36.35.29:27080^n--------------------^n%s^n--------------------^nOnline Admini: %d^nOnline Vipovi: %d^n--------------------^nTrenutna Mapa - [%s]^nSledeca Mapa - [%s]^n--------------------^n-Hawaii DeatHRun-^nMod Editor : Domagoj & BraT^SteLe", Time, admin_num,broj_vipova,szMapName,nextmap);
}

public proveri_admine(id) {
	broj_vipova = 0;
	new igraci[32], broj_igraca;
	get_players(igraci,broj_igraca,"c");
	for(new i = 0; i <= broj_igraca; i++) {
		new id = igraci[i];
		if(!is_user_connected(id)) continue;
		if(get_user_flags(id) & ADMIN_LEVEL_H)
			broj_vipova++;
}
}




public proveri_vipove(id) {
	admin_num = 0;
	new igraci[32], broj_igraca;
	get_players(igraci,broj_igraca,"c");
	for(new i = 0; i <= broj_igraca; i++) {
		new id = igraci[i];
		if(!is_user_connected(id)) continue;
		if(get_user_flags(id) & ADMIN_KICK)
			admin_num++;
}
}

                                    