<?php
/** Adminer - Compact database management
* @link https://www.adminer.org/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
* @version 5.4.2
*/namespace
Adminer;const
VERSION="5.4.2";error_reporting(24575);set_error_handler(function($Bc,$Dc){return!!preg_match('~^Undefined (array key|offset|index)~',$Dc);},E_WARNING|E_NOTICE);$Zc=!preg_match('~^(unsafe_raw)?$~',ini_get("filter.default"));if($Zc||ini_get("filter.default_flags")){foreach(array('_GET','_POST','_COOKIE','_SERVER')as$X){$tj=filter_input_array(constant("INPUT$X"),FILTER_UNSAFE_RAW);if($tj)$$X=$tj;}}if(function_exists("mb_internal_encoding"))mb_internal_encoding("8bit");function
connection($g=null){return($g?:Db::$instance);}function
adminer(){return
Adminer::$instance;}function
driver(){return
Driver::$instance;}function
connect(){$Fb=adminer()->credentials();$J=Driver::connect($Fb[0],$Fb[1],$Fb[2]);return(is_object($J)?$J:null);}function
idf_unescape($u){if(!preg_match('~^[`\'"[]~',$u))return$u;$Ie=substr($u,-1);return
str_replace($Ie.$Ie,$Ie,substr($u,1,-1));}function
q($Q){return
connection()->quote($Q);}function
escape_string($X){return
substr(q($X),1,-1);}function
idx($va,$x,$k=null){return($va&&array_key_exists($x,$va)?$va[$x]:$k);}function
number($X){return
preg_replace('~[^0-9]+~','',$X);}function
number_type(){return'((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';}function
remove_slashes(array$Jj,$Zc=false){$J=array();foreach($Jj
as$x=>$X)$J[stripslashes($x)]=(is_array($X)?remove_slashes($X,$Zc):($Zc?$X:stripslashes($X)));return$J;}function
bracket_escape($u,$Ca=false){static$cj=array(':'=>':1',']'=>':2','['=>':3','"'=>':4');return
strtr($u,($Ca?array_flip($cj):$cj));}function
min_version($Mj,$We="",$g=null){$g=connection($g);$Vh=$g->server_info;if($We&&preg_match('~([\d.]+)-MariaDB~',$Vh,$A)){$Vh=$A[1];$Mj=$We;}return$Mj&&version_compare($Vh,$Mj)>=0;}function
charset(Db$f){return(min_version("5.5.3",0,$f)?"utf8mb4":"utf8");}function
ini_bool($je){$X=ini_get($je);return(preg_match('~^(on|true|yes)$~i',$X)||(int)$X);}function
ini_bytes($je){$X=ini_get($je);switch(strtolower(substr($X,-1))){case'g':$X=(int)$X*1024;case'm':$X=(int)$X*1024;case'k':$X=(int)$X*1024;}return$X;}function
sid(){static$J;if($J===null)$J=(SID&&!($_COOKIE&&ini_bool("session.use_cookies")));return$J;}function
set_password($Lj,$N,$V,$F){$_SESSION["pwds"][$Lj][$N][$V]=($_COOKIE["adminer_key"]&&is_string($F)?array(encrypt_string($F,$_COOKIE["adminer_key"])):$F);}function
get_password(){$J=get_session("pwds");if(is_array($J))$J=($_COOKIE["adminer_key"]?decrypt_string($J[0],$_COOKIE["adminer_key"]):false);return$J;}function
get_val($H,$m=0,$tb=null){$tb=connection($tb);$I=$tb->query($H);if(!is_object($I))return
false;$K=$I->fetch_row();return($K?$K[$m]:false);}function
get_vals($H,$d=0){$J=array();$I=connection()->query($H);if(is_object($I)){while($K=$I->fetch_row())$J[]=$K[$d];}return$J;}function
get_key_vals($H,$g=null,$Yh=true){$g=connection($g);$J=array();$I=$g->query($H);if(is_object($I)){while($K=$I->fetch_row()){if($Yh)$J[$K[0]]=$K[1];else$J[]=$K[0];}}return$J;}function
get_rows($H,$g=null,$l="<p class='error'>"){$tb=connection($g);$J=array();$I=$tb->query($H);if(is_object($I)){while($K=$I->fetch_assoc())$J[]=$K;}elseif(!$I&&!$g&&$l&&(defined('Adminer\PAGE_HEADER')||$l=="-- "))echo$l.error()."\n";return$J;}function
unique_array($K,array$w){foreach($w
as$v){if(preg_match("~PRIMARY|UNIQUE~",$v["type"])&&!$v["partial"]){$J=array();foreach($v["columns"]as$x){if(!isset($K[$x]))continue
2;$J[$x]=$K[$x];}return$J;}}}function
escape_key($x){if(preg_match('(^([\w(]+)('.str_replace("_",".*",preg_quote(idf_escape("_"))).')([ \w)]+)$)',$x,$A))return$A[1].idf_escape(idf_unescape($A[2])).$A[3];return
idf_escape($x);}function
where(array$Z,array$n=array()){$J=array();foreach((array)$Z["where"]as$x=>$X){$x=bracket_escape($x,true);$d=escape_key($x);$m=idx($n,$x,array());$Wc=$m["type"];$J[]=$d.(JUSH=="sql"&&$Wc=="json"?" = CAST(".q($X)." AS JSON)":(JUSH=="pgsql"&&preg_match('~^json~',$Wc)?"::jsonb = ".q($X)."::jsonb":(JUSH=="sql"&&is_numeric($X)&&preg_match('~\.~',$X)?" LIKE ".q($X):(JUSH=="mssql"&&strpos($Wc,"datetime")===false?" LIKE ".q(preg_replace('~[_%[]~','[\0]',$X)):" = ".unconvert_field($m,q($X))))));if(JUSH=="sql"&&preg_match('~char|text~',$Wc)&&preg_match("~[^ -@]~",$X))$J[]="$d = ".q($X)." COLLATE ".charset(connection())."_bin";}foreach((array)$Z["null"]as$x)$J[]=escape_key($x)." IS NULL";return
implode(" AND ",$J);}function
where_check($X,array$n=array()){parse_str($X,$Wa);remove_slashes(array(&$Wa));return
where($Wa,$n);}function
where_link($s,$d,$Y,$Yf="="){return"&where%5B$s%5D%5Bcol%5D=".urlencode($d)."&where%5B$s%5D%5Bop%5D=".urlencode(($Y!==null?$Yf:"IS NULL"))."&where%5B$s%5D%5Bval%5D=".urlencode($Y);}function
convert_fields(array$e,array$n,array$M=array()){$J="";foreach($e
as$x=>$X){if($M&&!in_array(idf_escape($x),$M))continue;$wa=convert_field($n[$x]);if($wa)$J
.=", $wa AS ".idf_escape($x);}return$J;}function
cookie($B,$Y,$Pe=2592000){header("Set-Cookie: $B=".rawurlencode($Y).($Pe?"; expires=".gmdate("D, d M Y H:i:s",time()+$Pe)." GMT":"")."; path=".preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]).(HTTPS?"; secure":"")."; HttpOnly; SameSite=lax",false);}function
get_settings($Bb){parse_str($_COOKIE[$Bb],$Zh);return$Zh;}function
get_setting($x,$Bb="adminer_settings",$k=null){return
idx(get_settings($Bb),$x,$k);}function
save_settings(array$Zh,$Bb="adminer_settings"){$Y=http_build_query($Zh+get_settings($Bb));cookie($Bb,$Y);$_COOKIE[$Bb]=$Y;}function
restart_session(){if(!ini_bool("session.use_cookies")&&(!function_exists('session_status')||session_status()==1))session_start();}function
stop_session($hd=false){$Cj=ini_bool("session.use_cookies");if(!$Cj||$hd){session_write_close();if($Cj&&@ini_set("session.use_cookies",'0')===false)session_start();}}function&get_session($x){return$_SESSION[$x][DRIVER][SERVER][$_GET["username"]];}function
set_session($x,$X){$_SESSION[$x][DRIVER][SERVER][$_GET["username"]]=$X;}function
auth_url($Lj,$N,$V,$j=null){$zj=remove_from_uri(implode("|",array_keys(SqlDriver::$drivers))."|username|ext|".($j!==null?"db|":"").($Lj=='mssql'||$Lj=='pgsql'?"":"ns|").session_name());preg_match('~([^?]*)\??(.*)~',$zj,$A);return"$A[1]?".(sid()?SID."&":"").($Lj!="server"||$N!=""?urlencode($Lj)."=".urlencode($N)."&":"").($_GET["ext"]?"ext=".urlencode($_GET["ext"])."&":"")."username=".urlencode($V).($j!=""?"&db=".urlencode($j):"").($A[2]?"&$A[2]":"");}function
is_ajax(){return($_SERVER["HTTP_X_REQUESTED_WITH"]=="XMLHttpRequest");}function
redirect($Se,$mf=null){if($mf!==null){restart_session();$_SESSION["messages"][preg_replace('~^[^?]*~','',($Se!==null?$Se:$_SERVER["REQUEST_URI"]))][]=$mf;}if($Se!==null){if($Se=="")$Se=".";header("Location: $Se");exit;}}function
query_redirect($H,$Se,$mf,$jh=true,$Ic=true,$Rc=false,$Pi=""){if($Ic){$oi=microtime(true);$Rc=!connection()->query($H);$Pi=format_time($oi);}$ii=($H?adminer()->messageQuery($H,$Pi,$Rc):"");if($Rc){adminer()->error
.=error().$ii.script("messagesPrint();")."<br>";return
false;}if($jh)redirect($Se,$mf.$ii);return
true;}class
Queries{static$queries=array();static$start=0;}function
queries($H){if(!Queries::$start)Queries::$start=microtime(true);Queries::$queries[]=(driver()->delimiter!=';'?$H:(preg_match('~;$~',$H)?"DELIMITER ;;\n$H;\nDELIMITER ":$H).";");return
connection()->query($H);}function
apply_queries($H,array$T,$Ec='Adminer\table'){foreach($T
as$R){if(!queries("$H ".$Ec($R)))return
false;}return
true;}function
queries_redirect($Se,$mf,$jh){$eh=implode("\n",Queries::$queries);$Pi=format_time(Queries::$start);return
query_redirect($eh,$Se,$mf,$jh,false,!$jh,$Pi);}function
format_time($oi){return
sprintf('%.3f s',max(0,microtime(true)-$oi));}function
relative_uri(){return
str_replace(":","%3a",preg_replace('~^[^?]*/([^?]*)~','\1',$_SERVER["REQUEST_URI"]));}function
remove_from_uri($vg=""){return
substr(preg_replace("~(?<=[?&])($vg".(SID?"":"|".session_name()).")=[^&]*&~",'',relative_uri()."&"),0,-1);}function
get_file($x,$Rb=false,$Xb=""){$Yc=$_FILES[$x];if(!$Yc)return
null;foreach($Yc
as$x=>$X)$Yc[$x]=(array)$X;$J='';foreach($Yc["error"]as$x=>$l){if($l)return$l;$B=$Yc["name"][$x];$Xi=$Yc["tmp_name"][$x];$yb=file_get_contents($Rb&&preg_match('~\.gz$~',$B)?"compress.zlib://$Xi":$Xi);if($Rb){$oi=substr($yb,0,3);if(function_exists("iconv")&&preg_match("~^\xFE\xFF|^\xFF\xFE~",$oi))$yb=iconv("utf-16","utf-8",$yb);elseif($oi=="\xEF\xBB\xBF")$yb=substr($yb,3);}$J
.=$yb;if($Xb)$J
.=(preg_match("($Xb\\s*\$)",$yb)?"":$Xb)."\n\n";}return$J;}function
upload_error($l){$gf=($l==UPLOAD_ERR_INI_SIZE?ini_get("upload_max_filesize"):0);return($l?'Unable to upload a file.'.($gf?" ".sprintf('Maximum allowed file size is %sB.',$gf):""):'File does not exist.');}function
repeat_pattern($Hg,$y){return
str_repeat("$Hg{0,65535}",$y/65535)."$Hg{0,".($y%65535)."}";}function
is_utf8($X){return(preg_match('~~u',$X)&&!preg_match('~[\0-\x8\xB\xC\xE-\x1F]~',$X));}function
format_number($X){return
strtr(number_format($X,0,".",','),preg_split('~~u','0123456789',-1,PREG_SPLIT_NO_EMPTY));}function
friendly_url($X){return
preg_replace('~\W~i','-',$X);}function
table_status1($R,$Sc=false){$J=table_status($R,$Sc);return($J?reset($J):array("Name"=>$R));}function
column_foreign_keys($R){$J=array();foreach(adminer()->foreignKeys($R)as$p){foreach($p["source"]as$X)$J[$X][]=$p;}return$J;}function
fields_from_edit(){$J=array();foreach((array)$_POST["field_keys"]as$x=>$X){if($X!=""){$X=bracket_escape($X);$_POST["function"][$X]=$_POST["field_funs"][$x];$_POST["fields"][$X]=$_POST["field_vals"][$x];}}foreach((array)$_POST["fields"]as$x=>$X){$B=bracket_escape($x,true);$J[$B]=array("field"=>$B,"privileges"=>array("insert"=>1,"update"=>1,"where"=>1,"order"=>1),"null"=>1,"auto_increment"=>($x==driver()->primary),);}return$J;}function
dump_headers($Pd,$xf=false){$J=adminer()->dumpHeaders($Pd,$xf);$rg=$_POST["output"];if($rg!="text")header("Content-Disposition: attachment; filename=".adminer()->dumpFilename($Pd).".$J".($rg!="file"&&preg_match('~^[0-9a-z]+$~',$rg)?".$rg":""));session_write_close();if(!ob_get_level())ob_start(null,4096);ob_flush();flush();return$J;}function
dump_csv(array$K){$lj=$_POST["format"]=="tsv";foreach($K
as$x=>$X){if(preg_match('~["\n]|^0[^.]|\.\d*0$|'.($lj?'\t':'[,;]|^$').'~',$X))$K[$x]='"'.str_replace('"','""',$X).'"';}echo
implode(($_POST["format"]=="csv"?",":($lj?"\t":";")),$K)."\r\n";}function
apply_sql_function($r,$d){return($r?($r=="unixepoch"?"DATETIME($d, '$r')":($r=="count distinct"?"COUNT(DISTINCT ":strtoupper("$r("))."$d)"):$d);}function
get_temp_dir(){$J=ini_get("upload_tmp_dir");if(!$J){if(function_exists('sys_get_temp_dir'))$J=sys_get_temp_dir();else{$o=@tempnam("","");if(!$o)return'';$J=dirname($o);unlink($o);}}return$J;}function
file_open_lock($o){if(is_link($o))return;$q=@fopen($o,"c+");if(!$q)return;@chmod($o,0660);if(!flock($q,LOCK_EX)){fclose($q);return;}return$q;}function
file_write_unlock($q,$Lb){rewind($q);fwrite($q,$Lb);ftruncate($q,strlen($Lb));file_unlock($q);}function
file_unlock($q){flock($q,LOCK_UN);fclose($q);}function
first(array$va){return
reset($va);}function
password_file($h){$o=get_temp_dir()."/adminer.key";if(!$h&&!file_exists($o))return'';$q=file_open_lock($o);if(!$q)return'';$J=stream_get_contents($q);if(!$J){$J=rand_string();file_write_unlock($q,$J);}else
file_unlock($q);return$J;}function
rand_string(){return
md5(uniqid(strval(mt_rand()),true));}function
select_value($X,$_,array$m,$Oi){if(is_array($X)){$J="";if(array_filter($X,'is_array')==array_values($X)){$Ce=array();foreach($X
as$W)$Ce+=array_fill_keys(array_keys($W),null);foreach(array_keys($Ce)as$Ae)$J
.="<th>".h($Ae);foreach($X
as$W){$J
.="<tr>";foreach(array_merge($Ce,$W)as$Gj)$J
.="<td>".select_value($Gj,$_,$m,$Oi);}}else{foreach($X
as$Ae=>$W)$J
.="<tr>".($X!=array_values($X)?"<th>".h($Ae):"")."<td>".select_value($W,$_,$m,$Oi);}return"<table>$J</table>";}if(!$_)$_=adminer()->selectLink($X,$m);if($_===null){if(is_mail($X))$_="mailto:$X";if(is_url($X))$_=$X;}$J=adminer()->editVal(driver()->value($X,$m),$m);if($J!==null){if(!is_utf8($J))$J="\0";elseif($Oi!=""&&is_shortable($m))$J=shorten_utf8($J,max(0,+$Oi));else$J=h($J);}return
adminer()->selectVal($J,$_,$m,$X);}function
is_blob(array$m){return
preg_match('~blob|bytea|raw|file~',$m["type"])&&!in_array($m["type"],idx(driver()->structuredTypes(),'User types',array()));}function
is_mail($sc){$xa='[-a-z0-9!#$%&\'*+/=?^_`{|}~]';$fc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';$Hg="$xa+(\\.$xa+)*@($fc?\\.)+$fc";return
is_string($sc)&&preg_match("(^$Hg(,\\s*$Hg)*\$)i",$sc);}function
is_url($Q){$fc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';return
preg_match("~^((https?):)?//($fc?\\.)+$fc(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i",$Q);}function
is_shortable(array$m){return!preg_match('~'.number_type().'|date|time|year~',$m["type"]);}function
host_port($N){return(preg_match('~^(\[(.+)]|([^:]+)):([^:]+)$~',$N,$A)?array($A[2].$A[3],$A[4]):array($N,''));}function
count_rows($R,array$Z,$te,array$vd){$H=" FROM ".table($R).($Z?" WHERE ".implode(" AND ",$Z):"");return($te&&(JUSH=="sql"||count($vd)==1)?"SELECT COUNT(DISTINCT ".implode(", ",$vd).")$H":"SELECT COUNT(*)".($te?" FROM (SELECT 1$H GROUP BY ".implode(", ",$vd).") x":$H));}function
slow_query($H){$j=adminer()->database();$Qi=adminer()->queryTimeout();$di=driver()->slowQuery($H,$Qi);$g=null;if(!$di&&support("kill")){$g=connect();if($g&&($j==""||$g->select_db($j))){$De=get_val(connection_id(),0,$g);echo
script("const timeout = setTimeout(() => { ajax('".js_escape(ME)."script=kill', function () {}, 'kill=$De&token=".get_token()."'); }, 1000 * $Qi);");}}ob_flush();flush();$J=@get_key_vals(($di?:$H),$g,false);if($g){echo
script("clearTimeout(timeout);");ob_flush();flush();}return$J;}function
get_token(){$hh=rand(1,1e6);return($hh^$_SESSION["token"]).":$hh";}function
verify_token(){list($Yi,$hh)=explode(":",$_POST["token"]);return($hh^$_SESSION["token"])==$Yi;}function
lzw_decompress($Ia){$cc=256;$Ja=8;$gb=array();$uh=0;$vh=0;for($s=0;$s<strlen($Ia);$s++){$uh=($uh<<8)+ord($Ia[$s]);$vh+=8;if($vh>=$Ja){$vh-=$Ja;$gb[]=$uh>>$vh;$uh&=(1<<$vh)-1;$cc++;if($cc>>$Ja)$Ja++;}}$bc=range("\0","\xFF");$J="";$Vj="";foreach($gb
as$s=>$fb){$rc=$bc[$fb];if(!isset($rc))$rc=$Vj.$Vj[0];$J
.=$rc;if($s)$bc[]=$Vj.$rc[0];$Vj=$rc;}return$J;}function
script($fi,$bj="\n"){return"<script".nonce().">$fi</script>$bj";}function
script_src($_j,$Ub=false){return"<script src='".h($_j)."'".nonce().($Ub?" defer":"")."></script>\n";}function
nonce(){return' nonce="'.get_nonce().'"';}function
input_hidden($B,$Y=""){return"<input type='hidden' name='".h($B)."' value='".h($Y)."'>\n";}function
input_token(){return
input_hidden("token",get_token());}function
target_blank(){return' target="_blank" rel="noreferrer noopener"';}function
h($Q){return
str_replace("\0","&#0;",htmlspecialchars($Q,ENT_QUOTES,'utf-8'));}function
nl_br($Q){return
str_replace("\n","<br>",$Q);}function
checkbox($B,$Y,$Za,$Fe="",$Xf="",$db="",$He=""){$J="<input type='checkbox' name='$B' value='".h($Y)."'".($Za?" checked":"").($He?" aria-labelledby='$He'":"").">".($Xf?script("qsl('input').onclick = function () { $Xf };",""):"");return($Fe!=""||$db?"<label".($db?" class='$db'":"").">$J".h($Fe)."</label>":$J);}function
optionlist($cg,$Nh=null,$Dj=false){$J="";foreach($cg
as$Ae=>$W){$dg=array($Ae=>$W);if(is_array($W)){$J
.='<optgroup label="'.h($Ae).'">';$dg=$W;}foreach($dg
as$x=>$X)$J
.='<option'.($Dj||is_string($x)?' value="'.h($x).'"':'').($Nh!==null&&($Dj||is_string($x)?(string)$x:$X)===$Nh?' selected':'').'>'.h($X);if(is_array($W))$J
.='</optgroup>';}return$J;}function
html_select($B,array$cg,$Y="",$Wf="",$He=""){static$Fe=0;$Ge="";if(!$He&&substr($cg[""],0,1)=="("){$Fe++;$He="label-$Fe";$Ge="<option value='' id='$He'>".h($cg[""]);unset($cg[""]);}return"<select name='".h($B)."'".($He?" aria-labelledby='$He'":"").">".$Ge.optionlist($cg,$Y)."</select>".($Wf?script("qsl('select').onchange = function () { $Wf };",""):"");}function
html_radios($B,array$cg,$Y="",$Rh=""){$J="";foreach($cg
as$x=>$X)$J
.="<label><input type='radio' name='".h($B)."' value='".h($x)."'".($x==$Y?" checked":"").">".h($X)."</label>$Rh";return$J;}function
confirm($mf="",$Oh="qsl('input')"){return
script("$Oh.onclick = () => confirm('".($mf?js_escape($mf):'Are you sure?')."');","");}function
print_fieldset($t,$Ne,$Pj=false){echo"<fieldset><legend>","<a href='#fieldset-$t'>$Ne</a>",script("qsl('a').onclick = partial(toggle, 'fieldset-$t');",""),"</legend>","<div id='fieldset-$t'".($Pj?"":" class='hidden'").">\n";}function
bold($La,$db=""){return($La?" class='active $db'":($db?" class='$db'":""));}function
js_escape($Q){return
addcslashes($Q,"\r\n'\\/");}function
pagination($D,$Ib){return" ".($D==$Ib?$D+1:'<a href="'.h(remove_from_uri("page").($D?"&page=$D".($_GET["next"]?"&next=".urlencode($_GET["next"]):""):"")).'">'.($D+1)."</a>");}function
hidden_fields(array$bh,array$Td=array(),$Tg=''){$J=false;foreach($bh
as$x=>$X){if(!in_array($x,$Td)){if(is_array($X))hidden_fields($X,array(),$x);else{$J=true;echo
input_hidden(($Tg?$Tg."[$x]":$x),$X);}}}return$J;}function
hidden_fields_get(){echo(sid()?input_hidden(session_name(),session_id()):''),(SERVER!==null?input_hidden(DRIVER,SERVER):""),input_hidden("username",$_GET["username"]);}function
file_input($le){$bf="max_file_uploads";$cf=ini_get($bf);$xj="upload_max_filesize";$yj=ini_get($xj);return(ini_bool("file_uploads")?$le.script("qsl('input[type=\"file\"]').onchange = partialArg(fileChange, "."$cf, '".sprintf('Increase %s.',"$bf = $cf")."', ".ini_bytes("upload_max_filesize").", '".sprintf('Increase %s.',"$xj = $yj")."')"):'File uploads are disabled.');}function
enum_input($U,$ya,array$m,$Y,$vc=""){preg_match_all("~'((?:[^']|'')*)'~",$m["length"],$Ze);$Tg=($m["type"]=="enum"?"val-":"");$Za=(is_array($Y)?in_array("null",$Y):$Y===null);$J=($m["null"]&&$Tg?"<label><input type='$U'$ya value='null'".($Za?" checked":"")."><i>$vc</i></label>":"");foreach($Ze[1]as$X){$X=stripcslashes(str_replace("''","'",$X));$Za=(is_array($Y)?in_array($Tg.$X,$Y):$Y===$X);$J
.=" <label><input type='$U'$ya value='".h($Tg.$X)."'".($Za?' checked':'').'>'.h(adminer()->editVal($X,$m)).'</label>';}return$J;}function
input(array$m,$Y,$r,$Ba=false){$B=h(bracket_escape($m["field"]));echo"<td class='function'>";if(is_array($Y)&&!$r)$r="json";$ze=($r=="json"||preg_match('~^jsonb?$~',$m["type"]));if($ze&&$Y!=''&&(JUSH!="pgsql"||$m["type"]!="json"))$Y=json_encode(is_array($Y)?$Y:json_decode($Y),128|64|256);$th=(JUSH=="mssql"&&$m["auto_increment"]);if($th&&!$_POST["save"])$r=null;$qd=(isset($_GET["select"])||$th?array("orig"=>'original'):array())+adminer()->editFunctions($m);$Ac=driver()->enumLength($m);if($Ac){$m["type"]="enum";$m["length"]=$Ac;}$ya=" name='fields[$B]".($m["type"]=="enum"||$m["type"]=="set"?"[]":"")."'".($Ba?" autofocus":"");echo
driver()->unconvertFunction($m)." ";$R=$_GET["edit"]?:$_GET["select"];if($m["type"]=="enum")echo
h($qd[""])."<td>".adminer()->editInput($R,$m,$ya,$Y);else{$Cd=(in_array($r,$qd)||isset($qd[$r]));echo(count($qd)>1?"<select name='function[$B]'>".optionlist($qd,$r===null||$Cd?$r:"")."</select>".on_help("event.target.value.replace(/^SQL\$/, '')",1).script("qsl('select').onchange = functionChange;",""):h(reset($qd))).'<td>';$le=adminer()->editInput($R,$m,$ya,$Y);if($le!="")echo$le;elseif(preg_match('~bool~',$m["type"]))echo"<input type='hidden'$ya value='0'>"."<input type='checkbox'".(preg_match('~^(1|t|true|y|yes|on)$~i',$Y)?" checked='checked'":"")."$ya value='1'>";elseif($m["type"]=="set")echo
enum_input("checkbox",$ya,$m,(is_string($Y)?explode(",",$Y):$Y));elseif(is_blob($m)&&ini_bool("file_uploads"))echo"<input type='file' name='fields-$B'>";elseif($ze)echo"<textarea$ya cols='50' rows='12' class='jush-js'>".h($Y).'</textarea>';elseif(($Mi=preg_match('~text|lob|memo~i',$m["type"]))||preg_match("~\n~",$Y)){if($Mi&&JUSH!="sqlite")$ya
.=" cols='50' rows='12'";else{$L=min(12,substr_count($Y,"\n")+1);$ya
.=" cols='30' rows='$L'";}echo"<textarea$ya>".h($Y).'</textarea>';}else{$nj=driver()->types();$if=(!preg_match('~int~',$m["type"])&&preg_match('~^(\d+)(,(\d+))?$~',$m["length"],$A)?((preg_match("~binary~",$m["type"])?2:1)*$A[1]+($A[3]?1:0)+($A[2]&&!$m["unsigned"]?1:0)):($nj[$m["type"]]?$nj[$m["type"]]+($m["unsigned"]?0:1):0));if(JUSH=='sql'&&min_version(5.6)&&preg_match('~time~',$m["type"]))$if+=7;echo"<input".((!$Cd||$r==="")&&preg_match('~(?<!o)int(?!er)~',$m["type"])&&!preg_match('~\[\]~',$m["full_type"])?" type='number'":"")." value='".h($Y)."'".($if?" data-maxlength='$if'":"").(preg_match('~char|binary~',$m["type"])&&$if>20?" size='".($if>99?60:40)."'":"")."$ya>";}echo
adminer()->editHint($R,$m,$Y);$ad=0;foreach($qd
as$x=>$X){if($x===""||!$X)break;$ad++;}if($ad&&count($qd)>1)echo
script("qsl('td').oninput = partial(skipOriginal, $ad);");}}function
process_input(array$m){$u=bracket_escape($m["field"]);$r=idx($_POST["function"],$u);$Y=idx($_POST["fields"],$u);if($Y===null)return
false;if($m["type"]=="enum"||driver()->enumLength($m)){$Y=idx($Y,0);if($Y=="orig"||!$Y)return
false;if($Y=="null")return"NULL";$Y=substr($Y,4);}if($m["auto_increment"]&&$Y=="")return
null;if($r=="orig")return(preg_match('~^CURRENT_TIMESTAMP~i',$m["on_update"])?idf_escape($m["field"]):false);if($r=="NULL")return"NULL";if($m["type"]=="set")$Y=implode(",",(array)$Y);if($r=="json"){$r="";$Y=json_decode($Y,true);if(!is_array($Y))return
false;return$Y;}if(is_blob($m)&&ini_bool("file_uploads")){$Yc=get_file("fields-$u");if(!is_string($Yc))return
false;return
driver()->quoteBinary($Yc);}return
adminer()->processInput($m,$Y,$r);}function
search_tables(){$_GET["where"][0]["val"]=$_POST["query"];$Qh="<ul>\n";foreach(table_status('',true)as$R=>$S){$B=adminer()->tableName($S);if(isset($S["Engine"])&&$B!=""&&(!$_POST["tables"]||in_array($R,$_POST["tables"]))){$I=connection()->query("SELECT".limit("1 FROM ".table($R)," WHERE ".implode(" AND ",adminer()->selectSearchProcess(fields($R),array())),1));if(!$I||$I->fetch_row()){$Xg="<a href='".h(ME."select=".urlencode($R)."&where[0][op]=".urlencode($_GET["where"][0]["op"])."&where[0][val]=".urlencode($_GET["where"][0]["val"]))."'>$B</a>";echo"$Qh<li>".($I?$Xg:"<p class='error'>$Xg: ".error())."\n";$Qh="";}}}echo($Qh?"<p class='message'>".'No tables.':"</ul>")."\n";}function
on_help($mb,$bi=0){return
script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $mb, $bi) }, onmouseout: helpMouseout});","");}function
edit_form($R,array$n,$K,$wj,$l=''){$_i=adminer()->tableName(table_status1($R,true));page_header(($wj?'Edit':'Insert'),$l,array("select"=>array($R,$_i)),$_i);adminer()->editRowPrint($R,$n,$K,$wj);if($K===false){echo"<p class='error'>".'No rows.'."\n";return;}echo"<form action='' method='post' enctype='multipart/form-data' id='form'>\n";$pc=false;if(!$n)echo"<p class='error'>".'You have no privileges to update this table.'."\n";else{echo"<table class='layout'>".script("qsl('table').onkeydown = editingKeydown;");$Ba=!$_POST;foreach($n
as$B=>$m){echo"<tr><th>".adminer()->fieldName($m);$k=idx($_GET["set"],bracket_escape($B));if($k===null){$k=$m["default"];if($m["type"]=="bit"&&preg_match("~^b'([01]*)'\$~",$k,$qh))$k=$qh[1];if(JUSH=="sql"&&preg_match('~binary~',$m["type"]))$k=bin2hex($k);}$Y=($K!==null?($K[$B]!=""&&JUSH=="sql"&&preg_match("~enum|set~",$m["type"])&&is_array($K[$B])?implode(",",$K[$B]):(is_bool($K[$B])?+$K[$B]:$K[$B])):(!$wj&&$m["auto_increment"]?"":(isset($_GET["select"])?false:$k)));if(!$_POST["save"]&&is_string($Y))$Y=adminer()->editVal($Y,$m);if(($wj&&!isset($m["privileges"]["update"]))||$m["generated"])echo"<td class='function'><td>".select_value($Y,'',$m,null);else{$pc=true;$r=($_POST["save"]?idx($_POST["function"],$B,""):($wj&&preg_match('~^CURRENT_TIMESTAMP~i',$m["on_update"])?"now":($Y===false?null:($Y!==null?'':'NULL'))));if(!$_POST&&!$wj&&$Y==$m["default"]&&preg_match('~^[\w.]+\(~',$Y))$r="SQL";if(preg_match("~time~",$m["type"])&&preg_match('~^CURRENT_TIMESTAMP~i',$Y)){$Y="";$r="now";}if($m["type"]=="uuid"&&$Y=="uuid()"){$Y="";$r="uuid";}if($Ba!==false)$Ba=($m["auto_increment"]||$r=="now"||$r=="uuid"?null:true);input($m,$Y,$r,$Ba);if($Ba)$Ba=false;}echo"\n";}if(!support("table")&&!fields($R))echo"<tr>"."<th><input name='field_keys[]'>".script("qsl('input').oninput = fieldChange;")."<td class='function'>".html_select("field_funs[]",adminer()->editFunctions(array("null"=>isset($_GET["select"]))))."<td><input name='field_vals[]'>"."\n";echo"</table>\n";}echo"<p>\n";if($pc){echo"<input type='submit' value='".'Save'."'>\n";if(!isset($_GET["select"]))echo"<input type='submit' name='insert' value='".($wj?'Save and continue edit':'Save and insert next')."' title='Ctrl+Shift+Enter'>\n",($wj?script("qsl('input').onclick = function () { return !ajaxForm(this.form, '".'Saving'."â€¦', this); };"):"");}echo($wj?"<input type='submit' name='delete' value='".'Delete'."'>".confirm()."\n":"");if(isset($_GET["select"]))hidden_fields(array("check"=>(array)$_POST["check"],"clone"=>$_POST["clone"],"all"=>$_POST["all"]));echo
input_hidden("referer",(isset($_POST["referer"])?$_POST["referer"]:$_SERVER["HTTP_REFERER"])),input_hidden("save",1),input_token(),"</form>\n";}function
shorten_utf8($Q,$y=80,$ui=""){if(!preg_match("(^(".repeat_pattern("[\t\r\n -\x{10FFFF}]",$y).")($)?)u",$Q,$A))preg_match("(^(".repeat_pattern("[\t\r\n -~]",$y).")($)?)",$Q,$A);return
h($A[1]).$ui.(isset($A[2])?"":"<i>â€¦</i>");}function
icon($Od,$B,$Nd,$Si){return"<button type='submit' name='$B' title='".h($Si)."' class='icon icon-$Od'><span>$Nd</span></button>";}if(isset($_GET["file"])){if(substr(VERSION,-4)!='-dev'){if($_SERVER["HTTP_IF_MODIFIED_SINCE"]){header("HTTP/1.1 304 Not Modified");exit;}header("Expires: ".gmdate("D, d M Y H:i:s",time()+365*24*60*60)." GMT");header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");header("Cache-Control: immutable");}@ini_set("zlib.output_compression",'1');if($_GET["file"]=="default.css"){header("Content-Type: text/css; charset=utf-8");echo
lzw_decompress("h:M‡±h´ÄgÌĞ±ÜÍŒ\"PÑiÒm„™cQCa¤é	2Ã³éˆŞd<Ìfóa¼ä:;NBˆqœR;1Lf³9ÈŞu7&)¤l;3ÍÑñÈÀJ/‹†CQXÊr2MÆaäi0›„ƒ)°ìe:LuÃhæ-9ÕÍ23lÈÎi7†³màZw4™†Ñš<-•ÒÌ´¹!†U,—ŒFÃ©”vt2‘S,¬äa´Ò‡FêVXúa˜Nqã)“-—ÖÎÇœhê:n5û9ÈY¨;jµ”-Ş÷_‘9krùœÙ“;.ĞtTqËo¦0‹³­Öò®{íóyùı\rçHnìGS™ Zh²œ;¼i^ÀuxøWÎ’C@Äö¤©k€Ò=¡Ğb©Ëâì¼/AØà0¤+Â(ÚÁ°lÂÉÂ\\ê Ãxè:\rèÀb8\0æ–0!\0FÆ\nB”Íã(Ò3 \r\\ºÛêÈ„a¼„œ'Iâ|ê(iš\n‹\r©¸ú4Oüg@4ÁC’î¼†º@@†!ÄQB°İ	Â°¸c¤ÊÂ¯Äq,\r1EhèÈ&2PZ‡¦ğiGûH9G’\"v§ê’¢££¤œ4r”ÆñÍDĞR¤\n†pJë-A“|/.¯cê“Du·£¤ö:,˜Ê=°¢RÅ]U5¥mVÁkÍLLQ@-\\ª¦ËŒ@9Áã%ÚSrÁÎñMPDãÂIa\rƒ(YY\\ã@XõpÃê:£p÷lLC —Åñè¸ƒÍÊO,\rÆ2]7œ?m06ä»pÜTÑÍaÒ¥Cœ;_Ë—ÑyÈ´d‘>¨²bnğ…«n¼Ü£3÷X¾€ö8\rí[Ë€-)Ûi>V[Yãy&L3¯#ÌX|Õ	†X \\Ã¹`ËC§ç˜å#ÑÙHÉÌ2Ê2.# ö‹Zƒ`Â<¾ãs®·¹ªÃ’£º\0uœhÖ¾—¥M²Í_\niZeO/CÓ’_†`3İòğ1>‹=Ğk3£…‰R/;ä/dÛÜ\0ú‹ŒãŞÚµmùúò¾¤7/«ÖAÎXƒÂÿ„°“Ãq.½sáL£ı— :\$ÉF¢—¸ª¾£‚w‰8óß¾~«HÔj…­\"¨¼œ•¹Ô³7gSõä±âFLéÎ¯çQò_¤’O'WØö]c=ı5¾1X~7;˜™iş´\rí*\n’¨JS1Z¦™ø£ØÆßÍcå‚tœüAÔVí86fĞdÃy;Y]©õzIÀp¡Ñû§ğc‰3®YË]}Â˜@¡\$.+”1¶'>ZÃcpdàéÒGLæá„#kô8PzœYÒAuÏvİ]s9‰ÑØ_AqÎÁ„:†ÆÅ\nK€hB¼;­ÖŠXbAHq,âCIÉ`†‚çj¹S[ËŒ¶1ÆVÓrŠñÔ;¶pŞBÃÛ)#é‰;4ÌHñÒ/*Õ<Â3L Á;lfª\n¶s\$K`Ğ}ÆôÕ”£¾7ƒjx`d–%j] ¸4œ—Y¤–HbY ØJ`¤GG ’.ÅÜK‚òfÊI©)2ÂŠMfÖ¸İX‰RC‰¸Ì±V,©ÛÑ~g\0è‚àg6İ:õ[jí1H½:AlIq©u3\"™êæq¤æ|8<9s'ãQ]JÊ|Ğ\0Â`p ³îƒ«‰jf„OÆbĞÉú¬¨q¬¢\$é©²Ã1J¹>RœH(Ç”q\n#rŠ’à@e(yóVJµ0¡QÒˆ£òˆ6†Pæ[C:·Gä¼‘ İ4©‘Ò^ÓğÃPZŠµ\\´‘è(\nÖ)š~¦´°9R%×Sj·{‰7ä0Ş_šÇs	z|8ÅHê	\"@Ü#9DVLÅ\$H5ÔWJ@—…z®a¿J Ä^	‘)®2\nQvÀÔ]ëÇ”“Õ‡ÊQ’p.±Ëµâ»ë&hÌˆ–¡°2€dM1²ÀŒ#[[kf,»Õ¸Î†º¤Wqğ'f¶Lkgn­²¶·6ÖŞG¦;e„×”E¦ÒCVYŠ¼«{\0è ™DŠ5’Råx\"®ºëÁh\"êİŸ7òWÔ,ÅˆŠŞu¥c31Cxp<«¶™ØIf¯”’]±Ñ±^ÔÁ{åÁ¡İë/ÅüHó&s’Ïiº9\$Ö’b‡0âÙI½ äK\0]…¡ÉIDG}ŒEDì›¼V¥âN—Š¢°Ã½´m¡Q3“1KT¦½©•3»zq•|†Éã´#¤!–\"š	Òƒk×/pİĞŞhy-¡ø.Ç!¹ õå0dñç’ùmäÙKó—±ö±˜~«‡au0´>\$¨:‡\$VğŒÅÄM—ÉfÙ¨k6„™:‘‚öüÁ3L@¶µâ—ãdŒ…é1¸øĞì×˜zlg·„Ö©òi²”XŠßÅ9è7â<×­#a}sŠø«\0\\mÃZíÃXËQÚ'n.à9‰ŠKC9?lX–qê¹—\$MÏ2“Fq—»ĞKŞB:™¤Èêbo¤#î”KºXnM½±Ãz€«È¤\r€=°öfmÅ%fiÓ.q´˜­»‹Ş;-7x˜°ê(@#Ùà9‚ÀF¹)ó/M-Ù6®.±VÃ^º*Æg\n‹ƒ!\$œ(7¥µÚGxwäá¦Dš§®¿Wşbäa“{‡³¼ƒ1-Œ²Ô˜¾GÂÃw\ráöÜ9Ñš µ(â:¢Àï›ó'Ï%¿?ä¼0Î†­µ×)è™t­jHVŠ8}f\$Ì½f^wõlKêšl=í1ZëZ©áEiÎìög´¤±—Öº1¡ŞÛX”ßâØ«‚ØâbäÛeÌ&—‘†,2r»½ôŒk>§äŞ²O{Í-µAŞî]³mMDüÈŞ>G;ûĞ—ŒgêˆùQo: „0¾.å7lL“×©l˜š¢|:nDæúíƒ‰ˆÀ-ÑK‹±Úõ*NYš3†xèš.d§t>êĞà¾Å)\$•\$±€Œ9ÛBëÙæ°eeR¶Gwišr[62Ç±9ßXk0Ì±¡ˆ5˜è^¯ìPÏìOÊ>êC `ÇãÄXOk7¯\0KäÎlêÎèx;Ï4Ú8ßLüÌ\$09*–9 ÜhNŠıÍíF>\0ØrPQo<Éç	¤\\Fôª²d'Îö‡Lå:‹bú—ğ.4,2Àô¢ğ9Àğ@ÂHnbì-¼ôÅ #Ë2Ë`Z§%.ª‚Lê\r€P¯P\"ê ^.âFø€ÊÀh€¤\0Øà€Ø\r\0Šà‚\n`‚	 Š š n o\0‚à”\r ´\r ¢1` „0ûú	‘ğò „	1\n ’G\0’`à V\0 \n€¢\r\0¤\n‚zÀÌ\n@ \0Ü\r Š\nÀ	 Ş\n@Ê@à\r\0ğ' ëÀÌ @Æ àz°ª1\"*Œ…åPÉ°¿#Ap¹ĞĞH‚ã\rİåíõı‘\rñ%ñ+Q7±>\rCqKà¢\r@ğ@†¾ ì‹À°é~\r ğ\0î\r d@î€ğ3à­Q‰Ñ‘Q˜Çœ‚£Ù\n ÉpËÃ­Åh>ñ³âç×\r°ß0ç°ï1Íñqqqñ#qãÑéÑ81<\rõQIÑQ  €Úàl@ò'‘à¬àÂÂ:	€° ’\0¨ ¨	 æÀ‚€ç#iE\nÏ\"f.‹Q³\$ÁRQ²U\r Ã²]cri²m2sòwÒ}1(2…‰\0Õ)1ùÀ’ñz ÖQ\\\rÀÜ€˜\ràŒÀÈ@\n h\n€è ªò@†\0Ì`¨	ÀÆ@±'‘“qš)@Z€.RG²íqµ%pÕÒ_2e€‚	Q&	òo“—’x1ß'ñå1‘é1ï€’Ó%€fÀÏ`ª\0¤ Îf€\0j\n f`â	 ®\n`´@˜\$n=`†\0ÈÒŒ nIĞ=\0Ğ@Âd'ÌöÄàÌä‘8¯.êƒ/2Y8Òı@‡€—q.	42à ôE‘á(ç’Š\rô:\n6	H*@	ˆ`\n ¤ è	àòlí’ÕŒ’\rì–É è\r¯HlŒh‰Šø\0Ø ìí(÷dÄî4’”–¡\0]IL^\\¥×K\0\\¥£}Jô¨C\nÁ´œ}ªØØÉEKÙIıB>ÚÍˆ‹„IJt–ìdfhtœí/Fb…—…xYEíéM4Âoj\"òmİN@ŞtŠØ®Ø~d»J2U4ÁI`\\Aê‚èµ„uQôöÅU.uh‚€\\ òàÍM¯×Q•Ø‰\"G!TnæMt·P­äµX#õ]Qõ-KëTh\$“c’»CD‹ÆŠ €§¢-ÃIb´O`Pv§^W@tdSS0ËS”Ü™Õ<¶)gMhF<\rj*\$4´®' õ\rÀÒHÊ[íÈÜÉªõÅW-éFh:,½µ\\/­„¿É¾ªíJ¦‚^ODøšª¬Ùj'Â\rèTÒ-&[êÖùDÄª®ÃNÃìÍÛ[ôşE B\"æ`ø´eujî¬ü™­_ñõ\rª`İÀhöF\r¶JVƒ–%Ú!MZlP^™Ï:Úo>Ö¯XïöxCöñ):mei/\n¯Ëé8˜I2\rp2îö†ï)ÆùoC[àmViugµñh6Zf´è˜Ö|DUw\\çWÔèC4â5UÕ\r–ÕW6§mµzØ–Âù•hì”ñcïÖK¶og6Nøõd6ãPÖ`òVeo•<%Öt?uf§!YU˜,+îÍe.W%×\\†ÄÌ\0v8ì­–X¯ÒınØìUBcfv@i·Nö=uÕ;NlKqwqKQ!vÕ[\\7TO0 ë{yj. `È¡iøòz§%©b€â¦H®\"\"\"hí¸_\$b á|jä\0f\"tÄ®*ŠçÂ}ä\$¬ZØW¼\"@r¯‚(\r`Ê îC÷ÔÈ‚(0&†.`ÒNk9B\n&#(Æjâ„@ä‚¯ò«fX^÷Ö®Šü £@²`ÒI-}C0£â\n–B}B5Ó]|Ã§øW{×Ê©b÷|àÑ}\"…—Ë…Â)}àÂøgƒ‚ÀÅˆõ,=cÚª‰«{¥î&ìb£PŠÆÉ/‰CÜ \0ÚâV\r¥×ŠÅí‹ˆ=¸¿‹BN\\ØÂ=ÃK‹¨rí\$xÕŒWÑŒ˜Á‹Øç8Î©døñ‹Ø÷êH'¦Î¶8×}â=Øæ=\0ïøØ\0¾»å]‰«ˆ\n†Ûô(7Ôz‡y+˜å¨Ş\rù`ÊDYgÅ‰„ı~Ä×|k3ØÚ ùE9C‘™CƒÑ‘™e‘Œ@ùw,@5™|fxÂà¿–¹˜ÙJlY%•xE•·ó•Ù=‘Aj@¾O¹G¹±™ Ùšâe”àæçÄ—˜Ö–L\nû%şÁ/»šy˜`ßœ™?‘Ùo›ya‘Ùe©‘Äûœî`×ÊtG·³ ¾ŒH¼J5×ƒMšYš(¸œ6_ehø´§ùtDz&–x½„9jZ*š/ŸK¢Ù£:,j¤5‚U¡ˆ§“º>Ç¡¤Âß“˜Ÿš\"ée£ºq£×£Y‘¤š<¶ZÚu¨Z{¢Ø!‘še§zV º%Ù,|m·¡xS¦wã¦º=Ú#‘€ğ @¿¢:š¸€X	“º³¤+ï‹Ú»›¸C¨®:5¦Zt \0èrZ©­¿„Š!¬Úá¢Ú¨ú=¤{›Â®ø 2¹¥¬ôñ°ÂÃ±ùÙÃ¬yÀúÇ¤ÿŒX÷²ºàfÃ°ø%«óc’sºï¬x+8æÄA{/Ÿ ¿µ›U–9‰¶y˜#1µ¹«–yë¶,.5›uÛk· àûe·»_»‹¸ù¶›y¹¹\rª~Âûƒ£{Ÿ [¥¹š°Z:\0Æ\\»«¹8î3û¾·mÒA“9'‡8‚‡:i¡ÙØ|Y³‘Ûå/+˜ó»9¾ùŠR ËºÚÃ—X7¾Ïƒ:”\rŠá¡	«ƒ+¼^»€î«¬;M¬»AŠÎ«0Y®Ğ*2<7›Y¿½—¨\$ê»û¸E»ºœSŒ[õZ»ÛÁÅ£Ü5vp\\®iÄØòFür1Å:Â\">Â`É›Wº›Ï”<u·»µ¶ïÇÄ§È¬§xó¢<“°«Œ\\›–Ö¥Êü˜f¹¼‘Æ™Û™`eÂjâ?äec³‹Ğ(Ğì×<Úã£‚fCZÂSDv£üÎ\rÃò#Ù¦áœU ");}elseif($_GET["file"]=="dark.css"){header("Content-Type: text/css; charset=utf-8");echo
lzw_decompress("h:M‡±h´ÄgÆÈh0ÁLĞàd91¢S!¤Û	Fƒ!°æ\"-6N‘€ÄbdGgÓ°Â:;Nr£)öc7›\rç(HØb81˜†s9¼¤Ük\rçc)Êm8O•VA¡Âc1”c34Of*’ª- P¨‚1©”r41Ùî6˜Ìd2ŒÖ•®Ûo½ÜÌ#3—‰–BÇf#	ŒÖg9Î¦êØŒfc\rÇI™ĞÂb6E‡C&¬Ğ,buÄêm7aVã•ÂÁs²#m!ôèhµårùœŞv\\3\rL:SA”Âdk5İnÇ·×ìšıÊaF†¸3é˜Òe6fS¦ëy¾óør!ÇLú -ÎK,Ì3Lâ@º“J¶ƒË²¢*J äìµ£¤‚»	¸ğ—¹Ášb©cèà9­ˆê9¹¤æ@ÏÔè¿ÃHÜ8£ \\·Ãê6>«`ğÅ¸Ş;‡Aˆà<T™'¨p&q´qEˆê4Å\rl­…ÃhÂ<5#pÏÈR Ñ#I„İ%„êfBIØŞÜ²”¨>…Ê«29<«åCîj2¯î»¦¶7j¬“8jÒìc(nÔÄç?(a\0Å@”5*3:Î´æ6Œ£˜æ0Œã-àAÀlL›•PÆ4@ÊÉ°ê\$¡H¥4 n31¶æ1Ítò0®áÍ™9ŒƒéWO!¨r¼ÚÔØÜÛÕèHÈ†£Ã9ŒQ°Â96èF±¬«<ø7°\rœ-xC\n Üã®@Òø…ÜÔƒ:\$iÜØ¶m«ªË4íKid¬²{\n6\r–…xhË‹â#^'4Vø@aÍÇ<´#h0¦Sæ-…c¸Ö9‰+pŠ«Ša2Ôcy†h®BO\$Áç9öw‡iX›É”ùVY9*r÷Htm	@bÖÑ|@ü/€l’\$z¦­ +Ô%p2l‹˜É.õØúÕÛìÄ7ï;Ç&{ÀËm„€X¨C<l9ğí6x9ïmìò¤ƒ¯À­7RüÀ0\\ê4Î÷PÈ)AÈoÀx„ÄÚqÍO#¸¥Èf[;»ª6~PÛ\rŒa¸ÊTGT0„èìu¸ŞŸ¾³Ş\n3ğ\\ \\ÊƒJ©udªCGÀ§©PZ÷>“³Áûd8ÖÒ¨èéñ½ïåôC?V…·dLğÅL.(tiƒ’­>«,ôƒÖœÃR+9i‡‡ŞC\$äØ#\"ÎAC€hV’b\nĞÊ6ğT2ƒewá\nf¡À6m	!1'cÁä;–Ø*eLRn\rì¾G\$ô2S\$áØ0†Àêa„'«l6†&ø~Ad\$ëJ†\$sœ ¦ÈƒB4òÉéjª.ÁRCÌ”ƒQ•jƒ\"7\nãXs!²6=ÎBÈ€}");}elseif($_GET["file"]=="functions.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("':œÌ¢™Ğäi1ã³1Ôİ	4›ÍÀ£‰ÌQ6a&ó°Ç:OAIìäe:NFáD|İ!‘Ÿ†CyŒêm2ËÅ\"ã‰ÔÊr<”Ì±˜ÙÊ/C#‚‘Ùö:DbqSe‰JË¦CÜº\n\n¡œÇ±S\rZ“H\$RAÜS+XKvtdÜg:£í6Ÿ‰EvXÅ³j‘ÉmÒ©ej×2šM§©äúB«Ç&Ê®‹L§C°3„åQ0ÕLÆé-xè\nÓìD‘ÈÂyNaäPn:ç›¼äèsœÍƒ( cLÅÜ/õ£(Æ5{ŞôQy4œøg-–‚ı¢êi4ÚƒfĞÎ(ÕëbUıÏk·îo7Ü&ãºÃ¤ô*ACb’¾¢Ø`.‡­ŠÛ\rÎĞÜü»ÏÄú¼Í\n ©ChÒ<\r)`èØ¥`æ7¥CÊ’ŒÈâZùµãXÊ<QÅ1X÷¼‰@·0dp9EQüf¾°ÓFØ\r‰ä!ƒæ‹(hô£)‰Ã\np'#ÄŒ¤£HÌ(i*†r¸æ&<#¢æ7KÈÈ~Œ# È‡A:N6ã°Ê‹©lÕ,§\r”ôJPÎ3£!@Ò2>Cr¾¡¬h°N„á]¦(a0M3Í2”×6…ÔUæ„ãE2'!<·Â#3R<ğÛãXÒæÔCHÎ7ƒ#nä+±€a\$!èÜ2àPˆ0¤.°wd¡r:Yö¨éE²æ…!]„<¹šjâ¥ó@ß\\×pl§_\rÁZ¸€Ò“¬TÍ©ZÉsò3\"²~9À©³jã>WeQ:ÃÖXä/ßØ\"\$†8Xç¡‰@Æ4Hè:˜t…ã¾LÜŒ˜j~#ƒ8_ˆªAxƒ\$éx{Læ˜EJ4'00æ<¡áğ8>c(zX´“^5Dãt;Œ#K_¡è¡v˜ê©•Åu…å1\nˆ`j–n…¼'˜\"I–rº˜Šã¡Ğ7UÕ*Ö!­Y¶Ìnjk@éÃŒğè+5)òÌ„Ì3CÁZÊB2Œ‚HİV½`‚qÃ¦ùÂŒªk]ó<€{Æ\rãƒÒ9‹|gÈr\\¢úè¥œ:B278ú1©çÍ‰òd=®HàLUØÈõ} íÎ^NìÄß”CÂ*/|«ŒôŠ¾“ÙV`)£8‹zã¢ö:ûRbÁ8ÓWAü½:\$û²2\r•/«BE~Œ8iY¨tzX6Ç°ICºªQ¯Ì½7ªş 3Õ)˜6ÔÏ\00N\rê°¦»âñ Á\r0ÖşÑ¯ Àöø9~¥'%DwÈè'cdi't¸şaÜ&r11?€\\‹CmSÉ\$Ğ¶â€‰oæ&ÄóR,!ç.AHG\"tP‹v-&’	Ô3€0.	¼àè£ƒ!iÄ•k„€èJªˆ¾7Øü	Á:sO\0óÇÂ^¼›©'7…€^(àôÀÈÁ›Á`‚ğÏƒB(0nL9”(\0´\n[êUÍec)Fà¥ÔÊ›q2‡¸‹ÚR5\rÁÁÜ€ ŞŒe}ÒíÜ±h.i ÌZ°´:A¥YÃÜED2ñÍ@òğãøs¡‰¤Ã1Ğd<)ÅÑH`éØª†I1¨‰ÄØI\rúZGRİÏ”€Û/¦‹ñ\$OcŒ±\"*p'Ú7Ï`]@‘\\¡µ4BXzgÔA‡ îĞçñBçTìQ3’wÂc­-‘sŸšrö_Ì:ˆÒúÕ¢S@Èƒ2÷  µ†Ø#›Ä–ŠÏ\nuP!‰¡T‡Ñe6ÒTœ•êaM)\0v¨(s¢VA±ZSÚ<™aíŒv¨éÀ(A%#&¾‰: `C)­\r“â]MI÷C'ñ/ 	„PHXb\r‡‘®ÕÈ\nÁYM°z²†J³FéJPŒé‘?ô­áJ‰²dBèllÕDĞCîS+‰-rÍ1Òå<wË]v‹!)‡IK²±P™4Es¿lÁÆ µÀkV´-kšj­½—,c,f„ÒRå²dCº!&İnƒ0RJ‘2[¡Òëš3¬x3†èTëB¥-ÊéG—lÀšls`hs…éV‡)W4S€–v”øCå:…ndï-ÌÖx`…›Ñ ÄÃÂ®\$ÈAÏPì-˜k¶¦r^’ÙsAíSVöô?™™3œìE2ÕØX,Két„”ÙÚSäAq7´Š\nÈº¡^ì+ˆú§¿’%skÎG‹‘ ¦àŠ<£ıaw	DÈÁ¢Œd°¸…Y¹Ú‡Qg„b¦•n¿\0ûA{æ¿¡”9‡Àì®Ã¹Èl.ĞHë²g¬(²0TJ\$Çh-Šùš«Bz°m\nWÆY`ì!†lc¿\0 ÏªÃ„Õ†MLxyk* ÌZ3´à‡EUÇ Lµ-~Éäâ?iiå4ş[§ ıi¥…DŸZP¨•Åº‘)h¼Z\n5\"œ°²1ÚtÅ¦d/B×òrJ»cNµ[FÕª©İéx‹°K¼ß­ÙnÂÑDŸQ§ šS‚?Q\r¸L©ÖíÖğöØî²Ã'!¯\nÃÍ…¯êII%„2‡½æèµ‚£QÖ;Ç˜â8m‘•ÊX-¨ğz¥‹´‘IFF‚üè]“Öt.ÀH	•ròä/Ã[!#ñü\r‘{Ì«À˜pH\n4&3r‰*§Lè‡œó¾{Ëá£Aºe\0ŞÁL(àÚı¢*Ï{”kø‚Ø˜“æùDÃJ_¸³CªØ:„U°ù2é\0ĞIÃ0,í–Æø¥œ\n;šî|š­¤»xeÀ÷À†fÉÛ0`1N`›¶6>ğõC){)ç3(t8dÃ¨O_ÚDTƒ^`µ™Hô:c»ô¬î\0f•º•<Y`fË\\&x è\nı„¿öd +¨òò½‡5UÇİ‡OzÉ{´ón-i¬FYbşÁ°7‡vo›Ø%)çşXÀù€îhüú ¡çè'Òôş«7UIÙVØwS°Rú´}ÏÓ‡døKŸ_¥4‘ ÊÅàWjnÏ„¯í\0l\r\0Â.æŒp@\0@È„[¢ËPZIèXÇÙƒc§bÏöé qŠtg2Û \\ãi9®< Z@ºÎi,`^³®N'àuGBr'&\$F(/ÊÒ—*uÉ„ÙàYi ÛO	‰å`Ê‘n:paPh¯ğnğrå‰ÀMÊ	\0ôĞºÁM´‡L,Â\$Û¶ÄNà‰£§–w¦)×Ğ\0‹*™®l7G†rlr€Q	OÜs\"„4Æ6Ô òºbXÃËbÓ„€oXÀbbeÄg\r´ `ùƒÂ‹BÀĞ’€Rhç€áJ‚\"g¤ˆ\rTcj>ÅIõ-zGo›ìlÇv‡’u°€¬é×í€\rçz\r Ü	©D9¥BK\r^¤\r“YĞ@õ†,BĞ–L`^#ñ†\rÌğwHŞõpÅDJõ‘ÁMX‡Q„&æèl‘’gø&I\0£1 Ë	âP®¦5î&n0…®±?gàT¿âséÄÂÄÙ O!)Œæ`v´ ÒX ÒÍQĞ‚\r y!'v.Âğ\r	f°K! {#*/±öà¶¡\0Hâà·\0ºår(ÈˆÓ`ØSÇpä…cmó­øI)¤Ò8.¢s#òG\"¬`ÆíÆ‡x'Å”E§)Qo)°¨°&\\š•òVRZ@·2bÊ’f'dZ&Â,Uã³\r‹¼\"*±Óó‡4! ä\r‘¯D'G\\ÌVôHiÁàÈ1Rè‡pcâ\$LË2\nb”è×ÈT³oB8ÏF½ˆŠ½k\\\rB\r\0¨-l\n§“13Ç54\0ç4SHßM4QÀærß2«OÀó%€ù6Óp±5/ïO5:pL5±êÀ)À¾óPÄ¾%E¥3«6­à·1¢”\rÀ»4ÏI:S¨\"L´Ée¤èGs¢‰ \\œQ¼†6«27ç½=C	¶›¦,ß	¶¥&Dà‚)“—<‰´›†¥;óö\\òÒ~2ÖË®Îrî0¨76ó½.'?52½K6Çsa6Rï2²õ3SVLM@Frÿ9pÈ›3âj@NSÓ‚³k:Ùé¡@)ùB\0Nä¿`Ö!e®\n€Ò'Pã­”X¡”\\çàYqLVÂ&r¤¸³ú±³+c.€]é”Àh2]4¡ z`q8c6q²4 Ó“Pg>û#–.é)7”¢´¦Ne–\$nÀìBî`àë¢\" 4ãLàÎ~Î‚³—ğ\nu.ÃOBúÁNôëè†@R&N´(uN@Ï:ô¸¾h\n¾¥]6¨*ªhÅPé…XéÎ @´ÿ,P3¯S¶¡µ6™U:é®ŸHã«5Lš­-¾ƒÒØÌí6ôT6ÓñSÀC0ÓFsÃÔRRB~§rä:T°nÑA/¸±OP2²-âŸHªÕÊ:ÉÙ1úe]P«òİ-'''8;í¹ª¼­Â8WÀ¨ší´¢UŠbYe!\rõÜ àÏ^)°ÛÈ–p»]àÎ	 Âj.âò­°µ…®ÀÛ`ò</\"šUŠÆªÚw3Ê¸b ñbrA`äfâ¶çîFµË_uá^MÅcTBÛ	_ÌSe65`–\ra÷æ)e©Ãc‹]cÖAa–_–oa2>°B\$§@Q<OHJtx\"šg€Ø éòµZ\$nW@à	õøD#S\0002˜²#V»©Î•ğB”;N«1NéKPnÆÇvÇ1wàğ’ªE€İl‡*çYnŒBÆ4†IqûZ…ºş…`zÿ¥—\0\r¢í§RÈ'\"í”š‘ ˜i©O«	pàs|)·=÷Ífë‚s1s72¢›i-ÙGf« Õ`àP%H\nh®I\re‚¸\0X'¦ò\"\$âzÍ‰ÎYešxÆ@|Š~òk Ëyâ¸s÷e`ó\$ZR¦ãzàğ ·µ\\W£x[¤v`ñ{\"Rwnˆ'îtç†o#r*Úâ÷Èò\0DÅ3~åº^@xòBš†‚~†Ä¦@×Ñ}B³¯ÖU†è€C‡ûx‚| ¦Y PXN` 	à¦\n‰à‹„\0R—mz+X:÷¨q éyØ*€‘¥X(ÀNo^8À[fGÛˆ¸ïÂ\$àğ¦LàZ‰ [vÂr#åX³îÏ…e¯…×†\$ê'æ:\0[Š\nr\0Z÷¢ò}·”	—˜°›Ä…b\$ßS|Bcr³QHˆ¸)xĞ N¢‚De“M‹bÍ ewzXÂÖswxı…ãAdè‹‚LYC‚æ`÷{Ø}q}ÎŒ’˜ã‚ØÔ  ’ç4j•‘4bFO7ä×èMN.'ïöWòS/uLàÊ	¬Ù| ËØ\"·ô)˜IäÕ±ÄU%VU©ÕŒ¸^q§'ƒK€4=“—c\"PÈñv²î¸âV7½šH“‘I!€ ”\n`	ĞğÆã›“ õf‹”ÙirH	tXù’nš\$w¤FHÄ‚PÃ@¼éÄÑr²°ËBa†¼@WÀĞ9`Îâ~ëbÅuâ¼ÈÀ>Áwùbòw3ª¬M~µ€zÊw\$­JÙ<Šâ@\r&ÏIåXÏ<ÉÉ_,Ñ[ËŞÎàÒÏ,eŠóDuWšÅLÒ%°Î\0ø6ÉÄ\ràù?©ºŠbLe¦…Ke‘*Èl©èı;cXkY\0“BL‚™@ª\n@’o\0Úh…–%êîÕåälx“«š½¬Å=õR°B's2tpÄÊDÏ§\"àZ=ªàÔ\räBc®Q2ÀvÌBŒr4lv ^ê èúgš(Ÿ’ø”% \$»\rvĞ¡\nP\\€~ÀU.R%ô¸§›°èƒÙ¯vĞ“zx_›e{Ù3!e,{e—Ğw™îc»o|0EµØå“ÂW¢•ö!¢ìÊ8wÑ¶uiŸ·tNe€fºç:\r¡(Ò‰Dÿ¹V¹‚™‚@æ\n¬›{}cAÀÃ¢×ƒ|Ñ*í!XÂ¶‹†\rÎÆóË\$İÃÃL…L/ELlU-Ô/à¾WÆ¬cõš“Š\$l\nUÜÚTPN‹îÅµtç¾£SY<,4ÛèÜ4. sö	kÔüv—Û Œ¢‹R+bd‘ñ´®ÜFN!rgs\$¥Î?äĞßBB¢2?ëP\$dæÀôtU`UÜ\rÄT\"œæ–EJí´@o¥UxÓÔ:<©3SÔSÀáI–xGzD(7Ê~¢œM’|Q~b5+¿Irê z»vÈ@¢wf6#€öE¯\"-§	(¥Ò—hSİ*°ş7\$›Qlv‚·†ÂB%üà+ê]2OÈhË¢roªº¬d\rúÂw'!ÒÅ¥ÊÁ‘¨‰¯Æú¢ùC`ÂóbiĞHÌ8Ïù(\0 @Œú… ¶ıD™dêœBîö­>,Æ4İq×HßÒ¯Ÿ×Äì¸ ¥ ÂHb¶àd\0`]ª‚eä\"Çb·£†¦ú¢Ä w§6ã›;I?uÂMÜNÍj\r±bÅŞS_!‡Ş·ÂwdKĞéĞ\\O}î{=tıtüÎZàê\0§Dxaº½ ¶ıN­ÒÎ 3´«R eš„#šï©wÒğà^NPzÒUš»«ı=­ºÉßÅ!¬ûz˜ŞLyÍ¸@Ë¸•õc]ælÙ¬[†´pœÕX°MÕspäºqÈÖ5ş‚Û*W²4èXéşs^š\"@Šr~¢|>B5 ág2	€ŞN±Œ\$ígFæ¤uØ\rïzÛñëTjB2A®nè®yÒc^ğ¾äğ vöÿ’¾Ò¸¬vğ¤\nøOÀ‚vÎÃÔ:ğ§àv­}\0Pğ»[æ‘Aõ…ÆÃ%3@ÇÇ@ËÇŠ=ècXGà•…îy)~u>´zºšºÄœ²™Q§XW\"©wEÎãwt°ş;ÿmÛßJ¦ªnf²a@Ğƒ–›¿OoÍ;ğÜöğğ½Ï©¬îîO hàVí€VcùÍ^\0¢àà6¡ôˆ,#2s*ÇÕy2{Ät§«‡ÂXoñæ;ášõş™Œù°ˆl²’»Ø«ã˜\n¸\nZœc?`€(%³ÂÓüğ×ı4\$ƒ’&¢»GrTó¼!şğËAİ¡CğüÒmŒj0Ô€øÕC\0¬D[­H/{î²!á“A×éîk!N‹:ñ5q\0°§MKC.íB7ÀØéÍ/´‰Àæ •@`Ip;PGÙrÀ`‹+Ü€D<C‚]Ç†+¨<,%Hl`®09õ-°Gs„šÀV]ÁJ\n‚²‚¼‰» äu^ĞVi™Š5¨/	6\rÉÿ%©““TšÇè‚Š©ƒû:Œ\nšó!½ã@ nˆS†ô\"Àë–&)ámt1¬Œfğ%R°˜ì°éƒ•VX„JtX%¬@Í=bU\$`z@X€2dD^…Pq„ØÅ‘‡4p¯@\\,B~Ä6?ÑüëŠ?ù2¤OP6\0ÉU0Ä@À	XK‘Ápfğ6€ RR,e‚8ñ¶„ÈZ\n°kê.B•†àfB:7Œ¤]\"Iä6J¨üU£¥\$Mö‡paÜ:€4…õ_gp¡ÜÇ/0ü®Â@Kü;™ğp®Ã…ó¥TI<Aáì¯ÇDƒÜ =!üC¤ƒĞè\një	¨ä¶Øå¿‰šSçÖ<´e…§-aË?X’ÎRAö]§ë@‰r4Ó¢ÓOD%Æ9“¡¢n9Èxş'OÆ4-ZÈtp‡FK&1f^biB¥ˆ´\räŞPKÆ¢)%'*ÈAgeÑ\râ¢.²o@Ş,`ƒ’[	`¥}¬+“Cà24â¯°.(\næÂÆ„Òlùfané*\0œ€Ok¤!lö%ŒYİ„EtÉtÆ¬š’ÁıÇ(õ	ÔÎ±|¨@J0‹’\0D4!J\0ˆé‡pe@Oá.´>„üã;›ÿMfkø~„N2K¶!h@Ş 5\0ö6iwzÒgUäRXÛª æ8A[Æ§°’ÇÑ¸ˆ2&8¼ÃHfë9£]·r\$j81AY<ã‚’xåÇ\n/Ó\$h	Ï\0pÑö€¼‘(Qw@Ç@Z†D€EÁ`ãíik#Ş¯%ñG‘ÁÀ	ÀAÀÆÖd>ãÃB@Hœ=mœ\$qÆÂÿ ”tò\0X‹@åu¯\0§ÔÈHYÙ<x*F‚˜@Å!<Èl\ràg‹@ÚÑåÇU>Ñê	Ú·P 9úB#¦\nãÔœ0ŸÈègò.‘€i€ÒNIH.=¤ÃTğŠd¾GòL Ü“¤†ÈÆHò3’Sõ\0^0‹±ÚF-E\$˜ä\$ /´\\€q)¸\n@¾†Ğt³ # ¤ºqĞÉF2o“Šdèƒ¢uG|H‹²éc¥9#ò‚<~†:*À;,BMd@tó\0jù5ÎMƒí¤‘ÀÈ!u´àk«€u(Æ|Ê8ò–¦%'È€¼îFĞ¦c[ÉCÊ8!1şÉƒ	J A’Â•T«\$|6°…vXÑê\\­ÎÂé:nâlr@±#\$–€¥¶2Â!ŒÄn“C-HÌ62Bª€‰Ä\0¾=ƒ@>ÑH0>SA&……„hòã—|¹¥Ğu´†\$CÕ\\«‘ê`tk\0 À|àr şØ;\$z¨åGq«Ë\"¶©o&¬µæøõC†;š¼¦-‹Ñ[Q ÿ‰zÀLœx	:~¦€–6»±mE¯Œ0Í‡°”ñÎÌ®#ÇàÉÀŸËr0 <şí“iX–Kxu•#IäYH@V[*ÇéQGÂ®¯˜Ti€PÂ8ˆ*´°¥%<\nšjM†\rŒ¥.AZ&«5s3<yÂ:0’ÛÀŞ!‘½ÿˆÌ%ÁRW**YŠœÚyU¡‘ˆ¶FrÊHáU0Fa,]·Ã„ñ\"ÑIÜêŸØã9¯pûGÑZá\$L!uÀ3{€YŒ•8v	ÀÍàg%C™Ì†˜v€w8HYÔû!K7i!ìã3çƒş··gc=]p™İ7’s€œ@œ›nH£p2¨åƒ(£ôï†ï<›ƒÀà—€Å‘4ídµ+0è!M\\¢\$8\"\"ó`dŸOÔÀcyÀ‡…óäH¬/ÈbmY»‰îÂÇ›FK&ùM,\$3	“]C›>Á.F&70êøÀÆ`°>kSöOÑÀ¶ÇNNØŸàBÉ\0Çølää€¤ADd Xè¨:XcD4tJ!B\0ÄŞ%µ’ˆ¨¥(Ô§ÑŒ2IOërtI¢=şø@O€\0’Î<ib´#KzÃºà&îSô(:ğ@@¶­ 2ˆ1^ˆ?W¹_(–§bQQ<ù¥b,G9=ÑJ}¹è¯’Ş‰Áİ§‘EÑœQ‘ÏÕ°ØˆNJê-LÂH‹Fd»ŠzŠô)¢u\0º`ÅzkÊù¢óÑh÷DÑÔQøZt'¢Åh¶O!RŠ´ ZÂ!F5±í¥oŸ˜®I(îÉÊ,d5ó— Âåá€Fvb'\0&3HCC8¹ş<ü¡0¥)l_É`5¶ŸÉ”Ìüğ3Ÿíá&\\Ù¬QÒŒ@±P²á¯@í)#Š9‘‹4ÖÆFÂ\n¯?áÙ6b)èEOHñjÍ&x	F‡dm•ñ‹@ce‘-5‚“M‚*Ólctè¼‡JeDëÏÍ4º\"u<€ÑOAy%ˆ‹/G6ú0™Ş] ‘‰@s5À˜%€R+€°	ş•Ñ€(§hÍêQ€™%\r\r3áÀP‰¸â\0”ÚÔ´Vƒ\"Æ€™!Æ94¹UË…@QOà´õtÑÂr\"~âœÈ&˜t@`3ğ#änªPŠ^óD*\0|¦Š\0àğ—<x‹ªØˆZŠqõÏñĞª­0ÜB,j}«¡'tñ§U?Âø/\$˜\nz52*6GPO#bWuNQ €t–\$ß\n ©7¥d@@äÃ9şUP§tyZÄmPƒSRDĞ¤ò®R~oºÁ	¬ pu1«:Ó\"±ˆØ¨:İ*Z*™ÓÄbI ğ®Fü-&y…TçL¬„b…sWà€„•aMh	û'eÌÜ®’¡hPŞÌ\$à\"„õkèqc5`Ô‘ø\"òø¦@ÅSèˆ4u×3uvk§*6Ê¤È››À_v\$òÖ‡Z»bÖ&ÜäCŸ(%ÀEšî†xEîFÄ@À;#HÀt™ÑMÒÓ7Hd.U+¡8JøÑú–2û‰fdç'aGì\\Qş7<Ãs„W[bÉõ8+ÏøLÌı.)ü\0È\"ê.àÃˆÔs|#Ÿı7jgX,¶\rY„	 !á\",€ {”ñbG`ÄºŒ°Ôdã7>fôËå‰€ËX5–6	-%[ºÇÖ+±VeNà„ÓbÅ€}dÊdj©+õ^MÏ³(„ùCóÈ¦§ZÔ€áBğYÆÃppáflûCdì´àbíç•›ìò;YÚÏÉËùV±ap»·½Iˆù²lúK,=fş¸Eª‡,I±dPNÒ€œìÍ.¿3œÿöcë ÄÖ(³Ø•F0Œ4½á6¥+µ©í °SóZ²ÅIp -«ê\\Hà/\"*Ö’µµªQŒ'ë]ØĞö¿3LùKU„a[\r¶Å²8ÇÀøP2Û\$Ã…ôWì*3(í\n¹/E¦OHØ¶·¸\$˜³}´±\0‹.©Q(ˆ(iTÍa	^„ƒCœµ¾ÖŸÉBw4±:L`â!|ÛçÂ_m,-‰\n©\"¨	ÕÂD÷’å§òí·ÏïO†Å£öf,@³¿»XM;çJ°ª`@P[IÃ!Éi›	E¨Œçb&™Ú– ¥™é:	½O%Å+Ñ®\n!Kc\" æ÷9.âÛ‚î·°¤­ôr€=up`‚#-ª‘D¹İÑÖæ9KAÑ€06·°Êiã(QB½€bœˆĞmÔ'¬€£nŸšˆH›`T@QÎg¥•ÕånN˜,Hd`¸éé~l^Š<Zı>é\nèuü\r0ö»Ôw	fĞ€ì²58|œ&Ëv¨4æ”>È×¦ÅÓøŞ·¢‰ˆıyØî\0´B§İã’ûÒ^óñ@¯Ù\0W_ÒÎª\\×\0¸x_\$áJË¥sëºiıOIùÖ„i×Ç”>¬˜f²|'Lµ©Œ-l£§ğıtxßP WÖ3eöÆ[Öß*»(9!\\bn„ş¹ u®XjH\"R´£eÑ‹®=ú«”Zæ_*ıâ`½äï!õwş¢Ã\0w|T~ö8\0Ú¼®8ô]/\0dâİß,Íuû­)Õ6«?œ/'VÚœ’T¯à)\$¨j×*rUpp§DüÀñ|j¶Ğll—Ìèİ~9±ÎG‘Ü<\rŞZtOÍqŸ³âä0„}XeC2È‚-ö!¶‚ÌÀ–›BJêpš=P9Ã)!ƒ‚Â”\0ğ¨‚8tÍñPìÂuã¡å4tñÈI'6ÍùCe†ÂºŞÔA@-È©êƒqÊ”SkÕĞ€ıP-€ [£¼¤'ù„ì8¼î×ÄFP{\n0Ğa:”¥„ª °…¨I¡#Ï„»1/A»Ä†¾ñsBæf‹†rØâ4Œ—\0‹@îñ=‡áÄüxİ\0Œ=a«\rˆkiÚ5ŒçQÅ~@°şõMhÂg’b‰¬^p³†Ç~üÍ¿ÄOñy¦Ébª	¦ÅÔxñy=±\$â AdZ7×	äÜğ¶ºmâ!‘À\0„x 3—	U.¢›îŠ©èàyæãš°™­SuÔ¬½L‹ê¶\r€V3qŠã¦¸U|;3N±ÀQ«[Û^×'ó4¹ınvô`°‰·gAV€¼e1²TöNF{@©ıßüĞ¦at%öL(ÌH°<ŒÜé‚Ë^CŒG‘cdLëµ¬ã}°†‡“ip¿™,lXÇqíuK£)ìFÈJ„Z´G;@—˜ æøíÇy1ävÁ“xêºCuP3€ë)ùGÊõÎ²“•¼z…¯)\n(>Z²Ëu=e‹J¤9³¢s=‘X«4Ñ6^YrqmU™Ra¾Ê!?È±•€âºÎ@ Õ' 6b.Óà€Û„*-MZ‡†@¦R„(el»ãI2ŞW6²š²iŒ³IUPÒ8¦ŞV¼2€P*ÂWcE,É/ùª@T…äOšĞ<æ¿!k š£/*›µ%ºcîlZmJÆ­gZùÄ»·È&Eìh…6ÂN+s}o‘1ç›\$BøÃRš\$ô'uÆ¨m‡feAO\0¼*+ÀX[ WlŒLï3­»¢J®`KpÜl‹Øß ™ğı‚ô_:iyõIz0„¢›p²>+P!ƒEZÁÚ™Á`tMÜ3„C;•Û9É¯Ïhîêá‚\nür	 Ëé æ¶2`@|Ü@S¯7I®`|àOÂÔz±©È	˜Š\nSŒp1¨Ü55[?ğq›Ãu\$Û\rºIPD€¾ğ‘jh“Al»Ñ=F,ØÌõ¯K@p	àô³¤pÄé'4&ÚĞ&“–,Š(˜KD¢TT®Š4®úşèkI‚³²ÕBü¿Ù¦%\0hÌšğŠÁA{CJ÷‡ªÈ3Ó#ŸhK6á¦ÍÎ†[%™`æ“éP7Ë Ò¬Ùzø\n\"Öú{²Ô„ZåĞƒ/ÎHt/œÄnµÑ].‚º’Û5+—cg=¾Ö^à¥ó\"û¤\rŸ³0 ´'ümB'èv]1ÈÏÔı5Õ\"ÕÉx”rc[3ÿ.ÀgÎtºyCÃ“i¹•ÚÒÕÜ.G‘\r_p\"ÂÄ?ĞÑ¯+00\0¦` *\$ \n4ZrQ@L€.â<@Të¬“ØB3dÚ>ØÛ9ğ%A-\r?‹Ú@ æÔßõ§.\nÃ®Ãİ\\Á”ş9¸åK€…ghI­XM^Â©¸»æßX9,œ	:Iô-\0ÆNµ»ØˆJ2||qÍYÂ°¨æÀ‰Î:8î2o_»kû`uòzÑæêdCš›‰tp£ûÒmÎEÍ>«£¨L’ \rĞÀIP€¸ayj9µ2újş‘O`RÍ\rMõ¶®I¶ÑHÖ=’^•Y'Î0z íšCÛ(9.¼6Õ ÇŒã¢\nöÅ™”k/ZÇ«Öv¶u¶º¤NîY¡·É–´K| )’‡'e…¿Š:«:ß°9Kö¥K°P ¾(iN+Ğ“)t(5| .Ğ ıš),,‡¤·@'Èğ>{‘?ël\rÙN™Åà /:_}?Iœ\"[ª`v•÷[\0*!é ¦`‡?¼¥X¸z…)©È€‚æò¡ì¬Nª’vF\\n‰€÷r\"~ôN(\râh?|ÁRŞ™€øi]eb=n›á!«.Ê—¾°‰G¾~éÑNş7¤N@¦iÔúšwÚ`wıjäøÿ‘\n\\fP”%ÈAÓz°@”¹Ä0ä«‚¹ËïO‰eÕçQÆ®ì]…£íRÖ\0ÿ¦ÅA¤ÇÕ1±Šk†]†®ø ôÚdìÇæ¸fd÷¾ ‹E¨?ûüÒ¿Íè·çvÜBLÖ··]F›­QA¶“Sí»Kçnbí–vŞ6ó^‰-RSo‡‹ò—™3Ì¯7‚»šS¦›­iù†mZ@TF \r¦~(²ˆxÕıàÄ/ˆò>U…áÌ¯gşài\0r‚¡ÖìŸX7	%ôúfÙ>kgÊc<R‚zÅVö¨59gvTØ0 ño˜Eêç¸º\rÏÃƒ¯Ö2 –±Y6rpÄ¹\\F…XxşCp?‘Ü@îùÆæ‡R‡’%&¦xUëƒ\0À«á·“7Öå€Ğ®ƒd\0šP¡[–ü®–‹êPÂG’HGNN=4Vä&¡w;k8ï3yŸ ni!p­ÙÑï¹wÁÍb>÷•ÅæksëNÅµÆƒŸ(@XšAJìè|Å†°€cn …tx;·%Íò‘ =ˆO«—L¿İ.¬±§ Z»U²WÊÆÛ}©\nÆîZ5ƒœ	/?v81ËĞLÛ|—b½©BYÛŠÑq\\z¼çÈ‡ÀWÒm„±Eö?3lMÏy’RŸbÆGëÛgæ8%¿ä˜Š·çŞ:\\…›ŠÙM\\m‹åÒyI\nC¬7¤‚Iƒ\0D' XN9«Ê8Q€ğt›¹HìK¦=Ìœÿ»¼t‰XV¨ç©©Y%Äğ2×@.fl™Ì<-ÓCr¨Äæ@Ry•Ét'ô·œüÑæŸUp!\n4 …9Ü¿Ş‚×ùëuã¶ÖHîGpÿ_¬_Š(\0so’É¾W7Ş’e\nY_YftBÇc-9bj«ÊWm?CKÑ ‡Nvò\0'÷/ágùW¬R›ô‡°›Q§#4ğ96DVg˜UŠ™daZ6#ıÅMäSùkCVŞLÖ·”Ÿù¬—\r^(P*ÒA²\\6—\n½šŞ1±€(}â®?wĞäyApÌğ‰ì¨àÂ\n:Uqh¯Ç‹ï Ãûî2ßå=ò8Dƒzşş÷æç¤=<_€óà€Ú„qÜ~^‹œn™§¿Èe‹]ŒRqá—†”/7tîzcã¸ÇjÏa…ñ(Ó¼[¼†¤·³	‹ªYc¼jFX7¬¢&H¼v0Oxå–HâÁk¼cÖ×ã\0ûÆñ[p×ü„¼,ée\0(\r mƒpcı¶+)ã/xr @:’4\"á7†{ç˜M 6÷¬½âÖñïÑ6ï éÃ!§¿›|ŞÉ¶Š\"qB‹`/ŒÌÖ>ıøîšMö\"l,À85tÜ6rvñ9ÁŸQ_‚İ/·yMzÿÒ0úHWŞ”ïrT×]ALÏ÷Ñ>‘{2œÓ¯RJñ½}ë#=Q^2	Íáì\0w`-zrÄ9ï}Àİ^›À@ğ#OóĞ®`­á¯Âò-\0à€y‹p’ëê3ÅˆÚ-X¶“\"*“‹Ü1µ*iªˆ£Mñó¡ÔlšqÖa/b·\"ölì#ÒäÇÜAË0cŞº½›Pt»ÈöyBÀÃh»lPĞ´¨\n£\"é%H2È„dÓêi=¸ÀèÅaÊ€¼¡wm§j“¾\rîìÜü(\r³óepP‰ÏL®ÏÏĞË•Hq( ®Ä„Ì2/ñU;;Ašˆ«t\röHN&:qRÉœ`l†i;„ŠíòM‰ÌîwÏÍNSó„]W·1`4Ü.ñ®SÁÌT¥* ßÈw–.„Ëé©–Tô|=–t¿R\r>M{`€ô/só8·Ğ/¬ã¸\0ºó -©ì¹§Gt¥ ÁŸ-ú²©N¦iÿ°İ5b\r»1Ü)é!³Û;ÜŸ!ÜÀ‰Ïø`‹È¡aùwBƒ\rÖ\$;%ºÕuZÂÿ÷Å¶ä¹ü42¾ô0ÜÆ~¿~ãßØşéøSÛ\0÷ó¿™ügÕ*ÿÇÃšQéœ|(?*ŠËĞ_¬„GÅD|(ø„}•ÚµùÅÅô”¡GıœßËûVH¾Ù¶‰\r’mÊó&(‘Òı…2bâJWÖ}ä‰]ı2pÊşßİ?½õ¿…ıÂR?rI/ëºú#±Òşì¿~\\{ıæÊï×†_ò³·íuªáÚ¦ ºpKÍ`?²ÿ°Œ¿x4@kÍj ü0’Ã\0VüCè¯Å’#\0kpDÉÀu{ôÉºÿ¯Í@.[âÏ˜(ºº\0àOc¨…	\0O\0´P«\0ÓûpÀDóÈp\"½¢F9á\$Å¥>ÅKß(¨ø<O¥¢ĞZ\rKà´	D\\–6AŒ@½ÖØ%ïˆ	:(Xp)ƒŒøD\nà6‚ûRŠe{)»ø_+,˜ˆ±\0Œ•@#£ î€V\0^A<€VûÒ˜FcŒÖúbPj\r¾Š0ŒpVªrî\"r@ğ:€ĞÄy(§“šØîÑ¬³¯{â‰n5j“ÌD#.Sâ[‡ıT'é2<ê«ïÂ{p]a­›xn˜kïz–\"ãÀ\\@1\\X<@”„H´+;7b	Êà¡€àHWìx½šBÑDc¬âLY¾!‚	Ì31&Eƒ7€=¸Z±ùÏ)% tĞºˆ?F³´ˆÑ€Ê	BÃ\"µtP[†œw së;A&³°~;LsXç ­€v—¢\\ :%Î xk;)òÓòÎÎ\"?®	8!+ò“².ØP@Š,P8Áğ’øeŸ0ŠI<¯‚^º pu@2øiôªúöãûàÁø&¨t©\0AŒ(çÈÁt>  2 ßÑ;/¬˜bv€“ -	%P“ \$vĞçn”Ô€Q©óm=ÑÓ°ÏÑ<ê`ğu>²u¨\r\0BDZœ\$ƒŞ|Ñ9p£ÂŸ	l&›7‘\nÎğã±¤ Á±è{ˆ8Pô€¦jByHÅ‡\nà' ’Áà °@<Rà(\"p·…ÀĞS~­Ñ†ãB7¥°4\0");}elseif($_GET["file"]=="jush.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("v0œF£©ÌĞ==˜ÎFS	ĞÊ_6MÆ³˜èèr:™E‡CI´Êo:C„”Xc‚\ræØ„J(:=ŸE†¦a28¡xğ¸?Ä'ƒi°SANN‘ùğxs…NBáÌVl0›ŒçS	œËUl(D|Ò„çÊP¦À>šE†ã©¶yHchäÂ-3Eb“å ¸b½ßpEÁpÿ9.Š˜Ì~\n?Kb±iw|È`Ç÷d.¼x8EN¦ã!”Í2™‡3©ˆá\r‡ÑYÌèy6GFmY8o7\n\r³0²<d4˜E'¸\n#™\ròˆñ¸è.…C!Ä^tè(õÍbqHïÔ.…›¢sÿƒ2™N‚qÙ¤Ì9î‹¦÷À#{‡cëŞåµÁì3nÓ¸2»Ár¼:<ƒ+Ì9ˆCÈ¨®‰Ã\n<ô\r`Èö/bè\\š È!HØ2SÚ™F#8ĞˆÇIˆ78ÃK‘«*Úº!ÃÀèé‘ˆæ+¨¾:+¯›ù&2|¢:ã¢9ÊÁÚ:­ĞN§¶ãpA/#œÀ ˆ0Dá\\±'Ç1ØÓ‹ïª2a@¶¬+Jâ¼.£c,”ø£‚°1Œ¡@^.BàÜÑŒá`OK=`B‹ÎPè6’ Î>(ƒeK%! ^!Ï¬‰BÈáHS…s8^9Í3¤O1àÑ.Xj+†â¸îM	#+ÖF£:ˆ7SÚ\$0¾V(ÙFQÃ\r!Iƒä*¡X¶/ÌŠ˜¸ë•67=ÛªX3İ†Ø‡³ˆĞ^±ígf#WÕùg‹ğ¢8ß‹íhÆ7µ¡E©k\rÖÅ¹GÒ)íÏt…We4öV×•¤‰\rC+Œ„¸ò8\ró\0a“RØ¾7ŒÃ0æı¹^vâ6ÚnÛáxP\\áÛ°Š@y‹°AğR…ôÌ Èo¨ä`ÃK~f“ôéå\n°{‡f9˜èåÚÎÅ¥…«~†!Ğ`ö¿Á@Cµ.A‘‚Şº.‡º”²ì9¦Ìız”¡\nòlöë¹¨w~Şã\${XHpÉ‰ÛØ­/ÁåÔ¤gú‡¢³=Ñ¤écàHé¡fŸd…•%jö­ºc5¨^cH{\$»î\nµÅ\r!÷4…¡nìÿîî6õ”…cHºéê[ê.6ƒ¤`Ó¥ù»Î»è°\\7³íûğˆÊà¡ÀWÃçªŞ”>ü}ıàñhW´öÛ^ÚÛÓúL©©¿ÓÚ˜à rY_À´¦WV:@v\n˜†ÄÃ¸i‰4é¯0àBÚù¿E¬À*`z|Ú‘àœ¡\"êÁ±úC(m¡ğÎˆQ¦\$X®Õæ•awKŞÂ- ÒM0œÕšÓ^ˆ?ˆ\"\r†€t\rƒÉhî ³æà}ˆ¬­yÀ°zëÒÉƒ«I? èb€wA?‚ƒÚÑ‰Á¤AğÊáŞhd6ĞÆAÙğ^2aÌËƒ¥ôZ†R ü‚Ğ¸Õ°(’,>ÕÈÌ¬Ê)‘ˆüŞ‘àKğà2·ÿ!C¤‡lµ\"É\$!ƒ@[fzXHytAĞ'X§òSÊ’%H\n4&4ĞVSZ_©À‚†„ç3ÓRlMÓM}Ôë\$R:¹NiÕ@å´¿ä,˜¨ªc†Y“2Âc˜g¡p::Ø HhŠPZ`ÏF8®Aâ»W´^•|CH+gôÿ°\"8G‰\0tÀššÀŞŞÁú\n„t’&\n#Œs ¤ÆÔ–¨u¢'NŠª0Ø¨İ\$')Ê/`è	\$\0\\D05¿6Kã²¿=A~B—E±Z‚Ê–©Ù¤µ¢@˜Y­;'n¡SÂŸá›=D2¯¸§lï™ı'/Êj¿§Íxùi&Ğ{WĞ½Y;Èq\"D¤A8a^1\rŞ1÷løx”)å‚„Û*R:p İ*P{ó±‹Â0’rŸÉi©Àõ2f¼ŒvM3×§öÏ—!ÖdŠQ3ÔÁ<\n9“No’éÅ4Sjo›¨”6\0D	æ	ì´áæ†hKYj½«=I‚xU-Šuµ\$‡Ü¹äÅBòåìn‚{…a­\0rağ´\\ N-\0á†ƒ‚ÀÖCÈwZ9ÚÂ+ŠT!ÆÎÂª\0Ô `ÂÕ!Áñ.°ÉZ\nÕr°P?ålğhe>wş0·A)‰Ğ_!Ô7…óª[0ÉJÄÁ>‡TR±)Àx 8pç‰±DMØÃ-E¼pq‹\"\r¿”¢\$qŠÃÃÈTd«Uz±Á—êV½L˜|ÊP2Â§ÿÂsé‰°)­=˜C'åpÙ”ÁE¨¹`Ê‰æ\"\\Á[Â/N§€¤Ê|­Foy«&ÖY˜ë\"YJŸ4æ°v˜{;bˆ×>:å‘]‰9Òà:ùH	[Cv4ĞhAğ1?¯&Âéª3›Ò–g©¯ª„jLÆIÁ`£7Ê€Z^ä:µäk\0­5|ÀÕ Áh'2¤‚à\$½áåÖë`ÇCœ–!£D§ó¦Óm]-@ëRı}<Á 1uºy\rØ…`ÂeÁhÇcÛNÃ\r=ÚÌ´á˜ãp6©.ºûlí°å¤˜6¡ED«p‡}Ç¹U¶óRaqÖ‚y½¹ì¾êÚ;´š†àÓ¼	p=ÚÊ7A©=ê¦T^6˜ì9‘#ª•–Üß6![şE\\ì@:äúƒooÍÄ·#3Ü/ğ^Â)à;İ{K¡. v8›<b»m)W¾¸Ù\ní2îsÓÎ¸]ÿa'oŸ†¾%¼¶¿CâäÏ{éş‘ÖxÈ\\\nà¨çY¡ –ˆ—¡¢uhÛG\0¬hp;|*‡[Ì8‹éÜ+vj~«ÕÈŸè›Û|r‰SË·÷xæLwtwÊ»‹òşÔâ=Šø>×vì©ì\nL1€‚ E\nAğ!… Š}|H'…\0ùé‚pA	¡>0Â¹n*ÁL!„€ŠB	‡»`Ÿl‚\0‰êB!L\"Í¿¿wÿ‹ğE[sf8üoPİA±wÿ)¯ø·Eš‰æŒÈ|Ç#ó\\SğsU3Á˜ç&ı>^şÆ{û”×å_Ï–j/åîbR/á/´ñìLÁ¢\nûÎ°şÎ´üE\$¥ª ÈN@<ívzoäğ¯úßmÁ\0\0ÿp4ßPç.vËÆ¬«¯\$èèMèüNå°:ñ0æo6»OŞúï³¯!ï».¬ûí±Ïøéú0ïpÌ”!°Ï\0\roëp^ğğcÍÌû	¬Zòğ0k\nP‡ ñPúf˜ã| b¶	¼¸%m	´ÅĞ?P»\n¿PBÛÏ6ÿà.èîĞ­nŸ Æ\rÀÍ°£½P<ñpàê çîğ‘ıpXR`\\à _‰ÀÂ Ø\$MãĞ±(ó'¦ğNıîA(~jÃ‚L&â`Bh\r,èOìØ`ñc‚kâ ¶Ù¢ÊÌ)1*˜§ÇelÎÀú²d\0Ñ€~ífÚ»Æ–`K¨µÈ\rn¹'¤üqt«`Â¶€Vœ¥W†D: Øâ¾¬6\rìÃë\rÆÑîÒ€Z—qŒÛ±öxIó©Ê|FæâºbR%kíÀÊÍ†â ä@Â*Àr%\"€òÌ+‘!bX¹rzifÍìòIâP>²\$ÖE&X„%>ÌòBm`r^%Rbü²Bd’m#²a!²VÍæø!dÑå¤ÍçÜ\rËÏRO'€Î§¨o­ç&òS&R‚@ØQğ9&¤–gñõqøLìÂÇLcÉGb{j{g»+ål¼…@\\ç<B|½bàüì-‡´\"æÀkD–Áë&\n´‹\0¶D·ñÎš¦(±ÔqÙËÄÃL8Õ’°ŞoˆÀNvª¸\n ¤	 †%fPŠ¼Ñ å\rën›Ktš [)¢Vœg\n\"ëÔ½€N€Ë\$îWàÄ¤d€¾4Å'r¶\r†#`äíÅæ„\0¶ÎÇ²6ë@Ãv ¶»Ìí(Â\rr’„³–b\$åÄ@ÀÌ[fÏãk9Ãr7`\\	«8ŠØ DÀ\"àb`ÖE@æ\$\0äRTÃ&‚\"~0€¸`ø£\nbşG¦)	=@À[AJi¢å8geÙ`d°§ªkó»;ë`«€ó¦Áô7\"€z4F\$n42ãĞz“Ê7 IóÔ ÓÙE)^ÑŒË8óä€Î\rÅ¨°°´N±sq0‡¯°ÈÓbPşîñ˜A+I:`WÿNJmI±W4<nÖPÙJT¿J´·LbTî´JàOCĞİJŠ€¨ôfÙ”XN¢¬=…â«Q9´`7LæØfùO“ŸOÒzÏS€5ş¾ø¤ ¤ Î£PÀÔ\râ\$=Ğ%4…dnX\nÎXdúÉ‹îĞëòOàæ©§¼\rÀ¾)F¨*h• ön Bµ5\$˜¬µjLbs¬M‡;+P\"õnÏSw7³QÓƒ8‹à#jÊ\"óåQDn§ÖfgrweçWâ%)dŸXH¹W‘Q\$TK`’5…qÀúŒHØÉì\"ÎuÛ’kVU‚RCH„È7@¶µµ1ó\"\rŞÌ'ïSUÛÓ’f“—W•¬¯Í4•ß K0nŞ;ôæ=	°·	¶š‚›ÓcTËœDèFåæífXõ]³¤ÎÅæ¾µÚeŠLqÈğFE\"¤Àxx\r(£î×\$¥4ãS\$)F	J­tDÊ•DE(–˜EFê&Tîv\"¢*`ø>£€• |UÀÓ/Q¢ÙdRÁævÂè±\\ZSŠ\r¶Oaˆ¯ÎÖÒ6¨¶n.Ö±\rem­xÒƒ¦ØvqPSÏ]Ìê±\0weèõOt_Pcw&mjo€zØfì‹@ûo…#oÃmO·%g¤„÷`Û=3×m­D?ªA/³]5erk':uj|€@wH›3s—Æã;¢”¢vèÊtËv¶#–»kâ¢&¾ØcÁ_Àä#Îmì¬åâ^c Ä²)nÙjÁ\\Àğwbá€¿_ÑBÊQ¦—RÒ†İ= =çï/ˆR+MšÀYx÷’9¸ÀíT\$şzÖ9a§òÒ²È¡2¼¹ ø7\0¾&ŒyB\0(ÒÒÕl\"*>Â÷ô¿÷ò´ºMØX‹@)xVWÕ}Œ.K²`T\r@Â  Z¢¦'–«-IkHó7ÕŞ5b?ÃÏ‚lª>wôdÜº`¾¨>\rë€”Â}xZ¯8ïË`ïÉ‚Â‘‚…g] Qd„gˆ•O_Fn†dLv54\"â2üxwWø…˜1Ä[2±2Kë€uL%…Ø8¸¬µ÷‹õûó(\râ-‘ÓØÃwÑàÃ—öeŞA5¦§İhWÚ>xfì(¼˜w Ízx-vÉù	ÕV'L‘ØvòRû¹’”!ğvV0é“y-0ä\r•W”¯ºÙøK‰€]…bÌ–Oî’\\à¾0Njé¬ÿ‰˜Sä¹‰•„ÕD³Ø¬•¸ü\r†g3ù‡lQYEwdÄ˜·€€LÂìX'Lbò®ÄĞNÇ¹JÈ¬fÄì2ÆÄ¼¬{’È8È ÂÈø#…xsˆ˜IdµE•£w•ùÜ¸tÉ—Á/È°=¶UTYvGG+‰˜“•uÛYŒô…#RJ\$JP)8Ø¯ŒÌ¬Å¶ŠJËKé¡…xäµ0z5 Şcµ¥˜Ù\0n7¢Å¨Œ¥•YåTÙé…9`D–ŸÙu_Yy ™‰™„#‰¤¹n:%…ÆQ’Ù9Y¥…™8ê@îÀB«—i Ùç•ØU¦€Ú^9ÿTÚODù—Ú¥TÚz#\$où‘¨jó¨¹›ŒàO©\n'©YFêMNË*»¥Ø—„ùëª¶ŒÈz±¦øÙ§:½¥åc¬:¬š…¬Ù–Ãš”z)¨º“ù”Ã,u†Ã0»Ä‚?¥–ÕÛ!Äµ~2	¢{ û%;–ÈwÜV6ĞyÔk›]–†~Fã­ÂŸe«|Gº`Sh¢Õ­»ZOö‹XÕ·™ñˆ›X·¸Yó·ØĞK—şËw;¶L\$»×p@Ìkû*` ß³,ÏZ?¤8Ëºú+£ÀÉ£\$Û¡º9{¹¼zA¼º7-‘n«¡{Ù¡É]~¸¼x_—ôÔì‘jÛ Áåæû­µàVÖ­¸»dñ±×øá;¿Àœ\r¹z9lõ¼¸ñ¼ø»˜ØíÃ\\Wøcºw®Úeû“™ØxK‘Šì();{¶gÏŸ˜‡dÚq Jm§Z¿°<:`§ú8¢«˜©¢5BKœ+Uì#şóL…ZI¬zM™ ¢|KTZé˜aªšg¿ùsÆÚûÇ»TZ°°G]Ê©=øé‹Ü3ŒX©Ëº%\0ÚZüçUø¨ZnJ\"ÖX\rX¿;ñ‡¹Ó¸©š®@ù®ÑYªÈŒQ›#›LVÄ9ºÅ\0Û›ìcœLpÅ#œ®ÈU=1x¸Ì)œ«TÀu9`SÚ€¬!ˆÜŒ@¼\\ß«%c:FÓUÜëÎä[Ï<ö<ú…>T;ï¸ĞxÈ`ùĞËÇÑOÑ]È}Ä9­ÒyÀÄ™?œŒYÒì3Ó=%œ2)œls´]@ÇùÑÙİKQ€`ÕecÕ§§Í‰’YŞX‹×E&“™g\r†¾@ä¾‹íŒËø€6%=iÏçìQ|g¶¼™|Î:9*÷š5·ŸnÇ~9ük÷+aÀĞ€f(\0æ¶+5I¹5€Ş·ËÑÃµùÁİqØÅæ]„iet  ÜNİŒ ÛßŞMç-5v3åsaåÜ?ÍŞeÎİ|R>zØàué§¦½^qçQ¬NÜ×ÃÜÛ{Îgéd\0rÈ‡~{ì4¼—ş~M>ƒå>‡å‹¥êş_Öåé>iç©wìIæÊW´>úõd¥ub?ìÌü¬Ê¬²AP\n'ìr ?å@TİQpÕ†KDÚKˆMñÉI6@ZMIò”‘Iõ®µˆ…a3¯X	&U\0–`ÚVqğµGvz”¿¾¿N°¿OßÄâ?fÖ+‘TúÄn\r<§ºP¾Š?c§s·<?úSÜ0éñä¡ò\$ºšSˆµŠ'Øçb}`Ì-‚`Ù! Ò`ø:Oj–¬FÀ~=TÚ¡µ’£ëílLşå0Ò¾‰å¾İèşµî^½êìØş¥ïTÚ5âé–¨º¡.Oá©˜òP-Y÷Ïä€XK›Ğ\$ó9+„ş¨—6	°Ë·\0Ğ‰œëÿ.ÙÆMO\0‡Æ¿©ü¦ò|ÚÄl‡ä/¾1¡‘ V˜×¬:ÙéKzS×¾ö§½\$F\"ó×Ñüşç´?À›¯ó{k…İjÆ÷˜ÀÑîowËİ_úPg½«DLk–Q¤	¡\$Ö	ÔØkLÛÂÕŞ±5Ã/Ñºí—2Ú¼ÓÒÙì€ÈÀ_}B£©\08 \\€n\n8VÚk\\…`?°\nEâZ…b±-V¡ètôS6µr_%„å¿À÷ÈŠÁI…idÀdØH^ŠsCIÙâ¤-™bÌ„Ó)[±	X6À¤rTj£Õ\")³`ÁÙ{qBùğÀ¹Â7‚VüYHÉ†Ë™Jğ¥†U¢Ç÷¿¶ùAû|†\\š¢Y£”¼E±Ã¤èj'LÊ*kF	˜Ÿœš¡\\€è˜#…Cô	OV¬,á!êHá \"f´(ÀZğÏûÍ€\\§gÜœ\0³Èó pQÆTÅ=ë.!G’8^ltkŞ\nkxZ¯G|Ğ†‹ì\rª—_ @XµŞ<<\"ËjÖ#E:=æ\nşg˜Ê â­–­œ\"ORÂÖâòú\0†\"¤ù~*\0úeVÍÄÌI¦¹T) az·„\\?4>ªåxÂûˆÜ¦ç„¨Ğµ/™}K–ğh@ÉëK4xy\n—Æ˜Ä9\rAı\n{<â`P•ˆD-=o7{ĞÕŞâr ®†\nj•Tº5ƒ|ªdg9Í‘RGyfÍ¾3¹\$±±x84ÏŞaÀgÎ<Ù@bşŠÁÀ¡ /ÒÒ’Áæ\r\"‹±~^!¡5#¢.pHhs‘âòp Èñ¤dq'¸7ÈÑ—X‰c5Î95É<h€F0Æš.Q°Œ›cTªD®Fz3\0 {ÛØÄÇÙF|óqµ‹ümãr§˜İ¸ø`î@Q£+Ö&/‡›4b\nÈÂF,Ñ8*Çâû@œ·ñŠD¸	€Ü=¨Á€u	(@aö€Œt•ª\0¿†”1éiÚ\n’šc¶“©Bñ­,hã<à3È%b0\nhFw È)(ï*¹XV\"œ\0ÙÉñ}Œ4™¥N·u¾q×Lpã·¸[ÇÈØ2(üŠƒğÆ1”H²/.yæÀ·u5ÈÈ’4	”›ÌáÕ¹:A„‘ìbä~ÀvHRD\ró›×#yG\nIjFx‚*…rßLà¦ÙSÈÉJ „8@aJ\$rcXç0HÄ€_hãC\$YÉ¬'Rm4ÀàªĞ1ÉÄà’s“¬mBd0°»Iè'cUd\$â£‚\0¾Pé\"€}Ba(€/ÊT\$B“˜\n‹·(éNÊD'{„|B~\0™IÂT°	”Ö 	P,Pt•h]%+ÖÉ“dÜœ)ğğ»ÒŸ”,«Y1&©_IÈòÁ“´heÉ;†ÌËÕ•„edË@\0‘@àAhƒA&)]:P!ò¼–\\°£k,ôMË\\Lq•„³\0E,éPKDBŞ–¨O\0Á*ÔïËÔòRWHÆg\$¹sLav‹@‡m4Cì(ÌLFxà=l‚ bºh@ØPİ›<9õUñ|_@\"¹è¡@	À¼\\éŸ0	€E6p\$8ù€R &b@'Ì¼\n P>9èf^@\"Ì¬ô  1ë\0›2ğ\"`\n\0LÌTÖ) /M&isMqZy•L²eÂˆ™4Ìfg3Y”LÀàNyé¦Ÿ5Ù™Šf .\\-ÀS5dé€ü\nÇŸ¨@§2ğ'ÍT“;bhPP, YÎæz|Ù®zpÓ-Àî¹¸M`³[š„âæ‡8éÈ2ms›À®{é³N&hBœÑ@ÙÆrqó‘œùè§) (	ó1LãÓøå…0	ıDŞ@øP)ÌÄà|Èİ: ÑNFo3:€6x[Šk3-œˆ\n¦~)Rf3-€aç§9¹È€ştÓGšäôg¿;°¡\0¸S»ié€øsÖLì\0BÈ\0+O“eš\0§ç?Y¾4	 T›z§!>0M²r31qè§c;0'L¾e`F™¬ì¦œ)©ÏN‚uğ°”Ğfµ>€Ïªws÷ŸÌó§ö)şÏü” şÀŒiÍPT TçgàùùOÒ{´™\\õûB)ŞĞ¢Óô¡XhJPÂrt2 <Ñ¨9É«€ş„“Â¡Üùè>°P²‰\0O¡}gC:'PÖŠ3ü¢h«AêO¦‹\\¢U(¿DÙÓÑ>|4Z™xèÙ9©³€‚Œ“şŸ¥(Eª\$Ñz€Ó‘šï&2T­€)á*”@£ƒô³&\0°A®QøLÙ`NâşŠ„9ä”BÓÌ°¿ÊOª\\l|gkªc0«°>ÒLˆf¥RÏ)ÙõAòR\0/\$XòEÎ)`È… \\êkÈ®Ë¸p)õG¥TèÖ„Gdó‡´4—“E2Ãrp Ïª—ÉZÜÇ6Nà<€ö•¡]3‰Üs©Ò‘@l`‡æ(ÄP'ˆd!Æq°ÅD	Š¾bàm˜Í8wN ‚†ÆœÁ÷#<Jéö(\0S\\Cu§´ÇVškÌZc\nº¤@îé«N*x2\0„”é§Xw×ş‘@Óä”ÿaµEÇPğ.iJ!%D@çPªzÎ¢&l¨=BiåP°-ÔŠc|ZºjAS*”€ö¢ƒx§i|*2pê—Tácq©Âz@à¼!5/©I¥Ğ7Ó²Æ¬FÈ,t?UíÅ|©\0¶¢4ìÔj£“ªH6ŠæêÑ©€ÌNà…HtDøÀù3p'òqS<›ø(,é·—\0[åª»™jèé¯MªwóÍ<ÛÅÎ€ÈÂİ?‚çux\nÀY<bØ\0ê¨´ÃE^çG)ÍğøÓ|›ôĞç8IËÒóo;-e«0\\\nÍÎÀí=¥èL'„óûp\0{XÍU07`,,S9§…y ä÷ÀP|iìOh	Ó-Õæ‰Dà£Í²²áLSY[ë„:‚Ó‰v£÷¦Õ%&v9ª4=O¸AN¤›t¬¯1ëĞ\nõ\0}T·U{¦^‰MSRœ*Ú©BtVR›×ŒQgkzİ~@À	Ì\0¦Áğ·–Ëßnl±‡è„µ…^Y/•âõYÖ¤õßWÍaQsaÊ±XŠÄ´ç]cà,E`Z•X™ñö0«0¬mRkX¬8#Óİ[ªàéØR»¢w±€üÆãP\$‹HKÀu\rkÜB µ—éŠ‚uN¨¯™ƒëQÉP¢Ş6cF\0Š\0öÖnË r²Ù!ËŞ;/Œ=¶D®ı˜ìËeÛ4Y€A5]O*¹`:ãĞZ`fĞs,~+<×\"dUË3eéî\0 …§fĞ%…°Pwì^‘H×1` ‘’ãØyYÕqâš°œò,^jø\nhK#4pîÇÙ1Òø—ÎÏv¨˜ùœÂø•eZ¥àb)2±lç1âù®×m¤U¿K\$\0ºÁn…t/¡n§xŒZì‚¹¶8®mEjJ¥­p#6F~E²(êù¬ÔÖyRÓå‡°%B7Ì\nãV6e¶TÎˆË-jÀbY˜²îí•jä‡³eä´í^B{6U\n™@cWÇÇ÷nÊyÁCä`u}yiV¶…tÜ%0bŞJ,p)g1•ô\r…îVX@R4;‹\$V@=s˜®şx ÆŠºPşÌÔóH›H*IÈ¡X1u†iÄ;á•¦Øp¹QÀ¥îq€€ôÏ[µ |æã(€®ã±`+ØG]rÇ…ö‘\$Oªµ9Åd‰ZílE¶	ÚÀƒNK•âz5uš5_¨!Wp'Lâwõ|=ñÂ¬.Iäğløv€«Næ‚åOàP¨²Z\n]‚§£«ıo+?ªÚO¾~'®­´ğè÷DZ#ÏSÇœ}Ú®Ùvêî*láî\$°BÃi2E]Úc‡kµ]ÔËER\nˆØt—)d7ÊfLµZ„êœ.åxiÇU÷/`¤¼½”Íz`/^ ª½b5ˆyNvúØâÄ•+R%åÆóUá6ò¢6Ô•TC¿U;ËW.«/¨ólQ`X¾»÷Å®]­ã|µt¦ú1ˆí\"æÚG6ÍåbíÇ+ğW€/W°e\0kà§{‰ªüÔ˜`‚eü˜Áà?d@À(N£®tÀ)¬\n)aÂ¬R>°ˆ_!Á;}Ff3¡\"©\0\$Ş%šE´a,Ä€RÀÊğ¹‡%D¯gƒK›oÓ!4!ŞgY20_ü‘¸	ãXüî—‚¡”XÑë	8r¨©¥ÀÍ£“XÊFİHŒ `°*	Ax…#„EÚàÔÃXÁá:†S‚ƒ¸Œ¥=#)¸iÚCİL(á9T)Ì™„\\a#‰€ÂñhªˆÂP(ø5 T.#Ûq–_ÛËØZM>Td=\0¥}á	f‚F»†1¯2üÁBJÁ˜C„+X³#5ŞÃ‰2-J¶P\\Â+˜Š‹£°Ò,œ6aYÌb3]êo@œ`c}aÃø6Jşb¤\\FºÆ&÷ÀÒc\$0„Õx’1+ˆññ”.éO q_ñ\$ËüWÙ5µ%„†MÓ0W† 7b§\rØxÆ†,‹,BaÌlX¶._Ğq8?‰-XÄ+°G±†,d”ûá¬ÁÚ`Óq1®Çé˜õ6°¯q<C\$e)¶ºVâWÀıcûa²ÇÎ 0ñ‡ 2áğE¤'ÃşÓ{‰0:bT†Gî20¿\$»hâÌÕša.8ƒõ,CÌd£ôÇ€Ê@ZVü<#X—_‹1U©¡•‘óì%Æˆ 1¦±x\\XêÆ72yãÃã´É°ÉG‹DY<â\$‰½É0H€Ó’¼§iVYN(šrwŠìX+Â”øYÂFTÄg•Pe\\~pÈX-ñ©ûLd++â3Éî,qò¿Kñ•:üB€®YO•ÓH‘±`Ox\rÅ´2r²›p¿x<Ì&]ÔU˜œàdªb*´\0°Iø´àÃ09‰Š¸x1‡\"“\0¹.,À†‡Ö7ƒD3ø}bŒhÀì[«³2á^j…¶ÑŒÙÚG*ÑÈ.’”Sûæxµ!¨ÄŠ0:	(?‰	^ûÈ\0x2‘`Í«7\$I\"ÉHò´’´“Ä—«ÉIq?*Pš T¾\0‰T[œc»8ğˆ'ÒÛRÈLa¾\\ BÚÊc\n€,²¦Ú\\ü–ø¸–>gğı(™™„Òª\\ß[õ¸6jŞ‚@ƒ0›şR?¡íĞuSÂÒl›:ÈKÃ)Í†„&¡%hæ@\$ğĞ ³ÕQÜğ•‡@DÍÕU&%½äuRz*'†‹ˆş/¬ò	+<Õ0ğ4\0LÁ`3ÙwÍéRmPRàä³à`×Q˜àq’°5ı%X\"àlY|É¥Gè:U¨\"¬´°\"´Pép° !Òp\n&-àòfˆ*dilé t™N,ãJ¯ªôR2Qp\"\\^\0?ˆ€“m„©}4måbÉÓj@Àb01é§N!Æ\rŒQàR§N—Ï/•´îsº³O±¹¨EfŸQ€dÔp\r_©/¯D\nGÓÈô÷©½?‡'P:jÔ\"¼5@-½E[T´İÔN®\0Ò¢V±—U:•ªÂ½©>DFØZÔş¬õs¨Õç\0·YÚ¿Ö])È†üjˆ„K#‚(¡¬ímkB(º¹ÄYct.<s˜\\¡Ş'p)ÌßÔµkn¯ÓÒû‰ôÄ«İ“¸š¤f‡Â×…¦\\ë^~;t¦X]yZàš\rn‚´=~‰†lîQşõüGıˆt£ûØ…#ôÕ~Ä‹kÇRu=®•öF½!x\"·ƒ#µ\$Cèë¬7-™×«=´Ä`ı\nı§ÚfFº—<D‰”\\	®¦Ğ\$\$p)Ú~Á+g&ºó‹J]y-h\rš×åùïÒ€+æi—^›#À5î;Ğ9T¢ÚsÙ|\$,Æpl\nÖÙ4ë¶cœ\09/&ËöŞ³Ÿm%Ù«\n¶n¿A,íˆ;EäÎÛGÂ†Çpé	+(¾·ü¸f{&®ãÖä­Ó=n8¢Û‘(X¼Èšõœnh;JùÜ A·‚´æk8\"wfçò1ºÒ‹Œ5€)WKaºP4nœe#ÆªQj7E¹—-«sÛcİöåJ-ºMÌï;[¨/ Å´\\¦—d¹ÀVÀ7`­×ïtÛÇŞÖîw6=Ü›÷ù]:x¶	‹¡±1ò9ƒ½[,HP<OZ€=Åëµ™3O–¤<@e+yÃé­¡xëOX·ßµ\0w«4Õ°Âi¬ØæÕÃù¬àû)Ë\"Éapöª^îêöÛëQpµK½Y‡ KÏİ:±®u¯™‘»jº×ù„n½œìç[SŸ\nö.Ty’˜úÿÈ…Ë€²%Å€ÀÅ~ ÀŸ4\0>@ôÚğ5^Da”¦É€‡=„p06yÄÜJÍe›,RUÎ±7EÉ8ñÖk`yâ kSÒıïoö)ÏbõÖ±ôƒiY\"ÓØo\r¶;ÂĞ…é¼KêÀ˜ŞñÂ5Ìm@ÜÖ~©œgm\rğ×aûW*\rH0/ıq÷°bÍ^‚¼šÕ•:¤–ÁjÄ/›œ­£)Ë°¤.<Ş¸Ê¸2b¤³5˜œJâÆLãĞ·€{Àİˆ˜DZ3q24røª¶ÛÜ»#ùXykÕñcå¾·ÎÙ  E½}=7îÔú¹uæ©Å1ôìó>Ú3Ôòˆ\\mı`<¥Z?7C/s¸Ú<å½¿&>gntäc&do˜ÿø4\"Á;0t_§5ÂFärHrÜòÂ0ÁˆO1ñêkkºiçN¡bvi¥tëƒšº^pßuµÏmEoÏVOFõ™È\rZ¼€Š4_u€8Î	‘§ÜŒ·Ş¢¸\"àè\nğ+Ùn•ÂxäF=ô¤9+Ø¹šn‰æ§’˜Àÿ&½¦~\rt7rü£9N(^»“ß'ğJ¼0ŞW/¨äá*©7›œÌà~\rY›¦G+°pRnXáË£ÚïWJM±ôƒM‹ÙÑåå-óüs€º›ıCÎãÉÈ5K… tÉèìDÓÒİ\\t¼8,°èšsEƒÍ¡²ÀW pÇz]ÁÀ•ÁºİJøV°\r¿²}•3ÿc‚šÜ×•0=OÌnğ}pîDèw_¼w@úå1º§¯‚éˆ·zh£â(†‘=‚××O4%ÂîméÃ4¼‘Ö×P¹7™,òs¨Ål×'²Õ|åã7}ÉJO`ú¨.}™Ï¢\\~ä3Æ\rö?~yŞ¹+à=ÕçC;ÃÈ=PôO\\BŠVÈ)\0'B¯qû:¶xD·‚¾Réª©ävbyK×Æè¿}y.ÍcéX¼ÍrG3™¡Ë&\r³Cš0>ó|†ßMJŠ#@÷Ü¿LŞÀÕSØ=\nq×‘{ê_î¾Ÿø\rV\r±ğP}|\0DÅs<6-¬#ÿùIÔà6fÅªêûñß­âlî‘%@îFb)‘£/øÇFÑB§€šàØeš4+ŠyzNíîËåbaûüù’ÌEŞígT|¸Lß7œ\\ r¹Ø\nî4€).Ç!n/Æ”ŸÑÕ¨B@Ã°¬iL°ÙÊô5‹ˆËØ}Gå?7€÷Î1…F/WàÄœc>‚|~+èø\0ïÎÇĞ\0ºqÖ¾L™úê]Ààq¤d“ANõ¦F04¯N\nsÕƒšõ\0¯ˆ`¦¶õ»Ôg¿1:	®Á\n Ö>€0±Án	œAÆ*OwõNÏï÷\"°°ÿù½ùÔÁEeí]å¼Ò…ä÷ö÷Gî]ïo,e\"*v·7Å&¿i{†¬Ä\\»Œ4o<ò–_bØb¹Iœõ˜œâ1—Û^ÜÜy­üsåÌîÍ6ŞèİĞUŠğ?\$m·†Xºøfñş+î 9÷œI^PÏA¹£¿~-{âào³ï½ıÍ¼ŒîÈrB.Ç•Ã‚\$ªdï9—›Ã.‘ƒn\\+êOa#á\0Äğ€‚TèH7Õãloµ~¯‡Wáğôxˆš+ñ.ù€YWû+ÿKÿ=ùÿĞ~†}|=Àµ tô¾¾¡ƒW&dtÉJ(µ<íİ¶ãš‘<#öìTæ¡}oJz\\Ù1<%M1módvà¸¿˜=ıß‰æ÷×áƒ\\#~Ø÷_â7µ9ƒİa®\\R<k÷9¹ØLi•fI0K8–'pz/-­DÍw’f&À®€ËãÜ&~+¤~!UdRÒ‹à‹ DiŒÂ‹\rû@ÜÜcøüÈnqB¦¯|ãM(ZB/ğ×!Ğ½#¢J²»Üp[|	+¸®cˆMRb*MjÁwÏŞNàù€Ç²€ î\"é€F?ø„ÿã#ùH«ı¢U¤`Öã\"¯hÿäàÛüŠlÿÃ„aƒ\0(¦Ïÿ<¦ÿ£ŒæñˆT˜nÊ?ÿ\0c5Âw\0ÌÚ˜æ&\0›¥ïÓ¸;çá&³–û5f¦‚hZ(k#-³Ã\0aeà‡\0¦Ùaº\"?\0[00½Ğøø²ïí<¦İùlo‘¼\0005{Ê`ä\r†ÒB×@<´‘áÀ7>`ô”	@Àù¹p(>DT›„@ˆ¾ê+|\nÂ³ÂçÀ5zCù.p‚åû°¬ÕºêkÉT†âÍYJr	êÂ¶ñà{ÀÜ,\nï‰³V¯›B`Àö¯¨°Í^›ë[À3^ßè„ïí@èÑ\$â ´¼Û®­†(ıd®ˆ¹éxw@ï9 ÈÉ4@ƒbqj-	¬²ôÎÄ»xË·Àù»€*ë\\¡5?,ÉX(àö¤ÎƒãiE\$øØ)I30\0R`¿à„\$Ø”`'O«‹ê\r2N&OêGà€T“A—©Õ*R\0=¥ˆ	à¢í¤*à.é\\¯ş“èzğk¶ã´	?œ “°»f2%Ój^i@€^—¼ªM¤â”äÂú„%x‰H%<Â(.ÉNAê.ÚVĞ[°ò¬¦¦N»Õ\0B×ø3\0006 èø(à.í‰‘ƒ!Â;1ú¬€Ê¦¸>°\$×k“á@Fœ#@Ö“N\$!ğa\$ã’N`‚îä!¡]–šX\\ä„‚RPi€^8À.¦è‹L¾2””a}Áº/¬ ã	AÀ“t#©AˆœÁŸ…Lc³¤-\\ŸAµ™Ú®ÍB“éU¥„ğ§	\nŒ\"¸Â«|PnAy\n!Ñ\"®A|“Ü AÆ–tÉs¥J^ĞˆAİĞâí¥¤ğ~†•´ &§\$â’N`\$â;:T\n[Âw	èàª¥ù\n\nEJë4ğ_Â‘Ã‰hAÊ‘Ìğ»¥é\\/IWÂùğ%pÀAø¬ĞÂB³:SğÅ'bN°Ç7i„2P B°/ª“p·¥Ú]şBS	\\%¦‚¥	„&P´Â…YXçB·Ä)d¥\nğäï(“ˆp›=HP82 ¸Ã•¬:ë\rzOÉ@%	´2pİ¦³ªUiPÂûü(eı’'\rôÅVBçùPĞ‹ëÄ4vÃL8\"R0|CTœ5ÁÂ\0:’âĞìBõxRp”%ALpËAœT>¸¥Ø,\0Bû)ŠYÁ÷iày	ƒjÁš60İD\":‘ñ\nÃ¸&pĞBíÜ4pvD/üD@¤ÆC\\c\"qAÛ`‘\$ê`0¢J\rT-Q	é\$>ĞÎÁÉŒ?1“½¬4 áCOÒS°Õ‚í3ØIX‰(Ø@>¥Á¤>0tÄ]\nä: ¨CÏ	0âÑ\"Âl—¼;ã9D%\n(>h‚xx5¬×¶¦;ºØ@7€ô+Ñ\rîxB‘>¶˜à\"'NxØBø%²nl2‘;B³Ê\0ñ=€ïØÀ;€g0à€¨à,	˜AåFÂ0'¨a&€Êh…ÿÅ`6?‰’°|¤éÄõìO¡õ¯ÖRc5±A©Èû\0Z‘PÅˆ)—€”`Ø )Â^yQª·‚\0 €Úš^fS/bLME–YÆ	ëˆÁ\n {‡a\r\ró€1eE™8ñh],Z‘t˜ÜQKE:#È«±oEß|\\‘iÅÏL_\0ÿEôcü]ÑpFœ`QjÆ	X\"ä‹,l6€Ùq„Å›\\ZQsEªxîà†…©dçÅØ™üQğ0Åº<QÀ&Åş`;ñ“ÆSCdq—E\"r±™FT¨Š[1v…5{÷ŒFOØñMŠ1ôTQEI0	‘T‡R£zÆ-€*qyF3¬Zà7Å²ü[`’2H¬g1§Æ1¤\\ñªÆ¯Ìk`<ÆOübñqF¥Z±±±ÂA¼Eú±³ÅÿT`1E­Ämñ¬€ŒnÑ…FñdoQ·Eµˆ8ÑF\0œª’`9GL^1¼Æ©äpêŠÅ…jÇÆ¡p‘ÉÆ­ìqPEìx‚Lƒ;Elf4BA	¤kÈ51=Šàx\rà3¿È”@à8\0^/øB@‚T§\ra«F‚Lw±Q»Beñ“µVH¡ªáM48CqâÅÛ2`£3Äîjrd¯ä‹€0¼( >B‹PÉï‹­º®o¿Œv8'P±û¼i°Â8ÈL#É€ËQü1&ö32À†}*AÇˆŠBeß6Î=POàÆ\r»\nÉß€¨0MÈÀö€&\0œ’…`'H¡X	à#€e l‚ ’h€	#Ú€¢™ (6H<™¤‚ğY¿€Ü`H+2\0İ €RH„à€ù\0¼v\09	!ˆøHz-‚‹€øÀğ;AR\$\$\"iiò ^#pT ¬ƒ	(€!G`…±º\0ø+h2FşÍò¯ÑfH¡@a/ÈºùÒ1€ÂÕ[î¡#€øÔØ‘Å€ÛjqĞ¸’ÙPHâñÇ0\r@ö¨Ï*îD0ÇàßªüšwÁ«zò»Ç@2H¯\"ÌŠåÿÈ°”‡LÜÉ õñÎ…!\$|‡@)€òÁ J5ÜÃì“DÏ\0“\$Ò: ÖÉ<~ùŠRQ>ğé4gíEÌ04”rUÉLM4JMƒ½!©à>²4¦r³\$û+\0ŒÚ˜!²^†fğ0£ÆÈf¶‘œ‚!ÈnˆdÜ6PáRƒ—\"ÃåÅG´· h íŠô†¦“‹‰Ùâ\\Hnºœ’ÀÀÍ8Àr ;¤Z˜\0ø#ŒšA,…JÃìÀ;,Î(0ª¯&˜´’\0¬›D/#»Ø/@3Éù!Óçà2\0òvywĞB‰ÜÀKhªF‚hÀÒc±,£\"JNGaéœ„O+–³ÿ@;ÉH8éG²ŠZ~ø;bJ:* <ÍşÊP24…a\r)&/¤†òƒ)å\$„f‚ñÀì–ÂB³i)ê‘Àó¸@’ÈÊLóÿRCÕ(8’3‚Ø˜¸gñ¢L¨É›!r?è˜D ıÆGT²)‚9*¬¢¤Ï\0˜àÒ¥Êo!ÓşÁ&Ÿ\"¤‡Bê€.q7c‹¨ÓË2€:\0ŒH¤y‡í?—T–r¿ƒÌ™‘Ùè\0ŠÔœ°­ı¦dTi> 63_+‹2ÌËü’Š‹¨ !`2€®À½òğ÷àOò–|Ã¯€ø+Œe€“\$4µÀ\r@è•’ ¨ì\$¢²`\0È|±î™€ø²D´ ¬€È×Z°²CKxú|·ÍGr\$¸oK}L·`Œª-è5€+>CÑ©ÒêOäŸ\"ğ€Ó+¨P†2À²l­ìô\nï+{ÿ@ï@ÚT\0 ï;#(ˆ\"!ƒ;<2\$½ :?ù+qüq‹ÄÈÉ„²[Ió|¨ ­JŠ¬ÁÈv6€\r’Ø†\"ôâ»Š\n„”b(”ß’b‚IŞ04ÀÃJ30˜5²é&.g!+òóÊxJü½`>¿9ûNÎW1’ù€Ñ1UÂwJğ4ü—¡ƒJ¬«p\r <ØaÈH@‚Ì ¸Tæ©ädÃÁa–TÇóÌ|§\$½ó!¤\$§\$ÅFG–£\"hMRÈš!¼¼l™:%šËÏĞ¿F£]°._/Êb2ËÈû¬­êMÊ¬íè—ÃŸµ` ²Óƒõ+˜Z²îLÜ×Ü»RîK¼ÎíÁ=*´Ï:Ì÷0 \ns9·ú+ †ÒØËZ! ®³*=,!_ÄŒLü0Ñ³<Ìí4Ò3GË»4lÀ 22ë%³_\"7\0„¯¬–À‡HQğBB‚\"Ö™®Ô3a4´Õ0\nÍ%3ÜĞ.ÓÍ]4´ªÓY3_4ÌÕ°CÌ´ùÀ™f…5ÄÈà6\$<|¤U–Ÿ3|Õ±M^t°“eMi(¬ÙÒºLş\rlÙ²ªP·ÄH÷¦/!Ó„E0?6Ëî€5Í²@™°,Í³3`¼p!àÒDÛ#aˆü`dİ@<Ê©6Ë5ª4õ7 \$™ÍU7ÂŸ'>ƒ‘7¨fp\nÍ¸tà\0002ÍæDÂVÉòÓJÄİ€Äºp’º‚U!XÚj\0Ø6ªsÉÃ8²°²òÄãÀï'êÓ+ïŒ*Å§(ÀÒ ıIHÂ8UM,\0¡4iœ„àÀ¬°	áj†pÀCïÆ6Š·awÒ¢€ò'tä™‰ÜŸ«ïí-´¬¼œ“œ„.~À+Ón\nò~ ø„şª´çS%òtäÎ®Ÿ«^Í+?	9P¡é†„¨¿DaÊÑ){AÉ£#ìÍRYÈúÒäí³¤¢Š|Îã4àjÀ*É?,A%\08\0 ”éò¡ÈVû@;Ïµ/¤+4á\rÌ0@[ÁH¦£\nÍ¢Á\n#L†¢	0û<¨ª3	GÄaiàÚ¢&Ú*òÁ­ƒ\ns Y!RÂB(ÑØO@(¼«ò)¡.ê«ÅÎ#)³jr„æ×hR\nr5W\0t¿ÓÜ€Ùx[Ó	\$#/#\0ûÏ;.R rkˆ«,œsÓƒZ˜`\n“ÓË/=I»2RO¡>¤¢(\rÈçÜúÊGÏ·=+ê@)H…>z‘óñ\0î+úRö49\$1v³%ƒƒ(\0!BâU%\"¹DP¸w3iü¼.ëù2Çßäe“ÿLàIÀ•O’ÑT\nÃ2kjqŠO)@lğIyÈtè6 €Ïg b%ä\0ÏôÛ†µÚ(‹ÌÌ…A\0S&Î(¸N˜(4H~Ğîäú†s@-€5˜`ˆ3«(_È L“`FSĞ2SÉPzdÉª‘¨™*sÊw2±m¢‚jYğ\r”&JÜìÌùR·Mƒ@¼s`¢ Äë3\")ÉBüë”1\0ÙCıÓ®­\"H5´Bè¿@‚ĞiØ\r”Fz_ÌıóÉTâ-•N\"	P2p‚¦+I‹Æg )	İ%­\09\nb(ìıA™É\r|Ô§ï‚ê2!æRqƒY!¸Z€;¾ƒ3œ®aªÊˆ¼•O8tàŒÎoİÊˆ1ÜÁU;!ì®ÏLDØma\n\0ˆGd‡‚‚%B’BKôO@Í8Ú3¸‹Ç8Mó„Ñe6ÉSÑ_6C¯Ñ%+FJœµ.ìØ4cƒõDPRZŠ`)P\$2\$µ€ìófGÌN\r]2ª\0Èüºš ´¶sp8i0à5’¾\0É<Û*¸I D¶ÓlƒoEÜÛ3Ğ¶Š˜İÓlµsHóÁ«M²\r\\¶Á¢Æ‘P¦=)ä[,l &¬™²ÇÑ\$q9iôvºd~éœ‡-J\"á˜(¶HVi\$¢Ò*¼ŠÔ–+3œoêr\0²d‡A€O°¼a€› K&)YIÈ?T‚èŒÎrŠ½1[4Å­Êh½ó9ÑÒ“t.¬€ô–ƒõJ b:JJœ€ô˜€ÙIÔ®{IÄÎt¬Rv§%'´¥R€¥,À‰A=K],Ì#R‘J¼€ìÒÕ68’+ÅJõ,­4K lT³‚\".ôÀÒİJ%04¹RñK°9šQ·0@lT¬RõK t¾RiKÅ+›°ÛLÄ€ôÁRÓLm´ÊR…K}3€!ÒBÕ2”ÆR+n‘üÌ\$9tÀ€2Ó[#Õ6l2\"(å5ÒÿUD}7!S”ÏKª8T•\0\\\n@E€6J0 (Ôá	RY8Ä¬2\\}\$0%S¿‘Öxš”å0ÎøT¯CÓ´É  %àJ¨ÀÔñ·¤Ó‡Œ0w/øRÓ×@€82T³!ìœC¬Íš4” ZxQÔƒ<é/§ˆJÂ7\r6\$e£P;tÛĞB5A+Q\$·9M!™Ş\$ÀTõL2‘ú¥P‘ -§¢—!KD2”ƒ\$‚\$Èâ\0ë+è®eü‚B1ÜöÍ €ïD<ŒJ‡‚³IàŒ\$‚¡õ\rA?£írRı 62‘Â_<£KÑ#1À5áõÉ\rx82ÜQ;A+r[zQüÓ“^‡…) #Ò7‰İO\\ÀôL„—¡LnÅü´&ï#ñ=SŸ¼XÃ`4¯-&jÿ4Ğ™É!U?cŸ»&“hò¯Ï/HÓ÷€Â€€9Xh  îp‘”Š\0öár/lM& D/aä€@àbN‰<\$ RÕÃP	d*±€B¨2PzÄüP{™0>ã\$ñû˜0\n:†5\n\0WP¹?£Øf\"cŞ€‚)–EH˜\nå€¦º”‰‚8	€'”`\\£Ú¦ì\no!r‚™·\0)ÕzÕZ4>\0€8(¸1‰ı€˜ 1ÖädÄ,ğ«Ä#WDé]Äd.ÚXñ)%ä•J€[T½S!ä¥eTëĞ0|åTioÕJ¥Sñ™0– R`!\0ô5°€%@Ø2cÎÏ¢*·© ™  õ£×€Š€ôê\$EôÄ;ÕH‡°2ÅU‚7´\r5RÕLU5WÜ…u~ÕQİ^9›˜*8ñû%ÑX€UĞøU%YÃÁlWtJµ˜™M…^‚íÕíWÅeuNVZ;=eñ.¥Ğd6 VqXdLVFi5dÉrÅ!”2£îPâUÕkUœÖD”Ä-ĞöÂÑ¬Võ«™2¤u€ŠÅxgÂØ@< Ìğ\r±E\0Æx\rµ¹M@\rÑHEi[DuIÅuÍmà;Vã[œv	Vñ[Ğ\r•¾Vü/‚eí®‰ÜkKámW\"E\rrqœW,Õr@9\0Z^BhW\"È-`Gt¬-tAM©\\£duÍ€O]Y+uÔ×^€¦… %•ÙWV‰XQUİWi\\ĞYé—×V.pà¯™]uuuĞ\n1]ug•€[]àÙWš…tês×d¤˜gÊY]“›¨‰×M^\0(©—†vg]sÕğ¾ĞlQİ0<œò`äWd0¢äÖ¬Û]u~\0;×´Ã'Õúw_µz÷×÷]ªBAHİL;õıWãC}ÕøªM`M~Àêƒ¢ºuvClØ\"ˆ¤±{ˆa]p?Ö\n„şçuÁƒÅ`ÔÔV×‚ÑŠÁ ÿ^¬\0006×^úxjÕ÷˜6iRÂ¹×e@h\rvWóaQŒ@ıWäòø©5Ù>¤h9\0×qOíH•Ùˆ§ x’ÒhxµuÁET—züÕç„€í=„Uğ×TM !,Øƒı‡‚Š‹”\0¿<¢AjĞebc´X¼`d­ØÇĞ¯ 7\0ób¤­¦\nJ\rª OıX×\\¸\r–;€ÅcÍ†ö+\0NSô`9µ¤ôYtµÊ\0ñd-Ö@XöTÜˆõê\0Åc›5 èTš/}èÏ\0v0XÒ¥êÿÙ5c-‹@7Y6Íõ“¶0ÙA9V¨Y<'u–P…5eh[VW’)cV©—¶¦lÀ–4YacU•ÖU\0åe•…`ïL–SŠ“eM“öaÆObÈI¯¿Ÿ»fSV¶ZÙ…f İa±’·fe—öUØáG8!ÖC€ÉĞ£–j4ÙeuÑ“ÙÁbƒÑs°ÙÌíÅ–¶7YÖÖ‘¼i—¦^•°ÖiÊT),’á*W£^e„òßYÈôwL>Ùù\$Å“'ˆZ\nm öWe[Èò’“œGeˆ@†‚Ãí‘à‰`(–î…±gy=x£f \"QšOi“¶tØà6Í‚£½_¸6‡‰İiy%¾E^E¦5×H8\"\0Zêí§Jd1±iõ€•ÙZwj+Uù*ËjÖ¤\0ÎlÑ¡}Ú™ià9¢`\rªòÚjY6Ÿy^E‹3X·fm¥6‘ØÈÂ5˜òWífİ³Xà‹Å¥¶³}f%®RXÏke¤V¹ÆOhØCGîY{kÀYö6ÚÜ™}vYİl‹ö•W„|®6¼Š“f U6ÆÛlPS@1­l•±6Á…52 n}Û1ce²‘¥£¶ Ûm³V³=ğ+\"Ù\rm=°V½Xà=’ Ù'lı¶6ÇÆOfÜw@7Øw,xl`¯6˜.pPÛô7ğB€À[Hm¬¶¹„Ûl°b*¦_mà%Vßµôm¸O¿…«n*’`:[‘e5¤ÃPZålyò!ûÛ§då¹UòŒiğ ´çØû:“P–ã[½:½»\0ÛµfœjÑË[ÆM˜–êüub8Ûën»v×Ñ{dSôvŸ)7nm·VÙÛìÒ v\0E~\rı·Ğ…Ûd0à5Ùµdå¿b4•C…\r£Ù.uV#5½bHftüZ¥l¤cµ”×\\\0Iõ’ÇWOµÃŒM[¥nÕÅ!\\tx‹Q9z`UÚ‚+¸76N€ç[:¶bZ 115©‹¾q\\ñ†¶ÚEcE¾7%±Yf³Ÿb¢WMõ¯uÆ\\š	MrcAZ<M‡pŸºòÎˆÓf\rË7+\\¹c…Ê×/ÜŸiøâ—1ˆÒ),\râBÚròÉw9ÜÅ@uˆ\"“Usİ¢7>ƒsgãç\0006×?bÊÄVW\\É6V\\ët”Î†Ûl½Â6]ÜÙoåÍÖb\\ÿi=ÒÖècÓVZİtÄ7Iİ@ï¢BÜŸtuÉ\0€İ=uUÌ—KÖÍ}Ów];eØ¤ ¬3^mÅSWÅu¥Î÷[]|#ıËN\\·uˆ—UÛãu½ÙÀİOu•ÒWfİjï\r× ä\\´<…ÍêÿÑ\\›©Wdİuv]²Ö§ªMvõ7p]±wÛWNÆNáL±÷DMEtY6]Mu™Ö·İ¿\\õÑ÷yØtmŞ÷H]e\0ÁUaj†EØ!XİÑwß¡\r]é`x>÷X^f~CXbëõô]÷w•á×İív•ßºAr¥œ÷vT\nğ™·ÇKq…jô7Üg\\\$O•¸\\­qÅqW+\\y¥ãWtİùZıá÷€]¤/ÕÉ/€¾Åè—…×'C}ç·Ø¾0mÕ¦•Uu™&K_HÂ6W‚€Hi‘ïùZ¼~ÕG<øô )\n²h\0#&cUùƒ\0±AŒ%\0)r€ŠµbŠ\$<=\0ôW±€V›Êoª‰{º…÷¼€Š\neîÀ\$¦Æ›-ïè>¬ ù)•†‹{î ÌÊ<øé²¨@	 °^Ô; 3\0*«r»ÅìêİfãÚBh\nÄ\0…|UğÇ^É|âïwËD3{`(Õ\0V˜\n5fv™d“À*\0²» 3²ŞÎ=f +\0œ\nC’…ÊŸÈ£Üƒ\n­Àóà,€´-îÉ²\0¾¹3ãĞ€¾™Àà!&cVJxarÕ’ó÷¶ß|MïàÂKXíúÙ_}}mí7×ƒE{uî°†‹:o÷»_×{@,7÷_ÄX×Í&ZJo7ùM­ıWÖ_ñ|»;—ı¸”x`\"¦öâ]üØC{µï³Şö£eï×Ô€t-ó@\$€¢›­ïwş€™{ \n\$ÊX)í_Ã|0i˜¦€Æ\0Wô^í}\n	²ÕvÍÿwÓ_€XŞÍeÿ7µßß|93à#ßC~.˜`6\n²l¡rLš¸\r_eò7êß)}qƒ\0¤_5½óÃÑ_B×p÷÷ÒßÈ9-şØ\0¥‚ÂRØ^í}¥ö×Ùßq~­÷k³ß{ƒ2ìá_‰~0*×ä_”@õcÖà(uïØŞû{=ÿx&’. (`gƒÀ)`qfWò€QX ¢ZÒ€Wçß¢}úwê€‹~¾—ía ­ïwïàV.!¢àšmìWÙ_¥~¢€xOß±…û˜Rà…=üwÓá\$œÕîÕdU”<ıïcæ\0§V‚°HUx™•Zø\0\0œ*{\0'¦™VÆ`«&W{€	¢l=ÅîØa«cˆÀ&\0ªjfXkn¾\riœUy}\rÿuŠ\0{8“\0Âá¯W@a\r9i»\0ø­8“qa±}–XY€ni¾§³‡Ö—Ùa}V^5gá•Ú{#Ô'ˆ& *àGÍü˜v€Q‡~µdâ>!X\0àX›™3øŠß{¦øx¦z>HùcÚx=ğø'âI~ô‚·³&V*†é§‰‰}öà)^à=ñ˜’€W„^h>P`%¦w…EüƒÒUz=ö—ÍÎAcÒ'îp¡r€ÍíŸªò=êe€%â‘…Ö*X®€§†ş+é•I€–*¸“>Ubø•~0—úC‰€ø™bÒ^&£×bå‹ºfxâÏF,©»Uƒ€n/é¿à8™˜õJR¤(ô \$€„=¤QÃÕX…÷€bO‹f%X®b[Œõ·ø^ãŒæ2€«_ú®ĞË€^¸ã!Œ.˜»bh¼4Øœâı„N08 ã	¦—Á`ˆiàEæR+¦”šbf >\0†ğöËÁ+p¢F*`\"&V=÷À&\\¬Jf‹°b4øoaÖ­êï %€“ŠY  ÕÉ{ ùr§ÇŠ°ùw°È)\\¸“ã×¸§cŞ,i\$“=}=¬b}~äĞ#Øe‹¸)ËâR=®3X¸V5U¶.øHäş0øßàšf0ƒÓ'5Î=Y	'':i—¸V4\nlx`d%‡6A8¤Mƒ¶%J4(‘˜*Õ`á‡V\"…ÚáÇ|}*ƒÛ€¥4áráE¾.™d^\n¶’\nã<»GCÜËUÕW•_b|­F «a»†~Yd…’Ro1QãJ¢l¹ áà^/xÊä‹n@ Âd“’Æ-Àä’¾K8<É>¾Ly-b×-Ø–ä­{ryØd¾=õ™äÒ\n²~åäŞ\n¶*÷°àO|@\n‰àdï{½c˜hâˆ®Pi¥€«ŞO`¸”J)•ßC”n-É½ãŸ“ş!ÙJd3‹¸öéìå4ŸÆ/™@e’ş9Le”nJX#E”h\nõ]€œJÃÚß=Œ¬ø†¦iÆTÚ¦q\röyM§•zfWÄc±‘N;Xâà:òµ*Åá%VMc)•ås…WƒÔ§?ş@\$€\"¸	ƒæe­…Ucuå~Ö ÂÅGö	XÀ‚™†µñ[à‰V®)ßcØô‰Ó¨=~À&bˆ^ÙP`j™¾^˜åï…@	øåô ‚€€Âàµ†-ûø¯ar™X\np†aİ¸*Ùdi˜†K	ûä‹“õöù‚§{”2oi¥«K‹º´ø.É–®PÀ!\0Ÿ†pôùC\0šâ8ö‰˜…Ê=P5^`ÚšbyÀ*€ƒÆO™–\0ø½òarà>= ¦¥V®!wåä¨ú{cÓg0©ì*ïUÆb8‰eÂF1à*\0®-b’6€¦FÉÉæ¯šÎ8©²f¸\n²f7Å€œŸ¬ÙâGšši*èÍ›íÀ,fÜ.g“èà—ªgxk(p­Îj\0¦úœh¹¿i›†@\$ç\0.p€M}\niUg†YÁ‹›xŠÜ«wAN	\0_À>fH‹‘¾×ù“<=€\n€/§=&tw¸ß®¢0ö€!çR»uu[ß}\$‚˜¨a1 ÆvÙÖb¥+Ó*ûîvò\0‡ŠnÙÙç!šjì#Ñ&çšW¸€'ƒ‹<Jİb{œ­ù·ç§‰4ù`!ç¯X¢x)íd5Œx×ÂH£šØ	(§ëœİü\$UuŠ¦*U]Õ¯ş+˜¢IVMbù%ªû†îêŞ¸Œ­Ê€y&çöÍW™~gö®–ıâv¢F/x³€Ÿ†u¦Ê=VMu‹ä·‡°øà,€¾=¹3Úh, ôº¦X›Ê·Z\n€¾ 	Ôªc ‚Ãæg÷¡\ne‰¦'İ{(8‰V<š…c=æ17°èH®‰4Õhy&‡Éì§·÷ĞU™´¬ãÓ{–ÅbõŠ\0‡Ÿ¦†É»_ÁXâ·Y¶¨0óõ‹€Œœ‰xã€=@˜ãcÂ ãhŸ\nXÂhĞ.Vxã.»†Ğô8¯¡Âğ‰ü'ôEğ@\$\0¿”}òWİ'ì¡À\nZ“@=f…ZhşLöZS Æ:Bç-•|Xy®Á‹²ïXß¦b¡Â‰\nÄ¦eŸîCI›Ğr™¼‚	›€f»\0\nš0¦o£*¯{§¥P3@åœ\"J	¨¤ïÕ]¨Š n•Ú/«u˜L‚ŠU’¾dÏèúŸ®O£Ñ\0¿ˆøå­¡NyZc`¨øçÊ ˜çhØ»i˜èM¤ƒºG_=¦ÕúÚoHÖâ>ZÒOæßˆvfY­a;…ìß·…&„¸¨¨îœšïÃÖæ³„ºˆÀ\$ç­§ÂwÚ~ehb~«Ãé0ŸŞ„ÃÑé1¤£‰I–'±’nQãàaâNø= Ş>ãÚa‚ş\0jİj3èôà\"iÖ=HôÚ-aˆcYgV/ğöu`>J}ÙÉN¢@ôÙ˜«{‚(™YbX¦Ø·æ'¡^›šBh?œ°ùšMç½‘-X9hèŠYZÖ8œ¹í`Ù òe`,`}.I¸6b=N\r™V€¥–xx6iÜ8ù	heª€ø¨g‡Ÿz°q‘¥öºc¬)»jÇˆWU]«¥ªíZš<çJ»îAZ&b›ú·U‰«z»¯7¼§‡•N7yqi‚Ú¯8æ•ş——Íd8 j·Iàfo¬Z±€>g–›¬Ğ8d‰Ÿxôx\0²¼\0÷ÊŞ¯›®|¸XSœÀ€,O¤ek°çË~xõ˜™aªôÁ?°‡\0<í²Í¢—lÍŸ©å8ŒŠ`†RO50:í¢„­šæµÙ^4â!ˆ6‹!Ä˜ íj\\µ!—Ï!^ºÓ.Pa@Ó Tâ…ª~ğ5ôéƒgYûá?ÎÂ(£?NÉ¯|çà€ÏÑ9è:¤Ék£nŒ¡`êİE>N·éŠF­¯…AàN#Å;¡%Hz\rˆ\r1Æl®X\r»6¦\nÖÀT>l&H~óÊ‚ëKÀh¶ìÜ!(Xe~®0]@A”SŒ<¨€6«–\n•†:ålW±/ìW±0;HW°ôb*‘:‚_@0¶JçD–t€/ã}œÉ\\¥\0ˆ`<§°=”cß¦ËŸ8\n`+'‰£Nïä Xöø³_?‚ş‹işë\0(	·ĞhG²UZÀ&†‹ª*{Xhdmš¢øIlÑŸíZ9fƒˆc[7ìÕ³–Hxggóˆ¶ÎØelÖ*~ãÛlÏ«¶Î’ìç{=W{@–FĞišm³]îÚZß‹b´ô‰Pø:úÔÛ g%¶ıƒë%°mkUEİtèH©´øgëƒıµ¼´´\0Ì(M¤Èn†º!.AO®%ß _×‡Y‡µ½<ò`í‚åFrc€í&ëh¤àËfìåU&Ìº`äî†ÅDäÔ²`„K1³êSN¤\$€çbH6‰¶ğ2\$ıJrP 0\rv‹z@’çH\$(½ûfk” ÔÄ@ãmêvÖÛ^ç\"\nR¢#Hg%ƒÒ`ÓìaÈÔINm2@ÛÉ#pZ¡Rêò¼ÆÛ‡Ò~	h½ôş3PÛn`ÌzKj3Ûh—œ.á >\0ë¶è5{kîD·@h¡©\0Æ¿FÖíó!A2H]!t†U!ŒÇ’Ñ>¨!@1€g €5»NË»!´‡HB!ØTö]È!eÜ‚`šÈƒ)eÄÈ†@: İî§DÜˆôMÊII<‰@8È™'fä\0â'É¼zö1¯ykvà¦ÑÙá2ëØÂ®½úöY×d±úöu—öo½¢ÕÛÃ»É“ÀÚëÛ(]òKËÇ¼fÖÒ»øfäMÅ¼ ÚúË<QÜºéÑzI\"¢ñÇø	b á%\n93Ü–å¶Š1ÜÌA—oO ½úömàÖóh‰Ì‰L%1²Ò†g&ğÒ·obEL3	î¡gÈa›»É;¸HDßné.j™\rvïYºĞdA)Œ;¯xj[ão(0{:ö³¾EnZökß;÷ó°ëä2&úÓ±îN¦¾;íoª(æó»jë}¿\0%[f½¿.ğ2¯Œ;¾¦›Ì„§¾ê01íó7ñ[Ñï†ñÀ>oó¼vñSô#¶3_A¢‡ï¼‹G›“ÙÖHhºŞŒ\näÎÖÛ9?‘&†lí\$kô/,/”3˜„(ªÉ§ ğ))ÇÓø–ÀyiÀ6€È¬ÄF%¾n6Nß|¦>Zy_Ü\0ÃAÈ8¤Ñp/¹|\0ª®×m7I‹0\rMÅaÍ\$bw!l°ÅTãÌ<˜â([·¥œT]@5„ßÏYOfãÎÁí£¸X¢üÉf\n…£”@†fuÃÊ|Êµ[”Ô@/ğÍ¹…2´nTœóú¶Š¸\"\0íÍÄ\r€K‘HWÃÂS4@mA·\$³<:ÌÈÏ\r\\XiO¥ÉåU†R Ám¢ÔÂ0*òfíN.¯Å§ƒ‚näDŞI¯A>Ô`Ú+G•D‹°TüK}µ¨eò„­zGŒ\rÒFäÈa7ˆ%-=’<HSĞèå>›ˆ€é\$0>¦ñ™ğdÅõ¢MÆO¡>ïâ\r T—\$ñ‡rM}“²]ÿ¦Ö\09ëÿ(XM·¯'Ëçq«pĞh²7“îÌşêÜo:cI6¹BŒ7N‡ÛR0­L‡¡qN\nÀ5<vˆÜ	\râññ¼6PF3ŠqÁD:BA7OøÏ’ñÎf4Ó—\"Æå1· šoÕ¹¡²k„°ƒ¤˜ :†c=À9×€ğC[Ì_r'o »‚³Q*%Èüı˜RlŠ8\rİI\0007Dü¿\\Í×\0ó)QiájÉùø‰·Qí@Ğ*r…„²8ëc¡Toõ<¨›Ég–×‰[r…Qÿ(ô“³Ê>Ô[WG|ÌKD\rÈHD‰Ì%ÇW*§ˆHV•·+j!D8`É	mé±Â |­‚ëË%[Ûí±Öòû[³ËnÃ;òá°P( Ørç®W(ü»È{±§/\\¼Ñ{°7/œ¿ì2‹ô)äÏ/\\Âs	_-ÜµÌ¼¿Ü–€ÛÌ€\r{ríEï2<ºˆ¡Ì¥œÃQwÌç/|ÃóAËğ%|Èóo2<Âs\rN74ÅsEÌÇ2¼Él?±×#òìa#ÖÅDP„d\r†Æ<ÜÊÇ±nÆ\\İli±´ˆ4~s‡±áRB‹ñ»'+¬ƒê\$ÌC5=mC7­Üeºñb=Ô®Y;È]—m¸óT>	rîàšA}ª;1RÏ<†Œ1±}K¼E)åxÄÕñ&_Úa5Cğª²UŠ“·\\ÏºüË%q}õ’²]sş ¹7|óäe0#\nˆĞ¨œñtÎïAA”sæ8ï>½	¥<ÿÁ2ÆÉ×CNt=1È\0>ë*÷=œûğ£·!fU¢#ÑH‚ıÑX|¾¼ûtb	œñìôm·!ùÀƒC7gG{rí£¾8A„	ÇÒE£»ˆ8×H7'\0ÑÃ¬: †„¦¼=H7I¢jôló ¾Üx!a…ËÑ<!.Àğ .½#ô'a§œUÎÂsïGvêaB™`‡ˆ†Nğ\"V]ôaÒ„>BCñc!×N1Øôú‹5ı=ÙwĞ¤Z\\út\rÓ/Pı!t1Ô_<F–`/©;¶Ú@2'P0êõ-*¡zm¦tÿÓİâ§ğA9†›{twx©=OÆ \nïT9I\rOMñãÑÛA=OÑÜıĞtŸ}v×Mônôv0l7…UN‹ÂO`Úí¶X@õ\$¸a>Ã©å}5tÊ¨@}isÈh²äßSÏÑH2u¯Ò)„ÜKŒI>}%ı©óµİ`1œ€6àrrn_Ø\r›Â0 Öi–©y–±×À½G†‹×°}~YwØ	–·„ƒ5×à°ı~G³×·Oƒ}GÄœİ†u¾å7cöê°b‹ö/×Ñd‡\$\nWó5éL't3]¼ß\0ÒMû</qĞa<şK]x,^ce„û»gaƒh@ßÓ4÷ÌØg\0`0ô ÀTı†=µ¶e}†uÎXàµ×€7=%ŒqÚ0fa‚õ’7eRwóïD÷e­ğœ°h½õùn‡bæ+ëØ¹+}‹‹“şé‚%ÀOO=Avl/Q\\\\ôğwPı·™<Ö§nVèuÔyiıfvçeŞÖ	„î<<İÁóû<—p]—w\nK‡^¼ûõÉÀa	ÅkÆZİ¡Ø¿`ÔaØ`#wbãQ6¸o=~p]·ØgrÙö/İ×İÓuùÃ_rı~¡İ	–½^¶‹İorÑŞ€áØ½ÂñI·;˜O·cÈ†qXı1)±Ù@\"|KX_Ò´İüj×èUWhv¥¾/@½ãvB¸+5ö[ÀªP÷{Ş8}ÛvT¤ÆÇ¶ò•éÚú%}éve¬¶İ°¯Ñ/­Şwv. Öå#,]ËÚpP£/­Ü½°¬E¯ßr .î÷±Ôğ]‹÷Û!×\n2úĞÛQ\\úËuø6bñìÚp\"‡lÔÆ±±İ8š³v4±à\rõÜOß3uå 6v/ÓÑ2[_x×lIğĞÖ×­FwÇÜ·„~xáH7>Y×çF³¹øJ1Ã;2¢¿İ<½´õùİÏ‡ÆZŠ\"ù‡ˆ .ÙØ¹t½ÌHT?}åçK»ßé¤uùdwˆ´Ot!P¼}=@1İ=àÃ\0óÜÀuñì×îwqÖK£‹ uøÚ?ƒàÒ§Üµm 7xnwï`^7P¤ ×ò È™_b­şW÷Ø¿\n)yÒ6‹©1]0Dõù·/‹Œ_–Ÿİ·Œäó…±àÿÓ	wº\n—‰ã…©ì¿ŞM÷oáw~Z-ä5Nş-ø§.w‹ıHxO¯DıÙŒMØ¿z!QøÃS—\rÂñpàØäóòÈ³Úª•a=•T6gºô\riÇûm5õÂß©y˜a­J	y¡Íßit…¨ro’\"m˜\r>mf\rŒ‚	]÷/®Õ†LwæÕÍ½ùr%ÔK/=íuµ¡“‰†cçwP]ƒw´]-ƒ,mÿÄ÷¢êwµä\0!ıÌ÷µâ´	#kàöúü*Ï˜ ŠG´ ½•wâe5à”]^rs>‰ŠˆÔíâÛi5©Ü	'¿ux+å˜JÕ×Jˆ‘@}÷™İõÛç€şvµÍ¬†qaÛùä-@î\\=É‡[d‰†\rÂË_\\&†ñÙÕ¾oÂ%†ï“°ú®ªĞdPˆ1¿Ÿ©m¢õÉ9ù7Şg#åïª}Xyİ—>ª)87nóTÙ2ìw\r-t´@šó¹eÜ[ÊÈoÒw­ı-kŞe;Úâ‚²íŸ­NÈnåâ©ğ{ëØ¨„îúü°\$v¤O¬Ş«Ò\rë¤ï¾¿mËàå–ŠuìV\\[t¥x¯°%ÆO¿P†r{4NğQà5Œv	ÇÕüP	Ş:‘¼û?ÁóşÔ]!í?d2…L~ï»ªKıìı‰ÍûJ\r‡¶;ceÿVû=Ş?,’…û?Ñ··»hñ›îH#İU{…îKA6û“j=«¾Û÷ì7nŞä’)·§³í£Ä¯ÁåÓóÒûº¸? /©İîOº^ÏòBU\0”€é½¯„>mä~|¼²ˆÊïl\\Hv·<§¾=¦ûóéÅ^ş‰İï›/4Cûïïğ?^¼];ÀK™õL×fò,_‚êå\$İD|Ûà½áFõlhİÛ^y‰éwÂı¼y‰Û±`¯¦e~|F²à!û>ëÛÅ}›%p÷±M¢‚±ÕUı¸‘Ûê\"S4À¬¥Tøn=ì}†­u„×šû¤vç!ßi~Ãkß·M˜cü7ğTÔRèÚ=ú|{èGn]ŒüMóe‚÷ë•èçÁÁ.wsÇ·Ì€ä{ö˜ßn^¬“}ÖÀDß4t«İÏj·Š„J	§Ë]¾^+æwÍßõ³ó—£¥U|õèáäğ„û¶_XTWÆ«‰T;üëèäêG v÷ÛÅâ¾o‚)ô0Ø}¹ê#w¢|ı41'L,6Ü<\rm	½¹ymß§Ğ3{õÍ¯Ğ¢ôó®¸fï—Ù÷(ÿÍQ[ÈK!z7Ò¯Óa.uô§Ö?]tÃ8eîğÈ{ö%•ñÔåó÷Î?cır	g×¿Y‡ó×Ù\në<Üß\\}e×<¹C\"TÃó\0*T|ñ×ü¢üÖÏ¨‡>÷^V<b=ªı×õw«’xxáE˜¡íjY† ı›]Äı÷§Í`}§b_IÿRJİ^ïŞÁ>É¡1XQÕ“»/¨ÒÛ}¥ÛˆÔ™ôpanLÌnnÊaFSU* 53ƒµöfÜ{z{\rØÏY¿}Ûç»[åïå=›º8V?Ns¹Ë›ŞÄŸ”yYòÇfü˜~[Û€ı6\$_øƒRĞû#÷ä¸¹9×…¾Ğpíú0Dß‡ù³úobfíÆ\rÑ7ßr~˜éŸOT‚½Ä‘\"½>L€— ƒ²MõK¿\$şÅôgìªû¾~ö¾(€ïÕX8½'ï‘x'°İIqöêİ¾UVÖ×åtÿP?·b(vú‡xN	g©T¨Ö§»=j#íÃßÆ«õkÉQ¹­÷ò}Zÿ\$§8JsËüá·æ½¼?Ö×D^Ÿu»Sçé³o\0É¹ÏôeöLÉêVïÄ©7è?V“.ïÔıjvùŞ 7uö•Uú/äİ¸ÿyŞµ¿Ÿ¢)Èßø]*Ø´\nÄô·„ÿ'^T(‹r~ûÅ\rÿ¾~×ãeU)Ñh½™ÉşÏyÈiü¯İ îRilÜ1Ñ×áÎØÛ7¨?÷ÿØ\nD²­Öe©ñËº€BSÕsª”ë€ukë×@£¯B&Ø›`I“Õ U‘¡ä@¤ú®òZE(‰v\"S€Bœ“‰r%^Ê§ÉL†D\0^\0p6\$ vXwªÎ(ªÉW2 DKè€º«V€.6]ñ\nb ]Å\n'T\0©{hµB]\nÙĞYÀ/ ÒLl•\0Í :€\$;v\0©,èÄ¦Ã`«FVP\0¶\0á)¤@h` \"a\$ê­Nt5k\$³±#§dBš\n¶ÄhĞŒH\0tm:­Í*·dQ‰Éƒ»ô?u\\z,•å——†CVÜà5ØÅå—Ài%­ÖàOUOJİ×†^\\@¯½rbÁ%~‹“Î+U!cè]HÀ—àH,BOL-Êâe•E[|4³-b;¨ë|V]­¶®¹mâ×e}Ğ*ôk]²Ú”§=ğ)Ö-¼²[]rŞxkFàQšlX*Iv„\nd_ `­ñ[Â.Ø<Òcp'Ô”ípİ¡\"Ğ1`_;¯²™MtZ5Íi	F¹RXÖÓªÆÙÀà Ìh‹IOq@æY Hèâº\$zŸQ;@aŞ®²)¨/{ 3À}Eü|À;Ğ–¿\0/0Ùh µ°5ëSÑd,®\0Târ\$Â@€(ê¯	/håxK\0ç‚6°ğJ¼!#Ëa\r%\"	Ü·LY€6EA&¡]8v\"\nieÛ´eé»Ä:š,»\r¸xŸt_ } 7õ»¼:‰àËğ<Ñù£Ò€„¸È«šÑV Ä•Ë/XV¸Ò£ˆ\0¬¼Š±§aV˜­Ó&PlóUg±V'&İ¡Âî ÙçA^O¢qà{†²Dª»dÃV²ÿòwÌ\0Øa²³Ë©¡°zf¤Ì_²üXËùUë0¦QĞUÚ4*_rÙÌ>I4ÍY`´d,\n´öD¬ØØ7Aulãm‘Šù Aêª³U¨Ã\"‘[ÖVĞe ÏÁqcJy™3V'«ãØ#3‹*û­’ƒ83„ï Ø2X&òÄí†#vc\0\nÚ	Áºb²ĞÁ¡”fRµIÁ¾b|Œ¤š¤fGği\"±»ƒjM\$=I¸6ŒNş/„‚ìÇ‘|@.Uú€@(+byQ£\\vPìô ğ/şcKÕ‹Ì¦lŒ| Ú³4‚Ö^S7åWlÎ»€B\0”Mj‹Mô@CÏ´ú`¿“<ÍQ ïÁ»`jMô?X6¬j‰î„U}9ZVI°m`ÉAñ'âWH=¤!F\"P†`ê2mjqÔ>c3òºp‡ İ±}c”CÀlö!Âx&}ª¤8D­+WÑÁñdÕŠ8DŒVZÄB'ƒ¨¾éXäÈkİƒàAİ'„2‹ù@ë2ïcŠÅA+;?	l¾Úl4Oh<ÏÌ£ˆÀY¥´‚©	xƒ>vL%Ü`Ö€E\0ÏŞ%†=,aX¹Á±d˜Nú\nÓ@fUlÿ¡4Á½‚µ\"|&•íëÜXTAÍgá	é+=ÈNŒ`ÑAÖ&ÆÇµ(h;pwa?Â„ƒªš ¨+LhàĞÂlbï¦\nÓI(+P{™›0_‚µé‰	7Õùì|àÁZ„¡ |¨@âh!1B„Æª³xB‚ Ù³ú„ÓV\nĞ(Cp¬Cİ²…xÁºH+P‰ƒÑÂÃ„RÑ\n\\+ö,`¡€I„c\nÚs	îÅÜ¡_Â9b…VƒF€	°¶İBc¾Ì\$+P×ÙBEH8O:D¦8\$ĞÏ°¦cĞ¶s’tWğ2-c\"Æâ\nÜ&XLìbà±Bj'²ÆñŸ³X_œ™²M…ñö9:x90¾!=—a„ût=0ÈP0tŠŞÂøƒÃ\nÀ|QJ¯!FC…û]”3 ¨bĞy¡ƒBıƒÓá¤”/ˆS|!|B ƒù\nŠû&eù0Z`ïB¨†<Æu‘KèUŒo!Wµ†y\nÎ‘;è_…a¡´˜`-\rÜ/ˆCÌo!“u„G\r1¦l3vWUá&†•¹Œl,ö7È¡~ÂÖco\rvÉ6X[p¾!ÃRaQ…\\3†7¤Ìá\"AÜ…ÎV4\nl/†8,%á/¸RMI![Ö‹m4˜å4Ø(ŒÀÕ—T(öÆÙÂ¾c¨ÒÌ®‹5–<-.Ø\0Klš¾€=£2¶CLØšeÁljŠÔX»Ã! 	z°Ã/ƒı\n’)>L…š˜/o_†ÔY—«/v`á\$*Ö^á	Q‘;\"eYÅ`Ê4©dÃŒ×t+¢ºlïØ@C‰+zË\$››:æíf‰ºvbGî;fHdÓa°1…¾Ê=3hyj°˜DBı‡’Á5’T<Æ\"Ğ@.7oõ»kúgòÏBí&6ºŞmOƒ}–ş!êT3¬Êh›Ë	({![á8;pÊáµÃ36b·Lå	²³Ÿf¼Í`¬\0VpL¬Š4.f\0¿Í:Ö°miZ&´ÚiOÛj\$›§ES>6ç<+6ÖSÅØÊ³h'Oqc+F•°†[ 4(g®Ï]Ğ|°0—	É¤§'‰dLü¶4¬è	ú³&O¢Å*ü%&^0lƒÔÃgüÙé‡/ºlëÀ*5\0ˆ„Ğ\0š£@†-\rš3®l€Î©,&‘› ³§ˆ¨ÎªÄDF˜ğ¯¢+³°gƒu+;vwl^¢-6CcÑa«öVNŒRXÆ4A+¤LµU6ŠíCÚ4hhÍ\n@›FækõŠ»0ÚhæÄØ¼)Wx€dÌYşÂí'êP1¤³<–Fp~T³N'°ÓÅ+9wÖğôR³´¯ib]âC/6ÁèÖ3µ^ÀÎé2FÖ0±DHÚÍH¤OFŸ¬ €”BjÔŸÛ²i€@°P'ôÔ5º±¦¤M˜{51<Õp={W¥YĞe€'6BcO +K`\nq\nÃÙ²RjĞ=üLf7í_XŠ‡²&–¾ˆ«ËXRMb™_²MkÀ‚#1<LH ş4°g´Äí™2±v´ìš\"µ¨m,¬D,3rà`¸’ˆ·6ÜÙ0“t³!xÛ¢SnŒæÙ!âÉP-ƒ¨ƒ—·S ïUººDTˆfÜ^%^òâñæIæëğAÇï%mt&íå‹rô†€›R -HWy!‚C@anìÒ 7`=*â­¶k¦ØE^ ¾Pmîø%µ»õ%çê“Ò·n@u¹8wvæ-¬”?·!	ğ%+ «ƒ:6à}<Û­*Snä‡®	À¶!ÕKâà„ba'Ÿa‡í<û)D\$PP«QXáĞ“_âM|QİûnÆá‘N‚\\Zv2=¸JCE?íù[X€i€ß•¹3ü7ù‰Â€8tkzŞqd›|ÇÜjŸq¹/o`à&øaÖ¿MúĞ·å%l‘Á¿,>¦å‰>_­š|_(2#wh¬íİ–Şvzê˜˜Dñ›`œ@7o(­ÈtX?ÃĞ%\0‹9¸ğ”–¢’‘/UzAı 3ôoğßß=Do®ÚÀ,¼OwÂ/—\"íPœì\nƒ•Ô‚Rw¹GJ¤vÅ\"\n‹A\"€t6Åkˆ˜ØL€Ÿw‡\0ÌÁS‰Î~çÎ;‘!NÛc¸î\$³e!¸\" FOq÷=íêº¹7^‡°ëâô\$ïy<É7ß˜½JÛE•OĞèz-X?u@~…ÿÅ¸41ìØk•ÎºÒ`—#¨toÄ`7­Ô£;0Œ/æ0S~VÆ1ƒSk7Ân;²0k*S¸\nI ×	Ğb‰¸Ä*R¿4”Ÿ%!ó‹‡	Ä‰¤3q”˜Óë'¡‘\0Ó,Ã61´cQn)…Æ:~*’Î1Ó¤ñÊ/ÖÚ	¿H!éâŠvhÉÑfÆE\0æâ1è¨çÚ`R…¸½DúãnŒ8ÊÃpã¥h]‹R2óïtÄî3À¹j^R¬áK–”ôp÷ß\0œ‡¾ákì>äàŸW<‚mM8ø&*xÑ‡Pºâ§»¨pøğ\r½Ôg·Á1 Ô-\\´	MÉÄgG1S^å/E\\³\r5íÈÎ±£ =.®{üf&ı—´ï[B >YQt/ õ´Ñ­¹‘ÆŸzL÷ŠpT·ÄÑ©£PÆ¨µõé\$jY¦ß-F¬gŒ©2Ö1©ãFF£L–;z*tRÇ—K¶œBÈ:œj42ÆèØ¢òcd!ÕY¯.68éØÙÀÕFŒ—n6“å¨Ú¶#`?[Z6b¤ÆóÑ·£n¸tTz`ÕÅØèÑà¤:áÑ^€Dèİo¹ÄP=¿¯¾4Ï”mğ6@ŒÆ`ğ>I9²¼hŞQ¿áú\0rY&ÛÒ8\"¼¨àhuc\\ƒ™}fò¡¹ØÊbÉª‘Ò¢-ù¢‡>â¿QÅãŠEÚ‡æ\rŠB—‡BãF'Or‰]Ñ:‰¸ĞÀ|O ?¤\r0dÇJcãC&P­7œsS³1Íãœ¡Õ\r’\rYÓğ‡OQ¡¡ùÇBuÛ<¤tH{ñÑê½V‚W%¬tÇHN#Ä¯ÆŒ¤èµ½¬tB¸OÄêÆm¸+şbáço‘ÍMj;0@Ø‚8ab(×QØã†\rÙFŞ·Â;·ˆĞÃ1OÇ+~›Ò9ğ_§Ãq£	FÆy®è;àHïÏÚ6?gT‹÷lwÕ‹QáJÇˆ~Õ)ôÛé'éqá›İºQ-èÃ·Hñ±å£ÁÇ™\n.ú<<yÈó£Í>/+çAPª©ç:‹Óà\0	é€´½u)~h\"®'R:‡dz=£ØUJî[§”oX	c××“íÁU*fÕñé¦´ñE#ÜGÈş!ñCÚ7*1ó#àûWHköcâ˜úqñ£æ,ŸÑM³£ÅGi£ßÇ¹²a](Éå61ø”GÅ3]uÄ\0˜ûÅR5GåÁ!D=Ğ}jKãûGŞğ÷¹ş˜ÙGà‹’ú=M%©¸¼iÕ;9XÜ”%cÒ¤¹n”İêÅµ–á1(óÔè¶õß¨;tŒ«ÙvÓŞÃÑ¯Çí¬!¼ÿ•ÅB1üŸ	¿“HÕ~AXXşbwR5©q¦\n \n)Î–ï‡ı¨ÙÄ¢¡;ø¡œ’JM‹ûN˜á<OÆòÏšêCİ¬¨ş*zJäÂOŞ„+ìJ!P¤Ùn¡oÖ|5çm¹‚@Èù ~í³G#ö?}¼z %¢wßµEÖKN't  O6\$¾5‡Ì2™ølrÙ\rbE¶°ÆöÃ#´¶òñ„\"ÿ¶¢Jl¨’»¤ößò§8ø^j'àô±T#ÄF<WKü*·\"ëä’&\0‰?õ¬“ùSºNÅãÀã‘­¤U\"MâÃø8§ëUcì@Ù\\İYş3BS&·‚¹w(™mıøŞ7éw]Ô/|Êi±<èwwÕIèWtÇ.|ÖİY¿sËÌNŸÓı'É‘’áÙğK«'¡O¯\$hEf	ÜDMÃ#æÃçà…J‚e|·!bGÃ mÀˆ™¯u(ş®G ?29	:”| ’Ô%Œ Q¥W¤s;Uy\rUt¤‚iãH\$}Œ¦E¦*8nÈ¿’–‚]éİŠG‰é@5Çm˜¼éï0_±òCBÀè\0ìŞÖH£å€fg`£‚¸.ú©Sõø¾âO×=¤TïÕ8ZğEá¯âÉ¬•p0”MÛ¥ËS_6<Â~ùQĞ‚½	’\0EŒQKtùÏÀ\$Ù'ÊKİê%3\$¼kráÏ¯^‡Ç’`ğ!÷ğaÕéOX:¤I²´ZFd~7	Iê½\0ĞKÎ;ÜUIïcÕCºFŞÔMónT› ‰6=\\{1¸U[à9`²]®º‚,š.ÙÂdîm#ñ¾JOó%iòSnVö®¡ã˜§‚|JÛ™Ô˜U¿ßCÅ•1 †;tSUnN£Sà¸IvúñF:kÌˆ¤€ğ¾%–‚2õğNì…W‡®¡ß—É¢®ê	ó¢Xóçæ\$-º‚~^ùÒ-rK94ÂÁ2É†“bøÙÛs¦x¸Ï’¤_¾lutÆMëui7òmSÒº‡w=&:8f\rz_%:l*ñeÔ›wÉR›rÉĞrB€˜ğ®ŞR+Æo—5â{¬×¦-¹¤ñ90^*±¸4‹è	,QgOı>åmÂùì^t‘´uÂ¿z]÷@ƒÊ>ñ¦£@?à%m%5úSâ÷oP›f*,zô}<@1óoBB©N*UüšÕR„Î-QRM(Qí\"½	ò†\0‡½Í½(\\£ù2SQ?”LJ\n{I\"ºP|¢ó’S%=¤8ÒP|\r—EÏ‰£üÅ	øæQ¬ ”ÒªI&‹Ë(éÏP(©G…#ƒ¶Ÿ”€³^Q¨â­à]¿¡MPxˆcÉJ‘ËGÒLİ)D(3²”İ»q”¸¼¡eüŒ	K†®W-–Œí!„`¢à‘†ÓªÆçQvíIsëßÃ\r«(2JDO†%?ğÇ€Çd\0¾”öíEñ«r˜ôÕ^uÇÄû‘ôñìrŞ¬ËG´ò}Ğ{nøİˆQj• ©uôĞ%GÅïÀ“Éçu'%Å÷ºÀnŸFHymÆFCdûñşd¡µış	IñÈ#1õeV>9‘°U\\€Ç.¨¥WJ´!Ù(*U˜oTÓÙÊÂ aõÛªIX£S›_ÊÈvL§ô×l¤£5ÈA!:Lë©&øîQ÷ÉäÅäq+h_Ü¤Ç]ïaŸİÊàŒ~¨şJ(ûå›n‚Ì+¶pvß¼‡ìŠ¹‘¢ôIYP“˜“¬ÉI4Åt¬òöP\"äwğ¶e”ä”f=\n(^9@’¢%\0JÆ•ˆèmÅ\\°õ…’ÓZ}ÕÊ< TñHåŒ6-‘õ,p\\±—§N¯”½ö@á,eè\"a%ÅO„‚¢%–W)5.\"‰¹eï„ßË¹ĞU­WY.%gäºĞº«B¦­¸)4;%\$‘,®D´%X*ª•hJÏ@9<DÈ\0!%(c´ÇnÀ\"‚¤\0 âS3v%°\n\0Ò@T\$úJÙZ´‰j° \$K=–¦®Z\0HJÑe£<–‰qüµà_ha‡ƒªV¸^[°'eœ”¢^\\B>âµÄNÒØ‰qbE1åìAÛ¨ÑQâ/,»Õl¸”S’âà4À…–±½a˜\$PK¤\0€;÷W].^Kšæ¹sòæ‚ê+ı—Fí,.¢¾e—Ré+ÄW.f]D¹Ä¤*ì¥Õ»KÚ²¹<¹pa`s\0âË¸Xá.]gX4ùwÒí](«Å—„²Õy\\åjâƒ+mô¼—4PƒàWW=KÈ^p:^£³éy\"c%ÁË…€â\\Œ‰z(‘¢¿ÛXR±~,½²O¡u¥ÂK~€‰/aaö) «×¬¿ÿ)\0¥{;0¤ÂK_d¢ø†‰g¡0Âò'&Æ@œ›¶7Êa®Äl†ÁA oraÃÄBc&‚+I&AğµÉï—cgO•—i[Øx aá³š„ÒOä™£D†\\Àaa'3ú„¾Ëõ—´yÌ×ÙDß_\nÅ5|Ã5ı,ØŸ°a^öÀÑ„kù…s	˜Ì<`i0ı„b«Æt,1¡ˆL:aÎÑ…DÄ–ëşØ=/‹ƒRQ\"a	<Fš¤ñ\n\nB>JÎ.!DBògÒCß±ŸgÀÏˆ¢#>†<LëCß3ògñŸûW˜J­!@Ä`g}ö\"ÔEù1(\"k4_LÈ\0zŒñØ°DjˆĞ±¡ÃKˆM%3å†èM&#”G9¤\":“MJÏÚFâtìq¢TAé‰ËX«ºø2}ÅƒÙ´°*úÃÔ­ÔHF©1¢D/Àe‚Ôu¥#*¸‘…ØJ¼³NcºÒ­¥‘x‚…¬ÌÏD¤*òÎR%,Jˆ”Å\"T”[+zÔ\n%52·²Ö@#‡Àj Q%Ë3ö¡í\0Z“—x']¨ä¶AmJZ—L‰‚©¨zÆMë•³€LÁ}\$Ä]ÍcYW²Èe^Ö>'Bf³l=ŠÚ;]G€Úq°@«U>²Ò›?²Ú²gøİ–Õ‹wVï¥¢Y\n“…DGˆ¾€‰R˜&š¤é³ a*&ÒH¥‰ŞÚa!2C8‚>¶«r2Ü˜sÌãhí½[n*ü9ÏÒ‡ÊÆ»b	×‘‘	\\£dó>b†)n R„vœŸÆã‰’•\$îŒ*éXVók:Ú÷*Ğ±Ix5!–G#\r§•Îâå½r|t¬ •äª% çJ\0\\¿`üÒŞeıG/Ì¬ö>NfïL,ƒ3rPç¸¢Q§;ŒÉ/päüáÛƒ·Çr¼¾X)Èêê'ã¹? ©Ş`Š=“äŞZE¡TYó`\nrJù€šqÜ 0dmñóÇE‰ös,µ)<Ù,Ã)GÈBxr¤&ïk\r\$S»Ñ|rú\rÒ¬£‡ÏÔ„ß85t®'=¸[È‡—Nôã€ÇÄnaZ=\"{wÑ:c˜Uth“¡S»‰ğÀ¥HæÁÊû\$%+õ*üh•¦²æá(th©ÊFk„§¦ÏÑ·yp¥*nl××˜a|\0–¶Ÿb°Úª½Èa&í,PVíUÖ¤ÄÈnC?Õqô_¡ÿìi;¯†¥Í8I7µ !Â™Š~À;|&;•şüßiº°2†Ë7€²_¼¼±	`™0!V+Z‚ÅT‚1ÜDÃà\"Ó–Í!„¹n=çŒ¦%ó-	Z¤UjÓ…PñV´vZ’ ùpJÚg\nË€î:d!Î¦õN?A˜ÊV\0¾UD‡ÀØCA6 4:dˆ€ \rÀ’“/œp\0ÜÀP€ç\0sœr\0à˜rKF§#s\0j\0È´äYÇ \r€\0006\0k9Jr\0YÈ–'!€8\0o9HÛH9É3˜\0\0004œ½9Jrğ‰Ì³š\0ÎIœ¿8Şrlä‰Ê³š\r¹€2\0s9°È)És\0NH\0m9îr0pà\r€NDœá8äˆ ëœ'8€3œ­9¢qÜèùĞó—§G\08œ±:Ûœç@ó™§,I\0g9^tœç)Íó“'€7\0r\0Ît´é9È`gFN;œª\0ÊuLêCm3§PN¤œu8òuŒãùÈ`\r§(­•\0Ä\0ØœèYÉó›'Nw|\0Útæ)Ö©Ãç`\0000a;u´æ™ĞgA\0004{;FsÌê9Ï€\0€6¡9ğÌä‰Ö³Ÿ'\$N¨œĞ\0ætÜë™É €Îg':(„íyÇó¡'`ÎX\0o9>ulçĞ\0\rgqÎn:Bttí9Ï³˜§yNM¹;t<æÙÙ3–'TN‰í;\0¢¼ s¬\0Nƒ®Âx¤æiÛS gWÏC:xÜã™Û“Ÿg<N’I:\nvDèiÖÓ·\0ÎĞ™:\ns±yÒs²'{Îh8îxx‰Ús¦çeNl7;ör<ìéÛóœgSO@;Öyœè9ãÓÊçnOœw;„¬òà@\r@’N;†yÔåÉÜ3Èg*Î§‡8äÈIß“'SÎd*“<Êy8IÈsÊ§i\0i<¶s#sùàSŸ§|Îr;Ü´ô¹Üµ§VÎƒœË<†sä©Í°'GNxŸ<&{|îË•gÎ“a;ªtDçiëó¦çtOl×<¢s¤ä™òÜçÄÎt\0i<V{ˆYéÓŸgAÏ\\\0d\0ÒqÌéÙŞ3Ş§@Î¨œìL¾y|ä©Ès¹çkO–œw=FtïiËSÚ'mÎÎŸG:˜¤ó¹Şà§ÛN”9:N{ëÉó3ò§™Ï1œÙ9Š{¬÷ùñsŞgÏ¸Ÿ…:zäåIÜÓò'SO¦7;äŒöùß g'Ï¬œw=ªzB\0S©çÔN<}>*xLäÖ¹ç'ÎKŸc8æ4÷àË'ŒNjŸ?=.}Œúyï³§ç“N|\0c=Fö)åT\0gLÏÈœŸ>òrlæÙç\nê§‰Ïş÷>w¼ô	ô“’'sÎ÷û9vxíYüÓšggNX¡@u4å	Ì“Ûç£NjŸO>Àäæçó×ç/N§ŸG;\"~çIõsí'?Ï3?]}Yâ³²'¸Ï£:|Üî)ä3 §!Oùß:š€ì÷	á3Ùè%€3Ÿk9â}	ı“øg§O~\0a@Òr J	t¨1ÏT G9Êz™ï3’§ÈN¦6Ó=:{tóYùØ§´O±ƒ>Nr¨åSÿg¿ÏR›;²}åêS¤'vĞ]Õ?†…ùËSç§BÎhWAî‚æiÚs¬Í´Î—PqA&väğ \$³¢èOóŸ;Ş¤è™íóÖ§oP+œÕ>èÅ©ÌS §ÉÏoIAÎ…ô™Õ”'ªP>œÔmÎv…ÉŞ“Ö¨JÏ3ÑA,ªM)ÖÓ”'øOi[AvrMÙäô§tN\\Ÿ?=r{ıºsÛçûOëœÅ9V†„öª	&ÚhNS;æ€•	ÓôhUÎ[  âsÄüJ3²gÂÏˆ¡‰BÚ}\\ì¹×ó°gTP`œÅCVvléYÒôè\rNâ¡sA\nrôï™ÛÔ'PÎ¨Ÿ7;†„ôëiÛÓ˜çÇPV 5;6|èZs÷(ĞŸ_:sì\nSçè=Q@…ı©Í \rgÛNmŸƒBBx¤ú*%š§*O;é>şryíT7gYÎm¡÷>y<èIĞ“Ã\0NÖ a@ÊİÚÓ­§pÎ=Ÿã9ş†„ùIútDè¢N‚¡»A2{IÇS¦Š¤Ïô\0a:Äÿ…‚7ñgóĞÈœƒ?æ}-YÈ\n'<Ñœu>nsmùÒs·(Ñ\r¡Õ<Í¹üüYİ+çl¡ãBÆu”èZó¨h´ÏZ7B’|Üì\n\"óú§'O§¡»9zrš'tZçDĞŸÉAZs¤êÊ“g¾ÏQ¡›Dbt-:4R'ÏÑh?=Î€õº*³Âg¿P4 %>Nt%‰Ï”Kh’ĞVœç<Îv-	Än'£Oj¢í<&t\$ğŠ!S¢¨N÷Ÿ‹@Ö}şIôQçnNœ«@Bttä*6ô0ç~Q“YE>rüÊsÎ¨~Ñ¾ŸG\nÕñ£§VÎa¡G‰¤ì*\r¥RhRÑ¡‹8şŒõÀ\$ èÎ@û=B}4ïø´R(\rPz ¥D*Š-º.“¹'xÑ“¢9>.‰%*&4Mè6Îƒ£u=¶yz'³êg_Oì¢ÙGwe\nJASª(’ÏŒ [A6„õIŞ4Z§[N‚¤Euê\0óÃè½Ï'œƒGt	TšEØ'¢Îçœ‘@y¤üYæ'!Qo<JŒåZ7ÁççÑLœù9ŒüÚ'Ÿ'6ÎAŸiG~ŒÜö*\rTSç¿QİFEÉòsÕ\0NŒ¢>¢yİ:I“Î§®PL£ß:²vºpùÉù(DOœu?r…j3k¨Ñ¯OIR‚ì÷Š%Ôèğ·?£;c‚pöçó•¨ûÎóICôÅùê gàÑ£Ù<\nvõ!úLTcè„Ï{œó@êwùü“ñ(ÉÑ´£¯H‡=%™ÑTpg\$OhÇ<êtU(ğST§ç=N¦û?î“-Ú-´‰§¨Ï×IBZ-Ú\0³“hÑ%¢uA‚u|åÊB“š\0’ÏŸ¡Q?V]Š2¤çğÒ‘¢F.vŒıÙõS•'¸Ò˜ÒFâ“ŒîÚ\0IhNv¹Dö]\$IÕ”Œ§<Ò?>‰íŠ:¿(§Ïû¢¯<2}õùÌ3úiPbŸó:bŒ=):Zó™iNé‰J¾‘İ*º[T°ç“ÏX¡[J‡\\û*\0<çaPC²z]™ìSŸh|PôİKöu='ZTjç>Ò§ãFzˆ¬şª3§ç›O\n!9şˆ<ïzASê(%£?>U¹ßtCé\"Î­B}Êc”QèöOï¡ÅB¦“\\íÙğt{'\"AD÷¶q,µvz+İ#/š^ÂÄ1•›N€ö‹Üâ°•_–Íœüo3)©2¼iOi{4EL½Ø£²|cÒÅe´­5F(´×X71:@Åİ¦+êl,Õ!33e˜YMµ”40EZÍØŸ³¬g30µl2ô‚°ÿ˜íÓyh\0ÉL=\0)!JÁŸãM²›ëpŒiiÃCşf­\0(€: Si»l—0±€/‰…ŒD ÁC‡ˆÎq0z€÷´ä@ÌS“â.ùœÆØJlÁù´P§ZĞy¥6ptëÃæ1•‰—²&p.R´ìMØ6Ó·‰š’Ñ86+ù™z“_ç	~<%È*´â ¸LY§O}#BjxåØZm0’Y×%^éæ½m{‚\n§·OdùƒÆéØ°·.Ê×¬GZjf¼¯sGîÓãhŸºŸsBæ.ñ’@3™'G0Ÿ5\0000³\"—òCeTÎeX³	%b”ÿXÜÓÿŠÂR 9[˜1n!ZÔj¤¬m¤ÌH¦…LÆ‰¤ÃviPU C0d€*CuH¾=ˆ´A \nŒE¡½Ó£!5ú`0­¢“ãrÔÄH ”œÏqA¢¯¡ƒ)MÊ«ö•\raÖ…_\"Lâ¡«vcL^[5ƒE/\n\rŠË³p|\0(\0’M¢û h¬¶ÙäTS&ÒLÒ ¥Ü¢ÓÚä6ê\0ıEİEjˆÓ@)°›(À²\$€4V;ÌDÀÂÔk`Û3Iš9Jk5CİÃX„`ÃB£Súw¬ ¾“²\0„Îœ3	&Ël\$€¤\0sk1¼0_Ì\0×¸TeWP5×«_§%KŠšû3ˆf¶ëş/«a–¼@W˜K2…©:¬R6ªv`aZ{2†§}´M<)!g°–g2Qî¢-JE*€ª0–bvÙœLû4À‡×Â2Ü'²¾¥\rJª—ÌˆSf`S\nµ6¸—ÍVÙn4©›…T:˜00ŸYvA¡©£Š,¢l´æœä€w²Ëæ¤k.¸4‡Ã´a­P!˜{1 öÊUG\0WˆÅ®DÔI©Œ;¢Äz4ã>œ¸:{@\n]ƒEEGR®§ä;ªkSÙcÔï*ZfOZT‡|\0\n\nÔƒE+RÊš­PædmY1¾ŠÄ›¡4Ğ\n•\0ÂÌõª:ÑáÙ[5òlİVFÌJÓfµSØ©\nU®Ó”	(+LÍÉøBf§ŒÁ&l¸;°­)ºA’˜uP€>`Õôõ@*™Ô§§sS&¥ÄHyàƒÖ/Äƒ„Ó©û\$¢mMSj›ÕJªrĞ\r˜½UL—¸Ã/ª´–	3†O <\0C‚­R2¢xz*«Mêµ´bîĞÅ¥„F\rBª9Ôäª¬Åİ ›'\n¬³êaU8ªğ]á¡ˆz\n«L%!ØUƒ_ãR£”4ğV¡†Õrb;V.KG:Ãä/ÜªµVI,Ã†õ_˜ó3Rª(Éü=kgJ²ğÉ\0Õ~^í0Ù„+ê«K÷)·Uw©\0®›\\)õYíeá³«ª´Ùö¼)J®Ğª›BStdÛTÊL3Ök€«3?&ëUišS5¶/Œò©³²6`]	¬änÍ *cÃ9aW!™E]ŠzUtYÅBªµz®ü5F\\jğ±:b³UÂZû6©uU*İÂibûM®ü,r{PŠêïÄÌ©QUšªETJ½ÀI²3glÍWq…M`OÌæ`­B@«\n9²U©Šµw\0K‡Pêš\\@hÒ²lòÀŒšÓ4V¿jšA®§ÏXnT6ê§Ÿ ÈÕÙ§÷Xq†{ú¨põkÕF§Wæ±c+Ê©éØŸ4|`áXÅ’U:®¬\$¡²Qª³XRşzŠ\rRk2Ja¾• ¬1Ê¬µYÉü“ı¬‹ò«udú¯%Ü@*Õq`OW®«­a¨`õ[ª½VG¦éM®=X†U“êÂS¬¬€Êò¬k2öku{+-Bı¬Ò¾Ş&%dú³\rêÊÓ{¬ÏVuYø=sk;±¢«=VL=Û+º´UŸWşU¤©ß¢­UhJµ•¡á~ÓiªûX•â«uZĞ}+VO«pÊ­ÕfØmU¥ë\n±,¬yö®iømUq«Q2¼«“Tæ¯}]Pl(šXBè­ÈJ®£vµuëWÖ&­ ÍŞ®İkx25w«BUà­{WŠ²¥^J×õy˜ŸUèªåYb¬UdúÕ5©XÓIfc[2´ÈYE¡¥UöªVÂªMmZ¿±\në'Ö­tÄş°mØm“ëÖ„¬[~°m`öOàë'Ö…zÔŞ°¼;JÃPmkUŠfïT†·¥bš¨M@!ãÕç¬]R¦±‚ü¸:`³Ä1© ½Î\rİc:©ÌŠZaV7®îš½^ÆPmk!U]_Ã\\=ŠÍWº¬U’«€AƒªÑY:¸ÄzÊ5ÈaDL§k[¯MW6©•–jÒ×ƒYp\n³DêËÕ‰+lU\0ƒVæ¬-rJæ5aØVq®uZ³ÍhMQŠÆ×?¬çVi…tjÏõfk@Õ¡+£[õ‰õišå°mXy×PbéV¶\r­hêà5Ë˜ŸV’«i‚­µsúÓ•Ÿ˜ÒVóƒ©]-iêêÕÃB\r®'Rµ%v¶qM“«TUÌ­UZ²®…uÆ	ÕtÄÏVª_\"Äì›#9˜B•ß4Ö²fNÏ2¥Sêçğ…ë·Â%d»\\ş%^2€uÜ«È×(­UÒ¶My\nîÕãX¬ÖË«_M®mjÅõÍk¹VŞ„q[†¹ınZïPÌ˜=Áµ­ÒÒê°ƒ<zõu„ÂfVbß[Æ°Ë\0Ó<ä¦<qˆµb(q­Ù–/‹ªw_=5ùpw@/²_ğHšùõÖ+}UC`z¢’üºvåiÙ¤SN=_lœ}rmUÍ—ÄTïP=|Xjè¬Õ¿°jËN©‹:Šsğ—€'TÎ_ÌÑ±¬2ÿ3_Iß×	¤æ\0†ó.¢}:•Wv\0ª\\Ö|g5_Á†ı:–,L7À/Õ4§}¢•S*x¬4+ñ4ªˆÃ8ù2²yÉôiã€L¯šÇşÀë?›µöYÍD@&dÙ	™}æe`ĞØ#°.]„š£f€vko4ƒ Í s>zuı¬Ø2©/Oš5<zhÍWØUa\0¾¾†&+te-Û ‡¦f~Of¾í„ÆuQ™ãXRga^ªŸ¡6Z¦¦XDUni‚Onpyû\n4şê·X.°»\\™XÛ:üufØ>U•aÕ`rÃ zz6Ø2Ö\0aÒ¾u‡-µ,2U\0laƒà+ìÚ©ı€B‚ÉOº²ñ?H…@k0,±fš½ˆŠ¬\$ı,F×±(N¸#Eúü¬GX“\0²VÄÍ‰v'WÒ“ôdTÀ B«Êt!3¦‡bŒ›KV·7X/™®ÁF É];ö\"éµ×2±=b‰„‹«Ö/laX¥…Â«\n«%Šª€M,-0ˆ3c1­…[63Ù:×Ía¾Æ> ˜5ÛXÕT±´1¦U‚FN–š«Ô«Ä u{&.Ö ,uÕi®’UÕ–¥ˆ6L]˜¼Øìƒˆ^Ç•BÛí,3T+e©cô««,Æs0¶ƒÔW^±¦]qšÅQJ…¶+ªŠVŞ¬çD<úA[ œëeÙ\0¨l}‹³@\0ôàWëÓÍƒBÕ•’Œ\n†¤äìªÕ(ÂÛ*{\$uùIæ³R²VNÉZ™*ª¬^k¼Ù4'b´:f(Œóª#Ëhöˆh5û-¬<€(m Ÿ¥|šˆÍÙÒØ\nÊu-”Z­,ì\"0TS¬‡`à=-•fuAóTV`__rÈ;,,S¬3S'°Ğ±UVªŒˆÖ ûZk'evËX6'PdƒÙÕB²ÕQ8“\nŒ•l½°ßƒ÷PdA¥ËéŞ«ïY‚²fœ˜€Q&À«gYØ¢ÊAmñ\0’\n“1²\0ÒşË¸z3õÀÀ±ŞĞ‘³3«ÿ×¸5j\0¯â°Ó[\0\n\né³g&¿&Ì:­øiµÅ‰¾×Ş§©T†\$…EBw¶[I–³¦_XÚ„µ›Ë)µ÷•eA÷³{eÎ)5¨‹mMìÅY»³ŒRÈœ’e¶¬6T¥bN’»ë	*”µ*O€N™ÄPÆ¥b±Di+—Á5°=aşÎC[<ÖlÊÔïjŠÕÁ\0SU`“LcYòƒ9Z&ZÅ”{1>WÒ³äâË½KHB!í™XCQ²Š@¸HKpåÛ3Ú	±|¾”+ú¹VQU^L¦aÂf¥6s6˜UX³e¸ÇŠÈU¡‚e¸2Ügö½š}\\9ƒv.*]«ªxÂI‘Ë&M^ªh°[©¢Ó¡-—kCaî)¢³°_µ_¬™¥™¶Ìl@B³šñ§µ}Ú«¶	!bY\0a„Ã&“9›Iì2­'“¯TÖM†³Ì C \\šbaİihÛÃ€ÕklìYøclÂí«lNF9v6ëìU\0_iañˆ»ú~;ª>LwavPš\0f]kÙ4\0eĞT¡{\rhEÌ”«W1°Ã¹²¤[Q6QX±“3ifÔkL`\nv£º‡½içS©¥i8vvì5­L“goj^ÔåˆÊü6¬ZœbÆ¥VÔó:ËTËèí(Ôş+qSúª›uúpàÂe1ª(¾•œÍQFyvaÉœZšgYj—`:ù¬ñXi“A©ı\r¢Ä`k9µ¬€08ŒM¨•—ª¡Çj‡3µªÓÌ=¨»> \nW²\0¬³å¼i¿!G lA×ÿİT^×\0›\\A\0002Z[´»R(+€‹^ QcW„…›€À+Zë\0hCcÔ¹Ó›şˆDtâil¨hK‘µUÎK®pŒùi*Ì w_ –ù6Ğ1ª©\0É€.#ø4ĞÀ3ÖÅÀÇ\0f\0ÈyY¼«`3‰‘=šHKlŠ1¸Gõq(¢à€€d\0^1Ä²Ãm<\0\\ğSøNĞ€0€â²‰`Øo’N”zÄÆÛ@L‚Úæ[hªús¶’\0ÖÚ\\Ëh6Ó‚œ€6¶£&Ü/¨SöÕí¦ÛH\nr\0âÚåµ;kÀI@Ûa¶mfvàlÉk‚úÛ=æÚe¶+m IH5[p¶¥mœƒe´KnÖÖ-¼ÛJ¶÷mvÛœï»m`†í¾ÛV¶ÿmÊÛíµ»pöŞ-Û`·m²Ûí¶[qöáĞ\$·m\nÜ­¶ñhöÜmÆP™·/m:Üª)ûrvĞ§`ÎÜ·?m\"İ-·[svİíÈOŸ·MnÚuºëuHòmÖ[„·]nŠİ]·ËuÀ\r-Ó…õ·]mBİ…´‹uÖá­ÜÛ€\0¿nºÜU¼[që­Ç[Ê¶ñnºÜ•¼ëu¶ÚmŞ€_Ïnjİ¥·Éìöìí£[ÏnâŞÍ¼iìöï-à…õÏoŞ•¸Iìöñ-ğÛˆ ©oV{=¼Û}¶Ş'³ÛÑ·çozŞ¥¾[zÓ·-ì[İ·ÕnzßÔèKuöúm¡\\·¹nrÜ…À+|ÿ®Ò½·«p\nßE¿{p—\0­ö\\¶p\nŞMÁ+´UîÛd¸;nZà\r¿Ëƒ÷íÚÜ\r õp~ß%ÀK‚óÁîÜ¸nqåÀ;ƒVÓ®Ü\$¶ùpÆà]ÂûhWnÜ3¶‘9ªá•Ák‡öİ-êÜ@¸sp–ÚuÄ‡·‚úÜ@¸#q0ıÄ…×.!Ï¸Š–ß•Åˆı®-[ù¸Uq\rAÅÅyÑ7®#Û|œÕ?†ãÄû‡Wg¦Üb¸3qvqÍÆ+‹—î!¡¸¯IVã½ÃkxÔ®2Ü{¢?qŞãUÅK‰³ï®;Üo¸éru…½Z–ÿnC€_¡¹qêÜE\rË·\$n[ú¡¹rÛå\rËŠw&hMÜŠ¸±rz‚ıÉë„Âú›i¸ÃrZàÊK‘Ó·.IÛx¹Mq.ämÊk“ñ®S\\›¹i;rä5È+•wnT[1¹=qÚåEÇ‹ANn Ü¹‰rBÛÅÌK•¶ä.b\\°¹uså¸‹˜—-®i%¸­mÙfİÄK›'-½[«¹³múæõÍËpW6ÖT%¸§s~åÍÍû‹ ¦®oÜs\0Osfå»K#.wÜÜ¸Çs‘f]ÊËj7<.g\\ğ¹sÂç=Ïk7=®uÜõ¹ËrúçÁ¨IÙÖÚ®„šlsÒæÌç«Ÿw7'â]¹Ë>èµÏ™İ—Fn…NPº9t:tUÑòcs³®‚İ·ì\0ŒLè™ÔÔÅ`]]ºOt¦u„íÙì7Kn…NÁºDîŒÍÓpt“îN…¸sf‚µÓÙÓ÷P®€Üåœ“u\né-ÍÂ7OgÏİLº!sr~\rÔË§÷T.~İP¹ÿuBê-ÏšWS.¤ÜåßtôªMÖ„—6h’]`º«s–wåÖ«7B§-]`º»sæzÓÙĞ—\\®§ÜåœÿuÊê×k¬÷>g+]rº×t:vE×+­÷B§o]=œyvë­Ï™ÉWa®¼İŠº÷t*w½Øk¯÷HçA]†»t:u5ÓÙÍWf®Äİ\nuvjìmÙë±÷C§ İš»'târõÙ«²÷HÍ¹İ=6ÓvºìíĞéÏ7k®Ğİ²»Gt%Úë´÷Nçt]®»WtâymÓ §7p®bİY—lâî%ÛRc`I.Û»¤ÿwíØK k*\0’]¿œr†èmÜ»7M\r6(8»cwjëÉÅr®ç\\h»³w–ê½İIÛ·p§İì»¬ âçrÍ¹Ñ7C.pİÔ¹…wÖî=Ñ+¼ó‘®Šİû¡Ew\nèİßë£×€®éİù»ß9ÚîÓk¿Ô{/İá»©9ŠğMÜÙÈ×PïŞ5	Aêï}Ô»¿×So\rİß»uFğİŞIÈÓÚ®áOb¼KwFêİá»½÷Wîÿ]a¼[xzr4äû¸WYoŞ w¦î<ú+Æw@õIV’\rÜkÂ÷[AbŞ=|àšòí¾W‘QŞF¼Aêr]ä»½÷\\nÿ]s¼«xÂvíàë¸ó°.áOy¼»xâğ¼ëËË·…®îÎT¼»wÆïØ{¿Ó¢îá]‹¼×xŠ=æÛÌwgAŞm¼Éw.ræÛÍu.Ïİşœ‘w\n‰íèÎwrç*Ş€¼ïw:í}ßéÕ—p®ÙŞŠ¼á=†ôeè;ÑtgpŞŒ¼ö³.ÙíÓ£´7–B¡¼Dv†ğ‘ÚÒAš'xŞš¹¯wâôíÁË¿ghoKŞ»·s±då%[Æ/M\\'½WwšõA¦ÊJ·¨é*İ»¤«z3EËË×\$Æé*Ş­½usö¹ÏW¬îı^ÉÑwöötç«Ô7€ohŞ½«{sÕİiÏW)Ÿ#ô¶GM\n£DøK,oëÙÕl®~ÒÁš[JîS\"€%±y®å]J¿4JêµÏØyÖ•®~(ŸÃ jöpË şÂ£„\0¿&»•ïÈfèä±t®å^¼F“3«Ù±ƒ\0–Ö^»•jâ-mYjWr­age³Í|ªöuâ¯ÔÒ©²¾Şfj÷ò€a`×œdV>¼¤M3’ÿ]W¥b+ê½-zŠöw½«Ù×ªƒk[_òüúùé ¦CÏ†©[M|]eZòtèj6X%ˆYRêÙxš»—¸˜ıU_²CT¶ú]cæÌ]ª¶Øh¾ªÄ¢¹;7âf57!;³¬†)U­©a5¦É÷Ø\0)Şí­ÙWr÷…U«Şu„¯zÖã«¹{à›Z¶1ÓªıB¾~÷û¸SäßáPßx¯Y|®åğŠ«WÂØBUÜ¾|Bü4ëõªÎ#ßu‡Bú¥øf¢67oÉ\\¾+Wr¥àzf4õ™«	_…s|z|Ëä7Ò*÷W¬%fÎ]ûòåïÓÕü&ó[r°;ö,.­3ÕZ†Ë~Úûua*ÀÌ¯ÆÕZ°±0“=>2tŒçUk0Ã`òµE_!4µ!~ßL¦ZÁµõ\nÛ÷¹¯é×0¾´:Å¤/Ûİ «–Ã¾ÂL¶ûhKİ—»«B_i­	}®´Cûæ¾/¸^ú†U}ÎbhKî÷¿«ÖVO¿çÄ[«ğ·ïÁV„¿P6´µø« ğ¾/‰V„`~F¶ıùšğÄÍë'ß†‹Sbı&hKµ²¯’CN´Y[jı}™Èl—ì«oÃ^­¡[‚bmhKıp×a´_¼\0‰aúíz¨nWğb±Ã&¨ÇfÕ}B¸y–R*iÃc1P·›/öal\$™<Ôº§=fRøü:¤5 ÙÉ´_¾„ÙÕ¨«-ËBé™ÃÔ»¿AS‚g.\0Êœ¤ÖªsÔ7&ó ™»0Ü\nµ½Ø]Á²=UÙ—;ºÃõCR|ƒÚm`¢CóöE.N(“/¿µä\n„Vá+®6Y8ÑvÖ—e\"v„…óS\\É‚\nîí°UTX`.´å’ß7şuÚä»èƒ[›5÷)P(»¿ô`rÓô.Nv›‚HbN	gÀc\rIy¸HÁÓïúŸ1Àû¹%OF˜üÂ~„–*„°S¬&ÁGx‘<BDÁ>à³Y†¯SŠ\$… °S¸ÁO¼\n^øÆQ™c5qc‚.=xÍpø¢Û7ÚOĞc¯X)\$µ…\\Á«‚®+¢~@I Qdµšùw‰‚âŸB„Ù-gáÚõ¨—p¢ør\0°@À.¢Øp²,«jÀØ;ğ`ƒi–|”P‡]jâQál)Vñ	w³àıÂ?á€ENX\"ÔJRÂİM=Bvò`\0=6 ‚-ì®	‡VC“€Âáv—‚a¶»÷ôüàaR>twvvv\rÌ\$‰§LäE,«„¯˜G°72a¢ÃÕ.Xít|€JMàp+3L6ít6'*D)‹´„)ÉUB Fª‚\\İCäÁ‰…,‹Ê‘\0åî×[…;]mÜç-·A n¶Àò¸ \0a7p5‰Ş[]×ø”­.¿âŸºÿ!Võp\$¨³î¿ãº8D‚ôP¦@¾¸]°L;tÂö1áğJ¦/MÇ£ 4ÃùCÓëÜ0sOêL0uşkxööÂ ÃEª±†H	P“£˜e°¥aIuş•¦ğ0á\"‚ôÆòƒE‹­†™Â3ÓóØ8Sa©m(øÀàPîà¤0×ÍÇ,Á†Ë\n€ñ.É°‚„¦_†ò+ëåŒåW€ßá¦*â¹Ã€Gà:cãüáÆl¶<\rjrÇXr°ä.ÚÁ8YÍŞ\\6XqÖÇá½‚hxåî\r³Y°}áÎ›ä.¼=)PÛå;¥µÎH p%Mµğõáò‘‡Óøü?#,\0007áø.T,éÂÈ¬,?8€¬áé!z	öiŞ hÈµ!`“H=Œ‡–2BW‰£ÆUŒ˜¹°7\\@ÉL‘b…‡¦(f\"íøMpˆÔİ’nF!ÓnÔ•%…W†q²‚![åEnS ‚Dƒ\"“xê|·[nS……!VÀv1CE;ñÃŞ#	Ø %b;#D`‹u.lH'çø’rbMÄzè/«épÉMÊq,MŠé‰=ÍF%lK’¼ä\"¨€f?~&;i)b;)‰wdVe|‡ñ7ÊóÄã)OS0ìJŠŒãH)\rããŒX=c-Œ:Â<=¹N1²ŠÜŸU»TY' è÷ZñE òvœÛÎ)WjX>œ5±nSŠ0\nŞ	ŒRIJ±QbŒS‹ø_PU+Ê1TàÊbá¡¿„X°Ì8WÒvbB‹ ß(\n„]¦ü®4Ã©µ×ŠéŠítÄÙ”˜>[ò‰’‹?=¶,|UÍú0Ê¶¥Â”ß—pVü®É„ïE~Å	HfÃ 1hâÚ‘f©{,a …Oi\"¼â¿oŠÇ¬Xœ]\rÚñcášqÕ÷’¾¸®r¶@ñJÙ;+d*Mğ@Ëéñ…q4\r¨>`ØğÆbş8SŒ\0áH!L<XBp`EŒÉŠÉÆ~\n`w¿€ÂÅsºòÄ.*ux¸Æ@¢€cp£ŒpGiO 7¼\0©t6i.×2ØÈÄã(ÆJ¥^°U3|bºc3¿Œ¤º†2’BCvqFüF5Œö7Òj|f QJˆã ‘b¶’Y´Õ”nO\nG–w\0Rp}°…^AvÕ¢¢uVÓ04é|à?‚+Tf¬\$+ø¥Ç\0q°È7älu²<ã‚¨£`’¢¿\0âi¬ÕuÀC@È\0¥Ô™Ğ\"eçtÂ_Æô\nhš[<o«E±¿“X:R;¢ÏPá@*¼K:Œqfè^\"eænS\rÇ¸*ôäz1ëq¬±ƒ-]H‡búØ/°Ñ!\"Ê²N)Ú¤`h³B<¸?[æ îi2K§MN\01ƒEIúí>¬ˆ9 „ÂIt›û)ˆ'¼iÀĞûãVGQ\"5´Ob-V!\"‹\nÀœ@šã€p!AEÆG¡\\Æ9%}à€­.Ş\\T¾	˜ĞZğHg¶+\0[Şöêõ¼yWe¬YL'ŞÓÒŸ¸zœ!J“¤%K[­ÿ®%ô¶x×Löyzî0¨ÊÌi/ÿ€");}elseif($_GET["file"]=="logo.png"){header("Content-Type: image/png");echo"‰PNG\r\n\n\0\0\0\rIHDR\0\0\09\0\0\09\0\0\0~6¶\0\0\0000PLTE\0\0\0ƒ—­+NvYt“s‰£®¾´¾ÌÈÒÚü‘üsuüIJ÷ÓÔü/.üü¯±úüúC¥×\0\0\0tRNS\0@æØf\0\0\0	pHYs\0\0\0\0\0šœ\0\0´IDAT8Õ”ÍNÂ@ÇûEáìlÏ¶õ¤p6ˆG.\$=£¥Ç>á	w5r}‚z7²>€‘På#\$Œ³K¡j«7üİ¶¿ÌÎÌ?4m•„ˆÑ÷t&î~À3!0“0Šš^„½Af0Ş\"å½í,Êğ* ç4¼Œâo¥Eè³è×X(*YÓó¼¸	6	ïPcOW¢ÉÎÜŠm’¬rƒ0Ã~/ áL¨\rXj#ÖmÊÁújÀC€]G¦mæ\0¶}ŞË¬ß‘u¼A9ÀX£\nÔØ8¼V±YÄ+ÇD#¨iqŞnKQ8Jà1Q6²æY0§`•ŸP³bQ\\h”~>ó:pSÉ€£¦¼¢ØóGEõQ=îIÏ{’*Ÿ3ë2£7÷\neÊLèBŠ~Ğ/R(\$°)Êç‹ —ÁHQn€i•6J¶	<×-.–wÇÉªjêVm«êüm¿?SŞH ›vÃÌûñÆ©§İ\0àÖ^Õq«¶)ª—Û]÷‹U¹92Ñ,;ÿÇî'pøµ£!XËƒäÚÜÿLñD.»tÃ¦—ı/wÃÓäìR÷	w­dÓÖr2ïÆ¤ª4[=½E5÷S+ñ—c\0\0\0\0IEND®B`‚";}exit;}if(!$_SERVER["REQUEST_URI"])$_SERVER["REQUEST_URI"]=$_SERVER["ORIG_PATH_INFO"];if(!strpos($_SERVER["REQUEST_URI"],'?')&&$_SERVER["QUERY_STRING"]!="")$_SERVER["REQUEST_URI"].="?$_SERVER[QUERY_STRING]";if($_SERVER["HTTP_X_FORWARDED_PREFIX"])$_SERVER["REQUEST_URI"]=$_SERVER["HTTP_X_FORWARDED_PREFIX"].$_SERVER["REQUEST_URI"];define('Adminer\HTTPS',($_SERVER["HTTPS"]&&strcasecmp($_SERVER["HTTPS"],"off"))||ini_bool("session.cookie_secure"));@ini_set("session.use_trans_sid",'0');if(!defined("SID")){session_cache_limiter("");session_name("adminer_sid");session_set_cookie_params(0,preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]),"",HTTPS,true);session_start();}if(function_exists("get_magic_quotes_gpc")&&get_magic_quotes_gpc()){$_GET=remove_slashes($_GET,$Zc);$_POST=remove_slashes($_POST,$Zc);$_COOKIE=remove_slashes($_COOKIE,$Zc);}if(function_exists("get_magic_quotes_runtime")&&get_magic_quotes_runtime())set_magic_quotes_runtime(false);@set_time_limit(0);@ini_set("precision",'15');function
lang($u,$Kf=null){$ua=func_get_args();$ua[0]=$u;return
call_user_func_array('Adminer\lang_format',$ua);}function
lang_format($dj,$Kf=null){if(is_array($dj)){$Og=($Kf==1?0:1);$dj=$dj[$Og];}$dj=str_replace("'",'â€™',$dj);$ua=func_get_args();array_shift($ua);$ld=str_replace("%d","%s",$dj);if($ld!=$dj)$ua[0]=format_number($Kf);return
vsprintf($ld,$ua);}define('Adminer\LANG','en');abstract
class
SqlDb{static$instance;var$extension;var$flavor='';var$server_info;var$affected_rows=0;var$info='';var$errno=0;var$error='';protected$multi;abstract
function
attach($N,$V,$F);abstract
function
quote($Q);abstract
function
select_db($Nb);abstract
function
query($H,$oj=false);function
multi_query($H){return$this->multi=$this->query($H);}function
store_result(){return$this->multi;}function
next_result(){return
false;}}if(extension_loaded('pdo')){abstract
class
PdoDb
extends
SqlDb{protected$pdo;function
dsn($mc,$V,$F,array$cg=array()){$cg[\PDO::ATTR_ERRMODE]=\PDO::ERRMODE_SILENT;$cg[\PDO::ATTR_STATEMENT_CLASS]=array('Adminer\PdoResult');try{$this->pdo=new
\PDO($mc,$V,$F,$cg);}catch(\Exception$Gc){return$Gc->getMessage();}$this->server_info=@$this->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION);return'';}function
quote($Q){return$this->pdo->quote($Q);}function
query($H,$oj=false){$I=$this->pdo->query($H);$this->error="";if(!$I){list(,$this->errno,$this->error)=$this->pdo->errorInfo();if(!$this->error)$this->error='Unknown error.';return
false;}$this->store_result($I);return$I;}function
store_result($I=null){if(!$I){$I=$this->multi;if(!$I)return
false;}if($I->columnCount()){$I->num_rows=$I->rowCount();return$I;}$this->affected_rows=$I->rowCount();return
true;}function
next_result(){$I=$this->multi;if(!is_object($I))return
false;$I->_offset=0;return@$I->nextRowset();}}class
PdoResult
extends
\PDOStatement{var$_offset=0,$num_rows;function
fetch_assoc(){return$this->fetch_array(\PDO::FETCH_ASSOC);}function
fetch_row(){return$this->fetch_array(\PDO::FETCH_NUM);}private
function
fetch_array($uf){$J=$this->fetch($uf);return($J?array_map(array($this,'unresource'),$J):$J);}private
function
unresource($X){return(is_resource($X)?stream_get_contents($X):$X);}function
fetch_field(){$K=(object)$this->getColumnMeta($this->_offset++);$U=$K->pdo_type;$K->type=($U==\PDO::PARAM_INT?0:15);$K->charsetnr=($U==\PDO::PARAM_LOB||(isset($K->flags)&&in_array("blob",(array)$K->flags))?63:0);return$K;}function
seek($C){for($s=0;$s<$C;$s++)$this->fetch();}}}function
add_driver($t,$B){SqlDriver::$drivers[$t]=$B;}function
get_driver($t){return
SqlDriver::$drivers[$t];}abstract
class
SqlDriver{static$instance;static$drivers=array();static$extensions=array();static$jush;protected$conn;protected$types=array();var$delimiter=";";var$insertFunctions=array();var$editFunctions=array();var$unsigned=array();var$operators=array();var$functions=array();var$grouping=array();var$onActions="RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";var$partitionBy=array();var$inout="IN|OUT|INOUT";var$enumLength="'(?:''|[^'\\\\]|\\\\.)*'";var$generated=array();static
function
connect($N,$V,$F){$f=new
Db;return($f->attach($N,$V,$F)?:$f);}function
__construct(Db$f){$this->conn=$f;}function
types(){return
call_user_func_array('array_merge',array_values($this->types));}function
structuredTypes(){return
array_map('array_keys',$this->types);}function
enumLength(array$m){}function
unconvertFunction(array$m){}function
select($R,array$M,array$Z,array$vd,array$eg=array(),$z=1,$D=0,$Xg=false){$te=(count($vd)<count($M));$H=adminer()->selectQueryBuild($M,$Z,$vd,$eg,$z,$D);if(!$H)$H="SELECT".limit(($_GET["page"]!="last"&&$z&&$vd&&$te&&JUSH=="sql"?"SQL_CALC_FOUND_ROWS ":"").implode(", ",$M)."\nFROM ".table($R),($Z?"\nWHERE ".implode(" AND ",$Z):"").($vd&&$te?"\nGROUP BY ".implode(", ",$vd):"").($eg?"\nORDER BY ".implode(", ",$eg):""),$z,($D?$z*$D:0),"\n");$oi=microtime(true);$J=$this->conn->query($H);if($Xg)echo
adminer()->selectQuery($H,$oi,!$J);return$J;}function
delete($R,$fh,$z=0){$H="FROM ".table($R);return
queries("DELETE".($z?limit1($R,$H,$fh):" $H$fh"));}function
update($R,array$O,$fh,$z=0,$Rh="\n"){$Jj=array();foreach($O
as$x=>$X)$Jj[]="$x = $X";$H=table($R)." SET$Rh".implode(",$Rh",$Jj);return
queries("UPDATE".($z?limit1($R,$H,$fh,$Rh):" $H$fh"));}function
insert($R,array$O){return
queries("INSERT INTO ".table($R).($O?" (".implode(", ",array_keys($O)).")\nVALUES (".implode(", ",$O).")":" DEFAULT VALUES").$this->insertReturning($R));}function
insertReturning($R){return"";}function
insertUpdate($R,array$L,array$G){return
false;}function
begin(){return
queries("BEGIN");}function
commit(){return
queries("COMMIT");}function
rollback(){return
queries("ROLLBACK");}function
slowQuery($H,$Qi){}function
convertSearch($u,array$X,array$m){return$u;}function
value($X,array$m){return(method_exists($this->conn,'value')?$this->conn->value($X,$m):$X);}function
quoteBinary($Dh){return
q($Dh);}function
warnings(){}function
tableHelp($B,$xe=false){}function
inheritsFrom($R){return
array();}function
inheritedTables($R){return
array();}function
partitionsInfo($R){return
array();}function
hasCStyleEscapes(){return
false;}function
engines(){return
array();}function
supportsIndex(array$S){return!is_view($S);}function
indexAlgorithms(array$yi){return
array();}function
checkConstraints($R){return
get_key_vals("SELECT c.CONSTRAINT_NAME, CHECK_CLAUSE
FROM INFORMATION_SCHEMA.CHECK_CONSTRAINTS c
JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS t ON c.CONSTRAINT_SCHEMA = t.CONSTRAINT_SCHEMA AND c.CONSTRAINT_NAME = t.CONSTRAINT_NAME".($this->conn->flavor=='maria'?" AND c.TABLE_NAME = t.TABLE_NAME":"")."
WHERE c.CONSTRAINT_SCHEMA = ".q($_GET["ns"]!=""?$_GET["ns"]:DB)."
AND t.TABLE_NAME = ".q($R).(JUSH=="pgsql"?"
AND CHECK_CLAUSE NOT LIKE '% IS NOT NULL'":""),$this->conn);}function
allFields(){$J=array();if(DB!=""){foreach(get_rows("SELECT TABLE_NAME AS tab, COLUMN_NAME AS field, IS_NULLABLE AS nullable, DATA_TYPE AS type, CHARACTER_MAXIMUM_LENGTH AS length".(JUSH=='sql'?", COLUMN_KEY = 'PRI' AS `primary`":"")."
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = ".q($_GET["ns"]!=""?$_GET["ns"]:DB)."
ORDER BY TABLE_NAME, ORDINAL_POSITION",$this->conn)as$K){$K["null"]=($K["nullable"]=="YES");$J[$K["tab"]][]=$K;}}return$J;}}add_driver("sqlite","SQLite");if(isset($_GET["sqlite"])){define('Adminer\DRIVER',"sqlite");if(class_exists("SQLite3")&&$_GET["ext"]!="pdo"){abstract
class
SqliteDb
extends
SqlDb{var$extension="SQLite3";private$link;function
attach($o,$V,$F){$this->link=new
\SQLite3($o);$Mj=$this->link->version();$this->server_info=$Mj["versionString"];return'';}function
query($H,$oj=false){$I=@$this->link->query($H);$this->error="";if(!$I){$this->errno=$this->link->lastErrorCode();$this->error=$this->link->lastErrorMsg();return
false;}elseif($I->numColumns())return
new
Result($I);$this->affected_rows=$this->link->changes();return
true;}function
quote($Q){return(is_utf8($Q)?"'".$this->link->escapeString($Q)."'":"x'".first(unpack('H*',$Q))."'");}}class
Result{var$num_rows;private$result,$offset=0;function
__construct($I){$this->result=$I;}function
fetch_assoc(){return$this->result->fetchArray(SQLITE3_ASSOC);}function
fetch_row(){return$this->result->fetchArray(SQLITE3_NUM);}function
fetch_field(){$d=$this->offset++;$U=$this->result->columnType($d);return(object)array("name"=>$this->result->columnName($d),"type"=>($U==SQLITE3_TEXT?15:0),"charsetnr"=>($U==SQLITE3_BLOB?63:0),);}function
__destruct(){$this->result->finalize();}}}elseif(extension_loaded("pdo_sqlite")){abstract
class
SqliteDb
extends
PdoDb{var$extension="PDO_SQLite";function
attach($o,$V,$F){return$this->dsn(DRIVER.":$o","","");}}}if(class_exists('Adminer\SqliteDb')){class
Db
extends
SqliteDb{function
attach($o,$V,$F){parent::attach($o,$V,$F);$this->query("PRAGMA foreign_keys = 1");$this->query("PRAGMA busy_timeout = 500");return'';}function
select_db($o){if(is_readable($o)&&$this->query("ATTACH ".$this->quote(preg_match("~(^[/\\\\]|:)~",$o)?$o:dirname($_SERVER["SCRIPT_FILENAME"])."/$o")." AS a"))return!self::attach($o,'','');return
false;}}}class
Driver
extends
SqlDriver{static$extensions=array("SQLite3","PDO_SQLite");static$jush="sqlite";protected$types=array(array("integer"=>0,"real"=>0,"numeric"=>0,"text"=>0,"blob"=>0));var$insertFunctions=array();var$editFunctions=array("integer|real|numeric"=>"+/-","text"=>"||",);var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL");var$functions=array("hex","length","lower","round","unixepoch","upper");var$grouping=array("avg","count","count distinct","group_concat","max","min","sum");static
function
connect($N,$V,$F){if($F!="")return'Database does not support password.';return
parent::connect(":memory:","","");}function
__construct(Db$f){parent::__construct($f);if(min_version(3.31,0,$f))$this->generated=array("STORED","VIRTUAL");}function
structuredTypes(){return
array_keys($this->types[0]);}function
insertUpdate($R,array$L,array$G){$Jj=array();foreach($L
as$O)$Jj[]="(".implode(", ",$O).")";return
queries("REPLACE INTO ".table($R)." (".implode(", ",array_keys(reset($L))).") VALUES\n".implode(",\n",$Jj));}function
tableHelp($B,$xe=false){if($B=="sqlite_sequence")return"fileformat2.html#seqtab";if($B=="sqlite_master")return"fileformat2.html#$B";}function
checkConstraints($R){preg_match_all('~ CHECK *(\( *(((?>[^()]*[^() ])|(?1))*) *\))~',get_val("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($R),0,$this->conn),$Ze);return
array_combine($Ze[2],$Ze[2]);}function
allFields(){$J=array();foreach(tables_list()as$R=>$U){foreach(fields($R)as$m)$J[$R][]=$m;}return$J;}}function
idf_escape($u){return'"'.str_replace('"','""',$u).'"';}function
table($u){return
idf_escape($u);}function
get_databases($gd){return
array();}function
limit($H,$Z,$z,$C=0,$Rh=" "){return" $H$Z".($z?$Rh."LIMIT $z".($C?" OFFSET $C":""):"");}function
limit1($R,$H,$Z,$Rh="\n"){return(preg_match('~^INTO~',$H)||get_val("SELECT sqlite_compileoption_used('ENABLE_UPDATE_DELETE_LIMIT')")?limit($H,$Z,1,0,$Rh):" $H WHERE rowid = (SELECT rowid FROM ".table($R).$Z.$Rh."LIMIT 1)");}function
db_collation($j,$jb){return
get_val("PRAGMA encoding");}function
logged_user(){return
get_current_user();}function
tables_list(){return
get_key_vals("SELECT name, type FROM sqlite_master WHERE type IN ('table', 'view') ORDER BY (name = 'sqlite_sequence'), name");}function
count_tables($i){return
array();}function
table_status($B=""){$J=array();foreach(get_rows("SELECT name AS Name, type AS Engine, 'rowid' AS Oid, '' AS Auto_increment FROM sqlite_master WHERE type IN ('table', 'view') ".($B!=""?"AND name = ".q($B):"ORDER BY name"))as$K){$K["Rows"]=get_val("SELECT COUNT(*) FROM ".idf_escape($K["Name"]));$J[$K["Name"]]=$K;}foreach(get_rows("SELECT * FROM sqlite_sequence".($B!=""?" WHERE name = ".q($B):""),null,"")as$K)$J[$K["name"]]["Auto_increment"]=$K["seq"];return$J;}function
is_view($S){return$S["Engine"]=="view";}function
fk_support($S){return!get_val("SELECT sqlite_compileoption_used('OMIT_FOREIGN_KEY')");}function
fields($R){$J=array();$G="";foreach(get_rows("PRAGMA table_".(min_version(3.31)?"x":"")."info(".table($R).")")as$K){$B=$K["name"];$U=strtolower($K["type"]);$k=$K["dflt_value"];$J[$B]=array("field"=>$B,"type"=>(preg_match('~int~i',$U)?"integer":(preg_match('~char|clob|text~i',$U)?"text":(preg_match('~blob~i',$U)?"blob":(preg_match('~real|floa|doub~i',$U)?"real":"numeric")))),"full_type"=>$U,"default"=>(preg_match("~^'(.*)'$~",$k,$A)?str_replace("''","'",$A[1]):($k=="NULL"?null:$k)),"null"=>!$K["notnull"],"privileges"=>array("select"=>1,"insert"=>1,"update"=>1,"where"=>1,"order"=>1),"primary"=>$K["pk"],);if($K["pk"]){if($G!="")$J[$G]["auto_increment"]=false;elseif(preg_match('~^integer$~i',$U))$J[$B]["auto_increment"]=true;$G=$B;}}$ii=get_val("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($R));$u='(("[^"]*+")+|[a-z0-9_]+)';preg_match_all('~'.$u.'\s+text\s+COLLATE\s+(\'[^\']+\'|\S+)~i',$ii,$Ze,PREG_SET_ORDER);foreach($Ze
as$A){$B=str_replace('""','"',preg_replace('~^"|"$~','',$A[1]));if($J[$B])$J[$B]["collation"]=trim($A[3],"'");}preg_match_all('~'.$u.'\s.*GENERATED ALWAYS AS \((.+)\) (STORED|VIRTUAL)~i',$ii,$Ze,PREG_SET_ORDER);foreach($Ze
as$A){$B=str_replace('""','"',preg_replace('~^"|"$~','',$A[1]));$J[$B]["default"]=$A[3];$J[$B]["generated"]=strtoupper($A[4]);}return$J;}function
indexes($R,$g=null){$g=connection($g);$J=array();$ii=get_val("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($R),0,$g);if(preg_match('~\bPRIMARY\s+KEY\s*\((([^)"]+|"[^"]*"|`[^`]*`)++)~i',$ii,$A)){$J[""]=array("type"=>"PRIMARY","columns"=>array(),"lengths"=>array(),"descs"=>array());preg_match_all('~((("[^"]*+")+|(?:`[^`]*+`)+)|(\S+))(\s+(ASC|DESC))?(,\s*|$)~i',$A[1],$Ze,PREG_SET_ORDER);foreach($Ze
as$A){$J[""]["columns"][]=idf_unescape($A[2]).$A[4];$J[""]["descs"][]=(preg_match('~DESC~i',$A[5])?'1':null);}}if(!$J){foreach(fields($R)as$B=>$m){if($m["primary"])$J[""]=array("type"=>"PRIMARY","columns"=>array($B),"lengths"=>array(),"descs"=>array(null));}}$mi=get_key_vals("SELECT name, sql FROM sqlite_master WHERE type = 'index' AND tbl_name = ".q($R),$g);foreach(get_rows("PRAGMA index_list(".table($R).")",$g)as$K){$B=$K["name"];$v=array("type"=>($K["unique"]?"UNIQUE":"INDEX"));$v["lengths"]=array();$v["descs"]=array();foreach(get_rows("PRAGMA index_info(".idf_escape($B).")",$g)as$Ch){$v["columns"][]=$Ch["name"];$v["descs"][]=null;}if(preg_match('~^CREATE( UNIQUE)? INDEX '.preg_quote(idf_escape($B).' ON '.idf_escape($R),'~').' \((.*)\)$~i',$mi[$B],$qh)){preg_match_all('/("[^"]*+")+( DESC)?/',$qh[2],$Ze);foreach($Ze[2]as$x=>$X){if($X)$v["descs"][$x]='1';}}if(!$J[""]||$v["type"]!="UNIQUE"||$v["columns"]!=$J[""]["columns"]||$v["descs"]!=$J[""]["descs"]||!preg_match("~^sqlite_~",$B))$J[$B]=$v;}return$J;}function
foreign_keys($R){$J=array();foreach(get_rows("PRAGMA foreign_key_list(".table($R).")")as$K){$p=&$J[$K["id"]];if(!$p)$p=$K;$p["source"][]=$K["from"];$p["target"][]=$K["to"];}return$J;}function
view($B){return
array("select"=>preg_replace('~^(?:[^`"[]+|`[^`]*`|"[^"]*")* AS\s+~iU','',get_val("SELECT sql FROM sqlite_master WHERE type = 'view' AND name = ".q($B))));}function
collations(){return(isset($_GET["create"])?get_vals("PRAGMA collation_list",1):array());}function
information_schema($j){return
false;}function
error(){return
h(connection()->error);}function
check_sqlite_name($B){$Oc="db|sdb|sqlite";if(!preg_match("~^[^\\0]*\\.($Oc)\$~",$B)){connection()->error=sprintf('Please use one of the extensions %s.',str_replace("|",", ",$Oc));return
false;}return
true;}function
create_database($j,$c){if(file_exists($j)){connection()->error='File exists.';return
false;}if(!check_sqlite_name($j))return
false;try{$_=new
Db();$_->attach($j,'','');}catch(\Exception$Gc){connection()->error=$Gc->getMessage();return
false;}$_->query('PRAGMA encoding = "UTF-8"');$_->query('CREATE TABLE adminer (i)');$_->query('DROP TABLE adminer');return
true;}function
drop_databases($i){connection()->attach(":memory:",'','');foreach($i
as$j){if(!@unlink($j)){connection()->error='File exists.';return
false;}}return
true;}function
rename_database($B,$c){if(!check_sqlite_name($B))return
false;connection()->attach(":memory:",'','');connection()->error='File exists.';return@rename(DB,$B);}function
auto_increment(){return" PRIMARY KEY AUTOINCREMENT";}function
alter_table($R,$B,$n,$id,$ob,$wc,$c,$_a,$E){$Bj=($R==""||$id);foreach($n
as$m){if($m[0]!=""||!$m[1]||$m[2]){$Bj=true;break;}}$b=array();$pg=array();foreach($n
as$m){if($m[1]){$b[]=($Bj?$m[1]:"ADD ".implode($m[1]));if($m[0]!="")$pg[$m[0]]=$m[1][0];}}if(!$Bj){foreach($b
as$X){if(!queries("ALTER TABLE ".table($R)." $X"))return
false;}if($R!=$B&&!queries("ALTER TABLE ".table($R)." RENAME TO ".table($B)))return
false;}elseif(!recreate_table($R,$B,$b,$pg,$id,$_a))return
false;if($_a){queries("BEGIN");queries("UPDATE sqlite_sequence SET seq = $_a WHERE name = ".q($B));if(!connection()->affected_rows)queries("INSERT INTO sqlite_sequence (name, seq) VALUES (".q($B).", $_a)");queries("COMMIT");}return
true;}function
recreate_table($R,$B,array$n,array$pg,array$id,$_a="",$w=array(),$ic="",$ja=""){if($R!=""){if(!$n){foreach(fields($R)as$x=>$m){if($w)$m["auto_increment"]=0;$n[]=process_field($m,$m);$pg[$x]=idf_escape($x);}}$Wg=false;foreach($n
as$m){if($m[6])$Wg=true;}$kc=array();foreach($w
as$x=>$X){if($X[2]=="DROP"){$kc[$X[1]]=true;unset($w[$x]);}}foreach(indexes($R)as$Be=>$v){$e=array();foreach($v["columns"]as$x=>$d){if(!$pg[$d])continue
2;$e[]=$pg[$d].($v["descs"][$x]?" DESC":"");}if(!$kc[$Be]){if($v["type"]!="PRIMARY"||!$Wg)$w[]=array($v["type"],$Be,$e);}}foreach($w
as$x=>$X){if($X[0]=="PRIMARY"){unset($w[$x]);$id[]="  PRIMARY KEY (".implode(", ",$X[2]).")";}}foreach(foreign_keys($R)as$Be=>$p){foreach($p["source"]as$x=>$d){if(!$pg[$d])continue
2;$p["source"][$x]=idf_unescape($pg[$d]);}if(!isset($id[" $Be"]))$id[]=" ".format_foreign_key($p);}queries("BEGIN");}$Ua=array();foreach($n
as$m){if(preg_match('~GENERATED~',$m[3]))unset($pg[array_search($m[0],$pg)]);$Ua[]="  ".implode($m);}$Ua=array_merge($Ua,array_filter($id));foreach(driver()->checkConstraints($R)as$Wa){if($Wa!=$ic)$Ua[]="  CHECK ($Wa)";}if($ja)$Ua[]="  CHECK ($ja)";$Ki=($R==$B?"adminer_$B":$B);if(!queries("CREATE TABLE ".table($Ki)." (\n".implode(",\n",$Ua)."\n)"))return
false;if($R!=""){if($pg&&!queries("INSERT INTO ".table($Ki)." (".implode(", ",$pg).") SELECT ".implode(", ",array_map('Adminer\idf_escape',array_keys($pg)))." FROM ".table($R)))return
false;$kj=array();foreach(triggers($R)as$ij=>$Ri){$hj=trigger($ij,$R);$kj[]="CREATE TRIGGER ".idf_escape($ij)." ".implode(" ",$Ri)." ON ".table($B)."\n$hj[Statement]";}$_a=$_a?"":get_val("SELECT seq FROM sqlite_sequence WHERE name = ".q($R));if(!queries("DROP TABLE ".table($R))||($R==$B&&!queries("ALTER TABLE ".table($Ki)." RENAME TO ".table($B)))||!alter_indexes($B,$w))return
false;if($_a)queries("UPDATE sqlite_sequence SET seq = $_a WHERE name = ".q($B));foreach($kj
as$hj){if(!queries($hj))return
false;}queries("COMMIT");}return
true;}function
index_sql($R,$U,$B,$e){return"CREATE $U ".($U!="INDEX"?"INDEX ":"").idf_escape($B!=""?$B:uniqid($R."_"))." ON ".table($R)." $e";}function
alter_indexes($R,$b){foreach($b
as$G){if($G[0]=="PRIMARY")return
recreate_table($R,$R,array(),array(),array(),"",$b);}foreach(array_reverse($b)as$X){if(!queries($X[2]=="DROP"?"DROP INDEX ".idf_escape($X[1]):index_sql($R,$X[0],$X[1],"(".implode(", ",$X[2]).")")))return
false;}return
true;}function
truncate_tables($T){return
apply_queries("DELETE FROM",$T);}function
drop_views($Oj){return
apply_queries("DROP VIEW",$Oj);}function
drop_tables($T){return
apply_queries("DROP TABLE",$T);}function
move_tables($T,$Oj,$Ii){return
false;}function
trigger($B,$R){if($B=="")return
array("Statement"=>"BEGIN\n\t;\nEND");$u='(?:[^`"\s]+|`[^`]*`|"[^"]*")+';$jj=trigger_options();preg_match("~^CREATE\\s+TRIGGER\\s*$u\\s*(".implode("|",$jj["Timing"]).")\\s+([a-z]+)(?:\\s+OF\\s+($u))?\\s+ON\\s*$u\\s*(?:FOR\\s+EACH\\s+ROW\\s)?(.*)~is",get_val("SELECT sql FROM sqlite_master WHERE type = 'trigger' AND name = ".q($B)),$A);$Mf=$A[3];return
array("Timing"=>strtoupper($A[1]),"Event"=>strtoupper($A[2]).($Mf?" OF":""),"Of"=>idf_unescape($Mf),"Trigger"=>$B,"Statement"=>$A[4],);}function
triggers($R){$J=array();$jj=trigger_options();foreach(get_rows("SELECT * FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($R))as$K){preg_match('~^CREATE\s+TRIGGER\s*(?:[^`"\s]+|`[^`]*`|"[^"]*")+\s*('.implode("|",$jj["Timing"]).')\s*(.*?)\s+ON\b~i',$K["sql"],$A);$J[$K["name"]]=array($A[1],$A[2]);}return$J;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","UPDATE OF","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
begin(){return
queries("BEGIN");}function
last_id($I){return
get_val("SELECT LAST_INSERT_ROWID()");}function
explain($f,$H){return$f->query("EXPLAIN QUERY PLAN $H");}function
found_rows($S,$Z){}function
types(){return
array();}function
create_sql($R,$_a,$si){$J=get_val("SELECT sql FROM sqlite_master WHERE type IN ('table', 'view') AND name = ".q($R));foreach(indexes($R)as$B=>$v){if($B=='')continue;$J
.=";\n\n".index_sql($R,$v['type'],$B,"(".implode(", ",array_map('Adminer\idf_escape',$v['columns'])).")");}return$J;}function
truncate_sql($R){return"DELETE FROM ".table($R);}function
use_sql($Nb,$si=""){}function
trigger_sql($R){return
implode(get_vals("SELECT sql || ';;\n' FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($R)));}function
show_variables(){$J=array();foreach(get_rows("PRAGMA pragma_list")as$K){$B=$K["name"];if($B!="pragma_list"&&$B!="compile_options"){$J[$B]=array($B,'');foreach(get_rows("PRAGMA $B")as$K)$J[$B][1].=implode(", ",$K)."\n";}}return$J;}function
show_status(){$J=array();foreach(get_vals("PRAGMA compile_options")as$bg)$J[]=explode("=",$bg,2)+array('','');return$J;}function
convert_field($m){}function
unconvert_field($m,$J){return$J;}function
support($Tc){return
preg_match('~^(check|columns|database|drop_col|dump|indexes|descidx|move_col|sql|status|table|trigger|variables|view|view_trigger)$~',$Tc);}}add_driver("pgsql","PostgreSQL");if(isset($_GET["pgsql"])){define('Adminer\DRIVER',"pgsql");if(extension_loaded("pgsql")&&$_GET["ext"]!="pdo"){class
PgsqlDb
extends
SqlDb{var$extension="PgSQL";var$timeout=0;private$link,$string,$database=true;function
_error($Bc,$l){if(ini_bool("html_errors"))$l=html_entity_decode(strip_tags($l));$l=preg_replace('~^[^:]*: ~','',$l);$this->error=$l;}function
attach($N,$V,$F){$j=adminer()->database();set_error_handler(array($this,'_error'));list($Ld,$Ng)=host_port(addcslashes($N,"'\\"));$this->string="host='$Ld'".($Ng?" port='$Ng'":"")." user='".addcslashes($V,"'\\")."' password='".addcslashes($F,"'\\")."'";$ni=adminer()->connectSsl();if(isset($ni["mode"]))$this->string
.=" sslmode='".$ni["mode"]."'";$this->link=@pg_connect("$this->string dbname='".($j!=""?addcslashes($j,"'\\"):"postgres")."'",PGSQL_CONNECT_FORCE_NEW);if(!$this->link&&$j!=""){$this->database=false;$this->link=@pg_connect("$this->string dbname='postgres'",PGSQL_CONNECT_FORCE_NEW);}restore_error_handler();if($this->link)pg_set_client_encoding($this->link,"UTF8");return($this->link?'':$this->error);}function
quote($Q){return(function_exists('pg_escape_literal')?pg_escape_literal($this->link,$Q):"'".pg_escape_string($this->link,$Q)."'");}function
value($X,array$m){return($m["type"]=="bytea"&&$X!==null?pg_unescape_bytea($X):$X);}function
select_db($Nb){if($Nb==adminer()->database())return$this->database;$J=@pg_connect("$this->string dbname='".addcslashes($Nb,"'\\")."'",PGSQL_CONNECT_FORCE_NEW);if($J)$this->link=$J;return$J;}function
close(){$this->link=@pg_connect("$this->string dbname='postgres'");}function
query($H,$oj=false){$I=@pg_query($this->link,$H);$this->error="";if(!$I){$this->error=pg_last_error($this->link);$J=false;}elseif(!pg_num_fields($I)){$this->affected_rows=pg_affected_rows($I);$J=true;}else$J=new
Result($I);if($this->timeout){$this->timeout=0;$this->query("RESET statement_timeout");}return$J;}function
warnings(){return
h(pg_last_notice($this->link));}function
copyFrom($R,array$L){$this->error='';set_error_handler(function($Bc,$l){$this->error=(ini_bool('html_errors')?html_entity_decode($l):$l);return
true;});$J=pg_copy_from($this->link,$R,$L);restore_error_handler();return$J;}}class
Result{var$num_rows;private$result,$offset=0;function
__construct($I){$this->result=$I;$this->num_rows=pg_num_rows($I);}function
fetch_assoc(){return
pg_fetch_assoc($this->result);}function
fetch_row(){return
pg_fetch_row($this->result);}function
fetch_field(){$d=$this->offset++;$J=new
\stdClass;$J->orgtable=pg_field_table($this->result,$d);$J->name=pg_field_name($this->result,$d);$U=pg_field_type($this->result,$d);$J->type=(preg_match(number_type(),$U)?0:15);$J->charsetnr=($U=="bytea"?63:0);return$J;}function
__destruct(){pg_free_result($this->result);}}}elseif(extension_loaded("pdo_pgsql")){class
PgsqlDb
extends
PdoDb{var$extension="PDO_PgSQL";var$timeout=0;function
attach($N,$V,$F){$j=adminer()->database();list($Ld,$Ng)=host_port(addcslashes($N,"'\\"));$mc="pgsql:host='$Ld'".($Ng?" port='$Ng'":"")." client_encoding=utf8 dbname='".($j!=""?addcslashes($j,"'\\"):"postgres")."'";$ni=adminer()->connectSsl();if(isset($ni["mode"]))$mc
.=" sslmode='".$ni["mode"]."'";return$this->dsn($mc,$V,$F);}function
select_db($Nb){return(adminer()->database()==$Nb);}function
query($H,$oj=false){$J=parent::query($H,$oj);if($this->timeout){$this->timeout=0;parent::query("RESET statement_timeout");}return$J;}function
warnings(){}function
copyFrom($R,array$L){$J=$this->pdo->pgsqlCopyFromArray($R,$L);$this->error=idx($this->pdo->errorInfo(),2)?:'';return$J;}function
close(){}}}if(class_exists('Adminer\PgsqlDb')){class
Db
extends
PgsqlDb{function
multi_query($H){if(preg_match('~\bCOPY\s+(.+?)\s+FROM\s+stdin;\n?(.*)\n\\\\\.$~is',str_replace("\r\n","\n",$H),$A)){$L=explode("\n",$A[2]);$this->affected_rows=count($L);return$this->copyFrom($A[1],$L);}return
parent::multi_query($H);}}}class
Driver
extends
SqlDriver{static$extensions=array("PgSQL","PDO_PgSQL");static$jush="pgsql";var$operators=array("=","<",">","<=",">=","!=","~","!~","LIKE","LIKE %%","ILIKE","ILIKE %%","IN","IS NULL","NOT LIKE","NOT ILIKE","NOT IN","IS NOT NULL","SQL");var$functions=array("char_length","lower","round","to_hex","to_timestamp","upper");var$grouping=array("avg","count","count distinct","max","min","sum");var$nsOid="(SELECT oid FROM pg_namespace WHERE nspname = current_schema())";static
function
connect($N,$V,$F){$f=parent::connect($N,$V,$F);if(is_string($f))return$f;$Mj=get_val("SELECT version()",0,$f);$f->flavor=(preg_match('~CockroachDB~',$Mj)?'cockroach':'');$f->server_info=preg_replace('~^\D*([\d.]+[-\w]*).*~','\1',$Mj);if(min_version(9,0,$f))$f->query("SET application_name = 'Adminer'");if($f->flavor=='cockroach')add_driver(DRIVER,"CockroachDB");return$f;}function
__construct(Db$f){parent::__construct($f);$this->types=array('Numbers'=>array("smallint"=>5,"integer"=>10,"bigint"=>19,"boolean"=>1,"numeric"=>0,"real"=>7,"double precision"=>16,"money"=>20),'Date and time'=>array("date"=>13,"time"=>17,"timestamp"=>20,"timestamptz"=>21,"interval"=>0),'Strings'=>array("character"=>0,"character varying"=>0,"text"=>0,"tsquery"=>0,"tsvector"=>0,"uuid"=>0,"xml"=>0),'Binary'=>array("bit"=>0,"bit varying"=>0,"bytea"=>0),'Network'=>array("cidr"=>43,"inet"=>43,"macaddr"=>17,"macaddr8"=>23,"txid_snapshot"=>0),'Geometry'=>array("box"=>0,"circle"=>0,"line"=>0,"lseg"=>0,"path"=>0,"point"=>0,"polygon"=>0),);if(min_version(9.2,0,$f)){$this->types['Strings']["json"]=4294967295;if(min_version(9.4,0,$f))$this->types['Strings']["jsonb"]=4294967295;}$this->insertFunctions=array("char"=>"md5","date|time"=>"now",);$this->editFunctions=array(number_type()=>"+/-","date|time"=>"+ interval/- interval","char|text"=>"||",);if(min_version(12,0,$f))$this->generated=array("STORED");$this->partitionBy=array("RANGE","LIST");if(!$f->flavor)$this->partitionBy[]="HASH";}function
enumLength(array$m){$yc=$this->types['User types'][$m["type"]];return($yc?type_values($yc):"");}function
setUserTypes($nj){$this->types['User types']=array_flip($nj);}function
insertReturning($R){$_a=array_filter(fields($R),function($m){return$m['auto_increment'];});return(count($_a)==1?" RETURNING ".idf_escape(key($_a)):"");}function
insertUpdate($R,array$L,array$G){foreach($L
as$O){$wj=array();$Z=array();foreach($O
as$x=>$X){$wj[]="$x = $X";if(isset($G[idf_unescape($x)]))$Z[]="$x = $X";}if(!(($Z&&queries("UPDATE ".table($R)." SET ".implode(", ",$wj)." WHERE ".implode(" AND ",$Z))&&$this->conn->affected_rows)||queries("INSERT INTO ".table($R)." (".implode(", ",array_keys($O)).") VALUES (".implode(", ",$O).")")))return
false;}return
true;}function
slowQuery($H,$Qi){$this->conn->query("SET statement_timeout = ".(1000*$Qi));$this->conn->timeout=1000*$Qi;return$H;}function
convertSearch($u,array$X,array$m){$Ni="char|text";if(strpos($X["op"],"LIKE")===false)$Ni
.="|date|time(stamp)?|boolean|uuid|inet|cidr|macaddr|".number_type();return(preg_match("~$Ni~",$m["type"])?$u:"CAST($u AS text)");}function
quoteBinary($Dh){return"'\\x".bin2hex($Dh)."'";}function
warnings(){return$this->conn->warnings();}function
tableHelp($B,$xe=false){$Re=array("information_schema"=>"infoschema","pg_catalog"=>($xe?"view":"catalog"),);$_=$Re[$_GET["ns"]];if($_)return"$_-".str_replace("_","-",$B).".html";}function
inheritsFrom($R){return
get_rows("SELECT relname AS table, nspname AS ns FROM pg_class JOIN pg_inherits ON inhparent = oid JOIN pg_namespace ON relnamespace = pg_namespace.oid WHERE inhrelid = ".$this->tableOid($R)." ORDER BY 2, 1");}function
inheritedTables($R){return
get_rows("SELECT relname AS table, nspname AS ns FROM pg_inherits JOIN pg_class ON inhrelid = oid JOIN pg_namespace ON relnamespace = pg_namespace.oid WHERE inhparent = ".$this->tableOid($R)." ORDER BY 2, 1");}function
partitionsInfo($R){$K=(min_version(10)?$this->conn->query("SELECT * FROM pg_partitioned_table WHERE partrelid = ".$this->tableOid($R))->fetch_assoc():null);if($K){$ya=get_vals("SELECT attname FROM pg_attribute WHERE attrelid = $K[partrelid] AND attnum IN (".str_replace(" ",", ",$K["partattrs"]).")");$Oa=array('h'=>'HASH','l'=>'LIST','r'=>'RANGE');return
array("partition_by"=>$Oa[$K["partstrat"]],"partition"=>implode(", ",array_map('Adminer\idf_escape',$ya)),);}return
array();}function
tableOid($R){return"(SELECT oid FROM pg_class WHERE relnamespace = $this->nsOid AND relname = ".q($R)." AND relkind IN ('r', 'm', 'v', 'f', 'p'))";}function
indexAlgorithms(array$yi){static$J=array();if(!$J)$J=get_vals("SELECT amname FROM pg_am".(min_version(9.6)?" WHERE amtype = 'i'":"")." ORDER BY amname = '".($this->conn->flavor=='cockroach'?"prefix":"btree")."' DESC, amname");return$J;}function
supportsIndex(array$S){return$S["Engine"]!="view";}function
hasCStyleEscapes(){static$Qa;if($Qa===null)$Qa=(get_val("SHOW standard_conforming_strings",0,$this->conn)=="off");return$Qa;}}function
idf_escape($u){return'"'.str_replace('"','""',$u).'"';}function
table($u){return
idf_escape($u);}function
get_databases($gd){return
get_vals("SELECT datname FROM pg_database
WHERE datallowconn = TRUE AND has_database_privilege(datname, 'CONNECT')
ORDER BY datname");}function
limit($H,$Z,$z,$C=0,$Rh=" "){return" $H$Z".($z?$Rh."LIMIT $z".($C?" OFFSET $C":""):"");}function
limit1($R,$H,$Z,$Rh="\n"){return(preg_match('~^INTO~',$H)?limit($H,$Z,1,0,$Rh):" $H".(is_view(table_status1($R))?$Z:$Rh."WHERE ctid = (SELECT ctid FROM ".table($R).$Z.$Rh."LIMIT 1)"));}function
db_collation($j,$jb){return
get_val("SELECT datcollate FROM pg_database WHERE datname = ".q($j));}function
logged_user(){return
get_val("SELECT user");}function
tables_list(){$H="SELECT table_name, table_type FROM information_schema.tables WHERE table_schema = current_schema()";if(support("materializedview"))$H
.="
UNION ALL
SELECT matviewname, 'MATERIALIZED VIEW'
FROM pg_matviews
WHERE schemaname = current_schema()";$H
.="
ORDER BY 1";return
get_key_vals($H);}function
count_tables($i){$J=array();foreach($i
as$j){if(connection()->select_db($j))$J[$j]=count(tables_list());}return$J;}function
table_status($B=""){static$Ed;if($Ed===null)$Ed=get_val("SELECT 'pg_table_size'::regproc");$J=array();foreach(get_rows("SELECT
	relname AS \"Name\",
	CASE relkind WHEN 'v' THEN 'view' WHEN 'm' THEN 'materialized view' ELSE 'table' END AS \"Engine\"".($Ed?",
	pg_table_size(c.oid) AS \"Data_length\",
	pg_indexes_size(c.oid) AS \"Index_length\"":"").",
	obj_description(c.oid, 'pg_class') AS \"Comment\",
	".(min_version(12)?"''":"CASE WHEN relhasoids THEN 'oid' ELSE '' END")." AS \"Oid\",
	reltuples AS \"Rows\",
	".(min_version(10)?"relispartition::int AS partition,":"")."
	current_schema() AS nspname
FROM pg_class c
WHERE relkind IN ('r', 'm', 'v', 'f', 'p')
AND relnamespace = ".driver()->nsOid."
".($B!=""?"AND relname = ".q($B):"ORDER BY relname"))as$K)$J[$K["Name"]]=$K;return$J;}function
is_view($S){return
in_array($S["Engine"],array("view","materialized view"));}function
fk_support($S){return
true;}function
fields($R){$J=array();$ra=array('timestamp without time zone'=>'timestamp','timestamp with time zone'=>'timestamptz',);foreach(get_rows("SELECT
	a.attname AS field,
	format_type(a.atttypid, a.atttypmod) AS full_type,
	pg_get_expr(d.adbin, d.adrelid) AS default,
	a.attnotnull::int,
	i.indrelid AS primary,
	col_description(a.attrelid, a.attnum) AS comment".(min_version(10)?",
	a.attidentity".(min_version(12)?",
	a.attgenerated":""):"")."
FROM pg_attribute a
LEFT JOIN pg_attrdef d ON a.attrelid = d.adrelid AND a.attnum = d.adnum
LEFT JOIN pg_index i ON a.attrelid = i.indrelid AND a.attnum = ANY(i.indkey) AND i.indisprimary
WHERE a.attrelid = ".driver()->tableOid($R)."
AND NOT a.attisdropped
AND a.attnum > 0
ORDER BY a.attnum")as$K){preg_match('~([^([]+)(\((.*)\))?([a-z ]+)?((\[[0-9]*])*)$~',$K["full_type"],$A);list(,$U,$y,$K["length"],$ka,$va)=$A;$K["length"].=$va;$Ya=$U.$ka;if(isset($ra[$Ya])){$K["type"]=$ra[$Ya];$K["full_type"]=$K["type"].$y.$va;}else{$K["type"]=$U;$K["full_type"]=$K["type"].$y.$ka.$va;}if(in_array($K['attidentity'],array('a','d')))$K['default']='GENERATED '.($K['attidentity']=='d'?'BY DEFAULT':'ALWAYS').' AS IDENTITY';$K["generated"]=($K["attgenerated"]=="s"?"STORED":"");$K["null"]=!$K["attnotnull"];$K["auto_increment"]=$K['attidentity']||preg_match('~^nextval\(~i',$K["default"])||preg_match('~^unique_rowid\(~',$K["default"]);$K["privileges"]=array("insert"=>1,"select"=>1,"update"=>1,"where"=>1,"order"=>1);if(!$K['generated']&&preg_match('~(.+)::[^,)]+(.*)~',$K["default"],$A))$K["default"]=($A[1]=="NULL"?null:idf_unescape($A[1]).$A[2]);$J[$K["field"]]=$K;}return$J;}function
indexes($R,$g=null){$g=connection($g);$J=array();$Ai=driver()->tableOid($R);$e=get_key_vals("SELECT attnum, attname FROM pg_attribute WHERE attrelid = $Ai AND attnum > 0",$g);foreach(get_rows("SELECT relname, indisunique::int, indisprimary::int, indkey, indoption, amname, pg_get_expr(indpred, indrelid, true) AS partial, pg_get_expr(indexprs, indrelid) AS indexpr
FROM pg_index
JOIN pg_class ON indexrelid = oid
JOIN pg_am ON pg_am.oid = pg_class.relam
WHERE indrelid = $Ai
ORDER BY indisprimary DESC, indisunique DESC",$g)as$K){$rh=$K["relname"];$J[$rh]["type"]=($K["indisprimary"]?"PRIMARY":($K["indisunique"]?"UNIQUE":"INDEX"));$J[$rh]["columns"]=array();$J[$rh]["descs"]=array();$J[$rh]["algorithm"]=$K["amname"];$J[$rh]["partial"]=$K["partial"];$de=preg_split('~(?<=\)), (?=\()~',$K["indexpr"]);foreach(explode(" ",$K["indkey"])as$ee)$J[$rh]["columns"][]=($ee?$e[$ee]:array_shift($de));foreach(explode(" ",$K["indoption"])as$fe)$J[$rh]["descs"][]=(intval($fe)&1?'1':null);$J[$rh]["lengths"]=array();}return$J;}function
foreign_keys($R){$J=array();foreach(get_rows("SELECT conname, condeferrable::int AS deferrable, condeferred::int AS deferred, pg_get_constraintdef(oid) AS definition
FROM pg_constraint
WHERE conrelid = ".driver()->tableOid($R)."
AND contype = 'f'::char
ORDER BY conkey, conname")as$K){$K['deferrable']=($K['deferrable']?'':'NOT ').'DEFERRABLE'.($K['deferred']?' INITIALLY DEFERRED':'');if(preg_match('~FOREIGN KEY\s*\((.+)\)\s*REFERENCES (.+)\((.+)\)(.*)$~iA',$K['definition'],$A)){$K['source']=array_map('Adminer\idf_unescape',array_map('trim',explode(',',$A[1])));if(preg_match('~^(("([^"]|"")+"|[^"]+)\.)?"?("([^"]|"")+"|[^"]+)$~',$A[2],$Xe)){$K['ns']=idf_unescape($Xe[2]);$K['table']=idf_unescape($Xe[4]);}$K['target']=array_map('Adminer\idf_unescape',array_map('trim',explode(',',$A[3])));$K['on_delete']=(preg_match("~ON DELETE (".driver()->onActions.")~",$A[4],$Xe)?$Xe[1]:'NO ACTION');$K['on_update']=(preg_match("~ON UPDATE (".driver()->onActions.")~",$A[4],$Xe)?$Xe[1]:'NO ACTION');$J[$K['conname']]=$K;}}return$J;}function
view($B){return
array("select"=>trim(get_val("SELECT pg_get_viewdef(".driver()->tableOid($B).")")));}function
collations(){return
array();}function
information_schema($j){return
get_schema()=="information_schema";}function
error(){$J=h(connection()->error);if(preg_match('~^(.*\n)?([^\n]*)\n( *)\^(\n.*)?$~s',$J,$A))$J=$A[1].preg_replace('~((?:[^&]|&[^;]*;){'.strlen($A[3]).'})(.*)~','\1<b>\2</b>',$A[2]).$A[4];return
nl_br($J);}function
create_database($j,$c){return
queries("CREATE DATABASE ".idf_escape($j).($c?" ENCODING ".idf_escape($c):""));}function
drop_databases($i){connection()->close();return
apply_queries("DROP DATABASE",$i,'Adminer\idf_escape');}function
rename_database($B,$c){connection()->close();return
queries("ALTER DATABASE ".idf_escape(DB)." RENAME TO ".idf_escape($B));}function
auto_increment(){return"";}function
alter_table($R,$B,$n,$id,$ob,$wc,$c,$_a,$E){$b=array();$eh=array();if($R!=""&&$R!=$B)$eh[]="ALTER TABLE ".table($R)." RENAME TO ".table($B);$Sh="";foreach($n
as$m){$d=idf_escape($m[0]);$X=$m[1];if(!$X)$b[]="DROP $d";else{$Ij=$X[5];unset($X[5]);if($m[0]==""){if(isset($X[6]))$X[1]=($X[1]==" bigint"?" big":($X[1]==" smallint"?" small":" "))."serial";$b[]=($R!=""?"ADD ":"  ").implode($X);if(isset($X[6]))$b[]=($R!=""?"ADD":" ")." PRIMARY KEY ($X[0])";}else{if($d!=$X[0])$eh[]="ALTER TABLE ".table($B)." RENAME $d TO $X[0]";$b[]="ALTER $d TYPE$X[1]";$Th=$R."_".idf_unescape($X[0])."_seq";$b[]="ALTER $d ".($X[3]?"SET".preg_replace('~GENERATED ALWAYS(.*) STORED~','EXPRESSION\1',$X[3]):(isset($X[6])?"SET DEFAULT nextval(".q($Th).")":"DROP DEFAULT"));if(isset($X[6]))$Sh="CREATE SEQUENCE IF NOT EXISTS ".idf_escape($Th)." OWNED BY ".idf_escape($R).".$X[0]";$b[]="ALTER $d ".($X[2]==" NULL"?"DROP NOT":"SET").$X[2];}if($m[0]!=""||$Ij!="")$eh[]="COMMENT ON COLUMN ".table($B).".$X[0] IS ".($Ij!=""?substr($Ij,9):"''");}}$b=array_merge($b,$id);if($R==""){$P="";if($E){$eb=(connection()->flavor=='cockroach');$P=" PARTITION BY $E[partition_by]($E[partition])";if($E["partition_by"]=='HASH'){$Dg=+$E["partitions"];for($s=0;$s<$Dg;$s++)$eh[]="CREATE TABLE ".idf_escape($B."_$s")." PARTITION OF ".idf_escape($B)." FOR VALUES WITH (MODULUS $Dg, REMAINDER $s)";}else{$Vg="MINVALUE";foreach($E["partition_names"]as$s=>$X){$Y=$E["partition_values"][$s];$_g=" VALUES ".($E["partition_by"]=='LIST'?"IN ($Y)":"FROM ($Vg) TO ($Y)");if($eb)$P
.=($s?",":" (")."\n  PARTITION ".(preg_match('~^DEFAULT$~i',$X)?$X:idf_escape($X))."$_g";else$eh[]="CREATE TABLE ".idf_escape($B."_$X")." PARTITION OF ".idf_escape($B)." FOR$_g";$Vg=$Y;}$P
.=($eb?"\n)":"");}}array_unshift($eh,"CREATE TABLE ".table($B)." (\n".implode(",\n",$b)."\n)$P");}elseif($b)array_unshift($eh,"ALTER TABLE ".table($R)."\n".implode(",\n",$b));if($Sh)array_unshift($eh,$Sh);if($ob!==null)$eh[]="COMMENT ON TABLE ".table($B)." IS ".q($ob);foreach($eh
as$H){if(!queries($H))return
false;}return
true;}function
alter_indexes($R,$b){$h=array();$hc=array();$eh=array();foreach($b
as$X){if($X[0]!="INDEX")$h[]=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");elseif($X[2]=="DROP")$hc[]=idf_escape($X[1]);else$eh[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($R."_"))." ON ".table($R).($X[3]?" USING $X[3]":"")." (".implode(", ",$X[2]).")".($X[4]?" WHERE $X[4]":"");}if($h)array_unshift($eh,"ALTER TABLE ".table($R).implode(",",$h));if($hc)array_unshift($eh,"DROP INDEX ".implode(", ",$hc));foreach($eh
as$H){if(!queries($H))return
false;}return
true;}function
truncate_tables($T){return
queries("TRUNCATE ".implode(", ",array_map('Adminer\table',$T)));}function
drop_views($Oj){return
drop_tables($Oj);}function
drop_tables($T){foreach($T
as$R){$P=table_status1($R);if(!queries("DROP ".strtoupper($P["Engine"])." ".table($R)))return
false;}return
true;}function
move_tables($T,$Oj,$Ii){foreach(array_merge($T,$Oj)as$R){$P=table_status1($R);if(!queries("ALTER ".strtoupper($P["Engine"])." ".table($R)." SET SCHEMA ".idf_escape($Ii)))return
false;}return
true;}function
trigger($B,$R){if($B=="")return
array("Statement"=>"EXECUTE PROCEDURE ()");$e=array();$Z="WHERE trigger_schema = current_schema() AND event_object_table = ".q($R)." AND trigger_name = ".q($B);foreach(get_rows("SELECT * FROM information_schema.triggered_update_columns $Z")as$K)$e[]=$K["event_object_column"];$J=array();foreach(get_rows('SELECT trigger_name AS "Trigger", action_timing AS "Timing", event_manipulation AS "Event", \'FOR EACH \' || action_orientation AS "Type", action_statement AS "Statement"
FROM information_schema.triggers'."
$Z
ORDER BY event_manipulation DESC")as$K){if($e&&$K["Event"]=="UPDATE")$K["Event"].=" OF";$K["Of"]=implode(", ",$e);if($J)$K["Event"].=" OR $J[Event]";$J=$K;}return$J;}function
triggers($R){$J=array();foreach(get_rows("SELECT * FROM information_schema.triggers WHERE trigger_schema = current_schema() AND event_object_table = ".q($R))as$K){$hj=trigger($K["trigger_name"],$R);$J[$hj["Trigger"]]=array($hj["Timing"],$hj["Event"]);}return$J;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","UPDATE OF","DELETE","INSERT OR UPDATE","INSERT OR UPDATE OF","DELETE OR INSERT","DELETE OR UPDATE","DELETE OR UPDATE OF","DELETE OR INSERT OR UPDATE","DELETE OR INSERT OR UPDATE OF"),"Type"=>array("FOR EACH ROW","FOR EACH STATEMENT"),);}function
routine($B,$U){$L=get_rows('SELECT routine_definition AS definition, LOWER(external_language) AS language, *
FROM information_schema.routines
WHERE routine_schema = current_schema() AND specific_name = '.q($B));$J=idx($L,0,array());$J["returns"]=array("type"=>$J["type_udt_name"]);$J["fields"]=get_rows('SELECT COALESCE(parameter_name, ordinal_position::text) AS field, data_type AS type, character_maximum_length AS length, parameter_mode AS inout
FROM information_schema.parameters
WHERE specific_schema = current_schema() AND specific_name = '.q($B).'
ORDER BY ordinal_position');return$J;}function
routines(){return
get_rows('SELECT specific_name AS "SPECIFIC_NAME", routine_type AS "ROUTINE_TYPE", routine_name AS "ROUTINE_NAME", type_udt_name AS "DTD_IDENTIFIER"
FROM information_schema.routines
WHERE routine_schema = current_schema()
ORDER BY SPECIFIC_NAME');}function
routine_languages(){return
get_vals("SELECT LOWER(lanname) FROM pg_catalog.pg_language");}function
routine_id($B,$K){$J=array();foreach($K["fields"]as$m){$y=$m["length"];$J[]=$m["type"].($y?"($y)":"");}return
idf_escape($B)."(".implode(", ",$J).")";}function
last_id($I){$K=(is_object($I)?$I->fetch_row():array());return($K?$K[0]:0);}function
explain($f,$H){return$f->query("EXPLAIN $H");}function
found_rows($S,$Z){if(preg_match("~ rows=([0-9]+)~",get_val("EXPLAIN SELECT * FROM ".idf_escape($S["Name"]).($Z?" WHERE ".implode(" AND ",$Z):"")),$qh))return$qh[1];}function
types(){return
get_key_vals("SELECT oid, typname
FROM pg_type
WHERE typnamespace = ".driver()->nsOid."
AND typtype IN ('b','d','e')
AND typelem = 0");}function
type_values($t){$Ac=get_vals("SELECT enumlabel FROM pg_enum WHERE enumtypid = $t ORDER BY enumsortorder");return($Ac?"'".implode("', '",array_map('addslashes',$Ac))."'":"");}function
schemas(){return
get_vals("SELECT nspname FROM pg_namespace ORDER BY nspname");}function
get_schema(){return
get_val("SELECT current_schema()");}function
set_schema($Fh,$g=null){if(!$g)$g=connection();$J=$g->query("SET search_path TO ".idf_escape($Fh));driver()->setUserTypes(types());return$J;}function
foreign_keys_sql($R){$J="";$P=table_status1($R);$ed=foreign_keys($R);ksort($ed);foreach($ed
as$dd=>$cd)$J
.="ALTER TABLE ONLY ".idf_escape($P['nspname']).".".idf_escape($P['Name'])." ADD CONSTRAINT ".idf_escape($dd)." $cd[definition];\n";return($J?"$J\n":$J);}function
create_sql($R,$_a,$si){$wh=array();$Uh=array();$P=table_status1($R);$Hf=idf_escape($P['nspname']);if(is_view($P)){$Nj=view($R);return
rtrim("CREATE VIEW $Hf.".idf_escape($R)." AS $Nj[select]",";");}$n=fields($R);if(count($P)<2||empty($n))return
false;$J="CREATE TABLE $Hf.".idf_escape($P['Name'])." (\n    ";foreach($n
as$m){$yg=idf_escape($m['field']).' '.$m['full_type'].default_value($m).($m['null']?"":" NOT NULL");$wh[]=$yg;if(preg_match('~nextval\(\'([^\']+)\'\)~',$m['default'],$Ze)){$Th=$Ze[1];$hi=first(get_rows((min_version(10)?"SELECT *, cache_size AS cache_value FROM pg_sequences WHERE schemaname = current_schema() AND sequencename = ".q(idf_unescape($Th)):"SELECT * FROM $Th"),null,"-- "));$Uh[]=($si=="DROP+CREATE"?"DROP SEQUENCE IF EXISTS $Hf.$Th;\n":"")."CREATE SEQUENCE $Hf.$Th INCREMENT $hi[increment_by] MINVALUE $hi[min_value] MAXVALUE $hi[max_value]".($_a&&$hi['last_value']?" START ".($hi["last_value"]+1):"")." CACHE $hi[cache_value];";}}if(!empty($Uh))$J=implode("\n\n",$Uh)."\n\n$J";$G="";foreach(indexes($R)as$be=>$v){if($v['type']=='PRIMARY'){$G=$be;$wh[]="CONSTRAINT ".idf_escape($be)." PRIMARY KEY (".implode(', ',array_map('Adminer\idf_escape',$v['columns'])).")";}}foreach(driver()->checkConstraints($R)as$ub=>$wb)$wh[]="CONSTRAINT ".idf_escape($ub)." CHECK ($wb)";$J
.=implode(",\n    ",$wh)."\n)";$_g=driver()->partitionsInfo($P['Name']);if($_g)$J
.="\nPARTITION BY $_g[partition_by]($_g[partition])";$J
.="\nWITH (oids = ".($P['Oid']?'true':'false').");";if($P['Comment'])$J
.="\n\nCOMMENT ON TABLE $Hf.".idf_escape($P['Name'])." IS ".q($P['Comment']).";";foreach($n
as$Vc=>$m){if($m['comment'])$J
.="\n\nCOMMENT ON COLUMN $Hf.".idf_escape($P['Name']).".".idf_escape($Vc)." IS ".q($m['comment']).";";}foreach(get_rows("SELECT indexdef FROM pg_catalog.pg_indexes WHERE schemaname = current_schema() AND tablename = ".q($R).($G?" AND indexname != ".q($G):""),null,"-- ")as$K)$J
.="\n\n$K[indexdef];";return
rtrim($J,';');}function
truncate_sql($R){return"TRUNCATE ".table($R);}function
trigger_sql($R){$P=table_status1($R);$J="";foreach(triggers($R)as$gj=>$fj){$hj=trigger($gj,$P['Name']);$J
.="\nCREATE TRIGGER ".idf_escape($hj['Trigger'])." $hj[Timing] $hj[Event] ON ".idf_escape($P["nspname"]).".".idf_escape($P['Name'])." $hj[Type] $hj[Statement];;\n";}return$J;}function
use_sql($Nb,$si=""){$B=idf_escape($Nb);$J="";if(preg_match('~CREATE~',$si)){if($si=="DROP+CREATE")$J="DROP DATABASE IF EXISTS $B;\n";$J
.="CREATE DATABASE $B;\n";}return"$J\\connect $B";}function
show_variables(){return
get_rows("SHOW ALL");}function
process_list(){return
get_rows("SELECT * FROM pg_stat_activity ORDER BY ".(min_version(9.2)?"pid":"procpid"));}function
convert_field($m){}function
unconvert_field($m,$J){return$J;}function
support($Tc){return
preg_match('~^(check|columns|comment|database|drop_col|dump|descidx|indexes|kill|partial_indexes|routine|scheme|sequence|sql|table|trigger|type|variables|view'.(min_version(9.3)?'|materializedview':'').(min_version(11)?'|procedure':'').(connection()->flavor=='cockroach'?'':'|processlist').')$~',$Tc);}function
kill_process($X){return
queries("SELECT pg_terminate_backend(".number($X).")");}function
connection_id(){return"SELECT pg_backend_pid()";}function
max_connections(){return
get_val("SHOW max_connections");}}add_driver("oracle","Oracle (beta)");if(isset($_GET["oracle"])){define('Adminer\DRIVER',"oracle");if(extension_loaded("oci8")&&$_GET["ext"]!="pdo"){class
Db
extends
SqlDb{var$extension="oci8";var$_current_db;private$link;function
_error($Bc,$l){if(ini_bool("html_errors"))$l=html_entity_decode(strip_tags($l));$l=preg_replace('~^[^:]*: ~','',$l);$this->error=$l;}function
attach($N,$V,$F){$this->link=@oci_new_connect($V,$F,$N,"AL32UTF8");if($this->link){$this->server_info=oci_server_version($this->link);return'';}$l=oci_error();return$l["message"];}function
quote($Q){return"'".str_replace("'","''",$Q)."'";}function
select_db($Nb){$this->_current_db=$Nb;return
true;}function
query($H,$oj=false){$I=oci_parse($this->link,$H);$this->error="";if(!$I){$l=oci_error($this->link);$this->errno=$l["code"];$this->error=$l["message"];return
false;}set_error_handler(array($this,'_error'));$J=@oci_execute($I);restore_error_handler();if($J){if(oci_num_fields($I))return
new
Result($I);$this->affected_rows=oci_num_rows($I);oci_free_statement($I);}return$J;}function
timeout($vf){return
oci_set_call_timeout($this->link,$vf);}}class
Result{var$num_rows;private$result,$offset=1;function
__construct($I){$this->result=$I;}private
function
convert($K){foreach((array)$K
as$x=>$X){if(is_a($X,'OCILob')||is_a($X,'OCI-Lob'))$K[$x]=$X->load();}return$K;}function
fetch_assoc(){return$this->convert(oci_fetch_assoc($this->result));}function
fetch_row(){return$this->convert(oci_fetch_row($this->result));}function
fetch_field(){$d=$this->offset++;$J=new
\stdClass;$J->name=oci_field_name($this->result,$d);$J->type=oci_field_type($this->result,$d);$J->charsetnr=(preg_match("~raw|blob|bfile~",$J->type)?63:0);return$J;}function
__destruct(){oci_free_statement($this->result);}}}elseif(extension_loaded("pdo_oci")){class
Db
extends
PdoDb{var$extension="PDO_OCI";var$_current_db;function
attach($N,$V,$F){return$this->dsn("oci:dbname=//$N;charset=AL32UTF8",$V,$F);}function
select_db($Nb){$this->_current_db=$Nb;return
true;}}}class
Driver
extends
SqlDriver{static$extensions=array("OCI8","PDO_OCI");static$jush="oracle";var$insertFunctions=array("date"=>"current_date","timestamp"=>"current_timestamp",);var$editFunctions=array("number|float|double"=>"+/-","date|timestamp"=>"+ interval/- interval","char|clob"=>"||",);var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL");var$functions=array("length","lower","round","upper");var$grouping=array("avg","count","count distinct","max","min","sum");function
__construct(Db$f){parent::__construct($f);$this->types=array('Numbers'=>array("number"=>38,"binary_float"=>12,"binary_double"=>21),'Date and time'=>array("date"=>10,"timestamp"=>29,"interval year"=>12,"interval day"=>28),'Strings'=>array("char"=>2000,"varchar2"=>4000,"nchar"=>2000,"nvarchar2"=>4000,"clob"=>4294967295,"nclob"=>4294967295),'Binary'=>array("raw"=>2000,"long raw"=>2147483648,"blob"=>4294967295,"bfile"=>4294967296),);}function
begin(){return
true;}function
insertUpdate($R,array$L,array$G){foreach($L
as$O){$wj=array();$Z=array();foreach($O
as$x=>$X){$wj[]="$x = $X";if(isset($G[idf_unescape($x)]))$Z[]="$x = $X";}if(!(($Z&&queries("UPDATE ".table($R)." SET ".implode(", ",$wj)." WHERE ".implode(" AND ",$Z))&&$this->conn->affected_rows)||queries("INSERT INTO ".table($R)." (".implode(", ",array_keys($O)).") VALUES (".implode(", ",$O).")")))return
false;}return
true;}function
hasCStyleEscapes(){return
true;}}function
idf_escape($u){return'"'.str_replace('"','""',$u).'"';}function
table($u){return
idf_escape($u);}function
get_databases($gd){return
get_vals("SELECT DISTINCT tablespace_name FROM (
SELECT tablespace_name FROM user_tablespaces
UNION SELECT tablespace_name FROM all_tables WHERE tablespace_name IS NOT NULL
)
ORDER BY 1");}function
limit($H,$Z,$z,$C=0,$Rh=" "){return($C?" * FROM (SELECT t.*, rownum AS rnum FROM (SELECT $H$Z) t WHERE rownum <= ".($z+$C).") WHERE rnum > $C":($z?" * FROM (SELECT $H$Z) WHERE rownum <= ".($z+$C):" $H$Z"));}function
limit1($R,$H,$Z,$Rh="\n"){return" $H$Z";}function
db_collation($j,$jb){return
get_val("SELECT value FROM nls_database_parameters WHERE parameter = 'NLS_CHARACTERSET'");}function
logged_user(){return
get_val("SELECT USER FROM DUAL");}function
get_current_db(){$j=connection()->_current_db?:DB;unset(connection()->_current_db);return$j;}function
where_owner($Tg,$sg="owner"){if(!$_GET["ns"])return'';return"$Tg$sg = sys_context('USERENV', 'CURRENT_SCHEMA')";}function
views_table($e){$sg=where_owner('');return"(SELECT $e FROM all_views WHERE ".($sg?:"rownum < 0").")";}function
tables_list(){$Nj=views_table("view_name");$sg=where_owner(" AND ");return
get_key_vals("SELECT table_name, 'table' FROM all_tables WHERE tablespace_name = ".q(DB)."$sg
UNION SELECT view_name, 'view' FROM $Nj
ORDER BY 1");}function
count_tables($i){$J=array();foreach($i
as$j)$J[$j]=get_val("SELECT COUNT(*) FROM all_tables WHERE tablespace_name = ".q($j));return$J;}function
table_status($B=""){$J=array();$Kh=q($B);$j=get_current_db();$Nj=views_table("view_name");$sg=where_owner(" AND ");foreach(get_rows('SELECT table_name "Name", \'table\' "Engine", avg_row_len * num_rows "Data_length", num_rows "Rows" FROM all_tables WHERE tablespace_name = '.q($j).$sg.($B!=""?" AND table_name = $Kh":"")."
UNION SELECT view_name, 'view', 0, 0 FROM $Nj".($B!=""?" WHERE view_name = $Kh":"")."
ORDER BY 1")as$K)$J[$K["Name"]]=$K;return$J;}function
is_view($S){return$S["Engine"]=="view";}function
fk_support($S){return
true;}function
fields($R){$J=array();$sg=where_owner(" AND ");foreach(get_rows("SELECT * FROM all_tab_columns WHERE table_name = ".q($R)."$sg ORDER BY column_id")as$K){$U=$K["DATA_TYPE"];$y="$K[DATA_PRECISION],$K[DATA_SCALE]";if($y==",")$y=$K["CHAR_COL_DECL_LENGTH"];$J[$K["COLUMN_NAME"]]=array("field"=>$K["COLUMN_NAME"],"full_type"=>$U.($y?"($y)":""),"type"=>strtolower($U),"length"=>$y,"default"=>$K["DATA_DEFAULT"],"null"=>($K["NULLABLE"]=="Y"),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1,"where"=>1,"order"=>1),);}return$J;}function
indexes($R,$g=null){$J=array();$sg=where_owner(" AND ","aic.table_owner");foreach(get_rows("SELECT aic.*, ac.constraint_type, atc.data_default
FROM all_ind_columns aic
LEFT JOIN all_constraints ac ON aic.index_name = ac.constraint_name AND aic.table_name = ac.table_name AND aic.index_owner = ac.owner
LEFT JOIN all_tab_cols atc ON aic.column_name = atc.column_name AND aic.table_name = atc.table_name AND aic.index_owner = atc.owner
WHERE aic.table_name = ".q($R)."$sg
ORDER BY ac.constraint_type, aic.column_position",$g)as$K){$be=$K["INDEX_NAME"];$lb=$K["DATA_DEFAULT"];$lb=($lb?trim($lb,'"'):$K["COLUMN_NAME"]);$J[$be]["type"]=($K["CONSTRAINT_TYPE"]=="P"?"PRIMARY":($K["CONSTRAINT_TYPE"]=="U"?"UNIQUE":"INDEX"));$J[$be]["columns"][]=$lb;$J[$be]["lengths"][]=($K["CHAR_LENGTH"]&&$K["CHAR_LENGTH"]!=$K["COLUMN_LENGTH"]?$K["CHAR_LENGTH"]:null);$J[$be]["descs"][]=($K["DESCEND"]&&$K["DESCEND"]=="DESC"?'1':null);}return$J;}function
view($B){$Nj=views_table("view_name, text");$L=get_rows('SELECT text "select" FROM '.$Nj.' WHERE view_name = '.q($B));return
reset($L);}function
collations(){return
array();}function
information_schema($j){return
get_schema()=="INFORMATION_SCHEMA";}function
error(){return
h(connection()->error);}function
explain($f,$H){$f->query("EXPLAIN PLAN FOR $H");return$f->query("SELECT * FROM plan_table");}function
found_rows($S,$Z){}function
auto_increment(){return"";}function
alter_table($R,$B,$n,$id,$ob,$wc,$c,$_a,$E){$b=$hc=array();$lg=($R?fields($R):array());foreach($n
as$m){$X=$m[1];if($X&&$m[0]!=""&&idf_escape($m[0])!=$X[0])queries("ALTER TABLE ".table($R)." RENAME COLUMN ".idf_escape($m[0])." TO $X[0]");$kg=$lg[$m[0]];if($X&&$kg){$Of=process_field($kg,$kg);if($X[2]==$Of[2])$X[2]="";}if($X)$b[]=($R!=""?($m[0]!=""?"MODIFY (":"ADD ("):"  ").implode($X).($R!=""?")":"");else$hc[]=idf_escape($m[0]);}if($R=="")return
queries("CREATE TABLE ".table($B)." (\n".implode(",\n",$b)."\n)");return(!$b||queries("ALTER TABLE ".table($R)."\n".implode("\n",$b)))&&(!$hc||queries("ALTER TABLE ".table($R)." DROP (".implode(", ",$hc).")"))&&($R==$B||queries("ALTER TABLE ".table($R)." RENAME TO ".table($B)));}function
alter_indexes($R,$b){$hc=array();$eh=array();foreach($b
as$X){if($X[0]!="INDEX"){$X[2]=preg_replace('~ DESC$~','',$X[2]);$h=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");array_unshift($eh,"ALTER TABLE ".table($R).$h);}elseif($X[2]=="DROP")$hc[]=idf_escape($X[1]);else$eh[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($R."_"))." ON ".table($R)." (".implode(", ",$X[2]).")";}if($hc)array_unshift($eh,"DROP INDEX ".implode(", ",$hc));foreach($eh
as$H){if(!queries($H))return
false;}return
true;}function
foreign_keys($R){$J=array();$H="SELECT c_list.CONSTRAINT_NAME as NAME,
c_src.COLUMN_NAME as SRC_COLUMN,
c_dest.OWNER as DEST_DB,
c_dest.TABLE_NAME as DEST_TABLE,
c_dest.COLUMN_NAME as DEST_COLUMN,
c_list.DELETE_RULE as ON_DELETE
FROM ALL_CONSTRAINTS c_list, ALL_CONS_COLUMNS c_src, ALL_CONS_COLUMNS c_dest
WHERE c_list.CONSTRAINT_NAME = c_src.CONSTRAINT_NAME
AND c_list.R_CONSTRAINT_NAME = c_dest.CONSTRAINT_NAME
AND c_list.CONSTRAINT_TYPE = 'R'
AND c_src.TABLE_NAME = ".q($R);foreach(get_rows($H)as$K)$J[$K['NAME']]=array("db"=>$K['DEST_DB'],"table"=>$K['DEST_TABLE'],"source"=>array($K['SRC_COLUMN']),"target"=>array($K['DEST_COLUMN']),"on_delete"=>$K['ON_DELETE'],"on_update"=>null,);return$J;}function
truncate_tables($T){return
apply_queries("TRUNCATE TABLE",$T);}function
drop_views($Oj){return
apply_queries("DROP VIEW",$Oj);}function
drop_tables($T){return
apply_queries("DROP TABLE",$T);}function
last_id($I){return
0;}function
schemas(){$J=get_vals("SELECT DISTINCT owner FROM dba_segments WHERE owner IN (SELECT username FROM dba_users WHERE default_tablespace NOT IN ('SYSTEM','SYSAUX')) ORDER BY 1");return($J?:get_vals("SELECT DISTINCT owner FROM all_tables WHERE tablespace_name = ".q(DB)." ORDER BY 1"));}function
get_schema(){return
get_val("SELECT sys_context('USERENV', 'SESSION_USER') FROM dual");}function
set_schema($Hh,$g=null){if(!$g)$g=connection();return$g->query("ALTER SESSION SET CURRENT_SCHEMA = ".idf_escape($Hh));}function
show_variables(){return
get_rows('SELECT name, display_value FROM v$parameter');}function
show_status(){$J=array();$L=get_rows('SELECT * FROM v$instance');foreach(reset($L)as$x=>$X)$J[]=array($x,$X);return$J;}function
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
convert_field($m){}function
unconvert_field($m,$J){return$J;}function
support($Tc){return
preg_match('~^(columns|database|drop_col|indexes|descidx|processlist|scheme|sql|status|table|variables|view)$~',$Tc);}}add_driver("mssql","MS SQL");if(isset($_GET["mssql"])){define('Adminer\DRIVER',"mssql");if(extension_loaded("sqlsrv")&&$_GET["ext"]!="pdo"){class
Db
extends
SqlDb{var$extension="sqlsrv";private$link,$result;private
function
get_error(){$this->error="";foreach(sqlsrv_errors()as$l){$this->errno=$l["code"];$this->error
.="$l[message]\n";}$this->error=rtrim($this->error);}function
attach($N,$V,$F){$vb=array("UID"=>$V,"PWD"=>$F,"CharacterSet"=>"UTF-8");$ni=adminer()->connectSsl();if(isset($ni["Encrypt"]))$vb["Encrypt"]=$ni["Encrypt"];if(isset($ni["TrustServerCertificate"]))$vb["TrustServerCertificate"]=$ni["TrustServerCertificate"];$j=adminer()->database();if($j!="")$vb["Database"]=$j;list($Ld,$Ng)=host_port($N);$this->link=@sqlsrv_connect($Ld.($Ng?",$Ng":""),$vb);if($this->link){$ge=sqlsrv_server_info($this->link);$this->server_info=$ge['SQLServerVersion'];}else$this->get_error();return($this->link?'':$this->error);}function
quote($Q){$pj=strlen($Q)!=strlen(utf8_decode($Q));return($pj?"N":"")."'".str_replace("'","''",$Q)."'";}function
select_db($Nb){return$this->query(use_sql($Nb));}function
query($H,$oj=false){$I=sqlsrv_query($this->link,$H);$this->error="";if(!$I){$this->get_error();return
false;}return$this->store_result($I);}function
multi_query($H){$this->result=sqlsrv_query($this->link,$H);$this->error="";if(!$this->result){$this->get_error();return
false;}return
true;}function
store_result($I=null){if(!$I)$I=$this->result;if(!$I)return
false;if(sqlsrv_field_metadata($I))return
new
Result($I);$this->affected_rows=sqlsrv_rows_affected($I);return
true;}function
next_result(){return$this->result?!!sqlsrv_next_result($this->result):false;}}class
Result{var$num_rows;private$result,$offset=0,$fields;function
__construct($I){$this->result=$I;}private
function
convert($K){foreach((array)$K
as$x=>$X){if(is_a($X,'DateTime'))$K[$x]=$X->format("Y-m-d H:i:s");}return$K;}function
fetch_assoc(){return$this->convert(sqlsrv_fetch_array($this->result,SQLSRV_FETCH_ASSOC));}function
fetch_row(){return$this->convert(sqlsrv_fetch_array($this->result,SQLSRV_FETCH_NUMERIC));}function
fetch_field(){if(!$this->fields)$this->fields=sqlsrv_field_metadata($this->result);$m=$this->fields[$this->offset++];$J=new
\stdClass;$J->name=$m["Name"];$J->type=($m["Type"]==1?254:15);$J->charsetnr=0;return$J;}function
seek($C){for($s=0;$s<$C;$s++)sqlsrv_fetch($this->result);}function
__destruct(){sqlsrv_free_stmt($this->result);}}function
last_id($I){return
get_val("SELECT SCOPE_IDENTITY()");}function
explain($f,$H){$f->query("SET SHOWPLAN_ALL ON");$J=$f->query($H);$f->query("SET SHOWPLAN_ALL OFF");return$J;}}else{abstract
class
MssqlDb
extends
PdoDb{function
select_db($Nb){return$this->query(use_sql($Nb));}function
lastInsertId(){return$this->pdo->lastInsertId();}}function
last_id($I){return
connection()->lastInsertId();}function
explain($f,$H){}if(extension_loaded("pdo_sqlsrv")){class
Db
extends
MssqlDb{var$extension="PDO_SQLSRV";function
attach($N,$V,$F){list($Ld,$Ng)=host_port($N);return$this->dsn("sqlsrv:Server=$Ld".($Ng?",$Ng":""),$V,$F);}}}elseif(extension_loaded("pdo_dblib")){class
Db
extends
MssqlDb{var$extension="PDO_DBLIB";function
attach($N,$V,$F){list($Ld,$Ng)=host_port($N);return$this->dsn("dblib:charset=utf8;host=$Ld".($Ng?(is_numeric($Ng)?";port=":";unix_socket=").$Ng:""),$V,$F);}}}}class
Driver
extends
SqlDriver{static$extensions=array("SQLSRV","PDO_SQLSRV","PDO_DBLIB");static$jush="mssql";var$insertFunctions=array("date|time"=>"getdate");var$editFunctions=array("int|decimal|real|float|money|datetime"=>"+/-","char|text"=>"+",);var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL");var$functions=array("len","lower","round","upper");var$grouping=array("avg","count","count distinct","max","min","sum");var$generated=array("PERSISTED","VIRTUAL");var$onActions="NO ACTION|CASCADE|SET NULL|SET DEFAULT";static
function
connect($N,$V,$F){if($N=="")$N="localhost:1433";return
parent::connect($N,$V,$F);}function
__construct(Db$f){parent::__construct($f);$this->types=array('Numbers'=>array("tinyint"=>3,"smallint"=>5,"int"=>10,"bigint"=>20,"bit"=>1,"decimal"=>0,"real"=>12,"float"=>53,"smallmoney"=>10,"money"=>20),'Date and time'=>array("date"=>10,"smalldatetime"=>19,"datetime"=>19,"datetime2"=>19,"time"=>8,"datetimeoffset"=>10),'Strings'=>array("char"=>8000,"varchar"=>8000,"text"=>2147483647,"nchar"=>4000,"nvarchar"=>4000,"ntext"=>1073741823),'Binary'=>array("binary"=>8000,"varbinary"=>8000,"image"=>2147483647),);}function
insertUpdate($R,array$L,array$G){$n=fields($R);$wj=array();$Z=array();$O=reset($L);$e="c".implode(", c",range(1,count($O)));$Pa=0;$me=array();foreach($O
as$x=>$X){$Pa++;$B=idf_unescape($x);if(!$n[$B]["auto_increment"])$me[$x]="c$Pa";if(isset($G[$B]))$Z[]="$x = c$Pa";else$wj[]="$x = c$Pa";}$Jj=array();foreach($L
as$O)$Jj[]="(".implode(", ",$O).")";if($Z){$Qd=queries("SET IDENTITY_INSERT ".table($R)." ON");$J=queries("MERGE ".table($R)." USING (VALUES\n\t".implode(",\n\t",$Jj)."\n) AS source ($e) ON ".implode(" AND ",$Z).($wj?"\nWHEN MATCHED THEN UPDATE SET ".implode(", ",$wj):"")."\nWHEN NOT MATCHED THEN INSERT (".implode(", ",array_keys($Qd?$O:$me)).") VALUES (".($Qd?$e:implode(", ",$me)).");");if($Qd)queries("SET IDENTITY_INSERT ".table($R)." OFF");}else$J=queries("INSERT INTO ".table($R)." (".implode(", ",array_keys($O)).") VALUES\n".implode(",\n",$Jj));return$J;}function
begin(){return
queries("BEGIN TRANSACTION");}function
tableHelp($B,$xe=false){$Re=array("sys"=>"catalog-views/sys-","INFORMATION_SCHEMA"=>"information-schema-views/",);$_=$Re[get_schema()];if($_)return"relational-databases/system-$_".preg_replace('~_~','-',strtolower($B))."-transact-sql";}}function
idf_escape($u){return"[".str_replace("]","]]",$u)."]";}function
table($u){return($_GET["ns"]!=""?idf_escape($_GET["ns"]).".":"").idf_escape($u);}function
get_databases($gd){return
get_vals("SELECT name FROM sys.databases WHERE name NOT IN ('master', 'tempdb', 'model', 'msdb')");}function
limit($H,$Z,$z,$C=0,$Rh=" "){return($z?" TOP (".($z+$C).")":"")." $H$Z";}function
limit1($R,$H,$Z,$Rh="\n"){return
limit($H,$Z,1,0,$Rh);}function
db_collation($j,$jb){return
get_val("SELECT collation_name FROM sys.databases WHERE name = ".q($j));}function
logged_user(){return
get_val("SELECT SUSER_NAME()");}function
tables_list(){return
get_key_vals("SELECT name, type_desc FROM sys.all_objects WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ORDER BY name");}function
count_tables($i){$J=array();foreach($i
as$j){connection()->select_db($j);$J[$j]=get_val("SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES");}return$J;}function
table_status($B=""){$J=array();foreach(get_rows("SELECT ao.name AS Name, ao.type_desc AS Engine, (SELECT value FROM fn_listextendedproperty(default, 'SCHEMA', schema_name(schema_id), 'TABLE', ao.name, null, null)) AS Comment
FROM sys.all_objects AS ao
WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') ".($B!=""?"AND name = ".q($B):"ORDER BY name"))as$K)$J[$K["Name"]]=$K;return$J;}function
is_view($S){return$S["Engine"]=="VIEW";}function
fk_support($S){return
true;}function
fields($R){$qb=get_key_vals("SELECT objname, cast(value as varchar(max)) FROM fn_listextendedproperty('MS_DESCRIPTION', 'schema', ".q(get_schema()).", 'table', ".q($R).", 'column', NULL)");$J=array();$zi=get_val("SELECT object_id FROM sys.all_objects WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') AND name = ".q($R));foreach(get_rows("SELECT c.max_length, c.precision, c.scale, c.name, c.is_nullable, c.is_identity, c.collation_name, t.name type, d.definition [default], d.name default_constraint, i.is_primary_key
FROM sys.all_columns c
JOIN sys.types t ON c.user_type_id = t.user_type_id
LEFT JOIN sys.default_constraints d ON c.default_object_id = d.object_id
LEFT JOIN sys.index_columns ic ON c.object_id = ic.object_id AND c.column_id = ic.column_id
LEFT JOIN sys.indexes i ON ic.object_id = i.object_id AND ic.index_id = i.index_id
WHERE c.object_id = ".q($zi))as$K){$U=$K["type"];$y=(preg_match("~char|binary~",$U)?intval($K["max_length"])/($U[0]=='n'?2:1):($U=="decimal"?"$K[precision],$K[scale]":""));$J[$K["name"]]=array("field"=>$K["name"],"full_type"=>$U.($y?"($y)":""),"type"=>$U,"length"=>$y,"default"=>(preg_match("~^\('(.*)'\)$~",$K["default"],$A)?str_replace("''","'",$A[1]):$K["default"]),"default_constraint"=>$K["default_constraint"],"null"=>$K["is_nullable"],"auto_increment"=>$K["is_identity"],"collation"=>$K["collation_name"],"privileges"=>array("insert"=>1,"select"=>1,"update"=>1,"where"=>1,"order"=>1),"primary"=>$K["is_primary_key"],"comment"=>$qb[$K["name"]],);}foreach(get_rows("SELECT * FROM sys.computed_columns WHERE object_id = ".q($zi))as$K){$J[$K["name"]]["generated"]=($K["is_persisted"]?"PERSISTED":"VIRTUAL");$J[$K["name"]]["default"]=$K["definition"];}return$J;}function
indexes($R,$g=null){$J=array();foreach(get_rows("SELECT i.name, key_ordinal, is_unique, is_primary_key, c.name AS column_name, is_descending_key
FROM sys.indexes i
INNER JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
INNER JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
WHERE OBJECT_NAME(i.object_id) = ".q($R),$g)as$K){$B=$K["name"];$J[$B]["type"]=($K["is_primary_key"]?"PRIMARY":($K["is_unique"]?"UNIQUE":"INDEX"));$J[$B]["lengths"]=array();$J[$B]["columns"][$K["key_ordinal"]]=$K["column_name"];$J[$B]["descs"][$K["key_ordinal"]]=($K["is_descending_key"]?'1':null);}return$J;}function
view($B){return
array("select"=>preg_replace('~^(?:[^[]|\[[^]]*])*\s+AS\s+~isU','',get_val("SELECT VIEW_DEFINITION FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = SCHEMA_NAME() AND TABLE_NAME = ".q($B))));}function
collations(){$J=array();foreach(get_vals("SELECT name FROM fn_helpcollations()")as$c)$J[preg_replace('~_.*~','',$c)][]=$c;return$J;}function
information_schema($j){return
get_schema()=="INFORMATION_SCHEMA";}function
error(){return
nl_br(h(preg_replace('~^(\[[^]]*])+~m','',connection()->error)));}function
create_database($j,$c){return
queries("CREATE DATABASE ".idf_escape($j).(preg_match('~^[a-z0-9_]+$~i',$c)?" COLLATE $c":""));}function
drop_databases($i){return
queries("DROP DATABASE ".implode(", ",array_map('Adminer\idf_escape',$i)));}function
rename_database($B,$c){if(preg_match('~^[a-z0-9_]+$~i',$c))queries("ALTER DATABASE ".idf_escape(DB)." COLLATE $c");queries("ALTER DATABASE ".idf_escape(DB)." MODIFY NAME = ".idf_escape($B));return
true;}function
auto_increment(){return" IDENTITY".($_POST["Auto_increment"]!=""?"(".number($_POST["Auto_increment"]).",1)":"")." PRIMARY KEY";}function
alter_table($R,$B,$n,$id,$ob,$wc,$c,$_a,$E){$b=array();$qb=array();$lg=fields($R);foreach($n
as$m){$d=idf_escape($m[0]);$X=$m[1];if(!$X)$b["DROP"][]=" COLUMN $d";else{$X[1]=preg_replace("~( COLLATE )'(\\w+)'~",'\1\2',$X[1]);$qb[$m[0]]=$X[5];unset($X[5]);if(preg_match('~ AS ~',$X[3]))unset($X[1],$X[2]);if($m[0]=="")$b["ADD"][]="\n  ".implode("",$X).($R==""?substr($id[$X[0]],16+strlen($X[0])):"");else{$k=$X[3];unset($X[3]);unset($X[6]);if($d!=$X[0])queries("EXEC sp_rename ".q(table($R).".$d").", ".q(idf_unescape($X[0])).", 'COLUMN'");$b["ALTER COLUMN ".implode("",$X)][]="";$kg=$lg[$m[0]];if(default_value($kg)!=$k){if($kg["default"]!==null)$b["DROP"][]=" ".idf_escape($kg["default_constraint"]);if($k)$b["ADD"][]="\n $k FOR $d";}}}}if($R=="")return
queries("CREATE TABLE ".table($B)." (".implode(",",(array)$b["ADD"])."\n)");if($R!=$B)queries("EXEC sp_rename ".q(table($R)).", ".q($B));if($id)$b[""]=$id;foreach($b
as$x=>$X){if(!queries("ALTER TABLE ".table($B)." $x".implode(",",$X)))return
false;}foreach($qb
as$x=>$X){$ob=substr($X,9);queries("EXEC sp_dropextendedproperty @name = N'MS_Description', @level0type = N'Schema', @level0name = ".q(get_schema()).", @level1type = N'Table', @level1name = ".q($B).", @level2type = N'Column', @level2name = ".q($x));queries("EXEC sp_addextendedproperty
@name = N'MS_Description',
@value = $ob,
@level0type = N'Schema',
@level0name = ".q(get_schema()).",
@level1type = N'Table',
@level1name = ".q($B).",
@level2type = N'Column',
@level2name = ".q($x));}return
true;}function
alter_indexes($R,$b){$v=array();$hc=array();foreach($b
as$X){if($X[2]=="DROP"){if($X[0]=="PRIMARY")$hc[]=idf_escape($X[1]);else$v[]=idf_escape($X[1])." ON ".table($R);}elseif(!queries(($X[0]!="PRIMARY"?"CREATE $X[0] ".($X[0]!="INDEX"?"INDEX ":"").idf_escape($X[1]!=""?$X[1]:uniqid($R."_"))." ON ".table($R):"ALTER TABLE ".table($R)." ADD PRIMARY KEY")." (".implode(", ",$X[2]).")"))return
false;}return(!$v||queries("DROP INDEX ".implode(", ",$v)))&&(!$hc||queries("ALTER TABLE ".table($R)." DROP ".implode(", ",$hc)));}function
found_rows($S,$Z){}function
foreign_keys($R){$J=array();$Vf=array("CASCADE","NO ACTION","SET NULL","SET DEFAULT");foreach(get_rows("EXEC sp_fkeys @fktable_name = ".q($R).", @fktable_owner = ".q(get_schema()))as$K){$p=&$J[$K["FK_NAME"]];$p["db"]=$K["PKTABLE_QUALIFIER"];$p["ns"]=$K["PKTABLE_OWNER"];$p["table"]=$K["PKTABLE_NAME"];$p["on_update"]=$Vf[$K["UPDATE_RULE"]];$p["on_delete"]=$Vf[$K["DELETE_RULE"]];$p["source"][]=$K["FKCOLUMN_NAME"];$p["target"][]=$K["PKCOLUMN_NAME"];}return$J;}function
truncate_tables($T){return
apply_queries("TRUNCATE TABLE",$T);}function
drop_views($Oj){return
queries("DROP VIEW ".implode(", ",array_map('Adminer\table',$Oj)));}function
drop_tables($T){return
queries("DROP TABLE ".implode(", ",array_map('Adminer\table',$T)));}function
move_tables($T,$Oj,$Ii){return
apply_queries("ALTER SCHEMA ".idf_escape($Ii)." TRANSFER",array_merge($T,$Oj));}function
trigger($B,$R){if($B=="")return
array();$L=get_rows("SELECT s.name [Trigger],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(s.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(s.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing],
c.text
FROM sysobjects s
JOIN syscomments c ON s.id = c.id
WHERE s.xtype = 'TR' AND s.name = ".q($B));$J=reset($L);if($J)$J["Statement"]=preg_replace('~^.+\s+AS\s+~isU','',$J["text"]);return$J;}function
triggers($R){$J=array();foreach(get_rows("SELECT sys1.name,
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing]
FROM sysobjects sys1
JOIN sysobjects sys2 ON sys1.parent_obj = sys2.id
WHERE sys1.xtype = 'TR' AND sys2.name = ".q($R))as$K)$J[$K["name"]]=array($K["Timing"],$K["Event"]);return$J;}function
trigger_options(){return
array("Timing"=>array("AFTER","INSTEAD OF"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("AS"),);}function
schemas(){return
get_vals("SELECT name FROM sys.schemas");}function
get_schema(){if($_GET["ns"]!="")return$_GET["ns"];return
get_val("SELECT SCHEMA_NAME()");}function
set_schema($Fh){$_GET["ns"]=$Fh;return
true;}function
create_sql($R,$_a,$si){if(is_view(table_status1($R))){$Nj=view($R);return"CREATE VIEW ".table($R)." AS $Nj[select]";}$n=array();$G=false;foreach(fields($R)as$B=>$m){$X=process_field($m,$m);if($X[6])$G=true;$n[]=implode("",$X);}foreach(indexes($R)as$B=>$v){if(!$G||$v["type"]!="PRIMARY"){$e=array();foreach($v["columns"]as$x=>$X)$e[]=idf_escape($X).($v["descs"][$x]?" DESC":"");$B=idf_escape($B);$n[]=($v["type"]=="INDEX"?"INDEX $B":"CONSTRAINT $B ".($v["type"]=="UNIQUE"?"UNIQUE":"PRIMARY KEY"))." (".implode(", ",$e).")";}}foreach(driver()->checkConstraints($R)as$B=>$Wa)$n[]="CONSTRAINT ".idf_escape($B)." CHECK ($Wa)";return"CREATE TABLE ".table($R)." (\n\t".implode(",\n\t",$n)."\n)";}function
foreign_keys_sql($R){$n=array();foreach(foreign_keys($R)as$id)$n[]=ltrim(format_foreign_key($id));return($n?"ALTER TABLE ".table($R)." ADD\n\t".implode(",\n\t",$n).";\n\n":"");}function
truncate_sql($R){return"TRUNCATE TABLE ".table($R);}function
use_sql($Nb,$si=""){return"USE ".idf_escape($Nb);}function
trigger_sql($R){$J="";foreach(triggers($R)as$B=>$hj)$J
.=create_trigger(" ON ".table($R),trigger($B,$R)).";";return$J;}function
convert_field($m){}function
unconvert_field($m,$J){return$J;}function
support($Tc){return
preg_match('~^(check|comment|columns|database|drop_col|dump|indexes|descidx|scheme|sql|table|trigger|view|view_trigger)$~',$Tc);}}class
Adminer{static$instance;var$error='';function
name(){return"<a href='https://www.adminer.org/'".target_blank()." id='h1'><img src='".h(preg_replace("~\\?.*~","",ME)."?file=logo.png&version=5.4.2")."' width='24' height='24' alt='' id='logo'>Adminer</a>";}function
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
databases($gd=true){return
get_databases($gd);}function
pluginsLinks(){}function
operators(){return
driver()->operators;}function
schemas(){return
schemas();}function
queryTimeout(){return
2;}function
afterConnect(){}function
headers(){}function
csp(array$Gb){return$Gb;}function
head($Kb=null){return
true;}function
bodyClass(){echo" adminer";}function
css(){$J=array();foreach(array("","-dark")as$uf){$o="adminer$uf.css";if(file_exists($o)){$Yc=file_get_contents($o);$J["$o?v=".crc32($Yc)]=($uf?"dark":(preg_match('~prefers-color-scheme:\s*dark~',$Yc)?'':'light'));}}return$J;}function
loginForm(){echo"<table class='layout'>\n",adminer()->loginFormField('driver','<tr><th>'.'System'.'<td>',html_select("auth[driver]",SqlDriver::$drivers,DRIVER,"loginDriver(this);")),adminer()->loginFormField('server','<tr><th>'.'Server'.'<td>','<input name="auth[server]" value="'.h(SERVER).'" title="'.'hostname[:port] or :socket'.'" placeholder="localhost" autocapitalize="off">'),adminer()->loginFormField('username','<tr><th>'.'Username'.'<td>','<input name="auth[username]" id="username" autofocus value="'.h($_GET["username"]).'" autocomplete="username" autocapitalize="off">'.script("const authDriver = qs('#username').form['auth[driver]']; authDriver && authDriver.onchange();")),adminer()->loginFormField('password','<tr><th>'.'Password'.'<td>','<input type="password" name="auth[password]" autocomplete="current-password">'),adminer()->loginFormField('db','<tr><th>'.'Database'.'<td>','<input name="auth[db]" value="'.h($_GET["db"]).'" autocapitalize="off">'),"</table>\n","<p><input type='submit' value='".'Login'."'>\n",checkbox("auth[permanent]",1,$_COOKIE["adminer_permanent"],'Permanent login')."\n";}function
loginFormField($B,$Gd,$Y){return$Gd.$Y."\n";}function
login($Te,$F){if($F=="")return
sprintf('Adminer does not support accessing a database without a password, <a href="https://www.adminer.org/en/password/"%s>more information</a>.',target_blank());return
true;}function
tableName(array$yi){return
h($yi["Name"]);}function
fieldName(array$m,$eg=0){$U=$m["full_type"];$ob=$m["comment"];return'<span title="'.h($U.($ob!=""?($U?": ":"").$ob:'')).'">'.h($m["field"]).'</span>';}function
selectLinks(array$yi,$O=""){$B=$yi["Name"];echo'<p class="links">';$Re=array("select"=>'Select data');if(support("table")||support("indexes"))$Re["table"]='Show structure';$xe=false;if(support("table")){$xe=is_view($yi);if($xe){if(support("view"))$Re["view"]='Alter view';}elseif(function_exists('Adminer\alter_table'))$Re["create"]='Alter table';}if($O!==null)$Re["edit"]='New item';foreach($Re
as$x=>$X)echo" <a href='".h(ME)."$x=".urlencode($B).($x=="edit"?$O:"")."'".bold(isset($_GET[$x])).">$X</a>";echo
doc_link(array(JUSH=>driver()->tableHelp($B,$xe)),"?"),"\n";}function
foreignKeys($R){return
foreign_keys($R);}function
backwardKeys($R,$xi){return
array();}function
backwardKeysPrint(array$Da,array$K){}function
selectQuery($H,$oi,$Rc=false){$J="</p>\n";if(!$Rc&&($Rj=driver()->warnings())){$t="warnings";$J=", <a href='#$t'>".'Warnings'."</a>".script("qsl('a').onclick = partial(toggle, '$t');","")."$J<div id='$t' class='hidden'>\n$Rj</div>\n";}return"<p><code class='jush-".JUSH."'>".h(str_replace("\n"," ",$H))."</code> <span class='time'>(".format_time($oi).")</span>".(support("sql")?" <a href='".h(ME)."sql=".urlencode($H)."'>".'Edit'."</a>":"").$J;}function
sqlCommandQuery($H){return
shorten_utf8(trim($H),1000);}function
sqlPrintAfter(){}function
rowDescription($R){return"";}function
rowDescriptions(array$L,array$jd){return$L;}function
selectLink($X,array$m){}function
selectVal($X,$_,array$m,$og){$J=($X===null?"<i>NULL</i>":(preg_match("~char|binary|boolean~",$m["type"])&&!preg_match("~var~",$m["type"])?"<code>$X</code>":(preg_match('~json~',$m["type"])?"<code class='jush-js'>$X</code>":$X)));if(is_blob($m)&&!is_utf8($X))$J="<i>".lang_format(array('%d byte','%d bytes'),strlen($og))."</i>";return($_?"<a href='".h($_)."'".(is_url($_)?target_blank():"").">$J</a>":$J);}function
editVal($X,array$m){return$X;}function
config(){return
array();}function
tableStructurePrint(array$n,$yi=null){echo"<div class='scrollable'>\n","<table class='nowrap odds'>\n","<thead><tr><th>".'Column'."<td>".'Type'.(support("comment")?"<td>".'Comment':"")."</thead>\n";$ri=driver()->structuredTypes();foreach($n
as$m){echo"<tr><th>".h($m["field"]);$U=h($m["full_type"]);$c=h($m["collation"]);echo"<td><span title='$c'>".(in_array($U,(array)$ri['User types'])?"<a href='".h(ME.'type='.urlencode($U))."'>$U</a>":$U.($c&&isset($yi["Collation"])&&$c!=$yi["Collation"]?" $c":""))."</span>",($m["null"]?" <i>NULL</i>":""),($m["auto_increment"]?" <i>".'Auto Increment'."</i>":"");$k=h($m["default"]);echo(isset($m["default"])?" <span title='".'Default value'."'>[<b>".($m["generated"]?"<code class='jush-".JUSH."'>$k</code>":$k)."</b>]</span>":""),(support("comment")?"<td>".h($m["comment"]):""),"\n";}echo"</table>\n","</div>\n";}function
tableIndexesPrint(array$w,array$yi){$zg=false;foreach($w
as$B=>$v)$zg|=!!$v["partial"];echo"<table>\n";$Sb=first(driver()->indexAlgorithms($yi));foreach($w
as$B=>$v){ksort($v["columns"]);$Xg=array();foreach($v["columns"]as$x=>$X)$Xg[]="<i>".h($X)."</i>".($v["lengths"][$x]?"(".$v["lengths"][$x].")":"").($v["descs"][$x]?" DESC":"");echo"<tr title='".h($B)."'>","<th>$v[type]".($Sb&&$v['algorithm']!=$Sb?" ($v[algorithm])":""),"<td>".implode(", ",$Xg);if($zg)echo"<td>".($v['partial']?"<code class='jush-".JUSH."'>WHERE ".h($v['partial']):"");echo"\n";}echo"</table>\n";}function
selectColumnsPrint(array$M,array$e){print_fieldset("select",'Select',$M);$s=0;$M[""]=array();foreach($M
as$x=>$X){$X=idx($_GET["columns"],$x,array());$d=select_input(" name='columns[$s][col]'",$e,$X["col"],($x!==""?"selectFieldChange":"selectAddRow"));echo"<div>".(driver()->functions||driver()->grouping?html_select("columns[$s][fun]",array(-1=>"")+array_filter(array('Functions'=>driver()->functions,'Aggregation'=>driver()->grouping)),$X["fun"]).on_help("event.target.value && event.target.value.replace(/ |\$/, '(') + ')'",1).script("qsl('select').onchange = function () { helpClose();".($x!==""?"":" qsl('select, input', this.parentNode).onchange();")." };","")."($d)":$d)."</div>\n";$s++;}echo"</div></fieldset>\n";}function
selectSearchPrint(array$Z,array$e,array$w){print_fieldset("search",'Search',$Z);foreach($w
as$s=>$v){if($v["type"]=="FULLTEXT")echo"<div>(<i>".implode("</i>, <i>",array_map('Adminer\h',$v["columns"]))."</i>) AGAINST"," <input type='search' name='fulltext[$s]' value='".h(idx($_GET["fulltext"],$s))."'>",script("qsl('input').oninput = selectFieldChange;",""),(JUSH=='sql'?checkbox("boolean[$s]",1,isset($_GET["boolean"][$s]),"BOOL"):''),"</div>\n";}$Ta="this.parentNode.firstChild.onchange();";foreach(array_merge((array)$_GET["where"],array(array()))as$s=>$X){if(!$X||("$X[col]$X[val]"!=""&&in_array($X["op"],adminer()->operators())))echo"<div>".select_input(" name='where[$s][col]'",$e,$X["col"],($X?"selectFieldChange":"selectAddRow"),"(".'anywhere'.")"),html_select("where[$s][op]",adminer()->operators(),$X["op"],$Ta),"<input type='search' name='where[$s][val]' value='".h($X["val"])."'>",script("mixin(qsl('input'), {oninput: function () { $Ta }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});",""),"</div>\n";}echo"</div></fieldset>\n";}function
selectOrderPrint(array$eg,array$e,array$w){print_fieldset("sort",'Sort',$eg);$s=0;foreach((array)$_GET["order"]as$x=>$X){if($X!=""){echo"<div>".select_input(" name='order[$s]'",$e,$X,"selectFieldChange"),checkbox("desc[$s]",1,isset($_GET["desc"][$x]),'descending')."</div>\n";$s++;}}echo"<div>".select_input(" name='order[$s]'",$e,"","selectAddRow"),checkbox("desc[$s]",1,false,'descending')."</div>\n","</div></fieldset>\n";}function
selectLimitPrint($z){echo"<fieldset><legend>".'Limit'."</legend><div>","<input type='number' name='limit' class='size' value='".intval($z)."'>",script("qsl('input').oninput = selectFieldChange;",""),"</div></fieldset>\n";}function
selectLengthPrint($Oi){if($Oi!==null)echo"<fieldset><legend>".'Text length'."</legend><div>","<input type='number' name='text_length' class='size' value='".h($Oi)."'>","</div></fieldset>\n";}function
selectActionPrint(array$w){echo"<fieldset><legend>".'Action'."</legend><div>","<input type='submit' value='".'Select'."'>"," <span id='noindex' title='".'Full table scan'."'></span>","<script".nonce().">\n","const indexColumns = ";$e=array();foreach($w
as$v){$Jb=reset($v["columns"]);if($v["type"]!="FULLTEXT"&&$Jb)$e[$Jb]=1;}$e[""]=1;foreach($e
as$x=>$X)json_row($x);echo";\n","selectFieldChange.call(qs('#form')['select']);\n","</script>\n","</div></fieldset>\n";}function
selectCommandPrint(){return!information_schema(DB);}function
selectImportPrint(){return!information_schema(DB);}function
selectEmailPrint(array$tc,array$e){}function
selectColumnsProcess(array$e,array$w){$M=array();$vd=array();foreach((array)$_GET["columns"]as$x=>$X){if($X["fun"]=="count"||($X["col"]!=""&&(!$X["fun"]||in_array($X["fun"],driver()->functions)||in_array($X["fun"],driver()->grouping)))){$M[$x]=apply_sql_function($X["fun"],($X["col"]!=""?idf_escape($X["col"]):"*"));if(!in_array($X["fun"],driver()->grouping))$vd[]=$M[$x];}}return
array($M,$vd);}function
selectSearchProcess(array$n,array$w){$J=array();foreach($w
as$s=>$v){if($v["type"]=="FULLTEXT"&&idx($_GET["fulltext"],$s)!="")$J[]="MATCH (".implode(", ",array_map('Adminer\idf_escape',$v["columns"])).") AGAINST (".q($_GET["fulltext"][$s]).(isset($_GET["boolean"][$s])?" IN BOOLEAN MODE":"").")";}foreach((array)$_GET["where"]as$x=>$X){$hb=$X["col"];if("$hb$X[val]"!=""&&in_array($X["op"],adminer()->operators())){$sb=array();foreach(($hb!=""?array($hb=>$n[$hb]):$n)as$B=>$m){$Tg="";$rb=" $X[op]";if(preg_match('~IN$~',$X["op"])){$Vd=process_length($X["val"]);$rb
.=" ".($Vd!=""?$Vd:"(NULL)");}elseif($X["op"]=="SQL")$rb=" $X[val]";elseif(preg_match('~^(I?LIKE) %%$~',$X["op"],$A))$rb=" $A[1] ".adminer()->processInput($m,"%$X[val]%");elseif($X["op"]=="FIND_IN_SET"){$Tg="$X[op](".q($X["val"]).", ";$rb=")";}elseif(!preg_match('~NULL$~',$X["op"]))$rb
.=" ".adminer()->processInput($m,$X["val"]);if($hb!=""||(isset($m["privileges"]["where"])&&(preg_match('~^[-\d.'.(preg_match('~IN$~',$X["op"])?',':'').']+$~',$X["val"])||!preg_match('~'.number_type().'|bit~',$m["type"]))&&(!preg_match("~[\x80-\xFF]~",$X["val"])||preg_match('~char|text|enum|set~',$m["type"]))&&(!preg_match('~date|timestamp~',$m["type"])||preg_match('~^\d+-\d+-\d+~',$X["val"]))))$sb[]=$Tg.driver()->convertSearch(idf_escape($B),$X,$m).$rb;}$J[]=(count($sb)==1?$sb[0]:($sb?"(".implode(" OR ",$sb).")":"1 = 0"));}}return$J;}function
selectOrderProcess(array$n,array$w){$J=array();foreach((array)$_GET["order"]as$x=>$X){if($X!="")$J[]=(preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~',$X)?$X:idf_escape($X)).(isset($_GET["desc"][$x])?" DESC":"");}return$J;}function
selectLimitProcess(){return(isset($_GET["limit"])?intval($_GET["limit"]):50);}function
selectLengthProcess(){return(isset($_GET["text_length"])?"$_GET[text_length]":"100");}function
selectEmailProcess(array$Z,array$jd){return
false;}function
selectQueryBuild(array$M,array$Z,array$vd,array$eg,$z,$D){return"";}function
messageQuery($H,$Pi,$Rc=false){restart_session();$Id=&get_session("queries");if(!idx($Id,$_GET["db"]))$Id[$_GET["db"]]=array();if(strlen($H)>1e6)$H=preg_replace('~[\x80-\xFF]+$~','',substr($H,0,1e6))."\nâ€¦";$Id[$_GET["db"]][]=array($H,time(),$Pi);$ki="sql-".count($Id[$_GET["db"]]);$J="<a href='#$ki' class='toggle'>".'SQL command'."</a> <a href='' class='jsonly copy'>ğŸ—</a>\n";if(!$Rc&&($Rj=driver()->warnings())){$t="warnings-".count($Id[$_GET["db"]]);$J="<a href='#$t' class='toggle'>".'Warnings'."</a>, $J<div id='$t' class='hidden'>\n$Rj</div>\n";}return" <span class='time'>".@date("H:i:s")."</span>"." $J<div id='$ki' class='hidden'><pre><code class='jush-".JUSH."'>".shorten_utf8($H,1e4)."</code></pre>".($Pi?" <span class='time'>($Pi)</span>":'').(support("sql")?'<p><a href="'.h(str_replace("db=".urlencode(DB),"db=".urlencode($_GET["db"]),ME).'sql=&history='.(count($Id[$_GET["db"]])-1)).'">'.'Edit'.'</a>':'').'</div>';}function
editRowPrint($R,array$n,$K,$wj){}function
editFunctions(array$m){$J=($m["null"]?"NULL/":"");$wj=isset($_GET["select"])||where($_GET);foreach(array(driver()->insertFunctions,driver()->editFunctions)as$x=>$qd){if(!$x||(!isset($_GET["call"])&&$wj)){foreach($qd
as$Hg=>$X){if(!$Hg||preg_match("~$Hg~",$m["type"]))$J
.="/$X";}}if($x&&$qd&&!preg_match('~set|bool~',$m["type"])&&!is_blob($m))$J
.="/SQL";}if($m["auto_increment"]&&!$wj)$J='Auto Increment';return
explode("/",$J);}function
editInput($R,array$m,$ya,$Y){if($m["type"]=="enum")return(isset($_GET["select"])?"<label><input type='radio'$ya value='orig' checked><i>".'original'."</i></label> ":"").enum_input("radio",$ya,$m,$Y,"NULL");return"";}function
editHint($R,array$m,$Y){return"";}function
processInput(array$m,$Y,$r=""){if($r=="SQL")return$Y;$B=$m["field"];$J=q($Y);if(preg_match('~^(now|getdate|uuid)$~',$r))$J="$r()";elseif(preg_match('~^current_(date|timestamp)$~',$r))$J=$r;elseif(preg_match('~^([+-]|\|\|)$~',$r))$J=idf_escape($B)." $r $J";elseif(preg_match('~^[+-] interval$~',$r))$J=idf_escape($B)." $r ".(preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i",$Y)&&JUSH!="pgsql"?$Y:$J);elseif(preg_match('~^(addtime|subtime|concat)$~',$r))$J="$r(".idf_escape($B).", $J)";elseif(preg_match('~^(md5|sha1|password|encrypt)$~',$r))$J="$r($J)";return
unconvert_field($m,$J);}function
dumpOutput(){$J=array('text'=>'open','file'=>'save');if(function_exists('gzencode'))$J['gz']='gzip';return$J;}function
dumpFormat(){return(support("dump")?array('sql'=>'SQL'):array())+array('csv'=>'CSV,','csv;'=>'CSV;','tsv'=>'TSV');}function
dumpDatabase($j){}function
dumpTable($R,$si,$xe=0){if($_POST["format"]!="sql"){echo"\xef\xbb\xbf";if($si)dump_csv(array_keys(fields($R)));}else{if($xe==2){$n=array();foreach(fields($R)as$B=>$m)$n[]=idf_escape($B)." $m[full_type]";$h="CREATE TABLE ".table($R)." (".implode(", ",$n).")";}else$h=create_sql($R,$_POST["auto_increment"],$si);set_utf8mb4($h);if($si&&$h){if($si=="DROP+CREATE"||$xe==1)echo"DROP ".($xe==2?"VIEW":"TABLE")." IF EXISTS ".table($R).";\n";if($xe==1)$h=remove_definer($h);echo"$h;\n\n";}}}function
dumpData($R,$si,$H){if($si){$df=(JUSH=="sqlite"?0:1048576);$n=array();$Rd=false;if($_POST["format"]=="sql"){if($si=="TRUNCATE+INSERT")echo
truncate_sql($R).";\n";$n=fields($R);if(JUSH=="mssql"){foreach($n
as$m){if($m["auto_increment"]){echo"SET IDENTITY_INSERT ".table($R)." ON;\n";$Rd=true;break;}}}}$I=connection()->query($H,1);if($I){$me="";$Na="";$Ce=array();$rd=array();$ui="";$Uc=($R!=''?'fetch_assoc':'fetch_row');$Cb=0;while($K=$I->$Uc()){if(!$Ce){$Jj=array();foreach($K
as$X){$m=$I->fetch_field();if(idx($n[$m->name],'generated')){$rd[$m->name]=true;continue;}$Ce[]=$m->name;$x=idf_escape($m->name);$Jj[]="$x = VALUES($x)";}$ui=($si=="INSERT+UPDATE"?"\nON DUPLICATE KEY UPDATE ".implode(", ",$Jj):"").";\n";}if($_POST["format"]!="sql"){if($si=="table"){dump_csv($Ce);$si="INSERT";}dump_csv($K);}else{if(!$me)$me="INSERT INTO ".table($R)." (".implode(", ",array_map('Adminer\idf_escape',$Ce)).") VALUES";foreach($K
as$x=>$X){if($rd[$x]){unset($K[$x]);continue;}$m=$n[$x];$K[$x]=($X!==null?unconvert_field($m,preg_match(number_type(),$m["type"])&&!preg_match('~\[~',$m["full_type"])&&is_numeric($X)?$X:q(($X===false?0:$X))):"NULL");}$Dh=($df?"\n":" ")."(".implode(",\t",$K).")";if(!$Na)$Na=$me.$Dh;elseif(JUSH=='mssql'?$Cb%1000!=0:strlen($Na)+4+strlen($Dh)+strlen($ui)<$df)$Na
.=",$Dh";else{echo$Na.$ui;$Na=$me.$Dh;}}$Cb++;}if($Na)echo$Na.$ui;}elseif($_POST["format"]=="sql")echo"-- ".str_replace("\n"," ",connection()->error)."\n";if($Rd)echo"SET IDENTITY_INSERT ".table($R)." OFF;\n";}}function
dumpFilename($Pd){return
friendly_url($Pd!=""?$Pd:(SERVER?:"localhost"));}function
dumpHeaders($Pd,$xf=false){$rg=$_POST["output"];$Mc=(preg_match('~sql~',$_POST["format"])?"sql":($xf?"tar":"csv"));header("Content-Type: ".($rg=="gz"?"application/x-gzip":($Mc=="tar"?"application/x-tar":($Mc=="sql"||$rg!="file"?"text/plain":"text/csv")."; charset=utf-8")));if($rg=="gz"){ob_start(function($Q){return
gzencode($Q);},1e6);}return$Mc;}function
dumpFooter(){if($_POST["format"]=="sql")echo"-- ".gmdate("Y-m-d H:i:s e")."\n";}function
importServerPath(){return"adminer.sql";}function
homepage(){echo'<p class="links">'.($_GET["ns"]==""&&support("database")?'<a href="'.h(ME).'database=">'.'Alter database'."</a>\n":""),(support("scheme")?"<a href='".h(ME)."scheme='>".($_GET["ns"]!=""?'Alter schema':'Create schema')."</a>\n":""),($_GET["ns"]!==""?'<a href="'.h(ME).'schema=">'.'Database schema'."</a>\n":""),(support("privileges")?"<a href='".h(ME)."privileges='>".'Privileges'."</a>\n":"");if($_GET["ns"]!=="")echo(support("routine")?"<a href='#routines'>".'Routines'."</a>\n":""),(support("sequence")?"<a href='#sequences'>".'Sequences'."</a>\n":""),(support("type")?"<a href='#user-types'>".'User types'."</a>\n":""),(support("event")?"<a href='#events'>".'Events'."</a>\n":"");return
true;}function
navigation($tf){echo"<h1>".adminer()->name()." <span class='version'>".VERSION;$Ef=$_COOKIE["adminer_version"];echo" <a href='https://www.adminer.org/#download'".target_blank()." id='version'>".(version_compare(VERSION,$Ef)<0?h($Ef):"")."</a>","</span></h1>\n";if($tf=="auth"){$rg="";foreach((array)$_SESSION["pwds"]as$Lj=>$Wh){foreach($Wh
as$N=>$Fj){$B=h(get_setting("vendor-$Lj-$N")?:get_driver($Lj));foreach($Fj
as$V=>$F){if($F!==null){$Qb=$_SESSION["db"][$Lj][$N][$V];foreach(($Qb?array_keys($Qb):array(""))as$j)$rg
.="<li><a href='".h(auth_url($Lj,$N,$V,$j))."'>($B) ".h("$V@".($N!=""?adminer()->serverName($N):"").($j!=""?" - $j":""))."</a>\n";}}}}if($rg)echo"<ul id='logins'>\n$rg</ul>\n".script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");}else{$T=array();if($_GET["ns"]!==""&&!$tf&&DB!=""){connection()->select_db(DB);$T=table_status('',true);}adminer()->syntaxHighlighting($T);adminer()->databasesPrint($tf);$ia=array();if(DB==""||!$tf){if(support("sql")){$ia[]="<a href='".h(ME)."sql='".bold(isset($_GET["sql"])&&!isset($_GET["import"])).">".'SQL command'."</a>";$ia[]="<a href='".h(ME)."import='".bold(isset($_GET["import"])).">".'Import'."</a>";}$ia[]="<a href='".h(ME)."dump=".urlencode(isset($_GET["table"])?$_GET["table"]:$_GET["select"])."' id='dump'".bold(isset($_GET["dump"])).">".'Export'."</a>";}$Wd=$_GET["ns"]!==""&&!$tf&&DB!="";if($Wd&&function_exists('Adminer\alter_table'))$ia[]='<a href="'.h(ME).'create="'.bold($_GET["create"]==="").">".'Create table'."</a>";echo($ia?"<p class='links'>\n".implode("\n",$ia)."\n":"");if($Wd){if($T)adminer()->tablesPrint($T);else
echo"<p class='message'>".'No tables.'."</p>\n";}}}function
syntaxHighlighting(array$T){echo
script_src(preg_replace("~\\?.*~","",ME)."?file=jush.js&version=5.4.2",true);if(support("sql")){echo"<script".nonce().">\n";if($T){$Re=array();foreach($T
as$R=>$U)$Re[]=preg_quote($R,'/');echo"var jushLinks = { ".JUSH.":";json_row(js_escape(ME).(support("table")?"table":"select").'=$&','/\b('.implode('|',$Re).')\b/g',false);if(support('routine')){foreach(routines()as$K)json_row(js_escape(ME).'function='.urlencode($K["SPECIFIC_NAME"]).'&name=$&','/\b'.preg_quote($K["ROUTINE_NAME"],'/').'(?=["`]?\()/g',false);}json_row('');echo"};\n";foreach(array("bac","bra","sqlite_quo","mssql_bra")as$X)echo"jushLinks.$X = jushLinks.".JUSH.";\n";if(isset($_GET["sql"])||isset($_GET["trigger"])||isset($_GET["check"])){$Ei=array_fill_keys(array_keys($T),array());foreach(driver()->allFields()as$R=>$n){foreach($n
as$m)$Ei[$R][]=$m["field"];}echo"addEventListener('DOMContentLoaded', () => { autocompleter = jush.autocompleteSql('".idf_escape("")."', ".json_encode($Ei)."); });\n";}}echo"</script>\n";}echo
script("syntaxHighlighting('".preg_replace('~^(\d\.?\d).*~s','\1',connection()->server_info)."', '".connection()->flavor."');");}function
databasesPrint($tf){$i=adminer()->databases();if(DB&&$i&&!in_array(DB,$i))array_unshift($i,DB);echo"<form action=''>\n<p id='dbs'>\n";hidden_fields_get();$Ob=script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");echo"<label title='".'Database'."'>".'DB'.": ".($i?html_select("db",array(""=>"")+$i,DB).$Ob:"<input name='db' value='".h(DB)."' autocapitalize='off' size='19'>\n")."</label>","<input type='submit' value='".'Use'."'".($i?" class='hidden'":"").">\n";if(support("scheme")){if($tf!="db"&&DB!=""&&connection()->select_db(DB)){echo"<br><label>".'Schema'.": ".html_select("ns",array(""=>"")+adminer()->schemas(),$_GET["ns"])."$Ob</label>";if($_GET["ns"]!="")set_schema($_GET["ns"]);}}foreach(array("import","sql","schema","dump","privileges")as$X){if(isset($_GET[$X])){echo
input_hidden($X);break;}}echo"</p></form>\n";}function
tablesPrint(array$T){echo"<ul id='tables'>".script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");foreach($T
as$R=>$P){$R="$R";$B=adminer()->tableName($P);if($B!=""&&!$P["partition"])echo'<li><a href="'.h(ME).'select='.urlencode($R).'"'.bold($_GET["select"]==$R||$_GET["edit"]==$R,"select")." title='".'Select data'."'>".'select'."</a> ",(support("table")||support("indexes")?'<a href="'.h(ME).'table='.urlencode($R).'"'.bold(in_array($R,array($_GET["table"],$_GET["create"],$_GET["indexes"],$_GET["foreign"],$_GET["trigger"],$_GET["check"],$_GET["view"])),(is_view($P)?"view":"structure"))." title='".'Show structure'."'>$B</a>":"<span>$B</span>")."\n";}echo"</ul>\n";}function
showVariables(){return
show_variables();}function
showStatus(){return
show_status();}function
processList(){return
process_list();}function
killProcess($t){return
kill_process($t);}}class
Plugins{private
static$append=array('dumpFormat'=>true,'dumpOutput'=>true,'editRowPrint'=>true,'editFunctions'=>true,'config'=>true);var$plugins;var$error='';private$hooks=array();function
__construct($Mg){if($Mg===null){$Mg=array();$Ha="adminer-plugins";if(is_dir($Ha)){foreach(glob("$Ha/*.php")as$o)$this->includeOnce($o);}$Hd=" href='https://www.adminer.org/plugins/#use'".target_blank();if(file_exists("$Ha.php")){$Xd=$this->includeOnce("$Ha.php");if(is_array($Xd)){foreach($Xd
as$Lg)$Mg[get_class($Lg)]=$Lg;}else$this->error
.=sprintf('%s must <a%s>return an array</a>.',"<b>$Ha.php</b>",$Hd)."<br>";}foreach(get_declared_classes()as$db){if(!$Mg[$db]&&(preg_match('~^Adminer\w~i',$db)||is_subclass_of($db,'Adminer\Plugin'))){$oh=new
\ReflectionClass($db);$xb=$oh->getConstructor();if($xb&&$xb->getNumberOfRequiredParameters())$this->error
.=sprintf('<a%s>Configure</a> %s in %s.',$Hd,"<b>$db</b>","<b>$Ha.php</b>")."<br>";else$Mg[$db]=new$db;}}}$this->plugins=$Mg;$la=new
Adminer;$Mg[]=$la;$oh=new
\ReflectionObject($la);foreach($oh->getMethods()as$rf){foreach($Mg
as$Lg){$B=$rf->getName();if(method_exists($Lg,$B))$this->hooks[$B][]=$Lg;}}}function
includeOnce($o){return
include_once"./$o";}function
__call($B,array$wg){$ua=array();foreach($wg
as$x=>$X)$ua[]=&$wg[$x];$J=null;foreach($this->hooks[$B]as$Lg){$Y=call_user_func_array(array($Lg,$B),$ua);if($Y!==null){if(!self::$append[$B])return$Y;$J=$Y+(array)$J;}}return$J;}}abstract
class
Plugin{protected$translations=array();function
description(){return$this->lang('');}function
screenshot(){return"";}protected
function
lang($u,$Kf=null){$ua=func_get_args();$ua[0]=idx($this->translations[LANG],$u)?:$u;return
call_user_func_array('Adminer\lang_format',$ua);}}Adminer::$instance=(function_exists('adminer_object')?adminer_object():(is_dir("adminer-plugins")||file_exists("adminer-plugins.php")?new
Plugins(null):new
Adminer));SqlDriver::$drivers=array("server"=>"MySQL / MariaDB")+SqlDriver::$drivers;if(!defined('Adminer\DRIVER')){define('Adminer\DRIVER',"server");if(extension_loaded("mysqli")&&$_GET["ext"]!="pdo"){class
Db
extends
\MySQLi{static$instance;var$extension="MySQLi",$flavor='';function
__construct(){parent::init();}function
attach($N,$V,$F){mysqli_report(MYSQLI_REPORT_OFF);list($Ld,$Ng)=host_port($N);$ni=adminer()->connectSsl();if($ni)$this->ssl_set($ni['key'],$ni['cert'],$ni['ca'],'','');$J=@$this->real_connect(($N!=""?$Ld:ini_get("mysqli.default_host")),($N.$V!=""?$V:ini_get("mysqli.default_user")),($N.$V.$F!=""?$F:ini_get("mysqli.default_pw")),null,(is_numeric($Ng)?intval($Ng):ini_get("mysqli.default_port")),(is_numeric($Ng)?null:$Ng),($ni?($ni['verify']!==false?2048:64):0));$this->options(MYSQLI_OPT_LOCAL_INFILE,0);return($J?'':$this->error);}function
set_charset($Va){if(parent::set_charset($Va))return
true;parent::set_charset('utf8');return$this->query("SET NAMES $Va");}function
next_result(){return
self::more_results()&&parent::next_result();}function
quote($Q){return"'".$this->escape_string($Q)."'";}}}elseif(extension_loaded("mysql")&&!((ini_bool("sql.safe_mode")||ini_bool("mysql.allow_local_infile"))&&extension_loaded("pdo_mysql"))){class
Db
extends
SqlDb{private$link;function
attach($N,$V,$F){if(ini_bool("mysql.allow_local_infile"))return
sprintf('Disable %s or enable %s or %s extensions.',"'mysql.allow_local_infile'","MySQLi","PDO_MySQL");$this->link=@mysql_connect(($N!=""?$N:ini_get("mysql.default_host")),($N.$V!=""?$V:ini_get("mysql.default_user")),($N.$V.$F!=""?$F:ini_get("mysql.default_password")),true,131072);if(!$this->link)return
mysql_error();$this->server_info=mysql_get_server_info($this->link);return'';}function
set_charset($Va){if(function_exists('mysql_set_charset')){if(mysql_set_charset($Va,$this->link))return
true;mysql_set_charset('utf8',$this->link);}return$this->query("SET NAMES $Va");}function
quote($Q){return"'".mysql_real_escape_string($Q,$this->link)."'";}function
select_db($Nb){return
mysql_select_db($Nb,$this->link);}function
query($H,$oj=false){$I=@($oj?mysql_unbuffered_query($H,$this->link):mysql_query($H,$this->link));$this->error="";if(!$I){$this->errno=mysql_errno($this->link);$this->error=mysql_error($this->link);return
false;}if($I===true){$this->affected_rows=mysql_affected_rows($this->link);$this->info=mysql_info($this->link);return
true;}return
new
Result($I);}}class
Result{var$num_rows;private$result;private$offset=0;function
__construct($I){$this->result=$I;$this->num_rows=mysql_num_rows($I);}function
fetch_assoc(){return
mysql_fetch_assoc($this->result);}function
fetch_row(){return
mysql_fetch_row($this->result);}function
fetch_field(){$J=mysql_fetch_field($this->result,$this->offset++);$J->orgtable=$J->table;$J->charsetnr=($J->blob?63:0);return$J;}function
__destruct(){mysql_free_result($this->result);}}}elseif(extension_loaded("pdo_mysql")){class
Db
extends
PdoDb{var$extension="PDO_MySQL";function
attach($N,$V,$F){$cg=array(\PDO::MYSQL_ATTR_LOCAL_INFILE=>false);$ni=adminer()->connectSsl();if($ni){if($ni['key'])$cg[\PDO::MYSQL_ATTR_SSL_KEY]=$ni['key'];if($ni['cert'])$cg[\PDO::MYSQL_ATTR_SSL_CERT]=$ni['cert'];if($ni['ca'])$cg[\PDO::MYSQL_ATTR_SSL_CA]=$ni['ca'];if(isset($ni['verify']))$cg[\PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT]=$ni['verify'];}list($Ld,$Ng)=host_port($N);return$this->dsn("mysql:charset=utf8;host=$Ld".($Ng?(is_numeric($Ng)?";port=":";unix_socket=").$Ng:""),$V,$F,$cg);}function
set_charset($Va){return$this->query("SET NAMES $Va");}function
select_db($Nb){return$this->query("USE ".idf_escape($Nb));}function
query($H,$oj=false){$this->pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,!$oj);return
parent::query($H,$oj);}}}class
Driver
extends
SqlDriver{static$extensions=array("MySQLi","MySQL","PDO_MySQL");static$jush="sql";var$unsigned=array("unsigned","zerofill","unsigned zerofill");var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","REGEXP","IN","FIND_IN_SET","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL");var$functions=array("char_length","date","from_unixtime","lower","round","floor","ceil","sec_to_time","time_to_sec","upper");var$grouping=array("avg","count","count distinct","group_concat","max","min","sum");static
function
connect($N,$V,$F){$f=parent::connect($N,$V,$F);if(is_string($f)){if(function_exists('iconv')&&!is_utf8($f)&&strlen($Dh=iconv("windows-1250","utf-8",$f))>strlen($f))$f=$Dh;return$f;}$f->set_charset(charset($f));$f->query("SET sql_quote_show_create = 1, autocommit = 1");$f->flavor=(preg_match('~MariaDB~',$f->server_info)?'maria':'mysql');add_driver(DRIVER,($f->flavor=='maria'?"MariaDB":"MySQL"));return$f;}function
__construct(Db$f){parent::__construct($f);$this->types=array('Numbers'=>array("tinyint"=>3,"smallint"=>5,"mediumint"=>8,"int"=>10,"bigint"=>20,"decimal"=>66,"float"=>12,"double"=>21),'Date and time'=>array("date"=>10,"datetime"=>19,"timestamp"=>19,"time"=>10,"year"=>4),'Strings'=>array("char"=>255,"varchar"=>65535,"tinytext"=>255,"text"=>65535,"mediumtext"=>16777215,"longtext"=>4294967295),'Lists'=>array("enum"=>65535,"set"=>64),'Binary'=>array("bit"=>20,"binary"=>255,"varbinary"=>65535,"tinyblob"=>255,"blob"=>65535,"mediumblob"=>16777215,"longblob"=>4294967295),'Geometry'=>array("geometry"=>0,"point"=>0,"linestring"=>0,"polygon"=>0,"multipoint"=>0,"multilinestring"=>0,"multipolygon"=>0,"geometrycollection"=>0),);$this->insertFunctions=array("char"=>"md5/sha1/password/encrypt/uuid","binary"=>"md5/sha1","date|time"=>"now",);$this->editFunctions=array(number_type()=>"+/-","date"=>"+ interval/- interval","time"=>"addtime/subtime","char|text"=>"concat",);if(min_version('5.7.8',10.2,$f))$this->types['Strings']["json"]=4294967295;if(min_version('',10.7,$f)){$this->types['Strings']["uuid"]=128;$this->insertFunctions['uuid']='uuid';}if(min_version(9,'',$f)){$this->types['Numbers']["vector"]=16383;$this->insertFunctions['vector']='string_to_vector';}if(min_version(5.1,'',$f))$this->partitionBy=array("HASH","LINEAR HASH","KEY","LINEAR KEY","RANGE","LIST");if(min_version(5.7,10.2,$f))$this->generated=array("STORED","VIRTUAL");}function
unconvertFunction(array$m){return(preg_match("~binary~",$m["type"])?"<code class='jush-sql'>UNHEX</code>":($m["type"]=="bit"?doc_link(array('sql'=>'bit-value-literals.html'),"<code>b''</code>"):(preg_match("~geometry|point|linestring|polygon~",$m["type"])?"<code class='jush-sql'>GeomFromText</code>":"")));}function
insert($R,array$O){return($O?parent::insert($R,$O):queries("INSERT INTO ".table($R)." ()\nVALUES ()"));}function
insertUpdate($R,array$L,array$G){$e=array_keys(reset($L));$Tg="INSERT INTO ".table($R)." (".implode(", ",$e).") VALUES\n";$Jj=array();foreach($e
as$x)$Jj[$x]="$x = VALUES($x)";$ui="\nON DUPLICATE KEY UPDATE ".implode(", ",$Jj);$Jj=array();$y=0;foreach($L
as$O){$Y="(".implode(", ",$O).")";if($Jj&&(strlen($Tg)+$y+strlen($Y)+strlen($ui)>1e6)){if(!queries($Tg.implode(",\n",$Jj).$ui))return
false;$Jj=array();$y=0;}$Jj[]=$Y;$y+=strlen($Y)+2;}return
queries($Tg.implode(",\n",$Jj).$ui);}function
slowQuery($H,$Qi){if(min_version('5.7.8','10.1.2')){if($this->conn->flavor=='maria')return"SET STATEMENT max_statement_time=$Qi FOR $H";elseif(preg_match('~^(SELECT\b)(.+)~is',$H,$A))return"$A[1] /*+ MAX_EXECUTION_TIME(".($Qi*1000).") */ $A[2]";}}function
convertSearch($u,array$X,array$m){return(preg_match('~char|text|enum|set~',$m["type"])&&!preg_match("~^utf8~",$m["collation"])&&preg_match('~[\x80-\xFF]~',$X['val'])?"CONVERT($u USING ".charset($this->conn).")":$u);}function
warnings(){$I=$this->conn->query("SHOW WARNINGS");if($I&&$I->num_rows){ob_start();print_select_result($I);return
ob_get_clean();}}function
tableHelp($B,$xe=false){$Ve=($this->conn->flavor=='maria');if(information_schema(DB))return
strtolower("information-schema-".($Ve?"$B-table/":str_replace("_","-",$B)."-table.html"));if(DB=="mysql")return($Ve?"mysql$B-table/":"system-schema.html");}function
partitionsInfo($R){$od="FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = ".q(DB)." AND TABLE_NAME = ".q($R);$I=$this->conn->query("SELECT PARTITION_METHOD, PARTITION_EXPRESSION, PARTITION_ORDINAL_POSITION $od ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");$J=array();list($J["partition_by"],$J["partition"],$J["partitions"])=$I->fetch_row();$Dg=get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $od AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");$J["partition_names"]=array_keys($Dg);$J["partition_values"]=array_values($Dg);return$J;}function
hasCStyleEscapes(){static$Qa;if($Qa===null){$li=get_val("SHOW VARIABLES LIKE 'sql_mode'",1,$this->conn);$Qa=(strpos($li,'NO_BACKSLASH_ESCAPES')===false);}return$Qa;}function
engines(){$J=array();foreach(get_rows("SHOW ENGINES")as$K){if(preg_match("~YES|DEFAULT~",$K["Support"]))$J[]=$K["Engine"];}return$J;}function
indexAlgorithms(array$yi){return(preg_match('~^(MEMORY|NDB)$~',$yi["Engine"])?array("HASH","BTREE"):array());}}function
idf_escape($u){return"`".str_replace("`","``",$u)."`";}function
table($u){return
idf_escape($u);}function
get_databases($gd){$J=get_session("dbs");if($J===null){$H="SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME";$J=($gd?slow_query($H):get_vals($H));restart_session();set_session("dbs",$J);stop_session();}return$J;}function
limit($H,$Z,$z,$C=0,$Rh=" "){return" $H$Z".($z?$Rh."LIMIT $z".($C?" OFFSET $C":""):"");}function
limit1($R,$H,$Z,$Rh="\n"){return
limit($H,$Z,1,0,$Rh);}function
db_collation($j,array$jb){$J=null;$h=get_val("SHOW CREATE DATABASE ".idf_escape($j),1);if(preg_match('~ COLLATE ([^ ]+)~',$h,$A))$J=$A[1];elseif(preg_match('~ CHARACTER SET ([^ ]+)~',$h,$A))$J=$jb[$A[1]][-1];return$J;}function
logged_user(){return
get_val("SELECT USER()");}function
tables_list(){return
get_key_vals("SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME");}function
count_tables(array$i){$J=array();foreach($i
as$j)$J[$j]=count(get_vals("SHOW TABLES IN ".idf_escape($j)));return$J;}function
table_status($B="",$Sc=false){$J=array();foreach(get_rows($Sc?"SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ".($B!=""?"AND TABLE_NAME = ".q($B):"ORDER BY Name"):"SHOW TABLE STATUS".($B!=""?" LIKE ".q(addcslashes($B,"%_\\")):""))as$K){if($K["Engine"]=="InnoDB")$K["Comment"]=preg_replace('~(?:(.+); )?InnoDB free: .*~','\1',$K["Comment"]);if(!isset($K["Engine"]))$K["Comment"]="";if($B!="")$K["Name"]=$B;$J[$K["Name"]]=$K;}return$J;}function
is_view(array$S){return$S["Engine"]===null;}function
fk_support(array$S){return
preg_match('~InnoDB|IBMDB2I'.(min_version(5.6)?'|NDB':'').'~i',$S["Engine"]);}function
fields($R){$Ve=(connection()->flavor=='maria');$J=array();foreach(get_rows("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ".q($R)." ORDER BY ORDINAL_POSITION")as$K){$m=$K["COLUMN_NAME"];$U=$K["COLUMN_TYPE"];$sd=$K["GENERATION_EXPRESSION"];$Pc=$K["EXTRA"];preg_match('~^(VIRTUAL|PERSISTENT|STORED)~',$Pc,$rd);preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~',$U,$Ye);$k=$K["COLUMN_DEFAULT"];if($k!=""){$we=preg_match('~text|json~',$Ye[1]);if(!$Ve&&$we)$k=preg_replace("~^(_\w+)?('.*')$~",'\2',stripslashes($k));if($Ve||$we){$k=($k=="NULL"?null:preg_replace_callback("~^'(.*)'$~",function($A){return
stripslashes(str_replace("''","'",$A[1]));},$k));}if(!$Ve&&preg_match('~binary~',$Ye[1])&&preg_match('~^0x(\w*)$~',$k,$A))$k=pack("H*",$A[1]);}$J[$m]=array("field"=>$m,"full_type"=>$U,"type"=>$Ye[1],"length"=>$Ye[2],"unsigned"=>ltrim($Ye[3].$Ye[4]),"default"=>($rd?($Ve?$sd:stripslashes($sd)):$k),"null"=>($K["IS_NULLABLE"]=="YES"),"auto_increment"=>($Pc=="auto_increment"),"on_update"=>(preg_match('~\bon update (\w+)~i',$Pc,$A)?$A[1]:""),"collation"=>$K["COLLATION_NAME"],"privileges"=>array_flip(explode(",","$K[PRIVILEGES],where,order")),"comment"=>$K["COLUMN_COMMENT"],"primary"=>($K["COLUMN_KEY"]=="PRI"),"generated"=>($rd[1]=="PERSISTENT"?"STORED":$rd[1]),);}return$J;}function
indexes($R,$g=null){$J=array();foreach(get_rows("SHOW INDEX FROM ".table($R),$g)as$K){$B=$K["Key_name"];$J[$B]["type"]=($B=="PRIMARY"?"PRIMARY":($K["Index_type"]=="FULLTEXT"?"FULLTEXT":($K["Non_unique"]?($K["Index_type"]=="SPATIAL"?"SPATIAL":"INDEX"):"UNIQUE")));$J[$B]["columns"][]=$K["Column_name"];$J[$B]["lengths"][]=($K["Index_type"]=="SPATIAL"?null:$K["Sub_part"]);$J[$B]["descs"][]=null;$J[$B]["algorithm"]=$K["Index_type"];}return$J;}function
foreign_keys($R){static$Hg='(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';$J=array();$Db=get_val("SHOW CREATE TABLE ".table($R),1);if($Db){preg_match_all("~CONSTRAINT ($Hg) FOREIGN KEY ?\\(((?:$Hg,? ?)+)\\) REFERENCES ($Hg)(?:\\.($Hg))? \\(((?:$Hg,? ?)+)\\)(?: ON DELETE (".driver()->onActions."))?(?: ON UPDATE (".driver()->onActions."))?~",$Db,$Ze,PREG_SET_ORDER);foreach($Ze
as$A){preg_match_all("~$Hg~",$A[2],$fi);preg_match_all("~$Hg~",$A[5],$Ii);$J[idf_unescape($A[1])]=array("db"=>idf_unescape($A[4]!=""?$A[3]:$A[4]),"table"=>idf_unescape($A[4]!=""?$A[4]:$A[3]),"source"=>array_map('Adminer\idf_unescape',$fi[0]),"target"=>array_map('Adminer\idf_unescape',$Ii[0]),"on_delete"=>($A[6]?:"RESTRICT"),"on_update"=>($A[7]?:"RESTRICT"),);}}return$J;}function
view($B){return
array("select"=>preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU','',get_val("SHOW CREATE VIEW ".table($B),1)));}function
collations(){$J=array();foreach(get_rows("SHOW COLLATION")as$K){if($K["Default"])$J[$K["Charset"]][-1]=$K["Collation"];else$J[$K["Charset"]][]=$K["Collation"];}ksort($J);foreach($J
as$x=>$X)sort($J[$x]);return$J;}function
information_schema($j){return($j=="information_schema")||(min_version(5.5)&&$j=="performance_schema");}function
error(){return
h(preg_replace('~^You have an error.*syntax to use~U',"Syntax error",connection()->error));}function
create_database($j,$c){return
queries("CREATE DATABASE ".idf_escape($j).($c?" COLLATE ".q($c):""));}function
drop_databases(array$i){$J=apply_queries("DROP DATABASE",$i,'Adminer\idf_escape');restart_session();set_session("dbs",null);return$J;}function
rename_database($B,$c){$J=false;if(create_database($B,$c)){$T=array();$Oj=array();foreach(tables_list()as$R=>$U){if($U=='VIEW')$Oj[]=$R;else$T[]=$R;}$J=(!$T&&!$Oj)||move_tables($T,$Oj,$B);drop_databases($J?array(DB):array());}return$J;}function
auto_increment(){$Aa=" PRIMARY KEY";if($_GET["create"]!=""&&$_POST["auto_increment_col"]){foreach(indexes($_GET["create"])as$v){if(in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"],$v["columns"],true)){$Aa="";break;}if($v["type"]=="PRIMARY")$Aa=" UNIQUE";}}return" AUTO_INCREMENT$Aa";}function
alter_table($R,$B,array$n,array$id,$ob,$wc,$c,$_a,$E){$b=array();foreach($n
as$m){if($m[1]){$k=$m[1][3];if(preg_match('~ GENERATED~',$k)){$m[1][3]=(connection()->flavor=='maria'?"":$m[1][2]);$m[1][2]=$k;}$b[]=($R!=""?($m[0]!=""?"CHANGE ".idf_escape($m[0]):"ADD"):" ")." ".implode($m[1]).($R!=""?$m[2]:"");}else$b[]="DROP ".idf_escape($m[0]);}$b=array_merge($b,$id);$P=($ob!==null?" COMMENT=".q($ob):"").($wc?" ENGINE=".q($wc):"").($c?" COLLATE ".q($c):"").($_a!=""?" AUTO_INCREMENT=$_a":"");if($E){$Dg=array();if($E["partition_by"]=='RANGE'||$E["partition_by"]=='LIST'){foreach($E["partition_names"]as$x=>$X){$Y=$E["partition_values"][$x];$Dg[]="\n  PARTITION ".idf_escape($X)." VALUES ".($E["partition_by"]=='RANGE'?"LESS THAN":"IN").($Y!=""?" ($Y)":" MAXVALUE");}}$P
.="\nPARTITION BY $E[partition_by]($E[partition])";if($Dg)$P
.=" (".implode(",",$Dg)."\n)";elseif($E["partitions"])$P
.=" PARTITIONS ".(+$E["partitions"]);}elseif($E===null)$P
.="\nREMOVE PARTITIONING";if($R=="")return
queries("CREATE TABLE ".table($B)." (\n".implode(",\n",$b)."\n)$P");if($R!=$B)$b[]="RENAME TO ".table($B);if($P)$b[]=ltrim($P);return($b?queries("ALTER TABLE ".table($R)."\n".implode(",\n",$b)):true);}function
alter_indexes($R,$b){$Ua=array();foreach($b
as$X)$Ua[]=($X[2]=="DROP"?"\nDROP INDEX ".idf_escape($X[1]):"\nADD $X[0] ".($X[0]=="PRIMARY"?"KEY ":"").($X[1]!=""?idf_escape($X[1])." ":"")."(".implode(", ",$X[2]).")");return
queries("ALTER TABLE ".table($R).implode(",",$Ua));}function
truncate_tables(array$T){return
apply_queries("TRUNCATE TABLE",$T);}function
drop_views(array$Oj){return
queries("DROP VIEW ".implode(", ",array_map('Adminer\table',$Oj)));}function
drop_tables(array$T){return
queries("DROP TABLE ".implode(", ",array_map('Adminer\table',$T)));}function
move_tables(array$T,array$Oj,$Ii){$sh=array();foreach($T
as$R)$sh[]=table($R)." TO ".idf_escape($Ii).".".table($R);if(!$sh||queries("RENAME TABLE ".implode(", ",$sh))){$Wb=array();foreach($Oj
as$R)$Wb[table($R)]=view($R);connection()->select_db($Ii);$j=idf_escape(DB);foreach($Wb
as$B=>$Nj){if(!queries("CREATE VIEW $B AS ".str_replace(" $j."," ",$Nj["select"]))||!queries("DROP VIEW $j.$B"))return
false;}return
true;}return
false;}function
copy_tables(array$T,array$Oj,$Ii){queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");foreach($T
as$R){$B=($Ii==DB?table("copy_$R"):idf_escape($Ii).".".table($R));if(($_POST["overwrite"]&&!queries("\nDROP TABLE IF EXISTS $B"))||!queries("CREATE TABLE $B LIKE ".table($R))||!queries("INSERT INTO $B SELECT * FROM ".table($R)))return
false;foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($R,"%_\\")))as$K){$hj=$K["Trigger"];if(!queries("CREATE TRIGGER ".($Ii==DB?idf_escape("copy_$hj"):idf_escape($Ii).".".idf_escape($hj))." $K[Timing] $K[Event] ON $B FOR EACH ROW\n$K[Statement];"))return
false;}}foreach($Oj
as$R){$B=($Ii==DB?table("copy_$R"):idf_escape($Ii).".".table($R));$Nj=view($R);if(($_POST["overwrite"]&&!queries("DROP VIEW IF EXISTS $B"))||!queries("CREATE VIEW $B AS $Nj[select]"))return
false;}return
true;}function
trigger($B,$R){if($B=="")return
array();$L=get_rows("SHOW TRIGGERS WHERE `Trigger` = ".q($B));return
reset($L);}function
triggers($R){$J=array();foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($R,"%_\\")))as$K)$J[$K["Trigger"]]=array($K["Timing"],$K["Event"]);return$J;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
routine($B,$U){$n=get_rows("SELECT
	PARAMETER_NAME field,
	DATA_TYPE type,
	CHARACTER_MAXIMUM_LENGTH length,
	REGEXP_REPLACE(DTD_IDENTIFIER, '^[^ ]+ ', '') `unsigned`,
	1 `null`,
	DTD_IDENTIFIER full_type,
	PARAMETER_MODE `inout`,
	CHARACTER_SET_NAME collation
FROM information_schema.PARAMETERS
WHERE SPECIFIC_SCHEMA = DATABASE() AND ROUTINE_TYPE = '$U' AND SPECIFIC_NAME = ".q($B)."
ORDER BY ORDINAL_POSITION");$J=connection()->query("SELECT ROUTINE_COMMENT comment, ROUTINE_DEFINITION definition, 'SQL' language
FROM information_schema.ROUTINES
WHERE ROUTINE_SCHEMA = DATABASE() AND ROUTINE_TYPE = '$U' AND ROUTINE_NAME = ".q($B))->fetch_assoc();if($n&&$n[0]['field']=='')$J['returns']=array_shift($n);$J['fields']=$n;return$J;}function
routines(){return
get_rows("SELECT SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = DATABASE()");}function
routine_languages(){return
array();}function
routine_id($B,array$K){return
idf_escape($B);}function
last_id($I){return
get_val("SELECT LAST_INSERT_ID()");}function
explain(Db$f,$H){return$f->query("EXPLAIN ".(min_version(5.1)&&!min_version(5.7)?"PARTITIONS ":"").$H);}function
found_rows(array$S,array$Z){return($Z||$S["Engine"]!="InnoDB"?null:$S["Rows"]);}function
create_sql($R,$_a,$si){$J=get_val("SHOW CREATE TABLE ".table($R),1);if(!$_a)$J=preg_replace('~ AUTO_INCREMENT=\d+~','',$J);return$J;}function
truncate_sql($R){return"TRUNCATE ".table($R);}function
use_sql($Nb,$si=""){$B=idf_escape($Nb);$J="";if(preg_match('~CREATE~',$si)&&($h=get_val("SHOW CREATE DATABASE $B",1))){set_utf8mb4($h);if($si=="DROP+CREATE")$J="DROP DATABASE IF EXISTS $B;\n";$J
.="$h;\n";}return$J."USE $B";}function
trigger_sql($R){$J="";foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($R,"%_\\")),null,"-- ")as$K)$J
.="\nCREATE TRIGGER ".idf_escape($K["Trigger"])." $K[Timing] $K[Event] ON ".table($K["Table"])." FOR EACH ROW\n$K[Statement];;\n";return$J;}function
show_variables(){return
get_rows("SHOW VARIABLES");}function
show_status(){return
get_rows("SHOW STATUS");}function
process_list(){return
get_rows("SHOW FULL PROCESSLIST");}function
convert_field(array$m){if(preg_match("~binary~",$m["type"]))return"HEX(".idf_escape($m["field"]).")";if($m["type"]=="bit")return"BIN(".idf_escape($m["field"])." + 0)";if(preg_match("~geometry|point|linestring|polygon~",$m["type"]))return(min_version(8)?"ST_":"")."AsWKT(".idf_escape($m["field"]).")";}function
unconvert_field(array$m,$J){if(preg_match("~binary~",$m["type"]))$J="UNHEX($J)";if($m["type"]=="bit")$J="CONVERT(b$J, UNSIGNED)";if(preg_match("~geometry|point|linestring|polygon~",$m["type"])){$Tg=(min_version(8)?"ST_":"");$J=$Tg."GeomFromText($J, $Tg"."SRID($m[field]))";}return$J;}function
support($Tc){return
preg_match('~^(comment|columns|copy|database|drop_col|dump|indexes|kill|privileges|move_col|procedure|processlist|routine|sql|status|table|trigger|variables|view'.(min_version(5.1)?'|event':'').(min_version(8)?'|descidx':'').(min_version('8.0.16','10.2.1')?'|check':'').')$~',$Tc);}function
kill_process($t){return
queries("KILL ".number($t));}function
connection_id(){return"SELECT CONNECTION_ID()";}function
max_connections(){return
get_val("SELECT @@max_connections");}function
types(){return
array();}function
type_values($t){return"";}function
schemas(){return
array();}function
get_schema(){return"";}function
set_schema($Fh,$g=null){return
true;}}define('Adminer\JUSH',Driver::$jush);define('Adminer\SERVER',"".$_GET[DRIVER]);define('Adminer\DB',"$_GET[db]");define('Adminer\ME',preg_replace('~\?.*~','',relative_uri()).'?'.(sid()?SID.'&':'').(SERVER!==null?DRIVER."=".urlencode(SERVER).'&':'').($_GET["ext"]?"ext=".urlencode($_GET["ext"]).'&':'').(isset($_GET["username"])?"username=".urlencode($_GET["username"]).'&':'').(DB!=""?'db='.urlencode(DB).'&'.(isset($_GET["ns"])?"ns=".urlencode($_GET["ns"])."&":""):''));function
page_header($Si,$l="",$Ma=array(),$Ti=""){page_headers();if(is_ajax()&&$l){page_messages($l);exit;}if(!ob_get_level())ob_start('ob_gzhandler',4096);$Ui=$Si.($Ti!=""?": $Ti":"");$Vi=strip_tags($Ui.(SERVER!=""&&SERVER!="localhost"?h(" - ".SERVER):"")." - ".adminer()->name());echo'<!DOCTYPE html>
<html lang="en" dir="ltr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>',$Vi,'</title>
<link rel="stylesheet" href="',h(preg_replace("~\\?.*~","",ME)."?file=default.css&version=5.4.2"),'">
';$Hb=adminer()->css();if(is_int(key($Hb)))$Hb=array_fill_keys($Hb,'light');$Dd=in_array('light',$Hb)||in_array('',$Hb);$Bd=in_array('dark',$Hb)||in_array('',$Hb);$Kb=($Dd?($Bd?null:false):($Bd?:null));$jf=" media='(prefers-color-scheme: dark)'";if($Kb!==false)echo"<link rel='stylesheet'".($Kb?"":$jf)." href='".h(preg_replace("~\\?.*~","",ME)."?file=dark.css&version=5.4.2")."'>\n";echo"<meta name='color-scheme' content='".($Kb===null?"light dark":($Kb?"dark":"light"))."'>\n",script_src(preg_replace("~\\?.*~","",ME)."?file=functions.js&version=5.4.2");if(adminer()->head($Kb))echo"<link rel='icon' href='data:image/gif;base64,R0lGODlhEAAQAJEAAAQCBPz+/PwCBAROZCH5BAEAAAAALAAAAAAQABAAAAI2hI+pGO1rmghihiUdvUBnZ3XBQA7f05mOak1RWXrNq5nQWHMKvuoJ37BhVEEfYxQzHjWQ5qIAADs='>\n","<link rel='apple-touch-icon' href='".h(preg_replace("~\\?.*~","",ME)."?file=logo.png&version=5.4.2")."'>\n";foreach($Hb
as$_j=>$uf){$ya=($uf=='dark'&&!$Kb?$jf:($uf=='light'&&$Bd?" media='(prefers-color-scheme: light)'":""));echo"<link rel='stylesheet'$ya href='".h($_j)."'>\n";}echo"\n<body class='".'ltr'." nojs";adminer()->bodyClass();echo"'>\n";$o=get_temp_dir()."/adminer.version";echo
script("mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick".(isset($_COOKIE["adminer_version"])?"":", onload: partial(verifyVersion, '".VERSION."')")."});
document.body.classList.replace('nojs', 'js');
const offlineMessage = '".js_escape('You are offline.')."';
const thousandsSeparator = '".js_escape(',')."';"),"<div id='help' class='jush-".JUSH." jsonly hidden'></div>\n",script("mixin(qs('#help'), {onmouseover: () => { helpOpen = 1; }, onmouseout: helpMouseout});"),"<div id='content'>\n","<span id='menuopen' class='jsonly'>".icon("move","","menu","")."</span>".script("qs('#menuopen').onclick = event => { qs('#foot').classList.toggle('foot'); event.stopPropagation(); }");if($Ma!==null){$_=substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1);echo'<p id="breadcrumb"><a href="'.h($_?:".").'">'.get_driver(DRIVER).'</a> Â» ';$_=substr(preg_replace('~\b(db|ns)=[^&]*&~','',ME),0,-1);$N=adminer()->serverName(SERVER);$N=($N!=""?$N:'Server');if($Ma===false)echo"$N\n";else{echo"<a href='".h($_)."' accesskey='1' title='Alt+Shift+1'>$N</a> Â» ";if($_GET["ns"]!=""||(DB!=""&&is_array($Ma)))echo'<a href="'.h($_."&db=".urlencode(DB).(support("scheme")?"&ns=":"")).'">'.h(DB).'</a> Â» ';if(is_array($Ma)){if($_GET["ns"]!="")echo'<a href="'.h(substr(ME,0,-1)).'">'.h($_GET["ns"]).'</a> Â» ';foreach($Ma
as$x=>$X){$Yb=(is_array($X)?$X[1]:h($X));if($Yb!="")echo"<a href='".h(ME."$x=").urlencode(is_array($X)?$X[0]:$X)."'>$Yb</a> Â» ";}}echo"$Si\n";}}echo"<h2>$Ui</h2>\n","<div id='ajaxstatus' class='jsonly hidden'></div>\n";restart_session();page_messages($l);$i=&get_session("dbs");if(DB!=""&&$i&&!in_array(DB,$i,true))$i=null;stop_session();define('Adminer\PAGE_HEADER',1);}function
page_headers(){header("Content-Type: text/html; charset=utf-8");header("Cache-Control: no-cache");header("X-Frame-Options: deny");header("X-XSS-Protection: 0");header("X-Content-Type-Options: nosniff");header("Referrer-Policy: origin-when-cross-origin");foreach(adminer()->csp(csp())as$Gb){$Fd=array();foreach($Gb
as$x=>$X)$Fd[]="$x $X";header("Content-Security-Policy: ".implode("; ",$Fd));}adminer()->headers();}function
csp(){return
array(array("script-src"=>"'self' 'unsafe-inline' 'nonce-".get_nonce()."' 'strict-dynamic'","connect-src"=>"'self' https://www.adminer.org","frame-src"=>"'none'","object-src"=>"'none'","base-uri"=>"'none'","form-action"=>"'self'",),);}function
get_nonce(){static$Gf;if(!$Gf)$Gf=base64_encode(rand_string());return$Gf;}function
page_messages($l){$zj=preg_replace('~^[^?]*~','',$_SERVER["REQUEST_URI"]);$qf=idx($_SESSION["messages"],$zj);if($qf){echo"<div class='message'>".implode("</div>\n<div class='message'>",$qf)."</div>".script("messagesPrint();");unset($_SESSION["messages"][$zj]);}if($l)echo"<div class='error'>$l</div>\n";if(adminer()->error)echo"<div class='error'>".adminer()->error."</div>\n";}function
page_footer($tf=""){echo"</div>\n\n<div id='foot' class='foot'>\n<div id='menu'>\n";adminer()->navigation($tf);echo"</div>\n";if($tf!="auth")echo'<form action="" method="post">
<p class="logout">
<span>',h($_GET["username"])."\n",'</span>
<input type="submit" name="logout" value="Logout" id="logout">
',input_token(),'</form>
';echo"</div>\n\n",script("setupSubmitHighlight(document);");}function
int32($zf){while($zf>=2147483648)$zf-=4294967296;while($zf<=-2147483649)$zf+=4294967296;return(int)$zf;}function
long2str(array$W,$Qj){$Dh='';foreach($W
as$X)$Dh
.=pack('V',$X);if($Qj)return
substr($Dh,0,end($W));return$Dh;}function
str2long($Dh,$Qj){$W=array_values(unpack('V*',str_pad($Dh,4*ceil(strlen($Dh)/4),"\0")));if($Qj)$W[]=strlen($Dh);return$W;}function
xxtea_mx($Xj,$Wj,$vi,$Ae){return
int32((($Xj>>5&0x7FFFFFF)^$Wj<<2)+(($Wj>>3&0x1FFFFFFF)^$Xj<<4))^int32(($vi^$Wj)+($Ae^$Xj));}function
encrypt_string($qi,$x){if($qi=="")return"";$x=array_values(unpack("V*",pack("H*",md5($x))));$W=str2long($qi,true);$zf=count($W)-1;$Xj=$W[$zf];$Wj=$W[0];$dh=floor(6+52/($zf+1));$vi=0;while($dh-->0){$vi=int32($vi+0x9E3779B9);$nc=$vi>>2&3;for($tg=0;$tg<$zf;$tg++){$Wj=$W[$tg+1];$yf=xxtea_mx($Xj,$Wj,$vi,$x[$tg&3^$nc]);$Xj=int32($W[$tg]+$yf);$W[$tg]=$Xj;}$Wj=$W[0];$yf=xxtea_mx($Xj,$Wj,$vi,$x[$tg&3^$nc]);$Xj=int32($W[$zf]+$yf);$W[$zf]=$Xj;}return
long2str($W,false);}function
decrypt_string($qi,$x){if($qi=="")return"";if(!$x)return
false;$x=array_values(unpack("V*",pack("H*",md5($x))));$W=str2long($qi,false);$zf=count($W)-1;$Xj=$W[$zf];$Wj=$W[0];$dh=floor(6+52/($zf+1));$vi=int32($dh*0x9E3779B9);while($vi){$nc=$vi>>2&3;for($tg=$zf;$tg>0;$tg--){$Xj=$W[$tg-1];$yf=xxtea_mx($Xj,$Wj,$vi,$x[$tg&3^$nc]);$Wj=int32($W[$tg]-$yf);$W[$tg]=$Wj;}$Xj=$W[$zf];$yf=xxtea_mx($Xj,$Wj,$vi,$x[$tg&3^$nc]);$Wj=int32($W[0]-$yf);$W[0]=$Wj;$vi=int32($vi-0x9E3779B9);}return
long2str($W,true);}$Jg=array();if($_COOKIE["adminer_permanent"]){foreach(explode(" ",$_COOKIE["adminer_permanent"])as$X){list($x)=explode(":",$X);$Jg[$x]=$X;}}function
add_invalid_login(){$Fa=get_temp_dir()."/adminer.invalid";foreach(glob("$Fa*")?:array($Fa)as$o){$q=file_open_lock($o);if($q)break;}if(!$q)$q=file_open_lock("$Fa-".rand_string());if(!$q)return;$re=unserialize(stream_get_contents($q));$Pi=time();if($re){foreach($re
as$se=>$X){if($X[0]<$Pi)unset($re[$se]);}}$qe=&$re[adminer()->bruteForceKey()];if(!$qe)$qe=array($Pi+30*60,0);$qe[1]++;file_write_unlock($q,serialize($re));}function
check_invalid_login(array&$Jg){$re=array();foreach(glob(get_temp_dir()."/adminer.invalid*")as$o){$q=file_open_lock($o);if($q){$re=unserialize(stream_get_contents($q));file_unlock($q);break;}}$qe=idx($re,adminer()->bruteForceKey(),array());$Ff=($qe[1]>29?$qe[0]-time():0);if($Ff>0)auth_error(lang_format(array('Too many unsuccessful logins, try again in %d minute.','Too many unsuccessful logins, try again in %d minutes.'),ceil($Ff/60)),$Jg);}$za=$_POST["auth"];if($za){session_regenerate_id();$Lj=$za["driver"];$N=$za["server"];$V=$za["username"];$F=(string)$za["password"];$j=$za["db"];set_password($Lj,$N,$V,$F);$_SESSION["db"][$Lj][$N][$V][$j]=true;if($za["permanent"]){$x=implode("-",array_map('base64_encode',array($Lj,$N,$V,$j)));$Yg=adminer()->permanentLogin(true);$Jg[$x]="$x:".base64_encode($Yg?encrypt_string($F,$Yg):"");cookie("adminer_permanent",implode(" ",$Jg));}if(count($_POST)==1||DRIVER!=$Lj||SERVER!=$N||$_GET["username"]!==$V||DB!=$j)redirect(auth_url($Lj,$N,$V,$j));}elseif($_POST["logout"]&&(!$_SESSION["token"]||verify_token())){foreach(array("pwds","db","dbs","queries")as$x)set_session($x,null);unset_permanent($Jg);redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1),'Logout successful.'.' '.'Thanks for using Adminer, consider <a href="https://www.adminer.org/en/donation/">donating</a>.');}elseif($Jg&&!$_SESSION["pwds"]){session_regenerate_id();$Yg=adminer()->permanentLogin();foreach($Jg
as$x=>$X){list(,$cb)=explode(":",$X);list($Lj,$N,$V,$j)=array_map('base64_decode',explode("-",$x));set_password($Lj,$N,$V,decrypt_string(base64_decode($cb),$Yg));$_SESSION["db"][$Lj][$N][$V][$j]=true;}}function
unset_permanent(array&$Jg){foreach($Jg
as$x=>$X){list($Lj,$N,$V,$j)=array_map('base64_decode',explode("-",$x));if($Lj==DRIVER&&$N==SERVER&&$V==$_GET["username"]&&$j==DB)unset($Jg[$x]);}cookie("adminer_permanent",implode(" ",$Jg));}function
auth_error($l,array&$Jg){$Xh=session_name();if(isset($_GET["username"])){header("HTTP/1.1 403 Forbidden");if(($_COOKIE[$Xh]||$_GET[$Xh])&&!$_SESSION["token"])$l='Session expired, please login again.';else{restart_session();add_invalid_login();$F=get_password();if($F!==null){if($F===false)$l
.=($l?'<br>':'').sprintf('Master password expired. <a href="https://www.adminer.org/en/extension/"%s>Implement</a> %s method to make it permanent.',target_blank(),'<code>permanentLogin()</code>');set_password(DRIVER,SERVER,$_GET["username"],null);}unset_permanent($Jg);}}if(!$_COOKIE[$Xh]&&$_GET[$Xh]&&ini_bool("session.use_only_cookies"))$l='Session support must be enabled.';$wg=session_get_cookie_params();cookie("adminer_key",($_COOKIE["adminer_key"]?:rand_string()),$wg["lifetime"]);if(!$_SESSION["token"])$_SESSION["token"]=rand(1,1e6);page_header('Login',$l,null);echo"<form action='' method='post'>\n","<div>";if(hidden_fields($_POST,array("auth")))echo"<p class='message'>".'The action will be performed after successful login with the same credentials.'."\n";echo"</div>\n";adminer()->loginForm();echo"</form>\n";page_footer("auth");exit;}if(isset($_GET["username"])&&!class_exists('Adminer\Db')){unset($_SESSION["pwds"][DRIVER]);unset_permanent($Jg);page_header('No extension',sprintf('None of the supported PHP extensions (%s) are available.',implode(", ",Driver::$extensions)),false);page_footer("auth");exit;}$f='';if(isset($_GET["username"])&&is_string(get_password())){list(,$Ng)=host_port(SERVER);if(preg_match('~^\s*([-+]?\d+)~',$Ng,$A)&&($A[1]<1024||$A[1]>65535))auth_error('Connecting to privileged ports is not allowed.',$Jg);check_invalid_login($Jg);$Fb=adminer()->credentials();$f=Driver::connect($Fb[0],$Fb[1],$Fb[2]);if(is_object($f)){Db::$instance=$f;Driver::$instance=new
Driver($f);if($f->flavor)save_settings(array("vendor-".DRIVER."-".SERVER=>get_driver(DRIVER)));}}$Te=null;if(!is_object($f)||($Te=adminer()->login($_GET["username"],get_password()))!==true){$l=(is_string($f)?nl_br(h($f)):(is_string($Te)?$Te:'Invalid credentials.')).(preg_match('~^ | $~',get_password())?'<br>'.'There is a space in the input password which might be the cause.':'');auth_error($l,$Jg);}if($_POST["logout"]&&$_SESSION["token"]&&!verify_token()){page_header('Logout','Invalid CSRF token. Send the form again.');page_footer("db");exit;}if(!$_SESSION["token"])$_SESSION["token"]=rand(1,1e6);stop_session(true);if($za&&$_POST["token"])$_POST["token"]=get_token();$l='';if($_POST){if(!verify_token()){$je="max_input_vars";$hf=ini_get($je);if(extension_loaded("suhosin")){foreach(array("suhosin.request.max_vars","suhosin.post.max_vars")as$x){$X=ini_get($x);if($X&&(!$hf||$X<$hf)){$je=$x;$hf=$X;}}}$l=(!$_POST["token"]&&$hf?sprintf('Maximum number of allowed fields exceeded. Please increase %s.',"'$je'"):'Invalid CSRF token. Send the form again.'.' '.'If you did not send this request from Adminer then close this page.');}}elseif($_SERVER["REQUEST_METHOD"]=="POST"){$l=sprintf('Too big POST data. Reduce the data or increase the %s configuration directive.',"'post_max_size'");if(isset($_GET["sql"]))$l
.=' '.'You can upload a big SQL file via FTP and import it from server.';}function
print_select_result($I,$g=null,array$ig=array(),$z=0){$Re=array();$w=array();$e=array();$Ka=array();$nj=array();$J=array();for($s=0;(!$z||$s<$z)&&($K=$I->fetch_row());$s++){if(!$s){echo"<div class='scrollable'>\n","<table class='nowrap odds'>\n","<thead><tr>";for($ye=0;$ye<count($K);$ye++){$m=$I->fetch_field();$B=$m->name;$hg=(isset($m->orgtable)?$m->orgtable:"");$gg=(isset($m->orgname)?$m->orgname:$B);if($ig&&JUSH=="sql")$Re[$ye]=($B=="table"?"table=":($B=="possible_keys"?"indexes=":null));elseif($hg!=""){if(isset($m->table))$J[$m->table]=$hg;if(!isset($w[$hg])){$w[$hg]=array();foreach(indexes($hg,$g)as$v){if($v["type"]=="PRIMARY"){$w[$hg]=array_flip($v["columns"]);break;}}$e[$hg]=$w[$hg];}if(isset($e[$hg][$gg])){unset($e[$hg][$gg]);$w[$hg][$gg]=$ye;$Re[$ye]=$hg;}}if($m->charsetnr==63)$Ka[$ye]=true;$nj[$ye]=$m->type;echo"<th".($hg!=""||$m->name!=$gg?" title='".h(($hg!=""?"$hg.":"").$gg)."'":"").">".h($B).($ig?doc_link(array('sql'=>"explain-output.html#explain_".strtolower($B),'mariadb'=>"explain/#the-columns-in-explain-select",)):"");}echo"</thead>\n";}echo"<tr>";foreach($K
as$x=>$X){$_="";if(isset($Re[$x])&&!$e[$Re[$x]]){if($ig&&JUSH=="sql"){$R=$K[array_search("table=",$Re)];$_=ME.$Re[$x].urlencode($ig[$R]!=""?$ig[$R]:$R);}else{$_=ME."edit=".urlencode($Re[$x]);foreach($w[$Re[$x]]as$hb=>$ye){if($K[$ye]===null){$_="";break;}$_
.="&where".urlencode("[".bracket_escape($hb)."]")."=".urlencode($K[$ye]);}}}$m=array('type'=>($Ka[$x]?'blob':($nj[$x]==254?'char':'')),);$X=select_value($X,$_,$m,null);echo"<td".($nj[$x]<=9||$nj[$x]==246?" class='number'":"").">$X";}}echo($s?"</table>\n</div>":"<p class='message'>".'No rows.')."\n";return$J;}function
referencable_primary($Ph){$J=array();foreach(table_status('',true)as$_i=>$R){if($_i!=$Ph&&fk_support($R)){foreach(fields($_i)as$m){if($m["primary"]){if($J[$_i]){unset($J[$_i]);break;}$J[$_i]=$m;}}}}return$J;}function
textarea($B,$Y,$L=10,$kb=80){echo"<textarea name='".h($B)."' rows='$L' cols='$kb' class='sqlarea jush-".JUSH."' spellcheck='false' wrap='off'>";if(is_array($Y)){foreach($Y
as$X)echo
h($X[0])."\n\n\n";}else
echo
h($Y);echo"</textarea>";}function
select_input($ya,array$cg,$Y="",$Wf="",$Kg=""){$Hi=($cg?"select":"input");return"<$Hi$ya".($cg?"><option value=''>$Kg".optionlist($cg,$Y,true)."</select>":" size='10' value='".h($Y)."' placeholder='$Kg'>").($Wf?script("qsl('$Hi').onchange = $Wf;",""):"");}function
json_row($x,$X=null,$Ec=true){static$ad=true;if($ad)echo"{";if($x!=""){echo($ad?"":",")."\n\t\"".addcslashes($x,"\r\n\t\"\\/").'": '.($X!==null?($Ec?'"'.addcslashes($X,"\r\n\"\\/").'"':$X):'null');$ad=false;}else{echo"\n}\n";$ad=true;}}function
edit_type($x,array$m,array$jb,array$kd=array(),array$Qc=array()){$U=$m["type"];echo"<td><select name='".h($x)."[type]' class='type' aria-labelledby='label-type'>";if($U&&!array_key_exists($U,driver()->types())&&!isset($kd[$U])&&!in_array($U,$Qc))$Qc[]=$U;$ri=driver()->structuredTypes();if($kd)$ri['Foreign keys']=$kd;echo
optionlist(array_merge($Qc,$ri),$U),"</select><td>","<input name='".h($x)."[length]' value='".h($m["length"])."' size='3'".(!$m["length"]&&preg_match('~var(char|binary)$~',$U)?" class='required'":"")." aria-labelledby='label-length'>","<td class='options'>",($jb?"<input list='collations' name='".h($x)."[collation]'".(preg_match('~(char|text|enum|set)$~',$U)?"":" class='hidden'")." value='".h($m["collation"])."' placeholder='(".'collation'.")'>":''),(driver()->unsigned?"<select name='".h($x)."[unsigned]'".(!$U||preg_match(number_type(),$U)?"":" class='hidden'").'><option>'.optionlist(driver()->unsigned,$m["unsigned"]).'</select>':''),(isset($m['on_update'])?"<select name='".h($x)."[on_update]'".(preg_match('~timestamp|datetime~',$U)?"":" class='hidden'").'>'.optionlist(array(""=>"(".'ON UPDATE'.")","CURRENT_TIMESTAMP"),(preg_match('~^CURRENT_TIMESTAMP~i',$m["on_update"])?"CURRENT_TIMESTAMP":$m["on_update"])).'</select>':''),($kd?"<select name='".h($x)."[on_delete]'".(preg_match("~`~",$U)?"":" class='hidden'")."><option value=''>(".'ON DELETE'.")".optionlist(explode("|",driver()->onActions),$m["on_delete"])."</select> ":" ");}function
process_length($y){$_c=driver()->enumLength;return(preg_match("~^\\s*\\(?\\s*$_c(?:\\s*,\\s*$_c)*+\\s*\\)?\\s*\$~",$y)&&preg_match_all("~$_c~",$y,$Ze)?"(".implode(",",$Ze[0]).")":preg_replace('~^[0-9].*~','(\0)',preg_replace('~[^-0-9,+()[\]]~','',$y)));}function
process_type(array$m,$ib="COLLATE"){return" $m[type]".process_length($m["length"]).(preg_match(number_type(),$m["type"])&&in_array($m["unsigned"],driver()->unsigned)?" $m[unsigned]":"").(preg_match('~char|text|enum|set~',$m["type"])&&$m["collation"]?" $ib ".(JUSH=="mssql"?$m["collation"]:q($m["collation"])):"");}function
process_field(array$m,array$mj){if($m["on_update"])$m["on_update"]=str_ireplace("current_timestamp()","CURRENT_TIMESTAMP",$m["on_update"]);return
array(idf_escape(trim($m["field"])),process_type($mj),($m["null"]?" NULL":" NOT NULL"),default_value($m),(preg_match('~timestamp|datetime~',$m["type"])&&$m["on_update"]?" ON UPDATE $m[on_update]":""),(support("comment")&&$m["comment"]!=""?" COMMENT ".q($m["comment"]):""),($m["auto_increment"]?auto_increment():null),);}function
default_value(array$m){if($m["default"]===null)return"";$k=str_replace("\r","",$m["default"]);$rd=$m["generated"];return(in_array($rd,driver()->generated)?(JUSH=="mssql"?" AS ($k)".($rd=="VIRTUAL"?"":" $rd"):" GENERATED ALWAYS AS ($k) $rd"):" DEFAULT ".(!preg_match('~^GENERATED ~i',$k)&&(preg_match('~char|binary|text|json|enum|set~',$m["type"])||preg_match('~^(?![a-z])~i',$k))?(JUSH=="sql"&&preg_match('~text|json~',$m["type"])?"(".q($k).")":q($k)):str_ireplace("current_timestamp()","CURRENT_TIMESTAMP",(JUSH=="sqlite"?"($k)":$k))));}function
type_class($U){foreach(array('char'=>'text','date'=>'time|year','binary'=>'blob','enum'=>'set',)as$x=>$X){if(preg_match("~$x|$X~",$U))return" class='$x'";}}function
edit_fields(array$n,array$jb,$U="TABLE",array$kd=array()){$n=array_values($n);$Tb=(($_POST?$_POST["defaults"]:get_setting("defaults"))?"":" class='hidden'");$pb=(($_POST?$_POST["comments"]:get_setting("comments"))?"":" class='hidden'");echo"<thead><tr>\n",($U=="PROCEDURE"?"<td>":""),"<th id='label-name'>".($U=="TABLE"?'Column name':'Parameter name'),"<td id='label-type'>".'Type'."<textarea id='enum-edit' rows='4' cols='12' wrap='off' style='display: none;'></textarea>".script("qs('#enum-edit').onblur = editingLengthBlur;"),"<td id='label-length'>".'Length',"<td>".'Options';if($U=="TABLE")echo"<td id='label-null'>NULL\n","<td><input type='radio' name='auto_increment_col' value=''><abbr id='label-ai' title='".'Auto Increment'."'>AI</abbr>",doc_link(array('sql'=>"example-auto-increment.html",'mariadb'=>"auto_increment/",'sqlite'=>"autoinc.html",'pgsql'=>"datatype-numeric.html#DATATYPE-SERIAL",'mssql'=>"t-sql/statements/create-table-transact-sql-identity-property",)),"<td id='label-default'$Tb>".'Default value',(support("comment")?"<td id='label-comment'$pb>".'Comment':"");echo"<td>".icon("plus","add[".(support("move_col")?0:count($n))."]","+",'Add next'),"</thead>\n<tbody>\n",script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");foreach($n
as$s=>$m){$s++;$jg=$m[($_POST?"orig":"field")];$dc=(isset($_POST["add"][$s-1])||(isset($m["field"])&&!idx($_POST["drop_col"],$s)))&&(support("drop_col")||$jg=="");echo"<tr".($dc?"":" style='display: none;'").">\n",($U=="PROCEDURE"?"<td>".html_select("fields[$s][inout]",explode("|",driver()->inout),$m["inout"]):"")."<th>";if($dc)echo"<input name='fields[$s][field]' value='".h($m["field"])."' data-maxlength='64' autocapitalize='off' aria-labelledby='label-name'".(isset($_POST["add"][$s-1])?" autofocus":"").">";echo
input_hidden("fields[$s][orig]",$jg);edit_type("fields[$s]",$m,$jb,$kd);if($U=="TABLE"){echo"<td>".checkbox("fields[$s][null]",1,$m["null"],"","","block","label-null"),"<td><label class='block'><input type='radio' name='auto_increment_col' value='$s'".($m["auto_increment"]?" checked":"")." aria-labelledby='label-ai'></label>","<td$Tb>".(driver()->generated?html_select("fields[$s][generated]",array_merge(array("","DEFAULT"),driver()->generated),$m["generated"])." ":checkbox("fields[$s][generated]",1,$m["generated"],"","","","label-default"));$ya=" name='fields[$s][default]' aria-labelledby='label-default'";$Y=h($m["default"]);echo(preg_match('~\n~',$m["default"])?"<textarea$ya rows='2' cols='30' style='vertical-align: bottom;'>\n$Y</textarea>":"<input$ya value='$Y'>"),(support("comment")?"<td$pb><input name='fields[$s][comment]' value='".h($m["comment"])."' data-maxlength='".(min_version(5.5)?1024:255)."' aria-labelledby='label-comment'>":"");}echo"<td>",(support("move_col")?icon("plus","add[$s]","+",'Add next')." ".icon("up","up[$s]","â†‘",'Move up')." ".icon("down","down[$s]","â†“",'Move down')." ":""),($jg==""||support("drop_col")?icon("cross","drop_col[$s]","x",'Remove'):"");}}function
process_fields(array&$n){$C=0;if($_POST["up"]){$Ie=0;foreach($n
as$x=>$m){if(key($_POST["up"])==$x){unset($n[$x]);array_splice($n,$Ie,0,array($m));break;}if(isset($m["field"]))$Ie=$C;$C++;}}elseif($_POST["down"]){$md=false;foreach($n
as$x=>$m){if(isset($m["field"])&&$md){unset($n[key($_POST["down"])]);array_splice($n,$C,0,array($md));break;}if(key($_POST["down"])==$x)$md=$m;$C++;}}elseif($_POST["add"]){$n=array_values($n);array_splice($n,key($_POST["add"]),0,array(array()));}elseif(!$_POST["drop_col"])return
false;return
true;}function
normalize_enum(array$A){$X=$A[0];return"'".str_replace("'","''",addcslashes(stripcslashes(str_replace($X[0].$X[0],$X[0],substr($X,1,-1))),'\\'))."'";}function
grant($td,array$ah,$e,$Tf){if(!$ah)return
true;if($ah==array("ALL PRIVILEGES","GRANT OPTION"))return($td=="GRANT"?queries("$td ALL PRIVILEGES$Tf WITH GRANT OPTION"):queries("$td ALL PRIVILEGES$Tf")&&queries("$td GRANT OPTION$Tf"));return
queries("$td ".preg_replace('~(GRANT OPTION)\([^)]*\)~','\1',implode("$e, ",$ah).$e).$Tf);}function
drop_create($hc,$h,$jc,$Li,$lc,$Se,$pf,$nf,$of,$Qf,$Cf){if($_POST["drop"])query_redirect($hc,$Se,$pf);elseif($Qf=="")query_redirect($h,$Se,$of);elseif($Qf!=$Cf){$Eb=queries($h);queries_redirect($Se,$nf,$Eb&&queries($hc));if($Eb)queries($jc);}else
queries_redirect($Se,$nf,queries($Li)&&queries($lc)&&queries($hc)&&queries($h));}function
create_trigger($Tf,array$K){$Ri=" $K[Timing] $K[Event]".(preg_match('~ OF~',$K["Event"])?" $K[Of]":"");return"CREATE TRIGGER ".idf_escape($K["Trigger"]).(JUSH=="mssql"?$Tf.$Ri:$Ri.$Tf).rtrim(" $K[Type]\n$K[Statement]",";").";";}function
create_routine($_h,array$K){$O=array();$n=(array)$K["fields"];ksort($n);foreach($n
as$m){if($m["field"]!="")$O[]=(preg_match("~^(".driver()->inout.")\$~",$m["inout"])?"$m[inout] ":"").idf_escape($m["field"]).process_type($m,"CHARACTER SET");}$Vb=rtrim($K["definition"],";");return"CREATE $_h ".idf_escape(trim($K["name"]))." (".implode(", ",$O).")".($_h=="FUNCTION"?" RETURNS".process_type($K["returns"],"CHARACTER SET"):"").($K["language"]?" LANGUAGE $K[language]":"").(JUSH=="pgsql"?" AS ".q($Vb):"\n$Vb;");}function
remove_definer($H){return
preg_replace('~^([A-Z =]+) DEFINER=`'.preg_replace('~@(.*)~','`@`(%|\1)',logged_user()).'`~','\1',$H);}function
format_foreign_key(array$p){$j=$p["db"];$Hf=$p["ns"];return" FOREIGN KEY (".implode(", ",array_map('Adminer\idf_escape',$p["source"])).") REFERENCES ".($j!=""&&$j!=$_GET["db"]?idf_escape($j).".":"").($Hf!=""&&$Hf!=$_GET["ns"]?idf_escape($Hf).".":"").idf_escape($p["table"])." (".implode(", ",array_map('Adminer\idf_escape',$p["target"])).")".(preg_match("~^(".driver()->onActions.")\$~",$p["on_delete"])?" ON DELETE $p[on_delete]":"").(preg_match("~^(".driver()->onActions.")\$~",$p["on_update"])?" ON UPDATE $p[on_update]":"").($p["deferrable"]?" $p[deferrable]":"");}function
tar_file($o,$Wi){$J=pack("a100a8a8a8a12a12",$o,644,0,0,decoct($Wi->size),decoct(time()));$bb=8*32;for($s=0;$s<strlen($J);$s++)$bb+=ord($J[$s]);$J
.=sprintf("%06o",$bb)."\0 ";echo$J,str_repeat("\0",512-strlen($J));$Wi->send();echo
str_repeat("\0",511-($Wi->size+511)%512);}function
doc_link(array$Gg,$Mi="<sup>?</sup>"){$Vh=connection()->server_info;$Mj=preg_replace('~^(\d\.?\d).*~s','\1',$Vh);$Aj=array('sql'=>"https://dev.mysql.com/doc/refman/$Mj/en/",'sqlite'=>"https://www.sqlite.org/",'pgsql'=>"https://www.postgresql.org/docs/".(connection()->flavor=='cockroach'?"current":$Mj)."/",'mssql'=>"https://learn.microsoft.com/en-us/sql/",'oracle'=>"https://www.oracle.com/pls/topic/lookup?ctx=db".preg_replace('~^.* (\d+)\.(\d+)\.\d+\.\d+\.\d+.*~s','\1\2',$Vh)."&id=",);if(connection()->flavor=='maria'){$Aj['sql']="https://mariadb.com/kb/en/";$Gg['sql']=(isset($Gg['mariadb'])?$Gg['mariadb']:str_replace(".html","/",$Gg['sql']));}return($Gg[JUSH]?"<a href='".h($Aj[JUSH].$Gg[JUSH].(JUSH=='mssql'?"?view=sql-server-ver$Mj":""))."'".target_blank().">$Mi</a>":"");}function
db_size($j){if(!connection()->select_db($j))return"?";$J=0;foreach(table_status()as$S)$J+=$S["Data_length"]+$S["Index_length"];return
format_number($J);}function
set_utf8mb4($h){static$O=false;if(!$O&&preg_match('~\butf8mb4~i',$h)){$O=true;echo"SET NAMES ".charset(connection()).";\n\n";}}if(isset($_GET["status"]))$_GET["variables"]=$_GET["status"];if(isset($_GET["import"]))$_GET["sql"]=$_GET["import"];if(!(DB!=""?connection()->select_db(DB):isset($_GET["sql"])||isset($_GET["dump"])||isset($_GET["database"])||isset($_GET["processlist"])||isset($_GET["privileges"])||isset($_GET["user"])||isset($_GET["variables"])||$_GET["script"]=="connect"||$_GET["script"]=="kill")){if(DB!=""||$_GET["refresh"]){restart_session();set_session("dbs",null);}if(DB!=""){header("HTTP/1.1 404 Not Found");page_header('Database'.": ".h(DB),'Invalid database.',true);}else{if($_POST["db"]&&!$l)queries_redirect(substr(ME,0,-1),'Databases have been dropped.',drop_databases($_POST["db"]));page_header('Select database',$l,false);echo"<p class='links'>\n";foreach(array('database'=>'Create database','privileges'=>'Privileges','processlist'=>'Process list','variables'=>'Variables','status'=>'Status',)as$x=>$X){if(support($x))echo"<a href='".h(ME)."$x='>$X</a>\n";}echo"<p>".sprintf('%s version: %s through PHP extension %s',get_driver(DRIVER),"<b>".h(connection()->server_info)."</b>","<b>".connection()->extension."</b>")."\n","<p>".sprintf('Logged as: %s',"<b>".h(logged_user())."</b>")."\n";$i=adminer()->databases();if($i){$Hh=support("scheme");$jb=collations();echo"<form action='' method='post'>\n","<table class='checkable odds'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),"<thead><tr>".(support("database")?"<td>":"")."<th>".'Database'.(get_session("dbs")!==null?" - <a href='".h(ME)."refresh=1'>".'Refresh'."</a>":"")."<td>".'Collation'."<td>".'Tables'."<td>".'Size'." - <a href='".h(ME)."dbsize=1'>".'Compute'."</a>".script("qsl('a').onclick = partial(ajaxSetHtml, '".js_escape(ME)."script=connect');","")."</thead>\n";$i=($_GET["dbsize"]?count_tables($i):array_flip($i));foreach($i
as$j=>$T){$zh=h(ME)."db=".urlencode($j);$t=h("Db-".$j);echo"<tr>".(support("database")?"<td>".checkbox("db[]",$j,in_array($j,(array)$_POST["db"]),"","","",$t):""),"<th><a href='$zh' id='$t'>".h($j)."</a>";$c=h(db_collation($j,$jb));echo"<td>".(support("database")?"<a href='$zh".($Hh?"&amp;ns=":"")."&amp;database=' title='".'Alter database'."'>$c</a>":$c),"<td align='right'><a href='$zh&amp;schema=' id='tables-".h($j)."' title='".'Database schema'."'>".($_GET["dbsize"]?$T:"?")."</a>","<td align='right' id='size-".h($j)."'>".($_GET["dbsize"]?db_size($j):"?"),"\n";}echo"</table>\n",(support("database")?"<div class='footer'><div>\n"."<fieldset><legend>".'Selected'." <span id='selected'></span></legend><div>\n".input_hidden("all").script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };")."<input type='submit' name='drop' value='".'Drop'."'>".confirm()."\n"."</div></fieldset>\n"."</div></div>\n":""),input_token(),"</form>\n",script("tableCheck();");}if(!empty(adminer()->plugins)){echo"<div class='plugins'>\n","<h3>".'Loaded plugins'."</h3>\n<ul>\n";foreach(adminer()->plugins
as$Lg){$Zb=(method_exists($Lg,'description')?$Lg->description():"");if(!$Zb){$oh=new
\ReflectionObject($Lg);if(preg_match('~^/[\s*]+(.+)~',$oh->getDocComment(),$A))$Zb=$A[1];}$Ih=(method_exists($Lg,'screenshot')?$Lg->screenshot():"");echo"<li><b>".get_class($Lg)."</b>".h($Zb?": $Zb":"").($Ih?" (<a href='".h($Ih)."'".target_blank().">".'screenshot'."</a>)":"")."\n";}echo"</ul>\n";adminer()->pluginsLinks();echo"</div>\n";}}page_footer("db");exit;}if(support("scheme")){if(DB!=""&&$_GET["ns"]!==""){if(!isset($_GET["ns"]))redirect(preg_replace('~ns=[^&]*&~','',ME)."ns=".get_schema());if(!set_schema($_GET["ns"])){header("HTTP/1.1 404 Not Found");page_header('Schema'.": ".h($_GET["ns"]),'Invalid schema.',true);page_footer("ns");exit;}}}adminer()->afterConnect();class
TmpFile{private$handler;var$size;function
__construct(){$this->handler=tmpfile();}function
write($zb){$this->size+=strlen($zb);fwrite($this->handler,$zb);}function
send(){fseek($this->handler,0);fpassthru($this->handler);fclose($this->handler);}}if(isset($_GET["select"])&&($_POST["edit"]||$_POST["clone"])&&!$_POST["save"])$_GET["edit"]=$_GET["select"];if(isset($_GET["callf"]))$_GET["call"]=$_GET["callf"];if(isset($_GET["function"]))$_GET["procedure"]=$_GET["function"];if(isset($_GET["download"])){$a=$_GET["download"];$n=fields($a);header("Content-Type: application/octet-stream");header("Content-Disposition: attachment; filename=".friendly_url("$a-".implode("_",$_GET["where"])).".".friendly_url($_GET["field"]));$M=array(idf_escape($_GET["field"]));$I=driver()->select($a,$M,array(where($_GET,$n)),$M);$K=($I?$I->fetch_row():array());echo
driver()->value($K[0],$n[$_GET["field"]]);exit;}elseif(isset($_GET["table"])){$a=$_GET["table"];$n=fields($a);if(!$n)$l=error()?:'No tables.';$S=table_status1($a);$B=adminer()->tableName($S);page_header(($n&&is_view($S)?$S['Engine']=='materialized view'?'Materialized view':'View':'Table').": ".($B!=""?$B:h($a)),$l);$yh=array();foreach($n
as$x=>$m)$yh+=$m["privileges"];adminer()->selectLinks($S,(isset($yh["insert"])||!support("table")?"":null));$ob=$S["Comment"];if($ob!="")echo"<p class='nowrap'>".'Comment'.": ".h($ob)."\n";if($n)adminer()->tableStructurePrint($n,$S);function
tables_links(array$T){echo"<ul>\n";foreach($T
as$K){$_=preg_replace('~ns=[^&]*~',"ns=".urlencode($K["ns"]),ME);echo"<li><a href='".h($_."table=".urlencode($K["table"]))."'>".($K["ns"]!=$_GET["ns"]?"<b>".h($K["ns"])."</b>.":"").h($K["table"])."</a>";}echo"</ul>\n";}$ie=driver()->inheritsFrom($a);if($ie){echo"<h3>".'Inherits from'."</h3>\n";tables_links($ie);}if(support("indexes")&&driver()->supportsIndex($S)){echo"<h3 id='indexes'>".'Indexes'."</h3>\n";$w=indexes($a);if($w)adminer()->tableIndexesPrint($w,$S);echo'<p class="links"><a href="'.h(ME).'indexes='.urlencode($a).'">'.'Alter indexes'."</a>\n";}if(!is_view($S)){if(fk_support($S)){echo"<h3 id='foreign-keys'>".'Foreign keys'."</h3>\n";$kd=foreign_keys($a);if($kd){echo"<table>\n","<thead><tr><th>".'Source'."<td>".'Target'."<td>".'ON DELETE'."<td>".'ON UPDATE'."<td></thead>\n";foreach($kd
as$B=>$p){echo"<tr title='".h($B)."'>","<th><i>".implode("</i>, <i>",array_map('Adminer\h',$p["source"]))."</i>";$_=($p["db"]!=""?preg_replace('~db=[^&]*~',"db=".urlencode($p["db"]),ME):($p["ns"]!=""?preg_replace('~ns=[^&]*~',"ns=".urlencode($p["ns"]),ME):ME));echo"<td><a href='".h($_."table=".urlencode($p["table"]))."'>".($p["db"]!=""&&$p["db"]!=DB?"<b>".h($p["db"])."</b>.":"").($p["ns"]!=""&&$p["ns"]!=$_GET["ns"]?"<b>".h($p["ns"])."</b>.":"").h($p["table"])."</a>","(<i>".implode("</i>, <i>",array_map('Adminer\h',$p["target"]))."</i>)","<td>".h($p["on_delete"]),"<td>".h($p["on_update"]),'<td><a href="'.h(ME.'foreign='.urlencode($a).'&name='.urlencode($B)).'">'.'Alter'.'</a>',"\n";}echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'foreign='.urlencode($a).'">'.'Add foreign key'."</a>\n";}if(support("check")){echo"<h3 id='checks'>".'Checks'."</h3>\n";$Xa=driver()->checkConstraints($a);if($Xa){echo"<table>\n";foreach($Xa
as$x=>$X)echo"<tr title='".h($x)."'>","<td><code class='jush-".JUSH."'>".h($X),"<td><a href='".h(ME.'check='.urlencode($a).'&name='.urlencode($x))."'>".'Alter'."</a>","\n";echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'check='.urlencode($a).'">'.'Create check'."</a>\n";}}if(support(is_view($S)?"view_trigger":"trigger")){echo"<h3 id='triggers'>".'Triggers'."</h3>\n";$kj=triggers($a);if($kj){echo"<table>\n";foreach($kj
as$x=>$X)echo"<tr valign='top'><td>".h($X[0])."<td>".h($X[1])."<th>".h($x)."<td><a href='".h(ME.'trigger='.urlencode($a).'&name='.urlencode($x))."'>".'Alter'."</a>\n";echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'trigger='.urlencode($a).'">'.'Add trigger'."</a>\n";}$he=driver()->inheritedTables($a);if($he){echo"<h3 id='partitions'>".'Inherited by'."</h3>\n";$_g=driver()->partitionsInfo($a);if($_g)echo"<p><code class='jush-".JUSH."'>BY ".h("$_g[partition_by]($_g[partition])")."</code>\n";tables_links($he);}}elseif(isset($_GET["schema"])){page_header('Database schema',"",array(),h(DB.($_GET["ns"]?".$_GET[ns]":"")));$Bi=array();$Ci=array();$ca=($_GET["schema"]?:$_COOKIE["adminer_schema-".str_replace(".","_",DB)]);preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~',$ca,$Ze,PREG_SET_ORDER);foreach($Ze
as$s=>$A){$Bi[$A[1]]=array($A[2],$A[3]);$Ci[]="\n\t'".js_escape($A[1])."': [ $A[2], $A[3] ]";}$Zi=0;$Ga=-1;$Fh=array();$nh=array();$Me=array();$sa=driver()->allFields();foreach(table_status('',true)as$R=>$S){if(is_view($S))continue;$Og=0;$Fh[$R]["fields"]=array();foreach($sa[$R]as$m){$Og+=1.25;$m["pos"]=$Og;$Fh[$R]["fields"][$m["field"]]=$m;}$Fh[$R]["pos"]=($Bi[$R]?:array($Zi,0));foreach(adminer()->foreignKeys($R)as$X){if(!$X["db"]){$Ke=$Ga;if(idx($Bi[$R],1)||idx($Bi[$X["table"]],1))$Ke=min(idx($Bi[$R],1,0),idx($Bi[$X["table"]],1,0))-1;else$Ga-=.1;while($Me[(string)$Ke])$Ke-=.0001;$Fh[$R]["references"][$X["table"]][(string)$Ke]=array($X["source"],$X["target"]);$nh[$X["table"]][$R][(string)$Ke]=$X["target"];$Me[(string)$Ke]=true;}}$Zi=max($Zi,$Fh[$R]["pos"][0]+2.5+$Og);}echo'<div id="schema" style="height: ',$Zi,'em;">
<script',nonce(),'>
qs(\'#schema\').onselectstart = () => false;
const tablePos = {',implode(",",$Ci)."\n",'};
const em = qs(\'#schema\').offsetHeight / ',$Zi,';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'',js_escape(DB),'\');
</script>
';foreach($Fh
as$B=>$R){echo"<div class='table' style='top: ".$R["pos"][0]."em; left: ".$R["pos"][1]."em;'>",'<a href="'.h(ME).'table='.urlencode($B).'"><b>'.h($B)."</b></a>",script("qsl('div').onmousedown = schemaMousedown;");foreach($R["fields"]as$m){$X='<span'.type_class($m["type"]).' title="'.h($m["type"].($m["length"]?"($m[length])":"").($m["null"]?" NULL":'')).'">'.h($m["field"]).'</span>';echo"<br>".($m["primary"]?"<i>$X</i>":$X);}foreach((array)$R["references"]as$Ji=>$ph){foreach($ph
as$Ke=>$kh){$Le=$Ke-idx($Bi[$B],1);$s=0;foreach($kh[0]as$fi)echo"\n<div class='references' title='".h($Ji)."' id='refs$Ke-".($s++)."' style='left: $Le"."em; top: ".$R["fields"][$fi]["pos"]."em; padding-top: .5em;'>"."<div style='border-top: 1px solid gray; width: ".(-$Le)."em;'></div></div>";}}foreach((array)$nh[$B]as$Ji=>$ph){foreach($ph
as$Ke=>$e){$Le=$Ke-idx($Bi[$B],1);$s=0;foreach($e
as$Ii)echo"\n<div class='references arrow' title='".h($Ji)."' id='refd$Ke-".($s++)."' style='left: $Le"."em; top: ".$R["fields"][$Ii]["pos"]."em;'>"."<div style='height: .5em; border-bottom: 1px solid gray; width: ".(-$Le)."em;'></div>"."</div>";}}echo"\n</div>\n";}foreach($Fh
as$B=>$R){foreach((array)$R["references"]as$Ji=>$ph){foreach($ph
as$Ke=>$kh){$sf=$Zi;$ff=-10;foreach($kh[0]as$x=>$fi){$Pg=$R["pos"][0]+$R["fields"][$fi]["pos"];$Qg=$Fh[$Ji]["pos"][0]+$Fh[$Ji]["fields"][$kh[1][$x]]["pos"];$sf=min($sf,$Pg,$Qg);$ff=max($ff,$Pg,$Qg);}echo"<div class='references' id='refl$Ke' style='left: $Ke"."em; top: $sf"."em; padding: .5em 0;'><div style='border-right: 1px solid gray; margin-top: 1px; height: ".($ff-$sf)."em;'></div></div>\n";}}}echo'</div>
<p class="links"><a href="',h(ME."schema=".urlencode($ca)),'" id="schema-link">Permanent link</a>
';}elseif(isset($_GET["dump"])){$a=$_GET["dump"];if($_POST&&!$l){save_settings(array_intersect_key($_POST,array_flip(array("output","format","db_style","types","routines","events","table_style","auto_increment","triggers","data_style"))),"adminer_export");$T=array_flip((array)$_POST["tables"])+array_flip((array)$_POST["data"]);$Mc=dump_headers((count($T)==1?key($T):DB),(DB==""||count($T)>1));$ve=preg_match('~sql~',$_POST["format"]);if($ve){echo"-- Adminer ".VERSION." ".get_driver(DRIVER)." ".str_replace("\n"," ",connection()->server_info)." dump\n\n";if(JUSH=="sql"){echo"SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
".($_POST["data_style"]?"SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
":"")."
";connection()->query("SET time_zone = '+00:00'");connection()->query("SET sql_mode = ''");}}$si=$_POST["db_style"];$i=array(DB);if(DB==""){$i=$_POST["databases"];if(is_string($i))$i=explode("\n",rtrim(str_replace("\r","",$i),"\n"));}foreach((array)$i
as$j){adminer()->dumpDatabase($j);if(connection()->select_db($j)){if($ve){if($si)echo
use_sql($j,$si).";\n\n";$qg="";if($_POST["types"]){foreach(types()as$t=>$U){$Ac=type_values($t);if($Ac)$qg
.=($si!='DROP+CREATE'?"DROP TYPE IF EXISTS ".idf_escape($U).";;\n":"")."CREATE TYPE ".idf_escape($U)." AS ENUM ($Ac);\n\n";else$qg
.="-- Could not export type $U\n\n";}}if($_POST["routines"]){foreach(routines()as$K){$B=$K["ROUTINE_NAME"];$_h=$K["ROUTINE_TYPE"];$h=create_routine($_h,array("name"=>$B)+routine($K["SPECIFIC_NAME"],$_h));set_utf8mb4($h);$qg
.=($si!='DROP+CREATE'?"DROP $_h IF EXISTS ".idf_escape($B).";;\n":"")."$h;\n\n";}}if($_POST["events"]){foreach(get_rows("SHOW EVENTS",null,"-- ")as$K){$h=remove_definer(get_val("SHOW CREATE EVENT ".idf_escape($K["Name"]),3));set_utf8mb4($h);$qg
.=($si!='DROP+CREATE'?"DROP EVENT IF EXISTS ".idf_escape($K["Name"]).";;\n":"")."$h;;\n\n";}}echo($qg&&JUSH=='sql'?"DELIMITER ;;\n\n$qg"."DELIMITER ;\n\n":$qg);}if($_POST["table_style"]||$_POST["data_style"]){$Oj=array();foreach(table_status('',true)as$B=>$S){$R=(DB==""||in_array($B,(array)$_POST["tables"]));$Lb=(DB==""||in_array($B,(array)$_POST["data"]));if($R||$Lb){$Wi=null;if($Mc=="tar"){$Wi=new
TmpFile;ob_start(array($Wi,'write'),1e5);}adminer()->dumpTable($B,($R?$_POST["table_style"]:""),(is_view($S)?2:0));if(is_view($S))$Oj[]=$B;elseif($Lb){$n=fields($B);adminer()->dumpData($B,$_POST["data_style"],"SELECT *".convert_fields($n,$n)." FROM ".table($B));}if($ve&&$_POST["triggers"]&&$R&&($kj=trigger_sql($B)))echo"\nDELIMITER ;;\n$kj\nDELIMITER ;\n";if($Mc=="tar"){ob_end_flush();tar_file((DB!=""?"":"$j/")."$B.csv",$Wi);}elseif($ve)echo"\n";}}if(function_exists('Adminer\foreign_keys_sql')){foreach(table_status('',true)as$B=>$S){$R=(DB==""||in_array($B,(array)$_POST["tables"]));if($R&&!is_view($S))echo
foreign_keys_sql($B);}}foreach($Oj
as$Nj)adminer()->dumpTable($Nj,$_POST["table_style"],1);if($Mc=="tar")echo
pack("x512");}}}adminer()->dumpFooter();exit;}page_header('Export',$l,($_GET["export"]!=""?array("table"=>$_GET["export"]):array()),h(DB));echo'
<form action="" method="post">
<table class="layout">
';$Pb=array('','USE','DROP+CREATE','CREATE');$Di=array('','DROP+CREATE','CREATE');$Mb=array('','TRUNCATE+INSERT','INSERT');if(JUSH=="sql")$Mb[]='INSERT+UPDATE';$K=get_settings("adminer_export");if(!$K)$K=array("output"=>"text","format"=>"sql","db_style"=>(DB!=""?"":"CREATE"),"table_style"=>"DROP+CREATE","data_style"=>"INSERT");if(!isset($K["events"])){$K["routines"]=$K["events"]=($_GET["dump"]=="");$K["triggers"]=$K["table_style"];}echo"<tr><th>".'Output'."<td>".html_radios("output",adminer()->dumpOutput(),$K["output"])."\n","<tr><th>".'Format'."<td>".html_radios("format",adminer()->dumpFormat(),$K["format"])."\n",(JUSH=="sqlite"?"":"<tr><th>".'Database'."<td>".html_select('db_style',$Pb,$K["db_style"]).(support("type")?checkbox("types",1,$K["types"],'User types'):"").(support("routine")?checkbox("routines",1,$K["routines"],'Routines'):"").(support("event")?checkbox("events",1,$K["events"],'Events'):"")),"<tr><th>".'Tables'."<td>".html_select('table_style',$Di,$K["table_style"]).checkbox("auto_increment",1,$K["auto_increment"],'Auto Increment').(support("trigger")?checkbox("triggers",1,$K["triggers"],'Triggers'):""),"<tr><th>".'Data'."<td>".html_select('data_style',$Mb,$K["data_style"]),'</table>
<p><input type="submit" value="Export">
',input_token(),'
<table>
',script("qsl('table').onclick = dumpClick;");$Ug=array();if(DB!=""){$Za=($a!=""?"":" checked");echo"<thead><tr>","<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$Za>".'Tables'."</label>".script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);",""),"<th style='text-align: right;'><label class='block'>".'Data'."<input type='checkbox' id='check-data'$Za></label>".script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);",""),"</thead>\n";$Oj="";$Fi=tables_list();foreach($Fi
as$B=>$U){$Tg=preg_replace('~_.*~','',$B);$Za=($a==""||$a==(substr($a,-1)=="%"?"$Tg%":$B));$Xg="<tr><td>".checkbox("tables[]",$B,$Za,$B,"","block");if($U!==null&&!preg_match('~table~i',$U))$Oj
.="$Xg\n";else
echo"$Xg<td align='right'><label class='block'><span id='Rows-".h($B)."'></span>".checkbox("data[]",$B,$Za)."</label>\n";$Ug[$Tg]++;}echo$Oj;if($Fi)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}else{echo"<thead><tr><th style='text-align: left;'>","<label class='block'><input type='checkbox' id='check-databases'".($a==""?" checked":"").">".'Database'."</label>",script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);",""),"</thead>\n";$i=adminer()->databases();if($i){foreach($i
as$j){if(!information_schema($j)){$Tg=preg_replace('~_.*~','',$j);echo"<tr><td>".checkbox("databases[]",$j,$a==""||$a=="$Tg%",$j,"","block")."\n";$Ug[$Tg]++;}}}else
echo"<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";}echo'</table>
</form>
';$ad=true;foreach($Ug
as$x=>$X){if($x!=""&&$X>1){echo($ad?"<p>":" ")."<a href='".h(ME)."dump=".urlencode("$x%")."'>".h($x)."</a>";$ad=false;}}}elseif(isset($_GET["privileges"])){page_header('Privileges');echo'<p class="links"><a href="'.h(ME).'user=">'.'Create user'."</a>";$I=connection()->query("SELECT User, Host FROM mysql.".(DB==""?"user":"db WHERE ".q(DB)." LIKE Db")." ORDER BY Host, User");$td=$I;if(!$I)$I=connection()->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");echo"<form action=''><p>\n";hidden_fields_get();echo
input_hidden("db",DB),($td?"":input_hidden("grant")),"<table class='odds'>\n","<thead><tr><th>".'Username'."<th>".'Server'."<th></thead>\n";while($K=$I->fetch_assoc())echo'<tr><td>'.h($K["User"])."<td>".h($K["Host"]).'<td><a href="'.h(ME.'user='.urlencode($K["User"]).'&host='.urlencode($K["Host"])).'">'.'Edit'."</a>\n";if(!$td||DB!="")echo"<tr><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='".'Edit'."'>\n";echo"</table>\n","</form>\n";}elseif(isset($_GET["sql"])){if(!$l&&$_POST["export"]){save_settings(array("output"=>$_POST["output"],"format"=>$_POST["format"]),"adminer_import");dump_headers("sql");if($_POST["format"]=="sql")echo"$_POST[query]\n";else{adminer()->dumpTable("","");adminer()->dumpData("","table",$_POST["query"]);adminer()->dumpFooter();}exit;}restart_session();$Jd=&get_session("queries");$Id=&$Jd[DB];if(!$l&&$_POST["clear"]){$Id=array();redirect(remove_from_uri("history"));}stop_session();page_header((isset($_GET["import"])?'Import':'SQL command'),$l);$Qe='--'.(JUSH=='sql'?' ':'');if(!$l&&$_POST){$q=false;if(!isset($_GET["import"]))$H=$_POST["query"];elseif($_POST["webfile"]){$ji=adminer()->importServerPath();$q=@fopen((file_exists($ji)?$ji:"compress.zlib://$ji.gz"),"rb");$H=($q?fread($q,1e6):false);}else$H=get_file("sql_file",true,";");if(is_string($H)){if(function_exists('memory_get_usage')&&($kf=ini_bytes("memory_limit"))!="-1")@ini_set("memory_limit",max($kf,strval(2*strlen($H)+memory_get_usage()+8e6)));if($H!=""&&strlen($H)<1e6){$dh=$H.(preg_match("~;[ \t\r\n]*\$~",$H)?"":";");if(!$Id||first(end($Id))!=$dh){restart_session();$Id[]=array($dh,time());set_session("queries",$Jd);stop_session();}}$gi="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|$Qe)[^\n]*\n?|--\r?\n)";$Xb=driver()->delimiter;$C=0;$vc=true;$g=connect();if($g&&DB!=""){$g->select_db(DB);if($_GET["ns"]!="")set_schema($_GET["ns"],$g);}$nb=0;$Cc=array();$xg='[\'"'.(JUSH=="sql"?'`#':(JUSH=="sqlite"?'`[':(JUSH=="mssql"?'[':''))).']|/\*|'.$Qe.'|$'.(JUSH=="pgsql"?'|\$([a-zA-Z]\w*)?\$':'');$aj=microtime(true);$ma=get_settings("adminer_import");while($H!=""){if(!$C&&preg_match("~^$gi*+DELIMITER\\s+(\\S+)~i",$H,$A)){$Xb=preg_quote($A[1]);$H=substr($H,strlen($A[0]));}elseif(!$C&&JUSH=='pgsql'&&preg_match("~^($gi*+COPY\\s+)[^;]+\\s+FROM\\s+stdin;~i",$H,$A)){$Xb="\n\\\\\\.\r?\n";$C=strlen($A[0]);}else{preg_match("($Xb\\s*|$xg)",$H,$A,PREG_OFFSET_CAPTURE,$C);list($md,$Og)=$A[0];if(!$md&&$q&&!feof($q))$H
.=fread($q,1e5);else{if(!$md&&rtrim($H)=="")break;$C=$Og+strlen($md);if($md&&!preg_match("(^$Xb)",$md)){$Ra=driver()->hasCStyleEscapes()||(JUSH=="pgsql"&&($Og>0&&strtolower($H[$Og-1])=="e"));$Hg=($md=='/*'?'\*/':($md=='['?']':(preg_match("~^$Qe|^#~",$md)?"\n":preg_quote($md).($Ra?'|\\\\.':''))));while(preg_match("($Hg|\$)s",$H,$A,PREG_OFFSET_CAPTURE,$C)){$Dh=$A[0][0];if(!$Dh&&$q&&!feof($q))$H
.=fread($q,1e5);else{$C=$A[0][1]+strlen($Dh);if(!$Dh||$Dh[0]!="\\")break;}}}else{$vc=false;$dh=substr($H,0,$Og+($Xb[0]=="\n"?3:0));$nb++;$Xg="<pre id='sql-$nb'><code class='jush-".JUSH."'>".adminer()->sqlCommandQuery($dh)."</code></pre>\n";if(JUSH=="sqlite"&&preg_match("~^$gi*+ATTACH\\b~i",$dh,$A)){echo$Xg,"<p class='error'>".'ATTACH queries are not supported.'."\n";$Cc[]=" <a href='#sql-$nb'>$nb</a>";if($_POST["error_stops"])break;}else{if(!$_POST["only_errors"]){echo$Xg;ob_flush();flush();}$oi=microtime(true);if(connection()->multi_query($dh)&&$g&&preg_match("~^$gi*+USE\\b~i",$dh))$g->query($dh);do{$I=connection()->store_result();if(connection()->error){echo($_POST["only_errors"]?$Xg:""),"<p class='error'>".'Error in query'.(connection()->errno?" (".connection()->errno.")":"").": ".error()."\n";$Cc[]=" <a href='#sql-$nb'>$nb</a>";if($_POST["error_stops"])break
2;}else{$Pi=" <span class='time'>(".format_time($oi).")</span>".(strlen($dh)<1000?" <a href='".h(ME)."sql=".urlencode(trim($dh))."'>".'Edit'."</a>":"");$oa=connection()->affected_rows;$Rj=($_POST["only_errors"]?"":driver()->warnings());$Sj="warnings-$nb";if($Rj)$Pi
.=", <a href='#$Sj'>".'Warnings'."</a>".script("qsl('a').onclick = partial(toggle, '$Sj');","");$Kc=null;$ig=null;$Lc="explain-$nb";if(is_object($I)){$z=$_POST["limit"];$ig=print_select_result($I,$g,array(),$z);if(!$_POST["only_errors"]){echo"<form action='' method='post'>\n";$Jf=$I->num_rows;echo"<p class='sql-footer'>".($Jf?($z&&$Jf>$z?sprintf('%d / ',$z):"").lang_format(array('%d row','%d rows'),$Jf):""),$Pi;if($g&&preg_match("~^($gi|\\()*+SELECT\\b~i",$dh)&&($Kc=explain($g,$dh)))echo", <a href='#$Lc'>Explain</a>".script("qsl('a').onclick = partial(toggle, '$Lc');","");$t="export-$nb";echo", <a href='#$t'>".'Export'."</a>".script("qsl('a').onclick = partial(toggle, '$t');","")."<span id='$t' class='hidden'>: ".html_select("output",adminer()->dumpOutput(),$ma["output"])." ".html_select("format",adminer()->dumpFormat(),$ma["format"]).input_hidden("query",$dh)."<input type='submit' name='export' value='".'Export'."'>".input_token()."</span>\n"."</form>\n";}}else{if(preg_match("~^$gi*+(CREATE|DROP|ALTER)$gi++(DATABASE|SCHEMA)\\b~i",$dh)){restart_session();set_session("dbs",null);stop_session();}if(!$_POST["only_errors"])echo"<p class='message' title='".h(connection()->info)."'>".lang_format(array('Query executed OK, %d row affected.','Query executed OK, %d rows affected.'),$oa)."$Pi\n";}echo($Rj?"<div id='$Sj' class='hidden'>\n$Rj</div>\n":"");if($Kc){echo"<div id='$Lc' class='hidden explain'>\n";print_select_result($Kc,$g,$ig);echo"</div>\n";}}$oi=microtime(true);}while(connection()->next_result());}$H=substr($H,$C);$C=0;}}}}if($vc)echo"<p class='message'>".'No commands to execute.'."\n";elseif($_POST["only_errors"])echo"<p class='message'>".lang_format(array('%d query executed OK.','%d queries executed OK.'),$nb-count($Cc))," <span class='time'>(".format_time($aj).")</span>\n";elseif($Cc&&$nb>1)echo"<p class='error'>".'Error in query'.": ".implode("",$Cc)."\n";}else
echo"<p class='error'>".upload_error($H)."\n";}echo'
<form action="" method="post" enctype="multipart/form-data" id="form">
';$Ic="<input type='submit' value='".'Execute'."' title='Ctrl+Enter'>";if(!isset($_GET["import"])){$dh=$_GET["sql"];if($_POST)$dh=$_POST["query"];elseif($_GET["history"]=="all")$dh=$Id;elseif($_GET["history"]!="")$dh=idx($Id[$_GET["history"]],0);echo"<p>";textarea("query",$dh,20);echo
script(($_POST?"":"qs('textarea').focus();\n")."qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '".js_escape(remove_from_uri("sql|limit|error_stops|only_errors|history"))."');"),"<p>";adminer()->sqlPrintAfter();echo"$Ic\n",'Limit rows'.": <input type='number' name='limit' class='size' value='".h($_POST?$_POST["limit"]:$_GET["limit"])."'>\n";}else{$zd=(extension_loaded("zlib")?"[.gz]":"");echo"<fieldset><legend>".'File upload'."</legend><div>",file_input("SQL$zd: <input type='file' name='sql_file[]' multiple>\n$Ic"),"</div></fieldset>\n";$Ud=adminer()->importServerPath();if($Ud)echo"<fieldset><legend>".'From server'."</legend><div>",sprintf('Webserver file %s',"<code>".h($Ud)."$zd</code>"),' <input type="submit" name="webfile" value="'.'Run file'.'">',"</div></fieldset>\n";echo"<p>";}echo
checkbox("error_stops",1,($_POST?$_POST["error_stops"]:isset($_GET["import"])||$_GET["error_stops"]),'Stop on error')."\n",checkbox("only_errors",1,($_POST?$_POST["only_errors"]:isset($_GET["import"])||$_GET["only_errors"]),'Show only errors')."\n",input_token();if(!isset($_GET["import"])&&$Id){print_fieldset("history",'History',$_GET["history"]!="");for($X=end($Id);$X;$X=prev($Id)){$x=key($Id);list($dh,$Pi,$qc)=$X;echo'<a href="'.h(ME."sql=&history=$x").'">'.'Edit'."</a>"." <span class='time' title='".@date('Y-m-d',$Pi)."'>".@date("H:i:s",$Pi)."</span>"." <code class='jush-".JUSH."'>".shorten_utf8(ltrim(str_replace("\n"," ",str_replace("\r","",preg_replace("~^(#|$Qe).*~m",'',$dh)))),80,"</code>").($qc?" <span class='time'>($qc)</span>":"")."<br>\n";}echo"<input type='submit' name='clear' value='".'Clear'."'>\n","<a href='".h(ME."sql=&history=all")."'>".'Edit all'."</a>\n","</div></fieldset>\n";}echo'</form>
';}elseif(isset($_GET["edit"])){$a=$_GET["edit"];$n=fields($a);$Z=(isset($_GET["select"])?($_POST["check"]&&count($_POST["check"])==1?where_check($_POST["check"][0],$n):""):where($_GET,$n));$wj=(isset($_GET["select"])?$_POST["edit"]:$Z);foreach($n
as$B=>$m){if((!$wj&&!isset($m["privileges"]["insert"]))||adminer()->fieldName($m)=="")unset($n[$B]);}if($_POST&&!$l&&!isset($_GET["select"])){$Se=$_POST["referer"];if($_POST["insert"])$Se=($wj?null:$_SERVER["REQUEST_URI"]);elseif(!preg_match('~^.+&select=.+$~',$Se))$Se=ME."select=".urlencode($a);$w=indexes($a);$rj=unique_array($_GET["where"],$w);$gh="\nWHERE $Z";if(isset($_POST["delete"]))queries_redirect($Se,'Item has been deleted.',driver()->delete($a,$gh,$rj?0:1));else{$O=array();foreach($n
as$B=>$m){$X=process_input($m);if($X!==false&&$X!==null)$O[idf_escape($B)]=$X;}if($wj){if(!$O)redirect($Se);queries_redirect($Se,'Item has been updated.',driver()->update($a,$O,$gh,$rj?0:1));if(is_ajax()){page_headers();page_messages($l);exit;}}else{$I=driver()->insert($a,$O);$Je=($I?last_id($I):0);queries_redirect($Se,sprintf('Item%s has been inserted.',($Je?" $Je":"")),$I);}}}$K=null;if($Z){$M=array();foreach($n
as$B=>$m){if(isset($m["privileges"]["select"])){$wa=($_POST["clone"]&&$m["auto_increment"]?"''":convert_field($m));$M[]=($wa?"$wa AS ":"").idf_escape($B);}}$K=array();if(!support("table"))$M=array("*");if($M){$I=driver()->select($a,$M,array($Z),$M,array(),(isset($_GET["select"])?2:1));if(!$I)$l=error();else{$K=$I->fetch_assoc();if(!$K)$K=false;}if(isset($_GET["select"])&&(!$K||$I->fetch_assoc()))$K=null;}}if(!support("table")&&!$n){if(!$Z){$I=driver()->select($a,array("*"),array(),array("*"));$K=($I?$I->fetch_assoc():false);if(!$K)$K=array(driver()->primary=>"");}if($K){foreach($K
as$x=>$X){if(!$Z)$K[$x]=null;$n[$x]=array("field"=>$x,"null"=>($x!=driver()->primary),"auto_increment"=>($x==driver()->primary));}}}if($_POST["save"])$K=(array)$_POST["fields"]+($K?$K:array());edit_form($a,$n,$K,$wj,$l);}elseif(isset($_GET["create"])){$a=$_GET["create"];$Bg=driver()->partitionBy;$Eg=($Bg?driver()->partitionsInfo($a):array());$mh=referencable_primary($a);$kd=array();foreach($mh
as$_i=>$m)$kd[str_replace("`","``",$_i)."`".str_replace("`","``",$m["field"])]=$_i;$lg=array();$S=array();if($a!=""){$lg=fields($a);$S=table_status1($a);if(count($S)<2)$l='No tables.';}$K=$_POST;$K["fields"]=(array)$K["fields"];if($K["auto_increment_col"])$K["fields"][$K["auto_increment_col"]]["auto_increment"]=true;if($_POST)save_settings(array("comments"=>$_POST["comments"],"defaults"=>$_POST["defaults"]));if($_POST&&!process_fields($K["fields"])&&!$l){if($_POST["drop"])queries_redirect(substr(ME,0,-1),'Table has been dropped.',drop_tables(array($a)));else{$n=array();$sa=array();$Bj=false;$id=array();$kg=reset($lg);$qa=" FIRST";foreach($K["fields"]as$x=>$m){$p=$kd[$m["type"]];$mj=($p!==null?$mh[$p]:$m);if($m["field"]!=""){if(!$m["generated"])$m["default"]=null;$ch=process_field($m,$mj);$sa[]=array($m["orig"],$ch,$qa);if(!$kg||$ch!==process_field($kg,$kg)){$n[]=array($m["orig"],$ch,$qa);if($m["orig"]!=""||$qa)$Bj=true;}if($p!==null)$id[idf_escape($m["field"])]=($a!=""&&JUSH!="sqlite"?"ADD":" ").format_foreign_key(array('table'=>$kd[$m["type"]],'source'=>array($m["field"]),'target'=>array($mj["field"]),'on_delete'=>$m["on_delete"],));$qa=" AFTER ".idf_escape($m["field"]);}elseif($m["orig"]!=""){$Bj=true;$n[]=array($m["orig"]);}if($m["orig"]!=""){$kg=next($lg);if(!$kg)$qa="";}}$E=array();if(in_array($K["partition_by"],$Bg)){foreach($K
as$x=>$X){if(preg_match('~^partition~',$x))$E[$x]=$X;}foreach($E["partition_names"]as$x=>$B){if($B==""){unset($E["partition_names"][$x]);unset($E["partition_values"][$x]);}}$E["partition_names"]=array_values($E["partition_names"]);$E["partition_values"]=array_values($E["partition_values"]);if($E==$Eg)$E=array();}elseif(preg_match("~partitioned~",$S["Create_options"]))$E=null;$mf='Table has been altered.';if($a==""){cookie("adminer_engine",$K["Engine"]);$mf='Table has been created.';}$B=trim($K["name"]);queries_redirect(ME.(support("table")?"table=":"select=").urlencode($B),$mf,alter_table($a,$B,(JUSH=="sqlite"&&($Bj||$id)?$sa:$n),$id,($K["Comment"]!=$S["Comment"]?$K["Comment"]:null),($K["Engine"]&&$K["Engine"]!=$S["Engine"]?$K["Engine"]:""),($K["Collation"]&&$K["Collation"]!=$S["Collation"]?$K["Collation"]:""),($K["Auto_increment"]!=""?number($K["Auto_increment"]):""),$E));}}page_header(($a!=""?'Alter table':'Create table'),$l,array("table"=>$a),h($a));if(!$_POST){$nj=driver()->types();$K=array("Engine"=>$_COOKIE["adminer_engine"],"fields"=>array(array("field"=>"","type"=>(isset($nj["int"])?"int":(isset($nj["integer"])?"integer":"")),"on_update"=>"")),"partition_names"=>array(""),);if($a!=""){$K=$S;$K["name"]=$a;$K["fields"]=array();if(!$_GET["auto_increment"])$K["Auto_increment"]="";foreach($lg
as$m){$m["generated"]=$m["generated"]?:(isset($m["default"])?"DEFAULT":"");$K["fields"][]=$m;}if($Bg){$K+=$Eg;$K["partition_names"][]="";$K["partition_values"][]="";}}}$jb=collations();if(is_array(reset($jb)))$jb=call_user_func_array('array_merge',array_values($jb));$xc=driver()->engines();foreach($xc
as$wc){if(!strcasecmp($wc,$K["Engine"])){$K["Engine"]=$wc;break;}}echo'
<form action="" method="post" id="form">
<p>
';if(support("columns")||$a==""){echo'Table name'.": <input name='name'".($a==""&&!$_POST?" autofocus":"")." data-maxlength='64' value='".h($K["name"])."' autocapitalize='off'>\n",($xc?html_select("Engine",array(""=>"(".'engine'.")")+$xc,$K["Engine"]).on_help("event.target.value",1).script("qsl('select').onchange = helpClose;")."\n":"");if($jb)echo"<datalist id='collations'>".optionlist($jb)."</datalist>\n",(preg_match("~sqlite|mssql~",JUSH)?"":"<input list='collations' name='Collation' value='".h($K["Collation"])."' placeholder='(".'collation'.")'>\n");echo"<input type='submit' value='".'Save'."'>\n";}if(support("columns")){echo"<div class='scrollable'>\n","<table id='edit-fields' class='nowrap'>\n";edit_fields($K["fields"],$jb,"TABLE",$kd);echo"</table>\n",script("editFields();"),"</div>\n<p>\n",'Auto Increment'.": <input type='number' name='Auto_increment' class='size' value='".h($K["Auto_increment"])."'>\n",checkbox("defaults",1,($_POST?$_POST["defaults"]:get_setting("defaults")),'Default values',"columnShow(this.checked, 5)","jsonly");$qb=($_POST?$_POST["comments"]:get_setting("comments"));echo(support("comment")?checkbox("comments",1,$qb,'Comment',"editingCommentsClick(this, true);","jsonly").' '.(preg_match('~\n~',$K["Comment"])?"<textarea name='Comment' rows='2' cols='20'".($qb?"":" class='hidden'").">".h($K["Comment"])."</textarea>":'<input name="Comment" value="'.h($K["Comment"]).'" data-maxlength="'.(min_version(5.5)?2048:60).'"'.($qb?"":" class='hidden'").'>'):''),'<p>
<input type="submit" value="Save">
';}echo'
';if($a!="")echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$a));if($Bg&&(JUSH=='sql'||$a=="")){$Cg=preg_match('~RANGE|LIST~',$K["partition_by"]);print_fieldset("partition",'Partition by',$K["partition_by"]);echo"<p>".html_select("partition_by",array_merge(array(""),$Bg),$K["partition_by"]).on_help("event.target.value.replace(/./, 'PARTITION BY \$&')",1).script("qsl('select').onchange = partitionByChange;"),"(<input name='partition' value='".h($K["partition"])."'>)\n",'Partitions'.": <input type='number' name='partitions' class='size".($Cg||!$K["partition_by"]?" hidden":"")."' value='".h($K["partitions"])."'>\n","<table id='partition-table'".($Cg?"":" class='hidden'").">\n","<thead><tr><th>".'Partition name'."<th>".'Values'."</thead>\n";foreach($K["partition_names"]as$x=>$X)echo'<tr>','<td><input name="partition_names[]" value="'.h($X).'" autocapitalize="off">',($x==count($K["partition_names"])-1?script("qsl('input').oninput = partitionNameChange;"):''),'<td><input name="partition_values[]" value="'.h(idx($K["partition_values"],$x)).'">';echo"</table>\n</div></fieldset>\n";}echo
input_token(),'</form>
';}elseif(isset($_GET["indexes"])){$a=$_GET["indexes"];$ce=array("PRIMARY","UNIQUE","INDEX");$S=table_status1($a,true);$Zd=driver()->indexAlgorithms($S);if(preg_match('~MyISAM|M?aria'.(min_version(5.6,'10.0.5')?'|InnoDB':'').'~i',$S["Engine"]))$ce[]="FULLTEXT";if(preg_match('~MyISAM|M?aria'.(min_version(5.7,'10.2.2')?'|InnoDB':'').'~i',$S["Engine"]))$ce[]="SPATIAL";$w=indexes($a);$n=fields($a);$G=array();if(JUSH=="mongo"){$G=$w["_id_"];unset($ce[0]);unset($w["_id_"]);}$K=$_POST;if($K)save_settings(array("index_options"=>$K["options"]));if($_POST&&!$l&&!$_POST["add"]&&!$_POST["drop_col"]){$b=array();foreach($K["indexes"]as$v){$B=$v["name"];if(in_array($v["type"],$ce)){$e=array();$Oe=array();$ac=array();$ae=(support("partial_indexes")?$v["partial"]:"");$Yd=(in_array($v["algorithm"],$Zd)?$v["algorithm"]:"");$O=array();ksort($v["columns"]);foreach($v["columns"]as$x=>$d){if($d!=""){$y=idx($v["lengths"],$x);$Yb=idx($v["descs"],$x);$O[]=($n[$d]?idf_escape($d):$d).($y?"(".(+$y).")":"").($Yb?" DESC":"");$e[]=$d;$Oe[]=($y?:null);$ac[]=$Yb;}}$Jc=$w[$B];if($Jc){ksort($Jc["columns"]);ksort($Jc["lengths"]);ksort($Jc["descs"]);if($v["type"]==$Jc["type"]&&array_values($Jc["columns"])===$e&&(!$Jc["lengths"]||array_values($Jc["lengths"])===$Oe)&&array_values($Jc["descs"])===$ac&&$Jc["partial"]==$ae&&(!$Zd||$Jc["algorithm"]==$Yd)){unset($w[$B]);continue;}}if($e)$b[]=array($v["type"],$B,$O,$Yd,$ae);}}foreach($w
as$B=>$Jc)$b[]=array($Jc["type"],$B,"DROP");if(!$b)redirect(ME."table=".urlencode($a));queries_redirect(ME."table=".urlencode($a),'Indexes have been altered.',alter_indexes($a,$b));}page_header('Indexes',$l,array("table"=>$a),h($a));$Xc=array_keys($n);if($_POST["add"]){foreach($K["indexes"]as$x=>$v){if($v["columns"][count($v["columns"])]!="")$K["indexes"][$x]["columns"][]="";}$v=end($K["indexes"]);if($v["type"]||array_filter($v["columns"],'strlen'))$K["indexes"][]=array("columns"=>array(1=>""));}if(!$K){foreach($w
as$x=>$v){$w[$x]["name"]=$x;$w[$x]["columns"][]="";}$w[]=array("columns"=>array(1=>""));$K["indexes"]=$w;}$Oe=(JUSH=="sql"||JUSH=="mssql");$ai=($_POST?$_POST["options"]:get_setting("index_options"));echo'
<form action="" method="post">
<div class="scrollable">
<table class="nowrap">
<thead><tr>
<th id="label-type">Index Type
';$Sd=" class='idxopts".($ai?"":" hidden")."'";if($Zd)echo"<th id='label-algorithm'$Sd>".'Algorithm'.doc_link(array('sql'=>'create-index.html#create-index-storage-engine-index-types','mariadb'=>'storage-engine-index-types/','pgsql'=>'indexes-types.html',));echo'<th><input type="submit" class="wayoff">','Columns'.($Oe?"<span$Sd> (".'length'.")</span>":"");if($Oe||support("descidx"))echo
checkbox("options",1,$ai,'Options',"indexOptionsShow(this.checked)","jsonly")."\n";echo'<th id="label-name">Name
';if(support("partial_indexes"))echo"<th id='label-condition'$Sd>".'Condition';echo'<th><noscript>',icon("plus","add[0]","+",'Add next'),'</noscript>
</thead>
';if($G){echo"<tr><td>PRIMARY<td>";foreach($G["columns"]as$x=>$d)echo
select_input(" disabled",$Xc,$d),"<label><input disabled type='checkbox'>".'descending'."</label> ";echo"<td><td>\n";}$ye=1;foreach($K["indexes"]as$v){if(!$_POST["drop_col"]||$ye!=key($_POST["drop_col"])){echo"<tr><td>".html_select("indexes[$ye][type]",array(-1=>"")+$ce,$v["type"],($ye==count($K["indexes"])?"indexesAddRow.call(this);":""),"label-type");if($Zd)echo"<td$Sd>".html_select("indexes[$ye][algorithm]",array_merge(array(""),$Zd),$v['algorithm'],"label-algorithm");echo"<td>";ksort($v["columns"]);$s=1;foreach($v["columns"]as$x=>$d){echo"<span>".select_input(" name='indexes[$ye][columns][$s]' title='".'Column'."'",($n&&($d==""||$n[$d])?array_combine($Xc,$Xc):array()),$d,"partial(".($s==count($v["columns"])?"indexesAddColumn":"indexesChangeColumn").", '".js_escape(JUSH=="sql"?"":$_GET["indexes"]."_")."')"),"<span$Sd>",($Oe?"<input type='number' name='indexes[$ye][lengths][$s]' class='size' value='".h(idx($v["lengths"],$x))."' title='".'Length'."'>":""),(support("descidx")?checkbox("indexes[$ye][descs][$s]",1,idx($v["descs"],$x),'descending'):""),"</span> </span>";$s++;}echo"<td><input name='indexes[$ye][name]' value='".h($v["name"])."' autocapitalize='off' aria-labelledby='label-name'>\n";if(support("partial_indexes"))echo"<td$Sd><input name='indexes[$ye][partial]' value='".h($v["partial"])."' autocapitalize='off' aria-labelledby='label-condition'>\n";echo"<td>".icon("cross","drop_col[$ye]","x",'Remove').script("qsl('button').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");}$ye++;}echo'</table>
</div>
<p>
<input type="submit" value="Save">
',input_token(),'</form>
';}elseif(isset($_GET["database"])){$K=$_POST;if($_POST&&!$l&&!$_POST["add"]){$B=trim($K["name"]);if($_POST["drop"]){$_GET["db"]="";queries_redirect(remove_from_uri("db|database"),'Database has been dropped.',drop_databases(array(DB)));}elseif(DB!==$B){if(DB!=""){$_GET["db"]=$B;queries_redirect(preg_replace('~\bdb=[^&]*&~','',ME)."db=".urlencode($B),'Database has been renamed.',rename_database($B,$K["collation"]));}else{$i=explode("\n",str_replace("\r","",$B));$ti=true;$Ie="";foreach($i
as$j){if(count($i)==1||$j!=""){if(!create_database($j,$K["collation"]))$ti=false;$Ie=$j;}}restart_session();set_session("dbs",null);queries_redirect(ME."db=".urlencode($Ie),'Database has been created.',$ti);}}else{if(!$K["collation"])redirect(substr(ME,0,-1));query_redirect("ALTER DATABASE ".idf_escape($B).(preg_match('~^[a-z0-9_]+$~i',$K["collation"])?" COLLATE $K[collation]":""),substr(ME,0,-1),'Database has been altered.');}}page_header(DB!=""?'Alter database':'Create database',$l,array(),h(DB));$jb=collations();$B=DB;if($_POST)$B=$K["name"];elseif(DB!="")$K["collation"]=db_collation(DB,$jb);elseif(JUSH=="sql"){foreach(get_vals("SHOW GRANTS")as$td){if(preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~',$td,$A)&&$A[1]){$B=stripcslashes(idf_unescape("`$A[2]`"));break;}}}echo'
<form action="" method="post">
<p>
',($_POST["add"]||strpos($B,"\n")?'<textarea autofocus name="name" rows="10" cols="40">'.h($B).'</textarea><br>':'<input name="name" autofocus value="'.h($B).'" data-maxlength="64" autocapitalize="off">')."\n".($jb?html_select("collation",array(""=>"(".'collation'.")")+$jb,$K["collation"]).doc_link(array('sql'=>"charset-charsets.html",'mariadb'=>"supported-character-sets-and-collations/",'mssql'=>"relational-databases/system-functions/sys-fn-helpcollations-transact-sql",)):""),'<input type="submit" value="Save">
';if(DB!="")echo"<input type='submit' name='drop' value='".'Drop'."'>".confirm(sprintf('Drop %s?',DB))."\n";elseif(!$_POST["add"]&&$_GET["db"]=="")echo
icon("plus","add[0]","+",'Add next')."\n";echo
input_token(),'</form>
';}elseif(isset($_GET["scheme"])){$K=$_POST;if($_POST&&!$l){$_=preg_replace('~ns=[^&]*&~','',ME)."ns=";if($_POST["drop"])query_redirect("DROP SCHEMA ".idf_escape($_GET["ns"]),$_,'Schema has been dropped.');else{$B=trim($K["name"]);$_
.=urlencode($B);if($_GET["ns"]=="")query_redirect("CREATE SCHEMA ".idf_escape($B),$_,'Schema has been created.');elseif($_GET["ns"]!=$B)query_redirect("ALTER SCHEMA ".idf_escape($_GET["ns"])." RENAME TO ".idf_escape($B),$_,'Schema has been altered.');else
redirect($_);}}page_header($_GET["ns"]!=""?'Alter schema':'Create schema',$l);if(!$K)$K["name"]=$_GET["ns"];echo'
<form action="" method="post">
<p><input name="name" autofocus value="',h($K["name"]),'" autocapitalize="off">
<input type="submit" value="Save">
';if($_GET["ns"]!="")echo"<input type='submit' name='drop' value='".'Drop'."'>".confirm(sprintf('Drop %s?',$_GET["ns"]))."\n";echo
input_token(),'</form>
';}elseif(isset($_GET["call"])){$ba=($_GET["name"]?:$_GET["call"]);page_header('Call'.": ".h($ba),$l);$_h=routine($_GET["call"],(isset($_GET["callf"])?"FUNCTION":"PROCEDURE"));$Vd=array();$qg=array();foreach($_h["fields"]as$s=>$m){if(substr($m["inout"],-3)=="OUT"&&JUSH=='sql')$qg[$s]="@".idf_escape($m["field"])." AS ".idf_escape($m["field"]);if(!$m["inout"]||substr($m["inout"],0,2)=="IN")$Vd[]=$s;}if(!$l&&$_POST){$Sa=array();foreach($_h["fields"]as$x=>$m){$X="";if(in_array($x,$Vd)){$X=process_input($m);if($X===false)$X="''";if(isset($qg[$x]))connection()->query("SET @".idf_escape($m["field"])." = $X");}if(isset($qg[$x]))$Sa[]="@".idf_escape($m["field"]);elseif(in_array($x,$Vd))$Sa[]=$X;}$H=(isset($_GET["callf"])?"SELECT ":"CALL ").(idx($_h["returns"],"type")=="record"?"* FROM ":"").table($ba)."(".implode(", ",$Sa).")";$oi=microtime(true);$I=connection()->multi_query($H);$oa=connection()->affected_rows;echo
adminer()->selectQuery($H,$oi,!$I);if(!$I)echo"<p class='error'>".error()."\n";else{$g=connect();if($g)$g->select_db(DB);do{$I=connection()->store_result();if(is_object($I))print_select_result($I,$g);else
echo"<p class='message'>".lang_format(array('Routine has been called, %d row affected.','Routine has been called, %d rows affected.'),$oa)." <span class='time'>".@date("H:i:s")."</span>\n";}while(connection()->next_result());if($qg)print_select_result(connection()->query("SELECT ".implode(", ",$qg)));}}echo'
<form action="" method="post">
';if($Vd){echo"<table class='layout'>\n";foreach($Vd
as$x){$m=$_h["fields"][$x];$B=$m["field"];echo"<tr><th>".adminer()->fieldName($m);$Y=idx($_POST["fields"],$B);if($Y!=""){if($m["type"]=="set")$Y=implode(",",$Y);}input($m,$Y,idx($_POST["function"],$B,""));echo"\n";}echo"</table>\n";}echo'<p>
<input type="submit" value="Call">
',input_token(),'</form>

<pre>
';function
pre_tr($Dh){return
preg_replace('~^~m','<tr>',preg_replace('~\|~','<td>',preg_replace('~\|$~m',"",rtrim($Dh))));}$R='(\+--[-+]+\+\n)';$K='(\| .* \|\n)';echo
preg_replace_callback("~^$R?$K$R?($K*)$R?~m",function($A){$bd=pre_tr($A[2]);return"<table>\n".($A[1]?"<thead>$bd</thead>\n":$bd).pre_tr($A[4])."\n</table>";},preg_replace('~(\n(    -|mysql)&gt; )(.+)~',"\\1<code class='jush-sql'>\\3</code>",preg_replace('~(.+)\n---+\n~',"<b>\\1</b>\n",h($_h['comment']))));echo'</pre>
';}elseif(isset($_GET["foreign"])){$a=$_GET["foreign"];$B=$_GET["name"];$K=$_POST;if($_POST&&!$l&&!$_POST["add"]&&!$_POST["change"]&&!$_POST["change-js"]){if(!$_POST["drop"]){$K["source"]=array_filter($K["source"],'strlen');ksort($K["source"]);$Ii=array();foreach($K["source"]as$x=>$X)$Ii[$x]=$K["target"][$x];$K["target"]=$Ii;}if(JUSH=="sqlite")$I=recreate_table($a,$a,array(),array(),array(" $B"=>($K["drop"]?"":" ".format_foreign_key($K))));else{$b="ALTER TABLE ".table($a);$I=($B==""||queries("$b DROP ".(JUSH=="sql"?"FOREIGN KEY ":"CONSTRAINT ").idf_escape($B)));if(!$K["drop"])$I=queries("$b ADD".format_foreign_key($K));}queries_redirect(ME."table=".urlencode($a),($K["drop"]?'Foreign key has been dropped.':($B!=""?'Foreign key has been altered.':'Foreign key has been created.')),$I);if(!$K["drop"])$l='Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.';}page_header('Foreign key',$l,array("table"=>$a),h($a));if($_POST){ksort($K["source"]);if($_POST["add"])$K["source"][]="";elseif($_POST["change"]||$_POST["change-js"])$K["target"]=array();}elseif($B!=""){$kd=foreign_keys($a);$K=$kd[$B];$K["source"][]="";}else{$K["table"]=$a;$K["source"]=array("");}echo'
<form action="" method="post">
';$fi=array_keys(fields($a));if($K["db"]!="")connection()->select_db($K["db"]);if($K["ns"]!=""){$mg=get_schema();set_schema($K["ns"]);}$lh=array_keys(array_filter(table_status('',true),'Adminer\fk_support'));$Ii=array_keys(fields(in_array($K["table"],$lh)?$K["table"]:reset($lh)));$Wf="this.form['change-js'].value = '1'; this.form.submit();";echo"<p><label>".'Target table'.": ".html_select("table",$lh,$K["table"],$Wf)."</label>\n";if(support("scheme")){$Gh=array_filter(adminer()->schemas(),function($Fh){return!preg_match('~^information_schema$~i',$Fh);});echo"<label>".'Schema'.": ".html_select("ns",$Gh,$K["ns"]!=""?$K["ns"]:$_GET["ns"],$Wf)."</label>";if($K["ns"]!="")set_schema($mg);}elseif(JUSH!="sqlite"){$Qb=array();foreach(adminer()->databases()as$j){if(!information_schema($j))$Qb[]=$j;}echo"<label>".'DB'.": ".html_select("db",$Qb,$K["db"]!=""?$K["db"]:$_GET["db"],$Wf)."</label>";}echo
input_hidden("change-js"),'<noscript><p><input type="submit" name="change" value="Change"></noscript>
<table>
<thead><tr><th id="label-source">Source<th id="label-target">Target</thead>
';$ye=0;foreach($K["source"]as$x=>$X){echo"<tr>","<td>".html_select("source[".(+$x)."]",array(-1=>"")+$fi,$X,($ye==count($K["source"])-1?"foreignAddRow.call(this);":""),"label-source"),"<td>".html_select("target[".(+$x)."]",$Ii,idx($K["target"],$x),"","label-target");$ye++;}echo'</table>
<p>
<label>ON DELETE: ',html_select("on_delete",array(-1=>"")+explode("|",driver()->onActions),$K["on_delete"]),'</label>
<label>ON UPDATE: ',html_select("on_update",array(-1=>"")+explode("|",driver()->onActions),$K["on_update"]),'</label>
',(DRIVER==='pgsql'?html_select("deferrable",array('NOT DEFERRABLE','DEFERRABLE','DEFERRABLE INITIALLY DEFERRED'),$K["deferrable"]).' ':''),doc_link(array('sql'=>"innodb-foreign-key-constraints.html",'mariadb'=>"foreign-keys/",'pgsql'=>"sql-createtable.html#SQL-CREATETABLE-PARMS-REFERENCES",'mssql'=>"t-sql/statements/create-table-transact-sql",'oracle'=>"SQLRF01111",)),'<p>
<input type="submit" value="Save">
<noscript><p><input type="submit" name="add" value="Add column"></noscript>
';if($B!="")echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$B));echo
input_token(),'</form>
';}elseif(isset($_GET["view"])){$a=$_GET["view"];$K=$_POST;$ng="VIEW";if(JUSH=="pgsql"&&$a!=""){$P=table_status1($a);$ng=strtoupper($P["Engine"]);}if($_POST&&!$l){$B=trim($K["name"]);$wa=" AS\n$K[select]";$Se=ME."table=".urlencode($B);$mf='View has been altered.';$U=($_POST["materialized"]?"MATERIALIZED VIEW":"VIEW");if(!$_POST["drop"]&&$a==$B&&JUSH!="sqlite"&&$U=="VIEW"&&$ng=="VIEW")query_redirect((JUSH=="mssql"?"ALTER":"CREATE OR REPLACE")." VIEW ".table($B).$wa,$Se,$mf);else{$Ki=$B."_adminer_".uniqid();drop_create("DROP $ng ".table($a),"CREATE $U ".table($B).$wa,"DROP $U ".table($B),"CREATE $U ".table($Ki).$wa,"DROP $U ".table($Ki),($_POST["drop"]?substr(ME,0,-1):$Se),'View has been dropped.',$mf,'View has been created.',$a,$B);}}if(!$_POST&&$a!=""){$K=view($a);$K["name"]=$a;$K["materialized"]=($ng!="VIEW");if(!$l)$l=error();}page_header(($a!=""?'Alter view':'Create view'),$l,array("table"=>$a),h($a));echo'
<form action="" method="post">
<p>Name: <input name="name" value="',h($K["name"]),'" data-maxlength="64" autocapitalize="off">
',(support("materializedview")?" ".checkbox("materialized",1,$K["materialized"],'Materialized view'):""),'<p>';textarea("select",$K["select"]);echo'<p>
<input type="submit" value="Save">
';if($a!="")echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$a));echo
input_token(),'</form>
';}elseif(isset($_GET["event"])){$aa=$_GET["event"];$pe=array("YEAR","QUARTER","MONTH","DAY","HOUR","MINUTE","WEEK","SECOND","YEAR_MONTH","DAY_HOUR","DAY_MINUTE","DAY_SECOND","HOUR_MINUTE","HOUR_SECOND","MINUTE_SECOND");$pi=array("ENABLED"=>"ENABLE","DISABLED"=>"DISABLE","SLAVESIDE_DISABLED"=>"DISABLE ON SLAVE");$K=$_POST;if($_POST&&!$l){if($_POST["drop"])query_redirect("DROP EVENT ".idf_escape($aa),substr(ME,0,-1),'Event has been dropped.');elseif(in_array($K["INTERVAL_FIELD"],$pe)&&isset($pi[$K["STATUS"]])){$Eh="\nON SCHEDULE ".($K["INTERVAL_VALUE"]?"EVERY ".q($K["INTERVAL_VALUE"])." $K[INTERVAL_FIELD]".($K["STARTS"]?" STARTS ".q($K["STARTS"]):"").($K["ENDS"]?" ENDS ".q($K["ENDS"]):""):"AT ".q($K["STARTS"]))." ON COMPLETION".($K["ON_COMPLETION"]?"":" NOT")." PRESERVE";queries_redirect(substr(ME,0,-1),($aa!=""?'Event has been altered.':'Event has been created.'),queries(($aa!=""?"ALTER EVENT ".idf_escape($aa).$Eh.($aa!=$K["EVENT_NAME"]?"\nRENAME TO ".idf_escape($K["EVENT_NAME"]):""):"CREATE EVENT ".idf_escape($K["EVENT_NAME"]).$Eh)."\n".$pi[$K["STATUS"]]." COMMENT ".q($K["EVENT_COMMENT"]).rtrim(" DO\n$K[EVENT_DEFINITION]",";").";"));}}page_header(($aa!=""?'Alter event'.": ".h($aa):'Create event'),$l);if(!$K&&$aa!=""){$L=get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = ".q(DB)." AND EVENT_NAME = ".q($aa));$K=reset($L);}echo'
<form action="" method="post">
<table class="layout">
<tr><th>Name<td><input name="EVENT_NAME" value="',h($K["EVENT_NAME"]),'" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">Start<td><input name="STARTS" value="',h("$K[EXECUTE_AT]$K[STARTS]"),'">
<tr><th title="datetime">End<td><input name="ENDS" value="',h($K["ENDS"]),'">
<tr><th>Every<td><input type="number" name="INTERVAL_VALUE" value="',h($K["INTERVAL_VALUE"]),'" class="size"> ',html_select("INTERVAL_FIELD",$pe,$K["INTERVAL_FIELD"]),'<tr><th>Status<td>',html_select("STATUS",$pi,$K["STATUS"]),'<tr><th>Comment<td><input name="EVENT_COMMENT" value="',h($K["EVENT_COMMENT"]),'" data-maxlength="64">
<tr><th><td>',checkbox("ON_COMPLETION","PRESERVE",$K["ON_COMPLETION"]=="PRESERVE",'On completion preserve'),'</table>
<p>';textarea("EVENT_DEFINITION",$K["EVENT_DEFINITION"]);echo'<p>
<input type="submit" value="Save">
';if($aa!="")echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$aa));echo
input_token(),'</form>
';}elseif(isset($_GET["procedure"])){$ba=($_GET["name"]?:$_GET["procedure"]);$_h=(isset($_GET["function"])?"FUNCTION":"PROCEDURE");$K=$_POST;$K["fields"]=(array)$K["fields"];if($_POST&&!process_fields($K["fields"])&&!$l){$jg=routine($_GET["procedure"],$_h);$Ki="$K[name]_adminer_".uniqid();foreach($K["fields"]as$x=>$m){if($m["field"]=="")unset($K["fields"][$x]);}drop_create("DROP $_h ".routine_id($ba,$jg),create_routine($_h,$K),"DROP $_h ".routine_id($K["name"],$K),create_routine($_h,array("name"=>$Ki)+$K),"DROP $_h ".routine_id($Ki,$K),substr(ME,0,-1),'Routine has been dropped.','Routine has been altered.','Routine has been created.',$ba,$K["name"]);}page_header(($ba!=""?(isset($_GET["function"])?'Alter function':'Alter procedure').": ".h($ba):(isset($_GET["function"])?'Create function':'Create procedure')),$l);if(!$_POST){if($ba=="")$K["language"]="sql";else{$K=routine($_GET["procedure"],$_h);$K["name"]=$ba;}}$jb=get_vals("SHOW CHARACTER SET");sort($jb);$Ah=routine_languages();echo($jb?"<datalist id='collations'>".optionlist($jb)."</datalist>":""),'
<form action="" method="post" id="form">
<p>Name: <input name="name" value="',h($K["name"]),'" data-maxlength="64" autocapitalize="off">
',($Ah?"<label>".'Language'.": ".html_select("language",$Ah,$K["language"])."</label>\n":""),'<input type="submit" value="Save">
<div class="scrollable">
<table class="nowrap">
';edit_fields($K["fields"],$jb,$_h);if(isset($_GET["function"])){echo"<tr><td>".'Return type';edit_type("returns",(array)$K["returns"],$jb,array(),(JUSH=="pgsql"?array("void","trigger"):array()));}echo'</table>
',script("editFields();"),'</div>
<p>';textarea("definition",$K["definition"],20);echo'<p>
<input type="submit" value="Save">
';if($ba!="")echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$ba));echo
input_token(),'</form>
';}elseif(isset($_GET["sequence"])){$da=$_GET["sequence"];$K=$_POST;if($_POST&&!$l){$_=substr(ME,0,-1);$B=trim($K["name"]);if($_POST["drop"])query_redirect("DROP SEQUENCE ".idf_escape($da),$_,'Sequence has been dropped.');elseif($da=="")query_redirect("CREATE SEQUENCE ".idf_escape($B),$_,'Sequence has been created.');elseif($da!=$B)query_redirect("ALTER SEQUENCE ".idf_escape($da)." RENAME TO ".idf_escape($B),$_,'Sequence has been altered.');else
redirect($_);}page_header($da!=""?'Alter sequence'.": ".h($da):'Create sequence',$l);if(!$K)$K["name"]=$da;echo'
<form action="" method="post">
<p><input name="name" value="',h($K["name"]),'" autocapitalize="off">
<input type="submit" value="Save">
';if($da!="")echo"<input type='submit' name='drop' value='".'Drop'."'>".confirm(sprintf('Drop %s?',$da))."\n";echo
input_token(),'</form>
';}elseif(isset($_GET["type"])){$ea=$_GET["type"];$K=$_POST;if($_POST&&!$l){$_=substr(ME,0,-1);if($_POST["drop"])query_redirect("DROP TYPE ".idf_escape($ea),$_,'Type has been dropped.');else
query_redirect("CREATE TYPE ".idf_escape(trim($K["name"]))." $K[as]",$_,'Type has been created.');}page_header($ea!=""?'Alter type'.": ".h($ea):'Create type',$l);if(!$K)$K["as"]="AS ";echo'
<form action="" method="post">
<p>
';if($ea!=""){$nj=driver()->types();$Ac=type_values($nj[$ea]);if($Ac)echo"<code class='jush-".JUSH."'>ENUM (".h($Ac).")</code>\n<p>";echo"<input type='submit' name='drop' value='".'Drop'."'>".confirm(sprintf('Drop %s?',$ea))."\n";}else{echo'Name'.": <input name='name' value='".h($K['name'])."' autocapitalize='off'>\n",doc_link(array('pgsql'=>"datatype-enum.html",),"?");textarea("as",$K["as"]);echo"<p><input type='submit' value='".'Save'."'>\n";}echo
input_token(),'</form>
';}elseif(isset($_GET["check"])){$a=$_GET["check"];$B=$_GET["name"];$K=$_POST;if($K&&!$l){if(JUSH=="sqlite")$I=recreate_table($a,$a,array(),array(),array(),"",array(),"$B",($K["drop"]?"":$K["clause"]));else{$I=($B==""||queries("ALTER TABLE ".table($a)." DROP CONSTRAINT ".idf_escape($B)));if(!$K["drop"])$I=queries("ALTER TABLE ".table($a)." ADD".($K["name"]!=""?" CONSTRAINT ".idf_escape($K["name"]):"")." CHECK ($K[clause])");}queries_redirect(ME."table=".urlencode($a),($K["drop"]?'Check has been dropped.':($B!=""?'Check has been altered.':'Check has been created.')),$I);}page_header(($B!=""?'Alter check'.": ".h($B):'Create check'),$l,array("table"=>$a));if(!$K){$ab=driver()->checkConstraints($a);$K=array("name"=>$B,"clause"=>$ab[$B]);}echo'
<form action="" method="post">
<p>';if(JUSH!="sqlite")echo'Name'.': <input name="name" value="'.h($K["name"]).'" data-maxlength="64" autocapitalize="off"> ';echo
doc_link(array('sql'=>"create-table-check-constraints.html",'mariadb'=>"constraint/",'pgsql'=>"ddl-constraints.html#DDL-CONSTRAINTS-CHECK-CONSTRAINTS",'mssql'=>"relational-databases/tables/create-check-constraints",'sqlite'=>"lang_createtable.html#check_constraints",),"?"),'<p>';textarea("clause",$K["clause"]);echo'<p><input type="submit" value="Save">
';if($B!="")echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$B));echo
input_token(),'</form>
';}elseif(isset($_GET["trigger"])){$a=$_GET["trigger"];$B="$_GET[name]";$jj=trigger_options();$K=(array)trigger($B,$a)+array("Trigger"=>$a."_bi");if($_POST){if(!$l&&in_array($_POST["Timing"],$jj["Timing"])&&in_array($_POST["Event"],$jj["Event"])&&in_array($_POST["Type"],$jj["Type"])){$Tf=" ON ".table($a);$hc="DROP TRIGGER ".idf_escape($B).(JUSH=="pgsql"?$Tf:"");$Se=ME."table=".urlencode($a);if($_POST["drop"])query_redirect($hc,$Se,'Trigger has been dropped.');else{if($B!="")queries($hc);queries_redirect($Se,($B!=""?'Trigger has been altered.':'Trigger has been created.'),queries(create_trigger($Tf,$_POST)));if($B!="")queries(create_trigger($Tf,$K+array("Type"=>reset($jj["Type"]))));}}$K=$_POST;}page_header(($B!=""?'Alter trigger'.": ".h($B):'Create trigger'),$l,array("table"=>$a));echo'
<form action="" method="post" id="form">
<table class="layout">
<tr><th>Time<td>',html_select("Timing",$jj["Timing"],$K["Timing"],"triggerChange(/^".preg_quote($a,"/")."_[ba][iud]$/, '".js_escape($a)."', this.form);"),'<tr><th>Event<td>',html_select("Event",$jj["Event"],$K["Event"],"this.form['Timing'].onchange();"),(in_array("UPDATE OF",$jj["Event"])?" <input name='Of' value='".h($K["Of"])."' class='hidden'>":""),'<tr><th>Type<td>',html_select("Type",$jj["Type"],$K["Type"]),'</table>
<p>Name: <input name="Trigger" value="',h($K["Trigger"]),'" data-maxlength="64" autocapitalize="off">
',script("qs('#form')['Timing'].onchange();"),'<p>';textarea("Statement",$K["Statement"]);echo'<p>
<input type="submit" value="Save">
';if($B!="")echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$B));echo
input_token(),'</form>
';}elseif(isset($_GET["user"])){$fa=$_GET["user"];$ah=array(""=>array("All privileges"=>""));foreach(get_rows("SHOW PRIVILEGES")as$K){foreach(explode(",",($K["Privilege"]=="Grant option"?"":$K["Context"]))as$_b)$ah[$_b][$K["Privilege"]]=$K["Comment"];}$ah["Server Admin"]+=$ah["File access on server"];$ah["Databases"]["Create routine"]=$ah["Procedures"]["Create routine"];unset($ah["Procedures"]["Create routine"]);$ah["Columns"]=array();foreach(array("Select","Insert","Update","References")as$X)$ah["Columns"][$X]=$ah["Tables"][$X];unset($ah["Server Admin"]["Usage"]);foreach($ah["Tables"]as$x=>$X)unset($ah["Databases"][$x]);$Bf=array();if($_POST){foreach($_POST["objects"]as$x=>$X)$Bf[$X]=(array)$Bf[$X]+idx($_POST["grants"],$x,array());}$ud=array();$Rf="";if(isset($_GET["host"])&&($I=connection()->query("SHOW GRANTS FOR ".q($fa)."@".q($_GET["host"])))){while($K=$I->fetch_row()){if(preg_match('~GRANT (.*) ON (.*) TO ~',$K[0],$A)&&preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~',$A[1],$Ze,PREG_SET_ORDER)){foreach($Ze
as$X){if($X[1]!="USAGE")$ud["$A[2]$X[2]"][$X[1]]=true;if(preg_match('~ WITH GRANT OPTION~',$K[0]))$ud["$A[2]$X[2]"]["GRANT OPTION"]=true;}}if(preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~",$K[0],$A))$Rf=$A[1];}}if($_POST&&!$l){$Sf=(isset($_GET["host"])?q($fa)."@".q($_GET["host"]):"''");if($_POST["drop"])query_redirect("DROP USER $Sf",ME."privileges=",'User has been dropped.');else{$Df=q($_POST["user"])."@".q($_POST["host"]);$Fg=$_POST["pass"];if($Fg!=''&&!$_POST["hashed"]&&!min_version(8)){$Fg=get_val("SELECT PASSWORD(".q($Fg).")");$l=!$Fg;}$Eb=false;if(!$l){if($Sf!=$Df){$Eb=queries((min_version(5)?"CREATE USER":"GRANT USAGE ON *.* TO")." $Df IDENTIFIED BY ".(min_version(8)?"":"PASSWORD ").q($Fg));$l=!$Eb;}elseif($Fg!=$Rf)queries("SET PASSWORD FOR $Df = ".q($Fg));}if(!$l){$xh=array();foreach($Bf
as$Lf=>$td){if(isset($_GET["grant"]))$td=array_filter($td);$td=array_keys($td);if(isset($_GET["grant"]))$xh=array_diff(array_keys(array_filter($Bf[$Lf],'strlen')),$td);elseif($Sf==$Df){$Pf=array_keys((array)$ud[$Lf]);$xh=array_diff($Pf,$td);$td=array_diff($td,$Pf);unset($ud[$Lf]);}if(preg_match('~^(.+)\s*(\(.*\))?$~U',$Lf,$A)&&(!grant("REVOKE",$xh,$A[2]," ON $A[1] FROM $Df")||!grant("GRANT",$td,$A[2]," ON $A[1] TO $Df"))){$l=true;break;}}}if(!$l&&isset($_GET["host"])){if($Sf!=$Df)queries("DROP USER $Sf");elseif(!isset($_GET["grant"])){foreach($ud
as$Lf=>$xh){if(preg_match('~^(.+)(\(.*\))?$~U',$Lf,$A))grant("REVOKE",array_keys($xh),$A[2]," ON $A[1] FROM $Df");}}}queries_redirect(ME."privileges=",(isset($_GET["host"])?'User has been altered.':'User has been created.'),!$l);if($Eb)connection()->query("DROP USER $Df");}}page_header((isset($_GET["host"])?'Username'.": ".h("$fa@$_GET[host]"):'Create user'),$l,array("privileges"=>array('','Privileges')));$K=$_POST;if($K)$ud=$Bf;else{$K=$_GET+array("host"=>get_val("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)"));$K["pass"]=$Rf;if($Rf!="")$K["hashed"]=true;$ud[(DB==""||$ud?"":idf_escape(addcslashes(DB,"%_\\"))).".*"]=array();}echo'<form action="" method="post">
<table class="layout">
<tr><th>Server<td><input name="host" data-maxlength="60" value="',h($K["host"]),'" autocapitalize="off">
<tr><th>Username<td><input name="user" data-maxlength="80" value="',h($K["user"]),'" autocapitalize="off">
<tr><th>Password<td><input name="pass" id="pass" value="',h($K["pass"]),'" autocomplete="new-password">
',($K["hashed"]?"":script("typePassword(qs('#pass'));")),(min_version(8)?"":checkbox("hashed",1,$K["hashed"],'Hashed',"typePassword(this.form['pass'], this.checked);")),'</table>

',"<table class='odds'>\n","<thead><tr><th colspan='2'>".'Privileges'.doc_link(array('sql'=>"grant.html#priv_level"));$s=0;foreach($ud
as$Lf=>$td){echo'<th>'.($Lf!="*.*"?"<input name='objects[$s]' value='".h($Lf)."' size='10' autocapitalize='off'>":input_hidden("objects[$s]","*.*")."*.*");$s++;}echo"</thead>\n";foreach(array(""=>"","Server Admin"=>'Server',"Databases"=>'Database',"Tables"=>'Table',"Columns"=>'Column',"Procedures"=>'Routine',)as$_b=>$Yb){foreach((array)$ah[$_b]as$Zg=>$ob){echo"<tr><td".($Yb?">$Yb<td":" colspan='2'").' lang="en" title="'.h($ob).'">'.h($Zg);$s=0;foreach($ud
as$Lf=>$td){$B="'grants[$s][".h(strtoupper($Zg))."]'";$Y=$td[strtoupper($Zg)];if($_b=="Server Admin"&&$Lf!=(isset($ud["*.*"])?"*.*":".*"))echo"<td>";elseif(isset($_GET["grant"]))echo"<td><select name=$B><option><option value='1'".($Y?" selected":"").">".'Grant'."<option value='0'".($Y=="0"?" selected":"").">".'Revoke'."</select>";else
echo"<td align='center'><label class='block'>","<input type='checkbox' name=$B value='1'".($Y?" checked":"").($Zg=="All privileges"?" id='grants-$s-all'>":">".($Zg=="Grant option"?"":script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$s-all'); };"))),"</label>";$s++;}}}echo"</table>\n",'<p>
<input type="submit" value="Save">
';if(isset($_GET["host"]))echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',"$fa@$_GET[host]"));echo
input_token(),'</form>
';}elseif(isset($_GET["processlist"])){if(support("kill")){if($_POST&&!$l){$Ee=0;foreach((array)$_POST["kill"]as$X){if(adminer()->killProcess($X))$Ee++;}queries_redirect(ME."processlist=",lang_format(array('%d process has been killed.','%d processes have been killed.'),$Ee),$Ee||!$_POST["kill"]);}}page_header('Process list',$l);echo'
<form action="" method="post">
<div class="scrollable">
<table class="nowrap checkable odds">
',script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");$s=-1;foreach(adminer()->processList()as$s=>$K){if(!$s){echo"<thead><tr lang='en'>".(support("kill")?"<th>":"");foreach($K
as$x=>$X)echo"<th>$x".doc_link(array('sql'=>"show-processlist.html#processlist_".strtolower($x),'pgsql'=>"monitoring-stats.html#PG-STAT-ACTIVITY-VIEW",'oracle'=>"REFRN30223",));echo"</thead>\n";}echo"<tr>".(support("kill")?"<td>".checkbox("kill[]",$K[JUSH=="sql"?"Id":"pid"],0):"");foreach($K
as$x=>$X)echo"<td>".((JUSH=="sql"&&$x=="Info"&&preg_match("~Query|Killed~",$K["Command"])&&$X!="")||(JUSH=="pgsql"&&$x=="current_query"&&$X!="<IDLE>")||(JUSH=="oracle"&&$x=="sql_text"&&$X!="")?"<code class='jush-".JUSH."'>".shorten_utf8($X,100,"</code>").' <a href="'.h(ME.($K["db"]!=""?"db=".urlencode($K["db"])."&":"")."sql=".urlencode($X)).'">'.'Clone'.'</a>':h($X));echo"\n";}echo'</table>
</div>
<p>
';if(support("kill"))echo($s+1)."/".sprintf('%d in total',max_connections()),"<p><input type='submit' value='".'Kill'."'>\n";echo
input_token(),'</form>
',script("tableCheck();");}elseif(isset($_GET["select"])){$a=$_GET["select"];$S=table_status1($a);$w=indexes($a);$n=fields($a);$kd=column_foreign_keys($a);$Nf=$S["Oid"];$na=get_settings("adminer_import");$yh=array();$e=array();$Lh=array();$fg=array();$Oi="";foreach($n
as$x=>$m){$B=adminer()->fieldName($m);$_f=html_entity_decode(strip_tags($B),ENT_QUOTES);if(isset($m["privileges"]["select"])&&$B!=""){$e[$x]=$_f;if(is_shortable($m))$Oi=adminer()->selectLengthProcess();}if(isset($m["privileges"]["where"])&&$B!="")$Lh[$x]=$_f;if(isset($m["privileges"]["order"])&&$B!="")$fg[$x]=$_f;$yh+=$m["privileges"];}list($M,$vd)=adminer()->selectColumnsProcess($e,$w);$M=array_unique($M);$vd=array_unique($vd);$te=count($vd)<count($M);$Z=adminer()->selectSearchProcess($n,$w);$eg=adminer()->selectOrderProcess($n,$w);$z=adminer()->selectLimitProcess();if($_GET["val"]&&is_ajax()){header("Content-Type: text/plain; charset=utf-8");foreach($_GET["val"]as$sj=>$K){$wa=convert_field($n[key($K)]);$M=array($wa?:idf_escape(key($K)));$Z[]=where_check($sj,$n);$J=driver()->select($a,$M,$Z,$M);if($J)echo
first($J->fetch_row());}exit;}$G=$uj=array();foreach($w
as$v){if($v["type"]=="PRIMARY"){$G=array_flip($v["columns"]);$uj=($M?$G:array());foreach($uj
as$x=>$X){if(in_array(idf_escape($x),$M))unset($uj[$x]);}break;}}if($Nf&&!$G){$G=$uj=array($Nf=>0);$w[]=array("type"=>"PRIMARY","columns"=>array($Nf));}if($_POST&&!$l){$Uj=$Z;if(!$_POST["all"]&&is_array($_POST["check"])){$ab=array();foreach($_POST["check"]as$Wa)$ab[]=where_check($Wa,$n);$Uj[]="((".implode(") OR (",$ab)."))";}$Uj=($Uj?"\nWHERE ".implode(" AND ",$Uj):"");if($_POST["export"]){save_settings(array("output"=>$_POST["output"],"format"=>$_POST["format"]),"adminer_import");dump_headers($a);adminer()->dumpTable($a,"");$od=($M?implode(", ",$M):"*").convert_fields($e,$n,$M)."\nFROM ".table($a);$xd=($vd&&$te?"\nGROUP BY ".implode(", ",$vd):"").($eg?"\nORDER BY ".implode(", ",$eg):"");$H="SELECT $od$Uj$xd";if(is_array($_POST["check"])&&!$G){$qj=array();foreach($_POST["check"]as$X)$qj[]="(SELECT".limit($od,"\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$n).$xd,1).")";$H=implode(" UNION ALL ",$qj);}adminer()->dumpData($a,"table",$H);adminer()->dumpFooter();exit;}if(!adminer()->selectEmailProcess($Z,$kd)){if($_POST["save"]||$_POST["delete"]){$I=true;$oa=0;$O=array();if(!$_POST["delete"]){foreach($_POST["fields"]as$B=>$X){$X=process_input($n[$B]);if($X!==null&&($_POST["clone"]||$X!==false))$O[idf_escape($B)]=($X!==false?$X:idf_escape($B));}}if($_POST["delete"]||$O){$H=($_POST["clone"]?"INTO ".table($a)." (".implode(", ",array_keys($O)).")\nSELECT ".implode(", ",$O)."\nFROM ".table($a):"");if($_POST["all"]||($G&&is_array($_POST["check"]))||$te){$I=($_POST["delete"]?driver()->delete($a,$Uj):($_POST["clone"]?queries("INSERT $H$Uj".driver()->insertReturning($a)):driver()->update($a,$O,$Uj)));$oa=connection()->affected_rows;if(is_object($I))$oa+=$I->num_rows;}else{foreach((array)$_POST["check"]as$X){$Tj="\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$n);$I=($_POST["delete"]?driver()->delete($a,$Tj,1):($_POST["clone"]?queries("INSERT".limit1($a,$H,$Tj)):driver()->update($a,$O,$Tj,1)));if(!$I)break;$oa+=connection()->affected_rows;}}}$mf=lang_format(array('%d item has been affected.','%d items have been affected.'),$oa);if($_POST["clone"]&&$I&&$oa==1){$Je=last_id($I);if($Je)$mf=sprintf('Item%s has been inserted.'," $Je");}queries_redirect(remove_from_uri($_POST["all"]&&$_POST["delete"]?"page":""),$mf,$I);if(!$_POST["delete"]){$Rg=(array)$_POST["fields"];edit_form($a,array_intersect_key($n,$Rg),$Rg,!$_POST["clone"],$l);page_footer();exit;}}elseif(!$_POST["import"]){if(!$_POST["val"])$l='Ctrl+click on a value to modify it.';else{$I=true;$oa=0;foreach($_POST["val"]as$sj=>$K){$O=array();foreach($K
as$x=>$X){$x=bracket_escape($x,true);$O[idf_escape($x)]=(preg_match('~char|text~',$n[$x]["type"])||$X!=""?adminer()->processInput($n[$x],$X):"NULL");}$I=driver()->update($a,$O," WHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($sj,$n),($te||$G?0:1)," ");if(!$I)break;$oa+=connection()->affected_rows;}queries_redirect(remove_from_uri(),lang_format(array('%d item has been affected.','%d items have been affected.'),$oa),$I);}}elseif(!is_string($Yc=get_file("csv_file",true)))$l=upload_error($Yc);elseif(!preg_match('~~u',$Yc))$l='File must be in UTF-8 encoding.';else{save_settings(array("output"=>$na["output"],"format"=>$_POST["separator"]),"adminer_import");$I=true;$kb=array_keys($n);preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~',$Yc,$Ze);$oa=count($Ze[0]);driver()->begin();$Rh=($_POST["separator"]=="csv"?",":($_POST["separator"]=="tsv"?"\t":";"));$L=array();foreach($Ze[0]as$x=>$X){preg_match_all("~((?>\"[^\"]*\")+|[^$Rh]*)$Rh~",$X.$Rh,$af);if(!$x&&!array_diff($af[1],$kb)){$kb=$af[1];$oa--;}else{$O=array();foreach($af[1]as$s=>$hb)$O[idf_escape($kb[$s])]=($hb==""&&$n[$kb[$s]]["null"]?"NULL":q(preg_match('~^".*"$~s',$hb)?str_replace('""','"',substr($hb,1,-1)):$hb));$L[]=$O;}}$I=(!$L||driver()->insertUpdate($a,$L,$G));if($I)driver()->commit();queries_redirect(remove_from_uri("page"),lang_format(array('%d row has been imported.','%d rows have been imported.'),$oa),$I);driver()->rollback();}}}$_i=adminer()->tableName($S);if(is_ajax()){page_headers();ob_start();}else
page_header('Select'.": $_i",$l);$O=null;if(isset($yh["insert"])||!support("table")){$wg=array();foreach((array)$_GET["where"]as$X){if(isset($kd[$X["col"]])&&count($kd[$X["col"]])==1&&($X["op"]=="="||(!$X["op"]&&(is_array($X["val"])||!preg_match('~[_%]~',$X["val"])))))$wg["set"."[".bracket_escape($X["col"])."]"]=$X["val"];}$O=$wg?"&".http_build_query($wg):"";}adminer()->selectLinks($S,$O);if(!$e&&support("table"))echo"<p class='error'>".'Unable to select the table'.($n?".":": ".error())."\n";else{echo"<form action='' id='form'>\n","<div style='display: none;'>";hidden_fields_get();echo(DB!=""?input_hidden("db",DB).(isset($_GET["ns"])?input_hidden("ns",$_GET["ns"]):""):""),input_hidden("select",$a),"</div>\n";adminer()->selectColumnsPrint($M,$e);adminer()->selectSearchPrint($Z,$Lh,$w);adminer()->selectOrderPrint($eg,$fg,$w);adminer()->selectLimitPrint($z);adminer()->selectLengthPrint($Oi);adminer()->selectActionPrint($w);echo"</form>\n";$D=$_GET["page"];$nd=null;if($D=="last"){$nd=get_val(count_rows($a,$Z,$te,$vd));$D=floor(max(0,intval($nd)-1)/$z);}$Mh=$M;$wd=$vd;if(!$Mh){$Mh[]="*";$Ab=convert_fields($e,$n,$M);if($Ab)$Mh[]=substr($Ab,2);}foreach($M
as$x=>$X){$m=$n[idf_unescape($X)];if($m&&($wa=convert_field($m)))$Mh[$x]="$wa AS $X";}if(!$te&&$uj){foreach($uj
as$x=>$X){$Mh[]=idf_escape($x);if($wd)$wd[]=idf_escape($x);}}$I=driver()->select($a,$Mh,$Z,$wd,$eg,$z,$D,true);if(!$I)echo"<p class='error'>".error()."\n";else{if(JUSH=="mssql"&&$D)$I->seek($z*$D);$uc=array();echo"<form action='' method='post' enctype='multipart/form-data'>\n";$L=array();while($K=$I->fetch_assoc()){if($D&&JUSH=="oracle")unset($K["RNUM"]);$L[]=$K;}if($_GET["page"]!="last"&&$z&&$vd&&$te&&JUSH=="sql")$nd=get_val(" SELECT FOUND_ROWS()");if(!$L)echo"<p class='message'>".'No rows.'."\n";else{$Ea=adminer()->backwardKeys($a,$_i);echo"<div class='scrollable'>","<table id='table' class='nowrap checkable odds'>",script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"),"<thead><tr>".(!$vd&&$M?"":"<td><input type='checkbox' id='all-page' class='jsonly'>".script("qs('#all-page').onclick = partial(formCheck, /check/);","")." <a href='".h($_GET["modify"]?remove_from_uri("modify"):$_SERVER["REQUEST_URI"]."&modify=1")."'>".'Modify'."</a>");$Af=array();$qd=array();reset($M);$ih=1;foreach($L[0]as$x=>$X){if(!isset($uj[$x])){$X=idx($_GET["columns"],key($M))?:array();$m=$n[$M?($X?$X["col"]:current($M)):$x];$B=($m?adminer()->fieldName($m,$ih):($X["fun"]?"*":h($x)));if($B!=""){$ih++;$Af[$x]=$B;$d=idf_escape($x);$Md=remove_from_uri('(order|desc)[^=]*|page').'&order%5B0%5D='.urlencode($x);$Yb="&desc%5B0%5D=1";echo"<th id='th[".h(bracket_escape($x))."]'>".script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});","");$pd=apply_sql_function($X["fun"],$B);$ei=isset($m["privileges"]["order"])||$pd!=$B;echo($ei?"<a href='".h($Md.($eg[0]==$d||$eg[0]==$x?$Yb:''))."'>$pd</a>":$pd);$lf=($ei?"<a href='".h($Md.$Yb)."' title='".'descending'."' class='text'> â†“</a>":'');if(!$X["fun"]&&isset($m["privileges"]["where"])){$lf
.='<a href="#fieldset-search" title="'.'Search'.'" class="text jsonly"> =</a>';$lf
.=script("qsl('a').onclick = partial(selectSearch, '".js_escape($x)."');");}echo($lf?"<span class='column hidden'>$lf</span>":"");}$qd[$x]=$X["fun"];next($M);}}$Oe=array();if($_GET["modify"]){foreach($L
as$K){foreach($K
as$x=>$X)$Oe[$x]=max($Oe[$x],min(40,strlen(utf8_decode($X))));}}echo($Ea?"<th>".'Relations':"")."</thead>\n";if(is_ajax())ob_end_clean();foreach(adminer()->rowDescriptions($L,$kd)as$zf=>$K){$rj=unique_array($L[$zf],$w);if(!$rj){$rj=array();reset($M);foreach($L[$zf]as$x=>$X){if(!preg_match('~^(COUNT|AVG|GROUP_CONCAT|MAX|MIN|SUM)\(~',current($M)))$rj[$x]=$X;next($M);}}$sj="";foreach($rj
as$x=>$X){$m=(array)$n[$x];if((JUSH=="sql"||JUSH=="pgsql")&&preg_match('~char|text|enum|set~',$m["type"])&&strlen($X)>64){$x=(strpos($x,'(')?$x:idf_escape($x));$x="MD5(".(JUSH!='sql'||preg_match("~^utf8~",$m["collation"])?$x:"CONVERT($x USING ".charset(connection()).")").")";$X=md5($X);}$sj
.="&".($X!==null?urlencode("where[".bracket_escape($x)."]")."=".urlencode($X===false?"f":$X):"null%5B%5D=".urlencode($x));}echo"<tr>".(!$vd&&$M?"":"<td>".checkbox("check[]",substr($sj,1),in_array(substr($sj,1),(array)$_POST["check"])).($te||information_schema(DB)?"":" <a href='".h(ME."edit=".urlencode($a).$sj)."' class='edit'>".'edit'."</a>"));reset($M);foreach($K
as$x=>$X){if(isset($Af[$x])){$d=current($M);$m=(array)$n[$x];if($X!=""&&(!isset($uc[$x])||$uc[$x]!=""))$uc[$x]=(is_mail($X)?$Af[$x]:"");$_="";if(is_blob($m)&&$X!="")$_=ME.'download='.urlencode($a).'&field='.urlencode($x).$sj;if(!$_&&$X!==null){foreach((array)$kd[$x]as$p){if(count($kd[$x])==1||end($p["source"])==$x){$_="";foreach($p["source"]as$s=>$fi)$_
.=where_link($s,$p["target"][$s],$L[$zf][$fi]);$_=($p["db"]!=""?preg_replace('~([?&]db=)[^&]+~','\1'.urlencode($p["db"]),ME):ME).'select='.urlencode($p["table"]).$_;if($p["ns"])$_=preg_replace('~([?&]ns=)[^&]+~','\1'.urlencode($p["ns"]),$_);if(count($p["source"])==1)break;}}}if($d=="COUNT(*)"){$_=ME."select=".urlencode($a);$s=0;foreach((array)$_GET["where"]as$W){if(!array_key_exists($W["col"],$rj))$_
.=where_link($s++,$W["col"],$W["val"],$W["op"]);}foreach($rj
as$Ae=>$W)$_
.=where_link($s++,$Ae,$W);}$Nd=select_value($X,$_,$m,$Oi);$t=h("val[$sj][".bracket_escape($x)."]");$Sg=idx(idx($_POST["val"],$sj),bracket_escape($x));$pc=!is_array($K[$x])&&is_utf8($Nd)&&$L[$zf][$x]==$K[$x]&&!$qd[$x]&&!$m["generated"];$U=(preg_match('~^(AVG|MIN|MAX)\((.+)\)~',$d,$A)?$n[idf_unescape($A[2])]["type"]:$m["type"]);$Mi=preg_match('~text|json|lob~',$U);$ue=preg_match(number_type(),$U)||preg_match('~^(CHAR_LENGTH|ROUND|FLOOR|CEIL|TIME_TO_SEC|COUNT|SUM)\(~',$d);echo"<td id='$t'".($ue&&($X===null||is_numeric(strip_tags($Nd))||$U=="money")?" class='number'":"");if(($_GET["modify"]&&$pc&&$X!==null)||$Sg!==null){$_d=h($Sg!==null?$Sg:$K[$x]);echo">".($Mi?"<textarea name='$t' cols='30' rows='".(substr_count($K[$x],"\n")+1)."'>$_d</textarea>":"<input name='$t' value='$_d' size='$Oe[$x]'>");}else{$Ue=strpos($Nd,"<i>â€¦</i>");echo" data-text='".($Ue?2:($Mi?1:0))."'".($pc?"":" data-warning='".h('Use edit link to modify this value.')."'").">$Nd";}}next($M);}if($Ea)echo"<td>";adminer()->backwardKeysPrint($Ea,$L[$zf]);echo"</tr>\n";}if(is_ajax())exit;echo"</table>\n","</div>\n";}if(!is_ajax()){if($L||$D){$Hc=true;if($_GET["page"]!="last"){if(!$z||(count($L)<$z&&($L||!$D)))$nd=($D?$D*$z:0)+count($L);elseif(JUSH!="sql"||!$te){$nd=($te?false:found_rows($S,$Z));if(intval($nd)<max(1e4,2*($D+1)*$z))$nd=first(slow_query(count_rows($a,$Z,$te,$vd)));elseif(JUSH=='sql'||JUSH=='pgsql')$Hc=false;}}$ug=($z&&($nd===false||$nd>$z||$D));if($ug)echo(($nd===false?count($L)+1:$nd-$D*$z)>$z?'<p><a href="'.h(remove_from_uri("page")."&page=".($D+1)).'" class="loadmore">'.'Load more data'.'</a>'.script("qsl('a').onclick = partial(selectLoadMore, $z, '".'Loading'."â€¦');",""):''),"\n";echo"<div class='footer'><div>\n";if($ug){$ef=($nd===false?$D+(count($L)>=$z?2:1):floor(($nd-1)/$z));echo"<fieldset>";if(JUSH!="simpledb"){echo"<legend><a href='".h(remove_from_uri("page"))."'>".'Page'."</a></legend>",script("qsl('a').onclick = function () { pageClick(this.href, +prompt('".'Page'."', '".($D+1)."')); return false; };"),pagination(0,$D).($D>5?" â€¦":"");for($s=max(1,$D-4);$s<min($ef,$D+5);$s++)echo
pagination($s,$D);if($ef>0)echo($D+5<$ef?" â€¦":""),($Hc&&$nd!==false?pagination($ef,$D):" <a href='".h(remove_from_uri("page")."&page=last")."' title='~$ef'>".'last'."</a>");}else
echo"<legend>".'Page'."</legend>",pagination(0,$D).($D>1?" â€¦":""),($D?pagination($D,$D):""),($ef>$D?pagination($D+1,$D).($ef>$D+1?" â€¦":""):"");echo"</fieldset>\n";}echo"<fieldset>","<legend>".'Whole result'."</legend>";$ec=($Hc?"":"~ ").$nd;$Xf="const checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$ec' : checked); selectCount('selected2', this.checked || !checked ? '$ec' : checked);";echo
checkbox("all",1,0,($nd!==false?($Hc?"":"~ ").lang_format(array('%d row','%d rows'),$nd):""),$Xf)."\n","</fieldset>\n";if(adminer()->selectCommandPrint())echo'<fieldset',($_GET["modify"]?'':' class="jsonly"'),'><legend>Modify</legend><div>
<input type="submit" value="Save"',($_GET["modify"]?'':' title="'.'Ctrl+click on a value to modify it.'.'"'),'>
</div></fieldset>
<fieldset><legend>Selected <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="Edit">
<input type="submit" name="clone" value="Clone">
<input type="submit" name="delete" value="Delete">',confirm(),'</div></fieldset>
';$ld=adminer()->dumpFormat();foreach((array)$_GET["columns"]as$d){if($d["fun"]){unset($ld['sql']);break;}}if($ld){print_fieldset("export",'Export'." <span id='selected2'></span>");$rg=adminer()->dumpOutput();echo($rg?html_select("output",$rg,$na["output"])." ":""),html_select("format",$ld,$na["format"])," <input type='submit' name='export' value='".'Export'."'>\n","</div></fieldset>\n";}adminer()->selectEmailPrint(array_filter($uc,'strlen'),$e);echo"</div></div>\n";}if(adminer()->selectImportPrint())echo"<p>","<a href='#import'>".'Import'."</a>",script("qsl('a').onclick = partial(toggle, 'import');",""),"<span id='import'".($_POST["import"]?"":" class='hidden'").">: ",file_input("<input type='file' name='csv_file'> ".html_select("separator",array("csv"=>"CSV,","csv;"=>"CSV;","tsv"=>"TSV"),$na["format"])." <input type='submit' name='import' value='".'Import'."'>"),"</span>";echo
input_token(),"</form>\n",(!$vd&&$M?"":script("tableCheck();"));}}}if(is_ajax()){ob_end_clean();exit;}}elseif(isset($_GET["variables"])){$P=isset($_GET["status"]);page_header($P?'Status':'Variables');$Kj=($P?adminer()->showStatus():adminer()->showVariables());if(!$Kj)echo"<p class='message'>".'No rows.'."\n";else{echo"<table>\n";foreach($Kj
as$K){echo"<tr>";$x=array_shift($K);echo"<th><code class='jush-".JUSH.($P?"status":"set")."'>".h($x)."</code>";foreach($K
as$X)echo"<td>".nl_br(h($X));}echo"</table>\n";}}elseif(isset($_GET["script"])){header("Content-Type: text/javascript; charset=utf-8");if($_GET["script"]=="db"){$wi=array("Data_length"=>0,"Index_length"=>0,"Data_free"=>0);foreach(table_status()as$B=>$S){json_row("Comment-$B",h($S["Comment"]));if(!is_view($S)||preg_match('~materialized~i',$S["Engine"])){foreach(array("Engine","Collation")as$x)json_row("$x-$B",h($S[$x]));foreach($wi+array("Auto_increment"=>0,"Rows"=>0)as$x=>$X){if($S[$x]!=""){$X=format_number($S[$x]);if($X>=0)json_row("$x-$B",($x=="Rows"&&$X&&$S["Engine"]==(JUSH=="pgsql"?"table":"InnoDB")?"~ $X":$X));if(isset($wi[$x]))$wi[$x]+=($S["Engine"]!="InnoDB"||$x!="Data_free"?$S[$x]:0);}elseif(array_key_exists($x,$S))json_row("$x-$B","?");}}}foreach($wi
as$x=>$X)json_row("sum-$x",format_number($X));json_row("");}elseif($_GET["script"]=="kill")connection()->query("KILL ".number($_POST["kill"]));else{foreach(count_tables(adminer()->databases())as$j=>$X){json_row("tables-$j",$X);json_row("size-$j",db_size($j));}json_row("");}exit;}else{$Gi=array_merge((array)$_POST["tables"],(array)$_POST["views"]);if($Gi&&!$l&&!$_POST["search"]){$I=true;$mf="";if(JUSH=="sql"&&$_POST["tables"]&&count($_POST["tables"])>1&&($_POST["drop"]||$_POST["truncate"]||$_POST["copy"]))queries("SET foreign_key_checks = 0");if($_POST["truncate"]){if($_POST["tables"])$I=truncate_tables($_POST["tables"]);$mf='Tables have been truncated.';}elseif($_POST["move"]){$I=move_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$mf='Tables have been moved.';}elseif($_POST["copy"]){$I=copy_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$mf='Tables have been copied.';}elseif($_POST["drop"]){if($_POST["views"])$I=drop_views($_POST["views"]);if($I&&$_POST["tables"])$I=drop_tables($_POST["tables"]);$mf='Tables have been dropped.';}elseif(JUSH=="sqlite"&&$_POST["check"]){foreach((array)$_POST["tables"]as$R){foreach(get_rows("PRAGMA integrity_check(".q($R).")")as$K)$mf
.="<b>".h($R)."</b>: ".h($K["integrity_check"])."<br>";}}elseif(JUSH!="sql"){$I=(JUSH=="sqlite"?queries("VACUUM"):apply_queries("VACUUM".($_POST["optimize"]?"":" ANALYZE"),$_POST["tables"]));$mf='Tables have been optimized.';}elseif(!$_POST["tables"])$mf='No tables.';elseif($I=queries(($_POST["optimize"]?"OPTIMIZE":($_POST["check"]?"CHECK":($_POST["repair"]?"REPAIR":"ANALYZE")))." TABLE ".implode(", ",array_map('Adminer\idf_escape',$_POST["tables"])))){while($K=$I->fetch_assoc())$mf
.="<b>".h($K["Table"])."</b>: ".h($K["Msg_text"])."<br>";}queries_redirect(substr(ME,0,-1),$mf,$I);}page_header(($_GET["ns"]==""?'Database'.": ".h(DB):'Schema'.": ".h($_GET["ns"])),$l,true);if(adminer()->homepage()){if($_GET["ns"]!==""){echo"<h3 id='tables-views'>".'Tables and views'."</h3>\n";$Fi=tables_list();if(!$Fi)echo"<p class='message'>".'No tables.'."\n";else{echo"<form action='' method='post'>\n";if(support("table")){echo"<fieldset><legend>".'Search data in tables'." <span id='selected2'></span></legend><div>",html_select("op",adminer()->operators(),idx($_POST,"op",JUSH=="elastic"?"should":"LIKE %%"))," <input type='search' name='query' value='".h($_POST["query"])."'>",script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');","")," <input type='submit' name='search' value='".'Search'."'>\n","</div></fieldset>\n";if($_POST["search"]&&$_POST["query"]!=""){$_GET["where"][0]["op"]=$_POST["op"];search_tables();}}echo"<div class='scrollable'>\n","<table class='nowrap checkable odds'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),'<thead><tr class="wrap">','<td><input id="check-all" type="checkbox" class="jsonly">'.script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);",""),'<th>'.'Table';$e=array("Engine"=>array('Engine'.doc_link(array('sql'=>'storage-engines.html'))));if(collations())$e["Collation"]=array('Collation'.doc_link(array('sql'=>'charset-charsets.html','mariadb'=>'supported-character-sets-and-collations/')));if(function_exists('Adminer\alter_table'))$e["Data_length"]=array('Data Length'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT','oracle'=>'REFRN20286')),"create",'Alter table');if(support('indexes'))$e["Index_length"]=array('Index Length'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT')),"indexes",'Alter indexes');$e["Data_free"]=array('Data Free'.doc_link(array('sql'=>'show-table-status.html')),"edit",'New item');if(function_exists('Adminer\alter_table'))$e["Auto_increment"]=array('Auto Increment'.doc_link(array('sql'=>'example-auto-increment.html','mariadb'=>'auto_increment/')),"auto_increment=1&create",'Alter table');$e["Rows"]=array('Rows'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'catalog-pg-class.html#CATALOG-PG-CLASS','oracle'=>'REFRN20286')),"select",'Select data');if(support("comment"))$e["Comment"]=array('Comment'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-info.html#FUNCTIONS-INFO-COMMENT-TABLE')));foreach($e
as$d)echo"<td>$d[0]";echo"</thead>\n";$T=0;foreach($Fi
as$B=>$U){$Nj=($U!==null&&!preg_match('~table|sequence~i',$U));$t=h("Table-".$B);echo'<tr><td>'.checkbox(($Nj?"views[]":"tables[]"),$B,in_array("$B",$Gi,true),"","","",$t),'<th>'.(support("table")||support("indexes")?"<a href='".h(ME)."table=".urlencode($B)."' title='".'Show structure'."' id='$t'>".h($B).'</a>':h($B));if($Nj&&!preg_match('~materialized~i',$U)){$Si='View';echo'<td colspan="6">'.(support("view")?"<a href='".h(ME)."view=".urlencode($B)."' title='".'Alter view'."'>$Si</a>":$Si),'<td align="right"><a href="'.h(ME)."select=".urlencode($B).'" title="'.'Select data'.'">?</a>';}else{foreach($e
as$x=>$d){$t=" id='$x-".h($B)."'";echo($d[1]?"<td align='right'><a href='".h(ME."$d[1]=").urlencode($B)."'$t title='$d[2]'>?</a>":"<td id='$x-".h($B)."'>");}$T++;}echo"\n";}echo"<tr><td><th>".sprintf('%d in total',count($Fi)),"<td>".h(JUSH=="sql"?get_val("SELECT @@default_storage_engine"):""),"<td>".h(db_collation(DB,collations()));foreach(array("Data_length","Index_length","Data_free")as$x)echo($e[$x]?"<td align='right' id='sum-$x'>":"");echo"\n","</table>\n",script("ajaxSetHtml('".js_escape(ME)."script=db');"),"</div>\n";if(!information_schema(DB)){$Hj="<input type='submit' value='".'Vacuum'."'> ".on_help("'VACUUM'");$ag="<input type='submit' name='optimize' value='".'Optimize'."'> ".on_help(JUSH=="sql"?"'OPTIMIZE TABLE'":"'VACUUM OPTIMIZE'");$Xg=(JUSH=="sqlite"?$Hj."<input type='submit' name='check' value='".'Check'."'> ".on_help("'PRAGMA integrity_check'"):(JUSH=="pgsql"?$Hj.$ag:(JUSH=="sql"?"<input type='submit' value='".'Analyze'."'> ".on_help("'ANALYZE TABLE'").$ag."<input type='submit' name='check' value='".'Check'."'> ".on_help("'CHECK TABLE'")."<input type='submit' name='repair' value='".'Repair'."'> ".on_help("'REPAIR TABLE'"):""))).(function_exists('Adminer\truncate_tables')?"<input type='submit' name='truncate' value='".'Truncate'."'> ".on_help(JUSH=="sqlite"?"'DELETE'":"'TRUNCATE".(JUSH=="pgsql"?"'":" TABLE'")).confirm():"").(function_exists('Adminer\drop_tables')?"<input type='submit' name='drop' value='".'Drop'."'>".on_help("'DROP TABLE'").confirm():"");echo($Xg?"<div class='footer'><div>\n<fieldset><legend>".'Selected'." <span id='selected'></span></legend><div>$Xg\n</div></fieldset>\n":"");$i=(support("scheme")?adminer()->schemas():adminer()->databases());$Jh="";if(count($i)!=1&&JUSH!="sqlite"){echo"<fieldset><legend>".'Move to other database'." <span id='selected3'></span></legend><div>";$j=(isset($_POST["target"])?$_POST["target"]:(support("scheme")?$_GET["ns"]:DB));echo($i?html_select("target",$i,$j):'<input name="target" value="'.h($j).'" autocapitalize="off">'),"</label> <input type='submit' name='move' value='".'Move'."'>",(support("copy")?" <input type='submit' name='copy' value='".'Copy'."'> ".checkbox("overwrite",1,$_POST["overwrite"],'overwrite'):""),"</div></fieldset>\n";$Jh=" selectCount('selected3', formChecked(this, /^(tables|views)\[/));";}echo"<input type='hidden' name='all' value=''>",script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));".(support("table")?" selectCount('selected2', formChecked(this, /^tables\[/) || $T);":"")."$Jh }"),input_token(),"</div></div>\n";}echo"</form>\n",script("tableCheck();");}echo(function_exists('Adminer\alter_table')?"<p class='links'><a href='".h(ME)."create='>".'Create table'."</a>\n":''),(support("view")?"<a href='".h(ME)."view='>".'Create view'."</a>\n":"");if(support("routine")){echo"<h3 id='routines'>".'Routines'."</h3>\n";$Bh=routines();if($Bh){echo"<table class='odds'>\n",'<thead><tr><th>'.'Name'.'<td>'.'Type'.'<td>'.'Return type'."<td></thead>\n";foreach($Bh
as$K){$B=($K["SPECIFIC_NAME"]==$K["ROUTINE_NAME"]?"":"&name=".urlencode($K["ROUTINE_NAME"]));echo'<tr>','<th><a href="'.h(ME.($K["ROUTINE_TYPE"]!="PROCEDURE"?'callf=':'call=').urlencode($K["SPECIFIC_NAME"]).$B).'">'.h($K["ROUTINE_NAME"]).'</a>','<td>'.h($K["ROUTINE_TYPE"]),'<td>'.h($K["DTD_IDENTIFIER"]),'<td><a href="'.h(ME.($K["ROUTINE_TYPE"]!="PROCEDURE"?'function=':'procedure=').urlencode($K["SPECIFIC_NAME"]).$B).'">'.'Alter'."</a>";}echo"</table>\n";}echo'<p class="links">'.(support("procedure")?'<a href="'.h(ME).'procedure=">'.'Create procedure'.'</a>':'').'<a href="'.h(ME).'function=">'.'Create function'."</a>\n";}if(support("sequence")){echo"<h3 id='sequences'>".'Sequences'."</h3>\n";$Uh=get_vals("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = current_schema() ORDER BY sequence_name");if($Uh){echo"<table class='odds'>\n","<thead><tr><th>".'Name'."</thead>\n";foreach($Uh
as$X)echo"<tr><th><a href='".h(ME)."sequence=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."sequence='>".'Create sequence'."</a>\n";}if(support("type")){echo"<h3 id='user-types'>".'User types'."</h3>\n";$Ej=types();if($Ej){echo"<table class='odds'>\n","<thead><tr><th>".'Name'."</thead>\n";foreach($Ej
as$X)echo"<tr><th><a href='".h(ME)."type=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."type='>".'Create type'."</a>\n";}if(support("event")){echo"<h3 id='events'>".'Events'."</h3>\n";$L=get_rows("SHOW EVENTS");if($L){echo"<table>\n","<thead><tr><th>".'Name'."<td>".'Schedule'."<td>".'Start'."<td>".'End'."<td></thead>\n";foreach($L
as$K)echo"<tr>","<th>".h($K["Name"]),"<td>".($K["Execute at"]?'At given time'."<td>".$K["Execute at"]:'Every'." ".$K["Interval value"]." ".$K["Interval field"]."<td>$K[Starts]"),"<td>$K[Ends]",'<td><a href="'.h(ME).'event='.urlencode($K["Name"]).'">'.'Alter'.'</a>';echo"</table>\n";$Fc=get_val("SELECT @@event_scheduler");if($Fc&&$Fc!="ON")echo"<p class='error'><code class='jush-sqlset'>event_scheduler</code>: ".h($Fc)."\n";}echo'<p class="links"><a href="'.h(ME).'event=">'.'Create event'."</a>\n";}}}}page_footer();