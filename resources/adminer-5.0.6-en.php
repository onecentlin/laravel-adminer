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
sprintf('%.3f s',max(0,microtime(true)-$_h));}function
relative_uri(){return
str_replace(":","%3a",preg_replace('~^[^?]*/([^?]*)~','\1',$_SERVER["REQUEST_URI"]));}function
remove_from_uri($Nf=""){return
substr(preg_replace("~(?<=[?&])($Nf".(SID?"":"|".session_name()).")=[^&]*&~",'',relative_uri()."&"),0,-1);}function
get_file($y,$Mb=false,$Qb=""){$Rc=$_FILES[$y];if(!$Rc)return
null;foreach($Rc
as$y=>$X)$Rc[$y]=(array)$X;$I='';foreach($Rc["error"]as$y=>$m){if($m)return$m;$B=$Rc["name"][$y];$ii=$Rc["tmp_name"][$y];$tb=file_get_contents($Mb&&preg_match('~\.gz$~',$B)?"compress.zlib://$ii":$ii);if($Mb){$_h=substr($tb,0,3);if(function_exists("iconv")&&preg_match("~^\xFE\xFF|^\xFF\xFE~",$_h))$tb=iconv("utf-16","utf-8",$tb);elseif($_h=="\xEF\xBB\xBF")$tb=substr($tb,3);}$I.=$tb;if($Qb)$I.=(preg_match("($Qb\\s*\$)",$tb)?"":$Qb)."\n\n";}return$I;}function
upload_error($m){$Fe=($m==UPLOAD_ERR_INI_SIZE?ini_get("upload_max_filesize"):0);return($m?'Unable to upload a file.'.($Fe?" ".sprintf('Maximum allowed file size is %sB.',$Fe):""):'File does not exist.');}function
repeat_pattern($Xf,$qe){return
str_repeat("$Xf{0,65535}",$qe/65535)."$Xf{0,".($qe%65535)."}";}function
is_utf8($X){return(preg_match('~~u',$X)&&!preg_match('~[\0-\x8\xB\xC\xE-\x1F]~',$X));}function
shorten_utf8($P,$qe=80,$Fh=""){if(!preg_match("(^(".repeat_pattern("[\t\r\n -\x{10FFFF}]",$qe).")($)?)u",$P,$A))preg_match("(^(".repeat_pattern("[\t\r\n -~]",$qe).")($)?)",$P,$A);return
h($A[1]).$Fh.(isset($A[2])?"":"<i>â€¦</i>");}function
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
script("$Zg.onclick = function () { return confirm('".($Je?js_escape($Je):'Are you sure?')."'); };","");}function
print_fieldset($u,$pe,$Wi=false){echo"<fieldset><legend>","<a href='#fieldset-$u'>$pe</a>",script("qsl('a').onclick = partial(toggle, 'fieldset-$u');",""),"</legend>","<div id='fieldset-$u'".($Wi?"":" class='hidden'").">\n";}function
bold($Ka,$ab=""){return($Ka?" class='active $ab'":($ab?" class='$ab'":""));}function
js_escape($P){return
addcslashes($P,"\r\n'\\/");}function
pagination($D,$Db){return" ".($D==$Db?$D+1:'<a href="'.h(remove_from_uri("page").($D?"&page=$D".($_GET["next"]?"&next=".urlencode($_GET["next"]):""):"")).'">'.($D+1)."</a>");}function
hidden_fields($og,$Fd=array(),$hg=''){$I=false;foreach($og
as$y=>$X){if(!in_array($y,$Fd)){if(is_array($X))hidden_fields($X,array(),$y);else{$I=true;echo'<input type="hidden" name="'.h($hg?$hg."[$y]":$y).'" value="'.h($X).'">';}}}return$I;}function
hidden_fields_get(){echo(sid()?'<input type="hidden" name="'.session_name().'" value="'.h(session_id()).'">':''),(SERVER!==null?'<input type="hidden" name="'.DRIVER.'" value="'.h(SERVER).'">':""),'<input type="hidden" name="username" value="'.h($_GET["username"]).'">';}function
enum_input($U,$ya,$n,$Y,$pc=null){global$b;preg_match_all("~'((?:[^']|'')*)'~",$n["length"],$Ae);$I=($pc!==null?"<label><input type='$U'$ya value='$pc'".((is_array($Y)?in_array($pc,$Y):$Y===$pc)?" checked":"")."><i>".'empty'."</i></label>":"");foreach($Ae[1]as$t=>$X){$X=stripcslashes(str_replace("''","'",$X));$Wa=(is_array($Y)?in_array($X,$Y):$Y===$X);$I.=" <label><input type='$U'$ya value='".h($X)."'".($Wa?' checked':'').'>'.h($b->editVal($X,$n)).'</label>';}return$I;}function
input($n,$Y,$s,$Ba=false){global$l,$b;$B=h(bracket_escape($n["field"]));echo"<td class='function'>";if(is_array($Y)&&!$s){$Y=json_encode($Y,128);$s="json";}$Fg=(JUSH=="mssql"&&$n["auto_increment"]);if($Fg&&!$_POST["save"])$s=null;$id=(isset($_GET["select"])||$Fg?array("orig"=>'original'):array())+$b->editFunctions($n);$Vb=stripos($n["default"],"GENERATED ALWAYS AS ")===0?" disabled=''":"";$ya=" name='fields[$B]'$Vb".($Ba?" autofocus":"");$vc=$l->enumLength($n);if($vc){$n["type"]="enum";$n["length"]=$vc;}echo$l->unconvertFunction($n)." ";if($n["type"]=="enum")echo
h($id[""])."<td>".$b->editInput($_GET["edit"],$n,$ya,$Y);else{$ud=(in_array($s,$id)||isset($id[$s]));echo(count($id)>1?"<select name='function[$B]'$Vb>".optionlist($id,$s===null||$ud?$s:"")."</select>".on_help("getTarget(event).value.replace(/^SQL\$/, '')",1).script("qsl('select').onchange = functionChange;",""):h(reset($id))).'<td>';$Qd=$b->editInput($_GET["edit"],$n,$ya,$Y);if($Qd!="")echo$Qd;elseif(preg_match('~bool~',$n["type"]))echo"<input type='hidden'$ya value='0'>"."<input type='checkbox'".(preg_match('~^(1|t|true|y|yes|on)$~i',$Y)?" checked='checked'":"")."$ya value='1'>";elseif($n["type"]=="set"){preg_match_all("~'((?:[^']|'')*)'~",$n["length"],$Ae);foreach($Ae[1]as$t=>$X){$X=stripcslashes(str_replace("''","'",$X));$Wa=in_array($X,explode(",",$Y),true);echo" <label><input type='checkbox' name='fields[$B][$t]' value='".h($X)."'".($Wa?' checked':'').">".h($b->editVal($X,$n)).'</label>';}}elseif(preg_match('~blob|bytea|raw|file~',$n["type"])&&ini_bool("file_uploads"))echo"<input type='file' name='fields-$B'>";elseif(($Xh=preg_match('~text|lob|memo~i',$n["type"]))||preg_match("~\n~",$Y)){if($Xh&&JUSH!="sqlite")$ya.=" cols='50' rows='12'";else{$K=min(12,substr_count($Y,"\n")+1);$ya.=" cols='30' rows='$K'".($K==1?" style='height: 1.2em;'":"");}echo"<textarea$ya>".h($Y).'</textarea>';}elseif($s=="json"||preg_match('~^jsonb?$~',$n["type"]))echo"<textarea$ya cols='50' rows='12' class='jush-js'>".h($Y).'</textarea>';else{$xi=$l->types();$He=(!preg_match('~int~',$n["type"])&&preg_match('~^(\d+)(,(\d+))?$~',$n["length"],$A)?((preg_match("~binary~",$n["type"])?2:1)*$A[1]+($A[3]?1:0)+($A[2]&&!$n["unsigned"]?1:0)):($xi[$n["type"]]?$xi[$n["type"]]+($n["unsigned"]?0:1):0));if(JUSH=='sql'&&min_version(5.6)&&preg_match('~time~',$n["type"]))$He+=7;echo"<input".((!$ud||$s==="")&&preg_match('~(?<!o)int(?!er)~',$n["type"])&&!preg_match('~\[\]~',$n["full_type"])?" type='number'":"")." value='".h($Y)."'".($He?" data-maxlength='$He'":"").(preg_match('~char|binary~',$n["type"])&&$He>20?" size='40'":"")."$ya>";}echo$b->editHint($_GET["edit"],$n,$Y);$Tc=0;foreach($id
as$y=>$X){if($y===""||!$X)break;$Tc++;}if($Tc)echo
script("mixin(qsl('td'), {onchange: partial(skipOriginal, $Tc), oninput: function () { this.onchange(); }});");}}function
process_input($n){global$b,$l;if(stripos($n["default"],"GENERATED ALWAYS AS ")===0)return
null;$v=bracket_escape($n["field"]);$s=$_POST["function"][$v];$Y=$_POST["fields"][$v];if($n["type"]=="enum"||$l->enumLength($n)){if($Y==-1)return
false;if($Y=="")return"NULL";}if($n["auto_increment"]&&$Y=="")return
null;if($s=="orig")return(preg_match('~^CURRENT_TIMESTAMP~i',$n["on_update"])?idf_escape($n["field"]):false);if($s=="NULL")return"NULL";if($n["type"]=="set")$Y=implode(",",(array)$Y);if($s=="json"){$s="";$Y=json_decode($Y,true);if(!is_array($Y))return
false;return$Y;}if(preg_match('~blob|bytea|raw|file~',$n["type"])&&ini_bool("file_uploads")){$Rc=get_file("fields-$v");if(!is_string($Rc))return
false;return$l->quoteBinary($Rc);}return$b->processInput($n,$Y,$s);}function
search_tables(){global$b,$f;$_GET["where"][0]["val"]=$_POST["query"];$bh="<ul>\n";foreach(table_status('',true)as$Q=>$R){$B=$b->tableName($R);if(isset($R["Engine"])&&$B!=""&&(!$_POST["tables"]||in_array($Q,$_POST["tables"]))){$H=$f->query("SELECT".limit("1 FROM ".table($Q)," WHERE ".implode(" AND ",$b->selectSearchProcess(fields($Q),array())),1));if(!$H||$H->fetch_row()){$kg="<a href='".h(ME."select=".urlencode($Q)."&where[0][op]=".urlencode($_GET["where"][0]["op"])."&where[0][val]=".urlencode($_GET["where"][0]["val"]))."'>$B</a>";echo"$bh<li>".($H?$kg:"<p class='error'>$kg: ".error())."\n";$bh="";}}}echo($bh?"<p class='message'>".'No tables.':"</ul>")."\n";}function
on_help($jb,$mh=0){return
script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $jb, $mh) }, onmouseout: helpMouseout});","");}function
edit_form($Q,$o,$J,$Fi){global$b,$T,$m;$Lh=$b->tableName(table_status1($Q,true));page_header(($Fi?'Edit':'Insert'),$m,array("select"=>array($Q,$Lh)),$Lh);$b->editRowPrint($Q,$o,$J,$Fi);if($J===false){echo"<p class='error'>".'No rows.'."\n";return;}echo"<form action='' method='post' enctype='multipart/form-data' id='form'>\n";if(!$o)echo"<p class='error'>".'You have no privileges to update this table.'."\n";else{echo"<table class='layout'>".script("qsl('table').onkeydown = editingKeydown;");$Ba=!$_POST;foreach($o
as$B=>$n){echo"<tr><th>".$b->fieldName($n);$k=$_GET["set"][bracket_escape($B)];if($k===null){$k=$n["default"];if($n["type"]=="bit"&&preg_match("~^b'([01]*)'\$~",$k,$Cg))$k=$Cg[1];if(JUSH=="sql"&&preg_match('~binary~',$n["type"]))$k=bin2hex($k);}$Y=($J!==null?($J[$B]!=""&&JUSH=="sql"&&preg_match("~enum|set~",$n["type"])&&is_array($J[$B])?implode(",",$J[$B]):(is_bool($J[$B])?+$J[$B]:$J[$B])):(!$Fi&&$n["auto_increment"]?"":(isset($_GET["select"])?false:$k)));if(!$_POST["save"]&&is_string($Y))$Y=$b->editVal($Y,$n);$s=($_POST["save"]?(string)$_POST["function"][$B]:($Fi&&preg_match('~^CURRENT_TIMESTAMP~i',$n["on_update"])?"now":($Y===false?null:($Y!==null?'':'NULL'))));if(!$_POST&&!$Fi&&$Y==$n["default"]&&preg_match('~^[\w.]+\(~',$Y))$s="SQL";if(preg_match("~time~",$n["type"])&&preg_match('~^CURRENT_TIMESTAMP~i',$Y)){$Y="";$s="now";}if($n["type"]=="uuid"&&$Y=="uuid()"){$Y="";$s="uuid";}if($Ba!==false)$Ba=($n["auto_increment"]||$s=="now"||$s=="uuid"?null:true);input($n,$Y,$s,$Ba);if($Ba)$Ba=false;echo"\n";}if(!support("table"))echo"<tr>"."<th><input name='field_keys[]'>".script("qsl('input').oninput = fieldChange;")."<td class='function'>".html_select("field_funs[]",$b->editFunctions(array("null"=>isset($_GET["select"]))))."<td><input name='field_vals[]'>"."\n";echo"</table>\n";}echo"<p>\n";if($o){echo"<input type='submit' value='".'Save'."'>\n";if(!isset($_GET["select"]))echo"<input type='submit' name='insert' value='".($Fi?'Save and continue edit':'Save and insert next')."' title='Ctrl+Shift+Enter'>\n",($Fi?script("qsl('input').onclick = function () { return !ajaxForm(this.form, '".'Saving'."â€¦', this); };"):"");}echo($Fi?"<input type='submit' name='delete' value='".'Delete'."'>".confirm()."\n":"");if(isset($_GET["select"]))hidden_fields(array("check"=>(array)$_POST["check"],"clone"=>$_POST["clone"],"all"=>$_POST["all"]));echo'<input type="hidden" name="referer" value="',h(isset($_POST["referer"])?$_POST["referer"]:$_SERVER["HTTP_REFERER"]),'">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="',$T,'">
</form>
';}if(isset($_GET["file"])){if(substr($ia,-4)!='-dev'){if($_SERVER["HTTP_IF_MODIFIED_SINCE"]){header("HTTP/1.1 304 Not Modified");exit;}header("Expires: ".gmdate("D, d M Y H:i:s",time()+365*24*60*60)." GMT");header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");header("Cache-Control: immutable");}if($_GET["file"]=="favicon.ico"){header("Content-Type: image/x-icon");echo
lzw_decompress("\0\0\0` \0„\0\n @\0´C„è\"\0`EãQ¸àÿ‡?ÀtvM'”JdÁd\\Œb0\0Ä\"™ÀfÓˆ¤îs5›ÏçÑAXPaJ“0„¥‘8„#RŠT©‘z`ˆ#.©ÇcíXÃşÈ€?À-\0¡Im? .«M¶€\0È¯(Ì‰ıÀ/(%Œ\0");}elseif($_GET["file"]=="default.css"){header("Content-Type: text/css; charset=utf-8");echo
lzw_decompress("b7™'³¼Øo9„c`ìÄa1šÌç#yÔÜd…£C³1¼ÜtFQxÄ\\2ˆ\nÆS‘Ân0‹'#I„Ø,\$M‡c)ĞÒc˜œåç1iÎXi3Í¦‘œÒn)TñiÜÒd:FcIĞ[™cã³é†	„ŒFÃ©”vt2+ÆC,äaŸG‡FèõºÊ:;NuÓ)’Ï„ÌÇ›!„tl§šÇFƒ|ğä,Ç`pwÆS-‡´œ°¶ûÎë¼oQk¡Ë n¿E×–O+,=í4×mMêù°Æ‹GS™ Zh6Ùø. uOäM–C@Ä÷ÑM'£(èb5‘Ò©”ê…Hàa2)æqĞ¸pe6ˆ?t#Z-€†óoxà<š«„s£ˆò¼;Œ£HÎ4\$àä¥Ûš´„a¼4‡\"’(Ö!C,DêN¼í;óÀ¼Jj¨„€@ø@†!Ãş¼ïKÖö½ï‹æ6¾©jXü\rïÓøÿ@ 2@¨b¥¡(ZìApl¡¤8ˆ¢hª.…=*Hú4q3³AĞ‚÷.¦ĞK²ÁÅ!ˆfğ©qr¡!Æ1ŠÈÂcÜòò*+ é(ƒ\nÖ2j²°­(dYAÅêûDÑtÇÏ‘¤m*HŒ9+è0Ø0\n0tæÔõJİ,EêERã X¬u[&@0¡AëÔ7=‰;àÁ›éKÌ;0ÄD·7Ajm*`Ê3:v`ÊôÅ«kŒê€Æ±.”xôXv(ec…Á­–¬ÛôEmz\\Â0CóG2ÏãJt2(Ã öõc…N<¹ãs^·2Éò€6ZÌ…Ê?c…×Xmäø½Ï¥(¨d9?>Ô/²Y^IĞ%€¬ƒ…5=H==\0T Ò6ŒãŞ\"Ÿ¦Ø­°\rª¸ÉmHµİ-C„Şz¥\nª®¬‡Q¤j<<Z‹‘6¤´v> «¥~LHÅ¥Òèp¡,òYpŞûPó¶9{}õgß»5§˜´Y	>g5¨@8o¹\n>ğƒ-nÒ©–üÔR)J“¥#j<7á(‚ıÄ¸N%›}ÃÛ*2ñ\rA°Ñ˜F0á‹XŞˆçCpà:œZåÆ¬È£:GõÔİv=Ÿj£[C\rŸâz/¢½:@ú§øBØè<(z.ïPŞ¹òY‰h7\"¡j¿/Ü‰çö] \\ºÃê6`İÒŠ4=xï^1·ó\0C0ßĞğq¢!Ô4š%lôSP[K}÷vı#öé@g‚úƒ»¬\räh=­¥¸‘ÂRGaÁÌÓTTRNv…ø:â\"ÁÌ«u¤ØĞ\\eŒ4	U\rtäW“¡İÀÉZ æ²CF,@°ÀÕâ1\r„\rÕ0´Şp!´OY4:†ĞÜá!›„àêhV—İ\nÑ`	’pn±Ïš\0Y+©20ZÆanYq5ûpàÜ\"a|ñùp†…n#äƒU\0°8H˜ü£bIp(§sƒ§YtŠêHI&æ“zN0Ø–@åÁÔtAfĞ¥)‰±Æ™ZFÕ‚lKr…/C`ÚC™Bê1*¢&ˆƒth•êWI‰0CÃ\\*)mJ„¬¨[Ã¢di3K\0å)¢dÏ˜J261Õâ¼\n-oìÙ«²‰0ß¤§˜©X„b\r‰qpšÓÔ†OY0X¢ìÖŸ¡C`ÄSÊa˜°Z¸[“t#çxØ@2\rÀ¦ZÌ²­ ¤b-éà]C\\Ô±lä \"5,¥ª™RåçæÌj“tŸKùP`ÉÙ,‡êÄsÃ\rƒ1xĞ@ÅĞÄK\"dù'¬íF.6,T	¢[“Mê¨Ö¦¤“X¡¡À¼†èñ«µÁ¾²Bx2jˆĞ¸ÉƒC»(¯Mmõd˜\"øW©t›ˆ“Ì8ªsDY«‘Z â\"—VSæš™òD2Éù+%á±?‡VDï#¦°ÖåÚ9Gr­¼ªSœbŒe¡,\rÖSÚÆËk	£†Ñ¯(ú‹]a±È\rŒÈ1‡Pä€›iÉ“u\$›ˆÃ	‹ĞsbA¬Æ>T—TØnµe7ÖnÒR<xfêõ'‚šCèÈ5 °”^»Û¸)¼\n‘ÍºÃÊ`-\"g¡ğQyÃ\ré½×ªö`BN\nAdÛ#@¤ù)\$ıR}Í@€Ô¨ëyte&rÅ@²ıËÂ+¤ÆÁ[ñT\nXğ×ì…œ³ÇvAGéÔU.ã]jò`ƒ†r*Á£´xœéçÖXÈ¡Qp-õ±Bã—‹CyèrÎì‚Ø<ä.\0#—á¸:ÆK‘£)lÉNH©ôıx¦WP¶ƒ•—–¨ƒÁ8ô§‡<¦ĞsŒ²6¤äÈ®Ê…wÊ’ë×÷ypcÑEçJÌ†w¥QÈAÓ+æ4/º02d€ömÃf ïŞ\$’Å£4vvyâ`IÙ\$æd®5U\0ïPj(%©K¤Éº47La¤”^¿ÕzM\0x¿m–ŒÜÑ…€¸üRTyñÃàÉ!±µÚw§mã¼j[F’ö{‘caŒñâïàmšVÙ <Ùòs,¤…›ÃŒ9Tí]gu†š“Hó/î‘²V+y«jM¿›İ¨MÛG”û;Âœƒ%ÚÈımW\r‡Ñ’8´Ú0êÏ´6µK¡¼ÈÆıW¢{¤ké]Zö]ÃˆO*(`#tœ¥ìü­ºAĞ6Ç{€½%OaqÄHõ¡ãErÜUC(b\retô%IÑäXæ\\Ğ0¬X®YQ	Ğìµ(T-ÄØê2HîâÜrÒå‰æüŒEëqd­wÌÎAKYŠW Ü¹ó×<…ÿ1àGp™—zÈù\$·h6X¯*f½\"<:ª;Vµ¢Å6ˆå÷È;@´§—@ğw¤Àr°„KÅÑ½ª@oĞú<å\0}v¬‰‹ÒMéÁì=¬â¾Û<ïGDûwá·´Y÷ÁŞpT²sî?~·Ò=˜º=æÑFn?xüÊÎÙÇ×=â½w¦öÍ_(7ƒ¼ÁR'¨ãY›| \\yæzünÓòş}«÷=%p“0j?–ÉÈB!†¾÷\nTåˆöoºËlºÿÏêkŒøGHu`4J–/Gà]@ú	~=Nª&ÏH%ä  jK|\0pjê8ıëìşNpüŒx×¯ŠğK¤5+ñî*ßL¼íb¡¦\$kI\rvùíœÌÔúíPÛĞzº~Q0‚×o¾=Â\r©i˜YàÕ¯’ş²ùÄúìÉĞ”ÿ\nmæŞ°¬pºù`ûp:&§&œÛ°Î¸†ŠÎHÙpÃì«	-àŞP«\nîpşéU\n`ÖI6Å&d³i<ß)x”h²sÀö¨î4«pJ¤¤q4@Ï¬7\0Z\0ĞHJÀgË¥‘F˜©Ôñ5ã×åN*‰æ!€rÂ¥@Ö òãí‹aÂ®]`EH¡cG@ì&ÂÛ‡fFèàZË¬Hñv	êŸÑ4/\0è&€Ä…qH.ãH?b-ªÀa7@Æ˜1Ùi¸•ÑñSéæ›‘ãqQKb‘E\0ÌRÅƒ†8©Q ä4Z¤¨¾Q.8£€Úâ\n\r¨™!ª(?’>sÅK#gQ\$r0/²P8Òè\"rW€á#’Ds²1%²U&ÃŒ‰à¿'2@²y%éP¿kc'Re&2Z6\0ï)Rê’‹é‹\"%&Q:¾O’¥RÑİ\"Ò%¨\ròc,2Æ ß'£a)’f¤“&%Q,R  ¿-òc £	.hI.«òÉ.2÷-†\r*\"™*qlX’ª¤’I%²ß!ó±Çë.»R+1o)²Âò!-S0)’ô\r“6”å`äîR¯â2’Y)²ŞY,Í3ó552¿)² ¯SDÓIDB²/4òf~‡àD²¯0R#1Ú1å8§\"’»4Èîš28˜2Ü?SšŠRù,Ó“£5RI:’é(Ó©³¥;s¡ Ù1“ƒbå0óÃ1¢¿Ò2ss9`ÎèŸ:óí<21:’û:s ¤³ı;»@3ó;S÷<bm&3Á?3Í8ñ92sÖ9Ò³(‰>3“>eòb\0Û3Ô3A±Qˆ%³>qÅCt;.cõ?ï;Ó¡<ğB\0è¸“ÙBqÅ‘Í>T];û<T/4w3sË8Ñ¡K;GR~úˆ³Ét‘\$’y ó&4£T8Ô{#ªns¼„”AI”D²'ƒDg´—JTF”Å5r› ´¯&S«.Ù&tİ62g@sM«0”ß5”åO4éObáO³QHæààôëPô³7UQKP”ïPÕ\0àÚ˜5#NÔã3U/Qu+O+&cPeµRU7SUGTµ51t\"-4'+r+“‰9E÷3Uk(Íâ&2S²÷W3;.òÃKñ’#ñ—”/(ÑµA@ØTk=Ñ´©ñ›Xò@ÍLôE´8µ©(Ï\0 ‹Œ¹&¹SçMÕu'òäu©Wõ\\³RC&5y]òU*W]’00`Ûí;Z‹KK ÀÉ9R[SÕCN5ÓSV	QÓR,És_Ä¹6ó•C6@6';hIb²1,61aV/^ÕcV=N\0Uø˜£ (åº6R~¸«¤Il\\3e‡Ì00ƒ\ra°BD½dÀÜ:\"»4Ç÷…,");}elseif($_GET["file"]=="dark.css"){header("Content-Type: text/css; charset=utf-8");echo
lzw_decompress("b7™'³¼Øo9„cäÄbÌF¬Îr7MÆHPÀ`2\r\"'Ó\r…\rF#s1„p;’Æ“™¤èe2I ğ‘ªY.˜GFÃI¸Ö:4ÎÆS²…3šÍã”šYÊu(ÃŒc(Æ`hà#%0[ÊL£‘¡½h¬ŒÆC!ˆÍŠE£¨àŒb5†ÃšøÊÅ²œ¬òyá„fbºÇw	äz#ŠÅã1¸PÌÆ6“¡Xt4aì–l¤tÊ4´gİEŠóš¾B†#˜àjaÒ¦ ƒK§áq8Úh]İó¬İôa»2Æ¼P ’óyãŒÀÌi2›‡3)ÓU‰ÅÚoÃl\0ã€}‚ÙvÙ›ŞrüŞ7Ï¸è€ N2ª)3M #Ì¤)PKjé·óxí¬ú8C(\\5£›S\n?«ëvŞ·é‚Š8£ \\²¥£¨Ø÷ À[8ƒxî#€ğG±ü‚!aÂ^>Åqh]#¨Ó´ÒL\\6Œ#ÀØ2Ã<&7ÆÑÀÉG‘ô1Hr‚`*©¨Ş7*éä#Ãã˜@-¨Û6Dª:ì;S:˜Œ*ÍlÍ<·!Ê¹¸ÆÄÌ1øæƒ\r.-†Ã5+?T\0@1?n¥\n\$	Î6Œ£˜æ0Œã,ÚŒAÀlKÃù=PÃ0Ê‰1\neQê%\$–2	eGRÔõKŒ0ŒR½V…¡¨{.ÛÄ¨ê>¤s Ğ0Ğ,b0­Í¹3Œƒ\noe†¡ÊİrÏÃtíeŒ¨j1İó8Ä¢Ûš­+Šğú /[AÃ¢758Ğ4½A@d74ì*ë0,õ8Îc„ŠÙ¾+‹iÄb–°ËŒY#.7‘ã®ôGhVˆ`‡7‹šĞ! ÂíßcTå‘d˜Öy”Â\n®?âÙF3“géÆƒ	euİĞÖ‰hù:+<6ĞGšfÙÀ\\4 ³ÆX¾>*À`0LÏ°MzZ­B#{*x27‹eo}ŒÃxŞ›íõË:\rã†äC:&`f·áMpÕ±CL©TÆèÈä1ŒªŠá±H»ˆô`GÃñ<_Æpd…Ajr[Æõ¾ğ@2\r#¶höVD>„u%ÔŠ3¨£Ÿb:hã›ŞÖkA›1\\É€Gåù¯ŸèûÁ¡’ÎC˜à0ìZsıÙøaÅ¸ƒå;S›„LÀ0L'ˆ°Yk’è]Òi\r)­v ÄÌ»Úm*'7Æ²”[Ô>@À¸µĞşÏHpzf)™ƒ`l¬”ñş`Ü×«h»w º²f²|Œğ7!èiâ¥€êœÈ twª¨æ³\0pÍÚ'ØsÒ¿b`M¹¨gx\")è=IÊ\$°„C‘ËwêĞÇ©PrlĞú!5 ´“pñhc@î2 ÎàÏù^ŒÀ48(ÒÌ\$dl¢ÆóšA²·Qñ,‚Ğà	EAÖ:C¹ˆP»ÆE\"–!ÔFƒh3\$hØC°a\rÔ2È¹'×PmPI³¹>¸£àbE²–Æ¸ÈÎln¾Æ@Æ©¥Ì~kDˆ‘é?º9 ÔçQ¸q\r“8LC,L\0");}elseif($_GET["file"]=="functions.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("f:›ŒgCI¼Ü\n8œÅ3)°Ë7œ…†81ĞÊx:\nOg#)Ğêr7\n\"†è´`ø|2ÌgSi–H)N¦S‘ä§\r‡\"0¹Ä@ä)Ÿ`(\$s6O!ÓèœV/=Œ' T4æ=„˜iS˜6IO G#ÒX·VCÆs¡ Z1.Ğhp8,³[¦Häµ~Cz§Éå2¹l¾c3šÍés£‘ÙI†bâ4\néF8Tà†I˜İ©U*fz¹är0EÆÀØy¸ñfY.:æƒIŒÊ(Øc·áÎ‹!_l™í^·^(¶šN{S–“)rËqÁY“–lÙ¦3Š3Ú\n˜+G¥Óêyºí†Ëi¶ÂîxV3w³uhã^rØÀº´aÛ”ú¹cØè\r“¨ë(.ÂˆºChÒ<\r)èÑ£¡`æ7£íò43'm5Œ£È\nPÜ:2£P»ª‹q òÿÅC“}Ä«ˆúÊÁê38‹BØ0hR‰Èr(œ0¥¡b\\0ŒHr44ŒÁB!¡pÇ\$rZZË2Ü‰.Éƒ(\\5Ã|\nC(Î\"€P…ğø.ĞNÌRTÊÎ“Àæ>HN…8HPá\\¬7Jp~„Üû2%¡ĞOC¨1ã.ƒ§C8Î‡HÈò*ˆj°…á÷S(úi!Lr°ÙDÁ# È—á`BÎ³»u\\×ióB!x\\‹c¥m-K’ôXù¸ƒ38†AÔøŠ\rãXÒßÌcHÎ7ƒ#Rİ*/-Ì‹£pÊ;B Â‹\n×3!ƒ¥åz^ápÎßmøRÜÃËt°mºI-\röí¿\0H·İ@k,â4£Š¼÷{Û.ĞìšJƒÈ¬šoÂVÓ·b?[§Q#>=Û–ó~Œ#\$%wBş>9d¨0zW®wJD¿„¾2Ò9yŒ¢*øÎz,ËNjIh\\9ÆÁèN4ƒ à9‡Ax^;ì^m\n¦r\"3…ùŞz7áşN\$šÔøîƒ wªÌÃ6Œ2ˆHv9gûŞı2…ÃkG\n‰-Å®p»æ®1C{\nŒúĞÜ7„ü6ÿ«ƒÊõ2Û­è¿;ÉY½Ì4qÃ? †!pdŒ£oW*ô£rR;…Ã€ßf‰£,Š0ßá0MŞ÷û0È\"ãé ˜é\"ÙÄ§ÃêİoF2:SHóÍ Ã/;šùşˆééÙ©ri9¥¾=ÿ^¸ÏÀËózò·ÍµW*ëZæ¼ØdxÕ›¶–Ö¡×ITqAĞ1†€zÛY!u  µ’ˆ¹~Æà.°ÂP (p43¾œà#hg-º	'¸FÙp0† ÂC+PÍÊàì, ÏÀûeêÃêN~ğy@fZK›´O3êv\$­`ØC¡	N`!åzÉpdh\$6EJöcBDœ…c8LËÁP„ †66®OH°d	.ø‹œ“†Y#¨tÅH62‚ˆ¤e€ö@¶¨~]C˜[‘²&=GÀğ\\P(2(Õµ×òƒªÌq¼2’xnÃJ‹|2ù)(ä(eR¼½™GâQTy\nØ!pÎª\0Q]«¼&ÔŞœS˜^N`®_(\0R	è'\r*q–PØòˆâËxË9,Ëå¥-¢);†â]/ˆĞwŒ†ü†¼ C.eÜçy\0¥,ÄÀ	S787«²ƒ5Hlj(ÁÑ »\0ÆÕ´À €öq’IË/=SŠÉ ¥Ã D<\r!è2+ÔÃA¨ä J©e Úò©!\r¡mšğNiDø¤´®–†Ê^Úˆl7¡®z‚êgKå6´á-Óµê§e¹!\rEJ\ni*ä\$@ÚRU0,\$U6 ?Å6¤Á:š™un©(¾škáp!€Âàd`Ì>°5\nÃ<½\rp9†|É¹Ü^fNg(r€ˆ•TZUª½S¸jQ8n„«—y¥d¥\rŸ4:OÅw>[Í4”4G\"­“7%¤—ÀĞŞÁ\\²¦PƒÛhnBØi.0†Û¬°ó*jğs¡‰	Ho^å}J2*	‘J¥Wš”GjxíS8ÇFÍŠe˜à6•s¢éõ*ƒ\r<Ü0wi-00o`òî^Õk­…²„*A«,É¸Óäº×Ñi‡»Ûnj ÷2ï¥ªA\"İºô[;›òn•ÔB^åàº0-½•¯©Ï\n:<ÔˆeĞ2 ÌÆh-¡¦2‚n§/Aå\r6ŸÚÂÖ[oŠ- ·cà¥R@U3\n¤\nTû·=¬R®jÀÑú7s\"²ØÁY+Ğ\"u°<fH÷ò`aû™z¬Eø÷†“^7syo:!ÆVöãkàm‹õ¿“ifàÛ»€/İÚ¦8;<eåNÌ2Í±S³W?e`‡C*B¨ÏÍ”ÔZB¤]œ¡ëü:K¤_7¢‰ÄŠq»‰QĞ)à÷/â:dği”ĞÁàZ^ì3õ©têƒ¥ª‚t*†Œ\$€²fùz50tÕUJg«ƒ¹S\rÎcX‘¸ş”î\rw7Z²N^`oxPÅ’êIöäx?ÀéTÃkeÌ ÷Jim)Éx;X°ßÎğçCÒ=V=ÛÍï<U½Ä!ğ0‡ËnÜú;òÍÛ~AZÃáˆ7‡ˆ€Êâº+Z†=n‘õÑ{HåÊPURY³–ŠÇ¯³¢å4ËHÇ‹6'gœÚ2K´©î~¼º|hT²A¶•1¨›V£‡Ş>/å^Ãál.ÀŠSIª.À9g’­~O²%Ø¦ ´Ì¾ó)A|ÊÑ\n;-ğîn‚à[t,«ì³òâ¥Y§<>j\nœ¹NìePúˆ’O<Éüû q ñÇ(G!~ ‡åÎ`_Š\r~áÍ†`èÑ.¡>'H¢Oé2ÎyKú‘Şód:(õ,û<°3ğ: „ÎÃã+0nUYZ²ö©^é)wwôÖ!°Íòá÷1ĞıµÍ!ÊÒæ»ÔmG¿½Ö·gdÑ=ı¶ûXÇ[Ş¢ÿ<­Úß©Wç´§ïğ7‹ºÂ`ËoÙÒ­·°éô¢‘Gêı©~`Äi`Öã*@ùïväë¦¢¬ ÷\0)»êœ\$R#ªªªê†¸ªìUdæ·)KLàÊM*Ôî@¸@º¯O\0HÅğ\\jŠF\r‡ëéì]£gKü³iô\$‹DÄ*g\0\n€š	†´s° Šğ\$K0&“	`{ˆ¨È6W` x`Ò8ëDG„*ëÔŞeHVÌÆ8íªø\nmT§OÜ#PÆĞ@úš°ÆĞÎÊÑ.˜\r8ÀY/&:D–	ÀQ•&%Eæ. ]€ÊĞ¯¥.\"%&ĞònÑ\ny\0Ê-àRSOÂBŒ0 ê	ævŞ D@Âİ‚:İÂ;\nDT­ş< ÂQ.\nc2‹ÀRy@Âm@ÌÅò	‘€W ßåò\nçL\r\0}®VŸ¤Íñ€#±”‚Ú-àjE¯Zt\\mFvÀØÛF´í¦J¹pB€”(À§µ1¿ î¥LX°œÈ	%t\nM´ˆäDÄâ¯Zù‚¨r±æKgÂ´CÄ[èÊ´	÷ é\0Ğ¯Åş‘ˆğÒŒR*-n¿#j‰#¥ş¨é4øIW²\r\",Ô*Œfúàx/¶Æë^ûÂ5&Lğê2p¿Læ­Ô7à^`Â ô®â® Vå`bS’v¨i(ev\nğï|µRNj/%Mµ%¨½+ÖÆ«Şû¬âß¯Ç'„ÊüR±'''ĞW(r‹(àÉ)2–Òš„ÎÀ%£-%6ü²ò·Ë€âJ@â,ıòÖ¿N„äÎQ\nÍ0ê†‚g	ª‘\$³ó*LÄŒ.nŒ Q%m\"n*hô\0òwâBòO×\0\\FJ˜Wgø f\$îC5dK5 Ë5àaC¤§4H©(°.Gª”BFÀÑ8èˆèæÀ³ E€öÀ³.§Îk3m*)-*±Ğ[g,%€Ü	ªø7å.›ë!\nı+ O<È¼¯C¥+Ï«%ËO=RfÍòÊí( ÚnèYÓäÏ²ö%©èsû1ÿ6ê3;³òObE@¢NSl#Œ³|»4\0²U€G\"@È_ [7³S„Ã@³\$DG¸ÓÑD«5=ÒÀûK>rÈûåÔ\r ì´ZüÖ±@¶¿€H Dsî°n\\´e)ÚÉÉb¡'øòĞBPGkx”ZÍÂÚ#TK:w:Éa2+øaeK›KR)\"Æ(4qGTxi	H«H@ì&@%bZƒ–ëÍÜª)3P“3f `ä\r“I6Gî%¤/4‘vÎ\\~ä4İ¤0ÓpÃè,§îEÍ)PH8k\0ÆiÌÎ\$â€È3I4ÑPV'F^ä ¦'DäòRĞõ+Qñ`ÓõÀÔ¯8\n‚áD[V5,#µqW@ÑW‚0áO2ÿ ætó\rC6sY_6 ùZkZ@z3ryIà<5‚….W¦–àÒ·@5¾Ä¢#ê„5N Õ~ÒìÈ¥uŞ\rÒô¨Ã)3S]*g7‹†¸µâÒ•ç_Ë‰î›_‹Ä¸V\nYÃ)aä¨é«1PêÙìFI\r;u@/!![õeÕ Ş(CU™OñaSó„¨óäKPõÒt3=5ÿàO[‘f:Q,_]o_¶<à¾J*ü\rg:_ ¨\r\"ZC…8XV}V2ú‰3s8e´‘P¾sFÛSN~“S5U£5Àz€ae	kón fOLòJV5Òõj‘Şùö½ZöÁlE&]Â1\rÄ¢Ù…5\rGæ µuoĞàí8<¥U]3§2é%n¢Ö·prÔ5º¢\n\$\"O\rqöÿr)éfÍğà7/Yéì£îp´I#`Ë¦Kk;\"!tŒÆÅhËusYjè[àRÂ\n{N5té¶#NÎœ¤o6ó¶X)İc6²ö¶e+.!ƒºß—‹\n	ÿbĞÊ’ŒtÉÒ®¶¬\n§ïÒjÒİ(\0¼©2”ô4erEJ÷íd¿@+xş\"\\@¨áïö %vÄåÜÏë{`Ï«€·¶`äø\n Î	¨oRi-IBØ-†“íŒNm\\q@ñ,`ĞğKz#€Ú\ræ?‚íŠÕ˜6†ø<jáf´Ö!„Nÿ7õØ:Ø/ËTÅ‚\0ñ‚K\\Æ0Ø*_8LÕm^r‡ƒ˜V˜wø\"û€ĞºB¶àQ:5Kn®¢‚v\0Ø„xtË;`æ[Àà	øB£9!nv˜<Û¢SÒ{:P×p‹r	~±Øæî1i*B.tY¤>\rØèS±*nJæ¶¨º²7{Ò=|R]ÒøÕ¼õ­4ßiéUì2ø2´ø€Y3Ìc>a,X¬Ç3²Œñ9ó\$¹<AàQÌ&2wÓ­3²ºÁ1·‹/ÃiˆĞÈj†èsOâ&¨ ÄM@Ö\\¸œ‡Ú¯¥ş˜8&I¶‚m²x\0±	jªkÄÛ›EšåÜ^¾	™ÂÆ&lëàQ› \\\"ècà°	àÄ\rBsœÉ‰‚	ÙñŸBN`š7§*Co<ÙÓ	 ¨\nÄÎ½”hC›9İ#Ë™ ñUeçWXìz0Yº7}Ñcš±8?hm£\$.#ËÁ\n`å\n°˜àyD @Rôy¤…ş@|…ÇšÀÊP\0xôK§ w£5¥E Le¤@O¨µu¨äı|ĞR­2€ˆ%ĞaAØcZ‰¥:›<dşkZ©¥y{9È@Ş•\"B<R` 	à¦\nŠÂàºàQW(<ÚÊàé©¶q¦j}`N©‚¾\$€[†é¢@Íibàğ¨ªf¦V%Â(Wj:2š(›zù¯Å›°N`°»< [BÚš:k¹ØºÊš›]¢ªpiuC¤,´Èä©Ã9„«³e›j&ÚSlàh~®ÒNì›s;¶;9¶Õu@.<1ùÁ›|äP!€÷«zCÀİ	•	›—¯{œ`º°Q!•Œ…5¦4e¦d¹G‚hr å§÷Pà§Š}Ú{¦FZrV:—«‹Á«Ä¿»ZÀÄÍ|àPúÂWZ¬¯:°ºd¹›~!‡}­X³V)º¹‘©p4ªÂ“®ï.\$\0C£–Vóº©€ƒÀ{@”\n`	ÀÆ<f´¼;dc'„\rÛÔ,\0t~xŞN„÷¼Üy½ Ë½kECÊFK\"Zó@\\C„ešD.GfºIÁ8ƒÍ¤àŒ¥CÄ¥Y©§q9TÉCU[‰Àzê•^*ÎJ¼K¸ÍVDìØŠô©&²ÊİbÌ·KK+øÄ²¹,C€„ªí,N!Îê\r3öYøPä³9õ\$Z·ŒnÒ\$Sâ ø5¸\ràùaKŠEÑn•71Z®ŠË3eµëJØœx5ˆQû. ª\n@’©€ÛÇ£pï´Pí²Ñ¡Ö½n\rır|*r­ó% R•×è”ŠÈ)ñÒ#ÅÈ=W\0ŞB¤çz*†WÍìÊMCå _`èıîõûPŠöTâ5Û¦WU(\0¸à\\W×¥&`˜œaÕj)«ÅVœWÂÊ§Êb’fšO¼rUà›ÏÇ¼~#cUró‚5â`Ñ§§Gd€¾—ÀP²İfW¬“£ü°ÀYj`û¦ÇŒ\nò©ŞGá>K”h’ƒÜÇ¿œ¶[MfÑgÌ—­|Ù\"@s\r ÿ‹ÌÓ¶áµiUÈçm”ô~ıfíK‘.xçt÷õÇXæ–Pşš¡õ¿×¬Ùõ“-•è²!Ã»ì~ıÜ+Rw·*Â©€ØÜÍK¥š\\Á-F/bN­sôîşÜRu”Âi8r”\$\"Õ8jöRnêå5gf÷@ÜFSM·S‰cˆç5CÅä*y®Cëõ­cU°@oĞ“esIôH9QoCQ•€„ ä=cşìØå»à{ïc8S v!Àè;g†Lî5<	ñ#¿z# –qL¢Œ§•éóªç£V\r‚2\$íJ/{z éûm»¢i½nG½?~Ä•Vuß0wÍ´Ø=pµIüåHÄ€X=Şú·±Şt‘–¸ -§™MJTPÜ#UáÜ`‘Â/3\\?ÀLÁ™Ğæ„yà*p€8³ŸÌ:ÑÀ0{kãÂ2À&äP\0p8±§ÂÀYƒ\\'Ì%‹¼¤àĞ.\rÀ¯,ÆJğÃø€ö/_,±4Í~–,µ!àRn%x@¡·0Fdt\0Ü4§Á”\nKß\n™ÂG\$½¢Y	  \0@,)ğ%:\rÀ]¶L2\0ÊPV C\\Ñ¦,B\r0Wø\0ŞøRr<×UHğšøQßAl©À'„\0 íT•)(cƒ\\I´‡;…î/àikîújV^¤pçñ-PPóà)¬Ì€HxÌ öøÖ¯	Np&Àÿ\0dé²8¡':#Q\$³Q=»\0WnÂk± ,ûaSºøˆ“qbj\\Œ<g‡9&å½e¤1ÛĞãèeb:‹ÜN|#³³ŸÁ–‰Ï†™ ¡«n²ÛÁhĞwJ<8p’.°…‡9y Š¡…A41aufÄáà4˜u\nL‚›%àø/ø:\r5Ã%H¨jA^€¶„¤s¸\nĞÇñ|áx‹ÚX²” °&¼f©àáì–…ğ@hESĞ•^@:8@\rÜnòÕ^ˆäH\"ö&\rC‰bq!Ì:&ûACØJj–&	Î&\r°£‰ÚNˆ˜<	·pÅ4êÆTiwÀ-ğ…ä„2)È«ô5O·B´3¡’ş#\$š ‹ğ™eüVUB‹³©vÀd£ÀxS¥€7e!ÈDF„O`°Ëòµf.Q0DŠ#à\\“ø%Ìî±J|š\"äN\0®l`EìW™€‡\ntÇèUR«(¼…Lª±ågCcRy¸ÍTì±:j¾”úWàß°EÃ.Y©\"*É25‡¡X\\)dñ¡®\"lo'zJû“DJYX·°\"#À£†ø•	G®¥³>Ó)œªYÇ&2±,'Ú„ŠMœ¤èÙÂŠ6ÀhÀöZ¨N2È·@).š„#±BâÇn;±ßGaıÓR+÷O!|àÃŠû¨\rèÜ“:°åÔÁûĞôv[qDÂ¨W¥·rúœ…cÑóG…\\\0'WY¾Ø¤{÷×„~2n\\\$<æXQ2DwÀDDxCfHô,~åˆT\n(+A\"„.B‰`‡Ÿ¬Ç˜ŠÈL[E·‰õ	\"Y\r’C‚Öüˆ`,zÔXÈ”?oÖ™E¤K\"ÉÈ}&@`¤’ıi<éêÃUÚ¹\$OS1¼Y½jÈ^8\nˆ¯8XÕş„‡_	ğ z•±'È¥QÑs£+c¨ÁæX€µL-ÃŸòÃö\rjD«5}Qüî¦CâL&.=úP0>Hÿ8HîàªŠüG²ÔK2ˆ0úªBÊP7–Qõ%iGùìhŒ^¥&5Ñ5¢Q\"Î9ÑŠ)ùPÊBS°\n3&ÀÊ£—™†\rJ!HJ4\n.{ÅW’\"#Z\0Rªö\r9+2Â‘•DE+ie2šY’i…yôÓß&ÒõË%ÎÒp°ˆ¥´û–K(üsrpŠ%´Ü`/65Ñb2T<¶œ°a˜#„]Òâ-Ô»åÀ.!§K¼ŠŸÌmaJñ±[KT \0lPY‰'4à&¡è†—~¾ªö1têé4£Ø2jÖ'\0µŠV(œ‘\n*+W­€ci4cÊ­Ó<©ˆ±Xâ/ô~ŒÉ¢ÁàL¥&×2Æb23RÒFTŠÉÓRñ%b<UXû°Ğà±V \"Zß pÀ\"Ú[æ@m¬òA1cˆ»ÉkË” ïpÊÅÑ-æ|€öl“f4ùÃÑ\0 7³æ]çOI±Ö@‰¸©÷3r\\Dd9*Ìğ\r3>s™ŒàV}‰¼ÇU,³y0ŞÀÔg‡\0®\"&ˆÊÎÕÀ\0œÕçPèBHCrh€´ÕÌi_ÊÔ –ä`-pĞ…ç6Jİ/¬€1jç.ï•¢ÇkYÃ9Ö(} rà˜ÜP£„—à\\¢gu@º\0wÀ-0¤'‘<©Î¤\r -\ràË–9ËÂr+ÔÜïIŞ™Ë+„&“å˜Á‚-=¹î˜†|·yeĞ¶(	\rüHózœıç³>ùîN{ÁŸœø§0V „-¥!¡tèÁ¨;àº|\r£‰@Rò\n\0¨Y\"‰¢çé\0€} s\r\rëA±VÎÍ }œdßH'8 0€ş…¢91±Çæ8š\nØ@	Pè&:\n“F†\0dÃ\0Úğ5‰¡ô3rÍ\rDçCÀ1Ğú‡3•Ğú8¡¸	îkôN='À70ÜQP%Só\\×Å:B pzoDÙä 6ÍB³H›R±(×4€ ÍA1·€óÇIv q]ŠõjoD\r#)Š#%c…É±%åë%ò‹œğ_'B‹O )x°cñaä=©Â˜/ê‰…6Häj‘¦>,rà’o)GªÑìu)ˆ¨#¹&©#Is	IŸæ~©Â–_²ÜO¨•J~–ƒÕYb%*?\$yP0À°(	Œã‚%ã ‹–c <¡0	·kPtŒBø€§µÄ3\"E¦X›2q‘y§-:°@ÃÊ€æòÈ.!…qDW¤0²ÀŞ* ‡(¦ZÊ+/d¶Ù_g=•éÕ(`f§‘PŠŒ²i¤ÔÅb1x¡†ì¸bÍ> pdd©åTƒùE<[e)…ŒòŸ£y(}E†v|–]‰œÛOCQ‰r‚H°Ñ\0§A¤¹WêúJ`V3‘@BŠI\rm¬Ië¦uIÂSr•Òx	 À„’r‹I”å™HJ‡SÒæUBê\$É@Øªú\"<±pe|ë1ÌDDğ*è DZÔeÓT²ñä5%G€O€\0’ã0I„(4Dª±m•–¬×¤	V«,{+à×ÊPÿ€õ€AŸê÷Uµ]Uùeüús‰I+@ƒÕÑ\$CMM]ò›¢ğ->a‹@ZãĞœ¾5„Âˆ¨õ 3*ÏÇvÖªª©äyU‡CebjşÓˆÖ\r€HNŠ6ÙiZÆ>V)7uŒ@ªµZÒHÖ¾°D|­œ5ØĞ‘–JÖM“A)SĞ•ç,ƒi‡‰·fl™ÙPS:EÒMô÷¥ì‚©52p:á{©ii€_Òj½­í“p6.â>H(n\$”1ièIKÀ¤Öªğ3V\rÇ]^Ä³Ôãê®§\n—)0I”â”`B@¤b¾j6>hå¬F×gä/ y2‰ÔA3YGâÊ ÈÈâz¢4„…äÀk=ƒÂRúZ”¬…õAYÎªaW’ÛÖ*§	à(5”Ş„!O»“ß2ss'xg¢x\0’°\"ğ\n@Ek˜\0¡RÖ³ºœ%Õ‘¬‘'ÂB*f¨BnfèSf×¦5í×+Ê¶À“’#Bİ¯à¶ %RXÖÂ¶g²@R4`\$iŞeĞ;œ…Î	% Ê¸ä„(€|¯È‡\0àğ‘ÂĞŒ´˜…]:ÂgÔµ>ê´m~ŞÖ\"+)ÙÅ?±]ÔË¢ÆÍC0¯ù\$Sî<¤ûÍÒĞ…Æ+\0”Ö­š3Ÿ°rÃÊ;Hà‚iRÛ>—hòvg±ñ%¬‚ŸİY®½«ÆRhTŸ%ÛNÂlşc“Óïd+aØôE?<}«TfÅ‰ìš¢İ\n\nJUG	ÌsvÜí”À×kP€„ùuë!s'\$•À;•0ªEç@À®âà…ğš&Lo\$ mUM&ê ô\"€øÀÅfÎòáwåŒ„\0º\"¶à1¢ÎMÍ;€ªÑY‰`W½BÊ™\0TÀf)XñtT¼xÖ\0000ÈV¥,ÈË!s0§¡G\"eQÚT4¦Ã\$¶[ØE/eO’œé˜×<À´™-èÔH-0,‹d?Rñ,rÑ@gGĞø<¬²à`åÓsqe®†Û¢mƒ×H®ÊL.›]ÂÙHB‰§\"¹€\0X°ƒB©È7b€s¤\n« L”7ƒZ¸Zæ\$‹«•Œ\r×¤5ÛÀËwİÒgÖ/]İÒhË½;bŸ7¼…ŒM]4	‰Ò«şµ’dFD•1¤zñ—ca½äoæÕŠ\0r½;äÓPÆ 8U„!—»5°cîÕ#]­Äİç’Rİ@Æ…{Ü'…i@:¾ğ€Ê´«É§nêkXÜÂ©Ö±÷£Ğå®È8\nÎä°Ës|‰A\rQéI®bÅ¾M'ø§PU¢çá2–8í#ä;KO_}»²#íıwi=óĞ#fc´Áºÿ®‹¿ıáÖİøªz¾¡€€/&›gwÀmãXŒ	`ï¶dÀÄ[ÏiË`m¹X»›b},œ|à+íäìÀ·tsÁ+è¾iiÔ‡‚tñ\n¾>8()³’6f2Ÿ¯±#d‘…Ë´IH(\0.àİ#v/9j†¯š!ô2ĞšE/:H/°ÃA½ybj“·\rÎğzV,pİwÊE}^``»¯?Xî•-¿Â€\nz¸*àUD~?‰íã\\Hc•UñWXz\\0æ!ÅrJ²Aÿo`à³ğğÇÌBañ‘á!CÄ!€«W(˜Õ¬XâPË.§°õÃˆ`ğ@ovÎçÄf­ inÑ@UøáçUƒ<ï‹¼pòGNıUçğ©†™cˆÖ8–7›O†-£ªĞ€ì˜€ÀABXrÏvÅ³,ÉH‹Ø58¼à½Õ¸?Ìcb”CÊ¸¶5q¹‹à‹&>!—4 ­Í…(qåŸ	I©Æ-Jm\0>Û5IïDm©BãmDï\0öÅ`2ÇøyNÖæ³DôÄ4N©L`Ô¢åä0xÙ_~1\07¢õ¨‡k„ˆ’ÊhƒROÈ`j_…Å­®Ÿ›ˆ ôÑ‚m{îp0¤Ü!9'şK-ş\$Öàœ\nj~Èh…ü²QøèNÆ\0ûq{–Øxú\"¥2†/qâãiTÊF/Ø’*V@*¸g»-ÙÜÃ bÈc0	H·0\0]–@ãHƒUƒ:U,VáGd ?·ªuîL}L¹9İùuí:\"\$ƒTlœ‡Çe¾—É;ÁªVÉ\nLõ!+èÇ†T³1Ğj,µ}R\r-[Ò2“6Uøi\0d–Á/Ò¼ùè@rà.¥ÒPF	¤ÎgËõ•<†ÏS„•&i\r\$ÏR72†>fs#˜˜3Ÿë7UNÈµ\"Ï±HÜÎ+î“9 [8Í	Bü 	„A¸Â!3†_¦Zã5™3é×%r¡ÃW9y£¹ \n3Kš|ÔĞo5gh;”Ød€Ú\r¡ñ	D“Â3RÜÑg†ØL\\Îæv	IGBç´_ã8`©óñ<ıaÛ?€sÍqÖÏä˜¬ğb2NÕ(Ãıuğâ`L·‘úÓ¦!Uê>¹á\rşeó~_°§âí!…Sët1'=\r·C…½…QÓrê±­\rC¶ù*á —¯fì3`{Ø Géå‘ÿ„|U\$níJóÅˆ3Hã¸æ§;ÎR5Ø–}„Qw9êBÒµØ=k0«—FàöÇº\$1ï€œsbîîâ-L3àC\0w!Í´ P&[Ÿ#0ØØ·PSñ\"¹ÕÄ¡%rƒ{ZA´°„]ÓDE%Ñ)¶†Tòè{@sÓúáÀu¨e¾ÓR£˜Ôˆğ53©°µè # >¥ô<»\"½A:Êt\"ñz¦¦KH7´8}äk–ÂäŠ¸¸3'îN^êóŒVh\r±Pj;Ö¯Øá÷u¤f.úç¢ç\$İyWÖ|U\$ê¿:­œ¿˜±»™qÄªMãSÅ8m2è³Ä°İPúâˆ.¹'­®cºº,–¶R\0K‚XéĞëœîúéÖ]¯¯q|ëé¹ZóP£óşµ£›,ş\rŠ\ráˆC¯Å˜„}¢uÌŸ5²¤±?€œz	¦N«kÍ‰lI€pw3¢ô“KMj9‹[{Ãˆ1i…s çyNÂYÍz¤»±qvìeGÃ–qñí\"r‹åª©ëû¥‚¦õWîëØ\rºøÎ¼Nï¯7ÎC›+Ø@FJ.2Elş¦›A8ĞÅ{´Q;n]&§HÎ\\ğ>N d\0ctÊ„¬Ğ?t%%Ãv}@Æ´€ÎZL| yÏÀX/é³ªğn¾Ö„SRˆmxWÀ/ÙHr¦l‡o¯ÛşÔ©ƒ³­Á[ø#µ€ FĞk´*í~æ»“Ét¯€ÆW¼Ü;X\0¼~­¤‡¸r‹ié¢ƒ\$V×ñ„7;Úğ4;F\$õB§¯`;6õÈÛ\\n¤ôTwçj®å:pÀõãïtƒ\$	7i—¿Ö¿ö—°§7+Y!¿5.#ĞÛ‡ÍUô…Û»Gv”Û(‚ìWÍê*_SjÛc]ö¤`eö—nySôm¿Ü¹#Ş››¾½ıiœ52Äs~G;sÂğ¬?ÁFÚVûÂÍ„Û‹\0NÀ,H@T'Lói@…/¾Y€ø ê\r\0Ÿ‚ÅxUxÆd>æ¼‚½µøä@3\0yH^o\"uÙÄ„&Í‡x?Tiäâ\$/nâTÂ5”Å‰—	úÎ°<çˆ¼‚d1È‹˜Á’á)ÙĞy”|9î2ŞT98aŒ/ÖSáXÿ)ŞQãH}ÚÎØá.‰gº¬Káñò5®Z†«œ=ğœãpß0ğ¬üÃ´ìkJ\nööLëf ’ÖÁœR	€EFPÎd2 +È¥§q9d ™ÜyZç˜á!<	âƒåj\$I£Wò\") à\n.4ÑÀN3	7|¥ßæš‡ÂtdĞ\ne{Ó¡Ÿ²zâ…Th²Åa’nxÙ,%Ÿ/39Çærw=\"]”t—£<1öÎò|Ñ\\n„WÆ~àXAí¸ùó¸û–hıæ¡d( ŞšvŠ˜¶ºLoc¥8lÒ9–ÇW7Ü}wê8ChœÔÊĞw\"PZ£î¸²ö]à‰uĞH Nk˜,ŒÖıà†.Å÷©ì&@¼\$óòwå/æ<‹Oàãóÿn |<¦şHğÈRKt6H¢µ2OD§£!DsÅÂ¾é0Aº4FÓ£‡u(xèÀ]q3M;¤^R·•ötÆÊ °¿¯)\rê°0´9ŞŸ2ç¥ô„Òg3rÌ=…L\"õ	Â¾Öİpe0Hú-=ƒ±ã„Šb6«Ôa,¹h,ş[k¨{[¨E3æ½-ÅIš,±Ò¹»Öá¤è×š®P	c:´µÃu²ß\r]éMú¯Ø¤D (^©eÆ¿œÄ,åŒÒiG^<6ÖËHìjBWK<Ú¸%â«ÀwØ‚l¤.±­PTFK+¨ıfÃ&ºvÉİ0æ©]@åQx/b‘vc'\n¾A9Ìxbíñ¬ÃìXéÔ§°]yìM­}'\\Ñ)/Hgm	ä“fÏ£ø‰ºUz’6]SÅ—— ß¬&Ó<»nµztíoN¥z+¸İf\r“ı³>Y{n›~ÜË\$Ô†Ì³0y†““g%)ö î=&’{@t w„irK ¢’ì”îèæ¿ºzÙ´œ‹)›y42ªéYÆ>ÊV3“^m¦ßÃÉğƒ|àIÙxñâÇTÖ£İzwk©Œ¿îıÊ‰,<kÈÛ\$+‚1< ‹ _À«¹±Îd¾û}g©Ÿ9F]µk)‰|‡şØ÷¯»›e}òiÎ¨ëg³™ÖB³ÉİüŸœÅ\0Úƒ?ûÛ³¥²)HBHïÇDEÂe€€üVÖëmPäyPİì(œ(Ö1}ûìñ „ÀWæ05;\\\$+@¹Ò<v_\"¢Â2@bMÛ¶:áX§øVïÿ›]ê¾¼(Şg\"¤s\$Ÿ‚úB´3\\ÃxDp°‘Ä@D' Xò½*ÈNêã¿‹ÅÉ\$2ôå/VeM„ïyÓr\0Ÿ“ùö¾WØVL¼ÒeßLÈdÓ¸«íç~ˆñßÓò[KşÊp_‡@^”c¹%ÏÄ)wß©ÂsÒHlÛ\nİï¨Øw—â•?VOÆHôjü&lŞ_ËØYÅ®×…»‡É9øb'Q?2[}í¤{M\n¦¬»2\\xmlì·PÑ¦›3â½.û¯ÛfDÊË(+%™æD\rär)@‚ëh^‹¸©ØIfĞMlux·\0Ô	¹Ú¿e>è5‹5©S¯ş-¿Œ;×_ëÇ@óñòXŒÅ%,É¿Îf‰|›Ø@+ÂOÏ|J4P|ë	-óˆÅšÖu÷h8öè—ú`Î~5õlµÄQ¿;•o@òÿªıG¥D¸Aƒ_ö\0Ó„F_ZëÙ±D+:å M¹u}ŠLÇ\"•J¯¸ö(ÂLªÊ_ƒ‰·dİa£…şo¿£—÷	?…áş|›sD\\1A^\\ü\\Gæîa-\\nË£)œªÿ3eÄÜ„À'Q½ÈzfŞv}qøİéP¯7\0'¥¿ e\r:‘Upà€y·ã—x;Å_YT‰¨YlÍæ@Õ²+©ÌêğMz6…çdª)ö`5{0øW\0ñ½úBß	 ª›¾*U¬ùZıøî@Ã}lÕ˜-¢ó8pØXR`8óÄşØnG( æ\$ö%MTÀèşó\\Ïü€ÚªÁFE”dcË÷3›ò	¸ˆ\n¯<&-9Jow ‹\0)?Æ¤0x:jÁº|i²³vATÅ;I©ğQ¨¿AX&Cè£¡M@Jl¡…L¹(LPŠè3ú ˜ÑÖ0á\0 ¿HÈ+\0	<à; üN›ü(;6HÉäëF ‚Şe ‘pŒ6æ€/úsJ`ˆ*“Ú	”L3Á2ãˆÀ<Ô9\"	À Ğ^lF°Öª §’F(À¬»şB @òˆPÜ‡;³æÆF‚v5l\0àİ 00t¤k˜óĞ>\0OñUğ< ÔÄXq07¢BF°8‚á©KĞ#4Ê4 Á%èwPN ıA”Q1°D‡O`€AHBpp„`2^ÄĞc±	P,=œğĞbÀ¸³´ÎFÖCè\rŠ2ûËÿ`8@¢Udğ1‹õI¬ğA¢ƒT3Á±\\\0p1)5)F…@ÕD\r%VAdÑê§\r^ÿ¿ Ã‚h	´#êA°‹çû‡`€ô\r‡ş ©±¬éÚAÔËì\0>ÁãÁb	Àò\\p‚AK<êw\0áì\rÁB%é¬èWÁf}èmH¬jÌa¿Ödt\"0PÂ|°‘Á?Ô†³Â6§#÷Â?‚O\n\rÅR¨ˆ¬\$oö«dÿ‹‚åÀ}	S¨­äŸ©\nƒÀÿ€¶ÿëúoÿ€[\0	¤?¸£şád‡rŒ\$o÷+`X-Y.”›VŸ†I»G>\0VPM\0W¢¿GÀz]ê§\0TVÓädÜ€_ƒäa@-<\rª‘\0YÄ+ÂH¦úª-ğ¸Âå£fÀ«¡tu£æ'b¾4OäŒP*Šf¿ÊRy*9…8š:ÄGÁD£œ3 34ë5.F€V/0„Á™ˆRÃéĞ™†ØHaCF`g”+Ö¾›\0—<h\0\$…ÆÑ#÷¡m/ª¾‘ãxÀCAS ˜XÒ‹ğäÃpòˆºbc24¬¨Ğ|Éıg‹D¾7Iª‰J8@õ£ˆ—|Ô6†´-pø¯€âøš¡*B°ÓÊ=%şâÀğ€¶¾ÆÔ¯€è©ĞrÉ	^CJ`\0sEpi h3¢œ‚`ƒ¨¨HÃĞpôŸîU`‚eŒ‡&¨1ğ%\0VàÅV'X(W`¢‘\rÁÄi¡FˆkƒW•nÿq¨’’ú‘DQ#t¨ Kt\$°„€Q‡‘\n\0ØşÄBàœ‹X<ôCpã\0Kü(\0ĞÔCæ1ÄBFIqå)q‰é‘ã C~½Ñ‹ßÃq\r«åõC±\rØ˜Kµ\"ìõj‘ZZBúävŒ#œ< —CÁ\rÃu3ˆ’	å+Dàé’²ÔŒ“;¥-Å ");}elseif($_GET["file"]=="jush.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("v0œF£©ÌĞ==˜ÎFS	ĞÊ_6MÆ³˜èèr:™E‡CI´Êo:C„”Xc‚\ræØ„J(:=ŸE†¦a28¡xğ¸?Ä'ƒi°SANN‘ùğxs…NBáÌVl0›ŒçS	œËUl(D|Ò„çÊP¦À>šE†ã©¶yHchäÂ-3Eb“å ¸b½ßpEÁpÿ9.Š˜Ì~\n?Kb±iw|È`Ç÷d.¼x8EN¦ã!”Í2™‡3©ˆá\r‡ÑYÌèy6GFmY8o7\n\r³0²<d4˜E'¸\n#™\ròˆñ¸è.…C!Ä^tè(õÍbqHïÔ.…›¢sÿƒ2™N‚qÙ¤Ì9î‹¦÷À#{‡cëŞåµÁì3nÓ¸2»Ár¼:<ƒ+Ì9ˆCÈ¨®‰Ã\n<ô\r`Èö/bè\\š È!HØ2SÚ™F#8ĞˆÇIˆ78ÃK‘«*Úº!ÃÀèé‘ˆæ+¨¾:+¯›ù&2|¢:ã¢9ÊÁÚ:­ĞN§¶ãpA/#œÀ ˆ0Dá\\±'Ç1ØÓ‹ïª2a@¶¬+Jâ¼.£c,”ø£‚°1Œ¡@^.BàÜÑŒá`OK=`B‹ÎPè6’ Î>(ƒeK%! ^!Ï¬‰BÈáHS…s8^9Í3¤O1àÑ.Xj+†â¸îM	#+ÖF£:ˆ7SÚ\$0¾V(ÙFQÃ\r!Iƒä*¡X¶/ÌŠ˜¸ë•67=ÛªX3İ†Ø‡³ˆĞ^±ígf#WÕùg‹ğ¢8ß‹íhÆ7µ¡E©k\rÖÅ¹GÒ)íÏt…We4öVØ½Š…ó&7\0RôÈN!0Ü1Wİãy¢CPÊã!íåi|Àgn´Û.\rã0Ì9¿Aî‡İ¸¶…Û¶ø^×8vÁl\"bì|…yHYÈ2ê9˜0Òß…š.ı:yê¬áÚ6:²Ø¿·nû\0Qµ7áøbkü<\0òéæ¹¸è-îBè{³Á;Öù¤òã W³Ê Ï&Á/nå¥wíî2A×µ„‡˜ö¥AÁ0yu)¦­¬kLÆ¹tkÛ\0ø;Éd…=%m.ö×Åc5¨fì’ï¸*×@4‡İ Ò…¼cÿÆ¸Ü†|\"ë§³òh¸\\Úf¸PƒNÁğqû—ÈÁsŸfÎ~PˆÊpHp\n~ˆ«>T_³ÒQOQÏ\$ĞVßŞSpn1¤Êšœ }=©‚LëüJeuc¤ˆ©ˆØaA|;†È“Nšó-ºôZÑ@R¦§Í³‘ Î	Áú.¬¤2†Ğêè…ª`REŠéí^iP1&œ¸Şˆ(Š²\$ĞCÍY­5á¸Øƒø·axh@ÑÃ=Æ²â +>`€ş×¢Ğœ¯\r!˜b´“ğr€ö2pø(=¡İœø!˜es¯X4GòHhc íM‘S.—Ğ|YjHƒğzBàSVÀ 0æjä\nf\rà‚åÍÁD‘o”ğ%ø˜\\1ÿ“ÒMI`(Ò:“! -ƒ3=0äÔÍ è¬Sø¼ÓgW…e5¥ğzœ(h©ÖdårœÓ«„KiÊ@Y.¥áŒÈ\$@šsÑ±EI&çÃDf…SR}±ÅrÚ½?x\"¢@ng¬÷À™PI\\U‚€<ô5X\"E0‰—t8†Yé=‚`=£”>“Qñ4B’k ¬¸+p`ş(8/N´qSKõr¯ƒëÿiîO*[JœùRJY±&uÄÊ¢7¡¤‚³úØ#Ô>‰ÂÓXÃ»ë?AP‘òCDÁD…ò\$‚Ù’ÁõY¬´<éÕãµX[½d«d„å:¥ìa\$‚‹ˆ†¸Î üŠWç¨/É‚è¶!+eYIw=9ŒÂÍiÙ;q\r\nÿØ1è³•xÚ0]Q©<÷zI9~Wåı9RDŠKI6ƒÛL…íŞCˆz\"0NWŒWzH4½ x›gû×ª¯x&ÚF¿aÓƒ†è\\éxƒà=Ó^Ô“´şKH‘x‡¨Ù“0èEÃÒ‚Éšã§Xµk,ñ¼R‰ ~	àñÌ›ó—Nyº›Szú¨”6\0D	æ¡ìğØ†hs|.õò=I‚x}/ÂuNçƒü'‚[ñ¸R¼´` Nİ95\0°ÊCºÔÎù‘XøÙ’¡6w1P¥©‰u†L\0V«¨Ê²OÄ9[¼–O>®PK’tÃˆu\rá|ê–Ì®R²ğpO¡ÅU¬ÆDrfœ9æLÃcSvnÌËQoŞÍÃ@oÍå(‰œŞ°Ã pÍòa*Õ^¬O>OÉ¹<ù” e”ÏşŒ‡™“\"ÓÙ“±ÎP>™“H^ô²”	psTO\rá0dò{æZ\$	2Ÿ,7«C¨Ó!u Ì}B­^ŸÔÚÉ?ëDÀ“ÚƒFºİ±¬ˆúñH¹Î™`ÄéÜ'¢@JÚ¹3ˆĞ|OëÜ¹›BÎMbùf1ênŠƒ@“1¡èĞ(Õ²ìƒÌà!İoowıç»fë¦õ)I‚L\\[÷İÊØ‡8[1)Š!)¶Ò u¸~Ácõ-–6-¸†îy*	•‚“>\"m„61ğÂÓ•ä.â»~Î*¦x»Ûè«qÀåÇšG |‹’rløƒO*%À÷ˆ¨İ…¿A‹bRAxÚgæDŒfèV\\ÆİR5lú¦Ş¤`ë¬ó5`øØwã¼|ïÀ¿Sgç€ï’´O˜—B;¨Ï®^LÃ–ÑæW?‰5 ¼»ac}ªïsŞİ˜IÛîA¯¢rÎûİºO0ï;w¯xş—àP(ÏbÂmL'~Ìwh\0c×Â¨pE¼ß²:Cá{g&Ü¾/Æ‘>[İúïìÛœ)	a}nÍ¡³ÚwNË¼xï]V^ye&@A	P\"… øÂE?P>@¤Â€|û!8 „ĞŠ˜H	á\\·`¦Â@E	¡Ã‚õ4Ë\0Dûa!¦£ØëîÂìnrì¯œ\\¬†í8ço`í«Høfîø¯èÎ&é”ÔÌ’<ïrù°(jNÎeNÒ)6EOå4í.¸òn0Ü÷ÈõïÍ6\rŒ– °\$öĞîå\$“ª ÈN¤<íô|Î±Nö—jìOY\0°Rùn´Ü`äoƒìÈmkHáî†øĞ*ù-Ï˜æw	Oz‘NZ*Ê›n×O‡\nĞ#çnêâ“p[P_bäĞÖÑĞÜñ´jP¸òPœëĞ“\0}\n/á¬ØÓşö ÖöğçĞŸ	o}¦ÂS'ø‡`b¾éÆÄ\nPdÍp ?Po0sq\nï:b°LîÒõUu\r.L`ÜÑSP»°‘1mqì¥ñò~ò‘]%&Êš§QˆÀÌ ê\r‚DåpqğåpV|ÄŠfÖ8\$Âpæ&€Ò×‚ÕF‘Î&±Ô ºmOèwÀæˆG	±™1/elÖ€ú»D\0Ù`~¦ì`KâÃÂ\\Øb&ùQúQµ`Ê¾àA¬ ÀàVEW†n: Ø“BÆŒ²\rò*ƒ‚l\0NÀñDïrë­¦©±[&Gª hšrªH4A'ÃbP>¢VÆ±âÕM~©R„%2ŠÂrmÜó«\$Ù\0ä˜Ç2²c„´©ÄMhÊ‡vcÑŠ}cjgàs%l½DÈºˆ2»DÎ+òA²9#Â‹\$\0Ç\$RHÄl°Ë@Q!’˜%’œÕ\$R©FVÀNy+F\n ¤	 †%fzŒƒ½*’Ö¿ÄØMÉ¾ÀR†%@Ú6\"ìTN’ kÖƒ~@êF@ÈãLQBvÆã’ßâ6OD^hhm|6£n¼êL7`zrÖœZ@Ö€@Ü‡3h˜Â\$åÄ@Ñ«€Êà³t7zIààœ P\rkf DÀ\"àb`ÖE@æ\$\0äRZ1ƒ&‚\"~0€¸`ø£\nbşGÌ)	c>€[>Î®e\"å6¨ÙN4“@d¹‡Ğn“—9«î¬ó€É´D4&2€Ò\"/ãĞ|ó§7ƒu:Ó±;T3 ´Ô“i<TO`ÜZ€Ê÷«™BòØƒ§9ñ0‘S>Qhõr\0A2á8\0W!ët‚ÙtwH€OAÈ¦\0eI”‡FæÁJTõ4xì…sAÌAGÓJ2ƒi%:â=ĞÅ#Ø^ úÃgÙ7cr7sÀÅç%Ms©D vÃsZ5\rbßç\$­@¤ Î£PÀÔ\râ\$=Ğ%4‡änX\\XdúÓ,lØÌpOàæxë9b”m\" &‰€g4íOÓ\\½(àµ”î5&rs† Mÿ8ÌÓâ.I‹Y5U5•IP3dÃb/Màó\0ú¨3 y§^u^\"UbIõgTí?U4óN h`’5…t•‚›\r2}5-2¶’ğªçW€å(ôf7@¶Ãeµ/ô\rJ‹Kd7Õ- Sli3qU•Š¸€zÛ\0Ò)õ\$Úcú¹oF?@]LJb›DÒ¿ó0œœs?[gÊœê£%¤¦\rj“UnÉäÁ^©±R5,ÖªŞt‰FE\"­àxzm¦­\n`×-W#S(él	p²Ô%CU¶¦è¾š¥Fê&T|jb Z¢¦ƒê8	€Ê/4Lš*nÉ¦yBé:(í8Œ^9Ó8Uî KŠ¦ü{`Zç¦\nFŞ\0Cl\r÷'(`mÿeRÌ6ÔçMÓ€ÖB‘ÔÕCôÚÖ6ŞßvßçÀûn%#nvÙDÜÖjGo,^:`Û`s±l\rÁ_ê¬®×X5CoV- İ8RZ€@yÈÃ13q GSBt¢vÒÑ¢tÒöš#–ŸbB¡æèßãÁ]€ä#Îp±îæfZC Ä²©”áOZ€ğ÷Níà¿]‘°Ñò™slÈÔ‚‰°EL,+Qê@Yw·~9¶I\"Ö8!Õ´V5¹&r½\\ª7úÏWØ&—Ü¼ì¸[\r\ri\r­×~L|—Ødİ—äÜ·ë,—Ã|i€Ş@,\0Ô\"gâ¤\$Bã~ÒÖ!)5v0ÃV Ãü£b|M\$·÷åÑò¾øDèf\rì—8;€Ñï}f¾ïfšŒ¤àŒicÔ„V0,Fx\rRõĞ`‡a&nÈ§‹QB.# Y·È>wŞg¨‡òîE²ò[öÆ—àX”Ê™~RO‰ëY]8¥]rK}¢-‹ò?Œ8©v’LË@¿~ÖA*„¨f˜–øJÊMáƒñt×’¼àà-v…[#çxL'Lû>ølÏ8óPg\nÌÏ\r‘Q‘±ìÑ±\r˜M’ğ\":xw‚Õûƒ\$bÍÓ-øÅÎãìï=¸kRXoQä¹‡9;‡«Ëˆé¡sÕƒìÍ‹¹)¬Í~ÙgeBÍBtÍï‡™ªÍ,¿’íÎ,ÊÊìèKÀÊÏyèÿÍ-,mÓ€­“˜+‡¸07yCƒ€ËƒÙIzÅÆ™Y‡¹^GGW‡¸uœv0#kX‡£RJ\$JP+Ó6x‘‹1ï˜8œŒËYÌgŸ…¦{Œ­?¡\0ç¡XÖ\rî	XF‘—WÌ×”œV/“ùÍƒdIg9ß†ÕÑ–é–yï‡Â1–ú-G X™‰Ù‹@O‹ R¢yÁ‘Ïì‚!ëGuYí¤5”ZF\r¥ã•µ-\$ôO™e¨u-–ºZFøã—Zd·úi9+¦ìµ˜`M§z¶ñ\rÊÒ«I£Øy‚ùA¤VpĞ:“OJÿ¥: V:¤#:©—:cªù{«ºk l¯˜Zs«øW—Œ®ÏP0ƒ°ŒÄ#ú9g@McÏzw¯Û“[9Uì\\k‹‚÷ Û6º¤9Ó…› €Ê°y×,÷®çŞ€f6n-Zu´Äÿf÷Ù‹»c´,Ÿ¶—å˜[o[g‹d¸ ˆ:w#¬É!W\\@Ìn›` ß±º\r¡àÉ¡\$ÛŸ¸±¹¹…º\$Ÿ¢%¡€ß¡Û·ºz#ºº\$øimYõ¼cñŸÉ‚ék›I_·ÿ…Øı€y¿¶L˜˜ÀÏ¹•\$—`VİØ[‹š»»FŠ2C8Ç\$û¯¿ª©À»Ø¼ÓøÁÀòG[½¼˜ÑÂ¼˜Ü=ºU¨™Ï…[q‘×ØÊKïûŒ’YØÜàºİ‹úQ©ú?ª8¡“‚aX‰Ÿùm*Gˆ‡¢µ\\¤Ô?ûUÈ\0Ï¢ºï¢ûKÄ¤ş¢|CRÚÍ“Õ-œº‹|Éœa¤Üe®RYëÆºé¥˜Ü’¬†øÏÂ˜«ˆ¼³•ÑèPJE Î=ˆ uŸç¡öÅ\$¹{å¾8›Xî•ú{§úÈšÅİ˜ÍÌÙ“ÑÙ—š¬Õ™ÌÌ\r¹ Íù¦ÎÌÍ°Ù¬&¹±£YµÒ¹¸(Ù¼ÉM2)œV u7\0S Z_Ìüo]\\Ä|Ù©Ec7æÿS¼åÎ„[ÎÜğ<ôŞ<øüı„;çĞ-Ñi§Ù ´}™­Ñl¿˜ı!š,Å}%™½Êı-Û¬ÅÓ=·²¬óÓ¬û›=“ÔY»8³ÕæPV|Ò×øzE.Ùİıé²\rÜà¶ÔßìbLfÆ¸²Çh*;ö	Ö·¨;ùØ‡ÀQ{9\n_b\$5·‹l„UzXn—z\0xb€kîM	¹2ìœ Z\rìÅcÃ|××’/åİ}%Š›`ÜNŒA‹\0Û*=`ŞF›Öœ^Q3ŞWÍXÕ×<ãåıtR>rà`uégÌ§>iæÒzNØÍÀØ§ÃiåÜçé\$\0r¼‰şsëô–š^Cæ–ä¶è>Uê¼5è•Ûë^aç)ì	¥æJ+>¥uB®•@?íJÔ-Hµ’OJ'ì-TÊ€¼TİÙoUh×F†„{÷ğÔJ[’ÜN—ñV‘oJ&SåB\"I^5½I‚2ÉğÂ™òT«´¥é¾½Ğ]\0·¾\rkæL%ç}ˆtÓÛ·~I0õH|PkûL5ğ_TÃ<ÃwÙ÷=<ÿx\"esaKø\"ºššJH³+‡UÕaïâ'Yõ~¹—7û)WÑç<6=_–N¿hŠ?6Ü˜ıäyó,›üÃçaŸÒàwö\rÄ°×#-V@Úk‡ğ?iüb*%¸Şºõõp?ü¹ÿyĞ€Î†ùp®¾-pïë|ènÀøúCaôf§8Aà8†+#\ré°RŠ@nÿƒ¡–pæÿmĞ~Ûˆ{`®H?ívò*%§Ç¼‘v%ó€ ñGş`¶`ÍZàà.”ª­,‚6øz”¶U8—Ì|ïyÓÙV§Ÿ¼å/¿p“š^®ò×¤½mèï]zcÓìõµ\$IB0é|ÓÔşÃ@¿¹ñpRü\nÂjğ9 ÑüG·7ùı ì¤#pß­Â?±ÒÍË'ÌÁĞ=ê6HÅlÏˆ.½YŒOYƒÜ_V÷G¯²°O]I«ÏÕƒ=ª‚x‚ô\$Å÷®=È|Ïª{›Ô\nôÒ<;{:f^L'S¬A1%é8*¿^·¥p75±†—WÀÛ\nÜğ\0¸æ¸SâŸ•\02\nX(âu[»…rp€şBñ0Ú­˜xªô:n	‰ZI3¼C³€ˆà{†[†Õ&C(@}‡r¡à w2²é—Œ—nt•˜¬¨{Cñ±É†Y!\0ÊHe>©ıP\"›9t5œo´ŸÚ!€\$@\\7SS\rõ–C† Pã„„@¶Iÿƒ‡nhGƒöøÇ	IäSƒ`x’7Û0b+v5œ^gè‰r%b¹pU”Œ%)<+ŠS/Z@ 4!¢ûj¡Û8•À\0­vN-6a[>¹X¢,æe\ned/PX¥`¬}kOR‘N¼ô®+€1O\$¤Ï€ÓF6B-‰:wÚ¨ÃN²ÓT«D>ªÓx¢¶‰¥ÈY)ŒÃnş1‘&ğ7¡Á}è«&xZö\nŞ–°öÅ¸ªúWã”Û:U@ÁÅaàâºƒ@Ø.åRÅhbcT\"¡ƒ’“Õx\nÅ Eæãñˆ|ßˆğ\rÀ-\0 À\"QAàIhÓ\0´	 F‘ùP\0MHŞFøSBØ@œ\0*Æê9½üs\0Ï0'	@Et€O˜êÆÈ Cx@\"G†81ä`Ï¾P(G=1Ë\0„ğ\"f>Qê¸@¨`'>;ÑèälÀ¨ˆıÇÒ82>ÔzI© IGô\n€RH	ÀÄc\"“\0¶;1Ûìnã¨)¤¼„8 B`À†°(V@QÇ8c\"2€´€E4r\0œ9¼\r‚Ô‘ÿ€‹ \0'GzHºÒ5E!#ÓÿÉ\rAòJĞ‰Jÿ(çÇFCÑÊ&¨dŸ IÈ\"I²Vì†£µÈïG€SAXÿÀZ~`'UAçà @èßÈì+A­\n„p£‰i%ÇüÑ¿ˆG€Z`\$ÈĞ‡ÿ’À¤Ù>~?ÀEÀ\0‚} ¨<QÑ¤›å'èáÉêE’w“Ø¦¤û#\rÉ‚7rQ’ }Ë'iMIæOš0dm%  ùHÊ°\"-h#œ¹XFüM’„t\$Ã!ğÊìœR¡ìtä©,(ÿH8ò8!Jë5IxÇÕr\nåThÚ“~Pe@&eg\"[hØ–ù¿4³¡ÏË|„2ÏzÃDËÄlw#9	v{lb•Û/~\0ˆ© &I8%Õ,èIKAÂê\0—Œµ‹©/GYKµ*„>—ÑÀO/°€Ì2ÿtÀeÚ¾ÙªP93=\$ÂXád“Ì-È&ü˜|¶æ#154LUÇË‹G.ùiÌ2`Ä–Áó€M.B¦€ñ\00036—ISJ£-™~€ì©¦˜jF\\3	o4€u	(@a3¸A\0˜cµ¨`ÅP( Ğü0\$´š»\\}/d˜ê™˜\0§-€3È%b0\ncÆz`˜))%*´Ê6\"À€ÙÉÙ–ì×E4˜…F·q¼’ÑJœÇºädóÍ(åÓ€üà›×1™iLmµ2òœAó€¶À.)&q@\$œ`L§ÏÖ2Lrseœ¬ §.Àvss\ròĞÔİiÑKQÈó¤™¬ §0()Ì|ÅMbštU9!ÁED	Ñ(	Ã`8*pa<œÁı€¾80ËêsÍ\r NÆ©·8O0“Î„ÃÂd0°»OVxÁ@'Ÿ<ÀOlóßJ)ê	ğ~}ÌØ\0U=ÉôO¨'Å‡dô~\0™Of¯ïŸXÛHÈ	óL”ĞÒ (]'Ã@’EP‘LWÜöE'=¹ó\0À'‰\nŸÁN¨\$iIáĞZy´	à¥õ>ièOH6f”­' ßxà.\"}@‚Ğ-‚wa2vÓ…áÙA¢L>… ùš<0/Ñ„Ô¡P…½Bà‚€©Í¢€çT¬ŒÖ\n«„è¹<sSQ~|ƒÓ‚€P fÌi¹O€Ï†Ölqÿ„œ9T\r€ÚÔÿÑÑ•gÃ„ÑÀÉFÓ§‹%O¡(1¤hâº¶nÌm£vÑ;Æ|¦Ë”gËğ‚SaF°ÖRáÈ¤™NrÉÚ9z‘%&¤XÛË\0007\"æ2tÊ-\rh%fÅ¦Ö½õËâ3!İ\"(ê7I\$s/ ë-„7*J\rÎ•CÓLxwˆˆÙÖ—²é“´µ£(Òª¬B,+àh\nû¥Üf\r›FÊ7Rfô*™:ã\"œÎ”4t¤PæiÈXÒõ¥¬¸*â\0P.(#Ú+H¦oJAG¤ëqñ’.57˜+N	:-m`‡£õ&©µHJO°Uviª¨\0 \nGN:gR”nôç2ié)}#¥Â	Fé§©Ê>dÚ`ÙqêÁ¤½€ŸHÀóÑÆ•e©5J);HQ¿°”ø\nHÏ“GRW‰Ô”Õ/¨Jjª)K*UR°´®iéb8za.˜¡ªô³RGÌÌ!4Í£¨©@9ššÓäc: E.F|ÒÛT*˜”s¦<Z]_OÊi€òŸÕ§\r@£2øqTlVUkCQ\rOe™\"ª\n¦.ÕTéEUZ«Ô @iªå^ÈÜª½”L¸µaMUBêëVÖÉŠ¯´¶'U˜+Q ıV«¯W˜m°GºœÔº›u0« *íPúT+€!u\\ÙkVy@Æ¤”j+ÉÜH©äÜ\"E˜”P·¿,Ú`<ˆHØÿÕ”’p•ÄŸ%	l\nÚK ÁŠ¾\0®\$T!8@¨@º2’ôÀ¿h²Ş4LµæÅ+ÄÔ&°Èò,ñ|Ï±\"ËTÄÑQéœ‹‰b#w)umÅµ[Ş’õô)E}…Ÿ[Š•’Exdó)pƒ…»	nÀ¶-AK¬¨1}W\\IUÙnF^®\n•«` \$ƒ©m)«oZ˜’	PDÆP VŒ D ór%ÀR)ï„ÅbÒ±Òlö^Èwë)JB·€¹-KøD.1ÿ8Øì¬ø£\0Úğ;” le‹,L(\"m¡N\nò ¬Z“êK›ü®áÉgHÁƒ§eĞï\0öÌ\0t7]ŠÀKk\$‡yN¥¬²ÑX\0İ6ã(YŒÆÿ³‚¸ÿf›\\\r€K1y¼,å`0Ùğqo›³¶\0éh\$åÌ\n¥_¥œ¬èdR€åzEÄšŸCµhÛ<YÌÅöp!Ø\0ro;‘Ñå™í¤Š'g'*Ú!½¢Y´Xvà%›K4R–V°\r¬’‚ZÁ}Z´\rô€oúÉmpN]NõÕ5®­xUay‘„\rëjµÉWÕÏkûb•~¾+m„îËedyÙ¯Ê°Z«ksOÛ4;T€Èáaÿl@4[«ë]¶M£7n 7Û>Ü6À¶Ï“äÀ=‹hÁ*˜0HÎ«j\$§Û[`«öÚ,»íè«y	>Ş¼7púìD\$¸Àu9ãH ;ÿîÁ¡ÒöÅR¯Ø~®0[D˜ÃH•ì‚•6öÜ>-LxjëZ›kNÈ¢²¥’—nŞÛÜdgÄ;éC\\\nİPb[¤h)3M“c’D4¶0uRê#bP¯Ø5•:éaÅæEqH: öº•:é.X›‘?õc÷9¹%nÈK¢ÜøŒa±5­ƒJ‘`À7X¥\nà»q=È¿vr—EÖ<¹(~¬€”CÈ·PQxH½bK˜Üªæ–-]°ûÃÚ\"ë£QşéCºUá.a»§QÖév&¼¹ ®¨7 ]Ä¨åª»©>œ.9\0ù=K=)˜×ÀT³Ò ¤Ã_OXğı5ñ!‹b¦U«­háëóAPÖ-ğô—¼\rƒÉ%zPŞ”ß€<§x©âàÄğc7·|Ô4q˜€¢õ€p€C<•Nö½ÃYè5ÑŒ’°)×æ¾ˆÆ¿}AN_ŒRCTxÌFÀ*à3´ğg¶­À.•`*±ÓB¨š`&œTÒ:**¿7Æ·E°W R«\\×cãWĞî°[­Ş×Kb°¼\r¦oàHr¶¸ííu 2~/Õ­Á	@ßÀaIÁ ,%b †\0ºÂ¡+{î[–,`_6º7²µ.Ö@Ì†°)?Ámºmêb«a\nëvŒ¸šÔù„Û]`Œ’WÁ8ôğ!…ºëW`»Ø:ÀFpo-`7	ğ\re˜ƒXXzK„I:áç™bDï_ª5Ü>´†³Å—ìñf+<Y•âvg³¸,ä%à©H\\  d\$@•Ïqë\nêà±A \n˜ğ6–8F€'|ñI€èRäÄáT“{sÖm3ˆ€8b)à	@éŠÀôLc†M³’øF@×#Y`Â–­İNºÙÎDXˆíCxzYcÏ0y´Ÿ­3hDZÓ6\"¹t\\7”SE;ÊÀ„U#ÒR^Œ…Ş©‰s\0Cfb°ÜšğÉrrI\"Y¡	–tÃ¥¹8ZB/.¬`ÀEÉKì|’ø£öbÛÉ\n|_}òÀKC¤.ğ“Ì pÀ1:¹À#Y\nTC	%,,‚ô\r#¹@Ğ+œŠdqÅö\$”“„{’D	\\J\0ñ’«‡-`m!ğ|Àg’œdzÇVI¤vv&……AÉ`££MH\\IµÀ©ˆš|E›¸ÒùÊjÈB0ÛŠ@Ñ¡nUØÿKüàŞŒ¹Ã>–«–Ü]İ¸³hìßi X9uprù€ÀäaÈ\$7Évó˜Q¡™CAÌ>1˜ì²é¬xifìRÜÔ7*¸;8%ØŞÛ\"¤‚É„š¹ãw…PéâTB¹ªÀyH‰š'\næ”bØ¸¢°²v°ïT5xcH\$ƒ\\¢êÛı½¹¬Xl“Kııa¯`Àğú#tŒEwÀghµ1›À …zğí pó’‡Ğå4:¼\nÀCæ¢Ò2ğô„‘HèK<X	(!JŸ¾Â•;ùã¨ÇÙó,õÂuŠ3šy€sŸM€C9p€ªwz\0Ø€Õ 9ôìşÇˆ™xÔÇƒŸŠ1¨ëB–Ÿ§’à©èŸÙŠôĞ`r„)=hLÆ‚`¤çÓ?z9ÛEö?µ³ëJ°ºè1ÙÁ½÷ÀQ£²Rœ<\rÁL\n8(# Ãrèôóp>¢ŸL²Q¬™ ø¤À|¹  \"4(†µ*¢äÒ8ÀfpiWaQ\n˜QïŞ*‹œÀ\\0@HÀ;…VŠôYÏÎ†šÓüşOZxê›<F€…' Ií§¯A\n<ã¡]dP»è_NšT!\rË§éó@*~Ğ† B…¨=º%Úz †÷Ÿ­;ê³:ÓŞôAB}Ññ&Ñlú´cªİhØ`TÑÓOç˜))ó\0Êy‡œÓIßôÛ¦ı8ÏNyğÔÑ˜‹G©\r\0³Tú\"hn‰5W@}€¼şÓàÕ†Bë£}ZkVóÎÕĞ¤õy=sé³	zÀÓ”úõ©ı;\rìŒšÈÕ,òhTÉói|jza&˜Ö€\$°iŸSÂ°×HiµÙ>IìB{Z*UÀÓ˜¡Iænƒ³ÛOÒ}§ïXMsëóQ»Ø8µI°ÿĞŠƒ	Öv&! „k¿@ºæÖ#€å<‹çÛTÆZ¡.³¿¬ãj³Z:Ó	^µBç­}Yèäñ–ÂvıO3BTC¢¶É6=ª½kÿeSÉÖ~‰ÂÁ?]ij¿OúÑ¦ƒ„Àm,\0}Ø!¿õ´mF!¸[JŸ.²Âg¬İUlÇZPÙ¦Œ§ë«œO[;&Ùè¤ö¢] ŠOht	`aILA­°k£bkiÙNÙvY¢³ì¿m:êÚvŠv¥¶ıkÛg7ú )€¶ >Ğïb&°Øçp\0¼5¶I‘ÙêÀ]dp=È+:;ÈÄ)º íÌàDx@^oãĞÑ¸Aü¢ÔLö'¨öµ†§t wŞ&U€gºÀ3€¾B`/Á=ÀÇí'd> /“dbFá\0·w\0yİäñ÷9Ÿ´ànƒZ[£ş6TuºÕb´Z›Éİ~öã~¦„\nzd'âŸ@ÌRa\n\n@àG‘İ™0ı;vS½Öü¿={€¿~Ûø\0@_c0‡ovà1ß~üxÀş»›úà€†e»\0p…oÜà>ı83¿|ÜppÓ<÷IloË„ÜáO¸;Á ‹ç…Ç%8Gx.>ğoÀO=^uLGÀ÷\rğN7û´İ¶q8~&n»5ÂâlåÅ]Ú€¼Šë‰âÆí±üI..€¿4à¤“_Û¼=âßxûëŞP·™¼íè—IûÓá÷ø5Ã]ıïô[\0_à\0Íƒ»  ìœ<:â¸eÀoçÛüÚøûÀ òB€yä/¸íÂEqç‘»ÿà÷f'şJğ—‘wäÏ#7ıÇÎN›xàF˜×(yÁDğ7“\\§ä'€œY2Ë•Ü?ß¯)9eÊnGr§vQ	†.ù/Ä.YóÜª›<ì§zkMŞ ÓcáÛMşğB+­\"Û¼\ràgÈlø\0^\0˜øB@-	T€Ö6¾1§œûÊ\nîûïÆP@ \"\"ø@ë“™Fÿ™û0çtğ°æ°ÁUÒ\04€Í!Š»_|ıÖ(B\0Oc<ˆœ'‚¡¾ôt \"m)éTWÈÒÇF “¸P?f9û¹šCàÆM¦mk´³÷DşÀ¤Ş |ˆÃ	¡&ôÀ3ç`€dÎ„“¨\0O8ºyÔ@’œ\n\0I?@@¤@Ã/©½Oéù\n›â0¶ø<d\r\nË\0³ÓñHÉÙC>âk€ù”nm_:Gb§\$À\0ùÑ’ôà|±(v…I6¢0­\"KB‰ …JÂrK`|6ƒƒÕÜF³T»' 9Y9>r°@yìü@†%şÊ„–¶dä7<±Š\$p>tà\r\0|å¸yrÎÍó³Àk9+ùˆƒô6¤ŠÓ#òû\"97ö NåÚ®€ÎÅÍªùÀEnp{s^ã_;–\"îIú\0óJ <w6¨€eîjc%ØËç8è5½Ö€»û¶˜ÜL&F{ù2/w;ÉİôÇ&CDÁŞë+p€ø%#ôÈBYo:d4€#Hì!°A¤,İƒ\nsÎ±­8#=gìjl:èšU¡“B¥YX\0øeÕ¿tmd•(v†´î²§@k\\9vQ2úÎ-{&/Â¶Aï˜É<%N„…ğ`–EKJÿÙPÕº,s&˜ùß8+-–1ÿT@Wˆş8ìl…ÀÉÙD½‹x76@³\$øvÓ\"ø©€tîŸXÀßÎvj‘‹@t¶Húç'Ey@5°Ùƒ<ÉÖğ{½v¤OY{LW›Èr:ğ(µ,Ì—½ä˜\nñ+Â:(ï5ä¤¢˜ƒı’02ˆ%ŞDëQ¨BØÎ{¾x-(¨*à~.ùÙ˜‰CôJô\n—°Áô·”SÏ‡«Ñ#K²»|ä†®ØÂÉ¨2C@‰™aƒBœøïbCqèì¬yñL’7öK»‰4†ÈİO©ãfQ=Š'ûšû<!Ù™òfP+‹`Å×ÎgNDÿÖU˜šÒ¡½„!Ğ\$ú\$·Â-Ù/üö3ÒAz_¿@d~Q3ÊÍ'È>ã\nÈ\0Š11Ñ>ù÷ØJñ5Àı˜TŸ÷àk8;ï€Œûëá d¶Y«Ğ^ƒéÆ¥ç¯­\0ìªÓ‡ÕÕÛ(ÿ«²Fì™•ÿäÃ`k¼šƒQå+öI}Zçg0>¢0MW{ız_BkĞŸ;`©(ƒ¶-wJÅe&Ø¤;¸FA%L\r?!÷ŠÌ‹ô“\"ùV¨_ôƒ5G3ò‘ğs?-eØªQÏ,ÜYs?24æ~l\$ß±eØ¤Ş·óG\rérH†¿­ËáA~¥õO¡,şG@lû¿dÏ²Y“ğàlûbĞ‚ø?·ö#İÂ:ÜSß’àÊkünŸ±Ã¼Á,Õ3Jy’\rgÏfÏ€‰—äØÅõv‰½/4İ’kóÖdÎğA}ÊOY|t¤¿·ıÏÔÊKìAş÷ãŞ—şÇ?|ê†ÿÜŞ-Ù½İî¿æ&ŞÄW`ÿ…û¿êÿ_ù\0SóÀ›µñÿêşš´ß\"Äîos~¾÷ğGêÀr\$ÀDr¡à{#Ù'ûÿğ²EÍ½gûÿî/ş?öı×ò<¢ÿÓş¯ñ?èÎ:ÏĞ0ö'›ÀãºÀüZnÀ7¼ºˆ9h@ı?æ»ûïb@(ş3øo(À.ÿ»ÿÀÖÀ,ô«Şo>Ä{ÒçI\"ÄĞ³ä‘‚\"ı`9Ú‰^ËØÅë-ÀF7ø’%ÿÀhËÒ°¬*Ö¬»@|	\0iıÀ‡Ï@ä@~Cş°\0İX°ƒ­X\r,¨´´3¤Ô\0ÄøãïZT ä®€Ø6°.<;…C;2bğš\0èÉÙK=1š¤#í!±º³ 5ª:T³\nê™ªMtáµ€¨i¡l@ì»½à9¦ØëSb“@ÚÏ(¤Ğ81 ³èiAÒ ¯@Ú\r¸+Ğ8âøK¿B6–~È\rĞ8-R³ëL\n´*Æ`6ó1wĞBğ[¾OÙ»Ş:ĞãÁtï“Ê Aà\n©@±J\"û‰µA8kĞl[¼ÅÁªØ´²Co¥‚<_ã#AF€éXnğl’ë(„ÊWÁÀ,Ãê®ˆZ6¨¦¬È­Xn\0ÂœãûáJ3›PuŠÀõ° è>>°d!=VÈ{KGeşcFé¾ª‚ÉŒ°¼úªm/’‚0¼L‚ì¢XOi*†ÒË»¢\0B/“3zŸËá(ÿÁë°ãÀ©½}á0’Á¾ÿ+I¯BPp\nB°´ÇÓ×©†ôIuiµ,˜)0•à…%f	S»°h‘°àƒöÏœ{ãìÖ:ÎP #Ï_Âğ•á'T÷Ôk2h³ µÈ¾ŒáãĞiÂ¸B‰Ëçº\r¨ 0kªÎOn#>Äl–	é\n»ìB’€å\nÔ€2€°¼úÌº€³ÃîÎöVOiĞ°‚ØYÀ€büsÚî­‚\0“ñ­ø„düIÅ¿	„1À6B´[Ç,\\¦íÏ+2‚û(&¥˜\0ÙÓî\0•\r«ñp°‰^üZ)@<ALüzÉÖÁU\r€\r×ÂtdHºô\rl0DÃV1È °Á9Êd0Ltø¯Ìê€Äı@[À5¿P	P/‚¦+º‹<BzõznÂ“;Üf  \"½\nÌùxgÆj–šÎ`T€2ê4åÏƒXğ @;±ıá7åı»¼\"’€È›9hÛ®ş²>c<Á®ÿØC®·¿êù”-a\nD\np„‘9¶bZ¼¦Õ”k ı˜•ğ*2¡BÊ¡Œôü\\1ÁÄüXC¯Ğ'İêÉ¹äóìDÆD6Ô; 9;Ü+È®`ºôÊƒæJ¥ ‡C·©÷íè\0002şøœo€¨ûPH›>¼\rc×`2A•¤Îá@F÷œ`Û‚%\$‘\"D8èâäñ+AÒ\\`Õ½æÓy &74¢Àú†´xÂú\0Âºt©©Ñ¢p¼Ê i¡ÎZHe¡HRœªğ‡‡D#LZæ…Èp)»ı¸‘Ê.åbÉ€,‚¾pBà\$È%xBà&·TÉˆ`ÖE(ÔRÀºbı»Ê\0ï;F¹1i£¿oôTâ²€ôÑ4/ºk<UÀ*\0‡KöîšÅ\rÄQñZÅe’“Ñ]\0‡²É‘LEKØšÅ:),X‘c(ç?Nš¬,W½¾¼VñGBÊ¯¤RqhÅ€ˆihï<SñoÅ—ŒYàäEM„á»Å_œY±YE«Ì]Q]Å³ŒWñKÅ»45qvÅëóãñzEBû„^‘rÅ4õ±.“¾„9¨ä àÆ\ní”al*†+,`ÁS‚Uôb/QEœœ˜kQ5„XcÉİmTP€ÌT†{½`°õ¾%˜=	P\n\0…’òx{HqŒÆBËÜ!RŠ5üP`¤ö]³ä	¶Œ‹ái±>¢ÈÂ¤ï¡€èü´h°¯Fï\nN·¼<<| €¼hŒOj³ÉátÚ“ÔCÆ)ã†Fºú88(‘1Ñ8ŸNR¸iµ…ÈÔ\0ß¯ÀçàÖîi€Æè“€-€@'Ø2!‘¶ŸK@¿%X\0¤¬õäDkšò(Z‰µ\0ï¸À\0„üõë£†#ƒŒìii¡³€êãü(/-»º\$‹‡€Ø»º`t\$Ğù¬Æ÷[£;^ûÑ ×ƒ‚÷¬;O/:Î˜Ó½èë”]\n«JaêÅLóÍà9FŠúRSï¦\$ç˜T‚¯döù„ãÕƒ~`6°¼2Ê	‹µÌjÀ‰Dò2\\OGõQ8úĞ¬ÇÀ XEÂôÄÔØ4Šnlø†CfAî\0@àbX	b Xd‹Û4bk#V\r¨t’~ÍW5¨Ñ›FEN`„mà”#H «FäOXüƒó\0¦8úà\$%\n;£êÈ(€ÿÀ)€®”0’\n:D£ş€˜@@ÿà)€¦“p	Ár‚˜˜)È0“jMò\n\0€8ù\0œ(\näô#Ë!ó`ÒÔãQQ÷\r(Ö8ÉÃJ5R?±‘M³(œXê)(Ñ<~QúGì¡€RÑ¹6Ûä€‘ÿ dmÇ´]\"b…€€§˜\rÈµ°ÑÊ ƒ&>‚AŞ\$h?û¨cğÄ(\ní\0¨>è	ëèâ×Ø}RÈ¼~\rhH«¨{’,Gò<ä€mÈ(VN¸\"È\0_Ãh’7:ØŒ2Aƒô_˜>R\$™1\"\\‘æ27\"zŠ#ûGâl~rDGî‘m¶¶lÛã[€I-#Srr@u ;d* I/\"1àÀ¡ø'’]¶<ŸŒ‰\nHŠŞówÒAI ÜûŒíñ™Òİ8#áƒÀ	[v\0001€^lš#27\\¯ƒ}ÍÍÉ’3#š­ñ7E&|›i9¼”šòl€Ù&Ûvã£Â\rÈ«9µ'zC./œ3' @Áj+hå†œË*r@ÒÉhYéŒ;'ŠÓ2~˜í(96{¤A(9„áHCÌT¡D†€[¡Ò…¢](’ŒÊ,0°à¯u(¬ ò}Ê3Qå‹—‰)<R2(RL¡¦Éâ\rd£'”\nµªF2{J›’|Êu((SA»¹È±(o%û(È Â°\0[À. İÊ3Èò™†š©ò¥J1(T©2¨Ê\"j€úÊ«*Œ7Ò¯Ê]*¤«¨Iô:0.!H\n+ŸCÓÊ`­Îˆ‰(P?Ò¸„ş±L§aFƒÅ+³‚2¹Ê€9ˆá ÿ+£Ïƒ×*AF£L6ô£0¯\0×+­câ\$@cP?R¥ƒ# ²RŒÂXy:6póDï£ â,˜˜­ÑG‰5(ÈQQÔ¤cP\rò•Ã+Ä¯ï'JÑB“8,ˆmó8Œû‰òÙ«-¤·P©ËpM„·x²Ì¥B·V‘ˆ}|²G,Š< 6\nÜ\r¬¹Ò²JşSô 9€Z÷è¥ÍÉâÄ»2é€Å.¬ºEºğ€ 1K²8:ÕŒG*Aµ À&5-Ä¸!jKŠùÈÒËAe-˜9ù'#/£ˆ°©ËîÑU'Ës0¾Î'Ì\nÔÀòÛLUJN.mÄğÄ¶¥\nK…04¾ 9Lc²p\0Ê<¿ÂÉL0tÁ2ã‚B\$Ñ<LBLÄsLJ‘xhsˆû1l·n'Ä|‘»WÌdèäÀÒâLm,Ç\"²Ìw*tÁ’âLo-Yºhß¤ø\"Z 1¹È¥x­Îç„¨Ä¤ó /ƒ1ÒU 9Ì¤Ê’¬Kã2ÌËs.Êÿ'(Ì‚·vI³‚¥|¼®‡¢–Ô‘„Ì‡.cS\r‚\$âÜ’ş“a3¢r3\rÊàJ#×i‡<\r„£ 1»+ˆÎ€¯J¥4\$¡N™#è‡À¯-4jÃjM€\nĞo/ĞÊ34tÒÓHÊ˜lÈ’¿Í8LÒ/ê…÷4 SNÍ0¼Qã›«4ÜÒ³RM0]”¢¤ÈKøœÃ3>%0Ü')L?*TÏsÌêâ|¿3`Ì‹6üË|ÌÏRùÍ…3ë‰âa„J&ÂréMŒxs9á2<»s+Ì…6¸(³lÍ‘1€>³9ÍŸ5Û‰áTÍÍ6<Úx\0Ä\\İslM´û/}GJœÜ\0006MÅ7j7ó;¼í3ÌßgMÙ7C¦‚¡+\"³Kµ7Ìßs‚#~<¼òôË‘8dŞi\"Ëæç\$µ¥¦²ˆÀ+ÒåŒ,½ ıÄ 0Ë8Y&6€ç7xb/}#3ÜãË\0İ8Ø³¢L¬ä	2€é9ß“Mu9K1*ßÎ-/üä²Ÿ\n54ˆ›q“K¥üÅ“ÎwDæ Îo1SheÎ~#ìÃs˜šl©rƒ‰:ŒãÓœN|»ïĞÍ\"Ñ4êàäL79°?O}\0[KÓ‰Î7”ÜeE„²Ë(\ra¼N)3¬Ü³J•.kâ2çËBF¹ËK”ÔóºLú)I2o9¥%Ã|2fÉÆ´šsI©'DÌ’u·Û'pSByíñâ>/|Á“-\0æ¬ÃsÌÊ–ôƒr|˜O8€DH-N›<Èu³Jm:Äö“ÔÉÕ=X%)ƒ0˜Y3™2Ào\nÕ¤t	¨óÛMî,lDÕÍ£=ØKÓŞÉó=ü+èÙ‚¡6›²…OU>Œõ³I>\0²»MR\nÔĞ³èOY'„ôÎÊÎAì­SOM=DÁSïÏ«=”Ærô…¯;s­sO—=Ìş2ÏÎ?££“ûN[.Dÿ3ÒÉ£?ƒêOÿ=½\0\"LO[?u\0à€Ì7@Tø4v+p+\$Ïõ9L÷.µĞ1,H¯JÌGÌÀ“ùP7¼»FñĞ5>U“æĞ'A5´P?A\\Û÷Ğ%?ìôÌY@Ü÷M‰ÒC4LAhødÕÍŞ<²üP'ÍTNÕ?äÙ4%Ì¢ÃØ\r³õÊÒ½ÓĞoBŒEÉÏÒÕ\nÒËqA´ÃL£˜L¨aá„PDTµ	T.ÉóBı\n êĞ¯.´Ü422áØˆÓû)Å\r¬¢P§?UT1P³@D¿ˆĞ5Ü4\0¾ÎÔ¶ÆL9öæˆIäI}'òMÑÏ*3\$š`6É«'Hørv9Ü¥\nPßPÃ?lô£ÏPÄÀà<QUCíÒ_QGBÅ †Ñæ‚ŒP‡Ö4¤—€J„2|¶¶Ş¡qºÇŞé,}ƒè¦>¨0À«\$f”‡`)ÀPY‚˜( +\0Š’0£é¨• ¤Ş•´‡bWQ¼0Ôp\0Š\ne \$€rPÔs¡´\n²QÉQÏFÍôn0(ú@#¥J@à&Ñ3\0*€FZ9À\"€ˆíú #Î> 	 (QâÀêônÒ	FmôhƒEFè\n`(ÈN?r;ë\0¨È\\ ¤R&>«¶`'\0¬x	cê®(\nÉ@ÙFÈü€&\0²Ğ´nÑØø\näÆ¨úR /€„rD #ÑÄ‘(céQ§G€ÿ”ˆ\n>ÄTšÑïFRGô‚ÑœĞ%	ôÑ¥GxtjÑ® kT¦·JpArÒGJ˜,-§Ò®(Ô#»!e+©H©H•*4ŠR©K04Ar€ >øtƒG˜¯RßJ}À'QÍG	ôrQÍGE0\0’‘Hüô´\0ªeéFÑÄœƒ‰6ÒJÂ9É€±Km)´nÒ‚PÉG€³J8t‡ÒùKõ,±Rã Õ.t‹SHT…\0¥Lå+ôn¥(û(ÛÈ1Gu´|Ñ÷Gí\"£ÌÒH5tƒÌ•!@>S?M5\"4ÀRÇN•4‹ÓHÍ#`ş#Ô­I5cë#I=%4ÙÓIIl‡­¼?6ÔÁRL%0Ô‚ÓILÊQ”ó¾…3ÃùS@(\nTÑÒ±N`0´k€ˆÒMˆŞ\0“I¥&À'ÒqIĞ´T\rIı0N¢R†‘52árÓøE7  €“Gµ, «RoIÍ•Ò{Pe(5ÒŠe5ô¤Òø”%²#²>•2`\"ÈUKe?hâÈeK\\† «\0’íÀ	ƒíÈX*7kTH(ı#õÑ»KM2Ò#Ø¨	©†µR\nôŒ%*-!TÒQ®= ¢UT€?T‡´íƒ1O„\rµ.T\\å% ,‰UR]K!ÓQ%+»¤MQp\ni[\0§JåJõ!SQT„ÕÔ^“}4•7¶­JÀT™S5H´ıÔMSíOõ9ÈKQ`\\²ÈWSÅ+\0+%MPa­QµM`àÌõGŠGÃôà?.ÀÑëQã¨‰@#p*=À'£àåRt©Ó¬>­ÃëUSP•PrRòì\$ƒ\0%£áU…CëÈ0?ˆ\\µ.UuL„‚²Ò(şu7Õ(”¬‚¨î\0—UÂ7d¤NIfÏME\$5Kö?ìƒ÷â?˜0•j­J\rT@\"ÕHxü5oUV•U£ëÒİW)yS)Mİ]T¦…ËSå\$‰£p>âFc÷“üíÚ»OZ U.?åS5mU8%<à(Q©Fµ„ÓuFŞV\nµMT¼€‰Kİ_ãğU@=\\5qÕL?\rbusÕÓY\r4ÕwÕgY!1 #ÓeXÍa@«Uè>µd4ò\0®î\0İ#œìp	•>\0â=ÒÈ÷ µ hÜ¬?ˆ	ƒğ£œ?û©ô’ÔõL….ÕœÔ¨íà	@'ÖnX	5`\$J„4e÷K@ûô­V-n¡Ö±Kÿu±V²]WÕ«ÖÏµDÆU‡ZøÿÔmÖ6şàühãVX[óÖ\rVäòÕÙM-DÕ¾ÖíYui;ÓuU˜û)BU‰[\$•Ä£sTMG4kHï!]uWR}oôÓHïOoI\$À?EqõŠH; ø\nTƒÔ™GÂ:#õ\0¤şåtà«TMncôT°-D¢VJİu•Ù‚¬?„‚òÕT”%vCõ…ÊeG2;y]hhò\$ƒWÚ:)CWs^wuuÖïV½`µMÖù^E\\ÕÍW±^*Õ™WƒRÍRµW©VÍzÕN×Ÿ_Jtõ×>¨ûõÕ×¿WgÕó×V5wéG\0©Så}à«ÁF½ZUùV)Zuhõü€WK¸	4–£qHUÔëU7X½hUD×í_Åy6€ƒF°\\£õTß`M‚V\nİ`}4ÓXSİƒµ”Óe`H\néG€œpõóÑGU&#ô%ê}r	Öô”­e´ëW\"?=1I¥Zeà*Öé¥„îÜ£áT½‡ÿ†´‘,ÈÜXdít¯€ø¸	ªÒø¸\0&şkTÜÈõbMµ€P-TÚÓN`õ%Ø^¥BU\0§!œ…Â\0‹aú<€&€›GàüHò€˜?êDõ%ØeM9Ò=¿L…eÑà}Q6=Ö¤’k@¤R\ne(–AWWuŒµ WB]oÕÖY']â8µßUÍ@Ñ”‚VÔ¢¨-L5y€¡b kHçWh\r‰VO\0Vj?óÙUPÕOhâÓ«QÈ	À#€ª\rmöWÙcb}€\$ËLe?4jVk!Q`'U%^hèçR˜“EN\0Tníœ‚u\rTÎÕ_€*\0®-îÒ\$]¢76mÙ»Y½–4TmfU&8;p?5RU\"ÓúÅFà*?¹g-˜ÖxÔú½˜4ÜXì…IuSRf¨i[RSb8	4”Ù½g5 6‚Òùg *ÃìÒY¬ö‡€¡bÍ V…¤UE nÔ­½6t¥¤}O5€¶l#M+¤ÆÆ ö\"¯i5+t#yV¥‰ Ú] ’QÔ†º‡QM£óZoFÕ¥õ=Zlé­¥6'ZiÍ‡YZgQu¦¶‰ƒcíU”£Q²/5ÕsZÅ õTÚ0>•&cóıU@ıö®Q¯!ZMµÉUø\0û.Â\$YØP8RŠ?}kiÖNM“ÒITÚDãë¤K#¥x–'TRHúé7€‰GåµåTŞ-¶¾¤‚p\nµi¤ßUltÔUÔ|…V•×V”0ûµñÕûl³ûƒı\0²øıDÆ[+lİcì[ å¯ÖÏ€¿cšM5|\0ƒlİ:öÒ¤fG6²Ñ–\r1ò=Õím] ÃîÔ\\·TmÛQg‰1ÃîÛX…¶Öá£º>ıfu„»eÛÕíáb¬”kÛam öİ£kmÊQ–:\0Œ>”€##sn} '¶¥gñ\0¨Ã±ÖÊZÉU¬€\"ØXìuk®ÇTÎ>¥2URÕO µ%¶\\€ùbˆà\$\0¿`%7ğ8[:•´äÇ¿mm£7ÜmHü÷\\H=…”vÒKLÕ\$µpÒKFm\$µSH÷Z=«öÀW%cì0ö>ºcèt’€©o%¶ôXú}L\0\"ÀáSû–%ZÿoÒ7\0#Hö•µwÒ\n”{¨*ÖÍi¸	n¡Üh?]¿äÆÜí\rq—HT`õV£‡meUƒê€¿KÍi#ùÅví	 \"\0ˆÅ°¶Ô#£PM´7ÛIhÍËÔÜí\n?á¥g–µT7PEATŸRPrM5`S\n5xÜ×öíå@69ÒhíE!Ö6Ô“xúT™Z4‘˜ú×\r;QrıÑ(èÜ-Kº;•ØÛ` ştü»UKÅ/V²£¡N@üõS’”… ÷PVèm@õÈïnğüv¨ÈïbT•ºÚt>ÊE5İ;jC¼?#rLc·•”‰ëTÕ[` İyTå’Õå\0‰p-´W3ş‘½ÃÕÎÈ8-IãôS+TƒÕÊ]\"”·”ê:šÀ¼İíÍ:•=¹N¥„ )XOoÕ:—9\0ıq6Úİ¯r˜ú@!€¾ WaÛ‘]e#@/€¦?2tT]wUÉv%“mÜ’QÔ'¨õ¨Öo\\Õ·Ö‘©H<4å\\Yx¡SaYU\$–0XqHÅ”ÅSb‘¶ W)!İ õ>Yyb-…\0>UYÍKõG\0¥kw×“SEy-ŠnŞck-Ÿ	ØŸP@–\0øÈûWY`’\rgtš¿UD‹èÖÒ1=ÃèMŞ³!u€<Ä¦ıC°×¨\$t`d€9¿ÚºÌ\0‚ëz}ëŠcJDı@bÚ;õÀ\$.Ë{¡’µiš¢ïTP#±“†ñ\\É‘ì¾õá¯oÌxT¢²„ı•ï°k€ó|&eÚ<<D,³–B'|8WÅB©zkà- ^úp!é¿PßìfÁ%:Ş\rˆ\r.\\_1zĞ\r·Ë\$ä=ò0åßG|°B€ºÅ¢Ôí{z|Õ‡#='àğù€Ú­€*RÅºß}Åö.Ù_nFÅ÷7ÚCç}kßPÌ1×ø0²öZJ•¤à/Ö_eJî 7€ˆ´ <Ôn?-!X],\n`+UQy]Š6±Tr‘8ıUfÓNM»×DR¿Oø0 &Ó‘m=úÖ5€šÕÙi6×]¥;@İ=Kåş¶ÀTj]­5Yã¥ß÷ÿY]€\rwhòÔ‘RP0·şßï]uÿ2Ó€#©ø_ñ€‡iGØ*?ğ	\n_íQŞnÑÌ”}4•0…m  0æ\0ßtàí*:¬ º,™Ø7.÷;€ˆ ıUXı¸*\0004Œı9eì.¡ëÖÚ Jæ	%\nM‚X’‘>;÷!¢Bz@Ï¬ÈMtHa>Á1[ôê?\0¾N\\³<,È+­Ğ–Av8”D	Dùv\rø(½æüuÆjÆ”2(ñÜƒnôIj…H\$ÀÅØ/^²!sì@ãa\nvØ&dôš/A¥û{l¯NıÆ `ì'—¶¾T–nº,!<kŸ:İ„ìS@–Œ]°cñ­`ØŒhTøT`Æ^ T¸?;{ƒp5x4Dx=XkA³€Ç”\ná˜A°ë M®½º¸êÛÅ°\$¬S¬ ë…NêÃ¬o&“Ê›§àÖÎ È•î³:Ğìk¡£Në[§îµº„	«Òn¹ºäÒ™B€è³«ß®º/ôHéèëºõz«¯·¦:»,t0+›§2;ó‚ŠÊğãa)€ôvPL¸z)	{æ“#ËÚ‚Èæ6›¦€¸»ø3b/}˜„;)ó¹ï’â *ÈñQb,äpçb&5ğp²ˆP¦Î•YˆƒÎ1€¾\rX\r!%aî¾““<ğO\$hÁ„»„\0006/oâi{â)¯ÇÅï[®İâ*û†'à4G€ğpõa!Vh@-‚“bŒH?È ²°ÛJxáĞ¸Jc-Şø>*¸™„föb¯&—¾A_ˆğ\"%»‹-ïø=ÆW{ğJYbÉ~%¯ö;÷‹€%X/ ‹®\$QbíÄG8”„§‹f,øŒºÈ\rxˆc(\ra¢â:¾v1`>cˆÌ&a¡áğÄôa%b@£qLHkW¥Œˆ¹t\næ…Íë	ù†…†7³É¤È+V|û»Ğ?„€òŠN‰—cQ`¡ cgh 6€È«ìF0ô86xßÿ‡A]‘9\0Ã88¸ÕJ¹ËÉØÕƒc‚€ Î·ó1@ 0ç«Àab“ó7xÍ\$?8À2ÌNS„\$ÍJ'Dâ\\ğ5„ÖAï‰Œ%˜1½v3îöO¯3„!7N±Órh¸#‰;7Şãûñ{ÏÂ„³&%’ÇAw\$Û:¯Èà;ØÁƒ£Úàˆ·pK8şcŸ5ÀÜ˜Lğ…†n,È”øÈ€İÄ#¸ÃÙ	Å\0ÈĞ@:“RôNEBú3Ë¯ÌÇÌ.hÁSã=‡.3Ï\"†×ELsÃcR¹v)€úÇ­\$¼ùÄúë„iØO€é‡FImÑ™n™´!®JbÎ\r T“Ôd¥|`O¸³ÑànÇ;(hà5ÇØñ«wÍdÉ;ÈkNÓÊª¢Ù73ÆT-éù78ä\nàUY7D§„¬s™7@š\nÀ5.·…Ä	Tsf~åkÂn½«)	êmA7B’ÎNödîÍ¦™>@E“ø&P@Í •ãƒ„bøÒà:†ŒÒœãAE\0Ñ<\"ùQ¸k”ª¢É„Î7X¦¸„Ğ:\0îÆatŒl½Ë;\rò°q\0æ«Ñ)ˆÃ|\\S;(ÈéğYìës²_^ïc›˜&(–|Yj^ª¸~ZDÆ¸ÈKĞğ½£+Ü\0Ü„„Ù;ê¹=ĞÑ— +A’(—6\\iÙBz2mXB_ˆî}î€6ß‰.}õ“©_‰òÓ›eø [ÑB2eÿ|Ğ( ØfzÎZ™ƒºŞìc™…f}òÙ†\0ó˜P@2Ad‘Öbyˆf˜®bY…Nm—ÜAù2Ã——öd93f\rvd°åæ˜e9…Ë‰dY—f™naà•æc˜îe¹Šæ/™fÙ“f9˜Æf“eç~4?’_{å÷àf-÷læ“~7Úºã}ÖbY©µvM¯º¤LLÒ§ÓŠöÁvÆèéòeÑˆ\n9E…˜ˆ¹u˜U©Y\\óÄâ	 #‹\$—’n®gŠB«<ş Ì~ˆúãÜw™\r¤uCÛıù¸ˆW-d|˜ôÇ¬ÿÒyÃÚÊTzÙ	1Š,kÊ9ÇQ•VpROÄ,hCBÆæá~nYË¸QœÎp†jçŸY#ÊáNXùĞWumü¦Z‚(ÅĞg3V…‘LŠ^oy¹gqğ!ïœgz!]íp.:œq¡)	ÙägtJa|óöuÙÜƒ‚a6	î/ç‡ƒ¤õ€4d\$Ø6\n ‹€ğ2#1.g‘îs‘Å¾«å\\Ê&u¹·„º+¹,g©Ÿ”±ÙäwyÏYÇK1¡ƒ 0·ï‹‰9€‰:×Û­f6“ËöxYÿ9· QbË\$è ~tX'²Ÿ6zºàë.‚mƒ`ê1¡9sˆ@4ÍƒhDô©y2åâ˜¾vqÎ¶èVD.£\0á„6…´<®Æè\"\0®ç¶Šk»è¡>P9Ç1²vzÏç\r¼‰çØNÕŸäFYÇ–ÛV}\$:¹Ø6ƒÕ`ºÄ::';O§Od\$yF~ù¾8¿œ\"™í„š.ñ5yØ6O–ŒÙé,Q¦!=ïœt%³¨e£’\0ñ\0yf6€Ù}¬ÄáR\nÒAø`™P¢r,úC\0» ¸k@Ö¤S­zB™QCX!ÚI\0º.v‘N‚éş\$ñÁ@×TcšFæå Hi˜ZĞ2Ö‘Kİ\nÁ¤¶‘‹‚)]™»i>à77İß€MbÅ¸øä?›”µ™Å½C;ƒC„û‡Ş“c’³IŸ›4¸¿Á¯¤Ş#à0ç¾hTúMçÚD=zMèêX§µ£öCYíi¬@`º,¥ÓÅy¹Cİ‘Ùi¸ñc;›zV%¤±ˆàúé,M†’Âø…¨%~’:ENYŒî€ÚéŒ.ƒšNY NŸà‡è/’N€ 7h¨<ËA jë\\\nì¥aW-x`Ú‰çïdµš‹i~KP0ºMèĞ*i–Ë\$ÖFz|™QAV•Ié=øj!é,:tB0é-z–‰©œNº›¤V?@K¤¶AzxDbüV”úK\0æç8KD›§»Âğ^û¥;®Ggİje«Ã©F|ÂoC9¹àí¤u©önÈç(ó«\0‹áÇ*4íA1ÎÄëá“¬j\n–—B“f³=nĞõêQ¤³ŞzxbÜ‚D47i,!v£JP!­XÎúxPÅ{¡ZvéˆUøÓ€jB^!djù\rãğŒ¹¤°ßúK:4ŒšzÅÍ4¶¦bpÀl³¨ÌÒCÍCÜ¢y…±«ÄAo\$ƒŒ)6²z™Q ş?A\r`›­™\\zEï¬\rÚİƒs­¨Ö:Ehæe‘>‚ĞŒnêfínÚ¥;±®‘B‡°ç®¡•òj€n~’À‚Ÿw¤ThoêM¤[(úKKÉ®À°÷t!öŸëË¤TxÔ4€ó®î¥oÇyÆúEKRë€6:KG«À#±.\$t&¹á7c‡œ-šäƒï°@¶]°QÒQ:ÊŠß¾¨Ò¨i-,lQnÃ©¤´qOÉ+G©H¸:êf®:·ê“¯ĞIDŞë_¤†BoªìMªäAj9Îü©\néW®3«˜óF­¯~»/ˆëç±f9	Á0>’ÒöªGº¾d•µ™ÔD¹ª\\ÃA…®]bKš\"\rÿ¦F~¯Ÿƒ[Ø÷cØ\rŞË¸BOsê»1„d!ñy/Ğ…¨™n îºà¼\rŒ0û7\r‹§ê	ê%®š¶h\nØ2älõ ¬ÃJ×‘±³Ö8\"¥ hÛBh¤¤jÃJ7ê„-b*€K£ìõ°˜!ûFCV4¦½SKŒÙ‹F-¹€Ò~Ë2í;³FÊKÃ›4¥ÚøŒ‚™nÓZÀ™1¡vR9Òê\"LäÎ:.ĞÎ½‘dQh“ûõkŸanĞk#9N9¢ºÆ²dà­UÉÂ\0N°ó6O´áVÍæ5+ÑiÇ¢d„â]{Ø¬¸¸‰‡ê¶c	·¿gĞAM^= ˆì·Uğ{vlÀ\$™Pïë5·‰/°(ê\r)Â:`F_:Æ—Àó=À	¨!yï´VäÎ9îºÏŸEï†Q˜ì5ê>ÌÂë:5´<c‡‚†â‚Æ“—¸¸z»Œ¾	§M1˜[°náĞdn/ƒ®µ´Fé9¹Fˆ#`«¡vãºX‚<BöFjîdN`Qà5Œó¾´›KªÎ5oîæí	ñh;›—ı‚Îæï#¤ûÆBZË>…¹¾¿o@ck*è@‡·îÒÖ“ûî«D\\êS¶»)¹¾pÛ­„²ësC½º˜6­è†pU[›ÍG4†éûŸî?¨.ëe\na	¹¾>W@£Ğ{¼.ÈãÂ£¹şí›­Ìµ™\\9Ú˜>•­–CA»„ºùƒ×¥Ú`0ÖñÛdå]¼f‚ÒMì1óÊI7´[Îá¸•\n]éÑ,¸qÙVJ›¶Û‘?•tzƒŒ]£ƒíum*‰p›+í‹½Åá.…½¨\0Hùè«W¹ÛÑ;+ê¹ÆBzo½şx;^nE·tK€¬hq®ƒ„‘íêŸ“éE!³+n=Ìï®T±Øç“—æÍxkjú6›{ŞùƒÎÊ#†h‹½#ı[öo}§Œqàê¥PìDÕ²Ã®¡Ë¹²€•úoı1¡xcŸ£8DÜ\0Ğñ²†œšJ	¦°™ëê¡v=¼WÀFzz„mkÀèhOŞ“5j\$‹¦Xçƒë}´<A>™n¡{~h]³˜\"š\rÿ¨GDà£ÁxÌQ—)=:À5°Íê²G:ûPñÆD8ñp	¡sH2pzt¨¸‘º¹Ş\\Ú€ğ˜ùñğk¿|)‚Yt	¡½ĞPëE\\D¥0×İğÃÂ¾÷|pÎ1ÈÆs=&Æì`–hëĞIOïô\n”,òMí‹‚>Ae\\}·©Ï\\>êÕ£ÎGÏÉ7ÂNõ¯l\\¦ì¨L4!˜5c,ºTöè¦ñ‚ôñ!p}Ä¬§Ê<íQÏHè‰’89ğÒÿˆ!=ÁFÕ1j»ÀËAš@ ío„6ËÛéU¢åò9Éê»ù›‘Ä¹Æ˜î¸q ˆ\nM£Ï<_ì}½ö˜ï3q‰¨\0ùü‚\$n…Ïoî>\$z/	£ô+Ûäq}·æµç1³o\0äF8ğ?àİP½†‚Ürşä“š‚¼ğ;<ºNG…ÆñEÚcŸ¿\$*€ƒqUœâÈï}™¿séFˆŠÁ¡È8¹ïb¯C6ãú\rk•ÃGÊmù 4K<~4H!û­j¢âm8Nkr	f.UˆÈü¦zûºhÆ#¾S¬rU(	Zs„¹½nŒz!ñ /%\0‡¼ÍÃ/&û}¿ßÉæÚº6rxW`5˜cGµÅÀOÏÖbáˆW\$­bÊM]öá\$¾?ÂŒzƒêÌ\rŞ­\"q»Åéö«J‰ÊÎ˜nò­ŸÙ€¬A¿¤§&}šğŸ#[%çÉ¸-Ï'gt\$Æ•ÆjòâL†wN²reÄ\0\$8Zš#§¬:;¶s\0MÛò\\¿éƒ¯ÜÁs\nD¯MóeAñ„õ„êûäÿfÆ¢4IúBÔ¾’Šp`Âó@%Zü\0004É0ˆ}òO.Ñ\"‡­³L4¡±‰æ]\"˜'îH¶Ÿ›fÜ×™1ÍĞníÑ‹Ret®FŞ®ˆ.MY6ä¬–È™lc>h5ºÓ‚}<ÙÉŒéüç(ÄÜ7FLÑr ›m2(%„üìób7ì”ÒC\0[Í¸£M›sŒŸ#V’6‡Î§5M	&vî79ÎÏ7¤¹¬ã@¬!¹\0é†|šN6\$İ”ƒvôšÒnÑ!ÎTœÈ ãÏâ˜<ÿ«WDÇ@MØ€_Ğ(;İÌã'hÅòüLÊd©Êİ+øøríÏQäË¤HiåÊ±3,¥)t]+üæp=<è“tq1o3	FÑÜé³eÃÒş¢˜}Ò%\0001RÍ,”¡S˜OÆ_IÍ¥Ò)lt›8¾LIÄt¯:&ÅÖ\0ÏÒ¤Í!?Á_Ó^}0dÓ\0i\r'¸ÓgAôÙ)4Á?ôĞÊ/Lt·ÑáÎ¸IïE¢|œû™4W§?mi7‰Ïègİ	Ğ£u½ô/C1ìI¬ÀyI?CÆÛ{SZM±eĞmíKŒÊP \0”ê‘~ò\0ı¤A5°#.\$s¶ĞY)“û|ÒŠM9yd]Ï«A =9	õhë^šßÀrE@SO‚#>0L¡HKğôHEÿ%tÄñª.ÑmÏÇOüùfŞÑ¸R{Ñ~éİFğ%¶8ÜsKµB£ìÒYıw]/#ÂQõÌØÕcc·)HT_GX\\½pÛr>ÍÕ•¿Ø×Fµ”lXÿc½V½nuÉÖõ¶@uód85á¤ßlBÉ Ù-hEõÎÚTV\0Ûh=`-Tuvå’rTg^5ßÖQá×=b4l£ïZMUà«Yxuö'vC^M±cêÙ“UESõ­U1#§dî&vÙen@«RÓn%½“Ûì?dõ_vOeÅ—W‘öiT¥wf[)Ù?a=¡×_/iVMÓX…«]–ÙVodõ’ÕeÚf´ÒØEI'j ,ÈóÚmp®RcjÍÖ8â‘?^¶ÆÚïVg5úZûc•+}·Üskè\nµW¹ØueV‡ZõÛ½­vÆöùØàTlUÍ^UU½•ÕÍ[ÅS=Ã·kÙ\\İ›ö;W7guxÒ¿Uí86ÕÍÚ—v¸vïÚ(ûvÊUÍÚOsôÇÕ§Û½ow_UÌ?ÿiõY×³\\utyQğşçu¨ÜVMİ^]ÓckŸnôö¿W5eıÉYG^í%Öİ]P…_î[cWísÕ|VÙo=’÷•XÕwu¸ÖYØ\$İ•XÛYq:w±Ü]fõ÷ØÅd=ÈÖCUõd=Ìv…×=£VaŞ]ÿHòÕûß`\n]Ñw¦?wi•÷QlOjùö§ßzı÷gßÕâu•ÖIÚ÷–÷{Yx4ÿViHèû‰FVlíå»×+Ö{FÅÃ•¤ÔÜ>£·•µ\\sErVrÜŸ×ÙwYÕ}\\uÖÕÎuû×Å®½yÈñd<cÿ£pítÚq]9]øÖ!j=Uc;yb‰ÕGS±REå×”TûÙ?s•'×‡QÌ…TÚwF÷}=ÎÕUm„ƒ´ùwûâ-6õİø‘SïC.aıÔg&x{ø³·®-;îß¼i^1âÍ|\0ûu	Z^(I7Òùâş§¡¤cí;V§¸üU%hÍœ¶Y±g\r›–t\0Qh­…v9ÛcP”¶Héy‹·—†Èæ?8axDóòg•-ğ!‘3Yßgµ\$¶ŒYÔİ¯j7¢àP>ƒªÇee¬Xb¾«†sÚøh»a†›­Y£D/fÁØnáÁ¬¶nº=ú	^Î¼†ï³:øëöV››[°L½…ã«N¯a€êû¬x+¿ëÛÅÿäw‚9/xè>á•+¯Ûöa\$ŞùL;(”ÒØSF…tÑàƒ‚o;³lyÊÁxs\"€	E„Î ºßØ-ƒ@×¿ş5àè>…„~=È!ú\0¢1BUSÃbƒÅ\0O¡8L}„ÖÑ«„¹4q8L:ÉÎ.¡6’ò3ö.¸Yr®oÉ€ÂâYz[öäæ_+·Q¬põé?à¼62Ù/x½bÂ2ÚÎÓâë~-0+ñï–îr~œmCˆX!şŠbæ™º\0æí¨ÈA8‚9ˆæ&Rh	H?É–Œóï©^¨áW¬dåºçEæ¢¾ŸbÏŸàØÃz?Ë«Ø\\<j.ô Jc;²Š\$Í)Ã;N[°›Á¢Åyj	_¡œHÏIÂÙå°:ÛB*»­Ä¼“Ê3±:Sóôéùªä.lf¿P›QÃ¶¿hF[¯õ‰á6Ã@p\r{äìçÓìeú£î;|¶™çVïsêÌFN¹¸P+¹™kô™oûg½òÌ6¦[•©¾>ÛùµíÖ˜¶{lä+7Ù{ç+ÓfÔâ³íÔ\nùàŠcl=y¯œ¾py;ÛÖB¬»\n£­®·º÷’Ã¬m“ºÇ’Óæy÷Ğ%ÂhĞ@ÓL4``î·{ÔcnF®Ê{ßÅkÀóˆz¯Ô^úíéÿ½ü…[ïĞO´U|\0˜ùı¼ .Êd©’wÁy(¾gğnJ×Àd¿Ï¼ƒAOQïF_:×bŠPPÕhÖöÙÛaùğù–,Ò	1ñÚØùĞ:']Pæû¡g¾}ä6ëğ6XĞ—ñÅ˜/Pİñœ/-ƒI°¤>üMˆÍx1¶bŞ·Ÿ üUò#`Üÿd3 ²áûz¼Å”?¡6üC¿txÅßƒÇ»ú¸:LëòÎ×»Ÿ#,¦ø?0|·óÈSìmwòÑTîŒi£Ìß6üºâÿ8ñïò/Ë°%çÖ*h‰©wÃ§ÀÍò,¸Ÿ@ô`ÓüŒ2çĞçM}ëÀÀEıúŸÑÜ ı%ôoÏa)©_ô¿ĞQÕNMô×¿ÿ\"âYÎ¬Ñ)ˆÅçÎë›ÿƒP¾wÔRMÆ‡õ?Õ¡.B\rˆ5ßTbXÍá\$X/tÕÏÖ!)Á	)ÖI7Ä½[1}„nËß`ğƒÇŞóoñ`“£~AÎªbtoÊ’ĞwÚŸhûâønı/{IÔŸ°Ş}<vÿ şbÃ×ò(>8èÓÕ	µ\r3şå\"Šß÷(\rpıå\r7ŞŸ{lùÄı:ü‹âøàïoŸ^.}û ~İ¯£Á¿ò/à.mè7‘\0s?T~?áï’ıÿ><Ô|‹öoãMƒN™:Æ ÿyJq¦\0¼şo¶\ró£,<Ÿ}2	PJ†L~?;Wä-ƒi¡_İ¼\\}ã³àÇ:\"ıPA÷Ğ;5èÉùØŸò\rŸÏ @…½ò+‡8ƒ~…ÁfDß¤r\rùäÙŸ¡ï“ú,t_\"ş¡ÁÖÆ¿Yú·è?¨ş³ú'ß£çÁúïë“ş´}„cÙ¯4\"Öl]efÉÏÈy³‹›Ôà[ÙI LµNşí¸×a2ãÁûÏî ºğª!fÆPùû§SÀ–#	4ÿÀ_ŸñüJ’ı?ñß½‚²Ä ü[ÿÄ~÷û×ğENç®’4*Ã‚Uı\0%ŸËÆ8Ê‡ÈQ‡`èòS±¿Êÿ›H??Öh\\íö@–P2 J[xL²Gğ?İƒıæÛ\0¬È÷>Ã¼µ·/åR¸\"3ù¡HB{Ÿ¡öâ<.~Ü„l}}«<×|²ãÁş_û^±ÍwÇ/_J¹:Æïš´Ş¦‚&—ûÖÿwı ¿ÖhÆíıïkÿlN[´TäÄ@(´z€~M—0Ü#òh+Ü“6GETh˜ckØÑ tS2á(Ïq[Å ZÍè_ç>ªßY\n‚TTE\r\";(ßX s¢Íõ˜€¹˜-ÄÃ@¶D kÁS·J{(Ñpˆœ× ÏaÁ¦¾^\0ôé³bZf{ÍôÏ#di€ÁÎˆ¡DìL<œ¨2ÈlĞÄˆ_ãÛv‡Pæ“¯Ú	ÿ\0%ÆSÀŞÂ0Ñ’*D“!Ö½gĞ…;³Üv4dP'1 ÚßqZXb.YçfÍ‘Õ´[<ıc¦‘S¤œ['ä+ñˆ™ÏĞ‚|^•pøúÿ­ê èVáb…×İnª1(p¬Ù\n\0’2ä*ge G} ¢-/;Øï1^‰Ÿ\n€Œtqz€áP ™[ì ×	ˆ‰½˜p\"%’Z\0dí¼\"‚9+û¢.FOÂL1¡o}ƒjOªåğüPÑhCDE\\d_jŒ™9LÈc&¼9ÔĞxVèˆ7À5¯|te‹16¹P5B²¿\0ì}*ã2JÀnÙ=fäáò—µBQá'ìrR	}ğéãRÉBÔ8>–KØÆ°MC>QÉª`P3inÕ¯×wP¬ãŞa¿¾	# c3²YHòõE…h1øÇ_÷˜k0\nÄpe´GÇŸç´1ehá=\n29t*¸\0h(œüè!sQVåù\0İ{j&­ƒ«+@DÌş[Ö·0ulÏaÃ#•ğ²M;\rƒtXÇÕÃjƒğhQÎµ4‚CM¿3SéM_w6Í;A0n{lÖ íXxßÔz	šzfƒHBØî²¯rl	K!dOˆ# n~øÎps].1 Ájhà0Ê!!r0Ú¸Æpõpïd±9iDà©%r‚òÓùş£×füÎ\0àP4	3Ç€´gïÈ7Ú·Š>Jü\rƒLïMù™ü¹2kÚüá+¹8*Z·æ€h™ŒëôFßŒÒ‘1Zô½ùƒhdFÙŒ.ÆAÄĞ¹. mNY\0ÖƒÊKÜóXíAx6Q|£ˆh8fòÄcğ/Û%µ}°å¸ qĞcnWA`½ù¤`PBL¥¹€æƒÉ‚j`+ ©àé \\fî”Œˆ;ÈĞàëÁİg®İ˜,<ÀCÉù’;>g­õÔSà‘:Áğ8Í\n,îÛ³XAÖòÜ	c}H?Ã²„ë‚S=*ä¥ì¸8@¨Ğá7R„(«…äÄ”^Ë®7îgjŒÖß€W€8†z„8ÅYüÛ|CÜ°‡A‚ƒFDë}#PxE\n#8„PÙõ5ÚnğM¯öFXºÄ Šù¼6ƒ„r­İŸŠO¸z¨B_`LÔ†²®bE©”NM­ZÈ©ƒ©…«öÇ\nP>AmÍî7üPG°Gx9“Ø1¯á\09B^ktà¼£97¬P<7µVÕqş’¸JN)_u-€dÿaıÜæG`á<Áo¨Ä³\$'ĞJMõƒ¯…ôM¾	ó„yp¡ÜB4€˜iıô(á§ê@Œ8Uhb~ <(ğ\"¥Y§¢w4§X²7fzPA \"´ÄûAœbîTáTm…T!¸û•ä9­.PB­LöÆh.úU°MÌ_Ä•#VpØù“B¸(©£´[e^	zG-è— ç9gÒtE™dÈ?€CÍ 2ƒ–äV°ÉˆSOï›'<Z‚uŸ(ËÒ{¥e©=©šC°¹ÛÖÂê\0×¶Œv‰pO&ÁKi´ô–‚ Cà²·4n†|‡,/ç'MPÂU¹•~ÚlxvĞ‚‡©(Ö›‡(NQPÛ°d”‰\\ò¤TsÎ‘ˆÚ¨È¢… ÍË€@\0HN©\$xÉÛNo_¹)wYx«qÎ<8¦Ü\\ö9ÈsNÍ–é‰'†HC\"ç‚‘°ˆb !‰¤RIN’¹ \"KG8æå	è\$³s“ŒKŸD˜F£!‘¨“†”çÙ&ûøi İ@œb7Š;hŞC¡Ã{‰ã”H‘Q(è=Ô5qÒ0ÖTO‚ËKŠ–4+{pOà‚%\n†Í	m>JWølÂCR«Ãr†Ò\$5)úVÂLpİÃ¥ JE\r¡¦ØÔ¤ÉB‰8Ãi\\”6ÁÄønb‹²&‡\r¥2<8ÔÁãÚmÁÛ‡%\$à£§À_fç!©Ã_7…\r„+Ä63À®„˜‡pÇ´:V™Ê#Òd'†d¢MĞt9øjĞèJ#CYrä”¾L:ˆu„ù~”=‡:t!”û)A]i¨ÁfÉ%û“µUp)V¬.¶J9nyGn«n•{»È‡ ¬íß¹W€\nàU”;·wÖïõ^óÀåG*ÍŞ\n­\$Ş£”Lrëg„iñ«xdtÑe:ÄçbËİ¼>\0ªñKë·u%§SÖæ*Òxö±Àİ«·7^ë ^%)©V\\°Lb÷r±Tú­6T\$§ÙM\nŸ•Dª<¢,cSì£‰LüA?KaïDT2¦– ¼@õ!±”ñ©.U\$ì}#Û®ƒ·‹UT.6v¸«jØå·ÃÖC¬Ïvâµp’Ö•WK[	ªÎ\\‚µìíâØ'p.ß–È;°Zb´¡iR…ù‹KV¢-’_šµiò²²Ën–í®êQ–¯²á#õ}‹nU|­¼Zş©½frGµ¹ÊÎŞŒ]µ‰vË¶Õ€¡ùÖí«U[ÒYojŞò8†íVù*Àw\"·áy*ÅEÂ+YHŞæZş±9Ròá„êe”È p#œ¸aZ8}Ek‰•+Ÿxh³Mx1ÛÅL'P	®:væ‘_ºËe›ËAÖƒ®u=Qxí@h”+Ü¨\\ø®•I\"á¥\$ŠnŞC&\0Ít¹Å4@b p[º¶\"Òê•Kî¼íD¸Vü®MMƒÃ×Kƒõ‡èY¶^A•?d)ŠX…!lIÓD…k~—“­‰?¸¼ÍKàg7É\n©Fœ ë(ô–,ª,‹›lòœé9áî»'‡Q8„ŒDoX ÇŒj`Õ´ø‡¬ìh¹¶èrØ¼¡yİÌMÆn\0›<°²ôÇµsFñ6˜;BugÊİæÓÉâs×¶Â\0yl|í2ùƒ¯\r]˜s‚ŠjØ2B+ÑƒÆä=¾ÄÓp €DO~ƒÎ2ˆ++ÜÖî!^î²H{Àü°_£ö¦li\\Ë†¢†`\nÄK÷&£/ê´Çj 9‚ğ²ìİ¢†cd€€¡D'­o@Şø²cD–/?P†\n.YòŒÇã\rû%¢\0Ù¶¢…(†LEDGµµ™å­àÓ™Ò¹|¶x™kA¶!Ic›4Aeo¨àqŸ '®9XäÂáXx¨CsW×ÀÒ‘\"{¶Ó€\rY!‡èÌŒu¢ù)Ïñ\"5fFN¢±À¥Eû¸›P¢ÓöÏóÅH£·‹Hš¾l	&ü­±Ó¬\"ÜmºQ¿tZæÊ‘WÛ+Å²á¹§\$ ÄßÈ.ÇŠ-`a	²›F8·o’ÜX†#„€åáº„&R©Ä>Âî> ‰à}„\\ã¾ìöX9v~äê.©àøºño/#ëŠxı¹ÌÄSö,À™ÎŠ4 ˆÿc>·ÒpC4åÙÎù¶hgğÆ\rEì1@O|4(e \\äÅö6*’ä	àØdÇ!¨Ò‹íxæºMp`\0007§DğÊ4)cdšP‰ÃZV\nğÉ¸)¡ÒÀ@\0001\0n”üa°à\0€4\0g„œaÀ\0À†Œ5¤´ğP@\r£F\0l\0à°XÆ±ˆÀÆ#Œw˜ÀxÆ¥¤€Æ,Œ†\0À¤dÆ±@FHŒ–\0Ş1dd(ÅñŠ€Æ8Œ–Zx˜Éà@F.:Â1XhËÑˆ€€6\0a2œaĞ@\rÓ‚Æ`\0gæ2\\aèÎšc(F7Œw˜´ôepñ’c€5ŒÏê3Lb¸ÉQ”À€7\0sV2\\b`1›cF8\0d\0â2<e˜Ğ—ãF\0aB4\$b`ÑM [\0l\0Î3üf8ÆˆÀÆZ:ˆ´hXÈ±¤ãOF š4 ˆÉ‘¨£F…\0ir5ŒeˆÊQ¬@\0001\0mÂ0ÙièÅq¤ã`Æ+¤Ìg¸Ó¬@\000520ükˆÄQ™£PF;\0oÊ4dk \0\rcbFna™Æ3|kHÖQ‘ciF0{Ê1ÜeÍ¥#(Fj­|¡\"ğq£ÀFepdj7¤d˜×qˆ£GFñ7ÜnhÅQ–ã9ÆìŒËB2\\kĞ1¬#OF…Œ²M>3Lj˜Úñ’ã5ÆŞ\0â5¤g¸Õq“ã=ÆİŒT\0Â2Ìg 1Ç£(FP!Æ5HhßÑ¯#^ÆåŒ<\0æ1\$pÀ@\r@’FbIÂ8ÄcøæÀcF‡ÀÈHÛ‘–ãCÆGŒı1HÄÑºã\r–’\0i.2;ÈÜQ˜clÆ‚I^9Td¸è \r£FFeŒ‘ò2\$bØÉq§ã7Æ[Åf8\\l¸ß‘§ãqGÕÀŒe˜çñ‡£§ÇŒÓ®3,exÅ‘ÛãGA¡¤oXê \rc—F²P¤aÈÏ #¬Æ„Œ«†5<q Q‰£­F·™¦6¼l˜åÑ¡cÇHÍ‚<,h`‘Æck€2/ÔœgÈÙ­ãÂÆaˆ´”døÈ±Õc¯Æ;Œq3ìl˜ô‘™£F8j44{ØÍqâc8ÇO³<œcøÄÑÉĞ-Æ‡~8äsöÑŒ£¾F1ŒºFş8lfÀÊãiÇŒ9áâ2lxåqöcÉÇ]\0g8ôaĞ±¢ãÊ€5×’3ÌlˆÆQç£ÔG\$AÎ?m¸ìqµãôÆLNZz6¼uØÈÛc=ÇÜG68ÌsÄ±–ãÆGŸ’@D~0QŒXfGsŒƒ=|g¸êqã\$G}oz?dˆõC£üFõSF6üoøØñ®cóÇ<9*9ÔhhøßãvGG]¦4üe¸ğ‘ö\0001GÎ\0cŞ3¸YÑÀH.!9¤ØÜqüIH=U¶;ähbÒQË£§GWúAäq(ÔÜãÇ\\× †B,s(ÓñÈ\$ÆŒ÷ôŒlèóqÒ¤ÈY]ö2¼xÿñ¢¤/È%Œ“Ğ´”pøÎèa£êÆMã&7¬m˜Õ1£ãGëŒãNBätø×ò£&ÆÖİÊ4<e1Î#ÊÇO÷²8Œ€ŞQ½OF°CR9Ô{â1²dF~­25ü…éàcÍÆ,‘E²=Ll˜ùQà£ÕÈ+ŒE\"Æ2ô|ØÈ±#ŞÇAG´”Iˆa£ÙHÄŒéD„dXĞ±õc‘ÈÆc=4…˜ÕQÙcLÆ3‘= –9TjÈÕ¨#*ÈCŒ‹\"æFÜfxÎÑ¡#3G#õ\"?¼‰ÈÍ‘ØäVG½#28Ä}X×ñ‘¤cÇBÇ‚;fy±ğ#1GZŒeÎ2\$ƒ˜Ôñó£^Çï{¦9„©‘úc(GîÓC¬oHğ’Dc&Æ73R=b9‘Ò£úHyí²=ä‘xñ‘ı#vÈ@O R:ä|ÇÑ²#&É\$\"ö3Ü…ÈöòL#èF„¯#Ú3L†˜Ã±¤,Gò/Ê3eè²Nc=È­ŒI v4,q(İ1ˆä%HĞ‘á*F<|˜Í1¯cÜIQÿ²?ül˜ÖQ•ã.I‘õ\$3<©Ò\ncvGu’‘\"*G”Y‘õ£ÀÇŸ<ÔŒ(×±³dG©’¹–Jà(ë±úäYFSŒ‰ÚA\$”ğ1õd†ÇS‘5#’6Ü’HëÒ£(Ix“\"Z8Œqˆôñ”#\$Ç¯Œ; Z6LtÇäÄ£’GJ\0e\$’34nˆâ1ğãàIÍ\"²Gô‹Hİ‘#^Æq“Y¢3|bY3ñÅ#nH-<’>œi¸İ1Æ#şÆ×’¯F‘Y\0Q›ãFFDáMd•èüòc?H‹LJBŒbIòTã3ÇæIî@T|(ñ’Uã5Çé\0bLJBs	4¥ä>ÇŒ“m:ìb@r ¤HA’W1Ì‡ˆàpcÄÆË‘u'¢BTaÉ.‘Ú#3GzŒWÚ4üÄ²£šGŒ’¥#>>Ôu©ò¤4Æï’Å&®?\\œÀô£dF†ÓÂK´‰™#ñ°c‡I2ŒK¦J}ğr`¤ÖÉˆ”#Ö=ìbi?qÊ#5ÇmŒ«(^:k³#R6dVIŠŒÍ'3<yÒ’_ä.G4’õ&Â:x˜ã2G\$ÅG{r:ìp¸×ÒZäÎHmŒév?üc9CqŠc\"H¿!v3ìwóqÖ\$‘H¯›(æKL¢Y	¬3#È4¦’?é1)\$’£ÖÇ£‘ó'®7kù*d\nH„Wr2¸X×ãëõ#šE¢xÖ23e!Æk(b98İ8ãšå<š•v44uØë’“¥AÈ§*6O„›‰€I%GƒşH’	<ÑØãGI›“ÿ'RKl“hıÑÆc£ÉW“)<d 	?²iäRÇŒù%şLé1)Kq³¥ZÊb•?fGtz9R¤cÿÈĞ“ƒF=”}¹RK£nI I!F?<œéGq™ãjÉ~¿%\"3ÄŒ(ù;£\$JÅ•>0ì9*²3ãçIØe\"&St(Å²#ÈÈÜ“M!6BÔ¡™01Ğ£YHàÇVAtp¹Z²´ä]Ê¤’w&\"GŒøÜ2¥jGéŒ×#Ò5ŒkéNÒ¥dÆ¹ X	,‰`RdêGC‘3\"Ú;„zÉO2¥#bÉ\r”'®>Œm˜ÊŸ¥kIë_'®1<9£¤1xcÃÉ\\´£t\"%jV,µÎ£bòCıô@')£\n²gä³õVª­Õİ‡Õ\$Ú»QJúÍ‰hk\rU°*”`M-‘<´EdBc•¿ËMUU-<B¯ÅiğÿÖY»(wª®­ØšÊå¨‹Ge¬¬o–»ıJµÅ•ÑÔØ“^¬œB§†©QœKZ–º\"[‹±×bÒİ^>(×Y`¨ÆLM?%Ë?% -fÂ˜õ‘ĞùT®­Z<Šî[ø©p Ä½©]vÎ-ÛJ•×mræ–Ñ«óv³-an˜õ` À,»p‰‚²‘qs²Å:²é%Óà—P©‰Â×úŠWb\0¨ü—h±ÉGä·cÆ%½Ë·%|¦œ“zğ±0GŞ¯yaÆ)4¼p#ÂåäÁ§\n¶T¡O0}¥2ñ¾/p?ÚËÖ½Šöeí;ÇW†&0íÄ¶E^ÄnT¾3–z´c[ºçvËÅ%²<‹´£]Q4AÉ}’ûÔËôVÎîÙT¶}ë¶R<.\$ƒ4ì¿·ùÉFÜ—#0NÃÀĞ×ËûYì\riàˆ\0kGZIŒk\$Ák¬¾NmŠs\n™—˜5¥!KB%üK``\0­ÙÜÂ' \n}•˜D¨Éf‹³µÿ\0Ö¢<,¹´Å-³@µéÇiKæ_í,ùfe•/¥Æ…¡Zõuò`âÀ¢S˜‡0¹jX5@ªW¬D´­Qgp‰‹\nubZ‚åx=-\"a:­\0J¾€\$®Ûxı1m`úÏ \\ªÔ@!-Z¿µHJ—À)Õ‘	4M\n™e‚Á©kÎáeı5zbœÍ|@•P0«9ZF½¨f\0½Ä\nò /—=Ë–œ¸ºdR¿ÀıÒéCóK§­-atÈÉl‰J-iT\0GD•ò U«ıÆ¬ˆ\n®]GjÅ•©\n;fGKW™!2eX}•“jº%ªL­—_2ª\$ËÇàû+c&U+œX²±Ùd\nÆ•™\n¦_ºş\$N•]\$¸€0¨ã›%¬z˜õ-å^2¤µsÓ\0VIKõY\$³D?Iv€Ş?Lt,˜èÙÎµ«RùÛUÅmJĞf\\(‘P#ÀÖ–Lìˆ\$cÃw‰j„âg<~bPi>Ô³\$s €<<—fgó¯%~ËpîZš·ÑfŠ¯@kKÊ­,%Qù0d,M‰¡«T¥\0(^jÀvhŠÏ*È˜VJ»WYî¨\"hB&†k½•û)§vîìÛÔÏø.í]‡¶YC-…gÔÑU\\ÉCù\$˜4Î]dÉYuÓ%æWÍ+w&®¸>ú[„›”M7vù-sRÊ)¤ÓKå\$0™©4ùâZ”É‡Ë´\"«ÃSò¤8ê!P\n@!ºÜ\0¤µtDÕWeÊÁ#)Kvîïe[úÛE¯îÂÒ<€Cš“1öj‚·ù­\n5ˆMW˜O.‚k9#õ¶ôæ±)YR.fk4ÒÅ+Df/šß3FlÓõ+*Ã…ªlRÙ6%âZ¤E23	ıËi› ­şl”Ğ‡rŠf¦¾Í™%ì-a£Áy³ªZ¦ÄMqQº¼j^™ˆseÕ‘Îšû-Ze¼ÚÅkê›‘ªx	5õ€s°×{ócæ¸©v`1…^´Ô¹±JÅWLÍÂx–¦2^Û%ÿAü‰Ì³RZ¥å]¢™•…_UÄª¦^V­ıMYºû¦í®_›¨îŠkëºY¼+”UUMj—m7)ZBªÕuZÕDÍm›6ñİ:ªÉj“xfÄ`š7¢d¡™§`\næ¼M,—H£²Yêÿ9¹J„Õì»[–È¯fm¼Ü¥ùór•™M}™’­©Xô´·³FÂ{ª‰WÊì	L&	·ŠÈf”;Î—Êï°©q1ÓL†ÍÜ8q!TÓU&O–‡ş›ó2ZoäÓÕd ¦ ª”\\5qb¼9©'»ıšš²efŠ²ªJVæªN'wØaÚñ)Ug³VÄÇM^šÀ¤ªr3¿Ù­f±«y›×.ä?tŞéŒ†İöMs¬·Jk³°Ùkö&½-µœ©5ø\$Ø\0\nÈfÁ­˜¿8m,æÉ±‹&Õ;¼~w¼·Îlú¼9²§Q'3Í%6mOŒå†³Ÿ¦Ğà›E:	Xz±Ìê—'3©A›]:![‚¿I¶3šİö\$XÖ²õİÔãÕ†³nWÿÍ»Tñ:A`Û÷aªŞçMM^V,¥îs<Ü‰Ô«Cfæ<K›Ó2Õ]tİ)†Ó¨&ê‰Œ› ¬Qedæwa3®¢UNº›Á:‚oì	¼“•ç »ì›ÒªRo4ÖÅÚsœ'.;ı^¥æs:ñùfÓ´fú’m›ï:Rvtâù¿s˜çc\0Yœ.–s:¡8{²üçPN™œÏ8.vÂÃYÁ³¨'­âVÏ0¦u&ÂË¯g<2›xìqÒù„ó®Ôz;Yšh6i²ÎÙßÓNfıNMšy1wÂº—b3\\“Î4RQ8Ùr4ã‰ßª¥*KGœà¥ñÙ<ä5°ëS”c;Yœ‘5br\\ÕÉÉË–g(OU)9Nxšª©ËÎÃ€*Íìœ³;-eïwjSÊç0NIœÅ4õÙ:ŸéÍSÎg9©œë<	T¤èIÏKç>O)S¦BlÒÎy³“Ñ›Nxœş°nt3\09é€\nçO<~v{6®y2ª©ÑÓÕ©M°=UTéi¶ª<'ÏY›|ÀVa<õYìÙØ¯ÿI=­X¢é…bò÷'©Îªá7-e„êé¾S­Ø\0N²\0=Şu¬İuT“WÃê¨ì–Èí!Qtİiï“veœ»Rù=šq,İéês°gÈ+\"‘<¶o<ùYØóygÌNÊšİ9ntüù©ïsÆ©NÏ–ª¹&t›²yà“Œ%¬CÊˆ)=MàòWdóº“ÎëŸ+;µ[iŞågy;ôèÀ&pÌè¤M,\nCşÜ¢G‘âÒâDÀÖÓ¬±U%?(‘:“Å©óÀ(\0_VüªH?x	3ö'G‡ÑœS<I’¦§}*GçìK¥TÂ³6YÜâà	ª˜gñKFJ:z°C§Ê¤€+O–~´OÊå9rê´\0&ƒ&y\ršZúÍ/*Õfé©K1<Œ´ß0õ+­—W,Ë–`H¥- ´ÊYéj_gıªH—,«*à÷dríé-»—€¦B[şÓ©óMÈò€_#p²ä<»EÉ“õÔ¥°\nT“@Š%Õg*’@)¯Î‡â¼.] ä‡jÄhP\$\$‚ìSìÔÚ%àÍŸYš8™—”h ’—i,Ê‚zÓ%'óı¡üÎI\0¾¤(rî‰gFíWå¯Í]aYiE\0Õ)qÖ£ÄQ º´¶wDD©|3I)æ[,¹ftÆPúSú(7;/Hğ§ÎuY¬”İ¢©9®lª¥:3‰Ô¯­T ê¤Ä*ãP‡_ëAºbı:“‰À!OÖ¡BQj„½©®ËZgõNc#¹BlÌñZS’V´Ğ>GØÊ¦†”'gPŸ¡IB¥qtCJS‰èW)ZÒq!TÕ²8³Yg5¬o²¨º^‰#uA*Œ¦eNk¡Un’—Éæ´-€,Ğ¬˜C.…E04(RÍ=¡¨íy í©qÔ4×æ† L§¹Oí\rÕçÓm(ĞáWÛ?YRB¯É}´8—\"ªkçC*‡`õÉÔhnPç]½C*lb°9kR€*á¡'Cõb”şŠô?¨Q\0X«’‡ú®gt%–vLX¤ìîìÁŠTDf,H–Èµ‘r´ö*´?h_Í!˜1Dvlú¡9Ğ‹(ƒéD¢)CözrÏ)ôtIæ®ïX¤¶>ĞÕ'’îÒ.S ŠJ6aš&k29Îu Ø¯İSìÂ5™b&,Ì#YPa*ùi4RrP˜YE5eÍöKJV<-QTûEMßHÚ«Zh†)|`\$!kH}J*ëd(0Ë;X,´¢ˆ,òE¦Q–“¬©˜}A>Åå¥¡ÿÔƒLCS5?‰:¥Ê/.åh›,^Tn¶i¬òZ/ä±y,,¢ë1Ew²®‡a!ù§€Q‚\0§Ef9ŠÓI4©Ç1]½êËªS›ŞÑ›ŸÏDqªÍëç¢¼:,õº\$ä‰VmËd¦&6p€şjf×öÏİ[Q@iKZeİúİÂÍ¼^BB±\n Ö’¬ø–wGß¼ä@úTfÖÃÍ‰<±`-E¥*\\X*\0\$¾Gv‡ı* ´tÒÑ]£¬Hp¥z0”h?®{Vvâu²—ÅÏq-fH€N]æ²rŒÈ´L*€”­#\\™BJİU&4	¢Oİ]–»„¸ƒ@“Jî0\rTu=bŠÊ£u™*ŸN¥¯ô×<”\"EFëV\\Ï›¢\n@¸E/WúR¡ \rh‘I\"º ¤qb?°T(¨YZB¾Õ‹2Î©€N¡Šº‚ˆò¡B;‹{”kLªW”JeÔ÷JFJáÔ¾)¹õHõJÒººG«ÀÖh‘ï™¬¨Qr%ZS/À+Ë1 ¤£©bÊ›\n64whÍÑİ¢\n½_İ%°ô='ÍÑ'vI½~r´‰šSi/.·¤Ä©ab¤±E€‡@ ·‡-©“Yï¶2”š?Qè°îÍRZïUåJ¤™R^:3`‘K®UŒÁöèÑTŞHÌ²ÆjQ?Á¬f\0ª£‘RXYŒjl'Yª~ ,©Y}õZ\nÒ(ïR˜¥8®Yİ)µÊTd©\0¤QøÁsº@ÅH\n˜–\"-DT—J±JúÔJU4|?Oæ\\]IyS ú”«©UªÆ¢e;¢„ÎÉ©\nh”œ-î[ú³Ê–(Õ!ÒÙ&„/'£6JV•jÒúVk4gØ®Hv©½Qé#I(Î™¥:±}à%u1Dy	Í n¥ğƒ¾™ Ô™æ~Òœ£7Jfˆ*òª€˜¥1>¤G\\\rˆ!ĞtœÀRô«KØQe/4›YXRo\0PÆp(*—Í)œ\"Ï#Â´¼ñ\$S§íiŒøâ†ÜÑ)raà\\¡†›/(OÍ\$jF3fæŒ€Ãˆ(t\0¬`ô‹àdÀU	>hàêeÀc°Hÿ\rpİ`gPÊìc–[=çLäf¢‰”š®\0002\0/\0…–5\0b‰!Ò`à&\0]*px)ògÀCZu‡d-Ñ<ğ\$¦ñÂk%A‚üzšÔdÀ´ÕÒ¾ÓY\0Ö›5êkØÁ\0006¦ÒÒšøc@°@\ré·Áx¦Ø”Å7Zn4Ø@Óz¦×MÊ5è\noÔÙi°STtF5\"›U8@Æ”ÕdÓ]¦áMü†]5ºpgó)ÈÓb§MÚœ\\±r`†éÊÓn§/Mîš¥7Jsôä)ªSy§GN*œ­7Útôå\$Ï\$§6ÊœŠjuôÖiÖÓsN&dZvtØ#PF½§vÒí;jqãéÔG§}N®œå<jxTÙ)ÊSÆ¦¹NŞ%<Ğ\$ \r)ß€_§M¢E;\nxÔç©èS˜§¬–=Úotñ©ÓSâ§!OU>jx´àiêÇG§O2œätzytî)øÓ’§³Mf:==J~ôØ#£ÓØ§ÕNR:==Êxt÷¤Sí¦ñPP@juÔşÃF~§eP0ı@ê~tôiÎFf§Oş ¨Z‚t÷ªSÏ¨Mî µ?ªƒì*Sş¨?NB µ@*~	)ğSÕ¨-O–¡=:Š‚ÔújÓ””oN\n „£z}ôı*Gq¨]Nê¡Ì•J‡òj!Ô*¨yMf0ıAz†´ç*\$Ô¦÷Q& õBº‰ôéêÉ-¨wPR„’Ú‰Ôä\$–ÔQ¨M‚ImB*‰uiÍT’[Q¢Å5™%´øj1Ôj¨QšBEZ}•*Ô#¨İPú£¥Eê5*!Tt¨MQJ£äkêQ‡ªAÔ0©\0ÒCõCJàäT8¨íQòKÕG(Ëµ\$ª=SŞ#RJ£ıEú‘è*ITl© \"¤5I ò0j+ÓŞ‘ƒQnDŒ’´Şä`Ôb©#¤ÍG°Æ’0j4T¦¨[PBF\rJ–U(ê8Ô¸¨çR>¥œkÚ”µ+\$¹ÓÕ-%'~¦5GÚ˜/*\"T¾©S:¤õJ*˜õ.ª[F¥©“&~¦½L:r`ª%T‹©¹R¢œ¥MÊ•u6À’Ó–©—Sr¥=ê›•-i½ÔÜ©¢\03İAªmõ<c3ÔóKçQRœuOJ–5=*4Tô©ßSÒ¥ÕOJ‘IĞÓT¿§‡SÆ£­Pzõ)èU¨õT\"¥uPDÅ‘¹ê{%ÿ[TV¨-HJŸ5Bê€ÕªSÂ§½MŠ£uEªHÕ#ªRN©5Q8ôÕF*•UªAT’§İRŸµHjÕ!ª;T’¡ 0\r1ÜcCF²9áSÆ2ÈàZ§QÜcÆ¿WSÆ5RÄÆruj¥”sU4\rÜ­Jª\0ä}USŒÿUZ3}UŠ¦µE£*ÕXª?SÆ<\rUhñ5Xª	Õ`ªSŞ:UV*¦5E£[Õbª·T2MV*«õ=ã?UVŒeUÚ«=QhÄµ]ªµÕ	UÚ«}Q8ÙÕ]ª¹ÕŒÍUZ:åXŠ¬µ=ãOÕˆª]SÆ1ÍXŠ¦uaªÀÕKŒoV\"¬-PXÃõU£6Uœ«TZ2…YÊ±õ=ãkÕœ«'Vj¬­TèÄug*ÌÕŒ›UZ0í[\n³õAcÕ°«GTZ1%[\n´õkªÔÕQeVÂ­mT²ÒUU£EÕÄ«gTN4=\\J¶õAc‘ÕÄ«wW\n­íUHæq*àUL	%EtÏr§*ìTõªR˜Ì	%\\´Å’š*îÕÏ«­Ö®íStÄ@I*ê»C\rR:¨R_ô0Õv’ù¡†«W‚¦E]úºÒêìTÍªWÖ¦}_ú¾UF«UëŒ9Wö¯lbš¤UjñÕ%¬W‚©E`úºÕJêıUî'Wb6maŠ¼Õ…ªèÕD¬1X&Nı_åõ}dõÕØa™Xš«Í^¸õ5‰ª¾ÕãŒYXš¯UbêÄXk\nÆ)ªÇXÖš]ˆÄÕªñUà…Xê°İcjÃµ\\kGO«±UÖ±ÄsJÈõ}êëGî¬Xö²mbÚ¼_ë\$Ôl\0FÔ|—©EuvãÕB¬°2²Ôk\nË••«/®’õ%’²åcÊuˆ*ÃÖ8«Yº²e^ê±µ›«(Vr¬¥WZ4İ]ˆÕ5«5Vx¬AVn±ÅYÚĞ5œcÌV)«Çî®ÅZZĞ5cV«WZ±qŠ»mkGÛ­'YŞ¯tcŠÒu‡jáÖ8«‹Zz´%4Š»ĞkQÖ˜”©Z2®iêÁ4Õ*©ÉŸ­	&~´2c93õCQFÛ­[2µ½]3õŸ@İÉŸ­WP.°•kÚ¡5ˆÒÿÖZ­[Wæ¶j*¿•d½V¦’õYKÕkªÀõ³*kVÌ¬WÅ1eÚ¾•±kÖØLYvµ‰ÑÈËµ­#.ÖÎŒgZ¶3]nŠ×¨ª „Ö–T b˜´<—jKl>+aŸ+<¢·ºÒõÙè]˜ª7\0—>íÙ<ö©ês£+»•Í=LRÁ5S³Ô×+Õ] ¨\rH2’È„ÕÃ¯‰£–¤Ñ[:³%csİŞ*O‡v¤¸iL<õ5V@×‘Ïw›‰C¾¹2ô5ŠSà'ÄÑév©¾|âiò±\0İª«‰^¥n{½—jÎfÇVüŸJ©‰Hd÷uBsëÙ;W®…8ºöYöt»'Ú×–y6xÂB¢DÊ¤'WNÕñ|ì¸Ù‹.¶«œP-—q@	Ûã¶Ùfsr¦¦ÍŸšû8ü*®¯µ¾Ã­–`1CÜ=o¥™5Ú×Yİ%\r5idEúßê¹&Ñ»8ŸB«š¸\$á5mÁ§²ªæ®ª:ké+iÆ‹I&åW\r®,JÚ¸Åq%<µãkŠ×¯\"ï!åq¹¹UÇf¾× ¡Á^\n¹rY¹UèV^‘÷#ó6â»Uz9îSª+Õ)…®W7*eDË)×fíÍ2vï\\Òf:‘Êæó)«ÁO”›âî¦n3¯ \nêkŞÎŞ\$ß;‚p¢i¯®Õ”İ×Ë®‘8¼+»—€‹*ëÓÎ\n¥Ø«š}´¾9¥QÒ×S›»zh\"§ÙÈUØ§’ÎB¢o;r’ÙiÌóÊÔpPÅw±]ÊvjÃU¯áök»LïÒ¥Š·ôû¹Îõß§;;ì¯eLÕpzşàU«Ã×°´&¼]ed5ã«ËW¯0¤¾À=€Êâö€×U¿F•ß@}W‰Ó™ëÏ\$;œÏ^’uZÀ:õt•ªj¯ˆ¬†½Œİ‡…“¯&ŠØ(™\\Ô?ı{ºı\rkNĞ_pîùS¹UX×ÍË_>À=€'€ikêP‘wÙ;¡àEy:jÍañ¬®‰Y0AâE\næµ¾r°™‚«¶h«Á5š3hÓW¹wö\ri:ÑiÙ+ı·R@¤F£Vx|ÌW…1^Njx\\I‚f”ÂGpaƒ,‘Tü²N|z¸§cs0çELğxm5*—5ªÈÎ¬@Dg(Š‰‘›ÛQ“´Âæ¼çÎÁèÛ\0\"HÏX”:¿ÉŒì¢£ï4š\"1u(.÷ë`Óå±‘y,0é†øRÃ`µ°5€AÜ-	š~v	ö+†X²qM¨¢sË¨;¬[0‚BfÀ®((&h€q¬_³FÚƒ¹8ÛéÌé~6ObüÙ8'Û	†„íXÈdfu`ğ£¦42\nØ¿|.KuíPæH3:^/¦G|<ÛYë(´Å<\n€bƒ>’	Z;'z¬c\r‹3b2\r«NªĞLÍÁ2¢xU:\r6XÀÀ-€b\0ÆtßëT»%P˜ÊØêşÆXòSX!k®ÌÄ‡Qu‘a°?Ğv”g².ÜÌàSçS:l‘¤œídŠtÏÈHà\0=/¬`_3¥¹m‹FˆÃ‘%çlÑbÑƒB0 Ú¦ƒkâÕ5¶Åˆ°(¶PO?ú?ÎŠñ<ÏÁ\nĞ‹Sµ=5jä\nÀä{*\0ĞÑ3b!eT•’F ‰‘3¼•™Ò<bÊƒ*¡	Ìæ‚5FÉc¦	ãNÁ	H™Ø=¢ga6Íe„\rñ  6¯œ;\0¿&ÄšüaŒ›Qe†4‰Ğ‚¡¤hÖYadLü	\nÛÕ¤l‹*íG_™±×…¼	y‚ƒHÛ1©e.X´jÒÌtYë2Mw4³6ÈJË]˜ÀMÈìÏ½È™\n,‰¤jxFíG@º*g\0_¥šÅô ÙXY°³	f\r¤m˜9y€Ã ¦¦´æÍûß‡Ä>ÀÂ‡«o¶Í(jG;8\"yAµ3×ƒfü9µ	LÓÁ¾ÙÅmgQé[{ëds(YÅ~ŒŸ~@â@:	®àÿY¿³¾šíÈê6Fa\$lñ§)Obå³=Û<Vx˜Yuvx»ÁÄ5ÌYæ€š¸›¥•€ã±Yjuh¸¦\r‚/Ú™–c^ĞxÊ \röƒ…A,m®*ÎĞyw¡\0ÇÙ«ÚÙhuï´Ç7UÌ«HA{èÈê«#S­Ï{>Lµh´]¡ĞĞ‚µ&~f®ÃÑ¸xèïm„]¶.ÒÑèBôö&eÙm™—e¼lH‹¦+6ZÄ¿ç(ç\0Ç…¤Ù,:YPZak‰…¬QÛ.ªË‰…~œ°	[ëÑ-a_±:üÉœbPcA–˜í/\rhàÆÓe¦–¬h š'…´uiÆÓ¬\0„=Ïm\0´Éi¸›ä\0JPh-6Ó`rfiÚ=‡–mC‚R\"È'^Ãµ§Tqï’lS¾´ÈÉUİçÂ—^³ÅQ3ñ’ÃTš.AÇ=&gvÀlMª3@«-Tš+P‚¥ª ÆQA.!\0ÇjÉD[\"»Wƒ,Z'¦QRİ«€U&v­YXæµ[i0\"Õ—{Y ¬lØé{Š\"éé{P”\"aâW¶ZÑdÅ\0BÆPV.²åmm=0²kv\r5­5ïZØÚàµ¾h2Û4÷¤ÒñlOZÜµĞOÉ–í¦‹Ç.,§Úï:´ËF×Z('¦ì`-NÚûB Ú…‡Õ­6¶¹,ØÂ§aÆåš×ĞaÃl­…Å<6èÜ½\0000¶®­‰‡@±lM¯­ˆË4ÖÄÌŞZcğRÏÕ•« aloÚ|&Š´GæIb3µ´\n¦Ö\r0( Ó5[/¶fHè\rÅ®Z`öÍÌL–^¶d\$ÆLÎU(5-Ÿ[;ŠÎ(ºÅ8*˜ºvÍƒƒò¶~|Úa6¡¹öÓ4dÁlıõÁÄ\nÖÏÎ/ÛL€êyÚ*>Ç2Èû?Ÿ«¹¹›Ød!|’'O†(kîå¶P6!i¡t­x\"°“I©¡\0A¶ö ú“, «ôÀÛ7¦bá•Èz°ìŠÎÛJ2E´Cà\nB5Á@!ûŒFü¹h´àæ+-Ë:¢\0NMCësˆ–HßÛ=nAğà;s¤oÀ*Ú÷·:q›«Bæ§×\0ŒÛ¨NÅn¬İnõVÜ„º×4}Áóük6ìŞZÊ—¨_àtv­ÀÂÄî3>wı9\nƒÑL(ÏYy-B{èÓûš¨Gà\$6yeÌ‹tÇd]ç2À");}else{header("Content-Type: image/gif");switch($_GET["file"]){case"plus.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0!„©ËíMñÌ*)¾oú¯) q•¡eˆµî#ÄòLË\0;";break;case"cross.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0#„©Ëí#\naÖFo~yÃ._wa”á1ç±JîGÂL×6]\0\0;";break;case"up.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMQN\nï}ôa8ŠyšaÅ¶®\0Çò\0;";break;case"down.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMñÌ*)¾[Wş\\¢ÇL&ÙœÆ¶•\0Çò\0;";break;case"arrow.gif":echo"GIF89a\0\n\0€\0\0€€€ÿÿÿ!ù\0\0\0,\0\0\0\0\0\n\0\0‚i–±‹”ªÓ²Ş»\0\0;";break;}}exit;}if($_GET["script"]=="version"){$p=get_temp_dir()."/adminer.version";unlink($p);$r=file_open_lock($p);if($r)file_write_unlock($r,serialize(array("signature"=>$_POST["signature"],"version"=>$_POST["version"])));exit;}global$b,$f,$l,$Zb,$m,$ba,$ca,$je,$Zf,$wd,$T,$oi,$ia;if(!$_SERVER["REQUEST_URI"])$_SERVER["REQUEST_URI"]=$_SERVER["ORIG_PATH_INFO"];if(!strpos($_SERVER["REQUEST_URI"],'?')&&$_SERVER["QUERY_STRING"]!="")$_SERVER["REQUEST_URI"].="?$_SERVER[QUERY_STRING]";if($_SERVER["HTTP_X_FORWARDED_PREFIX"])$_SERVER["REQUEST_URI"]=$_SERVER["HTTP_X_FORWARDED_PREFIX"].$_SERVER["REQUEST_URI"];$ba=($_SERVER["HTTPS"]&&strcasecmp($_SERVER["HTTPS"],"off"))||ini_bool("session.cookie_secure");@ini_set("session.use_trans_sid",false);if(!defined("SID")){session_cache_limiter("");session_name("adminer_sid");session_set_cookie_params(0,preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]),"",$ba,true);session_start();}remove_slashes(array(&$_GET,&$_POST,&$_COOKIE),$Sc);if(function_exists("get_magic_quotes_runtime")&&get_magic_quotes_runtime())set_magic_quotes_runtime(false);@set_time_limit(0);@ini_set("precision",15);function
get_lang(){return'en';}function
lang($ni,$df=null){if(is_array($ni)){$cg=($df==1?0:1);$ni=$ni[$cg];}$ni=str_replace("%d","%s",$ni);$df=format_number($df);return
sprintf($ni,$df);}if(extension_loaded('pdo')){abstract
class
PdoDb{var$server_info,$affected_rows,$errno,$error;protected$pdo;private$result;function
dsn($fc,$V,$E,$vf=array()){$vf[\PDO::ATTR_ERRMODE]=\PDO::ERRMODE_SILENT;$vf[\PDO::ATTR_STATEMENT_CLASS]=array('Adminer\PdoDbStatement');try{$this->pdo=new
\PDO($fc,$V,$E,$vf);}catch(Exception$Ac){auth_error(h($Ac->getMessage()));}$this->server_info=@$this->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION);}abstract
function
select_db($Ib);function
quote($P){return$this->pdo->quote($P);}function
query($G,$yi=false){$H=$this->pdo->query($G);$this->error="";if(!$H){list(,$this->errno,$this->error)=$this->pdo->errorInfo();if(!$this->error)$this->error='Unknown error.';return
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
connect($Ab){list(,,$E)=$Ab;if($E!="")return'Database does not support password.';return
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
check_sqlite_name($B){global$f;$Ic="db|sdb|sqlite";if(!preg_match("~^[^\\0]*\\.($Ic)\$~",$B)){$f->error=sprintf('Please use one of the extensions %s.',str_replace("|",", ",$Ic));return
false;}return
true;}function
create_database($j,$fb){global$f;if(file_exists($j)){$f->error='File exists.';return
false;}if(!check_sqlite_name($j))return
false;try{$_=new
SqliteDb($j);}catch(Exception$Ac){$f->error=$Ac->getMessage();return
false;}$_->query('PRAGMA encoding = "UTF-8"');$_->query('CREATE TABLE adminer (i)');$_->query('DROP TABLE adminer');return
true;}function
drop_databases($i){global$f;$f->__construct(":memory:");foreach($i
as$j){if(!@unlink($j)){$f->error='File exists.';return
false;}}return
true;}function
rename_database($B,$fb){global$f;if(!check_sqlite_name($B))return
false;$f->__construct(":memory:");$f->error='File exists.';return@rename(DB,$B);}function
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
__construct($f){parent::__construct($f);$this->types=array('Numbers'=>array("smallint"=>5,"integer"=>10,"bigint"=>19,"boolean"=>1,"numeric"=>0,"real"=>7,"double precision"=>16,"money"=>20),'Date and time'=>array("date"=>13,"time"=>17,"timestamp"=>20,"timestamptz"=>21,"interval"=>0),'Strings'=>array("character"=>0,"character varying"=>0,"text"=>0,"tsquery"=>0,"tsvector"=>0,"uuid"=>0,"xml"=>0),'Binary'=>array("bit"=>0,"bit varying"=>0,"bytea"=>0),'Network'=>array("cidr"=>43,"inet"=>43,"macaddr"=>17,"macaddr8"=>23,"txid_snapshot"=>0),'Geometry'=>array("box"=>0,"circle"=>0,"line"=>0,"lseg"=>0,"path"=>0,"point"=>0,"polygon"=>0),);if(min_version(9.2,0,$f)){$this->types['Strings']["json"]=4294967295;if(min_version(9.4,0,$f))$this->types['Strings']["jsonb"]=4294967295;}$this->editFunctions=array(array("char"=>"md5","date|time"=>"now",),array(number_type()=>"+/-","date|time"=>"+ interval/- interval","char|text"=>"||",));if(min_version(12,0,$f))$this->generated=array("STORED");}function
enumLength($n){$sc=$this->types['User types'][$n["type"]];return($sc?type_values($sc):"");}function
setUserTypes($xi){$this->types['User types']=array_flip($xi);}function
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
__construct($f){parent::__construct($f);$this->types=array('Numbers'=>array("number"=>38,"binary_float"=>12,"binary_double"=>21),'Date and time'=>array("date"=>10,"timestamp"=>29,"interval year"=>12,"interval day"=>28),'Strings'=>array("char"=>2000,"varchar2"=>4000,"nchar"=>2000,"nvarchar2"=>4000,"clob"=>4294967295,"nclob"=>4294967295),'Binary'=>array("raw"=>2000,"long raw"=>2147483648,"blob"=>4294967295,"bfile"=>4294967296),);}function
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
__construct($f){parent::__construct($f);$this->types=array('Numbers'=>array("tinyint"=>3,"smallint"=>5,"int"=>10,"bigint"=>20,"bit"=>1,"decimal"=>0,"real"=>12,"float"=>53,"smallmoney"=>10,"money"=>20),'Date and time'=>array("date"=>10,"smalldatetime"=>19,"datetime"=>19,"datetime2"=>19,"time"=>8,"datetimeoffset"=>10),'Strings'=>array("char"=>8000,"varchar"=>8000,"text"=>2147483647,"nchar"=>4000,"nvarchar"=>4000,"ntext"=>1073741823),'Binary'=>array("binary"=>8000,"varbinary"=>8000,"image"=>2147483647),);}function
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
loginForm(){global$Zb;echo"<table class='layout'>\n",$this->loginFormField('driver','<tr><th>'.'System'.'<td>',html_select("auth[driver]",$Zb,DRIVER,"loginDriver(this);")),$this->loginFormField('server','<tr><th>'.'Server'.'<td>','<input name="auth[server]" value="'.h(SERVER).'" title="hostname[:port]" placeholder="localhost" autocapitalize="off">'),$this->loginFormField('username','<tr><th>'.'Username'.'<td>','<input name="auth[username]" id="username" autofocus value="'.h($_GET["username"]).'" autocomplete="username" autocapitalize="off">'.script("qs('#username').form['auth[driver]'].onchange();")),$this->loginFormField('password','<tr><th>'.'Password'.'<td>','<input type="password" name="auth[password]" autocomplete="current-password">'),$this->loginFormField('db','<tr><th>'.'Database'.'<td>','<input name="auth[db]" value="'.h($_GET["db"]).'" autocapitalize="off">'),"</table>\n","<p><input type='submit' value='".'Login'."'>\n",checkbox("auth[permanent]",1,$_COOKIE["adminer_permanent"],'Permanent login')."\n";}function
loginFormField($B,$yd,$Y){return$yd.$Y."\n";}function
login($ve,$E){if($E=="")return
sprintf('Adminer does not support accessing a database without a password, <a href="https://www.adminer.org/en/password/"%s>more information</a>.',target_blank());return
true;}function
tableName($Jh){return
h($Jh["Name"]);}function
fieldName($n,$xf=0){return'<span title="'.h($n["full_type"].($n["comment"]!=""?" : $n[comment]":'')).'">'.h($n["field"]).'</span>';}function
selectLinks($Jh,$N=""){global$l;echo'<p class="links">';$te=array("select"=>'Select data');if(support("table")||support("indexes"))$te["table"]='Show structure';$Zd=false;if(support("table")){$Zd=is_view($Jh);if($Zd)$te["view"]='Alter view';else$te["create"]='Alter table';}if($N!==null)$te["edit"]='New item';$B=$Jh["Name"];foreach($te
as$y=>$X)echo" <a href='".h(ME)."$y=".urlencode($B).($y=="edit"?$N:"")."'".bold(isset($_GET[$y])).">$X</a>";echo
doc_link(array(JUSH=>$l->tableHelp($B,$Zd)),"?"),"\n";}function
foreignKeys($Q){return
foreign_keys($Q);}function
backwardKeys($Q,$Ih){return
array();}function
backwardKeysPrint($Da,$J){}function
selectQuery($G,$_h,$Lc=false){global$l;$I="</p>\n";if(!$Lc&&($Yi=$l->warnings())){$u="warnings";$I=", <a href='#$u'>".'Warnings'."</a>".script("qsl('a').onclick = partial(toggle, '$u');","")."$I<div id='$u' class='hidden'>\n$Yi</div>\n";}return"<p><code class='jush-".JUSH."'>".h(str_replace("\n"," ",$G))."</code> <span class='time'>(".format_time($_h).")</span>".(support("sql")?" <a href='".h(ME)."sql=".urlencode($G)."'>".'Edit'."</a>":"").$I;}function
sqlCommandQuery($G){return
shorten_utf8(trim($G),1000);}function
rowDescription($Q){return"";}function
rowDescriptions($K,$bd){return$K;}function
selectLink($X,$n){}function
selectVal($X,$_,$n,$Gf){$I=($X===null?"<i>NULL</i>":(preg_match("~char|binary|boolean~",$n["type"])&&!preg_match("~var~",$n["type"])?"<code>$X</code>":(preg_match('~json~',$n["type"])?"<code class='jush-js'>$X</code>":$X)));if(preg_match('~blob|bytea|raw|file~',$n["type"])&&!is_utf8($X))$I="<i>".lang(array('%d byte','%d bytes'),strlen($Gf))."</i>";return($_?"<a href='".h($_)."'".(is_url($_)?target_blank():"").">$I</a>":$I);}function
editVal($X,$n){return$X;}function
tableStructurePrint($o){global$l;echo"<div class='scrollable'>\n","<table class='nowrap odds'>\n","<thead><tr><th>".'Column'."<td>".'Type'.(support("comment")?"<td>".'Comment':"")."</thead>\n";$Ch=$l->structuredTypes();foreach($o
as$n){echo"<tr><th>".h($n["field"]);$U=h($n["full_type"]);echo"<td><span title='".h($n["collation"])."'>".(in_array($U,(array)$Ch['User types'])?"<a href='".h(ME.'type='.urlencode($U))."'>$U</a>":$U)."</span>",($n["null"]?" <i>NULL</i>":""),($n["auto_increment"]?" <i>".'Auto Increment'."</i>":"");$k=h($n["default"]);echo(isset($n["default"])?" <span title='".'Default value'."'>[<b>".($n["generated"]?"<code class='jush-".JUSH."'>$k</code>":$k)."</b>]</span>":""),(support("comment")?"<td>".h($n["comment"]):""),"\n";}echo"</table>\n","</div>\n";}function
tableIndexesPrint($x){echo"<table>\n";foreach($x
as$B=>$w){ksort($w["columns"]);$kg=array();foreach($w["columns"]as$y=>$X)$kg[]="<i>".h($X)."</i>".($w["lengths"][$y]?"(".$w["lengths"][$y].")":"").($w["descs"][$y]?" DESC":"");echo"<tr title='".h($B)."'><th>$w[type]<td>".implode(", ",$kg)."\n";}echo"</table>\n";}function
selectColumnsPrint($L,$e){global$l;print_fieldset("select",'Select',$L);$t=0;$L[""]=array();foreach($L
as$y=>$X){$X=$_GET["columns"][$y];$d=select_input(" name='columns[$t][col]'",$e,$X["col"],($y!==""?"selectFieldChange":"selectAddRow"));echo"<div>".($l->functions||$l->grouping?html_select("columns[$t][fun]",array(-1=>"")+array_filter(array('Functions'=>$l->functions,'Aggregation'=>$l->grouping)),$X["fun"]).on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'",1).script("qsl('select').onchange = function () { helpClose();".($y!==""?"":" qsl('select, input', this.parentNode).onchange();")." };","")."($d)":$d)."</div>\n";$t++;}echo"</div></fieldset>\n";}function
selectSearchPrint($Z,$e,$x){print_fieldset("search",'Search',$Z);foreach($x
as$t=>$w){if($w["type"]=="FULLTEXT")echo"<div>(<i>".implode("</i>, <i>",array_map('Adminer\h',$w["columns"]))."</i>) AGAINST"," <input type='search' name='fulltext[$t]' value='".h($_GET["fulltext"][$t])."'>",script("qsl('input').oninput = selectFieldChange;",""),checkbox("boolean[$t]",1,isset($_GET["boolean"][$t]),"BOOL"),"</div>\n";}$Ra="this.parentNode.firstChild.onchange();";foreach(array_merge((array)$_GET["where"],array(array()))as$t=>$X){if(!$X||("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators)))echo"<div>".select_input(" name='where[$t][col]'",$e,$X["col"],($X?"selectFieldChange":"selectAddRow"),"(".'anywhere'.")"),html_select("where[$t][op]",$this->operators,$X["op"],$Ra),"<input type='search' name='where[$t][val]' value='".h($X["val"])."'>",script("mixin(qsl('input'), {oninput: function () { $Ra }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});",""),"</div>\n";}echo"</div></fieldset>\n";}function
selectOrderPrint($xf,$e,$x){print_fieldset("sort",'Sort',$xf);$t=0;foreach((array)$_GET["order"]as$y=>$X){if($X!=""){echo"<div>".select_input(" name='order[$t]'",$e,$X,"selectFieldChange"),checkbox("desc[$t]",1,isset($_GET["desc"][$y]),'descending')."</div>\n";$t++;}}echo"<div>".select_input(" name='order[$t]'",$e,"","selectAddRow"),checkbox("desc[$t]",1,false,'descending')."</div>\n","</div></fieldset>\n";}function
selectLimitPrint($z){echo"<fieldset><legend>".'Limit'."</legend><div>","<input type='number' name='limit' class='size' value='".h($z)."'>",script("qsl('input').oninput = selectFieldChange;",""),"</div></fieldset>\n";}function
selectLengthPrint($Zh){if($Zh!==null)echo"<fieldset><legend>".'Text length'."</legend><div>","<input type='number' name='text_length' class='size' value='".h($Zh)."'>","</div></fieldset>\n";}function
selectActionPrint($x){echo"<fieldset><legend>".'Action'."</legend><div>","<input type='submit' value='".'Select'."'>"," <span id='noindex' title='".'Full table scan'."'></span>","<script".nonce().">\n","var indexColumns = ";$e=array();foreach($x
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
messageQuery($G,$ai,$Lc=false){global$l;restart_session();$zd=&get_session("queries");if(!$zd[$_GET["db"]])$zd[$_GET["db"]]=array();if(strlen($G)>1e6)$G=preg_replace('~[\x80-\xFF]+$~','',substr($G,0,1e6))."\nâ€¦";$zd[$_GET["db"]][]=array($G,time(),$ai);$wh="sql-".count($zd[$_GET["db"]]);$I="<a href='#$wh' class='toggle'>".'SQL command'."</a>\n";if(!$Lc&&($Yi=$l->warnings())){$u="warnings-".count($zd[$_GET["db"]]);$I="<a href='#$u' class='toggle'>".'Warnings'."</a>, $I<div id='$u' class='hidden'>\n$Yi</div>\n";}return" <span class='time'>".@date("H:i:s")."</span>"." $I<div id='$wh' class='hidden'><pre><code class='jush-".JUSH."'>".shorten_utf8($G,1000)."</code></pre>".($ai?" <span class='time'>($ai)</span>":'').(support("sql")?'<p><a href="'.h(str_replace("db=".urlencode(DB),"db=".urlencode($_GET["db"]),ME).'sql=&history='.(count($zd[$_GET["db"]])-1)).'">'.'Edit'.'</a>':'').'</div>';}function
editRowPrint($Q,$o,$J,$Fi){}function
editFunctions($n){global$l;$I=($n["null"]?"NULL/":"");$Fi=isset($_GET["select"])||where($_GET);foreach($l->editFunctions
as$y=>$id){if(!$y||(!isset($_GET["call"])&&$Fi)){foreach($id
as$Xf=>$X){if(!$Xf||preg_match("~$Xf~",$n["type"]))$I.="/$X";}}if($y&&!preg_match('~set|blob|bytea|raw|file|bool~',$n["type"]))$I.="/SQL";}if($n["auto_increment"]&&!$Fi)$I='Auto Increment';return
explode("/",$I);}function
editInput($Q,$n,$ya,$Y){if($n["type"]=="enum")return(isset($_GET["select"])?"<label><input type='radio'$ya value='-1' checked><i>".'original'."</i></label> ":"").($n["null"]?"<label><input type='radio'$ya value=''".($Y!==null||isset($_GET["select"])?"":" checked")."><i>NULL</i></label> ":"").enum_input("radio",$ya,$n,$Y,$Y===0?0:null);return"";}function
editHint($Q,$n,$Y){return"";}function
processInput($n,$Y,$s=""){if($s=="SQL")return$Y;$B=$n["field"];$I=q($Y);if(preg_match('~^(now|getdate|uuid)$~',$s))$I="$s()";elseif(preg_match('~^current_(date|timestamp)$~',$s))$I=$s;elseif(preg_match('~^([+-]|\|\|)$~',$s))$I=idf_escape($B)." $s $I";elseif(preg_match('~^[+-] interval$~',$s))$I=idf_escape($B)." $s ".(preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i",$Y)?$Y:$I);elseif(preg_match('~^(addtime|subtime|concat)$~',$s))$I="$s(".idf_escape($B).", $I)";elseif(preg_match('~^(md5|sha1|password|encrypt)$~',$s))$I="$s($I)";return
unconvert_field($n,$I);}function
dumpOutput(){$I=array('text'=>'open','file'=>'save');if(function_exists('gzencode'))$I['gz']='gzip';return$I;}function
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
homepage(){echo'<p class="links">'.($_GET["ns"]==""&&support("database")?'<a href="'.h(ME).'database=">'.'Alter database'."</a>\n":""),(support("scheme")?"<a href='".h(ME)."scheme='>".($_GET["ns"]!=""?'Alter schema':'Create schema')."</a>\n":""),($_GET["ns"]!==""?'<a href="'.h(ME).'schema=">'.'Database schema'."</a>\n":""),(support("privileges")?"<a href='".h(ME)."privileges='>".'Privileges'."</a>\n":"");return
true;}function
navigation($Pe){global$ia,$Zb,$f;echo'<h1>
',$this->name(),'<span class="version">
',$ia,' <a href="https://www.adminer.org/#download"',target_blank(),' id="version">',(version_compare($ia,$_COOKIE["adminer_version"])<0?h($_COOKIE["adminer_version"]):""),'</a>
</span>
</h1>
';if($Pe=="auth"){$Jf="";foreach((array)$_SESSION["pwds"]as$Si=>$hh){foreach($hh
as$M=>$Ni){$B=h(get_setting("vendor-$M")?:$Zb[$Si]);foreach($Ni
as$V=>$E){if($E!==null){$Lb=$_SESSION["db"][$Si][$M][$V];foreach(($Lb?array_keys($Lb):array(""))as$j)$Jf.="<li><a href='".h(auth_url($Si,$M,$V,$j))."'>($B) ".h($V.($M!=""?"@".$this->serverName($M):"").($j!=""?" - $j":""))."</a>\n";}}}}if($Jf)echo"<ul id='logins'>\n$Jf</ul>\n".script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");}else{$S=array();if($_GET["ns"]!==""&&!$Pe&&DB!=""){$f->select_db(DB);$S=table_status('',true);}$this->syntaxHighlighting($S);$this->databasesPrint($Pe);$la=array();if(DB==""||!$Pe){if(support("sql")){$la[]="<a href='".h(ME)."sql='".bold(isset($_GET["sql"])&&!isset($_GET["import"])).">".'SQL command'."</a>";$la[]="<a href='".h(ME)."import='".bold(isset($_GET["import"])).">".'Import'."</a>";}$la[]="<a href='".h(ME)."dump=".urlencode(isset($_GET["table"])?$_GET["table"]:$_GET["select"])."' id='dump'".bold(isset($_GET["dump"])).">".'Export'."</a>";}$Id=$_GET["ns"]!==""&&!$Pe&&DB!="";if($Id)$la[]='<a href="'.h(ME).'create="'.bold($_GET["create"]==="").">".'Create table'."</a>";echo($la?"<p class='links'>\n".implode("\n",$la)."\n":"");if($Id){if($S)$this->tablesPrint($S);else
echo"<p class='message'>".'No tables.'."</p>\n";}}}function
syntaxHighlighting($S){global$f;echo
script_src(preg_replace("~\\?.*~","",ME)."?file=jush.js&version=5.0.6");if(support("sql")){echo"<script".nonce().">\n";if($S){$te=array();foreach($S
as$Q=>$U)$te[]=preg_quote($Q,'/');echo"var jushLinks = { ".JUSH.": [ '".js_escape(ME).(support("table")?"table=":"select=")."\$&', /\\b(".implode("|",$te).")\\b/g ] };\n";foreach(array("bac","bra","sqlite_quo","mssql_bra")as$X)echo"jushLinks.$X = jushLinks.".JUSH.";\n";}echo"</script>\n";}echo
script("bodyLoad('".(is_object($f)?preg_replace('~^(\d\.?\d).*~s','\1',$f->server_info):"")."'".($f->maria?", true":"").");");}function
databasesPrint($Pe){global$b,$f;$i=$this->databases();if(DB&&$i&&!in_array(DB,$i))array_unshift($i,DB);echo'<form action="">
<p id="dbs">
';hidden_fields_get();$Jb=script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");echo"<span title='".'Database'."'>".'DB'.":</span> ".($i?html_select("db",array(""=>"")+$i,DB).$Jb:"<input name='db' value='".h(DB)."' autocapitalize='off' size='19'>\n"),"<input type='submit' value='".'Use'."'".($i?" class='hidden'":"").">\n";if(support("scheme")){if($Pe!="db"&&DB!=""&&$f->select_db(DB)){echo"<br><span>".'Schema'.":</span> ".html_select("ns",array(""=>"")+$b->schemas(),$_GET["ns"]).$Jb;if($_GET["ns"]!="")set_schema($_GET["ns"]);}}foreach(array("import","sql","schema","dump","privileges")as$X){if(isset($_GET[$X])){echo"<input type='hidden' name='$X' value=''>";break;}}echo"</p></form>\n";}function
tablesPrint($S){echo"<ul id='tables'>".script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");foreach($S
as$Q=>$O){$B=$this->tableName($O);if($B!="")echo'<li><a href="'.h(ME).'select='.urlencode($Q).'"'.bold($_GET["select"]==$Q||$_GET["edit"]==$Q,"select")." title='".'Select data'."'>".'select'."</a> ",(support("table")||support("indexes")?'<a href="'.h(ME).'table='.urlencode($Q).'"'.bold(in_array($Q,array($_GET["table"],$_GET["create"],$_GET["indexes"],$_GET["foreign"],$_GET["trigger"])),(is_view($O)?"view":"structure"))." title='".'Show structure'."'>$B</a>":"<span>$B</span>")."\n";}echo"</ul>\n";}}$b=(function_exists('adminer_object')?adminer_object():new
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
connect($M,$V,$E){if(ini_bool("mysql.allow_local_infile")){$this->error=sprintf('Disable %s or enable %s or %s extensions.',"'mysql.allow_local_infile'","MySQLi","PDO_MySQL");return
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
__construct($f){parent::__construct($f);$this->types=array('Numbers'=>array("tinyint"=>3,"smallint"=>5,"mediumint"=>8,"int"=>10,"bigint"=>20,"decimal"=>66,"float"=>12,"double"=>21),'Date and time'=>array("date"=>10,"datetime"=>19,"timestamp"=>19,"time"=>10,"year"=>4),'Strings'=>array("char"=>255,"varchar"=>65535,"tinytext"=>255,"text"=>65535,"mediumtext"=>16777215,"longtext"=>4294967295),'Lists'=>array("enum"=>65535,"set"=>64),'Binary'=>array("bit"=>20,"binary"=>255,"varbinary"=>65535,"tinyblob"=>255,"blob"=>65535,"mediumblob"=>16777215,"longblob"=>4294967295),'Geometry'=>array("geometry"=>0,"point"=>0,"linestring"=>0,"polygon"=>0,"multipoint"=>0,"multilinestring"=>0,"multipolygon"=>0,"geometrycollection"=>0),);$this->editFunctions=array(array("char"=>"md5/sha1/password/encrypt/uuid","binary"=>"md5/sha1","date|time"=>"now",),array(number_type()=>"+/-","date"=>"+ interval/- interval","time"=>"addtime/subtime","char|text"=>"concat",));if(min_version('5.7.8',10.2,$f))$this->types['Strings']["json"]=4294967295;if(min_version('',10.7,$f)){$this->types['Strings']["uuid"]=128;$this->editFunctions[0]['uuid']='uuid';}if(min_version(9,'',$f)){$this->types['Numbers']["vector"]=16383;$this->editFunctions[0]['vector']='string_to_vector';}if(min_version(5.7,10.2,$f))$this->generated=array("STORED","VIRTUAL");}function
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
<html lang="en" dir="ltr">
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
var offlineMessage = '".js_escape('You are offline.')."';
var thousandsSeparator = '".js_escape(',')."';"),"<div id='help' class='jush-".JUSH." jsonly hidden'></div>\n",script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"),"<div id='content'>\n";if($La!==null){$_=substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1);echo'<p id="breadcrumb"><a href="'.h($_?:".").'">'.$Zb[DRIVER].'</a> Â» ';$_=substr(preg_replace('~\b(db|ns)=[^&]*&~','',ME),0,-1);$M=$b->serverName(SERVER);$M=($M!=""?$M:'Server');if($La===false)echo"$M\n";else{echo"<a href='".h($_)."' accesskey='1' title='Alt+Shift+1'>$M</a> Â» ";if($_GET["ns"]!=""||(DB!=""&&is_array($La)))echo'<a href="'.h($_."&db=".urlencode(DB).(support("scheme")?"&ns=":"")).'">'.h(DB).'</a> Â» ';if(is_array($La)){if($_GET["ns"]!="")echo'<a href="'.h(substr(ME,0,-1)).'">'.h($_GET["ns"]).'</a> Â» ';foreach($La
as$y=>$X){$Rb=(is_array($X)?$X[1]:h($X));if($Rb!="")echo"<a href='".h(ME."$y=").urlencode(is_array($X)?$X[0]:$X)."'>$Rb</a> Â» ";}}echo"$di\n";}}echo"<h2>$fi</h2>\n","<div id='ajaxstatus' class='jsonly hidden'></div>\n";restart_session();page_messages($m);$i=&get_session("dbs");if(DB!=""&&$i&&!in_array(DB,$i,true))$i=null;stop_session();define('Adminer\PAGE_HEADER',1);}function
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
<input type="submit" name="logout" value="Logout" id="logout">
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
check_invalid_login(){global$b;$Ud=array();foreach(glob(get_temp_dir()."/adminer.invalid*")as$p){$r=file_open_lock($p);if($r){$Ud=unserialize(stream_get_contents($r));file_unlock($r);break;}}$Td=($Ud?$Ud[$b->bruteForceKey()]:array());$Ze=($Td[1]>29?$Td[0]-time():0);if($Ze>0)auth_error(lang(array('Too many unsuccessful logins, try again in %d minute.','Too many unsuccessful logins, try again in %d minutes.'),ceil($Ze/60)));}$za=$_POST["auth"];if($za){session_regenerate_id();$Si=$za["driver"];$M=$za["server"];$V=$za["username"];$E=(string)$za["password"];$j=$za["db"];set_password($Si,$M,$V,$E);$_SESSION["db"][$Si][$M][$V][$j]=true;if($za["permanent"]){$y=implode("-",array_map('base64_encode',array($Si,$M,$V,$j)));$lg=$b->permanentLogin(true);$Zf[$y]="$y:".base64_encode($lg?encrypt_string($E,$lg):"");cookie("adminer_permanent",implode(" ",$Zf));}if(count($_POST)==1||DRIVER!=$Si||SERVER!=$M||$_GET["username"]!==$V||DB!=$j)redirect(auth_url($Si,$M,$V,$j));}elseif($_POST["logout"]&&(!$wd||verify_token())){foreach(array("pwds","db","dbs","queries")as$y)set_session($y,null);unset_permanent();redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1),'Logout successful.'.' '.'Thanks for using Adminer, consider <a href="https://www.adminer.org/en/donation/">donating</a>.');}elseif($Zf&&!$_SESSION["pwds"]){session_regenerate_id();$lg=$b->permanentLogin();foreach($Zf
as$y=>$X){list(,$Za)=explode(":",$X);list($Si,$M,$V,$j)=array_map('base64_decode',explode("-",$y));set_password($Si,$M,$V,decrypt_string(base64_decode($Za),$lg));$_SESSION["db"][$Si][$M][$V][$j]=true;}}function
unset_permanent(){global$Zf;foreach($Zf
as$y=>$X){list($Si,$M,$V,$j)=array_map('base64_decode',explode("-",$y));if($Si==DRIVER&&$M==SERVER&&$V==$_GET["username"]&&$j==DB)unset($Zf[$y]);}cookie("adminer_permanent",implode(" ",$Zf));}function
auth_error($m){global$b,$wd;$ih=session_name();if(isset($_GET["username"])){header("HTTP/1.1 403 Forbidden");if(($_COOKIE[$ih]||$_GET[$ih])&&!$wd)$m='Session expired, please login again.';else{restart_session();add_invalid_login();$E=get_password();if($E!==null){if($E===false)$m.=($m?'<br>':'').sprintf('Master password expired. <a href="https://www.adminer.org/en/extension/"%s>Implement</a> %s method to make it permanent.',target_blank(),'<code>permanentLogin()</code>');set_password(DRIVER,SERVER,$_GET["username"],null);}unset_permanent();}}if(!$_COOKIE[$ih]&&$_GET[$ih]&&ini_bool("session.use_only_cookies"))$m='Session support must be enabled.';$Of=session_get_cookie_params();cookie("adminer_key",($_COOKIE["adminer_key"]?:rand_string()),$Of["lifetime"]);page_header('Login',$m,null);echo"<form action='' method='post'>\n","<div>";if(hidden_fields($_POST,array("auth")))echo"<p class='message'>".'The action will be performed after successful login with the same credentials.'."\n";echo"</div>\n";$b->loginForm();echo"</form>\n";page_footer("auth");exit;}if(isset($_GET["username"])&&!class_exists('Adminer\Db')){unset($_SESSION["pwds"][DRIVER]);unset_permanent();page_header('No extension',sprintf('None of the supported PHP extensions (%s) are available.',implode(", ",Driver::$fg)),false);page_footer("auth");exit;}stop_session(true);if(isset($_GET["username"])&&is_string(get_password())){list($Ad,$bg)=explode(":",SERVER,2);if(preg_match('~^\s*([-+]?\d+)~',$bg,$A)&&($A[1]<1024||$A[1]>65535))auth_error('Connecting to privileged ports is not allowed.');check_invalid_login();$f=connect($b->credentials());if(is_object($f)){$l=new
Driver($f);if($b->operators===null)$b->operators=$l->operators;if(isset($f->maria)||$f->cockroach)save_settings(array("vendor-".SERVER=>$Zb[DRIVER]));}}$ve=null;if(!is_object($f)||($ve=$b->login($_GET["username"],get_password()))!==true){$m=(is_string($f)?nl_br(h($f)):(is_string($ve)?$ve:'Invalid credentials.'));auth_error($m.(preg_match('~^ | $~',get_password())?'<br>'.'There is a space in the input password which might be the cause.':''));}if($_POST["logout"]&&$wd&&!verify_token()){page_header('Logout','Invalid CSRF token. Send the form again.');page_footer("db");exit;}if($za&&$_POST["token"])$_POST["token"]=$T;$m='';if($_POST){if(!verify_token()){$Od="max_input_vars";$Ge=ini_get($Od);if(extension_loaded("suhosin")){foreach(array("suhosin.request.max_vars","suhosin.post.max_vars")as$y){$X=ini_get($y);if($X&&(!$Ge||$X<$Ge)){$Od=$y;$Ge=$X;}}}$m=(!$_POST["token"]&&$Ge?sprintf('Maximum number of allowed fields exceeded. Please increase %s.',"'$Od'"):'Invalid CSRF token. Send the form again.'.' '.'If you did not send this request from Adminer then close this page.');}}elseif($_SERVER["REQUEST_METHOD"]=="POST"){$m=sprintf('Too big POST data. Reduce the data or increase the %s configuration directive.',"'post_max_size'");if(isset($_GET["sql"]))$m.=' '.'You can upload a big SQL file via FTP and import it from server.';}function
select($H,$g=null,$Af=array(),$z=0){$te=array();$x=array();$e=array();$Ja=array();$xi=array();$I=array();for($t=0;(!$z||$t<$z)&&($J=$H->fetch_row());$t++){if(!$t){echo"<div class='scrollable'>\n","<table class='nowrap odds'>\n","<thead><tr>";for($ae=0;$ae<count($J);$ae++){$n=$H->fetch_field();$B=$n->name;$_f=$n->orgtable;$zf=$n->orgname;$I[$n->table]=$_f;if($Af&&JUSH=="sql")$te[$ae]=($B=="table"?"table=":($B=="possible_keys"?"indexes=":null));elseif($_f!=""){if(!isset($x[$_f])){$x[$_f]=array();foreach(indexes($_f,$g)as$w){if($w["type"]=="PRIMARY"){$x[$_f]=array_flip($w["columns"]);break;}}$e[$_f]=$x[$_f];}if(isset($e[$_f][$zf])){unset($e[$_f][$zf]);$x[$_f][$zf]=$ae;$te[$ae]=$_f;}}if($n->charsetnr==63)$Ja[$ae]=true;$xi[$ae]=$n->type;echo"<th".($_f!=""||$n->name!=$zf?" title='".h(($_f!=""?"$_f.":"").$zf)."'":"").">".h($B).($Af?doc_link(array('sql'=>"explain-output.html#explain_".strtolower($B),'mariadb'=>"explain/#the-columns-in-explain-select",)):"");}echo"</thead>\n";}echo"<tr>";foreach($J
as$y=>$X){$_="";if(isset($te[$y])&&!$e[$te[$y]]){if($Af&&JUSH=="sql"){$Q=$J[array_search("table=",$te)];$_=ME.$te[$y].urlencode($Af[$Q]!=""?$Af[$Q]:$Q);}else{$_=ME."edit=".urlencode($te[$y]);foreach($x[$te[$y]]as$db=>$ae)$_.="&where".urlencode("[".bracket_escape($db)."]")."=".urlencode($J[$ae]);}}elseif(is_url($X))$_=$X;if($X===null)$X="<i>NULL</i>";elseif($Ja[$y]&&!is_utf8($X))$X="<i>".lang(array('%d byte','%d bytes'),strlen($X))."</i>";else{$X=h($X);if($xi[$y]==254)$X="<code>$X</code>";}if($_)$X="<a href='".h($_)."'".(is_url($_)?target_blank():'').">$X</a>";echo"<td".($xi[$y]<=9||$xi[$y]==246?" class='number'":"").">$X";}}echo($t?"</table>\n</div>":"<p class='message'>".'No rows.')."\n";return$I;}function
referencable_primary($ah){$I=array();foreach(table_status('',true)as$Lh=>$Q){if($Lh!=$ah&&fk_support($Q)){foreach(fields($Lh)as$n){if($n["primary"]){if($I[$Lh]){unset($I[$Lh]);break;}$I[$Lh]=$n;}}}}return$I;}function
textarea($B,$Y,$K=10,$hb=80){echo"<textarea name='".h($B)."' rows='$K' cols='$hb' class='sqlarea jush-".JUSH."' spellcheck='false' wrap='off'>";if(is_array($Y)){foreach($Y
as$X)echo
h($X[0])."\n\n\n";}else
echo
h($Y);echo"</textarea>";}function
select_input($ya,$vf,$Y="",$pf="",$ag=""){$Sh=($vf?"select":"input");return"<$Sh$ya".($vf?"><option value=''>$ag".optionlist($vf,$Y,true)."</select>":" size='10' value='".h($Y)."' placeholder='$ag'>").($pf?script("qsl('$Sh').onchange = $pf;",""):"");}function
json_row($y,$X=null){static$Tc=true;if($Tc)echo"{";if($y!=""){echo($Tc?"":",")."\n\t\"".addcslashes($y,"\r\n\t\"\\/").'": '.($X!==null?'"'.addcslashes($X,"\r\n\"\\/").'"':'null');$Tc=false;}else{echo"\n}\n";$Tc=true;}}function
edit_type($y,$n,$gb,$cd=array(),$Kc=array()){global$l;$U=$n["type"];echo"<td><select name='".h($y)."[type]' class='type' aria-labelledby='label-type'>";if($U&&!array_key_exists($U,$l->types())&&!isset($cd[$U])&&!in_array($U,$Kc))$Kc[]=$U;$Ch=$l->structuredTypes();if($cd)$Ch['Foreign keys']=$cd;echo
optionlist(array_merge($Kc,$Ch),$U),"</select><td>","<input name='".h($y)."[length]' value='".h($n["length"])."' size='3'".(!$n["length"]&&preg_match('~var(char|binary)$~',$U)?" class='required'":"")." aria-labelledby='label-length'>","<td class='options'>",($gb?"<input list='collations' name='".h($y)."[collation]'".(preg_match('~(char|text|enum|set)$~',$U)?"":" class='hidden'")." value='".h($n["collation"])."' placeholder='(".'collation'.")'>":''),($l->unsigned?"<select name='".h($y)."[unsigned]'".(!$U||preg_match(number_type(),$U)?"":" class='hidden'").'><option>'.optionlist($l->unsigned,$n["unsigned"]).'</select>':''),(isset($n['on_update'])?"<select name='".h($y)."[on_update]'".(preg_match('~timestamp|datetime~',$U)?"":" class='hidden'").'>'.optionlist(array(""=>"(".'ON UPDATE'.")","CURRENT_TIMESTAMP"),(preg_match('~^CURRENT_TIMESTAMP~i',$n["on_update"])?"CURRENT_TIMESTAMP":$n["on_update"])).'</select>':''),($cd?"<select name='".h($y)."[on_delete]'".(preg_match("~`~",$U)?"":" class='hidden'")."><option value=''>(".'ON DELETE'.")".optionlist(explode("|",$l->onActions),$n["on_delete"])."</select> ":" ");}function
get_partitions_info($Q){global$f;$gd="FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = ".q(DB)." AND TABLE_NAME = ".q($Q);$H=$f->query("SELECT PARTITION_METHOD, PARTITION_EXPRESSION, PARTITION_ORDINAL_POSITION $gd ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");$I=array();list($I["partition_by"],$I["partition"],$I["partitions"])=$H->fetch_row();$Uf=get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $gd AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");$I["partition_names"]=array_keys($Uf);$I["partition_values"]=array_values($Uf);return$I;}function
process_length($qe){global$l;$uc=$l->enumLength;return(preg_match("~^\\s*\\(?\\s*$uc(?:\\s*,\\s*$uc)*+\\s*\\)?\\s*\$~",$qe)&&preg_match_all("~$uc~",$qe,$Ae)?"(".implode(",",$Ae[0]).")":preg_replace('~^[0-9].*~','(\0)',preg_replace('~[^-0-9,+()[\]]~','',$qe)));}function
process_type($n,$eb="COLLATE"){global$l;return" $n[type]".process_length($n["length"]).(preg_match(number_type(),$n["type"])&&in_array($n["unsigned"],$l->unsigned)?" $n[unsigned]":"").(preg_match('~char|text|enum|set~',$n["type"])&&$n["collation"]?" $eb ".(JUSH=="mssql"?$n["collation"]:q($n["collation"])):"");}function
process_field($n,$vi){if($n["on_update"])$n["on_update"]=str_ireplace("current_timestamp()","CURRENT_TIMESTAMP",$n["on_update"]);return
array(idf_escape(trim($n["field"])),process_type($vi),($n["null"]?" NULL":" NOT NULL"),default_value($n),(preg_match('~timestamp|datetime~',$n["type"])&&$n["on_update"]?" ON UPDATE $n[on_update]":""),(support("comment")&&$n["comment"]!=""?" COMMENT ".q($n["comment"]):""),($n["auto_increment"]?auto_increment():null),);}function
default_value($n){global$l;$k=$n["default"];$jd=$n["generated"];return($k===null?"":(in_array($jd,$l->generated)?(JUSH=="mssql"?" AS ($k)".($jd=="VIRTUAL"?"":" $jd")."":" GENERATED ALWAYS AS ($k) $jd"):" DEFAULT ".(!preg_match('~^GENERATED ~i',$k)&&(preg_match('~char|binary|text|json|enum|set~',$n["type"])||preg_match('~^(?![a-z])~i',$k))?(JUSH=="sql"&&preg_match('~text|json~',$n["type"])?"(".q($k).")":q($k)):str_ireplace("current_timestamp()","CURRENT_TIMESTAMP",(JUSH=="sqlite"?"($k)":$k)))));}function
type_class($U){foreach(array('char'=>'text','date'=>'time|year','binary'=>'blob','enum'=>'set',)as$y=>$X){if(preg_match("~$y|$X~",$U))return" class='$y'";}}function
edit_fields($o,$gb,$U="TABLE",$cd=array()){global$l;$o=array_values($o);$Nb=(($_POST?$_POST["defaults"]:get_setting("defaults"))?"":" class='hidden'");$mb=(($_POST?$_POST["comments"]:get_setting("comments"))?"":" class='hidden'");echo'<thead><tr>
',($U=="PROCEDURE"?"<td>":""),'<th id="label-name">',($U=="TABLE"?'Column name':'Parameter name'),'<td id="label-type">Type<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>',script("qs('#enum-edit').onblur = editingLengthBlur;"),'<td id="label-length">Length
<td>','Options';if($U=="TABLE")echo"<td id='label-null'>NULL\n","<td><input type='radio' name='auto_increment_col' value=''><abbr id='label-ai' title='".'Auto Increment'."'>AI</abbr>",doc_link(array('sql'=>"example-auto-increment.html",'mariadb'=>"auto_increment/",'sqlite'=>"autoinc.html",'pgsql'=>"datatype-numeric.html#DATATYPE-SERIAL",'mssql'=>"t-sql/statements/create-table-transact-sql-identity-property",)),"<td id='label-default'$Nb>".'Default value',(support("comment")?"<td id='label-comment'$mb>".'Comment':"");echo"<td><input type='image' class='icon' name='add[".(support("move_col")?0:count($o))."]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=5.0.6")."' alt='+' title='".'Add next'."'>".script("row_count = ".count($o).";"),"</thead>\n<tbody>\n",script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");foreach($o
as$t=>$n){$t++;$Bf=$n[($_POST?"orig":"field")];$Wb=(isset($_POST["add"][$t-1])||(isset($n["field"])&&!$_POST["drop_col"][$t]))&&(support("drop_col")||$Bf=="");echo"<tr".($Wb?"":" style='display: none;'").">\n",($U=="PROCEDURE"?"<td>".html_select("fields[$t][inout]",explode("|",$l->inout),$n["inout"]):"")."<th>";if($Wb)echo"<input name='fields[$t][field]' value='".h($n["field"])."' data-maxlength='64' autocapitalize='off' aria-labelledby='label-name'>\n";echo"<input type='hidden' name='fields[$t][orig]' value='".h($Bf)."'>";edit_type("fields[$t]",$n,$gb,$cd);if($U=="TABLE")echo"<td>".checkbox("fields[$t][null]",1,$n["null"],"","","block","label-null"),"<td><label class='block'><input type='radio' name='auto_increment_col' value='$t'".($n["auto_increment"]?" checked":"")." aria-labelledby='label-ai'></label>","<td$Nb>".($l->generated?html_select("fields[$t][generated]",array_merge(array("","DEFAULT"),$l->generated),$n["generated"])." ":checkbox("fields[$t][generated]",1,$n["generated"],"","","","label-default")),"<input name='fields[$t][default]' value='".h($n["default"])."' aria-labelledby='label-default'>",(support("comment")?"<td$mb><input name='fields[$t][comment]' value='".h($n["comment"])."' data-maxlength='".(min_version(5.5)?1024:255)."' aria-labelledby='label-comment'>":"");echo"<td>",(support("move_col")?"<input type='image' class='icon' name='add[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=5.0.6")."' alt='+' title='".'Add next'."'> "."<input type='image' class='icon' name='up[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=up.gif&version=5.0.6")."' alt='â†‘' title='".'Move up'."'> "."<input type='image' class='icon' name='down[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=down.gif&version=5.0.6")."' alt='â†“' title='".'Move down'."'> ":""),($Bf==""||support("drop_col")?"<input type='image' class='icon' name='drop_col[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=5.0.6")."' alt='x' title='".'Remove'."'>":"");}}function
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
set_utf8mb4($h){global$f;static$N=false;if(!$N&&preg_match('~\butf8mb4~i',$h)){$N=true;echo"SET NAMES ".charset($f).";\n\n";}}if(isset($_GET["status"]))$_GET["variables"]=$_GET["status"];if(isset($_GET["import"]))$_GET["sql"]=$_GET["import"];if(!(DB!=""?$f->select_db(DB):isset($_GET["sql"])||isset($_GET["dump"])||isset($_GET["database"])||isset($_GET["processlist"])||isset($_GET["privileges"])||isset($_GET["user"])||isset($_GET["variables"])||$_GET["script"]=="connect"||$_GET["script"]=="kill")){if(DB!=""||$_GET["refresh"]){restart_session();set_session("dbs",null);}if(DB!=""){header("HTTP/1.1 404 Not Found");page_header('Database'.": ".h(DB),'Invalid database.',true);}else{if($_POST["db"]&&!$m)queries_redirect(substr(ME,0,-1),'Databases have been dropped.',drop_databases($_POST["db"]));page_header('Select database',$m,false);echo"<p class='links'>\n";foreach(array('database'=>'Create database','privileges'=>'Privileges','processlist'=>'Process list','variables'=>'Variables','status'=>'Status',)as$y=>$X){if(support($y))echo"<a href='".h(ME)."$y='>$X</a>\n";}echo"<p>".sprintf('%s version: %s through PHP extension %s',$Zb[DRIVER],"<b>".h($f->server_info)."</b>","<b>$f->extension</b>")."\n","<p>".sprintf('Logged as: %s',"<b>".h(logged_user())."</b>")."\n";$i=$b->databases();if($i){$Ug=support("scheme");$gb=collations();echo"<form action='' method='post'>\n","<table class='checkable odds'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),"<thead><tr>".(support("database")?"<td>":"")."<th>".'Database'.(get_session("dbs")!==null?" - <a href='".h(ME)."refresh=1'>".'Refresh'."</a>":"")."<td>".'Collation'."<td>".'Tables'."<td>".'Size'." - <a href='".h(ME)."dbsize=1'>".'Compute'."</a>".script("qsl('a').onclick = partial(ajaxSetHtml, '".js_escape(ME)."script=connect');","")."</thead>\n";$i=($_GET["dbsize"]?count_tables($i):array_flip($i));foreach($i
as$j=>$S){$Lg=h(ME)."db=".urlencode($j);$u=h("Db-".$j);echo"<tr>".(support("database")?"<td>".checkbox("db[]",$j,in_array($j,(array)$_POST["db"]),"","","",$u):""),"<th><a href='$Lg' id='$u'>".h($j)."</a>";$fb=h(db_collation($j,$gb));echo"<td>".(support("database")?"<a href='$Lg".($Ug?"&amp;ns=":"")."&amp;database=' title='".'Alter database'."'>$fb</a>":$fb),"<td align='right'><a href='$Lg&amp;schema=' id='tables-".h($j)."' title='".'Database schema'."'>".($_GET["dbsize"]?$S:"?")."</a>","<td align='right' id='size-".h($j)."'>".($_GET["dbsize"]?db_size($j):"?"),"\n";}echo"</table>\n",(support("database")?"<div class='footer'><div>\n"."<fieldset><legend>".'Selected'." <span id='selected'></span></legend><div>\n"."<input type='hidden' name='all' value=''>".script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };")."<input type='submit' name='drop' value='".'Drop'."'>".confirm()."\n"."</div></fieldset>\n"."</div></div>\n":""),"<input type='hidden' name='token' value='$T'>\n","</form>\n",script("tableCheck();");}}page_footer("db");exit;}if(support("scheme")){if(DB!=""&&$_GET["ns"]!==""){if(!isset($_GET["ns"]))redirect(preg_replace('~ns=[^&]*&~','',ME)."ns=".get_schema());if(!set_schema($_GET["ns"])){header("HTTP/1.1 404 Not Found");page_header('Schema'.": ".h($_GET["ns"]),'Invalid schema.',true);page_footer("ns");exit;}}}class
TmpFile{private$handler,$size;function
__construct(){$this->handler=tmpfile();}function
write($ub){$this->size+=strlen($ub);fwrite($this->handler,$ub);}function
send(){fseek($this->handler,0);fpassthru($this->handler);fclose($this->handler);}}if(isset($_GET["select"])&&($_POST["edit"]||$_POST["clone"])&&!$_POST["save"])$_GET["edit"]=$_GET["select"];if(isset($_GET["callf"]))$_GET["call"]=$_GET["callf"];if(isset($_GET["function"]))$_GET["procedure"]=$_GET["function"];if(isset($_GET["download"])){$a=$_GET["download"];$o=fields($a);header("Content-Type: application/octet-stream");header("Content-Disposition: attachment; filename=".friendly_url("$a-".implode("_",$_GET["where"])).".".friendly_url($_GET["field"]));$L=array(idf_escape($_GET["field"]));$H=$l->select($a,$L,array(where($_GET,$o)),$L);$J=($H?$H->fetch_row():array());echo$l->value($J[0],$o[$_GET["field"]]);exit;}elseif(isset($_GET["table"])){$a=$_GET["table"];$o=fields($a);if(!$o)$m=error();$R=table_status1($a,true);$B=$b->tableName($R);page_header(($o&&is_view($R)?$R['Engine']=='materialized view'?'Materialized view':'View':'Table').": ".($B!=""?$B:h($a)),$m);$Kg=array();foreach($o
as$y=>$n)$Kg+=$n["privileges"];$b->selectLinks($R,(isset($Kg["insert"])||!support("table")?"":null));$lb=$R["Comment"];if($lb!="")echo"<p class='nowrap'>".'Comment'.": ".h($lb)."\n";if($o)$b->tableStructurePrint($o);if(support("indexes")&&$l->supportsIndex($R)){echo"<h3 id='indexes'>".'Indexes'."</h3>\n";$x=indexes($a);if($x)$b->tableIndexesPrint($x);echo'<p class="links"><a href="'.h(ME).'indexes='.urlencode($a).'">'.'Alter indexes'."</a>\n";}if(!is_view($R)){if(fk_support($R)){echo"<h3 id='foreign-keys'>".'Foreign keys'."</h3>\n";$cd=foreign_keys($a);if($cd){echo"<table>\n","<thead><tr><th>".'Source'."<td>".'Target'."<td>".'ON DELETE'."<td>".'ON UPDATE'."<td></thead>\n";foreach($cd
as$B=>$q){echo"<tr title='".h($B)."'>","<th><i>".implode("</i>, <i>",array_map('Adminer\h',$q["source"]))."</i>";$_=($q["db"]!=""?preg_replace('~db=[^&]*~',"db=".urlencode($q["db"]),ME):($q["ns"]!=""?preg_replace('~ns=[^&]*~',"ns=".urlencode($q["ns"]),ME):ME));echo"<td><a href='".h($_."table=".urlencode($q["table"]))."'>".($q["db"]!=""&&$q["db"]!=DB?"<b>".h($q["db"])."</b>.":"").($q["ns"]!=""&&$q["ns"]!=$_GET["ns"]?"<b>".h($q["ns"])."</b>.":"").h($q["table"])."</a>","(<i>".implode("</i>, <i>",array_map('Adminer\h',$q["target"]))."</i>)","<td>".h($q["on_delete"]),"<td>".h($q["on_update"]),'<td><a href="'.h(ME.'foreign='.urlencode($a).'&name='.urlencode($B)).'">'.'Alter'.'</a>',"\n";}echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'foreign='.urlencode($a).'">'.'Add foreign key'."</a>\n";}if(support("check")){echo"<h3 id='checks'>".'Checks'."</h3>\n";$Ua=$l->checkConstraints($a);if($Ua){echo"<table>\n";foreach($Ua
as$y=>$X)echo"<tr title='".h($y)."'>","<td><code class='jush-".JUSH."'>".h($X),"<td><a href='".h(ME.'check='.urlencode($a).'&name='.urlencode($y))."'>".'Alter'."</a>","\n";echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'check='.urlencode($a).'">'.'Create check'."</a>\n";}}if(support(is_view($R)?"view_trigger":"trigger")){echo"<h3 id='triggers'>".'Triggers'."</h3>\n";$ui=triggers($a);if($ui){echo"<table>\n";foreach($ui
as$y=>$X)echo"<tr valign='top'><td>".h($X[0])."<td>".h($X[1])."<th>".h($y)."<td><a href='".h(ME.'trigger='.urlencode($a).'&name='.urlencode($y))."'>".'Alter'."</a>\n";echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'trigger='.urlencode($a).'">'.'Add trigger'."</a>\n";}}elseif(isset($_GET["schema"])){page_header('Database schema',"",array(),h(DB.($_GET["ns"]?".$_GET[ns]":"")));$Nh=array();$Oh=array();$ea=($_GET["schema"]?:$_COOKIE["adminer_schema-".str_replace(".","_",DB)]);preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~',$ea,$Ae,PREG_SET_ORDER);foreach($Ae
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
<p class="links"><a href="',h(ME."schema=".urlencode($ea)),'" id="schema-link">Permanent link</a>
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
pack("x512");}}}$b->dumpFooter();exit;}page_header('Export',$m,($_GET["export"]!=""?array("table"=>$_GET["export"]):array()),h(DB));echo'
<form action="" method="post">
<table class="layout">
';$Kb=array('','USE','DROP+CREATE','CREATE');$Ph=array('','DROP+CREATE','CREATE');$Hb=array('','TRUNCATE+INSERT','INSERT');if(JUSH=="sql")$Hb[]='INSERT+UPDATE';$J=get_settings("adminer_export");if(!$J)$J=array("output"=>"text","format"=>"sql","db_style"=>(DB!=""?"":"CREATE"),"table_style"=>"DROP+CREATE","data_style"=>"INSERT");if(!isset($J["events"])){$J["routines"]=$J["events"]=($_GET["dump"]=="");$J["triggers"]=$J["table_style"];}echo"<tr><th>".'Output'."<td>".html_radios("output",$b->dumpOutput(),$J["output"])."\n","<tr><th>".'Format'."<td>".html_radios("format",$b->dumpFormat(),$J["format"])."\n",(JUSH=="sqlite"?"":"<tr><th>".'Database'."<td>".html_select('db_style',$Kb,$J["db_style"]).(support("type")?checkbox("types",1,$J["types"],'User types'):"").(support("routine")?checkbox("routines",1,$J["routines"],'Routines'):"").(support("event")?checkbox("events",1,$J["events"],'Events'):"")),"<tr><th>".'Tables'."<td>".html_select('table_style',$Ph,$J["table_style"]).checkbox("auto_increment",1,$J["auto_increment"],'Auto Increment').(support("trigger")?checkbox("triggers",1,$J["triggers"],'Triggers'):""),"<tr><th>".'Data'."<td>".html_select('data_style',$Hb,$J["data_style"]),'</table>
<p><input type="submit" value="Export">
<input type="hidden" name="token" value="',$T,'">

<table>
',script("qsl('table').onclick = dumpClick;");$ig=array();if(DB!=""){$Wa=($a!=""?"":" checked");echo"<thead><tr>","<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$Wa>".'Tables'."</label>".script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);",""),"<th style='text-align: right;'><label class='block'>".'Data'."<input type='checkbox' id='check-data'$Wa></label>".script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);",""),"</thead>\n";$Vi="";$Qh=tables_list();foreach($Qh
as$B=>$U){$hg=preg_replace('~_.*~','',$B);$Wa=($a==""||$a==(substr($a,-1)=="%"?"$hg%":$B));$kg="<tr><td>".checkbox("tables[]",$B,$Wa,$B,"","block");if($U!==null&&!preg_match('~table~i',$U))$Vi.="$kg\n";else
echo"$kg<td align='right'><label class='block'><span id='Rows-".h($B)."'></span>".checkbox("data[]",$B,$Wa)."</label>\n";$ig[$hg]++;}echo$Vi;if($Qh)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}else{echo"<thead><tr><th style='text-align: left;'>","<label class='block'><input type='checkbox' id='check-databases'".($a==""?" checked":"").">".'Database'."</label>",script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);",""),"</thead>\n";$i=$b->databases();if($i){foreach($i
as$j){if(!information_schema($j)){$hg=preg_replace('~_.*~','',$j);echo"<tr><td>".checkbox("databases[]",$j,$a==""||$a=="$hg%",$j,"","block")."\n";$ig[$hg]++;}}}else
echo"<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";}echo'</table>
</form>
';$Tc=true;foreach($ig
as$y=>$X){if($y!=""&&$X>1){echo($Tc?"<p>":" ")."<a href='".h(ME)."dump=".urlencode("$y%")."'>".h($y)."</a>";$Tc=false;}}}elseif(isset($_GET["privileges"])){page_header('Privileges');echo'<p class="links"><a href="'.h(ME).'user=">'.'Create user'."</a>";$H=$f->query("SELECT User, Host FROM mysql.".(DB==""?"user":"db WHERE ".q(DB)." LIKE Db")." ORDER BY Host, User");$ld=$H;if(!$H)$H=$f->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");echo"<form action=''><p>\n";hidden_fields_get();echo"<input type='hidden' name='db' value='".h(DB)."'>\n",($ld?"":"<input type='hidden' name='grant' value=''>\n"),"<table class='odds'>\n","<thead><tr><th>".'Username'."<th>".'Server'."<th></thead>\n";while($J=$H->fetch_assoc())echo'<tr><td>'.h($J["User"])."<td>".h($J["Host"]).'<td><a href="'.h(ME.'user='.urlencode($J["User"]).'&host='.urlencode($J["Host"])).'">'.'Edit'."</a>\n";if(!$ld||DB!="")echo"<tr><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='".'Edit'."'>\n";echo"</table>\n","</form>\n";}elseif(isset($_GET["sql"])){if(!$m&&$_POST["export"]){save_settings(array("output"=>$_POST["output"],"format"=>$_POST["format"]),"adminer_import");dump_headers("sql");$b->dumpTable("","");$b->dumpData("","table",$_POST["query"]);$b->dumpFooter();exit;}restart_session();$_d=&get_session("queries");$zd=&$_d[DB];if(!$m&&$_POST["clear"]){$zd=array();redirect(remove_from_uri("history"));}page_header((isset($_GET["import"])?'Import':'SQL command'),$m);if(!$m&&$_POST){$r=false;if(!isset($_GET["import"]))$G=$_POST["query"];elseif($_POST["webfile"]){$vh=$b->importServerPath();$r=@fopen((file_exists($vh)?$vh:"compress.zlib://$vh.gz"),"rb");$G=($r?fread($r,1e6):false);}else$G=get_file("sql_file",true,";");if(is_string($G)){if(function_exists('memory_get_usage')&&($Ie=ini_bytes("memory_limit"))!="-1")@ini_set("memory_limit",max($Ie,2*strlen($G)+memory_get_usage()+8e6));if($G!=""&&strlen($G)<1e6){$rg=$G.(preg_match("~;[ \t\r\n]*\$~",$G)?"":";");if(!$zd||reset(end($zd))!=$rg){restart_session();$zd[]=array($rg,time());set_session("queries",$_d);stop_session();}}$sh="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$Qb=";";$C=0;$pc=true;$g=connect($b->credentials());if(is_object($g)&&DB!=""){$g->select_db(DB);if($_GET["ns"]!="")set_schema($_GET["ns"],$g);}$kb=0;$xc=array();$Pf='[\'"'.(JUSH=="sql"?'`#':(JUSH=="sqlite"?'`[':(JUSH=="mssql"?'[':''))).']|/\*|-- |$'.(JUSH=="pgsql"?'|\$[^$]*\$':'');$ki=microtime(true);$oa=get_settings("adminer_import");$gc=$b->dumpFormat();unset($gc["sql"]);while($G!=""){if(!$C&&preg_match("~^$sh*+DELIMITER\\s+(\\S+)~i",$G,$A)){$Qb=$A[1];$G=substr($G,strlen($A[0]));}else{preg_match('('.preg_quote($Qb)."\\s*|$Pf)",$G,$A,PREG_OFFSET_CAPTURE,$C);list($ed,$cg)=$A[0];if(!$ed&&$r&&!feof($r))$G.=fread($r,1e5);else{if(!$ed&&rtrim($G)=="")break;$C=$cg+strlen($ed);if($ed&&rtrim($ed)!=$Qb){$Pa=$l->hasCStyleEscapes()||(JUSH=="pgsql"&&($cg>0&&strtolower($G[$cg-1])=="e"));$Xf=($ed=='/*'?'\*/':($ed=='['?']':(preg_match('~^-- |^#~',$ed)?"\n":preg_quote($ed).($Pa?"|\\\\.":""))));while(preg_match("($Xf|\$)s",$G,$A,PREG_OFFSET_CAPTURE,$C)){$Qg=$A[0][0];if(!$Qg&&$r&&!feof($r))$G.=fread($r,1e5);else{$C=$A[0][1]+strlen($Qg);if(!$Qg||$Qg[0]!="\\")break;}}}else{$pc=false;$rg=substr($G,0,$cg);$kb++;$kg="<pre id='sql-$kb'><code class='jush-".JUSH."'>".$b->sqlCommandQuery($rg)."</code></pre>\n";if(JUSH=="sqlite"&&preg_match("~^$sh*+ATTACH\\b~i",$rg,$A)){echo$kg,"<p class='error'>".'ATTACH queries are not supported.'."\n";$xc[]=" <a href='#sql-$kb'>$kb</a>";if($_POST["error_stops"])break;}else{if(!$_POST["only_errors"]){echo$kg;ob_flush();flush();}$_h=microtime(true);if($f->multi_query($rg)&&is_object($g)&&preg_match("~^$sh*+USE\\b~i",$rg))$g->query($rg);do{$H=$f->store_result();if($f->error){echo($_POST["only_errors"]?$kg:""),"<p class='error'>".'Error in query'.($f->errno?" ($f->errno)":"").": ".error()."\n";$xc[]=" <a href='#sql-$kb'>$kb</a>";if($_POST["error_stops"])break
2;}else{$ai=" <span class='time'>(".format_time($_h).")</span>".(strlen($rg)<1000?" <a href='".h(ME)."sql=".urlencode(trim($rg))."'>".'Edit'."</a>":"");$qa=$f->affected_rows;$Yi=($_POST["only_errors"]?"":$l->warnings());$Zi="warnings-$kb";if($Yi)$ai.=", <a href='#$Zi'>".'Warnings'."</a>".script("qsl('a').onclick = partial(toggle, '$Zi');","");$Ec=null;$Fc="explain-$kb";if(is_object($H)){$z=$_POST["limit"];$Af=select($H,$g,array(),$z);if(!$_POST["only_errors"]){echo"<form action='' method='post'>\n";$cf=$H->num_rows;echo"<p>".($cf?($z&&$cf>$z?sprintf('%d / ',$z):"").lang(array('%d row','%d rows'),$cf):""),$ai;if($g&&preg_match("~^($sh|\\()*+SELECT\\b~i",$rg)&&($Ec=explain($g,$rg)))echo", <a href='#$Fc'>Explain</a>".script("qsl('a').onclick = partial(toggle, '$Fc');","");$u="export-$kb";echo", <a href='#$u'>".'Export'."</a>".script("qsl('a').onclick = partial(toggle, '$u');","")."<span id='$u' class='hidden'>: ".html_select("output",$b->dumpOutput(),$oa["output"])." ".html_select("format",$gc,$oa["format"])."<input type='hidden' name='query' value='".h($rg)."'>"." <input type='submit' name='export' value='".'Export'."'><input type='hidden' name='token' value='$T'></span>\n"."</form>\n";}}else{if(preg_match("~^$sh*+(CREATE|DROP|ALTER)$sh++(DATABASE|SCHEMA)\\b~i",$rg)){restart_session();set_session("dbs",null);stop_session();}if(!$_POST["only_errors"])echo"<p class='message' title='".h($f->info)."'>".lang(array('Query executed OK, %d row affected.','Query executed OK, %d rows affected.'),$qa)."$ai\n";}echo($Yi?"<div id='$Zi' class='hidden'>\n$Yi</div>\n":"");if($Ec){echo"<div id='$Fc' class='hidden explain'>\n";select($Ec,$g,$Af);echo"</div>\n";}}$_h=microtime(true);}while($f->next_result());}$G=substr($G,$C);$C=0;}}}}if($pc)echo"<p class='message'>".'No commands to execute.'."\n";elseif($_POST["only_errors"])echo"<p class='message'>".lang(array('%d query executed OK.','%d queries executed OK.'),$kb-count($xc))," <span class='time'>(".format_time($ki).")</span>\n";elseif($xc&&$kb>1)echo"<p class='error'>".'Error in query'.": ".implode("",$xc)."\n";}else
echo"<p class='error'>".upload_error($G)."\n";}echo'
<form action="" method="post" enctype="multipart/form-data" id="form">
';$Cc="<input type='submit' value='".'Execute'."' title='Ctrl+Enter'>";if(!isset($_GET["import"])){$rg=$_GET["sql"];if($_POST)$rg=$_POST["query"];elseif($_GET["history"]=="all")$rg=$zd;elseif($_GET["history"]!="")$rg=$zd[$_GET["history"]][0];echo"<p>";textarea("query",$rg,20);echo
script(($_POST?"":"qs('textarea').focus();\n")."qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '".js_escape(remove_from_uri("sql|limit|error_stops|only_errors|history"))."');"),"<p>$Cc\n",'Limit rows'.": <input type='number' name='limit' class='size' value='".h($_POST?$_POST["limit"]:$_GET["limit"])."'>\n";}else{echo"<fieldset><legend>".'File upload'."</legend><div>";$rd=(extension_loaded("zlib")?"[.gz]":"");echo(ini_bool("file_uploads")?"SQL$rd (&lt; ".ini_get("upload_max_filesize")."B): <input type='file' name='sql_file[]' multiple>\n$Cc":'File uploads are disabled.'),"</div></fieldset>\n";$Gd=$b->importServerPath();if($Gd)echo"<fieldset><legend>".'From server'."</legend><div>",sprintf('Webserver file %s',"<code>".h($Gd)."$rd</code>"),' <input type="submit" name="webfile" value="'.'Run file'.'">',"</div></fieldset>\n";echo"<p>";}echo
checkbox("error_stops",1,($_POST?$_POST["error_stops"]:isset($_GET["import"])||$_GET["error_stops"]),'Stop on error')."\n",checkbox("only_errors",1,($_POST?$_POST["only_errors"]:isset($_GET["import"])||$_GET["only_errors"]),'Show only errors')."\n","<input type='hidden' name='token' value='$T'>\n";if(!isset($_GET["import"])&&$zd){print_fieldset("history",'History',$_GET["history"]!="");for($X=end($zd);$X;$X=prev($zd)){$y=key($zd);list($rg,$ai,$kc)=$X;echo'<a href="'.h(ME."sql=&history=$y").'">'.'Edit'."</a>"." <span class='time' title='".@date('Y-m-d',$ai)."'>".@date("H:i:s",$ai)."</span>"." <code class='jush-".JUSH."'>".shorten_utf8(ltrim(str_replace("\n"," ",str_replace("\r","",preg_replace('~^(#|-- ).*~m','',$rg)))),80,"</code>").($kc?" <span class='time'>($kc)</span>":"")."<br>\n";}echo"<input type='submit' name='clear' value='".'Clear'."'>\n","<a href='".h(ME."sql=&history=all")."'>".'Edit all'."</a>\n","</div></fieldset>\n";}echo'</form>
';}elseif(isset($_GET["edit"])){$a=$_GET["edit"];$o=fields($a);$Z=(isset($_GET["select"])?($_POST["check"]&&count($_POST["check"])==1?where_check($_POST["check"][0],$o):""):where($_GET,$o));$Fi=(isset($_GET["select"])?$_POST["edit"]:$Z);foreach($o
as$B=>$n){if(!isset($n["privileges"][$Fi?"update":"insert"])||$b->fieldName($n)==""||$n["generated"])unset($o[$B]);}if($_POST&&!$m&&!isset($_GET["select"])){$ue=$_POST["referer"];if($_POST["insert"])$ue=($Fi?null:$_SERVER["REQUEST_URI"]);elseif(!preg_match('~^.+&select=.+$~',$ue))$ue=ME."select=".urlencode($a);$x=indexes($a);$Ai=unique_array($_GET["where"],$x);$ug="\nWHERE $Z";if(isset($_POST["delete"]))queries_redirect($ue,'Item has been deleted.',$l->delete($a,$ug,!$Ai));else{$N=array();foreach($o
as$B=>$n){$X=process_input($n);if($X!==false&&$X!==null)$N[idf_escape($B)]=$X;}if($Fi){if(!$N)redirect($ue);queries_redirect($ue,'Item has been updated.',$l->update($a,$N,$ug,!$Ai));if(is_ajax()){page_headers();page_messages($m);exit;}}else{$H=$l->insert($a,$N);$le=($H?last_id():0);queries_redirect($ue,sprintf('Item%s has been inserted.',($le?" $le":"")),$H);}}}$J=null;if($_POST["save"])$J=(array)$_POST["fields"];elseif($Z){$L=array();foreach($o
as$B=>$n){if(isset($n["privileges"]["select"])){$wa=($_POST["clone"]&&$n["auto_increment"]?"''":convert_field($n));$L[]=($wa?"$wa AS ":"").idf_escape($B);}}$J=array();if(!support("table"))$L=array("*");if($L){$H=$l->select($a,$L,array($Z),$L,array(),(isset($_GET["select"])?2:1));if(!$H)$m=error();else{$J=$H->fetch_assoc();if(!$J)$J=false;}if(isset($_GET["select"])&&(!$J||$H->fetch_assoc()))$J=null;}}if(!support("table")&&!$o){if(!$Z){$H=$l->select($a,array("*"),$Z,array("*"));$J=($H?$H->fetch_assoc():false);if(!$J)$J=array($l->primary=>"");}if($J){foreach($J
as$y=>$X){if(!$Z)$J[$y]=null;$o[$y]=array("field"=>$y,"null"=>($y!=$l->primary),"auto_increment"=>($y==$l->primary));}}}edit_form($a,$o,$J,$Fi);}elseif(isset($_GET["create"])){$a=$_GET["create"];$Rf=array();foreach(array('HASH','LINEAR HASH','KEY','LINEAR KEY','RANGE','LIST')as$y)$Rf[$y]=$y;$_g=referencable_primary($a);$cd=array();foreach($_g
as$Lh=>$n)$cd[str_replace("`","``",$Lh)."`".str_replace("`","``",$n["field"])]=$Lh;$Df=array();$R=array();if($a!=""){$Df=fields($a);$R=table_status($a);if(!$R)$m='No tables.';}$J=$_POST;$J["fields"]=(array)$J["fields"];if($J["auto_increment_col"])$J["fields"][$J["auto_increment_col"]]["auto_increment"]=true;if($_POST)save_settings(array("comments"=>$_POST["comments"],"defaults"=>$_POST["defaults"]));if($_POST&&!process_fields($J["fields"])&&!$m){if($_POST["drop"])queries_redirect(substr(ME,0,-1),'Table has been dropped.',drop_tables(array($a)));else{$o=array();$ua=array();$Ji=false;$ad=array();$Cf=reset($Df);$sa=" FIRST";foreach($J["fields"]as$y=>$n){$q=$cd[$n["type"]];$vi=($q!==null?$_g[$q]:$n);if($n["field"]!=""){if(!$n["generated"])$n["default"]=null;$pg=process_field($n,$vi);$ua[]=array($n["orig"],$pg,$sa);if(!$Cf||$pg!==process_field($Cf,$Cf)){$o[]=array($n["orig"],$pg,$sa);if($n["orig"]!=""||$sa)$Ji=true;}if($q!==null)$ad[idf_escape($n["field"])]=($a!=""&&JUSH!="sqlite"?"ADD":" ").format_foreign_key(array('table'=>$cd[$n["type"]],'source'=>array($n["field"]),'target'=>array($vi["field"]),'on_delete'=>$n["on_delete"],));$sa=" AFTER ".idf_escape($n["field"]);}elseif($n["orig"]!=""){$Ji=true;$o[]=array($n["orig"]);}if($n["orig"]!=""){$Cf=next($Df);if(!$Cf)$sa="";}}$Tf="";if(support("partitioning")){if(isset($Rf[$J["partition_by"]])){$Of=array();foreach($J
as$y=>$X){if(preg_match('~^partition~',$y))$Of[$y]=$X;}foreach($Of["partition_names"]as$y=>$B){if($B==""){unset($Of["partition_names"][$y]);unset($Of["partition_values"][$y]);}}if($Of!=get_partitions_info($a)){$Uf=array();if($Of["partition_by"]=='RANGE'||$Of["partition_by"]=='LIST'){foreach($Of["partition_names"]as$y=>$B){$Y=$Of["partition_values"][$y];$Uf[]="\n  PARTITION ".idf_escape($B)." VALUES ".($Of["partition_by"]=='RANGE'?"LESS THAN":"IN").($Y!=""?" ($Y)":" MAXVALUE");}}$Tf.="\nPARTITION BY $Of[partition_by]($Of[partition])";if($Uf)$Tf.=" (".implode(",",$Uf)."\n)";elseif($Of["partitions"])$Tf.=" PARTITIONS ".(+$Of["partitions"]);}}elseif(preg_match("~partitioned~",$R["Create_options"]))$Tf.="\nREMOVE PARTITIONING";}$Je='Table has been altered.';if($a==""){cookie("adminer_engine",$J["Engine"]);$Je='Table has been created.';}$B=trim($J["name"]);queries_redirect(ME.(support("table")?"table=":"select=").urlencode($B),$Je,alter_table($a,$B,(JUSH=="sqlite"&&($Ji||$ad)?$ua:$o),$ad,($J["Comment"]!=$R["Comment"]?$J["Comment"]:null),($J["Engine"]&&$J["Engine"]!=$R["Engine"]?$J["Engine"]:""),($J["Collation"]&&$J["Collation"]!=$R["Collation"]?$J["Collation"]:""),($J["Auto_increment"]!=""?number($J["Auto_increment"]):""),$Tf));}}page_header(($a!=""?'Alter table':'Create table'),$m,array("table"=>$a),h($a));if(!$_POST){$xi=$l->types();$J=array("Engine"=>$_COOKIE["adminer_engine"],"fields"=>array(array("field"=>"","type"=>(isset($xi["int"])?"int":(isset($xi["integer"])?"integer":"")),"on_update"=>"")),"partition_names"=>array(""),);if($a!=""){$J=$R;$J["name"]=$a;$J["fields"]=array();if(!$_GET["auto_increment"])$J["Auto_increment"]="";foreach($Df
as$n){$n["generated"]=$n["generated"]?:(isset($n["default"])?"DEFAULT":"");$J["fields"][]=$n;}if(support("partitioning")){$J+=get_partitions_info($a);$J["partition_names"][]="";$J["partition_values"][]="";}}}$gb=collations();$rc=engines();foreach($rc
as$qc){if(!strcasecmp($qc,$J["Engine"])){$J["Engine"]=$qc;break;}}echo'
<form action="" method="post" id="form">
<p>
';if(support("columns")||$a==""){echo'Table name'."<input name='name'".($a==""&&!$_POST?" autofocus":"")." data-maxlength='64' value='".h($J["name"])."' autocapitalize='off'>\n",($rc?html_select("Engine",array(""=>"(".'engine'.")")+$rc,$J["Engine"]).on_help("getTarget(event).value",1).script("qsl('select').onchange = helpClose;")."\n":"");if($gb)echo"<datalist id='collations'>".optionlist($gb)."</datalist>",(preg_match("~sqlite|mssql~",JUSH)?"":"<input list='collations' name='Collation' value='".h($J["Collation"])."' placeholder='(".'collation'.")'>");echo"<input type='submit' value='".'Save'."'>\n";}if(support("columns")){echo"<div class='scrollable'>\n","<table id='edit-fields' class='nowrap'>\n";edit_fields($J["fields"],$gb,"TABLE",$cd);echo"</table>\n",script("editFields();"),"</div>\n<p>\n",'Auto Increment'.": <input type='number' name='Auto_increment' class='size' value='".h($J["Auto_increment"])."'>\n",checkbox("defaults",1,($_POST?$_POST["defaults"]:get_setting("defaults")),'Default values',"columnShow(this.checked, 5)","jsonly");$nb=($_POST?$_POST["comments"]:get_setting("comments"));echo(support("comment")?checkbox("comments",1,$nb,'Comment',"editingCommentsClick(this, true);","jsonly").' '.(preg_match('~\n~',$J["Comment"])?"<textarea name='Comment' rows='2' cols='20'".($nb?"":" class='hidden'").">".h($J["Comment"])."</textarea>":'<input name="Comment" value="'.h($J["Comment"]).'" data-maxlength="'.(min_version(5.5)?2048:60).'"'.($nb?"":" class='hidden'").'>'):''),'<p>
<input type="submit" value="Save">
';}echo'
';if($a!="")echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$a));if(support("partitioning")){$Sf=preg_match('~RANGE|LIST~',$J["partition_by"]);print_fieldset("partition",'Partition by',$J["partition_by"]);echo"<p>".html_select("partition_by",array(""=>"")+$Rf,$J["partition_by"]).on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')",1).script("qsl('select').onchange = partitionByChange;"),"(<input name='partition' value='".h($J["partition"])."'>)\n",'Partitions'.": <input type='number' name='partitions' class='size".($Sf||!$J["partition_by"]?" hidden":"")."' value='".h($J["partitions"])."'>\n","<table id='partition-table'".($Sf?"":" class='hidden'").">\n","<thead><tr><th>".'Partition name'."<th>".'Values'."</thead>\n";foreach($J["partition_names"]as$y=>$X)echo'<tr>','<td><input name="partition_names[]" value="'.h($X).'" autocapitalize="off">',($y==count($J["partition_names"])-1?script("qsl('input').oninput = partitionNameChange;"):''),'<td><input name="partition_values[]" value="'.h($J["partition_values"][$y]).'">';echo"</table>\n</div></fieldset>\n";}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["indexes"])){$a=$_GET["indexes"];$Kd=array("PRIMARY","UNIQUE","INDEX");$R=table_status($a,true);if(preg_match('~MyISAM|M?aria'.(min_version(5.6,'10.0.5')?'|InnoDB':'').'~i',$R["Engine"]))$Kd[]="FULLTEXT";if(preg_match('~MyISAM|M?aria'.(min_version(5.7,'10.2.2')?'|InnoDB':'').'~i',$R["Engine"]))$Kd[]="SPATIAL";$x=indexes($a);$F=array();if(JUSH=="mongo"){$F=$x["_id_"];unset($Kd[0]);unset($x["_id_"]);}$J=$_POST;if($J)save_settings(array("index_options"=>$J["options"]));if($_POST&&!$m&&!$_POST["add"]&&!$_POST["drop_col"]){$c=array();foreach($J["indexes"]as$w){$B=$w["name"];if(in_array($w["type"],$Kd)){$e=array();$re=array();$Sb=array();$N=array();ksort($w["columns"]);foreach($w["columns"]as$y=>$d){if($d!=""){$qe=$w["lengths"][$y];$Rb=$w["descs"][$y];$N[]=idf_escape($d).($qe?"(".(+$qe).")":"").($Rb?" DESC":"");$e[]=$d;$re[]=($qe?:null);$Sb[]=$Rb;}}$Dc=$x[$B];if($Dc){ksort($Dc["columns"]);ksort($Dc["lengths"]);ksort($Dc["descs"]);if($w["type"]==$Dc["type"]&&array_values($Dc["columns"])===$e&&(!$Dc["lengths"]||array_values($Dc["lengths"])===$re)&&array_values($Dc["descs"])===$Sb){unset($x[$B]);continue;}}if($e)$c[]=array($w["type"],$B,$N);}}foreach($x
as$B=>$Dc)$c[]=array($Dc["type"],$B,"DROP");if(!$c)redirect(ME."table=".urlencode($a));queries_redirect(ME."table=".urlencode($a),'Indexes have been altered.',alter_indexes($a,$c));}page_header('Indexes',$m,array("table"=>$a),h($a));$o=array_keys(fields($a));if($_POST["add"]){foreach($J["indexes"]as$y=>$w){if($w["columns"][count($w["columns"])]!="")$J["indexes"][$y]["columns"][]="";}$w=end($J["indexes"]);if($w["type"]||array_filter($w["columns"],'strlen'))$J["indexes"][]=array("columns"=>array(1=>""));}if(!$J){foreach($x
as$y=>$w){$x[$y]["name"]=$y;$x[$y]["columns"][]="";}$x[]=array("columns"=>array(1=>""));$J["indexes"]=$x;}$re=(JUSH=="sql"||JUSH=="mssql");$lh=($_POST?$_POST["options"]:get_setting("index_options"));echo'
<form action="" method="post">
<div class="scrollable">
<table class="nowrap">
<thead><tr>
<th id="label-type">Index Type
<th><input type="submit" class="wayoff">','Column'.($re?"<span class='idxopts".($lh?"":" hidden")."'> (".'length'.")</span>":"");if($re||support("descidx"))echo
checkbox("options",1,$lh,'Options',"indexOptionsShow(this.checked)","jsonly")."\n";echo'<th id="label-name">Name
<th><noscript>',"<input type='image' class='icon' name='add[0]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=5.0.6")."' alt='+' title='".'Add next'."'>",'</noscript>
</thead>
';if($F){echo"<tr><td>PRIMARY<td>";foreach($F["columns"]as$y=>$d)echo
select_input(" disabled",$o,$d),"<label><input disabled type='checkbox'>".'descending'."</label> ";echo"<td><td>\n";}$ae=1;foreach($J["indexes"]as$w){if(!$_POST["drop_col"]||$ae!=key($_POST["drop_col"])){echo"<tr><td>".html_select("indexes[$ae][type]",array(-1=>"")+$Kd,$w["type"],($ae==count($J["indexes"])?"indexesAddRow.call(this);":""),"label-type"),"<td>";ksort($w["columns"]);$t=1;foreach($w["columns"]as$y=>$d){echo"<span>".select_input(" name='indexes[$ae][columns][$t]' title='".'Column'."'",($o?array_combine($o,$o):$o),$d,"partial(".($t==count($w["columns"])?"indexesAddColumn":"indexesChangeColumn").", '".js_escape(JUSH=="sql"?"":$_GET["indexes"]."_")."')"),"<span class='idxopts".($lh?"":" hidden")."'>",($re?"<input type='number' name='indexes[$ae][lengths][$t]' class='size' value='".h($w["lengths"][$y])."' title='".'Length'."'>":""),(support("descidx")?checkbox("indexes[$ae][descs][$t]",1,$w["descs"][$y],'descending'):""),"</span> </span>";$t++;}echo"<td><input name='indexes[$ae][name]' value='".h($w["name"])."' autocapitalize='off' aria-labelledby='label-name'>\n","<td><input type='image' class='icon' name='drop_col[$ae]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=5.0.6")."' alt='x' title='".'Remove'."'>".script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");}$ae++;}echo'</table>
</div>
<p>
<input type="submit" value="Save">
<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["database"])){$J=$_POST;if($_POST&&!$m&&!isset($_POST["add_x"])){$B=trim($J["name"]);if($_POST["drop"]){$_GET["db"]="";queries_redirect(remove_from_uri("db|database"),'Database has been dropped.',drop_databases(array(DB)));}elseif(DB!==$B){if(DB!=""){$_GET["db"]=$B;queries_redirect(preg_replace('~\bdb=[^&]*&~','',ME)."db=".urlencode($B),'Database has been renamed.',rename_database($B,$J["collation"]));}else{$i=explode("\n",str_replace("\r","",$B));$Eh=true;$ke="";foreach($i
as$j){if(count($i)==1||$j!=""){if(!create_database($j,$J["collation"]))$Eh=false;$ke=$j;}}restart_session();set_session("dbs",null);queries_redirect(ME."db=".urlencode($ke),'Database has been created.',$Eh);}}else{if(!$J["collation"])redirect(substr(ME,0,-1));query_redirect("ALTER DATABASE ".idf_escape($B).(preg_match('~^[a-z0-9_]+$~i',$J["collation"])?" COLLATE $J[collation]":""),substr(ME,0,-1),'Database has been altered.');}}page_header(DB!=""?'Alter database':'Create database',$m,array(),h(DB));$gb=collations();$B=DB;if($_POST)$B=$J["name"];elseif(DB!="")$J["collation"]=db_collation(DB,$gb);elseif(JUSH=="sql"){foreach(get_vals("SHOW GRANTS")as$ld){if(preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~',$ld,$A)&&$A[1]){$B=stripcslashes(idf_unescape("`$A[2]`"));break;}}}echo'
<form action="" method="post">
<p>
',($_POST["add_x"]||strpos($B,"\n")?'<textarea autofocus name="name" rows="10" cols="40">'.h($B).'</textarea><br>':'<input name="name" autofocus value="'.h($B).'" data-maxlength="64" autocapitalize="off">')."\n".($gb?html_select("collation",array(""=>"(".'collation'.")")+$gb,$J["collation"]).doc_link(array('sql'=>"charset-charsets.html",'mariadb'=>"supported-character-sets-and-collations/",'mssql'=>"relational-databases/system-functions/sys-fn-helpcollations-transact-sql",)):""),'<input type="submit" value="Save">
';if(DB!="")echo"<input type='submit' name='drop' value='".'Drop'."'>".confirm(sprintf('Drop %s?',DB))."\n";elseif(!$_POST["add_x"]&&$_GET["db"]=="")echo"<input type='image' class='icon' name='add' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=5.0.6")."' alt='+' title='".'Add next'."'>\n";echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["scheme"])){$J=$_POST;if($_POST&&!$m){$_=preg_replace('~ns=[^&]*&~','',ME)."ns=";if($_POST["drop"])query_redirect("DROP SCHEMA ".idf_escape($_GET["ns"]),$_,'Schema has been dropped.');else{$B=trim($J["name"]);$_.=urlencode($B);if($_GET["ns"]=="")query_redirect("CREATE SCHEMA ".idf_escape($B),$_,'Schema has been created.');elseif($_GET["ns"]!=$B)query_redirect("ALTER SCHEMA ".idf_escape($_GET["ns"])." RENAME TO ".idf_escape($B),$_,'Schema has been altered.');else
redirect($_);}}page_header($_GET["ns"]!=""?'Alter schema':'Create schema',$m);if(!$J)$J["name"]=$_GET["ns"];echo'
<form action="" method="post">
<p><input name="name" autofocus value="',h($J["name"]),'" autocapitalize="off">
<input type="submit" value="Save">
';if($_GET["ns"]!="")echo"<input type='submit' name='drop' value='".'Drop'."'>".confirm(sprintf('Drop %s?',$_GET["ns"]))."\n";echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["call"])){$da=($_GET["name"]?:$_GET["call"]);page_header('Call'.": ".h($da),$m);$Mg=routine($_GET["call"],(isset($_GET["callf"])?"FUNCTION":"PROCEDURE"));$Hd=array();$If=array();foreach($Mg["fields"]as$t=>$n){if(substr($n["inout"],-3)=="OUT")$If[$t]="@".idf_escape($n["field"])." AS ".idf_escape($n["field"]);if(!$n["inout"]||substr($n["inout"],0,2)=="IN")$Hd[]=$t;}if(!$m&&$_POST){$Qa=array();foreach($Mg["fields"]as$y=>$n){if(in_array($y,$Hd)){$X=process_input($n);if($X===false)$X="''";if(isset($If[$y]))$f->query("SET @".idf_escape($n["field"])." = $X");}$Qa[]=(isset($If[$y])?"@".idf_escape($n["field"]):$X);}$G=(isset($_GET["callf"])?"SELECT":"CALL")." ".table($da)."(".implode(", ",$Qa).")";$_h=microtime(true);$H=$f->multi_query($G);$qa=$f->affected_rows;echo$b->selectQuery($G,$_h,!$H);if(!$H)echo"<p class='error'>".error()."\n";else{$g=connect($b->credentials());if(is_object($g))$g->select_db(DB);do{$H=$f->store_result();if(is_object($H))select($H,$g);else
echo"<p class='message'>".lang(array('Routine has been called, %d row affected.','Routine has been called, %d rows affected.'),$qa)." <span class='time'>".@date("H:i:s")."</span>\n";}while($f->next_result());if($If)select($f->query("SELECT ".implode(", ",$If)));}}echo'
<form action="" method="post">
';if($Hd){echo"<table class='layout'>\n";foreach($Hd
as$y){$n=$Mg["fields"][$y];$B=$n["field"];echo"<tr><th>".$b->fieldName($n);$Y=$_POST["fields"][$B];if($Y!=""){if($n["type"]=="set")$Y=implode(",",$Y);}input($n,$Y,(string)$_POST["function"][$B]);echo"\n";}echo"</table>\n";}echo'<p>
<input type="submit" value="Call">
<input type="hidden" name="token" value="',$T,'">
</form>

<pre>
';function
pre_tr($Qg){return
preg_replace('~^~m','<tr>',preg_replace('~\|~','<td>',preg_replace('~\|$~m',"",rtrim($Qg))));}$Q='(\+--[-+]+\+\n)';$J='(\| .* \|\n)';echo
preg_replace_callback("~^$Q?$J$Q?($J*)$Q?~m",function($A){$Uc=pre_tr($A[2]);return"<table>\n".($A[1]?"<thead>$Uc</thead>\n":$Uc).pre_tr($A[4])."\n</table>";},preg_replace('~(\n(    -|mysql)&gt; )(.+)~',"\\1<code class='jush-sql'>\\3</code>",preg_replace('~(.+)\n---+\n~',"<b>\\1</b>\n",h($Mg['comment']))));echo'</pre>
';}elseif(isset($_GET["foreign"])){$a=$_GET["foreign"];$B=$_GET["name"];$J=$_POST;if($_POST&&!$m&&!$_POST["add"]&&!$_POST["change"]&&!$_POST["change-js"]){if(!$_POST["drop"]){$J["source"]=array_filter($J["source"],'strlen');ksort($J["source"]);$Th=array();foreach($J["source"]as$y=>$X)$Th[$y]=$J["target"][$y];$J["target"]=$Th;}if(JUSH=="sqlite")$H=recreate_table($a,$a,array(),array(),array(" $B"=>($J["drop"]?"":" ".format_foreign_key($J))));else{$c="ALTER TABLE ".table($a);$H=($B==""||queries("$c DROP ".(JUSH=="sql"?"FOREIGN KEY ":"CONSTRAINT ").idf_escape($B)));if(!$J["drop"])$H=queries("$c ADD".format_foreign_key($J));}queries_redirect(ME."table=".urlencode($a),($J["drop"]?'Foreign key has been dropped.':($B!=""?'Foreign key has been altered.':'Foreign key has been created.')),$H);if(!$J["drop"])$m="$m<br>".'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.';}page_header('Foreign key',$m,array("table"=>$a),h($a));if($_POST){ksort($J["source"]);if($_POST["add"])$J["source"][]="";elseif($_POST["change"]||$_POST["change-js"])$J["target"]=array();}elseif($B!=""){$cd=foreign_keys($a);$J=$cd[$B];$J["source"][]="";}else{$J["table"]=$a;$J["source"]=array("");}echo'
<form action="" method="post">
';$rh=array_keys(fields($a));if($J["db"]!="")$f->select_db($J["db"]);if($J["ns"]!=""){$Ef=get_schema();set_schema($J["ns"]);}$zg=array_keys(array_filter(table_status('',true),'Adminer\fk_support'));$Th=array_keys(fields(in_array($J["table"],$zg)?$J["table"]:reset($zg)));$pf="this.form['change-js'].value = '1'; this.form.submit();";echo"<p>".'Target table'.": ".html_select("table",$zg,$J["table"],$pf)."\n";if(support("scheme")){$Tg=array_filter($b->schemas(),function($Sg){return!preg_match('~^information_schema$~i',$Sg);});echo'Schema'.": ".html_select("ns",$Tg,$J["ns"]!=""?$J["ns"]:$_GET["ns"],$pf);if($J["ns"]!="")set_schema($Ef);}elseif(JUSH!="sqlite"){$Lb=array();foreach($b->databases()as$j){if(!information_schema($j))$Lb[]=$j;}echo'DB'.": ".html_select("db",$Lb,$J["db"]!=""?$J["db"]:$_GET["db"],$pf);}echo'<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="Change"></noscript>
<table>
<thead><tr><th id="label-source">Source<th id="label-target">Target</thead>
';$ae=0;foreach($J["source"]as$y=>$X){echo"<tr>","<td>".html_select("source[".(+$y)."]",array(-1=>"")+$rh,$X,($ae==count($J["source"])-1?"foreignAddRow.call(this);":""),"label-source"),"<td>".html_select("target[".(+$y)."]",$Th,$J["target"][$y],"","label-target");$ae++;}echo'</table>
<p>
ON DELETE: ',html_select("on_delete",array(-1=>"")+explode("|",$l->onActions),$J["on_delete"]),' ON UPDATE: ',html_select("on_update",array(-1=>"")+explode("|",$l->onActions),$J["on_update"]),doc_link(array('sql'=>"innodb-foreign-key-constraints.html",'mariadb'=>"foreign-keys/",'pgsql'=>"sql-createtable.html#SQL-CREATETABLE-REFERENCES",'mssql'=>"t-sql/statements/create-table-transact-sql",'oracle'=>"SQLRF01111",)),'<p>
<input type="submit" value="Save">
<noscript><p><input type="submit" name="add" value="Add column"></noscript>
';if($B!="")echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$B));echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["view"])){$a=$_GET["view"];$J=$_POST;$Ff="VIEW";if(JUSH=="pgsql"&&$a!=""){$O=table_status($a);$Ff=strtoupper($O["Engine"]);}if($_POST&&!$m){$B=trim($J["name"]);$wa=" AS\n$J[select]";$ue=ME."table=".urlencode($B);$Je='View has been altered.';$U=($_POST["materialized"]?"MATERIALIZED VIEW":"VIEW");if(!$_POST["drop"]&&$a==$B&&JUSH!="sqlite"&&$U=="VIEW"&&$Ff=="VIEW")query_redirect((JUSH=="mssql"?"ALTER":"CREATE OR REPLACE")." VIEW ".table($B).$wa,$ue,$Je);else{$Vh=$B."_adminer_".uniqid();drop_create("DROP $Ff ".table($a),"CREATE $U ".table($B).$wa,"DROP $U ".table($B),"CREATE $U ".table($Vh).$wa,"DROP $U ".table($Vh),($_POST["drop"]?substr(ME,0,-1):$ue),'View has been dropped.',$Je,'View has been created.',$a,$B);}}if(!$_POST&&$a!=""){$J=view($a);$J["name"]=$a;$J["materialized"]=($Ff!="VIEW");if(!$m)$m=error();}page_header(($a!=""?'Alter view':'Create view'),$m,array("table"=>$a),h($a));echo'
<form action="" method="post">
<p>Name: <input name="name" value="',h($J["name"]),'" data-maxlength="64" autocapitalize="off">
',(support("materializedview")?" ".checkbox("materialized",1,$J["materialized"],'Materialized view'):""),'<p>';textarea("select",$J["select"]);echo'<p>
<input type="submit" value="Save">
';if($a!="")echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$a));echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["event"])){$aa=$_GET["event"];$Sd=array("YEAR","QUARTER","MONTH","DAY","HOUR","MINUTE","WEEK","SECOND","YEAR_MONTH","DAY_HOUR","DAY_MINUTE","DAY_SECOND","HOUR_MINUTE","HOUR_SECOND","MINUTE_SECOND");$Ah=array("ENABLED"=>"ENABLE","DISABLED"=>"DISABLE","SLAVESIDE_DISABLED"=>"DISABLE ON SLAVE");$J=$_POST;if($_POST&&!$m){if($_POST["drop"])query_redirect("DROP EVENT ".idf_escape($aa),substr(ME,0,-1),'Event has been dropped.');elseif(in_array($J["INTERVAL_FIELD"],$Sd)&&isset($Ah[$J["STATUS"]])){$Rg="\nON SCHEDULE ".($J["INTERVAL_VALUE"]?"EVERY ".q($J["INTERVAL_VALUE"])." $J[INTERVAL_FIELD]".($J["STARTS"]?" STARTS ".q($J["STARTS"]):"").($J["ENDS"]?" ENDS ".q($J["ENDS"]):""):"AT ".q($J["STARTS"]))." ON COMPLETION".($J["ON_COMPLETION"]?"":" NOT")." PRESERVE";queries_redirect(substr(ME,0,-1),($aa!=""?'Event has been altered.':'Event has been created.'),queries(($aa!=""?"ALTER EVENT ".idf_escape($aa).$Rg.($aa!=$J["EVENT_NAME"]?"\nRENAME TO ".idf_escape($J["EVENT_NAME"]):""):"CREATE EVENT ".idf_escape($J["EVENT_NAME"]).$Rg)."\n".$Ah[$J["STATUS"]]." COMMENT ".q($J["EVENT_COMMENT"]).rtrim(" DO\n$J[EVENT_DEFINITION]",";").";"));}}page_header(($aa!=""?'Alter event'.": ".h($aa):'Create event'),$m);if(!$J&&$aa!=""){$K=get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = ".q(DB)." AND EVENT_NAME = ".q($aa));$J=reset($K);}echo'
<form action="" method="post">
<table class="layout">
<tr><th>Name<td><input name="EVENT_NAME" value="',h($J["EVENT_NAME"]),'" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">Start<td><input name="STARTS" value="',h("$J[EXECUTE_AT]$J[STARTS]"),'">
<tr><th title="datetime">End<td><input name="ENDS" value="',h($J["ENDS"]),'">
<tr><th>Every<td><input type="number" name="INTERVAL_VALUE" value="',h($J["INTERVAL_VALUE"]),'" class="size"> ',html_select("INTERVAL_FIELD",$Sd,$J["INTERVAL_FIELD"]),'<tr><th>Status<td>',html_select("STATUS",$Ah,$J["STATUS"]),'<tr><th>Comment<td><input name="EVENT_COMMENT" value="',h($J["EVENT_COMMENT"]),'" data-maxlength="64">
<tr><th><td>',checkbox("ON_COMPLETION","PRESERVE",$J["ON_COMPLETION"]=="PRESERVE",'On completion preserve'),'</table>
<p>';textarea("EVENT_DEFINITION",$J["EVENT_DEFINITION"]);echo'<p>
<input type="submit" value="Save">
';if($aa!="")echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$aa));echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["procedure"])){$da=($_GET["name"]?:$_GET["procedure"]);$Mg=(isset($_GET["function"])?"FUNCTION":"PROCEDURE");$J=$_POST;$J["fields"]=(array)$J["fields"];if($_POST&&!process_fields($J["fields"])&&!$m){$Bf=routine($_GET["procedure"],$Mg);$Vh="$J[name]_adminer_".uniqid();drop_create("DROP $Mg ".routine_id($da,$Bf),create_routine($Mg,$J),"DROP $Mg ".routine_id($J["name"],$J),create_routine($Mg,array("name"=>$Vh)+$J),"DROP $Mg ".routine_id($Vh,$J),substr(ME,0,-1),'Routine has been dropped.','Routine has been altered.','Routine has been created.',$da,$J["name"]);}page_header(($da!=""?(isset($_GET["function"])?'Alter function':'Alter procedure').": ".h($da):(isset($_GET["function"])?'Create function':'Create procedure')),$m);if(!$_POST&&$da!=""){$J=routine($_GET["procedure"],$Mg);$J["name"]=$da;}$gb=get_vals("SHOW CHARACTER SET");sort($gb);$Ng=routine_languages();echo($gb?"<datalist id='collations'>".optionlist($gb)."</datalist>":""),'
<form action="" method="post" id="form">
<p>Name: <input name="name" value="',h($J["name"]),'" data-maxlength="64" autocapitalize="off">
',($Ng?'Language'.": ".html_select("language",$Ng,$J["language"])."\n":""),'<input type="submit" value="Save">
<div class="scrollable">
<table class="nowrap">
';edit_fields($J["fields"],$gb,$Mg);if(isset($_GET["function"])){echo"<tr><td>".'Return type';edit_type("returns",$J["returns"],$gb,array(),(JUSH=="pgsql"?array("void","trigger"):array()));}echo'</table>
',script("editFields();"),'</div>
<p>';textarea("definition",$J["definition"]);echo'<p>
<input type="submit" value="Save">
';if($da!="")echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$da));echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["sequence"])){$fa=$_GET["sequence"];$J=$_POST;if($_POST&&!$m){$_=substr(ME,0,-1);$B=trim($J["name"]);if($_POST["drop"])query_redirect("DROP SEQUENCE ".idf_escape($fa),$_,'Sequence has been dropped.');elseif($fa=="")query_redirect("CREATE SEQUENCE ".idf_escape($B),$_,'Sequence has been created.');elseif($fa!=$B)query_redirect("ALTER SEQUENCE ".idf_escape($fa)." RENAME TO ".idf_escape($B),$_,'Sequence has been altered.');else
redirect($_);}page_header($fa!=""?'Alter sequence'.": ".h($fa):'Create sequence',$m);if(!$J)$J["name"]=$fa;echo'
<form action="" method="post">
<p><input name="name" value="',h($J["name"]),'" autocapitalize="off">
<input type="submit" value="Save">
';if($fa!="")echo"<input type='submit' name='drop' value='".'Drop'."'>".confirm(sprintf('Drop %s?',$fa))."\n";echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["type"])){$ga=$_GET["type"];$J=$_POST;if($_POST&&!$m){$_=substr(ME,0,-1);if($_POST["drop"])query_redirect("DROP TYPE ".idf_escape($ga),$_,'Type has been dropped.');else
query_redirect("CREATE TYPE ".idf_escape(trim($J["name"]))." $J[as]",$_,'Type has been created.');}page_header($ga!=""?'Alter type'.": ".h($ga):'Create type',$m);if(!$J)$J["as"]="AS ";echo'
<form action="" method="post">
<p>
';if($ga!=""){$xi=$l->types();$vc=type_values($xi[$ga]);if($vc)echo"<code class='jush-".JUSH."'>ENUM (".h($vc).")</code>\n<p>";echo"<input type='submit' name='drop' value='".'Drop'."'>".confirm(sprintf('Drop %s?',$ga))."\n";}else{echo'Name'.": <input name='name' value='".h($J['name'])."' autocapitalize='off'>\n",doc_link(array('pgsql'=>"datatype-enum.html",),"?");textarea("as",$J["as"]);echo"<p><input type='submit' value='".'Save'."'>\n";}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["check"])){$a=$_GET["check"];$B=$_GET["name"];$J=$_POST;if($J&&!$m){if(JUSH=="sqlite")$H=recreate_table($a,$a,array(),array(),array(),0,array(),$B,($J["drop"]?"":$J["clause"]));else{$H=($B==""||queries("ALTER TABLE ".table($a)." DROP CONSTRAINT ".idf_escape($B)));if(!$J["drop"])$H=queries("ALTER TABLE ".table($a)." ADD".($J["name"]!=""?" CONSTRAINT ".idf_escape($J["name"]):"")." CHECK ($J[clause])");}queries_redirect(ME."table=".urlencode($a),($J["drop"]?'Check has been dropped.':($B!=""?'Check has been altered.':'Check has been created.')),$H);}page_header(($B!=""?'Alter check'.": ".h($B):'Create check'),$m,array("table"=>$a));if(!$J){$Xa=$l->checkConstraints($a);$J=array("name"=>$B,"clause"=>$Xa[$B]);}echo'
<form action="" method="post">
<p>';if(JUSH!="sqlite")echo'Name'.': <input name="name" value="'.h($J["name"]).'" data-maxlength="64" autocapitalize="off"> ';echo
doc_link(array('sql'=>"create-table-check-constraints.html",'mariadb'=>"constraint/",'pgsql'=>"ddl-constraints.html#DDL-CONSTRAINTS-CHECK-CONSTRAINTS",'mssql'=>"relational-databases/tables/create-check-constraints",'sqlite'=>"lang_createtable.html#check_constraints",),"?"),'<p>';textarea("clause",$J["clause"]);echo'<p><input type="submit" value="Save">
';if($B!="")echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$B));echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["trigger"])){$a=$_GET["trigger"];$B=$_GET["name"];$ti=trigger_options();$J=(array)trigger($B,$a)+array("Trigger"=>$a."_bi");if($_POST){if(!$m&&in_array($_POST["Timing"],$ti["Timing"])&&in_array($_POST["Event"],$ti["Event"])&&in_array($_POST["Type"],$ti["Type"])){$mf=" ON ".table($a);$ac="DROP TRIGGER ".idf_escape($B).(JUSH=="pgsql"?$mf:"");$ue=ME."table=".urlencode($a);if($_POST["drop"])query_redirect($ac,$ue,'Trigger has been dropped.');else{if($B!="")queries($ac);queries_redirect($ue,($B!=""?'Trigger has been altered.':'Trigger has been created.'),queries(create_trigger($mf,$_POST)));if($B!="")queries(create_trigger($mf,$J+array("Type"=>reset($ti["Type"]))));}}$J=$_POST;}page_header(($B!=""?'Alter trigger'.": ".h($B):'Create trigger'),$m,array("table"=>$a));echo'
<form action="" method="post" id="form">
<table class="layout">
<tr><th>Time<td>',html_select("Timing",$ti["Timing"],$J["Timing"],"triggerChange(/^".preg_quote($a,"/")."_[ba][iud]$/, '".js_escape($a)."', this.form);"),'<tr><th>Event<td>',html_select("Event",$ti["Event"],$J["Event"],"this.form['Timing'].onchange();"),(in_array("UPDATE OF",$ti["Event"])?" <input name='Of' value='".h($J["Of"])."' class='hidden'>":""),'<tr><th>Type<td>',html_select("Type",$ti["Type"],$J["Type"]),'</table>
<p>Name: <input name="Trigger" value="',h($J["Trigger"]),'" data-maxlength="64" autocapitalize="off">
',script("qs('#form')['Timing'].onchange();"),'<p>';textarea("Statement",$J["Statement"]);echo'<p>
<input type="submit" value="Save">
';if($B!="")echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$B));echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["user"])){$ha=$_GET["user"];$ng=array(""=>array("All privileges"=>""));foreach(get_rows("SHOW PRIVILEGES")as$J){foreach(explode(",",($J["Privilege"]=="Grant option"?"":$J["Context"]))as$vb)$ng[$vb][$J["Privilege"]]=$J["Comment"];}$ng["Server Admin"]+=$ng["File access on server"];$ng["Databases"]["Create routine"]=$ng["Procedures"]["Create routine"];unset($ng["Procedures"]["Create routine"]);$ng["Columns"]=array();foreach(array("Select","Insert","Update","References")as$X)$ng["Columns"][$X]=$ng["Tables"][$X];unset($ng["Server Admin"]["Usage"]);foreach($ng["Tables"]as$y=>$X)unset($ng["Databases"][$y]);$We=array();if($_POST){foreach($_POST["objects"]as$y=>$X)$We[$X]=(array)$We[$X]+(array)$_POST["grants"][$y];}$md=array();$kf="";if(isset($_GET["host"])&&($H=$f->query("SHOW GRANTS FOR ".q($ha)."@".q($_GET["host"])))){while($J=$H->fetch_row()){if(preg_match('~GRANT (.*) ON (.*) TO ~',$J[0],$A)&&preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~',$A[1],$Ae,PREG_SET_ORDER)){foreach($Ae
as$X){if($X[1]!="USAGE")$md["$A[2]$X[2]"][$X[1]]=true;if(preg_match('~ WITH GRANT OPTION~',$J[0]))$md["$A[2]$X[2]"]["GRANT OPTION"]=true;}}if(preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~",$J[0],$A))$kf=$A[1];}}if($_POST&&!$m){$lf=(isset($_GET["host"])?q($ha)."@".q($_GET["host"]):"''");if($_POST["drop"])query_redirect("DROP USER $lf",ME."privileges=",'User has been dropped.');else{$Ye=q($_POST["user"])."@".q($_POST["host"]);$Vf=$_POST["pass"];if($Vf!=''&&!$_POST["hashed"]&&!min_version(8)){$Vf=get_val("SELECT PASSWORD(".q($Vf).")");$m=!$Vf;}$_b=false;if(!$m){if($lf!=$Ye){$_b=queries((min_version(5)?"CREATE USER":"GRANT USAGE ON *.* TO")." $Ye IDENTIFIED BY ".(min_version(8)?"":"PASSWORD ").q($Vf));$m=!$_b;}elseif($Vf!=$kf)queries("SET PASSWORD FOR $Ye = ".q($Vf));}if(!$m){$Jg=array();foreach($We
as$ef=>$ld){if(isset($_GET["grant"]))$ld=array_filter($ld);$ld=array_keys($ld);if(isset($_GET["grant"]))$Jg=array_diff(array_keys(array_filter($We[$ef],'strlen')),$ld);elseif($lf==$Ye){$if=array_keys((array)$md[$ef]);$Jg=array_diff($if,$ld);$ld=array_diff($ld,$if);unset($md[$ef]);}if(preg_match('~^(.+)\s*(\(.*\))?$~U',$ef,$A)&&(!grant("REVOKE",$Jg,$A[2]," ON $A[1] FROM $Ye")||!grant("GRANT",$ld,$A[2]," ON $A[1] TO $Ye"))){$m=true;break;}}}if(!$m&&isset($_GET["host"])){if($lf!=$Ye)queries("DROP USER $lf");elseif(!isset($_GET["grant"])){foreach($md
as$ef=>$Jg){if(preg_match('~^(.+)(\(.*\))?$~U',$ef,$A))grant("REVOKE",array_keys($Jg),$A[2]," ON $A[1] FROM $Ye");}}}queries_redirect(ME."privileges=",(isset($_GET["host"])?'User has been altered.':'User has been created.'),!$m);if($_b)$f->query("DROP USER $Ye");}}page_header((isset($_GET["host"])?'Username'.": ".h("$ha@$_GET[host]"):'Create user'),$m,array("privileges"=>array('','Privileges')));$J=$_POST;if($J)$md=$We;else{$J=$_GET+array("host"=>get_val("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)"));$J["pass"]=$kf;if($kf!="")$J["hashed"]=true;$md[(DB==""||$md?"":idf_escape(addcslashes(DB,"%_\\"))).".*"]=array();}echo'<form action="" method="post">
<table class="layout">
<tr><th>Server<td><input name="host" data-maxlength="60" value="',h($J["host"]),'" autocapitalize="off">
<tr><th>Username<td><input name="user" data-maxlength="80" value="',h($J["user"]),'" autocapitalize="off">
<tr><th>Password<td><input name="pass" id="pass" value="',h($J["pass"]),'" autocomplete="new-password">
',($J["hashed"]?"":script("typePassword(qs('#pass'));")),(min_version(8)?"":checkbox("hashed",1,$J["hashed"],'Hashed',"typePassword(this.form['pass'], this.checked);")),'</table>

',"<table class='odds'>\n","<thead><tr><th colspan='2'>".'Privileges'.doc_link(array('sql'=>"grant.html#priv_level"));$t=0;foreach($md
as$ef=>$ld){echo'<th>'.($ef!="*.*"?"<input name='objects[$t]' value='".h($ef)."' size='10' autocapitalize='off'>":"<input type='hidden' name='objects[$t]' value='*.*' size='10'>*.*");$t++;}echo"</thead>\n";foreach(array(""=>"","Server Admin"=>'Server',"Databases"=>'Database',"Tables"=>'Table',"Columns"=>'Column',"Procedures"=>'Routine',)as$vb=>$Rb){foreach((array)$ng[$vb]as$mg=>$lb){echo"<tr><td".($Rb?">$Rb<td":" colspan='2'").' lang="en" title="'.h($lb).'">'.h($mg);$t=0;foreach($md
as$ef=>$ld){$B="'grants[$t][".h(strtoupper($mg))."]'";$Y=$ld[strtoupper($mg)];if($vb=="Server Admin"&&$ef!=(isset($md["*.*"])?"*.*":".*"))echo"<td>";elseif(isset($_GET["grant"]))echo"<td><select name=$B><option><option value='1'".($Y?" selected":"").">".'Grant'."<option value='0'".($Y=="0"?" selected":"").">".'Revoke'."</select>";else
echo"<td align='center'><label class='block'>","<input type='checkbox' name=$B value='1'".($Y?" checked":"").($mg=="All privileges"?" id='grants-$t-all'>":">".($mg=="Grant option"?"":script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$t-all'); };"))),"</label>";$t++;}}}echo"</table>\n",'<p>
<input type="submit" value="Save">
';if(isset($_GET["host"]))echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',"$ha@$_GET[host]"));echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["processlist"])){if(support("kill")){if($_POST&&!$m){$ge=0;foreach((array)$_POST["kill"]as$X){if(kill_process($X))$ge++;}queries_redirect(ME."processlist=",lang(array('%d process has been killed.','%d processes have been killed.'),$ge),$ge||!$_POST["kill"]);}}page_header('Process list',$m);echo'
<form action="" method="post">
<div class="scrollable">
<table class="nowrap checkable odds">
',script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");$t=-1;foreach(process_list()as$t=>$J){if(!$t){echo"<thead><tr lang='en'>".(support("kill")?"<th>":"");foreach($J
as$y=>$X)echo"<th>$y".doc_link(array('sql'=>"show-processlist.html#processlist_".strtolower($y),'pgsql'=>"monitoring-stats.html#PG-STAT-ACTIVITY-VIEW",'oracle'=>"REFRN30223",));echo"</thead>\n";}echo"<tr>".(support("kill")?"<td>".checkbox("kill[]",$J[JUSH=="sql"?"Id":"pid"],0):"");foreach($J
as$y=>$X)echo"<td>".((JUSH=="sql"&&$y=="Info"&&preg_match("~Query|Killed~",$J["Command"])&&$X!="")||(JUSH=="pgsql"&&$y=="current_query"&&$X!="<IDLE>")||(JUSH=="oracle"&&$y=="sql_text"&&$X!="")?"<code class='jush-".JUSH."'>".shorten_utf8($X,100,"</code>").' <a href="'.h(ME.($J["db"]!=""?"db=".urlencode($J["db"])."&":"")."sql=".urlencode($X)).'">'.'Clone'.'</a>':h($X));echo"\n";}echo'</table>
</div>
<p>
';if(support("kill"))echo($t+1)."/".sprintf('%d in total',max_connections()),"<p><input type='submit' value='".'Kill'."'>\n";echo'<input type="hidden" name="token" value="',$T,'">
</form>
',script("tableCheck();");}elseif(isset($_GET["select"])){$a=$_GET["select"];$R=table_status1($a);$x=indexes($a);$o=fields($a);$cd=column_foreign_keys($a);$gf=$R["Oid"];$pa=get_settings("adminer_import");$Kg=array();$e=array();$Wg=array();$yf=array();$Zh=null;foreach($o
as$y=>$n){$B=$b->fieldName($n);$Ue=html_entity_decode(strip_tags($B),ENT_QUOTES);if(isset($n["privileges"]["select"])&&$B!=""){$e[$y]=$Ue;if(is_shortable($n))$Zh=$b->selectLengthProcess();}if(isset($n["privileges"]["where"])&&$B!="")$Wg[$y]=$Ue;if(isset($n["privileges"]["order"])&&$B!="")$yf[$y]=$Ue;$Kg+=$n["privileges"];}list($L,$nd)=$b->selectColumnsProcess($e,$x);$L=array_unique($L);$nd=array_unique($nd);$Wd=count($nd)<count($L);$Z=$b->selectSearchProcess($o,$x);$xf=$b->selectOrderProcess($o,$x);$z=$b->selectLimitProcess();if($_GET["val"]&&is_ajax()){header("Content-Type: text/plain; charset=utf-8");foreach($_GET["val"]as$Bi=>$J){$wa=convert_field($o[key($J)]);$L=array($wa?:idf_escape(key($J)));$Z[]=where_check($Bi,$o);$I=$l->select($a,$L,$Z,$L);if($I)echo
reset($I->fetch_row());}exit;}$F=$Di=null;foreach($x
as$w){if($w["type"]=="PRIMARY"){$F=array_flip($w["columns"]);$Di=($L?$F:array());foreach($Di
as$y=>$X){if(in_array(idf_escape($y),$L))unset($Di[$y]);}break;}}if($gf&&!$F){$F=$Di=array($gf=>0);$x[]=array("type"=>"PRIMARY","columns"=>array($gf));}if($_POST&&!$m){$bj=$Z;if(!$_POST["all"]&&is_array($_POST["check"])){$Xa=array();foreach($_POST["check"]as$Ta)$Xa[]=where_check($Ta,$o);$bj[]="((".implode(") OR (",$Xa)."))";}$bj=($bj?"\nWHERE ".implode(" AND ",$bj):"");if($_POST["export"]){save_settings(array("output"=>$_POST["output"],"format"=>$_POST["format"]),"adminer_import");dump_headers($a);$b->dumpTable($a,"");$gd=($L?implode(", ",$L):"*").convert_fields($e,$o,$L)."\nFROM ".table($a);$pd=($nd&&$Wd?"\nGROUP BY ".implode(", ",$nd):"").($xf?"\nORDER BY ".implode(", ",$xf):"");$G="SELECT $gd$bj$pd";if(is_array($_POST["check"])&&!$F){$_i=array();foreach($_POST["check"]as$X)$_i[]="(SELECT".limit($gd,"\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$o).$pd,1).")";$G=implode(" UNION ALL ",$_i);}$b->dumpData($a,"table",$G);$b->dumpFooter();exit;}if(!$b->selectEmailProcess($Z,$cd)){if($_POST["save"]||$_POST["delete"]){$H=true;$qa=0;$N=array();if(!$_POST["delete"]){foreach($_POST["fields"]as$B=>$X){$X=process_input($o[$B]);if($X!==null&&($_POST["clone"]||$X!==false))$N[idf_escape($B)]=($X!==false?$X:idf_escape($B));}}if($_POST["delete"]||$N){if($_POST["clone"])$G="INTO ".table($a)." (".implode(", ",array_keys($N)).")\nSELECT ".implode(", ",$N)."\nFROM ".table($a);if($_POST["all"]||($F&&is_array($_POST["check"]))||$Wd){$H=($_POST["delete"]?$l->delete($a,$bj):($_POST["clone"]?queries("INSERT $G$bj"):$l->update($a,$N,$bj)));$qa=$f->affected_rows;}else{foreach((array)$_POST["check"]as$X){$aj="\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$o);$H=($_POST["delete"]?$l->delete($a,$aj,1):($_POST["clone"]?queries("INSERT".limit1($a,$G,$aj)):$l->update($a,$N,$aj,1)));if(!$H)break;$qa+=$f->affected_rows;}}}$Je=lang(array('%d item has been affected.','%d items have been affected.'),$qa);if($_POST["clone"]&&$H&&$qa==1){$le=last_id();if($le)$Je=sprintf('Item%s has been inserted.'," $le");}queries_redirect(remove_from_uri($_POST["all"]&&$_POST["delete"]?"page":""),$Je,$H);if(!$_POST["delete"]){$gg=(array)$_POST["fields"];edit_form($a,array_intersect_key($o,$gg),$gg,!$_POST["clone"]);page_footer();exit;}}elseif(!$_POST["import"]){if(!$_POST["val"])$m='Ctrl+click on a value to modify it.';else{$H=true;$qa=0;foreach($_POST["val"]as$Bi=>$J){$N=array();foreach($J
as$y=>$X){$y=bracket_escape($y,1);$N[idf_escape($y)]=(preg_match('~char|text~',$o[$y]["type"])||$X!=""?$b->processInput($o[$y],$X):"NULL");}$H=$l->update($a,$N," WHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($Bi,$o),!$Wd&&!$F," ");if(!$H)break;$qa+=$f->affected_rows;}queries_redirect(remove_from_uri(),lang(array('%d item has been affected.','%d items have been affected.'),$qa),$H);}}elseif(!is_string($Rc=get_file("csv_file",true)))$m=upload_error($Rc);elseif(!preg_match('~~u',$Rc))$m='File must be in UTF-8 encoding.';else{save_settings(array("output"=>$pa["output"],"format"=>$_POST["separator"]),"adminer_import");$H=true;$hb=array_keys($o);preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~',$Rc,$Ae);$qa=count($Ae[0]);$l->begin();$ch=($_POST["separator"]=="csv"?",":($_POST["separator"]=="tsv"?"\t":";"));$K=array();foreach($Ae[0]as$y=>$X){preg_match_all("~((?>\"[^\"]*\")+|[^$ch]*)$ch~",$X.$ch,$Be);if(!$y&&!array_diff($Be[1],$hb)){$hb=$Be[1];$qa--;}else{$N=array();foreach($Be[1]as$t=>$db)$N[idf_escape($hb[$t])]=($db==""&&$o[$hb[$t]]["null"]?"NULL":q(preg_match('~^".*"$~s',$db)?str_replace('""','"',substr($db,1,-1)):$db));$K[]=$N;}}$H=(!$K||$l->insertUpdate($a,$K,$F));if($H)$l->commit();queries_redirect(remove_from_uri("page"),lang(array('%d row has been imported.','%d rows have been imported.'),$qa),$H);$l->rollback();}}}$Lh=$b->tableName($R);if(is_ajax()){page_headers();ob_start();}else
page_header('Select'.": $Lh",$m);$N=null;if(isset($Kg["insert"])||!support("table")){$Of=array();foreach((array)$_GET["where"]as$X){if(isset($cd[$X["col"]])&&count($cd[$X["col"]])==1&&($X["op"]=="="||(!$X["op"]&&(is_array($X["val"])||!preg_match('~[_%]~',$X["val"])))))$Of["set"."[".bracket_escape($X["col"])."]"]=$X["val"];}$N=$Of?"&".http_build_query($Of):"";}$b->selectLinks($R,$N);if(!$e&&support("table"))echo"<p class='error'>".'Unable to select the table'.($o?".":": ".error())."\n";else{echo"<form action='' id='form'>\n","<div style='display: none;'>";hidden_fields_get();echo(DB!=""?'<input type="hidden" name="db" value="'.h(DB).'">'.(isset($_GET["ns"])?'<input type="hidden" name="ns" value="'.h($_GET["ns"]).'">':""):""),'<input type="hidden" name="select" value="'.h($a).'">',"</div>\n";$b->selectColumnsPrint($L,$e);$b->selectSearchPrint($Z,$Wg,$x);$b->selectOrderPrint($xf,$yf,$x);$b->selectLimitPrint($z);$b->selectLengthPrint($Zh);$b->selectActionPrint($x);echo"</form>\n";$D=$_GET["page"];if($D=="last"){$fd=get_val(count_rows($a,$Z,$Wd,$nd));$D=floor(max(0,$fd-1)/$z);}$Xg=$L;$od=$nd;if(!$Xg){$Xg[]="*";$wb=convert_fields($e,$o,$L);if($wb)$Xg[]=substr($wb,2);}foreach($L
as$y=>$X){$n=$o[idf_unescape($X)];if($n&&($wa=convert_field($n)))$Xg[$y]="$wa AS $X";}if(!$Wd&&$Di){foreach($Di
as$y=>$X){$Xg[]=idf_escape($y);if($od)$od[]=idf_escape($y);}}$H=$l->select($a,$Xg,$Z,$od,$xf,$z,$D,true);if(!$H)echo"<p class='error'>".error()."\n";else{if(JUSH=="mssql"&&$D)$H->seek($z*$D);$oc=array();echo"<form action='' method='post' enctype='multipart/form-data'>\n";$K=array();while($J=$H->fetch_assoc()){if($D&&JUSH=="oracle")unset($J["RNUM"]);$K[]=$J;}if($_GET["page"]!="last"&&$z!=""&&$nd&&$Wd&&JUSH=="sql")$fd=get_val(" SELECT FOUND_ROWS()");if(!$K)echo"<p class='message'>".'No rows.'."\n";else{$Ea=$b->backwardKeys($a,$Lh);echo"<div class='scrollable'>","<table id='table' class='nowrap checkable odds'>",script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"),"<thead><tr>".(!$nd&&$L?"":"<td><input type='checkbox' id='all-page' class='jsonly'>".script("qs('#all-page').onclick = partial(formCheck, /check/);","")." <a href='".h($_GET["modify"]?remove_from_uri("modify"):$_SERVER["REQUEST_URI"]."&modify=1")."'>".'Modify'."</a>");$Ve=array();$id=array();reset($L);$wg=1;foreach($K[0]as$y=>$X){if(!isset($Di[$y])){$X=$_GET["columns"][key($L)];$n=$o[$L?($X?$X["col"]:current($L)):$y];$B=($n?$b->fieldName($n,$wg):($X["fun"]?"*":h($y)));if($B!=""){$wg++;$Ve[$y]=$B;$d=idf_escape($y);$Bd=remove_from_uri('(order|desc)[^=]*|page').'&order%5B0%5D='.urlencode($y);$Rb="&desc%5B0%5D=1";$qh=isset($n["privileges"]["order"]);echo"<th id='th[".h(bracket_escape($y))."]'>".script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});","");$hd=apply_sql_function($X["fun"],$B);echo($qh?'<a href="'.h($Bd.($xf[0]==$d||$xf[0]==$y||(!$xf&&$Wd&&$nd[0]==$d)?$Rb:'')).'">'."$hd</a>":$hd),"<span class='column hidden'>";if($qh)echo"<a href='".h($Bd.$Rb)."' title='".'descending'."' class='text'> â†“</a>";if(!$X["fun"]&&isset($n["privileges"]["where"]))echo'<a href="#fieldset-search" title="'.'Search'.'" class="text jsonly"> =</a>',script("qsl('a').onclick = partial(selectSearch, '".js_escape($y)."');");echo"</span>";}$id[$y]=$X["fun"];next($L);}}$re=array();if($_GET["modify"]){foreach($K
as$J){foreach($J
as$y=>$X)$re[$y]=max($re[$y],min(40,strlen(utf8_decode($X))));}}echo($Ea?"<th>".'Relations':"")."</thead>\n";if(is_ajax())ob_end_clean();foreach($b->rowDescriptions($K,$cd)as$Te=>$J){$Ai=unique_array($K[$Te],$x);if(!$Ai){$Ai=array();foreach($K[$Te]as$y=>$X){if(!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~',$y))$Ai[$y]=$X;}}$Bi="";foreach($Ai
as$y=>$X){if((JUSH=="sql"||JUSH=="pgsql")&&preg_match('~char|text|enum|set~',$o[$y]["type"])&&strlen($X)>64){$y=(strpos($y,'(')?$y:idf_escape($y));$y="MD5(".(JUSH!='sql'||preg_match("~^utf8~",$o[$y]["collation"])?$y:"CONVERT($y USING ".charset($f).")").")";$X=md5($X);}$Bi.="&".($X!==null?urlencode("where[".bracket_escape($y)."]")."=".urlencode($X===false?"f":$X):"null%5B%5D=".urlencode($y));}echo"<tr>".(!$nd&&$L?"":"<td>".checkbox("check[]",substr($Bi,1),in_array(substr($Bi,1),(array)$_POST["check"])).($Wd||information_schema(DB)?"":" <a href='".h(ME."edit=".urlencode($a).$Bi)."' class='edit'>".'edit'."</a>"));foreach($J
as$y=>$X){if(isset($Ve[$y])){$n=$o[$y];$X=$l->value($X,$n);if($X!=""&&(!isset($oc[$y])||$oc[$y]!=""))$oc[$y]=(is_mail($X)?$Ve[$y]:"");$_="";if(preg_match('~blob|bytea|raw|file~',$n["type"])&&$X!="")$_=ME.'download='.urlencode($a).'&field='.urlencode($y).$Bi;if(!$_&&$X!==null){foreach((array)$cd[$y]as$q){if(count($cd[$y])==1||end($q["source"])==$y){$_="";foreach($q["source"]as$t=>$rh)$_.=where_link($t,$q["target"][$t],$K[$Te][$rh]);$_=($q["db"]!=""?preg_replace('~([?&]db=)[^&]+~','\1'.urlencode($q["db"]),ME):ME).'select='.urlencode($q["table"]).$_;if($q["ns"])$_=preg_replace('~([?&]ns=)[^&]+~','\1'.urlencode($q["ns"]),$_);if(count($q["source"])==1)break;}}}if($y=="COUNT(*)"){$_=ME."select=".urlencode($a);$t=0;foreach((array)$_GET["where"]as$W){if(!array_key_exists($W["col"],$Ai))$_.=where_link($t++,$W["col"],$W["val"],$W["op"]);}foreach($Ai
as$ce=>$W)$_.=where_link($t++,$ce,$W);}$X=select_value($X,$_,$n,$Zh);$u=h("val[$Bi][".bracket_escape($y)."]");$Y=$_POST["val"][$Bi][bracket_escape($y)];$jc=!is_array($J[$y])&&is_utf8($X)&&$K[$Te][$y]==$J[$y]&&!$id[$y]&&!$n["generated"];$Xh=preg_match('~text|json|lob~',$n["type"]);echo"<td id='$u'".(preg_match(number_type(),$n["type"])&&is_numeric(strip_tags($X))?" class='number'":"");if(($_GET["modify"]&&$jc)||$Y!==null){$sd=h($Y!==null?$Y:$J[$y]);echo">".($Xh?"<textarea name='$u' cols='30' rows='".(substr_count($J[$y],"\n")+1)."'>$sd</textarea>":"<input name='$u' value='$sd' size='$re[$y]'>");}else{$we=strpos($X,"<i>â€¦</i>");echo" data-text='".($we?2:($Xh?1:0))."'".($jc?"":" data-warning='".h('Use edit link to modify this value.')."'").">$X";}}}if($Ea)echo"<td>";$b->backwardKeysPrint($Ea,$K[$Te]);echo"</tr>\n";}if(is_ajax())exit;echo"</table>\n","</div>\n";}if(!is_ajax()){if($K||$D){$Bc=true;if($_GET["page"]!="last"){if($z==""||(count($K)<$z&&($K||!$D)))$fd=($D?$D*$z:0)+count($K);elseif(JUSH!="sql"||!$Wd){$fd=($Wd?false:found_rows($R,$Z));if($fd<max(1e4,2*($D+1)*$z))$fd=reset(slow_query(count_rows($a,$Z,$Wd,$nd)));else$Bc=false;}}$Mf=($z!=""&&($fd===false||$fd>$z||$D));if($Mf)echo(($fd===false?count($K)+1:$fd-$D*$z)>$z?'<p><a href="'.h(remove_from_uri("page")."&page=".($D+1)).'" class="loadmore">'.'Load more data'.'</a>'.script("qsl('a').onclick = partial(selectLoadMore, ".(+$z).", '".'Loading'."â€¦');",""):''),"\n";}echo"<div class='footer'><div>\n";if($K||$D){if($Mf){$De=($fd===false?$D+(count($K)>=$z?2:1):floor(($fd-1)/$z));echo"<fieldset>";if(JUSH!="simpledb"){echo"<legend><a href='".h(remove_from_uri("page"))."'>".'Page'."</a></legend>",script("qsl('a').onclick = function () { pageClick(this.href, +prompt('".'Page'."', '".($D+1)."')); return false; };"),pagination(0,$D).($D>5?" â€¦":"");for($t=max(1,$D-4);$t<min($De,$D+5);$t++)echo
pagination($t,$D);if($De>0)echo($D+5<$De?" â€¦":""),($Bc&&$fd!==false?pagination($De,$D):" <a href='".h(remove_from_uri("page")."&page=last")."' title='~$De'>".'last'."</a>");}else
echo"<legend>".'Page'."</legend>",pagination(0,$D).($D>1?" â€¦":""),($D?pagination($D,$D):""),($De>$D?pagination($D+1,$D).($De>$D+1?" â€¦":""):"");echo"</fieldset>\n";}echo"<fieldset>","<legend>".'Whole result'."</legend>";$Xb=($Bc?"":"~ ").$fd;$qf="var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$Xb' : checked); selectCount('selected2', this.checked || !checked ? '$Xb' : checked);";echo
checkbox("all",1,0,($fd!==false?($Bc?"":"~ ").lang(array('%d row','%d rows'),$fd):""),$qf)."\n","</fieldset>\n";if($b->selectCommandPrint())echo'<fieldset',($_GET["modify"]?'':' class="jsonly"'),'><legend>Modify</legend><div>
<input type="submit" value="Save"',($_GET["modify"]?'':' title="'.'Ctrl+click on a value to modify it.'.'"'),'>
</div></fieldset>
<fieldset><legend>Selected <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="Edit">
<input type="submit" name="clone" value="Clone">
<input type="submit" name="delete" value="Delete">',confirm(),'</div></fieldset>
';$dd=$b->dumpFormat();foreach((array)$_GET["columns"]as$d){if($d["fun"]){unset($dd['sql']);break;}}if($dd){print_fieldset("export",'Export'." <span id='selected2'></span>");$Jf=$b->dumpOutput();echo($Jf?html_select("output",$Jf,$pa["output"])." ":""),html_select("format",$dd,$pa["format"])," <input type='submit' name='export' value='".'Export'."'>\n","</div></fieldset>\n";}$b->selectEmailPrint(array_filter($oc,'strlen'),$e);}echo"</div></div>\n";if($b->selectImportPrint())echo"<div>","<a href='#import'>".'Import'."</a>",script("qsl('a').onclick = partial(toggle, 'import');",""),"<span id='import'".($_POST["import"]?"":" class='hidden'").">: ","<input type='file' name='csv_file'> ",html_select("separator",array("csv"=>"CSV,","csv;"=>"CSV;","tsv"=>"TSV"),$pa["format"])," <input type='submit' name='import' value='".'Import'."'>","</span>","</div>";echo"<input type='hidden' name='token' value='$T'>\n","</form>\n",(!$nd&&$L?"":script("tableCheck();"));}}}if(is_ajax()){ob_end_clean();exit;}}elseif(isset($_GET["variables"])){$O=isset($_GET["status"]);page_header($O?'Status':'Variables');$Ri=($O?show_status():show_variables());if(!$Ri)echo"<p class='message'>".'No rows.'."\n";else{echo"<table>\n";foreach($Ri
as$y=>$X)echo"<tr>","<th><code class='jush-".JUSH.($O?"status":"set")."'>".h($y)."</code>","<td>".nl_br(h($X));echo"</table>\n";}}elseif(isset($_GET["script"])){header("Content-Type: text/javascript; charset=utf-8");if($_GET["script"]=="db"){$Hh=array("Data_length"=>0,"Index_length"=>0,"Data_free"=>0);foreach(table_status()as$B=>$R){json_row("Comment-$B",h($R["Comment"]));if(!is_view($R)){foreach(array("Engine","Collation")as$y)json_row("$y-$B",h($R[$y]));foreach($Hh+array("Auto_increment"=>0,"Rows"=>0)as$y=>$X){if($R[$y]!=""){$X=format_number($R[$y]);if($X>=0)json_row("$y-$B",($y=="Rows"&&$X&&$R["Engine"]==(JUSH=="pgsql"?"table":"InnoDB")?"~ $X":$X));if(isset($Hh[$y]))$Hh[$y]+=($R["Engine"]!="InnoDB"||$y!="Data_free"?$R[$y]:0);}elseif(array_key_exists($y,$R))json_row("$y-$B","?");}}}foreach($Hh
as$y=>$X)json_row("sum-$y",format_number($X));json_row("");}elseif($_GET["script"]=="kill")$f->query("KILL ".number($_POST["kill"]));else{foreach(count_tables($b->databases())as$j=>$X){json_row("tables-$j",$X);json_row("size-$j",db_size($j));}json_row("");}exit;}else{$Rh=array_merge((array)$_POST["tables"],(array)$_POST["views"]);if($Rh&&!$m&&!$_POST["search"]){$H=true;$Je="";if(JUSH=="sql"&&$_POST["tables"]&&count($_POST["tables"])>1&&($_POST["drop"]||$_POST["truncate"]||$_POST["copy"]))queries("SET foreign_key_checks = 0");if($_POST["truncate"]){if($_POST["tables"])$H=truncate_tables($_POST["tables"]);$Je='Tables have been truncated.';}elseif($_POST["move"]){$H=move_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Je='Tables have been moved.';}elseif($_POST["copy"]){$H=copy_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Je='Tables have been copied.';}elseif($_POST["drop"]){if($_POST["views"])$H=drop_views($_POST["views"]);if($H&&$_POST["tables"])$H=drop_tables($_POST["tables"]);$Je='Tables have been dropped.';}elseif(JUSH=="sqlite"&&$_POST["check"]){foreach((array)$_POST["tables"]as$Q){foreach(get_rows("PRAGMA integrity_check(".q($Q).")")as$J)$Je.="<b>".h($Q)."</b>: ".h($J["integrity_check"])."<br>";}}elseif(JUSH!="sql"){$H=(JUSH=="sqlite"?queries("VACUUM"):apply_queries("VACUUM".($_POST["optimize"]?"":" ANALYZE"),$_POST["tables"]));$Je='Tables have been optimized.';}elseif(!$_POST["tables"])$Je='No tables.';elseif($H=queries(($_POST["optimize"]?"OPTIMIZE":($_POST["check"]?"CHECK":($_POST["repair"]?"REPAIR":"ANALYZE")))." TABLE ".implode(", ",array_map('Adminer\idf_escape',$_POST["tables"])))){while($J=$H->fetch_assoc())$Je.="<b>".h($J["Table"])."</b>: ".h($J["Msg_text"])."<br>";}queries_redirect(substr(ME,0,-1),$Je,$H);}page_header(($_GET["ns"]==""?'Database'.": ".h(DB):'Schema'.": ".h($_GET["ns"])),$m,true);if($b->homepage()){if($_GET["ns"]!==""){echo"<h3 id='tables-views'>".'Tables and views'."</h3>\n";$Qh=tables_list();if(!$Qh)echo"<p class='message'>".'No tables.'."\n";else{echo"<form action='' method='post'>\n";if(support("table")){echo"<fieldset><legend>".'Search data in tables'." <span id='selected2'></span></legend><div>","<input type='search' name='query' value='".h($_POST["query"])."'>",script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');","")," <input type='submit' name='search' value='".'Search'."'>\n","</div></fieldset>\n";if($_POST["search"]&&$_POST["query"]!=""){$_GET["where"][0]["op"]=$l->convertOperator("LIKE %%");search_tables();}}echo"<div class='scrollable'>\n","<table class='nowrap checkable odds'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),'<thead><tr class="wrap">','<td><input id="check-all" type="checkbox" class="jsonly">'.script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);",""),'<th>'.'Table','<td>'.'Engine'.doc_link(array('sql'=>'storage-engines.html')),'<td>'.'Collation'.doc_link(array('sql'=>'charset-charsets.html','mariadb'=>'supported-character-sets-and-collations/')),'<td>'.'Data Length'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT','oracle'=>'REFRN20286')),'<td>'.'Index Length'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT')),'<td>'.'Data Free'.doc_link(array('sql'=>'show-table-status.html')),'<td>'.'Auto Increment'.doc_link(array('sql'=>'example-auto-increment.html','mariadb'=>'auto_increment/')),'<td>'.'Rows'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'catalog-pg-class.html#CATALOG-PG-CLASS','oracle'=>'REFRN20286')),(support("comment")?'<td>'.'Comment'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-info.html#FUNCTIONS-INFO-COMMENT-TABLE')):''),"</thead>\n";$S=0;foreach($Qh
as$B=>$U){$Ui=($U!==null&&!preg_match('~table|sequence~i',$U));$u=h("Table-".$B);echo'<tr><td>'.checkbox(($Ui?"views[]":"tables[]"),$B,in_array($B,$Rh,true),"","","",$u),'<th>'.(support("table")||support("indexes")?"<a href='".h(ME)."table=".urlencode($B)."' title='".'Show structure'."' id='$u'>".h($B).'</a>':h($B));if($Ui)echo'<td colspan="6"><a href="'.h(ME)."view=".urlencode($B).'" title="'.'Alter view'.'">'.(preg_match('~materialized~i',$U)?'Materialized view':'View').'</a>','<td align="right"><a href="'.h(ME)."select=".urlencode($B).'" title="'.'Select data'.'">?</a>';else{foreach(array("Engine"=>array(),"Collation"=>array(),"Data_length"=>array("create",'Alter table'),"Index_length"=>array("indexes",'Alter indexes'),"Data_free"=>array("edit",'New item'),"Auto_increment"=>array("auto_increment=1&create",'Alter table'),"Rows"=>array("select",'Select data'),)as$y=>$_){$u=" id='$y-".h($B)."'";echo($_?"<td align='right'>".(support("table")||$y=="Rows"||(support("indexes")&&$y!="Data_length")?"<a href='".h(ME."$_[0]=").urlencode($B)."'$u title='$_[1]'>?</a>":"<span$u>?</span>"):"<td id='$y-".h($B)."'>");}$S++;}echo(support("comment")?"<td id='Comment-".h($B)."'>":""),"\n";}echo"<tr><td><th>".sprintf('%d in total',count($Qh)),"<td>".h(JUSH=="sql"?get_val("SELECT @@default_storage_engine"):""),"<td>".h(db_collation(DB,collations()));foreach(array("Data_length","Index_length","Data_free")as$y)echo"<td align='right' id='sum-$y'>";echo"\n","</table>\n","</div>\n";if(!information_schema(DB)){echo"<div class='footer'><div>\n";$Oi="<input type='submit' value='".'Vacuum'."'> ".on_help("'VACUUM'");$tf="<input type='submit' name='optimize' value='".'Optimize'."'> ".on_help(JUSH=="sql"?"'OPTIMIZE TABLE'":"'VACUUM OPTIMIZE'");echo"<fieldset><legend>".'Selected'." <span id='selected'></span></legend><div>".(JUSH=="sqlite"?$Oi."<input type='submit' name='check' value='".'Check'."'> ".on_help("'PRAGMA integrity_check'"):(JUSH=="pgsql"?$Oi.$tf:(JUSH=="sql"?"<input type='submit' value='".'Analyze'."'> ".on_help("'ANALYZE TABLE'").$tf."<input type='submit' name='check' value='".'Check'."'> ".on_help("'CHECK TABLE'")."<input type='submit' name='repair' value='".'Repair'."'> ".on_help("'REPAIR TABLE'"):"")))."<input type='submit' name='truncate' value='".'Truncate'."'> ".on_help(JUSH=="sqlite"?"'DELETE'":"'TRUNCATE".(JUSH=="pgsql"?"'":" TABLE'")).confirm()."<input type='submit' name='drop' value='".'Drop'."'>".on_help("'DROP TABLE'").confirm()."\n";$i=(support("scheme")?$b->schemas():$b->databases());if(count($i)!=1&&JUSH!="sqlite"){$j=(isset($_POST["target"])?$_POST["target"]:(support("scheme")?$_GET["ns"]:DB));echo"<p>".'Move to other database'.": ",($i?html_select("target",$i,$j):'<input name="target" value="'.h($j).'" autocapitalize="off">')," <input type='submit' name='move' value='".'Move'."'>",(support("copy")?" <input type='submit' name='copy' value='".'Copy'."'> ".checkbox("overwrite",1,$_POST["overwrite"],'overwrite'):""),"\n";}echo"<input type='hidden' name='all' value=''>",script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));".(support("table")?" selectCount('selected2', formChecked(this, /^tables\[/) || $S);":"")." }"),"<input type='hidden' name='token' value='$T'>\n","</div></fieldset>\n","</div></div>\n";}echo"</form>\n",script("tableCheck();");}echo'<p class="links"><a href="'.h(ME).'create=">'.'Create table'."</a>\n",(support("view")?'<a href="'.h(ME).'view=">'.'Create view'."</a>\n":"");if(support("routine")){echo"<h3 id='routines'>".'Routines'."</h3>\n";$Og=routines();if($Og){echo"<table class='odds'>\n",'<thead><tr><th>'.'Name'.'<td>'.'Type'.'<td>'.'Return type'."<td></thead>\n";foreach($Og
as$J){$B=($J["SPECIFIC_NAME"]==$J["ROUTINE_NAME"]?"":"&name=".urlencode($J["ROUTINE_NAME"]));echo'<tr>','<th><a href="'.h(ME.($J["ROUTINE_TYPE"]!="PROCEDURE"?'callf=':'call=').urlencode($J["SPECIFIC_NAME"]).$B).'">'.h($J["ROUTINE_NAME"]).'</a>','<td>'.h($J["ROUTINE_TYPE"]),'<td>'.h($J["DTD_IDENTIFIER"]),'<td><a href="'.h(ME.($J["ROUTINE_TYPE"]!="PROCEDURE"?'function=':'procedure=').urlencode($J["SPECIFIC_NAME"]).$B).'">'.'Alter'."</a>";}echo"</table>\n";}echo'<p class="links">'.(support("procedure")?'<a href="'.h(ME).'procedure=">'.'Create procedure'.'</a>':'').'<a href="'.h(ME).'function=">'.'Create function'."</a>\n";}if(support("sequence")){echo"<h3 id='sequences'>".'Sequences'."</h3>\n";$fh=get_vals("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = current_schema() ORDER BY sequence_name");if($fh){echo"<table class='odds'>\n","<thead><tr><th>".'Name'."</thead>\n";foreach($fh
as$X)echo"<tr><th><a href='".h(ME)."sequence=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."sequence='>".'Create sequence'."</a>\n";}if(support("type")){echo"<h3 id='user-types'>".'User types'."</h3>\n";$Mi=types();if($Mi){echo"<table class='odds'>\n","<thead><tr><th>".'Name'."</thead>\n";foreach($Mi
as$X)echo"<tr><th><a href='".h(ME)."type=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."type='>".'Create type'."</a>\n";}if(support("event")){echo"<h3 id='events'>".'Events'."</h3>\n";$K=get_rows("SHOW EVENTS");if($K){echo"<table>\n","<thead><tr><th>".'Name'."<td>".'Schedule'."<td>".'Start'."<td>".'End'."<td></thead>\n";foreach($K
as$J)echo"<tr>","<th>".h($J["Name"]),"<td>".($J["Execute at"]?'At given time'."<td>".$J["Execute at"]:'Every'." ".$J["Interval value"]." ".$J["Interval field"]."<td>$J[Starts]"),"<td>$J[Ends]",'<td><a href="'.h(ME).'event='.urlencode($J["Name"]).'">'.'Alter'.'</a>';echo"</table>\n";$_c=get_val("SELECT @@event_scheduler");if($_c&&$_c!="ON")echo"<p class='error'><code class='jush-sqlset'>event_scheduler</code>: ".h($_c)."\n";}echo'<p class="links"><a href="'.h(ME).'event=">'.'Create event'."</a>\n";}if($Qh)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}}}page_footer();