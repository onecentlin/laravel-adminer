<?php
/** Adminer - Compact database management
* @link https://www.adminer.org/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
* @version 4.17.1
*/$ia="4.17.1";function
adminer_errors($Gc,$Ic){return!!preg_match('~^(Trying to access array offset on( value of type)? null|Undefined (array key|property))~',$Ic);}error_reporting(6135);set_error_handler('adminer_errors',E_WARNING);$cd=!preg_match('~^(unsafe_raw)?$~',ini_get("filter.default"));if($cd||ini_get("filter.default_flags")){foreach(array('_GET','_POST','_COOKIE','_SERVER')as$X){$Ei=filter_input_array(constant("INPUT$X"),FILTER_UNSAFE_RAW);if($Ei)$$X=$Ei;}}if(function_exists("mb_internal_encoding"))mb_internal_encoding("8bit");function
connection(){global$f;return$f;}function
adminer(){global$b;return$b;}function
version(){global$ia;return$ia;}function
idf_unescape($t){if(!preg_match('~^[`\'"[]~',$t))return$t;$pe=substr($t,-1);return
str_replace($pe.$pe,$pe,substr($t,1,-1));}function
escape_string($X){return
substr(q($X),1,-1);}function
number($X){return
preg_replace('~[^0-9]+~','',$X);}function
number_type(){return'((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';}function
remove_slashes($pg,$cd=false){if(function_exists("get_magic_quotes_gpc")&&get_magic_quotes_gpc()){while(list($x,$X)=each($pg)){foreach($X
as$he=>$W){unset($pg[$x][$he]);if(is_array($W)){$pg[$x][stripslashes($he)]=$W;$pg[]=&$pg[$x][stripslashes($he)];}else$pg[$x][stripslashes($he)]=($cd?$W:stripslashes($W));}}}}function
bracket_escape($t,$Ma=false){static$pi=array(':'=>':1',']'=>':2','['=>':3','"'=>':4');return
strtr($t,($Ma?array_flip($pi):$pi));}function
min_version($Vi,$Be="",$g=null){global$f;if(!$g)$g=$f;$ih=$g->server_info;if($Be&&preg_match('~([\d.]+)-MariaDB~',$ih,$A)){$ih=$A[1];$Vi=$Be;}return$Vi&&version_compare($ih,$Vi)>=0;}function
charset($f){return(min_version("5.5.3",0,$f)?"utf8mb4":"utf8");}function
script($uh,$oi="\n"){return"<script".nonce().">$uh</script>$oi";}function
script_src($Ji){return"<script src='".h($Ji)."'".nonce()."></script>\n";}function
nonce(){return' nonce="'.get_nonce().'"';}function
target_blank(){return' target="_blank" rel="noreferrer noopener"';}function
h($O){return
str_replace("\0","&#0;",htmlspecialchars($O,ENT_QUOTES,'utf-8'));}function
nl_br($O){return
str_replace("\n","<br>",$O);}function
checkbox($B,$Y,$fb,$me="",$tf="",$jb="",$ne=""){$H="<input type='checkbox' name='$B' value='".h($Y)."'".($fb?" checked":"").($ne?" aria-labelledby='$ne'":"").">".($tf?script("qsl('input').onclick = function () { $tf };",""):"");return($me!=""||$jb?"<label".($jb?" class='$jb'":"").">$H".h($me)."</label>":$H);}function
optionlist($C,$ah=null,$Ni=false){$H="";foreach($C
as$he=>$W){$zf=array($he=>$W);if(is_array($W)){$H.='<optgroup label="'.h($he).'">';$zf=$W;}foreach($zf
as$x=>$X)$H.='<option'.($Ni||is_string($x)?' value="'.h($x).'"':'').($ah!==null&&($Ni||is_string($x)?(string)$x:$X)===$ah?' selected':'').'>'.h($X);if(is_array($W))$H.='</optgroup>';}return$H;}function
html_select($B,$C,$Y="",$sf=true,$ne=""){if($sf)return"<select name='".h($B)."'".($ne?" aria-labelledby='$ne'":"").">".optionlist($C,$Y)."</select>".(is_string($sf)?script("qsl('select').onchange = function () { $sf };",""):"");$H="";foreach($C
as$x=>$X)$H.="<label><input type='radio' name='".h($B)."' value='".h($x)."'".($x==$Y?" checked":"").">".h($X)."</label>";return$H;}function
confirm($Me="",$bh="qsl('input')"){return
script("$bh.onclick = function () { return confirm('".($Me?js_escape($Me):'ä½ ç¢ºå®šå—ï¼Ÿ')."'); };","");}function
print_fieldset($Jd,$ue,$Yi=false){echo"<fieldset><legend>","<a href='#fieldset-$Jd'>$ue</a>",script("qsl('a').onclick = partial(toggle, 'fieldset-$Jd');",""),"</legend>","<div id='fieldset-$Jd'".($Yi?"":" class='hidden'").">\n";}function
bold($Ta,$jb=""){return($Ta?" class='active $jb'":($jb?" class='$jb'":""));}function
js_escape($O){return
addcslashes($O,"\r\n'\\/");}function
ini_bool($Ud){$X=ini_get($Ud);return(preg_match('~^(on|true|yes)$~i',$X)||(int)$X);}function
sid(){static$H;if($H===null)$H=(SID&&!($_COOKIE&&ini_bool("session.use_cookies")));return$H;}function
set_password($Ui,$L,$V,$E){$_SESSION["pwds"][$Ui][$L][$V]=($_COOKIE["adminer_key"]&&is_string($E)?array(encrypt_string($E,$_COOKIE["adminer_key"])):$E);}function
get_password(){$H=get_session("pwds");if(is_array($H))$H=($_COOKIE["adminer_key"]?decrypt_string($H[0],$_COOKIE["adminer_key"]):false);return$H;}function
q($O){global$f;return$f->quote($O);}function
get_vals($F,$d=0){global$f;$H=array();$G=$f->query($F);if(is_object($G)){while($I=$G->fetch_row())$H[]=$I[$d];}return$H;}function
get_key_vals($F,$g=null,$lh=true){global$f;if(!is_object($g))$g=$f;$H=array();$G=$g->query($F);if(is_object($G)){while($I=$G->fetch_row()){if($lh)$H[$I[0]]=$I[1];else$H[]=$I[0];}}return$H;}function
get_rows($F,$g=null,$l="<p class='error'>"){global$f;$_b=(is_object($g)?$g:$f);$H=array();$G=$_b->query($F);if(is_object($G)){while($I=$G->fetch_assoc())$H[]=$I;}elseif(!$G&&!is_object($g)&&$l&&(defined("PAGE_HEADER")||$l=="-- "))echo$l.error()."\n";return$H;}function
unique_array($I,$v){foreach($v
as$u){if(preg_match("~PRIMARY|UNIQUE~",$u["type"])){$H=array();foreach($u["columns"]as$x){if(!isset($I[$x]))continue
2;$H[$x]=$I[$x];}return$H;}}}function
escape_key($x){if(preg_match('(^([\w(]+)('.str_replace("_",".*",preg_quote(idf_escape("_"))).')([ \w)]+)$)',$x,$A))return$A[1].idf_escape(idf_unescape($A[2])).$A[3];return
idf_escape($x);}function
where($Z,$n=array()){global$f,$w;$H=array();foreach((array)$Z["where"]as$x=>$X){$x=bracket_escape($x,1);$d=escape_key($x);$H[]=$d.($w=="sql"&&$n[$x]["type"]=="json"?" = CAST(".q($X)." AS JSON)":($w=="sql"&&is_numeric($X)&&preg_match('~\.~',$X)?" LIKE ".q($X):($w=="mssql"?" LIKE ".q(preg_replace('~[_%[]~','[\0]',$X)):" = ".unconvert_field($n[$x],q($X)))));if($w=="sql"&&preg_match('~char|text~',$n[$x]["type"])&&preg_match("~[^ -@]~",$X))$H[]="$d = ".q($X)." COLLATE ".charset($f)."_bin";}foreach((array)$Z["null"]as$x)$H[]=escape_key($x)." IS NULL";return
implode(" AND ",$H);}function
where_check($X,$n=array()){parse_str($X,$cb);remove_slashes(array(&$cb));return
where($cb,$n);}function
where_link($s,$d,$Y,$vf="="){return"&where%5B$s%5D%5Bcol%5D=".urlencode($d)."&where%5B$s%5D%5Bop%5D=".urlencode(($Y!==null?$vf:"IS NULL"))."&where%5B$s%5D%5Bval%5D=".urlencode($Y);}function
convert_fields($e,$n,$K=array()){$H="";foreach($e
as$x=>$X){if($K&&!in_array(idf_escape($x),$K))continue;$Fa=convert_field($n[$x]);if($Fa)$H.=", $Fa AS ".idf_escape($x);}return$H;}function
adm_cookie($B,$Y,$xe=2592000){global$ba;return
header("Set-Cookie: $B=".urlencode($Y).($xe?"; expires=".gmdate("D, d M Y H:i:s",time()+$xe)." GMT":"")."; path=".preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]).($ba?"; secure":"")."; HttpOnly; SameSite=lax",false);}function
restart_session(){if(!ini_bool("session.use_cookies"))session_start();}function
stop_session($jd=false){$Mi=ini_bool("session.use_cookies");if(!$Mi||$jd){session_write_close();if($Mi&&@ini_set("session.use_cookies",false)===false)session_start();}}function&get_session($x){return$_SESSION[$x][DRIVER][SERVER][$_GET["username"]];}function
set_session($x,$X){$_SESSION[$x][DRIVER][SERVER][$_GET["username"]]=$X;}function
auth_url($Ui,$L,$V,$j=null){global$nc;preg_match('~([^?]*)\??(.*)~',remove_from_uri(implode("|",array_keys($nc))."|username|".($j!==null?"db|":"").session_name()),$A);return"$A[1]?".(sid()?SID."&":"").($Ui!="server"||$L!=""?urlencode($Ui)."=".urlencode($L)."&":"")."username=".urlencode($V).($j!=""?"&db=".urlencode($j):"").($A[2]?"&$A[2]":"");}function
is_ajax(){return($_SERVER["HTTP_X_REQUESTED_WITH"]=="XMLHttpRequest");}function
adm_redirect($_,$Me=null){if($Me!==null){restart_session();$_SESSION["messages"][preg_replace('~^[^?]*~','',($_!==null?$_:$_SERVER["REQUEST_URI"]))][]=$Me;}if($_!==null){if($_=="")$_=".";header("Location: $_");exit;}}function
query_redirect($F,$_,$Me,$yg=true,$Nc=true,$Wc=false,$ci=""){global$f,$l,$b;if($Nc){$Ch=microtime(true);$Wc=!$f->query($F);$ci=format_time($Ch);}$xh="";if($F)$xh=$b->messageQuery($F,$ci,$Wc);if($Wc){$l=error().$xh.script("messagesPrint();");return
false;}if($yg)adm_redirect($_,$Me.$xh);return
true;}function
queries($F){global$f;static$tg=array();static$Ch;if(!$Ch)$Ch=microtime(true);if($F===null)return
array(implode("\n",$tg),format_time($Ch));$tg[]=(preg_match('~;$~',$F)?"DELIMITER ;;\n$F;\nDELIMITER ":$F).";";return$f->query($F);}function
apply_queries($F,$R,$Jc='table'){foreach($R
as$P){if(!queries("$F ".$Jc($P)))return
false;}return
true;}function
queries_redirect($_,$Me,$yg){list($tg,$ci)=queries(null);return
query_redirect($tg,$_,$Me,$yg,false,!$yg,$ci);}function
format_time($Ch){return
sprintf('%.3f ç§’',max(0,microtime(true)-$Ch));}function
relative_uri(){return
str_replace(":","%3a",preg_replace('~^[^?]*/([^?]*)~','\1',$_SERVER["REQUEST_URI"]));}function
remove_from_uri($Of=""){return
substr(preg_replace("~(?<=[?&])($Of".(SID?"":"|".session_name()).")=[^&]*&~",'',relative_uri()."&"),0,-1);}function
pagination($D,$Qb){return" ".($D==$Qb?$D+1:'<a href="'.h(remove_from_uri("page").($D?"&page=$D".($_GET["next"]?"&next=".urlencode($_GET["next"]):""):"")).'">'.($D+1)."</a>");}function
get_file($x,$Zb=false){$bd=$_FILES[$x];if(!$bd)return
null;foreach($bd
as$x=>$X)$bd[$x]=(array)$X;$H='';foreach($bd["error"]as$x=>$l){if($l)return$l;$B=$bd["name"][$x];$ki=$bd["tmp_name"][$x];$Eb=file_get_contents($Zb&&preg_match('~\.gz$~',$B)?"compress.zlib://$ki":$ki);if($Zb){$Ch=substr($Eb,0,3);if(function_exists("iconv")&&preg_match("~^\xFE\xFF|^\xFF\xFE~",$Ch,$Dg))$Eb=iconv("utf-16","utf-8",$Eb);elseif($Ch=="\xEF\xBB\xBF")$Eb=substr($Eb,3);$H.=$Eb."\n\n";}else$H.=$Eb;}return$H;}function
upload_error($l){$Ie=($l==UPLOAD_ERR_INI_SIZE?ini_get("upload_max_filesize"):0);return($l?'ç„¡æ³•ä¸Šå‚³æª”æ¡ˆã€‚'.($Ie?" ".sprintf('å…è¨±çš„æª”æ¡ˆä¸Šé™å¤§å°ç‚º %sB',$Ie):""):'æª”æ¡ˆä¸å­˜åœ¨');}function
repeat_pattern($Yf,$ve){return
str_repeat("$Yf{0,65535}",$ve/65535)."$Yf{0,".($ve%65535)."}";}function
is_utf8($X){return(preg_match('~~u',$X)&&!preg_match('~[\0-\x8\xB\xC\xE-\x1F]~',$X));}function
shorten_utf8($O,$ve=80,$Ih=""){if(!preg_match("(^(".repeat_pattern("[\t\r\n -\x{10FFFF}]",$ve).")($)?)u",$O,$A))preg_match("(^(".repeat_pattern("[\t\r\n -~]",$ve).")($)?)",$O,$A);return
h($A[1]).$Ih.(isset($A[2])?"":"<i>â€¦</i>");}function
format_number($X){return
strtr(number_format($X,0,".",','),preg_split('~~u','0123456789',-1,PREG_SPLIT_NO_EMPTY));}function
friendly_url($X){return
preg_replace('~[^a-z0-9_]~i','-',$X);}function
hidden_fields($pg,$Ld=array(),$hg=''){$H=false;foreach($pg
as$x=>$X){if(!in_array($x,$Ld)){if(is_array($X))hidden_fields($X,array(),$x);else{$H=true;echo'<input type="hidden" name="'.h($hg?$hg."[$x]":$x).'" value="'.h($X).'">';}}}return$H;}function
hidden_fields_get(){echo(sid()?'<input type="hidden" name="'.session_name().'" value="'.h(session_id()).'">':''),(SERVER!==null?'<input type="hidden" name="'.DRIVER.'" value="'.h(SERVER).'">':""),'<input type="hidden" name="username" value="'.h($_GET["username"]).'">';}function
table_status1($P,$Xc=false){$H=table_status($P,$Xc);return($H?$H:array("Name"=>$P));}function
column_foreign_keys($P){global$b;$H=array();foreach($b->foreignKeys($P)as$p){foreach($p["source"]as$X)$H[$X][]=$p;}return$H;}function
enum_input($T,$Ha,$m,$Y,$Bc=null){global$b,$w;preg_match_all("~'((?:[^']|'')*)'~",$m["length"],$De);$H=($Bc!==null?"<label><input type='$T'$Ha value='$Bc'".((is_array($Y)?in_array($Bc,$Y):$Y===0)?" checked":"")."><i>".'ç©ºå€¼'."</i></label>":"");foreach($De[1]as$s=>$X){$X=stripcslashes(str_replace("''","'",$X));$fb=(is_int($Y)?$Y==$s+1:(is_array($Y)?in_array($s+1,$Y):$Y===$X));$H.=" <label><input type='$T'$Ha value='".($w=="sql"?$s+1:h($X))."'".($fb?' checked':'').'>'.h($b->editVal($X,$m)).'</label>';}return$H;}function
input($m,$Y,$r){global$U,$Fh,$b,$w;$B=h(bracket_escape($m["field"]));echo"<td class='function'>";if(is_array($Y)&&!$r){$Da=array($Y);if(version_compare(PHP_VERSION,5.4)>=0)$Da[]=JSON_PRETTY_PRINT;$Y=call_user_func_array('json_encode',$Da);$r="json";}$Hg=($w=="mssql"&&$m["auto_increment"]);if($Hg&&!$_POST["save"])$r=null;$rd=(isset($_GET["select"])||$Hg?array("orig"=>'åŸå§‹'):array())+$b->editFunctions($m);$jc=stripos($m["default"],"GENERATED ALWAYS AS ")===0?" disabled=''":"";$Ha=" name='fields[$B]'$jc";if($w=="pgsql"&&in_array($m["type"],(array)$Fh['ä½¿ç”¨è€…é¡å‹'])){$Fc=get_vals("SELECT enumlabel FROM pg_enum WHERE enumtypid = ".$U[$m["type"]]." ORDER BY enumsortorder");if($Fc){$m["type"]="enum";$m["length"]="'".implode("','",array_map('addslashes',$Fc))."'";}}if($m["type"]=="enum")echo
h($rd[""])."<td>".$b->editInput($_GET["edit"],$m,$Ha,$Y);else{$Bd=(in_array($r,$rd)||isset($rd[$r]));echo(count($rd)>1?"<select name='function[$B]'$jc>".optionlist($rd,$r===null||$Bd?$r:"")."</select>".on_help("getTarget(event).value.replace(/^SQL\$/, '')",1).script("qsl('select').onchange = functionChange;",""):h(reset($rd))).'<td>';$Wd=$b->editInput($_GET["edit"],$m,$Ha,$Y);if($Wd!="")echo$Wd;elseif(preg_match('~bool~',$m["type"]))echo"<input type='hidden'$Ha value='0'>"."<input type='checkbox'".(preg_match('~^(1|t|true|y|yes|on)$~i',$Y)?" checked='checked'":"")."$Ha value='1'>";elseif($m["type"]=="set"){preg_match_all("~'((?:[^']|'')*)'~",$m["length"],$De);foreach($De[1]as$s=>$X){$X=stripcslashes(str_replace("''","'",$X));$fb=(is_int($Y)?($Y>>$s)&1:in_array($X,explode(",",$Y),true));echo" <label><input type='checkbox' name='fields[$B][$s]' value='".(1<<$s)."'".($fb?' checked':'').">".h($b->editVal($X,$m)).'</label>';}}elseif(preg_match('~blob|bytea|raw|file~',$m["type"])&&ini_bool("file_uploads"))echo"<input type='file' name='fields-$B'>";elseif(($Zh=preg_match('~text|lob|memo~i',$m["type"]))||preg_match("~\n~",$Y)){if($Zh&&$w!="sqlite")$Ha.=" cols='50' rows='12'";else{$J=min(12,substr_count($Y,"\n")+1);$Ha.=" cols='30' rows='$J'".($J==1?" style='height: 1.2em;'":"");}echo"<textarea$Ha>".h($Y).'</textarea>';}elseif($r=="json"||preg_match('~^jsonb?$~',$m["type"]))echo"<textarea$Ha cols='50' rows='12' class='jush-js'>".h($Y).'</textarea>';else{$Ke=(!preg_match('~int~',$m["type"])&&preg_match('~^(\d+)(,(\d+))?$~',$m["length"],$A)?((preg_match("~binary~",$m["type"])?2:1)*$A[1]+($A[3]?1:0)+($A[2]&&!$m["unsigned"]?1:0)):($U[$m["type"]]?$U[$m["type"]]+($m["unsigned"]?0:1):0));if($w=='sql'&&min_version(5.6)&&preg_match('~time~',$m["type"]))$Ke+=7;echo"<input".((!$Bd||$r==="")&&preg_match('~(?<!o)int(?!er)~',$m["type"])&&!preg_match('~\[\]~',$m["full_type"])?" type='number'":"")." value='".h($Y)."'".($Ke?" data-maxlength='$Ke'":"").(preg_match('~char|binary~',$m["type"])&&$Ke>20?" size='40'":"")."$Ha>";}echo$b->editHint($_GET["edit"],$m,$Y);$dd=0;foreach($rd
as$x=>$X){if($x===""||!$X)break;$dd++;}if($dd)echo
script("mixin(qsl('td'), {onchange: partial(skipOriginal, $dd), oninput: function () { this.onchange(); }});");}}function
process_input($m){global$b,$k;if(stripos($m["default"],"GENERATED ALWAYS AS ")===0)return
null;$t=bracket_escape($m["field"]);$r=$_POST["function"][$t];$Y=$_POST["fields"][$t];if($m["type"]=="enum"){if($Y==-1)return
false;if($Y=="")return"NULL";return+$Y;}if($m["auto_increment"]&&$Y=="")return
null;if($r=="orig")return(preg_match('~^CURRENT_TIMESTAMP~i',$m["on_update"])?idf_escape($m["field"]):false);if($r=="NULL")return"NULL";if($m["type"]=="set")return
array_sum((array)$Y);if($r=="json"){$r="";$Y=json_decode($Y,true);if(!is_array($Y))return
false;return$Y;}if(preg_match('~blob|bytea|raw|file~',$m["type"])&&ini_bool("file_uploads")){$bd=get_file("fields-$t");if(!is_string($bd))return
false;return$k->quoteBinary($bd);}return$b->processInput($m,$Y,$r);}function
fields_from_edit(){global$k;$H=array();foreach((array)$_POST["field_keys"]as$x=>$X){if($X!=""){$X=bracket_escape($X);$_POST["function"][$X]=$_POST["field_funs"][$x];$_POST["fields"][$X]=$_POST["field_vals"][$x];}}foreach((array)$_POST["fields"]as$x=>$X){$B=bracket_escape($x,1);$H[$B]=array("field"=>$B,"privileges"=>array("insert"=>1,"update"=>1),"null"=>1,"auto_increment"=>($x==$k->primary),);}return$H;}function
search_tables(){global$b,$f;$_GET["where"][0]["val"]=$_POST["query"];$dh="<ul>\n";foreach(table_status('',true)as$P=>$Q){$B=$b->tableName($Q);if(isset($Q["Engine"])&&$B!=""&&(!$_POST["tables"]||in_array($P,$_POST["tables"]))){$G=$f->query("SELECT".limit("1 FROM ".table($P)," WHERE ".implode(" AND ",$b->selectSearchProcess(fields($P),array())),1));if(!$G||$G->fetch_row()){$lg="<a href='".h(ME."select=".urlencode($P)."&where[0][op]=".urlencode($_GET["where"][0]["op"])."&where[0][val]=".urlencode($_GET["where"][0]["val"]))."'>$B</a>";echo"$dh<li>".($G?$lg:"<p class='error'>$lg: ".error())."\n";$dh="";}}}echo($dh?"<p class='message'>".'æ²’æœ‰è³‡æ–™è¡¨ã€‚':"</ul>")."\n";}function
dump_headers($Kd,$Ue=false){global$b;$H=$b->dumpHeaders($Kd,$Ue);$Kf=$_POST["output"];if($Kf!="text")header("Content-Disposition: attachment; filename=".$b->dumpFilename($Kd).".$H".($Kf!="file"&&preg_match('~^[0-9a-z]+$~',$Kf)?".$Kf":""));session_write_close();ob_flush();flush();return$H;}function
dump_csv($I){foreach($I
as$x=>$X){if(preg_match('~["\n,;\t]|^0|\.\d*0$~',$X)||$X==="")$I[$x]='"'.str_replace('"','""',$X).'"';}echo
implode(($_POST["format"]=="csv"?",":($_POST["format"]=="tsv"?"\t":";")),$I)."\r\n";}function
apply_sql_function($r,$d){return($r?($r=="unixepoch"?"DATETIME($d, '$r')":($r=="count distinct"?"COUNT(DISTINCT ":strtoupper("$r("))."$d)"):$d);}function
get_temp_dir(){$H=ini_get("upload_tmp_dir");if(!$H){if(function_exists('sys_get_temp_dir'))$H=sys_get_temp_dir();else{$o=@tempnam("","");if(!$o)return
false;$H=dirname($o);unlink($o);}}return$H;}function
file_open_lock($o){$q=@fopen($o,"r+");if(!$q){$q=@fopen($o,"w");if(!$q)return;chmod($o,0660);}flock($q,LOCK_EX);return$q;}function
file_write_unlock($q,$Sb){rewind($q);fwrite($q,$Sb);ftruncate($q,strlen($Sb));flock($q,LOCK_UN);fclose($q);}function
password_file($h){$o=get_temp_dir()."/adminer.key";$H=@file_get_contents($o);if($H||!$h)return$H;$q=@fopen($o,"w");if($q){chmod($o,0660);$H=rand_string();fwrite($q,$H);fclose($q);}return$H;}function
rand_string(){return
md5(uniqid(mt_rand(),true));}function
select_value($X,$z,$m,$bi){global$b;if(is_array($X)){$H="";foreach($X
as$he=>$W)$H.="<tr>".($X!=array_values($X)?"<th>".h($he):"")."<td>".select_value($W,$z,$m,$bi);return"<table>$H</table>";}if(!$z)$z=$b->selectLink($X,$m);if($z===null){if(is_mail($X))$z="mailto:$X";if(is_url($X))$z=$X;}$H=$b->editVal($X,$m);if($H!==null){if(!is_utf8($H))$H="\0";elseif($bi!=""&&is_shortable($m))$H=shorten_utf8($H,max(0,+$bi));else$H=h($H);}return$b->selectVal($H,$z,$m,$X);}function
is_mail($zc){$Ga='[-a-z0-9!#$%&\'*+/=?^_`{|}~]';$mc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';$Yf="$Ga+(\\.$Ga+)*@($mc?\\.)+$mc";return
is_string($zc)&&preg_match("(^$Yf(,\\s*$Yf)*\$)i",$zc);}function
is_url($O){$mc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';return
preg_match("~^(https?)://($mc?\\.)+$mc(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i",$O);}function
is_shortable($m){return
preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~',$m["type"]);}function
count_rows($P,$Z,$ce,$vd){global$w;$F=" FROM ".table($P).($Z?" WHERE ".implode(" AND ",$Z):"");return($ce&&($w=="sql"||count($vd)==1)?"SELECT COUNT(DISTINCT ".implode(", ",$vd).")$F":"SELECT COUNT(*)".($ce?" FROM (SELECT 1$F GROUP BY ".implode(", ",$vd).") x":$F));}function
slow_query($F){global$b,$S,$k;$j=$b->database();$di=$b->queryTimeout();$rh=$k->slowQuery($F,$di);if(!$rh&&support("kill")&&is_object($g=connect())&&($j==""||$g->select_db($j))){$ke=$g->result(connection_id());echo'<script',nonce(),'>
var timeout = setTimeout(function () {
	ajax(\'',js_escape(ME),'script=kill\', function () {
	}, \'kill=',$ke,'&token=',$S,'\');
}, ',1000*$di,');
</script>
';}else$g=null;ob_flush();flush();$H=@get_key_vals(($rh?$rh:$F),$g,false);if($g){echo
script("clearTimeout(timeout);");ob_flush();flush();}return$H;}function
get_token(){$wg=rand(1,1e6);return($wg^$_SESSION["token"]).":$wg";}function
verify_token(){list($S,$wg)=explode(":",$_POST["token"]);return($wg^$_SESSION["token"])==$S;}function
lzw_decompress($Qa){$ic=256;$Ra=8;$lb=array();$Jg=0;$Kg=0;for($s=0;$s<strlen($Qa);$s++){$Jg=($Jg<<8)+ord($Qa[$s]);$Kg+=8;if($Kg>=$Ra){$Kg-=$Ra;$lb[]=$Jg>>$Kg;$Jg&=(1<<$Kg)-1;$ic++;if($ic>>$Ra)$Ra++;}}$hc=range("\0","\xFF");$H="";foreach($lb
as$s=>$kb){$yc=$hc[$kb];if(!isset($yc))$yc=$jj.$jj[0];$H.=$yc;if($s)$hc[]=$jj.$yc[0];$jj=$yc;}return$H;}function
on_help($tb,$oh=0){return
script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $tb, $oh) }, onmouseout: helpMouseout});","");}function
edit_form($P,$n,$I,$Hi){global$b,$w,$S,$l;$Nh=$b->tableName(table_status1($P,true));page_header(($Hi?'ç·¨è¼¯':'æ–°å¢'),$l,array("select"=>array($P,$Nh)),$Nh);$b->editRowPrint($P,$n,$I,$Hi);if($I===false){echo"<p class='error'>".'æ²’æœ‰è³‡æ–™è¡Œã€‚'."\n";return;}echo'<form action="" method="post" enctype="multipart/form-data" id="form">
';if(!$n)echo"<p class='error'>".'æ‚¨æ²’æœ‰è¨±å¯æ¬Šæ›´æ–°é€™å€‹è³‡æ–™è¡¨ã€‚'."\n";else{echo"<table class='layout'>".script("qsl('table').onkeydown = editingKeydown;");foreach($n
as$B=>$m){echo"<tr><th>".$b->fieldName($m);$ac=$_GET["set"][bracket_escape($B)];if($ac===null){$ac=$m["default"];if($m["type"]=="bit"&&preg_match("~^b'([01]*)'\$~",$ac,$Dg))$ac=$Dg[1];}$Y=($I!==null?($I[$B]!=""&&$w=="sql"&&preg_match("~enum|set~",$m["type"])?(is_array($I[$B])?array_sum($I[$B]):+$I[$B]):(is_bool($I[$B])?+$I[$B]:$I[$B])):(!$Hi&&$m["auto_increment"]?"":(isset($_GET["select"])?false:$ac)));if(!$_POST["save"]&&is_string($Y))$Y=$b->editVal($Y,$m);$r=($_POST["save"]?(string)$_POST["function"][$B]:($Hi&&preg_match('~^CURRENT_TIMESTAMP~i',$m["on_update"])?"now":($Y===false?null:($Y!==null?'':'NULL'))));if(!$_POST&&!$Hi&&$Y==$m["default"]&&preg_match('~^[\w.]+\(~',$Y))$r="SQL";if(preg_match("~time~",$m["type"])&&preg_match('~^CURRENT_TIMESTAMP~i',$Y)){$Y="";$r="now";}if($m["type"]=="uuid"&&$Y=="uuid()"){$Y="";$r="uuid";}input($m,$Y,$r);echo"\n";}if(!support("table"))echo"<tr>"."<th><input name='field_keys[]'>".script("qsl('input').oninput = fieldChange;")."<td class='function'>".html_select("field_funs[]",$b->editFunctions(array("null"=>isset($_GET["select"]))))."<td><input name='field_vals[]'>"."\n";echo"</table>\n";}echo"<p>\n";if($n){echo"<input type='submit' value='".'å„²å­˜'."'>\n";if(!isset($_GET["select"])){echo"<input type='submit' name='insert' value='".($Hi?'å„²å­˜ä¸¦ç¹¼çºŒç·¨è¼¯':'å„²å­˜ä¸¦æ–°å¢ä¸‹ä¸€ç­†')."' title='Ctrl+Shift+Enter'>\n",($Hi?script("qsl('input').onclick = function () { return !ajaxForm(this.form, '".'ä¿å­˜ä¸­'."â€¦', this); };"):"");}}echo($Hi?"<input type='submit' name='delete' value='".'åˆªé™¤'."'>".confirm()."\n":($_POST||!$n?"":script("focus(qsa('td', qs('#form'))[1].firstChild);")));if(isset($_GET["select"]))hidden_fields(array("check"=>(array)$_POST["check"],"clone"=>$_POST["clone"],"all"=>$_POST["all"]));echo'<input type="hidden" name="referer" value="',h(isset($_POST["referer"])?$_POST["referer"]:$_SERVER["HTTP_REFERER"]),'">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="',$S,'">
</form>
';}if(isset($_GET["file"])){if($_SERVER["HTTP_IF_MODIFIED_SINCE"]){header("HTTP/1.1 304 Not Modified");exit;}header("Expires: ".gmdate("D, d M Y H:i:s",time()+365*24*60*60)." GMT");header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");header("Cache-Control: immutable");if($_GET["file"]=="favicon.ico"){header("Content-Type: image/x-icon");echo
lzw_decompress("\0\0\0` \0„\0\n @\0´C„è\"\0`EãQ¸àÿ‡?ÀtvM'”JdÁd\\Œb0\0Ä\"™ÀfÓˆ¤îs5›ÏçÑAXPaJ“0„¥‘8„#RŠT©‘z`ˆ#.©ÇcíXÃşÈ€?À-\0¡Im? .«M¶€\0È¯(Ì‰ıÀ/(%Œ\0");}elseif($_GET["file"]=="default.css"){header("Content-Type: text/css; charset=utf-8");echo
lzw_decompress("\n1Ì‡“ÙŒŞl7œ‡B1„4vb0˜Ífs‘¼ên2BÌÑ±Ù˜Şn:‡#(¼b.\rDc)ÈÈa7E„‘¤Âl¦Ã±”èi1Ìs˜´ç-4™‡fÓ	ÈÎi7†º€´îi2\r£1¤è-ƒH²ÙôÃƒÂGF#aÔÊ;:Oó!–r0Ïãã£t~ßf':ñ”Éh„B¦'cÍ”Â:6T\rc£A¾zrcğXKŒg+—ÄZXk…Êév„ŞM7¸½Ôå‘7_Ì\"ëÏ)––öº{¾ª÷}Øã…Æ£©ÌĞ-4NÎ}:¨rf§K) b{H(Æ“Ñ”t1É)tÚ}F¦p0™•8è\\82›DŒ>®ÀN‡Cy·¾8\0æƒ«\0FÁê>¯ã(Ò3	\nú9)ƒ`vç-Ao\r¡èŠ&Šµ¨XËº¡“±»në¾ğ„¯œ¨*A\0`A„\0¡ˆq\0oCÔö=Ïƒäú\r¯²\\–¿#{öş¿ğÈŒ2©ÃR‡;0dBHL+¢H¢,Œ!oR”>œNíA°|\"¾KÉ¼í0‘Pb¼Jd^¨È‘”d²£Ğ ÷=<ª’Ê:J# Â¶£Ú®¬«aŠĞ‘‚¦>ÑTeòFìkÆjš#K6#‚9ÕET·Ë1K¼‘Å´ÀÈ+CİF×I°	(ÀğL|õÏjPø„pfúÓEuLQG­íØZ›ÁêˆØ2ŒÎ¥š2½!sk[:¢1¬kˆå½6%ŒYpkf+W[Ş·\rrˆL1ÈÌÔ\0ÒŒŠ8è=½c˜áT.€ÜØ-ìº~ –»#sOàávGö+İy¾O{ëJª9COÕî–×²|`‡+(áMÏr\r‘OÀ5\nÊ4£8÷‰(	¾-l‡Cj°2[r5yKÑyŸ)ƒÂ¬¬+AÔk¤äÍÉ¯¨2ëgß³3iÄ”ÂÜHS>–ÜWÆÖ<í®fá}ÚöÏjfMiBÏ¹Ğú84uÃL¦ÜZCI\$‰2P•\r¨øß…\"+ÿ2¸n-~Cû24ª€à:œ2çÄ,è¥:ÈÜ‘ÕgcwGÒ¨öØÇƒè¦‡ŒhÏV“Ğö] \\ºŒÃê6`ıRŒ4=#xï^†1¿£\0ÃPçÙ…Íâ:-å8ŞoŸé¾~”oïv>Æ£mØ·ØßÕùƒ'è|ĞÑëøC¸Â<èØö¶Öè:G)M&WYQQi=Òğ\\[ya\r…¿²ÖB‘eÆ\\ÂóB•Ø7Ne}:àl•©Ãk\$44rÆq}\rP®ğØALa§C5’sƒ¨m\rÁîÈ Y©Î­&°Ò(ë ú ”²\n›\$¬jE%™^qx\rÆĞï—hW’0FuR„mŒJ:—Œz@:rğj7F5,wr©Á\n' ú‰iP|>‡8´Wøfm2 9H @›\$M’\$qX¦Ô¹!ü‡\r¡”9”0Î£R¨:\"ˆŒ7DÉ Şä””r”0ÊuÄ¢ÖÜŒJê‰¼¹àFFÓ<”‘PÂYÊeòò^)	8nÖLo2EÊ”®\rÂ1ä¼¸Ë©°CfÄ,q]N\08d8b*4‚J—îˆ\\MÍº’4ÃHl€ àRÜdÌ¯!aĞJ	¡ğ.šeØ5Ë€ËÎI0Ñ’Q\nC¨µQ.n^ÄàÉ0Iü£‘†ØF¬Ğ7<R3woMÑ¦weDš¥È4¢b7+‘‹ÓF»¦á>gŠ64Jj„`Ğt!ÁF¨öªx;©ÅmãÀ¸Ìd8oè7B·j]˜=SjÀÂ¨Ö*ªê¼0A”;¸¢R–ÙĞQFD1Á¢\"OÉín“É¼€Ï¨4ÃŠ¨4e±q\nK”*;9Hóä9@ƒÕ‰#Æ¹'ì«Y‘íéSócl‰anÒ.Í¶k:h\$‡„ª9ª¸¦Öd9É\rŒÌ1‡Pä€ÛqÊƒDy%˜‹Øsba¬ÆŸ£ø¢Êœ\rÀ¶£’ZÎRH‹Œá_%\0@Sˆ„ü Ô›¹w¡€77ER³Éjw˜M¤Pô°2@\n.Àa»W~íİÛêJH,—än¸ÀJŸé`o·¡Èà@zÃµoN|¥LƒÚ¨VK ·x	uºÁ3*±qK‚ã`á]„¡–AG˜Í¦iU¹µ°aàŞÈ³‹Qre\$[W\"@b…Ä¸U¥\rŠğé=.E¿E¨\0âêˆ}rœDH\"ImÇŒïÍutÏ®GPÖP¬Ì—8Á\0p¿D ò‡;ô¦VØsˆ‹¶(¤#æÈîR†uÊ–ã\$ÇÈË–\0cÏE”æB¡\nÌg¡Ú\0004¿ó	+Ş‡™ğ2c önf!>¢ÇŸ3õ]ĞJ35|G‰tTaU ïHi'ç¥K¬­ÉZgé¼Ò	#Í‘ˆ‡iV”ÀÏ…„¸’4TWòÂ\0É\"1Åİ•Q½ÔºŠ_>“}â>Q‰qrç‚àm–Vá!<ù²d¬´‡—ƒƒŒ9S›‰,v¡¨÷'íu±æykb]p¿Ûå—Mûy•I¾œ[&ØÉì\\©„š9GvÀi¼‡±u7¸ãE«„k‰^[×%AÊa;­H#t,¦kğ[–³Xİ‘½š5Q^yÅI}Û§‚Uƒ(b\rexó%KÍéÁÉ\\Œä”Å“¬ÕÓ+!Yİ_ )òeøF`É[[nZœ‰=åwnü¤_ù\$+\$ÑÉ#F—FjÚïicÌ•l™Ÿkë¸ì·ç6[ÓY„®Ám ·ààt\rQâ±x­´W%ºAØz¥@º‡ƒ¿ƒt\r€€4\"n,Ê4ÊŞCÉfaä|³óşvaŸGäÁtÅ¼úüïÅ„ıt\$? Y9“¿ı³ÚìHt¿Îy0G¯O¬Ø(ÑÀ§şü¤•šÙ<«ØùĞG¸W¶äÜÙj³ƒ¼W½R/—á_'û \\z%>júïë{Ÿ±ïZsÁ€¹ı?ÇıøÏçå“ğ†âße³V/§@Ù0:ûhú¬€ı.ÿFÄQ£Ö4j^/g]`ú	F=nÆ&ï&&¢¢je @p° öûëÎüOnú©ö‡HÉÎX*+„5JêïÎ\nŠŒ¼ÿPë€uf&ªKZ÷OâÉO€×ÌŒöïá…PX°fÇl(øúÒú@Ú“à÷šõÀ”€öÅpH{/¬d¹K˜÷0‚ıÜP˜“¬ü€û°&ÌÂ&­|ÿ\0Î¿Pd‡&æÎÁNLËMŠÉP”ÜmË	¯üÉŠìNU*)hüEERÜí@”	ãˆ8É-„<¡49\0è\r ¾ ÀÚ†\"ãûÑ/‘6 @ËCŒ¢ı\0Ğ\0¾~@Ç€[Ña‘iÀ¿g3(gcc‘I½‹A±[ñsà¾6 ïq`¥¨†šÄ¦\0fnô´É¬Ñ¸	³ÑSG¶\rñiqÊ ßOk€ÊIQhU1É‹\0\r€¿Qi£è\r+ñÍ‘ÿæ•)VÒñ!ñuIÊ\0r›,;ñÛÆàì)±¡\"Ò1 Qí\"éâÍ®N7“äY2%QÑ#C1’€ÒQ!Q™#ÊÜâêâBiC%Ñ˜y‡DÍî‹N!M<0¤.-\"ˆ3!1RQ@ÏiK#÷)Èi\"Bò’¡*ÀÆ”²c2«‘ç*’£+r§ò¿\"àÙePƒ2(*€Œ²#ò˜èg+2í,²½*2,R¬¡2ı,ñ0Í*2Ñ’É/2Õ²Ûq½À\$ˆ¶–±h\0ÛÒ˜‘‹?2R«2³/ã÷0lÍ’¿,’ğB è¶’Œc%ÀBÒ”8ò¿/³*Ññ4“&ét`äah{ï‚•3u7“%àÖ ó@æóŠn‘Ù6Q}93—+³`€Ór¶Ó…5à[ãFgÉS3s±Që:R'*òÃ&Qa<2u\$Ñû= ¿Bã<RU<±Ã“Ü¡óÙ6²S€àóÑ?2)+Ù?sû<Ó=€Ú”«>™9ÒJô@sç=SåA£Re·ASÿBsÇB´/>ó©1³Vq¸TI.qR_’3EØÜ\"e”ôYÃ\".3È‘‰ß\"Jq±ÙBÉ«D)ÌÖ4#\$aà «l·(·S±<4[\"Që¢êÖd0´­%ÓùA4£ô_qiCŠK±R0€Û7HI:Kjø àÉ2SÁA3Ùt³?ÓÛNTí\$âÏMos'	\r’™N³gPR½&È8ôéPóÇOR3Q23 €eHIR:\":‰R±#F”¨Ğìàè	ÑL¡KmSÀ¦Ñ*(ËÆ,Ôv8«2\$35V¸D˜3c\n0ôø“ôüBÕ&\rÃ¤+ÒŠ9õ0”ˆ:\rÕ8qATëTI*]5Jã0JµSH&fàâÊ");}elseif($_GET["file"]=="functions.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("f:›ŒgCI¼Ü\n8œÅ3)°Ë7œ…†81ĞÊx:\nOg#)Ğêr7\n\"†è´`ø|2ÌgSi–H)N¦S‘ä§\r‡\"0¹Ä@ä)Ÿ`(\$s6O!ÓèœV/=Œ' T4æ=„˜iS˜6IO G#ÒX·VCÆs¡ Z1.Ğhp8,³[¦Häµ~Cz§Éå2¹l¾c3šÍés£‘ÙI†bâ4\néF8Tà†I˜İ©U*fz¹är0EÆÀØy¸ñfY.:æƒIŒÊ(Øc·áÎ‹!_l™í^·^(¶šN{S–“)rËqÁY“–lÙ¦3Š3Ú\n˜+G¥Óêyºí†Ëi¶ÂîxV3w³uhã^rØÀº´aÛ”ú¹cØè\r“¨ë(.ÂˆºChÒ<\r)èÑ£¡`æ7£íò43'm5Œ£È\nPÜ:2£P»ª‹q òÿÅC“}Ä«ˆúÊÁê38‹BØ0hR‰Èr(œ0¥¡b\\0ŒHr44ŒÁB!¡pÇ\$rZZË2Ü‰.Éƒ(\\5Ã|\nC(Î\"€P…ğø.ĞNÌRTÊÎ“Àæ>HN…8HPá\\¬7Jp~„Üû2%¡ĞOC¨1ã.ƒ§C8Î‡HÈò*ˆj°…á÷S(¹/¡ì¬6KUœÊ‡¡<2‰pOI„ôÕ`Ôäâ³ˆdOH Ş5-üÆ4ŒãpX25-Ò¢òÛˆ°z7£¸\"(°P \\32:]UÚèíâß…!]¸<·AÛÛ¤’ĞßiÚ°‹l\rÔ\0v²Î#J8«ÏwmíÉ¤¨<ŠÉ æü%m;p#ã`XDŒø÷iZøN0Œ•È9ø¨å Áè`…wJD¿¾2Ò9tŒ¢*øÎyìËNiIh\\9ÆÕèĞ:ƒ€æáxï­µyl*šÈˆÎæY Ü‡øê8’W³â?µŞ›3ÙğÊ!\"6å›n[¬Ê\r­*\$¶Æ§¾nzxÆ9\rì|*3×£pŞï»¶:(p\\;ÔËmz¢ü§9óĞÑÂŒü8N…Áj2½«Î\rÉHîH&Œ²(Ãz„Á7iÛk£ ‹Š¤‚c¤‹eòı§tœÌÌ2:SHóÈ Ã/)–xŞ@éåt‰ri9¥½õëœ8ÏÀËïyÒ·½°VÄ+^WÚ¦­¬kZæY—l·Ê£Œ4ÖÈÆ‹ª¶À¬‚ğ\\EÈ{î7\0¹p†€•D€„i”-TæşÚû0l°%=Á ĞËƒ9(„5ğ\n\n€n,4‡\0èa}Üƒ.°öRsï‚ª\02B\\Ûb1ŸS±\0003,ÔXPHJspåd“Kƒ CA!°2*WŸÔñÚ2\$ä+Âf^\n„1Œ´òzEƒ Iv¤\\äœ2É .*A°™”E(d±á°ÃbêÂÜ„Æ9‡‚â€ÁDh&­ª?ÄH°sQ˜2’x~nÃJ‹T2ù&ãàeRœ½™GÒQTwêİ‘»õPˆâã\\ )6¦ôâœÂòsh\\3¨\0R	À'\r+*;RğHà.“!Ñ[Í'~­%t< çpÜK#Â‘æ!ñlßÌğLeŒ³œÙ,ÄÀ®&á\$	Á½`”–CXš‰Ó†0Ö­å¼û³Ä:Méh	çÚœGäÑ!&3 D<!è23„Ã?h¤J©e Úğhá\r¡m•˜ğNi¸£´’†ÊNØHl7¡®v‚êWIå.´Á-Ó5Ö§ey\rEJ\ni*¼\$@ÚRU0,\$U¿E†¦ÔÔÂªu)@(tÎSJkáp!€~­‚àd`Ì>¯•\nÃ;#\rp9†jÉ¹Ü]&Nc(r€ˆ•TQUª½S·Ú\08n`«—y•b¤ÅLÜO5‚î,¤ò‘>‚†xââ±fä´’âØ+–\"ÑI€{kMÈ[\r%Æ[	¤eôaÔ1! èÿí³Ô®©F@«b)RŸ£72ˆî0¡\nW¨™±L²ÜœÒ®tdÕ+íÜ0wglø0n@òêÉ¢ÕiíM«ƒ\nA§M5nì\$E³×±NÛál©İŸ×ì%ª1 AÜûºú÷İkñrîiFB÷Ïùol,muNx-Í_ Ö¤C( fél\r1p[9x(i´BÒ–²ÛzQlüº8CÔ	´©XU Tb£İIİ`•p+V\0î‹Ñ;‹CbÎÀXñ+Ï’sïü]H÷Ò[ák‹x¬G*ô†]·awnú!Å6‚òâÛĞmSí¾“IŞÍKË~/Ó¥7ŞùeeNÉòªS«/;dåA†>}l~Ïê ¨%^´fçØ¢pÚœDEîÃa·‚t\nx=ÃkĞ„*dºêğT—ºüûj2ŸÉjœ\n‘ É ,˜e=‘†M84ôûÔa•j@îTÃsÔänf©İ\nî6ª\rdœ¼0ŞíôYŠ'%Ô“íŞ~	Ò¨†<ÖË–Aî‹–H¿G‚8ñ¿Îƒ\$z«ğ{¶»²u2*†àa–À>»(wŒK.bP‚{…ƒoı”Â´«zµ#ë2ö8=É8>ª¤³A,°e°À…+ìCè§xõ*ÃáÒ-b=m‡™Ÿ,‹a’Ãlzkï\$Wõ,mJiæÊ§á÷+‹èı0°[¯ÿ.RÊsKùÇäXçİZLËç2`Ì(ïCàvZ¡ÜİÀ¶è\$×¹,åD?H±ÖNxXôó)’îM¨‰\$ó,Í*\nÑ£\$<qÿÅŸh!¿¹S“âƒÀŸxsA!˜:´K¥Á}Á²“ù¬£œRşšA2k·Xp\n<÷ş¦ıëlì§Ù3¯ø¦È•VV¬}£g&Yİ!†+ó;<¸YÇóŸYE3r³Ùñ›Cío5¦Åù¢Õ³Ïkkş…ø°ÖÛ£«Ït÷’Uø…­)û[ıßÁî}ïØu´«lç¢:DŸø+Ï _oãäh140ÖáÊ0ø¯bäK˜ã¬’ öşé»lGª„#ªš©ê†¦©ì|Udæ¶IK«êÂ7à^ìà¸@º®O\0HÅğHiŠ6\r‡Û©Ü\\cg\0öãë2BÄ*eà\n€š	…zr!nWz& {H–ğ'\$X  w@Ò8ëDGr*ëÄİHVéŞw8ìJè\nm@¦OÈ#P²Ï@úYp²ÏÃ¶wàÊğÀP\r8ÀXë\$Xü Pİd–	ÀQ\0Rx1\"T]\"êĞè Í	°êQĞğàÀbR`MÛğà-àRSE8Go0 ê	æd‚B^±\0ÂÜ\":ÜmN.Şj%ß@æ3(ªx Âl ÌÅŞ	‘€W ßåŞ\nç:\r\0}®@³qm;@È-¢Ş¤Zôg.zFÂf@Ì\rW®Äck‰Œ ñ<	é0‡Ëúz'4\rñ­\0îjELYˆğ(ğ%€\nM‡ÄDÃÂoFøB¨q‘ÖKg²ä#ÄZ¨¸³àä\"\nçÀĞ®ÅêhŞÒ‹2-n§\"jy\"¥ê§èşì\"÷ğgı!,Ä*ŒTù x¢ÅËPú‚5%Làèò`¾LÖM†¬@¶ Z@ºìÊÒ`^Q0R%9&jv‘häX ğoöö‹G#æ’ö²DÙòHùKÂ¼lX¼ï¦Í-äû2hWli+æ&ÄÕs'rzìàÉ(„Òˆ‚ò¼¿%tKå6ûrâ¶ëràïáK.î¢‰Â‚*Ğ,*vbgj#²óLÈ®v®Z‹€Q\$pÜn*hòÀòvÂBñôâÀ\\FJˆX%x f\$óA4K74 a#¤¦3\n¨(|°Z,³e2äl\r|Kû0Ğò¿³¦ÎW2-m)	)‘¾Z'%€Ü	ªè7å.›*í*\0O;’®C¥*¯—\$ËA;’VÌò¸ë‚(€ÚlìØt‚Kã.DÆ›_>á:¥v¢3Ÿ=dö\$Ræ“ øSlß7ˆºB[ì!@È]à[63zS…e>sòr„Dz€í;T0²SÁ*ïCË+oª\\\0ÒÀ{D´Ükè€z@·= »¥·Dª4Vç‚Ê•*\0Wÿ³tÿäv¶¥yDÌ-¢5CŒæ3•¾…ıD´–t”›!’_ U”XL´]F÷Fn—F ì&@%b>cˆêPÜÛIö)3<’@ `ä\r“55Ş%¤/3Qœó@Gó5\rÍÄÑ±T£è,§ŞEÍNÈ&j\0ÆhÌ¾\$Üá È353‘TB'FLâÀ¦'DäñøU#±LÑÉPm*Ñ \\\r@êò@¨)íşE­ÓUUU•]V†ñïŞ`‡MµÒóRD³FV {4Õ`3U4•‹5§‚#ÃT`èQ(ğßµq7M÷*@SVMÈÄ¢#ê~ƒ2 Õ´Ñjl¤@·\\ İ.J|2“U¡\\¬º Ëv·°«\\b;^\0Û6x·Î‡]ëµ^uøîõULµZ§å—MPÖ™¬4Hû9µ\$0å3Í'VuTõ@ƒKW•|ñ/\$J*D´÷]î	X“·_pªõšŞ•Ñ¥ÄÕ²uü¤I¬Ü…zä¢®ÀÖr…Ş\n€Ò%¤8š“i^Èò»U¡15³n;I\n§R­Ÿ3§ÙQU45…5`z€ac¶­b°`qOtÙNu 6)õTÿ¯‹jµ“X–´ReÈ#ÈJ-„S@á\"U¶ëÀÎÒCÊUUß8³‘6Ø-kií/YÊ¡ R\$ğ¼!·\rn×[6Vİ­íqÕ€Ê.åÎB‘¢°¦cp­pps!\0»Ow\"çngsôX³wGiÈ{Z\0Su*k`”ÎÖa!Qo'd òx Caö ö¤cë!ƒºŞ60P°\rÊ‚‹T¯ÒœµËú¦ï¿,jÁ&ğ@Êƒ( OA€æP÷T¯jÕßGhÎ»b¶¯Ì\"%°\n‹qX€z %‚ÃÅÈÎëm~@Ï~‹r¶ÖJnWâ~ Î	¨]RXûFÖír’ÍxNmHp ñ+@Ñkl#€Û\0ËívÔX&…Ø,iÍd¥zÔÓ\0äNıø~wêü¸„×û€Ø\0äWá·ı\0ñKNÆm†	0ÍpÓíB×¥Ó'X)„`Y†e±‡XyI: Ë`dÑ t¶\nÚ('N\r€àHGuKše¨\0Ÿ€Ä*3’æ)n3Í¤ oä“Vò}vö¯ô¦æN\\°ØØèÜ1i)\".`t„>\rØÛcÈßó—fãŒoA—©\"×­±³ É OyYïFÒ\rá[5BÂo*/t“(ÅÅ%²úR[<òï8V‘“\$AMï¨¬5¨±9'*ŒX¤úö†‡ğÜ…ˆ\\†æ\"jrDÔ\re·ˆàX|ªê^©n#‚dÍ¥lÙÇn‚©¦ªM¹¦t€~\\…Í›\0™›@á›‚g=Ñ2¬À‚.†*\0@Ô'9¾—yÚ ™ß9æ dæ	£zq„6ò€]œP~\n€ Pì:‰Ù<ƒ¥œâ DY„:]5[[¢'I¢—ËFùö…º\$Bâ<“P’P—@N”0/Eú:^ DÈJw¹¥\0€_Cdz#¢zFW4(Kú{¤U[¨ı{>\0^%ĞM@XSÚ‡£ZŒSlWº™¥…wYº Ş”\"B*R` 	à¦\n…ŠàºĞQCFè*º»ˆYÌÍ§e‡Æêˆ+âH¸j™\$ÕQ À^\0Zk`îªV¦B%Â(X**2šÍºèº»®æôN`°ºê| È±„-©“ ‡í³«~8Zæ Æ‡Rz2\"È	Jî4›S~J»&tŠ¾e‚m¤Và}®ºNÖÍ³'²Úrú5f.&1ùÀ›jâğ‹§§úK¤åm¹{‰¤`º†w Ü!•^#5¥TK¥„¹Eâhq€å¦\$÷ñ®kçx|Úm¥:sDºd…zA§Ú‹?…¾ºˆ“[ğLÒÈ¬Z²Xœ®: ¹„¸[(!‡k¬X²V¹yƒ¾° ©Â“­ï\$\0C¢9ˆdSi¹in‚ {`”\n`	ÀÄ|K Â¸:ç»5ä»º# t}xĞN„÷»{»[¸)êûC£ÊFKZâj™Â€PFY–BäpFk–›0<Ú@ÊD<JE™ºi0“5Ãø®•T\"¬ãVhº¬Á”ÄNÌŒ“HùWDeSsŒ’ûNŠô\0ËxD²¸L1„ªë¬<!ÎÔ\r3ÚÍÅqd´öK3…P”ÓyÈÔë¢E/`ğƒPz€Ş–\n ùÏdYÏ¼şš½5Xïı8W•ÑI8w[7Û³`ª\n@’¨€Û»Cpš¬¨PÛÔåƒÕ=V\rıZ{*qİ\$ R”×Ö“ŠÆeqĞ¬Ä+U`ŞB¤çOf*†CÌLºMCä`_ èüü½ËµO\næTâ5Ú&C×½©@¸à\\WÅe&_X_Ü».·8œ4d YÃ¼œ‰Âp\$ezAµµ[\$]ò<]»|`,\rul\r5áqpÊdu èéˆ±ç´Œ£ö¯ÀYi@û¥çz\nâ¨Ş7ßş;“È€‚¼­½Ü7ßb'¼dmh×â@qíõChö+6.J­×W¶Éc÷e]ó‘eïkZ‚0ßåşZ_yŠè‡fØpc8&‰©æÍ‚üœz\0„EØÎÍ7º0€	ŒÓ\"ö\$êÇ=‹İìÅ!>úæ€‚g7B-QÆ/e&ßÆ‡­6a€˜p\rÄe3›cÕNIjn-Ä\$*x-WVİjõ”@oÎ#wó5óˆ'OÏ.œöÇMÇÙˆ\0èHøCÖ9ïÚÀ-míP™îƒ8S v!Àè;gtLŞ5,	ñ€#¿n# •Ş‘“x-7ùf5`Ø#\"NÓb÷¯g˜Ÿ£ö Üeübãå÷,7S§¥òGjÙíoÕ‹F?ÀTŒ6ƒİîËmÄÌs‘š€¸-§˜m6§£q‘œ;‚dl¤ÕÏé0fE€8ô]P'X\n›ÿàMGï–\0£Üx‡\0É5¢€ÂÍ*Ä#ø*à1>*]È–Ws\rœ®,¿’àÀØ\0öO–,q2Íj•+H ÃŞFG€º³E¶>d@bÑ÷±¢Iz¡aR¸à8@7¡LB¦åş‚H‚ ½è¦A¸Ë³Ép¥p@Ê	 d¨kƒz4EƒA‚	Ã‚ƒß‰ºóWA1\"À2bGk\"£\0ÀdƒhíRD¥p !fPs3`FÔ´¿e	OkLA¦Ó‘C—/ ´a@|@¦²€:!âƒ‹á˜‚»…o‰T/b¼“¡‚Èá¤lL8èˆDjÊ„öë@2ºÙüÎº€ƒìENë\"¾1ÃÈzqÂ,\\^ãÔ)8V°½qÓÁÂ1	â<í'4ÙÖÏÌÊäáC!ÎFš…´4 €f‰‡t cº†±µÂ\r¸m—z¡*M¦®(ÁƒA†¸†„÷À2Á)’Pr¬ÆŠà²ˆ¤45	 Î\0Z[dá9¨hY‡ »ˆŞt1e¯EŒ\$o`ÆX ¡gèUd\0G¨~DR<èÒhUp€y¦“=­T(‰DZ-bHÓÈ ú‘ya¢H²¯°lb¬b(œâHLÀú8e¤sC«½Ûe³I¬=Dğë{ĞĞŞú]È<ÑaâœŠQ=Tû\$!CáOÙ¾UèG²â)ª“Q¼VÃTb\".\r­Í@<)‘o¢`œV\r0q—j‹s¡Xˆ¤F\"*åbIùÚ¢|øÄAˆ hp\\	²‹X¨j#ˆbË#œ©ÅO>5w°?TóÉ¾;öÁªlò1aÖc\"t5v©Ä®Á¾`‹x\\CM=ib„¨!.¯HLÂmâH–ÛÒ¬ãñ–%+¥£ĞD4FøÚ¼Ñé£C©[KX}P¹  >e:V¡t—;ì#Ñ¦„Ä&‡Rñ©‘È´p’,aË˜ HåÆœ·ÑÎDt\0é\$qŸµñÀ/t›õ–~‡J›¥·éî`Ãö,ãº¼¶‰]ÀÎ`å%3®>Ş¢´@N­Óx1,ö¯ªùrÏxr):ğ˜8ÓäÀˆˆ 0†Ì‘ÚB«,EúAˆò‡íùåàBá0(•üÈEùã8@Œn[	(–ñåhídDÙ	HR£Q¼†^µ!± Èv<² „„‘6œÕı’Eò\"œ&ç…¸ÅV(GBü’UªËé_¦«ûHü½sÛ@Õ*BN)QH£ˆævTG‚Æ0ùhØRÙ¥Ù†+õ-Ô&TúCó?ÀÀzd\0\$¨bSÚ¡<ÆãÜ‰Q„í@º P®ÀdpOÓ>+‰>x|Ì	¡Me‰EˆùR€4 ‡k(W{´*-¨G\$ …È	'Òj\0œ‡H½ü¥¥	(ØÑ™>A%‡YêÏÀÊ´ñ6Évò«£ÇŞ^¦K• G%2ÌEdÍ”<öJ¡#ÀDE{0\$…T+ş2T%Š#&ˆŠW2Íe³ä¹\nSä§†Lã–cšdÇ—²°hÀ=–ê|e²\"' ¢[­¼óa2#%=ËuÉk©:6É,ÒüKÎ\\’âd¼È—YGr;Â·–Á=ÀØ  ²öLÉ´XyVšh*…‚ŒO *»ÍFšˆà-bK*Š#‚†‰:.<ÇRY\"EU'x3eQÁŸÚü©”’qÍ@>™bK®x‡Ä4e… D¥G?!éáN¥xk©aŞ4@/¡˜\rc0Ò¬ÀD³!¾ @ á;€D9\$:·”&€ “Wå\$ÂÃR5ÒÚ—HAŞ2o=•@=›:œáÅ\n%ú¢ü@og”¼Î³]¬ótT¹&ê# ¸ˆÈqU™øf‚æc@ùÓ|BW&ø_‰¿¨Î\rÿR\"(L•zr‚s5*ıT’¸™ -5\"ÉZ74È%£ñ\\!yÎ’„7Kâ @Z‚™Í/v\0/I´ÃÖ¯‡s®ø@äÀ11œ& -FÁşÀ¸5‘DÎöAu;¨í@[<‘HO.y³Ÿ@ZÃs™	„æÓ¶A™O\0ÊòœÊ´§ĞIîZ{Óà0ÄøçrÔ’Ç¡DP°'ìô©ıOÄvß\nœøB?iòÎè¬@#[HƒBé!~P>x!uøEø.\0¤à(wIE1EÏİÜ /è\":\rĞu|T Kyç8[N ?¡xgPÁ!õ‚ç;uÃNBTúÎƒÉ¡\0Ä0 6€¼\r`bhE\r\\™CpĞøt@¡Üæ;ÄElâ{›(¥>1µâŠÁ*Ÿ°\næÄ)ÒMòCÊ|@·¦`¶i\"š\\ÛKFÉ¥…áÂ	|Ş(K4ıgJX˜iBP‰'˜\$²Û>q1Bæ¶Ş	ÔNáºxXc×ß§Åª©ô,Chìy(Bˆ¹7S#\r!H0Ç—‡9‘¨˜ãÀMJT.0ÂĞ)ZD‘òåB?°üˆ-v¥¾q*”İ,JÄ<bÁÕÍ&˜ë˜İd PÆòKG;Æ y”ã	šÄ#>)íiÈ‘iœ&Èœ8]*CÍ,Ã´ò 9¼’\nhW\\	’iM 7Šˆ!Ê—9óÆŠ_–¬,Åò9ñ²Š©Ã\$T\"£,—)51v\"Lf&á»-àé”9>y¢ üQBJ‹J4±û\n»,*0¢Pšı–‚g6yw”/M‚â\n<”B¨i.F…öş£ã2dñBärPê ¢‰jjwi¢âÂÔä.·ƒpI\0æ <“xVŒ¢,ˆ\nCúSºŸ—ª0ÌP¸„ÅPÑäŒr+ Y€x#'IU e\"ÔcQµCª¨˜‚´à€\0*%Ä \"’ PhUr×¬iècì,5V–ôW@-¯l¡ÿ_¹×ô€=Õú«Š­¬\n4‹èôà’rU!«ºF…ğ‡ª»©µ5ÅÙY¢ÑÀO5!{+4)OëFeÚÏÉ¬UVShğk†*ÆV§_Â\"†¾gzÈÀîµìs¬jkë/à1Un¶ˆ­•aWó[zÉˆ¥\")dŠFØÖR&7«âYfÈ•‹ã	-2Œ¥r_I<q’Ÿ8Òõ0±)æp™P	œôƒP½Ô½0rYŒBcD#·²›\"—Ñ#Ì4R:´í\$…Şò^UÇS&ZIûnİW“mKÄ”\$ª¼+#zD+ğ¢“á6ÁÄdv ¼Bbœa41d@âŒì,1	‰nÕû	„¦4¸)	ªt(¯-u*¡#Û´¬[N2…ÀP\n_)|4H0— ¾L\"æÛN€Ï0ğ&\$	`Eà€ŠÖ°,B¥í_\\x\0Qb^Ù&Éro#Ù‚¦ià&¶nà%6{–˜&•L\r'#ØF…§`Ñ J¤±Å†lÕdR€¤(h% x\"HC·K°? v8KCPÂ Q\0ù_áÀá#…P)ia\nºH%„Ç©zzVci\0D(DV5QÓ°Šobë'è\r–2Q½›FO`BD'¤x)é›½¡Ë~,@)}X¶r³PğNº7šT¾ĞÓ<Mš¬‚HÛ\"'¬7Vn¯’ó”€!=X „ØìÇ §¦È¶Å²\0Š,„x[X,ÆÍëØ²Å¦”ıÈ®ı•·Æqep5Úàà!>\nSCDà\"A\0œÉS¹Q\n”]ó‹,µ-BdÆ‚=†ÕST>ZÀÂ(\0/‰ìVlà¯.q3°ÜT@\0+¢;kÃMDÖÓÀ\n¬¶‘ñqÁ§Ô4ŸaÀyTÀÈ`\"Ì5¿ğ²É59°|@`&Ï´Ğ:RØ‹’\n2Êv”¶Õ.mAŠ`¤TkãŠ|ê|2ªL”û)ÜÂ‹\\Ëû <V•Í3qê#C‘—öD2©ˆ–©hĞ3£Èˆô½×¤,`‡0–:èàeºK®™]Ç4R>L‚¢g\\Ş[0ì Ë¸qÙàÊ¨ü*´—V¥áVœ¹Š]r0·q0	îçt•’İŞ·O/\$·®¥›¾;2ê—¼‚L;+\$‰ ²lµ*ÜÅ˜íJ÷»C\rn¹{\rÕƒ€r½;ã<Å°8Uˆ!—»5`cä-“X¼ô#ªƒ†\nˆ€kÜß“\0:¾ğ¥^IˆÂ§6ë!ky‘¹‹*«åAQo@uá½–`NÚÁs‰‚¡'7°F&’áû©ØC£´L¥†:è÷ÍRóÒßní(ó%Û„3¦æÙ¤ë°e¿û¦px`µ§Hb·l¾*›†E€‹4pÉœÀi{°xö°s˜{¶p5Q†¯ÚLq¸nîĞ&Ø™CÇ\0§7²ù\0¹;[¥\$Léjì@:º2²L¼â{Ø|pTRæ5¤Må7_DÉ\n÷b’pP\0]ÁÊ>ldr5CCéeq2Š*]ôŒ^0ènó	î•nKŸà@ô¯|i¸/Âªƒ®šìoÏ;MKïô ’š±Æ¸k}yùÏ[†ßk\rW[¬³\$ÀªÇ\rı^u³\nwH7ö\0´ğ^a5-R'!e|Rè%¢€¬\nıpw,²]~¤…¨N&;QS\rÆ—­Éiy<½¤ -Ù-ì0ú0¹ mŸH#‹\nòqFà!±2±N=Av«4W˜°sP@d<Ë“*1”*B,˜Y™\\àw:H¡ÇƒƒõòTèáU¶z–'TÆÚéĞí‹€e©‡OÕËÇ_%©q(oH»(£š¹Àïqò¾kÍ€*o¥âP¿w 5%pëê´ŸÀÔ¾|hÛi=wA™×ÃÚúÒàÀu¸@g1÷P\\‰\"÷Fò:2,ä}}çâÆ¨»jêÜcãXV iŞ9H—cü–E¸£NRRÓ“‹jV‡rpv«¶9R?%ˆÅ¸\nn.\0»)à?±Ÿ¬EX(/%.ÅÁşv;€ºñîOw+Êóš‘3–[­BÁåGõúIº{ÖM›½p”¼er\$ÊR¿\$o·æ%)3ÇWéÒØ°Axé`¶*†I1İ#³ÔŠ‡ô 9pRÙ'c\0åüÎ=º­)J_,Îâ™¤=ı)HìÀ^W4ÆÏ–Áõ¤ÍšŠ§ä»´¤Îb1˜êaÒB!:Â@˜4Œ#ÿ6òevh³†_“(ÙÀã™Ç†n\nv“Z €’Ì¦e¨=™Œ8nÊìJ>mĞø„¢G¯ÏÅé{³^ÅYf+0;w–vPæ\$@/áÌ#5/Ï9és˜—û8ˆï1Áş)ü0ˆE+ˆ	ü‰ÅªòŸRˆ ˆ†ÿ0l¤\"Üä&ÇU®â7Œ ÄËuÈiB€2™hX¯Fo +~•PÏKÍÏÎpAƒ#Ôñˆ÷ÂV%©oZp6â9ÎX÷ØÍ™l^%íØ`GÊA‹*Œˆ´ŒU—\n„\nJ{ì¹îD¨Ç®qÉrš\$8æ‰®Ñ,Ü†Õ\n6Ya¤…ÇŒNzª.ƒ×(·ñ\$Nñ\nGö‹4Y}½pZˆŠ?†@ëè¯ê­Ó.Ö­6é’)f[öGo¨%GêºˆŸ€Ï¨\r®Ì9rš–¼ã¾^©†©ˆÒ°ãïmˆR€É±‚\"†V(Ì×–3å\0Àdz¦Äƒ*€ZlJfõ«ía~l‹@²U|x>8±Já¸5p]§2UÎ/†˜¸Äÿyk»è‘ÅÅÇ§‘< <ÚqÓ'}aªõ›­gÏgZ'jtÉ+lªÔ¡G„±ÒAÖ‘{µ¨Âû_k„\rºãÎ·3Ìl”×¨D9ë×ØØØèƒçKÉB%\\Ñ—VÉ¿ôÄÖ8Ò<øçŒ‡KµğAÊ!wV»iÓ:.L–¯Üª_LNgËxZ9¾rWy¬CîìbòÉéqğw#q L„HÆö©èÎ\0C­p©½1úÁ.×»õÊÜ\ro>[`j>Ø(@F6-’@ì¦Û*(>Ë@Y²úIhÔ\rë©§XÎHğ>N¨bÀctrn¬Öx‡?X%%¼vx€Ç{5°l\\€yÏ¦¼6tta]ëw–0àÊ.İ¡L‚C¦îÚ6ËöfÑ&À%DÛ¾ÙB0ò§8ì‡`»m¸Gk?ı¡íÏeZNîËîu­İ³îø^q\\­Ä!€+Èêƒe©Æ\\Z0â@ì»¢f`µ¯ƒBè½˜Ï`*zÛ¶°o\\%ÂiíšgzAÌõâ†íÌ^\"V•GÒkÓÍuk³féîÕ˜oÍ7‡¦9ê;vº•Y‰`.ÎÑ`ìÒ{×@P•Ùá„&	ÕTÄ![£\n#™l™™‰ZìûİF”œ‹„=aìiHÈ›Öß6“CS,p7!˜{[ëBª¹TÍ†;Ÿïd“\n›N[k‹;\0°\"yP3§£`.œNùQP¡ÀT(nÁT#“—±àFõ¼o‚\"!0Ğ¸ûFÄ!É]•ß‚Cƒš#éJ?áÿ—t[·çºòVt 	ñßw.<O k'kBOpd#ºÊÙNäÇ†@ñª´n¸ïd\$ì§f\0œ„U%^å‚»”–H§Ê®Šqu(EÌU½¡PÑÂËñ»ym+¤Pîn›@~G»\\†px(ƒ9~)€¯ô	jLæPLÄqò„bxjxñB)İñOäÉ« \nøè”Œoµ:Nß†ü‡(]%ïŸ’šPÊ;Ìo’)•ÏKFv\njz†Li1™Ò¡/fônÎØ¬'0´b7PâÇDdc30:Œl	S±_n3eÆv¨ˆ´-¾ùõ·o”(õæ!b(&¯*wŠ˜°ºl¶³fÎg·o–Ûr(w6SãSÎam˜•ÉàAT‹®bœ«²q,£@ğ)	Íkå’ZÏºĞÅØ­}Ä+æäÈ´`RNuÏ¤üàpwz^wmt‡Šß+\"IÂÆsô!F@è8AJ|Ds ».è¯;L0\rÉ£cr¨nèî€!ç¥ÔËÚWRÁÒş\\Wòq|åéÇ~n¼ÀwÒÖYE]–­`„‚d³NËÍ{]^õ	¶ÄY«µˆ¸rA&UuÀ|p–®f½u6ŒAqå(‰«ÊMXtGe2¦x‘·S\"·B2	:3zº4\rW&­¾ê(ÍÀË7\"ı‚P¿zÎJXV_ÒZ!åÊmto­Îì\r£–8 ã£\rRZ*€ê‡r‡ÉDÀZB[Té@lĞHÂ2Vh²W¥L˜Ò6\\:rÉİò&¿(‰eúm«îœ½†//º¶°JG³”hiöÃ:}Iú	EÜBQ#Ù›ètR™Ó€é²Î};e¾øS(œÛo÷²úZìÏJe€,Öe½“]Ÿ>	{F+^ÒË#Ô‡Ì.¹f’×Sæ•6ÍÏl†ÿsäÍ'Ék¢[’‹Û¼Ğvõ9eâ·±bRŸšY-²–‘|×eJK\$É^³£ø¼ùÑjWz{Ö–ÁEwºòhÆÆ{‰Ü\n‘w=}Å„qäHÑŞİrÙ!!c‰‡¤ìX‚ú]Ëîf&\$l§ÏÚ¨Üä²1½êg)’ LD;öwº}Á4‹'»¿’^W…ÜÜ¾ñuŸİãŒÇ—Ô±®Ş-í•Ja*º~!á’oK.Öå;wP¢p©Xõóo_Ã¢_“\0Ôì°Ö~çÒ'ğÀîÕá´?¡ÔBxIGÌFƒÊG‰èô¦øYíü¨¾,*^g j\$W|¸X¾ÔÂÂ¤oIÁ€D' XXùšğ/„‡Ë3¾ı%š5ºçCÇZzÏÓÙ¹`áe1°^IWw2ùÊTè]ãµµøí}ƒRŒ»a‰Ö-şğ ÒÒ“şöĞ·Ï¬~è~g{é…ëß¤;ËèJW†k-á´;ù«3®,g~G’UWx±™ˆöa\rÓ	\r/\0Ÿ›Î³»õ¿{ÛBÖ±d¶µtb_XÓa²ÁA†l„÷Á	hhñ!w²Ê+h1#+h0\räi(Ø@Pê¨Y‹¨ØLf˜Ml{Œ(±€È 3r¾e(è\r‹*¢;¡_ïçZü×®øT>\nŸƒ’¤_6,)&I>B4Idm \n^>MàĞ™¢käxLo(D@¾:F¯¯—9ªYWÍFaó«+­\"ù\$¨·â/üûçX~(¢\$‚ÿ¤†œ\"0#ú1C´k¡Q3§_nGëöQêç”zT)¥Šğ™*“ÅtÃmØŸT\0¨Àaz›ÃæBÂgÛÅ±÷“ŠÔë÷Oï‘~ë9½.¦Ë×³¾JW*ÁÙ5¡0	ÔC@îPË“–ó\"Âcğ:Ñ¤wm©`O5Kÿúy+…P-¢é`\0X›€9<†c§\rõ•,™åŒ&€İÿì„@G½Ô)¥Fˆº^t”µ8Án\næ¥eç	à7ëÿZ¡\$Ïñ;EÂx(Â¹?«€o­ƒ³ˆ ]'®5m—öKp‡PVßÊ\rÃfäìñØ<îÅU‚°?›­ô¶«*%PÒ‰dHÓ‹ğká7!½Wûö-HÎñ+0ÿ¡>äÿ‡èšÈm`ß6,ACÔ21EäşºCª|gL”P/VIê(¨SP\n\0¸§aS.R€òAcáê°ëåÑ€·\0šHÁ²¿hwPÀ/“œÀ‡\0ºÔÀ; èN+‰Oè¿âxúÆc¾vˆ ·™>\$.pñ 1xhiÚ=À¬Æ\r\0kMÄ6Óü :@¨\rÀ˜ÕQª'˜EÚh@`“” ÀÂˆPØ)ƒãæC‚v5şÍ%¨sĞ5) ğ;C\n02@Ì	UP0€[H.6”£ñaÍ@ãD¡ØÁ&ƒ¤\"7ÀöPÜÁÍA\0 ,@:\0eÉ‚57äÿáIz?ô!¢Ä\r@\"ÔğmxĞ\\À¤³Ì\n=ÄC¨\r‰ÚVAk†¯ÀTô…Œá	«ïø¿Ô‚0d@¹`g {¬£À¶Q,íI‚i«ğS dDR©ãRš¾}¸kàÃ‚h	´Ãå@ø°«É9N€¸°E ŞÜĞsA¡<À>·å«t„]…mp9ÁùÔé9=¨]02†\\„Á‘ÁÃ8rU„`2²\n÷³ôÿÄ Ò¿Å\$°M?FXóIp…Á‘		Äx\n\$ıi:h2•.¢0}°‘¿¸­ª°êÜ1t\$må’\né”'C[*û;Oò?˜kşØ\n¥\nó€.0‘¿»	ªXN)›)TP›‡tI{C¯1\0VPM\0WR¿çÀh\$Bp\n§€Tˆ´“Z|-µ\08\\+ğ†ªH_Âdbâ@](.³ÂÕ\\-°´‚‚2ÛãX¾4uËàBj	4ÕBåˆ/&”ŞƒúÀ§˜£ S‰¥\"ŞD\\2H’4hğ¬Ë8öX»Â†T!\0eï›ÂVIĞb 1!qà€@ïªød\\@ ! 8\0’ËA/Ô… ¾©:kİ•.ØCASòX™fÎ¸ªøN˜¾ŒÁ…J4Ÿ&!ácÌ/\ršk\0°81v€CZk×a/€Ş‚øN/€‰Jd&\r(£Ú5A©¨ş`ĞØ¬fü˜!Kà:GrÀÜ˜°#¡¼ğxĞ ÜÚgâÈ¡ ˆ ¢(€’4ÊÜ;ğ…?ÖXxqAÆşˆpùòTòuÁ…‚ùpØ‘’*`u©º.VÛ‰AÂ . hKêD-ìC ŒÀN€èr‘´—ˆgP\rãÄ	Ì#À:D#\rğğï¸”à\r\0D*bäBäe‘‡Ù\\‘‘‡[( <§0BÜ/tG÷ğØÃ\\ø€¼PçÃh%ÊBÃƒC„73·B‚¥\\•—â5C®	t:ĞØ·(c\0ˆ\r@<8ÍÊ·6©ºdC CºèËhÉ‚‚");}elseif($_GET["file"]=="jush.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("v0œF£©ÌĞ==˜ÎFS	ĞÊ_6MÆ³˜èèr:™E‡CI´Êo:C„”Xc‚\ræØ„J(:=ŸE†¦a28¡xğ¸?Ä'ƒi°SANN‘ùğxs…NBáÌVl0›ŒçS	œËUl(D|Ò„çÊP¦À>šE†ã©¶yHchäÂ-3Eb“å ¸b½ßpEÁpÿ9.Š˜Ì~\n?Kb±iw|È`Ç÷d.¼x8EN¦ã!”Í2™‡3©ˆá\r‡ÑYÌèy6GFmY8o7\n\r³0¤÷\0DbcÓ!¾Q7Ğ¨d8‹Áì~‘¬N)ùEĞ³`ôNsßğ`ÆS)ĞOé—·ç/º<xÆ9o»ÔåµÁì3n«®2»!r¼:;ã+Â9ˆCÈ¨®‰Ã\n<ñ`Èó¯bè\\š?`†4\r#`È<¯BeãB#¤N Üã\r.D`¬«jê4ÿpéar°øã¢º÷>ò8Ó\$Éc ¾1Écœ ¡c êİê{n7ÀÃ¡ƒAğNÊRLi\r1À¾ø!£(æjÂ´®+Âê62ÀXÊ8+Êâàä.\rÍÎôƒÎ!x¼åƒhù'ãâˆ6Sğ\0RïÔôñOÒ\n¼…1(W0…ãœÇ7qœë:NÃE:68n+äÕ´5_(®s \rã”ê‰/m6PÔ@ÃEQàÄ9\n¨V-‹Áó\"¦.:åJÏ8weÎq½|Ø‡³XĞ]µİY XÁeåzWâü 7âûZ1íhQfÙãu£jÑ4Z{p\\AUËJ<õ†káÁ@¼ÉÃà@„}&„ˆL7U°wuYhÔ2¸È@ûu  Pà7ËA†hèÌò°Ş3Ã›êçXEÍ…Zˆ]­lá@MplvÂ)æ ÁÁHW‘‘Ôy>Y-øYŸè/«›ªÁî hC [*‹ûFã­#~†!Ğ`ô\r#0PïCË—f ·¶¡îÃ\\î›¶‡É^Ã%B<\\½fˆŞ±ÅáĞİã&/¦O‚ğL\\jF¨jZ£1«\\:Æ´>N¹¯XaFÃAÀ³²ğÃØÍf…h{\"s\n×64‡ÜøÒ…¼?Ä8Ü^p\"ë°ñÈ¸\\Úe(¸PƒNµìq[g¸Árÿ&Â}PhÊà¡ÀWÙí*Şír_sËP‡hà¼àĞ\nÛËÃomõ¿¥Ãê—Ó#§¡.Á\0@épdW ²\$Òº°QÛ½Tl0† ¾ÃHdHë)š‡ÛÙÀ)PÓÜØHgàıUş„ªBèe\r†t:‡Õ\0)\"Åtô,´œ’ÛÇ[(DøO\nR8!†Æ¬ÖšğÜlAüV…¨4 hà£Sq<à@}ÃëÊgK±]®àè]â=90°'€åâøwA<‚ƒĞÑaÁ~€òWšæƒD|A´††2ÓXÙU2àéyÅŠŠ=¡p)«\0P	˜s€µn…3îr„f\0¢F…·ºvÒÌG®ÁI@é%¤”Ÿ+Àö_I`¶ÌôÅ\r.ƒ N²ºËKI…[”Ê–SJò©¾aUf›Szûƒ«M§ô„%¬·\"Q|9€¨Bc§aÁq\0©8Ÿ#Ò<a„³:z1Ufª·>îZ¹l‰‰¹ÓÀe5#U@iUGÂ‚™©n¨%Ò°s¦„Ë;gxL´pPš?BçŒÊQ\\—b„ÿé¾’Q„=7:¸¯İ¡Qº\r:ƒtì¥:y(Å ×\nÛd)¹ĞÒ\nÁX; ‹ìêCaA¬\ráİñŸP¨GHù!¡ ¢@È9\n\nAl~H úªV\nsªÉÕ«Æ¯ÕbBr£ªö„’­²ßû3ƒ\rP¿%¢Ñ„\r}b/‰Î‘\$“5§PëCä\"wÌB_çÉUÕgAtë¤ô…å¤…é^QÄåUÉÄÖj™Áí Bvhì¡„4‡)¹ã+ª)<–j^<Lóà4U* õBg ëĞæè*nÊ–è-ÿÜõÓ	9O\$´‰Ø·zyM™3„\\9Üè˜.oŠ¶šÌë¸E(iåàœÄÓ7	tßšé-&¢\nj!\rÀyœyàD1gğÒö]«ÜyRÔ7\"ğæ§·ƒˆ~ÀíàÜ)TZ0E9MåYZtXe!İf†@ç{È¬yl	8‡;¦ƒR{„ë8‡Ä®ÁeØ+ULñ'‚F²1ıøæ8PE5-	Ğ_!Ô7…ó [2‰JËÁ;‡HR²éÇ¹€8pç—²İ‡@™£0,Õ®psK0\r¿4”¢\$sJ¾Ã4ÉDZ©ÕI¢™'\$cL”R–MpY&ü½Íiçz3GÍzÒšJ%ÁÌPÜ-„[É/xç³T¾{p¶§z‹CÖvµ¥Ó:ƒV'\\–’KJa¨ÃMƒ&º°£Ó¾\"à²eo^Q+h^âĞiTğ1ªORäl«,5[İ˜\$¹·)¬ôjLÆU`£SË`Z^ğ|€‡r½=Ğ÷nç™»–˜TU	1Hyk›Çt+\0váD¿\r	<œàÆ™ìñjG”­tÆ*3%k›YÜ²T*İ|\"CŠülhE§(È\rÃ8r‡×{Üñ0å²×şÙDÜ_Œ‡.6Ğ¸è;ãü‡„rBjƒO'Ûœ¥¥Ï>\$¤Ô`^6™Ì9‘#¸¨§æ4Xş¥mh8:êûc‹ş0ø×;Ø/Ô‰·¿¹Ø;ä\\'( î„tú'+™òı¯Ì·°^]­±NÑv¹ç#Ç,ëvğ×ÃOÏiÏ–©>·Ş<SïA\\€\\îµü!Ø3*tl`÷u\0p'è7…Pà9·bsœ{Àv®{·ü7ˆ\"{ÛÆrîaÖ(¿^æ¼İE÷úÿë¹gÒÜ/¡øUÄ9g¶î÷/ÈÔ`Ä\nL\n)À†‚(Aúağ\" çØ	Á&„PøÂ@O\nå¸«0†(M&©FJ'Ú! …0Š<ïHëîÂçÆù¥*Ì|ìÆ*çOZím*n/bî/ö®Ôˆ¹.ìâ©o\0ÎÊdnÎ)ùi:RÎëP2êmµ\0/vìOX÷ğøFÊ³ÏˆîŒè®\"ñ®êöî¸÷0õ0ö‚¬©í0bËĞgjğğ\$ñné0}°	î@ø=MÆ‚0nîPŸ/pæotì€÷°¨ğ.ÌÌ½g\0Ğ)o—\n0È÷‰\rF¶é€ b¾i¶Ão}\n°Ì¯…	NQ°'ğxòFaĞJîÎôLõéğĞàÆ\rÀÍ\r€Öö‘0Åñ'ğ¬Éd	oepİ°4DĞÜÊ¦q(~ÀÌ ê\r‚E°ÛprùQVFHœl£‚Kj¦¿äN&­j!ÍH`‚_bh\r1 ºn!ÍÉ­z™°¡ğ¥Í\\«¬\rŠíŠÃ`V_kÚÃ\"\\×‚'Vˆ«\0Ê¾`ACúÀ±Ï…¦VÆ`\r%¢’ÂÅì¦\rñâƒ‚k@NÀ°üBñíš™¯ ·!È\n’\0Z™6°\$d Œ,%à%laíH×\n‹#¢S\$!\$@¶İ2±„I\$r€{!±°J‡2HàZM\\ÉÇhb,‡'||cj~gĞr…`¼Ä¼º\$ºÄÂ+êA1ğœE€ÇÀÙ <ÊL¨Ñ\$âY%-FDªŠd€Lç„³ ª\n@’bVfè¾;2_(ëôLÄĞ¿Â²<%@Úœ,\"êdÄÀN‚erô\0æƒ`Ä¤Z€¾4Å'ld9-ò#`äóÅ–…à¶Öãj6ëÆ£ãv ¶àNÕÍf Ö@Ü†“&’B\$å¶(ğZ&„ßó278I à¿àP\rk\\§—2`¶\rdLb@Eöƒ2`P( B'ã€¶€º0²& ô{Â•“§:®ªdBå1ò^Ø‰*\r\0c<K|İ5sZ¾`ºÀÀO3ê5=@å5ÀC>@ÂW*	=\0N<g¿6s67Sm7u?	{<&LÂ.3~DÄê\rÅš¯x¹í),rîinÅ/ åO\0o{0kÎ]3>m‹”1\0”I@Ô9T34+Ô™@e”GFMCÉ\rE3ËEtm!Û#1ÁD @‚H(‘Ón ÃÆ<g,V`R]@úÂÇÉ3Cr7s~ÅGIói@\0vÂÓ5\rVß'¬ ¤ Î£PÀÔ\râ\$<bĞ%(‡Ddƒ‹PWÄîĞÌbØfO æx\0è} Üâ”lb &‰vj4µLS¼¨Ö´Ô¶5&dsF Mó4ÌÓ\".HËM0ó1uL³\"ÂÂ/J`ò{Çş§€ÊxÇYu*\"U.I53Q­3Qô»J„”g ’5…sàú&jÑŒ’Õu‚Ù­ĞªGQMTmGBƒtl-cù*±ş\rŠ«Z7Ôõó*hs/RUV·ğôªBŸNËˆ¸ÃóãêÔŠài¨Lk÷.©´Ätì é¾©…rYi”Õé-Sµƒ3Í\\šTëOM^­G>‘ZQjÔ‡™\"¤¬i”ÖMsSãS\$Ib	f²âÑuæ¦´™å:êSB|i¢ YÂ¦ƒà8	vÊ#é”Dª4`‡†.€Ë^óHÅM‰_Õ¼ŠuÀ™UÊz`ZJ	eçºİ@Ceíëa‰\"mób„6Ô¯JRÂÖ‘T?Ô£XMZÜÍĞ†ÍòpèÒ¶ªQv¯jÿjV¶{¶¼ÅCœ\rµÕ7‰TÊª úí5{Pö¿]’\rÓ?QàAAÀè‹’Í2ñ¾ “V)Ji£Ü-N99f–l JmÍò;u¨@‚<FşÑ ¾e†j€ÒÄ¦I‰<+CW@ğçÀ¿Z‘lÑ1É<2ÅiFı7`KG˜~L&+NàYtWHé£‘w	Ö•ƒòl€Òs'gÉãq+Lézbiz«ÆÊÅ¢Ğ.ĞŠÇzW²Ç ùzd•W¦Û÷¹(y)vİE4,\0Ô\"d¢¤\$Bã{²!)1U†5bp#Å}m=×È@ˆwÄ	P\0ä\rì¢·‘€`O|ëÆö	œÉüÅõûYôæJÕ‚öE×ÙOu_§\n`F`È}MÂ.#1á‚¬fì*´Õ¡µ§  ¿zàucû€—³ xfÓ8kZR¯s2Ê‚-†’§Z2­+Ê·¯(åsUõcDòÑ·Êì˜İX!àÍuø&-vPĞØ±\0'LïŒX øLÃ¹Œˆo	İô>¸ÕÓ\r@ÙPõ\rxF×üE€ÌÈ­ï%Àãì®ü=5NÖœƒ¸?„7ùNËÃ…©wŠ`ØhX«98 Ìø¯q¬£zãÏd%6Ì‚tÍ/…•˜ä¬ëLúÍl¾Ê,ÜKa•N~ÏÀÛìú,ÿ'íÇ€M\rf9£w˜!x÷x[ˆÏ‘ØG’8;„xA˜ù-IÌ&5\$–D\$ö¼³%…ØxÑ¬Á”ÈÂ´ÀÂŒ]›¤õ‡&o‰-39ÖLù½zü§y6¹;u¹zZ èÑ8ÿ_•Éx\0D?šX7†™«’y±OY.#3Ÿ8 ™Ç€˜e”Q¨=Ø€*˜™GŒwm ³Ú„Y‘ù ÀÚ]YOY¨F¨íšÙ)„z#\$eŠš)†/Œz?£z;™—Ù¬^ÛúFÒZg¤ù• Ì÷¥™§ƒš`^Úe¡­¦º#§“Øñ”©ú?œ¸e£€M£Ú3uÌåƒ0¹>Ê\"?Ÿö@×—Xv•\"ç”Œ¹¬¦*Ô¢\r6v~‡ÃOV~&×¨^gü šÄ‘Ù‡'Î€f6:-Z~¹šO6;zx²;&!Û+{9M³Ù³d¬ \r,9Öí°ä·WÂÆİ­:ê\rúÙœùã@ç‚+¢·]œÌ-[g™Û‡[s¶[iÙiÈq››y›éxé+“|7Í{7Ë|w³}„¢›£E–ûW°€Wk¸|JØ¶å‰xmˆ¸q xwyjŸ»˜#³˜e¼ø(²©‰¸ÀßÃ¾™†ò³ {èßÚ y“ »M»¸´@«æÉ‚“°Y(gÍš-ÿ©º©äí¡š¡ØJ(¥ü@ó…;…yÂ#S¼‡µY„Èp@Ï%èsúoŸ9;°ê¿ôõ¤¹+¯Ú	¥;«ÁúˆZNÙ¯Âº§„š k¼V§·u‰[ñ¼x…|q’¤ON?€ÉÕ	…`uœ¡6|­|X¹¤­—Ø³|Oìx!ë:¨œÏ—Y]–¬¹™c•¬À\r¹hÍ9nÎÁ¬¬ë€Ï8'—ù‚êà Æ\rS.1¿¢USÈ¸…¼X‰É+ËÉz]ÉµÊ¤?œ©ÊÀCË\r×Ë\\º­¹ø\$Ï`ùÌ)UÌ|Ë¤|Ñ¨x'ÕœØÌäÊ<àÌ™eÎ|êÍ³ç—â’Ìé—LïÏİMÎy€(Û§ĞlĞº¤O]{Ñ¾×FD®ÕÙ}¡yu‹ÑÄ’ß,XL\\ÆxÆÈ;U×ÉWt€vŸÄ\\OxWJ9È’×R5·WiMi[‡Kˆ€f(\0æ¾dÄšÒè¿©´\rìMÄáÈÙ7¿;ÈÃÆóÒñçÓ6‰KÊ¦Iª\rÄÜÃxv\r²V3ÕÛßÉ±.ÌàRùÂşÉá|Ÿá¾^2‰^0ß¾\$ QÍä[ã¿D÷áÜ£å>1'^X~t1\"6Lş›+ş¾Aàeá“æŞåI‘ç~Ÿåâ³â³@ßÕ­õpM>Óm<´ÒSKÊç-HÉÀ¼T76ÙSMfg¨=»ÅGPÊ°›PÖ\r¸é>Íö¾¡¥2Sb\$•C[Ø×ï(Ä)Ş%Q#G`uğ°ÇGwp\rkŞKe—zhjÓ“zi(ôèrO«óÄŞÓşØT=·7³òî~ÿ4\"ef›~íd™ôíVÿZ‰š÷U•-ëb'VµJ¹Z7ÛöÂ)T‘£8.<¿RMÿ\$‰ôÛØ'ßbyï\n5øƒİõ_àwñÎ°íUğ’`eiŞ¿J”b©gğuSÍë?Íå`öáì+¾Ïï Mïgè7`ùïí\0¢_Ô-ûŸõ_÷–?õF°\0“õ¸X‚å´’[²¯Jœ8&~D#Áö{P•Øô4Ü—½ù\"›\0ÌÀ€‹ı§ı@Ò“–¥\0F ?* ^ñï¹å¯wëĞ:ğ¾uàÏ3xKÍ^ów“¼¨ß¯‰y[Ô(æ–µ#¦/zr_”g·æ?¾\0?€1wMR&M¿†ù?¬St€T]İ´Gõ:I·à¢÷ˆ)‡©Bïˆ‹ vô§’½1ç<ôtÈâ6½:W{ÀŠôx:=Èî‘ƒŒŞšóø:Â!!\0x›Õ˜£÷q&áè0}z\"]ÄŞo•z¥™ÒjÃw×ßÊÚÁ6¸ÒJ¢PÛ[\\ }ûª`S™\0à¤qHMë/7B’€P°ÂÄ]FTã•8S5±/IÑ\rŒ\n îO¯0aQ\n >Ã2­j…;=Ú¬ÛdA=­p£VL)Xõ\nÂ¦`e\$˜TÆ¦QJÎk´7ª*Oë .‰ˆ…òÄ¡\röµš\$#pİWT>!ªªv|¿¢}ë× .%˜Á,;¨ê›å…­Úf*?«ç„˜ïô„\0¸ÄpD›¸! ¶õ#:MRcúèB/06©­®	7@\0V¹vg€ ØÄhZ\nR\"@®ÈF	‘Êä¼+Êš°EŸIŞ\n8&2ÒbXşPÄ¬€Í¤=h[§¥æ+ÕÊ‰\r:ÄÍFû\0:*åŞ\r}#úˆ!\"¤c;hÅ¦/0ƒ·Ş’òEj®íÁ‚Î]ñZ’ˆ‘—\0Ú@iW_–”®h›;ŒVRb°ÚP%!­ìb]SBšƒ’õUl	åâ³érˆÜ\rÀ-\0 À\"Q=ÀIhÒÍ€´	 F‘ùşLèÎFxR‚Ñ@œ\0*Æj5Œük\0Ï0'	@El€O˜ÚÆH CxÜ@\"G41Ä`Ï¼P(G91«\0„ğ\"f:QÊ¸@¨`'>7ÑÈädÀ¨ˆíÇR41ç>ÌrIHõGt\n€RH	ÀÄbÒ€¶71»ìfãh)Dª„8 B`À†°(V<Q§8c? 2€´€E4j\0œ9¼\r‚Íÿ@‹\0'FúDš¢,Å!ÓÿH=Ò* ˆEí(×ÆÆ?Ñª&xd_H÷Ç¢E²6Ä~£uÈßG\0RXıÀZ~P'U=Çß @èÏÈl+A­\n„h£IiÆ”ü±ŸPG€Z`\$ÈP‡ş‘À¤Ù.Ş;ÀEÀ\0‚}€ §¸Q±¤“äÓ%èÑÉjA’W’Ø¥\$»!ıÉ3r1‘ {Ó‰%i=IfK”!Œe\$àé8Ê0!üh#\\¹HF|Œi8tl\$ƒğÊlÀìläi*(ïG¸ñçL	 ß\$€—xØ.èq\"Wzs{8d`&ğWô©\0&E´¯Íì15jWäb¬öÄ‡ÊŞV©R„³™¿-#{\0ŠXi¤²Äg*÷š7ÒVF3‹`å¦©p@õÅ#7°	å†0€æ[Ò®–¬¸[øÃ©hË–\\áo{ÈáŞT­ÊÒ]²ï—Œ¼Å¦á‘€8l`f@—reh·¥\nÊŞW2Å*@\0€`K(©L•Ì·\0vTƒË\0åc'L¯ŠÀ:„” 0˜¼@L1×T0b¢àhşWÌ|\\É-èïÏDN‡ó€\ns3ÀÚ\"°€¥°`Ç¢ùè‚’2ªå€&¾ˆ\rœU+™^ÌèR‰eS‹n›i0ÙuËšb	J˜’€¹2s¹Ípƒs^n<¸¥òâ™±Fl°aØ\0¸š´\0’mA2›`|ØŸ6	‡¦nrÁ›¨\0DÙ¼Íì7Ë&mÜß§-)¸ÊÚ\\©ÆäİŒ\n=â¤–à;* ‚Şb„è“ˆÄT“‚y7cú|o /–Ôßß:‹ît¡P<ÙÀY: K¸&C´ì'G/Å@ÎàQ *›8çv’/‡À&¼üòWí6p.\0ªu3«ŒñBq:(eOPáp	”é§²üÙã\rœ‹á0(ac>ºNö|£º	“t¹Ó\n6vÀ_„îeİ;yÕÎè6fügQ;yúÎ²[Sø	äëgöÇ°èO’ud¡dH€Hğ= Z\ræ'ÚÊùqC*€) œîgÂÇEêO’€ \" ğ¨!kĞ('€`Ÿ\nkhTùÄ*ösˆÄ5R¤Eöa\n#Ö!1¡œ¿‰×\0¡;ÆÇSÂiÈ¼@(àl¦Á¸I× Ìv\rœnj~ØçŠ63¿ÎˆôI:h°ÔÂƒ\n.‰«2plÄ9Btâ0\$bº†p+”Ç€*‹tJ¢ğÌ¾s†JQ8;4P(ı†Ò§Ñ¶!’€.Ppk@©)6¶5ı”!µ(ø“\n+¦Ø{`=£¸H,É\\Ñ´€4ƒ\"[²Cø»º1“´Œ-èÌluoµä¸4•[™±â…EÊ%‡\"‹ôw] Ù(ã ÊTe¢)êK´A“E={ \n·`;?İôœ-ÀGŠ5I¡í­Ò.%Á¥²şéq%EŸ—ıs¢é©gFˆ¹s	‰¦¸ŠKºGÑøn4i/,­i0·uèx)73ŒSzgŒâÁV[¢¯hãDp'ÑL<TM¤äjP*oœâ‰´‘\nHÎÚÅ\n 4¨M-W÷NÊA/î†@¤8mH¢‚Rp€tp„V”=h*0ºÁ	¥1;\0uG‘ÊT6’@s™\0)ô6À–Æ£T\\…(\"èÅU,ò•C:‹¥5iÉKšl«ì‚Û§¡E*Œ\"êrà¦ÔÎ.@jRâJ–QîŒÕ/¨½L@ÓSZ”‘¥Põ)(jjJ¨««ªİL*ª¯Ä\0§ªÛ\r¢-ˆñQ*„QÚœgª9é~P@…ÕÔH³‘¬\n-e»\0êQw%^ ETø< 2Hş@Ş´îe¥\0ğ e#;öÖI‚T’l“¤İ+A+C*’YŒ¢ªh/øD\\ğ£!é¬š8“Â»3AĞ™ÄĞEğÍE¦/}0tµJ|™Àİ1Qm«Øn%(¬p´ë!\nÈÑÂ±UË)\rsEXú‚’5u%B- ´Àw]¡*•»E¢)<+¾¦qyV¸@°mFH òÔšBN#ı]ÃYQ1¸Ö:¯ìV#ù\$“æ şô<&ˆX„€¡úÿ…x« tš@]GğíÔ¶¥j)-@—qĞˆL\nc÷I°Y?qC´\ràv(@ØËX\0Ov£<¬Rå3X©µ¬Q¾Jä–Éü9Ö9ÈlxCuÄ«d±± vT²Zkl\rÓJíÀ\\o›&?”o6EĞq °³ªÉĞ\r–÷«'3úËÉª˜J´6ë'Y@È6ÉFZ50‡VÍT²yŠ¬˜C`\0äİVS!ıš‹&Û6”6ÉÑ³rD§f`ê›¨Jvqz„¬àF¿ ÂÂò´@è¸İµ…šÒ…Z.\$kXkJÚ\\ª\"Ë\"àÖi°ê«:ÓEÿµÎ\roXÁ\0>P–¥Pğmi]\0ªöö“µaV¨¸=¿ªÈI6¨´°ÎÓjK3ÚòÔZµQ¦m‰EÄèğbÓ0:Ÿ32ºV4N6³´à‘!÷lë^Ú¦Ù@hµhUĞ>:ú	˜ĞE›>jäèĞú0g´\\|¡Shâ7yÂŞ„\$•†,5aÄ—7&¡ë°:[WX4ÊØqÖ ‹ìJ¹Æä×‚Şc8!°H¸àØVD§Ä­+íDŠ:‘¡¥°9,DUa!±X\$‘ÕĞ¯ÀÚ‹GÁÜŒŠBŠt9-+oÛt”L÷£}Ä­õqK‹‘x6&¯¯%x”ÏtR¿–éğ\"ÕÏ€èR‚IWA`c÷°È}l6€Â~Ä*¸0vkıp«Ü6Àë›8z+¡qúXöäw*·EƒªIN›¶ªå¶ê*qPKFO\0İ,(Ğ€|œ•‘”°k *YF5”åå;“<6´@ØQU—\"×ğ\rbØOAXÃvè÷v¯)H®ôo`STÈpbj1+Å‹¢e²Á™ Ê€Qx8@¡‡ĞÈç5\\Q¦,Œ‡¸Ä‰NëİŞ˜b#Y½H¥¯p1›ÖÊøkB¨8NüoûX3,#UÚ©å'Ä\"†é”€ÂeeH#z›­q^rG[¸—:¿\r¸m‹ngòÜÌ·5½¥V]«ñ-(İWğ¿0âëÑ~kh\\˜„ZŠå`ïél°êÄÜk ‚oÊjõWĞ!€.¯hFŠÔå[tÖA‡wê¿e¥Mà««¡3!¬µÍæ°nK_SF˜j©¿ş-S‚[rœÌ€wä´ø0^Áh„fü-´­ı°?‚›ıXø5—/±©Š€ëëIY ÅV7²a€d ‡8°bq·µbƒn\n1YRÇvT±õ•,ƒ+!Øıü¶NÀT£î2IÃß·ÄÄ÷„ÇòØ‡õ©K`K\"ğ½ô£÷O)\nY­Ú4!}K¢^²êÂàD@á…÷naˆ\$@¦ ƒÆ\$AŠ”jÉËÇø\\‹D[=Ë	bHpùSOAG—ho!F@l„UËİ`Xn\$\\˜Íˆ_†¢Ë˜`¶âHBÅÕ]ª2ü«¢\"z0i1‹\\”ŞÇÂÔwù.…fyŞ»K)£îíÂ‡¸ pÀ0ä¸XÂS>1	*,]’à\r\"ÿ¹<cQ±ñ\$t‹„qœ.‹ü	<ğ¬ñ™+t,©]Lò!È{€güãX¤¶\$¤6v…˜ùÇ ¡š£%GÜHõ–ÄØœÈE ÒXÃÈ*Á‚0ÛŠ)q¡nCØ)I›ûà\"µåÚÅŞíˆ³¬`„KFçÁ’@ïd»5Œê»AÈÉp€{“\\äÓÀpÉ¾Nòrì'£S(+5®ĞŠ+ \"´Ä€£U0ÆiËÜ›úæ!nMˆùbrKÀğä6Ãº¡r–ì¥â¬|aüÊÀˆ@Æx|®²kaÍ9WR4\"?5Ê¬pıÛ“•ñk„rÄ˜«¸¨ıß’ğæ¼7Â—Hp†‹5YpW®¼ØG#ÏrÊ¶AWD+`¬ä=Ê\"ø}Ï@HÑ\\p°“Ğ€©ß‹Ì)C3Í!sO:)Ùè_F/\r4éÀç<A¦…\nn /Tæ3f7P1«6ÓÄÙıOYĞ»Ï²‡¢óqì×;ìØÀæaıXtS<ã¼9Ânws²x@1ÎxsÑ?¬ï3Å@¹…×54„®oÜÈƒ0»ŞĞïpR\0Øà¦„†Îù·óâyqßÕL&S^:ÙÒQğ>\\4OInƒZ“nçòvà3¸3ô+P¨…L(÷Ä”ğ…Àà.x \$àÂ«Cå‡éCnªAkçc:LÙ6¨ÍÂr³w›ÓÌh°½ÙÈnr³Zêã=è»=jÑ’˜³‡6}MŸGıu~3ùšÄbg4Åùôs6sóQé±#:¡3g~v3¼ó€¿<¡+Ï<ô³Òa}Ï§=Îe8£'n)ÓcCÇzÑ‰4L=hıŒ{i´±Jç^~çƒÓwg‹Dà»jLÓéÏ^šœÒÁ=6Î§NÓ”êÅÁ¢\\éÛDóÆÑN”†êEı?hÃ:SÂ*>„ô+¡uúhhÒ…´W›E1j†x²Ÿôí´ŠtÖ'Îtà[ îwS²¸ê·9š¯Tö®[«,ÕjÒv“òÕît£¬A#T™¸Ôæ‚9ìèj‹K-õÒŞ ³¿¨Yèi‹Qe?®£4ÓÓÁë_WzßÎéó‹@JkWYêhÎÖpu®­çj|z4×˜õ	èi˜ğm¢	àO5à\0>ç|ß9É×–«µè½ öëgVyÒÔu´»¨=}gs_ºãÔV¹sÕ®{çk¤@r×^—õÚ(İwÏ…øH'°İaì=i»ÖNÅ4µ¨‹ë_{Ï6ÇtÏ¨ÜöÏ—e [Ğh-¢“Ul?Jîƒ0O\0^ÛHlõ\0.±„Z‚’œ¼âÚxu€æğ\"<	 /7ÁŠ¨Ú û‹ïi:Ò\nÇ ¡´à;íÇ!À3ÚÈÀ_0`\0H`€Â2\0€ŒHò#h€[¶P<í¦†‘×¢g¶Ü§m@~ï(şÕ\0ßµkâY»vÚæâ#>¥ù„\nz\n˜@ÌQñ\n(àGİ\nöüà'kóš¦èº5“n”5Û¨Ø@_`Ğ‡_l€1Üşèwp¿Pî›w›ªŞ\0…cµĞoEl{Åİ¾é7“»¼¶o0ĞÛÂôIbÏên‹zÛÊŞÎï·›¼ ‹ç{Ç8øw=ëîŸ| /yê3aíß¼#xqŸÛØò¿»@ï÷kaà!ÿ\08dîmˆäR[wvÇ‹RGp8øŸ vñ\$Zü½¸mÈûtÜŞİÀ¥·½íôºÜû·Ç½Ôîûu€oİp÷`2ğãm|;#x»mñnç~;ËáVëE£ÂíØğÄü3OŸ\r¸,~o¿w[òáNêø}ºş ›clyá¾ñ¸OÄÍŞñ;…œ?á~ì€^j\"ñWz¼:ß'xWÂŞ.ñ	Áu’(¸ÅÃäq—‹<gâçv¿hWq¿‰\\;ßŸ8¡Ã)M\\³š5vÚ·x=h¦iºb-ÀŞ|bÎğàpyDĞ•Hh\rceà˜y7·p®îxşÜG€@D=ğ Öù§1Œÿ!4Ra\r¥9”!\0'ÊYŒŸ¥@>iS>æ€Ö¦Ÿo°óoòÎfsO 9 .íşéâ\"ĞF‚…ló20åğE!Qšá¦çËD9dÑBW4ƒ›\0û‚y`RoF>FÄa„‰0‘ùÊƒó0	À2ç<‚IÏP'\\ñçÈIÌ\0\$Ÿœ\n R aUĞ.‚sĞ„«æ\"ùš1Ğ†…eºYç ¢„Zêqœñ1 |Ç÷#¯G!±P’P\0|‰HÇFnp>Wü:¢`YP%”ÄâŸ\nÈa8‰ÃP>‘ÁÁè–™`]‘‹4œ`<Ğr\0ùÃ›ç¨û¡–z–4Ù‡¥Ë8€ùÎĞ4ó`mãh:¢Îª¬HDªãÀjÏ+p>*ä‹ÃÄê8äŸÕ 08—A¸È:€À»Ñ´]wêÃºùz>9\n+¯ççÍÀñØ:—°ii“PoG0°Öö1ş¬)ìŠZ°Ú–èn¤È’ì×eRÖ–Üí‡g£M¢à”ÀŒgs‰LC½rç8Ğ€!°†À‚Œ3R)Îú0³0Œôs¨IéJˆVPpK\n|9e[á•ÖÇË‘²’D0¡Õ àz4Ï‘ªo¥Ôéáèà´,N8nåØsµ#{è“·z3ğ>¸BSı\";Àe5VD0±¬š[\$7z0¬ºøÃËã=8ş	T 3÷»¨Q÷'R’±—’ØnÈ¼LĞyÅ‹ìö'£\0oäÛ,»‰\0:[}(’¢ƒ|×ú‡X†>xvqWá“?tBÒE1wG;ó!®İ‹5Î€|Ç0¯»JI@¯¨#¢ˆŞuÅ†Iáø\\p8Û!'‚]ß®šl-€låSßBØğ,Ó—·»ò]èñ¬1‡Ô•HöÿNÂ8%%¤	Å/;FGSôòôhé\\Ù„ÓcÔt²¡á2|ùWÚ\$tøÎ<ËhİOŠ¬+#¦BêaN1ùç{ØĞyÊwòš°2\\Z&)½d°b',XxmÃ~‚Hƒç@:d	>=-Ÿ¦lK¯ŒÜşJí€\0ŸÌÌó@€rÏ¥²@\"Œ(AÁñïªıZ¼7Åh>¥÷­½\\Íæú¨#>¬õø\0­ƒXrã—YøïYxÅæq=:šÔ¹ó\rlŠoæm‡gbööÀ¿À˜ï„D_àTx·C³ß0.Šôy€†R]Ú_İëÇZñÇ»WöIàëGÔï	MÉª(®É|@\0SO¬ÈsŞ {î£”ˆø@k}äFXSÛb8àå=¾È_ŠÔ”¹l²\0å=ÈgÁÊ{ HÿÉyGüÕáÛ sœ_şJ\$hkúF¼q„àŸ÷¢Éd4Ï‰ø»æÖ'ø½>vÏ¬ !_7ùVq­Ó@1zë¤uSe…õjKdyuëÛÂS©.‚2Œ\"¯{úÌKşØË?˜s·ä¬Ë¦h’ßRíd‚é`:y—ÙåûGÚ¾\nQéı·Ùßow’„'öïhS—î>ñ©¶‰LÖX}ğˆe·§¸G¾â­@9ıãíŸˆüWİ|íøÏ¹û@•_ˆ÷uZ=©‡,¸åÌ!}¥ŞÂ\0äI@ˆä#·¶\"±'ãY`¿Ò\\?Ìßpó·ê,Gú¯µı×œ_®±'åGúÿ²Ğ	ŸT†‚#ûoŸÍH\rş‡\"Êëúoã}§ò?¬şOé¼”7ç|'ÎÁ´=8³M±ñQ”yôaÈH€?±…ß®‡ ³ÿ\0ÿ±öbUdè67şÁ¾I Oöäïû\"-¤2_ÿ0\rõ?øÿ«–ÿ hO×¿¶t\0\0002°~şÂ° 4²¢ÌK,“Öoh¼Î	Pc£ƒ·z`@ÚÀ\"îœâŒàÇH; ,=Ì 'S‚.bËÇS„¾øàCc—ƒêìšŒ¡R,~ƒñXŠ@ '…œ8Z0„&í(np<pÈ£ğ32(ü«.@R3ºĞ@^\r¸+Ğ@ , öò\$	ÏŸ¸„E’ƒèt«B,²¯¤âª€Ê°h\r£><6]#ø¥ƒ;‚íC÷.Ò€¢ËĞ8»Pğ3ş°;@æªL,+>½‰p(#Ğ-†f1Äz°Áª,8»ß ÆÆPà:9ÀŒï·RğÛ³¯ƒ¹†)e\0Ú¢R²°!µ\nr{Æîe™ÒøÎGA@*ÛÊnDöŠ6Á»ğòóíN¸\rR™Ôø8QK²0»àé¢½®À>PN°Ü©IQ=r<á;&À°fÁNGJ;ğUAõÜ¦×A–P€&şõØã`©ÁüÀ€);‰ø!Ğs\0î£Áp†p\r‹¶à‹¾n(ø•@…%&	S²dY«ŞìïuCÚ,¥º8O˜#ÏÁ„óòoªšêRè¬v,€¯#è¯|7Ù\"Cp‰ƒ¡Bô`ìj¦X3«~ïŠ„RĞ@¤ÂvÂø¨£À9B#˜¹ @\nğ0—>Tíõá‘À-€5„ˆ/¡=è€ ¾‚İE¯—Ç\nç“Âˆd\"!‚;ŞÄp*n¬¼Z²\08/ŒjX°\r¨>F	PÏe>À•OŸ¢LÄ¯¡¬O0³\0Ù)kÀÂºã¦ƒ[	ÀÈÏ³Âêœ'L€Ù	Ãåñƒ‚é›1 1\0ø¡Cë 1Tº`©„¾ìRÊz¼Äš£îÒp®¢°ÁÜ¶ìÀ< .£>î¨5İ\0ä»¹>Ÿ BnËŠ<\"he•>ĞººÃ®£çsõ!ºHı{Ü‘!\rĞ\rÀ\"¬ä| ‰>Rš1dàö÷\"U@ÈD6ĞåÁ¢3£çğŸ>o\r³çá¿vL:K„2å+Æ0ì¾€>°È\0äí ®‚·Bé{!r*Hî¹§’y;®`8\0ÈËØ¯ô½dş³ûé\rÃ0ÿÍÀ2AşÀ£î¼?°õ+û\0ÛÃ…\0A¯ƒwSû‡lÁ²¿°\r[Ô¡ª6ôcoƒ=¶ü¼ˆ0§z/J+ê†ŒøW[·¬~C0‹ùeü30HQP÷DPY“}‡4#YDö…ºp)	º|û@¥&ã-À†/F˜	á‰T˜	­«„¦aH5‘#ƒëH.ƒA>Ğğ0;.¬­şY“Ä¡	Ã*ûD2 =3·	pBnuDw\n€!ÄzûCQ \0ØÌHQ4DË*ñ7\0‡JÄñ%Ä±puD (ôO=!°>®u,7»ù1†ãTM+—3ù1:\"P¸Ä÷”RQ?¿“üP°Š¼+ù11= ŒM\$ZÄ×lT7Å,Nq%E!ÌS±2Å&öŒU*>GDS&¼ªéó›ozh8881\\:ÑØZ0hŠÁÈT •C+#Ê±A%¤¤D!\0ØïòñÁXDAÀ3\0•!\\í#h¼ªí9bÏ‚T€!dª—ˆÏÄY‘j2ôSëÈÅÊ\nA+Í½¤šHÈwD`íŠ(AB*÷ª+%ÕEï¬X.Ë Bé#ºƒÈ¿Œ¸&ÙÄXe„EoŸ\"×è|©r¼ª8ÄW€2‘@8Daï|ƒ‚ø÷‘Š”Núhô¥ÊJ8[¬Û³öÂö®WzØ{Z\"L\0¶\0€È†8ØxŒÛ¶X@”À E£Íïë‘h;¿af˜¼1Âş;nÃÎhZ3¨E™Â«†0|¼ ì˜‘­öAà’£tB,~ôŠW£8^»Ç ×ƒ‚õ<2/	º8¢+´¨Û”‚O+ %P#Î®\n?»ß‰?½şeË”ÁO\\]Ò7(#û©DÛ¾(!c) NöˆºÑMF”E£#DXîgï)¾0Aª\0€:ÜrBÆ×``  ÚèQ’³H>!\rB‡¨\0€‰V%ce¡HFH×ñ¤m2€B¨2IêµÄÙë`#ú˜ØD>¬ø³n\n:LŒıÉ9CñÊ˜0ãë\0“x(Ş©(\nş€¦ºLÀ\"GŠ\n@éø`[Ãó€Š˜\ni'\0œğ)ˆù€‚¼y)&¤Ÿ(p\0€Nˆ	À\"€®N:8±é.\r!'4|×œ~¬ç§ÜÙÊ€ê´·\"…cúÇDlt‘Ó¨Ÿ0c«Å5kQQ×¨+‹ZGkê!F€„cÍ4ˆÓRx@ƒ&>z=¹\$(?óŸïÂ(\nì€¨>à	ëÒµ‚ÔéCqÛŒ¼Œt-}ÇG,tòGW ’xqÛHf«b\0\0zÕìƒÁT9zwĞ…¢Dmn'îccb H\0z…‰ñ3¹!¼€ÑÔÅ HóÚHz×€Iy\",ƒ- \0Û\"<†2ˆî Ğ'’#H`†d-µ#cljÄ`³­i(º_¤ÈdgÈíÇ‚*Ój\rª\0ò>Â 6¶ºà6É2ókjã·<ÚCq‘Ğ9àÄ†ÉI\r\$C’AI\$x\r’H¶È7Ê8 Ü€Z²pZrR£òà‚_²U\0äl\r‚®IRXi\0<²äÄÌr…~xÃS¬é%™Ò^“%j@^ÆôT3…3É€GH±z€ñ&\$˜(…Éq\0Œšf&8+Å\rÉ—%ì–2hCüx™¥ÕI½šlbÉ€’(hòSƒY&àBªÀŒ•’`”f•òxÉv n.L+ş›/\"=I 0«d¼\$4¨7rŒæ¼A£„õ(4 2gJ(D˜á=F„¡â´Èå(«‚û-'Ä òXGô29Z=˜’Ê,ÊÀr`);x\"Éä8;²–>û&…¡„ó',—@¢¤2Ãpl²—ä:0ÃlI¡¨\rrœJDˆÀúÊ»°±’hAÈz22pÎ`O2hˆ±8H‚´Ä„wt˜BF²Œg`7ÉÂä¥2{‘,Kl£ğ›Œß°%C%úomû€¾àÀ’´ƒ‘+X£íûÊ41ò¹¸\nÈ2pŠÒ	ZB!ò=VÆÜ¨èÈ€Ø+H6²ÃÊ*èª\0ækÕà—%<² øK',3ØrÄI ;¥ 8\0Z°+EÜ­Ò`Ğˆ²½Êã+l¯ÈÏËW+¨YÒµ-t­fËb¡Qò·Ë_-Ó€Ş…§+„· 95ŠLjJ.GÊ©,\\·òÔ….\$¯2ØJè\\„- À1ÿ-c¨²‚Ë‡.l·fŒxBqK°,d·èË€â8äA¹Ko-ô¸²îÃæ²°3KÆ¯r¾¸/|¬ÊËå/\\¸r¾Ëñ,¡HÏ¤¸!ğYÀ1¹0¤@­.Â„&|˜ÿËâ+ÀéJ\0ç0P3JÍ-ZQ³	»\r&„‘Ãá\nÒLÑ*ÀËŞj‘Ä‰|—ÒåËæ#Ô¾ª\"Ëº“AÊï/ä¹òû8)1#ï7\$\"È6\n>\nô¢Ã7L1à‹òh9Î\0B€Z»d˜#©b:\0+A¹¾©22ÁÓ'Ì•\nt ’ÄÌœÉOÄç2lÊ³.L¢”HC\0™é2 ó+L¢\\¼™r´Kk+¼¹³Ë³.êŒ’êº;(DÆ€¢Êù1s€ÕÌòdÏs9Ìú•¼ P4ÊìŒœÏó@‹.ìÄáAäÅnhJß1²3óKõ0„Ñ3J\$\0ìÒ2íLk3ãˆáQÍ;3”Ñn\0\0Ä,ÔsIÍ@Œûu/VAÅ1œµ³UMâ<ÆLe4DÖ2şÍV¢% ¨Ap\nÈ¬2ÉÍ35ØòĞA-´“TÍu5š3òÛ¹1+fL~ä\nô°ƒ	„õ->£° ÖÒ¡M—4XLóS†õdÙ²ÖÍŸ*\\Ú@Í¨€˜YÓk¤Š¤ÛSDM»5 Xf° ¬ªD³s¤äÀUs%	«Ì±p+Ké6ÄŞ/ÍÔüİ’ñ8XäŞ‚=K»6pHà†’ñ%è3ƒÍ«7lØI£K0ú¤ÉLíÎD»³uƒêõ`±½P\rüÙSOÍ™&(;³L@Œ£ÏˆN>Sü¸2€Ë8(ü³Ò`J®E°€r­F	2üåSE‰”M’†MÈá\$qÎE¶Ÿ\$ÔÃ£/I\$\\“ãáIDå\" †\nä±º½w.tÏS	€æ„Ñ’Pğò#\nWÆõ-\0CÒµÎ:jœRíÍ^Süí„Å8;dì`”£ò5ÔªaÊ–ÇôE¹+(XröMë;Œì3±;´•ó¼B,Œ˜*1&î“ÃÎË2XåS¼ˆõ)<Í ­L9;òRSN¼Ş£ÁgIs+ÜëÓ°Kƒ<¬ñsµLY-Z’:A<áÓÂOO*œõ2vÏW7¹¹+|ô €Ë»<TÖóÕ9 h’“²Ïy\$<ôÎ#Ï;ÔöÓá›v±\$öOé\0­ ¬,Hkòü-äõàÏš\rÜú²ŸÏ£;„”¹O•>ìù“·Ë7>´§3@O{.4öpO½?TübÃÏË.ë.~O…4ôÏSïÏì>1SS€Ï*4¶PÈ£ó>ü·ÁÏï3í\0ÒWÏ>´ô2å><ëóßP?4€Û@Œôt\nNÀÇùAŒxpÜû%=P@ÅÒCÏ@…RÇËŸ?x°ó\n˜´Œ0NòwĞO?ÕTJC@õÎ#„	.dş“·MêÌt¯&=¹\\ä4èÄAÈå:L“¥€í\$ÜéÒNƒ­:Œ’\rÎÉI'Å²–AÕráŒ;\r /€ñCôÈåBåÓ®Œi>LèŠ7:9¡¡€ö|©C\$ÊË)Ñù¡­¹z@´tlÇ:>€úCê\n²Bi0GÚ,\0±FD%p)o\0Š°©ƒ\n>ˆú`)QZIéKGÚ%M\0#\0DĞ ¦Q.Hà'\$ÍE\n «\$Ü%4IÑD°3o¢:LÀ\$£Îm ±ƒ0¨	ÔB£\\(«¨8üÃé€š…hÌ«D½ÔCÑsDX4TK€¦Œ{ö£xì`\n€,…¼\nE£ê:Òp\nÀ'€–> ê¡o\0¬“ıtIÆ` -\0‹D½À/€®KPú`/¤êøH×\$\n=‰€†>´U÷FP0£ëÈUG}4B\$?EıÛÑ%”T€WD} *©H0ûT„\0tõ´†‚ÂØ\"!o\0Eâ7±ïR.“€útfRFu!ÔDğ\nï\0‡F-4V€QHÅ%4„Ñ0uN\0ŸDõQRuEà	)ÍI\n &Q“m€)Çš’m ‰#\\˜“ÒD½À(\$Ì“x4€€WFM&ÔœR5Hå%qåÒ[F…+ÈùÑIF \nT«R3DºLÁo°Œ¼y4TQ/E´[Ñ<­t^ÒËFü )Qˆå+4°Q—IÕ#´½‰IF'TiÑªXÿÀ!Ñ±FĞ*ÔnRÊ>ª5ÔpÑÇKm+ÔsÇÜ û£ïÒáIåôŸREı+Ô©¤ÙM\0ûÀ(R°?+HÒ€¥Jí\"TÃDˆª\$˜Œà	4wQà}Tz\0‹Gµ8|ÒxçÍ©R¢õ6ÀRæ	4XR6\nµ4yÑmNôãQ÷NMà&RÓH&É2Q/ª7#èÒ›Ü{©'ÒÒ,|”’ÇÎ\n°	.·\0˜>Ô{Áo#1D…;ÀÂĞ?Uô‘Ò•Jò9€*€š¸j”ı€¯F’N¨ÒÑ‰Jõ #Ñ~%-?CôÇßL¨3Õ@EP´{`>QÆÈ”µÔ%Oí)4ïR%IŠ@Ôô%,\"ÕÓùIÕ<‘ëÓÏå\$Ô‰TP>Ğ\nµ\0QP5DÿÓkOFÕTYµ<ÁoıQ…=T‰\0¬“x	5©D¥,Â0?ÍiÎ?xş  ºmE}>Î|¤ÀŒÀ[Èç\0€•&RL€ú”H«S9•G›I›§1ä€–…M4V­HşoT-S)QãGÇF [ÃùTQRjN±ã#x]N(ÌU8\nuU\n?5,TmÔ?Ğÿ’Ü?€ş@ÂU\nµu-€‹Rê9ãğU/S \nU3­IEStQYJu.µQÒõF´o\$&ŒÀûi	ÜKPCó6Â>å5µG\0uR€ÿu)U'R¨0”Ğ€¡DuIU…J@	Ô÷:åV8*ÕRf%&µ\\¿RÈõMU9RøüfUAU[T°UQSe[¤µ\0KeZUa‚­UhúµmS<»®À,Rès¨`&Tj@ˆçGÇ!\\xô^£0>¨ş\0&ÀpÿÎ‚Q¿Q)T˜UåPs®@%\0ŸW€	`\$Ôò(1éQ?Õ\$CïQp\nµOÔJ¹ñX#ƒıV7Xu;Ö!YBî°ÓSåcşÑ+V£ÎÃñ#MUÕW•HÍUıR²Ç…U-+ôğVmY}\\õ€ÈOK¥Mƒì\$ÉSíeToV„ŒÍHTùÑ!!<{´RÓÍZA5œRÁ!=3U™¤(’{@*Ratz\0)QƒP5HØÒ“ÎÕ°­N5+•–ÏP[Ôí9óV%\"µ²ÖØ\n°ıñäG•SL•µÔò9”ùÇÌë•lÀ£ˆ‘\rVˆØ¤Í[•ouºUIY…R_T©Y­p5OÖ§\\q`«U×[ÕBu'Uw\\mRUÇÔ­\\Es5ÓK\\úƒïVÉ\\ÅS•{×AZ%Oõ¼\$Ü¥FµÔ¬>ı5E×WVm`õ€Wd]& \$ÑÎŒÅ•ÛÓ!R¥Z}Ô…]}v5À€§ZUgôÔQ^y` Ñ!^=F•áRÁ^¥vëUÅKex@+¤Şr5À#×@?=”uÎ“s •¤×¥YšNµsS!^c5ğ\$.“u`µÜ\0«XE~1ï9Ò…JóUZ¢@²#1_[­4JÒ2à\nà\$VI²4n»\0˜?ò4aªRç!U~)&ÓòB>t’RßIÕ0ÀÔ_EkTUSØœ|µıUk_Â8€&€›E°ü(â€˜?â@õ××JÒ5Ò½JU†BQT}HVÖ‘j€¤Qx\neÖVsU=ƒÔıV‘N¢4Õ²Ø—\\xèÒÖïR34İG¿D\":	KQş>˜[Õ\rÕY_å#!ª#][j<6Ø®X	¨ìÍc‰•Ø#KL}>`'\0¨5”XÑcU[\0õ(ÔÙÑWt|tô€R]pÀ/£]H2I€QO‹­1âS©Qj•Z€¨¸´Hº´m¨ÌÙ)dµ^SXCY\rtu@Jëpüµ%ÓÿM¸ø€¨óµ“Ö?ÙUQ°\nö=Råar:Ô¿Eí‘À¥-G€\0\$ÑÇd½“ö]Òmeh*ÃìQ‰Wt„öc€¡`•˜AªY=S\r®¯«	m-´‚¤=MwÖH£]Jå\"ä´Ä õş­fõ\"´{#9Teœ‰ÙÍMÔc¹ñNêI£òÙßD¥œõÙÜçUœ6ÙñgÑ2Ù×İ¶eƒa­L´€Q&&uTåX51Y >£óûSıÖŠQ#êIµ¥Õj\0ûœ£ÅW PÑş?ub5FUóLn¶)V5R¢@ãë\$!%o¶ÔPúÉ'€‰EµUÁÔP-†¶š¤Bp\nµF\$ŸS4…t±UF|{–qÖÈ“0û•ÎUmjsÎÃü€²øı\$´Ú›j…cëÚå¦Ö«€¿aZI5X€ƒj26®¤&>vÑ\n\r)2Õ_kîG¶®TJÚÁeQ-cîZñVM­Ö½£z>õ]•a¹c£Ëcìß`t„”HÚÑjİ6¹£+kŠM–\0Œ>Œ„€##3l=à'´¥^6Í\0¨Ã¨v¦Z9Se£€\"×ÊêbÎ¡ÔB>)•/TÁ=ö9\0ù`Pà\$\0¿]í/0Úª•«äµ½k-š6İÛ{küÖá[F\r|´SÑ¿J¥õMQ¿D=õ/ÈWX¢öœV—a¬'¶¹éa¨to€©lå†¶ĞXj}C@\"ÀKPÛÎÖÚom’3\0#HV”µ…v÷Ñ~“{µÖ?gx	n|[Ø?U¶äµ[rê½h¶ŞG¸`õ3#Gk%L£ê\0¿I`CùDŞê¸	 \"\0ˆŒÅ§¶°#cN«6ßÚ¹fÂÔzÛêº;Ñ¤ÃeeF–7Ù/N\r:ôâQñGÕ9	\$ÔóIøÕ¼ºß]£®TİØWGs«ÔdWõMÚIãèÑÙf’BcêÛ¤êõÂ÷!#cnu&(ŞSã_Õw£ùSfë&TšZ:…0CóSÙLN`Ü³Yj=·¶>Å²ÃñZ!=€rV]gû	Ó£rµ ËXlŒÉ-.¹UÄ'uJuJ\0ƒs­J¶'W%·¶­\\>?òBöëV­j4µÏJ}I/-ÒrRLºSè3\0,RgqÓ­ôÇTf>İ1Õï\0¥_•”Ç\\V8õ¡ZÛt…Ácè€†ú<^\\ùll´j\0¾˜şT¥]CİÔw×Î“zI¶ÙZwN…¶¶pVW…jv»Y¶>2Ó	o\$|U‡WÃL%{toX3_õ¶òR‰J5~6\"×ãZl}´`Ôkc­ÑîÛeR=^UÔ•¥1òÑ½w7eØdµİvÙb=á\0ùf €,³må)ÕéGpûÕ-Ó¼½)9Lı“š>|Ôë \"Ì@èû¤5§`†:›ô\0é,€ñt@ºÄxº“òlÃJÈ»b¨6 à…½‰İaŞA\0Ø»ARì[A»Ã0\$qo—AàÊSÒü@Ìø¬<@ÓyÄĞ\"as.âÎä÷V^„•è®¥^õ›…—œ\0ÜÈHÁ·[H@’bK—©Ş)zÀ\r·¨¤¤=éÁ^¿zˆB\0º¿’¤äNéo<Ì‡t<xî£\0Ú¬0*R ºI{¥í®´^æEµî·¸:{KÕ§1Eˆ0²ÓYº•›à/ÕÑcêÀ\"\0„ê¸4øÉF7'€†˜\nÕ0İÉ`U£Tù¤?MPÔÀÓlµÈ4ŒÓr(	´ÁZ¿|„€&†©t\"Iµ¿ÖÛL w+Òm}…§÷€Wi\r>ÖU__uÅ÷63ßy[¢8µT-÷ÙVÏ}¤xãô_~è%ø7Ùß{jMáo_šEù÷ØÓë~]ôP\$ßJõCaXGŠ9„\0007Åƒ5óA#á\0.‹Àä\rË´_Ö¢áÀßÚ%şáÀÀ\n€\r#<MÅxØJËù±|¸Ø2ğ\0¨–;oŒ^a+F€í¸Îç¬€LkúÁ;À_Ûİê#€¾M\\“¬€¤pr@ä“ÃµÆÔøÂşOR€¿ñ–~zÇûAÁNE°YÁO	(1N×‰ˆRø¨8Ø€C¼¦ë¨Én?O)ƒ¶1AçDo\0ä\r»Ç¢?àkJâî‘“„\"â,OFÈÌa…›ùª-bà6]PSø)Æ™ 5xCâ=@j°€ÇL”ÁèÈLî˜:\"èƒ»ÎŠ¤l#¢ÀéBèk£“ˆ›€ÖË@ •Nº:ê>ï|Bé9î	«Èî”:Nıñ\$èéS¥ CB:j6î—Şé•àÎ‰Jk”†uKğ_W›Í¢Ã˜I =@TvãÒ\n0^o…\\¿Ó ?/Á‡&uê.ŞØ_˜æ\r®î¥Cæì+Úøc†~±J¸b†6ÓüØe\0ÍyóÑ¡\0wxêhÁ8j%S›À–VH@N'\\Û¯‡ÆN¥`n\r‹ÒuŞn‰KèqUÃBé+í˜f>G‡°\r¸»ˆ=@G¤Åädç‚†\nã)¬ĞFOÅ hÊ·›†ÃˆfC‡É…X|˜‡I…]æğ3auyàUi^â9yÖ\no^rt\r8ÀÍ‡#óîØâN	VÈâY†;Êc*â%Và<›‰#Øh9r \rxcâv(\raŸá¨æ(xja¡`g¸0çVÌ¼°Œ¿Q†©x(ÇëƒÀglÕ°{—Ægh`sW<Kj°'¿;)°Gnq\$¨pæ+ÎÉŒ_ŠÉdø¶^& ¯Š˜DÂxà!bèvŞ!EjPV¤' ââÁ(”=ÏbÂ\rˆ\"–b¦İL¼\0€¿Ìbtá‚\n>J¬Ôã1;üù¼ÖîÛˆ¿4^s¨QÁp`Öfr`7‚ˆ«xª»E<lÑÏã	8sş¯'PT°øÖºæËƒ¸°z_ÊT[>Ğ€:Ïó`³1.î¾°;7ó@[ÑŞ>º6!¡*\$`²•\0À„æ`,€“øÇàİÁ@°àáå?Ìm˜>ƒ>\0êLCÇ¸ñˆR¸În™°/+½`;CŠ£Õø\0ê½*€<F“„ö+ëƒâ„q MŒÁş;1ºK\nÀ:b3j1™Ôl–:c>áYøhôìŞ¾#Ô;ã´Ü3Öº”8à5Ç:ï\\Şï¨\0XH·Â…¶«aş®¸™M1ä\\æL[YC…£vN’·\0+\0Ôät#ø\$¬ÆØØà!@*©l¦„	F»dhdİıùF›‘à&˜˜Æ˜fó¹)=˜¦0¡ 4…x\0004ED6KÍòä¢£±…”\0ònN¨];qº4sj-Ê=-8½ê†\0æsÇ¨ûˆ¹D§f5p4Œàé©Jè^Öí’'Ó”[úùH^·NR F˜Kw¼z¢Ò ÜĞE”º“ágF|!Èc©ôäo•dbÁêùxß\0ì-åà6ß,Eí„_†íê3uåp ÇÂ/åwz¨( ØexRaºH¼YùceŠš5ê9d\0ó–0@2@ÒÖYùfey–YÙcM×•ºhÙÃ•Ö[¹ez\rv\\0Áeƒ•ö\\¹cÊƒ†î[Ùue“—NY`•åÛ–Î]9hå§—~^Yqe±–¦]™qe_|6!Şóuï`fÕî™Jæ{è7¸ºM{¶YÙ‡©øj‚eÆÌC»¢S6\0DuasFL}º\$È‡à(å”Mb…ÈàÆ¤,0BuÎ¯…ì¥Ñ‚2ögxFÑ™{a¸n:i\rPjıeÏñ˜rÈrØÏGıBY ˆM+qïçiY”dË™é`0À,>6®foš0ù©†o™ó æXf¢äù\0ÀVİL!“«f…†láœ6 Å/ëæ£1eƒ•\0‰>kbfé\r˜!ïufò<%ä(rË›ùa&	ı™¨àY€Ş!¡Òñ–mBg=@ƒĞ\rç; \rŞ5phI 9bm›\$BYË‹ÿšÄgxç#‰@QEOÇæm9–®Ë0\"€ºç!t¨˜ê†Ë‰¸®Ğ‡çO* Ååÿ\0Âİ>%Ö\$éoîrN&s9¿f£4çù™gŠä~jMùf›wyèg›yí\\`X1y5xÿŒù^zï_,& kÑæ¢é|¡€À¦1xçÏA‘6ğ \nîoè”»Œ&xÙïgg™{r…?ç·›ü-°½…®|tä3±šˆÈÍ}gHgK¢9¿¿¨õJÀ<C C° 1„î9ş7‡g÷š‚ïh6!0Hâí›cdy´fÿ¡DA;ƒ‚9…Tæ¢ÿ®0¬Ä\0ÆpØàù†!‡ 6^ã.øSÂ²?ÆØ¦E(P­Îˆ .æÂ 5€ÄhŠéˆEPJv‰ .‹•¢+—\$ç5Œ>P+µ?~‰¡gŒ6\r³öh¢¼p«z(è†WÙÄ`Â•¨±\"y¯ñÏ:ĞFadÅ¬6:ù¡f˜Şi\0ì˜İØàA;áe¢°àì¬ç^ÊÖwf„ >yÍŠËõ`-\rŠÚ…á\0­hr\rÎr£8i\"_Ú	££¼9¡CI¹fXËˆ2¦‰š\"ÍÅ¢‰… øh¢L~Š\"ö…š%V•:!%Šxyèizyg„vxÚ]‚Æ}qgÄÃZiŒä|Œ`Ç+ _úgèòú†™Ù£¾úªÂÀÂè­6PA€Ê€\$¶=9¢ŒùàÍh‹¢|p’ ÿ¢ˆé˜íè!¢.ø!”ş¶üiç§^œøÚiË¢8zVCÌùöŒZ\"€æäØ(Ä¥›¹°9èU)û¥!DgU\0Ãjÿã¿?`Çğ4ãLTo@•B¤§úN†aš{Ãrç:\nÌŸ“E„»8Ã¦&=êE¨*Z:\n?˜¨g¢èÌŠ£‹h¢õ.•˜’ Nş5(ˆSƒhÑôi2Ö*c„fı@•“ÑŞ7¦œz\"áƒ|ÖúrP†.Ç€ÊL8T'¿¸k¢ˆß:(¹q2&œÆED±2~ÿ¿Ø±şœŒ¬Ã9ûÒÂv£©¼8ÿƒ©– @úé^X=X`ªqZºĞQ«Ö®`9jø5^ˆ¹å@ç«¸În¼qv±á¨3±ÚÇèŠ(I6ğªjšdT±ÚÂ\\Š ‚Ÿ3¢,™Ïhék¢3ú(ë3¬‘‘PÒu•VÏ|\0ï§†Uâk;¢ÌJQ¶ã é. Ú	:J\rŠ1ŸênìBI\r\0É¬h@˜¼?ÒN±\nsh—®å\"ë’ò;¦r~7O§\$ ú(ã5¤RÅèÆ	èÊ½jÂîšØFYF šÜ”£«~‰xŞ¾©f º\"ã†vÛ“ošëË¨ººÂº#ŒÜaÒèŠõ¶®P“„Ë<ãáh£-3éº/Gx®õ²nÇi@\"’G…?ó¤,ïZpÖxX`v¦4XÆõóàû„[ƒI¶œ7Ã¥Xc	îÅ!¡bç¢}ÚjŒ_¾¥9á5qti¦6f»’°¸İÙ5ÿûç FÆ¹ãiÑ±©pX'ø2¡rƒ„®0ÆÆºé§D,#GëU2€ÌØâIè\rl(£— €ì±£¦¨=ĞA¸a€ì©³-8›dbSşˆûõ4~‚ô—H;°Â­0à6Çbé{ª„ŞºRæèÃs3zë¯ÃÀüNğŞ„`ÆË†+ò¦­ 4<ø^aƒy°¬”	}r°Âây´õãáû¸kŒ&4@ˆÁ?~ÔäÅcE´ÂÈ­@ˆLS@€Œéz^qqN¦°</H‚j^sCâ`èæsbgGy¹¤Ö^\nÈNó\n:G¶N}¼c\nîÚÕí¤ +£†ï=†pÙ1º’NµTB[dÀÿ¶–š¶Ğ‹¢¾Ü¹ñ`³nÚoj;jÄ›whØõ€c9ƒ‚pÌ¡[y4«¨¶05œÍ‹NßÁ+Î¿·Ğ`Xdaáæ/zn*öPÀ‡êÁ¸#tíèµ¸~à9Wî	šVâò~=¸#Ùùn)¨î´î	2ÜÉ;…j:õ°Ják„C¸!>xîù5š£==¦2»—‚. ã|¿'¨îä[€Ì'—;üÚv½ù«–“¸„®÷ÎëÎ;:SA	º&Ğ[£me†êãn±ëúûªî™«Ëµ¦Ä•<Ÿº6ma‘=Y.ç¥ÀÅ:g¶ÔşÉè…€ù°Ğ;«Iß»xÅ[”éI¡J\0÷~ÂzaY®íºîüwT\\`–íV\nÆ~P)ézJ¾©æ½üñğQ@İà[¶{rÊ‰µDîB„v—ï|i-¹EæøKŒ;^n»{êó½å:Nh;–—Ú2Á¨Æ€pçÑ´6“úƒ»ç½˜9§9¡¥öÖXÂhQœ~—ÛÛiAŸ@D šj‡¥î}ÑozLV÷ïçÑ³~ù•	8B?â#F}F¾Td­ë»áĞe±ÃzcîçŸFÅÀŠg‚7Î—Ûêà€ 6ı#.EÂ£¼áÀÖÂ£¥ğS£.J3¥ö5»¯KÉ¥óJ™§¸;¤—„n5¾¾:ySï‘ÀCÛvoÕ½.˜{ñğ	d\\0ë?W\0!)ğ'šû¼èEgá;à+»\0üY Ntbp+À†cŒø“ş£\0©B=\"ùc†Tñ:Bœ±Á¤úcğïˆşîÆï¸P‘IÜÈD¸ÂV0ÊÇ!ROl‰O˜N~aFş|%Éßº³¸¬…ò)Où¿	Wìo´û‡Qğw¨È:ÙŸlé0h@:ƒ«ÀÖ…8îQ£&™[Ànç¹FïÛp,Ã¦å@‡ºJTöw°9½„(ş†œ<é{ÃÆO\rñ	¥àùÚ‚\$m…/HnP\$o^®U¡Ì\"»¿ã{Ä–…<.îç¡‹n¥q8\rÕ\0;³n£ÄŞÔÛğç¡Ÿˆ+ÎŞ³3¢¼n{ÃD\$7¬,Ez7\0…“l!{˜é8÷á¶xÒ‚°.s8‡PA¹FxÛrğÄÓôQÛ®€¹†1Ì…¸p+@ØdÔŞ9OP5¼lKÂ/¾‘·¾˜\\mæú¸Äs‡q» îvºQí/§ÿÜ	„!»¶åz¼7¾oœ¿EÇ†Ò:qàV 5˜?G¡HO®âO†\$ül¾š+â,òœ\r;ãç°¾¤’~ÎAÄéŒ³é{È`7|‡ÿÄ‚Äàër'‰°Ji\rc+¢|—#+<&Ò›¹<W,Ã>¢»^òPğ&nÂJhĞe‡%d¶æìèÏÜCƒi¶zXÃAÿ'DÍ>ÉÎˆ¡Ek£Ê¬@©Bòw(€.–¾\n99Aê¯hNæcîkN¾d`£ĞÂp`Âò°%2ö¦½3H†Ëb2&¨< 9¤R(òÀ‡táTH¬	àz‘Ö'œ× oòÀ‹>4?Ô\rZÌwÊÓ‚ä×4ƒ`ºÈĞ‡é†µ³N‡ñŸéÓ€î'-IõÈì†÷0(S¨rØw,ü¹ĞåËKÊrÍÌ'-2Hlo-ÁUòáËâ_’'W#'/üÉHÖŸ¤®j6“Ì‰¡¡ÉàÈ«¶\0é„<‘„ÚúŒj1¤E’QŒTÜT­ÆrÁBcmí16ãÍˆgÙ«:w6Í¯›h@1ÅI:¤ÃÁ’Éş2ópò’L/ÎÁŸÂwÿ:òÅ‘ÓÎøK<ğÌE<‚şJ­76Ó€s×.Ì²sZóß/\$÷AsEyÏœàrÚr:w?Õ‰”!Ï?³áêÇ™ĞZ“MÍ9»Õ\0ÏÁ1?ARÍ¦%Ğ7>ÖMÇARr}sé€ñr)\\t-8=³öÍËĞUıË,WOCsÕ†„Ğ#w½5®á¯ERlM*¯D³ç1ûÑ>]ÏÀgK¤²V¹\nÜ\\èÜÓsˆÜ‡8Í¹seÍ§9­soÎ~„ ìów4xàŒ†’ñf@×ĞÜD­ö9€‡ÎÊ6¬\0	@.©î²@´9\0ŠC;Kôy+ÓJğ“ÜÙ¥ƒÏu<\\û`òc{Ó‹¤E£>ÿyÁJ=lŒüïá/…-—7˜ş”ĞZ46¨uC5™‘PçÎ©´RVĞòæ¡ÜáĞıÊ³lVøÒaNxû`Õ´?UÛ7(HP“}jVØJëzNQJ÷S–¸±s-gQ!a¥VØ_SwRıOõ3am‡ZXwZÍo‰'İwa­‰ÖOØoZµ“õ!Ù[\n<ôZ€µO¥Ò¶'ÇÅOmo÷[×Óa=Qºä>‚:õTĞ\nµ¨ç\0Š=€ım×jú–ATÃRÅbu(ÈI×´è:å×\$v¾Wõ×µÃğuÅS¿\\V8Øçvç\\õ•×g!MĞ¶¦uÅÖ_µ&Öis¿\\CÿRVM¢]tXT7\\UoT×Øo_Ô¯İ›S?aÔlÈSØ-LutZGeÇÕái`	}XZ‹i}Q•yW[i­…TŠöYo¦ (ZE\\¨}nÙi—f–‘Ú‹ÙÏW×dÑ%Tıpu3uÍTıf5)vˆÛ]ÕUR3VEY]¥X¸\n·^½§VqS½Sı}XéiGf•Úv>­Sı‚v»JMQšvÚ•Š…ÔÙ\\•g]´QYE“Îİµ#1Vÿl5UØEK]ÕÉ\0³ØİSıU?\\ºBwS•UŠ7–´ÕmZ½V5\\õ¹WfıÂÕ§[¥eUrõ{G\\µıUµÚ,„Éö‘W…[]xö›V×j5mTïV×jİ~u7Ø\0ûV¦UµØ'tı°w?msİÕÔÉÛ5VİÃvİq}Ùöáİu-UqÕ]İ—c]ÚWİØõ]Tt:ífŠM”k¶“e]î¹[-p}^ÔI[©XDãéºåY¿V—dõÀıO]	seNõ£ÜßZ¯WYÚ[Õt…ÈV?ò3ŞÇµßM“öñİ™`Ğût^w£d²:qTL•@@>]Áj\rFİqvµİ-Lv´GKwiôLwIPMo”ùÇ¹Mgv½ÿø[§Uss¦~	èõ…w:BâA‘ŸÑNEù{ä!-ÔÃdıŸo\0´’}&Ş­hXÕÎA–5µ%Ù£fzLÖHÙ5d­” Y…_%…v´Ó™!mšÒ]Öë•ØÒÌ%üñßò€şå=B©>E [#^}öhYFÛa·ßÆ>{¡gS…¶ğp[ìF÷¦ÏDaë6næ´À¶x9«¥8LêIãˆ«N–a=ˆSÊ@úbPk¦.™áNòøHù”l\0ú†:àğè–îŠº2#çÎ˜;¼í®vøO}€9ik]	&®{õ‰ ø«ÕœÙ2|a—·&óãÔÇåÿŞQ½¥ª±ÌîÎç¨)ÉñµoÙ“Ç¸:é&.\0¶5q\0JĞL½é‚64hy€3®Ş¢«¹˜a®Şƒù‚Iz†ÁO‚—–ñ„æï®ˆ\"á¶yB»Ê³{ª3Æ%˜5r(mØÈàÂáÇx.7rÒb%Á‡ü^ e†M€»¢2®\0x—½!‰b}.®âY6\$qS”Ï\"^|xE…äÈøaãş‘¼À€ëXÇ¡5‚9†'T‚R	Ãc9ÄãèW¢1ßáÑAÎ”Pí¦ŸØh6'Şoò-àÖËpµ¾T(\nn\rËÅ“å1Ô„RïRUgÛéƒÈş™“çx¨•Pe#îé*¤âkT<Ÿ<>b;‹“\0™Á˜gL½.<k©ZváÌ„ø¯óz³¶Æ8~¬ğy7€Y¸ïÈêÜ7w¨áOdnÒ>¤<€ú›Eé3ˆ¦wS”Û†œ@¾¡ë® oôWÅ1…ñúñ¾Òº¿zã‰eíŞ½è±å1İˆz÷\0f=ØùcãŠ¤g¹Ÿ{éŞ>nŒp\0±ÍèÎ‘:Hé†BnŒ6FèÆB¯rçW=öãC>M.1~@3ºGí9‡8÷q<Sô|ûY•8QPâû`L[Öqzç˜Û«PÇíèNà<{_-Ù®¥dO¸ùd-îNB7ä4İîBùNÁí.Vº·ç9Æ¨Qø3º{IcP\$§»ºhû¾<R yy…ì?ŞòGÒş:n™ã€µôgÍÁœÿ;Ah!åÔşÁ&å»+>ğË€Û;MÁËŒŞ	ÍşşÃïÿ6SâîŠ·N¸ÚŒ=#ñëëñ³±`üTü#+ìnû;•·r,‚Ç½ğ¦ÏX|#ïÄ\rü# ïÃ?\nüD>¨|VüSñ¿ÂÚeÏ—~Jãm99…á¾\nsÆ{S|r],~ÿË¹ñøé¿ µqÏI?\"|wñ¦øÿ%|Œj‘\0rEò,kSnü¡íç¿øqÆ•Èd8B.ûñ‡1«Ñü³\"™ß/|Æ´€Øƒ]òüˆ¸­€·EüÏœèN²lüÌÕÆxÖËI°÷Ï Icó¿Å¸.|\$8D¹ŸF¨İÌ“…˜PÕKÆò€3ƒô\\j¾¥xUÏC/äã³Ò—¿A{¹ÀĞûşeüÚƒ€ÿÓæ×¶éÜ¾ÿŠÕôà\rpıU\nçÕŸWloÂ­Yâ{ÿô˜ã`]'Öşıs†Õ/|¼oïÿ×à3çÀrü}‹ö;Úÿ[ÊnÎ¹ûÿº—¿OíM7¯ÛÉß£Ø¼q¾µq(ÏĞ_lâqsN÷“yòûñÄçÕ;ŒiÀg¿t—‡ÅÎ:ÿıåÈëÕ™§qk‡¿íôá{÷Ÿß?zı¿÷ÏŞûêñMÈ—ßoıì'àj˜úïá†ãcøyñß„ıãøgß‡gkŒwÉâf8¼VcÔ7fAÌY‘³å+Kxñ…=gKAkşT,95rdã+ùGåÀºíÙ¯„…ñş[Òà%…AÅwæŸµú…½å7ùßåà¬…£%· {½míú8%_”şmú—qˆàVËË¨_ ş“%«!şEƒú¼iø~‘ù²h ú~»ŸCªß­~§ù¨%†„­µ—ç_¨şÙúåÿ·rLkD«yÌúŒğ~Ô?p1O!?¿®vÌ\\ïä±Pm©\"¸Ì<ûŒ¯ïŸÅúE©6… äEŸVğ³åÎñšzkîÇú¦9³zÉªßĞ~Ê/ìäÕº¬é!Q‹>ÿ O£åNmèğ3rˆç Fú˜l‘Òúe;¤Mãß·…ŸºÏ½_a ´!~C»¼f€úå¼b}3œ K¼føÜí. 	Ùä}.©ş»ƒDX	i5¿|úŒ?ğÀ=\0õ±?ï?»ø?£Ş@ˆÿÃ•£½fu~a^’Ønûáªy±Q;ï q¹ÌàŒş)€s’S½,\"G†\nu%ÊÇU­YïAKl\nÓëBØIÊ86VCcO\0Ö`}.x©ƒî„,-Ná‡@~ºèœTÿG›çü–'üÄdÛJƒ÷‚ŸÆy1ƒzl‡á½Ã¦f÷gõ·ùAB aõ!şŒM\\<ƒgÊƒız4Æ¿ìÜ@/³ŞCÜÃ‚ì@õ	¯Qq÷)¤ûxäÁ/Ã.7inD±#=Àœ *79cÂF²ËÑd2(¶ .ÀV€À3µ¿ùÚ\$g`ˆAá§‹rl|øm˜²¶b§‚/¯qE²›ÕÃ´!bU@œ¿9iâ;ppÊdííÛ×¤=ğ1ùy–x°x	™=€v=ø®(v±ï¬s_œ³BoòÉ‚ãÖ#àK\r nñîÈ\\—# Ûf˜PXĞu-3&«	½›J&,FÊ(9¶v´0Á&@khZòy¶gîCÔ‹€z Á”Ãã¦hi=¡s9TñÂ eT>gŒÂ3ëdŞtFûö2b&:¾ğ\0ĞP¡÷€B–š-¹QËº8~ÔLSÆMàˆ™Ú·cgĞÎğTh'òf(Ñ³Ğ\$¨.EŒ«§VLÀ°·œAıI¼ãÃßŒñ†¹¼râ¦ãêgÛ\rÜÙã0§¶œ‚ëTëÎ1P`1’dÔâôÕÄ\r¦4âÁÚ=6@FüÁ¼È F±Ìñœ=¿É‚6ÏA¾Â>åN¥AVß	èÙÚ(\$ÎA/¦·ØÚõ¦;¦­çÚ?¾gŒf^	¬\nè&ğKO³Æn„{]õĞgË›Î8åc¬ÒÑ„–²Ï·Şı³ÿ‚\nÈ7LĞŒ¶‚t:ÒÑ ³hF°VO\r³èJú)bƒ(\"OBÌm°	oØß\$]T„SHÎZ^½õKŒÿ©äwğ\\[A9('ÒÙ„cÛ‘â­Üàb0‚ØÙÄ K’à£åà²srB™x\nè*BaÆz6oƒ\ry&tX1p'›^ƒM·¹<âCg¹`Ì4Ã8GHõ“zd?gX›†.@,‹7wÃïÛ:+ƒTiUX16à“L¸Üs’:\ršLè6‡Á±ƒf—r\r`ãtà67~g°xˆgH9ãJÀ¿O=-\$ğ4?rÙª4½ƒ¨¡O›ûè:z¦§{ÈşD`ó¨‹Ğ21FŒÜµ£Ğ(DòMÓÊ;¥º½ñ&–¡ÍÌ©ÔÚ­¾ƒU>ÎI˜6‹™cİÄò›ß¸@\r/œ/¸¶Ô•ıó_HÀƒ\n7zë ¶ü€“œ‰7òaî É»[9D¢'ü„¿ì}Bÿ€O›R‡ôİŸ¸B#s“¼]z!(DÀ“Å@L^„ı	û³x£İ@oá¿u„OäïÁ¥D¸ÏÜ!e`\na³k>´0`á„€Ì-*™ ˆ8E‡Z6=fÌé%¡™İ×cã›°”K=£ò¤F‡\rÊ…ÂShèyNò[v*vá\rÁää@#ß¸í‰ªAh*ãL\$°À±AÀA\\”¢‚úÓ%Á*	ÄçpŠ\r*==8ì\$Wî\rƒ [±“Jx0yñÛZÃ+&YÙHA~A\n,\\(Öìp¤!F¶êÚ<6SØ&IP`6Xzü+í£dfŞ\r¾ÏJÂ£€ŞÌië•sã+Ò&5¼å/rE…À£M^\$R(R‘QÌÒEw3‰ôlH*m\0Bq¬aŒ¯rèêLB“ª¥Q¹z6~lËùB‰\rIÂ®GøæXÙ¸XVbs¡mB·Hª×ó™ócî_Kç\$pæ-:8„•Nj:ÂÑ…Œ¡-#¢Få	\0’aiBÆs\\)Î<.!Æİ\\ß‰N‹ÒbIw8§Í¹t…øPjWä¨`¶‚y\0ìİ&0˜i?¡ˆÃÒ”:«Ia)=’C†,a&ºM˜apÆƒ\$İI€IFcæ­ç\0!„ƒ˜YÄxa)~¯C1†PÒZL3T¸jİC\0yˆÒ¤`\\ÆWÂü\\t\$¤2µ\næ+a¤\0aKbèíÎ\n„˜]àC@‚º?I\rĞHãƒ®Ks%ÏN©ğ—áË^°ÏÔ9CL/š=%Û¨õhÉÆ:?&PşìEYÒ>5¢ín[GÙ’×%Vàá»*ôw<¥ù­ÕgJ¸]º*éwd®]ŞBŸ5^óÖ¢’OQ>%­s{½Ô…ç•«;ìWö³‰ÖzÂGi®ıÀ*»ùRnìÑG9ĞE°Š¢Ş,(u*°±Õ’Ã—€ŠXÕs«àRŒ¦¦:µ5ë;”æ)°R¶¦ÍNúŠÈvKØ(œR³İM¢œÇbğîÔé©_‡{ÕF<<3ª:%ºÙHVëYS\ná%L+{”o.>Z(´Qk¢ÖÂN«!Ãì,‰:rH}nRÒNkI		ª‡[ò´Ìë’Ó§gÎÎÖ¤;mYÒ³g™%ñ9V~-J_³ñg²­•©Ë\\–É®£Q\n®–!õt«\\UY-tZn¨¡d:Bµ°Ê½Ü*í]')t“²¥wÁù–É«[BUm*Úr4†Ø–Õ*yv¢¶ÁvZÀÕ¹+GHÎåZn°PÂÜ…|\nT¥ %#\\·AX\0}5b+wr«XwÜ²1uù×%Cg=I­òv`creË0`..<·êğh‰+ŒHÌ^\\j­yFòİ%Ê]¹BÊ\0ÉrÅ+€> %Zx¹š æ%C.ªÃìÄ`Vn­1KS¾¥Îk\rƒõçX|´õ[Ì;õ6H	U@©D:Ş»Mj	Î•ÛÊ?ıª]Ú¤Øˆb“A+ÔÅG£\0thxbşÆL`”ÅÀ64MŞ›ÄôŠY#ºhfD=e€Øw=´c˜+H…ñ¡¡:„.%ü^\$òDZrAzjÿfLl›7’o¬Œı°Û\0¨-äÜ³EdäŞ‰yz'V ­“Ó¯W´	Zö§K˜+°d(AÌfyŞP?‡xRš^hõ…¸'•æàA\0ˆ¯:p\r„d(V±ŒÜ½šdöt	SîFcHÈŸ¹]r¢rÊCHY	X_º/fƒŒİÍ½ 4 7eÚ6D³{,ÑèşêØ<<Z^´İj\"	éµ\n+Æ€M…Y9…’A‚(<Pl¤lp	“,>Ğ€¤{E9Ü&àGhšh{(ı±Agg8 (@ŞjTûnËg€Zã†ÙÅ°ÁJˆÁŠ³x¦˜Œü¼@ic¶àÕ‹ô(pƒ'oJ0MnÄ€í&Ê§³\r'\0Õ‘ø„\rqÑFè4½°Š)ı½cL˜§ş_ÀoJÚ}5ïÚc–o¨àà|6„m¾}Qª£á4QëÇb„·µ[úx«m( İ&µ@ä;Â+ò˜¥®ÚÅf|IÎàõ”RĞ48… {	`øè®çk`u»r`èWã¸±`\"´)fI\n©Ô;ò8ZjÍ‡–gğ~¡šAÎˆè!j¼Ä%ÄæT ÂE\\¯\r3E“j‚jê¢FXZ	âÏAyækH ØXdğgCQ“–±´áÎ€ş0ğd”ü²¨°ïû¡†út¨	œÇzkÀ`@\0001\0n”ŒøçH¸À\0€4\0g&.€\0Àú\0O(³ÈP@\r¢èEÄ\0l\0à°X» \râæEä‹Ç8Àx»¥›@ÅÔ‹Ö\0À¤^˜»±z@Eğ‹æ\0Ş.¤^¨¸Qq\"éÅà‹æYäÂD_p&âÿ€3\0mZ.Ppà\r€EÏ‹÷sˆñv\"éÅá‹ç0´`ø¿wâñÆ,óü¼_¼`\rcÅâŒö/Ô]x¸q‚€€3\0qÎ.p˜ÂqŠâğ\0002Œ_ì³i„ˆÄÑŠ¢âEÆ\0aŞ1äbÀÑwJ \0l\0Î1,`ˆº1y\0€9#?0T^ØÇq‘£\$F6Œ/\$d¨¸‘‚€FDŒyJ0b˜»\0	ªÆWŒ¾\0æ.œc¸Â‘{c EØ\0s†3l]@\rbùFŒ\"\0Â2ô`˜Á‘’\"ñ€7‹µÎ/à\0±š¢èÅÓa	^04e¨ºQ{c<ÅÑŒÉj/_˜ÁÑc\0001Œµ*28BAàã\0000ŒxÆ”iØ¾1˜£F50ljH¸‘™\"éFŒ30\\_ˆ¾q™\0ÆfŒ¡T³l_0Ñ‚£BEÄŒ#3ì]øÒñs€Æ½‹Ó†64_XÀ1–\0Æ½‹ñà™d`ø×`\r£SÆ_JMV/f€±­€1\0005I6tf€°ã4Fª‹Á¶34fà‘ ãF-‹ß’6Œd‘±\"÷€4k½„\$h¨Â± #EÅÌŒú\0Ö6¤_01—c@F‹áª/d]X×Q£#G\n‹÷†5¬g¹q‘ãEF\nŒm\\ÂDn˜Åq½£YFv1/4`øàq½ã€4=â8b×q|À\0004‹‰3ÄmXÁ1‹£e‘ö\0Åî.¬\\èàQ—cIÆ	·.7ü\\xÖ`\"íÆ\0i^3ğ(ç±’ÀÆ\"Ev4l_ÈÈq®Œ\$Fñ‹±àœoÈ¾ \r#UEä©^9ütˆÁ‘¹¢ïÆ.\0Ş3|rÈÄ1¿\0Æöù69l^x¹Ñ¼PF-]\n0ÔvˆâQy\"íG‹³2,sxÁQq#™F+Œ\0Ù/DiÈëq}£ÀÇ8[6,jø»\0cmÇo×N5¼ehàQv£«GL€H<T_ĞQ®£?FÉ‹É..\$føÛÑyãšE÷ŒC2Ül¨Û1s#ØEéŒD³lohÙÑ²£j ‹²Â8Ôe¸Å±ÔbğF!õÆ9Ü`xÓq¨£§–CÆ7ÄhxÕÙ£ÆÅ»ú7œ^xÍñğK<Çhƒø	,uØé±‘ãG)Ú;luàÀ#îEß¹ş<ükÛÑíbşÆÜ\0sR.¬w¸Ö±#zÆ~w’2|x(Ú÷âğ\0001'†:Üv‰\0001‘ã¢GæŒ¿¦?|`øò‘£‡ÆóÛ .2¨XÜÀ#“G¨8KÆ@<z¾1–£Æ¹\"9|jˆÒÑĞã	G¤/æ6ÜqˆŞÑö€GÁsÖ7ù/\0001‹büÇßí¶:|ƒ8ÚQÚ#~F»W‚4ég˜ÌÒ#<F\rµ š2üƒXÁQÌ#ÿFvkî7´xÒ1Ú#ÎÅÆ›¦@¬rhÜÑÀãêF”íZ;¬fÈårc¿y‹‘!\r	ä_xë1¿\"üH1Ï¶0TwèÙ²c\rF1 \n8dX»rãĞÆÔŒ§Ş2Dbèı±{d4HˆŒrA<~ÈÙ1±dBHI[J?¼¸ÅÒ£qÇ~kº0ÔtØØÒ#„F\r#0\\h¨î\r¤GÈí’EttØè‘íc7ÈUŒ¿!Ö=D_ˆèòcNÇ\0‘yÖ6aÙñë¤ Fgç!v1ÌqØÈ1ØãKÇ‡»â@äeè÷Ñ³cGoó\n/¬ŒøÆ²ãˆEã‹Á\"3t`©ñö#cHµ‚<ÜcøÓqâüFî%†?Tbè¹±°d)Ç‹© r0‚øÌñqc¿Eøã>3\$tyQÒ£…ÉE’Cl`9)¤VFHMJ7”føöÄ\$HHQ ;üri’7#F³-F¤HÆQ÷#\0G·!‚1ä^Èş&4¤vG&‘û7Ôgèà±ƒ\$\0G\rr/ÄdÙR¤(Æã‘s6@¤“Ù'RAãÇ¬›È”Œù&‘¢¤–Çg\0k z=´|HÙ±Éã‡ÅàŒÉ^J´]ÀÑsd¤Ç,\$’1”¨à<cqÇ¦’ŸêJœ_øÏÁbçGˆQvJ´¸Ø±ŞãH5Œ¢FôpÜÀIc¬È[‹‹Î@ÔrÈÏ¤vHå%ã¶3D”¨Çòc<I\$M.d—Ùr1c=F÷.4„cˆÕ2béG.Œ!¦L|{X×Ñ³£{I«NFôdx÷qscŞÆİ¿#şE¼a)‘Ñ#¹G”ƒJ¬m¹.‘û\$=Gh’AN=¬s‰ÑÅ¤EÍ‘GşG\\a1ò0¤ÛH¡‘ÁF.tg8ê‘Ã¤[Èòÿ¦Idn¸şò8ãF€‹ÙÖ.T’¨ûñ·€F3‘Eº6riq¸ãsF¼Ö6ÄxºrãÚÆL=nFTÒod Ç>-ª3ô|©2\$ı0„‘= â:‘xc’HËI\"NP\$b¸ÛQñ\$Fñ ®DÄ‚˜æÑïä}FêŒ%ª?äŸ(î£êÉG”3\$‚O\$^xÂ2T¢éÆñÕ0Œ¡ğR’‹Ì#ÈDŒ:„òE¤|i/2Œ£XGˆ’”’8¬•¹-ù\$HÉv¥Ö=dš‰ è¤Ç`’ù’:laxäÑú¢ğI¦¢:ì—XâRJ¤Òñ”ÒRÌmxê’J#\nGG“9!N¨ä{cIõ’Ó&æI¬ éR=£€I\rŒù&j:ä‘8ÃÒg#¸H‹á'3„_x¸²b¤H}”£>7ƒèèñŠcÌÇÙ\"&K<xØÊ2¡ãçH†‹¥\"6@dbèë±­e;É)Œ!–.Ä]ù/ò‘d—Êm*f6,v©—ÉªÊ‹£ªLäÉ(qµ£AI8”7d„9TtcôÊ’‚UL•XÈò%H¡”I*z:Ì|IXqsá¨ó-ÂBĞÅäq^(•R¼»aq(~eÑñ¯§ 9JèU‡+-eq*nTà­Ğ>¡\$ÕÑ«er’•Î±¡p\nÅÕ¼Ë\$es+îV£IšºÇb«øeq:ß#]•cc®7r\nÙf,gYø³TC²%Œñ	Ô}Ë\0–²©\\*ìEWPæaè:ÏE¥,&WòÆp)Å¦Ëxl²MáÂÄ3\0t\0¦/IipñD'\0	k\$T¤¬F‡¤]fºÍdMòÈ€K\$”¼ıH(@îÉ”‹»(–zµnWÒ¤Ù_ŠMİ”*º\0¦eÙlF™^H	W*B––ZPe½ÅÖ˜‡ÓR/dRÂ—RÊ…\0Ku£,yH)¶\"SÊXI'®¹Zƒ=çLøRå3åÄÒ\nÀ'š[kğ­Í6@;}R”íıI²ò³ô¬_é) wê‚[óÀ û\nß´n–ª¼ŒÊ“bBr¸l,\$vÖíÍİÔ°‡ˆÀÕH©à‡…\\¢‹Ùs*È ºå–.Qt’B…ºdˆb‘½—@ï?3¼S`a@¤Kª\\.«´à~Çfª)¬«¨ï,?|&Ó¶KÀ£…Z9.İX³+S‘â|ÀœØ\0PÊ¼¢ŒE“òçe‚/Ê\0VëÖ^KÄ\0\n-	:ËÉSØ²)×ªû0j‘9TX•åBğƒ½K\"åÅ¯±•Â²,2Æ'‡2ËåÖ˜P,¡xŠôàpÀĞáKê—ª´š›õ\"ÊD¢#TV²œD¿õ1ñAo;Ø•×/9TH%V`WJ<9˜¯aeÊ° K/V^/¨Q†¤Ø\nBñZ\"9íËÆXÒ¯M~\$°5„ŠßÚ\$0dè½I€U“Í³2¼^X\n¼*ãE7I\nV3«–…+ÎaŒÃIiÒÒNËKK˜g0’aŒ°„z*“V©º#bJyMÒ¦eõâZ– …V ¢`’ĞòĞU1ËC˜Ÿ.\rF²ª-jÎ&LU˜p§9s‚é¹Š+Q&1¨âRm¥ÕÓ±gZª²–	,.XryZì²°0¨ÏÜ3¬2˜A1©Ö‚’e‰Nû©¸˜ú²(?Al ŞÌ,Nèue²Ï\$|rùá_%²ñE05E}³\$¡Ü…X2«%ÚZªe €\n\";<9a¾hã¶¥àa]úÊì™8±à*éu¯åÁªL¥¦¶±dR¿ğ0«¸Áª+ŞQm.ü,Gù–«¦M®ï_±2åedBêÍİ¸,°S…2Á²>UÕêëÔ°»4vlë~e2©ò2¤eÄµËYg2nf’=Àş\$%óÌÙ–Ffaìµ)‹ê§å”ÌfTÆ¶áG¤Í×g2ºW,[™šíÊX>)tÊA]œº™R*º&Z·Å6j2|‘¥\0 °(©p	ê9× ÌùuÒªô?ôĞ`nåœ-lZnë!H9²çæzLğš¢9VLÏ¹yÒĞİ¢ZØJhR›‰g“EfL©UŠ²~`4ÍYˆçæx)\$B±QR#Ã•Sê”¥ËËõ,6i#ÀY¦“,;C±šr¬âiÙ&ÇXªû]èÍ\nw54­K‰x\n*&©Tš£îWüÓùŠ“¦©+SĞ»qNc·yóIWä¯Û\0W5cÔÒÉ«‹ğ&+š¶ğVrå)¬êÎ£Kgšª¾Ô?‰ µŠ“¥|«gR¦¯†hR´%Kë¹œ)Z#‹5ä,Öµ–k…æ¼»`šìl:à•LsC”[M‰UB©6ldÑÑ“J¦°ªŸ•ï1nl:ºù•j¦ËLß–¢\0®hã¶ *)¥p/®šŞ§5\\”<9´óV¦…/‹šŞ«®hTÇdjµårMbx\nˆ]R¹çWªR‰ MaUµ3=×µ`0³oÈË,Z™¬³lÀÅ}Èó¦m¨ì›”í²lôÎ´ÕmLåS6ê\\’tÎ™¹òºèL—îÉ\\Ï%‘J¶”ƒKå™ñ7oÑ©Ÿ¤ef€Mš£’oC»Y¡“væ…­NVÃ4=RÑ¢sJİÉÍö¬¶*hÔÕéhnäæ-m›é4‰ß4ày¤óHñMû›|îÊis¬U=ƒİÚÍA\$Ú­òi¹Ï™¾“…öÍ>–êîÊpâ¼pûóQfø«îšÀ§ªq,ÔÕ5sŠULùš£8}İ¬ÅÙª“Œ÷#ÃXH±ÙİìßI««î§¼9Uµ8íc:³I»îíf´ªĞ±7Òklä5}Ğ÷f¹LY•ğ¬áN2Ş°ó}&½	išê®ñc,åI¹3‹ÚÄRœ©6räØ‰Ì3b¦ûÍœÇ6>lXY¿ûfıLœ)+ÙS,Ù‰Ì*ùelÍô™U\"edæº\"ZçªÚ–6’ZDßE9°á%ÈÎ‚›Y9rmtãEĞó'.M²[4¬‚^„åÉ·ë;M»wÙ5…×Í9¸Òóa¬¦v+70lÍÉÓÓd%£Ì<œù3Š_<é•lN²¦Š(€v+7YRlÎ…Óª]‡.•Õ4©I³®)¼³=ÖƒN®Tš]Û¹'U^Ó?çS«¼½7¾XC®Å©Ó¨Õ1Íu¹9©E´ß™²kçL;œ¤NhÌìÀSİqNXk;1[„ÒõÓLgpVœBî1_¤á¥ÎÅgs¬ š;­RlîÕEˆ×ßNğTÇ8öw,îéÅs¯•1ÍPxrëŠq”ê‰ß3¦¬(ª;ñZÚı	yÓ¾'{O	_´¾êrï™ÈªMg|ÎIó92eLçÊó”f¼O\rYŠnkÜåuŠ™”SNÉv9Vkâ“	Ë3Ç§.Ì›v9zydæ)á“¦ÈNĞYì&s\$ìùÍjd'6Í”œQ<ÍVÜç)èeç+Ï›§:ÑØ¬êYjt¥¡Ãp‡u<±İÊ–Éß3¢]qM°Y:9XãµS³¾gI«Ã*¿mäÆÄCëùıv GßìÜR@ÀÖ¯¬jT—=¨:e ÛÀ(\0_Vn©,?p	3Ş'Î ™¸¨‘Ø™ïÒ\r¬†•¼ö|\"ŞiğºgT’nşPçš¤°\nÓ”åq,ÛSf¸.YĞµQ A¼A‡,ZÊÚeSå›˜sEÀì\rú‘v„T‹¬QŸZ©\"pó²IósëUAÏ›\0¾ëvZ¸}®rÙ¥KŸtféPäf9ç–®¸{¼¶^J€çßÏ‚Ÿ”¿šø©•\n0%«€NGÚ«*~lüD.»¦ÎKeŸ¹6¢[,Ô%ÀˆğOÕ˜É-†~ìµ•–óú¥j®ŸRO;úŒ@	Ë¨en›b_¾%sK¿Åœë‚ÃïYÿæºÎYÑ0ü¥ÃLËWª¦jrßÕóèÏ† ë©!BšÙñ”æ„Pv´£fwÚ«Éø€çãMÃR2´2€zŒ4rúh;Ò#M@…}…\0‰|ëã¨MÃ\0…=Ú=å¡àf-!Ÿ6pÊ g[P4‚´†ÌìóCÚ[5:–‚\rµCt¨ÍÃ u@ıÛº<éŸäif„ĞNu¼n[ñ!u8j{&9Ku FQlR“iÀ(ËC ÇAä®™s4ˆë\0Y Í;fƒB<Ô{”å˜¼R_Iš~š…6ô×|MWTAí]4÷e@J­eÉP|[ú¨–r5*Áÿ—OÎ íBt½)¤ê¯%Ğ-\0Pªjm	usá§}Ğ˜Ÿ“Bi^©Ú*¦zĞ0YK.ù`[¯Yû2íÖĞ«—|°XBÑÅÁÓÁ(?Ğ—±.\$“l¼’³,æÎX¶DçÍ\nêëjæ¡OD ->_<¼¥ÕÖ‡Ù\0š£ÙÕ¬¥Ásøh\\…¡•ea\\Ó\0Êöeä‘™Yµ`¼¥´7UØ\"e¡ÇCYTìñÙzt:V9P™_š³…a‚Ğ•FÔ;İ€\0MŸ¢´†…2“eúëHCéĞóZ‘?îVò¼åœ'×¬å‡ä³}c¾Yüaõè„¬åı?Qh8	ğ´0•Q‡CM`ºŸ«ó6æø,‹Ÿ¢J‘eZ¾Z\"G—Wª¡u†–u\rÕ>49èKı—ğI%L–¹ÍİV9Ïü˜İÖ‰´øZë{VEOÄX;©áÑÏĞoàagPÂ\$\n²RX@}!-Si€òRª¾¢qzÖ	öêITH.¡Ôí\nk\nïš \ndÏ®˜Tº‰²>Ğ\nîÂ– ­?£E…`²Ì5D+f’?#z³…IZü7T[¨€Qs#ùDˆŠ\$«ÕÏPù¢ìI†	û3¾×*¼:İ9YI²ãH‹³ÔH®¬X«0åDŠ!u7J¸–m® YB}Eª°Š³¿—ç®€¢òr”8Q•ù\n}'PõSâ²	Q±Ğõáú¨‘°\$§Å`RÇ)^áõ(O€P\0®aK½µõômè3¬Š\$H.„ùX„ëñÔç)ĞV®™`”­Ú9 ¨.®Y™‘18âÚeUÁ’`Xç9‚´	Œğäç\\Lcˆj°IE Né«ª¦6€W¡D¦XBØ	Z‹:”|Ï¤:	E-P-Ú&ÎÁè¿)ú†ğ§ˆ*ÓúÔlÀ)PÂuŒy|R°³Lhÿ.p¤§é_* QA †@ ·?,Æ§êYêÖ)t‚Ñ‡œ<íÁP*êåÜj’VuQş:2\0L¸?JëçèÑ,TPHL²ÁúE%–¬\0ª¢yP(YJZ¥î©úTHÅX\r	•Q4hOÒ;\\vVõ#åÀTWw‡ï\\`õOÒ¡Å«?ÒJR2³ò’=õFóâ]»ĞŸI5TMjIë9é,(Æ¤Dv|tÉ)ŠWy-¦]z¨Úe‚Œ‰a,pQ6\$ëI-g=%‘SÔW#íTP§Ü¤É)«T&]ŞÑõX15j†”B8„„æVÏÓ¥\nìem y“”h›*è¤ü»„°dç4Ï‚·bd!0¤gR”J\\Í ÖMtƒÀ1R\n\nïâxè¡èÜÁª.ö_¾üuò+Æ¼Ç;ı‹*4ˆÎ¸)]À\\¡lÜ(m\"ñƒQ†nTˆ(*\0¬`ğ1Hì@2	6hàêYÀcH_ÌÚÈfğ?°Ğa«–7=KKdeÂt÷HàÀ2\0/\0…62@b~Ë`·\0.”€\0¼vÙ) !~º€JPÄT—Á½ô½’–…µ¥óÂ—ÚOƒ{t¾¾\0005¦¾˜/à¯€\r©ƒÁJ^ğ½0Úa!¶)€8¦%KŞ˜PP4Åé~ÓH’˜á÷ĞÅô¼Üí\r+¦Lb˜¥/24)“Ó¦GKê™e0ŠeËé€S1¦B¨	-0jfÔÄéšS¦wLÎ™Äiêd …é Ó¦Lºš\r1ºhôÈ©œS ¦—MJJÊht¾)¨Ó+?L¶še5n”Óé|FHŒÉMN—õ5êjÔÉ©™SH“ÕL–—å4É=TØé´ÓD“ÕMnš½6Zm@I@S`¦)'ª™Õ7fòz©ŸSz¦x~OU1k”¿¤õSF¦ıMOU4ªpôÙ£2\0000¦ì¾7…6ŠkÑ#xSl§'Kâ7…7\nl”ÍãxSu§LR7…7šstßãxS}§GM7…8*qtÓ#xS†§OM\"7…8ªuôë)ÆÓ\0¿’š•9úr™)ËSr¦‰2šı; ôğ)ŞÓ7§Nj›m/Šxç©ÕÓ¿¦sNÚ:jy4¿©àSª§gO:1ı=\ncTö©§SÍ§•’œ•;ê{ñ¥©îSÈ§/ORH\r=ÊtTôéŠIİ§¥O˜¤\\zx4÷©Sò§‹MşŸ•>j|TıiºS¶‘³O†™¼š~ôĞ\$lÓú¨Oöš}tüÈÙ§ßOî˜¤šzÔû*%§]PPüšvU\"úÓİ§¯Kâ í@\noõjÓH¨;P¡>š1£éÿFd¨P.5BØ¸•ª\rÔ¨3œuB¹<µL#Ô<¨QPECÊu*\nÅÛ¨yPN¡´lª‚õ\r‹6Óó¨?Kú¢mBZi•jÓH¨›O2¢}1J‰µé›ÔM¨_Mş¢mDŠˆ€ê&ÔK¨ÇQ6¡­Fzv´ğ‹6Ó¹§éQjå;jµj)Ô*¨Ş¾£mEÊŒª9Fd¨ÅQv5eGØÉµd¤Ô„¨EM\0+åDêƒ\"j)SD©QÒ¤pZfµéÆ‚§mR&¢ıHŠ’U’Û%§{Rv0m0z”¥ä§ŸLÆ¥@ú”'ÖÔ©ER¶?eJ÷>é¸Ô¨İM’¥µIú•²ªYT¦ÛRõ/¥BÊ•.êUT»©YRÎ¡L:™jNÔ…©•Rš¡İLú˜5ji&,‰Oê¦mJDß5,ã9ÔÀ©­Q¦©Íè•1êhTf©›NÈ˜ÒÑŞ¥Q€'©Î7¾§Lih¸²\rcjÔŒ‘Sz§ušŸ\0nãÔº©g¶§Ø9Õ@cÕŒ\rT§%LÅÕAªfT­MT9uQ\nŸÕ)¢çU©µSº¨uD:“±—jˆU	©­Æ¨…PÚ–q‰*‚EÚªKSb¥l\\Ú¤µFª”ÔÅªGTz§gJ¤µHªSFª	\"©½Q:˜1‘ê›Õ©;†©½Rê¦µL*~EßªoTÒ¦\\z ‘„ª¥Õ:©­âª]Sê•±Ÿª¥ÕBª“U¨^J©uR*kEõª	ªıTêœQtê¯ÕR©g2ªıUj«µV\$ÅÕ_ª¹Sˆ³mPHÆU\\ª±TüŒ[UÊ«5JhÙµ\\ªµUpªÙ¢«•Vğ7a_*€Ó«¬=R‡>\0I*¼¥ô”V«íX:hU8jÉTæKZ’¬\\:ƒÕ)jÇT·«8˜±	åWZ³Ub’òJ8«R­=Y³UVU–«R¬¤\\:™Õ-jËÔÑ«iV.¦¥[z´±ÒªÂÇ-«{T²­ÅZªuoj×U»«3 ¡Í[ª±Õ>ªØÈ«E ­%\\º±µh#bÕ…‹©WZ®-\\º¸õCêæÕ«»W>¨­]Úºg4#¶ÕÀ«KTr®íZÊ¤wjãÕ\$«›z¬-Rj½õtjĞU*«ßWš¬tp\n¾4õ€ğ'–N•Mº´²ªxUş™X32[xò•+®“Ë\$B°US*½õqê›UÍªqXZ®}SÊÂÕxêÁÕ@¬-W\n5İXZ¨Õ…ªãÕJ«›U2±=\\úª‰ëF+«ñV‚0]XXÁUŒªìÖ0«¬-VJ¹²+Ö/«É‚±ÍZÊ®5sj¹ÖD«ŸUŞ²%bØÉµªÁÇ÷«V²%Yš^u@d¤Õ¢’“WĞæ„”šÅ²Rk&œŒñYR¬\\¤Å’RkÖY©cVÆO-\\š—	kdòÓáKoX²¥KÊÍ/ë9Ö]“ËVªO-U‰<µ™@İÉå¬¥VÎ³[Ÿõ›«6U¹­—Â=eŠÏµo«4Tİ­Yâ0eHÆÕ¤ª\rÊÍ9«¢•¬6à(ó®•+7ÎybÓrI §|Ä\0—:FzğÉè\n…§|ªœs<°R½%JÓËÔ]¦õFèµ3õ­Œ‰j¢Î£¹Y®µZ“¾^<5X·IJòÅM`×nO\\£B&¶r“õsÅçQˆuz¨¢x¼å¹è	¬Tˆ®¤VwÍJ5¸g	Ï?v¨qF4ï•9³Ó·»­Õ6ªzjùèÕ‡OV•¿\rÎuÊ=Â@Ê’fTÍšœğïöy´³	€Ö«pKaXU9šm²³…­\nekMo›Ã5\nhTŞ†ê¦¦…V ®¬v€‚ı:®Ñs®\\p>ÁÒLÓ:¦‹)ñ­O=nk}j¥Sõ«&·Ö®ª~µŠ¤y©àe”¬ÜšßZÖµñ)jØ®”t×VR¢Vµ½sµrÊ:+aÍo­‹,!TılŠUÏ•Ş*n­›5¾¶\\ğU÷dv+’M\\®)]B¶|ñJë´¦l;4˜¯5öpLÖùÓµØ¦7Liı[~bmtÉæSe€\"»°›Bº½v©´d“ç@Í§SÁ4)Ø’—Zï¼»\$)®ñ5ic!™µ´¢½ÎŒ–êî\\Rù*ßSD¦’Îw\$›9ætSÁ\ná”GfòPÔ›ÆîÊ¸´ßÚã*¦	KÍô­D·Vyû¹5ÍuÈ¦J×‘š\\šµC¹•\$“ÙW,¯M\\º»ôåÊæ5¬ëÓ–®k^•VÕsŠè5®k¡Ö»¯M^êµı{Àu°§Ï¤wFQàßJéHûgWN¡k8şºÍŠôÊ‰+¸»§˜¥1brÄíùË•ØëÓVÜX]dLçjí´YT™Îv®ç6–twyË•Şkò×ë­à«vx=…5àh»²ï½ô8—]ÊÁ‘ñË·x\"c|ĞufUÿƒşØ\0˜Ò§5ŞjÈ©}”PknÌšRl¾‰fÙªà+ò“ÑÛ£‚¢>c4Æ×W+TıDo®Òï ’Ç÷qî¯É€SX’¨İb}}Åhnµ&<Ï?™/3º”-Ã¡h†°©qn‰ı§	õpƒ%)SÉyP\r…ÛÍµÿm-Ïf5°Šº[€\\–=ÌTà}øy )ıç Ydç«Ø¤46#Y>¥3ÔŒ× šm©ú\n09h;²4˜°Â0‚Ã+ßae\nÈƒÄ°È!ÊÅüÑ)‘@ôx¢x}‡\$¦ÖßıAFŒúÃ‘²0Nö Rã	º°şÓ„èiÜ¥ü¬U¬?½¡—b5í!+×­\0G˜ıØw{¶îÓ¤—ïlI £)’w-4;p8ÂÎØ¤;@\r\n\r­…ÚN5Æ…F\\Ó¹hgPE il0¦ëX¦%’)\nˆØLkÈ^‚Æ2¢İ<5FØìd‰Iƒ<ñFÆj³bM¬d'á	¶Æ²D£âîBma²ĞÒö…ıOYñXgg¼8¥çZVØ%mf¬Ô%å€F¡-¥,É\nƒ‘ıaù¤FÇwfƒôs¹ç¬Ê0Gä¹‘ØZ²\n	1†;Jí–1Á\"iPñBÈy´C¬–Ìû²t—zÓ‰ãÑÖ;l‚4âÈÒ¡‚ƒJ‡”mLX²+lá˜ªõ{Â8¬\"â\nÌVÁÀšÄÛ(Ú\$Y\0íd\\İ†6›D9B´H±d%¦Óî–1ÛÁ˜6f Ñ\"ÊTJÖÚ`/²‡>ÊC=Äc“ì¨±¼²?e!ık*±3l~ƒÃÓiÿ«,×A‚z/dà¨¦MoìÅí´Ú²nÑ\"É½„ÍÂëÆzTr}eÙŒ{MÀaCÔ7‘fiTºõ—Ë/6W¢©P²ìÖÌ8†Fa`İì¾5³ó©¹M…f2V]œ['}cn4]h·íÖe«¦‹Z€Å§\r™‹2ÉÈ½XllGa`(­™—Û(‚ŠÄò\0èÄıšĞ_ölO˜ùf&fÄ1c8ìD{¼QæÜ	S6öp\0äYÂ˜æ¹˜™î\0\röq…3m&*fÎ;Ìpò6r^cŒÏ³¨—`Éµ&z€n^Ú±ù;DÈèSã¤oj^ã=¿L'g”5œ“Ä&ƒìä‡Ef&ñŞÏ|\nK 6?bX*¬.fÏˆEƒû–~&9Ù!˜çdŒk@‰v\"F¬Gšx\\é=ıEŠ7ïXP2[:Á¶\0ƒ×à¡ X~¦½7·ÍâX6†4²œÉ(Ã\";Bì\nŞıX×Ñhy¹Ì&›DÖˆÛZ¼l\nKC–‰íšŸ†pØ’Ä`mS®	2ĞU¢;Gà•‘8¶´{’Ñ-”±WBmì¸\$F€ø\ràl&B‡Y2\r´¨mAÅ‘°wÄZØ6ØRĞ’¿Ğ%d´ŒİÂÚ_²œTô5¦``BaĞÙG´ÕcáXKö\r¶˜\0­ØgN¼ù\\‘´¾;Nà¨àÄÚs^\nŒÌu§ä¿Ÿ­Ñ²VwzÄU F\"\0T-±,^’Î\0‹Îö—è2 /æ™ óÂÏàEW/\0Â¼ò–ÒÄ¾Ë4;\"ìK-NZš½ĞMcÎ»RVNeœZ¦wj–ÂŠ6ë¯a¶÷yÌˆÙç»‹KV®lN?±Ãjt2­–¶T/[íN¤û±j|0t% #°”€âÑ\0ôÓ`£ø5F<–´ƒ X@\nÓ¢Áí•ËZF\\-m›¼³cd2Äp5Gºv'Bß'¢7{kŠ*'LÜAªZ|I±k´\n-.C¢6¼«¹Çk•-¯×©SÚú°÷kÑ]¯Ë_\$…Ú+Gò× [^‡­­z]kÑÑ8›\\ö¿F|§¢?BˆØÁ^ÏB¨‰Ì|ñ™ë@Š­Â÷B¯¥zPéW/R?[!bB–á¹kÀ‰Ñ '	(ãe:xfàr‚7\r_íâq¶Maê\0#±ä7|éQ&\0É@)µô†À1òë®†LA[PtÀ\0œ™ı`‡6Õ\\e‘Ÿ¶zxÒÚSİ€vÕˆÏ€U:Ú±¿T¼Á‡ˆÏ—>fÛ\nq‹l€Å+K(|¶\\´Ñ G›UØ‹³Æ@(ğ*ÉiS%F¨\rR\$©•C¶¶LĞİÄö;ÉdµìÄ¼gë-\$m?ölhÊŠ3?PªY\0");}else{header("Content-Type: image/gif");switch($_GET["file"]){case"plus.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0!„©ËíMñÌ*)¾oú¯) q•¡eˆµî#ÄòLË\0;";break;case"cross.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0#„©Ëí#\naÖFo~yÃ._wa”á1ç±JîGÂL×6]\0\0;";break;case"up.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMQN\nï}ôa8ŠyšaÅ¶®\0Çò\0;";break;case"down.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMñÌ*)¾[Wş\\¢ÇL&ÙœÆ¶•\0Çò\0;";break;case"arrow.gif":echo"GIF89a\0\n\0€\0\0€€€ÿÿÿ!ù\0\0\0,\0\0\0\0\0\n\0\0‚i–±‹”ªÓ²Ş»\0\0;";break;}}exit;}if($_GET["script"]=="version"){$q=file_open_lock(get_temp_dir()."/adminer.version");if($q)file_write_unlock($q,serialize(array("signature"=>$_POST["signature"],"version"=>$_POST["version"])));exit;}global$b,$f,$k,$nc,$vc,$Ec,$l,$rd,$yd,$ba,$Vd,$w,$ca,$oe,$rf,$ag,$Fh,$Cd,$S,$ri,$U,$Gi,$ia;if(!$_SERVER["REQUEST_URI"])$_SERVER["REQUEST_URI"]=$_SERVER["ORIG_PATH_INFO"];if(!strpos($_SERVER["REQUEST_URI"],'?')&&$_SERVER["QUERY_STRING"]!="")$_SERVER["REQUEST_URI"].="?$_SERVER[QUERY_STRING]";if($_SERVER["HTTP_X_FORWARDED_PREFIX"])$_SERVER["REQUEST_URI"]=$_SERVER["HTTP_X_FORWARDED_PREFIX"].$_SERVER["REQUEST_URI"];$ba=($_SERVER["HTTPS"]&&strcasecmp($_SERVER["HTTPS"],"off"))||ini_bool("session.cookie_secure");@ini_set("session.use_trans_sid",false);if(!defined("SID")){session_cache_limiter("");session_name("adminer_sid");$Pf=array(0,preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]),"",$ba);if(version_compare(PHP_VERSION,'5.2.0')>=0)$Pf[]=true;call_user_func_array('session_set_cookie_params',$Pf);session_start();}remove_slashes(array(&$_GET,&$_POST,&$_COOKIE),$cd);if(function_exists("get_magic_quotes_runtime")&&get_magic_quotes_runtime())set_magic_quotes_runtime(false);@set_time_limit(0);@ini_set("zend.ze1_compatibility_mode",false);@ini_set("precision",15);function
get_lang(){return'zh-tw';}function
lang($qi,$gf=null){if(is_array($qi)){$dg=($gf==1?0:1);$qi=$qi[$dg];}$qi=str_replace("%d","%s",$qi);$gf=format_number($gf);return
sprintf($qi,$gf);}if(extension_loaded('pdo')){class
Min_PDO{var$_result,$server_info,$affected_rows,$errno,$error,$pdo;function
__construct(){global$b;$dg=array_search("SQL",$b->operators);if($dg!==false)unset($b->operators[$dg]);}function
dsn($sc,$V,$E,$C=array()){$C[PDO::ATTR_ERRMODE]=PDO::ERRMODE_SILENT;$C[PDO::ATTR_STATEMENT_CLASS]=array('Min_PDOStatement');try{$this->pdo=new
PDO($sc,$V,$E,$C);}catch(Exception$Lc){auth_error(h($Lc->getMessage()));}$this->server_info=@$this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);}function
quote($O){return$this->pdo->quote($O);}function
query($F,$_i=false){$G=$this->pdo->query($F);$this->error="";if(!$G){list(,$this->errno,$this->error)=$this->pdo->errorInfo();if(!$this->error)$this->error='æœªçŸ¥éŒ¯èª¤ã€‚';return
false;}$this->store_result($G);return$G;}function
multi_query($F){return$this->_result=$this->query($F);}function
store_result($G=null){if(!$G){$G=$this->_result;if(!$G)return
false;}if($G->columnCount()){$G->num_rows=$G->rowCount();return$G;}$this->affected_rows=$G->rowCount();return
true;}function
next_result(){if(!$this->_result)return
false;$this->_result->_offset=0;return@$this->_result->nextRowset();}function
result($F,$m=0){$G=$this->query($F);if(!$G)return
false;$I=$G->fetch();return$I[$m];}}class
Min_PDOStatement
extends
PDOStatement{var$_offset=0,$num_rows;function
fetch_assoc(){return$this->fetch(PDO::FETCH_ASSOC);}function
fetch_row(){return$this->fetch(PDO::FETCH_NUM);}function
fetch_field(){$I=(object)$this->getColumnMeta($this->_offset++);$I->orgtable=$I->table;$I->orgname=$I->name;$I->charsetnr=(in_array("blob",(array)$I->flags)?63:0);return$I;}}}$nc=array();function
add_driver($Jd,$B){global$nc;$nc[$Jd]=$B;}function
get_driver($Jd){global$nc;return$nc[$Jd];}class
Min_SQL{var$_conn;function
__construct($f){$this->_conn=$f;}function
select($P,$K,$Z,$vd,$_f=array(),$y=1,$D=0,$lg=false){global$b,$w;$ce=(count($vd)<count($K));$F=$b->selectQueryBuild($K,$Z,$vd,$_f,$y,$D);if(!$F)$F="SELECT".limit(($_GET["page"]!="last"&&$y!=""&&$vd&&$ce&&$w=="sql"?"SQL_CALC_FOUND_ROWS ":"").implode(", ",$K)."\nFROM ".table($P),($Z?"\nWHERE ".implode(" AND ",$Z):"").($vd&&$ce?"\nGROUP BY ".implode(", ",$vd):"").($_f?"\nORDER BY ".implode(", ",$_f):""),($y!=""?+$y:null),($D?$y*$D:0),"\n");$Ch=microtime(true);$H=$this->_conn->query($F);if($lg)echo$b->selectQuery($F,$Ch,!$H);return$H;}function
delete($P,$ug,$y=0){$F="FROM ".table($P);return
queries("DELETE".($y?limit1($P,$F,$ug):" $F$ug"));}function
update($P,$M,$ug,$y=0,$eh="\n"){$Si=array();foreach($M
as$x=>$X)$Si[]="$x = $X";$F=table($P)." SET$eh".implode(",$eh",$Si);return
queries("UPDATE".($y?limit1($P,$F,$ug,$eh):" $F$ug"));}function
insert($P,$M){return
queries("INSERT INTO ".table($P).($M?" (".implode(", ",array_keys($M)).")\nVALUES (".implode(", ",$M).")":" DEFAULT VALUES"));}function
insertUpdate($P,$J,$jg){return
false;}function
begin(){return
queries("BEGIN");}function
commit(){return
queries("COMMIT");}function
rollback(){return
queries("ROLLBACK");}function
slowQuery($F,$di){}function
convertSearch($t,$X,$m){return$t;}function
convertOperator($vf){return$vf;}function
value($X,$m){return(method_exists($this->_conn,'value')?$this->_conn->value($X,$m):(is_resource($X)?stream_get_contents($X):$X));}function
quoteBinary($Ug){return
q($Ug);}function
warnings(){return'';}function
tableHelp($B){}function
hasCStyleEscapes(){return
false;}}$nc["sqlite"]="SQLite 3";$nc["sqlite2"]="SQLite 2";if(isset($_GET["sqlite"])||isset($_GET["sqlite2"])){define("DRIVER",(isset($_GET["sqlite"])?"sqlite":"sqlite2"));if(class_exists(isset($_GET["sqlite"])?"SQLite3":"SQLiteDatabase")){if(isset($_GET["sqlite"])){class
Min_SQLite{var$extension="SQLite3",$server_info,$affected_rows,$errno,$error,$_link;function
__construct($o){$this->_link=new
SQLite3($o);$Vi=$this->_link->version();$this->server_info=$Vi["versionString"];}function
query($F){$G=@$this->_link->query($F);$this->error="";if(!$G){$this->errno=$this->_link->lastErrorCode();$this->error=$this->_link->lastErrorMsg();return
false;}elseif($G->numColumns())return
new
Min_Result($G);$this->affected_rows=$this->_link->changes();return
true;}function
quote($O){return(is_utf8($O)?"'".$this->_link->escapeString($O)."'":"x'".reset(unpack('H*',$O))."'");}function
store_result(){return$this->_result;}function
result($F,$m=0){$G=$this->query($F);if(!is_object($G))return
false;$I=$G->_result->fetchArray();return$I?$I[$m]:false;}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($G){$this->_result=$G;}function
fetch_assoc(){return$this->_result->fetchArray(SQLITE3_ASSOC);}function
fetch_row(){return$this->_result->fetchArray(SQLITE3_NUM);}function
fetch_field(){$d=$this->_offset++;$T=$this->_result->columnType($d);return(object)array("name"=>$this->_result->columnName($d),"type"=>$T,"charsetnr"=>($T==SQLITE3_BLOB?63:0),);}function
__desctruct(){return$this->_result->finalize();}}}else{class
Min_SQLite{var$extension="SQLite",$server_info,$affected_rows,$error,$_link;function
__construct($o){$this->server_info=sqlite_libversion();$this->_link=new
SQLiteDatabase($o);}function
query($F,$_i=false){$Re=($_i?"unbufferedQuery":"query");$G=@$this->_link->$Re($F,SQLITE_BOTH,$l);$this->error="";if(!$G){$this->error=$l;return
false;}elseif($G===true){$this->affected_rows=$this->changes();return
true;}return
new
Min_Result($G);}function
quote($O){return"'".sqlite_escape_string($O)."'";}function
store_result(){return$this->_result;}function
result($F,$m=0){$G=$this->query($F);if(!is_object($G))return
false;$I=$G->_result->fetch();return$I[$m];}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($G){$this->_result=$G;if(method_exists($G,'numRows'))$this->num_rows=$G->numRows();}function
fetch_assoc(){$I=$this->_result->fetch(SQLITE_ASSOC);if(!$I)return
false;$H=array();foreach($I
as$x=>$X)$H[idf_unescape($x)]=$X;return$H;}function
fetch_row(){return$this->_result->fetch(SQLITE_NUM);}function
fetch_field(){$B=$this->_result->fieldName($this->_offset++);$Yf='(\[.*]|"(?:[^"]|"")*"|(.+))';if(preg_match("~^($Yf\\.)?$Yf\$~",$B,$A)){$P=($A[3]!=""?$A[3]:idf_unescape($A[2]));$B=($A[5]!=""?$A[5]:idf_unescape($A[4]));}return(object)array("name"=>$B,"orgname"=>$B,"orgtable"=>$P,);}}}}elseif(extension_loaded("pdo_sqlite")){class
Min_SQLite
extends
Min_PDO{var$extension="PDO_SQLite";function
__construct($o){$this->dsn(DRIVER.":$o","","");}}}if(class_exists("Min_SQLite")){class
Min_DB
extends
Min_SQLite{function
__construct(){parent::__construct(":memory:");$this->query("PRAGMA foreign_keys = 1");}function
select_db($o){if(is_readable($o)&&$this->query("ATTACH ".$this->quote(preg_match("~(^[/\\\\]|:)~",$o)?$o:dirname($_SERVER["SCRIPT_FILENAME"])."/$o")." AS a")){parent::__construct($o);$this->query("PRAGMA foreign_keys = 1");$this->query("PRAGMA busy_timeout = 500");return
true;}return
false;}function
multi_query($F){return$this->_result=$this->query($F);}function
next_result(){return
false;}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($P,$J,$jg){$Si=array();foreach($J
as$M)$Si[]="(".implode(", ",$M).")";return
queries("REPLACE INTO ".table($P)." (".implode(", ",array_keys(reset($J))).") VALUES\n".implode(",\n",$Si));}function
tableHelp($B){if($B=="sqlite_sequence")return"fileformat2.html#seqtab";if($B=="sqlite_master")return"fileformat2.html#$B";}}function
idf_escape($t){return'"'.str_replace('"','""',$t).'"';}function
table($t){return
idf_escape($t);}function
connect(){global$b;list(,,$E)=$b->credentials();if($E!="")return'è³‡æ–™åº«ä¸æ”¯æ´å¯†ç¢¼ã€‚';return
new
Min_DB;}function
get_databases(){return
array();}function
limit($F,$Z,$y,$jf=0,$eh=" "){return" $F$Z".($y!==null?$eh."LIMIT $y".($jf?" OFFSET $jf":""):"");}function
limit1($P,$F,$Z,$eh="\n"){global$f;return(preg_match('~^INTO~',$F)||$f->result("SELECT sqlite_compileoption_used('ENABLE_UPDATE_DELETE_LIMIT')")?limit($F,$Z,1,0,$eh):" $F WHERE rowid = (SELECT rowid FROM ".table($P).$Z.$eh."LIMIT 1)");}function
db_collation($j,$pb){global$f;return$f->result("PRAGMA encoding");}function
engines(){return
array();}function
logged_user(){return
get_current_user();}function
tables_list(){return
get_key_vals("SELECT name, type FROM sqlite_master WHERE type IN ('table', 'view') ORDER BY (name = 'sqlite_sequence'), name");}function
count_tables($i){return
array();}function
table_status($B=""){global$f;$H=array();foreach(get_rows("SELECT name AS Name, type AS Engine, 'rowid' AS Oid, '' AS Auto_increment FROM sqlite_master WHERE type IN ('table', 'view') ".($B!=""?"AND name = ".q($B):"ORDER BY name"))as$I){$I["Rows"]=$f->result("SELECT COUNT(*) FROM ".idf_escape($I["Name"]));$H[$I["Name"]]=$I;}foreach(get_rows("SELECT * FROM sqlite_sequence",null,"")as$I)$H[$I["name"]]["Auto_increment"]=$I["seq"];return($B!=""?$H[$B]:$H);}function
is_view($Q){return$Q["Engine"]=="view";}function
fk_support($Q){global$f;return!$f->result("SELECT sqlite_compileoption_used('OMIT_FOREIGN_KEY')");}function
fields($P){global$f;$H=array();$jg="";foreach(get_rows("PRAGMA table_info(".table($P).")")as$I){$B=$I["name"];$T=strtolower($I["type"]);$ac=$I["dflt_value"];$H[$B]=array("field"=>$B,"type"=>(preg_match('~int~i',$T)?"integer":(preg_match('~char|clob|text~i',$T)?"text":(preg_match('~blob~i',$T)?"blob":(preg_match('~real|floa|doub~i',$T)?"real":"numeric")))),"full_type"=>$T,"default"=>(preg_match("~^'(.*)'$~",$ac,$A)?str_replace("''","'",$A[1]):($ac=="NULL"?null:$ac)),"null"=>!$I["notnull"],"privileges"=>array("select"=>1,"insert"=>1,"update"=>1),"primary"=>$I["pk"],);if($I["pk"]){if($jg!="")$H[$jg]["auto_increment"]=false;elseif(preg_match('~^integer$~i',$T))$H[$B]["auto_increment"]=true;$jg=$B;}}$xh=$f->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($P));preg_match_all('~(("[^"]*+")+|[a-z0-9_]+)\s+text\s+COLLATE\s+(\'[^\']+\'|\S+)~i',$xh,$De,PREG_SET_ORDER);foreach($De
as$A){$B=str_replace('""','"',preg_replace('~^"|"$~','',$A[1]));if($H[$B])$H[$B]["collation"]=trim($A[3],"'");}return$H;}function
indexes($P,$g=null){global$f;if(!is_object($g))$g=$f;$H=array();$xh=$g->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($P));if(preg_match('~\bPRIMARY\s+KEY\s*\((([^)"]+|"[^"]*"|`[^`]*`)++)~i',$xh,$A)){$H[""]=array("type"=>"PRIMARY","columns"=>array(),"lengths"=>array(),"descs"=>array());preg_match_all('~((("[^"]*+")+|(?:`[^`]*+`)+)|(\S+))(\s+(ASC|DESC))?(,\s*|$)~i',$A[1],$De,PREG_SET_ORDER);foreach($De
as$A){$H[""]["columns"][]=idf_unescape($A[2]).$A[4];$H[""]["descs"][]=(preg_match('~DESC~i',$A[5])?'1':null);}}if(!$H){foreach(fields($P)as$B=>$m){if($m["primary"])$H[""]=array("type"=>"PRIMARY","columns"=>array($B),"lengths"=>array(),"descs"=>array(null));}}$Ah=get_key_vals("SELECT name, sql FROM sqlite_master WHERE type = 'index' AND tbl_name = ".q($P),$g);foreach(get_rows("PRAGMA index_list(".table($P).")",$g)as$I){$B=$I["name"];$u=array("type"=>($I["unique"]?"UNIQUE":"INDEX"));$u["lengths"]=array();$u["descs"]=array();foreach(get_rows("PRAGMA index_info(".idf_escape($B).")",$g)as$Tg){$u["columns"][]=$Tg["name"];$u["descs"][]=null;}if(preg_match('~^CREATE( UNIQUE)? INDEX '.preg_quote(idf_escape($B).' ON '.idf_escape($P),'~').' \((.*)\)$~i',$Ah[$B],$Dg)){preg_match_all('/("[^"]*+")+( DESC)?/',$Dg[2],$De);foreach($De[2]as$x=>$X){if($X)$u["descs"][$x]='1';}}if(!$H[""]||$u["type"]!="UNIQUE"||$u["columns"]!=$H[""]["columns"]||$u["descs"]!=$H[""]["descs"]||!preg_match("~^sqlite_~",$B))$H[$B]=$u;}return$H;}function
foreign_keys($P){$H=array();foreach(get_rows("PRAGMA foreign_key_list(".table($P).")")as$I){$p=&$H[$I["id"]];if(!$p)$p=$I;$p["source"][]=$I["from"];$p["target"][]=$I["to"];}return$H;}function
adm_view($B){global$f;return
array("select"=>preg_replace('~^(?:[^`"[]+|`[^`]*`|"[^"]*")* AS\s+~iU','',$f->result("SELECT sql FROM sqlite_master WHERE name = ".q($B))));}function
collations(){return(isset($_GET["create"])?get_vals("PRAGMA collation_list",1):array());}function
information_schema($j){return
false;}function
error(){global$f;return
h($f->error);}function
check_sqlite_name($B){global$f;$Uc="db|sdb|sqlite";if(!preg_match("~^[^\\0]*\\.($Uc)\$~",$B)){$f->error=sprintf('è«‹ä½¿ç”¨ä¸‹åˆ—å…¶ä¸­ä¸€å€‹æ“´å……æ¨¡çµ„ %sã€‚',str_replace("|",", ",$Uc));return
false;}return
true;}function
create_database($j,$ob){global$f;if(file_exists($j)){$f->error='æª”æ¡ˆå·²å­˜åœ¨ã€‚';return
false;}if(!check_sqlite_name($j))return
false;try{$z=new
Min_SQLite($j);}catch(Exception$Lc){$f->error=$Lc->getMessage();return
false;}$z->query('PRAGMA encoding = "UTF-8"');$z->query('CREATE TABLE adminer (i)');$z->query('DROP TABLE adminer');return
true;}function
drop_databases($i){global$f;$f->__construct(":memory:");foreach($i
as$j){if(!@unlink($j)){$f->error='æª”æ¡ˆå·²å­˜åœ¨ã€‚';return
false;}}return
true;}function
rename_database($B,$ob){global$f;if(!check_sqlite_name($B))return
false;$f->__construct(":memory:");$f->error='æª”æ¡ˆå·²å­˜åœ¨ã€‚';return@rename(DB,$B);}function
auto_increment(){return" PRIMARY KEY".(DRIVER=="sqlite"?" AUTOINCREMENT":"");}function
alter_table($P,$B,$n,$kd,$vb,$Cc,$ob,$Ka,$Uf){global$f;$Li=($P==""||$kd);foreach($n
as$m){if($m[0]!=""||!$m[1]||$m[2]){$Li=true;break;}}$c=array();$If=array();foreach($n
as$m){if($m[1]){$c[]=($Li?$m[1]:"ADD ".implode($m[1]));if($m[0]!="")$If[$m[0]]=$m[1][0];}}if(!$Li){foreach($c
as$X){if(!queries("ALTER TABLE ".table($P)." $X"))return
false;}if($P!=$B&&!queries("ALTER TABLE ".table($P)." RENAME TO ".table($B)))return
false;}elseif(!recreate_table($P,$B,$c,$If,$kd,$Ka))return
false;if($Ka){queries("BEGIN");queries("UPDATE sqlite_sequence SET seq = $Ka WHERE name = ".q($B));if(!$f->affected_rows)queries("INSERT INTO sqlite_sequence (name, seq) VALUES (".q($B).", $Ka)");queries("COMMIT");}return
true;}function
recreate_table($P,$B,$n,$If,$kd,$Ka=0,$v=array()){global$f;if($P!=""){if(!$n){foreach(fields($P)as$x=>$m){if($v)$m["auto_increment"]=0;$n[]=process_field($m,$m);$If[$x]=idf_escape($x);}}$kg=false;foreach($n
as$m){if($m[6])$kg=true;}$qc=array();foreach($v
as$x=>$X){if($X[2]=="DROP"){$qc[$X[1]]=true;unset($v[$x]);}}foreach(indexes($P)as$ie=>$u){$e=array();foreach($u["columns"]as$x=>$d){if(!$If[$d])continue
2;$e[]=$If[$d].($u["descs"][$x]?" DESC":"");}if(!$qc[$ie]){if($u["type"]!="PRIMARY"||!$kg)$v[]=array($u["type"],$ie,$e);}}foreach($v
as$x=>$X){if($X[0]=="PRIMARY"){unset($v[$x]);$kd[]="  PRIMARY KEY (".implode(", ",$X[2]).")";}}foreach(foreign_keys($P)as$ie=>$p){foreach($p["source"]as$x=>$d){if(!$If[$d])continue
2;$p["source"][$x]=idf_unescape($If[$d]);}if(!isset($kd[" $ie"]))$kd[]=" ".format_foreign_key($p);}queries("BEGIN");}foreach($n
as$x=>$m)$n[$x]="  ".implode($m);$n=array_merge($n,array_filter($kd));$Xh=($P==$B?"adminer_$B":$B);if(!queries("CREATE TABLE ".table($Xh)." (\n".implode(",\n",$n)."\n)"))return
false;if($P!=""){if($If&&!queries("INSERT INTO ".table($Xh)." (".implode(", ",$If).") SELECT ".implode(", ",array_map('idf_escape',array_keys($If)))." FROM ".table($P)))return
false;$xi=array();foreach(triggers($P)as$vi=>$ei){$ui=trigger($vi);$xi[]="CREATE TRIGGER ".idf_escape($vi)." ".implode(" ",$ei)." ON ".table($B)."\n$ui[Statement]";}$Ka=$Ka?0:$f->result("SELECT seq FROM sqlite_sequence WHERE name = ".q($P));if(!queries("DROP TABLE ".table($P))||($P==$B&&!queries("ALTER TABLE ".table($Xh)." RENAME TO ".table($B)))||!alter_indexes($B,$v))return
false;if($Ka)queries("UPDATE sqlite_sequence SET seq = $Ka WHERE name = ".q($B));foreach($xi
as$ui){if(!queries($ui))return
false;}queries("COMMIT");}return
true;}function
index_sql($P,$T,$B,$e){return"CREATE $T ".($T!="INDEX"?"INDEX ":"").idf_escape($B!=""?$B:uniqid($P."_"))." ON ".table($P)." $e";}function
alter_indexes($P,$c){foreach($c
as$jg){if($jg[0]=="PRIMARY")return
recreate_table($P,$P,array(),array(),array(),0,$c);}foreach(array_reverse($c)as$X){if(!queries($X[2]=="DROP"?"DROP INDEX ".idf_escape($X[1]):index_sql($P,$X[0],$X[1],"(".implode(", ",$X[2]).")")))return
false;}return
true;}function
truncate_tables($R){return
apply_queries("DELETE FROM",$R);}function
drop_views($Xi){return
apply_queries("DROP VIEW",$Xi);}function
drop_tables($R){return
apply_queries("DROP TABLE",$R);}function
move_tables($R,$Xi,$Vh){return
false;}function
trigger($B){global$f;if($B=="")return
array("Statement"=>"BEGIN\n\t;\nEND");$t='(?:[^`"\s]+|`[^`]*`|"[^"]*")+';$wi=trigger_options();preg_match("~^CREATE\\s+TRIGGER\\s*$t\\s*(".implode("|",$wi["Timing"]).")\\s+([a-z]+)(?:\\s+OF\\s+($t))?\\s+ON\\s*$t\\s*(?:FOR\\s+EACH\\s+ROW\\s)?(.*)~is",$f->result("SELECT sql FROM sqlite_master WHERE type = 'trigger' AND name = ".q($B)),$A);$if=$A[3];return
array("Timing"=>strtoupper($A[1]),"Event"=>strtoupper($A[2]).($if?" OF":""),"Of"=>idf_unescape($if),"Trigger"=>$B,"Statement"=>$A[4],);}function
triggers($P){$H=array();$wi=trigger_options();foreach(get_rows("SELECT * FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($P))as$I){preg_match('~^CREATE\s+TRIGGER\s*(?:[^`"\s]+|`[^`]*`|"[^"]*")+\s*('.implode("|",$wi["Timing"]).')\s*(.*?)\s+ON\b~i',$I["sql"],$A);$H[$I["name"]]=array($A[1],$A[2]);}return$H;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","UPDATE OF","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
begin(){return
queries("BEGIN");}function
last_id(){global$f;return$f->result("SELECT LAST_INSERT_ROWID()");}function
explain($f,$F){return$f->query("EXPLAIN QUERY PLAN $F");}function
found_rows($Q,$Z){}function
types(){return
array();}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($Xg){return
true;}function
create_sql($P,$Ka,$Gh){global$f;$H=$f->result("SELECT sql FROM sqlite_master WHERE type IN ('table', 'view') AND name = ".q($P));foreach(indexes($P)as$B=>$u){if($B=='')continue;$H.=";\n\n".index_sql($P,$u['type'],$B,"(".implode(", ",array_map('idf_escape',$u['columns'])).")");}return$H;}function
truncate_sql($P){return"DELETE FROM ".table($P);}function
use_sql($Ub){}function
trigger_sql($P){return
implode(get_vals("SELECT sql || ';;\n' FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($P)));}function
show_variables(){global$f;$H=array();foreach(get_rows("PRAGMA pragma_list")as$I)$H[$I["name"]]=$f->result("PRAGMA $I[name]");return$H;}function
show_status(){$H=array();foreach(get_vals("PRAGMA compile_options")as$yf){list($x,$X)=explode("=",$yf,2);$H[$x]=$X;}return$H;}function
convert_field($m){}function
unconvert_field($m,$H){return$H;}function
support($Yc){return
preg_match('~^(columns|database|drop_col|dump|indexes|descidx|move_col|sql|status|table|trigger|variables|view|view_trigger)$~',$Yc);}function
driver_config(){$U=array("integer"=>0,"real"=>0,"numeric"=>0,"text"=>0,"blob"=>0);return
array('possible_drivers'=>array((isset($_GET["sqlite"])?"SQLite3":"SQLite"),"PDO_SQLite"),'jush'=>"sqlite",'types'=>$U,'structured_types'=>array_keys($U),'unsigned'=>array(),'operators'=>array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL"),'functions'=>array("hex","length","lower","round","unixepoch","upper"),'grouping'=>array("avg","count","count distinct","group_concat","max","min","sum"),'edit_functions'=>array(array(),array("integer|real|numeric"=>"+/-","text"=>"||",)),);}}$nc["pgsql"]="PostgreSQL";if(isset($_GET["pgsql"])){define("DRIVER","pgsql");if(extension_loaded("pgsql")){class
Min_DB{var$extension="PgSQL",$_link,$_result,$_string,$_database=true,$server_info,$affected_rows,$error,$timeout;function
_error($Gc,$l){if(ini_bool("html_errors"))$l=html_entity_decode(strip_tags($l));$l=preg_replace('~^[^:]*: ~','',$l);$this->error=$l;}function
connect($L,$V,$E){global$b;$j=$b->database();set_error_handler(array($this,'_error'));$this->_string="host='".str_replace(":","' port='",addcslashes($L,"'\\"))."' user='".addcslashes($V,"'\\")."' password='".addcslashes($E,"'\\")."'";$Bh=$b->connectSsl();if(isset($Bh["mode"]))$this->_string.=" sslmode='".$Bh["mode"]."'";$this->_link=@pg_connect("$this->_string dbname='".($j!=""?addcslashes($j,"'\\"):"postgres")."'",PGSQL_CONNECT_FORCE_NEW);if(!$this->_link&&$j!=""){$this->_database=false;$this->_link=@pg_connect("$this->_string dbname='postgres'",PGSQL_CONNECT_FORCE_NEW);}restore_error_handler();if($this->_link){$Vi=pg_version($this->_link);$this->server_info=$Vi["server"];pg_set_client_encoding($this->_link,"UTF8");}return(bool)$this->_link;}function
quote($O){return
pg_escape_literal($this->_link,$O);}function
value($X,$m){return($m["type"]=="bytea"&&$X!==null?pg_unescape_bytea($X):$X);}function
quoteBinary($O){return"'".pg_escape_bytea($this->_link,$O)."'";}function
select_db($Ub){global$b;if($Ub==$b->database())return$this->_database;$H=@pg_connect("$this->_string dbname='".addcslashes($Ub,"'\\")."'",PGSQL_CONNECT_FORCE_NEW);if($H)$this->_link=$H;return$H;}function
close(){$this->_link=@pg_connect("$this->_string dbname='postgres'");}function
query($F,$_i=false){$G=@pg_query($this->_link,$F);$this->error="";if(!$G){$this->error=pg_last_error($this->_link);$H=false;}elseif(!pg_num_fields($G)){$this->affected_rows=pg_affected_rows($G);$H=true;}else$H=new
Min_Result($G);if($this->timeout){$this->timeout=0;$this->query("RESET statement_timeout");}return$H;}function
multi_query($F){return$this->_result=$this->query($F);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($F,$m=0){$G=$this->query($F);if(!$G||!$G->num_rows)return
false;return
pg_fetch_result($G->_result,0,$m);}function
warnings(){return
h(pg_last_notice($this->_link));}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($G){$this->_result=$G;$this->num_rows=pg_num_rows($G);}function
fetch_assoc(){return
pg_fetch_assoc($this->_result);}function
fetch_row(){return
pg_fetch_row($this->_result);}function
fetch_field(){$d=$this->_offset++;$H=new
stdClass;if(function_exists('pg_field_table'))$H->orgtable=pg_field_table($this->_result,$d);$H->name=pg_field_name($this->_result,$d);$H->orgname=$H->name;$H->type=pg_field_type($this->_result,$d);$H->charsetnr=($H->type=="bytea"?63:0);return$H;}function
__destruct(){pg_free_result($this->_result);}}}elseif(extension_loaded("pdo_pgsql")){class
Min_DB
extends
Min_PDO{var$extension="PDO_PgSQL",$timeout;function
connect($L,$V,$E){global$b;$j=$b->database();$sc="pgsql:host='".str_replace(":","' port='",addcslashes($L,"'\\"))."' client_encoding=utf8 dbname='".($j!=""?addcslashes($j,"'\\"):"postgres")."'";$Bh=$b->connectSsl();if(isset($Bh["mode"]))$sc.=" sslmode='".$Bh["mode"]."'";$this->dsn($sc,$V,$E);return
true;}function
select_db($Ub){global$b;return($b->database()==$Ub);}function
quoteBinary($Ug){return
q($Ug);}function
query($F,$_i=false){$H=parent::query($F,$_i);if($this->timeout){$this->timeout=0;parent::query("RESET statement_timeout");}return$H;}function
warnings(){return'';}function
close(){}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($P,$J,$jg){global$f;foreach($J
as$M){$Hi=array();$Z=array();foreach($M
as$x=>$X){$Hi[]="$x = $X";if(isset($jg[idf_unescape($x)]))$Z[]="$x = $X";}if(!(($Z&&queries("UPDATE ".table($P)." SET ".implode(", ",$Hi)." WHERE ".implode(" AND ",$Z))&&$f->affected_rows)||queries("INSERT INTO ".table($P)." (".implode(", ",array_keys($M)).") VALUES (".implode(", ",$M).")")))return
false;}return
true;}function
slowQuery($F,$di){$this->_conn->query("SET statement_timeout = ".(1000*$di));$this->_conn->timeout=1000*$di;return$F;}function
convertSearch($t,$X,$m){$ai="char|text";if(strpos($X["op"],"LIKE")===false)$ai.="|date|time(stamp)?|boolean|uuid|inet|cidr|macaddr|".number_type();return(preg_match("~$ai~",$m["type"])?$t:"CAST($t AS text)");}function
quoteBinary($Ug){return$this->_conn->quoteBinary($Ug);}function
warnings(){return$this->_conn->warnings();}function
tableHelp($B){$ye=array("information_schema"=>"infoschema","pg_catalog"=>"catalog",);$z=$ye[$_GET["ns"]];if($z)return"$z-".str_replace("_","-",$B).".html";}function
hasCStyleEscapes(){static$Xa;if($Xa===null)$Xa=($this->_conn->result("SHOW standard_conforming_strings")=="off");return$Xa;}}function
idf_escape($t){return'"'.str_replace('"','""',$t).'"';}function
table($t){return
idf_escape($t);}function
connect(){global$b,$U,$Fh;$f=new
Min_DB;$Nb=$b->credentials();if($f->connect($Nb[0],$Nb[1],$Nb[2])){if(min_version(9,0,$f)){$f->query("SET application_name = 'Adminer'");if(min_version(9.2,0,$f)){$Fh['å­—ä¸²'][]="json";$U["json"]=4294967295;if(min_version(9.4,0,$f)){$Fh['å­—ä¸²'][]="jsonb";$U["jsonb"]=4294967295;}}}return$f;}return$f->error;}function
get_databases(){return
get_vals("SELECT d.datname FROM pg_database d JOIN pg_roles r ON d.datdba = r.oid
WHERE d.datallowconn = TRUE AND has_database_privilege(d.datname, 'CONNECT') AND pg_has_role(r.rolname, 'USAGE')
ORDER BY d.datname");}function
limit($F,$Z,$y,$jf=0,$eh=" "){return" $F$Z".($y!==null?$eh."LIMIT $y".($jf?" OFFSET $jf":""):"");}function
limit1($P,$F,$Z,$eh="\n"){return(preg_match('~^INTO~',$F)?limit($F,$Z,1,0,$eh):" $F".(is_view(table_status1($P))?$Z:$eh."WHERE ctid = (SELECT ctid FROM ".table($P).$Z.$eh."LIMIT 1)"));}function
db_collation($j,$pb){global$f;return$f->result("SELECT datcollate FROM pg_database WHERE datname = ".q($j));}function
engines(){return
array();}function
logged_user(){global$f;return$f->result("SELECT user");}function
tables_list(){$F="SELECT table_name, table_type FROM information_schema.tables WHERE table_schema = current_schema()";if(support("materializedview"))$F.="
UNION ALL
SELECT matviewname, 'MATERIALIZED VIEW'
FROM pg_matviews
WHERE schemaname = current_schema()";$F.="
ORDER BY 1";return
get_key_vals($F);}function
count_tables($i){return
array();}function
table_status($B=""){$H=array();foreach(get_rows("SELECT
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
".($B!=""?"AND relname = ".q($B):"ORDER BY relname"))as$I)$H[$I["Name"]]=$I;return($B!=""?$H[$B]:$H);}function
is_view($Q){return
in_array($Q["Engine"],array("view","materialized view"));}function
fk_support($Q){return
true;}function
fields($P){$H=array();$Ba=array('timestamp without time zone'=>'timestamp','timestamp with time zone'=>'timestamptz',);foreach(get_rows("SELECT a.attname AS field, format_type(a.atttypid, a.atttypmod) AS full_type, pg_get_expr(d.adbin, d.adrelid) AS default, a.attnotnull::int, col_description(c.oid, a.attnum) AS comment".(min_version(10)?", a.attidentity":"")."
FROM pg_class c
JOIN pg_namespace n ON c.relnamespace = n.oid
JOIN pg_attribute a ON c.oid = a.attrelid
LEFT JOIN pg_attrdef d ON c.oid = d.adrelid AND a.attnum = d.adnum
WHERE c.relname = ".q($P)."
AND n.nspname = current_schema()
AND NOT a.attisdropped
AND a.attnum > 0
ORDER BY a.attnum")as$I){preg_match('~([^([]+)(\((.*)\))?([a-z ]+)?((\[[0-9]*])*)$~',$I["full_type"],$A);list(,$T,$ve,$I["length"],$wa,$Ea)=$A;$I["length"].=$Ea;$eb=$T.$wa;if(isset($Ba[$eb])){$I["type"]=$Ba[$eb];$I["full_type"]=$I["type"].$ve.$Ea;}else{$I["type"]=$T;$I["full_type"]=$I["type"].$ve.$wa.$Ea;}if(in_array($I['attidentity'],array('a','d')))$I['default']='GENERATED '.($I['attidentity']=='d'?'BY DEFAULT':'ALWAYS').' AS IDENTITY';$I["null"]=!$I["attnotnull"];$I["auto_increment"]=$I['attidentity']||preg_match('~^nextval\(~i',$I["default"]);$I["privileges"]=array("insert"=>1,"select"=>1,"update"=>1);if(preg_match('~(.+)::[^,)]+(.*)~',$I["default"],$A))$I["default"]=($A[1]=="NULL"?null:idf_unescape($A[1]).$A[2]);$H[$I["field"]]=$I;}return$H;}function
indexes($P,$g=null){global$f;if(!is_object($g))$g=$f;$H=array();$Oh=$g->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = ".q($P));$e=get_key_vals("SELECT attnum, attname FROM pg_attribute WHERE attrelid = $Oh AND attnum > 0",$g);foreach(get_rows("SELECT relname, indisunique::int, indisprimary::int, indkey, indoption, (indpred IS NOT NULL)::int as indispartial FROM pg_index i, pg_class ci WHERE i.indrelid = $Oh AND ci.oid = i.indexrelid",$g)as$I){$Eg=$I["relname"];$H[$Eg]["type"]=($I["indispartial"]?"INDEX":($I["indisprimary"]?"PRIMARY":($I["indisunique"]?"UNIQUE":"INDEX")));$H[$Eg]["columns"]=array();foreach(explode(" ",$I["indkey"])as$Rd)$H[$Eg]["columns"][]=$e[$Rd];$H[$Eg]["descs"]=array();foreach(explode(" ",$I["indoption"])as$Sd)$H[$Eg]["descs"][]=($Sd&1?'1':null);$H[$Eg]["lengths"]=array();}return$H;}function
foreign_keys($P){global$rf;$H=array();foreach(get_rows("SELECT conname, condeferrable::int AS deferrable, pg_get_constraintdef(oid) AS definition
FROM pg_constraint
WHERE conrelid = (SELECT pc.oid FROM pg_class AS pc INNER JOIN pg_namespace AS pn ON (pn.oid = pc.relnamespace) WHERE pc.relname = ".q($P)." AND pn.nspname = current_schema())
AND contype = 'f'::char
ORDER BY conkey, conname")as$I){if(preg_match('~FOREIGN KEY\s*\((.+)\)\s*REFERENCES (.+)\((.+)\)(.*)$~iA',$I['definition'],$A)){$I['source']=array_map('idf_unescape',array_map('trim',explode(',',$A[1])));if(preg_match('~^(("([^"]|"")+"|[^"]+)\.)?"?("([^"]|"")+"|[^"]+)$~',$A[2],$Ce)){$I['ns']=idf_unescape($Ce[2]);$I['table']=idf_unescape($Ce[4]);}$I['target']=array_map('idf_unescape',array_map('trim',explode(',',$A[3])));$I['on_delete']=(preg_match("~ON DELETE ($rf)~",$A[4],$Ce)?$Ce[1]:'NO ACTION');$I['on_update']=(preg_match("~ON UPDATE ($rf)~",$A[4],$Ce)?$Ce[1]:'NO ACTION');$H[$I['conname']]=$I;}}return$H;}function
adm_view($B){global$f;return
array("select"=>trim($f->result("SELECT pg_get_viewdef(".$f->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = ".q($B)).")")));}function
collations(){return
array();}function
information_schema($j){return($j=="information_schema");}function
error(){global$f;$H=h($f->error);if(preg_match('~^(.*\n)?([^\n]*)\n( *)\^(\n.*)?$~s',$H,$A))$H=$A[1].preg_replace('~((?:[^&]|&[^;]*;){'.strlen($A[3]).'})(.*)~','\1<b>\2</b>',$A[2]).$A[4];return
nl_br($H);}function
create_database($j,$ob){return
queries("CREATE DATABASE ".idf_escape($j).($ob?" ENCODING ".idf_escape($ob):""));}function
drop_databases($i){global$f;$f->close();return
apply_queries("DROP DATABASE",$i,'idf_escape');}function
rename_database($B,$ob){global$f;$f->close();return
queries("ALTER DATABASE ".idf_escape(DB)." RENAME TO ".idf_escape($B));}function
auto_increment(){return"";}function
alter_table($P,$B,$n,$kd,$vb,$Cc,$ob,$Ka,$Uf){$c=array();$tg=array();if($P!=""&&$P!=$B)$tg[]="ALTER TABLE ".table($P)." RENAME TO ".table($B);$fh="";foreach($n
as$m){$d=idf_escape($m[0]);$X=$m[1];if(!$X)$c[]="DROP $d";else{$Ri=$X[5];unset($X[5]);if($m[0]==""){if(isset($X[6]))$X[1]=($X[1]==" bigint"?" big":($X[1]==" smallint"?" small":" "))."serial";$c[]=($P!=""?"ADD ":"  ").implode($X);if(isset($X[6]))$c[]=($P!=""?"ADD":" ")." PRIMARY KEY ($X[0])";}else{if($d!=$X[0])$tg[]="ALTER TABLE ".table($B)." RENAME $d TO $X[0]";$c[]="ALTER $d TYPE$X[1]";$gh=$P."_".idf_unescape($X[0])."_seq";$c[]="ALTER $d ".($X[3]?"SET$X[3]":(isset($X[6])?"SET DEFAULT nextval(".q($gh).")":"DROP DEFAULT"));if(isset($X[6]))$fh="CREATE SEQUENCE IF NOT EXISTS ".idf_escape($gh)." OWNED BY ".idf_escape($P).".$X[0]";$c[]="ALTER $d ".($X[2]==" NULL"?"DROP NOT":"SET").$X[2];}if($m[0]!=""||$Ri!="")$tg[]="COMMENT ON COLUMN ".table($B).".$X[0] IS ".($Ri!=""?substr($Ri,9):"''");}}$c=array_merge($c,$kd);if($P=="")array_unshift($tg,"CREATE TABLE ".table($B)." (\n".implode(",\n",$c)."\n)");elseif($c)array_unshift($tg,"ALTER TABLE ".table($P)."\n".implode(",\n",$c));if($fh)array_unshift($tg,$fh);if($vb!==null)$tg[]="COMMENT ON TABLE ".table($B)." IS ".q($vb);if($Ka!=""){}foreach($tg
as$F){if(!queries($F))return
false;}return
true;}function
alter_indexes($P,$c){$h=array();$oc=array();$tg=array();foreach($c
as$X){if($X[0]!="INDEX")$h[]=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");elseif($X[2]=="DROP")$oc[]=idf_escape($X[1]);else$tg[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($P."_"))." ON ".table($P)." (".implode(", ",$X[2]).")";}if($h)array_unshift($tg,"ALTER TABLE ".table($P).implode(",",$h));if($oc)array_unshift($tg,"DROP INDEX ".implode(", ",$oc));foreach($tg
as$F){if(!queries($F))return
false;}return
true;}function
truncate_tables($R){return
queries("TRUNCATE ".implode(", ",array_map('table',$R)));return
true;}function
drop_views($Xi){return
drop_tables($Xi);}function
drop_tables($R){foreach($R
as$P){$N=table_status($P);if(!queries("DROP ".strtoupper($N["Engine"])." ".table($P)))return
false;}return
true;}function
move_tables($R,$Xi,$Vh){foreach(array_merge($R,$Xi)as$P){$N=table_status($P);if(!queries("ALTER ".strtoupper($N["Engine"])." ".table($P)." SET SCHEMA ".idf_escape($Vh)))return
false;}return
true;}function
trigger($B,$P){if($B=="")return
array("Statement"=>"EXECUTE PROCEDURE ()");$e=array();$Z="WHERE trigger_schema = current_schema() AND event_object_table = ".q($P)." AND trigger_name = ".q($B);foreach(get_rows("SELECT * FROM information_schema.triggered_update_columns $Z")as$I)$e[]=$I["event_object_column"];$H=array();foreach(get_rows('SELECT trigger_name AS "Trigger", action_timing AS "Timing", event_manipulation AS "Event", \'FOR EACH \' || action_orientation AS "Type", action_statement AS "Statement" FROM information_schema.triggers '."$Z ORDER BY event_manipulation DESC")as$I){if($e&&$I["Event"]=="UPDATE")$I["Event"].=" OF";$I["Of"]=implode(", ",$e);if($H)$I["Event"].=" OR $H[Event]";$H=$I;}return$H;}function
triggers($P){$H=array();foreach(get_rows("SELECT * FROM information_schema.triggers WHERE trigger_schema = current_schema() AND event_object_table = ".q($P))as$I){$ui=trigger($I["trigger_name"],$P);$H[$ui["Trigger"]]=array($ui["Timing"],$ui["Event"]);}return$H;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","UPDATE OF","DELETE","INSERT OR UPDATE","INSERT OR UPDATE OF","DELETE OR INSERT","DELETE OR UPDATE","DELETE OR UPDATE OF","DELETE OR INSERT OR UPDATE","DELETE OR INSERT OR UPDATE OF"),"Type"=>array("FOR EACH ROW","FOR EACH STATEMENT"),);}function
routine($B,$T){$J=get_rows('SELECT routine_definition AS definition, LOWER(external_language) AS language, *
FROM information_schema.routines
WHERE routine_schema = current_schema() AND specific_name = '.q($B));$H=$J[0];$H["returns"]=array("type"=>$H["type_udt_name"]);$H["fields"]=get_rows('SELECT parameter_name AS field, data_type AS type, character_maximum_length AS length, parameter_mode AS inout
FROM information_schema.parameters
WHERE specific_schema = current_schema() AND specific_name = '.q($B).'
ORDER BY ordinal_position');return$H;}function
routines(){return
get_rows('SELECT specific_name AS "SPECIFIC_NAME", routine_type AS "ROUTINE_TYPE", routine_name AS "ROUTINE_NAME", type_udt_name AS "DTD_IDENTIFIER"
FROM information_schema.routines
WHERE routine_schema = current_schema()
ORDER BY SPECIFIC_NAME');}function
routine_languages(){return
get_vals("SELECT LOWER(lanname) FROM pg_catalog.pg_language");}function
routine_id($B,$I){$H=array();foreach($I["fields"]as$m)$H[]=$m["type"];return
idf_escape($B)."(".implode(", ",$H).")";}function
last_id(){return
0;}function
explain($f,$F){return$f->query("EXPLAIN $F");}function
found_rows($Q,$Z){global$f;if(preg_match("~ rows=([0-9]+)~",$f->result("EXPLAIN SELECT * FROM ".idf_escape($Q["Name"]).($Z?" WHERE ".implode(" AND ",$Z):"")),$Dg))return$Dg[1];return
false;}function
types(){return
get_key_vals("SELECT oid, typname
FROM pg_type
WHERE typnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema())
AND typtype IN ('b','d','e')
AND typelem = 0");}function
schemas(){return
get_vals("SELECT nspname FROM pg_namespace ORDER BY nspname");}function
get_schema(){global$f;return$f->result("SELECT current_schema()");}function
set_schema($Wg,$g=null){global$f,$U,$Fh;if(!$g)$g=$f;$H=$g->query("SET search_path TO ".idf_escape($Wg));foreach(types()as$x=>$T){if(!isset($U[$T])){$U[$T]=$x;$Fh['ä½¿ç”¨è€…é¡å‹'][]=$T;}}return$H;}function
foreign_keys_sql($P){$H="";$N=table_status($P);$hd=foreign_keys($P);ksort($hd);foreach($hd
as$gd=>$fd)$H.="ALTER TABLE ONLY ".idf_escape($N['nspname']).".".idf_escape($N['Name'])." ADD CONSTRAINT ".idf_escape($gd)." $fd[definition] ".($fd['deferrable']?'DEFERRABLE':'NOT DEFERRABLE').";\n";return($H?"$H\n":$H);}function
create_sql($P,$Ka,$Gh){$Mg=array();$hh=array();$N=table_status($P);if(is_view($N)){$Wi=adm_view($P);return
rtrim("CREATE VIEW ".idf_escape($P)." AS $Wi[select]",";");}$n=fields($P);$v=indexes($P);ksort($v);if(!$N||empty($n))return
false;$H="CREATE TABLE ".idf_escape($N['nspname']).".".idf_escape($N['Name'])." (\n    ";foreach($n
as$m){$Rf=idf_escape($m['field']).' '.$m['full_type'].default_value($m).($m['attnotnull']?" NOT NULL":"");$Mg[]=$Rf;if(preg_match('~nextval\(\'([^\']+)\'\)~',$m['default'],$De)){$gh=$De[1];$wh=reset(get_rows(min_version(10)?"SELECT *, cache_size AS cache_value FROM pg_sequences WHERE schemaname = current_schema() AND sequencename = ".q(idf_unescape($gh)):"SELECT * FROM $gh"));$hh[]=($Gh=="DROP+CREATE"?"DROP SEQUENCE IF EXISTS $gh;\n":"")."CREATE SEQUENCE $gh INCREMENT $wh[increment_by] MINVALUE $wh[min_value] MAXVALUE $wh[max_value]".($Ka&&$wh['last_value']?" START ".($wh["last_value"]+1):"")." CACHE $wh[cache_value];";}}if(!empty($hh))$H=implode("\n\n",$hh)."\n\n$H";foreach($v
as$Pd=>$u){switch($u['type']){case'UNIQUE':$Mg[]="CONSTRAINT ".idf_escape($Pd)." UNIQUE (".implode(', ',array_map('idf_escape',$u['columns'])).")";break;case'PRIMARY':$Mg[]="CONSTRAINT ".idf_escape($Pd)." PRIMARY KEY (".implode(', ',array_map('idf_escape',$u['columns'])).")";break;}}$Db=get_key_vals("SELECT conname, ".(min_version(8)?"pg_get_constraintdef(pg_constraint.oid)":"CONCAT('CHECK ', consrc)")."
FROM pg_catalog.pg_constraint
INNER JOIN pg_catalog.pg_namespace ON pg_constraint.connamespace = pg_namespace.oid
INNER JOIN pg_catalog.pg_class ON pg_constraint.conrelid = pg_class.oid AND pg_constraint.connamespace = pg_class.relnamespace
WHERE pg_constraint.contype = 'c'
AND conrelid != 0 -- handle only CONSTRAINTs here, not TYPES
AND nspname = current_schema()
AND relname = ".q($P)."
ORDER BY connamespace, conname");foreach($Db
as$Ab=>$Cb)$Mg[]="CONSTRAINT ".idf_escape($Ab)." $Cb";$H.=implode(",\n    ",$Mg)."\n) WITH (oids = ".($N['Oid']?'true':'false').");";foreach($v
as$Pd=>$u){if($u['type']=='INDEX'){$e=array();foreach($u['columns']as$x=>$X)$e[]=idf_escape($X).($u['descs'][$x]?" DESC":"");$H.="\n\nCREATE INDEX ".idf_escape($Pd)." ON ".idf_escape($N['nspname']).".".idf_escape($N['Name'])." USING btree (".implode(', ',$e).");";}}if($N['Comment'])$H.="\n\nCOMMENT ON TABLE ".idf_escape($N['nspname']).".".idf_escape($N['Name'])." IS ".q($N['Comment']).";";foreach($n
as$ad=>$m){if($m['comment'])$H.="\n\nCOMMENT ON COLUMN ".idf_escape($N['nspname']).".".idf_escape($N['Name']).".".idf_escape($ad)." IS ".q($m['comment']).";";}return
rtrim($H,';');}function
truncate_sql($P){return"TRUNCATE ".table($P);}function
trigger_sql($P){$N=table_status($P);$H="";foreach(triggers($P)as$ti=>$si){$ui=trigger($ti,$N['Name']);$H.="\nCREATE TRIGGER ".idf_escape($ui['Trigger'])." $ui[Timing] $ui[Event] ON ".idf_escape($N["nspname"]).".".idf_escape($N['Name'])." $ui[Type] $ui[Statement];;\n";}return$H;}function
use_sql($Ub){return"\connect ".idf_escape($Ub);}function
show_variables(){return
get_key_vals("SHOW ALL");}function
process_list(){return
get_rows("SELECT * FROM pg_stat_activity ORDER BY ".(min_version(9.2)?"pid":"procpid"));}function
show_status(){}function
convert_field($m){}function
unconvert_field($m,$H){return$H;}function
support($Yc){return
preg_match('~^(check|database|table|columns|sql|indexes|descidx|comment|view|'.(min_version(9.3)?'materializedview|':'').'scheme|routine|processlist|sequence|trigger|type|variables|drop_col|kill|dump)$~',$Yc);}function
kill_process($X){return
queries("SELECT pg_terminate_backend(".number($X).")");}function
connection_id(){return"SELECT pg_backend_pid()";}function
max_connections(){global$f;return$f->result("SHOW max_connections");}function
driver_config(){$U=array();$Fh=array();foreach(array('æ•¸å­—'=>array("smallint"=>5,"integer"=>10,"bigint"=>19,"boolean"=>1,"numeric"=>0,"real"=>7,"double precision"=>16,"money"=>20),'æ—¥æœŸæ™‚é–“'=>array("date"=>13,"time"=>17,"timestamp"=>20,"timestamptz"=>21,"interval"=>0),'å­—ä¸²'=>array("character"=>0,"character varying"=>0,"text"=>0,"tsquery"=>0,"tsvector"=>0,"uuid"=>0,"xml"=>0),'äºŒé€²ä½'=>array("bit"=>0,"bit varying"=>0,"bytea"=>0),'ç¶²è·¯'=>array("cidr"=>43,"inet"=>43,"macaddr"=>17,"macaddr8"=>23,"txid_snapshot"=>0),'å¹¾ä½•'=>array("box"=>0,"circle"=>0,"line"=>0,"lseg"=>0,"path"=>0,"point"=>0,"polygon"=>0),)as$x=>$X){$U+=$X;$Fh[$x]=array_keys($X);}return
array('possible_drivers'=>array("PgSQL","PDO_PgSQL"),'jush'=>"pgsql",'types'=>$U,'structured_types'=>$Fh,'unsigned'=>array(),'operators'=>array("=","<",">","<=",">=","!=","~","!~","LIKE","LIKE %%","ILIKE","ILIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL"),'functions'=>array("char_length","lower","round","to_hex","to_timestamp","upper"),'grouping'=>array("avg","count","count distinct","max","min","sum"),'edit_functions'=>array(array("char"=>"md5","date|time"=>"now",),array(number_type()=>"+/-","date|time"=>"+ interval/- interval","char|text"=>"||",)),);}}$nc["oracle"]="Oracle (beta)";if(isset($_GET["oracle"])){define("DRIVER","oracle");if(extension_loaded("oci8")){class
Min_DB{var$extension="oci8",$_link,$_result,$server_info,$affected_rows,$errno,$error;var$_current_db;function
_error($Gc,$l){if(ini_bool("html_errors"))$l=html_entity_decode(strip_tags($l));$l=preg_replace('~^[^:]*: ~','',$l);$this->error=$l;}function
connect($L,$V,$E){$this->_link=@oci_new_connect($V,$E,$L,"AL32UTF8");if($this->_link){$this->server_info=oci_server_version($this->_link);return
true;}$l=oci_error();$this->error=$l["message"];return
false;}function
quote($O){return"'".str_replace("'","''",$O)."'";}function
select_db($Ub){$this->_current_db=$Ub;return
true;}function
query($F,$_i=false){$G=oci_parse($this->_link,$F);$this->error="";if(!$G){$l=oci_error($this->_link);$this->errno=$l["code"];$this->error=$l["message"];return
false;}set_error_handler(array($this,'_error'));$H=@oci_execute($G);restore_error_handler();if($H){if(oci_num_fields($G))return
new
Min_Result($G);$this->affected_rows=oci_num_rows($G);oci_free_statement($G);}return$H;}function
multi_query($F){return$this->_result=$this->query($F);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($F,$m=1){$G=$this->query($F);if(!is_object($G)||!oci_fetch($G->_result))return
false;return
oci_result($G->_result,$m);}}class
Min_Result{var$_result,$_offset=1,$num_rows;function
__construct($G){$this->_result=$G;}function
_convert($I){foreach((array)$I
as$x=>$X){if(is_a($X,'OCI-Lob'))$I[$x]=$X->load();}return$I;}function
fetch_assoc(){return$this->_convert(oci_fetch_assoc($this->_result));}function
fetch_row(){return$this->_convert(oci_fetch_row($this->_result));}function
fetch_field(){$d=$this->_offset++;$H=new
stdClass;$H->name=oci_field_name($this->_result,$d);$H->orgname=$H->name;$H->type=oci_field_type($this->_result,$d);$H->charsetnr=(preg_match("~raw|blob|bfile~",$H->type)?63:0);return$H;}function
__destruct(){oci_free_statement($this->_result);}}}elseif(extension_loaded("pdo_oci")){class
Min_DB
extends
Min_PDO{var$extension="PDO_OCI";var$_current_db;function
connect($L,$V,$E){$this->dsn("oci:dbname=//$L;charset=AL32UTF8",$V,$E);return
true;}function
select_db($Ub){$this->_current_db=$Ub;return
true;}}}class
Min_Driver
extends
Min_SQL{function
begin(){return
true;}function
insertUpdate($P,$J,$jg){global$f;foreach($J
as$M){$Hi=array();$Z=array();foreach($M
as$x=>$X){$Hi[]="$x = $X";if(isset($jg[idf_unescape($x)]))$Z[]="$x = $X";}if(!(($Z&&queries("UPDATE ".table($P)." SET ".implode(", ",$Hi)." WHERE ".implode(" AND ",$Z))&&$f->affected_rows)||queries("INSERT INTO ".table($P)." (".implode(", ",array_keys($M)).") VALUES (".implode(", ",$M).")")))return
false;}return
true;}function
hasCStyleEscapes(){return
true;}}function
idf_escape($t){return'"'.str_replace('"','""',$t).'"';}function
table($t){return
idf_escape($t);}function
connect(){global$b;$f=new
Min_DB;$Nb=$b->credentials();if($f->connect($Nb[0],$Nb[1],$Nb[2]))return$f;return$f->error;}function
get_databases(){return
get_vals("SELECT DISTINCT tablespace_name FROM (
SELECT tablespace_name FROM user_tablespaces
UNION SELECT tablespace_name FROM all_tables WHERE tablespace_name IS NOT NULL
)
ORDER BY 1");}function
limit($F,$Z,$y,$jf=0,$eh=" "){return($jf?" * FROM (SELECT t.*, rownum AS rnum FROM (SELECT $F$Z) t WHERE rownum <= ".($y+$jf).") WHERE rnum > $jf":($y!==null?" * FROM (SELECT $F$Z) WHERE rownum <= ".($y+$jf):" $F$Z"));}function
limit1($P,$F,$Z,$eh="\n"){return" $F$Z";}function
db_collation($j,$pb){global$f;return$f->result("SELECT value FROM nls_database_parameters WHERE parameter = 'NLS_CHARACTERSET'");}function
engines(){return
array();}function
logged_user(){global$f;return$f->result("SELECT USER FROM DUAL");}function
get_current_db(){global$f;$j=$f->_current_db?$f->_current_db:DB;unset($f->_current_db);return$j;}function
where_owner($hg,$Lf="owner"){if(!$_GET["ns"])return'';return"$hg$Lf = sys_context('USERENV', 'CURRENT_SCHEMA')";}function
views_table($e){$Lf=where_owner('');return"(SELECT $e FROM all_views WHERE ".($Lf?$Lf:"rownum < 0").")";}function
tables_list(){$Wi=views_table("view_name");$Lf=where_owner(" AND ");return
get_key_vals("SELECT table_name, 'table' FROM all_tables WHERE tablespace_name = ".q(DB)."$Lf
UNION SELECT view_name, 'view' FROM $Wi
ORDER BY 1");}function
count_tables($i){global$f;$H=array();foreach($i
as$j)$H[$j]=$f->result("SELECT COUNT(*) FROM all_tables WHERE tablespace_name = ".q($j));return$H;}function
table_status($B=""){$H=array();$Yg=q($B);$j=get_current_db();$Wi=views_table("view_name");$Lf=where_owner(" AND ");foreach(get_rows('SELECT table_name "Name", \'table\' "Engine", avg_row_len * num_rows "Data_length", num_rows "Rows" FROM all_tables WHERE tablespace_name = '.q($j).$Lf.($B!=""?" AND table_name = $Yg":"")."
UNION SELECT view_name, 'view', 0, 0 FROM $Wi".($B!=""?" WHERE view_name = $Yg":"")."
ORDER BY 1")as$I){if($B!="")return$I;$H[$I["Name"]]=$I;}return$H;}function
is_view($Q){return$Q["Engine"]=="view";}function
fk_support($Q){return
true;}function
fields($P){$H=array();$Lf=where_owner(" AND ");foreach(get_rows("SELECT * FROM all_tab_columns WHERE table_name = ".q($P)."$Lf ORDER BY column_id")as$I){$T=$I["DATA_TYPE"];$ve="$I[DATA_PRECISION],$I[DATA_SCALE]";if($ve==",")$ve=$I["CHAR_COL_DECL_LENGTH"];$H[$I["COLUMN_NAME"]]=array("field"=>$I["COLUMN_NAME"],"full_type"=>$T.($ve?"($ve)":""),"type"=>strtolower($T),"length"=>$ve,"default"=>$I["DATA_DEFAULT"],"null"=>($I["NULLABLE"]=="Y"),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),);}return$H;}function
indexes($P,$g=null){$H=array();$Lf=where_owner(" AND ","aic.table_owner");foreach(get_rows("SELECT aic.*, ac.constraint_type, atc.data_default
FROM all_ind_columns aic
LEFT JOIN all_constraints ac ON aic.index_name = ac.constraint_name AND aic.table_name = ac.table_name AND aic.index_owner = ac.owner
LEFT JOIN all_tab_cols atc ON aic.column_name = atc.column_name AND aic.table_name = atc.table_name AND aic.index_owner = atc.owner
WHERE aic.table_name = ".q($P)."$Lf
ORDER BY ac.constraint_type, aic.column_position",$g)as$I){$Pd=$I["INDEX_NAME"];$sb=$I["DATA_DEFAULT"];$sb=($sb?trim($sb,'"'):$I["COLUMN_NAME"]);$H[$Pd]["type"]=($I["CONSTRAINT_TYPE"]=="P"?"PRIMARY":($I["CONSTRAINT_TYPE"]=="U"?"UNIQUE":"INDEX"));$H[$Pd]["columns"][]=$sb;$H[$Pd]["lengths"][]=($I["CHAR_LENGTH"]&&$I["CHAR_LENGTH"]!=$I["COLUMN_LENGTH"]?$I["CHAR_LENGTH"]:null);$H[$Pd]["descs"][]=($I["DESCEND"]&&$I["DESCEND"]=="DESC"?'1':null);}return$H;}function
adm_view($B){$Wi=views_table("view_name, text");$J=get_rows('SELECT text "select" FROM '.$Wi.' WHERE view_name = '.q($B));return
reset($J);}function
collations(){return
array();}function
information_schema($j){return
false;}function
error(){global$f;return
h($f->error);}function
explain($f,$F){$f->query("EXPLAIN PLAN FOR $F");return$f->query("SELECT * FROM plan_table");}function
found_rows($Q,$Z){}function
auto_increment(){return"";}function
alter_table($P,$B,$n,$kd,$vb,$Cc,$ob,$Ka,$Uf){$c=$oc=array();$Ff=($P?fields($P):array());foreach($n
as$m){$X=$m[1];if($X&&$m[0]!=""&&idf_escape($m[0])!=$X[0])queries("ALTER TABLE ".table($P)." RENAME COLUMN ".idf_escape($m[0])." TO $X[0]");$Ef=$Ff[$m[0]];if($X&&$Ef){$lf=process_field($Ef,$Ef);if($X[2]==$lf[2])$X[2]="";}if($X)$c[]=($P!=""?($m[0]!=""?"MODIFY (":"ADD ("):"  ").implode($X).($P!=""?")":"");else$oc[]=idf_escape($m[0]);}if($P=="")return
queries("CREATE TABLE ".table($B)." (\n".implode(",\n",$c)."\n)");return(!$c||queries("ALTER TABLE ".table($P)."\n".implode("\n",$c)))&&(!$oc||queries("ALTER TABLE ".table($P)." DROP (".implode(", ",$oc).")"))&&($P==$B||queries("ALTER TABLE ".table($P)." RENAME TO ".table($B)));}function
alter_indexes($P,$c){$oc=array();$tg=array();foreach($c
as$X){if($X[0]!="INDEX"){$X[2]=preg_replace('~ DESC$~','',$X[2]);$h=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");array_unshift($tg,"ALTER TABLE ".table($P).$h);}elseif($X[2]=="DROP")$oc[]=idf_escape($X[1]);else$tg[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($P."_"))." ON ".table($P)." (".implode(", ",$X[2]).")";}if($oc)array_unshift($tg,"DROP INDEX ".implode(", ",$oc));foreach($tg
as$F){if(!queries($F))return
false;}return
true;}function
foreign_keys($P){$H=array();$F="SELECT c_list.CONSTRAINT_NAME as NAME,
c_src.COLUMN_NAME as SRC_COLUMN,
c_dest.OWNER as DEST_DB,
c_dest.TABLE_NAME as DEST_TABLE,
c_dest.COLUMN_NAME as DEST_COLUMN,
c_list.DELETE_RULE as ON_DELETE
FROM ALL_CONSTRAINTS c_list, ALL_CONS_COLUMNS c_src, ALL_CONS_COLUMNS c_dest
WHERE c_list.CONSTRAINT_NAME = c_src.CONSTRAINT_NAME
AND c_list.R_CONSTRAINT_NAME = c_dest.CONSTRAINT_NAME
AND c_list.CONSTRAINT_TYPE = 'R'
AND c_src.TABLE_NAME = ".q($P);foreach(get_rows($F)as$I)$H[$I['NAME']]=array("db"=>$I['DEST_DB'],"table"=>$I['DEST_TABLE'],"source"=>array($I['SRC_COLUMN']),"target"=>array($I['DEST_COLUMN']),"on_delete"=>$I['ON_DELETE'],"on_update"=>null,);return$H;}function
truncate_tables($R){return
apply_queries("TRUNCATE TABLE",$R);}function
drop_views($Xi){return
apply_queries("DROP VIEW",$Xi);}function
drop_tables($R){return
apply_queries("DROP TABLE",$R);}function
last_id(){return
0;}function
schemas(){$H=get_vals("SELECT DISTINCT owner FROM dba_segments WHERE owner IN (SELECT username FROM dba_users WHERE default_tablespace NOT IN ('SYSTEM','SYSAUX')) ORDER BY 1");return($H?$H:get_vals("SELECT DISTINCT owner FROM all_tables WHERE tablespace_name = ".q(DB)." ORDER BY 1"));}function
get_schema(){global$f;return$f->result("SELECT sys_context('USERENV', 'SESSION_USER') FROM dual");}function
set_schema($Xg,$g=null){global$f;if(!$g)$g=$f;return$g->query("ALTER SESSION SET CURRENT_SCHEMA = ".idf_escape($Xg));}function
show_variables(){return
get_key_vals('SELECT name, display_value FROM v$parameter');}function
process_list(){return
get_rows('SELECT sess.process AS "process", sess.username AS "user", sess.schemaname AS "schema", sess.status AS "status", sess.wait_class AS "wait_class", sess.seconds_in_wait AS "seconds_in_wait", sql.sql_text AS "sql_text", sess.machine AS "machine", sess.port AS "port"
FROM v$session sess LEFT OUTER JOIN v$sql sql
ON sql.sql_id = sess.sql_id
WHERE sess.type = \'USER\'
ORDER BY PROCESS
');}function
show_status(){$J=get_rows('SELECT * FROM v$instance');return
reset($J);}function
convert_field($m){}function
unconvert_field($m,$H){return$H;}function
support($Yc){return
preg_match('~^(columns|database|drop_col|indexes|descidx|processlist|scheme|sql|status|table|variables|view)$~',$Yc);}function
driver_config(){$U=array();$Fh=array();foreach(array('æ•¸å­—'=>array("number"=>38,"binary_float"=>12,"binary_double"=>21),'æ—¥æœŸæ™‚é–“'=>array("date"=>10,"timestamp"=>29,"interval year"=>12,"interval day"=>28),'å­—ä¸²'=>array("char"=>2000,"varchar2"=>4000,"nchar"=>2000,"nvarchar2"=>4000,"clob"=>4294967295,"nclob"=>4294967295),'äºŒé€²ä½'=>array("raw"=>2000,"long raw"=>2147483648,"blob"=>4294967295,"bfile"=>4294967296),)as$x=>$X){$U+=$X;$Fh[$x]=array_keys($X);}return
array('possible_drivers'=>array("OCI8","PDO_OCI"),'jush'=>"oracle",'types'=>$U,'structured_types'=>$Fh,'unsigned'=>array(),'operators'=>array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL"),'functions'=>array("length","lower","round","upper"),'grouping'=>array("avg","count","count distinct","max","min","sum"),'edit_functions'=>array(array("date"=>"current_date","timestamp"=>"current_timestamp",),array("number|float|double"=>"+/-","date|timestamp"=>"+ interval/- interval","char|clob"=>"||",)),);}}$nc["mssql"]="MS SQL";if(isset($_GET["mssql"])){define("DRIVER","mssql");if(extension_loaded("sqlsrv")){class
Min_DB{var$extension="sqlsrv",$_link,$_result,$server_info,$affected_rows,$errno,$error;function
_get_error(){$this->error="";foreach(sqlsrv_errors()as$l){$this->errno=$l["code"];$this->error.="$l[message]\n";}$this->error=rtrim($this->error);}function
connect($L,$V,$E){global$b;$Bb=array("UID"=>$V,"PWD"=>$E,"CharacterSet"=>"UTF-8");$Bh=$b->connectSsl();if(isset($Bh["Encrypt"]))$Bb["Encrypt"]=$Bh["Encrypt"];if(isset($Bh["TrustServerCertificate"]))$Bb["TrustServerCertificate"]=$Bh["TrustServerCertificate"];$j=$b->database();if($j!="")$Bb["Database"]=$j;$this->_link=@sqlsrv_connect(preg_replace('~:~',',',$L),$Bb);if($this->_link){$Td=sqlsrv_server_info($this->_link);$this->server_info=$Td['SQLServerVersion'];}else$this->_get_error();return(bool)$this->_link;}function
quote($O){$Ai=strlen($O)!=strlen(utf8_decode($O));return($Ai?"N":"")."'".str_replace("'","''",$O)."'";}function
select_db($Ub){return$this->query("USE ".idf_escape($Ub));}function
query($F,$_i=false){$G=sqlsrv_query($this->_link,$F);$this->error="";if(!$G){$this->_get_error();return
false;}return$this->store_result($G);}function
multi_query($F){$this->_result=sqlsrv_query($this->_link,$F);$this->error="";if(!$this->_result){$this->_get_error();return
false;}return
true;}function
store_result($G=null){if(!$G)$G=$this->_result;if(!$G)return
false;if(sqlsrv_field_metadata($G))return
new
Min_Result($G);$this->affected_rows=sqlsrv_rows_affected($G);return
true;}function
next_result(){return$this->_result?sqlsrv_next_result($this->_result):null;}function
result($F,$m=0){$G=$this->query($F);if(!is_object($G))return
false;$I=$G->fetch_row();return$I[$m];}}class
Min_Result{var$_result,$_offset=0,$_fields,$num_rows;function
__construct($G){$this->_result=$G;}function
_convert($I){foreach((array)$I
as$x=>$X){if(is_a($X,'DateTime'))$I[$x]=$X->format("Y-m-d H:i:s");}return$I;}function
fetch_assoc(){return$this->_convert(sqlsrv_fetch_array($this->_result,SQLSRV_FETCH_ASSOC));}function
fetch_row(){return$this->_convert(sqlsrv_fetch_array($this->_result,SQLSRV_FETCH_NUMERIC));}function
fetch_field(){if(!$this->_fields)$this->_fields=sqlsrv_field_metadata($this->_result);$m=$this->_fields[$this->_offset++];$H=new
stdClass;$H->name=$m["Name"];$H->orgname=$m["Name"];$H->type=($m["Type"]==1?254:0);return$H;}function
seek($jf){for($s=0;$s<$jf;$s++)sqlsrv_fetch($this->_result);}function
__destruct(){sqlsrv_free_stmt($this->_result);}}}elseif(extension_loaded("mssql")){class
Min_DB{var$extension="MSSQL",$_link,$_result,$server_info,$affected_rows,$error;function
connect($L,$V,$E){$this->_link=@mssql_connect($L,$V,$E);if($this->_link){$G=$this->query("SELECT SERVERPROPERTY('ProductLevel'), SERVERPROPERTY('Edition')");if($G){$I=$G->fetch_row();$this->server_info=$this->result("sp_server_info 2",2)." [$I[0]] $I[1]";}}else$this->error=mssql_get_last_message();return(bool)$this->_link;}function
quote($O){$Ai=strlen($O)!=strlen(utf8_decode($O));return($Ai?"N":"")."'".str_replace("'","''",$O)."'";}function
select_db($Ub){return
mssql_select_db($Ub);}function
query($F,$_i=false){$G=@mssql_query($F,$this->_link);$this->error="";if(!$G){$this->error=mssql_get_last_message();return
false;}if($G===true){$this->affected_rows=mssql_rows_affected($this->_link);return
true;}return
new
Min_Result($G);}function
multi_query($F){return$this->_result=$this->query($F);}function
store_result(){return$this->_result;}function
next_result(){return
mssql_next_result($this->_result->_result);}function
result($F,$m=0){$G=$this->query($F);if(!is_object($G))return
false;return
mssql_result($G->_result,0,$m);}}class
Min_Result{var$_result,$_offset=0,$_fields,$num_rows;function
__construct($G){$this->_result=$G;$this->num_rows=mssql_num_rows($G);}function
fetch_assoc(){return
mssql_fetch_assoc($this->_result);}function
fetch_row(){return
mssql_fetch_row($this->_result);}function
num_rows(){return
mssql_num_rows($this->_result);}function
fetch_field(){$H=mssql_fetch_field($this->_result);$H->orgtable=$H->table;$H->orgname=$H->name;return$H;}function
seek($jf){mssql_data_seek($this->_result,$jf);}function
__destruct(){mssql_free_result($this->_result);}}}elseif(extension_loaded("pdo_dblib")){class
Min_DB
extends
Min_PDO{var$extension="PDO_DBLIB";function
connect($L,$V,$E){$this->dsn("dblib:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\d)~',';port=\1',$L)),$V,$E);return
true;}function
select_db($Ub){return$this->query("USE ".idf_escape($Ub));}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($P,$J,$jg){foreach($J
as$M){$Hi=array();$Z=array();foreach($M
as$x=>$X){$Hi[]="$x = $X";if(isset($jg[idf_unescape($x)]))$Z[]="$x = $X";}if(!queries("MERGE ".table($P)." USING (VALUES(".implode(", ",$M).")) AS source (c".implode(", c",range(1,count($M))).") ON ".implode(" AND ",$Z)." WHEN MATCHED THEN UPDATE SET ".implode(", ",$Hi)." WHEN NOT MATCHED THEN INSERT (".implode(", ",array_keys($M)).") VALUES (".implode(", ",$M).");"))return
false;}return
true;}function
begin(){return
queries("BEGIN TRANSACTION");}}function
idf_escape($t){return"[".str_replace("]","]]",$t)."]";}function
table($t){return($_GET["ns"]!=""?idf_escape($_GET["ns"]).".":"").idf_escape($t);}function
connect(){global$b;$f=new
Min_DB;$Nb=$b->credentials();if($Nb[0]=="")$Nb[0]="localhost:1433";if($f->connect($Nb[0],$Nb[1],$Nb[2]))return$f;return$f->error;}function
get_databases(){return
get_vals("SELECT name FROM sys.databases WHERE name NOT IN ('master', 'tempdb', 'model', 'msdb')");}function
limit($F,$Z,$y,$jf=0,$eh=" "){return($y!==null?" TOP (".($y+$jf).")":"")." $F$Z";}function
limit1($P,$F,$Z,$eh="\n"){return
limit($F,$Z,1,0,$eh);}function
db_collation($j,$pb){global$f;return$f->result("SELECT collation_name FROM sys.databases WHERE name = ".q($j));}function
engines(){return
array();}function
logged_user(){global$f;return$f->result("SELECT SUSER_NAME()");}function
tables_list(){return
get_key_vals("SELECT name, type_desc FROM sys.all_objects WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ORDER BY name");}function
count_tables($i){global$f;$H=array();foreach($i
as$j){$f->select_db($j);$H[$j]=$f->result("SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES");}return$H;}function
table_status($B=""){$H=array();foreach(get_rows("SELECT ao.name AS Name, ao.type_desc AS Engine, (SELECT value FROM fn_listextendedproperty(default, 'SCHEMA', schema_name(schema_id), 'TABLE', ao.name, null, null)) AS Comment
FROM sys.all_objects AS ao
WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ".($B!=""?"AND name = ".q($B):"ORDER BY name"))as$I){if($B!="")return$I;$H[$I["Name"]]=$I;}return$H;}function
is_view($Q){return$Q["Engine"]=="VIEW";}function
fk_support($Q){return
true;}function
fields($P){$xb=get_key_vals("SELECT objname, cast(value as varchar(max)) FROM fn_listextendedproperty('MS_DESCRIPTION', 'schema', ".q(get_schema()).", 'table', ".q($P).", 'column', NULL)");$H=array();foreach(get_rows("SELECT c.max_length, c.precision, c.scale, c.name, c.is_nullable, c.is_identity, c.collation_name, t.name type, CAST(d.definition as text) [default], d.name default_constraint
FROM sys.all_columns c
JOIN sys.all_objects o ON c.object_id = o.object_id
JOIN sys.types t ON c.user_type_id = t.user_type_id
LEFT JOIN sys.default_constraints d ON c.default_object_id = d.object_id
WHERE o.schema_id = SCHEMA_ID(".q(get_schema()).") AND o.type IN ('S', 'U', 'V') AND o.name = ".q($P))as$I){$T=$I["type"];$ve=(preg_match("~char|binary~",$T)?$I["max_length"]/($T[0]=='n'?2:1):($T=="decimal"?"$I[precision],$I[scale]":""));$H[$I["name"]]=array("field"=>$I["name"],"full_type"=>$T.($ve?"($ve)":""),"type"=>$T,"length"=>$ve,"default"=>(preg_match("~^\('(.*)'\)$~",$I["default"],$A)?str_replace("''","'",$A[1]):$I["default"]),"default_constraint"=>$I["default_constraint"],"null"=>$I["is_nullable"],"auto_increment"=>$I["is_identity"],"collation"=>$I["collation_name"],"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),"primary"=>$I["is_identity"],"comment"=>$xb[$I["name"]],);}return$H;}function
indexes($P,$g=null){$H=array();foreach(get_rows("SELECT i.name, key_ordinal, is_unique, is_primary_key, c.name AS column_name, is_descending_key
FROM sys.indexes i
INNER JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
INNER JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
WHERE OBJECT_NAME(i.object_id) = ".q($P),$g)as$I){$B=$I["name"];$H[$B]["type"]=($I["is_primary_key"]?"PRIMARY":($I["is_unique"]?"UNIQUE":"INDEX"));$H[$B]["lengths"]=array();$H[$B]["columns"][$I["key_ordinal"]]=$I["column_name"];$H[$B]["descs"][$I["key_ordinal"]]=($I["is_descending_key"]?'1':null);}return$H;}function
adm_view($B){global$f;return
array("select"=>preg_replace('~^(?:[^[]|\[[^]]*])*\s+AS\s+~isU','',$f->result("SELECT VIEW_DEFINITION FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = SCHEMA_NAME() AND TABLE_NAME = ".q($B))));}function
collations(){$H=array();foreach(get_vals("SELECT name FROM fn_helpcollations()")as$ob)$H[preg_replace('~_.*~','',$ob)][]=$ob;return$H;}function
information_schema($j){return
false;}function
error(){global$f;return
nl_br(h(preg_replace('~^(\[[^]]*])+~m','',$f->error)));}function
create_database($j,$ob){return
queries("CREATE DATABASE ".idf_escape($j).(preg_match('~^[a-z0-9_]+$~i',$ob)?" COLLATE $ob":""));}function
drop_databases($i){return
queries("DROP DATABASE ".implode(", ",array_map('idf_escape',$i)));}function
rename_database($B,$ob){if(preg_match('~^[a-z0-9_]+$~i',$ob))queries("ALTER DATABASE ".idf_escape(DB)." COLLATE $ob");queries("ALTER DATABASE ".idf_escape(DB)." MODIFY NAME = ".idf_escape($B));return
true;}function
auto_increment(){return" IDENTITY".($_POST["Auto_increment"]!=""?"(".number($_POST["Auto_increment"]).",1)":"")." PRIMARY KEY";}function
alter_table($P,$B,$n,$kd,$vb,$Cc,$ob,$Ka,$Uf){$c=array();$xb=array();$Ff=fields($P);foreach($n
as$m){$d=idf_escape($m[0]);$X=$m[1];if(!$X)$c["DROP"][]=" COLUMN $d";else{$X[1]=preg_replace("~( COLLATE )'(\\w+)'~",'\1\2',$X[1]);$xb[$m[0]]=$X[5];unset($X[5]);if($m[0]=="")$c["ADD"][]="\n  ".implode("",$X).($P==""?substr($kd[$X[0]],16+strlen($X[0])):"");else{$ac=$X[3];unset($X[3]);unset($X[6]);if($d!=$X[0])queries("EXEC sp_rename ".q(table($P).".$d").", ".q(idf_unescape($X[0])).", 'COLUMN'");$c["ALTER COLUMN ".implode("",$X)][]="";$Ef=$Ff[$m[0]];if(default_value($Ef)!=$ac){if($Ef["default"]!==null)$c["DROP"][]=" ".idf_escape($Ef["default_constraint"]);if($ac)$c["ADD"][]="\n $ac FOR $d";}}}}if($P=="")return
queries("CREATE TABLE ".table($B)." (".implode(",",(array)$c["ADD"])."\n)");if($P!=$B)queries("EXEC sp_rename ".q(table($P)).", ".q($B));if($kd)$c[""]=$kd;foreach($c
as$x=>$X){if(!queries("ALTER TABLE ".table($B)." $x".implode(",",$X)))return
false;}foreach($xb
as$x=>$X){$vb=substr($X,9);queries("EXEC sp_dropextendedproperty @name = N'MS_Description', @level0type = N'Schema', @level0name = ".q(get_schema()).", @level1type = N'Table', @level1name = ".q($B).", @level2type = N'Column', @level2name = ".q($x));queries("EXEC sp_addextendedproperty @name = N'MS_Description', @value = ".$vb.", @level0type = N'Schema', @level0name = ".q(get_schema()).", @level1type = N'Table', @level1name = ".q($B).", @level2type = N'Column', @level2name = ".q($x));}return
true;}function
alter_indexes($P,$c){$u=array();$oc=array();foreach($c
as$X){if($X[2]=="DROP"){if($X[0]=="PRIMARY")$oc[]=idf_escape($X[1]);else$u[]=idf_escape($X[1])." ON ".table($P);}elseif(!queries(($X[0]!="PRIMARY"?"CREATE $X[0] ".($X[0]!="INDEX"?"INDEX ":"").idf_escape($X[1]!=""?$X[1]:uniqid($P."_"))." ON ".table($P):"ALTER TABLE ".table($P)." ADD PRIMARY KEY")." (".implode(", ",$X[2]).")"))return
false;}return(!$u||queries("DROP INDEX ".implode(", ",$u)))&&(!$oc||queries("ALTER TABLE ".table($P)." DROP ".implode(", ",$oc)));}function
last_id(){global$f;return$f->result("SELECT SCOPE_IDENTITY()");}function
explain($f,$F){$f->query("SET SHOWPLAN_ALL ON");$H=$f->query($F);$f->query("SET SHOWPLAN_ALL OFF");return$H;}function
found_rows($Q,$Z){}function
foreign_keys($P){$H=array();foreach(get_rows("EXEC sp_fkeys @fktable_name = ".q($P).", @fktable_owner = ".q(get_schema()))as$I){$p=&$H[$I["FK_NAME"]];$p["db"]=$I["PKTABLE_QUALIFIER"];$p["table"]=$I["PKTABLE_NAME"];$p["source"][]=$I["FKCOLUMN_NAME"];$p["target"][]=$I["PKCOLUMN_NAME"];}return$H;}function
truncate_tables($R){return
apply_queries("TRUNCATE TABLE",$R);}function
drop_views($Xi){return
queries("DROP VIEW ".implode(", ",array_map('table',$Xi)));}function
drop_tables($R){return
queries("DROP TABLE ".implode(", ",array_map('table',$R)));}function
move_tables($R,$Xi,$Vh){return
apply_queries("ALTER SCHEMA ".idf_escape($Vh)." TRANSFER",array_merge($R,$Xi));}function
trigger($B){if($B=="")return
array();$J=get_rows("SELECT s.name [Trigger],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(s.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(s.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing],
c.text
FROM sysobjects s
JOIN syscomments c ON s.id = c.id
WHERE s.xtype = 'TR' AND s.name = ".q($B));$H=reset($J);if($H)$H["Statement"]=preg_replace('~^.+\s+AS\s+~isU','',$H["text"]);return$H;}function
triggers($P){$H=array();foreach(get_rows("SELECT sys1.name,
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing]
FROM sysobjects sys1
JOIN sysobjects sys2 ON sys1.parent_obj = sys2.id
WHERE sys1.xtype = 'TR' AND sys2.name = ".q($P))as$I)$H[$I["name"]]=array($I["Timing"],$I["Event"]);return$H;}function
trigger_options(){return
array("Timing"=>array("AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("AS"),);}function
schemas(){return
get_vals("SELECT name FROM sys.schemas");}function
get_schema(){global$f;if($_GET["ns"]!="")return$_GET["ns"];return$f->result("SELECT SCHEMA_NAME()");}function
set_schema($Wg){return
true;}function
use_sql($Ub){return"USE ".idf_escape($Ub);}function
show_variables(){return
array();}function
show_status(){return
array();}function
convert_field($m){}function
unconvert_field($m,$H){return$H;}function
support($Yc){return
preg_match('~^(check|comment|columns|database|drop_col|indexes|descidx|scheme|sql|table|trigger|view|view_trigger)$~',$Yc);}function
driver_config(){$U=array();$Fh=array();foreach(array('æ•¸å­—'=>array("tinyint"=>3,"smallint"=>5,"int"=>10,"bigint"=>20,"bit"=>1,"decimal"=>0,"real"=>12,"float"=>53,"smallmoney"=>10,"money"=>20),'æ—¥æœŸæ™‚é–“'=>array("date"=>10,"smalldatetime"=>19,"datetime"=>19,"datetime2"=>19,"time"=>8,"datetimeoffset"=>10),'å­—ä¸²'=>array("char"=>8000,"varchar"=>8000,"text"=>2147483647,"nchar"=>4000,"nvarchar"=>4000,"ntext"=>1073741823),'äºŒé€²ä½'=>array("binary"=>8000,"varbinary"=>8000,"image"=>2147483647),)as$x=>$X){$U+=$X;$Fh[$x]=array_keys($X);}return
array('possible_drivers'=>array("SQLSRV","MSSQL","PDO_DBLIB"),'jush'=>"mssql",'types'=>$U,'structured_types'=>$Fh,'unsigned'=>array(),'operators'=>array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL"),'functions'=>array("len","lower","round","upper"),'grouping'=>array("avg","count","count distinct","max","min","sum"),'edit_functions'=>array(array("date|time"=>"getdate",),array("int|decimal|real|float|money|datetime"=>"+/-","char|text"=>"+",)),);}}$nc["mongo"]="MongoDB (alpha)";if(isset($_GET["mongo"])){define("DRIVER","mongo");if(class_exists('MongoDB')){class
Min_DB{var$extension="Mongo",$server_info=MongoClient::VERSION,$error,$last_id,$_link,$_db;function
connect($Ii,$C){try{$this->_link=new
MongoClient($Ii,$C);if($C["password"]!=""){$C["password"]="";try{new
MongoClient($Ii,$C);$this->error='è³‡æ–™åº«ä¸æ”¯æ´å¯†ç¢¼ã€‚';}catch(Exception$uc){}}}catch(Exception$uc){$this->error=$uc->getMessage();}}function
query($F){return
false;}function
select_db($Ub){try{$this->_db=$this->_link->selectDB($Ub);return
true;}catch(Exception$Lc){$this->error=$Lc->getMessage();return
false;}}function
quote($O){return$O;}}class
Min_Result{var$num_rows,$_rows=array(),$_offset=0,$_charset=array();function
__construct($G){foreach($G
as$fe){$I=array();foreach($fe
as$x=>$X){if(is_a($X,'MongoBinData'))$this->_charset[$x]=63;$I[$x]=(is_a($X,'MongoId')?"ObjectId(\"$X\")":(is_a($X,'MongoDate')?gmdate("Y-m-d H:i:s",$X->sec)." GMT":(is_a($X,'MongoBinData')?$X->bin:(is_a($X,'MongoRegex')?"$X":(is_object($X)?get_class($X):$X)))));}$this->_rows[]=$I;foreach($I
as$x=>$X){if(!isset($this->_rows[0][$x]))$this->_rows[0][$x]=null;}}$this->num_rows=count($this->_rows);}function
fetch_assoc(){$I=current($this->_rows);if(!$I)return$I;$H=array();foreach($this->_rows[0]as$x=>$X)$H[$x]=$I[$x];next($this->_rows);return$H;}function
fetch_row(){$H=$this->fetch_assoc();if(!$H)return$H;return
array_values($H);}function
fetch_field(){$je=array_keys($this->_rows[0]);$B=$je[$this->_offset++];return(object)array('name'=>$B,'charsetnr'=>$this->_charset[$B],);}}class
Min_Driver
extends
Min_SQL{public$jg="_id";function
select($P,$K,$Z,$vd,$_f=array(),$y=1,$D=0,$lg=false){$K=($K==array("*")?array():array_fill_keys($K,true));$th=array();foreach($_f
as$X){$X=preg_replace('~ DESC$~','',$X,1,$Jb);$th[$X]=($Jb?-1:1);}return
new
Min_Result($this->_conn->_db->selectCollection($P)->find(array(),$K)->sort($th)->limit($y!=""?+$y:0)->skip($D*$y));}function
insert($P,$M){try{$H=$this->_conn->_db->selectCollection($P)->insert($M);$this->_conn->errno=$H['code'];$this->_conn->error=$H['err'];$this->_conn->last_id=$M['_id'];return!$H['err'];}catch(Exception$Lc){$this->_conn->error=$Lc->getMessage();return
false;}}}function
get_databases($id){global$f;$H=array();$Yb=$f->_link->listDBs();foreach($Yb['databases']as$j)$H[]=$j['name'];return$H;}function
count_tables($i){global$f;$H=array();foreach($i
as$j)$H[$j]=count($f->_link->selectDB($j)->getCollectionNames(true));return$H;}function
tables_list(){global$f;return
array_fill_keys($f->_db->getCollectionNames(true),'table');}function
drop_databases($i){global$f;foreach($i
as$j){$Ig=$f->_link->selectDB($j)->drop();if(!$Ig['ok'])return
false;}return
true;}function
indexes($P,$g=null){global$f;$H=array();foreach($f->_db->selectCollection($P)->getIndexInfo()as$u){$gc=array();foreach($u["key"]as$d=>$T)$gc[]=($T==-1?'1':null);$H[$u["name"]]=array("type"=>($u["name"]=="_id_"?"PRIMARY":($u["unique"]?"UNIQUE":"INDEX")),"columns"=>array_keys($u["key"]),"lengths"=>array(),"descs"=>$gc,);}return$H;}function
fields($P){return
fields_from_edit();}function
found_rows($Q,$Z){global$f;return$f->_db->selectCollection($_GET["select"])->count($Z);}$wf=array("=");}elseif(class_exists('MongoDB\Driver\Manager')){class
Min_DB{var$extension="MongoDB",$server_info=MONGODB_VERSION,$affected_rows,$error,$last_id;var$_link;var$_db,$_db_name;function
connect($Ii,$C){$jb='MongoDB\Driver\Manager';$this->_link=new$jb($Ii,$C);$this->executeCommand($C["db"],array('ping'=>1));}function
executeCommand($j,$tb){$jb='MongoDB\Driver\Command';try{return$this->_link->executeCommand($j,new$jb($tb));}catch(Exception$uc){$this->error=$uc->getMessage();return
array();}}function
executeBulkWrite($Ye,$Wa,$Kb){try{$Lg=$this->_link->executeBulkWrite($Ye,$Wa);$this->affected_rows=$Lg->$Kb();return
true;}catch(Exception$uc){$this->error=$uc->getMessage();return
false;}}function
query($F){return
false;}function
select_db($Ub){$this->_db_name=$Ub;return
true;}function
quote($O){return$O;}}class
Min_Result{var$num_rows,$_rows=array(),$_offset=0,$_charset=array();function
__construct($G){foreach($G
as$fe){$I=array();foreach($fe
as$x=>$X){if(is_a($X,'MongoDB\BSON\Binary'))$this->_charset[$x]=63;$I[$x]=(is_a($X,'MongoDB\BSON\ObjectID')?'MongoDB\BSON\ObjectID("'."$X\")":(is_a($X,'MongoDB\BSON\UTCDatetime')?$X->toDateTime()->format('Y-m-d H:i:s'):(is_a($X,'MongoDB\BSON\Binary')?$X->getData():(is_a($X,'MongoDB\BSON\Regex')?"$X":(is_object($X)||is_array($X)?json_encode($X,256):$X)))));}$this->_rows[]=$I;foreach($I
as$x=>$X){if(!isset($this->_rows[0][$x]))$this->_rows[0][$x]=null;}}$this->num_rows=count($this->_rows);}function
fetch_assoc(){$I=current($this->_rows);if(!$I)return$I;$H=array();foreach($this->_rows[0]as$x=>$X)$H[$x]=$I[$x];next($this->_rows);return$H;}function
fetch_row(){$H=$this->fetch_assoc();if(!$H)return$H;return
array_values($H);}function
fetch_field(){$je=array_keys($this->_rows[0]);$B=$je[$this->_offset++];return(object)array('name'=>$B,'charsetnr'=>$this->_charset[$B],);}}class
Min_Driver
extends
Min_SQL{public$jg="_id";function
select($P,$K,$Z,$vd,$_f=array(),$y=1,$D=0,$lg=false){global$f;$K=($K==array("*")?array():array_fill_keys($K,1));if(count($K)&&!isset($K['_id']))$K['_id']=0;$Z=where_to_query($Z);$th=array();foreach($_f
as$X){$X=preg_replace('~ DESC$~','',$X,1,$Jb);$th[$X]=($Jb?-1:1);}if(isset($_GET['limit'])&&is_numeric($_GET['limit'])&&$_GET['limit']>0)$y=$_GET['limit'];$y=min(200,max(1,(int)$y));$qh=$D*$y;$jb='MongoDB\Driver\Query';try{return
new
Min_Result($f->_link->executeQuery("$f->_db_name.$P",new$jb($Z,array('projection'=>$K,'limit'=>$y,'skip'=>$qh,'sort'=>$th))));}catch(Exception$uc){$f->error=$uc->getMessage();return
false;}}function
update($P,$M,$ug,$y=0,$eh="\n"){global$f;$j=$f->_db_name;$Z=sql_query_where_parser($ug);$jb='MongoDB\Driver\BulkWrite';$Wa=new$jb(array());if(isset($M['_id']))unset($M['_id']);$Fg=array();foreach($M
as$x=>$Y){if($Y=='NULL'){$Fg[$x]=1;unset($M[$x]);}}$Hi=array('$set'=>$M);if(count($Fg))$Hi['$unset']=$Fg;$Wa->update($Z,$Hi,array('upsert'=>false));return$f->executeBulkWrite("$j.$P",$Wa,'getModifiedCount');}function
delete($P,$ug,$y=0){global$f;$j=$f->_db_name;$Z=sql_query_where_parser($ug);$jb='MongoDB\Driver\BulkWrite';$Wa=new$jb(array());$Wa->delete($Z,array('limit'=>$y));return$f->executeBulkWrite("$j.$P",$Wa,'getDeletedCount');}function
insert($P,$M){global$f;$j=$f->_db_name;$jb='MongoDB\Driver\BulkWrite';$Wa=new$jb(array());if($M['_id']=='')unset($M['_id']);$Wa->insert($M);return$f->executeBulkWrite("$j.$P",$Wa,'getInsertedCount');}}function
get_databases($id){global$f;$H=array();foreach($f->executeCommand($f->_db_name,array('listDatabases'=>1))as$Yb){foreach($Yb->databases
as$j)$H[]=$j->name;}return$H;}function
count_tables($i){$H=array();return$H;}function
tables_list(){global$f;$qb=array();foreach($f->executeCommand($f->_db_name,array('listCollections'=>1))as$G)$qb[$G->name]='table';return$qb;}function
drop_databases($i){return
false;}function
indexes($P,$g=null){global$f;$H=array();foreach($f->executeCommand($f->_db_name,array('listIndexes'=>$P))as$u){$gc=array();$e=array();foreach(get_object_vars($u->key)as$d=>$T){$gc[]=($T==-1?'1':null);$e[]=$d;}$H[$u->name]=array("type"=>($u->name=="_id_"?"PRIMARY":(isset($u->unique)?"UNIQUE":"INDEX")),"columns"=>$e,"lengths"=>array(),"descs"=>$gc,);}return$H;}function
fields($P){global$k;$n=fields_from_edit();if(!$n){$G=$k->select($P,array("*"),null,null,array(),10);if($G){while($I=$G->fetch_assoc()){foreach($I
as$x=>$X){$I[$x]=null;$n[$x]=array("field"=>$x,"type"=>"string","null"=>($x!=$k->primary),"auto_increment"=>($x==$k->primary),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1,),);}}}}return$n;}function
found_rows($Q,$Z){global$f;$Z=where_to_query($Z);$li=$f->executeCommand($f->_db_name,array('count'=>$Q['Name'],'query'=>$Z))->toArray();return$li[0]->n;}function
sql_query_where_parser($ug){$ug=preg_replace('~^\s*WHERE\s*~',"",$ug);while($ug[0]=="(")$ug=preg_replace('~^\((.*)\)$~',"$1",$ug);$hj=explode(' AND ',$ug);$ij=explode(') OR (',$ug);$Z=array();foreach($hj
as$fj)$Z[]=trim($fj);if(count($ij)==1)$ij=array();elseif(count($ij)>1)$Z=array();return
where_to_query($Z,$ij);}function
where_to_query($dj=array(),$ej=array()){global$b;$Sb=array();foreach(array('and'=>$dj,'or'=>$ej)as$T=>$Z){if(is_array($Z)){foreach($Z
as$Rc){list($mb,$uf,$X)=explode(" ",$Rc,3);if($mb=="_id"&&preg_match('~^(MongoDB\\\\BSON\\\\ObjectID)\("(.+)"\)$~',$X,$A)){list(,$jb,$X)=$A;$X=new$jb($X);}if(!in_array($uf,$b->operators))continue;if(preg_match('~^\(f\)(.+)~',$uf,$A)){$X=(float)$X;$uf=$A[1];}elseif(preg_match('~^\(date\)(.+)~',$uf,$A)){$Vb=new
DateTime($X);$jb='MongoDB\BSON\UTCDatetime';$X=new$jb($Vb->getTimestamp()*1000);$uf=$A[1];}switch($uf){case'=':$uf='$eq';break;case'!=':$uf='$ne';break;case'>':$uf='$gt';break;case'<':$uf='$lt';break;case'>=':$uf='$gte';break;case'<=':$uf='$lte';break;case'regex':$uf='$regex';break;default:continue
2;}if($T=='and')$Sb['$and'][]=array($mb=>array($uf=>$X));elseif($T=='or')$Sb['$or'][]=array($mb=>array($uf=>$X));}}}return$Sb;}$wf=array("=","!=",">","<",">=","<=","regex","(f)=","(f)!=","(f)>","(f)<","(f)>=","(f)<=","(date)=","(date)!=","(date)>","(date)<","(date)>=","(date)<=",);}function
table($t){return$t;}function
idf_escape($t){return$t;}function
table_status($B="",$Xc=false){$H=array();foreach(tables_list()as$P=>$T){$H[$P]=array("Name"=>$P);if($B==$P)return$H[$P];}return$H;}function
create_database($j,$ob){return
true;}function
last_id(){global$f;return$f->last_id;}function
error(){global$f;return
h($f->error);}function
collations(){return
array();}function
logged_user(){global$b;$Nb=$b->credentials();return$Nb[1];}function
connect(){global$b;$f=new
Min_DB;list($L,$V,$E)=$b->credentials();if($L=="")$L="localhost:27017";$C=array();if($V.$E!=""){$C["username"]=$V;$C["password"]=$E;}$j=$b->database();if($j!="")$C["db"]=$j;if(($Ja=getenv("MONGO_AUTH_SOURCE")))$C["authSource"]=$Ja;$f->connect("mongodb://$L",$C);if($f->error)return$f->error;return$f;}function
alter_indexes($P,$c){global$f;foreach($c
as$X){list($T,$B,$M)=$X;if($M=="DROP")$H=$f->_db->command(array("deleteIndexes"=>$P,"index"=>$B));else{$e=array();foreach($M
as$d){$d=preg_replace('~ DESC$~','',$d,1,$Jb);$e[$d]=($Jb?-1:1);}$H=$f->_db->selectCollection($P)->ensureIndex($e,array("unique"=>($T=="UNIQUE"),"name"=>$B,));}if($H['errmsg']){$f->error=$H['errmsg'];return
false;}}return
true;}function
support($Yc){return
preg_match("~database|indexes|descidx~",$Yc);}function
db_collation($j,$pb){}function
information_schema(){}function
is_view($Q){}function
convert_field($m){}function
unconvert_field($m,$H){return$H;}function
foreign_keys($P){return
array();}function
fk_support($Q){}function
engines(){return
array();}function
alter_table($P,$B,$n,$kd,$vb,$Cc,$ob,$Ka,$Uf){global$f;if($P==""){$f->_db->createCollection($B);return
true;}}function
drop_tables($R){global$f;foreach($R
as$P){$Ig=$f->_db->selectCollection($P)->drop();if(!$Ig['ok'])return
false;}return
true;}function
truncate_tables($R){global$f;foreach($R
as$P){$Ig=$f->_db->selectCollection($P)->remove();if(!$Ig['ok'])return
false;}return
true;}function
driver_config(){global$wf;return
array('possible_drivers'=>array("mongo","mongodb"),'jush'=>"mongo",'operators'=>$wf,'functions'=>array(),'grouping'=>array(),'edit_functions'=>array(array("json")),);}}class
Adminer{var$operators;function
name(){return"<a href='https://www.adminer.org/'".target_blank()." id='h1'>Adminer</a>";}function
credentials(){return
array(SERVER,$_GET["username"],get_password());}function
connectSsl(){}function
permanentLogin($h=false){return
password_file($h);}function
bruteForceKey(){return$_SERVER["REMOTE_ADDR"];}function
serverName($L){return
h($L);}function
database(){return
DB;}function
databases($id=true){return
get_databases($id);}function
schemas(){return
schemas();}function
queryTimeout(){return
2;}function
headers(){}function
csp(){return
csp();}function
head(){return
true;}function
css(){$H=array();$o="adminer.css";if(file_exists($o))$H[]="$o?v=".crc32(file_get_contents($o));return$H;}function
loginForm(){global$nc;echo"<table class='layout'>\n",$this->loginFormField('driver','<tr><th>'.'è³‡æ–™åº«ç³»çµ±'.'<td>',html_select("auth[driver]",$nc,DRIVER,"loginDriver(this);")."\n"),$this->loginFormField('server','<tr><th>'.'ä¼ºæœå™¨'.'<td>','<input name="auth[server]" value="'.h(SERVER).'" title="hostname[:port]" placeholder="localhost" autocapitalize="off">'."\n"),$this->loginFormField('username','<tr><th>'.'å¸³è™Ÿ'.'<td>','<input name="auth[username]" id="username" autofocus value="'.h($_GET["username"]).'" autocomplete="username" autocapitalize="off">'.script("qs('#username').form['auth[driver]'].onchange();")),$this->loginFormField('password','<tr><th>'.'å¯†ç¢¼'.'<td>','<input type="password" name="auth[password]" autocomplete="current-password">'."\n"),$this->loginFormField('db','<tr><th>'.'è³‡æ–™åº«'.'<td>','<input name="auth[db]" value="'.h($_GET["db"]).'" autocapitalize="off">'."\n"),"</table>\n","<p><input type='submit' value='".'ç™»å…¥'."'>\n",checkbox("auth[permanent]",1,$_COOKIE["adminer_permanent"],'æ°¸ä¹…ç™»å…¥')."\n";}function
loginFormField($B,$Ed,$Y){return$Ed.$Y;}function
login($ze,$E){if($E=="")return
sprintf('Admineré è¨­ä¸æ”¯æ´è¨ªå•æ²’æœ‰å¯†ç¢¼çš„è³‡æ–™åº«ï¼Œ<a href="https://www.adminer.org/en/password/"%s>è©³æƒ…è¦‹é€™è£¡</a>.',target_blank());return
true;}function
tableName($Mh){return
h($Mh["Name"]);}function
fieldName($m,$_f=0){return'<span title="'.h($m["full_type"]).'">'.h($m["field"]).'</span>';}function
selectLinks($Mh,$M=""){global$w,$k;echo'<p class="links">';$ye=array("select"=>'é¸æ“‡è³‡æ–™');if(support("table")||support("indexes"))$ye["table"]='é¡¯ç¤ºçµæ§‹';if(support("table")){if(is_view($Mh))$ye["view"]='ä¿®æ”¹æª¢è¦–è¡¨';else$ye["create"]='ä¿®æ”¹è³‡æ–™è¡¨';}if($M!==null)$ye["edit"]='æ–°å¢é …ç›®';$B=$Mh["Name"];foreach($ye
as$x=>$X)echo" <a href='".h(ME)."$x=".urlencode($B).($x=="edit"?$M:"")."'".bold(isset($_GET[$x])).">$X</a>";echo
doc_link(array($w=>$k->tableHelp($B)),"?"),"\n";}function
foreignKeys($P){return
foreign_keys($P);}function
backwardKeys($P,$Lh){return
array();}function
backwardKeysPrint($Na,$I){}function
selectQuery($F,$Ch,$Wc=false){global$w,$k;$H="</p>\n";if(!$Wc&&($aj=$k->warnings())){$Jd="warnings";$H=", <a href='#$Jd'>".'è­¦å‘Š'."</a>".script("qsl('a').onclick = partial(toggle, '$Jd');","")."$H<div id='$Jd' class='hidden'>\n$aj</div>\n";}return"<p><code class='jush-$w'>".h(str_replace("\n"," ",$F))."</code> <span class='time'>(".format_time($Ch).")</span>".(support("sql")?" <a href='".h(ME)."sql=".urlencode($F)."'>".'ç·¨è¼¯'."</a>":"").$H;}function
sqlCommandQuery($F){return
shorten_utf8(trim($F),1000);}function
rowDescription($P){return"";}function
rowDescriptions($J,$ld){return$J;}function
selectLink($X,$m){}function
selectVal($X,$z,$m,$Hf){$H=($X===null?"<i>NULL</i>":(preg_match("~char|binary|boolean~",$m["type"])&&!preg_match("~var~",$m["type"])?"<code>$X</code>":$X));if(preg_match('~blob|bytea|raw|file~',$m["type"])&&!is_utf8($X))$H="<i>".sprintf('%d byte(s)',strlen($Hf))."</i>";if(preg_match('~json~',$m["type"]))$H="<code class='jush-js'>$H</code>";return($z?"<a href='".h($z)."'".(is_url($z)?target_blank():"").">$H</a>":$H);}function
editVal($X,$m){return$X;}function
tableStructurePrint($n){global$Fh;echo"<div class='scrollable'>\n","<table class='nowrap odds'>\n","<thead><tr><th>".'æ¬„ä½'."<td>".'é¡å‹'.(support("comment")?"<td>".'è¨»è§£':"")."</thead>\n";foreach($n
as$m){echo"<tr><th>".h($m["field"]);$T=h($m["full_type"]);echo"<td><span title='".h($m["collation"])."'>".(in_array($T,(array)$Fh['ä½¿ç”¨è€…é¡å‹'])?"<a href='".h(ME.'type='.urlencode($T))."'>$T</a>":$T)."</span>",($m["null"]?" <i>NULL</i>":""),($m["auto_increment"]?" <i>".'è‡ªå‹•éå¢'."</i>":""),(isset($m["default"])?" <span title='".'é è¨­å€¼'."'>[<b>".h($m["default"])."</b>]</span>":""),(support("comment")?"<td>".h($m["comment"]):""),"\n";}echo"</table>\n","</div>\n";}function
tableIndexesPrint($v){echo"<table>\n";foreach($v
as$B=>$u){ksort($u["columns"]);$lg=array();foreach($u["columns"]as$x=>$X)$lg[]="<i>".h($X)."</i>".($u["lengths"][$x]?"(".$u["lengths"][$x].")":"").($u["descs"][$x]?" DESC":"");echo"<tr title='".h($B)."'><th>$u[type]<td>".implode(", ",$lg)."\n";}echo"</table>\n";}function
selectColumnsPrint($K,$e){global$rd,$yd;print_fieldset("select",'é¸æ“‡',$K);$s=0;$K[""]=array();foreach($K
as$x=>$X){$X=$_GET["columns"][$x];$d=select_input(" name='columns[$s][col]'",$e,$X["col"],($x!==""?"selectFieldChange":"selectAddRow"));echo"<div>".($rd||$yd?"<select name='columns[$s][fun]'>".optionlist(array(-1=>"")+array_filter(array('å‡½å¼'=>$rd,'é›†åˆ'=>$yd)),$X["fun"])."</select>".on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'",1).script("qsl('select').onchange = function () { helpClose();".($x!==""?"":" qsl('select, input', this.parentNode).onchange();")." };","")."($d)":$d)."</div>\n";$s++;}echo"</div></fieldset>\n";}function
selectSearchPrint($Z,$e,$v){print_fieldset("search",'æœå°‹',$Z);foreach($v
as$s=>$u){if($u["type"]=="FULLTEXT"){echo"<div>(<i>".implode("</i>, <i>",array_map('h',$u["columns"]))."</i>) AGAINST"," <input type='search' name='fulltext[$s]' value='".h($_GET["fulltext"][$s])."'>",script("qsl('input').oninput = selectFieldChange;",""),checkbox("boolean[$s]",1,isset($_GET["boolean"][$s]),"BOOL"),"</div>\n";}}$ab="this.parentNode.firstChild.onchange();";foreach(array_merge((array)$_GET["where"],array(array()))as$s=>$X){if(!$X||("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators))){echo"<div>".select_input(" name='where[$s][col]'",$e,$X["col"],($X?"selectFieldChange":"selectAddRow"),"(".'ä»»æ„ä½ç½®'.")"),html_select("where[$s][op]",$this->operators,$X["op"],$ab),"<input type='search' name='where[$s][val]' value='".h($X["val"])."'>",script("mixin(qsl('input'), {oninput: function () { $ab }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});",""),"</div>\n";}}echo"</div></fieldset>\n";}function
selectOrderPrint($_f,$e,$v){print_fieldset("sort",'æ’åº',$_f);$s=0;foreach((array)$_GET["order"]as$x=>$X){if($X!=""){echo"<div>".select_input(" name='order[$s]'",$e,$X,"selectFieldChange"),checkbox("desc[$s]",1,isset($_GET["desc"][$x]),'é™å†ª (éæ¸›)')."</div>\n";$s++;}}echo"<div>".select_input(" name='order[$s]'",$e,"","selectAddRow"),checkbox("desc[$s]",1,false,'é™å†ª (éæ¸›)')."</div>\n","</div></fieldset>\n";}function
selectLimitPrint($y){echo"<fieldset><legend>".'é™å®š'."</legend><div>";echo"<input type='number' name='limit' class='size' value='".h($y)."'>",script("qsl('input').oninput = selectFieldChange;",""),"</div></fieldset>\n";}function
selectLengthPrint($bi){if($bi!==null){echo"<fieldset><legend>".'Text é•·åº¦'."</legend><div>","<input type='number' name='text_length' class='size' value='".h($bi)."'>","</div></fieldset>\n";}}function
selectActionPrint($v){echo"<fieldset><legend>".'å‹•ä½œ'."</legend><div>","<input type='submit' value='".'é¸æ“‡'."'>"," <span id='noindex' title='".'å…¨è³‡æ–™è¡¨æƒæ'."'></span>","<script".nonce().">\n","var indexColumns = ";$e=array();foreach($v
as$u){$Rb=reset($u["columns"]);if($u["type"]!="FULLTEXT"&&$Rb)$e[$Rb]=1;}$e[""]=1;foreach($e
as$x=>$X)json_row($x);echo";\n","selectFieldChange.call(qs('#form')['select']);\n","</script>\n","</div></fieldset>\n";}function
selectCommandPrint(){return!information_schema(DB);}function
selectImportPrint(){return!information_schema(DB);}function
selectEmailPrint($_c,$e){}function
selectColumnsProcess($e,$v){global$rd,$yd;$K=array();$vd=array();foreach((array)$_GET["columns"]as$x=>$X){if($X["fun"]=="count"||($X["col"]!=""&&(!$X["fun"]||in_array($X["fun"],$rd)||in_array($X["fun"],$yd)))){$K[$x]=apply_sql_function($X["fun"],($X["col"]!=""?idf_escape($X["col"]):"*"));if(!in_array($X["fun"],$yd))$vd[]=$K[$x];}}return
array($K,$vd);}function
selectSearchProcess($n,$v){global$f,$k;$H=array();foreach($v
as$s=>$u){if($u["type"]=="FULLTEXT"&&$_GET["fulltext"][$s]!="")$H[]="MATCH (".implode(", ",array_map('idf_escape',$u["columns"])).") AGAINST (".q($_GET["fulltext"][$s]).(isset($_GET["boolean"][$s])?" IN BOOLEAN MODE":"").")";}foreach((array)$_GET["where"]as$x=>$X){if("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators)){$hg="";$yb=" $X[op]";if(preg_match('~IN$~',$X["op"])){$Nd=process_length($X["val"]);$yb.=" ".($Nd!=""?$Nd:"(NULL)");}elseif($X["op"]=="SQL")$yb=" $X[val]";elseif($X["op"]=="LIKE %%")$yb=" LIKE ".$this->processInput($n[$X["col"]],"%$X[val]%");elseif($X["op"]=="ILIKE %%")$yb=" ILIKE ".$this->processInput($n[$X["col"]],"%$X[val]%");elseif($X["op"]=="FIND_IN_SET"){$hg="$X[op](".q($X["val"]).", ";$yb=")";}elseif(!preg_match('~NULL$~',$X["op"]))$yb.=" ".$this->processInput($n[$X["col"]],$X["val"]);if($X["col"]!="")$H[]=$hg.$k->convertSearch(idf_escape($X["col"]),$X,$n[$X["col"]]).$yb;else{$rb=array();foreach($n
as$B=>$m){if((preg_match('~^[-\d.'.(preg_match('~IN$~',$X["op"])?',':'').']+$~',$X["val"])||!preg_match('~'.number_type().'|bit~',$m["type"]))&&(!preg_match("~[\x80-\xFF]~",$X["val"])||preg_match('~char|text|enum|set~',$m["type"]))&&(!preg_match('~date|timestamp~',$m["type"])||preg_match('~^\d+-\d+-\d+~',$X["val"])))$rb[]=$hg.$k->convertSearch(idf_escape($B),$X,$m).$yb;}$H[]=($rb?"(".implode(" OR ",$rb).")":"1 = 0");}}}return$H;}function
selectOrderProcess($n,$v){$H=array();foreach((array)$_GET["order"]as$x=>$X){if($X!="")$H[]=(preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~',$X)?$X:idf_escape($X)).(isset($_GET["desc"][$x])?" DESC":"");}return$H;}function
selectLimitProcess(){return(isset($_GET["limit"])?$_GET["limit"]:"50");}function
selectLengthProcess(){return(isset($_GET["text_length"])?$_GET["text_length"]:"100");}function
selectEmailProcess($Z,$ld){return
false;}function
selectQueryBuild($K,$Z,$vd,$_f,$y,$D){return"";}function
messageQuery($F,$ci,$Wc=false){global$w,$k;restart_session();$Fd=&get_session("queries");if(!$Fd[$_GET["db"]])$Fd[$_GET["db"]]=array();if(strlen($F)>1e6)$F=preg_replace('~[\x80-\xFF]+$~','',substr($F,0,1e6))."\nâ€¦";$Fd[$_GET["db"]][]=array($F,time(),$ci);$zh="sql-".count($Fd[$_GET["db"]]);$H="<a href='#$zh' class='toggle'>".'SQL å‘½ä»¤'."</a>\n";if(!$Wc&&($aj=$k->warnings())){$Jd="warnings-".count($Fd[$_GET["db"]]);$H="<a href='#$Jd' class='toggle'>".'è­¦å‘Š'."</a>, $H<div id='$Jd' class='hidden'>\n$aj</div>\n";}return" <span class='time'>".@date("H:i:s")."</span>"." $H<div id='$zh' class='hidden'><pre><code class='jush-$w'>".shorten_utf8($F,1000)."</code></pre>".($ci?" <span class='time'>($ci)</span>":'').(support("sql")?'<p><a href="'.h(str_replace("db=".urlencode(DB),"db=".urlencode($_GET["db"]),ME).'sql=&history='.(count($Fd[$_GET["db"]])-1)).'">'.'ç·¨è¼¯'.'</a>':'').'</div>';}function
editRowPrint($P,$n,$I,$Hi){}function
editFunctions($m){global$vc;$H=($m["null"]?"NULL/":"");$Hi=isset($_GET["select"])||where($_GET);foreach($vc
as$x=>$rd){if(!$x||(!isset($_GET["call"])&&$Hi)){foreach($rd
as$Yf=>$X){if(!$Yf||preg_match("~$Yf~",$m["type"]))$H.="/$X";}}if($x&&!preg_match('~set|blob|bytea|raw|file|bool~',$m["type"]))$H.="/SQL";}if($m["auto_increment"]&&!$Hi)$H='è‡ªå‹•éå¢';return
explode("/",$H);}function
editInput($P,$m,$Ha,$Y){if($m["type"]=="enum")return(isset($_GET["select"])?"<label><input type='radio'$Ha value='-1' checked><i>".'åŸå§‹'."</i></label> ":"").($m["null"]?"<label><input type='radio'$Ha value=''".($Y!==null||isset($_GET["select"])?"":" checked")."><i>NULL</i></label> ":"").enum_input("radio",$Ha,$m,$Y,$Y===0?0:null);return"";}function
editHint($P,$m,$Y){return"";}function
processInput($m,$Y,$r=""){if($r=="SQL")return$Y;$B=$m["field"];$H=q($Y);if(preg_match('~^(now|getdate|uuid)$~',$r))$H="$r()";elseif(preg_match('~^current_(date|timestamp)$~',$r))$H=$r;elseif(preg_match('~^([+-]|\|\|)$~',$r))$H=idf_escape($B)." $r $H";elseif(preg_match('~^[+-] interval$~',$r))$H=idf_escape($B)." $r ".(preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i",$Y)?$Y:$H);elseif(preg_match('~^(addtime|subtime|concat)$~',$r))$H="$r(".idf_escape($B).", $H)";elseif(preg_match('~^(md5|sha1|password|encrypt)$~',$r))$H="$r($H)";return
unconvert_field($m,$H);}function
dumpOutput(){$H=array('text'=>'æ‰“é–‹','file'=>'å„²å­˜');if(function_exists('gzencode'))$H['gz']='gzip';return$H;}function
dumpFormat(){return
array('sql'=>'SQL','csv'=>'CSV,','csv;'=>'CSV;','tsv'=>'TSV');}function
dumpDatabase($j){}function
dumpTable($P,$Gh,$ee=0){if($_POST["format"]!="sql"){echo"\xef\xbb\xbf";if($Gh)dump_csv(array_keys(fields($P)));}else{if($ee==2){$n=array();foreach(fields($P)as$B=>$m)$n[]=idf_escape($B)." $m[full_type]";$h="CREATE TABLE ".table($P)." (".implode(", ",$n).")";}else$h=create_sql($P,$_POST["auto_increment"],$Gh);set_utf8mb4($h);if($Gh&&$h){if($Gh=="DROP+CREATE"||$ee==1)echo"DROP ".($ee==2?"VIEW":"TABLE")." IF EXISTS ".table($P).";\n";if($ee==1)$h=remove_definer($h);echo"$h;\n\n";}}}function
dumpData($P,$Gh,$F){global$f,$w;if($Gh){$Fe=($w=="sqlite"?0:1048576);$n=array();if($_POST["format"]=="sql"){if($Gh=="TRUNCATE+INSERT")echo
truncate_sql($P).";\n";$n=fields($P);}$G=$f->query($F,1);if($G){$Xd="";$Va="";$je=array();$sd=array();$Ih="";$Zc=($P!=''?'fetch_assoc':'fetch_row');while($I=$G->$Zc()){if(!$je){$Si=array();foreach($I
as$X){$m=$G->fetch_field();if($n[$m->name]['generated']){$sd[$m->name]=true;continue;}$je[]=$m->name;$x=idf_escape($m->name);$Si[]="$x = VALUES($x)";}$Ih=($Gh=="INSERT+UPDATE"?"\nON DUPLICATE KEY UPDATE ".implode(", ",$Si):"").";\n";}if($_POST["format"]!="sql"){if($Gh=="table"){dump_csv($je);$Gh="INSERT";}dump_csv($I);}else{if(!$Xd)$Xd="INSERT INTO ".table($P)." (".implode(", ",array_map('idf_escape',$je)).") VALUES";foreach($I
as$x=>$X){if($sd[$x]){unset($I[$x]);continue;}$m=$n[$x];$I[$x]=($X!==null?unconvert_field($m,preg_match(number_type(),$m["type"])&&!preg_match('~\[~',$m["full_type"])&&is_numeric($X)?$X:q(($X===false?0:$X))):"NULL");}$Ug=($Fe?"\n":" ")."(".implode(",\t",$I).")";if(!$Va)$Va=$Xd.$Ug;elseif(strlen($Va)+4+strlen($Ug)+strlen($Ih)<$Fe)$Va.=",$Ug";else{echo$Va.$Ih;$Va=$Xd.$Ug;}}}if($Va)echo$Va.$Ih;}elseif($_POST["format"]=="sql")echo"-- ".str_replace("\n"," ",$f->error)."\n";}}function
dumpFilename($Kd){return
friendly_url($Kd!=""?$Kd:(SERVER!=""?SERVER:"localhost"));}function
dumpHeaders($Kd,$Ue=false){$Kf=$_POST["output"];$Sc=(preg_match('~sql~',$_POST["format"])?"sql":($Ue?"tar":"csv"));header("Content-Type: ".($Kf=="gz"?"application/x-gzip":($Sc=="tar"?"application/x-tar":($Sc=="sql"||$Kf!="file"?"text/plain":"text/csv")."; charset=utf-8")));if($Kf=="gz")ob_start('ob_gzencode',1e6);return$Sc;}function
importServerPath(){return"adminer.sql";}function
homepage(){echo'<p class="links">'.($_GET["ns"]==""&&support("database")?'<a href="'.h(ME).'database=">'.'ä¿®æ”¹è³‡æ–™åº«'."</a>\n":""),(support("scheme")?"<a href='".h(ME)."scheme='>".($_GET["ns"]!=""?'ä¿®æ”¹è³‡æ–™è¡¨çµæ§‹':'å»ºç«‹è³‡æ–™è¡¨çµæ§‹')."</a>\n":""),($_GET["ns"]!==""?'<a href="'.h(ME).'schema=">'.'è³‡æ–™åº«çµæ§‹'."</a>\n":""),(support("privileges")?"<a href='".h(ME)."privileges='>".'æ¬Šé™'."</a>\n":"");return
true;}function
navigation($Te){global$ia,$w,$nc,$f;echo'<h1>
',$this->name(),'<span class="version">
',$ia,' <a href="https://www.adminer.org/#download"',target_blank(),' id="version">',(version_compare($ia,$_COOKIE["adminer_version"])<0?h($_COOKIE["adminer_version"]):""),'</a>
</span>
</h1>
';if($Te=="auth"){$Kf="";foreach((array)$_SESSION["pwds"]as$Ui=>$jh){foreach($jh
as$L=>$Pi){foreach($Pi
as$V=>$E){if($E!==null){$Yb=$_SESSION["db"][$Ui][$L][$V];foreach(($Yb?array_keys($Yb):array(""))as$j)$Kf.="<li><a href='".h(auth_url($Ui,$L,$V,$j))."'>($nc[$Ui]) ".h($V.($L!=""?"@".$this->serverName($L):"").($j!=""?" - $j":""))."</a>\n";}}}}if($Kf)echo"<ul id='logins'>\n$Kf</ul>\n".script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");}else{$R=array();if($_GET["ns"]!==""&&!$Te&&DB!=""){$f->select_db(DB);$R=table_status('',true);}echo
script_src(preg_replace("~\\?.*~","",ME)."?file=jush.js&version=4.17.1");if(support("sql")){echo'<script',nonce(),'>
';if($R){$ye=array();foreach($R
as$P=>$T)$ye[]=preg_quote($P,'/');echo"var jushLinks = { $w: [ '".js_escape(ME).(support("table")?"table=":"select=")."\$&', /\\b(".implode("|",$ye).")\\b/g ] };\n";foreach(array("bac","bra","sqlite_quo","mssql_bra")as$X)echo"jushLinks.$X = jushLinks.$w;\n";}$ih=$f->server_info;echo'bodyLoad(\'',(is_object($f)?preg_replace('~^(\d\.?\d).*~s','\1',$ih):""),'\'',(preg_match('~MariaDB~',$ih)?", true":""),');
</script>
';}$this->databasesPrint($Te);$va=array();if(DB==""||!$Te){if(support("sql")){$va[]="<a href='".h(ME)."sql='".bold(isset($_GET["sql"])&&!isset($_GET["import"])).">".'SQL å‘½ä»¤'."</a>";$va[]="<a href='".h(ME)."import='".bold(isset($_GET["import"])).">".'åŒ¯å…¥'."</a>";}if(support("dump"))$va[]="<a href='".h(ME)."dump=".urlencode(isset($_GET["table"])?$_GET["table"]:$_GET["select"])."' id='dump'".bold(isset($_GET["dump"])).">".'åŒ¯å‡º'."</a>";}$Od=$_GET["ns"]!==""&&!$Te&&DB!="";if($Od)$va[]='<a href="'.h(ME).'create="'.bold($_GET["create"]==="").">".'å»ºç«‹è³‡æ–™è¡¨'."</a>";echo($va?"<p class='links'>\n".implode("\n",$va)."\n":"");if($Od){if($R)$this->tablesPrint($R);else
echo"<p class='message'>".'æ²’æœ‰è³‡æ–™è¡¨ã€‚'."</p>\n";}}}function
databasesPrint($Te){global$b,$f;$i=$this->databases();if(DB&&$i&&!in_array(DB,$i))array_unshift($i,DB);echo'<form action="">
<p id="dbs">
';hidden_fields_get();$Wb=script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");echo"<span title='".'è³‡æ–™åº«'."'>".'è³‡æ–™åº«'."</span>: ".($i?"<select name='db'>".optionlist(array(""=>"")+$i,DB)."</select>$Wb":"<input name='db' value='".h(DB)."' autocapitalize='off' size='19'>\n"),"<input type='submit' value='".'ä½¿ç”¨'."'".($i?" class='hidden'":"").">\n";if(support("scheme")){if($Te!="db"&&DB!=""&&$f->select_db(DB)){echo"<br>".'è³‡æ–™è¡¨çµæ§‹'.": <select name='ns'>".optionlist(array(""=>"")+$b->schemas(),$_GET["ns"])."</select>$Wb";if($_GET["ns"]!="")set_schema($_GET["ns"]);}}foreach(array("import","sql","schema","dump","privileges")as$X){if(isset($_GET[$X])){echo"<input type='hidden' name='$X' value=''>";break;}}echo"</p></form>\n";}function
tablesPrint($R){echo"<ul id='tables'>".script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");foreach($R
as$P=>$N){$B=$this->tableName($N);if($B!=""){echo'<li><a href="'.h(ME).'select='.urlencode($P).'"'.bold($_GET["select"]==$P||$_GET["edit"]==$P,"select")." title='".'é¸æ“‡è³‡æ–™'."'>".'é¸æ“‡'."</a> ",(support("table")||support("indexes")?'<a href="'.h(ME).'table='.urlencode($P).'"'.bold(in_array($P,array($_GET["table"],$_GET["create"],$_GET["indexes"],$_GET["foreign"],$_GET["trigger"])),(is_view($N)?"view":"structure"))." title='".'é¡¯ç¤ºçµæ§‹'."'>$B</a>":"<span>$B</span>")."\n";}}echo"</ul>\n";}}$b=(function_exists('adminer_object')?adminer_object():new
Adminer);$nc=array("server"=>"MySQL")+$nc;if(!defined("DRIVER")){define("DRIVER","server");if(extension_loaded("mysqli")){class
Min_DB
extends
MySQLi{var$extension="MySQLi";function
__construct(){parent::init();}function
connect($L="",$V="",$E="",$Ub=null,$cg=null,$sh=null){global$b;mysqli_report(MYSQLI_REPORT_OFF);list($Hd,$cg)=explode(":",$L,2);$Bh=$b->connectSsl();if($Bh)$this->ssl_set($Bh['key'],$Bh['cert'],$Bh['ca'],'','');$H=@$this->real_connect(($L!=""?$Hd:ini_get("mysqli.default_host")),($L.$V!=""?$V:ini_get("mysqli.default_user")),($L.$V.$E!=""?$E:ini_get("mysqli.default_pw")),$Ub,(is_numeric($cg)?$cg:ini_get("mysqli.default_port")),(!is_numeric($cg)?$cg:$sh),($Bh?(empty($Bh['cert'])?2048:64):0));$this->options(MYSQLI_OPT_LOCAL_INFILE,false);return$H;}function
set_charset($bb){if(parent::set_charset($bb))return
true;parent::set_charset('utf8');return$this->query("SET NAMES $bb");}function
result($F,$m=0){$G=$this->query($F);if(!$G)return
false;$I=$G->fetch_array();return$I[$m];}function
quote($O){return"'".$this->escape_string($O)."'";}}}elseif(extension_loaded("mysql")&&!((ini_bool("sql.safe_mode")||ini_bool("mysql.allow_local_infile"))&&extension_loaded("pdo_mysql"))){class
Min_DB{var$extension="MySQL",$server_info,$affected_rows,$errno,$error,$_link,$_result;function
connect($L,$V,$E){if(ini_bool("mysql.allow_local_infile")){$this->error=sprintf('ç¦ç”¨ %s æˆ–å•Ÿç”¨ %s æˆ– %s æ“´å……æ¨¡çµ„ã€‚',"'mysql.allow_local_infile'","MySQLi","PDO_MySQL");return
false;}$this->_link=@mysql_connect(($L!=""?$L:ini_get("mysql.default_host")),("$L$V"!=""?$V:ini_get("mysql.default_user")),("$L$V$E"!=""?$E:ini_get("mysql.default_password")),true,131072);if($this->_link)$this->server_info=mysql_get_server_info($this->_link);else$this->error=mysql_error();return(bool)$this->_link;}function
set_charset($bb){if(function_exists('mysql_set_charset')){if(mysql_set_charset($bb,$this->_link))return
true;mysql_set_charset('utf8',$this->_link);}return$this->query("SET NAMES $bb");}function
quote($O){return"'".mysql_real_escape_string($O,$this->_link)."'";}function
select_db($Ub){return
mysql_select_db($Ub,$this->_link);}function
query($F,$_i=false){$G=@($_i?mysql_unbuffered_query($F,$this->_link):mysql_query($F,$this->_link));$this->error="";if(!$G){$this->errno=mysql_errno($this->_link);$this->error=mysql_error($this->_link);return
false;}if($G===true){$this->affected_rows=mysql_affected_rows($this->_link);$this->info=mysql_info($this->_link);return
true;}return
new
Min_Result($G);}function
multi_query($F){return$this->_result=$this->query($F);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($F,$m=0){$G=$this->query($F);if(!$G||!$G->num_rows)return
false;return
mysql_result($G->_result,0,$m);}}class
Min_Result{var$num_rows,$_result,$_offset=0;function
__construct($G){$this->_result=$G;$this->num_rows=mysql_num_rows($G);}function
fetch_assoc(){return
mysql_fetch_assoc($this->_result);}function
fetch_row(){return
mysql_fetch_row($this->_result);}function
fetch_field(){$H=mysql_fetch_field($this->_result,$this->_offset++);$H->orgtable=$H->table;$H->orgname=$H->name;$H->charsetnr=($H->blob?63:0);return$H;}function
__destruct(){mysql_free_result($this->_result);}}}elseif(extension_loaded("pdo_mysql")){class
Min_DB
extends
Min_PDO{var$extension="PDO_MySQL";function
connect($L,$V,$E){global$b;$C=array(PDO::MYSQL_ATTR_LOCAL_INFILE=>false);$Bh=$b->connectSsl();if($Bh){if(!empty($Bh['key']))$C[PDO::MYSQL_ATTR_SSL_KEY]=$Bh['key'];if(!empty($Bh['cert']))$C[PDO::MYSQL_ATTR_SSL_CERT]=$Bh['cert'];if(!empty($Bh['ca']))$C[PDO::MYSQL_ATTR_SSL_CA]=$Bh['ca'];if(!empty($Bh['verify']))$C[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT]=$Bh['verify'];}$this->dsn("mysql:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\d)~',';port=\1',$L)),$V,$E,$C);return
true;}function
set_charset($bb){$this->query("SET NAMES $bb");}function
select_db($Ub){return$this->query("USE ".idf_escape($Ub));}function
query($F,$_i=false){$this->pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,!$_i);return
parent::query($F,$_i);}}}class
Min_Driver
extends
Min_SQL{function
insert($P,$M){return($M?parent::insert($P,$M):queries("INSERT INTO ".table($P)." ()\nVALUES ()"));}function
insertUpdate($P,$J,$jg){$e=array_keys(reset($J));$hg="INSERT INTO ".table($P)." (".implode(", ",$e).") VALUES\n";$Si=array();foreach($e
as$x)$Si[$x]="$x = VALUES($x)";$Ih="\nON DUPLICATE KEY UPDATE ".implode(", ",$Si);$Si=array();$ve=0;foreach($J
as$M){$Y="(".implode(", ",$M).")";if($Si&&(strlen($hg)+$ve+strlen($Y)+strlen($Ih)>1e6)){if(!queries($hg.implode(",\n",$Si).$Ih))return
false;$Si=array();$ve=0;}$Si[]=$Y;$ve+=strlen($Y)+2;}return
queries($hg.implode(",\n",$Si).$Ih);}function
slowQuery($F,$di){if(min_version('5.7.8','10.1.2')){if(preg_match('~MariaDB~',$this->_conn->server_info))return"SET STATEMENT max_statement_time=$di FOR $F";elseif(preg_match('~^(SELECT\b)(.+)~is',$F,$A))return"$A[1] /*+ MAX_EXECUTION_TIME(".($di*1000).") */ $A[2]";}}function
convertSearch($t,$X,$m){return(preg_match('~char|text|enum|set~',$m["type"])&&!preg_match("~^utf8~",$m["collation"])&&preg_match('~[\x80-\xFF]~',$X['val'])?"CONVERT($t USING ".charset($this->_conn).")":$t);}function
warnings(){$G=$this->_conn->query("SHOW WARNINGS");if($G&&$G->num_rows){ob_start();select($G);return
ob_get_clean();}}function
tableHelp($B){$Ae=preg_match('~MariaDB~',$this->_conn->server_info);if(information_schema(DB))return
strtolower("information-schema-".($Ae?"$B-table/":str_replace("_","-",$B)."-table.html"));if(DB=="mysql")return($Ae?"mysql$B-table/":"system-schema.html");}function
hasCStyleEscapes(){static$Xa;if($Xa===null){$_h=$this->_conn->result("SHOW VARIABLES LIKE 'sql_mode'",1);$Xa=(strpos($_h,'NO_BACKSLASH_ESCAPES')===false);}return$Xa;}}function
idf_escape($t){return"`".str_replace("`","``",$t)."`";}function
table($t){return
idf_escape($t);}function
connect(){global$b,$U,$Fh,$vc;$f=new
Min_DB;$Nb=$b->credentials();if($f->connect($Nb[0],$Nb[1],$Nb[2])){$f->set_charset(charset($f));$f->query("SET sql_quote_show_create = 1, autocommit = 1");if(min_version('5.7.8',10.2,$f)){$Fh['å­—ä¸²'][]="json";$U["json"]=4294967295;}if(min_version('',10.7,$f)){$Fh['å­—ä¸²'][]="uuid";$U["uuid"]=128;$vc[0]['uuid']='uuid';}if(min_version(9,'',$f)){$Fh['æ•¸å­—'][]="vector";$U["vector"]=16383;$vc[0]['vector']='string_to_vector';}return$f;}$H=$f->error;if(function_exists('iconv')&&!is_utf8($H)&&strlen($Ug=iconv("windows-1250","utf-8",$H))>strlen($H))$H=$Ug;return$H;}function
get_databases($id){$H=get_session("dbs");if($H===null){$F=(min_version(5)?"SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME":"SHOW DATABASES");$H=($id?slow_query($F):get_vals($F));restart_session();set_session("dbs",$H);stop_session();}return$H;}function
limit($F,$Z,$y,$jf=0,$eh=" "){return" $F$Z".($y!==null?$eh."LIMIT $y".($jf?" OFFSET $jf":""):"");}function
limit1($P,$F,$Z,$eh="\n"){return
limit($F,$Z,1,0,$eh);}function
db_collation($j,$pb){global$f;$H=null;$h=$f->result("SHOW CREATE DATABASE ".idf_escape($j),1);if(preg_match('~ COLLATE ([^ ]+)~',$h,$A))$H=$A[1];elseif(preg_match('~ CHARACTER SET ([^ ]+)~',$h,$A))$H=$pb[$A[1]][-1];return$H;}function
engines(){$H=array();foreach(get_rows("SHOW ENGINES")as$I){if(preg_match("~YES|DEFAULT~",$I["Support"]))$H[]=$I["Engine"];}return$H;}function
logged_user(){global$f;return$f->result("SELECT USER()");}function
tables_list(){return
get_key_vals(min_version(5)?"SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME":"SHOW TABLES");}function
count_tables($i){$H=array();foreach($i
as$j)$H[$j]=count(get_vals("SHOW TABLES IN ".idf_escape($j)));return$H;}function
table_status($B="",$Xc=false){$H=array();foreach(get_rows($Xc&&min_version(5)?"SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ".($B!=""?"AND TABLE_NAME = ".q($B):"ORDER BY Name"):"SHOW TABLE STATUS".($B!=""?" LIKE ".q(addcslashes($B,"%_\\")):""))as$I){if($I["Engine"]=="InnoDB")$I["Comment"]=preg_replace('~(?:(.+); )?InnoDB free: .*~','\1',$I["Comment"]);if(!isset($I["Engine"]))$I["Comment"]="";if($B!=""){$I["Name"]=$B;return$I;}$H[$I["Name"]]=$I;}return$H;}function
is_view($Q){return$Q["Engine"]===null;}function
fk_support($Q){return
preg_match('~InnoDB|IBMDB2I~i',$Q["Engine"])||(preg_match('~NDB~i',$Q["Engine"])&&min_version(5.6));}function
fields($P){$H=array();foreach(get_rows("SHOW FULL COLUMNS FROM ".table($P))as$I){preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~',$I["Type"],$A);$H[$I["Field"]]=array("field"=>$I["Field"],"full_type"=>$I["Type"],"type"=>$A[1],"length"=>$A[2],"unsigned"=>ltrim($A[3].$A[4]),"default"=>($I["Default"]!=""||preg_match("~char|set~",$A[1])?(preg_match('~text~',$A[1])?stripslashes(preg_replace("~^'(.*)'\$~",'\1',$I["Default"])):$I["Default"]):null),"null"=>($I["Null"]=="YES"),"auto_increment"=>($I["Extra"]=="auto_increment"),"on_update"=>(preg_match('~^on update (.+)~i',$I["Extra"],$A)?$A[1]:""),"collation"=>$I["Collation"],"privileges"=>array_flip(preg_split('~, *~',$I["Privileges"])),"comment"=>$I["Comment"],"primary"=>($I["Key"]=="PRI"),"generated"=>preg_match('~^(VIRTUAL|PERSISTENT|STORED)~',$I["Extra"]),);}return$H;}function
indexes($P,$g=null){$H=array();foreach(get_rows("SHOW INDEX FROM ".table($P),$g)as$I){$B=$I["Key_name"];$H[$B]["type"]=($B=="PRIMARY"?"PRIMARY":($I["Index_type"]=="FULLTEXT"?"FULLTEXT":($I["Non_unique"]?($I["Index_type"]=="SPATIAL"?"SPATIAL":"INDEX"):"UNIQUE")));$H[$B]["columns"][]=$I["Column_name"];$H[$B]["lengths"][]=($I["Index_type"]=="SPATIAL"?null:$I["Sub_part"]);$H[$B]["descs"][]=null;}return$H;}function
foreign_keys($P){global$f,$rf;static$Yf='(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';$H=array();$Lb=$f->result("SHOW CREATE TABLE ".table($P),1);if($Lb){preg_match_all("~CONSTRAINT ($Yf) FOREIGN KEY ?\\(((?:$Yf,? ?)+)\\) REFERENCES ($Yf)(?:\\.($Yf))? \\(((?:$Yf,? ?)+)\\)(?: ON DELETE ($rf))?(?: ON UPDATE ($rf))?~",$Lb,$De,PREG_SET_ORDER);foreach($De
as$A){preg_match_all("~$Yf~",$A[2],$uh);preg_match_all("~$Yf~",$A[5],$Vh);$H[idf_unescape($A[1])]=array("db"=>idf_unescape($A[4]!=""?$A[3]:$A[4]),"table"=>idf_unescape($A[4]!=""?$A[4]:$A[3]),"source"=>array_map('idf_unescape',$uh[0]),"target"=>array_map('idf_unescape',$Vh[0]),"on_delete"=>($A[6]?$A[6]:"RESTRICT"),"on_update"=>($A[7]?$A[7]:"RESTRICT"),);}}return$H;}function
adm_view($B){global$f;return
array("select"=>preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU','',$f->result("SHOW CREATE VIEW ".table($B),1)));}function
collations(){$H=array();foreach(get_rows("SHOW COLLATION")as$I){if($I["Default"])$H[$I["Charset"]][-1]=$I["Collation"];else$H[$I["Charset"]][]=$I["Collation"];}ksort($H);foreach($H
as$x=>$X)asort($H[$x]);return$H;}function
information_schema($j){return(min_version(5)&&$j=="information_schema")||(min_version(5.5)&&$j=="performance_schema");}function
error(){global$f;return
h(preg_replace('~^You have an error.*syntax to use~U',"Syntax error",$f->error));}function
create_database($j,$ob){return
queries("CREATE DATABASE ".idf_escape($j).($ob?" COLLATE ".q($ob):""));}function
drop_databases($i){$H=apply_queries("DROP DATABASE",$i,'idf_escape');restart_session();set_session("dbs",null);return$H;}function
rename_database($B,$ob){$H=false;if(create_database($B,$ob)){$R=array();$Xi=array();foreach(tables_list()as$P=>$T){if($T=='VIEW')$Xi[]=$P;else$R[]=$P;}$H=(!$R&&!$Xi)||move_tables($R,$Xi,$B);drop_databases($H?array(DB):array());}return$H;}function
auto_increment(){$La=" PRIMARY KEY";if($_GET["create"]!=""&&$_POST["auto_increment_col"]){foreach(indexes($_GET["create"])as$u){if(in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"],$u["columns"],true)){$La="";break;}if($u["type"]=="PRIMARY")$La=" UNIQUE";}}return" AUTO_INCREMENT$La";}function
alter_table($P,$B,$n,$kd,$vb,$Cc,$ob,$Ka,$Uf){$c=array();foreach($n
as$m)$c[]=($m[1]?($P!=""?($m[0]!=""?"CHANGE ".idf_escape($m[0]):"ADD"):" ")." ".implode($m[1]).($P!=""?$m[2]:""):"DROP ".idf_escape($m[0]));$c=array_merge($c,$kd);$N=($vb!==null?" COMMENT=".q($vb):"").($Cc?" ENGINE=".q($Cc):"").($ob?" COLLATE ".q($ob):"").($Ka!=""?" AUTO_INCREMENT=$Ka":"");if($P=="")return
queries("CREATE TABLE ".table($B)." (\n".implode(",\n",$c)."\n)$N$Uf");if($P!=$B)$c[]="RENAME TO ".table($B);if($N)$c[]=ltrim($N);return($c||$Uf?queries("ALTER TABLE ".table($P)."\n".implode(",\n",$c).$Uf):true);}function
alter_indexes($P,$c){foreach($c
as$x=>$X)$c[$x]=($X[2]=="DROP"?"\nDROP INDEX ".idf_escape($X[1]):"\nADD $X[0] ".($X[0]=="PRIMARY"?"KEY ":"").($X[1]!=""?idf_escape($X[1])." ":"")."(".implode(", ",$X[2]).")");return
queries("ALTER TABLE ".table($P).implode(",",$c));}function
truncate_tables($R){return
apply_queries("TRUNCATE TABLE",$R);}function
drop_views($Xi){return
queries("DROP VIEW ".implode(", ",array_map('table',$Xi)));}function
drop_tables($R){return
queries("DROP TABLE ".implode(", ",array_map('table',$R)));}function
move_tables($R,$Xi,$Vh){global$f;$Gg=array();foreach($R
as$P)$Gg[]=table($P)." TO ".idf_escape($Vh).".".table($P);if(!$Gg||queries("RENAME TABLE ".implode(", ",$Gg))){$dc=array();foreach($Xi
as$P)$dc[table($P)]=adm_view($P);$f->select_db($Vh);$j=idf_escape(DB);foreach($dc
as$B=>$Wi){if(!queries("CREATE VIEW $B AS ".str_replace(" $j."," ",$Wi["select"]))||!queries("DROP VIEW $j.$B"))return
false;}return
true;}return
false;}function
copy_tables($R,$Xi,$Vh){queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");foreach($R
as$P){$B=($Vh==DB?table("copy_$P"):idf_escape($Vh).".".table($P));if(($_POST["overwrite"]&&!queries("\nDROP TABLE IF EXISTS $B"))||!queries("CREATE TABLE $B LIKE ".table($P))||!queries("INSERT INTO $B SELECT * FROM ".table($P)))return
false;foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($P,"%_\\")))as$I){$ui=$I["Trigger"];if(!queries("CREATE TRIGGER ".($Vh==DB?idf_escape("copy_$ui"):idf_escape($Vh).".".idf_escape($ui))." $I[Timing] $I[Event] ON $B FOR EACH ROW\n$I[Statement];"))return
false;}}foreach($Xi
as$P){$B=($Vh==DB?table("copy_$P"):idf_escape($Vh).".".table($P));$Wi=adm_view($P);if(($_POST["overwrite"]&&!queries("DROP VIEW IF EXISTS $B"))||!queries("CREATE VIEW $B AS $Wi[select]"))return
false;}return
true;}function
trigger($B){if($B=="")return
array();$J=get_rows("SHOW TRIGGERS WHERE `Trigger` = ".q($B));return
reset($J);}function
triggers($P){$H=array();foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($P,"%_\\")))as$I)$H[$I["Trigger"]]=array($I["Timing"],$I["Event"]);return$H;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
routine($B,$T){global$f,$Ec,$Vd,$U;$Ba=array("bool","boolean","integer","double precision","real","dec","numeric","fixed","national char","national varchar");$vh="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$zi="((".implode("|",array_merge(array_keys($U),$Ba)).")\\b(?:\\s*\\(((?:[^'\")]|$Ec)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";$Yf="$vh*(".($T=="FUNCTION"?"":$Vd).")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$zi";$h=$f->result("SHOW CREATE $T ".idf_escape($B),2);preg_match("~\\(((?:$Yf\\s*,?)*)\\)\\s*".($T=="FUNCTION"?"RETURNS\\s+$zi\\s+":"")."(.*)~is",$h,$A);$n=array();preg_match_all("~$Yf\\s*,?~is",$A[1],$De,PREG_SET_ORDER);foreach($De
as$Of)$n[]=array("field"=>str_replace("``","`",$Of[2]).$Of[3],"type"=>strtolower($Of[5]),"length"=>preg_replace_callback("~$Ec~s",'normalize_enum',$Of[6]),"unsigned"=>strtolower(preg_replace('~\s+~',' ',trim("$Of[8] $Of[7]"))),"null"=>1,"full_type"=>$Of[4],"inout"=>strtoupper($Of[1]),"collation"=>strtolower($Of[9]),);return
array("fields"=>$n,"comment"=>$f->result("SELECT ROUTINE_COMMENT FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = ".q(DB)." AND ROUTINE_NAME = ".q($B)),)+($T!="FUNCTION"?array("definition"=>$A[11]):array("returns"=>array("type"=>$A[12],"length"=>$A[13],"unsigned"=>$A[15],"collation"=>$A[16]),"definition"=>$A[17],"language"=>"SQL",));}function
routines(){return
get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = ".q(DB));}function
routine_languages(){return
array();}function
routine_id($B,$I){return
idf_escape($B);}function
last_id(){global$f;return$f->result("SELECT LAST_INSERT_ID()");}function
explain($f,$F){return$f->query("EXPLAIN ".(min_version(5.1)&&!min_version(5.7)?"PARTITIONS ":"").$F);}function
found_rows($Q,$Z){return($Z||$Q["Engine"]!="InnoDB"?null:$Q["Rows"]);}function
types(){return
array();}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($Wg,$g=null){return
true;}function
create_sql($P,$Ka,$Gh){global$f;$H=$f->result("SHOW CREATE TABLE ".table($P),1);if(!$Ka)$H=preg_replace('~ AUTO_INCREMENT=\d+~','',$H);return$H;}function
truncate_sql($P){return"TRUNCATE ".table($P);}function
use_sql($Ub){return"USE ".idf_escape($Ub);}function
trigger_sql($P){$H="";foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($P,"%_\\")),null,"-- ")as$I)$H.="\nCREATE TRIGGER ".idf_escape($I["Trigger"])." $I[Timing] $I[Event] ON ".table($I["Table"])." FOR EACH ROW\n$I[Statement];;\n";return$H;}function
show_variables(){return
get_key_vals("SHOW VARIABLES");}function
process_list(){return
get_rows("SHOW FULL PROCESSLIST");}function
show_status(){return
get_key_vals("SHOW STATUS");}function
convert_field($m){if(preg_match("~binary~",$m["type"]))return"HEX(".idf_escape($m["field"]).")";if($m["type"]=="bit")return"BIN(".idf_escape($m["field"])." + 0)";if(preg_match("~geometry|point|linestring|polygon~",$m["type"]))return(min_version(8)?"ST_":"")."AsWKT(".idf_escape($m["field"]).")";}function
unconvert_field($m,$H){if(preg_match("~binary~",$m["type"]))$H="UNHEX($H)";if($m["type"]=="bit")$H="CONVERT(b$H, UNSIGNED)";if(preg_match("~geometry|point|linestring|polygon~",$m["type"])){$hg=(min_version(8)?"ST_":"");$H=$hg."GeomFromText($H, $hg"."SRID($m[field]))";}return$H;}function
support($Yc){return!preg_match("~scheme|sequence|type|view_trigger|materializedview".(min_version(8)?"":"|descidx".(min_version(5.1)?"":"|event|partitioning".(min_version(5)?"":"|routine|trigger|view"))).(min_version('8.0.16','10.2.1')?"":"|check")."~",$Yc);}function
kill_process($X){return
queries("KILL ".number($X));}function
connection_id(){return"SELECT CONNECTION_ID()";}function
max_connections(){global$f;return$f->result("SELECT @@max_connections");}function
driver_config(){$U=array();$Fh=array();foreach(array('æ•¸å­—'=>array("tinyint"=>3,"smallint"=>5,"mediumint"=>8,"int"=>10,"bigint"=>20,"decimal"=>66,"float"=>12,"double"=>21),'æ—¥æœŸæ™‚é–“'=>array("date"=>10,"datetime"=>19,"timestamp"=>19,"time"=>10,"year"=>4),'å­—ä¸²'=>array("char"=>255,"varchar"=>65535,"tinytext"=>255,"text"=>65535,"mediumtext"=>16777215,"longtext"=>4294967295),'åˆ—è¡¨'=>array("enum"=>65535,"set"=>64),'äºŒé€²ä½'=>array("bit"=>20,"binary"=>255,"varbinary"=>65535,"tinyblob"=>255,"blob"=>65535,"mediumblob"=>16777215,"longblob"=>4294967295),'å¹¾ä½•'=>array("geometry"=>0,"point"=>0,"linestring"=>0,"polygon"=>0,"multipoint"=>0,"multilinestring"=>0,"multipolygon"=>0,"geometrycollection"=>0),)as$x=>$X){$U+=$X;$Fh[$x]=array_keys($X);}return
array('possible_drivers'=>array("MySQLi","MySQL","PDO_MySQL"),'jush'=>"sql",'types'=>$U,'structured_types'=>$Fh,'unsigned'=>array("unsigned","zerofill","unsigned zerofill"),'operators'=>array("=","<",">","<=",">=","!=","LIKE","LIKE %%","REGEXP","IN","FIND_IN_SET","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL"),'functions'=>array("char_length","date","from_unixtime","lower","round","floor","ceil","sec_to_time","time_to_sec","upper"),'grouping'=>array("avg","count","count distinct","group_concat","max","min","sum"),'edit_functions'=>array(array("char"=>"md5/sha1/password/encrypt/uuid","binary"=>"md5/sha1","date|time"=>"now",),array(number_type()=>"+/-","date"=>"+ interval/- interval","time"=>"addtime/subtime","char|text"=>"concat",)),);}}$zb=driver_config();$gg=$zb['possible_drivers'];$w=$zb['jush'];$U=$zb['types'];$Fh=$zb['structured_types'];$Gi=$zb['unsigned'];$wf=$zb['operators'];$rd=$zb['functions'];$yd=$zb['grouping'];$vc=$zb['edit_functions'];if($b->operators===null)$b->operators=$wf;define("SERVER",$_GET[DRIVER]);define("DB",$_GET["db"]);define("ME",preg_replace('~\?.*~','',relative_uri()).'?'.(sid()?SID.'&':'').(SERVER!==null?DRIVER."=".urlencode(SERVER).'&':'').(isset($_GET["username"])?"username=".urlencode($_GET["username"]).'&':'').(DB!=""?'db='.urlencode(DB).'&'.(isset($_GET["ns"])?"ns=".urlencode($_GET["ns"])."&":""):''));function
page_header($fi,$l="",$Ua=array(),$gi=""){global$ca,$ia,$b,$nc,$w;page_headers();if(is_ajax()&&$l){page_messages($l);exit;}$hi=$fi.($gi!=""?": $gi":"");$ii=strip_tags($hi.(SERVER!=""&&SERVER!="localhost"?h(" - ".SERVER):"")." - ".$b->name());echo'<!DOCTYPE html>
<html lang="zh-tw" dir="ltr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width">
<title>',$ii,'</title>
<link rel="stylesheet" type="text/css" href="',h(preg_replace("~\\?.*~","",ME)."?file=default.css&version=4.17.1"),'">
',script_src(preg_replace("~\\?.*~","",ME)."?file=functions.js&version=4.17.1");if($b->head()){echo'<link rel="shortcut icon" type="image/x-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=4.17.1"),'">
<link rel="apple-touch-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=4.17.1"),'">
';foreach($b->css()as$Pb){echo'<link rel="stylesheet" type="text/css" href="',h($Pb),'">
';}}echo'
<body class="ltr nojs">
';$o=get_temp_dir()."/adminer.version";if(!$_COOKIE["adminer_version"]&&function_exists('openssl_verify')&&file_exists($o)&&filemtime($o)+86400>time()){$Vi=unserialize(file_get_contents($o));$rg="-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";if(openssl_verify($Vi["version"],base64_decode($Vi["signature"]),$rg)==1)$_COOKIE["adminer_version"]=$Vi["version"];}echo'<script',nonce(),'>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick',(isset($_COOKIE["adminer_version"])?"":", onload: partial(verifyVersion, '$ia', '".js_escape(ME)."', '".get_token()."')");?>});
document.body.className = document.body.className.replace(/ nojs/, ' js');
var offlineMessage = '<?php echo
js_escape('æ‚¨é›¢ç·šäº†ã€‚'),'\';
var thousandsSeparator = \'',js_escape(','),'\';
</script>

<div id="help" class="jush-',$w,' jsonly hidden"></div>
',script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"),'
<div id="content">
';if($Ua!==null){$z=substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1);echo'<p id="breadcrumb"><a href="'.h($z?$z:".").'">'.$nc[DRIVER].'</a> Â» ';$z=substr(preg_replace('~\b(db|ns)=[^&]*&~','',ME),0,-1);$L=$b->serverName(SERVER);$L=($L!=""?$L:'ä¼ºæœå™¨');if($Ua===false)echo"$L\n";else{echo"<a href='".h($z)."' accesskey='1' title='Alt+Shift+1'>$L</a> Â» ";if($_GET["ns"]!=""||(DB!=""&&is_array($Ua)))echo'<a href="'.h($z."&db=".urlencode(DB).(support("scheme")?"&ns=":"")).'">'.h(DB).'</a> Â» ';if(is_array($Ua)){if($_GET["ns"]!="")echo'<a href="'.h(substr(ME,0,-1)).'">'.h($_GET["ns"]).'</a> Â» ';foreach($Ua
as$x=>$X){$fc=(is_array($X)?$X[1]:h($X));if($fc!="")echo"<a href='".h(ME."$x=").urlencode(is_array($X)?$X[0]:$X)."'>$fc</a> Â» ";}}echo"$fi\n";}}echo"<h2>$hi</h2>\n","<div id='ajaxstatus' class='jsonly hidden'></div>\n";restart_session();page_messages($l);$i=&get_session("dbs");if(DB!=""&&$i&&!in_array(DB,$i,true))$i=null;stop_session();define("PAGE_HEADER",1);}function
page_headers(){global$b;header("Content-Type: text/html; charset=utf-8");header("Cache-Control: no-cache");header("X-Frame-Options: deny");header("X-XSS-Protection: 0");header("X-Content-Type-Options: nosniff");header("Referrer-Policy: origin-when-cross-origin");foreach($b->csp()as$Ob){$Dd=array();foreach($Ob
as$x=>$X)$Dd[]="$x $X";header("Content-Security-Policy: ".implode("; ",$Dd));}$b->headers();}function
csp(){return
array(array("script-src"=>"'self' 'unsafe-inline' 'nonce-".get_nonce()."' 'strict-dynamic'","connect-src"=>"'self'","frame-src"=>"https://www.adminer.org","object-src"=>"'none'","base-uri"=>"'none'","form-action"=>"'self'",),);}function
get_nonce(){static$df;if(!$df)$df=base64_encode(rand_string());return$df;}function
page_messages($l){$Ii=preg_replace('~^[^?]*~','',$_SERVER["REQUEST_URI"]);$Qe=$_SESSION["messages"][$Ii];if($Qe){echo"<div class='message'>".implode("</div>\n<div class='message'>",$Qe)."</div>".script("messagesPrint();");unset($_SESSION["messages"][$Ii]);}if($l)echo"<div class='error'>$l</div>\n";}function
page_footer($Te=""){global$b,$S;echo'</div>

<div id="menu">
';$b->navigation($Te);echo'</div>

';if($Te!="auth"){echo'<form action="" method="post">
<p class="logout">
',h($_GET["username"])."\n",'<input type="submit" name="logout" value="ç™»å‡º" id="logout">
<input type="hidden" name="token" value="',$S,'">
</p>
</form>
';}echo
script("setupSubmitHighlight(document);");}function
int32($We){while($We>=2147483648)$We-=4294967296;while($We<=-2147483649)$We+=4294967296;return(int)$We;}function
long2str($W,$Zi){$Ug='';foreach($W
as$X)$Ug.=pack('V',$X);if($Zi)return
substr($Ug,0,end($W));return$Ug;}function
str2long($Ug,$Zi){$W=array_values(unpack('V*',str_pad($Ug,4*ceil(strlen($Ug)/4),"\0")));if($Zi)$W[]=strlen($Ug);return$W;}function
xxtea_mx($lj,$kj,$Jh,$he){return
int32((($lj>>5&0x7FFFFFF)^$kj<<2)+(($kj>>3&0x1FFFFFFF)^$lj<<4))^int32(($Jh^$kj)+($he^$lj));}function
encrypt_string($Eh,$x){if($Eh=="")return"";$x=array_values(unpack("V*",pack("H*",md5($x))));$W=str2long($Eh,true);$We=count($W)-1;$lj=$W[$We];$kj=$W[0];$sg=floor(6+52/($We+1));$Jh=0;while($sg-->0){$Jh=int32($Jh+0x9E3779B9);$uc=$Jh>>2&3;for($Mf=0;$Mf<$We;$Mf++){$kj=$W[$Mf+1];$Ve=xxtea_mx($lj,$kj,$Jh,$x[$Mf&3^$uc]);$lj=int32($W[$Mf]+$Ve);$W[$Mf]=$lj;}$kj=$W[0];$Ve=xxtea_mx($lj,$kj,$Jh,$x[$Mf&3^$uc]);$lj=int32($W[$We]+$Ve);$W[$We]=$lj;}return
long2str($W,false);}function
decrypt_string($Eh,$x){if($Eh=="")return"";if(!$x)return
false;$x=array_values(unpack("V*",pack("H*",md5($x))));$W=str2long($Eh,false);$We=count($W)-1;$lj=$W[$We];$kj=$W[0];$sg=floor(6+52/($We+1));$Jh=int32($sg*0x9E3779B9);while($Jh){$uc=$Jh>>2&3;for($Mf=$We;$Mf>0;$Mf--){$lj=$W[$Mf-1];$Ve=xxtea_mx($lj,$kj,$Jh,$x[$Mf&3^$uc]);$kj=int32($W[$Mf]-$Ve);$W[$Mf]=$kj;}$lj=$W[$We];$Ve=xxtea_mx($lj,$kj,$Jh,$x[$Mf&3^$uc]);$kj=int32($W[0]-$Ve);$W[0]=$kj;$Jh=int32($Jh-0x9E3779B9);}return
long2str($W,true);}$f='';$Cd=$_SESSION["token"];if(!$Cd)$_SESSION["token"]=rand(1,1e6);$S=get_token();$ag=array();if($_COOKIE["adminer_permanent"]){foreach(explode(" ",$_COOKIE["adminer_permanent"])as$X){list($x)=explode(":",$X);$ag[$x]=$X;}}function
add_invalid_login(){global$b;$q=file_open_lock(get_temp_dir()."/adminer.invalid");if(!$q)return;$ae=unserialize(stream_get_contents($q));$ci=time();if($ae){foreach($ae
as$be=>$X){if($X[0]<$ci)unset($ae[$be]);}}$Zd=&$ae[$b->bruteForceKey()];if(!$Zd)$Zd=array($ci+30*60,0);$Zd[1]++;file_write_unlock($q,serialize($ae));}function
check_invalid_login(){global$b;$ae=unserialize(@file_get_contents(get_temp_dir()."/adminer.invalid"));$Zd=($ae?$ae[$b->bruteForceKey()]:array());$cf=($Zd[1]>29?$Zd[0]-time():0);if($cf>0)auth_error(sprintf('ç™»éŒ„å¤±æ•—æ¬¡æ•¸éå¤šï¼Œè«‹ %d åˆ†é˜å¾Œé‡è©¦ã€‚',ceil($cf/60)));}$Ia=$_POST["auth"];if($Ia){session_regenerate_id();$Ui=$Ia["driver"];$L=$Ia["server"];$V=$Ia["username"];$E=(string)$Ia["password"];$j=$Ia["db"];set_password($Ui,$L,$V,$E);$_SESSION["db"][$Ui][$L][$V][$j]=true;if($Ia["permanent"]){$x=base64_encode($Ui)."-".base64_encode($L)."-".base64_encode($V)."-".base64_encode($j);$mg=$b->permanentLogin(true);$ag[$x]="$x:".base64_encode($mg?encrypt_string($E,$mg):"");adm_cookie("adminer_permanent",implode(" ",$ag));}if(count($_POST)==1||DRIVER!=$Ui||SERVER!=$L||$_GET["username"]!==$V||DB!=$j)adm_redirect(auth_url($Ui,$L,$V,$j));}elseif($_POST["logout"]&&(!$Cd||verify_token())){foreach(array("pwds","db","dbs","queries")as$x)set_session($x,null);unset_permanent();adm_redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1),'æˆåŠŸç™»å‡ºã€‚'.' '.'æ„Ÿè¬ä½¿ç”¨Adminerï¼Œè«‹è€ƒæ…®ç‚ºæˆ‘å€‘<a href="https://www.adminer.org/en/donation/">ææ¬¾ï¼ˆè‹±æ–‡ç¶²é ï¼‰</a>.');}elseif($ag&&!$_SESSION["pwds"]){session_regenerate_id();$mg=$b->permanentLogin();foreach($ag
as$x=>$X){list(,$ib)=explode(":",$X);list($Ui,$L,$V,$j)=array_map('base64_decode',explode("-",$x));set_password($Ui,$L,$V,decrypt_string(base64_decode($ib),$mg));$_SESSION["db"][$Ui][$L][$V][$j]=true;}}function
unset_permanent(){global$ag;foreach($ag
as$x=>$X){list($Ui,$L,$V,$j)=array_map('base64_decode',explode("-",$x));if($Ui==DRIVER&&$L==SERVER&&$V==$_GET["username"]&&$j==DB)unset($ag[$x]);}adm_cookie("adminer_permanent",implode(" ",$ag));}function
auth_error($l){global$b,$Cd;$kh=session_name();if(isset($_GET["username"])){header("HTTP/1.1 403 Forbidden");if(($_COOKIE[$kh]||$_GET[$kh])&&!$Cd)$l='Session å·²éæœŸï¼Œè«‹é‡æ–°ç™»å…¥ã€‚';else{restart_session();add_invalid_login();$E=get_password();if($E!==null){if($E===false)$l.=($l?'<br>':'').sprintf('ä¸»å¯†ç¢¼å·²éæœŸã€‚<a href="https://www.adminer.org/en/extension/"%s>è«‹æ“´å±•</a> %s æ–¹æ³•è®“å®ƒæ°¸ä¹…åŒ–ã€‚',target_blank(),'<code>permanentLogin()</code>');set_password(DRIVER,SERVER,$_GET["username"],null);}unset_permanent();}}if(!$_COOKIE[$kh]&&$_GET[$kh]&&ini_bool("session.use_only_cookies"))$l='Session å¿…é ˆè¢«å•Ÿç”¨ã€‚';$Pf=session_get_cookie_params();adm_cookie("adminer_key",($_COOKIE["adminer_key"]?$_COOKIE["adminer_key"]:rand_string()),$Pf["lifetime"]);page_header('ç™»å…¥',$l,null);echo"<form action='' method='post'>\n","<div>";if(hidden_fields($_POST,array("auth")))echo"<p class='message'>".'æ­¤æ“ä½œå°‡åœ¨æˆåŠŸä½¿ç”¨ç›¸åŒçš„æ†‘æ“šç™»éŒ„å¾ŒåŸ·è¡Œã€‚'."\n";echo"</div>\n";$b->loginForm();echo"</form>\n";page_footer("auth");exit;}if(isset($_GET["username"])&&!class_exists("Min_DB")){unset($_SESSION["pwds"][DRIVER]);unset_permanent();page_header('ç„¡æ“´å……æ¨¡çµ„',sprintf('æ²’æœ‰ä»»ä½•æ”¯æ´çš„ PHP æ“´å……æ¨¡çµ„ï¼ˆ%sï¼‰ã€‚',implode(", ",$gg)),false);page_footer("auth");exit;}stop_session(true);if(isset($_GET["username"])&&is_string(get_password())){list($Hd,$cg)=explode(":",SERVER,2);if(preg_match('~^\s*([-+]?\d+)~',$cg,$A)&&($A[1]<1024||$A[1]>65535))auth_error('ä¸å…è¨±é€£æ¥åˆ°ç‰¹æ¬ŠåŸ ã€‚');check_invalid_login();$f=connect();$k=new
Min_Driver($f);}$ze=null;if(!is_object($f)||($ze=$b->login($_GET["username"],get_password()))!==true){$l=(is_string($f)?nl_br(h($f)):(is_string($ze)?$ze:'ç„¡æ•ˆçš„æ†‘è­‰ã€‚'));auth_error($l.(preg_match('~^ | $~',get_password())?'<br>'.'æ‚¨è¼¸å…¥çš„å¯†ç¢¼ä¸­æœ‰ä¸€å€‹ç©ºæ ¼ï¼Œé€™å¯èƒ½æ˜¯å°è‡´å•é¡Œçš„åŸå› ã€‚':''));}if($_POST["logout"]&&$Cd&&!verify_token()){page_header('ç™»å‡º','ç„¡æ•ˆçš„ CSRF tokenã€‚è«‹é‡æ–°ç™¼é€è¡¨å–®ã€‚');page_footer("db");exit;}if($Ia&&$_POST["token"])$_POST["token"]=$S;$l='';if($_POST){if(!verify_token()){$Ud="max_input_vars";$Je=ini_get($Ud);if(extension_loaded("suhosin")){foreach(array("suhosin.request.max_vars","suhosin.post.max_vars")as$x){$X=ini_get($x);if($X&&(!$Je||$X<$Je)){$Ud=$x;$Je=$X;}}}$l=(!$_POST["token"]&&$Je?sprintf('è¶…éå…è¨±çš„å­—æ®µæ•¸é‡çš„æœ€å¤§å€¼ã€‚è«‹å¢åŠ  %sã€‚',"'$Ud'"):'ç„¡æ•ˆçš„ CSRF tokenã€‚è«‹é‡æ–°ç™¼é€è¡¨å–®ã€‚'.' '.'å¦‚æœæ‚¨ä¸¦æ²’æœ‰å¾Adminerç™¼é€è«‹æ±‚ï¼Œè«‹é—œé–‰æ­¤é é¢ã€‚');}}elseif($_SERVER["REQUEST_METHOD"]=="POST"){$l=sprintf('POST è³‡æ–™å¤ªå¤§ã€‚æ¸›å°‘è³‡æ–™æˆ–è€…å¢åŠ  %s çš„è¨­å®šå€¼ã€‚',"'post_max_size'");if(isset($_GET["sql"]))$l.=' '.'æ‚¨å¯ä»¥é€šéFTPä¸Šå‚³å¤§å‹SQLæª”ä¸¦å¾ä¼ºæœå™¨å°å…¥ã€‚';}function
select($G,$g=null,$Cf=array(),$y=0){global$w;$ye=array();$v=array();$e=array();$Sa=array();$U=array();$H=array();for($s=0;(!$y||$s<$y)&&($I=$G->fetch_row());$s++){if(!$s){echo"<div class='scrollable'>\n","<table class='nowrap odds'>\n","<thead><tr>";for($ge=0;$ge<count($I);$ge++){$m=$G->fetch_field();$B=$m->name;$Bf=$m->orgtable;$Af=$m->orgname;$H[$m->table]=$Bf;if($Cf&&$w=="sql")$ye[$ge]=($B=="table"?"table=":($B=="possible_keys"?"indexes=":null));elseif($Bf!=""){if(!isset($v[$Bf])){$v[$Bf]=array();foreach(indexes($Bf,$g)as$u){if($u["type"]=="PRIMARY"){$v[$Bf]=array_flip($u["columns"]);break;}}$e[$Bf]=$v[$Bf];}if(isset($e[$Bf][$Af])){unset($e[$Bf][$Af]);$v[$Bf][$Af]=$ge;$ye[$ge]=$Bf;}}if($m->charsetnr==63)$Sa[$ge]=true;$U[$ge]=$m->type;echo"<th".($Bf!=""||$m->name!=$Af?" title='".h(($Bf!=""?"$Bf.":"").$Af)."'":"").">".h($B).($Cf?doc_link(array('sql'=>"explain-output.html#explain_".strtolower($B),'mariadb'=>"explain/#the-columns-in-explain-select",)):"");}echo"</thead>\n";}echo"<tr>";foreach($I
as$x=>$X){$z="";if(isset($ye[$x])&&!$e[$ye[$x]]){if($Cf&&$w=="sql"){$P=$I[array_search("table=",$ye)];$z=ME.$ye[$x].urlencode($Cf[$P]!=""?$Cf[$P]:$P);}else{$z=ME."edit=".urlencode($ye[$x]);foreach($v[$ye[$x]]as$mb=>$ge)$z.="&where".urlencode("[".bracket_escape($mb)."]")."=".urlencode($I[$ge]);}}elseif(is_url($X))$z=$X;if($X===null)$X="<i>NULL</i>";elseif($Sa[$x]&&!is_utf8($X))$X="<i>".sprintf('%d byte(s)',strlen($X))."</i>";else{$X=h($X);if($U[$x]==254)$X="<code>$X</code>";}if($z)$X="<a href='".h($z)."'".(is_url($z)?target_blank():'').">$X</a>";echo"<td>$X";}}echo($s?"</table>\n</div>":"<p class='message'>".'æ²’æœ‰è³‡æ–™è¡Œã€‚')."\n";return$H;}function
referencable_primary($ch){$H=array();foreach(table_status('',true)as$Nh=>$P){if($Nh!=$ch&&fk_support($P)){foreach(fields($Nh)as$m){if($m["primary"]){if($H[$Nh]){unset($H[$Nh]);break;}$H[$Nh]=$m;}}}}return$H;}function
adminer_settings(){parse_str($_COOKIE["adminer_settings"],$mh);return$mh;}function
adminer_setting($x){$mh=adminer_settings();return$mh[$x];}function
set_adminer_settings($mh){return
adm_cookie("adminer_settings",http_build_query($mh+adminer_settings()));}function
textarea($B,$Y,$J=10,$rb=80){global$w;echo"<textarea name='".h($B)."' rows='$J' cols='$rb' class='sqlarea jush-$w' spellcheck='false' wrap='off'>";if(is_array($Y)){foreach($Y
as$X)echo
h($X[0])."\n\n\n";}else
echo
h($Y);echo"</textarea>";}function
select_input($Ha,$C,$Y="",$sf="",$bg=""){$Uh=($C?"select":"input");return"<$Uh$Ha".($C?"><option value=''>$bg".optionlist($C,$Y,true)."</select>":" size='10' value='".h($Y)."' placeholder='$bg'>").($sf?script("qsl('$Uh').onchange = $sf;",""):"");}function
json_row($x,$X=null){static$dd=true;if($dd)echo"{";if($x!=""){echo($dd?"":",")."\n\t\"".addcslashes($x,"\r\n\t\"\\/").'": '.($X!==null?'"'.addcslashes($X,"\r\n\"\\/").'"':'null');$dd=false;}else{echo"\n}\n";$dd=true;}}function
edit_type($x,$m,$pb,$md=array(),$Vc=array()){global$Fh,$U,$Gi,$rf;$T=$m["type"];echo'<td><select name="',h($x),'[type]" class="type" aria-labelledby="label-type">';if($T&&!isset($U[$T])&&!isset($md[$T])&&!in_array($T,$Vc))$Vc[]=$T;if($md)$Fh['å¤–ä¾†éµ']=$md;echo
optionlist(array_merge($Vc,$Fh),$T),'</select><td><input
	name="',h($x),'[length]"
	value="',h($m["length"]),'"
	size="3"
	',(!$m["length"]&&preg_match('~var(char|binary)$~',$T)?" class='required'":"");echo'	aria-labelledby="label-length"><td class="options">',($pb?"<select name='".h($x)."[collation]'".(preg_match('~(char|text|enum|set)$~',$T)?"":" class='hidden'").'><option value="">('.'æ ¡å°'.')'.optionlist($pb,$m["collation"]).'</select>':''),($Gi?"<select name='".h($x)."[unsigned]'".(!$T||preg_match(number_type(),$T)?"":" class='hidden'").'><option>'.optionlist($Gi,$m["unsigned"]).'</select>':''),(isset($m['on_update'])?"<select name='".h($x)."[on_update]'".(preg_match('~timestamp|datetime~',$T)?"":" class='hidden'").'>'.optionlist(array(""=>"(".'ON UPDATE'.")","CURRENT_TIMESTAMP"),(preg_match('~^CURRENT_TIMESTAMP~i',$m["on_update"])?"CURRENT_TIMESTAMP":$m["on_update"])).'</select>':''),($md?"<select name='".h($x)."[on_delete]'".(preg_match("~`~",$T)?"":" class='hidden'")."><option value=''>(".'ON DELETE'.")".optionlist(explode("|",$rf),$m["on_delete"])."</select> ":" ");}function
get_partitions_info($P){global$f;$qd="FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = ".q(DB)." AND TABLE_NAME = ".q($P);$G=$f->query("SELECT PARTITION_METHOD, PARTITION_EXPRESSION, PARTITION_ORDINAL_POSITION $qd ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");$H=array();list($H["partition_by"],$H["partition"],$H["partitions"])=$G->fetch_row();$Vf=get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $qd AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");$H["partition_names"]=array_keys($Vf);$H["partition_values"]=array_values($Vf);return$H;}function
process_length($ve){global$Ec;return(preg_match("~^\\s*\\(?\\s*$Ec(?:\\s*,\\s*$Ec)*+\\s*\\)?\\s*\$~",$ve)&&preg_match_all("~$Ec~",$ve,$De)?"(".implode(",",$De[0]).")":preg_replace('~^[0-9].*~','(\0)',preg_replace('~[^-0-9,+()[\]]~','',$ve)));}function
process_type($m,$nb="COLLATE"){global$Gi;return" $m[type]".process_length($m["length"]).(preg_match(number_type(),$m["type"])&&in_array($m["unsigned"],$Gi)?" $m[unsigned]":"").(preg_match('~char|text|enum|set~',$m["type"])&&$m["collation"]?" $nb ".q($m["collation"]):"");}function
process_field($m,$yi){if($m["on_update"])$m["on_update"]=str_ireplace("current_timestamp()","CURRENT_TIMESTAMP",$m["on_update"]);return
array(idf_escape(trim($m["field"])),process_type($yi),($m["null"]?" NULL":" NOT NULL"),default_value($m),(preg_match('~timestamp|datetime~',$m["type"])&&$m["on_update"]?" ON UPDATE $m[on_update]":""),(support("comment")&&$m["comment"]!=""?" COMMENT ".q($m["comment"]):""),($m["auto_increment"]?auto_increment():null),);}function
default_value($m){global$w;$ac=$m["default"];return($ac===null?"":" DEFAULT ".(!preg_match('~^GENERATED ~i',$ac)&&(preg_match('~char|binary|text|enum|set~',$m["type"])||preg_match('~^(?![a-z])~i',$ac))?q($ac):str_ireplace("current_timestamp()","CURRENT_TIMESTAMP",($w=="sqlite"?"($ac)":$ac))));}function
type_class($T){foreach(array('char'=>'text','date'=>'time|year','binary'=>'blob','enum'=>'set',)as$x=>$X){if(preg_match("~$x|$X~",$T))return" class='$x'";}}function
edit_fields($n,$pb,$T="TABLE",$md=array()){global$Vd;$n=array_values($n);$bc=(($_POST?$_POST["defaults"]:adminer_setting("defaults"))?"":" class='hidden'");$wb=(($_POST?$_POST["comments"]:adminer_setting("comments"))?"":" class='hidden'");echo'<thead><tr>
';if($T=="PROCEDURE"){echo'<td>';}echo'<th id="label-name">',($T=="TABLE"?'æ¬„ä½åç¨±':'åƒæ•¸åç¨±'),'<td id="label-type">é¡å‹<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>',script("qs('#enum-edit').onblur = editingLengthBlur;"),'<td id="label-length">é•·åº¦
<td>','é¸é …';if($T=="TABLE"){echo'<td id="label-null">NULL
<td><input type="radio" name="auto_increment_col" value=""><abbr id="label-ai" title="è‡ªå‹•éå¢">AI</abbr>',doc_link(array('sql'=>"example-auto-increment.html",'mariadb'=>"auto_increment/",'sqlite'=>"autoinc.html",'pgsql'=>"datatype-numeric.html#DATATYPE-SERIAL",'mssql'=>"t-sql/statements/create-table-transact-sql-identity-property",)),'<td id="label-default"',$bc,'>é è¨­å€¼
',(support("comment")?"<td id='label-comment'$wb>".'è¨»è§£':"");}echo'<td>',"<input type='image' class='icon' name='add[".(support("move_col")?0:count($n))."]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.17.1")."' alt='+' title='".'æ–°å¢ä¸‹ä¸€ç­†'."'>".script("row_count = ".count($n).";"),'</thead>
<tbody>
',script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");foreach($n
as$s=>$m){$s++;$Df=$m[($_POST?"orig":"field")];$kc=(isset($_POST["add"][$s-1])||(isset($m["field"])&&!$_POST["drop_col"][$s]))&&(support("drop_col")||$Df=="");echo'<tr',($kc?"":" style='display: none;'"),'>
',($T=="PROCEDURE"?"<td>".html_select("fields[$s][inout]",explode("|",$Vd),$m["inout"]):""),'<th>';if($kc){echo'<input name="fields[',$s,'][field]" value="',h($m["field"]),'" data-maxlength="64" autocapitalize="off" aria-labelledby="label-name">';}echo'<input type="hidden" name="fields[',$s,'][orig]" value="',h($Df),'">';edit_type("fields[$s]",$m,$pb,$md);if($T=="TABLE"){echo'<td>',checkbox("fields[$s][null]",1,$m["null"],"","","block","label-null"),'<td><label class="block"><input type="radio" name="auto_increment_col" value="',$s,'"';if($m["auto_increment"]){echo' checked';}echo' aria-labelledby="label-ai"></label><td',$bc,'>',checkbox("fields[$s][has_default]",1,$m["has_default"],"","","","label-default"),'<input name="fields[',$s,'][default]" value="',h($m["default"]),'" aria-labelledby="label-default">',(support("comment")?"<td$wb><input name='fields[$s][comment]' value='".h($m["comment"])."' data-maxlength='".(min_version(5.5)?1024:255)."' aria-labelledby='label-comment'>":"");}echo"<td>",(support("move_col")?"<input type='image' class='icon' name='add[$s]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.17.1")."' alt='+' title='".'æ–°å¢ä¸‹ä¸€ç­†'."'> "."<input type='image' class='icon' name='up[$s]' src='".h(preg_replace("~\\?.*~","",ME)."?file=up.gif&version=4.17.1")."' alt='â†‘' title='".'ä¸Šç§»'."'> "."<input type='image' class='icon' name='down[$s]' src='".h(preg_replace("~\\?.*~","",ME)."?file=down.gif&version=4.17.1")."' alt='â†“' title='".'ä¸‹ç§»'."'> ":""),($Df==""||support("drop_col")?"<input type='image' class='icon' name='drop_col[$s]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=4.17.1")."' alt='x' title='".'ç§»é™¤'."'>":"");}}function
process_fields(&$n){$jf=0;if($_POST["up"]){$pe=0;foreach($n
as$x=>$m){if(key($_POST["up"])==$x){unset($n[$x]);array_splice($n,$pe,0,array($m));break;}if(isset($m["field"]))$pe=$jf;$jf++;}}elseif($_POST["down"]){$od=false;foreach($n
as$x=>$m){if(isset($m["field"])&&$od){unset($n[key($_POST["down"])]);array_splice($n,$jf,0,array($od));break;}if(key($_POST["down"])==$x)$od=$m;$jf++;}}elseif($_POST["add"]){$n=array_values($n);array_splice($n,key($_POST["add"]),0,array(array()));}elseif(!$_POST["drop_col"])return
false;return
true;}function
normalize_enum($A){return"'".str_replace("'","''",addcslashes(stripcslashes(str_replace($A[0][0].$A[0][0],$A[0][0],substr($A[0],1,-1))),'\\'))."'";}function
grant($td,$og,$e,$qf){if(!$og)return
true;if($og==array("ALL PRIVILEGES","GRANT OPTION"))return($td=="GRANT"?queries("$td ALL PRIVILEGES$qf WITH GRANT OPTION"):queries("$td ALL PRIVILEGES$qf")&&queries("$td GRANT OPTION$qf"));return
queries("$td ".preg_replace('~(GRANT OPTION)\([^)]*\)~','\1',implode("$e, ",$og).$e).$qf);}function
drop_create($oc,$h,$pc,$Yh,$rc,$_,$Pe,$Ne,$Oe,$nf,$af){if($_POST["drop"])query_redirect($oc,$_,$Pe);elseif($nf=="")query_redirect($h,$_,$Oe);elseif($nf!=$af){$Mb=queries($h);queries_redirect($_,$Ne,$Mb&&queries($oc));if($Mb)queries($pc);}else
queries_redirect($_,$Ne,queries($Yh)&&queries($rc)&&queries($oc)&&queries($h));}function
create_trigger($qf,$I){global$w;$ei=" $I[Timing] $I[Event]".(preg_match('~ OF~',$I["Event"])?" $I[Of]":"");return"CREATE TRIGGER ".idf_escape($I["Trigger"]).($w=="mssql"?$qf.$ei:$ei.$qf).rtrim(" $I[Type]\n$I[Statement]",";").";";}function
create_routine($Qg,$I){global$Vd,$w;$M=array();$n=(array)$I["fields"];ksort($n);foreach($n
as$m){if($m["field"]!="")$M[]=(preg_match("~^($Vd)\$~",$m["inout"])?"$m[inout] ":"").idf_escape($m["field"]).process_type($m,"CHARACTER SET");}$cc=rtrim($I["definition"],";");return"CREATE $Qg ".idf_escape(trim($I["name"]))." (".implode(", ",$M).")".($Qg=="FUNCTION"?" RETURNS".process_type($I["returns"],"CHARACTER SET"):"").($I["language"]?" LANGUAGE $I[language]":"").($w=="pgsql"?" AS ".q($cc):"\n$cc;");}function
check_constraints($P){return
get_key_vals("SELECT c.CONSTRAINT_NAME, CHECK_CLAUSE
FROM INFORMATION_SCHEMA.CHECK_CONSTRAINTS c
JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS t ON c.CONSTRAINT_SCHEMA = t.CONSTRAINT_SCHEMA AND c.CONSTRAINT_NAME = t.CONSTRAINT_NAME
WHERE c.CONSTRAINT_SCHEMA = ".q($_GET["ns"]!=""?$_GET["ns"]:DB)."
AND t.TABLE_NAME = ".q($P)."
AND CHECK_CLAUSE NOT LIKE '% IS NOT NULL'");}function
remove_definer($F){return
preg_replace('~^([A-Z =]+) DEFINER=`'.preg_replace('~@(.*)~','`@`(%|\1)',logged_user()).'`~','\1',$F);}function
format_foreign_key($p){global$rf;$j=$p["db"];$ef=$p["ns"];return" FOREIGN KEY (".implode(", ",array_map('idf_escape',$p["source"])).") REFERENCES ".($j!=""&&$j!=$_GET["db"]?idf_escape($j).".":"").($ef!=""&&$ef!=$_GET["ns"]?idf_escape($ef).".":"").table($p["table"])." (".implode(", ",array_map('idf_escape',$p["target"])).")".(preg_match("~^($rf)\$~",$p["on_delete"])?" ON DELETE $p[on_delete]":"").(preg_match("~^($rf)\$~",$p["on_update"])?" ON UPDATE $p[on_update]":"");}function
tar_file($o,$ji){$H=pack("a100a8a8a8a12a12",$o,644,0,0,decoct($ji->size),decoct(time()));$hb=8*32;for($s=0;$s<strlen($H);$s++)$hb+=ord($H[$s]);$H.=sprintf("%06o",$hb)."\0 ";echo$H,str_repeat("\0",512-strlen($H));$ji->send();echo
str_repeat("\0",511-($ji->size+511)%512);}function
ini_bytes($Ud){$X=ini_get($Ud);switch(strtolower(substr($X,-1))){case'g':$X=(int)$X*1024;case'm':$X=(int)$X*1024;case'k':$X=(int)$X*1024;}return$X;}function
doc_link($Xf,$Zh="<sup>?</sup>"){global$w,$f;$ih=$f->server_info;$Vi=preg_replace('~^(\d\.?\d).*~s','\1',$ih);$Ki=array('sql'=>"https://dev.mysql.com/doc/refman/$Vi/en/",'sqlite'=>"https://www.sqlite.org/",'pgsql'=>"https://www.postgresql.org/docs/$Vi/",'mssql'=>"https://learn.microsoft.com/en-us/sql/",'oracle'=>"https://www.oracle.com/pls/topic/lookup?ctx=db".preg_replace('~^.* (\d+)\.(\d+)\.\d+\.\d+\.\d+.*~s','\1\2',$ih)."&id=",);if(preg_match('~MariaDB~',$ih)){$Ki['sql']="https://mariadb.com/kb/en/";$Xf['sql']=(isset($Xf['mariadb'])?$Xf['mariadb']:str_replace(".html","/",$Xf['sql']));}return($Xf[$w]?"<a href='".h($Ki[$w].$Xf[$w].($w=='mssql'?"?view=sql-server-ver$Vi":""))."'".target_blank().">$Zh</a>":"");}function
ob_gzencode($O){return
gzencode($O);}function
db_size($j){global$f;if(!$f->select_db($j))return"?";$H=0;foreach(table_status()as$Q)$H+=$Q["Data_length"]+$Q["Index_length"];return
format_number($H);}function
set_utf8mb4($h){global$f;static$M=false;if(!$M&&preg_match('~\butf8mb4~i',$h)){$M=true;echo"SET NAMES ".charset($f).";\n\n";}}function
connect_error(){global$b,$f,$S,$l,$nc;if(DB!=""){header("HTTP/1.1 404 Not Found");page_header('è³‡æ–™åº«'.": ".h(DB),'ç„¡æ•ˆçš„è³‡æ–™åº«ã€‚',true);}else{if($_POST["db"]&&!$l)queries_redirect(substr(ME,0,-1),'è³‡æ–™åº«å·²åˆªé™¤ã€‚',drop_databases($_POST["db"]));page_header('é¸æ“‡è³‡æ–™åº«',$l,false);echo"<p class='links'>\n";foreach(array('database'=>'å»ºç«‹è³‡æ–™åº«','privileges'=>'æ¬Šé™','processlist'=>'è™•ç†ç¨‹åºåˆ—è¡¨','variables'=>'è®Šæ•¸','status'=>'ç‹€æ…‹',)as$x=>$X){if(support($x))echo"<a href='".h(ME)."$x='>$X</a>\n";}echo"<p>".sprintf('%s ç‰ˆæœ¬ï¼š%s é€é PHP æ“´å……æ¨¡çµ„ %s',$nc[DRIVER],"<b>".h($f->server_info)."</b>","<b>$f->extension</b>")."\n","<p>".sprintf('ç™»éŒ„ç‚ºï¼š %s',"<b>".h(logged_user())."</b>")."\n";$i=$b->databases();if($i){$Xg=support("scheme");$pb=collations();echo"<form action='' method='post'>\n","<table class='checkable odds'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),"<thead><tr>".(support("database")?"<td>":"")."<th>".'è³‡æ–™åº«'." - <a href='".h(ME)."refresh=1'>".'é‡æ–°è¼‰å…¥'."</a>"."<td>".'æ ¡å°'."<td>".'è³‡æ–™è¡¨'."<td>".'å¤§å°'." - <a href='".h(ME)."dbsize=1'>".'è¨ˆç®—'."</a>".script("qsl('a').onclick = partial(ajaxSetHtml, '".js_escape(ME)."script=connect');","")."</thead>\n";$i=($_GET["dbsize"]?count_tables($i):array_flip($i));foreach($i
as$j=>$R){$Pg=h(ME)."db=".urlencode($j);$Jd=h("Db-".$j);echo"<tr>".(support("database")?"<td>".checkbox("db[]",$j,in_array($j,(array)$_POST["db"]),"","","",$Jd):""),"<th><a href='$Pg' id='$Jd'>".h($j)."</a>";$ob=h(db_collation($j,$pb));echo"<td>".(support("database")?"<a href='$Pg".($Xg?"&amp;ns=":"")."&amp;database=' title='".'ä¿®æ”¹è³‡æ–™åº«'."'>$ob</a>":$ob),"<td align='right'><a href='$Pg&amp;schema=' id='tables-".h($j)."' title='".'è³‡æ–™åº«çµæ§‹'."'>".($_GET["dbsize"]?$R:"?")."</a>","<td align='right' id='size-".h($j)."'>".($_GET["dbsize"]?db_size($j):"?"),"\n";}echo"</table>\n",(support("database")?"<div class='footer'><div>\n"."<fieldset><legend>".'å·²é¸ä¸­'." <span id='selected'></span></legend><div>\n"."<input type='hidden' name='all' value=''>".script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };")."<input type='submit' name='drop' value='".'åˆªé™¤'."'>".confirm()."\n"."</div></fieldset>\n"."</div></div>\n":""),"<input type='hidden' name='token' value='$S'>\n","</form>\n",script("tableCheck();");}}page_footer("db");}if(isset($_GET["status"]))$_GET["variables"]=$_GET["status"];if(isset($_GET["import"]))$_GET["sql"]=$_GET["import"];if(!(DB!=""?$f->select_db(DB):isset($_GET["sql"])||isset($_GET["dump"])||isset($_GET["database"])||isset($_GET["processlist"])||isset($_GET["privileges"])||isset($_GET["user"])||isset($_GET["variables"])||$_GET["script"]=="connect"||$_GET["script"]=="kill")){if(DB!=""||$_GET["refresh"]){restart_session();set_session("dbs",null);}connect_error();exit;}if(support("scheme")){if(DB!=""&&$_GET["ns"]!==""){if(!isset($_GET["ns"]))adm_redirect(preg_replace('~ns=[^&]*&~','',ME)."ns=".get_schema());if(!set_schema($_GET["ns"])){header("HTTP/1.1 404 Not Found");page_header('è³‡æ–™è¡¨çµæ§‹'.": ".h($_GET["ns"]),'ç„¡æ•ˆçš„è³‡æ–™è¡¨çµæ§‹ã€‚',true);page_footer("ns");exit;}}}$rf="RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";class
TmpFile{var$handler;var$size;function
__construct(){$this->handler=tmpfile();}function
write($Fb){$this->size+=strlen($Fb);fwrite($this->handler,$Fb);}function
send(){fseek($this->handler,0);fpassthru($this->handler);fclose($this->handler);}}$Ec="'(?:''|[^'\\\\]|\\\\.)*'";$Vd="IN|OUT|INOUT";if(isset($_GET["select"])&&($_POST["edit"]||$_POST["clone"])&&!$_POST["save"])$_GET["edit"]=$_GET["select"];if(isset($_GET["callf"]))$_GET["call"]=$_GET["callf"];if(isset($_GET["function"]))$_GET["procedure"]=$_GET["function"];if(isset($_GET["download"])){$a=$_GET["download"];$n=fields($a);header("Content-Type: application/octet-stream");header("Content-Disposition: attachment; filename=".friendly_url("$a-".implode("_",$_GET["where"])).".".friendly_url($_GET["field"]));$K=array(idf_escape($_GET["field"]));$G=$k->select($a,$K,array(where($_GET,$n)),$K);$I=($G?$G->fetch_row():array());echo$k->value($I[0],$n[$_GET["field"]]);exit;}elseif(isset($_GET["table"])){$a=$_GET["table"];$n=fields($a);if(!$n)$l=error();$Q=table_status1($a,true);$B=$b->tableName($Q);page_header(($n&&is_view($Q)?$Q['Engine']=='materialized view'?'ç‰©åŒ–è¦–åœ–':'æª¢è¦–è¡¨':'è³‡æ–™è¡¨').": ".($B!=""?$B:h($a)),$l);$Og=array();foreach($n
as$x=>$m)$Og+=$m["privileges"];$b->selectLinks($Q,(isset($Og["insert"])||!support("table")?"":null));$vb=$Q["Comment"];if($vb!="")echo"<p class='nowrap'>".'è¨»è§£'.": ".h($vb)."\n";if($n)$b->tableStructurePrint($n);if(!is_view($Q)){if(support("indexes")){echo"<h3 id='indexes'>".'ç´¢å¼•'."</h3>\n";$v=indexes($a);if($v)$b->tableIndexesPrint($v);echo'<p class="links"><a href="'.h(ME).'indexes='.urlencode($a).'">'.'ä¿®æ”¹ç´¢å¼•'."</a>\n";}if(fk_support($Q)){echo"<h3 id='foreign-keys'>".'å¤–ä¾†éµ'."</h3>\n";$md=foreign_keys($a);if($md){echo"<table>\n","<thead><tr><th>".'ä¾†æº'."<td>".'ç›®æ¨™'."<td>".'ON DELETE'."<td>".'ON UPDATE'."<td></thead>\n";foreach($md
as$B=>$p){echo"<tr title='".h($B)."'>","<th><i>".implode("</i>, <i>",array_map('h',$p["source"]))."</i>","<td><a href='".h($p["db"]!=""?preg_replace('~db=[^&]*~',"db=".urlencode($p["db"]),ME):($p["ns"]!=""?preg_replace('~ns=[^&]*~',"ns=".urlencode($p["ns"]),ME):ME))."table=".urlencode($p["table"])."'>".($p["db"]!=""?"<b>".h($p["db"])."</b>.":"").($p["ns"]!=""?"<b>".h($p["ns"])."</b>.":"").h($p["table"])."</a>","(<i>".implode("</i>, <i>",array_map('h',$p["target"]))."</i>)","<td>".h($p["on_delete"]),"<td>".h($p["on_update"]),'<td><a href="'.h(ME.'foreign='.urlencode($a).'&name='.urlencode($B)).'">'.'ä¿®æ”¹'.'</a>',"\n";}echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'foreign='.urlencode($a).'">'.'æ–°å¢å¤–ä¾†éµ'."</a>\n";}if(support("check")){echo"<h3 id='checks'>".'Checks'."</h3>\n";$db=check_constraints($a);if($db){echo"<table>\n";foreach($db
as$x=>$X){echo"<tr title='".h($x)."'>","<td><code class='jush-$w'>".h($X),"<td><a href='".h(ME.'check='.urlencode($a).'&name='.urlencode($x))."'>".'ä¿®æ”¹'."</a>","\n";}echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'check='.urlencode($a).'">'.'Create check'."</a>\n";}}if(support(is_view($Q)?"view_trigger":"trigger")){echo"<h3 id='triggers'>".'è§¸ç™¼å™¨'."</h3>\n";$xi=triggers($a);if($xi){echo"<table>\n";foreach($xi
as$x=>$X)echo"<tr valign='top'><td>".h($X[0])."<td>".h($X[1])."<th>".h($x)."<td><a href='".h(ME.'trigger='.urlencode($a).'&name='.urlencode($x))."'>".'ä¿®æ”¹'."</a>\n";echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'trigger='.urlencode($a).'">'.'å»ºç«‹è§¸ç™¼å™¨'."</a>\n";}}elseif(isset($_GET["schema"])){page_header('è³‡æ–™åº«çµæ§‹',"",array(),h(DB.($_GET["ns"]?".$_GET[ns]":"")));$Ph=array();$Qh=array();$ea=($_GET["schema"]?$_GET["schema"]:$_COOKIE["adminer_schema-".str_replace(".","_",DB)]);preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~',$ea,$De,PREG_SET_ORDER);foreach($De
as$s=>$A){$Ph[$A[1]]=array($A[2],$A[3]);$Qh[]="\n\t'".js_escape($A[1])."': [ $A[2], $A[3] ]";}$mi=0;$Pa=-1;$Wg=array();$Bg=array();$te=array();foreach(table_status('',true)as$P=>$Q){if(is_view($Q))continue;$dg=0;$Wg[$P]["fields"]=array();foreach(fields($P)as$B=>$m){$dg+=1.25;$m["pos"]=$dg;$Wg[$P]["fields"][$B]=$m;}$Wg[$P]["pos"]=($Ph[$P]?$Ph[$P]:array($mi,0));foreach($b->foreignKeys($P)as$X){if(!$X["db"]){$re=$Pa;if($Ph[$P][1]||$Ph[$X["table"]][1])$re=min(floatval($Ph[$P][1]),floatval($Ph[$X["table"]][1]))-1;else$Pa-=.1;while($te[(string)$re])$re-=.0001;$Wg[$P]["references"][$X["table"]][(string)$re]=array($X["source"],$X["target"]);$Bg[$X["table"]][$P][(string)$re]=$X["target"];$te[(string)$re]=true;}}$mi=max($mi,$Wg[$P]["pos"][0]+2.5+$dg);}echo'<div id="schema" style="height: ',$mi,'em;">
<script',nonce(),'>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {',implode(",",$Qh)."\n",'};
var em = qs(\'#schema\').offsetHeight / ',$mi,';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'',js_escape(DB),'\');
</script>
';foreach($Wg
as$B=>$P){echo"<div class='table' style='top: ".$P["pos"][0]."em; left: ".$P["pos"][1]."em;'>",'<a href="'.h(ME).'table='.urlencode($B).'"><b>'.h($B)."</b></a>",script("qsl('div').onmousedown = schemaMousedown;");foreach($P["fields"]as$m){$X='<span'.type_class($m["type"]).' title="'.h($m["full_type"].($m["null"]?" NULL":'')).'">'.h($m["field"]).'</span>';echo"<br>".($m["primary"]?"<i>$X</i>":$X);}foreach((array)$P["references"]as$Wh=>$Cg){foreach($Cg
as$re=>$zg){$se=$re-$Ph[$B][1];$s=0;foreach($zg[0]as$uh)echo"\n<div class='references' title='".h($Wh)."' id='refs$re-".($s++)."' style='left: $se"."em; top: ".$P["fields"][$uh]["pos"]."em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: ".(-$se)."em;'></div></div>";}}foreach((array)$Bg[$B]as$Wh=>$Cg){foreach($Cg
as$re=>$e){$se=$re-$Ph[$B][1];$s=0;foreach($e
as$Vh)echo"\n<div class='references' title='".h($Wh)."' id='refd$re-".($s++)."' style='left: $se"."em; top: ".$P["fields"][$Vh]["pos"]."em; height: 1.25em; background: url(".h(preg_replace("~\\?.*~","",ME)."?file=arrow.gif) no-repeat right center;&version=4.17.1")."'><div style='height: .5em; border-bottom: 1px solid Gray; width: ".(-$se)."em;'></div></div>";}}echo"\n</div>\n";}foreach($Wg
as$B=>$P){foreach((array)$P["references"]as$Wh=>$Cg){foreach($Cg
as$re=>$zg){$Se=$mi;$He=-10;foreach($zg[0]as$x=>$uh){$eg=$P["pos"][0]+$P["fields"][$uh]["pos"];$fg=$Wg[$Wh]["pos"][0]+$Wg[$Wh]["fields"][$zg[1][$x]]["pos"];$Se=min($Se,$eg,$fg);$He=max($He,$eg,$fg);}echo"<div class='references' id='refl$re' style='left: $re"."em; top: $Se"."em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: ".($He-$Se)."em;'></div></div>\n";}}}echo'</div>
<p class="links"><a href="',h(ME."schema=".urlencode($ea)),'" id="schema-link">æ°¸ä¹…é€£çµ</a>
';}elseif(isset($_GET["dump"])){$a=$_GET["dump"];if($_POST&&!$l){$Ib="";foreach(array("output","format","db_style","routines","events","table_style","auto_increment","triggers","data_style")as$x)$Ib.="&$x=".urlencode($_POST[$x]);adm_cookie("adminer_export",substr($Ib,1));$R=array_flip((array)$_POST["tables"])+array_flip((array)$_POST["data"]);$Sc=dump_headers((count($R)==1?key($R):DB),(DB==""||count($R)>1));$de=preg_match('~sql~',$_POST["format"]);if($de){echo"-- Adminer $ia ".$nc[DRIVER]." ".str_replace("\n"," ",$f->server_info)." dump\n\n";if($w=="sql"){echo"SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
".($_POST["data_style"]?"SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
":"")."
";$f->query("SET time_zone = '+00:00'");$f->query("SET sql_mode = ''");}}$Gh=$_POST["db_style"];$i=array(DB);if(DB==""){$i=$_POST["databases"];if(is_string($i))$i=explode("\n",rtrim(str_replace("\r","",$i),"\n"));}foreach((array)$i
as$j){$b->dumpDatabase($j);if($f->select_db($j)){if($de&&preg_match('~CREATE~',$Gh)&&($h=$f->result("SHOW CREATE DATABASE ".idf_escape($j),1))){set_utf8mb4($h);if($Gh=="DROP+CREATE")echo"DROP DATABASE IF EXISTS ".idf_escape($j).";\n";echo"$h;\n";}if($de){if($Gh)echo
use_sql($j).";\n\n";$Jf="";if($_POST["routines"]){foreach(routines()as$I){$B=$I["ROUTINE_NAME"];$Qg=$I["ROUTINE_TYPE"];$h=create_routine($Qg,array("name"=>$B)+routine($I["SPECIFIC_NAME"],$Qg));set_utf8mb4($h);$Jf.=($Gh!='DROP+CREATE'?"DROP $Qg IF EXISTS ".idf_escape($B).";;\n":"")."$h;\n\n";}}if($_POST["events"]){foreach(get_rows("SHOW EVENTS",null,"-- ")as$I){$h=remove_definer($f->result("SHOW CREATE EVENT ".idf_escape($I["Name"]),3));set_utf8mb4($h);$Jf.=($Gh!='DROP+CREATE'?"DROP EVENT IF EXISTS ".idf_escape($I["Name"]).";;\n":"")."$h;;\n\n";}}echo($Jf&&$w=='sql'?"DELIMITER ;;\n\n$Jf"."DELIMITER ;\n\n":$Jf);}if($_POST["table_style"]||$_POST["data_style"]){$Xi=array();foreach(table_status('',true)as$B=>$Q){$P=(DB==""||in_array($B,(array)$_POST["tables"]));$Sb=(DB==""||in_array($B,(array)$_POST["data"]));if($P||$Sb){if($Sc=="tar"){$ji=new
TmpFile;ob_start(array($ji,'write'),1e5);}$b->dumpTable($B,($P?$_POST["table_style"]:""),(is_view($Q)?2:0));if(is_view($Q))$Xi[]=$B;elseif($Sb){$n=fields($B);$b->dumpData($B,$_POST["data_style"],"SELECT *".convert_fields($n,$n)." FROM ".table($B));}if($de&&$_POST["triggers"]&&$P&&($xi=trigger_sql($B)))echo"\nDELIMITER ;;\n$xi\nDELIMITER ;\n";if($Sc=="tar"){ob_end_flush();tar_file((DB!=""?"":"$j/")."$B.csv",$ji);}elseif($de)echo"\n";}}if(function_exists('foreign_keys_sql')){foreach(table_status('',true)as$B=>$Q){$P=(DB==""||in_array($B,(array)$_POST["tables"]));if($P&&!is_view($Q))echo
foreign_keys_sql($B);}}foreach($Xi
as$Wi)$b->dumpTable($Wi,$_POST["table_style"],1);if($Sc=="tar")echo
pack("x512");}}}if($de)echo"-- ".$f->result("SELECT NOW()")."\n";exit;}page_header('åŒ¯å‡º',$l,($_GET["export"]!=""?array("table"=>$_GET["export"]):array()),h(DB));echo'
<form action="" method="post">
<table class="layout">
';$Xb=array('','USE','DROP+CREATE','CREATE');$Rh=array('','DROP+CREATE','CREATE');$Tb=array('','TRUNCATE+INSERT','INSERT');if($w=="sql")$Tb[]='INSERT+UPDATE';parse_str($_COOKIE["adminer_export"],$I);if(!$I)$I=array("output"=>"text","format"=>"sql","db_style"=>(DB!=""?"":"CREATE"),"table_style"=>"DROP+CREATE","data_style"=>"INSERT");if(!isset($I["events"])){$I["routines"]=$I["events"]=($_GET["dump"]=="");$I["triggers"]=$I["table_style"];}echo"<tr><th>".'è¼¸å‡º'."<td>".html_select("output",$b->dumpOutput(),$I["output"],0)."\n";echo"<tr><th>".'æ ¼å¼'."<td>".html_select("format",$b->dumpFormat(),$I["format"],0)."\n";echo($w=="sqlite"?"":"<tr><th>".'è³‡æ–™åº«'."<td>".html_select('db_style',$Xb,$I["db_style"]).(support("routine")?checkbox("routines",1,$I["routines"],'ç¨‹åº'):"").(support("event")?checkbox("events",1,$I["events"],'äº‹ä»¶'):"")),"<tr><th>".'è³‡æ–™è¡¨'."<td>".html_select('table_style',$Rh,$I["table_style"]).checkbox("auto_increment",1,$I["auto_increment"],'è‡ªå‹•éå¢').(support("trigger")?checkbox("triggers",1,$I["triggers"],'è§¸ç™¼å™¨'):""),"<tr><th>".'è³‡æ–™'."<td>".html_select('data_style',$Tb,$I["data_style"]),'</table>
<p><input type="submit" value="åŒ¯å‡º">
<input type="hidden" name="token" value="',$S,'">

<table>
',script("qsl('table').onclick = dumpClick;");$ig=array();if(DB!=""){$fb=($a!=""?"":" checked");echo"<thead><tr>","<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$fb>".'è³‡æ–™è¡¨'."</label>".script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);",""),"<th style='text-align: right;'><label class='block'>".'è³‡æ–™'."<input type='checkbox' id='check-data'$fb></label>".script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);",""),"</thead>\n";$Xi="";$Sh=tables_list();foreach($Sh
as$B=>$T){$hg=preg_replace('~_.*~','',$B);$fb=($a==""||$a==(substr($a,-1)=="%"?"$hg%":$B));$lg="<tr><td>".checkbox("tables[]",$B,$fb,$B,"","block");if($T!==null&&!preg_match('~table~i',$T))$Xi.="$lg\n";else
echo"$lg<td align='right'><label class='block'><span id='Rows-".h($B)."'></span>".checkbox("data[]",$B,$fb)."</label>\n";$ig[$hg]++;}echo$Xi;if($Sh)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}else{echo"<thead><tr><th style='text-align: left;'>","<label class='block'><input type='checkbox' id='check-databases'".($a==""?" checked":"").">".'è³‡æ–™åº«'."</label>",script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);",""),"</thead>\n";$i=$b->databases();if($i){foreach($i
as$j){if(!information_schema($j)){$hg=preg_replace('~_.*~','',$j);echo"<tr><td>".checkbox("databases[]",$j,$a==""||$a=="$hg%",$j,"","block")."\n";$ig[$hg]++;}}}else
echo"<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";}echo'</table>
</form>
';$dd=true;foreach($ig
as$x=>$X){if($x!=""&&$X>1){echo($dd?"<p>":" ")."<a href='".h(ME)."dump=".urlencode("$x%")."'>".h($x)."</a>";$dd=false;}}}elseif(isset($_GET["privileges"])){page_header('æ¬Šé™');echo'<p class="links"><a href="'.h(ME).'user=">'.'å»ºç«‹ä½¿ç”¨è€…'."</a>";$G=$f->query("SELECT User, Host FROM mysql.".(DB==""?"user":"db WHERE ".q(DB)." LIKE Db")." ORDER BY Host, User");$td=$G;if(!$G)$G=$f->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");echo"<form action=''><p>\n";hidden_fields_get();echo"<input type='hidden' name='db' value='".h(DB)."'>\n",($td?"":"<input type='hidden' name='grant' value=''>\n"),"<table class='odds'>\n","<thead><tr><th>".'å¸³è™Ÿ'."<th>".'ä¼ºæœå™¨'."<th></thead>\n";while($I=$G->fetch_assoc())echo'<tr><td>'.h($I["User"])."<td>".h($I["Host"]).'<td><a href="'.h(ME.'user='.urlencode($I["User"]).'&host='.urlencode($I["Host"])).'">'.'ç·¨è¼¯'."</a>\n";if(!$td||DB!="")echo"<tr><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='".'ç·¨è¼¯'."'>\n";echo"</table>\n","</form>\n";}elseif(isset($_GET["sql"])){if(!$l&&$_POST["export"]){dump_headers("sql");$b->dumpTable("","");$b->dumpData("","table",$_POST["query"]);exit;}restart_session();$Gd=&get_session("queries");$Fd=&$Gd[DB];if(!$l&&$_POST["clear"]){$Fd=array();adm_redirect(remove_from_uri("history"));}page_header((isset($_GET["import"])?'åŒ¯å…¥':'SQL å‘½ä»¤'),$l);if(!$l&&$_POST){$q=false;if(!isset($_GET["import"]))$F=$_POST["query"];elseif($_POST["webfile"]){$yh=$b->importServerPath();$q=@fopen((file_exists($yh)?$yh:"compress.zlib://$yh.gz"),"rb");$F=($q?fread($q,1e6):false);}else$F=get_file("sql_file",true);if(is_string($F)){if(function_exists('memory_get_usage')&&($Le=ini_bytes("memory_limit"))!="-1")@ini_set("memory_limit",max($Le,2*strlen($F)+memory_get_usage()+8e6));if($F!=""&&strlen($F)<1e6){$sg=$F.(preg_match("~;[ \t\r\n]*\$~",$F)?"":";");if(!$Fd||reset(end($Fd))!=$sg){restart_session();$Fd[]=array($sg,time());set_session("queries",$Gd);stop_session();}}$vh="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$ec=";";$jf=0;$Bc=true;$g=connect();if(is_object($g)&&DB!=""){$g->select_db(DB);if($_GET["ns"]!="")set_schema($_GET["ns"],$g);}$ub=0;$Hc=array();$Qf='[\'"'.($w=="sql"?'`#':($w=="sqlite"?'`[':($w=="mssql"?'[':''))).']|/\*|-- |$'.($w=="pgsql"?'|\$[^$]*\$':'');$ni=microtime(true);parse_str($_COOKIE["adminer_export"],$xa);$tc=$b->dumpFormat();unset($tc["sql"]);while($F!=""){if(!$jf&&preg_match("~^$vh*+DELIMITER\\s+(\\S+)~i",$F,$A)){$ec=$A[1];$F=substr($F,strlen($A[0]));}else{preg_match('('.preg_quote($ec)."\\s*|$Qf)",$F,$A,PREG_OFFSET_CAPTURE,$jf);list($od,$dg)=$A[0];if(!$od&&$q&&!feof($q))$F.=fread($q,1e5);else{if(!$od&&rtrim($F)=="")break;$jf=$dg+strlen($od);if($od&&rtrim($od)!=$ec){$Ya=$k->hasCStyleEscapes()||($w=="pgsql"&&($dg>0&&strtolower($F[$dg-1])=="e"));$Yf=($od=='/*'?'\*/':($od=='['?']':(preg_match('~^-- |^#~',$od)?"\n":preg_quote($od).($Ya?"|\\\\.":""))));while(preg_match("($Yf|\$)s",$F,$A,PREG_OFFSET_CAPTURE,$jf)){$Ug=$A[0][0];if(!$Ug&&$q&&!feof($q))$F.=fread($q,1e5);else{$jf=$A[0][1]+strlen($Ug);if(!$Ug||$Ug[0]!="\\")break;}}}else{$Bc=false;$sg=substr($F,0,$dg);$ub++;$lg="<pre id='sql-$ub'><code class='jush-$w'>".$b->sqlCommandQuery($sg)."</code></pre>\n";if($w=="sqlite"&&preg_match("~^$vh*+ATTACH\\b~i",$sg,$A)){echo$lg,"<p class='error'>".'ä¸æ”¯æ´ATTACHæŸ¥è©¢ã€‚'."\n";$Hc[]=" <a href='#sql-$ub'>$ub</a>";if($_POST["error_stops"])break;}else{if(!$_POST["only_errors"]){echo$lg;ob_flush();flush();}$Ch=microtime(true);if($f->multi_query($sg)&&is_object($g)&&preg_match("~^$vh*+USE\\b~i",$sg))$g->query($sg);do{$G=$f->store_result();if($f->error){echo($_POST["only_errors"]?$lg:""),"<p class='error'>".'æŸ¥è©¢ç™¼ç”ŸéŒ¯èª¤'.($f->errno?" ($f->errno)":"").": ".error()."\n";$Hc[]=" <a href='#sql-$ub'>$ub</a>";if($_POST["error_stops"])break
2;}else{$ci=" <span class='time'>(".format_time($Ch).")</span>".(strlen($sg)<1000?" <a href='".h(ME)."sql=".urlencode(trim($sg))."'>".'ç·¨è¼¯'."</a>":"");$za=$f->affected_rows;$aj=($_POST["only_errors"]?"":$k->warnings());$bj="warnings-$ub";if($aj)$ci.=", <a href='#$bj'>".'è­¦å‘Š'."</a>".script("qsl('a').onclick = partial(toggle, '$bj');","");$Pc=null;$Qc="explain-$ub";if(is_object($G)){$y=$_POST["limit"];$Cf=select($G,$g,array(),$y);if(!$_POST["only_errors"]){echo"<form action='' method='post'>\n";$ff=$G->num_rows;echo"<p>".($ff?($y&&$ff>$y?sprintf('%d / ',$y):"").sprintf('%d è¡Œ',$ff):""),$ci;if($g&&preg_match("~^($vh|\\()*+SELECT\\b~i",$sg)&&($Pc=explain($g,$sg)))echo", <a href='#$Qc'>Explain</a>".script("qsl('a').onclick = partial(toggle, '$Qc');","");$Jd="export-$ub";echo", <a href='#$Jd'>".'åŒ¯å‡º'."</a>".script("qsl('a').onclick = partial(toggle, '$Jd');","")."<span id='$Jd' class='hidden'>: ".html_select("output",$b->dumpOutput(),$xa["output"])." ".html_select("format",$tc,$xa["format"])."<input type='hidden' name='query' value='".h($sg)."'>"." <input type='submit' name='export' value='".'åŒ¯å‡º'."'><input type='hidden' name='token' value='$S'></span>\n"."</form>\n";}}else{if(preg_match("~^$vh*+(CREATE|DROP|ALTER)$vh++(DATABASE|SCHEMA)\\b~i",$sg)){restart_session();set_session("dbs",null);stop_session();}if(!$_POST["only_errors"])echo"<p class='message' title='".h($f->info)."'>".sprintf('åŸ·è¡ŒæŸ¥è©¢ OKï¼Œ%d è¡Œå—å½±éŸ¿ã€‚',$za)."$ci\n";}echo($aj?"<div id='$bj' class='hidden'>\n$aj</div>\n":"");if($Pc){echo"<div id='$Qc' class='hidden explain'>\n";select($Pc,$g,$Cf);echo"</div>\n";}}$Ch=microtime(true);}while($f->next_result());}$F=substr($F,$jf);$jf=0;}}}}if($Bc)echo"<p class='message'>".'æ²’æœ‰å‘½ä»¤å¯åŸ·è¡Œã€‚'."\n";elseif($_POST["only_errors"]){echo"<p class='message'>".sprintf('å·²é †åˆ©åŸ·è¡Œ %d å€‹æŸ¥è©¢ã€‚',$ub-count($Hc))," <span class='time'>(".format_time($ni).")</span>\n";}elseif($Hc&&$ub>1)echo"<p class='error'>".'æŸ¥è©¢ç™¼ç”ŸéŒ¯èª¤'.": ".implode("",$Hc)."\n";}else
echo"<p class='error'>".upload_error($F)."\n";}echo'
<form action="" method="post" enctype="multipart/form-data" id="form">
';$Nc="<input type='submit' value='".'åŸ·è¡Œ'."' title='Ctrl+Enter'>";if(!isset($_GET["import"])){$sg=$_GET["sql"];if($_POST)$sg=$_POST["query"];elseif($_GET["history"]=="all")$sg=$Fd;elseif($_GET["history"]!="")$sg=$Fd[$_GET["history"]][0];echo"<p>";textarea("query",$sg,20);echo
script(($_POST?"":"qs('textarea').focus();\n")."qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '".js_escape(remove_from_uri("sql|limit|error_stops|only_errors|history"))."');"),"<p>$Nc\n",'é™åˆ¶è¡Œæ•¸'.": <input type='number' name='limit' class='size' value='".h($_POST?$_POST["limit"]:$_GET["limit"])."'>\n";}else{echo"<fieldset><legend>".'æª”æ¡ˆä¸Šå‚³'."</legend><div>";$zd=(extension_loaded("zlib")?"[.gz]":"");echo(ini_bool("file_uploads")?"SQL$zd (&lt; ".ini_get("upload_max_filesize")."B): <input type='file' name='sql_file[]' multiple>\n$Nc":'æª”æ¡ˆä¸Šå‚³å·²ç¶“è¢«åœç”¨ã€‚'),"</div></fieldset>\n";$Md=$b->importServerPath();if($Md){echo"<fieldset><legend>".'å¾ä¼ºæœå™¨'."</legend><div>",sprintf('ç¶²é ä¼ºæœå™¨æª”æ¡ˆ %s',"<code>".h($Md)."$zd</code>"),' <input type="submit" name="webfile" value="'.'åŸ·è¡Œæª”æ¡ˆ'.'">',"</div></fieldset>\n";}echo"<p>";}echo
checkbox("error_stops",1,($_POST?$_POST["error_stops"]:isset($_GET["import"])||$_GET["error_stops"]),'å‡ºéŒ¯æ™‚åœæ­¢')."\n",checkbox("only_errors",1,($_POST?$_POST["only_errors"]:isset($_GET["import"])||$_GET["only_errors"]),'åƒ…é¡¯ç¤ºéŒ¯èª¤è¨Šæ¯')."\n","<input type='hidden' name='token' value='$S'>\n";if(!isset($_GET["import"])&&$Fd){print_fieldset("history",'ç´€éŒ„',$_GET["history"]!="");for($X=end($Fd);$X;$X=prev($Fd)){$x=key($Fd);list($sg,$ci,$xc)=$X;echo'<a href="'.h(ME."sql=&history=$x").'">'.'ç·¨è¼¯'."</a>"." <span class='time' title='".@date('Y-m-d',$ci)."'>".@date("H:i:s",$ci)."</span>"." <code class='jush-$w'>".shorten_utf8(ltrim(str_replace("\n"," ",str_replace("\r","",preg_replace('~^(#|-- ).*~m','',$sg)))),80,"</code>").($xc?" <span class='time'>($xc)</span>":"")."<br>\n";}echo"<input type='submit' name='clear' value='".'æ¸…é™¤'."'>\n","<a href='".h(ME."sql=&history=all")."'>".'ç·¨è¼¯å…¨éƒ¨'."</a>\n","</div></fieldset>\n";}echo'</form>
';}elseif(isset($_GET["edit"])){$a=$_GET["edit"];$n=fields($a);$Z=(isset($_GET["select"])?($_POST["check"]&&count($_POST["check"])==1?where_check($_POST["check"][0],$n):""):where($_GET,$n));$Hi=(isset($_GET["select"])?$_POST["edit"]:$Z);foreach($n
as$B=>$m){if(!isset($m["privileges"][$Hi?"update":"insert"])||$b->fieldName($m)==""||$m["generated"])unset($n[$B]);}if($_POST&&!$l&&!isset($_GET["select"])){$_=$_POST["referer"];if($_POST["insert"])$_=($Hi?null:$_SERVER["REQUEST_URI"]);elseif(!preg_match('~^.+&select=.+$~',$_))$_=ME."select=".urlencode($a);$v=indexes($a);$Ci=unique_array($_GET["where"],$v);$vg="\nWHERE $Z";if(isset($_POST["delete"]))queries_redirect($_,'è©²é …ç›®å·²è¢«åˆªé™¤',$k->delete($a,$vg,!$Ci));else{$M=array();foreach($n
as$B=>$m){$X=process_input($m);if($X!==false&&$X!==null)$M[idf_escape($B)]=$X;}if($Hi){if(!$M)adm_redirect($_);queries_redirect($_,'å·²æ›´æ–°é …ç›®ã€‚',$k->update($a,$M,$vg,!$Ci));if(is_ajax()){page_headers();page_messages($l);exit;}}else{$G=$k->insert($a,$M);$qe=($G?last_id():0);queries_redirect($_,sprintf('å·²æ–°å¢é …ç›® %sã€‚',($qe?" $qe":"")),$G);}}}$I=null;if($_POST["save"])$I=(array)$_POST["fields"];elseif($Z){$K=array();foreach($n
as$B=>$m){if(isset($m["privileges"]["select"])){$Fa=convert_field($m);if($_POST["clone"]&&$m["auto_increment"])$Fa="''";if($w=="sql"&&preg_match("~enum|set~",$m["type"]))$Fa="1*".idf_escape($B);$K[]=($Fa?"$Fa AS ":"").idf_escape($B);}}$I=array();if(!support("table"))$K=array("*");if($K){$G=$k->select($a,$K,array($Z),$K,array(),(isset($_GET["select"])?2:1));if(!$G)$l=error();else{$I=$G->fetch_assoc();if(!$I)$I=false;}if(isset($_GET["select"])&&(!$I||$G->fetch_assoc()))$I=null;}}if(!support("table")&&!$n){if(!$Z){$G=$k->select($a,array("*"),$Z,array("*"));$I=($G?$G->fetch_assoc():false);if(!$I)$I=array($k->primary=>"");}if($I){foreach($I
as$x=>$X){if(!$Z)$I[$x]=null;$n[$x]=array("field"=>$x,"null"=>($x!=$k->primary),"auto_increment"=>($x==$k->primary));}}}edit_form($a,$n,$I,$Hi);}elseif(isset($_GET["create"])){$a=$_GET["create"];$Sf=array();foreach(array('HASH','LINEAR HASH','KEY','LINEAR KEY','RANGE','LIST')as$x)$Sf[$x]=$x;$Ag=referencable_primary($a);$md=array();foreach($Ag
as$Nh=>$m)$md[str_replace("`","``",$Nh)."`".str_replace("`","``",$m["field"])]=$Nh;$Ff=array();$Q=array();if($a!=""){$Ff=fields($a);$Q=table_status($a);if(!$Q)$l='æ²’æœ‰è³‡æ–™è¡¨ã€‚';}$I=$_POST;$I["fields"]=(array)$I["fields"];if($I["auto_increment_col"])$I["fields"][$I["auto_increment_col"]]["auto_increment"]=true;if($_POST)set_adminer_settings(array("comments"=>$_POST["comments"],"defaults"=>$_POST["defaults"]));if($_POST&&!process_fields($I["fields"])&&!$l){if($_POST["drop"])queries_redirect(substr(ME,0,-1),'å·²ç¶“åˆªé™¤è³‡æ–™è¡¨ã€‚',drop_tables(array($a)));else{$n=array();$Ca=array();$Li=false;$kd=array();$Ef=reset($Ff);$Aa=" FIRST";foreach($I["fields"]as$x=>$m){$p=$md[$m["type"]];$yi=($p!==null?$Ag[$p]:$m);if($m["field"]!=""){if(!$m["has_default"])$m["default"]=null;$qg=process_field($m,$yi);$Ca[]=array($m["orig"],$qg,$Aa);if(!$Ef||$qg!==process_field($Ef,$Ef)){$n[]=array($m["orig"],$qg,$Aa);if($m["orig"]!=""||$Aa)$Li=true;}if($p!==null)$kd[idf_escape($m["field"])]=($a!=""&&$w!="sqlite"?"ADD":" ").format_foreign_key(array('table'=>$md[$m["type"]],'source'=>array($m["field"]),'target'=>array($yi["field"]),'on_delete'=>$m["on_delete"],));$Aa=" AFTER ".idf_escape($m["field"]);}elseif($m["orig"]!=""){$Li=true;$n[]=array($m["orig"]);}if($m["orig"]!=""){$Ef=next($Ff);if(!$Ef)$Aa="";}}$Uf="";if(support("partitioning")){if(isset($Sf[$I["partition_by"]])){$Pf=array_filter($I,function($x){return
preg_match('~^partition~',$x);},ARRAY_FILTER_USE_KEY);foreach($Pf["partition_names"]as$x=>$B){if($B==""){unset($Pf["partition_names"][$x]);unset($Pf["partition_values"][$x]);}}if($Pf!=get_partitions_info($a)){$Vf=array();if($Pf["partition_by"]=='RANGE'||$Pf["partition_by"]=='LIST'){foreach($Pf["partition_names"]as$x=>$B){$Y=$Pf["partition_values"][$x];$Vf[]="\n  PARTITION ".idf_escape($B)." VALUES ".($Pf["partition_by"]=='RANGE'?"LESS THAN":"IN").($Y!=""?" ($Y)":" MAXVALUE");}}$Uf.="\nPARTITION BY $Pf[partition_by]($Pf[partition])";if($Vf)$Uf.=" (".implode(",",$Vf)."\n)";elseif($Pf["partitions"])$Uf.=" PARTITIONS ".(+$Pf["partitions"]);}}elseif(preg_match("~partitioned~",$Q["Create_options"]))$Uf.="\nREMOVE PARTITIONING";}$Me='è³‡æ–™è¡¨å·²ä¿®æ”¹ã€‚';if($a==""){adm_cookie("adminer_engine",$I["Engine"]);$Me='è³‡æ–™è¡¨å·²å»ºç«‹ã€‚';}$B=trim($I["name"]);queries_redirect(ME.(support("table")?"table=":"select=").urlencode($B),$Me,alter_table($a,$B,($w=="sqlite"&&($Li||$kd)?$Ca:$n),$kd,($I["Comment"]!=$Q["Comment"]?$I["Comment"]:null),($I["Engine"]&&$I["Engine"]!=$Q["Engine"]?$I["Engine"]:""),($I["Collation"]&&$I["Collation"]!=$Q["Collation"]?$I["Collation"]:""),($I["Auto_increment"]!=""?number($I["Auto_increment"]):""),$Uf));}}page_header(($a!=""?'ä¿®æ”¹è³‡æ–™è¡¨':'å»ºç«‹è³‡æ–™è¡¨'),$l,array("table"=>$a),h($a));if(!$_POST){$I=array("Engine"=>$_COOKIE["adminer_engine"],"fields"=>array(array("field"=>"","type"=>(isset($U["int"])?"int":(isset($U["integer"])?"integer":"")),"on_update"=>"")),"partition_names"=>array(""),);if($a!=""){$I=$Q;$I["name"]=$a;$I["fields"]=array();if(!$_GET["auto_increment"])$I["Auto_increment"]="";foreach($Ff
as$m){$m["has_default"]=isset($m["default"]);$I["fields"][]=$m;}if(support("partitioning")){$I+=get_partitions_info($a);$I["partition_names"][]="";$I["partition_values"][]="";}}}$pb=collations();$Dc=engines();foreach($Dc
as$Cc){if(!strcasecmp($Cc,$I["Engine"])){$I["Engine"]=$Cc;break;}}echo'
<form action="" method="post" id="form">
<p>
';if(support("columns")||$a==""){echo'è³‡æ–™è¡¨åç¨±: <input name="name"',($a==""&&!$_POST?" autofocus":""),' data-maxlength="64" value="',h($I["name"]),'" autocapitalize="off">
',($Dc?"<select name='Engine'>".optionlist(array(""=>"(".'å¼•æ“'.")")+$Dc,$I["Engine"])."</select>".on_help("getTarget(event).value",1).script("qsl('select').onchange = helpClose;"):""),' ',($pb&&!preg_match("~sqlite|mssql~",$w)?html_select("Collation",array(""=>"(".'æ ¡å°'.")")+$pb,$I["Collation"]):""),' <input type="submit" value="å„²å­˜">
';}echo'
';if(support("columns")){echo'<div class="scrollable">
<table id="edit-fields" class="nowrap">
';edit_fields($I["fields"],$pb,"TABLE",$md);echo'</table>
',script("editFields();"),'</div>
<p>
è‡ªå‹•éå¢: <input type="number" name="Auto_increment" class="size" value="',h($I["Auto_increment"]),'">
',checkbox("defaults",1,($_POST?$_POST["defaults"]:adminer_setting("defaults")),'é è¨­å€¼',"columnShow(this.checked, 5)","jsonly");$xb=($_POST?$_POST["comments"]:adminer_setting("comments"));echo(support("comment")?checkbox("comments",1,$xb,'è¨»è§£',"editingCommentsClick(this, true);","jsonly").' '.(preg_match('~\n~',$I["Comment"])?"<textarea name='Comment' rows='2' cols='20'".($xb?"":" class='hidden'").">".h($I["Comment"])."</textarea>":'<input name="Comment" value="'.h($I["Comment"]).'" data-maxlength="'.(min_version(5.5)?2048:60).'"'.($xb?"":" class='hidden'").'>'):''),'<p>
<input type="submit" value="å„²å­˜">
';}echo'
';if($a!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('åˆªé™¤ %s?',$a));}if(support("partitioning")){$Tf=preg_match('~RANGE|LIST~',$I["partition_by"]);print_fieldset("partition",'åˆ†å€é¡å‹',$I["partition_by"]);echo'<p>
',"<select name='partition_by'>".optionlist(array(""=>"")+$Sf,$I["partition_by"])."</select>".on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')",1).script("qsl('select').onchange = partitionByChange;"),'(<input name="partition" value="',h($I["partition"]),'">)
åˆ†å€: <input type="number" name="partitions" class="size',($Tf||!$I["partition_by"]?" hidden":""),'" value="',h($I["partitions"]),'">
<table id="partition-table"',($Tf?"":" class='hidden'"),'>
<thead><tr><th>åˆ†å€åç¨±<th>å€¼</thead>
';foreach($I["partition_names"]as$x=>$X){echo'<tr>','<td><input name="partition_names[]" value="'.h($X).'" autocapitalize="off">',($x==count($I["partition_names"])-1?script("qsl('input').oninput = partitionNameChange;"):''),'<td><input name="partition_values[]" value="'.h($I["partition_values"][$x]).'">';}echo'</table>
</div></fieldset>
';}echo'<input type="hidden" name="token" value="',$S,'">
</form>
';}elseif(isset($_GET["indexes"])){$a=$_GET["indexes"];$Qd=array("PRIMARY","UNIQUE","INDEX");$Q=table_status($a,true);if(preg_match('~MyISAM|M?aria'.(min_version(5.6,'10.0.5')?'|InnoDB':'').'~i',$Q["Engine"]))$Qd[]="FULLTEXT";if(preg_match('~MyISAM|M?aria'.(min_version(5.7,'10.2.2')?'|InnoDB':'').'~i',$Q["Engine"]))$Qd[]="SPATIAL";$v=indexes($a);$jg=array();if($w=="mongo"){$jg=$v["_id_"];unset($Qd[0]);unset($v["_id_"]);}$I=$_POST;if($I)set_adminer_settings(array("index_options"=>$I["options"]));if($_POST&&!$l&&!$_POST["add"]&&!$_POST["drop_col"]){$c=array();foreach($I["indexes"]as$u){$B=$u["name"];if(in_array($u["type"],$Qd)){$e=array();$we=array();$gc=array();$M=array();ksort($u["columns"]);foreach($u["columns"]as$x=>$d){if($d!=""){$ve=$u["lengths"][$x];$fc=$u["descs"][$x];$M[]=idf_escape($d).($ve?"(".(+$ve).")":"").($fc?" DESC":"");$e[]=$d;$we[]=($ve?$ve:null);$gc[]=$fc;}}if($e){$Oc=$v[$B];if($Oc){ksort($Oc["columns"]);ksort($Oc["lengths"]);ksort($Oc["descs"]);if($u["type"]==$Oc["type"]&&array_values($Oc["columns"])===$e&&(!$Oc["lengths"]||array_values($Oc["lengths"])===$we)&&array_values($Oc["descs"])===$gc){unset($v[$B]);continue;}}$c[]=array($u["type"],$B,$M);}}}foreach($v
as$B=>$Oc)$c[]=array($Oc["type"],$B,"DROP");if(!$c)adm_redirect(ME."table=".urlencode($a));queries_redirect(ME."table=".urlencode($a),'å·²ä¿®æ”¹ç´¢å¼•ã€‚',alter_indexes($a,$c));}page_header('ç´¢å¼•',$l,array("table"=>$a),h($a));$n=array_keys(fields($a));if($_POST["add"]){foreach($I["indexes"]as$x=>$u){if($u["columns"][count($u["columns"])]!="")$I["indexes"][$x]["columns"][]="";}$u=end($I["indexes"]);if($u["type"]||array_filter($u["columns"],'strlen'))$I["indexes"][]=array("columns"=>array(1=>""));}if(!$I){foreach($v
as$x=>$u){$v[$x]["name"]=$x;$v[$x]["columns"][]="";}$v[]=array("columns"=>array(1=>""));$I["indexes"]=$v;}$we=($w=="sql"||$w=="mssql");$nh=($_POST?$_POST["options"]:adminer_setting("index_options"));echo'
<form action="" method="post">
<div class="scrollable">
<table class="nowrap">
<thead><tr>
<th id="label-type">ç´¢å¼•é¡å‹
<th><input type="submit" class="wayoff">','æ¬„ä½'.($we?"<span class='idxopts".($nh?"":" hidden")."'> (".'é•·åº¦'.")</span>":"");if($we||support("descidx"))echo
checkbox("options",1,$nh,'é¸é …',"indexOptionsShow(this.checked)","jsonly")."\n";echo'<th id="label-name">åç¨±
<th><noscript>',"<input type='image' class='icon' name='add[0]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.17.1")."' alt='+' title='".'æ–°å¢ä¸‹ä¸€ç­†'."'>",'</noscript>
</thead>
';if($jg){echo"<tr><td>PRIMARY<td>";foreach($jg["columns"]as$x=>$d){echo
select_input(" disabled",$n,$d),"<label><input disabled type='checkbox'>".'é™å†ª (éæ¸›)'."</label> ";}echo"<td><td>\n";}$ge=1;foreach($I["indexes"]as$u){if(!$_POST["drop_col"]||$ge!=key($_POST["drop_col"])){echo"<tr><td>".html_select("indexes[$ge][type]",array(-1=>"")+$Qd,$u["type"],($ge==count($I["indexes"])?"indexesAddRow.call(this);":1),"label-type"),"<td>";ksort($u["columns"]);$s=1;foreach($u["columns"]as$x=>$d){echo"<span>".select_input(" name='indexes[$ge][columns][$s]' title='".'æ¬„ä½'."'",($n?array_combine($n,$n):$n),$d,"partial(".($s==count($u["columns"])?"indexesAddColumn":"indexesChangeColumn").", '".js_escape($w=="sql"?"":$_GET["indexes"]."_")."')"),"<span class='idxopts".($nh?"":" hidden")."'>",($we?"<input type='number' name='indexes[$ge][lengths][$s]' class='size' value='".h($u["lengths"][$x])."' title='".'é•·åº¦'."'>":""),(support("descidx")?checkbox("indexes[$ge][descs][$s]",1,$u["descs"][$x],'é™å†ª (éæ¸›)'):""),"</span> </span>";$s++;}echo"<td><input name='indexes[$ge][name]' value='".h($u["name"])."' autocapitalize='off' aria-labelledby='label-name'>\n","<td><input type='image' class='icon' name='drop_col[$ge]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=4.17.1")."' alt='x' title='".'ç§»é™¤'."'>".script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");}$ge++;}echo'</table>
</div>
<p>
<input type="submit" value="å„²å­˜">
<input type="hidden" name="token" value="',$S,'">
</form>
';}elseif(isset($_GET["database"])){$I=$_POST;if($_POST&&!$l&&!isset($_POST["add_x"])){$B=trim($I["name"]);if($_POST["drop"]){$_GET["db"]="";queries_redirect(remove_from_uri("db|database"),'è³‡æ–™åº«å·²åˆªé™¤ã€‚',drop_databases(array(DB)));}elseif(DB!==$B){if(DB!=""){$_GET["db"]=$B;queries_redirect(preg_replace('~\bdb=[^&]*&~','',ME)."db=".urlencode($B),'å·²é‡æ–°å‘½åè³‡æ–™åº«ã€‚',rename_database($B,$I["collation"]));}else{$i=explode("\n",str_replace("\r","",$B));$Hh=true;$pe="";foreach($i
as$j){if(count($i)==1||$j!=""){if(!create_database($j,$I["collation"]))$Hh=false;$pe=$j;}}restart_session();set_session("dbs",null);queries_redirect(ME."db=".urlencode($pe),'å·²å»ºç«‹è³‡æ–™åº«ã€‚',$Hh);}}else{if(!$I["collation"])adm_redirect(substr(ME,0,-1));query_redirect("ALTER DATABASE ".idf_escape($B).(preg_match('~^[a-z0-9_]+$~i',$I["collation"])?" COLLATE $I[collation]":""),substr(ME,0,-1),'å·²ä¿®æ”¹è³‡æ–™åº«ã€‚');}}page_header(DB!=""?'ä¿®æ”¹è³‡æ–™åº«':'å»ºç«‹è³‡æ–™åº«',$l,array(),h(DB));$pb=collations();$B=DB;if($_POST)$B=$I["name"];elseif(DB!="")$I["collation"]=db_collation(DB,$pb);elseif($w=="sql"){foreach(get_vals("SHOW GRANTS")as$td){if(preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~',$td,$A)&&$A[1]){$B=stripcslashes(idf_unescape("`$A[2]`"));break;}}}echo'
<form action="" method="post">
<p>
',($_POST["add_x"]||strpos($B,"\n")?'<textarea autofocus name="name" rows="10" cols="40">'.h($B).'</textarea><br>':'<input name="name" autofocus value="'.h($B).'" data-maxlength="64" autocapitalize="off">')."\n".($pb?html_select("collation",array(""=>"(".'æ ¡å°'.")")+$pb,$I["collation"]).doc_link(array('sql'=>"charset-charsets.html",'mariadb'=>"supported-character-sets-and-collations/",'mssql'=>"relational-databases/system-functions/sys-fn-helpcollations-transact-sql",)):""),'<input type="submit" value="å„²å­˜">
';if(DB!="")echo"<input type='submit' name='drop' value='".'åˆªé™¤'."'>".confirm(sprintf('åˆªé™¤ %s?',DB))."\n";elseif(!$_POST["add_x"]&&$_GET["db"]=="")echo"<input type='image' class='icon' name='add' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.17.1")."' alt='+' title='".'æ–°å¢ä¸‹ä¸€ç­†'."'>\n";echo'<input type="hidden" name="token" value="',$S,'">
</form>
';}elseif(isset($_GET["scheme"])){$I=$_POST;if($_POST&&!$l){$z=preg_replace('~ns=[^&]*&~','',ME)."ns=";if($_POST["drop"])query_redirect("DROP SCHEMA ".idf_escape($_GET["ns"]),$z,'å·²åˆªé™¤è³‡æ–™è¡¨çµæ§‹ã€‚');else{$B=trim($I["name"]);$z.=urlencode($B);if($_GET["ns"]=="")query_redirect("CREATE SCHEMA ".idf_escape($B),$z,'å·²å»ºç«‹è³‡æ–™è¡¨çµæ§‹ã€‚');elseif($_GET["ns"]!=$B)query_redirect("ALTER SCHEMA ".idf_escape($_GET["ns"])." RENAME TO ".idf_escape($B),$z,'å·²ä¿®æ”¹è³‡æ–™è¡¨çµæ§‹ã€‚');else
adm_redirect($z);}}page_header($_GET["ns"]!=""?'ä¿®æ”¹è³‡æ–™è¡¨çµæ§‹':'å»ºç«‹è³‡æ–™è¡¨çµæ§‹',$l);if(!$I)$I["name"]=$_GET["ns"];echo'
<form action="" method="post">
<p><input name="name" autofocus value="',h($I["name"]),'" autocapitalize="off">
<input type="submit" value="å„²å­˜">
';if($_GET["ns"]!="")echo"<input type='submit' name='drop' value='".'åˆªé™¤'."'>".confirm(sprintf('åˆªé™¤ %s?',$_GET["ns"]))."\n";echo'<input type="hidden" name="token" value="',$S,'">
</form>
';}elseif(isset($_GET["call"])){$da=($_GET["name"]?$_GET["name"]:$_GET["call"]);page_header('å‘¼å«'.": ".h($da),$l);$Qg=routine($_GET["call"],(isset($_GET["callf"])?"FUNCTION":"PROCEDURE"));$Nd=array();$Jf=array();foreach($Qg["fields"]as$s=>$m){if(substr($m["inout"],-3)=="OUT")$Jf[$s]="@".idf_escape($m["field"])." AS ".idf_escape($m["field"]);if(!$m["inout"]||substr($m["inout"],0,2)=="IN")$Nd[]=$s;}if(!$l&&$_POST){$Za=array();foreach($Qg["fields"]as$x=>$m){if(in_array($x,$Nd)){$X=process_input($m);if($X===false)$X="''";if(isset($Jf[$x]))$f->query("SET @".idf_escape($m["field"])." = $X");}$Za[]=(isset($Jf[$x])?"@".idf_escape($m["field"]):$X);}$F=(isset($_GET["callf"])?"SELECT":"CALL")." ".table($da)."(".implode(", ",$Za).")";$Ch=microtime(true);$G=$f->multi_query($F);$za=$f->affected_rows;echo$b->selectQuery($F,$Ch,!$G);if(!$G)echo"<p class='error'>".error()."\n";else{$g=connect();if(is_object($g))$g->select_db(DB);do{$G=$f->store_result();if(is_object($G))select($G,$g);else
echo"<p class='message'>".sprintf('ç¨‹åºå·²è¢«åŸ·è¡Œï¼Œ%d è¡Œè¢«å½±éŸ¿',$za)." <span class='time'>".@date("H:i:s")."</span>\n";}while($f->next_result());if($Jf)select($f->query("SELECT ".implode(", ",$Jf)));}}echo'
<form action="" method="post">
';if($Nd){echo"<table class='layout'>\n";foreach($Nd
as$x){$m=$Qg["fields"][$x];$B=$m["field"];echo"<tr><th>".$b->fieldName($m);$Y=$_POST["fields"][$B];if($Y!=""){if($m["type"]=="enum")$Y=+$Y;if($m["type"]=="set")$Y=array_sum($Y);}input($m,$Y,(string)$_POST["function"][$B]);echo"\n";}echo"</table>\n";}echo'<p>
<input type="submit" value="å‘¼å«">
<input type="hidden" name="token" value="',$S,'">
</form>

<pre>
';function
pre_tr($Ug){return
preg_replace('~^~m','<tr>',preg_replace('~\|~','<td>',preg_replace('~\|$~m',"",rtrim($Ug))));}$P='(\+--[-+]+\+\n)';$I='(\| .* \|\n)';echo
preg_replace_callback("~^$P?$I$P?($I*)$P?~m",function($A){$ed=pre_tr($A[2]);return"<table>\n".($A[1]?"<thead>$ed</thead>\n":$ed).pre_tr($A[4])."\n</table>";},preg_replace('~(\n(    -|mysql)&gt; )(.+)~',"\\1<code class='jush-sql'>\\3</code>",preg_replace('~(.+)\n---+\n~',"<b>\\1</b>\n",h($Qg['comment']))));echo'</pre>
';}elseif(isset($_GET["foreign"])){$a=$_GET["foreign"];$B=$_GET["name"];$I=$_POST;if($_POST&&!$l&&!$_POST["add"]&&!$_POST["change"]&&!$_POST["change-js"]){$Me=($_POST["drop"]?'å·²åˆªé™¤å¤–ä¾†éµã€‚':($B!=""?'å·²ä¿®æ”¹å¤–ä¾†éµã€‚':'å·²å»ºç«‹å¤–ä¾†éµã€‚'));$_=ME."table=".urlencode($a);if(!$_POST["drop"]){$I["source"]=array_filter($I["source"],'strlen');ksort($I["source"]);$Vh=array();foreach($I["source"]as$x=>$X)$Vh[$x]=$I["target"][$x];$I["target"]=$Vh;}if($w=="sqlite")queries_redirect($_,$Me,recreate_table($a,$a,array(),array(),array(" $B"=>($_POST["drop"]?"":" ".format_foreign_key($I)))));else{$c="ALTER TABLE ".table($a);$oc="\nDROP ".($w=="sql"?"FOREIGN KEY ":"CONSTRAINT ").idf_escape($B);if($_POST["drop"])query_redirect($c.$oc,$_,$Me);else{query_redirect($c.($B!=""?"$oc,":"")."\nADD".format_foreign_key($I),$_,$Me);$l='ä¾†æºåˆ—å’Œç›®æ¨™åˆ—å¿…é ˆå…·æœ‰ç›¸åŒçš„è³‡æ–™é¡å‹ï¼Œåœ¨ç›®æ¨™åˆ—ä¸Šå¿…é ˆæœ‰ä¸€å€‹ç´¢å¼•ä¸¦ä¸”å¼•ç”¨çš„è³‡æ–™å¿…é ˆå­˜åœ¨ã€‚'."<br>$l";}}}page_header('å¤–ä¾†éµ',$l,array("table"=>$a),h($a));if($_POST){ksort($I["source"]);if($_POST["add"])$I["source"][]="";elseif($_POST["change"]||$_POST["change-js"])$I["target"]=array();}elseif($B!=""){$md=foreign_keys($a);$I=$md[$B];$I["source"][]="";}else{$I["table"]=$a;$I["source"]=array("");}echo'
<form action="" method="post">
';$uh=array_keys(fields($a));if($I["db"]!="")$f->select_db($I["db"]);if($I["ns"]!="")set_schema($I["ns"]);$_g=array_keys(array_filter(table_status('',true),'fk_support'));$Vh=array_keys(fields(in_array($I["table"],$_g)?$I["table"]:reset($_g)));$sf="this.form['change-js'].value = '1'; this.form.submit();";echo"<p>".'ç›®æ¨™è³‡æ–™è¡¨'.": ".html_select("table",$_g,$I["table"],$sf)."\n";if($w=="pgsql")echo'è³‡æ–™è¡¨çµæ§‹'.": ".html_select("ns",$b->schemas(),$I["ns"]!=""?$I["ns"]:$_GET["ns"],$sf);elseif($w!="sqlite"){$Yb=array();foreach($b->databases()as$j){if(!information_schema($j))$Yb[]=$j;}echo'è³‡æ–™åº«'.": ".html_select("db",$Yb,$I["db"]!=""?$I["db"]:$_GET["db"],$sf);}echo'<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="è®Šæ›´"></noscript>
<table>
<thead><tr><th id="label-source">ä¾†æº<th id="label-target">ç›®æ¨™</thead>
';$ge=0;foreach($I["source"]as$x=>$X){echo"<tr>","<td>".html_select("source[".(+$x)."]",array(-1=>"")+$uh,$X,($ge==count($I["source"])-1?"foreignAddRow.call(this);":1),"label-source"),"<td>".html_select("target[".(+$x)."]",$Vh,$I["target"][$x],1,"label-target");$ge++;}echo'</table>
<p>
ON DELETE: ',html_select("on_delete",array(-1=>"")+explode("|",$rf),$I["on_delete"]),' ON UPDATE: ',html_select("on_update",array(-1=>"")+explode("|",$rf),$I["on_update"]),doc_link(array('sql'=>"innodb-foreign-key-constraints.html",'mariadb'=>"foreign-keys/",'pgsql'=>"sql-createtable.html#SQL-CREATETABLE-REFERENCES",'mssql'=>"t-sql/statements/create-table-transact-sql",'oracle'=>"SQLRF01111",)),'<p>
<input type="submit" value="å„²å­˜">
<noscript><p><input type="submit" name="add" value="æ–°å¢æ¬„ä½"></noscript>
';if($B!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('åˆªé™¤ %s?',$B));}echo'<input type="hidden" name="token" value="',$S,'">
</form>
';}elseif(isset($_GET["view"])){$a=$_GET["view"];$I=$_POST;$Gf="VIEW";if($w=="pgsql"&&$a!=""){$N=table_status($a);$Gf=strtoupper($N["Engine"]);}if($_POST&&!$l){$B=trim($I["name"]);$Fa=" AS\n$I[select]";$_=ME."table=".urlencode($B);$Me='å·²ä¿®æ”¹æª¢è¦–è¡¨ã€‚';$T=($_POST["materialized"]?"MATERIALIZED VIEW":"VIEW");if(!$_POST["drop"]&&$a==$B&&$w!="sqlite"&&$T=="VIEW"&&$Gf=="VIEW")query_redirect(($w=="mssql"?"ALTER":"CREATE OR REPLACE")." VIEW ".table($B).$Fa,$_,$Me);else{$Xh=$B."_adminer_".uniqid();drop_create("DROP $Gf ".table($a),"CREATE $T ".table($B).$Fa,"DROP $T ".table($B),"CREATE $T ".table($Xh).$Fa,"DROP $T ".table($Xh),($_POST["drop"]?substr(ME,0,-1):$_),'å·²åˆªé™¤æª¢è¦–è¡¨ã€‚',$Me,'å·²å»ºç«‹æª¢è¦–è¡¨ã€‚',$a,$B);}}if(!$_POST&&$a!=""){$I=adm_view($a);$I["name"]=$a;$I["materialized"]=($Gf!="VIEW");if(!$l)$l=error();}page_header(($a!=""?'ä¿®æ”¹æª¢è¦–è¡¨':'å»ºç«‹æª¢è¦–è¡¨'),$l,array("table"=>$a),h($a));echo'
<form action="" method="post">
<p>åç¨±: <input name="name" value="',h($I["name"]),'" data-maxlength="64" autocapitalize="off">
',(support("materializedview")?" ".checkbox("materialized",1,$I["materialized"],'ç‰©åŒ–è¦–åœ–'):""),'<p>';textarea("select",$I["select"]);echo'<p>
<input type="submit" value="å„²å­˜">
';if($a!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('åˆªé™¤ %s?',$a));}echo'<input type="hidden" name="token" value="',$S,'">
</form>
';}elseif(isset($_GET["event"])){$aa=$_GET["event"];$Yd=array("YEAR","QUARTER","MONTH","DAY","HOUR","MINUTE","WEEK","SECOND","YEAR_MONTH","DAY_HOUR","DAY_MINUTE","DAY_SECOND","HOUR_MINUTE","HOUR_SECOND","MINUTE_SECOND");$Dh=array("ENABLED"=>"ENABLE","DISABLED"=>"DISABLE","SLAVESIDE_DISABLED"=>"DISABLE ON SLAVE");$I=$_POST;if($_POST&&!$l){if($_POST["drop"])query_redirect("DROP EVENT ".idf_escape($aa),substr(ME,0,-1),'å·²åˆªé™¤äº‹ä»¶ã€‚');elseif(in_array($I["INTERVAL_FIELD"],$Yd)&&isset($Dh[$I["STATUS"]])){$Vg="\nON SCHEDULE ".($I["INTERVAL_VALUE"]?"EVERY ".q($I["INTERVAL_VALUE"])." $I[INTERVAL_FIELD]".($I["STARTS"]?" STARTS ".q($I["STARTS"]):"").($I["ENDS"]?" ENDS ".q($I["ENDS"]):""):"AT ".q($I["STARTS"]))." ON COMPLETION".($I["ON_COMPLETION"]?"":" NOT")." PRESERVE";queries_redirect(substr(ME,0,-1),($aa!=""?'å·²ä¿®æ”¹äº‹ä»¶ã€‚':'å·²å»ºç«‹äº‹ä»¶ã€‚'),queries(($aa!=""?"ALTER EVENT ".idf_escape($aa).$Vg.($aa!=$I["EVENT_NAME"]?"\nRENAME TO ".idf_escape($I["EVENT_NAME"]):""):"CREATE EVENT ".idf_escape($I["EVENT_NAME"]).$Vg)."\n".$Dh[$I["STATUS"]]." COMMENT ".q($I["EVENT_COMMENT"]).rtrim(" DO\n$I[EVENT_DEFINITION]",";").";"));}}page_header(($aa!=""?'ä¿®æ”¹äº‹ä»¶'.": ".h($aa):'å»ºç«‹äº‹ä»¶'),$l);if(!$I&&$aa!=""){$J=get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = ".q(DB)." AND EVENT_NAME = ".q($aa));$I=reset($J);}echo'
<form action="" method="post">
<table class="layout">
<tr><th>åç¨±<td><input name="EVENT_NAME" value="',h($I["EVENT_NAME"]),'" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">é–‹å§‹<td><input name="STARTS" value="',h("$I[EXECUTE_AT]$I[STARTS]"),'">
<tr><th title="datetime">çµæŸ<td><input name="ENDS" value="',h($I["ENDS"]),'">
<tr><th>æ¯<td><input type="number" name="INTERVAL_VALUE" value="',h($I["INTERVAL_VALUE"]),'" class="size"> ',html_select("INTERVAL_FIELD",$Yd,$I["INTERVAL_FIELD"]),'<tr><th>ç‹€æ…‹<td>',html_select("STATUS",$Dh,$I["STATUS"]),'<tr><th>è¨»è§£<td><input name="EVENT_COMMENT" value="',h($I["EVENT_COMMENT"]),'" data-maxlength="64">
<tr><th><td>',checkbox("ON_COMPLETION","PRESERVE",$I["ON_COMPLETION"]=="PRESERVE",'åœ¨å®Œæˆå¾Œå„²å­˜'),'</table>
<p>';textarea("EVENT_DEFINITION",$I["EVENT_DEFINITION"]);echo'<p>
<input type="submit" value="å„²å­˜">
';if($aa!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('åˆªé™¤ %s?',$aa));}echo'<input type="hidden" name="token" value="',$S,'">
</form>
';}elseif(isset($_GET["procedure"])){$da=($_GET["name"]?$_GET["name"]:$_GET["procedure"]);$Qg=(isset($_GET["function"])?"FUNCTION":"PROCEDURE");$I=$_POST;$I["fields"]=(array)$I["fields"];if($_POST&&!process_fields($I["fields"])&&!$l){$Df=routine($_GET["procedure"],$Qg);$Xh="$I[name]_adminer_".uniqid();drop_create("DROP $Qg ".routine_id($da,$Df),create_routine($Qg,$I),"DROP $Qg ".routine_id($I["name"],$I),create_routine($Qg,array("name"=>$Xh)+$I),"DROP $Qg ".routine_id($Xh,$I),substr(ME,0,-1),'å·²åˆªé™¤ç¨‹åºã€‚','å·²ä¿®æ”¹å­ç¨‹åºã€‚','å·²å»ºç«‹å­ç¨‹åºã€‚',$da,$I["name"]);}page_header(($da!=""?(isset($_GET["function"])?'ä¿®æ”¹å‡½å¼':'ä¿®æ”¹é å­˜ç¨‹åº').": ".h($da):(isset($_GET["function"])?'å»ºç«‹å‡½å¼':'å»ºç«‹é å­˜ç¨‹åº')),$l);if(!$_POST&&$da!=""){$I=routine($_GET["procedure"],$Qg);$I["name"]=$da;}$pb=get_vals("SHOW CHARACTER SET");sort($pb);$Rg=routine_languages();echo'
<form action="" method="post" id="form">
<p>åç¨±: <input name="name" value="',h($I["name"]),'" data-maxlength="64" autocapitalize="off">
',($Rg?'èªè¨€'.": ".html_select("language",$Rg,$I["language"])."\n":""),'<input type="submit" value="å„²å­˜">
<div class="scrollable">
<table class="nowrap">
';edit_fields($I["fields"],$pb,$Qg);if(isset($_GET["function"])){echo"<tr><td>".'å›å‚³é¡å‹';edit_type("returns",$I["returns"],$pb,array(),($w=="pgsql"?array("void","trigger"):array()));}echo'</table>
',script("editFields();"),'</div>
<p>';textarea("definition",$I["definition"]);echo'<p>
<input type="submit" value="å„²å­˜">
';if($da!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('åˆªé™¤ %s?',$da));}echo'<input type="hidden" name="token" value="',$S,'">
</form>
';}elseif(isset($_GET["sequence"])){$fa=$_GET["sequence"];$I=$_POST;if($_POST&&!$l){$z=substr(ME,0,-1);$B=trim($I["name"]);if($_POST["drop"])query_redirect("DROP SEQUENCE ".idf_escape($fa),$z,'å·²åˆªé™¤åºåˆ—ã€‚');elseif($fa=="")query_redirect("CREATE SEQUENCE ".idf_escape($B),$z,'å·²å»ºç«‹åºåˆ—ã€‚');elseif($fa!=$B)query_redirect("ALTER SEQUENCE ".idf_escape($fa)." RENAME TO ".idf_escape($B),$z,'å·²ä¿®æ”¹åºåˆ—ã€‚');else
redirect($z);}page_header($fa!=""?'ä¿®æ”¹åºåˆ—'.": ".h($fa):'å»ºç«‹åºåˆ—',$l);if(!$I)$I["name"]=$fa;echo'
<form action="" method="post">
<p><input name="name" value="',h($I["name"]),'" autocapitalize="off">
<input type="submit" value="å„²å­˜">
';if($fa!="")echo"<input type='submit' name='drop' value='".'åˆªé™¤'."'>".confirm(sprintf('åˆªé™¤ %s?',$fa))."\n";echo'<input type="hidden" name="token" value="',$S,'">
</form>
';}elseif(isset($_GET["type"])){$ga=$_GET["type"];$I=$_POST;if($_POST&&!$l){$z=substr(ME,0,-1);if($_POST["drop"])query_redirect("DROP TYPE ".idf_escape($ga),$z,'å·²åˆªé™¤é¡å‹ã€‚');else
query_redirect("CREATE TYPE ".idf_escape(trim($I["name"]))." $I[as]",$z,'å·²å»ºç«‹é¡å‹ã€‚');}page_header($ga!=""?'ä¿®æ”¹é¡å‹'.": ".h($ga):'å»ºç«‹é¡å‹',$l);if(!$I)$I["as"]="AS ";echo'
<form action="" method="post">
<p>
';if($ga!="")echo"<input type='submit' name='drop' value='".'åˆªé™¤'."'>".confirm(sprintf('åˆªé™¤ %s?',$ga))."\n";else{echo"<input name='name' value='".h($I['name'])."' autocapitalize='off'>\n";textarea("as",$I["as"]);echo"<p><input type='submit' value='".'å„²å­˜'."'>\n";}echo'<input type="hidden" name="token" value="',$S,'">
</form>
';}elseif(isset($_GET["check"])){$a=$_GET["check"];$B=$_GET["name"];$I=$_POST;if($I&&!$l){$G=($B==""||queries("ALTER TABLE ".table($a)." DROP CONSTRAINT ".idf_escape($B)));if(!$I["drop"])$G=queries("ALTER TABLE ".table($a)." ADD".($I["name"]!=""?" CONSTRAINT ".idf_escape($I["name"])."":"")." CHECK ($I[clause])");queries_redirect(ME."table=".urlencode($a),($I["drop"]?'Check has been dropped.':($B!=""?'Check has been altered.':'Check has been created.')),$G);}page_header(($B!=""?'Alter check'.": ".h($B):'Create check'),$l,array("table"=>$a));if(!$I){$gb=check_constraints($a);$I=array("name"=>$B,"clause"=>$gb[$B]);}echo'
<form action="" method="post">
<p>åç¨±: <input name="name" value="',h($I["name"]),'" data-maxlength="64" autocapitalize="off">',doc_link(array('sql'=>"create-table-check-constraints.html",'mariadb'=>"constraint/",'pgsql'=>"ddl-constraints.html#DDL-CONSTRAINTS-CHECK-CONSTRAINTS",'mssql'=>"relational-databases/tables/create-check-constraints",)),'<p>';textarea("clause",$I["clause"]);echo'<p><input type="submit" value="å„²å­˜">
';if($B!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('åˆªé™¤ %s?',$B));}echo'<input type="hidden" name="token" value="',$S,'">
</form>
';}elseif(isset($_GET["trigger"])){$a=$_GET["trigger"];$B=$_GET["name"];$wi=trigger_options();$I=(array)trigger($B,$a)+array("Trigger"=>$a."_bi");if($_POST){if(!$l&&in_array($_POST["Timing"],$wi["Timing"])&&in_array($_POST["Event"],$wi["Event"])&&in_array($_POST["Type"],$wi["Type"])){$qf=" ON ".table($a);$oc="DROP TRIGGER ".idf_escape($B).($w=="pgsql"?$qf:"");$_=ME."table=".urlencode($a);if($_POST["drop"])query_redirect($oc,$_,'å·²åˆªé™¤è§¸ç™¼å™¨ã€‚');else{if($B!="")queries($oc);queries_redirect($_,($B!=""?'å·²ä¿®æ”¹è§¸ç™¼å™¨ã€‚':'å·²å»ºç«‹è§¸ç™¼å™¨ã€‚'),queries(create_trigger($qf,$_POST)));if($B!="")queries(create_trigger($qf,$I+array("Type"=>reset($wi["Type"]))));}}$I=$_POST;}page_header(($B!=""?'ä¿®æ”¹è§¸ç™¼å™¨'.": ".h($B):'å»ºç«‹è§¸ç™¼å™¨'),$l,array("table"=>$a));echo'
<form action="" method="post" id="form">
<table class="layout">
<tr><th>æ™‚é–“<td>',html_select("Timing",$wi["Timing"],$I["Timing"],"triggerChange(/^".preg_quote($a,"/")."_[ba][iud]$/, '".js_escape($a)."', this.form);"),'<tr><th>äº‹ä»¶<td>',html_select("Event",$wi["Event"],$I["Event"],"this.form['Timing'].onchange();"),(in_array("UPDATE OF",$wi["Event"])?" <input name='Of' value='".h($I["Of"])."' class='hidden'>":""),'<tr><th>é¡å‹<td>',html_select("Type",$wi["Type"],$I["Type"]),'</table>
<p>åç¨±: <input name="Trigger" value="',h($I["Trigger"]),'" data-maxlength="64" autocapitalize="off">
',script("qs('#form')['Timing'].onchange();"),'<p>';textarea("Statement",$I["Statement"]);echo'<p>
<input type="submit" value="å„²å­˜">
';if($B!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('åˆªé™¤ %s?',$B));}echo'<input type="hidden" name="token" value="',$S,'">
</form>
';}elseif(isset($_GET["user"])){$ha=$_GET["user"];$og=array(""=>array("All privileges"=>""));foreach(get_rows("SHOW PRIVILEGES")as$I){foreach(explode(",",($I["Privilege"]=="Grant option"?"":$I["Context"]))as$Gb)$og[$Gb][$I["Privilege"]]=$I["Comment"];}$og["Server Admin"]+=$og["File access on server"];$og["Databases"]["Create routine"]=$og["Procedures"]["Create routine"];unset($og["Procedures"]["Create routine"]);$og["Columns"]=array();foreach(array("Select","Insert","Update","References")as$X)$og["Columns"][$X]=$og["Tables"][$X];unset($og["Server Admin"]["Usage"]);foreach($og["Tables"]as$x=>$X)unset($og["Databases"][$x]);$Ze=array();if($_POST){foreach($_POST["objects"]as$x=>$X)$Ze[$X]=(array)$Ze[$X]+(array)$_POST["grants"][$x];}$ud=array();$of="";if(isset($_GET["host"])&&($G=$f->query("SHOW GRANTS FOR ".q($ha)."@".q($_GET["host"])))){while($I=$G->fetch_row()){if(preg_match('~GRANT (.*) ON (.*) TO ~',$I[0],$A)&&preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~',$A[1],$De,PREG_SET_ORDER)){foreach($De
as$X){if($X[1]!="USAGE")$ud["$A[2]$X[2]"][$X[1]]=true;if(preg_match('~ WITH GRANT OPTION~',$I[0]))$ud["$A[2]$X[2]"]["GRANT OPTION"]=true;}}if(preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~",$I[0],$A))$of=$A[1];}}if($_POST&&!$l){$pf=(isset($_GET["host"])?q($ha)."@".q($_GET["host"]):"''");if($_POST["drop"])query_redirect("DROP USER $pf",ME."privileges=",'å·²åˆªé™¤ä½¿ç”¨è€…ã€‚');else{$bf=q($_POST["user"])."@".q($_POST["host"]);$Wf=$_POST["pass"];if($Wf!=''&&!$_POST["hashed"]&&!min_version(8)){$Wf=$f->result("SELECT PASSWORD(".q($Wf).")");$l=!$Wf;}$Mb=false;if(!$l){if($pf!=$bf){$Mb=queries((min_version(5)?"CREATE USER":"GRANT USAGE ON *.* TO")." $bf IDENTIFIED BY ".(min_version(8)?"":"PASSWORD ").q($Wf));$l=!$Mb;}elseif($Wf!=$of)queries("SET PASSWORD FOR $bf = ".q($Wf));}if(!$l){$Ng=array();foreach($Ze
as$hf=>$td){if(isset($_GET["grant"]))$td=array_filter($td);$td=array_keys($td);if(isset($_GET["grant"]))$Ng=array_diff(array_keys(array_filter($Ze[$hf],'strlen')),$td);elseif($pf==$bf){$mf=array_keys((array)$ud[$hf]);$Ng=array_diff($mf,$td);$td=array_diff($td,$mf);unset($ud[$hf]);}if(preg_match('~^(.+)\s*(\(.*\))?$~U',$hf,$A)&&(!grant("REVOKE",$Ng,$A[2]," ON $A[1] FROM $bf")||!grant("GRANT",$td,$A[2]," ON $A[1] TO $bf"))){$l=true;break;}}}if(!$l&&isset($_GET["host"])){if($pf!=$bf)queries("DROP USER $pf");elseif(!isset($_GET["grant"])){foreach($ud
as$hf=>$Ng){if(preg_match('~^(.+)(\(.*\))?$~U',$hf,$A))grant("REVOKE",array_keys($Ng),$A[2]," ON $A[1] FROM $bf");}}}queries_redirect(ME."privileges=",(isset($_GET["host"])?'å·²ä¿®æ”¹ä½¿ç”¨è€…ã€‚':'å·²å»ºç«‹ä½¿ç”¨è€…ã€‚'),!$l);if($Mb)$f->query("DROP USER $bf");}}page_header((isset($_GET["host"])?'å¸³è™Ÿ'.": ".h("$ha@$_GET[host]"):'å»ºç«‹ä½¿ç”¨è€…'),$l,array("privileges"=>array('','æ¬Šé™')));if($_POST){$I=$_POST;$ud=$Ze;}else{$I=$_GET+array("host"=>$f->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)"));$I["pass"]=$of;if($of!="")$I["hashed"]=true;$ud[(DB==""||$ud?"":idf_escape(addcslashes(DB,"%_\\"))).".*"]=array();}echo'<form action="" method="post">
<table class="layout">
<tr><th>ä¼ºæœå™¨<td><input name="host" data-maxlength="60" value="',h($I["host"]),'" autocapitalize="off">
<tr><th>å¸³è™Ÿ<td><input name="user" data-maxlength="80" value="',h($I["user"]),'" autocapitalize="off">
<tr><th>å¯†ç¢¼<td><input name="pass" id="pass" value="',h($I["pass"]),'" autocomplete="new-password">
';if(!$I["hashed"])echo
script("typePassword(qs('#pass'));");echo(min_version(8)?"":checkbox("hashed",1,$I["hashed"],'Hashed',"typePassword(this.form['pass'], this.checked);")),'</table>

';echo"<table class='odds'>\n","<thead><tr><th colspan='2'>".'æ¬Šé™'.doc_link(array('sql'=>"grant.html#priv_level"));$s=0;foreach($ud
as$hf=>$td){echo'<th>'.($hf!="*.*"?"<input name='objects[$s]' value='".h($hf)."' size='10' autocapitalize='off'>":"<input type='hidden' name='objects[$s]' value='*.*' size='10'>*.*");$s++;}echo"</thead>\n";foreach(array(""=>"","Server Admin"=>'ä¼ºæœå™¨',"Databases"=>'è³‡æ–™åº«',"Tables"=>'è³‡æ–™è¡¨',"Columns"=>'æ¬„ä½',"Procedures"=>'ç¨‹åº',)as$Gb=>$fc){foreach((array)$og[$Gb]as$ng=>$vb){echo"<tr><td".($fc?">$fc<td":" colspan='2'").' lang="en" title="'.h($vb).'">'.h($ng);$s=0;foreach($ud
as$hf=>$td){$B="'grants[$s][".h(strtoupper($ng))."]'";$Y=$td[strtoupper($ng)];if($Gb=="Server Admin"&&$hf!=(isset($ud["*.*"])?"*.*":".*"))echo"<td>";elseif(isset($_GET["grant"]))echo"<td><select name=$B><option><option value='1'".($Y?" selected":"").">".'æˆæ¬Š'."<option value='0'".($Y=="0"?" selected":"").">".'å»¢é™¤'."</select>";else{echo"<td align='center'><label class='block'>","<input type='checkbox' name=$B value='1'".($Y?" checked":"").($ng=="All privileges"?" id='grants-$s-all'>":">".($ng=="Grant option"?"":script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$s-all'); };"))),"</label>";}$s++;}}}echo"</table>\n",'<p>
<input type="submit" value="å„²å­˜">
';if(isset($_GET["host"])){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('åˆªé™¤ %s?',"$ha@$_GET[host]"));}echo'<input type="hidden" name="token" value="',$S,'">
</form>
';}elseif(isset($_GET["processlist"])){if(support("kill")){if($_POST&&!$l){$le=0;foreach((array)$_POST["kill"]as$X){if(kill_process($X))$le++;}queries_redirect(ME."processlist=",sprintf('%d å€‹ Process(es) è¢«çµ‚æ­¢',$le),$le||!$_POST["kill"]);}}page_header('è™•ç†ç¨‹åºåˆ—è¡¨',$l);echo'
<form action="" method="post">
<div class="scrollable">
<table class="nowrap checkable odds">
',script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");$s=-1;foreach(process_list()as$s=>$I){if(!$s){echo"<thead><tr lang='en'>".(support("kill")?"<th>":"");foreach($I
as$x=>$X)echo"<th>$x".doc_link(array('sql'=>"show-processlist.html#processlist_".strtolower($x),'pgsql'=>"monitoring-stats.html#PG-STAT-ACTIVITY-VIEW",'oracle'=>"REFRN30223",));echo"</thead>\n";}echo"<tr>".(support("kill")?"<td>".checkbox("kill[]",$I[$w=="sql"?"Id":"pid"],0):"");foreach($I
as$x=>$X)echo"<td>".(($w=="sql"&&$x=="Info"&&preg_match("~Query|Killed~",$I["Command"])&&$X!="")||($w=="pgsql"&&$x=="current_query"&&$X!="<IDLE>")||($w=="oracle"&&$x=="sql_text"&&$X!="")?"<code class='jush-$w'>".shorten_utf8($X,100,"</code>").' <a href="'.h(ME.($I["db"]!=""?"db=".urlencode($I["db"])."&":"")."sql=".urlencode($X)).'">'.'è¤‡è£½'.'</a>':h($X));echo"\n";}echo'</table>
</div>
<p>
';if(support("kill")){echo($s+1)."/".sprintf('ç¸½å…± %d å€‹',max_connections()),"<p><input type='submit' value='".'çµ‚æ­¢'."'>\n";}echo'<input type="hidden" name="token" value="',$S,'">
</form>
',script("tableCheck();");}elseif(isset($_GET["select"])){$a=$_GET["select"];$Q=table_status1($a);$v=indexes($a);$n=fields($a);$md=column_foreign_keys($a);$kf=$Q["Oid"];parse_str($_COOKIE["adminer_import"],$ya);$Og=array();$e=array();$bi=null;foreach($n
as$x=>$m){$B=$b->fieldName($m);if(isset($m["privileges"]["select"])&&$B!=""){$e[$x]=html_entity_decode(strip_tags($B),ENT_QUOTES);if(is_shortable($m))$bi=$b->selectLengthProcess();}$Og+=$m["privileges"];}list($K,$vd)=$b->selectColumnsProcess($e,$v);$ce=count($vd)<count($K);$Z=$b->selectSearchProcess($n,$v);$_f=$b->selectOrderProcess($n,$v);$y=$b->selectLimitProcess();if($_GET["val"]&&is_ajax()){header("Content-Type: text/plain; charset=utf-8");foreach($_GET["val"]as$Di=>$I){$Fa=convert_field($n[key($I)]);$K=array($Fa?$Fa:idf_escape(key($I)));$Z[]=where_check($Di,$n);$H=$k->select($a,$K,$Z,$K);if($H)echo
reset($H->fetch_row());}exit;}$jg=$Fi=null;foreach($v
as$u){if($u["type"]=="PRIMARY"){$jg=array_flip($u["columns"]);$Fi=($K?$jg:array());foreach($Fi
as$x=>$X){if(in_array(idf_escape($x),$K))unset($Fi[$x]);}break;}}if($kf&&!$jg){$jg=$Fi=array($kf=>0);$v[]=array("type"=>"PRIMARY","columns"=>array($kf));}if($_POST&&!$l){$gj=$Z;if(!$_POST["all"]&&is_array($_POST["check"])){$gb=array();foreach($_POST["check"]as$cb)$gb[]=where_check($cb,$n);$gj[]="((".implode(") OR (",$gb)."))";}$gj=($gj?"\nWHERE ".implode(" AND ",$gj):"");if($_POST["export"]){adm_cookie("adminer_import","output=".urlencode($_POST["output"])."&format=".urlencode($_POST["format"]));dump_headers($a);$b->dumpTable($a,"");$qd=($K?implode(", ",$K):"*").convert_fields($e,$n,$K)."\nFROM ".table($a);$xd=($vd&&$ce?"\nGROUP BY ".implode(", ",$vd):"").($_f?"\nORDER BY ".implode(", ",$_f):"");if(!is_array($_POST["check"])||$jg)$F="SELECT $qd$gj$xd";else{$Bi=array();foreach($_POST["check"]as$X)$Bi[]="(SELECT".limit($qd,"\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$n).$xd,1).")";$F=implode(" UNION ALL ",$Bi);}$b->dumpData($a,"table",$F);exit;}if(!$b->selectEmailProcess($Z,$md)){if($_POST["save"]||$_POST["delete"]){$G=true;$za=0;$M=array();if(!$_POST["delete"]){foreach($e
as$B=>$X){$X=process_input($n[$B]);if($X!==null&&($_POST["clone"]||$X!==false))$M[idf_escape($B)]=($X!==false?$X:idf_escape($B));}}if($_POST["delete"]||$M){if($_POST["clone"])$F="INTO ".table($a)." (".implode(", ",array_keys($M)).")\nSELECT ".implode(", ",$M)."\nFROM ".table($a);if($_POST["all"]||($jg&&is_array($_POST["check"]))||$ce){$G=($_POST["delete"]?$k->delete($a,$gj):($_POST["clone"]?queries("INSERT $F$gj"):$k->update($a,$M,$gj)));$za=$f->affected_rows;}else{foreach((array)$_POST["check"]as$X){$cj="\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$n);$G=($_POST["delete"]?$k->delete($a,$cj,1):($_POST["clone"]?queries("INSERT".limit1($a,$F,$cj)):$k->update($a,$M,$cj,1)));if(!$G)break;$za+=$f->affected_rows;}}}$Me=sprintf('%d å€‹é …ç›®å—åˆ°å½±éŸ¿ã€‚',$za);if($_POST["clone"]&&$G&&$za==1){$qe=last_id();if($qe)$Me=sprintf('å·²æ–°å¢é …ç›® %sã€‚'," $qe");}queries_redirect(remove_from_uri($_POST["all"]&&$_POST["delete"]?"page":""),$Me,$G);if(!$_POST["delete"]){edit_form($a,$n,(array)$_POST["fields"],!$_POST["clone"]);page_footer();exit;}}elseif(!$_POST["import"]){if(!$_POST["val"])$l='æŒ‰ä½Ctrlä¸¦æŒ‰ä¸€ä¸‹æŸå€‹å€¼é€²è¡Œä¿®æ”¹ã€‚';else{$G=true;$za=0;foreach($_POST["val"]as$Di=>$I){$M=array();foreach($I
as$x=>$X){$x=bracket_escape($x,1);$M[idf_escape($x)]=(preg_match('~char|text~',$n[$x]["type"])||$X!=""?$b->processInput($n[$x],$X):"NULL");}$G=$k->update($a,$M," WHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($Di,$n),!$ce&&!$jg," ");if(!$G)break;$za+=$f->affected_rows;}queries_redirect(remove_from_uri(),sprintf('%d å€‹é …ç›®å—åˆ°å½±éŸ¿ã€‚',$za),$G);}}elseif(!is_string($bd=get_file("csv_file",true)))$l=upload_error($bd);elseif(!preg_match('~~u',$bd))$l='æª”å¿…é ˆä½¿ç”¨UTF-8ç·¨ç¢¼ã€‚';else{adm_cookie("adminer_import","output=".urlencode($ya["output"])."&format=".urlencode($_POST["separator"]));$G=true;$rb=array_keys($n);preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~',$bd,$De);$za=count($De[0]);$k->begin();$eh=($_POST["separator"]=="csv"?",":($_POST["separator"]=="tsv"?"\t":";"));$J=array();foreach($De[0]as$x=>$X){preg_match_all("~((?>\"[^\"]*\")+|[^$eh]*)$eh~",$X.$eh,$Ee);if(!$x&&!array_diff($Ee[1],$rb)){$rb=$Ee[1];$za--;}else{$M=array();foreach($Ee[1]as$s=>$mb)$M[idf_escape($rb[$s])]=($mb==""&&$n[$rb[$s]]["null"]?"NULL":q(str_replace('""','"',preg_replace('~^"|"$~','',$mb))));$J[]=$M;}}$G=(!$J||$k->insertUpdate($a,$J,$jg));if($G)$G=$k->commit();queries_redirect(remove_from_uri("page"),sprintf('å·²åŒ¯å…¥ %d è¡Œã€‚',$za),$G);$k->rollback();}}}$Nh=$b->tableName($Q);if(is_ajax()){page_headers();ob_start();}else
page_header('é¸æ“‡'.": $Nh",$l);$M=null;if(isset($Og["insert"])||!support("table")){$Pf=array();foreach((array)$_GET["where"]as$X){if(isset($md[$X["col"]])&&count($md[$X["col"]])==1&&($X["op"]=="="||(!$X["op"]&&(is_array($X["val"])||!preg_match('~[_%]~',$X["val"])))))$Pf["set"."[".bracket_escape($X["col"])."]"]=$X["val"];}$M=$Pf?"&".http_build_query($Pf):"";}$b->selectLinks($Q,$M);if(!$e&&support("table"))echo"<p class='error'>".'ç„¡æ³•é¸æ“‡è©²è³‡æ–™è¡¨'.($n?".":": ".error())."\n";else{echo"<form action='' id='form'>\n","<div style='display: none;'>";hidden_fields_get();echo(DB!=""?'<input type="hidden" name="db" value="'.h(DB).'">'.(isset($_GET["ns"])?'<input type="hidden" name="ns" value="'.h($_GET["ns"]).'">':""):"");echo'<input type="hidden" name="select" value="'.h($a).'">',"</div>\n";$b->selectColumnsPrint($K,$e);$b->selectSearchPrint($Z,$e,$v);$b->selectOrderPrint($_f,$e,$v);$b->selectLimitPrint($y);$b->selectLengthPrint($bi);$b->selectActionPrint($v);echo"</form>\n";$D=$_GET["page"];if($D=="last"){$pd=$f->result(count_rows($a,$Z,$ce,$vd));$D=floor(max(0,$pd-1)/$y);}$Zg=$K;$wd=$vd;if(!$Zg){$Zg[]="*";$Hb=convert_fields($e,$n,$K);if($Hb)$Zg[]=substr($Hb,2);}foreach($K
as$x=>$X){$m=$n[idf_unescape($X)];if($m&&($Fa=convert_field($m)))$Zg[$x]="$Fa AS $X";}if(!$ce&&$Fi){foreach($Fi
as$x=>$X){$Zg[]=idf_escape($x);if($wd)$wd[]=idf_escape($x);}}$G=$k->select($a,$Zg,$Z,$wd,$_f,$y,$D,true);if(!$G)echo"<p class='error'>".error()."\n";else{if($w=="mssql"&&$D)$G->seek($y*$D);$Ac=array();echo"<form action='' method='post' enctype='multipart/form-data'>\n";$J=array();while($I=$G->fetch_assoc()){if($D&&$w=="oracle")unset($I["RNUM"]);$J[]=$I;}if($_GET["page"]!="last"&&$y!=""&&$vd&&$ce&&$w=="sql")$pd=$f->result(" SELECT FOUND_ROWS()");if(!$J)echo"<p class='message'>".'æ²’æœ‰è³‡æ–™è¡Œã€‚'."\n";else{$Oa=$b->backwardKeys($a,$Nh);echo"<div class='scrollable'>","<table id='table' class='nowrap checkable odds'>",script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"),"<thead><tr>".(!$vd&&$K?"":"<td><input type='checkbox' id='all-page' class='jsonly'>".script("qs('#all-page').onclick = partial(formCheck, /check/);","")." <a href='".h($_GET["modify"]?remove_from_uri("modify"):$_SERVER["REQUEST_URI"]."&modify=1")."'>".'ä¿®æ”¹'."</a>");$Xe=array();$rd=array();reset($K);$xg=1;foreach($J[0]as$x=>$X){if(!isset($Fi[$x])){$X=$_GET["columns"][key($K)];$m=$n[$K?($X?$X["col"]:current($K)):$x];$B=($m?$b->fieldName($m,$xg):($X["fun"]?"*":h($x)));if($B!=""){$xg++;$Xe[$x]=$B;$d=idf_escape($x);$Id=remove_from_uri('(order|desc)[^=]*|page').'&order%5B0%5D='.urlencode($x);$fc="&desc%5B0%5D=1";echo"<th id='th[".h(bracket_escape($x))."]'>".script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});",""),'<a href="'.h($Id.($_f[0]==$d||$_f[0]==$x||(!$_f&&$ce&&$vd[0]==$d)?$fc:'')).'">';echo
apply_sql_function($X["fun"],$B)."</a>";echo"<span class='column hidden'>","<a href='".h($Id.$fc)."' title='".'é™å†ª (éæ¸›)'."' class='text'> â†“</a>";if(!$X["fun"]){echo'<a href="#fieldset-search" title="'.'æœå°‹'.'" class="text jsonly"> =</a>',script("qsl('a').onclick = partial(selectSearch, '".js_escape($x)."');");}echo"</span>";}$rd[$x]=$X["fun"];next($K);}}$we=array();if($_GET["modify"]){foreach($J
as$I){foreach($I
as$x=>$X)$we[$x]=max($we[$x],min(40,strlen(utf8_decode($X))));}}echo($Oa?"<th>".'é—œè¯':"")."</thead>\n";if(is_ajax())ob_end_clean();foreach($b->rowDescriptions($J,$md)as$We=>$I){$Ci=unique_array($J[$We],$v);if(!$Ci){$Ci=array();foreach($J[$We]as$x=>$X){if(!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~',$x))$Ci[$x]=$X;}}$Di="";foreach($Ci
as$x=>$X){if(($w=="sql"||$w=="pgsql")&&preg_match('~char|text|enum|set~',$n[$x]["type"])&&strlen($X)>64){$x=(strpos($x,'(')?$x:idf_escape($x));$x="MD5(".($w!='sql'||preg_match("~^utf8~",$n[$x]["collation"])?$x:"CONVERT($x USING ".charset($f).")").")";$X=md5($X);}$Di.="&".($X!==null?urlencode("where[".bracket_escape($x)."]")."=".urlencode($X===false?"f":$X):"null%5B%5D=".urlencode($x));}echo"<tr>".(!$vd&&$K?"":"<td>".checkbox("check[]",substr($Di,1),in_array(substr($Di,1),(array)$_POST["check"])).($ce||information_schema(DB)?"":" <a href='".h(ME."edit=".urlencode($a).$Di)."' class='edit'>".'ç·¨è¼¯'."</a>"));foreach($I
as$x=>$X){if(isset($Xe[$x])){$m=$n[$x];$X=$k->value($X,$m);if($X!=""&&(!isset($Ac[$x])||$Ac[$x]!=""))$Ac[$x]=(is_mail($X)?$Xe[$x]:"");$z="";if(preg_match('~blob|bytea|raw|file~',$m["type"])&&$X!="")$z=ME.'download='.urlencode($a).'&field='.urlencode($x).$Di;if(!$z&&$X!==null){foreach((array)$md[$x]as$p){if(count($md[$x])==1||end($p["source"])==$x){$z="";foreach($p["source"]as$s=>$uh)$z.=where_link($s,$p["target"][$s],$J[$We][$uh]);$z=($p["db"]!=""?preg_replace('~([?&]db=)[^&]+~','\1'.urlencode($p["db"]),ME):ME).'select='.urlencode($p["table"]).$z;if($p["ns"])$z=preg_replace('~([?&]ns=)[^&]+~','\1'.urlencode($p["ns"]),$z);if(count($p["source"])==1)break;}}}if($x=="COUNT(*)"){$z=ME."select=".urlencode($a);$s=0;foreach((array)$_GET["where"]as$W){if(!array_key_exists($W["col"],$Ci))$z.=where_link($s++,$W["col"],$W["val"],$W["op"]);}foreach($Ci
as$he=>$W)$z.=where_link($s++,$he,$W);}$X=select_value($X,$z,$m,$bi);$Jd=h("val[$Di][".bracket_escape($x)."]");$Y=$_POST["val"][$Di][bracket_escape($x)];$wc=!is_array($I[$x])&&is_utf8($X)&&$J[$We][$x]==$I[$x]&&!$rd[$x];$Zh=preg_match('~text|lob~',$m["type"]);echo"<td id='$Jd'";if(($_GET["modify"]&&$wc)||$Y!==null){$_d=h($Y!==null?$Y:$I[$x]);echo">".($Zh?"<textarea name='$Jd' cols='30' rows='".(substr_count($I[$x],"\n")+1)."'>$_d</textarea>":"<input name='$Jd' value='$_d' size='$we[$x]'>");}else{$_e=strpos($X,"<i>â€¦</i>");echo" data-text='".($_e?2:($Zh?1:0))."'".($wc?"":" data-warning='".h('ä½¿ç”¨ç·¨è¼¯é€£çµä¾†ä¿®æ”¹ã€‚')."'").">$X</td>";}}}if($Oa)echo"<td>";$b->backwardKeysPrint($Oa,$J[$We]);echo"</tr>\n";}if(is_ajax())exit;echo"</table>\n","</div>\n";}if(!is_ajax()){if($J||$D){$Mc=true;if($_GET["page"]!="last"){if($y==""||(count($J)<$y&&($J||!$D)))$pd=($D?$D*$y:0)+count($J);elseif($w!="sql"||!$ce){$pd=($ce?false:found_rows($Q,$Z));if($pd<max(1e4,2*($D+1)*$y))$pd=reset(slow_query(count_rows($a,$Z,$ce,$vd)));else$Mc=false;}}$Nf=($y!=""&&($pd===false||$pd>$y||$D));if($Nf){echo(($pd===false?count($J)+1:$pd-$D*$y)>$y?'<p><a href="'.h(remove_from_uri("page")."&page=".($D+1)).'" class="loadmore">'.'è¼‰å…¥æ›´å¤šè³‡æ–™'.'</a>'.script("qsl('a').onclick = partial(selectLoadMore, ".(+$y).", '".'è¼‰å…¥ä¸­'."â€¦');",""):''),"\n";}}echo"<div class='footer'><div>\n";if($J||$D){if($Nf){$Ge=($pd===false?$D+(count($J)>=$y?2:1):floor(($pd-1)/$y));echo"<fieldset>";if($w!="simpledb"){echo"<legend><a href='".h(remove_from_uri("page"))."'>".'é '."</a></legend>",script("qsl('a').onclick = function () { pageClick(this.href, +prompt('".'é '."', '".($D+1)."')); return false; };"),pagination(0,$D).($D>5?" â€¦":"");for($s=max(1,$D-4);$s<min($Ge,$D+5);$s++)echo
pagination($s,$D);if($Ge>0){echo($D+5<$Ge?" â€¦":""),($Mc&&$pd!==false?pagination($Ge,$D):" <a href='".h(remove_from_uri("page")."&page=last")."' title='~$Ge'>".'æœ€å¾Œä¸€é '."</a>");}}else{echo"<legend>".'é '."</legend>",pagination(0,$D).($D>1?" â€¦":""),($D?pagination($D,$D):""),($Ge>$D?pagination($D+1,$D).($Ge>$D+1?" â€¦":""):"");}echo"</fieldset>\n";}echo"<fieldset>","<legend>".'æ‰€æœ‰çµæœ'."</legend>";$lc=($Mc?"":"~ ").$pd;echo
checkbox("all",1,0,($pd!==false?($Mc?"":"~ ").sprintf('%d è¡Œ',$pd):""),"var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$lc' : checked); selectCount('selected2', this.checked || !checked ? '$lc' : checked);")."\n","</fieldset>\n";if($b->selectCommandPrint()){echo'<fieldset',($_GET["modify"]?'':' class="jsonly"'),'><legend>ä¿®æ”¹</legend><div>
<input type="submit" value="å„²å­˜"',($_GET["modify"]?'':' title="'.'æŒ‰ä½Ctrlä¸¦æŒ‰ä¸€ä¸‹æŸå€‹å€¼é€²è¡Œä¿®æ”¹ã€‚'.'"'),'>
</div></fieldset>
<fieldset><legend>å·²é¸ä¸­ <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="ç·¨è¼¯">
<input type="submit" name="clone" value="è¤‡è£½">
<input type="submit" name="delete" value="åˆªé™¤">',confirm(),'</div></fieldset>
';}$nd=$b->dumpFormat();foreach((array)$_GET["columns"]as$d){if($d["fun"]){unset($nd['sql']);break;}}if($nd){print_fieldset("export",'åŒ¯å‡º'." <span id='selected2'></span>");$Kf=$b->dumpOutput();echo($Kf?html_select("output",$Kf,$ya["output"])." ":""),html_select("format",$nd,$ya["format"])," <input type='submit' name='export' value='".'åŒ¯å‡º'."'>\n","</div></fieldset>\n";}$b->selectEmailPrint(array_filter($Ac,'strlen'),$e);}echo"</div></div>\n";if($b->selectImportPrint()){echo"<div>","<a href='#import'>".'åŒ¯å…¥'."</a>",script("qsl('a').onclick = partial(toggle, 'import');",""),"<span id='import' class='hidden'>: ","<input type='file' name='csv_file'> ",html_select("separator",array("csv"=>"CSV,","csv;"=>"CSV;","tsv"=>"TSV"),$ya["format"],1);echo" <input type='submit' name='import' value='".'åŒ¯å…¥'."'>","</span>","</div>";}echo"<input type='hidden' name='token' value='$S'>\n","</form>\n",(!$vd&&$K?"":script("tableCheck();"));}}}if(is_ajax()){ob_end_clean();exit;}}elseif(isset($_GET["variables"])){$N=isset($_GET["status"]);page_header($N?'ç‹€æ…‹':'è®Šæ•¸');$Ti=($N?show_status():show_variables());if(!$Ti)echo"<p class='message'>".'æ²’æœ‰è³‡æ–™è¡Œã€‚'."\n";else{echo"<table>\n";foreach($Ti
as$x=>$X){echo"<tr>","<th><code class='jush-".$w.($N?"status":"set")."'>".h($x)."</code>","<td>".h($X);}echo"</table>\n";}}elseif(isset($_GET["script"])){header("Content-Type: text/javascript; charset=utf-8");if($_GET["script"]=="db"){$Kh=array("Data_length"=>0,"Index_length"=>0,"Data_free"=>0);foreach(table_status()as$B=>$Q){json_row("Comment-$B",h($Q["Comment"]));if(!is_view($Q)){foreach(array("Engine","Collation")as$x)json_row("$x-$B",h($Q[$x]));foreach($Kh+array("Auto_increment"=>0,"Rows"=>0)as$x=>$X){if($Q[$x]!=""){$X=format_number($Q[$x]);json_row("$x-$B",($x=="Rows"&&$X&&$Q["Engine"]==($w=="pgsql"?"table":"InnoDB")?"~ $X":$X));if(isset($Kh[$x]))$Kh[$x]+=($Q["Engine"]!="InnoDB"||$x!="Data_free"?$Q[$x]:0);}elseif(array_key_exists($x,$Q))json_row("$x-$B");}}}foreach($Kh
as$x=>$X)json_row("sum-$x",format_number($X));json_row("");}elseif($_GET["script"]=="kill")$f->query("KILL ".number($_POST["kill"]));else{foreach(count_tables($b->databases())as$j=>$X){json_row("tables-$j",$X);json_row("size-$j",db_size($j));}json_row("");}exit;}else{$Th=array_merge((array)$_POST["tables"],(array)$_POST["views"]);if($Th&&!$l&&!$_POST["search"]){$G=true;$Me="";if($w=="sql"&&$_POST["tables"]&&count($_POST["tables"])>1&&($_POST["drop"]||$_POST["truncate"]||$_POST["copy"]))queries("SET foreign_key_checks = 0");if($_POST["truncate"]){if($_POST["tables"])$G=truncate_tables($_POST["tables"]);$Me='å·²æ¸…ç©ºè³‡æ–™è¡¨ã€‚';}elseif($_POST["move"]){$G=move_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Me='å·²è½‰ç§»è³‡æ–™è¡¨ã€‚';}elseif($_POST["copy"]){$G=copy_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Me='è³‡æ–™è¡¨å·²ç¶“è¤‡è£½';}elseif($_POST["drop"]){if($_POST["views"])$G=drop_views($_POST["views"]);if($G&&$_POST["tables"])$G=drop_tables($_POST["tables"]);$Me='å·²ç¶“å°‡è³‡æ–™è¡¨åˆªé™¤ã€‚';}elseif($w!="sql"){$G=($w=="sqlite"?queries("VACUUM"):apply_queries("VACUUM".($_POST["optimize"]?"":" ANALYZE"),$_POST["tables"]));$Me='å·²å„ªåŒ–è³‡æ–™è¡¨ã€‚';}elseif(!$_POST["tables"])$Me='æ²’æœ‰è³‡æ–™è¡¨ã€‚';elseif($G=queries(($_POST["optimize"]?"OPTIMIZE":($_POST["check"]?"CHECK":($_POST["repair"]?"REPAIR":"ANALYZE")))." TABLE ".implode(", ",array_map('idf_escape',$_POST["tables"])))){while($I=$G->fetch_assoc())$Me.="<b>".h($I["Table"])."</b>: ".h($I["Msg_text"])."<br>";}queries_redirect(substr(ME,0,-1),$Me,$G);}page_header(($_GET["ns"]==""?'è³‡æ–™åº«'.": ".h(DB):'è³‡æ–™è¡¨çµæ§‹'.": ".h($_GET["ns"])),$l,true);if($b->homepage()){if($_GET["ns"]!==""){echo"<h3 id='tables-views'>".'è³‡æ–™è¡¨å’Œæª¢è¦–è¡¨'."</h3>\n";$Sh=tables_list();if(!$Sh)echo"<p class='message'>".'æ²’æœ‰è³‡æ–™è¡¨ã€‚'."\n";else{echo"<form action='' method='post'>\n";if(support("table")){echo"<fieldset><legend>".'åœ¨è³‡æ–™åº«æœå°‹'." <span id='selected2'></span></legend><div>","<input type='search' name='query' value='".h($_POST["query"])."'>",script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');","")," <input type='submit' name='search' value='".'æœå°‹'."'>\n","</div></fieldset>\n";if($_POST["search"]&&$_POST["query"]!=""){$_GET["where"][0]["op"]=$k->convertOperator("LIKE %%");search_tables();}}echo"<div class='scrollable'>\n","<table class='nowrap checkable odds'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),'<thead><tr class="wrap">','<td><input id="check-all" type="checkbox" class="jsonly">'.script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);",""),'<th>'.'è³‡æ–™è¡¨','<td>'.'å¼•æ“'.doc_link(array('sql'=>'storage-engines.html')),'<td>'.'æ ¡å°'.doc_link(array('sql'=>'charset-charsets.html','mariadb'=>'supported-character-sets-and-collations/')),'<td>'.'è³‡æ–™é•·åº¦'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT','oracle'=>'REFRN20286')),'<td>'.'ç´¢å¼•é•·åº¦'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT')),'<td>'.'è³‡æ–™ç©ºé–’'.doc_link(array('sql'=>'show-table-status.html')),'<td>'.'è‡ªå‹•éå¢'.doc_link(array('sql'=>'example-auto-increment.html','mariadb'=>'auto_increment/')),'<td>'.'è¡Œæ•¸'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'catalog-pg-class.html#CATALOG-PG-CLASS','oracle'=>'REFRN20286')),(support("comment")?'<td>'.'è¨»è§£'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-info.html#FUNCTIONS-INFO-COMMENT-TABLE')):''),"</thead>\n";$R=0;foreach($Sh
as$B=>$T){$Wi=($T!==null&&!preg_match('~table|sequence~i',$T));$Jd=h("Table-".$B);echo'<tr><td>'.checkbox(($Wi?"views[]":"tables[]"),$B,in_array($B,$Th,true),"","","",$Jd),'<th>'.(support("table")||support("indexes")?"<a href='".h(ME)."table=".urlencode($B)."' title='".'é¡¯ç¤ºçµæ§‹'."' id='$Jd'>".h($B).'</a>':h($B));if($Wi){echo'<td colspan="6"><a href="'.h(ME)."view=".urlencode($B).'" title="'.'ä¿®æ”¹æª¢è¦–è¡¨'.'">'.(preg_match('~materialized~i',$T)?'ç‰©åŒ–è¦–åœ–':'æª¢è¦–è¡¨').'</a>','<td align="right"><a href="'.h(ME)."select=".urlencode($B).'" title="'.'é¸æ“‡è³‡æ–™'.'">?</a>';}else{foreach(array("Engine"=>array(),"Collation"=>array(),"Data_length"=>array("create",'ä¿®æ”¹è³‡æ–™è¡¨'),"Index_length"=>array("indexes",'ä¿®æ”¹ç´¢å¼•'),"Data_free"=>array("edit",'æ–°å¢é …ç›®'),"Auto_increment"=>array("auto_increment=1&create",'ä¿®æ”¹è³‡æ–™è¡¨'),"Rows"=>array("select",'é¸æ“‡è³‡æ–™'),)as$x=>$z){$Jd=" id='$x-".h($B)."'";echo($z?"<td align='right'>".(support("table")||$x=="Rows"||(support("indexes")&&$x!="Data_length")?"<a href='".h(ME."$z[0]=").urlencode($B)."'$Jd title='$z[1]'>?</a>":"<span$Jd>?</span>"):"<td id='$x-".h($B)."'>");}$R++;}echo(support("comment")?"<td id='Comment-".h($B)."'>":""),"\n";}echo"<tr><td><th>".sprintf('ç¸½å…± %d å€‹',count($Sh)),"<td>".h($w=="sql"?$f->result("SELECT @@default_storage_engine"):""),"<td>".h(db_collation(DB,collations()));foreach(array("Data_length","Index_length","Data_free")as$x)echo"<td align='right' id='sum-$x'>";echo"\n","</table>\n","</div>\n";if(!information_schema(DB)){echo"<div class='footer'><div>\n";$Qi="<input type='submit' value='".'æ•´ç†ï¼ˆVacuumï¼‰'."'> ".on_help("'VACUUM'");$xf="<input type='submit' name='optimize' value='".'æœ€ä½³åŒ–'."'> ".on_help($w=="sql"?"'OPTIMIZE TABLE'":"'VACUUM OPTIMIZE'");echo"<fieldset><legend>".'å·²é¸ä¸­'." <span id='selected'></span></legend><div>".($w=="sqlite"?$Qi:($w=="pgsql"?$Qi.$xf:($w=="sql"?"<input type='submit' value='".'åˆ†æ'."'> ".on_help("'ANALYZE TABLE'").$xf."<input type='submit' name='check' value='".'æª¢æŸ¥'."'> ".on_help("'CHECK TABLE'")."<input type='submit' name='repair' value='".'ä¿®å¾©'."'> ".on_help("'REPAIR TABLE'"):"")))."<input type='submit' name='truncate' value='".'æ¸…ç©º'."'> ".on_help($w=="sqlite"?"'DELETE'":"'TRUNCATE".($w=="pgsql"?"'":" TABLE'")).confirm()."<input type='submit' name='drop' value='".'åˆªé™¤'."'>".on_help("'DROP TABLE'").confirm()."\n";$i=(support("scheme")?$b->schemas():$b->databases());if(count($i)!=1&&$w!="sqlite"){$j=(isset($_POST["target"])?$_POST["target"]:(support("scheme")?$_GET["ns"]:DB));echo"<p>".'è½‰ç§»åˆ°å…¶å®ƒè³‡æ–™åº«'.": ",($i?html_select("target",$i,$j):'<input name="target" value="'.h($j).'" autocapitalize="off">')," <input type='submit' name='move' value='".'è½‰ç§»'."'>",(support("copy")?" <input type='submit' name='copy' value='".'è¤‡è£½'."'> ".checkbox("overwrite",1,$_POST["overwrite"],'è¦†è“‹'):""),"\n";}echo"<input type='hidden' name='all' value=''>";echo
script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));".(support("table")?" selectCount('selected2', formChecked(this, /^tables\[/) || $R);":"")." }"),"<input type='hidden' name='token' value='$S'>\n","</div></fieldset>\n","</div></div>\n";}echo"</form>\n",script("tableCheck();");}echo'<p class="links"><a href="'.h(ME).'create=">'.'å»ºç«‹è³‡æ–™è¡¨'."</a>\n",(support("view")?'<a href="'.h(ME).'view=">'.'å»ºç«‹æª¢è¦–è¡¨'."</a>\n":"");if(support("routine")){echo"<h3 id='routines'>".'ç¨‹åº'."</h3>\n";$Sg=routines();if($Sg){echo"<table class='odds'>\n",'<thead><tr><th>'.'åç¨±'.'<td>'.'é¡å‹'.'<td>'.'å›å‚³é¡å‹'."<td></thead>\n";foreach($Sg
as$I){$B=($I["SPECIFIC_NAME"]==$I["ROUTINE_NAME"]?"":"&name=".urlencode($I["ROUTINE_NAME"]));echo'<tr>','<th><a href="'.h(ME.($I["ROUTINE_TYPE"]!="PROCEDURE"?'callf=':'call=').urlencode($I["SPECIFIC_NAME"]).$B).'">'.h($I["ROUTINE_NAME"]).'</a>','<td>'.h($I["ROUTINE_TYPE"]),'<td>'.h($I["DTD_IDENTIFIER"]),'<td><a href="'.h(ME.($I["ROUTINE_TYPE"]!="PROCEDURE"?'function=':'procedure=').urlencode($I["SPECIFIC_NAME"]).$B).'">'.'ä¿®æ”¹'."</a>";}echo"</table>\n";}echo'<p class="links">'.(support("procedure")?'<a href="'.h(ME).'procedure=">'.'å»ºç«‹é å­˜ç¨‹åº'.'</a>':'').'<a href="'.h(ME).'function=">'.'å»ºç«‹å‡½å¼'."</a>\n";}if(support("sequence")){echo"<h3 id='sequences'>".'åºåˆ—'."</h3>\n";$hh=get_vals("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = current_schema() ORDER BY sequence_name");if($hh){echo"<table class='odds'>\n","<thead><tr><th>".'åç¨±'."</thead>\n";foreach($hh
as$X)echo"<tr><th><a href='".h(ME)."sequence=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."sequence='>".'å»ºç«‹åºåˆ—'."</a>\n";}if(support("type")){echo"<h3 id='user-types'>".'ä½¿ç”¨è€…é¡å‹'."</h3>\n";$Oi=types();if($Oi){echo"<table class='odds'>\n","<thead><tr><th>".'åç¨±'."</thead>\n";foreach($Oi
as$X)echo"<tr><th><a href='".h(ME)."type=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."type='>".'å»ºç«‹é¡å‹'."</a>\n";}if(support("event")){echo"<h3 id='events'>".'äº‹ä»¶'."</h3>\n";$J=get_rows("SHOW EVENTS");if($J){echo"<table>\n","<thead><tr><th>".'åç¨±'."<td>".'æ’ç¨‹'."<td>".'é–‹å§‹'."<td>".'çµæŸ'."<td></thead>\n";foreach($J
as$I){echo"<tr>","<th>".h($I["Name"]),"<td>".($I["Execute at"]?'åœ¨æŒ‡å®šæ™‚é–“'."<td>".$I["Execute at"]:'æ¯'." ".$I["Interval value"]." ".$I["Interval field"]."<td>$I[Starts]"),"<td>$I[Ends]",'<td><a href="'.h(ME).'event='.urlencode($I["Name"]).'">'.'ä¿®æ”¹'.'</a>';}echo"</table>\n";$Kc=$f->result("SELECT @@event_scheduler");if($Kc&&$Kc!="ON")echo"<p class='error'><code class='jush-sqlset'>event_scheduler</code>: ".h($Kc)."\n";}echo'<p class="links"><a href="'.h(ME).'event=">'.'å»ºç«‹äº‹ä»¶'."</a>\n";}if($Sh)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}}}page_footer();