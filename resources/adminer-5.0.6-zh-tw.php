<?php
/** Adminer - Compact database management
* @link https://www.adminer.org/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
* @version 5.0.6
*/namespace
Adminer;$ia="5.0.6";error_reporting(6135);set_error_handler(function($wc,$yc){return!!preg_match('~^(Trying to access array offset on( value of type)? null|Undefined (array key|property))~',$yc);},E_WARNING);$Sc=!preg_match('~^(unsafe_raw)?$~',ini_get("filter.default"));if($Sc||ini_get("filter.default_flags")){foreach(array('_GET','_POST','_COOKIE','_SERVER')as$X){$Ci=filter_input_array(constant("INPUT$X"),FILTER_UNSAFE_RAW);if($Ci)$$X=$Ci;}}if(function_exists("mb_internal_encoding"))mb_internal_encoding("8bit");function
connection(){global$f;return$f;}function
adminer(){global$b;return$b;}function
driver(){global$l;return$l;}function
version(){global$ia;return$ia;}function
idf_unescape($v){if(!preg_match('~^[`\'"[]~',$v))return$v;$ke=substr($v,-1);return
str_replace($ke.$ke,$ke,substr($v,1,-1));}function
q($P){global$f;return$f->quote($P);}function
escape_string($X){return
substr(q($X),1,-1);}function
number($X){return
preg_replace('~[^0-9]+~','',$X);}function
number_type(){return'((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';}function
remove_slashes($og,$Sc=false){if(function_exists("get_magic_quotes_gpc")&&get_magic_quotes_gpc()){while(list($y,$X)=each($og)){foreach($X
as$ce=>$W){unset($og[$y][$ce]);if(is_array($W)){$og[$y][stripslashes($ce)]=$W;$og[]=&$og[$y][stripslashes($ce)];}else$og[$y][stripslashes($ce)]=($Sc?$W:stripslashes($W));}}}}function
bracket_escape($v,$Ca=false){static$mi=array(':'=>':1',']'=>':2','['=>':3','"'=>':4');return
strtr($v,($Ca?array_flip($mi):$mi));}function
min_version($Ti,$ye="",$g=null){global$f;if(!$g)$g=$f;$gh=$g->server_info;if($ye&&preg_match('~([\d.]+)-MariaDB~',$gh,$A)){$gh=$A[1];$Ti=$ye;}return$Ti&&version_compare($gh,$Ti)>=0;}function
charset($f){return(min_version("5.5.3",0,$f)?"utf8mb4":"utf8");}function
ini_bool($Od){$X=ini_get($Od);return(preg_match('~^(on|true|yes)$~i',$X)||(int)$X);}function
sid(){static$I;if($I===null)$I=(SID&&!($_COOKIE&&ini_bool("session.use_cookies")));return$I;}function
set_password($Si,$M,$V,$E){$_SESSION["pwds"][$Si][$M][$V]=($_COOKIE["adminer_key"]&&is_string($E)?array(encrypt_string($E,$_COOKIE["adminer_key"])):$E);}function
get_password(){$I=get_session("pwds");if(is_array($I))$I=($_COOKIE["adminer_key"]?decrypt_string($I[0],$_COOKIE["adminer_key"]):false);return$I;}function
get_val($G,$n=0){global$f;return$f->result($G,$n);}function
get_vals($G,$d=0){global$f;$I=array();$H=$f->query($G);if(is_object($H)){while($J=$H->fetch_row())$I[]=$J[$d];}return$I;}function
get_key_vals($G,$g=null,$jh=true){global$f;if(!is_object($g))$g=$f;$I=array();$H=$g->query($G);if(is_object($H)){while($J=$H->fetch_row()){if($jh)$I[$J[0]]=$J[1];else$I[]=$J[0];}}return$I;}function
get_rows($G,$g=null,$m="<p class='error'>"){global$f;$pb=(is_object($g)?$g:$f);$I=array();$H=$pb->query($G);if(is_object($H)){while($J=$H->fetch_assoc())$I[]=$J;}elseif(!$H&&!is_object($g)&&$m&&(defined('Adminer\PAGE_HEADER')||$m=="-- "))echo$m.error()."\n";return$I;}function
unique_array($J,$x){foreach($x
as$w){if(preg_match("~PRIMARY|UNIQUE~",$w["type"])){$I=array();foreach($w["columns"]as$y){if(!isset($J[$y]))continue
2;$I[$y]=$J[$y];}return$I;}}}function
escape_key($y){if(preg_match('(^([\w(]+)('.str_replace("_",".*",preg_quote(idf_escape("_"))).')([ \w)]+)$)',$y,$A))return$A[1].idf_escape(idf_unescape($A[2])).$A[3];return
idf_escape($y);}function
where($Z,$o=array()){global$f;$I=array();foreach((array)$Z["where"]as$y=>$X){$y=bracket_escape($y,1);$d=escape_key($y);$Qc=$o[$y]["type"];$I[]=$d.(JUSH=="sql"&&$Qc=="json"?" = CAST(".q($X)." AS JSON)":(JUSH=="sql"&&is_numeric($X)&&preg_match('~\.~',$X)?" LIKE ".q($X):(JUSH=="mssql"&&strpos($Qc,"datetime")===false?" LIKE ".q(preg_replace('~[_%[]~','[\0]',$X)):" = ".unconvert_field($o[$y],q($X)))));if(JUSH=="sql"&&preg_match('~char|text~',$Qc)&&preg_match("~[^ -@]~",$X))$I[]="$d = ".q($X)." COLLATE ".charset($f)."_bin";}foreach((array)$Z["null"]as$y)$I[]=escape_key($y)." IS NULL";return
implode(" AND ",$I);}function
where_check($X,$o=array()){parse_str($X,$Ta);remove_slashes(array(&$Ta));return
where($Ta,$o);}function
where_link($t,$d,$Y,$rf="="){return"&where%5B$t%5D%5Bcol%5D=".urlencode($d)."&where%5B$t%5D%5Bop%5D=".urlencode(($Y!==null?$rf:"IS NULL"))."&where%5B$t%5D%5Bval%5D=".urlencode($Y);}function
convert_fields($e,$o,$L=array()){$I="";foreach($e
as$y=>$X){if($L&&!in_array(idf_escape($y),$L))continue;$wa=convert_field($o[$y]);if($wa)$I.=", $wa AS ".idf_escape($y);}return$I;}function
cookie($B,$Y,$se=2592000){global$ba;return
header("Set-Cookie: $B=".urlencode($Y).($se?"; expires=".gmdate("D, d M Y H:i:s",time()+$se)." GMT":"")."; path=".preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]).($ba?"; secure":"")."; HttpOnly; SameSite=lax",false);}function
get_settings($xb){parse_str($_COOKIE[$xb],$kh);return$kh;}function
get_setting($y,$xb="adminer_settings"){$kh=get_settings($xb);return$kh[$y];}function
save_settings($kh,$xb="adminer_settings"){return
cookie($xb,http_build_query($kh+get_settings($xb)));}function
restart_session(){if(!ini_bool("session.use_cookies"))session_start();}function
stop_session($Zc=false){$Ki=ini_bool("session.use_cookies");if(!$Ki||$Zc){session_write_close();if($Ki&&@ini_set("session.use_cookies",false)===false)session_start();}}function&get_session($y){return$_SESSION[$y][DRIVER][SERVER][$_GET["username"]];}function
set_session($y,$X){$_SESSION[$y][DRIVER][SERVER][$_GET["username"]]=$X;}function
auth_url($Si,$M,$V,$j=null){global$Zb;preg_match('~([^?]*)\??(.*)~',remove_from_uri(implode("|",array_keys($Zb))."|username|".($j!==null?"db|":"").session_name()),$A);return"$A[1]?".(sid()?SID."&":"").($Si!="server"||$M!=""?urlencode($Si)."=".urlencode($M)."&":"")."username=".urlencode($V).($j!=""?"&db=".urlencode($j):"").($A[2]?"&$A[2]":"");}function
is_ajax(){return($_SERVER["HTTP_X_REQUESTED_WITH"]=="XMLHttpRequest");}function
redirect($ue,$Je=null){if($Je!==null){restart_session();$_SESSION["messages"][preg_replace('~^[^?]*~','',($ue!==null?$ue:$_SERVER["REQUEST_URI"]))][]=$Je;}if($ue!==null){if($ue=="")$ue=".";header("Location: $ue");exit;}}function
query_redirect($G,$ue,$Je,$xg=true,$Cc=true,$Lc=false,$ai=""){global$f,$m,$b;if($Cc){$_h=microtime(true);$Lc=!$f->query($G);$ai=format_time($_h);}$uh="";if($G)$uh=$b->messageQuery($G,$ai,$Lc);if($Lc){$m=error().$uh.script("messagesPrint();");return
false;}if($xg)redirect($ue,$Je.$uh);return
true;}function
queries($G){global$f;static$sg=array();static$_h;if(!$_h)$_h=microtime(true);if($G===null)return
array(implode("\n",$sg),format_time($_h));$sg[]=(preg_match('~;$~',$G)?"DELIMITER ;;\n$G;\nDELIMITER ":$G).";";return$f->query($G);}function
apply_queries($G,$S,$zc='Adminer\table'){foreach($S
as$Q){if(!queries("$G ".$zc($Q)))return
false;}return
true;}function
queries_redirect($ue,$Je,$xg){list($sg,$ai)=queries(null);return
query_redirect($sg,$ue,$Je,$xg,false,!$xg,$ai);}function
format_time($_h){return
sprintf('%.3f 秒',max(0,microtime(true)-$_h));}function
relative_uri(){return
str_replace(":","%3a",preg_replace('~^[^?]*/([^?]*)~','\1',$_SERVER["REQUEST_URI"]));}function
remove_from_uri($Nf=""){return
substr(preg_replace("~(?<=[?&])($Nf".(SID?"":"|".session_name()).")=[^&]*&~",'',relative_uri()."&"),0,-1);}function
get_file($y,$Mb=false,$Qb=""){$Rc=$_FILES[$y];if(!$Rc)return
null;foreach($Rc
as$y=>$X)$Rc[$y]=(array)$X;$I='';foreach($Rc["error"]as$y=>$m){if($m)return$m;$B=$Rc["name"][$y];$ii=$Rc["tmp_name"][$y];$tb=file_get_contents($Mb&&preg_match('~\.gz$~',$B)?"compress.zlib://$ii":$ii);if($Mb){$_h=substr($tb,0,3);if(function_exists("iconv")&&preg_match("~^\xFE\xFF|^\xFF\xFE~",$_h))$tb=iconv("utf-16","utf-8",$tb);elseif($_h=="\xEF\xBB\xBF")$tb=substr($tb,3);}$I.=$tb;if($Qb)$I.=(preg_match("($Qb\\s*\$)",$tb)?"":$Qb)."\n\n";}return$I;}function
upload_error($m){$Fe=($m==UPLOAD_ERR_INI_SIZE?ini_get("upload_max_filesize"):0);return($m?'無法上傳檔案。'.($Fe?" ".sprintf('允許的檔案上限大小為 %sB。',$Fe):""):'檔案不存在。');}function
repeat_pattern($Xf,$qe){return
str_repeat("$Xf{0,65535}",$qe/65535)."$Xf{0,".($qe%65535)."}";}function
is_utf8($X){return(preg_match('~~u',$X)&&!preg_match('~[\0-\x8\xB\xC\xE-\x1F]~',$X));}function
shorten_utf8($P,$qe=80,$Fh=""){if(!preg_match("(^(".repeat_pattern("[\t\r\n -\x{10FFFF}]",$qe).")($)?)u",$P,$A))preg_match("(^(".repeat_pattern("[\t\r\n -~]",$qe).")($)?)",$P,$A);return
h($A[1]).$Fh.(isset($A[2])?"":"<i>…</i>");}function
format_number($X){return
strtr(number_format($X,0,".",','),preg_split('~~u','0123456789',-1,PREG_SPLIT_NO_EMPTY));}function
friendly_url($X){return
preg_replace('~\W~i','-',$X);}function
table_status1($Q,$Mc=false){$I=table_status($Q,$Mc);return($I?:array("Name"=>$Q));}function
column_foreign_keys($Q){global$b;$I=array();foreach($b->foreignKeys($Q)as$q){foreach($q["source"]as$X)$I[$X][]=$q;}return$I;}function
fields_from_edit(){global$l;$I=array();foreach((array)$_POST["field_keys"]as$y=>$X){if($X!=""){$X=bracket_escape($X);$_POST["function"][$X]=$_POST["field_funs"][$y];$_POST["fields"][$X]=$_POST["field_vals"][$y];}}foreach((array)$_POST["fields"]as$y=>$X){$B=bracket_escape($y,1);$I[$B]=array("field"=>$B,"privileges"=>array("insert"=>1,"update"=>1,"where"=>1,"order"=>1),"null"=>1,"auto_increment"=>($y==$l->primary),);}return$I;}function
dump_headers($Cd,$Re=false){global$b;$I=$b->dumpHeaders($Cd,$Re);$Jf=$_POST["output"];if($Jf!="text")header("Content-Disposition: attachment; filename=".$b->dumpFilename($Cd).".$I".($Jf!="file"&&preg_match('~^[0-9a-z]+$~',$Jf)?".$Jf":""));session_write_close();ob_flush();flush();return$I;}function
dump_csv($J){foreach($J
as$y=>$X){if(preg_match('~["\n,;\t]|^0|\.\d*0$~',$X)||$X==="")$J[$y]='"'.str_replace('"','""',$X).'"';}echo
implode(($_POST["format"]=="csv"?",":($_POST["format"]=="tsv"?"\t":";")),$J)."\r\n";}function
apply_sql_function($s,$d){return($s?($s=="unixepoch"?"DATETIME($d, '$s')":($s=="count distinct"?"COUNT(DISTINCT ":strtoupper("$s("))."$d)"):$d);}function
get_temp_dir(){$I=ini_get("upload_tmp_dir");if(!$I){if(function_exists('sys_get_temp_dir'))$I=sys_get_temp_dir();else{$p=@tempnam("","");if(!$p)return
false;$I=dirname($p);unlink($p);}}return$I;}function
file_open_lock($p){if(is_link($p))return;$r=@fopen($p,"c+");if(!$r)return;chmod($p,0660);if(!flock($r,LOCK_EX)){fclose($r);return;}return$r;}function
file_write_unlock($r,$Gb){rewind($r);fwrite($r,$Gb);ftruncate($r,strlen($Gb));file_unlock($r);}function
file_unlock($r){flock($r,LOCK_UN);fclose($r);}function
password_file($h){$p=get_temp_dir()."/adminer.key";if(!$h&&!file_exists($p))return
false;$r=file_open_lock($p);if(!$r)return
false;$I=stream_get_contents($r);if(!$I){$I=rand_string();file_write_unlock($r,$I);}else
file_unlock($r);return$I;}function
rand_string(){return
md5(uniqid(mt_rand(),true));}function
select_value($X,$_,$n,$Zh){global$b;if(is_array($X)){$I="";foreach($X
as$ce=>$W)$I.="<tr>".($X!=array_values($X)?"<th>".h($ce):"")."<td>".select_value($W,$_,$n,$Zh);return"<table>$I</table>";}if(!$_)$_=$b->selectLink($X,$n);if($_===null){if(is_mail($X))$_="mailto:$X";if(is_url($X))$_=$X;}$I=$b->editVal($X,$n);if($I!==null){if(!is_utf8($I))$I="\0";elseif($Zh!=""&&is_shortable($n))$I=shorten_utf8($I,max(0,+$Zh));else$I=h($I);}return$b->selectVal($I,$_,$n,$X);}function
is_mail($mc){$xa='[-a-z0-9!#$%&\'*+/=?^_`{|}~]';$Yb='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';$Xf="$xa+(\\.$xa+)*@($Yb?\\.)+$Yb";return
is_string($mc)&&preg_match("(^$Xf(,\\s*$Xf)*\$)i",$mc);}function
is_url($P){$Yb='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';return
preg_match("~^(https?)://($Yb?\\.)+$Yb(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i",$P);}function
is_shortable($n){return
preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~',$n["type"]);}function
count_rows($Q,$Z,$Wd,$nd){$G=" FROM ".table($Q).($Z?" WHERE ".implode(" AND ",$Z):"");return($Wd&&(JUSH=="sql"||count($nd)==1)?"SELECT COUNT(DISTINCT ".implode(", ",$nd).")$G":"SELECT COUNT(*)".($Wd?" FROM (SELECT 1$G GROUP BY ".implode(", ",$nd).") x":$G));}function
slow_query($G){global$b,$T,$l;$j=$b->database();$bi=$b->queryTimeout();$oh=$l->slowQuery($G,$bi);$g=null;if(!$oh&&support("kill")&&is_object($g=connect($b->credentials()))&&($j==""||$g->select_db($j))){$fe=$g->result(connection_id());echo
script("var timeout = setTimeout(function () { ajax('".js_escape(ME)."script=kill', function () {}, 'kill=$fe&token=$T'); }, 1000 * $bi);");}ob_flush();flush();$I=@get_key_vals(($oh?:$G),$g,false);if($g){echo
script("clearTimeout(timeout);");ob_flush();flush();}return$I;}function
get_token(){$vg=rand(1,1e6);return($vg^$_SESSION["token"]).":$vg";}function
verify_token(){list($T,$vg)=explode(":",$_POST["token"]);return($vg^$_SESSION["token"])==$T;}function
lzw_decompress($Ha){$Ub=256;$Ia=8;$cb=array();$Gg=0;$Hg=0;for($t=0;$t<strlen($Ha);$t++){$Gg=($Gg<<8)+ord($Ha[$t]);$Hg+=8;if($Hg>=$Ia){$Hg-=$Ia;$cb[]=$Gg>>$Hg;$Gg&=(1<<$Hg)-1;$Ub++;if($Ub>>$Ia)$Ia++;}}$Tb=range("\0","\xFF");$I="";foreach($cb
as$t=>$bb){$lc=$Tb[$bb];if(!isset($lc))$lc=$cj.$cj[0];$I.=$lc;if($t)$Tb[]=$cj.$lc[0];$cj=$lc;}return$I;}function
script($rh,$li="\n"){return"<script".nonce().">$rh</script>$li";}function
script_src($Hi){return"<script src='".h($Hi)."'".nonce()."></script>\n";}function
nonce(){return' nonce="'.get_nonce().'"';}function
target_blank(){return' target="_blank" rel="noreferrer noopener"';}function
h($P){return
str_replace("\0","&#0;",htmlspecialchars($P,ENT_QUOTES,'utf-8'));}function
nl_br($P){return
str_replace("\n","<br>",$P);}function
checkbox($B,$Y,$Wa,$he="",$qf="",$ab="",$ie=""){$I="<input type='checkbox' name='$B' value='".h($Y)."'".($Wa?" checked":"").($ie?" aria-labelledby='$ie'":"").">".($qf?script("qsl('input').onclick = function () { $qf };",""):"");return($he!=""||$ab?"<label".($ab?" class='$ab'":"").">$I".h($he)."</label>":$I);}function
optionlist($vf,$Yg=null,$Li=false){$I="";foreach($vf
as$ce=>$W){$wf=array($ce=>$W);if(is_array($W)){$I.='<optgroup label="'.h($ce).'">';$wf=$W;}foreach($wf
as$y=>$X)$I.='<option'.($Li||is_string($y)?' value="'.h($y).'"':'').($Yg!==null&&($Li||is_string($y)?(string)$y:$X)===$Yg?' selected':'').'>'.h($X);if(is_array($W))$I.='</optgroup>';}return$I;}function
html_select($B,$vf,$Y="",$pf="",$ie=""){return"<select name='".h($B)."'".($ie?" aria-labelledby='$ie'":"").">".optionlist($vf,$Y)."</select>".($pf?script("qsl('select').onchange = function () { $pf };",""):"");}function
html_radios($B,$vf,$Y=""){$I="";foreach($vf
as$y=>$X)$I.="<label><input type='radio' name='".h($B)."' value='".h($y)."'".($y==$Y?" checked":"").">".h($X)."</label>";return$I;}function
confirm($Je="",$Zg="qsl('input')"){return
script("$Zg.onclick = function () { return confirm('".($Je?js_escape($Je):'你確定嗎？')."'); };","");}function
print_fieldset($u,$pe,$Wi=false){echo"<fieldset><legend>","<a href='#fieldset-$u'>$pe</a>",script("qsl('a').onclick = partial(toggle, 'fieldset-$u');",""),"</legend>","<div id='fieldset-$u'".($Wi?"":" class='hidden'").">\n";}function
bold($Ka,$ab=""){return($Ka?" class='active $ab'":($ab?" class='$ab'":""));}function
js_escape($P){return
addcslashes($P,"\r\n'\\/");}function
pagination($D,$Db){return" ".($D==$Db?$D+1:'<a href="'.h(remove_from_uri("page").($D?"&page=$D".($_GET["next"]?"&next=".urlencode($_GET["next"]):""):"")).'">'.($D+1)."</a>");}function
hidden_fields($og,$Fd=array(),$hg=''){$I=false;foreach($og
as$y=>$X){if(!in_array($y,$Fd)){if(is_array($X))hidden_fields($X,array(),$y);else{$I=true;echo'<input type="hidden" name="'.h($hg?$hg."[$y]":$y).'" value="'.h($X).'">';}}}return$I;}function
hidden_fields_get(){echo(sid()?'<input type="hidden" name="'.session_name().'" value="'.h(session_id()).'">':''),(SERVER!==null?'<input type="hidden" name="'.DRIVER.'" value="'.h(SERVER).'">':""),'<input type="hidden" name="username" value="'.h($_GET["username"]).'">';}function
enum_input($U,$ya,$n,$Y,$pc=null){global$b;preg_match_all("~'((?:[^']|'')*)'~",$n["length"],$Ae);$I=($pc!==null?"<label><input type='$U'$ya value='$pc'".((is_array($Y)?in_array($pc,$Y):$Y===$pc)?" checked":"")."><i>".'空值'."</i></label>":"");foreach($Ae[1]as$t=>$X){$X=stripcslashes(str_replace("''","'",$X));$Wa=(is_array($Y)?in_array($X,$Y):$Y===$X);$I.=" <label><input type='$U'$ya value='".h($X)."'".($Wa?' checked':'').'>'.h($b->editVal($X,$n)).'</label>';}return$I;}function
input($n,$Y,$s,$Ba=false){global$l,$b;$B=h(bracket_escape($n["field"]));echo"<td class='function'>";if(is_array($Y)&&!$s){$Y=json_encode($Y,128);$s="json";}$Fg=(JUSH=="mssql"&&$n["auto_increment"]);if($Fg&&!$_POST["save"])$s=null;$id=(isset($_GET["select"])||$Fg?array("orig"=>'原始'):array())+$b->editFunctions($n);$Vb=stripos($n["default"],"GENERATED ALWAYS AS ")===0?" disabled=''":"";$ya=" name='fields[$B]'$Vb".($Ba?" autofocus":"");$vc=$l->enumLength($n);if($vc){$n["type"]="enum";$n["length"]=$vc;}echo$l->unconvertFunction($n)." ";if($n["type"]=="enum")echo
h($id[""])."<td>".$b->editInput($_GET["edit"],$n,$ya,$Y);else{$ud=(in_array($s,$id)||isset($id[$s]));echo(count($id)>1?"<select name='function[$B]'$Vb>".optionlist($id,$s===null||$ud?$s:"")."</select>".on_help("getTarget(event).value.replace(/^SQL\$/, '')",1).script("qsl('select').onchange = functionChange;",""):h(reset($id))).'<td>';$Qd=$b->editInput($_GET["edit"],$n,$ya,$Y);if($Qd!="")echo$Qd;elseif(preg_match('~bool~',$n["type"]))echo"<input type='hidden'$ya value='0'>"."<input type='checkbox'".(preg_match('~^(1|t|true|y|yes|on)$~i',$Y)?" checked='checked'":"")."$ya value='1'>";elseif($n["type"]=="set"){preg_match_all("~'((?:[^']|'')*)'~",$n["length"],$Ae);foreach($Ae[1]as$t=>$X){$X=stripcslashes(str_replace("''","'",$X));$Wa=in_array($X,explode(",",$Y),true);echo" <label><input type='checkbox' name='fields[$B][$t]' value='".h($X)."'".($Wa?' checked':'').">".h($b->editVal($X,$n)).'</label>';}}elseif(preg_match('~blob|bytea|raw|file~',$n["type"])&&ini_bool("file_uploads"))echo"<input type='file' name='fields-$B'>";elseif(($Xh=preg_match('~text|lob|memo~i',$n["type"]))||preg_match("~\n~",$Y)){if($Xh&&JUSH!="sqlite")$ya.=" cols='50' rows='12'";else{$K=min(12,substr_count($Y,"\n")+1);$ya.=" cols='30' rows='$K'".($K==1?" style='height: 1.2em;'":"");}echo"<textarea$ya>".h($Y).'</textarea>';}elseif($s=="json"||preg_match('~^jsonb?$~',$n["type"]))echo"<textarea$ya cols='50' rows='12' class='jush-js'>".h($Y).'</textarea>';else{$xi=$l->types();$He=(!preg_match('~int~',$n["type"])&&preg_match('~^(\d+)(,(\d+))?$~',$n["length"],$A)?((preg_match("~binary~",$n["type"])?2:1)*$A[1]+($A[3]?1:0)+($A[2]&&!$n["unsigned"]?1:0)):($xi[$n["type"]]?$xi[$n["type"]]+($n["unsigned"]?0:1):0));if(JUSH=='sql'&&min_version(5.6)&&preg_match('~time~',$n["type"]))$He+=7;echo"<input".((!$ud||$s==="")&&preg_match('~(?<!o)int(?!er)~',$n["type"])&&!preg_match('~\[\]~',$n["full_type"])?" type='number'":"")." value='".h($Y)."'".($He?" data-maxlength='$He'":"").(preg_match('~char|binary~',$n["type"])&&$He>20?" size='40'":"")."$ya>";}echo$b->editHint($_GET["edit"],$n,$Y);$Tc=0;foreach($id
as$y=>$X){if($y===""||!$X)break;$Tc++;}if($Tc)echo
script("mixin(qsl('td'), {onchange: partial(skipOriginal, $Tc), oninput: function () { this.onchange(); }});");}}function
process_input($n){global$b,$l;if(stripos($n["default"],"GENERATED ALWAYS AS ")===0)return
null;$v=bracket_escape($n["field"]);$s=$_POST["function"][$v];$Y=$_POST["fields"][$v];if($n["type"]=="enum"||$l->enumLength($n)){if($Y==-1)return
false;if($Y=="")return"NULL";}if($n["auto_increment"]&&$Y=="")return
null;if($s=="orig")return(preg_match('~^CURRENT_TIMESTAMP~i',$n["on_update"])?idf_escape($n["field"]):false);if($s=="NULL")return"NULL";if($n["type"]=="set")$Y=implode(",",(array)$Y);if($s=="json"){$s="";$Y=json_decode($Y,true);if(!is_array($Y))return
false;return$Y;}if(preg_match('~blob|bytea|raw|file~',$n["type"])&&ini_bool("file_uploads")){$Rc=get_file("fields-$v");if(!is_string($Rc))return
false;return$l->quoteBinary($Rc);}return$b->processInput($n,$Y,$s);}function
search_tables(){global$b,$f;$_GET["where"][0]["val"]=$_POST["query"];$bh="<ul>\n";foreach(table_status('',true)as$Q=>$R){$B=$b->tableName($R);if(isset($R["Engine"])&&$B!=""&&(!$_POST["tables"]||in_array($Q,$_POST["tables"]))){$H=$f->query("SELECT".limit("1 FROM ".table($Q)," WHERE ".implode(" AND ",$b->selectSearchProcess(fields($Q),array())),1));if(!$H||$H->fetch_row()){$kg="<a href='".h(ME."select=".urlencode($Q)."&where[0][op]=".urlencode($_GET["where"][0]["op"])."&where[0][val]=".urlencode($_GET["where"][0]["val"]))."'>$B</a>";echo"$bh<li>".($H?$kg:"<p class='error'>$kg: ".error())."\n";$bh="";}}}echo($bh?"<p class='message'>".'沒有資料表。':"</ul>")."\n";}function
on_help($jb,$mh=0){return
script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $jb, $mh) }, onmouseout: helpMouseout});","");}function
edit_form($Q,$o,$J,$Fi){global$b,$T,$m;$Lh=$b->tableName(table_status1($Q,true));page_header(($Fi?'編輯':'新增'),$m,array("select"=>array($Q,$Lh)),$Lh);$b->editRowPrint($Q,$o,$J,$Fi);if($J===false){echo"<p class='error'>".'沒有資料行。'."\n";return;}echo"<form action='' method='post' enctype='multipart/form-data' id='form'>\n";if(!$o)echo"<p class='error'>".'您沒有許可權更新這個資料表。'."\n";else{echo"<table class='layout'>".script("qsl('table').onkeydown = editingKeydown;");$Ba=!$_POST;foreach($o
as$B=>$n){echo"<tr><th>".$b->fieldName($n);$k=$_GET["set"][bracket_escape($B)];if($k===null){$k=$n["default"];if($n["type"]=="bit"&&preg_match("~^b'([01]*)'\$~",$k,$Cg))$k=$Cg[1];if(JUSH=="sql"&&preg_match('~binary~',$n["type"]))$k=bin2hex($k);}$Y=($J!==null?($J[$B]!=""&&JUSH=="sql"&&preg_match("~enum|set~",$n["type"])&&is_array($J[$B])?implode(",",$J[$B]):(is_bool($J[$B])?+$J[$B]:$J[$B])):(!$Fi&&$n["auto_increment"]?"":(isset($_GET["select"])?false:$k)));if(!$_POST["save"]&&is_string($Y))$Y=$b->editVal($Y,$n);$s=($_POST["save"]?(string)$_POST["function"][$B]:($Fi&&preg_match('~^CURRENT_TIMESTAMP~i',$n["on_update"])?"now":($Y===false?null:($Y!==null?'':'NULL'))));if(!$_POST&&!$Fi&&$Y==$n["default"]&&preg_match('~^[\w.]+\(~',$Y))$s="SQL";if(preg_match("~time~",$n["type"])&&preg_match('~^CURRENT_TIMESTAMP~i',$Y)){$Y="";$s="now";}if($n["type"]=="uuid"&&$Y=="uuid()"){$Y="";$s="uuid";}if($Ba!==false)$Ba=($n["auto_increment"]||$s=="now"||$s=="uuid"?null:true);input($n,$Y,$s,$Ba);if($Ba)$Ba=false;echo"\n";}if(!support("table"))echo"<tr>"."<th><input name='field_keys[]'>".script("qsl('input').oninput = fieldChange;")."<td class='function'>".html_select("field_funs[]",$b->editFunctions(array("null"=>isset($_GET["select"]))))."<td><input name='field_vals[]'>"."\n";echo"</table>\n";}echo"<p>\n";if($o){echo"<input type='submit' value='".'儲存'."'>\n";if(!isset($_GET["select"]))echo"<input type='submit' name='insert' value='".($Fi?'儲存並繼續編輯':'儲存並新增下一筆')."' title='Ctrl+Shift+Enter'>\n",($Fi?script("qsl('input').onclick = function () { return !ajaxForm(this.form, '".'保存中'."…', this); };"):"");}echo($Fi?"<input type='submit' name='delete' value='".'刪除'."'>".confirm()."\n":"");if(isset($_GET["select"]))hidden_fields(array("check"=>(array)$_POST["check"],"clone"=>$_POST["clone"],"all"=>$_POST["all"]));echo'<input type="hidden" name="referer" value="',h(isset($_POST["referer"])?$_POST["referer"]:$_SERVER["HTTP_REFERER"]),'">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="',$T,'">
</form>
';}if(isset($_GET["file"])){if(substr($ia,-4)!='-dev'){if($_SERVER["HTTP_IF_MODIFIED_SINCE"]){header("HTTP/1.1 304 Not Modified");exit;}header("Expires: ".gmdate("D, d M Y H:i:s",time()+365*24*60*60)." GMT");header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");header("Cache-Control: immutable");}if($_GET["file"]=="favicon.ico"){header("Content-Type: image/x-icon");echo
lzw_decompress("\0\0\0` \0�\0\n @\0�C��\"\0`E�Q����?�tvM'�Jd�d\\�b0\0�\"��fӈ��s5����A�XPaJ�0���8�#R�T��z`�#.��c�X��Ȁ?�-\0�Im?�.�M��\0ȯ(̉��/(%�\0");}elseif($_GET["file"]=="default.css"){header("Content-Type: text/css; charset=utf-8");echo
lzw_decompress("b7�'���o9�c`��a1���#y��d��C�1��tFQx�\\2�\n�S���n0�'#I��,\$M�c)��c����1i�Xi3ͦ���n)T�i��d:FcI�[��c��	��Fé�vt2�+�C,�a�G�F����:;Nu�)����Ǜ!�tl���F�|��,�`pw�S-����������oQk�� n�E��O+,=�4�mM���Ƌ�GS��Zh�6��. uO�M�C@����M'�(�b5�ҩ��H�a2)�qиpe6�?t#Z-���ox�<���s���;��H�4\$�䥍�ۚ��a�4�\"�(�!C,D�N��;����Jj����@�@�!����K�����6��jX�\r����@ 2@�b��(Z�Apl��8��h�.�=*H�4q3�AЂ�.��K���!�f�qr�!�1�Ȏ�c���*+ �(�\n�2�j���(dYA���D�t�ϑ�m*H�9+�0�0�\n0t���J�,E�ER� X��u[&@0�A��7=�;����K��;0�D�7Ajm*`�3:v`��ūk��Ʊ.�x�Xv(ec�������Emz\\�0C�G2��Jt2(à��c�N<��s^�2��6Z̅�?c��X�m���ϥ(�d9?>�/�Y^I�%����5=H==\0T �6���\"��ح�\r���mH��-C��z��\n����Q�j<<Z��6��v>����~LHť��p�,�Yp��P�9{}�g߻5���Y�	>g5�@8o�\n>��-nҩ��ԐR)J��#j<7�(��ĸN%�}��*2��\rA�јF0�Xވ�Cp�:��Z�Ƭ��:G�ԏ�v=�j�[C\r��z/��:@���B��<�(z.�P���Y�h7\"�j�/܉��]�\\���6`�Ҋ4=x�^1��\0C0����q�!�4�%l�SP[K}�v�#��@g�����\r�h=�����RGa���TTRNv��:�\"���u���\\e�4	U\rt�W�����Z �CF,@����1\r�\r�0��p!�OY4:����!�����hV��\n�`	�pn�Ϛ\0Y+�20Z�anYq5�p��\"a|��p��n#�U\0�8H���bIp(��s��Yt���HI&�zN0ؖ@���tAf��)��ƙZFՂlKr�/C`�C�B�1*�&��th���WI�0C�\\*)mJ���[âdi3K\0�)�dϘJ261��\n-o�٫��0ߤ���X�b\r�qp��ԆOY0X��֟�C`�S�a��Z�[�t#�x��@2\r��Z̲�� �b-��]C\\��l� \"5,���R����j�t�K�P`��,���s�\r�1xО@���K\"d�'��F.6,T	�[�M�֦��X������������Bx�2�j�иɃC��(�Mm�d�\"��W�t����8�sDY��Z �\"�VS暙�D2��+%�?�VD�#�����9Gr���S�b�e�,\r�S���k�	����(��]a��\r��1�P䀛iɓu\$���	��sbA��>T�T�n�e7�n�R<xf��'��C��5���^���)�\n������`-\"g���Qy�\r�ת�`BN\nAd�#@��)\$�R}�@����yte&r��@����+���[�T�\nX��셜��vAG��U.�]j�`��r*���x����X��Qp-��B��Cy�r���<�.\0#��:�K��)l�NH���x��WP���������8���<��s��6��Ȯʅwʒ���ypc�E��J��w�Q�A�+�4/�02d��mÐf ��\$��ţ4vvy�`I�\$�d�5U\0�Pj(%�K���47�La��^��zM\0�x�m���х���RTy����!���w�m�j[F��{�ca�����m�V� <��s,�������9T�]gu���H�/���V+y�jM���ݨM�G���;�%���mW\r�ђ8��0�ϴ6�K�����W�{�k�]Z�]ÈO*(`#t������A�6�{��%Oaq�H���Er�UC(b\ret�%I��X�\\�0��X�YQ	��(T-���2H���r�����E�qd�w��AKY�W ܹ��<��1�Gp��z��\$�h6X��*f�\"<:��;V���6����;@���@�w��r���K�ѽ�@o��<�\0}v�����M���=���<�GD�wᷴY���pT�s�?~��=��=��Fn?x�������=�w���_(7����R'��Y�| \\y�z�n���}��=%p�0j?���B!���\nT��o��l����k���GHu`4J�/G�]@�	~=N�&�H%��jK|\0pj�8����Np��xׯ��K�5+��*��L��b��\$kI\rv�휎����P��z�~Q0��o�=�\r�i��Y�կ���������Д�\nm�ް�p��`�p:&�&��۰�����H�p��	-��P�\n�p��U\n`�I6��&d�i<�)x�h�s����4�pJ��q4@��7\0Z\0�HJ�g˥�F�����5���N*��!�r�¥@������a®]�`EH�cG@�&���fF��Zː�H�v	��4/\0�&�ąqH.�H�?b-��a7@Ƙ1�i����S�曑�qQKb�E\0�RŃ�8�Q �4Z���Q.8�����\n\r��!�(?�>s�K#gQ\$r0/�P8��\"rW��#�Ds�1%�U&Ì��'2@�y%�P�kc'Re&2Z6\0�)Rꒋ�\"%&Q:�O��R��\"ҍ%�\r�c,2���'�a)�f��&%Q,R� ��-�c �	.hI.���.2�-�\r*\"�*qlX����I%��!����.�R+1o)���!-S0)��\r�6��`��R��2�Y)��Y,�3�552�)� �SD�IDB�/4�f~��D��0R#1�1�8�\"��4��28�2�?S��R�,Ӟ��5RI:��(ө��;s� �1��b�0��1���2ss9`��:��<21:��:s����;�@3�;S�<bm&3�?3�8�92s�9ҳ(�>3�>e�b\0�3�3A��Q�%�>q�Ct;.c�?�;ӡ<�B\0踓�Bq���>T];�<T/4w3s�8ѡK;GR~����t�\$�y �&4�T8�{#�ns���AI��D��'�Dg��JTF��5r� ��&S�.�&t�62g@sM�0��5��O4�Ob�O�QH�����P��7UQKP��P�\0�ژ5#N��3U/Qu+O+&cPe�RU7SUGT�51t\"-4'+r+��9E�3Uk(��&2�S��W3;.��K�#��/(ѵA@؞Tk=Ѵ��X�@�L�E��8��(�\0 ���&�S�M�u'��u�W�\\�RC&5y]�U*W]�00`��;Z�KK ��9R[S�CN5�SV	Q�R,�s_Ĺ6�C6@6';hIb�1,61aV/^�cV=N\0U����(�6R~���Il\\3�e��00�\ra�BD�d��:\"�4���,");}elseif($_GET["file"]=="dark.css"){header("Content-Type: text/css; charset=utf-8");echo
lzw_decompress("b7�'���o9�c����b�F��r7�M�HP�`2\r\"'�\r�\rF#s1�p;��Ɠ���e2I���Y.�GF�I��:4��S���3��㔚Y�u(Ìc(�`h��#%0[��L�����h���C!���E����b5�Ú�������y�fb��w	�z#���1�P��6����Xt4a�l�t�4��g�E��B�#��ja�� �K��q8ڝh�]�����a�2ƼP ��y����i2��3)�U���o�l\0�}��vٛ�r��7ϸ� N2�)�3M�#��)PKj��x����8C(\\5��S\n?��v޷邊8��\\������ �[8�x�#��G���!a�^>�qh]�#����L\\6�#��2��<&7����G��1Hr�`*���7*��#��@-��6D��:�;S:��*�l�<�!ʹ�����1��\r.-��5+?T\0@1?n�\n�\$	�6����0��,ڎ�A�lK��=P�0ʉ1\neQ�%\$�2	eGR��K�0�R�V���{.�Ĩ�>��s��0�,b0��͹3��\noe����r��t�e���j1��8Ģ���+��� /[�Aâ758�4�A@d74�*�0,�8�c����+��i�b��ˌY#.7���GhV��`�7���!����cT�d��y��\n�?���F3�g�ƃ	eu���։�h�:+�<6�G�f��\\4���X�>*�`0LϰMzZ�B#{*x27�eo}��xޛ���:\r��C:&`f���MpձCL�T����1����H���`�G��<_�pd��Ajr[����@2\r#�h�V�D>�u%��3���b:h���kA�1\\ɀG����������C��0�Zs���a����;S��L�0L'��Yk��]��i\r)�v ����m*'7Ʋ�[�>@������Hpzf)��`l����`�׫h�w���f�|��7!�i⥀�Ƞtw���\0p��'��sҿ�b`M���gx\")�=I�\$��C��w��ǩPrl��!5 ��p�hc�@�2 ����^���48(��\$dl���A���Q�,���	E�A�:C���P��E\"�!�F��h3\$h�C�a\r��2ȹ'�PmPI��>���bE��Ƹ�΁ln���@Ʃ��~kD���?�9���Q�q\r�8LC,L\0");}elseif($_GET["file"]=="functions.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("f:��gCI��\n8��3)��7���81��x:\nOg#)��r7\n\"��`�|2�gSi�H)N�S��\r��\"0��@�)�`(\$s6O!��V/=��' T4�=��iS��6IO�G#�X�VC��s��Z1.�hp8,�[�H�~Cz���2�l�c3���s���I�b�4\n�F8T��I���U*fz��r0�E����y���f�Y.:��I��(�c��΋!�_l��^�^(��N{S��)r�q�Y��l٦3�3�\n�+G���y���i���xV3w�uh�^r����a۔���c��\r���(.��Ch�<\r)�ѣ�`�7���43'm5���\n�P�:2�P����q ���C�}ī�����38�B�0�hR��r(�0��b\\0�Hr44��B�!�p�\$�rZZ�2܉.Ƀ(\\�5�|\nC(�\"��P���.��N�RT�Γ��>�HN��8HP�\\�7Jp~���2%��OC�1�.��C8·H��*�j����S(�i!Lr��D�# ȗ�`Bγ�u\\�i�B!x\\�c�m-K��X���38�A���\r�X���cH�7�#R�*/-̋�p�;�B \n�3!���z^�pΎ�m�R���t�m�I-\r��\0H��@k,�4����{�.��J�Ȭ�o�Vӷb?[�Q#>=ۖ�~�#\$%wB�>9d�0zW�wJ�D���2�9y��*��z,�NjIh\\9���N4���9�Ax^;�^m\n��r\"3���z7��N�\$����w���6�2�H�v9g���2��kG\n�-Ůp��1�C{\n����7��6������2ۭ�;�Y��4q�? �!pd��oW*��rR;�À�f��,�0��0M���0�\"�� ��\"�ħ���oF2:SH�� �/;������٩ri9��=�^�����z�͵W*�Z��dx՛��֡�ITqA�1��z�Y!u������~��.��P�(�p4�3���#hg-�	'�F�p�0���C+P�����, ����e���N~�y@fZK��O3�v\$�`�C�	N`�!�z�pdh\$6EJ�cBD��c8L��P� �66�OH�d	.�����Y#�t�H62���e��@��~]C�[��&=G��\\P(�2(յ����̐q�2�x�nÁJ�|2�)(�(eR���G�Q��Ty\n�!pΪ\0Q]��&�ޜS�^N`�_(\0R	�'\r*q�P����x�9,��-�);��]�/��w������C.e��y\0�,��	S787���5Hlj(�� �\0�մ����q�I�/=S�� �àD�<\r!�2+��A�� J�e ��!\r�m��NiD�������^ڈl7��z��gK�6��-ӵ�e��!\rEJ\ni*�\$@�RU0,\$U6 ?�6��:��un�(��k�p!���d`�>�5\n�<�\rp9�|ɹ�^fNg(r���TZU��S�jQ8n���y�d�\r�4:O�w>[͞�4�4G\"��7%������\\��P��hnB�i.0�۬��*j�s��	Ho^�}J2*	�J�W��Gjx�S8�F͊e��6�s���*�\r<�0wi-00o`��^�k����*A�,ɸ�䍺��i���nj��2索A\"����[;��n��B^��0-�����\n:<Ԉe�2���h-���2�n�/A�\r6����[o�-��c��R@U3\n�\n�T��=�R�j���7s\"���Y+�\"u�<fH��`a��z�E�����^7syo:!�V���k�m����if�ۻ�/�ڦ8;<e�N�2ͱS�W?e`�C*B��͔�ZB�]����:K�_7��Ċq��Q�)��/�:d�i����Z^�3��tꃥ��t*��\$��f�z50t�UJg���S\r�cX�����\rw7Z�N^`oxP���I��x?��T�ke�� �Jim)�x;�X�����C�=V=���<U��!�0��n��;���~AZ��7�����+Z�=n���{H��PURY����������4�Hǋ6'g��2K���~��|hT�A��1��V���>/�^��l.��SI�.�9g��~O��%ئ��̾�)A|��\n;-��n��[�t,�����Y�<>j\n��N�eP���O<��� q���(G!~����`_�\r~���`��.�>'H�O�2�yK����d:(�,�<�3�:�����+0nUYZ���^�)ww��!�����1����!����mG��ַgd�=���X�[ޢ�<��ߩW�����7���`�o�ҭ��������G���~`�i`��*@��v������\0)�ꐜ\$R#��������Ud�)KL��M*��@�@��O\0H��\\j�F\r����]�gK��i�\$�D�*g\0�\n��	��s� ��\$K0�&��	`{���6W`�x`�8�DG�*���eHV��8��\nmT�O�#P��@��������.�\r8�Y/&:D�	�Q�&%E�.�]��Я�.\"%&��n�\ny\0�-�RSO�B�0��	�v��D@�݂:��;\nDT��< �Q.\nc2��Ry@�m@���	��W����\n�L\r\0}�V����#����-�jE�Zt\\mFv���F��J�p�B���(����1� ��LX���	%t\nM���D���Z���r��Kg´C�[�ʴ	�� �\0Я�������R*-n�#j�#�����4�IW�\r\",�*�f��x�/���^��5&L��2p�L��7�^`����� V�`bS�v�i(�ev\n��|�RNj/%M�%���+�ƫ����߯�'���R�'''�W(r�(��)2�Қ���%�-%6���ˀ�J@�,��ֿN���Q\n�0ꆐ�g	��\$���*L��.n��Q%m�\"n*h�\0�w�B�O�\0\\FJ�Wg� f\$�C5dK5��5�aC��4H�(��.G���BF��8������ E����.��k3m�*)-*��[g,%��	��7�.��!\n�+ O<ȼ�C�+ϫ%�O=Rf����(���n�Y��ϲ�%��s�1�6�3;��ObE@�NSl#��|�4\0�U�G\"@�_ [7��S��@�\$DG���D�5=���K>r����\r ��Z��ֱ@���H�Ds��n\\�e)����b�'���BPGkx�Z���#TK:�w:�a2+�aeK�KR)\"�(4qGTxi	H�H@�&@%bZ����ܪ)3P�3f `�\r�I6G�%�/4�v�\\~�4�ݤ0�p���,��E�)PH8k\0�i��\$���3I4�P�V'F^� �'D��R���+Q�`�����8\n���D[V5,#�qW@�W�0�O2� �t�\rC6sY_6 �ZkZ@z3ryI�<5���.W���ҷ@5�Ģ#ꎄ5N �~��ȥu�\r����)3S]*g7�����ҕ�_ˉ�_�ĸV\nY�)a��1P���FI\r;u@/!![�e� �(CU�O�aS���KP��t3=5��O[�f:Q,_]o_�<�J*�\rg:_ �\r\"ZC��8XV}V2��3s8e��P�sF�SN~�S5U�5�z�ae	k�n�fOL�JV5��j�����Z��lE&]�1\rĢم5\rG� �uo���8<�U]3�2�%n�ַpr�5��\n\$\"O\rq��r)�f���7/Y���p�I#`��Kk;\"!t���h�usYj�[�R�\n{N5t�#NΜ�o6�X)�c6���e+.!��ߗ�\n	�b��ʒ�t�Ү��\n���j��(\0��2��4erEJ��d����@+x�\"\\@���� %v�����{`�����`��\n �	�oRi-IB�-���Nm\\q@�,`��Kz#��\r�?��՘6��<j��f��!�N�7���:��/�Tł\0�K\\�0�*_8L�m�^r���V�w��\"��кB��Q:5Kn���v\0��xt�;`�[��	�B�9!nv�<ۢSҏ{:P�p�r	~����1i*B.�tY�>\r��S�*nJ涨��7{�=|R]��ռ��4�i�U�2�2���Y3�c>a,X��3���9�\$�<A�Q�&2wӭ3���1��/�i����j��sO�&� �M@�\\���گ���8&I��m�x\0�	j�k�ۛE���^�	���&l��Q��\\\"�c�	��\rBs�ɉ��	���BN`�7�*Co<��	 �\n�ν�hC�9�#˙ �Ue�WX�z0Y�7}�c��8?hm�\$.#��\n`�\n���yD�@R�y���@|�Ǎ���P\0x�K� w�5�E�Le�@O��u���|�R�2��%�aA�cZ��:�<d�kZ��y{9Ȑ@ޕ\"B<R`�	�\n������QW(<��ʎ�革�q�j}`N���\$�[��@�ib����f�V%�(Wj:2�(�z��ś�N`��<� [Bښ:k���ʚ�]��piuC�,�����9���e�j&�Sl�h~��N�s;�;9��u@.<1����|�P�!���zC��	�	���{�`��Q!���5�4e�d�G�hr���P���}�{��FZrV:�����Ŀ�Z����|�P��WZ��:��d��~!�}�X��V)����p4���.\$\0C��V󁺩���{�@�\n`�	��<f��;dc'�\r��,\0t~x�N����y� ˽kEC�FK\"Z�@\\C�e�D.Gf�I�8�ͤ���CĥY��q9T�CU[��z�^*�J�K��VD�؊��&���b̷KK+��Ĳ�,C����,N!��\r3�Y�P�9�\$Z���n�\$S��5�\r��aK��E��n�71Z���3e��J؜x5�Q�.��\n@����ǣp��P�ѡֽn\r�r|*�r��% R��蔊�)��#��=W\0�B���z*�W���MC��_`�����P��T�5ۦWU(\0��\\W��&`��a�j)��V�W�ʧ�b�f�O�rU���Ǽ~#c�Ur�5�`���Gd����P��fW������Yj`��ǌ\n��G�>K�h���ǿ��[Mf�g̗�|�\"@s\r ���Ӷ��iU��m��~��f�K�.x�t���X�P�����׬����-���!û�~��+Rw�*©��ܞ�K��\\�-F/bN�s����Ru���i8r�\$\"�8j�Rn��5gf�@�FSM�S�c��5C��*y�C���cU�@o��esI�H9QoCQ�������=c������{�c8S�v!��;g�L�5<	�#�z#���qL�������V\r�2\$�J/{z���m��i�nG�?~ĕVu�0wʹ�=p�I��HĀX=�����t��� -��MJTP�#U��`��/3\\?�L�����y���*p�8���:��0{�k���2�&�P\0p8����Y�\\'�%�����.\r��,ƁJ�����/_,�4�~��,�!�Rn%x@��0Fdt\0�4����\nK�\n��G\$���Y	 �\0@,)�%:\r�]�L2\0�PV C\\Ѧ,B\r0W�\0��Rr<�UH���Q�Al��'�\0 �T�)�(c�\\I��;��/�ik��jV^�p��-PP��)���Hx������	Np&��\0d��8�':#Q\$�Q=�\0Wn�k��,�aS�����qbj\\�<g�9&�e�1����eb:��N|#������φ� ��n���h�wJ<8p�.���9y����A41auf���4�u\nL��%��/�:\r5�%H�jA^����s�\n���|�x��X�� �&�f���얐��@hESЕ^@:8@\r�n��^��H\"�&\rC�bq!�:&�AC�Jj�&	�&\r����N��<	�p�4��Tiw��-���2)ȫ�5O�B�3���#\$� ��e�VUB���v�d���xS��7e!�DF�O`����f.Q0D�#�\\��%��J|�\"�N\0�l`E�W���\nt��UR�(��L���gCcRy��T챞:j���W���E�.Y�\"*�25��X\\)d�\"lo'zJ��DJYX��\"#�����	G���>�)��Y�&2�,'ڄ�M����6�h���Z�N2ȷ@).��#�B��n;��Ga��R+�O!|�Ê��\r�ܓ:�������v[qD¨W��r���c��G�\\\0'WY�ؤ{�ׄ~2n\\�\$<�XQ2Dw�DDxCfH�,~厏�T\n(+A\"�.B�`���ǘ��L[E����	�\"Y\r�C�֐��`,z�XȔ?o��E�K\"��}&@`����i<���Uڹ\$OS1�Y�j�^8\n��8X����_	� z��'ȥQ�s�+c���X��L-ß���\rjD�5}Q���C�L&.=�P0>H�8H�����G��K2�0��B��P7�Q�%iG��h�^�&5�5�Q\"�9ъ)�P�BS�\n3&�ʐ����\rJ!HJ4\n.{�W�\"#Z�\0R��\r9+2���DE+ie2�Y�i�y���&���%��p�������K(��srp�%��`/65�b2T<���a�#�]��-Ի��.!�K������maJ�[KT�\0l�PY�'4�&�膗~���1t��4��2j�'\0��V(��\n*+W���ci4cʭӞ<���X�/�~�ɢ��L�&��2�b23RҐFT���R�%b<UX��������V \"Z�� p��\"�[�@m��A1c���k˔ �p���-�|��l�f4��ю\0�7��]�OI��@�����3r�\\Dd9*��\r3>s���V}���U,�y0���g�\0��\"&�����\0���P�BHCrh����i_�� ���`-pЅ�6J��/��1j�.����kYÎ9�(} r���P����\\�gu@��\0w�-�0�'�<�Ώ�\r�-\r�˖9��r+���Iޙ�+�&�����-=�|��yeж(	\r�H�z���>��N{�����0V��-�!�t���;ກ|\r��@R�\n\0�Y\"����\0��}�s\r\r�A�V�� }�d�H'8 0����9�1���8�\n؍@	P�&:\n�F�\0d�\0��5����3r�\rD�C�1���3���8��	�k�N='�70�QP%S�\\��:B�pzo�D���6�B�H�R�(�4��͐A1����Iv�q]��joD\r#)�#%c�ɱ%��%��_'B�O )x�c�a�=�/���6H�j��>,r��o)G���u)��#�&�#Is	I��~��_��O��J~��՞Yb%*?\$yP0��(	��%㠋�c�<�0	�kPt�B�����3\"E�X�2q�y�-:�@�ʀ���.!�qDW�0���* �(�Z�+/d��_g=���(`f��P���i���b�1x���b�>�pdd��T��E<[e)����y(}E�v|�]���OCQ�r�H��\0�A��W���J`V3�@B�I\rm�I�uISr�Ґx	 ���r�I��HJ�S��UB�\$�@ت�\"<�pe|�1́DD�*��DZ�e�T���5%G�O�\0��0I�(4D��m���פ	V�,{+���P�����A���U�]U�e��s�I+@���\$CMM]��->a�@Z�М�5����3*��v֪���yU�Cebj�ӈ�\r�HN�6�iZ�>V)7u�@��Z�H־�D|��5�Б�J�M�A)SЕ�,�i���f�l��PS:E�M���삩52p:�{�i�i�_�j���p6�.�>H(n\$�1i�IK��֪�3�V\r�]^ĳ��ꮧ\n�)0I��`B@�b�j6>h�F�g�/ y2��A3YG�� ���z�4�����k=��R�Z����AYΪaW���*�	�(5���!O���2ss'xg�x\0��\"��\n@Ek�\0�Rֳ��%Ց��'�B*f�Bnf�Sfצ5��+ʶ���#Bݯ��%RX�¶g�@R4�`\$i�e��;���	%�ʸ�(�|�ȇ\0��������]:�gԵ>��m~��\"+)��?�]������C0��\$S�<����Ѕ�+\0�֭�3��r��;H��iR�>�h�vg��%�����Y����RhT�%�N��l�c���d+a��E?<}�Tfŉ욢�\n\nJ�UG	�sv����kP���u�!s'\$��;�0�E�@������&Lo\$ mUM&��\"�����f����w匄\0�\"��1��M�;���Y�`W�B��\0T�f)X�tT�x�\0000�V�,��!s0��G\"eQڏT4��\$�[�E/eO����<���-��H-0,�d?R�,r�@gG��<���`��sqe��ۢ�m��H��L.�]��HB��\"��\0X��B��7b�s�\n��L�7�Z�Z�\$�����\rפ5���w�Ҟg�/]��h��;b�7���M]4	�ҫ���dFD�1�z�ca��o�Պ\0r�;��P� 8U�!��5�c��#]����R�@ƅ{�'�i@:���ʴ�ɧn�kX�©ֱ������8\n���s|�A\rQ�I�b��M'��PU���2�8�#�;�KO_}��#��wi=��#fc���������֞�ݞ��z�����/&�gw�m�X�	`�d��[�i�`m�X��b},�|�+�����ts�+�iiԇ�t�\n�>8()��6f2���#d��˴IH(\0.��#v/9j���!��2КE/:H/��A�ybj��\r��zV,p�w�E}^``��?X�-�\nz�*�UD~?���\\Hc�U�WXz\\0�!�rJ�A�o`�����Ba��!�C�!��W(�լX�P�.���È`�@ov���f� in�@U���U�<p�GN�U�𩆙c��8�7�O�-��������ABXr�vų,�H�؍58��ո?�cb�Cʸ�5q����&>!�4 �ͅ(q��	I��-Jm\0>�5I�D�m�B�mD�\0��`2��yN��D��4N�L`�����0x�_~1\07����k����h�RO�`j_�ŭ���� ���m{�p0��!9'�K-�\$�����\nj~�h���Q��N��\0��q{��x�\"��2�/q��iT�F/��*V@*�g�-��� b�c0	H�0\0]�@�H�U�:U,V�Gd�?��u�L}L�9��u�:\"\$�Tl���e��ɐ;��V�\nL�!+�ǆT�1�j,�}R\r-[�2�6U�i\0d��/Ҏ���@r�.��PF	��g���<����S��&i\r\$�R72�>fs#��3��7UNȵ\"ϱH��+�9�[8�	B� 	�A��!3�_�Z�5��3��%�r��W9y���\n3K�|��o5gh;���d��\r��	D��3R��g��L\\��v	IGB�_�8`���<�a�?�s�q��䘬�b�2�N�(��u��`L���Ӧ!U�>��\r�e�~_����!�S�t1'=\r�C���Q�r���\rC��*᠗�f�3`{� G����|U\$n�J���3H��;�R5ؖ}�Qw9�B���=k0��F��Ǻ\$1sb���-L3�C\0w!ʹ�P�&[�#0�طPS�\"����%r�{ZA���]�DE%�)��T��{@s����u�e��R��Ԉ�53����#�>��<�\"�A:�t\"�z��KH7�8}�k������3�'�N^���Vh\r�Pj;֯���u�f.����\$�yW�|U\$�:�������qĪM�SŞ8m2�İ�P��.�'��c��,��R\0K�X�Ў�����]��q|��Z�P������,�\r�\r��C�Ř�}�u̟5���?��z	��N�k͉lI�pw3���KMj9�[{È1i�s��yN�Ýz���qv�eGÖq��\"r�媩������W���\r��μN�7�C�+�@FJ.2El���A8��{�Q;n]&�H�\\�>N�d\0ctʄ�Ў�?t%%�v}@ƴ��ZL| y��X/鳍��n�ք�SR�mxW�/�Hr��l�o���ԩ����[�#�� F�k�*��~滓�t���W��;X\0�~����r�i颃\$V��7;��4;F�\$�B��`;6���\\n��Tw�j��:p����t�\$	7i��ֿ����7+Y!�5.#�ۇ�U���ۻGv�۞(��W��*_Sj�c]��`e��nyS�m�ܹ#������i�52�s~G;s��?�F�V��̈́ۋ\0N�,H�@T'L�i@�/�Y����\r\0���xUx�d>漂����@3\0yH^o\"u�ā�&͇x?Ti��\$/n�T�5�ŉ�	�ΰ<����d1ȋ����)��y�|9�2�T98a�/�S�X�)�Q�H}����.�g��K���5�Z����=��pߎ0��ô�kJ\n��L�f�����R	�EFP�d2 +ȥ�q9d �܎�yZ��!<	��j��\$I�W�\") �\n.4��N3	7|��暇td�\ne{ӡ��z��Th��a�nx�,%�/39��rw=\"�]�t��<1���|�\\n�W�~�XA�����h��d( ޚv����Loc�8�l�9��W7�}w�8Ch����w\"PZ��]��u��H Nk�,�����.�����&@��\$��w�/�<��O����n�|<��H��RKt6H��2OD��!Ds�¾�0A�4F�ӣ�u(x��]q3M;�^R����t�� ����)\r��0�9ޟ2���g3r�=�L\"�	¾��pe�0H�-=��ㄊb6��a�,�h,�[k�{[�E3�-�I��,��ҹ����ך�P	c:���u��\r�]�M��ؤD (^�eƿ��,��iG^<6��H�jBWK�<ڸ%⫎�w؂l�.��PT��FK+��f�&�v��0��]@�Qx/b�vc'\n�A9�xb����X�ԧ�]y�M�}'\\�)/Hgm	�fϣ���Uz�6]Sŗ� ߬&�<��n�zt�oN�z+��f\r���>Y�{n�~��\$Ԇ̳0y���g%)� �=&�{@t�w�irK������濺zٴ��)�y42��Y�>�V3�^m������|�I�x���T֣�z�wk�����ʉ,<k��\$+�1<�� _�����d���}g��9F]�k)�|�������e}�iΨ�g���B�������\0ڃ?�۳��)HBH��DE�e���V��mP�yP��(�(�1}����W�05;\\\$+@��<v_\"��2@bM۶:�X��V���]꾼(�g\"�s\$���B�3\\�xDp���@D�'�X�*�N�����\$2��/VeM���y�r\0�����W�VL��e�L�dӸ���~�����[K��p_�@^�c�%��)wߩ�s�Hl�\n���w��?VO�H�j�&l�_��YŮׅ���9�b'Q?2[}���{M\n����2\\xml�PѦ�3�.���fD��(+%��D\r�r)@���h^����If�Mlu�x�\0�	�ڿe>�5�5�S��-��;�_��@���X��%,ɿ�f�|���@+�O�|J4P|�	-��Ś�u�h8���`�~�5�l��Q�;�o@����G�D�A�_�\0ӄF_Z�ٱD+:� M�u}�L�\"�J���(�L��_���d�a���o����	?���|�sD\\1A^\\�\\G��a-\\nˣ)���3e�܄�'Q��zf�v}q���P�7\0'�����e\r:�Up��y��x;�_YT��Yl��@ղ+����Mz6��d�)��`5{0�W\0��B�	 ���*U��Z���@�}l՘-��8�p�XR`8����nG( ��\$�%MT����\\���ڪ�FE�dc��3��	��\n�<&-9Jow��\0)?Ƥ0x:j��|i��vAT�;I��Q��AX&C裡M@Jl��L�(LP��3�� ���0�\0��H�+\0	<�; �N��(;6H���F ��e �p��6�/�sJ`�*��ڐ	�L3�2��<�9\"	���^lF������F(����B @��P܇;���F�v5l\0�ݠ00t�k���>\0O�U�<���Xq07�BF�8���K�#4�4 �%�wPN���A�Q1�D�O`�AHBp�p�`2^��c��	P,=���b�����F�C�\r�2���`8@�Ud�1��I��A��T�3��\\\0p1)5)F�@��D\r%VAd���\r^�� Âh	�#�A�����`��\r��������A���\0>���b	��\\p�AK<�w\0��\r�B%��W�f}�mH�j�a��dt\"0P�|���?�Ԇ��6�#�?�O\n\r�R���\$o��d������}	S��䟩\n��������o��[\0	��?����d�r�\$o�+`X-Y.��V��I�G>\0V�PM\0W��G�z]�\0TV��d܀_��a@-<\r��\0Y�+�H���-����f���tu��'b�4O��P*��f���Ry*9�8�:�G�D��3 34��5.F�V/0����R��Й��HaCF`g�+־�\0�<h\0\$���#��m/���㐞x�CAS��Xҋ���p��bc24���|��g�D�7I��J8@����|�6��-p��������*B���=%��������ԯ���r�	^CJ`\0sEpi�h3���`���H��p���U`�e��&�1�%\0V���V'X(W`��\r��i�F�k�W�n�q�����DQ#t��Kt\$���Q���\n\0���B���X<�Cp�\0K�(\0��C�1�BFIq�)q���� C~�����q\r���C�\rؘK�\"���j�ZZB��v�#�< �C�\r�u3���	�+D�钲�Ԍ�;�-��");}elseif($_GET["file"]=="jush.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("v0��F����==��FS	��_6MƳ���r:�E�CI��o:�C��Xc��\r�؄J(:=�E���a28�x�?�'�i�SANN���xs�NB��Vl0���S	��Ul�(D|҄��P��>�E�㩶yHch��-3Eb�� �b��pE�p�9.����~\n�?Kb�iw|�`��d.�x8EN��!��2��3���\r���Y���y6GFmY�8o7\n\r�0�<d4�E'�\n#�\r���.�C!�^t�(��bqH��.���s���2�N�q٤�9��#{�c�����3nӸ2��r�:<�+�9�CȨ���\n<�\r`��/b�\\���!�H�2SڙF#8Ј�I�78�K��*ں�!���鎑��+��:+���&�2|�:��9���:��N���pA/#�� �0D�\\�'�1����2�a@��+J�.�c,�����1��@^.B��ь�`OK=�`B��P�6����>(�eK%! ^!Ϭ�B��HS�s8^9�3�O1��.Xj+���M	#+�F�:�7�S�\$0�V(�FQ�\r!I��*�X�/̊���67=�۪X3݆؇���^��gf#W��g��8ߋ�h�7��E�k\r�ŹG�)��t�We4�V؝����&7�\0R��N!0�1W���y�CP��!��i|�gn��.\r�0�9�Aݸ���۶�^�8v�l\"�b�|�yHY�2�9�0�߅�.��:y���6�:�ؿ�n�\0Q�7��bk�<\0��湸�-�B�{��;�����W����&�/n�w��2A׵�����A�0yu)���kLƹtk�\0�;�d�=%m.��ŏc5�f���*�@4�� ���c�Ƹ܆|�\"맳�h�\\�f�P�N��q����s�f�~P��pHp\n~���>T_��QOQ�\$�V��S�pn1�ʚ��}=���L��Jeuc�����aA|;��ȓN��-��Z�@R��ͳ� �	��.��2�����`RE���^iP1&��ވ(���\$�C�Y�5�؃��axh@��=Ʋ�+>`��ע���\r!�b���r��2p�(=����!�es�X4G�Hhc �M�S.��|YjH��zB�SV��0�j�\nf\r�����D�o��%��\\1���MI`(�:�!�-�3=0������S���gW�e5��z�(h��d�r�ӫ�Ki�@Y.�����\$@�s�ѱEI&��Df�SR}��rڽ?�x\"�@ng����PI\\U��<�5X\"E0��t8��Y�=�`=��>�Q�4B�k���+p`�(8/N�qSK�r����i�O*[J��RJY�&u���7������#�>���Xû�?AP���CD�D���\$�����Y��<���X[�d�d��:��a\$�����Π��W�/ɂ�!+eYIw=9���i�;q\r\n���1��x�0]Q�<�zI9~W��9RD�KI6��L���C�z�\"0NW�WzH4��x�g�ת�x&�F�aӃ��\\�x��=�^ԓ���KH��x��ٓ0�EÝ҂ɚ�X�k,��R���~	��̛�Ny��Sz���6\0D	���؏�hs|.��=I�x}/�uN���'�[�R��`�N��95\0��C������X�ْ�6w1P���u�L\0V��ʲO�9[��O�>��PK�tÈu\r�|�̮R��pO��U��Drf�9�L�cSvn��Qo���@o��(��ްàp��a*�^�O>Oɹ<���e�������\"�ٓ��P>��H^���	psTO\r�0d�{�Z\$	2�,7�C���!u��}B�^����?�D��ڃF�ݱ����H�Ι`���'�@J��3��|O�ܹ�B�Mb�f1�n��@�1���(ղ����!�oow��f���)I�L\\[�����8[1)��!)���u��~�c�-�6-���y*	���>\"�m�61��ӕ�.��~�*�x��諍q��ǚG |��rl��O*%����݅�A�bRAx�g��D�f�V\\��R5l��ޤ`��5`��w�|���Sg��O���B;�Ϯ^LÖ��W?�5 ��ac}��s�ݏ�I��A��r��ݺO0�;w�x���P(�b�m�L'~�wh\0c�¨pE�߲:C�{g&ܾ/Ƒ>[����ۜ)	a}�n͡��wN�˼�x�]V^ye&�@A	�P\"� �E?P>@�|�!8 �Њ�H	�\\�`��@E	�Â�4�\0D�a!�������nr쯜\\���8�o`�H�f�����&���̒<�r��(jN�eN�)�6EO��4�.��n0�������6\r�� �\$����\$�� �N�<��|αN���j�OY\0�R�n��`�o���mkH����*�-Ϙ�w	Oz�NZ*ʛn�O�\n�#�n�⏓p[P_�b�������jP��P��Г\0�}\n/��Ӑ�������П	o}��S'��`b����\nPd�p ?Po0sq\n�:b�L���Uu\r.L`��SP���1mq���~�]%&ʚ�Q��� �\r�D�pq��pV|��f�8\$�p�&��ׂ�F��&����m�O�w��G	��1/elր��D\0�`~��`K���\\�b&�Q�Q�`ʾ�A����V�E�W�n: ؓBƌ�\r�*��l\0N��D��r뭦���[&G��h�r�H4A'�bP>�VƱ��M~�R�%2��r�m��\$�\0��2�c�����Mhʇvc���}cjg�s%l�DȺ�2�D�+�A�9#\$\0�\$RH�l��@Q!��%���\$R�FV�Ny+F\n��	 �%fz���*�ֿ��Mɾ�R�%@ڝ6\"�TN� kփ~@�F@��LQBv����6OD^hhm|6�n��L7`zr֍�Z@ր@܇3h��\$��@ѫ���t7zI��� P\rkf D�\"�b`�E@�\$\0�RZ1�&�\"~0��`��\nb�G�)	c>�[>ήe\"�6��N4�@d���n��9����ɴD4&2��\"/��|�7�u:ӱ;T3 �ԓi<TO`�Z�����B�؃�9�0�S>Qh�r\0A2�8\0W!�t��twH�OA��\0e�I��F��JT�4x�sA�AG�J2�i%:�=��#�^ ��g�7cr7s���%Ms�D v�sZ5\rb��\$�@����P��\r�\$=�%4��nX\\Xd��,l��pO��x�9b�m\"�&��g4�O�\\�(ൔ�5&rs� M�8���.I�Y5U5�IP3d�b/M��\0��3�y��^u^\"UbI�gT�?U4�N�h`�5�t���\r2}5-2�����W��(�f7@��e�/�\rJ�Kd7�- Sli3qU����z�\0�)�\$�c��oF?@]LJb�Dҿ�0��s?[gʜ�%��\rj�Un���^��R5,֪�t�FE\"��xzm��\n`�-�W#S(�l	p��%CU��辚�F�&T|jb�Z����8	��/4L�*nɦyB�:(�8�^9�8U� K���{`Z���\nF�\0Cl\r�'(`m�eR�6��M���B���C���6��v�����n%#nv�D��jGo,^:`�`s�l\r�_���X5CoV-��8RZ�@y��13q GSBt�v�Ѣt���#��bB������]��#�p���fZC�Ĳ����OZ����N��]�����sl�Ԃ���EL,+Q�@Yw�~9�I\"�8!մV5�&r�\\�7��W�&�ܼ�[\r\ri\r��~L|��d���ܷ�,��|i��@,\0�\"g�\$B�~��!)5v0�V ���b|M\$������D�f\r��8;���}�f��f�����icԄV0,Fx\rR��`�a&nȧ�QB.# Y��>w�g�����E��[�Ɨ�X���~RO��Y]8�]rK}�-��?�8�v�L�@�~�A*��f���J�M��tג���-v�[#�xL'L��>�l�8�Pg\n��\r�Q���ѱ\r�M��\":xw����\$b��-������=�kRXoQ乇9;��ˈ過��sՃ�͋�)���~�geB�Bt���,����,����K���y����-,mӀ���+��07yC��˃�Iz�ƍ�Y��^GGW��u�v0#kX��RJ\$JP+�6x��1�8���Y�g����{��?�\0�X�\r�	XF��W��ה��V/��̓dIg9߆�і�y��1��-�G�X����@O��R�y����!�GuY�5�ZF\r�㕵-�\$�O�e�u-��ZF��Zd��i�9+�쵘`M�z��\r�ҫI��y��A�Vp�:��O�J��:�V:�#:��:c��{��k�l��Zs��W����P0����#�9g@Mc�zw���[9U�\\k�����6��9Ӆ� ���y�,�����f6n-Zu���f�ً�c�,����[o�[g�d� �:w#��!W\\@�n�`�߱�\r��ɡ\$۟������\$��%��ߡ۷�z#��\$�imY��c�ɂ�k�I_������y��L���Ϲ�\$�`V��[����F�2C�8�\$��������ؼ�����G�[����¼���=�U��υ[q����K����Y���݋�Q��?�8���aX���m*G����\\��?�U�\0Ϣ���KĤ��|CR�͓�-����|ɜa��e��RY�ƺ饘�ܒ������������PJE��=��u�����\$�{�8�X��{����ŏ����ٓ�ٗ��ՙ��\r�������Ͱ٬&���Y�ҹ�(ټ�M2)��V u7\0S Z_��o]\\�|٩Ec7��S��΄[���<��<����;��-��i�� �}����l���!�,�}%����-۬��=����Ӭ��=��Y�8���PV|���zE.����\r�����bLfƸ��h*;�	ַ�;�؇�Q{��9\n_b\$5��l�UzXn�z\0xb�k�M	�2�� Z\r��c�|�ג/��}%��`�N�A�\0�*=`�F���^Q3�W�X��<���tR>r�`u�ģ>i��zN���اÝi����\$\0r���s����^C���>U�5���^a�)��	��J+>�uB��@?�J�-H���OJ'�-Tʀ�T��oUh�F��{��ԏJ[��N��V�oJ&S�B\"I^5�I�2���T���龽�]\0��\rk�L%�}�t�۷~I0�H|Pk�L5�_T�<�w��=<�x\"esa�K�\"���JH��+�U�a��'Y�~���7�)W��<6�=_�N�h�?6ܘ��y�,����a���w�\rİ�#�-V@�k��?i�b*%�޺��p?����yЀΆ�p��-p��|�n���Ca�f�8A�8�+#\r�R�@n����p��m�~ۈ{`�H?�v�*%�Ǽ�v%��G�`�`�Z��.���,�6�z��U8��|�y��V�����/�p��^��פ�m��]zcӞ���\$�IB0�|����@���pR�\n�j�9 ��G�7���읤#p߭�?����'���=�6H�lψ.�Y�OY��_V�G����O]I����=��x��\$���=�|Ϫ{��\n��<;�{:f^L'S�A1%�8*�^��p75���W��\n��\0��S⟕\02\nX(�u[��rp��B�0ڭ�x���:n	�ZI3�C����{�[��&�C(@}�r���w2�闌�nt����{C�ɆY!\0�He>��P\"�9t5�o���!�\$@\\7SS\r��C� P㄄@��I���nhG����	I�S�`x�7�0b+v5�^g�r%b�p�U��%)<+�S/Z@ �4!��j��8��\0�vN-6a[>�X�,�e\ned/�PX�`�}kOR�N���+�1O\$�π�F6B-�:wڨ�N��T�D>��x�����Y)��n�1��&�7��}�&xZ�\nޖ������W��:U@��a�⺃@��.�R�hbcT\"�����x\n� E���|߈�\r�-\0��\"�QA�Ih�\0�	 F��P\0MH�F�SB؎@�\0*��9���s\0�0'�	@Et�O�����Cx@\"G�81�`ϾP(G�=1ˏ\0��\"f>Qꎸ@�`'�>;���l������82>�zI� IG�\n�R�H	��c\"�\0�;1ێ�n�)���8�B`���(�V@Q�8c\"2���E�4r\0�9��\r�ԑ��� \0'GzH��5E!#���\rA�JЉJ�(��FC��&�d� I�\"I�V솣���G�SAX��Z~`'UA���@�����+A�\n�p��i%��ѿ�G�Z`\$��������>~?�E�\0�}� �<Q����'����E�w�ئ��#\rɂ7rQ� }�'iMI�O�0dm% ��Hʰ\"-h#��XF��M��t\$�!���R���t�,(�H8�8�!J�5I�x��r\n�Thړ~Pe@&eg\"[hؖ��4����|�2�z�D��lw#9	v{lb��/~\0���&I8%�,�IKA��\0�����/GYK�*�>���O/���2�t�eھف�P93=\$�X�d��-�&��|��#154LU���G.�i�2`����M.B���\00036�ISJ�-�~�쩦�jF\\3	o4�u	(@a3�A\0�c��`�P( ��0\$���\\}/d������\0�-�3�%b0\nc�z`��))%*��6\"����ٖ��E4��F�q���J����d��(�Ӏ����1�iLm�2�A��.)&q@\$�`L���2Lrse�� �.�vss�\r����i�KQ�󤙬 �0()�|�Mb�tU�9!�ED	�(	�`8*pa<�����80��s�\r� N���8O0�Ξ���d0��OVx��@'�<�Ol��J)�	�~}���\0U=��O�'Ňd�~\0�Of��X�H�	�L��Ҡ(]'�@�EP�LW��E'=��\0�'�\n��N�\$iI��Zy�	���>i�OH6f��'�߁x�.\"}@��-�wa2vӅ��A��L>����<0/����P��B�����͢��T���\n���<sSQ~|�ӂ��P�f�i�O�φ�lq���9T\r�����ѕgÄ���Fӧ�%O�(1�h⺶n�m�v�;�|���g���SaF��R��Ȥ�Nr��9z�%&�X��\0007\"�2t�-\rh%fŦֽ���3!�\"(�7I�\$s/ �-�7*J\rΕC�Lxw���֗�铴���(Ҫ�B,+�h\n���f\r�F�7Rf���*�:�\"�Δ4t�P�i�X�����*�\0P.(#��+H�oJAG���q�.57�+N	:-m`���&��HJO�Uvi��\0�\nGN:gR�n��2i�)}#���	F駩�>d�`�q������H���ƕe�5J);HQ�����\nHϓGRW�Ԟ��/�Jj�)K*UR���i�b8za�.�����RG��!4ͣ��@9����c: E.F|��T*��s�<Z]_O�i����\r@�2��qTlVUk�CQ\rOe��\"�\n�.�T�EUZ�Ԡ@i��^�ܪ��L��aMUB��V������'�U�+Q �V���W�m�G��Ժ�u0��*�P�T+�!u�\\�kV�y@Ƥ�j+��H��䁐�\"E��P��,�`<�H��Ք�p�ğ%	l\n�K ���\0�\$T!8@�@�2����h��4L��ŝ+��&����,�|��\"�T��Q霋�b#w)umŵ[�ޒ��)E}��[���Exd�)p����	n��-AK��1}W\\IU�nF^�\n��` \$��m)�oZ��	P�D�P�V��D �r%�R)��bұ�l�^�w�)JB���-K�D.1��8����\0��;� le�,L(\"m�N\n�Z��K�����gH���e��\0��\0t7�]��Kk\$�yN����X\0�6�(Y�������f�\\\r�K1y�,�`0��qo����\0�h\$��\n�_����dR��zE���C�h�<Y���p!�\0ro;����'g'*�!��Y�Xv��%�K4R�V�\r����Z�}Z�\r�o��mpN]N��5��xUay��\r�j��W��k�b�~��+m���edyٯʰZ�ksO�4;T���a�l@4[��]�M�7n 7�>�6���ϓ��=�h�*�0HΫj\$��[`���,����y	>��7p��D\$��u9�H ;�������R��~�0[�D��H��삕6�ܐ>-Lxj�Z�k�NȢ����n���dg�;�C\\\n�Pb[�h)3M�c�D4�0uR�#bP��5�:�a��EqH: ���:�.X��?�c�9�%n�K����a�5��J�`�7X�\n�q=ȿvr�E�<�(~���CȷPQxH�bK�ܪ�-]����\"�Q��C�U�.a��Q��v&�� ��7�]Ĩ媻�>�.9\0�=K=)���T�� ���_OX��5�!�b�U��h���AP�-����\r��%zPޔ߀<�x�����c7�|��4q�����p�C<�N���Y�5ь��)�澈��}AN_�RCTx�F�*�3���g���.�`*��B��`&�T�:**�7ƷE�W�R�\\�c�W��[���Kb��\r�o�Hr�����u 2~/խ�	@����aI� ,%b �\0�¡+{��[�,`_6�7��.�@̆�)?�m�m�b�a\n�v�������]`��W�8��!���W`��:�Fpo-`7	�\re��XXzK�I:���bD�_�5�>���ŗ��f+<Y��vg��,�%�H\\  d\$@��q�\n��A \n��6�8F�'|�I��R���T�{s�m3��8b)��	@���Lc�M���F@�#Y`��N���DX��CxzYc�0y���3hDZ��6\"�t\\7�SE;���U#�R^��ީ�s\0Cfb�ܚ��rrI\"Y�	�tå�8ZB/.�`�E��K�|����b��\n|_�}��KC�.��� p�1:����#Y\nTC	%,,��\r#�@�+��dqŁ�\$���{�D	\\J\0񒫇-`m!�|�g��dz�VI��vv&��A�`���MH\\I�����|E������j�B0ۊ@ѡnU��K��ތ��>����]ݸ�h��i�X9upr����a�\$7�v��Q��CA�>1����xif�R���7*�;8%���\"��Ʉ���w�P��TB���yH��'\n攏bظ���v��T5xcH\$�\\��ۏ����X�l��K���a�`���#t�Ew�gh�1�� �z��p���4:�\n�C��2��H�K<X	(!J��;�㏨���,��u�3�y�s�M�C9p��wz\0��ՠ9���ǈ�x�ǃ��1��B�������ي��`r�)=hLƂ�`���?z9�E�?���J���1�����Q��R�<\r�L\n8(#��r���p>��L�Q������|���\"4�(��*���8�fpiWaQ\n�Q��*���\\0@H�;�V��Y�Ά�����OZx�<F��'�I�A\n<�]�dP��_N�T!�\r˧���@*~І�B��=�%�z������;��:���AB}��&�l��c��h�`T��O�))�\0�y���I��ۦ�8��Ny��ј�G�\r\0�T�\"hn�5W@}�����Ն�B�}ZkV���Ф�y=s�	z�Ӕ����;\r쌚��,�hT��i|jza&�ր\$�i�S°�Hi��>I�B{Z*U�Ә�I�n���O�}��XMs��Q��8��I��Њ�	��v&! �k�@���#��<���T�Z�.����j�Z:�	^�B�}Y�����v�O3BTC���6=��k�eS��~���?]ij�O�Ѧ����m,\0}�!���mF!�[J�.��g��Ul�ZP٦����O[;&����]��Oht	`aILA��k�bki�N�vY���m:��v�v���k�g7���)���>��b&�؞��p�\0�5�I����]dp=�+:;��)� ���Dx@^o��ѸA���L�'�����t w�&U�g��3��B`/�=����'d>�/�dbF�\0�w\0y����9���n�Z[��6Tu���b�Z���~��~��\nzd'�@�Ra\n\n@�G���0�;vS����={��~��\0@_c0�ov�1�~�x����������e�\0p�o��>�83�|�pp�<�Il�o˄��O�;� ����%8Gx.>�o��O=^uLG��\r�N7��ݶq8~&n�5��l��]ڀ�������I..��4ओ_ۼ=��x���P������I�����5�]���[\0_�\0̓��  �<:��e��o������� �B�y�/��Eq瑻���f'�J�w��#7���N�x�F��(y��D�7�\\��'��Y2�˕�?߯)9e�nGr�vQ	�.�/�.Y��ܪ�<�zkMޠ�c��M��B+�\"ہ�\r�g�l�\0^\0��B@-	T���6�1����\n�����P�@ \"\"��@���F���0��t����U�\04��!��_|��(B\0Oc<��'����t�\"m)�TW����F ��P?f9�����C��M�mk����D���ސ�|���	�&��3�`�dΞ���\0O8�y�@��\n\0I?@@�@�/��O��\n��0���<d�\r\n�\0���H��C>�k���nm_:Gb�\$�\0�ђ��|�(v�I6�0�\"KB� �J��rK�`|6����F�T�'�9Y9>r�@y��@�%�ʄ��d�7<��\$p>t�\r\0|�yr�́��k9+����6���#��\"97�� N�ڮ���ͪ��Enp{s^�_;�\"��I�\0�J <w6��e�jc%���8�5�ր�����L&F{�2/w;����&CD���+p��%�#��BYo:d4�#H�!�A�,݃\nsα�8#=g�jl:�U��B�YX\0�eտtmd�(v��@k\\9vQ2��-{&/¶A��<%N����`�EKJ��Pպ,s&���8+-�1�T@W���8�l����D��x76@�\$�v�\"���t�X���vj��@t�H��'Ey@5�ك<ɏ��{��v�OY{LW���r:�(�,̗��\n�+�:(�5䏤�����02�%�D�Q�B��{�x-�(�*�~.����C�J�\n������S���ў#K��|䆮��ɨ2C@��a�B���bCq��y�L�7�K��4���O��fQ=�'���<!ٙ�fP+�`���gND��U���ҡ��!�\$�\$��-�/��3�Az_�@d~Q3��'��>�\n�\0�11�>���J�5���T���k8;���d�Y��^��ƥ���\0�Ӈ���(���F왕���`k���Q�+�I}Z�g0>�0MW{�z_BkП;`�(��-�wJ�e&ؤ;�FA%L\r?!��̋��\"�V�_�5G3���s?-eتQ�,�Y�s?24�~l\$߱eؤ޷�G\r�rH�����A~��O�,�G@l���dϲY���l�bЂ�?���#��:�Sߒ��k�n��ü�,�3Jy�\rg�fπ������v��/�4ݒk��d��A}�OY|t�������K�A���ޗ��?|���ށ-�����&���W`������_�\0S�����������\"��os~���G��r\$�Dr��{#�'���Eͽg���/�?����<������?��:��0�'�����Zn�7���9h@�?����b@(�3�o(�.������,���o>�{���I\"���䑂\"�`9ډ^����-�F7��%��h�Ұ��*֬�@|	\0i����@�@~C��\0�X����X\r,���3��\0����ZT ���6�.<;�C;2b��\0���K=1��#�!��� 5�:T�\nꙪMtᵀ��i�l@����9���S�b�@��(��81���i�A� �@�\r�+�8���K�B�6�~�\r�8-R���L\n�*�`6��1w�B�[�Oٻ�:���t�� A�\n�@�J\"���A8k�l[�������Co��<_�#AF��Xn�l��(��W��,�ꮈZ6���ȭXn\0���J3�Pu������>>��d�!=V�{KGe�c�F龪�Ɍ����m/��0�L��XOi*��˻�\0B/�3z���(��������}�0����+I�BPp\nB����ש���Iui�,�)0���%f	S��h�����Ϝ{���:�P�#�_���'T��k2h� �Ⱦ����i¸B����\r� 0k�ΐOn#>�l�	�\n��B���\n��2����̐�������VOiа��Y��b�s�\0����d�I�ſ	�1�6B�[�,\\���+2��(&��\0���\0�\r��p��^�Z)@<AL�zɐ��U\r�\r���tdH��\rl0D�V1� ��9�d0Lt������@[�5�P	P/��+��<Bz�zn;�f� \"�\n��xg�j���`T�2�4���X� @;���7������\"��ț9h�ۮ��>c<����C������-a\nD\np��9�bZ�����k �����*2�Bʡ���\\1���XC��'��Ɂ����D��D6�; 9;�+Ȯ`���ʃ�J���C������\0002���o���PH�>�\rc�`2A����@F��`ۂ%\$�\"D8����+A�\\`ս��y�&7�4�����x��\0ºt��Ѣp�� i��ZHe�HR�����D#LZ���p)�����.�bɀ,��pB�\$�%xB�&�TɈ`�E(�R��b���\0�;F�1i��o�TⲀ��4/��k<U�*\0�K���\r�Q�Z�e���]\0��ɑLEK����:),X�c(�?N���,W���V�GBʯ�Rqhŀ�ih�<S�oŗ�Y��EM���_�Y�YE��]Q]ų�W�KŻ45qv�����zEB��^�r�4��.���9����\n�al*�+,`�S�U�b/QE���kQ5�Xc��mTP��T�{�`����%�=	P\n\0���x{Hq��B��!R�5�P`��]��	����i�>��¤���h��F�\nN��<<| ��h�Oj��ᝐtڝ��C��)�F��88(�1�8�NR�i����\0߯�����i��蓀-�@'�2!����K@��%X\0����Dk��(Z��\0���\0���룆#���ii������(/-��\$���ػ�`t\$�����[�;^�� ׃���;O/:Θӽ��]\n�Ja��L���9F��RS劣\$�T��d����Ճ~`6��2�	����j��D�2\\OG�Q8����� XE�����4�nl��CfA�\0@�bX	b�Xd��4bk#V\r�t�~�W5�ћFEN`�m���#H��F�OX���\0�8��\$%\n;���(���)���0�\n�:D����@@��)���p	�r����)�0�jM�\n\0�8�\0�(\n��#�!�`���QQ�\r(�8��J5R?��M�(��X�)(�<~Q�G졀Rѹ6�䀑� dmǴ]\"b�����\rȵ��ʁ �&>�A��\$h?��c��(\n�\0�>�	�����}R��~\rhH��{�,G�<�m�(VN��\"�\0_�h�7:،�2A��_�>R\$�1\"\\��27\"z�#�G�l~rDG��m��l��[��I-#Srr@u ;d* I/\"1�����'�]�<���\nH���w�AI �������8#��	[v\0001�^l�#27\\��}��ɒ3#���7E&|�i9����l��&�v���\r��9�'zC./�3'�@�j+�h农�*r@��hY��;'��2~��(96{�A(9��HC�T�D��[�҅�](���,0��u(���}�3Q����)<R�2(RL����\rd�'�\n��F2{J���|�u((SA��ȱ(o%�(� °\0[�.��ʐ3�򙆚��J1(T�2��\"j��ʫ*�7ү�]*���I�:0.!H\n+�C��`����(P?Ҹ���L�aF��+��2�ʀ9�� �+�σ�*A��F�L6��0�\0�+�c�\$@cP?R���# �R��Xy:6p�D�� �,����G�5(�QQԤcP\r��+į�'J�B�8�,�m�8������-��P��pM���x�̥B�V��}�|�G,�< 6\n�\r��ҲJ�S� 9�Z������Ļ2��.��E����1K��8:ՌG*A� �&5-ĸ!jK������Ae-�9�'#/�������U'�s0��'�\n����LUJN.m��Ķ�\nK�04��9Lc��p�\0�<���L0t�2��B\$�<LBL�sLJ�xhs��1l�n'�|���W�d�����Lm,�\"��w*t���Lo-Y�hߤ�\"Z�1�ȥx��焨Ĥ� /�1�U�9̤ʒ�K�2��s.��'(̂�vI���|��������̇.cS\r�\$�����a3�r3\r��J#�i�<\r�� �1�+�΀�J�4\$�N�#���-4j�jM��\n�o/��34t��HʘlȒ��8L�/��4��SN�0�Q���4�ҳRM0]����K����3>%0�')L?*T�s���|�3`̋6���|��R�ͅ3��a�J&�r�M�xs9�2<�s+̅6�(�l͑1�>�9͟5ۉ�T��6<�x\0�\\�slM���/}GJ���\0006M�7j7�;��3��gM�7C����+\"�K�7��s�#~<���ˑ8d�i\"���\$������+��,� ���0�8Y&6��7xb/}#3���\0�8����L��	2��9��Mu9K1*��-/�䲟\n54��q�K��œ��wD栏�o1She�~#��s��l�r��:��ӜN|����\"�4���L79�?O}\0[KӉ�7��eE���(\ra�N)3�ܳJ�.k�2��BF��K���L�)�I2o9�%�|2f����sI�'D̒u��'pSBy���>/|��-\0���s�ʖ�r|�O8�DH-N�<�u�Jm:������=X%)��0�Y3�2��o\nդt	���M�,l�D�ͣ=�K����=�+�ق�6���OU>���I�>\0���MR\n�г�OY'�����A�SOM=D�S�ϫ=��r�;s�sO�=��2��?����N[.D�3�ɣ?���O�=�\0\"LO[?u\0���7@T�4v+p+\$��9L�.��1,H�J̎G����P7��F��5>U���'A5�P?A\\���%?���Y@��M��C4LAh�d���<��P�'�TN�?��4%̢��\r�������oB�E����\nҁ�qA��L��L�a�PDT�	T.��B�\n��Я.��422�؈��)�\r��P�?UT1P�@D���5�4\0��Զ�L9��I�I}'�M��*3\$�`6ɫ'H�rv9��\nP�P�?l���P���<QUC��_QGB����悌P��4���J�2|����q����,}�菦>�0��\$f��`)�PY��(�+\0��0���� �ޕ��bWQ�0�p\0�\ne�\$��rP�s��\n�Q�Q�F��n0(�@#�J@�&ў3\0*��FZ9�\"�����#��>�	�(Q����n�	Fm�h�EF�\n`(�N?r;��\0��\\��R&>��`'\0�x	cꎮ(\n�@��F���&\0���n���\n�Ə��R�/���rD�#�đ(c�Q�G����\n>ďT���FRG�ќ�%	�ѥGxtjѮ�kT��JpAr�GJ�,-�Ү(ԁ#�!e+�H�H�*4�R�K04Ar��>�t�G��R�J}�'Q�G	�rQ�GE0�\0��H���\0�e�F�����6ҍJ�9���Km)�n��P�G��J8t���K�,�R� �.t�SH��T�\0�L�+�n�(�(��1Gu�|��G�\"���H5t����!@>S?M5\"4�R�N�4��H�#`��#Ԑ�I5c�#�I=%4��IIl����?6��RL%0Ԃ�IL�Q����3��S@�(\nT�ұN`0�k���M��\0�I�&�'�qI���T\rI�0N�R��52�r��E7  ��G�, �RoI���{Pe(5Ҋe5�����%�#�>�2`\"�UKe?h��eK\\���\0���	���X*7kTH(�#�ѻKM2�#��	���R\n�%*�-!T�Q�= �UT�?T���1O�\r�.T\\�% ,�UR]K!�Q%+��MQp\ni[\0�J�J�!SQT���^�}4�7���J�T�S5H���MS�O�9�KQ`\\��WS�+\0+%MPa�Q�M`����G�G���?�.���Q㨉@#p*=�'���Rt�Ӭ>���USP�PrR��\$�\0%��U�C��0?�\\�.UuL����(�u7�(�����\0�U�7d�N�If�ME\$5K�?쎃���?�0�j�J\rT@\"�H�x�5oUV�U����W)yS)M�]T���S�\$��p>�Fc������O�Z�U.?�S5mU8%<�(Q�F���uF��V\n�MT���K�_��U@=\\5q�L?\rbus��Y\r4�w�gY!1�#�eX�a@�U�>�d4�\0��\0�#��p	�>\0��=��� � h��?�	��?������L�.՜Ԩ��	@'�nX	5`\$J�4e�K@���V-n�ֱK�u�V�]Wի���D�U�Z���m�6���h�VX[��\rV����M-Dվ��Yui;�uU��)BU�[�\$�ģsTMG4kH�!]uWR}o��H�OoI\$�?Eq��H; �\nT�ԙG�:#�\0���t�TMnc�T�-D�VJ�u�ق�?����T�%vC��ʏeG2;y]hh�\$�W�:)CWs^wuu��V�`�M��^E\\��W�^�*ՙW�R�R��W�V�z�Nן_Jt�א>����׿Wg���V5w�G\0�S�}��F�ZU�V)Zuh���WK�	4��qHU��U7X�hUD��_�y6��F�\\��T�`M�V\n�`}�4�XS݃���e`H\n�G���p���GU&#�%�}r	����e��W\"?=1I�Ze�*֞饄�ܣ�T������,���Xd�t����	�����\0&��kT���bM��P��-T��N`�%�^�BU\0�!����\0�a�<�&��G��H�?�D�%�eM9�=��L��e��}Q6=֤�k@�R\ne(�AWWu�� WB]o��Y']�8��U��@є��VԢ��-L5y��b kH�Wh�\r�VO\0Vj?��UP�Oh�ӫQ�	�#��\rm�W�cb}�\$�Le?4jVk!�Q`'U%^h��R��EN\0Tn휂u\rT��_�*\0�-��\$]�76mٻY��4TmfU&8;p?5RU\"���F�*?�g-��x����4�X쏅IuSRf�i[RSb8	4�ٽg5�6���g�*���Y������b͠V��UE n���6t��}O5��l#�M+�����\"�i5+t�#yV��� �] �QԆ��QM��ZoFե�=Zl魥6'Z�i͇YZgQu����c�U��Q�/5�sZ� �T�0>�&c��U@���Q�!ZM��U��\0�.�\$Y�P8R�?}kiցNM��IT�D��K#�x�'T�RH��7��G卵�Tގ-������p\n�i��Ul�t�U�|�V��V�0�����l����\0���D�[+lݎc�[ ���π�c�M5|\0�l�:�ҤfG6�і\r1�=��m] ���\\�Tm�Qg�1��ہX���᣺>�fu���e����b���k�am �ݣkm�Q�:\0�>���##sn}�'���g�\0�ñ��Z�U���\"�X�uk��T�>�2UR�O �%�\\��b��\$\0�`%7�8[:�����mm�7�mH��\\H=��v�KL�\$�p�KFm\$�SH�Z=���W%c�0�>�c�t���o%���X�}L\0\"��S��%Z�o�7\0#H����w�\n�{�*��i�	n��h?]�����\rq�HT`�V��meU�ꀿK�i#��v�	 \"\0��Ű��#�PM�7�Ih��ԝ��\n?�g���T7PEAT�R�PrM5`S\n5x�����@69�h�E!�6��x�T�Z4����\r;Qr��(��-K�;���` �t��UK�/V���N@��S��� �PV�m@���n��v���bT����t>�E5�;jC�?#rLc�����T�[` �yT���\0�p-�W3��������8�-I��S+T���]\"����:�������:�=�N���)XOo�:�9\0��q6�ݯr��@!��� Waۑ]e#@/��?�2tT]wU�v%�mܒQ�'����o\\շ֑��H<�4�\\Yx�SaYU\$�0XqHŔ�Sb�� W)!� �>Yyb-�\0>UY�K�G\0�k�wדSEy-�n�ck-�	؟P@��\0���WY`�\rgt��UD����1=��M޳!u�<Ħ�C�ר\$t`d�9���́\0��z}�cJD�@b�;��\$.�{���i���TP#����\\ɑ���ȍxT������k��|&e�<<D,��B'|8W�B�zk�-�^�p!�P��f�%:�\r�\r.\\_1z�\r��\$�=�0��G|�B��Ţ��{z|Շ#='����ڭ�*Rź�}��.�_nF��7�C�}k�P�1��0��ZJ���/�_eJ� 7��� <�n?-!X],\n`+UQy]�6�Tr�8�UfӏNM��DR�O�0�&ӑm=��5����i6׍]�;@�=K����Tj]�5Y�����Y]�\rwh�ԑRP0����]u�2Ӏ#��_��iG�*?�	\n_�Q�n�̔}4�0�m �0�\0�t��*:� �,��7.�;��� ���UX��*\0004��9e�.���� J�	%\nM�X��>;�!�Bz@���MtHa>�1[��?\0�N\\�<,�+�ЖAv8�D	D�v\r�(���u�jƔ2(�܃n�Ij�H\$���/^�!s�@�a\nv�&d���/A��{l�N�Ơ`�'���T�n�,!<k�:݄�S@��]�c�`،hT�T`�^ T�?;{�p5x4Dx=XkA����\n�A�� M��������\$�S� �N�ìo&������� ȕ�:��k��N�[��	��n���ҙB����߮�/�H����z����:�,t0+��2;�����a)��vPL�z)	{��#�ڂ��6������3b/�}��;)��� *��Qb,�p�b&5�p��P�ΕY���1��\rX\r!%a����<�O\$h����\0006/o�i{�)����[���*��'�4G��p�a!Vh@-��b�H?� ���Jx����Jc-��>*���f��b�&���A_��\"�%��-��=�W{�J�Yb�~%��;���%X/ ���\$�Qb��G8����f,����\rx�c(\ra��:�v1`>c��&a�����a%b@�qL�HkW����t\n���	����7�ɤ�+V|���?���N��cQ`� cg�h 6����F0�86xߝ��A]�9\0�88��J����Ճc���η�1@ 0���ab��7x�\$?8�2�NS�\$�J'D�\\�5��A%�1�v3��O�3�!7N��rh�#�;7�����{��&%��Aw\$�:���;��������pK8�c��5�ܘL���n,Ȕ�Ȁ��#����	�\0��@:�R�NEB�3˯���.h�S�=�.3�\"��ELs�cR�v)��ǭ�\$�����i�O��FImљn��!���Jb�\r�T��d�|`O����n�;(h�5���w�d�;�kN�ʪ��73�T-��78�\n�UY7D���s�7@�\n�5.���	Tsf~�k�n��)	�mA7B��N��d�ͦ�>@E��&�P@� �ツb�ҝ�:��Ҝ�AE\0�<\"�Q�k�������7X����:\0��at�l��;\r�q\0���)��|\\S;(���Y��s��_^�c��&(�|Yj^��~Z�DƸ�K���+�\0܄��;�=�ї +A�(�6\\i�Bz2mXB_��}�6߉.}���_���ӛe� [�B2e�|�(��fz�Z�����c��f}�ن\0�P@2Ad��by�f��bY�Nm��A�2×��d93f\rvd����e9���dY�f�na���c��e���/��fٓf9��f�e�~4?��_{����f�-�l�~7ں�}�bY��vM���LL������v����eш\n9E����u�U�Y\\���	�#�\$��n�g�B�<� �~����w�\r�uC�����W-d|��Ǭ��y���Tz�	1�,k�9�Q�VpRO��,hCB���~�nY˸Q��p�j��Y#��NX��Wum��Z�(��g3V��L�^oy�gq�!�gz!]�p.:�q�)	��gtJa|��u�܃�a6	�/燃���4d\$�6\n����2#1.g���s�ž���\\�&u����+�,g������wy�Y�K1�� 0�9��:מۭf6�˞�xY�9��Qb�\$��~tX'���6z���.�m�`�1�9s�@4�̓hD��y2�☾vqζ�VD.�\0�6��<���\"\0�綊k���>P9�1�vzϏ�\r����N՟�FY���V}\$:���6��`��::';�O�Od\$yF~��8���\"�턚.�5y�6O�����,Q�!=�t%��e���\0�\0yf6��}���R\n�A�`�P�r,�C\0���k@��S�zB�QCX!�I\0�.v�N����\$��@�Tc�F��Hi�Z�2֑K�\n������)]��i>�77�߀MbŸ��?����ŽC;�C���ޓc��I��4������#�0�hT�M��D=zM��X����CY�i�@`�,����y�Cݑ�i��c;�zV%������,M������%~�:ENY����.��NY�N����/�N��7h�<�A j�\\\n�aW-x`ډ��d���i~KP0�M��*i��\$�Fz|�QAV�I�=�j!�,:tB0�-�z����N���V?@K��AzxDb�V��K\0��8KD�����^��;��Gg�je�Ý�F|��oC9���u��n��(��\0���*4�A1�����j�\n��B�f�=n����Q���zxb܂D47i,!v�JP�!�XΎ��xP�{�Zv��U�Ӏj�B^!dj�\r��������K:4��z��4��bp�l����C�Cܢy����Ao\$��)6�z��Q��?A\r`���\\zEיִ\r�݃s���:Eh�e�>�Ќn�f�nڥ;����B��管��j�n~����w�Tho��M�[(�KKɮ���t!���ˤTx�4���o��y�Ɲ�EKR�6:KG��#�.\$t&��7c��-���@�]�Q�Q:ʊ߾�Ҩi-�,lQné��qO�+G�H�:�f�:�ꓯ�ID��_��Bo��M��Aj9���\n�W�3���F��~�/���f9	�0>����G��d����D��\\�A��]bK�\"\r��F~���[��c�\r�˸BOs�1�d!�y/Ѕ��n���\r�0�7�\r���	�%����h\n�2�l����Jב��ց8\"� h�Bh��j�J7�-b*�K�����!�FCV4��SK�ًF-����~�2�;�F�KÛ4������n�Z��1�vR9��\"L��:.�ν�dQh����k�a�n�k#9N�9��Ʋd��U��\0N��6�O��V��5+�iǢd��]{ج�����c	��g�AM^=����U�{vl�\$�P��5��/�(�\r):`F_:Ɨ��=�	�!y�V��9�ϟE�Q��5�>���:5�<c����Ɠ���z���	�M1�[�n��dn/����F�9�F�#`��v�X�<B�Fj�dN`Q�5�󞾴�K��5o���	�h;�������#���BZ�>����o@ck*��@����֓���D\\�S��)��pۭ���sC���6��pU[��G4�����?�.�e\na	��>W@��{�.��£��훭̵�\\9ژ>���CA�����ץ�`�0���d�]�f��M�1���I7�[����\n�]��,�q�VJ���ۑ?�tz��]����um*�p�+틽���.���\0H��W���;+���Bzo���x;^nE�tK��hq�����ꟓ�E!�+n=��T��瓗��xkj�6�{������#�h��#�[�o}��q���P�DղÝ��������o�1��xc��8D�\0�񲆜�J	������v=�W�Fzz�mk���hOޓ5j\$��X��}�<A>�n�{~h]��\"�\r��GD��x�Q�)=:�5����G:�P��D8�p	�sH2pzt�������\\ڀ����k�|)�Yt	���P�E\\D�0����¾�|p�1�Ɛs=&��`�h���IO��\n�,�M틂>Ae\\}���\\>�գ�G��7�N��l\\��L4!�5c,�T������!p}Ĭ��<�Q�H艞�89����!=�F�1j��ː�A�@��o�6�ۏ�U���9�������Ĺ���q���\nM��<_�}����3q��\0���\$n��o�>\$�z/	��+��q}����1�o\0�F8�?��P�����r�������;<�NG���E�c��\$*��qU����}��s�F�����8��b�C6��\rk��G�m� 4K<~4H!��j��m8Nkr	f.U����z��h�#�S�rU(	Zs���n�z!�/%\0����/&�}����ں6rxW`5�cG���O��b�W\$�b�M]��\$�?��z���\rޭ\"q�����J��Θn�ـ�A���&}���#[%�ɸ-�'gt\$ƕ�j��L�wN�re�\0\$8Z�#��:;�s\0M��\\������s\n�D�M�eA�������f��4I�BԾ��p`��@%Z�\0004�0�}�O.�\"���L4����]\"�'��H���f�י1��n�ыRet�Fޮ�.MY6���ȏ�lc>h�5�ӂ}<�Ɍ���(��7FL�r��m2(�%����b7��C\0[͸�M�s��#V�6�Χ5M	&v�79��7�����@�!�\0�|�N6\$ݔ��v���n�!�T�Ƞ���<��WD�@M؀_�(;���'h���L�d���+��r��Q�ˤHi�ʱ3,�)t]+��p=<�tq1o3	F���e�����}�%\0001R�,��S�O�_Iͥҍ)lt�8�LI�t�:&��\0�Ҥ�!?�_�^}0d�\0i\r'��g�A��)4�?���/Lt���θI�E�|���4W�?mi7���g�	Уu��/��C1�I��yI?C��{SZM�e�m�K��P \0��~�\0��A5�#�.\$s��Y)���|�ҊM9yd]ϫA =9	�h�^���rE@SO�#>0L�HK��HE�%t��.�m��O���f�ѸR{�~��F�%�8�sK�B���Y�w�]/#�Q����cc�)HT_GX\\�p�r>�Օ���F���lX�c�V�nu�����@u�d85��lB� �-hE����TV\0�h�=`-Tuv�rTg^5��Q��=b4l��ZMU�Yx�u��'vC^M�c�ٓUES��U1#�d�&v�en@�R�n%�����?d�_vOeŗW��iT�wf[)�?a=��_/iVM�X��]��Vod���eڏf���EI'j�,���mp��Rcj͍�8�?^����V�g5�Z�c�+}��sk�\n�W��ueV�Z�۽�v�����TlU�^UU����[�S=÷kٝ\\ݛ�;W7guxҿU�8�6����v�v��(�v�U��Os��է۽ow_U�?�i�Y׳\\utyQ���u��VM�^]��ck�n���W5e��YG^�%��]P�_�[cW�s�|V�o=���X�wu��Y�\$ݕX�Yq:w��]f�����d=��CU�d=�v���=�Va�]�H����`\n]�w�?wi���QlOj����z��g���u��I����{Y�x4�ViH���FVl���+�{F�Õ���>����\\�sErVrܟ��wY�}\\u���u��Ů�y��d<�c��p��t�q]9]��!j=Uc;yb��GS�RE�הT��?s�'ׇQ̅T�wF�}=��Um����w��-6����S�C.a��g&x{����-;�߁�i^1��|\0�u	Z^(I7�������c�;V���U%h͜��Y�g\r��t\0Qh��v9�cP����H�y������?8axD��g�-�!�3Y�g�\$��Y�ݯj7��P>���ee�Xb���s��h�a���Y�D/f��n����n�=�	^μ�ﳞ:���V��[�L���N�a����x+������w�9/x�>�+���a\$��L;(���SF�t����o�;��ly��xs�\"�	E�����ߍ�-��@׿�5��>��~=�!�\0�1B�US�b���\0O�8L}��ѫ��4q�8L:��.�6��3�.�Yr�oɀ��Yz[���_+�Q�p��?���62�/x�b�2ځ����~-0+���r~�mC�X!��b���\0���A8�9��&Rh�	H?ɖ���^��W��d���E梾�bϟ���z?���\\<j.� Jc;��\$�)�;N[�����yj	_��H�I���:�B*���ļ��3�:S�������.lf�P�Qö�hF[����6Ý@p\r{����ӝ�e����;|���V�s��FN��P+��k��o�g��̝6�[���>����֘�{l�+7�{��+�f����\n���cl=y����py;��B��\n�������ìm��ǒ��y��%�h�@�L4``�{�cnF��{��k��z���^�������[��O�U|\0�����.�d��w�y(�g�nJ��d�ϼ�AOQ�F_:�b�PP�h����a����,�	1������:']P���g�}�6��6XЗ�Ř/P��/-�I���>�M��x1�b޷� �U�#`��d3����z�Ŕ?�6�C�tx���ǻ��:L���׻�#,��?0|���S�mw��T��i���6����8���/˰�%��*h���wç���,��@�`���2���M}���E����� �%�o�a)�_���Q�NM�׿�\"�Yά�)�������P�w�RMƇ�?ա.B\r�5�TbX��\$X/t���!)�	)�I7�Ľ[1}�n��`�����o��`��~�AΪbt�oʒ�wڟh���n�/{Iԟ��}<v� �b���(>8����	�\r3���\"���(\rp��\r7ޟ{l���:������o�^.}��~ݯ����/�.m�7�\0s?T~?����><�|��o�M�N�:Ơ�yJq�\0��o�\r�,<�}2	PJ�L~?;W�-�i�_ݼ\\}���:\"�PA��;5�������\r�� @���+�8�~��fDߤr\r��ٟ���,t_\"����ƿY���?����'ߣ��������}�cٯ4�\"�l]ef��Ȑy�����[�I�L��N���a2�����!f�P����S��#	4��_���J��?�߽��Ġ���[��~����EN箒4*ÂU�\0%���8ʇ�Q�`��S�����H??�h\\��@�P2 J[xL�G�?�����\0�ȁ�>ü��/�R�\"3��HB{����<�.~܄l}}�<�|����_�^��w�/_J�:�ަ�&����w����h����k�lN[�T��@(�z�~M�0�#�h+ܓ6GETh�ck�ѝ tS2�(�q�[ŠZ��_�>��Y\n�TTE\r\";(�X�s�������-��@�D k�S�J{(�p��� �a���^\0��bZf{���#di�����D�L<��2�l�Ĉ_��v��P擯�	�\0%�S���0��*D��!ֽgЅ;��v4dP'1���q�ZXb.Y�f���մ[<�c��S����['�+����Ђ|^�p����� �V�b���n�1(p��\n\0�2�*ge G}� �-/;��1^��\n��tqz��P��[� �	����p\"%�Z\0d���\"�9�+��.FO�L1�o}�jO����P�hCDE\\d_j��9L�c&��9��xV�7�5��|te�16�P5B��\0�}*�2J�n�=f���BQ�'�rR	}���RɎB�8>�K�ưMC>Qɪ`P3inկ�wP���a��	#�c�3��Y�H���E�h1��_���k0\n��pe�Gǟ�1eh�=\n29t*���\0h(���!sQV��\0�{j&���+@D��[ַ0ul�a�#��M;\r�tXǁ��j��hQε4�CM�3S�M_w6�;A0n{l֠�Xx��z	�zf�HB�rl	K!dO�# n~��ps]�.1��jh�0�!!r�0���p�p�d�9iD�%r�������f��\0�P4	3���g��7���>J�\r�L�M����2k���+�8*��Z��h����Fߌ�ґ1Z����hdFٌ.�A�й. mNY\0փ�K��X��Ax�6Q|��h8f��c�/��%�}��帠q�c�nWA`���`PB�L����惁ɂj`+����\\f����;������g�ݘ,<�C���;>g���S��:��8�\n,�۳�XA���	c}H?ò��S=*��8@���7R�(���č�^ˁ�7�gj��߀W�8�z�8�Y��|Cܰ�A��FD�}�#PxE\n#8�P��5�n�M��FX�� ���6��r�ݟ�O�z�B_`L�Ԑ���bE��NM�Zȁ�������\nP>Am���7�PG��Gx�9��1���\09B^kt��97�P<7�V�q���JN)_u-�d�a���G`�<�o�ĳ\$'�JM�����M�	�yp�܍B4��i��(��@�8Uhb~�<(�\"�Y��w4�X�7fzPA \"�ā�A�b��T�Tm�T!����9�.�PB�L��h.�U�M�_ĕ#Vp���B�(�����[e^	zG-� �9g�tE�d�?�C� 2����V�ɈSO�'<Z�u��(�ҍ{��e�=��C������\0����v�p�O&��Ki���� Cಷ4n�|�,/�'MP�U��~�lxv����(֛�(NQP۰d��\\�TsΑ�ڨȢ���ˀ@\0HN�\$x��No_�)wYx�q�<8��\\�9�sN͖���'�HC\"����b !��RIN�� \"KG8��	�\$�s��K�D�F�!�������&���i �@�b7�;h�C��{��H��Q(�=�5q�0�TO��K��4+{pO��%\n��	m>JW�l�CR��r��\$5)�V�Lp��� JE\r��ؐԤ�B�8�i\\��6���nb���&�\r�2<8�����m�ۇ%\$ࣧ�_f�!��_7�\r�+�63��������pǴ:V��#�d'��d�M�t9�j��J#CYr䔾L:�u��~�=�:t!��)A]i��f�%���Up)V�.�J9nyGn�n�{�ȇ�����W�\n�U�;�w���^���G*��\n��\$ޣ�Lr�g�i�xdt�e:��b�ݎ�>\0��K�u%�S��*�x���ݫ�7^� ^%)�V\\��Lb��r�T��6T\$��M\n��D�<�,cS죉L�A?Ka�DT2�� �@�!���.U\$�}#ۮ���UT.6v��j�巎��C��vⵍp�֕WK[	��\\������'p.ߖ�;�Zb��iR����KV�-�_��i���n���Q����#�}�nU|��Z���frG������]��v˶Հ����U[�Yoj��8��V�*�w\"��y*�E�+YH��Z��9R����e�� p#��aZ8}Ek���+�xh�Mx1��L'P	�:v��_��e��Aփ�u=Qx�@h�+�ܝ�\\���I\"�\$�n��C&\0��t��4@b p[��\"��K��D�V��MM���K����Y�^A�?d)�X�!lI�D�k~����?���K�g7�\n�F� �(��,�,��l��9���'�Q8��DoX ���j`մ����h���r���y��M�n\0�<���ǵsF�6�;Bug������s׶�\0yl|�2���\r]�s��j�2B+у��=���p �DO~���2�++���!^�H{���_���li\\ˆ��`\n�K�&�/���j 9�����ݢ�cd���D'��o@���cD�/?P�\n.Y����\r�%�\0����(�LED�G������әҹ|�x�kA�!Ic�4Aeo��q� '�9X���Xx�CsW���ґ\"{�Ӏ\rY!����u��)��\"5fFN����E���P������H���H��l	&���Ӭ\"�m�Q�tZ�ʑW�+Ų���\$ ���.Ǌ-`a	��F8�o��X�#���ឺ�&R��>��> ��}�\\���X�9v~��.�����o�/#�x����S�,����4���c>��pC4�����hg��\rE�1@O|4(e�\\���6*��	��d�!�ҋ�x�Mp`\0007�D��4)cd��P��ZV\n�ɸ)���@\0001\0n���a��\0�4\0g��a�\0����5���P@\r�F\0l\0��XƱ���#�w��xƥ���,��\0��dƱ�@FH��\0�1dd(���8��Zx����@F.:�1Xh�ш��6\0a�2�a�@\rӂ�`\0g�2\\a���c(F7�w���ep�c�5���3Lb��Q���7\0sV2\\b`1�cF8\0d\0�2<e����F\0aB4\$b`эM [\0l\0�3�f8����Z�:��hXȱ��OF���4��ɑ��F�\0ir5�e��Q�@\0001\0m�0�i��q��`�+���g���@\0005�20�k��Q��PF;\0o�4dk \0\rcbFna��3|kH�Q�ciF0�{�1�e��#(Fj��|�\"�q��Fe�pdj7�d��q��GF��7�nh�Q��9���B2\\k�1�#OF���M>3Lj����5���\0�5�g��q��=�݌T\0�2�g�1ǣ(FP�!�5Hh�ѯ#^��<\0�1\$p�@\r@�Fb�I�8�c���cF�����Hۑ��C�G���1H�Ѻ�\r��\0i.2;��Q�clƂ�I^9Td�� \r�FFe���2\$b��q��7�[��f8\\l�ߑ��qG����e��񇣧����3,exő��GA���oX� \rc�F��P�a�Ϡ#�Ƅ���5<q Q���F����6�l��ѡc�H���<,h`��ck�2�/��g������a����d�ȱ�c��;�q�3�l������F8�j44{��q�c8�O���<�c�����-Ƈ�~8�s�ь��F1��F�8lf���iǌ9��2lx�q�c��]\0g8�a����ʀ5���3�l��Q��G\$A�?m��q����L�NZz6�u���c=�܍G68�sı���G���@D~0Q�XfGs��=|g��q�\$G}�oz?d��C��F��SF6�o���c��<�9*9�hh���vGG�]�4�e���\0001G�\0c�3�Yэ�H.�!9����q�IH=�U�;�hb�Qˣ�G�W�A�q(����\\�� �B,s(���\$Ɓ����l��qҤ�Y�]�2�x��/�%��д�p���a���M��&7�m��1��G��NB�t����&�֏��4<e1�#��O���8���Q�OF��CR9�{�1�dF~��25����c��,�E�=Ll��Q���+�E\"�2�|�ȱ�#��A�G��I�a��HČ��D�dXб�c��ƍc=4���Q�cL�3�= �9Tj���#*�C��\"�F�fx�ѡ#3G#��\"?���͑��VG��#28�}X��c�B���;fy��#1GZ�e�2\$�����^��{�9����c(G���C�oH�Dc&�7�3R=b9�ң�Hy���=�x��#v�@�O R:�|�Ѳ#&�\$�\"�3܅���L#�F���#�3L��ñ��,G�/�3e�Nc=ȭ�I v4,q(�1��%HБ�*F<|��1�c�IQ���?�l��Q��.I��\$3<��\ncvGu��\"*G��Y�������<Ԍ(ױ�dG����J�(���YFS���A\$��1�d��S�5#�6ܒH���(Ix�\"Z8�q���#\$ǯ�; Z6Lt��ģ�GJ\0e\$�34n��1���I��\"�G�Hݑ�#^�q�Y�3|bY3��#nH-<�>�i��1�#��ג��F�Y\0Q��FFD��Md����c?H��LJB�bI�T�3��I�@T|(�U�5��\0bLJBs	4��>ǌ�m:�b@r ��HA�W1̇��pc��ˑu'�BTa�.��#3Gz�W�4��Ĳ��G���#>>�u��4���&�?\\����dF����K���#�c�I2�K�J}�r`��Ɉ�#�=�bi?q�#5�m��(^:k�#R6dVI���'3<yҒ_�.G4��&�:x��2G\$�G�{r:�p���Z��Hm��v?�c9Cq�c\"H���!v3�w�q�\$�H���(�KL�Y	�3#�4���?�1)\$���ǣ��'�7k�*d\nH��Wr2�X�����#�E�x�23e!�k�(b98�8���<��v44u�뒓�A���*6O����I%G���H�	<���GI���'RKl�h���c��W�)<d�	?�i�Rǌ��%�L�1)Kq��Z�b�?fGtz9R�c��Г�F=�}�RK�nI�I!F?<��Gq��j�~��%\"3Č(�;�\$Jō�>0�9*�3��I؍e\"&St�(Ų#��ܓM!6Bԡ�01УYH���VAtp�Z���]ʤ�w&\"G���2�jG��#�5�k�Nҥd�ƹ� X	,��`Rd�GC�3\"�;�z�O2�#b�\r�'�>�m����kI�_'�1<9��1xc��\\��t�\"�%j�V,�Σb�C���@')�\n�g��V���݇�\$ڻQJ�͉hk\rU�*�`M-�<�EdBc���MUU-<B��i���Y�(w���ؚ�娋Ge��o���J�ŕ����^��B���Q�KZ��\"[���b��^>(�Y`��LM?%�?% -f����T��Z<��[��p Ľ�]v�-�J��mr�ѫ�v�-an��` �,�p����qs��:��%���P���א��Wb\0���h��G�c��%�˷%|���z��0Gސ�ya�)4�p#����\n�T�O0}�2��/p?������e�;�W�&0�ĶE^�nT�3�z��c[��v��%�<���]Q4A�}��ԁ��V���T�}�R<.\$�4�쿷����Fܗ#0N�������Y�\ri��\0kGZI�k\$�k��Nm�s\n���5�!KB%�K``\0����'��\n}��D��f����\0֢<,���-�@��ǍiK�_�,�f�e�/�����Z�u�`���S��0�jX5@�W�D���Qgp��\nubZ��x=-\"a:�\0J��\$��x�1m`�� \\��@!-Z��HJ��)Ց�	4M\n�e���k��e�5zb��|@�P0�9ZF��f\0��\n��/�=˞����dR�����C�K��-at��l�J-iT\0GD��U��Ƭ�\n�]Gjŕ�\n;fGKW�!2�eX}��j�%�L��_2�\$����+c&U+�X���d\nƕ�\n�_��\$N�]\$��0��%�z��-�^2��s�\0VIK�Y\$�D?Iv��?Lt,���ε�R��U�mJ�f\\(�P#�֖L�\$c�w�j��g<~bPi>Գ\$s �<<�fg�%~�p�Z���f��@kKʁ�,%Q�0d,M���T�\0(^j�vh�ϐ*ȘVJ�WY�\"hB&�k���)�v������.�]��YC-�g��U\\�C�\$��4�]d�Yu�%�W�+w&��>��[����M7v�-sR�)��K�\$0��4��Z�ɇ˴\"��S�8�!P\n@!��\0���tD�We��#)Kv��e[��E����<�C��1�j����\n5�MW�O.�k9#�����)YR.fk4��+D�f/��3Fl��+*���lR�6%�Z�E23	��i� ��l�Їr�f��͙%�-a��y��Z��MqQ��j^���seՍ�Κ�-Ze���k���x	5��s��{�c温v`1�^�Թ�J�WL��x��2^�%�A��̳RZ��]����_UĪ�^V��MY�����_���k�Y�+�UUMj�m7)ZB��uZ�D�m�6��:��j�xf��`�7�d���`\n�M,�H��Y��9�J���[�ȯfm�ܥ��r��M}����X����F�{��W��	L�&	���f�;Η�ﰍ�q1�L���8q!T�U&O�����2Zo���d ����\\5qb�9�'�����ef���JV�N'w�a��)Ug�V��M^����r3�٭�f��y��.�?t�����Ms��Jk���k�&�-���5�\$�\0\n�f����8�m,�ɱ�&�;�~w���l��9��Q'3͞%6mO���������E:	Xz���'3�A�]:![��I�3���\$Xֲ����Ն�nW�ͻT�:A`��a���MM^V,��s<܉ԫCf�<K��2�]t�)�Ө&ꉌ���Qed�wa3��UN���:�o�	���� ��ҪRo4���s�'.;��^��s:��fӴf��m��:Rvt���s��c\0Y�.�s:�8{���PN���8.v��Y���'��V�0�u&�˯g<2�x�q�����z;Y�h6i�����Nf�NM�y1wº�b3\\��4RQ8�r4�ߪ�*KG����<�5��S�c;Y��5br\\���˖g(OU)9Nx�����À*�윳;-e�wjS��0NI��4��:���S�g9���<	T��I�K�>O)S�Bl��y��ѝ�Nx���nt3\09�\n�O<~v{6�y2����՝�M��=UT�i��<'�Y�|�Va<�Y������I=�X��b��'�Ϊ��7-e���S��\0N�\0�=�u��uT�W�����!Qt�i�ve��R��=�q,���s�g�+\"��<�o<�Y��yg�Nʚ�9nt����s��Nϖ��&t��y���%�Cʈ)=M��Wd����+;�[i��gy;����&p��M,\nC���G����D��Ӭ�U%?(�:�ũ��(\0_V��H?x�	3�'G�ќS<I���}*G��K�T³6Y���	��g�KF�J:z�C�ʤ�+O�~��O��9r�\0&�&y\r�Z��/*�f�K1<���0�+��W,˖`H�- ��Y�j_g��H�,�*��dr��-����B[�ө�M��_#p��<�Eɓ�ԥ�\nT�@�%�g*�@)�·�.]��j�hP\$\$��S����%�͟Y�8����h ��i,ʂz�%'�����I\0��(r�gF�W��]aYiE\0�)q֣�Q����wDD�|3I)�[,�ft�P�S�(7;/H��uY��ݢ��9�l��:3�ԯ�T����*��P�_�A�b�:���!O֡BQj�����Zg�Nc#�Bl��ZS�V�О�>G�ʦ��'gP��IB�qtCJS��W)ZҐq!Tղ8�Yg5�o���^�#uA*��eNk�Un����-�,Ь��C.�E04(R�=���y ��q�4����L��O�\r���m(��W�?YRB��}�8�\"�k��C*�`���hnP�]�C*lb�9kR�*�'C�b����?�Q\0X�����gt%�vLX������TDf,H�ȵ�r��*�?h_�!�1Dvl��9Ћ(��D�)C�zr�)�tI���X��>��'���.S��J6a�&k29�u�د�S��5�b&,�#YPa*�i4RrP�YE5e��KJV<-QT�EM�H��Zh�)|`\$!kH}J*�d(0�;X,���,�E�Q�����}A>�奡�ԃLCS5?��:��/.�h�,^Tn��i��Z/�y,,��1Ew���a!���Q�\0�Ef�9��I4��1]��˪S��ћ��Dq���碼:�,��\$�Vm�d�&6p��jf����[Q@iKZ�e����ͼ^BB�\n ֒���wG߼�@�Tf����<�`-E�*\\X*\0\$�Gv��* �t���]��Hp�z0�h?�{Vv�u����q-fH�N]�r��ȴL*���#\\�BJ��U&4	��O�]������@�J�0\rTu=b�ʣu�*�N����<���\"EF�V\\ϛ�\n@�E�/W�R��\rh�I\"� �qb?�T(�YZB�Ջ2Ω�N������B;�{�kL�W�Je��JFJ�Ծ)���H�JҺ�G���h��Qr%ZS/�+�1����bʛ\n64wh��ݢ\n�_�%��='��'vI�~r���S�i/.��ĩab��E��@ ��-��Y�2��?Q螰��RZ�U�J��R^:�3`�K�U����ѐT�H���jQ?��f\0���RXY�jl'Y�~�,�Y}�Z\n�(�R��8��Y�)��Td�\0�Q��s�@�H\n��\"-DT�J�J��JU4|?O�\\]IyS�����U�Ƣe;���ɩ\nh��-�[��ʖ(�!��&�/'�6JV�j��Vk4gخHv��Q�#I��(Ι�:�}�%u1Dy	��n�������ԙ�~Ҝ�7Jf�*����1>�G\\\r�!�t��R��K�Qe/�4�YXRo\0P�p(*��)�\"�#����\$S��i�����)ra�\\���/(O�\$jF3f挀��(t\0�`��d�U	>h��e�c����H�\rp�`gP��c�[=�L�f������\0002\0/\0��5\0b�!�`�&\0]*px)�g�CZu�d-�<�\$���k%A��z��d����Ҿ�Y\0֛5�k��\0006��Қ�c@�@\r��x����7Zn4�@�z��M�5�\no��i�STtF5\"�U8@Ɣ�d�]��M��]5�pg�)��b�Mڜ\\�r`����n�/M7Js��)�Sy�GN*��7�t��\$ρ\$�6ʜ�ju��i�ӍsN&�d�Zvt�#PF��vҝ�;jq���G��}N���<jxT�)�SƦ�Nޞ%<�\$�\r)߀_��M��E;\nx���S�����=�ot��S�!O�U>jx��i��G�O2��tzyt�)�Ӓ��Mf:==J~��#��ا�NR:==�xt��S��PP�@ju���F~�eP0�@�~t�i�Ff��O���Z�t��SϨM?���*S��?NB��@*~	)�Sը-O��=:����jӔ�oN\n���z}��*Gq�]N�̕J��j!�*�yMf0�Az���*\$���Q&��B������-�wPR���ډ��\$��Q��M�ImB*�ui�T�[Q��5�%��j1�j�Q�BEZ}�*�#��P���E�5*!Tt�MQJ��k�Q��A�0�\0�C�CJ���T8��Q�K�G(˵\$�=Sސ#RJ��E���*ITl� \"�5I��0j+�ޑ�Qn�D�����`�b�#��G�ƒ0j4T��[PBF\rJ�U(�8Ը��R>��kڔ�+\$���-%'~�5Gژ/*\"T��S:��J*��.�[F���&~��L:r`�%T���R���Mʕu6��Ӗ��Sr��=ꛕ-i��ܩ�\0�3�A�m�<c3��K�QR�uOJ�5=*4T���Sҥ�OJ�I��T���Sƣ�Pz��)�U��T\"�uPDő��{%��[TV�-HJ�5B���S§�M��uE�H�#�RN�5Q8��F*�U�AT���R��Hj�!�;T���0\r1�cCF�9�S�2��Z�Q�cƿ�WS�5R��ruj��sU4\rܭJ�\0�}US��UZ3}U���E�*�X�?S�<\rUh�5X�	�`�S�:UV*�5E�[�b��T2MV*��=�?UV�eUګ=Qhĵ]����	Uګ}Q8��]�����UZ:�X���=�OՈ�]S�1�X��ua���K�oV\"�-PX��U�6U��TZ2�Yʱ�=�k՜�'Vj��T��ug*����UZ0�[\n��Acհ�GTZ1%[\n��k���Q�eV­mT��UU�E�īgTN4=\\J��Ac��īwW\n��UH�q*��UL	%Et�r�*�T��R��	%\\�Œ�*��ϫ�֮�St�@I*ꁻC\rR:�R_�0�v������W��E]�����TͪW֦}_��UF�U�9W��lb��U�j��%�W��E`���J��U�'Wb6ma��Յ���D�1X&N�_��}d���a�X���^��5�����YX��Ub��Xk\n�)��X֚�]��Վ��U���X��cjõ\\kGO��Uֱ�sJ��}��GX��mbڼ_�\$�l\0F�|��Euv��B��2��k\n˕��/����%���c�u�*��8�Y��e^걵��(Vr��WZ4�]��5��5Vx�AVn��Y��5�c�V)����ZZ�5�cV�WZ�q��mkGۭ'Yޯtc��u�j��8��Zz�%4���kQ֘��Z2��i��4�*�ɟ�	&~�2c93��CQFۭ[2��]3��@�ɟ�WP.��kڡ5����Z�[W�j*���d�V���YK�k����*kV̬W�1eھ��k��LYv����˵�#.�ΌgZ�3]n�ׁ����֖T b��<�jKl>+a�+<�������]��7\0�>��<���s�+�����=LR�5S���+�]��\rH2�Ȅ���������[:�%cs��*O�v��iL<�5V@ב�w��C��2�5�S�'���v��|�i�\0����^�n{��j�f�V��J��Hd�uBs��;W��8��Y�t�'���y6x�B�Dʤ'WN��|�ً.���P-�q@	���fsr��͟��8��*����í�`1C�=o��5��Y�%\r5idE���&ѻ8�B���\$�5m������:k�+iƋI&�W\r�,Jڸ�q%<��k���\"�!�q��U�f�� ��^\n�rY�U�V^��#�6�Uz9�S�+�)��W7*eD�)�f��2v�\\�f:����)��O����n3� \n�k���\$�;�p�i��Ք��ˮ�8�+����*���\n�ث�}��9�Q��S��zh\"���Uا��B�o;r��i����pP�w�]�vj�U���k�L�ҥ�������ߧ;;�eL�pz��U�����&�]ed5��W�0���=������U�F��@}W�ә��\$;��^�uZ�:�t����j������݇���&��(��\\�?�{��\rk�NН�_p��S�UX�͝�_>�=�'�ik�P�w�;��Ey:j�a񬮉Y0A�E\n浾r�����h��5�3h�W�w�\ri:�i�+��R@�F�Vx|�W�1^Njx\\I�f��Gpa�,�T��N|z��cs0�EL�xm5*�5��ά@Dg(�����Q���������\0\"H�X�:�Ɍ����4�\"1u(.���`Ӂ屑y,0��R�`��5�A�-	�~v	�+�X�qM��s��;�[0�Bf��((&h�q�_�Fڃ�8����~6Ob��8'�	���X�dfu`��42\nؿ|.Ku�P�H3:^/�G|<�Y�(��<�\n�b�>�	�Z;'z�c�\r�3b2\r�N��L���2�xU:\r6X��-�b\0�t��T�%P������X�SX!�k���ćQ�u�a�?�v�g�.���S�S:l����d�t��H�\0=/�`_3��m�F���%�l�bуB0 ڦ�k��5�ň�(�PO?�?Ί�<��\nЋS�=5j�\n��{*\0��3��b!eT��F���3����<bʃ*�	���5F�c�	�N�	H��=�ga6�e�\r�� �6��;\0�&Ě��a��Qe�4�Ђ��h��YadL�	\n�դl�*�G_��ׅ�	y��H�1�e.X�j��tY�2Mw�4�6�J�]��MȐ�Ͻș\n,��jxF�G@��*g\0_���� �XY��	f\r�m�9y�à������߇�>��o��(jG;8\"yA�3׃f�9��	L�����mgQ�[{�ds(Y�~��~@�@:	���Y�������6Fa\$l�)Ob�=��<Vx�Yuvx����č5�Y���������Yjuh��\r�/���c^�x� \r���A,m�*��yw�\0�٫��hu��7U̫HA{���#S��{>L�h�]��Ђ�&~�f�ÞѸx��m�]�.���B���&e�m��e�lH��+6ZĿ�(�\0ǅ�ٝ,:YPZak���Q�.������~��	[��-a_�:�ɜbPcA����/\rh���e���h��'���ui�Ӭ\0�=�m�\0��i���\0JPh-6�`rfi��=���mC�R\"�'^õ�Tq�lS����U�ݐ���^��Q3��T�.A�=&gv�lM�3@�-T�+P��� ƏQA.!\0�j�D[\"�W�,Z'�QRݫ�U&v�YX�[i0\"՗{Y �l��{�\"��{P�\"a�W�Z�d�\0B�PV.��mm=0�kv\r5�5�Z���ൾh2�4����lOZܵ�Oɖ��.,���:��F�Z('��`-N��B�څ�խ6��,�§a����a�l����<6�ܽ\0000�����@�lM����4����Zc�R�Օ��aloڝ|&��G�I�b3��\n��\r0�(��5[/�fH�\rŮZ`���L�^�d\$��LΐU(5-�[;��(��8*��v̓��~|�a6����4�d�l����\n���/�L��y�*>�2���?�������d!|�'O�(k��P6!i��t�x\"��I��\0A�� ��,�����7�b��z����J2E��C�\nB5�@!��F��h���+-�:�\0NMC�s��H�ہ=nA��;s�o�*���:q��B��\0�ۨN�n��n�V܄��4}���k6��Zʗ�_�tv�����3>w�9\n��L(�Yy-B{�����G�\$6ye̋t�d]�2�");}else{header("Content-Type: image/gif");switch($_GET["file"]){case"plus.gif":echo"GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0!�����M��*)�o��) q��e���#��L�\0;";break;case"cross.gif":echo"GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0#�����#\na�Fo~y�.�_wa��1�J�G�L�6]\0\0;";break;case"up.gif":echo"GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0 �����MQN\n�}��a8�y�aŶ�\0��\0;";break;case"down.gif":echo"GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0 �����M��*)�[W�\\��L&ٜƶ�\0��\0;";break;case"arrow.gif":echo"GIF89a\0\n\0�\0\0������!�\0\0\0,\0\0\0\0\0\n\0\0�i������Ӳ޻\0\0;";break;}}exit;}if($_GET["script"]=="version"){$p=get_temp_dir()."/adminer.version";unlink($p);$r=file_open_lock($p);if($r)file_write_unlock($r,serialize(array("signature"=>$_POST["signature"],"version"=>$_POST["version"])));exit;}global$b,$f,$l,$Zb,$m,$ba,$ca,$je,$Zf,$wd,$T,$oi,$ia;if(!$_SERVER["REQUEST_URI"])$_SERVER["REQUEST_URI"]=$_SERVER["ORIG_PATH_INFO"];if(!strpos($_SERVER["REQUEST_URI"],'?')&&$_SERVER["QUERY_STRING"]!="")$_SERVER["REQUEST_URI"].="?$_SERVER[QUERY_STRING]";if($_SERVER["HTTP_X_FORWARDED_PREFIX"])$_SERVER["REQUEST_URI"]=$_SERVER["HTTP_X_FORWARDED_PREFIX"].$_SERVER["REQUEST_URI"];$ba=($_SERVER["HTTPS"]&&strcasecmp($_SERVER["HTTPS"],"off"))||ini_bool("session.cookie_secure");@ini_set("session.use_trans_sid",false);if(!defined("SID")){session_cache_limiter("");session_name("adminer_sid");session_set_cookie_params(0,preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]),"",$ba,true);session_start();}remove_slashes(array(&$_GET,&$_POST,&$_COOKIE),$Sc);if(function_exists("get_magic_quotes_runtime")&&get_magic_quotes_runtime())set_magic_quotes_runtime(false);@set_time_limit(0);@ini_set("precision",15);function
get_lang(){return'zh-tw';}function
lang($ni,$df=null){if(is_array($ni)){$cg=($df==1?0:1);$ni=$ni[$cg];}$ni=str_replace("%d","%s",$ni);$df=format_number($df);return
sprintf($ni,$df);}if(extension_loaded('pdo')){abstract
class
PdoDb{var$server_info,$affected_rows,$errno,$error;protected$pdo;private$result;function
dsn($fc,$V,$E,$vf=array()){$vf[\PDO::ATTR_ERRMODE]=\PDO::ERRMODE_SILENT;$vf[\PDO::ATTR_STATEMENT_CLASS]=array('Adminer\PdoDbStatement');try{$this->pdo=new
\PDO($fc,$V,$E,$vf);}catch(Exception$Ac){auth_error(h($Ac->getMessage()));}$this->server_info=@$this->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION);}abstract
function
select_db($Ib);function
quote($P){return$this->pdo->quote($P);}function
query($G,$yi=false){$H=$this->pdo->query($G);$this->error="";if(!$H){list(,$this->errno,$this->error)=$this->pdo->errorInfo();if(!$this->error)$this->error='未知錯誤。';return
false;}$this->store_result($H);return$H;}function
multi_query($G){return$this->result=$this->query($G);}function
store_result($H=null){if(!$H){$H=$this->result;if(!$H)return
false;}if($H->columnCount()){$H->num_rows=$H->rowCount();return$H;}$this->affected_rows=$H->rowCount();return
true;}function
next_result(){if(!$this->result)return
false;$this->result->_offset=0;return@$this->result->nextRowset();}function
result($G,$n=0){$H=$this->query($G);if(!$H)return
false;$J=$H->fetch();return$J[$n];}}class
PdoDbStatement
extends
\PDOStatement{var$_offset=0,$num_rows;function
fetch_assoc(){return$this->fetch(\PDO::FETCH_ASSOC);}function
fetch_row(){return$this->fetch(\PDO::FETCH_NUM);}function
fetch_field(){$J=(object)$this->getColumnMeta($this->_offset++);$J->orgtable=$J->table;$J->orgname=$J->name;$J->charsetnr=(in_array("blob",(array)$J->flags)?63:0);return$J;}function
seek($C){for($t=0;$t<$C;$t++)$this->fetch();}}}$Zb=array();function
add_driver($u,$B){global$Zb;$Zb[$u]=$B;}function
get_driver($u){global$Zb;return$Zb[$u];}abstract
class
SqlDriver{static$fg=array();static$be;protected$conn;protected$types=array();var$editFunctions=array();var$unsigned=array();var$operators=array();var$functions=array();var$grouping=array();var$onActions="RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";var$inout="IN|OUT|INOUT";var$enumLength="'(?:''|[^'\\\\]|\\\\.)*'";var$generated=array();function
__construct($f){$this->conn=$f;}function
types(){return
call_user_func_array('array_merge',array_values($this->types));}function
structuredTypes(){return
array_map('array_keys',$this->types);}function
enumLength($n){}function
unconvertFunction($n){}function
select($Q,$L,$Z,$nd,$xf=array(),$z=1,$D=0,$kg=false){global$b;$Wd=(count($nd)<count($L));$G=$b->selectQueryBuild($L,$Z,$nd,$xf,$z,$D);if(!$G)$G="SELECT".limit(($_GET["page"]!="last"&&$z!=""&&$nd&&$Wd&&JUSH=="sql"?"SQL_CALC_FOUND_ROWS ":"").implode(", ",$L)."\nFROM ".table($Q),($Z?"\nWHERE ".implode(" AND ",$Z):"").($nd&&$Wd?"\nGROUP BY ".implode(", ",$nd):"").($xf?"\nORDER BY ".implode(", ",$xf):""),($z!=""?+$z:null),($D?$z*$D:0),"\n");$_h=microtime(true);$I=$this->conn->query($G);if($kg)echo$b->selectQuery($G,$_h,!$I);return$I;}function
delete($Q,$tg,$z=0){$G="FROM ".table($Q);return
queries("DELETE".($z?limit1($Q,$G,$tg):" $G$tg"));}function
update($Q,$N,$tg,$z=0,$ch="\n"){$Qi=array();foreach($N
as$y=>$X)$Qi[]="$y = $X";$G=table($Q)." SET$ch".implode(",$ch",$Qi);return
queries("UPDATE".($z?limit1($Q,$G,$tg,$ch):" $G$tg"));}function
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
slowQuery($G,$bi){}function
convertSearch($v,$X,$n){return$v;}function
convertOperator($rf){return$rf;}function
value($X,$n){return(method_exists($this->conn,'value')?$this->conn->value($X,$n):(is_resource($X)?stream_get_contents($X):$X));}function
quoteBinary($Qg){return
q($Qg);}function
warnings(){return'';}function
tableHelp($B,$Zd=false){}function
hasCStyleEscapes(){return
false;}function
supportsIndex($R){return!is_view($R);}function
checkConstraints($Q){return
get_key_vals("SELECT c.CONSTRAINT_NAME, CHECK_CLAUSE
FROM INFORMATION_SCHEMA.CHECK_CONSTRAINTS c
JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS t ON c.CONSTRAINT_SCHEMA = t.CONSTRAINT_SCHEMA AND c.CONSTRAINT_NAME = t.CONSTRAINT_NAME
WHERE c.CONSTRAINT_SCHEMA = ".q($_GET["ns"]!=""?$_GET["ns"]:DB)."
AND t.TABLE_NAME = ".q($Q)."
AND CHECK_CLAUSE NOT LIKE '% IS NOT NULL'");}}$Zb["sqlite"]="SQLite";if(isset($_GET["sqlite"])){define('Adminer\DRIVER',"sqlite");if(class_exists("SQLite3")){class
SqliteDb{var$extension="SQLite3",$server_info,$affected_rows,$errno,$error;private$link;function
__construct($p){$this->link=new
\SQLite3($p);$Ti=$this->link->version();$this->server_info=$Ti["versionString"];}function
query($G){$H=@$this->link->query($G);$this->error="";if(!$H){$this->errno=$this->link->lastErrorCode();$this->error=$this->link->lastErrorMsg();return
false;}elseif($H->numColumns())return
new
Result($H);$this->affected_rows=$this->link->changes();return
true;}function
quote($P){return(is_utf8($P)?"'".$this->link->escapeString($P)."'":"x'".reset(unpack('H*',$P))."'");}function
store_result(){return$this->result;}function
result($G,$n=0){$H=$this->query($G);if(!is_object($H))return
false;$J=$H->fetch_row();return$J?$J[$n]:false;}}class
Result{var$num_rows;private$result,$offset=0;function
__construct($H){$this->result=$H;}function
fetch_assoc(){return$this->result->fetchArray(SQLITE3_ASSOC);}function
fetch_row(){return$this->result->fetchArray(SQLITE3_NUM);}function
fetch_field(){$d=$this->offset++;$U=$this->result->columnType($d);return(object)array("name"=>$this->result->columnName($d),"type"=>$U,"charsetnr"=>($U==SQLITE3_BLOB?63:0),);}function
__destruct(){return$this->result->finalize();}}}elseif(extension_loaded("pdo_sqlite")){class
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
multi_query($G){return$this->result=$this->query($G);}function
next_result(){return
false;}}}class
Driver
extends
SqlDriver{static$fg=array("SQLite3","PDO_SQLite");static$be="sqlite";protected$types=array(array("integer"=>0,"real"=>0,"numeric"=>0,"text"=>0,"blob"=>0));var$editFunctions=array(array(),array("integer|real|numeric"=>"+/-","text"=>"||",));var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL");var$functions=array("hex","length","lower","round","unixepoch","upper");var$grouping=array("avg","count","count distinct","group_concat","max","min","sum");function
__construct($f){parent::__construct($f);if(min_version(3.31,0,$f))$this->generated=array("STORED","VIRTUAL");}function
structuredTypes(){return
array_keys($this->types[0]);}function
insertUpdate($Q,$K,$F){$Qi=array();foreach($K
as$N)$Qi[]="(".implode(", ",$N).")";return
queries("REPLACE INTO ".table($Q)." (".implode(", ",array_keys(reset($K))).") VALUES\n".implode(",\n",$Qi));}function
tableHelp($B,$Zd=false){if($B=="sqlite_sequence")return"fileformat2.html#seqtab";if($B=="sqlite_master")return"fileformat2.html#$B";}function
checkConstraints($Q){preg_match_all('~ CHECK *(\( *(((?>[^()]*[^() ])|(?1))*) *\))~',$this->conn->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($Q)),$Ae);return
array_combine($Ae[2],$Ae[2]);}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect($Ab){list(,,$E)=$Ab;if($E!="")return'資料庫不支援密碼。';return
new
Db;}function
get_databases(){return
array();}function
limit($G,$Z,$z,$C=0,$ch=" "){return" $G$Z".($z!==null?$ch."LIMIT $z".($C?" OFFSET $C":""):"");}function
limit1($Q,$G,$Z,$ch="\n"){return(preg_match('~^INTO~',$G)||get_val("SELECT sqlite_compileoption_used('ENABLE_UPDATE_DELETE_LIMIT')")?limit($G,$Z,1,0,$ch):" $G WHERE rowid = (SELECT rowid FROM ".table($Q).$Z.$ch."LIMIT 1)");}function
db_collation($j,$gb){return
get_val("PRAGMA encoding");}function
engines(){return
array();}function
logged_user(){return
get_current_user();}function
tables_list(){return
get_key_vals("SELECT name, type FROM sqlite_master WHERE type IN ('table', 'view') ORDER BY (name = 'sqlite_sequence'), name");}function
count_tables($i){return
array();}function
table_status($B=""){$I=array();foreach(get_rows("SELECT name AS Name, type AS Engine, 'rowid' AS Oid, '' AS Auto_increment FROM sqlite_master WHERE type IN ('table', 'view') ".($B!=""?"AND name = ".q($B):"ORDER BY name"))as$J){$J["Rows"]=get_val("SELECT COUNT(*) FROM ".idf_escape($J["Name"]));$I[$J["Name"]]=$J;}foreach(get_rows("SELECT * FROM sqlite_sequence",null,"")as$J)$I[$J["name"]]["Auto_increment"]=$J["seq"];return($B!=""?$I[$B]:$I);}function
is_view($R){return$R["Engine"]=="view";}function
fk_support($R){return!get_val("SELECT sqlite_compileoption_used('OMIT_FOREIGN_KEY')");}function
fields($Q){$I=array();$F="";foreach(get_rows("PRAGMA table_".(min_version(3.31)?"x":"")."info(".table($Q).")")as$J){$B=$J["name"];$U=strtolower($J["type"]);$k=$J["dflt_value"];$I[$B]=array("field"=>$B,"type"=>(preg_match('~int~i',$U)?"integer":(preg_match('~char|clob|text~i',$U)?"text":(preg_match('~blob~i',$U)?"blob":(preg_match('~real|floa|doub~i',$U)?"real":"numeric")))),"full_type"=>$U,"default"=>(preg_match("~^'(.*)'$~",$k,$A)?str_replace("''","'",$A[1]):($k=="NULL"?null:$k)),"null"=>!$J["notnull"],"privileges"=>array("select"=>1,"insert"=>1,"update"=>1,"where"=>1,"order"=>1),"primary"=>$J["pk"],);if($J["pk"]){if($F!="")$I[$F]["auto_increment"]=false;elseif(preg_match('~^integer$~i',$U))$I[$B]["auto_increment"]=true;$F=$B;}}$uh=get_val("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($Q));$v='(("[^"]*+")+|[a-z0-9_]+)';preg_match_all('~'.$v.'\s+text\s+COLLATE\s+(\'[^\']+\'|\S+)~i',$uh,$Ae,PREG_SET_ORDER);foreach($Ae
as$A){$B=str_replace('""','"',preg_replace('~^"|"$~','',$A[1]));if($I[$B])$I[$B]["collation"]=trim($A[3],"'");}preg_match_all('~'.$v.'\s.*GENERATED ALWAYS AS \((.+)\) (STORED|VIRTUAL)~i',$uh,$Ae,PREG_SET_ORDER);foreach($Ae
as$A){$B=str_replace('""','"',preg_replace('~^"|"$~','',$A[1]));$I[$B]["default"]=$A[3];$I[$B]["generated"]=strtoupper($A[4]);}return$I;}function
indexes($Q,$g=null){global$f;if(!is_object($g))$g=$f;$I=array();$uh=$g->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($Q));if(preg_match('~\bPRIMARY\s+KEY\s*\((([^)"]+|"[^"]*"|`[^`]*`)++)~i',$uh,$A)){$I[""]=array("type"=>"PRIMARY","columns"=>array(),"lengths"=>array(),"descs"=>array());preg_match_all('~((("[^"]*+")+|(?:`[^`]*+`)+)|(\S+))(\s+(ASC|DESC))?(,\s*|$)~i',$A[1],$Ae,PREG_SET_ORDER);foreach($Ae
as$A){$I[""]["columns"][]=idf_unescape($A[2]).$A[4];$I[""]["descs"][]=(preg_match('~DESC~i',$A[5])?'1':null);}}if(!$I){foreach(fields($Q)as$B=>$n){if($n["primary"])$I[""]=array("type"=>"PRIMARY","columns"=>array($B),"lengths"=>array(),"descs"=>array(null));}}$yh=get_key_vals("SELECT name, sql FROM sqlite_master WHERE type = 'index' AND tbl_name = ".q($Q),$g);foreach(get_rows("PRAGMA index_list(".table($Q).")",$g)as$J){$B=$J["name"];$w=array("type"=>($J["unique"]?"UNIQUE":"INDEX"));$w["lengths"]=array();$w["descs"]=array();foreach(get_rows("PRAGMA index_info(".idf_escape($B).")",$g)as$Pg){$w["columns"][]=$Pg["name"];$w["descs"][]=null;}if(preg_match('~^CREATE( UNIQUE)? INDEX '.preg_quote(idf_escape($B).' ON '.idf_escape($Q),'~').' \((.*)\)$~i',$yh[$B],$Cg)){preg_match_all('/("[^"]*+")+( DESC)?/',$Cg[2],$Ae);foreach($Ae[2]as$y=>$X){if($X)$w["descs"][$y]='1';}}if(!$I[""]||$w["type"]!="UNIQUE"||$w["columns"]!=$I[""]["columns"]||$w["descs"]!=$I[""]["descs"]||!preg_match("~^sqlite_~",$B))$I[$B]=$w;}return$I;}function
foreign_keys($Q){$I=array();foreach(get_rows("PRAGMA foreign_key_list(".table($Q).")")as$J){$q=&$I[$J["id"]];if(!$q)$q=$J;$q["source"][]=$J["from"];$q["target"][]=$J["to"];}return$I;}function
view($B){return
array("select"=>preg_replace('~^(?:[^`"[]+|`[^`]*`|"[^"]*")* AS\s+~iU','',get_val("SELECT sql FROM sqlite_master WHERE type = 'view' AND name = ".q($B))));}function
collations(){return(isset($_GET["create"])?get_vals("PRAGMA collation_list",1):array());}function
information_schema($j){return
false;}function
error(){global$f;return
h($f->error);}function
check_sqlite_name($B){global$f;$Ic="db|sdb|sqlite";if(!preg_match("~^[^\\0]*\\.($Ic)\$~",$B)){$f->error=sprintf('請使用下列其中一個擴充模組 %s。',str_replace("|",", ",$Ic));return
false;}return
true;}function
create_database($j,$fb){global$f;if(file_exists($j)){$f->error='檔案已存在。';return
false;}if(!check_sqlite_name($j))return
false;try{$_=new
SqliteDb($j);}catch(Exception$Ac){$f->error=$Ac->getMessage();return
false;}$_->query('PRAGMA encoding = "UTF-8"');$_->query('CREATE TABLE adminer (i)');$_->query('DROP TABLE adminer');return
true;}function
drop_databases($i){global$f;$f->__construct(":memory:");foreach($i
as$j){if(!@unlink($j)){$f->error='檔案已存在。';return
false;}}return
true;}function
rename_database($B,$fb){global$f;if(!check_sqlite_name($B))return
false;$f->__construct(":memory:");$f->error='檔案已存在。';return@rename(DB,$B);}function
auto_increment(){return" PRIMARY KEY AUTOINCREMENT";}function
alter_table($Q,$B,$o,$ad,$lb,$qc,$fb,$_a,$Tf){global$f;$Ji=($Q==""||$ad);foreach($o
as$n){if($n[0]!=""||!$n[1]||$n[2]){$Ji=true;break;}}$c=array();$Hf=array();foreach($o
as$n){if($n[1]){$c[]=($Ji?$n[1]:"ADD ".implode($n[1]));if($n[0]!="")$Hf[$n[0]]=$n[1][0];}}if(!$Ji){foreach($c
as$X){if(!queries("ALTER TABLE ".table($Q)." $X"))return
false;}if($Q!=$B&&!queries("ALTER TABLE ".table($Q)." RENAME TO ".table($B)))return
false;}elseif(!recreate_table($Q,$B,$c,$Hf,$ad,$_a))return
false;if($_a){queries("BEGIN");queries("UPDATE sqlite_sequence SET seq = $_a WHERE name = ".q($B));if(!$f->affected_rows)queries("INSERT INTO sqlite_sequence (name, seq) VALUES (".q($B).", $_a)");queries("COMMIT");}return
true;}function
recreate_table($Q,$B,$o,$Hf,$ad,$_a=0,$x=array(),$bc="",$ma=""){global$l;if($Q!=""){if(!$o){foreach(fields($Q)as$y=>$n){if($x)$n["auto_increment"]=0;$o[]=process_field($n,$n);$Hf[$y]=idf_escape($y);}}$jg=false;foreach($o
as$n){if($n[6])$jg=true;}$dc=array();foreach($x
as$y=>$X){if($X[2]=="DROP"){$dc[$X[1]]=true;unset($x[$y]);}}foreach(indexes($Q)as$de=>$w){$e=array();foreach($w["columns"]as$y=>$d){if(!$Hf[$d])continue
2;$e[]=$Hf[$d].($w["descs"][$y]?" DESC":"");}if(!$dc[$de]){if($w["type"]!="PRIMARY"||!$jg)$x[]=array($w["type"],$de,$e);}}foreach($x
as$y=>$X){if($X[0]=="PRIMARY"){unset($x[$y]);$ad[]="  PRIMARY KEY (".implode(", ",$X[2]).")";}}foreach(foreign_keys($Q)as$de=>$q){foreach($q["source"]as$y=>$d){if(!$Hf[$d])continue
2;$q["source"][$y]=idf_unescape($Hf[$d]);}if(!isset($ad[" $de"]))$ad[]=" ".format_foreign_key($q);}queries("BEGIN");}foreach($o
as$y=>$n){if(preg_match('~GENERATED~',$n[3]))unset($Hf[array_search($n[0],$Hf)]);$o[$y]="  ".implode($n);}$o=array_merge($o,array_filter($ad));foreach($l->checkConstraints($Q)as$Ta){if($Ta!=$bc)$o[]="  CHECK ($Ta)";}if($ma)$o[]="  CHECK ($ma)";$Vh=($Q==$B?"adminer_$B":$B);if(!queries("CREATE TABLE ".table($Vh)." (\n".implode(",\n",$o)."\n)"))return
false;if($Q!=""){if($Hf&&!queries("INSERT INTO ".table($Vh)." (".implode(", ",$Hf).") SELECT ".implode(", ",array_map('Adminer\idf_escape',array_keys($Hf)))." FROM ".table($Q)))return
false;$ui=array();foreach(triggers($Q)as$si=>$ci){$ri=trigger($si);$ui[]="CREATE TRIGGER ".idf_escape($si)." ".implode(" ",$ci)." ON ".table($B)."\n$ri[Statement]";}$_a=$_a?0:get_val("SELECT seq FROM sqlite_sequence WHERE name = ".q($Q));if(!queries("DROP TABLE ".table($Q))||($Q==$B&&!queries("ALTER TABLE ".table($Vh)." RENAME TO ".table($B)))||!alter_indexes($B,$x))return
false;if($_a)queries("UPDATE sqlite_sequence SET seq = $_a WHERE name = ".q($B));foreach($ui
as$ri){if(!queries($ri))return
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
drop_views($Vi){return
apply_queries("DROP VIEW",$Vi);}function
drop_tables($S){return
apply_queries("DROP TABLE",$S);}function
move_tables($S,$Vi,$Th){return
false;}function
trigger($B){if($B=="")return
array("Statement"=>"BEGIN\n\t;\nEND");$v='(?:[^`"\s]+|`[^`]*`|"[^"]*")+';$ti=trigger_options();preg_match("~^CREATE\\s+TRIGGER\\s*$v\\s*(".implode("|",$ti["Timing"]).")\\s+([a-z]+)(?:\\s+OF\\s+($v))?\\s+ON\\s*$v\\s*(?:FOR\\s+EACH\\s+ROW\\s)?(.*)~is",get_val("SELECT sql FROM sqlite_master WHERE type = 'trigger' AND name = ".q($B)),$A);$ff=$A[3];return
array("Timing"=>strtoupper($A[1]),"Event"=>strtoupper($A[2]).($ff?" OF":""),"Of"=>idf_unescape($ff),"Trigger"=>$B,"Statement"=>$A[4],);}function
triggers($Q){$I=array();$ti=trigger_options();foreach(get_rows("SELECT * FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($Q))as$J){preg_match('~^CREATE\s+TRIGGER\s*(?:[^`"\s]+|`[^`]*`|"[^"]*")+\s*('.implode("|",$ti["Timing"]).')\s*(.*?)\s+ON\b~i',$J["sql"],$A);$I[$J["name"]]=array($A[1],$A[2]);}return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","UPDATE OF","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
begin(){return
queries("BEGIN");}function
last_id(){return
get_val("SELECT LAST_INSERT_ROWID()");}function
explain($f,$G){return$f->query("EXPLAIN QUERY PLAN $G");}function
found_rows($R,$Z){}function
types(){return
array();}function
create_sql($Q,$_a,$Dh){$I=get_val("SELECT sql FROM sqlite_master WHERE type IN ('table', 'view') AND name = ".q($Q));foreach(indexes($Q)as$B=>$w){if($B=='')continue;$I.=";\n\n".index_sql($Q,$w['type'],$B,"(".implode(", ",array_map('Adminer\idf_escape',$w['columns'])).")");}return$I;}function
truncate_sql($Q){return"DELETE FROM ".table($Q);}function
use_sql($Ib){}function
trigger_sql($Q){return
implode(get_vals("SELECT sql || ';;\n' FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($Q)));}function
show_variables(){$I=array();foreach(get_rows("PRAGMA pragma_list")as$J){$B=$J["name"];if($B!="pragma_list"&&$B!="compile_options"){foreach(get_rows("PRAGMA $B")as$J)$I[$B].=implode(", ",$J)."\n";}}return$I;}function
show_status(){$I=array();foreach(get_vals("PRAGMA compile_options")as$uf){list($y,$X)=explode("=",$uf,2);$I[$y]=$X;}return$I;}function
convert_field($n){}function
unconvert_field($n,$I){return$I;}function
support($Nc){return
preg_match('~^(check|columns|database|drop_col|dump|indexes|descidx|move_col|sql|status|table|trigger|variables|view|view_trigger)$~',$Nc);}}$Zb["pgsql"]="PostgreSQL";if(isset($_GET["pgsql"])){define('Adminer\DRIVER',"pgsql");if(extension_loaded("pgsql")){class
Db{var$extension="PgSQL",$server_info,$affected_rows,$error,$timeout;private$link,$result,$string,$database=true;function
_error($wc,$m){if(ini_bool("html_errors"))$m=html_entity_decode(strip_tags($m));$m=preg_replace('~^[^:]*: ~','',$m);$this->error=$m;}function
connect($M,$V,$E){global$b;$j=$b->database();set_error_handler(array($this,'_error'));$this->string="host='".str_replace(":","' port='",addcslashes($M,"'\\"))."' user='".addcslashes($V,"'\\")."' password='".addcslashes($E,"'\\")."'";$zh=$b->connectSsl();if(isset($zh["mode"]))$this->string.=" sslmode='".$zh["mode"]."'";$this->link=@pg_connect("$this->string dbname='".($j!=""?addcslashes($j,"'\\"):"postgres")."'",PGSQL_CONNECT_FORCE_NEW);if(!$this->link&&$j!=""){$this->database=false;$this->link=@pg_connect("$this->string dbname='postgres'",PGSQL_CONNECT_FORCE_NEW);}restore_error_handler();if($this->link){$Ti=pg_version($this->link);$this->server_info=$Ti["server"];pg_set_client_encoding($this->link,"UTF8");}return(bool)$this->link;}function
quote($P){return(function_exists('pg_escape_literal')?pg_escape_literal($this->link,$P):"'".pg_escape_string($this->link,$P)."'");}function
value($X,$n){return($n["type"]=="bytea"&&$X!==null?pg_unescape_bytea($X):$X);}function
select_db($Ib){global$b;if($Ib==$b->database())return$this->database;$I=@pg_connect("$this->string dbname='".addcslashes($Ib,"'\\")."'",PGSQL_CONNECT_FORCE_NEW);if($I)$this->link=$I;return$I;}function
close(){$this->link=@pg_connect("$this->string dbname='postgres'");}function
query($G,$yi=false){$H=@pg_query($this->link,$G);$this->error="";if(!$H){$this->error=pg_last_error($this->link);$I=false;}elseif(!pg_num_fields($H)){$this->affected_rows=pg_affected_rows($H);$I=true;}else$I=new
Result($H);if($this->timeout){$this->timeout=0;$this->query("RESET statement_timeout");}return$I;}function
multi_query($G){return$this->result=$this->query($G);}function
store_result(){return$this->result;}function
next_result(){return
false;}function
result($G,$n=0){$H=$this->query($G);return($H?$H->fetch_column($n):false);}function
warnings(){return
h(pg_last_notice($this->link));}}class
Result{var$num_rows;private$result,$offset=0;function
__construct($H){$this->result=$H;$this->num_rows=pg_num_rows($H);}function
fetch_assoc(){return
pg_fetch_assoc($this->result);}function
fetch_row(){return
pg_fetch_row($this->result);}function
fetch_column($n){return($this->num_rows?pg_fetch_result($this->result,0,$n):false);}function
fetch_field(){$d=$this->offset++;$I=new
\stdClass;if(function_exists('pg_field_table'))$I->orgtable=pg_field_table($this->result,$d);$I->name=pg_field_name($this->result,$d);$I->orgname=$I->name;$I->type=pg_field_type($this->result,$d);$I->charsetnr=($I->type=="bytea"?63:0);return$I;}function
__destruct(){pg_free_result($this->result);}}}elseif(extension_loaded("pdo_pgsql")){class
Db
extends
PdoDb{var$extension="PDO_PgSQL",$timeout;function
connect($M,$V,$E){global$b;$j=$b->database();$fc="pgsql:host='".str_replace(":","' port='",addcslashes($M,"'\\"))."' client_encoding=utf8 dbname='".($j!=""?addcslashes($j,"'\\"):"postgres")."'";$zh=$b->connectSsl();if(isset($zh["mode"]))$fc.=" sslmode='".$zh["mode"]."'";$this->dsn($fc,$V,$E);return
true;}function
select_db($Ib){global$b;return($b->database()==$Ib);}function
query($G,$yi=false){$I=parent::query($G,$yi);if($this->timeout){$this->timeout=0;parent::query("RESET statement_timeout");}return$I;}function
warnings(){return'';}function
close(){}}}class
Driver
extends
SqlDriver{static$fg=array("PgSQL","PDO_PgSQL");static$be="pgsql";var$operators=array("=","<",">","<=",">=","!=","~","!~","LIKE","LIKE %%","ILIKE","ILIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL");var$functions=array("char_length","lower","round","to_hex","to_timestamp","upper");var$grouping=array("avg","count","count distinct","max","min","sum");function
__construct($f){parent::__construct($f);$this->types=array('數字'=>array("smallint"=>5,"integer"=>10,"bigint"=>19,"boolean"=>1,"numeric"=>0,"real"=>7,"double precision"=>16,"money"=>20),'日期時間'=>array("date"=>13,"time"=>17,"timestamp"=>20,"timestamptz"=>21,"interval"=>0),'字串'=>array("character"=>0,"character varying"=>0,"text"=>0,"tsquery"=>0,"tsvector"=>0,"uuid"=>0,"xml"=>0),'二進位'=>array("bit"=>0,"bit varying"=>0,"bytea"=>0),'網路'=>array("cidr"=>43,"inet"=>43,"macaddr"=>17,"macaddr8"=>23,"txid_snapshot"=>0),'幾何'=>array("box"=>0,"circle"=>0,"line"=>0,"lseg"=>0,"path"=>0,"point"=>0,"polygon"=>0),);if(min_version(9.2,0,$f)){$this->types['字串']["json"]=4294967295;if(min_version(9.4,0,$f))$this->types['字串']["jsonb"]=4294967295;}$this->editFunctions=array(array("char"=>"md5","date|time"=>"now",),array(number_type()=>"+/-","date|time"=>"+ interval/- interval","char|text"=>"||",));if(min_version(12,0,$f))$this->generated=array("STORED");}function
enumLength($n){$sc=$this->types['使用者類型'][$n["type"]];return($sc?type_values($sc):"");}function
setUserTypes($xi){$this->types['使用者類型']=array_flip($xi);}function
insertUpdate($Q,$K,$F){global$f;foreach($K
as$N){$Fi=array();$Z=array();foreach($N
as$y=>$X){$Fi[]="$y = $X";if(isset($F[idf_unescape($y)]))$Z[]="$y = $X";}if(!(($Z&&queries("UPDATE ".table($Q)." SET ".implode(", ",$Fi)." WHERE ".implode(" AND ",$Z))&&$f->affected_rows)||queries("INSERT INTO ".table($Q)." (".implode(", ",array_keys($N)).") VALUES (".implode(", ",$N).")")))return
false;}return
true;}function
slowQuery($G,$bi){$this->conn->query("SET statement_timeout = ".(1000*$bi));$this->conn->timeout=1000*$bi;return$G;}function
convertSearch($v,$X,$n){$Yh="char|text";if(strpos($X["op"],"LIKE")===false)$Yh.="|date|time(stamp)?|boolean|uuid|inet|cidr|macaddr|".number_type();return(preg_match("~$Yh~",$n["type"])?$v:"CAST($v AS text)");}function
quoteBinary($Qg){return"'\\x".bin2hex($Qg)."'";}function
warnings(){return$this->conn->warnings();}function
tableHelp($B,$Zd=false){$te=array("information_schema"=>"infoschema","pg_catalog"=>($Zd?"view":"catalog"),);$_=$te[$_GET["ns"]];if($_)return"$_-".str_replace("_","-",$B).".html";}function
supportsIndex($R){return$R["Engine"]!="view";}function
hasCStyleEscapes(){static$Oa;if($Oa===null)$Oa=($this->conn->result("SHOW standard_conforming_strings")=="off");return$Oa;}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect($Ab){global$Zb;$f=new
Db;if($f->connect($Ab[0],$Ab[1],$Ab[2])){if(min_version(9,0,$f))$f->query("SET application_name = 'Adminer'");$yb=$f->result("SHOW crdb_version");$f->server_info.=($yb?"-".preg_replace('~ \(.*~','',$yb):"");$f->cockroach=preg_match('~CockroachDB~',$f->server_info);if($f->cockroach)$Zb[DRIVER]="CockroachDB";return$f;}return$f->error;}function
get_databases(){return
get_vals("SELECT datname FROM pg_database
WHERE datallowconn = TRUE AND has_database_privilege(datname, 'CONNECT')
ORDER BY datname");}function
limit($G,$Z,$z,$C=0,$ch=" "){return" $G$Z".($z!==null?$ch."LIMIT $z".($C?" OFFSET $C":""):"");}function
limit1($Q,$G,$Z,$ch="\n"){return(preg_match('~^INTO~',$G)?limit($G,$Z,1,0,$ch):" $G".(is_view(table_status1($Q))?$Z:$ch."WHERE ctid = (SELECT ctid FROM ".table($Q).$Z.$ch."LIMIT 1)"));}function
db_collation($j,$gb){return
get_val("SELECT datcollate FROM pg_database WHERE datname = ".q($j));}function
engines(){return
array();}function
logged_user(){return
get_val("SELECT user");}function
tables_list(){$G="SELECT table_name, table_type FROM information_schema.tables WHERE table_schema = current_schema()";if(support("materializedview"))$G.="
UNION ALL
SELECT matviewname, 'MATERIALIZED VIEW'
FROM pg_matviews
WHERE schemaname = current_schema()";$G.="
ORDER BY 1";return
get_key_vals($G);}function
count_tables($i){global$f;$I=array();foreach($i
as$j){if($f->select_db($j))$I[$j]=count(tables_list());}return$I;}function
table_status($B=""){static$vd;if($vd===null)$vd=get_val("SELECT 'pg_table_size'::regproc");$I=array();foreach(get_rows("SELECT
	c.relname AS \"Name\",
	CASE c.relkind WHEN 'r' THEN 'table' WHEN 'm' THEN 'materialized view' ELSE 'view' END AS \"Engine\"".($vd?",
	pg_table_size(c.oid) AS \"Data_length\",
	pg_indexes_size(c.oid) AS \"Index_length\"":"").",
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
fields($Q){$I=array();$ta=array('timestamp without time zone'=>'timestamp','timestamp with time zone'=>'timestamptz',);foreach(get_rows("SELECT
	a.attname AS field,
	format_type(a.atttypid, a.atttypmod) AS full_type,
	pg_get_expr(d.adbin, d.adrelid) AS default,
	a.attnotnull::int,
	col_description(c.oid, a.attnum) AS comment".(min_version(10)?",
	a.attidentity".(min_version(12)?",
	a.attgenerated":""):"")."
FROM pg_class c
JOIN pg_namespace n ON c.relnamespace = n.oid
JOIN pg_attribute a ON c.oid = a.attrelid
LEFT JOIN pg_attrdef d ON c.oid = d.adrelid AND a.attnum = d.adnum
WHERE c.relname = ".q($Q)."
AND n.nspname = current_schema()
AND NOT a.attisdropped
AND a.attnum > 0
ORDER BY a.attnum")as$J){preg_match('~([^([]+)(\((.*)\))?([a-z ]+)?((\[[0-9]*])*)$~',$J["full_type"],$A);list(,$U,$qe,$J["length"],$na,$va)=$A;$J["length"].=$va;$Va=$U.$na;if(isset($ta[$Va])){$J["type"]=$ta[$Va];$J["full_type"]=$J["type"].$qe.$va;}else{$J["type"]=$U;$J["full_type"]=$J["type"].$qe.$na.$va;}if(in_array($J['attidentity'],array('a','d')))$J['default']='GENERATED '.($J['attidentity']=='d'?'BY DEFAULT':'ALWAYS').' AS IDENTITY';$J["generated"]=($J["attgenerated"]=="s"?"STORED":"");$J["null"]=!$J["attnotnull"];$J["auto_increment"]=$J['attidentity']||preg_match('~^nextval\(~i',$J["default"])||preg_match('~^unique_rowid\(~',$J["default"]);$J["privileges"]=array("insert"=>1,"select"=>1,"update"=>1,"where"=>1,"order"=>1);if(preg_match('~(.+)::[^,)]+(.*)~',$J["default"],$A))$J["default"]=($A[1]=="NULL"?null:idf_unescape($A[1]).$A[2]);$I[$J["field"]]=$J;}return$I;}function
indexes($Q,$g=null){global$f;if(!is_object($g))$g=$f;$I=array();$Mh=$g->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = ".q($Q));$e=get_key_vals("SELECT attnum, attname FROM pg_attribute WHERE attrelid = $Mh AND attnum > 0",$g);foreach(get_rows("SELECT relname, indisunique::int, indisprimary::int, indkey, indoption, (indpred IS NOT NULL)::int as indispartial
FROM pg_index i, pg_class ci
WHERE i.indrelid = $Mh AND ci.oid = i.indexrelid
ORDER BY indisprimary DESC, indisunique DESC",$g)as$J){$Dg=$J["relname"];$I[$Dg]["type"]=($J["indispartial"]?"INDEX":($J["indisprimary"]?"PRIMARY":($J["indisunique"]?"UNIQUE":"INDEX")));$I[$Dg]["columns"]=array();$I[$Dg]["descs"]=array();if($J["indkey"]){foreach(explode(" ",$J["indkey"])as$Ld)$I[$Dg]["columns"][]=$e[$Ld];foreach(explode(" ",$J["indoption"])as$Md)$I[$Dg]["descs"][]=($Md&1?'1':null);}$I[$Dg]["lengths"]=array();}return$I;}function
foreign_keys($Q){global$l;$I=array();foreach(get_rows("SELECT conname, condeferrable::int AS deferrable, pg_get_constraintdef(oid) AS definition
FROM pg_constraint
WHERE conrelid = (SELECT pc.oid FROM pg_class AS pc INNER JOIN pg_namespace AS pn ON (pn.oid = pc.relnamespace) WHERE pc.relname = ".q($Q)." AND pn.nspname = current_schema())
AND contype = 'f'::char
ORDER BY conkey, conname")as$J){if(preg_match('~FOREIGN KEY\s*\((.+)\)\s*REFERENCES (.+)\((.+)\)(.*)$~iA',$J['definition'],$A)){$J['source']=array_map('Adminer\idf_unescape',array_map('trim',explode(',',$A[1])));if(preg_match('~^(("([^"]|"")+"|[^"]+)\.)?"?("([^"]|"")+"|[^"]+)$~',$A[2],$ze)){$J['ns']=idf_unescape($ze[2]);$J['table']=idf_unescape($ze[4]);}$J['target']=array_map('Adminer\idf_unescape',array_map('trim',explode(',',$A[3])));$J['on_delete']=(preg_match("~ON DELETE ($l->onActions)~",$A[4],$ze)?$ze[1]:'NO ACTION');$J['on_update']=(preg_match("~ON UPDATE ($l->onActions)~",$A[4],$ze)?$ze[1]:'NO ACTION');$I[$J['conname']]=$J;}}return$I;}function
view($B){return
array("select"=>trim(get_val("SELECT pg_get_viewdef(".get_val("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = ".q($B)).")")));}function
collations(){return
array();}function
information_schema($j){return
get_schema()=="information_schema";}function
error(){global$f;$I=h($f->error);if(preg_match('~^(.*\n)?([^\n]*)\n( *)\^(\n.*)?$~s',$I,$A))$I=$A[1].preg_replace('~((?:[^&]|&[^;]*;){'.strlen($A[3]).'})(.*)~','\1<b>\2</b>',$A[2]).$A[4];return
nl_br($I);}function
create_database($j,$fb){return
queries("CREATE DATABASE ".idf_escape($j).($fb?" ENCODING ".idf_escape($fb):""));}function
drop_databases($i){global$f;$f->close();return
apply_queries("DROP DATABASE",$i,'Adminer\idf_escape');}function
rename_database($B,$fb){global$f;$f->close();return
queries("ALTER DATABASE ".idf_escape(DB)." RENAME TO ".idf_escape($B));}function
auto_increment(){return"";}function
alter_table($Q,$B,$o,$ad,$lb,$qc,$fb,$_a,$Tf){$c=array();$sg=array();if($Q!=""&&$Q!=$B)$sg[]="ALTER TABLE ".table($Q)." RENAME TO ".table($B);$dh="";foreach($o
as$n){$d=idf_escape($n[0]);$X=$n[1];if(!$X)$c[]="DROP $d";else{$Pi=$X[5];unset($X[5]);if($n[0]==""){if(isset($X[6]))$X[1]=($X[1]==" bigint"?" big":($X[1]==" smallint"?" small":" "))."serial";$c[]=($Q!=""?"ADD ":"  ").implode($X);if(isset($X[6]))$c[]=($Q!=""?"ADD":" ")." PRIMARY KEY ($X[0])";}else{if($d!=$X[0])$sg[]="ALTER TABLE ".table($B)." RENAME $d TO $X[0]";$c[]="ALTER $d TYPE$X[1]";$eh=$Q."_".idf_unescape($X[0])."_seq";$c[]="ALTER $d ".($X[3]?"SET".preg_replace('~GENERATED ALWAYS(.*) STORED~','EXPRESSION\1',$X[3]):(isset($X[6])?"SET DEFAULT nextval(".q($eh).")":"DROP DEFAULT"));if(isset($X[6]))$dh="CREATE SEQUENCE IF NOT EXISTS ".idf_escape($eh)." OWNED BY ".idf_escape($Q).".$X[0]";$c[]="ALTER $d ".($X[2]==" NULL"?"DROP NOT":"SET").$X[2];}if($n[0]!=""||$Pi!="")$sg[]="COMMENT ON COLUMN ".table($B).".$X[0] IS ".($Pi!=""?substr($Pi,9):"''");}}$c=array_merge($c,$ad);if($Q=="")array_unshift($sg,"CREATE TABLE ".table($B)." (\n".implode(",\n",$c)."\n)");elseif($c)array_unshift($sg,"ALTER TABLE ".table($Q)."\n".implode(",\n",$c));if($dh)array_unshift($sg,$dh);if($lb!==null)$sg[]="COMMENT ON TABLE ".table($B)." IS ".q($lb);foreach($sg
as$G){if(!queries($G))return
false;}return
true;}function
alter_indexes($Q,$c){$h=array();$ac=array();$sg=array();foreach($c
as$X){if($X[0]!="INDEX")$h[]=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");elseif($X[2]=="DROP")$ac[]=idf_escape($X[1]);else$sg[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($Q."_"))." ON ".table($Q)." (".implode(", ",$X[2]).")";}if($h)array_unshift($sg,"ALTER TABLE ".table($Q).implode(",",$h));if($ac)array_unshift($sg,"DROP INDEX ".implode(", ",$ac));foreach($sg
as$G){if(!queries($G))return
false;}return
true;}function
truncate_tables($S){return
queries("TRUNCATE ".implode(", ",array_map('Adminer\table',$S)));}function
drop_views($Vi){return
drop_tables($Vi);}function
drop_tables($S){foreach($S
as$Q){$O=table_status($Q);if(!queries("DROP ".strtoupper($O["Engine"])." ".table($Q)))return
false;}return
true;}function
move_tables($S,$Vi,$Th){foreach(array_merge($S,$Vi)as$Q){$O=table_status($Q);if(!queries("ALTER ".strtoupper($O["Engine"])." ".table($Q)." SET SCHEMA ".idf_escape($Th)))return
false;}return
true;}function
trigger($B,$Q){if($B=="")return
array("Statement"=>"EXECUTE PROCEDURE ()");$e=array();$Z="WHERE trigger_schema = current_schema() AND event_object_table = ".q($Q)." AND trigger_name = ".q($B);foreach(get_rows("SELECT * FROM information_schema.triggered_update_columns $Z")as$J)$e[]=$J["event_object_column"];$I=array();foreach(get_rows('SELECT trigger_name AS "Trigger", action_timing AS "Timing", event_manipulation AS "Event", \'FOR EACH \' || action_orientation AS "Type", action_statement AS "Statement"
FROM information_schema.triggers'."
$Z
ORDER BY event_manipulation DESC")as$J){if($e&&$J["Event"]=="UPDATE")$J["Event"].=" OF";$J["Of"]=implode(", ",$e);if($I)$J["Event"].=" OR $I[Event]";$I=$J;}return$I;}function
triggers($Q){$I=array();foreach(get_rows("SELECT * FROM information_schema.triggers WHERE trigger_schema = current_schema() AND event_object_table = ".q($Q))as$J){$ri=trigger($J["trigger_name"],$Q);$I[$ri["Trigger"]]=array($ri["Timing"],$ri["Event"]);}return$I;}function
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
found_rows($R,$Z){if(preg_match("~ rows=([0-9]+)~",get_val("EXPLAIN SELECT * FROM ".idf_escape($R["Name"]).($Z?" WHERE ".implode(" AND ",$Z):"")),$Cg))return$Cg[1];return
false;}function
types(){return
get_key_vals("SELECT oid, typname
FROM pg_type
WHERE typnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema())
AND typtype IN ('b','d','e')
AND typelem = 0");}function
type_values($u){$vc=get_vals("SELECT enumlabel FROM pg_enum WHERE enumtypid = $u ORDER BY enumsortorder");return($vc?"'".implode("', '",array_map('addslashes',$vc))."'":"");}function
schemas(){return
get_vals("SELECT nspname FROM pg_namespace ORDER BY nspname");}function
get_schema(){return
get_val("SELECT current_schema()");}function
set_schema($Sg,$g=null){global$f,$l;if(!$g)$g=$f;$I=$g->query("SET search_path TO ".idf_escape($Sg));$l->setUserTypes(types());return$I;}function
foreign_keys_sql($Q){$I="";$O=table_status($Q);$Xc=foreign_keys($Q);ksort($Xc);foreach($Xc
as$Wc=>$Vc)$I.="ALTER TABLE ONLY ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." ADD CONSTRAINT ".idf_escape($Wc)." $Vc[definition] ".($Vc['deferrable']?'DEFERRABLE':'NOT DEFERRABLE').";\n";return($I?"$I\n":$I);}function
create_sql($Q,$_a,$Dh){global$l;$Ig=array();$fh=array();$O=table_status($Q);if(is_view($O)){$Ui=view($Q);return
rtrim("CREATE VIEW ".idf_escape($Q)." AS $Ui[select]",";");}$o=fields($Q);if(!$O||empty($o))return
false;$I="CREATE TABLE ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." (\n    ";foreach($o
as$n){$Qf=idf_escape($n['field']).' '.$n['full_type'].default_value($n).($n['attnotnull']?" NOT NULL":"");$Ig[]=$Qf;if(preg_match('~nextval\(\'([^\']+)\'\)~',$n['default'],$Ae)){$eh=$Ae[1];$th=reset(get_rows((min_version(10)?"SELECT *, cache_size AS cache_value FROM pg_sequences WHERE schemaname = current_schema() AND sequencename = ".q(idf_unescape($eh)):"SELECT * FROM $eh"),null,"-- "));$fh[]=($Dh=="DROP+CREATE"?"DROP SEQUENCE IF EXISTS $eh;\n":"")."CREATE SEQUENCE $eh INCREMENT $th[increment_by] MINVALUE $th[min_value] MAXVALUE $th[max_value]".($_a&&$th['last_value']?" START ".($th["last_value"]+1):"")." CACHE $th[cache_value];";}}if(!empty($fh))$I=implode("\n\n",$fh)."\n\n$I";$F="";foreach(indexes($Q)as$Jd=>$w){if($w['type']=='PRIMARY'){$F=$Jd;$Ig[]="CONSTRAINT ".idf_escape($Jd)." PRIMARY KEY (".implode(', ',array_map('Adminer\idf_escape',$w['columns'])).")";}}foreach($l->checkConstraints($Q)as$qb=>$sb)$Ig[]="CONSTRAINT ".idf_escape($qb)." CHECK $sb";$I.=implode(",\n    ",$Ig)."\n) WITH (oids = ".($O['Oid']?'true':'false').");";if($O['Comment'])$I.="\n\nCOMMENT ON TABLE ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." IS ".q($O['Comment']).";";foreach($o
as$Pc=>$n){if($n['comment'])$I.="\n\nCOMMENT ON COLUMN ".idf_escape($O['nspname']).".".idf_escape($O['Name']).".".idf_escape($Pc)." IS ".q($n['comment']).";";}foreach(get_rows("SELECT indexdef FROM pg_catalog.pg_indexes WHERE schemaname = current_schema() AND tablename = ".q($Q).($F?" AND indexname != ".q($F):""),null,"-- ")as$J)$I.="\n\n$J[indexdef];";return
rtrim($I,';');}function
truncate_sql($Q){return"TRUNCATE ".table($Q);}function
trigger_sql($Q){$O=table_status($Q);$I="";foreach(triggers($Q)as$qi=>$pi){$ri=trigger($qi,$O['Name']);$I.="\nCREATE TRIGGER ".idf_escape($ri['Trigger'])." $ri[Timing] $ri[Event] ON ".idf_escape($O["nspname"]).".".idf_escape($O['Name'])." $ri[Type] $ri[Statement];;\n";}return$I;}function
use_sql($Ib){return"\connect ".idf_escape($Ib);}function
show_variables(){return
get_key_vals("SHOW ALL");}function
process_list(){return
get_rows("SELECT * FROM pg_stat_activity ORDER BY ".(min_version(9.2)?"pid":"procpid"));}function
convert_field($n){}function
unconvert_field($n,$I){return$I;}function
support($Nc){global$f;return
preg_match('~^(check|database|table|columns|sql|indexes|descidx|comment|view|'.(min_version(9.3)?'materializedview|':'').'scheme|routine|sequence|trigger|type|variables|drop_col'.($f->cockroach?'':'|processlist').'|kill|dump)$~',$Nc);}function
kill_process($X){return
queries("SELECT pg_terminate_backend(".number($X).")");}function
connection_id(){return"SELECT pg_backend_pid()";}function
max_connections(){return
get_val("SHOW max_connections");}}$Zb["oracle"]="Oracle (beta)";if(isset($_GET["oracle"])){define('Adminer\DRIVER',"oracle");if(extension_loaded("oci8")){class
Db{var$extension="oci8",$server_info,$affected_rows,$errno,$error;var$_current_db;private$link,$result;function
_error($wc,$m){if(ini_bool("html_errors"))$m=html_entity_decode(strip_tags($m));$m=preg_replace('~^[^:]*: ~','',$m);$this->error=$m;}function
connect($M,$V,$E){$this->link=@oci_new_connect($V,$E,$M,"AL32UTF8");if($this->link){$this->server_info=oci_server_version($this->link);return
true;}$m=oci_error();$this->error=$m["message"];return
false;}function
quote($P){return"'".str_replace("'","''",$P)."'";}function
select_db($Ib){$this->_current_db=$Ib;return
true;}function
query($G,$yi=false){$H=oci_parse($this->link,$G);$this->error="";if(!$H){$m=oci_error($this->link);$this->errno=$m["code"];$this->error=$m["message"];return
false;}set_error_handler(array($this,'_error'));$I=@oci_execute($H);restore_error_handler();if($I){if(oci_num_fields($H))return
new
Result($H);$this->affected_rows=oci_num_rows($H);oci_free_statement($H);}return$I;}function
multi_query($G){return$this->result=$this->query($G);}function
store_result(){return$this->result;}function
next_result(){return
false;}function
result($G,$n=0){$H=$this->query($G);return(is_object($H)?$H->fetch_column($n):false);}}class
Result{var$num_rows;private$result,$offset=1;function
__construct($H){$this->result=$H;}private
function
convert($J){foreach((array)$J
as$y=>$X){if(is_a($X,'OCI-Lob'))$J[$y]=$X->load();}return$J;}function
fetch_assoc(){return$this->convert(oci_fetch_assoc($this->result));}function
fetch_row(){return$this->convert(oci_fetch_row($this->result));}function
fetch_column($n){return(oci_fetch($this->result)?oci_result($this->result,$n+1):false);}function
fetch_field(){$d=$this->offset++;$I=new
\stdClass;$I->name=oci_field_name($this->result,$d);$I->orgname=$I->name;$I->type=oci_field_type($this->result,$d);$I->charsetnr=(preg_match("~raw|blob|bfile~",$I->type)?63:0);return$I;}function
__destruct(){oci_free_statement($this->result);}}}elseif(extension_loaded("pdo_oci")){class
Db
extends
PdoDb{var$extension="PDO_OCI";var$_current_db;function
connect($M,$V,$E){$this->dsn("oci:dbname=//$M;charset=AL32UTF8",$V,$E);return
true;}function
select_db($Ib){$this->_current_db=$Ib;return
true;}}}class
Driver
extends
SqlDriver{static$fg=array("OCI8","PDO_OCI");static$be="oracle";var$editFunctions=array(array("date"=>"current_date","timestamp"=>"current_timestamp",),array("number|float|double"=>"+/-","date|timestamp"=>"+ interval/- interval","char|clob"=>"||",));var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL");var$functions=array("length","lower","round","upper");var$grouping=array("avg","count","count distinct","max","min","sum");function
__construct($f){parent::__construct($f);$this->types=array('數字'=>array("number"=>38,"binary_float"=>12,"binary_double"=>21),'日期時間'=>array("date"=>10,"timestamp"=>29,"interval year"=>12,"interval day"=>28),'字串'=>array("char"=>2000,"varchar2"=>4000,"nchar"=>2000,"nvarchar2"=>4000,"clob"=>4294967295,"nclob"=>4294967295),'二進位'=>array("raw"=>2000,"long raw"=>2147483648,"blob"=>4294967295,"bfile"=>4294967296),);}function
begin(){return
true;}function
insertUpdate($Q,$K,$F){global$f;foreach($K
as$N){$Fi=array();$Z=array();foreach($N
as$y=>$X){$Fi[]="$y = $X";if(isset($F[idf_unescape($y)]))$Z[]="$y = $X";}if(!(($Z&&queries("UPDATE ".table($Q)." SET ".implode(", ",$Fi)." WHERE ".implode(" AND ",$Z))&&$f->affected_rows)||queries("INSERT INTO ".table($Q)." (".implode(", ",array_keys($N)).") VALUES (".implode(", ",$N).")")))return
false;}return
true;}function
hasCStyleEscapes(){return
true;}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect($Ab){$f=new
Db;if($f->connect($Ab[0],$Ab[1],$Ab[2]))return$f;return$f->error;}function
get_databases(){return
get_vals("SELECT DISTINCT tablespace_name FROM (
SELECT tablespace_name FROM user_tablespaces
UNION SELECT tablespace_name FROM all_tables WHERE tablespace_name IS NOT NULL
)
ORDER BY 1");}function
limit($G,$Z,$z,$C=0,$ch=" "){return($C?" * FROM (SELECT t.*, rownum AS rnum FROM (SELECT $G$Z) t WHERE rownum <= ".($z+$C).") WHERE rnum > $C":($z!==null?" * FROM (SELECT $G$Z) WHERE rownum <= ".($z+$C):" $G$Z"));}function
limit1($Q,$G,$Z,$ch="\n"){return" $G$Z";}function
db_collation($j,$gb){return
get_val("SELECT value FROM nls_database_parameters WHERE parameter = 'NLS_CHARACTERSET'");}function
engines(){return
array();}function
logged_user(){return
get_val("SELECT USER FROM DUAL");}function
get_current_db(){global$f;$j=$f->_current_db?:DB;unset($f->_current_db);return$j;}function
where_owner($hg,$Kf="owner"){if(!$_GET["ns"])return'';return"$hg$Kf = sys_context('USERENV', 'CURRENT_SCHEMA')";}function
views_table($e){$Kf=where_owner('');return"(SELECT $e FROM all_views WHERE ".($Kf?:"rownum < 0").")";}function
tables_list(){$Ui=views_table("view_name");$Kf=where_owner(" AND ");return
get_key_vals("SELECT table_name, 'table' FROM all_tables WHERE tablespace_name = ".q(DB)."$Kf
UNION SELECT view_name, 'view' FROM $Ui
ORDER BY 1");}function
count_tables($i){$I=array();foreach($i
as$j)$I[$j]=get_val("SELECT COUNT(*) FROM all_tables WHERE tablespace_name = ".q($j));return$I;}function
table_status($B=""){$I=array();$Vg=q($B);$j=get_current_db();$Ui=views_table("view_name");$Kf=where_owner(" AND ");foreach(get_rows('SELECT table_name "Name", \'table\' "Engine", avg_row_len * num_rows "Data_length", num_rows "Rows" FROM all_tables WHERE tablespace_name = '.q($j).$Kf.($B!=""?" AND table_name = $Vg":"")."
UNION SELECT view_name, 'view', 0, 0 FROM $Ui".($B!=""?" WHERE view_name = $Vg":"")."
ORDER BY 1")as$J){if($B!="")return$J;$I[$J["Name"]]=$J;}return$I;}function
is_view($R){return$R["Engine"]=="view";}function
fk_support($R){return
true;}function
fields($Q){$I=array();$Kf=where_owner(" AND ");foreach(get_rows("SELECT * FROM all_tab_columns WHERE table_name = ".q($Q)."$Kf ORDER BY column_id")as$J){$U=$J["DATA_TYPE"];$qe="$J[DATA_PRECISION],$J[DATA_SCALE]";if($qe==",")$qe=$J["CHAR_COL_DECL_LENGTH"];$I[$J["COLUMN_NAME"]]=array("field"=>$J["COLUMN_NAME"],"full_type"=>$U.($qe?"($qe)":""),"type"=>strtolower($U),"length"=>$qe,"default"=>$J["DATA_DEFAULT"],"null"=>($J["NULLABLE"]=="Y"),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1,"where"=>1,"order"=>1),);}return$I;}function
indexes($Q,$g=null){$I=array();$Kf=where_owner(" AND ","aic.table_owner");foreach(get_rows("SELECT aic.*, ac.constraint_type, atc.data_default
FROM all_ind_columns aic
LEFT JOIN all_constraints ac ON aic.index_name = ac.constraint_name AND aic.table_name = ac.table_name AND aic.index_owner = ac.owner
LEFT JOIN all_tab_cols atc ON aic.column_name = atc.column_name AND aic.table_name = atc.table_name AND aic.index_owner = atc.owner
WHERE aic.table_name = ".q($Q)."$Kf
ORDER BY ac.constraint_type, aic.column_position",$g)as$J){$Jd=$J["INDEX_NAME"];$ib=$J["DATA_DEFAULT"];$ib=($ib?trim($ib,'"'):$J["COLUMN_NAME"]);$I[$Jd]["type"]=($J["CONSTRAINT_TYPE"]=="P"?"PRIMARY":($J["CONSTRAINT_TYPE"]=="U"?"UNIQUE":"INDEX"));$I[$Jd]["columns"][]=$ib;$I[$Jd]["lengths"][]=($J["CHAR_LENGTH"]&&$J["CHAR_LENGTH"]!=$J["COLUMN_LENGTH"]?$J["CHAR_LENGTH"]:null);$I[$Jd]["descs"][]=($J["DESCEND"]&&$J["DESCEND"]=="DESC"?'1':null);}return$I;}function
view($B){$Ui=views_table("view_name, text");$K=get_rows('SELECT text "select" FROM '.$Ui.' WHERE view_name = '.q($B));return
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
alter_table($Q,$B,$o,$ad,$lb,$qc,$fb,$_a,$Tf){$c=$ac=array();$Df=($Q?fields($Q):array());foreach($o
as$n){$X=$n[1];if($X&&$n[0]!=""&&idf_escape($n[0])!=$X[0])queries("ALTER TABLE ".table($Q)." RENAME COLUMN ".idf_escape($n[0])." TO $X[0]");$Cf=$Df[$n[0]];if($X&&$Cf){$hf=process_field($Cf,$Cf);if($X[2]==$hf[2])$X[2]="";}if($X)$c[]=($Q!=""?($n[0]!=""?"MODIFY (":"ADD ("):"  ").implode($X).($Q!=""?")":"");else$ac[]=idf_escape($n[0]);}if($Q=="")return
queries("CREATE TABLE ".table($B)." (\n".implode(",\n",$c)."\n)");return(!$c||queries("ALTER TABLE ".table($Q)."\n".implode("\n",$c)))&&(!$ac||queries("ALTER TABLE ".table($Q)." DROP (".implode(", ",$ac).")"))&&($Q==$B||queries("ALTER TABLE ".table($Q)." RENAME TO ".table($B)));}function
alter_indexes($Q,$c){$ac=array();$sg=array();foreach($c
as$X){if($X[0]!="INDEX"){$X[2]=preg_replace('~ DESC$~','',$X[2]);$h=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");array_unshift($sg,"ALTER TABLE ".table($Q).$h);}elseif($X[2]=="DROP")$ac[]=idf_escape($X[1]);else$sg[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($Q."_"))." ON ".table($Q)." (".implode(", ",$X[2]).")";}if($ac)array_unshift($sg,"DROP INDEX ".implode(", ",$ac));foreach($sg
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
drop_views($Vi){return
apply_queries("DROP VIEW",$Vi);}function
drop_tables($S){return
apply_queries("DROP TABLE",$S);}function
last_id(){return
0;}function
schemas(){$I=get_vals("SELECT DISTINCT owner FROM dba_segments WHERE owner IN (SELECT username FROM dba_users WHERE default_tablespace NOT IN ('SYSTEM','SYSAUX')) ORDER BY 1");return($I?:get_vals("SELECT DISTINCT owner FROM all_tables WHERE tablespace_name = ".q(DB)." ORDER BY 1"));}function
get_schema(){return
get_val("SELECT sys_context('USERENV', 'SESSION_USER') FROM dual");}function
set_schema($Ug,$g=null){global$f;if(!$g)$g=$f;return$g->query("ALTER SESSION SET CURRENT_SCHEMA = ".idf_escape($Ug));}function
show_variables(){return
get_key_vals('SELECT name, display_value FROM v$parameter');}function
process_list(){return
get_rows('SELECT
	sess.process AS "process",
	sess.username AS "user",
	sess.schemaname AS "schema",
	sess.status AS "status",
	sess.wait_class AS "wait_class",
	sess.seconds_in_wait AS "seconds_in_wait",
	sql.sql_text AS "sql_text",
	sess.machine AS "machine",
	sess.port AS "port"
FROM v$session sess LEFT OUTER JOIN v$sql sql
ON sql.sql_id = sess.sql_id
WHERE sess.type = \'USER\'
ORDER BY PROCESS
');}function
show_status(){$K=get_rows('SELECT * FROM v$instance');return
reset($K);}function
convert_field($n){}function
unconvert_field($n,$I){return$I;}function
support($Nc){return
preg_match('~^(columns|database|drop_col|indexes|descidx|processlist|scheme|sql|status|table|variables|view)$~',$Nc);}}$Zb["mssql"]="MS SQL";if(isset($_GET["mssql"])){define('Adminer\DRIVER',"mssql");if(extension_loaded("sqlsrv")){class
Db{var$extension="sqlsrv",$server_info,$affected_rows,$errno,$error;private$link,$result;private
function
get_error(){$this->error="";foreach(sqlsrv_errors()as$m){$this->errno=$m["code"];$this->error.="$m[message]\n";}$this->error=rtrim($this->error);}function
connect($M,$V,$E){global$b;$rb=array("UID"=>$V,"PWD"=>$E,"CharacterSet"=>"UTF-8");$zh=$b->connectSsl();if(isset($zh["Encrypt"]))$rb["Encrypt"]=$zh["Encrypt"];if(isset($zh["TrustServerCertificate"]))$rb["TrustServerCertificate"]=$zh["TrustServerCertificate"];$j=$b->database();if($j!="")$rb["Database"]=$j;$this->link=@sqlsrv_connect(preg_replace('~:~',',',$M),$rb);if($this->link){$Nd=sqlsrv_server_info($this->link);$this->server_info=$Nd['SQLServerVersion'];}else$this->get_error();return(bool)$this->link;}function
quote($P){$zi=strlen($P)!=strlen(utf8_decode($P));return($zi?"N":"")."'".str_replace("'","''",$P)."'";}function
select_db($Ib){return$this->query(use_sql($Ib));}function
query($G,$yi=false){$H=sqlsrv_query($this->link,$G);$this->error="";if(!$H){$this->get_error();return
false;}return$this->store_result($H);}function
multi_query($G){$this->result=sqlsrv_query($this->link,$G);$this->error="";if(!$this->result){$this->get_error();return
false;}return
true;}function
store_result($H=null){if(!$H)$H=$this->result;if(!$H)return
false;if(sqlsrv_field_metadata($H))return
new
Result($H);$this->affected_rows=sqlsrv_rows_affected($H);return
true;}function
next_result(){return$this->result?sqlsrv_next_result($this->result):null;}function
result($G,$n=0){$H=$this->query($G);if(!is_object($H))return
false;$J=$H->fetch_row();return$J[$n];}}class
Result{var$num_rows;private$result,$offset=0,$fields;function
__construct($H){$this->result=$H;}private
function
convert($J){foreach((array)$J
as$y=>$X){if(is_a($X,'DateTime'))$J[$y]=$X->format("Y-m-d H:i:s");}return$J;}function
fetch_assoc(){return$this->convert(sqlsrv_fetch_array($this->result,SQLSRV_FETCH_ASSOC));}function
fetch_row(){return$this->convert(sqlsrv_fetch_array($this->result,SQLSRV_FETCH_NUMERIC));}function
fetch_field(){if(!$this->fields)$this->fields=sqlsrv_field_metadata($this->result);$n=$this->fields[$this->offset++];$I=new
\stdClass;$I->name=$n["Name"];$I->orgname=$n["Name"];$I->type=($n["Type"]==1?254:0);return$I;}function
seek($C){for($t=0;$t<$C;$t++)sqlsrv_fetch($this->result);}function
__destruct(){sqlsrv_free_stmt($this->result);}}}elseif(extension_loaded("pdo_sqlsrv")){class
Db
extends
PdoDb{var$extension="PDO_SQLSRV";function
connect($M,$V,$E){$this->dsn("sqlsrv:Server=".str_replace(":",",",$M),$V,$E);return
true;}function
select_db($Ib){return$this->query(use_sql($Ib));}}}elseif(extension_loaded("pdo_dblib")){class
Db
extends
PdoDb{var$extension="PDO_DBLIB";function
connect($M,$V,$E){$this->dsn("dblib:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\d)~',';port=\1',$M)),$V,$E);return
true;}function
select_db($Ib){return$this->query(use_sql($Ib));}}}class
Driver
extends
SqlDriver{static$fg=array("SQLSRV","PDO_SQLSRV","PDO_DBLIB");static$be="mssql";var$editFunctions=array(array("date|time"=>"getdate",),array("int|decimal|real|float|money|datetime"=>"+/-","char|text"=>"+",));var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL");var$functions=array("len","lower","round","upper");var$grouping=array("avg","count","count distinct","max","min","sum");var$onActions="NO ACTION|CASCADE|SET NULL|SET DEFAULT";var$generated=array("PERSISTED","VIRTUAL");function
__construct($f){parent::__construct($f);$this->types=array('數字'=>array("tinyint"=>3,"smallint"=>5,"int"=>10,"bigint"=>20,"bit"=>1,"decimal"=>0,"real"=>12,"float"=>53,"smallmoney"=>10,"money"=>20),'日期時間'=>array("date"=>10,"smalldatetime"=>19,"datetime"=>19,"datetime2"=>19,"time"=>8,"datetimeoffset"=>10),'字串'=>array("char"=>8000,"varchar"=>8000,"text"=>2147483647,"nchar"=>4000,"nvarchar"=>4000,"ntext"=>1073741823),'二進位'=>array("binary"=>8000,"varbinary"=>8000,"image"=>2147483647),);}function
insertUpdate($Q,$K,$F){$o=fields($Q);$Fi=array();$Z=array();$N=reset($K);$e="c".implode(", c",range(1,count($N)));$Na=0;$Rd=array();foreach($N
as$y=>$X){$Na++;$B=idf_unescape($y);if(!$o[$B]["auto_increment"])$Rd[$y]="c$Na";if(isset($F[$B]))$Z[]="$y = c$Na";else$Fi[]="$y = c$Na";}$Qi=array();foreach($K
as$N)$Qi[]="(".implode(", ",$N).")";if($Z){$Dd=queries("SET IDENTITY_INSERT ".table($Q)." ON");$I=queries("MERGE ".table($Q)." USING (VALUES\n\t".implode(",\n\t",$Qi)."\n) AS source ($e) ON ".implode(" AND ",$Z).($Fi?"\nWHEN MATCHED THEN UPDATE SET ".implode(", ",$Fi):"")."\nWHEN NOT MATCHED THEN INSERT (".implode(", ",array_keys($Dd?$N:$Rd)).") VALUES (".($Dd?$e:implode(", ",$Rd)).");");if($Dd)queries("SET IDENTITY_INSERT ".table($Q)." OFF");}else$I=queries("INSERT INTO ".table($Q)." (".implode(", ",array_keys($N)).") VALUES\n".implode(",\n",$Qi));return$I;}function
begin(){return
queries("BEGIN TRANSACTION");}function
tableHelp($B,$Zd=false){$te=array("sys"=>"catalog-views/sys-","INFORMATION_SCHEMA"=>"information-schema-views/",);$_=$te[get_schema()];if($_)return"relational-databases/system-$_".preg_replace('~_~','-',strtolower($B))."-transact-sql";}}function
idf_escape($v){return"[".str_replace("]","]]",$v)."]";}function
table($v){return($_GET["ns"]!=""?idf_escape($_GET["ns"]).".":"").idf_escape($v);}function
connect($Ab){$f=new
Db;if($Ab[0]=="")$Ab[0]="localhost:1433";if($f->connect($Ab[0],$Ab[1],$Ab[2]))return$f;return$f->error;}function
get_databases(){return
get_vals("SELECT name FROM sys.databases WHERE name NOT IN ('master', 'tempdb', 'model', 'msdb')");}function
limit($G,$Z,$z,$C=0,$ch=" "){return($z!==null?" TOP (".($z+$C).")":"")." $G$Z";}function
limit1($Q,$G,$Z,$ch="\n"){return
limit($G,$Z,1,0,$ch);}function
db_collation($j,$gb){return
get_val("SELECT collation_name FROM sys.databases WHERE name = ".q($j));}function
engines(){return
array();}function
logged_user(){return
get_val("SELECT SUSER_NAME()");}function
tables_list(){return
get_key_vals("SELECT name, type_desc FROM sys.all_objects WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ORDER BY name");}function
count_tables($i){global$f;$I=array();foreach($i
as$j){$f->select_db($j);$I[$j]=get_val("SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES");}return$I;}function
table_status($B=""){$I=array();foreach(get_rows("SELECT ao.name AS Name, ao.type_desc AS Engine, (SELECT value FROM fn_listextendedproperty(default, 'SCHEMA', schema_name(schema_id), 'TABLE', ao.name, null, null)) AS Comment
FROM sys.all_objects AS ao
WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ".($B!=""?"AND name = ".q($B):"ORDER BY name"))as$J){if($B!="")return$J;$I[$J["Name"]]=$J;}return$I;}function
is_view($R){return$R["Engine"]=="VIEW";}function
fk_support($R){return
true;}function
fields($Q){$nb=get_key_vals("SELECT objname, cast(value as varchar(max)) FROM fn_listextendedproperty('MS_DESCRIPTION', 'schema', ".q(get_schema()).", 'table', ".q($Q).", 'column', NULL)");$I=array();$Kh=get_val("SELECT object_id FROM sys.all_objects WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') AND name = ".q($Q));foreach(get_rows("SELECT c.max_length, c.precision, c.scale, c.name, c.is_nullable, c.is_identity, c.collation_name, t.name type, CAST(d.definition as text) [default], d.name default_constraint, i.is_primary_key
FROM sys.all_columns c
JOIN sys.types t ON c.user_type_id = t.user_type_id
LEFT JOIN sys.default_constraints d ON c.default_object_id = d.object_id
LEFT JOIN sys.index_columns ic ON c.object_id = ic.object_id AND c.column_id = ic.column_id
LEFT JOIN sys.indexes i ON ic.object_id = i.object_id AND ic.index_id = i.index_id
WHERE c.object_id = ".q($Kh))as$J){$U=$J["type"];$qe=(preg_match("~char|binary~",$U)?$J["max_length"]/($U[0]=='n'?2:1):($U=="decimal"?"$J[precision],$J[scale]":""));$I[$J["name"]]=array("field"=>$J["name"],"full_type"=>$U.($qe?"($qe)":""),"type"=>$U,"length"=>$qe,"default"=>(preg_match("~^\('(.*)'\)$~",$J["default"],$A)?str_replace("''","'",$A[1]):$J["default"]),"default_constraint"=>$J["default_constraint"],"null"=>$J["is_nullable"],"auto_increment"=>$J["is_identity"],"collation"=>$J["collation_name"],"privileges"=>array("insert"=>1,"select"=>1,"update"=>1,"where"=>1,"order"=>1),"primary"=>$J["is_primary_key"],"comment"=>$nb[$J["name"]],);}foreach(get_rows("SELECT * FROM sys.computed_columns WHERE object_id = ".q($Kh))as$J){$I[$J["name"]]["generated"]=($J["is_persisted"]?"PERSISTED":"VIRTUAL");$I[$J["name"]]["default"]=$J["definition"];}return$I;}function
indexes($Q,$g=null){$I=array();foreach(get_rows("SELECT i.name, key_ordinal, is_unique, is_primary_key, c.name AS column_name, is_descending_key
FROM sys.indexes i
INNER JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
INNER JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
WHERE OBJECT_NAME(i.object_id) = ".q($Q),$g)as$J){$B=$J["name"];$I[$B]["type"]=($J["is_primary_key"]?"PRIMARY":($J["is_unique"]?"UNIQUE":"INDEX"));$I[$B]["lengths"]=array();$I[$B]["columns"][$J["key_ordinal"]]=$J["column_name"];$I[$B]["descs"][$J["key_ordinal"]]=($J["is_descending_key"]?'1':null);}return$I;}function
view($B){return
array("select"=>preg_replace('~^(?:[^[]|\[[^]]*])*\s+AS\s+~isU','',get_val("SELECT VIEW_DEFINITION FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = SCHEMA_NAME() AND TABLE_NAME = ".q($B))));}function
collations(){$I=array();foreach(get_vals("SELECT name FROM fn_helpcollations()")as$fb)$I[preg_replace('~_.*~','',$fb)][]=$fb;return$I;}function
information_schema($j){return
get_schema()=="INFORMATION_SCHEMA";}function
error(){global$f;return
nl_br(h(preg_replace('~^(\[[^]]*])+~m','',$f->error)));}function
create_database($j,$fb){return
queries("CREATE DATABASE ".idf_escape($j).(preg_match('~^[a-z0-9_]+$~i',$fb)?" COLLATE $fb":""));}function
drop_databases($i){return
queries("DROP DATABASE ".implode(", ",array_map('Adminer\idf_escape',$i)));}function
rename_database($B,$fb){if(preg_match('~^[a-z0-9_]+$~i',$fb))queries("ALTER DATABASE ".idf_escape(DB)." COLLATE $fb");queries("ALTER DATABASE ".idf_escape(DB)." MODIFY NAME = ".idf_escape($B));return
true;}function
auto_increment(){return" IDENTITY".($_POST["Auto_increment"]!=""?"(".number($_POST["Auto_increment"]).",1)":"")." PRIMARY KEY";}function
alter_table($Q,$B,$o,$ad,$lb,$qc,$fb,$_a,$Tf){$c=array();$nb=array();$Df=fields($Q);foreach($o
as$n){$d=idf_escape($n[0]);$X=$n[1];if(!$X)$c["DROP"][]=" COLUMN $d";else{$X[1]=preg_replace("~( COLLATE )'(\\w+)'~",'\1\2',$X[1]);$nb[$n[0]]=$X[5];unset($X[5]);if(preg_match('~ AS ~',$X[3]))unset($X[1],$X[2]);if($n[0]=="")$c["ADD"][]="\n  ".implode("",$X).($Q==""?substr($ad[$X[0]],16+strlen($X[0])):"");else{$k=$X[3];unset($X[3]);unset($X[6]);if($d!=$X[0])queries("EXEC sp_rename ".q(table($Q).".$d").", ".q(idf_unescape($X[0])).", 'COLUMN'");$c["ALTER COLUMN ".implode("",$X)][]="";$Cf=$Df[$n[0]];if(default_value($Cf)!=$k){if($Cf["default"]!==null)$c["DROP"][]=" ".idf_escape($Cf["default_constraint"]);if($k)$c["ADD"][]="\n $k FOR $d";}}}}if($Q=="")return
queries("CREATE TABLE ".table($B)." (".implode(",",(array)$c["ADD"])."\n)");if($Q!=$B)queries("EXEC sp_rename ".q(table($Q)).", ".q($B));if($ad)$c[""]=$ad;foreach($c
as$y=>$X){if(!queries("ALTER TABLE ".table($B)." $y".implode(",",$X)))return
false;}foreach($nb
as$y=>$X){$lb=substr($X,9);queries("EXEC sp_dropextendedproperty @name = N'MS_Description', @level0type = N'Schema', @level0name = ".q(get_schema()).", @level1type = N'Table', @level1name = ".q($B).", @level2type = N'Column', @level2name = ".q($y));queries("EXEC sp_addextendedproperty
@name = N'MS_Description',
@value = $lb,
@level0type = N'Schema',
@level0name = ".q(get_schema()).",
@level1type = N'Table',
@level1name = ".q($B).",
@level2type = N'Column',
@level2name = ".q($y));}return
true;}function
alter_indexes($Q,$c){$w=array();$ac=array();foreach($c
as$X){if($X[2]=="DROP"){if($X[0]=="PRIMARY")$ac[]=idf_escape($X[1]);else$w[]=idf_escape($X[1])." ON ".table($Q);}elseif(!queries(($X[0]!="PRIMARY"?"CREATE $X[0] ".($X[0]!="INDEX"?"INDEX ":"").idf_escape($X[1]!=""?$X[1]:uniqid($Q."_"))." ON ".table($Q):"ALTER TABLE ".table($Q)." ADD PRIMARY KEY")." (".implode(", ",$X[2]).")"))return
false;}return(!$w||queries("DROP INDEX ".implode(", ",$w)))&&(!$ac||queries("ALTER TABLE ".table($Q)." DROP ".implode(", ",$ac)));}function
last_id(){return
get_val("SELECT SCOPE_IDENTITY()");}function
explain($f,$G){$f->query("SET SHOWPLAN_ALL ON");$I=$f->query($G);$f->query("SET SHOWPLAN_ALL OFF");return$I;}function
found_rows($R,$Z){}function
foreign_keys($Q){$I=array();$of=array("CASCADE","NO ACTION","SET NULL","SET DEFAULT");foreach(get_rows("EXEC sp_fkeys @fktable_name = ".q($Q).", @fktable_owner = ".q(get_schema()))as$J){$q=&$I[$J["FK_NAME"]];$q["db"]=$J["PKTABLE_QUALIFIER"];$q["ns"]=$J["PKTABLE_OWNER"];$q["table"]=$J["PKTABLE_NAME"];$q["on_update"]=$of[$J["UPDATE_RULE"]];$q["on_delete"]=$of[$J["DELETE_RULE"]];$q["source"][]=$J["FKCOLUMN_NAME"];$q["target"][]=$J["PKCOLUMN_NAME"];}return$I;}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($Vi){return
queries("DROP VIEW ".implode(", ",array_map('Adminer\table',$Vi)));}function
drop_tables($S){return
queries("DROP TABLE ".implode(", ",array_map('Adminer\table',$S)));}function
move_tables($S,$Vi,$Th){return
apply_queries("ALTER SCHEMA ".idf_escape($Th)." TRANSFER",array_merge($S,$Vi));}function
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
get_schema(){if($_GET["ns"]!="")return$_GET["ns"];return
get_val("SELECT SCHEMA_NAME()");}function
set_schema($Sg){$_GET["ns"]=$Sg;return
true;}function
create_sql($Q,$_a,$Dh){global$l;if(is_view(table_status($Q))){$Ui=view($Q);return"CREATE VIEW ".table($Q)." AS $Ui[select]";}$o=array();$F=false;foreach(fields($Q)as$B=>$n){$X=process_field($n,$n);if($X[6])$F=true;$o[]=implode("",$X);}foreach(indexes($Q)as$B=>$w){if(!$F||$w["type"]!="PRIMARY"){$e=array();foreach($w["columns"]as$y=>$X)$e[]=idf_escape($X).($w["descs"][$y]?" DESC":"");$B=idf_escape($B);$o[]=($w["type"]=="INDEX"?"INDEX $B":"CONSTRAINT $B ".($w["type"]=="UNIQUE"?"UNIQUE":"PRIMARY KEY"))." (".implode(", ",$e).")";}}foreach($l->checkConstraints($Q)as$B=>$Ta)$o[]="CONSTRAINT ".idf_escape($B)." CHECK ($Ta)";return"CREATE TABLE ".table($Q)." (\n\t".implode(",\n\t",$o)."\n)";}function
foreign_keys_sql($Q){$o=array();foreach(foreign_keys($Q)as$ad)$o[]=ltrim(format_foreign_key($ad));return($o?"ALTER TABLE ".table($Q)." ADD\n\t".implode(",\n\t",$o).";\n\n":"");}function
truncate_sql($Q){return"TRUNCATE TABLE ".table($Q);}function
use_sql($Ib){return"USE ".idf_escape($Ib);}function
trigger_sql($Q){$I="";foreach(triggers($Q)as$B=>$ri)$I.=create_trigger(" ON ".table($Q),trigger($B)).";";return$I;}function
convert_field($n){}function
unconvert_field($n,$I){return$I;}function
support($Nc){return
preg_match('~^(check|comment|columns|database|drop_col|dump|indexes|descidx|scheme|sql|table|trigger|view|view_trigger)$~',$Nc);}}class
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
databases($Yc=true){return
get_databases($Yc);}function
schemas(){return
schemas();}function
queryTimeout(){return
2;}function
headers(){}function
csp(){return
csp();}function
head($Fb=null){return
true;}function
css(){$I=array();foreach(array("","-dark")as$Qe){$p="adminer$Qe.css";if(file_exists($p))$I[]="$p?v=".crc32(file_get_contents($p));}return$I;}function
loginForm(){global$Zb;echo"<table class='layout'>\n",$this->loginFormField('driver','<tr><th>'.'資料庫系統'.'<td>',html_select("auth[driver]",$Zb,DRIVER,"loginDriver(this);")),$this->loginFormField('server','<tr><th>'.'伺服器'.'<td>','<input name="auth[server]" value="'.h(SERVER).'" title="hostname[:port]" placeholder="localhost" autocapitalize="off">'),$this->loginFormField('username','<tr><th>'.'帳號'.'<td>','<input name="auth[username]" id="username" autofocus value="'.h($_GET["username"]).'" autocomplete="username" autocapitalize="off">'.script("qs('#username').form['auth[driver]'].onchange();")),$this->loginFormField('password','<tr><th>'.'密碼'.'<td>','<input type="password" name="auth[password]" autocomplete="current-password">'),$this->loginFormField('db','<tr><th>'.'資料庫'.'<td>','<input name="auth[db]" value="'.h($_GET["db"]).'" autocapitalize="off">'),"</table>\n","<p><input type='submit' value='".'登入'."'>\n",checkbox("auth[permanent]",1,$_COOKIE["adminer_permanent"],'永久登入')."\n";}function
loginFormField($B,$yd,$Y){return$yd.$Y."\n";}function
login($ve,$E){if($E=="")return
sprintf('Adminer預設不支援訪問沒有密碼的資料庫，<a href="https://www.adminer.org/en/password/"%s>詳情見這裡</a>。',target_blank());return
true;}function
tableName($Jh){return
h($Jh["Name"]);}function
fieldName($n,$xf=0){return'<span title="'.h($n["full_type"].($n["comment"]!=""?" : $n[comment]":'')).'">'.h($n["field"]).'</span>';}function
selectLinks($Jh,$N=""){global$l;echo'<p class="links">';$te=array("select"=>'選擇資料');if(support("table")||support("indexes"))$te["table"]='顯示結構';$Zd=false;if(support("table")){$Zd=is_view($Jh);if($Zd)$te["view"]='修改檢視表';else$te["create"]='修改資料表';}if($N!==null)$te["edit"]='新增項目';$B=$Jh["Name"];foreach($te
as$y=>$X)echo" <a href='".h(ME)."$y=".urlencode($B).($y=="edit"?$N:"")."'".bold(isset($_GET[$y])).">$X</a>";echo
doc_link(array(JUSH=>$l->tableHelp($B,$Zd)),"?"),"\n";}function
foreignKeys($Q){return
foreign_keys($Q);}function
backwardKeys($Q,$Ih){return
array();}function
backwardKeysPrint($Da,$J){}function
selectQuery($G,$_h,$Lc=false){global$l;$I="</p>\n";if(!$Lc&&($Yi=$l->warnings())){$u="warnings";$I=", <a href='#$u'>".'警告'."</a>".script("qsl('a').onclick = partial(toggle, '$u');","")."$I<div id='$u' class='hidden'>\n$Yi</div>\n";}return"<p><code class='jush-".JUSH."'>".h(str_replace("\n"," ",$G))."</code> <span class='time'>(".format_time($_h).")</span>".(support("sql")?" <a href='".h(ME)."sql=".urlencode($G)."'>".'編輯'."</a>":"").$I;}function
sqlCommandQuery($G){return
shorten_utf8(trim($G),1000);}function
rowDescription($Q){return"";}function
rowDescriptions($K,$bd){return$K;}function
selectLink($X,$n){}function
selectVal($X,$_,$n,$Gf){$I=($X===null?"<i>NULL</i>":(preg_match("~char|binary|boolean~",$n["type"])&&!preg_match("~var~",$n["type"])?"<code>$X</code>":(preg_match('~json~',$n["type"])?"<code class='jush-js'>$X</code>":$X)));if(preg_match('~blob|bytea|raw|file~',$n["type"])&&!is_utf8($X))$I="<i>".sprintf('%d byte(s)',strlen($Gf))."</i>";return($_?"<a href='".h($_)."'".(is_url($_)?target_blank():"").">$I</a>":$I);}function
editVal($X,$n){return$X;}function
tableStructurePrint($o){global$l;echo"<div class='scrollable'>\n","<table class='nowrap odds'>\n","<thead><tr><th>".'欄位'."<td>".'類型'.(support("comment")?"<td>".'註解':"")."</thead>\n";$Ch=$l->structuredTypes();foreach($o
as$n){echo"<tr><th>".h($n["field"]);$U=h($n["full_type"]);echo"<td><span title='".h($n["collation"])."'>".(in_array($U,(array)$Ch['使用者類型'])?"<a href='".h(ME.'type='.urlencode($U))."'>$U</a>":$U)."</span>",($n["null"]?" <i>NULL</i>":""),($n["auto_increment"]?" <i>".'自動遞增'."</i>":"");$k=h($n["default"]);echo(isset($n["default"])?" <span title='".'預設值'."'>[<b>".($n["generated"]?"<code class='jush-".JUSH."'>$k</code>":$k)."</b>]</span>":""),(support("comment")?"<td>".h($n["comment"]):""),"\n";}echo"</table>\n","</div>\n";}function
tableIndexesPrint($x){echo"<table>\n";foreach($x
as$B=>$w){ksort($w["columns"]);$kg=array();foreach($w["columns"]as$y=>$X)$kg[]="<i>".h($X)."</i>".($w["lengths"][$y]?"(".$w["lengths"][$y].")":"").($w["descs"][$y]?" DESC":"");echo"<tr title='".h($B)."'><th>$w[type]<td>".implode(", ",$kg)."\n";}echo"</table>\n";}function
selectColumnsPrint($L,$e){global$l;print_fieldset("select",'選擇',$L);$t=0;$L[""]=array();foreach($L
as$y=>$X){$X=$_GET["columns"][$y];$d=select_input(" name='columns[$t][col]'",$e,$X["col"],($y!==""?"selectFieldChange":"selectAddRow"));echo"<div>".($l->functions||$l->grouping?html_select("columns[$t][fun]",array(-1=>"")+array_filter(array('函式'=>$l->functions,'集合'=>$l->grouping)),$X["fun"]).on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'",1).script("qsl('select').onchange = function () { helpClose();".($y!==""?"":" qsl('select, input', this.parentNode).onchange();")." };","")."($d)":$d)."</div>\n";$t++;}echo"</div></fieldset>\n";}function
selectSearchPrint($Z,$e,$x){print_fieldset("search",'搜尋',$Z);foreach($x
as$t=>$w){if($w["type"]=="FULLTEXT")echo"<div>(<i>".implode("</i>, <i>",array_map('Adminer\h',$w["columns"]))."</i>) AGAINST"," <input type='search' name='fulltext[$t]' value='".h($_GET["fulltext"][$t])."'>",script("qsl('input').oninput = selectFieldChange;",""),checkbox("boolean[$t]",1,isset($_GET["boolean"][$t]),"BOOL"),"</div>\n";}$Ra="this.parentNode.firstChild.onchange();";foreach(array_merge((array)$_GET["where"],array(array()))as$t=>$X){if(!$X||("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators)))echo"<div>".select_input(" name='where[$t][col]'",$e,$X["col"],($X?"selectFieldChange":"selectAddRow"),"(".'任意位置'.")"),html_select("where[$t][op]",$this->operators,$X["op"],$Ra),"<input type='search' name='where[$t][val]' value='".h($X["val"])."'>",script("mixin(qsl('input'), {oninput: function () { $Ra }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});",""),"</div>\n";}echo"</div></fieldset>\n";}function
selectOrderPrint($xf,$e,$x){print_fieldset("sort",'排序',$xf);$t=0;foreach((array)$_GET["order"]as$y=>$X){if($X!=""){echo"<div>".select_input(" name='order[$t]'",$e,$X,"selectFieldChange"),checkbox("desc[$t]",1,isset($_GET["desc"][$y]),'降冪 (遞減)')."</div>\n";$t++;}}echo"<div>".select_input(" name='order[$t]'",$e,"","selectAddRow"),checkbox("desc[$t]",1,false,'降冪 (遞減)')."</div>\n","</div></fieldset>\n";}function
selectLimitPrint($z){echo"<fieldset><legend>".'限定'."</legend><div>","<input type='number' name='limit' class='size' value='".h($z)."'>",script("qsl('input').oninput = selectFieldChange;",""),"</div></fieldset>\n";}function
selectLengthPrint($Zh){if($Zh!==null)echo"<fieldset><legend>".'Text 長度'."</legend><div>","<input type='number' name='text_length' class='size' value='".h($Zh)."'>","</div></fieldset>\n";}function
selectActionPrint($x){echo"<fieldset><legend>".'動作'."</legend><div>","<input type='submit' value='".'選擇'."'>"," <span id='noindex' title='".'全資料表掃描'."'></span>","<script".nonce().">\n","var indexColumns = ";$e=array();foreach($x
as$w){$Eb=reset($w["columns"]);if($w["type"]!="FULLTEXT"&&$Eb)$e[$Eb]=1;}$e[""]=1;foreach($e
as$y=>$X)json_row($y);echo";\n","selectFieldChange.call(qs('#form')['select']);\n","</script>\n","</div></fieldset>\n";}function
selectCommandPrint(){return!information_schema(DB);}function
selectImportPrint(){return!information_schema(DB);}function
selectEmailPrint($nc,$e){}function
selectColumnsProcess($e,$x){global$l;$L=array();$nd=array();foreach((array)$_GET["columns"]as$y=>$X){if($X["fun"]=="count"||($X["col"]!=""&&(!$X["fun"]||in_array($X["fun"],$l->functions)||in_array($X["fun"],$l->grouping)))){$L[$y]=apply_sql_function($X["fun"],($X["col"]!=""?idf_escape($X["col"]):"*"));if(!in_array($X["fun"],$l->grouping))$nd[]=$L[$y];}}return
array($L,$nd);}function
selectSearchProcess($o,$x){global$f,$l;$I=array();foreach($x
as$t=>$w){if($w["type"]=="FULLTEXT"&&$_GET["fulltext"][$t]!="")$I[]="MATCH (".implode(", ",array_map('Adminer\idf_escape',$w["columns"])).") AGAINST (".q($_GET["fulltext"][$t]).(isset($_GET["boolean"][$t])?" IN BOOLEAN MODE":"").")";}foreach((array)$_GET["where"]as$y=>$X){if("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators)){$hg="";$ob=" $X[op]";if(preg_match('~IN$~',$X["op"])){$Hd=process_length($X["val"]);$ob.=" ".($Hd!=""?$Hd:"(NULL)");}elseif($X["op"]=="SQL")$ob=" $X[val]";elseif($X["op"]=="LIKE %%")$ob=" LIKE ".$this->processInput($o[$X["col"]],"%$X[val]%");elseif($X["op"]=="ILIKE %%")$ob=" ILIKE ".$this->processInput($o[$X["col"]],"%$X[val]%");elseif($X["op"]=="FIND_IN_SET"){$hg="$X[op](".q($X["val"]).", ";$ob=")";}elseif(!preg_match('~NULL$~',$X["op"]))$ob.=" ".$this->processInput($o[$X["col"]],$X["val"]);if($X["col"]!="")$I[]=$hg.$l->convertSearch(idf_escape($X["col"]),$X,$o[$X["col"]]).$ob;else{$hb=array();foreach($o
as$B=>$n){if(isset($n["privileges"]["where"])&&(preg_match('~^[-\d.'.(preg_match('~IN$~',$X["op"])?',':'').']+$~',$X["val"])||!preg_match('~'.number_type().'|bit~',$n["type"]))&&(!preg_match("~[\x80-\xFF]~",$X["val"])||preg_match('~char|text|enum|set~',$n["type"]))&&(!preg_match('~date|timestamp~',$n["type"])||preg_match('~^\d+-\d+-\d+~',$X["val"])))$hb[]=$hg.$l->convertSearch(idf_escape($B),$X,$n).$ob;}$I[]=($hb?"(".implode(" OR ",$hb).")":"1 = 0");}}}return$I;}function
selectOrderProcess($o,$x){$I=array();foreach((array)$_GET["order"]as$y=>$X){if($X!="")$I[]=(preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~',$X)?$X:idf_escape($X)).(isset($_GET["desc"][$y])?" DESC":"");}return$I;}function
selectLimitProcess(){return(isset($_GET["limit"])?$_GET["limit"]:"50");}function
selectLengthProcess(){return(isset($_GET["text_length"])?$_GET["text_length"]:"100");}function
selectEmailProcess($Z,$bd){return
false;}function
selectQueryBuild($L,$Z,$nd,$xf,$z,$D){return"";}function
messageQuery($G,$ai,$Lc=false){global$l;restart_session();$zd=&get_session("queries");if(!$zd[$_GET["db"]])$zd[$_GET["db"]]=array();if(strlen($G)>1e6)$G=preg_replace('~[\x80-\xFF]+$~','',substr($G,0,1e6))."\n…";$zd[$_GET["db"]][]=array($G,time(),$ai);$wh="sql-".count($zd[$_GET["db"]]);$I="<a href='#$wh' class='toggle'>".'SQL 命令'."</a>\n";if(!$Lc&&($Yi=$l->warnings())){$u="warnings-".count($zd[$_GET["db"]]);$I="<a href='#$u' class='toggle'>".'警告'."</a>, $I<div id='$u' class='hidden'>\n$Yi</div>\n";}return" <span class='time'>".@date("H:i:s")."</span>"." $I<div id='$wh' class='hidden'><pre><code class='jush-".JUSH."'>".shorten_utf8($G,1000)."</code></pre>".($ai?" <span class='time'>($ai)</span>":'').(support("sql")?'<p><a href="'.h(str_replace("db=".urlencode(DB),"db=".urlencode($_GET["db"]),ME).'sql=&history='.(count($zd[$_GET["db"]])-1)).'">'.'編輯'.'</a>':'').'</div>';}function
editRowPrint($Q,$o,$J,$Fi){}function
editFunctions($n){global$l;$I=($n["null"]?"NULL/":"");$Fi=isset($_GET["select"])||where($_GET);foreach($l->editFunctions
as$y=>$id){if(!$y||(!isset($_GET["call"])&&$Fi)){foreach($id
as$Xf=>$X){if(!$Xf||preg_match("~$Xf~",$n["type"]))$I.="/$X";}}if($y&&!preg_match('~set|blob|bytea|raw|file|bool~',$n["type"]))$I.="/SQL";}if($n["auto_increment"]&&!$Fi)$I='自動遞增';return
explode("/",$I);}function
editInput($Q,$n,$ya,$Y){if($n["type"]=="enum")return(isset($_GET["select"])?"<label><input type='radio'$ya value='-1' checked><i>".'原始'."</i></label> ":"").($n["null"]?"<label><input type='radio'$ya value=''".($Y!==null||isset($_GET["select"])?"":" checked")."><i>NULL</i></label> ":"").enum_input("radio",$ya,$n,$Y,$Y===0?0:null);return"";}function
editHint($Q,$n,$Y){return"";}function
processInput($n,$Y,$s=""){if($s=="SQL")return$Y;$B=$n["field"];$I=q($Y);if(preg_match('~^(now|getdate|uuid)$~',$s))$I="$s()";elseif(preg_match('~^current_(date|timestamp)$~',$s))$I=$s;elseif(preg_match('~^([+-]|\|\|)$~',$s))$I=idf_escape($B)." $s $I";elseif(preg_match('~^[+-] interval$~',$s))$I=idf_escape($B)." $s ".(preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i",$Y)?$Y:$I);elseif(preg_match('~^(addtime|subtime|concat)$~',$s))$I="$s(".idf_escape($B).", $I)";elseif(preg_match('~^(md5|sha1|password|encrypt)$~',$s))$I="$s($I)";return
unconvert_field($n,$I);}function
dumpOutput(){$I=array('text'=>'打開','file'=>'儲存');if(function_exists('gzencode'))$I['gz']='gzip';return$I;}function
dumpFormat(){return(support("dump")?array('sql'=>'SQL'):array())+array('csv'=>'CSV,','csv;'=>'CSV;','tsv'=>'TSV');}function
dumpDatabase($j){}function
dumpTable($Q,$Dh,$Zd=0){if($_POST["format"]!="sql"){echo"\xef\xbb\xbf";if($Dh)dump_csv(array_keys(fields($Q)));}else{if($Zd==2){$o=array();foreach(fields($Q)as$B=>$n)$o[]=idf_escape($B)." $n[full_type]";$h="CREATE TABLE ".table($Q)." (".implode(", ",$o).")";}else$h=create_sql($Q,$_POST["auto_increment"],$Dh);set_utf8mb4($h);if($Dh&&$h){if($Dh=="DROP+CREATE"||$Zd==1)echo"DROP ".($Zd==2?"VIEW":"TABLE")." IF EXISTS ".table($Q).";\n";if($Zd==1)$h=remove_definer($h);echo"$h;\n\n";}}}function
dumpData($Q,$Dh,$G){global$f;if($Dh){$Ce=(JUSH=="sqlite"?0:1048576);$o=array();$Ed=false;if($_POST["format"]=="sql"){if($Dh=="TRUNCATE+INSERT")echo
truncate_sql($Q).";\n";$o=fields($Q);if(JUSH=="mssql"){foreach($o
as$n){if($n["auto_increment"]){echo"SET IDENTITY_INSERT ".table($Q)." ON;\n";$Ed=true;break;}}}}$H=$f->query($G,1);if($H){$Rd="";$Ma="";$ee=array();$jd=array();$Fh="";$Oc=($Q!=''?'fetch_assoc':'fetch_row');while($J=$H->$Oc()){if(!$ee){$Qi=array();foreach($J
as$X){$n=$H->fetch_field();if($o[$n->name]['generated']){$jd[$n->name]=true;continue;}$ee[]=$n->name;$y=idf_escape($n->name);$Qi[]="$y = VALUES($y)";}$Fh=($Dh=="INSERT+UPDATE"?"\nON DUPLICATE KEY UPDATE ".implode(", ",$Qi):"").";\n";}if($_POST["format"]!="sql"){if($Dh=="table"){dump_csv($ee);$Dh="INSERT";}dump_csv($J);}else{if(!$Rd)$Rd="INSERT INTO ".table($Q)." (".implode(", ",array_map('Adminer\idf_escape',$ee)).") VALUES";foreach($J
as$y=>$X){if($jd[$y]){unset($J[$y]);continue;}$n=$o[$y];$J[$y]=($X!==null?unconvert_field($n,preg_match(number_type(),$n["type"])&&!preg_match('~\[~',$n["full_type"])&&is_numeric($X)?$X:q(($X===false?0:$X))):"NULL");}$Qg=($Ce?"\n":" ")."(".implode(",\t",$J).")";if(!$Ma)$Ma=$Rd.$Qg;elseif(strlen($Ma)+4+strlen($Qg)+strlen($Fh)<$Ce)$Ma.=",$Qg";else{echo$Ma.$Fh;$Ma=$Rd.$Qg;}}}if($Ma)echo$Ma.$Fh;}elseif($_POST["format"]=="sql")echo"-- ".str_replace("\n"," ",$f->error)."\n";if($Ed)echo"SET IDENTITY_INSERT ".table($Q)." OFF;\n";}}function
dumpFilename($Cd){return
friendly_url($Cd!=""?$Cd:(SERVER!=""?SERVER:"localhost"));}function
dumpHeaders($Cd,$Re=false){$Jf=$_POST["output"];$Gc=(preg_match('~sql~',$_POST["format"])?"sql":($Re?"tar":"csv"));header("Content-Type: ".($Jf=="gz"?"application/x-gzip":($Gc=="tar"?"application/x-tar":($Gc=="sql"||$Jf!="file"?"text/plain":"text/csv")."; charset=utf-8")));if($Jf=="gz"){ob_start(function($P){return
gzencode($P);},1e6);}return$Gc;}function
dumpFooter(){if($_POST["format"]=="sql")echo"-- ".gmdate("Y-m-d H:i:s e")."\n";}function
importServerPath(){return"adminer.sql";}function
homepage(){echo'<p class="links">'.($_GET["ns"]==""&&support("database")?'<a href="'.h(ME).'database=">'.'修改資料庫'."</a>\n":""),(support("scheme")?"<a href='".h(ME)."scheme='>".($_GET["ns"]!=""?'修改資料表結構':'建立資料表結構')."</a>\n":""),($_GET["ns"]!==""?'<a href="'.h(ME).'schema=">'.'資料庫結構'."</a>\n":""),(support("privileges")?"<a href='".h(ME)."privileges='>".'權限'."</a>\n":"");return
true;}function
navigation($Pe){global$ia,$Zb,$f;echo'<h1>
',$this->name(),'<span class="version">
',$ia,' <a href="https://www.adminer.org/#download"',target_blank(),' id="version">',(version_compare($ia,$_COOKIE["adminer_version"])<0?h($_COOKIE["adminer_version"]):""),'</a>
</span>
</h1>
';if($Pe=="auth"){$Jf="";foreach((array)$_SESSION["pwds"]as$Si=>$hh){foreach($hh
as$M=>$Ni){$B=h(get_setting("vendor-$M")?:$Zb[$Si]);foreach($Ni
as$V=>$E){if($E!==null){$Lb=$_SESSION["db"][$Si][$M][$V];foreach(($Lb?array_keys($Lb):array(""))as$j)$Jf.="<li><a href='".h(auth_url($Si,$M,$V,$j))."'>($B) ".h($V.($M!=""?"@".$this->serverName($M):"").($j!=""?" - $j":""))."</a>\n";}}}}if($Jf)echo"<ul id='logins'>\n$Jf</ul>\n".script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");}else{$S=array();if($_GET["ns"]!==""&&!$Pe&&DB!=""){$f->select_db(DB);$S=table_status('',true);}$this->syntaxHighlighting($S);$this->databasesPrint($Pe);$la=array();if(DB==""||!$Pe){if(support("sql")){$la[]="<a href='".h(ME)."sql='".bold(isset($_GET["sql"])&&!isset($_GET["import"])).">".'SQL 命令'."</a>";$la[]="<a href='".h(ME)."import='".bold(isset($_GET["import"])).">".'匯入'."</a>";}$la[]="<a href='".h(ME)."dump=".urlencode(isset($_GET["table"])?$_GET["table"]:$_GET["select"])."' id='dump'".bold(isset($_GET["dump"])).">".'匯出'."</a>";}$Id=$_GET["ns"]!==""&&!$Pe&&DB!="";if($Id)$la[]='<a href="'.h(ME).'create="'.bold($_GET["create"]==="").">".'建立資料表'."</a>";echo($la?"<p class='links'>\n".implode("\n",$la)."\n":"");if($Id){if($S)$this->tablesPrint($S);else
echo"<p class='message'>".'沒有資料表。'."</p>\n";}}}function
syntaxHighlighting($S){global$f;echo
script_src(preg_replace("~\\?.*~","",ME)."?file=jush.js&version=5.0.6");if(support("sql")){echo"<script".nonce().">\n";if($S){$te=array();foreach($S
as$Q=>$U)$te[]=preg_quote($Q,'/');echo"var jushLinks = { ".JUSH.": [ '".js_escape(ME).(support("table")?"table=":"select=")."\$&', /\\b(".implode("|",$te).")\\b/g ] };\n";foreach(array("bac","bra","sqlite_quo","mssql_bra")as$X)echo"jushLinks.$X = jushLinks.".JUSH.";\n";}echo"</script>\n";}echo
script("bodyLoad('".(is_object($f)?preg_replace('~^(\d\.?\d).*~s','\1',$f->server_info):"")."'".($f->maria?", true":"").");");}function
databasesPrint($Pe){global$b,$f;$i=$this->databases();if(DB&&$i&&!in_array(DB,$i))array_unshift($i,DB);echo'<form action="">
<p id="dbs">
';hidden_fields_get();$Jb=script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");echo"<span title='".'資料庫'."'>".'資料庫'.":</span> ".($i?html_select("db",array(""=>"")+$i,DB).$Jb:"<input name='db' value='".h(DB)."' autocapitalize='off' size='19'>\n"),"<input type='submit' value='".'使用'."'".($i?" class='hidden'":"").">\n";if(support("scheme")){if($Pe!="db"&&DB!=""&&$f->select_db(DB)){echo"<br><span>".'資料表結構'.":</span> ".html_select("ns",array(""=>"")+$b->schemas(),$_GET["ns"]).$Jb;if($_GET["ns"]!="")set_schema($_GET["ns"]);}}foreach(array("import","sql","schema","dump","privileges")as$X){if(isset($_GET[$X])){echo"<input type='hidden' name='$X' value=''>";break;}}echo"</p></form>\n";}function
tablesPrint($S){echo"<ul id='tables'>".script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");foreach($S
as$Q=>$O){$B=$this->tableName($O);if($B!="")echo'<li><a href="'.h(ME).'select='.urlencode($Q).'"'.bold($_GET["select"]==$Q||$_GET["edit"]==$Q,"select")." title='".'選擇資料'."'>".'選擇'."</a> ",(support("table")||support("indexes")?'<a href="'.h(ME).'table='.urlencode($Q).'"'.bold(in_array($Q,array($_GET["table"],$_GET["create"],$_GET["indexes"],$_GET["foreign"],$_GET["trigger"])),(is_view($O)?"view":"structure"))." title='".'顯示結構'."'>$B</a>":"<span>$B</span>")."\n";}echo"</ul>\n";}}$b=(function_exists('adminer_object')?adminer_object():new
Adminer);$Zb=array("server"=>"MySQL / MariaDB")+$Zb;if(!defined('Adminer\DRIVER')){define('Adminer\DRIVER',"server");if(extension_loaded("mysqli")){class
Db
extends
\MySQLi{var$extension="MySQLi";function
__construct(){parent::init();}function
connect($M="",$V="",$E="",$Ib=null,$bg=null,$ph=null){global$b;mysqli_report(MYSQLI_REPORT_OFF);list($Ad,$bg)=explode(":",$M,2);$zh=$b->connectSsl();if($zh)$this->ssl_set($zh['key'],$zh['cert'],$zh['ca'],'','');$I=@$this->real_connect(($M!=""?$Ad:ini_get("mysqli.default_host")),($M.$V!=""?$V:ini_get("mysqli.default_user")),($M.$V.$E!=""?$E:ini_get("mysqli.default_pw")),$Ib,(is_numeric($bg)?$bg:ini_get("mysqli.default_port")),(!is_numeric($bg)?$bg:$ph),($zh?($zh['verify']!==false?2048:64):0));$this->options(MYSQLI_OPT_LOCAL_INFILE,false);return$I;}function
set_charset($Sa){if(parent::set_charset($Sa))return
true;parent::set_charset('utf8');return$this->query("SET NAMES $Sa");}function
result($G,$n=0){$H=$this->query($G);if(!$H)return
false;$J=$H->fetch_array();return$J[$n];}function
quote($P){return"'".$this->escape_string($P)."'";}}}elseif(extension_loaded("mysql")&&!((ini_bool("sql.safe_mode")||ini_bool("mysql.allow_local_infile"))&&extension_loaded("pdo_mysql"))){class
Db{var$extension="MySQL",$server_info,$affected_rows,$errno,$error;private$link,$result;function
connect($M,$V,$E){if(ini_bool("mysql.allow_local_infile")){$this->error=sprintf('禁用 %s 或啟用 %s 或 %s 擴充模組。',"'mysql.allow_local_infile'","MySQLi","PDO_MySQL");return
false;}$this->link=@mysql_connect(($M!=""?$M:ini_get("mysql.default_host")),("$M$V"!=""?$V:ini_get("mysql.default_user")),("$M$V$E"!=""?$E:ini_get("mysql.default_password")),true,131072);if($this->link)$this->server_info=mysql_get_server_info($this->link);else$this->error=mysql_error();return(bool)$this->link;}function
set_charset($Sa){if(function_exists('mysql_set_charset')){if(mysql_set_charset($Sa,$this->link))return
true;mysql_set_charset('utf8',$this->link);}return$this->query("SET NAMES $Sa");}function
quote($P){return"'".mysql_real_escape_string($P,$this->link)."'";}function
select_db($Ib){return
mysql_select_db($Ib,$this->link);}function
query($G,$yi=false){$H=@($yi?mysql_unbuffered_query($G,$this->link):mysql_query($G,$this->link));$this->error="";if(!$H){$this->errno=mysql_errno($this->link);$this->error=mysql_error($this->link);return
false;}if($H===true){$this->affected_rows=mysql_affected_rows($this->link);$this->info=mysql_info($this->link);return
true;}return
new
Result($H);}function
multi_query($G){return$this->result=$this->query($G);}function
store_result(){return$this->result;}function
next_result(){return
false;}function
result($G,$n=0){$H=$this->query($G);return($H?$H->fetch_column($n):false);}}class
Result{var$num_rows;private$result,$offset=0;function
__construct($H){$this->result=$H;$this->num_rows=mysql_num_rows($H);}function
fetch_assoc(){return
mysql_fetch_assoc($this->result);}function
fetch_row(){return
mysql_fetch_row($this->result);}function
fetch_column($n){return($this->num_rows?mysql_result($this->result,0,$n):false);}function
fetch_field(){$I=mysql_fetch_field($this->result,$this->offset++);$I->orgtable=$I->table;$I->orgname=$I->name;$I->charsetnr=($I->blob?63:0);return$I;}function
__destruct(){mysql_free_result($this->result);}}}elseif(extension_loaded("pdo_mysql")){class
Db
extends
PdoDb{var$extension="PDO_MySQL";function
connect($M,$V,$E){global$b;$vf=array(\PDO::MYSQL_ATTR_LOCAL_INFILE=>false);$zh=$b->connectSsl();if($zh){if($zh['key'])$vf[\PDO::MYSQL_ATTR_SSL_KEY]=$zh['key'];if($zh['cert'])$vf[\PDO::MYSQL_ATTR_SSL_CERT]=$zh['cert'];if($zh['ca'])$vf[\PDO::MYSQL_ATTR_SSL_CA]=$zh['ca'];if(isset($zh['verify']))$vf[\PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT]=$zh['verify'];}$this->dsn("mysql:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\d)~',';port=\1',$M)),$V,$E,$vf);return
true;}function
set_charset($Sa){$this->query("SET NAMES $Sa");}function
select_db($Ib){return$this->query("USE ".idf_escape($Ib));}function
query($G,$yi=false){$this->pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,!$yi);return
parent::query($G,$yi);}}}class
Driver
extends
SqlDriver{static$fg=array("MySQLi","MySQL","PDO_MySQL");static$be="sql";var$unsigned=array("unsigned","zerofill","unsigned zerofill");var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","REGEXP","IN","FIND_IN_SET","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL");var$functions=array("char_length","date","from_unixtime","lower","round","floor","ceil","sec_to_time","time_to_sec","upper");var$grouping=array("avg","count","count distinct","group_concat","max","min","sum");function
__construct($f){parent::__construct($f);$this->types=array('數字'=>array("tinyint"=>3,"smallint"=>5,"mediumint"=>8,"int"=>10,"bigint"=>20,"decimal"=>66,"float"=>12,"double"=>21),'日期時間'=>array("date"=>10,"datetime"=>19,"timestamp"=>19,"time"=>10,"year"=>4),'字串'=>array("char"=>255,"varchar"=>65535,"tinytext"=>255,"text"=>65535,"mediumtext"=>16777215,"longtext"=>4294967295),'列表'=>array("enum"=>65535,"set"=>64),'二進位'=>array("bit"=>20,"binary"=>255,"varbinary"=>65535,"tinyblob"=>255,"blob"=>65535,"mediumblob"=>16777215,"longblob"=>4294967295),'幾何'=>array("geometry"=>0,"point"=>0,"linestring"=>0,"polygon"=>0,"multipoint"=>0,"multilinestring"=>0,"multipolygon"=>0,"geometrycollection"=>0),);$this->editFunctions=array(array("char"=>"md5/sha1/password/encrypt/uuid","binary"=>"md5/sha1","date|time"=>"now",),array(number_type()=>"+/-","date"=>"+ interval/- interval","time"=>"addtime/subtime","char|text"=>"concat",));if(min_version('5.7.8',10.2,$f))$this->types['字串']["json"]=4294967295;if(min_version('',10.7,$f)){$this->types['字串']["uuid"]=128;$this->editFunctions[0]['uuid']='uuid';}if(min_version(9,'',$f)){$this->types['數字']["vector"]=16383;$this->editFunctions[0]['vector']='string_to_vector';}if(min_version(5.7,10.2,$f))$this->generated=array("STORED","VIRTUAL");}function
unconvertFunction($n){return(preg_match("~binary~",$n["type"])?"<code class='jush-sql'>UNHEX</code>":($n["type"]=="bit"?doc_link(array('sql'=>'bit-value-literals.html'),"<code>b''</code>"):(preg_match("~geometry|point|linestring|polygon~",$n["type"])?"<code class='jush-sql'>GeomFromText</code>":"")));}function
insert($Q,$N){return($N?parent::insert($Q,$N):queries("INSERT INTO ".table($Q)." ()\nVALUES ()"));}function
insertUpdate($Q,$K,$F){$e=array_keys(reset($K));$hg="INSERT INTO ".table($Q)." (".implode(", ",$e).") VALUES\n";$Qi=array();foreach($e
as$y)$Qi[$y]="$y = VALUES($y)";$Fh="\nON DUPLICATE KEY UPDATE ".implode(", ",$Qi);$Qi=array();$qe=0;foreach($K
as$N){$Y="(".implode(", ",$N).")";if($Qi&&(strlen($hg)+$qe+strlen($Y)+strlen($Fh)>1e6)){if(!queries($hg.implode(",\n",$Qi).$Fh))return
false;$Qi=array();$qe=0;}$Qi[]=$Y;$qe+=strlen($Y)+2;}return
queries($hg.implode(",\n",$Qi).$Fh);}function
slowQuery($G,$bi){if(min_version('5.7.8','10.1.2')){if($this->conn->maria)return"SET STATEMENT max_statement_time=$bi FOR $G";elseif(preg_match('~^(SELECT\b)(.+)~is',$G,$A))return"$A[1] /*+ MAX_EXECUTION_TIME(".($bi*1000).") */ $A[2]";}}function
convertSearch($v,$X,$n){return(preg_match('~char|text|enum|set~',$n["type"])&&!preg_match("~^utf8~",$n["collation"])&&preg_match('~[\x80-\xFF]~',$X['val'])?"CONVERT($v USING ".charset($this->conn).")":$v);}function
warnings(){$H=$this->conn->query("SHOW WARNINGS");if($H&&$H->num_rows){ob_start();select($H);return
ob_get_clean();}}function
tableHelp($B,$Zd=false){$xe=$this->conn->maria;if(information_schema(DB))return
strtolower("information-schema-".($xe?"$B-table/":str_replace("_","-",$B)."-table.html"));if(DB=="mysql")return($xe?"mysql$B-table/":"system-schema.html");}function
hasCStyleEscapes(){static$Oa;if($Oa===null){$xh=$this->conn->result("SHOW VARIABLES LIKE 'sql_mode'",1);$Oa=(strpos($xh,'NO_BACKSLASH_ESCAPES')===false);}return$Oa;}}function
idf_escape($v){return"`".str_replace("`","``",$v)."`";}function
table($v){return
idf_escape($v);}function
connect($Ab){global$Zb;$f=new
Db;if($f->connect($Ab[0],$Ab[1],$Ab[2])){$f->set_charset(charset($f));$f->query("SET sql_quote_show_create = 1, autocommit = 1");$f->maria=preg_match('~MariaDB~',$f->server_info);$Zb[DRIVER]=($f->maria?"MariaDB":"MySQL");return$f;}$I=$f->error;if(function_exists('iconv')&&!is_utf8($I)&&strlen($Qg=iconv("windows-1250","utf-8",$I))>strlen($I))$I=$Qg;return$I;}function
get_databases($Yc){$I=get_session("dbs");if($I===null){$G="SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME";$I=($Yc?slow_query($G):get_vals($G));restart_session();set_session("dbs",$I);stop_session();}return$I;}function
limit($G,$Z,$z,$C=0,$ch=" "){return" $G$Z".($z!==null?$ch."LIMIT $z".($C?" OFFSET $C":""):"");}function
limit1($Q,$G,$Z,$ch="\n"){return
limit($G,$Z,1,0,$ch);}function
db_collation($j,$gb){$I=null;$h=get_val("SHOW CREATE DATABASE ".idf_escape($j),1);if(preg_match('~ COLLATE ([^ ]+)~',$h,$A))$I=$A[1];elseif(preg_match('~ CHARACTER SET ([^ ]+)~',$h,$A))$I=$gb[$A[1]][-1];return$I;}function
engines(){$I=array();foreach(get_rows("SHOW ENGINES")as$J){if(preg_match("~YES|DEFAULT~",$J["Support"]))$I[]=$J["Engine"];}return$I;}function
logged_user(){return
get_val("SELECT USER()");}function
tables_list(){return
get_key_vals("SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME");}function
count_tables($i){$I=array();foreach($i
as$j)$I[$j]=count(get_vals("SHOW TABLES IN ".idf_escape($j)));return$I;}function
table_status($B="",$Mc=false){$I=array();foreach(get_rows($Mc?"SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ".($B!=""?"AND TABLE_NAME = ".q($B):"ORDER BY Name"):"SHOW TABLE STATUS".($B!=""?" LIKE ".q(addcslashes($B,"%_\\")):""))as$J){if($J["Engine"]=="InnoDB")$J["Comment"]=preg_replace('~(?:(.+); )?InnoDB free: .*~','\1',$J["Comment"]);if(!isset($J["Engine"]))$J["Comment"]="";if($B!=""){$J["Name"]=$B;return$J;}$I[$J["Name"]]=$J;}return$I;}function
is_view($R){return$R["Engine"]===null;}function
fk_support($R){return
preg_match('~InnoDB|IBMDB2I~i',$R["Engine"])||(preg_match('~NDB~i',$R["Engine"])&&min_version(5.6));}function
fields($Q){global$f;$xe=$f->maria;$I=array();foreach(get_rows("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ".q($Q)." ORDER BY ORDINAL_POSITION")as$J){$n=$J["COLUMN_NAME"];$U=$J["COLUMN_TYPE"];$kd=$J["GENERATION_EXPRESSION"];$Jc=$J["EXTRA"];preg_match('~^(VIRTUAL|PERSISTENT|STORED)~',$Jc,$jd);preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~',$U,$_e);$k=$J["COLUMN_DEFAULT"];if($k!=""){$Yd=preg_match('~text|json~',$_e[1]);if(!$xe&&$Yd)$k=preg_replace("~^(_\w+)?('.*')$~",'\2',stripslashes($k));if($xe||$Yd){$k=($k=="NULL"?null:preg_replace_callback("~^'(.*)'$~",function($A){return
stripslashes(str_replace("''","'",$A[1]));},$k));}if(!$xe&&preg_match('~binary~',$_e[1])&&preg_match('~^0x(\w*)$~',$k,$A))$k=pack("H*",$A[1]);}$I[$n]=array("field"=>$n,"full_type"=>$U,"type"=>$_e[1],"length"=>$_e[2],"unsigned"=>ltrim($_e[3].$_e[4]),"default"=>($jd?($xe?$kd:stripslashes($kd)):$k),"null"=>($J["IS_NULLABLE"]=="YES"),"auto_increment"=>($Jc=="auto_increment"),"on_update"=>(preg_match('~\bon update (\w+)~i',$Jc,$A)?$A[1]:""),"collation"=>$J["COLLATION_NAME"],"privileges"=>array_flip(explode(",","$J[PRIVILEGES],where,order")),"comment"=>$J["COLUMN_COMMENT"],"primary"=>($J["COLUMN_KEY"]=="PRI"),"generated"=>($jd[1]=="PERSISTENT"?"STORED":$jd[1]),);}return$I;}function
indexes($Q,$g=null){$I=array();foreach(get_rows("SHOW INDEX FROM ".table($Q),$g)as$J){$B=$J["Key_name"];$I[$B]["type"]=($B=="PRIMARY"?"PRIMARY":($J["Index_type"]=="FULLTEXT"?"FULLTEXT":($J["Non_unique"]?($J["Index_type"]=="SPATIAL"?"SPATIAL":"INDEX"):"UNIQUE")));$I[$B]["columns"][]=$J["Column_name"];$I[$B]["lengths"][]=($J["Index_type"]=="SPATIAL"?null:$J["Sub_part"]);$I[$B]["descs"][]=null;}return$I;}function
foreign_keys($Q){global$l;static$Xf='(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';$I=array();$zb=get_val("SHOW CREATE TABLE ".table($Q),1);if($zb){preg_match_all("~CONSTRAINT ($Xf) FOREIGN KEY ?\\(((?:$Xf,? ?)+)\\) REFERENCES ($Xf)(?:\\.($Xf))? \\(((?:$Xf,? ?)+)\\)(?: ON DELETE ($l->onActions))?(?: ON UPDATE ($l->onActions))?~",$zb,$Ae,PREG_SET_ORDER);foreach($Ae
as$A){preg_match_all("~$Xf~",$A[2],$rh);preg_match_all("~$Xf~",$A[5],$Th);$I[idf_unescape($A[1])]=array("db"=>idf_unescape($A[4]!=""?$A[3]:$A[4]),"table"=>idf_unescape($A[4]!=""?$A[4]:$A[3]),"source"=>array_map('Adminer\idf_unescape',$rh[0]),"target"=>array_map('Adminer\idf_unescape',$Th[0]),"on_delete"=>($A[6]?:"RESTRICT"),"on_update"=>($A[7]?:"RESTRICT"),);}}return$I;}function
view($B){return
array("select"=>preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU','',get_val("SHOW CREATE VIEW ".table($B),1)));}function
collations(){$I=array();foreach(get_rows("SHOW COLLATION")as$J){if($J["Default"])$I[$J["Charset"]][-1]=$J["Collation"];else$I[$J["Charset"]][]=$J["Collation"];}ksort($I);foreach($I
as$y=>$X)asort($I[$y]);return$I;}function
information_schema($j){return($j=="information_schema")||(min_version(5.5)&&$j=="performance_schema");}function
error(){global$f;return
h(preg_replace('~^You have an error.*syntax to use~U',"Syntax error",$f->error));}function
create_database($j,$fb){return
queries("CREATE DATABASE ".idf_escape($j).($fb?" COLLATE ".q($fb):""));}function
drop_databases($i){$I=apply_queries("DROP DATABASE",$i,'Adminer\idf_escape');restart_session();set_session("dbs",null);return$I;}function
rename_database($B,$fb){$I=false;if(create_database($B,$fb)){$S=array();$Vi=array();foreach(tables_list()as$Q=>$U){if($U=='VIEW')$Vi[]=$Q;else$S[]=$Q;}$I=(!$S&&!$Vi)||move_tables($S,$Vi,$B);drop_databases($I?array(DB):array());}return$I;}function
auto_increment(){$Aa=" PRIMARY KEY";if($_GET["create"]!=""&&$_POST["auto_increment_col"]){foreach(indexes($_GET["create"])as$w){if(in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"],$w["columns"],true)){$Aa="";break;}if($w["type"]=="PRIMARY")$Aa=" UNIQUE";}}return" AUTO_INCREMENT$Aa";}function
alter_table($Q,$B,$o,$ad,$lb,$qc,$fb,$_a,$Tf){global$f;$c=array();foreach($o
as$n){if($n[1]){$k=$n[1][3];if(preg_match('~ GENERATED~',$k)){$n[1][3]=($f->maria?"":$n[1][2]);$n[1][2]=$k;}$c[]=($Q!=""?($n[0]!=""?"CHANGE ".idf_escape($n[0]):"ADD"):" ")." ".implode($n[1]).($Q!=""?$n[2]:"");}else$c[]="DROP ".idf_escape($n[0]);}$c=array_merge($c,$ad);$O=($lb!==null?" COMMENT=".q($lb):"").($qc?" ENGINE=".q($qc):"").($fb?" COLLATE ".q($fb):"").($_a!=""?" AUTO_INCREMENT=$_a":"");if($Q=="")return
queries("CREATE TABLE ".table($B)." (\n".implode(",\n",$c)."\n)$O$Tf");if($Q!=$B)$c[]="RENAME TO ".table($B);if($O)$c[]=ltrim($O);return($c||$Tf?queries("ALTER TABLE ".table($Q)."\n".implode(",\n",$c).$Tf):true);}function
alter_indexes($Q,$c){foreach($c
as$y=>$X)$c[$y]=($X[2]=="DROP"?"\nDROP INDEX ".idf_escape($X[1]):"\nADD $X[0] ".($X[0]=="PRIMARY"?"KEY ":"").($X[1]!=""?idf_escape($X[1])." ":"")."(".implode(", ",$X[2]).")");return
queries("ALTER TABLE ".table($Q).implode(",",$c));}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($Vi){return
queries("DROP VIEW ".implode(", ",array_map('Adminer\table',$Vi)));}function
drop_tables($S){return
queries("DROP TABLE ".implode(", ",array_map('Adminer\table',$S)));}function
move_tables($S,$Vi,$Th){global$f;$Eg=array();foreach($S
as$Q)$Eg[]=table($Q)." TO ".idf_escape($Th).".".table($Q);if(!$Eg||queries("RENAME TABLE ".implode(", ",$Eg))){$Pb=array();foreach($Vi
as$Q)$Pb[table($Q)]=view($Q);$f->select_db($Th);$j=idf_escape(DB);foreach($Pb
as$B=>$Ui){if(!queries("CREATE VIEW $B AS ".str_replace(" $j."," ",$Ui["select"]))||!queries("DROP VIEW $j.$B"))return
false;}return
true;}return
false;}function
copy_tables($S,$Vi,$Th){queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");foreach($S
as$Q){$B=($Th==DB?table("copy_$Q"):idf_escape($Th).".".table($Q));if(($_POST["overwrite"]&&!queries("\nDROP TABLE IF EXISTS $B"))||!queries("CREATE TABLE $B LIKE ".table($Q))||!queries("INSERT INTO $B SELECT * FROM ".table($Q)))return
false;foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")))as$J){$ri=$J["Trigger"];if(!queries("CREATE TRIGGER ".($Th==DB?idf_escape("copy_$ri"):idf_escape($Th).".".idf_escape($ri))." $J[Timing] $J[Event] ON $B FOR EACH ROW\n$J[Statement];"))return
false;}}foreach($Vi
as$Q){$B=($Th==DB?table("copy_$Q"):idf_escape($Th).".".table($Q));$Ui=view($Q);if(($_POST["overwrite"]&&!queries("DROP VIEW IF EXISTS $B"))||!queries("CREATE VIEW $B AS $Ui[select]"))return
false;}return
true;}function
trigger($B){if($B=="")return
array();$K=get_rows("SHOW TRIGGERS WHERE `Trigger` = ".q($B));return
reset($K);}function
triggers($Q){$I=array();foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")))as$J)$I[$J["Trigger"]]=array($J["Timing"],$J["Event"]);return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
routine($B,$U){global$l;$ta=array("bool","boolean","integer","double precision","real","dec","numeric","fixed","national char","national varchar");$sh="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$sc=$l->enumLength;$wi="((".implode("|",array_merge(array_keys($l->types()),$ta)).")\\b(?:\\s*\\(((?:[^'\")]|$sc)++)\\))?"."\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";$Xf="$sh*(".($U=="FUNCTION"?"":$l->inout).")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$wi";$h=get_val("SHOW CREATE $U ".idf_escape($B),2);preg_match("~\\(((?:$Xf\\s*,?)*)\\)\\s*".($U=="FUNCTION"?"RETURNS\\s+$wi\\s+":"")."(.*)~is",$h,$A);$o=array();preg_match_all("~$Xf\\s*,?~is",$A[1],$Ae,PREG_SET_ORDER);foreach($Ae
as$Nf)$o[]=array("field"=>str_replace("``","`",$Nf[2]).$Nf[3],"type"=>strtolower($Nf[5]),"length"=>preg_replace_callback("~$sc~s",'Adminer\normalize_enum',$Nf[6]),"unsigned"=>strtolower(preg_replace('~\s+~',' ',trim("$Nf[8] $Nf[7]"))),"null"=>1,"full_type"=>$Nf[4],"inout"=>strtoupper($Nf[1]),"collation"=>strtolower($Nf[9]),);return
array("fields"=>$o,"comment"=>get_val("SELECT ROUTINE_COMMENT FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = DATABASE() AND ROUTINE_NAME = ".q($B)),)+($U!="FUNCTION"?array("definition"=>$A[11]):array("returns"=>array("type"=>$A[12],"length"=>$A[13],"unsigned"=>$A[15],"collation"=>$A[16]),"definition"=>$A[17],"language"=>"SQL",));}function
routines(){return
get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = DATABASE()");}function
routine_languages(){return
array();}function
routine_id($B,$J){return
idf_escape($B);}function
last_id(){return
get_val("SELECT LAST_INSERT_ID()");}function
explain($f,$G){return$f->query("EXPLAIN ".(min_version(5.1)&&!min_version(5.7)?"PARTITIONS ":"").$G);}function
found_rows($R,$Z){return($Z||$R["Engine"]!="InnoDB"?null:$R["Rows"]);}function
create_sql($Q,$_a,$Dh){$I=get_val("SHOW CREATE TABLE ".table($Q),1);if(!$_a)$I=preg_replace('~ AUTO_INCREMENT=\d+~','',$I);return$I;}function
truncate_sql($Q){return"TRUNCATE ".table($Q);}function
use_sql($Ib){return"USE ".idf_escape($Ib);}function
trigger_sql($Q){$I="";foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")),null,"-- ")as$J)$I.="\nCREATE TRIGGER ".idf_escape($J["Trigger"])." $J[Timing] $J[Event] ON ".table($J["Table"])." FOR EACH ROW\n$J[Statement];;\n";return$I;}function
show_variables(){return
get_key_vals("SHOW VARIABLES");}function
process_list(){return
get_rows("SHOW FULL PROCESSLIST");}function
show_status(){return
get_key_vals("SHOW STATUS");}function
convert_field($n){if(preg_match("~binary~",$n["type"]))return"HEX(".idf_escape($n["field"]).")";if($n["type"]=="bit")return"BIN(".idf_escape($n["field"])." + 0)";if(preg_match("~geometry|point|linestring|polygon~",$n["type"]))return(min_version(8)?"ST_":"")."AsWKT(".idf_escape($n["field"]).")";}function
unconvert_field($n,$I){if(preg_match("~binary~",$n["type"]))$I="UNHEX($I)";if($n["type"]=="bit")$I="CONVERT(b$I, UNSIGNED)";if(preg_match("~geometry|point|linestring|polygon~",$n["type"])){$hg=(min_version(8)?"ST_":"");$I=$hg."GeomFromText($I, $hg"."SRID($n[field]))";}return$I;}function
support($Nc){return!preg_match("~scheme|sequence|type|view_trigger|materializedview".(min_version(8)?"":"|descidx".(min_version(5.1)?"":"|event|partitioning")).(min_version('8.0.16','10.2.1')?"":"|check")."~",$Nc);}function
kill_process($X){return
queries("KILL ".number($X));}function
connection_id(){return"SELECT CONNECTION_ID()";}function
max_connections(){return
get_val("SELECT @@max_connections");}}define('Adminer\JUSH',Driver::$be);define('Adminer\SERVER',$_GET[DRIVER]);define('Adminer\DB',$_GET["db"]);define('Adminer\ME',preg_replace('~\?.*~','',relative_uri()).'?'.(sid()?SID.'&':'').(SERVER!==null?DRIVER."=".urlencode(SERVER).'&':'').(isset($_GET["username"])?"username=".urlencode($_GET["username"]).'&':'').(DB!=""?'db='.urlencode(DB).'&'.(isset($_GET["ns"])?"ns=".urlencode($_GET["ns"])."&":""):''));if(!ob_get_level())ob_start(null,4096);function
page_header($di,$m="",$La=array(),$ei=""){global$ca,$ia,$b,$Zb;page_headers();if(is_ajax()&&$m){page_messages($m);exit;}$fi=$di.($ei!=""?": $ei":"");$gi=strip_tags($fi.(SERVER!=""&&SERVER!="localhost"?h(" - ".SERVER):"")." - ".$b->name());echo'<!DOCTYPE html>
<html lang="zh-tw" dir="ltr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width">
<title>',$gi,'</title>
<link rel="stylesheet" href="',h(preg_replace("~\\?.*~","",ME)."?file=default.css&version=5.0.6"),'">
';$Cb=$b->css();$Fb=(count($Cb)==1?!!preg_match('~-dark~',$Cb[0]):null);if($Fb!==false)echo"<link rel='stylesheet'".($Fb?"":" media='(prefers-color-scheme: dark)'")." href='".h(preg_replace("~\\?.*~","",ME)."?file=dark.css&version=5.0.6")."'>\n";echo"<meta name='color-scheme' content='".($Fb===null?"light dark":($Fb?"dark":"light"))."'>\n",script_src(preg_replace("~\\?.*~","",ME)."?file=functions.js&version=5.0.6");if($b->head($Fb))echo"<link rel='shortcut icon' type='image/x-icon' href='".h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=5.0.6")."'>\n","<link rel='apple-touch-icon' href='".h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=5.0.6")."'>\n";foreach($Cb
as$X)echo"<link rel='stylesheet'".(preg_match('~-dark~',$X)&&!$Fb?" media='(prefers-color-scheme: dark)'":"")." href='".h($X)."'>\n";echo"\n<body class='".'ltr'." nojs'>\n";$p=get_temp_dir()."/adminer.version";if(!$_COOKIE["adminer_version"]&&function_exists('openssl_verify')&&file_exists($p)&&filemtime($p)+86400>time()){$Ti=unserialize(file_get_contents($p));$qg="-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";if(openssl_verify($Ti["version"],base64_decode($Ti["signature"]),$qg)==1)$_COOKIE["adminer_version"]=$Ti["version"];}echo
script("mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick".(isset($_COOKIE["adminer_version"])?"":", onload: partial(verifyVersion, '$ia', '".js_escape(ME)."', '".get_token()."')")."});
document.body.className = document.body.className.replace(/ nojs/, ' js');
var offlineMessage = '".js_escape('您離線了。')."';
var thousandsSeparator = '".js_escape(',')."';"),"<div id='help' class='jush-".JUSH." jsonly hidden'></div>\n",script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"),"<div id='content'>\n";if($La!==null){$_=substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1);echo'<p id="breadcrumb"><a href="'.h($_?:".").'">'.$Zb[DRIVER].'</a> » ';$_=substr(preg_replace('~\b(db|ns)=[^&]*&~','',ME),0,-1);$M=$b->serverName(SERVER);$M=($M!=""?$M:'伺服器');if($La===false)echo"$M\n";else{echo"<a href='".h($_)."' accesskey='1' title='Alt+Shift+1'>$M</a> » ";if($_GET["ns"]!=""||(DB!=""&&is_array($La)))echo'<a href="'.h($_."&db=".urlencode(DB).(support("scheme")?"&ns=":"")).'">'.h(DB).'</a> » ';if(is_array($La)){if($_GET["ns"]!="")echo'<a href="'.h(substr(ME,0,-1)).'">'.h($_GET["ns"]).'</a> » ';foreach($La
as$y=>$X){$Rb=(is_array($X)?$X[1]:h($X));if($Rb!="")echo"<a href='".h(ME."$y=").urlencode(is_array($X)?$X[0]:$X)."'>$Rb</a> » ";}}echo"$di\n";}}echo"<h2>$fi</h2>\n","<div id='ajaxstatus' class='jsonly hidden'></div>\n";restart_session();page_messages($m);$i=&get_session("dbs");if(DB!=""&&$i&&!in_array(DB,$i,true))$i=null;stop_session();define('Adminer\PAGE_HEADER',1);}function
page_headers(){global$b;header("Content-Type: text/html; charset=utf-8");header("Cache-Control: no-cache");header("X-Frame-Options: deny");header("X-XSS-Protection: 0");header("X-Content-Type-Options: nosniff");header("Referrer-Policy: origin-when-cross-origin");foreach($b->csp()as$Bb){$xd=array();foreach($Bb
as$y=>$X)$xd[]="$y $X";header("Content-Security-Policy: ".implode("; ",$xd));}$b->headers();}function
csp(){return
array(array("script-src"=>"'self' 'unsafe-inline' 'nonce-".get_nonce()."' 'strict-dynamic'","connect-src"=>"'self'","frame-src"=>"https://www.adminer.org","object-src"=>"'none'","base-uri"=>"'none'","form-action"=>"'self'",),);}function
get_nonce(){static$af;if(!$af)$af=base64_encode(rand_string());return$af;}function
page_messages($m){$Gi=preg_replace('~^[^?]*~','',$_SERVER["REQUEST_URI"]);$Ne=$_SESSION["messages"][$Gi];if($Ne){echo"<div class='message'>".implode("</div>\n<div class='message'>",$Ne)."</div>".script("messagesPrint();");unset($_SESSION["messages"][$Gi]);}if($m)echo"<div class='error'>$m</div>\n";}function
page_footer($Pe=""){global$b,$T;echo'</div>

<div id="menu">
';$b->navigation($Pe);echo'</div>

';if($Pe!="auth")echo'<form action="" method="post">
<p class="logout">
<span>',h($_GET["username"])."\n",'</span>
<input type="submit" name="logout" value="登出" id="logout">
<input type="hidden" name="token" value="',$T,'">
</p>
</form>
';echo
script("setupSubmitHighlight(document);");}function
int32($Te){while($Te>=2147483648)$Te-=4294967296;while($Te<=-2147483649)$Te+=4294967296;return(int)$Te;}function
long2str($W,$Xi){$Qg='';foreach($W
as$X)$Qg.=pack('V',$X);if($Xi)return
substr($Qg,0,end($W));return$Qg;}function
str2long($Qg,$Xi){$W=array_values(unpack('V*',str_pad($Qg,4*ceil(strlen($Qg)/4),"\0")));if($Xi)$W[]=strlen($Qg);return$W;}function
xxtea_mx($ej,$dj,$Gh,$ce){return
int32((($ej>>5&0x7FFFFFF)^$dj<<2)+(($dj>>3&0x1FFFFFFF)^$ej<<4))^int32(($Gh^$dj)+($ce^$ej));}function
encrypt_string($Bh,$y){if($Bh=="")return"";$y=array_values(unpack("V*",pack("H*",md5($y))));$W=str2long($Bh,true);$Te=count($W)-1;$ej=$W[$Te];$dj=$W[0];$rg=floor(6+52/($Te+1));$Gh=0;while($rg-->0){$Gh=int32($Gh+0x9E3779B9);$hc=$Gh>>2&3;for($Lf=0;$Lf<$Te;$Lf++){$dj=$W[$Lf+1];$Se=xxtea_mx($ej,$dj,$Gh,$y[$Lf&3^$hc]);$ej=int32($W[$Lf]+$Se);$W[$Lf]=$ej;}$dj=$W[0];$Se=xxtea_mx($ej,$dj,$Gh,$y[$Lf&3^$hc]);$ej=int32($W[$Te]+$Se);$W[$Te]=$ej;}return
long2str($W,false);}function
decrypt_string($Bh,$y){if($Bh=="")return"";if(!$y)return
false;$y=array_values(unpack("V*",pack("H*",md5($y))));$W=str2long($Bh,false);$Te=count($W)-1;$ej=$W[$Te];$dj=$W[0];$rg=floor(6+52/($Te+1));$Gh=int32($rg*0x9E3779B9);while($Gh){$hc=$Gh>>2&3;for($Lf=$Te;$Lf>0;$Lf--){$ej=$W[$Lf-1];$Se=xxtea_mx($ej,$dj,$Gh,$y[$Lf&3^$hc]);$dj=int32($W[$Lf]-$Se);$W[$Lf]=$dj;}$ej=$W[$Te];$Se=xxtea_mx($ej,$dj,$Gh,$y[$Lf&3^$hc]);$dj=int32($W[0]-$Se);$W[0]=$dj;$Gh=int32($Gh-0x9E3779B9);}return
long2str($W,true);}$f='';$wd=$_SESSION["token"];if(!$wd)$_SESSION["token"]=rand(1,1e6);$T=get_token();$Zf=array();if($_COOKIE["adminer_permanent"]){foreach(explode(" ",$_COOKIE["adminer_permanent"])as$X){list($y)=explode(":",$X);$Zf[$y]=$X;}}function
add_invalid_login(){global$b;$Fa=get_temp_dir()."/adminer.invalid";foreach(glob("$Fa*")?:array($Fa)as$p){$r=file_open_lock($p);if($r)break;}if(!$r)$r=file_open_lock("$Fa-".rand_string());if(!$r)return;$Ud=unserialize(stream_get_contents($r));$ai=time();if($Ud){foreach($Ud
as$Vd=>$X){if($X[0]<$ai)unset($Ud[$Vd]);}}$Td=&$Ud[$b->bruteForceKey()];if(!$Td)$Td=array($ai+30*60,0);$Td[1]++;file_write_unlock($r,serialize($Ud));}function
check_invalid_login(){global$b;$Ud=array();foreach(glob(get_temp_dir()."/adminer.invalid*")as$p){$r=file_open_lock($p);if($r){$Ud=unserialize(stream_get_contents($r));file_unlock($r);break;}}$Td=($Ud?$Ud[$b->bruteForceKey()]:array());$Ze=($Td[1]>29?$Td[0]-time():0);if($Ze>0)auth_error(sprintf('登錄失敗次數過多，請 %d 分鐘後重試。',ceil($Ze/60)));}$za=$_POST["auth"];if($za){session_regenerate_id();$Si=$za["driver"];$M=$za["server"];$V=$za["username"];$E=(string)$za["password"];$j=$za["db"];set_password($Si,$M,$V,$E);$_SESSION["db"][$Si][$M][$V][$j]=true;if($za["permanent"]){$y=implode("-",array_map('base64_encode',array($Si,$M,$V,$j)));$lg=$b->permanentLogin(true);$Zf[$y]="$y:".base64_encode($lg?encrypt_string($E,$lg):"");cookie("adminer_permanent",implode(" ",$Zf));}if(count($_POST)==1||DRIVER!=$Si||SERVER!=$M||$_GET["username"]!==$V||DB!=$j)redirect(auth_url($Si,$M,$V,$j));}elseif($_POST["logout"]&&(!$wd||verify_token())){foreach(array("pwds","db","dbs","queries")as$y)set_session($y,null);unset_permanent();redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1),'成功登出。'.' '.'感謝使用Adminer，請考慮為我們<a href="https://www.adminer.org/en/donation/">捐款（英文網頁）</a>。');}elseif($Zf&&!$_SESSION["pwds"]){session_regenerate_id();$lg=$b->permanentLogin();foreach($Zf
as$y=>$X){list(,$Za)=explode(":",$X);list($Si,$M,$V,$j)=array_map('base64_decode',explode("-",$y));set_password($Si,$M,$V,decrypt_string(base64_decode($Za),$lg));$_SESSION["db"][$Si][$M][$V][$j]=true;}}function
unset_permanent(){global$Zf;foreach($Zf
as$y=>$X){list($Si,$M,$V,$j)=array_map('base64_decode',explode("-",$y));if($Si==DRIVER&&$M==SERVER&&$V==$_GET["username"]&&$j==DB)unset($Zf[$y]);}cookie("adminer_permanent",implode(" ",$Zf));}function
auth_error($m){global$b,$wd;$ih=session_name();if(isset($_GET["username"])){header("HTTP/1.1 403 Forbidden");if(($_COOKIE[$ih]||$_GET[$ih])&&!$wd)$m='Session 已過期，請重新登入。';else{restart_session();add_invalid_login();$E=get_password();if($E!==null){if($E===false)$m.=($m?'<br>':'').sprintf('主密碼已過期。<a href="https://www.adminer.org/en/extension/"%s>請擴展</a> %s 方法讓它永久化。',target_blank(),'<code>permanentLogin()</code>');set_password(DRIVER,SERVER,$_GET["username"],null);}unset_permanent();}}if(!$_COOKIE[$ih]&&$_GET[$ih]&&ini_bool("session.use_only_cookies"))$m='Session 必須被啟用。';$Of=session_get_cookie_params();cookie("adminer_key",($_COOKIE["adminer_key"]?:rand_string()),$Of["lifetime"]);page_header('登入',$m,null);echo"<form action='' method='post'>\n","<div>";if(hidden_fields($_POST,array("auth")))echo"<p class='message'>".'此操作將在成功使用相同的憑據登錄後執行。'."\n";echo"</div>\n";$b->loginForm();echo"</form>\n";page_footer("auth");exit;}if(isset($_GET["username"])&&!class_exists('Adminer\Db')){unset($_SESSION["pwds"][DRIVER]);unset_permanent();page_header('無擴充模組',sprintf('沒有任何支援的 PHP 擴充模組（%s）。',implode(", ",Driver::$fg)),false);page_footer("auth");exit;}stop_session(true);if(isset($_GET["username"])&&is_string(get_password())){list($Ad,$bg)=explode(":",SERVER,2);if(preg_match('~^\s*([-+]?\d+)~',$bg,$A)&&($A[1]<1024||$A[1]>65535))auth_error('不允許連接到特權埠。');check_invalid_login();$f=connect($b->credentials());if(is_object($f)){$l=new
Driver($f);if($b->operators===null)$b->operators=$l->operators;if(isset($f->maria)||$f->cockroach)save_settings(array("vendor-".SERVER=>$Zb[DRIVER]));}}$ve=null;if(!is_object($f)||($ve=$b->login($_GET["username"],get_password()))!==true){$m=(is_string($f)?nl_br(h($f)):(is_string($ve)?$ve:'無效的憑證。'));auth_error($m.(preg_match('~^ | $~',get_password())?'<br>'.'您輸入的密碼中有一個空格，這可能是導致問題的原因。':''));}if($_POST["logout"]&&$wd&&!verify_token()){page_header('登出','無效的 CSRF token。請重新發送表單。');page_footer("db");exit;}if($za&&$_POST["token"])$_POST["token"]=$T;$m='';if($_POST){if(!verify_token()){$Od="max_input_vars";$Ge=ini_get($Od);if(extension_loaded("suhosin")){foreach(array("suhosin.request.max_vars","suhosin.post.max_vars")as$y){$X=ini_get($y);if($X&&(!$Ge||$X<$Ge)){$Od=$y;$Ge=$X;}}}$m=(!$_POST["token"]&&$Ge?sprintf('超過允許的字段數量的最大值。請增加 %s。',"'$Od'"):'無效的 CSRF token。請重新發送表單。'.' '.'如果您並沒有從Adminer發送請求，請關閉此頁面。');}}elseif($_SERVER["REQUEST_METHOD"]=="POST"){$m=sprintf('POST 資料太大。減少資料或者增加 %s 的設定值。',"'post_max_size'");if(isset($_GET["sql"]))$m.=' '.'您可以通過FTP上傳大型SQL檔並從伺服器導入。';}function
select($H,$g=null,$Af=array(),$z=0){$te=array();$x=array();$e=array();$Ja=array();$xi=array();$I=array();for($t=0;(!$z||$t<$z)&&($J=$H->fetch_row());$t++){if(!$t){echo"<div class='scrollable'>\n","<table class='nowrap odds'>\n","<thead><tr>";for($ae=0;$ae<count($J);$ae++){$n=$H->fetch_field();$B=$n->name;$_f=$n->orgtable;$zf=$n->orgname;$I[$n->table]=$_f;if($Af&&JUSH=="sql")$te[$ae]=($B=="table"?"table=":($B=="possible_keys"?"indexes=":null));elseif($_f!=""){if(!isset($x[$_f])){$x[$_f]=array();foreach(indexes($_f,$g)as$w){if($w["type"]=="PRIMARY"){$x[$_f]=array_flip($w["columns"]);break;}}$e[$_f]=$x[$_f];}if(isset($e[$_f][$zf])){unset($e[$_f][$zf]);$x[$_f][$zf]=$ae;$te[$ae]=$_f;}}if($n->charsetnr==63)$Ja[$ae]=true;$xi[$ae]=$n->type;echo"<th".($_f!=""||$n->name!=$zf?" title='".h(($_f!=""?"$_f.":"").$zf)."'":"").">".h($B).($Af?doc_link(array('sql'=>"explain-output.html#explain_".strtolower($B),'mariadb'=>"explain/#the-columns-in-explain-select",)):"");}echo"</thead>\n";}echo"<tr>";foreach($J
as$y=>$X){$_="";if(isset($te[$y])&&!$e[$te[$y]]){if($Af&&JUSH=="sql"){$Q=$J[array_search("table=",$te)];$_=ME.$te[$y].urlencode($Af[$Q]!=""?$Af[$Q]:$Q);}else{$_=ME."edit=".urlencode($te[$y]);foreach($x[$te[$y]]as$db=>$ae)$_.="&where".urlencode("[".bracket_escape($db)."]")."=".urlencode($J[$ae]);}}elseif(is_url($X))$_=$X;if($X===null)$X="<i>NULL</i>";elseif($Ja[$y]&&!is_utf8($X))$X="<i>".sprintf('%d byte(s)',strlen($X))."</i>";else{$X=h($X);if($xi[$y]==254)$X="<code>$X</code>";}if($_)$X="<a href='".h($_)."'".(is_url($_)?target_blank():'').">$X</a>";echo"<td".($xi[$y]<=9||$xi[$y]==246?" class='number'":"").">$X";}}echo($t?"</table>\n</div>":"<p class='message'>".'沒有資料行。')."\n";return$I;}function
referencable_primary($ah){$I=array();foreach(table_status('',true)as$Lh=>$Q){if($Lh!=$ah&&fk_support($Q)){foreach(fields($Lh)as$n){if($n["primary"]){if($I[$Lh]){unset($I[$Lh]);break;}$I[$Lh]=$n;}}}}return$I;}function
textarea($B,$Y,$K=10,$hb=80){echo"<textarea name='".h($B)."' rows='$K' cols='$hb' class='sqlarea jush-".JUSH."' spellcheck='false' wrap='off'>";if(is_array($Y)){foreach($Y
as$X)echo
h($X[0])."\n\n\n";}else
echo
h($Y);echo"</textarea>";}function
select_input($ya,$vf,$Y="",$pf="",$ag=""){$Sh=($vf?"select":"input");return"<$Sh$ya".($vf?"><option value=''>$ag".optionlist($vf,$Y,true)."</select>":" size='10' value='".h($Y)."' placeholder='$ag'>").($pf?script("qsl('$Sh').onchange = $pf;",""):"");}function
json_row($y,$X=null){static$Tc=true;if($Tc)echo"{";if($y!=""){echo($Tc?"":",")."\n\t\"".addcslashes($y,"\r\n\t\"\\/").'": '.($X!==null?'"'.addcslashes($X,"\r\n\"\\/").'"':'null');$Tc=false;}else{echo"\n}\n";$Tc=true;}}function
edit_type($y,$n,$gb,$cd=array(),$Kc=array()){global$l;$U=$n["type"];echo"<td><select name='".h($y)."[type]' class='type' aria-labelledby='label-type'>";if($U&&!array_key_exists($U,$l->types())&&!isset($cd[$U])&&!in_array($U,$Kc))$Kc[]=$U;$Ch=$l->structuredTypes();if($cd)$Ch['外來鍵']=$cd;echo
optionlist(array_merge($Kc,$Ch),$U),"</select><td>","<input name='".h($y)."[length]' value='".h($n["length"])."' size='3'".(!$n["length"]&&preg_match('~var(char|binary)$~',$U)?" class='required'":"")." aria-labelledby='label-length'>","<td class='options'>",($gb?"<input list='collations' name='".h($y)."[collation]'".(preg_match('~(char|text|enum|set)$~',$U)?"":" class='hidden'")." value='".h($n["collation"])."' placeholder='(".'校對'.")'>":''),($l->unsigned?"<select name='".h($y)."[unsigned]'".(!$U||preg_match(number_type(),$U)?"":" class='hidden'").'><option>'.optionlist($l->unsigned,$n["unsigned"]).'</select>':''),(isset($n['on_update'])?"<select name='".h($y)."[on_update]'".(preg_match('~timestamp|datetime~',$U)?"":" class='hidden'").'>'.optionlist(array(""=>"(".'ON UPDATE'.")","CURRENT_TIMESTAMP"),(preg_match('~^CURRENT_TIMESTAMP~i',$n["on_update"])?"CURRENT_TIMESTAMP":$n["on_update"])).'</select>':''),($cd?"<select name='".h($y)."[on_delete]'".(preg_match("~`~",$U)?"":" class='hidden'")."><option value=''>(".'ON DELETE'.")".optionlist(explode("|",$l->onActions),$n["on_delete"])."</select> ":" ");}function
get_partitions_info($Q){global$f;$gd="FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = ".q(DB)." AND TABLE_NAME = ".q($Q);$H=$f->query("SELECT PARTITION_METHOD, PARTITION_EXPRESSION, PARTITION_ORDINAL_POSITION $gd ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");$I=array();list($I["partition_by"],$I["partition"],$I["partitions"])=$H->fetch_row();$Uf=get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $gd AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");$I["partition_names"]=array_keys($Uf);$I["partition_values"]=array_values($Uf);return$I;}function
process_length($qe){global$l;$uc=$l->enumLength;return(preg_match("~^\\s*\\(?\\s*$uc(?:\\s*,\\s*$uc)*+\\s*\\)?\\s*\$~",$qe)&&preg_match_all("~$uc~",$qe,$Ae)?"(".implode(",",$Ae[0]).")":preg_replace('~^[0-9].*~','(\0)',preg_replace('~[^-0-9,+()[\]]~','',$qe)));}function
process_type($n,$eb="COLLATE"){global$l;return" $n[type]".process_length($n["length"]).(preg_match(number_type(),$n["type"])&&in_array($n["unsigned"],$l->unsigned)?" $n[unsigned]":"").(preg_match('~char|text|enum|set~',$n["type"])&&$n["collation"]?" $eb ".(JUSH=="mssql"?$n["collation"]:q($n["collation"])):"");}function
process_field($n,$vi){if($n["on_update"])$n["on_update"]=str_ireplace("current_timestamp()","CURRENT_TIMESTAMP",$n["on_update"]);return
array(idf_escape(trim($n["field"])),process_type($vi),($n["null"]?" NULL":" NOT NULL"),default_value($n),(preg_match('~timestamp|datetime~',$n["type"])&&$n["on_update"]?" ON UPDATE $n[on_update]":""),(support("comment")&&$n["comment"]!=""?" COMMENT ".q($n["comment"]):""),($n["auto_increment"]?auto_increment():null),);}function
default_value($n){global$l;$k=$n["default"];$jd=$n["generated"];return($k===null?"":(in_array($jd,$l->generated)?(JUSH=="mssql"?" AS ($k)".($jd=="VIRTUAL"?"":" $jd")."":" GENERATED ALWAYS AS ($k) $jd"):" DEFAULT ".(!preg_match('~^GENERATED ~i',$k)&&(preg_match('~char|binary|text|json|enum|set~',$n["type"])||preg_match('~^(?![a-z])~i',$k))?(JUSH=="sql"&&preg_match('~text|json~',$n["type"])?"(".q($k).")":q($k)):str_ireplace("current_timestamp()","CURRENT_TIMESTAMP",(JUSH=="sqlite"?"($k)":$k)))));}function
type_class($U){foreach(array('char'=>'text','date'=>'time|year','binary'=>'blob','enum'=>'set',)as$y=>$X){if(preg_match("~$y|$X~",$U))return" class='$y'";}}function
edit_fields($o,$gb,$U="TABLE",$cd=array()){global$l;$o=array_values($o);$Nb=(($_POST?$_POST["defaults"]:get_setting("defaults"))?"":" class='hidden'");$mb=(($_POST?$_POST["comments"]:get_setting("comments"))?"":" class='hidden'");echo'<thead><tr>
',($U=="PROCEDURE"?"<td>":""),'<th id="label-name">',($U=="TABLE"?'欄位名稱':'參數名稱'),'<td id="label-type">類型<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>',script("qs('#enum-edit').onblur = editingLengthBlur;"),'<td id="label-length">長度
<td>','選項';if($U=="TABLE")echo"<td id='label-null'>NULL\n","<td><input type='radio' name='auto_increment_col' value=''><abbr id='label-ai' title='".'自動遞增'."'>AI</abbr>",doc_link(array('sql'=>"example-auto-increment.html",'mariadb'=>"auto_increment/",'sqlite'=>"autoinc.html",'pgsql'=>"datatype-numeric.html#DATATYPE-SERIAL",'mssql'=>"t-sql/statements/create-table-transact-sql-identity-property",)),"<td id='label-default'$Nb>".'預設值',(support("comment")?"<td id='label-comment'$mb>".'註解':"");echo"<td><input type='image' class='icon' name='add[".(support("move_col")?0:count($o))."]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=5.0.6")."' alt='+' title='".'新增下一筆'."'>".script("row_count = ".count($o).";"),"</thead>\n<tbody>\n",script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");foreach($o
as$t=>$n){$t++;$Bf=$n[($_POST?"orig":"field")];$Wb=(isset($_POST["add"][$t-1])||(isset($n["field"])&&!$_POST["drop_col"][$t]))&&(support("drop_col")||$Bf=="");echo"<tr".($Wb?"":" style='display: none;'").">\n",($U=="PROCEDURE"?"<td>".html_select("fields[$t][inout]",explode("|",$l->inout),$n["inout"]):"")."<th>";if($Wb)echo"<input name='fields[$t][field]' value='".h($n["field"])."' data-maxlength='64' autocapitalize='off' aria-labelledby='label-name'>\n";echo"<input type='hidden' name='fields[$t][orig]' value='".h($Bf)."'>";edit_type("fields[$t]",$n,$gb,$cd);if($U=="TABLE")echo"<td>".checkbox("fields[$t][null]",1,$n["null"],"","","block","label-null"),"<td><label class='block'><input type='radio' name='auto_increment_col' value='$t'".($n["auto_increment"]?" checked":"")." aria-labelledby='label-ai'></label>","<td$Nb>".($l->generated?html_select("fields[$t][generated]",array_merge(array("","DEFAULT"),$l->generated),$n["generated"])." ":checkbox("fields[$t][generated]",1,$n["generated"],"","","","label-default")),"<input name='fields[$t][default]' value='".h($n["default"])."' aria-labelledby='label-default'>",(support("comment")?"<td$mb><input name='fields[$t][comment]' value='".h($n["comment"])."' data-maxlength='".(min_version(5.5)?1024:255)."' aria-labelledby='label-comment'>":"");echo"<td>",(support("move_col")?"<input type='image' class='icon' name='add[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=5.0.6")."' alt='+' title='".'新增下一筆'."'> "."<input type='image' class='icon' name='up[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=up.gif&version=5.0.6")."' alt='↑' title='".'上移'."'> "."<input type='image' class='icon' name='down[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=down.gif&version=5.0.6")."' alt='↓' title='".'下移'."'> ":""),($Bf==""||support("drop_col")?"<input type='image' class='icon' name='drop_col[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=5.0.6")."' alt='x' title='".'移除'."'>":"");}}function
process_fields(&$o){$C=0;if($_POST["up"]){$ke=0;foreach($o
as$y=>$n){if(key($_POST["up"])==$y){unset($o[$y]);array_splice($o,$ke,0,array($n));break;}if(isset($n["field"]))$ke=$C;$C++;}}elseif($_POST["down"]){$ed=false;foreach($o
as$y=>$n){if(isset($n["field"])&&$ed){unset($o[key($_POST["down"])]);array_splice($o,$C,0,array($ed));break;}if(key($_POST["down"])==$y)$ed=$n;$C++;}}elseif($_POST["add"]){$o=array_values($o);array_splice($o,key($_POST["add"]),0,array(array()));}elseif(!$_POST["drop_col"])return
false;return
true;}function
normalize_enum($A){return"'".str_replace("'","''",addcslashes(stripcslashes(str_replace($A[0][0].$A[0][0],$A[0][0],substr($A[0],1,-1))),'\\'))."'";}function
grant($ld,$ng,$e,$mf){if(!$ng)return
true;if($ng==array("ALL PRIVILEGES","GRANT OPTION"))return($ld=="GRANT"?queries("$ld ALL PRIVILEGES$mf WITH GRANT OPTION"):queries("$ld ALL PRIVILEGES$mf")&&queries("$ld GRANT OPTION$mf"));return
queries("$ld ".preg_replace('~(GRANT OPTION)\([^)]*\)~','\1',implode("$e, ",$ng).$e).$mf);}function
drop_create($ac,$h,$cc,$Wh,$ec,$ue,$Me,$Ke,$Le,$jf,$Xe){if($_POST["drop"])query_redirect($ac,$ue,$Me);elseif($jf=="")query_redirect($h,$ue,$Le);elseif($jf!=$Xe){$_b=queries($h);queries_redirect($ue,$Ke,$_b&&queries($ac));if($_b)queries($cc);}else
queries_redirect($ue,$Ke,queries($Wh)&&queries($ec)&&queries($ac)&&queries($h));}function
create_trigger($mf,$J){$ci=" $J[Timing] $J[Event]".(preg_match('~ OF~',$J["Event"])?" $J[Of]":"");return"CREATE TRIGGER ".idf_escape($J["Trigger"]).(JUSH=="mssql"?$mf.$ci:$ci.$mf).rtrim(" $J[Type]\n$J[Statement]",";").";";}function
create_routine($Mg,$J){global$l;$N=array();$o=(array)$J["fields"];ksort($o);foreach($o
as$n){if($n["field"]!="")$N[]=(preg_match("~^($l->inout)\$~",$n["inout"])?"$n[inout] ":"").idf_escape($n["field"]).process_type($n,"CHARACTER SET");}$Ob=rtrim($J["definition"],";");return"CREATE $Mg ".idf_escape(trim($J["name"]))." (".implode(", ",$N).")".($Mg=="FUNCTION"?" RETURNS".process_type($J["returns"],"CHARACTER SET"):"").($J["language"]?" LANGUAGE $J[language]":"").(JUSH=="pgsql"?" AS ".q($Ob):"\n$Ob;");}function
remove_definer($G){return
preg_replace('~^([A-Z =]+) DEFINER=`'.preg_replace('~@(.*)~','`@`(%|\1)',logged_user()).'`~','\1',$G);}function
format_foreign_key($q){global$l;$j=$q["db"];$bf=$q["ns"];return" FOREIGN KEY (".implode(", ",array_map('Adminer\idf_escape',$q["source"])).") REFERENCES ".($j!=""&&$j!=$_GET["db"]?idf_escape($j).".":"").($bf!=""&&$bf!=$_GET["ns"]?idf_escape($bf).".":"").idf_escape($q["table"])." (".implode(", ",array_map('Adminer\idf_escape',$q["target"])).")".(preg_match("~^($l->onActions)\$~",$q["on_delete"])?" ON DELETE $q[on_delete]":"").(preg_match("~^($l->onActions)\$~",$q["on_update"])?" ON UPDATE $q[on_update]":"");}function
tar_file($p,$hi){$I=pack("a100a8a8a8a12a12",$p,644,0,0,decoct($hi->size),decoct(time()));$Ya=8*32;for($t=0;$t<strlen($I);$t++)$Ya+=ord($I[$t]);$I.=sprintf("%06o",$Ya)."\0 ";echo$I,str_repeat("\0",512-strlen($I));$hi->send();echo
str_repeat("\0",511-($hi->size+511)%512);}function
ini_bytes($Od){$X=ini_get($Od);switch(strtolower(substr($X,-1))){case'g':$X=(int)$X*1024;case'm':$X=(int)$X*1024;case'k':$X=(int)$X*1024;}return$X;}function
doc_link($Wf,$Xh="<sup>?</sup>"){global$f;$gh=$f->server_info;$Ti=preg_replace('~^(\d\.?\d).*~s','\1',$gh);$Ii=array('sql'=>"https://dev.mysql.com/doc/refman/$Ti/en/",'sqlite'=>"https://www.sqlite.org/",'pgsql'=>"https://www.postgresql.org/docs/$Ti/",'mssql'=>"https://learn.microsoft.com/en-us/sql/",'oracle'=>"https://www.oracle.com/pls/topic/lookup?ctx=db".preg_replace('~^.* (\d+)\.(\d+)\.\d+\.\d+\.\d+.*~s','\1\2',$gh)."&id=",);if($f->maria){$Ii['sql']="https://mariadb.com/kb/en/";$Wf['sql']=(isset($Wf['mariadb'])?$Wf['mariadb']:str_replace(".html","/",$Wf['sql']));}return($Wf[JUSH]?"<a href='".h($Ii[JUSH].$Wf[JUSH].(JUSH=='mssql'?"?view=sql-server-ver$Ti":""))."'".target_blank().">$Xh</a>":"");}function
db_size($j){global$f;if(!$f->select_db($j))return"?";$I=0;foreach(table_status()as$R)$I+=$R["Data_length"]+$R["Index_length"];return
format_number($I);}function
set_utf8mb4($h){global$f;static$N=false;if(!$N&&preg_match('~\butf8mb4~i',$h)){$N=true;echo"SET NAMES ".charset($f).";\n\n";}}if(isset($_GET["status"]))$_GET["variables"]=$_GET["status"];if(isset($_GET["import"]))$_GET["sql"]=$_GET["import"];if(!(DB!=""?$f->select_db(DB):isset($_GET["sql"])||isset($_GET["dump"])||isset($_GET["database"])||isset($_GET["processlist"])||isset($_GET["privileges"])||isset($_GET["user"])||isset($_GET["variables"])||$_GET["script"]=="connect"||$_GET["script"]=="kill")){if(DB!=""||$_GET["refresh"]){restart_session();set_session("dbs",null);}if(DB!=""){header("HTTP/1.1 404 Not Found");page_header('資料庫'.": ".h(DB),'無效的資料庫。',true);}else{if($_POST["db"]&&!$m)queries_redirect(substr(ME,0,-1),'資料庫已刪除。',drop_databases($_POST["db"]));page_header('選擇資料庫',$m,false);echo"<p class='links'>\n";foreach(array('database'=>'建立資料庫','privileges'=>'權限','processlist'=>'處理程序列表','variables'=>'變數','status'=>'狀態',)as$y=>$X){if(support($y))echo"<a href='".h(ME)."$y='>$X</a>\n";}echo"<p>".sprintf('%s 版本：%s 透過 PHP 擴充模組 %s',$Zb[DRIVER],"<b>".h($f->server_info)."</b>","<b>$f->extension</b>")."\n","<p>".sprintf('登錄為： %s',"<b>".h(logged_user())."</b>")."\n";$i=$b->databases();if($i){$Ug=support("scheme");$gb=collations();echo"<form action='' method='post'>\n","<table class='checkable odds'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),"<thead><tr>".(support("database")?"<td>":"")."<th>".'資料庫'.(get_session("dbs")!==null?" - <a href='".h(ME)."refresh=1'>".'重新載入'."</a>":"")."<td>".'校對'."<td>".'資料表'."<td>".'大小'." - <a href='".h(ME)."dbsize=1'>".'計算'."</a>".script("qsl('a').onclick = partial(ajaxSetHtml, '".js_escape(ME)."script=connect');","")."</thead>\n";$i=($_GET["dbsize"]?count_tables($i):array_flip($i));foreach($i
as$j=>$S){$Lg=h(ME)."db=".urlencode($j);$u=h("Db-".$j);echo"<tr>".(support("database")?"<td>".checkbox("db[]",$j,in_array($j,(array)$_POST["db"]),"","","",$u):""),"<th><a href='$Lg' id='$u'>".h($j)."</a>";$fb=h(db_collation($j,$gb));echo"<td>".(support("database")?"<a href='$Lg".($Ug?"&amp;ns=":"")."&amp;database=' title='".'修改資料庫'."'>$fb</a>":$fb),"<td align='right'><a href='$Lg&amp;schema=' id='tables-".h($j)."' title='".'資料庫結構'."'>".($_GET["dbsize"]?$S:"?")."</a>","<td align='right' id='size-".h($j)."'>".($_GET["dbsize"]?db_size($j):"?"),"\n";}echo"</table>\n",(support("database")?"<div class='footer'><div>\n"."<fieldset><legend>".'已選中'." <span id='selected'></span></legend><div>\n"."<input type='hidden' name='all' value=''>".script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };")."<input type='submit' name='drop' value='".'刪除'."'>".confirm()."\n"."</div></fieldset>\n"."</div></div>\n":""),"<input type='hidden' name='token' value='$T'>\n","</form>\n",script("tableCheck();");}}page_footer("db");exit;}if(support("scheme")){if(DB!=""&&$_GET["ns"]!==""){if(!isset($_GET["ns"]))redirect(preg_replace('~ns=[^&]*&~','',ME)."ns=".get_schema());if(!set_schema($_GET["ns"])){header("HTTP/1.1 404 Not Found");page_header('資料表結構'.": ".h($_GET["ns"]),'無效的資料表結構。',true);page_footer("ns");exit;}}}class
TmpFile{private$handler,$size;function
__construct(){$this->handler=tmpfile();}function
write($ub){$this->size+=strlen($ub);fwrite($this->handler,$ub);}function
send(){fseek($this->handler,0);fpassthru($this->handler);fclose($this->handler);}}if(isset($_GET["select"])&&($_POST["edit"]||$_POST["clone"])&&!$_POST["save"])$_GET["edit"]=$_GET["select"];if(isset($_GET["callf"]))$_GET["call"]=$_GET["callf"];if(isset($_GET["function"]))$_GET["procedure"]=$_GET["function"];if(isset($_GET["download"])){$a=$_GET["download"];$o=fields($a);header("Content-Type: application/octet-stream");header("Content-Disposition: attachment; filename=".friendly_url("$a-".implode("_",$_GET["where"])).".".friendly_url($_GET["field"]));$L=array(idf_escape($_GET["field"]));$H=$l->select($a,$L,array(where($_GET,$o)),$L);$J=($H?$H->fetch_row():array());echo$l->value($J[0],$o[$_GET["field"]]);exit;}elseif(isset($_GET["table"])){$a=$_GET["table"];$o=fields($a);if(!$o)$m=error();$R=table_status1($a,true);$B=$b->tableName($R);page_header(($o&&is_view($R)?$R['Engine']=='materialized view'?'物化視圖':'檢視表':'資料表').": ".($B!=""?$B:h($a)),$m);$Kg=array();foreach($o
as$y=>$n)$Kg+=$n["privileges"];$b->selectLinks($R,(isset($Kg["insert"])||!support("table")?"":null));$lb=$R["Comment"];if($lb!="")echo"<p class='nowrap'>".'註解'.": ".h($lb)."\n";if($o)$b->tableStructurePrint($o);if(support("indexes")&&$l->supportsIndex($R)){echo"<h3 id='indexes'>".'索引'."</h3>\n";$x=indexes($a);if($x)$b->tableIndexesPrint($x);echo'<p class="links"><a href="'.h(ME).'indexes='.urlencode($a).'">'.'修改索引'."</a>\n";}if(!is_view($R)){if(fk_support($R)){echo"<h3 id='foreign-keys'>".'外來鍵'."</h3>\n";$cd=foreign_keys($a);if($cd){echo"<table>\n","<thead><tr><th>".'來源'."<td>".'目標'."<td>".'ON DELETE'."<td>".'ON UPDATE'."<td></thead>\n";foreach($cd
as$B=>$q){echo"<tr title='".h($B)."'>","<th><i>".implode("</i>, <i>",array_map('Adminer\h',$q["source"]))."</i>";$_=($q["db"]!=""?preg_replace('~db=[^&]*~',"db=".urlencode($q["db"]),ME):($q["ns"]!=""?preg_replace('~ns=[^&]*~',"ns=".urlencode($q["ns"]),ME):ME));echo"<td><a href='".h($_."table=".urlencode($q["table"]))."'>".($q["db"]!=""&&$q["db"]!=DB?"<b>".h($q["db"])."</b>.":"").($q["ns"]!=""&&$q["ns"]!=$_GET["ns"]?"<b>".h($q["ns"])."</b>.":"").h($q["table"])."</a>","(<i>".implode("</i>, <i>",array_map('Adminer\h',$q["target"]))."</i>)","<td>".h($q["on_delete"]),"<td>".h($q["on_update"]),'<td><a href="'.h(ME.'foreign='.urlencode($a).'&name='.urlencode($B)).'">'.'修改'.'</a>',"\n";}echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'foreign='.urlencode($a).'">'.'新增外來鍵'."</a>\n";}if(support("check")){echo"<h3 id='checks'>".'Checks'."</h3>\n";$Ua=$l->checkConstraints($a);if($Ua){echo"<table>\n";foreach($Ua
as$y=>$X)echo"<tr title='".h($y)."'>","<td><code class='jush-".JUSH."'>".h($X),"<td><a href='".h(ME.'check='.urlencode($a).'&name='.urlencode($y))."'>".'修改'."</a>","\n";echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'check='.urlencode($a).'">'.'Create check'."</a>\n";}}if(support(is_view($R)?"view_trigger":"trigger")){echo"<h3 id='triggers'>".'觸發器'."</h3>\n";$ui=triggers($a);if($ui){echo"<table>\n";foreach($ui
as$y=>$X)echo"<tr valign='top'><td>".h($X[0])."<td>".h($X[1])."<th>".h($y)."<td><a href='".h(ME.'trigger='.urlencode($a).'&name='.urlencode($y))."'>".'修改'."</a>\n";echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'trigger='.urlencode($a).'">'.'建立觸發器'."</a>\n";}}elseif(isset($_GET["schema"])){page_header('資料庫結構',"",array(),h(DB.($_GET["ns"]?".$_GET[ns]":"")));$Nh=array();$Oh=array();$ea=($_GET["schema"]?:$_COOKIE["adminer_schema-".str_replace(".","_",DB)]);preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~',$ea,$Ae,PREG_SET_ORDER);foreach($Ae
as$t=>$A){$Nh[$A[1]]=array($A[2],$A[3]);$Oh[]="\n\t'".js_escape($A[1])."': [ $A[2], $A[3] ]";}$ji=0;$Ga=-1;$Sg=array();$Ag=array();$oe=array();foreach(table_status('',true)as$Q=>$R){if(is_view($R))continue;$cg=0;$Sg[$Q]["fields"]=array();foreach(fields($Q)as$B=>$n){$cg+=1.25;$n["pos"]=$cg;$Sg[$Q]["fields"][$B]=$n;}$Sg[$Q]["pos"]=($Nh[$Q]?:array($ji,0));foreach($b->foreignKeys($Q)as$X){if(!$X["db"]){$me=$Ga;if($Nh[$Q][1]||$Nh[$X["table"]][1])$me=min(floatval($Nh[$Q][1]),floatval($Nh[$X["table"]][1]))-1;else$Ga-=.1;while($oe[(string)$me])$me-=.0001;$Sg[$Q]["references"][$X["table"]][(string)$me]=array($X["source"],$X["target"]);$Ag[$X["table"]][$Q][(string)$me]=$X["target"];$oe[(string)$me]=true;}}$ji=max($ji,$Sg[$Q]["pos"][0]+2.5+$cg);}echo'<div id="schema" style="height: ',$ji,'em;">
<script',nonce(),'>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {',implode(",",$Oh)."\n",'};
var em = qs(\'#schema\').offsetHeight / ',$ji,';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'',js_escape(DB),'\');
</script>
';foreach($Sg
as$B=>$Q){echo"<div class='table' style='top: ".$Q["pos"][0]."em; left: ".$Q["pos"][1]."em;'>",'<a href="'.h(ME).'table='.urlencode($B).'"><b>'.h($B)."</b></a>",script("qsl('div').onmousedown = schemaMousedown;");foreach($Q["fields"]as$n){$X='<span'.type_class($n["type"]).' title="'.h($n["full_type"].($n["null"]?" NULL":'')).'">'.h($n["field"]).'</span>';echo"<br>".($n["primary"]?"<i>$X</i>":$X);}foreach((array)$Q["references"]as$Uh=>$Bg){foreach($Bg
as$me=>$yg){$ne=$me-$Nh[$B][1];$t=0;foreach($yg[0]as$rh)echo"\n<div class='references' title='".h($Uh)."' id='refs$me-".($t++)."' style='left: $ne"."em; top: ".$Q["fields"][$rh]["pos"]."em; padding-top: .5em;'>"."<div style='border-top: 1px solid gray; width: ".(-$ne)."em;'></div></div>";}}foreach((array)$Ag[$B]as$Uh=>$Bg){foreach($Bg
as$me=>$e){$ne=$me-$Nh[$B][1];$t=0;foreach($e
as$Th)echo"\n<div class='references' title='".h($Uh)."' id='refd$me-".($t++)."'"." style='left: $ne"."em; top: ".$Q["fields"][$Th]["pos"]."em; height: 1.25em; background: url(".h(preg_replace("~\\?.*~","",ME)."?file=arrow.gif) no-repeat right center;&version=5.0.6")."'>"."<div style='height: .5em; border-bottom: 1px solid gray; width: ".(-$ne)."em;'></div>"."</div>";}}echo"\n</div>\n";}foreach($Sg
as$B=>$Q){foreach((array)$Q["references"]as$Uh=>$Bg){foreach($Bg
as$me=>$yg){$Oe=$ji;$Ee=-10;foreach($yg[0]as$y=>$rh){$dg=$Q["pos"][0]+$Q["fields"][$rh]["pos"];$eg=$Sg[$Uh]["pos"][0]+$Sg[$Uh]["fields"][$yg[1][$y]]["pos"];$Oe=min($Oe,$dg,$eg);$Ee=max($Ee,$dg,$eg);}echo"<div class='references' id='refl$me' style='left: $me"."em; top: $Oe"."em; padding: .5em 0;'><div style='border-right: 1px solid gray; margin-top: 1px; height: ".($Ee-$Oe)."em;'></div></div>\n";}}}echo'</div>
<p class="links"><a href="',h(ME."schema=".urlencode($ea)),'" id="schema-link">永久連結</a>
';}elseif(isset($_GET["dump"])){$a=$_GET["dump"];if($_POST&&!$m){save_settings(array_intersect_key($_POST,array_flip(array("output","format","db_style","types","routines","events","table_style","auto_increment","triggers","data_style"))),"adminer_export");$S=array_flip((array)$_POST["tables"])+array_flip((array)$_POST["data"]);$Gc=dump_headers((count($S)==1?key($S):DB),(DB==""||count($S)>1));$Xd=preg_match('~sql~',$_POST["format"]);if($Xd){echo"-- Adminer $ia ".$Zb[DRIVER]." ".str_replace("\n"," ",$f->server_info)." dump\n\n";if(JUSH=="sql"){echo"SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
".($_POST["data_style"]?"SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
":"")."
";$f->query("SET time_zone = '+00:00'");$f->query("SET sql_mode = ''");}}$Dh=$_POST["db_style"];$i=array(DB);if(DB==""){$i=$_POST["databases"];if(is_string($i))$i=explode("\n",rtrim(str_replace("\r","",$i),"\n"));}foreach((array)$i
as$j){$b->dumpDatabase($j);if($f->select_db($j)){if($Xd&&preg_match('~CREATE~',$Dh)&&($h=get_val("SHOW CREATE DATABASE ".idf_escape($j),1))){set_utf8mb4($h);if($Dh=="DROP+CREATE")echo"DROP DATABASE IF EXISTS ".idf_escape($j).";\n";echo"$h;\n";}if($Xd){if($Dh)echo
use_sql($j).";\n\n";$If="";if($_POST["types"]){foreach(types()as$u=>$U){$vc=type_values($u);if($vc)$If.=($Dh!='DROP+CREATE'?"DROP TYPE IF EXISTS ".idf_escape($U).";;\n":"")."CREATE TYPE ".idf_escape($U)." AS ENUM ($vc);\n\n";else$If.="-- Could not export type $U\n\n";}}if($_POST["routines"]){foreach(routines()as$J){$B=$J["ROUTINE_NAME"];$Mg=$J["ROUTINE_TYPE"];$h=create_routine($Mg,array("name"=>$B)+routine($J["SPECIFIC_NAME"],$Mg));set_utf8mb4($h);$If.=($Dh!='DROP+CREATE'?"DROP $Mg IF EXISTS ".idf_escape($B).";;\n":"")."$h;\n\n";}}if($_POST["events"]){foreach(get_rows("SHOW EVENTS",null,"-- ")as$J){$h=remove_definer(get_val("SHOW CREATE EVENT ".idf_escape($J["Name"]),3));set_utf8mb4($h);$If.=($Dh!='DROP+CREATE'?"DROP EVENT IF EXISTS ".idf_escape($J["Name"]).";;\n":"")."$h;;\n\n";}}echo($If&&JUSH=='sql'?"DELIMITER ;;\n\n$If"."DELIMITER ;\n\n":$If);}if($_POST["table_style"]||$_POST["data_style"]){$Vi=array();foreach(table_status('',true)as$B=>$R){$Q=(DB==""||in_array($B,(array)$_POST["tables"]));$Gb=(DB==""||in_array($B,(array)$_POST["data"]));if($Q||$Gb){if($Gc=="tar"){$hi=new
TmpFile;ob_start(array($hi,'write'),1e5);}$b->dumpTable($B,($Q?$_POST["table_style"]:""),(is_view($R)?2:0));if(is_view($R))$Vi[]=$B;elseif($Gb){$o=fields($B);$b->dumpData($B,$_POST["data_style"],"SELECT *".convert_fields($o,$o)." FROM ".table($B));}if($Xd&&$_POST["triggers"]&&$Q&&($ui=trigger_sql($B)))echo"\nDELIMITER ;;\n$ui\nDELIMITER ;\n";if($Gc=="tar"){ob_end_flush();tar_file((DB!=""?"":"$j/")."$B.csv",$hi);}elseif($Xd)echo"\n";}}if(function_exists('Adminer\foreign_keys_sql')){foreach(table_status('',true)as$B=>$R){$Q=(DB==""||in_array($B,(array)$_POST["tables"]));if($Q&&!is_view($R))echo
foreign_keys_sql($B);}}foreach($Vi
as$Ui)$b->dumpTable($Ui,$_POST["table_style"],1);if($Gc=="tar")echo
pack("x512");}}}$b->dumpFooter();exit;}page_header('匯出',$m,($_GET["export"]!=""?array("table"=>$_GET["export"]):array()),h(DB));echo'
<form action="" method="post">
<table class="layout">
';$Kb=array('','USE','DROP+CREATE','CREATE');$Ph=array('','DROP+CREATE','CREATE');$Hb=array('','TRUNCATE+INSERT','INSERT');if(JUSH=="sql")$Hb[]='INSERT+UPDATE';$J=get_settings("adminer_export");if(!$J)$J=array("output"=>"text","format"=>"sql","db_style"=>(DB!=""?"":"CREATE"),"table_style"=>"DROP+CREATE","data_style"=>"INSERT");if(!isset($J["events"])){$J["routines"]=$J["events"]=($_GET["dump"]=="");$J["triggers"]=$J["table_style"];}echo"<tr><th>".'輸出'."<td>".html_radios("output",$b->dumpOutput(),$J["output"])."\n","<tr><th>".'格式'."<td>".html_radios("format",$b->dumpFormat(),$J["format"])."\n",(JUSH=="sqlite"?"":"<tr><th>".'資料庫'."<td>".html_select('db_style',$Kb,$J["db_style"]).(support("type")?checkbox("types",1,$J["types"],'使用者類型'):"").(support("routine")?checkbox("routines",1,$J["routines"],'程序'):"").(support("event")?checkbox("events",1,$J["events"],'事件'):"")),"<tr><th>".'資料表'."<td>".html_select('table_style',$Ph,$J["table_style"]).checkbox("auto_increment",1,$J["auto_increment"],'自動遞增').(support("trigger")?checkbox("triggers",1,$J["triggers"],'觸發器'):""),"<tr><th>".'資料'."<td>".html_select('data_style',$Hb,$J["data_style"]),'</table>
<p><input type="submit" value="匯出">
<input type="hidden" name="token" value="',$T,'">

<table>
',script("qsl('table').onclick = dumpClick;");$ig=array();if(DB!=""){$Wa=($a!=""?"":" checked");echo"<thead><tr>","<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$Wa>".'資料表'."</label>".script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);",""),"<th style='text-align: right;'><label class='block'>".'資料'."<input type='checkbox' id='check-data'$Wa></label>".script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);",""),"</thead>\n";$Vi="";$Qh=tables_list();foreach($Qh
as$B=>$U){$hg=preg_replace('~_.*~','',$B);$Wa=($a==""||$a==(substr($a,-1)=="%"?"$hg%":$B));$kg="<tr><td>".checkbox("tables[]",$B,$Wa,$B,"","block");if($U!==null&&!preg_match('~table~i',$U))$Vi.="$kg\n";else
echo"$kg<td align='right'><label class='block'><span id='Rows-".h($B)."'></span>".checkbox("data[]",$B,$Wa)."</label>\n";$ig[$hg]++;}echo$Vi;if($Qh)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}else{echo"<thead><tr><th style='text-align: left;'>","<label class='block'><input type='checkbox' id='check-databases'".($a==""?" checked":"").">".'資料庫'."</label>",script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);",""),"</thead>\n";$i=$b->databases();if($i){foreach($i
as$j){if(!information_schema($j)){$hg=preg_replace('~_.*~','',$j);echo"<tr><td>".checkbox("databases[]",$j,$a==""||$a=="$hg%",$j,"","block")."\n";$ig[$hg]++;}}}else
echo"<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";}echo'</table>
</form>
';$Tc=true;foreach($ig
as$y=>$X){if($y!=""&&$X>1){echo($Tc?"<p>":" ")."<a href='".h(ME)."dump=".urlencode("$y%")."'>".h($y)."</a>";$Tc=false;}}}elseif(isset($_GET["privileges"])){page_header('權限');echo'<p class="links"><a href="'.h(ME).'user=">'.'建立使用者'."</a>";$H=$f->query("SELECT User, Host FROM mysql.".(DB==""?"user":"db WHERE ".q(DB)." LIKE Db")." ORDER BY Host, User");$ld=$H;if(!$H)$H=$f->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");echo"<form action=''><p>\n";hidden_fields_get();echo"<input type='hidden' name='db' value='".h(DB)."'>\n",($ld?"":"<input type='hidden' name='grant' value=''>\n"),"<table class='odds'>\n","<thead><tr><th>".'帳號'."<th>".'伺服器'."<th></thead>\n";while($J=$H->fetch_assoc())echo'<tr><td>'.h($J["User"])."<td>".h($J["Host"]).'<td><a href="'.h(ME.'user='.urlencode($J["User"]).'&host='.urlencode($J["Host"])).'">'.'編輯'."</a>\n";if(!$ld||DB!="")echo"<tr><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='".'編輯'."'>\n";echo"</table>\n","</form>\n";}elseif(isset($_GET["sql"])){if(!$m&&$_POST["export"]){save_settings(array("output"=>$_POST["output"],"format"=>$_POST["format"]),"adminer_import");dump_headers("sql");$b->dumpTable("","");$b->dumpData("","table",$_POST["query"]);$b->dumpFooter();exit;}restart_session();$_d=&get_session("queries");$zd=&$_d[DB];if(!$m&&$_POST["clear"]){$zd=array();redirect(remove_from_uri("history"));}page_header((isset($_GET["import"])?'匯入':'SQL 命令'),$m);if(!$m&&$_POST){$r=false;if(!isset($_GET["import"]))$G=$_POST["query"];elseif($_POST["webfile"]){$vh=$b->importServerPath();$r=@fopen((file_exists($vh)?$vh:"compress.zlib://$vh.gz"),"rb");$G=($r?fread($r,1e6):false);}else$G=get_file("sql_file",true,";");if(is_string($G)){if(function_exists('memory_get_usage')&&($Ie=ini_bytes("memory_limit"))!="-1")@ini_set("memory_limit",max($Ie,2*strlen($G)+memory_get_usage()+8e6));if($G!=""&&strlen($G)<1e6){$rg=$G.(preg_match("~;[ \t\r\n]*\$~",$G)?"":";");if(!$zd||reset(end($zd))!=$rg){restart_session();$zd[]=array($rg,time());set_session("queries",$_d);stop_session();}}$sh="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$Qb=";";$C=0;$pc=true;$g=connect($b->credentials());if(is_object($g)&&DB!=""){$g->select_db(DB);if($_GET["ns"]!="")set_schema($_GET["ns"],$g);}$kb=0;$xc=array();$Pf='[\'"'.(JUSH=="sql"?'`#':(JUSH=="sqlite"?'`[':(JUSH=="mssql"?'[':''))).']|/\*|-- |$'.(JUSH=="pgsql"?'|\$[^$]*\$':'');$ki=microtime(true);$oa=get_settings("adminer_import");$gc=$b->dumpFormat();unset($gc["sql"]);while($G!=""){if(!$C&&preg_match("~^$sh*+DELIMITER\\s+(\\S+)~i",$G,$A)){$Qb=$A[1];$G=substr($G,strlen($A[0]));}else{preg_match('('.preg_quote($Qb)."\\s*|$Pf)",$G,$A,PREG_OFFSET_CAPTURE,$C);list($ed,$cg)=$A[0];if(!$ed&&$r&&!feof($r))$G.=fread($r,1e5);else{if(!$ed&&rtrim($G)=="")break;$C=$cg+strlen($ed);if($ed&&rtrim($ed)!=$Qb){$Pa=$l->hasCStyleEscapes()||(JUSH=="pgsql"&&($cg>0&&strtolower($G[$cg-1])=="e"));$Xf=($ed=='/*'?'\*/':($ed=='['?']':(preg_match('~^-- |^#~',$ed)?"\n":preg_quote($ed).($Pa?"|\\\\.":""))));while(preg_match("($Xf|\$)s",$G,$A,PREG_OFFSET_CAPTURE,$C)){$Qg=$A[0][0];if(!$Qg&&$r&&!feof($r))$G.=fread($r,1e5);else{$C=$A[0][1]+strlen($Qg);if(!$Qg||$Qg[0]!="\\")break;}}}else{$pc=false;$rg=substr($G,0,$cg);$kb++;$kg="<pre id='sql-$kb'><code class='jush-".JUSH."'>".$b->sqlCommandQuery($rg)."</code></pre>\n";if(JUSH=="sqlite"&&preg_match("~^$sh*+ATTACH\\b~i",$rg,$A)){echo$kg,"<p class='error'>".'不支援ATTACH查詢。'."\n";$xc[]=" <a href='#sql-$kb'>$kb</a>";if($_POST["error_stops"])break;}else{if(!$_POST["only_errors"]){echo$kg;ob_flush();flush();}$_h=microtime(true);if($f->multi_query($rg)&&is_object($g)&&preg_match("~^$sh*+USE\\b~i",$rg))$g->query($rg);do{$H=$f->store_result();if($f->error){echo($_POST["only_errors"]?$kg:""),"<p class='error'>".'查詢發生錯誤'.($f->errno?" ($f->errno)":"").": ".error()."\n";$xc[]=" <a href='#sql-$kb'>$kb</a>";if($_POST["error_stops"])break
2;}else{$ai=" <span class='time'>(".format_time($_h).")</span>".(strlen($rg)<1000?" <a href='".h(ME)."sql=".urlencode(trim($rg))."'>".'編輯'."</a>":"");$qa=$f->affected_rows;$Yi=($_POST["only_errors"]?"":$l->warnings());$Zi="warnings-$kb";if($Yi)$ai.=", <a href='#$Zi'>".'警告'."</a>".script("qsl('a').onclick = partial(toggle, '$Zi');","");$Ec=null;$Fc="explain-$kb";if(is_object($H)){$z=$_POST["limit"];$Af=select($H,$g,array(),$z);if(!$_POST["only_errors"]){echo"<form action='' method='post'>\n";$cf=$H->num_rows;echo"<p>".($cf?($z&&$cf>$z?sprintf('%d / ',$z):"").sprintf('%d 行',$cf):""),$ai;if($g&&preg_match("~^($sh|\\()*+SELECT\\b~i",$rg)&&($Ec=explain($g,$rg)))echo", <a href='#$Fc'>Explain</a>".script("qsl('a').onclick = partial(toggle, '$Fc');","");$u="export-$kb";echo", <a href='#$u'>".'匯出'."</a>".script("qsl('a').onclick = partial(toggle, '$u');","")."<span id='$u' class='hidden'>: ".html_select("output",$b->dumpOutput(),$oa["output"])." ".html_select("format",$gc,$oa["format"])."<input type='hidden' name='query' value='".h($rg)."'>"." <input type='submit' name='export' value='".'匯出'."'><input type='hidden' name='token' value='$T'></span>\n"."</form>\n";}}else{if(preg_match("~^$sh*+(CREATE|DROP|ALTER)$sh++(DATABASE|SCHEMA)\\b~i",$rg)){restart_session();set_session("dbs",null);stop_session();}if(!$_POST["only_errors"])echo"<p class='message' title='".h($f->info)."'>".sprintf('執行查詢 OK，%d 行受影響。',$qa)."$ai\n";}echo($Yi?"<div id='$Zi' class='hidden'>\n$Yi</div>\n":"");if($Ec){echo"<div id='$Fc' class='hidden explain'>\n";select($Ec,$g,$Af);echo"</div>\n";}}$_h=microtime(true);}while($f->next_result());}$G=substr($G,$C);$C=0;}}}}if($pc)echo"<p class='message'>".'沒有命令可執行。'."\n";elseif($_POST["only_errors"])echo"<p class='message'>".sprintf('已順利執行 %d 個查詢。',$kb-count($xc))," <span class='time'>(".format_time($ki).")</span>\n";elseif($xc&&$kb>1)echo"<p class='error'>".'查詢發生錯誤'.": ".implode("",$xc)."\n";}else
echo"<p class='error'>".upload_error($G)."\n";}echo'
<form action="" method="post" enctype="multipart/form-data" id="form">
';$Cc="<input type='submit' value='".'執行'."' title='Ctrl+Enter'>";if(!isset($_GET["import"])){$rg=$_GET["sql"];if($_POST)$rg=$_POST["query"];elseif($_GET["history"]=="all")$rg=$zd;elseif($_GET["history"]!="")$rg=$zd[$_GET["history"]][0];echo"<p>";textarea("query",$rg,20);echo
script(($_POST?"":"qs('textarea').focus();\n")."qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '".js_escape(remove_from_uri("sql|limit|error_stops|only_errors|history"))."');"),"<p>$Cc\n",'限制行數'.": <input type='number' name='limit' class='size' value='".h($_POST?$_POST["limit"]:$_GET["limit"])."'>\n";}else{echo"<fieldset><legend>".'檔案上傳'."</legend><div>";$rd=(extension_loaded("zlib")?"[.gz]":"");echo(ini_bool("file_uploads")?"SQL$rd (&lt; ".ini_get("upload_max_filesize")."B): <input type='file' name='sql_file[]' multiple>\n$Cc":'檔案上傳已經被停用。'),"</div></fieldset>\n";$Gd=$b->importServerPath();if($Gd)echo"<fieldset><legend>".'從伺服器'."</legend><div>",sprintf('網頁伺服器檔案 %s',"<code>".h($Gd)."$rd</code>"),' <input type="submit" name="webfile" value="'.'執行檔案'.'">',"</div></fieldset>\n";echo"<p>";}echo
checkbox("error_stops",1,($_POST?$_POST["error_stops"]:isset($_GET["import"])||$_GET["error_stops"]),'出錯時停止')."\n",checkbox("only_errors",1,($_POST?$_POST["only_errors"]:isset($_GET["import"])||$_GET["only_errors"]),'僅顯示錯誤訊息')."\n","<input type='hidden' name='token' value='$T'>\n";if(!isset($_GET["import"])&&$zd){print_fieldset("history",'紀錄',$_GET["history"]!="");for($X=end($zd);$X;$X=prev($zd)){$y=key($zd);list($rg,$ai,$kc)=$X;echo'<a href="'.h(ME."sql=&history=$y").'">'.'編輯'."</a>"." <span class='time' title='".@date('Y-m-d',$ai)."'>".@date("H:i:s",$ai)."</span>"." <code class='jush-".JUSH."'>".shorten_utf8(ltrim(str_replace("\n"," ",str_replace("\r","",preg_replace('~^(#|-- ).*~m','',$rg)))),80,"</code>").($kc?" <span class='time'>($kc)</span>":"")."<br>\n";}echo"<input type='submit' name='clear' value='".'清除'."'>\n","<a href='".h(ME."sql=&history=all")."'>".'編輯全部'."</a>\n","</div></fieldset>\n";}echo'</form>
';}elseif(isset($_GET["edit"])){$a=$_GET["edit"];$o=fields($a);$Z=(isset($_GET["select"])?($_POST["check"]&&count($_POST["check"])==1?where_check($_POST["check"][0],$o):""):where($_GET,$o));$Fi=(isset($_GET["select"])?$_POST["edit"]:$Z);foreach($o
as$B=>$n){if(!isset($n["privileges"][$Fi?"update":"insert"])||$b->fieldName($n)==""||$n["generated"])unset($o[$B]);}if($_POST&&!$m&&!isset($_GET["select"])){$ue=$_POST["referer"];if($_POST["insert"])$ue=($Fi?null:$_SERVER["REQUEST_URI"]);elseif(!preg_match('~^.+&select=.+$~',$ue))$ue=ME."select=".urlencode($a);$x=indexes($a);$Ai=unique_array($_GET["where"],$x);$ug="\nWHERE $Z";if(isset($_POST["delete"]))queries_redirect($ue,'該項目已被刪除。',$l->delete($a,$ug,!$Ai));else{$N=array();foreach($o
as$B=>$n){$X=process_input($n);if($X!==false&&$X!==null)$N[idf_escape($B)]=$X;}if($Fi){if(!$N)redirect($ue);queries_redirect($ue,'已更新項目。',$l->update($a,$N,$ug,!$Ai));if(is_ajax()){page_headers();page_messages($m);exit;}}else{$H=$l->insert($a,$N);$le=($H?last_id():0);queries_redirect($ue,sprintf('已新增項目 %s。',($le?" $le":"")),$H);}}}$J=null;if($_POST["save"])$J=(array)$_POST["fields"];elseif($Z){$L=array();foreach($o
as$B=>$n){if(isset($n["privileges"]["select"])){$wa=($_POST["clone"]&&$n["auto_increment"]?"''":convert_field($n));$L[]=($wa?"$wa AS ":"").idf_escape($B);}}$J=array();if(!support("table"))$L=array("*");if($L){$H=$l->select($a,$L,array($Z),$L,array(),(isset($_GET["select"])?2:1));if(!$H)$m=error();else{$J=$H->fetch_assoc();if(!$J)$J=false;}if(isset($_GET["select"])&&(!$J||$H->fetch_assoc()))$J=null;}}if(!support("table")&&!$o){if(!$Z){$H=$l->select($a,array("*"),$Z,array("*"));$J=($H?$H->fetch_assoc():false);if(!$J)$J=array($l->primary=>"");}if($J){foreach($J
as$y=>$X){if(!$Z)$J[$y]=null;$o[$y]=array("field"=>$y,"null"=>($y!=$l->primary),"auto_increment"=>($y==$l->primary));}}}edit_form($a,$o,$J,$Fi);}elseif(isset($_GET["create"])){$a=$_GET["create"];$Rf=array();foreach(array('HASH','LINEAR HASH','KEY','LINEAR KEY','RANGE','LIST')as$y)$Rf[$y]=$y;$_g=referencable_primary($a);$cd=array();foreach($_g
as$Lh=>$n)$cd[str_replace("`","``",$Lh)."`".str_replace("`","``",$n["field"])]=$Lh;$Df=array();$R=array();if($a!=""){$Df=fields($a);$R=table_status($a);if(!$R)$m='沒有資料表。';}$J=$_POST;$J["fields"]=(array)$J["fields"];if($J["auto_increment_col"])$J["fields"][$J["auto_increment_col"]]["auto_increment"]=true;if($_POST)save_settings(array("comments"=>$_POST["comments"],"defaults"=>$_POST["defaults"]));if($_POST&&!process_fields($J["fields"])&&!$m){if($_POST["drop"])queries_redirect(substr(ME,0,-1),'已經刪除資料表。',drop_tables(array($a)));else{$o=array();$ua=array();$Ji=false;$ad=array();$Cf=reset($Df);$sa=" FIRST";foreach($J["fields"]as$y=>$n){$q=$cd[$n["type"]];$vi=($q!==null?$_g[$q]:$n);if($n["field"]!=""){if(!$n["generated"])$n["default"]=null;$pg=process_field($n,$vi);$ua[]=array($n["orig"],$pg,$sa);if(!$Cf||$pg!==process_field($Cf,$Cf)){$o[]=array($n["orig"],$pg,$sa);if($n["orig"]!=""||$sa)$Ji=true;}if($q!==null)$ad[idf_escape($n["field"])]=($a!=""&&JUSH!="sqlite"?"ADD":" ").format_foreign_key(array('table'=>$cd[$n["type"]],'source'=>array($n["field"]),'target'=>array($vi["field"]),'on_delete'=>$n["on_delete"],));$sa=" AFTER ".idf_escape($n["field"]);}elseif($n["orig"]!=""){$Ji=true;$o[]=array($n["orig"]);}if($n["orig"]!=""){$Cf=next($Df);if(!$Cf)$sa="";}}$Tf="";if(support("partitioning")){if(isset($Rf[$J["partition_by"]])){$Of=array();foreach($J
as$y=>$X){if(preg_match('~^partition~',$y))$Of[$y]=$X;}foreach($Of["partition_names"]as$y=>$B){if($B==""){unset($Of["partition_names"][$y]);unset($Of["partition_values"][$y]);}}if($Of!=get_partitions_info($a)){$Uf=array();if($Of["partition_by"]=='RANGE'||$Of["partition_by"]=='LIST'){foreach($Of["partition_names"]as$y=>$B){$Y=$Of["partition_values"][$y];$Uf[]="\n  PARTITION ".idf_escape($B)." VALUES ".($Of["partition_by"]=='RANGE'?"LESS THAN":"IN").($Y!=""?" ($Y)":" MAXVALUE");}}$Tf.="\nPARTITION BY $Of[partition_by]($Of[partition])";if($Uf)$Tf.=" (".implode(",",$Uf)."\n)";elseif($Of["partitions"])$Tf.=" PARTITIONS ".(+$Of["partitions"]);}}elseif(preg_match("~partitioned~",$R["Create_options"]))$Tf.="\nREMOVE PARTITIONING";}$Je='資料表已修改。';if($a==""){cookie("adminer_engine",$J["Engine"]);$Je='資料表已建立。';}$B=trim($J["name"]);queries_redirect(ME.(support("table")?"table=":"select=").urlencode($B),$Je,alter_table($a,$B,(JUSH=="sqlite"&&($Ji||$ad)?$ua:$o),$ad,($J["Comment"]!=$R["Comment"]?$J["Comment"]:null),($J["Engine"]&&$J["Engine"]!=$R["Engine"]?$J["Engine"]:""),($J["Collation"]&&$J["Collation"]!=$R["Collation"]?$J["Collation"]:""),($J["Auto_increment"]!=""?number($J["Auto_increment"]):""),$Tf));}}page_header(($a!=""?'修改資料表':'建立資料表'),$m,array("table"=>$a),h($a));if(!$_POST){$xi=$l->types();$J=array("Engine"=>$_COOKIE["adminer_engine"],"fields"=>array(array("field"=>"","type"=>(isset($xi["int"])?"int":(isset($xi["integer"])?"integer":"")),"on_update"=>"")),"partition_names"=>array(""),);if($a!=""){$J=$R;$J["name"]=$a;$J["fields"]=array();if(!$_GET["auto_increment"])$J["Auto_increment"]="";foreach($Df
as$n){$n["generated"]=$n["generated"]?:(isset($n["default"])?"DEFAULT":"");$J["fields"][]=$n;}if(support("partitioning")){$J+=get_partitions_info($a);$J["partition_names"][]="";$J["partition_values"][]="";}}}$gb=collations();$rc=engines();foreach($rc
as$qc){if(!strcasecmp($qc,$J["Engine"])){$J["Engine"]=$qc;break;}}echo'
<form action="" method="post" id="form">
<p>
';if(support("columns")||$a==""){echo'資料表名稱'."<input name='name'".($a==""&&!$_POST?" autofocus":"")." data-maxlength='64' value='".h($J["name"])."' autocapitalize='off'>\n",($rc?html_select("Engine",array(""=>"(".'引擎'.")")+$rc,$J["Engine"]).on_help("getTarget(event).value",1).script("qsl('select').onchange = helpClose;")."\n":"");if($gb)echo"<datalist id='collations'>".optionlist($gb)."</datalist>",(preg_match("~sqlite|mssql~",JUSH)?"":"<input list='collations' name='Collation' value='".h($J["Collation"])."' placeholder='(".'校對'.")'>");echo"<input type='submit' value='".'儲存'."'>\n";}if(support("columns")){echo"<div class='scrollable'>\n","<table id='edit-fields' class='nowrap'>\n";edit_fields($J["fields"],$gb,"TABLE",$cd);echo"</table>\n",script("editFields();"),"</div>\n<p>\n",'自動遞增'.": <input type='number' name='Auto_increment' class='size' value='".h($J["Auto_increment"])."'>\n",checkbox("defaults",1,($_POST?$_POST["defaults"]:get_setting("defaults")),'預設值',"columnShow(this.checked, 5)","jsonly");$nb=($_POST?$_POST["comments"]:get_setting("comments"));echo(support("comment")?checkbox("comments",1,$nb,'註解',"editingCommentsClick(this, true);","jsonly").' '.(preg_match('~\n~',$J["Comment"])?"<textarea name='Comment' rows='2' cols='20'".($nb?"":" class='hidden'").">".h($J["Comment"])."</textarea>":'<input name="Comment" value="'.h($J["Comment"]).'" data-maxlength="'.(min_version(5.5)?2048:60).'"'.($nb?"":" class='hidden'").'>'):''),'<p>
<input type="submit" value="儲存">
';}echo'
';if($a!="")echo'<input type="submit" name="drop" value="刪除">',confirm(sprintf('刪除 %s?',$a));if(support("partitioning")){$Sf=preg_match('~RANGE|LIST~',$J["partition_by"]);print_fieldset("partition",'分區類型',$J["partition_by"]);echo"<p>".html_select("partition_by",array(""=>"")+$Rf,$J["partition_by"]).on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')",1).script("qsl('select').onchange = partitionByChange;"),"(<input name='partition' value='".h($J["partition"])."'>)\n",'分區'.": <input type='number' name='partitions' class='size".($Sf||!$J["partition_by"]?" hidden":"")."' value='".h($J["partitions"])."'>\n","<table id='partition-table'".($Sf?"":" class='hidden'").">\n","<thead><tr><th>".'分區名稱'."<th>".'值'."</thead>\n";foreach($J["partition_names"]as$y=>$X)echo'<tr>','<td><input name="partition_names[]" value="'.h($X).'" autocapitalize="off">',($y==count($J["partition_names"])-1?script("qsl('input').oninput = partitionNameChange;"):''),'<td><input name="partition_values[]" value="'.h($J["partition_values"][$y]).'">';echo"</table>\n</div></fieldset>\n";}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["indexes"])){$a=$_GET["indexes"];$Kd=array("PRIMARY","UNIQUE","INDEX");$R=table_status($a,true);if(preg_match('~MyISAM|M?aria'.(min_version(5.6,'10.0.5')?'|InnoDB':'').'~i',$R["Engine"]))$Kd[]="FULLTEXT";if(preg_match('~MyISAM|M?aria'.(min_version(5.7,'10.2.2')?'|InnoDB':'').'~i',$R["Engine"]))$Kd[]="SPATIAL";$x=indexes($a);$F=array();if(JUSH=="mongo"){$F=$x["_id_"];unset($Kd[0]);unset($x["_id_"]);}$J=$_POST;if($J)save_settings(array("index_options"=>$J["options"]));if($_POST&&!$m&&!$_POST["add"]&&!$_POST["drop_col"]){$c=array();foreach($J["indexes"]as$w){$B=$w["name"];if(in_array($w["type"],$Kd)){$e=array();$re=array();$Sb=array();$N=array();ksort($w["columns"]);foreach($w["columns"]as$y=>$d){if($d!=""){$qe=$w["lengths"][$y];$Rb=$w["descs"][$y];$N[]=idf_escape($d).($qe?"(".(+$qe).")":"").($Rb?" DESC":"");$e[]=$d;$re[]=($qe?:null);$Sb[]=$Rb;}}$Dc=$x[$B];if($Dc){ksort($Dc["columns"]);ksort($Dc["lengths"]);ksort($Dc["descs"]);if($w["type"]==$Dc["type"]&&array_values($Dc["columns"])===$e&&(!$Dc["lengths"]||array_values($Dc["lengths"])===$re)&&array_values($Dc["descs"])===$Sb){unset($x[$B]);continue;}}if($e)$c[]=array($w["type"],$B,$N);}}foreach($x
as$B=>$Dc)$c[]=array($Dc["type"],$B,"DROP");if(!$c)redirect(ME."table=".urlencode($a));queries_redirect(ME."table=".urlencode($a),'已修改索引。',alter_indexes($a,$c));}page_header('索引',$m,array("table"=>$a),h($a));$o=array_keys(fields($a));if($_POST["add"]){foreach($J["indexes"]as$y=>$w){if($w["columns"][count($w["columns"])]!="")$J["indexes"][$y]["columns"][]="";}$w=end($J["indexes"]);if($w["type"]||array_filter($w["columns"],'strlen'))$J["indexes"][]=array("columns"=>array(1=>""));}if(!$J){foreach($x
as$y=>$w){$x[$y]["name"]=$y;$x[$y]["columns"][]="";}$x[]=array("columns"=>array(1=>""));$J["indexes"]=$x;}$re=(JUSH=="sql"||JUSH=="mssql");$lh=($_POST?$_POST["options"]:get_setting("index_options"));echo'
<form action="" method="post">
<div class="scrollable">
<table class="nowrap">
<thead><tr>
<th id="label-type">索引類型
<th><input type="submit" class="wayoff">','欄位'.($re?"<span class='idxopts".($lh?"":" hidden")."'> (".'長度'.")</span>":"");if($re||support("descidx"))echo
checkbox("options",1,$lh,'選項',"indexOptionsShow(this.checked)","jsonly")."\n";echo'<th id="label-name">名稱
<th><noscript>',"<input type='image' class='icon' name='add[0]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=5.0.6")."' alt='+' title='".'新增下一筆'."'>",'</noscript>
</thead>
';if($F){echo"<tr><td>PRIMARY<td>";foreach($F["columns"]as$y=>$d)echo
select_input(" disabled",$o,$d),"<label><input disabled type='checkbox'>".'降冪 (遞減)'."</label> ";echo"<td><td>\n";}$ae=1;foreach($J["indexes"]as$w){if(!$_POST["drop_col"]||$ae!=key($_POST["drop_col"])){echo"<tr><td>".html_select("indexes[$ae][type]",array(-1=>"")+$Kd,$w["type"],($ae==count($J["indexes"])?"indexesAddRow.call(this);":""),"label-type"),"<td>";ksort($w["columns"]);$t=1;foreach($w["columns"]as$y=>$d){echo"<span>".select_input(" name='indexes[$ae][columns][$t]' title='".'欄位'."'",($o?array_combine($o,$o):$o),$d,"partial(".($t==count($w["columns"])?"indexesAddColumn":"indexesChangeColumn").", '".js_escape(JUSH=="sql"?"":$_GET["indexes"]."_")."')"),"<span class='idxopts".($lh?"":" hidden")."'>",($re?"<input type='number' name='indexes[$ae][lengths][$t]' class='size' value='".h($w["lengths"][$y])."' title='".'長度'."'>":""),(support("descidx")?checkbox("indexes[$ae][descs][$t]",1,$w["descs"][$y],'降冪 (遞減)'):""),"</span> </span>";$t++;}echo"<td><input name='indexes[$ae][name]' value='".h($w["name"])."' autocapitalize='off' aria-labelledby='label-name'>\n","<td><input type='image' class='icon' name='drop_col[$ae]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=5.0.6")."' alt='x' title='".'移除'."'>".script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");}$ae++;}echo'</table>
</div>
<p>
<input type="submit" value="儲存">
<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["database"])){$J=$_POST;if($_POST&&!$m&&!isset($_POST["add_x"])){$B=trim($J["name"]);if($_POST["drop"]){$_GET["db"]="";queries_redirect(remove_from_uri("db|database"),'資料庫已刪除。',drop_databases(array(DB)));}elseif(DB!==$B){if(DB!=""){$_GET["db"]=$B;queries_redirect(preg_replace('~\bdb=[^&]*&~','',ME)."db=".urlencode($B),'已重新命名資料庫。',rename_database($B,$J["collation"]));}else{$i=explode("\n",str_replace("\r","",$B));$Eh=true;$ke="";foreach($i
as$j){if(count($i)==1||$j!=""){if(!create_database($j,$J["collation"]))$Eh=false;$ke=$j;}}restart_session();set_session("dbs",null);queries_redirect(ME."db=".urlencode($ke),'已建立資料庫。',$Eh);}}else{if(!$J["collation"])redirect(substr(ME,0,-1));query_redirect("ALTER DATABASE ".idf_escape($B).(preg_match('~^[a-z0-9_]+$~i',$J["collation"])?" COLLATE $J[collation]":""),substr(ME,0,-1),'已修改資料庫。');}}page_header(DB!=""?'修改資料庫':'建立資料庫',$m,array(),h(DB));$gb=collations();$B=DB;if($_POST)$B=$J["name"];elseif(DB!="")$J["collation"]=db_collation(DB,$gb);elseif(JUSH=="sql"){foreach(get_vals("SHOW GRANTS")as$ld){if(preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~',$ld,$A)&&$A[1]){$B=stripcslashes(idf_unescape("`$A[2]`"));break;}}}echo'
<form action="" method="post">
<p>
',($_POST["add_x"]||strpos($B,"\n")?'<textarea autofocus name="name" rows="10" cols="40">'.h($B).'</textarea><br>':'<input name="name" autofocus value="'.h($B).'" data-maxlength="64" autocapitalize="off">')."\n".($gb?html_select("collation",array(""=>"(".'校對'.")")+$gb,$J["collation"]).doc_link(array('sql'=>"charset-charsets.html",'mariadb'=>"supported-character-sets-and-collations/",'mssql'=>"relational-databases/system-functions/sys-fn-helpcollations-transact-sql",)):""),'<input type="submit" value="儲存">
';if(DB!="")echo"<input type='submit' name='drop' value='".'刪除'."'>".confirm(sprintf('刪除 %s?',DB))."\n";elseif(!$_POST["add_x"]&&$_GET["db"]=="")echo"<input type='image' class='icon' name='add' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=5.0.6")."' alt='+' title='".'新增下一筆'."'>\n";echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["scheme"])){$J=$_POST;if($_POST&&!$m){$_=preg_replace('~ns=[^&]*&~','',ME)."ns=";if($_POST["drop"])query_redirect("DROP SCHEMA ".idf_escape($_GET["ns"]),$_,'已刪除資料表結構。');else{$B=trim($J["name"]);$_.=urlencode($B);if($_GET["ns"]=="")query_redirect("CREATE SCHEMA ".idf_escape($B),$_,'已建立資料表結構。');elseif($_GET["ns"]!=$B)query_redirect("ALTER SCHEMA ".idf_escape($_GET["ns"])." RENAME TO ".idf_escape($B),$_,'已修改資料表結構。');else
redirect($_);}}page_header($_GET["ns"]!=""?'修改資料表結構':'建立資料表結構',$m);if(!$J)$J["name"]=$_GET["ns"];echo'
<form action="" method="post">
<p><input name="name" autofocus value="',h($J["name"]),'" autocapitalize="off">
<input type="submit" value="儲存">
';if($_GET["ns"]!="")echo"<input type='submit' name='drop' value='".'刪除'."'>".confirm(sprintf('刪除 %s?',$_GET["ns"]))."\n";echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["call"])){$da=($_GET["name"]?:$_GET["call"]);page_header('呼叫'.": ".h($da),$m);$Mg=routine($_GET["call"],(isset($_GET["callf"])?"FUNCTION":"PROCEDURE"));$Hd=array();$If=array();foreach($Mg["fields"]as$t=>$n){if(substr($n["inout"],-3)=="OUT")$If[$t]="@".idf_escape($n["field"])." AS ".idf_escape($n["field"]);if(!$n["inout"]||substr($n["inout"],0,2)=="IN")$Hd[]=$t;}if(!$m&&$_POST){$Qa=array();foreach($Mg["fields"]as$y=>$n){if(in_array($y,$Hd)){$X=process_input($n);if($X===false)$X="''";if(isset($If[$y]))$f->query("SET @".idf_escape($n["field"])." = $X");}$Qa[]=(isset($If[$y])?"@".idf_escape($n["field"]):$X);}$G=(isset($_GET["callf"])?"SELECT":"CALL")." ".table($da)."(".implode(", ",$Qa).")";$_h=microtime(true);$H=$f->multi_query($G);$qa=$f->affected_rows;echo$b->selectQuery($G,$_h,!$H);if(!$H)echo"<p class='error'>".error()."\n";else{$g=connect($b->credentials());if(is_object($g))$g->select_db(DB);do{$H=$f->store_result();if(is_object($H))select($H,$g);else
echo"<p class='message'>".sprintf('程序已被執行，%d 行被影響。',$qa)." <span class='time'>".@date("H:i:s")."</span>\n";}while($f->next_result());if($If)select($f->query("SELECT ".implode(", ",$If)));}}echo'
<form action="" method="post">
';if($Hd){echo"<table class='layout'>\n";foreach($Hd
as$y){$n=$Mg["fields"][$y];$B=$n["field"];echo"<tr><th>".$b->fieldName($n);$Y=$_POST["fields"][$B];if($Y!=""){if($n["type"]=="set")$Y=implode(",",$Y);}input($n,$Y,(string)$_POST["function"][$B]);echo"\n";}echo"</table>\n";}echo'<p>
<input type="submit" value="呼叫">
<input type="hidden" name="token" value="',$T,'">
</form>

<pre>
';function
pre_tr($Qg){return
preg_replace('~^~m','<tr>',preg_replace('~\|~','<td>',preg_replace('~\|$~m',"",rtrim($Qg))));}$Q='(\+--[-+]+\+\n)';$J='(\| .* \|\n)';echo
preg_replace_callback("~^$Q?$J$Q?($J*)$Q?~m",function($A){$Uc=pre_tr($A[2]);return"<table>\n".($A[1]?"<thead>$Uc</thead>\n":$Uc).pre_tr($A[4])."\n</table>";},preg_replace('~(\n(    -|mysql)&gt; )(.+)~',"\\1<code class='jush-sql'>\\3</code>",preg_replace('~(.+)\n---+\n~',"<b>\\1</b>\n",h($Mg['comment']))));echo'</pre>
';}elseif(isset($_GET["foreign"])){$a=$_GET["foreign"];$B=$_GET["name"];$J=$_POST;if($_POST&&!$m&&!$_POST["add"]&&!$_POST["change"]&&!$_POST["change-js"]){if(!$_POST["drop"]){$J["source"]=array_filter($J["source"],'strlen');ksort($J["source"]);$Th=array();foreach($J["source"]as$y=>$X)$Th[$y]=$J["target"][$y];$J["target"]=$Th;}if(JUSH=="sqlite")$H=recreate_table($a,$a,array(),array(),array(" $B"=>($J["drop"]?"":" ".format_foreign_key($J))));else{$c="ALTER TABLE ".table($a);$H=($B==""||queries("$c DROP ".(JUSH=="sql"?"FOREIGN KEY ":"CONSTRAINT ").idf_escape($B)));if(!$J["drop"])$H=queries("$c ADD".format_foreign_key($J));}queries_redirect(ME."table=".urlencode($a),($J["drop"]?'已刪除外來鍵。':($B!=""?'已修改外來鍵。':'已建立外來鍵。')),$H);if(!$J["drop"])$m="$m<br>".'來源列和目標列必須具有相同的資料類型，在目標列上必須有一個索引並且引用的資料必須存在。';}page_header('外來鍵',$m,array("table"=>$a),h($a));if($_POST){ksort($J["source"]);if($_POST["add"])$J["source"][]="";elseif($_POST["change"]||$_POST["change-js"])$J["target"]=array();}elseif($B!=""){$cd=foreign_keys($a);$J=$cd[$B];$J["source"][]="";}else{$J["table"]=$a;$J["source"]=array("");}echo'
<form action="" method="post">
';$rh=array_keys(fields($a));if($J["db"]!="")$f->select_db($J["db"]);if($J["ns"]!=""){$Ef=get_schema();set_schema($J["ns"]);}$zg=array_keys(array_filter(table_status('',true),'Adminer\fk_support'));$Th=array_keys(fields(in_array($J["table"],$zg)?$J["table"]:reset($zg)));$pf="this.form['change-js'].value = '1'; this.form.submit();";echo"<p>".'目標資料表'.": ".html_select("table",$zg,$J["table"],$pf)."\n";if(support("scheme")){$Tg=array_filter($b->schemas(),function($Sg){return!preg_match('~^information_schema$~i',$Sg);});echo'資料表結構'.": ".html_select("ns",$Tg,$J["ns"]!=""?$J["ns"]:$_GET["ns"],$pf);if($J["ns"]!="")set_schema($Ef);}elseif(JUSH!="sqlite"){$Lb=array();foreach($b->databases()as$j){if(!information_schema($j))$Lb[]=$j;}echo'資料庫'.": ".html_select("db",$Lb,$J["db"]!=""?$J["db"]:$_GET["db"],$pf);}echo'<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="變更"></noscript>
<table>
<thead><tr><th id="label-source">來源<th id="label-target">目標</thead>
';$ae=0;foreach($J["source"]as$y=>$X){echo"<tr>","<td>".html_select("source[".(+$y)."]",array(-1=>"")+$rh,$X,($ae==count($J["source"])-1?"foreignAddRow.call(this);":""),"label-source"),"<td>".html_select("target[".(+$y)."]",$Th,$J["target"][$y],"","label-target");$ae++;}echo'</table>
<p>
ON DELETE: ',html_select("on_delete",array(-1=>"")+explode("|",$l->onActions),$J["on_delete"]),' ON UPDATE: ',html_select("on_update",array(-1=>"")+explode("|",$l->onActions),$J["on_update"]),doc_link(array('sql'=>"innodb-foreign-key-constraints.html",'mariadb'=>"foreign-keys/",'pgsql'=>"sql-createtable.html#SQL-CREATETABLE-REFERENCES",'mssql'=>"t-sql/statements/create-table-transact-sql",'oracle'=>"SQLRF01111",)),'<p>
<input type="submit" value="儲存">
<noscript><p><input type="submit" name="add" value="新增欄位"></noscript>
';if($B!="")echo'<input type="submit" name="drop" value="刪除">',confirm(sprintf('刪除 %s?',$B));echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["view"])){$a=$_GET["view"];$J=$_POST;$Ff="VIEW";if(JUSH=="pgsql"&&$a!=""){$O=table_status($a);$Ff=strtoupper($O["Engine"]);}if($_POST&&!$m){$B=trim($J["name"]);$wa=" AS\n$J[select]";$ue=ME."table=".urlencode($B);$Je='已修改檢視表。';$U=($_POST["materialized"]?"MATERIALIZED VIEW":"VIEW");if(!$_POST["drop"]&&$a==$B&&JUSH!="sqlite"&&$U=="VIEW"&&$Ff=="VIEW")query_redirect((JUSH=="mssql"?"ALTER":"CREATE OR REPLACE")." VIEW ".table($B).$wa,$ue,$Je);else{$Vh=$B."_adminer_".uniqid();drop_create("DROP $Ff ".table($a),"CREATE $U ".table($B).$wa,"DROP $U ".table($B),"CREATE $U ".table($Vh).$wa,"DROP $U ".table($Vh),($_POST["drop"]?substr(ME,0,-1):$ue),'已刪除檢視表。',$Je,'已建立檢視表。',$a,$B);}}if(!$_POST&&$a!=""){$J=view($a);$J["name"]=$a;$J["materialized"]=($Ff!="VIEW");if(!$m)$m=error();}page_header(($a!=""?'修改檢視表':'建立檢視表'),$m,array("table"=>$a),h($a));echo'
<form action="" method="post">
<p>名稱: <input name="name" value="',h($J["name"]),'" data-maxlength="64" autocapitalize="off">
',(support("materializedview")?" ".checkbox("materialized",1,$J["materialized"],'物化視圖'):""),'<p>';textarea("select",$J["select"]);echo'<p>
<input type="submit" value="儲存">
';if($a!="")echo'<input type="submit" name="drop" value="刪除">',confirm(sprintf('刪除 %s?',$a));echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["event"])){$aa=$_GET["event"];$Sd=array("YEAR","QUARTER","MONTH","DAY","HOUR","MINUTE","WEEK","SECOND","YEAR_MONTH","DAY_HOUR","DAY_MINUTE","DAY_SECOND","HOUR_MINUTE","HOUR_SECOND","MINUTE_SECOND");$Ah=array("ENABLED"=>"ENABLE","DISABLED"=>"DISABLE","SLAVESIDE_DISABLED"=>"DISABLE ON SLAVE");$J=$_POST;if($_POST&&!$m){if($_POST["drop"])query_redirect("DROP EVENT ".idf_escape($aa),substr(ME,0,-1),'已刪除事件。');elseif(in_array($J["INTERVAL_FIELD"],$Sd)&&isset($Ah[$J["STATUS"]])){$Rg="\nON SCHEDULE ".($J["INTERVAL_VALUE"]?"EVERY ".q($J["INTERVAL_VALUE"])." $J[INTERVAL_FIELD]".($J["STARTS"]?" STARTS ".q($J["STARTS"]):"").($J["ENDS"]?" ENDS ".q($J["ENDS"]):""):"AT ".q($J["STARTS"]))." ON COMPLETION".($J["ON_COMPLETION"]?"":" NOT")." PRESERVE";queries_redirect(substr(ME,0,-1),($aa!=""?'已修改事件。':'已建立事件。'),queries(($aa!=""?"ALTER EVENT ".idf_escape($aa).$Rg.($aa!=$J["EVENT_NAME"]?"\nRENAME TO ".idf_escape($J["EVENT_NAME"]):""):"CREATE EVENT ".idf_escape($J["EVENT_NAME"]).$Rg)."\n".$Ah[$J["STATUS"]]." COMMENT ".q($J["EVENT_COMMENT"]).rtrim(" DO\n$J[EVENT_DEFINITION]",";").";"));}}page_header(($aa!=""?'修改事件'.": ".h($aa):'建立事件'),$m);if(!$J&&$aa!=""){$K=get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = ".q(DB)." AND EVENT_NAME = ".q($aa));$J=reset($K);}echo'
<form action="" method="post">
<table class="layout">
<tr><th>名稱<td><input name="EVENT_NAME" value="',h($J["EVENT_NAME"]),'" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">開始<td><input name="STARTS" value="',h("$J[EXECUTE_AT]$J[STARTS]"),'">
<tr><th title="datetime">結束<td><input name="ENDS" value="',h($J["ENDS"]),'">
<tr><th>每<td><input type="number" name="INTERVAL_VALUE" value="',h($J["INTERVAL_VALUE"]),'" class="size"> ',html_select("INTERVAL_FIELD",$Sd,$J["INTERVAL_FIELD"]),'<tr><th>狀態<td>',html_select("STATUS",$Ah,$J["STATUS"]),'<tr><th>註解<td><input name="EVENT_COMMENT" value="',h($J["EVENT_COMMENT"]),'" data-maxlength="64">
<tr><th><td>',checkbox("ON_COMPLETION","PRESERVE",$J["ON_COMPLETION"]=="PRESERVE",'在完成後儲存'),'</table>
<p>';textarea("EVENT_DEFINITION",$J["EVENT_DEFINITION"]);echo'<p>
<input type="submit" value="儲存">
';if($aa!="")echo'<input type="submit" name="drop" value="刪除">',confirm(sprintf('刪除 %s?',$aa));echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["procedure"])){$da=($_GET["name"]?:$_GET["procedure"]);$Mg=(isset($_GET["function"])?"FUNCTION":"PROCEDURE");$J=$_POST;$J["fields"]=(array)$J["fields"];if($_POST&&!process_fields($J["fields"])&&!$m){$Bf=routine($_GET["procedure"],$Mg);$Vh="$J[name]_adminer_".uniqid();drop_create("DROP $Mg ".routine_id($da,$Bf),create_routine($Mg,$J),"DROP $Mg ".routine_id($J["name"],$J),create_routine($Mg,array("name"=>$Vh)+$J),"DROP $Mg ".routine_id($Vh,$J),substr(ME,0,-1),'已刪除程序。','已修改子程序。','已建立子程序。',$da,$J["name"]);}page_header(($da!=""?(isset($_GET["function"])?'修改函式':'修改預存程序').": ".h($da):(isset($_GET["function"])?'建立函式':'建立預存程序')),$m);if(!$_POST&&$da!=""){$J=routine($_GET["procedure"],$Mg);$J["name"]=$da;}$gb=get_vals("SHOW CHARACTER SET");sort($gb);$Ng=routine_languages();echo($gb?"<datalist id='collations'>".optionlist($gb)."</datalist>":""),'
<form action="" method="post" id="form">
<p>名稱: <input name="name" value="',h($J["name"]),'" data-maxlength="64" autocapitalize="off">
',($Ng?'語言'.": ".html_select("language",$Ng,$J["language"])."\n":""),'<input type="submit" value="儲存">
<div class="scrollable">
<table class="nowrap">
';edit_fields($J["fields"],$gb,$Mg);if(isset($_GET["function"])){echo"<tr><td>".'回傳類型';edit_type("returns",$J["returns"],$gb,array(),(JUSH=="pgsql"?array("void","trigger"):array()));}echo'</table>
',script("editFields();"),'</div>
<p>';textarea("definition",$J["definition"]);echo'<p>
<input type="submit" value="儲存">
';if($da!="")echo'<input type="submit" name="drop" value="刪除">',confirm(sprintf('刪除 %s?',$da));echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["sequence"])){$fa=$_GET["sequence"];$J=$_POST;if($_POST&&!$m){$_=substr(ME,0,-1);$B=trim($J["name"]);if($_POST["drop"])query_redirect("DROP SEQUENCE ".idf_escape($fa),$_,'已刪除序列。');elseif($fa=="")query_redirect("CREATE SEQUENCE ".idf_escape($B),$_,'已建立序列。');elseif($fa!=$B)query_redirect("ALTER SEQUENCE ".idf_escape($fa)." RENAME TO ".idf_escape($B),$_,'已修改序列。');else
redirect($_);}page_header($fa!=""?'修改序列'.": ".h($fa):'建立序列',$m);if(!$J)$J["name"]=$fa;echo'
<form action="" method="post">
<p><input name="name" value="',h($J["name"]),'" autocapitalize="off">
<input type="submit" value="儲存">
';if($fa!="")echo"<input type='submit' name='drop' value='".'刪除'."'>".confirm(sprintf('刪除 %s?',$fa))."\n";echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["type"])){$ga=$_GET["type"];$J=$_POST;if($_POST&&!$m){$_=substr(ME,0,-1);if($_POST["drop"])query_redirect("DROP TYPE ".idf_escape($ga),$_,'已刪除類型。');else
query_redirect("CREATE TYPE ".idf_escape(trim($J["name"]))." $J[as]",$_,'已建立類型。');}page_header($ga!=""?'修改類型'.": ".h($ga):'建立類型',$m);if(!$J)$J["as"]="AS ";echo'
<form action="" method="post">
<p>
';if($ga!=""){$xi=$l->types();$vc=type_values($xi[$ga]);if($vc)echo"<code class='jush-".JUSH."'>ENUM (".h($vc).")</code>\n<p>";echo"<input type='submit' name='drop' value='".'刪除'."'>".confirm(sprintf('刪除 %s?',$ga))."\n";}else{echo'名稱'.": <input name='name' value='".h($J['name'])."' autocapitalize='off'>\n",doc_link(array('pgsql'=>"datatype-enum.html",),"?");textarea("as",$J["as"]);echo"<p><input type='submit' value='".'儲存'."'>\n";}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["check"])){$a=$_GET["check"];$B=$_GET["name"];$J=$_POST;if($J&&!$m){if(JUSH=="sqlite")$H=recreate_table($a,$a,array(),array(),array(),0,array(),$B,($J["drop"]?"":$J["clause"]));else{$H=($B==""||queries("ALTER TABLE ".table($a)." DROP CONSTRAINT ".idf_escape($B)));if(!$J["drop"])$H=queries("ALTER TABLE ".table($a)." ADD".($J["name"]!=""?" CONSTRAINT ".idf_escape($J["name"]):"")." CHECK ($J[clause])");}queries_redirect(ME."table=".urlencode($a),($J["drop"]?'Check has been dropped.':($B!=""?'Check has been altered.':'Check has been created.')),$H);}page_header(($B!=""?'Alter check'.": ".h($B):'Create check'),$m,array("table"=>$a));if(!$J){$Xa=$l->checkConstraints($a);$J=array("name"=>$B,"clause"=>$Xa[$B]);}echo'
<form action="" method="post">
<p>';if(JUSH!="sqlite")echo'名稱'.': <input name="name" value="'.h($J["name"]).'" data-maxlength="64" autocapitalize="off"> ';echo
doc_link(array('sql'=>"create-table-check-constraints.html",'mariadb'=>"constraint/",'pgsql'=>"ddl-constraints.html#DDL-CONSTRAINTS-CHECK-CONSTRAINTS",'mssql'=>"relational-databases/tables/create-check-constraints",'sqlite'=>"lang_createtable.html#check_constraints",),"?"),'<p>';textarea("clause",$J["clause"]);echo'<p><input type="submit" value="儲存">
';if($B!="")echo'<input type="submit" name="drop" value="刪除">',confirm(sprintf('刪除 %s?',$B));echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["trigger"])){$a=$_GET["trigger"];$B=$_GET["name"];$ti=trigger_options();$J=(array)trigger($B,$a)+array("Trigger"=>$a."_bi");if($_POST){if(!$m&&in_array($_POST["Timing"],$ti["Timing"])&&in_array($_POST["Event"],$ti["Event"])&&in_array($_POST["Type"],$ti["Type"])){$mf=" ON ".table($a);$ac="DROP TRIGGER ".idf_escape($B).(JUSH=="pgsql"?$mf:"");$ue=ME."table=".urlencode($a);if($_POST["drop"])query_redirect($ac,$ue,'已刪除觸發器。');else{if($B!="")queries($ac);queries_redirect($ue,($B!=""?'已修改觸發器。':'已建立觸發器。'),queries(create_trigger($mf,$_POST)));if($B!="")queries(create_trigger($mf,$J+array("Type"=>reset($ti["Type"]))));}}$J=$_POST;}page_header(($B!=""?'修改觸發器'.": ".h($B):'建立觸發器'),$m,array("table"=>$a));echo'
<form action="" method="post" id="form">
<table class="layout">
<tr><th>時間<td>',html_select("Timing",$ti["Timing"],$J["Timing"],"triggerChange(/^".preg_quote($a,"/")."_[ba][iud]$/, '".js_escape($a)."', this.form);"),'<tr><th>事件<td>',html_select("Event",$ti["Event"],$J["Event"],"this.form['Timing'].onchange();"),(in_array("UPDATE OF",$ti["Event"])?" <input name='Of' value='".h($J["Of"])."' class='hidden'>":""),'<tr><th>類型<td>',html_select("Type",$ti["Type"],$J["Type"]),'</table>
<p>名稱: <input name="Trigger" value="',h($J["Trigger"]),'" data-maxlength="64" autocapitalize="off">
',script("qs('#form')['Timing'].onchange();"),'<p>';textarea("Statement",$J["Statement"]);echo'<p>
<input type="submit" value="儲存">
';if($B!="")echo'<input type="submit" name="drop" value="刪除">',confirm(sprintf('刪除 %s?',$B));echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["user"])){$ha=$_GET["user"];$ng=array(""=>array("All privileges"=>""));foreach(get_rows("SHOW PRIVILEGES")as$J){foreach(explode(",",($J["Privilege"]=="Grant option"?"":$J["Context"]))as$vb)$ng[$vb][$J["Privilege"]]=$J["Comment"];}$ng["Server Admin"]+=$ng["File access on server"];$ng["Databases"]["Create routine"]=$ng["Procedures"]["Create routine"];unset($ng["Procedures"]["Create routine"]);$ng["Columns"]=array();foreach(array("Select","Insert","Update","References")as$X)$ng["Columns"][$X]=$ng["Tables"][$X];unset($ng["Server Admin"]["Usage"]);foreach($ng["Tables"]as$y=>$X)unset($ng["Databases"][$y]);$We=array();if($_POST){foreach($_POST["objects"]as$y=>$X)$We[$X]=(array)$We[$X]+(array)$_POST["grants"][$y];}$md=array();$kf="";if(isset($_GET["host"])&&($H=$f->query("SHOW GRANTS FOR ".q($ha)."@".q($_GET["host"])))){while($J=$H->fetch_row()){if(preg_match('~GRANT (.*) ON (.*) TO ~',$J[0],$A)&&preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~',$A[1],$Ae,PREG_SET_ORDER)){foreach($Ae
as$X){if($X[1]!="USAGE")$md["$A[2]$X[2]"][$X[1]]=true;if(preg_match('~ WITH GRANT OPTION~',$J[0]))$md["$A[2]$X[2]"]["GRANT OPTION"]=true;}}if(preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~",$J[0],$A))$kf=$A[1];}}if($_POST&&!$m){$lf=(isset($_GET["host"])?q($ha)."@".q($_GET["host"]):"''");if($_POST["drop"])query_redirect("DROP USER $lf",ME."privileges=",'已刪除使用者。');else{$Ye=q($_POST["user"])."@".q($_POST["host"]);$Vf=$_POST["pass"];if($Vf!=''&&!$_POST["hashed"]&&!min_version(8)){$Vf=get_val("SELECT PASSWORD(".q($Vf).")");$m=!$Vf;}$_b=false;if(!$m){if($lf!=$Ye){$_b=queries((min_version(5)?"CREATE USER":"GRANT USAGE ON *.* TO")." $Ye IDENTIFIED BY ".(min_version(8)?"":"PASSWORD ").q($Vf));$m=!$_b;}elseif($Vf!=$kf)queries("SET PASSWORD FOR $Ye = ".q($Vf));}if(!$m){$Jg=array();foreach($We
as$ef=>$ld){if(isset($_GET["grant"]))$ld=array_filter($ld);$ld=array_keys($ld);if(isset($_GET["grant"]))$Jg=array_diff(array_keys(array_filter($We[$ef],'strlen')),$ld);elseif($lf==$Ye){$if=array_keys((array)$md[$ef]);$Jg=array_diff($if,$ld);$ld=array_diff($ld,$if);unset($md[$ef]);}if(preg_match('~^(.+)\s*(\(.*\))?$~U',$ef,$A)&&(!grant("REVOKE",$Jg,$A[2]," ON $A[1] FROM $Ye")||!grant("GRANT",$ld,$A[2]," ON $A[1] TO $Ye"))){$m=true;break;}}}if(!$m&&isset($_GET["host"])){if($lf!=$Ye)queries("DROP USER $lf");elseif(!isset($_GET["grant"])){foreach($md
as$ef=>$Jg){if(preg_match('~^(.+)(\(.*\))?$~U',$ef,$A))grant("REVOKE",array_keys($Jg),$A[2]," ON $A[1] FROM $Ye");}}}queries_redirect(ME."privileges=",(isset($_GET["host"])?'已修改使用者。':'已建立使用者。'),!$m);if($_b)$f->query("DROP USER $Ye");}}page_header((isset($_GET["host"])?'帳號'.": ".h("$ha@$_GET[host]"):'建立使用者'),$m,array("privileges"=>array('','權限')));$J=$_POST;if($J)$md=$We;else{$J=$_GET+array("host"=>get_val("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)"));$J["pass"]=$kf;if($kf!="")$J["hashed"]=true;$md[(DB==""||$md?"":idf_escape(addcslashes(DB,"%_\\"))).".*"]=array();}echo'<form action="" method="post">
<table class="layout">
<tr><th>伺服器<td><input name="host" data-maxlength="60" value="',h($J["host"]),'" autocapitalize="off">
<tr><th>帳號<td><input name="user" data-maxlength="80" value="',h($J["user"]),'" autocapitalize="off">
<tr><th>密碼<td><input name="pass" id="pass" value="',h($J["pass"]),'" autocomplete="new-password">
',($J["hashed"]?"":script("typePassword(qs('#pass'));")),(min_version(8)?"":checkbox("hashed",1,$J["hashed"],'Hashed',"typePassword(this.form['pass'], this.checked);")),'</table>

',"<table class='odds'>\n","<thead><tr><th colspan='2'>".'權限'.doc_link(array('sql'=>"grant.html#priv_level"));$t=0;foreach($md
as$ef=>$ld){echo'<th>'.($ef!="*.*"?"<input name='objects[$t]' value='".h($ef)."' size='10' autocapitalize='off'>":"<input type='hidden' name='objects[$t]' value='*.*' size='10'>*.*");$t++;}echo"</thead>\n";foreach(array(""=>"","Server Admin"=>'伺服器',"Databases"=>'資料庫',"Tables"=>'資料表',"Columns"=>'欄位',"Procedures"=>'程序',)as$vb=>$Rb){foreach((array)$ng[$vb]as$mg=>$lb){echo"<tr><td".($Rb?">$Rb<td":" colspan='2'").' lang="en" title="'.h($lb).'">'.h($mg);$t=0;foreach($md
as$ef=>$ld){$B="'grants[$t][".h(strtoupper($mg))."]'";$Y=$ld[strtoupper($mg)];if($vb=="Server Admin"&&$ef!=(isset($md["*.*"])?"*.*":".*"))echo"<td>";elseif(isset($_GET["grant"]))echo"<td><select name=$B><option><option value='1'".($Y?" selected":"").">".'授權'."<option value='0'".($Y=="0"?" selected":"").">".'廢除'."</select>";else
echo"<td align='center'><label class='block'>","<input type='checkbox' name=$B value='1'".($Y?" checked":"").($mg=="All privileges"?" id='grants-$t-all'>":">".($mg=="Grant option"?"":script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$t-all'); };"))),"</label>";$t++;}}}echo"</table>\n",'<p>
<input type="submit" value="儲存">
';if(isset($_GET["host"]))echo'<input type="submit" name="drop" value="刪除">',confirm(sprintf('刪除 %s?',"$ha@$_GET[host]"));echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["processlist"])){if(support("kill")){if($_POST&&!$m){$ge=0;foreach((array)$_POST["kill"]as$X){if(kill_process($X))$ge++;}queries_redirect(ME."processlist=",sprintf('%d 個 Process(es) 被終止。',$ge),$ge||!$_POST["kill"]);}}page_header('處理程序列表',$m);echo'
<form action="" method="post">
<div class="scrollable">
<table class="nowrap checkable odds">
',script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");$t=-1;foreach(process_list()as$t=>$J){if(!$t){echo"<thead><tr lang='en'>".(support("kill")?"<th>":"");foreach($J
as$y=>$X)echo"<th>$y".doc_link(array('sql'=>"show-processlist.html#processlist_".strtolower($y),'pgsql'=>"monitoring-stats.html#PG-STAT-ACTIVITY-VIEW",'oracle'=>"REFRN30223",));echo"</thead>\n";}echo"<tr>".(support("kill")?"<td>".checkbox("kill[]",$J[JUSH=="sql"?"Id":"pid"],0):"");foreach($J
as$y=>$X)echo"<td>".((JUSH=="sql"&&$y=="Info"&&preg_match("~Query|Killed~",$J["Command"])&&$X!="")||(JUSH=="pgsql"&&$y=="current_query"&&$X!="<IDLE>")||(JUSH=="oracle"&&$y=="sql_text"&&$X!="")?"<code class='jush-".JUSH."'>".shorten_utf8($X,100,"</code>").' <a href="'.h(ME.($J["db"]!=""?"db=".urlencode($J["db"])."&":"")."sql=".urlencode($X)).'">'.'複製'.'</a>':h($X));echo"\n";}echo'</table>
</div>
<p>
';if(support("kill"))echo($t+1)."/".sprintf('總共 %d 個',max_connections()),"<p><input type='submit' value='".'終止'."'>\n";echo'<input type="hidden" name="token" value="',$T,'">
</form>
',script("tableCheck();");}elseif(isset($_GET["select"])){$a=$_GET["select"];$R=table_status1($a);$x=indexes($a);$o=fields($a);$cd=column_foreign_keys($a);$gf=$R["Oid"];$pa=get_settings("adminer_import");$Kg=array();$e=array();$Wg=array();$yf=array();$Zh=null;foreach($o
as$y=>$n){$B=$b->fieldName($n);$Ue=html_entity_decode(strip_tags($B),ENT_QUOTES);if(isset($n["privileges"]["select"])&&$B!=""){$e[$y]=$Ue;if(is_shortable($n))$Zh=$b->selectLengthProcess();}if(isset($n["privileges"]["where"])&&$B!="")$Wg[$y]=$Ue;if(isset($n["privileges"]["order"])&&$B!="")$yf[$y]=$Ue;$Kg+=$n["privileges"];}list($L,$nd)=$b->selectColumnsProcess($e,$x);$L=array_unique($L);$nd=array_unique($nd);$Wd=count($nd)<count($L);$Z=$b->selectSearchProcess($o,$x);$xf=$b->selectOrderProcess($o,$x);$z=$b->selectLimitProcess();if($_GET["val"]&&is_ajax()){header("Content-Type: text/plain; charset=utf-8");foreach($_GET["val"]as$Bi=>$J){$wa=convert_field($o[key($J)]);$L=array($wa?:idf_escape(key($J)));$Z[]=where_check($Bi,$o);$I=$l->select($a,$L,$Z,$L);if($I)echo
reset($I->fetch_row());}exit;}$F=$Di=null;foreach($x
as$w){if($w["type"]=="PRIMARY"){$F=array_flip($w["columns"]);$Di=($L?$F:array());foreach($Di
as$y=>$X){if(in_array(idf_escape($y),$L))unset($Di[$y]);}break;}}if($gf&&!$F){$F=$Di=array($gf=>0);$x[]=array("type"=>"PRIMARY","columns"=>array($gf));}if($_POST&&!$m){$bj=$Z;if(!$_POST["all"]&&is_array($_POST["check"])){$Xa=array();foreach($_POST["check"]as$Ta)$Xa[]=where_check($Ta,$o);$bj[]="((".implode(") OR (",$Xa)."))";}$bj=($bj?"\nWHERE ".implode(" AND ",$bj):"");if($_POST["export"]){save_settings(array("output"=>$_POST["output"],"format"=>$_POST["format"]),"adminer_import");dump_headers($a);$b->dumpTable($a,"");$gd=($L?implode(", ",$L):"*").convert_fields($e,$o,$L)."\nFROM ".table($a);$pd=($nd&&$Wd?"\nGROUP BY ".implode(", ",$nd):"").($xf?"\nORDER BY ".implode(", ",$xf):"");$G="SELECT $gd$bj$pd";if(is_array($_POST["check"])&&!$F){$_i=array();foreach($_POST["check"]as$X)$_i[]="(SELECT".limit($gd,"\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$o).$pd,1).")";$G=implode(" UNION ALL ",$_i);}$b->dumpData($a,"table",$G);$b->dumpFooter();exit;}if(!$b->selectEmailProcess($Z,$cd)){if($_POST["save"]||$_POST["delete"]){$H=true;$qa=0;$N=array();if(!$_POST["delete"]){foreach($_POST["fields"]as$B=>$X){$X=process_input($o[$B]);if($X!==null&&($_POST["clone"]||$X!==false))$N[idf_escape($B)]=($X!==false?$X:idf_escape($B));}}if($_POST["delete"]||$N){if($_POST["clone"])$G="INTO ".table($a)." (".implode(", ",array_keys($N)).")\nSELECT ".implode(", ",$N)."\nFROM ".table($a);if($_POST["all"]||($F&&is_array($_POST["check"]))||$Wd){$H=($_POST["delete"]?$l->delete($a,$bj):($_POST["clone"]?queries("INSERT $G$bj"):$l->update($a,$N,$bj)));$qa=$f->affected_rows;}else{foreach((array)$_POST["check"]as$X){$aj="\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$o);$H=($_POST["delete"]?$l->delete($a,$aj,1):($_POST["clone"]?queries("INSERT".limit1($a,$G,$aj)):$l->update($a,$N,$aj,1)));if(!$H)break;$qa+=$f->affected_rows;}}}$Je=sprintf('%d 個項目受到影響。',$qa);if($_POST["clone"]&&$H&&$qa==1){$le=last_id();if($le)$Je=sprintf('已新增項目 %s。'," $le");}queries_redirect(remove_from_uri($_POST["all"]&&$_POST["delete"]?"page":""),$Je,$H);if(!$_POST["delete"]){$gg=(array)$_POST["fields"];edit_form($a,array_intersect_key($o,$gg),$gg,!$_POST["clone"]);page_footer();exit;}}elseif(!$_POST["import"]){if(!$_POST["val"])$m='按住Ctrl並按一下某個值進行修改。';else{$H=true;$qa=0;foreach($_POST["val"]as$Bi=>$J){$N=array();foreach($J
as$y=>$X){$y=bracket_escape($y,1);$N[idf_escape($y)]=(preg_match('~char|text~',$o[$y]["type"])||$X!=""?$b->processInput($o[$y],$X):"NULL");}$H=$l->update($a,$N," WHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($Bi,$o),!$Wd&&!$F," ");if(!$H)break;$qa+=$f->affected_rows;}queries_redirect(remove_from_uri(),sprintf('%d 個項目受到影響。',$qa),$H);}}elseif(!is_string($Rc=get_file("csv_file",true)))$m=upload_error($Rc);elseif(!preg_match('~~u',$Rc))$m='檔必須使用UTF-8編碼。';else{save_settings(array("output"=>$pa["output"],"format"=>$_POST["separator"]),"adminer_import");$H=true;$hb=array_keys($o);preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~',$Rc,$Ae);$qa=count($Ae[0]);$l->begin();$ch=($_POST["separator"]=="csv"?",":($_POST["separator"]=="tsv"?"\t":";"));$K=array();foreach($Ae[0]as$y=>$X){preg_match_all("~((?>\"[^\"]*\")+|[^$ch]*)$ch~",$X.$ch,$Be);if(!$y&&!array_diff($Be[1],$hb)){$hb=$Be[1];$qa--;}else{$N=array();foreach($Be[1]as$t=>$db)$N[idf_escape($hb[$t])]=($db==""&&$o[$hb[$t]]["null"]?"NULL":q(preg_match('~^".*"$~s',$db)?str_replace('""','"',substr($db,1,-1)):$db));$K[]=$N;}}$H=(!$K||$l->insertUpdate($a,$K,$F));if($H)$l->commit();queries_redirect(remove_from_uri("page"),sprintf('已匯入 %d 行。',$qa),$H);$l->rollback();}}}$Lh=$b->tableName($R);if(is_ajax()){page_headers();ob_start();}else
page_header('選擇'.": $Lh",$m);$N=null;if(isset($Kg["insert"])||!support("table")){$Of=array();foreach((array)$_GET["where"]as$X){if(isset($cd[$X["col"]])&&count($cd[$X["col"]])==1&&($X["op"]=="="||(!$X["op"]&&(is_array($X["val"])||!preg_match('~[_%]~',$X["val"])))))$Of["set"."[".bracket_escape($X["col"])."]"]=$X["val"];}$N=$Of?"&".http_build_query($Of):"";}$b->selectLinks($R,$N);if(!$e&&support("table"))echo"<p class='error'>".'無法選擇該資料表'.($o?".":": ".error())."\n";else{echo"<form action='' id='form'>\n","<div style='display: none;'>";hidden_fields_get();echo(DB!=""?'<input type="hidden" name="db" value="'.h(DB).'">'.(isset($_GET["ns"])?'<input type="hidden" name="ns" value="'.h($_GET["ns"]).'">':""):""),'<input type="hidden" name="select" value="'.h($a).'">',"</div>\n";$b->selectColumnsPrint($L,$e);$b->selectSearchPrint($Z,$Wg,$x);$b->selectOrderPrint($xf,$yf,$x);$b->selectLimitPrint($z);$b->selectLengthPrint($Zh);$b->selectActionPrint($x);echo"</form>\n";$D=$_GET["page"];if($D=="last"){$fd=get_val(count_rows($a,$Z,$Wd,$nd));$D=floor(max(0,$fd-1)/$z);}$Xg=$L;$od=$nd;if(!$Xg){$Xg[]="*";$wb=convert_fields($e,$o,$L);if($wb)$Xg[]=substr($wb,2);}foreach($L
as$y=>$X){$n=$o[idf_unescape($X)];if($n&&($wa=convert_field($n)))$Xg[$y]="$wa AS $X";}if(!$Wd&&$Di){foreach($Di
as$y=>$X){$Xg[]=idf_escape($y);if($od)$od[]=idf_escape($y);}}$H=$l->select($a,$Xg,$Z,$od,$xf,$z,$D,true);if(!$H)echo"<p class='error'>".error()."\n";else{if(JUSH=="mssql"&&$D)$H->seek($z*$D);$oc=array();echo"<form action='' method='post' enctype='multipart/form-data'>\n";$K=array();while($J=$H->fetch_assoc()){if($D&&JUSH=="oracle")unset($J["RNUM"]);$K[]=$J;}if($_GET["page"]!="last"&&$z!=""&&$nd&&$Wd&&JUSH=="sql")$fd=get_val(" SELECT FOUND_ROWS()");if(!$K)echo"<p class='message'>".'沒有資料行。'."\n";else{$Ea=$b->backwardKeys($a,$Lh);echo"<div class='scrollable'>","<table id='table' class='nowrap checkable odds'>",script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"),"<thead><tr>".(!$nd&&$L?"":"<td><input type='checkbox' id='all-page' class='jsonly'>".script("qs('#all-page').onclick = partial(formCheck, /check/);","")." <a href='".h($_GET["modify"]?remove_from_uri("modify"):$_SERVER["REQUEST_URI"]."&modify=1")."'>".'修改'."</a>");$Ve=array();$id=array();reset($L);$wg=1;foreach($K[0]as$y=>$X){if(!isset($Di[$y])){$X=$_GET["columns"][key($L)];$n=$o[$L?($X?$X["col"]:current($L)):$y];$B=($n?$b->fieldName($n,$wg):($X["fun"]?"*":h($y)));if($B!=""){$wg++;$Ve[$y]=$B;$d=idf_escape($y);$Bd=remove_from_uri('(order|desc)[^=]*|page').'&order%5B0%5D='.urlencode($y);$Rb="&desc%5B0%5D=1";$qh=isset($n["privileges"]["order"]);echo"<th id='th[".h(bracket_escape($y))."]'>".script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});","");$hd=apply_sql_function($X["fun"],$B);echo($qh?'<a href="'.h($Bd.($xf[0]==$d||$xf[0]==$y||(!$xf&&$Wd&&$nd[0]==$d)?$Rb:'')).'">'."$hd</a>":$hd),"<span class='column hidden'>";if($qh)echo"<a href='".h($Bd.$Rb)."' title='".'降冪 (遞減)'."' class='text'> ↓</a>";if(!$X["fun"]&&isset($n["privileges"]["where"]))echo'<a href="#fieldset-search" title="'.'搜尋'.'" class="text jsonly"> =</a>',script("qsl('a').onclick = partial(selectSearch, '".js_escape($y)."');");echo"</span>";}$id[$y]=$X["fun"];next($L);}}$re=array();if($_GET["modify"]){foreach($K
as$J){foreach($J
as$y=>$X)$re[$y]=max($re[$y],min(40,strlen(utf8_decode($X))));}}echo($Ea?"<th>".'關聯':"")."</thead>\n";if(is_ajax())ob_end_clean();foreach($b->rowDescriptions($K,$cd)as$Te=>$J){$Ai=unique_array($K[$Te],$x);if(!$Ai){$Ai=array();foreach($K[$Te]as$y=>$X){if(!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~',$y))$Ai[$y]=$X;}}$Bi="";foreach($Ai
as$y=>$X){if((JUSH=="sql"||JUSH=="pgsql")&&preg_match('~char|text|enum|set~',$o[$y]["type"])&&strlen($X)>64){$y=(strpos($y,'(')?$y:idf_escape($y));$y="MD5(".(JUSH!='sql'||preg_match("~^utf8~",$o[$y]["collation"])?$y:"CONVERT($y USING ".charset($f).")").")";$X=md5($X);}$Bi.="&".($X!==null?urlencode("where[".bracket_escape($y)."]")."=".urlencode($X===false?"f":$X):"null%5B%5D=".urlencode($y));}echo"<tr>".(!$nd&&$L?"":"<td>".checkbox("check[]",substr($Bi,1),in_array(substr($Bi,1),(array)$_POST["check"])).($Wd||information_schema(DB)?"":" <a href='".h(ME."edit=".urlencode($a).$Bi)."' class='edit'>".'編輯'."</a>"));foreach($J
as$y=>$X){if(isset($Ve[$y])){$n=$o[$y];$X=$l->value($X,$n);if($X!=""&&(!isset($oc[$y])||$oc[$y]!=""))$oc[$y]=(is_mail($X)?$Ve[$y]:"");$_="";if(preg_match('~blob|bytea|raw|file~',$n["type"])&&$X!="")$_=ME.'download='.urlencode($a).'&field='.urlencode($y).$Bi;if(!$_&&$X!==null){foreach((array)$cd[$y]as$q){if(count($cd[$y])==1||end($q["source"])==$y){$_="";foreach($q["source"]as$t=>$rh)$_.=where_link($t,$q["target"][$t],$K[$Te][$rh]);$_=($q["db"]!=""?preg_replace('~([?&]db=)[^&]+~','\1'.urlencode($q["db"]),ME):ME).'select='.urlencode($q["table"]).$_;if($q["ns"])$_=preg_replace('~([?&]ns=)[^&]+~','\1'.urlencode($q["ns"]),$_);if(count($q["source"])==1)break;}}}if($y=="COUNT(*)"){$_=ME."select=".urlencode($a);$t=0;foreach((array)$_GET["where"]as$W){if(!array_key_exists($W["col"],$Ai))$_.=where_link($t++,$W["col"],$W["val"],$W["op"]);}foreach($Ai
as$ce=>$W)$_.=where_link($t++,$ce,$W);}$X=select_value($X,$_,$n,$Zh);$u=h("val[$Bi][".bracket_escape($y)."]");$Y=$_POST["val"][$Bi][bracket_escape($y)];$jc=!is_array($J[$y])&&is_utf8($X)&&$K[$Te][$y]==$J[$y]&&!$id[$y]&&!$n["generated"];$Xh=preg_match('~text|json|lob~',$n["type"]);echo"<td id='$u'".(preg_match(number_type(),$n["type"])&&is_numeric(strip_tags($X))?" class='number'":"");if(($_GET["modify"]&&$jc)||$Y!==null){$sd=h($Y!==null?$Y:$J[$y]);echo">".($Xh?"<textarea name='$u' cols='30' rows='".(substr_count($J[$y],"\n")+1)."'>$sd</textarea>":"<input name='$u' value='$sd' size='$re[$y]'>");}else{$we=strpos($X,"<i>…</i>");echo" data-text='".($we?2:($Xh?1:0))."'".($jc?"":" data-warning='".h('使用編輯連結來修改。')."'").">$X";}}}if($Ea)echo"<td>";$b->backwardKeysPrint($Ea,$K[$Te]);echo"</tr>\n";}if(is_ajax())exit;echo"</table>\n","</div>\n";}if(!is_ajax()){if($K||$D){$Bc=true;if($_GET["page"]!="last"){if($z==""||(count($K)<$z&&($K||!$D)))$fd=($D?$D*$z:0)+count($K);elseif(JUSH!="sql"||!$Wd){$fd=($Wd?false:found_rows($R,$Z));if($fd<max(1e4,2*($D+1)*$z))$fd=reset(slow_query(count_rows($a,$Z,$Wd,$nd)));else$Bc=false;}}$Mf=($z!=""&&($fd===false||$fd>$z||$D));if($Mf)echo(($fd===false?count($K)+1:$fd-$D*$z)>$z?'<p><a href="'.h(remove_from_uri("page")."&page=".($D+1)).'" class="loadmore">'.'載入更多資料'.'</a>'.script("qsl('a').onclick = partial(selectLoadMore, ".(+$z).", '".'載入中'."…');",""):''),"\n";}echo"<div class='footer'><div>\n";if($K||$D){if($Mf){$De=($fd===false?$D+(count($K)>=$z?2:1):floor(($fd-1)/$z));echo"<fieldset>";if(JUSH!="simpledb"){echo"<legend><a href='".h(remove_from_uri("page"))."'>".'頁'."</a></legend>",script("qsl('a').onclick = function () { pageClick(this.href, +prompt('".'頁'."', '".($D+1)."')); return false; };"),pagination(0,$D).($D>5?" …":"");for($t=max(1,$D-4);$t<min($De,$D+5);$t++)echo
pagination($t,$D);if($De>0)echo($D+5<$De?" …":""),($Bc&&$fd!==false?pagination($De,$D):" <a href='".h(remove_from_uri("page")."&page=last")."' title='~$De'>".'最後一頁'."</a>");}else
echo"<legend>".'頁'."</legend>",pagination(0,$D).($D>1?" …":""),($D?pagination($D,$D):""),($De>$D?pagination($D+1,$D).($De>$D+1?" …":""):"");echo"</fieldset>\n";}echo"<fieldset>","<legend>".'所有結果'."</legend>";$Xb=($Bc?"":"~ ").$fd;$qf="var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$Xb' : checked); selectCount('selected2', this.checked || !checked ? '$Xb' : checked);";echo
checkbox("all",1,0,($fd!==false?($Bc?"":"~ ").sprintf('%d 行',$fd):""),$qf)."\n","</fieldset>\n";if($b->selectCommandPrint())echo'<fieldset',($_GET["modify"]?'':' class="jsonly"'),'><legend>修改</legend><div>
<input type="submit" value="儲存"',($_GET["modify"]?'':' title="'.'按住Ctrl並按一下某個值進行修改。'.'"'),'>
</div></fieldset>
<fieldset><legend>已選中 <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="編輯">
<input type="submit" name="clone" value="複製">
<input type="submit" name="delete" value="刪除">',confirm(),'</div></fieldset>
';$dd=$b->dumpFormat();foreach((array)$_GET["columns"]as$d){if($d["fun"]){unset($dd['sql']);break;}}if($dd){print_fieldset("export",'匯出'." <span id='selected2'></span>");$Jf=$b->dumpOutput();echo($Jf?html_select("output",$Jf,$pa["output"])." ":""),html_select("format",$dd,$pa["format"])," <input type='submit' name='export' value='".'匯出'."'>\n","</div></fieldset>\n";}$b->selectEmailPrint(array_filter($oc,'strlen'),$e);}echo"</div></div>\n";if($b->selectImportPrint())echo"<div>","<a href='#import'>".'匯入'."</a>",script("qsl('a').onclick = partial(toggle, 'import');",""),"<span id='import'".($_POST["import"]?"":" class='hidden'").">: ","<input type='file' name='csv_file'> ",html_select("separator",array("csv"=>"CSV,","csv;"=>"CSV;","tsv"=>"TSV"),$pa["format"])," <input type='submit' name='import' value='".'匯入'."'>","</span>","</div>";echo"<input type='hidden' name='token' value='$T'>\n","</form>\n",(!$nd&&$L?"":script("tableCheck();"));}}}if(is_ajax()){ob_end_clean();exit;}}elseif(isset($_GET["variables"])){$O=isset($_GET["status"]);page_header($O?'狀態':'變數');$Ri=($O?show_status():show_variables());if(!$Ri)echo"<p class='message'>".'沒有資料行。'."\n";else{echo"<table>\n";foreach($Ri
as$y=>$X)echo"<tr>","<th><code class='jush-".JUSH.($O?"status":"set")."'>".h($y)."</code>","<td>".nl_br(h($X));echo"</table>\n";}}elseif(isset($_GET["script"])){header("Content-Type: text/javascript; charset=utf-8");if($_GET["script"]=="db"){$Hh=array("Data_length"=>0,"Index_length"=>0,"Data_free"=>0);foreach(table_status()as$B=>$R){json_row("Comment-$B",h($R["Comment"]));if(!is_view($R)){foreach(array("Engine","Collation")as$y)json_row("$y-$B",h($R[$y]));foreach($Hh+array("Auto_increment"=>0,"Rows"=>0)as$y=>$X){if($R[$y]!=""){$X=format_number($R[$y]);if($X>=0)json_row("$y-$B",($y=="Rows"&&$X&&$R["Engine"]==(JUSH=="pgsql"?"table":"InnoDB")?"~ $X":$X));if(isset($Hh[$y]))$Hh[$y]+=($R["Engine"]!="InnoDB"||$y!="Data_free"?$R[$y]:0);}elseif(array_key_exists($y,$R))json_row("$y-$B","?");}}}foreach($Hh
as$y=>$X)json_row("sum-$y",format_number($X));json_row("");}elseif($_GET["script"]=="kill")$f->query("KILL ".number($_POST["kill"]));else{foreach(count_tables($b->databases())as$j=>$X){json_row("tables-$j",$X);json_row("size-$j",db_size($j));}json_row("");}exit;}else{$Rh=array_merge((array)$_POST["tables"],(array)$_POST["views"]);if($Rh&&!$m&&!$_POST["search"]){$H=true;$Je="";if(JUSH=="sql"&&$_POST["tables"]&&count($_POST["tables"])>1&&($_POST["drop"]||$_POST["truncate"]||$_POST["copy"]))queries("SET foreign_key_checks = 0");if($_POST["truncate"]){if($_POST["tables"])$H=truncate_tables($_POST["tables"]);$Je='已清空資料表。';}elseif($_POST["move"]){$H=move_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Je='已轉移資料表。';}elseif($_POST["copy"]){$H=copy_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Je='資料表已經複製。';}elseif($_POST["drop"]){if($_POST["views"])$H=drop_views($_POST["views"]);if($H&&$_POST["tables"])$H=drop_tables($_POST["tables"]);$Je='已經將資料表刪除。';}elseif(JUSH=="sqlite"&&$_POST["check"]){foreach((array)$_POST["tables"]as$Q){foreach(get_rows("PRAGMA integrity_check(".q($Q).")")as$J)$Je.="<b>".h($Q)."</b>: ".h($J["integrity_check"])."<br>";}}elseif(JUSH!="sql"){$H=(JUSH=="sqlite"?queries("VACUUM"):apply_queries("VACUUM".($_POST["optimize"]?"":" ANALYZE"),$_POST["tables"]));$Je='已優化資料表。';}elseif(!$_POST["tables"])$Je='沒有資料表。';elseif($H=queries(($_POST["optimize"]?"OPTIMIZE":($_POST["check"]?"CHECK":($_POST["repair"]?"REPAIR":"ANALYZE")))." TABLE ".implode(", ",array_map('Adminer\idf_escape',$_POST["tables"])))){while($J=$H->fetch_assoc())$Je.="<b>".h($J["Table"])."</b>: ".h($J["Msg_text"])."<br>";}queries_redirect(substr(ME,0,-1),$Je,$H);}page_header(($_GET["ns"]==""?'資料庫'.": ".h(DB):'資料表結構'.": ".h($_GET["ns"])),$m,true);if($b->homepage()){if($_GET["ns"]!==""){echo"<h3 id='tables-views'>".'資料表和檢視表'."</h3>\n";$Qh=tables_list();if(!$Qh)echo"<p class='message'>".'沒有資料表。'."\n";else{echo"<form action='' method='post'>\n";if(support("table")){echo"<fieldset><legend>".'在資料庫搜尋'." <span id='selected2'></span></legend><div>","<input type='search' name='query' value='".h($_POST["query"])."'>",script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');","")," <input type='submit' name='search' value='".'搜尋'."'>\n","</div></fieldset>\n";if($_POST["search"]&&$_POST["query"]!=""){$_GET["where"][0]["op"]=$l->convertOperator("LIKE %%");search_tables();}}echo"<div class='scrollable'>\n","<table class='nowrap checkable odds'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),'<thead><tr class="wrap">','<td><input id="check-all" type="checkbox" class="jsonly">'.script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);",""),'<th>'.'資料表','<td>'.'引擎'.doc_link(array('sql'=>'storage-engines.html')),'<td>'.'校對'.doc_link(array('sql'=>'charset-charsets.html','mariadb'=>'supported-character-sets-and-collations/')),'<td>'.'資料長度'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT','oracle'=>'REFRN20286')),'<td>'.'索引長度'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT')),'<td>'.'資料空閒'.doc_link(array('sql'=>'show-table-status.html')),'<td>'.'自動遞增'.doc_link(array('sql'=>'example-auto-increment.html','mariadb'=>'auto_increment/')),'<td>'.'行數'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'catalog-pg-class.html#CATALOG-PG-CLASS','oracle'=>'REFRN20286')),(support("comment")?'<td>'.'註解'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-info.html#FUNCTIONS-INFO-COMMENT-TABLE')):''),"</thead>\n";$S=0;foreach($Qh
as$B=>$U){$Ui=($U!==null&&!preg_match('~table|sequence~i',$U));$u=h("Table-".$B);echo'<tr><td>'.checkbox(($Ui?"views[]":"tables[]"),$B,in_array($B,$Rh,true),"","","",$u),'<th>'.(support("table")||support("indexes")?"<a href='".h(ME)."table=".urlencode($B)."' title='".'顯示結構'."' id='$u'>".h($B).'</a>':h($B));if($Ui)echo'<td colspan="6"><a href="'.h(ME)."view=".urlencode($B).'" title="'.'修改檢視表'.'">'.(preg_match('~materialized~i',$U)?'物化視圖':'檢視表').'</a>','<td align="right"><a href="'.h(ME)."select=".urlencode($B).'" title="'.'選擇資料'.'">?</a>';else{foreach(array("Engine"=>array(),"Collation"=>array(),"Data_length"=>array("create",'修改資料表'),"Index_length"=>array("indexes",'修改索引'),"Data_free"=>array("edit",'新增項目'),"Auto_increment"=>array("auto_increment=1&create",'修改資料表'),"Rows"=>array("select",'選擇資料'),)as$y=>$_){$u=" id='$y-".h($B)."'";echo($_?"<td align='right'>".(support("table")||$y=="Rows"||(support("indexes")&&$y!="Data_length")?"<a href='".h(ME."$_[0]=").urlencode($B)."'$u title='$_[1]'>?</a>":"<span$u>?</span>"):"<td id='$y-".h($B)."'>");}$S++;}echo(support("comment")?"<td id='Comment-".h($B)."'>":""),"\n";}echo"<tr><td><th>".sprintf('總共 %d 個',count($Qh)),"<td>".h(JUSH=="sql"?get_val("SELECT @@default_storage_engine"):""),"<td>".h(db_collation(DB,collations()));foreach(array("Data_length","Index_length","Data_free")as$y)echo"<td align='right' id='sum-$y'>";echo"\n","</table>\n","</div>\n";if(!information_schema(DB)){echo"<div class='footer'><div>\n";$Oi="<input type='submit' value='".'整理（Vacuum）'."'> ".on_help("'VACUUM'");$tf="<input type='submit' name='optimize' value='".'最佳化'."'> ".on_help(JUSH=="sql"?"'OPTIMIZE TABLE'":"'VACUUM OPTIMIZE'");echo"<fieldset><legend>".'已選中'." <span id='selected'></span></legend><div>".(JUSH=="sqlite"?$Oi."<input type='submit' name='check' value='".'檢查'."'> ".on_help("'PRAGMA integrity_check'"):(JUSH=="pgsql"?$Oi.$tf:(JUSH=="sql"?"<input type='submit' value='".'分析'."'> ".on_help("'ANALYZE TABLE'").$tf."<input type='submit' name='check' value='".'檢查'."'> ".on_help("'CHECK TABLE'")."<input type='submit' name='repair' value='".'修復'."'> ".on_help("'REPAIR TABLE'"):"")))."<input type='submit' name='truncate' value='".'清空'."'> ".on_help(JUSH=="sqlite"?"'DELETE'":"'TRUNCATE".(JUSH=="pgsql"?"'":" TABLE'")).confirm()."<input type='submit' name='drop' value='".'刪除'."'>".on_help("'DROP TABLE'").confirm()."\n";$i=(support("scheme")?$b->schemas():$b->databases());if(count($i)!=1&&JUSH!="sqlite"){$j=(isset($_POST["target"])?$_POST["target"]:(support("scheme")?$_GET["ns"]:DB));echo"<p>".'轉移到其它資料庫'.": ",($i?html_select("target",$i,$j):'<input name="target" value="'.h($j).'" autocapitalize="off">')," <input type='submit' name='move' value='".'轉移'."'>",(support("copy")?" <input type='submit' name='copy' value='".'複製'."'> ".checkbox("overwrite",1,$_POST["overwrite"],'覆蓋'):""),"\n";}echo"<input type='hidden' name='all' value=''>",script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));".(support("table")?" selectCount('selected2', formChecked(this, /^tables\[/) || $S);":"")." }"),"<input type='hidden' name='token' value='$T'>\n","</div></fieldset>\n","</div></div>\n";}echo"</form>\n",script("tableCheck();");}echo'<p class="links"><a href="'.h(ME).'create=">'.'建立資料表'."</a>\n",(support("view")?'<a href="'.h(ME).'view=">'.'建立檢視表'."</a>\n":"");if(support("routine")){echo"<h3 id='routines'>".'程序'."</h3>\n";$Og=routines();if($Og){echo"<table class='odds'>\n",'<thead><tr><th>'.'名稱'.'<td>'.'類型'.'<td>'.'回傳類型'."<td></thead>\n";foreach($Og
as$J){$B=($J["SPECIFIC_NAME"]==$J["ROUTINE_NAME"]?"":"&name=".urlencode($J["ROUTINE_NAME"]));echo'<tr>','<th><a href="'.h(ME.($J["ROUTINE_TYPE"]!="PROCEDURE"?'callf=':'call=').urlencode($J["SPECIFIC_NAME"]).$B).'">'.h($J["ROUTINE_NAME"]).'</a>','<td>'.h($J["ROUTINE_TYPE"]),'<td>'.h($J["DTD_IDENTIFIER"]),'<td><a href="'.h(ME.($J["ROUTINE_TYPE"]!="PROCEDURE"?'function=':'procedure=').urlencode($J["SPECIFIC_NAME"]).$B).'">'.'修改'."</a>";}echo"</table>\n";}echo'<p class="links">'.(support("procedure")?'<a href="'.h(ME).'procedure=">'.'建立預存程序'.'</a>':'').'<a href="'.h(ME).'function=">'.'建立函式'."</a>\n";}if(support("sequence")){echo"<h3 id='sequences'>".'序列'."</h3>\n";$fh=get_vals("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = current_schema() ORDER BY sequence_name");if($fh){echo"<table class='odds'>\n","<thead><tr><th>".'名稱'."</thead>\n";foreach($fh
as$X)echo"<tr><th><a href='".h(ME)."sequence=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."sequence='>".'建立序列'."</a>\n";}if(support("type")){echo"<h3 id='user-types'>".'使用者類型'."</h3>\n";$Mi=types();if($Mi){echo"<table class='odds'>\n","<thead><tr><th>".'名稱'."</thead>\n";foreach($Mi
as$X)echo"<tr><th><a href='".h(ME)."type=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."type='>".'建立類型'."</a>\n";}if(support("event")){echo"<h3 id='events'>".'事件'."</h3>\n";$K=get_rows("SHOW EVENTS");if($K){echo"<table>\n","<thead><tr><th>".'名稱'."<td>".'排程'."<td>".'開始'."<td>".'結束'."<td></thead>\n";foreach($K
as$J)echo"<tr>","<th>".h($J["Name"]),"<td>".($J["Execute at"]?'在指定時間'."<td>".$J["Execute at"]:'每'." ".$J["Interval value"]." ".$J["Interval field"]."<td>$J[Starts]"),"<td>$J[Ends]",'<td><a href="'.h(ME).'event='.urlencode($J["Name"]).'">'.'修改'.'</a>';echo"</table>\n";$_c=get_val("SELECT @@event_scheduler");if($_c&&$_c!="ON")echo"<p class='error'><code class='jush-sqlset'>event_scheduler</code>: ".h($_c)."\n";}echo'<p class="links"><a href="'.h(ME).'event=">'.'建立事件'."</a>\n";}if($Qh)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}}}page_footer();