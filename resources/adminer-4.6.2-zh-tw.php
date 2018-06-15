<?php
/** Adminer - Compact database management
* @link https://www.adminer.org/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
* @version 4.6.2
*/error_reporting(6135);$Uc=!preg_match('~^(unsafe_raw)?$~',ini_get("filter.default"));if($Uc||ini_get("filter.default_flags")){foreach(array('_GET','_POST','_COOKIE','_SERVER')as$X){$xi=filter_input_array(constant("INPUT$X"),FILTER_UNSAFE_RAW);if($xi)$$X=$xi;}}if(function_exists("mb_internal_encoding"))mb_internal_encoding("8bit");function
connection(){global$f;return$f;}function
adminer(){global$b;return$b;}function
version(){global$ia;return$ia;}function
idf_unescape($u){$he=substr($u,-1);return
str_replace($he.$he,$he,substr($u,1,-1));}function
escape_string($X){return
substr(q($X),1,-1);}function
number($X){return
preg_replace('~[^0-9]+~','',$X);}function
number_type(){return'((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';}function
remove_slashes($hg,$Uc=false){if(get_magic_quotes_gpc()){while(list($y,$X)=each($hg)){foreach($X
as$Xd=>$W){unset($hg[$y][$Xd]);if(is_array($W)){$hg[$y][stripslashes($Xd)]=$W;$hg[]=&$hg[$y][stripslashes($Xd)];}else$hg[$y][stripslashes($Xd)]=($Uc?$W:stripslashes($W));}}}}function
bracket_escape($u,$Na=false){static$hi=array(':'=>':1',']'=>':2','['=>':3','"'=>':4');return
strtr($u,($Na?array_flip($hi):$hi));}function
min_version($Ni,$ve="",$g=null){global$f;if(!$g)$g=$f;$ch=$g->server_info;if($ve&&preg_match('~([\d.]+)-MariaDB~',$ch,$B)){$ch=$B[1];$Ni=$ve;}return(version_compare($ch,$Ni)>=0);}function
charset($f){return(min_version("5.5.3",0,$f)?"utf8mb4":"utf8");}function
script($lh,$gi="\n"){return"<script".nonce().">$lh</script>$gi";}function
script_src($Bi){return"<script src='".h($Bi)."'".nonce()."></script>\n";}function
nonce(){return' nonce="'.get_nonce().'"';}function
target_blank(){return' target="_blank" rel="noreferrer noopener"';}function
h($Q){return
str_replace("\0","&#0;",htmlspecialchars($Q,ENT_QUOTES,'utf-8'));}function
nbsp($Q){return(trim($Q)!=""?h($Q):"&nbsp;");}function
nl_br($Q){return
str_replace("\n","<br>",$Q);}function
checkbox($C,$Y,$eb,$ee="",$jf="",$jb="",$fe=""){$I="<input type='checkbox' name='$C' value='".h($Y)."'".($eb?" checked":"").($fe?" aria-labelledby='$fe'":"").">".($jf?script("qsl('input').onclick = function () { $jf };",""):"");return($ee!=""||$jb?"<label".($jb?" class='$jb'":"").">$I".h($ee)."</label>":$I);}function
optionlist($pf,$Wg=null,$Fi=false){$I="";foreach($pf
as$Xd=>$W){$qf=array($Xd=>$W);if(is_array($W)){$I.='<optgroup label="'.h($Xd).'">';$qf=$W;}foreach($qf
as$y=>$X)$I.='<option'.($Fi||is_string($y)?' value="'.h($y).'"':'').(($Fi||is_string($y)?(string)$y:$X)===$Wg?' selected':'').'>'.h($X);if(is_array($W))$I.='</optgroup>';}return$I;}function
html_select($C,$pf,$Y="",$if=true,$fe=""){if($if)return"<select name='".h($C)."'".($fe?" aria-labelledby='$fe'":"").">".optionlist($pf,$Y)."</select>".(is_string($if)?script("qsl('select').onchange = function () { $if };",""):"");$I="";foreach($pf
as$y=>$X)$I.="<label><input type='radio' name='".h($C)."' value='".h($y)."'".($y==$Y?" checked":"").">".h($X)."</label>";return$I;}function
select_input($Ja,$pf,$Y="",$if="",$Tf=""){$Lh=($pf?"select":"input");return"<$Lh$Ja".($pf?"><option value=''>$Tf".optionlist($pf,$Y,true)."</select>":" size='10' value='".h($Y)."' placeholder='$Tf'>").($if?script("qsl('$Lh').onchange = $if;",""):"");}function
confirm($Ee="",$Xg="qsl('input')"){return
script("$Xg.onclick = function () { return confirm('".($Ee?js_escape($Ee):'ä½ ç¢ºå®šå—ï¼Ÿ')."'); };","");}function
print_fieldset($t,$me,$Qi=false){echo"<fieldset><legend>","<a href='#fieldset-$t'>$me</a>",script("qsl('a').onclick = partial(toggle, 'fieldset-$t');",""),"</legend>","<div id='fieldset-$t'".($Qi?"":" class='hidden'").">\n";}function
bold($Va,$jb=""){return($Va?" class='active $jb'":($jb?" class='$jb'":""));}function
odd($I=' class="odd"'){static$s=0;if(!$I)$s=-1;return($s++%2?$I:'');}function
js_escape($Q){return
addcslashes($Q,"\r\n'\\/");}function
json_row($y,$X=null){static$Vc=true;if($Vc)echo"{";if($y!=""){echo($Vc?"":",")."\n\t\"".addcslashes($y,"\r\n\t\"\\/").'": '.($X!==null?'"'.addcslashes($X,"\r\n\"\\/").'"':'null');$Vc=false;}else{echo"\n}\n";$Vc=true;}}function
ini_bool($Kd){$X=ini_get($Kd);return(preg_match('~^(on|true|yes)$~i',$X)||(int)$X);}function
sid(){static$I;if($I===null)$I=(SID&&!($_COOKIE&&ini_bool("session.use_cookies")));return$I;}function
set_password($Mi,$N,$V,$F){$_SESSION["pwds"][$Mi][$N][$V]=($_COOKIE["adminer_key"]&&is_string($F)?array(encrypt_string($F,$_COOKIE["adminer_key"])):$F);}function
get_password(){$I=get_session("pwds");if(is_array($I))$I=($_COOKIE["adminer_key"]?decrypt_string($I[0],$_COOKIE["adminer_key"]):false);return$I;}function
q($Q){global$f;return$f->quote($Q);}function
get_vals($G,$d=0){global$f;$I=array();$H=$f->query($G);if(is_object($H)){while($J=$H->fetch_row())$I[]=$J[$d];}return$I;}function
get_key_vals($G,$g=null,$Uh=0,$fh=true){global$f;if(!is_object($g))$g=$f;$I=array();$g->timeout=$Uh;$H=$g->query($G);$g->timeout=0;if(is_object($H)){while($J=$H->fetch_row()){if($fh)$I[$J[0]]=$J[1];else$I[]=$J[0];}}return$I;}function
get_rows($G,$g=null,$n="<p class='error'>"){global$f;$xb=(is_object($g)?$g:$f);$I=array();$H=$xb->query($G);if(is_object($H)){while($J=$H->fetch_assoc())$I[]=$J;}elseif(!$H&&!is_object($g)&&$n&&defined("PAGE_HEADER"))echo$n.error()."\n";return$I;}function
unique_array($J,$w){foreach($w
as$v){if(preg_match("~PRIMARY|UNIQUE~",$v["type"])){$I=array();foreach($v["columns"]as$y){if(!isset($J[$y]))continue
2;$I[$y]=$J[$y];}return$I;}}}function
escape_key($y){if(preg_match('(^([\w(]+)('.str_replace("_",".*",preg_quote(idf_escape("_"))).')([ \w)]+)$)',$y,$B))return$B[1].idf_escape(idf_unescape($B[2])).$B[3];return
idf_escape($y);}function
where($Z,$p=array()){global$f,$x;$I=array();foreach((array)$Z["where"]as$y=>$X){$y=bracket_escape($y,1);$d=escape_key($y);$I[]=$d.($x=="sql"&&preg_match('~^[0-9]*\\.[0-9]*$~',$X)?" LIKE ".q(addcslashes($X,"%_\\")):($x=="mssql"?" LIKE ".q(preg_replace('~[_%[]~','[\0]',$X)):" = ".unconvert_field($p[$y],q($X))));if($x=="sql"&&preg_match('~char|text~',$p[$y]["type"])&&preg_match("~[^ -@]~",$X))$I[]="$d = ".q($X)." COLLATE ".charset($f)."_bin";}foreach((array)$Z["null"]as$y)$I[]=escape_key($y)." IS NULL";return
implode(" AND ",$I);}function
where_check($X,$p=array()){parse_str($X,$cb);remove_slashes(array(&$cb));return
where($cb,$p);}function
where_link($s,$d,$Y,$lf="="){return"&where%5B$s%5D%5Bcol%5D=".urlencode($d)."&where%5B$s%5D%5Bop%5D=".urlencode(($Y!==null?$lf:"IS NULL"))."&where%5B$s%5D%5Bval%5D=".urlencode($Y);}function
convert_fields($e,$p,$L=array()){$I="";foreach($e
as$y=>$X){if($L&&!in_array(idf_escape($y),$L))continue;$Ga=convert_field($p[$y]);if($Ga)$I.=", $Ga AS ".idf_escape($y);}return$I;}function
adm_cookie($C,$Y,$pe=2592000){global$ba;return
header("Set-Cookie: $C=".urlencode($Y).($pe?"; expires=".gmdate("D, d M Y H:i:s",time()+$pe)." GMT":"")."; path=".preg_replace('~\\?.*~','',$_SERVER["REQUEST_URI"]).($ba?"; secure":"")."; HttpOnly; SameSite=lax",false);}function
restart_session(){if(!ini_bool("session.use_cookies"))session_start();}function
stop_session(){if(!ini_bool("session.use_cookies"))session_write_close();}function&get_session($y){return$_SESSION[$y][DRIVER][SERVER][$_GET["username"]];}function
set_session($y,$X){$_SESSION[$y][DRIVER][SERVER][$_GET["username"]]=$X;}function
auth_url($Mi,$N,$V,$l=null){global$dc;preg_match('~([^?]*)\\??(.*)~',remove_from_uri(implode("|",array_keys($dc))."|username|".($l!==null?"db|":"").session_name()),$B);return"$B[1]?".(sid()?SID."&":"").($Mi!="server"||$N!=""?urlencode($Mi)."=".urlencode($N)."&":"")."username=".urlencode($V).($l!=""?"&db=".urlencode($l):"").($B[2]?"&$B[2]":"");}function
is_ajax(){return($_SERVER["HTTP_X_REQUESTED_WITH"]=="XMLHttpRequest");}function
adm_redirect($A,$Ee=null){if($Ee!==null){restart_session();$_SESSION["messages"][preg_replace('~^[^?]*~','',($A!==null?$A:$_SERVER["REQUEST_URI"]))][]=$Ee;}if($A!==null){if($A=="")$A=".";header("Location: $A");exit;}}function
query_redirect($G,$A,$Ee,$tg=true,$Bc=true,$Mc=false,$Th=""){global$f,$n,$b;if($Bc){$th=microtime(true);$Mc=!$f->query($G);$Th=format_time($th);}$oh="";if($G)$oh=$b->messageQuery($G,$Th,$Mc);if($Mc){$n=error().$oh.script("messagesPrint();");return
false;}if($tg)adm_redirect($A,$Ee.$oh);return
true;}function
queries($G){global$f;static$mg=array();static$th;if(!$th)$th=microtime(true);if($G===null)return
array(implode("\n",$mg),format_time($th));$mg[]=(preg_match('~;$~',$G)?"DELIMITER ;;\n$G;\nDELIMITER ":$G).";";return$f->query($G);}function
apply_queries($G,$T,$yc='table'){foreach($T
as$R){if(!queries("$G ".$yc($R)))return
false;}return
true;}function
queries_redirect($A,$Ee,$tg){list($mg,$Th)=queries(null);return
query_redirect($mg,$A,$Ee,$tg,false,!$tg,$Th);}function
format_time($th){return
sprintf('%.3fç§’',max(0,microtime(true)-$th));}function
remove_from_uri($Ef=""){return
substr(preg_replace("~(?<=[?&])($Ef".(SID?"":"|".session_name()).")=[^&]*&~",'',"$_SERVER[REQUEST_URI]&"),0,-1);}function
pagination($E,$Ib){return" ".($E==$Ib?$E+1:'<a href="'.h(remove_from_uri("page").($E?"&page=$E".($_GET["next"]?"&next=".urlencode($_GET["next"]):""):"")).'">'.($E+1)."</a>");}function
get_file($y,$Qb=false){$Sc=$_FILES[$y];if(!$Sc)return
null;foreach($Sc
as$y=>$X)$Sc[$y]=(array)$X;$I='';foreach($Sc["error"]as$y=>$n){if($n)return$n;$C=$Sc["name"][$y];$bi=$Sc["tmp_name"][$y];$zb=file_get_contents($Qb&&preg_match('~\\.gz$~',$C)?"compress.zlib://$bi":$bi);if($Qb){$th=substr($zb,0,3);if(function_exists("iconv")&&preg_match("~^\xFE\xFF|^\xFF\xFE~",$th,$zg))$zb=iconv("utf-16","utf-8",$zb);elseif($th=="\xEF\xBB\xBF")$zb=substr($zb,3);$I.=$zb."\n\n";}else$I.=$zb;}return$I;}function
upload_error($n){$Be=($n==UPLOAD_ERR_INI_SIZE?ini_get("upload_max_filesize"):0);return($n?'ç„¡æ³•ä¸Šå‚³æª”æ¡ˆã€‚'.($Be?" ".sprintf('å…è¨±çš„æª”æ¡ˆä¸Šé™å¤§å°ç‚º%sB',$Be):""):'æª”æ¡ˆä¸å­˜åœ¨');}function
repeat_pattern($Rf,$ne){return
str_repeat("$Rf{0,65535}",$ne/65535)."$Rf{0,".($ne%65535)."}";}function
is_utf8($X){return(preg_match('~~u',$X)&&!preg_match('~[\\0-\\x8\\xB\\xC\\xE-\\x1F]~',$X));}function
shorten_utf8($Q,$ne=80,$_h=""){if(!preg_match("(^(".repeat_pattern("[\t\r\n -\x{10FFFF}]",$ne).")($)?)u",$Q,$B))preg_match("(^(".repeat_pattern("[\t\r\n -~]",$ne).")($)?)",$Q,$B);return
h($B[1]).$_h.(isset($B[2])?"":"<i>...</i>");}function
format_number($X){return
strtr(number_format($X,0,".",','),preg_split('~~u','0123456789',-1,PREG_SPLIT_NO_EMPTY));}function
friendly_url($X){return
preg_replace('~[^a-z0-9_]~i','-',$X);}function
hidden_fields($hg,$Ad=array()){$I=false;while(list($y,$X)=each($hg)){if(!in_array($y,$Ad)){if(is_array($X)){foreach($X
as$Xd=>$W)$hg[$y."[$Xd]"]=$W;}else{$I=true;echo'<input type="hidden" name="'.h($y).'" value="'.h($X).'">';}}}return$I;}function
hidden_fields_get(){echo(sid()?'<input type="hidden" name="'.session_name().'" value="'.h(session_id()).'">':''),(SERVER!==null?'<input type="hidden" name="'.DRIVER.'" value="'.h(SERVER).'">':""),'<input type="hidden" name="username" value="'.h($_GET["username"]).'">';}function
table_status1($R,$Nc=false){$I=table_status($R,$Nc);return($I?$I:array("Name"=>$R));}function
column_foreign_keys($R){global$b;$I=array();foreach($b->foreignKeys($R)as$q){foreach($q["source"]as$X)$I[$X][]=$q;}return$I;}function
enum_input($U,$Ja,$o,$Y,$sc=null){global$b;preg_match_all("~'((?:[^']|'')*)'~",$o["length"],$xe);$I=($sc!==null?"<label><input type='$U'$Ja value='$sc'".((is_array($Y)?in_array($sc,$Y):$Y===0)?" checked":"")."><i>".'ç©ºå€¼'."</i></label>":"");foreach($xe[1]as$s=>$X){$X=stripcslashes(str_replace("''","'",$X));$eb=(is_int($Y)?$Y==$s+1:(is_array($Y)?in_array($s+1,$Y):$Y===$X));$I.=" <label><input type='$U'$Ja value='".($s+1)."'".($eb?' checked':'').'>'.h($b->editVal($X,$o)).'</label>';}return$I;}function
input($o,$Y,$r){global$si,$b,$x;$C=h(bracket_escape($o["field"]));echo"<td class='function'>";if(is_array($Y)&&!$r){$Ea=array($Y);if(version_compare(PHP_VERSION,5.4)>=0)$Ea[]=JSON_PRETTY_PRINT;$Y=call_user_func_array('json_encode',$Ea);$r="json";}$Cg=($x=="mssql"&&$o["auto_increment"]);if($Cg&&!$_POST["save"])$r=null;$id=(isset($_GET["select"])||$Cg?array("orig"=>'åŸå§‹'):array())+$b->editFunctions($o);$Ja=" name='fields[$C]'";if($o["type"]=="enum")echo
nbsp($id[""])."<td>".$b->editInput($_GET["edit"],$o,$Ja,$Y);else{$rd=(in_array($r,$id)||isset($id[$r]));echo(count($id)>1?"<select name='function[$C]'>".optionlist($id,$r===null||$rd?$r:"")."</select>".on_help("getTarget(event).value.replace(/^SQL\$/, '')",1).script("qsl('select').onchange = functionChange;",""):nbsp(reset($id))).'<td>';$Md=$b->editInput($_GET["edit"],$o,$Ja,$Y);if($Md!="")echo$Md;elseif(preg_match('~bool~',$o["type"]))echo"<input type='hidden'$Ja value='0'>"."<input type='checkbox'".(preg_match('~^(1|t|true|y|yes|on)$~i',$Y)?" checked='checked'":"")."$Ja value='1'>";elseif($o["type"]=="set"){preg_match_all("~'((?:[^']|'')*)'~",$o["length"],$xe);foreach($xe[1]as$s=>$X){$X=stripcslashes(str_replace("''","'",$X));$eb=(is_int($Y)?($Y>>$s)&1:in_array($X,explode(",",$Y),true));echo" <label><input type='checkbox' name='fields[$C][$s]' value='".(1<<$s)."'".($eb?' checked':'').">".h($b->editVal($X,$o)).'</label>';}}elseif(preg_match('~blob|bytea|raw|file~',$o["type"])&&ini_bool("file_uploads"))echo"<input type='file' name='fields-$C'>";elseif(($Rh=preg_match('~text|lob~',$o["type"]))||preg_match("~\n~",$Y)){if($Rh&&$x!="sqlite")$Ja.=" cols='50' rows='12'";else{$K=min(12,substr_count($Y,"\n")+1);$Ja.=" cols='30' rows='$K'".($K==1?" style='height: 1.2em;'":"");}echo"<textarea$Ja>".h($Y).'</textarea>';}elseif($r=="json"||preg_match('~^jsonb?$~',$o["type"]))echo"<textarea$Ja cols='50' rows='12' class='jush-js'>".h($Y).'</textarea>';else{$De=(!preg_match('~int~',$o["type"])&&preg_match('~^(\\d+)(,(\\d+))?$~',$o["length"],$B)?((preg_match("~binary~",$o["type"])?2:1)*$B[1]+($B[3]?1:0)+($B[2]&&!$o["unsigned"]?1:0)):($si[$o["type"]]?$si[$o["type"]]+($o["unsigned"]?0:1):0));if($x=='sql'&&min_version(5.6)&&preg_match('~time~',$o["type"]))$De+=7;echo"<input".((!$rd||$r==="")&&preg_match('~(?<!o)int(?!er)~',$o["type"])&&!preg_match('~\[\]~',$o["full_type"])?" type='number'":"")." value='".h($Y)."'".($De?" data-maxlength='$De'":"").(preg_match('~char|binary~',$o["type"])&&$De>20?" size='40'":"")."$Ja>";}echo$b->editHint($_GET["edit"],$o,$Y);$Vc=0;foreach($id
as$y=>$X){if($y===""||!$X)break;$Vc++;}if($Vc)echo
script("mixin(qsl('td'), {onchange: partial(skipOriginal, $Vc), oninput: function () { this.onchange(); }});");}}function
process_input($o){global$b,$m;$u=bracket_escape($o["field"]);$r=$_POST["function"][$u];$Y=$_POST["fields"][$u];if($o["type"]=="enum"){if($Y==-1)return
false;if($Y=="")return"NULL";return+$Y;}if($o["auto_increment"]&&$Y=="")return
null;if($r=="orig")return($o["on_update"]=="CURRENT_TIMESTAMP"?idf_escape($o["field"]):false);if($r=="NULL")return"NULL";if($o["type"]=="set")return
array_sum((array)$Y);if($r=="json"){$r="";$Y=json_decode($Y,true);if(!is_array($Y))return
false;return$Y;}if(preg_match('~blob|bytea|raw|file~',$o["type"])&&ini_bool("file_uploads")){$Sc=get_file("fields-$u");if(!is_string($Sc))return
false;return$m->quoteBinary($Sc);}return$b->processInput($o,$Y,$r);}function
fields_from_edit(){global$m;$I=array();foreach((array)$_POST["field_keys"]as$y=>$X){if($X!=""){$X=bracket_escape($X);$_POST["function"][$X]=$_POST["field_funs"][$y];$_POST["fields"][$X]=$_POST["field_vals"][$y];}}foreach((array)$_POST["fields"]as$y=>$X){$C=bracket_escape($y,1);$I[$C]=array("field"=>$C,"privileges"=>array("insert"=>1,"update"=>1),"null"=>1,"auto_increment"=>($y==$m->primary),);}return$I;}function
search_tables(){global$b,$f;$_GET["where"][0]["val"]=$_POST["query"];$Zg="<ul>\n";foreach(table_status('',true)as$R=>$S){$C=$b->tableName($S);if(isset($S["Engine"])&&$C!=""&&(!$_POST["tables"]||in_array($R,$_POST["tables"]))){$H=$f->query("SELECT".limit("1 FROM ".table($R)," WHERE ".implode(" AND ",$b->selectSearchProcess(fields($R),array())),1));if(!$H||$H->fetch_row()){$dg="<a href='".h(ME."select=".urlencode($R)."&where[0][op]=".urlencode($_GET["where"][0]["op"])."&where[0][val]=".urlencode($_GET["where"][0]["val"]))."'>$C</a>";echo"$Zg<li>".($H?$dg:"<p class='error'>$dg: ".error())."\n";$Zg="";}}}echo($Zg?"<p class='message'>".'æ²’æœ‰è³‡æ–™è¡¨ã€‚':"</ul>")."\n";}function
dump_headers($zd,$Ne=false){global$b;$I=$b->dumpHeaders($zd,$Ne);$Bf=$_POST["output"];if($Bf!="text")header("Content-Disposition: attachment; filename=".$b->dumpFilename($zd).".$I".($Bf!="file"&&!preg_match('~[^0-9a-z]~',$Bf)?".$Bf":""));session_write_close();ob_flush();flush();return$I;}function
dump_csv($J){foreach($J
as$y=>$X){if(preg_match("~[\"\n,;\t]~",$X)||$X==="")$J[$y]='"'.str_replace('"','""',$X).'"';}echo
implode(($_POST["format"]=="csv"?",":($_POST["format"]=="tsv"?"\t":";")),$J)."\r\n";}function
apply_sql_function($r,$d){return($r?($r=="unixepoch"?"DATETIME($d, '$r')":($r=="count distinct"?"COUNT(DISTINCT ":strtoupper("$r("))."$d)"):$d);}function
get_temp_dir(){$I=ini_get("upload_tmp_dir");if(!$I){if(function_exists('sys_get_temp_dir'))$I=sys_get_temp_dir();else{$Tc=@tempnam("","");if(!$Tc)return
false;$I=dirname($Tc);unlink($Tc);}}return$I;}function
file_open_lock($Tc){$gd=@fopen($Tc,"r+");if(!$gd){$gd=@fopen($Tc,"w");if(!$gd)return;chmod($Tc,0660);}flock($gd,LOCK_EX);return$gd;}function
file_write_unlock($gd,$Kb){rewind($gd);fwrite($gd,$Kb);ftruncate($gd,strlen($Kb));flock($gd,LOCK_UN);fclose($gd);}function
password_file($h){$Tc=get_temp_dir()."/adminer.key";$I=@file_get_contents($Tc);if($I||!$h)return$I;$gd=@fopen($Tc,"w");if($gd){chmod($Tc,0660);$I=rand_string();fwrite($gd,$I);fclose($gd);}return$I;}function
rand_string(){return
md5(uniqid(mt_rand(),true));}function
select_value($X,$_,$o,$Sh){global$b;if(is_array($X)){$I="";foreach($X
as$Xd=>$W)$I.="<tr>".($X!=array_values($X)?"<th>".h($Xd):"")."<td>".select_value($W,$_,$o,$Sh);return"<table cellspacing='0'>$I</table>";}if(!$_)$_=$b->selectLink($X,$o);if($_===null){if(is_mail($X))$_="mailto:$X";if(is_url($X))$_=$X;}$I=$b->editVal($X,$o);if($I!==null){if($I==="")$I="&nbsp;";elseif(!is_utf8($I))$I="\0";elseif($Sh!=""&&is_shortable($o))$I=shorten_utf8($I,max(0,+$Sh));else$I=h($I);}return$b->selectVal($I,$_,$o,$X);}function
is_mail($pc){$Ha='[-a-z0-9!#$%&\'*+/=?^_`{|}~]';$cc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';$Rf="$Ha+(\\.$Ha+)*@($cc?\\.)+$cc";return
is_string($pc)&&preg_match("(^$Rf(,\\s*$Rf)*\$)i",$pc);}function
is_url($Q){$cc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';return
preg_match("~^(https?)://($cc?\\.)+$cc(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i",$Q);}function
is_shortable($o){return
preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~',$o["type"]);}function
count_rows($R,$Z,$Sd,$ld){global$x;$G=" FROM ".table($R).($Z?" WHERE ".implode(" AND ",$Z):"");return($Sd&&($x=="sql"||count($ld)==1)?"SELECT COUNT(DISTINCT ".implode(", ",$ld).")$G":"SELECT COUNT(*)".($Sd?" FROM (SELECT 1$G GROUP BY ".implode(", ",$ld).") x":$G));}function
slow_query($G){global$b,$di;$l=$b->database();$Uh=$b->queryTimeout();if(support("kill")&&is_object($g=connect())&&($l==""||$g->select_db($l))){$ce=$g->result(connection_id());echo'<script',nonce(),'>
var timeout = setTimeout(function () {
	ajax(\'',js_escape(ME),'script=kill\', function () {
	}, \'kill=',$ce,'&token=',$di,'\');
}, ',1000*$Uh,');
</script>
';}else$g=null;ob_flush();flush();$I=@get_key_vals($G,$g,$Uh,false);if($g){echo
script("clearTimeout(timeout);");ob_flush();flush();}return$I;}function
get_token(){$pg=rand(1,1e6);return($pg^$_SESSION["token"]).":$pg";}function
verify_token(){list($di,$pg)=explode(":",$_POST["token"]);return($pg^$_SESSION["token"])==$di;}function
lzw_decompress($Ra){$Yb=256;$Sa=8;$lb=array();$Eg=0;$Fg=0;for($s=0;$s<strlen($Ra);$s++){$Eg=($Eg<<8)+ord($Ra[$s]);$Fg+=8;if($Fg>=$Sa){$Fg-=$Sa;$lb[]=$Eg>>$Fg;$Eg&=(1<<$Fg)-1;$Yb++;if($Yb>>$Sa)$Sa++;}}$Xb=range("\0","\xFF");$I="";foreach($lb
as$s=>$kb){$oc=$Xb[$kb];if(!isset($oc))$oc=$bj.$bj[0];$I.=$oc;if($s)$Xb[]=$bj.$oc[0];$bj=$oc;}return$I;}function
on_help($sb,$gh=0){return
script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $sb, $gh) }, onmouseout: helpMouseout});","");}function
edit_form($a,$p,$J,$_i){global$b,$x,$di,$n;$Eh=$b->tableName(table_status1($a,true));page_header(($_i?'ç·¨è¼¯':'æ–°å¢'),$n,array("select"=>array($a,$Eh)),$Eh);if($J===false)echo"<p class='error'>".'æ²’æœ‰è¡Œã€‚'."\n";echo'<form action="" method="post" enctype="multipart/form-data" id="form">
';if(!$p)echo"<p class='error'>".'You have no privileges to update this table.'."\n";else{echo"<table cellspacing='0'>".script("qsl('table').onkeydown = editingKeydown;");foreach($p
as$C=>$o){echo"<tr><th>".$b->fieldName($o);$Rb=$_GET["set"][bracket_escape($C)];if($Rb===null){$Rb=$o["default"];if($o["type"]=="bit"&&preg_match("~^b'([01]*)'\$~",$Rb,$zg))$Rb=$zg[1];}$Y=($J!==null?($J[$C]!=""&&$x=="sql"&&preg_match("~enum|set~",$o["type"])?(is_array($J[$C])?array_sum($J[$C]):+$J[$C]):$J[$C]):(!$_i&&$o["auto_increment"]?"":(isset($_GET["select"])?false:$Rb)));if(!$_POST["save"]&&is_string($Y))$Y=$b->editVal($Y,$o);$r=($_POST["save"]?(string)$_POST["function"][$C]:($_i&&$o["on_update"]=="CURRENT_TIMESTAMP"?"now":($Y===false?null:($Y!==null?'':'NULL'))));if(preg_match("~time~",$o["type"])&&$Y=="CURRENT_TIMESTAMP"){$Y="";$r="now";}input($o,$Y,$r);echo"\n";}if(!support("table"))echo"<tr>"."<th><input name='field_keys[]'>".script("qsl('input').oninput = fieldChange;")."<td class='function'>".html_select("field_funs[]",$b->editFunctions(array("null"=>isset($_GET["select"]))))."<td><input name='field_vals[]'>"."\n";echo"</table>\n";}echo"<p>\n";if($p){echo"<input type='submit' value='".'å„²å­˜'."'>\n";if(!isset($_GET["select"])){echo"<input type='submit' name='insert' value='".($_i?'å„²å­˜ä¸¦ç¹¼çºŒç·¨è¼¯':'å„²å­˜ä¸¦æ–°å¢ä¸‹ä¸€ç­†')."' title='Ctrl+Shift+Enter'>\n",($_i?script("qsl('input').onclick = function () { return !ajaxForm(this.form, '".'Saving'."...', this); };"):"");}}echo($_i?"<input type='submit' name='delete' value='".'åˆªé™¤'."'>".confirm()."\n":($_POST||!$p?"":script("focus(qsa('td', qs('#form'))[1].firstChild);")));if(isset($_GET["select"]))hidden_fields(array("check"=>(array)$_POST["check"],"clone"=>$_POST["clone"],"all"=>$_POST["all"]));echo'<input type="hidden" name="referer" value="',h(isset($_POST["referer"])?$_POST["referer"]:$_SERVER["HTTP_REFERER"]),'">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="',$di,'">
</form>
';}if(isset($_GET["file"])){if($_SERVER["HTTP_IF_MODIFIED_SINCE"]){header("HTTP/1.1 304 Not Modified");exit;}header("Expires: ".gmdate("D, d M Y H:i:s",time()+365*24*60*60)." GMT");header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");header("Cache-Control: immutable");if($_GET["file"]=="favicon.ico"){header("Content-Type: image/x-icon");echo
lzw_decompress("\0\0\0` \0„\0\n @\0´C„è\"\0`EãQ¸àÿ‡?ÀtvM'”JdÁd\\Œb0\0Ä\"™ÀfÓˆ¤îs5›ÏçÑAXPaJ“0„¥‘8„#RŠT©‘z`ˆ#.©ÇcíXÃşÈ€?À-\0¡Im? .«M¶€\0È¯(Ì‰ıÀ/(%Œ\0");}elseif($_GET["file"]=="default.css"){header("Content-Type: text/css; charset=utf-8");echo
lzw_decompress("\ræCÉìÆo6ÎC¡Â;1Lf³9ÈŞu7!†hàìÌo7C‘€”^1†¢±”äd0›Œ\"Â	ÈÒa6	SaØÊt4˜æg9‰ÌZs—LÃ³i„äg4›‡CÙôÃ„B‡F#aÔÊ;:OAiË9hÑºA_«Æ“™¦Âd¬Bas#±æªa*&±Ñ ß>90;­ß‡—^kG#)’Áb²Y­£M²1f9`×ºÃcÇâz|Íœ¶[´wñq¨ês4MÃ†§#½ª;¹±Òªhãò9¤ôeF²Ze:¡Rª&C%DÎ:¦Ñ\0ÇÇ…h°#¡ĞŞmèœœ ÒdÇ?¸ô‚È;Œ£HÎ4\$Kpä¦Û€­a¼ˆ\"H¢,Ï¡ƒ,,ã†NSüæ¹î‹¦ºªz¢©„€@@†!Ãä»Nã¼ğ<O#Ì6½	z\\õïkŞø¾o«ü!¨|…Èª£–ÿÀ0\n…A‚&Š¢èÊî)cèĞÃNd@‹l œ?®bë†!›¨¦ÄJ”oÄªª?sc®©ª££ğ:*àÊ=ï¸è4:(tA;Dj û>OÓ«­ÍñDU*ˆt9®\0Ø0\n@uMSŠDÊ²Lî‚IQc YAt³A >´ˆı‡1ƒ¶îÎúRñ„pfóÑcE[Ê G+í`Zœ@JØ2ŒÎ5‚2»aYeYƒ:¤1Œ©\n][FUËÀWpk`Pv¤÷U]6­XˆÊpœ¬ËÒŠ@è=»£˜áM.ÜÑ+ìB€¡\r–[mOpápWÕÎò</=©b¸¦'8R¯J]XHO»óZ*£…6Æ•å\$ùÒŠ¨Ò6ŒãŞ §Uš\r¯¸ÉgÇ5}=~b¦m2PaÔQ®ŠİÌ	—¨:ÍaŞ2ª5cÂôZ‚ZÈ[ÄZ×f¾<ì-ğåkXW„%­BºèàÊdó¼ß–»˜ËU³\nu©.¤A“¥)XÚ\r÷ò\$¸*#€ë}æxFm†g.æx>ñ¼x\\³Ãê6_hŠÜ;cxïX1WRùÁ°07qÃ \\Ê#¨ÒÊ/4t½?VòõQWq—vÖ‰g×7xßÑ÷ƒ'MÔx/Ÿ‡×ö!pî0#z8=Ùöˆu!ÚdaÄ®Ìê¥>È\\zà+ƒz'~.—ÿ°­¡(šª1ª@ÉIpn¨ĞáĞÀİTPæ¯CC:[ °àÕà1 \r„~¿&lŸ\\W§\0:†ĞÜÃƒä-oœ1>’Â”›zÆ^¨Åˆ®0n¯1óWÊğª1pZÃù)…èà>À×LZCƒe…¸;ÄØªÃ\$>ˆªp•	,%í-ÀtŞŸ¼Kˆ)ê(—`ËZb@é’’â,Ÿà:xm¹b¯0Ì×Atf!@€15ˆSˆêKhÉ50 d£Chee3§ôˆª\rĞ¢6µµ úäƒ2k'ÕŸRLŒ^Ml%˜â£<’2?ÂÄf¹—*5D-Ù•4Æ8ıÃ¼\"ƒpŒCáé0,2b[élıÖì“ø#KøzŠ‰N ²é‚âºã´!ÍI¨ıàĞ.–%œ5É`ËÍÙ2±\nN	¹7§4âOmµbI´®\$ñ@1¤º“Õ¿•(:çR†b0á«3L©dœıÃtFEl0º\nÔ_¼º'ì½?ĞÖoA#÷ä8'öÒN‘bt}B9ãÜ¬=\ráÂÀr³è€PJR*H©0o¥Ü¹†Pîà\n=Yç	> ÆıÈ‘@'Õ/¤â¶B´=aÅM™B¯MÁÈ8€¥ıÓtZ‹Ú…N«í66Iµ2VKØa/¯Ş®&Ædk+Z¬çfªZdÒ 6¤Pôİ†ÆLÃ¨r>­ˆŞ?r>LŒ!1¯˜6Ëñì=ÇÂ¨ğÜhÁ\"¬­£¸pÊÕŠC<ˆ‚‚T\rAe§µ ÖÔàn\nlê˜eòLè0BœH©Û^ä„Z@Ãi­e«µ¨”‚Xäè)<ª8ÏĞßbX>t;Mİrì¦\\JQ^±;\rsËkËÜ6/’~İJŒ7¥iâš ×ê¼R‹î*+DH*ïM™iOŠö†ğÎE×Ü6‡¡X§Ê[A}E‚õ•Kô¢q	;nºCgºàkØ#4&B+‚Jì'bêI§´wîâjRx0Ş®Dq…ÓÅ^+\rL@.:ŒYáÎ+yNO+²ÉáW#»\$İû!H&PG¤ 0Opº*J„t ÆN”=™\0äˆK§'qnäâuÃ9›Øğ;ß(Á}aúœy{0<ús™¯ñQ¾©?g¼ŸšÏ¡ÚƒõÅcIÜœAÖñ!½K1ÄNØ‚3pHªĞZÔÚ¹Ã¶/B\\	áÁTÆˆ¨ÅúÂ˜IDªÄç_£lhª°daÊ…EØ§}2ÆqaøÓ=ˆVN\rxÀi\r¼Ö@;ÔíHó°CuÒ7o £ŒGw2,EÍ4>‚3‘/zÊ3F¿^å™ñ•ê\"Ì¨ûuü¾j>` ™†W'9¶StX-Æ\0ÙñkËeİJ+àµÃ‡ ZmÑİ/,é<ÙÇ°ÄË·)\nc…PÄlöîö7e5^åZÇˆ^IVGĞ4Ï`å´ñB'EöÁ§OŸœ„˜¸>4xÃ\n½2‘¼Êå¹7öæ™:¾²nƒÌôù_È¼…d¦F6<Bú¬¢øôçYÌg#\\¾TK0x:/Ü9@ØBÚè®±¢y]„;/gÇÏ³ITı;Š½F'ºvp](í¦‹:0Ñ8YÈ{ŞpşÀqh,ÔiÃ\rı“º‚=XtV#Ñ»Âœ|¸´›,íÚRşwÓó¬V³Ö¸Ã;ß¯9µ²Ùí­ãÓãµ!qç¬ò@ï×iİ\\Ë²zïeíû£İï<ƒà!ÍSÓi‚bûÇ•Ãa×Æ=ï[äP@'wœ“ÎLOÀ(h…”2—5¸Ñ©˜:\0á¦÷í­§¹ñ¾Gãíß§¦ğ9R±Ær£Ó|îÛ¯.[¬²ÍôşoBÌÏÿ\rzÿf¶+Ô7®D´Cô?ºõ¶õ@Ú¯Œòo~ïÏn@ö¿Oşù°ó0¿P¯NÖ00°D÷`ú¯´2¢nÆâlÑOœW+şè*`.æ°K\0dÛ\0§¼÷ÀGÍdÖ2ú¬0‡ˆS‰È¾Ğ Ph‘	æLÍ¨¼ÍírŒd#j6å„â¸B)±t€Úâ\r¨6Ãp¬ğÙğß\rpÔ f÷Cr-ğÛÀà\r\0àçœp÷\rğûğ×cs ¿Pğ¨cGq\0}ÈÒ·\"ü‡°İ0ıQ4`ïĞüéüƒéh| ``f“Jä–€à`–ğË‘Fv ßQm\0ê\rñ!ñ6±¤{E9ñª`Øñ‹Q‹Ñ”„1˜ª€¿1Q„_i‘,ËPùqŠ˜``)nÂQlàì)ÑEñÒï‘Ğ)ÍŞİìİQgÿ¥{±kqãÑ»(Crñæ*†ÈÉ±w‡@C.¢®bµOE6~Ñ¹\räøğÔqˆ=²:‚~-@éqw#òJi ß\$‘ŸÒG\$U\$PÍ%ÑÒ\rˆÓgí\"1]àŒ±ÉÒ6è%‰&’[\$©&2J›2™%ò)Òk\$oRg(òs\"à×ƒ?\"D–òÀÑî†é'@ğ\r±“#hÒ/‘3²I,ÒÑCÛ*,Ó-Òe#Òí\$¤Šş­Z»/2M&§\$±—0Rn'Eşƒ0Í\0S°3,q\r`Ê1%2³/%ƒs)pÍ3FÑ-ÈC23rñã(f)-’ÇQ‘3‘³	ÿ5òÑ¡6ójªˆ½6Í\$ótñš,3}7g\0¾\0Ï6Ñùó=6““9j©8²8ócàÚs§83Ÿ9³9’0ó›bÒeŸ:“sÈ\"SÏ81¿'’üq^Sé(0Ş^Õ?Ög³¿Sù#,3)›ê1<Ég>)ˆ˜Ğğ¯5jÕ-±7BQè¢°+0«##s5óûñ¤jÉ¿DpÍ8tOÓ¤ûñ%?ô]£_<ÔWæ_1¬·BJ˜Ú\n¼³[sÁ:mBSÕH3‘B®Jš¤Ç01#t‰/4£\$rEßHt­Hô«=T±=Q®Ttã†)#ŒâÄoI|ÀP;Nz€É´°4Ú\nl®›JĞ¶­«\0±Ä~½ÃOCn²bä.ˆ¼/•G’A4Ä\rÃˆ.Ä/ÔÎ2”Ò\$ÖoÂCMâÍN)A\0Té!\0ËNÂõO\"dÍ®* ");}elseif($_GET["file"]=="functions.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("f:›ŒgCI¼Ü\n8œÅ3)°Ë7œ…†81ĞÊx:\nOg#)Ğêr7\n\"†è´`ø|2ÌgSi–H)N¦S‘ä§\r‡\"0¹Ä@ä)Ÿ`(\$s6O!ÓèœV/=Œ' T4æ=„˜iS˜6IO“ÊerÙxî9*Åº°ºn3\rÑ‰vƒCÁ`õšİ2G%¨YãæáşŸ1™Ífô¹ÑÈ‚l¤Ã1‘\ny£*pC\r\$ÌnTª•3=\\‚r9O\"ã	Ààl<Š\rÇ\\€³I,—s\nA¤Æeh+Mâ‹!q0™ıf»`(¹N{c–—+wËñÁY£–pÙ§3Š3ú˜+I¦Ôj¹ºıÏk·²n¸qÜƒzi#^rØÀº´‹3èâÏ[èºo;®Ë(‹Ğ6#ÀÒ\":cz>ß£C2vÑCXÊ<P˜Ãc*5\nº¨è·/üP97ñ|F»°c0ƒ³¨°ä!ƒæ…!¨œƒ!‰Ã\nZ%ÃÄ‡#CHÌ!¨Òr8ç\$¥¡ì¯,ÈRÜ”2…Èã^0·á@¤2Œâ(ğ88P/‚à¸İ„á\\Á\$La\\å;càH„áHX„•\nÊƒtœ‡á8A<ÏsZô*ƒ;IĞÎ3¡Á@Ò2<Š¢¬!A8G<Ôj¿-Kƒ({*\r’Åa1‡¡èN4Tc\"\\Ò!=1^•ğİM9O³:†;jŒŠ\rãXÒàL#HÎ7ƒ#Tİª/-´‹£pÊ;B Â‹\n¿2!ƒ¥Ít]apÎİî\0RÛCËv¬MÂI,\rö§\0Hv°İ?kTŞ4£Š¼óuÙ±Ø;&’ò+&ƒ›ğ•µ\rÈXbu4İ¡i88Â2Bä/âƒ–4ƒ¡€N8AÜA)52íúøËåÎ2ˆ¨sã8ç“5¤¥¡pçWC@è:˜t…ã¾´Öešh\"#8_˜æcp^ãˆâI]OHşÔ:zdÈ3g£(„ˆ×Ã–k¸î“\\6´˜2ÚÚ–÷¹iÃä7²˜Ï]\rÃxO¾nºpè<¡ÁpïQ®UĞn‹ò|@çËó#G3ğÁ8bA¨Ê6ô2Ÿ67%#¸\\8\rıš2Èc\ræİŸk®‚.(’	’-—J;î›Ñó ÈéLãÏ ƒ¼Wâøã§“Ñ¥É¤â–÷·nû Ò§»æıMÎÀ9ZĞs]êz®¯¬ëy^[¯ì4-ºU\0ta ¶62^•˜.`¤‚â.Cßjÿ[á„ % Q\0`dëM8¿¦¼ËÛ\$O0`4²êÎ\n\0a\rA„<†@Ÿƒ›Š\r!À:ØBAŸ9Ù?h>¤Çº š~ÌŒ—6ÈˆhÜ=Ë-œA7XäÀÖ‡\\¼\r‘Q<èš§q’'!XÎ“2úT °!ŒD\r§Ò,K´\"ç%˜HÖqR\r„Ì ¢îC =í‚ æäÈ<c”\n#<€5Mø êEƒœyŒ¡”“‡°úo\"°cJKL2ù&£ØeRœÀWĞAÎTwÊÑ‘;åJˆâá\\`)5¦ÔŞœBòqhT3§àR	¸'\r+\":‚8¤ÀtV“Aß+]ŒÉS72Èğ¤YˆFƒ¼Z85àc,æô¶JÁ±/+S¸nBpoWÅdÖ\"§Qû¦a­ZKpèŞ§y\$›’ĞÏõ4I¢@L'@‰xCÑdfé~}Q*”ÒºAµàQ’\"BÛ*2\0œ.ÑÕkF©\"\r”‘° Øoƒ\\ëÔ¢™ÚVijY¦¥MÊôO‚\$Šˆ2ÒThH´¤ª0XHª5~kL©‰…T*:~P©”2¦tÒÂàB\0ıY…ÀÈÁœŸj†vDĞs.Ğ9“s¸¹Ì¤ÆP¥*xª•b¤o“õÿ¢PÜ\$¹W/“*ÃÉz';¦Ñ\$*ùÛÙédâmíÃƒÄ'b\rÑn%ÅÄ47Wì-Ÿ’àöÕ ¶K´µ³@<ÅgæÃ¨bBÑÿ[7§\\’|€VdR£¿6leQÌ`(Ô¢,Ñd˜å¹8\r¥]S:?š1¹`îÍYÀ`ÜAåÒ“%¾ÒZkQ”sMš*Ñ×È{`¯J*w¶×ÓŠ>îÕ¾ôDÏû›>ïeÓ¾·\"åt+poüüŸÊ=Ş*‚µApc7gæä ]ÓÊlî!×Ñ—+ÌûzsN¦îıàÀPÔšòia§y}U²ašÓù™`äãA¥­Á½Áw\n¡óÊ›Øj“ÿ<­:+Ÿ7;\"°ÕN3tqd4Åºg”ƒ¦T‹x€ªPH¨—FvWõV\nÕh;¢”BáD°Ø³/öbJ³İ\\Ê+ %¥ñ–÷îá]úúÑŠ½£wa×İ«¹Š¦»á¦ğèE‘­(iÉ!îô7ë×x±†z¤×Ò÷çÅHÉ³¸d´êmdéìèQ±r@§a•î¤ja?¤\r”\ryë4-4µfPáÒ‰WÃÊ`,¼x@§ƒİx¼ˆèA’¦K.€OÁi€¯o²;ê©ö–)±Ğ¨ºä’É†SÙdÙÓeOı™%ÙNĞåL78í¦Fãª›§SîáÒùöIÁÂ\rîÛZ˜²r^‰>ıĞì*‚d\ri°YüëYd‹uÃës‡*œ	ÌèE ¡Ê½éD§9æë!Â>ùkCá€›A‡Ád®åâ°!WWì1ğğÿQAæœÛk½°d%¦Ü# ïy†°{›–`}Té_YY‹R®ğ-¹MôºO–2ÖâÊ,Ë,Å É`ú-2ÓÀ÷¨+]L•È7E¤Ôç{`¢ƒË•­ñ~wì-…×ı ©M6¥¤]Fóûƒ¦@™§Ìe`°/˜8¹@‡e¦ÍØ\\ap.‚H¥ûĞC´Àæ*EAoz2¹Æçg0úˆ?]Í~Ÿs°ñÏ`ŒhJ`†êç®¤`û}‡áÍ^`èÑÃ>§ÈOñ5\rğW^Iœõõ\n³ù¬ı;ñ¸´ğ:ŸäÏ_h›n±µŒ´ßYP4®ğˆ)û *ı¸îÉõ¯æÑ6vÖä[Ë¤­C;ûö³ïã»¶näW/jº<\$J*qÄ¢ûä°ú-LôŒ\0µ¯ãï÷\0Oš\$ëZW zş	\0}Ú.4F„\rnu\0âàØÀä‹’éLŞ ÷IA\nz›©*–©ªŠjJ˜Ì…PŠ¢ë‚Ğp…Â6€Ø¦NšDÈBf\\	\0¨	 ˜W@L\rÀÄ`àg'Bd¯	Bi	œ°‚‰*|r%|\nr\r#°„@w®»î(T.¬vâ8ñÊâ\nm˜¥ğ<pØÔ`úY0ØÔâğÀÊö\0Ğ#€Ì‘}.I œx¢T\\âôÑ\n ÍQ‘æ@bR MFÙÇ|¢è%0SDr§ÂÈ f/b–àÂá¢:áík/şã	f%äĞ¨®e\nx\0Âl\0ÌÅÚ	‘0€W`ß¥Ú\nç8\r\0}p²‘›Â;\0È.Bè¤Vù§,z&Àf Ì\röWOcKƒ\nì» ’åÒkªz2\rñÉÀîW@Â’ç%\n~1€‚X ¤ßqâD¢!°^ù¦t<§\$²{0<E¦ÊÑª³2&ÜNÒ\r\næ^iÀ\"è³#nı ì­#2D§ˆüË®Dâæo!¬zK6Âë:ïìÃÏğ#RlÓ%q'kŞ¾*¸«Ã€à¶ Z@ºòJÌ`^PàHÀbSR|§	%|öôì.ÿ¯Âµ²^ßrc&oæÑk<ÿ­şí&ş²xK²Õ'æüLÄ‚«ò‹(ò’òmE)¥*–ÿ¬`R¥bWGbTRø½î`VNf¢®jæğ´woVèè˜(\"­’Ú§ô&s\0§².²¦Ş³8=h®ë Q&üân*hø\0òv¢BèGØè@\\F\n‚WÅr f\$óe6‘6àaã¤¥¢5H•ñâ°bYĞfÓRF€Ñ9¨(Òº³.EQå*Êî¸ë(Ú1‰*Â/+,º\"ˆö\r Ü	ªâ8ı\0ˆü3@İ%lå­ã¥,+¼¼å&í#-\$¦óÈ%†ÌÅgF!sİ1³Ö%¯Ôsó/¥nKªq”\0O\"EA©8…2ÀŠ}5\0Ë8‹ŸA\n¯ÅRrH…Ú³‡9Å4UìdW3!b¨z`í>ãF>Òi,”a?L>°´`´r¾±r ta;L¦ëÅ%ÀRxîŒ‰R†ëtŠÊ¥HW/m7Dr¶EsG2Î.B5Iî°ëÉQ3â_€ÒÔˆë´¤§24.ì‰ÅRkâ€z@¶@ºNì[4Î&<%b>n¦YPWÎŸâ“6n\$bK5“t‡âZB³YI Lê~G³YÎÖñcQc	6DXÖµ\"}ÆfŠĞ¢IÎj€ó5“\\ö XÙ¢td®„\nbtNaEÀTb;lâp‚Õ|\0Ô¯x\n‚ådVÖíŒÖà]Xõ“Yf„÷%D`‡QbØsvDsk0ÓqT¥ÿ7“l c7ç€ä ÖôÎSZ”6äï¾ãµŠÄ#êx‚Õh Õšâ¬£`·_`Ü¾ÎÚ§±•ê¥œ·+w`Ö%U§…’ï©è™¯¶ïÌ»U òöD‹Xl#µ†Ju¯[ åQ'×\\Hğ÷„¤÷äGRÕë0«oaĞõÓCÃX¥+ÔaícàNä®`ÖreÚ\n€Ò%¤4šS_­k_àÚš!3({7ó’bI\rV\r÷5ç×\0µ\\“€aeSg[Óz f-PöO,ju;XUvĞîıÖÃmËl…\"\\B1ÄİÅ0æ µ‘pğå4á•ë;2*‘î.b£\0ØØuÔãJ\"NV‰ÛrrOÕfî2äW3[‰Ø¢”¤³	€ËÆ5\r7²Ë0,ytÉÛwS	W	]kGÓX·iA*=P\rbs\"®\\÷o{eÀòœ¶5k€ïkÆ<±‚;®;xÕ¶-ö0§É_\$4İ ²¶´™8*i\0f›.Ñ(`¼•òñD`æP·&Œô˜ŒÄA+eB\"ZÀ¨¶³¢WÌ¢\\M>¶wö÷ú¶Ëg0¦ãGààš…‘Òø´\rÆÜ©*İf\\òŒp\0ğ¼‚åKf#€ÛÀËƒ\rÎÙÍ¡ƒØ@\r÷‚Öd ¢Ÿ\nó&D°%‚Ø3­wı‚©.}÷ùÏÿÅ­‚ ñ‚kHÆk1x~]¸PÙ­Óƒ€[…Œ;…ÀY€ØˆØ‘KÅ6 ËZäÖàtµ©>gL\r€àHsMìºe¤\0Ÿä&3²\$ë‰n3íü wÊ“7Õ—®·\"ôÒë+İ;¢s;é” *1™ y*îË®;TG|ç|B©! {!åÅ\"/Ê–oÎãj÷Wë+µæ“LşDJş’Í…´w2´ÆVTZ¹Gg/šıÖŠƒ]4n½4²À¿±Á‹Ï÷i©=ÈT…ˆ]dâ&¦ÀÄM\0Ö[88‡È®Eæ–â8&LXVmôvÀ±	Ê”j„×›‡FåÄ\\™Â	™ÆÊ&t\0Q›à\\\"òb€°	àÄ\rBs	wÂ	ŸõŸ‚N š7ÇC/|Ù×	€¨\n\nNúıK›yà*A™`ñWÏYvUZ4tz;~0}šñJ?hW£d*#É3€åĞàyF\nKTë¤Åæ@|„gy›\0ÊOÀxôa§`w£Z9¥ŒbO„»¨ÚWY’RÄÉ}J¾ˆXÊÚPñU2`÷©šG©åbeuª…zWö+œÈğ\rè¬\$4ƒ…\"\n\0\n`¨X@Nà‹®%d|‚hé¬ÈÚ™ŞÅ‡egÄê‚+âH¸t™(ªŞÑ( À^\0Zk@îªP¦@%Â(WÍ{¬º/¯ºşt{o\$â\0[³èŞ±¡„%¡§ë´É™¯‚hU]¤B,€rDèğe:D§¢ÌX«†V&ÚWll@ÀdòìY4 Ë¯›iYy¡š[‘¬Ã+«Z¹©]¦g·‡FrÚFû´wŞµ”#1¦tÏ¦¤ÃN¢hq`å§Dóğğ§v|º¦Z…Lúv…:S¨ú@åeº»ÿB’ƒ.2‡¬EŠ%Ú¯Bè’@[”ŠúÖB£*Y;¿™[ú#ª”©™›µ@:5Ã`Y8Û¾–è&¹è	@¦	àœüQÅS8!›£³»Â Â¼¢2MY„äO;¾«©Æ›È)êõFÂ¨FZõA\\1 PF¨B¤lF+šó”<ÚRÊ><J?šÚ{µf’õkÄ˜8®ëW‚¬èë®ºM\r•Í¼Û–RsC÷NÍô€î”%©ÊJë~Á˜?·Úâ¯,\r4×k0µ,Jóª•b—öo\0Ê!1 ø5'¦\ràø·u\r\0øÊ\$¡Ğ=š}\r7NÌÔ=DW6Kø8võ\r³ Ê\n ¤	*‚\r»Ä7)¦ÏDüm›1	aÖ@ßÖ‡°¨w.äT”Èİ~©Ç¼pV½ÀœJ‚u¢\rä&N MqcÊdĞĞdĞ8îğØ€_ĞK×aU&®H#]°d}`P¬\0~ÀU/ª…ñƒ…ùÌynY<>dC·<GÉ@éÃ\"’eZS¹wã•›“ÆGy¼\\j)ğ}•¤\r5â1,pª^u\0èéˆÕÆnÌÚC©ºHPÖ¬G<Ÿšp‹ô2¨\nèFDÜ\rÖ\$°­yuycöçõv6İe)ÖpÛYHÏÄ’õŞ#VP¾€üÕØeW®Ş=mÙæc:&‰¥æ-ÛÄPv.£Ë€øæºğš	‹úØ£\0\$êÁ@+×ì¹Pÿl&_çCb-U&0\"åF…®Vy¸p\rÄa5Ûq9U>5è\\LBg†èU­[¶7m düóyV[5Ÿ*}Õ4ø5/ç¶àÒ¾HöD60 ¿­Åì¿íÃ:Suy\r„¼‡ãSMÀŸÂ;W“ªØÎµL4ÖG¢NØã°§–Ÿõ ÜeÜmğšt„Èsq¶€˜\".Fÿ™§CsQ¸ h€e7äünØ>°²*àc!iSİj¾†Ì­Ù‘ü°ø‚°ü {üµ­÷%t€ê\0`&lrÅ“,Ü!0ahy	RµB=ÍegWãùo\0¦H‡h/v(’N4‘\rı„ÀTz„&q÷?X\$€X!ôJ^,Ÿ­öbó“ı`2@:†¼7ÃCX’H€e¡Š@qïÛ\ny¶ 0¦è‹´£´€ñPÀO02@èv‰/IPa°2ÀÜ0\n]-(^Æüt.½•3&Ç\"«0¤˜\"Ğ\0]°1šÍñaÂ˜´°E³SúÄP|\\€ÉÑAõpú9›\$K˜ˆByuØ¯zë7Z•\rìb¤uÉ_ïò8õÆmãq³ğû˜E<-ÈÉ@\0®!)³Ä )÷)Õ~Qå	rÙ‘Ü/MèPÿ\nº	¦É`à!\n(ˆ‚\n\n>X€Ğ!` WºËáø¼àp4AÚ	Å¶Á©d‘Ç\0XÒÙ§V\n€+Cd/EØFåâ¯m+`\0Ş2´ôp/-ØÌ2·™´eæËC@C„\0pX,4½ìª¼ƒÌ9àòÔXt!.Pß˜\\ı•q„£b{…vˆbfMÃÍ)D]ûw„˜°ŸË… XàB4'»—fÀtXĞ¦¢(O Õ¾©	ğ‘qü#³3¸«p]¢i\".ªè7¬iw[T\0y\rÄ4Cå;,\$a2i(™\$µmÈ†DÒ&Ô”4¥Z â;E#6UAÄR€­üìeFFUŒ1•h2\n¨÷UpÖ‡ÃéTÊ¹€âÏØÕ[î+‘^ôXÕ¤Ù78 A\rnK‚‚d1´>€pƒ+¦`Î:‡‹Iƒo<ÚL„@äa	¾€´\0:ˆ†İG—½ hQ„\$ùjR¸Ç'ÉÈŒ¯K!ı`¨£¸1ÅÒÀHƒCÆâZ0\$ÀeÉyXG£5hÎEâ\r1ŸG‚\nº`·g'\0¼İ6qVã(\r‡„VPHöÇŒëbÖŠ\r¯-k–\0B‘bÆıØGß:½áŒZ×Ñ|¹>*ÄXXÙ!¡’£´\"&öÀ:EÕa«÷,vB P‰h!pf;\0£¾[Á‘/r:qTƒèÙ8\"x3Gl‘İ\"Xm#Ã`è5ÑæÜx\n¨óG¶;ÑşEQ—X¹Ç‚<HhAúå¢ê·+1Nsº´ã¡µk•jsH{€Øõãï&1•GãaIÊ?76š22Îp4™ş—È™V!°Á‡¢º2ÍŸ:€¤z	IàÄ‰ZÔ1ER7Ãİ%£¶ÂôÅ6!Á?@(•ä–‘ï,&…2’¸ò”>™I8 ÒP+œ”‚hâ&7N'2V˜š\0Ñ¢i\0œ‡ËÜ™i%8ù¹V8e„Z:Ò@Ê´°ñ6ä¦R{¨JzÔs2…	j(C`Z*ôˆJ-bçë#¸DEu\$¹WŒ*Œ¥*#9ˆ”D3y¥?\"Ø9ı,Q”/§ßw8ˆ‚UÀ=•qÿ™]\0ƒÊ¹¸mtøŒ-*ç(˜ğdÒ‰•!åƒ+FX\$IŒÌ„âîˆ¼ºU\$õ`‚‚Ìeò'c¦¿Vr¨n«Æ1l€Šõ5¬?XTÅ&*@ òIBÖtyt–fêõN¨ğ%ÂÅS™H˜xô\$Ü\0}/sH\\§Ë†°ÊË6@y1\0~@+ÄVñ7UÀLh`_CÀÆ€‰hBA|‰œ*pEÍí	 \"Ö‰0\0‰0\$R‹ìªåp\0§Š€[’²gØfb²rí«ÈÍ\0PÙ÷,™\0œtcğ€ÿ¦|d	£Ë,F‡œÂ€Ó0Ç6+šU¬û•¤æ’[	ZLü½íRŠ%j—€È4³I€æÈ#xŸ»´WÀvàßÅô6M´\"€mãP‚U7P6Í¾n /	tİRšAp©Í<R3NX†\0Ğ¬S|1KĞ@0<Í„S	O+ÜÚJÁ7`1ÍâoS`Ñ8³	æe“–›¨X€ç7Q´†æs*œØ@W2ÁMZaÇ¼Kà…¸ñE@è\r³œÅ¦lê¹ÚÌX(/äj0ñ¢Y¨<WÃ7Z²Ç‡|£&H|å‚Ù…©…%TŸsFGNq<Iˆ„î—ˆ€¶7&-zƒV ‚[±öwç¼1\\ô•ÖS–\r©:‹œ³£S-ÕŸ}Á2äƒŠ>‘ô„9h£`,=´ÔRÈ°©œJe4Kp—EÂ€E‰”}H¤Š¢a@ &;à–{.	’€ó!²ÚÙIÁÒ0cŞØf¸:\ráPwNŠu¢¦åW”Î+°»™ËM\0007Š|!Æ¨YhæéWĞ\$i;IÛaL¹§…\$SÂ ,‹S.Se±@N0y*Û¦&†ŠäD\0dÉ¤OE°1EuÅqë2J}EÄô+  DZê§è¹EâÖ+a[O;(Ä‡Edm}\0eû\0äÀ4\rîË…+‘À_ÿ§P“l—uÔÚÉ±öQ½Q	À\$ÊÂ–1µ¢!\\º«\n1O)6]u &’K' èÇGš=tæLDÀ×?H¨Òš‡¥H¿(ÃHJTRLaÿ¥e ¿Bñ‰Ş€[dĞ½‹\nR†=­BSgF”á‰nÊ˜\0²¬¥0e‚c&«@¨Ğ–¸½òõ1â‚\0\0ÀO›)>z¨&0½ÁMÊÈèÔZJj«Ä›…%Î!‘z¯\0Î8¸¦AP²¢P‚y‚¯FcDJ°Ñ‰6¦¹-Èî‘ĞÆúŸ„ìRY&ÈÎ~²˜\$á	 ™CÊ4àc#;ÈšAbİ­#CŠhBBtOÍh;±p×l”‚¥uò\nY	Â'‘ÈïŒ¹ÁÔ\03á\0¼	€IX@ø \"µĞ\0P§Z4ÀTŒWUCª,ˆô€°©›(	¿š	MŞ,—®¬†ÅP`IÈô¡hÓèé/Qœ\0ˆèôÿÓø@)\nFH‚ùíÃÈ€ÎÂâ’°QoÂ@>SÜC@pøHàîÆV@Bn—	a1éÄEÖ*Ÿ5aªH7dP\n¦Bç JDüJ– ú¬ã&§ê{À¶Aà'’h5-à°@t§‰©)dJu°¦è†ğJqUèóQ¯«%NÉSê(&­.ŒR°T°õÍÂeµr=\\SŞˆªâˆš§‡¯­hnêÑNµãˆäY\"Ñ\n\nJxƒG\r\0œr5Û½T@×[`€…”éZ\r‚Ip%|åA*9w\"¨+è˜ø¡2c¡ƒl«9#\$Í@ağÄò*³TÀ@\0+°€+=a9ÃC«I¿¡ÀY~#ñ!ÚÂ‹B™?è°åA‰\nŒÀE!ˆkC€-Ád’fkí^\0ÀUùk5‡:Ç¾pÇœ¬Š€(8ºèÖv¯5á±—*ë8€¡Ä‚ †¨¥ÎcÀ+úW¤ZFPîBWS)â@¼=³ÉSŠœ¶;r@@È1Û78èEÍX¬½0º~ÌcÓ±âz)fƒŸª\$d6ma­—“]gõÙÍkAp³´M÷g’~Äà!•c<P\"½XÑÆZ¸ö‚±àšá÷hk4›dãKğà	\0bµÚMHY4­†TÀ/ˆMî¡ñ´JØî‘uÛ”Ğëğ)\nİI±?vÔ	©iÓÔFËQ¦m÷\$Ê(‘w7-„x ç+Út]xlugAÇF²/s’È=d2°n=Ñş<¡å?eÊá2—€\\û ÇV.Ù.±¦,}á?K¡ç–æŠà0O¡ó†üÂĞ€Üık2)E0È¹Iú—ÄOÔz_õ¨¥6CBê/øÇ.Ü¨¤Ê*1¡Ô½ìHà„äÔZĞZ8\0´ ;%½DLCW00\0¢®u«ÅG..˜×D>¤(‹PôÅÖ®‘\\Ü\n€-ğ,/rz×Ü<]i–—íŒÈ»µaRÈµšEÉSœ=B¹ªXt[êfj…¨\0µ(•Ô%¸c§2¸Ç#™¹ğâ„¡{­µD«®whï.¾¿)ë˜üÈ&C0bŒZƒ+<ÇFN_…ë­a!¸,!\r§m€¬›]jºÕO°ßBi`0:Ø3¡MO(¶\\¿ŠİÜèhrF9Õä…Àİ,‰59¼²u“I§†å·±n’h^R0(Öê=™¬Ğå¨ã–ãÆ'5y¦Ú”°€şä„£ÙúÒ±R€ÿ\n2ê€]øöÉ%Ek_\nˆ¨¾4!T98Y#Él¥\\Ê¯ÙQ¤E4ÓÎ\r-<ˆİ_«}Ï>¥‹§õé¨–IíTŒ!¥’ZÅe=«÷NX? -ÈªT”Ù\"—öüF0J©#Ÿ?÷ßõ*áAÔŠËÊÆaÏjüi,z,|/Ì÷ò`(?¡v¡üögŸ~¥bO–©†µ8N­R&æÕ£şÀ•6É6Ğ<_êı‰}>‹£0JSˆOàk	o»»C;úÔ¨€,¿ÉâO%UÆİ!ƒh|BQ!ŒÓŠşYíşğM\0v[àøqí·¯	x3ŸEúÀç~ÓNà¶¼7ğñKP/zËvR<ïÉ\rLùd“B!5êĞH˜ˆp/¯€Û-ú<,Aôpá†cıá LtÅ„éu—ˆ[æµ€ã61¾ëøCQ¯`é6Ï´í,Âk×Ù Ö°·êEä¾g-Ñîş@^<•J®D@´¦Ÿ>ØÉÃieÓCAŠ&‘DpN,±ù™vÊ`Ş?0ˆÔõ«Ô=ÉâI{±T½e¡o_m_K¬¤Å½õHÒ'=@ì\$‹ˆ7p‰’a\$js £\r‰ÙÃƒÕ°æQ¬;ìcàpnõ¡ØûK<iaîÜ :Ãf4b%¥Äã—!OÇN5à_zc¿ÀgÇf9—dšFePAõtaê„k6¨·–<aÕ»IüÃÔ‚÷\nJòeoKÏ¥ß\0006·Ù±j¤×C]¥,eà¼úÂœÔIíÈÖQ¯b¸VI±Şç; à@'ÛmE\\Gv *`|ÂkYgO¥‡J–10òy“à<åOª~NB\\ÇK„w)MÇÊÿ²ˆ(Ü¨·*j%iúŠel6\nÖÙxlXlOLAlª–ØWA …]i#ëpP;&`[HĞğ­„ƒ»\0ùl1`’€àîOâv€9%rŞ\\ğ®KQ[\0ìXb^ÎLO——4ò	8ù7AB„†PFªŠü‘°ÉĞüL§·*!¶öRÂ1EœÇeÈO¹4Æ…®HÊK³2ÂD9fSç™Á:n·Æ<¡ Î ğ>Ì%£ğ¤Ô7VTrÃ]ø)-ÈC°J!ÀU•„¢âœ‹§òºøóÌæ¨%·0àcs±ÿfV=GÍ°Íãa—Æ‘:Ğ%CËæ²™Š)S5`[Îí€;GÌğæË<yµkmÀ_c\\ëg¼G,gcJ9œab€í^²\\YjŞ~¥İ‹v‹0æ¥€Là©— Ñfw(âÉşi[‘õû'cå”Ç;ñöô5)eyÚ\nb¬q ÜóD„§\"¥ƒ1hsG•²ih€8ÇÑ*Y¢ƒ-¨\$¯¶thøóBÛ»X*•Ğ©ß¬vËQY*¿~Ğò€êÎú«äX8 ,ª½¾ å9bdµ\\OìL.|)1\0ŸLµ·èP ¸Ëø’³ÇznGqv…L^\\\\C“Ò~‹~=YK¹¾z|³¦! İz ƒè°ÒÑI•«ÒL”ìäë×¦MÅm…‚wv{&˜¤X•)Å¥r=i±r &™P§^ÙÒìúfÁ©WÀO¦5j±(NífšE¦Pê”Â©›Óö/U¨A³8:½ÓÆ¯ñ§´WX\nep»¤¯xÅ\0Òz835Û)tfSàTÈc2¿VxŠX³^KÌfF­}k@º(|òælÓÒyZÅ´áÁ_Gò=ñ×_ÈËŸ°†™Ğô\nÇHâG\r{„hÌÅ()Hs¿ûf2­e>àA%áª>û\r]ğ‰eğH Nk *†×\nà»¡Ë÷!Nƒ³/p”ìRá…\$×FOÉD€ãì_9À|=¦Hİzüë{2æfÙP^¢~–¸'6û=6Ìˆ› F5hÛDv`.şDsßfQwÓÆiÇ)†ÍI)¯k&VË\0ö¨&^Pí—Íi\"Ã0SL]\\±¾(„<Ñ^»¬zëğø«a`¸~,,ÜÃãL›Y:Ì>%\$:%ku–Bı„™j.É‚·eéë§f©Á×[!c­/´pk®µ˜Et¡5ä€–hÕv?É]ÆŞkDZÛ\\}vNu”P|u\r!•r¡-ìêæ”£ÊŞî£™q¨üÓkHñ#P:Dç‡m´@‘Uveó0—8óåi÷oR•ES½rA)(¦ÆÛ³!9ÑHt±EŒ¶]mƒ”IU÷ƒ~‘T•¢’ª~êÏÓk—bÕ™X\0º—€ÎRI*¿æÍÉÉBï²ã{Ÿ™ÈöÄš-8Á}4Æ]®Øï7›¬İçŞ¡#›Ò¾¶Ôw­µ=ıßSjÛÜ¨N÷‚s¾\rmo‘Š±˜ß¦÷ÓNLo·€³§K²Sœ—­ùïŸ\0;ö’\"VdlXœ`9˜zÚ‘Ÿç¸˜=õ°û}Uœ·Ò”—~¥EşIŒ1†×wõ¹üfoj\$[c‚ñÙ„};„tÅ®@HXúe\"–¾!Ws++‰ˆX`=Í\nûñˆÀh°€cÛ¨ÓøÆÄÄDGqškÛó—‚ºÙ)¦Å¶xçWbõñÎıÚB+îtuVJŸÏÄ‚Î‰ßİT{Ëp‰0VGùíá¾Ë²o¹Ş	xµÕ\"å¥+ˆD|†S´‚B´ÇĞ‘œ/g÷JŞ,âoQù-Aí~SK_¥çÇ”ä˜¡ít˜[Q/ÌL‡ÀÀö†ûì‰I¤wIÌ€D' X’¹yÂÆE’âä†¾^ù‚sz\rû„]œÒ3äP~ÊÖ²â¾H–++Á@œÏBwƒßŒwÆ’«õT*`;®—yëÉS‡ü&KÏ¹éÌôïse+ùµÿ…e±F:qO\r\\UDB!„\"~ºh`2ÊÜìá£,xm’©–®G•Kb¹eªØ %Õ)ixJ?—ó#£˜¦wIŠŒøÄrm’ÍDf»5ï\0006ËşŠ[›·©2é¹…>P‰¸Mwa§¡FØîQù8o¦´6²“I Ş`Á5æ‚@'£ÅæqË¥A6²ê¨µº¯S|˜ºÁªãÿW)Û4SU`1ÄÒ~ñJ\$áÖ«\rŸª‡Ö¹BlB°m*ÖOµÙ`®ö]ÔP6ÉÂh U€\0‚@\"€€	àFERÇ’4L\0°5şr©GL8\n4œ*ªŠ ²£N(@0¦Ë³àhqÁİN›to‹æÉX‹L	àFmb¾Ø{ÈÉØõ»Z-0’g¶	ÁFºÑÚÑ¹~Ë¼=™{	¢³ sœÊÌ¥q-Â{áYöÜ7-¤’,ß\0Úóz‘ª6@tíÖR{¬«ÅŸ…F…o9úÛærÔ/Ê7/—7Ë\0•3¨Bƒó™Úƒ~ÒE)Ÿbq-y fT(ÃÅ\"u®ŸQù{ÅZ)CHS_Jp*;Q\\‚÷ÓUÁ¡d‰Y˜¹uÖÚï‰Œ6ëâxhw>Q‡¢ Ğx’éÙíê-ZÑİiCT¸õÉˆBèÊ‚@ø8à¦â¹ğ‘ìS€¤¤\né'I¨ëáÒ÷¤TæJ0ñ^ˆÓ­Üğ:xÕú hû´íèˆj”€·ÊB?´íåøĞOÃ¯Ÿ™¸¢7ìÙêg¢®.Ÿœ9ß-yˆşdUç” [å?*„†ŞPo–ëåÅ3Ú8ºó¼Æ;@ÀßÌá6óJL¼Öo6£‹Íäó‰ï€eèt+‘§¼â.°P5æ÷õN£òGƒüyÒ\rL€»Õ^@«ŸÊÖ—„C²ÓÎóSÖ’•zÖªä_¥F\"6\rgâñ×÷`-õ×“={Ûì¿û¾%òO“¼—ß¬V®ÍMhô»ıQ13höı¾aˆ	§£'èåbåC¦ƒH|ğ\$à…*ä>Ùö…<èßmù}'ÒFH\nü /L\0ïŞ8ºUÏ¹…ÏåA–‡C×\"ö§»½é°:wö‘4è.H\\…ÎÌúŞ¾sôGÃ–WïÊ‘úëâˆìPÉCû0˜ªÊ‹ƒìø·r©{ÜÖ0—ÃÒîÓ¶¦-­›ˆ‚aÿÂŸt»rŞï¼©ÿ6§u:ğ»|[¹t­`%<3+q¹ÄBÜ\"¬±	øS\0+óÅ>!ƒô¹`àLJçâoÀ_õÇş	øæÿT÷ø™J…oóxnlµ)úß×~½ö\rüš N¼uŒ ƒ£ŸØ˜8]æî‘{‚8-NôSS‰ß†?	œQ€ö¥Z«YvÈ62’¸ÿJ0ÃÀÅ_Æ€°o%¯ ´ö´É@! pHµğëÙA‰h¸Œ&I“Ëƒ\0!Q§ZyËrİ\nİ\$7ñí#@Ìl³èìŸhwˆŸ@Ÿ¥™…Ds%àkóíišˆ4	¤]\nk@ñ‚ÊÍ<HÎJyáË§èê]×˜‚şh\"Æõ°Gõ.@İ€#5PnDÖĞSõÄ2üÇ{¿Gñ2{ô*!¿ÀØ€à\0¿Ì#ÁW ‚ıˆïğ˜Ğö9ÃÓ†¤Ùù_Ï\0s	 \0tşœAÁ Ò?Qûçğ¿¦÷“ºı¢0×ğq€6=ô\0Nk¼ù\08WÀÀ0í“^à@„€:5ï\0iğ	6zO\nÀøâ*ÕÒ”QOåˆŠ.ûøoÓ	rßàæK ­¦Ë~cY¤ü”™4ÀŒ+÷F5–!éû©CÀ‚ıi*c?À33ú!C:üÚ\\NE\0ú");}elseif($_GET["file"]=="jush.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("v0œF£©ÌĞ==˜ÎFS	ĞÊ_6MÆ³˜èèr:™E‡CI´Êo:C„”Xc‚\ræØ„J(:=ŸE†¦a28¡xğ¸?Ä'ƒi°SANN‘ùğxs…NBáÌVl0›ŒçS	œËUl(D|Ò„çÊP¦À>šE†ã©¶yHchäÂ-3Eb“å ¸b½ßpEÁpÿ9.Š˜Ì~\n?Kb±iw|È`Ç÷d.¼x8EN¦ã!”Í2™‡3©ˆá\r‡ÑYÌèy6GFmY8o7\n\r³0¤÷\0DbcÓ!¾Q7Ğ¨d8‹Áì~‘¬N)ùEĞ³`ôNsßğ`ÆS)ĞOé—·ç/º<xÆ9o»ÔåµÁì3n«®2»!r¼:;ã+Â9ˆCÈ¨®‰Ã\n<ñ`Èó¯bè\\š?`†4\r#`È<¯BeãB#¤N Üã\r.D`¬«jê4ÿpéar°øã¢º÷>ò8Ó\$Éc ¾1Écœ ¡c êİê{n7ÀÃ¡ƒAğNÊRLi\r1À¾ø!£(æjÂ´®+Âê62ÀXÊ8+Êâàä.\rÍÎôƒÎ!x¼åƒhù'ãâˆ6Sğ\0RïÔôñOÒ\n¼…1(W0…ãœÇ7qœë:NÃE:68n+äÕ´5_(®s \rã”ê‰/m6PÔ@ÃEQàÄ9\n¨V-‹Áó\"¦.:åJÏ8weÎq½|Ø‡³XĞ]µİY XÁeåzWâü 7âûZ1íhQfÙãu£jÑ4Z{p\\AUËJ<õ†káÁ@¼ÉÃà@„}&„ˆL7U°wuYhÔ2¸È@ûu  Pà7ËA†hèÌò°Ş3Ã›êçXEÍ…Zˆ]­lá@MplvÂ)æ ÁÁHW‘‘Ôy>Y-øYŸè/«›ªÁî hC [*‹ûFã­#~†!Ğ`ô\r#0PïCË—f ·¶¡îÃ\\î›¶‡É^Ã%B<\\½fˆŞ±ÅáĞİã&/¦O‚ğL\\jF¨jZ£1«\\:Æ´>N¹¯XaFÃAÀ³²ğÃØÍf…h{\"s\n×64‡ÜøÒ…¼?Ä8Ü^p\"ë°ñÈ¸\\Úe(¸PƒNµìq[g¸Árÿ&Â}PhÊà¡ÀWÙí*Şír_sËP‡hà¼àĞ\nÛËÃomõ¿¥Ãê—Ó#§¡.Á\0@épdW ²\$Òº°QÛ½Tl0† ¾ÃHdHë)š‡ÛÙÀ)PÓÜØHgàıUş„ªBèe\r†t:‡Õ\0)\"Åtô,´œ’ÛÇ[(DøO\nR8!†Æ¬ÖšğÜlAüV…¨4 hà£Sq<à@}ÃëÊgK±]®àè]â=90°'€åâøwA<‚ƒĞÑaÁ~€òWšæƒD|A´††2ÓXÙU2àéyÅŠŠ=¡p)«\0P	˜s€µn…3îr„f\0¢F…·ºvÒÌG®ÁI@é%¤”Ÿ+Àö_I`¶ÌôÅ\r.ƒ N²ºËKI…[”Ê–SJò©¾aUf›Szûƒ«M§ô„%¬·\"Q|9€¨Bc§aÁq\0©8Ÿ#Ò<a„³:z1Ufª·>îZ¹l‰‰¹ÓÀe5#U@iUGÂ‚™©n¨%Ò°s¦„Ë;gxL´pPš?BçŒÊQ\\—b„ÿé¾’Q„=7:¸¯İ¡Qº\r:ƒtì¥:y(Å ×\nÛd)¹ĞÒ\nÁX; ‹ìêCaA¬\ráİñŸP¨GHù!¡ ¢@È9\n\nAl~H úªV\nsªÉÕ«Æ¯ÕbBr£ªö„’­²ßû3ƒ\rP¿%¢Ñ„\r}b/‰Î‘\$“5§PëCä\"wÌB_çÉUÕgAtë¤ô…å¤…é^QÄåUÉÄÖj™Áí Bvhì¡„4‡)¹ã+ª)<–j^<Lóà4U* õBg ëĞæè*nÊ–è-ÿÜõÓ	9O\$´‰Ø·zyM™3„\\9Üè˜.oŠ¶šÌë¸E(iåàœÄÓ7	tßšé-&¢\nj!\rÀyœyàD1gğÒö]«ÜyRÔ7\"ğæ§·ƒˆ~ÀíàÜ)TZ0E9MåYZtXe!İf†@ç{È¬yl	8‡;¦ƒR{„ë8‡Ä®ÁeØ+ULñ'‚F²1ıøæ8PE5-	Ğ_!Ô7…ó [2‰JËÁ;‡HR²éÇ¹€8pç—²İ‡@™£0,Õ®psK0\r¿4”¢\$sJ¾Ã4ÉDZ©ÕI¢™'\$cL”R–MpY&ü½Íiçz3GÍzÒšJ%ÁÌPÜ-„[É/xç³T¾{p¶§z‹CÖvµ¥Ó:ƒV'\\–’KJa¨ÃMƒ&º°£Ó¾\"à²eo^Q+h^âĞiTğ1ªORäl«,5[İ˜\$¹·)¬ôNô\n«[Ğb÷ƒà|;‘éîp»74ÍÜ”Â¢¨ĞIŠCË\\ŞX°ç\n%øhØIäç4Ïg‹P:< ôõk¦1Q™+\\ÚÈ^å’ ™VèøCàòôWàÃ`83B-9F@ànÃT>»ŞÀÇ‰-–¿öÊ&âÜ`9q¦…Çßä‘“PÜy6Üå\r.yñ&£ñ´ÎaÌ‰ÍÃE8Ÿ0 êÀõkAÁ×VÛT7ñpïÆxØ)Ş¡~¤M½ûÎß!áEt§ĞùP\\èÄÏ—m~c½Bğ\\\nímŠv{µÎù9`G[·¾~xsLî\\±Iõ®ïâXwy\nà¨çu¯áÁ™S£c»¬€1?A¼*‡ùÍ{œã½ÿ´óÍ¿á|9Ş¾/–òş¯Eúï4æÊ/¿Wÿ[È³>–á]ÄrÊı¯v¹~B£ PB`T¡H>0¤BÒ)ğ >¸N!4\"‡À¦xW-ÅX)„0BhA0à½J2P@>ÈAA)„SÎôn¼ìnìO˜Q¢¬ÇÎÊb®rõÔÒ¦âöàøïhèí@È‹’î®(–ğ\nì†FìÂ˜ñÏ–øÆ™…(ìÎ³¤ÛP\0÷NÂõo}¯‚l«<ønŞø®ˆâîlëoq\0/Q\0of*Ê‘NÑ½P\r/îpA°Y\0p\\ãï~³ĞbĞLh °!Îã	ĞPöîd÷.¿ïy\no\0áÌËĞ¶öPptùP¡ovĞ‚kn¸\0z+æ›l6÷°©¬Êø0’äğ¹P½oF€NìÏFô¯OpıàN`ÜĞÖ\rogğá0}PÍ\n¬–@°”ö15\r±9\$M\r \\©\nggìÀÂ Ø\$Q	\r‘“Dd‰ÆÊ8\$¶ªkşDâjÖ¢Ô†ö&€ÓÀÊ ¶àbÑ¬˜ê°¿‰›	ñ=\n0ÊÕÀúºÀPØ ~Ø¬6eö½¬2%Íx\"pß@XŠ±~«æ’?¬Ñ†Zelf\0ÒZ), ,^Ê`ß\0è8&´ì¨Ù©‘Ñr€© ©ÃkFJÂÂP>VÆœÔp¨²8%2>ÂBmÎóØ@ä’G(²ä¨s\$ dÕÌœv†\"Èp°wÇÆ6§æ}(VÌKË ‚K¬L Â¾¤éÄWñöqú\r‘şÃÌ¤Ê€QòL%’PÔdJ¨¦HÀNxK:\n ¤	 †%fn‹ã³%ÒŒ¿DÌMü À[#¢T\r©ÀrÂ.¦LLè&W/>h6@êE ÈãLP‚vÆC’ß6O:Yh^mn6£n¼j>7`z`Ní\\Ùj\rgô\rÈi2I\$\"@¾[`Â¢hMı3q3d’ş\0ÖµÈúys\$`ÖDÀæ\$\0äQOf1ƒ&‚\"~0€¸`ø£\"@ZG¼)	Y:S¨ê†D.S%Íˆ’ Ğ3¾à d¹ÀmÓU5‹æ¬ó<£SÒSZ3â%r “ÎãÆ{óe3Cu6³o73î—³ÀdÀL\"àc7ÄLN ÜY Ê÷k‘>²‚Ç.æpäì2øQôĞ÷“¼åÓ3ÀVØ°WBğDtCq#C@½I”P÷DT_D´:ÔQ<”UF²=’1ô@\$‚‰6Â<cÆrÅf%Ô¬,|“27#w7ÌTq´6sşl-1cPÕmğqªÊ\n@ÊàŠ5\0P!`\\\r@Ş\"CÆ-\0RRˆtFH8µ|NíÆ-€Ædòg€‡Ò\rÀ¾)FÆ*h—`ö €CK4Ã1‹ÊkMKCRf@w4BßJÁ2\"äŒ´Ó\r1Q4É2,\"ô¤'¼êx§Œy—R‚%RÄ“SÓ5K”¦IFz	#XP‡>¨âf­É-WX\ršÜê¤pU´ÕDÔt&7@¶ÂÑô?’©ÀÑ ªµ£}O1½2†‡2Õ#UK*¤)ôê¸‹Œ0o<> ]Hš„Æ¿rè›LGNª›ê˜W%–™M^’Õ9X:ÕÉ¥N”òÕêÔséE¥­@xy’(HêÆ™Md×5<52B– ğ–k!>\r^J`‹IS N¡¥4'Æš*œ*`ø>€—`|¢0,™DJ£Fxbèµí4lTØ•û[¨§[é•\\‡¦¨Ô –\\{­Ò6\\Ş–’ öß(#mJÔ£,ı`©I³ûJ‚Õ­ÊÜèlß ûj…jÖŸ?Ö£kG»k¬T9ÀÛ]3ohuJ©ê¢®ÑW•\rkÕÏ)\0İ3Õ€@xè¹,³-Ê	5B”¡¶˜=ÂÔà£#–gf¢¡&Üß·Z`ä#ÄoíæXf È\r ìJhô˜“À´5rqnzõ§­sÁ,6’oÓtD´y‡äÂb´àhş—Ctn˜9n‘ í`§X&¨\r'tpL7²Î—¤&—¨¼l¬Z-Í¬w£{r—¤@iUzM¿{rx×—mÒSBÀ\r@Â H*BD.7¹(Â‘3XCV Ç<WÔÑƒİ|d‡q*@”ş@ŞÀÊ+xø÷Ì¼`á€Ï^™Ì˜ß¬__•ND­X\0Q_D]}tõYÅúp¦f€wÔÚ\"â3øz¦nÂ«MYñùZR\0÷¬Q¤?¸{†M3†•£*×1 ,¨\"Øg*U¡*²¯ˆÌ«zÒŒW5NV2O-|€¾ÉÓñ,×]‚B×dí\rŠñ/OâtÎøÃï‚Ì0‹xÆ†ğ½Ğ®OCë8Ş-0Ò\r”ÿ0à·õ„@]¤XÌŠĞÎğ\\\0¾0NÈï£Ñƒ4ëi¨;ƒØAtê¼8X—x¤\r†…Š“‘ìÁ‡øİŠ×Ê7¬<ö@SlÈ'LÒø9W ÊÎ¸òÏ¬ÖËì¢ÍÄ±•ùRçÌğÌ\r¾Ï ÂÏò|ÜXĞÖa÷ø7y€Ù\rwe¸Œù„Y!ƒ˜Eƒù’´šÂcRIdBOkË28[‡mÌJŒ+L ÈÅÙ¸OXpføÓ9ÑDÏ›·¦ßªw“@Ë“—Y—…¢Õ÷\\yäAcÙ£ƒXgš™%šôó’Â1“ï“j	œX†9Ccİ‡àR¡¹‡”QFÇpdÒ= C˜÷ıš\n\r¥Õ‘ÔóšdjÙ«’xE¡Â2FX§¢x_¢ØÅ£Ú5£™—}q¨Åí¿¤M%¦ZM™:\nÏzWšX7¥åí¦:ĞZi¢npY;ù>Ê˜í£ÙÉ†:6Ú;£ZÎX0ƒ“Ì¢#ùıcàMyU…i2,q¹FËšÈb­J @ÓgGè|4ógÈÒmzWõäÊ	¬)™Èr|àX`Sc‚Õ§ÀË™„óc—¥‡û!²B²—±”»/}{4JÂ\0ÒÃn»Kuz @ÌmÚÑ®€ß­yÍÒyÖ\"º)u¹ÊÂÙã¶Yç˜s·c¶yë‘¶š‡··y¼—¹7Á|·±|—Å{Ï˜*)°Ê4Y`Ïµ[v¹‡¤­‡û^NX•†¸‰†ò‡W”©û·‚7†;¾_‚‹*x™ˆ¹Ú\rùß¼ß‰xm+¾mû¨Ú™	´»¹‹\$\n¾l˜);™²„|Ù ßÚ™¡:œNÚ :„‚Š_È8N³¸Uœ5;¨p+U–L‡ò\\‡9í¦Ùñ“›¡»ıO:I’šû zQºœ¡ƒ¡TëšÜ)ªXG¡æ»ÅJ{w8“¾ûÅ‰¸UÆù\$ôàÃøü›PxTY¾pjh·¾J×Ã€›˜JÙ{‹Âğ@îÇ‚³ øğZ‡ÌÙs•¹hË˜ç–XÌ\0Û–lÓ–ÌàÌÈÎ¸Îçìó‚Y}˜Ÿ®ü^Ğ@u2ÀSÚ#U‰ˆ;Ãˆ|¼¼•¥¼™P\\ŸÊ#ùÊ|ª<®İ\\³À›JÛ‚,öœÀ•\\ÅÌšEÌú…‚]WÍlÁÎ,£ÍìÉ–<åÎŒÛ>YnÎ),Î™rÎüûÔ¼å—âº]Èı	ª\$õĞç½Íq„DJí=•Ù÷•XI-ğÅ€äÅÌa‡llÃµ]\\“w(iÜCÄ×ƒtƒ‘<i-u[uVDÖ“¸QÂ¸€xb€kæLI­.kú›@ŞÀ„ÜN‹“[ñ¼l<o=-]1`è”¼ªdš ÜMÌ7‡@Û%C=]ú›êÀ/|-àÜˆ¾ÉŞáqÃã•âíùâ*¾C¾òO~ÊQâòså`·ç(âòãDÉßÉ²¿à[ãşæ>Éká¾R™uéŞ\\+>)3íûPÊßP§Óí6ÓËM%º¡¾pÔŒœÅAĞ3qmu2ÖfzƒÛ¯ì4s‹	´í`Û‘ì°-kÊS%6\"IT5½‹~Òì\"™íÂUt_	TuvàÖ½ä¶Yw¤†­0I7¤’L‡\$ú¿1Mí?íe@3Ûq{,çÀÏó\"&Vi·àÔIŸ?¾µmõˆ™¯UWR¾´\"uiT‹‘uƒq­Ÿj\"•GÃËõßò(™ï-½‚Byîê5øcİõ?Œàwñ®°ëTúî’`ei¾½Jtb‰gğU‹3ËëÉå@öá~ê+¾Íï\0MïGè7`ùïÍ\0¢_Ô-ùñ?\rîVÿµ?øFOÔ6á`\no†ÏšInª¼*pà™öeÙí\"T{[Ğ“p^÷ä\nlh@l0[/ö„poóJKÖX“ñ€ü<ª=€9{Ç¾6ç–<eßAxãÀùÇ‚¼Éá4x[ÍLò“~>!åOQxš{ZVFÔ`½éÈ~Iß–“øL)Q[ëTûôM›àşT²*BC¤~	æâ‚ä\nƒò¡gÃˆÅ…p9zKÉ–ówzO9di^›'‰+¹ßïDz4ägHAº¯Lyô¡\nr€<IêjKQó¸Snô==\r.Âo7Â½Êé%a;‰kÏãmX¿›Zi%P¨iÏ\r­€¾ıµ/©…L`pR0¤&õ—I (Øá\\.£*m„*(ÚÖõ—\$ä†ÆÀ÷\nw×ŠĞ¥…8a“\n&´Â‘ÍUmª MÖ¨P+\"Ly„ó?¡M\n€2’	L\nbS ¥NäùÇr¶!w¥jw`¼Â\$îôƒráè…Êaáv±^Ãq­F‰Ü6•Ó¨i*™Ÿæ„ì_xõØ\n‰fğIê:B&ù6@É“KED¡úú·QD(V`.1\0Q\$íøF­¹H®’Tş€zĞ†‹Ì\rªjkzM€ĞÀ®Y™À(61€”x‘+®%dj¸Æo\nÂ¦¬\rg°ï\"ÉŒ´ˆ—?Œ1- 3hÏXÖÁ)åyjÃ5r¢N±#Q¾¼Š¸w{_ş¡øG)ÂÎÙ1i‹Ì íç¤<Z‹ºpX³¡Ö\$â?¥=%.´€Ò®&¾­%\\±8w­!¤µa4œ<JB[ĞÄº¦u4‡%êŠ×47‹Ä%gÑä&¸€Z(@	€E¢{@’Ğ#¥–2Šh@Œ#ñŸø™ÑŸ¥£@\$8\n\0UŒìjãA(×2ÀO€Š8Ú€5‘¸Œ¨@†ğ&'´\n€D\$i#À#Ÿt\n PTs#]P*	àDÌuc› PÀO|pc—øËP	Ş¼i#Ô}ˆæ:<ñí\0\0¥ÀˆÅ¥lo#}ÏFÜR‰Tp@„À'	`Q¬ycTp(ÆŠ@€eh\0‹˜Õ8\nrx› cş<`Nˆã:)DY\n*Dı‘2{dZ)A‹Ú4±²¤€cZLğ2ÈÊ<ñò\\Œ\$r#ˆşÆö7ñÁ¥°!û€´ü€Nª{O¼@\$<	Ñ¢ğVƒZÒÆ52.Aù#D0 \0´ÀI¸û\"P'H	²_)¼x@Š€*úàAOh£hI)I²L1¦’ìƒäµ%áJI‚B‘ş’g¤i\"p÷§K2}’ä–Å(CËÉÍ=²t”xCøĞ&FÄ	r“ÒoÙÉ@@'”ñ€%	 ÛHŞT±áˆ	ãÔ˜:=¾)\0.ñ°]Îâ5 .ğæõ(pÈÀL!à8­\0ˆ¹	éR\0L‹YaÔbkÔ°ˆ6Ä)Y·éˆî •Ô®£	h³zZ¦õ±’IgÎVO3oœ­Lgà3ËY2ãÛ‰ÜDoPË`3Ì¸ec-‰r7í‡2Ô—Dº‚Şç‘B¼‰Z•¼¼%å/I{MÃ\0pĞÀÌ.`äÊİo*•Ô¯%T€ı\0 &–iR\n™+Éo€ì©–\rÀ^2q”Ë©\0\\¨I@‚	KÀ#peC*!>€/á%|È…Ì’ÁŞüô\$è)çÀ§1P30(\r¢+\nZÆz„))\0*®\0kà€ÙÅ2¼–Ï…(–E86å¶s—tºf&”™Š¡´“+;”Ø76&ãK–_(›9fÓ,@-ÃÉ4l\$Û‚e7\0ù±:l“LİæM7.\0ˆ³|›ğo–JÛ©ÀÎZ³u•ÌºŠ'Èy{ÅH,#\0vU@9!¼¥	Ñ'†¨&„òGôøß@_-Ù¿³ºt;Üê¡:©µ€²u¡<—ˆL†iÙÎš_ê€Ø£@U6°Îù#ä_€L'~ùæ/Öm`\\Të']=Iäât°Ç¸Âà)ÔÏqùsÉ9Âa<RPÂº|tút&5°äs©lî@¾	ŞKÆwS®èlÍ:9úN®wSø|·göÉØOùAĞŸ<ë‰BÈ€\0/àz@´	ÍÏÁ•Òå†=?=iŞO‘kÓŸ=\0E@iâĞ\$B× hO\0Á>DÖP´ó‹UäçÑ†j¥HìÂ9F¬BcCi‰é­BwM§tÓx€PÀÙM‚?p“®=—äì8ÜÔı‘Ïlg~¨˜tÁa©€%]b\$àØ\rˆr„èÄa,6ÅtŒàW)\0U¨›F˜	|æì“¢ˆvh¦Qú*¥Oƒl.C\$À\\ ĞÖRRÌ<lcù™&Cj3Ñı%ôZM¨öÀz9GpY’â¹£\0i\$Dµ‡d‡ñzt[')[)Q¤ØêŞkÁpi0·#cÃ¾‹ôNE¨ô(ºC2L	Æ@9hÑEJ5Ò,šh{&Jzö0n€vª©>[€j“£Û[œ]ƒK•ıRîJë>.;ù¨íF=RÚŒ<råÓM¡=—Ô’¤ÜhØ^Y\\RmnËĞğ Nn*g‘¦ôÒÅB¬·5^QÒ‰@O¢°x¨¡HIÊT ´â9½)(‘œ&µ‡}A)PÊ\\/êô…_Õ!ÌH şÚ‘¥¤ù\0éBá­\$z4ÓTYu‚J’v\0êƒ”¨…%@æ32\0Sôm€--Gi@¸úQÅ%Ñj©Yİ+FuzlS—”ÜW3ØÅ·OrŠU\$EÔè;¹M©¢\\€Ô±Äu/£õjeQªš¦§,#J¡ªXPÔ<UH•TVVé#Uê™ÔUbˆOU´DZ‘â¢µ£Í8êÕUJuS «À‘g)XDZK‚•¢Bî\n¼@2Š©ìx@d&ü ½eÜ«Ià@ÊFwì¬8“©\$Ù'IºV‚V†U\$²ETÎ_ğ*ˆd¸/áFCÓYdp§vGƒ‰3‰ ‹Ñš‹L^(ù`áj”÷2S¸ºcÛW¨ÜJQYiÖHB”£ckœRè\nş²U\$jê\n„ZAi€î»¢U*wKDRxW‰LÂò­ˆ€+fÚŒ@ã¨A4¢àGz…R\n²5‚b¬\\_²Ÿ ­ô‡¡á0¼C@¤\$X\0+Å]¤ÑÂè\"?‡n¦€+QIj\n»x\r€ôB`S¸âM‚ÈÑûŠ\r o°@‚À6XÀ\"{±\0µãb ¯)–ÁM¨cMğW ä¶D_áÎ±Ğv@{cĞ:¤®%[%‰C²ş1¼Ù;AÆˆÌTn› \0º a²páóe~ÙU5 s©V†İe|M9‡€9 hË@æ¦\0êÙ~É@.³	l€›¦É\$?³idÀ{fB†ÙF0VZn@”ìºSt‰NÍ\0oP™ÃchGóX^V}Û´°’ÓZ,«EÄ€kÂ\rhËGDYd\\zÓm\$UfÚD¿ö˜Á­ë É€²Ó‚ª\rªë¦•^CRÑV£*ÕÇ¢7õX‰&ÓöÁm7eëYÚ\\«V¡4Í®è¾\0>ìZfSÙÆfWJÈ	ÆÕV“\$EíukKP[\r¤\n±¹ÇÇ_q}Lø««£êÁÑ}òeM£ ÜmĞu4’V°İ‡RZÜˆ\r‡®Á	k\r]a“)`ÇX„Bv0±2æÛ‘^;tŒà†À=\"àkƒaYBŸ8J´_«Ğk)f;ÒF†–Á±U„ÆÅ`¢GWN¢Ãw,\rq’)\n(	Ğá´e¼ëîR53\\NW·…Â®EàØš¾¼õåS5ÎÊBş;ŸÀ‹W4¡J	%]5ŞÃAõ°àpmï	ËÜ‚ßÙ\$•È.-KØ!sCçEtî+Dº;›ã7 ¶ıƒêONË²ªäcjO¹PKFO\0İ(Ğ€|œ…‘°k *YD5”äå;s@6´@ØQU—\"Õóó\rbØ?XJÅvç·n¯AH®äoPS\$TËpbj1+Á‹¢f3&™@Ê€Qw8@¡‡ĞÈç;\\ƒã¬ˆ‡¸Ä‰NëÙŞxb#Y½¥¯`:‹ÒËkB¨8NúoëS³(#Uİ©ı(ƒ³Y;É:×eÄ¹…ô­±kËn¿å e¹Xí´ZîßMi&é¿\rõÇ^»ëÛã€d\"ÔW«\r~[aV' (#Y\0Ü}`ƒW¶.u|4V§*WŞ²l:¾İ÷mnõ\\Üà™\re¬/£ikmÚÖš”ÆUEü0#j[pæD¾®/õ^ñh„f½WøÀ¸ïÏ‚L\r_®Çá¬¹-ŒTX [*¸¢q•n\n2Ù*Ç–J±ı’¬…û\"YüvQÀT£ô2IÃß·=ÂD÷ƒGñØ‡õ¬KXK\"ğ½ğ£÷E)\nYmÆ4!}K®_íÂ D@á„wmá(\$@¦ƒÆ\$AŠ”jÊ+Æø\\‹4Z½Ä°vÒd¹SmÅXÚ!ho!F0l†UËzİ8Xn#\\Íˆ_…\"Ë˜`¶âHBÅÕ]Ú3‹ü«¡\"z0)7‰‚\\”ŞÇâÔwñ.…fyŞ»«(£ôí²‡¸ pÀ0´¸\0XªS6+	*\\Q’à\r\"ÿ¹<bñ°áñ\$tŒDqŒ\"‹ü	?ğ¬ñiŒ«o¬¥],ñ!È{€g|ãg¶\$(ø¤<v„…xáÅğ¡˜£%GèHõ™ÄœÆE\r ÒX«Æf=„Xà)†ÜQKŒXqîÁ:N_¢ÿ5².Ö(ñÃkµœàgBZ768C‘cr­¸¹¸²,<Ã#y!Èş\rÑ§’ešWtEÓZb\0Q‰%˜bÿTèÇ­ÿûrp…·\"Ä(û±A%†`xba}P™0vL1&>0şdôD c<6P™3°…‡f¨À„åVD~íÈÊ µÂ9b\\IÜ,~ïÈ\rxs\0Ş‡ÀˆaK£8CEšÈª+×Tl#‡‘×¸äï«¡°V\0òå‘|>çŸ\$h®G8XIĞè@\nTğ…æ¡™æ\$Ç9Œ,íBt/£†šu@s8ÓB…7€ªsy˜¨€Õ™¹ãìş‡‚,è]çßDy‹5–ne€àÆòÎ¼şŒ9)jÌ^€á\n78Y¾<çU<iêÒwùÇÎH\\Âë˜êC…×4cA]ïXŒê8)\0lpSÂCgCM`QÆâ¦)Š¯lè(ø.'¤¶=a­Ix·sÃ; …Ü™ß¨TB¦{ŞÊx¢àp¼ĞpáU¡¦lô¡§T Ë2“´>eÏ™¤fu99 Íåô\"^ìÖ75ù’uiô'@h]L9¨›^†æ×¡Üñ:»D9áÌŠ0ódbüì¹—6™Í¶n› ™³»7¹¤Îs\0_œ •ç2z¹Î°¾çÙ72N¨Q“º”ê/ 3¼èA:ƒtHÅó=´‹Dú=ÍÍ³y?£Ái8SÈ¢ˆ]´×¤¹ögCIîh~P£t§Fé^uÂàĞ5¬4· Éäè;Fãu\"ş˜ô+›yâ•?úÏâüóş\0èÖˆ:ÌÊ˜u\r<<ËĞw:*:jÓå: -Ğƒ8IØˆ\\u%›J*wS©¬Ô¾cõ3;yúê‹KÚ6ÕHƒ‚¨œÎêKámu£æúiLùÄÓTôô¦İ%ÓN:NÎ‘àµyª\rbfšuYª =õu«E3æÿ4Ú­WN…³>mëInôô–x&Ğ„ğ'šÕ\0sˆoŒ×k_RzÙ^È{u}©ŒÛé—7zBÓF·óƒ®-di¿YYÏÖeñµœ 9kCHšÒnµ'ŠÀÂ€ü¤×–ª5è´Í{ê»_:?Ó6¿5‰®\r€g/`ZLÓ–t§Ñ± -€è´Ğqªµé£÷|\"ºG\rm‰d<z{)¼B-\nÁIN\\ñ\0¼AÀsx\0Ğ›ÜÅTm}Å÷²í:h™c°NÒ8ö­`ìøà/°À°O\0\$0K=€ÀF\$y\n\0‘´ -ÚPvCx‰ZèKIÙO6…c­›”g;;±FÅ›µ½ í¶4@J_ˆ@§Ÿá\0©€Å€¢€^yP­@OÍ0âv‰9ÑJn ‡Y.âC]¸Á”öp…ö’Áîs‹ô~â·A¸íÒXæBx·l¶-Ôîoq­ÜşTw`hmÓvÄ±gÆîw\r»½×nût[±İ0EÀó¼3ƒxÛ«\nï7¼ <ôùn0öèŞºxÑmiDÜÀ	÷Å´\0ğÿ|»ç²úöò)-·}ÛHÄé#·æüCĞGu0Ó®ş6®}¬íÿk€RÚöØ6Ä\\ôí—z{ÈİîãwE¹\0007îHû”xq¶ˆ„„;åÜÖñ÷;½m×ğ?r\"Ñàåx,ş'Ëƒ{û?w©¹íëğ;qü#ÜŸ	±´Q<ğsu\\áèxgÁpSrÀ/58u»®ï'†\\à—¸NàºÉ \\Gàöë8•Ãî&q†ÛD‡*ø©Âşoc‹<5à¯\ræ.‰Îš»iûq×¦­¶é¿ÒÙ¼\ràgÅlïÀ^\0˜äAÀ-	T‡@Ö6]ü§û\\\nîàëÂÀ(CÑ¢oŠsÑq§AÆÙ{™|˜Éú9æs¸h\rSšiöÚô6ÿ%à\"g1„òAõÛz„EÜ÷ŠØ9òå|	¶+Ê ŠB—2yäQøÎCÆM\$%sL9©¶'Æ 6ôdäm\0†H”	™!˜?(\0œ >sX\$œÙxÀeÍ^n„ü PIù€¢ *\0ÆüæçG6J¾Q‚/”éƒhV[l\n(E®¦ÀÌsqÊór	%\0ğÈ•Œtfàwå€ª)æqdáY8Hş)ğ¬†…<à¸ä{a)•àEØ@³@ùÄSÌ‡ œèØzW¸P!‰g¥á\0âux;Èœ¦	œÑ@8 Ş)ó¦ |éÀÄ„J®.† üÒºâ®¼<N•NJ]>€ùs{‡ó¤Œ\n¼Ø[CÕ¾“\\¬›â¸¢ºÆ~`<Ñøg©\0zÎ–‰2t–ós\ro\\æÂº¥§\n©mãL×n¿uå-IlÎ\0vyüÚ>	LÆw1è”Ä;ÕneÒl¨É5`ÂœëŸ‹2Ï@:L˜î†¨dç\0\$°§Ã–U°>]l\\)\$C\nQªŸÌø¦óL€BÅ†í}‡{1×¾	;t#?á {L%1OÒ/¸€vSMeğ‰¥®C×›\nË¯L<¾#Óà•@b?tºM 2t¹*ù^(ı‡,ƒ;ôÌ7˜Ø™Ï[yøş?²¼‹¸x ±‡ĞÉ+¨3½A­˜uˆcßÑ‡g}ı3ğÇD-\$ƒt»²ìø³\\æÌg\nû±\$”\nñ*‚:(ÙQøXdï~ÇŒ02x%İŞè¦ÂØÎG=ğ-Á…:;C½p…ŞoÀS}ITQOô|#€pñrZ\0™Úòø“µ„du7H/6…ÍM0Æ=G@*#'Ë‘ı†GG€ü«¾œ©MÔØ’Áò:\$4¦à²Ä¾G0ÅÁ<·Ü™÷¯&A(Å¢b›Í¶G\"yçòÅ@Ç…\\+ç¸ˆ>X †@“âÙùğ¶Äºğ˜ÍÈÿâîÊ	şcËğ3Ò <ùà+ d(Â€Äú?Ò!+Â¼WêQñOzkÒA¬İ£‚3éQ\nØ!e'9=Şç—ŒYŞKÓ©©³KÏ\"ÖÔ¦şEÆvq¦/o^ü	®ï8DEşG€û;8Åò\"èo7–Pød´Eİ‰ñ\rÜ¼8¯{ED°´}	(.â”Üš¢Šë±Ä\004ú\\‡=Å2·ê?H¿v·Õ~(exå=~#€>SØl„÷ÍAy• SÙ|§³ïœ”ÉŞ²2ÅÿââF†¿ ëÆèA}Ñî¯l,’C l÷¿„¾5b}ÙãàløÉÂñ¿ƒt÷İ§ºUfWß6¥AgW½„%:”g·%b*öß¥Ä¿ëÌ¦y8.ËâfI-ónÃeÜ ¾z§’}fQï¦};İ%×Ô}eõ0‡x¸BRõ¥:>«è›`ˆ”ĞeØ†[z}{êªÓŸ×>¡öÏ·}gË_pú¿­	UöÏiU¯×ZÊ¶VØÒû°D”<;Cb;ıÅ•áüEÁ|•õO-~3ŸŠñwä¬K÷ŸÃã“é\0tgÎ!ÓÈ~cäsV}¡Â²púş+õMû¯ä?WùNc\rÇö­ú¨mL,Ól{äe(¼Ørÿ`İaè!È'¥ÿ„¿İ}(•Y1U?to‚Fˆùù!ıÕˆÂh|ÿT\$Büoö¿®åpäXhXäıè¿Ä\\~ê°€iÇ€Õ,³dôÃ‹ÒşµòXJ†:pmĞ°AµÿŸmÿò!(Îhƒ²ÃÙ@:\0²u0\"à6,ªu0Kï€69p>®»¨Ğ\"È\0(>Øey1€ˆ¤xYÁ£…£\0xBnÄ€ææ#Ã€<Š?\0#/ÂÀ²œa£;u Û‚½\0\$@2À`O 2@`ù;@Y >€7@³ÚÉè¸@B*¨«\0Ú3ã¿åÑ¿NX+´®Æ?6ìHçà:,«›±õ?¯Ä\n *¤ÈÁñ#ËÔ˜!¢=Øf[¬;«¢Ã¡½Âñ|L]£˜¸ÀâğÛq®ÿ»÷[”á‚–N\rª%k «P0§'<6º(DAO€Œã”B­¼nèñt/Z£rë»!1^Ï¡ÔÁû€ØäI/u…±C !k½ÖšK×`Œåû\nÀ€º\\•+Ìá<£ÕIïÏOÁ^gD ‡#Åc®áü\0Ë¹µ°Z”	£ÃpX‚8Ğ*p3>ø \nNÔA„, ;†¨ïcØ¡œbìØ\"ïŠ>%P!IKTë¹JÄ·Hú[ÙÁÄ†õ«&€äóÀpR<û»çfº\\¹Û‹ «ÎùKÛèÀÌôÀä(V¼Ø;\0Ú‚y•ìµ„êŞãß!³Ú)0°x½ò(ğPz@jÂío†„„Ì\".Ë @=98!¤Aö`\ra€b‹äÏ69è\0E¯’·\nkä%ñBHøä!P“€Ù `é°ì\n›§¯¬‚ß€š–*d&oƒ‚T3ä‘Áö%Säh”\0ñûäëB) 6B`RÅ!‡î€èé€ÖÂ623ép¬\0çÛ 6B6Ä9|@àº.Ëp@>(Vú@•\0Âí¸*a/ºÜ²T#&¬(û±[‚+¨¬0h†„ìÛ,¡O\0È¨Ï‡†»r\rc³À9\0îÂCêÏ™ÀÌ›¯b\0Èš9e/¦.š°ó¥C9ÀàühC.„1ÈöD ¡C:p„ª¸ç8\"O†¦”Y0=€†„üØ•Oõ±áÌ5Ğ]Œèù\$/Ã2ùC/Î§™\rªÅ¹ğ¬7’Cf¬.`9;+ ­Àº&ÇƒÙ\n“ AªéæLê¸\0002òõKùoK?pş\nCĞ½¿ˆò1¿t(û«İ=ıĞ6ğÒ¿Ôc£à İÂšıÒaÄÃá\0l¯İVôHj¯€˜ÛÏnVƒà¡ŞkÎƒ\næš¢>ÔíÌp½£Y<;l¾€ÒT:1–bŞ‰ÌèÄ–O\0Ñ}n€\\\n@Bn‘>˜\$#¥Á	¸‹\nˆ!‹Í„&A8BU&kg)˜P\rdE@úÄX ĞO¦;ÔË§«z–bğHBp¼>™ÀLàB*›™ÑDˆ q>˜ætD`6\0³,Iq\$DP£ÔJ !ÄX±DEÑÄb£™ÑŠ=ÜK¥ÇÄr«™ËD´ı\\CÁ¸Ä›|êçDRı\\Jàˆ†…8n1/Dk¬LOÕÄÌş\$(‚¯\nÀı\\H¯:ãa‘'D¡JQ7Å´E±9ÄùI;=k\\FïƒÅÜFºDåûÛ™Sn¦E<Œb°E8%P¼ENñÌL©j†© E\0006;Ä¼0VÄ6À%HU»\nàZ/»X«Ä •\0 Y*…á³»|VàÌ¼ìúñ1dJ¹sO[&š2Z1	»*Š \n‚=²ŠÙu1mAñ#¯hºíÀòÔí)¶Q™_säH¶Àş*]/ø¤O“Û àŸú=Ü_>b=!C„2Œë3Œğp½k’c^¸Ú°¢L\0¶\0€È†8×*xìÎ6\"@”À E›ÊoÜ‘f;»áf˜¼.\"ş;6ÃÊY˜X3¤Å˜†Â«‚Ğn;èë¸‘­èÁ¦’»q3,€óªX8^»Ä ×ƒ‚ô\\.ûº\0¢C±(İ ‚O+¦%P#Î \n?ÓÜ	A=ÆeÃ‘AO\\]Î‚ÂÛ¥ÄÛ=Ô!c) Jõ¨ºÑ>ÅÖ”B#Dí4do½áHAª\0€:ÔnÂÆŸx`  Ôë—¡‘5PĞø „4Ô \0>\0F%X•‰!;\\f‘4”2 É'°Ö;dMsècY@ú³¬Ìã—ÈÎ3¾@8w\$äÄ? \n`ÃªBN@ £€>œu@(ø˜\né4€‰P)\0#¤?Ø	oÌ(\n`)¤¢p[À¦#ì\nCQ×\$ ’”u@ À:\0'\0Š¹8ÈäGn<°4†5´fÑ[í3hŸ‹cÊ(HÒ,êé8±ÄÇ¢}!¯ÓlrM7Ç( ÄrÍ\\¶Ô|J\r´šFIéâ€v˜ùÈ÷º¬¸ÿ®n¼?\0 (° û`'¯:Õ4pañèà=ÇÑTq‘öÇ!ºxÑÍŒ¼‹^ FÖ¬€aT9Bƒ\rz‚X)ıÖ×Ğ‘ò€^¡z|¬àÇTƒ±ÇGÜ<¼s2µªbu*€_!LÍ’€Û!\\p’†† è'’H*D!-H ÚK–áñ',ëVêG¸—ûeÑÎHœ#»jcp6î²Ê@<‚°\r­Ú\0Æx\r²5¼Ú¹MÁ6Zãdp®7¶©#<25¸ìt9\0Ù#£i#|#ˆ\rÈ«(…§\$:?ú¦\$`@Àœ*ä‘h×Ë>@\0ÆhWé	1\$JÍrJ‘+\$ù1ÒG¤\$ükÁEBşS4”Dt\0[Ä”ÒQ¢\$ÓşrXÉ\\0˜à¯5%l“òIÉc	à2W—S%ürZ1[%I£É\rd–'€ŠªÿbB’GIDQ—òHÉ¥\$èR¸¸ø°\0l¯õ%ˆ Â­’îè. İÉÀ3˜òe†ÔœòqIa%œ2tÉRÔ] øIÛ'L+R{É'dtI\$	¯ù›ì4³òX†J+KxÉD¡<¬	&˜PàîÊİ,¡Rl\0Na`Ga<É÷%³Ó²ÉÀ_ˆPèÄ±%Œ\0005É÷(BF\"ƒë'íÂÆIc9è¨ËBşDAá<Éb\"Å\"\nÓ)İ²Q	êB‘€ß&;’‡Ê,ïD ŒŠŞØ%C&\0käùJšû|²¤*Tª-îJ1Òª8X\nÈ2a\nÒ	ZBò=Æ¥ë€Ø+H6²³Éù(°Pœ\0ækÒ`–ÿ\$H¹JØ­Ò´€N;¢ 8\0Z¬+—Cü©Òx%t‰­Ê³*›|§sÉÇ\\© äKéLœÁiÊ¡*`Y²¯#DTt©òÇË:ß,´ÍKD“UDÆ\$¨ãœ¦²µËO,t³’ÔJª\\|*\0À1Ï,¸±’Ø\n>Şä³È×xB1Ëp·R©KFá`ä!¹.,·òÃ¬,®°\$K†#Ô«r®Ë(Ôº\"°K¦åœ©ò®ËŸ*	(Ñ\$¾!ğYÀ1¸ø¤Yè¯1É}%»òº/.’RòK×(´²RøËÔï¼–28‚+I3\$ª€[.x!ªEÊü%ğD\"_K[.Ü³!_Ê¸¢D·¬,‘.ğt²ËK—.ìÁòÊHóÊI\n2\r„¿\"‚½(@ÍÓÌ6\"ü–.e†\0#Ğ‡ ®É%ÄÊZ~\nĞnoœLJ°|ÅÓÂc',¯Ó…‡1KíyÌY1¤Çs¥(À&yÌf#üÆ³-%i-’Ê£--|Â’ÌL£<¶®€ÉÓ0œ³Rë8Y,”ËL´²R«§0”±³(‹0lÀ@ËüÁêÌ*ád½²ì¤Ã2è(³Ì¥*¨g³6ÌÌÁ¡QÌõ2ÌÍèÑ\0Ä,Ïó/M£q¯HA‹3\$³7Lîá`\"MøÌ\"Œ´Î€6Lí3;|¨•‚¡Ğ+\"°Êç4¬Òó>7Ë,\0\$ÁK	4,Î³/¤Q,k’¡–bón@¯JÈ0˜ORÁƒê:øB\0ÀL!)Ğ)Ï4aOH#E.\\Õ²–M`lÖH…5ªI\0:Mq4¤×sGLÎè€saÍX\"“UÌR&¬W’µÀq.\$ÖÓg@ƒ6@#óeK„à‹Œ³iMDádØ#‚K¼“â@ÍÉ5œÙsO¦•+Ãç³7PSÍ’«Ò\0Æ¼=87óTM-5T–P2Ìa6ä¿ËÿMøDÁ±‘Ê÷+ì¦ñBÊt\\óM\r2™DĞHîdÔ‚Æ|ï#ÔŒÍšÈú2ô’7I>CL¤@SF²ôü±3\0ç#P:4IK»ÅI#ô°J—7¿C/M-4Ñe?NŠaÓ3„°	J?ƒ]Jj¥ŒsD’°’r‡-é\"ÃÉLLé²ıÎŸ9ôÅC”Î¦#Ğ­,Ÿ	)/ÌéÓÉ:”(Ë\nÔ!Ìí“±NÜäæì\0Û'øYÒMÊ·;Ìç2ÒNÍ;ŒèrêK„à.‚N¹3äés°8Y;„ÒsÂ¹g<<Ø2°Ï,Ôğ\0€Î#<ò2gO\$¤çÒ§Ï3-”ñóÎN©<ôòfİ,K<\\ß³Æ‚ ã˜­ ¬,Jkï„\n¤òÓÎ“+œõRNLë=DéS¯Ï7)¤ğ“àOy=”÷ÓKOG>SÎÏw=dâ×K#¢?“ãO¡>ø\$ÄÍ<¤ó0O©\$ŒúÓ¤O>úpãNñ#St³¾J”ôSœO5?+Ìb´ÏĞ´ıS¿OÚœç,s˜èÇ‡\rOjSÌûÓóI#;Ìı èO×+|Î³åºbÊ1!;É¡@ş4Oé@4şÓÌOİ=\$ÌÙO%0L÷ó®²ç-ÙNI8×9Š€†‚\nLìŒ­»NM:\\å2@N—9lÒlÏ¿(˜ ³úÊ=Æ“œ°ªøĞ!;ÄŠ´OÙ<Å3÷·PãR‡£MÎBcd‰à÷ÊV2L¨À¢¹4pknP++—€£ >\n@Ã¬²Lqé\0¤\0,Q‚‰\\\n`[À\"€¬*D€ÂĞ¶>À¤¤”ÌzBTĞä0Ô:\0Š\ne \$€rM4=¡l\n²N)Ğ÷Cpú480ğú\0#¤ÒJ=@&ĞÈ3\0*€C6 \"€ˆéØú`#Ê>	 (Q\nŒØê”8Ñ1Ct3ECˆ\n`(Çz?b7î¸\0¨È[À¤QN>›© '\0¬x	cé¨ğ\nÉ2ÕCpü@&\0²Ğ´8Ñ\0ø\nä´¤úO\0/€„ŠA\0#Ğì@cèPÑD ÿTR\n>´ôdÑBúDTLĞÆÌå©ãĞÏDt5PØ j”p³GAoQoG8,-rÑÖğÔK#)9¥E5´TQÑGĞ4Ao\0 >ètMÑD8yRG@'PõC°	ô<PõCå\"”K\0’`ü´~\0ªe)8PìœvI(QµGb6)\0±H\r48Ñ@‚M)9\0³FØtQÒ!H•”{R… ôURpµÔO\0¥I…t8¤ÒğúèÍG]D4FÑD#ÊQ+D½'ôMÈ•À>RgIÕ´ŠQïJ¨””UÒ)EmàúTZ­Eµ'ãê#cEİ´£ÒqFzaª¸>õ)T‹Q3HÅ#TLÒqIjMô½º…&CøRh@\nT›ÑÙK\0000´6\0ˆ¢IèÏ€“FE@'Ñ™Fp´hS5F\"ÎnÑ®M%aoS E)  €“Bí\"”eÑ›D…3´hÓAF­4tl€™J´ˆ\$ÏCŒwHŞ¡I<xá\$¥J5äÑÿ`*À\$º¤`û1á…¼Œİ\rtÛƒ\n?8ı48ÑûI%'ç€ªjCAªS¨½‰<#QDõ'6\0DÈ”´éÑ¥-àÌS	\0%=ñà\0ùEè\"RÓ½O]:Ô‘ÓoGe!iÓ‚”È\ntxSÕN­\"”ŞÇyNx4€QÙPû *ÓÒE;ôüÓ±L}75Ô#P,wtß…¼?íA4áÑØ²N@\$Ô*¥\rôsˆÀÿB¤B?0ıÃø\0‚èÕ5Qª“3ao#¢z:`>TKPØút5©Qİ”CRQJ{£±×\0–4ÔÜ«pıáoSßR]\$‘ÕÇ‘Dğ[ÃøÔJ' 'ÇVø	u\$Ñ\rRÚA@)Ó·Rò3cêÒ-µò?Ü#öŞ?ˆ0”SæíF•4­Q½G59Q`•GÕ3QÃS\$xÙRSõaoTEÂBÈÍ´°ı¤´€„?+hÃíÓSHUõQ]MÕ	KØ\n4Ğ×CmS”‘\0N;ªÕP‚­Oí! \"RTûÕ9€S­FÈé¿U5-UÕTH(ÍÔ‡TV”¢\0J5U•N‚­T8ú•ZRğ»«@,Rœ‹¤à&T@ˆèÇ‘ „u”K£6> ıà&¾ˆÿ®tQsPe\$”…UO;ªÀ%\0ŸV`	`\$Ô¢@1ÛĞ¾?ÍƒîÑ\$\nµJÔ.9¹WmÃüÕïWpu'ÕÙWä?N¢ÑR¥^ƒşP¹UsËCğ£ST¥RÕ6ËTÍNGOSµ'5%V?%PÕnÈJuPcë¤ÏR­`Ô\\V<ŒåCtæP× dxT?ÓXõ<UŠRu e.•‡¤.’wà*Rœv )Q7NıˆÚĞ“ËU­M&Õ„ÍOX[ÔÙ¹»Tõõ Ö\n°ıÑÖÇ_Q2Lõ£Òò9ôæG–êµh@£‘%QÈÚ\$ÓZujõ¨TÏXeMuLT[Xkµ=V+Rımµ³‚­V=jÔöTOT­m56Ö×Q}l•»SÍKık£é»ZnµXÕ§[íd+Ö¨“ˆ\n•W\n\n°ûÔ6U\\ETõqÕ¹\\xt…€“F\n3tOW)KUEµUU¯Pİq•ÇVºdÕŠÑP\rsõÔ\0ƒC]t•×?IÕv5Æ×fKMWãé×>ºN@'#b=o£óPıF(üÉ8¹ÑY-uõ‡¤ñV-UÔ¹›]òCI8ÕÃ\\¨\nµrWŸ™ (TR?-Páª\$ Z3uäº›Bå`>\0®E]Tˆ#LêĞ	ƒş£L¥)²×’…:@#íGõ)4ŠRÀı;ÕãVmD%8 )Ç•^ÅQõë#h	´HÀ@	ƒı¤Nõy4š#c €û´’XRí€'Ô7`\\é¨\nEÀ¦Q±`Åmõ]WùNd€«V'Z\r…5¯GXEjuTE9\0ÕTŒÑ-UB‚­O¥PÕíQæ¢65¤£É_x•z#¶?-ˆ6TE-4æ\0œ8\n  ÖX	¶#×ÍD€	oRALm\r5eG‘N	ÕVÄú64p\$—a9N¦ÇSaU?AªU \nà\"ĞØéò<µ¤£9cufQ_ı_¶0Ñ‰\0;ªCòTINÅ2 ,S”£ËV=Ø»d=Aà+Ø±JeˆéÓ½QÅö5€V”Íµï\0“Eí–>Y1H…‘@«¯DõYRYH…~O†©cİGTKº„>¤\"£Ñ¾‘\r/UÍØÜ&Ôx’Ğ?\n€/×¶>­—twÑ Œøü´¶\0¥eå˜qÔ\$ãE›”Û\$ ?%™´-Ù‰Pe™gY}_-šÖg×¹E™1àY—e@0¶	Ô{FÕ\rÀ!ÒPMKõvÑ7Q-•£èQ?(ÿ•Ûg•\r‘á\$¡Y=Qèñ®èê<µh\0…\0=#öÕÛf-Z´®Ö£a…^Õ¤>ªAÖ³_-;Tîª’”HW±Zı@(ÔX'hšDˆØ€«f*JUH!IåLÀ'Çƒfh	4·[ÍR–<´?À /ĞKE¥v˜Ø>µ¤ÈßÚ)i¨ö¤™TX6˜Ò×iÚBÀ!Ó™gİ\0 ÒG …Q6 Ñ4>Üx\0!Ú¡Bå§ÖC’Ô>İªÕQÚ™jÊ8îÕ‘Tàûv(¼~>ÀıÕöHCe¨ÖœÑ7jŠ3§¤ß`PÃèH23–²Ğòxû U›kÀ\n€:OiUŸUAÙô-xn“Õäé=?CéRMSÀûñÖQƒbx•ô\0@õÍR§\0=¦`)ZzKPû¶¡Ù]lÍ³vŸËm³ÔM×‡D\r4—QsS­41QsQÄ‚nYëhµdö	ÂA`››	€gEÈ\n–½X'kõ‚u-SéO˜´ú¹²…wöã€ ‚S6Û™DÊNNlÓÑWİ™ %¹¹l‚A\0+Û*KM²îÖClÔx &\0¿Qò4Ö¡UmlÕ!µoã“§`\$€ˆ\"3vÚ|¥3¶›Û;iÕ•ÖùÑŸm+§hí£L“%‘6%ÓMu3”ÏQ¥F¥4I&T£HÈÕªº§\\‹ªÔÊØFC¨TQW±LªJCèQezBÃê[`ê¾—#ime!hßÓ•^ÅsCøÓê%!”‡Yö+ƒòÓ‹JêNtMÜkXJ>ÍÓa e®ƒğÙÏ e|2Ö/q©SWr%£\$µX(Œá-«Wp'uE•7€ƒrEÖV¾%³vœ[ø?êCVÚVe’5ñÍIMDOÒQq2Lv©RĞç23`,Rp³ªt´T>Õ-Ş\0¥^…Ô´\\8õZ—s`ôÛ\0†ú<tK\\±jõh4W\0¾˜ş4’\\ûÏöğ×Š“’JÈZ3MU²v^ÕÍVeeöªYp>•rR½RÔxõu[“UõXû×¹D½KTRA^}„uçÖS•uX¥^äxVÈTAVu>U\0¥h<yT\\]|Í¹5óØçv5ŸvG#Õ_53€>Ybà#ì[5bªD•hQ>íF”Û¯:NK<æ4È%È\0óR?IÂÌèø!€æü :K ‚<].°õ]ä¥—P³² .Êƒª\r¨8!oFjwPc·}¿ú.ĞT‚;è`nâËÉ{âPi²^ó¤»ğ\$>+\0O%Ş'„À€Á\\Ãµ3ŒÁÿ6W€åyÒ‰€ÜËÒîŞLÈH³7#`@„bKŠ7—İßy \r·–¤ª=å0²ŞwyhB\0º¿V¤ßîÛoTÈgs¼Wî•\0Ú¬H*R‘:z…é.¦^E­ê7¦:Uz+Ò˜±¨0²ÃYuf=˜UbX€*\rà\"\0„éØ4åÇDåŠ·€†˜\nÕ]_EŸæ\$?EL´­Ò»k¥Ã´yÓ&(	´®Z{{m€@&†©sJ­Ö“KpwÒ!|e¢ÖÙÿN}÷Åİ)|­ˆ ß/Z‚9íÓº-ò—ÇV‡|„uƒóß4çEó—Çß1’NAo_REõwÆÓ}=4=\$åIÅ>XGT9ƒà7ÅI4Û=Ãá.‹@¨\rË±_¢¡Àß’%úaÀ¿Ü\n€\r#<Mw°JËñ’¯”µï0ï%ü(—;7¤ZÁ+FHìØÎÙ¬‚Lc÷;À#ûÚj%\0¾MTÓI,‚ ğcÀ¨“ÃµFœ÷âüoD€¿•ñoŒzÇ;=£ÁhE¨YÁO	(1MşWwR÷È8Ø~íüÃ¼V§¥Io¿(‹²±rÀĞæd¯	\0ä\r»Ä\"?à#bá®ƒ“‚\"â,ÎAEÖÈ]qw!Ôwû—Rşñ˜Eî\r]ÿêN l 1À–ÿpe08¹ú;¢z¹èîŸ)…HçĞ:AP¹âçã¼äá€fæÀ5²Àè%SŸî€ºLÎãÛPºæÃ m‚jñ[¡…¿@gA§ù:èh\$Â˜Ó¢wu:-wÒŒFlÿq2ï—ÄgMâSW°¶hP¶ó¢Œw‰a\r.ü°èË¾aÁ'ù‹·ÖF9k„Ó¥Ğë:ÒõŞAŸ¬GÆŸÍpşF 3^2óˆ@]]ğšP`N\r	Tæ%€Õ€ÒOá	à5ÛÂáE·…«¥Ø	ƒbó¦×‰\"Vù<QĞÂ:ú†ïƒá¢Dj®ÔNé1&x‚Ø(ş€èÊk³Û†kÄ19„š2­âA°áÏ…¨Ç¡òa&25a\rx”	JŞ.ZX{Ş+dX7Š^Ğ\$a~ü²¸U’xƒáDñ¸Ê¸r	U…Ğ&áı‡ÎnNƒè^X‹\0ÊXgøW€ùˆöøUÁíıŒ-ÀÙ…‹+ËÿC©.øTaª]À1úß¯÷Ù4LEñØÑNó’Ø¬!ï®¼@0Û˜É+œ7‰Ë®ãâhY6(÷w\0È«ß&°n7şØ§µ‡)Ze“•§	\08¸Éé‹½b‚%Ø—7.\0 /ä›\0ˆ`‚’©4ÌNñ>74›³b/ÌÏ€¼À\nÂö\\5„ÅA†÷ûàZ*Ş&Ã¡0,-a¡	7ëúïOç…Ë*®«ã¡xŞÁºE«é“×¾‚\r€JÌ·;€\"øJÀìß…\0ï6c,ş@J`/¿®LL¤±qÎ|Søg™~²\nPCƒwÃ£ƒãG¸>ƒ>\0êL;Ä8İˆR¸În‹ÎÿpÁPâ^ôûº¯7‰x–àó‰Òß¸oábÈ3R0a”B„ÅÇ˜rãºÙ©ŒFt›#`Ï€øcÄ`v Ú=9Ê'÷‘ï‡ÍĞß¯y#¥Á3€î[—®ç°qy>À5„‹{[j·ŸäêÛa)”ÑV@¸&@ÒÁ®Ü³¡m¿È\nÀ59ˆş	'Ñ¨¶8\0EûªaÁAAÉ5êY_~^Añ˜ä&	¦!‘˜ºí`JOX)’¨höáÀ\rB I‘«yY(È,adà<€Û„«„!ªBÄXÎ\0ÜÙ´kï=MéycŞ\09…œñ\n?B.^Ct	`ßÀD:d	c8:érºw£»ã¥üÉödÄıÎL÷u+ï“<Qx„¦ÄO¨†ó¨73şdÜ¥YÑ‘rê}™dòØ@‡0lş`V÷®:ÓxP\r·®JÑz\$Ü·¯aqylÙ9Gˆñ‹ùI^b\n(6K]İ“>SN„o–S¹N&•ynSà<å:%¤;•6TyIåQ•.S³dåšV>ğ²å#•¦?J]•Ä,¹Le+•æSÒ‘aq•®X9Pe•%ybea–UUe–NW9WåW–W9C^½ c·ªÅãz¸#™m@ùz†M™n^²Íé®…^¥•.\\¡ªFF ™Eñ2Úî”Ír€Q€\\Ñ„Ÿl…,ƒ†Ç\0\n9A…V‡±rNa``¢Ñt@‡Ì{ñİù‚?‹„Ã‚=8I5‰Ğü0y‚˜pÇToX¼ÆØübŒæ*m˜Ñ‹æ6dB\r‘æb¦=\0Â:ø°á.e9æX¾bÌw™_™ªwğ@ã±\0kq°wŞÑ˜|By vpÒC¿s™¬À–Sú%9‡Mšl2À‡½šğw~!Âs&kY˜0\$/çfk€EşøtgCÂÙ¡ˆM› ôâ?û›ç 4O^Ôè!¡&€åˆg°úæà/şf1=«›V aE:#Ìy¡N`»)`Šë›Npò’ã\\.\"B»Aåœ¤£—úqx“V“ ™¬:aÁ8y¹f¯™®sóŒæœóy›7¯˜¾gyÊgS›&gYÔ5;€@ÅäÕc¬3æt™Ôçn]t¬˜o/7™­og¨Åà8`3\08ˆ“m\0€\"\0®æ°‰[®X¯ç?¾q™F¾Söv™¬B¡\nğZçÆÎ!AÊùšŒŒÖşo¹ƒ„šÃöÏC¬Ä-yñ:ÒNãŸO^xz¹‡·ë~¢.Ñ19¢¶škı„D¸8!C˜Nônf¯ëâÀËhg\r\r(iâpeé²ß…<+#ø -€ZdJ…jŞh6îgAªXFƒî‚h4dLÿà‡hNè¹Z¹9¡nxÓC«ËP‘YhE˜~sá£`‘>F…kÃ\n·¡^ƒ¥}D)Zk§ ş,ì`ÜŞ§zÁ1Kc†dluf>û	-Ï¾ºÉöqŸç#aâ“å›˜háPè`¾İşPÂha P`€8]Æ\nÖ‚`ÜæÜ3†a¡ıŸ`8Ú'»‹˜|0ùÈc‹ƒ1\08ç¢\0\"Z˜X†…dÇhV/hY¢UhM üØ—g9N‹açYŞs`7g?¤¨!ùØĞ6sùØÎnŞ“.‚?ÜÇVÒ¢…ÿ¥NdÃJ…¥fŠ„¢ƒ¡†sá¦pÔ¤\"KÊ.‘æDÏ{¡^…1´JB#ş…c¥ãiŸV…x©`<S÷dÃ·¦f˜šã¼¤ã9¤49/‘hy øn?€á¡\\<šF»c®€’:Fpoò4°ùŞŒ^+ÄÄÆ¼	T&:jhŒ­fdîşiÜ¸+2nÌÎìŞ®Š˜õ§v› ©h(ş]“j\0å¤&Zm™ôNØ€ JıE\0ZˆS‚@ÑóíèæÖ%Ãƒæ¯>ŞÓ¿]í¤Özá9zôÒz²ªó¸::æ)0ÁPüàÖ…c|hVääÄ`Íh?ÜÅÚd‹şşrÈ•2}ü,O=	Ø…yÎ»Æ0£ú•ë¤I`Ô	=ªX7:§¦äû÷ğ_Éª°ÕzçG®ª8	ºğädºƒNœ¹jÑ ø¡\$ÛBo©)‘2¾é¬mn˜yŸK ü[Zé{¡úÊû«Y‘0Ãƒu”\r/n\0ï¦NOáâi¡œF±¨ãRèNœö:\r…q‘ê’ì>©€É«0@˜©¿–N¬*tèK¬Ãá¢ëBñ[¢òn·©Tâë¼Np·hz	åJ¾êtdNÄDY>›ÚÈ”¡ªF„ ë8şøÎ·ºã8vÖ¸xk‹¥öµº¯9ë‹´]z¾è>ôÖ©0Ñ“‚Êd#àèW,3æ:‰/7Œ†FR¡fó{®Z=¤‘ùOÃ|hºÊcÂÀÖœ3şx†é‹îñ¯F„÷^¾Áˆr]t¯Hi.èuş@ØÂA°\0h@Ø¹°Ÿ•Òß§¨smNÃã‰y•çV¬F2†5ç?~ŞÂÙÔ†Ñ°fsú`ì[üRiÿŒ¨c”+Œ1°fµ@‡éƒ\n ÑúÁL^36Xãt9û=:õ‚(äè ;èŸ¨ÁSıF¶@`;ìx,>y4_ñ&†”ä¼Ì×ŸŒÿeÑƒƒ,çêCFL0\r‡Æâû°£úKêQ3æùl9øÛìÏš×Âöï@~»ÿŸóà2«‰Ô¥¡+gÁVøN^\"+ b_Fd¬H„ø‹ìëwĞ~î\rb¿‹è\"0@Ás³ñ18¾ìŞ²¦pÏH#:K—ƒ¢¬X³~è¦Î š‚›˜Åø…º›Óy¾^\$d!5wt²»­!':µx©âÀîÕÕmT + î½O¥À5~Íû´>»P@ÃµV£PA¡×¹İßÓ²&\";XhŠ~tË¼!)5aD€Ö3˜8'I×¶^ˆØ®â·¶>ÄØší°ı»l;Â“Aó×àèöÆÛŸäº~§;jÜ[>šmÓ¶ÆPÛuf˜.ŞA)„=·#Ùæmß¶fzáI¶ÄÇSmÉ¶cÓA+…®ŞDù`/¶ÄddÕê<Tìø˜¸n¸>€/ğû¾Ù›må9¾WÏäiŒ÷ª›,ÈI\0¼÷ñê™-Fä`äi6ä;”ë‡`„±{î[€©SªÂÁ±¹6Rj¥¦Û•Cå“ô›Ú#m©=9gWˆÅ:ghÔ&ÄÈ†€ù¯VË”I¡ºxÅ[ƒh¸I¡IÂö½ZNm›®’û®îš±tW€[´+æ@k¤¹*Ú/§ ÷ÄAEw€L_8m{).Ïó¥-v\r:L½¹£†à·‰`-@íY§m£¹Şğ{ƒhíŸ¼jÚLh|:şYîÀ#@^Ëº<éÂî¾ò›ŸKs¤ÆÑ8¯è›F“Ëèõ@XD šj7¤½x¾ï:LNóïĞ9OÚOlŠZNsDàˆÿ¹†“F¾d¥ç;Ñì‹ÁÃZPî§@^À Šg47Æ“Û`8 6ù#.Eˆ£Ôß ÖÂi¤ÀS£.7ë†È¸Äãe¹[–zL4s™0`‹~ºw› –f›“>ä[áïÈöØ;ßã†ı[{Y#üºÏw¿ş[ˆI«ºÎ‘¨oÖ	fùYÕoÒü4;üçÇ›ë•üoË6ĞTŒø”@©B¹~ê;U‰ î.åùşh¾r¾3…N·£×»ïî†î6³P‚ÉÇ„µV0Ëok1ÁEşSŒ˜O¾œóÈ•ğ`7øl®Ò…ñIOÙ«‰€7¹Øït€ş÷‡QcŸ9µ ëf-¯\0-¡\0ê®ÿšà/¸.‡Ùø^RÊf’û‚î½µÂÈ<-nÆ,95JÂcM«ÔÂèÂşv</h¸ïÿ\rZK\0ïœp\"FĞˆRó¦à¢Fğ«¯ş‰Ü;ğ®|nv<\rpƒºŸ@äEdí	ÅbóÃûğÛàhcX+ÎĞ²ı¡Œjû³Ãê7™˜¬Gy/€…“ŒÛ‡hì÷¶XÀ°.nXtÏõ¸.sû^ğÄD]r­í~î´†1LC·@+@Ødƒ¥\"i!Oj¥»tH\"/¾Y¶“œ_æ¬¸t\n³~ñƒŸ¾qÚ>ìİ¦Ï[û!º¶áû»ÿ½oNî§Æ¦Í\0q¨V˜5˜,Æá O â„æ \\^¾b+b*ñ¼	{Óçc§à7roN!ÃÖqÜwÉ¹Ç‘OÜ;,P¶’à:b#3+\rèS\$ØÊÎû´píoK ëÁ§~Òœ…»Ñšx’š!_Èq-™§¹ûÆW`àm–‘xÂò9©Ø&™¨íı¤[e“ò>dI*€œáÇÉ8¥¯NHz«Ö·—³—3Âµ—Ğ(ôĞ¨-\n‚S/ZkË1(k5í!‚„*C!§(Hn§TD‡ ©Šz-d‰Ğ†ç(A¸³¬åíBõÖkµ@¹5— \0.²&!şcY­LÆ\"\0g÷)r,¡·Ë\"Š5çÊO*²'òˆÒ„|¤rÏËO) òŸ‡*-‘ò¾—ü€)×H‘Ë.2§ï\"‹–í—ràcàht¶ªÚ¸m€:`Å#[€M¡„š0@1·Hß#µdÚ˜óAC<mÿ\n¹Ì2s”s*³hŠ1¾\0¨Æ‘É\n1TÌ/6Ø=ÙK'6F~Š>x	ßÜÜJÖGG7,ó}/ü|à‹ù8¬Ñ²ÿ„óG9ÜÉ„?9³p:	-o:3ÃLÅÏ:³É‰•;¤”Sbjxa|îÍY+6Ö|ìƒvlÀœóOx˜¯<\\äãèw?=S]b/;’‹M‰³˜#Üøå\rÏ3œø†„ÏKt<øµxà×@R\\ƒM)·=¼çd¤7>3H·kĞLÜt:\$}	08ÙÌ/4\rş¶­ÍgÉ+	Í3güËsTÿ5“5€^Àxi0–b\r|û¶ÊŸb€|Ù£pÇP \0”ê“ØÀì¤9, #ù¤9³hI	ºf¡ûÊ£6`Á¹½».\$µzöKW%ÈÂJ?¢c¨RMK>Ñ8AELÁÍn:a¥:ŒãÊP•Ì^_ =*Ûa´2GŸ—B¯&ƒNrÆ2ö_LëØnu!TÔ¯DİVƒôİiqd©9V]`\r€n©¤çPMáotõjxú÷ Ö)`\rv	PÛ`­µ#tëÓïNöØ-Ô•ƒ5šÖ°’•Òö	ØYcå‚µ™XùPåŒ£ÕDxTæÜãalxôãV·txö\0X¿ÔªÃç£µVõH\0Ø¤ˆ #×ËÕÍkõXÁQÕF5|ÔU OW-ñSTê·W4~Úµ^ÇW6Æu‰X=94¬@	ÕÍ‰Ö(]oÖKÈÜÃiWW=Põ¹Z¥o}qÔyITvxu‹UÏ]]jXKT\rH\\İQEÇ^@,È×5XuG‘guÂ–Õ™hP	}GZGhm˜µgWhwönu¢`(Z[—WU_ÙGh‡b€ÚGØ¯S—RĞÛ[wX5İZ/Ø…aµÖİÖW_ıˆuU%PƒéUcQÀûõ·TŸ[w[6(Ú\rØ‡[ÃìÚU[w\\]œRGf/bˆ\\§[pÿ½tU[ueı¢SsDcË]£T…Tg•?ØJ-¢uíÚm‡@Õ‰ÙMb•º\$-pÕ4•E£j=R™ÕUÇb=^u}ÛUµ¨V\rVSt]v<êVÈÛ‹hıeöØ\n·dıWÕiÖ•V•'ÕiÙ[}<ÈÖıX½²uÅU \n]öï]Ê]Åöƒhÿ]=ÅÖ_UíB½¦w%]ÅX^ö§Ü_jõcQ„êÕ•É7Ñb>ÒMõeº­k¥½•iPÛm•[Õ\0¤êµ_öêÛûY=vòôùsÈ•'ÖGr]f=Ku#h_Q’Ø; €ÿ¨Í£ÿxÖ>[ƒJ÷q5QÙ±KõJî«#§eıD¶S¶å×vÔÕÏf´ñV±Ndx4¤vU\\‡p}›TMj4vtÃvÓC—|½ïV¡ßAıƒ³‡a•ıùq—‡~Ú/á÷©Ÿ±?Å¿zÄ{Tucå›Ao\0´’•\"üé§Œ4XÜ3ÛŒMD–WYX“MÖ;ØåcğO×…`M¨ôÓH%eœ7c:­uò†	~Bê ;ƒO0›ÃUø·×YEÍ•¶@6×UÛWßœçyÔÁm»Ï‚´:ı=±ƒÍ˜2:•ƒ3 ylÃG,0-†]hènš~ø *Ó¢<áÊñ°>˜r”è«¢øA<†>_úì>i‚Ş\n)¹í‚“Ÿ.~†ù¢á;3œ…üSÍ_¼DÖÃBªfù|äW\nì.•`w‚\0#¸#>u~ÅûC	ê¦[®ç3;o šF¾fÏà!äHx¦Ê¿G!+@ööÆX¿ AäèÌT;BŠ¾â†»Bæ¤EiÏ¦Ş@ÅÙš†µ ‹†Ù~\0ƒ„ÎJ Ïƒà‹Ç·C#ƒ…õÜÊË	‡oœIğ)ya•şJ»j2­ûø…<éˆ:} âFo÷q“‡jx„¼ÄØN‚âöŒL¯@DêxÇ¡5‚9…v‡TR	ÃC9Ä©ç7˜_™éA®†P¡¥_›X|çÀ6#>^qñßÖÆO÷µÎO\no¢T&ĞdàÚ¤à„Rî.LâUgé—ëø¡w€•PV#ôè9*„áêÄT\$Ìº{“f]È‹’ÿ‘™p³gD¹.€<k¥Úca‚„ôäzkµ†3šğ16pYºvî_é¼3×–á|®Ä=Ì¤8àú›Cè…Fv„S““ƒ<3¾iêÏô¾‰ş«è«êy|^ªbzW«LNc]uú¯&8ÙÈc‘‰|d9‹zÖèş9N~oÄ±Õä®ƒ:è¦=N~6çæ=dç	<Öü£>M-A~ 3ºì‡âº]ìFü.Ã{“ğQPÔÃ-@Nl{Å?QîQAï³A;€ñì_²{R:]6<ÒcÇo´Øô^-ŒB¾Œù9Ï°9Fjc–šAÌÆæèa³N0s5{w¥_·³Ğ@©¹~ä™ˆgÀï¸¹õ{†`ìûşã{—•\0XÖ:/ä¼!&él¼íPµù/)µ¡ËPİ)ÍŞì‚ØÔï23Ğnr¯¾‹îÔÁ¯3íÜãmŞÉÅDí–1|«¾ø\rÄo½¢nì›ï¹•şöû‚¿{'ûú>ôşû|ï£|Hü\rï—’şöÂ eÃS¸E=´Ååá=Òs¾vscKğ³ÿ¾KËO¿Â¥Ò|:Ôï8Æ|7ñÃÓüN:gÄa&©ñ ¿F}5ßÅŞÌù/…ôeÚ~CJ\"ï¼`/á|Lbóî_ÇÇŸ!­06 ×|{…ó*¤ªßåĞB#fì¬—_\"µ;…ö12Âkëò¾åòIü­ğN÷c\r²ù„íG<77GÌ±œøü3›4ß4·;{ƒşÜâ\\†â‘ÑgÇ¯üA?¸v»Ây.eøYşüïñéCCfçµï’âµ|ø[ı?DÂô_Ñ»;I›Îù/ßÏÒ¹Ôà7ÒşÜ}2ÔîĞ%ı8ÔïÓù²cb§Ç¿Ræ÷Òòr\0Û½ê~KìÅÆ³ğß?ìû3ç[I¡¢¨¼q°µ;¾¿Ì?\\áÎqSoÍûö“Yß}	 Ñi¼7ÂL…Äî5>K™Ñö¿Üz—1Ÿ’üı¯3Û:á|{öğŸlz±ÂÇ?nfé÷/ÜÿjHúÚßvom÷wÛ\\\"|{öÿŞ|1ç¤tiãåæ¼^½1eïÓ|ä]8ò±*F¸İ…=/FkşÃ¡/âáøGáÀºïÛ®Dåñ~Ñ°%…A‹‡âŸ³ù€[­äåøßáà¬…£\$Ç›û­m¡ù8%_„ş-ù—\0z`Êó¤ßşS\$»ìEIù¼eê~Qø²i ú~{@[§_~gø¨%x„­´Oã_˜ş™ùáÿ§rk<§™¹zE³¹¿01g¿`1¹¾‹Ò®»Á+Gë›7qï‹›Ì8¸;ç³ÇŸÚèÄ´rzMû=ÏîéÅ×(O~{¡şièŞoòé×ïÿ¢€Ëú95NG T@¢Ïæóåy?Bù\\	saïÇ1‡”\"Gì¸™:hÇwÏéág¿sî/“x5gá\\›°ànÛ…8>·îÚŸfˆîÛ„”\r_®„‰Át8Ù|ñ¶ÿ¥ùø\"Mf¿ß­†€8 =\0ôpÔãÜğ¹ßá\\ı	oøE»gOÃèá…Ç«¾¦ß¦îŞ{©Èfåí\"+øÀîn‡…”éë.ÅÏu”µ€<öN“Ö—»Á²»«ûÛÒl\$tğv¿gsÂ‰Ÿ{´ãŸşzçüTÿ'—†üIè\"…üÃ„dÒ óÂŸ†x±^z\$‡m¼Ë¤û§í‚·ÚAŸ™ô!şLD÷<bg|ƒ‰y,ÆºìÒŸ%C¢Âî\0ì@ôé¦‘cÛ) ûvô/Ã.7InD±+;Pœ 7crF¾ËÏ\$.ˆ¯`À6€€3±ìióF¶€Ù¸¹>D6ÉÉ3ìSóëÓQ^&|–Ûø¸'»ÏD‚ş6ªb’˜Zò7º˜à2¦İ>% Ç¸ 0„&Ô=ñàqİvaíö‘«08zˆ\$x	bCşo&ş=¶’ãì»jDïMéÒÃ1=jb0á‘d†û¬¿[K¸»jó\0<b1ötMŸQ°¶—\$ĞèãOÆpBßŞv0@0ß¸èºqHUG\0|pPU±áF+ìñ#õ€>ı‹p‰pN¯´+h¥¥[kÔo@n5À!’0\"&qÍĞÔ³•şÙeû‰ˆ¶—ŒêI+‹bàt£(còÅ¾ á`İõ€Aîsï¡SIŒ8qlml\rÖv,çØAÛN!pğÚw—((˜¶²AqBú¯sÆÀ€¤dõ¼™~ ÌÄ#VvsçB`|?©jôÎ¥½æ2?E—@ûTŞ‰ç¹Øh ÏÄR©>Ç~øÕ½ğ‹8—¢-ß[Ê¿g>eòª]H¯Ä\r³Ÿn>zíœúd6Š§Ä›¾¸Éc^Ò9L˜\"uœv³ÙÈÇ3ç­ÔÙ\$ºwèóQ€\r' ,YøÆ=à -*èl¦û?àxl²_½Hº˜¨ŸQ´—jVÙeı+QH §¥¨rO±±ÀÇ§m%àQ/ò‚šĞ„(! ‹¸Ë@d”ä1èĞT0X =¦=oaÚ-ˆ,Ğ[h¶ù½¾ òz\$‡dÁy|ŸÌô³xt;p_€.?ğ~ ‹5\0+Á×ã>İ­úpêa6À“L8Àt;H«0ÀPeAŒ;ÏMğü5ÆâÁ6ÕpĞİL\nğÎjY³„~^yê\rP/àhvàÖ3-i/Õ@üÖû°m[¦|M	ÿ\n6çK¡‹Ğ#1hFTÜ)ß˜(DìmË\n=%½u#\$N™émŞÂ ˜:ÀÙX\$>ÛO´İøËŞ\0Mæ\"¸Cq4ÍÙ§ë‡£/O\\K\"ãd(İBx=ˆÔ[ä‚Np°ßI†“dVélÛRyŸÒ}ÒÓÉôˆW÷â|š€¿~¬ıB3¡Ø1LÂúÂ	˜İ®bñ×äOÕ›µ³Â:]9Åƒh#»†RÔ?P„69‘†ØŒñ³\0g„8B.\$¦†{`Ñ–hŒõ™û?öhçmG]n‚Q8õ¬	¨FĞiZ	7qìÏu¢yãxF¯ñF±+·ö 0qëÀÖJšvğ¢+J2p”ŸşŸÛr‡Ö\nì%'’œ?Ín°håèÉÂFê0˜F=B'~ ×Ãã\nÌä5„2|e1“<ä\rĞ›À5Âqn‡	Ò‹f@>­™ƒe1h‚\$”‰sX3Û\r²@‡µÜzº+é¶©éÆ9¡ '2ñGüèÊä…åÍa¹FÜĞ¡ˆ(ÓT)\rJ\$7GÎkËÚD9£Ñı)\0€\0œ\\)f“£+œ«(Y\0P¤-b’§`WM’rÄPŒc˜7Ro(Ir¹t(7\n`Ôü) ş‰\r’#è5ÆåIËø/70 OÁ¤S…X‘=Ì:EˆVğ«*š·(‘IÌêr¤0®\\Æ¹¡t7hqµ§5æÛ“‚Iæèe#Ü-ñp¸“—­J¼”tĞO ‚{¤¢…İ%&ü/h^\":w¥…Ü#¡&º…\"HĞ¾Ã\$¸IuÁ£€„¾pÀ„ÏÃhàù*y¾X_âƒ¯C8Y¹.ü1T³PÄ¡xÁj†4˜)A·³Ó‘¹sE€\$qÀ …ÀWSµÃPbbVcàd.…¡‘¼¡rnœÛ´.¡•Ğ¸œ‡¤Ç†A¾˜/3’®!’—†V_ÃZH·Mg-Ô+Â’…\\ëÉRS¯µË…ì’qZÊGØrÕQNØa«*ĞvúëYÜ’¤¥W®æ[»ëVèî•Nb¬Çu‹HÉ)(y\\”1İÒ@ÕïJÌä«ÙY~êµ`²‡z ]ë©v £çBÖ%PVGvêA`»¾%'ª°Õß) SëZR˜•™Ši”Å)5S¦áD49Jb”;)3‡,¦9M46E–Pß”˜Ã›‡&¢ª˜Èt\nÜÔa*\$unAÕ¢£¥½ê–åºôT¢³Ä?âÕ%©D2‡×XÎtt‘Ú…Ÿê’ÖTÀ·Yh‰Õe£Æ‹­&v’³‘\"ÍpûK1–d,ÚZQUfšÍõ¥n±İ°­q\\ş¡\\6\"DJà–§ªŒZ¤´UP\nÆT‚Yh)’U’¹¾Zæç`ÊæÃò­qUÔµü>¢Ø5°¤iÍ£­ˆT¢ëIlrÜ•}kiÖ}‘ŸÈ´U_*Ÿ´Êï”•)\$@FÅmr­ÀúJ»VŞ+ºVhï-cJé³ªËpÈÍ­Ë[¤ì0?¸Õ‰‹N¬\\xş!9Ô Ñ\n—‘œ:„¸EYÒ‹…¶\n.§V…`?ŠâÂ3êM€>,[@´ir>5ÇÊ|D‡Øˆ‚¬MYB”Gxë“Ö\néÌ°qhÚµXsĞê—Q«×:¦º¹hùÌÕ×*5ì©ò]¤@ˆb“=ËËÅG\"ãsøxZü†G@”Å¿¶Mš›<óªW#¶è^ÂD=ABxgÄG6'M˜Ö‹âCt˜[úûä,«ğ<'äˆ@ã¢ò¥úL˜\"µónæŞİ_%üÑ[º8…f:É%¼ğ¤K8Ÿ‹=&­â™Ğõç¬‰03`~P\n¢.àÁD^±í^õ„“œ´OàA\0ˆ¿õ{F\\d V­\\Ã=vc´õä	SìF^(Á_¹?tÚËâ,*æ•ïÍÛ´\\gbŞ²‰Í¢JD¼Dãqö÷ë­×™Ø´¶ØPuxfÊ, ¡=°×œPd´håŠ i\$å€dzÖè4}èU~(ı1¨Abg1 @¼júíş[dğZã†™²0œJJ×î3v¶öLò›¬@Iq&%ŠÌ&±3LJ¾‡Ln„€u%Ò×®€Õ‘ûƒÏõéF7h.˜«/ñLnú¾'{ÿ°Gp•O¥ÁâL0|Åî¼Røğ“Û/¹mn|á©k]\0%«ñâtº€Ëí…˜DNN›ñ\"ØnìÒ*4T2Ğbâ‡3÷t|™Œ eg½gJ¡OŒÈ¡,A(N‡©‘Š¶vF@ë§\"gñ^oÅb;S’*\0â†_nLß95…sTÑyP0fxGé‰æ4œ)D|.]MBŸHt\0¶9²8®íFa`‰ÍH“\nÙ ¬X8+B|¡k<\0»\n¤)«8f€’bÅBèHÌ9Ì âÊHƒÙƒ?,–¬| 4P¸Á‚¶1’\nPs˜\0@%#E¤¸€ \r\0Å¯\0ç¨À0ä?\0Å©,à\0Ôh¶Ñj€\08\0l\0Ö.[±lbäÅ´\0p\0Ş.f@qn¢è€0\0i>.\\ğu¢ì€7‹uB-D[pnbãEÙ,à\0ÈÌ]Ğ ¢ŞE¾‹r\0Ú/l[pà\rÀ\0000‹k†-P@\rÎEî\0g.ÌZÈÀ~\"çÅÿ\0q&/©g¼À\râëÅÉ\0kÚ.D`H¼‘x\"ŞÅò\0n\0äœ`xÀ‘m\0Åı‹å”a¨Â K2EèŒ#-\\ZØÄQl\"Ú\0006‹„\nPÿ`q„\"øÅª‹c‘4 Ñ|âéÆ'ŒcÎ1^˜ÂQlcÅÏŒ¾1D^xÂ‘o€YŒ… Ì[˜Äñ£ÅÙ\0s21\\^ @\rbìF‹ö\0Â2D[¾±Œâä€7‹z-À\0±”âñE¹`¿/üdXÍÑ˜bñFM‹&.ü_xÄqw¢ÕÆ5‹çÈ¡! qˆ@EôŒbê4\$]xÉq‡âøFŒ%Ú4\\Z¨É±xâõFŒ÷Ò.ô]˜É c'Æ1‹ç ™„`HÇq™¢ìÅû‹Y–.,gè¶€ã6F6Œ¶/½‚ÀÆ­‹½z5bˆÇ`\r£GF(JMf.Le±§@1\0005IÂ5´eª£(Æ‘‹b2|[à \r#5ÅêŒ1V0|k˜Å‘ªâê€49U‚üg(¿ñš\"ñÆmš5äe`€\r£4Eô‹­F.”[¸»1Œ¢ÿÅêåâ0diÈË1k\"ãFoŒ	~7ÜgØÛñ¾#oF™Œ½ş/4[¨à1´ãÆI\0i7\0XÎ‘n#LF¥\0iª0tf×±l#Æ³Œaê4ü[HİQŒ£FW'Î.\\m¨Î±¬£‰ÅÏ§ú30(ÏQo¢ïF\rŒ	N1tp˜ç1¨£PEİ‹§’.ØHÒ1lc^F~‡Ş4¼_XÙÑqc*Ç7Œ/:/ÜqxÀ1·£rFµ\0en/H¶‘®OùF/¶.ìaxßqr£ÆV‹ò4ô_ÀÖ#F`K‘:]Èãñ¨ã«ÆíYZ-ğØqÕcjFzÓ;0(åQ€Æ§\$Â.´f¨Şq™£XEÚgŠ2¼lh¹±Çc°ÇZ‹»n3ôl(í‘Ë¢àÆİk&<ÄkÓşQoØ/ÆÑ‹Å^7¬j(Á‘œ£G#‹y\":sa±â#ŠÅø‹¥ú2L_hà1”£¡Æf-2¼zhµQğcáFfKœn¸ññ£ZÆH»\$Œn¸Á\0IcáEÆ×ö64}ˆú1ÂcG\0sò-Üv8Ó‘˜#nÆ¤oR:är×ñbã\0001ŒõÂ7|lHÆQ¬£‰F…2ärxëQöã¹Æ@‹—š8||¸íd½#÷Çˆ‹¯Ö1)fHÁGãİÆMŒ‹7\$c¸ì±¿ã3GÕ‹õz.l}øøE™\"ëÇƒPKÒ1Ìaˆ»ññcoF”Ï b=TaØñqä£ÃÆ„,á>?„f92£QFW‡>?4bˆ¸1”dÇ'‹u Ò3Ü|˜Êñsc‡ÆÎ§6Bmèí\0¤EÆj=ÙfHğrÇ>«ş5dlIQ|ã…ÆÆÉ^9”c˜ÔqtãıH;5äcèÇQŒãÇÕé!.?œ`húqçã	HYÏn.|ûñ³¢òG—´aˆÙÑÍcXGóáÚ?¼tè¾àd\rÅöIz>LdØïÒ\$HÇWŒ­¢9ğXùqÍd0È-‹·J@,†ˆÙqôãÔÆ(¹.:Ôx8Ä±Á£=ÇJŒıÖ/¬gˆíqó€1G¤Ù\"^.dsx»r£HFó‚?‹‰Ñï£XGz‹W.0|v`ˆŒ]Eğ‹½^0\$ZÈúQ¾#sGlŒÿÎ3Ä[ór\$?G±\"Z0\$dĞ‘‘bïHtÁ~@eyÑ’bõÈª‘\"61œxÙ²cH‹‹Î=,c˜·ñÕä)È\\‘}\"ÆG_¨Ö­cäÅæŒ;V/<nØØrãÛEö\rÎFtpøà1w£;ÆCY\"¶3TŒ8¾±õbïF8ñÖADk¨Ùr&ãäÅåE®>¬|Ñ‡#[GZNH¬k¨ê2%äMF´[Ö8„oˆ¸Ñ“c\0É;‹mş-œ’øËÑšä„F‘yJAôl¹RMdÈÉ\"Ş8\$n8â1ĞäÈîY0|ˆá2\$Gœ–<,™ñ¾#aGPŒÁ \nFtŒR^’£(ÈŒ 6JÔa(áñ»bÙIaU#®3hXìq}\$˜Å©ã!N;\\â?2%\$¹Ç›‹UnG´˜Ã2&ã~Æ¶‹eşLlhÌ8\$SGjŒ­bB\$w¨Õâ¤®É\\Œ÷>Lôm(Âò@âÜÇ›Ç†8ôg¹1ò!cSF‚’#\$òHüghçÒ\"cE´“ò:DsHÜÑº£ÿÇ‡Ó~HÔ›Äqt¤ÔÉ~’60(ÃÑòbÙÅú‰º7ÄdIq™£vÆœ~-ÌkXÿ’)¢ÕÈ‹ƒ\"²N4’YòI¤ÏÅúO¢Ex	xd	Èç“„É‚ü\\xá±˜€’G%é z6rØíq~ãpIÎk&\n=I=±´¤%EæK\"ÒGÜ‚	²#]F’'&.l_¹&ñnc\\Œé—î/[¤@’…ãÆíÙ'nM8ô°ã˜Fì’Ü’G\$”Şq÷äMÈ°İ‚<œ[˜ÓQâc2Èš%‚<\\Y1Ãã“ÅÆ’&:|q™òCcÂÉ-%é'2äƒx×ñ¼âôH|‘Ç#ö0ì€)b¤lHX×ªJtš¨Ír‰äeÆx%#Â3\$ØèR5£ÈS­!ò.´¥(ËåÀ’GÓ”Eş:ôl¼r	\$qÆÿ&B1üa	råI©C„†ÈË±ãNJa“‡ÚBD[è¸²XäŒJC‘MÆC†ÈÕ‘©c[Æ‹á.>4€	#Ñ¯£5I“ã(Î6¬z©Q1x£èÇ;s(‚3l‘I]¤ÊÈ*±(*T<xXå±Œ£÷:aP’ü,¬4õ½êHã¨–P¸¤áušÄ°ü¡óÖBÏQ.ğEI¸U‚ë\$¥e*FT­@>™%Í+åf’\n•±Qnø-å÷²µU#«ÌUº£Hj¸—]Ò¶À:şx1+™Ûk¬'UKçVmC£•Ğ¡}s)ÍØp‹V,‡VÂºT¤7ˆv.«QZÊåu{+Ğ\nD¯§e¿\n¬px.°|À\0)Œ}I<0\0„IÌZÆå\$k	!µ¨ñYh²Í”°€RÂ‡d¯Q¾¼S°%.Á%‘­9•Ä©bW\"Öÿª¥\0)€Yv*VÒÜWXŠZe–Ë/:õ,ÅO¬¯Õ¡áô”xÃ†Q!,õ`B‰	_. %©Å–tm•\n“²JK¥VÀ­y}¾ÙMµñ,€	å–¦Àl+qap0®ÖÔ’;]R ¼ü#(‡ö*^¯º~–Èï >ºµ-T¡Ñª‰#8¤@°éY \n!ô;Gv®æÂPjŠ%»)9‡E-îV:™òºUİJë–ö¹¹ jÛD‘ˆàK‡wF•İÌğ0 R%È­ôU’Fü?[«¥Aï–DTwP¸£ú€Q€Â¬ú—<«É”aÇ1>@Na(2†¨¢ycã±Õhºİ•ÊÌ\0P¢:]yWƒòíÔâ¬3[¾<¤@‰àÕ%»gB»Œîp…½Ê;ÔHKsWŞ³…àÄ±Yr`fí‹']Ø¼¬\nbUˆ‰%İ©ÊS2£ÁGdBpjŠºebËäRÓøó»YZké”µ\0U\0„ª4Jçƒù•Ú¬–UÌ	dÒÉ•ğŠ'TˆH]ÖŠĞGœJUØ/ vİ.ÍZÛB%ûì’×	/\n±í¡Ô&RkÁÁW…\\ ¦Q rùÕ^²ÊâÌW\$²Yp~IfæÌ—ä¦R;eK?ÔÊ´%B¦QQòø±-+€Â«,Q¯Áfòˆdê‰¥rL6–Ò©îW±Iƒs&©¨\\˜¹ŞaÂÒ)‰*/ˆCˆu1-ùÕšªE~‚ŞVs,D*26¼&ÌPu\\¤aC¼•;Êd¦1¬3ÎFĞÚ0wƒÿË9øD2²g„·&Èl|^ H¨¯.c¼9p0ªıİç;ãuŞ\rQHòœ00¬.ŒôÀ¸†–\"dÃég€a]é»U\\æµY{œÈ•{kb–«İ\nºø¢»Åé€ÂÄ_™2¯¡Fğ…ÙKí&N¬¬‡éa[´Å‘ªg&J!ùG”º-\\b“·b®İ‰Ì‹‡HíTŒÂÃ…2ûPÃŠvôi ynjÛƒşL!#9,Şa\$Ì7bÃæ&*&[,£:fS´åkÒ´VÿÌ»™e3IZú<yqª7İŠºw—˜³’e¼ÇàúÎ½‰<*Ò\0 ¯ §P	ê0WÌ¾UßrgrÃe¥ŠÏVŠº£Hf¬¸i›“4¹+ZĞ¦6_”³‰+RV¥ÌñS%,ŠgÛµUÄ‰%ô‘å™ó0&hLÇé¡n¨ÔàÌ`™Â¬QNº’Yv!şTjÌñš32QRt9	¢3FÄ’ouF¯-İtÑåÓD&‹¨qˆ°¢\ni\n’é*5HØÌñ˜‡4\ni¥U8+­ÔÓ;S™â¾•}¸·o3E•·M@Xj¬Bf»µUU‹¦¤Ì~RA-6iÊÊ şƒ•*|Ô¬QMÑYxsTWÈ£ÀTpºıX¢“B9<f^Í\\#¥2ÙÙÔÊh\nŞæxÊßT°µ*g¬ÖÕ¼ó=%¡ì™ï4>j#³ÕG³Uæ¶«Œ™ ¨=ÚÌi„`\nå”»=\0²¢[’ø©«Šiİ¢K›4újâöi«Š±æxÌWUÿ.ÕgÑp[È~•\r«{u6¤’ÑeV“-^ÊÔ–èí’eÉ)™—sPf²Í§wÖÌ?„Ì'}Jó&bË6Õ4âmr¼É™Š]]:’Q™¡6ÍZÄÍI}rÜ²LÙZ7[2‰©›êıUZLãQDstDÎy¶ê©ÃîÌìQ}-mÛ\$ÏÙ¹<¡îMt™ì¹¡aÌÒÇn3<À«Lÿ™É5W#·DKRƒèÍÛšïor©õ’ú¦ğÍ¢vÉ4MQâ¡×ƒ\n­&Í&V±4rW”İ‡}sI8M1S8	^dàI¤á÷¦”ÎUE1Jps­Y¦S„VKœİšk8Ri¼Ì™»hê,SQf:nÜÔeó³PæAM¹Vn¾²_dÔ‰Ä+‹UU×›·5>n#¾¸wÓU& MWV’¤µ]üİµcÓWåpª§X‡8èDãy“Yç!)Lvw7mÙôä‰®`U¦¸K?œ)5¹Q4äÙ»ó>%õÍöw×+~kääõxr°§\$M~‡Ó2Fr|Ø)™a&\"ª´–[6\"Ytİµ4ğØİ¨KmvÉ8~r+¯™ºó‰¡Ö)yœ)6YkÂ¯Å±“væÎì›<¾‚má	X»¦ÔÍõXk6µÕÌÛ	˜*1–AÎ„–k0Šs®IÑ*ÏTLú0¬>ìÛÉº“o¥æÎT°·¦V”Ş\"°&o-™Á:’g\$İ3:&uMÖ‡Fë%idéåDÓ?fï*šï9Vq,ë	»³yUQÍ\0—Ù:I×ZÕóB'Kª&›ğ¢ÂoÔë%\$JI&;jW¥8v,ì¹£S”—¨ˆuİ8)]\$àÅó3µ•,N\$x0êåO|ì *ÓM'oÎÁœ39’[›«™Ã“OBM¢ª|Ü¾ÉÛÓ¸•ÌÎñšƒ8ªväÌéÅŠCçzN0é8Îcôå‰Ç«ç§M[ß5tê–‰àj#•(€_;qÜğ©¬3ç|¬™Bë†!œïIÉ3Åf Mo\0«5Æxâ«UO“Ç¦zÎ¶›Á6®uÌìàS¨ç•M{;v®éÑó1æéÎèè¦×”Øéàód§ƒÍ”C9áWÂ§uVS½'>»ŒT]6}ŞJ@KğıZGŞÙ•„kOV#ª\$¤H\$Z›ÓÕ€(\0_V&¨?h	3Ø'‡ÏGƒ6ÅF2Ÿ×pj,ç°K.Sè±‘|öiíËqgµJÑÒIÆvøCšê‰\0+\0GYn‰Ljèd\0Õ1\0M>ğ‚dÀu†jCWSO\0†amU7ê<XE­îQâ°¾|º¢¤JDgÁÏ…Ÿ.©r|(÷WrÏCè-Q–”¤’W\\÷S0Èä\0_#6±<T³Õ¼S×Ôo¯¡S¹>ª{dûUYÊw\0)€_™º‚YèäzJ©'ÜO¬\$Hë.l´¹ùc%¥Í&XÈ8ü‰SígäÏ‹Y)?ZUòçµ 39\0/¨\0œ¹õA¾%ìk2ë© T=ÂÌ%›K5&ÌÃÔ^Ê«u{¶É–\nì”½-,[¶±–_ˆ}	ıÖÖ–OÅŸër~,àyn“GóO±ŸùMo|ÿõDi€#P\nŸi@>’øÉş²Ü×µOû–è\nzñ•/@–sKg|³şm¬Ş’7ôÀ,Î  =3‘gı)¹Äv@,©ô‡vµâY­ª”•±P&–·@C¯dvs9ÈÔı–Èêñ¶BCJgTâÌX–é@0>šÖ…\"y”QP  c1‚eÊÏg^Ğ9•ÉAEgú;\$x4%‹¼1YI¦}r˜%24×iÍ;SÉA\\õå;j£å¼Ğd[¶§úqmº\rÁÿVòO¹ ½A¥s¹¾J¥¥ÃÍ™Të@Zƒü¼¹Ú \n(?ĞTê¶2„¾š!¨E*²Ÿı.•_MúŠ÷áÑ¬ú[×;®ƒ=@úòÛÉ8K§Xå2QM<à©—aônĞ’œ<®„”»ĞŠúVŒ‡Ø\0š£BZ\"µµĞ3óhN…¡U\rá`Lß©şjí¥×‘œX¾´zV,»{t/UÆ¢H¡‡BÙU”ãšËßĞ_R²ù`rÎuAô3İÁ€MŸz³ş€ÊÈ 0«ìÖ‡Ò¡¦´™eìùjt8(l«ê–â²ötÃIyT9çç‡ÖXC°?ê‰©{jK§·Ğ’SßCÙÖµ5~ªr–Í±œçCğ•:È…xt<–pÏ½\0¦©ñÕ~I˜4?À)ĞÇ—”N_RIŠVÄµKãnª±B‡‚Ê´§·Ğˆ:°Î}z½éÚ\n5@’Q\"UÉBInÌç0ú\"ZfÅ\0(ãB\riğ5E§Óè”¨k\\ú¥ÖÑeÚ”€*£Ÿ10=”z@İÇÍË¢„¯ÑeŸ©yë\r	!ÀY|¤|â™J)´8g¸Ñ¡ËEHúË×gÔUæQS¡%D€\r5Â\n¥§„Í`˜<:!õuÑè¦(lCõ0¡CòË…¼Th¨UÉ?êw\"úµË”—Ò)\n2¾‘Nlùºªr–0*9È¾,?Lç26dÔå+èXŸ9B€x\0\nà»¸_FN‚ˆ5BA„ƒ¨‘¨ˆ¾MBš¥[ªàÕøOá£J:‚2ãY•³\rHß­„P×0áZù&5Š‹¨Ö+˜›\rÊuÄ˜‚Êü?î˜¦ºbšİª\"t(àÊ½‡¢£N{ôÃU(”Kh­Ñ¢·@<?j¹îó(;NP¡\$ê‘ûéş\n&ıQ×\\™GmP‚¼5;Âƒ€An8YiNCÒ,I”éÏe>mUÚ›¥ÑK¯•CÑ£®sc1 ÉlÊtÕÆO½¢¨°e´€fÌ­WúUCÂé}Ë’gƒOS¦«€²¦%[´WRG…=Æ}5Ñtteî\\INòŸY’k1)Ñ\rQæ³jıÅBÜİ{)‡íH•-\"zDŠtÔú¨ £µ9Î{ÄÇyšŠM”f-„]2¨>d¢Š(ts%]Ñ\$ñHŒ?%\"•†n¼ÖÍ#ÒT§@¼Çwjt§8RœáBIHñrBÓ\$¦ÓÓw2!\n#4„(®¾›2Y†ã\nãİn€Ø‚ŸEÆd½&4šÂ/€d£ËGœ[XV%´‡½ÿŠSØ*í÷o¿Qƒ?\0r€k`s°Ø¯0¯Ş‘%âÊ+á¬€Ğ±’Í4âfyG¨‚ƒ\0\nÀÆŸXq3`“`f€Î¥D9çàä‚¶iDÅ–PTddôI³àÍá#’?¹¨x(Ä‘ŒÀ÷YTt¢€à£èÇ‚\0aÒÚPàæëd°\rî¥’”P-­,ÈºÔ³’lÁ^ğ­-@=ôµ©i\0006¥µª–¼|z[ô·¾\08¥ÇK*–ˆWÀ4¹éhØ¥˜’—aöÅô±œÚ¥«K¢—u,b¡4){Òí¥çK6—å-º_¿éiÓ¥ÀBœ	--š`Ô·)cRŞ¦L˜DhZ^ …éˆÒæ¦Kú˜.ºbô¼©„Rğ¦7LR<úbt²éÒû¥íL\n˜Å2k4ÇéeÆ3Œ›L–2êdÃJ©~ÓL¾™e-fôÌégÓ6¦L˜=3p”Ì)wS7¦M–å3zaÔÒ)ˆS7\0oM1}3zbÔÓ)ŒS7¦5MR™õ1êkÅ#lÒõ¦iL¢˜ämšg”Íi®S?¦¿L6Í4:g4»£lÓG¦ÏKr6Í4ºmôÄ#lÓO¦Ö¾6Í5:ntÆ#lÓW¦÷M†2h\nj\0ãÓ\"¦ïN@u88¾´Î)­ÒË§M›1JqtÊéÆÒÑ§Mªœ­.êqtÛ©Ó’”N*—8zqtŞ©ÎÓ©N‚šÕ7úsÔá©Ì†/‹ëêE9JuTé£èÓ¨§9M’¥7*t´´bÖÓŒ§gNğ	-9\n`ôïiÙS»¥İNöœÅ;ú]Ò.é¯SÆ_\"î-ÉtñiÜRÑ‘wO&pùtíéÈÒË‘wNê­<ºt4ëií%§IO†}:zpñvéÔÓÙ§ÙO6ŸE>ZvúäISƒ§ÙObŸ>Ê{”ÁéöSà§»OZ2m7j|”û)óÓÿ§Å’Ÿ´k*pTı\$åT	‹ÙP:¥@j}1ÕêSû§¥² u@*yUêÓ¥OÂ ù\nTôiˆHR¨#Px	-?Š„2ªT%§?NB•Aª{2ªÒÜ¥Mú¡8pe™)ÖT¨EN&¡…?Zˆ4íj!Ô-¦1PòŸõBˆµ•ãIÔL¨Q<DÊ´áÂ¾S¾§³QV¡%1ŠŠµ	ér%¦O’¢­Djc•j\$Ô]§ÇM}.]<[UbûTkKP¦£rhÚa5RÜÔ/¦OQ²¡’jºR2ê:%Ä§ÕQŞ£}>ÚUj¦Ö¨åOÎ¤Hz‚5j\"T‰©	Or¤e?ê‘•@ÔŒ¨R2¡ÅH:Õi€Ôi¨§R:¤İ9\n“Õ\"ê7Ô©;R–¤…JZ’U)jJT©/R–›ğ0\r1~£±JŒ©=RÆ¥œbÉÑ¯j4Æ3¨ú—RHuKó–q}ªQTo‹§S\rÜˆŠ™\0ãTË‘S:-ÕM\n•õ‰zTÎSZ¡F™u5ªRTrµSZ¥MMê•u7ªVÔo‹¯SZ¤ÍIZñƒêgEÀ©ÛSv£¬[:µ8jxÔã©ãS–£”eÊµ:j4Åõ©²§ıLZQŒªÔ*©ûSÒ£ôbêŸõ>*:ÅÅ©ÿSò£|ZÚ™Ñ*‰Õ¨ëz¨Pj¢5B*`Eôª'T2£ô[¢uD*9EÛ©®©=QjÑnj“ÕªKTr¦\\j¤õH*`EãªOT’£©fJ™Ñ‡jÕ*©b©İRê§5L*dÇßªwTÒ¦e§uNâ|©–’¦ÊXÙESê6Ô§M’ªTØÍUU*{UZªì	%M4· I*¦%ÔB?P.¥Vjµ&ªµU>9f„~§…TÚ‘µ*©GzªMf«½Uø¶ñjª»ÕeªßRr«MWúª5UêÕVªÇÊª}Jj°5X#-Õ‰ª»Uš/İXš¬USbôUO©}VªlxZ²Õ[ª°TÇ«1Uš>MYj¨‘mêhÕŸªßf¬µWê¬5êÓU««U¦İZØ¶ñm*§Ôß«eF­ªZ¶µ^£èÕ“ªÍzª}NÊ¶ñ±ªàÕœ‹o\"j®\rUš¬ÑšêàÕªß,op0>\0‚äåI·©ÕU^®€,ŠºM\0€3UÕŒ—.;ÕAª»uu#÷E¼«ÁSê®Z¨¶õ?ªÛÕ\0«ÛWšÍW¬Ñ¯*§ÅÇ«ëW:«cº¾µoª·ÈªŸTJ­½QJÀ5|*ŒV«•U¾35_ú¿…ªÿÕüªÁ^ª|lºÂ5|ª·Çk¬#Væ©•[x¹õSêU·ªyXz¯…T\nÃÕê°Fµ¬9X.1%`è¶ñ§*eÒÆ¬[Ê±}a@7qà«œª·VÊ<`¸ğU^£ÁV*WªNUVŠ®‰£dåU¯K‰WV±l~êÉ5dåU£“•Xê¢]cŠ¯•”« U€¬†–æ/eddº‘{*ãEì¬dr¬UezÈõckEÁ¬[VF³-cê²¡4\nÃBFJ¶|ì¨Êƒ•{O›µ<…h©\$µŒ½!ô\0Kœ÷<†wœòÜ5 kNpè)]z¢ùä+zÃé®eS.¢iF:ÚÑj<Ä´‡Ğ­«ñV:ªéŞ÷^\nO![`¤ny\n¨ 	k­çzMK ãZ•vÂ¾™ßóW§‰:›T;şr\rkRä‚•D8Qß<ir+¹!µ®'dÏ!–Z©^‰l5s3ÈTQño<é×¬â	ä3Ï\\Ï>•Œëòu<A*ˆ§€Î^\$¡9€>|ñùÉÊDW\rK@XÏ[z¶Û±Ç`Ò¯æ®LÙšM3Æn1…N³@çXÍ\\i;Œ”ÔĞ5˜‹—g»#\\G\0“LÍjµŸk?Íšvñ4®kÌÍ*Ğu¿–>©.­\r5r´B¢	¦`e‡¬¹š¹Z2´©)•¦+IW®!Z:¸izu¦¦®Vœ‡F­º´ı*à•¨«RM\\®H±LÑÉ§õºë“Nû£i\\µLÖ§b§‰¬šÉZÆk4ÅI‰áÿk[PêšÖ¹Jk“´)©®¢À(W,®	9œ’”æ™±jnfxÖÅv™]6yÓµ*ÙUÁ'8,B®U6F¶êÙÒÛ¦[Ku­¥3âduma-JƒææÖãœç76…¢Ã9¼s<'\nVïY/[Æ»mo:ÏuÜCëÖø˜õ9ÒW¨:ÏÓĞç\nV®ñ\\ıpiİÊ­+„ÖŠ®ğJf¸mwuV•ÅëKWœê£»ÅxÊâU¤+Ç×®ñ\\znİrzSˆU#W%®ñZšwäáE?µÑÄL9˜~®fo„áIµ®â+V´Qa\\ö»S¶J(®ºg\$M‡®“DµÜ¥l:ïÓ”§Îjtîjº|	«vè\n;dxîzs³ÃYPÚWÎÄ5—<ï€DÅYê¥èK¥¯¡_Jcı…ZröÕnÑ ±_Úã•k^+m,3\\aBerÄ¹Jj+ÖĞFwƒ;Ş)\$9Œ®Û]N’\$\0¦°P‚ÂÙµªÇİYL_œK1òfµ%É–Ç;Ï÷ñaâmK°¹\"‡\0Ö“¤ö%ä 6úï.ë?Üw\nÀ¹Ï‡­K l”ûxŞ)ùæ€Ya§¤Ø‘´#_>M(3Ôì—–šm¨ºP9h3Ó»¥¨°b0~Á¨À“ˆ[âX4N Ü¹á„HaÉ¨†YkÆAv„t£6^:Qì_‚l\"Â9°€NöRÔ	¹A\nQ¶Â¸kìLl+½®°öÀ–Ô@#Ìt¬ ½¸K¾õ“¿vĞB”Ì;^…¦	œ!gl9ØHD2ƒ.À{^æÍ; `¡4‚4íz\rŒ–G\r\0[\0ÄŒé¹\$é\\ŠD\"ÄÓÃœ qŒ›…7 ™´½ƒ{âRN „(Šuq¯Q¦¶%ˆ¡ÿ±HxmêÉt0_&EahĞÒôEøÏİØ7gn8¡åúX¿v\r×ş%Mf^Óäh°0¨1ìÉ±‡=ÇğRI\ryÚqØ±†æëÍ¡\r/&XÔ±Lüc\n\$@ÚìJ‚0Dˆá})­/Üd—.‚/—Ÿ6,t’é–!Ä@!š„°±\0VäÃ.ÅægFW°Ø^Â—e€‘5i­Ğ ´\"²ÚÇDR»¡ Z/´\"Ã¡ì–,ïÓÁ˜6=!dD1}‘6/ÖFÄTc;`x+#ì“±ƒ“¬7ƒ²0ß*ÈäJÛ!l·Q¼*hDÔ	PbçòBöšYÙ0\0ŞÉ\nÉ›!\r¬„KVÑ1è5G¤VP˜µ4«°ø=;w+%ŒlYIÈÛFÅ” æ–T„1²âïe 9¥•g˜íÁ¬1m²„âi:»ç\0‘¢èS3¿N²¾¼Í38Ôv¬±ÙaN x¡]ƒËEl²>¸±<éLÈT\rÁEbh½H²Î.ŒşÛ. +6‹ÇaÖÓAá€Ÿ àJ—şY‚³\"ÌlÅ5Ìºb\0o³\")”X‹f¡SdR³(òfu™ôµÿ¼²>{\"ÇAìqÎæ8§AŞÂ½£{8œŞÍp8k2‡LúY”ˆË©âµ›ˆ64¬VÄ‘TX\\Å› ‹ï¬àÌY±å1fÇ ÖqÌ:ìuØÂ|ıØ\\}‡‹ì,O0{ddsÍ‚Cÿ	B5¤à#H1zl\0%o“„,0Hide‘'†?6x½Ö±®à¾5Q¬öyÚ|¢p¶\rŸ+=†p×²X\r`!°q,÷>³§gÎĞ\$Û@¬Ô³ËÉpÙ¸\\¡6Õş£\${¾^&Ï›{<ÌyØòZ6jÇ¾Çeš¬ö†³¤jo¶\$MXá«(v‰lŒ•@Mh°˜d¶EíX“¬„‹DÀVì§y|jHæĞu¢`TpZ­/FeÎÒ-†{E–sNÚØüªdíp€\$°uPddÄ£5“şo2ÚL ªØ¿\nc«ÌË8¡^fXŠ\nó:Z{£o<ìt1´Íi,:õE6šC*Å+–=iÀİ¦û(Ô¬V½_rÛEæ!—šlDìvZƒ´¦ı†Å¦pÊ¶N<=K´Î“r	Ü#@;°\0Â4ŠvÔĞ7YkA¸ì°º±œ¬`(KÖ¨#Ìƒ2ª\rQŒH!/v7l/…°Ác±íb!ĞXìÆxÂÍ(¥¤4—6®@¢€cLjğJ±!Ğ7£€£fzXî“å¬	v°6ÚÈµŠ¯=pTqX-`5µ€zjÖ\0À¡µ¶°ÿcåk%òióı¶²MúÚÀ€x:tLc1,—Å…v4†­)°áN”/9B‘„ğ¹é€ŠÎ\rš9¨NŒ8IG©Ê@ Û{¡·:ö¨´/M¢›xJ¢áº'EÉ(€(¶#rHE '¤2`qˆÑS|èaªØØ`R€ÏÜ9¶@â¼°ƒÃÅ^Ú€s¶BFˆ«Wkd&ö’İ¥MOn\0œ¸!ï0#6ËzÛ/)Y´åÃ¦ë]–¾Ÿƒæq^x‰´ü–OÌúŞK/ˆ\nƒ[G ab:™9;3dôMS¹?‹9¨üå£R×û\r‚Ù?\"s1g~x×");}else{header("Content-Type: image/gif");switch($_GET["file"]){case"plus.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0!„©ËíMñÌ*)¾oú¯) q•¡eˆµî#ÄòLË\0;";break;case"cross.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0#„©Ëí#\naÖFo~yÃ._wa”á1ç±JîGÂL×6]\0\0;";break;case"up.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMQN\nï}ôa8ŠyšaÅ¶®\0Çò\0;";break;case"down.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMñÌ*)¾[Wş\\¢ÇL&ÙœÆ¶•\0Çò\0;";break;case"arrow.gif":echo"GIF89a\0\n\0€\0\0€€€ÿÿÿ!ù\0\0\0,\0\0\0\0\0\n\0\0‚i–±‹”ªÓ²Ş»\0\0;";break;}}exit;}if($_GET["script"]=="version"){$gd=file_open_lock(get_temp_dir()."/adminer.version");if($gd)file_write_unlock($gd,serialize(array("signature"=>$_POST["signature"],"version"=>$_POST["version"])));exit;}global$b,$f,$dc,$lc,$vc,$n,$id,$od,$ba,$Ld,$x,$ca,$ge,$hf,$Sf,$xh,$sd,$di,$ji,$si,$zi,$ia;if(!$_SERVER["REQUEST_URI"])$_SERVER["REQUEST_URI"]=$_SERVER["ORIG_PATH_INFO"];if(!strpos($_SERVER["REQUEST_URI"],'?')&&$_SERVER["QUERY_STRING"]!="")$_SERVER["REQUEST_URI"].="?$_SERVER[QUERY_STRING]";if($_SERVER["HTTP_X_FORWARDED_PREFIX"])$_SERVER["REQUEST_URI"]=$_SERVER["HTTP_X_FORWARDED_PREFIX"].$_SERVER["REQUEST_URI"];$ba=$_SERVER["HTTPS"]&&strcasecmp($_SERVER["HTTPS"],"off");@ini_set("session.use_trans_sid",false);if(!defined("SID")){session_cache_limiter("");session_name("adminer_sid");$Ff=array(0,preg_replace('~\\?.*~','',$_SERVER["REQUEST_URI"]),"",$ba);if(version_compare(PHP_VERSION,'5.2.0')>=0)$Ff[]=true;call_user_func_array('session_set_cookie_params',$Ff);session_start();}remove_slashes(array(&$_GET,&$_POST,&$_COOKIE),$Uc);if(get_magic_quotes_runtime())set_magic_quotes_runtime(false);@set_time_limit(0);@ini_set("zend.ze1_compatibility_mode",false);@ini_set("precision",15);function
get_lang(){return'zh-tw';}function
lang($ii,$Ye=null){if(is_array($ii)){$Vf=($Ye==1?0:1);$ii=$ii[$Vf];}$ii=str_replace("%d","%s",$ii);$Ye=format_number($Ye);return
sprintf($ii,$Ye);}if(extension_loaded('pdo')){class
Min_PDO
extends
PDO{var$_result,$server_info,$affected_rows,$errno,$error;function
__construct(){global$b;$Vf=array_search("SQL",$b->operators);if($Vf!==false)unset($b->operators[$Vf]);}function
dsn($ic,$V,$F,$pf=array()){try{parent::__construct($ic,$V,$F,$pf);}catch(Exception$_c){auth_error(h($_c->getMessage()));}$this->setAttribute(13,array('Min_PDOStatement'));$this->server_info=@$this->getAttribute(4);}function
query($G,$ti=false){$H=parent::query($G);$this->error="";if(!$H){list(,$this->errno,$this->error)=$this->errorInfo();return
false;}$this->store_result($H);return$H;}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result($H=null){if(!$H){$H=$this->_result;if(!$H)return
false;}if($H->columnCount()){$H->num_rows=$H->rowCount();return$H;}$this->affected_rows=$H->rowCount();return
true;}function
next_result(){if(!$this->_result)return
false;$this->_result->_offset=0;return@$this->_result->nextRowset();}function
result($G,$o=0){$H=$this->query($G);if(!$H)return
false;$J=$H->fetch();return$J[$o];}}class
Min_PDOStatement
extends
PDOStatement{var$_offset=0,$num_rows;function
fetch_assoc(){return$this->fetch(2);}function
fetch_row(){return$this->fetch(3);}function
fetch_field(){$J=(object)$this->getColumnMeta($this->_offset++);$J->orgtable=$J->table;$J->orgname=$J->name;$J->charsetnr=(in_array("blob",(array)$J->flags)?63:0);return$J;}}}$dc=array();class
Min_SQL{var$_conn;function
__construct($f){$this->_conn=$f;}function
select($R,$L,$Z,$ld,$rf=array(),$z=1,$E=0,$dg=false){global$b,$x;$Sd=(count($ld)<count($L));$G=$b->selectQueryBuild($L,$Z,$ld,$rf,$z,$E);if(!$G)$G="SELECT".limit(($_GET["page"]!="last"&&$z!=""&&$ld&&$Sd&&$x=="sql"?"SQL_CALC_FOUND_ROWS ":"").implode(", ",$L)."\nFROM ".table($R),($Z?"\nWHERE ".implode(" AND ",$Z):"").($ld&&$Sd?"\nGROUP BY ".implode(", ",$ld):"").($rf?"\nORDER BY ".implode(", ",$rf):""),($z!=""?+$z:null),($E?$z*$E:0),"\n");$th=microtime(true);$I=$this->_conn->query($G);if($dg)echo$b->selectQuery($G,$th,!$I);return$I;}function
delete($R,$ng,$z=0){$G="FROM ".table($R);return
queries("DELETE".($z?limit1($R,$G,$ng):" $G$ng"));}function
update($R,$O,$ng,$z=0,$M="\n"){$Ki=array();foreach($O
as$y=>$X)$Ki[]="$y = $X";$G=table($R)." SET$M".implode(",$M",$Ki);return
queries("UPDATE".($z?limit1($R,$G,$ng,$M):" $G$ng"));}function
insert($R,$O){return
queries("INSERT INTO ".table($R).($O?" (".implode(", ",array_keys($O)).")\nVALUES (".implode(", ",$O).")":" DEFAULT VALUES"));}function
insertUpdate($R,$K,$bg){return
false;}function
begin(){return
queries("BEGIN");}function
commit(){return
queries("COMMIT");}function
rollback(){return
queries("ROLLBACK");}function
convertSearch($u,$X,$o){return$u;}function
value($X,$o){return$X;}function
quoteBinary($Pg){return
q($Pg);}function
warnings(){return'';}function
tableHelp($C){}}$dc["sqlite"]="SQLite 3";$dc["sqlite2"]="SQLite 2";if(isset($_GET["sqlite"])||isset($_GET["sqlite2"])){$Yf=array((isset($_GET["sqlite"])?"SQLite3":"SQLite"),"PDO_SQLite");define("DRIVER",(isset($_GET["sqlite"])?"sqlite":"sqlite2"));if(class_exists(isset($_GET["sqlite"])?"SQLite3":"SQLiteDatabase")){if(isset($_GET["sqlite"])){class
Min_SQLite{var$extension="SQLite3",$server_info,$affected_rows,$errno,$error,$_link;function
__construct($Tc){$this->_link=new
SQLite3($Tc);$Ni=$this->_link->version();$this->server_info=$Ni["versionString"];}function
query($G){$H=@$this->_link->query($G);$this->error="";if(!$H){$this->errno=$this->_link->lastErrorCode();$this->error=$this->_link->lastErrorMsg();return
false;}elseif($H->numColumns())return
new
Min_Result($H);$this->affected_rows=$this->_link->changes();return
true;}function
quote($Q){return(is_utf8($Q)?"'".$this->_link->escapeString($Q)."'":"x'".reset(unpack('H*',$Q))."'");}function
store_result(){return$this->_result;}function
result($G,$o=0){$H=$this->query($G);if(!is_object($H))return
false;$J=$H->_result->fetchArray();return$J[$o];}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($H){$this->_result=$H;}function
fetch_assoc(){return$this->_result->fetchArray(SQLITE3_ASSOC);}function
fetch_row(){return$this->_result->fetchArray(SQLITE3_NUM);}function
fetch_field(){$d=$this->_offset++;$U=$this->_result->columnType($d);return(object)array("name"=>$this->_result->columnName($d),"type"=>$U,"charsetnr"=>($U==SQLITE3_BLOB?63:0),);}function
__desctruct(){return$this->_result->finalize();}}}else{class
Min_SQLite{var$extension="SQLite",$server_info,$affected_rows,$error,$_link;function
__construct($Tc){$this->server_info=sqlite_libversion();$this->_link=new
SQLiteDatabase($Tc);}function
query($G,$ti=false){$Ke=($ti?"unbufferedQuery":"query");$H=@$this->_link->$Ke($G,SQLITE_BOTH,$n);$this->error="";if(!$H){$this->error=$n;return
false;}elseif($H===true){$this->affected_rows=$this->changes();return
true;}return
new
Min_Result($H);}function
quote($Q){return"'".sqlite_escape_string($Q)."'";}function
store_result(){return$this->_result;}function
result($G,$o=0){$H=$this->query($G);if(!is_object($H))return
false;$J=$H->_result->fetch();return$J[$o];}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($H){$this->_result=$H;if(method_exists($H,'numRows'))$this->num_rows=$H->numRows();}function
fetch_assoc(){$J=$this->_result->fetch(SQLITE_ASSOC);if(!$J)return
false;$I=array();foreach($J
as$y=>$X)$I[($y[0]=='"'?idf_unescape($y):$y)]=$X;return$I;}function
fetch_row(){return$this->_result->fetch(SQLITE_NUM);}function
fetch_field(){$C=$this->_result->fieldName($this->_offset++);$Rf='(\\[.*]|"(?:[^"]|"")*"|(.+))';if(preg_match("~^($Rf\\.)?$Rf\$~",$C,$B)){$R=($B[3]!=""?$B[3]:idf_unescape($B[2]));$C=($B[5]!=""?$B[5]:idf_unescape($B[4]));}return(object)array("name"=>$C,"orgname"=>$C,"orgtable"=>$R,);}}}}elseif(extension_loaded("pdo_sqlite")){class
Min_SQLite
extends
Min_PDO{var$extension="PDO_SQLite";function
__construct($Tc){$this->dsn(DRIVER.":$Tc","","");}}}if(class_exists("Min_SQLite")){class
Min_DB
extends
Min_SQLite{function
__construct(){parent::__construct(":memory:");$this->query("PRAGMA foreign_keys = 1");}function
select_db($Tc){if(is_readable($Tc)&&$this->query("ATTACH ".$this->quote(preg_match("~(^[/\\\\]|:)~",$Tc)?$Tc:dirname($_SERVER["SCRIPT_FILENAME"])."/$Tc")." AS a")){parent::__construct($Tc);$this->query("PRAGMA foreign_keys = 1");return
true;}return
false;}function
multi_query($G){return$this->_result=$this->query($G);}function
next_result(){return
false;}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($R,$K,$bg){$Ki=array();foreach($K
as$O)$Ki[]="(".implode(", ",$O).")";return
queries("REPLACE INTO ".table($R)." (".implode(", ",array_keys(reset($K))).") VALUES\n".implode(",\n",$Ki));}function
tableHelp($C){if($C=="sqlite_sequence")return"fileformat2.html#seqtab";if($C=="sqlite_master")return"fileformat2.html#$C";}}function
idf_escape($u){return'"'.str_replace('"','""',$u).'"';}function
table($u){return
idf_escape($u);}function
connect(){return
new
Min_DB;}function
get_databases(){return
array();}function
limit($G,$Z,$z,$D=0,$M=" "){return" $G$Z".($z!==null?$M."LIMIT $z".($D?" OFFSET $D":""):"");}function
limit1($R,$G,$Z,$M="\n"){global$f;return(preg_match('~^INTO~',$G)||$f->result("SELECT sqlite_compileoption_used('ENABLE_UPDATE_DELETE_LIMIT')")?limit($G,$Z,1,0,$M):" $G WHERE rowid = (SELECT rowid FROM ".table($R).$Z.$M."LIMIT 1)");}function
db_collation($l,$pb){global$f;return$f->result("PRAGMA encoding");}function
engines(){return
array();}function
logged_user(){return
get_current_user();}function
tables_list(){return
get_key_vals("SELECT name, type FROM sqlite_master WHERE type IN ('table', 'view') ORDER BY (name = 'sqlite_sequence'), name",1);}function
count_tables($k){return
array();}function
table_status($C=""){global$f;$I=array();foreach(get_rows("SELECT name AS Name, type AS Engine, 'rowid' AS Oid, '' AS Auto_increment FROM sqlite_master WHERE type IN ('table', 'view') ".($C!=""?"AND name = ".q($C):"ORDER BY name"))as$J){$J["Rows"]=$f->result("SELECT COUNT(*) FROM ".idf_escape($J["Name"]));$I[$J["Name"]]=$J;}foreach(get_rows("SELECT * FROM sqlite_sequence",null,"")as$J)$I[$J["name"]]["Auto_increment"]=$J["seq"];return($C!=""?$I[$C]:$I);}function
is_view($S){return$S["Engine"]=="view";}function
fk_support($S){global$f;return!$f->result("SELECT sqlite_compileoption_used('OMIT_FOREIGN_KEY')");}function
fields($R){global$f;$I=array();$bg="";foreach(get_rows("PRAGMA table_info(".table($R).")")as$J){$C=$J["name"];$U=strtolower($J["type"]);$Rb=$J["dflt_value"];$I[$C]=array("field"=>$C,"type"=>(preg_match('~int~i',$U)?"integer":(preg_match('~char|clob|text~i',$U)?"text":(preg_match('~blob~i',$U)?"blob":(preg_match('~real|floa|doub~i',$U)?"real":"numeric")))),"full_type"=>$U,"default"=>(preg_match("~'(.*)'~",$Rb,$B)?str_replace("''","'",$B[1]):($Rb=="NULL"?null:$Rb)),"null"=>!$J["notnull"],"privileges"=>array("select"=>1,"insert"=>1,"update"=>1),"primary"=>$J["pk"],);if($J["pk"]){if($bg!="")$I[$bg]["auto_increment"]=false;elseif(preg_match('~^integer$~i',$U))$I[$C]["auto_increment"]=true;$bg=$C;}}$oh=$f->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($R));preg_match_all('~(("[^"]*+")+|[a-z0-9_]+)\s+text\s+COLLATE\s+(\'[^\']+\'|\S+)~i',$oh,$xe,PREG_SET_ORDER);foreach($xe
as$B){$C=str_replace('""','"',preg_replace('~^"|"$~','',$B[1]));if($I[$C])$I[$C]["collation"]=trim($B[3],"'");}return$I;}function
indexes($R,$g=null){global$f;if(!is_object($g))$g=$f;$I=array();$oh=$g->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($R));if(preg_match('~\bPRIMARY\s+KEY\s*\((([^)"]+|"[^"]*"|`[^`]*`)++)~i',$oh,$B)){$I[""]=array("type"=>"PRIMARY","columns"=>array(),"lengths"=>array(),"descs"=>array());preg_match_all('~((("[^"]*+")+|(?:`[^`]*+`)+)|(\S+))(\s+(ASC|DESC))?(,\s*|$)~i',$B[1],$xe,PREG_SET_ORDER);foreach($xe
as$B){$I[""]["columns"][]=idf_unescape($B[2]).$B[4];$I[""]["descs"][]=(preg_match('~DESC~i',$B[5])?'1':null);}}if(!$I){foreach(fields($R)as$C=>$o){if($o["primary"])$I[""]=array("type"=>"PRIMARY","columns"=>array($C),"lengths"=>array(),"descs"=>array(null));}}$rh=get_key_vals("SELECT name, sql FROM sqlite_master WHERE type = 'index' AND tbl_name = ".q($R),$g);foreach(get_rows("PRAGMA index_list(".table($R).")",$g)as$J){$C=$J["name"];$v=array("type"=>($J["unique"]?"UNIQUE":"INDEX"));$v["lengths"]=array();$v["descs"]=array();foreach(get_rows("PRAGMA index_info(".idf_escape($C).")",$g)as$Og){$v["columns"][]=$Og["name"];$v["descs"][]=null;}if(preg_match('~^CREATE( UNIQUE)? INDEX '.preg_quote(idf_escape($C).' ON '.idf_escape($R),'~').' \((.*)\)$~i',$rh[$C],$zg)){preg_match_all('/("[^"]*+")+( DESC)?/',$zg[2],$xe);foreach($xe[2]as$y=>$X){if($X)$v["descs"][$y]='1';}}if(!$I[""]||$v["type"]!="UNIQUE"||$v["columns"]!=$I[""]["columns"]||$v["descs"]!=$I[""]["descs"]||!preg_match("~^sqlite_~",$C))$I[$C]=$v;}return$I;}function
foreign_keys($R){$I=array();foreach(get_rows("PRAGMA foreign_key_list(".table($R).")")as$J){$q=&$I[$J["id"]];if(!$q)$q=$J;$q["source"][]=$J["from"];$q["target"][]=$J["to"];}return$I;}function
adm_view($C){global$f;return
array("select"=>preg_replace('~^(?:[^`"[]+|`[^`]*`|"[^"]*")* AS\\s+~iU','',$f->result("SELECT sql FROM sqlite_master WHERE name = ".q($C))));}function
collations(){return(isset($_GET["create"])?get_vals("PRAGMA collation_list",1):array());}function
information_schema($l){return
false;}function
error(){global$f;return
h($f->error);}function
check_sqlite_name($C){global$f;$Jc="db|sdb|sqlite";if(!preg_match("~^[^\\0]*\\.($Jc)\$~",$C)){$f->error=sprintf('è«‹ä½¿ç”¨ä¸‹åˆ—å…¶ä¸­ä¸€å€‹æ“´å……æ¨¡çµ„ %sã€‚',str_replace("|",", ",$Jc));return
false;}return
true;}function
create_database($l,$ob){global$f;if(file_exists($l)){$f->error='æª”æ¡ˆå·²å­˜åœ¨ã€‚';return
false;}if(!check_sqlite_name($l))return
false;try{$_=new
Min_SQLite($l);}catch(Exception$_c){$f->error=$_c->getMessage();return
false;}$_->query('PRAGMA encoding = "UTF-8"');$_->query('CREATE TABLE adminer (i)');$_->query('DROP TABLE adminer');return
true;}function
drop_databases($k){global$f;$f->__construct(":memory:");foreach($k
as$l){if(!@unlink($l)){$f->error='æª”æ¡ˆå·²å­˜åœ¨ã€‚';return
false;}}return
true;}function
rename_database($C,$ob){global$f;if(!check_sqlite_name($C))return
false;$f->__construct(":memory:");$f->error='æª”æ¡ˆå·²å­˜åœ¨ã€‚';return@rename(DB,$C);}function
auto_increment(){return" PRIMARY KEY".(DRIVER=="sqlite"?" AUTOINCREMENT":"");}function
alter_table($R,$C,$p,$ad,$ub,$tc,$ob,$La,$Lf){$Ei=($R==""||$ad);foreach($p
as$o){if($o[0]!=""||!$o[1]||$o[2]){$Ei=true;break;}}$c=array();$_f=array();foreach($p
as$o){if($o[1]){$c[]=($Ei?$o[1]:"ADD ".implode($o[1]));if($o[0]!="")$_f[$o[0]]=$o[1][0];}}if(!$Ei){foreach($c
as$X){if(!queries("ALTER TABLE ".table($R)." $X"))return
false;}if($R!=$C&&!queries("ALTER TABLE ".table($R)." RENAME TO ".table($C)))return
false;}elseif(!recreate_table($R,$C,$c,$_f,$ad))return
false;if($La)queries("UPDATE sqlite_sequence SET seq = $La WHERE name = ".q($C));return
true;}function
recreate_table($R,$C,$p,$_f,$ad,$w=array()){if($R!=""){if(!$p){foreach(fields($R)as$y=>$o){if($w)$o["auto_increment"]=0;$p[]=process_field($o,$o);$_f[$y]=idf_escape($y);}}$cg=false;foreach($p
as$o){if($o[6])$cg=true;}$gc=array();foreach($w
as$y=>$X){if($X[2]=="DROP"){$gc[$X[1]]=true;unset($w[$y]);}}foreach(indexes($R)as$ae=>$v){$e=array();foreach($v["columns"]as$y=>$d){if(!$_f[$d])continue
2;$e[]=$_f[$d].($v["descs"][$y]?" DESC":"");}if(!$gc[$ae]){if($v["type"]!="PRIMARY"||!$cg)$w[]=array($v["type"],$ae,$e);}}foreach($w
as$y=>$X){if($X[0]=="PRIMARY"){unset($w[$y]);$ad[]="  PRIMARY KEY (".implode(", ",$X[2]).")";}}foreach(foreign_keys($R)as$ae=>$q){foreach($q["source"]as$y=>$d){if(!$_f[$d])continue
2;$q["source"][$y]=idf_unescape($_f[$d]);}if(!isset($ad[" $ae"]))$ad[]=" ".format_foreign_key($q);}queries("BEGIN");}foreach($p
as$y=>$o)$p[$y]="  ".implode($o);$p=array_merge($p,array_filter($ad));if(!queries("CREATE TABLE ".table($R!=""?"adminer_$C":$C)." (\n".implode(",\n",$p)."\n)"))return
false;if($R!=""){if($_f&&!queries("INSERT INTO ".table("adminer_$C")." (".implode(", ",$_f).") SELECT ".implode(", ",array_map('idf_escape',array_keys($_f)))." FROM ".table($R)))return
false;$pi=array();foreach(triggers($R)as$ni=>$Vh){$mi=trigger($ni);$pi[]="CREATE TRIGGER ".idf_escape($ni)." ".implode(" ",$Vh)." ON ".table($C)."\n$mi[Statement]";}if(!queries("DROP TABLE ".table($R)))return
false;queries("ALTER TABLE ".table("adminer_$C")." RENAME TO ".table($C));if(!alter_indexes($C,$w))return
false;foreach($pi
as$mi){if(!queries($mi))return
false;}queries("COMMIT");}return
true;}function
index_sql($R,$U,$C,$e){return"CREATE $U ".($U!="INDEX"?"INDEX ":"").idf_escape($C!=""?$C:uniqid($R."_"))." ON ".table($R)." $e";}function
alter_indexes($R,$c){foreach($c
as$bg){if($bg[0]=="PRIMARY")return
recreate_table($R,$R,array(),array(),array(),$c);}foreach(array_reverse($c)as$X){if(!queries($X[2]=="DROP"?"DROP INDEX ".idf_escape($X[1]):index_sql($R,$X[0],$X[1],"(".implode(", ",$X[2]).")")))return
false;}return
true;}function
truncate_tables($T){return
apply_queries("DELETE FROM",$T);}function
drop_views($Pi){return
apply_queries("DROP VIEW",$Pi);}function
drop_tables($T){return
apply_queries("DROP TABLE",$T);}function
move_tables($T,$Pi,$Mh){return
false;}function
trigger($C){global$f;if($C=="")return
array("Statement"=>"BEGIN\n\t;\nEND");$u='(?:[^`"\\s]+|`[^`]*`|"[^"]*")+';$oi=trigger_options();preg_match("~^CREATE\\s+TRIGGER\\s*$u\\s*(".implode("|",$oi["Timing"]).")\\s+([a-z]+)(?:\\s+OF\\s+($u))?\\s+ON\\s*$u\\s*(?:FOR\\s+EACH\\s+ROW\\s)?(.*)~is",$f->result("SELECT sql FROM sqlite_master WHERE type = 'trigger' AND name = ".q($C)),$B);$af=$B[3];return
array("Timing"=>strtoupper($B[1]),"Event"=>strtoupper($B[2]).($af?" OF":""),"Of"=>($af[0]=='`'||$af[0]=='"'?idf_unescape($af):$af),"Trigger"=>$C,"Statement"=>$B[4],);}function
triggers($R){$I=array();$oi=trigger_options();foreach(get_rows("SELECT * FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($R))as$J){preg_match('~^CREATE\\s+TRIGGER\\s*(?:[^`"\\s]+|`[^`]*`|"[^"]*")+\\s*('.implode("|",$oi["Timing"]).')\\s*(.*)\\s+ON\\b~iU',$J["sql"],$B);$I[$J["name"]]=array($B[1],$B[2]);}return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","UPDATE OF","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
begin(){return
queries("BEGIN");}function
last_id(){global$f;return$f->result("SELECT LAST_INSERT_ROWID()");}function
explain($f,$G){return$f->query("EXPLAIN QUERY PLAN $G");}function
found_rows($S,$Z){}function
types(){return
array();}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($Sg){return
true;}function
create_sql($R,$La,$yh){global$f;$I=$f->result("SELECT sql FROM sqlite_master WHERE type IN ('table', 'view') AND name = ".q($R));foreach(indexes($R)as$C=>$v){if($C=='')continue;$I.=";\n\n".index_sql($R,$v['type'],$C,"(".implode(", ",array_map('idf_escape',$v['columns'])).")");}return$I;}function
truncate_sql($R){return"DELETE FROM ".table($R);}function
use_sql($j){}function
trigger_sql($R){return
implode(get_vals("SELECT sql || ';;\n' FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($R)));}function
show_variables(){global$f;$I=array();foreach(array("auto_vacuum","cache_size","count_changes","default_cache_size","empty_result_callbacks","encoding","foreign_keys","full_column_names","fullfsync","journal_mode","journal_size_limit","legacy_file_format","locking_mode","page_size","max_page_count","read_uncommitted","recursive_triggers","reverse_unordered_selects","secure_delete","short_column_names","synchronous","temp_store","temp_store_directory","schema_version","integrity_check","quick_check")as$y)$I[$y]=$f->result("PRAGMA $y");return$I;}function
show_status(){$I=array();foreach(get_vals("PRAGMA compile_options")as$of){list($y,$X)=explode("=",$of,2);$I[$y]=$X;}return$I;}function
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
support($Oc){return
preg_match('~^(columns|database|drop_col|dump|indexes|move_col|sql|status|table|trigger|variables|view|view_trigger)$~',$Oc);}$x="sqlite";$si=array("integer"=>0,"real"=>0,"numeric"=>0,"text"=>0,"blob"=>0);$xh=array_keys($si);$zi=array();$mf=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL");$id=array("hex","length","lower","round","unixepoch","upper");$od=array("avg","count","count distinct","group_concat","max","min","sum");$lc=array(array(),array("integer|real|numeric"=>"+/-","text"=>"||",));}$dc["pgsql"]="PostgreSQL";if(isset($_GET["pgsql"])){$Yf=array("PgSQL","PDO_PgSQL");define("DRIVER","pgsql");if(extension_loaded("pgsql")){class
Min_DB{var$extension="PgSQL",$_link,$_result,$_string,$_database=true,$server_info,$affected_rows,$error;function
_error($wc,$n){if(ini_bool("html_errors"))$n=html_entity_decode(strip_tags($n));$n=preg_replace('~^[^:]*: ~','',$n);$this->error=$n;}function
connect($N,$V,$F){global$b;$l=$b->database();set_error_handler(array($this,'_error'));$this->_string="host='".str_replace(":","' port='",addcslashes($N,"'\\"))."' user='".addcslashes($V,"'\\")."' password='".addcslashes($F,"'\\")."'";$this->_link=@pg_connect("$this->_string dbname='".($l!=""?addcslashes($l,"'\\"):"postgres")."'",PGSQL_CONNECT_FORCE_NEW);if(!$this->_link&&$l!=""){$this->_database=false;$this->_link=@pg_connect("$this->_string dbname='postgres'",PGSQL_CONNECT_FORCE_NEW);}restore_error_handler();if($this->_link){$Ni=pg_version($this->_link);$this->server_info=$Ni["server"];pg_set_client_encoding($this->_link,"UTF8");}return(bool)$this->_link;}function
quote($Q){return"'".pg_escape_string($this->_link,$Q)."'";}function
value($X,$o){return($o["type"]=="bytea"?pg_unescape_bytea($X):$X);}function
quoteBinary($Q){return"'".pg_escape_bytea($this->_link,$Q)."'";}function
select_db($j){global$b;if($j==$b->database())return$this->_database;$I=@pg_connect("$this->_string dbname='".addcslashes($j,"'\\")."'",PGSQL_CONNECT_FORCE_NEW);if($I)$this->_link=$I;return$I;}function
close(){$this->_link=@pg_connect("$this->_string dbname='postgres'");}function
query($G,$ti=false){$H=@pg_query($this->_link,$G);$this->error="";if(!$H){$this->error=pg_last_error($this->_link);return
false;}elseif(!pg_num_fields($H)){$this->affected_rows=pg_affected_rows($H);return
true;}return
new
Min_Result($H);}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($G,$o=0){$H=$this->query($G);if(!$H||!$H->num_rows)return
false;return
pg_fetch_result($H->_result,0,$o);}function
warnings(){return
h(pg_last_notice($this->_link));}}class
Min_Result{var$_result,$_offset=0,$num_rows;function
__construct($H){$this->_result=$H;$this->num_rows=pg_num_rows($H);}function
fetch_assoc(){return
pg_fetch_assoc($this->_result);}function
fetch_row(){return
pg_fetch_row($this->_result);}function
fetch_field(){$d=$this->_offset++;$I=new
stdClass;if(function_exists('pg_field_table'))$I->orgtable=pg_field_table($this->_result,$d);$I->name=pg_field_name($this->_result,$d);$I->orgname=$I->name;$I->type=pg_field_type($this->_result,$d);$I->charsetnr=($I->type=="bytea"?63:0);return$I;}function
__destruct(){pg_free_result($this->_result);}}}elseif(extension_loaded("pdo_pgsql")){class
Min_DB
extends
Min_PDO{var$extension="PDO_PgSQL";function
connect($N,$V,$F){global$b;$l=$b->database();$Q="pgsql:host='".str_replace(":","' port='",addcslashes($N,"'\\"))."' options='-c client_encoding=utf8'";$this->dsn("$Q dbname='".($l!=""?addcslashes($l,"'\\"):"postgres")."'",$V,$F);return
true;}function
select_db($j){global$b;return($b->database()==$j);}function
value($X,$o){return$X;}function
quoteBinary($Pg){return
q($Pg);}function
warnings(){return'';}function
close(){}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($R,$K,$bg){global$f;foreach($K
as$O){$_i=array();$Z=array();foreach($O
as$y=>$X){$_i[]="$y = $X";if(isset($bg[idf_unescape($y)]))$Z[]="$y = $X";}if(!(($Z&&queries("UPDATE ".table($R)." SET ".implode(", ",$_i)." WHERE ".implode(" AND ",$Z))&&$f->affected_rows)||queries("INSERT INTO ".table($R)." (".implode(", ",array_keys($O)).") VALUES (".implode(", ",$O).")")))return
false;}return
true;}function
convertSearch($u,$X,$o){return(preg_match('~char|text'.(is_numeric($X["val"])&&!preg_match('~LIKE~',$X["op"])?'|'.number_type():'').'~',$o["type"])?$u:"CAST($u AS text)");}function
value($X,$o){return$this->_conn->value($X,$o);}function
quoteBinary($Pg){return$this->_conn->quoteBinary($Pg);}function
warnings(){return$this->_conn->warnings();}function
tableHelp($C){$qe=array("information_schema"=>"infoschema","pg_catalog"=>"catalog",);$_=$qe[$_GET["ns"]];if($_)return"$_-".str_replace("_","-",$C).".html";}}function
idf_escape($u){return'"'.str_replace('"','""',$u).'"';}function
table($u){return
idf_escape($u);}function
connect(){global$b,$si,$xh;$f=new
Min_DB;$i=$b->credentials();if($f->connect($i[0],$i[1],$i[2])){if(min_version(9,0,$f)){$f->query("SET application_name = 'Adminer'");if(min_version(9.2,0,$f)){$xh['å­—ä¸²'][]="json";$si["json"]=4294967295;if(min_version(9.4,0,$f)){$xh['å­—ä¸²'][]="jsonb";$si["jsonb"]=4294967295;}}}return$f;}return$f->error;}function
get_databases(){return
get_vals("SELECT datname FROM pg_database WHERE has_database_privilege(datname, 'CONNECT') ORDER BY datname");}function
limit($G,$Z,$z,$D=0,$M=" "){return" $G$Z".($z!==null?$M."LIMIT $z".($D?" OFFSET $D":""):"");}function
limit1($R,$G,$Z,$M="\n"){return(preg_match('~^INTO~',$G)?limit($G,$Z,1,0,$M):" $G WHERE ctid = (SELECT ctid FROM ".table($R).$Z.$M."LIMIT 1)");}function
db_collation($l,$pb){global$f;return$f->result("SHOW LC_COLLATE");}function
engines(){return
array();}function
logged_user(){global$f;return$f->result("SELECT user");}function
tables_list(){$G="SELECT table_name, table_type FROM information_schema.tables WHERE table_schema = current_schema()";if(support('materializedview'))$G.="
UNION ALL
SELECT matviewname, 'MATERIALIZED VIEW'
FROM pg_matviews
WHERE schemaname = current_schema()";$G.="
ORDER BY 1";return
get_key_vals($G);}function
count_tables($k){return
array();}function
table_status($C=""){$I=array();foreach(get_rows("SELECT c.relname AS \"Name\", CASE c.relkind WHEN 'r' THEN 'table' WHEN 'm' THEN 'materialized view' ELSE 'view' END AS \"Engine\", pg_relation_size(c.oid) AS \"Data_length\", pg_total_relation_size(c.oid) - pg_relation_size(c.oid) AS \"Index_length\", obj_description(c.oid, 'pg_class') AS \"Comment\", CASE WHEN c.relhasoids THEN 'oid' ELSE '' END AS \"Oid\", c.reltuples as \"Rows\", n.nspname
FROM pg_class c
JOIN pg_namespace n ON(n.nspname = current_schema() AND n.oid = c.relnamespace)
WHERE relkind IN ('r', 'm', 'v', 'f')
".($C!=""?"AND relname = ".q($C):"ORDER BY relname"))as$J)$I[$J["Name"]]=$J;return($C!=""?$I[$C]:$I);}function
is_view($S){return
in_array($S["Engine"],array("view","materialized view"));}function
fk_support($S){return
true;}function
fields($R){$I=array();$Ca=array('timestamp without time zone'=>'timestamp','timestamp with time zone'=>'timestamptz',);foreach(get_rows("SELECT a.attname AS field, format_type(a.atttypid, a.atttypmod) AS full_type, d.adsrc AS default, a.attnotnull::int, col_description(c.oid, a.attnum) AS comment
FROM pg_class c
JOIN pg_namespace n ON c.relnamespace = n.oid
JOIN pg_attribute a ON c.oid = a.attrelid
LEFT JOIN pg_attrdef d ON c.oid = d.adrelid AND a.attnum = d.adnum
WHERE c.relname = ".q($R)."
AND n.nspname = current_schema()
AND NOT a.attisdropped
AND a.attnum > 0
ORDER BY a.attnum")as$J){preg_match('~([^([]+)(\((.*)\))?([a-z ]+)?((\[[0-9]*])*)$~',$J["full_type"],$B);list(,$U,$ne,$J["length"],$wa,$Fa)=$B;$J["length"].=$Fa;$db=$U.$wa;if(isset($Ca[$db])){$J["type"]=$Ca[$db];$J["full_type"]=$J["type"].$ne.$Fa;}else{$J["type"]=$U;$J["full_type"]=$J["type"].$ne.$wa.$Fa;}$J["null"]=!$J["attnotnull"];$J["auto_increment"]=preg_match('~^nextval\\(~i',$J["default"]);$J["privileges"]=array("insert"=>1,"select"=>1,"update"=>1);if(preg_match('~(.+)::[^)]+(.*)~',$J["default"],$B))$J["default"]=($B[1]=="NULL"?null:(($B[1][0]=="'"?idf_unescape($B[1]):$B[1]).$B[2]));$I[$J["field"]]=$J;}return$I;}function
indexes($R,$g=null){global$f;if(!is_object($g))$g=$f;$I=array();$Fh=$g->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = ".q($R));$e=get_key_vals("SELECT attnum, attname FROM pg_attribute WHERE attrelid = $Fh AND attnum > 0",$g);foreach(get_rows("SELECT relname, indisunique::int, indisprimary::int, indkey, indoption , (indpred IS NOT NULL)::int as indispartial FROM pg_index i, pg_class ci WHERE i.indrelid = $Fh AND ci.oid = i.indexrelid",$g)as$J){$_g=$J["relname"];$I[$_g]["type"]=($J["indispartial"]?"INDEX":($J["indisprimary"]?"PRIMARY":($J["indisunique"]?"UNIQUE":"INDEX")));$I[$_g]["columns"]=array();foreach(explode(" ",$J["indkey"])as$Hd)$I[$_g]["columns"][]=$e[$Hd];$I[$_g]["descs"]=array();foreach(explode(" ",$J["indoption"])as$Id)$I[$_g]["descs"][]=($Id&1?'1':null);$I[$_g]["lengths"]=array();}return$I;}function
foreign_keys($R){global$hf;$I=array();foreach(get_rows("SELECT conname, condeferrable::int AS deferrable, pg_get_constraintdef(oid) AS definition
FROM pg_constraint
WHERE conrelid = (SELECT pc.oid FROM pg_class AS pc INNER JOIN pg_namespace AS pn ON (pn.oid = pc.relnamespace) WHERE pc.relname = ".q($R)." AND pn.nspname = current_schema())
AND contype = 'f'::char
ORDER BY conkey, conname")as$J){if(preg_match('~FOREIGN KEY\s*\((.+)\)\s*REFERENCES (.+)\((.+)\)(.*)$~iA',$J['definition'],$B)){$J['source']=array_map('trim',explode(',',$B[1]));if(preg_match('~^(("([^"]|"")+"|[^"]+)\.)?"?("([^"]|"")+"|[^"]+)$~',$B[2],$we)){$J['ns']=str_replace('""','"',preg_replace('~^"(.+)"$~','\1',$we[2]));$J['table']=str_replace('""','"',preg_replace('~^"(.+)"$~','\1',$we[4]));}$J['target']=array_map('trim',explode(',',$B[3]));$J['on_delete']=(preg_match("~ON DELETE ($hf)~",$B[4],$we)?$we[1]:'NO ACTION');$J['on_update']=(preg_match("~ON UPDATE ($hf)~",$B[4],$we)?$we[1]:'NO ACTION');$I[$J['conname']]=$J;}}return$I;}function
adm_view($C){global$f;return
array("select"=>trim($f->result("SELECT view_definition
FROM information_schema.views
WHERE table_schema = current_schema() AND table_name = ".q($C))));}function
collations(){return
array();}function
information_schema($l){return($l=="information_schema");}function
error(){global$f;$I=h($f->error);if(preg_match('~^(.*\\n)?([^\\n]*)\\n( *)\\^(\\n.*)?$~s',$I,$B))$I=$B[1].preg_replace('~((?:[^&]|&[^;]*;){'.strlen($B[3]).'})(.*)~','\\1<b>\\2</b>',$B[2]).$B[4];return
nl_br($I);}function
create_database($l,$ob){return
queries("CREATE DATABASE ".idf_escape($l).($ob?" ENCODING ".idf_escape($ob):""));}function
drop_databases($k){global$f;$f->close();return
apply_queries("DROP DATABASE",$k,'idf_escape');}function
rename_database($C,$ob){return
queries("ALTER DATABASE ".idf_escape(DB)." RENAME TO ".idf_escape($C));}function
auto_increment(){return"";}function
alter_table($R,$C,$p,$ad,$ub,$tc,$ob,$La,$Lf){$c=array();$mg=array();foreach($p
as$o){$d=idf_escape($o[0]);$X=$o[1];if(!$X)$c[]="DROP $d";else{$Ji=$X[5];unset($X[5]);if(isset($X[6])&&$o[0]=="")$X[1]=($X[1]=="bigint"?" big":" ")."serial";if($o[0]=="")$c[]=($R!=""?"ADD ":"  ").implode($X);else{if($d!=$X[0])$mg[]="ALTER TABLE ".table($R)." RENAME $d TO $X[0]";$c[]="ALTER $d TYPE$X[1]";if(!$X[6]){$c[]="ALTER $d ".($X[3]?"SET$X[3]":"DROP DEFAULT");$c[]="ALTER $d ".($X[2]==" NULL"?"DROP NOT":"SET").$X[2];}}if($o[0]!=""||$Ji!="")$mg[]="COMMENT ON COLUMN ".table($R).".$X[0] IS ".($Ji!=""?substr($Ji,9):"''");}}$c=array_merge($c,$ad);if($R=="")array_unshift($mg,"CREATE TABLE ".table($C)." (\n".implode(",\n",$c)."\n)");elseif($c)array_unshift($mg,"ALTER TABLE ".table($R)."\n".implode(",\n",$c));if($R!=""&&$R!=$C)$mg[]="ALTER TABLE ".table($R)." RENAME TO ".table($C);if($R!=""||$ub!="")$mg[]="COMMENT ON TABLE ".table($C)." IS ".q($ub);if($La!=""){}foreach($mg
as$G){if(!queries($G))return
false;}return
true;}function
alter_indexes($R,$c){$h=array();$ec=array();$mg=array();foreach($c
as$X){if($X[0]!="INDEX")$h[]=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");elseif($X[2]=="DROP")$ec[]=idf_escape($X[1]);else$mg[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($R."_"))." ON ".table($R)." (".implode(", ",$X[2]).")";}if($h)array_unshift($mg,"ALTER TABLE ".table($R).implode(",",$h));if($ec)array_unshift($mg,"DROP INDEX ".implode(", ",$ec));foreach($mg
as$G){if(!queries($G))return
false;}return
true;}function
truncate_tables($T){return
queries("TRUNCATE ".implode(", ",array_map('table',$T)));return
true;}function
drop_views($Pi){return
drop_tables($Pi);}function
drop_tables($T){foreach($T
as$R){$P=table_status($R);if(!queries("DROP ".strtoupper($P["Engine"])." ".table($R)))return
false;}return
true;}function
move_tables($T,$Pi,$Mh){foreach(array_merge($T,$Pi)as$R){$P=table_status($R);if(!queries("ALTER ".strtoupper($P["Engine"])." ".table($R)." SET SCHEMA ".idf_escape($Mh)))return
false;}return
true;}function
trigger($C,$R=null){if($C=="")return
array("Statement"=>"EXECUTE PROCEDURE ()");if($R===null)$R=$_GET['trigger'];$K=get_rows('SELECT t.trigger_name AS "Trigger", t.action_timing AS "Timing", (SELECT STRING_AGG(event_manipulation, \' OR \') FROM information_schema.triggers WHERE event_object_table = t.event_object_table AND trigger_name = t.trigger_name ) AS "Events", t.event_manipulation AS "Event", \'FOR EACH \' || t.action_orientation AS "Type", t.action_statement AS "Statement" FROM information_schema.triggers t WHERE t.event_object_table = '.q($R).' AND t.trigger_name = '.q($C));return
reset($K);}function
triggers($R){$I=array();foreach(get_rows("SELECT * FROM information_schema.triggers WHERE event_object_table = ".q($R))as$J)$I[$J["trigger_name"]]=array($J["action_timing"],$J["event_manipulation"]);return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("FOR EACH ROW","FOR EACH STATEMENT"),);}function
routine($C,$U){$K=get_rows('SELECT routine_definition AS definition, LOWER(external_language) AS language, *
FROM information_schema.routines
WHERE routine_schema = current_schema() AND specific_name = '.q($C));$I=$K[0];$I["returns"]=array("type"=>$I["type_udt_name"]);$I["fields"]=get_rows('SELECT parameter_name AS field, data_type AS type, character_maximum_length AS length, parameter_mode AS inout
FROM information_schema.parameters
WHERE specific_schema = current_schema() AND specific_name = '.q($C).'
ORDER BY ordinal_position');return$I;}function
routines(){return
get_rows('SELECT specific_name AS "SPECIFIC_NAME", routine_type AS "ROUTINE_TYPE", routine_name AS "ROUTINE_NAME", type_udt_name AS "DTD_IDENTIFIER"
FROM information_schema.routines
WHERE routine_schema = current_schema()
ORDER BY SPECIFIC_NAME');}function
routine_languages(){return
get_vals("SELECT LOWER(lanname) FROM pg_catalog.pg_language");}function
routine_id($C,$J){$I=array();foreach($J["fields"]as$o)$I[]=$o["type"];return
idf_escape($C)."(".implode(", ",$I).")";}function
last_id(){return
0;}function
explain($f,$G){return$f->query("EXPLAIN $G");}function
found_rows($S,$Z){global$f;if(preg_match("~ rows=([0-9]+)~",$f->result("EXPLAIN SELECT * FROM ".idf_escape($S["Name"]).($Z?" WHERE ".implode(" AND ",$Z):"")),$zg))return$zg[1];return
false;}function
types(){return
get_vals("SELECT typname
FROM pg_type
WHERE typnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema())
AND typtype IN ('b','d','e')
AND typelem = 0");}function
schemas(){return
get_vals("SELECT nspname FROM pg_namespace ORDER BY nspname");}function
get_schema(){global$f;return$f->result("SELECT current_schema()");}function
set_schema($Rg){global$f,$si,$xh;$I=$f->query("SET search_path TO ".idf_escape($Rg));foreach(types()as$U){if(!isset($si[$U])){$si[$U]=0;$xh['ä½¿ç”¨è€…é¡å‹'][]=$U;}}return$I;}function
create_sql($R,$La,$yh){global$f;$I='';$Hg=array();$bh=array();$P=table_status($R);$p=fields($R);$w=indexes($R);ksort($w);$Yc=foreign_keys($R);ksort($Yc);if(!$P||empty($p))return
false;$I="CREATE TABLE ".idf_escape($P['nspname']).".".idf_escape($P['Name'])." (\n    ";foreach($p
as$Qc=>$o){$If=idf_escape($o['field']).' '.$o['full_type'].default_value($o).($o['attnotnull']?" NOT NULL":"");$Hg[]=$If;if(preg_match('~nextval\(\'([^\']+)\'\)~',$o['default'],$xe)){$ah=$xe[1];$nh=reset(get_rows(min_version(10)?"SELECT *, cache_size AS cache_value FROM pg_sequences WHERE schemaname = current_schema() AND sequencename = ".q($ah):"SELECT * FROM $ah"));$bh[]=($yh=="DROP+CREATE"?"DROP SEQUENCE IF EXISTS $ah;\n":"")."CREATE SEQUENCE $ah INCREMENT $nh[increment_by] MINVALUE $nh[min_value] MAXVALUE $nh[max_value] START ".($La?$nh['last_value']:1)." CACHE $nh[cache_value];";}}if(!empty($bh))$I=implode("\n\n",$bh)."\n\n$I";foreach($w
as$Cd=>$v){switch($v['type']){case'UNIQUE':$Hg[]="CONSTRAINT ".idf_escape($Cd)." UNIQUE (".implode(', ',array_map('idf_escape',$v['columns'])).")";break;case'PRIMARY':$Hg[]="CONSTRAINT ".idf_escape($Cd)." PRIMARY KEY (".implode(', ',array_map('idf_escape',$v['columns'])).")";break;}}foreach($Yc
as$Xc=>$Wc)$Hg[]="CONSTRAINT ".idf_escape($Xc)." $Wc[definition] ".($Wc['deferrable']?'DEFERRABLE':'NOT DEFERRABLE');$I.=implode(",\n    ",$Hg)."\n) WITH (oids = ".($P['Oid']?'true':'false').");";foreach($w
as$Cd=>$v){if($v['type']=='INDEX')$I.="\n\nCREATE INDEX ".idf_escape($Cd)." ON ".idf_escape($P['nspname']).".".idf_escape($P['Name'])." USING btree (".implode(', ',array_map('idf_escape',$v['columns'])).");";}if($P['Comment'])$I.="\n\nCOMMENT ON TABLE ".idf_escape($P['nspname']).".".idf_escape($P['Name'])." IS ".q($P['Comment']).";";foreach($p
as$Qc=>$o){if($o['comment'])$I.="\n\nCOMMENT ON COLUMN ".idf_escape($P['nspname']).".".idf_escape($P['Name']).".".idf_escape($Qc)." IS ".q($o['comment']).";";}return
rtrim($I,';');}function
truncate_sql($R){return"TRUNCATE ".table($R);}function
trigger_sql($R){$P=table_status($R);$I="";foreach(triggers($R)as$li=>$ki){$mi=trigger($li,$P['Name']);$I.="\nCREATE TRIGGER ".idf_escape($mi['Trigger'])." $mi[Timing] $mi[Events] ON ".idf_escape($P["nspname"]).".".idf_escape($P['Name'])." $mi[Type] $mi[Statement];;\n";}return$I;}function
use_sql($j){return"\connect ".idf_escape($j);}function
show_variables(){return
get_key_vals("SHOW ALL");}function
process_list(){return
get_rows("SELECT * FROM pg_stat_activity ORDER BY ".(min_version(9.2)?"pid":"procpid"));}function
show_status(){}function
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
support($Oc){return
preg_match('~^(database|table|columns|sql|indexes|comment|view|'.(min_version(9.3)?'materializedview|':'').'scheme|routine|processlist|sequence|trigger|type|variables|drop_col|kill|dump)$~',$Oc);}function
kill_process($X){return
queries("SELECT pg_terminate_backend(".number($X).")");}function
connection_id(){return"SELECT pg_backend_pid()";}function
max_connections(){global$f;return$f->result("SHOW max_connections");}$x="pgsql";$si=array();$xh=array();foreach(array('æ•¸å­—'=>array("smallint"=>5,"integer"=>10,"bigint"=>19,"boolean"=>1,"numeric"=>0,"real"=>7,"double precision"=>16,"money"=>20),'æ—¥æœŸæ™‚é–“'=>array("date"=>13,"time"=>17,"timestamp"=>20,"timestamptz"=>21,"interval"=>0),'å­—ä¸²'=>array("character"=>0,"character varying"=>0,"text"=>0,"tsquery"=>0,"tsvector"=>0,"uuid"=>0,"xml"=>0),'äºŒé€²ä½'=>array("bit"=>0,"bit varying"=>0,"bytea"=>0),'ç¶²è·¯'=>array("cidr"=>43,"inet"=>43,"macaddr"=>17,"txid_snapshot"=>0),'å¹¾ä½•'=>array("box"=>0,"circle"=>0,"line"=>0,"lseg"=>0,"path"=>0,"point"=>0,"polygon"=>0),)as$y=>$X){$si+=$X;$xh[$y]=array_keys($X);}$zi=array();$mf=array("=","<",">","<=",">=","!=","~","!~","LIKE","LIKE %%","ILIKE","ILIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL");$id=array("char_length","lower","round","to_hex","to_timestamp","upper");$od=array("avg","count","count distinct","max","min","sum");$lc=array(array("char"=>"md5","date|time"=>"now",),array(number_type()=>"+/-","date|time"=>"+ interval/- interval","char|text"=>"||",));}$dc["oracle"]="Oracle (beta)";if(isset($_GET["oracle"])){$Yf=array("OCI8","PDO_OCI");define("DRIVER","oracle");if(extension_loaded("oci8")){class
Min_DB{var$extension="oci8",$_link,$_result,$server_info,$affected_rows,$errno,$error;function
_error($wc,$n){if(ini_bool("html_errors"))$n=html_entity_decode(strip_tags($n));$n=preg_replace('~^[^:]*: ~','',$n);$this->error=$n;}function
connect($N,$V,$F){$this->_link=@oci_new_connect($V,$F,$N,"AL32UTF8");if($this->_link){$this->server_info=oci_server_version($this->_link);return
true;}$n=oci_error();$this->error=$n["message"];return
false;}function
quote($Q){return"'".str_replace("'","''",$Q)."'";}function
select_db($j){return
true;}function
query($G,$ti=false){$H=oci_parse($this->_link,$G);$this->error="";if(!$H){$n=oci_error($this->_link);$this->errno=$n["code"];$this->error=$n["message"];return
false;}set_error_handler(array($this,'_error'));$I=@oci_execute($H);restore_error_handler();if($I){if(oci_num_fields($H))return
new
Min_Result($H);$this->affected_rows=oci_num_rows($H);}return$I;}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($G,$o=1){$H=$this->query($G);if(!is_object($H)||!oci_fetch($H->_result))return
false;return
oci_result($H->_result,$o);}}class
Min_Result{var$_result,$_offset=1,$num_rows;function
__construct($H){$this->_result=$H;}function
_convert($J){foreach((array)$J
as$y=>$X){if(is_a($X,'OCI-Lob'))$J[$y]=$X->load();}return$J;}function
fetch_assoc(){return$this->_convert(oci_fetch_assoc($this->_result));}function
fetch_row(){return$this->_convert(oci_fetch_row($this->_result));}function
fetch_field(){$d=$this->_offset++;$I=new
stdClass;$I->name=oci_field_name($this->_result,$d);$I->orgname=$I->name;$I->type=oci_field_type($this->_result,$d);$I->charsetnr=(preg_match("~raw|blob|bfile~",$I->type)?63:0);return$I;}function
__destruct(){oci_free_statement($this->_result);}}}elseif(extension_loaded("pdo_oci")){class
Min_DB
extends
Min_PDO{var$extension="PDO_OCI";function
connect($N,$V,$F){$this->dsn("oci:dbname=//$N;charset=AL32UTF8",$V,$F);return
true;}function
select_db($j){return
true;}}}class
Min_Driver
extends
Min_SQL{function
begin(){return
true;}}function
idf_escape($u){return'"'.str_replace('"','""',$u).'"';}function
table($u){return
idf_escape($u);}function
connect(){global$b;$f=new
Min_DB;$i=$b->credentials();if($f->connect($i[0],$i[1],$i[2]))return$f;return$f->error;}function
get_databases(){return
get_vals("SELECT tablespace_name FROM user_tablespaces");}function
limit($G,$Z,$z,$D=0,$M=" "){return($D?" * FROM (SELECT t.*, rownum AS rnum FROM (SELECT $G$Z) t WHERE rownum <= ".($z+$D).") WHERE rnum > $D":($z!==null?" * FROM (SELECT $G$Z) WHERE rownum <= ".($z+$D):" $G$Z"));}function
limit1($R,$G,$Z,$M="\n"){return" $G$Z";}function
db_collation($l,$pb){global$f;return$f->result("SELECT value FROM nls_database_parameters WHERE parameter = 'NLS_CHARACTERSET'");}function
engines(){return
array();}function
logged_user(){global$f;return$f->result("SELECT USER FROM DUAL");}function
tables_list(){return
get_key_vals("SELECT table_name, 'table' FROM all_tables WHERE tablespace_name = ".q(DB)."
UNION SELECT view_name, 'view' FROM user_views
ORDER BY 1");}function
count_tables($k){return
array();}function
table_status($C=""){$I=array();$Tg=q($C);foreach(get_rows('SELECT table_name "Name", \'table\' "Engine", avg_row_len * num_rows "Data_length", num_rows "Rows" FROM all_tables WHERE tablespace_name = '.q(DB).($C!=""?" AND table_name = $Tg":"")."
UNION SELECT view_name, 'view', 0, 0 FROM user_views".($C!=""?" WHERE view_name = $Tg":"")."
ORDER BY 1")as$J){if($C!="")return$J;$I[$J["Name"]]=$J;}return$I;}function
is_view($S){return$S["Engine"]=="view";}function
fk_support($S){return
true;}function
fields($R){$I=array();foreach(get_rows("SELECT * FROM all_tab_columns WHERE table_name = ".q($R)." ORDER BY column_id")as$J){$U=$J["DATA_TYPE"];$ne="$J[DATA_PRECISION],$J[DATA_SCALE]";if($ne==",")$ne=$J["DATA_LENGTH"];$I[$J["COLUMN_NAME"]]=array("field"=>$J["COLUMN_NAME"],"full_type"=>$U.($ne?"($ne)":""),"type"=>strtolower($U),"length"=>$ne,"default"=>$J["DATA_DEFAULT"],"null"=>($J["NULLABLE"]=="Y"),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),);}return$I;}function
indexes($R,$g=null){$I=array();foreach(get_rows("SELECT uic.*, uc.constraint_type
FROM user_ind_columns uic
LEFT JOIN user_constraints uc ON uic.index_name = uc.constraint_name AND uic.table_name = uc.table_name
WHERE uic.table_name = ".q($R)."
ORDER BY uc.constraint_type, uic.column_position",$g)as$J){$Cd=$J["INDEX_NAME"];$I[$Cd]["type"]=($J["CONSTRAINT_TYPE"]=="P"?"PRIMARY":($J["CONSTRAINT_TYPE"]=="U"?"UNIQUE":"INDEX"));$I[$Cd]["columns"][]=$J["COLUMN_NAME"];$I[$Cd]["lengths"][]=($J["CHAR_LENGTH"]&&$J["CHAR_LENGTH"]!=$J["COLUMN_LENGTH"]?$J["CHAR_LENGTH"]:null);$I[$Cd]["descs"][]=($J["DESCEND"]?'1':null);}return$I;}function
adm_view($C){$K=get_rows('SELECT text "select" FROM user_views WHERE view_name = '.q($C));return
reset($K);}function
collations(){return
array();}function
information_schema($l){return
false;}function
error(){global$f;return
h($f->error);}function
explain($f,$G){$f->query("EXPLAIN PLAN FOR $G");return$f->query("SELECT * FROM plan_table");}function
found_rows($S,$Z){}function
alter_table($R,$C,$p,$ad,$ub,$tc,$ob,$La,$Lf){$c=$ec=array();foreach($p
as$o){$X=$o[1];if($X&&$o[0]!=""&&idf_escape($o[0])!=$X[0])queries("ALTER TABLE ".table($R)." RENAME COLUMN ".idf_escape($o[0])." TO $X[0]");if($X)$c[]=($R!=""?($o[0]!=""?"MODIFY (":"ADD ("):"  ").implode($X).($R!=""?")":"");else$ec[]=idf_escape($o[0]);}if($R=="")return
queries("CREATE TABLE ".table($C)." (\n".implode(",\n",$c)."\n)");return(!$c||queries("ALTER TABLE ".table($R)."\n".implode("\n",$c)))&&(!$ec||queries("ALTER TABLE ".table($R)." DROP (".implode(", ",$ec).")"))&&($R==$C||queries("ALTER TABLE ".table($R)." RENAME TO ".table($C)));}function
foreign_keys($R){$I=array();$G="SELECT c_list.CONSTRAINT_NAME as NAME,
c_src.COLUMN_NAME as SRC_COLUMN,
c_dest.OWNER as DEST_DB,
c_dest.TABLE_NAME as DEST_TABLE,
c_dest.COLUMN_NAME as DEST_COLUMN,
c_list.DELETE_RULE as ON_DELETE
FROM ALL_CONSTRAINTS c_list, ALL_CONS_COLUMNS c_src, ALL_CONS_COLUMNS c_dest
WHERE c_list.CONSTRAINT_NAME = c_src.CONSTRAINT_NAME
AND c_list.R_CONSTRAINT_NAME = c_dest.CONSTRAINT_NAME
AND c_list.CONSTRAINT_TYPE = 'R'
AND c_src.TABLE_NAME = ".q($R);foreach(get_rows($G)as$J)$I[$J['NAME']]=array("db"=>$J['DEST_DB'],"table"=>$J['DEST_TABLE'],"source"=>array($J['SRC_COLUMN']),"target"=>array($J['DEST_COLUMN']),"on_delete"=>$J['ON_DELETE'],"on_update"=>null,);return$I;}function
truncate_tables($T){return
apply_queries("TRUNCATE TABLE",$T);}function
drop_views($Pi){return
apply_queries("DROP VIEW",$Pi);}function
drop_tables($T){return
apply_queries("DROP TABLE",$T);}function
last_id(){return
0;}function
schemas(){return
get_vals("SELECT DISTINCT owner FROM dba_segments WHERE owner IN (SELECT username FROM dba_users WHERE default_tablespace NOT IN ('SYSTEM','SYSAUX'))");}function
get_schema(){global$f;return$f->result("SELECT sys_context('USERENV', 'SESSION_USER') FROM dual");}function
set_schema($Sg){global$f;return$f->query("ALTER SESSION SET CURRENT_SCHEMA = ".idf_escape($Sg));}function
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
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
support($Oc){return
preg_match('~^(columns|database|drop_col|indexes|processlist|scheme|sql|status|table|variables|view|view_trigger)$~',$Oc);}$x="oracle";$si=array();$xh=array();foreach(array('æ•¸å­—'=>array("number"=>38,"binary_float"=>12,"binary_double"=>21),'æ—¥æœŸæ™‚é–“'=>array("date"=>10,"timestamp"=>29,"interval year"=>12,"interval day"=>28),'å­—ä¸²'=>array("char"=>2000,"varchar2"=>4000,"nchar"=>2000,"nvarchar2"=>4000,"clob"=>4294967295,"nclob"=>4294967295),'äºŒé€²ä½'=>array("raw"=>2000,"long raw"=>2147483648,"blob"=>4294967295,"bfile"=>4294967296),)as$y=>$X){$si+=$X;$xh[$y]=array_keys($X);}$zi=array();$mf=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL");$id=array("length","lower","round","upper");$od=array("avg","count","count distinct","max","min","sum");$lc=array(array("date"=>"current_date","timestamp"=>"current_timestamp",),array("number|float|double"=>"+/-","date|timestamp"=>"+ interval/- interval","char|clob"=>"||",));}$dc["mssql"]="MS SQL (beta)";if(isset($_GET["mssql"])){$Yf=array("SQLSRV","MSSQL","PDO_DBLIB");define("DRIVER","mssql");if(extension_loaded("sqlsrv")){class
Min_DB{var$extension="sqlsrv",$_link,$_result,$server_info,$affected_rows,$errno,$error;function
_get_error(){$this->error="";foreach(sqlsrv_errors()as$n){$this->errno=$n["code"];$this->error.="$n[message]\n";}$this->error=rtrim($this->error);}function
connect($N,$V,$F){$this->_link=@sqlsrv_connect($N,array("UID"=>$V,"PWD"=>$F,"CharacterSet"=>"UTF-8"));if($this->_link){$Jd=sqlsrv_server_info($this->_link);$this->server_info=$Jd['SQLServerVersion'];}else$this->_get_error();return(bool)$this->_link;}function
quote($Q){return"'".str_replace("'","''",$Q)."'";}function
select_db($j){return$this->query("USE ".idf_escape($j));}function
query($G,$ti=false){$H=sqlsrv_query($this->_link,$G);$this->error="";if(!$H){$this->_get_error();return
false;}return$this->store_result($H);}function
multi_query($G){$this->_result=sqlsrv_query($this->_link,$G);$this->error="";if(!$this->_result){$this->_get_error();return
false;}return
true;}function
store_result($H=null){if(!$H)$H=$this->_result;if(!$H)return
false;if(sqlsrv_field_metadata($H))return
new
Min_Result($H);$this->affected_rows=sqlsrv_rows_affected($H);return
true;}function
next_result(){return$this->_result?sqlsrv_next_result($this->_result):null;}function
result($G,$o=0){$H=$this->query($G);if(!is_object($H))return
false;$J=$H->fetch_row();return$J[$o];}}class
Min_Result{var$_result,$_offset=0,$_fields,$num_rows;function
__construct($H){$this->_result=$H;}function
_convert($J){foreach((array)$J
as$y=>$X){if(is_a($X,'DateTime'))$J[$y]=$X->format("Y-m-d H:i:s");}return$J;}function
fetch_assoc(){return$this->_convert(sqlsrv_fetch_array($this->_result,SQLSRV_FETCH_ASSOC));}function
fetch_row(){return$this->_convert(sqlsrv_fetch_array($this->_result,SQLSRV_FETCH_NUMERIC));}function
fetch_field(){if(!$this->_fields)$this->_fields=sqlsrv_field_metadata($this->_result);$o=$this->_fields[$this->_offset++];$I=new
stdClass;$I->name=$o["Name"];$I->orgname=$o["Name"];$I->type=($o["Type"]==1?254:0);return$I;}function
seek($D){for($s=0;$s<$D;$s++)sqlsrv_fetch($this->_result);}function
__destruct(){sqlsrv_free_stmt($this->_result);}}}elseif(extension_loaded("mssql")){class
Min_DB{var$extension="MSSQL",$_link,$_result,$server_info,$affected_rows,$error;function
connect($N,$V,$F){$this->_link=@mssql_connect($N,$V,$F);if($this->_link){$H=$this->query("SELECT SERVERPROPERTY('ProductLevel'), SERVERPROPERTY('Edition')");$J=$H->fetch_row();$this->server_info=$this->result("sp_server_info 2",2)." [$J[0]] $J[1]";}else$this->error=mssql_get_last_message();return(bool)$this->_link;}function
quote($Q){return"'".str_replace("'","''",$Q)."'";}function
select_db($j){return
mssql_select_db($j);}function
query($G,$ti=false){$H=@mssql_query($G,$this->_link);$this->error="";if(!$H){$this->error=mssql_get_last_message();return
false;}if($H===true){$this->affected_rows=mssql_rows_affected($this->_link);return
true;}return
new
Min_Result($H);}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
mssql_next_result($this->_result->_result);}function
result($G,$o=0){$H=$this->query($G);if(!is_object($H))return
false;return
mssql_result($H->_result,0,$o);}}class
Min_Result{var$_result,$_offset=0,$_fields,$num_rows;function
__construct($H){$this->_result=$H;$this->num_rows=mssql_num_rows($H);}function
fetch_assoc(){return
mssql_fetch_assoc($this->_result);}function
fetch_row(){return
mssql_fetch_row($this->_result);}function
num_rows(){return
mssql_num_rows($this->_result);}function
fetch_field(){$I=mssql_fetch_field($this->_result);$I->orgtable=$I->table;$I->orgname=$I->name;return$I;}function
seek($D){mssql_data_seek($this->_result,$D);}function
__destruct(){mssql_free_result($this->_result);}}}elseif(extension_loaded("pdo_dblib")){class
Min_DB
extends
Min_PDO{var$extension="PDO_DBLIB";function
connect($N,$V,$F){$this->dsn("dblib:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\\d)~',';port=\\1',$N)),$V,$F);return
true;}function
select_db($j){return$this->query("USE ".idf_escape($j));}}}class
Min_Driver
extends
Min_SQL{function
insertUpdate($R,$K,$bg){foreach($K
as$O){$_i=array();$Z=array();foreach($O
as$y=>$X){$_i[]="$y = $X";if(isset($bg[idf_unescape($y)]))$Z[]="$y = $X";}if(!queries("MERGE ".table($R)." USING (VALUES(".implode(", ",$O).")) AS source (c".implode(", c",range(1,count($O))).") ON ".implode(" AND ",$Z)." WHEN MATCHED THEN UPDATE SET ".implode(", ",$_i)." WHEN NOT MATCHED THEN INSERT (".implode(", ",array_keys($O)).") VALUES (".implode(", ",$O).");"))return
false;}return
true;}function
begin(){return
queries("BEGIN TRANSACTION");}}function
idf_escape($u){return"[".str_replace("]","]]",$u)."]";}function
table($u){return($_GET["ns"]!=""?idf_escape($_GET["ns"]).".":"").idf_escape($u);}function
connect(){global$b;$f=new
Min_DB;$i=$b->credentials();if($f->connect($i[0],$i[1],$i[2]))return$f;return$f->error;}function
get_databases(){return
get_vals("SELECT name FROM sys.databases WHERE name NOT IN ('master', 'tempdb', 'model', 'msdb')");}function
limit($G,$Z,$z,$D=0,$M=" "){return($z!==null?" TOP (".($z+$D).")":"")." $G$Z";}function
limit1($R,$G,$Z,$M="\n"){return
limit($G,$Z,1,0,$M);}function
db_collation($l,$pb){global$f;return$f->result("SELECT collation_name FROM sys.databases WHERE name = ".q($l));}function
engines(){return
array();}function
logged_user(){global$f;return$f->result("SELECT SUSER_NAME()");}function
tables_list(){return
get_key_vals("SELECT name, type_desc FROM sys.all_objects WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ORDER BY name");}function
count_tables($k){global$f;$I=array();foreach($k
as$l){$f->select_db($l);$I[$l]=$f->result("SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES");}return$I;}function
table_status($C=""){$I=array();foreach(get_rows("SELECT name AS Name, type_desc AS Engine FROM sys.all_objects WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ".($C!=""?"AND name = ".q($C):"ORDER BY name"))as$J){if($C!="")return$J;$I[$J["Name"]]=$J;}return$I;}function
is_view($S){return$S["Engine"]=="VIEW";}function
fk_support($S){return
true;}function
fields($R){$I=array();foreach(get_rows("SELECT c.max_length, c.precision, c.scale, c.name, c.is_nullable, c.is_identity, c.collation_name, t.name type, CAST(d.definition as text) [default]
FROM sys.all_columns c
JOIN sys.all_objects o ON c.object_id = o.object_id
JOIN sys.types t ON c.user_type_id = t.user_type_id
LEFT JOIN sys.default_constraints d ON c.default_object_id = d.parent_column_id
WHERE o.schema_id = SCHEMA_ID(".q(get_schema()).") AND o.type IN ('S', 'U', 'V') AND o.name = ".q($R))as$J){$U=$J["type"];$ne=(preg_match("~char|binary~",$U)?$J["max_length"]:($U=="decimal"?"$J[precision],$J[scale]":""));$I[$J["name"]]=array("field"=>$J["name"],"full_type"=>$U.($ne?"($ne)":""),"type"=>$U,"length"=>$ne,"default"=>$J["default"],"null"=>$J["is_nullable"],"auto_increment"=>$J["is_identity"],"collation"=>$J["collation_name"],"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),"primary"=>$J["is_identity"],);}return$I;}function
indexes($R,$g=null){$I=array();foreach(get_rows("SELECT i.name, key_ordinal, is_unique, is_primary_key, c.name AS column_name, is_descending_key
FROM sys.indexes i
INNER JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
INNER JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
WHERE OBJECT_NAME(i.object_id) = ".q($R),$g)as$J){$C=$J["name"];$I[$C]["type"]=($J["is_primary_key"]?"PRIMARY":($J["is_unique"]?"UNIQUE":"INDEX"));$I[$C]["lengths"]=array();$I[$C]["columns"][$J["key_ordinal"]]=$J["column_name"];$I[$C]["descs"][$J["key_ordinal"]]=($J["is_descending_key"]?'1':null);}return$I;}function
adm_view($C){global$f;return
array("select"=>preg_replace('~^(?:[^[]|\\[[^]]*])*\\s+AS\\s+~isU','',$f->result("SELECT VIEW_DEFINITION FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = SCHEMA_NAME() AND TABLE_NAME = ".q($C))));}function
collations(){$I=array();foreach(get_vals("SELECT name FROM fn_helpcollations()")as$ob)$I[preg_replace('~_.*~','',$ob)][]=$ob;return$I;}function
information_schema($l){return
false;}function
error(){global$f;return
nl_br(h(preg_replace('~^(\\[[^]]*])+~m','',$f->error)));}function
create_database($l,$ob){return
queries("CREATE DATABASE ".idf_escape($l).(preg_match('~^[a-z0-9_]+$~i',$ob)?" COLLATE $ob":""));}function
drop_databases($k){return
queries("DROP DATABASE ".implode(", ",array_map('idf_escape',$k)));}function
rename_database($C,$ob){if(preg_match('~^[a-z0-9_]+$~i',$ob))queries("ALTER DATABASE ".idf_escape(DB)." COLLATE $ob");queries("ALTER DATABASE ".idf_escape(DB)." MODIFY NAME = ".idf_escape($C));return
true;}function
auto_increment(){return" IDENTITY".($_POST["Auto_increment"]!=""?"(".number($_POST["Auto_increment"]).",1)":"")." PRIMARY KEY";}function
alter_table($R,$C,$p,$ad,$ub,$tc,$ob,$La,$Lf){$c=array();foreach($p
as$o){$d=idf_escape($o[0]);$X=$o[1];if(!$X)$c["DROP"][]=" COLUMN $d";else{$X[1]=preg_replace("~( COLLATE )'(\\w+)'~","\\1\\2",$X[1]);if($o[0]=="")$c["ADD"][]="\n  ".implode("",$X).($R==""?substr($ad[$X[0]],16+strlen($X[0])):"");else{unset($X[6]);if($d!=$X[0])queries("EXEC sp_rename ".q(table($R).".$d").", ".q(idf_unescape($X[0])).", 'COLUMN'");$c["ALTER COLUMN ".implode("",$X)][]="";}}}if($R=="")return
queries("CREATE TABLE ".table($C)." (".implode(",",(array)$c["ADD"])."\n)");if($R!=$C)queries("EXEC sp_rename ".q(table($R)).", ".q($C));if($ad)$c[""]=$ad;foreach($c
as$y=>$X){if(!queries("ALTER TABLE ".idf_escape($C)." $y".implode(",",$X)))return
false;}return
true;}function
alter_indexes($R,$c){$v=array();$ec=array();foreach($c
as$X){if($X[2]=="DROP"){if($X[0]=="PRIMARY")$ec[]=idf_escape($X[1]);else$v[]=idf_escape($X[1])." ON ".table($R);}elseif(!queries(($X[0]!="PRIMARY"?"CREATE $X[0] ".($X[0]!="INDEX"?"INDEX ":"").idf_escape($X[1]!=""?$X[1]:uniqid($R."_"))." ON ".table($R):"ALTER TABLE ".table($R)." ADD PRIMARY KEY")." (".implode(", ",$X[2]).")"))return
false;}return(!$v||queries("DROP INDEX ".implode(", ",$v)))&&(!$ec||queries("ALTER TABLE ".table($R)." DROP ".implode(", ",$ec)));}function
last_id(){global$f;return$f->result("SELECT SCOPE_IDENTITY()");}function
explain($f,$G){$f->query("SET SHOWPLAN_ALL ON");$I=$f->query($G);$f->query("SET SHOWPLAN_ALL OFF");return$I;}function
found_rows($S,$Z){}function
foreign_keys($R){$I=array();foreach(get_rows("EXEC sp_fkeys @fktable_name = ".q($R))as$J){$q=&$I[$J["FK_NAME"]];$q["table"]=$J["PKTABLE_NAME"];$q["source"][]=$J["FKCOLUMN_NAME"];$q["target"][]=$J["PKCOLUMN_NAME"];}return$I;}function
truncate_tables($T){return
apply_queries("TRUNCATE TABLE",$T);}function
drop_views($Pi){return
queries("DROP VIEW ".implode(", ",array_map('table',$Pi)));}function
drop_tables($T){return
queries("DROP TABLE ".implode(", ",array_map('table',$T)));}function
move_tables($T,$Pi,$Mh){return
apply_queries("ALTER SCHEMA ".idf_escape($Mh)." TRANSFER",array_merge($T,$Pi));}function
trigger($C){if($C=="")return
array();$K=get_rows("SELECT s.name [Trigger],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(s.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(s.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing],
c.text
FROM sysobjects s
JOIN syscomments c ON s.id = c.id
WHERE s.xtype = 'TR' AND s.name = ".q($C));$I=reset($K);if($I)$I["Statement"]=preg_replace('~^.+\\s+AS\\s+~isU','',$I["text"]);return$I;}function
triggers($R){$I=array();foreach(get_rows("SELECT sys1.name,
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing]
FROM sysobjects sys1
JOIN sysobjects sys2 ON sys1.parent_obj = sys2.id
WHERE sys1.xtype = 'TR' AND sys2.name = ".q($R))as$J)$I[$J["name"]]=array($J["Timing"],$J["Event"]);return$I;}function
trigger_options(){return
array("Timing"=>array("AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("AS"),);}function
schemas(){return
get_vals("SELECT name FROM sys.schemas");}function
get_schema(){global$f;if($_GET["ns"]!="")return$_GET["ns"];return$f->result("SELECT SCHEMA_NAME()");}function
set_schema($Rg){return
true;}function
use_sql($j){return"USE ".idf_escape($j);}function
show_variables(){return
array();}function
show_status(){return
array();}function
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
support($Oc){return
preg_match('~^(columns|database|drop_col|indexes|scheme|sql|table|trigger|view|view_trigger)$~',$Oc);}$x="mssql";$si=array();$xh=array();foreach(array('æ•¸å­—'=>array("tinyint"=>3,"smallint"=>5,"int"=>10,"bigint"=>20,"bit"=>1,"decimal"=>0,"real"=>12,"float"=>53,"smallmoney"=>10,"money"=>20),'æ—¥æœŸæ™‚é–“'=>array("date"=>10,"smalldatetime"=>19,"datetime"=>19,"datetime2"=>19,"time"=>8,"datetimeoffset"=>10),'å­—ä¸²'=>array("char"=>8000,"varchar"=>8000,"text"=>2147483647,"nchar"=>4000,"nvarchar"=>4000,"ntext"=>1073741823),'äºŒé€²ä½'=>array("binary"=>8000,"varbinary"=>8000,"image"=>2147483647),)as$y=>$X){$si+=$X;$xh[$y]=array_keys($X);}$zi=array();$mf=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL");$id=array("len","lower","round","upper");$od=array("avg","count","count distinct","max","min","sum");$lc=array(array("date|time"=>"getdate",),array("int|decimal|real|float|money|datetime"=>"+/-","char|text"=>"+",));}$dc['firebird']='Firebird (alpha)';if(isset($_GET["firebird"])){$Yf=array("interbase");define("DRIVER","firebird");if(extension_loaded("interbase")){class
Min_DB{var$extension="Firebird",$server_info,$affected_rows,$errno,$error,$_link,$_result;function
connect($N,$V,$F){$this->_link=ibase_connect($N,$V,$F);if($this->_link){$Ci=explode(':',$N);$this->service_link=ibase_service_attach($Ci[0],$V,$F);$this->server_info=ibase_server_info($this->service_link,IBASE_SVC_SERVER_VERSION);}else{$this->errno=ibase_errcode();$this->error=ibase_errmsg();}return(bool)$this->_link;}function
quote($Q){return"'".str_replace("'","''",$Q)."'";}function
select_db($j){return($j=="domain");}function
query($G,$ti=false){$H=ibase_query($G,$this->_link);if(!$H){$this->errno=ibase_errcode();$this->error=ibase_errmsg();return
false;}$this->error="";if($H===true){$this->affected_rows=ibase_affected_rows($this->_link);return
true;}return
new
Min_Result($H);}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($G,$o=0){$H=$this->query($G);if(!$H||!$H->num_rows)return
false;$J=$H->fetch_row();return$J[$o];}}class
Min_Result{var$num_rows,$_result,$_offset=0;function
__construct($H){$this->_result=$H;}function
fetch_assoc(){return
ibase_fetch_assoc($this->_result);}function
fetch_row(){return
ibase_fetch_row($this->_result);}function
fetch_field(){$o=ibase_field_info($this->_result,$this->_offset++);return(object)array('name'=>$o['name'],'orgname'=>$o['name'],'type'=>$o['type'],'charsetnr'=>$o['length'],);}function
__destruct(){ibase_free_result($this->_result);}}}class
Min_Driver
extends
Min_SQL{}function
idf_escape($u){return'"'.str_replace('"','""',$u).'"';}function
table($u){return
idf_escape($u);}function
connect(){global$b;$f=new
Min_DB;$i=$b->credentials();if($f->connect($i[0],$i[1],$i[2]))return$f;return$f->error;}function
get_databases($Zc){return
array("domain");}function
limit($G,$Z,$z,$D=0,$M=" "){$I='';$I.=($z!==null?$M."FIRST $z".($D?" SKIP $D":""):"");$I.=" $G$Z";return$I;}function
limit1($R,$G,$Z,$M="\n"){return
limit($G,$Z,1,0,$M);}function
db_collation($l,$pb){}function
engines(){return
array();}function
logged_user(){global$b;$i=$b->credentials();return$i[1];}function
tables_list(){global$f;$G='SELECT RDB$RELATION_NAME FROM rdb$relations WHERE rdb$system_flag = 0';$H=ibase_query($f->_link,$G);$I=array();while($J=ibase_fetch_assoc($H))$I[$J['RDB$RELATION_NAME']]='table';ksort($I);return$I;}function
count_tables($k){return
array();}function
table_status($C="",$Nc=false){global$f;$I=array();$Kb=tables_list();foreach($Kb
as$v=>$X){$v=trim($v);$I[$v]=array('Name'=>$v,'Engine'=>'standard',);if($C==$v)return$I[$v];}return$I;}function
is_view($S){return
false;}function
fk_support($S){return
preg_match('~InnoDB|IBMDB2I~i',$S["Engine"]);}function
fields($R){global$f;$I=array();$G='SELECT r.RDB$FIELD_NAME AS field_name,
r.RDB$DESCRIPTION AS field_description,
r.RDB$DEFAULT_VALUE AS field_default_value,
r.RDB$NULL_FLAG AS field_not_null_constraint,
f.RDB$FIELD_LENGTH AS field_length,
f.RDB$FIELD_PRECISION AS field_precision,
f.RDB$FIELD_SCALE AS field_scale,
CASE f.RDB$FIELD_TYPE
WHEN 261 THEN \'BLOB\'
WHEN 14 THEN \'CHAR\'
WHEN 40 THEN \'CSTRING\'
WHEN 11 THEN \'D_FLOAT\'
WHEN 27 THEN \'DOUBLE\'
WHEN 10 THEN \'FLOAT\'
WHEN 16 THEN \'INT64\'
WHEN 8 THEN \'INTEGER\'
WHEN 9 THEN \'QUAD\'
WHEN 7 THEN \'SMALLINT\'
WHEN 12 THEN \'DATE\'
WHEN 13 THEN \'TIME\'
WHEN 35 THEN \'TIMESTAMP\'
WHEN 37 THEN \'VARCHAR\'
ELSE \'UNKNOWN\'
END AS field_type,
f.RDB$FIELD_SUB_TYPE AS field_subtype,
coll.RDB$COLLATION_NAME AS field_collation,
cset.RDB$CHARACTER_SET_NAME AS field_charset
FROM RDB$RELATION_FIELDS r
LEFT JOIN RDB$FIELDS f ON r.RDB$FIELD_SOURCE = f.RDB$FIELD_NAME
LEFT JOIN RDB$COLLATIONS coll ON f.RDB$COLLATION_ID = coll.RDB$COLLATION_ID
LEFT JOIN RDB$CHARACTER_SETS cset ON f.RDB$CHARACTER_SET_ID = cset.RDB$CHARACTER_SET_ID
WHERE r.RDB$RELATION_NAME = '.q($R).'
ORDER BY r.RDB$FIELD_POSITION';$H=ibase_query($f->_link,$G);while($J=ibase_fetch_assoc($H))$I[trim($J['FIELD_NAME'])]=array("field"=>trim($J["FIELD_NAME"]),"full_type"=>trim($J["FIELD_TYPE"]),"type"=>trim($J["FIELD_SUB_TYPE"]),"default"=>trim($J['FIELD_DEFAULT_VALUE']),"null"=>(trim($J["FIELD_NOT_NULL_CONSTRAINT"])=="YES"),"auto_increment"=>'0',"collation"=>trim($J["FIELD_COLLATION"]),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),"comment"=>trim($J["FIELD_DESCRIPTION"]),);return$I;}function
indexes($R,$g=null){$I=array();return$I;}function
foreign_keys($R){return
array();}function
collations(){return
array();}function
information_schema($l){return
false;}function
error(){global$f;return
h($f->error);}function
types(){return
array();}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($Rg){return
true;}function
support($Oc){return
preg_match("~^(columns|sql|status|table)$~",$Oc);}$x="firebird";$mf=array("=");$id=array();$od=array();$lc=array();}$dc["simpledb"]="SimpleDB";if(isset($_GET["simpledb"])){$Yf=array("SimpleXML + allow_url_fopen");define("DRIVER","simpledb");if(class_exists('SimpleXMLElement')&&ini_bool('allow_url_fopen')){class
Min_DB{var$extension="SimpleXML",$server_info='2009-04-15',$error,$timeout,$next,$affected_rows,$_result;function
select_db($j){return($j=="domain");}function
query($G,$ti=false){$Ff=array('SelectExpression'=>$G,'ConsistentRead'=>'true');if($this->next)$Ff['NextToken']=$this->next;$H=sdb_request_all('Select','Item',$Ff,$this->timeout);if($H===false)return$H;if(preg_match('~^\s*SELECT\s+COUNT\(~i',$G)){$Ah=0;foreach($H
as$Vd)$Ah+=$Vd->Attribute->Value;$H=array((object)array('Attribute'=>array((object)array('Name'=>'Count','Value'=>$Ah,))));}return
new
Min_Result($H);}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
quote($Q){return"'".str_replace("'","''",$Q)."'";}}class
Min_Result{var$num_rows,$_rows=array(),$_offset=0;function
__construct($H){foreach($H
as$Vd){$J=array();if($Vd->Name!='')$J['itemName()']=(string)$Vd->Name;foreach($Vd->Attribute
as$Ia){$C=$this->_processValue($Ia->Name);$Y=$this->_processValue($Ia->Value);if(isset($J[$C])){$J[$C]=(array)$J[$C];$J[$C][]=$Y;}else$J[$C]=$Y;}$this->_rows[]=$J;foreach($J
as$y=>$X){if(!isset($this->_rows[0][$y]))$this->_rows[0][$y]=null;}}$this->num_rows=count($this->_rows);}function
_processValue($oc){return(is_object($oc)&&$oc['encoding']=='base64'?base64_decode($oc):(string)$oc);}function
fetch_assoc(){$J=current($this->_rows);if(!$J)return$J;$I=array();foreach($this->_rows[0]as$y=>$X)$I[$y]=$J[$y];next($this->_rows);return$I;}function
fetch_row(){$I=$this->fetch_assoc();if(!$I)return$I;return
array_values($I);}function
fetch_field(){$be=array_keys($this->_rows[0]);return(object)array('name'=>$be[$this->_offset++]);}}}class
Min_Driver
extends
Min_SQL{public$bg="itemName()";function
_chunkRequest($_d,$va,$Ff,$Dc=array()){global$f;foreach(array_chunk($_d,25)as$hb){$Gf=$Ff;foreach($hb
as$s=>$t){$Gf["Item.$s.ItemName"]=$t;foreach($Dc
as$y=>$X)$Gf["Item.$s.$y"]=$X;}if(!sdb_request($va,$Gf))return
false;}$f->affected_rows=count($_d);return
true;}function
_extractIds($R,$ng,$z){$I=array();if(preg_match_all("~itemName\(\) = (('[^']*+')+)~",$ng,$xe))$I=array_map('idf_unescape',$xe[1]);else{foreach(sdb_request_all('Select','Item',array('SelectExpression'=>'SELECT itemName() FROM '.table($R).$ng.($z?" LIMIT 1":"")))as$Vd)$I[]=$Vd->Name;}return$I;}function
select($R,$L,$Z,$ld,$rf=array(),$z=1,$E=0,$dg=false){global$f;$f->next=$_GET["next"];$I=parent::select($R,$L,$Z,$ld,$rf,$z,$E,$dg);$f->next=0;return$I;}function
delete($R,$ng,$z=0){return$this->_chunkRequest($this->_extractIds($R,$ng,$z),'BatchDeleteAttributes',array('DomainName'=>$R));}function
update($R,$O,$ng,$z=0,$M="\n"){$Tb=array();$Nd=array();$s=0;$_d=$this->_extractIds($R,$ng,$z);$t=idf_unescape($O["`itemName()`"]);unset($O["`itemName()`"]);foreach($O
as$y=>$X){$y=idf_unescape($y);if($X=="NULL"||($t!=""&&array($t)!=$_d))$Tb["Attribute.".count($Tb).".Name"]=$y;if($X!="NULL"){foreach((array)$X
as$Xd=>$W){$Nd["Attribute.$s.Name"]=$y;$Nd["Attribute.$s.Value"]=(is_array($X)?$W:idf_unescape($W));if(!$Xd)$Nd["Attribute.$s.Replace"]="true";$s++;}}}$Ff=array('DomainName'=>$R);return(!$Nd||$this->_chunkRequest(($t!=""?array($t):$_d),'BatchPutAttributes',$Ff,$Nd))&&(!$Tb||$this->_chunkRequest($_d,'BatchDeleteAttributes',$Ff,$Tb));}function
insert($R,$O){$Ff=array("DomainName"=>$R);$s=0;foreach($O
as$C=>$Y){if($Y!="NULL"){$C=idf_unescape($C);if($C=="itemName()")$Ff["ItemName"]=idf_unescape($Y);else{foreach((array)$Y
as$X){$Ff["Attribute.$s.Name"]=$C;$Ff["Attribute.$s.Value"]=(is_array($Y)?$X:idf_unescape($Y));$s++;}}}}return
sdb_request('PutAttributes',$Ff);}function
insertUpdate($R,$K,$bg){foreach($K
as$O){if(!$this->update($R,$O,"WHERE `itemName()` = ".q($O["`itemName()`"])))return
false;}return
true;}function
begin(){return
false;}function
commit(){return
false;}function
rollback(){return
false;}}function
connect(){return
new
Min_DB;}function
support($Oc){return
preg_match('~sql~',$Oc);}function
logged_user(){global$b;$i=$b->credentials();return$i[1];}function
get_databases(){return
array("domain");}function
collations(){return
array();}function
db_collation($l,$pb){}function
tables_list(){global$f;$I=array();foreach(sdb_request_all('ListDomains','DomainName')as$R)$I[(string)$R]='table';if($f->error&&defined("PAGE_HEADER"))echo"<p class='error'>".error()."\n";return$I;}function
table_status($C="",$Nc=false){$I=array();foreach(($C!=""?array($C=>true):tables_list())as$R=>$U){$J=array("Name"=>$R,"Auto_increment"=>"");if(!$Nc){$Je=sdb_request('DomainMetadata',array('DomainName'=>$R));if($Je){foreach(array("Rows"=>"ItemCount","Data_length"=>"ItemNamesSizeBytes","Index_length"=>"AttributeValuesSizeBytes","Data_free"=>"AttributeNamesSizeBytes",)as$y=>$X)$J[$y]=(string)$Je->$X;}}if($C!="")return$J;$I[$R]=$J;}return$I;}function
explain($f,$G){}function
error(){global$f;return
h($f->error);}function
information_schema(){}function
is_view($S){}function
indexes($R,$g=null){return
array(array("type"=>"PRIMARY","columns"=>array("itemName()")),);}function
fields($R){return
fields_from_edit();}function
foreign_keys($R){return
array();}function
table($u){return
idf_escape($u);}function
idf_escape($u){return"`".str_replace("`","``",$u)."`";}function
limit($G,$Z,$z,$D=0,$M=" "){return" $G$Z".($z!==null?$M."LIMIT $z":"");}function
unconvert_field($o,$I){return$I;}function
fk_support($S){}function
engines(){return
array();}function
alter_table($R,$C,$p,$ad,$ub,$tc,$ob,$La,$Lf){return($R==""&&sdb_request('CreateDomain',array('DomainName'=>$C)));}function
drop_tables($T){foreach($T
as$R){if(!sdb_request('DeleteDomain',array('DomainName'=>$R)))return
false;}return
true;}function
count_tables($k){foreach($k
as$l)return
array($l=>count(tables_list()));}function
found_rows($S,$Z){return($Z?null:$S["Rows"]);}function
last_id(){}function
hmac($Ba,$Kb,$y,$rg=false){$Ua=64;if(strlen($y)>$Ua)$y=pack("H*",$Ba($y));$y=str_pad($y,$Ua,"\0");$Yd=$y^str_repeat("\x36",$Ua);$Zd=$y^str_repeat("\x5C",$Ua);$I=$Ba($Zd.pack("H*",$Ba($Yd.$Kb)));if($rg)$I=pack("H*",$I);return$I;}function
sdb_request($va,$Ff=array()){global$b,$f;list($xd,$Ff['AWSAccessKeyId'],$Ug)=$b->credentials();$Ff['Action']=$va;$Ff['Timestamp']=gmdate('Y-m-d\TH:i:s+00:00');$Ff['Version']='2009-04-15';$Ff['SignatureVersion']=2;$Ff['SignatureMethod']='HmacSHA1';ksort($Ff);$G='';foreach($Ff
as$y=>$X)$G.='&'.rawurlencode($y).'='.rawurlencode($X);$G=str_replace('%7E','~',substr($G,1));$G.="&Signature=".urlencode(base64_encode(hmac('sha1',"POST\n".preg_replace('~^https?://~','',$xd)."\n/\n$G",$Ug,true)));@ini_set('track_errors',1);$Sc=@file_get_contents((preg_match('~^https?://~',$xd)?$xd:"http://$xd"),false,stream_context_create(array('http'=>array('method'=>'POST','content'=>$G,'ignore_errors'=>1,))));if(!$Sc){$f->error=$php_errormsg;return
false;}libxml_use_internal_errors(true);$cj=simplexml_load_string($Sc);if(!$cj){$n=libxml_get_last_error();$f->error=$n->message;return
false;}if($cj->Errors){$n=$cj->Errors->Error;$f->error="$n->Message ($n->Code)";return
false;}$f->error='';$Lh=$va."Result";return($cj->$Lh?$cj->$Lh:true);}function
sdb_request_all($va,$Lh,$Ff=array(),$Uh=0){$I=array();$th=($Uh?microtime(true):0);$z=(preg_match('~LIMIT\s+(\d+)\s*$~i',$Ff['SelectExpression'],$B)?$B[1]:0);do{$cj=sdb_request($va,$Ff);if(!$cj)break;foreach($cj->$Lh
as$oc)$I[]=$oc;if($z&&count($I)>=$z){$_GET["next"]=$cj->NextToken;break;}if($Uh&&microtime(true)-$th>$Uh)return
false;$Ff['NextToken']=$cj->NextToken;if($z)$Ff['SelectExpression']=preg_replace('~\d+\s*$~',$z-count($I),$Ff['SelectExpression']);}while($cj->NextToken);return$I;}$x="simpledb";$mf=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","IS NOT NULL");$id=array();$od=array("count");$lc=array(array("json"));}$dc["mongo"]="MongoDB";if(isset($_GET["mongo"])){$Yf=array("mongo","mongodb");define("DRIVER","mongo");if(class_exists('MongoDB')){class
Min_DB{var$extension="Mongo",$error,$last_id,$_link,$_db;function
connect($N,$V,$F){global$b;$l=$b->database();$pf=array();if($V!=""){$pf["username"]=$V;$pf["password"]=$F;}if($l!="")$pf["db"]=$l;try{$this->_link=@new
MongoClient("mongodb://$N",$pf);return
true;}catch(Exception$_c){$this->error=$_c->getMessage();return
false;}}function
query($G){return
false;}function
select_db($j){try{$this->_db=$this->_link->selectDB($j);return
true;}catch(Exception$_c){$this->error=$_c->getMessage();return
false;}}function
quote($Q){return$Q;}}class
Min_Result{var$num_rows,$_rows=array(),$_offset=0,$_charset=array();function
__construct($H){foreach($H
as$Vd){$J=array();foreach($Vd
as$y=>$X){if(is_a($X,'MongoBinData'))$this->_charset[$y]=63;$J[$y]=(is_a($X,'MongoId')?'ObjectId("'.strval($X).'")':(is_a($X,'MongoDate')?gmdate("Y-m-d H:i:s",$X->sec)." GMT":(is_a($X,'MongoBinData')?$X->bin:(is_a($X,'MongoRegex')?strval($X):(is_object($X)?get_class($X):$X)))));}$this->_rows[]=$J;foreach($J
as$y=>$X){if(!isset($this->_rows[0][$y]))$this->_rows[0][$y]=null;}}$this->num_rows=count($this->_rows);}function
fetch_assoc(){$J=current($this->_rows);if(!$J)return$J;$I=array();foreach($this->_rows[0]as$y=>$X)$I[$y]=$J[$y];next($this->_rows);return$I;}function
fetch_row(){$I=$this->fetch_assoc();if(!$I)return$I;return
array_values($I);}function
fetch_field(){$be=array_keys($this->_rows[0]);$C=$be[$this->_offset++];return(object)array('name'=>$C,'charsetnr'=>$this->_charset[$C],);}}class
Min_Driver
extends
Min_SQL{public$bg="_id";function
select($R,$L,$Z,$ld,$rf=array(),$z=1,$E=0,$dg=false){$L=($L==array("*")?array():array_fill_keys($L,true));$kh=array();foreach($rf
as$X){$X=preg_replace('~ DESC$~','',$X,1,$Db);$kh[$X]=($Db?-1:1);}return
new
Min_Result($this->_conn->_db->selectCollection($R)->find(array(),$L)->sort($kh)->limit($z!=""?+$z:0)->skip($E*$z));}function
insert($R,$O){try{$I=$this->_conn->_db->selectCollection($R)->insert($O);$this->_conn->errno=$I['code'];$this->_conn->error=$I['err'];$this->_conn->last_id=$O['_id'];return!$I['err'];}catch(Exception$_c){$this->_conn->error=$_c->getMessage();return
false;}}}function
get_databases($Zc){global$f;$I=array();$Pb=$f->_link->listDBs();foreach($Pb['databases']as$l)$I[]=$l['name'];return$I;}function
count_tables($k){global$f;$I=array();foreach($k
as$l)$I[$l]=count($f->_link->selectDB($l)->getCollectionNames(true));return$I;}function
tables_list(){global$f;return
array_fill_keys($f->_db->getCollectionNames(true),'table');}function
drop_databases($k){global$f;foreach($k
as$l){$Dg=$f->_link->selectDB($l)->drop();if(!$Dg['ok'])return
false;}return
true;}function
indexes($R,$g=null){global$f;$I=array();foreach($f->_db->selectCollection($R)->getIndexInfo()as$v){$Wb=array();foreach($v["key"]as$d=>$U)$Wb[]=($U==-1?'1':null);$I[$v["name"]]=array("type"=>($v["name"]=="_id_"?"PRIMARY":($v["unique"]?"UNIQUE":"INDEX")),"columns"=>array_keys($v["key"]),"lengths"=>array(),"descs"=>$Wb,);}return$I;}function
fields($R){return
fields_from_edit();}function
found_rows($S,$Z){global$f;return$f->_db->selectCollection($_GET["select"])->count($Z);}$mf=array("=");}elseif(class_exists('MongoDB\Driver\Manager')){class
Min_DB{var$extension="MongoDB",$error,$last_id;var$_link;var$_db,$_db_name;function
connect($N,$V,$F){global$b;$l=$b->database();$pf=array();if($V!=""){$pf["username"]=$V;$pf["password"]=$F;}if($l!="")$pf["db"]=$l;try{$jb='MongoDB\Driver\Manager';$this->_link=new$jb("mongodb://$N",$pf);return
true;}catch(Exception$_c){$this->error=$_c->getMessage();return
false;}}function
query($G){return
false;}function
select_db($j){try{$this->_db_name=$j;return
true;}catch(Exception$_c){$this->error=$_c->getMessage();return
false;}}function
quote($Q){return$Q;}}class
Min_Result{var$num_rows,$_rows=array(),$_offset=0,$_charset=array();function
__construct($H){foreach($H
as$Vd){$J=array();foreach($Vd
as$y=>$X){if(is_a($X,'MongoDB\BSON\Binary'))$this->_charset[$y]=63;$J[$y]=(is_a($X,'MongoDB\BSON\ObjectID')?'MongoDB\BSON\ObjectID("'.strval($X).'")':(is_a($X,'MongoDB\BSON\UTCDatetime')?$X->toDateTime()->format('Y-m-d H:i:s'):(is_a($X,'MongoDB\BSON\Binary')?$X->bin:(is_a($X,'MongoDB\BSON\Regex')?strval($X):(is_object($X)?json_encode($X,256):$X)))));}$this->_rows[]=$J;foreach($J
as$y=>$X){if(!isset($this->_rows[0][$y]))$this->_rows[0][$y]=null;}}$this->num_rows=$H->count;}function
fetch_assoc(){$J=current($this->_rows);if(!$J)return$J;$I=array();foreach($this->_rows[0]as$y=>$X)$I[$y]=$J[$y];next($this->_rows);return$I;}function
fetch_row(){$I=$this->fetch_assoc();if(!$I)return$I;return
array_values($I);}function
fetch_field(){$be=array_keys($this->_rows[0]);$C=$be[$this->_offset++];return(object)array('name'=>$C,'charsetnr'=>$this->_charset[$C],);}}class
Min_Driver
extends
Min_SQL{public$bg="_id";function
select($R,$L,$Z,$ld,$rf=array(),$z=1,$E=0,$dg=false){global$f;$L=($L==array("*")?array():array_fill_keys($L,1));if(count($L)&&!isset($L['_id']))$L['_id']=0;$Z=where_to_query($Z);$kh=array();foreach($rf
as$X){$X=preg_replace('~ DESC$~','',$X,1,$Db);$kh[$X]=($Db?-1:1);}if(isset($_GET['limit'])&&is_numeric($_GET['limit'])&&$_GET['limit']>0)$z=$_GET['limit'];$z=min(200,max(1,(int)$z));$ih=$E*$z;$jb='MongoDB\Driver\Query';$G=new$jb($Z,array('projection'=>$L,'limit'=>$z,'skip'=>$ih,'sort'=>$kh));$Gg=$f->_link->executeQuery("$f->_db_name.$R",$G);return
new
Min_Result($Gg);}function
update($R,$O,$ng,$z=0,$M="\n"){global$f;$l=$f->_db_name;$Z=sql_query_where_parser($ng);$jb='MongoDB\Driver\BulkWrite';$Ya=new$jb(array());if(isset($O['_id']))unset($O['_id']);$Ag=array();foreach($O
as$y=>$Y){if($Y=='NULL'){$Ag[$y]=1;unset($O[$y]);}}$_i=array('$set'=>$O);if(count($Ag))$_i['$unset']=$Ag;$Ya->update($Z,$_i,array('upsert'=>false));$Gg=$f->_link->executeBulkWrite("$l.$R",$Ya);$f->affected_rows=$Gg->getModifiedCount();return
true;}function
delete($R,$ng,$z=0){global$f;$l=$f->_db_name;$Z=sql_query_where_parser($ng);$jb='MongoDB\Driver\BulkWrite';$Ya=new$jb(array());$Ya->delete($Z,array('limit'=>$z));$Gg=$f->_link->executeBulkWrite("$l.$R",$Ya);$f->affected_rows=$Gg->getDeletedCount();return
true;}function
insert($R,$O){global$f;$l=$f->_db_name;$jb='MongoDB\Driver\BulkWrite';$Ya=new$jb(array());if(isset($O['_id'])&&empty($O['_id']))unset($O['_id']);$Ya->insert($O);$Gg=$f->_link->executeBulkWrite("$l.$R",$Ya);$f->affected_rows=$Gg->getInsertedCount();return
true;}}function
get_databases($Zc){global$f;$I=array();$jb='MongoDB\Driver\Command';$sb=new$jb(array('listDatabases'=>1));$Gg=$f->_link->executeCommand('admin',$sb);foreach($Gg
as$Pb){foreach($Pb->databases
as$l)$I[]=$l->name;}return$I;}function
count_tables($k){$I=array();return$I;}function
tables_list(){global$f;$jb='MongoDB\Driver\Command';$sb=new$jb(array('listCollections'=>1));$Gg=$f->_link->executeCommand($f->_db_name,$sb);$qb=array();foreach($Gg
as$H)$qb[$H->name]='table';return$qb;}function
drop_databases($k){return
false;}function
indexes($R,$g=null){global$f;$I=array();$jb='MongoDB\Driver\Command';$sb=new$jb(array('listIndexes'=>$R));$Gg=$f->_link->executeCommand($f->_db_name,$sb);foreach($Gg
as$v){$Wb=array();$e=array();foreach(get_object_vars($v->key)as$d=>$U){$Wb[]=($U==-1?'1':null);$e[]=$d;}$I[$v->name]=array("type"=>($v->name=="_id_"?"PRIMARY":(isset($v->unique)?"UNIQUE":"INDEX")),"columns"=>$e,"lengths"=>array(),"descs"=>$Wb,);}return$I;}function
fields($R){$p=fields_from_edit();if(!count($p)){global$m;$H=$m->select($R,array("*"),null,null,array(),10);while($J=$H->fetch_assoc()){foreach($J
as$y=>$X){$J[$y]=null;$p[$y]=array("field"=>$y,"type"=>"string","null"=>($y!=$m->primary),"auto_increment"=>($y==$m->primary),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1,),);}}}return$p;}function
found_rows($S,$Z){global$f;$Z=where_to_query($Z);$jb='MongoDB\Driver\Command';$sb=new$jb(array('count'=>$S['Name'],'query'=>$Z));$Gg=$f->_link->executeCommand($f->_db_name,$sb);$ci=$Gg->toArray();return$ci[0]->n;}function
sql_query_where_parser($ng){$ng=trim(preg_replace('/WHERE[\s]?[(]?\(?/','',$ng));$ng=preg_replace('/\)\)\)$/',')',$ng);$Zi=explode(' AND ',$ng);$aj=explode(') OR (',$ng);$Z=array();foreach($Zi
as$Xi)$Z[]=trim($Xi);if(count($aj)==1)$aj=array();elseif(count($aj)>1)$Z=array();return
where_to_query($Z,$aj);}function
where_to_query($Vi=array(),$Wi=array()){global$mf;$Kb=array();foreach(array('and'=>$Vi,'or'=>$Wi)as$U=>$Z){if(is_array($Z)){foreach($Z
as$Gc){list($mb,$kf,$X)=explode(" ",$Gc,3);if($mb=="_id"){$X=str_replace('MongoDB\BSON\ObjectID("',"",$X);$X=str_replace('")',"",$X);$jb='MongoDB\BSON\ObjectID';$X=new$jb($X);}if(!in_array($kf,$mf))continue;if(preg_match('~^\(f\)(.+)~',$kf,$B)){$X=(float)$X;$kf=$B[1];}elseif(preg_match('~^\(date\)(.+)~',$kf,$B)){$Mb=new
DateTime($X);$jb='MongoDB\BSON\UTCDatetime';$X=new$jb($Mb->getTimestamp()*1000);$kf=$B[1];}switch($kf){case'=':$kf='$eq';break;case'!=':$kf='$ne';break;case'>':$kf='$gt';break;case'<':$kf='$lt';break;case'>=':$kf='$gte';break;case'<=':$kf='$lte';break;case'regex':$kf='$regex';break;default:continue;}if($U=='and')$Kb['$and'][]=array($mb=>array($kf=>$X));elseif($U=='or')$Kb['$or'][]=array($mb=>array($kf=>$X));}}}return$Kb;}$mf=array("=","!=",">","<",">=","<=","regex","(f)=","(f)!=","(f)>","(f)<","(f)>=","(f)<=","(date)=","(date)!=","(date)>","(date)<","(date)>=","(date)<=",);}function
table($u){return$u;}function
idf_escape($u){return$u;}function
table_status($C="",$Nc=false){$I=array();foreach(tables_list()as$R=>$U){$I[$R]=array("Name"=>$R);if($C==$R)return$I[$R];}return$I;}function
last_id(){global$f;return$f->last_id;}function
error(){global$f;return
h($f->error);}function
collations(){return
array();}function
logged_user(){global$b;$i=$b->credentials();return$i[1];}function
connect(){global$b;$f=new
Min_DB;$i=$b->credentials();if($f->connect($i[0],$i[1],$i[2]))return$f;return$f->error;}function
alter_indexes($R,$c){global$f;foreach($c
as$X){list($U,$C,$O)=$X;if($O=="DROP")$I=$f->_db->command(array("deleteIndexes"=>$R,"index"=>$C));else{$e=array();foreach($O
as$d){$d=preg_replace('~ DESC$~','',$d,1,$Db);$e[$d]=($Db?-1:1);}$I=$f->_db->selectCollection($R)->ensureIndex($e,array("unique"=>($U=="UNIQUE"),"name"=>$C,));}if($I['errmsg']){$f->error=$I['errmsg'];return
false;}}return
true;}function
support($Oc){return
preg_match("~database|indexes~",$Oc);}function
db_collation($l,$pb){}function
information_schema(){}function
is_view($S){}function
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
foreign_keys($R){return
array();}function
fk_support($S){}function
engines(){return
array();}function
alter_table($R,$C,$p,$ad,$ub,$tc,$ob,$La,$Lf){global$f;if($R==""){$f->_db->createCollection($C);return
true;}}function
drop_tables($T){global$f;foreach($T
as$R){$Dg=$f->_db->selectCollection($R)->drop();if(!$Dg['ok'])return
false;}return
true;}function
truncate_tables($T){global$f;foreach($T
as$R){$Dg=$f->_db->selectCollection($R)->remove();if(!$Dg['ok'])return
false;}return
true;}$x="mongo";$id=array();$od=array();$lc=array(array("json"));}$dc["elastic"]="Elasticsearch (beta)";if(isset($_GET["elastic"])){$Yf=array("json");define("DRIVER","elastic");if(function_exists('json_decode')){class
Min_DB{var$extension="JSON",$server_info,$errno,$error,$_url;function
rootQuery($Pf,$zb=array(),$Ke='GET'){@ini_set('track_errors',1);$Sc=@file_get_contents("$this->_url/".ltrim($Pf,'/'),false,stream_context_create(array('http'=>array('method'=>$Ke,'content'=>$zb===null?$zb:json_encode($zb),'header'=>'Content-Type: application/json','ignore_errors'=>1,))));if(!$Sc){$this->error=$php_errormsg;return$Sc;}if(!preg_match('~^HTTP/[0-9.]+ 2~i',$http_response_header[0])){$this->error=$Sc;return
false;}$I=json_decode($Sc,true);if($I===null){$this->errno=json_last_error();if(function_exists('json_last_error_msg'))$this->error=json_last_error_msg();else{$yb=get_defined_constants(true);foreach($yb['json']as$C=>$Y){if($Y==$this->errno&&preg_match('~^JSON_ERROR_~',$C)){$this->error=$C;break;}}}}return$I;}function
query($Pf,$zb=array(),$Ke='GET'){return$this->rootQuery(($this->_db!=""?"$this->_db/":"/").ltrim($Pf,'/'),$zb,$Ke);}function
connect($N,$V,$F){preg_match('~^(https?://)?(.*)~',$N,$B);$this->_url=($B[1]?$B[1]:"http://")."$V:$F@$B[2]";$I=$this->query('');if($I)$this->server_info=$I['version']['number'];return(bool)$I;}function
select_db($j){$this->_db=$j;return
true;}function
quote($Q){return$Q;}}class
Min_Result{var$num_rows,$_rows;function
__construct($K){$this->num_rows=count($this->_rows);$this->_rows=$K;reset($this->_rows);}function
fetch_assoc(){$I=current($this->_rows);next($this->_rows);return$I;}function
fetch_row(){return
array_values($this->fetch_assoc());}}}class
Min_Driver
extends
Min_SQL{function
select($R,$L,$Z,$ld,$rf=array(),$z=1,$E=0,$dg=false){global$b;$Kb=array();$G="$R/_search";if($L!=array("*"))$Kb["fields"]=$L;if($rf){$kh=array();foreach($rf
as$mb){$mb=preg_replace('~ DESC$~','',$mb,1,$Db);$kh[]=($Db?array($mb=>"desc"):$mb);}$Kb["sort"]=$kh;}if($z){$Kb["size"]=+$z;if($E)$Kb["from"]=($E*$z);}foreach($Z
as$X){list($mb,$kf,$X)=explode(" ",$X,3);if($mb=="_id")$Kb["query"]["ids"]["values"][]=$X;elseif($mb.$X!=""){$Ph=array("term"=>array(($mb!=""?$mb:"_all")=>$X));if($kf=="=")$Kb["query"]["filtered"]["filter"]["and"][]=$Ph;else$Kb["query"]["filtered"]["query"]["bool"]["must"][]=$Ph;}}if($Kb["query"]&&!$Kb["query"]["filtered"]["query"]&&!$Kb["query"]["ids"])$Kb["query"]["filtered"]["query"]=array("match_all"=>array());$th=microtime(true);$Tg=$this->_conn->query($G,$Kb);if($dg)echo$b->selectQuery("$G: ".print_r($Kb,true),$th,!$Tg);if(!$Tg)return
false;$I=array();foreach($Tg['hits']['hits']as$wd){$J=array();if($L==array("*"))$J["_id"]=$wd["_id"];$p=$wd['_source'];if($L!=array("*")){$p=array();foreach($L
as$y)$p[$y]=$wd['fields'][$y];}foreach($p
as$y=>$X){if($Kb["fields"])$X=$X[0];$J[$y]=(is_array($X)?json_encode($X):$X);}$I[]=$J;}return
new
Min_Result($I);}function
update($U,$sg,$ng){$Nf=preg_split('~ *= *~',$ng);if(count($Nf)==2){$t=trim($Nf[1]);$G="$U/$t";return$this->_conn->query($G,$sg,'POST');}return
false;}function
insert($U,$sg){$t="";$G="$U/$t";$Dg=$this->_conn->query($G,$sg,'POST');$this->_conn->last_id=$Dg['_id'];return$Dg['created'];}function
delete($U,$ng){$_d=array();if(is_array($_GET["where"])&&$_GET["where"]["_id"])$_d[]=$_GET["where"]["_id"];if(is_array($_POST['check'])){foreach($_POST['check']as$cb){$Nf=preg_split('~ *= *~',$cb);if(count($Nf)==2)$_d[]=trim($Nf[1]);}}$this->_conn->affected_rows=0;foreach($_d
as$t){$G="{$U}/{$t}";$Dg=$this->_conn->query($G,'{}','DELETE');if(is_array($Dg)&&$Dg['found']==true)$this->_conn->affected_rows++;}return$this->_conn->affected_rows;}}function
connect(){global$b;$f=new
Min_DB;$i=$b->credentials();if($f->connect($i[0],$i[1],$i[2]))return$f;return$f->error;}function
support($Oc){return
preg_match("~database|table|columns~",$Oc);}function
logged_user(){global$b;$i=$b->credentials();return$i[1];}function
get_databases(){global$f;$I=$f->rootQuery('_aliases');if($I){$I=array_keys($I);sort($I,SORT_STRING);}return$I;}function
collations(){return
array();}function
db_collation($l,$pb){}function
engines(){return
array();}function
count_tables($k){global$f;$I=array();$H=$f->query('_stats');if($H&&$H['indices']){$Gd=$H['indices'];foreach($Gd
as$Fd=>$uh){$Ed=$uh['total']['indexing'];$I[$Fd]=$Ed['index_total'];}}return$I;}function
tables_list(){global$f;$I=$f->query('_mapping');if($I)$I=array_fill_keys(array_keys($I[$f->_db]["mappings"]),'table');return$I;}function
table_status($C="",$Nc=false){global$f;$Tg=$f->query("_search",array("size"=>0,"aggregations"=>array("count_by_type"=>array("terms"=>array("field"=>"_type")))),"POST");$I=array();if($Tg){$T=$Tg["aggregations"]["count_by_type"]["buckets"];foreach($T
as$R){$I[$R["key"]]=array("Name"=>$R["key"],"Engine"=>"table","Rows"=>$R["doc_count"],);if($C!=""&&$C==$R["key"])return$I[$C];}}return$I;}function
error(){global$f;return
h($f->error);}function
information_schema(){}function
is_view($S){}function
indexes($R,$g=null){return
array(array("type"=>"PRIMARY","columns"=>array("_id")),);}function
fields($R){global$f;$H=$f->query("$R/_mapping");$I=array();if($H){$te=$H[$R]['properties'];if(!$te)$te=$H[$f->_db]['mappings'][$R]['properties'];if($te){foreach($te
as$C=>$o){$I[$C]=array("field"=>$C,"full_type"=>$o["type"],"type"=>$o["type"],"privileges"=>array("insert"=>1,"select"=>1,"update"=>1),);if($o["properties"]){unset($I[$C]["privileges"]["insert"]);unset($I[$C]["privileges"]["update"]);}}}}return$I;}function
foreign_keys($R){return
array();}function
table($u){return$u;}function
idf_escape($u){return$u;}function
convert_field($o){}function
unconvert_field($o,$I){return$I;}function
fk_support($S){}function
found_rows($S,$Z){return
null;}function
create_database($l){global$f;return$f->rootQuery(urlencode($l),null,'PUT');}function
drop_databases($k){global$f;return$f->rootQuery(urlencode(implode(',',$k)),array(),'DELETE');}function
alter_table($R,$C,$p,$ad,$ub,$tc,$ob,$La,$Lf){global$f;$jg=array();foreach($p
as$Lc){$Qc=trim($Lc[1][0]);$Rc=trim($Lc[1][1]?$Lc[1][1]:"text");$jg[$Qc]=array('type'=>$Rc);}if(!empty($jg))$jg=array('properties'=>$jg);return$f->query("_mapping/{$C}",$jg,'PUT');}function
drop_tables($T){global$f;$I=true;foreach($T
as$R)$I=$I&&$f->query(urlencode($R),array(),'DELETE');return$I;}function
last_id(){global$f;return$f->last_id;}$x="elastic";$mf=array("=","query");$id=array();$od=array();$lc=array(array("json"));$si=array();$xh=array();foreach(array('æ•¸å­—'=>array("long"=>3,"integer"=>5,"short"=>8,"byte"=>10,"double"=>20,"float"=>66,"half_float"=>12,"scaled_float"=>21),'æ—¥æœŸæ™‚é–“'=>array("date"=>10),'å­—ä¸²'=>array("string"=>65535,"text"=>65535),'äºŒé€²ä½'=>array("binary"=>255),)as$y=>$X){$si+=$X;$xh[$y]=array_keys($X);}}$dc=array("server"=>"MySQL")+$dc;if(!defined("DRIVER")){$Yf=array("MySQLi","MySQL","PDO_MySQL");define("DRIVER","server");if(extension_loaded("mysqli")){class
Min_DB
extends
MySQLi{var$extension="MySQLi";function
__construct(){parent::init();}function
connect($N="",$V="",$F="",$j=null,$Uf=null,$jh=null){global$b;mysqli_report(MYSQLI_REPORT_OFF);list($xd,$Uf)=explode(":",$N,2);$sh=$b->connectSsl();if($sh)$this->ssl_set($sh['key'],$sh['cert'],$sh['ca'],'','');$I=@$this->real_connect(($N!=""?$xd:ini_get("mysqli.default_host")),($N.$V!=""?$V:ini_get("mysqli.default_user")),($N.$V.$F!=""?$F:ini_get("mysqli.default_pw")),$j,(is_numeric($Uf)?$Uf:ini_get("mysqli.default_port")),(!is_numeric($Uf)?$Uf:$jh),($sh?64:0));return$I;}function
set_charset($bb){if(parent::set_charset($bb))return
true;parent::set_charset('utf8');return$this->query("SET NAMES $bb");}function
result($G,$o=0){$H=$this->query($G);if(!$H)return
false;$J=$H->fetch_array();return$J[$o];}function
quote($Q){return"'".$this->escape_string($Q)."'";}}}elseif(extension_loaded("mysql")&&!(ini_get("sql.safe_mode")&&extension_loaded("pdo_mysql"))){class
Min_DB{var$extension="MySQL",$server_info,$affected_rows,$errno,$error,$_link,$_result;function
connect($N,$V,$F){$this->_link=@mysql_connect(($N!=""?$N:ini_get("mysql.default_host")),("$N$V"!=""?$V:ini_get("mysql.default_user")),("$N$V$F"!=""?$F:ini_get("mysql.default_password")),true,131072);if($this->_link)$this->server_info=mysql_get_server_info($this->_link);else$this->error=mysql_error();return(bool)$this->_link;}function
set_charset($bb){if(function_exists('mysql_set_charset')){if(mysql_set_charset($bb,$this->_link))return
true;mysql_set_charset('utf8',$this->_link);}return$this->query("SET NAMES $bb");}function
quote($Q){return"'".mysql_real_escape_string($Q,$this->_link)."'";}function
select_db($j){return
mysql_select_db($j,$this->_link);}function
query($G,$ti=false){$H=@($ti?mysql_unbuffered_query($G,$this->_link):mysql_query($G,$this->_link));$this->error="";if(!$H){$this->errno=mysql_errno($this->_link);$this->error=mysql_error($this->_link);return
false;}if($H===true){$this->affected_rows=mysql_affected_rows($this->_link);$this->info=mysql_info($this->_link);return
true;}return
new
Min_Result($H);}function
multi_query($G){return$this->_result=$this->query($G);}function
store_result(){return$this->_result;}function
next_result(){return
false;}function
result($G,$o=0){$H=$this->query($G);if(!$H||!$H->num_rows)return
false;return
mysql_result($H->_result,0,$o);}}class
Min_Result{var$num_rows,$_result,$_offset=0;function
__construct($H){$this->_result=$H;$this->num_rows=mysql_num_rows($H);}function
fetch_assoc(){return
mysql_fetch_assoc($this->_result);}function
fetch_row(){return
mysql_fetch_row($this->_result);}function
fetch_field(){$I=mysql_fetch_field($this->_result,$this->_offset++);$I->orgtable=$I->table;$I->orgname=$I->name;$I->charsetnr=($I->blob?63:0);return$I;}function
__destruct(){mysql_free_result($this->_result);}}}elseif(extension_loaded("pdo_mysql")){class
Min_DB
extends
Min_PDO{var$extension="PDO_MySQL";function
connect($N,$V,$F){global$b;$pf=array();$sh=$b->connectSsl();if($sh)$pf=array(PDO::MYSQL_ATTR_SSL_KEY=>$sh['key'],PDO::MYSQL_ATTR_SSL_CERT=>$sh['cert'],PDO::MYSQL_ATTR_SSL_CA=>$sh['ca'],);$this->dsn("mysql:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\\d)~',';port=\\1',$N)),$V,$F,$pf);return
true;}function
set_charset($bb){$this->query("SET NAMES $bb");}function
select_db($j){return$this->query("USE ".idf_escape($j));}function
query($G,$ti=false){$this->setAttribute(1000,!$ti);return
parent::query($G,$ti);}}}class
Min_Driver
extends
Min_SQL{function
insert($R,$O){return($O?parent::insert($R,$O):queries("INSERT INTO ".table($R)." ()\nVALUES ()"));}function
insertUpdate($R,$K,$bg){$e=array_keys(reset($K));$Zf="INSERT INTO ".table($R)." (".implode(", ",$e).") VALUES\n";$Ki=array();foreach($e
as$y)$Ki[$y]="$y = VALUES($y)";$_h="\nON DUPLICATE KEY UPDATE ".implode(", ",$Ki);$Ki=array();$ne=0;foreach($K
as$O){$Y="(".implode(", ",$O).")";if($Ki&&(strlen($Zf)+$ne+strlen($Y)+strlen($_h)>1e6)){if(!queries($Zf.implode(",\n",$Ki).$_h))return
false;$Ki=array();$ne=0;}$Ki[]=$Y;$ne+=strlen($Y)+2;}return
queries($Zf.implode(",\n",$Ki).$_h);}function
convertSearch($u,$X,$o){return(preg_match('~char|text|enum|set~',$o["type"])&&!preg_match("~^utf8~",$o["collation"])?"CONVERT($u USING ".charset($this->_conn).")":$u);}function
warnings(){$H=$this->_conn->query("SHOW WARNINGS");if($H&&$H->num_rows){ob_start();select($H);return
ob_get_clean();}}function
tableHelp($C){$ue=preg_match('~MariaDB~',$this->_conn->server_info);if(information_schema(DB))return
strtolower(($ue?"information-schema-$C-table/":str_replace("_","-",$C)."-table.html"));if(DB=="mysql")return($ue?"mysql$C-table/":"system-database.html");}}function
idf_escape($u){return"`".str_replace("`","``",$u)."`";}function
table($u){return
idf_escape($u);}function
connect(){global$b,$si,$xh;$f=new
Min_DB;$i=$b->credentials();if($f->connect($i[0],$i[1],$i[2])){$f->set_charset(charset($f));$f->query("SET sql_quote_show_create = 1, autocommit = 1");if(min_version('5.7.8',10.2,$f)){$xh['å­—ä¸²'][]="json";$si["json"]=4294967295;}return$f;}$I=$f->error;if(function_exists('iconv')&&!is_utf8($I)&&strlen($Pg=iconv("windows-1250","utf-8",$I))>strlen($I))$I=$Pg;return$I;}function
get_databases($Zc){$I=get_session("dbs");if($I===null){$G=(min_version(5)?"SELECT SCHEMA_NAME FROM information_schema.SCHEMATA":"SHOW DATABASES");$I=($Zc?slow_query($G):get_vals($G));restart_session();set_session("dbs",$I);stop_session();}return$I;}function
limit($G,$Z,$z,$D=0,$M=" "){return" $G$Z".($z!==null?$M."LIMIT $z".($D?" OFFSET $D":""):"");}function
limit1($R,$G,$Z,$M="\n"){return
limit($G,$Z,1,0,$M);}function
db_collation($l,$pb){global$f;$I=null;$h=$f->result("SHOW CREATE DATABASE ".idf_escape($l),1);if(preg_match('~ COLLATE ([^ ]+)~',$h,$B))$I=$B[1];elseif(preg_match('~ CHARACTER SET ([^ ]+)~',$h,$B))$I=$pb[$B[1]][-1];return$I;}function
engines(){$I=array();foreach(get_rows("SHOW ENGINES")as$J){if(preg_match("~YES|DEFAULT~",$J["Support"]))$I[]=$J["Engine"];}return$I;}function
logged_user(){global$f;return$f->result("SELECT USER()");}function
tables_list(){return
get_key_vals(min_version(5)?"SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME":"SHOW TABLES");}function
count_tables($k){$I=array();foreach($k
as$l)$I[$l]=count(get_vals("SHOW TABLES IN ".idf_escape($l)));return$I;}function
table_status($C="",$Nc=false){$I=array();foreach(get_rows($Nc&&min_version(5)?"SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ".($C!=""?"AND TABLE_NAME = ".q($C):"ORDER BY Name"):"SHOW TABLE STATUS".($C!=""?" LIKE ".q(addcslashes($C,"%_\\")):""))as$J){if($J["Engine"]=="InnoDB")$J["Comment"]=preg_replace('~(?:(.+); )?InnoDB free: .*~','\\1',$J["Comment"]);if(!isset($J["Engine"]))$J["Comment"]="";if($C!="")return$J;$I[$J["Name"]]=$J;}return$I;}function
is_view($S){return$S["Engine"]===null;}function
fk_support($S){return
preg_match('~InnoDB|IBMDB2I~i',$S["Engine"])||(preg_match('~NDB~i',$S["Engine"])&&min_version(5.6));}function
fields($R){$I=array();foreach(get_rows("SHOW FULL COLUMNS FROM ".table($R))as$J){preg_match('~^([^( ]+)(?:\\((.+)\\))?( unsigned)?( zerofill)?$~',$J["Type"],$B);$I[$J["Field"]]=array("field"=>$J["Field"],"full_type"=>$J["Type"],"type"=>$B[1],"length"=>$B[2],"unsigned"=>ltrim($B[3].$B[4]),"default"=>($J["Default"]!=""||preg_match("~char|set~",$B[1])?$J["Default"]:null),"null"=>($J["Null"]=="YES"),"auto_increment"=>($J["Extra"]=="auto_increment"),"on_update"=>(preg_match('~^on update (.+)~i',$J["Extra"],$B)?$B[1]:""),"collation"=>$J["Collation"],"privileges"=>array_flip(preg_split('~, *~',$J["Privileges"])),"comment"=>$J["Comment"],"primary"=>($J["Key"]=="PRI"),);}return$I;}function
indexes($R,$g=null){$I=array();foreach(get_rows("SHOW INDEX FROM ".table($R),$g)as$J){$C=$J["Key_name"];$I[$C]["type"]=($C=="PRIMARY"?"PRIMARY":($J["Index_type"]=="FULLTEXT"?"FULLTEXT":($J["Non_unique"]?($J["Index_type"]=="SPATIAL"?"SPATIAL":"INDEX"):"UNIQUE")));$I[$C]["columns"][]=$J["Column_name"];$I[$C]["lengths"][]=($J["Index_type"]=="SPATIAL"?null:$J["Sub_part"]);$I[$C]["descs"][]=null;}return$I;}function
foreign_keys($R){global$f,$hf;static$Rf='`(?:[^`]|``)+`';$I=array();$Eb=$f->result("SHOW CREATE TABLE ".table($R),1);if($Eb){preg_match_all("~CONSTRAINT ($Rf) FOREIGN KEY ?\\(((?:$Rf,? ?)+)\\) REFERENCES ($Rf)(?:\\.($Rf))? \\(((?:$Rf,? ?)+)\\)(?: ON DELETE ($hf))?(?: ON UPDATE ($hf))?~",$Eb,$xe,PREG_SET_ORDER);foreach($xe
as$B){preg_match_all("~$Rf~",$B[2],$lh);preg_match_all("~$Rf~",$B[5],$Mh);$I[idf_unescape($B[1])]=array("db"=>idf_unescape($B[4]!=""?$B[3]:$B[4]),"table"=>idf_unescape($B[4]!=""?$B[4]:$B[3]),"source"=>array_map('idf_unescape',$lh[0]),"target"=>array_map('idf_unescape',$Mh[0]),"on_delete"=>($B[6]?$B[6]:"RESTRICT"),"on_update"=>($B[7]?$B[7]:"RESTRICT"),);}}return$I;}function
adm_view($C){global$f;return
array("select"=>preg_replace('~^(?:[^`]|`[^`]*`)*\\s+AS\\s+~isU','',$f->result("SHOW CREATE VIEW ".table($C),1)));}function
collations(){$I=array();foreach(get_rows("SHOW COLLATION")as$J){if($J["Default"])$I[$J["Charset"]][-1]=$J["Collation"];else$I[$J["Charset"]][]=$J["Collation"];}ksort($I);foreach($I
as$y=>$X)asort($I[$y]);return$I;}function
information_schema($l){return(min_version(5)&&$l=="information_schema")||(min_version(5.5)&&$l=="performance_schema");}function
error(){global$f;return
h(preg_replace('~^You have an error.*syntax to use~U',"Syntax error",$f->error));}function
create_database($l,$ob){return
queries("CREATE DATABASE ".idf_escape($l).($ob?" COLLATE ".q($ob):""));}function
drop_databases($k){$I=apply_queries("DROP DATABASE",$k,'idf_escape');restart_session();set_session("dbs",null);return$I;}function
rename_database($C,$ob){$I=false;if(create_database($C,$ob)){$Bg=array();foreach(tables_list()as$R=>$U)$Bg[]=table($R)." TO ".idf_escape($C).".".table($R);$I=(!$Bg||queries("RENAME TABLE ".implode(", ",$Bg)));if($I)queries("DROP DATABASE ".idf_escape(DB));restart_session();set_session("dbs",null);}return$I;}function
auto_increment(){$Ma=" PRIMARY KEY";if($_GET["create"]!=""&&$_POST["auto_increment_col"]){foreach(indexes($_GET["create"])as$v){if(in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"],$v["columns"],true)){$Ma="";break;}if($v["type"]=="PRIMARY")$Ma=" UNIQUE";}}return" AUTO_INCREMENT$Ma";}function
alter_table($R,$C,$p,$ad,$ub,$tc,$ob,$La,$Lf){$c=array();foreach($p
as$o)$c[]=($o[1]?($R!=""?($o[0]!=""?"CHANGE ".idf_escape($o[0]):"ADD"):" ")." ".implode($o[1]).($R!=""?$o[2]:""):"DROP ".idf_escape($o[0]));$c=array_merge($c,$ad);$P=($ub!==null?" COMMENT=".q($ub):"").($tc?" ENGINE=".q($tc):"").($ob?" COLLATE ".q($ob):"").($La!=""?" AUTO_INCREMENT=$La":"");if($R=="")return
queries("CREATE TABLE ".table($C)." (\n".implode(",\n",$c)."\n)$P$Lf");if($R!=$C)$c[]="RENAME TO ".table($C);if($P)$c[]=ltrim($P);return($c||$Lf?queries("ALTER TABLE ".table($R)."\n".implode(",\n",$c).$Lf):true);}function
alter_indexes($R,$c){foreach($c
as$y=>$X)$c[$y]=($X[2]=="DROP"?"\nDROP INDEX ".idf_escape($X[1]):"\nADD $X[0] ".($X[0]=="PRIMARY"?"KEY ":"").($X[1]!=""?idf_escape($X[1])." ":"")."(".implode(", ",$X[2]).")");return
queries("ALTER TABLE ".table($R).implode(",",$c));}function
truncate_tables($T){return
apply_queries("TRUNCATE TABLE",$T);}function
drop_views($Pi){return
queries("DROP VIEW ".implode(", ",array_map('table',$Pi)));}function
drop_tables($T){return
queries("DROP TABLE ".implode(", ",array_map('table',$T)));}function
move_tables($T,$Pi,$Mh){$Bg=array();foreach(array_merge($T,$Pi)as$R)$Bg[]=table($R)." TO ".idf_escape($Mh).".".table($R);return
queries("RENAME TABLE ".implode(", ",$Bg));}function
copy_tables($T,$Pi,$Mh){queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");foreach($T
as$R){$C=($Mh==DB?table("copy_$R"):idf_escape($Mh).".".table($R));if(!queries("\nDROP TABLE IF EXISTS $C")||!queries("CREATE TABLE $C LIKE ".table($R))||!queries("INSERT INTO $C SELECT * FROM ".table($R)))return
false;}foreach($Pi
as$R){$C=($Mh==DB?table("copy_$R"):idf_escape($Mh).".".table($R));$Oi=view($R);if(!queries("DROP VIEW IF EXISTS $C")||!queries("CREATE VIEW $C AS $Oi[select]"))return
false;}return
true;}function
trigger($C){if($C=="")return
array();$K=get_rows("SHOW TRIGGERS WHERE `Trigger` = ".q($C));return
reset($K);}function
triggers($R){$I=array();foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($R,"%_\\")))as$J)$I[$J["Trigger"]]=array($J["Timing"],$J["Event"]);return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
routine($C,$U){global$f,$vc,$Ld,$si;$Ca=array("bool","boolean","integer","double precision","real","dec","numeric","fixed","national char","national varchar");$mh="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$ri="((".implode("|",array_merge(array_keys($si),$Ca)).")\\b(?:\\s*\\(((?:[^'\")]|$vc)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";$Rf="$mh*(".($U=="FUNCTION"?"":$Ld).")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$ri";$h=$f->result("SHOW CREATE $U ".idf_escape($C),2);preg_match("~\\(((?:$Rf\\s*,?)*)\\)\\s*".($U=="FUNCTION"?"RETURNS\\s+$ri\\s+":"")."(.*)~is",$h,$B);$p=array();preg_match_all("~$Rf\\s*,?~is",$B[1],$xe,PREG_SET_ORDER);foreach($xe
as$Ef){$C=str_replace("``","`",$Ef[2]).$Ef[3];$p[]=array("field"=>$C,"type"=>strtolower($Ef[5]),"length"=>preg_replace_callback("~$vc~s",'normalize_enum',$Ef[6]),"unsigned"=>strtolower(preg_replace('~\\s+~',' ',trim("$Ef[8] $Ef[7]"))),"null"=>1,"full_type"=>$Ef[4],"inout"=>strtoupper($Ef[1]),"collation"=>strtolower($Ef[9]),);}if($U!="FUNCTION")return
array("fields"=>$p,"definition"=>$B[11]);return
array("fields"=>$p,"returns"=>array("type"=>$B[12],"length"=>$B[13],"unsigned"=>$B[15],"collation"=>$B[16]),"definition"=>$B[17],"language"=>"SQL",);}function
routines(){return
get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = ".q(DB));}function
routine_languages(){return
array();}function
routine_id($C,$J){return
idf_escape($C);}function
last_id(){global$f;return$f->result("SELECT LAST_INSERT_ID()");}function
explain($f,$G){return$f->query("EXPLAIN ".(min_version(5.1)?"PARTITIONS ":"").$G);}function
found_rows($S,$Z){return($Z||$S["Engine"]!="InnoDB"?null:$S["Rows"]);}function
types(){return
array();}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($Rg){return
true;}function
create_sql($R,$La,$yh){global$f;$I=$f->result("SHOW CREATE TABLE ".table($R),1);if(!$La)$I=preg_replace('~ AUTO_INCREMENT=\\d+~','',$I);return$I;}function
truncate_sql($R){return"TRUNCATE ".table($R);}function
use_sql($j){return"USE ".idf_escape($j);}function
trigger_sql($R){$I="";foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($R,"%_\\")),null,"-- ")as$J)$I.="\nCREATE TRIGGER ".idf_escape($J["Trigger"])." $J[Timing] $J[Event] ON ".table($J["Table"])." FOR EACH ROW\n$J[Statement];;\n";return$I;}function
show_variables(){return
get_key_vals("SHOW VARIABLES");}function
process_list(){return
get_rows("SHOW FULL PROCESSLIST");}function
show_status(){return
get_key_vals("SHOW STATUS");}function
convert_field($o){if(preg_match("~binary~",$o["type"]))return"HEX(".idf_escape($o["field"]).")";if($o["type"]=="bit")return"BIN(".idf_escape($o["field"])." + 0)";if(preg_match("~geometry|point|linestring|polygon~",$o["type"]))return(min_version(8)?"ST_":"")."AsWKT(".idf_escape($o["field"]).")";}function
unconvert_field($o,$I){if(preg_match("~binary~",$o["type"]))$I="UNHEX($I)";if($o["type"]=="bit")$I="CONV($I, 2, 10) + 0";if(preg_match("~geometry|point|linestring|polygon~",$o["type"]))$I=(min_version(8)?"ST_":"")."GeomFromText($I)";return$I;}function
support($Oc){return!preg_match("~scheme|sequence|type|view_trigger|materializedview".(min_version(5.1)?"":"|event|partitioning".(min_version(5)?"":"|routine|trigger|view"))."~",$Oc);}function
kill_process($X){return
queries("KILL ".number($X));}function
connection_id(){return"SELECT CONNECTION_ID()";}function
max_connections(){global$f;return$f->result("SELECT @@max_connections");}$x="sql";$si=array();$xh=array();foreach(array('æ•¸å­—'=>array("tinyint"=>3,"smallint"=>5,"mediumint"=>8,"int"=>10,"bigint"=>20,"decimal"=>66,"float"=>12,"double"=>21),'æ—¥æœŸæ™‚é–“'=>array("date"=>10,"datetime"=>19,"timestamp"=>19,"time"=>10,"year"=>4),'å­—ä¸²'=>array("char"=>255,"varchar"=>65535,"tinytext"=>255,"text"=>65535,"mediumtext"=>16777215,"longtext"=>4294967295),'åˆ—è¡¨'=>array("enum"=>65535,"set"=>64),'äºŒé€²ä½'=>array("bit"=>20,"binary"=>255,"varbinary"=>65535,"tinyblob"=>255,"blob"=>65535,"mediumblob"=>16777215,"longblob"=>4294967295),'å¹¾ä½•'=>array("geometry"=>0,"point"=>0,"linestring"=>0,"polygon"=>0,"multipoint"=>0,"multilinestring"=>0,"multipolygon"=>0,"geometrycollection"=>0),)as$y=>$X){$si+=$X;$xh[$y]=array_keys($X);}$zi=array("unsigned","zerofill","unsigned zerofill");$mf=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","REGEXP","IN","FIND_IN_SET","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL");$id=array("char_length","date","from_unixtime","lower","round","floor","ceil","sec_to_time","time_to_sec","upper");$od=array("avg","count","count distinct","group_concat","max","min","sum");$lc=array(array("char"=>"md5/sha1/password/encrypt/uuid","binary"=>"md5/sha1","date|time"=>"now",),array(number_type()=>"+/-","date"=>"+ interval/- interval","time"=>"addtime/subtime","char|text"=>"concat",));}define("SERVER",$_GET[DRIVER]);define("DB",$_GET["db"]);define("ME",preg_replace('~^[^?]*/([^?]*).*~','\\1',$_SERVER["REQUEST_URI"]).'?'.(sid()?SID.'&':'').(SERVER!==null?DRIVER."=".urlencode(SERVER).'&':'').(isset($_GET["username"])?"username=".urlencode($_GET["username"]).'&':'').(DB!=""?'db='.urlencode(DB).'&'.(isset($_GET["ns"])?"ns=".urlencode($_GET["ns"])."&":""):''));$ia="4.6.2";class
Adminer{var$operators;function
name(){return"<a href='https://www.adminer.org/'".target_blank()." id='h1'>Adminer</a>";}function
credentials(){return
array(SERVER,$_GET["username"],get_password());}function
connectSsl(){}function
permanentLogin($h=false){return
password_file($h);}function
bruteForceKey(){return$_SERVER["REMOTE_ADDR"];}function
serverName($N){return
h($N);}function
database(){return
DB;}function
databases($Zc=true){return
get_databases($Zc);}function
schemas(){return
schemas();}function
queryTimeout(){return
5;}function
headers(){}function
csp(){return
csp();}function
head(){return
true;}function
css(){$I=array();$Tc="adminer.css";if(file_exists($Tc))$I[]=$Tc;return$I;}function
loginForm(){global$dc;echo'<table cellspacing="0">
<tr><th>è³‡æ–™åº«ç³»çµ±<td>',html_select("auth[driver]",$dc,DRIVER)."\n",'<tr><th>ä¼ºæœå™¨<td><input name="auth[server]" value="',h(SERVER),'" title="hostname[:port]" placeholder="localhost" autocapitalize="off">
<tr><th>å¸³è™Ÿ<td><input name="auth[username]" id="username" value="',h($_GET["username"]),'" autocapitalize="off">
<tr><th>å¯†ç¢¼<td><input type="password" name="auth[password]">
<tr><th>è³‡æ–™åº«<td><input name="auth[db]" value="',h($_GET["db"]),'" autocapitalize="off">
</table>
',script("focus(qs('#username'));"),"<p><input type='submit' value='".'ç™»å…¥'."'>\n",checkbox("auth[permanent]",1,$_COOKIE["adminer_permanent"],'æ°¸ä¹…ç™»å…¥')."\n";}function
login($re,$F){global$x;if($x=="sqlite")return
sprintf('<a href="https://www.adminer.org/en/extension/"%s>Implement</a> %s method to use SQLite.',target_blank(),'<code>login()</code>');return
true;}function
tableName($Dh){return
h($Dh["Name"]);}function
fieldName($o,$rf=0){return'<span title="'.h($o["full_type"]).'">'.h($o["field"]).'</span>';}function
selectLinks($Dh,$O=""){global$x,$m;echo'<p class="links">';$qe=array("select"=>'é¸æ“‡è³‡æ–™');if(support("table")||support("indexes"))$qe["table"]='é¡¯ç¤ºçµæ§‹';if(support("table")){if(is_view($Dh))$qe["view"]='ä¿®æ”¹æª¢è¦–è¡¨';else$qe["create"]='ä¿®æ”¹è³‡æ–™è¡¨';}if($O!==null)$qe["edit"]='æ–°å¢é …ç›®';$C=$Dh["Name"];foreach($qe
as$y=>$X)echo" <a href='".h(ME)."$y=".urlencode($C).($y=="edit"?$O:"")."'".bold(isset($_GET[$y])).">$X</a>";echo
doc_link(array($x=>$m->tableHelp($C)),"?"),"\n";}function
foreignKeys($R){return
foreign_keys($R);}function
backwardKeys($R,$Ch){return
array();}function
backwardKeysPrint($Oa,$J){}function
selectQuery($G,$th,$Mc=false){global$x,$m;$I="</p>\n";if(!$Mc&&($Si=$m->warnings())){$t="warnings";$I=", <a href='#$t'>".'Warnings'."</a>".script("qsl('a').onclick = partial(toggle, '$t');","")."$I<div id='$t' class='hidden'>\n$Si</div>\n";}return"<p><code class='jush-$x'>".h(str_replace("\n"," ",$G))."</code> <span class='time'>(".format_time($th).")</span>".(support("sql")?" <a href='".h(ME)."sql=".urlencode($G)."'>".'ç·¨è¼¯'."</a>":"").$I;}function
sqlCommandQuery($G){return
shorten_utf8(trim($G),1000);}function
rowDescription($R){return"";}function
rowDescriptions($K,$bd){return$K;}function
selectLink($X,$o){}function
selectVal($X,$_,$o,$zf){$I=($X===null?"<i>NULL</i>":(preg_match("~char|binary|boolean~",$o["type"])&&!preg_match("~var~",$o["type"])?"<code>$X</code>":$X));if(preg_match('~blob|bytea|raw|file~',$o["type"])&&!is_utf8($X))$I="<i>".sprintf('%d byte(s)',strlen($zf))."</i>";if(preg_match('~json~',$o["type"]))$I="<code class='jush-js'>$I</code>";return($_?"<a href='".h($_)."'".(is_url($_)?target_blank():"").">$I</a>":$I);}function
editVal($X,$o){return$X;}function
tableStructurePrint($p){echo"<table cellspacing='0' class='nowrap'>\n","<thead><tr><th>".'åˆ—'."<td>".'é¡å‹'.(support("comment")?"<td>".'è¨»è§£':"")."</thead>\n";foreach($p
as$o){echo"<tr".odd()."><th>".h($o["field"]),"<td><span title='".h($o["collation"])."'>".h($o["full_type"])."</span>",($o["null"]?" <i>NULL</i>":""),($o["auto_increment"]?" <i>".'è‡ªå‹•éå¢'."</i>":""),(isset($o["default"])?" <span title='".'Default value'."'>[<b>".h($o["default"])."</b>]</span>":""),(support("comment")?"<td>".nbsp($o["comment"]):""),"\n";}echo"</table>\n";}function
tableIndexesPrint($w){echo"<table cellspacing='0'>\n";foreach($w
as$C=>$v){ksort($v["columns"]);$dg=array();foreach($v["columns"]as$y=>$X)$dg[]="<i>".h($X)."</i>".($v["lengths"][$y]?"(".$v["lengths"][$y].")":"").($v["descs"][$y]?" DESC":"");echo"<tr title='".h($C)."'><th>$v[type]<td>".implode(", ",$dg)."\n";}echo"</table>\n";}function
selectColumnsPrint($L,$e){global$id,$od;print_fieldset("select",'é¸æ“‡',$L);$s=0;$L[""]=array();foreach($L
as$y=>$X){$X=$_GET["columns"][$y];$d=select_input(" name='columns[$s][col]'",$e,$X["col"],($y!==""?"selectFieldChange":"selectAddRow"));echo"<div>".($id||$od?"<select name='columns[$s][fun]'>".optionlist(array(-1=>"")+array_filter(array('å‡½æ•¸'=>$id,'é›†åˆ'=>$od)),$X["fun"])."</select>".on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'",1).script("qsl('select').onchange = function () { helpClose();".($y!==""?"":" qsl('select, input', this.parentNode).onchange();")." };","")."($d)":$d)."</div>\n";$s++;}echo"</div></fieldset>\n";}function
selectSearchPrint($Z,$e,$w){print_fieldset("search",'æœå°‹',$Z);foreach($w
as$s=>$v){if($v["type"]=="FULLTEXT"){echo"<div>(<i>".implode("</i>, <i>",array_map('h',$v["columns"]))."</i>) AGAINST"," <input type='search' name='fulltext[$s]' value='".h($_GET["fulltext"][$s])."'>",script("qsl('input').oninput = selectFieldChange;",""),checkbox("boolean[$s]",1,isset($_GET["boolean"][$s]),"BOOL"),"</div>\n";}}$ab="this.parentNode.firstChild.onchange();";foreach(array_merge((array)$_GET["where"],array(array()))as$s=>$X){if(!$X||("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators))){echo"<div>".select_input(" name='where[$s][col]'",$e,$X["col"],($X?"selectFieldChange":"selectAddRow"),"(".'ä»»æ„ä½ç½®'.")"),html_select("where[$s][op]",$this->operators,$X["op"],$ab),"<input type='search' name='where[$s][val]' value='".h($X["val"])."'>",script("mixin(qsl('input'), {oninput: function () { $ab }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});",""),"</div>\n";}}echo"</div></fieldset>\n";}function
selectOrderPrint($rf,$e,$w){print_fieldset("sort",'æ’åº',$rf);$s=0;foreach((array)$_GET["order"]as$y=>$X){if($X!=""){echo"<div>".select_input(" name='order[$s]'",$e,$X,"selectFieldChange"),checkbox("desc[$s]",1,isset($_GET["desc"][$y]),'é™å†ª(éæ¸›)')."</div>\n";$s++;}}echo"<div>".select_input(" name='order[$s]'",$e,"","selectAddRow"),checkbox("desc[$s]",1,false,'é™å†ª(éæ¸›)')."</div>\n","</div></fieldset>\n";}function
selectLimitPrint($z){echo"<fieldset><legend>".'é™å®š'."</legend><div>";echo"<input type='number' name='limit' class='size' value='".h($z)."'>",script("qsl('input').oninput = selectFieldChange;",""),"</div></fieldset>\n";}function
selectLengthPrint($Sh){if($Sh!==null){echo"<fieldset><legend>".'Text é•·åº¦'."</legend><div>","<input type='number' name='text_length' class='size' value='".h($Sh)."'>","</div></fieldset>\n";}}function
selectActionPrint($w){echo"<fieldset><legend>".'å‹•ä½œ'."</legend><div>","<input type='submit' value='".'é¸æ“‡'."'>"," <span id='noindex' title='".'Full table scan'."'></span>","<script".nonce().">\n","var indexColumns = ";$e=array();foreach($w
as$v){$Jb=reset($v["columns"]);if($v["type"]!="FULLTEXT"&&$Jb)$e[$Jb]=1;}$e[""]=1;foreach($e
as$y=>$X)json_row($y);echo";\n","selectFieldChange.call(qs('#form')['select']);\n","</script>\n","</div></fieldset>\n";}function
selectCommandPrint(){return!information_schema(DB);}function
selectImportPrint(){return!information_schema(DB);}function
selectEmailPrint($qc,$e){}function
selectColumnsProcess($e,$w){global$id,$od;$L=array();$ld=array();foreach((array)$_GET["columns"]as$y=>$X){if($X["fun"]=="count"||($X["col"]!=""&&(!$X["fun"]||in_array($X["fun"],$id)||in_array($X["fun"],$od)))){$L[$y]=apply_sql_function($X["fun"],($X["col"]!=""?idf_escape($X["col"]):"*"));if(!in_array($X["fun"],$od))$ld[]=$L[$y];}}return
array($L,$ld);}function
selectSearchProcess($p,$w){global$f,$m;$I=array();foreach($w
as$s=>$v){if($v["type"]=="FULLTEXT"&&$_GET["fulltext"][$s]!="")$I[]="MATCH (".implode(", ",array_map('idf_escape',$v["columns"])).") AGAINST (".q($_GET["fulltext"][$s]).(isset($_GET["boolean"][$s])?" IN BOOLEAN MODE":"").")";}foreach((array)$_GET["where"]as$y=>$X){if("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators)){$Zf="";$wb=" $X[op]";if(preg_match('~IN$~',$X["op"])){$Bd=process_length($X["val"]);$wb.=" ".($Bd!=""?$Bd:"(NULL)");}elseif($X["op"]=="SQL")$wb=" $X[val]";elseif($X["op"]=="LIKE %%")$wb=" LIKE ".$this->processInput($p[$X["col"]],"%$X[val]%");elseif($X["op"]=="ILIKE %%")$wb=" ILIKE ".$this->processInput($p[$X["col"]],"%$X[val]%");elseif($X["op"]=="FIND_IN_SET"){$Zf="$X[op](".q($X["val"]).", ";$wb=")";}elseif(!preg_match('~NULL$~',$X["op"]))$wb.=" ".$this->processInput($p[$X["col"]],$X["val"]);if($X["col"]!="")$I[]=$Zf.$m->convertSearch(idf_escape($X["col"]),$X,$p[$X["col"]]).$wb;else{$rb=array();foreach($p
as$C=>$o){if((is_numeric($X["val"])||!preg_match('~'.number_type().'|bit~',$o["type"]))&&(!preg_match("~[\x80-\xFF]~",$X["val"])||preg_match('~char|text|enum|set~',$o["type"])))$rb[]=$Zf.$m->convertSearch(idf_escape($C),$X,$o).$wb;}$I[]=($rb?"(".implode(" OR ",$rb).")":"1 = 0");}}}return$I;}function
selectOrderProcess($p,$w){$I=array();foreach((array)$_GET["order"]as$y=>$X){if($X!="")$I[]=(preg_match('~^((COUNT\\(DISTINCT |[A-Z0-9_]+\\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\\)|COUNT\\(\\*\\))$~',$X)?$X:idf_escape($X)).(isset($_GET["desc"][$y])?" DESC":"");}return$I;}function
selectLimitProcess(){return(isset($_GET["limit"])?$_GET["limit"]:"50");}function
selectLengthProcess(){return(isset($_GET["text_length"])?$_GET["text_length"]:"100");}function
selectEmailProcess($Z,$bd){return
false;}function
selectQueryBuild($L,$Z,$ld,$rf,$z,$E){return"";}function
messageQuery($G,$Th,$Mc=false){global$x,$m;restart_session();$ud=&get_session("queries");if(!$ud[$_GET["db"]])$ud[$_GET["db"]]=array();if(strlen($G)>1e6)$G=preg_replace('~[\x80-\xFF]+$~','',substr($G,0,1e6))."\n...";$ud[$_GET["db"]][]=array($G,time(),$Th);$qh="sql-".count($ud[$_GET["db"]]);$I="<a href='#$qh' class='toggle'>".'SQLå‘½ä»¤'."</a>\n";if(!$Mc&&($Si=$m->warnings())){$t="warnings-".count($ud[$_GET["db"]]);$I="<a href='#$t' class='toggle'>".'Warnings'."</a>, $I<div id='$t' class='hidden'>\n$Si</div>\n";}return" <span class='time'>".@date("H:i:s")."</span>"." $I<div id='$qh' class='hidden'><pre><code class='jush-$x'>".shorten_utf8($G,1000)."</code></pre>".($Th?" <span class='time'>($Th)</span>":'').(support("sql")?'<p><a href="'.h(str_replace("db=".urlencode(DB),"db=".urlencode($_GET["db"]),ME).'sql=&history='.(count($ud[$_GET["db"]])-1)).'">'.'ç·¨è¼¯'.'</a>':'').'</div>';}function
editFunctions($o){global$lc;$I=($o["null"]?"NULL/":"");foreach($lc
as$y=>$id){if(!$y||(!isset($_GET["call"])&&(isset($_GET["select"])||where($_GET)))){foreach($id
as$Rf=>$X){if(!$Rf||preg_match("~$Rf~",$o["type"]))$I.="/$X";}if($y&&!preg_match('~set|blob|bytea|raw|file~',$o["type"]))$I.="/SQL";}}if($o["auto_increment"]&&!isset($_GET["select"])&&!where($_GET))$I='è‡ªå‹•éå¢';return
explode("/",$I);}function
editInput($R,$o,$Ja,$Y){if($o["type"]=="enum")return(isset($_GET["select"])?"<label><input type='radio'$Ja value='-1' checked><i>".'åŸå§‹'."</i></label> ":"").($o["null"]?"<label><input type='radio'$Ja value=''".($Y!==null||isset($_GET["select"])?"":" checked")."><i>NULL</i></label> ":"").enum_input("radio",$Ja,$o,$Y,0);return"";}function
editHint($R,$o,$Y){return"";}function
processInput($o,$Y,$r=""){if($r=="SQL")return$Y;$C=$o["field"];$I=q($Y);if(preg_match('~^(now|getdate|uuid)$~',$r))$I="$r()";elseif(preg_match('~^current_(date|timestamp)$~',$r))$I=$r;elseif(preg_match('~^([+-]|\\|\\|)$~',$r))$I=idf_escape($C)." $r $I";elseif(preg_match('~^[+-] interval$~',$r))$I=idf_escape($C)." $r ".(preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i",$Y)?$Y:$I);elseif(preg_match('~^(addtime|subtime|concat)$~',$r))$I="$r(".idf_escape($C).", $I)";elseif(preg_match('~^(md5|sha1|password|encrypt)$~',$r))$I="$r($I)";return
unconvert_field($o,$I);}function
dumpOutput(){$I=array('text'=>'æ‰“é–‹','file'=>'å„²å­˜');if(function_exists('gzencode'))$I['gz']='gzip';return$I;}function
dumpFormat(){return
array('sql'=>'SQL','csv'=>'CSV,','csv;'=>'CSV;','tsv'=>'TSV');}function
dumpDatabase($l){}function
dumpTable($R,$yh,$Ud=0){if($_POST["format"]!="sql"){echo"\xef\xbb\xbf";if($yh)dump_csv(array_keys(fields($R)));}else{if($Ud==2){$p=array();foreach(fields($R)as$C=>$o)$p[]=idf_escape($C)." $o[full_type]";$h="CREATE TABLE ".table($R)." (".implode(", ",$p).")";}else$h=create_sql($R,$_POST["auto_increment"],$yh);set_utf8mb4($h);if($yh&&$h){if($yh=="DROP+CREATE"||$Ud==1)echo"DROP ".($Ud==2?"VIEW":"TABLE")." IF EXISTS ".table($R).";\n";if($Ud==1)$h=remove_definer($h);echo"$h;\n\n";}}}function
dumpData($R,$yh,$G){global$f,$x;$ze=($x=="sqlite"?0:1048576);if($yh){if($_POST["format"]=="sql"){if($yh=="TRUNCATE+INSERT")echo
truncate_sql($R).";\n";$p=fields($R);}$H=$f->query($G,1);if($H){$Nd="";$Xa="";$be=array();$_h="";$Pc=($R!=''?'fetch_assoc':'fetch_row');while($J=$H->$Pc()){if(!$be){$Ki=array();foreach($J
as$X){$o=$H->fetch_field();$be[]=$o->name;$y=idf_escape($o->name);$Ki[]="$y = VALUES($y)";}$_h=($yh=="INSERT+UPDATE"?"\nON DUPLICATE KEY UPDATE ".implode(", ",$Ki):"").";\n";}if($_POST["format"]!="sql"){if($yh=="table"){dump_csv($be);$yh="INSERT";}dump_csv($J);}else{if(!$Nd)$Nd="INSERT INTO ".table($R)." (".implode(", ",array_map('idf_escape',$be)).") VALUES";foreach($J
as$y=>$X){$o=$p[$y];$J[$y]=($X!==null?unconvert_field($o,preg_match(number_type(),$o["type"])&&$X!=''?$X:q($X)):"NULL");}$Pg=($ze?"\n":" ")."(".implode(",\t",$J).")";if(!$Xa)$Xa=$Nd.$Pg;elseif(strlen($Xa)+4+strlen($Pg)+strlen($_h)<$ze)$Xa.=",$Pg";else{echo$Xa.$_h;$Xa=$Nd.$Pg;}}}if($Xa)echo$Xa.$_h;}elseif($_POST["format"]=="sql")echo"-- ".str_replace("\n"," ",$f->error)."\n";}}function
dumpFilename($zd){return
friendly_url($zd!=""?$zd:(SERVER!=""?SERVER:"localhost"));}function
dumpHeaders($zd,$Ne=false){$Bf=$_POST["output"];$Hc=(preg_match('~sql~',$_POST["format"])?"sql":($Ne?"tar":"csv"));header("Content-Type: ".($Bf=="gz"?"application/x-gzip":($Hc=="tar"?"application/x-tar":($Hc=="sql"||$Bf!="file"?"text/plain":"text/csv")."; charset=utf-8")));if($Bf=="gz")ob_start('ob_gzencode',1e6);return$Hc;}function
importServerPath(){return"adminer.sql";}function
homepage(){echo'<p class="links">'.($_GET["ns"]==""&&support("database")?'<a href="'.h(ME).'database=">'.'ä¿®æ”¹è³‡æ–™åº«'."</a>\n":""),(support("scheme")?"<a href='".h(ME)."scheme='>".($_GET["ns"]!=""?'ä¿®æ”¹è³‡æ–™è¡¨çµæ§‹':'å»ºç«‹è³‡æ–™è¡¨çµæ§‹')."</a>\n":""),($_GET["ns"]!==""?'<a href="'.h(ME).'schema=">'.'è³‡æ–™åº«æ¶æ§‹'."</a>\n":""),(support("privileges")?"<a href='".h(ME)."privileges='>".'æ¬Šé™'."</a>\n":"");return
true;}function
navigation($Me){global$ia,$x,$dc,$f;echo'<h1>
',$this->name(),' <span class="version">',$ia,'</span>
<a href="https://www.adminer.org/#download"',target_blank(),' id="version">',(version_compare($ia,$_COOKIE["adminer_version"])<0?h($_COOKIE["adminer_version"]):""),'</a>
</h1>
';if($Me=="auth"){$Vc=true;foreach((array)$_SESSION["pwds"]as$Mi=>$dh){foreach($dh
as$N=>$Hi){foreach($Hi
as$V=>$F){if($F!==null){if($Vc){echo"<p id='logins'>".script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");$Vc=false;}$Pb=$_SESSION["db"][$Mi][$N][$V];foreach(($Pb?array_keys($Pb):array(""))as$l)echo"<a href='".h(auth_url($Mi,$N,$V,$l))."'>($dc[$Mi]) ".h($V.($N!=""?"@".$this->serverName($N):"").($l!=""?" - $l":""))."</a><br>\n";}}}}}else{if($_GET["ns"]!==""&&!$Me&&DB!=""){$f->select_db(DB);$T=table_status('',true);}echo
script_src(preg_replace("~\\?.*~","",ME)."?file=jush.js&version=4.6.2");if(support("sql")){echo'<script',nonce(),'>
';if($T){$qe=array();foreach($T
as$R=>$U)$qe[]=preg_quote($R,'/');echo"var jushLinks = { $x: [ '".js_escape(ME).(support("table")?"table=":"select=")."\$&', /\\b(".implode("|",$qe).")\\b/g ] };\n";foreach(array("bac","bra","sqlite_quo","mssql_bra")as$X)echo"jushLinks.$X = jushLinks.$x;\n";}$ch=$f->server_info;echo'bodyLoad(\'',(is_object($f)?preg_replace('~^(\\d\\.?\\d).*~s','\\1',$ch):""),'\'',(preg_match('~MariaDB~',$ch)?", true":""),');
</script>
';}$this->databasesPrint($Me);if(DB==""||!$Me){echo"<p class='links'>".(support("sql")?"<a href='".h(ME)."sql='".bold(isset($_GET["sql"])&&!isset($_GET["import"])).">".'SQLå‘½ä»¤'."</a>\n<a href='".h(ME)."import='".bold(isset($_GET["import"])).">".'åŒ¯å…¥'."</a>\n":"")."";if(support("dump"))echo"<a href='".h(ME)."dump=".urlencode(isset($_GET["table"])?$_GET["table"]:$_GET["select"])."' id='dump'".bold(isset($_GET["dump"])).">".'åŒ¯å‡º'."</a>\n";}if($_GET["ns"]!==""&&!$Me&&DB!=""){echo'<a href="'.h(ME).'create="'.bold($_GET["create"]==="").">".'å»ºç«‹è³‡æ–™è¡¨'."</a>\n";if(!$T)echo"<p class='message'>".'æ²’æœ‰è³‡æ–™è¡¨ã€‚'."\n";else$this->tablesPrint($T);}}}function
databasesPrint($Me){global$b,$f;$k=$this->databases();echo'<form action="">
<p id="dbs">
';hidden_fields_get();$Nb=script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");echo"<span title='".'è³‡æ–™åº«'."'>".'DB'."</span>: ".($k?"<select name='db'>".optionlist(array(""=>"")+$k,DB)."</select>$Nb":"<input name='db' value='".h(DB)."' autocapitalize='off'>\n"),"<input type='submit' value='".'ä½¿ç”¨'."'".($k?" class='hidden'":"").">\n";if($Me!="db"&&DB!=""&&$f->select_db(DB)){if(support("scheme")){echo"<br>".'è³‡æ–™è¡¨çµæ§‹'.": <select name='ns'>".optionlist(array(""=>"")+$b->schemas(),$_GET["ns"])."</select>$Nb";if($_GET["ns"]!="")set_schema($_GET["ns"]);}}echo(isset($_GET["sql"])?'<input type="hidden" name="sql" value="">':(isset($_GET["schema"])?'<input type="hidden" name="schema" value="">':(isset($_GET["dump"])?'<input type="hidden" name="dump" value="">':(isset($_GET["privileges"])?'<input type="hidden" name="privileges" value="">':"")))),"</p></form>\n";}function
tablesPrint($T){echo"<ul id='tables'>".script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");foreach($T
as$R=>$P){$C=$this->tableName($P);if($C!=""){echo'<li><a href="'.h(ME).'select='.urlencode($R).'"'.bold($_GET["select"]==$R||$_GET["edit"]==$R,"select").">".'é¸æ“‡'."</a> ",(support("table")||support("indexes")?'<a href="'.h(ME).'table='.urlencode($R).'"'.bold(in_array($R,array($_GET["table"],$_GET["create"],$_GET["indexes"],$_GET["foreign"],$_GET["trigger"])),(is_view($P)?"view":"structure"))." title='".'é¡¯ç¤ºçµæ§‹'."'>$C</a>":"<span>$C</span>")."\n";}}echo"</ul>\n";}}$b=(function_exists('adminer_object')?adminer_object():new
Adminer);if($b->operators===null)$b->operators=$mf;function
page_header($Wh,$n="",$Wa=array(),$Xh=""){global$ca,$ia,$b,$dc,$x;page_headers();if(is_ajax()&&$n){page_messages($n);exit;}$Yh=$Wh.($Xh!=""?": $Xh":"");$Zh=strip_tags($Yh.(SERVER!=""&&SERVER!="localhost"?h(" - ".SERVER):"")." - ".$b->name());echo'<!DOCTYPE html>
<html lang="zh-tw" dir="ltr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<title>',$Zh,'</title>
<link rel="stylesheet" type="text/css" href="',h(preg_replace("~\\?.*~","",ME)."?file=default.css&version=4.6.2"),'">
',script_src(preg_replace("~\\?.*~","",ME)."?file=functions.js&version=4.6.2");if($b->head()){echo'<link rel="shortcut icon" type="image/x-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=4.6.2"),'">
<link rel="apple-touch-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=4.6.2"),'">
';foreach($b->css()as$Hb){echo'<link rel="stylesheet" type="text/css" href="',h($Hb),'">
';}}echo'
<body class="ltr nojs">
';$Tc=get_temp_dir()."/adminer.version";if(!$_COOKIE["adminer_version"]&&function_exists('openssl_verify')&&file_exists($Tc)&&filemtime($Tc)+86400>time()){$Ni=unserialize(file_get_contents($Tc));$kg="-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";if(openssl_verify($Ni["version"],base64_decode($Ni["signature"]),$kg)==1)$_COOKIE["adminer_version"]=$Ni["version"];}echo'<script',nonce(),'>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick',(isset($_COOKIE["adminer_version"])?"":", onload: partial(verifyVersion, '$ia', '".js_escape(ME)."', '".get_token()."')");?>});
document.body.className = document.body.className.replace(/ nojs/, ' js');
var offlineMessage = '<?php echo
js_escape('You are offline.'),'\';
var thousandsSeparator = \'',js_escape(','),'\';
</script>

<div id="help" class="jush-',$x,' jsonly hidden"></div>
',script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"),'
<div id="content">
';if($Wa!==null){$_=substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1);echo'<p id="breadcrumb"><a href="'.h($_?$_:".").'">'.$dc[DRIVER].'</a> &raquo; ';$_=substr(preg_replace('~\b(db|ns)=[^&]*&~','',ME),0,-1);$N=$b->serverName(SERVER);$N=($N!=""?$N:'ä¼ºæœå™¨');if($Wa===false)echo"$N\n";else{echo"<a href='".($_?h($_):".")."' accesskey='1' title='Alt+Shift+1'>$N</a> &raquo; ";if($_GET["ns"]!=""||(DB!=""&&is_array($Wa)))echo'<a href="'.h($_."&db=".urlencode(DB).(support("scheme")?"&ns=":"")).'">'.h(DB).'</a> &raquo; ';if(is_array($Wa)){if($_GET["ns"]!="")echo'<a href="'.h(substr(ME,0,-1)).'">'.h($_GET["ns"]).'</a> &raquo; ';foreach($Wa
as$y=>$X){$Vb=(is_array($X)?$X[1]:h($X));if($Vb!="")echo"<a href='".h(ME."$y=").urlencode(is_array($X)?$X[0]:$X)."'>$Vb</a> &raquo; ";}}echo"$Wh\n";}}echo"<h2>$Yh</h2>\n","<div id='ajaxstatus' class='jsonly hidden'></div>\n";restart_session();page_messages($n);$k=&get_session("dbs");if(DB!=""&&$k&&!in_array(DB,$k,true))$k=null;stop_session();define("PAGE_HEADER",1);}function
page_headers(){global$b;header("Content-Type: text/html; charset=utf-8");header("Cache-Control: no-cache");header("X-Frame-Options: deny");header("X-XSS-Protection: 0");header("X-Content-Type-Options: nosniff");header("Referrer-Policy: origin-when-cross-origin");foreach($b->csp()as$Gb){$td=array();foreach($Gb
as$y=>$X)$td[]="$y $X";header("Content-Security-Policy: ".implode("; ",$td));}$b->headers();}function
csp(){return
array(array("script-src"=>"'self' 'unsafe-inline' 'nonce-".get_nonce()."' 'strict-dynamic'","connect-src"=>"'self'","frame-src"=>"https://www.adminer.org","object-src"=>"'none'","base-uri"=>"'none'","form-action"=>"'self'",),);}function
get_nonce(){static$We;if(!$We)$We=base64_encode(rand_string());return$We;}function
page_messages($n){$Ai=preg_replace('~^[^?]*~','',$_SERVER["REQUEST_URI"]);$Ie=$_SESSION["messages"][$Ai];if($Ie){echo"<div class='message'>".implode("</div>\n<div class='message'>",$Ie)."</div>".script("messagesPrint();");unset($_SESSION["messages"][$Ai]);}if($n)echo"<div class='error'>$n</div>\n";}function
page_footer($Me=""){global$b,$di;echo'</div>

';if($Me!="auth"){echo'<form action="" method="post">
<p class="logout">
<input type="submit" name="logout" value="ç™»å‡º" id="logout">
<input type="hidden" name="token" value="',$di,'">
</p>
</form>
';}echo'<div id="menu">
';$b->navigation($Me);echo'</div>
',script("setupSubmitHighlight(document);");}function
int32($Pe){while($Pe>=2147483648)$Pe-=4294967296;while($Pe<=-2147483649)$Pe+=4294967296;return(int)$Pe;}function
long2str($W,$Ri){$Pg='';foreach($W
as$X)$Pg.=pack('V',$X);if($Ri)return
substr($Pg,0,end($W));return$Pg;}function
str2long($Pg,$Ri){$W=array_values(unpack('V*',str_pad($Pg,4*ceil(strlen($Pg)/4),"\0")));if($Ri)$W[]=strlen($Pg);return$W;}function
xxtea_mx($ej,$dj,$Ah,$Xd){return
int32((($ej>>5&0x7FFFFFF)^$dj<<2)+(($dj>>3&0x1FFFFFFF)^$ej<<4))^int32(($Ah^$dj)+($Xd^$ej));}function
encrypt_string($wh,$y){if($wh=="")return"";$y=array_values(unpack("V*",pack("H*",md5($y))));$W=str2long($wh,true);$Pe=count($W)-1;$ej=$W[$Pe];$dj=$W[0];$lg=floor(6+52/($Pe+1));$Ah=0;while($lg-->0){$Ah=int32($Ah+0x9E3779B9);$kc=$Ah>>2&3;for($Cf=0;$Cf<$Pe;$Cf++){$dj=$W[$Cf+1];$Oe=xxtea_mx($ej,$dj,$Ah,$y[$Cf&3^$kc]);$ej=int32($W[$Cf]+$Oe);$W[$Cf]=$ej;}$dj=$W[0];$Oe=xxtea_mx($ej,$dj,$Ah,$y[$Cf&3^$kc]);$ej=int32($W[$Pe]+$Oe);$W[$Pe]=$ej;}return
long2str($W,false);}function
decrypt_string($wh,$y){if($wh=="")return"";if(!$y)return
false;$y=array_values(unpack("V*",pack("H*",md5($y))));$W=str2long($wh,false);$Pe=count($W)-1;$ej=$W[$Pe];$dj=$W[0];$lg=floor(6+52/($Pe+1));$Ah=int32($lg*0x9E3779B9);while($Ah){$kc=$Ah>>2&3;for($Cf=$Pe;$Cf>0;$Cf--){$ej=$W[$Cf-1];$Oe=xxtea_mx($ej,$dj,$Ah,$y[$Cf&3^$kc]);$dj=int32($W[$Cf]-$Oe);$W[$Cf]=$dj;}$ej=$W[$Pe];$Oe=xxtea_mx($ej,$dj,$Ah,$y[$Cf&3^$kc]);$dj=int32($W[0]-$Oe);$W[0]=$dj;$Ah=int32($Ah-0x9E3779B9);}return
long2str($W,true);}$f='';$sd=$_SESSION["token"];if(!$sd)$_SESSION["token"]=rand(1,1e6);$di=get_token();$Sf=array();if($_COOKIE["adminer_permanent"]){foreach(explode(" ",$_COOKIE["adminer_permanent"])as$X){list($y)=explode(":",$X);$Sf[$y]=$X;}}function
add_invalid_login(){global$b;$gd=file_open_lock(get_temp_dir()."/adminer.invalid");if(!$gd)return;$Qd=unserialize(stream_get_contents($gd));$Th=time();if($Qd){foreach($Qd
as$Rd=>$X){if($X[0]<$Th)unset($Qd[$Rd]);}}$Pd=&$Qd[$b->bruteForceKey()];if(!$Pd)$Pd=array($Th+30*60,0);$Pd[1]++;file_write_unlock($gd,serialize($Qd));}function
check_invalid_login(){global$b;$Qd=unserialize(@file_get_contents(get_temp_dir()."/adminer.invalid"));$Pd=$Qd[$b->bruteForceKey()];$Ve=($Pd[1]>29?$Pd[0]-time():0);if($Ve>0)auth_error(sprintf('Too many unsuccessful logins, try again in %d minute(s).',ceil($Ve/60)));}$Ka=$_POST["auth"];if($Ka){session_regenerate_id();$Mi=$Ka["driver"];$N=$Ka["server"];$V=$Ka["username"];$F=(string)$Ka["password"];$l=$Ka["db"];set_password($Mi,$N,$V,$F);$_SESSION["db"][$Mi][$N][$V][$l]=true;if($Ka["permanent"]){$y=base64_encode($Mi)."-".base64_encode($N)."-".base64_encode($V)."-".base64_encode($l);$eg=$b->permanentLogin(true);$Sf[$y]="$y:".base64_encode($eg?encrypt_string($F,$eg):"");adm_cookie("adminer_permanent",implode(" ",$Sf));}if(count($_POST)==1||DRIVER!=$Mi||SERVER!=$N||$_GET["username"]!==$V||DB!=$l)adm_redirect(auth_url($Mi,$N,$V,$l));}elseif($_POST["logout"]){if($sd&&!verify_token()){page_header('ç™»å‡º','ç„¡æ•ˆçš„ CSRF tokenã€‚è«‹é‡æ–°ç™¼é€è¡¨å–®ã€‚');page_footer("db");exit;}else{foreach(array("pwds","db","dbs","queries")as$y)set_session($y,null);unset_permanent();adm_redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1),'æˆåŠŸç™»å‡ºã€‚');}}elseif($Sf&&!$_SESSION["pwds"]){session_regenerate_id();$eg=$b->permanentLogin();foreach($Sf
as$y=>$X){list(,$ib)=explode(":",$X);list($Mi,$N,$V,$l)=array_map('base64_decode',explode("-",$y));set_password($Mi,$N,$V,decrypt_string(base64_decode($ib),$eg));$_SESSION["db"][$Mi][$N][$V][$l]=true;}}function
unset_permanent(){global$Sf;foreach($Sf
as$y=>$X){list($Mi,$N,$V,$l)=array_map('base64_decode',explode("-",$y));if($Mi==DRIVER&&$N==SERVER&&$V==$_GET["username"]&&$l==DB)unset($Sf[$y]);}adm_cookie("adminer_permanent",implode(" ",$Sf));}function
auth_error($n){global$b,$sd;$eh=session_name();if(isset($_GET["username"])){header("HTTP/1.1 403 Forbidden");if(($_COOKIE[$eh]||$_GET[$eh])&&!$sd)$n='Session å·²éæœŸï¼Œè«‹é‡æ–°ç™»å…¥ã€‚';else{add_invalid_login();$F=get_password();if($F!==null){if($F===false)$n.='<br>'.sprintf('Master password expired. <a href="https://www.adminer.org/en/extension/"%s>Implement</a> %s method to make it permanent.',target_blank(),'<code>permanentLogin()</code>');set_password(DRIVER,SERVER,$_GET["username"],null);}unset_permanent();}}if(!$_COOKIE[$eh]&&$_GET[$eh]&&ini_bool("session.use_only_cookies"))$n='Session å¿…é ˆè¢«å•Ÿç”¨ã€‚';$Ff=session_get_cookie_params();adm_cookie("adminer_key",($_COOKIE["adminer_key"]?$_COOKIE["adminer_key"]:rand_string()),$Ff["lifetime"]);page_header('ç™»å…¥',$n,null);echo"<form action='' method='post'>\n","<div>";if(hidden_fields($_POST,array("auth")))echo"<p class='message'>".'The action will be performed after successful login with the same credentials.'."\n";echo"</div>\n";$b->loginForm();echo"</form>\n";page_footer("auth");exit;}if(isset($_GET["username"])){if(!class_exists("Min_DB")){unset($_SESSION["pwds"][DRIVER]);unset_permanent();page_header('ç„¡æ“´å……æ¨¡çµ„',sprintf('æ²’æœ‰ä»»ä½•æ”¯æ´çš„PHPæ“´å……æ¨¡çµ„ï¼ˆ%sï¼‰ã€‚',implode(", ",$Yf)),false);page_footer("auth");exit;}list($xd,$Uf)=explode(":",SERVER,2);if(is_numeric($Uf)&&$Uf<1024)auth_error('Connecting to privileged ports is not allowed.');check_invalid_login();$f=connect();$m=new
Min_Driver($f);}$re=null;if(!is_object($f)||($re=$b->login($_GET["username"],get_password()))!==true)auth_error((is_string($f)?h($f):(is_string($re)?$re:'ç„¡æ•ˆçš„æ†‘è­‰ã€‚')));if($Ka&&$_POST["token"])$_POST["token"]=$di;$n='';if($_POST){if(!verify_token()){$Kd="max_input_vars";$Ce=ini_get($Kd);if(extension_loaded("suhosin")){foreach(array("suhosin.request.max_vars","suhosin.post.max_vars")as$y){$X=ini_get($y);if($X&&(!$Ce||$X<$Ce)){$Kd=$y;$Ce=$X;}}}$n=(!$_POST["token"]&&$Ce?sprintf('è¶…éå…è¨±çš„å­—æ®µæ•¸é‡çš„æœ€å¤§å€¼ã€‚è«‹å¢åŠ %sã€‚',"'$Kd'"):'ç„¡æ•ˆçš„ CSRF tokenã€‚è«‹é‡æ–°ç™¼é€è¡¨å–®ã€‚'.' '.'If you did not send this request from Adminer then close this page.');}}elseif($_SERVER["REQUEST_METHOD"]=="POST"){$n=sprintf('POST è³‡æ–™å¤ªå¤§ã€‚æ¸›å°‘è³‡æ–™æˆ–è€…å¢åŠ  %s çš„è¨­å®šå€¼ã€‚',"'post_max_size'");if(isset($_GET["sql"]))$n.=' '.'You can upload a big SQL file via FTP and import it from server.';}if(!ini_bool("session.use_cookies")||@ini_set("session.use_cookies",false)!==false)session_write_close();function
select($H,$g=null,$uf=array(),$z=0){global$x;$qe=array();$w=array();$e=array();$Ta=array();$si=array();$I=array();odd('');for($s=0;(!$z||$s<$z)&&($J=$H->fetch_row());$s++){if(!$s){echo"<table cellspacing='0' class='nowrap'>\n","<thead><tr>";for($Wd=0;$Wd<count($J);$Wd++){$o=$H->fetch_field();$C=$o->name;$tf=$o->orgtable;$sf=$o->orgname;$I[$o->table]=$tf;if($uf&&$x=="sql")$qe[$Wd]=($C=="table"?"table=":($C=="possible_keys"?"indexes=":null));elseif($tf!=""){if(!isset($w[$tf])){$w[$tf]=array();foreach(indexes($tf,$g)as$v){if($v["type"]=="PRIMARY"){$w[$tf]=array_flip($v["columns"]);break;}}$e[$tf]=$w[$tf];}if(isset($e[$tf][$sf])){unset($e[$tf][$sf]);$w[$tf][$sf]=$Wd;$qe[$Wd]=$tf;}}if($o->charsetnr==63)$Ta[$Wd]=true;$si[$Wd]=$o->type;echo"<th".($tf!=""||$o->name!=$sf?" title='".h(($tf!=""?"$tf.":"").$sf)."'":"").">".h($C).($uf?doc_link(array('sql'=>"explain-output.html#explain_".strtolower($C),'mariadb'=>"explain/#the-columns-in-explain-select",)):"");}echo"</thead>\n";}echo"<tr".odd().">";foreach($J
as$y=>$X){if($X===null)$X="<i>NULL</i>";elseif($Ta[$y]&&!is_utf8($X))$X="<i>".sprintf('%d byte(s)',strlen($X))."</i>";elseif(!strlen($X))$X="&nbsp;";else{$X=h($X);if($si[$y]==254)$X="<code>$X</code>";}if(isset($qe[$y])&&!$e[$qe[$y]]){if($uf&&$x=="sql"){$R=$J[array_search("table=",$qe)];$_=$qe[$y].urlencode($uf[$R]!=""?$uf[$R]:$R);}else{$_="edit=".urlencode($qe[$y]);foreach($w[$qe[$y]]as$mb=>$Wd)$_.="&where".urlencode("[".bracket_escape($mb)."]")."=".urlencode($J[$Wd]);}$X="<a href='".h(ME.$_)."'>$X</a>";}echo"<td>$X";}}echo($s?"</table>":"<p class='message'>".'æ²’æœ‰è¡Œã€‚')."\n";return$I;}function
referencable_primary($Yg){$I=array();foreach(table_status('',true)as$Eh=>$R){if($Eh!=$Yg&&fk_support($R)){foreach(fields($Eh)as$o){if($o["primary"]){if($I[$Eh]){unset($I[$Eh]);break;}$I[$Eh]=$o;}}}}return$I;}function
textarea($C,$Y,$K=10,$rb=80){global$x;echo"<textarea name='$C' rows='$K' cols='$rb' class='sqlarea jush-$x' spellcheck='false' wrap='off'>";if(is_array($Y)){foreach($Y
as$X)echo
h($X[0])."\n\n\n";}else
echo
h($Y);echo"</textarea>";}function
edit_type($y,$o,$pb,$cd=array(),$Kc=array()){global$xh,$si,$zi,$hf;$U=$o["type"];echo'<td><select name="',h($y),'[type]" class="type" aria-labelledby="label-type">';if($U&&!isset($si[$U])&&!isset($cd[$U])&&!in_array($U,$Kc))$Kc[]=$U;if($cd)$xh['å¤–ä¾†éµ']=$cd;echo
optionlist(array_merge($Kc,$xh),$U),'</select>
',on_help("getTarget(event).value",1),script("mixin(qsl('select'), {onfocus: function () { lastType = selectValue(this); }, onchange: editingTypeChange});",""),'<td><input name="',h($y),'[length]" value="',h($o["length"]),'" size="3"',(!$o["length"]&&preg_match('~var(char|binary)$~',$U)?" class='required'":""),' aria-labelledby="label-length">',script("mixin(qsl('input'), {onfocus: editingLengthFocus, oninput: editingLengthChange});",""),'<td class="options">';echo"<select name='".h($y)."[collation]'".(preg_match('~(char|text|enum|set)$~',$U)?"":" class='hidden'").'><option value="">('.'æ ¡å°'.')'.optionlist($pb,$o["collation"]).'</select>',($zi?"<select name='".h($y)."[unsigned]'".(!$U||preg_match(number_type(),$U)?"":" class='hidden'").'><option>'.optionlist($zi,$o["unsigned"]).'</select>':''),(isset($o['on_update'])?"<select name='".h($y)."[on_update]'".(preg_match('~timestamp|datetime~',$U)?"":" class='hidden'").'>'.optionlist(array(""=>"(".'ON UPDATE'.")","CURRENT_TIMESTAMP"),$o["on_update"]).'</select>':''),($cd?"<select name='".h($y)."[on_delete]'".(preg_match("~`~",$U)?"":" class='hidden'")."><option value=''>(".'ON DELETE'.")".optionlist(explode("|",$hf),$o["on_delete"])."</select> ":" ");}function
process_length($ne){global$vc;return(preg_match("~^\\s*\\(?\\s*$vc(?:\\s*,\\s*$vc)*+\\s*\\)?\\s*\$~",$ne)&&preg_match_all("~$vc~",$ne,$xe)?"(".implode(",",$xe[0]).")":preg_replace('~^[0-9].*~','(\0)',preg_replace('~[^-0-9,+()[\]]~','',$ne)));}function
process_type($o,$nb="COLLATE"){global$zi;return" $o[type]".process_length($o["length"]).(preg_match(number_type(),$o["type"])&&in_array($o["unsigned"],$zi)?" $o[unsigned]":"").(preg_match('~char|text|enum|set~',$o["type"])&&$o["collation"]?" $nb ".q($o["collation"]):"");}function
process_field($o,$qi){return
array(idf_escape(trim($o["field"])),process_type($qi),($o["null"]?" NULL":" NOT NULL"),default_value($o),(preg_match('~timestamp|datetime~',$o["type"])&&$o["on_update"]?" ON UPDATE $o[on_update]":""),(support("comment")&&$o["comment"]!=""?" COMMENT ".q($o["comment"]):""),($o["auto_increment"]?auto_increment():null),);}function
default_value($o){$Rb=$o["default"];return($Rb===null?"":" DEFAULT ".(preg_match('~char|binary|text|enum|set~',$o["type"])||preg_match('~^(?![a-z])~i',$Rb)?q($Rb):$Rb));}function
type_class($U){foreach(array('char'=>'text','date'=>'time|year','binary'=>'blob','enum'=>'set',)as$y=>$X){if(preg_match("~$y|$X~",$U))return" class='$y'";}}function
edit_fields($p,$pb,$U="TABLE",$cd=array(),$vb=false){global$Ld;$p=array_values($p);echo'<thead><tr>
';if($U=="PROCEDURE"){echo'<td>&nbsp;';}echo'<th id="label-name">',($U=="TABLE"?'åˆ—å':'åƒæ•¸åç¨±'),'<td id="label-type">é¡å‹<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>',script("qs('#enum-edit').onblur = editingLengthBlur;"),'<td id="label-length">é•·åº¦
<td>','é¸é …';if($U=="TABLE"){echo'<td id="label-null">NULL
<td><input type="radio" name="auto_increment_col" value=""><acronym id="label-ai" title="è‡ªå‹•éå¢">AI</acronym>',doc_link(array('sql'=>"example-auto-increment.html",'mariadb'=>"auto_increment/",'sqlite'=>"autoinc.html",'pgsql'=>"datatype.html#DATATYPE-SERIAL",'mssql'=>"ms186775.aspx",)),'<td id="label-default">Default value
',(support("comment")?"<td id='label-comment'".($vb?"":" class='hidden'").">".'è¨»è§£':"");}echo'<td>',"<input type='image' class='icon' name='add[".(support("move_col")?0:count($p))."]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.6.2")."' alt='+' title='".'æ–°å¢ä¸‹ä¸€ç­†'."'>".script("row_count = ".count($p).";"),'</thead>
<tbody>
',script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");foreach($p
as$s=>$o){$s++;$vf=$o[($_POST?"orig":"field")];$Zb=(isset($_POST["add"][$s-1])||(isset($o["field"])&&!$_POST["drop_col"][$s]))&&(support("drop_col")||$vf=="");echo'<tr',($Zb?"":" style='display: none;'"),'>
',($U=="PROCEDURE"?"<td>".html_select("fields[$s][inout]",explode("|",$Ld),$o["inout"]):""),'<th>';if($Zb){echo'<input name="fields[',$s,'][field]" value="',h($o["field"]),'" maxlength="64" autocapitalize="off" aria-labelledby="label-name">',script("qsl('input').oninput = function () { editingNameChange.call(this);".($o["field"]!=""||count($p)>1?"":" editingAddRow.call(this);")." };","");}echo'<input type="hidden" name="fields[',$s,'][orig]" value="',h($vf),'">
';edit_type("fields[$s]",$o,$pb,$cd);if($U=="TABLE"){echo'<td>',checkbox("fields[$s][null]",1,$o["null"],"","","block","label-null"),'<td><label class="block"><input type="radio" name="auto_increment_col" value="',$s,'"';if($o["auto_increment"]){echo' checked';}echo' aria-labelledby="label-ai"></label><td>',checkbox("fields[$s][has_default]",1,$o["has_default"],"","","","label-default"),'<input name="fields[',$s,'][default]" value="',h($o["default"]),'" aria-labelledby="label-default">',(support("comment")?"<td".($vb?"":" class='hidden'")."><input name='fields[$s][comment]' value='".h($o["comment"])."' maxlength='".(min_version(5.5)?1024:255)."' aria-labelledby='label-comment'>":"");}echo"<td>",(support("move_col")?"<input type='image' class='icon' name='add[$s]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.6.2")."' alt='+' title='".'æ–°å¢ä¸‹ä¸€ç­†'."'>&nbsp;"."<input type='image' class='icon' name='up[$s]' src='".h(preg_replace("~\\?.*~","",ME)."?file=up.gif&version=4.6.2")."' alt='â†‘' title='".'ä¸Šç§»'."'>&nbsp;"."<input type='image' class='icon' name='down[$s]' src='".h(preg_replace("~\\?.*~","",ME)."?file=down.gif&version=4.6.2")."' alt='â†“' title='".'ä¸‹ç§»'."'>&nbsp;":""),($vf==""||support("drop_col")?"<input type='image' class='icon' name='drop_col[$s]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=4.6.2")."' alt='x' title='".'ç§»é™¤'."'>":"");}}function
process_fields(&$p){$D=0;if($_POST["up"]){$he=0;foreach($p
as$y=>$o){if(key($_POST["up"])==$y){unset($p[$y]);array_splice($p,$he,0,array($o));break;}if(isset($o["field"]))$he=$D;$D++;}}elseif($_POST["down"]){$ed=false;foreach($p
as$y=>$o){if(isset($o["field"])&&$ed){unset($p[key($_POST["down"])]);array_splice($p,$D,0,array($ed));break;}if(key($_POST["down"])==$y)$ed=$o;$D++;}}elseif($_POST["add"]){$p=array_values($p);array_splice($p,key($_POST["add"]),0,array(array()));}elseif(!$_POST["drop_col"])return
false;return
true;}function
normalize_enum($B){return"'".str_replace("'","''",addcslashes(stripcslashes(str_replace($B[0][0].$B[0][0],$B[0][0],substr($B[0],1,-1))),'\\'))."'";}function
grant($jd,$gg,$e,$gf){if(!$gg)return
true;if($gg==array("ALL PRIVILEGES","GRANT OPTION"))return($jd=="GRANT"?queries("$jd ALL PRIVILEGES$gf WITH GRANT OPTION"):queries("$jd ALL PRIVILEGES$gf")&&queries("$jd GRANT OPTION$gf"));return
queries("$jd ".preg_replace('~(GRANT OPTION)\\([^)]*\\)~','\\1',implode("$e, ",$gg).$e).$gf);}function
drop_create($ec,$h,$fc,$Qh,$hc,$A,$He,$Fe,$Ge,$df,$Se){if($_POST["drop"])query_redirect($ec,$A,$He);elseif($df=="")query_redirect($h,$A,$Ge);elseif($df!=$Se){$Fb=queries($h);queries_redirect($A,$Fe,$Fb&&queries($ec));if($Fb)queries($fc);}else
queries_redirect($A,$Fe,queries($Qh)&&queries($hc)&&queries($ec)&&queries($h));}function
create_trigger($gf,$J){global$x;$Vh=" $J[Timing] $J[Event]".($J["Event"]=="UPDATE OF"?" ".idf_escape($J["Of"]):"");return"CREATE TRIGGER ".idf_escape($J["Trigger"]).($x=="mssql"?$gf.$Vh:$Vh.$gf).rtrim(" $J[Type]\n$J[Statement]",";").";";}function
create_routine($Lg,$J){global$Ld,$x;$O=array();$p=(array)$J["fields"];ksort($p);foreach($p
as$o){if($o["field"]!="")$O[]=(preg_match("~^($Ld)\$~",$o["inout"])?"$o[inout] ":"").idf_escape($o["field"]).process_type($o,"CHARACTER SET");}$Sb=rtrim("\n$J[definition]",";");return"CREATE $Lg ".idf_escape(trim($J["name"]))." (".implode(", ",$O).")".(isset($_GET["function"])?" RETURNS".process_type($J["returns"],"CHARACTER SET"):"").($J["language"]?" LANGUAGE $J[language]":"").($x=="pgsql"?" AS ".q($Sb):"$Sb;");}function
remove_definer($G){return
preg_replace('~^([A-Z =]+) DEFINER=`'.preg_replace('~@(.*)~','`@`(%|\\1)',logged_user()).'`~','\\1',$G);}function
format_foreign_key($q){global$hf;return" FOREIGN KEY (".implode(", ",array_map('idf_escape',$q["source"])).") REFERENCES ".table($q["table"])." (".implode(", ",array_map('idf_escape',$q["target"])).")".(preg_match("~^($hf)\$~",$q["on_delete"])?" ON DELETE $q[on_delete]":"").(preg_match("~^($hf)\$~",$q["on_update"])?" ON UPDATE $q[on_update]":"");}function
tar_file($Tc,$ai){$I=pack("a100a8a8a8a12a12",$Tc,644,0,0,decoct($ai->size),decoct(time()));$gb=8*32;for($s=0;$s<strlen($I);$s++)$gb+=ord($I[$s]);$I.=sprintf("%06o",$gb)."\0 ";echo$I,str_repeat("\0",512-strlen($I));$ai->send();echo
str_repeat("\0",511-($ai->size+511)%512);}function
ini_bytes($Kd){$X=ini_get($Kd);switch(strtolower(substr($X,-1))){case'g':$X*=1024;case'm':$X*=1024;case'k':$X*=1024;}return$X;}function
doc_link($Qf,$Rh="<sup>?</sup>"){global$x,$f;$ch=$f->server_info;$Ni=preg_replace('~^(\\d\\.?\\d).*~s','\\1',$ch);$Di=array('sql'=>"https://dev.mysql.com/doc/refman/$Ni/en/",'sqlite'=>"https://www.sqlite.org/",'pgsql'=>"https://www.postgresql.org/docs/$Ni/static/",'mssql'=>"https://msdn.microsoft.com/library/",'oracle'=>"https://download.oracle.com/docs/cd/B19306_01/server.102/b14200/",);if(preg_match('~MariaDB~',$ch)){$Di['sql']="https://mariadb.com/kb/en/library/";$Qf['sql']=(isset($Qf['mariadb'])?$Qf['mariadb']:str_replace(".html","/",$Qf['sql']));}return($Qf[$x]?"<a href='$Di[$x]$Qf[$x]'".target_blank().">$Rh</a>":"");}function
ob_gzencode($Q){return
gzencode($Q);}function
db_size($l){global$f;if(!$f->select_db($l))return"?";$I=0;foreach(table_status()as$S)$I+=$S["Data_length"]+$S["Index_length"];return
format_number($I);}function
set_utf8mb4($h){global$f;static$O=false;if(!$O&&preg_match('~\butf8mb4~i',$h)){$O=true;echo"SET NAMES ".charset($f).";\n\n";}}function
connect_error(){global$b,$f,$di,$n,$dc;if(DB!=""){header("HTTP/1.1 404 Not Found");page_header('è³‡æ–™åº«'.": ".h(DB),'ç„¡æ•ˆçš„è³‡æ–™åº«ã€‚',true);}else{if($_POST["db"]&&!$n)queries_redirect(substr(ME,0,-1),'è³‡æ–™åº«å·²åˆªé™¤ã€‚',drop_databases($_POST["db"]));page_header('é¸æ“‡è³‡æ–™åº«',$n,false);echo"<p class='links'>\n";foreach(array('database'=>'å»ºç«‹è³‡æ–™åº«','privileges'=>'æ¬Šé™','processlist'=>'è™•ç†ç¨‹åºåˆ—è¡¨','variables'=>'è®Šæ•¸','status'=>'ç‹€æ…‹',)as$y=>$X){if(support($y))echo"<a href='".h(ME)."$y='>$X</a>\n";}echo"<p>".sprintf('%sç‰ˆæœ¬ï¼š%s é€éPHPæ“´å……æ¨¡çµ„ %s',$dc[DRIVER],"<b>".h($f->server_info)."</b>","<b>$f->extension</b>")."\n","<p>".sprintf('ç™»éŒ„ç‚ºï¼š%s',"<b>".h(logged_user())."</b>")."\n";$k=$b->databases();if($k){$Sg=support("scheme");$pb=collations();echo"<form action='' method='post'>\n","<table cellspacing='0' class='checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),"<thead><tr>".(support("database")?"<td>&nbsp;":"")."<th>".'è³‡æ–™åº«'." - <a href='".h(ME)."refresh=1'>".'é‡æ–°è¼‰å…¥'."</a>"."<td>".'æ ¡å°'."<td>".'è³‡æ–™è¡¨'."<td>".'Size'." - <a href='".h(ME)."dbsize=1'>".'Compute'."</a>".script("qsl('a').onclick = partial(ajaxSetHtml, '".js_escape(ME)."script=connect');","")."</thead>\n";$k=($_GET["dbsize"]?count_tables($k):array_flip($k));foreach($k
as$l=>$T){$Kg=h(ME)."db=".urlencode($l);$t=h("Db-".$l);echo"<tr".odd().">".(support("database")?"<td>".checkbox("db[]",$l,in_array($l,(array)$_POST["db"]),"","","",$t):""),"<th><a href='$Kg' id='$t'>".h($l)."</a>";$ob=nbsp(db_collation($l,$pb));echo"<td>".(support("database")?"<a href='$Kg".($Sg?"&amp;ns=":"")."&amp;database=' title='".'ä¿®æ”¹è³‡æ–™åº«'."'>$ob</a>":$ob),"<td align='right'><a href='$Kg&amp;schema=' id='tables-".h($l)."' title='".'è³‡æ–™åº«æ¶æ§‹'."'>".($_GET["dbsize"]?$T:"?")."</a>","<td align='right' id='size-".h($l)."'>".($_GET["dbsize"]?db_size($l):"?"),"\n";}echo"</table>\n",(support("database")?"<div class='footer'><div>\n"."<fieldset><legend>".'Selected'." <span id='selected'></span></legend><div>\n"."<input type='hidden' name='all' value=''>".script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };")."<input type='submit' name='drop' value='".'åˆªé™¤'."'>".confirm()."\n"."</div></fieldset>\n"."</div></div>\n":""),"<input type='hidden' name='token' value='$di'>\n","</form>\n",script("tableCheck();");}}page_footer("db");}if(isset($_GET["status"]))$_GET["variables"]=$_GET["status"];if(isset($_GET["import"]))$_GET["sql"]=$_GET["import"];if(!(DB!=""?$f->select_db(DB):isset($_GET["sql"])||isset($_GET["dump"])||isset($_GET["database"])||isset($_GET["processlist"])||isset($_GET["privileges"])||isset($_GET["user"])||isset($_GET["variables"])||$_GET["script"]=="connect"||$_GET["script"]=="kill")){if(DB!=""||$_GET["refresh"]){restart_session();set_session("dbs",null);}connect_error();exit;}if(support("scheme")&&DB!=""&&$_GET["ns"]!==""){if(!isset($_GET["ns"]))adm_redirect(preg_replace('~ns=[^&]*&~','',ME)."ns=".get_schema());if(!set_schema($_GET["ns"])){header("HTTP/1.1 404 Not Found");page_header('è³‡æ–™è¡¨çµæ§‹'.": ".h($_GET["ns"]),'ç„¡æ•ˆçš„è³‡æ–™è¡¨çµæ§‹ã€‚',true);page_footer("ns");exit;}}$hf="RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";class
TmpFile{var$handler;var$size;function
__construct(){$this->handler=tmpfile();}function
write($_b){$this->size+=strlen($_b);fwrite($this->handler,$_b);}function
send(){fseek($this->handler,0);fpassthru($this->handler);fclose($this->handler);}}$vc="'(?:''|[^'\\\\]|\\\\.)*'";$Ld="IN|OUT|INOUT";if(isset($_GET["select"])&&($_POST["edit"]||$_POST["clone"])&&!$_POST["save"])$_GET["edit"]=$_GET["select"];if(isset($_GET["callf"]))$_GET["call"]=$_GET["callf"];if(isset($_GET["function"]))$_GET["procedure"]=$_GET["function"];if(isset($_GET["download"])){$a=$_GET["download"];$p=fields($a);header("Content-Type: application/octet-stream");header("Content-Disposition: attachment; filename=".friendly_url("$a-".implode("_",$_GET["where"])).".".friendly_url($_GET["field"]));$L=array(idf_escape($_GET["field"]));$H=$m->select($a,$L,array(where($_GET,$p)),$L);$J=($H?$H->fetch_row():array());echo$m->value($J[0],$p[$_GET["field"]]);exit;}elseif(isset($_GET["table"])){$a=$_GET["table"];$p=fields($a);if(!$p)$n=error();$S=table_status1($a,true);$C=$b->tableName($S);page_header(($p&&is_view($S)?$S['Engine']=='materialized view'?'Materialized view':'æª¢è¦–è¡¨':'è³‡æ–™è¡¨').": ".($C!=""?$C:h($a)),$n);$b->selectLinks($S);$ub=$S["Comment"];if($ub!="")echo"<p class='nowrap'>".'è¨»è§£'.": ".h($ub)."\n";if($p)$b->tableStructurePrint($p);if(!is_view($S)){if(support("indexes")){echo"<h3 id='indexes'>".'ç´¢å¼•'."</h3>\n";$w=indexes($a);if($w)$b->tableIndexesPrint($w);echo'<p class="links"><a href="'.h(ME).'indexes='.urlencode($a).'">'.'ä¿®æ”¹ç´¢å¼•'."</a>\n";}if(fk_support($S)){echo"<h3 id='foreign-keys'>".'å¤–ä¾†éµ'."</h3>\n";$cd=foreign_keys($a);if($cd){echo"<table cellspacing='0'>\n","<thead><tr><th>".'ä¾†æº'."<td>".'ç›®æ¨™'."<td>".'ON DELETE'."<td>".'ON UPDATE'."<td>&nbsp;</thead>\n";foreach($cd
as$C=>$q){echo"<tr title='".h($C)."'>","<th><i>".implode("</i>, <i>",array_map('h',$q["source"]))."</i>","<td><a href='".h($q["db"]!=""?preg_replace('~db=[^&]*~',"db=".urlencode($q["db"]),ME):($q["ns"]!=""?preg_replace('~ns=[^&]*~',"ns=".urlencode($q["ns"]),ME):ME))."table=".urlencode($q["table"])."'>".($q["db"]!=""?"<b>".h($q["db"])."</b>.":"").($q["ns"]!=""?"<b>".h($q["ns"])."</b>.":"").h($q["table"])."</a>","(<i>".implode("</i>, <i>",array_map('h',$q["target"]))."</i>)","<td>".nbsp($q["on_delete"])."\n","<td>".nbsp($q["on_update"])."\n",'<td><a href="'.h(ME.'foreign='.urlencode($a).'&name='.urlencode($C)).'">'.'ä¿®æ”¹'.'</a>';}echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'foreign='.urlencode($a).'">'.'æ–°å¢å¤–ä¾†éµ'."</a>\n";}}if(support(is_view($S)?"view_trigger":"trigger")){echo"<h3 id='triggers'>".'è§¸ç™¼å™¨'."</h3>\n";$pi=triggers($a);if($pi){echo"<table cellspacing='0'>\n";foreach($pi
as$y=>$X)echo"<tr valign='top'><td>".h($X[0])."<td>".h($X[1])."<th>".h($y)."<td><a href='".h(ME.'trigger='.urlencode($a).'&name='.urlencode($y))."'>".'ä¿®æ”¹'."</a>\n";echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'trigger='.urlencode($a).'">'.'å»ºç«‹è§¸ç™¼å™¨'."</a>\n";}}elseif(isset($_GET["schema"])){page_header('è³‡æ–™åº«æ¶æ§‹',"",array(),h(DB.($_GET["ns"]?".$_GET[ns]":"")));$Gh=array();$Hh=array();$ea=($_GET["schema"]?$_GET["schema"]:$_COOKIE["adminer_schema-".str_replace(".","_",DB)]);preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~',$ea,$xe,PREG_SET_ORDER);foreach($xe
as$s=>$B){$Gh[$B[1]]=array($B[2],$B[3]);$Hh[]="\n\t'".js_escape($B[1])."': [ $B[2], $B[3] ]";}$ei=0;$Qa=-1;$Rg=array();$xg=array();$le=array();foreach(table_status('',true)as$R=>$S){if(is_view($S))continue;$Vf=0;$Rg[$R]["fields"]=array();foreach(fields($R)as$C=>$o){$Vf+=1.25;$o["pos"]=$Vf;$Rg[$R]["fields"][$C]=$o;}$Rg[$R]["pos"]=($Gh[$R]?$Gh[$R]:array($ei,0));foreach($b->foreignKeys($R)as$X){if(!$X["db"]){$je=$Qa;if($Gh[$R][1]||$Gh[$X["table"]][1])$je=min(floatval($Gh[$R][1]),floatval($Gh[$X["table"]][1]))-1;else$Qa-=.1;while($le[(string)$je])$je-=.0001;$Rg[$R]["references"][$X["table"]][(string)$je]=array($X["source"],$X["target"]);$xg[$X["table"]][$R][(string)$je]=$X["target"];$le[(string)$je]=true;}}$ei=max($ei,$Rg[$R]["pos"][0]+2.5+$Vf);}echo'<div id="schema" style="height: ',$ei,'em;">
<script',nonce(),'>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {',implode(",",$Hh)."\n",'};
var em = qs(\'#schema\').offsetHeight / ',$ei,';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'',js_escape(DB),'\');
</script>
';foreach($Rg
as$C=>$R){echo"<div class='table' style='top: ".$R["pos"][0]."em; left: ".$R["pos"][1]."em;'>",'<a href="'.h(ME).'table='.urlencode($C).'"><b>'.h($C)."</b></a>",script("qsl('div').onmousedown = schemaMousedown;");foreach($R["fields"]as$o){$X='<span'.type_class($o["type"]).' title="'.h($o["full_type"].($o["null"]?" NULL":'')).'">'.h($o["field"]).'</span>';echo"<br>".($o["primary"]?"<i>$X</i>":$X);}foreach((array)$R["references"]as$Nh=>$yg){foreach($yg
as$je=>$ug){$ke=$je-$Gh[$C][1];$s=0;foreach($ug[0]as$lh)echo"\n<div class='references' title='".h($Nh)."' id='refs$je-".($s++)."' style='left: $ke"."em; top: ".$R["fields"][$lh]["pos"]."em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: ".(-$ke)."em;'></div></div>";}}foreach((array)$xg[$C]as$Nh=>$yg){foreach($yg
as$je=>$e){$ke=$je-$Gh[$C][1];$s=0;foreach($e
as$Mh)echo"\n<div class='references' title='".h($Nh)."' id='refd$je-".($s++)."' style='left: $ke"."em; top: ".$R["fields"][$Mh]["pos"]."em; height: 1.25em; background: url(".h(preg_replace("~\\?.*~","",ME)."?file=arrow.gif) no-repeat right center;&version=4.6.2")."'><div style='height: .5em; border-bottom: 1px solid Gray; width: ".(-$ke)."em;'></div></div>";}}echo"\n</div>\n";}foreach($Rg
as$C=>$R){foreach((array)$R["references"]as$Nh=>$yg){foreach($yg
as$je=>$ug){$Le=$ei;$Ae=-10;foreach($ug[0]as$y=>$lh){$Wf=$R["pos"][0]+$R["fields"][$lh]["pos"];$Xf=$Rg[$Nh]["pos"][0]+$Rg[$Nh]["fields"][$ug[1][$y]]["pos"];$Le=min($Le,$Wf,$Xf);$Ae=max($Ae,$Wf,$Xf);}echo"<div class='references' id='refl$je' style='left: $je"."em; top: $Le"."em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: ".($Ae-$Le)."em;'></div></div>\n";}}}echo'</div>
<p class="links"><a href="',h(ME."schema=".urlencode($ea)),'" id="schema-link">æ°¸ä¹…é€£çµ</a>
';}elseif(isset($_GET["dump"])){$a=$_GET["dump"];if($_POST&&!$n){$Cb="";foreach(array("output","format","db_style","routines","events","table_style","auto_increment","triggers","data_style")as$y)$Cb.="&$y=".urlencode($_POST[$y]);adm_cookie("adminer_export",substr($Cb,1));$T=array_flip((array)$_POST["tables"])+array_flip((array)$_POST["data"]);$Hc=dump_headers((count($T)==1?key($T):DB),(DB==""||count($T)>1));$Td=preg_match('~sql~',$_POST["format"]);if($Td){echo"-- Adminer $ia ".$dc[DRIVER]." dump\n\n";if($x=="sql"){echo"SET NAMES utf8;
SET time_zone = '+00:00';
".($_POST["data_style"]?"SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
":"")."
";$f->query("SET time_zone = '+00:00';");}}$yh=$_POST["db_style"];$k=array(DB);if(DB==""){$k=$_POST["databases"];if(is_string($k))$k=explode("\n",rtrim(str_replace("\r","",$k),"\n"));}foreach((array)$k
as$l){$b->dumpDatabase($l);if($f->select_db($l)){if($Td&&preg_match('~CREATE~',$yh)&&($h=$f->result("SHOW CREATE DATABASE ".idf_escape($l),1))){set_utf8mb4($h);if($yh=="DROP+CREATE")echo"DROP DATABASE IF EXISTS ".idf_escape($l).";\n";echo"$h;\n";}if($Td){if($yh)echo
use_sql($l).";\n\n";$Af="";if($_POST["routines"]){foreach(array("FUNCTION","PROCEDURE")as$Lg){foreach(get_rows("SHOW $Lg STATUS WHERE Db = ".q($l),null,"-- ")as$J){$h=remove_definer($f->result("SHOW CREATE $Lg ".idf_escape($J["Name"]),2));set_utf8mb4($h);$Af.=($yh!='DROP+CREATE'?"DROP $Lg IF EXISTS ".idf_escape($J["Name"]).";;\n":"")."$h;;\n\n";}}}if($_POST["events"]){foreach(get_rows("SHOW EVENTS",null,"-- ")as$J){$h=remove_definer($f->result("SHOW CREATE EVENT ".idf_escape($J["Name"]),3));set_utf8mb4($h);$Af.=($yh!='DROP+CREATE'?"DROP EVENT IF EXISTS ".idf_escape($J["Name"]).";;\n":"")."$h;;\n\n";}}if($Af)echo"DELIMITER ;;\n\n$Af"."DELIMITER ;\n\n";}if($_POST["table_style"]||$_POST["data_style"]){$Pi=array();foreach(table_status('',true)as$C=>$S){$R=(DB==""||in_array($C,(array)$_POST["tables"]));$Kb=(DB==""||in_array($C,(array)$_POST["data"]));if($R||$Kb){if($Hc=="tar"){$ai=new
TmpFile;ob_start(array($ai,'write'),1e5);}$b->dumpTable($C,($R?$_POST["table_style"]:""),(is_view($S)?2:0));if(is_view($S))$Pi[]=$C;elseif($Kb){$p=fields($C);$b->dumpData($C,$_POST["data_style"],"SELECT *".convert_fields($p,$p)." FROM ".table($C));}if($Td&&$_POST["triggers"]&&$R&&($pi=trigger_sql($C)))echo"\nDELIMITER ;;\n$pi\nDELIMITER ;\n";if($Hc=="tar"){ob_end_flush();tar_file((DB!=""?"":"$l/")."$C.csv",$ai);}elseif($Td)echo"\n";}}foreach($Pi
as$Oi)$b->dumpTable($Oi,$_POST["table_style"],1);if($Hc=="tar")echo
pack("x512");}}}if($Td)echo"-- ".$f->result("SELECT NOW()")."\n";exit;}page_header('åŒ¯å‡º',$n,($_GET["export"]!=""?array("table"=>$_GET["export"]):array()),h(DB));echo'
<form action="" method="post">
<table cellspacing="0">
';$Ob=array('','USE','DROP+CREATE','CREATE');$Ih=array('','DROP+CREATE','CREATE');$Lb=array('','TRUNCATE+INSERT','INSERT');if($x=="sql")$Lb[]='INSERT+UPDATE';parse_str($_COOKIE["adminer_export"],$J);if(!$J)$J=array("output"=>"text","format"=>"sql","db_style"=>(DB!=""?"":"CREATE"),"table_style"=>"DROP+CREATE","data_style"=>"INSERT");if(!isset($J["events"])){$J["routines"]=$J["events"]=($_GET["dump"]=="");$J["triggers"]=$J["table_style"];}echo"<tr><th>".'è¼¸å‡º'."<td>".html_select("output",$b->dumpOutput(),$J["output"],0)."\n";echo"<tr><th>".'æ ¼å¼'."<td>".html_select("format",$b->dumpFormat(),$J["format"],0)."\n";echo($x=="sqlite"?"":"<tr><th>".'è³‡æ–™åº«'."<td>".html_select('db_style',$Ob,$J["db_style"]).(support("routine")?checkbox("routines",1,$J["routines"],'ç¨‹åº'):"").(support("event")?checkbox("events",1,$J["events"],'äº‹ä»¶'):"")),"<tr><th>".'è³‡æ–™è¡¨'."<td>".html_select('table_style',$Ih,$J["table_style"]).checkbox("auto_increment",1,$J["auto_increment"],'è‡ªå‹•éå¢').(support("trigger")?checkbox("triggers",1,$J["triggers"],'è§¸ç™¼å™¨'):""),"<tr><th>".'è³‡æ–™'."<td>".html_select('data_style',$Lb,$J["data_style"]),'</table>
<p><input type="submit" value="åŒ¯å‡º">
<input type="hidden" name="token" value="',$di,'">

<table cellspacing="0">
',script("qsl('table').onclick = dumpClick;");$ag=array();if(DB!=""){$eb=($a!=""?"":" checked");echo"<thead><tr>","<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$eb>".'è³‡æ–™è¡¨'."</label>".script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);",""),"<th style='text-align: right;'><label class='block'>".'è³‡æ–™'."<input type='checkbox' id='check-data'$eb></label>".script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);",""),"</thead>\n";$Pi="";$Jh=tables_list();foreach($Jh
as$C=>$U){$Zf=preg_replace('~_.*~','',$C);$eb=($a==""||$a==(substr($a,-1)=="%"?"$Zf%":$C));$dg="<tr><td>".checkbox("tables[]",$C,$eb,$C,"","block");if($U!==null&&!preg_match('~table~i',$U))$Pi.="$dg\n";else
echo"$dg<td align='right'><label class='block'><span id='Rows-".h($C)."'></span>".checkbox("data[]",$C,$eb)."</label>\n";$ag[$Zf]++;}echo$Pi;if($Jh)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}else{echo"<thead><tr><th style='text-align: left;'>","<label class='block'><input type='checkbox' id='check-databases'".($a==""?" checked":"").">".'è³‡æ–™åº«'."</label>",script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);",""),"</thead>\n";$k=$b->databases();if($k){foreach($k
as$l){if(!information_schema($l)){$Zf=preg_replace('~_.*~','',$l);echo"<tr><td>".checkbox("databases[]",$l,$a==""||$a=="$Zf%",$l,"","block")."\n";$ag[$Zf]++;}}}else
echo"<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";}echo'</table>
</form>
';$Vc=true;foreach($ag
as$y=>$X){if($y!=""&&$X>1){echo($Vc?"<p>":" ")."<a href='".h(ME)."dump=".urlencode("$y%")."'>".h($y)."</a>";$Vc=false;}}}elseif(isset($_GET["privileges"])){page_header('æ¬Šé™');echo'<p class="links"><a href="'.h(ME).'user=">'.'å»ºç«‹ä½¿ç”¨è€…'."</a>";$H=$f->query("SELECT User, Host FROM mysql.".(DB==""?"user":"db WHERE ".q(DB)." LIKE Db")." ORDER BY Host, User");$jd=$H;if(!$H)$H=$f->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");echo"<form action=''><p>\n";hidden_fields_get();echo"<input type='hidden' name='db' value='".h(DB)."'>\n",($jd?"":"<input type='hidden' name='grant' value=''>\n"),"<table cellspacing='0'>\n","<thead><tr><th>".'å¸³è™Ÿ'."<th>".'ä¼ºæœå™¨'."<th>&nbsp;</thead>\n";while($J=$H->fetch_assoc())echo'<tr'.odd().'><td>'.h($J["User"])."<td>".h($J["Host"]).'<td><a href="'.h(ME.'user='.urlencode($J["User"]).'&host='.urlencode($J["Host"])).'">'.'ç·¨è¼¯'."</a>\n";if(!$jd||DB!="")echo"<tr".odd()."><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='".'ç·¨è¼¯'."'>\n";echo"</table>\n","</form>\n";}elseif(isset($_GET["sql"])){if(!$n&&$_POST["export"]){dump_headers("sql");$b->dumpTable("","");$b->dumpData("","table",$_POST["query"]);exit;}restart_session();$vd=&get_session("queries");$ud=&$vd[DB];if(!$n&&$_POST["clear"]){$ud=array();adm_redirect(remove_from_uri("history"));}page_header((isset($_GET["import"])?'åŒ¯å…¥':'SQLå‘½ä»¤'),$n);if(!$n&&$_POST){$gd=false;if(!isset($_GET["import"]))$G=$_POST["query"];elseif($_POST["webfile"]){$ph=$b->importServerPath();$gd=@fopen((file_exists($ph)?$ph:"compress.zlib://$ph.gz"),"rb");$G=($gd?fread($gd,1e6):false);}else$G=get_file("sql_file",true);if(is_string($G)){if(function_exists('memory_get_usage'))@ini_set("memory_limit",max(ini_bytes("memory_limit"),2*strlen($G)+memory_get_usage()+8e6));if($G!=""&&strlen($G)<1e6){$lg=$G.(preg_match("~;[ \t\r\n]*\$~",$G)?"":";");if(!$ud||reset(end($ud))!=$lg){restart_session();$ud[]=array($lg,time());set_session("queries",$vd);stop_session();}}$mh="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$Ub=";";$D=0;$sc=true;$g=connect();if(is_object($g)&&DB!="")$g->select_db(DB);$tb=0;$xc=array();$Hf='[\'"'.($x=="sql"?'`#':($x=="sqlite"?'`[':($x=="mssql"?'[':''))).']|/\\*|-- |$'.($x=="pgsql"?'|\\$[^$]*\\$':'');$fi=microtime(true);parse_str($_COOKIE["adminer_export"],$xa);$jc=$b->dumpFormat();unset($jc["sql"]);while($G!=""){if(!$D&&preg_match("~^$mh*+DELIMITER\\s+(\\S+)~i",$G,$B)){$Ub=$B[1];$G=substr($G,strlen($B[0]));}else{preg_match('('.preg_quote($Ub)."\\s*|$Hf)",$G,$B,PREG_OFFSET_CAPTURE,$D);list($ed,$Vf)=$B[0];if(!$ed&&$gd&&!feof($gd))$G.=fread($gd,1e5);else{if(!$ed&&rtrim($G)=="")break;$D=$Vf+strlen($ed);if($ed&&rtrim($ed)!=$Ub){while(preg_match('('.($ed=='/*'?'\\*/':($ed=='['?']':(preg_match('~^-- |^#~',$ed)?"\n":preg_quote($ed)."|\\\\."))).'|$)s',$G,$B,PREG_OFFSET_CAPTURE,$D)){$Pg=$B[0][0];if(!$Pg&&$gd&&!feof($gd))$G.=fread($gd,1e5);else{$D=$B[0][1]+strlen($Pg);if($Pg[0]!="\\")break;}}}else{$sc=false;$lg=substr($G,0,$Vf);$tb++;$dg="<pre id='sql-$tb'><code class='jush-$x'>".$b->sqlCommandQuery($lg)."</code></pre>\n";if($x=="sqlite"&&preg_match("~^$mh*+ATTACH\\b~i",$lg,$B)){echo$dg,"<p class='error'>".'ATTACH queries are not supported.'."\n";$xc[]=" <a href='#sql-$tb'>$tb</a>";if($_POST["error_stops"])break;}else{if(!$_POST["only_errors"]){echo$dg;ob_flush();flush();}$th=microtime(true);if($f->multi_query($lg)&&is_object($g)&&preg_match("~^$mh*+USE\\b~i",$lg))$g->query($lg);do{$H=$f->store_result();if($f->error){echo($_POST["only_errors"]?$dg:""),"<p class='error'>".'æŸ¥è©¢ç™¼ç”ŸéŒ¯èª¤'.($f->errno?" ($f->errno)":"").": ".error()."\n";$xc[]=" <a href='#sql-$tb'>$tb</a>";if($_POST["error_stops"])break
2;}else{$Th=" <span class='time'>(".format_time($th).")</span>".(strlen($lg)<1000?" <a href='".h(ME)."sql=".urlencode(trim($lg))."'>".'ç·¨è¼¯'."</a>":"");$za=$f->affected_rows;$Si=($_POST["only_errors"]?"":$m->warnings());$Ti="warnings-$tb";if($Si)$Th.=", <a href='#$Ti'>".'Warnings'."</a>".script("qsl('a').onclick = partial(toggle, '$Ti');","");$Ec=null;$Fc="explain-$tb";if(is_object($H)){$z=$_POST["limit"];$uf=select($H,$g,array(),$z);if(!$_POST["only_errors"]){echo"<form action='' method='post'>\n";$Xe=$H->num_rows;echo"<p>".($Xe?($z&&$Xe>$z?sprintf('%d / ',$z):"").sprintf('%dè¡Œ',$Xe):""),$Th;if($g&&preg_match("~^($mh|\\()*+SELECT\\b~i",$lg)&&($Ec=explain($g,$lg)))echo", <a href='#$Fc'>Explain</a>".script("qsl('a').onclick = partial(toggle, '$Fc');","");$t="export-$tb";echo", <a href='#$t'>".'åŒ¯å‡º'."</a>".script("qsl('a').onclick = partial(toggle, '$t');","")."<span id='$t' class='hidden'>: ".html_select("output",$b->dumpOutput(),$xa["output"])." ".html_select("format",$jc,$xa["format"])."<input type='hidden' name='query' value='".h($lg)."'>"." <input type='submit' name='export' value='".'åŒ¯å‡º'."'><input type='hidden' name='token' value='$di'></span>\n"."</form>\n";}}else{if(preg_match("~^$mh*+(CREATE|DROP|ALTER)$mh++(DATABASE|SCHEMA)\\b~i",$lg)){restart_session();set_session("dbs",null);stop_session();}if(!$_POST["only_errors"])echo"<p class='message' title='".h($f->info)."'>".sprintf('åŸ·è¡ŒæŸ¥è©¢OKï¼Œ%dè¡Œå—å½±éŸ¿',$za)."$Th\n";}echo($Si?"<div id='$Ti' class='hidden'>\n$Si</div>\n":"");if($Ec){echo"<div id='$Fc' class='hidden'>\n";select($Ec,$g,$uf);echo"</div>\n";}}$th=microtime(true);}while($f->next_result());}$G=substr($G,$D);$D=0;}}}}if($sc)echo"<p class='message'>".'æ²’æœ‰å‘½ä»¤å¯åŸ·è¡Œã€‚'."\n";elseif($_POST["only_errors"]){echo"<p class='message'>".sprintf('å·²é †åˆ©åŸ·è¡Œ %d å€‹æŸ¥è©¢ã€‚',$tb-count($xc))," <span class='time'>(".format_time($fi).")</span>\n";}elseif($xc&&$tb>1)echo"<p class='error'>".'æŸ¥è©¢ç™¼ç”ŸéŒ¯èª¤'.": ".implode("",$xc)."\n";}else
echo"<p class='error'>".upload_error($G)."\n";}echo'
<form action="" method="post" enctype="multipart/form-data" id="form">
';$Bc="<input type='submit' value='".'åŸ·è¡Œ'."' title='Ctrl+Enter'>";if(!isset($_GET["import"])){$lg=$_GET["sql"];if($_POST)$lg=$_POST["query"];elseif($_GET["history"]=="all")$lg=$ud;elseif($_GET["history"]!="")$lg=$ud[$_GET["history"]][0];echo"<p>";textarea("query",$lg,20);echo($_POST?"":script("qs('textarea').focus();")),"<p>$Bc\n",'Limit rows'.": <input type='number' name='limit' class='size' value='".h($_POST?$_POST["limit"]:$_GET["limit"])."'>\n";}else{echo"<fieldset><legend>".'æª”æ¡ˆä¸Šå‚³'."</legend><div>",(ini_bool("file_uploads")?"SQL (&lt; ".ini_get("upload_max_filesize")."B): <input type='file' name='sql_file[]' multiple>\n$Bc":'æª”æ¡ˆä¸Šå‚³å·²ç¶“è¢«åœç”¨ã€‚'),"</div></fieldset>\n","<fieldset><legend>".'å¾ä¼ºæœå™¨'."</legend><div>",sprintf('ç¶²é ä¼ºæœå™¨æª”æ¡ˆ %s',"<code>".h($b->importServerPath()).(extension_loaded("zlib")?"[.gz]":"")."</code>"),' <input type="submit" name="webfile" value="'.'åŸ·è¡Œæª”æ¡ˆ'.'">',"</div></fieldset>\n","<p>";}echo
checkbox("error_stops",1,($_POST?$_POST["error_stops"]:isset($_GET["import"])),'å‡ºéŒ¯æ™‚åœæ­¢')."\n",checkbox("only_errors",1,($_POST?$_POST["only_errors"]:isset($_GET["import"])),'åƒ…é¡¯ç¤ºéŒ¯èª¤è¨Šæ¯')."\n","<input type='hidden' name='token' value='$di'>\n";if(!isset($_GET["import"])&&$ud){print_fieldset("history",'ç´€éŒ„',$_GET["history"]!="");for($X=end($ud);$X;$X=prev($ud)){$y=key($ud);list($lg,$Th,$nc)=$X;echo'<a href="'.h(ME."sql=&history=$y").'">'.'ç·¨è¼¯'."</a>"." <span class='time' title='".@date('Y-m-d',$Th)."'>".@date("H:i:s",$Th)."</span>"." <code class='jush-$x'>".shorten_utf8(ltrim(str_replace("\n"," ",str_replace("\r","",preg_replace('~^(#|-- ).*~m','',$lg)))),80,"</code>").($nc?" <span class='time'>($nc)</span>":"")."<br>\n";}echo"<input type='submit' name='clear' value='".'æ¸…é™¤'."'>\n","<a href='".h(ME."sql=&history=all")."'>".'ç·¨è¼¯å…¨éƒ¨'."</a>\n","</div></fieldset>\n";}echo'</form>
';}elseif(isset($_GET["edit"])){$a=$_GET["edit"];$p=fields($a);$Z=(isset($_GET["select"])?($_POST["check"]&&count($_POST["check"])==1?where_check($_POST["check"][0],$p):""):where($_GET,$p));$_i=(isset($_GET["select"])?$_POST["edit"]:$Z);foreach($p
as$C=>$o){if(!isset($o["privileges"][$_i?"update":"insert"])||$b->fieldName($o)=="")unset($p[$C]);}if($_POST&&!$n&&!isset($_GET["select"])){$A=$_POST["referer"];if($_POST["insert"])$A=($_i?null:$_SERVER["REQUEST_URI"]);elseif(!preg_match('~^.+&select=.+$~',$A))$A=ME."select=".urlencode($a);$w=indexes($a);$vi=unique_array($_GET["where"],$w);$og="\nWHERE $Z";if(isset($_POST["delete"]))queries_redirect($A,'è©²é …ç›®å·²è¢«åˆªé™¤',$m->delete($a,$og,!$vi));else{$O=array();foreach($p
as$C=>$o){$X=process_input($o);if($X!==false&&$X!==null)$O[idf_escape($C)]=$X;}if($_i){if(!$O)adm_redirect($A);queries_redirect($A,'å·²æ›´æ–°é …ç›®ã€‚',$m->update($a,$O,$og,!$vi));if(is_ajax()){page_headers();page_messages($n);exit;}}else{$H=$m->insert($a,$O);$ie=($H?last_id():0);queries_redirect($A,sprintf('å·²æ–°å¢é …ç›®%sã€‚',($ie?" $ie":"")),$H);}}}$J=null;if($_POST["save"])$J=(array)$_POST["fields"];elseif($Z){$L=array();foreach($p
as$C=>$o){if(isset($o["privileges"]["select"])){$Ga=convert_field($o);if($_POST["clone"]&&$o["auto_increment"])$Ga="''";if($x=="sql"&&preg_match("~enum|set~",$o["type"]))$Ga="1*".idf_escape($C);$L[]=($Ga?"$Ga AS ":"").idf_escape($C);}}$J=array();if(!support("table"))$L=array("*");if($L){$H=$m->select($a,$L,array($Z),$L,array(),(isset($_GET["select"])?2:1));if(!$H)$n=error();else{$J=$H->fetch_assoc();if(!$J)$J=false;}if(isset($_GET["select"])&&(!$J||$H->fetch_assoc()))$J=null;}}if(!support("table")&&!$p){if(!$Z){$H=$m->select($a,array("*"),$Z,array("*"));$J=($H?$H->fetch_assoc():false);if(!$J)$J=array($m->primary=>"");}if($J){foreach($J
as$y=>$X){if(!$Z)$J[$y]=null;$p[$y]=array("field"=>$y,"null"=>($y!=$m->primary),"auto_increment"=>($y==$m->primary));}}}edit_form($a,$p,$J,$_i);}elseif(isset($_GET["create"])){$a=$_GET["create"];$Jf=array();foreach(array('HASH','LINEAR HASH','KEY','LINEAR KEY','RANGE','LIST')as$y)$Jf[$y]=$y;$wg=referencable_primary($a);$cd=array();foreach($wg
as$Eh=>$o)$cd[str_replace("`","``",$Eh)."`".str_replace("`","``",$o["field"])]=$Eh;$xf=array();$S=array();if($a!=""){$xf=fields($a);$S=table_status($a);if(!$S)$n='æ²’æœ‰è³‡æ–™è¡¨ã€‚';}$J=$_POST;$J["fields"]=(array)$J["fields"];if($J["auto_increment_col"])$J["fields"][$J["auto_increment_col"]]["auto_increment"]=true;if($_POST&&!process_fields($J["fields"])&&!$n){if($_POST["drop"])queries_redirect(substr(ME,0,-1),'å·²ç¶“åˆªé™¤è³‡æ–™è¡¨ã€‚',drop_tables(array($a)));else{$p=array();$Da=array();$Ei=false;$ad=array();$wf=reset($xf);$Aa=" FIRST";foreach($J["fields"]as$y=>$o){$q=$cd[$o["type"]];$qi=($q!==null?$wg[$q]:$o);if($o["field"]!=""){if(!$o["has_default"])$o["default"]=null;if($y==$J["auto_increment_col"])$o["auto_increment"]=true;$ig=process_field($o,$qi);$Da[]=array($o["orig"],$ig,$Aa);if($ig!=process_field($wf,$wf)){$p[]=array($o["orig"],$ig,$Aa);if($o["orig"]!=""||$Aa)$Ei=true;}if($q!==null)$ad[idf_escape($o["field"])]=($a!=""&&$x!="sqlite"?"ADD":" ").format_foreign_key(array('table'=>$cd[$o["type"]],'source'=>array($o["field"]),'target'=>array($qi["field"]),'on_delete'=>$o["on_delete"],));$Aa=" AFTER ".idf_escape($o["field"]);}elseif($o["orig"]!=""){$Ei=true;$p[]=array($o["orig"]);}if($o["orig"]!=""){$wf=next($xf);if(!$wf)$Aa="";}}$Lf="";if($Jf[$J["partition_by"]]){$Mf=array();if($J["partition_by"]=='RANGE'||$J["partition_by"]=='LIST'){foreach(array_filter($J["partition_names"])as$y=>$X){$Y=$J["partition_values"][$y];$Mf[]="\n  PARTITION ".idf_escape($X)." VALUES ".($J["partition_by"]=='RANGE'?"LESS THAN":"IN").($Y!=""?" ($Y)":" MAXVALUE");}}$Lf.="\nPARTITION BY $J[partition_by]($J[partition])".($Mf?" (".implode(",",$Mf)."\n)":($J["partitions"]?" PARTITIONS ".(+$J["partitions"]):""));}elseif(support("partitioning")&&preg_match("~partitioned~",$S["Create_options"]))$Lf.="\nREMOVE PARTITIONING";$Ee='è³‡æ–™è¡¨å·²ä¿®æ”¹ã€‚';if($a==""){adm_cookie("adminer_engine",$J["Engine"]);$Ee='è³‡æ–™è¡¨å·²ä¿®æ”¹ã€‚';}$C=trim($J["name"]);queries_redirect(ME.(support("table")?"table=":"select=").urlencode($C),$Ee,alter_table($a,$C,($x=="sqlite"&&($Ei||$ad)?$Da:$p),$ad,($J["Comment"]!=$S["Comment"]?$J["Comment"]:null),($J["Engine"]&&$J["Engine"]!=$S["Engine"]?$J["Engine"]:""),($J["Collation"]&&$J["Collation"]!=$S["Collation"]?$J["Collation"]:""),($J["Auto_increment"]!=""?number($J["Auto_increment"]):""),$Lf));}}page_header(($a!=""?'ä¿®æ”¹è³‡æ–™è¡¨':'å»ºç«‹è³‡æ–™è¡¨'),$n,array("table"=>$a),h($a));if(!$_POST){$J=array("Engine"=>$_COOKIE["adminer_engine"],"fields"=>array(array("field"=>"","type"=>(isset($si["int"])?"int":(isset($si["integer"])?"integer":"")),"on_update"=>"")),"partition_names"=>array(""),);if($a!=""){$J=$S;$J["name"]=$a;$J["fields"]=array();if(!$_GET["auto_increment"])$J["Auto_increment"]="";foreach($xf
as$o){$o["has_default"]=isset($o["default"]);$J["fields"][]=$o;}if(support("partitioning")){$hd="FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = ".q(DB)." AND TABLE_NAME = ".q($a);$H=$f->query("SELECT PARTITION_METHOD, PARTITION_ORDINAL_POSITION, PARTITION_EXPRESSION $hd ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");list($J["partition_by"],$J["partitions"],$J["partition"])=$H->fetch_row();$Mf=get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $hd AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");$Mf[""]="";$J["partition_names"]=array_keys($Mf);$J["partition_values"]=array_values($Mf);}}}$pb=collations();$uc=engines();foreach($uc
as$tc){if(!strcasecmp($tc,$J["Engine"])){$J["Engine"]=$tc;break;}}echo'
<form action="" method="post" id="form">
<p>
';if(support("columns")||$a==""){echo'è³‡æ–™è¡¨åç¨±: <input name="name" maxlength="64" value="',h($J["name"]),'" autocapitalize="off">
';if($a==""&&!$_POST)echo
script("focus(qs('#form')['name']);");echo($uc?"<select name='Engine'>".optionlist(array(""=>"(".'å¼•æ“'.")")+$uc,$J["Engine"])."</select>".on_help("getTarget(event).value",1).script("qsl('select').onchange = helpClose;"):""),' ',($pb&&!preg_match("~sqlite|mssql~",$x)?html_select("Collation",array(""=>"(".'æ ¡å°'.")")+$pb,$J["Collation"]):""),' <input type="submit" value="å„²å­˜">
';}echo'
';if(support("columns")){echo'<table cellspacing="0" id="edit-fields" class="nowrap">
';$vb=($_POST?$_POST["comments"]:$J["Comment"]!="");if(!$_POST&&!$vb){foreach($J["fields"]as$o){if($o["comment"]!=""){$vb=true;break;}}}edit_fields($J["fields"],$pb,"TABLE",$cd,$vb);echo'</table>
<p>
è‡ªå‹•éå¢: <input type="number" name="Auto_increment" size="6" value="',h($J["Auto_increment"]),'">
',checkbox("defaults",1,!$_POST||$_POST["defaults"],'é è¨­å€¼',"columnShow(this.checked, 5)","jsonly"),($_POST?"":script("editingHideDefaults();")),(support("comment")?"<label><input type='checkbox' name='comments' value='1' class='jsonly'".($vb?" checked":"").">".'è¨»è§£'."</label>".script("qsl('input').onclick = partial(editingCommentsClick, true);").' <input name="Comment" value="'.h($J["Comment"]).'" maxlength="'.(min_version(5.5)?2048:60).'"'.($vb?'':' class="hidden"').'>':''),'<p>
<input type="submit" value="å„²å­˜">
';}echo'
';if($a!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('Drop %s?',$a));}if(support("partitioning")){$Kf=preg_match('~RANGE|LIST~',$J["partition_by"]);print_fieldset("partition",'åˆ†å€é¡å‹',$J["partition_by"]);echo'<p>
',"<select name='partition_by'>".optionlist(array(""=>"")+$Jf,$J["partition_by"])."</select>".on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')",1).script("qsl('select').onchange = partitionByChange;"),'(<input name="partition" value="',h($J["partition"]),'">)
åˆ†å€: <input type="number" name="partitions" class="size',($Kf||!$J["partition_by"]?" hidden":""),'" value="',h($J["partitions"]),'">
<table cellspacing="0" id="partition-table"',($Kf?"":" class='hidden'"),'>
<thead><tr><th>åˆ†å€åç¨±<th>å€¼</thead>
';foreach($J["partition_names"]as$y=>$X){echo'<tr>','<td><input name="partition_names[]" value="'.h($X).'" autocapitalize="off">',($y==count($J["partition_names"])-1?script("qsl('input').oninput = partitionNameChange;"):''),'<td><input name="partition_values[]" value="'.h($J["partition_values"][$y]).'">';}echo'</table>
</div></fieldset>
';}echo'<input type="hidden" name="token" value="',$di,'">
</form>
',script("qs('#form')['defaults'].onclick();".(support("comment")?" editingCommentsClick.call(qs('#form')['comments']);":""));}elseif(isset($_GET["indexes"])){$a=$_GET["indexes"];$Dd=array("PRIMARY","UNIQUE","INDEX");$S=table_status($a,true);if(preg_match('~MyISAM|M?aria'.(min_version(5.6,'10.0.5')?'|InnoDB':'').'~i',$S["Engine"]))$Dd[]="FULLTEXT";if(preg_match('~MyISAM|M?aria'.(min_version(5.7,'10.2.2')?'|InnoDB':'').'~i',$S["Engine"]))$Dd[]="SPATIAL";$w=indexes($a);$bg=array();if($x=="mongo"){$bg=$w["_id_"];unset($Dd[0]);unset($w["_id_"]);}$J=$_POST;if($_POST&&!$n&&!$_POST["add"]&&!$_POST["drop_col"]){$c=array();foreach($J["indexes"]as$v){$C=$v["name"];if(in_array($v["type"],$Dd)){$e=array();$oe=array();$Wb=array();$O=array();ksort($v["columns"]);foreach($v["columns"]as$y=>$d){if($d!=""){$ne=$v["lengths"][$y];$Vb=$v["descs"][$y];$O[]=idf_escape($d).($ne?"(".(+$ne).")":"").($Vb?" DESC":"");$e[]=$d;$oe[]=($ne?$ne:null);$Wb[]=$Vb;}}if($e){$Cc=$w[$C];if($Cc){ksort($Cc["columns"]);ksort($Cc["lengths"]);ksort($Cc["descs"]);if($v["type"]==$Cc["type"]&&array_values($Cc["columns"])===$e&&(!$Cc["lengths"]||array_values($Cc["lengths"])===$oe)&&array_values($Cc["descs"])===$Wb){unset($w[$C]);continue;}}$c[]=array($v["type"],$C,$O);}}}foreach($w
as$C=>$Cc)$c[]=array($Cc["type"],$C,"DROP");if(!$c)adm_redirect(ME."table=".urlencode($a));queries_redirect(ME."table=".urlencode($a),'å·²ä¿®æ”¹ç´¢å¼•ã€‚',alter_indexes($a,$c));}page_header('ç´¢å¼•',$n,array("table"=>$a),h($a));$p=array_keys(fields($a));if($_POST["add"]){foreach($J["indexes"]as$y=>$v){if($v["columns"][count($v["columns"])]!="")$J["indexes"][$y]["columns"][]="";}$v=end($J["indexes"]);if($v["type"]||array_filter($v["columns"],'strlen'))$J["indexes"][]=array("columns"=>array(1=>""));}if(!$J){foreach($w
as$y=>$v){$w[$y]["name"]=$y;$w[$y]["columns"][]="";}$w[]=array("columns"=>array(1=>""));$J["indexes"]=$w;}?>

<form action="" method="post">
<table cellspacing="0" class="nowrap">
<thead><tr>
<th id="label-type">ç´¢å¼•é¡å‹
<th><input type="submit" class="wayoff">åˆ—ï¼ˆé•·åº¦ï¼‰
<th id="label-name">åç¨±
<th><noscript><input type='image' class='icon' name='add[0]' src='" . h(preg_replace("~\\?.*~", "", ME) . "?file=plus.gif&version=4.6.2") . "' alt='+' title='æ–°å¢ä¸‹ä¸€ç­†'></noscript>&nbsp;
</thead>
<?php
if($bg){echo"<tr><td>PRIMARY<td>";foreach($bg["columns"]as$y=>$d){echo
select_input(" disabled",$p,$d),"<label><input disabled type='checkbox'>".'é™å†ª(éæ¸›)'."</label> ";}echo"<td><td>\n";}$Wd=1;foreach($J["indexes"]as$v){if(!$_POST["drop_col"]||$Wd!=key($_POST["drop_col"])){echo"<tr><td>".html_select("indexes[$Wd][type]",array(-1=>"")+$Dd,$v["type"],($Wd==count($J["indexes"])?"indexesAddRow.call(this);":1),"label-type"),"<td>";ksort($v["columns"]);$s=1;foreach($v["columns"]as$y=>$d){echo"<span>".select_input(" name='indexes[$Wd][columns][$s]' title='".'åˆ—'."'",($p?array_combine($p,$p):$p),$d,"partial(".($s==count($v["columns"])?"indexesAddColumn":"indexesChangeColumn").", '".js_escape($x=="sql"?"":$_GET["indexes"]."_")."')"),($x=="sql"||$x=="mssql"?"<input type='number' name='indexes[$Wd][lengths][$s]' class='size' value='".h($v["lengths"][$y])."' title='".'é•·åº¦'."'>":""),($x!="sql"?checkbox("indexes[$Wd][descs][$s]",1,$v["descs"][$y],'é™å†ª(éæ¸›)'):"")," </span>";$s++;}echo"<td><input name='indexes[$Wd][name]' value='".h($v["name"])."' autocapitalize='off' aria-labelledby='label-name'>\n","<td><input type='image' class='icon' name='drop_col[$Wd]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=4.6.2")."' alt='x' title='".'ç§»é™¤'."'>".script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");}$Wd++;}echo'</table>
<p>
<input type="submit" value="å„²å­˜">
<input type="hidden" name="token" value="',$di,'">
</form>
';}elseif(isset($_GET["database"])){$J=$_POST;if($_POST&&!$n&&!isset($_POST["add_x"])){$C=trim($J["name"]);if($_POST["drop"]){$_GET["db"]="";queries_redirect(remove_from_uri("db|database"),'è³‡æ–™åº«å·²åˆªé™¤ã€‚',drop_databases(array(DB)));}elseif(DB!==$C){if(DB!=""){$_GET["db"]=$C;queries_redirect(preg_replace('~\bdb=[^&]*&~','',ME)."db=".urlencode($C),'å·²é‡æ–°å‘½åè³‡æ–™åº«ã€‚',rename_database($C,$J["collation"]));}else{$k=explode("\n",str_replace("\r","",$C));$zh=true;$he="";foreach($k
as$l){if(count($k)==1||$l!=""){if(!create_database($l,$J["collation"]))$zh=false;$he=$l;}}restart_session();set_session("dbs",null);queries_redirect(ME."db=".urlencode($he),'å·²å»ºç«‹è³‡æ–™åº«ã€‚',$zh);}}else{if(!$J["collation"])adm_redirect(substr(ME,0,-1));query_redirect("ALTER DATABASE ".idf_escape($C).(preg_match('~^[a-z0-9_]+$~i',$J["collation"])?" COLLATE $J[collation]":""),substr(ME,0,-1),'å·²ä¿®æ”¹è³‡æ–™åº«ã€‚');}}page_header(DB!=""?'ä¿®æ”¹è³‡æ–™åº«':'å»ºç«‹è³‡æ–™åº«',$n,array(),h(DB));$pb=collations();$C=DB;if($_POST)$C=$J["name"];elseif(DB!="")$J["collation"]=db_collation(DB,$pb);elseif($x=="sql"){foreach(get_vals("SHOW GRANTS")as$jd){if(preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\\.\\*)?~',$jd,$B)&&$B[1]){$C=stripcslashes(idf_unescape("`$B[2]`"));break;}}}echo'
<form action="" method="post">
<p>
',($_POST["add_x"]||strpos($C,"\n")?'<textarea id="name" name="name" rows="10" cols="40">'.h($C).'</textarea><br>':'<input name="name" id="name" value="'.h($C).'" maxlength="64" autocapitalize="off">')."\n".($pb?html_select("collation",array(""=>"(".'æ ¡å°'.")")+$pb,$J["collation"]).doc_link(array('sql'=>"charset-charsets.html",'mariadb'=>"supported-character-sets-and-collations/",'mssql'=>"ms187963.aspx",)):""),script("focus(qs('#name'));"),'<input type="submit" value="å„²å­˜">
';if(DB!="")echo"<input type='submit' name='drop' value='".'åˆªé™¤'."'>".confirm(sprintf('Drop %s?',DB))."\n";elseif(!$_POST["add_x"]&&$_GET["db"]=="")echo"<input type='image' class='icon' name='add' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=4.6.2")."' alt='+' title='".'æ–°å¢ä¸‹ä¸€ç­†'."'>\n";echo'<input type="hidden" name="token" value="',$di,'">
</form>
';}elseif(isset($_GET["scheme"])){$J=$_POST;if($_POST&&!$n){$_=preg_replace('~ns=[^&]*&~','',ME)."ns=";if($_POST["drop"])query_redirect("DROP SCHEMA ".idf_escape($_GET["ns"]),$_,'å·²åˆªé™¤è³‡æ–™è¡¨çµæ§‹ã€‚');else{$C=trim($J["name"]);$_.=urlencode($C);if($_GET["ns"]=="")query_redirect("CREATE SCHEMA ".idf_escape($C),$_,'å·²å»ºç«‹è³‡æ–™è¡¨çµæ§‹ã€‚');elseif($_GET["ns"]!=$C)query_redirect("ALTER SCHEMA ".idf_escape($_GET["ns"])." RENAME TO ".idf_escape($C),$_,'å·²ä¿®æ”¹è³‡æ–™è¡¨çµæ§‹ã€‚');else
adm_redirect($_);}}page_header($_GET["ns"]!=""?'ä¿®æ”¹è³‡æ–™è¡¨çµæ§‹':'å»ºç«‹è³‡æ–™è¡¨çµæ§‹',$n);if(!$J)$J["name"]=$_GET["ns"];echo'
<form action="" method="post">
<p><input name="name" id="name" value="',h($J["name"]),'" autocapitalize="off">
',script("focus(qs('#name'));"),'<input type="submit" value="å„²å­˜">
';if($_GET["ns"]!="")echo"<input type='submit' name='drop' value='".'åˆªé™¤'."'>".confirm(sprintf('Drop %s?',$_GET["ns"]))."\n";echo'<input type="hidden" name="token" value="',$di,'">
</form>
';}elseif(isset($_GET["call"])){$da=($_GET["name"]?$_GET["name"]:$_GET["call"]);page_header('å‘¼å«'.": ".h($da),$n);$Lg=routine($_GET["call"],(isset($_GET["callf"])?"FUNCTION":"PROCEDURE"));$Bd=array();$Af=array();foreach($Lg["fields"]as$s=>$o){if(substr($o["inout"],-3)=="OUT")$Af[$s]="@".idf_escape($o["field"])." AS ".idf_escape($o["field"]);if(!$o["inout"]||substr($o["inout"],0,2)=="IN")$Bd[]=$s;}if(!$n&&$_POST){$Za=array();foreach($Lg["fields"]as$y=>$o){if(in_array($y,$Bd)){$X=process_input($o);if($X===false)$X="''";if(isset($Af[$y]))$f->query("SET @".idf_escape($o["field"])." = $X");}$Za[]=(isset($Af[$y])?"@".idf_escape($o["field"]):$X);}$G=(isset($_GET["callf"])?"SELECT":"CALL")." ".table($da)."(".implode(", ",$Za).")";$th=microtime(true);$H=$f->multi_query($G);$za=$f->affected_rows;echo$b->selectQuery($G,$th,!$H);if(!$H)echo"<p class='error'>".error()."\n";else{$g=connect();if(is_object($g))$g->select_db(DB);do{$H=$f->store_result();if(is_object($H))select($H,$g);else
echo"<p class='message'>".sprintf('ç¨‹åºå·²è¢«åŸ·è¡Œï¼Œ%dè¡Œè¢«å½±éŸ¿',$za)."\n";}while($f->next_result());if($Af)select($f->query("SELECT ".implode(", ",$Af)));}}echo'
<form action="" method="post">
';if($Bd){echo"<table cellspacing='0'>\n";foreach($Bd
as$y){$o=$Lg["fields"][$y];$C=$o["field"];echo"<tr><th>".$b->fieldName($o);$Y=$_POST["fields"][$C];if($Y!=""){if($o["type"]=="enum")$Y=+$Y;if($o["type"]=="set")$Y=array_sum($Y);}input($o,$Y,(string)$_POST["function"][$C]);echo"\n";}echo"</table>\n";}echo'<p>
<input type="submit" value="å‘¼å«">
<input type="hidden" name="token" value="',$di,'">
</form>
';}elseif(isset($_GET["foreign"])){$a=$_GET["foreign"];$C=$_GET["name"];$J=$_POST;if($_POST&&!$n&&!$_POST["add"]&&!$_POST["change"]&&!$_POST["change-js"]){$Ee=($_POST["drop"]?'å·²åˆªé™¤å¤–ä¾†éµã€‚':($C!=""?'å·²ä¿®æ”¹å¤–ä¾†éµã€‚':'å·²å»ºç«‹å¤–ä¾†éµã€‚'));$A=ME."table=".urlencode($a);if(!$_POST["drop"]){$J["source"]=array_filter($J["source"],'strlen');ksort($J["source"]);$Mh=array();foreach($J["source"]as$y=>$X)$Mh[$y]=$J["target"][$y];$J["target"]=$Mh;}if($x=="sqlite")queries_redirect($A,$Ee,recreate_table($a,$a,array(),array(),array(" $C"=>($_POST["drop"]?"":" ".format_foreign_key($J)))));else{$c="ALTER TABLE ".table($a);$ec="\nDROP ".($x=="sql"?"FOREIGN KEY ":"CONSTRAINT ").idf_escape($C);if($_POST["drop"])query_redirect($c.$ec,$A,$Ee);else{query_redirect($c.($C!=""?"$ec,":"")."\nADD".format_foreign_key($J),$A,$Ee);$n='ä¾†æºåˆ—å’Œç›®æ¨™åˆ—å¿…é ˆå…·æœ‰ç›¸åŒçš„è³‡æ–™é¡å‹ï¼Œåœ¨ç›®æ¨™åˆ—ä¸Šå¿…é ˆæœ‰ä¸€å€‹ç´¢å¼•ä¸¦ä¸”å¼•ç”¨çš„è³‡æ–™å¿…é ˆå­˜åœ¨ã€‚'."<br>$n";}}}page_header('å¤–ä¾†éµ',$n,array("table"=>$a),h($a));if($_POST){ksort($J["source"]);if($_POST["add"])$J["source"][]="";elseif($_POST["change"]||$_POST["change-js"])$J["target"]=array();}elseif($C!=""){$cd=foreign_keys($a);$J=$cd[$C];$J["source"][]="";}else{$J["table"]=$a;$J["source"]=array("");}$lh=array_keys(fields($a));$Mh=($a===$J["table"]?$lh:array_keys(fields($J["table"])));$vg=array_keys(array_filter(table_status('',true),'fk_support'));echo'
<form action="" method="post">
<p>
';if($J["db"]==""&&$J["ns"]==""){echo'ç›®æ¨™è³‡æ–™è¡¨:
',html_select("table",$vg,$J["table"],"this.form['change-js'].value = '1'; this.form.submit();"),'<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="ä¿®æ”¹"></noscript>
<table cellspacing="0">
<thead><tr><th id="label-source">ä¾†æº<th id="label-target">ç›®æ¨™</thead>
';$Wd=0;foreach($J["source"]as$y=>$X){echo"<tr>","<td>".html_select("source[".(+$y)."]",array(-1=>"")+$lh,$X,($Wd==count($J["source"])-1?"foreignAddRow.call(this);":1),"label-source"),"<td>".html_select("target[".(+$y)."]",$Mh,$J["target"][$y],1,"label-target");$Wd++;}echo'</table>
<p>
ON DELETE: ',html_select("on_delete",array(-1=>"")+explode("|",$hf),$J["on_delete"]),' ON UPDATE: ',html_select("on_update",array(-1=>"")+explode("|",$hf),$J["on_update"]),doc_link(array('sql'=>"innodb-foreign-key-constraints.html",'mariadb'=>"foreign-keys/",'pgsql'=>"sql-createtable.html#SQL-CREATETABLE-REFERENCES",'mssql'=>"ms174979.aspx",'oracle'=>"clauses002.htm#sthref2903",)),'<p>
<input type="submit" value="å„²å­˜">
<noscript><p><input type="submit" name="add" value="æ–°å¢è³‡æ–™åˆ—"></noscript>
';}if($C!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('Drop %s?',$C));}echo'<input type="hidden" name="token" value="',$di,'">
</form>
';}elseif(isset($_GET["view"])){$a=$_GET["view"];$J=$_POST;$yf="VIEW";if($x=="pgsql"&&$a!=""){$P=table_status($a);$yf=strtoupper($P["Engine"]);}if($_POST&&!$n){$C=trim($J["name"]);$Ga=" AS\n$J[select]";$A=ME."table=".urlencode($C);$Ee='å·²ä¿®æ”¹æª¢è¦–è¡¨ã€‚';$U=($_POST["materialized"]?"MATERIALIZED VIEW":"VIEW");if(!$_POST["drop"]&&$a==$C&&$x!="sqlite"&&$U=="VIEW"&&$yf=="VIEW")query_redirect(($x=="mssql"?"ALTER":"CREATE OR REPLACE")." VIEW ".table($C).$Ga,$A,$Ee);else{$Oh=$C."_adminer_".uniqid();drop_create("DROP $yf ".table($a),"CREATE $U ".table($C).$Ga,"DROP $U ".table($C),"CREATE $U ".table($Oh).$Ga,"DROP $U ".table($Oh),($_POST["drop"]?substr(ME,0,-1):$A),'å·²åˆªé™¤æª¢è¦–è¡¨ã€‚',$Ee,'å·²å»ºç«‹æª¢è¦–è¡¨ã€‚',$a,$C);}}if(!$_POST&&$a!=""){$J=adm_view($a);$J["name"]=$a;$J["materialized"]=($yf!="VIEW");if(!$n)$n=error();}page_header(($a!=""?'ä¿®æ”¹æª¢è¦–è¡¨':'å»ºç«‹æª¢è¦–è¡¨'),$n,array("table"=>$a),h($a));echo'
<form action="" method="post">
<p>åç¨±: <input name="name" value="',h($J["name"]),'" maxlength="64" autocapitalize="off">
',(support("materializedview")?" ".checkbox("materialized",1,$J["materialized"],'Materialized view'):""),'<p>';textarea("select",$J["select"]);echo'<p>
<input type="submit" value="å„²å­˜">
';if($a!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('Drop %s?',$a));}echo'<input type="hidden" name="token" value="',$di,'">
</form>
';}elseif(isset($_GET["event"])){$aa=$_GET["event"];$Od=array("YEAR","QUARTER","MONTH","DAY","HOUR","MINUTE","WEEK","SECOND","YEAR_MONTH","DAY_HOUR","DAY_MINUTE","DAY_SECOND","HOUR_MINUTE","HOUR_SECOND","MINUTE_SECOND");$vh=array("ENABLED"=>"ENABLE","DISABLED"=>"DISABLE","SLAVESIDE_DISABLED"=>"DISABLE ON SLAVE");$J=$_POST;if($_POST&&!$n){if($_POST["drop"])query_redirect("DROP EVENT ".idf_escape($aa),substr(ME,0,-1),'å·²åˆªé™¤äº‹ä»¶ã€‚');elseif(in_array($J["INTERVAL_FIELD"],$Od)&&isset($vh[$J["STATUS"]])){$Qg="\nON SCHEDULE ".($J["INTERVAL_VALUE"]?"EVERY ".q($J["INTERVAL_VALUE"])." $J[INTERVAL_FIELD]".($J["STARTS"]?" STARTS ".q($J["STARTS"]):"").($J["ENDS"]?" ENDS ".q($J["ENDS"]):""):"AT ".q($J["STARTS"]))." ON COMPLETION".($J["ON_COMPLETION"]?"":" NOT")." PRESERVE";queries_redirect(substr(ME,0,-1),($aa!=""?'å·²ä¿®æ”¹äº‹ä»¶ã€‚':'å·²å»ºç«‹äº‹ä»¶ã€‚'),queries(($aa!=""?"ALTER EVENT ".idf_escape($aa).$Qg.($aa!=$J["EVENT_NAME"]?"\nRENAME TO ".idf_escape($J["EVENT_NAME"]):""):"CREATE EVENT ".idf_escape($J["EVENT_NAME"]).$Qg)."\n".$vh[$J["STATUS"]]." COMMENT ".q($J["EVENT_COMMENT"]).rtrim(" DO\n$J[EVENT_DEFINITION]",";").";"));}}page_header(($aa!=""?'ä¿®æ”¹äº‹ä»¶'.": ".h($aa):'å»ºç«‹äº‹ä»¶'),$n);if(!$J&&$aa!=""){$K=get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = ".q(DB)." AND EVENT_NAME = ".q($aa));$J=reset($K);}echo'
<form action="" method="post">
<table cellspacing="0">
<tr><th>åç¨±<td><input name="EVENT_NAME" value="',h($J["EVENT_NAME"]),'" maxlength="64" autocapitalize="off">
<tr><th title="datetime">é–‹å§‹<td><input name="STARTS" value="',h("$J[EXECUTE_AT]$J[STARTS]"),'">
<tr><th title="datetime">çµæŸ<td><input name="ENDS" value="',h($J["ENDS"]),'">
<tr><th>æ¯<td><input type="number" name="INTERVAL_VALUE" value="',h($J["INTERVAL_VALUE"]),'" class="size"> ',html_select("INTERVAL_FIELD",$Od,$J["INTERVAL_FIELD"]),'<tr><th>ç‹€æ…‹<td>',html_select("STATUS",$vh,$J["STATUS"]),'<tr><th>è¨»è§£<td><input name="EVENT_COMMENT" value="',h($J["EVENT_COMMENT"]),'" maxlength="64">
<tr><th>&nbsp;<td>',checkbox("ON_COMPLETION","PRESERVE",$J["ON_COMPLETION"]=="PRESERVE",'åœ¨å®Œæˆå¾Œå„²å­˜'),'</table>
<p>';textarea("EVENT_DEFINITION",$J["EVENT_DEFINITION"]);echo'<p>
<input type="submit" value="å„²å­˜">
';if($aa!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('Drop %s?',$aa));}echo'<input type="hidden" name="token" value="',$di,'">
</form>
';}elseif(isset($_GET["procedure"])){$da=($_GET["name"]?$_GET["name"]:$_GET["procedure"]);$Lg=(isset($_GET["function"])?"FUNCTION":"PROCEDURE");$J=$_POST;$J["fields"]=(array)$J["fields"];if($_POST&&!process_fields($J["fields"])&&!$n){$vf=routine($_GET["procedure"],$Lg);$Oh="$J[name]_adminer_".uniqid();drop_create("DROP $Lg ".routine_id($da,$vf),create_routine($Lg,$J),"DROP $Lg ".routine_id($J["name"],$J),create_routine($Lg,array("name"=>$Oh)+$J),"DROP $Lg ".routine_id($Oh,$J),substr(ME,0,-1),'å·²åˆªé™¤ç¨‹åºã€‚','å·²ä¿®æ”¹å­ç¨‹åºã€‚','å·²å»ºç«‹å­ç¨‹åºã€‚',$da,$J["name"]);}page_header(($da!=""?(isset($_GET["function"])?'ä¿®æ”¹å‡½æ•¸':'ä¿®æ”¹éç¨‹').": ".h($da):(isset($_GET["function"])?'å»ºç«‹å‡½æ•¸':'å»ºç«‹é å­˜ç¨‹åº')),$n);if(!$_POST&&$da!=""){$J=routine($_GET["procedure"],$Lg);$J["name"]=$da;}$pb=get_vals("SHOW CHARACTER SET");sort($pb);$Mg=routine_languages();echo'
<form action="" method="post" id="form">
<p>åç¨±: <input name="name" value="',h($J["name"]),'" maxlength="64" autocapitalize="off">
',($Mg?'èªè¨€'.": ".html_select("language",$Mg,$J["language"])."\n":""),'<input type="submit" value="å„²å­˜">
<table cellspacing="0" class="nowrap">
';edit_fields($J["fields"],$pb,$Lg);if(isset($_GET["function"])){echo"<tr><td>".'å›å‚³é¡å‹';edit_type("returns",$J["returns"],$pb,array(),($x=="pgsql"?array("void","trigger"):array()));}echo'</table>
<p>';textarea("definition",$J["definition"]);echo'<p>
<input type="submit" value="å„²å­˜">
';if($da!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('Drop %s?',$da));}echo'<input type="hidden" name="token" value="',$di,'">
</form>
';}elseif(isset($_GET["sequence"])){$fa=$_GET["sequence"];$J=$_POST;if($_POST&&!$n){$_=substr(ME,0,-1);$C=trim($J["name"]);if($_POST["drop"])query_redirect("DROP SEQUENCE ".idf_escape($fa),$_,'å·²åˆªé™¤åºåˆ—ã€‚');elseif($fa=="")query_redirect("CREATE SEQUENCE ".idf_escape($C),$_,'å·²å»ºç«‹åºåˆ—ã€‚');elseif($fa!=$C)query_redirect("ALTER SEQUENCE ".idf_escape($fa)." RENAME TO ".idf_escape($C),$_,'å·²ä¿®æ”¹åºåˆ—ã€‚');else
adm_redirect($_);}page_header($fa!=""?'ä¿®æ”¹åºåˆ—'.": ".h($fa):'å»ºç«‹åºåˆ—',$n);if(!$J)$J["name"]=$fa;echo'
<form action="" method="post">
<p><input name="name" value="',h($J["name"]),'" autocapitalize="off">
<input type="submit" value="å„²å­˜">
';if($fa!="")echo"<input type='submit' name='drop' value='".'åˆªé™¤'."'>".confirm(sprintf('Drop %s?',$fa))."\n";echo'<input type="hidden" name="token" value="',$di,'">
</form>
';}elseif(isset($_GET["type"])){$ga=$_GET["type"];$J=$_POST;if($_POST&&!$n){$_=substr(ME,0,-1);if($_POST["drop"])query_redirect("DROP TYPE ".idf_escape($ga),$_,'å·²åˆªé™¤é¡å‹ã€‚');else
query_redirect("CREATE TYPE ".idf_escape(trim($J["name"]))." $J[as]",$_,'å·²å»ºç«‹é¡å‹ã€‚');}page_header($ga!=""?'ä¿®æ”¹é¡å‹'.": ".h($ga):'å»ºç«‹é¡å‹',$n);if(!$J)$J["as"]="AS ";echo'
<form action="" method="post">
<p>
';if($ga!="")echo"<input type='submit' name='drop' value='".'åˆªé™¤'."'>".confirm(sprintf('Drop %s?',$ga))."\n";else{echo"<input name='name' value='".h($J['name'])."' autocapitalize='off'>\n";textarea("as",$J["as"]);echo"<p><input type='submit' value='".'å„²å­˜'."'>\n";}echo'<input type="hidden" name="token" value="',$di,'">
</form>
';}elseif(isset($_GET["trigger"])){$a=$_GET["trigger"];$C=$_GET["name"];$oi=trigger_options();$J=(array)trigger($C)+array("Trigger"=>$a."_bi");if($_POST){if(!$n&&in_array($_POST["Timing"],$oi["Timing"])&&in_array($_POST["Event"],$oi["Event"])&&in_array($_POST["Type"],$oi["Type"])){$gf=" ON ".table($a);$ec="DROP TRIGGER ".idf_escape($C).($x=="pgsql"?$gf:"");$A=ME."table=".urlencode($a);if($_POST["drop"])query_redirect($ec,$A,'å·²åˆªé™¤è§¸ç™¼å™¨ã€‚');else{if($C!="")queries($ec);queries_redirect($A,($C!=""?'å·²ä¿®æ”¹è§¸ç™¼å™¨ã€‚':'å·²å»ºç«‹è§¸ç™¼å™¨ã€‚'),queries(create_trigger($gf,$_POST)));if($C!="")queries(create_trigger($gf,$J+array("Type"=>reset($oi["Type"]))));}}$J=$_POST;}page_header(($C!=""?'ä¿®æ”¹è§¸ç™¼å™¨'.": ".h($C):'å»ºç«‹è§¸ç™¼å™¨'),$n,array("table"=>$a));echo'
<form action="" method="post" id="form">
<table cellspacing="0">
<tr><th>æ™‚é–“<td>',html_select("Timing",$oi["Timing"],$J["Timing"],"triggerChange(/^".preg_quote($a,"/")."_[ba][iud]$/, '".js_escape($a)."', this.form);"),'<tr><th>äº‹ä»¶<td>',html_select("Event",$oi["Event"],$J["Event"],"this.form['Timing'].onchange();"),(in_array("UPDATE OF",$oi["Event"])?" <input name='Of' value='".h($J["Of"])."' class='hidden'>":""),'<tr><th>é¡å‹<td>',html_select("Type",$oi["Type"],$J["Type"]),'</table>
<p>åç¨±: <input name="Trigger" value="',h($J["Trigger"]),'" maxlength="64" autocapitalize="off">
',script("qs('#form')['Timing'].onchange();"),'<p>';textarea("Statement",$J["Statement"]);echo'<p>
<input type="submit" value="å„²å­˜">
';if($C!=""){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('Drop %s?',$C));}echo'<input type="hidden" name="token" value="',$di,'">
</form>
';}elseif(isset($_GET["user"])){$ha=$_GET["user"];$gg=array(""=>array("All privileges"=>""));foreach(get_rows("SHOW PRIVILEGES")as$J){foreach(explode(",",($J["Privilege"]=="Grant option"?"":$J["Context"]))as$Ab)$gg[$Ab][$J["Privilege"]]=$J["Comment"];}$gg["Server Admin"]+=$gg["File access on server"];$gg["Databases"]["Create routine"]=$gg["Procedures"]["Create routine"];unset($gg["Procedures"]["Create routine"]);$gg["Columns"]=array();foreach(array("Select","Insert","Update","References")as$X)$gg["Columns"][$X]=$gg["Tables"][$X];unset($gg["Server Admin"]["Usage"]);foreach($gg["Tables"]as$y=>$X)unset($gg["Databases"][$y]);$Re=array();if($_POST){foreach($_POST["objects"]as$y=>$X)$Re[$X]=(array)$Re[$X]+(array)$_POST["grants"][$y];}$kd=array();$ef="";if(isset($_GET["host"])&&($H=$f->query("SHOW GRANTS FOR ".q($ha)."@".q($_GET["host"])))){while($J=$H->fetch_row()){if(preg_match('~GRANT (.*) ON (.*) TO ~',$J[0],$B)&&preg_match_all('~ *([^(,]*[^ ,(])( *\\([^)]+\\))?~',$B[1],$xe,PREG_SET_ORDER)){foreach($xe
as$X){if($X[1]!="USAGE")$kd["$B[2]$X[2]"][$X[1]]=true;if(preg_match('~ WITH GRANT OPTION~',$J[0]))$kd["$B[2]$X[2]"]["GRANT OPTION"]=true;}}if(preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~",$J[0],$B))$ef=$B[1];}}if($_POST&&!$n){$ff=(isset($_GET["host"])?q($ha)."@".q($_GET["host"]):"''");if($_POST["drop"])query_redirect("DROP USER $ff",ME."privileges=",'å·²åˆªé™¤ä½¿ç”¨è€…ã€‚');else{$Te=q($_POST["user"])."@".q($_POST["host"]);$Of=$_POST["pass"];if($Of!=''&&!$_POST["hashed"]){$Of=$f->result("SELECT PASSWORD(".q($Of).")");$n=!$Of;}$Fb=false;if(!$n){if($ff!=$Te){$Fb=queries((min_version(5)?"CREATE USER":"GRANT USAGE ON *.* TO")." $Te IDENTIFIED BY PASSWORD ".q($Of));$n=!$Fb;}elseif($Of!=$ef)queries("SET PASSWORD FOR $Te = ".q($Of));}if(!$n){$Ig=array();foreach($Re
as$Ze=>$jd){if(isset($_GET["grant"]))$jd=array_filter($jd);$jd=array_keys($jd);if(isset($_GET["grant"]))$Ig=array_diff(array_keys(array_filter($Re[$Ze],'strlen')),$jd);elseif($ff==$Te){$cf=array_keys((array)$kd[$Ze]);$Ig=array_diff($cf,$jd);$jd=array_diff($jd,$cf);unset($kd[$Ze]);}if(preg_match('~^(.+)\\s*(\\(.*\\))?$~U',$Ze,$B)&&(!grant("REVOKE",$Ig,$B[2]," ON $B[1] FROM $Te")||!grant("GRANT",$jd,$B[2]," ON $B[1] TO $Te"))){$n=true;break;}}}if(!$n&&isset($_GET["host"])){if($ff!=$Te)queries("DROP USER $ff");elseif(!isset($_GET["grant"])){foreach($kd
as$Ze=>$Ig){if(preg_match('~^(.+)(\\(.*\\))?$~U',$Ze,$B))grant("REVOKE",array_keys($Ig),$B[2]," ON $B[1] FROM $Te");}}}queries_redirect(ME."privileges=",(isset($_GET["host"])?'å·²ä¿®æ”¹ä½¿ç”¨è€…ã€‚':'å·²å»ºç«‹ä½¿ç”¨è€…ã€‚'),!$n);if($Fb)$f->query("DROP USER $Te");}}page_header((isset($_GET["host"])?'å¸³è™Ÿ'.": ".h("$ha@$_GET[host]"):'å»ºç«‹ä½¿ç”¨è€…'),$n,array("privileges"=>array('','æ¬Šé™')));if($_POST){$J=$_POST;$kd=$Re;}else{$J=$_GET+array("host"=>$f->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)"));$J["pass"]=$ef;if($ef!="")$J["hashed"]=true;$kd[(DB==""||$kd?"":idf_escape(addcslashes(DB,"%_\\"))).".*"]=array();}echo'<form action="" method="post">
<table cellspacing="0">
<tr><th>ä¼ºæœå™¨<td><input name="host" maxlength="60" value="',h($J["host"]),'" autocapitalize="off">
<tr><th>å¸³è™Ÿ<td><input name="user" maxlength="16" value="',h($J["user"]),'" autocapitalize="off">
<tr><th>å¯†ç¢¼<td><input name="pass" id="pass" value="',h($J["pass"]),'" autocomplete="new-password">
';if(!$J["hashed"])echo
script("typePassword(qs('#pass'));");echo
checkbox("hashed",1,$J["hashed"],'Hashed',"typePassword(this.form['pass'], this.checked);"),'</table>

';echo"<table cellspacing='0'>\n","<thead><tr><th colspan='2'>".'æ¬Šé™'.doc_link(array('sql'=>"grant.html#priv_level"));$s=0;foreach($kd
as$Ze=>$jd){echo'<th>'.($Ze!="*.*"?"<input name='objects[$s]' value='".h($Ze)."' size='10' autocapitalize='off'>":"<input type='hidden' name='objects[$s]' value='*.*' size='10'>*.*");$s++;}echo"</thead>\n";foreach(array(""=>"","Server Admin"=>'ä¼ºæœå™¨',"Databases"=>'è³‡æ–™åº«',"Tables"=>'è³‡æ–™è¡¨',"Columns"=>'åˆ—',"Procedures"=>'ç¨‹åº',)as$Ab=>$Vb){foreach((array)$gg[$Ab]as$fg=>$ub){echo"<tr".odd()."><td".($Vb?">$Vb<td":" colspan='2'").' lang="en" title="'.h($ub).'">'.h($fg);$s=0;foreach($kd
as$Ze=>$jd){$C="'grants[$s][".h(strtoupper($fg))."]'";$Y=$jd[strtoupper($fg)];if($Ab=="Server Admin"&&$Ze!=(isset($kd["*.*"])?"*.*":".*"))echo"<td>&nbsp;";elseif(isset($_GET["grant"]))echo"<td><select name=$C><option><option value='1'".($Y?" selected":"").">".'æˆæ¬Š'."<option value='0'".($Y=="0"?" selected":"").">".'å»¢é™¤'."</select>";else{echo"<td align='center'><label class='block'>","<input type='checkbox' name=$C value='1'".($Y?" checked":"").($fg=="All privileges"?" id='grants-$s-all'>":">".($fg=="Grant option"?"":script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$s-all'); };"))),"</label>";}$s++;}}}echo"</table>\n",'<p>
<input type="submit" value="å„²å­˜">
';if(isset($_GET["host"])){echo'<input type="submit" name="drop" value="åˆªé™¤">',confirm(sprintf('Drop %s?',"$ha@$_GET[host]"));}echo'<input type="hidden" name="token" value="',$di,'">
</form>
';}elseif(isset($_GET["processlist"])){if(support("kill")&&$_POST&&!$n){$de=0;foreach((array)$_POST["kill"]as$X){if(kill_process($X))$de++;}queries_redirect(ME."processlist=",sprintf('%d å€‹ Process(es) è¢«çµ‚æ­¢',$de),$de||!$_POST["kill"]);}page_header('è™•ç†ç¨‹åºåˆ—è¡¨',$n);echo'
<form action="" method="post">
<table cellspacing="0" class="nowrap checkable">
',script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");$s=-1;foreach(process_list()as$s=>$J){if(!$s){echo"<thead><tr lang='en'>".(support("kill")?"<th>&nbsp;":"");foreach($J
as$y=>$X)echo"<th>$y".doc_link(array('sql'=>"show-processlist.html#processlist_".strtolower($y),'pgsql'=>"monitoring-stats.html#PG-STAT-ACTIVITY-VIEW",'oracle'=>"../b14237/dynviews_2088.htm",));echo"</thead>\n";}echo"<tr".odd().">".(support("kill")?"<td>".checkbox("kill[]",$J[$x=="sql"?"Id":"pid"],0):"");foreach($J
as$y=>$X)echo"<td>".(($x=="sql"&&$y=="Info"&&preg_match("~Query|Killed~",$J["Command"])&&$X!="")||($x=="pgsql"&&$y=="current_query"&&$X!="<IDLE>")||($x=="oracle"&&$y=="sql_text"&&$X!="")?"<code class='jush-$x'>".shorten_utf8($X,100,"</code>").' <a href="'.h(ME.($J["db"]!=""?"db=".urlencode($J["db"])."&":"")."sql=".urlencode($X)).'">'.'è¤‡è£½'.'</a>':nbsp($X));echo"\n";}echo'</table>
<p>
';if(support("kill")){echo($s+1)."/".sprintf('ç¸½å…± %d å€‹',max_connections()),"<p><input type='submit' value='".'çµ‚æ­¢'."'>\n";}echo'<input type="hidden" name="token" value="',$di,'">
</form>
',script("tableCheck();");}elseif(isset($_GET["select"])){$a=$_GET["select"];$S=table_status1($a);$w=indexes($a);$p=fields($a);$cd=column_foreign_keys($a);$bf=$S["Oid"];parse_str($_COOKIE["adminer_import"],$ya);$Jg=array();$e=array();$Sh=null;foreach($p
as$y=>$o){$C=$b->fieldName($o);if(isset($o["privileges"]["select"])&&$C!=""){$e[$y]=html_entity_decode(strip_tags($C),ENT_QUOTES);if(is_shortable($o))$Sh=$b->selectLengthProcess();}$Jg+=$o["privileges"];}list($L,$ld)=$b->selectColumnsProcess($e,$w);$Sd=count($ld)<count($L);$Z=$b->selectSearchProcess($p,$w);$rf=$b->selectOrderProcess($p,$w);$z=$b->selectLimitProcess();if($_GET["val"]&&is_ajax()){header("Content-Type: text/plain; charset=utf-8");foreach($_GET["val"]as$wi=>$J){$Ga=convert_field($p[key($J)]);$L=array($Ga?$Ga:idf_escape(key($J)));$Z[]=where_check($wi,$p);$I=$m->select($a,$L,$Z,$L);if($I)echo
reset($I->fetch_row());}exit;}$bg=$yi=null;foreach($w
as$v){if($v["type"]=="PRIMARY"){$bg=array_flip($v["columns"]);$yi=($L?$bg:array());foreach($yi
as$y=>$X){if(in_array(idf_escape($y),$L))unset($yi[$y]);}break;}}if($bf&&!$bg){$bg=$yi=array($bf=>0);$w[]=array("type"=>"PRIMARY","columns"=>array($bf));}if($_POST&&!$n){$Yi=$Z;if(!$_POST["all"]&&is_array($_POST["check"])){$fb=array();foreach($_POST["check"]as$cb)$fb[]=where_check($cb,$p);$Yi[]="((".implode(") OR (",$fb)."))";}$Yi=($Yi?"\nWHERE ".implode(" AND ",$Yi):"");if($_POST["export"]){adm_cookie("adminer_import","output=".urlencode($_POST["output"])."&format=".urlencode($_POST["format"]));dump_headers($a);$b->dumpTable($a,"");$hd=($L?implode(", ",$L):"*").convert_fields($e,$p,$L)."\nFROM ".table($a);$nd=($ld&&$Sd?"\nGROUP BY ".implode(", ",$ld):"").($rf?"\nORDER BY ".implode(", ",$rf):"");if(!is_array($_POST["check"])||$bg)$G="SELECT $hd$Yi$nd";else{$ui=array();foreach($_POST["check"]as$X)$ui[]="(SELECT".limit($hd,"\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$p).$nd,1).")";$G=implode(" UNION ALL ",$ui);}$b->dumpData($a,"table",$G);exit;}if(!$b->selectEmailProcess($Z,$cd)){if($_POST["save"]||$_POST["delete"]){$H=true;$za=0;$O=array();if(!$_POST["delete"]){foreach($e
as$C=>$X){$X=process_input($p[$C]);if($X!==null&&($_POST["clone"]||$X!==false))$O[idf_escape($C)]=($X!==false?$X:idf_escape($C));}}if($_POST["delete"]||$O){if($_POST["clone"])$G="INTO ".table($a)." (".implode(", ",array_keys($O)).")\nSELECT ".implode(", ",$O)."\nFROM ".table($a);if($_POST["all"]||($bg&&is_array($_POST["check"]))||$Sd){$H=($_POST["delete"]?$m->delete($a,$Yi):($_POST["clone"]?queries("INSERT $G$Yi"):$m->update($a,$O,$Yi)));$za=$f->affected_rows;}else{foreach((array)$_POST["check"]as$X){$Ui="\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$p);$H=($_POST["delete"]?$m->delete($a,$Ui,1):($_POST["clone"]?queries("INSERT".limit1($a,$G,$Ui)):$m->update($a,$O,$Ui,1)));if(!$H)break;$za+=$f->affected_rows;}}}$Ee=sprintf('%då€‹é …ç›®å—åˆ°å½±éŸ¿ã€‚',$za);if($_POST["clone"]&&$H&&$za==1){$ie=last_id();if($ie)$Ee=sprintf('å·²æ–°å¢é …ç›®%sã€‚'," $ie");}queries_redirect(remove_from_uri($_POST["all"]&&$_POST["delete"]?"page":""),$Ee,$H);if(!$_POST["delete"]){edit_form($a,$p,(array)$_POST["fields"],!$_POST["clone"]);page_footer();exit;}}elseif(!$_POST["import"]){if(!$_POST["val"])$n='Ctrl+click on a value to modify it.';else{$H=true;$za=0;foreach($_POST["val"]as$wi=>$J){$O=array();foreach($J
as$y=>$X){$y=bracket_escape($y,1);$O[idf_escape($y)]=(preg_match('~char|text~',$p[$y]["type"])||$X!=""?$b->processInput($p[$y],$X):"NULL");}$H=$m->update($a,$O," WHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($wi,$p),!$Sd&&!$bg," ");if(!$H)break;$za+=$f->affected_rows;}queries_redirect(remove_from_uri(),sprintf('%då€‹é …ç›®å—åˆ°å½±éŸ¿ã€‚',$za),$H);}}elseif(!is_string($Sc=get_file("csv_file",true)))$n=upload_error($Sc);elseif(!preg_match('~~u',$Sc))$n='File must be in UTF-8 encoding.';else{adm_cookie("adminer_import","output=".urlencode($ya["output"])."&format=".urlencode($_POST["separator"]));$H=true;$rb=array_keys($p);preg_match_all('~(?>"[^"]*"|[^"\\r\\n]+)+~',$Sc,$xe);$za=count($xe[0]);$m->begin();$M=($_POST["separator"]=="csv"?",":($_POST["separator"]=="tsv"?"\t":";"));$K=array();foreach($xe[0]as$y=>$X){preg_match_all("~((?>\"[^\"]*\")+|[^$M]*)$M~",$X.$M,$ye);if(!$y&&!array_diff($ye[1],$rb)){$rb=$ye[1];$za--;}else{$O=array();foreach($ye[1]as$s=>$mb)$O[idf_escape($rb[$s])]=($mb==""&&$p[$rb[$s]]["null"]?"NULL":q(str_replace('""','"',preg_replace('~^"|"$~','',$mb))));$K[]=$O;}}$H=(!$K||$m->insertUpdate($a,$K,$bg));if($H)$H=$m->commit();queries_redirect(remove_from_uri("page"),sprintf('å·²åŒ¯å…¥%dè¡Œã€‚',$za),$H);$m->rollback();}}}$Eh=$b->tableName($S);if(is_ajax()){page_headers();ob_start();}else
page_header('é¸æ“‡'.": $Eh",$n);$O=null;if(isset($Jg["insert"])||!support("table")){$O="";foreach((array)$_GET["where"]as$X){if($cd[$X["col"]]&&count($cd[$X["col"]])==1&&($X["op"]=="="||(!$X["op"]&&!preg_match('~[_%]~',$X["val"]))))$O.="&set".urlencode("[".bracket_escape($X["col"])."]")."=".urlencode($X["val"]);}}$b->selectLinks($S,$O);if(!$e&&support("table"))echo"<p class='error'>".'ç„¡æ³•é¸æ“‡è©²è³‡æ–™è¡¨'.($p?".":": ".error())."\n";else{echo"<form action='' id='form'>\n","<div style='display: none;'>";hidden_fields_get();echo(DB!=""?'<input type="hidden" name="db" value="'.h(DB).'">'.(isset($_GET["ns"])?'<input type="hidden" name="ns" value="'.h($_GET["ns"]).'">':""):"");echo'<input type="hidden" name="select" value="'.h($a).'">',"</div>\n";$b->selectColumnsPrint($L,$e);$b->selectSearchPrint($Z,$e,$w);$b->selectOrderPrint($rf,$e,$w);$b->selectLimitPrint($z);$b->selectLengthPrint($Sh);$b->selectActionPrint($w);echo"</form>\n";$E=$_GET["page"];if($E=="last"){$fd=$f->result(count_rows($a,$Z,$Sd,$ld));$E=floor(max(0,$fd-1)/$z);}$Vg=$L;$md=$ld;if(!$Vg){$Vg[]="*";$Bb=convert_fields($e,$p,$L);if($Bb)$Vg[]=substr($Bb,2);}foreach($L
as$y=>$X){$o=$p[idf_unescape($X)];if($o&&($Ga=convert_field($o)))$Vg[$y]="$Ga AS $X";}if(!$Sd&&$yi){foreach($yi
as$y=>$X){$Vg[]=idf_escape($y);if($md)$md[]=idf_escape($y);}}$H=$m->select($a,$Vg,$Z,$md,$rf,$z,$E,true);if(!$H)echo"<p class='error'>".error()."\n";else{if($x=="mssql"&&$E)$H->seek($z*$E);$rc=array();echo"<form action='' method='post' enctype='multipart/form-data'>\n";$K=array();while($J=$H->fetch_assoc()){if($E&&$x=="oracle")unset($J["RNUM"]);$K[]=$J;}if($_GET["page"]!="last"&&$z!=""&&$ld&&$Sd&&$x=="sql")$fd=$f->result(" SELECT FOUND_ROWS()");if(!$K)echo"<p class='message'>".'æ²’æœ‰è¡Œã€‚'."\n";else{$Pa=$b->backwardKeys($a,$Eh);echo"<table id='table' cellspacing='0' class='nowrap checkable'>",script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"),"<thead><tr>".(!$ld&&$L?"":"<td><input type='checkbox' id='all-page' class='jsonly'>".script("qs('#all-page').onclick = partial(formCheck, /check/);","")." <a href='".h($_GET["modify"]?remove_from_uri("modify"):$_SERVER["REQUEST_URI"]."&modify=1")."'>".'Modify'."</a>");$Qe=array();$id=array();reset($L);$qg=1;foreach($K[0]as$y=>$X){if(!isset($yi[$y])){$X=$_GET["columns"][key($L)];$o=$p[$L?($X?$X["col"]:current($L)):$y];$C=($o?$b->fieldName($o,$qg):($X["fun"]?"*":$y));if($C!=""){$qg++;$Qe[$y]=$C;$d=idf_escape($y);$yd=remove_from_uri('(order|desc)[^=]*|page').'&order%5B0%5D='.urlencode($y);$Vb="&desc%5B0%5D=1";echo"<th>".script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});",""),'<a href="'.h($yd.($rf[0]==$d||$rf[0]==$y||(!$rf&&$Sd&&$ld[0]==$d)?$Vb:'')).'">';echo
apply_sql_function($X["fun"],$C)."</a>";echo"<span class='column hidden'>","<a href='".h($yd.$Vb)."' title='".'é™å†ª(éæ¸›)'."' class='text'> â†“</a>";if(!$X["fun"]){echo'<a href="#fieldset-search" title="'.'æœå°‹'.'" class="text jsonly"> =</a>',script("qsl('a').onclick = partial(selectSearch, '".js_escape($y)."');");}echo"</span>";}$id[$y]=$X["fun"];next($L);}}$oe=array();if($_GET["modify"]){foreach($K
as$J){foreach($J
as$y=>$X)$oe[$y]=max($oe[$y],min(40,strlen(utf8_decode($X))));}}echo($Pa?"<th>".'é—œè¯':"")."</thead>\n";if(is_ajax()){if($z%2==1&&$E%2==1)odd();ob_end_clean();}foreach($b->rowDescriptions($K,$cd)as$Pe=>$J){$vi=unique_array($K[$Pe],$w);if(!$vi){$vi=array();foreach($K[$Pe]as$y=>$X){if(!preg_match('~^(COUNT\\((\\*|(DISTINCT )?`(?:[^`]|``)+`)\\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\\(`(?:[^`]|``)+`\\))$~',$y))$vi[$y]=$X;}}$wi="";foreach($vi
as$y=>$X){if(($x=="sql"||$x=="pgsql")&&preg_match('~char|text|enum|set~',$p[$y]["type"])&&strlen($X)>64){$y=(strpos($y,'(')?$y:idf_escape($y));$y="MD5(".($x!='sql'||preg_match("~^utf8~",$p[$y]["collation"])?$y:"CONVERT($y USING ".charset($f).")").")";$X=md5($X);}$wi.="&".($X!==null?urlencode("where[".bracket_escape($y)."]")."=".urlencode($X):"null%5B%5D=".urlencode($y));}echo"<tr".odd().">".(!$ld&&$L?"":"<td>".checkbox("check[]",substr($wi,1),in_array(substr($wi,1),(array)$_POST["check"])).($Sd||information_schema(DB)?"":" <a href='".h(ME."edit=".urlencode($a).$wi)."' class='edit'>".'ç·¨è¼¯'."</a>"));foreach($J
as$y=>$X){if(isset($Qe[$y])){$o=$p[$y];$X=$m->value($X,$o);if($X!=""&&(!isset($rc[$y])||$rc[$y]!=""))$rc[$y]=(is_mail($X)?$Qe[$y]:"");$_="";if(preg_match('~blob|bytea|raw|file~',$o["type"])&&$X!="")$_=ME.'download='.urlencode($a).'&field='.urlencode($y).$wi;if(!$_&&$X!==null){foreach((array)$cd[$y]as$q){if(count($cd[$y])==1||end($q["source"])==$y){$_="";foreach($q["source"]as$s=>$lh)$_.=where_link($s,$q["target"][$s],$K[$Pe][$lh]);$_=($q["db"]!=""?preg_replace('~([?&]db=)[^&]+~','\\1'.urlencode($q["db"]),ME):ME).'select='.urlencode($q["table"]).$_;if($q["ns"])$_=preg_replace('~([?&]ns=)[^&]+~','\\1'.urlencode($q["ns"]),$_);if(count($q["source"])==1)break;}}}if($y=="COUNT(*)"){$_=ME."select=".urlencode($a);$s=0;foreach((array)$_GET["where"]as$W){if(!array_key_exists($W["col"],$vi))$_.=where_link($s++,$W["col"],$W["val"],$W["op"]);}foreach($vi
as$Xd=>$W)$_.=where_link($s++,$Xd,$W);}$X=select_value($X,$_,$o,$Sh);$t=h("val[$wi][".bracket_escape($y)."]");$Y=$_POST["val"][$wi][bracket_escape($y)];$mc=!is_array($J[$y])&&is_utf8($X)&&$K[$Pe][$y]==$J[$y]&&!$id[$y];$Rh=preg_match('~text|lob~',$o["type"]);if(($_GET["modify"]&&$mc)||$Y!==null){$pd=h($Y!==null?$Y:$J[$y]);echo"<td>".($Rh?"<textarea name='$t' cols='30' rows='".(substr_count($J[$y],"\n")+1)."'>$pd</textarea>":"<input name='$t' value='$pd' size='$oe[$y]'>");}else{$se=strpos($X,"<i>...</i>");echo"<td id='$t' data-text='".($se?2:($Rh?1:0))."'".($mc?"":" data-warning='".h('ä½¿ç”¨ç·¨è¼¯é€£çµä¾†ä¿®æ”¹ã€‚')."'").">$X</td>";}}}if($Pa)echo"<td>";$b->backwardKeysPrint($Pa,$K[$Pe]);echo"</tr>\n";}if(is_ajax())exit;echo"</table>\n";}if(!is_ajax()){if($K||$E){$Ac=true;if($_GET["page"]!="last"){if($z==""||(count($K)<$z&&($K||!$E)))$fd=($E?$E*$z:0)+count($K);elseif($x!="sql"||!$Sd){$fd=($Sd?false:found_rows($S,$Z));if($fd<max(1e4,2*($E+1)*$z))$fd=reset(slow_query(count_rows($a,$Z,$Sd,$ld)));else$Ac=false;}}$Df=($z!=""&&($fd===false||$fd>$z||$E));if($Df){echo(($fd===false?count($K)+1:$fd-$E*$z)>$z?'<p><a href="'.h(remove_from_uri("page")."&page=".($E+1)).'" class="loadmore">'.'Load more data'.'</a>'.script("qsl('a').onclick = partial(selectLoadMore, ".(+$z).", '".'Loading'."...');",""):''),"\n";}}echo"<div class='footer'><div>\n";if($K||$E){if($Df){$_e=($fd===false?$E+(count($K)>=$z?2:1):floor(($fd-1)/$z));echo"<fieldset>";if($x!="simpledb"){echo"<legend><a href='".h(remove_from_uri("page"))."'>".'é '."</a></legend>",script("qsl('a').onclick = function () { pageClick(this.href, +prompt('".'é '."', '".($E+1)."')); return false; };"),pagination(0,$E).($E>5?" ...":"");for($s=max(1,$E-4);$s<min($_e,$E+5);$s++)echo
pagination($s,$E);if($_e>0){echo($E+5<$_e?" ...":""),($Ac&&$fd!==false?pagination($_e,$E):" <a href='".h(remove_from_uri("page")."&page=last")."' title='~$_e'>".'æœ€å¾Œä¸€é '."</a>");}}else{echo"<legend>".'é '."</legend>",pagination(0,$E).($E>1?" ...":""),($E?pagination($E,$E):""),($_e>$E?pagination($E+1,$E).($_e>$E+1?" ...":""):"");}echo"</fieldset>\n";}echo"<fieldset>","<legend>".'æ‰€æœ‰çµæœ'."</legend>";$ac=($Ac?"":"~ ").$fd;echo
checkbox("all",1,0,($fd!==false?($Ac?"":"~ ").sprintf('%dè¡Œ',$fd):""),"var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$ac' : checked); selectCount('selected2', this.checked || !checked ? '$ac' : checked);")."\n","</fieldset>\n";if($b->selectCommandPrint()){echo'<fieldset',($_GET["modify"]?'':' class="jsonly"'),'><legend>Modify</legend><div>
<input type="submit" value="å„²å­˜"',($_GET["modify"]?'':' title="'.'Ctrl+click on a value to modify it.'.'"'),'>
</div></fieldset>
<fieldset><legend>Selected <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="ç·¨è¼¯">
<input type="submit" name="clone" value="è¤‡è£½">
<input type="submit" name="delete" value="åˆªé™¤">',confirm(),'</div></fieldset>
';}$dd=$b->dumpFormat();foreach((array)$_GET["columns"]as$d){if($d["fun"]){unset($dd['sql']);break;}}if($dd){print_fieldset("export",'åŒ¯å‡º'." <span id='selected2'></span>");$Bf=$b->dumpOutput();echo($Bf?html_select("output",$Bf,$ya["output"])." ":""),html_select("format",$dd,$ya["format"])," <input type='submit' name='export' value='".'åŒ¯å‡º'."'>\n","</div></fieldset>\n";}$b->selectEmailPrint(array_filter($rc,'strlen'),$e);}echo"</div></div>\n";if($b->selectImportPrint()){echo"<div>","<a href='#import'>".'åŒ¯å…¥'."</a>",script("qsl('a').onclick = partial(toggle, 'import');",""),"<span id='import' class='hidden'>: ","<input type='file' name='csv_file'> ",html_select("separator",array("csv"=>"CSV,","csv;"=>"CSV;","tsv"=>"TSV"),$ya["format"],1);echo" <input type='submit' name='import' value='".'åŒ¯å…¥'."'>","</span>","</div>";}echo"<input type='hidden' name='token' value='$di'>\n","</form>\n",(!$ld&&$L?"":script("tableCheck();"));}}}if(is_ajax()){ob_end_clean();exit;}}elseif(isset($_GET["variables"])){$P=isset($_GET["status"]);page_header($P?'ç‹€æ…‹':'è®Šæ•¸');$Li=($P?show_status():show_variables());if(!$Li)echo"<p class='message'>".'æ²’æœ‰è¡Œã€‚'."\n";else{echo"<table cellspacing='0'>\n";foreach($Li
as$y=>$X){echo"<tr>","<th><code class='jush-".$x.($P?"status":"set")."'>".h($y)."</code>","<td>".nbsp($X);}echo"</table>\n";}}elseif(isset($_GET["script"])){header("Content-Type: text/javascript; charset=utf-8");if($_GET["script"]=="db"){$Bh=array("Data_length"=>0,"Index_length"=>0,"Data_free"=>0);foreach(table_status()as$C=>$S){json_row("Comment-$C",nbsp($S["Comment"]));if(!is_view($S)){foreach(array("Engine","Collation")as$y)json_row("$y-$C",nbsp($S[$y]));foreach($Bh+array("Auto_increment"=>0,"Rows"=>0)as$y=>$X){if($S[$y]!=""){$X=format_number($S[$y]);json_row("$y-$C",($y=="Rows"&&$X&&$S["Engine"]==($oh=="pgsql"?"table":"InnoDB")?"~ $X":$X));if(isset($Bh[$y]))$Bh[$y]+=($S["Engine"]!="InnoDB"||$y!="Data_free"?$S[$y]:0);}elseif(array_key_exists($y,$S))json_row("$y-$C");}}}foreach($Bh
as$y=>$X)json_row("sum-$y",format_number($X));json_row("");}elseif($_GET["script"]=="kill")$f->query("KILL ".number($_POST["kill"]));else{foreach(count_tables($b->databases())as$l=>$X){json_row("tables-$l",$X);json_row("size-$l",db_size($l));}json_row("");}exit;}else{$Kh=array_merge((array)$_POST["tables"],(array)$_POST["views"]);if($Kh&&!$n&&!$_POST["search"]){$H=true;$Ee="";if($x=="sql"&&$_POST["tables"]&&count($_POST["tables"])>1&&($_POST["drop"]||$_POST["truncate"]||$_POST["copy"]))queries("SET foreign_key_checks = 0");if($_POST["truncate"]){if($_POST["tables"])$H=truncate_tables($_POST["tables"]);$Ee='å·²æ¸…ç©ºè³‡æ–™è¡¨ã€‚';}elseif($_POST["move"]){$H=move_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Ee='å·²è½‰ç§»è³‡æ–™è¡¨ã€‚';}elseif($_POST["copy"]){$H=copy_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Ee='è³‡æ–™è¡¨å·²ç¶“è¤‡è£½';}elseif($_POST["drop"]){if($_POST["views"])$H=drop_views($_POST["views"]);if($H&&$_POST["tables"])$H=drop_tables($_POST["tables"]);$Ee='å·²ç¶“å°‡è³‡æ–™è¡¨åˆªé™¤ã€‚';}elseif($x!="sql"){$H=($x=="sqlite"?queries("VACUUM"):apply_queries("VACUUM".($_POST["optimize"]?"":" ANALYZE"),$_POST["tables"]));$Ee='Tables have been optimized.';}elseif(!$_POST["tables"])$Ee='æ²’æœ‰è³‡æ–™è¡¨ã€‚';elseif($H=queries(($_POST["optimize"]?"OPTIMIZE":($_POST["check"]?"CHECK":($_POST["repair"]?"REPAIR":"ANALYZE")))." TABLE ".implode(", ",array_map('idf_escape',$_POST["tables"])))){while($J=$H->fetch_assoc())$Ee.="<b>".h($J["Table"])."</b>: ".h($J["Msg_text"])."<br>";}queries_redirect(substr(ME,0,-1),$Ee,$H);}page_header(($_GET["ns"]==""?'è³‡æ–™åº«'.": ".h(DB):'è³‡æ–™è¡¨çµæ§‹'.": ".h($_GET["ns"])),$n,true);if($b->homepage()){if($_GET["ns"]!==""){echo"<h3 id='tables-views'>".'è³‡æ–™è¡¨å’Œæª¢è¦–è¡¨'."</h3>\n";$Jh=tables_list();if(!$Jh)echo"<p class='message'>".'æ²’æœ‰è³‡æ–™è¡¨ã€‚'."\n";else{echo"<form action='' method='post'>\n";if(support("table")){echo"<fieldset><legend>".'åœ¨è³‡æ–™åº«æœå°‹'." <span id='selected2'></span></legend><div>","<input type='search' name='query' value='".h($_POST["query"])."'>",script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');","")," <input type='submit' name='search' value='".'æœå°‹'."'>\n","</div></fieldset>\n";if($_POST["search"]&&$_POST["query"]!=""){$_GET["where"][0]["op"]="LIKE %%";search_tables();}}$bc=doc_link(array('sql'=>'show-table-status.html'));echo"<table cellspacing='0' class='nowrap checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),'<thead><tr class="wrap">','<td><input id="check-all" type="checkbox" class="jsonly">'.script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);",""),'<th>'.'è³‡æ–™è¡¨','<td>'.'å¼•æ“'.doc_link(array('sql'=>'storage-engines.html')),'<td>'.'æ ¡å°'.doc_link(array('sql'=>'charset-charsets.html','mariadb'=>'supported-character-sets-and-collations/')),'<td>'.'è³‡æ–™é•·åº¦'.$bc,'<td>'.'ç´¢å¼•é•·åº¦'.$bc,'<td>'.'è³‡æ–™ç©ºé–’'.$bc,'<td>'.'è‡ªå‹•éå¢'.doc_link(array('sql'=>'example-auto-increment.html','mariadb'=>'auto_increment/')),'<td>'.'è¡Œæ•¸'.$bc,(support("comment")?'<td>'.'è¨»è§£'.$bc:''),"</thead>\n";$T=0;foreach($Jh
as$C=>$U){$Oi=($U!==null&&!preg_match('~table~i',$U));$t=h("Table-".$C);echo'<tr'.odd().'><td>'.checkbox(($Oi?"views[]":"tables[]"),$C,in_array($C,$Kh,true),"","","",$t),'<th>'.(support("table")||support("indexes")?"<a href='".h(ME)."table=".urlencode($C)."' title='".'é¡¯ç¤ºçµæ§‹'."' id='$t'>".h($C).'</a>':h($C));if($Oi){echo'<td colspan="6"><a href="'.h(ME)."view=".urlencode($C).'" title="'.'ä¿®æ”¹æª¢è¦–è¡¨'.'">'.(preg_match('~materialized~i',$U)?'Materialized view':'æª¢è¦–è¡¨').'</a>','<td align="right"><a href="'.h(ME)."select=".urlencode($C).'" title="'.'é¸æ“‡è³‡æ–™'.'">?</a>';}else{foreach(array("Engine"=>array(),"Collation"=>array(),"Data_length"=>array("create",'ä¿®æ”¹è³‡æ–™è¡¨'),"Index_length"=>array("indexes",'ä¿®æ”¹ç´¢å¼•'),"Data_free"=>array("edit",'æ–°å¢é …ç›®'),"Auto_increment"=>array("auto_increment=1&create",'ä¿®æ”¹è³‡æ–™è¡¨'),"Rows"=>array("select",'é¸æ“‡è³‡æ–™'),)as$y=>$_){$t=" id='$y-".h($C)."'";echo($_?"<td align='right'>".(support("table")||$y=="Rows"||(support("indexes")&&$y!="Data_length")?"<a href='".h(ME."$_[0]=").urlencode($C)."'$t title='$_[1]'>?</a>":"<span$t>?</span>"):"<td id='$y-".h($C)."'>&nbsp;");}$T++;}echo(support("comment")?"<td id='Comment-".h($C)."'>&nbsp;":"");}echo"<tr><td>&nbsp;<th>".sprintf('ç¸½å…± %d å€‹',count($Jh)),"<td>".nbsp($x=="sql"?$f->result("SELECT @@storage_engine"):""),"<td>".nbsp(db_collation(DB,collations()));foreach(array("Data_length","Index_length","Data_free")as$y)echo"<td align='right' id='sum-$y'>&nbsp;";echo"</table>\n";if(!information_schema(DB)){echo"<div class='footer'><div>\n";$Ii="<input type='submit' value='".'Vacuum'."'> ".on_help("'VACUUM'");$nf="<input type='submit' name='optimize' value='".'æœ€ä½³åŒ–'."'> ".on_help($x=="sql"?"'OPTIMIZE TABLE'":"'VACUUM OPTIMIZE'");echo"<fieldset><legend>".'Selected'." <span id='selected'></span></legend><div>".($x=="sqlite"?$Ii:($x=="pgsql"?$Ii.$nf:($x=="sql"?"<input type='submit' value='".'åˆ†æ'."'> ".on_help("'ANALYZE TABLE'").$nf."<input type='submit' name='check' value='".'æª¢æŸ¥'."'> ".on_help("'CHECK TABLE'")."<input type='submit' name='repair' value='".'ä¿®å¾©'."'> ".on_help("'REPAIR TABLE'"):"")))."<input type='submit' name='truncate' value='".'æ¸…ç©º'."'> ".on_help($x=="sqlite"?"'DELETE'":"'TRUNCATE".($x=="pgsql"?"'":" TABLE'")).confirm()."<input type='submit' name='drop' value='".'åˆªé™¤'."'>".on_help("'DROP TABLE'").confirm()."\n";$k=(support("scheme")?$b->schemas():$b->databases());if(count($k)!=1&&$x!="sqlite"){$l=(isset($_POST["target"])?$_POST["target"]:(support("scheme")?$_GET["ns"]:DB));echo"<p>".'è½‰ç§»åˆ°å…¶å®ƒè³‡æ–™åº«'.": ",($k?html_select("target",$k,$l):'<input name="target" value="'.h($l).'" autocapitalize="off">')," <input type='submit' name='move' value='".'è½‰ç§»'."'>",(support("copy")?" <input type='submit' name='copy' value='".'è¤‡è£½'."'>":""),"\n";}echo"<input type='hidden' name='all' value=''>";echo
script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));".(support("table")?" selectCount('selected2', formChecked(this, /^tables\[/) || $T);":"")." }"),"<input type='hidden' name='token' value='$di'>\n","</div></fieldset>\n","</div></div>\n";}echo"</form>\n",script("tableCheck();");}echo'<p class="links"><a href="'.h(ME).'create=">'.'å»ºç«‹è³‡æ–™è¡¨'."</a>\n",(support("view")?'<a href="'.h(ME).'view=">'.'å»ºç«‹æª¢è¦–è¡¨'."</a>\n":"");if(support("routine")){echo"<h3 id='routines'>".'ç¨‹åº'."</h3>\n";$Ng=routines();if($Ng){echo"<table cellspacing='0'>\n",'<thead><tr><th>'.'åç¨±'.'<td>'.'é¡å‹'.'<td>'.'å›å‚³é¡å‹'."<td>&nbsp;</thead>\n";odd('');foreach($Ng
as$J){$C=($J["SPECIFIC_NAME"]==$J["ROUTINE_NAME"]?"":"&name=".urlencode($J["ROUTINE_NAME"]));echo'<tr'.odd().'>','<th><a href="'.h(ME.($J["ROUTINE_TYPE"]!="PROCEDURE"?'callf=':'call=').urlencode($J["SPECIFIC_NAME"]).$C).'">'.h($J["ROUTINE_NAME"]).'</a>','<td>'.h($J["ROUTINE_TYPE"]),'<td>'.h($J["DTD_IDENTIFIER"]),'<td><a href="'.h(ME.($J["ROUTINE_TYPE"]!="PROCEDURE"?'function=':'procedure=').urlencode($J["SPECIFIC_NAME"]).$C).'">'.'ä¿®æ”¹'."</a>";}echo"</table>\n";}echo'<p class="links">'.(support("procedure")?'<a href="'.h(ME).'procedure=">'.'å»ºç«‹é å­˜ç¨‹åº'.'</a>':'').'<a href="'.h(ME).'function=">'.'å»ºç«‹å‡½æ•¸'."</a>\n";}if(support("sequence")){echo"<h3 id='sequences'>".'åºåˆ—'."</h3>\n";$bh=get_vals("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = current_schema() ORDER BY sequence_name");if($bh){echo"<table cellspacing='0'>\n","<thead><tr><th>".'åç¨±'."</thead>\n";odd('');foreach($bh
as$X)echo"<tr".odd()."><th><a href='".h(ME)."sequence=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."sequence='>".'å»ºç«‹åºåˆ—'."</a>\n";}if(support("type")){echo"<h3 id='user-types'>".'ä½¿ç”¨è€…é¡å‹'."</h3>\n";$Gi=types();if($Gi){echo"<table cellspacing='0'>\n","<thead><tr><th>".'åç¨±'."</thead>\n";odd('');foreach($Gi
as$X)echo"<tr".odd()."><th><a href='".h(ME)."type=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."type='>".'å»ºç«‹é¡å‹'."</a>\n";}if(support("event")){echo"<h3 id='events'>".'äº‹ä»¶'."</h3>\n";$K=get_rows("SHOW EVENTS");if($K){echo"<table cellspacing='0'>\n","<thead><tr><th>".'åç¨±'."<td>".'æ’ç¨‹'."<td>".'é–‹å§‹'."<td>".'çµæŸ'."<td></thead>\n";foreach($K
as$J){echo"<tr>","<th>".h($J["Name"]),"<td>".($J["Execute at"]?'åœ¨æŒ‡å®šæ™‚é–“'."<td>".$J["Execute at"]:'æ¯'." ".$J["Interval value"]." ".$J["Interval field"]."<td>$J[Starts]"),"<td>$J[Ends]",'<td><a href="'.h(ME).'event='.urlencode($J["Name"]).'">'.'ä¿®æ”¹'.'</a>';}echo"</table>\n";$zc=$f->result("SELECT @@event_scheduler");if($zc&&$zc!="ON")echo"<p class='error'><code class='jush-sqlset'>event_scheduler</code>: ".h($zc)."\n";}echo'<p class="links"><a href="'.h(ME).'event=">'.'å»ºç«‹äº‹ä»¶'."</a>\n";}if($Jh)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}}}page_footer();