<?php
/** Adminer - Compact database management
* @link https://www.adminer.org/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
* @version 5.0.1
*/namespace
Adminer;$ia="5.0.1";error_reporting(6135);set_error_handler(function($Hc,$Jc){return!!preg_match('~^(Trying to access array offset on( value of type)? null|Undefined (array key|property))~',$Jc);},E_WARNING);$ed=!preg_match('~^(unsafe_raw)?$~',ini_get("filter.default"));if($ed||ini_get("filter.default_flags")){foreach(array('_GET','_POST','_COOKIE','_SERVER')as$X){$Ni=filter_input_array(constant("INPUT$X"),FILTER_UNSAFE_RAW);if($Ni)$$X=$Ni;}}if(function_exists("mb_internal_encoding"))mb_internal_encoding("8bit");function
connection(){global$f;return$f;}function
adminer(){global$b;return$b;}function
version(){global$ia;return$ia;}function
idf_unescape($v){if(!preg_match('~^[`\'"[]~',$v))return$v;$te=substr($v,-1);return
str_replace($te.$te,$te,substr($v,1,-1));}function
escape_string($X){return
substr(q($X),1,-1);}function
number($X){return
preg_replace('~[^0-9]+~','',$X);}function
number_type(){return'((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';}function
remove_slashes($vg,$ed=false){if(function_exists("get_magic_quotes_gpc")&&get_magic_quotes_gpc()){while(list($y,$X)=each($vg)){foreach($X
as$le=>$W){unset($vg[$y][$le]);if(is_array($W)){$vg[$y][stripslashes($le)]=$W;$vg[]=&$vg[$y][stripslashes($le)];}else$vg[$y][stripslashes($le)]=($ed?$W:stripslashes($W));}}}}function
bracket_escape($v,$Na=false){static$xi=array(':'=>':1',']'=>':2','['=>':3','"'=>':4');return
strtr($v,($Na?array_flip($xi):$xi));}function
min_version($ej,$Ge="",$g=null){global$f;if(!$g)$g=$f;$ph=$g->server_info;if($Ge&&preg_match('~([\d.]+)-MariaDB~',$ph,$A)){$ph=$A[1];$ej=$Ge;}return$ej&&version_compare($ph,$ej)>=0;}function
charset($f){return(min_version("5.5.3",0,$f)?"utf8mb4":"utf8");}function
script($Ah,$wi="\n"){return"<script".nonce().">$Ah</script>$wi";}function
script_src($Si){return"<script src='".h($Si)."'".nonce()."></script>\n";}function
nonce(){return' nonce="'.get_nonce().'"';}function
target_blank(){return' target="_blank" rel="noreferrer noopener"';}function
h($P){return
str_replace("\0","&#0;",htmlspecialchars($P,ENT_QUOTES,'utf-8'));}function
nl_br($P){return
str_replace("\n","<br>",$P);}function
checkbox($B,$Y,$hb,$qe="",$xf="",$lb="",$re=""){$I="<input type='checkbox' name='$B' value='".h($Y)."'".($hb?" checked":"").($re?" aria-labelledby='$re'":"").">".($xf?script("qsl('input').onclick = function () { $xf };",""):"");return($qe!=""||$lb?"<label".($lb?" class='$lb'":"").">$I".h($qe)."</label>":$I);}function
optionlist($Cf,$hh=null,$Wi=false){$I="";foreach($Cf
as$le=>$W){$Df=array($le=>$W);if(is_array($W)){$I.='<optgroup label="'.h($le).'">';$Df=$W;}foreach($Df
as$y=>$X)$I.='<option'.($Wi||is_string($y)?' value="'.h($y).'"':'').($hh!==null&&($Wi||is_string($y)?(string)$y:$X)===$hh?' selected':'').'>'.h($X);if(is_array($W))$I.='</optgroup>';}return$I;}function
html_select($B,$Cf,$Y="",$wf=true,$re=""){if($wf)return"<select name='".h($B)."'".($re?" aria-labelledby='$re'":"").">".optionlist($Cf,$Y)."</select>".(is_string($wf)?script("qsl('select').onchange = function () { $wf };",""):"");$I="";foreach($Cf
as$y=>$X)$I.="<label><input type='radio' name='".h($B)."' value='".h($y)."'".($y==$Y?" checked":"").">".h($X)."</label>";return$I;}function
confirm($Re="",$ih="qsl('input')"){return
script("$ih.onclick = function () { return confirm('".($Re?js_escape($Re):'ä½ ç¢ºå®šå—ï¼Ÿ')."'); };","");}function
print_fieldset($u,$ye,$hj=false){echo"<fieldset><legend>","<a href='#fieldset-$u'>$ye</a>",script("qsl('a').onclick = partial(toggle, 'fieldset-$u');",""),"</legend>","<div id='fieldset-$u'".($hj?"":" class='hidden'").">\n";}function
bold($Ua,$lb=""){return($Ua?" class='active $lb'":($lb?" class='$lb'":""));}function
js_escape($P){return
addcslashes($P,"\r\n'\\/");}function
ini_bool($Xd){$X=ini_get($Xd);return(preg_match('~^(on|true|yes)$~i',$X)||(int)$X);}function
sid(){static$I;if($I===null)$I=(SID&&!($_COOKIE&&ini_bool("session.use_cookies")));return$I;}function
set_password($dj,$M,$V,$E){$_SESSION["pwds"][$dj][$M][$V]=($_COOKIE["adminer_key"]&&is_string($E)?array(encrypt_string($E,$_COOKIE["adminer_key"])):$E);}function
get_password(){$I=get_session("pwds");if(is_array($I))$I=($_COOKIE["adminer_key"]?decrypt_string($I[0],$_COOKIE["adminer_key"]):false);return$I;}function
q($P){global$f;return$f->quote($P);}function
get_vals($G,$d=0){global$f;$I=array();$H=$f->query($G);if(is_object($H)){while($J=$H->fetch_row())$I[]=$J[$d];}return$I;}function
get_key_vals($G,$g=null,$sh=true){global$f;if(!is_object($g))$g=$f;$I=array();$H=$g->query($G);if(is_object($H)){while($J=$H->fetch_row()){if($sh)$I[$J[0]]=$J[1];else$I[]=$J[0];}}return$I;}function
get_rows($G,$g=null,$m="<p class='error'>"){global$f;$Ab=(is_object($g)?$g:$f);$I=array();$H=$Ab->query($G);if(is_object($H)){while($J=$H->fetch_assoc())$I[]=$J;}elseif(!$H&&!is_object($g)&&$m&&(defined('Adminer\PAGE_HEADER')||$m=="-- "))echo$m.error()."\n";return$I;}function
unique_array($J,$x){foreach($x
as$w){if(preg_match("~PRIMARY|UNIQUE~",$w["type"])){$I=array();foreach($w["columns"]as$y){if(!isset($J[$y]))continue
2;$I[$y]=$J[$y];}return$I;}}}function
escape_key($y){if(preg_match('(^([\w(]+)('.str_replace("_",".*",preg_quote(idf_escape("_"))).')([ \w)]+)$)',$y,$A))return$A[1].idf_escape(idf_unescape($A[2])).$A[3];return
idf_escape($y);}function
where($Z,$o=array()){global$f;$I=array();foreach((array)$Z["where"]as$y=>$X){$y=bracket_escape($y,1);$d=escape_key($y);$I[]=$d.(JUSH=="sql"&&$o[$y]["type"]=="json"?" = CAST(".q($X)." AS JSON)":(JUSH=="sql"&&is_numeric($X)&&preg_match('~\.~',$X)?" LIKE ".q($X):(JUSH=="mssql"?" LIKE ".q(preg_replace('~[_%[]~','[\0]',$X)):" = ".unconvert_field($o[$y],q($X)))));if(JUSH=="sql"&&preg_match('~char|text~',$o[$y]["type"])&&preg_match("~[^ -@]~",$X))$I[]="$d = ".q($X)." COLLATE ".charset($f)."_bin";}foreach((array)$Z["null"]as$y)$I[]=escape_key($y)." IS NULL";return
implode(" AND ",$I);}function
where_check($X,$o=array()){parse_str($X,$eb);remove_slashes(array(&$eb));return
where($eb,$o);}function
where_link($t,$d,$Y,$zf="="){return"&where%5B$t%5D%5Bcol%5D=".urlencode($d)."&where%5B$t%5D%5Bop%5D=".urlencode(($Y!==null?$zf:"IS NULL"))."&where%5B$t%5D%5Bval%5D=".urlencode($Y);}function
convert_fields($e,$o,$L=array()){$I="";foreach($e
as$y=>$X){if($L&&!in_array(idf_escape($y),$L))continue;$Ga=convert_field($o[$y]);if($Ga)$I.=", $Ga AS ".idf_escape($y);}return$I;}function
cookie($B,$Y,$Ae=2592000){global$ba;return
header("Set-Cookie: $B=".urlencode($Y).($Ae?"; expires=".gmdate("D, d M Y H:i:s",time()+$Ae)." GMT":"")."; path=".preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]).($ba?"; secure":"")."; HttpOnly; SameSite=lax",false);}function
restart_session(){if(!ini_bool("session.use_cookies"))session_start();}function
stop_session($ld=false){$Vi=ini_bool("session.use_cookies");if(!$Vi||$ld){session_write_close();if($Vi&&@ini_set("session.use_cookies",false)===false)session_start();}}function&get_session($y){return$_SESSION[$y][DRIVER][SERVER][$_GET["username"]];}function
set_session($y,$X){$_SESSION[$y][DRIVER][SERVER][$_GET["username"]]=$X;}function
auth_url($dj,$M,$V,$j=null){global$mc;preg_match('~([^?]*)\??(.*)~',remove_from_uri(implode("|",array_keys($mc))."|username|".($j!==null?"db|":"").session_name()),$A);return"$A[1]?".(sid()?SID."&":"").($dj!="server"||$M!=""?urlencode($dj)."=".urlencode($M)."&":"")."username=".urlencode($V).($j!=""?"&db=".urlencode($j):"").($A[2]?"&$A[2]":"");}function
is_ajax(){return($_SERVER["HTTP_X_REQUESTED_WITH"]=="XMLHttpRequest");}function
redirect($Ce,$Re=null){if($Re!==null){restart_session();$_SESSION["messages"][preg_replace('~^[^?]*~','',($Ce!==null?$Ce:$_SERVER["REQUEST_URI"]))][]=$Re;}if($Ce!==null){if($Ce=="")$Ce=".";header("Location: $Ce");exit;}}function
query_redirect($G,$Ce,$Re,$Dg=true,$Oc=true,$Yc=false,$ki=""){global$f,$m,$b;if($Oc){$Jh=microtime(true);$Yc=!$f->query($G);$ki=format_time($Jh);}$Dh="";if($G)$Dh=$b->messageQuery($G,$ki,$Yc);if($Yc){$m=error().$Dh.script("messagesPrint();");return
false;}if($Dg)redirect($Ce,$Re.$Dh);return
true;}function
queries($G){global$f;static$zg=array();static$Jh;if(!$Jh)$Jh=microtime(true);if($G===null)return
array(implode("\n",$zg),format_time($Jh));$zg[]=(preg_match('~;$~',$G)?"DELIMITER ;;\n$G;\nDELIMITER ":$G).";";return$f->query($G);}function
apply_queries($G,$S,$Kc='Adminer\table'){foreach($S
as$Q){if(!queries("$G ".$Kc($Q)))return
false;}return
true;}function
queries_redirect($Ce,$Re,$Dg){list($zg,$ki)=queries(null);return
query_redirect($zg,$Ce,$Re,$Dg,false,!$Dg,$ki);}function
format_time($Jh){return
sprintf('%.3f ç§’',max(0,microtime(true)-$Jh));}function
relative_uri(){return
str_replace(":","%3a",preg_replace('~^[^?]*/([^?]*)~','\1',$_SERVER["REQUEST_URI"]));}function
remove_from_uri($Uf=""){return
substr(preg_replace("~(?<=[?&])($Uf".(SID?"":"|".session_name()).")=[^&]*&~",'',relative_uri()."&"),0,-1);}function
pagination($D,$Qb){return" ".($D==$Qb?$D+1:'<a href="'.h(remove_from_uri("page").($D?"&page=$D".($_GET["next"]?"&next=".urlencode($_GET["next"]):""):"")).'">'.($D+1)."</a>");}function
get_file($y,$Zb=false){$dd=$_FILES[$y];if(!$dd)return
null;foreach($dd
as$y=>$X)$dd[$y]=(array)$X;$I='';foreach($dd["error"]as$y=>$m){if($m)return$m;$B=$dd["name"][$y];$si=$dd["tmp_name"][$y];$Eb=file_get_contents($Zb&&preg_match('~\.gz$~',$B)?"compress.zlib://$si":$si);if($Zb){$Jh=substr($Eb,0,3);if(function_exists("iconv")&&preg_match("~^\xFE\xFF|^\xFF\xFE~",$Jh,$Jg))$Eb=iconv("utf-16","utf-8",$Eb);elseif($Jh=="\xEF\xBB\xBF")$Eb=substr($Eb,3);$I.=$Eb."\n\n";}else$I.=$Eb;}return$I;}function
upload_error($m){$Ne=($m==UPLOAD_ERR_INI_SIZE?ini_get("upload_max_filesize"):0);return($m?'ç„¡æ³•ä¸Šå‚³æª”æ¡ˆã€‚'.($Ne?" ".sprintf('å…è¨±çš„æª”æ¡ˆä¸Šé™å¤§å°ç‚º %sB',$Ne):""):'æª”æ¡ˆä¸å­˜åœ¨');}function
repeat_pattern($eg,$ze){return
str_repeat("$eg{0,65535}",$ze/65535)."$eg{0,".($ze%65535)."}";}function
is_utf8($X){return(preg_match('~~u',$X)&&!preg_match('~[\0-\x8\xB\xC\xE-\x1F]~',$X));}function
shorten_utf8($P,$ze=80,$Ph=""){if(!preg_match("(^(".repeat_pattern("[\t\r\n -\x{10FFFF}]",$ze).")($)?)u",$P,$A))preg_match("(^(".repeat_pattern("[\t\r\n -~]",$ze).")($)?)",$P,$A);return
h($A[1]).$Ph.(isset($A[2])?"":"<i>â€¦</i>");}function
format_number($X){return
strtr(number_format($X,0,".",','),preg_split('~~u','0123456789',-1,PREG_SPLIT_NO_EMPTY));}function
friendly_url($X){return
preg_replace('~\W~i','-',$X);}function
hidden_fields($vg,$Od=array(),$og=''){$I=false;foreach($vg
as$y=>$X){if(!in_array($y,$Od)){if(is_array($X))hidden_fields($X,array(),$y);else{$I=true;echo'<input type="hidden" name="'.h($og?$og."[$y]":$y).'" value="'.h($X).'">';}}}return$I;}function
hidden_fields_get(){echo(sid()?'<input type="hidden" name="'.session_name().'" value="'.h(session_id()).'">':''),(SERVER!==null?'<input type="hidden" name="'.DRIVER.'" value="'.h(SERVER).'">':""),'<input type="hidden" name="username" value="'.h($_GET["username"]).'">';}function
table_status1($Q,$Zc=false){$I=table_status($Q,$Zc);return($I?:array("Name"=>$Q));}function
column_foreign_keys($Q){global$b;$I=array();foreach($b->foreignKeys($Q)as$q){foreach($q["source"]as$X)$I[$X][]=$q;}return$I;}function
enum_input($U,$Ia,$n,$Y,$Bc=null){global$b;preg_match_all("~'((?:[^']|'')*)'~",$n["length"],$Ie);$I=($Bc!==null?"<label><input type='$U'$Ia value='$Bc'".((is_array($Y)?in_array($Bc,$Y):$Y===0)?" checked":"")."><i>".'ç©ºå€¼'."</i></label>":"");foreach($Ie[1]as$t=>$X){$X=stripcslashes(str_replace("''","'",$X));$hb=(is_int($Y)?$Y==$t+1:(is_array($Y)?in_array($t+1,$Y):$Y===$X));$I.=" <label><input type='$U'$Ia value='".(JUSH=="sql"?$t+1:h($X))."'".($hb?' checked':'').'>'.h($b->editVal($X,$n)).'</label>';}return$I;}function
input($n,$Y,$s){global$l,$b;$B=h(bracket_escape($n["field"]));echo"<td class='function'>";if(is_array($Y)&&!$s){$Ea=array($Y);if(version_compare(PHP_VERSION,5.4)>=0)$Ea[]=JSON_PRETTY_PRINT;$Y=call_user_func_array('json_encode',$Ea);$s="json";}$Ng=(JUSH=="mssql"&&$n["auto_increment"]);if($Ng&&!$_POST["save"])$s=null;$td=(isset($_GET["select"])||$Ng?array("orig"=>'åŸå§‹'):array())+$b->editFunctions($n);$ic=stripos($n["default"],"GENERATED ALWAYS AS ")===0?" disabled=''":"";$Ia=" name='fields[$B]'$ic";$Hi=$l->types();$Mh=$l->structuredTypes();if(in_array($n["type"],(array)$Mh['ä½¿ç”¨è€…é¡å‹'])){$Gc=type_values($Hi[$n["type"]]);if($Gc){$n["type"]="enum";$n["length"]=$Gc;}}if($n["type"]=="enum")echo
h($td[""])."<td>".$b->editInput($_GET["edit"],$n,$Ia,$Y);else{$Dd=(in_array($s,$td)||isset($td[$s]));echo(count($td)>1?"<select name='function[$B]'$ic>".optionlist($td,$s===null||$Dd?$s:"")."</select>".on_help("getTarget(event).value.replace(/^SQL\$/, '')",1).script("qsl('select').onchange = functionChange;",""):h(reset($td))).'<td>';$Zd=$b->editInput($_GET["edit"],$n,$Ia,$Y);if($Zd!="")echo$Zd;elseif(preg_match('~bool~',$n["type"]))echo"<input type='hidden'$Ia value='0'>"."<input type='checkbox'".(preg_match('~^(1|t|true|y|yes|on)$~i',$Y)?" checked='checked'":"")."$Ia value='1'>";elseif($n["type"]=="set"){preg_match_all("~'((?:[^']|'')*)'~",$n["length"],$Ie);foreach($Ie[1]as$t=>$X){$X=stripcslashes(str_replace("''","'",$X));$hb=(is_int($Y)?($Y>>$t)&1:in_array($X,explode(",",$Y),true));echo" <label><input type='checkbox' name='fields[$B][$t]' value='".(1<<$t)."'".($hb?' checked':'').">".h($b->editVal($X,$n)).'</label>';}}elseif(preg_match('~blob|bytea|raw|file~',$n["type"])&&ini_bool("file_uploads"))echo"<input type='file' name='fields-$B'>";elseif(($hi=preg_match('~text|lob|memo~i',$n["type"]))||preg_match("~\n~",$Y)){if($hi&&JUSH!="sqlite")$Ia.=" cols='50' rows='12'";else{$K=min(12,substr_count($Y,"\n")+1);$Ia.=" cols='30' rows='$K'".($K==1?" style='height: 1.2em;'":"");}echo"<textarea$Ia>".h($Y).'</textarea>';}elseif($s=="json"||preg_match('~^jsonb?$~',$n["type"]))echo"<textarea$Ia cols='50' rows='12' class='jush-js'>".h($Y).'</textarea>';else{$Pe=(!preg_match('~int~',$n["type"])&&preg_match('~^(\d+)(,(\d+))?$~',$n["length"],$A)?((preg_match("~binary~",$n["type"])?2:1)*$A[1]+($A[3]?1:0)+($A[2]&&!$n["unsigned"]?1:0)):($Hi[$n["type"]]?$Hi[$n["type"]]+($n["unsigned"]?0:1):0));if(JUSH=='sql'&&min_version(5.6)&&preg_match('~time~',$n["type"]))$Pe+=7;echo"<input".((!$Dd||$s==="")&&preg_match('~(?<!o)int(?!er)~',$n["type"])&&!preg_match('~\[\]~',$n["full_type"])?" type='number'":"")." value='".h($Y)."'".($Pe?" data-maxlength='$Pe'":"").(preg_match('~char|binary~',$n["type"])&&$Pe>20?" size='40'":"")."$Ia>";}echo$b->editHint($_GET["edit"],$n,$Y);$fd=0;foreach($td
as$y=>$X){if($y===""||!$X)break;$fd++;}if($fd)echo
script("mixin(qsl('td'), {onchange: partial(skipOriginal, $fd), oninput: function () { this.onchange(); }});");}}function
process_input($n){global$b,$l;if(stripos($n["default"],"GENERATED ALWAYS AS ")===0)return
null;$v=bracket_escape($n["field"]);$s=$_POST["function"][$v];$Y=$_POST["fields"][$v];if($n["type"]=="enum"){if($Y==-1)return
false;if($Y=="")return"NULL";return+$Y;}if($n["auto_increment"]&&$Y=="")return
null;if($s=="orig")return(preg_match('~^CURRENT_TIMESTAMP~i',$n["on_update"])?idf_escape($n["field"]):false);if($s=="NULL")return"NULL";if($n["type"]=="set")return
array_sum((array)$Y);if($s=="json"){$s="";$Y=json_decode($Y,true);if(!is_array($Y))return
false;return$Y;}if(preg_match('~blob|bytea|raw|file~',$n["type"])&&ini_bool("file_uploads")){$dd=get_file("fields-$v");if(!is_string($dd))return
false;return$l->quoteBinary($dd);}return$b->processInput($n,$Y,$s);}function
fields_from_edit(){global$l;$I=array();foreach((array)$_POST["field_keys"]as$y=>$X){if($X!=""){$X=bracket_escape($X);$_POST["function"][$X]=$_POST["field_funs"][$y];$_POST["fields"][$X]=$_POST["field_vals"][$y];}}foreach((array)$_POST["fields"]as$y=>$X){$B=bracket_escape($y,1);$I[$B]=array("field"=>$B,"privileges"=>array("insert"=>1,"update"=>1),"null"=>1,"auto_increment"=>($y==$l->primary),);}return$I;}function
search_tables(){global$b,$f;$_GET["where"][0]["val"]=$_POST["query"];$kh="<ul>\n";foreach(table_status('',true)as$Q=>$R){$B=$b->tableName($R);if(isset($R["Engine"])&&$B!=""&&(!$_POST["tables"]||in_array($Q,$_POST["tables"]))){$H=$f->query("SELECT".limit("1 FROM ".table($Q)," WHERE ".implode(" AND ",$b->selectSearchProcess(fields($Q),array())),1));if(!$H||$H->fetch_row()){$rg="<a href='".h(ME."select=".urlencode($Q)."&where[0][op]=".urlencode($_GET["where"][0]["op"])."&where[0][val]=".urlencode($_GET["where"][0]["val"]))."'>$B</a>";echo"$kh<li>".($H?$rg:"<p class='error'>$rg: ".error())."\n";$kh="";}}}echo($kh?"<p class='message'>".'æ²’æœ‰è³‡æ–™è¡¨ã€‚':"</ul>")."\n";}function
dump_headers($Ld,$Ye=false){global$b;$I=$b->dumpHeaders($Ld,$Ye);$Qf=$_POST["output"];if($Qf!="text")header("Content-Disposition: attachment; filename=".$b->dumpFilename($Ld).".$I".($Qf!="file"&&preg_match('~^[0-9a-z]+$~',$Qf)?".$Qf":""));session_write_close();ob_flush();flush();return$I;}function
dump_csv($J){foreach($J
as$y=>$X){if(preg_match('~["\n,;\t]|^0|\.\d*0$~',$X)||$X==="")$J[$y]='"'.str_replace('"','""',$X).'"';}echo
implode(($_POST["format"]=="csv"?",":($_POST["format"]=="tsv"?"\t":";")),$J)."\r\n";}function
apply_sql_function($s,$d){return($s?($s=="unixepoch"?"DATETIME($d, '$s')":($s=="count distinct"?"COUNT(DISTINCT ":strtoupper("$s("))."$d)"):$d);}function
get_temp_dir(){$I=ini_get("upload_tmp_dir");if(!$I){if(function_exists('sys_get_temp_dir'))$I=sys_get_temp_dir();else{$p=@tempnam("","");if(!$p)return
false;$I=dirname($p);unlink($p);}}return$I;}function
file_open_lock($p){$r=@fopen($p,"r+");if(!$r){$r=@fopen($p,"w");if(!$r)return;chmod($p,0660);}flock($r,LOCK_EX);return$r;}function
file_write_unlock($r,$Sb){rewind($r);fwrite($r,$Sb);ftruncate($r,strlen($Sb));flock($r,LOCK_UN);fclose($r);}function
password_file($h){$p=get_temp_dir()."/adminer.key";$I=@file_get_contents($p);if($I||!$h)return$I;$r=@fopen($p,"w");if($r){chmod($p,0660);$I=rand_string();fwrite($r,$I);fclose($r);}return$I;}function
rand_string(){return
md5(uniqid(mt_rand(),true));}function
select_value($X,$_,$n,$ji){global$b;if(is_array($X)){$I="";foreach($X
as$le=>$W)$I.="<tr>".($X!=array_values($X)?"<th>".h($le):"")."<td>".select_value($W,$_,$n,$ji);return"<table>$I</table>";}if(!$_)$_=$b->selectLink($X,$n);if($_===null){if(is_mail($X))$_="mailto:$X";if(is_url($X))$_=$X;}$I=$b->editVal($X,$n);if($I!==null){if(!is_utf8($I))$I="\0";elseif($ji!=""&&is_shortable($n))$I=shorten_utf8($I,max(0,+$ji));else$I=h($I);}return$b->selectVal($I,$_,$n,$X);}function
is_mail($zc){$Ha='[-a-z0-9!#$%&\'*+/=?^_`{|}~]';$lc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';$eg="$Ha+(\\.$Ha+)*@($lc?\\.)+$lc";return
is_string($zc)&&preg_match("(^$eg(,\\s*$eg)*\$)i",$zc);}function
is_url($P){$lc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';return
preg_match("~^(https?)://($lc?\\.)+$lc(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i",$P);}function
is_shortable($n){return
preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~',$n["type"]);}function
count_rows($Q,$Z,$fe,$xd){$G=" FROM ".table($Q).($Z?" WHERE ".implode(" AND ",$Z):"");return($fe&&(JUSH=="sql"||count($xd)==1)?"SELECT COUNT(DISTINCT ".implode(", ",$xd).")$G":"SELECT COUNT(*)".($fe?" FROM (SELECT 1$G GROUP BY ".implode(", ",$xd).") x":$G));}function
slow_query($G){global$b,$T,$l;$j=$b->database();$li=$b->queryTimeout();$yh=$l->slowQuery($G,$li);if(!$yh&&support("kill")&&is_object($g=connect($b->credentials()))&&($j==""||$g->select_db($j))){$oe=$g->result(connection_id());echo'<script',nonce(),'>
var timeout = setTimeout(function () {
	ajax(\'',js_escape(ME),'script=kill\', function () {
	}, \'kill=',$oe,'&token=',$T,'\');
}, ',1000*$li,');
</script>
';}else$g=null;ob_flush();flush();$I=@get_key_vals(($yh?:$G),$g,false);if($g){echo
script("clearTimeout(timeout);");ob_flush();flush();}return$I;}function
get_token(){$Bg=rand(1,1e6);return($Bg^$_SESSION["token"]).":$Bg";}function
verify_token(){list($T,$Bg)=explode(":",$_POST["token"]);return($Bg^$_SESSION["token"])==$T;}function
lzw_decompress($Ra){$hc=256;$Sa=8;$nb=array();$Pg=0;$Qg=0;for($t=0;$t<strlen($Ra);$t++){$Pg=($Pg<<8)+ord($Ra[$t]);$Qg+=8;if($Qg>=$Sa){$Qg-=$Sa;$nb[]=$Pg>>$Qg;$Pg&=(1<<$Qg)-1;$hc++;if($hc>>$Sa)$Sa++;}}$gc=range("\0","\xFF");$I="";foreach($nb
as$t=>$mb){$yc=$gc[$mb];if(!isset($yc))$yc=$sj.$sj[0];$I.=$yc;if($t)$gc[]=$sj.$yc[0];$sj=$yc;}return$I;}function
on_help($vb,$vh=0){return
script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $vb, $vh) }, onmouseout: helpMouseout});","");}function
edit_form($Q,$o,$J,$Qi){global$b,$T,$m;$Vh=$b->tableName(table_status1($Q,true));page_header(($Qi?'ç·¨è¼¯':'æ–°å¢'),$m,array("select"=>array($Q,$Vh)),$Vh);$b->editRowPrint($Q,$o,$J,$Qi);if($J===false){echo"<p class='error'>".'æ²’æœ‰è³‡æ–™è¡Œã€‚'."\n";return;}echo'<form action="" method="post" enctype="multipart/form-data" id="form">
';if(!$o)echo"<p class='error'>".'æ‚¨æ²’æœ‰è¨±å¯æ¬Šæ›´æ–°é€™å€‹è³‡æ–™è¡¨ã€‚'."\n";else{echo"<table class='layout'>".script("qsl('table').onkeydown = editingKeydown;");$fd=0;foreach($o
as$B=>$n){echo"<tr><th>".$b->fieldName($n);$k=$_GET["set"][bracket_escape($B)];if($k===null){$k=$n["default"];if($n["type"]=="bit"&&preg_match("~^b'([01]*)'\$~",$k,$Jg))$k=$Jg[1];}$Y=($J!==null?($J[$B]!=""&&JUSH=="sql"&&preg_match("~enum|set~",$n["type"])?(is_array($J[$B])?array_sum($J[$B]):+$J[$B]):(is_bool($J[$B])?+$J[$B]:$J[$B])):(!$Qi&&$n["auto_increment"]?"":(isset($_GET["select"])?false:$k)));if(!$_POST["save"]&&is_string($Y))$Y=$b->editVal($Y,$n);$s=($_POST["save"]?(string)$_POST["function"][$B]:($Qi&&preg_match('~^CURRENT_TIMESTAMP~i',$n["on_update"])?"now":($Y===false?null:($Y!==null?'':'NULL'))));if(!$_POST&&!$Qi&&$Y==$n["default"]&&preg_match('~^[\w.]+\(~',$Y))$s="SQL";if(preg_match("~time~",$n["type"])&&preg_match('~^CURRENT_TIMESTAMP~i',$Y)){$Y="";$s="now";}if($n["type"]=="uuid"&&$Y=="uuid()"){$Y="";$s="uuid";}if($n["auto_increment"]||$s=="now"||$s=="uuid")$fd++;input($n,$Y,$s);echo"\n";}if(!support("table"))echo"<tr>"."<th><input name='field_keys[]'>".script("qsl('input').oninput = fieldChange;")."<td class='function'>".html_select("field_funs[]",$b->editFunctions(array("null"=>isset($_GET["select"]))))."<td><input name='field_vals[]'>"."\n";echo"</table>\n";}echo"<p>\n";if($o){echo"<input type='submit' value='".'å„²å­˜'."'>\n";if(!isset($_GET["select"])){echo"<input type='submit' name='insert' value='".($Qi?'å„²å­˜ä¸¦ç¹¼çºŒç·¨è¼¯':'å„²å­˜ä¸¦æ–°å¢ä¸‹ä¸€ç­†')."' title='Ctrl+Shift+Enter'>\n",($Qi?script("qsl('input').onclick = function () { return !ajaxForm(this.form, '".'ä¿å­˜ä¸­'."â€¦', this); };"):"");}}echo($Qi?"<input type='submit' name='delete' value='".'åˆªé™¤'."'>".confirm()."\n":($_POST||!$o?"":script("focus(qsa('td', qs('#form'))[2*$fd+1].firstChild);")));if(isset($_GET["select"]))hidden_fields(array("check"=>(array)$_POST["check"],"clone"=>$_POST["clone"],"all"=>$_POST["all"]));echo'<input type="hidden" name="referer" value="',h(isset($_POST["referer"])?$_POST["referer"]:$_SERVER["HTTP_REFERER"]),'">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="',$T,'">
</form>
';}if(isset($_GET["file"])){if($_SERVER["HTTP_IF_MODIFIED_SINCE"]){header("HTTP/1.1 304 Not Modified");exit;}header("Expires: ".gmdate("D, d M Y H:i:s",time()+365*24*60*60)." GMT");header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");header("Cache-Control: immutable");if($_GET["file"]=="favicon.ico"){header("Content-Type: image/x-icon");echo
lzw_decompress("\0\0\0` \0„\0\n @\0´C„è\"\0`EãQ¸àÿ‡?ÀtvM'”JdÁd\\Œb0\0Ä\"™ÀfÓˆ¤îs5›ÏçÑAXPaJ“0„¥‘8„#RŠT©‘z`ˆ#.©ÇcíXÃşÈ€?À-\0¡Im? .«M¶€\0È¯(Ì‰ıÀ/(%Œ\0");}elseif($_GET["file"]=="default.css"){header("Content-Type: text/css; charset=utf-8");echo
lzw_decompress("\n1Ì‡“ÙŒŞl7œ‡B1„4vb0˜Ífs‘¼ên2BÌÑ±Ù˜Şn:‡#(¼b.\rDc)ÈÈa7E„‘¤Âl¦Ã±”èi1Ìs˜´ç-4™‡fÓ	ÈÎi7†º€´îi2\r£1¤è-ƒH²ÙôÃƒÂGF#aÔÊ;:Oó!–r0Ïãã£t~ßf':ñ”Éh„B¦'cÍ”Â:6T\rc£A¾zrcğXKŒg+—ÄZXk…Êév„ŞM7¸½Ôå‘7_Ì\"ëÏ)––öº{¾ª÷}Øã…Æ£©ÌĞ-4NÎ}:¨rf§K) b{H(Æ“Ñ”t1É)tÚ}F¦p0™•8è\\82›DŒ>®ÀN‡Cy·¾8\0æƒ«\0FÁê>¯ã(Ò3	\nú9)ƒ`vç-Ao\r¡èŠ&Šµ¨XËº¡“±»në¾ğ„¯œ¨*A\0`A„\0¡ˆq\0oCÔö=Ïƒäú\r¯²\\–¿#{öş¿ğÈŒ2©ÃR‡;0dBHL+¢H¢,Œ!oR”>œNíA°|\"¾KÉ¼í0‘Pb¼Jd^¨È‘”d²£Ğ ÷=<ª’Ê:J# Â¶£Ú®¬«aŠĞ‘‚¦>ÑTeòFìkÆjš#K6#‚9ÕET·Ë1K¼‘Å´ÀÈ+CİF×I°	(ÀğL|õÏjPø„pfúÓEuLQG­íØZ›ÁêˆØ2ŒÎ¥š2½!sk[:¢1¬kˆå½6%ŒYpkf+W[Ş·\rrˆL1ÈÌÔ\0ÒŒŠ8è=½c˜áT.€ÜØ-ìº~ –»#sOàávGö+İy¾O{ëJª9COÕî–×²|`‡+(áMÏr\r‘OÀ5\nÊ4£8÷‰(	¾-l‡Cj°2[r5yKÑyŸ)ƒÂ¬¬+AÔk¤äÍÉ¯¨2ëgß³3iÄ”ÂÜHS>–ÜWÆÖ<í®fá}ÚöÏjfMiBÏ¹ÕlöIC¼(Ë\\4ÊmÁ5¤4’H“%	PÚøR\"¿ñN‹g_şÌ#ƒê 8£§¹ñË:©N²w\$uùØİÔuJ=¶1àú)¡ã3Õ¤ôİ¿R-ƒÈà2‡¡ğõá»Ÿ¥¸…rª6³ôşH¾/p.£0Â:˜?^£\rHŞ;×¡Œo÷@0Ô9ïu!sF8£KFÃüî7Ôûó}èİı»g¾ÔVÚÅ_a½Ø>Èúßl@0ú@\\Ãy\räl=­µº‘ÊSGÁÌ•ãVTTZOu%üÀŞD˜Aƒapdµ‚\$YAq—0„|Ğ¥d6\rÓ™_N§x%jpÃšÉ\r\r±‚À\\_CTI‰|6FØiÀ…‘EdœàêCp{„†rƒ¨RAáZ`tKI€¬4€JºÈ>ˆe,‚¦Ék„ÁfD÷Ö^ƒq‰Åô;ÈÄÀdÒT‚Àá\"ä‰eÄ£…ĞœT8‘’DI#%\\ÚpB‰È>‚âZEC”=PĞ­ş›L¦R &ÉåyV)µ.J\$¿)Chee3¨Ôªˆ¢#\rÑªW7¹a&Ã3q(µ·*’º¢o.Œ‘´Ï,¥DNš3FÆæ<¼—ŠBEÎ›µ†Sé•3+ƒpŒC¥)/.3b{Ùí_›ø#OùJŠM “\nâÁWsn¤€ãÏÒ (A¸·o3HXF´Š‘Cˆ¸§‰v\rsX2ÅÓ’DŒ4‚‰º•RÊiLK ›q°2Mò0eQ„'„¶ « t\rÏ¥Ä]ŞBstiQ&©rè¾ÊäbõI®Ã‰ôO™â«M©¡pò^ZjŠEyµ•Õ_üŒÆR†ğà^ƒtIwEÙƒÖò¶K;¯Ñ™Ô†úçeî@£<•¶tQ‘pàˆ“ò{c%âo 4b0âª\rg°`äDråÊ„’jKÉ™JP!åƒGHñ®KÛfÖekzTÇ<Å˜Û^X[´©·-šİš#I)bjRÀÊS’˜c¡É¶ã•òJ71°æÄÃY{i2;©ÀÜk)!¬á¥\$ˆôÎòP8ˆQ j\rAa)¿ê'pS{U+<šgyˆĞZEK\$\0¢úí~ï½ùÂ\$ ‚ÉºFèë’©ş¥û´\0>¬;Qöôé\nTæ=ª…d²±‡—P +¬ƒ7ò«”¸.6®\$Ú)&e—’u•[ÒÕšÄ8!œ‹0xñ§BE»•â3(T\\K…vPÙƒÒåÜ5æ°yÈÜĞG0j´b„¹R3–Ü°áÔ’ O÷¼úæE\rlÊÌÌôÂal–TS+l9Æ%ÛÒódw™C;5KxÏôeË\0001éRÊóıyGARÈ’d`éƒˆV8ïE­.2°{7È3‡ÙÏQcÒúg@‚=0­V@µš–?ªwªõlÖÖe‡İ0Ï.=Óª3ekm<€Da¸kJoirÂ\\I6*+ÀùbÀd‘âî;óºø_/¦	ƒ>Êq—6Æ˜õzÁp6Î«p}9ÖZCÏAŠĞ†@Æª¾¹È:òM£Ü×»2´hËàçm¾}všÿo–Õ7íÎT2r,›p¤g¸>,FhåµŒu§âZÅÔŞåML¬nøy±åylY=ªu¸àŒ9Ò’™¶³ô@Û\$î²öhÕE–-ç\$W·xœ	V¡ˆ5•à[Ó/NK§csÓ’SN·WL¬…i%~€¨¹—ã¬yƒ\$yt®¡jrä÷ƒFB÷»rÇ]çÁ…dš9`hÃrèĞ½pœÜ_ÁÏf~*årß£™ogf3¶‚ßŠĞ5GŠÅñ4hªÑ\\Æ»aè•êü8AĞ6\0Ğ‰¹\n8¶èÒwcŸWëC„NöóUF{¯X²e9	÷Ş´N<¶üvO×²Rû¼u²2lèEO#×ßê½ø#Úë§ämÄhàSÿ˜Î,çÚ#˜ı¾Îü^Ûÿ€ço¬ò?H¾Ç’g/mïÁqè˜º÷X_àk¦¬Üš÷çN~¨0ƒH8ÿ£øÿéz„\"lĞõ­ĞX¯†@ÌĞ¯¤ƒïŞË°÷G¦ÄQ£Ö4jš/gÊ]`ú	‚=nø&ïZ&¢¢jk–\0pk\0RoòÀoøèOŞ”¬–ú/»ãT²o0ãèäÏP.ÍNì*0ˆbk­k	mŒûm²ìümfİ0˜»°œQP ØÏÔ=/Ø\r©mO¯\0oˆÿMpú¯ı\rD\r\nÌœÌLPàpÆßÎÀ÷\rĞ©0V&Ç&­³`ÎÂĞ–ŠæêN-öß°Ëî…\0I U*dÈq0+Iæfì~ài|”‰J8ƒŒ•BØCÊLsã€Úâ\r¨Ê*?±g‘cqg<8ÀZ/ÑoÀà\r\0àèq‚8ñ‡±c [`¿z8è£#cÑ«éTÁ}qŸ‘bñÃ€¾©hÂ„¦\0fo(¸‰èÑä	ïq…Çğ\rñ1ö ßÑy‘¿ ÊIQœU1õË<\r€¿!!c!¨I!ë>ñù!R+ ¦˜é’ÖQK‘¡!\n\0rìs Q¡ ¾Â›±‹%ƒ1#&æ.f²\"Ñ•ÒY2Qı%r[ÒB„’}\$Í&`Ô‘FBÒ?ñŠ}'ÊDÎ\"‹Š!Q@0¤.-\"(o)ãQ@Ï	‡ ã÷,ˆ¥ Bò’-ÒÍ-€Æ˜rÒ×\"R-RÏ.2Ó’ë%€ÙP†ò«*êC@Œ²O’Äè£-ó/ré,ò//Ø¤ó).Ó2Òù,òıÒõ1óS1é€'Hòšqœ\0Û!’Ä•K{5×5s[!£÷3-Òë/SB èº2¸c%Á)Óu2Rİ8²Ù!Ó‘(Rş˜çPF‹qXû“œºs£5ª\r`Ê1°`¿;FéÓ'“³;ræ8òE:³ x‘½£FgÉ62Á `¿!sÏ>“Ç*ê³óï(²ï)‹\"ã?²?óõ@J[(’y\"t àóíA²Û@ÒwAÔ!?”%9R Ú˜t1Ct'%À¿C´#D5@¢/\0Æ[t	³óB´R\"4YC(HÄÑá8 G@…GsÅùDTÍø&Q½D’+Hr(2\"ãBiT¡²ªÑeÔVtp Š\r`@,óâ#'T³Ï «¦º£(ºóç>Ô‰ RBëK4’0´İ(”/ñHÔéÃSEj[M1X0€Û:-QK+0Kk4 àÉ5¡D´Q4ãD?Rz,éwP„º”s‰ RÅQ³6•5.’O‘}Q•AF#DUEDR4U˜ã¢)¨˜ëN4i†„àP=\0€jPºun\nmH¥¸¿âÍJCŠ{ƒ 2C3X‹¾Iƒ60£Rp\0Bd¿U€Ü:B½+cŸV)„‡`İV§\$r.µv–eÓWÎdµ€15…Kfä\"Ê");}elseif($_GET["file"]=="functions.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("f:›ŒgCI¼Ü\n8œÅ3)°Ë7œ…†81ĞÊx:\nOg#)Ğêr7\n\"†è´`ø|2ÌgSi–H)N¦S‘ä§\r‡\"0¹Ä@ä)Ÿ`(\$s6O!ÓèœV/=Œ' T4æ=„˜iS˜6IO G#ÒX·VCÆs¡ Z1.Ğhp8,³[¦Häµ~Cz§Éå2¹l¾c3šÍés£‘ÙI†bâ4\néF8Tà†I˜İ©U*fz¹är0EÆÀØy¸ñfY.:æƒIŒÊ(Øc·áÎ‹!_l™í^·^(¶šN{S–“)rËqÁY“–lÙ¦3Š3Ú\n˜+G¥Óêyºí†Ëi¶ÂîxV3w³uhã^rØÀº´aÛ”ú¹cØè\r“¨ë(.ÂˆºChÒ<\r)èÑ£¡`æ7£íò43'm5Œ£È\nPÜ:2£P»ª‹q òÿÅC“}Ä«ˆúÊÁê38‹BØ0hR‰Èr(œ0¥¡b\\0ŒHr44ŒÁB!¡pÇ\$rZZË2Ü‰.Éƒ(\\5Ã|\nC(Î\"€P…ğø.ĞNÌRTÊÎ“Àæ>HN…8HPá\\¬7Jp~„Üû2%¡ĞOC¨1ã.ƒ§C8Î‡HÈò*ˆj°…á÷S(¹/¡ì¬6KUœÊ‡¡<2‰pOI„ôÕ`Ôäâ³ˆdOH Ş5-üÆ4ŒãpX25-Ò¢òÛˆ°z7£¸\"(°P \\32:]UÚèíâß…!]¸<·AÛÛ¤’ĞßiÚ°‹l\rÔ\0v²Î#J8«ÏwmíÉ¤¨<ŠÉ æü%m;p#ã`XDŒø÷iZøN0Œ•È9ø¨å Áè`…wJD¿¾2Ò9tŒ¢*øÎyìËNiIh\\9ÆÕèĞ:ƒ€æáxï­µyl*šÈˆÎæY Ü‡øê8’W³â?µŞ›3ÙğÊ!\"6å›n[¬Ê\r­*\$¶Æ§¾nzxÆ9\rì|*3×£pŞï»¶:(p\\;ÔËmz¢ü§9óĞÑÂŒü8N…Áj2½«Î\rÉHîH&Œ²(Ãz„Á7iÛk£ ‹Š¤‚c¤‹eòı§tœÌÌ2:SHóÈ Ã/)–xŞ@éåt‰ri9¥½õëœ8ÏÀËïyÒ·½°VÄ+^WÚ¦­¬kZæY—l·Ê£Œ4ÖÈÆ‹ª¶À¬‚ğ\\EÈ{î7\0¹p†€•D€„i”-TæşÚû0l°%=Á ĞËƒ9(„5ğ\n\n€n,4‡\0èa}Üƒ.°öRsï‚ª\02B\\Ûb1ŸS±\0003,ÔXPHJspåd“Kƒ CA!°2*WŸÔñÚ2\$ä+Âf^\n„1Œ´òzEƒ Iv¤\\äœ2É .*A°™”E(d±á°ÃbêÂÜ„Æ9‡‚â€ÁDh&­ª?ÄH°sQ˜2’x~nÃJ‹T2ù&ãàeRœ½™GÒQTwêİ‘»õPˆâã\\ )6¦ôâœÂòsh\\3¨\0R	À'\r+*;RğHà.“!Ñ[Í'~­%t< çpÜK#Â‘æ!ñlßÌğLeŒ³œÙ,ÄÀ®&á\$	Á½`”–CXš‰Ó†0Ö­å¼û³Ä:Méh	çÚœGäÑ!&3 D<!è23„Ã?h¤J©e Úğhá\r¡m•˜ğNi¸£´’†ÊNØHl7¡®v‚êWIå.´Á-Ó5Ö§ey\rEJ\ni*¼\$@ÚRU0,\$U¿E†¦ÔÔÂªu)@(tÎSJkáp!€~­‚àd`Ì>¯•\nÃ;#\rp9†jÉ¹Ü]&Nc(r€ˆ•TQUª½S·Ú\08n`«—y•b¤ÅLÜO5‚î,¤ò‘>‚†xââ±fä´’âØ+–\"ÑI€{kMÈ[\r%Æ[	¤eôaÔ1! èÿí³Ô®©F@«b)RŸ£72ˆî0¡\nW¨™±L²ÜœÒ®tdÕ+íÜ0wglø0n@òêÉ¢ÕiíM«ƒ\nA§M5nì\$E³×±NÛál©İŸ×ì%ª1 AÜûºú÷İkñrîiFB÷Ïùol,muNx-Í_ Ö¤C( fél\r1p[9x(i´BÒ–²ÛzQlüº8CÔ	´©XU Tb£İIİ`•p+V\0î‹Ñ;‹CbÎÀXñ+Ï’sïü]H÷Ò[ák‹x¬G*ô†]·awnú!Å6‚òâÛĞmSí¾“IŞÍKË~/Ó¥7ŞùeeNÉòªS«/;dåA†>}l~Ïê ¨%^´fçØ¢pÚœDEîÃa·‚t\nx=ÃkĞ„*dºêğT—ºüûj2ŸÉjœ\n‘ É ,˜e=‘†M84ôûÔa•j@îTÃsÔänf©İ\nî6ª\rdœ¼0ŞíôYŠ'%Ô“íŞ~	Ò¨†<ÖË–Aî‹–H¿G‚8ñ¿Îƒ\$z«ğ{¶»²u2*†àa–À>»(wŒK.bP‚{…ƒoı”Â´«zµ#ë2ö8=É8>ª¤³A,°e°À…+ìCè§xõ*ÃáÒ-b=m‡™Ÿ,‹a’Ãlzkï\$Wõ,mJiæÊ§á÷+‹èı0°[¯ÿ.RÊsKùÇäXçİZLËç2`Ì(ïCàvZ¡ÜİÀ¶è\$×¹,åD?H±ÖNxXôó)’îM¨‰\$ó,Í*\nÑ£\$<qÿÅŸh!¿¹S“âƒÀŸxsA!˜:´K¥Á}Á²“ù¬£œRşšA2k·Xp\n<÷ş¦ıëlì§Ù3¯ø¦È•VV¬}£g&Yİ!†+ó;<¸YÇóŸYE3r³Ùñ›Cío5¦Åù¢Õ³Ïkkş…ø°ÖÛ£«Ït÷’Uø…­)û[ıßÁî}ïØu´«lç¢:DŸø+Ï _oãäh140ÖáÊ0ø¯bäK˜ã¬’ öşé»lGª„#ªš©ê†¦©ì|Udæ¶IK«êÂ7à^ìà¸@º®O\0HÅğHiŠ6\r‡Û©Ü\\cg\0öãë2BÄ*eà\n€š	…zr!nWz& {H–ğ'\$X  w@Ò8ëDGr*ëÄİHVéŞw8ìJè\nm@¦OÈ#P²Ï@úYp²ÏÃ¶wàÊğÀP\r8ÀXë\$Xü Pİd–	ÀQ\0Rx1\"T]\"êĞè Í	°êQĞğàÀbR`MÛğà-àRSE8Go0 ê	æd‚B^±\0ÂÜ\":ÜmN.Şj%ß@æ3(ªx Âl ÌÅŞ	‘€W ßåŞ\nç:\r\0}®@³qm;@È-¢Ş¤Zôg.zFÂf@Ì\rW®Äck‰Œ ñ<	é0‡Ëúz'4\rñ­\0îjELYˆğ(ğ%€\nM‡ÄDÃÂoFøB¨q‘ÖKg²ä#ÄZ¨¸³àä\"\nçÀĞ®ÅêhŞÒ‹2-n§\"jy\"¥ê§èşì\"÷ğgı!,Ä*ŒTù x¢ÅËPú‚5%Làèò`¾LÖM†¬@¶ Z@ºìÊÒ`^Q0R%9&jv‘häX ğoöö‹G#æ’ö²DÙòHùKÂ¼lX¼ï¦Í-äû2hWli+æ&ÄÕs'rzìàÉ(„Òˆ‚ò¼¿%tKå6ûrâ¶ëràïáK.î¢‰Â‚*Ğ,*vbgj#²óLÈ®v®Z‹€Q\$pÜn*hòÀòvÂBñôâÀ\\FJˆX%x f\$óA4K74 a#¤¦3\n¨(|°Z,³e2äl\r|Kû0Ğò¿³¦ÎW2-m)	)‘¾Z'%€Ü	ªè7å.›*í*\0O;’®C¥*¯—\$ËA;’VÌò¸ë‚(€ÚlìØt‚Kã.DÆ›_>á:¥v¢3Ÿ=dö\$Ræ“ øSlß7ˆºB[ì!@È]à[63zS…e>sòr„Dz€í;T0²SÁ*ïCË+oª\\\0ÒÀ{D´Ükè€z@·= »¥·Dª4Vç‚Ê•*\0Wÿ³tÿäv¶¥yDÌ-¢5CŒæ3•¾…ıD´–t”›!’_ U”XL´]F÷Fn—F ì&@%b>cˆêPÜÛIö)3<’@ `ä\r“55Ş%¤/3Qœó@Gó5\rÍÄÑ±T£è,§ŞEÍNÈ&j\0ÆhÌ¾\$Üá È353‘TB'FLâÀ¦'DäñøU#±LÑÉPm*Ñ \\\r@êò@¨)íşE­ÓUUU•]V†ñïŞ`‡MµÒóRD³FV {4Õ`3U4•‹5§‚#ÃT`èQ(ğßµq7M÷*@SVMÈÄ¢#ê~ƒ2 Õ´Ñjl¤@·\\ İ.J|2“U¡\\¬º Ëv·°«\\b;^\0Û6x·Î‡]ëµ^uøîõULµZ§å—MPÖ™¬4Hû9µ\$0å3Í'VuTõ@ƒKW•|ñ/\$J*D´÷]î	X“·_pªõšŞ•Ñ¥ÄÕ²uü¤I¬Ü…zä¢®ÀÖr…Ş\n€Ò%¤8š“i^Èò»U¡15³n;I\n§R­Ÿ3§ÙQU45…5`z€ac¶­b°`qOtÙNu 6)õTÿ¯‹jµ“X–´ReÈ#ÈJ-„S@á\"U¶ëÀÎÒCÊUUß8³‘6Ø-kií/YÊ¡ R\$ğ¼!·\rn×[6Vİ­íqÕ€Ê.åÎB‘¢°¦cp­pps!\0»Ow\"çngsôX³wGiÈ{Z\0Su*k`”ÎÖa!Qo'd òx Caö ö¤cë!ƒºŞ60P°\rÊ‚‹T¯ÒœµËú¦ï¿,jÁ&ğ@Êƒ( OA€æP÷T¯jÕßGhÎ»b¶¯Ì\"%°\n‹qX€z %‚ÃÅÈÎëm~@Ï~‹r¶ÖJnWâ~ Î	¨]RXûFÖír’ÍxNmHp ñ+@Ñkl#€Û\0ËívÔX&…Ø,iÍd¥zÔÓ\0äNıø~wêü¸„×û€Ø\0äWá·ı\0ñKNÆm†	0ÍpÓíB×¥Ó'X)„`Y†e±‡XyI: Ë`dÑ t¶\nÚ('N\r€àHGuKše¨\0Ÿ€Ä*3’æ)n3Í¤ oä“Vò}vö¯ô¦æN\\°ØØèÜ1i)\".`t„>\rØÛcÈßó—fãŒoA—©\"×­±³ É OyYïFÒ\rá[5BÂo*/t“(ÅÅ%²úR[<òï8V‘“\$AMï¨¬5¨±9'*ŒX¤úö†‡ğÜ…ˆ\\†æ\"jrDÔ\re·ˆàX|ªê^©n#‚dÍ¥lÙÇn‚©¦ªM¹¦t€~\\…Í›\0™›@á›‚g=Ñ2¬À‚.†*\0@Ô'9¾—yÚ ™ß9æ dæ	£zq„6ò€]œP~\n€ Pì:‰Ù<ƒ¥œâ DY„:]5[[¢'I¢—ËFùö…º\$Bâ<“P’P—@N”0/Eú:^ DÈJw¹¥\0€_Cdz#¢zFW4(Kú{¤U[¨ı{>\0^%ĞM@XSÚ‡£ZŒSlWº™¥…wYº Ş”\"B*R` 	à¦\n…ŠàºĞQCFè*º»ˆYÌÍ§e‡Æêˆ+âH¸j™\$ÕQ À^\0Zk`îªV¦B%Â(X**2šÍºèº»®æôN`°ºê| È±„-©“ ‡í³«~8Zæ Æ‡Rz2\"È	Jî4›S~J»&tŠ¾e‚m¤Và}®ºNÖÍ³'²Úrú5f.&1ùÀ›jâğ‹§§úK¤åm¹{‰¤`º†w Ü!•^#5¥TK¥„¹Eâhq€å¦\$÷ñ®kçx|Úm¥:sDºd…zA§Ú‹?…¾ºˆ“[ğLÒÈ¬Z²Xœ®: ¹„¸[(!‡k¬X²V¹yƒ¾° ©Â“­ï\$\0C¢9ˆdSi¹in‚ {`”\n`	ÀÄ|K Â¸:ç»5ä»º# t}xĞN„÷»{»[¸)êûC£ÊFKZâj™Â€PFY–BäpFk–›0<Ú@ÊD<JE™ºi0“5Ãø®•T\"¬ãVhº¬Á”ÄNÌŒ“HùWDeSsŒ’ûNŠô\0ËxD²¸L1„ªë¬<!ÎÔ\r3ÚÍÅqd´öK3…P”ÓyÈÔë¢E/`ğƒPz€Ş–\n ùÏdYÏ¼şš½5Xïı8W•ÑI8w[7Û³`ª\n@’¨€Û»Cpš¬¨PÛÔåƒÕ=V\rıZ{*qİ\$ R”×Ö“ŠÆeqĞ¬Ä+U`ŞB¤çOf*†CÌLºMCä`_ èüü½ËµO\næTâ5Ú&C×½©@¸à\\WÅe&_X_Ü».·8œ4d YÃ¼œ‰Âp\$ezAµµ[\$]ò<]»|`,\rul\r5áqpÊdu èéˆ±ç´Œ£ö¯ÀYi@û¥çz\nâ¨Ş7ßş;“È€‚¼­½Ü7ßb'¼dmh×â@qíõChö+6.J­×W¶Éc÷e]ó‘eïkZ‚0ßåşZ_yŠè‡fØpc8&‰©æÍ‚üœz\0„EØÎÍ7º0€	ŒÓ\"ö\$êÇ=‹İìÅ!>úæ€‚g7B-QÆ/e&ßÆ‡­6a€˜p\rÄe3›cÕNIjn-Ä\$*x-WVİjõ”@oÎ#wó5óˆ'OÏ.œöÇMÇÙˆ\0èHøCÖ9ïÚÀ-míP™îƒ8S v!Àè;gtLŞ5,	ñ€#¿n# •Ş‘“x-7ùf5`Ø#\"NÓb÷¯g˜Ÿ£ö Üeübãå÷,7S§¥òGjÙíoÕ‹F?ÀTŒ6ƒİîËmÄÌs‘š€¸-§˜m6§£q‘œ;‚dl¤ÕÏé0fE€8ô]P'X\n›ÿàMGï–\0£Üx‡\0É5¢€ÂÍ*Ä#ø*à1>*]È–Ws\rœ®,¿’àÀØ\0öO–,q2Íj•+H ÃŞFG€º³E¶>d@bÑ÷±¢Iz¡aR¸à8@7¡LB¦åş‚H‚ ½è¦A¸Ë³Ép¥p@Ê	 d¨kƒz4EƒA‚	Ã‚ƒß‰ºóWA1\"À2bGk\"£\0ÀdƒhíRD¥p !fPs3`FÔ´¿e	OkLA¦Ó‘C—/ ´a@|@¦²€:!âƒ‹á˜‚»…o‰T/b¼“¡‚Èá¤lL8èˆDjÊ„öë@2ºÙüÎº€ƒìENë\"¾1ÃÈzqÂ,\\^ãÔ)8V°½qÓÁÂ1	â<í'4ÙÖÏÌÊäáC!ÎFš…´4 €f‰‡t cº†±µÂ\r¸m—z¡*M¦®(ÁƒA†¸†„÷À2Á)’Pr¬ÆŠà²ˆ¤45	 Î\0Z[dá9¨hY‡ »ˆŞt1e¯EŒ\$o`ÆX ¡gèUd\0G¨~DR<èÒhUp€y¦“=­T(‰DZ-bHÓÈ ú‘ya¢H²¯°lb¬b(œâHLÀú8e¤sC«½Ûe³I¬=Dğë{ĞĞŞú]È<ÑaâœŠQ=Tû\$!CáOÙ¾UèG²â)ª“Q¼VÃTb\".\r­Í@<)‘o¢`œV\r0q—j‹s¡Xˆ¤F\"*åbIùÚ¢|øÄAˆ hp\\	²‹X¨j#ˆbË#œ©ÅO>5w°?TóÉ¾;öÁªlò1aÖc\"t5v©Ä®Á¾`‹x\\CM=ib„¨!.¯HLÂmâH–ÛÒ¬ãñ–%+¥£ĞD4FøÚ¼Ñé£C©[KX}P¹  >e:V¡t—;ì#Ñ¦„Ä&‡Rñ©‘È´p’,aË˜ HåÆœ·ÑÎDt\0é\$qŸµñÀ/t›õ–~‡J›¥·éî`Ãö,ãº¼¶‰]ÀÎ`å%3®>Ş¢´@N­Óx1,ö¯ªùrÏxr):ğ˜8ÓäÀˆˆ 0†Ì‘ÚB«,EúAˆò‡íùåàBá0(•üÈEùã8@Œn[	(–ñåhídDÙ	HR£Q¼†^µ!± Èv<² „„‘6œÕı’Eò\"œ&ç…¸ÅV(GBü’UªËé_¦«ûHü½sÛ@Õ*BN)QH£ˆævTG‚Æ0ùhØRÙ¥Ù†+õ-Ô&TúCó?ÀÀzd\0\$¨bSÚ¡<ÆãÜ‰Q„í@º P®ÀdpOÓ>+‰>x|Ì	¡Me‰EˆùR€4 ‡k(W{´*-¨G\$ …È	'Òj\0œ‡H½ü¥¥	(ØÑ™>A%‡YêÏÀÊ´ñ6Évò«£ÇŞ^¦K• G%2ÌEdÍ”<öJ¡#ÀDE{0\$…T+ş2T%Š#&ˆŠW2Íe³ä¹\nSä§†Lã–cšdÇ—²°hÀ=–ê|e²\"' ¢[­¼óa2#%=ËuÉk©:6É,ÒüKÎ\\’âd¼È—YGr;Â·–Á=ÀØ  ²öLÉ´XyVšh*…‚ŒO *»ÍFšˆà-bK*Š#‚†‰:.<ÇRY\"EU'x3eQÁŸÚü©”’qÍ@>™bK®x‡Ä4e… D¥G?!éáN¥xk©aŞ4@/¡˜\rc0Ò¬ÀD³!¾ @ á;€D9\$:·”&€ “Wå\$ÂÃR5ÒÚ—HAŞ2o=•@=›:œáÅ\n%ú¢ü@og”¼Î³]¬ótT¹&ê# ¸ˆÈqU™øf‚æc@ùÓ|BW&ø_‰¿¨Î\rÿR\"(L•zr‚s5*ıT’¸™ -5\"ÉZ74È%£ñ\\!yÎ’„7Kâ @Z‚™Í/v\0/I´ÃÖ¯‡s®ø@äÀ11œ& -FÁşÀ¸5‘DÎöAu;¨í@[<‘HO.y³Ÿ@ZÃs™	„æÓ¶A™O\0ÊòœÊ´§ĞIîZ{Óà0ÄøçrÔ’Ç¡DP°'ìô©ıOÄvß\nœøB?iòÎè¬@#[HƒBé!~P>x!uøEø.\0¤à(wIE1EÏİÜ /è\":\rĞu|T Kyç8[N ?¡xgPÁ!õ‚ç;uÃNBTúÎƒÉ¡\0Ä0 6€¼\r`bhE\r\\™CpĞøt@¡Üæ;ÄElâ{›(¥>1µâŠÁ*Ÿ°\næÄ)ÒMòCÊ|@·¦`¶i\"š\\ÛKFÉ¥…áÂ	|Ş(K4ıgJX˜iBP‰'˜\$²Û>q1Bæ¶Ş	ÔNáºxXc×ß§Åª©ô,Chìy(Bˆ¹7S#\r!H0Ç—‡9‘¨˜ãÀMJT.0ÂĞ)ZD‘òåB?°üˆ-v¥¾q*”İ,JÄ<bÁÕÍ&˜ë˜İd PÆòKG;Æ y”ã	šÄ#>)íiÈ‘iœ&Èœ8]*CÍ,Ã´ò 9¼’\nhW\\	’iM 7Šˆ!Ê—9óÆŠ_–¬,Åò9ñ²Š©Ã\$T\"£,—)51v\"Lf&á»-àé”9>y¢ üQBJ‹J4±û\n»,*0¢Pšı–‚g6yw”/M‚â\n<”B¨i.F…öş£ã2dñBärPê ¢‰jjwi¢âÂÔä.·ƒpI\0æ <“xVŒ¢,ˆ\nCúSºŸ—ª0ÌP¸„ÅPÑäŒr+ Y€x#'IU e\"ÔcQµCª¨˜‚´à€\0*%Ä \"’ PhUr×¬iècì,5V–ôW@-¯l¡ÿ_¹×ô€=Õú«Š­¬\n4‹èôà’rU!«ºF…ğ‡ª»©µ5ÅÙY¢ÑÀO5!{+4)OëFeÚÏÉ¬UVShğk†*ÆV§_Â\"†¾gzÈÀîµìs¬jkë/à1Un¶ˆ­•aWó[zÉˆ¥\")dŠFØÖR&7«âYfÈ•‹ã	-2Œ¥r_I<q’Ÿ8Òõ0±)æp™P	œôƒP½Ô½0rYŒBcD#·²›\"—Ñ#Ì4R:´í\$…Şò^UÇS&ZIûnİW“mKÄ”\$ª¼+#zD+ğ¢“á6ÁÄdv ¼Bbœa41d@âŒì,1	‰nÕû	„¦4¸)	ªt(¯-u*¡#Û´¬[N2…ÀP\n_)|4H0— ¾L\"æÛN€Ï0ğ&\$	`Eà€ŠÖ°,B¥í_\\x\0Qb^Ù&Éro#Ù‚¦ià&¶nà%6{–˜&•L\r'#ØF…§`Ñ J¤±Å†lÕdR€¤(h% x\"HC·K°? v8KCPÂ Q\0ù_áÀá#…P)ia\nºH%„Ç©zzVci\0D(DV5QÓ°Šobë'è\r–2Q½›FO`BD'¤x)é›½¡Ë~,@)}X¶r³PğNº7šT¾ĞÓ<Mš¬‚HÛ\"'¬7Vn¯’ó”€!=X „ØìÇ §¦È¶Å²\0Š,„x[X,ÆÍëØ²Å¦”ıÈ®ı•·Æqep5Úàà!>\nSCDà\"A\0œÉS¹Q\n”]ó‹,µ-BdÆ‚=†ÕST>ZÀÂ(\0/‰ìVlà¯.q3°ÜT@\0+¢;kÃMDÖÓÀ\n¬¶‘ñqÁ§Ô4ŸaÀyTÀÈ`\"Ì5¿ğ²É59°|@`&Ï´Ğ:RØ‹’\n2Êv”¶Õ.mAŠ`¤TkãŠ|ê|2ªL”û)ÜÂ‹\\Ëû <V•Í3qê#C‘—öD2©ˆ–©hĞ3£Èˆô½×¤,`‡0–:èàeºK®™]Ç4R>L‚¢g\\Ş[0ì Ë¸qÙàÊ¨ü*´—V¥áVœ¹Š]r0·q0	îçt•’İŞ·O/\$·®¥›¾;2ê—¼‚L;+\$‰ ²lµ*ÜÅ˜íJ÷»C\rn¹{\rÕƒ€r½;ã<Å°8Uˆ!—»5`cä-“X¼ô#ªƒ†\n¯`kÜß“\0:¾ğ¥^IˆÂ§6ë!ky‘¹‹*«åAQo@uá½–`NÚÁs‰‚¡'7°F&’áû©ØC£´L¥†:è÷ÍRóÒßní(ó%Û„3¦æÙ¤ë°e¿û¦px`µ§Hb·l¾*›†E€‹4pÉœÀi{°xö°s˜{¶p5Q†¯ÚLq¸nîĞ&Ø™CÇ\0§7²ù\0¹;[¥\$Léjì@:º2²L¼â{Ø|pTRæ5¤Må7_DÉ\n÷b’pP\0]ÁÊ>ldr5CCéeq2Š*]ôŒ^0ènó	î•nKŸà@ô¯|i¸/Âªƒ®šìoÏ;MKïô ’š±Æ¸uE›OÎzØĞ‘ôãõUnú8ö>„å‘IJëı@Ğÿrâ±`sÄ6“””«çS˜Bºİe™&\0¨eV8oêó¨u˜S¼zA¿°X 7‚ó	©j‘9+â—A-`Wëƒ¹eØºëõ\$,ğ•Bq1ÚŠ˜h–4¸­nHûKÉàİè\r -hÉoa€Ğp€`Æ‘lúAd×“Š7\r‰õŒêµY¢¼ÆKš€Z!àØÖ\\˜ºQŒ ñ„dÂÌÊç¹Ğ¢E<¯’§Gz­³Ô„±8ĞZ .6×N€l\\,Ì:~®^:ù-K‰CxòEÙ@YÕÎ{‘%ó^lS}/€xuû½©+‡_U¤ø€¶¥óãªÛIë¸¢Î¾ †×Ğ&—­Â9‘J‚ä¬3ù0¸2i“a‘dë'ï?;…ÛWP>ãƒâµHñüD»åh‚-Åæ%Â.~œ©XÀ8¼R´<ë“€+µ]±Ê‘ù,F4\0P“ûtpÙhıˆ,ıb*ÁAy)v.ğ£²Ğp’x¤¹^]ÜÔ‰œ½BÜuj*?¯ÒMÓŞ²lİë€d àÃ+”&Rµù#}¿1[I˜0–:¿Hş–Å‚ÇHë±T4€2Iˆ®éšV¤PŒ? -È€º–É;3pÊ²RóN_,ÚÂ\"“4‡¿¢e)™›ÊæôÙòØ>´™³TüWv‘´™Í	3nS¼ÈD'XCƒq„qÿç¾L®Æl³FŸs(ÙÀã™ÚÎ†i©3š†ÿP)\0(Í^ks_AìØáÄvW`4zQóh6‡Ä%=~~5‹İœúö*Ë;ùÛ\$äòvkiÊHh‚§©~€KL?”S<G\"Ğ†mS™špÿÀşœ-×şDâˆUyO©DPDC™ÆR?‘nx}\\¡şØõ ˜`Ş0LjÄê•á¥\n\0Êfb½¾‡íúUC=/6Î7ÚÃV0DSÆ#ß	X¯¥½iÀÛŠw9d@`^;6kñª”·a),ª2\"Ò1V\\(2(9(1ï³¸	Pz¢C¸	Ç\$.AÊiã˜iÁ°dr[V(Ùe†™—r19è¯º-,y.©'x…#ûK…š,¾ˆ¸-ÄEÃ ƒuôAˆLJE#E‹~Ö¢µ©¬C…¯RÃ·Ôú£õ7ˆR‡ÇT gÔîˆNŒ‡æ¹MË^qß/TÃTÄiÒö«õºæ'ØL€ÁC+†kËáò€`2=aâ¥•@-¶+M3zÕö°¿9% Y*¾¼e%pÜÕ.Ó™*ŒçÃL\\b¼µİ‹€ôHãFãÓÈPm8é“¾°ÕOzê‡Ö»'³®ãµ:d•¶UjP£ÂXé ë¼½Úña}¯µüİ€g_9ÿ¶Jk…Ô\"õëì\rllôA‚%ä¡®hË«dß‡zbkbõ~‚Î—kà‚”Bî­vÓ¦t˜™-n9T¾˜µÃ˜0w…£›ç…MBYĞ±x­¥²l‰=\"C>än\$	‰ŞÕ=Àuè7¦?X%Úÿ~À›¯·Ëm\\x´¼°@F6-’@í¦ÛI(>Ó\0Y´êIiL\rë©§XÎHğ>N¨bÀctrn¬Öx‡?X%%¼v~ÀÇ{5°l\\€yĞnÃv²ta]ím½à[0àÊ.İ±L‚C¦îÛ6Ó¶RfÑ&À%DÜ¾áB0ò§8Ÿwfw–ÜmÀ‚;X1ÿír{KjÒwvs­}nGwÀbóŠåo‰¼5^GÒÚD‡tÌĞÑ‡i¸Æ3­|EíB{S×Å°ƒzäi.S«zAÌö†ìLRñ7D˜r>“^˜Ûşla;VOv´~i¼=1Ïzš± ÊÌKvv‹\0jsŞº„®Ï!0Nª¦!\nŞ P!ËdÈÌJ×gßò4¤ä\\!ëcNDß¿ôÖ™c¹ÃÚàbUÊ¦l1ÜÿDœTÚs\n+\\h‰Ø€)È\n„éÍ*p¤âwËR€E¡Cp”®\n¡|„œ½ª7¨]ã|	€v…ÀßØ`š6!^Q,®ü:„ÑJQÿü»¢İ¿=Ô‡’³¡\0ÈOŒˆ8Ùqâx á\\	;Z²{‡AÑŞ]\nw&<2‡ŒeU¤{uÇ{!'e;0à\\\"©*÷nmì²ªE8ŸPetS‹¾ÃšZ¨Ò†_ŒuÛËiQ]\"€Ø[p,Úò=Úä3ƒÁ@à¨ÌÌˆqĞy KRg2‚d ³“´#ÃSÄğ'ŠNïœ &M]\0WÉT„¤cÈ±Ógx&9Dré§µÓpöQŞc|L®zx3°SSÔ2cIŒÎå	xĞ«7åvvÅa8ø9¤hÌóCº¢‡8Ò##™Ôc`JŠûu»M3µDE¡mğ'Ï­»|ÂG¯9KA5yS¼TÀxÆMÓeµœ sÁ»|×Ü‘C¹ôŸslüå®Hwz¤jô–ı]‰e\0H NkX,’Ö}ç.Åkî!_?fE¤â’t2xE'è€“»Ò ºô?o |<W™HÎ&´ó£Á\n2JjSà\n#œ]&ÚoMºa€ nÑ¶CwO´k==£ş^Òº–Ÿs¸à°¿“Õ9vşëÔæYE]–­`„‚d³|ËÍ‰İ^õ	¶Ò&Y­…ˆ¸sF¦uÀ|p–®f½u¶ŒAqæ0É«Ì]fôËw¥¦~W‘¹S\"µFë¸:;ºú4W&­¾ê(ÍÀË7\"ı‚P¿zÎJXV_ÒZ!åË5t«¯\"l£–8 ã£\rRZ*€ê‡r‡ÉDÀZB[Té@lÑ0Â2ÂVh²W©l˜Ó&bz²ÉŞ¦¿+©eúm«îœÊ/2ÚÓ°JG³B”hi÷A&¹êw2ZĞJ(Îâ‰Í§Käê”Î¬M–tóêÛ-ø™DæÛ|w½·ÓÇnz•,`Æ³1šíùğKûÜ1Z÷X‰¤>fÙuÍD”÷:Ÿ4©°}0ìR[aäC½@sIòZçh–ä¢÷s7ŞN^Ï³ŠXÌŞIm”´‹çÃ*RY&JõÄ#¹Ç‚ü–ÁExBòhÇŒİåŞ‘w=}æ„z\$HÑŞİrÙ!!c‰‡¤ìX‚ú]Ëîf&\$l§ÏÜ¨Üä²1½2­¬BLD;ö÷¾â4‹'¼“­l×…ÜÜßæ8ìø^ï,g£}Áåevù¬ïlªS	UĞ {òÓ|èZYt‚°Y)Ûº……JÇ¯›=˜\nüÚ§e„†³÷>‘?\0çv¯¡ı¢ÂJ>b4R<H7Ke7ÂÏtù=çUñaRó9#Q\"¼)ÄĞ=ñ¦#x\nN \$8€EÀ”rÇÌÚø1x½\$>_İ÷ë<Ú¡¨ø:AÖ~İË)‚òJ»û™^c'BïÍ¯Çsì”`ÛKşÒÏO¥üOàúúyİ0Ê¾Ï°³ß‹ô‡y}	JñÍe¼v‡EæÇÂòYÎ–òuìºï34>ë“?‚h~o{ãÄÔzZRí„Gõ/\0eµ«£úÀİˆ\nu–\n4ƒd|gÀHû¿KI½–W˜ÃA‰X³E o#IFÂê‡UBÌ\\…FÂc4ÂkcÜmÅŒ@eœk•ó)@7@È`h¼YU‰İ\nÿº×ä.¸uwÉ:áò`<ü •\"ù±aI2{ô ™¢K'£m\0P\nğ™ô„Í_DÂcyB\"ñÒ5}|¥ù2Š\$¾¬3¬YX­ioÑeEÁ <ëÿ[Ğ‰ Q\$`×ı¨4áÙ9Ì£]\nˆ¡˜:ø›rq_²W<£Ò ğ=Šğ™*“ÅtÃmÙw\\\0¨Àaz›Ãê%õŞ?-Èı V§_¸‚|Íùh‰Íéu6^¸ı˜EòR¹P~’Ì	­	€N¢r†\\˜è|Ø™ÒN£»líKxª_ú‡ÓÉ\\*mH\0ğÀ<ÜÉä38ào¬©dÏ,a4è \"×BšTh‹¥çIKSŒà®jV^q\"#q¿÷Eª@,ÿƒ¸\\H‚€+“üÁØ†úØ1«8‚ÒpjãVÙd·qålÿ07Í¤ìxv¬PZª\nÀ:?Ò×t\0€6ª²Q)CE¤HHhâã¾¾	¸†ê¯¼8-HÏ«1\0>äÿ‡èšÈm`ß6,ACà21EäşºCª|gL”P/VIê(¨SP˜§aS.R òAcê°ëåÑ€·àšHÁ€º	<	e èN+oöÀxúÆc¾vˆ ·™>\$	.pñ 1ªhiÚ(Zìù84-Et,Ø#Oş€éãÁÀ˜Ö9ª'˜EÚh@˜“”ÀÀìˆPØ)cèC‚v5M4¨sĞ?)@ğEC²0<†\\Å4ÀÀú„%(€ìƒ¤„]ÁEØPD‡c2FˆßyCpI5 €°K\0él0W­¤<ÌáL—¤Ár,@Ô¡}@ÛèÖĞ1€]|Ë<ÀĞäÙ|D:€Ø©d±Zjü…OA”PÈÎ*š¿\0l\0À8 Ãô0q\0á\$\rp@ÜÕxX08@¥‘!™¿jDE*5)«çÛ†¾8&€›Af>T\0;\n¼“tè±Ká(7ùäs@‡Ğ®	‘¦Ô£Ôv\\ğ‰Á_²NEOB´åO#lTò°W(àœ\r+ ¯xGoâ<ÓL°;BTeØ]0‹„Í	Ğ^‘¼G€¢Oç¦ƒ)Rê#Û	“ÿ\nÚ«­ÀÃ%Bdê¡ ®©º¦ ¨?ìùÀ\0ÿ@°`*”*à:@ hv\0¸ÂdÿÌ)ib5r¤Zl¥QBšÑ%í½XFA@4\\*ÿœHwIyªP BüMhğ¾Âş\0ápºB©!	‘‹‰Rp\nBùü0ÁBü\nËoœ¡bùÙ×/‘‰¨\$ÓX«– ¼šS~/øbN&”‹ypÓ¢HÒÀ³^äàbï:P„—¾±\n	'Aˆ€Ä…Ä6 \0fyŞÀ/€çH%Ä\n€	!l´LşPZê“¦½ÙRà½„41%‰–lìŠ¯„à @ê‹èÌT£Iògò<Âøä¦°P\0»ƒhÔ8f°-vø\rø¯€âø”¡B`ÒŠ=£Tšàğ€¶¾ÆoÚ¾¤¤w ¼áÉ‹:ÁÇ\rÀM¦~ ¼Š‚\n\"ˆ	#€Ãë	\0å‡‡`1ïö€W@%O'\\ØX ç9\"¦P›§m¸Ö\"â€d¾¤E‘Ä^Ìh‡)Ü&U\0Qğ†q\0ØÿD`œ‹J<¤Dğê\0«gş\0ĞÔEf.DZFYq•É‰q²€âÌMr÷Dq¯<8˜‹Å,9B\\¤,84;s;¶(*UÉX~#T= —CÙ;v¦0€€ÑäÀÃ¸İ³hé9²æt>n6Ì‘(( ");}elseif($_GET["file"]=="jush.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("v0œF£©ÌĞ==˜ÎFS	ĞÊ_6MÆ³˜èèr:™E‡CI´Êo:C„”Xc‚\ræØ„J(:=ŸE†¦a28¡xğ¸?Ä'ƒi°SANN‘ùğxs…NBáÌVl0›ŒçS	œËUl(D|Ò„çÊP¦À>šE†ã©¶yHchäÂ-3Eb“å ¸b½ßpEÁpÿ9.Š˜Ì~\n?Kb±iw|È`Ç÷d.¼x8EN¦ã!”Í2™‡3©ˆá\r‡ÑYÌèy6GFmY8o7\n\r³0¤÷\0DbcÓ!¾Q7Ğ¨d8‹Áì~‘¬N)ùEĞ³`ôNsßğ`ÆS)ĞOé—·ç/º<xÆ9o»ÔåµÁì3n«®2»!r¼:;ã+Â9ˆCÈ¨®‰Ã\n<ñ`Èó¯bè\\š?`†4\r#`È<¯BeãB#¤N Üã\r.D`¬«jê4ÿpéar°øã¢º÷>ò8Ó\$Éc ¾1Écœ ¡c êİê{n7ÀÃ¡ƒAğNÊRLi\r1À¾ø!£(æjÂ´®+Âê62ÀXÊ8+Êâàä.\rÍÎôƒÎ!x¼åƒhù'ãâˆ6Sğ\0RïÔôñOÒ\n¼…1(W0…ãœÇ7qœë:NÃE:68n+äÕ´5_(®s \rã”ê‰/m6PÔ@ÃEQàÄ9\n¨V-‹Áó\"¦.:åJÏ8weÎq½|Ø‡³XĞ]µİY XÁeåzWâü 7âûZ1íhQfÙãu£jÑ4Z{p\\AUËJ<õ†káÁ@¼ÉÃà@„}&„ˆL7U°wuYhÔ2¸È@ûu  Pà7ËA†hèÌò°Ş3Ã›êçXEÍ…Zˆ]­lá@MplvÂ)æ ÁÁHW‘‘Ôy>Y-øYŸè/«›ªÁî hC [*‹ûFã­#~†!Ğ`ô\r#0PïCË—f ·¶¡îÃ\\î›¶‡É^Ã%B<\\½fˆŞ±ÅáĞİã&/¦O‚ğL\\jF¨jZ£1«\\:Æ´>N¹¯XaFÃAÀ³²ğÃØÍf…h{\"s\n×64‡ÜøÒ…¼?Ä8Ü^p\"ë°ñÈ¸\\Úe(¸PƒNµìq[g¸Árÿ&Â}PhÊà¡ÀWÙí*Şír_sËP‡hà¼àĞ\nÛËÃomõ¿¥Ãê—Ó#§¡.Á\0@épdW ²\$Òº°QÛ½Tl0† ¾ÃHdHë)š‡ÛÙÀ)PÓÜØHgàıUş„ªBèe\r†t:‡Õ\0)\"Åtô,´œ’ÛÇ[(DøO\nR8!†Æ¬ÖšğÜlAüV…¨4 hà£Sq<à@}ÃëÊgK±]®àè]â=90°'€åâøwA<‚ƒĞÑaÁ~€òWšæƒD|A´††2ÓXÙU2àéyÅŠŠ=¡p)«\0P	˜s€µn…3îr„f\0¢F…·ºvÒÌG®ÁI@é%¤”Ÿ+Àö_I`¶ÌôÅ\r.ƒ N²ºËKI…[”Ê–SJò©¾aUf›Szûƒ«M§ô„%¬·\"Q|9€¨Bc§aÁq\0©8Ÿ#Ò<a„³:z1Ufª·>îZ¹l‰‰¹ÓÀe5#U@iUGÂ‚™©n¨%Ò°s¦„Ë;gxL´pPš?BçŒÊQ\\—b„ÿé¾’Q„=7:¸¯İ¡Qº\r:ƒtì¥:y(Å ×\nÛd)¹ĞÒ\nÁX; ‹ìêCaA¬\ráİñŸP¨GHù!¡ ¢@È9\n\nAl~H úªV\nsªÉÕ«Æ¯ÕbBr£ªö„’­²ßû3ƒ\rP¿%¢Ñ„\r}b/‰Î‘\$“5§PëCä\"wÌB_çÉUÕgAtë¤ô…å¤…é^QÄåUÉÄÖj™Áí Bvhì¡„4‡)¹ã+ª)<–j^<Lóà4U* õBg ëĞæè*nÊ–è-ÿÜõÓ	9O\$´‰Ø·zyM™3„\\9Üè˜.oŠ¶šÌë¸E(iåàœÄÓ7	tßšé-&¢\nj!\rÀyœyàD1gğÒö]«ÜyRÔ7\"ğæ§·ƒˆ~ÀíàÜ)TZ0E9MåYZtXe!İf†@ç{È¬yl	8‡;¦ƒR{„ë8‡Ä®ÁeØ+ULñ'‚F²1ıøæ8PE5-	Ğ_!Ô7…ó [2‰JËÁ;‡HR²éÇ¹€8pç—²İ‡@™£0,Õ®psK0\r¿4”¢\$sJ¾Ã4ÉDZ©ÕI¢™'\$cL”R–MpY&ü½Íiçz3GÍzÒšJ%ÁÌPÜ-„[É/xç³T¾{p¶§z‹CÖvµ¥Ó:ƒV'\\–’KJa¨ÃMƒ&º°£Ó¾\"à²eo^Q+h^âĞiTğ1ªORäl«,5[İ˜\$¹·)¬ôjLÆU`£SË`Z^ğ|€‡r½=Ğ÷nç™»–˜TU	1Hyk›Çt+\0váD¿\r	<œàÆ™ìñjG”­tÆ*3%k›YÜ²T*İ|\"CŠülhE§(È\rÃ8r‡×{Üñ0å²×şÙDÜ_Œ‡.6Ğ¸è;ãü‡„rBjƒO'Ûœ¥¥Ï>\$¤Ô`^6™Ì9‘#¸¨§æ4Xş¥mh8:êûc‹ş0ø×;Ø/Ô‰·¿¹Ø;ä\\'( î„tú'+™òı¯Ì·°^]­±NÑv¹ç#Ç,ëvğ×ÃOÏiÏ–©>·Ş<SïA\\€\\îµü!Ø3*tl`÷u\0p'è7…Pà9·bsœ{Àv®{·ü7ˆ\"{ÛÆrîaÖ(¿^æ¼İE÷úÿë¹gÒÜ/¡øUÄ9g¶î÷/ÈÔ`Ä\nL\n)À†‚(Aúağ\" çØ	Á&„PøÂ@O\nå¸«0†(M&©FJ'Ú! …0Š<ïHëîÂçÆù¥*Ì|ìÆ*çOZím*n/bî/ö®Ôˆ¹.ìâ©o\0ÎÊdnÎ)ùi:RÎëP2êmµ\0/vìOX÷ğøLŒ °\"øÎŠâ/…’…œ ÈN <Mè{Î­/pæotìS\0Pöî¸ÛP^ä€³Ï„l«<øáÎäîB÷0	ozö‚¬©í0bËĞ­°ğğ\$ñp¹ĞŸ	¾÷sÎ{\n­Æi\rod\roi\rğœïi	Pè÷Ğ¥ÌÊøPjöp\rë.»nÅF¶é€ b¾i¶Ãqğ.ÌÌ½\rNQP'—pFaĞJîÎôLõ\n1<àÆ\rÀÍpı±MPå°	P¦ÉdÚèĞs¤M \\©\ng§ìÀÂ Ø\$QG‘S•„d‰ÆÊ8\$¶ªkşDâjÖ¢Ô†Åö&€Ó€Ê ¶à‚Ñ¬™± {°›ñ{\\ÕÀúºÀPØ ~Ø¬6eö½¬2%Íx\"quàÊ¾`A!Ëï ‘ÂZelf\0ÒZ), ,^Ê`ŞŠ±ºÈ NÀ±8Bñíš™èùrP€© ©ÃkFJÂÂP>VÆØÔp¨²l%2rÂvmĞó+Ø@ä’G(²O¨s\$ dÕÌœv†\"ÈpòwÇÆ6§æ}(VÌKË ‚K¬L Â¾¤À²( Åø(².r2\r’6ÃÌ¤Ê€Q ²€%’„ÔdJ¨¦HÀNxK:\n ¤	 †%fn‹ã³)À¿DÌMü À[&âT\r©ÀrÂ.¦LLè&W/@h6@êE ÈãLP‚vÆC’ß\"6O<Yh^mn6£n¼j>7`z`Ní\\Ùj\rgô\rÈi5É\$\"@¾[`Â¢hMÿ6ƒq6ä’ş\0ÖµÈúys\\`ÖDÀæ\$\0äQOh1ƒ&‚\"~0€¸`ø£\nbşG¼)	Y=À[>ªdBå5RØ‰*\r\0c?K|İ8Ó¾`ºÀÀO7J5@Àå9 CAÀÂW*	@€N<g¿9Ól7S£:s«B‰{?¦LÂ.3´DÄê\rÅš¯x¹%,(,rñ\0o{3\0åÏOF‹	«Î]3tm‹‘õ\0”DTqÄVt	”Q5Gô›HTtkT¢%Q_Jt•AEÕG’Ä‚\".sˆÓ¤ ÃÆ<g,V`SKl,|“j7#w;LTq´Ù9ô8l-4ãPÕmòqªÊ\n@ÊàŠ5\0P!`\\\r@Ş\"CÆ-\0RRˆtFH8µ|NíÆ-€Ædòg€‡Ò\rÀ¾)FÆ*h—`ö €CNôÿ5ÊkMORf@w7Âß3‚Á2\"äŒ´ÓE4“MTõ5Œ,\"ôà'¼êx§Œy—VB%V„“VÕTÓ5YOTâIFz	#XP‡>¨âf­É-W[Íšİ\n¤pUJ´Õ€Ôt`7@¶ÂÒ,?’á#@Ñ#ˆªµ£}Rñù6‡6U_Y\n¤)õ&¸‹Œ0o>>´Å:i¨Lk÷2	´Äu& é¾©…rYi”Õé-WU½7-\\šU%Rí^­G>‘ZQjÔ‡™%Ä¬i”ÖMsWƒS'ib	f²Ñv¦´™å:êSB|i¢ YÂ¦ƒà8	vÊ#é”Dª4`‡†.€Ëbs~ÅM‰cUöŠuú™Vz`ZJ	igºİ@Cimëe	\"móe’¶6ÔéMòøÖD‘T×CTİ[íZÜÍĞ†ÍòpèÒ¶âQvçm”7mÖî{¶ôÅCœ\r¶L–ÁXjª úí5µT–÷`´»7UXT€@xè¹03eŠ	8Â”¡¶Ò=ÂÔàÃ#–¡jB¡&Üß#·^ ä#ÄoíæXf È\r ìJhô˜“ú´5®tî|õãm 3û/¶ÌoÓ¬D´y‡äÂb´àˆş—{wîš9¦‘ íc±ã[ÑÙ)è\r*R¨pL7êÎ—Ü&—à¼l¬Z-í¬wÛ~Œr—Ü@iU}Í¿~ò³|WÈ—mÔSBÀ\r@Â ‚*BD.7ñ,‘3K\\V Ç<XÑƒİä‡qh@•:@ŞÀÊ+|x<ø¼`á„O`™Ì˜ßÌ_c5ÙR­[ÀQbä]€õ1]…úp¦f€wÕ\"â3XW~&nÂ«M]²1^8÷äQà?¸?~’=‰Í3Šß.Wi#¬¨\"ØWòß.2çŒL«~RÀW5ŠVlO-€\0¾ÉÕ…qj×•…Â×h\rqmS¢tÎøû…o„Ì0!øş†ğĞ½ĞğOCë¹-1@\r•;’° àØ-‡À]ƒ\$XÌŠĞÎò\\\0¾0NÊïÃÑ†µ'mH;‡Xy‚õ&¼8—xÜ\r†…É…lÁ‹yWPÊ7ä<özSlÈ'LÒøY‘ ÊÎ¹*Ï¬ÖËì¢ÍÄ±™yŠçìğÌ\r¾Ï ÂÏò°Üx:ĞÖ›“x07y?ƒ‚…YEzå¸ŒùS‡ÙY‡}‡yÅ–4ÖÂcRIdBOkË5¸“ŠíÌ‚Œ+MÌ]ŸõŠ†oŒ3 €ç ØÔßÊw–ÀË—‘›¢“V1`9=ƒdAgyÛ†ØŸ]u/–B1–š#–ê	ŸØ?‰¹{#İ‹`R¡¹¿—Ñ„Çp¬Ò=£X{œx5”>\r¥Õ•U/äjÙã•ø}¥2FXß¥¸—¦ı§i¦ÙÏ€ñäÅí¿§%©šœº>Ïz‹Øo©%í©zLĞZ¥Z¢pYs’yvÊ™%§‰ºjÚo¦W’ÎXN0ƒ—L¢#ú1g€M|ÕÁlÒ`q¹~Ëšüb­J @Ójçè|5/khÒmz³[¶Ê	¯iHr|àX`Sg\"Õ«\0Ëóg7İ‹{Uµ‚µ×é˜;c€ûhJÂ\0ÒÃr[@Ku¶ @ÌmÛ±Àß°º¡`É ¤ÏŸ8­¸º„û’I:¡Û£¡[©¹z¹º#ØimHqû¹ŸIxé+“˜~˜×é€yº¢›@£E–û‰³ Wo8²JØ·ºrÛ–ÕİÃ}ûŸ¾Ûñ…›k‰»ù‹ÜŠx«ˆİ¿ø¥.’=º-ı¬9œš=·ûó¤\n¾l˜);72¸|ÙØßúÍ¤zĞNÚK£zOÁÙ-ˆFˆ¹÷–rŒw¨p+UÒL‡ò‡:!ª%—@¡¼-Rú}–/£º…¾<M¤X»¤•'\\Y­˜¥&»È\n{z¸ËÁø£Œä¼¼›•qŞON?€Ì•CˆÀuŸg¡6Åd­¸A½\$­›8é¯ìx!ë:«¼ûš¹“š¹‘ù™™À\r¹Í9¤ÎÁ¯Ìën€Ï8]›Y¹8®)œŠĞ@u6@SšWXÜµ‹¸ÍÂ¼ÃØÌ:ÌuAÌÜĞ?œÕÍ€CÍÍ×Î9½„­½xZÏ`ùÎéUÏ<÷§œı«˜]Ø]ÌÊ=Ì™›Ñ=Í´šlâ’Ìéš¬ïÒyÑ9¶(Ûß”.\nı6O]:{Ñø×|D®Õ­dôqİÏ\\]FI-òÅ€äÅÌaŠìlÃµLnÌª€v×Æüy{·€9\0’×ˆ5·l„MlÙRm×lÀxb€kæLI­1ëú›@ŞÀ„ÜN·¿Ü»&óÕ²ÕöH‰KÊ¦Iª\rÄÜÃx¬\r²ˆ3Öâé±2,ãs/ÅØÏÂ\$÷äÜÏä‘ÿæ(•æ\rûåJ ~uÔŞEçŞMè2§è`·éô˜™+åvã+ş¾qã¾“ä8Ãä|Ëä¾æ	‘êËèÂ³å³vßÕH­õFpM>Óm<´Ò…OjæŸíî’T1ounÖfzƒÛéï‘JğÁGe–áö+¾ûq\nS%6\"IT5½¹‚R³ğ‚™ğ”J`uóTgğíıY+ŞKe—}ÈjÓ©~‰(ôèrO«ó„ŞÓÿT<Â×İõn~ÿ\\\"ef›~=ğ™ö›±ZŸ‚‰›)Y5gî\"'ZU„¹7\rùB)X1İ;p.<¿zMÿL‰ŸÛØ]â‚yóª9ß°=ß}û`Î`×ôkrU‹²)&VÕî´ãDöb–1\\qÿ@^ô\r­BoĞ=¾(SO|ã€Lùúì”4DŸ.ÿô\"?ùæ/›}ç` ¥'ĞÉıg,A\ròÛ“I.I[ENEL¢àû=üJxÂìKŞıÑM\r€f`@EşÕP`iJJÒR²#‡•&P\$N¡{Ç¾ğç˜½UaP-y³Ö8û¼íÔï=y#ÏŞÂô~¾uèOhyb–™RFÔ›`½éä~ñßÀ÷Ø#\0şa.~ªŸ¨‡ó|ŸÖ\ra².›vS¤›~ïâƒHzŸ>ˆT5ŠÀ#pQzS×Ş˜ö7¨zOO‚üTó12A1ãPO}øœJõåyB\nïd„T'´+G•½©Kj\\\\YÀá õrl½dMæùXŠ`]ø°}'Qqúnƒa\r\$«õº=¸à2pßä§Õ?ª\ne€QÄŞ´³t) \0;ü1EÔae\\°õUã…ÓaPt´´©ØÀ \"øá|ü1ñCV¾ì8!rØ8]´A­í.d£!ám ıBå’¢ş…Ü/a~RA)ùP\n‚©Üá¼óz¢èş°ı\"á š8i,ºól!¢a«XyCº*Äh“Ş›¡‡è½Ò‚Y‚<Cºp‰¾¡“ re²Ìu‡À¬I„øŒG„B»Ş±s¬ôĞ&„4^`mTCbR €\0­vLêA±ˆĞµÔ°Â”<e\0…Qa`ñµõdZ“ÂŠp%èDıÿ@!‰ñ›zzØ©1ı±lR¸•Lu—šø€tV³Â,GôÏ,&w‰‹L^a{=u‹ï\"^³ˆÅœ½’µ%€=6.´€Ò°Ë­™`qI…Œ(\n#%p5<DQèÄº¨UC‡%íjõ4?Ä%gÜä&,¸€Z(@	€E¢‚€’Ğ#¦4Š)h@Œ#òü™Ñ¯ˆ¥£@\$8\n\0Ulnãa(ß4ÀO€Š8â€7‘È(@†ğ&((\n€D¤m#®À#Ÿx\n PÔw#}P*	àDÌyc» PÀO|tc·øÓP	î<m#ô}˜î:>ñı€\0¥ÀˆÅ¥ls#×GR‰pp@„À'	`Q¬}ctp(ÆÊB€eh\0‹˜İ8\nr\"x›!cş>`NŒŒãZ)Dh\n*Fş‘²‚¤z)A‹Ú6±Â\$„czLğ2É\n>òÜ\$’#‰Ç69ñÑ˜¥°!û€´ü Nª‚¾@\$<	Ñ²‘pVƒZÚÆŞ72>Áùcd0 \0´ÀI‘8ı#P'H	²o)¼|@Š€*û\0APP£ˆI1IòN1¶“l‡äÕ&áJIÂD’’œk¤‰#p÷§~M2“dšÅ(CÓÊ\rAR„”øCøĞ&G	r£‘Ò£áÉRB@'•q€%)!ãIV±ñ	ãô™ÂB^/la.ñ°^\0ã<\0ŞÅ	„<• á=*@	‘§-{Mgƒš–‰ÜóÇ'êXë– ±8¥„à·TKŞÀ\"–ªG€é-ÑË\\U—ö\0Ï,‰s9rXn_—´´nS9j€Œ`9—„°eõ.†57^^±—¼¹¡/—KíÂIv—R€O0ÌZbş PX†YÙb˜Îa’È–R¥­.ò¤\0ñ\0&–áR\n™,¹w\0ì©—ñÊÆN2™h €u	(@a2¹i€˜c®¨`ÅD'ÀĞü0\$¯™¹œk,caˆü=\0åìà30˜\r¢+\naÆz ˆ))*µ˜8kà€ÙÇòË–|ÓE(˜G7U¼s!L¸Ó?5tFrgGs›æä3ËÑR³u—ìÃ”½0Ã{l€\\MäŞÀI7Ğ™MıŸ2áœ\\q8idÍâZsŠà€»8éÈùhMÛœİ'-0Ù»Î\"o\"|œYG¼T’ÂŒeTB<\0¥q*s O'P/ôòìœ‹BJ6©İ%²wPôŞ€Y<L\\&C´ñÂv/µOO@Q *›Ğç¦“’/‡À&ÔüøX#7 .\0ªxÂŸL÷Bq<ˆoO°áp	”ïgâşï\rœ‹á0Ñ(a‹?ºOV£º	“!Øª¹ŞŠ6yÀ_„ôf/<ùáOH6f½'™@©àP6xrì €O'‰A6KB“Â%)\0\\D÷ Z\rëè\nÌ¦ëÃzƒI»Ÿ\\ôgòÈ÷PÊƒÔÕÀÄ-z„ğùNE@_9õmNÍ&ªUp¾Ì!DÔpšÄ&4JK`‘ lœ'èØóƒ\0Q€Èœ\r”Ø#÷	:êÙ¶NÁ³ÀmOğñFÆp7á™ÑzŒMŸ‚PaáEÑ‘iÂN\r€Ø‡(NœFQK§¡Â˜†p+”ÕQv*´s£r(ì%óœ2¾Œ¡Ù£9GèÒ6•M\r°¹¯rŠƒZIS1a´Ïzey\r¨÷IT¤Ñ¹:#ÛèåğAfYŠäm”†m'ˆ˜pìş1N¡eÅ)KcFj>›_’.\r+—lzEÑ†£0¤€¢é8Êğ'\0æT“£å(ÿI¨¸Ò–.¡{Ñ“Å·°;@5ô¶-ÀGŠ5K1÷.B0…Á¦{©£&u­—ïTr¦Q©G‡)¹vi¤§xŠMJTR\\n4€/,²)·B‡ÀøÜtä\"1MéÏHZt–‘4^}ƒÅFJMNb¢•§¹Î(ÉJ ¤Œá3 }¨œUj+IŠÓ9‚Õ¤Û©:d\nPğ†Ô£(%-ˆK€‡ElÃÑ§E gš`°T’¥HiV1™¢8ilj]KuÕÒê+TÜ§XÎ£NÚ~SJ+2p…·P¢ŠU`EÔıD9Iv\\€ÔõU%Öª%(ûT:•Õ\r5I«QUIV¢†¢^¬@d«\"¸\\sVÚj”~®	¤¨}@uW8Šõ_´F™*MQÊfSâ¯ud§ı6\nºÆ	s˜F”»àF­ªD•Ğ€eTÈğ€ÈL ø@{ƒ¿ 2‘ş+\$Á*I6IÒn• •¡ƒI,€ÆQUB—ü\n„¢¹.øQôÖ¥éı^tV¦Lâh#lf¢ÓŠEXpZ¥LÌÕ`n™H¶Ö\$7”VZu¥…iéEÊğ†¼B¿­-FI¼B¡Z`;¯x•J‡^òÑ€ôT ¼«† \nâ¶ì#\$şª2M!'ş±Á¬©8ÜkIYf8‘ü’J\nĞHzÄ|\nB@=è—,8UĞ:MX .Ş#øvêƒIbµ–¢ËÓD&1û\$Ø,©¸¡€Úğ;” le†ì*'»Q –>\nò ì8TÚ’Qpß%rKjÅşë'd¶Q¡ºŠâU²XØä;*v-5’Ê¶é¯öÊ€.7Í˜_ô7›-h8Ñ\$YŠÕf8†Í£†|}˜Ú/g4âÌ\n¥Zu˜ìÊd\0ä£-šŸƒ«gÛ4ÙÅVa!°\0rn«4şÏå“í Šf8ÉYá¼¢S³ØuMÔ%;C½EÖ…\r¨ôaayZt\rôsoºÉ‹Mj’­°­«\n¢,².½mV´zºí^_ûUQÌÖå^­œ@Yk‘UÙåJ¶¡×j‹`jcÑú³Ä“kÊ9‘¦×|¶€A­UkãLÛ`g	ìàÅ¦`uL˜fu¢ê-k\"D¦¸6Ş*Õ¸-¯mZlİã°H‘i²Adh4J±.¢¨{G7Ô6´7¸8Î\n*I+Ø¾Æ)Go,ƒ×aÄÃ†®³I°°àã¬j!;\"Xévíå¯­ÃL\"Ò.¸6§)ñ#„«G;Ñ~¢>\$hil?^ZœTÂ^%ƒ,WQ*.æ¤RP¡ñj«ˆ[ô¤j„¹}!îJ˜\\¤‹Á±5}~kî¨K«…ÿWY'®B”J¼«½‹ƒëc\0àÜR–5¹Ú‹@›	Üvâ× °âí‡ÎŠòÜÆ‘ƒ½¹­Ûmùb;œÑöæÖ»ùì6¥\n´dğí×	â€amÈÉäYùK²¥ŸñwÃYO(îSñ4ñD\r¥Yr-™@€Ö-ôô˜¬ğçn±xªıŠñÆöà\n)¾½Ğ· v£¼øº&/ù›Œ¨•€\0ºqİv5ÚbÏÀàq«ŒH”áN¾}î†\"5›ŞŠZùƒ¾´´*€3´ïÆÿ¶%»nk^ú¨RäB(™à&|T‚7ª.Ù•ü\$u¯‰t»úÛâÕvúÕÑ\0Ët`;Ú©lUï¿²ÙÕ€Kı.¿·ú¶Ï@ÈE¨·Ökô¬RˆÖ@7_ä Õÿ°HC\0]` ©Ívı­3¯ı€UÁZ÷S fCYlÛ×`h\rÁÚäß<Û×4™ÌÈ‹y£–ˆFoé„oàîÚVãÀu”ÃYtÍ Fù¬0Ë‘CY2Ì\$Z€râÁ‰ÆáT\\\r¸|(óf›(Y¦Êvi²´Ul±eGıYŒKRP@@ÈHA'~á—P¸vŸõarÖù0àm,@‹ÀNù\"İ€¤)¸Ğ…ô‘YyANÒ%—ˆ0êï<<„ˆ\0tÄÈxÄˆ1RY|Bÿ k‘¢5á„IüiR—.EÊ+ho!F{Ğl®UË‰]¤Xn9]pÍˆ_ˆË˜`¶âHBÅÕ^ú=‹ü«½\"z7©cŒ‚\\”ŞÊbÔxÁ.…fyŞ½ëE¤ï2‡¸ pÀ1¹ÀXÚT&7	+\\i’à\r\"ÿ¹<c±´!ñ\$tDq9‹ü	Oğ¬ñÉ«~-LM!È{€g|#ã¸¤¶9¤\\v„…„ùÇà¡š£%H(Hõ¬Å˜œôEœ ÒXÛÈêÈ‚0ÛŠ)unIØ_K,àn¸…ÚÆíxµl%[äKFçÂ=—€ïf@ê½áÈÊ0€{”Ü#å0ÅXUÊ~Tå¡”°7a•9ZZ{ÄQs†\0£j0Æ)û’\\úèAo-R/cÂKÀğä6Äj¨²Æì±ã|aüË€ˆ@Æx|º²×!aÍ?Wˆ4\"?5Ê+­ ıÛË—qk„rÇ8Ã!¶4ßºğæ¼–7Â—~p†‹5“¹ˆW®àÙ¢G&ê;ËvGWz+`¬ä=Ê*\"ø}Ï@HÑ\\p°“´Ğ€;™ìèfy¼1Îoç‘œ8èÅá¦ğç¸4Ğ¡N(à*~r†ê 5g6{€{?©àæ@4ÚQP^câÎõ '­<‘yªzvóÃ?«f`äQ¹óÎé‹Ä;éíÏ¤ş³ÔÏÆ~‚æ\\ôRt.¹ÖsÒ‚ï|€h!ÁH`‚˜p.>¬{3ŞÏ.;àú©øÊb«ÈŠ>Ë	é1#BĞèkR’-İ	O<awæ„j©…ûrĞ¸\0\\Áïô€\\¸Uh‘(xªÅú\nîyó‘læ 9éåÎ–u0ìçBYÃGyˆg¼ãO^wa:ÒBŸóµ7­&MëIÚtïâi\rØ%ÒÎ€sÔÆ<öÍ¡9ï<|súüı„¯?³êÏø]…÷@9îwÂŒx§|yëG:;Ñîg½¤\r+hPËšlÒ6–ó“ºgºúuŸŞ|ç»FP»j{O”Ğ şÂíAÏPÂÔDğ…Á£‹fê3GÚÓHİH¿¦İ#Ïh¨ú*Ñf‹˜£hÏJ”UQ¹àÃM«K*|sÍĞ˜i“ ùßn†¹óO¢|'ÕXZë99ÈV—(;úÑVšUÖ.}ƒ¬]g?\\zÄÒ\0å;]JëwRúpÔÎœõ6bı;j{O ÓÙıuI§ı  rÖ„Àß‰ßgs\\:?Õ®ÁÀÕ­ÌôésS™òú5÷ŸÍ%O£O‡ƒmØOy®°÷BfùÓ>ºóÇ®Uú‡·^;×˜è=İ{lS»ÓÎ¨v5¯í\0lü[×~Ásá°Fì*{@,(ÀzA=“iğkiÙZ˜´¹©˜l»NšøÙ}5ùª-œiù:€ŸîÑ€¶ >Ğ»Hª×n‘İ \0¼5¶9‘qê\0]cp=´+%9xÄ!¶ ëÌàDx@^oƒP·a÷ŞÙ5O¥…A›m wÜfI€g·@3€¾@À/Á<\0Âí\rd>\0/‘äHFİ€·p\0yÜ%âImq-&ëmxÛXıŞ6Qı·¿n6<ÄĞ³w#·}ÑÆÈ	L\rô` ?˜£âPÀ\"ê²X	ùØNŞ§b)Mİ„wËBŞ\0k·†#°2€¾ÄA¾ßÀc»­ŞoM‚\0/Şõ÷‹½±Ço\0.ßbß÷Á½-ßï“zÙ„ß9¡·º8öÅ¢[ïİîüwË¿Mìï£{¡ÎşNp-şoˆ*{òŞ\0\0^óÔf„ÃÛÚu6÷£e·Í¿eßyà'àÆİƒÀCş\rğvÌ|!ÛèÈ¤¸®mû¤áHñoB}ïÉûû‹Üh÷»mÉKr›–ÜÀt7¹¾ïû~{ÄŞÎñö-/ï,eáÆÛĞuŞ<ğoz;ıŞ§7ÍÄ]äq#‰[Í”Å€ŸŠ|\nŞ¯x‰¼n,ï+yœLÛØx¥¾!q›{hâ?¸–m€p|oß‡wÿÆ~#o'‰<kãÀ‚ë%€9qóŠ›ããÿùÅ®BmêPÂäW8­ÀîGñÛ‹“V˜dìM]¸]Óë´AÉ¹ÜHjvÒ[ 7¼øİ Ààóˆ8¡*‘hÆËÂà4òÛrA]İÉı¸Â\0€ˆz6@A­øNc.Oi\0ÂesØB\0O–3?H€|Ò&ƒM¬1yó/pàpæt\næ\"0@ÇC<>ÜÕØE¡ıŠØ9\$ç<v’lâ7Aœ!Èc&²¹®ØÈÜÈcz<ò8€C\$NDÏàÌ˜	€N:N‡<à2èWD‚H~`(\$üàQ\0cîôw¡¤%`ÁtÑ„4+-ì\nÏCE\"×^Œà‰¨æE¹R\"Or¨„”ÇNÂ\$Â­òÂÕó	ˆ¸´NŸ™œâŸ\nÈa8½Å\0>•!Áé^–]w‹4œzÂˆÇx§Ôğ<óŠ`CÏX·yÅ°ãu˜ ÀËø€ùĞ`4óÀmä@:Ñe^¶¬HDªä˜jÏ/`>+X‹ÃÄëäÅ× 08—R¹X:°Ânœ·}êÕÈ{)ÓFŠ+²ççÍ%\0ñÙº˜—³i„“§VzpãÖö’lDíJaq˜˜ïÈªí—kS˜Œø‡g¦m»à”ÀŒgs‰LC½Šè\0Ğ€\"à†ÀÖf)Îúb´ğŒô×«IªêVˆpK\n|9}A2ºßù¨6RH†:£TLÚ\$5N:õ?½5…\rŞ+÷c¯’vö~Â@÷hJbŸ¥}Àì¨zÓ†7áL<‹ºp—jyÇ§Á*€ÄõjA@dë\n\\ó\"QûYVz‰µo>ñ’ĞôÄ\rü¶fYqN@+cÌı«:lr¼:Ø‡X†>1xvq‡ã?tBÒX1wM|!\"Şé‹5Ñ@|Çğ¯»zI@¯¨#¢ˆßM%†Iáø¼p8ó!'‚]áœ@-€læ+äº€ 8S÷º¼\r_N1Ü1‡Ô•IÿTÂ9æ}¦	€|°y|±İò2:÷ª8H2íŒ&š#¤…•”Ìnİ\$ÆşŠàşa@¦ëÜaa± Ò*Sòw@Ù‘OHXjÃ™ÎY¼=–P…”\nâÑ1ONW„Q<ôÍf@cÄ!t@DFĞC Iò©lıb[b]yfäór\0ÈüŠfÄš}Z2a@b•}‰ì`•â-¡õ(ø§½ŸìpÖo£Øaö/¶\0Èl\"³/š|ÕĞw€‹Æ,ï@	é×´î¦—«S=cÌ;9·¼EşÀ×xh\"\"ÿ£Æıìœzùåw½8ÌÀ|VšNŞùVñŞP\n×”>Ánœœ\r¹”—~\nnMQEv¨‹â\0˜}˜Cüâ•0¥ÈC[î.3,rôÀ)ï†P|º¢ÜÀÌ%•G)ïÓ>Sà\"GùvQÊ?è?ÙW ÿó#C_ÓÕñô ¿øÿÃVƒ\"Ğ6|³ÈßO±çÌ,«õ@6|áh\nú‡Îúãî¦‹Ú}=)°G…?Sz¨öé ’÷¸”ês¡ü¯ˆ«âÌÿ¼rÿç¬øù‹5éµ\$·Û;uš ‚ú¼~÷AG¿øOzE_‡÷?âBæ!	ş#İ4ıü_­¼šm‚\"U›ğXÃ-±IuøµxÏò_†ıèÿèÿÒş7İ\$ªıÁêÇîÜDf'1aíî÷>B\"JG\$Õ±½LÌ°…şöä^üW£ÿƒcáşñüûş=]å_æöŠÍ Lûp„4>yçım„Ö<›0üS…¢×÷ÿáüê¿‹şOßùˆn?éù£Ãhzqf›cåÃ(òçN‘»\nÿÏwBÒä‹ÿ„[*%S*@<¬˜ÿ˜ß\"F„	\0C*Ïù¬n*Ô¬£À	\0hOá@'\0ÍÀä@ùû\0İ\0Ø¬*¿æ¬À\r,¨³ºÍÄÑ\0ÄöcİO@Tèàíì\0Ø6°;Õ„£82È€èÉ× ‹€Ø³™×¡/¾jØåàú»V£àT‹*\0 ı	™dÔ@\0(	ágŒ		»z›Ÿ/(\0ò(ü¬ØŠ?Î0\"Œïl0%n\nô°5€Ë\0=<€ÉKêàî!éh ú\0İÓ+7,Ğª 2¬DhÏ—~ÿdNì»€ûòÊ®à,çc·£ \0èğìH;€ªNŒ6p¾)„Ğ5‚#Ğ-†s±HÅ2³¡ª,b»âÏ³®P*n|†â_ğ±™ˆBù+¶¯9¼)h€Ú¢x²ª³µ\ns+Éîs|øÎTÁx*ÛÍn©z÷R9!¼ó»íz¸\r`–ù\0QK2`»ä	¬½àÀ>P\\±¬)Z½8r?A;VÀ°tÁ†H2>PcAÖö¤&ãÁÎQ`&'Ÿ(ö ã`©Á@ıˆ€):ƒØ!Ğ\0î£Ãï}p\r‹¹à‹¾ (ø•@…%L	Sµdh+:ŞÛğ/‡CİL±ºjPx#ÏÁ¼óõ·šë\nêÌ‚A½ƒëÏˆÁ>D%Áa¨~éÀ;\0Ú‚I™lÏêà“åÁ´>)0°•>\\(ğP–ÀÜÂğï¡„Ì).å n=A;¡¤Bf`\ra€b‹ûP=ü\0E¯­7xkêĞ­¶ú’Ê°¯€Ù	h`1J\n›®/\"¬ªæ š–dd-oT3äÏ¬Bf%Sëœ€ñÃë‹Bıä0 6C\0şØ\r>î é ÖÂ¦Aœ/„=\0ç\n›–€6B¦Å¹Ààº–Í@>(~û¸@•\0ÂïP*a/¿¤9‹Ï@†\0ä›0£îŞ¦®¢°Â¹ìÌ< .£>Lï`5é\0ä»ÏÆ*ròxBn×Š<\"jÅ£?»BÆP˜æû3øAºvşCß°„!°\rÀ\"âéĞ…À‰>„šÑh`ö‚U@HÉ:PóÁÚ3£ëí>¡“ë¿¨Ÿ=Ë2æÉ0ú¾³`>°Ö\0äíà®‚·BêC\$~ªp¼nÅ§Â{±`8\0ÈËÛĞ=–ÿ‹ÿIChÿëĞà2A:ÿ˜£îÈ?æõóş`ÛÃ½’›w+şhLA²¿æ\r[×Áª7*crã=·2½(0§†/r+¡\nŒøwÓº¬ŠChŒ‘h‘\n3`HQQDˆZs€ç?#2Z\$\0ºp)	º¬ü°„&ãÒÇ€,ÃTü	ï	T˜	­¹¦b 5‘1ƒë(.ƒA?ğè;.¸®\$ZsÇ¡	Ãbü6 =3ã\nhBnÄ¯è\n€!Ä²ü q.CüP÷ÄÅ\$P12¬y<N‘5\0èèM‚E%¡uq9êèÆH¿É¸n1CD½	º¼E†ãp\"!¡E=8\"QK?Éƒç¸Å:ÿì/‚¯\nÀÿ\$OÏT†ã)QCÅIÜP10©!ÄQ±3EU¤X€!Å+tWqFÅ3LVq4¼Úê³†hø±j;¸Z0vŠÁ¨T •CcÍ±N%ú¤G¡\0ØğªôAXDy 3\0•!„íÈ#h¼ÚíùfO*‚T€!d¸¾Ğt]x2õ[ìàøEİ˜)¹—l÷Zk£ Fc¹(ª…¨«áÈ¶‹¢EÑl;^³§nõ\"ÿ .ìšA™q#¾®‹ô!ò¦óhãl%\r¤[€àŸ=äe„_–R±G\$0Àë9Í‡p¾K™C^¹D×8“\0-€@' 2!6*ã9Í¢‚%0\0¤¢ôCşDh„ğY¦\0ï‹¬¥§ğôKf\$ŒêÔkÑ±?äñ2³®Õ‰à<!‰3·ÊU%3€5áû¼ª\rx8/`CZñS¦©Á»zQEpH‰Ø\$ò¼¢U<ë £ñŠ>*”“ãj9‚ô; €Çë.°“¤øú@…Œ¦ãİBëEk(\"Q\$ŒC»Q­<Öù,HB=¨\0ëqÕˆ,]\0=€€‹B\0001F€Íàø@„5ò \0>\0F%X•£!ûf¦4ö2 É'ÚØ»OM¬(@dB°Îy3œ\n:NíÉ<£ñÊ˜0ãë\0”(è©è\nş€¦ºO \"Gº\n@éø`[Ãó€Š˜\ni0€œğ)‰\0‚‘T|)0\$Åèp\0€O`	À\"€®O;õ.\r!í)4Ğ× |cGµ( 3f1ç¶ d3ê!ëØ±ŞÇ~¢Á¯<ÕxÍQG¡lyMu6®Ù¼yê\r¬µJĞ{@ƒ&>z?îÅ\$N?ó¢#ïÂ(\nì€¨>à	ëÜ‚âæÃH&CdrH=„1âHVØş²%›t,Pàµ§!°U\$Å\"³e „H(Ú’æCÈ/ Èê!§ôÏ”w‘ßH¡„CÌ61!chmUy\"ä†MH¼Q¼ŠÍt(5\"ëR>C”ÀI\0Íâ|J(ÚKl’%B” Š·Xm[mà<„±0\r­¼\0Æx\r²K¼Û²»Ü¶Æåw-Õ8g\$˜ÒJÉ.åhAÒNI<d”\r¿ò 7 ¬Æœ–‰8Voì— 9\0[8«’\\#|@,9gË¡_¤D0Ä–ËDÉ„E¤™„ÕIxœ™‚¬\rŒ4ÒiÉ ˆø±‰\0ñ&Ñ ÒcÀY'™ƒ	€Î\nñFògÉÃ&›Q\r7&éx²vÁ;'²g¤°<–ÀÖI´xØª°¤I%Ü™á¥·%ô e(‹–k\n\0æÌˆRm*Ù2i‚ê\rÜ¡Ã9€ï'Èhá=J+(„›ÒÊ/&°QAERÔ™ò‡Ê/„£ÒzJ5),¢Ò_‚HÌˆKŠæ@ôrg†J+K~ÂÉ§<¬1(PàîÊzŞä§Rƒ\0Nb@Ga<ÊU'Ú!²Ê`hPèÌ±&Ôc 5ÊU)ÒÉ	˜Â¬¢+Å&Ô ­#M\rÀQ\$ó&Ğ8‹ˆ+L5GƒI\$niF¬|\0îJ*3Ãr—Â¢‚p£î	J°uå‚Tî\rÊòt¯rÀÊüoèdÕK\nã+ <Éà+H%iÈö#r¬#¨`­ ÚË1)\\¨ÁB>Ü˜¯d\0Z\\Ü–À<KG,èRÏË4Tc¨À8\0Z²K—{¨ÃÒ‡%ìpr¿Ë,±èÙ(Œ’½‘-ã«²ß8#.ƒeVK-øY²à…).pZrÀK—.‰U‰29U+4³’èKs.¬»Òéh][û`À2/.@±’åJû.d²\0ĞDIô‡/T°RèËì¾B=Kèà”¼Q¤+-42ü¹×,d±Î\rËı+’õ3\0“U+ü±ÓËJnZ6I7ˆ|pnY©B+K³¡'I¿&|ÁÓ\0\nÁ0²Tà9Ì2Ãr£K†•ÄNÏIµ\$èøB´“jKˆ²ÿ¥µà‰|—ÒîL(¤º³¸Â“„ğ—£M0\\À‰ÁËÅ)¹'C¤HÈ6Š>\nô§7L¡2`‹òm:\0\0B€Z»ô™ó+©:\0+A¹¾İ2²Äs/ÌµL¢sÌ¼ËOĞ…ç2ìÌ³6LÂ”5C\0››3 ó3LÂ]”DÄKŒ4»ÓL,4¼‰ËÍ(„È“Íã¸sD…,lÑráKw,8JrãÍ\n,Ò®ËÅ1¸BĞO¾%1ÜĞSML\r*TÃÉ8Í.dÓ\"ÆKÄ9nSSÍR¼AQÍA2,ÔN0€Ä,ÖsEMj“xbÁı4´·³ZMTàÜÈ!L…5ÌÑó#d‰à*j²+´“WM•-€\$ÙKi6DÓi€O0[–rºœÈ n@¯K*0˜ORÙƒê;\0B\0ÀM*œ×SUÏ5¸aOb£e6à%R®ÍÀlÜH7*K\0:MÑ2İsPÍÜÃ2µiK{7T UÌ´&¬^²Î@ã/œÜÓ@õ7À#ó}KâØsy³aM`àÜŞ…x†å'3ŠMÇ7ÜÚ)­KRûtËLøÎ8ÛŒ3|ƒêö(²kP\rüÛTM´/lás…£)så3•ˆõ/kRÖK]+DW²µ†…ÍódÌŒ&Q7’Q™m ‰¢B;ÉLÜT•U½\$Ä“RW…%‹—¬CŠ‚(S˜Çö¤»óGÌD˜:MÉ^L›ËŒ3I}&°ğ 8„Åƒ/M/×åNNêaëƒs½ÎØ	JAƒ]JÌ«¬‹D’³‰‡.|ï\"ÃÉ^M,ï³µ„±<—ÓÁ8#Ğ­,¸‰)1\\òS¶Ék<´Øâµs<äÅ³ÉÎİ0ÃÀ6Ê\\Aì¦2ÆNÏ;L¹£•O<ÄŸ’ıKf„æ	\0Ï<dÖ½Ï ãôÂOjç\\öóxË%=ÔõÒKOa>öSËË>7`‰);tù3´:ù³cÏ¡-!»kÏy9ü÷Àˆ9T+H+€ZÂ¬ÀáË§>ÌøS¼Ï¹?,™3LO¡<pøSß£e>ö“÷OÉ*„ú³åÏï?dÿ2ùÏ¾Dş“»KÄÌC\"“¹Ëõ@ïSÇ“¬ªòáCZdûtP;äÑ”	É};;{“ÕÊ`”ÿ³ë¸7@BA”-@ô™¿Ï_>»\"æ„z1âcÓô/@”?ôÉ-@è:ËA4ÅrÂ:xcª3!;ÉıA¥4OUAÍ4Ë	A¡´L;ÄÖÓJúd³™.PNA”“©¹M:¬ïs¬I[;Üë’YÊ@Ô¨`‚ĞQ=lº£#NÒÄà<PİB%°ÉPÏA\r#OüäúŠ#MÎ¡€à=ƒß*àÉ2»Êfkr\$-ËQÛ >ú€Ã¬‘2Nr€¤\0,Q‰\\\n`[À\"€¬*F€Â¢>˜\nTG\0V“U2‰SEÀ#QJ()”Q\0’8	É<ÑX†h*É@¤/EeÔFQBÀ[Ãè€“È	(ı\0›D ,`Ì\0ªuà€Š#­ãê\0?0ú`&€¡E²5cªÑEFMTbQ,\r@)€£€ı¨ç»H !o‘FÀúÀ€œ°	à%¨:¨[À+\$è?]Ãñ€˜È@\"ÑEEˆà+“\n>˜éD\0¾8)\0E:C\0!£DÅ£ıÑª(úò!QõEåéQ•D›9ÔJ§¹D½€Ñ5Dà\nªR\">Õ\"`½GE#\0°¶+Hà[À#Q„~Ô‘%>ô‹Q³HÍ%`Ñ¼€ûÀ!Ñ–L%\0RGI¥\"”Q€E]à'ÑSE]´¢ÑJCƒóRZ¨	”F%E8\nqò¤ÁH]#¨à¤LÅ&T‰QEFˆ\n	<¥Í!€Ñ©J\r(t’ÒOI´|tœQ·KJ@ÔWÑ•,4’QD“È[Ãì#U\rtQQ}FTm+F5¸Q˜?(\nTg€ùK%-tkR‹IE0ÂRQ¹J-Ôp\0V?ğtqÑÊ\nµô¸ª\r”wRñKMR¨>èûô½ÒFU)4¥Ñ•KM+É?ÓV>ğ\n±ãK*7\0)RÑHí2 ÂÑ8 j‰/£^M4}€ŸGíà\"ÒN] ”£º%HBC4®½N¿\0‚Mt“­GåÔ`ÓH:4ƒS©HP	”ºRJ\nNôQGÚ`ú4¬GçªLTº#qå&ÿ‚¬K°À&µ°[ÈÕÑ7OH0£ôÕE%ÔªÒÒø\n &¤T¥@À+Ñº”B7gÒÓDàôe	KP(ı2Ó@Å6°ÔC˜”w\0²%-BÔJ¥=4ÒxÍ>iT€§I\rC•Ò‹O|}ôùGéI#µ´­C`T#Q]ATàS×R\rHuÇİOˆ[ÃÿTwO­# +%MHáªQ?Kˆ\0ÌóE²F#óŞ?ˆ.§QuP¢I9£Vò< '£ÆåJôŒS6>¥cêÔÛN½HñòÒ|êŒ| %£ÇS¥ãëGÂ?€[ÕÔıJ¬{ÑıÑğşUÔ°”D{Èç€—Sâ5uF¤4AµHÍKmÕ-ô?ä‡ƒ÷à?0•L­H5LÀ\"ÔĞüQTŞ•N#ëRgU5!´[Ò³LUÔ‰½R)#V>ÚDÃ÷\nüÍ¾¹MÅS T¶?İKµOTÀ%5€(Q3DİµfÒ¦u?.ÅU¤\nµEôŸ\0‰JXcïÔÈ=TµSÔÔ?ZõUÕ[W--uYÔïWA0 #ÒïVíYÀ«Up>­\\´Ô€®ìp¿£‚êØ	• \0â<1ıÈ‡ıÕª?€	ƒğ#‚?ó£´uT}J­'u~Ô2ìP	@'ÕöX	5B\$0}TGõIhûÔa‚­TMˆÖ9I8ÿU“V:]PUÖW˜ˆáÓU€u’T±H3Ñãñ#sV-XõNÍVUTÇµY¥-u¡VwW•a’ÒÿS¸û	;Õ?ídµ¦£YRm?ÔMÈ­øÖ›P¥h”õÈM-gé¤§\n”ÇÍ@\nTfT#Eê8ƒô€¤ô}m`«S£K=[õ¸T:õ<®‰UŸInÃõ¼?||ñTÜ“¸üõ»‚¬ı?Ñÿ;[ˆhë¤iUú8‰<ÖûPõqµWÖyTİY5/Öƒ\\eUU¢×9\\°*Õ{W[õCõcW1TísU0×'DÈ	Õ‰Ö\\5#À)½[}tuÊV‘¥uu‘Ö¡RÅGÀ*T]¨[ÃïÑ9Tµw £T­buâÒxMHÕÑŸ^-YUmÖ\rRjP5ßW¡Z­fƒôÔg^¸4M×©Qıx´µ×¿^µxZÕÛK½x +¥r8 #×&?=ô{Î”£µªW»YúQxÓ7^Ã Uö\$T”\rblV%Wİ)îÃ£ÇRØüÕ\\¨Ä‡ÈÕ×îì\r’\0ø¸	ŒÒ‚³±À&ü°j”¿H…_êL\0P5%ô½R‹LˆõWé[-|Ñı€§ì~Î¨€‹X˜úÍ¾€›Fü(ì\0˜?âCUWïK*82!½J­‡•GÑj}I¶Ö,‘ j€¤Q\ne!6#RÕR=…5Ö§Nú75¸X¯\\l{èÜWRj5”âÇïDz<iTÒ>˜[ÕUn…ª#ƒ[Â>–XÇYª=cóXßbÅwÈÜS5Oõu *€ƒT=dv:Ø'F	oR£Mõ5|Ø]IÕÈ€¾\r\")-ÔhE?ÀÇ¹NıEªU€ \nà\"Ñ8ë’>µ¼#Ydí“õ}Ñcaee€'T¬tÃËRµATá\0±Oà\nGÙOdM–• €¯d%/¶#ÇP…MTdY.ZU4wXMÖPYQf-(6[‚¬>Åõ|Èfˆ\nÙ˜¥”õ6Që°ú°¤RñH‚F4Õ×™dÒ84³ÒDL ü@*\0¿`@úÖtRAH\n5õKÙÜ‘¥í¥F“¢4ô\$À?-Ÿ4OÙãQõŸÙ×`• V}Ø\r±ùÙïf¨0¶ ÔáH]À!Ò}QİOµQ™Sm›CèÑğ?0ÿµ6İhõ‘ú¤ÁZµXù°êŠ>µ€…!C÷V9T½`”ÇWbõdµ/¤4>²CW`•A•XkFE6×Qš7 Ú~“K•K¤ÅSŒˆt¶Õ\\|~–vÖŞ“Èû•ÓÕƒj³Ñãü€²øı\$ÂZ«jİ†ãëÚ zLTfZ´ı†é.Ux\r«tÎZÊ>â9ôÿZOD€4ªH‡UÕ­”eÚáhúDÔPZÓe¡0Ãî[V¥®öÁ£ >õ^õf¹cóÎcìß`Ì‡”N\0‡iÍ¯QùÒ\"\r‰?Øp0ú2\0Œe±ôU\0>Ğ•~[F ­Ú©i5Nö“\0‹_‹«uº·Q`út«ÔÓS\\{ôyWZå‚ #€ıytÂ@jè\nV´>õ­ÖmÛ‰n5­Có[—nM•øÑeGU+ôuUKGUTuTÕ\"avÚƒZµˆ0¬X‚èmˆ ÑÔ¥´¶ ÛSb	õ€‹DÏGØ%}®‡\$e\"U6ÛñFRPN‡T5YUŸ %º#mÚC\0+Û€L-¸N·×wn,~€&\0¿SŠ6Ö¶Ôà> ôŸV?”X.·€’ ˆÕÚkJ8”çZÃnE¬–mÜAHº·£Ö²N–[TcÕ”æSÅN} t‚Ó¦’åP”¥\0\\#°õá;N5†ô|ºíF†4ã\$Ä>ön\$L>­»n»\\Crb8–ëÒx}?–×–?•7Õ˜Ò{Iı¤õ™SO½Ëé\0HXåg)\0\\d>ØûÏÅhœ‡öHyYÕŸƒì\$9NàüÕ­»]b5„Â;WhÕ/U>\rÏÕ0Xµ\\p–ãZÅqHÿÉ[¿[|¨ÜT(?=+U*<çJÍÊ‰9€†èİÒto¤ÿIõÈÃÓ3]ígôo×Ô•ÔƒÓ3q¨à/Ö›kµÓ\n¢èùÑt-±¸Q¾ø\ncùR«uT~wV\\_šPV¤]MÕâw\0¿X­_u¢Úıg(útfHsL}½·bQKH=.µwQÓa%4d[ÛJ}*5şØ£_íkÑ™RöÇëmİJU~ÔIR\nV™ÇûGMİ€,Ûë`¥“÷zZOeÚ?V	Óšå›À>\0²>Í¸ &¤ÅwÍ#ïTÍOJ÷\$ò´\"O@ùó[¬ª]`1¤‘l3Î©‚èoÜƒ¤²¨#ÅŞ‚ëä\n\\ÉÑğa+*ºlîH: Úƒ‚ômg†;yLÂíH#±{ïÄÂqÒ>c,OTÌSâ°ñ%è/³@¾!Ú<é:D&óxAÉzXW§=‹z\rÀ<½˜Ø=ê€<„‰óy³„\0éØ6 4¹zíã·±\0ÛzÚL 3Ş¯íí7­„ «üªN\\ïHfñÌèx¨u€Ï	€\rªÎ‚¥*“§w¿^îìï¤iŞÿ{Ô&¹½‹KQÕ-µœõÙYßWÓ¯€ˆ­à<Óø?%·\\²\n`+TÙwm‚¶’SüĞı5HÓLu³÷%ÒIN 0 &ÓkEóV€š¥Ñ©0W[Å3àÜÁJ\r÷6 Óô]¥u\0Ùi}ÅØ7áXç~-pèìTPx0·àßw[•÷±ïÑ~C£·å_y~4€©A½~°	ì_uPú”QQV”-5aè0æ€ßìÙ­0„`º,yˆ7.Ş:© ~ˆ°T˜\08*\0004Œñ7…ä+0Kœa’Â`]£Âø\"~î|I±ˆ­Û¹à;;Ì²©5ø„ïTn¡CxM)8ĞWÌ‚²¨D.Âˆl\"O×#æ,=|üoeÆ2õK\"íŒag<\$ Å8Ş8!KåÎ´¼d¨\"	ŒZêP%Üş¨.äÆ? 0+<Œ6ïè&ñ;«”º{‚ìM –ŒRZ#&1’ÆPméÈ¿rü›ÁOà|ì^àÕàShõªÂ†Sƒ¦A3º~éS¥.úº\\’HT—ƒ¤¤Î˜¼4Nøn†ƒ[;ˆ>‚U:hé³«Mºr÷N†Ïtè€&® <V¹	N¡|HÊN¡º„»{Ê¯Ş0êH.¥»ëƒp8£‚¼n\\Àåÿ—zÛìD„šÔ§y½R£½èZÌ-º“˜¨nZbíàO†I‘ÀÚá’ëAîÎ½á†ˆgëÄã†xgót\0×†À×£½LÚ7“&´ŠU9î	`5`4„¸BxMÖò!;ÑŠáÈë\0Ø½S‡­è>¹<7¨DÚf^ÏbDqn Pé4¦‚Ø(ş! Êk´?‡æ!˜š2­è°â/‡ Ç¡òaj&#2Kakz8b^ŠZYø“Ş‡‚Ì_W¡&\$Ğ@áÜıÃ¹8™U€úX›á¢óXÊ¸Š	U‡H&â]‰NNjè^8£\0ÊXgøo\0ùŠvØmBî,DÁM‡2,D08Taª^1úãPš5ì\"eÿ×Ï\r¬ÁònÖ@¢ÛŸi3¦?‹KÅ‰B\$Z,…¡€Ú ¯—zÃ(à%ã\0w–%x–ˆWŒ+\0ââÖÖ'ø¸A	‹`68\$¢¼îkx’÷‚†Ù0%(ù.[ŒÄğ«ê!;\"üÕX\"Ld¡ü6…ÏXM4yBƒcú­âÀíĞ*CF@“ŸÀ ó5á\0¿Û±lÄ<é…ñÌ±AHF›ğSñ>î\r€JÌĞ»æ\"øJÀìßßŞPã•†ØJxß†„M,ª±ÎÜTèg™¶²ªRCƒwâÆ#„c¯€>ƒ>\0êMÊ¸÷ˆR¸În¥°@/+À@;CŠûÙ†êéÆ+à<FÈ»~-Kb„t+*Îã6®<Ñ&áıîà:aS“mf?–m^<>á¹…X”ƒhôí!›Œù;L¡w¢PŞÆ\0—©:Â8à5Çlğà²\0XH·Ç…¶¥;ËÎºæ™PÑätç\$^ÙC½ƒy®…·\0è+\0ÔäŒ#ø\$¸ÇØà!@`ª\"&	îG—Àd€eµÿ\"8˜ùsØ šbx®IÎï„¤÷*öÀ:†€Ğş <\0Ñêy5¸’êXÌE‹Ş!î+†¨]è;ÁdÛcuïWÎGzÓä 9…œòªAB.^Ÿ<€ßÀ¶:lƒ8:zë\n¼·º»tå^j\0å,ÿ–SwŒ-û”Üq•„¦Ä!o*¨®õP74åD¥ÈYÑ¬ˆrê€9!åZ×x‡0ˆ…şa6—Å;;yÀ\r·ÅK3{”â·ÆaÏzÜß9aˆò°‹ùc^¾\n(6e^9”ŞYÎ†o^Z9h&µzŞZ`<å¢B\$[–ÖZùcå¹–ÎZ3|å„šÖE°Îå‹—FEÙd]—d3¹fe“—†ZR©aÏ—N^¹jeé–°%y|eÉ—¦[™oeõ—î]¹qå¿—¾]¹]_hc·ÁÆW|(#™‡Am{öTˆ_ÍïaåA–Îc!ªF´ ™Eÿ3@ï ”ÍŠ€Q \\Ñ Ÿ–…ä´D‚QIEdã¢]f\r“¯ìcÁò]ğ!ó7fjxFgáÆ`N\$GE´!?v'^g2¹Ç_\\t/à ošfhR¹ÇC¸°î}æ¨!14Y9fd°#°ó®™ æ¹“S¹¯æ”f^kc±.A°#7‰	FfÂD™›Gi r1KşY¶Ìe¡deN¢u›6#€0—•,®!Îœfü	iæÚF€I€ƒC\0>qùÀ„zhA<•›®p\0à•:(øƒĞg;h\rñ\0Îb JÀ‹â‚¤yÂ2,/şlq«¾œâÿÅ]†È¦nŠOfìËğ\"€ºç7Ökàfá	ÍÙ¶Êª1yƒ 0·…‰à7Ouœ\$÷Mw	-œNzUg¤bÇ9êçOšîm,æÙœæz8æ×Ös¦ƒ“\\Yãg­Ÿ@Ëç‚øp”¾\rÃ€àëNm´“¥H\"\0®çâã²Èç£Ÿfwùœ·^Tæºæ…D3çõĞ	\$@y¶ŒŒÚ¦v\$:Uœ#ıï]„¬Ä4z	;:NãŸÏÄxŞB8W¾„¹Ì´M.níwæçœ Hú„îPæ!½…›l\$³@cÃƒäv@x†*\0Ù{Ü½ÁO\nÈAø`™J¡ú+%\0»ğj€Ö¢t÷Z\$™KA!Ú+\0º.V‰Îiè¥67ñ@äÕ´]z(æ…ˆhØ;Oá¢ÒôB­èµ¢abç\nWŠÇ)ò=077ÀßM2Ã˜ÙãÉš«#Y¨¿.a+zÃï…æ‹ãƒ²â¾w˜¡>Í¢ø€eçL8T:/çj7º/èr ˆ‚µ¢79ĞŒá¤ĞhAh86Îüf…× äcH Èjš*è7†‹F\$á¢Ñ5Z-Úh•ZYh––+À‰g£¤PD9ñĞ7†˜aké‹öBæç£¦dÅ:iåTìfk+°_úkæ¤ûVšÚAÂªÅ`Âè¿ˆBÀ©¦=*ˆ’Øü`åV‹Sîƒ5¢v‹ÎÊ¢#ş‹C¦cÑ Ö‹XÁà–Sş:|Ä)§æšxc…§v‹Xèikêú5èœ›–À8hµî—òA%¡œª¡´©,)†ŞÙ·@Ù„¦ãƒ­x¦£ªßf²ñ†£ ‹‚³(\\ÕA.ÎHZ Ñúê\n–Âæ@è£ú7¢«„ª-=}¥®&?ÃA¨Z-Sƒ°Ñó[çNá^XÔ^Ã\0NºZĞSy&yÚvh†]ñ“!iÛ@Ö˜Q»N)4APŸ(â†‹C|è´æœÊšw™K¤Ëú|‹ÿ\0:Êšv²ã\rÄ3OW‰Ø§Î<,6§:…ƒë¥Ádt#`€«aÅjıª&°z¾j‹«ğëš'gàî°8	ºò„	:|º÷„¾¡îÓk1¢p¡\$éBßª±”²×j\nn>‹@‚Ÿ[¢t›Ïui}¢{\"ú-K]¬Ù”°àu•®îœ€ï§ÎVaâkK£MÑÃã»‡ö¡úaü\r‹Q­j|ìEÉ€É¬°@˜Â@N²*h©®CèBë¢ê©r…·…§l¢Ú-cN8Cü*;êÕ¢Ø\$/¯«#¯ºÜ|Z&¡ºà”İ«ÆŠ€ë9lúv½º'c w–¾aPêg¨v¡zîëéV©Ñ(hİ¢sÙú¼ëõ¯”	Cáhµ-´fú ºqI|25dEÚˆK\"ãPß\$Tàß:F2äòP5©àY…Öºc_‚\$šÑ¼>A±HE¸5„‘,cÚf:‡€ø60¬lf6.†¨\r¦èÅø\0j`d¶©X±uæ©9´g@¬æ9Cç£€FÉYëÑ±şŒxì \\ÛİR3¨dt¢Á+Œ1²†»@‡éã²!’ÚÙLÀ36%X—ãÜ:C{2ş%VÌX5ì0»°#GĞ[èa€ì¿ªA’ÔäzTæŠ	+4ö„4~?:çMñGõã_ætfj³5iÚWÁA´|çúïÃhğØŸ¼g¡kæ¹š³‹T«ÙÔê†`!øeŞ~+&b_B*ñ8„ø£íSy@~î(c#x\"9ÖêÇş€İáu ‚Ê»[ã\"ĞØ#9ñ—»¤\$_ÓŸé¼íˆ5ÎgLÏ¶®šçI¶vv @N=âÀ¬„ï1§»iĞŒ&2Nš£@N6Û‚í¼K¨£úsƒQ©\\çûZÄ]¶œ{n`k«µ\nz0mßŸfA †‹1&Ûº::Fg\"J N8Q 5Œçœö­;hêğŞ-›ƒù‹¦ßA+ÎÑ¸P`Xiaõ?o†î+†R ‡î¸kxMhÇ¸Şßù]n!šŞäyî ö›hë <¤[ˆL×2ÎâÛ½¾™FeîP~››ãeªq4³üC·øøë\ròıfßû–î“¸<¸xàø®¯zP†â»ßoDà!¬VXóm%	†é»Fà‘´±™{¬Ë	º~Éùn½º®°Nàn­^VR†hëµäIÅlºüŸÀ>S¡®-[l´ˆşîCfešö™›é‰·Ø+Úõ¸Ê»¿nk¸¾Yñï\r¤YàQ‚[h+ş@İŸ.ZGcÊÁEmu	q’Ó FøˆÅ;\\æÆ±½ê{%º{NÜbï-­¶tµçË¶¼õ;Öl/V„ûÌP£hìÒ²c›æ™»H‡ó´ÑÃmñ½ô½:fí|M.†!o…ŠÂÚTĞ~&šQ¦eø×ï¼sZfì÷¦6ß³g˜NèùÂéš\$kèfX^Ï¾vß8¦=¦~î4ìp¦yƒ|é›¿X	ïÜ2ä_ªHm*> [|:2æ©šfãw»>ø»mƒ*®ù×ˆäKœ.<YiÀPCÛ{âƒ¿¦õûêp 	d_°†ë?s§|•w°›äï³\$èJ|ğ)´fîİğIÀ^‚yØ¹¿Àï¸tiKÏ‰Iot\n”'8\$pQŒ’ü`‘¡–í˜èvà&•<!4‰¼±ÍÎüë•	ìŸ¬K!p5c¬œ\$ö¨p€üé!ÂÙÂf¹+\0+»!D<ºTæ~FàgÁŞ™›ò m¿6•»É¬	T-#+c‰	€50ƒ«¾Æg=¸˜öºip¦fæ{¿ïw;ÃáüUŞyI=··.æšEñÃßºb¼gÄ.‘`;ğ‘·b½S¹˜‘¼>çÆ»nˆQŒïËÿán÷îî:‘[º¤M_\rTíc¿^zÙı‚¼î«6:0GÄêåÚc#<\$øÃğ×½\$äããÔø©¡¸Ù°.t¸ŒĞ[¹|;ÏğO»~|r%.'€Vº†?L¥¸Ğ+@Ø‰ ş:¸.cz	f&Q=¾ûsÛ¿ñÑŸzåPINÇV„üiYÂD@zèÄŒfòdšù/Zo¦g¹¸è]›Ìt¼Sâ\rfü‚ñ\\Ãîø™a—Ç+>8““K{è?ïuoÿ¾–|z•w(e\0œO^¯Å' …r8Tç«­ÈÎ(3J‚°ò~‹}I€Ò¼^c†0÷ïh o°S\rç\$¦&eòq¨öp.™qçµæÆ†éu¿(Ú'Ëœ¤Z]1Z'):µ‚¤ÌÜ¨€º{ñ<€¡ª¾A?•)™d`†‚\"ĞÔ¡rp`ÂòĞ%2ù&É³xDHËÒ1\rÔÔŠªH/ËÅæã§|D`©*|Í~‰Ğ‡Ÿ/¸´DUB5²G¬­à.M¶¶¬e1\"n;7üÉš0ğéîrù\$_2<¼!èhÂŠ\rvs=Ì,‰’1¨l¡§|»ó-ËÜƒmNòÿ!'01çsKck‰áHñÌé“&(\$4‘PóGÍÈòH¸h*àm€:a!\$»‡6ô£»æ¡ZŒiD–C7JKclœ¼9Hİ[…ÍÆó‹Î<êüä¶òo\0ÇG\$Üë³†K(pËÍÑJk17=&‹Š>xÙãôK8H7>,óå1Œ¼ú‹ù:\$¹3„ó?’ôÉà?@3ˆOu.ç@³ÛM)\nA3â	•=™ónjØa}Î,¿}Ï£1¿CSî&¯Ğ·?¹%•Ñ@X—Y=ßD“ˆmN÷C³‘Môà/E3Ûc¡ÑhhM\r·±Ñk`n(tq'84Ò³ôc>&PÀ3t[6/Gn‚%%åês}Î:òSó³Î gã+1Îën¼åsÁÈ<\\çÉ6Àxi8–œ\rxíÑLù4xà*€‡ÏR9\0	@.©n¢²Bs?9bE›Pˆô‘/(Ù7ZÛh£óy–F˜:Ó!OÔ&¾]AÏu¤¢6P\"£ÙóÿàºNø³ÒƒóŸ@@iV…£:j‰Ô=s#íÜów%åwÆ…Î¶eÔ¡XmF\r'tí±k5X€«ÕwËR %Z%>öÕ«sGtXW‚¿Vì\\İY¥…ôMØDíˆvÔóÕOV]UØsb'Xö#ÖÉ[úLV¢S·]ÇYög£±[\r•'Séc®¨ıQ€Õ?÷OX·Õ?Å]_­…½rØb>‚=U†Ôæ\nµèğØg`—]õÆÚ–>§[u6TÇXõK’uêàÇZ}}QAVŸVızÛn?^µAuëcçL·röRÅxWGZ©×­ˆvu÷Lİu=‡×-*5jv-ØV5HõëWMNİÕ_==‘€³\"cU[Ö“İ£W!Ua¥¦À%õ‡jm²–œTi­†ÔXjm¿V€¡iet\0õãf…§¢Ú[joi]hİ‰DíUUÇTã×ÍUUÔ»Ú«o½€ÕUIu°–¡v‹Ø=V´’ULLµUvcõ¦]¢ö\">Õª•Uv+Û\rgÒ©T¿hµ ]UPÿİÔï\\íkİ¾QoEëÑı¿#WWWn•[WÍKµ5ÎöWÜ/lU¤wÚ-tI\\‘N­W–¸õgk…Wu`õ[Ú5]İ¤UyÜßiuxu¡G__ÕËÚ´‡Óö³Wİ\\½®uoW/lrÕW/lı‡UËÛ]Ñõrößİ×n}ÑÛØÍ\\½¼€«l—sUovCŞ-]’UiWgqzw7G'e•rÕçİğuÑS‡WÅCí¤ÿWÓ±VÏÜ3]½»‰©oİQNÅV]p\rÅU«YOpV7FÜëml•«£YZı·:Øub(üö%ZŒ?ò5hèGåßí•öS•„£íÑQúnÅX`•JTÎÔåİ=áÔƒ×¯w¾WOô~”¼öãEˆ=‰Tİlœ|ÔÛ÷ààú¶x?àÅH<æi³…¯…@ìïWánÔP’lÍ¼åèß\rá–%#íS¯gˆ[À-\$ÅJ†íb'Œf7Xácwe]–l¤ódÕ”vOYT-™•øXok•:ò\"ÙÁ!åŞÅ]Ÿ!ØüÁ‚_áN\0Ha T¼-ğñäjE³UíÑÕfÕ•­¾ö-xEıƒçºHuè[o\ra	Å¯†áõN¿a(òÎa®KlašãšáD]î¥xQ\n´ê.òlq…IE:˜a]ÒâIZædËü	AkàúéC¥˜@ºZéŒ\"0{y9…zöÙ¸`Afx\\º—ËşÚ¾oê 6L½„dËñ”Şñ‚Ş¸`€?—Kj¾së¶¹ïğÀ	¤pX`vò® ºw‹à-™ÓÀv´¯†àŸ‚şiŒÅB›º¨´p>kº ş`¤EN¢ĞaîƒæTdÙÁk²¸m[.óiŠ]ùÙƒŸ#FíŒ.·‡c“-¦#¼D]ºŸ€bøï@Ê¸btõN&ê\0ºë‰¼8•ÀOÅ¾TœRzáÓ+íHo’™TaÃÛ°c„Öæ¸y~	Hp)ç£~ækÌ^Å<WD›>‡âS Ø¤ùãÉòŞ…<.ÔyV v)¾0·@·•&;p-èïÆSbUgï±š¡”xöÍŒ{^*éé.ïë\$T\$Úºã˜Ş[ù¼YœğÏLAôÕš„<k¬:{n”èLømÏ¦^ÜXèz×ÁôßÁfê9‚G­{q^·*@p„@Œíãã`:D\0©·p¸ŸÃáG0Şôs¡ë¹>Ãâò±^VıìåMì†&÷¼{Â¨õ?&ˆß°ğãõö?¸¯Æ±šO´.©ãşéÃ+'^¦éã§×Œ^à#]î˜äB÷övóëäJ3à4ÒÂ;§¾Ü˜©Ó¬>ßlßDî>“ã9¿ç›2Â\0äèo·ÜdƒùîHNô7{ ˜à”ÿºø.°ä7¯»ydE³ma;âS‘<I>ÙäGí²Yù`jîdv!=zõÒÆp»\0øƒ¬Ó¸^í;ï¤úpHà‘æ~hyÅp…ïæƒ^ıs@×¿¿`?ª&<¥ŒË<pIºr„ï<Ô4ã²n?*ŸÁ	ğ~6ŞfãÀ„ú{§-û½_'m˜\"~=QÈ–GÅ»ô8Lñ6Ğ››ÏŸèœÛÀüXU?Ä_M;´Äÿ_¡?Æ|_ªf¿|[ğ×Å/í™©æp9Ÿã²^óãÇGgO,wÉeà@mğ\\¼?(›òtüıIò·É¿#ò1òçË}ƒùƒ`Åÿ&@m?Ì_/aÛ.ç\0ìˆ»ğÖ¤Ô:qğ^²o|ßó§äib\rwÎ\$3KıD“óÆu0+IÑó¾tøvãw-¦ÅDà‘&Ñéqwºç”&KFÜŞ¤\r‡†ÕûÉò‡³±ôÜmû˜wÏ]¿É7L\r@cÏŞLC{ğX=—÷èXBŸX.Ü÷[wü+WÕ 5ÀEõÜ.ÿ^ı?úC\0ñÁ~ ı¶ï'ı“õ'ÙyÓíiÔÙÙÓı£Ÿ<¡Ê|5ö¾p/Šı“(\r»>nãğ^ë™ñıaµŒÖ4ı‰'ö‚ñÇ-ª]? ıÕˆ¸IÆKN9ÿŞf[g©÷?ß]}ˆ1¦|¿\r|^÷¸îüøÒ»ÕpÿÅóÊ¿ğ‰øFüZ>ïøvõ_ˆ~¼H Ü5ş'à›ÕDa¯—ãĞcª¯\$†~CøOä|EÛ²{™“¯=™OS9•ó%™h[´EJçÓ^=áOg£ù¸Zÿœ‹N47ÁAAùçM€–m·ë”\"ÿtÕùè.©òæwWé¢—ëú–ù2‡àEú'çÀ¬…£&(!ÿªï	úP%_œ~›û%…Pg<‘Ì°°,qú`%Ÿ­EÖÉÁñnàhÌ‹«_¬~ššÈ>Ÿ¸ooÅ¿îÀ–~È1øI›[şÕûÿïî“q±kC,ú­µZ³¿I`Êû?Âÿ 1‘²Ç<',Ïñ„iú)©_¦œ•cEGó^™ê[Å7~íx‰@&çÅN|ŒÆ{¶~ÿûÀ¿¸hNëwõïPşôN3­ÁQäT(³èmHûVFİ¾ÁÑ›ŠÁş)Š®VHÌ¾~‹g\ry8JÅŞ…Í»Mø»\nùò°’JÏû,ø¬ëòª\0âÖò¸`ãH€|,¿/Ká: ¸”I\0–“‘½Wña£üTĞ[ÊÛ.İZÏ¾\$Ò˜şl¯ØY¹¦t¡òy5§±çÉò¢½<\\ Ï}á_Ğ0rbx„òAROfÛ6Ÿ\rğÀÑ?)Õ¡àDœªe<Œ”ïª ñŞoª!0k\0…ñ ùİ°èÜŠ  óÄá<\0ÒÇ€¿˜ˆŒ¶ibTTàĞF2Q‘\n(?oˆÿ4ÿxQ÷\0h/T¾³tìs­S Ní‚è£œFÆ½MŠ7“\0•™ö@Qp'Qœùûˆ\0é~—Š€n	}úqö`—á—¹·\"Xä1xBÎÀ/Àm#Áî2ô^Ğ ;@o÷\rû\0\"xió…N7lnZ”ˆUØEõïh½SX?ır 2XK€—é-> ±y<­z‹às\"C6ï0™”0câ°'ÛšB\$ñğS4'\0hã2½zpıù){¡ã{9&\0îŞÀŞã‘„¶Ì[Z°¼ím?‘™€¸ošÔÀD˜Y+ø ‘£ò´6: Ô¨Q>Q¸ïHX7€¦u-éf¬1@>8Nªˆ<òC~¬Î•3‰B6½Mÿkäöóà\n¿RÓe·z:ğ7G\0š‰¥`jÉì€†íŠÙãÀa6äl,cKzÄ™ÅÖ1¢uÙ¹|vğ9 +¿àg¬ÀÔø«=„ÎsÜ¸·‚\$úİ÷Kwz/^í¿¨‚0‚;;>ŒgÜo¸É}¤Ø„ú¸²7…Íƒ??NôÆ1¬»=ïö ˜³ÖošdPQGH!ÌéÜC·ÍzXvê	“ô\0Ké†á‚eÄËûÔX(í+™†4½‚Ê\nc|Vz/Ğ`ƒ3ÖiíEö`‡Ñà…¸òcÇ9÷úSâğFß4	‚ÿÏ‹çíÜY!¤èb8ÕzàÇæí·•Œ|•AúXàÙMòŞjÃKpàñ¿ë’‘x°'KáF¨ãUğ#Í¿O¨\$Käü 	ÍC‰GÇõ´Ì²À~;gĞ.>—‡«€l‚ÉÇÒfà+ ¨AA¡šÙî\rÆgà¡ ÏÁ¥ƒTÜ \nôˆ5Ìç‰ó.=ıÍ¾™Ãè5§²ÙÏ7ôƒRÎxàbä'ø@8³‚oşäQÔH8ÃŸ(½¤	4Â«˜9 àç¤Şƒ y1üá¨9éx`ä®7„ñ¸;öî W€8†tƒÈÄ`CõcÖ§ƒ*ÁŞD)›SLÈ>\nŸ¡@Pƒàˆ©5RkpLïæFº“ røì6S¤l/›^h\0xOLÚL¤‚]KĞvo ±aÏÍ’KJXÍöÚ¬¸uqxÁÙøcŠwé&÷.8(‚øá¨[|‡\$MñZü7£F:ÉQ½€„ï\\¡7îœâ\rk…¸/-``% cã\n\0ÖOü…µ/\néFqÖGà“É‚,,«	³y4Ù*¡\$AËgÊ:lãÁæ‘Â?‚„¦9í€p‡LıPÏ\0g„¨BÓ1d¬¦‡àï2hêÎ]´ã73½´Gõ·j(ÄäZ`ÅH<\r[™¹!€ Ñøó\\'ÁlVÂíÂ6Hy±Ál!È!ŒªAh>ã|Ü\$ŒÛ™ÖÁ—i¢à¹ÂV‘’ÍäÍ\"6lƒ&İ¾³fKN˜³o¢âÎêµGÓ[2AH\0ÖÊnÂ\nˆTĞª¶B«J¤Ôy´Ë@ø@'†™ŞB¨€:\n…·ãGX%®`æ ã{ÿ­™ã@H¨í\\¶¤N !YË“Íqºæ{Ê\$g5 \n4Ö’A‚ˆ	\\Ö¤l\0ZlÕÌÈt…Æ×À \0\$'>æ dpÌ§0Î©T,U@ŒñÌa§Ô†`\\È”8\rÆHÓ·.¸\0‡ÂÎ\0Âlù#BF¤ƒ¶Ù9s_‰!¨;ƒi)áq9ºHÿ\r\$Ít2	!M¿¹½P®PÂzI;ã¹ŒÊ7 çDİ\"tàI##İ&§TtŸt1të «RÇ¥T€İÜÈ`é3á’?¢O²8d£°ÌO‰J\n”Ì’´3Ã	9’tC&†ja'bLòLÉß9%Œ87‘í€à8°Ñ0Ã\$L\rzd46“ğhá¨%ÕPªnš|0¡_.p<C†@8áÀBà+©æá«(b1‹\rœ45wIPÖD4¨Y†¹|d|1w'I=SG§]†ÔseCÔ.è`ªa³—á14’áÕ\nˆdhPÇR»#V¼ìÁGºä ûD VÇ‘×v†î`b¬5ŠŸİê;³w­yŞbígyÏİë*ùSü«ínê°ÕqÊ*„Ã.xU¥ù}:¶€@–6,uÈêÙ×3ÀĞ\n¯Ô¡;S¸®ø>Š©g‰ÍS¬Bwî©åàÒ–å^Jû¨©´vÉMÒÏ…:ênÔ³)¾SÔ¢ŞBÂu7j)Ô²CÍS~§]ÙBÍøvªX¡éCÊQk1Mì=ut*<Õ+:íH†°Àì:ÑeM€•’®HZ<´yt»­Õ‰k\$]Ÿ-%[¦´­SòÒâDÊ¤—-=;µ\rÚ{´ÅªàVy¬êYØ¦u|’ÏE ËT–t­	Z\0«‘j²×³‹«HÔ#p©ö ªù%¬Ëe–Á*3Y ‘\rlr¯÷zë¦Ò D \0°¶MR¼ÀüËgŒ­ªª¶¹mso«lÕB;`[r·Õ`Âİ%¤äkÃò­ôX\$¨nŠ¾Å+jUP Á[²¬,>š±Å¼î¾±¼Y*» ìR¢e¾Ğûÿ;AÆ±åOŠ‹™K2—sˆºuØ4FÇnü×«iQÒ·mGJ—ó±P¹@#‡ò\\´F½K8Åè¢®o\$dQŞ\"æWWêÑ—8­\n\\î…v,;å^î°R ,KH†®¬>Ú\nÿV®Üw†t	w:w‚*‰{)A\"ÁŒåZõUˆÇC3H¿Õ“€%1sm“~¦ÿ=T–ŒïR@‘uÍÏ:%¥‹TF{âÿŞZ6¿­êş×o€ù\"I‰2†uû'm‰›]7áF´Ø•€œIvĞÙ§²~{ñ„öØÜsø²\0•ÁÉV½­…9ÔvĞ\nAFP(£ÙƒCëÏC°ÁsşŠÜ ÙT°Œ \nÀöy„C FBkPqm}êÌ•ëòèX¯Ì\\¯Ã_…àê•+›õ7ç'zœG7qo\\Òa‚kGX™OjøCó\0UÇÃ>6œ À[°·4,xĞ5„“w§ÃB)6ƒÃ™ì4¢pOuB’…í‹M‚’…_¶\"N ÍçÜxc%™ï92m\\˜ó>&iUX5Á,o&ßQ·Ãy8\r˜ÅB2wT£¸tÖío¡Ÿ¤°TiJ¬\\#˜?ü‘U!¦hl{QŒ;äÍ¸b’@0…0˜QQøPI’Q›¾ŠÉ\n\rÆiE\0‰HÚ®µNZ¿Ò(è¢˜0‘[ØqôJFÒ¦²lT#Â\"º5ƒÉ¡<W§¿áŸÃsŸm’êwˆ0©m¢H×0î+:O„¿]£P’ÄWAÇÏÍb}¨y~e½\$!\0òÀ`Í	é3x:)Èi2†¼áfšô…ªåúºE3?Ñj¤ÂÏÒ‘æû™¶Ã\0»|Ñ°Èk\0’bİÃP¶’p˜@\rÆÛÑ\$2V~Y¨	Xø\0PC}£N\nØÇÈ)AÑ@@\0001\0n•6X8»À\0€4\0g†.à€`\rÈ‡&6‹ÄZ8¨ Ñz\0\0006‹ê\0Ö/@x¼‘~¢üÅæ\0p\0Ş/Ah qzã\0€0\0iş/¤_¨ÀÑ‚bõÆ\0‹µ¾/T_X¾…£Œ/F	\0rav0˜0Ñ{bí€7\0n\0Ø„^xÁñw\0€2\0nq†.Øˆ½@\r¢üF#‹»~1l^è»€\rã\r\08‹ó€´ta0ñâü€5ŒCÆ1LaÁÑŒ£\09\0gÚ1t^`1Š\"ñEúŒ7\"1‘h#Ñ\"÷ÅŞ\0aB0ì^`Ñ|ÁJ +\0l\0Î1üaÈ½ñ~€€9#ez0ô`8Æ1—£0\0002Œsº/øˆÌQŒãÆ\\Œeª0¼d8Å 	´ÆfŒ\\\0æ/TeH½1€ã,Eï\0sî4,]À@\rcF.ŒL\0Â3´aØÄ˜\"ü€7‹ã2/H\0± £FŒçv0Ôiø½Q†¢úF|‹ãæ0lb(È‘‘ãÆ•Œ¾\0Ğ‘8ÍÀ#Æv1ÕÎ0<g¨É±}@F°Œá†5Ô]ÈÏ‘Š£F,]Ò5,fXÏÄ‚@1\0006Œ<ax™übèÙÑ¥¢úF&‹½º3”_ØÍQ‚cÆœ\0p\0Â0¬g\0àcAF4ŒiF3¼làÑ¯£;%&Óæ4\0XÙh\nÀ\$Œ7–4m˜Äqã@FÁ‹ë6\\b \r#MÆŒ1ônˆË1y£UEÛ-\0ĞÌp¼Q€£FpŒ5b4ì^HÒ \rcuÅô\0Ú4ÄaøÀÑ°cEì‹é~5\$bèÜqÉ£}Çæ/«ØÛ‘›¢úF%#ö4<pØ½ñ‰£Æ‹ùş9ta0‘­#€39ê6tmP‘w#ÆÙv2<nÙ‘´ã^Ç:‹¹~:´ihĞñ¤c&Æ–‹¿–7uÈÆqÀã9Æ‹ãZ/ø8Ç‘Ğ#-ÆÛJ6„`ÀqÆ#o€4ƒ8¤vXŞQË#\"G\"ıÚ2<qèåqµcÇ\0cB8ÄnH×±bóFè@W:\\uøåQ¸ãDÅú‹ã&/„qXêq‡¢îGOŒ›‚9k×‚ã.ÆÍŸ.5DqÈÓ€cyG‰	ª3D^ÈÍñãÅG\nŒÇÎ2kxî±¦£“Æ–½ê;DhxŞ±¶£}FwŒ<\0Ò<ôc8ÛñÙcxÇÉ‹ÿ^;pøÜ‘Ì#pFì@WÁ„lq(ìqÊctÆ;E:8ğHÃqè£ºÇkiÊ6üaøä‘ˆc™F¿X¬wxÒÑò#œFãŞ7Üp˜îñÚ£/Æ–<„xxìQÈ€GÚ‹ê\0â;´q¸Úñ¾ãKG‡Œ3Î<|n¸öQ¼AGÑGr8cèÌñé£sÇÚŒœ\0Æ5T{¨äq¼ãfÆmÿŞ/ü€˜ÅÑë#	G-—ZA,nş1Ğ£ÅôŒ• †?D`hø±Ã£p‚Œn…^<ÄmøÕ±‹€’Æ'{Ò<œo(æ±¯dG\0mj8|møãdÀä\rÆFŒ!67Ì~âïc%Ç½†HNAÉhèÙr£IÇ8}J4<wxÇÑµ#GHO+º@^¹ñªãˆGw‘:~ù‘…ä*Æ„“?4dĞQí¢îFÎB¯2D<r¨èÒ	\$+F1’DL|hÂñì\$FæB|~HéÑšäÆG\r¢/lfÈÄ1}£È½\".DÔ_øãä?È(Œ\">3”y‰	ñ\$EGO‚?\\v¨ßÑÖãOÇŠ¡\"D¤yÏ’0cµGÕ!²>4thë1Ú€H8grFtmø¾ÑÙcIÇb‹ÿêD|‡xÀ±‰£¬Æ ùJ4„ˆHÆ’#;G×É^F<‹¼¾ã^H»ùÂ@”ŒyQüãÕÆŒéZD\$_Êñ¬c\rÆ4 ®3¬jˆ¼‘òcFÓQê>tn9	í\"îÇ˜Œi.B\$xxÓòCã´F_‘›\n6\$gÂò!#H[ŒG\n=än(ı±‘\$:É\"Ê>Ì¸ó1ĞãnFiŠ6Lh¸ãÀ\rcµFŒ— 0¤rŞQ¡ã¢ÈÏ#ö:èèÑ¨¤È¥5 21€hÆ‘™dRÉÓÊF\\`yÑ}¤¦FÇ\$˜˜nXù\0¤qF OÂ1Üx)&‘€ÈÖÉ!â2\$_XÏ‘ÍdµEáŒ5–JämXÓrN#%Èâ‹É¾5\\g(÷òXä4IGQB9e¨Ó€¤ÈìŒA\$r1üyXÇÒ&c‹G/‘Ùr7ğXîrAâîÆğ‹÷V4„‘XÄÑêÉÈŸ%v2¼„ÒN#¡Ç!‹É&N6”‰±Ïã¾Æ,Œç–GÌ€ˆé’\0\$bÈW%ê9Äb	ñÖc˜Æå’ Â7¬i	\"ñ£ÈêË\"=djé\$2ZcyIŠ\">7ˆ½Qó£iÇhŸ zHiÉ§LuI@’×î1œ™±¿¢óI2’Á\$N2<ˆà‘î@1Æëå&êJDøÊ1ˆc©H<ç z7¨(É‘Ú¢òÈC’IGœg(ßÑÙ£Çß–/T‰	!1¨#jÆÎ­\$vN„‚ØÈ’~dÆ–Ç'‚@,˜†²J\$ù +a²?ÄdHärã “‘ÅÆF´€ˆÄÒOcOÈO“g2>Ä¸àQÄ#ïÆ’U*B¤˜Ù;Q’äIù‹ûšK4^¨İrã9F&ø\nRR!…ØÜqÈcI¶’_æ9„o(ì±‡À’H?Á264†ˆÿ²†\$ÆIO”/\$’2<v€\$²K\$I4õ&J=ì“YqĞäÅõ“á ¢<˜Ò¢cIâ”Á%–8Ü’èÃ±ÂdU˜^ı(ªGÌ¤¹:ÒFãŸJŒ\$&K<¥/Ñ¤€’G•)vO´iI#ñÈä‚F8‘ó*Sü`i:Ñ¢#Åİ“A)B9Ty	2Ñìã…Ê+KR?¤ªxÌ2¤\rÉÕ”Õ\$ş8\$b©2'e=FM#*JOœhHäñŠ¥&Js”±*Î2ü~ÈÓ’7#i”eGÄt)*±»cMIJ”?‚8,š™QŠdJ)Œù:;L›èËñÆ#\"ÊÜŒ\"ş;œ•8îqyİ\$Ãx~e*áÅDuÔc¨ RÒ»…qx~ek‘ı¯° ²±dÒ§•—àaV\"ª{WïqbÆu(2¿Uı+6TÜ¿ªWä¯¥JÃy)>Vª*X:Şøwdpe‰¬sv¤ëá×\nÇ5 Ğö™¬w\0WùH4±U\$ë-È.ÍU‹¾CÅ¥>èÁå¬s‘,¡Õ»®IeTN,M0@\nc\"¦˜/À!ƒ\0–²iJ¢Å(t+\$Ö–©l´¾Y°©g¸Ú)\"àHiÙº’%²’Ô–±Ëv@\0®XB”%²Š±@)€Yv€F°írÆ•½î¾”ÍK]–¾¥Ô¶%DèÁÖ‡ÓREö[{´U\née˜:æ–e-Ä•Š–Åàdp]áÀäyç’Nc¼Q9À\n—9éI…5aöTª»”R‚¼ĞıË+ÇürâŞØ—(µÉY¤@ƒ°Ğö•]C‘—+à*ßE…îßİÃÃš¨ñr]8~9tŠZ¡ìË©•ì§\rİµ9c2éâÄ%ˆ–­¼’œ»G{!ù‰?‘Ï–“.õLë½ ïÀK´Yr\rQŞô´€0¯ôVF\n´š^B²X*…9;Ş\0¡•Ğ5Eë*%‹«o–2«ŠWØ…òöˆú¼V—Ä§İd›°u÷€Õ\"«­¨±+ëşµâ'€VJ&\$h£KBĞĞË'¬”wÄtvZKT¡h‹Æ—¬LC½/ğ”BÆà\njr”©ˆº\rQXÂËTÍDs¼ï­t´½ğı @!*¾\0’ºv_ìÁE|k0ÕŠ€BY³}ŠŒå( RŒ¢ígÆ^ºğ%{Ëó]ÒKŞWÑE€`à:\\Ölõh¢õİ–:óPUàaW)ÅH‚±ÎX4¶©ˆÊğÃöË^Ë-¢bTÄI„\nqaí#éT°´­N)BV*qU8¯¸\n±0*µµKV…(²–¬©bZÌÆ ûV	†Vi1\$\n´Æ•Ï+©&2-L˜êïÕ`ì;òCPöK)˜òë2cØemÏÀÂ£Zrp°úaœºÉªµU+b#¡25FDÈÕ’aúâ|uxÁÙxÓ¢´JK+–K |=‘;Æt ÕüÌ¤‡œa\"­Gq«áè…X/õ‡I¡¸ğ_Œy‰I™]¶[tËu\nøÖÀ/ ¨ğ,>šÛU’k€Â®ì¨¯©F½\0000±%fc¬R\0¡wÂş™k/\0«\"3V†îeÒœÙ˜HŒ‘ş®¸Wª¥±Ú+´w^s.aíÌ«#PF¨L4Á¥÷Îµáà»€ü4¼¿™œ¯ÃşÌN–À&bŒÏ5f’Ï]úªn[‚£şg“µ`fr;Q^´Ògj¸wUjHIM	W*ì¬”B°\ne´ªØ¼£Ér\\Ğçu8ÃKZ¬­±o£­”ˆ å€Ë³R íhÚºÀúóDòKX–%4hê×E®ÓC”áËQša2­Hù#I‚ä}f’Ì7šnğniË­•>k#&})SR«3	[ø©d3OÕš*	R¬ğ<ÔÉ¨ÓSÕêßx49İtÓéŸJ(¢G(³vÆ¥~hrib“T•İK™òª©ÚÂõ\nZÅÍ_¥4¶jÌÔEUS[×á«@š92­VÊåÉ®ïÔ¨Ë}šÈ¾ø?‰!é’Ãf}©^WÛ49Zj¦¥İªÍ²‘Ø›3²kù) ®Ñ^LÏvğ®¦ht°ÅK]fÍ™\\&©ºlä·53sHæÍrvê©ÂctÙ•z³/U »x™í1BcŒÒù¨³TX¬¬_o5ıNÂ¹Ùu³n&¶Í_)5ıW´ĞéjË¥ğ-›f\0­š¤Õu.´ª’Sšˆ«–gu\$•ıLçXÍ3©Ø¬İIÁüfxÍÚuá-šb|¶¶3<•rÌüSLê¤“Ğ	»ÊãfÌé™È«•\\r?©‘òè]ĞM—î´@Dß7Ê4Î‰¸š'3âh°ù£\n;æú<#š77®iK¯\0\n³HU&Í¤š	7=ÜÜà•#Êµ&ı¯Óš]7’p‰#%®¡ô¦õÍ5‰\r8uV‚Ê‰ƒ{§<#š‚±R|¿×u«m	?ËÜš”tJo\\Ôé©\n~æ¨Íùw78ÊqlÕY\nŒç©/š´îÊq«»C¢SXç<#˜á8^o\\Ö•ÜªuæŞÎEWõ5Ñcœ×>³g'¯Éœ-5Úo\\×•[rå§*,†w‡5úrr—Ù°/å†LnVñ6_tåÕ™èüæÅKU°±Æo\\İ™ÍS:×Îqvç7­Û´ç‰³óH`ÎzUY6np\\Ú%Ò“I'ÎSœÂ£†cj“éÏ\nüexÎx›Wzeôç9¼=æŠÎH\$fm¬µé½jv!Ì©w795Ş’°É½spg9ÍÃ[F¬­Ø<Ş¹¹.ï×?ÍÌx5×¬İiÄ‹ğç9(‹–®šnâu–­çIÍ°-:Út­á0®¸&­:õ›Ì©bgü¿‰×j–`š¥×ª‘~Ñçe¼œ+7ôDÑGU3€—\rÎ€©ºp:‹™jó„¦ĞÍ\"]+:Î_ë¯ù£àU–ÉNš[-e×¬áåˆ3µU½Í:QÃ8¦w iÇ &¤¬\0œa;‰RÄï¹ªX'€*n8êj¼ğW`“±]‹ª!ò³rî—bó‘çxOSç9-E¬ä×^³”'…Î°v/<ru`ÚÇ×-Î[G-^kìòuKöNd›Q9¹~\$æ€óÃæÄ‰„`¢ıSŠ‹{NÅ'6O6›9ÂxS­i™îÅ\"4Oœó=W4è	³³Ò&ÍM ;št\$î‰èÓËç•;1½p\\Ï—^³¯fñN¿‡\r2¶vü=‡y³ÃæßÏa‡Æ¦ªzDêedàU§TÏHVìbujüÙ¹³#¯íöz<>w‚djV(­hXê©Z{á!	j@V…O€\0 }Z¥`ıÀ@\$ÏŠœ‰:âg‚uEïTrOŠ–¼¨™d|¯i UO“wÇ3È?Ôî\n‡C+\0Vg+ñg*›åÂ²ÓÀ%ª”\0š}âºÔ×^ó\0ˆ-¯]¦¤ˆÄJ/Ä° oçÜ7á\\7-9B‘‹³Ã§á*Ÿ]-:~2 Ğî¼e·‡Ñ[--éJ¬±™óÇGf€‘Ø\0¾F­]i©mëƒ§Ä©_œ¨:~œùYûÊ¿U\0S\0¿3F\\¶ğ	ÉUjÏáŸªHÑÖœÚÕàsüfÜ¯œZ²<q9ıS§ïOò–ˆ³ü®ÕÕ\nL¦ˆ\0_Q9uT¯So«äb®rx\$³ª}ú‘€±–…Ğ_':Š€’Õ5ÁŠõU )«Z¬¸d„Áğú3æh:ıH€¦â|ıUYÿ§÷)¶—C5)PÄıªñWP%Q–FÚ_İ5„nh/¹ =7It4gîÍù\0„´J\\¤áU¥sæå¬’&šV£Mi\\ìÚ	3D•ĞM#ŸA(Ê¢h~T&ÙPN ±Ai\\)t4è*;+GÍ4LÀéqn¼‘ùËŸı@\$tÈI¿4\"<;—SA<Hš“<§vĞe Äñ¢p¥Yk4h(PfGéA¡g\nœ%vDgë©³¡®ÍkDñuBÔ#èF\\™á;z µÉËJP%ÓĞ‹\\¤~oU	JstÔáN!U.Òn2ªZ@\n(UNİRÁ/=`´øŠ”,ç*¨¡Vª•Ø=%•ô-ª¨Ÿİ/!`µùyë!í-&\\19*„\nÀûäI@KÑY=3	NÄğ%ŒáôN‰PÂ¡Y8°”æUÓ”\n'êKÚ#XºÅ`²Ô@û T€ºµ–R¸VµĞ0²öèr¬.Xo8¦fò¾\nÄ WEL¡ÖF±cmuwÈ h|ËçUÇ6‡Zª…}´*×ë,ëXx´MR\rWƒ gó-+¡t¥Ò°útBV¨P•ì¯igUYÛ«=\",éXİ;NÀ}z#ë;ÃÿOéZí’|Å\reD4J²PèXD§ò„	x{TL	[¬µWãD™d¤ş`\nj«Š‡å¢e0*‡êŸÊÔNhKÔ\r0A»Ó¦Z3Û½QKŸ1A\\>ÅrÍ^(Nÿ\0P¤	\"À¹â45—ÎŞ¤&m¸€şT+è±NDZÓ?-I‚‰µÕAú©ÍD^HÒf…Z‹Vl\$¢–»¼)¡ôh»¬!Yš¨±`äÄBJDtu©6_”§Œj1ƒèŒĞ³\0QDÕuÂºš!ôbÉ)ĞÖ¢k@¶‹\"ãåXça§ŸLK\0ÎŒòëUŒ3”N\"3˜¨¢½g*àåòôdæ\"*í£S?^xŠı…Ñ4c`G\n2¿EOüãZ!jmªA:2¾à?Tíâ8d…Ôş,W[=6‚(\0\nàë¨Òuf¾â]E’d‡	PE#qù~‚•;jÃÙ¬•ëGzƒŒÆEc“6æ0‘Ï[^¢nc\$:5ô'(ò«KRƒ¢ouú¦0Ä˜òºÎcÊàjÊ°!í-ˆ•Ø³ÑH\$úu;*]h°»v¡WH‚(~åxSæf†OâT…6~†³­¤~ÓùèRœSHEsÍ!UÜ*„‚\0‚ÉÜ³Â ZC§±˜«*œ‰Frq«¸EB­×v*TYéHDèäÉ2C”sÕ«ÕŸÍCõQ™\"`\nË\n©MÆZˆ°¨ªŠ•B¢Q\0T„¨6’°Ê@ê¼èÖRG¤”ÖW²©JIô‚W|ï\\tUP*¢uA•RZRH´’½5HSåÖ÷ÒTN‰ú’úÏKª¢¨rOe¡é2’X–u«kÖß,µ¤àJFœ=©˜Kºh¥’ˆ¤¶³Æ“\nÉ5Úª]çÄ-\nTHe#¸ºnôçPE¥CYJyrDÓ/æ\\)A#Æğveı!ZI”Ré&PE]Ù7³Æ§ÇHå±2‘(ŠT ³©QŠ)¥Læø\r´ˆ@1]\n\nñ°IH«°+@Â®ÿ_Ğü±óò÷-ÉFšE(pg¸‰1p.QkM©…÷ÈÕ :\nI€Ä-\0V0ø¤y@‰¢„›4põ-Ğ1ÏL@Ï\$G†4mĞ3xÕI\$¼G=}K fš…ç;àÀ2\0/\0…–3\0bË`Ç\0.H\0Èx)\"@IaŒ&’‚ÄÔ™!-´Á’¢S\nø\0Ò˜[©*`á¶)„Æš¦\"½)Í0à\$ \r©‹Á?¦(ğ½1Úc4ÇÀ’€8¦ELL1xWÀ4Éé†Ó\$IL°ü¸bù+‘Ÿ)˜!|”…àM\nbTËi™S\n¦uLb™E3xÀÔÍC˜ÓB\0kM˜E3:c”ÏéS=iM\"˜¥3:dÔÓ)‘ÓN¦WMRš•ÊeôÖ)S7B¯MB™ìbZl×ÇÓ\\¦b~33JlÔÍ©´Ó9wLî›< =cQ)¸S6”Mº›¥4\nk²€)²Óo¦õMÆS69@ÑéµÓE”M.›õ4Ğò€)Ó…¦(š8šj´âÀ’ÓW§%MM(\nlrŸ)ÍÓ8§;†œı1\nqÔÅ#„Ó„§/Mv8M8Šo4â£ıSŸ§#N®œœpšrÔì) Æ>¦·N›=;jntÃ)ÜÆ|¦ñNò™´˜zwtİi¢É‡§O˜D˜zo´í)®É‡§ENâZtÔó)³É‡§UO,„Zlraé×ÓØ§“NVÜgÊsTèÃÉá§‡Mş6*|€äğÓË§½LRO\r<úz”úiéÓï§Ëò½<Šb‘wéµSĞ¦‹Oò=>ŠôÏ©ÿS§ùOÊŸ°øÛôÿiùÓE¨PœU@º}ÔşƒÔ¨PR U=*luéüÔ¦P.œm@Zb•éîÔ¨NÎ L„*|uª\nÆ|§ÏPFõA¹u£ÃÔ4§ëPšŸÅCJ„5jÆÃ¨iP¢¡Ä•Ê†R~ª!Ô§'. Aê„qõj!Ô7¨•P¶/•D:‡u\ncpT%¨~DBúrr ê#SA‘Q&œTˆ:‚õäAÔN¨ÃLn›ˆ:Šu\$AÔV¨Ï £M>*4×éõ–‚§ÕP²¢ÅC:²µê9Ôf¨·Pæ£Ü]êuª?Æe¨ãQ\n£İDJ}a_*T	©QvšíHÊŒäêFTc§R2£õ4‘•jK%¦ŸLı0]9ê”	ojSy©CM¥\\šƒU*RôÔh©X—ÎÕJô¿TÉi‹Ô§¨€›n¥%;z”Õ.ióÔ¡¨ïRî¥T‚\n–µ.j1Ô¾¨Rú íKêu.*`ÔV©}RŞ¥\rHŠoÕ4j^Ô¤0»S¥TŒÚ›+c^ÔÛ©a.¦õK:Š5,uÆà©—SF¦uMjv`À4Æ%)&U85Mšu;c7F}ÙR†3Nœ±Üê}»“éSôœ~Ê ˆjbÔ¤T0ÕPŠœõAªtÔª&T:Q\nšµ*£¼Õ¨“R†>EQ\n˜õ)#ñUªTR¨mJØâ@ãU\$¨R†I¥RJ µ*£MÕ\$©“R’?RJ¤5,#yUŒATÚ¨JØÃuMª‹Ô¤×TÚ¨İJ¨ËuMªÕ:ªgRÎB}P8»õRªœÔ°‹ÙU*©íJ¨ÇuRª Ô­Œ?U*ª-Tê¨õ9cqÕ¿UzªmK8ÎUWª¨Ô­Uzª­K¾µWª¬Õbª·Sø´uP2ĞU\\ª°ÔåŒ/UÊ«-Kàu\\ª´Ô³’ËUÊ«mWj­õ@cˆÕ\0\nùV¤mO½4¿êÄUyKô’©]XºbÕ9\0İÆö«V¬¬ez±4Ş¡W¨WS¬]GJšugj_¦ó«IV8çZz²)|Ğ«Õ}«RM¦¬5H*²‘x¢îU±«8—&1-Yú´Õn*EU£«yT¬íMª¶q‰jÕÕ©ÁW§[ê±q‰ªÃFn«›VŞ¬]Oš¸u?*éÕÀ«q¬4vª»5kªÊÅë«³VA]\nµ•DjáÇK«\rTV¯-ZŠ²µFjòÕÜ‹ÅTv¯-YŠ½õx*‘ÕÃªKWÚ«­YX¾5aª”Õö«‹V¦©m_j¥õn*˜‚È\0FÀ\\Ÿ©<Õ3*ÅÖ;X¾HjÁQ²ÓÇ¬¨wXB°L‚½µ…cFUü«ÅV>©½\\8äaªÖ\"«ÕŠ©ıb*½ÄÚkÕ‹X’¯Tš¸uRëÕùŒ›WZ¬\\cJ°ÕTëÖ+ª¯XÎ¯”^:Çu‡êÔÕc«‡ª¬5VzÈõŠêµÖG¬ƒUÎ®dº°Õ]ë(Ö'ŒËWş¬¬nJÊu‹jÖF€¬§Y\rİ3: W+%ó’¹XJåe€Ó•dêåVf!Y¤ıfÔ¿RW*ÁÉ\\¬Àr¥Õ[´½2~«V\n¬ÇS\n­œŸªÍR~ª÷Iú¬¹YÎ­•g#r~«:Ô†­SJ­fj·µ¤k9Ô×­Y¢¦íhúĞµrkJV‹«™Z>³©…êar¹CM?2¥ŠåĞDí_²Ä'¤NáÍ,}gŠè©ĞÎ¿Ôş\0KÛZ¾r”ñ)jóñ+Wª!¥<<R½ÕL3ÒQF¢ø£åY\\êJÕõ±DÂÖÇQ–£ÅGš­ùáïg»[¶¥2zB§`	k¹g‡Ğ›œ¹Z½QzªYæ“ÏfÅºĞœy=\"u¬ôIƒÿDmRA=MÛÔõYÅ¶ç£*'Q£<=NÄõ÷pnÉk|M»­_ZşzDöW^µ²¡Ä-Ÿvi\$Êµw³k+OORD¹\"[ŠÉ*â3Ÿf¿Ä(–!4:oŒâÚãAÈìVâšÿZ¹Ú¬îµ˜„ª¦V±­é\\}s¡O3@f”Vµ­nínqôÚi£µ¯UV¾œšªª¶\n¥)¬ e¬æšÿ[1t’œŠÙóÙÔzMÇ®[:¶MmTtU•UVÔš[^„tÜzÛU·&¿×SšÖG¨dÖêãÕÔ§’Ñì®¸¥)`´Ø‰Œ³ç7Îó›#6Bn;¬Uˆ«+wL`›=»{±Çxt¦¿©Y®·6ºtÍpS^Õ®ª²­ù6â·ó¸¤ˆ3C©F,p®³6úªªªÙRçf÷¯›GèHeR¤æIÑä˜'HÎ‡WZ®Wtç:ã4:«ËV®wO\\‰E-'tõÉ§«ú[èb¹TÊzóµË•TN=v»:rğJòÕÍ«ÁÎs®s[¼±*šçµê•r×G%S[\"¶„öŠòÕï«¡WIH\r[Jstêù\$q+lW–®¬¥W-mêúæëp×aœç1ªyıvjòÓ­]İLz­Ø°Î¸”é*îNñ'<N˜\$Å:jsœéÈrõß”ÀN›­ü«¢u¼÷quá§<#Ê«Ö\"Ë'{ŠÄQıËÈx0\"»[¯ÊjPTUı°\0ë6edÌ÷|ÿ†,“X£êaJ³9‡³¹WÜ	„¡’¹Â’¶	î±–ªwõ]¹ßä»•ŠÒ÷§-EWp±VzÊ‰ÖªÓtÃ°š‰2¦X)J§I&@N7-šÊ'GÜ@2¯¥l%åØ6\0‚\\õ20i€{˜êm„€\rÒá‚ä±úb½@¨qÜÑ8ÏA@ºË;=ÅM¡ùù÷ˆ/Á¡a½\$±,Ğ«mQĞ_ËBy†A‡v'Œ&(~Æx%†tòŒ„/ï‰z‰I˜Xk¬·¡XuJ’ñåUˆk6Mw‚w±–Nªò6\"€ƒXubÃb)ï5‡VDzP_„>dbõ\"`w½í§^—0yA~S„ïøğZNøğxm\\„–Û´¥j7ád€¹§xÜ ¦eLxØ `Mä1WKFRyš†*ğ43´‘b²{†(ØªÖá9b„\rŞ^]Œ¨FZeå<F\rcT0òEså0¡`ÛL¶(²ÃŒ ¥îKüŞ3¶ô°ÔÏ°qóÏD¶,ì50)KÍ…¨“Ì0)`aP€X>“cÒ&(G÷GìÑ)ô±¼!Z¨©Ç ÍM‘„L²c\\ûøŠ\r,GÀØÔ`‰¥‹Æk\",dÁ2h40ê^sN³âV'ly´ë%îˆä9«K-,X-µ7`ƒbÌ®X†dØl\$ˆÿ°#ü+2S!‹âR zh¢dó¬Ã‹Í8ˆ|7–h¢ÿ¥†‹EßLfaO‚Xc%e1}”F6RFdc£aD+#ï£¸™l¦<¬²ßÒÊdN+ÀğÀà´QEzÀ\r§P%A‹Ÿà‹ö²Â½œ}++,¶FlŒ4Q<ëa03p¼¡¹ Õ«Yt{ğºÅxPõ\ræ™ˆÁÌlàÒË½—Ö@ï^l½Y!³\n!)˜µ\0–ÍlÄ¸:{aeŒı—HD)áØâ„zš©ü5™%ì)ª€Ö LiÕfZÌ¢€DšÖÛØ[\n+f]÷Jà¢­&\0:A±Af¬ıšóé(Y±Y;¶ Å€wTÀ¦Í­›à9p&B®f<{ä}œAPbË›O\n¶³Šóh<œw›C:¬é%„˜Xéñ“¢\nÆ@§nå¡[{ygyîÓİ\$ÄVxAÃYÇ<rhšÎ8tVcÌ*,õÀ·²cz&8B :ÒÓfBØc³å\n%zDÈ[\$s!l’jÄnÈãgôî—_ØØ¤40ñ…Sk%çJğƒ¾aP\nªAa!°!,šVú\0CËkB–œxd^#À1xÇ«C6„À††/oáhÑRtJN@6À·´Pà´Ï‹'‚Š€€Z´J	5ğh\$Ë@Ğ mÂIJÆÑµ1Gı\0“‰	Ò°PàµÛ‚G°™Zd8ÈfÒsŞ¶ìˆ¿ZT\0ÚÁÙ\$³€@JÉmÁ+idÆH*kKæ}„Ñ V!i`1}Œf•\0HlÂ¾´²nÃRvwÍ6œm,‚£ƒGi¡ChS4Öš,MZc´ï©Ş€+6ƒl1 É¡‰»\" ğ‹Ê‘)Z‰OqäîDÊ' 6}*½±{jû+R À”=(²2ÄŞÔ½©¶bÂq×­Z«gâÆóĞVT–‡ì*#ˆµRÄô!Ë9çŸ¯@š¶fµijÇ\r«K-L«ÀÚ€Jä®Ôh`èM`Ga5Å;Ğé§¸ 0¬|ª0é°…k-­à(Ká¹œÚÍ3kXŞ½šû!Ö\$@ÂØ“±<øAë\"‹[°fK	¢€¶\rRÓ²N{]\0Qiz*µÖ%È‘h‹W´­mv96²ş\n€µ®ôå“é[EŠ;d Y]àMmwÏµŞ0˜n=®÷F FmqZô\$ ôıÒ% Tg\níwÀ8<„Ì•³•Ôw’Ïf„P‹U*-c—hµĞ´eÂÔH’6ØàŠºÍ´¹ÊNl8IGÉÖ\0 Û2|u¸ÊùxºO\r½¸SK½˜ºÉ3À(¶WrIóĞ49€qˆÙœÄÍ´·N\0	À)ŸñsmEÆ¹+g“-¢½í¶•md XÔ%ëixFÈ¹	ò€#6×S’[RL#Z‘D=²‘õªEES<¬ş!î5Hª ·’Úş x²ÓlJ³-Œe‰!×ŠwîÉ{Ú©zïİZL öaÎ¼á»+\$UF.áb9]");}else{header("Content-Type: image/gif");switch($_GET["file"]){case"plus.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0!„©ËíMñÌ*)¾oú¯) q•¡eˆµî#ÄòLË\0;";break;case"cross.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0#„©Ëí#\naÖFo~yÃ._wa”á1ç±JîGÂL×6]\0\0;";break;case"up.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMQN\nï}ôa8ŠyšaÅ¶®\0Çò\0;";break;case"down.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMñÌ*)¾[Wş\\¢ÇL&ÙœÆ¶•\0Çò\0;";break;case"arrow.gif":echo"GIF89a\0\n\0€\0\0€€€ÿÿÿ!ù\0\0\0,\0\0\0\0\0\n\0\0‚i–±‹”ªÓ²Ş»\0\0;";break;}}exit;}if($_GET["script"]=="version"){$r=file_open_lock(get_temp_dir()."/adminer.version");if($r)file_write_unlock($r,serialize(array("signature"=>$_POST["signature"],"version"=>$_POST["version"])));exit;}global$b,$f,$l,$mc,$m,$ba,$ca,$se,$gg,$Ed,$T,$zi,$ia;if(!$_SERVER["REQUEST_URI"])$_SERVER["REQUEST_URI"]=$_SERVER["ORIG_PATH_INFO"];if(!strpos($_SERVER["REQUEST_URI"],'?')&&$_SERVER["QUERY_STRING"]!="")$_SERVER["REQUEST_URI"].="?$_SERVER[QUERY_STRING]";if($_SERVER["HTTP_X_FORWARDED_PREFIX"])$_SERVER["REQUEST_URI"]=$_SERVER["HTTP_X_FORWARDED_PREFIX"].$_SERVER["REQUEST_URI"];$ba=($_SERVER["HTTPS"]&&strcasecmp($_SERVER["HTTPS"],"off"))||ini_bool("session.cookie_secure");@ini_set("session.use_trans_sid",false);if(!defined("SID")){session_cache_limiter("");session_name("adminer_sid");session_set_cookie_params(0,preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]),"",$ba,true);session_start();}remove_slashes(array(&$_GET,&$_POST,&$_COOKIE),$ed);if(function_exists("get_magic_quotes_runtime")&&get_magic_quotes_runtime())set_magic_quotes_runtime(false);@set_time_limit(0);@ini_set("zend.ze1_compatibility_mode",false);@ini_set("precision",15);function
get_lang(){return'zh-tw';}function
lang($yi,$kf=null){if(is_array($yi)){$jg=($kf==1?0:1);$yi=$yi[$jg];}$yi=str_replace("%d","%s",$yi);$kf=format_number($kf);return
sprintf($yi,$kf);}if(extension_loaded('pdo')){abstract
class
PdoDb{var$_result,$server_info,$affected_rows,$errno,$error,$pdo;function
dsn($sc,$V,$E,$Cf=array()){$Cf[\PDO::ATTR_ERRMODE]=\PDO::ERRMODE_SILENT;$Cf[\PDO::ATTR_STATEMENT_CLASS]=array('Adminer\PdoDbStatement');try{$this->pdo=new
\PDO($sc,$V,$E,$Cf);}catch(Exception$Mc){auth_error(h($Mc->getMessage()));}$this->server_info=@$this->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION);}abstract
function
select_db($Ub);function
quote($P){return$this->pdo->quote($P);}function
query($G,$Ii=false){$H=$this->pdo->query($G);$this->error="";if(!$H){list(,$this->errno,$this->error)=$this->pdo->errorInfo();if(!$this->error)$this->error='æœªçŸ¥éŒ¯èª¤ã€‚';return
false;}$this->store_result($H);return$H;}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result($H=null){if(!$H){$H=$this->_result;if(!$H)return
false;}if($H->columnCount()){$H->num_rows=$H->rowCount();return$H;}$this->affected_rows=$H->rowCount();return
true;}function
next_result(){if(!$this->_result)return
false;$this->_result->_offset=0;return@$this->_result->nextRowset();}function
result($G,$n=0){$H=$this->query($G);if(!$H)return
false;$J=$H->fetch();return$J[$n];}}class
PdoDbStatement
extends
\PDOStatement{var$_offset=0,$num_rows;function
fetch_assoc(){return$this->fetch(\PDO::FETCH_ASSOC);}function
fetch_row(){return$this->fetch(\PDO::FETCH_NUM);}function
fetch_field(){$J=(object)$this->getColumnMeta($this->_offset++);$J->orgtable=$J->table;$J->orgname=$J->name;$J->charsetnr=(in_array("blob",(array)$J->flags)?63:0);return$J;}function
seek($C){for($t=0;$t<$C;$t++)$this->fetch();}}}$mc=array();function
add_driver($u,$B){global$mc;$mc[$u]=$B;}function
get_driver($u){global$mc;return$mc[$u];}abstract
class
SqlDriver{static$mg=array();static$ke;var$_conn;protected$Hi=array();var$editFunctions=array();var$unsigned=array();var$operators=array();var$functions=array();var$grouping=array();var$onActions="RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";var$inout="IN|OUT|INOUT";var$enumLength="'(?:''|[^'\\\\]|\\\\.)*'";var$generated=array();function
__construct($f){$this->_conn=$f;}function
types(){return
call_user_func_array('array_merge',array_values($this->types));}function
structuredTypes(){return
array_map('array_keys',$this->types);}function
select($Q,$L,$Z,$xd,$Ef=array(),$z=1,$D=0,$rg=false){global$b;$fe=(count($xd)<count($L));$G=$b->selectQueryBuild($L,$Z,$xd,$Ef,$z,$D);if(!$G)$G="SELECT".limit(($_GET["page"]!="last"&&$z!=""&&$xd&&$fe&&JUSH=="sql"?"SQL_CALC_FOUND_ROWS ":"").implode(", ",$L)."\nFROM ".table($Q),($Z?"\nWHERE ".implode(" AND ",$Z):"").($xd&&$fe?"\nGROUP BY ".implode(", ",$xd):"").($Ef?"\nORDER BY ".implode(", ",$Ef):""),($z!=""?+$z:null),($D?$z*$D:0),"\n");$Jh=microtime(true);$I=$this->_conn->query($G);if($rg)echo$b->selectQuery($G,$Jh,!$I);return$I;}function
delete($Q,$_g,$z=0){$G="FROM ".table($Q);return
queries("DELETE".($z?limit1($Q,$G,$_g):" $G$_g"));}function
update($Q,$N,$_g,$z=0,$lh="\n"){$bj=array();foreach($N
as$y=>$X)$bj[]="$y = $X";$G=table($Q)." SET$lh".implode(",$lh",$bj);return
queries("UPDATE".($z?limit1($Q,$G,$_g,$lh):" $G$_g"));}function
insert($Q,$N){return
queries("INSERT INTO ".table($Q).($N?" (".implode(", ",array_keys($N)).")\nVALUES (".implode(", ",$N).")":" DEFAULT VALUES"));}function
insertUpdate($Q,$K,$F){return
false;}function
begin(){return
queries("BEGIN");}function
commit(){return
queries("COMMIT");}function
rollback(){return
queries("ROLLBACK");}function
slowQuery($G,$li){}function
convertSearch($v,$X,$n){return$v;}function
convertOperator($zf){return$zf;}function
value($X,$n){return(method_exists($this->_conn,'value')?$this->_conn->value($X,$n):(is_resource($X)?stream_get_contents($X):$X));}function
quoteBinary($ah){return
q($ah);}function
warnings(){return'';}function
tableHelp($B,$he=false){}function
hasCStyleEscapes(){return
false;}function
supportsIndex($R){return!is_view($R);}function
checkConstraints($Q){return
get_key_vals("SELECT c.CONSTRAINT_NAME, CHECK_CLAUSE
FROM INFORMATION_SCHEMA.CHECK_CONSTRAINTS c
JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS t ON c.CONSTRAINT_SCHEMA = t.CONSTRAINT_SCHEMA AND c.CONSTRAINT_NAME = t.CONSTRAINT_NAME
WHERE c.CONSTRAINT_SCHEMA = ".q($_GET["ns"]!=""?$_GET["ns"]:DB)."
AND t.TABLE_NAME = ".q($Q)."
AND CHECK_CLAUSE NOT LIKE '% IS NOT NULL'");}}$mc["sqlite"]="SQLite";if(isset($_GET["sqlite"])){define('Adminer\DRIVER',"sqlite");if(class_exists("SQLite3")){class
SqliteDb{var$extension="SQLite3",$server_info,$affected_rows,$errno,$error,$_link;function
__construct($p){$this->_link=new
\SQLite3($p);$ej=$this->_link->version();$this->server_info=$ej["versionString"];}function
query($G){$H=@$this->_link->query($G);$this->error="";if(!$H){$this->errno=$this->_link->lastErrorCode();$this->error=$this->_link->lastErrorMsg();return
false;}elseif($H->numColumns())return
new
Result($H);$this->affected_rows=$this->_link->changes();return
true;}function
quote($P){return(is_utf8($P)?"'".$this->_link->escapeString($P)."'":"x'".reset(unpack('H*',$P))."'");}function
store_result(){return$this->_result;}function
result($G,$n=0){$H=$this->query($G);if(!is_object($H))return
false;$J=$H->_result->fetchArray();return$J?$J[$n]:false;}}class
Result{var$_result,$_offset=0,$num_rows;function
__construct($H){$this->_result=$H;}function
fetch_assoc(){return$this->_result->fetchArray(SQLITE3_ASSOC);}function
fetch_row(){return$this->_result->fetchArray(SQLITE3_NUM);}function
fetch_field(){$d=$this->_offset++;$U=$this->_result->columnType($d);return(object)array("name"=>$this->_result->columnName($d),"type"=>$U,"charsetnr"=>($U==SQLITE3_BLOB?63:0),);}function
__desctruct(){return$this->_result->finalize();}}}elseif(extension_loaded("pdo_sqlite")){class
SqliteDb
extends
PdoDb{var$extension="PDO_SQLite";function
__construct($p){$this->dsn(DRIVER.":$p","","");}function
select_db($j){return
false;}}}if(class_exists('Adminer\SqliteDb')){class
Db
extends
SqliteDb{function
__construct(){parent::__construct(":memory:");$this->query("PRAGMA foreign_keys = 1");}function
select_db($p){if(is_readable($p)&&$this->query("ATTACH ".$this->quote(preg_match("~(^[/\\\\]|:)~",$p)?$p:dirname($_SERVER["SCRIPT_FILENAME"])."/$p")." AS a")){parent::__construct($p);$this->query("PRAGMA foreign_keys = 1");$this->query("PRAGMA busy_timeout = 500");return
true;}return
false;}function
multi_query($G){return$this->_result=$this->query($G);}function
next_result(){return
false;}}}class
Driver
extends
SqlDriver{static$mg=array("SQLite3","PDO_SQLite");static$ke="sqlite";protected$Hi=array(array("integer"=>0,"real"=>0,"numeric"=>0,"text"=>0,"blob"=>0));var$editFunctions=array(array(),array("integer|real|numeric"=>"+/-","text"=>"||",));var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL");var$functions=array("hex","length","lower","round","unixepoch","upper");var$grouping=array("avg","count","count distinct","group_concat","max","min","sum");function
__construct($f){parent::__construct($f);if(min_version(3.31,0,$f))$this->generated=array("STORED","VIRTUAL");}function
structuredTypes(){return
array_keys($this->types[0]);}function
insertUpdate($Q,$K,$F){$bj=array();foreach($K
as$N)$bj[]="(".implode(", ",$N).")";return
queries("REPLACE INTO ".table($Q)." (".implode(", ",array_keys(reset($K))).") VALUES\n".implode(",\n",$bj));}function
tableHelp($B,$he=false){if($B=="sqlite_sequence")return"fileformat2.html#seqtab";if($B=="sqlite_master")return"fileformat2.html#$B";}function
checkConstraints($Q){preg_match_all('~ CHECK *(\( *(((?>[^()]*[^() ])|(?1))*) *\))~',$this->_conn->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($Q)),$Ie);return
array_combine($Ie[2],$Ie[2]);}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect($Nb){list(,,$E)=$Nb;if($E!="")return'è³‡æ–™åº«ä¸æ”¯æ´å¯†ç¢¼ã€‚';return
new
Db;}function
get_databases(){return
array();}function
limit($G,$Z,$z,$C=0,$lh=" "){return" $G$Z".($z!==null?$lh."LIMIT $z".($C?" OFFSET $C":""):"");}function
limit1($Q,$G,$Z,$lh="\n"){global$f;return(preg_match('~^INTO~',$G)||$f->result("SELECT sqlite_compileoption_used('ENABLE_UPDATE_DELETE_LIMIT')")?limit($G,$Z,1,0,$lh):" $G WHERE rowid = (SELECT rowid FROM ".table($Q).$Z.$lh."LIMIT 1)");}function
db_collation($j,$rb){global$f;return$f->result("PRAGMA encoding");}function
engines(){return
array();}function
logged_user(){return
get_current_user();}function
tables_list(){return
get_key_vals("SELECT name, type FROM sqlite_master WHERE type IN ('table', 'view') ORDER BY (name = 'sqlite_sequence'), name");}function
count_tables($i){return
array();}function
table_status($B=""){global$f;$I=array();foreach(get_rows("SELECT name AS Name, type AS Engine, 'rowid' AS Oid, '' AS Auto_increment FROM sqlite_master WHERE type IN ('table', 'view') ".($B!=""?"AND name = ".q($B):"ORDER BY name"))as$J){$J["Rows"]=$f->result("SELECT COUNT(*) FROM ".idf_escape($J["Name"]));$I[$J["Name"]]=$J;}foreach(get_rows("SELECT * FROM sqlite_sequence",null,"")as$J)$I[$J["name"]]["Auto_increment"]=$J["seq"];return($B!=""?$I[$B]:$I);}function
is_view($R){return$R["Engine"]=="view";}function
fk_support($R){global$f;return!$f->result("SELECT sqlite_compileoption_used('OMIT_FOREIGN_KEY')");}function
fields($Q){global$f;$I=array();$F="";foreach(get_rows("PRAGMA table_".(min_version(3.31)?"x":"")."info(".table($Q).")")as$J){$B=$J["name"];$U=strtolower($J["type"]);$k=$J["dflt_value"];$I[$B]=array("field"=>$B,"type"=>(preg_match('~int~i',$U)?"integer":(preg_match('~char|clob|text~i',$U)?"text":(preg_match('~blob~i',$U)?"blob":(preg_match('~real|floa|doub~i',$U)?"real":"numeric")))),"full_type"=>$U,"default"=>(preg_match("~^'(.*)'$~",$k,$A)?str_replace("''","'",$A[1]):($k=="NULL"?null:$k)),"null"=>!$J["notnull"],"privileges"=>array("select"=>1,"insert"=>1,"update"=>1),"primary"=>$J["pk"],);if($J["pk"]){if($F!="")$I[$F]["auto_increment"]=false;elseif(preg_match('~^integer$~i',$U))$I[$B]["auto_increment"]=true;$F=$B;}}$Dh=$f->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($Q));$v='(("[^"]*+")+|[a-z0-9_]+)';preg_match_all('~'.$v.'\s+text\s+COLLATE\s+(\'[^\']+\'|\S+)~i',$Dh,$Ie,PREG_SET_ORDER);foreach($Ie
as$A){$B=str_replace('""','"',preg_replace('~^"|"$~','',$A[1]));if($I[$B])$I[$B]["collation"]=trim($A[3],"'");}preg_match_all('~'.$v.'\s.*GENERATED ALWAYS AS \((.+)\) (STORED|VIRTUAL)~i',$Dh,$Ie,PREG_SET_ORDER);foreach($Ie
as$A){$B=str_replace('""','"',preg_replace('~^"|"$~','',$A[1]));$I[$B]["default"]=$A[3];$I[$B]["generated"]=strtoupper($A[4]);}return$I;}function
indexes($Q,$g=null){global$f;if(!is_object($g))$g=$f;$I=array();$Dh=$g->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($Q));if(preg_match('~\bPRIMARY\s+KEY\s*\((([^)"]+|"[^"]*"|`[^`]*`)++)~i',$Dh,$A)){$I[""]=array("type"=>"PRIMARY","columns"=>array(),"lengths"=>array(),"descs"=>array());preg_match_all('~((("[^"]*+")+|(?:`[^`]*+`)+)|(\S+))(\s+(ASC|DESC))?(,\s*|$)~i',$A[1],$Ie,PREG_SET_ORDER);foreach($Ie
as$A){$I[""]["columns"][]=idf_unescape($A[2]).$A[4];$I[""]["descs"][]=(preg_match('~DESC~i',$A[5])?'1':null);}}if(!$I){foreach(fields($Q)as$B=>$n){if($n["primary"])$I[""]=array("type"=>"PRIMARY","columns"=>array($B),"lengths"=>array(),"descs"=>array(null));}}$Hh=get_key_vals("SELECT name, sql FROM sqlite_master WHERE type = 'index' AND tbl_name = ".q($Q),$g);foreach(get_rows("PRAGMA index_list(".table($Q).")",$g)as$J){$B=$J["name"];$w=array("type"=>($J["unique"]?"UNIQUE":"INDEX"));$w["lengths"]=array();$w["descs"]=array();foreach(get_rows("PRAGMA index_info(".idf_escape($B).")",$g)as$Zg){$w["columns"][]=$Zg["name"];$w["descs"][]=null;}if(preg_match('~^CREATE( UNIQUE)? INDEX '.preg_quote(idf_escape($B).' ON '.idf_escape($Q),'~').' \((.*)\)$~i',$Hh[$B],$Jg)){preg_match_all('/("[^"]*+")+( DESC)?/',$Jg[2],$Ie);foreach($Ie[2]as$y=>$X){if($X)$w["descs"][$y]='1';}}if(!$I[""]||$w["type"]!="UNIQUE"||$w["columns"]!=$I[""]["columns"]||$w["descs"]!=$I[""]["descs"]||!preg_match("~^sqlite_~",$B))$I[$B]=$w;}return$I;}function
foreign_keys($Q){$I=array();foreach(get_rows("PRAGMA foreign_key_list(".table($Q).")")as$J){$q=&$I[$J["id"]];if(!$q)$q=$J;$q["source"][]=$J["from"];$q["target"][]=$J["to"];}return$I;}function
view($B){global$f;return
array("select"=>preg_replace('~^(?:[^`"[]+|`[^`]*`|"[^"]*")* AS\s+~iU','',$f->result("SELECT sql FROM sqlite_master WHERE type = 'view' AND name = ".q($B))));}function
collations(){return(isset($_GET["create"])?get_vals("PRAGMA collation_list",1):array());}function
information_schema($j){return
false;}function
error(){global$f;return
h($f->error);}function
check_sqlite_name($B){global$f;$Vc="db|sdb|sqlite";if(!preg_match("~^[^\\0]*\\.($Vc)\$~",$B)){$f->error=sprintf('è«‹ä½¿ç”¨ä¸‹åˆ—å…¶ä¸­ä¸€å€‹æ“´å……æ¨¡çµ„ %sã€‚',str_replace("|",", ",$Vc));return
false;}return
true;}function
create_database($j,$qb){global$f;if(file_exists($j)){$f->error='æª”æ¡ˆå·²å­˜åœ¨ã€‚';return
false;}if(!check_sqlite_name($j))return
false;try{$_=new
SqliteDb($j);}catch(Exception$Mc){$f->error=$Mc->getMessage();return
false;}$_->query('PRAGMA encoding = "UTF-8"');$_->query('CREATE TABLE adminer (i)');$_->query('DROP TABLE adminer');return
true;}function
drop_databases($i){global$f;$f->__construct(":memory:");foreach($i
as$j){if(!@unlink($j)){$f->error='æª”æ¡ˆå·²å­˜åœ¨ã€‚';return
false;}}return
true;}function
rename_database($B,$qb){global$f;if(!check_sqlite_name($B))return
false;$f->__construct(":memory:");$f->error='æª”æ¡ˆå·²å­˜åœ¨ã€‚';return@rename(DB,$B);}function
auto_increment(){return" PRIMARY KEY AUTOINCREMENT";}function
alter_table($Q,$B,$o,$md,$xb,$Cc,$qb,$La,$ag){global$f;$Ui=($Q==""||$md);foreach($o
as$n){if($n[0]!=""||!$n[1]||$n[2]){$Ui=true;break;}}$c=array();$Of=array();foreach($o
as$n){if($n[1]){$c[]=($Ui?$n[1]:"ADD ".implode($n[1]));if($n[0]!="")$Of[$n[0]]=$n[1][0];}}if(!$Ui){foreach($c
as$X){if(!queries("ALTER TABLE ".table($Q)." $X"))return
false;}if($Q!=$B&&!queries("ALTER TABLE ".table($Q)." RENAME TO ".table($B)))return
false;}elseif(!recreate_table($Q,$B,$c,$Of,$md,$La))return
false;if($La){queries("BEGIN");queries("UPDATE sqlite_sequence SET seq = $La WHERE name = ".q($B));if(!$f->affected_rows)queries("INSERT INTO sqlite_sequence (name, seq) VALUES (".q($B).", $La)");queries("COMMIT");}return
true;}function
recreate_table($Q,$B,$o,$Of,$md,$La=0,$x=array(),$oc="",$wa=""){global$f,$l;if($Q!=""){if(!$o){foreach(fields($Q)as$y=>$n){if($x)$n["auto_increment"]=0;$o[]=process_field($n,$n);$Of[$y]=idf_escape($y);}}$qg=false;foreach($o
as$n){if($n[6])$qg=true;}$qc=array();foreach($x
as$y=>$X){if($X[2]=="DROP"){$qc[$X[1]]=true;unset($x[$y]);}}foreach(indexes($Q)as$me=>$w){$e=array();foreach($w["columns"]as$y=>$d){if(!$Of[$d])continue
2;$e[]=$Of[$d].($w["descs"][$y]?" DESC":"");}if(!$qc[$me]){if($w["type"]!="PRIMARY"||!$qg)$x[]=array($w["type"],$me,$e);}}foreach($x
as$y=>$X){if($X[0]=="PRIMARY"){unset($x[$y]);$md[]="  PRIMARY KEY (".implode(", ",$X[2]).")";}}foreach(foreign_keys($Q)as$me=>$q){foreach($q["source"]as$y=>$d){if(!$Of[$d])continue
2;$q["source"][$y]=idf_unescape($Of[$d]);}if(!isset($md[" $me"]))$md[]=" ".format_foreign_key($q);}queries("BEGIN");}foreach($o
as$y=>$n){if(preg_match('~GENERATED~',$n[3]))unset($Of[array_search($n[0],$Of)]);$o[$y]="  ".implode($n);}$o=array_merge($o,array_filter($md));foreach($l->checkConstraints($Q)as$eb){if($eb!=$oc)$o[]="  CHECK ($eb)";}if($wa)$o[]="  CHECK ($wa)";$fi=($Q==$B?"adminer_$B":$B);if(!queries("CREATE TABLE ".table($fi)." (\n".implode(",\n",$o)."\n)"))return
false;if($Q!=""){if($Of&&!queries("INSERT INTO ".table($fi)." (".implode(", ",$Of).") SELECT ".implode(", ",array_map('Adminer\idf_escape',array_keys($Of)))." FROM ".table($Q)))return
false;$Ei=array();foreach(triggers($Q)as$Ci=>$mi){$Bi=trigger($Ci);$Ei[]="CREATE TRIGGER ".idf_escape($Ci)." ".implode(" ",$mi)." ON ".table($B)."\n$Bi[Statement]";}$La=$La?0:$f->result("SELECT seq FROM sqlite_sequence WHERE name = ".q($Q));if(!queries("DROP TABLE ".table($Q))||($Q==$B&&!queries("ALTER TABLE ".table($fi)." RENAME TO ".table($B)))||!alter_indexes($B,$x))return
false;if($La)queries("UPDATE sqlite_sequence SET seq = $La WHERE name = ".q($B));foreach($Ei
as$Bi){if(!queries($Bi))return
false;}queries("COMMIT");}return
true;}function
index_sql($Q,$U,$B,$e){return"CREATE $U ".($U!="INDEX"?"INDEX ":"").idf_escape($B!=""?$B:uniqid($Q."_"))." ON ".table($Q)." $e";}function
alter_indexes($Q,$c){foreach($c
as$F){if($F[0]=="PRIMARY")return
recreate_table($Q,$Q,array(),array(),array(),0,$c);}foreach(array_reverse($c)as$X){if(!queries($X[2]=="DROP"?"DROP INDEX ".idf_escape($X[1]):index_sql($Q,$X[0],$X[1],"(".implode(", ",$X[2]).")")))return
false;}return
true;}function
truncate_tables($S){return
apply_queries("DELETE FROM",$S);}function
drop_views($gj){return
apply_queries("DROP VIEW",$gj);}function
drop_tables($S){return
apply_queries("DROP TABLE",$S);}function
move_tables($S,$gj,$di){return
false;}function
trigger($B){global$f;if($B=="")return
array("Statement"=>"BEGIN\n\t;\nEND");$v='(?:[^`"\s]+|`[^`]*`|"[^"]*")+';$Di=trigger_options();preg_match("~^CREATE\\s+TRIGGER\\s*$v\\s*(".implode("|",$Di["Timing"]).")\\s+([a-z]+)(?:\\s+OF\\s+($v))?\\s+ON\\s*$v\\s*(?:FOR\\s+EACH\\s+ROW\\s)?(.*)~is",$f->result("SELECT sql FROM sqlite_master WHERE type = 'trigger' AND name = ".q($B)),$A);$mf=$A[3];return
array("Timing"=>strtoupper($A[1]),"Event"=>strtoupper($A[2]).($mf?" OF":""),"Of"=>idf_unescape($mf),"Trigger"=>$B,"Statement"=>$A[4],);}function
triggers($Q){$I=array();$Di=trigger_options();foreach(get_rows("SELECT * FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($Q))as$J){preg_match('~^CREATE\s+TRIGGER\s*(?:[^`"\s]+|`[^`]*`|"[^"]*")+\s*('.implode("|",$Di["Timing"]).')\s*(.*?)\s+ON\b~i',$J["sql"],$A);$I[$J["name"]]=array($A[1],$A[2]);}return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","UPDATE OF","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
begin(){return
queries("BEGIN");}function
last_id(){global$f;return$f->result("SELECT LAST_INSERT_ROWID()");}function
explain($f,$G){return$f->query("EXPLAIN QUERY PLAN $G");}function
found_rows($R,$Z){}function
types(){return
array();}function
create_sql($Q,$La,$Nh){global$f;$I=$f->result("SELECT sql FROM sqlite_master WHERE type IN ('table', 'view') AND name = ".q($Q));foreach(indexes($Q)as$B=>$w){if($B=='')continue;$I.=";\n\n".index_sql($Q,$w['type'],$B,"(".implode(", ",array_map('Adminer\idf_escape',$w['columns'])).")");}return$I;}function
truncate_sql($Q){return"DELETE FROM ".table($Q);}function
use_sql($Ub){}function
trigger_sql($Q){return
implode(get_vals("SELECT sql || ';;\n' FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($Q)));}function
show_variables(){$I=array();foreach(get_rows("PRAGMA pragma_list")as$J){$B=$J["name"];if($B!="pragma_list"&&$B!="compile_options"){foreach(get_rows("PRAGMA $B")as$J)$I[$B].=implode(", ",$J)."\n";}}return$I;}function
show_status(){$I=array();foreach(get_vals("PRAGMA compile_options")as$Bf){list($y,$X)=explode("=",$Bf,2);$I[$y]=$X;}return$I;}function
convert_field($n){}function
unconvert_field($n,$I){return$I;}function
support($ad){return
preg_match('~^(check|columns|database|drop_col|dump|indexes|descidx|move_col|sql|status|table|trigger|variables|view|view_trigger)$~',$ad);}}$mc["pgsql"]="PostgreSQL";if(isset($_GET["pgsql"])){define('Adminer\DRIVER',"pgsql");if(extension_loaded("pgsql")){class
Db{var$extension="PgSQL",$_link,$_result,$_string,$_database=true,$server_info,$affected_rows,$error,$timeout;function
_error($Hc,$m){if(ini_bool("html_errors"))$m=html_entity_decode(strip_tags($m));$m=preg_replace('~^[^:]*: ~','',$m);$this->error=$m;}function
connect($M,$V,$E){global$b;$j=$b->database();set_error_handler(array($this,'_error'));$this->_string="host='".str_replace(":","' port='",addcslashes($M,"'\\"))."' user='".addcslashes($V,"'\\")."' password='".addcslashes($E,"'\\")."'";$Ih=$b->connectSsl();if(isset($Ih["mode"]))$this->_string.=" sslmode='".$Ih["mode"]."'";$this->_link=@pg_connect("$this->_string dbname='".($j!=""?addcslashes($j,"'\\"):"postgres")."'",PGSQL_CONNECT_FORCE_NEW);if(!$this->_link&&$j!=""){$this->_database=false;$this->_link=@pg_connect("$this->_string dbname='postgres'",PGSQL_CONNECT_FORCE_NEW);}restore_error_handler();if($this->_link){$ej=pg_version($this->_link);$this->server_info=$ej["server"];pg_set_client_encoding($this->_link,"UTF8");}return(bool)$this->_link;}function
quote($P){return
pg_escape_literal($this->_link,$P);}function
value($X,$n){return($n["type"]=="bytea"&&$X!==null?pg_unescape_bytea($X):$X);}function
quoteBinary($P){return"'".pg_escape_bytea($this->_link,$P)."'";}function
select_db($Ub){global$b;if($Ub==$b->database())return$this->_database;$I=@pg_connect("$this->_string dbname='".addcslashes($Ub,"'\\")."'",PGSQL_CONNECT_FORCE_NEW);if($I)$this->_link=$I;return$I;}function
close(){$this->_link=@pg_connect("$this->_string dbname='postgres'");}function
query($G,$Ii=false){$H=@pg_query($this->_link,$G);$this->error="";if(!$H){$this->error=pg_last_error($this->_link);$I=false;}elseif(!pg_num_fields($H)){$this->affected_rows=pg_affected_rows($H);$I=true;}else$I=new
Result($H);if($this->timeout){$this->timeout=0;$this->query("RESET statement_timeout");}return$I;}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($G,$n=0){$H=$this->query($G);if(!$H||!$H->num_rows)return
false;return
pg_fetch_result($H->_result,0,$n);}function
warnings(){return
h(pg_last_notice($this->_link));}}class
Result{var$_result,$_offset=0,$num_rows;function
__construct($H){$this->_result=$H;$this->num_rows=pg_num_rows($H);}function
fetch_assoc(){return
pg_fetch_assoc($this->_result);}function
fetch_row(){return
pg_fetch_row($this->_result);}function
fetch_field(){$d=$this->_offset++;$I=new
\stdClass;if(function_exists('pg_field_table'))$I->orgtable=pg_field_table($this->_result,$d);$I->name=pg_field_name($this->_result,$d);$I->orgname=$I->name;$I->type=pg_field_type($this->_result,$d);$I->charsetnr=($I->type=="bytea"?63:0);return$I;}function
__destruct(){pg_free_result($this->_result);}}}elseif(extension_loaded("pdo_pgsql")){class
Db
extends
PdoDb{var$extension="PDO_PgSQL",$timeout;function
connect($M,$V,$E){global$b;$j=$b->database();$sc="pgsql:host='".str_replace(":","' port='",addcslashes($M,"'\\"))."' client_encoding=utf8 dbname='".($j!=""?addcslashes($j,"'\\"):"postgres")."'";$Ih=$b->connectSsl();if(isset($Ih["mode"]))$sc.=" sslmode='".$Ih["mode"]."'";$this->dsn($sc,$V,$E);return
true;}function
select_db($Ub){global$b;return($b->database()==$Ub);}function
quoteBinary($ah){return
q($ah);}function
query($G,$Ii=false){$I=parent::query($G,$Ii);if($this->timeout){$this->timeout=0;parent::query("RESET statement_timeout");}return$I;}function
warnings(){return'';}function
close(){}}}class
Driver
extends
SqlDriver{static$mg=array("PgSQL","PDO_PgSQL");static$ke="pgsql";var$operators=array("=","<",">","<=",">=","!=","~","!~","LIKE","LIKE %%","ILIKE","ILIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL");var$functions=array("char_length","lower","round","to_hex","to_timestamp","upper");var$grouping=array("avg","count","count distinct","max","min","sum");function
__construct($f){parent::__construct($f);$this->types=array('æ•¸å­—'=>array("smallint"=>5,"integer"=>10,"bigint"=>19,"boolean"=>1,"numeric"=>0,"real"=>7,"double precision"=>16,"money"=>20),'æ—¥æœŸæ™‚é–“'=>array("date"=>13,"time"=>17,"timestamp"=>20,"timestamptz"=>21,"interval"=>0),'å­—ä¸²'=>array("character"=>0,"character varying"=>0,"text"=>0,"tsquery"=>0,"tsvector"=>0,"uuid"=>0,"xml"=>0),'äºŒé€²ä½'=>array("bit"=>0,"bit varying"=>0,"bytea"=>0),'ç¶²è·¯'=>array("cidr"=>43,"inet"=>43,"macaddr"=>17,"macaddr8"=>23,"txid_snapshot"=>0),'å¹¾ä½•'=>array("box"=>0,"circle"=>0,"line"=>0,"lseg"=>0,"path"=>0,"point"=>0,"polygon"=>0),);if(min_version(9.2,0,$f)){$this->types['å­—ä¸²']["json"]=4294967295;if(min_version(9.4,0,$f))$this->types['å­—ä¸²']["jsonb"]=4294967295;}$this->editFunctions=array(array("char"=>"md5","date|time"=>"now",),array(number_type()=>"+/-","date|time"=>"+ interval/- interval","char|text"=>"||",));if(min_version(12,0,$f))$this->generated=array("STORED");}function
setUserTypes($Hi){$this->types['ä½¿ç”¨è€…é¡å‹']=array_flip($Hi);}function
insertUpdate($Q,$K,$F){global$f;foreach($K
as$N){$Qi=array();$Z=array();foreach($N
as$y=>$X){$Qi[]="$y = $X";if(isset($F[idf_unescape($y)]))$Z[]="$y = $X";}if(!(($Z&&queries("UPDATE ".table($Q)." SET ".implode(", ",$Qi)." WHERE ".implode(" AND ",$Z))&&$f->affected_rows)||queries("INSERT INTO ".table($Q)." (".implode(", ",array_keys($N)).") VALUES (".implode(", ",$N).")")))return
false;}return
true;}function
slowQuery($G,$li){$this->_conn->query("SET statement_timeout = ".(1000*$li));$this->_conn->timeout=1000*$li;return$G;}function
convertSearch($v,$X,$n){$ii="char|text";if(strpos($X["op"],"LIKE")===false)$ii.="|date|time(stamp)?|boolean|uuid|inet|cidr|macaddr|".number_type();return(preg_match("~$ii~",$n["type"])?$v:"CAST($v AS text)");}function
quoteBinary($ah){return$this->_conn->quoteBinary($ah);}function
warnings(){return$this->_conn->warnings();}function
tableHelp($B,$he=false){$Be=array("information_schema"=>"infoschema","pg_catalog"=>($he?"view":"catalog"),);$_=$Be[$_GET["ns"]];if($_)return"$_-".str_replace("_","-",$B).".html";}function
supportsIndex($R){return$R["Engine"]!="view";}function
hasCStyleEscapes(){static$Za;if($Za===null)$Za=($this->_conn->result("SHOW standard_conforming_strings")=="off");return$Za;}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect($Nb){$f=new
Db;if($f->connect($Nb[0],$Nb[1],$Nb[2])){if(min_version(9,0,$f))$f->query("SET application_name = 'Adminer'");return$f;}return$f->error;}function
get_databases(){return
get_vals("SELECT datname FROM pg_database
WHERE datallowconn = TRUE AND has_database_privilege(datname, 'CONNECT')
ORDER BY datname");}function
limit($G,$Z,$z,$C=0,$lh=" "){return" $G$Z".($z!==null?$lh."LIMIT $z".($C?" OFFSET $C":""):"");}function
limit1($Q,$G,$Z,$lh="\n"){return(preg_match('~^INTO~',$G)?limit($G,$Z,1,0,$lh):" $G".(is_view(table_status1($Q))?$Z:$lh."WHERE ctid = (SELECT ctid FROM ".table($Q).$Z.$lh."LIMIT 1)"));}function
db_collation($j,$rb){global$f;return$f->result("SELECT datcollate FROM pg_database WHERE datname = ".q($j));}function
engines(){return
array();}function
logged_user(){global$f;return$f->result("SELECT user");}function
tables_list(){$G="SELECT table_name, table_type FROM information_schema.tables WHERE table_schema = current_schema()";if(support("materializedview"))$G.="
UNION ALL
SELECT matviewname, 'MATERIALIZED VIEW'
FROM pg_matviews
WHERE schemaname = current_schema()";$G.="
ORDER BY 1";return
get_key_vals($G);}function
count_tables($i){global$f;$I=array();foreach($i
as$j){if($f->select_db($j))$I[$j]=count(tables_list());}return$I;}function
table_status($B=""){$I=array();foreach(get_rows("SELECT
	c.relname AS \"Name\",
	CASE c.relkind WHEN 'r' THEN 'table' WHEN 'm' THEN 'materialized view' ELSE 'view' END AS \"Engine\",
	pg_table_size(c.oid) AS \"Data_length\",
	pg_indexes_size(c.oid) AS \"Index_length\",
	obj_description(c.oid, 'pg_class') AS \"Comment\",
	".(min_version(12)?"''":"CASE WHEN c.relhasoids THEN 'oid' ELSE '' END")." AS \"Oid\",
	c.reltuples as \"Rows\",
	n.nspname
FROM pg_class c
JOIN pg_namespace n ON(n.nspname = current_schema() AND n.oid = c.relnamespace)
WHERE relkind IN ('r', 'm', 'v', 'f', 'p')
".($B!=""?"AND relname = ".q($B):"ORDER BY relname"))as$J)$I[$J["Name"]]=$J;return($B!=""?$I[$B]:$I);}function
is_view($R){return
in_array($R["Engine"],array("view","materialized view"));}function
fk_support($R){return
true;}function
fields($Q){$I=array();$Ca=array('timestamp without time zone'=>'timestamp','timestamp with time zone'=>'timestamptz',);foreach(get_rows("SELECT a.attname AS field, format_type(a.atttypid, a.atttypmod) AS full_type, pg_get_expr(d.adbin, d.adrelid) AS default, a.attnotnull::int, col_description(c.oid, a.attnum) AS comment".(min_version(10)?", a.attidentity".(min_version(12)?", a.attgenerated":""):"")."
FROM pg_class c
JOIN pg_namespace n ON c.relnamespace = n.oid
JOIN pg_attribute a ON c.oid = a.attrelid
LEFT JOIN pg_attrdef d ON c.oid = d.adrelid AND a.attnum = d.adnum
WHERE c.relname = ".q($Q)."
AND n.nspname = current_schema()
AND NOT a.attisdropped
AND a.attnum > 0
ORDER BY a.attnum")as$J){preg_match('~([^([]+)(\((.*)\))?([a-z ]+)?((\[[0-9]*])*)$~',$J["full_type"],$A);list(,$U,$ze,$J["length"],$xa,$Fa)=$A;$J["length"].=$Fa;$gb=$U.$xa;if(isset($Ca[$gb])){$J["type"]=$Ca[$gb];$J["full_type"]=$J["type"].$ze.$Fa;}else{$J["type"]=$U;$J["full_type"]=$J["type"].$ze.$xa.$Fa;}if(in_array($J['attidentity'],array('a','d')))$J['default']='GENERATED '.($J['attidentity']=='d'?'BY DEFAULT':'ALWAYS').' AS IDENTITY';$J["generated"]=($J["attgenerated"]=="s"?"STORED":"");$J["null"]=!$J["attnotnull"];$J["auto_increment"]=$J['attidentity']||preg_match('~^nextval\(~i',$J["default"]);$J["privileges"]=array("insert"=>1,"select"=>1,"update"=>1);if(preg_match('~(.+)::[^,)]+(.*)~',$J["default"],$A))$J["default"]=($A[1]=="NULL"?null:idf_unescape($A[1]).$A[2]);$I[$J["field"]]=$J;}return$I;}function
indexes($Q,$g=null){global$f;if(!is_object($g))$g=$f;$I=array();$Wh=$g->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = ".q($Q));$e=get_key_vals("SELECT attnum, attname FROM pg_attribute WHERE attrelid = $Wh AND attnum > 0",$g);foreach(get_rows("SELECT relname, indisunique::int, indisprimary::int, indkey, indoption, (indpred IS NOT NULL)::int as indispartial FROM pg_index i, pg_class ci WHERE i.indrelid = $Wh AND ci.oid = i.indexrelid ORDER BY indisprimary DESC, indisunique DESC",$g)as$J){$Kg=$J["relname"];$I[$Kg]["type"]=($J["indispartial"]?"INDEX":($J["indisprimary"]?"PRIMARY":($J["indisunique"]?"UNIQUE":"INDEX")));$I[$Kg]["columns"]=array();$I[$Kg]["descs"]=array();if($J["indkey"]){foreach(explode(" ",$J["indkey"])as$Ud)$I[$Kg]["columns"][]=$e[$Ud];foreach(explode(" ",$J["indoption"])as$Vd)$I[$Kg]["descs"][]=($Vd&1?'1':null);}$I[$Kg]["lengths"]=array();}return$I;}function
foreign_keys($Q){global$l;$I=array();foreach(get_rows("SELECT conname, condeferrable::int AS deferrable, pg_get_constraintdef(oid) AS definition
FROM pg_constraint
WHERE conrelid = (SELECT pc.oid FROM pg_class AS pc INNER JOIN pg_namespace AS pn ON (pn.oid = pc.relnamespace) WHERE pc.relname = ".q($Q)." AND pn.nspname = current_schema())
AND contype = 'f'::char
ORDER BY conkey, conname")as$J){if(preg_match('~FOREIGN KEY\s*\((.+)\)\s*REFERENCES (.+)\((.+)\)(.*)$~iA',$J['definition'],$A)){$J['source']=array_map('Adminer\idf_unescape',array_map('trim',explode(',',$A[1])));if(preg_match('~^(("([^"]|"")+"|[^"]+)\.)?"?("([^"]|"")+"|[^"]+)$~',$A[2],$He)){$J['ns']=idf_unescape($He[2]);$J['table']=idf_unescape($He[4]);}$J['target']=array_map('Adminer\idf_unescape',array_map('trim',explode(',',$A[3])));$J['on_delete']=(preg_match("~ON DELETE ($l->onActions)~",$A[4],$He)?$He[1]:'NO ACTION');$J['on_update']=(preg_match("~ON UPDATE ($l->onActions)~",$A[4],$He)?$He[1]:'NO ACTION');$I[$J['conname']]=$J;}}return$I;}function
view($B){global$f;return
array("select"=>trim($f->result("SELECT pg_get_viewdef(".$f->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = ".q($B)).")")));}function
collations(){return
array();}function
information_schema($j){return
get_schema()=="information_schema";}function
error(){global$f;$I=h($f->error);if(preg_match('~^(.*\n)?([^\n]*)\n( *)\^(\n.*)?$~s',$I,$A))$I=$A[1].preg_replace('~((?:[^&]|&[^;]*;){'.strlen($A[3]).'})(.*)~','\1<b>\2</b>',$A[2]).$A[4];return
nl_br($I);}function
create_database($j,$qb){return
queries("CREATE DATABASE ".idf_escape($j).($qb?" ENCODING ".idf_escape($qb):""));}function
drop_databases($i){global$f;$f->close();return
apply_queries("DROP DATABASE",$i,'Adminer\idf_escape');}function
rename_database($B,$qb){global$f;$f->close();return
queries("ALTER DATABASE ".idf_escape(DB)." RENAME TO ".idf_escape($B));}function
auto_increment(){return"";}function
alter_table($Q,$B,$o,$md,$xb,$Cc,$qb,$La,$ag){$c=array();$zg=array();if($Q!=""&&$Q!=$B)$zg[]="ALTER TABLE ".table($Q)." RENAME TO ".table($B);$mh="";foreach($o
as$n){$d=idf_escape($n[0]);$X=$n[1];if(!$X)$c[]="DROP $d";else{$aj=$X[5];unset($X[5]);if($n[0]==""){if(isset($X[6]))$X[1]=($X[1]==" bigint"?" big":($X[1]==" smallint"?" small":" "))."serial";$c[]=($Q!=""?"ADD ":"  ").implode($X);if(isset($X[6]))$c[]=($Q!=""?"ADD":" ")." PRIMARY KEY ($X[0])";}else{if($d!=$X[0])$zg[]="ALTER TABLE ".table($B)." RENAME $d TO $X[0]";$c[]="ALTER $d TYPE$X[1]";$nh=$Q."_".idf_unescape($X[0])."_seq";$c[]="ALTER $d ".($X[3]?"SET".preg_replace('~GENERATED ALWAYS(.*) STORED~','EXPRESSION\1',$X[3]):(isset($X[6])?"SET DEFAULT nextval(".q($nh).")":"DROP DEFAULT"));if(isset($X[6]))$mh="CREATE SEQUENCE IF NOT EXISTS ".idf_escape($nh)." OWNED BY ".idf_escape($Q).".$X[0]";$c[]="ALTER $d ".($X[2]==" NULL"?"DROP NOT":"SET").$X[2];}if($n[0]!=""||$aj!="")$zg[]="COMMENT ON COLUMN ".table($B).".$X[0] IS ".($aj!=""?substr($aj,9):"''");}}$c=array_merge($c,$md);if($Q=="")array_unshift($zg,"CREATE TABLE ".table($B)." (\n".implode(",\n",$c)."\n)");elseif($c)array_unshift($zg,"ALTER TABLE ".table($Q)."\n".implode(",\n",$c));if($mh)array_unshift($zg,$mh);if($xb!==null)$zg[]="COMMENT ON TABLE ".table($B)." IS ".q($xb);foreach($zg
as$G){if(!queries($G))return
false;}return
true;}function
alter_indexes($Q,$c){$h=array();$nc=array();$zg=array();foreach($c
as$X){if($X[0]!="INDEX")$h[]=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");elseif($X[2]=="DROP")$nc[]=idf_escape($X[1]);else$zg[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($Q."_"))." ON ".table($Q)." (".implode(", ",$X[2]).")";}if($h)array_unshift($zg,"ALTER TABLE ".table($Q).implode(",",$h));if($nc)array_unshift($zg,"DROP INDEX ".implode(", ",$nc));foreach($zg
as$G){if(!queries($G))return
false;}return
true;}function
truncate_tables($S){return
queries("TRUNCATE ".implode(", ",array_map('Adminer\table',$S)));return
true;}function
drop_views($gj){return
drop_tables($gj);}function
drop_tables($S){foreach($S
as$Q){$O=table_status($Q);if(!queries("DROP ".strtoupper($O["Engine"])." ".table($Q)))return
false;}return
true;}function
move_tables($S,$gj,$di){foreach(array_merge($S,$gj)as$Q){$O=table_status($Q);if(!queries("ALTER ".strtoupper($O["Engine"])." ".table($Q)." SET SCHEMA ".idf_escape($di)))return
false;}return
true;}function
trigger($B,$Q){if($B=="")return
array("Statement"=>"EXECUTE PROCEDURE ()");$e=array();$Z="WHERE trigger_schema = current_schema() AND event_object_table = ".q($Q)." AND trigger_name = ".q($B);foreach(get_rows("SELECT * FROM information_schema.triggered_update_columns $Z")as$J)$e[]=$J["event_object_column"];$I=array();foreach(get_rows('SELECT trigger_name AS "Trigger", action_timing AS "Timing", event_manipulation AS "Event", \'FOR EACH \' || action_orientation AS "Type", action_statement AS "Statement" FROM information_schema.triggers '."$Z ORDER BY event_manipulation DESC")as$J){if($e&&$J["Event"]=="UPDATE")$J["Event"].=" OF";$J["Of"]=implode(", ",$e);if($I)$J["Event"].=" OR $I[Event]";$I=$J;}return$I;}function
triggers($Q){$I=array();foreach(get_rows("SELECT * FROM information_schema.triggers WHERE trigger_schema = current_schema() AND event_object_table = ".q($Q))as$J){$Bi=trigger($J["trigger_name"],$Q);$I[$Bi["Trigger"]]=array($Bi["Timing"],$Bi["Event"]);}return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","UPDATE OF","DELETE","INSERT OR UPDATE","INSERT OR UPDATE OF","DELETE OR INSERT","DELETE OR UPDATE","DELETE OR UPDATE OF","DELETE OR INSERT OR UPDATE","DELETE OR INSERT OR UPDATE OF"),"Type"=>array("FOR EACH ROW","FOR EACH STATEMENT"),);}function
routine($B,$U){$K=get_rows('SELECT routine_definition AS definition, LOWER(external_language) AS language, *
FROM information_schema.routines
WHERE routine_schema = current_schema() AND specific_name = '.q($B));$I=$K[0];$I["returns"]=array("type"=>$I["type_udt_name"]);$I["fields"]=get_rows('SELECT parameter_name AS field, data_type AS type, character_maximum_length AS length, parameter_mode AS inout
FROM information_schema.parameters
WHERE specific_schema = current_schema() AND specific_name = '.q($B).'
ORDER BY ordinal_position');return$I;}function
routines(){return
get_rows('SELECT specific_name AS "SPECIFIC_NAME", routine_type AS "ROUTINE_TYPE", routine_name AS "ROUTINE_NAME", type_udt_name AS "DTD_IDENTIFIER"
FROM information_schema.routines
WHERE routine_schema = current_schema()
ORDER BY SPECIFIC_NAME');}function
routine_languages(){return
get_vals("SELECT LOWER(lanname) FROM pg_catalog.pg_language");}function
routine_id($B,$J){$I=array();foreach($J["fields"]as$n)$I[]=$n["type"];return
idf_escape($B)."(".implode(", ",$I).")";}function
last_id(){return
0;}function
explain($f,$G){return$f->query("EXPLAIN $G");}function
found_rows($R,$Z){global$f;if(preg_match("~ rows=([0-9]+)~",$f->result("EXPLAIN SELECT * FROM ".idf_escape($R["Name"]).($Z?" WHERE ".implode(" AND ",$Z):"")),$Jg))return$Jg[1];return
false;}function
types(){return
get_key_vals("SELECT oid, typname
FROM pg_type
WHERE typnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema())
AND typtype IN ('b','d','e')
AND typelem = 0");}function
type_values($u){$Gc=get_vals("SELECT enumlabel FROM pg_enum WHERE enumtypid = $u ORDER BY enumsortorder");return($Gc?"'".implode("', '",array_map('addslashes',$Gc))."'":"");}function
schemas(){return
get_vals("SELECT nspname FROM pg_namespace ORDER BY nspname");}function
get_schema(){global$f;return$f->result("SELECT current_schema()");}function
set_schema($ch,$g=null){global$f,$l;if(!$g)$g=$f;$I=$g->query("SET search_path TO ".idf_escape($ch));$l->setUserTypes(types());return$I;}function
foreign_keys_sql($Q){$I="";$O=table_status($Q);$jd=foreign_keys($Q);ksort($jd);foreach($jd
as$id=>$hd)$I.="ALTER TABLE ONLY ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." ADD CONSTRAINT ".idf_escape($id)." $hd[definition] ".($hd['deferrable']?'DEFERRABLE':'NOT DEFERRABLE').";\n";return($I?"$I\n":$I);}function
create_sql($Q,$La,$Nh){global$l;$Sg=array();$oh=array();$O=table_status($Q);if(is_view($O)){$fj=view($Q);return
rtrim("CREATE VIEW ".idf_escape($Q)." AS $fj[select]",";");}$o=fields($Q);if(!$O||empty($o))return
false;$I="CREATE TABLE ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." (\n    ";foreach($o
as$n){$Xf=idf_escape($n['field']).' '.$n['full_type'].default_value($n).($n['attnotnull']?" NOT NULL":"");$Sg[]=$Xf;if(preg_match('~nextval\(\'([^\']+)\'\)~',$n['default'],$Ie)){$nh=$Ie[1];$Ch=reset(get_rows((min_version(10)?"SELECT *, cache_size AS cache_value FROM pg_sequences WHERE schemaname = current_schema() AND sequencename = ".q(idf_unescape($nh)):"SELECT * FROM $nh"),null,"-- "));$oh[]=($Nh=="DROP+CREATE"?"DROP SEQUENCE IF EXISTS $nh;\n":"")."CREATE SEQUENCE $nh INCREMENT $Ch[increment_by] MINVALUE $Ch[min_value] MAXVALUE $Ch[max_value]".($La&&$Ch['last_value']?" START ".($Ch["last_value"]+1):"")." CACHE $Ch[cache_value];";}}if(!empty($oh))$I=implode("\n\n",$oh)."\n\n$I";$F="";foreach(indexes($Q)as$Sd=>$w){if($w['type']=='PRIMARY'){$F=$Sd;$Sg[]="CONSTRAINT ".idf_escape($Sd)." PRIMARY KEY (".implode(', ',array_map('Adminer\idf_escape',$w['columns'])).")";}}foreach($l->checkConstraints($Q)as$Bb=>$Db)$Sg[]="CONSTRAINT ".idf_escape($Bb)." CHECK $Db";$I.=implode(",\n    ",$Sg)."\n) WITH (oids = ".($O['Oid']?'true':'false').");";if($O['Comment'])$I.="\n\nCOMMENT ON TABLE ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." IS ".q($O['Comment']).";";foreach($o
as$cd=>$n){if($n['comment'])$I.="\n\nCOMMENT ON COLUMN ".idf_escape($O['nspname']).".".idf_escape($O['Name']).".".idf_escape($cd)." IS ".q($n['comment']).";";}foreach(get_rows("SELECT indexdef FROM pg_catalog.pg_indexes WHERE schemaname = current_schema() AND tablename = ".q($Q).($F?" AND indexname != ".q($F):""),null,"-- ")as$J)$I.="\n\n$J[indexdef];";return
rtrim($I,';');}function
truncate_sql($Q){return"TRUNCATE ".table($Q);}function
trigger_sql($Q){$O=table_status($Q);$I="";foreach(triggers($Q)as$Ai=>$_i){$Bi=trigger($Ai,$O['Name']);$I.="\nCREATE TRIGGER ".idf_escape($Bi['Trigger'])." $Bi[Timing] $Bi[Event] ON ".idf_escape($O["nspname"]).".".idf_escape($O['Name'])." $Bi[Type] $Bi[Statement];;\n";}return$I;}function
use_sql($Ub){return"\connect ".idf_escape($Ub);}function
show_variables(){return
get_key_vals("SHOW ALL");}function
process_list(){return
get_rows("SELECT * FROM pg_stat_activity ORDER BY ".(min_version(9.2)?"pid":"procpid"));}function
convert_field($n){}function
unconvert_field($n,$I){return$I;}function
support($ad){return
preg_match('~^(check|database|table|columns|sql|indexes|descidx|comment|view|'.(min_version(9.3)?'materializedview|':'').'scheme|routine|processlist|sequence|trigger|type|variables|drop_col|kill|dump)$~',$ad);}function
kill_process($X){return
queries("SELECT pg_terminate_backend(".number($X).")");}function
connection_id(){return"SELECT pg_backend_pid()";}function
max_connections(){global$f;return$f->result("SHOW max_connections");}}$mc["oracle"]="Oracle (beta)";if(isset($_GET["oracle"])){define('Adminer\DRIVER',"oracle");if(extension_loaded("oci8")){class
Db{var$extension="oci8",$_link,$_result,$server_info,$affected_rows,$errno,$error;var$_current_db;function
_error($Hc,$m){if(ini_bool("html_errors"))$m=html_entity_decode(strip_tags($m));$m=preg_replace('~^[^:]*: ~','',$m);$this->error=$m;}function
connect($M,$V,$E){$this->_link=@oci_new_connect($V,$E,$M,"AL32UTF8");if($this->_link){$this->server_info=oci_server_version($this->_link);return
true;}$m=oci_error();$this->error=$m["message"];return
false;}function
quote($P){return"'".str_replace("'","''",$P)."'";}function
select_db($Ub){$this->_current_db=$Ub;return
true;}function
query($G,$Ii=false){$H=oci_parse($this->_link,$G);$this->error="";if(!$H){$m=oci_error($this->_link);$this->errno=$m["code"];$this->error=$m["message"];return
false;}set_error_handler(array($this,'_error'));$I=@oci_execute($H);restore_error_handler();if($I){if(oci_num_fields($H))return
new
Result($H);$this->affected_rows=oci_num_rows($H);oci_free_statement($H);}return$I;}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($G,$n=1){$H=$this->query($G);if(!is_object($H)||!oci_fetch($H->_result))return
false;return
oci_result($H->_result,$n);}}class
Result{var$_result,$_offset=1,$num_rows;function
__construct($H){$this->_result=$H;}function
_convert($J){foreach((array)$J
as$y=>$X){if(is_a($X,'OCI-Lob'))$J[$y]=$X->load();}return$J;}function
fetch_assoc(){return$this->_convert(oci_fetch_assoc($this->_result));}function
fetch_row(){return$this->_convert(oci_fetch_row($this->_result));}function
fetch_field(){$d=$this->_offset++;$I=new
\stdClass;$I->name=oci_field_name($this->_result,$d);$I->orgname=$I->name;$I->type=oci_field_type($this->_result,$d);$I->charsetnr=(preg_match("~raw|blob|bfile~",$I->type)?63:0);return$I;}function
__destruct(){oci_free_statement($this->_result);}}}elseif(extension_loaded("pdo_oci")){class
Db
extends
PdoDb{var$extension="PDO_OCI";var$_current_db;function
connect($M,$V,$E){$this->dsn("oci:dbname=//$M;charset=AL32UTF8",$V,$E);return
true;}function
select_db($Ub){$this->_current_db=$Ub;return
true;}}}class
Driver
extends
SqlDriver{static$mg=array("OCI8","PDO_OCI");static$ke="oracle";var$editFunctions=array(array("date"=>"current_date","timestamp"=>"current_timestamp",),array("number|float|double"=>"+/-","date|timestamp"=>"+ interval/- interval","char|clob"=>"||",));var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL");var$functions=array("length","lower","round","upper");var$grouping=array("avg","count","count distinct","max","min","sum");function
__construct($f){parent::__construct($f);$this->types=array('æ•¸å­—'=>array("number"=>38,"binary_float"=>12,"binary_double"=>21),'æ—¥æœŸæ™‚é–“'=>array("date"=>10,"timestamp"=>29,"interval year"=>12,"interval day"=>28),'å­—ä¸²'=>array("char"=>2000,"varchar2"=>4000,"nchar"=>2000,"nvarchar2"=>4000,"clob"=>4294967295,"nclob"=>4294967295),'äºŒé€²ä½'=>array("raw"=>2000,"long raw"=>2147483648,"blob"=>4294967295,"bfile"=>4294967296),);}function
begin(){return
true;}function
insertUpdate($Q,$K,$F){global$f;foreach($K
as$N){$Qi=array();$Z=array();foreach($N
as$y=>$X){$Qi[]="$y = $X";if(isset($F[idf_unescape($y)]))$Z[]="$y = $X";}if(!(($Z&&queries("UPDATE ".table($Q)." SET ".implode(", ",$Qi)." WHERE ".implode(" AND ",$Z))&&$f->affected_rows)||queries("INSERT INTO ".table($Q)." (".implode(", ",array_keys($N)).") VALUES (".implode(", ",$N).")")))return
false;}return
true;}function
hasCStyleEscapes(){return
true;}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect($Nb){$f=new
Db;if($f->connect($Nb[0],$Nb[1],$Nb[2]))return$f;return$f->error;}function
get_databases(){return
get_vals("SELECT DISTINCT tablespace_name FROM (
SELECT tablespace_name FROM user_tablespaces
UNION SELECT tablespace_name FROM all_tables WHERE tablespace_name IS NOT NULL
)
ORDER BY 1");}function
limit($G,$Z,$z,$C=0,$lh=" "){return($C?" * FROM (SELECT t.*, rownum AS rnum FROM (SELECT $G$Z) t WHERE rownum <= ".($z+$C).") WHERE rnum > $C":($z!==null?" * FROM (SELECT $G$Z) WHERE rownum <= ".($z+$C):" $G$Z"));}function
limit1($Q,$G,$Z,$lh="\n"){return" $G$Z";}function
db_collation($j,$rb){global$f;return$f->result("SELECT value FROM nls_database_parameters WHERE parameter = 'NLS_CHARACTERSET'");}function
engines(){return
array();}function
logged_user(){global$f;return$f->result("SELECT USER FROM DUAL");}function
get_current_db(){global$f;$j=$f->_current_db?:DB;unset($f->_current_db);return$j;}function
where_owner($og,$Rf="owner"){if(!$_GET["ns"])return'';return"$og$Rf = sys_context('USERENV', 'CURRENT_SCHEMA')";}function
views_table($e){$Rf=where_owner('');return"(SELECT $e FROM all_views WHERE ".($Rf?:"rownum < 0").")";}function
tables_list(){$fj=views_table("view_name");$Rf=where_owner(" AND ");return
get_key_vals("SELECT table_name, 'table' FROM all_tables WHERE tablespace_name = ".q(DB)."$Rf
UNION SELECT view_name, 'view' FROM $fj
ORDER BY 1");}function
count_tables($i){global$f;$I=array();foreach($i
as$j)$I[$j]=$f->result("SELECT COUNT(*) FROM all_tables WHERE tablespace_name = ".q($j));return$I;}function
table_status($B=""){$I=array();$fh=q($B);$j=get_current_db();$fj=views_table("view_name");$Rf=where_owner(" AND ");foreach(get_rows('SELECT table_name "Name", \'table\' "Engine", avg_row_len * num_rows "Data_length", num_rows "Rows" FROM all_tables WHERE tablespace_name = '.q($j).$Rf.($B!=""?" AND table_name = $fh":"")."
UNION SELECT view_name, 'view', 0, 0 FROM $fj".($B!=""?" WHERE view_name = $fh":"")."
ORDER BY 1")as$J){if($B!="")return$J;$I[$J["Name"]]=$J;}return$I;}function
is_view($R){return$R["Engine"]=="view";}function
fk_support($R){return
true;}function
fields($Q){$I=array();$Rf=where_owner(" AND ");foreach(get_rows("SELECT * FROM all_tab_columns WHERE table_name = ".q($Q)."$Rf ORDER BY column_id")as$J){$U=$J["DATA_TYPE"];$ze="$J[DATA_PRECISION],$J[DATA_SCALE]";if($ze==",")$ze=$J["CHAR_COL_DECL_LENGTH"];$I[$J["COLUMN_NAME"]]=array("field"=>$J["COLUMN_NAME"],"full_type"=>$U.($ze?"($ze)":""),"type"=>strtolower($U),"length"=>$ze,"default"=>$J["DATA_DEFAULT"],"null"=>($J["NULLABLE"]=="Y"),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),);}return$I;}function
indexes($Q,$g=null){$I=array();$Rf=where_owner(" AND ","aic.table_owner");foreach(get_rows("SELECT aic.*, ac.constraint_type, atc.data_default
FROM all_ind_columns aic
LEFT JOIN all_constraints ac ON aic.index_name = ac.constraint_name AND aic.table_name = ac.table_name AND aic.index_owner = ac.owner
LEFT JOIN all_tab_cols atc ON aic.column_name = atc.column_name AND aic.table_name = atc.table_name AND aic.index_owner = atc.owner
WHERE aic.table_name = ".q($Q)."$Rf
ORDER BY ac.constraint_type, aic.column_position",$g)as$J){$Sd=$J["INDEX_NAME"];$ub=$J["DATA_DEFAULT"];$ub=($ub?trim($ub,'"'):$J["COLUMN_NAME"]);$I[$Sd]["type"]=($J["CONSTRAINT_TYPE"]=="P"?"PRIMARY":($J["CONSTRAINT_TYPE"]=="U"?"UNIQUE":"INDEX"));$I[$Sd]["columns"][]=$ub;$I[$Sd]["lengths"][]=($J["CHAR_LENGTH"]&&$J["CHAR_LENGTH"]!=$J["COLUMN_LENGTH"]?$J["CHAR_LENGTH"]:null);$I[$Sd]["descs"][]=($J["DESCEND"]&&$J["DESCEND"]=="DESC"?'1':null);}return$I;}function
view($B){$fj=views_table("view_name, text");$K=get_rows('SELECT text "select" FROM '.$fj.' WHERE view_name = '.q($B));return
reset($K);}function
collations(){return
array();}function
information_schema($j){return
get_schema()=="INFORMATION_SCHEMA";}function
error(){global$f;return
h($f->error);}function
explain($f,$G){$f->query("EXPLAIN PLAN FOR $G");return$f->query("SELECT * FROM plan_table");}function
found_rows($R,$Z){}function
auto_increment(){return"";}function
alter_table($Q,$B,$o,$md,$xb,$Cc,$qb,$La,$ag){$c=$nc=array();$Kf=($Q?fields($Q):array());foreach($o
as$n){$X=$n[1];if($X&&$n[0]!=""&&idf_escape($n[0])!=$X[0])queries("ALTER TABLE ".table($Q)." RENAME COLUMN ".idf_escape($n[0])." TO $X[0]");$Jf=$Kf[$n[0]];if($X&&$Jf){$of=process_field($Jf,$Jf);if($X[2]==$of[2])$X[2]="";}if($X)$c[]=($Q!=""?($n[0]!=""?"MODIFY (":"ADD ("):"  ").implode($X).($Q!=""?")":"");else$nc[]=idf_escape($n[0]);}if($Q=="")return
queries("CREATE TABLE ".table($B)." (\n".implode(",\n",$c)."\n)");return(!$c||queries("ALTER TABLE ".table($Q)."\n".implode("\n",$c)))&&(!$nc||queries("ALTER TABLE ".table($Q)." DROP (".implode(", ",$nc).")"))&&($Q==$B||queries("ALTER TABLE ".table($Q)." RENAME TO ".table($B)));}function
alter_indexes($Q,$c){$nc=array();$zg=array();foreach($c
as$X){if($X[0]!="INDEX"){$X[2]=preg_replace('~ DESC$~','',$X[2]);$h=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");array_unshift($zg,"ALTER TABLE ".table($Q).$h);}elseif($X[2]=="DROP")$nc[]=idf_escape($X[1]);else$zg[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($Q."_"))." ON ".table($Q)." (".implode(", ",$X[2]).")";}if($nc)array_unshift($zg,"DROP INDEX ".implode(", ",$nc));foreach($zg
as$G){if(!queries($G))return
false;}return
true;}function
foreign_keys($Q){$I=array();$G="SELECT c_list.CONSTRAINT_NAME as NAME,
c_src.COLUMN_NAME as SRC_COLUMN,
c_dest.OWNER as DEST_DB,
c_dest.TABLE_NAME as DEST_TABLE,
c_dest.COLUMN_NAME as DEST_COLUMN,
c_list.DELETE_RULE as ON_DELETE
FROM ALL_CONSTRAINTS c_list, ALL_CONS_COLUMNS c_src, ALL_CONS_COLUMNS c_dest
WHERE c_list.CONSTRAINT_NAME = c_src.CONSTRAINT_NAME
AND c_list.R_CONSTRAINT_NAME = c_dest.CONSTRAINT_NAME
AND c_list.CONSTRAINT_TYPE = 'R'
AND c_src.TABLE_NAME = ".q($Q);foreach(get_rows($G)as$J)$I[$J['NAME']]=array("db"=>$J['DEST_DB'],"table"=>$J['DEST_TABLE'],"source"=>array($J['SRC_COLUMN']),"target"=>array($J['DEST_COLUMN']),"on_delete"=>$J['ON_DELETE'],"on_update"=>null,);return$I;}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($gj){return
apply_queries("DROP VIEW",$gj);}function
drop_tables($S){return
apply_queries("DROP TABLE",$S);}function
last_id(){return
0;}function
schemas(){$I=get_vals("SELECT DISTINCT owner FROM dba_segments WHERE owner IN (SELECT username FROM dba_users WHERE default_tablespace NOT IN ('SYSTEM','SYSAUX')) ORDER BY 1");return($I?:get_vals("SELECT DISTINCT owner FROM all_tables WHERE tablespace_name = ".q(DB)." ORDER BY 1"));}function
get_schema(){global$f;return$f->result("SELECT sys_context('USERENV', 'SESSION_USER') FROM dual");}function
set_schema($eh,$g=null){global$f;if(!$g)$g=$f;return$g->query("ALTER SESSION SET CURRENT_SCHEMA = ".idf_escape($eh));}function
show_variables(){return
get_key_vals('SELECT name, display_value FROM v$parameter');}function
process_list(){return
get_rows('SELECT sess.process AS "process", sess.username AS "user", sess.schemaname AS "schema", sess.status AS "status", sess.wait_class AS "wait_class", sess.seconds_in_wait AS "seconds_in_wait", sql.sql_text AS "sql_text", sess.machine AS "machine", sess.port AS "port"
FROM v$session sess LEFT OUTER JOIN v$sql sql
ON sql.sql_id = sess.sql_id
WHERE sess.type = \'USER\'
ORDER BY PROCESS
');}function
show_status(){$K=get_rows('SELECT * FROM v$instance');return
reset($K);}function
convert_field($n){}function
unconvert_field($n,$I){return$I;}function
support($ad){return
preg_match('~^(columns|database|drop_col|indexes|descidx|processlist|scheme|sql|status|table|variables|view)$~',$ad);}}$mc["mssql"]="MS SQL";if(isset($_GET["mssql"])){define('Adminer\DRIVER',"mssql");if(extension_loaded("sqlsrv")){class
Db{var$extension="sqlsrv",$_link,$_result,$server_info,$affected_rows,$errno,$error;function
_get_error(){$this->error="";foreach(sqlsrv_errors()as$m){$this->errno=$m["code"];$this->error.="$m[message]\n";}$this->error=rtrim($this->error);}function
connect($M,$V,$E){global$b;$Cb=array("UID"=>$V,"PWD"=>$E,"CharacterSet"=>"UTF-8");$Ih=$b->connectSsl();if(isset($Ih["Encrypt"]))$Cb["Encrypt"]=$Ih["Encrypt"];if(isset($Ih["TrustServerCertificate"]))$Cb["TrustServerCertificate"]=$Ih["TrustServerCertificate"];$j=$b->database();if($j!="")$Cb["Database"]=$j;$this->_link=@sqlsrv_connect(preg_replace('~:~',',',$M),$Cb);if($this->_link){$Wd=sqlsrv_server_info($this->_link);$this->server_info=$Wd['SQLServerVersion'];}else$this->_get_error();return(bool)$this->_link;}function
quote($P){$Ji=strlen($P)!=strlen(utf8_decode($P));return($Ji?"N":"")."'".str_replace("'","''",$P)."'";}function
select_db($Ub){return$this->query(use_sql($Ub));}function
query($G,$Ii=false){$H=sqlsrv_query($this->_link,$G);$this->error="";if(!$H){$this->_get_error();return
false;}return$this->store_result($H);}function
multi_query($G){$this->_result=sqlsrv_query($this->_link,$G);$this->error="";if(!$this->_result){$this->_get_error();return
false;}return
true;}function
store_result($H=null){if(!$H)$H=$this->_result;if(!$H)return
false;if(sqlsrv_field_metadata($H))return
new
Result($H);$this->affected_rows=sqlsrv_rows_affected($H);return
true;}function
next_result(){return$this->_result?sqlsrv_next_result($this->_result):null;}function
result($G,$n=0){$H=$this->query($G);if(!is_object($H))return
false;$J=$H->fetch_row();return$J[$n];}}class
Result{var$_result,$_offset=0,$_fields,$num_rows;function
__construct($H){$this->_result=$H;}function
_convert($J){foreach((array)$J
as$y=>$X){if(is_a($X,'DateTime'))$J[$y]=$X->format("Y-m-d H:i:s");}return$J;}function
fetch_assoc(){return$this->_convert(sqlsrv_fetch_array($this->_result,SQLSRV_FETCH_ASSOC));}function
fetch_row(){return$this->_convert(sqlsrv_fetch_array($this->_result,SQLSRV_FETCH_NUMERIC));}function
fetch_field(){if(!$this->_fields)$this->_fields=sqlsrv_field_metadata($this->_result);$n=$this->_fields[$this->_offset++];$I=new
\stdClass;$I->name=$n["Name"];$I->orgname=$n["Name"];$I->type=($n["Type"]==1?254:0);return$I;}function
seek($C){for($t=0;$t<$C;$t++)sqlsrv_fetch($this->_result);}function
__destruct(){sqlsrv_free_stmt($this->_result);}}}elseif(extension_loaded("pdo_sqlsrv")){class
Db
extends
PdoDb{var$extension="PDO_SQLSRV";function
connect($M,$V,$E){$this->dsn("sqlsrv:Server=".str_replace(":",",",$M),$V,$E);return
true;}function
select_db($Ub){return$this->query(use_sql($Ub));}}}elseif(extension_loaded("pdo_dblib")){class
Db
extends
PdoDb{var$extension="PDO_DBLIB";function
connect($M,$V,$E){$this->dsn("dblib:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\d)~',';port=\1',$M)),$V,$E);return
true;}function
select_db($Ub){return$this->query(use_sql($Ub));}}}class
Driver
extends
SqlDriver{static$mg=array("SQLSRV","PDO_SQLSRV","PDO_DBLIB");static$ke="mssql";var$editFunctions=array(array("date|time"=>"getdate",),array("int|decimal|real|float|money|datetime"=>"+/-","char|text"=>"+",));var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL");var$functions=array("len","lower","round","upper");var$grouping=array("avg","count","count distinct","max","min","sum");var$onActions="NO ACTION|CASCADE|SET NULL|SET DEFAULT";var$generated=array("PERSISTED","VIRTUAL");function
__construct($f){parent::__construct($f);$this->types=array('æ•¸å­—'=>array("tinyint"=>3,"smallint"=>5,"int"=>10,"bigint"=>20,"bit"=>1,"decimal"=>0,"real"=>12,"float"=>53,"smallmoney"=>10,"money"=>20),'æ—¥æœŸæ™‚é–“'=>array("date"=>10,"smalldatetime"=>19,"datetime"=>19,"datetime2"=>19,"time"=>8,"datetimeoffset"=>10),'å­—ä¸²'=>array("char"=>8000,"varchar"=>8000,"text"=>2147483647,"nchar"=>4000,"nvarchar"=>4000,"ntext"=>1073741823),'äºŒé€²ä½'=>array("binary"=>8000,"varbinary"=>8000,"image"=>2147483647),);}function
insertUpdate($Q,$K,$F){$o=fields($Q);$Qi=array();$Z=array();$N=reset($K);$e="c".implode(", c",range(1,count($N)));$Ya=0;$ae=array();foreach($N
as$y=>$X){$Ya++;$B=idf_unescape($y);if(!$o[$B]["auto_increment"])$ae[$y]="c$Ya";if(isset($F[$B]))$Z[]="$y = c$Ya";else$Qi[]="$y = c$Ya";}$bj=array();foreach($K
as$N)$bj[]="(".implode(", ",$N).")";if($Z){$Md=queries("SET IDENTITY_INSERT ".table($Q)." ON");$I=queries("MERGE ".table($Q)." USING (VALUES\n\t".implode(",\n\t",$bj)."\n) AS source ($e) ON ".implode(" AND ",$Z).($Qi?"\nWHEN MATCHED THEN UPDATE SET ".implode(", ",$Qi):"")."\nWHEN NOT MATCHED THEN INSERT (".implode(", ",array_keys($Md?$N:$ae)).") VALUES (".($Md?$e:implode(", ",$ae)).");");if($Md)queries("SET IDENTITY_INSERT ".table($Q)." OFF");}else$I=queries("INSERT INTO ".table($Q)." (".implode(", ",array_keys($N)).") VALUES\n".implode(",\n",$bj));return$I;}function
begin(){return
queries("BEGIN TRANSACTION");}function
tableHelp($B,$he=false){$Be=array("sys"=>"catalog-views/sys-","INFORMATION_SCHEMA"=>"information-schema-views/",);$_=$Be[get_schema()];if($_)return"relational-databases/system-$_".preg_replace('~_~','-',strtolower($B))."-transact-sql";}}function
idf_escape($v){return"[".str_replace("]","]]",$v)."]";}function
table($v){return($_GET["ns"]!=""?idf_escape($_GET["ns"]).".":"").idf_escape($v);}function
connect($Nb){$f=new
Db;if($Nb[0]=="")$Nb[0]="localhost:1433";if($f->connect($Nb[0],$Nb[1],$Nb[2]))return$f;return$f->error;}function
get_databases(){return
get_vals("SELECT name FROM sys.databases WHERE name NOT IN ('master', 'tempdb', 'model', 'msdb')");}function
limit($G,$Z,$z,$C=0,$lh=" "){return($z!==null?" TOP (".($z+$C).")":"")." $G$Z";}function
limit1($Q,$G,$Z,$lh="\n"){return
limit($G,$Z,1,0,$lh);}function
db_collation($j,$rb){global$f;return$f->result("SELECT collation_name FROM sys.databases WHERE name = ".q($j));}function
engines(){return
array();}function
logged_user(){global$f;return$f->result("SELECT SUSER_NAME()");}function
tables_list(){return
get_key_vals("SELECT name, type_desc FROM sys.all_objects WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ORDER BY name");}function
count_tables($i){global$f;$I=array();foreach($i
as$j){$f->select_db($j);$I[$j]=$f->result("SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES");}return$I;}function
table_status($B=""){$I=array();foreach(get_rows("SELECT ao.name AS Name, ao.type_desc AS Engine, (SELECT value FROM fn_listextendedproperty(default, 'SCHEMA', schema_name(schema_id), 'TABLE', ao.name, null, null)) AS Comment
FROM sys.all_objects AS ao
WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ".($B!=""?"AND name = ".q($B):"ORDER BY name"))as$J){if($B!="")return$J;$I[$J["Name"]]=$J;}return$I;}function
is_view($R){return$R["Engine"]=="VIEW";}function
fk_support($R){return
true;}function
fields($Q){global$f;$zb=get_key_vals("SELECT objname, cast(value as varchar(max)) FROM fn_listextendedproperty('MS_DESCRIPTION', 'schema', ".q(get_schema()).", 'table', ".q($Q).", 'column', NULL)");$I=array();$Uh=$f->result("SELECT object_id FROM sys.all_objects WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') AND name = ".q($Q));foreach(get_rows("SELECT c.max_length, c.precision, c.scale, c.name, c.is_nullable, c.is_identity, c.collation_name, t.name type, CAST(d.definition as text) [default], d.name default_constraint, i.is_primary_key
FROM sys.all_columns c
JOIN sys.types t ON c.user_type_id = t.user_type_id
LEFT JOIN sys.default_constraints d ON c.default_object_id = d.object_id
LEFT JOIN sys.index_columns ic ON c.object_id = ic.object_id AND c.column_id = ic.column_id
LEFT JOIN sys.indexes i ON ic.object_id = i.object_id AND ic.index_id = i.index_id
WHERE c.object_id = ".q($Uh))as$J){$U=$J["type"];$ze=(preg_match("~char|binary~",$U)?$J["max_length"]/($U[0]=='n'?2:1):($U=="decimal"?"$J[precision],$J[scale]":""));$I[$J["name"]]=array("field"=>$J["name"],"full_type"=>$U.($ze?"($ze)":""),"type"=>$U,"length"=>$ze,"default"=>(preg_match("~^\('(.*)'\)$~",$J["default"],$A)?str_replace("''","'",$A[1]):$J["default"]),"default_constraint"=>$J["default_constraint"],"null"=>$J["is_nullable"],"auto_increment"=>$J["is_identity"],"collation"=>$J["collation_name"],"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),"primary"=>$J["is_primary_key"],"comment"=>$zb[$J["name"]],);}foreach(get_rows("SELECT * FROM sys.computed_columns WHERE object_id = ".q($Uh))as$J){$I[$J["name"]]["generated"]=($J["is_persisted"]?"PERSISTED":"VIRTUAL");$I[$J["name"]]["default"]=$J["definition"];}return$I;}function
indexes($Q,$g=null){$I=array();foreach(get_rows("SELECT i.name, key_ordinal, is_unique, is_primary_key, c.name AS column_name, is_descending_key
FROM sys.indexes i
INNER JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
INNER JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
WHERE OBJECT_NAME(i.object_id) = ".q($Q),$g)as$J){$B=$J["name"];$I[$B]["type"]=($J["is_primary_key"]?"PRIMARY":($J["is_unique"]?"UNIQUE":"INDEX"));$I[$B]["lengths"]=array();$I[$B]["columns"][$J["key_ordinal"]]=$J["column_name"];$I[$B]["descs"][$J["key_ordinal"]]=($J["is_descending_key"]?'1':null);}return$I;}function
view($B){global$f;return
array("select"=>preg_replace('~^(?:[^[]|\[[^]]*])*\s+AS\s+~isU','',$f->result("SELECT VIEW_DEFINITION FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = SCHEMA_NAME() AND TABLE_NAME = ".q($B))));}function
collations(){$I=array();foreach(get_vals("SELECT name FROM fn_helpcollations()")as$qb)$I[preg_replace('~_.*~','',$qb)][]=$qb;return$I;}function
information_schema($j){return
get_schema()=="INFORMATION_SCHEMA";}function
error(){global$f;return
nl_br(h(preg_replace('~^(\[[^]]*])+~m','',$f->error)));}function
create_database($j,$qb){return
queries("CREATE DATABASE ".idf_escape($j).(preg_match('~^[a-z0-9_]+$~i',$qb)?" COLLATE $qb":""));}function
drop_databases($i){return
queries("DROP DATABASE ".implode(", ",array_map('Adminer\idf_escape',$i)));}function
rename_database($B,$qb){if(preg_match('~^[a-z0-9_]+$~i',$qb))queries("ALTER DATABASE ".idf_escape(DB)." COLLATE $qb");queries("ALTER DATABASE ".idf_escape(DB)." MODIFY NAME = ".idf_escape($B));return
true;}function
auto_increment(){return" IDENTITY".($_POST["Auto_increment"]!=""?"(".number($_POST["Auto_increment"]).",1)":"")." PRIMARY KEY";}function
alter_table($Q,$B,$o,$md,$xb,$Cc,$qb,$La,$ag){$c=array();$zb=array();$Kf=fields($Q);foreach($o
as$n){$d=idf_escape($n[0]);$X=$n[1];if(!$X)$c["DROP"][]=" COLUMN $d";else{$X[1]=preg_replace("~( COLLATE )'(\\w+)'~",'\1\2',$X[1]);$zb[$n[0]]=$X[5];unset($X[5]);if(preg_match('~ AS ~',$X[3]))unset($X[1],$X[2]);if($n[0]=="")$c["ADD"][]="\n  ".implode("",$X).($Q==""?substr($md[$X[0]],16+strlen($X[0])):"");else{$k=$X[3];unset($X[3]);unset($X[6]);if($d!=$X[0])queries("EXEC sp_rename ".q(table($Q).".$d").", ".q(idf_unescape($X[0])).", 'COLUMN'");$c["ALTER COLUMN ".implode("",$X)][]="";$Jf=$Kf[$n[0]];if(default_value($Jf)!=$k){if($Jf["default"]!==null)$c["DROP"][]=" ".idf_escape($Jf["default_constraint"]);if($k)$c["ADD"][]="\n $k FOR $d";}}}}if($Q=="")return
queries("CREATE TABLE ".table($B)." (".implode(",",(array)$c["ADD"])."\n)");if($Q!=$B)queries("EXEC sp_rename ".q(table($Q)).", ".q($B));if($md)$c[""]=$md;foreach($c
as$y=>$X){if(!queries("ALTER TABLE ".table($B)." $y".implode(",",$X)))return
false;}foreach($zb
as$y=>$X){$xb=substr($X,9);queries("EXEC sp_dropextendedproperty @name = N'MS_Description', @level0type = N'Schema', @level0name = ".q(get_schema()).", @level1type = N'Table', @level1name = ".q($B).", @level2type = N'Column', @level2name = ".q($y));queries("EXEC sp_addextendedproperty @name = N'MS_Description', @value = ".$xb.", @level0type = N'Schema', @level0name = ".q(get_schema()).", @level1type = N'Table', @level1name = ".q($B).", @level2type = N'Column', @level2name = ".q($y));}return
true;}function
alter_indexes($Q,$c){$w=array();$nc=array();foreach($c
as$X){if($X[2]=="DROP"){if($X[0]=="PRIMARY")$nc[]=idf_escape($X[1]);else$w[]=idf_escape($X[1])." ON ".table($Q);}elseif(!queries(($X[0]!="PRIMARY"?"CREATE $X[0] ".($X[0]!="INDEX"?"INDEX ":"").idf_escape($X[1]!=""?$X[1]:uniqid($Q."_"))." ON ".table($Q):"ALTER TABLE ".table($Q)." ADD PRIMARY KEY")." (".implode(", ",$X[2]).")"))return
false;}return(!$w||queries("DROP INDEX ".implode(", ",$w)))&&(!$nc||queries("ALTER TABLE ".table($Q)." DROP ".implode(", ",$nc)));}function
last_id(){global$f;return$f->result("SELECT SCOPE_IDENTITY()");}function
explain($f,$G){$f->query("SET SHOWPLAN_ALL ON");$I=$f->query($G);$f->query("SET SHOWPLAN_ALL OFF");return$I;}function
found_rows($R,$Z){}function
foreign_keys($Q){$I=array();$vf=array("CASCADE","NO ACTION","SET NULL","SET DEFAULT");foreach(get_rows("EXEC sp_fkeys @fktable_name = ".q($Q).", @fktable_owner = ".q(get_schema()))as$J){$q=&$I[$J["FK_NAME"]];$q["db"]=$J["PKTABLE_QUALIFIER"];$q["ns"]=$J["PKTABLE_OWNER"];$q["table"]=$J["PKTABLE_NAME"];$q["on_update"]=$vf[$J["UPDATE_RULE"]];$q["on_delete"]=$vf[$J["DELETE_RULE"]];$q["source"][]=$J["FKCOLUMN_NAME"];$q["target"][]=$J["PKCOLUMN_NAME"];}return$I;}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($gj){return
queries("DROP VIEW ".implode(", ",array_map('Adminer\table',$gj)));}function
drop_tables($S){return
queries("DROP TABLE ".implode(", ",array_map('Adminer\table',$S)));}function
move_tables($S,$gj,$di){return
apply_queries("ALTER SCHEMA ".idf_escape($di)." TRANSFER",array_merge($S,$gj));}function
trigger($B){if($B=="")return
array();$K=get_rows("SELECT s.name [Trigger],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(s.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(s.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing],
c.text
FROM sysobjects s
JOIN syscomments c ON s.id = c.id
WHERE s.xtype = 'TR' AND s.name = ".q($B));$I=reset($K);if($I)$I["Statement"]=preg_replace('~^.+\s+AS\s+~isU','',$I["text"]);return$I;}function
triggers($Q){$I=array();foreach(get_rows("SELECT sys1.name,
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing]
FROM sysobjects sys1
JOIN sysobjects sys2 ON sys1.parent_obj = sys2.id
WHERE sys1.xtype = 'TR' AND sys2.name = ".q($Q))as$J)$I[$J["name"]]=array($J["Timing"],$J["Event"]);return$I;}function
trigger_options(){return
array("Timing"=>array("AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("AS"),);}function
schemas(){return
get_vals("SELECT name FROM sys.schemas");}function
get_schema(){global$f;if($_GET["ns"]!="")return$_GET["ns"];return$f->result("SELECT SCHEMA_NAME()");}function
set_schema($ch){$_GET["ns"]=$ch;return
true;}function
create_sql($Q,$La,$Nh){global$l;if(is_view(table_status($Q))){$fj=view($Q);return"CREATE VIEW ".table($Q)." AS $fj[select]";}$o=array();$F=false;foreach(fields($Q)as$B=>$n){$X=process_field($n,$n);if($X[6])$F=true;$o[]=implode("",$X);}foreach(indexes($Q)as$B=>$w){if(!$F||$w["type"]!="PRIMARY"){$e=array();foreach($w["columns"]as$y=>$X)$e[]=idf_escape($X).($w["descs"][$y]?" DESC":"");$B=idf_escape($B);$o[]=($w["type"]=="INDEX"?"INDEX $B":"CONSTRAINT $B ".($w["type"]=="UNIQUE"?"UNIQUE":"PRIMARY KEY"))." (".implode(", ",$e).")";}}foreach($l->checkConstraints($Q)as$B=>$eb)$o[]="CONSTRAINT ".idf_escape($B)." CHECK ($eb)";return"CREATE TABLE ".table($Q)." (\n\t".implode(",\n\t",$o)."\n)";}function
foreign_keys_sql($Q){$o=array();foreach(foreign_keys($Q)as$md)$o[]=ltrim(format_foreign_key($md));return($o?"ALTER TABLE ".table($Q)." ADD\n\t".implode(",\n\t",$o).";\n\n":"");}function
truncate_sql($Q){return"TRUNCATE TABLE ".table($Q);}function
use_sql($Ub){return"USE ".idf_escape($Ub);}function
trigger_sql($Q){$I="";foreach(triggers($Q)as$B=>$Bi)$I.=create_trigger(" ON ".table($Q),trigger($B)).";";return$I;}function
convert_field($n){}function
unconvert_field($n,$I){return$I;}function
support($ad){return
preg_match('~^(check|comment|columns|database|drop_col|dump|indexes|descidx|scheme|sql|table|trigger|view|view_trigger)$~',$ad);}}$mc["mongo"]="MongoDB (alpha)";if(isset($_GET["mongo"])){define('Adminer\DRIVER',"mongo");if(class_exists('MongoDB\Driver\Manager')){class
Db{var$extension="MongoDB",$server_info=MONGODB_VERSION,$affected_rows,$error,$last_id;var$_link;var$_db,$_db_name;function
connect($Ri,$Cf){$this->_link=new
\MongoDB\Driver\Manager($Ri,$Cf);$this->executeCommand($Cf["db"],array('ping'=>1));}function
executeCommand($j,$vb){try{return$this->_link->executeCommand($j,new
\MongoDB\Driver\Command($vb));}catch(Exception$uc){$this->error=$uc->getMessage();return
array();}}function
executeBulkWrite($cf,$Xa,$Kb){try{$Rg=$this->_link->executeBulkWrite($cf,$Xa);$this->affected_rows=$Rg->$Kb();return
true;}catch(Exception$uc){$this->error=$uc->getMessage();return
false;}}function
query($G){return
false;}function
select_db($Ub){$this->_db_name=$Ub;return
true;}function
quote($P){return$P;}}class
Result{var$num_rows,$_rows=array(),$_offset=0,$_charset=array();function
__construct($H){foreach($H
as$ie){$J=array();foreach($ie
as$y=>$X){if(is_a($X,'MongoDB\BSON\Binary'))$this->_charset[$y]=63;$J[$y]=(is_a($X,'MongoDB\BSON\ObjectID')?'MongoDB\BSON\ObjectID("'."$X\")":(is_a($X,'MongoDB\BSON\UTCDatetime')?$X->toDateTime()->format('Y-m-d H:i:s'):(is_a($X,'MongoDB\BSON\Binary')?$X->getData():(is_a($X,'MongoDB\BSON\Regex')?"$X":(is_object($X)||is_array($X)?json_encode($X,256):$X)))));}$this->_rows[]=$J;foreach($J
as$y=>$X){if(!isset($this->_rows[0][$y]))$this->_rows[0][$y]=null;}}$this->num_rows=count($this->_rows);}function
fetch_assoc(){$J=current($this->_rows);if(!$J)return$J;$I=array();foreach($this->_rows[0]as$y=>$X)$I[$y]=$J[$y];next($this->_rows);return$I;}function
fetch_row(){$I=$this->fetch_assoc();if(!$I)return$I;return
array_values($I);}function
fetch_field(){$ne=array_keys($this->_rows[0]);$B=$ne[$this->_offset++];return(object)array('name'=>$B,'charsetnr'=>$this->_charset[$B],);}}function
get_databases($kd){global$f;$I=array();foreach($f->executeCommand($f->_db_name,array('listDatabases'=>1))as$Yb){foreach($Yb->databases
as$j)$I[]=$j->name;}return$I;}function
count_tables($i){$I=array();return$I;}function
tables_list(){global$f;$sb=array();foreach($f->executeCommand($f->_db_name,array('listCollections'=>1))as$H)$sb[$H->name]='table';return$sb;}function
drop_databases($i){return
false;}function
indexes($Q,$g=null){global$f;$I=array();foreach($f->executeCommand($f->_db_name,array('listIndexes'=>$Q))as$w){$fc=array();$e=array();foreach(get_object_vars($w->key)as$d=>$U){$fc[]=($U==-1?'1':null);$e[]=$d;}$I[$w->name]=array("type"=>($w->name=="_id_"?"PRIMARY":(isset($w->unique)?"UNIQUE":"INDEX")),"columns"=>$e,"lengths"=>array(),"descs"=>$fc,);}return$I;}function
fields($Q){global$l;$o=fields_from_edit();if(!$o){$H=$l->select($Q,array("*"),null,null,array(),10);if($H){while($J=$H->fetch_assoc()){foreach($J
as$y=>$X){$J[$y]=null;$o[$y]=array("field"=>$y,"type"=>"string","null"=>($y!=$l->primary),"auto_increment"=>($y==$l->primary),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1,),);}}}}return$o;}function
found_rows($R,$Z){global$f;$Z=where_to_query($Z);$ti=$f->executeCommand($f->_db_name,array('count'=>$R['Name'],'query'=>$Z))->toArray();return$ti[0]->n;}function
sql_query_where_parser($_g){$_g=preg_replace('~^\s*WHERE\s*~',"",$_g);while($_g[0]=="(")$_g=preg_replace('~^\((.*)\)$~',"$1",$_g);$qj=explode(' AND ',$_g);$rj=explode(') OR (',$_g);$Z=array();foreach($qj
as$oj)$Z[]=trim($oj);if(count($rj)==1)$rj=array();elseif(count($rj)>1)$Z=array();return
where_to_query($Z,$rj);}function
where_to_query($mj=array(),$nj=array()){global$b;$Sb=array();foreach(array('and'=>$mj,'or'=>$nj)as$U=>$Z){if(is_array($Z)){foreach($Z
as$Sc){list($ob,$yf,$X)=explode(" ",$Sc,3);if($ob=="_id"&&preg_match('~^(MongoDB\\\\BSON\\\\ObjectID)\("(.+)"\)$~',$X,$A)){list(,$lb,$X)=$A;$X=new$lb($X);}if(!in_array($yf,$b->operators))continue;if(preg_match('~^\(f\)(.+)~',$yf,$A)){$X=(float)$X;$yf=$A[1];}elseif(preg_match('~^\(date\)(.+)~',$yf,$A)){$Vb=new
\DateTime($X);$X=new
\MongoDB\BSON\UTCDatetime($Vb->getTimestamp()*1000);$yf=$A[1];}switch($yf){case'=':$yf='$eq';break;case'!=':$yf='$ne';break;case'>':$yf='$gt';break;case'<':$yf='$lt';break;case'>=':$yf='$gte';break;case'<=':$yf='$lte';break;case'regex':$yf='$regex';break;default:continue
2;}if($U=='and')$Sb['$and'][]=array($ob=>array($yf=>$X));elseif($U=='or')$Sb['$or'][]=array($ob=>array($yf=>$X));}}}return$Sb;}}class
Driver
extends
SqlDriver{static$mg=array("mongodb");static$ke="mongo";var$editFunctions=array(array("json"));var$operators=array("=","!=",">","<",">=","<=","regex","(f)=","(f)!=","(f)>","(f)<","(f)>=","(f)<=","(date)=","(date)!=","(date)>","(date)<","(date)>=","(date)<=",);public$F="_id";function
select($Q,$L,$Z,$xd,$Ef=array(),$z=1,$D=0,$rg=false){$L=($L==array("*")?array():array_fill_keys($L,1));if(count($L)&&!isset($L['_id']))$L['_id']=0;$Z=where_to_query($Z);$_h=array();foreach($Ef
as$X){$X=preg_replace('~ DESC$~','',$X,1,$Jb);$_h[$X]=($Jb?-1:1);}if(isset($_GET['limit'])&&is_numeric($_GET['limit'])&&$_GET['limit']>0)$z=$_GET['limit'];$z=min(200,max(1,(int)$z));$xh=$D*$z;try{return
new
Result($this->_conn->_link->executeQuery("$f->_db_name.$Q",new
\MongoDB\Driver\Query($Z,array('projection'=>$L,'limit'=>$z,'skip'=>$xh,'sort'=>$_h))));}catch(Exception$uc){$f->error=$uc->getMessage();return
false;}}function
update($Q,$N,$_g,$z=0,$lh="\n"){$j=$this->_conn->_db_name;$Z=sql_query_where_parser($_g);$Xa=new
\MongoDB\Driver\BulkWrite(array());if(isset($N['_id']))unset($N['_id']);$Lg=array();foreach($N
as$y=>$Y){if($Y=='NULL'){$Lg[$y]=1;unset($N[$y]);}}$Qi=array('$set'=>$N);if(count($Lg))$Qi['$unset']=$Lg;$Xa->update($Z,$Qi,array('upsert'=>false));return$this->_conn->executeBulkWrite("$j.$Q",$Xa,'getModifiedCount');}function
delete($Q,$_g,$z=0){$j=$this->_conn->_db_name;$Z=sql_query_where_parser($_g);$Xa=new
\MongoDB\Driver\BulkWrite(array());$Xa->delete($Z,array('limit'=>$z));return$this->_conn->executeBulkWrite("$j.$Q",$Xa,'getDeletedCount');}function
insert($Q,$N){$j=$this->_conn->_db_name;$Xa=new
\MongoDB\Driver\BulkWrite(array());if($N['_id']=='')unset($N['_id']);$Xa->insert($N);return$this->_conn->executeBulkWrite("$j.$Q",$Xa,'getInsertedCount');}}function
table($v){return$v;}function
idf_escape($v){return$v;}function
table_status($B="",$Zc=false){$I=array();foreach(tables_list()as$Q=>$U){$I[$Q]=array("Name"=>$Q);if($B==$Q)return$I[$Q];}return$I;}function
create_database($j,$qb){return
true;}function
last_id(){global$f;return$f->last_id;}function
error(){global$f;return
h($f->error);}function
collations(){return
array();}function
logged_user(){global$b;$Nb=$b->credentials();return$Nb[1];}function
connect($Nb){global$b;$f=new
Db;list($M,$V,$E)=$Nb;if($M=="")$M="localhost:27017";$Cf=array();if($V.$E!=""){$Cf["username"]=$V;$Cf["password"]=$E;}$j=$b->database();if($j!="")$Cf["db"]=$j;if(($Ka=getenv("MONGO_AUTH_SOURCE")))$Cf["authSource"]=$Ka;$f->connect("mongodb://$M",$Cf);if($f->error)return$f->error;return$f;}function
alter_indexes($Q,$c){global$f;foreach($c
as$X){list($U,$B,$N)=$X;if($N=="DROP")$I=$f->_db->command(array("deleteIndexes"=>$Q,"index"=>$B));else{$e=array();foreach($N
as$d){$d=preg_replace('~ DESC$~','',$d,1,$Jb);$e[$d]=($Jb?-1:1);}$I=$f->_db->selectCollection($Q)->ensureIndex($e,array("unique"=>($U=="UNIQUE"),"name"=>$B,));}if($I['errmsg']){$f->error=$I['errmsg'];return
false;}}return
true;}function
support($ad){return
preg_match("~database|indexes|descidx~",$ad);}function
db_collation($j,$rb){}function
information_schema(){}function
is_view($R){}function
convert_field($n){}function
unconvert_field($n,$I){return$I;}function
foreign_keys($Q){return
array();}function
fk_support($R){}function
engines(){return
array();}function
alter_table($Q,$B,$o,$md,$xb,$Cc,$qb,$La,$ag){global$f;if($Q==""){$f->_db->createCollection($B);return
true;}}function
drop_tables($S){global$f;foreach($S
as$Q){$Og=$f->_db->selectCollection($Q)->drop();if(!$Og['ok'])return
false;}return
true;}function
truncate_tables($S){global$f;foreach($S
as$Q){$Og=$f->_db->selectCollection($Q)->remove();if(!$Og['ok'])return
false;}return
true;}}class
Adminer{var$operators;function
name(){return"<a href='https://www.adminer.org/'".target_blank()." id='h1'>Adminer</a>";}function
credentials(){return
array(SERVER,$_GET["username"],get_password());}function
connectSsl(){}function
permanentLogin($h=false){return
password_file($h);}function
bruteForceKey(){return$_SERVER["REMOTE_ADDR"];}function
serverName($M){return
h($M);}function
database(){return
DB;}function
databases($kd=true){return
get_databases($kd);}function
schemas(){return
schemas();}function
queryTimeout(){return
2;}function
headers(){}function
csp(){return
csp();}function
head(){return
true;}function
css(){$I=array();$p="adminer.css";if(file_exists($p))$I[]="$p?v=".crc32(file_get_contents($p));return$I;}function
loginForm(){global$mc;echo"<table class='layout'>\n",$this->loginFormField('driver','<tr><th>'.'è³‡æ–™åº«ç³»çµ±'.'<td>',html_select("auth[driver]",$mc,DRIVER,"loginDriver(this);")),$this->loginFormField('server','<tr><th>'.'ä¼ºæœå™¨'.'<td>','<input name="auth[server]" value="'.h(SERVER).'" title="hostname[:port]" placeholder="localhost" autocapitalize="off">'),$this->loginFormField('username','<tr><th>'.'å¸³è™Ÿ'.'<td>','<input name="auth[username]" id="username" autofocus value="'.h($_GET["username"]).'" autocomplete="username" autocapitalize="off">'.script("qs('#username').form['auth[driver]'].onchange();")),$this->loginFormField('password','<tr><th>'.'å¯†ç¢¼'.'<td>','<input type="password" name="auth[password]" autocomplete="current-password">'),$this->loginFormField('db','<tr><th>'.'è³‡æ–™åº«'.'<td>','<input name="auth[db]" value="'.h($_GET["db"]).'" autocapitalize="off">'),"</table>\n","<p><input type='submit' value='".'ç™»å…¥'."'>\n",checkbox("auth[permanent]",1,$_COOKIE["adminer_permanent"],'æ°¸ä¹…ç™»å…¥')."\n";}function
loginFormField($B,$Gd,$Y){return$Gd.$Y."\n";}function
login($De,$E){if($E=="")return
sprintf('Admineré è¨­ä¸æ”¯æ´è¨ªå•æ²’æœ‰å¯†ç¢¼çš„è³‡æ–™åº«ï¼Œ<a href="https://www.adminer.org/en/password/"%s>è©³æƒ…è¦‹é€™è£¡</a>.',target_blank());return
true;}function
tableName($Th){return
h($Th["Name"]);}function
fieldName($n,$Ef=0){return'<span title="'.h($n["full_type"]).'">'.h($n["field"]).'</span>';}function
selectLinks($Th,$N=""){global$l;echo'<p class="links">';$Be=array("select"=>'é¸æ“‡è³‡æ–™');if(support("table")||support("indexes"))$Be["table"]='é¡¯ç¤ºçµæ§‹';$he=false;if(support("table")){$he=is_view($Th);if($he)$Be["view"]='ä¿®æ”¹æª¢è¦–è¡¨';else$Be["create"]='ä¿®æ”¹è³‡æ–™è¡¨';}if($N!==null)$Be["edit"]='æ–°å¢é …ç›®';$B=$Th["Name"];foreach($Be
as$y=>$X)echo" <a href='".h(ME)."$y=".urlencode($B).($y=="edit"?$N:"")."'".bold(isset($_GET[$y])).">$X</a>";echo
doc_link(array(JUSH=>$l->tableHelp($B,$he)),"?"),"\n";}function
foreignKeys($Q){return
foreign_keys($Q);}function
backwardKeys($Q,$Sh){return
array();}function
backwardKeysPrint($Oa,$J){}function
selectQuery($G,$Jh,$Yc=false){global$l;$I="</p>\n";if(!$Yc&&($jj=$l->warnings())){$u="warnings";$I=", <a href='#$u'>".'è­¦å‘Š'."</a>".script("qsl('a').onclick = partial(toggle, '$u');","")."$I<div id='$u' class='hidden'>\n$jj</div>\n";}return"<p><code class='jush-".JUSH."'>".h(str_replace("\n"," ",$G))."</code> <span class='time'>(".format_time($Jh).")</span>".(support("sql")?" <a href='".h(ME)."sql=".urlencode($G)."'>".'ç·¨è¼¯'."</a>":"").$I;}function
sqlCommandQuery($G){return
shorten_utf8(trim($G),1000);}function
rowDescription($Q){return"";}function
rowDescriptions($K,$nd){return$K;}function
selectLink($X,$n){}function
selectVal($X,$_,$n,$Nf){$I=($X===null?"<i>NULL</i>":(preg_match("~char|binary|boolean~",$n["type"])&&!preg_match("~var~",$n["type"])?"<code>$X</code>":$X));if(preg_match('~blob|bytea|raw|file~',$n["type"])&&!is_utf8($X))$I="<i>".sprintf('%d byte(s)',strlen($Nf))."</i>";if(preg_match('~json~',$n["type"]))$I="<code class='jush-js'>$I</code>";return($_?"<a href='".h($_)."'".(is_url($_)?target_blank():"").">$I</a>":$I);}function
editVal($X,$n){return$X;}function
tableStructurePrint($o){global$l;echo"<div class='scrollable'>\n","<table class='nowrap odds'>\n","<thead><tr><th>".'æ¬„ä½'."<td>".'é¡å‹'.(support("comment")?"<td>".'è¨»è§£':"")."</thead>\n";$Mh=$l->structuredTypes();foreach($o
as$n){echo"<tr><th>".h($n["field"]);$U=h($n["full_type"]);echo"<td><span title='".h($n["collation"])."'>".(in_array($U,(array)$Mh['ä½¿ç”¨è€…é¡å‹'])?"<a href='".h(ME.'type='.urlencode($U))."'>$U</a>":$U)."</span>",($n["null"]?" <i>NULL</i>":""),($n["auto_increment"]?" <i>".'è‡ªå‹•éå¢'."</i>":"");$k=h($n["default"]);echo(isset($n["default"])?" <span title='".'é è¨­å€¼'."'>[<b>".($n["generated"]?"<code class='jush-".JUSH."'>$k</code>":$k)."</b>]</span>":""),(support("comment")?"<td>".h($n["comment"]):""),"\n";}echo"</table>\n","</div>\n";}function
tableIndexesPrint($x){echo"<table>\n";foreach($x
as$B=>$w){ksort($w["columns"]);$rg=array();foreach($w["columns"]as$y=>$X)$rg[]="<i>".h($X)."</i>".($w["lengths"][$y]?"(".$w["lengths"][$y].")":"").($w["descs"][$y]?" DESC":"");echo"<tr title='".h($B)."'><th>$w[type]<td>".implode(", ",$rg)."\n";}echo"</table>\n";}function
selectColumnsPrint($L,$e){global$l;print_fieldset("select",'é¸æ“‡',$L);$t=0;$L[""]=array();foreach($L
as$y=>$X){$X=$_GET["columns"][$y];$d=select_input(" name='columns[$t][col]'",$e,$X["col"],($y!==""?"selectFieldChange":"selectAddRow"));echo"<div>".($l->functions||$l->grouping?"<select name='columns[$t][fun]'>".optionlist(array(-1=>"")+array_filter(array('å‡½å¼'=>$l->functions,'é›†åˆ'=>$l->grouping)),$X["fun"])."</select>".on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'",1).script("qsl('select').onchange = function () { helpClose();".($y!==""?"":" qsl('select, input', this.parentNode).onchange();")." };","")."($d)":$d)."</div>\n";$t++;}echo"</div></fieldset>\n";}function
selectSearchPrint($Z,$e,$x){print_fieldset("search",'æœå°‹',$Z);foreach($x
as$t=>$w){if($w["type"]=="FULLTEXT"){echo"<div>(<i>".implode("</i>, <i>",array_map('Adminer\h',$w["columns"]))."</i>) AGAINST"," <input type='search' name='fulltext[$t]' value='".h($_GET["fulltext"][$t])."'>",script("qsl('input').oninput = selectFieldChange;",""),checkbox("boolean[$t]",1,isset($_GET["boolean"][$t]),"BOOL"),"</div>\n";}}$cb="this.parentNode.firstChild.onchange();";foreach(array_merge((array)$_GET["where"],array(array()))as$t=>$X){if(!$X||("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators))){echo"<div>".select_input(" name='where[$t][col]'",$e,$X["col"],($X?"selectFieldChange":"selectAddRow"),"(".'ä»»æ„ä½ç½®'.")"),html_select("where[$t][op]",$this->operators,$X["op"],$cb),"<input type='search' name='where[$t][val]' value='".h($X["val"])."'>",script("mixin(qsl('input'), {oninput: function () { $cb }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});",""),"</div>\n";}}echo"</div></fieldset>\n";}function
selectOrderPrint($Ef,$e,$x){print_fieldset("sort",'æ’åº',$Ef);$t=0;foreach((array)$_GET["order"]as$y=>$X){if($X!=""){echo"<div>".select_input(" name='order[$t]'",$e,$X,"selectFieldChange"),checkbox("desc[$t]",1,isset($_GET["desc"][$y]),'é™å†ª (éæ¸›)')."</div>\n";$t++;}}echo"<div>".select_input(" name='order[$t]'",$e,"","selectAddRow"),checkbox("desc[$t]",1,false,'é™å†ª (éæ¸›)')."</div>\n","</div></fieldset>\n";}function
selectLimitPrint($z){echo"<fieldset><legend>".'é™å®š'."</legend><div>";echo"<input type='number' name='limit' class='size' value='".h($z)."'>",script("qsl('input').oninput = selectFieldChange;",""),"</div></fieldset>\n";}function
selectLengthPrint($ji){if($ji!==null){echo"<fieldset><legend>".'Text é•·åº¦'."</legend><div>","<input type='number' name='text_length' class='size' value='".h($ji)."'>","</div></fieldset>\n";}}function
selectActionPrint($x){echo"<fieldset><legend>".'å‹•ä½œ'."</legend><div>","<input type='submit' value='".'é¸æ“‡'."'>"," <span id='noindex' title='".'å…¨è³‡æ–™è¡¨æƒæ'."'></span>","<script".nonce().">\n","var indexColumns = ";$e=array();foreach($x
as$w){$Rb=reset($w["columns"]);if($w["type"]!="FULLTEXT"&&$Rb)$e[$Rb]=1;}$e[""]=1;foreach($e
as$y=>$X)json_row($y);echo";\n","selectFieldChange.call(qs('#form')['select']);\n","</script>\n","</div></fieldset>\n";}function
selectCommandPrint(){return!information_schema(DB);}function
selectImportPrint(){return!information_schema(DB);}function
selectEmailPrint($_c,$e){}function
selectColumnsProcess($e,$x){global$l;$L=array();$xd=array();foreach((array)$_GET["columns"]as$y=>$X){if($X["fun"]=="count"||($X["col"]!=""&&(!$X["fun"]||in_array($X["fun"],$l->functions)||in_array($X["fun"],$l->grouping)))){$L[$y]=apply_sql_function($X["fun"],($X["col"]!=""?idf_escape($X["col"]):"*"));if(!in_array($X["fun"],$l->grouping))$xd[]=$L[$y];}}return
array($L,$xd);}function
selectSearchProcess($o,$x){global$f,$l;$I=array();foreach($x
as$t=>$w){if($w["type"]=="FULLTEXT"&&$_GET["fulltext"][$t]!="")$I[]="MATCH (".implode(", ",array_map('Adminer\idf_escape',$w["columns"])).") AGAINST (".q($_GET["fulltext"][$t]).(isset($_GET["boolean"][$t])?" IN BOOLEAN MODE":"").")";}foreach((array)$_GET["where"]as$y=>$X){if("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators)){$og="";$_b=" $X[op]";if(preg_match('~IN$~',$X["op"])){$Qd=process_length($X["val"]);$_b.=" ".($Qd!=""?$Qd:"(NULL)");}elseif($X["op"]=="SQL")$_b=" $X[val]";elseif($X["op"]=="LIKE %%")$_b=" LIKE ".$this->processInput($o[$X["col"]],"%$X[val]%");elseif($X["op"]=="ILIKE %%")$_b=" ILIKE ".$this->processInput($o[$X["col"]],"%$X[val]%");elseif($X["op"]=="FIND_IN_SET"){$og="$X[op](".q($X["val"]).", ";$_b=")";}elseif(!preg_match('~NULL$~',$X["op"]))$_b.=" ".$this->processInput($o[$X["col"]],$X["val"]);if($X["col"]!="")$I[]=$og.$l->convertSearch(idf_escape($X["col"]),$X,$o[$X["col"]]).$_b;else{$tb=array();foreach($o
as$B=>$n){if((preg_match('~^[-\d.'.(preg_match('~IN$~',$X["op"])?',':'').']+$~',$X["val"])||!preg_match('~'.number_type().'|bit~',$n["type"]))&&(!preg_match("~[\x80-\xFF]~",$X["val"])||preg_match('~char|text|enum|set~',$n["type"]))&&(!preg_match('~date|timestamp~',$n["type"])||preg_match('~^\d+-\d+-\d+~',$X["val"])))$tb[]=$og.$l->convertSearch(idf_escape($B),$X,$n).$_b;}$I[]=($tb?"(".implode(" OR ",$tb).")":"1 = 0");}}}return$I;}function
selectOrderProcess($o,$x){$I=array();foreach((array)$_GET["order"]as$y=>$X){if($X!="")$I[]=(preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~',$X)?$X:idf_escape($X)).(isset($_GET["desc"][$y])?" DESC":"");}return$I;}function
selectLimitProcess(){return(isset($_GET["limit"])?$_GET["limit"]:"50");}function
selectLengthProcess(){return(isset($_GET["text_length"])?$_GET["text_length"]:"100");}function
selectEmailProcess($Z,$nd){return
false;}function
selectQueryBuild($L,$Z,$xd,$Ef,$z,$D){return"";}function
messageQuery($G,$ki,$Yc=false){global$l;restart_session();$Hd=&get_session("queries");if(!$Hd[$_GET["db"]])$Hd[$_GET["db"]]=array();if(strlen($G)>1e6)$G=preg_replace('~[\x80-\xFF]+$~','',substr($G,0,1e6))."\nâ€¦";$Hd[$_GET["db"]][]=array($G,time(),$ki);$Fh="sql-".count($Hd[$_GET["db"]]);$I="<a href='#$Fh' class='toggle'>".'SQL å‘½ä»¤'."</a>\n";if(!$Yc&&($jj=$l->warnings())){$u="warnings-".count($Hd[$_GET["db"]]);$I="<a href='#$u' class='toggle'>".'è­¦å‘Š'."</a>, $I<div id='$u' class='hidden'>\n$jj</div>\n";}return" <span class='time'>".@date("H:i:s")."</span>"." $I<div id='$Fh' class='hidden'><pre><code class='jush-".JUSH."'>".shorten_utf8($G,1000)."</code></pre>".($ki?" <span class='time'>($ki)</span>":'').(support("sql")?'<p><a href="'.h(str_replace("db=".urlencode(DB),"db=".urlencode($_GET["db"]),ME).'sql=&history='.(count($Hd[$_GET["db"]])-1)).'">'.'ç·¨è¼¯'.'</a>':'').'</div>';}function
editRowPrint($Q,$o,$J,$Qi){}function
editFunctions($n){global$l;$I=($n["null"]?"NULL/":"");$Qi=isset($_GET["select"])||where($_GET);foreach($l->editFunctions
as$y=>$td){if(!$y||(!isset($_GET["call"])&&$Qi)){foreach($td
as$eg=>$X){if(!$eg||preg_match("~$eg~",$n["type"]))$I.="/$X";}}if($y&&!preg_match('~set|blob|bytea|raw|file|bool~',$n["type"]))$I.="/SQL";}if($n["auto_increment"]&&!$Qi)$I='è‡ªå‹•éå¢';return
explode("/",$I);}function
editInput($Q,$n,$Ia,$Y){if($n["type"]=="enum")return(isset($_GET["select"])?"<label><input type='radio'$Ia value='-1' checked><i>".'åŸå§‹'."</i></label> ":"").($n["null"]?"<label><input type='radio'$Ia value=''".($Y!==null||isset($_GET["select"])?"":" checked")."><i>NULL</i></label> ":"").enum_input("radio",$Ia,$n,$Y,$Y===0?0:null);return"";}function
editHint($Q,$n,$Y){return"";}function
processInput($n,$Y,$s=""){if($s=="SQL")return$Y;$B=$n["field"];$I=q($Y);if(preg_match('~^(now|getdate|uuid)$~',$s))$I="$s()";elseif(preg_match('~^current_(date|timestamp)$~',$s))$I=$s;elseif(preg_match('~^([+-]|\|\|)$~',$s))$I=idf_escape($B)." $s $I";elseif(preg_match('~^[+-] interval$~',$s))$I=idf_escape($B)." $s ".(preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i",$Y)?$Y:$I);elseif(preg_match('~^(addtime|subtime|concat)$~',$s))$I="$s(".idf_escape($B).", $I)";elseif(preg_match('~^(md5|sha1|password|encrypt)$~',$s))$I="$s($I)";return
unconvert_field($n,$I);}function
dumpOutput(){$I=array('text'=>'æ‰“é–‹','file'=>'å„²å­˜');if(function_exists('gzencode'))$I['gz']='gzip';return$I;}function
dumpFormat(){return(support("dump")?array('sql'=>'SQL'):array())+array('csv'=>'CSV,','csv;'=>'CSV;','tsv'=>'TSV');}function
dumpDatabase($j){}function
dumpTable($Q,$Nh,$he=0){if($_POST["format"]!="sql"){echo"\xef\xbb\xbf";if($Nh)dump_csv(array_keys(fields($Q)));}else{if($he==2){$o=array();foreach(fields($Q)as$B=>$n)$o[]=idf_escape($B)." $n[full_type]";$h="CREATE TABLE ".table($Q)." (".implode(", ",$o).")";}else$h=create_sql($Q,$_POST["auto_increment"],$Nh);set_utf8mb4($h);if($Nh&&$h){if($Nh=="DROP+CREATE"||$he==1)echo"DROP ".($he==2?"VIEW":"TABLE")." IF EXISTS ".table($Q).";\n";if($he==1)$h=remove_definer($h);echo"$h;\n\n";}}}function
dumpData($Q,$Nh,$G){global$f;if($Nh){$Ke=(JUSH=="sqlite"?0:1048576);$o=array();$Nd=false;if($_POST["format"]=="sql"){if($Nh=="TRUNCATE+INSERT")echo
truncate_sql($Q).";\n";$o=fields($Q);if(JUSH=="mssql"){foreach($o
as$n){if($n["auto_increment"]){echo"SET IDENTITY_INSERT ".table($Q)." ON;\n";$Nd=true;break;}}}}$H=$f->query($G,1);if($H){$ae="";$Wa="";$ne=array();$ud=array();$Ph="";$bd=($Q!=''?'fetch_assoc':'fetch_row');while($J=$H->$bd()){if(!$ne){$bj=array();foreach($J
as$X){$n=$H->fetch_field();if($o[$n->name]['generated']){$ud[$n->name]=true;continue;}$ne[]=$n->name;$y=idf_escape($n->name);$bj[]="$y = VALUES($y)";}$Ph=($Nh=="INSERT+UPDATE"?"\nON DUPLICATE KEY UPDATE ".implode(", ",$bj):"").";\n";}if($_POST["format"]!="sql"){if($Nh=="table"){dump_csv($ne);$Nh="INSERT";}dump_csv($J);}else{if(!$ae)$ae="INSERT INTO ".table($Q)." (".implode(", ",array_map('Adminer\idf_escape',$ne)).") VALUES";foreach($J
as$y=>$X){if($ud[$y]){unset($J[$y]);continue;}$n=$o[$y];$J[$y]=($X!==null?unconvert_field($n,preg_match(number_type(),$n["type"])&&!preg_match('~\[~',$n["full_type"])&&is_numeric($X)?$X:q(($X===false?0:$X))):"NULL");}$ah=($Ke?"\n":" ")."(".implode(",\t",$J).")";if(!$Wa)$Wa=$ae.$ah;elseif(strlen($Wa)+4+strlen($ah)+strlen($Ph)<$Ke)$Wa.=",$ah";else{echo$Wa.$Ph;$Wa=$ae.$ah;}}}if($Wa)echo$Wa.$Ph;}elseif($_POST["format"]=="sql")echo"-- ".str_replace("\n"," ",$f->error)."\n";if($Nd)echo"SET IDENTITY_INSERT ".table($Q)." OFF;\n";}}function
dumpFilename($Ld){return
friendly_url($Ld!=""?$Ld:(SERVER!=""?SERVER:"localhost"));}function
dumpHeaders($Ld,$Ye=false){$Qf=$_POST["output"];$Tc=(preg_match('~sql~',$_POST["format"])?"sql":($Ye?"tar":"csv"));header("Content-Type: ".($Qf=="gz"?"application/x-gzip":($Tc=="tar"?"application/x-tar":($Tc=="sql"||$Qf!="file"?"text/plain":"text/csv")."; charset=utf-8")));if($Qf=="gz")ob_start('ob_gzencode',1e6);return$Tc;}function
importServerPath(){return"adminer.sql";}function
homepage(){echo'<p class="links">'.($_GET["ns"]==""&&support("database")?'<a href="'.h(ME).'database=">'.'ä¿®æ”¹è³‡æ–™åº«'."</a>\n":""),(support("scheme")?"<a href='".h(ME)."scheme='>".($_GET["ns"]!=""?'ä¿®æ”¹è³‡æ–™è¡¨çµæ§‹':'å»ºç«‹è³‡æ–™è¡¨çµæ§‹')."</a>\n":""),($_GET["ns"]!==""?'<a href="'.h(ME).'schema=">'.'è³‡æ–™åº«çµæ§‹'."</a>\n":""),(support("privileges")?"<a href='".h(ME)."privileges='>".'æ¬Šé™'."</a>\n":"");return
true;}function
navigation($Xe){global$ia,$mc,$f;echo'<h1>
',$this->name(),'<span class="version">
',$ia,' <a href="https://www.adminer.org/#download"',target_blank(),' id="version">',(version_compare($ia,$_COOKIE["adminer_version"])<0?h($_COOKIE["adminer_version"]):""),'</a>
</span>
</h1>
';if($Xe=="auth"){$Qf="";foreach((array)$_SESSION["pwds"]as$dj=>$qh){foreach($qh
as$M=>$Yi){foreach($Yi
as$V=>$E){if($E!==null){$Yb=$_SESSION["db"][$dj][$M][$V];foreach(($Yb?array_keys($Yb):array(""))as$j)$Qf.="<li><a href='".h(auth_url($dj,$M,$V,$j))."'>($mc[$dj]) ".h($V.($M!=""?"@".$this->serverName($M):"").($j!=""?" - $j":""))."</a>\n";}}}}if($Qf)echo"<ul id='logins'>\n$Qf</ul>\n".script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");}else{$S=array();if($_GET["ns"]!==""&&!$Xe&&DB!=""){$f->select_db(DB);$S=table_status('',true);}echo
script_src(preg_replace("~\\?.*~","",ME)."?file=jush.js&version=5.0.1");if(support("sql")){echo'<script',nonce(),'>
';if($S){$Be=array();foreach($S
as$Q=>$U)$Be[]=preg_quote($Q,'/');echo"var jushLinks = { ".JUSH.": [ '".js_escape(ME).(support("table")?"table=":"select=")."\$&', /\\b(".implode("|",$Be).")\\b/g ] };\n";foreach(array("bac","bra","sqlite_quo","mssql_bra")as$X)echo"jushLinks.$X = jushLinks.".JUSH.";\n";}$ph=$f->server_info;echo'bodyLoad(\'',(is_object($f)?preg_replace('~^(\d\.?\d).*~s','\1',$ph):""),'\'',(preg_match('~MariaDB~',$ph)?", true":""),');
</script>
';}$this->databasesPrint($Xe);$va=array();if(DB==""||!$Xe){if(support("sql")){$va[]="<a href='".h(ME)."sql='".bold(isset($_GET["sql"])&&!isset($_GET["import"])).">".'SQL å‘½ä»¤'."</a>";$va[]="<a href='".h(ME)."import='".bold(isset($_GET["import"])).">".'åŒ¯å…¥'."</a>";}$va[]="<a href='".h(ME)."dump=".urlencode(isset($_GET["table"])?$_GET["table"]:$_GET["select"])."' id='dump'".bold(isset($_GET["dump"])).">".'åŒ¯å‡º'."</a>";}$Rd=$_GET["ns"]!==""&&!$Xe&&DB!="";if($Rd)$va[]='<a href="'.h(ME).'create="'.bold($_GET["create"]==="").">".'å»ºç«‹è³‡æ–™è¡¨'."</a>";echo($va?"<p class='links'>\n".implode("\n",$va)."\n":"");if($Rd){if($S)$this->tablesPrint($S);else
echo"<p class='message'>".'æ²’æœ‰è³‡æ–™è¡¨ã€‚'."</p>\n";}}}function
databasesPrint($Xe){global$b,$f;$i=$this->databases();if(DB&&$i&&!in_array(DB,$i))array_unshift($i,DB);echo'<form action="">
<p id="dbs">
';hidden_fields_get();$Wb=script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");echo"<span title='".'è³‡æ–™åº«'."'>".'è³‡æ–™åº«'."</span>: ".($i?"<select name='db'>".optionlist(array(""=>"")+$i,DB)."</select>$Wb":"<input name='db' value='".h(DB)."' autocapitalize='off' size='19'>\n"),"<input type='submit' value='".'ä½¿ç”¨'."'".($i?" class='hidden'":"").">\n";if(support("scheme")){if($Xe!="db"&&DB!=""&&$f->select_db(DB)){echo"<br>".'è³‡æ–™è¡¨çµæ§‹'.": <select name='ns'>".optionlist(array(""=>"")+$b->schemas(),$_GET["ns"])."</select>$Wb";if($_GET["ns"]!="")set_schema($_GET["ns"]);}}foreach(array("import","sql","schema","dump","privileges")as$X){if(isset($_GET[$X])){echo"<input type='hidden' name='$X' value=''>";break;}}echo"</p></form>\n";}function
tablesPrint($S){echo"<ul id='tables'>".script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");foreach($S
as$Q=>$O){$B=$this->tableName($O);if($B!=""){echo'<li><a href="'.h(ME).'select='.urlencode($Q).'"'.bold($_GET["select"]==$Q||$_GET["edit"]==$Q,"select")." title='".'é¸æ“‡è³‡æ–™'."'>".'é¸æ“‡'."</a> ",(support("table")||support("indexes")?'<a href="'.h(ME).'table='.urlencode($Q).'"'.bold(in_array($Q,array($_GET["table"],$_GET["create"],$_GET["indexes"],$_GET["foreign"],$_GET["trigger"])),(is_view($O)?"view":"structure"))." title='".'é¡¯ç¤ºçµæ§‹'."'>$B</a>":"<span>$B</span>")."\n";}}echo"</ul>\n";}}$b=(function_exists('adminer_object')?adminer_object():new
Adminer);$mc=array("server"=>"MySQL")+$mc;if(!defined('Adminer\DRIVER')){define('Adminer\DRIVER',"server");if(extension_loaded("mysqli")){class
Db
extends
\MySQLi{var$extension="MySQLi";function
__construct(){parent::init();}function
connect($M="",$V="",$E="",$Ub=null,$ig=null,$zh=null){global$b;mysqli_report(MYSQLI_REPORT_OFF);list($Jd,$ig)=explode(":",$M,2);$Ih=$b->connectSsl();if($Ih)$this->ssl_set($Ih['key'],$Ih['cert'],$Ih['ca'],'','');$I=@$this->real_connect(($M!=""?$Jd:ini_get("mysqli.default_host")),($M.$V!=""?$V:ini_get("mysqli.default_user")),($M.$V.$E!=""?$E:ini_get("mysqli.default_pw")),$Ub,(is_numeric($ig)?$ig:ini_get("mysqli.default_port")),(!is_numeric($ig)?$ig:$zh),($Ih?($Ih['verify']!==false?2048:64):0));$this->options(MYSQLI_OPT_LOCAL_INFILE,false);return$I;}function
set_charset($db){if(parent::set_charset($db))return
true;parent::set_charset('utf8');return$this->query("SET NAMES $db");}function
result($G,$n=0){$H=$this->query($G);if(!$H)return
false;$J=$H->fetch_array();return$J[$n];}function
quote($P){return"'".$this->escape_string($P)."'";}}}elseif(extension_loaded("mysql")&&!((ini_bool("sql.safe_mode")||ini_bool("mysql.allow_local_infile"))&&extension_loaded("pdo_mysql"))){class
Db{var$extension="MySQL",$server_info,$affected_rows,$errno,$error,$_link,$_result;function
connect($M,$V,$E){if(ini_bool("mysql.allow_local_infile")){$this->error=sprintf('ç¦ç”¨ %s æˆ–å•Ÿç”¨ %s æˆ– %s æ“´å……æ¨¡çµ„ã€‚',"'mysql.allow_local_infile'","MySQLi","PDO_MySQL");return
false;}$this->_link=@mysql_connect(($M!=""?$M:ini_get("mysql.default_host")),("$M$V"!=""?$V:ini_get("mysql.default_user")),("$M$V$E"!=""?$E:ini_get("mysql.default_password")),true,131072);if($this->_link)$this->server_info=mysql_get_server_info($this->_link);else$this->error=mysql_error();return(bool)$this->_link;}function
set_charset($db){if(function_exists('mysql_set_charset')){if(mysql_set_charset($db,$this->_link))return
true;mysql_set_charset('utf8',$this->_link);}return$this->query("SET NAMES $db");}function
quote($P){return"'".mysql_real_escape_string($P,$this->_link)."'";}function
select_db($Ub){return
mysql_select_db($Ub,$this->_link);}function
query($G,$Ii=false){$H=@($Ii?mysql_unbuffered_query($G,$this->_link):mysql_query($G,$this->_link));$this->error="";if(!$H){$this->errno=mysql_errno($this->_link);$this->error=mysql_error($this->_link);return
false;}if($H===true){$this->affected_rows=mysql_affected_rows($this->_link);$this->info=mysql_info($this->_link);return
true;}return
new
Result($H);}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($G,$n=0){$H=$this->query($G);if(!$H||!$H->num_rows)return
false;return
mysql_result($H->_result,0,$n);}}class
Result{var$num_rows,$_result,$_offset=0;function
__construct($H){$this->_result=$H;$this->num_rows=mysql_num_rows($H);}function
fetch_assoc(){return
mysql_fetch_assoc($this->_result);}function
fetch_row(){return
mysql_fetch_row($this->_result);}function
fetch_field(){$I=mysql_fetch_field($this->_result,$this->_offset++);$I->orgtable=$I->table;$I->orgname=$I->name;$I->charsetnr=($I->blob?63:0);return$I;}function
__destruct(){mysql_free_result($this->_result);}}}elseif(extension_loaded("pdo_mysql")){class
Db
extends
PdoDb{var$extension="PDO_MySQL";function
connect($M,$V,$E){global$b;$Cf=array(\PDO::MYSQL_ATTR_LOCAL_INFILE=>false);$Ih=$b->connectSsl();if($Ih){if($Ih['key'])$Cf[\PDO::MYSQL_ATTR_SSL_KEY]=$Ih['key'];if($Ih['cert'])$Cf[\PDO::MYSQL_ATTR_SSL_CERT]=$Ih['cert'];if($Ih['ca'])$Cf[\PDO::MYSQL_ATTR_SSL_CA]=$Ih['ca'];if(isset($Ih['verify']))$Cf[\PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT]=$Ih['verify'];}$this->dsn("mysql:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\d)~',';port=\1',$M)),$V,$E,$Cf);return
true;}function
set_charset($db){$this->query("SET NAMES $db");}function
select_db($Ub){return$this->query("USE ".idf_escape($Ub));}function
query($G,$Ii=false){$this->pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,!$Ii);return
parent::query($G,$Ii);}}}class
Driver
extends
SqlDriver{static$mg=array("MySQLi","MySQL","PDO_MySQL");static$ke="sql";var$unsigned=array("unsigned","zerofill","unsigned zerofill");var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","REGEXP","IN","FIND_IN_SET","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL");var$functions=array("char_length","date","from_unixtime","lower","round","floor","ceil","sec_to_time","time_to_sec","upper");var$grouping=array("avg","count","count distinct","group_concat","max","min","sum");function
__construct($f){parent::__construct($f);$this->types=array('æ•¸å­—'=>array("tinyint"=>3,"smallint"=>5,"mediumint"=>8,"int"=>10,"bigint"=>20,"decimal"=>66,"float"=>12,"double"=>21),'æ—¥æœŸæ™‚é–“'=>array("date"=>10,"datetime"=>19,"timestamp"=>19,"time"=>10,"year"=>4),'å­—ä¸²'=>array("char"=>255,"varchar"=>65535,"tinytext"=>255,"text"=>65535,"mediumtext"=>16777215,"longtext"=>4294967295),'åˆ—è¡¨'=>array("enum"=>65535,"set"=>64),'äºŒé€²ä½'=>array("bit"=>20,"binary"=>255,"varbinary"=>65535,"tinyblob"=>255,"blob"=>65535,"mediumblob"=>16777215,"longblob"=>4294967295),'å¹¾ä½•'=>array("geometry"=>0,"point"=>0,"linestring"=>0,"polygon"=>0,"multipoint"=>0,"multilinestring"=>0,"multipolygon"=>0,"geometrycollection"=>0),);$this->editFunctions=array(array("char"=>"md5/sha1/password/encrypt/uuid","binary"=>"md5/sha1","date|time"=>"now",),array(number_type()=>"+/-","date"=>"+ interval/- interval","time"=>"addtime/subtime","char|text"=>"concat",));if(min_version('5.7.8',10.2,$f))$this->types['å­—ä¸²']["json"]=4294967295;if(min_version('',10.7,$f)){$this->types['å­—ä¸²']["uuid"]=128;$this->editFunctions[0]['uuid']='uuid';}if(min_version(9,'',$f)){$this->types['æ•¸å­—']["vector"]=16383;$this->editFunctions[0]['vector']='string_to_vector';}if(min_version(5.7,10.2,$f))$this->generated=array("STORED","VIRTUAL");}function
insert($Q,$N){return($N?parent::insert($Q,$N):queries("INSERT INTO ".table($Q)." ()\nVALUES ()"));}function
insertUpdate($Q,$K,$F){$e=array_keys(reset($K));$og="INSERT INTO ".table($Q)." (".implode(", ",$e).") VALUES\n";$bj=array();foreach($e
as$y)$bj[$y]="$y = VALUES($y)";$Ph="\nON DUPLICATE KEY UPDATE ".implode(", ",$bj);$bj=array();$ze=0;foreach($K
as$N){$Y="(".implode(", ",$N).")";if($bj&&(strlen($og)+$ze+strlen($Y)+strlen($Ph)>1e6)){if(!queries($og.implode(",\n",$bj).$Ph))return
false;$bj=array();$ze=0;}$bj[]=$Y;$ze+=strlen($Y)+2;}return
queries($og.implode(",\n",$bj).$Ph);}function
slowQuery($G,$li){if(min_version('5.7.8','10.1.2')){if(preg_match('~MariaDB~',$this->_conn->server_info))return"SET STATEMENT max_statement_time=$li FOR $G";elseif(preg_match('~^(SELECT\b)(.+)~is',$G,$A))return"$A[1] /*+ MAX_EXECUTION_TIME(".($li*1000).") */ $A[2]";}}function
convertSearch($v,$X,$n){return(preg_match('~char|text|enum|set~',$n["type"])&&!preg_match("~^utf8~",$n["collation"])&&preg_match('~[\x80-\xFF]~',$X['val'])?"CONVERT($v USING ".charset($this->_conn).")":$v);}function
warnings(){$H=$this->_conn->query("SHOW WARNINGS");if($H&&$H->num_rows){ob_start();select($H);return
ob_get_clean();}}function
tableHelp($B,$he=false){$Fe=preg_match('~MariaDB~',$this->_conn->server_info);if(information_schema(DB))return
strtolower("information-schema-".($Fe?"$B-table/":str_replace("_","-",$B)."-table.html"));if(DB=="mysql")return($Fe?"mysql$B-table/":"system-schema.html");}function
hasCStyleEscapes(){static$Za;if($Za===null){$Gh=$this->_conn->result("SHOW VARIABLES LIKE 'sql_mode'",1);$Za=(strpos($Gh,'NO_BACKSLASH_ESCAPES')===false);}return$Za;}}function
idf_escape($v){return"`".str_replace("`","``",$v)."`";}function
table($v){return
idf_escape($v);}function
connect($Nb){$f=new
Db;if($f->connect($Nb[0],$Nb[1],$Nb[2])){$f->set_charset(charset($f));$f->query("SET sql_quote_show_create = 1, autocommit = 1");return$f;}$I=$f->error;if(function_exists('iconv')&&!is_utf8($I)&&strlen($ah=iconv("windows-1250","utf-8",$I))>strlen($I))$I=$ah;return$I;}function
get_databases($kd){$I=get_session("dbs");if($I===null){$G="SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME";$I=($kd?slow_query($G):get_vals($G));restart_session();set_session("dbs",$I);stop_session();}return$I;}function
limit($G,$Z,$z,$C=0,$lh=" "){return" $G$Z".($z!==null?$lh."LIMIT $z".($C?" OFFSET $C":""):"");}function
limit1($Q,$G,$Z,$lh="\n"){return
limit($G,$Z,1,0,$lh);}function
db_collation($j,$rb){global$f;$I=null;$h=$f->result("SHOW CREATE DATABASE ".idf_escape($j),1);if(preg_match('~ COLLATE ([^ ]+)~',$h,$A))$I=$A[1];elseif(preg_match('~ CHARACTER SET ([^ ]+)~',$h,$A))$I=$rb[$A[1]][-1];return$I;}function
engines(){$I=array();foreach(get_rows("SHOW ENGINES")as$J){if(preg_match("~YES|DEFAULT~",$J["Support"]))$I[]=$J["Engine"];}return$I;}function
logged_user(){global$f;return$f->result("SELECT USER()");}function
tables_list(){return
get_key_vals("SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME");}function
count_tables($i){$I=array();foreach($i
as$j)$I[$j]=count(get_vals("SHOW TABLES IN ".idf_escape($j)));return$I;}function
table_status($B="",$Zc=false){$I=array();foreach(get_rows($Zc?"SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ".($B!=""?"AND TABLE_NAME = ".q($B):"ORDER BY Name"):"SHOW TABLE STATUS".($B!=""?" LIKE ".q(addcslashes($B,"%_\\")):""))as$J){if($J["Engine"]=="InnoDB")$J["Comment"]=preg_replace('~(?:(.+); )?InnoDB free: .*~','\1',$J["Comment"]);if(!isset($J["Engine"]))$J["Comment"]="";if($B!=""){$J["Name"]=$B;return$J;}$I[$J["Name"]]=$J;}return$I;}function
is_view($R){return$R["Engine"]===null;}function
fk_support($R){return
preg_match('~InnoDB|IBMDB2I~i',$R["Engine"])||(preg_match('~NDB~i',$R["Engine"])&&min_version(5.6));}function
fields($Q){$I=array();foreach(get_rows("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ".q($Q)." ORDER BY ORDINAL_POSITION")as$J){$n=$J["COLUMN_NAME"];$k=$J["COLUMN_DEFAULT"];$U=$J["COLUMN_TYPE"];$Wc=$J["EXTRA"];preg_match('~^(VIRTUAL|PERSISTENT|STORED)~',$Wc,$ud);preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~',$U,$A);$I[$n]=array("field"=>$n,"full_type"=>$U,"type"=>$A[1],"length"=>$A[2],"unsigned"=>ltrim($A[3].$A[4]),"default"=>($ud?$J["GENERATION_EXPRESSION"]:($k!=""||preg_match("~char|set~",$A[1])?(preg_match('~text~',$A[1])?stripslashes(preg_replace("~^'(.*)'\$~",'\1',$k)):$k):null)),"null"=>($J["IS_NULLABLE"]=="YES"),"auto_increment"=>($Wc=="auto_increment"),"on_update"=>(preg_match('~\bon update (\w+)~i',$Wc,$A)?$A[1]:""),"collation"=>$J["COLLATION_NAME"],"privileges"=>array_flip(explode(",",$J["PRIVILEGES"])),"comment"=>$J["COLUMN_COMMENT"],"primary"=>($J["COLUMN_KEY"]=="PRI"),"generated"=>($ud[1]=="PERSISTENT"?"STORED":$ud[1]),);}return$I;}function
indexes($Q,$g=null){$I=array();foreach(get_rows("SHOW INDEX FROM ".table($Q),$g)as$J){$B=$J["Key_name"];$I[$B]["type"]=($B=="PRIMARY"?"PRIMARY":($J["Index_type"]=="FULLTEXT"?"FULLTEXT":($J["Non_unique"]?($J["Index_type"]=="SPATIAL"?"SPATIAL":"INDEX"):"UNIQUE")));$I[$B]["columns"][]=$J["Column_name"];$I[$B]["lengths"][]=($J["Index_type"]=="SPATIAL"?null:$J["Sub_part"]);$I[$B]["descs"][]=null;}return$I;}function
foreign_keys($Q){global$f,$l;static$eg='(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';$I=array();$Lb=$f->result("SHOW CREATE TABLE ".table($Q),1);if($Lb){preg_match_all("~CONSTRAINT ($eg) FOREIGN KEY ?\\(((?:$eg,? ?)+)\\) REFERENCES ($eg)(?:\\.($eg))? \\(((?:$eg,? ?)+)\\)(?: ON DELETE ($l->onActions))?(?: ON UPDATE ($l->onActions))?~",$Lb,$Ie,PREG_SET_ORDER);foreach($Ie
as$A){preg_match_all("~$eg~",$A[2],$Ah);preg_match_all("~$eg~",$A[5],$di);$I[idf_unescape($A[1])]=array("db"=>idf_unescape($A[4]!=""?$A[3]:$A[4]),"table"=>idf_unescape($A[4]!=""?$A[4]:$A[3]),"source"=>array_map('Adminer\idf_unescape',$Ah[0]),"target"=>array_map('Adminer\idf_unescape',$di[0]),"on_delete"=>($A[6]?:"RESTRICT"),"on_update"=>($A[7]?:"RESTRICT"),);}}return$I;}function
view($B){global$f;return
array("select"=>preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU','',$f->result("SHOW CREATE VIEW ".table($B),1)));}function
collations(){$I=array();foreach(get_rows("SHOW COLLATION")as$J){if($J["Default"])$I[$J["Charset"]][-1]=$J["Collation"];else$I[$J["Charset"]][]=$J["Collation"];}ksort($I);foreach($I
as$y=>$X)asort($I[$y]);return$I;}function
information_schema($j){return($j=="information_schema")||(min_version(5.5)&&$j=="performance_schema");}function
error(){global$f;return
h(preg_replace('~^You have an error.*syntax to use~U',"Syntax error",$f->error));}function
create_database($j,$qb){return
queries("CREATE DATABASE ".idf_escape($j).($qb?" COLLATE ".q($qb):""));}function
drop_databases($i){$I=apply_queries("DROP DATABASE",$i,'Adminer\idf_escape');restart_session();set_session("dbs",null);return$I;}function
rename_database($B,$qb){$I=false;if(create_database($B,$qb)){$S=array();$gj=array();foreach(tables_list()as$Q=>$U){if($U=='VIEW')$gj[]=$Q;else$S[]=$Q;}$I=(!$S&&!$gj)||move_tables($S,$gj,$B);drop_databases($I?array(DB):array());}return$I;}function
auto_increment(){$Ma=" PRIMARY KEY";if($_GET["create"]!=""&&$_POST["auto_increment_col"]){foreach(indexes($_GET["create"])as$w){if(in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"],$w["columns"],true)){$Ma="";break;}if($w["type"]=="PRIMARY")$Ma=" UNIQUE";}}return" AUTO_INCREMENT$Ma";}function
alter_table($Q,$B,$o,$md,$xb,$Cc,$qb,$La,$ag){$c=array();foreach($o
as$n){if($n[1]){$k=$n[1][3];if(preg_match('~ GENERATED~',$k)){$n[1][3]=$n[1][2];$n[1][2]=$k;}$c[]=($Q!=""?($n[0]!=""?"CHANGE ".idf_escape($n[0]):"ADD"):" ")." ".implode($n[1]).($Q!=""?$n[2]:"");}else$c[]="DROP ".idf_escape($n[0]);}$c=array_merge($c,$md);$O=($xb!==null?" COMMENT=".q($xb):"").($Cc?" ENGINE=".q($Cc):"").($qb?" COLLATE ".q($qb):"").($La!=""?" AUTO_INCREMENT=$La":"");if($Q=="")return
queries("CREATE TABLE ".table($B)." (\n".implode(",\n",$c)."\n)$O$ag");if($Q!=$B)$c[]="RENAME TO ".table($B);if($O)$c[]=ltrim($O);return($c||$ag?queries("ALTER TABLE ".table($Q)."\n".implode(",\n",$c).$ag):true);}function
alter_indexes($Q,$c){foreach($c
as$y=>$X)$c[$y]=($X[2]=="DROP"?"\nDROP INDEX ".idf_escape($X[1]):"\nADD $X[0] ".($X[0]=="PRIMARY"?"KEY ":"").($X[1]!=""?idf_escape($X[1])." ":"")."(".implode(", ",$X[2]).")");return
queries("ALTER TABLE ".table($Q).implode(",",$c));}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($gj){return
queries("DROP VIEW ".implode(", ",array_map('Adminer\table',$gj)));}function
drop_tables($S){return
queries("DROP TABLE ".implode(", ",array_map('Adminer\table',$S)));}function
move_tables($S,$gj,$di){global$f;$Mg=array();foreach($S
as$Q)$Mg[]=table($Q)." TO ".idf_escape($di).".".table($Q);if(!$Mg||queries("RENAME TABLE ".implode(", ",$Mg))){$cc=array();foreach($gj
as$Q)$cc[table($Q)]=view($Q);$f->select_db($di);$j=idf_escape(DB);foreach($cc
as$B=>$fj){if(!queries("CREATE VIEW $B AS ".str_replace(" $j."," ",$fj["select"]))||!queries("DROP VIEW $j.$B"))return
false;}return
true;}return
false;}function
copy_tables($S,$gj,$di){queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");foreach($S
as$Q){$B=($di==DB?table("copy_$Q"):idf_escape($di).".".table($Q));if(($_POST["overwrite"]&&!queries("\nDROP TABLE IF EXISTS $B"))||!queries("CREATE TABLE $B LIKE ".table($Q))||!queries("INSERT INTO $B SELECT * FROM ".table($Q)))return
false;foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")))as$J){$Bi=$J["Trigger"];if(!queries("CREATE TRIGGER ".($di==DB?idf_escape("copy_$Bi"):idf_escape($di).".".idf_escape($Bi))." $J[Timing] $J[Event] ON $B FOR EACH ROW\n$J[Statement];"))return
false;}}foreach($gj
as$Q){$B=($di==DB?table("copy_$Q"):idf_escape($di).".".table($Q));$fj=view($Q);if(($_POST["overwrite"]&&!queries("DROP VIEW IF EXISTS $B"))||!queries("CREATE VIEW $B AS $fj[select]"))return
false;}return
true;}function
trigger($B){if($B=="")return
array();$K=get_rows("SHOW TRIGGERS WHERE `Trigger` = ".q($B));return
reset($K);}function
triggers($Q){$I=array();foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")))as$J)$I[$J["Trigger"]]=array($J["Timing"],$J["Event"]);return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
routine($B,$U){global$f,$l;$Ca=array("bool","boolean","integer","double precision","real","dec","numeric","fixed","national char","national varchar");$Bh="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$Gi="((".implode("|",array_merge(array_keys($l->types()),$Ca)).")\\b(?:\\s*\\(((?:[^'\")]|$l->enumLength)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";$eg="$Bh*(".($U=="FUNCTION"?"":$l->inout).")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$Gi";$h=$f->result("SHOW CREATE $U ".idf_escape($B),2);preg_match("~\\(((?:$eg\\s*,?)*)\\)\\s*".($U=="FUNCTION"?"RETURNS\\s+$Gi\\s+":"")."(.*)~is",$h,$A);$o=array();preg_match_all("~$eg\\s*,?~is",$A[1],$Ie,PREG_SET_ORDER);foreach($Ie
as$Uf)$o[]=array("field"=>str_replace("``","`",$Uf[2]).$Uf[3],"type"=>strtolower($Uf[5]),"length"=>preg_replace_callback("~$l->enumLength~s",'Adminer\normalize_enum',$Uf[6]),"unsigned"=>strtolower(preg_replace('~\s+~',' ',trim("$Uf[8] $Uf[7]"))),"null"=>1,"full_type"=>$Uf[4],"inout"=>strtoupper($Uf[1]),"collation"=>strtolower($Uf[9]),);return
array("fields"=>$o,"comment"=>$f->result("SELECT ROUTINE_COMMENT FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = DATABASE() AND ROUTINE_NAME = ".q($B)),)+($U!="FUNCTION"?array("definition"=>$A[11]):array("returns"=>array("type"=>$A[12],"length"=>$A[13],"unsigned"=>$A[15],"collation"=>$A[16]),"definition"=>$A[17],"language"=>"SQL",));}function
routines(){return
get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = DATABASE()");}function
routine_languages(){return
array();}function
routine_id($B,$J){return
idf_escape($B);}function
last_id(){global$f;return$f->result("SELECT LAST_INSERT_ID()");}function
explain($f,$G){return$f->query("EXPLAIN ".(min_version(5.1)&&!min_version(5.7)?"PARTITIONS ":"").$G);}function
found_rows($R,$Z){return($Z||$R["Engine"]!="InnoDB"?null:$R["Rows"]);}function
create_sql($Q,$La,$Nh){global$f;$I=$f->result("SHOW CREATE TABLE ".table($Q),1);if(!$La)$I=preg_replace('~ AUTO_INCREMENT=\d+~','',$I);return$I;}function
truncate_sql($Q){return"TRUNCATE ".table($Q);}function
use_sql($Ub){return"USE ".idf_escape($Ub);}function
trigger_sql($Q){$I="";foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")),null,"-- ")as$J)$I.="\nCREATE TRIGGER ".idf_escape($J["Trigger"])." $J[Timing] $J[Event] ON ".table($J["Table"])." FOR EACH ROW\n$J[Statement];;\n";return$I;}function
show_variables(){return
get_key_vals("SHOW VARIABLES");}function
process_list(){return
get_rows("SHOW FULL PROCESSLIST");}function
show_status(){return
get_key_vals("SHOW STATUS");}function
convert_field($n){if(preg_match("~binary~",$n["type"]))return"HEX(".idf_escape($n["field"]).")";if($n["type"]=="bit")return"BIN(".idf_escape($n["field"])." + 0)";if(preg_match("~geometry|point|linestring|polygon~",$n["type"]))return(min_version(8)?"ST_":"")."AsWKT(".idf_escape($n["field"]).")";}function
unconvert_field($n,$I){if(preg_match("~binary~",$n["type"]))$I="UNHEX($I)";if($n["type"]=="bit")$I="CONVERT(b$I, UNSIGNED)";if(preg_match("~geometry|point|linestring|polygon~",$n["type"])){$og=(min_version(8)?"ST_":"");$I=$og."GeomFromText($I, $og"."SRID($n[field]))";}return$I;}function
support($ad){return!preg_match("~scheme|sequence|type|view_trigger|materializedview".(min_version(8)?"":"|descidx".(min_version(5.1)?"":"|event|partitioning")).(min_version('8.0.16','10.2.1')?"":"|check")."~",$ad);}function
kill_process($X){return
queries("KILL ".number($X));}function
connection_id(){return"SELECT CONNECTION_ID()";}function
max_connections(){global$f;return$f->result("SELECT @@max_connections");}}define('Adminer\JUSH',Driver::$ke);define('Adminer\SERVER',$_GET[DRIVER]);define('Adminer\DB',$_GET["db"]);define('Adminer\ME',preg_replace('~\?.*~','',relative_uri()).'?'.(sid()?SID.'&':'').(SERVER!==null?DRIVER."=".urlencode(SERVER).'&':'').(isset($_GET["username"])?"username=".urlencode($_GET["username"]).'&':'').(DB!=""?'db='.urlencode(DB).'&'.(isset($_GET["ns"])?"ns=".urlencode($_GET["ns"])."&":""):''));if(!ob_get_level())ob_start(null,4096);function
page_header($ni,$m="",$Va=array(),$oi=""){global$ca,$ia,$b,$mc;page_headers();if(is_ajax()&&$m){page_messages($m);exit;}$pi=$ni.($oi!=""?": $oi":"");$qi=strip_tags($pi.(SERVER!=""&&SERVER!="localhost"?h(" - ".SERVER):"")." - ".$b->name());echo'<!DOCTYPE html>
<html lang="zh-tw" dir="ltr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width">
<title>',$qi,'</title>
<link rel="stylesheet" type="text/css" href="',h(preg_replace("~\\?.*~","",ME)."?file=default.css&version=5.0.1"),'">
',script_src(preg_replace("~\\?.*~","",ME)."?file=functions.js&version=5.0.1");if($b->head()){echo'<link rel="shortcut icon" type="image/x-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=5.0.1"),'">
<link rel="apple-touch-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=5.0.1"),'">
';foreach($b->css()as$Pb){echo'<link rel="stylesheet" type="text/css" href="',h($Pb),'">
';}}echo'
<body class="ltr nojs">
';$p=get_temp_dir()."/adminer.version";if(!$_COOKIE["adminer_version"]&&function_exists('openssl_verify')&&file_exists($p)&&filemtime($p)+86400>time()){$ej=unserialize(file_get_contents($p));$xg="-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";if(openssl_verify($ej["version"],base64_decode($ej["signature"]),$xg)==1)$_COOKIE["adminer_version"]=$ej["version"];}echo'<script',nonce(),'>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick',(isset($_COOKIE["adminer_version"])?"":", onload: partial(verifyVersion, '$ia', '".js_escape(ME)."', '".get_token()."')");?>});
document.body.className = document.body.className.replace(/ nojs/, ' js');
var offlineMessage = '<?php echo
js_escape('æ‚¨é›¢ç·šäº†ã€‚'),'\';
var thousandsSeparator = \'',js_escape(','),'\';
</script>

<div id="help" class="jush-',JUSH,' jsonly hidden"></div>
',script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"),'
<div id="content">
';if($Va!==null){$_=substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1);echo'<p id="breadcrumb"><a href="'.h($_?:".").'">'.$mc[DRIVER].'</a> Â» ';$_=substr(preg_replace('~\b(db|ns)=[^&]*&~','',ME),0,-1);$M=$b->serverName(SERVER);$M=($M!=""?$M:'ä¼ºæœå™¨');if($Va===false)echo"$M\n";else{echo"<a href='".h($_)."' accesskey='1' title='Alt+Shift+1'>$M</a> Â» ";if($_GET["ns"]!=""||(DB!=""&&is_array($Va)))echo'<a href="'.h($_."&db=".urlencode(DB).(support("scheme")?"&ns=":"")).'">'.h(DB).'</a> Â» ';if(is_array($Va)){if($_GET["ns"]!="")echo'<a href="'.h(substr(ME,0,-1)).'">'.h($_GET["ns"]).'</a> Â» ';foreach($Va
as$y=>$X){$ec=(is_array($X)?$X[1]:h($X));if($ec!="")echo"<a href='".h(ME."$y=").urlencode(is_array($X)?$X[0]:$X)."'>$ec</a> Â» ";}}echo"$ni\n";}}echo"<h2>$pi</h2>\n","<div id='ajaxstatus' class='jsonly hidden'></div>\n";restart_session();page_messages($m);$i=&get_session("dbs");if(DB!=""&&$i&&!in_array(DB,$i,true))$i=null;stop_session();define('Adminer\PAGE_HEADER',1);}function
page_headers(){global$b;header("Content-Type: text/html; charset=utf-8");header("Cache-Control: no-cache");header("X-Frame-Options: deny");header("X-XSS-Protection: 0");header("X-Content-Type-Options: nosniff");header("Referrer-Policy: origin-when-cross-origin");foreach($b->csp()as$Ob){$Fd=array();foreach($Ob
as$y=>$X)$Fd[]="$y $X";header("Content-Security-Policy: ".implode("; ",$Fd));}$b->headers();}function
csp(){return
array(array("script-src"=>"'self' 'unsafe-inline' 'nonce-".get_nonce()."' 'strict-dynamic'","connect-src"=>"'self'","frame-src"=>"https://www.adminer.org","object-src"=>"'none'","base-uri"=>"'none'","form-action"=>"'self'",),);}function
get_nonce(){static$hf;if(!$hf)$hf=base64_encode(rand_string());return$hf;}function
page_messages($m){$Ri=preg_replace('~^[^?]*~','',$_SERVER["REQUEST_URI"]);$Ve=$_SESSION["messages"][$Ri];if($Ve){echo"<div class='message'>".implode("</div>\n<div class='message'>",$Ve)."</div>".script("messagesPrint();");unset($_SESSION["messages"][$Ri]);}if($m)echo"<div class='error'>$m</div>\n";}function
page_footer($Xe=""){global$b,$T;echo'</div>

<div id="menu">
';$b->navigation($Xe);echo'</div>

';if($Xe!="auth"){echo'<form action="" method="post">
<p class="logout">
',h($_GET["username"])."\n",'<input type="submit" name="logout" value="ç™»å‡º" id="logout">
<input type="hidden" name="token" value="',$T,'">
</p>
</form>
';}echo
script("setupSubmitHighlight(document);");}function
int32($af){while($af>=2147483648)$af-=4294967296;while($af<=-2147483649)$af+=4294967296;return(int)$af;}function
long2str($W,$ij){$ah='';foreach($W
as$X)$ah.=pack('V',$X);if($ij)return
substr($ah,0,end($W));return$ah;}function
str2long($ah,$ij){$W=array_values(unpack('V*',str_pad($ah,4*ceil(strlen($ah)/4),"\0")));if($ij)$W[]=strlen($ah);return$W;}function
xxtea_mx($uj,$tj,$Qh,$le){return
int32((($uj>>5&0x7FFFFFF)^$tj<<2)+(($tj>>3&0x1FFFFFFF)^$uj<<4))^int32(($Qh^$tj)+($le^$uj));}function
encrypt_string($Lh,$y){if($Lh=="")return"";$y=array_values(unpack("V*",pack("H*",md5($y))));$W=str2long($Lh,true);$af=count($W)-1;$uj=$W[$af];$tj=$W[0];$yg=floor(6+52/($af+1));$Qh=0;while($yg-->0){$Qh=int32($Qh+0x9E3779B9);$uc=$Qh>>2&3;for($Sf=0;$Sf<$af;$Sf++){$tj=$W[$Sf+1];$Ze=xxtea_mx($uj,$tj,$Qh,$y[$Sf&3^$uc]);$uj=int32($W[$Sf]+$Ze);$W[$Sf]=$uj;}$tj=$W[0];$Ze=xxtea_mx($uj,$tj,$Qh,$y[$Sf&3^$uc]);$uj=int32($W[$af]+$Ze);$W[$af]=$uj;}return
long2str($W,false);}function
decrypt_string($Lh,$y){if($Lh=="")return"";if(!$y)return
false;$y=array_values(unpack("V*",pack("H*",md5($y))));$W=str2long($Lh,false);$af=count($W)-1;$uj=$W[$af];$tj=$W[0];$yg=floor(6+52/($af+1));$Qh=int32($yg*0x9E3779B9);while($Qh){$uc=$Qh>>2&3;for($Sf=$af;$Sf>0;$Sf--){$uj=$W[$Sf-1];$Ze=xxtea_mx($uj,$tj,$Qh,$y[$Sf&3^$uc]);$tj=int32($W[$Sf]-$Ze);$W[$Sf]=$tj;}$uj=$W[$af];$Ze=xxtea_mx($uj,$tj,$Qh,$y[$Sf&3^$uc]);$tj=int32($W[0]-$Ze);$W[0]=$tj;$Qh=int32($Qh-0x9E3779B9);}return
long2str($W,true);}$f='';$Ed=$_SESSION["token"];if(!$Ed)$_SESSION["token"]=rand(1,1e6);$T=get_token();$gg=array();if($_COOKIE["adminer_permanent"]){foreach(explode(" ",$_COOKIE["adminer_permanent"])as$X){list($y)=explode(":",$X);$gg[$y]=$X;}}function
add_invalid_login(){global$b;$r=file_open_lock(get_temp_dir()."/adminer.invalid");if(!$r)return;$de=unserialize(stream_get_contents($r));$ki=time();if($de){foreach($de
as$ee=>$X){if($X[0]<$ki)unset($de[$ee]);}}$ce=&$de[$b->bruteForceKey()];if(!$ce)$ce=array($ki+30*60,0);$ce[1]++;file_write_unlock($r,serialize($de));}function
check_invalid_login(){global$b;$de=unserialize(@file_get_contents(get_temp_dir()."/adminer.invalid"));$ce=($de?$de[$b->bruteForceKey()]:array());$gf=($ce[1]>29?$ce[0]-time():0);if($gf>0)auth_error(sprintf('ç™»éŒ„å¤±æ•—æ¬¡æ•¸éå¤šï¼Œè«‹ %d åˆ†é˜å¾Œé‡è©¦ã€‚',ceil($gf/60)));}$Ja=$_POST["auth"];if($Ja){session_regenerate_id();$dj=$Ja["driver"];$M=$Ja["server"];$V=$Ja["username"];$E=(string)$Ja["password"];$j=$Ja["db"];set_password($dj,$M,$V,$E);$_SESSION["db"][$dj][$M][$V][$j]=true;if($Ja["permanent"]){$y=base64_encode($dj)."-".base64_encode($M)."-".base64_encode($V)."-".base64_encode($j);$sg=$b->permanentLogin(true);$gg[$y]="$y:".base64_encode($sg?encrypt_string($E,$sg):"");cookie("adminer_permanent",implode(" ",$gg));}if(count($_POST)==1||DRIVER!=$dj||SERVER!=$M||$_GET["username"]!==$V||DB!=$j)redirect(auth_url($dj,$M,$V,$j));}elseif($_POST["logout"]&&(!$Ed||verify_token())){foreach(array("pwds","db","dbs","queries")as$y)set_session($y,null);unset_permanent();redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1),'æˆåŠŸç™»å‡ºã€‚'.' '.'æ„Ÿè¬ä½¿ç”¨Adminerï¼Œè«‹è€ƒæ…®ç‚ºæˆ‘å€‘<a href="https://www.adminer.org/en/donation/">ææ¬¾ï¼ˆè‹±æ–‡ç¶²é ï¼‰</a>.');}elseif($gg&&!$_SESSION["pwds"]){session_regenerate_id();$sg=$b->permanentLogin();foreach($gg
as$y=>$X){list(,$kb)=explode(":",$X);list($dj,$M,$V,$j)=array_map('base64_decode',explode("-",$y));set_password($dj,$M,$V,decrypt_string(base64_decode($kb),$sg));$_SESSION["db"][$dj][$M][$V][$j]=true;}}function
unset_permanent(){global$gg;foreach($gg
as$y=>$X){list($dj,$M,$V,$j)=array_map('base64_decode',explode("-",$y));if($dj==DRIVER&&$M==SERVER&&$V==$_GET["username"]&&$j==DB)unset($gg[$y]);}cookie("adminer_permanent",implode(" ",$gg));}function
auth_error($m){global$b,$Ed;$rh=session_name();if(isset($_GET["username"])){header("HTTP/1.1 403 Forbidden");if(($_COOKIE[$rh]||$_GET[$rh])&&!$Ed)$m='Session å·²éæœŸï¼Œè«‹é‡æ–°ç™»å…¥ã€‚';else{restart_session();add_invalid_login();$E=get_password();if($E!==null){if($E===false)$m.=($m?'<br>':'').sprintf('ä¸»å¯†ç¢¼å·²éæœŸã€‚<a href="https://www.adminer.org/en/extension/"%s>è«‹æ“´å±•</a> %s æ–¹æ³•è®“å®ƒæ°¸ä¹…åŒ–ã€‚',target_blank(),'<code>permanentLogin()</code>');set_password(DRIVER,SERVER,$_GET["username"],null);}unset_permanent();}}if(!$_COOKIE[$rh]&&$_GET[$rh]&&ini_bool("session.use_only_cookies"))$m='Session å¿…é ˆè¢«å•Ÿç”¨ã€‚';$Vf=session_get_cookie_params();cookie("adminer_key",($_COOKIE["adminer_key"]?:rand_string()),$Vf["lifetime"]);page_header('ç™»å…¥',$m,null);echo"<form action='' method='post'>\n","<div>";if(hidden_fields($_POST,array("auth")))echo"<p class='message'>".'æ­¤æ“ä½œå°‡åœ¨æˆåŠŸä½¿ç”¨ç›¸åŒçš„æ†‘æ“šç™»éŒ„å¾ŒåŸ·è¡Œã€‚'."\n";echo"</div>\n";$b->loginForm();echo"</form>\n";page_footer("auth");exit;}if(isset($_GET["username"])&&!class_exists('Adminer\Db')){unset($_SESSION["pwds"][DRIVER]);unset_permanent();page_header('ç„¡æ“´å……æ¨¡çµ„',sprintf('æ²’æœ‰ä»»ä½•æ”¯æ´çš„ PHP æ“´å……æ¨¡çµ„ï¼ˆ%sï¼‰ã€‚',implode(", ",Driver::$mg)),false);page_footer("auth");exit;}stop_session(true);if(isset($_GET["username"])&&is_string(get_password())){list($Jd,$ig)=explode(":",SERVER,2);if(preg_match('~^\s*([-+]?\d+)~',$ig,$A)&&($A[1]<1024||$A[1]>65535))auth_error('ä¸å…è¨±é€£æ¥åˆ°ç‰¹æ¬ŠåŸ ã€‚');check_invalid_login();$f=connect($b->credentials());$l=new
Driver($f);if($b->operators===null)$b->operators=$l->operators;}$De=null;if(!is_object($f)||($De=$b->login($_GET["username"],get_password()))!==true){$m=(is_string($f)?nl_br(h($f)):(is_string($De)?$De:'ç„¡æ•ˆçš„æ†‘è­‰ã€‚'));auth_error($m.(preg_match('~^ | $~',get_password())?'<br>'.'æ‚¨è¼¸å…¥çš„å¯†ç¢¼ä¸­æœ‰ä¸€å€‹ç©ºæ ¼ï¼Œé€™å¯èƒ½æ˜¯å°è‡´å•é¡Œçš„åŸå› ã€‚':''));}if($_POST["logout"]&&$Ed&&!verify_token()){page_header('ç™»å‡º','ç„¡æ•ˆçš„ CSRF tokenã€‚è«‹é‡æ–°ç™¼é€è¡¨å–®ã€‚');page_footer("db");exit;}if($Ja&&$_POST["token"])$_POST["token"]=$T;$m='';if($_POST){if(!verify_token()){$Xd="max_input_vars";$Oe=ini_get($Xd);if(extension_loaded("suhosin")){foreach(array("suhosin.request.max_vars","suhosin.post.max_vars")as$y){$X=ini_get($y);if($X&&(!$Oe||$X<$Oe)){$Xd=$y;$Oe=$X;}}}$m=(!$_POST["token"]&&$Oe?sprintf('è¶…éå…è¨±çš„å­—æ®µæ•¸é‡çš„æœ€å¤§å€¼ã€‚è«‹å¢åŠ  %sã€‚',"'$Xd'"):'ç„¡æ•ˆçš„ CSRF tokenã€‚è«‹é‡æ–°ç™¼é€è¡¨å–®ã€‚'.' '.'å¦‚æœæ‚¨ä¸¦æ²’æœ‰å¾Adminerç™¼é€è«‹æ±‚ï¼Œè«‹é—œé–‰æ­¤é é¢ã€‚');}}elseif($_SERVER["REQUEST_METHOD"]=="POST"){$m=sprintf('POST è³‡æ–™å¤ªå¤§ã€‚æ¸›å°‘è³‡æ–™æˆ–è€…å¢åŠ  %s çš„è¨­å®šå€¼ã€‚',"'post_max_size'");if(isset($_GET["sql"]))$m.=' '.'æ‚¨å¯ä»¥é€šéFTPä¸Šå‚³å¤§å‹SQLæª”ä¸¦å¾ä¼ºæœå™¨å°å…¥ã€‚';}function
select($H,$g=null,$Hf=array(),$z=0){$Be=array();$x=array();$e=array();$Ta=array();$Hi=array();$I=array();for($t=0;(!$z||$t<$z)&&($J=$H->fetch_row());$t++){if(!$t){echo"<div class='scrollable'>\n","<table class='nowrap odds'>\n","<thead><tr>";for($je=0;$je<count($J);$je++){$n=$H->fetch_field();$B=$n->name;$Gf=$n->orgtable;$Ff=$n->orgname;$I[$n->table]=$Gf;if($Hf&&JUSH=="sql")$Be[$je]=($B=="table"?"table=":($B=="possible_keys"?"indexes=":null));elseif($Gf!=""){if(!isset($x[$Gf])){$x[$Gf]=array();foreach(indexes($Gf,$g)as$w){if($w["type"]=="PRIMARY"){$x[$Gf]=array_flip($w["columns"]);break;}}$e[$Gf]=$x[$Gf];}if(isset($e[$Gf][$Ff])){unset($e[$Gf][$Ff]);$x[$Gf][$Ff]=$je;$Be[$je]=$Gf;}}if($n->charsetnr==63)$Ta[$je]=true;$Hi[$je]=$n->type;echo"<th".($Gf!=""||$n->name!=$Ff?" title='".h(($Gf!=""?"$Gf.":"").$Ff)."'":"").">".h($B).($Hf?doc_link(array('sql'=>"explain-output.html#explain_".strtolower($B),'mariadb'=>"explain/#the-columns-in-explain-select",)):"");}echo"</thead>\n";}echo"<tr>";foreach($J
as$y=>$X){$_="";if(isset($Be[$y])&&!$e[$Be[$y]]){if($Hf&&JUSH=="sql"){$Q=$J[array_search("table=",$Be)];$_=ME.$Be[$y].urlencode($Hf[$Q]!=""?$Hf[$Q]:$Q);}else{$_=ME."edit=".urlencode($Be[$y]);foreach($x[$Be[$y]]as$ob=>$je)$_.="&where".urlencode("[".bracket_escape($ob)."]")."=".urlencode($J[$je]);}}elseif(is_url($X))$_=$X;if($X===null)$X="<i>NULL</i>";elseif($Ta[$y]&&!is_utf8($X))$X="<i>".sprintf('%d byte(s)',strlen($X))."</i>";else{$X=h($X);if($Hi[$y]==254)$X="<code>$X</code>";}if($_)$X="<a href='".h($_)."'".(is_url($_)?target_blank():'').">$X</a>";echo"<td>$X";}}echo($t?"</table>\n</div>":"<p class='message'>".'æ²’æœ‰è³‡æ–™è¡Œã€‚')."\n";return$I;}function
referencable_primary($jh){$I=array();foreach(table_status('',true)as$Vh=>$Q){if($Vh!=$jh&&fk_support($Q)){foreach(fields($Vh)as$n){if($n["primary"]){if($I[$Vh]){unset($I[$Vh]);break;}$I[$Vh]=$n;}}}}return$I;}function
adminer_settings(){parse_str($_COOKIE["adminer_settings"],$th);return$th;}function
adminer_setting($y){$th=adminer_settings();return$th[$y];}function
set_adminer_settings($th){return
cookie("adminer_settings",http_build_query($th+adminer_settings()));}function
textarea($B,$Y,$K=10,$tb=80){echo"<textarea name='".h($B)."' rows='$K' cols='$tb' class='sqlarea jush-".JUSH."' spellcheck='false' wrap='off'>";if(is_array($Y)){foreach($Y
as$X)echo
h($X[0])."\n\n\n";}else
echo
h($Y);echo"</textarea>";}function
select_input($Ia,$Cf,$Y="",$wf="",$hg=""){$ci=($Cf?"select":"input");return"<$ci$Ia".($Cf?"><option value=''>$hg".optionlist($Cf,$Y,true)."</select>":" size='10' value='".h($Y)."' placeholder='$hg'>").($wf?script("qsl('$ci').onchange = $wf;",""):"");}function
json_row($y,$X=null){static$fd=true;if($fd)echo"{";if($y!=""){echo($fd?"":",")."\n\t\"".addcslashes($y,"\r\n\t\"\\/").'": '.($X!==null?'"'.addcslashes($X,"\r\n\"\\/").'"':'null');$fd=false;}else{echo"\n}\n";$fd=true;}}function
edit_type($y,$n,$rb,$od=array(),$Xc=array()){global$l;$U=$n["type"];echo'<td><select name="',h($y),'[type]" class="type" aria-labelledby="label-type">';if($U&&!array_key_exists($U,$l->types())&&!isset($od[$U])&&!in_array($U,$Xc))$Xc[]=$U;$Mh=$l->structuredTypes();if($od)$Mh['å¤–ä¾†éµ']=$od;echo
optionlist(array_merge($Xc,$Mh),$U),'</select><td><input
	name="',h($y),'[length]"
	value="',h($n["length"]),'"
	size="3"
	',(!$n["length"]&&preg_match('~var(char|binary)$~',$U)?" class='required'":"");echo'	aria-labelledby="label-length"><td class="options">',($rb?"<select name='".h($y)."[collation]'".(preg_match('~(char|text|enum|set)$~',$U)?"":" class='hidden'").'><option value="">('.'æ ¡å°'.')'.optionlist($rb,$n["collation"]).'</select>':''),($l->unsigned?"<select name='".h($y)."[unsigned]'".(!$U||preg_match(number_type(),$U)?"":" class='hidden'").'><option>'.optionlist($l->unsigned,$n["unsigned"]).'</select>':''),(isset($n['on_update'])?"<select name='".h($y)."[on_update]'".(preg_match('~timestamp|datetime~',$U)?"":" class='hidden'").'>'.optionlist(array(""=>"(".'ON UPDATE'.")","CURRENT_TIMESTAMP"),(preg_match('~^CURRENT_TIMESTAMP~i',$n["on_update"])?"CURRENT_TIMESTAMP":$n["on_update"])).'</select>':''),($od?"<select name='".h($y)."[on_delete]'".(preg_match("~`~",$U)?"":" class='hidden'")."><option value=''>(".'ON DELETE'.")".optionlist(explode("|",$l->onActions),$n["on_delete"])."</select> ":" ");}function
get_partitions_info($Q){global$f;$sd="FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = ".q(DB)." AND TABLE_NAME = ".q($Q);$H=$f->query("SELECT PARTITION_METHOD, PARTITION_EXPRESSION, PARTITION_ORDINAL_POSITION $sd ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");$I=array();list($I["partition_by"],$I["partition"],$I["partitions"])=$H->fetch_row();$bg=get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $sd AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");$I["partition_names"]=array_keys($bg);$I["partition_values"]=array_values($bg);return$I;}function
process_length($ze){global$l;$Fc=$l->enumLength;return(preg_match("~^\\s*\\(?\\s*$Fc(?:\\s*,\\s*$Fc)*+\\s*\\)?\\s*\$~",$ze)&&preg_match_all("~$Fc~",$ze,$Ie)?"(".implode(",",$Ie[0]).")":preg_replace('~^[0-9].*~','(\0)',preg_replace('~[^-0-9,+()[\]]~','',$ze)));}function
process_type($n,$pb="COLLATE"){global$l;return" $n[type]".process_length($n["length"]).(preg_match(number_type(),$n["type"])&&in_array($n["unsigned"],$l->unsigned)?" $n[unsigned]":"").(preg_match('~char|text|enum|set~',$n["type"])&&$n["collation"]?" $pb ".(JUSH=="mssql"?$n["collation"]:q($n["collation"])):"");}function
process_field($n,$Fi){if($n["on_update"])$n["on_update"]=str_ireplace("current_timestamp()","CURRENT_TIMESTAMP",$n["on_update"]);return
array(idf_escape(trim($n["field"])),process_type($Fi),($n["null"]?" NULL":" NOT NULL"),default_value($n),(preg_match('~timestamp|datetime~',$n["type"])&&$n["on_update"]?" ON UPDATE $n[on_update]":""),(support("comment")&&$n["comment"]!=""?" COMMENT ".q($n["comment"]):""),($n["auto_increment"]?auto_increment():null),);}function
default_value($n){global$l;$k=$n["default"];$ud=$n["generated"];return($k===null?"":(in_array($ud,$l->generated)?(JUSH=="mssql"?" AS ($k)".($ud=="VIRTUAL"?"":" $ud")."":" GENERATED ALWAYS AS ($k) $ud"):" DEFAULT ".(!preg_match('~^GENERATED ~i',$k)&&(preg_match('~char|binary|text|enum|set~',$n["type"])||preg_match('~^(?![a-z])~i',$k))?q($k):str_ireplace("current_timestamp()","CURRENT_TIMESTAMP",(JUSH=="sqlite"?"($k)":$k)))));}function
type_class($U){foreach(array('char'=>'text','date'=>'time|year','binary'=>'blob','enum'=>'set',)as$y=>$X){if(preg_match("~$y|$X~",$U))return" class='$y'";}}function
edit_fields($o,$rb,$U="TABLE",$od=array()){global$l;$o=array_values($o);$ac=(($_POST?$_POST["defaults"]:adminer_setting("defaults"))?"":" class='hidden'");$yb=(($_POST?$_POST["comments"]:adminer_setting("comments"))?"":" class='hidden'");echo'<thead><tr>
',($U=="PROCEDURE"?"<td>":""),'<th id="label-name">',($U=="TABLE"?'æ¬„ä½åç¨±':'åƒæ•¸åç¨±'),'<td id="label-type">é¡å‹<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>',script("qs('#enum-edit').onblur = editingLengthBlur;"),'<td id="label-length">é•·åº¦
<td>','é¸é …';if($U=="TABLE"){echo'<td id="label-null">NULL
<td><input type="radio" name="auto_increment_col" value=""><abbr id="label-ai" title="è‡ªå‹•éå¢">AI</abbr>',doc_link(array('sql'=>"example-auto-increment.html",'mariadb'=>"auto_increment/",'sqlite'=>"autoinc.html",'pgsql'=>"datatype-numeric.html#DATATYPE-SERIAL",'mssql'=>"t-sql/statements/create-table-transact-sql-identity-property",)),'<td id="label-default"',$ac,'>é è¨­å€¼
',(support("comment")?"<td id='label-comment'$yb>".'è¨»è§£':"");}echo'<td>',"<input type='image' class='icon' name='add[".(support("move_col")?0:count($o))."]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=5.0.1")."' alt='+' title='".'æ–°å¢ä¸‹ä¸€ç­†'."'>".script("row_count = ".count($o).";"),'</thead>
<tbody>
',script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");foreach($o
as$t=>$n){$t++;$If=$n[($_POST?"orig":"field")];$jc=(isset($_POST["add"][$t-1])||(isset($n["field"])&&!$_POST["drop_col"][$t]))&&(support("drop_col")||$If=="");echo'<tr',($jc?"":" style='display: none;'"),'>
',($U=="PROCEDURE"?"<td>".html_select("fields[$t][inout]",explode("|",$l->inout),$n["inout"]):"")."<th>";if($jc){echo'<input name="fields[',$t,'][field]" value="',h($n["field"]),'" data-maxlength="64" autocapitalize="off" aria-labelledby="label-name">
';}echo'<input type="hidden" name="fields[',$t,'][orig]" value="',h($If),'">';edit_type("fields[$t]",$n,$rb,$od);if($U=="TABLE"){echo'<td>',checkbox("fields[$t][null]",1,$n["null"],"","","block","label-null"),'<td><label class="block"><input type="radio" name="auto_increment_col" value="',$t,'"',($n["auto_increment"]?" checked":""),' aria-labelledby="label-ai"></label><td',$ac,'>',($l->generated?"<select name='fields[$t][generated]'>".optionlist(array_merge(array("","DEFAULT"),$l->generated),$n["generated"])."</select> ":checkbox("fields[$t][generated]",1,$n["generated"],"","","","label-default")),'<input name="fields[',$t,'][default]" value="',h($n["default"]),'" aria-labelledby="label-default">',(support("comment")?"<td$yb><input name='fields[$t][comment]' value='".h($n["comment"])."' data-maxlength='".(min_version(5.5)?1024:255)."' aria-labelledby='label-comment'>":"");}echo"<td>",(support("move_col")?"<input type='image' class='icon' name='add[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=5.0.1")."' alt='+' title='".'æ–°å¢ä¸‹ä¸€ç­†'."'> "."<input type='image' class='icon' name='up[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=up.gif&version=5.0.1")."' alt='â†‘' title='".'ä¸Šç§»'."'> "."<input type='image' class='icon' name='down[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=down.gif&version=5.0.1")."' alt='â†“' title='".'ä¸‹ç§»'."'> ":""),($If==""||support("drop_col")?"<input type='image' class='icon' name='drop_col[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=5.0.1")."' alt='x' title='".'ç§»é™¤'."'>":"");}}function
process_fields(&$o){$C=0;if($_POST["up"]){$te=0;foreach($o
as$y=>$n){if(key($_POST["up"])==$y){unset($o[$y]);array_splice($o,$te,0,array($n));break;}if(isset($n["field"]))$te=$C;$C++;}}elseif($_POST["down"]){$qd=false;foreach($o
as$y=>$n){if(isset($n["field"])&&$qd){unset($o[key($_POST["down"])]);array_splice($o,$C,0,array($qd));break;}if(key($_POST["down"])==$y)$qd=$n;$C++;}}elseif($_POST["add"]){$o=array_values($o);array_splice($o,key($_POST["add"]),0,array(array()));}elseif(!$_POST["drop_col"])return
false;return
true;}function
normalize_enum($A){return"'".str_replace("'","''",addcslashes(stripcslashes(str_replace($A[0][0].$A[0][0],$A[0][0],substr($A[0],1,-1))),'\\'))."'";}function
grant($vd,$ug,$e,$tf){if(!$ug)return
true;if($ug==array("ALL PRIVILEGES","GRANT OPTION"))return($vd=="GRANT"?queries("$vd ALL PRIVILEGES$tf WITH GRANT OPTION"):queries("$vd ALL PRIVILEGES$tf")&&queries("$vd GRANT OPTION$tf"));return
queries("$vd ".preg_replace('~(GRANT OPTION)\([^)]*\)~','\1',implode("$e, ",$ug).$e).$tf);}function
drop_create($nc,$h,$pc,$gi,$rc,$Ce,$Ue,$Se,$Te,$qf,$ef){if($_POST["drop"])query_redirect($nc,$Ce,$Ue);elseif($qf=="")query_redirect($h,$Ce,$Te);elseif($qf!=$ef){$Mb=queries($h);queries_redirect($Ce,$Se,$Mb&&queries($nc));if($Mb)queries($pc);}else
queries_redirect($Ce,$Se,queries($gi)&&queries($rc)&&queries($nc)&&queries($h));}function
create_trigger($tf,$J){$mi=" $J[Timing] $J[Event]".(preg_match('~ OF~',$J["Event"])?" $J[Of]":"");return"CREATE TRIGGER ".idf_escape($J["Trigger"]).(JUSH=="mssql"?$tf.$mi:$mi.$tf).rtrim(" $J[Type]\n$J[Statement]",";").";";}function
create_routine($Wg,$J){global$l;$N=array();$o=(array)$J["fields"];ksort($o);foreach($o
as$n){if($n["field"]!="")$N[]=(preg_match("~^($l->inout)\$~",$n["inout"])?"$n[inout] ":"").idf_escape($n["field"]).process_type($n,"CHARACTER SET");}$bc=rtrim($J["definition"],";");return"CREATE $Wg ".idf_escape(trim($J["name"]))." (".implode(", ",$N).")".($Wg=="FUNCTION"?" RETURNS".process_type($J["returns"],"CHARACTER SET"):"").($J["language"]?" LANGUAGE $J[language]":"").(JUSH=="pgsql"?" AS ".q($bc):"\n$bc;");}function
remove_definer($G){return
preg_replace('~^([A-Z =]+) DEFINER=`'.preg_replace('~@(.*)~','`@`(%|\1)',logged_user()).'`~','\1',$G);}function
format_foreign_key($q){global$l;$j=$q["db"];$if=$q["ns"];return" FOREIGN KEY (".implode(", ",array_map('Adminer\idf_escape',$q["source"])).") REFERENCES ".($j!=""&&$j!=$_GET["db"]?idf_escape($j).".":"").($if!=""&&$if!=$_GET["ns"]?idf_escape($if).".":"").idf_escape($q["table"])." (".implode(", ",array_map('Adminer\idf_escape',$q["target"])).")".(preg_match("~^($l->onActions)\$~",$q["on_delete"])?" ON DELETE $q[on_delete]":"").(preg_match("~^($l->onActions)\$~",$q["on_update"])?" ON UPDATE $q[on_update]":"");}function
tar_file($p,$ri){$I=pack("a100a8a8a8a12a12",$p,644,0,0,decoct($ri->size),decoct(time()));$jb=8*32;for($t=0;$t<strlen($I);$t++)$jb+=ord($I[$t]);$I.=sprintf("%06o",$jb)."\0 ";echo$I,str_repeat("\0",512-strlen($I));$ri->send();echo
str_repeat("\0",511-($ri->size+511)%512);}function
ini_bytes($Xd){$X=ini_get($Xd);switch(strtolower(substr($X,-1))){case'g':$X=(int)$X*1024;case'm':$X=(int)$X*1024;case'k':$X=(int)$X*1024;}return$X;}function
doc_link($dg,$hi="<sup>?</sup>"){global$f;$ph=$f->server_info;$ej=preg_replace('~^(\d\.?\d).*~s','\1',$ph);$Ti=array('sql'=>"https://dev.mysql.com/doc/refman/$ej/en/",'sqlite'=>"https://www.sqlite.org/",'pgsql'=>"https://www.postgresql.org/docs/$ej/",'mssql'=>"https://learn.microsoft.com/en-us/sql/",'oracle'=>"https://www.oracle.com/pls/topic/lookup?ctx=db".preg_replace('~^.* (\d+)\.(\d+)\.\d+\.\d+\.\d+.*~s','\1\2',$ph)."&id=",);if(preg_match('~MariaDB~',$ph)){$Ti['sql']="https://mariadb.com/kb/en/";$dg['sql']=(isset($dg['mariadb'])?$dg['mariadb']:str_replace(".html","/",$dg['sql']));}return($dg[JUSH]?"<a href='".h($Ti[JUSH].$dg[JUSH].(JUSH=='mssql'?"?view=sql-server-ver$ej":""))."'".target_blank().">$hi</a>":"");}function
ob_gzencode($P){return
gzencode($P);}function
db_size($j){global$f;if(!$f->select_db($j))return"?";$I=0;foreach(table_status()as$R)$I+=$R["Data_length"]+$R["Index_length"];return
format_number($I);}function
set_utf8mb4($h){global$f;static$N=false;if(!$N&&preg_match('~\butf8mb4~i',$h)){$N=true;echo"SET NAMES ".charset($f).";\n\n";}}if(isset($_GET["status"]))$_GET["variables"]=$_GET["status"];if(isset($_GET["import"]))$_GET["sql"]=$_GET["import"];if(!(DB!=""?$f->select_db(DB):isset($_GET["sql"])||isset($_GET["dump"])||isset($_GET["database"])||isset($_GET["processlist"])||isset($_GET["privileges"])||isset($_GET["user"])||isset($_GET["variables"])||$_GET["script"]=="connect"||$_GET["script"]=="kill")){if(DB!=""||$_GET["refresh"]){restart_session();set_session("dbs",null);}if(DB!=""){header("HTTP/1.1 404 Not Found");page_header('è³‡æ–™åº«'.": ".h(DB),'ç„¡æ•ˆçš„è³‡æ–™åº«ã€‚',true);}else{if($_POST["db"]&&!$m)queries_redirect(substr(ME,0,-1),'è³‡æ–™åº«å·²åˆªé™¤ã€‚',drop_databases($_POST["db"]));page_header('é¸æ“‡è³‡æ–™åº«',$m,false);echo"<p class='links'>\n";foreach(array('database'=>'å»ºç«‹è³‡æ–™åº«','privileges'=>'æ¬Šé™','processlist'=>'è™•ç†ç¨‹åºåˆ—è¡¨','variables'=>'è®Šæ•¸','status'=>'ç‹€æ…‹',)as$y=>$X){if(support($y))echo"<a href='".h(ME)."$y='>$X</a>\n";}echo"<p>".sprintf('%s ç‰ˆæœ¬ï¼š%s é€é PHP æ“´å……æ¨¡çµ„ %s',$mc[DRIVER],"<b>".h($f->server_info)."</b>","<b>$f->extension</b>")."\n","<p>".sprintf('ç™»éŒ„ç‚ºï¼š %s',"<b>".h(logged_user())."</b>")."\n";$i=$b->databases();if($i){$eh=support("scheme");$rb=collations();echo"<form action='' method='post'>\n","<table class='checkable odds'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),"<thead><tr>".(support("database")?"<td>":"")."<th>".'è³‡æ–™åº«'.(get_session("dbs")!==null?" - <a href='".h(ME)."refresh=1'>".'é‡æ–°è¼‰å…¥'."</a>":"")."<td>".'æ ¡å°'."<td>".'è³‡æ–™è¡¨'."<td>".'å¤§å°'." - <a href='".h(ME)."dbsize=1'>".'è¨ˆç®—'."</a>".script("qsl('a').onclick = partial(ajaxSetHtml, '".js_escape(ME)."script=connect');","")."</thead>\n";$i=($_GET["dbsize"]?count_tables($i):array_flip($i));foreach($i
as$j=>$S){$Vg=h(ME)."db=".urlencode($j);$u=h("Db-".$j);echo"<tr>".(support("database")?"<td>".checkbox("db[]",$j,in_array($j,(array)$_POST["db"]),"","","",$u):""),"<th><a href='$Vg' id='$u'>".h($j)."</a>";$qb=h(db_collation($j,$rb));echo"<td>".(support("database")?"<a href='$Vg".($eh?"&amp;ns=":"")."&amp;database=' title='".'ä¿®æ”¹è³‡æ–™åº«'."'>$qb</a>":$qb),"<td align='right'><a href='$Vg&amp;schema=' id='tables-".h($j)."' title='".'è³‡æ–™åº«çµæ§‹'."'>".($_GET["dbsize"]?$S:"?")."</a>","<td align='right' id='size-".h($j)."'>".($_GET["dbsize"]?db_size($j):"?"),"\n";}echo"</table>\n",(support("database")?"<div class='footer'><div>\n"."<fieldset><legend>".'å·²é¸ä¸­'." <span id='selected'></span></legend><div>\n"."<input type='hidden' name='all' value=''>".script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };")."<input type='submit' name='drop' value='".'åˆªé™¤'."'>".confirm()."\n"."</div></fieldset>\n"."</div></div>\n":""),"<input type='hidden' name='token' value='$T'>\n","</form>\n",script("tableCheck();");}}page_footer("db");exit;}if(support("scheme")){if(DB!=""&&$_GET["ns"]!==""){if(!isset($_GET["ns"]))redirect(preg_replace('~ns=[^&]*&~','',ME)."ns=".get_schema());if(!set_schema($_GET["ns"])){header("HTTP/1.1 404 Not Found");page_header('è³‡æ–™è¡¨çµæ§‹'.": ".h($_GET["ns"]),'ç„¡æ•ˆçš„è³‡æ–™è¡¨çµæ§‹ã€‚',true);page_footer("ns");exit;}}}class
TmpFile{var$handler;var$size;function
__construct(){$this->handler=tmpfile();}function
write($Fb){$this->size+=strlen($Fb);fwrite($this->handler,$Fb);}function
send(){fseek($this->handler,0);fpassthru($this->handler);fclose($this->handler);}}if(isset($_GET["select"])&&($_POST["edit"]||$_POST["clone"])&&!$_POST["save"])$_GET["edit"]=$_GET["select"];if(isset($_GET["callf"]))$_GET["call"]=$_GET["callf"];if(isset($_GET["function"]))$_GET["procedure"]=$_GET["function"];if(isset($_GET["download"])){$a=$_GET["download"];$o=fields($a);header("Content-Type: application/octet-stream");header("Content-Disposition: attachment; filename=".friendly_url("$a-".implode("_",$_GET["where"])).".".friendly_url($_GET["field"]));$L=array(idf_escape($_GET["field"]));$H=$l->select($a,$L,array(where($_GET,$o)),$L);$J=($H?$H->fetch_row():array());echo$l->value($J[0],$o[$_GET["field"]]);exit;}elseif(isset($_GET["table"])){$a=$_GET["table"];$o=fields($a);if(!$o)$m=error();$R=table_status1($a,true);$B=$b->tableName($R);page_header(($o&&is_view($R)?$R['Engine']=='materialized view'?'ç‰©åŒ–è¦–åœ–':'æª¢è¦–è¡¨':'è³‡æ–™è¡¨').": ".($B!=""?$B:h($a)),$m);$Ug=array();foreach($o
as$y=>$n)$Ug+=$n["privileges"];$b->selectLinks($R,(isset($Ug["insert"])||!support("table")?"":null));$xb=$R["Comment"];if($xb!="")echo"<p class='nowrap'>".'è¨»è§£'.": ".h($xb)."\n";if($o)$b->tableStructurePrint($o);if(support("indexes")&&$l->supportsIndex($R)){echo"<h3 id='indexes'>".'ç´¢å¼•'."</h3>\n";$x=indexes($a);if($x)$b->tableIndexesPrint($x);echo'<p class="links"><a href="'.h(ME).'indexes='.urlencode($a).'">'.'ä¿®æ”¹ç´¢å¼•'."</a>\n";}if(!is_view($R)){if(fk_support($R)){echo"<h3 id='foreign-keys'>".'å¤–ä¾†éµ'."</h3>\n";$od=foreign_keys($a);if($od){echo"<table>\n","<thead><tr><th>".'ä¾†æº'."<td>".'ç›®æ¨™'."<td>".'ON DELETE'."<td>".'ON UPDATE'."<td></thead>\n";foreach($od
as$B=>$q){echo"<tr title='".h($B)."'>","<th><i>".implode("</i>, <i>",array_map('Adminer\h',$q["source"]))."</i>","<td><a href='".h($q["db"]!=""?preg_replace('~db=[^&]*~',"db=".urlencode($q["db"]),ME):($q["ns"]!=""?preg_replace('~ns=[^&]*~',"ns=".urlencode($q["ns"]),ME):ME))."table=".urlencode($q["table"])."'>".($q["db"]!=""&&$q["db"]!=DB?"<b>".h($q["db"])."</b>.":"").($q["ns"]!=""&&$q["ns"]!=$_GET["ns"]?"<b>".h($q["ns"])."</b>.":"").h($q["table"])."</a>","(<i>".implode("</i>, <i>",array_map('Adminer\h',$q["target"]))."</i>)","<td>".h($q["on_delete"]),"<td>".h($q["on_update"]),'<td><a href="'.h(ME.'foreign='.urlencode($a).'&name='.urlencode($B)).'">'.'ä¿®æ”¹'.'</a>',"\n";}echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'foreign='.urlencode($a).'">'.'æ–°å¢å¤–ä¾†éµ'."</a>\n";}if(support("check")){echo"<h3 id='checks'>".'Checks'."</h3>\n";$fb=$l->checkConstraints($a);if($fb){echo"<table>\n";foreach($fb
as$y=>$X){echo"<tr title='".h($y)."'>","<td><code class='jush-".JUSH."'>".h($X),"<td><a href='".h(ME.'check='.urlencode($a).'&name='.urlencode($y))."'>".'ä¿®æ”¹'."</a>","\n";}echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'check='.urlencode($a).'">'.'Create check'."</a>\n";}}if(support(is_view($R)?"view_trigger":"trigger")){echo"<h3 id='triggers'>".'è§¸ç™¼å™¨'."</h3>\n";$Ei=triggers($a);if($Ei){echo"<table>\n";foreach($Ei
as$y=>$X)echo"<tr valign='top'><td>".h($X[0])."<td>".h($X[1])."<th>".h($y)."<td><a href='".h(ME.'trigger='.urlencode($a).'&name='.urlencode($y))."'>".'ä¿®æ”¹'."</a>\n";echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'trigger='.urlencode($a).'">'.'å»ºç«‹è§¸ç™¼å™¨'."</a>\n";}}elseif(isset($_GET["schema"])){page_header('è³‡æ–™åº«çµæ§‹',"",array(),h(DB.($_GET["ns"]?".$_GET[ns]":"")));$Xh=array();$Yh=array();$ea=($_GET["schema"]?:$_COOKIE["adminer_schema-".str_replace(".","_",DB)]);preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~',$ea,$Ie,PREG_SET_ORDER);foreach($Ie
as$t=>$A){$Xh[$A[1]]=array($A[2],$A[3]);$Yh[]="\n\t'".js_escape($A[1])."': [ $A[2], $A[3] ]";}$ui=0;$Qa=-1;$ch=array();$Hg=array();$xe=array();foreach(table_status('',true)as$Q=>$R){if(is_view($R))continue;$jg=0;$ch[$Q]["fields"]=array();foreach(fields($Q)as$B=>$n){$jg+=1.25;$n["pos"]=$jg;$ch[$Q]["fields"][$B]=$n;}$ch[$Q]["pos"]=($Xh[$Q]?:array($ui,0));foreach($b->foreignKeys($Q)as$X){if(!$X["db"]){$ve=$Qa;if($Xh[$Q][1]||$Xh[$X["table"]][1])$ve=min(floatval($Xh[$Q][1]),floatval($Xh[$X["table"]][1]))-1;else$Qa-=.1;while($xe[(string)$ve])$ve-=.0001;$ch[$Q]["references"][$X["table"]][(string)$ve]=array($X["source"],$X["target"]);$Hg[$X["table"]][$Q][(string)$ve]=$X["target"];$xe[(string)$ve]=true;}}$ui=max($ui,$ch[$Q]["pos"][0]+2.5+$jg);}echo'<div id="schema" style="height: ',$ui,'em;">
<script',nonce(),'>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {',implode(",",$Yh)."\n",'};
var em = qs(\'#schema\').offsetHeight / ',$ui,';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'',js_escape(DB),'\');
</script>
';foreach($ch
as$B=>$Q){echo"<div class='table' style='top: ".$Q["pos"][0]."em; left: ".$Q["pos"][1]."em;'>",'<a href="'.h(ME).'table='.urlencode($B).'"><b>'.h($B)."</b></a>",script("qsl('div').onmousedown = schemaMousedown;");foreach($Q["fields"]as$n){$X='<span'.type_class($n["type"]).' title="'.h($n["full_type"].($n["null"]?" NULL":'')).'">'.h($n["field"]).'</span>';echo"<br>".($n["primary"]?"<i>$X</i>":$X);}foreach((array)$Q["references"]as$ei=>$Ig){foreach($Ig
as$ve=>$Eg){$we=$ve-$Xh[$B][1];$t=0;foreach($Eg[0]as$Ah)echo"\n<div class='references' title='".h($ei)."' id='refs$ve-".($t++)."' style='left: $we"."em; top: ".$Q["fields"][$Ah]["pos"]."em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: ".(-$we)."em;'></div></div>";}}foreach((array)$Hg[$B]as$ei=>$Ig){foreach($Ig
as$ve=>$e){$we=$ve-$Xh[$B][1];$t=0;foreach($e
as$di)echo"\n<div class='references' title='".h($ei)."' id='refd$ve-".($t++)."' style='left: $we"."em; top: ".$Q["fields"][$di]["pos"]."em; height: 1.25em; background: url(".h(preg_replace("~\\?.*~","",ME)."?file=arrow.gif) no-repeat right center;&version=5.0.1")."'>"."<div style='height: .5em; border-bottom: 1px solid Gray; width: ".(-$we)."em;'></div>"."</div>";}}echo"\n</div>\n";}foreach($ch
as$B=>$Q){foreach((array)$Q["references"]as$ei=>$Ig){foreach($Ig
as$ve=>$Eg){$We=$ui;$Me=-10;foreach($Eg[0]as$y=>$Ah){$kg=$Q["pos"][0]+$Q["fields"][$Ah]["pos"];$lg=$ch[$ei]["pos"][0]+$ch[$ei]["fields"][$Eg[1][$y]]["pos"];$We=min($We,$kg,$lg);$Me=max($Me,$kg,$lg);}echo"<div class='references' id='refl$ve' style='left: $ve"."em; top: $We"."em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: ".($Me-$We)."em;'></div></div>\n";}}}echo'</div>
<p class="links"><a href="',h(ME."schema=".urlencode($ea)),'" id="schema-link">æ°¸ä¹…é€£çµ</a>
';}elseif(isset($_GET["dump"])){$a=$_GET["dump"];if($_POST&&!$m){$Ib="";foreach(array("output","format","db_style","types","routines","events","table_style","auto_increment","triggers","data_style")as$y)$Ib.="&$y=".urlencode($_POST[$y]);cookie("adminer_export",substr($Ib,1));$S=array_flip((array)$_POST["tables"])+array_flip((array)$_POST["data"]);$Tc=dump_headers((count($S)==1?key($S):DB),(DB==""||count($S)>1));$ge=preg_match('~sql~',$_POST["format"]);if($ge){echo"-- Adminer $ia ".$mc[DRIVER]." ".str_replace("\n"," ",$f->server_info)." dump\n\n";if(JUSH=="sql"){echo"SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
".($_POST["data_style"]?"SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
":"")."
";$f->query("SET time_zone = '+00:00'");$f->query("SET sql_mode = ''");}}$Nh=$_POST["db_style"];$i=array(DB);if(DB==""){$i=$_POST["databases"];if(is_string($i))$i=explode("\n",rtrim(str_replace("\r","",$i),"\n"));}foreach((array)$i
as$j){$b->dumpDatabase($j);if($f->select_db($j)){if($ge&&preg_match('~CREATE~',$Nh)&&($h=$f->result("SHOW CREATE DATABASE ".idf_escape($j),1))){set_utf8mb4($h);if($Nh=="DROP+CREATE")echo"DROP DATABASE IF EXISTS ".idf_escape($j).";\n";echo"$h;\n";}if($ge){if($Nh)echo
use_sql($j).";\n\n";$Pf="";if($_POST["types"]){foreach(types()as$u=>$U){$Gc=type_values($u);if($Gc)$Pf.=($Nh!='DROP+CREATE'?"DROP TYPE IF EXISTS ".idf_escape($U).";;\n":"")."CREATE TYPE ".idf_escape($U)." AS ENUM ($Gc);\n\n";else$Pf.="-- Could not export type $U\n\n";}}if($_POST["routines"]){foreach(routines()as$J){$B=$J["ROUTINE_NAME"];$Wg=$J["ROUTINE_TYPE"];$h=create_routine($Wg,array("name"=>$B)+routine($J["SPECIFIC_NAME"],$Wg));set_utf8mb4($h);$Pf.=($Nh!='DROP+CREATE'?"DROP $Wg IF EXISTS ".idf_escape($B).";;\n":"")."$h;\n\n";}}if($_POST["events"]){foreach(get_rows("SHOW EVENTS",null,"-- ")as$J){$h=remove_definer($f->result("SHOW CREATE EVENT ".idf_escape($J["Name"]),3));set_utf8mb4($h);$Pf.=($Nh!='DROP+CREATE'?"DROP EVENT IF EXISTS ".idf_escape($J["Name"]).";;\n":"")."$h;;\n\n";}}echo($Pf&&JUSH=='sql'?"DELIMITER ;;\n\n$Pf"."DELIMITER ;\n\n":$Pf);}if($_POST["table_style"]||$_POST["data_style"]){$gj=array();foreach(table_status('',true)as$B=>$R){$Q=(DB==""||in_array($B,(array)$_POST["tables"]));$Sb=(DB==""||in_array($B,(array)$_POST["data"]));if($Q||$Sb){if($Tc=="tar"){$ri=new
TmpFile;ob_start(array($ri,'write'),1e5);}$b->dumpTable($B,($Q?$_POST["table_style"]:""),(is_view($R)?2:0));if(is_view($R))$gj[]=$B;elseif($Sb){$o=fields($B);$b->dumpData($B,$_POST["data_style"],"SELECT *".convert_fields($o,$o)." FROM ".table($B));}if($ge&&$_POST["triggers"]&&$Q&&($Ei=trigger_sql($B)))echo"\nDELIMITER ;;\n$Ei\nDELIMITER ;\n";if($Tc=="tar"){ob_end_flush();tar_file((DB!=""?"":"$j/")."$B.csv",$ri);}elseif($ge)echo"\n";}}if(function_exists('Adminer\foreign_keys_sql')){foreach(table_status('',true)as$B=>$R){$Q=(DB==""||in_array($B,(array)$_POST["tables"]));if($Q&&!is_view($R))echo
foreign_keys_sql($B);}}foreach($gj
as$fj)$b->dumpTable($fj,$_POST["table_style"],1);if($Tc=="tar")echo
pack("x512");}}}if($ge)echo"-- ".gmdate("Y-m-d H:i:s e")."\n";exit;}page_header('åŒ¯å‡º',$m,($_GET["export"]!=""?array("table"=>$_GET["export"]):array()),h(DB));echo'
<form action="" method="post">
<table class="layout">
';$Xb=array('','USE','DROP+CREATE','CREATE');$Zh=array('','DROP+CREATE','CREATE');$Tb=array('','TRUNCATE+INSERT','INSERT');if(JUSH=="sql")$Tb[]='INSERT+UPDATE';parse_str($_COOKIE["adminer_export"],$J);if(!$J)$J=array("output"=>"text","format"=>"sql","db_style"=>(DB!=""?"":"CREATE"),"table_style"=>"DROP+CREATE","data_style"=>"INSERT");if(!isset($J["events"])){$J["routines"]=$J["events"]=($_GET["dump"]=="");$J["triggers"]=$J["table_style"];}echo"<tr><th>".'è¼¸å‡º'."<td>".html_select("output",$b->dumpOutput(),$J["output"],0)."\n";echo"<tr><th>".'æ ¼å¼'."<td>".html_select("format",$b->dumpFormat(),$J["format"],0)."\n";echo(JUSH=="sqlite"?"":"<tr><th>".'è³‡æ–™åº«'."<td>".html_select('db_style',$Xb,$J["db_style"]).(support("type")?checkbox("types",1,$J["types"],'ä½¿ç”¨è€…é¡å‹'):"").(support("routine")?checkbox("routines",1,$J["routines"],'ç¨‹åº'):"").(support("event")?checkbox("events",1,$J["events"],'äº‹ä»¶'):"")),"<tr><th>".'è³‡æ–™è¡¨'."<td>".html_select('table_style',$Zh,$J["table_style"]).checkbox("auto_increment",1,$J["auto_increment"],'è‡ªå‹•éå¢').(support("trigger")?checkbox("triggers",1,$J["triggers"],'è§¸ç™¼å™¨'):""),"<tr><th>".'è³‡æ–™'."<td>".html_select('data_style',$Tb,$J["data_style"]),'</table>
<p><input type="submit" value="åŒ¯å‡º">
<input type="hidden" name="token" value="',$T,'">

<table>
',script("qsl('table').onclick = dumpClick;");$pg=array();if(DB!=""){$hb=($a!=""?"":" checked");echo"<thead><tr>","<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$hb>".'è³‡æ–™è¡¨'."</label>".script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);",""),"<th style='text-align: right;'><label class='block'>".'è³‡æ–™'."<input type='checkbox' id='check-data'$hb></label>".script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);",""),"</thead>\n";$gj="";$ai=tables_list();foreach($ai
as$B=>$U){$og=preg_replace('~_.*~','',$B);$hb=($a==""||$a==(substr($a,-1)=="%"?"$og%":$B));$rg="<tr><td>".checkbox("tables[]",$B,$hb,$B,"","block");if($U!==null&&!preg_match('~table~i',$U))$gj.="$rg\n";else
echo"$rg<td align='right'><label class='block'><span id='Rows-".h($B)."'></span>".checkbox("data[]",$B,$hb)."</label>\n";$pg[$og]++;}echo$gj;if($ai)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}else{echo"<thead><tr><th style='text-align: left;'>","<label class='block'><input type='checkbox' id='check-databases'".($a==""?" checked":"").">".'è³‡æ–™åº«'."</label>",script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);",""),"</thead>\n";$i=$b->databases();if($i){foreach($i
as$j){if(!information_schema($j)){$og=preg_replace('~_.*~','',$j);echo"<tr><td>".checkbox("databases[]",$j,$a==""||$a=="$og%",$j,"","block")."\n";$pg[$og]++;}}}else
echo"<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";}echo'</table>
</form>
';$fd=true;foreach($pg
as$y=>$X){if($y!=""&&$X>1){echo($fd?"<p>":" ")."<a href='".h(ME)."dump=".urlencode("$y%")."'>".h($y)."</a>";$fd=false;}}}elseif(isset($_GET["privileges"])){page_header('æ¬Šé™');echo'<p class="links"><a href="'.h(ME).'user=">'.'å»ºç«‹ä½¿ç”¨è€…'."</a>";$H=$f->query("SELECT User, Host FROM mysql.".(DB==""?"user":"db WHERE ".q(DB)." LIKE Db")." ORDER BY Host, User");$vd=$H;if(!$H)$H=$f->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");echo"<form action=''><p>\n";hidden_fields_get();echo"<input type='hidden' name='db' value='".h(DB)."'>\n",($vd?"":"<input type='hidden' name='grant' value=''>\n"),"<table class='odds'>\n","<thead><tr><th>".'å¸³è™Ÿ'."<th>".'ä¼ºæœå™¨'."<th></thead>\n";while($J=$H->fetch_assoc())echo'<tr><td>'.h($J["User"])."<td>".h($J["Host"]).'<td><a href="'.h(ME.'user='.urlencode($J["User"]).'&host='.urlencode($J["Host"])).'">'.'ç·¨è¼¯'."</a>\n";if(!$vd||DB!="")echo"<tr><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='".'ç·¨è¼¯'."'>\n";echo"</table>\n","</form>\n";}elseif(isset($_GET["sql"])){if(!$m&&$_POST["export"]){dump_headers("sql");$b->dumpTable("","");$b->dumpData("","table",$_POST["query"]);exit;}restart_session();$Id=&get_session("queries");$Hd=&$Id[DB];if(!$m&&$_POST["clear"]){$Hd=array();redirect(remove_from_uri("history"));}page_header((isset($_GET["import"])?'åŒ¯å…¥':'SQL å‘½ä»¤'),$m);if(!$m&&$_POST){$r=false;if(!isset($_GET["import"]))$G=$_POST["query"];elseif($_POST["webfile"]){$Eh=$b->importServerPath();$r=@fopen((file_exists($Eh)?$Eh:"compress.zlib://$Eh.gz"),"rb");$G=($r?fread($r,1e6):false);}else$G=get_file("sql_file",true);if(is_string($G)){if(function_exists('memory_get_usage')&&($Qe=ini_bytes("memory_limit"))!="-1")@ini_set("memory_limit",max($Qe,2*strlen($G)+memory_get_usage()+8e6));if($G!=""&&strlen($G)<1e6){$yg=$G.(preg_match("~;[ \t\r\n]*\$~",$G)?"":";");if(!$Hd||reset(end($Hd))!=$yg){restart_session();$Hd[]=array($yg,time());set_session("queries",$Id);stop_session();}}$Bh="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$dc=";";$C=0;$Bc=true;$g=connect($b->credentials());if(is_object($g)&&DB!=""){$g->select_db(DB);if($_GET["ns"]!="")set_schema($_GET["ns"],$g);}$wb=0;$Ic=array();$Wf='[\'"'.(JUSH=="sql"?'`#':(JUSH=="sqlite"?'`[':(JUSH=="mssql"?'[':''))).']|/\*|-- |$'.(JUSH=="pgsql"?'|\$[^$]*\$':'');$vi=microtime(true);parse_str($_COOKIE["adminer_export"],$ya);$tc=$b->dumpFormat();unset($tc["sql"]);while($G!=""){if(!$C&&preg_match("~^$Bh*+DELIMITER\\s+(\\S+)~i",$G,$A)){$dc=$A[1];$G=substr($G,strlen($A[0]));}else{preg_match('('.preg_quote($dc)."\\s*|$Wf)",$G,$A,PREG_OFFSET_CAPTURE,$C);list($qd,$jg)=$A[0];if(!$qd&&$r&&!feof($r))$G.=fread($r,1e5);else{if(!$qd&&rtrim($G)=="")break;$C=$jg+strlen($qd);if($qd&&rtrim($qd)!=$dc){$ab=$l->hasCStyleEscapes()||(JUSH=="pgsql"&&($jg>0&&strtolower($G[$jg-1])=="e"));$eg=($qd=='/*'?'\*/':($qd=='['?']':(preg_match('~^-- |^#~',$qd)?"\n":preg_quote($qd).($ab?"|\\\\.":""))));while(preg_match("($eg|\$)s",$G,$A,PREG_OFFSET_CAPTURE,$C)){$ah=$A[0][0];if(!$ah&&$r&&!feof($r))$G.=fread($r,1e5);else{$C=$A[0][1]+strlen($ah);if(!$ah||$ah[0]!="\\")break;}}}else{$Bc=false;$yg=substr($G,0,$jg);$wb++;$rg="<pre id='sql-$wb'><code class='jush-".JUSH."'>".$b->sqlCommandQuery($yg)."</code></pre>\n";if(JUSH=="sqlite"&&preg_match("~^$Bh*+ATTACH\\b~i",$yg,$A)){echo$rg,"<p class='error'>".'ä¸æ”¯æ´ATTACHæŸ¥è©¢ã€‚'."\n";$Ic[]=" <a href='#sql-$wb'>$wb</a>";if($_POST["error_stops"])break;}else{if(!$_POST["only_errors"]){echo$rg;ob_flush();flush();}$Jh=microtime(true);if($f->multi_query($yg)&&is_object($g)&&preg_match("~^$Bh*+USE\\b~i",$yg))$g->query($yg);do{$H=$f->store_result();if($f->error){echo($_POST["only_errors"]?$rg:""),"<p class='error'>".'æŸ¥è©¢ç™¼ç”ŸéŒ¯èª¤'.($f->errno?" ($f->errno)":"").": ".error()."\n";$Ic[]=" <a href='#sql-$wb'>$wb</a>";if($_POST["error_stops"])break
2;}else{$ki=" <span class='time'>(".format_time($Jh).")</span>".(strlen($yg)<1000?" <a href='".h(ME)."sql=".urlencode(trim($yg))."'>".'ç·¨è¼¯'."</a>":"");$_a=$f->affected_rows;$jj=($_POST["only_errors"]?"":$l->warnings());$kj="warnings-$wb";if($jj)$ki.=", <a href='#$kj'>".'è­¦å‘Š'."</a>".script("qsl('a').onclick = partial(toggle, '$kj');","");$Qc=null;$Rc="explain-$wb";if(is_object($H)){$z=$_POST["limit"];$Hf=select($H,$g,array(),$z);if(!$_POST["only_errors"]){echo"<form action='' method='post'>\n";$jf=$H->num_rows;echo"<p>".($jf?($z&&$jf>$z?sprintf('%d / ',$z):"").sprintf('%d è¡Œ',$jf):""),$ki;if($g&&preg_match("~^($Bh|\\()*+SELECT\\b~i",$yg)&&($Qc=explain($g,$yg)))echo", <a href='#$Rc'>Explain</a>".script("qsl('a').onclick = partial(toggle, '$Rc');","");$u="export-$wb";echo", <a href='#$u'>".'åŒ¯å‡º'."</a>".script("qsl('a').onclick = partial(toggle, '$u');","")."<span id='$u' class='hidden'>: ".html_select("output",$b->dumpOutput(),$ya["output"])." ".html_select("format",$tc,$ya["format"])."<input type='hidden' name='query' value='".h($yg)."'>"." <input type='submit' name='export' value='".'åŒ¯å‡º'."'><input type='hidden' name='token' value='$T'></span>\n"."</form>\n";}}else{if(preg_match("~^$Bh*+(CREATE|DROP|ALTER)$Bh++(DATABASE|SCHEMA)\\b~i",$yg)){restart_session();set_session("dbs",null);stop_session();}if(!$_POST["only_errors"])echo"<p class='message' title='".h($f->info)."'>".sprintf('åŸ·è¡ŒæŸ¥è©¢ OKï¼Œ%d è¡Œå—å½±éŸ¿ã€‚',$_a)."$ki\n";}echo($jj?"<div id='$kj' class='hidden'>\n$jj</div>\n":"");if($Qc){echo"<div id='$Rc' class='hidden explain'>\n";select($Qc,$g,$Hf);echo"</div>\n";}}$Jh=microtime(true);}while($f->next_result());}$G=substr($G,$C);$C=0;}}}}if($Bc)echo"<p class='message'>".'æ²’æœ‰å‘½ä»¤å¯åŸ·è¡Œã€‚'."\n";elseif($_POST["only_errors"]){echo"<p class='message'>".sprintf('å·²é †åˆ©åŸ·è¡Œ %d å€‹æŸ¥è©¢ã€‚',$wb-count($Ic))," <span class='time'>(".format_time($vi).")</span>\n";}elseif($Ic&&$wb>1)echo"<p class='error'>".'æŸ¥è©¢ç™¼ç”ŸéŒ¯èª¤'.": ".implode("",$Ic)."\n";}else
echo"<p class='error'>".upload_error($G)."\n";}echo'
<form action="" method="post" enctype="multipart/form-data" id="form">
';$Oc="<input type='submit' value='".'åŸ·è¡Œ'."' title='Ctrl+Enter'>";if(!isset($_GET["import"])){$yg=$_GET["sql"];if($_POST)$yg=$_POST["query"];elseif($_GET["history"]=="all")$yg=$Hd;elseif($_GET["history"]!="")$yg=$Hd[$_GET["history"]][0];echo"<p>";textarea("query",$yg,20);echo
script(($_POST?"":"qs('textarea').focus();\n")."qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '".js_escape(remove_from_uri("sql|limit|error_stops|only_errors|history"))."');"),"<p>$Oc\n",'é™åˆ¶è¡Œæ•¸'.": <input type='number' name='limit' class='size' value='".h($_POST?$_POST["limit"]:$_GET["limit"])."'>\n";}else{echo"<fieldset><legend>".'æª”æ¡ˆä¸Šå‚³'."</legend><div>";$Ad=(extension_loaded("zlib")?"[.gz]":"");echo(ini_bool("file_uploads")?"SQL$Ad (&lt; ".ini_get("upload_max_filesize")."B): <input type='file' name='sql_file[]' multiple>\n$Oc":'æª”æ¡ˆä¸Šå‚³å·²ç¶“è¢«åœç”¨ã€‚'),"</div></fieldset>\n";$Pd=$b->importServerPath();if($Pd){echo"<fieldset><legend>".'å¾ä¼ºæœå™¨'."</legend><div>",sprintf('ç¶²é ä¼ºæœå™¨æª”æ¡ˆ %s',"<code>".h($Pd)."$Ad</code>"),' <input type="submit" name="webfile" value="'.'åŸ·è¡Œæª”æ¡ˆ'.'">',"</div></fieldset>\n";}echo"<p>";}echo
checkbox("error_stops",1,($_POST?$_POST["error_stops"]:isset($_GET["import"])||$_GET["error_stops"]),'å‡ºéŒ¯æ™‚åœæ­¢')."\n",checkbox("only_errors",1,($_POST?$_POST["only_errors"]:isset($_GET["import"])||$_GET["only_errors"]),'åƒ…é¡¯ç¤ºéŒ¯èª¤è¨Šæ¯')."\n","<input type='hidden' name='token' value='$T'>\n";if(!isset($_GET["import"])&&$Hd){print_fieldset("history",'ç´€éŒ„',$_GET["history"]!="");for($X=end($Hd);$X;$X=prev($Hd)){$y=key($Hd);list($yg,$ki,$xc)=$X;echo'<a href="'.h(ME."sql=&history=$y").'">'.'ç·¨è¼¯'."</a>"." <span class='time' title='".@date('Y-m-d',$ki)."'>".@date("H:i:s",$ki)."</span>"." <code class='jush-".JUSH."'>".shorten_utf8(ltrim(str_replace("\n"," ",str_replace("\r","",preg_replace('~^(#|-- ).*~m','',$yg)))),80,"</code>").($xc?" <span class='time'>($xc)</span>":"")."<br>\n";}echo"<input type='submit' name='clear' value='".'æ¸…é™¤'."'>\n","<a href='".h(ME."sql=&history=all")."'>".'ç·¨è¼¯å…¨éƒ¨'."</a>\n","</div></fieldset>\n";}echo'</form>
';}elseif(isset($_GET["edit"])){$a=$_GET["edit"];$o=fields($a);$Z=(isset($_GET["select"])?($_POST["check"]&&count($_POST["check"])==1?where_check($_POST["check"][0],$o):""):where($_GET,$o));$Qi=(isset($_GET["select"])?$_POST["edit"]:$Z);foreach($o
as$B=>$n){if(!isset($n["privileges"][$Qi?"update":"insert"])||$b->fieldName($n)==""||$n["generated"])unset($o[$B]);}if($_POST&&!$m&&!isset($_GET["select"])){$Ce=$_POST["referer"];if($_POST["insert"])$Ce=($Qi?null:$_SERVER["REQUEST_URI"]);elseif(!preg_match('~^.+&select=.+$~',$Ce))$Ce=ME."select=".urlencode($a);$x=indexes($a);$Li=unique_array($_GET["where"],$x);$Ag="\nWHERE $Z";if(isset($_POST["delete"]))queries_redirect($Ce,'è©²é …ç›®å·²è¢«åˆªé™¤',$l->delete($a,$Ag,!$Li));else{$N=array();foreach($o
as$B=>$n){$X=process_input($n);if($X!==false&&$X!==null)$N[idf_escape($B)]=$X;}if($Qi){if(!$N)redirect($Ce);queries_redirect($Ce,'å·²æ›´æ–°é …ç›®ã€‚',$l->update($a,$N,$Ag,!$Li));if(is_ajax()){page_headers();page_messages($m);exit;}}else{$H=$l->insert($a,$N);$ue=($H?last_id():0);queries_redirect($Ce,sprintf('å·²æ–°å¢é …ç›® %sã€‚',($ue?" $ue":"")),$H);}}}$J=null;if($_POST["save"])$J=(array)$_POST["fields"];elseif($Z){$L=array();foreach($o
as$B=>$n){if(isset($n["privileges"]["select"])){$Ga=convert_field($n);if($_POST["clone"]&&$n["auto_increment"])$Ga="''";if(JUSH=="sql"&&preg_match("~enum|set~",$n["type"]))$Ga="1*".idf_escape($B);$L[]=($Ga?"$Ga AS ":"").idf_escape($B);}}$J=array();if(!support("table"))$L=array("*");if($L){$H=$l->select($a,$L,array($Z),$L,array(),(isset($_GET["select"])?2:1));if(!$H)$m=error();else{$J=$H->fetch_assoc();if(!$J)$J=false;}if(isset($_GET["select"])&&(!$J||$H->fetch_assoc()))$J=null;}}if(!support("table")&&!$o){if(!$Z){$H=$l->select($a,array("*"),$Z,array("*"));$J=($H?$H->fetch_assoc():false);if(!$J)$J=array($l->primary=>"");}if($J){foreach($J
as$y=>$X){if(!$Z)$J[$y]=null;$o[$y]=array("field"=>$y,"null"=>($y!=$l->primary),"auto_increment"=>($y==$l->primary));}}}edit_form($a,$o,$J,$Qi);}elseif(isset($_GET["create"])){$a=$_GET["create"];$Yf=array();foreach(array('HASH','LINEAR HASH','KEY','LINEAR KEY','RANGE','LIST')as$y)$Yf[$y]=$y;$Gg=referencable_primary($a);$od=array();foreach($Gg
as$Vh=>$n)$od[str_replace("`","``",$Vh)."`".str_replace("`","``",$n["field"])]=$Vh;$Kf=array();$R=array();if($a!=""){$Kf=fields($a);$R=table_status($a);if(!$R)$m='æ²’æœ‰è³‡æ–™è¡¨ã€‚';}$J=$_POST;$J["fields"]=(array)$J["fields"];if($J["auto_increment_col"])$J["fields"][$J["auto_increment_col"]]["auto_increment"]=true;if($_POST)set_adminer_settings(array("comments"=>$_POST["comments"],"defaults"=>$_POST["defaults"]));if($_POST&&!process_fields($J["fields"])&&!$m){if($_POST["drop"])queries_redirect(substr(ME,0,-1),'å·²ç¶“åˆªé™¤è³‡æ–™è¡¨ã€‚',drop_tables(array($a)));else{$o=array();$Da=array();$Ui=false;$md=array();$Jf=reset($Kf);$Ba=" FIRST";foreach($J["fields"]as$y=>$n){$q=$od[$n["type"]];$Fi=($q!==null?$Gg[$q]:$n);if($n["field"]!=""){if(!$n["generated"])$n["default"]=null;$wg=process_field($n,$Fi);$Da[]=array($n["orig"],$wg,$Ba);if(!$Jf||$wg!==process_field($Jf,$Jf)){$o[]=array($n["orig"],$wg,$Ba);if($n["orig"]!=""||$Ba)$Ui=true;}if($q!==null)$md[idf_escape($n["field"])]=($a!=""&&JUSH!="sqlite"?"ADD":" ").format_foreign_key(array('table'=>$od[$n["type"]],'source'=>array($n["field"]),'target'=>array($Fi["field"]),'on_delete'=>$n["on_delete"],));$Ba=" AFTER ".idf_escape($n["field"]);}elseif($n["orig"]!=""){$Ui=true;$o[]=array($n["orig"]);}if($n["orig"]!=""){$Jf=next($Kf);if(!$Jf)$Ba="";}}$ag="";if(support("partitioning")){if(isset($Yf[$J["partition_by"]])){$Vf=array_filter($J,function($y){return
preg_match('~^partition~',$y);},ARRAY_FILTER_USE_KEY);foreach($Vf["partition_names"]as$y=>$B){if($B==""){unset($Vf["partition_names"][$y]);unset($Vf["partition_values"][$y]);}}if($Vf!=get_partitions_info($a)){$bg=array();if($Vf["partition_by"]=='RANGE'||$Vf["partition_by"]=='LIST'){foreach($Vf["partition_names"]as$y=>$B){$Y=$Vf["partition_values"][$y];$bg[]="\n  PARTITION ".idf_escape($B)." VALUES ".($Vf["partition_by"]=='RANGE'?"LESS THAN":"IN").($Y!=""?" ($Y)":" MAXVALUE");}}$ag.="\nPARTITION BY $Vf[partition_by]($Vf[partition])";if($bg)$ag.=" (".implode(",",$bg)."\n)";elseif($Vf["partitions"])$ag.=" PARTITIONS ".(+$Vf["partitions"]);}}elseif(preg_match("~partitioned~",$R["Create_options"]))$ag.="\nREMOVE PARTITIONING";}$Re='è³‡æ–™è¡¨å·²ä¿®æ”¹ã€‚';if($a==""){cookie("adminer_engine",$J["Engine"]);$Re='è³‡æ–™è¡¨å·²å»ºç«‹ã€‚';}$B=trim($J["name"]);queries_redirect(ME.(support("table")?"table=":"select=").urlencode($B),$Re,alter_table($a,$B,(JUSH=="sqlite"&&($Ui||$md)?$Da:$o),$md,($J["Comment"]!=$R["Comment"]?$J["Comment"]:null),($J["Engine"]&&$J["Engine"]!=$R["Engine"]?$J["Engine"]:""),($J["Collation"]&&$J["Collation"]!=$R["Collation"]?$J["Collation"]:""),($J["Auto_increment"]!=""?number($J["Auto_increment"]):""),$ag));}}page_header(($a!=""?'ä¿®æ”¹è³‡æ–™è¡¨':'å»ºç«‹è³‡æ–™è¡¨'),$m,array("table"=>$a),h($a));if(!$_POST){$Hi=$l->types();$J=array("Engine"=>$_COOKIE["adminer_engine"],"fields"=>array(array("field"=>"","type"=>(isset($Hi["int"])?"int":(isset($Hi["integer"])?"integer":"")),"on_update"=>"")),"partition_names"=>array(""),);if($a!=""){$J=$R;$J["name"]=$a;$J["fields"]=array();if(!$_GET["auto_increment"])$J["Auto_increment"]="";foreach($Kf
as$n){$n["generated"]=$n["generated"]?:(isset($n["default"])?"DEFAULT":"");$J["fields"][]=$n;}if(support("partitioning")){$J+=get_partitions_info($a);$J["partition_names"][]="";$J["partition_values"][]="";}}}$rb=collations();$Dc=engines();foreach($Dc
as$Cc){if(!strcasecmp($Cc,$J["Engine"])){$J["Engine"]=$Cc;break;}}echo'
<form action="" method="post" id="form">
<p>
';if(support("columns")||$a==""){echo'è³‡æ–™è¡¨åç¨±: <input name="name"',($a==""&&!$_POST?" autofocus":""),' data-maxlength="64" value="',h($J["name"]),'" autocapitalize="off">
',($Dc?"<select name='Engine'>".optionlist(array(""=>"(".'å¼•æ“'.")")+$Dc,$J["Engine"])."</select>".on_help("getTarget(event).value",1).script("qsl('select').onchange = helpClose;"):""),' ',($rb&&!preg_match("~sqlite|mssql~",JUSH)?html_select("Collation",array(""=>"(".'æ ¡å°'.")")+$rb,$J["Collation"]):""),' <input type="submit" value="å„²å­˜">
';}echo'
';if(support("columns")){echo'<div class="scrollable">
<table id="edit-fields" class="nowrap">
';edit_fields($J["fields"],$rb,"TABLE",$od);echo'</table>
',script("editFields();"),'</div>
<p>
è‡ªå‹•éå¢: <input type="number" name="Auto_increment" class="size" value="',h($J["Auto_increment"]),'">
',checkbox("defaults",1,($_POST?$_POST["defaults"]:adminer_setting("defaults")),'é è¨­å€¼',"columnShow(this.checked, 5)","jsonly");$zb=($_POST?$_POST["comments"]:adminer_setting("comments"));echo(support("comment")?checkbox("comments",1,$zb,'è¨»è§£',"editingCommentsClick(this, true);","jsonly").' '.(preg_match('~\n~',$J["Comment"])?"<textarea name='Comment' rows='2' cols='20'".($zb?"":" class='hidden'").">".h($J["Comment"])."</textarea>":'<input name="Comment" value="'.h($J["Comment"]).'" data-maxlength="'.(min_version(5.5)?2048:60).'"'.($zb?"":" class='hidden'").'>'):''),'<p>
<input type="submit" value="å„²å­˜">
';}echo'
';if($a!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('åˆªé™¤ %s?',$a));}if(support("partitioning")){$Zf=preg_match('~RANGE|LIST~',$J["partition_by"]);print_fieldset("partition",'åˆ†å€é¡å‹',$J["partition_by"]);echo'<p>
',"<select name='partition_by'>".optionlist(array(""=>"")+$Yf,$J["partition_by"])."</select>".on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')",1).script("qsl('select').onchange = partitionByChange;"),'(<input name="partition" value="',h($J["partition"]),'">)
åˆ†å€: <input type="number" name="partitions" class="size',($Zf||!$J["partition_by"]?" hidden":""),'" value="',h($J["partitions"]),'">
<table id="partition-table"',($Zf?"":" class='hidden'"),'>
<thead><tr><th>åˆ†å€åç¨±<th>å€¼</thead>
';foreach($J["partition_names"]as$y=>$X){echo'<tr>','<td><input name="partition_names[]" value="'.h($X).'" autocapitalize="off">',($y==count($J["partition_names"])-1?script("qsl('input').oninput = partitionNameChange;"):''),'<td><input name="partition_values[]" value="'.h($J["partition_values"][$y]).'">';}echo'</table>
</div></fieldset>
';}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["indexes"])){$a=$_GET["indexes"];$Td=array("PRIMARY","UNIQUE","INDEX");$R=table_status($a,true);if(preg_match('~MyISAM|M?aria'.(min_version(5.6,'10.0.5')?'|InnoDB':'').'~i',$R["Engine"]))$Td[]="FULLTEXT";if(preg_match('~MyISAM|M?aria'.(min_version(5.7,'10.2.2')?'|InnoDB':'').'~i',$R["Engine"]))$Td[]="SPATIAL";$x=indexes($a);$F=array();if(JUSH=="mongo"){$F=$x["_id_"];unset($Td[0]);unset($x["_id_"]);}$J=$_POST;if($J)set_adminer_settings(array("index_options"=>$J["options"]));if($_POST&&!$m&&!$_POST["add"]&&!$_POST["drop_col"]){$c=array();foreach($J["indexes"]as$w){$B=$w["name"];if(in_array($w["type"],$Td)){$e=array();$_e=array();$fc=array();$N=array();ksort($w["columns"]);foreach($w["columns"]as$y=>$d){if($d!=""){$ze=$w["lengths"][$y];$ec=$w["descs"][$y];$N[]=idf_escape($d).($ze?"(".(+$ze).")":"").($ec?" DESC":"");$e[]=$d;$_e[]=($ze?:null);$fc[]=$ec;}}$Pc=$x[$B];if($Pc){ksort($Pc["columns"]);ksort($Pc["lengths"]);ksort($Pc["descs"]);if($w["type"]==$Pc["type"]&&array_values($Pc["columns"])===$e&&(!$Pc["lengths"]||array_values($Pc["lengths"])===$_e)&&array_values($Pc["descs"])===$fc){unset($x[$B]);continue;}}if($e)$c[]=array($w["type"],$B,$N);}}foreach($x
as$B=>$Pc)$c[]=array($Pc["type"],$B,"DROP");if(!$c)redirect(ME."table=".urlencode($a));queries_redirect(ME."table=".urlencode($a),'å·²ä¿®æ”¹ç´¢å¼•ã€‚',alter_indexes($a,$c));}page_header('ç´¢å¼•',$m,array("table"=>$a),h($a));$o=array_keys(fields($a));if($_POST["add"]){foreach($J["indexes"]as$y=>$w){if($w["columns"][count($w["columns"])]!="")$J["indexes"][$y]["columns"][]="";}$w=end($J["indexes"]);if($w["type"]||array_filter($w["columns"],'strlen'))$J["indexes"][]=array("columns"=>array(1=>""));}if(!$J){foreach($x
as$y=>$w){$x[$y]["name"]=$y;$x[$y]["columns"][]="";}$x[]=array("columns"=>array(1=>""));$J["indexes"]=$x;}$_e=(JUSH=="sql"||JUSH=="mssql");$uh=($_POST?$_POST["options"]:adminer_setting("index_options"));echo'
<form action="" method="post">
<div class="scrollable">
<table class="nowrap">
<thead><tr>
<th id="label-type">ç´¢å¼•é¡å‹
<th><input type="submit" class="wayoff">','æ¬„ä½'.($_e?"<span class='idxopts".($uh?"":" hidden")."'> (".'é•·åº¦'.")</span>":"");if($_e||support("descidx"))echo
checkbox("options",1,$uh,'é¸é …',"indexOptionsShow(this.checked)","jsonly")."\n";echo'<th id="label-name">åç¨±
<th><noscript>',"<input type='image' class='icon' name='add[0]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=5.0.1")."' alt='+' title='".'æ–°å¢ä¸‹ä¸€ç­†'."'>",'</noscript>
</thead>
';if($F){echo"<tr><td>PRIMARY<td>";foreach($F["columns"]as$y=>$d){echo
select_input(" disabled",$o,$d),"<label><input disabled type='checkbox'>".'é™å†ª (éæ¸›)'."</label> ";}echo"<td><td>\n";}$je=1;foreach($J["indexes"]as$w){if(!$_POST["drop_col"]||$je!=key($_POST["drop_col"])){echo"<tr><td>".html_select("indexes[$je][type]",array(-1=>"")+$Td,$w["type"],($je==count($J["indexes"])?"indexesAddRow.call(this);":1),"label-type"),"<td>";ksort($w["columns"]);$t=1;foreach($w["columns"]as$y=>$d){echo"<span>".select_input(" name='indexes[$je][columns][$t]' title='".'æ¬„ä½'."'",($o?array_combine($o,$o):$o),$d,"partial(".($t==count($w["columns"])?"indexesAddColumn":"indexesChangeColumn").", '".js_escape(JUSH=="sql"?"":$_GET["indexes"]."_")."')"),"<span class='idxopts".($uh?"":" hidden")."'>",($_e?"<input type='number' name='indexes[$je][lengths][$t]' class='size' value='".h($w["lengths"][$y])."' title='".'é•·åº¦'."'>":""),(support("descidx")?checkbox("indexes[$je][descs][$t]",1,$w["descs"][$y],'é™å†ª (éæ¸›)'):""),"</span> </span>";$t++;}echo"<td><input name='indexes[$je][name]' value='".h($w["name"])."' autocapitalize='off' aria-labelledby='label-name'>\n","<td><input type='image' class='icon' name='drop_col[$je]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=5.0.1")."' alt='x' title='".'ç§»é™¤'."'>".script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");}$je++;}echo'</table>
</div>
<p>
<input type="submit" value="å„²å­˜">
<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["database"])){$J=$_POST;if($_POST&&!$m&&!isset($_POST["add_x"])){$B=trim($J["name"]);if($_POST["drop"]){$_GET["db"]="";queries_redirect(remove_from_uri("db|database"),'è³‡æ–™åº«å·²åˆªé™¤ã€‚',drop_databases(array(DB)));}elseif(DB!==$B){if(DB!=""){$_GET["db"]=$B;queries_redirect(preg_replace('~\bdb=[^&]*&~','',ME)."db=".urlencode($B),'å·²é‡æ–°å‘½åè³‡æ–™åº«ã€‚',rename_database($B,$J["collation"]));}else{$i=explode("\n",str_replace("\r","",$B));$Oh=true;$te="";foreach($i
as$j){if(count($i)==1||$j!=""){if(!create_database($j,$J["collation"]))$Oh=false;$te=$j;}}restart_session();set_session("dbs",null);queries_redirect(ME."db=".urlencode($te),'å·²å»ºç«‹è³‡æ–™åº«ã€‚',$Oh);}}else{if(!$J["collation"])redirect(substr(ME,0,-1));query_redirect("ALTER DATABASE ".idf_escape($B).(preg_match('~^[a-z0-9_]+$~i',$J["collation"])?" COLLATE $J[collation]":""),substr(ME,0,-1),'å·²ä¿®æ”¹è³‡æ–™åº«ã€‚');}}page_header(DB!=""?'ä¿®æ”¹è³‡æ–™åº«':'å»ºç«‹è³‡æ–™åº«',$m,array(),h(DB));$rb=collations();$B=DB;if($_POST)$B=$J["name"];elseif(DB!="")$J["collation"]=db_collation(DB,$rb);elseif(JUSH=="sql"){foreach(get_vals("SHOW GRANTS")as$vd){if(preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~',$vd,$A)&&$A[1]){$B=stripcslashes(idf_unescape("`$A[2]`"));break;}}}echo'
<form action="" method="post">
<p>
',($_POST["add_x"]||strpos($B,"\n")?'<textarea autofocus name="name" rows="10" cols="40">'.h($B).'</textarea><br>':'<input name="name" autofocus value="'.h($B).'" data-maxlength="64" autocapitalize="off">')."\n".($rb?html_select("collation",array(""=>"(".'æ ¡å°'.")")+$rb,$J["collation"]).doc_link(array('sql'=>"charset-charsets.html",'mariadb'=>"supported-character-sets-and-collations/",'mssql'=>"relational-databases/system-functions/sys-fn-helpcollations-transact-sql",)):""),'<input type="submit" value="å„²å­˜">
';if(DB!="")echo"<input type='submit' name='drop' value='".'åˆªé™¤'."'>".confirm(sprintf('åˆªé™¤ %s?',DB))."\n";elseif(!$_POST["add_x"]&&$_GET["db"]=="")echo"<input type='image' class='icon' name='add' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=5.0.1")."' alt='+' title='".'æ–°å¢ä¸‹ä¸€ç­†'."'>\n";echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["scheme"])){$J=$_POST;if($_POST&&!$m){$_=preg_replace('~ns=[^&]*&~','',ME)."ns=";if($_POST["drop"])query_redirect("DROP SCHEMA ".idf_escape($_GET["ns"]),$_,'å·²åˆªé™¤è³‡æ–™è¡¨çµæ§‹ã€‚');else{$B=trim($J["name"]);$_.=urlencode($B);if($_GET["ns"]=="")query_redirect("CREATE SCHEMA ".idf_escape($B),$_,'å·²å»ºç«‹è³‡æ–™è¡¨çµæ§‹ã€‚');elseif($_GET["ns"]!=$B)query_redirect("ALTER SCHEMA ".idf_escape($_GET["ns"])." RENAME TO ".idf_escape($B),$_,'å·²ä¿®æ”¹è³‡æ–™è¡¨çµæ§‹ã€‚');else
redirect($_);}}page_header($_GET["ns"]!=""?'ä¿®æ”¹è³‡æ–™è¡¨çµæ§‹':'å»ºç«‹è³‡æ–™è¡¨çµæ§‹',$m);if(!$J)$J["name"]=$_GET["ns"];echo'
<form action="" method="post">
<p><input name="name" autofocus value="',h($J["name"]),'" autocapitalize="off">
<input type="submit" value="å„²å­˜">
';if($_GET["ns"]!="")echo"<input type='submit' name='drop' value='".'åˆªé™¤'."'>".confirm(sprintf('åˆªé™¤ %s?',$_GET["ns"]))."\n";echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["call"])){$da=($_GET["name"]?:$_GET["call"]);page_header('å‘¼å«'.": ".h($da),$m);$Wg=routine($_GET["call"],(isset($_GET["callf"])?"FUNCTION":"PROCEDURE"));$Qd=array();$Pf=array();foreach($Wg["fields"]as$t=>$n){if(substr($n["inout"],-3)=="OUT")$Pf[$t]="@".idf_escape($n["field"])." AS ".idf_escape($n["field"]);if(!$n["inout"]||substr($n["inout"],0,2)=="IN")$Qd[]=$t;}if(!$m&&$_POST){$bb=array();foreach($Wg["fields"]as$y=>$n){if(in_array($y,$Qd)){$X=process_input($n);if($X===false)$X="''";if(isset($Pf[$y]))$f->query("SET @".idf_escape($n["field"])." = $X");}$bb[]=(isset($Pf[$y])?"@".idf_escape($n["field"]):$X);}$G=(isset($_GET["callf"])?"SELECT":"CALL")." ".table($da)."(".implode(", ",$bb).")";$Jh=microtime(true);$H=$f->multi_query($G);$_a=$f->affected_rows;echo$b->selectQuery($G,$Jh,!$H);if(!$H)echo"<p class='error'>".error()."\n";else{$g=connect($b->credentials());if(is_object($g))$g->select_db(DB);do{$H=$f->store_result();if(is_object($H))select($H,$g);else
echo"<p class='message'>".sprintf('ç¨‹åºå·²è¢«åŸ·è¡Œï¼Œ%d è¡Œè¢«å½±éŸ¿',$_a)." <span class='time'>".@date("H:i:s")."</span>\n";}while($f->next_result());if($Pf)select($f->query("SELECT ".implode(", ",$Pf)));}}echo'
<form action="" method="post">
';if($Qd){echo"<table class='layout'>\n";foreach($Qd
as$y){$n=$Wg["fields"][$y];$B=$n["field"];echo"<tr><th>".$b->fieldName($n);$Y=$_POST["fields"][$B];if($Y!=""){if($n["type"]=="enum")$Y=+$Y;if($n["type"]=="set")$Y=array_sum($Y);}input($n,$Y,(string)$_POST["function"][$B]);echo"\n";}echo"</table>\n";}echo'<p>
<input type="submit" value="å‘¼å«">
<input type="hidden" name="token" value="',$T,'">
</form>

<pre>
';function
pre_tr($ah){return
preg_replace('~^~m','<tr>',preg_replace('~\|~','<td>',preg_replace('~\|$~m',"",rtrim($ah))));}$Q='(\+--[-+]+\+\n)';$J='(\| .* \|\n)';echo
preg_replace_callback("~^$Q?$J$Q?($J*)$Q?~m",function($A){$gd=pre_tr($A[2]);return"<table>\n".($A[1]?"<thead>$gd</thead>\n":$gd).pre_tr($A[4])."\n</table>";},preg_replace('~(\n(    -|mysql)&gt; )(.+)~',"\\1<code class='jush-sql'>\\3</code>",preg_replace('~(.+)\n---+\n~',"<b>\\1</b>\n",h($Wg['comment']))));echo'</pre>
';}elseif(isset($_GET["foreign"])){$a=$_GET["foreign"];$B=$_GET["name"];$J=$_POST;if($_POST&&!$m&&!$_POST["add"]&&!$_POST["change"]&&!$_POST["change-js"]){if(!$_POST["drop"]){$J["source"]=array_filter($J["source"],'strlen');ksort($J["source"]);$di=array();foreach($J["source"]as$y=>$X)$di[$y]=$J["target"][$y];$J["target"]=$di;}if(JUSH=="sqlite")$H=recreate_table($a,$a,array(),array(),array(" $B"=>($J["drop"]?"":" ".format_foreign_key($J))));else{$c="ALTER TABLE ".table($a);$H=($B==""||queries("$c DROP ".(JUSH=="sql"?"FOREIGN KEY ":"CONSTRAINT ").idf_escape($B)));if(!$J["drop"])$H=queries("$c ADD".format_foreign_key($J));}queries_redirect(ME."table=".urlencode($a),($J["drop"]?'å·²åˆªé™¤å¤–ä¾†éµã€‚':($B!=""?'å·²ä¿®æ”¹å¤–ä¾†éµã€‚':'å·²å»ºç«‹å¤–ä¾†éµã€‚')),$H);if(!$J["drop"])$m="$m<br>".'ä¾†æºåˆ—å’Œç›®æ¨™åˆ—å¿…é ˆå…·æœ‰ç›¸åŒçš„è³‡æ–™é¡å‹ï¼Œåœ¨ç›®æ¨™åˆ—ä¸Šå¿…é ˆæœ‰ä¸€å€‹ç´¢å¼•ä¸¦ä¸”å¼•ç”¨çš„è³‡æ–™å¿…é ˆå­˜åœ¨ã€‚';}page_header('å¤–ä¾†éµ',$m,array("table"=>$a),h($a));if($_POST){ksort($J["source"]);if($_POST["add"])$J["source"][]="";elseif($_POST["change"]||$_POST["change-js"])$J["target"]=array();}elseif($B!=""){$od=foreign_keys($a);$J=$od[$B];$J["source"][]="";}else{$J["table"]=$a;$J["source"]=array("");}echo'
<form action="" method="post">
';$Ah=array_keys(fields($a));if($J["db"]!="")$f->select_db($J["db"]);if($J["ns"]!=""){$Lf=get_schema();set_schema($J["ns"]);}$Fg=array_keys(array_filter(table_status('',true),'Adminer\fk_support'));$di=array_keys(fields(in_array($J["table"],$Fg)?$J["table"]:reset($Fg)));$wf="this.form['change-js'].value = '1'; this.form.submit();";echo"<p>".'ç›®æ¨™è³‡æ–™è¡¨'.": ".html_select("table",$Fg,$J["table"],$wf)."\n";if(support("scheme")){$dh=array_filter($b->schemas(),function($ch){return!preg_match('~^information_schema$~i',$ch);});echo'è³‡æ–™è¡¨çµæ§‹'.": ".html_select("ns",$dh,$J["ns"]!=""?$J["ns"]:$_GET["ns"],$wf);if($J["ns"]!="")set_schema($Lf);}elseif(JUSH!="sqlite"){$Yb=array();foreach($b->databases()as$j){if(!information_schema($j))$Yb[]=$j;}echo'è³‡æ–™åº«'.": ".html_select("db",$Yb,$J["db"]!=""?$J["db"]:$_GET["db"],$wf);}echo'<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="è®Šæ›´"></noscript>
<table>
<thead><tr><th id="label-source">ä¾†æº<th id="label-target">ç›®æ¨™</thead>
';$je=0;foreach($J["source"]as$y=>$X){echo"<tr>","<td>".html_select("source[".(+$y)."]",array(-1=>"")+$Ah,$X,($je==count($J["source"])-1?"foreignAddRow.call(this);":1),"label-source"),"<td>".html_select("target[".(+$y)."]",$di,$J["target"][$y],1,"label-target");$je++;}echo'</table>
<p>
ON DELETE: ',html_select("on_delete",array(-1=>"")+explode("|",$l->onActions),$J["on_delete"]),' ON UPDATE: ',html_select("on_update",array(-1=>"")+explode("|",$l->onActions),$J["on_update"]),doc_link(array('sql'=>"innodb-foreign-key-constraints.html",'mariadb'=>"foreign-keys/",'pgsql'=>"sql-createtable.html#SQL-CREATETABLE-REFERENCES",'mssql'=>"t-sql/statements/create-table-transact-sql",'oracle'=>"SQLRF01111",)),'<p>
<input type="submit" value="å„²å­˜">
<noscript><p><input type="submit" name="add" value="æ–°å¢æ¬„ä½"></noscript>
';if($B!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('åˆªé™¤ %s?',$B));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["view"])){$a=$_GET["view"];$J=$_POST;$Mf="VIEW";if(JUSH=="pgsql"&&$a!=""){$O=table_status($a);$Mf=strtoupper($O["Engine"]);}if($_POST&&!$m){$B=trim($J["name"]);$Ga=" AS\n$J[select]";$Ce=ME."table=".urlencode($B);$Re='å·²ä¿®æ”¹æª¢è¦–è¡¨ã€‚';$U=($_POST["materialized"]?"MATERIALIZED VIEW":"VIEW");if(!$_POST["drop"]&&$a==$B&&JUSH!="sqlite"&&$U=="VIEW"&&$Mf=="VIEW")query_redirect((JUSH=="mssql"?"ALTER":"CREATE OR REPLACE")." VIEW ".table($B).$Ga,$Ce,$Re);else{$fi=$B."_adminer_".uniqid();drop_create("DROP $Mf ".table($a),"CREATE $U ".table($B).$Ga,"DROP $U ".table($B),"CREATE $U ".table($fi).$Ga,"DROP $U ".table($fi),($_POST["drop"]?substr(ME,0,-1):$Ce),'å·²åˆªé™¤æª¢è¦–è¡¨ã€‚',$Re,'å·²å»ºç«‹æª¢è¦–è¡¨ã€‚',$a,$B);}}if(!$_POST&&$a!=""){$J=view($a);$J["name"]=$a;$J["materialized"]=($Mf!="VIEW");if(!$m)$m=error();}page_header(($a!=""?'ä¿®æ”¹æª¢è¦–è¡¨':'å»ºç«‹æª¢è¦–è¡¨'),$m,array("table"=>$a),h($a));echo'
<form action="" method="post">
<p>åç¨±: <input name="name" value="',h($J["name"]),'" data-maxlength="64" autocapitalize="off">
',(support("materializedview")?" ".checkbox("materialized",1,$J["materialized"],'ç‰©åŒ–è¦–åœ–'):""),'<p>';textarea("select",$J["select"]);echo'<p>
<input type="submit" value="å„²å­˜">
';if($a!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('åˆªé™¤ %s?',$a));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["event"])){$aa=$_GET["event"];$be=array("YEAR","QUARTER","MONTH","DAY","HOUR","MINUTE","WEEK","SECOND","YEAR_MONTH","DAY_HOUR","DAY_MINUTE","DAY_SECOND","HOUR_MINUTE","HOUR_SECOND","MINUTE_SECOND");$Kh=array("ENABLED"=>"ENABLE","DISABLED"=>"DISABLE","SLAVESIDE_DISABLED"=>"DISABLE ON SLAVE");$J=$_POST;if($_POST&&!$m){if($_POST["drop"])query_redirect("DROP EVENT ".idf_escape($aa),substr(ME,0,-1),'å·²åˆªé™¤äº‹ä»¶ã€‚');elseif(in_array($J["INTERVAL_FIELD"],$be)&&isset($Kh[$J["STATUS"]])){$bh="\nON SCHEDULE ".($J["INTERVAL_VALUE"]?"EVERY ".q($J["INTERVAL_VALUE"])." $J[INTERVAL_FIELD]".($J["STARTS"]?" STARTS ".q($J["STARTS"]):"").($J["ENDS"]?" ENDS ".q($J["ENDS"]):""):"AT ".q($J["STARTS"]))." ON COMPLETION".($J["ON_COMPLETION"]?"":" NOT")." PRESERVE";queries_redirect(substr(ME,0,-1),($aa!=""?'å·²ä¿®æ”¹äº‹ä»¶ã€‚':'å·²å»ºç«‹äº‹ä»¶ã€‚'),queries(($aa!=""?"ALTER EVENT ".idf_escape($aa).$bh.($aa!=$J["EVENT_NAME"]?"\nRENAME TO ".idf_escape($J["EVENT_NAME"]):""):"CREATE EVENT ".idf_escape($J["EVENT_NAME"]).$bh)."\n".$Kh[$J["STATUS"]]." COMMENT ".q($J["EVENT_COMMENT"]).rtrim(" DO\n$J[EVENT_DEFINITION]",";").";"));}}page_header(($aa!=""?'ä¿®æ”¹äº‹ä»¶'.": ".h($aa):'å»ºç«‹äº‹ä»¶'),$m);if(!$J&&$aa!=""){$K=get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = ".q(DB)." AND EVENT_NAME = ".q($aa));$J=reset($K);}echo'
<form action="" method="post">
<table class="layout">
<tr><th>åç¨±<td><input name="EVENT_NAME" value="',h($J["EVENT_NAME"]),'" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">é–‹å§‹<td><input name="STARTS" value="',h("$J[EXECUTE_AT]$J[STARTS]"),'">
<tr><th title="datetime">çµæŸ<td><input name="ENDS" value="',h($J["ENDS"]),'">
<tr><th>æ¯<td><input type="number" name="INTERVAL_VALUE" value="',h($J["INTERVAL_VALUE"]),'" class="size"> ',html_select("INTERVAL_FIELD",$be,$J["INTERVAL_FIELD"]),'<tr><th>ç‹€æ…‹<td>',html_select("STATUS",$Kh,$J["STATUS"]),'<tr><th>è¨»è§£<td><input name="EVENT_COMMENT" value="',h($J["EVENT_COMMENT"]),'" data-maxlength="64">
<tr><th><td>',checkbox("ON_COMPLETION","PRESERVE",$J["ON_COMPLETION"]=="PRESERVE",'åœ¨å®Œæˆå¾Œå„²å­˜'),'</table>
<p>';textarea("EVENT_DEFINITION",$J["EVENT_DEFINITION"]);echo'<p>
<input type="submit" value="å„²å­˜">
';if($aa!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('åˆªé™¤ %s?',$aa));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["procedure"])){$da=($_GET["name"]?:$_GET["procedure"]);$Wg=(isset($_GET["function"])?"FUNCTION":"PROCEDURE");$J=$_POST;$J["fields"]=(array)$J["fields"];if($_POST&&!process_fields($J["fields"])&&!$m){$If=routine($_GET["procedure"],$Wg);$fi="$J[name]_adminer_".uniqid();drop_create("DROP $Wg ".routine_id($da,$If),create_routine($Wg,$J),"DROP $Wg ".routine_id($J["name"],$J),create_routine($Wg,array("name"=>$fi)+$J),"DROP $Wg ".routine_id($fi,$J),substr(ME,0,-1),'å·²åˆªé™¤ç¨‹åºã€‚','å·²ä¿®æ”¹å­ç¨‹åºã€‚','å·²å»ºç«‹å­ç¨‹åºã€‚',$da,$J["name"]);}page_header(($da!=""?(isset($_GET["function"])?'ä¿®æ”¹å‡½å¼':'ä¿®æ”¹é å­˜ç¨‹åº').": ".h($da):(isset($_GET["function"])?'å»ºç«‹å‡½å¼':'å»ºç«‹é å­˜ç¨‹åº')),$m);if(!$_POST&&$da!=""){$J=routine($_GET["procedure"],$Wg);$J["name"]=$da;}$rb=get_vals("SHOW CHARACTER SET");sort($rb);$Xg=routine_languages();echo'
<form action="" method="post" id="form">
<p>åç¨±: <input name="name" value="',h($J["name"]),'" data-maxlength="64" autocapitalize="off">
',($Xg?'èªè¨€'.": ".html_select("language",$Xg,$J["language"])."\n":""),'<input type="submit" value="å„²å­˜">
<div class="scrollable">
<table class="nowrap">
';edit_fields($J["fields"],$rb,$Wg);if(isset($_GET["function"])){echo"<tr><td>".'å›å‚³é¡å‹';edit_type("returns",$J["returns"],$rb,array(),(JUSH=="pgsql"?array("void","trigger"):array()));}echo'</table>
',script("editFields();"),'</div>
<p>';textarea("definition",$J["definition"]);echo'<p>
<input type="submit" value="å„²å­˜">
';if($da!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('åˆªé™¤ %s?',$da));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["sequence"])){$fa=$_GET["sequence"];$J=$_POST;if($_POST&&!$m){$_=substr(ME,0,-1);$B=trim($J["name"]);if($_POST["drop"])query_redirect("DROP SEQUENCE ".idf_escape($fa),$_,'å·²åˆªé™¤åºåˆ—ã€‚');elseif($fa=="")query_redirect("CREATE SEQUENCE ".idf_escape($B),$_,'å·²å»ºç«‹åºåˆ—ã€‚');elseif($fa!=$B)query_redirect("ALTER SEQUENCE ".idf_escape($fa)." RENAME TO ".idf_escape($B),$_,'å·²ä¿®æ”¹åºåˆ—ã€‚');else
redirect($_);}page_header($fa!=""?'ä¿®æ”¹åºåˆ—'.": ".h($fa):'å»ºç«‹åºåˆ—',$m);if(!$J)$J["name"]=$fa;echo'
<form action="" method="post">
<p><input name="name" value="',h($J["name"]),'" autocapitalize="off">
<input type="submit" value="å„²å­˜">
';if($fa!="")echo"<input type='submit' name='drop' value='".'åˆªé™¤'."'>".confirm(sprintf('åˆªé™¤ %s?',$fa))."\n";echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["type"])){$ga=$_GET["type"];$J=$_POST;if($_POST&&!$m){$_=substr(ME,0,-1);if($_POST["drop"])query_redirect("DROP TYPE ".idf_escape($ga),$_,'å·²åˆªé™¤é¡å‹ã€‚');else
query_redirect("CREATE TYPE ".idf_escape(trim($J["name"]))." $J[as]",$_,'å·²å»ºç«‹é¡å‹ã€‚');}page_header($ga!=""?'ä¿®æ”¹é¡å‹'.": ".h($ga):'å»ºç«‹é¡å‹',$m);if(!$J)$J["as"]="AS ";echo'
<form action="" method="post">
<p>
';if($ga!=""){$Hi=$l->types();$Gc=type_values($Hi[$ga]);if($Gc)echo"<code class='jush-".JUSH."'>ENUM (".h($Gc).")</code>\n<p>";echo"<input type='submit' name='drop' value='".'åˆªé™¤'."'>".confirm(sprintf('åˆªé™¤ %s?',$ga))."\n";}else{echo'åç¨±'.": <input name='name' value='".h($J['name'])."' autocapitalize='off'>\n",doc_link(array('pgsql'=>"datatype-enum.html",),"?");textarea("as",$J["as"]);echo"<p><input type='submit' value='".'å„²å­˜'."'>\n";}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["check"])){$a=$_GET["check"];$B=$_GET["name"];$J=$_POST;if($J&&!$m){if(JUSH=="sqlite")$H=recreate_table($a,$a,array(),array(),array(),0,array(),$B,($J["drop"]?"":$J["clause"]));else{$H=($B==""||queries("ALTER TABLE ".table($a)." DROP CONSTRAINT ".idf_escape($B)));if(!$J["drop"])$H=queries("ALTER TABLE ".table($a)." ADD".($J["name"]!=""?" CONSTRAINT ".idf_escape($J["name"]):"")." CHECK ($J[clause])");}queries_redirect(ME."table=".urlencode($a),($J["drop"]?'Check has been dropped.':($B!=""?'Check has been altered.':'Check has been created.')),$H);}page_header(($B!=""?'Alter check'.": ".h($B):'Create check'),$m,array("table"=>$a));if(!$J){$ib=$l->checkConstraints($a);$J=array("name"=>$B,"clause"=>$ib[$B]);}echo'
<form action="" method="post">
<p>';if(JUSH!="sqlite")echo'åç¨±'.': <input name="name" value="'.h($J["name"]).'" data-maxlength="64" autocapitalize="off"> ';echo
doc_link(array('sql'=>"create-table-check-constraints.html",'mariadb'=>"constraint/",'pgsql'=>"ddl-constraints.html#DDL-CONSTRAINTS-CHECK-CONSTRAINTS",'mssql'=>"relational-databases/tables/create-check-constraints",'sqlite'=>"lang_createtable.html#check_constraints",),"?"),'<p>';textarea("clause",$J["clause"]);echo'<p><input type="submit" value="å„²å­˜">
';if($B!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('åˆªé™¤ %s?',$B));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["trigger"])){$a=$_GET["trigger"];$B=$_GET["name"];$Di=trigger_options();$J=(array)trigger($B,$a)+array("Trigger"=>$a."_bi");if($_POST){if(!$m&&in_array($_POST["Timing"],$Di["Timing"])&&in_array($_POST["Event"],$Di["Event"])&&in_array($_POST["Type"],$Di["Type"])){$tf=" ON ".table($a);$nc="DROP TRIGGER ".idf_escape($B).(JUSH=="pgsql"?$tf:"");$Ce=ME."table=".urlencode($a);if($_POST["drop"])query_redirect($nc,$Ce,'å·²åˆªé™¤è§¸ç™¼å™¨ã€‚');else{if($B!="")queries($nc);queries_redirect($Ce,($B!=""?'å·²ä¿®æ”¹è§¸ç™¼å™¨ã€‚':'å·²å»ºç«‹è§¸ç™¼å™¨ã€‚'),queries(create_trigger($tf,$_POST)));if($B!="")queries(create_trigger($tf,$J+array("Type"=>reset($Di["Type"]))));}}$J=$_POST;}page_header(($B!=""?'ä¿®æ”¹è§¸ç™¼å™¨'.": ".h($B):'å»ºç«‹è§¸ç™¼å™¨'),$m,array("table"=>$a));echo'
<form action="" method="post" id="form">
<table class="layout">
<tr><th>æ™‚é–“<td>',html_select("Timing",$Di["Timing"],$J["Timing"],"triggerChange(/^".preg_quote($a,"/")."_[ba][iud]$/, '".js_escape($a)."', this.form);"),'<tr><th>äº‹ä»¶<td>',html_select("Event",$Di["Event"],$J["Event"],"this.form['Timing'].onchange();"),(in_array("UPDATE OF",$Di["Event"])?" <input name='Of' value='".h($J["Of"])."' class='hidden'>":""),'<tr><th>é¡å‹<td>',html_select("Type",$Di["Type"],$J["Type"]),'</table>
<p>åç¨±: <input name="Trigger" value="',h($J["Trigger"]),'" data-maxlength="64" autocapitalize="off">
',script("qs('#form')['Timing'].onchange();"),'<p>';textarea("Statement",$J["Statement"]);echo'<p>
<input type="submit" value="å„²å­˜">
';if($B!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('åˆªé™¤ %s?',$B));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["user"])){$ha=$_GET["user"];$ug=array(""=>array("All privileges"=>""));foreach(get_rows("SHOW PRIVILEGES")as$J){foreach(explode(",",($J["Privilege"]=="Grant option"?"":$J["Context"]))as$Gb)$ug[$Gb][$J["Privilege"]]=$J["Comment"];}$ug["Server Admin"]+=$ug["File access on server"];$ug["Databases"]["Create routine"]=$ug["Procedures"]["Create routine"];unset($ug["Procedures"]["Create routine"]);$ug["Columns"]=array();foreach(array("Select","Insert","Update","References")as$X)$ug["Columns"][$X]=$ug["Tables"][$X];unset($ug["Server Admin"]["Usage"]);foreach($ug["Tables"]as$y=>$X)unset($ug["Databases"][$y]);$df=array();if($_POST){foreach($_POST["objects"]as$y=>$X)$df[$X]=(array)$df[$X]+(array)$_POST["grants"][$y];}$wd=array();$rf="";if(isset($_GET["host"])&&($H=$f->query("SHOW GRANTS FOR ".q($ha)."@".q($_GET["host"])))){while($J=$H->fetch_row()){if(preg_match('~GRANT (.*) ON (.*) TO ~',$J[0],$A)&&preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~',$A[1],$Ie,PREG_SET_ORDER)){foreach($Ie
as$X){if($X[1]!="USAGE")$wd["$A[2]$X[2]"][$X[1]]=true;if(preg_match('~ WITH GRANT OPTION~',$J[0]))$wd["$A[2]$X[2]"]["GRANT OPTION"]=true;}}if(preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~",$J[0],$A))$rf=$A[1];}}if($_POST&&!$m){$sf=(isset($_GET["host"])?q($ha)."@".q($_GET["host"]):"''");if($_POST["drop"])query_redirect("DROP USER $sf",ME."privileges=",'å·²åˆªé™¤ä½¿ç”¨è€…ã€‚');else{$ff=q($_POST["user"])."@".q($_POST["host"]);$cg=$_POST["pass"];if($cg!=''&&!$_POST["hashed"]&&!min_version(8)){$cg=$f->result("SELECT PASSWORD(".q($cg).")");$m=!$cg;}$Mb=false;if(!$m){if($sf!=$ff){$Mb=queries((min_version(5)?"CREATE USER":"GRANT USAGE ON *.* TO")." $ff IDENTIFIED BY ".(min_version(8)?"":"PASSWORD ").q($cg));$m=!$Mb;}elseif($cg!=$rf)queries("SET PASSWORD FOR $ff = ".q($cg));}if(!$m){$Tg=array();foreach($df
as$lf=>$vd){if(isset($_GET["grant"]))$vd=array_filter($vd);$vd=array_keys($vd);if(isset($_GET["grant"]))$Tg=array_diff(array_keys(array_filter($df[$lf],'strlen')),$vd);elseif($sf==$ff){$pf=array_keys((array)$wd[$lf]);$Tg=array_diff($pf,$vd);$vd=array_diff($vd,$pf);unset($wd[$lf]);}if(preg_match('~^(.+)\s*(\(.*\))?$~U',$lf,$A)&&(!grant("REVOKE",$Tg,$A[2]," ON $A[1] FROM $ff")||!grant("GRANT",$vd,$A[2]," ON $A[1] TO $ff"))){$m=true;break;}}}if(!$m&&isset($_GET["host"])){if($sf!=$ff)queries("DROP USER $sf");elseif(!isset($_GET["grant"])){foreach($wd
as$lf=>$Tg){if(preg_match('~^(.+)(\(.*\))?$~U',$lf,$A))grant("REVOKE",array_keys($Tg),$A[2]," ON $A[1] FROM $ff");}}}queries_redirect(ME."privileges=",(isset($_GET["host"])?'å·²ä¿®æ”¹ä½¿ç”¨è€…ã€‚':'å·²å»ºç«‹ä½¿ç”¨è€…ã€‚'),!$m);if($Mb)$f->query("DROP USER $ff");}}page_header((isset($_GET["host"])?'å¸³è™Ÿ'.": ".h("$ha@$_GET[host]"):'å»ºç«‹ä½¿ç”¨è€…'),$m,array("privileges"=>array('','æ¬Šé™')));if($_POST){$J=$_POST;$wd=$df;}else{$J=$_GET+array("host"=>$f->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)"));$J["pass"]=$rf;if($rf!="")$J["hashed"]=true;$wd[(DB==""||$wd?"":idf_escape(addcslashes(DB,"%_\\"))).".*"]=array();}echo'<form action="" method="post">
<table class="layout">
<tr><th>ä¼ºæœå™¨<td><input name="host" data-maxlength="60" value="',h($J["host"]),'" autocapitalize="off">
<tr><th>å¸³è™Ÿ<td><input name="user" data-maxlength="80" value="',h($J["user"]),'" autocapitalize="off">
<tr><th>å¯†ç¢¼<td><input name="pass" id="pass" value="',h($J["pass"]),'" autocomplete="new-password">
',($J["hashed"]?"":script("typePassword(qs('#pass'));")),(min_version(8)?"":checkbox("hashed",1,$J["hashed"],'Hashed',"typePassword(this.form['pass'], this.checked);")),'</table>

';echo"<table class='odds'>\n","<thead><tr><th colspan='2'>".'æ¬Šé™'.doc_link(array('sql'=>"grant.html#priv_level"));$t=0;foreach($wd
as$lf=>$vd){echo'<th>'.($lf!="*.*"?"<input name='objects[$t]' value='".h($lf)."' size='10' autocapitalize='off'>":"<input type='hidden' name='objects[$t]' value='*.*' size='10'>*.*");$t++;}echo"</thead>\n";foreach(array(""=>"","Server Admin"=>'ä¼ºæœå™¨',"Databases"=>'è³‡æ–™åº«',"Tables"=>'è³‡æ–™è¡¨',"Columns"=>'æ¬„ä½',"Procedures"=>'ç¨‹åº',)as$Gb=>$ec){foreach((array)$ug[$Gb]as$tg=>$xb){echo"<tr><td".($ec?">$ec<td":" colspan='2'").' lang="en" title="'.h($xb).'">'.h($tg);$t=0;foreach($wd
as$lf=>$vd){$B="'grants[$t][".h(strtoupper($tg))."]'";$Y=$vd[strtoupper($tg)];if($Gb=="Server Admin"&&$lf!=(isset($wd["*.*"])?"*.*":".*"))echo"<td>";elseif(isset($_GET["grant"]))echo"<td><select name=$B><option><option value='1'".($Y?" selected":"").">".'æˆæ¬Š'."<option value='0'".($Y=="0"?" selected":"").">".'å»¢é™¤'."</select>";else{echo"<td align='center'><label class='block'>","<input type='checkbox' name=$B value='1'".($Y?" checked":"").($tg=="All privileges"?" id='grants-$t-all'>":">".($tg=="Grant option"?"":script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$t-all'); };"))),"</label>";}$t++;}}}echo"</table>\n",'<p>
<input type="submit" value="å„²å­˜">
';if(isset($_GET["host"])){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('åˆªé™¤ %s?',"$ha@$_GET[host]"));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["processlist"])){if(support("kill")){if($_POST&&!$m){$pe=0;foreach((array)$_POST["kill"]as$X){if(kill_process($X))$pe++;}queries_redirect(ME."processlist=",sprintf('%d å€‹ Process(es) è¢«çµ‚æ­¢',$pe),$pe||!$_POST["kill"]);}}page_header('è™•ç†ç¨‹åºåˆ—è¡¨',$m);echo'
<form action="" method="post">
<div class="scrollable">
<table class="nowrap checkable odds">
',script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");$t=-1;foreach(process_list()as$t=>$J){if(!$t){echo"<thead><tr lang='en'>".(support("kill")?"<th>":"");foreach($J
as$y=>$X)echo"<th>$y".doc_link(array('sql'=>"show-processlist.html#processlist_".strtolower($y),'pgsql'=>"monitoring-stats.html#PG-STAT-ACTIVITY-VIEW",'oracle'=>"REFRN30223",));echo"</thead>\n";}echo"<tr>".(support("kill")?"<td>".checkbox("kill[]",$J[JUSH=="sql"?"Id":"pid"],0):"");foreach($J
as$y=>$X)echo"<td>".((JUSH=="sql"&&$y=="Info"&&preg_match("~Query|Killed~",$J["Command"])&&$X!="")||(JUSH=="pgsql"&&$y=="current_query"&&$X!="<IDLE>")||(JUSH=="oracle"&&$y=="sql_text"&&$X!="")?"<code class='jush-".JUSH."'>".shorten_utf8($X,100,"</code>").' <a href="'.h(ME.($J["db"]!=""?"db=".urlencode($J["db"])."&":"")."sql=".urlencode($X)).'">'.'è¤‡è£½'.'</a>':h($X));echo"\n";}echo'</table>
</div>
<p>
';if(support("kill")){echo($t+1)."/".sprintf('ç¸½å…± %d å€‹',max_connections()),"<p><input type='submit' value='".'çµ‚æ­¢'."'>\n";}echo'<input type="hidden" name="token" value="',$T,'">
</form>
',script("tableCheck();");}elseif(isset($_GET["select"])){$a=$_GET["select"];$R=table_status1($a);$x=indexes($a);$o=fields($a);$od=column_foreign_keys($a);$nf=$R["Oid"];parse_str($_COOKIE["adminer_import"],$za);$Ug=array();$e=array();$ji=null;foreach($o
as$y=>$n){$B=$b->fieldName($n);if(isset($n["privileges"]["select"])&&$B!=""){$e[$y]=html_entity_decode(strip_tags($B),ENT_QUOTES);if(is_shortable($n))$ji=$b->selectLengthProcess();}$Ug+=$n["privileges"];}list($L,$xd)=$b->selectColumnsProcess($e,$x);$L=array_unique($L);$xd=array_unique($xd);$fe=count($xd)<count($L);$Z=$b->selectSearchProcess($o,$x);$Ef=$b->selectOrderProcess($o,$x);$z=$b->selectLimitProcess();if($_GET["val"]&&is_ajax()){header("Content-Type: text/plain; charset=utf-8");foreach($_GET["val"]as$Mi=>$J){$Ga=convert_field($o[key($J)]);$L=array($Ga?:idf_escape(key($J)));$Z[]=where_check($Mi,$o);$I=$l->select($a,$L,$Z,$L);if($I)echo
reset($I->fetch_row());}exit;}$F=$Oi=null;foreach($x
as$w){if($w["type"]=="PRIMARY"){$F=array_flip($w["columns"]);$Oi=($L?$F:array());foreach($Oi
as$y=>$X){if(in_array(idf_escape($y),$L))unset($Oi[$y]);}break;}}if($nf&&!$F){$F=$Oi=array($nf=>0);$x[]=array("type"=>"PRIMARY","columns"=>array($nf));}if($_POST&&!$m){$pj=$Z;if(!$_POST["all"]&&is_array($_POST["check"])){$ib=array();foreach($_POST["check"]as$eb)$ib[]=where_check($eb,$o);$pj[]="((".implode(") OR (",$ib)."))";}$pj=($pj?"\nWHERE ".implode(" AND ",$pj):"");if($_POST["export"]){cookie("adminer_import","output=".urlencode($_POST["output"])."&format=".urlencode($_POST["format"]));dump_headers($a);$b->dumpTable($a,"");$sd=($L?implode(", ",$L):"*").convert_fields($e,$o,$L)."\nFROM ".table($a);$zd=($xd&&$fe?"\nGROUP BY ".implode(", ",$xd):"").($Ef?"\nORDER BY ".implode(", ",$Ef):"");if(!is_array($_POST["check"])||$F)$G="SELECT $sd$pj$zd";else{$Ki=array();foreach($_POST["check"]as$X)$Ki[]="(SELECT".limit($sd,"\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$o).$zd,1).")";$G=implode(" UNION ALL ",$Ki);}$b->dumpData($a,"table",$G);exit;}if(!$b->selectEmailProcess($Z,$od)){if($_POST["save"]||$_POST["delete"]){$H=true;$_a=0;$N=array();if(!$_POST["delete"]){foreach($_POST["fields"]as$B=>$X){$X=process_input($o[$B]);if($X!==null&&($_POST["clone"]||$X!==false))$N[idf_escape($B)]=($X!==false?$X:idf_escape($B));}}if($_POST["delete"]||$N){if($_POST["clone"])$G="INTO ".table($a)." (".implode(", ",array_keys($N)).")\nSELECT ".implode(", ",$N)."\nFROM ".table($a);if($_POST["all"]||($F&&is_array($_POST["check"]))||$fe){$H=($_POST["delete"]?$l->delete($a,$pj):($_POST["clone"]?queries("INSERT $G$pj"):$l->update($a,$N,$pj)));$_a=$f->affected_rows;}else{foreach((array)$_POST["check"]as$X){$lj="\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$o);$H=($_POST["delete"]?$l->delete($a,$lj,1):($_POST["clone"]?queries("INSERT".limit1($a,$G,$lj)):$l->update($a,$N,$lj,1)));if(!$H)break;$_a+=$f->affected_rows;}}}$Re=sprintf('%d å€‹é …ç›®å—åˆ°å½±éŸ¿ã€‚',$_a);if($_POST["clone"]&&$H&&$_a==1){$ue=last_id();if($ue)$Re=sprintf('å·²æ–°å¢é …ç›® %sã€‚'," $ue");}queries_redirect(remove_from_uri($_POST["all"]&&$_POST["delete"]?"page":""),$Re,$H);if(!$_POST["delete"]){$ng=(array)$_POST["fields"];edit_form($a,array_intersect_key($o,$ng),$ng,!$_POST["clone"]);page_footer();exit;}}elseif(!$_POST["import"]){if(!$_POST["val"])$m='æŒ‰ä½Ctrlä¸¦æŒ‰ä¸€ä¸‹æŸå€‹å€¼é€²è¡Œä¿®æ”¹ã€‚';else{$H=true;$_a=0;foreach($_POST["val"]as$Mi=>$J){$N=array();foreach($J
as$y=>$X){$y=bracket_escape($y,1);$N[idf_escape($y)]=(preg_match('~char|text~',$o[$y]["type"])||$X!=""?$b->processInput($o[$y],$X):"NULL");}$H=$l->update($a,$N," WHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($Mi,$o),!$fe&&!$F," ");if(!$H)break;$_a+=$f->affected_rows;}queries_redirect(remove_from_uri(),sprintf('%d å€‹é …ç›®å—åˆ°å½±éŸ¿ã€‚',$_a),$H);}}elseif(!is_string($dd=get_file("csv_file",true)))$m=upload_error($dd);elseif(!preg_match('~~u',$dd))$m='æª”å¿…é ˆä½¿ç”¨UTF-8ç·¨ç¢¼ã€‚';else{cookie("adminer_import","output=".urlencode($za["output"])."&format=".urlencode($_POST["separator"]));$H=true;$tb=array_keys($o);preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~',$dd,$Ie);$_a=count($Ie[0]);$l->begin();$lh=($_POST["separator"]=="csv"?",":($_POST["separator"]=="tsv"?"\t":";"));$K=array();foreach($Ie[0]as$y=>$X){preg_match_all("~((?>\"[^\"]*\")+|[^$lh]*)$lh~",$X.$lh,$Je);if(!$y&&!array_diff($Je[1],$tb)){$tb=$Je[1];$_a--;}else{$N=array();foreach($Je[1]as$t=>$ob)$N[idf_escape($tb[$t])]=($ob==""&&$o[$tb[$t]]["null"]?"NULL":q(preg_match('~^".*"$~s',$ob)?str_replace('""','"',substr($ob,1,-1)):$ob));$K[]=$N;}}$H=(!$K||$l->insertUpdate($a,$K,$F));if($H)$l->commit();queries_redirect(remove_from_uri("page"),sprintf('å·²åŒ¯å…¥ %d è¡Œã€‚',$_a),$H);$l->rollback();}}}$Vh=$b->tableName($R);if(is_ajax()){page_headers();ob_start();}else
page_header('é¸æ“‡'.": $Vh",$m);$N=null;if(isset($Ug["insert"])||!support("table")){$Vf=array();foreach((array)$_GET["where"]as$X){if(isset($od[$X["col"]])&&count($od[$X["col"]])==1&&($X["op"]=="="||(!$X["op"]&&(is_array($X["val"])||!preg_match('~[_%]~',$X["val"])))))$Vf["set"."[".bracket_escape($X["col"])."]"]=$X["val"];}$N=$Vf?"&".http_build_query($Vf):"";}$b->selectLinks($R,$N);if(!$e&&support("table"))echo"<p class='error'>".'ç„¡æ³•é¸æ“‡è©²è³‡æ–™è¡¨'.($o?".":": ".error())."\n";else{echo"<form action='' id='form'>\n","<div style='display: none;'>";hidden_fields_get();echo(DB!=""?'<input type="hidden" name="db" value="'.h(DB).'">'.(isset($_GET["ns"])?'<input type="hidden" name="ns" value="'.h($_GET["ns"]).'">':""):"");echo'<input type="hidden" name="select" value="'.h($a).'">',"</div>\n";$b->selectColumnsPrint($L,$e);$b->selectSearchPrint($Z,$e,$x);$b->selectOrderPrint($Ef,$e,$x);$b->selectLimitPrint($z);$b->selectLengthPrint($ji);$b->selectActionPrint($x);echo"</form>\n";$D=$_GET["page"];if($D=="last"){$rd=$f->result(count_rows($a,$Z,$fe,$xd));$D=floor(max(0,$rd-1)/$z);}$gh=$L;$yd=$xd;if(!$gh){$gh[]="*";$Hb=convert_fields($e,$o,$L);if($Hb)$gh[]=substr($Hb,2);}foreach($L
as$y=>$X){$n=$o[idf_unescape($X)];if($n&&($Ga=convert_field($n)))$gh[$y]="$Ga AS $X";}if(!$fe&&$Oi){foreach($Oi
as$y=>$X){$gh[]=idf_escape($y);if($yd)$yd[]=idf_escape($y);}}$H=$l->select($a,$gh,$Z,$yd,$Ef,$z,$D,true);if(!$H)echo"<p class='error'>".error()."\n";else{if(JUSH=="mssql"&&$D)$H->seek($z*$D);$Ac=array();echo"<form action='' method='post' enctype='multipart/form-data'>\n";$K=array();while($J=$H->fetch_assoc()){if($D&&JUSH=="oracle")unset($J["RNUM"]);$K[]=$J;}if($_GET["page"]!="last"&&$z!=""&&$xd&&$fe&&JUSH=="sql")$rd=$f->result(" SELECT FOUND_ROWS()");if(!$K)echo"<p class='message'>".'æ²’æœ‰è³‡æ–™è¡Œã€‚'."\n";else{$Pa=$b->backwardKeys($a,$Vh);echo"<div class='scrollable'>","<table id='table' class='nowrap checkable odds'>",script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"),"<thead><tr>".(!$xd&&$L?"":"<td><input type='checkbox' id='all-page' class='jsonly'>".script("qs('#all-page').onclick = partial(formCheck, /check/);","")." <a href='".h($_GET["modify"]?remove_from_uri("modify"):$_SERVER["REQUEST_URI"]."&modify=1")."'>".'ä¿®æ”¹'."</a>");$bf=array();$td=array();reset($L);$Cg=1;foreach($K[0]as$y=>$X){if(!isset($Oi[$y])){$X=$_GET["columns"][key($L)];$n=$o[$L?($X?$X["col"]:current($L)):$y];$B=($n?$b->fieldName($n,$Cg):($X["fun"]?"*":h($y)));if($B!=""){$Cg++;$bf[$y]=$B;$d=idf_escape($y);$Kd=remove_from_uri('(order|desc)[^=]*|page').'&order%5B0%5D='.urlencode($y);$ec="&desc%5B0%5D=1";echo"<th id='th[".h(bracket_escape($y))."]'>".script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});",""),'<a href="'.h($Kd.($Ef[0]==$d||$Ef[0]==$y||(!$Ef&&$fe&&$xd[0]==$d)?$ec:'')).'">';echo
apply_sql_function($X["fun"],$B)."</a>";echo"<span class='column hidden'>","<a href='".h($Kd.$ec)."' title='".'é™å†ª (éæ¸›)'."' class='text'> â†“</a>";if(!$X["fun"]){echo'<a href="#fieldset-search" title="'.'æœå°‹'.'" class="text jsonly"> =</a>',script("qsl('a').onclick = partial(selectSearch, '".js_escape($y)."');");}echo"</span>";}$td[$y]=$X["fun"];next($L);}}$_e=array();if($_GET["modify"]){foreach($K
as$J){foreach($J
as$y=>$X)$_e[$y]=max($_e[$y],min(40,strlen(utf8_decode($X))));}}echo($Pa?"<th>".'é—œè¯':"")."</thead>\n";if(is_ajax())ob_end_clean();foreach($b->rowDescriptions($K,$od)as$af=>$J){$Li=unique_array($K[$af],$x);if(!$Li){$Li=array();foreach($K[$af]as$y=>$X){if(!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~',$y))$Li[$y]=$X;}}$Mi="";foreach($Li
as$y=>$X){if((JUSH=="sql"||JUSH=="pgsql")&&preg_match('~char|text|enum|set~',$o[$y]["type"])&&strlen($X)>64){$y=(strpos($y,'(')?$y:idf_escape($y));$y="MD5(".(JUSH!='sql'||preg_match("~^utf8~",$o[$y]["collation"])?$y:"CONVERT($y USING ".charset($f).")").")";$X=md5($X);}$Mi.="&".($X!==null?urlencode("where[".bracket_escape($y)."]")."=".urlencode($X===false?"f":$X):"null%5B%5D=".urlencode($y));}echo"<tr>".(!$xd&&$L?"":"<td>".checkbox("check[]",substr($Mi,1),in_array(substr($Mi,1),(array)$_POST["check"])).($fe||information_schema(DB)?"":" <a href='".h(ME."edit=".urlencode($a).$Mi)."' class='edit'>".'ç·¨è¼¯'."</a>"));foreach($J
as$y=>$X){if(isset($bf[$y])){$n=$o[$y];$X=$l->value($X,$n);if($X!=""&&(!isset($Ac[$y])||$Ac[$y]!=""))$Ac[$y]=(is_mail($X)?$bf[$y]:"");$_="";if(preg_match('~blob|bytea|raw|file~',$n["type"])&&$X!="")$_=ME.'download='.urlencode($a).'&field='.urlencode($y).$Mi;if(!$_&&$X!==null){foreach((array)$od[$y]as$q){if(count($od[$y])==1||end($q["source"])==$y){$_="";foreach($q["source"]as$t=>$Ah)$_.=where_link($t,$q["target"][$t],$K[$af][$Ah]);$_=($q["db"]!=""?preg_replace('~([?&]db=)[^&]+~','\1'.urlencode($q["db"]),ME):ME).'select='.urlencode($q["table"]).$_;if($q["ns"])$_=preg_replace('~([?&]ns=)[^&]+~','\1'.urlencode($q["ns"]),$_);if(count($q["source"])==1)break;}}}if($y=="COUNT(*)"){$_=ME."select=".urlencode($a);$t=0;foreach((array)$_GET["where"]as$W){if(!array_key_exists($W["col"],$Li))$_.=where_link($t++,$W["col"],$W["val"],$W["op"]);}foreach($Li
as$le=>$W)$_.=where_link($t++,$le,$W);}$X=select_value($X,$_,$n,$ji);$u=h("val[$Mi][".bracket_escape($y)."]");$Y=$_POST["val"][$Mi][bracket_escape($y)];$wc=!is_array($J[$y])&&is_utf8($X)&&$K[$af][$y]==$J[$y]&&!$td[$y]&&!$n["generated"];$hi=preg_match('~text|lob~',$n["type"]);echo"<td id='$u'";if(($_GET["modify"]&&$wc)||$Y!==null){$Bd=h($Y!==null?$Y:$J[$y]);echo">".($hi?"<textarea name='$u' cols='30' rows='".(substr_count($J[$y],"\n")+1)."'>$Bd</textarea>":"<input name='$u' value='$Bd' size='$_e[$y]'>");}else{$Ee=strpos($X,"<i>â€¦</i>");echo" data-text='".($Ee?2:($hi?1:0))."'".($wc?"":" data-warning='".h('ä½¿ç”¨ç·¨è¼¯é€£çµä¾†ä¿®æ”¹ã€‚')."'").">$X";}}}if($Pa)echo"<td>";$b->backwardKeysPrint($Pa,$K[$af]);echo"</tr>\n";}if(is_ajax())exit;echo"</table>\n","</div>\n";}if(!is_ajax()){if($K||$D){$Nc=true;if($_GET["page"]!="last"){if($z==""||(count($K)<$z&&($K||!$D)))$rd=($D?$D*$z:0)+count($K);elseif(JUSH!="sql"||!$fe){$rd=($fe?false:found_rows($R,$Z));if($rd<max(1e4,2*($D+1)*$z))$rd=reset(slow_query(count_rows($a,$Z,$fe,$xd)));else$Nc=false;}}$Tf=($z!=""&&($rd===false||$rd>$z||$D));if($Tf){echo(($rd===false?count($K)+1:$rd-$D*$z)>$z?'<p><a href="'.h(remove_from_uri("page")."&page=".($D+1)).'" class="loadmore">'.'è¼‰å…¥æ›´å¤šè³‡æ–™'.'</a>'.script("qsl('a').onclick = partial(selectLoadMore, ".(+$z).", '".'è¼‰å…¥ä¸­'."â€¦');",""):''),"\n";}}echo"<div class='footer'><div>\n";if($K||$D){if($Tf){$Le=($rd===false?$D+(count($K)>=$z?2:1):floor(($rd-1)/$z));echo"<fieldset>";if(JUSH!="simpledb"){echo"<legend><a href='".h(remove_from_uri("page"))."'>".'é '."</a></legend>",script("qsl('a').onclick = function () { pageClick(this.href, +prompt('".'é '."', '".($D+1)."')); return false; };"),pagination(0,$D).($D>5?" â€¦":"");for($t=max(1,$D-4);$t<min($Le,$D+5);$t++)echo
pagination($t,$D);if($Le>0){echo($D+5<$Le?" â€¦":""),($Nc&&$rd!==false?pagination($Le,$D):" <a href='".h(remove_from_uri("page")."&page=last")."' title='~$Le'>".'æœ€å¾Œä¸€é '."</a>");}}else{echo"<legend>".'é '."</legend>",pagination(0,$D).($D>1?" â€¦":""),($D?pagination($D,$D):""),($Le>$D?pagination($D+1,$D).($Le>$D+1?" â€¦":""):"");}echo"</fieldset>\n";}echo"<fieldset>","<legend>".'æ‰€æœ‰çµæœ'."</legend>";$kc=($Nc?"":"~ ").$rd;$xf="var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$kc' : checked); selectCount('selected2', this.checked || !checked ? '$kc' : checked);";echo
checkbox("all",1,0,($rd!==false?($Nc?"":"~ ").sprintf('%d è¡Œ',$rd):""),$xf)."\n","</fieldset>\n";if($b->selectCommandPrint()){echo'<fieldset',($_GET["modify"]?'':' class="jsonly"'),'><legend>ä¿®æ”¹</legend><div>
<input type="submit" value="å„²å­˜"',($_GET["modify"]?'':' title="'.'æŒ‰ä½Ctrlä¸¦æŒ‰ä¸€ä¸‹æŸå€‹å€¼é€²è¡Œä¿®æ”¹ã€‚'.'"'),'>
</div></fieldset>
<fieldset><legend>å·²é¸ä¸­ <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="ç·¨è¼¯">
<input type="submit" name="clone" value="è¤‡è£½">
<input type="submit" name="delete" value="åˆªé™¤">',confirm(),'</div></fieldset>
';}$pd=$b->dumpFormat();foreach((array)$_GET["columns"]as$d){if($d["fun"]){unset($pd['sql']);break;}}if($pd){print_fieldset("export",'åŒ¯å‡º'." <span id='selected2'></span>");$Qf=$b->dumpOutput();echo($Qf?html_select("output",$Qf,$za["output"])." ":""),html_select("format",$pd,$za["format"])," <input type='submit' name='export' value='".'åŒ¯å‡º'."'>\n","</div></fieldset>\n";}$b->selectEmailPrint(array_filter($Ac,'strlen'),$e);}echo"</div></div>\n";if($b->selectImportPrint()){echo"<div>","<a href='#import'>".'åŒ¯å…¥'."</a>",script("qsl('a').onclick = partial(toggle, 'import');",""),"<span id='import'".($_POST["import"]?"":" class='hidden'").">: ","<input type='file' name='csv_file'> ",html_select("separator",array("csv"=>"CSV,","csv;"=>"CSV;","tsv"=>"TSV"),$za["format"],1);echo" <input type='submit' name='import' value='".'åŒ¯å…¥'."'>","</span>","</div>";}echo"<input type='hidden' name='token' value='$T'>\n","</form>\n",(!$xd&&$L?"":script("tableCheck();"));}}}if(is_ajax()){ob_end_clean();exit;}}elseif(isset($_GET["variables"])){$O=isset($_GET["status"]);page_header($O?'ç‹€æ…‹':'è®Šæ•¸');$cj=($O?show_status():show_variables());if(!$cj)echo"<p class='message'>".'æ²’æœ‰è³‡æ–™è¡Œã€‚'."\n";else{echo"<table>\n";foreach($cj
as$y=>$X){echo"<tr>","<th><code class='jush-".JUSH.($O?"status":"set")."'>".h($y)."</code>","<td>".nl_br(h($X));}echo"</table>\n";}}elseif(isset($_GET["script"])){header("Content-Type: text/javascript; charset=utf-8");if($_GET["script"]=="db"){$Rh=array("Data_length"=>0,"Index_length"=>0,"Data_free"=>0);foreach(table_status()as$B=>$R){json_row("Comment-$B",h($R["Comment"]));if(!is_view($R)){foreach(array("Engine","Collation")as$y)json_row("$y-$B",h($R[$y]));foreach($Rh+array("Auto_increment"=>0,"Rows"=>0)as$y=>$X){if($R[$y]!=""){$X=format_number($R[$y]);if($X>=0)json_row("$y-$B",($y=="Rows"&&$X&&$R["Engine"]==(JUSH=="pgsql"?"table":"InnoDB")?"~ $X":$X));if(isset($Rh[$y]))$Rh[$y]+=($R["Engine"]!="InnoDB"||$y!="Data_free"?$R[$y]:0);}elseif(array_key_exists($y,$R))json_row("$y-$B");}}}foreach($Rh
as$y=>$X)json_row("sum-$y",format_number($X));json_row("");}elseif($_GET["script"]=="kill")$f->query("KILL ".number($_POST["kill"]));else{foreach(count_tables($b->databases())as$j=>$X){json_row("tables-$j",$X);json_row("size-$j",db_size($j));}json_row("");}exit;}else{$bi=array_merge((array)$_POST["tables"],(array)$_POST["views"]);if($bi&&!$m&&!$_POST["search"]){$H=true;$Re="";if(JUSH=="sql"&&$_POST["tables"]&&count($_POST["tables"])>1&&($_POST["drop"]||$_POST["truncate"]||$_POST["copy"]))queries("SET foreign_key_checks = 0");if($_POST["truncate"]){if($_POST["tables"])$H=truncate_tables($_POST["tables"]);$Re='å·²æ¸…ç©ºè³‡æ–™è¡¨ã€‚';}elseif($_POST["move"]){$H=move_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Re='å·²è½‰ç§»è³‡æ–™è¡¨ã€‚';}elseif($_POST["copy"]){$H=copy_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Re='è³‡æ–™è¡¨å·²ç¶“è¤‡è£½';}elseif($_POST["drop"]){if($_POST["views"])$H=drop_views($_POST["views"]);if($H&&$_POST["tables"])$H=drop_tables($_POST["tables"]);$Re='å·²ç¶“å°‡è³‡æ–™è¡¨åˆªé™¤ã€‚';}elseif(JUSH=="sqlite"&&$_POST["check"]){foreach((array)$_POST["tables"]as$Q){foreach(get_rows("PRAGMA integrity_check(".q($Q).")")as$J)$Re.="<b>".h($Q)."</b>: ".h($J["integrity_check"])."<br>";}}elseif(JUSH!="sql"){$H=(JUSH=="sqlite"?queries("VACUUM"):apply_queries("VACUUM".($_POST["optimize"]?"":" ANALYZE"),$_POST["tables"]));$Re='å·²å„ªåŒ–è³‡æ–™è¡¨ã€‚';}elseif(!$_POST["tables"])$Re='æ²’æœ‰è³‡æ–™è¡¨ã€‚';elseif($H=queries(($_POST["optimize"]?"OPTIMIZE":($_POST["check"]?"CHECK":($_POST["repair"]?"REPAIR":"ANALYZE")))." TABLE ".implode(", ",array_map('Adminer\idf_escape',$_POST["tables"])))){while($J=$H->fetch_assoc())$Re.="<b>".h($J["Table"])."</b>: ".h($J["Msg_text"])."<br>";}queries_redirect(substr(ME,0,-1),$Re,$H);}page_header(($_GET["ns"]==""?'è³‡æ–™åº«'.": ".h(DB):'è³‡æ–™è¡¨çµæ§‹'.": ".h($_GET["ns"])),$m,true);if($b->homepage()){if($_GET["ns"]!==""){echo"<h3 id='tables-views'>".'è³‡æ–™è¡¨å’Œæª¢è¦–è¡¨'."</h3>\n";$ai=tables_list();if(!$ai)echo"<p class='message'>".'æ²’æœ‰è³‡æ–™è¡¨ã€‚'."\n";else{echo"<form action='' method='post'>\n";if(support("table")){echo"<fieldset><legend>".'åœ¨è³‡æ–™åº«æœå°‹'." <span id='selected2'></span></legend><div>","<input type='search' name='query' value='".h($_POST["query"])."'>",script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');","")," <input type='submit' name='search' value='".'æœå°‹'."'>\n","</div></fieldset>\n";if($_POST["search"]&&$_POST["query"]!=""){$_GET["where"][0]["op"]=$l->convertOperator("LIKE %%");search_tables();}}echo"<div class='scrollable'>\n","<table class='nowrap checkable odds'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),'<thead><tr class="wrap">','<td><input id="check-all" type="checkbox" class="jsonly">'.script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);",""),'<th>'.'è³‡æ–™è¡¨','<td>'.'å¼•æ“'.doc_link(array('sql'=>'storage-engines.html')),'<td>'.'æ ¡å°'.doc_link(array('sql'=>'charset-charsets.html','mariadb'=>'supported-character-sets-and-collations/')),'<td>'.'è³‡æ–™é•·åº¦'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT','oracle'=>'REFRN20286')),'<td>'.'ç´¢å¼•é•·åº¦'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT')),'<td>'.'è³‡æ–™ç©ºé–’'.doc_link(array('sql'=>'show-table-status.html')),'<td>'.'è‡ªå‹•éå¢'.doc_link(array('sql'=>'example-auto-increment.html','mariadb'=>'auto_increment/')),'<td>'.'è¡Œæ•¸'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'catalog-pg-class.html#CATALOG-PG-CLASS','oracle'=>'REFRN20286')),(support("comment")?'<td>'.'è¨»è§£'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-info.html#FUNCTIONS-INFO-COMMENT-TABLE')):''),"</thead>\n";$S=0;foreach($ai
as$B=>$U){$fj=($U!==null&&!preg_match('~table|sequence~i',$U));$u=h("Table-".$B);echo'<tr><td>'.checkbox(($fj?"views[]":"tables[]"),$B,in_array($B,$bi,true),"","","",$u),'<th>'.(support("table")||support("indexes")?"<a href='".h(ME)."table=".urlencode($B)."' title='".'é¡¯ç¤ºçµæ§‹'."' id='$u'>".h($B).'</a>':h($B));if($fj){echo'<td colspan="6"><a href="'.h(ME)."view=".urlencode($B).'" title="'.'ä¿®æ”¹æª¢è¦–è¡¨'.'">'.(preg_match('~materialized~i',$U)?'ç‰©åŒ–è¦–åœ–':'æª¢è¦–è¡¨').'</a>','<td align="right"><a href="'.h(ME)."select=".urlencode($B).'" title="'.'é¸æ“‡è³‡æ–™'.'">?</a>';}else{foreach(array("Engine"=>array(),"Collation"=>array(),"Data_length"=>array("create",'ä¿®æ”¹è³‡æ–™è¡¨'),"Index_length"=>array("indexes",'ä¿®æ”¹ç´¢å¼•'),"Data_free"=>array("edit",'æ–°å¢é …ç›®'),"Auto_increment"=>array("auto_increment=1&create",'ä¿®æ”¹è³‡æ–™è¡¨'),"Rows"=>array("select",'é¸æ“‡è³‡æ–™'),)as$y=>$_){$u=" id='$y-".h($B)."'";echo($_?"<td align='right'>".(support("table")||$y=="Rows"||(support("indexes")&&$y!="Data_length")?"<a href='".h(ME."$_[0]=").urlencode($B)."'$u title='$_[1]'>?</a>":"<span$u>?</span>"):"<td id='$y-".h($B)."'>");}$S++;}echo(support("comment")?"<td id='Comment-".h($B)."'>":""),"\n";}echo"<tr><td><th>".sprintf('ç¸½å…± %d å€‹',count($ai)),"<td>".h(JUSH=="sql"?$f->result("SELECT @@default_storage_engine"):""),"<td>".h(db_collation(DB,collations()));foreach(array("Data_length","Index_length","Data_free")as$y)echo"<td align='right' id='sum-$y'>";echo"\n","</table>\n","</div>\n";if(!information_schema(DB)){echo"<div class='footer'><div>\n";$Zi="<input type='submit' value='".'æ•´ç†ï¼ˆVacuumï¼‰'."'> ".on_help("'VACUUM'");$Af="<input type='submit' name='optimize' value='".'æœ€ä½³åŒ–'."'> ".on_help(JUSH=="sql"?"'OPTIMIZE TABLE'":"'VACUUM OPTIMIZE'");echo"<fieldset><legend>".'å·²é¸ä¸­'." <span id='selected'></span></legend><div>".(JUSH=="sqlite"?$Zi."<input type='submit' name='check' value='".'æª¢æŸ¥'."'> ".on_help("'PRAGMA integrity_check'"):(JUSH=="pgsql"?$Zi.$Af:(JUSH=="sql"?"<input type='submit' value='".'åˆ†æ'."'> ".on_help("'ANALYZE TABLE'").$Af."<input type='submit' name='check' value='".'æª¢æŸ¥'."'> ".on_help("'CHECK TABLE'")."<input type='submit' name='repair' value='".'ä¿®å¾©'."'> ".on_help("'REPAIR TABLE'"):"")))."<input type='submit' name='truncate' value='".'æ¸…ç©º'."'> ".on_help(JUSH=="sqlite"?"'DELETE'":"'TRUNCATE".(JUSH=="pgsql"?"'":" TABLE'")).confirm()."<input type='submit' name='drop' value='".'åˆªé™¤'."'>".on_help("'DROP TABLE'").confirm()."\n";$i=(support("scheme")?$b->schemas():$b->databases());if(count($i)!=1&&JUSH!="sqlite"){$j=(isset($_POST["target"])?$_POST["target"]:(support("scheme")?$_GET["ns"]:DB));echo"<p>".'è½‰ç§»åˆ°å…¶å®ƒè³‡æ–™åº«'.": ",($i?html_select("target",$i,$j):'<input name="target" value="'.h($j).'" autocapitalize="off">')," <input type='submit' name='move' value='".'è½‰ç§»'."'>",(support("copy")?" <input type='submit' name='copy' value='".'è¤‡è£½'."'> ".checkbox("overwrite",1,$_POST["overwrite"],'è¦†è“‹'):""),"\n";}echo"<input type='hidden' name='all' value=''>";echo
script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));".(support("table")?" selectCount('selected2', formChecked(this, /^tables\[/) || $S);":"")." }"),"<input type='hidden' name='token' value='$T'>\n","</div></fieldset>\n","</div></div>\n";}echo"</form>\n",script("tableCheck();");}echo'<p class="links"><a href="'.h(ME).'create=">'.'å»ºç«‹è³‡æ–™è¡¨'."</a>\n",(support("view")?'<a href="'.h(ME).'view=">'.'å»ºç«‹æª¢è¦–è¡¨'."</a>\n":"");if(support("routine")){echo"<h3 id='routines'>".'ç¨‹åº'."</h3>\n";$Yg=routines();if($Yg){echo"<table class='odds'>\n",'<thead><tr><th>'.'åç¨±'.'<td>'.'é¡å‹'.'<td>'.'å›å‚³é¡å‹'."<td></thead>\n";foreach($Yg
as$J){$B=($J["SPECIFIC_NAME"]==$J["ROUTINE_NAME"]?"":"&name=".urlencode($J["ROUTINE_NAME"]));echo'<tr>','<th><a href="'.h(ME.($J["ROUTINE_TYPE"]!="PROCEDURE"?'callf=':'call=').urlencode($J["SPECIFIC_NAME"]).$B).'">'.h($J["ROUTINE_NAME"]).'</a>','<td>'.h($J["ROUTINE_TYPE"]),'<td>'.h($J["DTD_IDENTIFIER"]),'<td><a href="'.h(ME.($J["ROUTINE_TYPE"]!="PROCEDURE"?'function=':'procedure=').urlencode($J["SPECIFIC_NAME"]).$B).'">'.'ä¿®æ”¹'."</a>";}echo"</table>\n";}echo'<p class="links">'.(support("procedure")?'<a href="'.h(ME).'procedure=">'.'å»ºç«‹é å­˜ç¨‹åº'.'</a>':'').'<a href="'.h(ME).'function=">'.'å»ºç«‹å‡½å¼'."</a>\n";}if(support("sequence")){echo"<h3 id='sequences'>".'åºåˆ—'."</h3>\n";$oh=get_vals("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = current_schema() ORDER BY sequence_name");if($oh){echo"<table class='odds'>\n","<thead><tr><th>".'åç¨±'."</thead>\n";foreach($oh
as$X)echo"<tr><th><a href='".h(ME)."sequence=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."sequence='>".'å»ºç«‹åºåˆ—'."</a>\n";}if(support("type")){echo"<h3 id='user-types'>".'ä½¿ç”¨è€…é¡å‹'."</h3>\n";$Xi=types();if($Xi){echo"<table class='odds'>\n","<thead><tr><th>".'åç¨±'."</thead>\n";foreach($Xi
as$X)echo"<tr><th><a href='".h(ME)."type=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."type='>".'å»ºç«‹é¡å‹'."</a>\n";}if(support("event")){echo"<h3 id='events'>".'äº‹ä»¶'."</h3>\n";$K=get_rows("SHOW EVENTS");if($K){echo"<table>\n","<thead><tr><th>".'åç¨±'."<td>".'æ’ç¨‹'."<td>".'é–‹å§‹'."<td>".'çµæŸ'."<td></thead>\n";foreach($K
as$J){echo"<tr>","<th>".h($J["Name"]),"<td>".($J["Execute at"]?'åœ¨æŒ‡å®šæ™‚é–“'."<td>".$J["Execute at"]:'æ¯'." ".$J["Interval value"]." ".$J["Interval field"]."<td>$J[Starts]"),"<td>$J[Ends]",'<td><a href="'.h(ME).'event='.urlencode($J["Name"]).'">'.'ä¿®æ”¹'.'</a>';}echo"</table>\n";$Lc=$f->result("SELECT @@event_scheduler");if($Lc&&$Lc!="ON")echo"<p class='error'><code class='jush-sqlset'>event_scheduler</code>: ".h($Lc)."\n";}echo'<p class="links"><a href="'.h(ME).'event=">'.'å»ºç«‹äº‹ä»¶'."</a>\n";}if($ai)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}}}page_footer();