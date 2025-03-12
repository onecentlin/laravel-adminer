<?php
/** Adminer - Compact database management
* @link https://www.adminer.org/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
* @version 5.0.4
*/namespace
Adminer;$ia="5.0.4";error_reporting(6135);set_error_handler(function($Ac,$Cc){return!!preg_match('~^(Trying to access array offset on( value of type)? null|Undefined (array key|property))~',$Cc);},E_WARNING);$Xc=!preg_match('~^(unsafe_raw)?$~',ini_get("filter.default"));if($Xc||ini_get("filter.default_flags")){foreach(array('_GET','_POST','_COOKIE','_SERVER')as$X){$Oi=filter_input_array(constant("INPUT$X"),FILTER_UNSAFE_RAW);if($Oi)$$X=$Oi;}}if(function_exists("mb_internal_encoding"))mb_internal_encoding("8bit");function
connection(){global$f;return$f;}function
adminer(){global$b;return$b;}function
version(){global$ia;return$ia;}function
idf_unescape($v){if(!preg_match('~^[`\'"[]~',$v))return$v;$qe=substr($v,-1);return
str_replace($qe.$qe,$qe,substr($v,1,-1));}function
escape_string($X){return
substr(q($X),1,-1);}function
number($X){return
preg_replace('~[^0-9]+~','',$X);}function
number_type(){return'((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';}function
remove_slashes($ug,$Xc=false){if(function_exists("get_magic_quotes_gpc")&&get_magic_quotes_gpc()){while(list($y,$X)=each($ug)){foreach($X
as$ie=>$W){unset($ug[$y][$ie]);if(is_array($W)){$ug[$y][stripslashes($ie)]=$W;$ug[]=&$ug[$y][stripslashes($ie)];}else$ug[$y][stripslashes($ie)]=($Xc?$W:stripslashes($W));}}}}function
bracket_escape($v,$Fa=false){static$yi=array(':'=>':1',']'=>':2','['=>':3','"'=>':4');return
strtr($v,($Fa?array_flip($yi):$yi));}function
min_version($fj,$De="",$g=null){global$f;if(!$g)$g=$f;$ph=$g->server_info;if($De&&preg_match('~([\d.]+)-MariaDB~',$ph,$A)){$ph=$A[1];$fj=$De;}return$fj&&version_compare($ph,$fj)>=0;}function
charset($f){return(min_version("5.5.3",0,$f)?"utf8mb4":"utf8");}function
script($Bh,$xi="\n"){return"<script".nonce().">$Bh</script>$xi";}function
script_src($Ti){return"<script src='".h($Ti)."'".nonce()."></script>\n";}function
nonce(){return' nonce="'.get_nonce().'"';}function
target_blank(){return' target="_blank" rel="noreferrer noopener"';}function
h($P){return
str_replace("\0","&#0;",htmlspecialchars($P,ENT_QUOTES,'utf-8'));}function
nl_br($P){return
str_replace("\n","<br>",$P);}function
checkbox($B,$Y,$Za,$ne="",$vf="",$db="",$oe=""){$I="<input type='checkbox' name='$B' value='".h($Y)."'".($Za?" checked":"").($oe?" aria-labelledby='$oe'":"").">".($vf?script("qsl('input').onclick = function () { $vf };",""):"");return($ne!=""||$db?"<label".($db?" class='$db'":"").">$I".h($ne)."</label>":$I);}function
optionlist($Af,$hh=null,$Xi=false){$I="";foreach($Af
as$ie=>$W){$Bf=array($ie=>$W);if(is_array($W)){$I.='<optgroup label="'.h($ie).'">';$Bf=$W;}foreach($Bf
as$y=>$X)$I.='<option'.($Xi||is_string($y)?' value="'.h($y).'"':'').($hh!==null&&($Xi||is_string($y)?(string)$y:$X)===$hh?' selected':'').'>'.h($X);if(is_array($W))$I.='</optgroup>';}return$I;}function
html_select($B,$Af,$Y="",$uf="",$oe=""){return"<select name='".h($B)."'".($oe?" aria-labelledby='$oe'":"").">".optionlist($Af,$Y)."</select>".($uf?script("qsl('select').onchange = function () { $uf };",""):"");}function
html_radios($B,$Af,$Y=""){$I="";foreach($Af
as$y=>$X)$I.="<label><input type='radio' name='".h($B)."' value='".h($y)."'".($y==$Y?" checked":"").">".h($X)."</label>";return$I;}function
confirm($Oe="",$ih="qsl('input')"){return
script("$ih.onclick = function () { return confirm('".($Oe?js_escape($Oe):'Are you sure?')."'); };","");}function
print_fieldset($u,$ve,$ij=false){echo"<fieldset><legend>","<a href='#fieldset-$u'>$ve</a>",script("qsl('a').onclick = partial(toggle, 'fieldset-$u');",""),"</legend>","<div id='fieldset-$u'".($ij?"":" class='hidden'").">\n";}function
bold($Ma,$db=""){return($Ma?" class='active $db'":($db?" class='$db'":""));}function
js_escape($P){return
addcslashes($P,"\r\n'\\/");}function
ini_bool($Td){$X=ini_get($Td);return(preg_match('~^(on|true|yes)$~i',$X)||(int)$X);}function
sid(){static$I;if($I===null)$I=(SID&&!($_COOKIE&&ini_bool("session.use_cookies")));return$I;}function
set_password($ej,$M,$V,$E){$_SESSION["pwds"][$ej][$M][$V]=($_COOKIE["adminer_key"]&&is_string($E)?array(encrypt_string($E,$_COOKIE["adminer_key"])):$E);}function
get_password(){$I=get_session("pwds");if(is_array($I))$I=($_COOKIE["adminer_key"]?decrypt_string($I[0],$_COOKIE["adminer_key"]):false);return$I;}function
q($P){global$f;return$f->quote($P);}function
get_val($G,$n=0){global$f;return$f->result($G,$n);}function
get_vals($G,$d=0){global$f;$I=array();$H=$f->query($G);if(is_object($H)){while($J=$H->fetch_row())$I[]=$J[$d];}return$I;}function
get_key_vals($G,$g=null,$sh=true){global$f;if(!is_object($g))$g=$f;$I=array();$H=$g->query($G);if(is_object($H)){while($J=$H->fetch_row()){if($sh)$I[$J[0]]=$J[1];else$I[]=$J[0];}}return$I;}function
get_rows($G,$g=null,$m="<p class='error'>"){global$f;$tb=(is_object($g)?$g:$f);$I=array();$H=$tb->query($G);if(is_object($H)){while($J=$H->fetch_assoc())$I[]=$J;}elseif(!$H&&!is_object($g)&&$m&&(defined('Adminer\PAGE_HEADER')||$m=="-- "))echo$m.error()."\n";return$I;}function
unique_array($J,$x){foreach($x
as$w){if(preg_match("~PRIMARY|UNIQUE~",$w["type"])){$I=array();foreach($w["columns"]as$y){if(!isset($J[$y]))continue
2;$I[$y]=$J[$y];}return$I;}}}function
escape_key($y){if(preg_match('(^([\w(]+)('.str_replace("_",".*",preg_quote(idf_escape("_"))).')([ \w)]+)$)',$y,$A))return$A[1].idf_escape(idf_unescape($A[2])).$A[3];return
idf_escape($y);}function
where($Z,$o=array()){global$f;$I=array();foreach((array)$Z["where"]as$y=>$X){$y=bracket_escape($y,1);$d=escape_key($y);$I[]=$d.(JUSH=="sql"&&$o[$y]["type"]=="json"?" = CAST(".q($X)." AS JSON)":(JUSH=="sql"&&is_numeric($X)&&preg_match('~\.~',$X)?" LIKE ".q($X):(JUSH=="mssql"?" LIKE ".q(preg_replace('~[_%[]~','[\0]',$X)):" = ".unconvert_field($o[$y],q($X)))));if(JUSH=="sql"&&preg_match('~char|text~',$o[$y]["type"])&&preg_match("~[^ -@]~",$X))$I[]="$d = ".q($X)." COLLATE ".charset($f)."_bin";}foreach((array)$Z["null"]as$y)$I[]=escape_key($y)." IS NULL";return
implode(" AND ",$I);}function
where_check($X,$o=array()){parse_str($X,$Wa);remove_slashes(array(&$Wa));return
where($Wa,$o);}function
where_link($t,$d,$Y,$xf="="){return"&where%5B$t%5D%5Bcol%5D=".urlencode($d)."&where%5B$t%5D%5Bop%5D=".urlencode(($Y!==null?$xf:"IS NULL"))."&where%5B$t%5D%5Bval%5D=".urlencode($Y);}function
convert_fields($e,$o,$L=array()){$I="";foreach($e
as$y=>$X){if($L&&!in_array(idf_escape($y),$L))continue;$za=convert_field($o[$y]);if($za)$I.=", $za AS ".idf_escape($y);}return$I;}function
cookie($B,$Y,$ye=2592000){global$ba;return
header("Set-Cookie: $B=".urlencode($Y).($ye?"; expires=".gmdate("D, d M Y H:i:s",time()+$ye)." GMT":"")."; path=".preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]).($ba?"; secure":"")."; HttpOnly; SameSite=lax",false);}function
restart_session(){if(!ini_bool("session.use_cookies"))session_start();}function
stop_session($ed=false){$Wi=ini_bool("session.use_cookies");if(!$Wi||$ed){session_write_close();if($Wi&&@ini_set("session.use_cookies",false)===false)session_start();}}function&get_session($y){return$_SESSION[$y][DRIVER][SERVER][$_GET["username"]];}function
set_session($y,$X){$_SESSION[$y][DRIVER][SERVER][$_GET["username"]]=$X;}function
auth_url($ej,$M,$V,$j=null){global$ec;preg_match('~([^?]*)\??(.*)~',remove_from_uri(implode("|",array_keys($ec))."|username|".($j!==null?"db|":"").session_name()),$A);return"$A[1]?".(sid()?SID."&":"").($ej!="server"||$M!=""?urlencode($ej)."=".urlencode($M)."&":"")."username=".urlencode($V).($j!=""?"&db=".urlencode($j):"").($A[2]?"&$A[2]":"");}function
is_ajax(){return($_SERVER["HTTP_X_REQUESTED_WITH"]=="XMLHttpRequest");}function
redirect($_e,$Oe=null){if($Oe!==null){restart_session();$_SESSION["messages"][preg_replace('~^[^?]*~','',($_e!==null?$_e:$_SERVER["REQUEST_URI"]))][]=$Oe;}if($_e!==null){if($_e=="")$_e=".";header("Location: $_e");exit;}}function
query_redirect($G,$_e,$Oe,$Cg=true,$Hc=true,$Rc=false,$li=""){global$f,$m,$b;if($Hc){$Kh=microtime(true);$Rc=!$f->query($G);$li=format_time($Kh);}$Eh="";if($G)$Eh=$b->messageQuery($G,$li,$Rc);if($Rc){$m=error().$Eh.script("messagesPrint();");return
false;}if($Cg)redirect($_e,$Oe.$Eh);return
true;}function
queries($G){global$f;static$yg=array();static$Kh;if(!$Kh)$Kh=microtime(true);if($G===null)return
array(implode("\n",$yg),format_time($Kh));$yg[]=(preg_match('~;$~',$G)?"DELIMITER ;;\n$G;\nDELIMITER ":$G).";";return$f->query($G);}function
apply_queries($G,$S,$Dc='Adminer\table'){foreach($S
as$Q){if(!queries("$G ".$Dc($Q)))return
false;}return
true;}function
queries_redirect($_e,$Oe,$Cg){list($yg,$li)=queries(null);return
query_redirect($yg,$_e,$Oe,$Cg,false,!$Cg,$li);}function
format_time($Kh){return
sprintf('%.3f s',max(0,microtime(true)-$Kh));}function
relative_uri(){return
str_replace(":","%3a",preg_replace('~^[^?]*/([^?]*)~','\1',$_SERVER["REQUEST_URI"]));}function
remove_from_uri($Tf=""){return
substr(preg_replace("~(?<=[?&])($Tf".(SID?"":"|".session_name()).")=[^&]*&~",'',relative_uri()."&"),0,-1);}function
pagination($D,$Ib){return" ".($D==$Ib?$D+1:'<a href="'.h(remove_from_uri("page").($D?"&page=$D".($_GET["next"]?"&next=".urlencode($_GET["next"]):""):"")).'">'.($D+1)."</a>");}function
get_file($y,$Rb=false,$Vb=""){$Wc=$_FILES[$y];if(!$Wc)return
null;foreach($Wc
as$y=>$X)$Wc[$y]=(array)$X;$I='';foreach($Wc["error"]as$y=>$m){if($m)return$m;$B=$Wc["name"][$y];$ti=$Wc["tmp_name"][$y];$xb=file_get_contents($Rb&&preg_match('~\.gz$~',$B)?"compress.zlib://$ti":$ti);if($Rb){$Kh=substr($xb,0,3);if(function_exists("iconv")&&preg_match("~^\xFE\xFF|^\xFF\xFE~",$Kh))$xb=iconv("utf-16","utf-8",$xb);elseif($Kh=="\xEF\xBB\xBF")$xb=substr($xb,3);}$I.=$xb;if($Vb)$I.=(preg_match("($Vb\\s*\$)",$xb)?"":$Vb)."\n\n";}return$I;}function
upload_error($m){$Ke=($m==UPLOAD_ERR_INI_SIZE?ini_get("upload_max_filesize"):0);return($m?'Unable to upload a file.'.($Ke?" ".sprintf('Maximum allowed file size is %sB.',$Ke):""):'File does not exist.');}function
repeat_pattern($dg,$we){return
str_repeat("$dg{0,65535}",$we/65535)."$dg{0,".($we%65535)."}";}function
is_utf8($X){return(preg_match('~~u',$X)&&!preg_match('~[\0-\x8\xB\xC\xE-\x1F]~',$X));}function
shorten_utf8($P,$we=80,$Qh=""){if(!preg_match("(^(".repeat_pattern("[\t\r\n -\x{10FFFF}]",$we).")($)?)u",$P,$A))preg_match("(^(".repeat_pattern("[\t\r\n -~]",$we).")($)?)",$P,$A);return
h($A[1]).$Qh.(isset($A[2])?"":"<i>â€¦</i>");}function
format_number($X){return
strtr(number_format($X,0,".",','),preg_split('~~u','0123456789',-1,PREG_SPLIT_NO_EMPTY));}function
friendly_url($X){return
preg_replace('~\W~i','-',$X);}function
hidden_fields($ug,$Kd=array(),$ng=''){$I=false;foreach($ug
as$y=>$X){if(!in_array($y,$Kd)){if(is_array($X))hidden_fields($X,array(),$y);else{$I=true;echo'<input type="hidden" name="'.h($ng?$ng."[$y]":$y).'" value="'.h($X).'">';}}}return$I;}function
hidden_fields_get(){echo(sid()?'<input type="hidden" name="'.session_name().'" value="'.h(session_id()).'">':''),(SERVER!==null?'<input type="hidden" name="'.DRIVER.'" value="'.h(SERVER).'">':""),'<input type="hidden" name="username" value="'.h($_GET["username"]).'">';}function
table_status1($Q,$Sc=false){$I=table_status($Q,$Sc);return($I?:array("Name"=>$Q));}function
column_foreign_keys($Q){global$b;$I=array();foreach($b->foreignKeys($Q)as$q){foreach($q["source"]as$X)$I[$X][]=$q;}return$I;}function
enum_input($U,$Aa,$n,$Y,$uc=null){global$b;preg_match_all("~'((?:[^']|'')*)'~",$n["length"],$Fe);$I=($uc!==null?"<label><input type='$U'$Aa value='$uc'".((is_array($Y)?in_array($uc,$Y):$Y===$uc)?" checked":"")."><i>".'empty'."</i></label>":"");foreach($Fe[1]as$t=>$X){$X=stripcslashes(str_replace("''","'",$X));$Za=(is_array($Y)?in_array($X,$Y):$Y===$X);$I.=" <label><input type='$U'$Aa value='".h($X)."'".($Za?' checked':'').'>'.h($b->editVal($X,$n)).'</label>';}return$I;}function
input($n,$Y,$s){global$l,$b;$B=h(bracket_escape($n["field"]));echo"<td class='function'>";if(is_array($Y)&&!$s){$Y=json_encode($Y,128);$s="json";}$Mg=(JUSH=="mssql"&&$n["auto_increment"]);if($Mg&&!$_POST["save"])$s=null;$nd=(isset($_GET["select"])||$Mg?array("orig"=>'original'):array())+$b->editFunctions($n);$ac=stripos($n["default"],"GENERATED ALWAYS AS ")===0?" disabled=''":"";$Aa=" name='fields[$B]'$ac";$_c=$l->enumLength($n);if($_c){$n["type"]="enum";$n["length"]=$_c;}if($n["type"]=="enum")echo
h($nd[""])."<td>".$b->editInput($_GET["edit"],$n,$Aa,$Y);else{$zd=(in_array($s,$nd)||isset($nd[$s]));echo(count($nd)>1?"<select name='function[$B]'$ac>".optionlist($nd,$s===null||$zd?$s:"")."</select>".on_help("getTarget(event).value.replace(/^SQL\$/, '')",1).script("qsl('select').onchange = functionChange;",""):h(reset($nd))).'<td>';$Vd=$b->editInput($_GET["edit"],$n,$Aa,$Y);if($Vd!="")echo$Vd;elseif(preg_match('~bool~',$n["type"]))echo"<input type='hidden'$Aa value='0'>"."<input type='checkbox'".(preg_match('~^(1|t|true|y|yes|on)$~i',$Y)?" checked='checked'":"")."$Aa value='1'>";elseif($n["type"]=="set"){preg_match_all("~'((?:[^']|'')*)'~",$n["length"],$Fe);foreach($Fe[1]as$t=>$X){$X=stripcslashes(str_replace("''","'",$X));$Za=in_array($X,explode(",",$Y),true);echo" <label><input type='checkbox' name='fields[$B][$t]' value='".h($X)."'".($Za?' checked':'').">".h($b->editVal($X,$n)).'</label>';}}elseif(preg_match('~blob|bytea|raw|file~',$n["type"])&&ini_bool("file_uploads"))echo"<input type='file' name='fields-$B'>";elseif(($ii=preg_match('~text|lob|memo~i',$n["type"]))||preg_match("~\n~",$Y)){if($ii&&JUSH!="sqlite")$Aa.=" cols='50' rows='12'";else{$K=min(12,substr_count($Y,"\n")+1);$Aa.=" cols='30' rows='$K'".($K==1?" style='height: 1.2em;'":"");}echo"<textarea$Aa>".h($Y).'</textarea>';}elseif($s=="json"||preg_match('~^jsonb?$~',$n["type"]))echo"<textarea$Aa cols='50' rows='12' class='jush-js'>".h($Y).'</textarea>';else{$Ii=$l->types();$Me=(!preg_match('~int~',$n["type"])&&preg_match('~^(\d+)(,(\d+))?$~',$n["length"],$A)?((preg_match("~binary~",$n["type"])?2:1)*$A[1]+($A[3]?1:0)+($A[2]&&!$n["unsigned"]?1:0)):($Ii[$n["type"]]?$Ii[$n["type"]]+($n["unsigned"]?0:1):0));if(JUSH=='sql'&&min_version(5.6)&&preg_match('~time~',$n["type"]))$Me+=7;echo"<input".((!$zd||$s==="")&&preg_match('~(?<!o)int(?!er)~',$n["type"])&&!preg_match('~\[\]~',$n["full_type"])?" type='number'":"")." value='".h($Y)."'".($Me?" data-maxlength='$Me'":"").(preg_match('~char|binary~',$n["type"])&&$Me>20?" size='40'":"")."$Aa>";}echo$b->editHint($_GET["edit"],$n,$Y);$Yc=0;foreach($nd
as$y=>$X){if($y===""||!$X)break;$Yc++;}if($Yc)echo
script("mixin(qsl('td'), {onchange: partial(skipOriginal, $Yc), oninput: function () { this.onchange(); }});");}}function
process_input($n){global$b,$l;if(stripos($n["default"],"GENERATED ALWAYS AS ")===0)return
null;$v=bracket_escape($n["field"]);$s=$_POST["function"][$v];$Y=$_POST["fields"][$v];if($n["type"]=="enum"||$l->enumLength($n)){if($Y==-1)return
false;if($Y=="")return"NULL";}if($n["auto_increment"]&&$Y=="")return
null;if($s=="orig")return(preg_match('~^CURRENT_TIMESTAMP~i',$n["on_update"])?idf_escape($n["field"]):false);if($s=="NULL")return"NULL";if($n["type"]=="set")$Y=implode(",",(array)$Y);if($s=="json"){$s="";$Y=json_decode($Y,true);if(!is_array($Y))return
false;return$Y;}if(preg_match('~blob|bytea|raw|file~',$n["type"])&&ini_bool("file_uploads")){$Wc=get_file("fields-$v");if(!is_string($Wc))return
false;return$l->quoteBinary($Wc);}return$b->processInput($n,$Y,$s);}function
fields_from_edit(){global$l;$I=array();foreach((array)$_POST["field_keys"]as$y=>$X){if($X!=""){$X=bracket_escape($X);$_POST["function"][$X]=$_POST["field_funs"][$y];$_POST["fields"][$X]=$_POST["field_vals"][$y];}}foreach((array)$_POST["fields"]as$y=>$X){$B=bracket_escape($y,1);$I[$B]=array("field"=>$B,"privileges"=>array("insert"=>1,"update"=>1,"where"=>1,"order"=>1),"null"=>1,"auto_increment"=>($y==$l->primary),);}return$I;}function
search_tables(){global$b,$f;$_GET["where"][0]["val"]=$_POST["query"];$kh="<ul>\n";foreach(table_status('',true)as$Q=>$R){$B=$b->tableName($R);if(isset($R["Engine"])&&$B!=""&&(!$_POST["tables"]||in_array($Q,$_POST["tables"]))){$H=$f->query("SELECT".limit("1 FROM ".table($Q)," WHERE ".implode(" AND ",$b->selectSearchProcess(fields($Q),array())),1));if(!$H||$H->fetch_row()){$qg="<a href='".h(ME."select=".urlencode($Q)."&where[0][op]=".urlencode($_GET["where"][0]["op"])."&where[0][val]=".urlencode($_GET["where"][0]["val"]))."'>$B</a>";echo"$kh<li>".($H?$qg:"<p class='error'>$qg: ".error())."\n";$kh="";}}}echo($kh?"<p class='message'>".'No tables.':"</ul>")."\n";}function
dump_headers($Hd,$Ve=false){global$b;$I=$b->dumpHeaders($Hd,$Ve);$Pf=$_POST["output"];if($Pf!="text")header("Content-Disposition: attachment; filename=".$b->dumpFilename($Hd).".$I".($Pf!="file"&&preg_match('~^[0-9a-z]+$~',$Pf)?".$Pf":""));session_write_close();ob_flush();flush();return$I;}function
dump_csv($J){foreach($J
as$y=>$X){if(preg_match('~["\n,;\t]|^0|\.\d*0$~',$X)||$X==="")$J[$y]='"'.str_replace('"','""',$X).'"';}echo
implode(($_POST["format"]=="csv"?",":($_POST["format"]=="tsv"?"\t":";")),$J)."\r\n";}function
apply_sql_function($s,$d){return($s?($s=="unixepoch"?"DATETIME($d, '$s')":($s=="count distinct"?"COUNT(DISTINCT ":strtoupper("$s("))."$d)"):$d);}function
get_temp_dir(){$I=ini_get("upload_tmp_dir");if(!$I){if(function_exists('sys_get_temp_dir'))$I=sys_get_temp_dir();else{$p=@tempnam("","");if(!$p)return
false;$I=dirname($p);unlink($p);}}return$I;}function
file_open_lock($p){$r=@fopen($p,"r+");if(!$r){$r=@fopen($p,"w");if(!$r)return;chmod($p,0660);}flock($r,LOCK_EX);return$r;}function
file_write_unlock($r,$Kb){rewind($r);fwrite($r,$Kb);ftruncate($r,strlen($Kb));flock($r,LOCK_UN);fclose($r);}function
password_file($h){$p=get_temp_dir()."/adminer.key";$I=@file_get_contents($p);if($I||!$h)return$I;$r=@fopen($p,"w");if($r){chmod($p,0660);$I=rand_string();fwrite($r,$I);fclose($r);}return$I;}function
rand_string(){return
md5(uniqid(mt_rand(),true));}function
select_value($X,$_,$n,$ki){global$b;if(is_array($X)){$I="";foreach($X
as$ie=>$W)$I.="<tr>".($X!=array_values($X)?"<th>".h($ie):"")."<td>".select_value($W,$_,$n,$ki);return"<table>$I</table>";}if(!$_)$_=$b->selectLink($X,$n);if($_===null){if(is_mail($X))$_="mailto:$X";if(is_url($X))$_=$X;}$I=$b->editVal($X,$n);if($I!==null){if(!is_utf8($I))$I="\0";elseif($ki!=""&&is_shortable($n))$I=shorten_utf8($I,max(0,+$ki));else$I=h($I);}return$b->selectVal($I,$_,$n,$X);}function
is_mail($rc){$_a='[-a-z0-9!#$%&\'*+/=?^_`{|}~]';$dc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';$dg="$_a+(\\.$_a+)*@($dc?\\.)+$dc";return
is_string($rc)&&preg_match("(^$dg(,\\s*$dg)*\$)i",$rc);}function
is_url($P){$dc='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';return
preg_match("~^(https?)://($dc?\\.)+$dc(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i",$P);}function
is_shortable($n){return
preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~',$n["type"]);}function
count_rows($Q,$Z,$be,$sd){$G=" FROM ".table($Q).($Z?" WHERE ".implode(" AND ",$Z):"");return($be&&(JUSH=="sql"||count($sd)==1)?"SELECT COUNT(DISTINCT ".implode(", ",$sd).")$G":"SELECT COUNT(*)".($be?" FROM (SELECT 1$G GROUP BY ".implode(", ",$sd).") x":$G));}function
slow_query($G){global$b,$T,$l;$j=$b->database();$mi=$b->queryTimeout();$yh=$l->slowQuery($G,$mi);$g=null;if(!$yh&&support("kill")&&is_object($g=connect($b->credentials()))&&($j==""||$g->select_db($j))){$le=$g->result(connection_id());echo'<script',nonce(),'>
var timeout = setTimeout(function () {
	ajax(\'',js_escape(ME),'script=kill\', function () {
	}, \'kill=',$le,'&token=',$T,'\');
}, ',1000*$mi,');
</script>
';}ob_flush();flush();$I=@get_key_vals(($yh?:$G),$g,false);if($g){echo
script("clearTimeout(timeout);");ob_flush();flush();}return$I;}function
get_token(){$Ag=rand(1,1e6);return($Ag^$_SESSION["token"]).":$Ag";}function
verify_token(){list($T,$Ag)=explode(":",$_POST["token"]);return($Ag^$_SESSION["token"])==$T;}function
lzw_decompress($Ja){$Zb=256;$Ka=8;$fb=array();$Og=0;$Pg=0;for($t=0;$t<strlen($Ja);$t++){$Og=($Og<<8)+ord($Ja[$t]);$Pg+=8;if($Pg>=$Ka){$Pg-=$Ka;$fb[]=$Og>>$Pg;$Og&=(1<<$Pg)-1;$Zb++;if($Zb>>$Ka)$Ka++;}}$Yb=range("\0","\xFF");$I="";foreach($fb
as$t=>$eb){$qc=$Yb[$eb];if(!isset($qc))$qc=$tj.$tj[0];$I.=$qc;if($t)$Yb[]=$tj.$qc[0];$tj=$qc;}return$I;}function
on_help($nb,$vh=0){return
script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $nb, $vh) }, onmouseout: helpMouseout});","");}function
edit_form($Q,$o,$J,$Ri){global$b,$T,$m;$Wh=$b->tableName(table_status1($Q,true));page_header(($Ri?'Edit':'Insert'),$m,array("select"=>array($Q,$Wh)),$Wh);$b->editRowPrint($Q,$o,$J,$Ri);if($J===false){echo"<p class='error'>".'No rows.'."\n";return;}echo'<form action="" method="post" enctype="multipart/form-data" id="form">
';$Yc=0;if(!$o)echo"<p class='error'>".'You have no privileges to update this table.'."\n";else{echo"<table class='layout'>".script("qsl('table').onkeydown = editingKeydown;");foreach($o
as$B=>$n){echo"<tr><th>".$b->fieldName($n);$k=$_GET["set"][bracket_escape($B)];if($k===null){$k=$n["default"];if($n["type"]=="bit"&&preg_match("~^b'([01]*)'\$~",$k,$Ig))$k=$Ig[1];}$Y=($J!==null?($J[$B]!=""&&JUSH=="sql"&&preg_match("~enum|set~",$n["type"])&&is_array($J[$B])?implode(",",$J[$B]):(is_bool($J[$B])?+$J[$B]:$J[$B])):(!$Ri&&$n["auto_increment"]?"":(isset($_GET["select"])?false:$k)));if(!$_POST["save"]&&is_string($Y))$Y=$b->editVal($Y,$n);$s=($_POST["save"]?(string)$_POST["function"][$B]:($Ri&&preg_match('~^CURRENT_TIMESTAMP~i',$n["on_update"])?"now":($Y===false?null:($Y!==null?'':'NULL'))));if(!$_POST&&!$Ri&&$Y==$n["default"]&&preg_match('~^[\w.]+\(~',$Y))$s="SQL";if(preg_match("~time~",$n["type"])&&preg_match('~^CURRENT_TIMESTAMP~i',$Y)){$Y="";$s="now";}if($n["type"]=="uuid"&&$Y=="uuid()"){$Y="";$s="uuid";}if($n["auto_increment"]||$s=="now"||$s=="uuid")$Yc++;input($n,$Y,$s);echo"\n";}if(!support("table"))echo"<tr>"."<th><input name='field_keys[]'>".script("qsl('input').oninput = fieldChange;")."<td class='function'>".html_select("field_funs[]",$b->editFunctions(array("null"=>isset($_GET["select"]))))."<td><input name='field_vals[]'>"."\n";echo"</table>\n";}echo"<p>\n";if($o){echo"<input type='submit' value='".'Save'."'>\n";if(!isset($_GET["select"])){echo"<input type='submit' name='insert' value='".($Ri?'Save and continue edit':'Save and insert next')."' title='Ctrl+Shift+Enter'>\n",($Ri?script("qsl('input').onclick = function () { return !ajaxForm(this.form, '".'Saving'."â€¦', this); };"):"");}}echo($Ri?"<input type='submit' name='delete' value='".'Delete'."'>".confirm()."\n":($_POST||!$o?"":script("focus(qsa('td', qs('#form'))[2*$Yc+1].firstChild);")));if(isset($_GET["select"]))hidden_fields(array("check"=>(array)$_POST["check"],"clone"=>$_POST["clone"],"all"=>$_POST["all"]));echo'<input type="hidden" name="referer" value="',h(isset($_POST["referer"])?$_POST["referer"]:$_SERVER["HTTP_REFERER"]),'">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="',$T,'">
</form>
';}if(isset($_GET["file"])){if($_SERVER["HTTP_IF_MODIFIED_SINCE"]){header("HTTP/1.1 304 Not Modified");exit;}header("Expires: ".gmdate("D, d M Y H:i:s",time()+365*24*60*60)." GMT");header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");header("Cache-Control: immutable");if($_GET["file"]=="favicon.ico"){header("Content-Type: image/x-icon");echo
lzw_decompress("\0\0\0` \0„\0\n @\0´C„è\"\0`EãQ¸àÿ‡?ÀtvM'”JdÁd\\Œb0\0Ä\"™ÀfÓˆ¤îs5›ÏçÑAXPaJ“0„¥‘8„#RŠT©‘z`ˆ#.©ÇcíXÃşÈ€?À-\0¡Im? .«M¶€\0È¯(Ì‰ıÀ/(%Œ\0");}elseif($_GET["file"]=="default.css"){header("Content-Type: text/css; charset=utf-8");echo
lzw_decompress("\n1Ì‡“ÙŒŞl7œ‡B1„4vb0˜Ífs‘¼ên2BÌÑ±Ù˜Şn:‡#(¼b.\rDc)ÈÈa7E„‘¤Âl¦Ã±”èi1Ìs˜´ç-4™‡fÓ	ÈÎi7†º€´îi2\r£1¤è-ƒH²ÙôÃƒÂGF#aÔÊ;:Oó!–r0Ïãã£t~ßf':ñ”Éh„B¦'cÍ”Â:6T\rc£A¾zrcğXKŒg+—ÄZXk…Êév„ŞM7¸½Ôå‘7_Ì\"ëÏ)––öº{¾ª÷}Øã…Æ£©ÌĞ-4NÎ}:¨rf§K) b{H(Æ“Ñ”t1É)tÚ}F¦p0™•8è\\82›DŒ>®ÀN‡Cy·¾8\0æƒ«\0FÁê>¯ã(Ò3	\nú9)ƒ`vç-Ao\r¡èŠ&Šµ¨XËº¡“±»në¾ğ„¯œ¨*A\0`A„\0¡ˆq\0oCÔö=Ïƒäú\r¯²\\–¿#{öş¿ğÈŒ2©ÃR‡;0dBHL+¢H¢,Œ!oR”>œNíA°|\"¾KÉ¼í0‘Pb¼Jd^¨È‘”d²£Ğ ÷=<ª’Ê:J# Â¶£Ú®¬«aŠĞ‘‚¦>ÑTeòFìkÆjš#K6#‚9ÕET·Ë1K¼‘Å´ÀÈ+CİF×I°	(ÀğL|õÏjPø„pfúÓEuLQG­íØZ›ÁêˆØ2ŒÎ¥š2½!sk[:¢1¬kˆå½6%ŒYpkf+W[Ş·\rrˆL1ÈÌÔ\0ÒŒŠ8è=½c˜áT.€ÜØ-ìº~ –»#sOàávGö+İy¾O{ëJª9COÕî–×²|`‡+(áMÏr\r‘OÀ5\nÊ4£8÷‰(	¾-l‡Cj°2[r5yKÑyŸ)ƒÂ¬¬+AÔk¤äÍÉ¯¨2ëgß³3iÄ”ÂÜHS>–ÜWÆÖ<í®fá}ÚöÏjfMiBÏ¹ÕlöIC¼(Ë\\4ÊmÁ5¤4’H“%	PÚøR\"¿ñN‹g_şÌ#ƒê 8£§¹ñË:©N²w\$uùØİÔuJ=¶1àú)¡ã3Õ¤ôİ¿R-ƒÈà2‡¡ğõá»Ÿ¥¸…rª6³ôşH¾/p.£0Â:˜?^£\rHŞ;×¡Œo÷@0Ô9ïu!sF8£KFÃüî7Ôûó}èİı»g¾ÔVÚÅ_a½Ø>Èúßl@0ú@\\Ãy\räl=­µº‘ÊSGÁÌ•ãVTTZOu%üÀŞD˜Aƒapdµ‚\$YAq—0„|Ğ¥d6\rÓ™_N§x%jpÃšÉ\r\r±‚À\\_CTI‰|6FØiÀ…‘EdœàêCp{„†rƒ¨RAáZ`tKI€¬4€JºÈ>ˆe,‚¦Ék„ÁfD÷Ö^ƒq‰Åô;ÈÄÀdÒT‚Àá\"ä‰eÄ£…ĞœT8‘’DI#%\\ÚpB‰È>‚âZEC”=PĞ­ş›L¦R &ÉåyV)µ.J\$¿)Chee3¨Ôªˆ¢#\rÑªW7¹a&Ã3q(µ·*’º¢o.Œ‘´Ï,¥DNš3FÆæ<¼—ŠBEÎ›µ†Sé•3+ƒpŒC¥)/.3b{Ùí_›ø#OùJŠM “\nâÁWsn¤€ãÏÒ (A¸·o3HXF´Š‘Cˆ¸§‰v\rsX2ÅÓ’DŒ4‚‰º•RÊiLK ›q°2Mò0eQ„'„¶ « t\rÏ¥Ä]ŞBstiQ&©rè¾ÊäbõI®Ã‰ôO™â«M©¡pò^ZjŠEyµ™JÃz\rÑ%İgUC«Œ'‰.ÔÖ¥ Õr‡2‡w QJÛ:\n(È†8pDIù=°òñ71˜qUŒ³¨öªAÄG.PÌ¨MU4ä˜e”^LÊR,ò‘Gme®KÔt%kzTÇ<Å˜Û\\X[´©·-šİš#I)b~j±Æ·ã’˜c¡É¶ã•òJ71°æÄÃY{i2;©ÀÜk)!¬á¥\$ˆôÎòP8ˆQ j\rAa)¿ê'pS{U+<šgyˆĞZEK\$\0¢úí~ï½ùÂ\$ ‚ÉºFèë’©ş¥û´\0>¬;Qöôé\nTæ=ª…d²±‡—P +¬ƒ7ò«”¸.6®\$ÙÛSjÎô„¬ªŞ›\0Ø1ĞoäYƒÇˆõ:-Ü®Q˜1B¢â\\+‚†ÈØä„—.á¯0-ƒÎFÁĞG0j´b„¹N3–Ü®áÔ’ O÷¼úæ5\rlNø9Y™€¸L,B(sÂÊem‡8Ä»czB>ló(gf©oş€,¹`=,YA€*\$Èè:Y§L0q\nÄäı¦&Ufà9bû\"Yê,zcMW=<£45¨“îjKä%Rõf®‚ÄºÌ¼Í­qî·Ğ €™=	0èŒ7\riMí0XK‰ ÆÅEx,X’#]Ç~w_à¥ôÉ0gÙJ2æØÓ¯X.ÙÕnÏ¢':ËHyì1YÀÈÃ•W“ÒS^ji6s^íÊ±£+ã€w·õÚ‹ı¾[Tß·xyPµ\\YÈ²mÄápø±£›g¦´üC‹Xº›Ü§ª-ß6(¯-‹™¡ÕN¡—‡:RS6ŞbŞ è5Ù£UD·œT‘]]âp8%X2† ÖWoNT½A.œÍÏILY;=]2²¤Õú¢æ_±äf‘åÒº…©Ë“ŞwaGÍÅÿóğÂ²M°4a¹thmØ^÷vWÌ×=™ø~ó•‹~e½¥˜LÌNÚ~*@Õ+ÄÑ¢«Es‡ ZT¨x;ğà9@ØB&ähâÛ Ïë=v~~ŞçgÄï[ëç	÷ŞäN<¶ÎüvO×²Rûõ“ 2dèeO#>3ùî=x#Û§ämÔhàSÿšÎ,ån^ó}È#ß«Û€p,íõƒx;ÈÜE\"û>Mœ±ÏÎÇ¢bèoŞu/âşmÂı^¯ˆ,ƒ4ƒşúìŒ„\"Éœİ%Šøo²Í\0êúH>şäk§÷o^qP(ÄQ£Ö4jš/gÊ]`ú	‚=nş&ï^&¢¢jjş\0pk\0RoöÀoüèp4”¯ ¯¯K¾5KóNBL÷ÌÔé£æ&lñ/´Ao¸ìümhİPïŒQP¦ÌÏÖ=/Ú\r©moã\0…’ÿ‰„o«\0°@Ï¶ÛHğÈĞ¹\rÔßĞÎ–ĞâúàûpZ&Ç&­µ@ÎÂĞœŠæêNù¬šÌ0¶ßøà0ÑÈ{© U*d×É8‘ff×N’ÍL”d-'<8ÉT-„<¤Ç>9\0è\r ¾ ÀÚ‰Ãˆ8ÅMñV¢£û¢qqz¢ıb\0Ğ\0¾àÇÑu•Ñœ8ñ ñ‹h£Ãc`[1˜•L·Ñ‡¹£bñË ¾©hÂ„¦\0fo,¸‰èÑì	ïŸGğ\rñ¹±ş ßQ…1©@ÊIQ¸U1ık2\r€¿!‘¹!ã\"(I\"k4ò!Ò3!&˜é’ÖiK À[² ``)îÇ2I±úàì)±ÓRb39\"j°îdæ‹(õ ñ•!…“%±ù Ra&QÇR…)2h)²tÔ©|”’˜çÒ|¤Lâ`È¸¢‚Ş˜ñ\\†òG%ñj˜r?rÊŠRH/ é#R,òÚi‡(qc-’-!²×-å-Rë-b\r‘ZUo+´¤1ìÀ‹%’Äš`¾Š2á1²ùRí#ró-ªO2²ï1ó//²Û/ñ¹/s!01_0‘ëğÒ~)§€ğ\r²!,iT·³S-“Y5Ò\"?s4ĞQ‡.Ò÷1ä\"‹¢-\".2¥3)3“37rü&éTu\0äah·/¸˜ó:S Ö ó“±;RéSSºn“v„“šºs­,3Ä`¾4f|˜óe=R€ò;óç<3ç>²§\"R§\"‚ã>ÒK(²ññÕ?Ê[?r/*`àóõ(‘•?TA´	(4AÀ¾\r©†³T%Òß*t5B‘÷BÔDq¬/\0Æ[t;@RgDâ#ET\rìM“…0À…FóEùE´wmú&Q‡D23Gò02\"ã-Ôdç`É5*­’IE)çF©ê ³Q>M™6 Â1’~Ù‘†ñ‚\nºkª2‹¯>BC”\$’êÙ”Š0´ÙtLÑ¹HPcƒSE*[Lñb0€Û:\rSJévKk* ô—L‘«DSï TßCB2ïPP²„»S,u3•/2HIS#µ9QÒ…OTMSÕE>r<T®˜ã¢)¨˜ëF4i†„àP=€*Pºuj\nmJ¥„¿âÍk¤»ä˜Çc3XCŠ{ƒ0c\n0õ„&KõT\rÃ¤+Ä/Fµ^˜Hv\rÕfqÂAVâëW)f]5xæ`ËWÃXzpRà");}elseif($_GET["file"]=="functions.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("f:›ŒgCI¼Ü\n8œÅ3)°Ë7œ…†81ĞÊx:\nOg#)Ğêr7\n\"†è´`ø|2ÌgSi–H)N¦S‘ä§\r‡\"0¹Ä@ä)Ÿ`(\$s6O!ÓèœV/=Œ' T4æ=„˜iS˜6IO G#ÒX·VCÆs¡ Z1.Ğhp8,³[¦Häµ~Cz§Éå2¹l¾c3šÍés£‘ÙI†bâ4\néF8Tà†I˜İ©U*fz¹är0EÆÀØy¸ñfY.:æƒIŒÊ(Øc·áÎ‹!_l™í^·^(¶šN{S–“)rËqÁY“–lÙ¦3Š3Ú\n˜+G¥Óêyºí†Ëi¶ÂîxV3w³uhã^rØÀº´aÛ”ú¹cØè\r“¨ë(.ÂˆºChÒ<\r)èÑ£¡`æ7£íò43'm5Œ£È\nPÜ:2£P»ª‹q òÿÅC“}Ä«ˆúÊÁê38‹BØ0hR‰Èr(œ0¥¡b\\0ŒHr44ŒÁB!¡pÇ\$rZZË2Ü‰.Éƒ(\\5Ã|\nC(Î\"€P…ğø.ĞNÌRTÊÎ“Àæ>HN…8HPá\\¬7Jp~„Üû2%¡ĞOC¨1ã.ƒ§C8Î‡HÈò*ˆj°…á÷S(úi!Lr°ÙDÁ# È—á`BÎ³»u\\×ióB!x\\‹c¥m-K’ôXù¸ƒ38†AÔøŠ\rãXÒßÌcHÎ7ƒ#Rİ*/-Ì‹£pÊ;B Â‹\n×3!ƒ¥åz^ápÎßmøRÜÃËt°mºI-\röí¿\0H·İ@k,â4£Š¼÷{Û.ĞìšJƒÈ¬šoÂVÓ·b?[§Q#>=Û–ó~Œ#\$%wBş>9d¨0zW®wJD¿„¾2Ò9yŒ¢*øÎz,ËNjIh\\9ÆÁèN4ƒ à9‡Ax^;ì^m\n¦r\"3…ùŞz7áşN\$šÔøîƒ wªÌÃ6Œ2ˆHv9gûŞı2…ÃkG\n‰-Å®p»æ®1C{\nŒúĞÜ7„ü6ÿ«ƒÊõ2Û­è¿;ÉY½Ì4qÃ? †!pdŒ£oW*ô£rR;…Ã€ßf‰£,Š0ßá0MŞ÷û0È\"ãé ˜é\"ÙÄ§ÃêİoF2:SHóÍ Ã/;šùşˆééÙ©ri9¥¾=ÿ^¸ÏÀËózò·ÍµW*ëZæ¼ØdxÕ›¶–Ö¡×ITqAĞ1†€zÛY!u  µ’ˆ¹~Æà.°ÂP (p43¾œà#hg-º	'¸FÙp0† ÂC+PÍÊàì, ÏÀûeêÃêN~ğy@fZK›´O3êv\$­`ØC¡	N`!åzÉpdh\$6EJöcBDœ…c8LËÁP„ †66®OH°d	.ø‹œ“†Y#¨tÅH62‚ˆ¤e€ö@¶¨~]C˜[‘²&=GÀğ\\P(2(Õµ×òƒªÌq¼2’xnÃJ‹|2ù)(ä(eR¼½™GâQTy\nØ!pÎª\0Q]«¼&ÔŞœS˜^N`®_(\0R	è'\r*q–PØòˆâËxË9,Ëå¥-¢);†â]/ˆĞwŒ†ü†¼ C.eÜçy\0¥,ÄÀ	S787«²ƒ5Hlj(ÁÑ »\0ÆÕ´À €öq’IË/=SŠÉ ¥Ã D<\r!è2+ÔÃA¨ä J©e Úò©!\r¡mšğNiDø¤´®–†Ê^Úˆl7¡®z‚êgKå6´á-Óµê§e¹!\rEJ\ni*ä\$@ÚRU0,\$U6 ?Å6¤Á:š™un©(¾škáp!€Âàd`Ì>°5\nÃ<½\rp9†|É¹Ü^fNg(r€ˆ•TZUª½S¸jQ8n„«—y¥d¥\rŸ4:OÅw>[Í4”4G\"­“7%¤—ÀĞŞÁ\\²¦PƒÛhnBØi.0†Û¬°ó*jğs¡‰	Ho^å}J2*	‘J¥Wš”GjxíS8ÇFÍŠe˜à6•s¢éõ*ƒ\r<Ü0wi-00o`òî^Õk­…²„*A«,É¸Óäº×Ñi‡»Ûnj ÷2ï¥ªA\"İºô[;›òn•ÔB^åàº0-½•¯©Ï\n:<ÔˆeĞ2 ÌÆh-¡¦2‚n§/Aå\r6ŸÚÂÖ[oŠ- ·cà¥R@U3\n¤\nTû·=¬R®jÀÑú7s\"²ØÁY+Ğ\"u°<fH÷ò`aû™z¬Eø÷†“^7syo:!ÆVöãkàm‹õ¿“ifàÛ»€/İÚ¦8;<eåNÌ2Í±S³W?e`‡C*B¨ÏÍ”ÔZB¤]œ¡ëü:K¤_7¢‰ÄŠq»‰QĞ)à÷/â:dği”ĞÁàZ^ì3õ©têƒ¥ª‚t*†Œ\$€²fùz50tÕUJg«ƒ¹S\rÎcX‘¸ş”î\rw7Z²N^`oxPÅ’êIöäx?ÀéTÃkeÌ ÷Jim)Éx;X°ßÎğçCÒ=V=ÛÍï<U½Ä!ğ0‡ËnÜú;òÍÛ~AZÃáˆ7‡ˆ€Êâº+Z†=n‘õÑ{HåÊPURY³–ŠÇ¯³¢å4ËHÇ‹6'gœÚ2K´©î~¼º|hT²A¶•1¨›V£‡Ş>/å^Ãál.ÀŠSIª.À9g’­~O²%Ø¦ ´Ì¾ó)A|ÊÑ\n;-ğîn‚à[t,«ì³òâ¥Y§<>j\nœ¹NìePúˆ’O<Éüû q ñÇ(G!~ ‡åÎ`_Š\r~áÍ†`èÑ.¡>'H¢Oé2ÎyKú‘Şód:(õ,û<°3ğ: „ÎÃã+0nUYZ²ö©^é)wwôÖ!°Íòá÷1ĞıµÍ!ÊÒæ»ÔmG¿½Ö·gdÑ=ı¶ûXÇ[Ş¢ÿ<­Úß©Wç´§ïğ7‹ºÂ`ËoÙÒ­·°éô¢‘Gêı©~`Äi`Öã*@ùïväë¦¢¬ ÷\0)»êœ\$R#ªªªê†¸ªìUdæ·)KLàÊM*Ôî@¸@º¯O\0HÅğ\\jŠF\r‡ëéì]£gKü³iô\$‹DÄ*g\0\n€š	†´s° Šğ\$K0&“	`{ˆ¨È6W` x`Ò8ëDG„*ëÔŞeHVÌÆ8íªø\nmT§OÜ#PÆĞ@úš°ÆĞÎÊÑ.˜\r8ÀY/&:D–	ÀQ•&%Eæ. ]€ÊĞ¯¥.\"%&ĞònÑ\ny\0Ê-àRSOÂBŒ0 ê	ævŞ D@Âİ‚:İÂ;\nDT­ş< ÂQ.\nc2‹ÀRy@Âm@ÌÅò	‘€W ßåò\nçL\r\0}®VŸ¤Íñ€#±”‚Ú-àjE¯Zt\\mFvÀØÛF´í¦J¹pB€”(À§µ1¿ î¥LX°œÈ	%t\nM´ˆäDÄâ¯Zù‚¨r±æKgÂ´CÄ[èÊ´	÷ é\0Ğ¯Åş‘ˆğÒŒR*-n¿#j‰#¥ş¨é4øIW²\r\",Ô*Œfúàx/¶Æë^ûÂ5&Lğê2p¿Læ­Ô7à^`Â ô®â® Vå`bS’v¨i(ev\nğï|µRNj/%Mµ%¨½+ÖÆ«Şû¬âß¯Ç'„ÊüR±'''ĞW(r‹(àÉ)2–Òš„ÎÀ%£-%6ü²ò·Ë€âJ@â,ıòÖ¿N„äÎQ\nÍ0ê†‚g	ª‘\$³ó*LÄŒ.nŒ Q%m\"n*hô\0òwâBòO×\0\\FJ˜Wgø f\$îC5dK5 Ë5àaC¤§4H©(°.Gª”BFÀÑ8èˆèæÀ³ E€öÀ³.§Îk3m*)-*±Ğ[g,%€Ü	ªø7å.›ë!\nı+ O<È¼¯C¥+Ï«%ËO=RfÍòÊí( ÚnèYÓäÏ²ö%©èsû1ÿ6ê3;³òObE@¢NSl#Œ³|»4\0²U€G\"@È_ [7³S„Ã@³\$DG¸ÓÑD«5=ÒÀûK>rÈûåÔ\r ì´ZüÖ±@¶¿€H Dsî°n\\´e)ÚÉÉb¡'øòĞBPGkx”ZÍÂÚ#TK:w:Éa2+øaeK›KR)\"Æ(4qGTxi	H«H@ì&@%bZƒ–ëÍÜª)3P“3f `ä\r“I6Gî%¤/4‘vÎ\\~ä4İ¤0ÓpÃè,§îEÍ)PH8k\0ÆiÌÎ\$â€È3I4ÑPV'F^ä ¦'DäòRĞõ+Qñ`ÓõÀÔ¯8\n‚áD[V5,#µqW@ÑW‚0áO2ÿ ætó\rC6sY_6 ùZkZ@z3ryIà<5‚….W¦–àÒ·@5¾Ä¢#ê„5N Õ~ÒìÈ¥uŞ\rÒô¨Ã)3S]*g7‹†¸µâÒ•ç_Ë‰î›_‹Ä¸V\nYÃ)aä¨é«1PêÙìFI\r;u@/!![õeÕ Ş(CU™OñaSó„¨óäKPõÒt3=5ÿàO[‘f:Q,_]o_¶<à¾J*ü\rg:_ ¨\r\"ZC…8XV}V2ú‰3s8e´‘P¾sFÛSN~“S5U£5Àz€ae	kón fOLòJV5Òõj‘Şùö½ZöÁlE&]Â1\rÄ¢Ù…5\rGæ µuoĞàí8<¥U]3§2é%n¢Ö·prÔ5º¢\n\$\"O\rqöÿr)éfÍğà7/Yéì£îp´I#`Ë¦Kk;\"!tŒÆÅhËusYjè[àRÂ\n{N5té¶#NÎœ¤o6ó¶X)İc6²ö¶e+.!ƒºß—‹\n	ÿbĞÊ’ŒtÉÒ®¶¬\n§ïÒjÒİ(\0¼©2”ô4erEJ÷íd¿@+xş\"\\@¨áïö %vÄåÜÏë{`Ï«€·¶`äø\n Î	¨oRi-IBØ-†“íŒNm\\q@ñ,`ĞğKz#€Ú\ræ?‚íŠÕ˜6†ø<jáf´Ö!„Nÿ7õØ:Ø/ËTÅ‚\0ñ‚K\\Æ0Ø*_8LÕm^r‡ƒ˜V˜wø\"û€ĞºB¶àQ:5Kn®¢‚v\0Ø„xtË;`æ[Àà	øB£9!nv˜<Û¢ÿ‹ÁpPÙp· ôÀçp±Øæî1i*B.tY¤>\rØèS±*nJæ¶¨º²7{Ò=|R]ÒøÕ¼õ­4ßiéUì2ø2´ø€Y3Ìc>a,X¬Ç3²Œñ9ó\$¹<AàQÌ&2wÓ­3²ºÁ1·‹/ÃiˆĞÈj†èsOâ&¨ ÄM@Ö\\¸œ‡Ú¯¥ş˜8&I¶‚m²x\0±	jªkÄÛ›EšåÜ^¾	™ÂÆ&lëàQ› \\\"ècà°	àÄ\rBsœÉ‰‚	ÙñŸBN`š7§*Co<ÙÓ	 ¨\nÄÎ½”hC›9İ#Ë™ ñUeçWPDUº0Yº7}Ñcš±8?hm£\$.#ËÁ\n`å\n°˜àyD @Rôy¤…ş@|…ÇšÀÊP\0xôK§ w£5¥E Le¤@O¨µu¨äı|ĞR­2€ˆ%ĞaAØcZ‰¥:›<dşkZ©¥y{9È@Ş•\"B<R` 	à¦\nŠÂàºàQW(<ÚÊàé©¶q¦j}`N©‚¾\$€[†é¢@Íibàğ¨ªf¦V%Â(Wj:2š(›zù¯Å›°N`°»< [BÚš:k¹ØºÊš›]¢ªpiuC¤,´Èä©Ã9„«³e›j&ÚSlàh~®ÒNì›s;¶;9¶Õu@.<1ùÁ›|äP!€÷«zCÀİ	•	›—¯{œ`º°Q!•Œ…5¦4e¦d¹G‚hr å§÷Pà§Š}Ú{¦FZrV:—«‹Á«Ä¿»ZÀÄÍ|àPúÂWZ¬¯:°ºd¹›~!‡}­X³V)º¹‘©p4ªÂ“®ï.\$\0C£–Vóº©€ƒÀ{@”\n`	ÀÆ<f´¼;dc'„\rÛÔ,\0t~xŞN„÷¼Üy½ Ë½kECÊFK\"Zó@\\C„ešD.GfºIÁ8ƒÍ¤àŒ¥CÄ¥Y©§q9TÉCU[‰Àzê•^*ÎJ¼K¸ÍVDìØŠô©&²ÊİbÌ·KK+øÄ²¹,C€„ªí,N!Îê\r3öYøPä³9õ\$Z·ŒnÒ\$Sâ ø5¸\ràùaKŠEÑn•71Z®ŠË3eµëJØœx5ˆQû. ª\n@’©€ÛÇ£pï´Pí²Ñ¡Ö½n\rır|*r­ó% R•×è”ŠÈ)ñÒ#ÅÈ=W\0ŞB¤çz*†WÍìÊMCå _`èıîõûPŠöTâ5Û¦WU(\0¸à\\W×¥&`˜œaÕj)«ÅVœWÂÊ§Êb’fšO¼rUà›ÏÇ¼~#cUró‚5â`Ñ§§Gd€¾—ÀP²İfW¬“£ü°ÀYj`û¦ÇŒ\nò©ŞGá>K”h’ƒÜÇ¿œ¶[MfÑgÌ—­|Ù\"@s\r!Õ_cÖâİõ\\vÙOGèÿÖnÔ¹ÈËgO\\uieéŠ[ñmzÍŸY9âÙ^»\";¾¿çïİÂµ'{r¬*˜\rÉìÔºY¥ÌÔbö\$ê×?Nïí¥!YHü&ƒ‡)BB-S† /e&á>¬SVvowô\rÄe4Ûu8–8sPä<^B§šä>½ZÖ5[\0dıy6W4ŸBƒ•ô5é1a‰\0èI\nCÖ9ïîÁ-î;¾¾ô3…:bƒ¶xdÀ~ãQ#ÀŸ;÷‚:Yh×û:Ç•éÓªç£V\r‚2\$íJ/{z éúßk»¢i½nG½?|Ä•Vuß.wÍ´Ø=pµIü¥HÄ€X=Şø·±Şt‘–¸ -§™MJ¨£pTk‡p!€FG¼Ípşá3dWC˜Fç€Rv@©À\0¢Î èGG\0¡î¬\nCÈ\0d›‘@ÀâÆŸdpŸ0–.ğj“ƒ@¸7¼³ètKÃàNØ½x²ÄÓ5øL<BX²Ô„/YI¸•áfÜÁ‘ĞFpÒŸP)/|,*dK	’ô.ˆUd\$‚ğI\0°D§Àè7\0YvÙ0TÈ(AP€u\rpoF˜±3ÁTcàT{á	Èó\\AM#À2kàG}’§\0Àdƒ¤ ÒT¦@ !\r0{&ĞFî¸?y¥¯·Ké©Yz‘Ãœ/ÄµA@Ì\0¦³0:!ã0ƒËã~¼%9À#ü“¤BÈâ„pœx8èD’ÍDöì]»	ınÆ€£íENëâ\">IÅ‰©r0ñä˜–õ–ÅoC¡ˆS0Tê/p9ğÎÎZ'>\$‚†œ/¡¶È3o£Aİ(`ğá¾HºÂ¥æ‚J†°Å…Õ›I‡pÒaĞh'\r2\n,—ƒĞ¿àä4×”e\"¡¨MzØe‘Îà+C?EğG…â/ibÈP€bÀ˜ñš§€#‡²ZBÀY\0X OB4êÂ î7y	j¯Dr\${Ö¡Ä¥\n·‰\0æĞı ¡„l%5KçÖØÑÄí'DK^Û¸ašuc*4‡«à–ø2òB‹äTÉú§Û!ZÇ’MEøK²ş*Ê¡EŒXÃT»`2\rÑÎà<)ÒÀ²ä\"#B'PVeùÚ³ø–¢Eğ,Iü’æwX£¾Iˆb'\0W–0\"ö+(L )Ó aUJ¬|šò2ªÇ–5œy\rŒUIæã09S²ÆpéªúSé_ƒ|À!¹f¤ˆ›\$ÈÖ08B}ap¢“Æ†¸‰±¼é+îM)dYbŞÀˆh\0:â%Bº–ÌûL¦r©g˜ÊÄ°Ÿjé6rG£c\nÚ¢6Àt#Ùj¡4Ë\"İ\0¤ºj´l‹‹˜íÇu‡÷MH¯İ<…óƒ(_î 7£rLêÃ—SìWCĞuÙmÅ\n^–İËêrŒ~ÇÍõp\0]fûb‘ïß\\øÈ¹r@PîSšya@Éßàa\r˜#Ì°eû–:=áP( ­Š¸P\n%€2~ ¯P!mŞAçÔ&ˆä0I\rZC²€¡ëQc\"0ı¿PVe‘Š¤7!ÔP™€R8’;õ\$xXó§«\rWjäP‘=LÆñfõ«!xà(:\"¼á\\Wù|'ÀÚVÄœS\"•G=ÎŒ­“™`~Õ0P·|_ËØ\\5©¬Õõ'ğ¨™‰/˜¸÷èY@Àù#øTá#»€.¨+ğÆ?Q,Ê|Ãè¨M\n{) ÜJP}GÔ”PA¥;ç±¼	¢1w”ˆ×DÔ‰C‹8äCF(§å?(éKF¸(Ğ¨,zÑ–U¥‰·kÁ¡Ó^Nópí2l©\n9y˜`Ğ¢„£@¢ç¼Uy B\"5¨ÿ\0%*¯`0Ó’³,à‰TDRÂ–³)¥±&xVŸM=òk/\\µ\\í&èêŠ\\Ï¸`tµÈç7'¢\\ÍÆóc]#%CË™Ë‚8Eİ.âİKî]‚ât¾È©	ØëÆÎo´¸J\0À˜’qNj\r:«Ù«}Uìb éÕÒiF%°dÕ¬Nk¬Q9!TV¯Z<É’i\"å[§<ySb±Ä_äüù˜Ä)ƒÀ>™¢M®dŒÄ\\f¥¥ Œ§‡?’¦¥âJÄxª±!ò`/¡À\rc1¬@D´!¾8@ á=€D9´>·Ì&€ ÛYå6‚bÇv7Rã—ˆAŞ,á•‹¢]LùìÛæâió‡£@ogÌ¾Î\"“b¬|Sî&ú# ¸ˆÈr\"Uš8f’ç3À¤û„šYg`	Ã¨Ï:#\\DM•ª1}9«Î¡Ğ<„†äÑi«˜Ò(¾¨6A-ÈÀZá¡Î˜•!º_X	\0bÔÎ‰Ş.\r+DƒÖ³‡s·Pú@äÀ11¸& -G	/À¸6!DÏAu<\0ï€[=HONz³¨H@ZÇ,s¡	„ç¨3¹ä=½3¡WM'à1ƒZ|Óè1úç…ÒË¡lPø'üõ*O’Sç\nœúB?éöÎŒ­@#[JCBéÑƒP^y!uøF2€¤äP²E1EÏş/ /ş\0æ»Ö„Â­ò(@û9yÄNq aıs;cÌq4:+±€ Ğxt &ÀÈ!†´àkCè|åš 	Îˆàc¢M'@0¡ôqCpÜÚ¨²z-Ï¬na¸¢øJ§ü¹µ\nt„3K<àôß.‰·©È'@mšˆ…f§7UbQÚjaA›x‚ckÇ’í@â»êÔæ.FSFJ‡“RKËÖKå9à¾N…@Rñ`ÇÚƒÈ0{S…0_Ô1\nmñÆ\nÕ&|XåÁ\$Ş6<D#Ô,êX‘PGrJ)RF’æ“?ÄıS-:¿eĞŸQ*”ı-«<²ÄJT~Hñ a`PÇKÇA,Ç@yB\n`nÖ é…ğáOkˆfD‹M`96dã\"óNZt)v‡•ÍåZC\nâˆ¯Ie¼TAQL¸”V^És²¾:{*Ò\rªPÀÍN8)\"¡dÏJYDödQ@\rÙpÅš}@àÈÀ;SÕ¨òŠx´¨ÊRËåBòPúŒìù,»9¶‹Ì¢Jp—,‘`/¢YN‚-J\"8¯Ô7õ)”°¬fS\"`…’\$2ÛX“×M‡6¨D1*¥ ì@9\$å“)Ë2ş•©ÌªÜ5TH%’±UôOybàÊøÖc™‰éàUĞ@ˆµ¨Ê¦©eãÈjJ\0\0*%Æ`\"’øPhŸVÛ+-Y¯G­YÖ¸BH¯”¡ÿë\06ƒ?Ö¬ÊºİbƒşœâRJÈ õIÀ“SWõ<¦è¼O4¸Ö¦°´4'/a0 *=jŒÊ³ñİµª¬\nyUd˜óX”m—ğ§¬s\0m²Ò¶Õˆ¬­nDÊá•ò¸©»­ÕcHù[èj±¡#,•¬ë&‚R¦;+ÎZ†Ó•ÓäŒ1¹2² ¦t•1¤›jL‰R–f@&t2Â÷SƒÓ,¿¤Õ{SÚæöm:cDtPÚI(bÓĞ’—I¥Uàg¬º½‰m¨!ÇÕhN1`“)Ê¨À*„HÅ”l|ÑËXT®Î\$H^@òe¨&‚f ²Å”A1‘ÄõDi!	É€Ö{\r§TÀ)Yê˜(³TÂ\n¯\$#·¬kNÂÀP\nk)¼6ˆBŸw'¾`\"ææNğÏDğ&\$	`Eà€Š×0,B§\rgu8\n,`5«(ÙNOD„00TÍP„ÜÍü¦Í¯¤k[®V•l\r'\$ F…»`ql)@J¤\"²ˆ,ådÒ\n€¤(h/ À4HÓ¼ËĞ? v8œKGpÉ Q\0ù`AÀá#…9iá\nºt%„Ï©Â}Ôi‹=¨DV=R;³Šck!(\r–:EFa`¢H§ÜyI÷›ı£ËŒV\0)­[4r?`å‡”v‘ÁÒ§ˆ.Ñäìåd’KY1?!º³µ~Œ¤Ğ0©>Kv¨„ÚìÇ'§ŞÉ¶Î²@Š,”xû\\(ÎëÙ5Eº•ª\"˜æíÎ+Û/®Ø\0'	òëì>BæNu+€w*aT‹Î]Åµá4(L˜ŞH@ÚªšKçÕAèE\0ñ=ŠÎœåÅ®4Ëˆ\0tPmÀcEœ›š|T5¢³ À®F5z‹822\0©€ÌR°7âè&©xğ0/¬\0`<¬J_–B¦aOBDÊ£µ¨iM†0Il¹°Šc–Ê …8?Ó1®9i2ZÍÑ¨\\Z`YÈv§BXå¥@Î 2#ğxdeÀÁË¦æâË]8%·PÛ®§^D˜]b¼å²…NEs\0\0°a…CnÛ\0Æ+H\rW@,˜™(oµpµÌt\rb+¯I½–ïŒ»ı?¬^»Á\$Ñ–…vÅA/xÉ\nšWh!¥WıjÕ\$È„‰*cHõåîÜÃ{Î^P\rÌ#«l€å{'É&¡Œ@p«`C/Œk`ÇİÖ»z*+Ï\$¥º‡\r\n÷wÃO\nÒ€u|»æÊà”7Nİ×ÂÖ±¹‹SÙcê´¬\$—pÉY–æù‚¢Ò“\\ÅŠ1|™ÏñOPªEÏÂe,qÚGÈwœ¾ü×oGÛúnè\${í FÎ'iƒf€«Ç…­<»•ôô+|¡C`^M6ï‹Ì0>\nØÀ{ß,ß‚8´µÓc–Á3r°Qvá6Äî\n8ùÀWÚÉßnêG‚WÑ|ÒÒ5©èâ||pfSf9\$lÌe?_bFÉ#wh’P\0]ÂFìtrÕ\r_`Cé e¡4Š:^t^Ua†ƒzêÄÕ'nË£`dô·Xáºï«´X•¬wi~¡İ*q€5\0õˆª|‡˜öÛÆ°Ç*¬9_1\n¸aÌC‚ ¤•dƒş^.ÁÁgâÑQÄ2çXøÈğ‹Î£BÀ]ØkªLi×{71> ØzáÄ0x 7ƒ+Šgt’3V¸\r´Â	h +*póªÁ–y%Ş8y#§”ªóøTÃL±åÇ+0KÓ'ÃqÓh@vL‹Ğ ` ¡¬Ohkã\r–d¤Eˆl\\šœdp^êÜæ4ñd!å\\‡XéÆXE“«ŸVè\"‰8òÏ…T€Õ.%6€m°¤ù‹Æ®Öq¶úw€{c`d0<§ksY¢	zb,ÔÒ0\nÈ¹rò2<l¯¿ \nœ)z€ÔÃµÂ<\rIe4A©'ú°5/Âä6âOÍÆĞzh€Á6¿W¸pRn!‘lš'7\nÃ@ëpğÎ5?ä4BşÙ(Üz§@ã\0}Ç ½Ël¼ƒ‘RÈùP¸‹q‹ŠªeWŒI«4\\9]ÂîNa!d1²„¤[Ä€.Ëˆñ¾AªÅA•*–6ğ£² ĞÜ:ø¬³áa‘;¢0C çDDj“øì 7ÒâY2x4K	!I¤}Èñp<ZÒ’\r–°A¥Ã`êKÒ’Â*¿\r ’Ø%úWWË#!ıh@\\ÔºJ\0Á9¢3ÆX2\\LŞ‘á¤–„…))#ÔÏRc4f>fYRm©pÉÁ|Y¼öHé,}ŠLf­_t¤ÍzÙÆhJ7á, L\"\rÆÈœ¬qÁ»ÍiŸN¸±,ôWË7ô¥Ií’€ŒÚfÛ7&ÍÑÚãeæGÑ 6‘h|BQ\$ĞŒÔã6%C=~|qï¨çø`(øÎ˜*}gr¾K<Ïjb3Ş§mbH2NÕ+ƒıuÃğâ”L·œúS¦!Uê>µá\rşi³<¾bupè±…Cë4Q'·E…½• e3±­\rE·*á —¯gœ8à§8+Géå‘ÿ…,[¤nîªóÅ}Šófã¸æã´&;ÎØ–}„Qt9êBÒ•Ø=g2‹—FàöÇº\$1ï€œsbîî“â),9`o`w!Í·`L&[Ÿ#2¸å·¨SñÇ²Ë“+²{RA´Ğ„]ÓFE%Ñ©¶†Tòè»ªºÔ~'€u©mê•pú¡ÑÆ£±9‰\0µ—ïUÊÑĞæ5O¢åØ!ééÖS Œx‹Ú°İ2ZQ½ùÃï9]f XDPÓÆ)œÖQ{4÷Y¸±b°@m‹SQŞá~Ç¼%ñŠ¯×8ÕC;FëË&¸18`÷>CåüÅõß‹%P’hX%„ô€ójGE%†ê‡×œ@õë>{ÕÑdµ²è°\\ÇN„w_w×Ö·-(ı„çamÊØ\"€]JFZÙgğlPlB†¬Ä ƒí»®dõˆ³ë°à[Ğ¨M4.u[cìŒ›bLƒ¹¥š_ë•Ì[*ÃŞ‚1ƒ†# è}{YÍñz¤·²…%‰ÿei÷qò\"R‹åª©ëû¥‚¦õGíì\r»	ÎÀï°GÍëª™›JØ@FJ.2Em>§ûQ8ÔÅ{µQ;n^¦§ Î\\ğ>NÌd\0ctÊ„¬æŒ?l%%ÃvÀÆ´€ÎZx| yĞPX/ÿ´ví À_ƒ`½öÔ\$\n CmÂ¾~Ìš@ë”\r3f[x†ãöÅ²É¸÷	íbÈµZíJ¨Ûoºé2]+å±•Ç2ÀÅ&¯5¬y î`¢ÚŠh Æ	¶üg„ÍÎöÇ\rÕ§Ÿ>\0©ìÙnÍ½Ê6×ª2ÀbWg='¦ï€»Í^JéyHnÓ/€]ˆmob[^nV¶ƒ~j\\M1ëÏÍŞâ€KvÖ€k@-º:ˆ.Û}0NÎ§UA®9hF_i¶èá@Gt„Ì\\‘ïƒO†Mßûıx!§‰h¹¿#º9xVŠ=ïğ”\n›yI„,;\0°\"yP3ñ¦\0.¼Nùsâƒ¨J~áUãëšò\$öÇã\0Ìå!y¼‰×˜RÀàLÖ(^S¬½Äˆ½»‰SÖVV&\\'ê:ÀóœHÌ9Pî~äEÌ	à‚‚Ép”ï¨RÊ4içI|*›°Üî'£L«´™o(ñ¤:íglpáD³ŞğA÷ÀÅi×YCUÙNöØÿj¼gpa~YÚvW¦{\n}†u³¨É	lÎ)À\"£€g23ğä†‚3Ã\nLƒnQÀ´­s×pñB¢µ@¿”ÄÑ«à\nù6‘p[Ná©àÏÙ„›¾]\"ãƒz\n=Ğ1”)•ïP†~ÊRwŠRRËH†Iº;d°¬|¼Ôg`g™Úİ„‰ù¢QÒ^ŒğÇÊ>°PEq»1_û„·8çäãîd£÷E Ûziğ*`<cê‘»„äùßI–Xst!\\õqõâjŠá\rªs«,áÜŒh]j¥¼Èt1w€n%ÔjÀ^  9®`|²‹[÷¦»¯Ş§ÛÂ™Z6ğ©Ñ)å¿œı>-BCÑ]ÂğòˆÛËHä†+S\$ô¢{‘_GAÑì+î¦iİÊ8wv‡—×ĞRÔ:Aåı,9ej'Nl¢úyŞ«›£ê“.zyÀˆL&s9,ÃØÜÅ/fœ+òáÉ×ñVYÓ£ÓØ;>8S¦{`úåFÀ¸ó#™BÏæfµÚ‡¶±Z„S@«ÒÜÜ—zBT+}‚N‘rÏ·\\ß¡k†ëe¾Ñ`(›úßİHˆ@P½U‹éÙ÷DÓÀ¸™²†‘Ù\0„®—<yµp<KÅW€ï±(ØH]d\n¦(=œ–Z‘úÍ†Mu=“ºqÌŸWº©Ëòğ^ñ\"ìÆNBs™àÅæƒ:ÉñI6v’Ÿb»ÉÏA‰mÏ´_€V‚ñD€Æx0œI6pY	‰@‹¥W«¡ÓeÕ?yr¾Âe3ÉÛ·8ñ»}¨Nàu:Y\"»Æd™?Ücå˜¹I·îd³RMIÒ³›)1î­Öiealùw_>¼¤ï¨Òä—AE%Ù)İå/ÖÑdÄ’êğg39\nº®uÏ²•ŒíWÇ»b_ñV—®á_Î÷ÃP5ƒÓ\"µõÔ¯½İ`eÿ|îjIaã^rÚA!\\‰å\0Yş]Ís%ôo“Ó™øâ=Hø‘È2í®LKä?÷¿ıì4Û(ü”€GSB^`´!İüÁİû•–›î³ı´é^BHïÉ<ZEÅ%˜€ü]W/\rPå!Pİì(œ.Vé}ü\0ò(„ÀWç05;\\\$+@º*<+w!¢¢ÂŠ@bH[\na„§øağŸ*¼ü¾¼.^“\$Ds\$p»Ñät3\\ïz„p°éÄ@D' Xò½KŞy?ø01xÆ\$†b\\¥ë¼°!Ğ‘¾:nCSò>áK+)—ƒ*L¼™şf§ç[§Ø°‡ƒ½~ìë¢Ù‚_öÛ‚ûºô£É.~2K¸ınœá²ChØağIƒ¼¿©ù³¾CCÿ¤óu)2xŠLÙAöŸ‰Ë)®91ÉË]æKOÁ<ùéï¥×Ü²u`«í{ÚÂãÃccQe·–´Üõˆ¶gÇšm÷æ™’&dL³1¢„O)sÀŞG\"‘„	Ø.¶…Ø»Š…FmÖÈ¸ä‹X€Ê8İ´5bŸÀÃQˆ³ZšºÿåP¹ùc±uòşºüÄ?3%ˆÀìhRÌ¢}0&h—Ê İ€¼*}GÆÄ²Pp£°¨ß0ˆ|Y­g_qÖÏh³_°çìc_VË\\EôùUğh _ûOÙqQÄK„5ÿt\r8D`QöîušÂÿ(*÷Í&Ü„:À%&c‘J¥Sİ›áRU%/‹)ˆDÛ³~ºSğqúÚ€p©ù¡q~êI·4EÅÔæÏÏÄvpF³-É¬Ğ02™Ê§õ¶gMÈLup;Ü³¨à}èÜ‹Ò®Ÿ\nós€ xªqûúPÓ©W\0\0X›ƒ¹p‡ƒ°UøUHš…‘¦ÌŞd\r[\"ºœÎ¯×£h^oBJ¢Ÿ`ÅãW³ˆ0\rĞ÷ÿÌ-ğ’gı)»ãJ+ZÏ–éä7áÁÕ\\BÚ˜â*ç¬€˜\0‡< ›ıàÜF”\0áÜ†±5H.€èÿ“^ğ€Ú«FE”d‘sùˆ2›ò	¸ˆ\n´¼J-9Jok ‡\0É?Æ¤0:l!º|i²³–ATÅ;I©õQ¨¿AX&Cè£¡M@rl‚¡…L¹€MhŠè2ú ˜ÑÖ0÷@¿HÆ‚è\$ğ)€ìƒá:oú*k<Ç“¬v<A`€zy”‚EÀŠB0ØŸ€¼CèÍ1€Z ªw¯…« ¨dË#“Räˆ')ÿy±.vÃÄ>ª˜¡h SYş°p!@rì\ro¥	ØÕ°\rƒvàqşÄk@óĞH€O™UğG ĞÄ°q0B\">F°CáQKĞ-´ê4ÀÁMwPX ù°LQÙ¡ÒÁ=<ğQÁr’Øôa´@@A\"_ƒÄĞhé	Ä\rŒŒ€¼t8­›”%õúb†¬Æ@›\0x3Y™DÃ<@¼ƒ£f°\r:k:\rsÀù\\@OH¿P=hQ”\\ÀüU`M\$AğÕïû›ò8&€›Az>¤ ;¾¨vAĞJ\n šÎü ÆAHì ğF‘† œÀÁ!Ô0Á8Ud\"pA„-¸—°xBHìáL¬ºÍÁ¿şdtZÂC0s°›Áf§ÈRÏÁä|\n4ş©<(6J¢x~°›À­ì\0†.—”'Î¬·è9Ä*ä†ˆ<ûBp¿âl¡ÜŠµ\nğ…’È.0›À¬y€ifµ†ºªm¥XB¦&í\$=XFA@4\\œ3ˆxi}ª²Q[@CL0°Ã\08´/A*Z`g¹‰\"œB©ÂC\r8ğÄ¶Œ\nºZ>Šv+åÄş@Ö‚£0R¨üßËÿ!Å'¨£ğS‰©!hD|Ê?C^3Kà³påbóL˜…!œ>Å\n9(a€Ä†7 \0fyB¾Ëå¹Ü	qÀ†€àH\\m?¢Òüî‘N9	ç€Œ41:	‹«Jì²ı£Ê Jê)ŒÈÑ°D£™óô,=ùpè&À%(áÖ\"]ğ#PåĞ¶DKå·ò¾XS‹å¢d„™\nÃO)\n˜XkŠDƒÂÚùk¿z¾[¥d{@œöÂcà‡`\0sEpi h2¢–‚Pƒ¨¦‚HÄ(pÿë	@Œ‡&¨1ğv\0VàÅV'n(W`¢‹qÎ9€àÕå[À½¹ãad€d¾üF‘‡bàˆ G'0ÄJŠ¼DáË\0ØÿdE`œ‹X<ôEğî\0ôÈ\0\0ĞÔFf1ÄjFIq•åÉqDŠ:P¢1ªø¤v/•t9`7l:\"a.ê8Œ<ä½ÌEjVé\\™Œ#œ>À—CëswF3ˆ’€ùå CÈİÙìN’9¼PÄ?·6‘x( ");}elseif($_GET["file"]=="jush.js"){header("Content-Type: text/javascript; charset=utf-8");echo
lzw_decompress("v0œF£©ÌĞ==˜ÎFS	ĞÊ_6MÆ³˜èèr:™E‡CI´Êo:C„”Xc‚\ræØ„J(:=ŸE†¦a28¡xğ¸?Ä'ƒi°SANN‘ùğxs…NBáÌVl0›ŒçS	œËUl(D|Ò„çÊP¦À>šE†ã©¶yHchäÂ-3Eb“å ¸b½ßpEÁpÿ9.Š˜Ì~\n?Kb±iw|È`Ç÷d.¼x8EN¦ã!”Í2™‡3©ˆá\r‡ÑYÌèy6GFmY8o7\n\r³0¤÷\0DbcÓ!¾Q7Ğ¨d8‹Áì~‘¬N)ùEĞ³`ôNsßğ`ÆS)ĞOé—·ç/º<xÆ9o»ÔåµÁì3n«®2»!r¼:;ã+Â9ˆCÈ¨®‰Ã\n<ñ`Èó¯bè\\š?`†4\r#`È<¯BeãB#¤N Üã\r.D`¬«jê4ÿpéar°øã¢º÷>ò8Ó\$Éc ¾1Écœ ¡c êİê{n7ÀÃ¡ƒAğNÊRLi\r1À¾ø!£(æjÂ´®+Âê62ÀXÊ8+Êâàä.\rÍÎôƒÎ!x¼åƒhù'ãâˆ6Sğ\0RïÔôñOÒ\n¼…1(W0…ãœÇ7qœë:NÃE:68n+äÕ´5_(®s \rã”ê‰/m6PÔ@ÃEQàÄ9\n¨V-‹Áó\"¦.:åJÏ8weÎq½|Ø‡³XĞ]µİY XÁeåzWâü 7âûZ1íhQfÙãu£jÑ4Z{p\\AUËJ<õ†káÁ@¼ÉÃà@„}&„ˆL7U°wuYhÔ2¸È@ûu  Pà7ËA†hèÌò°Ş3Ã›êçXEÍ…Zˆ]­lá@MplvÂ)æ ÁÁHW‘‘Ôy>Y-øYŸè/«›ªÁî hC [*‹ûFã­#~†!Ğ`ô\r#0PïCË—f ·¶¡îÃ\\î›¶‡É^Ã%B<\\½fˆŞ±ÅáĞİã&/¦O‚ğL\\jF¨jZ£1«\\:Æ´>N¹¯XaFÃAÀ³²ğÃØÍf…h{\"s\n×64‡ÜøÒ…¼?Ä8Ü^p\"ë°ñÈ¸\\Úe(¸PƒNµìq[g¸Árÿ&Â}PhÊà¡ÀWÙí*Şír_sËP‡hà¼àĞ\nÛËÃomõ¿¥Ãê—Ó#§¡.Á\0@épdW ²\$Òº°QÛ½Tl0† ¾ÃHdHë)š‡ÛÙÀ)PÓÜØHgàıUş„ªBèe\r†t:‡Õ\0)\"Åtô,´œ’ÛÇ[(DøO\nR8!†Æ¬ÖšğÜlAüV…¨4 hà£Sq<à@}ÃëÊgK±]®àè]â=90°'€åâøwA<‚ƒĞÑaÁ~€òWšæƒD|A´††2ÓXÙU2àéyÅŠŠ=¡p)«\0P	˜s€µn…3îr„f\0¢F…·ºvÒÌG®ÁI@é%¤”Ÿ+Àö_I`¶ÌôÅ\r.ƒ N²ºËKI…[”Ê–SJò©¾aUf›Szûƒ«M§ô„%¬·\"Q|9€¨Bc§aÁq\0©8Ÿ#Ò<a„³:z1Ufª·>îZ¹l‰‰¹ÓÀe5#U@iUGÂ‚™©n¨%Ò°s¦„Ë;gxL´pPš?BçŒÊQ\\—b„ÿé¾’Q„=7:¸¯İ¡Qº\r:ƒtì¥:y(Å ×\nÛd)¹ĞÒ\nÁX; ‹ìêCaA¬\ráİñŸP¨GHù!¡ ¢@È9\n\nAl~H úªV\nsªÉÕ«Æ¯ÕbBr£ªö„’­²ßû3ƒ\rP¿%¢Ñ„\r}b/‰Î‘\$“5§PëCä\"wÌB_çÉUÕgAtë¤ô…å¤…é^QÄåUÉÄÖj™Áí Bvhì¡„4‡)¹ã+ª)<–j^<Lóà4U* õBg ëĞæè*nÊ–è-ÿÜõÓ	9O\$´‰Ø·zyM™3„\\9Üè˜.oŠ¶šÌë¸E(iåàœÄÓ7	tßšé-&¢\nj!\rÀyœyàD1gğÒö]«ÜyRÔ7\"ğæ§·ƒˆ~ÀíàÜ)TZ0E9MåYZtXe!İf†@ç{È¬yl	8‡;¦ƒR{„ë8‡Ä®ÁeØ+ULñ'‚F²1ıøæ8PE5-	Ğ_!Ô7…ó [2‰JËÁ;‡HR²éÇ¹€8pç—²İ‡@™£0,Õ®psK0\r¿4”¢\$sJ¾Ã4ÉDZ©ÕI¢™'\$cL”R–MpY&ü½Íiçz3GÍzÒšJ%ÁÌPÜ-„[É/xç³T¾{p¶§z‹CÖvµ¥Ó:ƒV'\\–’KJa¨ÃMƒ&º°£Ó¾\"à²eo^Q+h^âĞiTğ1ªORäl«,5[İ˜\$¹·)¬ôjLÆU`£SË`Z^ğ|€‡r½=Ğ÷nç™»–˜TU	1Hyk›Çt+\0váD¿\r	<œàÆ™ìñjG”­tÆ*3%k›YÜ²T*İ|\"CŠülhE§(È\rÃ8r‡×{Üñ0å²×şÙDÜ_Œ‡.6Ğ¸è;ãü‡„rBjƒO'Ûœ¥¥Ï>\$¤Ô`^6™Ì9‘#¸¨§æ4Xş¥mh8:êûc‹ş0ø×;Ø/Ô‰·¿¹Ø;ä\\'( î„tú'+™òı¯Ì·°^]­±NÑv¹ç#Ç,ëvğ×ÃOÏiÏ–©>·Ş<SïA\\€\\îµü!Ø3*tl`÷u\0p'è7…Pà9·bsœ{Àv®{·ü7ˆ\"{ÛÆrîaÖ(¿^æ¼İE÷úÿë¹gÒÜ/¡øUÄ9g¶î÷/ÈÔ`Ä\nL\n)À†‚(Aúağ\" çØ	Á&„PøÂ@O\nå¸«0†(M&©FJ'Ú! …0Š<ïHëîÂçÆù¥*Ì|ìÆ*çOZím*n/bî/ö®Ôˆ¹.ìâ©o\0ÎÊdnÎ)ùi:RÎëP2êmµ\0/vìOX÷ğøLŒ °\"øÎŠâ/…’…œ ÈN <Mè{Î­/pæotìS\0Pöî¸ÛP^ä€³Ï„l«<øáÎäîB÷0	ozö‚¬©í0bËĞ­°ğğ\$ñp¹ĞŸ	¾÷sÎ{\n­Æi\rod\roi\rğœïi	Pè÷Ğ¥ÌÊøPjöp\rë.»nÅF¶é€ b¾i¶Ãqğ.ÌÌ½\rNQP'—pFaĞJîÎôLõ\n1<àÆ\rÀÍpı±MPå°	P¦ÉdÚèĞs¤M \\©\ng§ìÀÂ Ø\$QG‘S•„d‰ÆÊ8\$¶ªkşDâjÖ¢Ô†Åö&€Ó€Ê ¶à‚Ñ¬™± {°›ñ{\\ÕÀúºÀPØ ~Ø¬6eö½¬2%Íx\"quàÊ¾`A!Ëï ‘ÂZelf\0ÒZ), ,^Ê`ŞŠ±ºÈ NÀ±8Bñíš™èùrP€© ©ÃkFJÂÂP>VÆØÔp¨²l%2rÂvmĞó+Ø@ä’G(²O¨s\$ dÕÌœv†\"ÈpòwÇÆ6§æ}(VÌKË ‚K¬L Â¾¤À²( Åø(².r2\r’6ÃÌ¤Ê€Q ²€%’„ÔdJ¨¦HÀNxK:\n ¤	 †%fn‹ã³)À¿DÌMü À[&âT\r©ÀrÂ.¦LLè&W/@h6@êE ÈãLP‚vÆC’ß\"6O<Yh^mn6£n¼j>7`z`Ní\\Ùj\rgô\rÈi5É\$\"@¾[`Â¢hMÿ6ƒq6ä’ş\0ÖµÈúys\\`ÖDÀæ\$\0äQOh1ƒ&‚\"~0€¸`ø£\nbşG¼)	Y=À[>ªdBå5RØ‰*\r\0c?K|İ8Ó¾`ºÀÀO7J5@Àå9 CAÀÂW*	@€N<g¿9Ól7S£:s«B‰{?¦LÂ.3´DÄê\rÅš¯x¹%,(,rñ\0o{3\0åÏOF‹	«Î]3tm‹‘õ\0”DTqÄVt	”Q5Gô›HTtkT¢%Q_Jt•AEÕG’Ä‚\".sˆÓ¤ ÃÆ<g,V`SKl,|“j7#w;LTq´Ù9ô8l-4ãPÕmòqªÊ\n@ÊàŠ5\0P!`\\\r@Ş\"CÆ-\0RRˆtFH8µ|NíÆ-€Ædòg€‡Ò\rÀ¾)FÆ*h—`ö €CNôÿ5ÊkMORf@w7Âß3‚Á2\"äŒ´ÓE4“MTõ5Œ,\"ôà'¼êx§Œy—VB%V„“VÕTÓ5YOTâIFz	#XP‡>¨âf­É-W[Íšİ\n¤pUJ´Õ€Ôt`7@¶ÂÒ,?’á#@Ñ#ˆªµ£}Rñù6‡6U_Y\n¤)õ&¸‹Œ0o>>´Å:i¨Lk÷2	´Äu& é¾©…rYi”Õé-WU½7-\\šU%Rí^­G>‘ZQjÔ‡™%Ä¬i”ÖMsWƒS'ib	f²Ñv¦´™å:êSB|i¢ YÂ¦ƒà8	vÊ#é”Dª4`‡†.€Ëbs~ÅM‰cUöŠuú™Vz`ZJ	igºİ@Cimëe	\"móe’¶6ÔéMòøÖD‘T×CTİ[íZÜÍĞ†ÍòpèÒ¶âQvçm”7mÖî{¶ôÅCœ\r¶L–ÁXjª úí5µT–÷`´»7UXT€@xè¹03eŠ	8Â”¡¶Ò=ÂÔàÃ#–¡jB¡&Üß#·^ ä#ÄoíæXf È\r ìJhô˜“ú´5®tî|õãm 3û/¶ÌoÓ¬D´y‡äÂb´àˆş—{wîš9¦‘ íc±ã[ÑÙ)è\r*R¨pL7êÎ—Ü&—à¼l¬Z-í¬wÛ~Œr—Ü@iU}Í¿~ò³|WÈ—mÔSBÀ\r@Â ‚*BD.7ñ,‘3K\\V Ç<XÑƒİä‡qh@•:@ŞÀÊ+|x<ø¼`á„O`™Ì˜ßÌ_c5ÙR­[ÀQbä]€õ1]…úp¦f€wÕ\"â3XW~&nÂ«M]²1^8÷äQà?¸?~’=‰Í3Šß.Wi#¬¨\"ØWòß.2çŒL«~RÀW5ŠVlO-€\0¾ÉÕ…qj×•…Â×h\rqmS¢tÎøû…o„Ì0!øş†ğĞ½ĞğOCë¹-1@\r•;’° àØ-‡À]ƒ\$XÌŠĞÎò\\\0¾0NÊïÃÑ†µ'mH;‡Xy‚õ&¼8—xÜ\r†…É…lÁ‹yWPÊ7ä<özSlÈ'LÒøY‘ ÊÎ¹*Ï¬ÖËì¢ÍÄ±™yŠçìğÌ\r¾Ï ÂÏò°Üx:ĞÖ›“x07y?ƒ‚…YEzå¸ŒùS‡ÙY‡}‡yÅ–4ÖÂcRIdBOkË5¸“ŠíÌ‚Œ+MÌ]ŸõŠ†oŒ3 €ç ØÔßÊw–ÀË—‘›¢“V1`9=ƒdAgyÛ†ØŸ]u/–B1–š#–ê	ŸØ?‰¹{#İ‹`R¡¹¿—Ñ„Çp¬Ò=£X{œx5”>\r¥Õ•U/äjÙã•ø}¥2FXß¥¸—¦ı§i¦ÙÏ€ñäÅí¿§%©šœº>Ïz‹Øo©%í©zLĞZ¥Z¢pYs’yvÊ™%§‰ºjÚo¦W’ÎXN0ƒ—L¢#ú1g€M|ÕÁlÒ`q¹~Ëšüb­J @Ójçè|5/khÒmz³[¶Ê	¯iHr|àX`Sg\"Õ«\0Ëóg7İ‹{Uµ‚µ×é˜;c€ûhJÂ\0ÒÃr[@Ku¶ @ÌmÛ±Àß°º¡`É ¤ÏŸ8­¸º„û’I:¡Û£¡[©¹z¹º#ØimHqû¹ŸIxé+“˜~˜×é€yº¢›@£E–û‰³ Wo8²JØ·ºrÛ–ÕİÃ}ûŸ¾Ûñ…›k‰»ù‹ÜŠx«ˆİ¿ø¥.’=º-ı¬9œš=·ûó¤\n¾l˜);72¸|ÙØßúÍ¤zĞNÚK£zOÁÙ-ˆFˆ¹÷–rŒw¨p+UÒL‡ò‡:!ª%—@¡¼-Rú}–/£º…¾<M¤X»¤•'\\Y­˜¥&»È\n{z¸ËÁø£Œä¼¼›•qŞON?€Ì•CˆÀuŸg¡6Åd­¸A½\$­›8é¯ìx!ë:«¼ûš¹“š¹‘ù™™À\r¹Í9¤ÎÁ¯Ìën€Ï8]›Y¹8®)œŠĞ@u6@SšWXÜµ‹¸ÍÂ¼ÃØÌ:ÌuAÌÜĞ?œÕÍ€CÍÍ×Î9½„­½xZÏ`ùÎéUÏ<÷§œı«˜]Ø]ÌÊ=Ì™›Ñ=Í´šlâ’Ìéš¬ïÒyÑ9¶(Ûß”.\nı6O]:{Ñø×|D®Õ­dôqİÏ\\]FI-òÅ€äÅÌaŠìlÃµLnÌª€v×Æüy{·€9\0’×ˆ5·l„MlÙRm×lÀxb€kæLI­1ëú›@ŞÀ„ÜN·¿Ü»&óÕ²ÕöH‰KÊ¦Iª\rÄÜÃx¬\r²ˆ3Öâé±2,ãs/ÅØÏÂ\$÷äÜÏä‘ÿæ(•æ\rûåJ ~uÔŞEçŞMè2§è`·éô˜™+åvã+ş¾qã¾“ä8Ãä|Ëä¾æ	‘êËèÂ³å³vßÕH­õFpM>Óm<´Ò…OjæŸíî’T1ounÖfzƒÛéï‘JğÁGe–áö+¾ûq\nS%6\"IT5½¹‚R³ğ‚™ğ”J`uóTgğíıY+ŞKe—}ÈjÓ©~‰(ôèrO«ó„ŞÓÿT<Â×İõn~ÿ\\\"ef›~=ğ™ö›±ZŸ‚‰›)Y5gî\"'ZU„¹7\rùB)X1İ;p.<¿zMÿL‰ŸÛØ]â‚yóª9ß°=ß}û`Î`×ôkrU‹²)&VÕî´ãDöb–1\\qÿ@^ô\r­BoĞ=¾(SO|ã€Lùúì”4DŸ.ÿô\"?ùæ/›}ç` ¥'ĞÉıg,A\ròÛ“I.I[ENEL¢àû=üJxÂìKŞıÑM\r€f`@EşÕP`iJJÒR²#‡•&P\$N¡{Ç¾ğç˜½UaP-y³Ö8û¼íÔï=y#ÏŞÂô~¾uèOhyb–™RFÔ›`½éä~ñßÀ÷Ø#\0şa.~ªŸ¨‡ó|ŸÖ\ra².›vS¤›~ïâƒHzŸ>ˆT5ŠÀ#pQzS×Ş˜ö7¨zOO‚üTó12A1ãPO}øœJõåyB\nïd„T'´+G•½©Kj\\\\YÀá õrl½dMæùXŠ`]ø°}'Qqúnƒa\r\$«õº=¸à2pßä§Õ?ª\ne€QÄŞ´³t) \0;ü1EÔae\\°õUã…ÓaPt´´©ØÀ \"øá|ü1ñCV¾ì8!rØ8]´A­í.d£!ám ıBå’¢ş…Ü/a~RA)ùP\n‚©Üá¼óz¢èş°ı\"á š8i,ºól!¢a«XyCº*Äh“Ş›¡‡è½Ò‚Y‚<Cºp‰¾¡“ re²Ìu‡À¬I„øŒG„B»Ş±s¬ôĞ&„4^`mTCbR €\0­vLêA±ˆĞµÔ°Â”<e\0…Qa`ñµõdZ“ÂŠp%èDıÿ@!‰ñ›zzØ©1ı±lR¸•Lu—šø€tV³Â,GôÏ,&w‰‹L^a{=u‹ï\"^³ˆÅœ½’µ%€=6.´€Ò°Ë­™`qI…Œ(\n#%p5<DQèÄº¨UC‡%íjõ4?Ä%gÜä&,¸€Z(@	€E¢‚€’Ğ#¦4Š)h@Œ#òü™Ñ¯ˆ¥£@\$8\n\0Ulnãa(ß4ÀO€Š8â€7‘È(@†ğ&((\n€D¤m#®À#Ÿx\n PÔw#}P*	àDÌyc» PÀO|tc·øÓP	î<m#ô}˜î:>ñı€\0¥ÀˆÅ¥ls#×GR‰pp@„À'	`Q¬}ctp(ÆÊB€eh\0‹˜İ8\nr\"x›!cş>`NŒŒãZ)Dh\n*Fş‘²‚¤z)A‹Ú6±Â\$„czLğ2É\n>òÜ\$’#‰Ç69ñÑ˜¥°!û€´ü Nª‚¾@\$<	Ñ²‘pVƒZÚÆŞ72>Áùcd0 \0´ÀI‘8ı#P'H	²o)¼|@Š€*û\0APP£ˆI1IòN1¶“l‡äÕ&áJIÂD’’œk¤‰#p÷§~M2“dšÅ(CÓÊ\rAR„”øCøĞ&G	r£‘Ò£áÉRB@'•q€%)!ãIV±ñ	ãô™ÂB^/la.ñ°^\0ã<\0ŞÅ	„<• á=*@	‘§-{Mgƒš–‰ÜóÇ'êXë– ±8¥„à·TKŞÀ\"–ªG€é-ÑË\\U—ö\0Ï,‰s9rXn_—´´nS9j€Œ`9—„°eõ.†57^^±—¼¹¡/—KíÂIv—R€O0ÌZbş PX†YÙb˜Îa’È–R¥­.ò¤\0ñ\0&–áR\n™,¹w\0ì©—ñÊÆN2™h €u	(@a2¹i€˜c®¨`ÅD'ÀĞü0\$¯™¹œk,caˆü=\0åìà30˜\r¢+\naÆz ˆ))*µ˜8kà€ÙÇòË–|ÓE(˜G7U¼s!L¸Ó?5tFrgGs›æä3ËÑR³u—ìÃ”½0Ã{l€\\MäŞÀI7Ğ™MıŸ2áœ\\q8idÍâZsŠà€»8éÈùhMÛœİ'-0Ù»Î\"o\"|œYG¼T’ÂŒeTB<\0¥q*s O'P/ôòìœ‹BJ6©İ%²wPôŞ€Y<L\\&C´ñÂv/µOO@Q *›Ğç¦“’/‡À&ÔüøX#7 .\0ªxÂŸL÷Bq<ˆoO°áp	”ïgâşï\rœ‹á0Ñ(a‹?ºOV£º	“!Øª¹ŞŠ6yÀ_„ôf/<ùáOH6f½'™@©àP6xrì €O'‰A6KB“Â%)\0\\D÷ Z\rëè\nÌ¦ëÃzƒI»Ÿ\\ôgòÈ÷PÊƒÔÕÀÄ-z„ğùNE@_9õmNÍ&ªUp¾Ì!DÔpšÄ&4JK`‘ lœ'èØóƒ\0Q€Èœ\r”Ø#÷	:êÙ¶NÁ³ÀmOğñFÆp7á™ÑzŒMŸ‚PaáEÑ‘iÂN\r€Ø‡(NœFQK§¡Â˜†p+”ÕQv*´s£r(ì%óœ2¾Œ¡Ù£9GèÒ6•M\r°¹¯rŠƒZIS1a´Ïzey\r¨÷IT¤Ñ¹:#ÛèåğAfYŠäm”†m'ˆ˜pìş1N¡eÅ)KcFj>›_’.\r+—lzEÑ†£0¤€¢é8Êğ'\0æT“£å(ÿI¨¸Ò–.¡{Ñ“Å·°;@5ô¶-ÀGŠ5K1÷.B0…Á¦{©£&u­—ïTr¦Q©G‡)¹vi¤§xŠMJTR\\n4€/,²)·B‡ÀøÜtä\"1MéÏHZt–‘4^}ƒÅFJMNb¢•§¹Î(ÉJ ¤Œá3 }¨œUj+IŠÓ9‚Õ¤Û©:d\nPğ†Ô£(%-ˆK€‡ElÃÑ§E gš`°T’¥HiV1™¢8ilj]KuÕÒê+TÜ§XÎ£NÚ~SJ+2p…·P¢ŠU`EÔıD9Iv\\€ÔõU%Öª%(ûT:•Õ\r5I«QUIV¢†¢^¬@d«\"¸\\sVÚj”~®	¤¨}@uW8Šõ_´F™*MQÊfSâ¯ud§ı6\nºÆ	s˜F”»àF­ªD•Ğ€eTÈğ€ÈL ø@{ƒ¿ 2‘ş+\$Á*I6IÒn• •¡ƒI,€ÆQUB—ü\n„¢¹.øQôÖ¥éı^tV¦Lâh#lf¢ÓŠEXpZ¥LÌÕ`n™H¶Ö\$7”VZu¥…iéEÊğ†¼B¿­-FI¼B¡Z`;¯x•J‡^òÑ€ôT ¼«† \nâ¶ì#\$şª2M!'ş±Á¬©8ÜkIYf8‘ü’J\nĞHzÄ|\nB@=è—,8UĞ:MX .Ş#øvêƒIbµ–¢ËÓD&1û\$Ø,©¸¡€Úğ;” le†ì*'»Q –>\nò ì8TÚ’Qpß%rKjÅşë'd¶Q¡ºŠâU²XØä;*v-5’Ê¶é¯öÊ€.7Í˜_ô7›-h8Ñ\$YŠÕf8†Í£†|}˜Ú/g4âÌ\n¥Zu˜ìÊd\0ä£-šŸƒ«gÛ4ÙÅVa!°\0rn«4şÏå“í Šf8ÉYá¼¢S³ØuMÔ%;C½EÖ…\r¨ôaayZt\rôsoºÉ‹Mj’­°­«\n¢,².½mV´zºí^_ûUQÌÖå^­œ@Yk‘UÙåJ¶¡×j‹`jcÑú³Ä“kÊ9‘¦×|¶€A­UkãLÛ`g	ìàÅ¦`uL˜fu¢ê-k\"D¦¸6Ş*Õ¸-¯mZlİã°H‘i²Adh4J±.¢¨{G7Ô6´7¸8Î\n*I+Ø¾Æ)Go,ƒ×aÄÃ†®³I°°àã¬j!;\"Xévíå¯­ÃL\"Ò.¸6§)ñ#„«G;Ñ~¢>\$hil?^ZœTÂ^%ƒ,WQ*.æ¤RP¡ñj«ˆ[ô¤j„¹}!îJ˜\\¤‹Á±5}~kî¨K«…ÿWY'®B”J¼«½‹ƒëc\0àÜR–5¹Ú‹@›	Üvâ× °âí‡ÎŠòÜÆ‘ƒ½¹­Ûmùb;œÑöæÖ»ùì6¥\n´dğí×	â€amÈÉäYùK²¥ŸñwÃYO(îSñ4ñD\r¥Yr-™@€Ö-ôô˜¬ğçn±xªıŠñÆöà\n)¾½Ğ· v£¼øº&/ù›Œ¨•€\0ºqİv5ÚbÏÀàq«ŒH”áN¾}î†\"5›ŞŠZùƒ¾´´*€3´ïÆÿ¶%»nk^ú¨RäB(™à&|T‚7ª.Ù•ü\$u¯‰t»úÛâÕvúÕÑ\0Ët`;Ú©lUï¿²ÙÕ€Kı.¿·ú¶Ï@ÈE¨·Ökô¬RˆÖ@7_ä Õÿ°HC\0]` ©Ívı­3¯ı€UÁZ÷S fCYlÛ×`h\rÁÚäß<Û×4™ÌÈ‹y£–ˆFoé„oàîÚVãÀu”ÃYtÍ Fù¬0Ë‘CY2Ì\$Z€râÁ‰ÆáT\\\r¸|(óf›(Y¦Êvi²´Ul±eGıYŒKRP@@ÈHA'~á—P¸vŸõarÖù0àm,@‹ÀNù\"İ€¤)¸Ğ…ô‘YyANÒ%—ˆ0êï<<„ˆ\0tÄÈxÄˆ1RY|Bÿ k‘¢5á„IüiR—.EÊ+ho!F{Ğl®UË‰]¤Xn9]pÍˆ_ˆË˜`¶âHBÅÕ^ú=‹ü«½\"z7©cŒ‚\\”ŞÊbÔxÁ.…fyŞ½ëE¤ï2‡¸ pÀ1¹ÀXÚT&7	+\\i’à\r\"ÿ¹<c±´!ñ\$tDq9‹ü	Oğ¬ñÉ«~-LM!È{€g|#ã¸¤¶9¤\\v„…„ùÇà¡š£%H(Hõ¬Å˜œôEœ ÒXÛÈêÈ‚0ÛŠ)unIØ_K,àn¸…ÚÆíxµl%[äKFçÂ=—€ïf@ê½áÈÊ0€{”Ü#å0ÅXUÊ~Tå¡”°7a•9ZZ{ÄQs†\0£j0Æ)û’\\úèAo-R/cÂKÀğä6Äj¨²Æì±ã|aüË€ˆ@Æx|º²×!aÍ?Wˆ4\"?5Ê+­ ıÛË—qk„rÇ8Ã!¶4ßºğæ¼–7Â—~p†‹5“¹ˆW®àÙ¢G&ê;ËvGWz+`¬ä=Ê*\"ø}Ï@HÑ\\p°“´Ğ€;™ìèfy¼1Îoç‘œ8èÅá¦ğç¸4Ğ¡N(à*~r†ê 5g6{€{?©àæ@4ÚQP^câÎõ '­<‘yªzvóÃ?«f`äQ¹óÎé‹Ä;éíÏ¤ş³ÔÏÆ~‚æ\\ôRt.¹ÖsÒ‚ï|€h!ÁH`‚˜p.>¬{3ŞÏ.;àú©øÊb«ÈŠ>Ë	é1#BĞèkR’-İ	O<awæ„j©…ûrĞ¸\0\\Áïô€\\¸Uh‘(xªÅú\nîyó‘læ 9éåÎ–u0ìçBYÃGyˆg¼ãO^wa:ÒBŸóµ7­&MëIÚtïâi\rØ%ÒÎ€sÔÆ<öÍ¡9ï<|súüı„¯?³êÏø]…÷@9îwÂŒx§|yëG:;Ñîg½¤\r+hPËšlÒ6–ó“ºgºúuŸŞ|ç»FP»j{O”Ğ şÂíAÏPÂÔDğ…Á£‹fê3GÚÓHİH¿¦İ#Ïh¨ú*Ñf‹˜£hÏJ”UQ¹àÃM«K*|sÍĞ˜i“ ùßn†¹óO¢|'ÕXZë99ÈV—(;úÑVšUÖ.}ƒ¬]g?\\zÄÒ\0å;]JëwRúpÔÎœõ6bı;j{O ÓÙıuI§ı  rÖ„Àß‰ßgs\\:?Õ®ÁÀÕ­ÌôésS™òú5÷ŸÍ%O£O‡ƒmØOy®°÷BfùÓ>ºóÇ®Uú‡·^;×˜è=İ{lS»ÓÎ¨v5¯í\0lü[×~Ásá°Fì*{@,(ÀzA=“iğkiÙZ˜´¹©˜l»NšøÙ}5ùª-œiù:€ŸîÑ€¶ >Ğ»Hª×n‘İ \0¼5¶9‘qê\0]cp=´+%9xÄ!¶ ëÌàDx@^oƒP·a÷ŞÙ5O¥…A›m wÜfI€g·@3€¾@À/Á<\0Âí\rd>\0/‘äHFİ€·p\0yÜ%âImq-&ëmxÛXıŞ6Qı·¿n6<ÄĞ³w#·}ÑÆÈ	L\rô` ?˜£âPÀ\"ê²X	ùØNŞ§b)Mİ„wËBŞ\0k·†#°2€¾ÄA¾ßÀc»­ŞoM‚\0/Şõ÷‹½±Ço\0.ßbß÷Á½-ßï“zÙ„ß9¡·º8öÅ¢[ïİîüwË¿Mìï£{¡ÎşNp-şoˆ*{òŞ\0\0^óÔf„ÃÛÚu6÷£e·Í¿eßyà'àÆİƒÀCş\rğvÌ|!ÛèÈ¤¸®mû¤áHñoB}ïÉûû‹Üh÷»mÉKr›–ÜÀt7¹¾ïû~{ÄŞÎñö-/ï,eáÆÛĞuŞ<ğoz;ıŞ§7ÍÄ]äq#‰[Í”Å€ŸŠ|\nŞ¯x‰¼n,ï+yœLÛØx¥¾!q›{hâ?¸–m€p|oß‡wÿÆ~#o'‰<kãÀ‚ë%€9qóŠ›ããÿùÅ®BmêPÂäW8­ÀîGñÛ‹“V˜dìM]¸]Óë´AÉ¹ÜHjvÒ[ 7¼øİ Ààóˆ8¡*‘hÆËÂà4òÛrA]İÉı¸Â\0€ˆz6@A­øNc.Oi\0ÂesØB\0O–3?H€|Ò&ƒM¬1yó/pàpæt\næ\"0@ÇC<>ÜÕØE¡ıŠØ9\$ç<v’lâ7Aœ!Èc&²¹®ØÈÜÈcz<ò8€C\$NDÏàÌ˜	€N:N‡<à2èWD‚H~`(\$üàQ\0cîôw¡¤%`ÁtÑ„4+-ì\nÏCE\"×^Œà‰¨æE¹R\"Or¨„”ÇNÂ\$Â­òÂÕó	ˆ¸´NŸ™œâŸ\nÈa8½Å\0>•!Áé^–]w‹4œzÂˆÇx§Ôğ<óŠ`CÏX·yÅ°ãu˜ ÀËø€ùĞ`4óÀmä@:Ñe^¶¬HDªä˜jÏ/`>+X‹ÃÄëäÅ× 08—R¹X:°Ânœ·}êÕÈ{)ÓFŠ+²ççÍ%\0ñÙº˜—³i„“§VzpãÖö’lDíJaq˜˜ïÈªí—kS˜Œø‡g¦m»à”ÀŒgs‰LC½Šè\0Ğ€\"à†ÀÖf)Îúb´ğŒô×«IªêVˆpK\n|9}A2ºßù¨6RH†:£TLÚ\$5N:õ?½5…\rŞ+÷c¯’vö~Â@÷hJbŸ¥}Àì¨zÓ†7áL<‹ºp—jyÇ§Á*€ÄõjA@dë\n\\ó\"QûYVz‰µo>ñ’ĞôÄ\rü¶fYqN@+cÌı«:lr¼:Ø‡X†>1xvq‡ã?tBÒX1wM|!\"Şé‹5Ñ@|Çğ¯»zI@¯¨#¢ˆßM%†Iáø¼p8ó!'‚]áœ@-€læ+äº€ 8S÷º¼\r_N1Ü1‡Ô•IÿTÂ9æ}¦	€|°y|±İò2:÷ª8H2íŒ&š#¤…•”Ìnİ\$ÆşŠàşa@¦ëÜaa± Ò*Sòw@Ù‘OHXjÃ™ÎY¼=–P…”\nâÑ1ONW„Q<ôÍf@cÄ!t@DFĞC Iò©lıb[b]yfäór\0ÈüŠfÄš}Z2a@b•}‰ì`•â-¡õ(ø§½ŸìpÖo£Øaö/¶\0Èl\"³/š|ÕĞw€‹Æ,ï@	é×´î¦—«S=cÌ;9·¼EşÀ×xh\"\"ÿ£Æıìœzùåw½8ÌÀ|VšNŞùVñŞP\n×”>Ánœœ\r¹”—~\nnMQEv¨‹â\0˜}˜Cüâ•0¥ÈC[î.3,rôÀ)ï†P|º¢ÜÀÌ%•G)ïÓ>Sà\"GùvQÊ?è?ÙW ÿó#C_ÓÕñô ¿øÿÃVƒ\"Ğ6|³ÈßO±çÌ,«õ@6|áh\nú‡Îúãî¦‹Ú}=)°G…?Sz¨öé ’÷¸”ês¡ü¯ˆ«âÌÿ¼rÿç¬øù‹5éµ\$·Û;uš ‚ú¼~÷AG¿øOzE_‡÷?âBæ!	ş#İ4ıü_­¼šm‚\"U›ğXÃ-±IuøµxÏò_†ıèÿèÿÒş7İ\$ªıÁêÇîÜDf'1aíî÷>B\"JG\$Õ±½LÌ°…şöä^üW£ÿƒcáşñüûş=]å_æöŠÍ Lûp„4>yçım„Ö<›0üS…¢×÷ÿáüê¿‹şOßùˆn?éù£Ãhzqf›cåÃ(òçN‘»\nÿÏwBÒä‹ÿ„[*%S*@<¬˜ÿ˜ß\"F„	\0C*Ïù¬n*Ô¬£À	\0hOá@'\0ÍÀä@ùû\0İ\0Ø¬*¿æ¬À\r,¨³ºÍÄÑ\0ÄöcİO@Tèàíì\0Ø6°;Õ„£82È€èÉ× ‹€Ø³™×¡/¾jØåàú»V£àT‹*\0 ı	™dÔ@\0(	ágŒ		»z›Ÿ/(\0ò(ü¬ØŠ?Î0\"Œïl0%n\nô°5€Ë\0=<€ÉKêàî!éh ú\0İÓ+7,Ğª 2¬DhÏ—~ÿdNì»€ûòÊ®à,çc·£ \0èğìH;€ªNŒ6p¾)„Ğ5‚#Ğ-†s±HÅ2³¡ª,b»âÏ³®P*n|†â_ğ±™ˆBù+¶¯9¼)h€Ú¢x²ª³µ\ns+Éîs|øÎTÁx*ÛÍn©z÷R9!¼ó»íz¸\r`–ù\0QK2`»ä	¬½àÀ>P\\±¬)Z½8r?A;VÀ°tÁ†H2>PcAÖö¤&ãÁÎQ`&'Ÿ(ö ã`©Á@ıˆ€):ƒØ!Ğ\0î£Ãï}p\r‹¹à‹¾ (ø•@…%L	Sµdh+:ŞÛğ/‡CİL±ºjPx#ÏÁ¼óõ·šë\nêÌ‚A½ƒëÏˆÁ>D%Áa¨~éÀ;\0Ú‚I™lÏêà“åÁ´>)0°•>\\(ğP–ÀÜÂğï¡„Ì).å n=A;¡¤Bf`\ra€b‹ûP=ü\0E¯­7xkêĞ­¶ú’Ê°¯€Ù	h`1J\n›®/\"¬ªæ š–dd-oT3äÏ¬Bf%Sëœ€ñÃë‹Bıä0 6C\0şØ\r>î é ÖÂ¦Aœ/„=\0ç\n›–€6B¦Å¹Ààº–Í@>(~û¸@•\0ÂïP*a/¿¤9‹Ï@†\0ä›0£îŞ¦®¢°Â¹ìÌ< .£>Lï`5é\0ä»ÏÆ*ròxBn×Š<\"jÅ£?»BÆP˜æû3øAºvşCß°„!°\rÀ\"âéĞ…À‰>„šÑh`ö‚U@HÉ:PóÁÚ3£ëí>¡“ë¿¨Ÿ=Ë2æÉ0ú¾³`>°Ö\0äíà®‚·BêC\$~ªp¼nÅ§Â{±`8\0ÈËÛĞ=–ÿ‹ÿIChÿëĞà2A:ÿ˜£îÈ?æõóş`ÛÃ½’›w+şhLA²¿æ\r[×Áª7*crã=·2½(0§†/r+¡\nŒøwÓº¬ŠChŒ‘h‘\n3`HQQDˆZs€ç?#2Z\$\0ºp)	º¬ü°„&ãÒÇ€,ÃTü	ï	T˜	­¹¦b 5‘1ƒë(.ƒA?ğè;.¸®\$ZsÇ¡	Ãbü6 =3ã\nhBnÄ¯è\n€!Ä²ü q.CüP÷ÄÅ\$P12¬y<N‘5\0èèM‚E%¡uq9êèÆH¿É¸n1CD½	º¼E†ãp\"!¡E=8\"QK?Éƒç¸Å:ÿì/‚¯\nÀÿ\$OÏT†ã)QCÅIÜP10©!ÄQ±3EU¤X€!Å+tWqFÅ3LVq4¼Úê³†hø±j;¸Z0vŠÁ¨T •CcÍ±N%ú¤G¡\0ØğªôAXDy 3\0•!„íÈ#h¼ÚíùfO*‚T€!d¸¾Ğt]x2õ[ìàøEİ˜)¹—l÷Zk£ Fc¹(ª…¨«áÈ¶‹¢EÑl;^³§nõ\"ÿ .ìšA™q#¾®‹ô!ò¦óhãl%\r¤[€àŸ=äe„_–R±G\$0Àë9Í‡p¾K™C^¹D×8“\0-€@' 2!6*ã9Í¢‚%0\0¤¢ôCşDh„ğY¦\0ï‹¬¥§ğôKf\$ŒêÔkÑ±?äñ2³®Õ‰à<!‰3·ÊU%3€5áû¼ª\rx8/`CZñS¦©Á»zQEpH‰Ø\$ò¼¢U<ë £ñŠ>*”“ãj9‚ô; €Çë.°“¤øú@…Œ¦ãİBëEk(\"Q\$ŒC»Q­<Öù,HB=¨\0ëqÕˆ,]\0=€€‹B\0001F€Íàø@„5ò \0>\0F%X•£!ûf¦4ö2 É'ÚØ»OM¬(@dB°Îy3œ\n:NíÉ<£ñÊ˜0ãë\0”(è©è\nş€¦ºO \"Gº\n@éø`[Ãó€Š˜\ni0€œğ)‰\0‚‘T|)0\$Åèp\0€O`	À\"€®O;õ.\r!í)4Ğ× |cGµ( 3f1ç¶ d3ê!ëØ±ŞÇ~¢Á¯<ÕxÍQG¡lyMu6®Ù¼yê\r¬µJĞ{@ƒ&>z?îÅ\$N?ó¢#ïÂ(\nì€¨>à	ëÜ‚âæÃH&CdrH=„1âHVØş²%›t,Pàµ§!°U\$Å\"³e „H(Ú’æCÈ/ Èê!§ôÏ”w‘ßH¡„CÌ61!chmUy\"ä†MH¼Q¼ŠÍt(5\"ëR>C”ÀI\0Íâ|J(ÚKl’%B” Š·Xm[mà<„±0\r­¼\0Æx\r²K¼Û²»Ü¶Æåw-Õ8g\$˜ÒJÉ.åhAÒNI<d”\r¿ò 7 ¬Æœ–‰8Voì— 9\0[8«’\\#|@,9gË¡_¤D0Ä–ËDÉ„E¤™„ÕIxœ™‚¬\rŒ4ÒiÉ ˆø±‰\0ñ&Ñ ÒcÀY'™ƒ	€Î\nñFògÉÃ&›Q\r7&éx²vÁ;'²g¤°<–ÀÖI´xØª°¤I%Ü™á¥·%ô e(‹–k\n\0æÌˆRm*Ù2i‚ê\rÜ¡Ã9€ï'Èhá=J+(„›ÒÊ/&°QAERÔ™ò‡Ê/„£ÒzJ5),¢Ò_‚HÌˆKŠæ@ôrg†J+K~ÂÉ§<¬1(PàîÊzŞä§Rƒ\0Nb@Ga<ÊU'Ú!²Ê`hPèÌ±&Ôc 5ÊU)ÒÉ	˜Â¬¢+Å&Ô ­#M\rÀQ\$ó&Ğ8‹ˆ+L5GƒI\$niF¬|\0îJ*3Ãr—Â¢‚p£î	J°uå‚Tî\rÊòt¯rÀÊüoèdÕK\nã+ <Éà+H%iÈö#r¬#¨`­ ÚË1)\\¨ÁB>Ü˜¯d\0Z\\Ü–À<KG,èRÏË4Tc¨À8\0Z²K—{¨ÃÒ‡%ìpr¿Ë,±èÙ(Œ’½‘-ã«²ß8#.ƒeVK-øY²à…).pZrÀK—.‰U‰29U+4³’èKs.¬»Òéh][û`À2/.@±’åJû.d²\0ĞDIô‡/T°RèËì¾B=Kèà”¼Q¤+-42ü¹×,d±Î\rËı+’õ3\0“U+ü±ÓËJnZ6I7ˆ|pnY©B+K³¡'I¿&|ÁÓ\0\nÁ0²Tà9Ì2Ãr£K†•ÄNÏIµ\$èøB´“jKˆ²ÿ¥µà‰|—ÒîL(¤º³¸Â“„ğ—£M0\\À‰ÁËÅ)¹'C¤HÈ6Š>\nô§7L¡2`‹òm:\0\0B€Z»ô™ó+©:\0+A¹¾İ2²Äs/ÌµL¢sÌ¼ËOĞ…ç2ìÌ³6LÂ”5C\0››3 ó3LÂ]”DÄKŒ4»ÓL,4¼‰ËÍ(„È“Íã¸sD…,lÑráKw,8JrãÍ\n,Ò®ËÅ1¸BĞO¾%1ÜĞSML\r*TÃÉ8Í.dÓ\"ÆKÄ9nSSÍR¼AQÍA2,ÔN0€Ä,ÖsEMj“xbÁı4´·³ZMTàÜÈ!L…5ÌÑó#d‰à*j²+´“WM•-€\$ÙKi6DÓi€O0[–rºœÈ n@¯K*0˜ORÙƒê;\0B\0ÀM*œ×SUÏ5¸aOb£e6à%R®ÍÀlÜH7*K\0:MÑ2İsPÍÜÃ2µiK{7T UÌ´&¬^²Î@ã/œÜÓ@õ7À#ó}KâØsy³aM`àÜŞ…x†å'3ŠMÇ7ÜÚ)­KRûtËLøÎ8ÛŒ3|ƒêö(²kP\rüÛTM´/lás…£)så3•ˆõ/kRÖK]+DW²µ†…ÍódÌŒ&Q7’Q™m ‰¢B;ÉLÜT•U½\$Ä“RW…%‹—¬CŠ‚(S˜Çö¤»óGÌD˜:MÉ^L›ËŒ3I}&°ğ 8„Åƒ/M/×åNNêaëƒs½ÎØ	JAƒ]JÌ«¬‹D’³‰‡.|ï\"ÃÉ^M,ï³µ„±<—ÓÁ8#Ğ­,¸‰)1\\òS¶Ék<´Øâµs<äÅ³ÉÎİ0ÃÀ6Ê\\Aì¦2ÆNÏ;L¹£•O<ÄŸ’ıKf„æ	\0Ï<dÖ½Ï ãôÂOjç\\öóxË%=ÔõÒKOa>öSËË>7`‰);tù3´:ù³cÏ¡-!»kÏy9ü÷Àˆ9T+H+€ZÂ¬ÀáË§>ÌøS¼Ï¹?,™3LO¡<pøSß£e>ö“÷OÉ*„ú³åÏï?dÿ2ùÏ¾Dş“»KÄÌC\"“¹Ëõ@ïSÇ“¬ªòáCZdûtP;äÑ”	É};;{“ÕÊ`”ÿ³ë¸7@BA”-@ô™¿Ï_>»\"æ„z1âcÓô/@”?ôÉ-@è:ËA4ÅrÂ:xcª3!;ÉıA¥4OUAÍ4Ë	A¡´L;ÄÖÓJúd³™.PNA”“©¹M:¬ïs¬I[;Üë’YÊ@Ô¨`‚ĞQ=lº£#NÒÄà<PİB%°ÉPÏA\r#OüäúŠ#MÎ¡€à=ƒß*àÉ2»Êfkr\$-ËQÛ >ú€Ã¬‘2Nr€¤\0,Q‰\\\n`[À\"€¬*F€Â¢>˜\nTG\0V“U2‰SEÀ#QJ()”Q\0’8	É<ÑX†h*É@¤/EeÔFQBÀ[Ãè€“È	(ı\0›D ,`Ì\0ªuà€Š#­ãê\0?0ú`&€¡E²5cªÑEFMTbQ,\r@)€£€ı¨ç»H !o‘FÀúÀ€œ°	à%¨:¨[À+\$è?]Ãñ€˜È@\"ÑEEˆà+“\n>˜éD\0¾8)\0E:C\0!£DÅ£ıÑª(úò!QõEåéQ•D›9ÔJ§¹D½€Ñ5Dà\nªR\">Õ\"`½GE#\0°¶+Hà[À#Q„~Ô‘%>ô‹Q³HÍ%`Ñ¼€ûÀ!Ñ–L%\0RGI¥\"”Q€E]à'ÑSE]´¢ÑJCƒóRZ¨	”F%E8\nqò¤ÁH]#¨à¤LÅ&T‰QEFˆ\n	<¥Í!€Ñ©J\r(t’ÒOI´|tœQ·KJ@ÔWÑ•,4’QD“È[Ãì#U\rtQQ}FTm+F5¸Q˜?(\nTg€ùK%-tkR‹IE0ÂRQ¹J-Ôp\0V?ğtqÑÊ\nµô¸ª\r”wRñKMR¨>èûô½ÒFU)4¥Ñ•KM+É?ÓV>ğ\n±ãK*7\0)RÑHí2 ÂÑ8 j‰/£^M4}€ŸGíà\"ÒN] ”£º%HBC4®½N¿\0‚Mt“­GåÔ`ÓH:4ƒS©HP	”ºRJ\nNôQGÚ`ú4¬GçªLTº#qå&ÿ‚¬K°À&µ°[ÈÕÑ7OH0£ôÕE%ÔªÒÒø\n &¤T¥@À+Ñº”B7gÒÓDàôe	KP(ı2Ó@Å6°ÔC˜”w\0²%-BÔJ¥=4ÒxÍ>iT€§I\rC•Ò‹O|}ôùGéI#µ´­C`T#Q]ATàS×R\rHuÇİOˆ[ÃÿTwO­# +%MHáªQ?Kˆ\0ÌóE²F#óŞ?ˆ.§QuP¢I9£Vò< '£ÆåJôŒS6>¥cêÔÛN½HñòÒ|êŒ| %£ÇS¥ãëGÂ?€[ÕÔıJ¬{ÑıÑğşUÔ°”D{Èç€—Sâ5uF¤4AµHÍKmÕ-ô?ä‡ƒ÷à?0•L­H5LÀ\"ÔĞüQTŞ•N#ëRgU5!´[Ò³LUÔ‰½R)#V>ÚDÃ÷\nüÍ¾¹MÅS T¶?İKµOTÀ%5€(Q3DİµfÒ¦u?.ÅU¤\nµEôŸ\0‰JXcïÔÈ=TµSÔÔ?ZõUÕ[W--uYÔïWA0 #ÒïVíYÀ«Up>­\\´Ô€®ìp¿£‚êØ	• \0â<1ıÈ‡ıÕª?€	ƒğ#‚?ó£´uT}J­'u~Ô2ìP	@'ÕöX	5B\$0}TGõIhûÔa‚­TMˆÖ9I8ÿU“V:]PUÖW˜ˆáÓU€u’T±H3Ñãñ#sV-XõNÍVUTÇµY¥-u¡VwW•a’ÒÿS¸û	;Õ?ídµ¦£YRm?ÔMÈ­øÖ›P¥h”õÈM-gé¤§\n”ÇÍ@\nTfT#Eê8ƒô€¤ô}m`«S£K=[õ¸T:õ<®‰UŸInÃõ¼?||ñTÜ“¸üõ»‚¬ı?Ñÿ;[ˆhë¤iUú8‰<ÖûPõqµWÖyTİY5/Öƒ\\eUU¢×9\\°*Õ{W[õCõcW1TísU0×'DÈ	Õ‰Ö\\5#À)½[}tuÊV‘¥uu‘Ö¡RÅGÀ*T]¨[ÃïÑ9Tµw £T­buâÒxMHÕÑŸ^-YUmÖ\rRjP5ßW¡Z­fƒôÔg^¸4M×©Qıx´µ×¿^µxZÕÛK½x +¥r8 #×&?=ô{Î”£µªW»YúQxÓ7^Ã Uö\$T”\rblV%Wİ)îÃ£ÇRØüÕ\\¨Ä‡ÈÕ×îì\r’\0ø¸	ŒÒ‚³±À&ü°j”¿H…_êL\0P5%ô½R‹LˆõWé[-|Ñı€§ì~Î¨€‹X˜úÍ¾€›Fü(ì\0˜?âCUWïK*82!½J­‡•GÑj}I¶Ö,‘ j€¤Q\ne!6#RÕR=…5Ö§Nú75¸X¯\\l{èÜWRj5”âÇïDz<iTÒ>˜[ÕUn…ª#ƒ[Â>–XÇYª=cóXßbÅwÈÜS5Oõu *€ƒT=dv:Ø'F	oR£Mõ5|Ø]IÕÈ€¾\r\")-ÔhE?ÀÇ¹NıEªU€ \nà\"Ñ8ë’>µ¼#Ydí“õ}Ñcaee€'T¬tÃËRµATá\0±Oà\nGÙOdM–• €¯d%/¶#ÇP…MTdY.ZU4wXMÖPYQf-(6[‚¬>Åõ|Èfˆ\nÙ˜¥”õ6Që°ú°¤RñH‚F4Õ×™dÒ84³ÒDL ü@*\0¿`@úÖtRAH\n5õKÙÜ‘¥í¥F“¢4ô\$À?-Ÿ4OÙãQõŸÙ×`• V}Ø\r±ùÙïf¨0¶ ÔáH]À!Ò}QİOµQ™Sm›CèÑğ?0ÿµ6İhõ‘ú¤ÁZµXù°êŠ>µ€…!C÷V9T½`”ÇWbõdµ/¤4>²CW`•A•XkFE6×Qš7 Ú~“K•K¤ÅSŒˆt¶Õ\\|~–vÖŞ“Èû•ÓÕƒj³Ñãü€²øı\$ÂZ«jİ†ãëÚ zLTfZ´ı†é.Ux\r«tÎZÊ>â9ôÿZOD€4ªH‡UÕ­”eÚáhúDÔPZÓe¡0Ãî[V¥®öÁ£ >õ^õf¹cóÎcìß`Ì‡”N\0‡iÍ¯QùÒ\"\r‰?Øp0ú2\0Œe±ôU\0>Ğ•~[F ­Ú©i5Nö“\0‹_‹«uº·Q`út«ÔÓS\\{ôyWZå‚ #€ıytÂ@jè\nV´>õ­ÖmÛ‰n5­Có[—nM•øÑeGU+ôuUKGUTuTÕ\"avÚƒZµˆ0¬X‚èmˆ ÑÔ¥´¶ ÛSb	õ€‹DÏGØ%}®‡\$e\"U6ÛñFRPN‡T5YUŸ %º#mÚC\0+Û€L-¸N·×wn,~€&\0¿SŠ6Ö¶Ôà> ôŸV?”X.·€’ ˆÕÚkJ8”çZÃnE¬–mÜAHº·£Ö²N–[TcÕ”æSÅN} t‚Ó¦’åP”¥\0\\#°õá;N5†ô|ºíF†4ã\$Ä>ön\$L>­»n»\\Crb8–ëÒx}?–×–?•7Õ˜Ò{Iı¤õ™SO½Ëé\0HXåg)\0\\d>ØûÏÅhœ‡öHyYÕŸƒì\$9NàüÕ­»]b5„Â;WhÕ/U>\rÏÕ0Xµ\\p–ãZÅqHÿÉ[¿[|¨ÜT(?=+U*<çJÍÊ‰9€†èİÒto¤ÿIõÈÃÓ3]ígôo×Ô•ÔƒÓ3q¨à/Ö›kµÓ\n¢èùÑt-±¸Q¾ø\ncùR«uT~wV\\_šPV¤]MÕâw\0¿X­_u¢Úıg(útfHsL}½·bQKH=.µwQÓa%4d[ÛJ}*5şØ£_íkÑ™RöÇëmİJU~ÔIR\nV™ÇûGMİ€,Ûë`¥“÷zZOeÚ?V	Óšå›À>\0²>Í¸ &¤ÅwÍ#ïTÍOJ÷\$ò´\"O@ùó[¬ª]`1¤‘l3Î©‚èoÜƒ¤²¨#ÅŞ‚ëä\n\\ÉÑğa+*ºlîH: Úƒ‚ômg†;yLÂíH#±{ïÄÂqÒ>c,OTÌSâ°ñ%è/³@¾!Ú<é:D&óxAÉzXW§=‹z\rÀ<½˜Ø=ê€<„‰óy³„\0éØ6 4¹zíã·±\0ÛzÚL 3Ş¯íí7­„ «üªN\\ïHfñÌèx¨u€Ï	€\rªÎ‚¥*“§w¿^îìï¤iŞÿ{Ô&¹½‹KQÕ-µœõÙYßWÓ¯€ˆ­à<Óø?%·\\²\n`+TÙwm‚¶’SüĞı5HÓLu³÷%ÒIN 0 &ÓkEóV€š¥Ñ©0W[Å3àÜÁJ\r÷6 Óô]¥u\0Ùi}ÅØ7áXç~-pèìTPx0·àßw[•÷±ïÑ~C£·å_y~4€©A½~°	ì_uPú”QQV”-5aè0æ€ßìÙ­0„`º,yˆ7.Ş:© ~ˆ°T˜\08*\0004Œñ7…ä+0Kœa’Â`]£Âø\"~î|I±ˆ­Û¹à;;Ì²©5ø„ïTn¡CxM)8ĞWÌ‚²¨D.Âˆl\"O×#æ,=|üoeÆ2õK\"íŒag<\$ Å8Ş8!KåÎ´¼d¨\"	ŒZêP%Üş¨.äÆ? 0+<Œ6ïè&ñ;«”º{‚ìM –ŒRZ#&1’ÆPméÈ¿rü›ÁOà|ì^àÕàShõªÂ†Sƒ¦A3º~éS¥.úº\\’HT—ƒ¤¤Î˜¼4Nøn†ƒ[;ˆ>‚U:hé³«Mºr÷N†Ïtè€&® <V¹	N¡|HÊN¡º„»{Ê¯Ş0êH.¥»ëƒp8£‚¼n\\Àåÿ—zÛìD„šÔ§y½R£½èZÌ-º“˜¨nZbíàO†I‘ÀÚá’ëAîÎ½á†ˆgëÄã†xgót\0×†À×£½LÚ7“&´ŠU9î	`5`4„¸BxMÖò!;ÑŠáÈë\0Ø½S‡­è>¹<7¨DÚf^ÏbDqn Pé4¦‚Ø(ş! Êk´?‡æ!˜š2­è°â/‡ Ç¡òaj&#2Kakz8b^ŠZYø“Ş‡‚Ì_W¡&\$Ğ@áÜıÃ¹8™U€úX›á¢óXÊ¸Š	U‡H&â]‰NNjè^8£\0ÊXgøo\0ùŠvØmBî,DÁM‡2,D08Taª^1úãPš5ì\"eÿ×Ï\r¬ÁònÖ@¢ÛŸi3¦?‹KÅ‰B\$Z,…¡€Ú ¯—zÃ(à%ã\0w–%x–ˆWŒ+\0ââÖÖ'ø¸A	‹`68\$¢¼îkx’÷‚†Ù0%(ù.[ŒÄğ«ê!;\"üÕX\"Ld¡ü6…ÏXM4yBƒcú­âÀíĞ*CF@“ŸÀ ó5á\0¿Û±lÄ<é…ñÌ±AHF›ğSñ>î\r€JÌĞ»æ\"øJÀìßßŞPã•†ØJxß†„M,ª±ÎÜTèg™¶²ªRCƒwâÆ#„c¯€>ƒ>\0êMÊ¸÷ˆR¸În¥°@/+À@;CŠûÙ†êéÆ+à<FÈ»~-Kb„t+*Îã6®<Ñ&áıîà:aS“mf?–m^<>á¹…X”ƒhôí!›Œù;L¡w¢PŞÆ\0—©:Â8à5Çlğà²\0XH·Ç…¶¥;ËÎºæ™PÑätç\$^ÙC½ƒy®…·\0è+\0ÔäŒ#ø\$¸ÇØà!@`ª\"&	îG—Àd€eµÿ\"8˜ùsØ šbx®IÎï„¤÷*öÀ:†€Ğş <\0Ñêy5¸’êXÌE‹Ş!î+†¨]è;ÁdÛcuïWÎGzÓä 9…œòªAB.^Ÿ<€ßÀ¶:lƒ8:zë\n¼·º»tå^j\0å,ÿ–SwŒ-û”Üq•„¦Ä!o*¨®õP74åD¥ÈYÑ¬ˆrê€9!åZ×x‡0ˆ…şa6—Å;;yÀ\r·ÅK3{”â·ÆaÏzÜß9aˆò°‹ùc^¾\n(6e^9”ŞYÎ†o^Z9h&µzŞZ`<å¢B\$[–ÖZùcå¹–ÎZ3|å„šÖE°Îå‹—FEÙd]—d3¹fe“—†ZR©aÏ—N^¹jeé–°%y|eÉ—¦[™oeõ—î]¹qå¿—¾]¹]_hc·ÁÆW|(#™‡Am{öTˆ_ÍïaåA–Îc!ªF´ ™Eÿ3@ï ”ÍŠ€Q \\Ñ Ÿ–…ä´D‚QIEdã¢]f\r“¯ìcÁò]ğ!ó7fjxFgáÆ`N\$GE´!?v'^g2¹Ç_\\t/à ošfhR¹ÇC¸°î}æ¨!14Y9fd°#°ó®™ æ¹“S¹¯æ”f^kc±.A°#7‰	FfÂD™›Gi r1KşY¶Ìe¡deN¢u›6#€0—•,®!Îœfü	iæÚF€I€ƒC\0>qùÀ„zhA<•›®p\0à•:(øƒĞg;h\rñ\0Îb JÀ‹â‚¤yÂ2,/şlq«¾œâÿÅ]†È¦nŠOfìËğ\"€ºç7Ökàfá	ÍÙ¶Êª1yƒ 0·…‰à7Ouœ\$÷Mw	-œNzUg¤bÇ9êçOšîm,æÙœæz8æ×Ös¦ƒ“\\Yãg­Ÿ@Ëç‚øp”¾\rÃ€àëNm´“¥H\"\0®çâã²Èç£Ÿfwùœ·^Tæºæ…D3çõĞ	\$@y¶ŒŒÚ¦v\$:Uœ#ıï]„¬Ä4z	;:NãŸÏÄxŞB8W¾„¹Ì´M.níwæçœ Hú„îPæ!½…›l\$³@cÃƒäv@x†*\0Ù{Ü½ÁO\nÈAø`™J¡ú+%\0»ğj€Ö¢t÷Z\$™KA!Ú+\0º.V‰Îiè¥67ñ@äÕ´]z(æ…ˆhØ;Oá¢ÒôB­èµ¢abç\nWŠÇ)ò=077ÀßM2Ã˜ÙãÉš«#Y¨¿.a+zÃï…æ‹ãƒ²â¾w˜¡>Í¢ø€eçL8T:/çj7º/èr ˆ‚µ¢79ĞŒá¤ĞhAh86Îüf…× äcH Èjš*è7†‹F\$á¢Ñ5Z-Úh•ZYh––+À‰g£¤PD9ñĞ7†˜aké‹öBæç£¦dÅ:iåTìfk+°_úkæ¤ûVšÚAÂªÅ`Âè¿ˆBÀ©¦=*ˆ’Øü`åV‹Sîƒ5¢v‹ÎÊ¢#ş‹C¦cÑ Ö‹XÁà–Sş:|Ä)§æšxc…§v‹Xèikêú5èœ›–À8hµî—òA%¡œª¡´©,)†ŞÙ·@Ù„¦ãƒ­x¦£ªßf²ñ†£ ‹‚³(\\ÕA.ÎHZ Ñúê\n–Âæ@è£ú7¢«„ª-=}¥®&?ÃA¨Z-Sƒ°Ñó[çNá^XÔ^Ã\0NºZĞSy&yÚvh†]ñ“!iÛ@Ö˜Q»N)4APŸ(â†‹C|è´æœÊšw™K¤Ëú|‹ÿ\0:Êšv²ã\rÄ3OW‰Ø§Î<,6§:…ƒë¥Ádt#`€«aÅjıª&°z¾j‹«ğëš'gàî°8	ºò„	:|º÷„¾¡îÓk1¢p¡\$éBßª±”²×j\nn>‹@‚Ÿ[¢t›Ïui}¢{\"ú-K]¬Ù”°àu•®îœ€ï§ÎVaâkK£MÑÃã»‡ö¡úaü\r‹Q­j|ìEÉ€É¬°@˜Â@N²*h©®CèBë¢ê©r…·…§l¢Ú-cN8Cü*;êÕ¢Ø\$/¯«#¯ºÜ|Z&¡ºà”İ«ÆŠ€ë9lúv½º'c w–¾aPêg¨v¡zîëéV©Ñ(hİ¢sÙú¼ëõ¯”	Cáhµ-´fú ºqI|25dEÚˆK\"ãPß\$Tàß:F2äòP5©àY…Öºc_‚\$šÑ¼>A±HE¸5„‘,cÚf:‡€ø60¬lf6.†¨\r¦èÅø\0j`d¶©X±uæ©9´g@¬æ9Cç£€FÉYëÑ±şŒxì \\ÛİR3¨dt¢Á+Œ1²†»@‡éã²!’ÚÙLÀ36%X—ãÜ:C{2ş%VÌX5ì0»°#GĞ[èa€ì¿ªA’ÔäzTæŠ	+4ö„4~?:çMñGõã_ætfj³5iÚWÁA´|çúïÃhğØŸ¼g¡kæ¹š³‹T«ÙÔê†`!øeŞ~+&b_B*ñ8„ø£íSy@~î(c#x\"9ÖêÇş€İáu ‚Ê»[ã\"ĞØ#9ñ—»¤\$_ÓŸé¼íˆ5ÎgLÏ¶®šçI¶vv @N=âÀ¬„ï1§»iĞŒ&2Nš£@N6Û‚í¼K¨£úsƒQ©\\çûZÄ]¶œ{n`k«µ\nz0mßŸfA †‹1&Ûº::Fg\"J N8Q 5Œçœö­;hêğŞ-›ƒù‹¦ßA+ÎÑ¸P`Xiaõ?o†î+†R ‡î¸kxMhÇ¸Şßù]n!šŞäyî ö›hë <¤[ˆL×2ÎâÛ½¾™FeîP~››ãeªq4³üC·øøë\ròıfßû–î“¸<¸xàø®¯zP†â»ßoDà!¬VXóm%	†é»Fà‘´±™{¬Ë	º~Éùn½º®°Nàn­^VR†hëµäIÅlºüŸÀ>S¡®-[l´ˆşîCfešö™›é‰·Ø+Úõ¸Ê»¿nk¸¾Yñï\r¤YàQ‚[h+ş@İŸ.ZGcÊÁEmu	q’Ó FøˆÅ;\\æÆ±½ê{%º{NÜbï-­¶tµçË¶¼õ;Öl/V„ûÌP£hìÒ²c›æ™»H‡ó´ÑÃmñ½ô½:fí|M.†!o…ŠÂÚTĞ~&šQ¦eø×ï¼sZfì÷¦6ß³g˜NèùÂéš\$kèfX^Ï¾vß8¦=¦~î4ìp¦yƒ|é›¿X	ïÜ2ä_ªHm*> [|:2æ©šfãw»>ø»mƒ*®ù×ˆäKœ.<YiÀPCÛ{âƒ¿¦õûêp 	d_°†ë?s§|•w°›äï³\$èJ|ğ)´fîİğIÀ^‚yØ¹¿Àï¸tiKÏ‰Iot\n”'8\$pQŒ’ü`‘¡–í˜èvà&•<!4‰¼±ÍÎüë•	ìŸ¬K!p5c¬œ\$ö¨p€üé!ÂÙÂf¹+\0+»!D<ºTæ~FàgÁŞ™›ò m¿6•»É¬	T-#+c‰	€50ƒ«¾Æg=¸˜öºip¦fæ{¿ïw;ÃáüUŞyI=··.æšEñÃßºb¼gÄ.‘`;ğ‘·b½S¹˜‘¼>çÆ»nˆQŒïËÿán÷îî:‘[º¤M_\rTíc¿^zÙı‚¼î«6:0GÄêåÚc#<\$øÃğ×½\$äããÔø©¡¸Ù°.t¸ŒĞ[¹|;ÏğO»~|r%.'€Vº†?L¥¸Ğ+@Ø‰ ş:¸.cz	f&Q=¾ûsÛ¿ñÑŸzåPINÇV„üiYÂD@zèÄŒfòdšù/Zo¦g¹¸è]›Ìt¼Sâ\rfü‚ñ\\Ãîø™a—Ç+>8““K{è?ïuoÿ¾–|z•w(e\0œO^¯Å' …r8Tç«­ÈÎ(3J‚°ò~‹}I€Ò¼^c†0÷ïh o°S\rç\$¦&eòq¨öp.™qçµæÆ†éu¿(Ú'Ëœ¤Z]1Z'):µ‚¤ÌÜ¨€º{ñ<€¡ª¾A?•)™d`†‚\"ĞÔ¡rp`ÂòĞ%2ù&É³xDHËÒ1\rÔÔŠªH/ËÅæã§|D`©*|Í~‰Ğ‡Ÿ/¸´DUB5²G¬­à.M¶¶¬e1\"n;7üÉš0ğéîrù\$_2<¼!èhÂŠ\rvs=Ì,‰’1¨l¡§|»ó-ËÜƒmNòÿ!'01çsKck‰áHñÌé“&(\$4‘PóGÍÈòH¸h*àm€:a!\$»‡6ô£»æ¡ZŒiD–C7JKclœ¼9Hİ[…ÍÆó‹Î<êüä¶òo\0ÇG\$Üë³†K(pËÍÑJk17=&‹Š>xÙãôK8H7>,óå1Œ¼ú‹ù:\$¹3„ó?’ôÉà?@3ˆOu.ç@³ÛM)\nA3â	•=™ónjØa}Î,¿}Ï£1¿CSî&¯Ğ·?¹%•Ñ@X—Y=ßD“ˆmN÷C³‘Môà/E3Ûc¡ÑhhM\r·±Ñk`n(tq'84Ò³ôc>&PÀ3t[6/Gn‚%%åês}Î:òSó³Î gã+1Îën¼åsÁÈ<\\çÉ6Àxi8–œ\rxíÑLù4xà*€‡ÏR9\0	@.©n¢²Bs?9bE›Pˆô‘/(Ù7ZÛh£óy–F˜:Ó!OÔ&¾]AÏu¤¢6P\"£ÙóÿàºNø³ÒƒóŸ@@iV…£:j‰Ô=s#íÜów%åwÆ…Î¶eÔ¡XmF\r'tí±k5X€«ÕwËR %Z%>öÕ«sGtXW‚¿Vì\\İY¥…ôMØDíˆvÔóÕOV]UØsb'Xö#ÖÉ[úLV¢S·]ÇYög£±[\r•'Séc®¨ıQ€Õ?÷OX·Õ?Å]_­…½rØb>‚=U†Ôæ\nµèğØg`—]õÆÚ–>§[u6TÇXõK’uêàÇZ}}QAVŸVızÛn?^µAuëcçL·röRÅxWGZ©×­ˆvu÷Lİu=‡×-*5jv-ØV5HõëWMNİÕ_==‘€³\"cU[Ö“İ£W!Ua¥¦À%õ‡jm²–œTi­†ÔXjm¿V€¡iet\0õãf…§¢Ú[joi]hİ‰DíUUÇTã×ÍUUÔ»Ú«o½€ÕUIu°–¡v‹Ø=V´’ULLµUvcõ¦]¢ö\">Õª•Uv+Û\rgÒ©T¿hµ ]UPÿİÔï\\íkİ¾QoEëÑı¿#WWWn•[WÍKµ5ÎöWÜ/lU¤wÚ-tI\\‘N­W–¸õgk…Wu`õ[Ú5]İ¤UyÜßiuxu¡G__ÕËÚ´‡Óö³Wİ\\½®uoW/lrÕW/lı‡UËÛ]Ñõrößİ×n}ÑÛØÍ\\½¼€«l—sUovCŞ-]’UiWgqzw7G'e•rÕçİğuÑS‡WÅCí¤ÿWÓ±VÏÜ3]½»‰©oİQNÅV]p\rÅU«YOpV7FÜëml•«£YZı·:Øub(üö%ZŒ?ò5hèGåßí•öS•„£íÑQúnÅX`•JTÎÔåİ=áÔƒ×¯w¾WOô~”¼öãEˆ=‰Tİlœ|ÔÛ÷ààú¶x?àÅH<æi³…¯…@ìïWánÔP’lÍ¼åèß\rá–%#íS¯gˆ[À-\$ÅJ†íb'Œf7Xácwe]–l¤ódÕ”vOYT-™•øXok•:ò\"ÙÁ!åŞÅ]Ÿ!ØüÁ‚_áN\0Ha T¼-ğñäjE³UíÑÕfÕ•­¾ö-xEıƒçºHuè[o\ra	Å¯†áõN¿a(òÎa®KlašãšáD]î¥xQ\n´ê.òlq…IE:˜a]ÒâIZædËü	AkàúéC¥˜@ºZéŒ\"0{y9…zöÙ¸`Afx\\º—ËşÚ¾oê 6L½„dËñ”Şñ‚Ş¸`€?—Kj¾së¶¹ïğÀ	¤pX`vò® ºw‹à-™ÓÀv´¯†àŸ‚şiŒÅB›º¨´p>kº ş`¤EN¢ĞaîƒæTdÙÁk²¸m[.óiŠ]ùÙƒŸ#FíŒ.·‡c“-¦#¼D]ºŸ€bøï@Ê¸btõN&ê\0ºë‰¼8•ÀOÅ¾TœRzáÓ+íHo’™TaÃÛ°c„Öæ¸y~	Hp)ç£~ækÌ^Å<WD›>‡âS Ø¤ùãÉòŞ…<.ÔyV v)¾0·@·•&;p-èïÆSbUgï±š¡”xöÍŒ{^*éé.ïë\$T\$Úºã˜Ş[ù¼YœğÏLAôÕš„<k¬:{n”èLømÏ¦^ÜXèz×ÁôßÁfê9‚G­{q^·*@p„@Œíãã`:D\0©·p¸ŸÃáG0Şôs¡ë¹>Ãâò±^VıìåMì†&÷¼{Â¨õ?&ˆß°ğãõö?¸¯Æ±šO´.©ãşéÃ+'^¦éã§×Œ^à#]î˜äB÷övóëäJ3à4ÒÂ;§¾Ü˜©Ó¬>ßlßDî>“ã9¿ç›2Â\0äèo·ÜdƒùîHNô7{ ˜à”ÿºø.°ä7¯»ydE³ma;âS‘<I>ÙäGí²Yù`jîdv!=zõÒÆp»\0øƒ¬Ó¸^í;ï¤úpHà‘æ~hyÅp…ïæƒ^ıs@×¿¿`?ª&<¥ŒË<pIºr„ï<Ô4ã²n?*ŸÁ	ğ~6ŞfãÀ„ú{§-û½_'m˜\"~=QÈ–GÅ»ô8Lñ6Ğ››ÏŸèœÛÀüXU?Ä_M;´Äÿ_¡?Æ|_ªf¿|[ğ×Å/í™©æp9Ÿã²^óãÇGgO,wÉeà@mğ\\¼?(›òtüıIò·É¿#ò1òçË}ƒùƒ`Åÿ&@m?Ì_/aÛ.ç\0ìˆ»ğÖ¤Ô:qğ^²o|ßó§äib\rwÎ\$3KıD“óÆu0+IÑó¾tøvãw-¦ÅDà‘&Ñéqwºç”&KFÜŞ¤\r‡†ÕûÉò‡³±ôÜmû˜wÏ]¿É7L\r@cÏŞLC{ğX=—÷èXBŸX.Ü÷[wü+WÕ 5ÀEõÜ.ÿ^ı?úC\0ñÁ~ ı¶ï'ı“õ'ÙyÓíiÔÙÙÓı£Ÿ<¡Ê|5ö¾p/Šı“(\r»>nãğ^ë™ñıaµŒÖ4ı‰'ö‚ñÇ-ª]? ıÕˆ¸IÆKN9ÿŞf[g©÷?ß]}ˆ1¦|¿\r|^÷¸îüøÒ»ÕpÿÅóÊ¿ğ‰øFüZ>ïøvõ_ˆ~¼H Ü5ş'à›ÕDa¯—ãĞcª¯\$†~CøOä|EÛ²{™“¯=™OS9•ó%™h[´EJçÓ^=áOg£ù¸Zÿœ‹N47ÁAAùçM€–m·ë”\"ÿtÕùè.©òæwWé¢—ëú–ù2‡àEú'çÀ¬…£&(!ÿªï	úP%_œ~›û%…Pg<‘Ì°°,qú`%Ÿ­EÖÉÁñnàhÌ‹«_¬~ššÈ>Ÿ¸ooÅ¿îÀ–~È1øI›[şÕûÿïî“q±kC,ú­µZ³¿I`Êû?Âÿ 1‘²Ç<',Ïñ„iú)©_¦œ•cEGó^™ê[Å7~íx‰@&çÅN|ŒÆ{¶~ÿûÀ¿¸hNëwõïPşôN3­ÁQäT(³èmHûVFİ¾ÁÑ›ŠÁş)Š®VHÌ¾~‹g\ry8JÅŞ…Í»Mø»\nùò°’JÏû,ø¬ëòª\0âÖò¸`ãH€|,¿/Ká: ¸”I\0–“‘½Wña£üTĞ[ÊÛ.İZÏ¾\$Ò˜şl¯ØY¹¦t¡òy5§±çÉò¢½<\\ Ï}á_Ğ0rbx„òAROfÛ6Ÿ\rğÀÑ?)Õ¡àDœªe<Œ”ïª ñŞoª!0k\0…ñ ùİ°èÜŠ  óÄá<\0ÒÇ€¿˜ˆŒ¶ibTTàĞF2Q‘\n(?oˆÿ4ÿxQ÷\0h/T¾³tìs­S Ní‚è£œFÆ½MŠ7“\0•™ö@Qp'Qœùûˆ\0é~—Š€n	}úqö`—á—¹·\"Xä1xBÎÀ/Àm#Áî2ô^Ğ ;@o÷\rû\0\"xió…N7lnZ”ˆUØEõïh½SX?ır 2XK€—é-> ±y<­z‹às\"C6ï0™”0câ°'ÛšB\$ñğS4'\0hã2½zpıù){¡ã{9&\0îŞÀŞã‘„¶Ì[Z°¼ím?‘™€¸ošÔÀD˜Y+ø ‘£ò´6: Ô¨Q>Q¸ïHX7€¦u-éf¬1@>8Nªˆ<òC~¬Î•3‰B6½Mÿkäöóà\n¿RÓe·z:ğ7G\0š‰¥`jÉì€†íŠÙãÀa6äl,cKzÄ™ÅÖ1¢uÙ¹|vğ9 +¿àg¬ÀÔø«=„ÎsÜ¸·‚\$úİ÷Kwz/^í¿¨‚0‚;;>ŒgÜo¸É}¤Ø„ú¸²7…Íƒ??NôÆ1¬»=ïö ˜³ÖošdPQGH!ÌéÜC·ÍzXvê	“ô\0Ké†á‚eÄËûÔX(í+™†4½‚Ê\nc|Vz/Ğ`ƒ3ÖiíEö`‡Ñà…¸òcÇ9÷úSâğFß4	‚ÿÏ‹çíÜY!¤èb8ÕzàÇæí·•Œ|•AúXàÙMòŞjÃKpàñ¿ë’‘x°'KáF¨ãUğ#Í¿O¨\$Käü 	ÍC‰GÇõ´Ì²À~;gĞ.>—‡«€l‚ÉÇÒfà+ ¨AA¡šÙî\rÆgà¡ ÏÁ¥ƒTÜ \nôˆ5Ìç‰ó.=ıÍ¾™Ãè5§²ÙÏ7ôƒRÎxàbä'ø@8³‚oşäQÔH8ÃŸ(½¤	4Â«˜9 àç¤Şƒ y1üá¨9éx`ä®7„ñ¸;öî W€8†tƒÈÄ`CõcÖ§ƒ*ÁŞD)›SLÈ>\nŸ¡@Pƒàˆ©5RkpLïæFº“ røì6S¤l/›^h\0xOLÚL¤‚]KĞvo ±aÏÍ’KJXÍöÚ¬¸uqxÁÙøcŠwé&÷.8(‚øá¨[|‡\$MñZü7£F:ÉQ½€„ï\\¡7îœâ\rk…¸/-``% cã\n\0ÖOü…µ/\néFqÖGà“É‚,,«	³y4Ù*¡\$AËgÊ:lãÁæ‘Â?‚„¦9í€p‡LıPÏ\0g„¨BÓ1d¬¦‡àï2hêÎ]´ã73½´Gõ·j(ÄäZ`ÅH<\r[™¹!€ Ñøó\\'ÁlVÂíÂ6Hy±Ál!È!ŒªAh>ã|Ü\$ŒÛ™ÖÁ—i¢à¹ÂV‘’ÍäÍ\"6lƒ&İ¾³fKN˜³o¢âÎêµGÓ[2AH\0ÖÊnÂ\nˆTĞª¶B«J¤Ôy´Ë@ø@'†™ŞB¨€:\n…·ãGX%®`æ ã{ÿ­™ã@H¨í\\¶¤N !YË“Íqºæ{Ê\$g5 \n4Ö’A‚ˆ	\\Ö¤l\0ZlÕÌÈt…Æ×À \0\$'>æ dpÌ§0Î©T,U@ŒñÌa§Ô†`\\È”8\rÆHÓ·.¸\0‡ÂÎ\0Âlù#BF¤ƒ¶Ù9s_‰!¨;ƒi)áq9ºHÿ\r\$Ít2	!M¿¹½P®PÂzI;ã¹ŒÊ7 çDİ\"tàI##İ&§TtŸt1të «RÇ¥T€İÜÈ`é3á’?¢O²8d£°ÌO‰J\n”Ì’´3Ã	9’tC&†ja'bLòLÉß9%Œ87‘í€à8°Ñ0Ã\$L\rzd46“ğhá¨%ÕPªnš|0¡_.p<C†@8áÀBà+©æá«(b1‹\rœ45wIPÖD4¨Y†¹|d|1w'I=SG§]†ÔseCÔ.è`ªa³—á14’áÕ\nˆdhPÇR»#V¼ìÁGºä ûD VÇ‘×v†î`b¬5ŠŸİê;³w­yŞbígyÏİë*ùSü«ínê°ÕqÊ*„Ã.xU¥ù}:¶€@–6,uÈêÙ×3ÀĞ\n¯Ô¡;S¸®ø>Š©g‰ÍS¬Bwî©åàÒ–å^Jû¨©´vÉMÒÏ…:ênÔ³)¾SÔ¢ŞBÂu7j)Ô²CÍS~§]ÙBÍøvªX¡éCÊQk1Mì=ut*<Õ+:íH†°Àì:ÑeM€•’®HZ<´yt»­Õ‰k\$]Ÿ-%[¦´­SòÒâDÊ¤—-=;µ\rÚ{´ÅªàVy¬êYØ¦u|’ÏE ËT–t­	Z\0«‘j²×³‹«HÔ#p©ö ªù%¬Ëe–Á*3Y ‘\rlr¯÷zë¦Ò D \0°¶MR¼ÀüËgŒ­ªª¶¹mso«lÕB;`[r·Õ`Âİ%¤äkÃò­ôX\$¨nŠ¾Å+jUP Á[²¬,>š±Å¼î¾±¼Y*» ìR¢e¾Ğûÿ;AÆ±åOŠ‹™K2—sˆºuØ4FÇnü×«iQÒ·mGJ—ó±P¹@#‡ò\\´F½K8Åè¢®o\$dQŞ\"æWWêÑ—8­\n\\î…v,;å^î°R ,KH†®¬>Ú\nÿV®Üw†t	w:w‚*‰{)A\"ÁŒåZõUˆÇC3H¿Õ“€%1sm“~¦ÿ=T–ŒïR@‘uÍÏ:%¥‹TF{âÿŞZ6¿­êş×o€ù\"I‰2†uû'm‰›]7áF´Ø•€œIvĞÙ§²~{ñ„öØÜsø²\0•ÁÉV½­…9ÔvĞ\nAFP(£ÙƒCëÏC°ÁsşŠÜ ÙT°Œ \nÀöy„C FBkPqm}êÌ•ëòèX¯Ì\\¯Ã_…àê•+›õ7ç'zœG7qo\\Òa‚kGX™OjøCó\0UÇÃ>6œ À[°·4,xĞ5„“w§ÃB)6ƒÃ™ì4¢pOuB’…í‹M‚’…_¶\"N ÍçÜxc%™ï92m\\˜ó>&iUX5Á,o&ßQ·Ãy8\r˜ÅB2wT£¸tÖío¡Ÿ¤°TiJ¬\\#˜?ü‘U!¦hl{QŒ;äÍ¸b’@0…0˜QQøPI’Q›¾ŠÉ\n\rÆiE\0‰HÚ®µNZ¿Ò(è¢˜0‘[ØqôJFÒ¦²lT#Â\"º5ƒÉ¡<W§¿áŸÃsŸm’êwˆ0©m¢H×0î+:O„¿]£P’ÄWAÇÏÍb}¨y~e½\$!\0òÀ`Í	é3x:)Èi2†¼áfšô…ªåúºE3?Ñj¤ÂÏÒ‘æû™¶Ã\0»|Ñ°Èk\0’bİÃP¶’p˜@\rÆÛÑ\$2V~Y¨	Xø\0PC}£N\nØÇÈ)AÑ@@\0001\0n•6X8»À\0€4\0g†.à€`\rÈ‡&6‹ÄZ8¨ Ñz\0\0006‹ê\0Ö/@x¼‘~¢üÅæ\0p\0Ş/Ah qzã\0€0\0iş/¤_¨ÀÑ‚bõÆ\0‹µ¾/T_X¾…£Œ/F	\0rav0˜0Ñ{bí€7\0n\0Ø„^xÁñw\0€2\0nq†.Øˆ½@\r¢üF#‹»~1l^è»€\rã\r\08‹ó€´ta0ñâü€5ŒCÆ1LaÁÑŒ£\09\0gÚ1t^`1Š\"ñEúŒ7\"1‘h#Ñ\"÷ÅŞ\0aB0ì^`Ñ|ÁJ +\0l\0Î1üaÈ½ñ~€€9#ez0ô`8Æ1—£0\0002Œsº/øˆÌQŒãÆ\\Œeª0¼d8Å 	´ÆfŒ\\\0æ/TeH½1€ã,Eï\0sî4,]À@\rcF.ŒL\0Â3´aØÄ˜\"ü€7‹ã2/H\0± £FŒçv0Ôiø½Q†¢úF|‹ãæ0lb(È‘‘ãÆ•Œ¾\0Ğ‘8ÍÀ#Æv1ÕÎ0<g¨É±}@F°Œá†5Ô]ÈÏ‘Š£F,]Ò5,fXÏÄ‚@1\0006Œ<ax™übèÙÑ¥¢úF&‹½º3”_ØÍQ‚cÆœ\0p\0Â0¬g\0àcAF4ŒiF3¼làÑ¯£;%&Óæ4\0XÙh\nÀ\$Œ7–4m˜Äqã@FÁ‹ë6\\b \r#MÆŒ1ônˆË1y£UEÛ-\0ĞÌp¼Q€£FpŒ5b4ì^HÒ \rcuÅô\0Ú4ÄaøÀÑ°cEì‹é~5\$bèÜqÉ£}Çæ/«ØÛ‘›¢úF%#ö4<pØ½ñ‰£Æ‹ùş9ta0‘­#€39ê6tmP‘w#ÆÙv2<nÙ‘´ã^Ç:‹¹~:´ihĞñ¤c&Æ–‹¿–7uÈÆqÀã9Æ‹ãZ/ø8Ç‘Ğ#-ÆÛJ6„`ÀqÆ#o€4ƒ8¤vXŞQË#\"G\"ıÚ2<qèåqµcÇ\0cB8ÄnH×±bóFè@W:\\uøåQ¸ãDÅú‹ã&/„qXêq‡¢îGOŒ›‚9k×‚ã.ÆÍŸ.5DqÈÓ€cyG‰	ª3D^ÈÍñãÅG\nŒÇÎ2kxî±¦£“Æ–½ê;DhxŞ±¶£}FwŒ<\0Ò<ôc8ÛñÙcxÇÉ‹ÿ^;pøÜ‘Ì#pFì@WÁ„lq(ìqÊctÆ;E:8ğHÃqè£ºÇkiÊ6üaøä‘ˆc™F¿X¬wxÒÑò#œFãŞ7Üp˜îñÚ£/Æ–<„xxìQÈ€GÚ‹ê\0â;´q¸Úñ¾ãKG‡Œ3Î<|n¸öQ¼AGÑGr8cèÌñé£sÇÚŒœ\0Æ5T{¨äq¼ãfÆmÿŞ/ü€˜ÅÑë#	G-—ZA,nş1Ğ£ÅôŒ• †?D`hø±Ã£p‚Œn…^<ÄmøÕ±‹€’Æ'{Ò<œo(æ±¯dG\0mj8|møãdÀä\rÆFŒ!67Ì~âïc%Ç½†HNAÉhèÙr£IÇ8}J4<wxÇÑµ#GHO+º@^¹ñªãˆGw‘:~ù‘…ä*Æ„“?4dĞQí¢îFÎB¯2D<r¨èÒ	\$+F1’DL|hÂñì\$FæB|~HéÑšäÆG\r¢/lfÈÄ1}£È½\".DÔ_øãä?È(Œ\">3”y‰	ñ\$EGO‚?\\v¨ßÑÖãOÇŠ¡\"D¤yÏ’0cµGÕ!²>4thë1Ú€H8grFtmø¾ÑÙcIÇb‹ÿêD|‡xÀ±‰£¬Æ ùJ4„ˆHÆ’#;G×É^F<‹¼¾ã^H»ùÂ@”ŒyQüãÕÆŒéZD\$_Êñ¬c\rÆ4 ®3¬jˆ¼‘òcFÓQê>tn9	í\"îÇ˜Œi.B\$xxÓòCã´F_‘›\n6\$gÂò!#H[ŒG\n=än(ı±‘\$:É\"Ê>Ì¸ó1ĞãnFiŠ6Lh¸ãÀ\rcµFŒ— 0¤rŞQ¡ã¢ÈÏ#ö:èèÑ¨¤È¥5 21€hÆ‘™dRÉÓÊF\\`yÑ}¤¦FÇ\$˜˜nXù\0¤qF OÂ1Üx)&‘€ÈÖÉ!â2\$_XÏ‘ÍdµEáŒ5–JämXÓrN#%Èâ‹É¾5\\g(÷òXä4IGQB9e¨Ó€¤ÈìŒA\$r1üyXÇÒ&c‹G/‘Ùr7ğXîrAâîÆğ‹÷V4„‘XÄÑêÉÈŸ%v2¼„ÒN#¡Ç!‹É&N6”‰±Ïã¾Æ,Œç–GÌ€ˆé’\0\$bÈW%ê9Äb	ñÖc˜Æå’ Â7¬i	\"ñ£ÈêË\"=djé\$2ZcyIŠ\">7ˆ½Qó£iÇhŸ zHiÉ§LuI@’×î1œ™±¿¢óI2’Á\$N2<ˆà‘î@1Æëå&êJDøÊ1ˆc©H<ç z7¨(É‘Ú¢òÈC’IGœg(ßÑÙ£Çß–/T‰	!1¨#jÆÎ­\$vN„‚ØÈ’~dÆ–Ç'‚@,˜†²J\$ù +a²?ÄdHärã “‘ÅÆF´€ˆÄÒOcOÈO“g2>Ä¸àQÄ#ïÆ’U*B¤˜Ù;Q’äIù‹ûšK4^¨İrã9F&ø\nRR!…ØÜqÈcI¶’_æ9„o(ì±‡À’H?Á264†ˆÿ²†\$ÆIO”/\$’2<v€\$²K\$I4õ&J=ì“YqĞäÅõ“á ¢<˜Ò¢cIâ”Á%–8Ü’èÃ±ÂdU˜^ı(ªGÌ¤¹:ÒFãŸJŒ\$&K<¥/Ñ¤€’G•)vO´iI#ñÈä‚F8‘ó*Sü`i:Ñ¢#Åİ“A)B9Ty	2Ñìã…Ê+KR?¤ªxÌ2¤\rÉÕ”Õ\$ş8\$b©2'e=FM#*JOœhHäñŠ¥&Js”±*Î2ü~ÈÓ’7#i”eGÄt)*±»cMIJ”?‚8,š™QŠdJ)Œù:;L›èËñÆ#\"ÊÜŒ\"ş;œ•8îqyİ\$Ãx~e*áÅDuÔc¨ RÒ»…qx~ek‘ı¯° ²±dÒ§•—àaV\"ª{WïqbÆu(2¿Uı+6TÜ¿ªWä¯¥JÃy)>Vª*X:Şøwdpe‰¬sv¤ëá×\nÇ5 Ğö™¬w\0WùH4±U\$ë-È.ÍU‹¾CÅ¥>èÁå¬s‘,¡Õ»®IeTN,M0@\nc\"¦˜/À!ƒ\0–²iJ¢Å(t+\$Ö–©l´¾Y°©g¸Ú)\"àHiÙº’%²’Ô–±Ëv@\0®XB”%²Š±@)€Yv€F°írÆ•½î¾”ÍK]–¾¥Ô¶%DèÁÖ‡ÓREö[{´U\née˜:æ–e-Ä•Š–Åàdp]áÀäyç’Nc¼Q9À\n—9éI…5aöTª»”R‚¼ĞıË+ÇürâŞØ—(µÉY¤@ƒ°Ğö•]C‘—+à*ßE…îßİÃÃš¨ñr]8~9tŠZ¡ìË©•ì§\rİµ9c2éâÄ%ˆ–­¼’œ»G{!ù‰?‘Ï–“.õLë½ ïÀK´Yr\rQŞô´€0¯ôVF\n´š^B²X*…9;Ş\0¡•Ğ5Eë*%‹«o–2«ŠWØ…òöˆú¼V—Ä§İd›°u÷€Õ\"«­¨±+ëşµâ'€VJ&\$h£KBĞĞË'¬”wÄtvZKT¡h‹Æ—¬LC½/ğ”BÆà\njr”©ˆº\rQXÂËTÍDs¼ï­t´½ğı @!*¾\0’ºv_ìÁE|k0ÕŠ€BY³}ŠŒå( RŒ¢ígÆ^ºğ%{Ëó]ÒKŞWÑE€`à:\\Ölõh¢õİ–:óPUàaW)ÅH‚±ÎX4¶©ˆÊğÃöË^Ë-¢bTÄI„\nqaí#éT°´­N)BV*qU8¯¸\n±0*µµKV…(²–¬©bZÌÆ ûV	†Vi1\$\n´Æ•Ï+©&2-L˜êïÕ`ì;òCPöK)˜òë2cØemÏÀÂ£Zrp°úaœºÉªµU+b#¡25FDÈÕ’aúâ|uxÁÙxÓ¢´JK+–K |=‘;Æt ÕüÌ¤‡œa\"­Gq«áè…X/õ‡I¡¸ğ_Œy‰I™]¶[tËu\nøÖÀ/ ¨ğ,>šÛU’k€Â®ì¨¯©F½\0000±%fc¬R\0¡wÂş™k/\0«\"3V†îeÒœÙ˜HŒ‘ş®¸Wª¥±Ú+´w^s.aíÌ«#PF¨L4Á¥÷Îµáà»€ü4¼¿™œ¯ÃşÌN–À&bŒÏ5f’Ï]úªn[‚£şg“µ`fr;Q^´Ògj¸wUjHIM	W*ì¬”B°\ne´ªØ¼£Ér\\Ğçu8ÃKZ¬­±o£­”ˆ å€Ë³R íhÚºÀúóDòKX–%4hê×E®ÓC”áËQša2­Hù#I‚ä}f’Ì7šnğniË­•>k#&})SR«3	[ø©d3OÕš*	R¬ğ<ÔÉ¨ÓSÕêßx49İtÓéŸJ(¢G(³vÆ¥~hrib“T•İK™òª©ÚÂõ\nZÅÍ_¥4¶jÌÔEUS[×á«@š92­VÊåÉ®ïÔ¨Ë}šÈ¾ø?‰!é’Ãf}©^WÛ49Zj¦¥İªÍ²‘Ø›3²kù) ®Ñ^LÏvğ®¦ht°ÅK]fÍ™\\&©ºlä·53sHæÍrvê©ÂctÙ•z³/U »x™í1BcŒÒù¨³TX¬¬_o5ıNÂ¹Ùu³n&¶Í_)5ıW´ĞéjË¥ğ-›f\0­š¤Õu.´ª’Sšˆ«–gu\$•ıLçXÍ3©Ø¬İIÁüfxÍÚuá-šb|¶¶3<•rÌüSLê¤“Ğ	»ÊãfÌé™È«•\\r?©‘òè]ĞM—î´@Dß7Ê4Î‰¸š'3âh°ù£\n;æú<#š77®iK¯\0\n³HU&Í¤š	7=ÜÜà•#Êµ&ı¯Óš]7’p‰#%®¡ô¦õÍ5‰\r8uV‚Ê‰ƒ{§<#š‚±R|¿×u«m	?ËÜš”tJo\\Ôé©\n~æ¨Íùw78ÊqlÕY\nŒç©/š´îÊq«»C¢SXç<#˜á8^o\\Ö•ÜªuæŞÎEWõ5Ñcœ×>³g'¯Éœ-5Úo\\×•[rå§*,†w‡5úrr—Ù°/å†LnVñ6_tåÕ™èüæÅKU°±Æo\\İ™ÍS:×Îqvç7­Û´ç‰³óH`ÎzUY6np\\Ú%Ò“I'ÎSœÂ£†cj“éÏ\nüexÎx›Wzeôç9¼=æŠÎH\$fm¬µé½jv!Ì©w795Ş’°É½spg9ÍÃ[F¬­Ø<Ş¹¹.ï×?ÍÌx5×¬İiÄ‹ğç9(‹–®šnâu–­çIÍ°-:Út­á0®¸&­:õ›Ì©bgü¿‰×j–`š¥×ª‘~Ñçe¼œ+7ôDÑGU3€—\rÎ€©ºp:‹™jó„¦ĞÍ\"]+:Î_ë¯ù£àU–ÉNš[-e×¬áåˆ3µU½Í:QÃ8¦w iÇ &¤¬\0œa;‰RÄï¹ªX'€*n8êj¼ğW`“±]‹ª!ò³rî—bó‘çxOSç9-E¬ä×^³”'…Î°v/<ru`ÚÇ×-Î[G-^kìòuKöNd›Q9¹~\$æ€óÃæÄ‰„`¢ıSŠ‹{NÅ'6O6›9ÂxS­i™îÅ\"4Oœó=W4è	³³Ò&ÍM ;št\$î‰èÓËç•;1½p\\Ï—^³¯fñN¿‡\r2¶vü=‡y³ÃæßÏa‡Æ¦ªzDêedàU§TÏHVìbujüÙ¹³#¯íöz<>w‚djV(­hXê©Z{á!	j@V…O€\0 }Z¥`ıÀ@\$ÏŠœ‰:âg‚uEïTrOŠ–¼¨™d|¯i UO“wÇ3È?Ôî\n‡C+\0Vg+ñg*›åÂ²ÓÀ%ª”\0š}âºÔ×^ó\0ˆ-¯]¦¤ˆÄJ/Ä° oçÜ7á\\7-9B‘‹³Ã§á*Ÿ]-:~2 Ğî¼e·‡Ñ[--éJ¬±™óÇGf€‘Ø\0¾F­]i©mëƒ§Ä©_œ¨:~œùYûÊ¿U\0S\0¿3F\\¶ğ	ÉUjÏáŸªHÑÖœÚÕàsüfÜ¯œZ²<q9ıS§ïOò–ˆ³ü®ÕÕ\nL¦ˆ\0_Q9uT¯So«äb®rx\$³ª}ú‘€±–…Ğ_':Š€’Õ5ÁŠõU )«Z¬¸d„Áğú3æh:ıH€¦â|ıUYÿ§÷)¶—C5)PÄıªñWP%Q–FÚ_İ5„nh/¹ =7It4gîÍù\0„´J\\¤áU¥sæå¬’&šV£Mi\\ìÚ	3D•ĞM#ŸA(Ê¢h~T&ÙPN ±Ai\\)t4è*;+GÍ4LÀéqn¼‘ùËŸı@\$tÈI¿4\"<;—SA<Hš“<§vĞe Äñ¢p¥Yk4h(PfGéA¡g\nœ%vDgë©³¡®ÍkDñuBÔ#èF\\™á;z µÉËJP%ÓĞ‹\\¤~oU	JstÔáN!U.Òn2ªZ@\n(UNİRÁ/=`´øŠ”,ç*¨¡Vª•Ø=%•ô-ª¨Ÿİ/!`µùyë!í-&\\19*„\nÀûäI@KÑY=3	NÄğ%ŒáôN‰PÂ¡Y8°”æUÓ”\n'êKÚ#XºÅ`²Ô@û T€ºµ–R¸VµĞ0²öèr¬.Xo8¦fò¾\nÄ WEL¡ÖF±cmuwÈ h|ËçUÇ6‡Zª…}´*×ë,ëXx´MR\rWƒ gó-+¡t¥Ò°útBV¨P•ì¯igUYÛ«=\",éXİ;NÀ}z#ë;ÃÿOéZí’|Å\reD4J²PèXD§ò„	x{TL	[¬µWãD™d¤ş`\nj«Š‡å¢e0*‡êŸÊÔNhKÔ\r0A»Ó¦Z3Û½QKŸ1A\\>ÅrÍ^(Nÿ\0P¤	\"À¹â45—ÎŞ¤&m¸€şT+è±NDZÓ?-I‚‰µÕAú©ÍD^HÒf…Z‹Vl\$¢–»¼)¡ôh»¬!Yš¨±`äÄBJDtu©6_”§Œj1ƒèŒĞ³\0QDÕuÂºš!ôbÉ)ĞÖ¢k@¶‹\"ãåXça§ŸLK\0ÎŒòëUŒ3”N\"3˜¨¢½g*àåòôdæ\"*í£S?^xŠı…Ñ4c`G\n2¿EOüãZ!jmªA:2¾à?Tíâ8d…Ôş,W[=6‚(\0\nàë¨Òuf¾â]E’d‡	PE#qù~‚•;jÃÙ¬•ëGzƒŒÆEc“6æ0‘Ï[^¢nc\$:5ô'(ò«KRƒ¢ouú¦0Ä˜òºÎcÊàjÊ°!í-ˆ•Ø³ÑH\$úu;*]h°»v¡WH‚(~åxSæf†OâT…6~†³­¤~ÓùèRœSHEsÍ!UÜ*„‚\0‚ÉÜ³Â ZC§±˜«*œ‰Frq«¸EB­×v*TYéHDèäÉ2C”sÕ«ÕŸÍCõQ™\"`\nË\n©MÆZˆ°¨ªŠ•B¢Q\0T„¨6’°Ê@ê¼èÖRG¤”ÖW²©JIô‚W|ï\\tUP*¢uA•RZRH´’½5HSåÖ÷ÒTN‰ú’úÏKª¢¨rOe¡é2’X–u«kÖß,µ¤àJFœ=©˜Kºh¥’ˆ¤¶³Æ“\nÉ5Úª]çÄ-\nTHe#¸ºnôçPE¥CYJyrDÓ/æ\\)A#Æğveı!ZI”Ré&PE]Ù7³Æ§ÇHå±2‘(ŠT ³©QŠ)¥Læø\r´ˆ@1]\n\nñ°IH«°+@Â®ÿ_Ğü±óò÷-ÉFšE(pg¸‰1p.QkM©…÷ÈÕ :\nI€Ä-\0V0ø¤y@‰¢„›4põ-Ğ1ÏL@Ï\$G†4mĞ3xÕI\$¼G=}K fš…ç;àÀ2\0/\0…–3\0bË`Ç\0.H\0Èx)\"@IaŒ&’‚ÄÔ™!-´Á’¢S\nø\0Ò˜[©*`á¶)„Æš¦\"½)Í0à\$ \r©‹Á?¦(ğ½1Úc4ÇÀ’€8¦ELL1xWÀ4Éé†Ó\$IL°ü¸bù+‘Ÿ)˜!|”…àM\nbTËi™S\n¦uLb™E3xÀÔÍC˜ÓB\0kM˜E3:c”ÏéS=iM\"˜¥3:dÔÓ)‘ÓN¦WMRš•ÊeôÖ)S7B¯MB™ìbZl×ÇÓ\\¦b~33JlÔÍ©´Ó9wLî›< =cQ)¸S6”Mº›¥4\nk²€)²Óo¦õMÆS69@ÑéµÓE”M.›õ4Ğò€)Ó…¦(š8šj´âÀ’ÓW§%MM(\nlrŸ)ÍÓ8§;†œı1\nqÔÅ#„Ó„§/Mv8M8Šo4â£ıSŸ§#N®œœpšrÔì) Æ>¦·N›=;jntÃ)ÜÆ|¦ñNò™´˜zwtİi¢É‡§O˜D˜zo´í)®É‡§ENâZtÔó)³É‡§UO,„Zlraé×ÓØ§“NVÜgÊsTèÃÉá§‡Mş6*|€äğÓË§½LRO\r<úz”úiéÓï§Ëò½<Šb‘wéµSĞ¦‹Oò=>ŠôÏ©ÿS§ùOÊŸ°øÛôÿiùÓE¨PœU@º}ÔşƒÔ¨PR U=*luéüÔ¦P.œm@Zb•éîÔ¨NÎ L„*|uª\nÆ|§ÏPFõA¹u£ÃÔ4§ëPšŸÅCJ„5jÆÃ¨iP¢¡Ä•Ê†R~ª!Ô§'. Aê„qõj!Ô7¨•P¶/•D:‡u\ncpT%¨~DBúrr ê#SA‘Q&œTˆ:‚õäAÔN¨ÃLn›ˆ:Šu\$AÔV¨Ï £M>*4×éõ–‚§ÕP²¢ÅC:²µê9Ôf¨·Pæ£Ü]êuª?Æe¨ãQ\n£İDJ}a_*T	©QvšíHÊŒäêFTc§R2£õ4‘•jK%¦ŸLı0]9ê”	ojSy©CM¥\\šƒU*RôÔh©X—ÎÕJô¿TÉi‹Ô§¨€›n¥%;z”Õ.ióÔ¡¨ïRî¥T‚\n–µ.j1Ô¾¨Rú íKêu.*`ÔV©}RŞ¥\rHŠoÕ4j^Ô¤0»S¥TŒÚ›+c^ÔÛ©a.¦õK:Š5,uÆà©—SF¦uMjv`À4Æ%)&U85Mšu;c7F}ÙR†3Nœ±Üê}»“éSôœ~Ê ˆjbÔ¤T0ÕPŠœõAªtÔª&T:Q\nšµ*£¼Õ¨“R†>EQ\n˜õ)#ñUªTR¨mJØâ@ãU\$¨R†I¥RJ µ*£MÕ\$©“R’?RJ¤5,#yUŒATÚ¨JØÃuMª‹Ô¤×TÚ¨İJ¨ËuMªÕ:ªgRÎB}P8»õRªœÔ°‹ÙU*©íJ¨ÇuRª Ô­Œ?U*ª-Tê¨õ9cqÕ¿UzªmK8ÎUWª¨Ô­Uzª­K¾µWª¬Õbª·Sø´uP2ĞU\\ª°ÔåŒ/UÊ«-Kàu\\ª´Ô³’ËUÊ«mWj­õ@cˆÕ\0\nùV¤mO½4¿êÄUyKô’©]XºbÕ9\0İÆö«V¬¬ez±4Ş¡W¨WS¬]GJšugj_¦ó«IV8çZz²)|Ğ«Õ}«RM¦¬5H*²‘x¢îU±«8—&1-Yú´Õn*EU£«yT¬íMª¶q‰jÕÕ©ÁW§[ê±q‰ªÃFn«›VŞ¬]Oš¸u?*éÕÀ«q¬4vª»5kªÊÅë«³VA]\nµ•DjáÇK«\rTV¯-ZŠ²µFjòÕÜ‹ÅTv¯-YŠ½õx*‘ÕÃªKWÚ«­YX¾5aª”Õö«‹V¦©m_j¥õn*˜‚È\0FÀ\\Ÿ©<Õ3*ÅÖ;X¾HjÁQ²ÓÇ¬¨wXB°L‚½µ…cFUü«ÅV>©½\\8äaªÖ\"«ÕŠ©ıb*½ÄÚkÕ‹X’¯Tš¸uRëÕùŒ›WZ¬\\cJ°ÕTëÖ+ª¯XÎ¯”^:Çu‡êÔÕc«‡ª¬5VzÈõŠêµÖG¬ƒUÎ®dº°Õ]ë(Ö'ŒËWş¬¬nJÊu‹jÖF€¬§Y\rİ3: W+%ó’¹XJåe€Ó•dêåVf!Y¤ıfÔ¿RW*ÁÉ\\¬Àr¥Õ[´½2~«V\n¬ÇS\n­œŸªÍR~ª÷Iú¬¹YÎ­•g#r~«:Ô†­SJ­fj·µ¤k9Ô×­Y¢¦íhúĞµrkJV‹«™Z>³©…êar¹CM?2¥ŠåĞDí_²Ä'¤NáÍ,}gŠè©ĞÎ¿Ôş\0KÛZ¾r”ñ)jóñ+Wª!¥<<R½ÕL3ÒQF¢ø£åY\\êJÕõ±DÂÖÇQ–£ÅGš­ùáïg»[¶¥2zB§`	k¹g‡Ğ›œ¹Z½QzªYæ“ÏfÅºĞœy=\"u¬ôIƒÿDmRA=MÛÔõYÅ¶ç£*'Q£<=NÄõ÷pnÉk|M»­_ZşzDöW^µ²¡Ä-Ÿvi\$Êµw³k+OORD¹\"[ŠÉ*â3Ÿf¿Ä(–!4:oŒâÚãAÈìVâšÿZ¹Ú¬îµ˜„ª¦V±­é\\}s¡O3@f”Vµ­nínqôÚi£µ¯UV¾œšªª¶\n¥)¬ e¬æšÿ[1t’œŠÙóÙÔzMÇ®[:¶MmTtU•UVÔš[^„tÜzÛU·&¿×SšÖG¨dÖêãÕÔ§’Ñì®¸¥)`´Ø‰Œ³ç7Îó›#6Bn;¬Uˆ«+wL`›=»{±Çxt¦¿©Y®·6ºtÍpS^Õ®ª²­ù6â·ó¸¤ˆ3C©F,p®³6úªªªÙRçf÷¯›GèHeR¤æIÑä˜'HÎ‡WZ®Wtç:ã4:«ËV®wO\\‰E-'tõÉ§«ú[èb¹TÊzóµË•TN=v»:rğJòÕÍ«ÁÎs®s[¼±*šçµê•r×G%S[\"¶„öŠòÕï«¡WIH\r[Jstêù\$q+lW–®¬¥W-mêúæëp×aœç1ªyıvjòÓ­]İLz­Ø°Î¸”é*îNñ'<N˜\$Å:jsœéÈrõß”ÀN›­ü«¢u¼÷quá§<#Ê«Ö\"Ë'{ŠÄQıËÈx0\"»[¯ÊjPTUı°\0ë6edÌ÷|ÿ†,“X£êaJ³9‡³¹WÜ	„¡’¹Â’¶	î±–ªwõ]¹ßä»•ŠÒ÷§-EWp±VzÊ‰ÖªÓtÃ°š‰2¦X)J§I&@N7-šÊ'GÜ@2¯¥l%åØ6\0‚\\õ20i€{˜êm„€\rÒá‚ä±úb½@¨qÜÑ8ÏA@ºË;=ÅM¡ùù÷ˆ/Á¡a½\$±,Ğ«mQĞ_ËBy†A‡v'Œ&(~Æx%†tòŒ„/ï‰z‰I˜Xk¬·¡XuJ’ñåUˆk6Mw‚w±–Nªò6\"€ƒXubÃb)ï5‡VDzP_„>dbõ\"`w½í§^—0yA~S„ïøğZNøğxm\\„–Û´¥j7ád€¹§xÜ ¦eLxØ `Mä1WKFRyš†*ğ43´‘b²{†(ØªÖá9b„\rŞ^]Œ¨FZeå<F\rcT0òEså0¡`ÛL¶(²ÃŒ ¥îKüŞ3¶ô°ÔÏ°qóÏD¶,ì50)KÍ…¨“Ì0)`aP€X>“cÒ&(G÷GìÑ)ô±¼!Z¨©Ç ÍM‘„L²c\\ûøŠ\r,GÀØÔ`‰¥‹Æk\",dÁ2h40ê^sN³âV'ly´ë%îˆä9«K-,X-µ7`ƒbÌ®X†dØl\$ˆÿ°#ü+2S!‹âR zh¢dó¬Ã‹Í8ˆ|7–h¢ÿ¥†‹EßLfaO‚Xc%e1}”F6RFdc£aD+#ï£¸™l¦<¬²ßÒÊdN+ÀğÀà´QEzÀ\r§P%A‹Ÿà‹ö²Â½œ}++,¶FlŒ4Q<ëa03p¼¡¹ Õ«Yt{ğºÅxPõ\ræ™ˆÁÌlàÒË½—Ö@ï^l½Y!³\n!)˜µ\0–ÍlÄ¸:{aeŒı—HD)áØâ„zš©ü5™%ì)ª€Ö LiÕfZÌ¢€DšÖÛØ[\n+f]÷Jà¢­&\0:A±Af¬ıšóé(Y±Y;¶ Å€wTÀ¦Í­›à9p&B®f<{ä}œAPbË›O\n¶³Šóh<œw›C:¬é%„˜Xéñ“¢\nÆ@§nå¡[{ygyîÓİ\$ÄVxAÃYÇ<rhšÎ8tVcÌ*,õÀ·²cz&8B :ÒÓfBØc³å\n%zDÈ[\$s!l’jÄnÈãgôî—_ØØ¤40ñ…Sk%çJğƒ¾aP\nªAa!°!,šVú\0CËkB–œxd^#À1xÇ«C6„À††/oáhÑRtJN@6À·´Pà´Ï‹'‚Š€€Z´J	5ğh\$Ë@Ğ mÂIJÆÑµ1Gı\0“‰	Ò°PàµÛ‚G°™Zd8ÈfÒsŞ¶ìˆ¿ZT\0ÚÁÙ\$³€@JÉmÁ+idÆH*kKæ}„Ñ V!i`1}Œf•\0HlÂ¾´²nÃRvwÍ6œm,‚£ƒGi¡ChS4Öš,MZc´ï©Ş€+6ƒl1 É¡‰»\" ğ‹Ê‘)Z‰OqäîDÊ' 6}*½±{jû+R À”=(²2ÄŞÔ½©¶bÂq×­Z«gâÆóĞVT–‡ì*#ˆµRÄô!Ë9çŸ¯@š¶fµijÇ\r«K-L«ÀÚ€Jä®Ôh`èM`Ga5Å;Ğé§¸ 0¬|ª0é°…k-­à(Ká¹œÚÍ3kXŞ½šû!Ö\$@ÂØ“±<øAë\"‹[°fK	¢€¶\rRÓ²N{]\0Qiz*µÖ%È‘h‹W´­mv96²ş\n€µ®ôå“é[EŠ;d Y]àMmwÏµŞ0˜n=®÷F FmqZô\$ ôıÒ% Tg\níwÀ8<„Ì•³•Ôw’Ïf„P‹U*-c—hµĞ´eÂÔH’6ØàŠºÍ´¹ÊNl8IGÉÖ\0 Û2|u¸ÊùxºO\r½¸SK½˜ºÉ3À(¶WrIóĞ49€qˆÙœÄÍ´·N\0	À)ŸñsmEÆ¹+g“-¢½í¶•md XÔ%ëixFÈ¹	ò€#6×S’[RL#Z‘D=²‘õªEES<¬ş!î5Hª ·’Úş x²ÓlJ³-Œe‰!×ŠwîÉ{Ú©zïİZL öaÎ¼á»+\$UF.áb9]");}else{header("Content-Type: image/gif");switch($_GET["file"]){case"plus.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0!„©ËíMñÌ*)¾oú¯) q•¡eˆµî#ÄòLË\0;";break;case"cross.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0#„©Ëí#\naÖFo~yÃ._wa”á1ç±JîGÂL×6]\0\0;";break;case"up.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMQN\nï}ôa8ŠyšaÅ¶®\0Çò\0;";break;case"down.gif":echo"GIF89a\0\0\0001îîî\0\0€™™™\0\0\0!ù\0\0\0,\0\0\0\0\0\0 „©ËíMñÌ*)¾[Wş\\¢ÇL&ÙœÆ¶•\0Çò\0;";break;case"arrow.gif":echo"GIF89a\0\n\0€\0\0€€€ÿÿÿ!ù\0\0\0,\0\0\0\0\0\n\0\0‚i–±‹”ªÓ²Ş»\0\0;";break;}}exit;}if($_GET["script"]=="version"){$r=file_open_lock(get_temp_dir()."/adminer.version");if($r)file_write_unlock($r,serialize(array("signature"=>$_POST["signature"],"version"=>$_POST["version"])));exit;}global$b,$f,$l,$ec,$m,$ba,$ca,$pe,$fg,$Ad,$T,$_i,$ia;if(!$_SERVER["REQUEST_URI"])$_SERVER["REQUEST_URI"]=$_SERVER["ORIG_PATH_INFO"];if(!strpos($_SERVER["REQUEST_URI"],'?')&&$_SERVER["QUERY_STRING"]!="")$_SERVER["REQUEST_URI"].="?$_SERVER[QUERY_STRING]";if($_SERVER["HTTP_X_FORWARDED_PREFIX"])$_SERVER["REQUEST_URI"]=$_SERVER["HTTP_X_FORWARDED_PREFIX"].$_SERVER["REQUEST_URI"];$ba=($_SERVER["HTTPS"]&&strcasecmp($_SERVER["HTTPS"],"off"))||ini_bool("session.cookie_secure");@ini_set("session.use_trans_sid",false);if(!defined("SID")){session_cache_limiter("");session_name("adminer_sid");session_set_cookie_params(0,preg_replace('~\?.*~','',$_SERVER["REQUEST_URI"]),"",$ba,true);session_start();}remove_slashes(array(&$_GET,&$_POST,&$_COOKIE),$Xc);if(function_exists("get_magic_quotes_runtime")&&get_magic_quotes_runtime())set_magic_quotes_runtime(false);@set_time_limit(0);@ini_set("zend.ze1_compatibility_mode",false);@ini_set("precision",15);function
get_lang(){return'en';}function
lang($zi,$if=null){if(is_array($zi)){$ig=($if==1?0:1);$zi=$zi[$ig];}$zi=str_replace("%d","%s",$zi);$if=format_number($if);return
sprintf($zi,$if);}if(extension_loaded('pdo')){abstract
class
PdoDb{var$server_info,$affected_rows,$errno,$error;protected$pdo;private$result;function
dsn($kc,$V,$E,$Af=array()){$Af[\PDO::ATTR_ERRMODE]=\PDO::ERRMODE_SILENT;$Af[\PDO::ATTR_STATEMENT_CLASS]=array('Adminer\PdoDbStatement');try{$this->pdo=new
\PDO($kc,$V,$E,$Af);}catch(Exception$Fc){auth_error(h($Fc->getMessage()));}$this->server_info=@$this->pdo->getAttribute(\PDO::ATTR_SERVER_VERSION);}abstract
function
select_db($Mb);function
quote($P){return$this->pdo->quote($P);}function
query($G,$Ji=false){$H=$this->pdo->query($G);$this->error="";if(!$H){list(,$this->errno,$this->error)=$this->pdo->errorInfo();if(!$this->error)$this->error='Unknown error.';return
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
seek($C){for($t=0;$t<$C;$t++)$this->fetch();}}}$ec=array();function
add_driver($u,$B){global$ec;$ec[$u]=$B;}function
get_driver($u){global$ec;return$ec[$u];}abstract
class
SqlDriver{static$lg=array();static$he;protected$conn;protected$types=array();var$editFunctions=array();var$unsigned=array();var$operators=array();var$functions=array();var$grouping=array();var$onActions="RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";var$inout="IN|OUT|INOUT";var$enumLength="'(?:''|[^'\\\\]|\\\\.)*'";var$generated=array();function
__construct($f){$this->conn=$f;}function
types(){return
call_user_func_array('array_merge',array_values($this->types));}function
structuredTypes(){return
array_map('array_keys',$this->types);}function
enumLength($n){}function
select($Q,$L,$Z,$sd,$Cf=array(),$z=1,$D=0,$qg=false){global$b;$be=(count($sd)<count($L));$G=$b->selectQueryBuild($L,$Z,$sd,$Cf,$z,$D);if(!$G)$G="SELECT".limit(($_GET["page"]!="last"&&$z!=""&&$sd&&$be&&JUSH=="sql"?"SQL_CALC_FOUND_ROWS ":"").implode(", ",$L)."\nFROM ".table($Q),($Z?"\nWHERE ".implode(" AND ",$Z):"").($sd&&$be?"\nGROUP BY ".implode(", ",$sd):"").($Cf?"\nORDER BY ".implode(", ",$Cf):""),($z!=""?+$z:null),($D?$z*$D:0),"\n");$Kh=microtime(true);$I=$this->conn->query($G);if($qg)echo$b->selectQuery($G,$Kh,!$I);return$I;}function
delete($Q,$zg,$z=0){$G="FROM ".table($Q);return
queries("DELETE".($z?limit1($Q,$G,$zg):" $G$zg"));}function
update($Q,$N,$zg,$z=0,$lh="\n"){$cj=array();foreach($N
as$y=>$X)$cj[]="$y = $X";$G=table($Q)." SET$lh".implode(",$lh",$cj);return
queries("UPDATE".($z?limit1($Q,$G,$zg,$lh):" $G$zg"));}function
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
slowQuery($G,$mi){}function
convertSearch($v,$X,$n){return$v;}function
convertOperator($xf){return$xf;}function
value($X,$n){return(method_exists($this->conn,'value')?$this->conn->value($X,$n):(is_resource($X)?stream_get_contents($X):$X));}function
quoteBinary($Zg){return
q($Zg);}function
warnings(){return'';}function
tableHelp($B,$ee=false){}function
hasCStyleEscapes(){return
false;}function
supportsIndex($R){return!is_view($R);}function
checkConstraints($Q){return
get_key_vals("SELECT c.CONSTRAINT_NAME, CHECK_CLAUSE
FROM INFORMATION_SCHEMA.CHECK_CONSTRAINTS c
JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS t ON c.CONSTRAINT_SCHEMA = t.CONSTRAINT_SCHEMA AND c.CONSTRAINT_NAME = t.CONSTRAINT_NAME
WHERE c.CONSTRAINT_SCHEMA = ".q($_GET["ns"]!=""?$_GET["ns"]:DB)."
AND t.TABLE_NAME = ".q($Q)."
AND CHECK_CLAUSE NOT LIKE '% IS NOT NULL'");}}$ec["sqlite"]="SQLite";if(isset($_GET["sqlite"])){define('Adminer\DRIVER',"sqlite");if(class_exists("SQLite3")){class
SqliteDb{var$extension="SQLite3",$server_info,$affected_rows,$errno,$error;private$link;function
__construct($p){$this->link=new
\SQLite3($p);$fj=$this->link->version();$this->server_info=$fj["versionString"];}function
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
__desctruct(){return$this->result->finalize();}}}elseif(extension_loaded("pdo_sqlite")){class
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
SqlDriver{static$lg=array("SQLite3","PDO_SQLite");static$he="sqlite";protected$types=array(array("integer"=>0,"real"=>0,"numeric"=>0,"text"=>0,"blob"=>0));var$editFunctions=array(array(),array("integer|real|numeric"=>"+/-","text"=>"||",));var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL");var$functions=array("hex","length","lower","round","unixepoch","upper");var$grouping=array("avg","count","count distinct","group_concat","max","min","sum");function
__construct($f){parent::__construct($f);if(min_version(3.31,0,$f))$this->generated=array("STORED","VIRTUAL");}function
structuredTypes(){return
array_keys($this->types[0]);}function
insertUpdate($Q,$K,$F){$cj=array();foreach($K
as$N)$cj[]="(".implode(", ",$N).")";return
queries("REPLACE INTO ".table($Q)." (".implode(", ",array_keys(reset($K))).") VALUES\n".implode(",\n",$cj));}function
tableHelp($B,$ee=false){if($B=="sqlite_sequence")return"fileformat2.html#seqtab";if($B=="sqlite_master")return"fileformat2.html#$B";}function
checkConstraints($Q){preg_match_all('~ CHECK *(\( *(((?>[^()]*[^() ])|(?1))*) *\))~',$this->conn->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($Q)),$Fe);return
array_combine($Fe[2],$Fe[2]);}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect($Fb){list(,,$E)=$Fb;if($E!="")return'Database does not support password.';return
new
Db;}function
get_databases(){return
array();}function
limit($G,$Z,$z,$C=0,$lh=" "){return" $G$Z".($z!==null?$lh."LIMIT $z".($C?" OFFSET $C":""):"");}function
limit1($Q,$G,$Z,$lh="\n"){return(preg_match('~^INTO~',$G)||get_val("SELECT sqlite_compileoption_used('ENABLE_UPDATE_DELETE_LIMIT')")?limit($G,$Z,1,0,$lh):" $G WHERE rowid = (SELECT rowid FROM ".table($Q).$Z.$lh."LIMIT 1)");}function
db_collation($j,$jb){return
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
fields($Q){$I=array();$F="";foreach(get_rows("PRAGMA table_".(min_version(3.31)?"x":"")."info(".table($Q).")")as$J){$B=$J["name"];$U=strtolower($J["type"]);$k=$J["dflt_value"];$I[$B]=array("field"=>$B,"type"=>(preg_match('~int~i',$U)?"integer":(preg_match('~char|clob|text~i',$U)?"text":(preg_match('~blob~i',$U)?"blob":(preg_match('~real|floa|doub~i',$U)?"real":"numeric")))),"full_type"=>$U,"default"=>(preg_match("~^'(.*)'$~",$k,$A)?str_replace("''","'",$A[1]):($k=="NULL"?null:$k)),"null"=>!$J["notnull"],"privileges"=>array("select"=>1,"insert"=>1,"update"=>1,"where"=>1,"order"=>1),"primary"=>$J["pk"],);if($J["pk"]){if($F!="")$I[$F]["auto_increment"]=false;elseif(preg_match('~^integer$~i',$U))$I[$B]["auto_increment"]=true;$F=$B;}}$Eh=get_val("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($Q));$v='(("[^"]*+")+|[a-z0-9_]+)';preg_match_all('~'.$v.'\s+text\s+COLLATE\s+(\'[^\']+\'|\S+)~i',$Eh,$Fe,PREG_SET_ORDER);foreach($Fe
as$A){$B=str_replace('""','"',preg_replace('~^"|"$~','',$A[1]));if($I[$B])$I[$B]["collation"]=trim($A[3],"'");}preg_match_all('~'.$v.'\s.*GENERATED ALWAYS AS \((.+)\) (STORED|VIRTUAL)~i',$Eh,$Fe,PREG_SET_ORDER);foreach($Fe
as$A){$B=str_replace('""','"',preg_replace('~^"|"$~','',$A[1]));$I[$B]["default"]=$A[3];$I[$B]["generated"]=strtoupper($A[4]);}return$I;}function
indexes($Q,$g=null){global$f;if(!is_object($g))$g=$f;$I=array();$Eh=$g->result("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = ".q($Q));if(preg_match('~\bPRIMARY\s+KEY\s*\((([^)"]+|"[^"]*"|`[^`]*`)++)~i',$Eh,$A)){$I[""]=array("type"=>"PRIMARY","columns"=>array(),"lengths"=>array(),"descs"=>array());preg_match_all('~((("[^"]*+")+|(?:`[^`]*+`)+)|(\S+))(\s+(ASC|DESC))?(,\s*|$)~i',$A[1],$Fe,PREG_SET_ORDER);foreach($Fe
as$A){$I[""]["columns"][]=idf_unescape($A[2]).$A[4];$I[""]["descs"][]=(preg_match('~DESC~i',$A[5])?'1':null);}}if(!$I){foreach(fields($Q)as$B=>$n){if($n["primary"])$I[""]=array("type"=>"PRIMARY","columns"=>array($B),"lengths"=>array(),"descs"=>array(null));}}$Ih=get_key_vals("SELECT name, sql FROM sqlite_master WHERE type = 'index' AND tbl_name = ".q($Q),$g);foreach(get_rows("PRAGMA index_list(".table($Q).")",$g)as$J){$B=$J["name"];$w=array("type"=>($J["unique"]?"UNIQUE":"INDEX"));$w["lengths"]=array();$w["descs"]=array();foreach(get_rows("PRAGMA index_info(".idf_escape($B).")",$g)as$Yg){$w["columns"][]=$Yg["name"];$w["descs"][]=null;}if(preg_match('~^CREATE( UNIQUE)? INDEX '.preg_quote(idf_escape($B).' ON '.idf_escape($Q),'~').' \((.*)\)$~i',$Ih[$B],$Ig)){preg_match_all('/("[^"]*+")+( DESC)?/',$Ig[2],$Fe);foreach($Fe[2]as$y=>$X){if($X)$w["descs"][$y]='1';}}if(!$I[""]||$w["type"]!="UNIQUE"||$w["columns"]!=$I[""]["columns"]||$w["descs"]!=$I[""]["descs"]||!preg_match("~^sqlite_~",$B))$I[$B]=$w;}return$I;}function
foreign_keys($Q){$I=array();foreach(get_rows("PRAGMA foreign_key_list(".table($Q).")")as$J){$q=&$I[$J["id"]];if(!$q)$q=$J;$q["source"][]=$J["from"];$q["target"][]=$J["to"];}return$I;}function
view($B){return
array("select"=>preg_replace('~^(?:[^`"[]+|`[^`]*`|"[^"]*")* AS\s+~iU','',get_val("SELECT sql FROM sqlite_master WHERE type = 'view' AND name = ".q($B))));}function
collations(){return(isset($_GET["create"])?get_vals("PRAGMA collation_list",1):array());}function
information_schema($j){return
false;}function
error(){global$f;return
h($f->error);}function
check_sqlite_name($B){global$f;$Oc="db|sdb|sqlite";if(!preg_match("~^[^\\0]*\\.($Oc)\$~",$B)){$f->error=sprintf('Please use one of the extensions %s.',str_replace("|",", ",$Oc));return
false;}return
true;}function
create_database($j,$ib){global$f;if(file_exists($j)){$f->error='File exists.';return
false;}if(!check_sqlite_name($j))return
false;try{$_=new
SqliteDb($j);}catch(Exception$Fc){$f->error=$Fc->getMessage();return
false;}$_->query('PRAGMA encoding = "UTF-8"');$_->query('CREATE TABLE adminer (i)');$_->query('DROP TABLE adminer');return
true;}function
drop_databases($i){global$f;$f->__construct(":memory:");foreach($i
as$j){if(!@unlink($j)){$f->error='File exists.';return
false;}}return
true;}function
rename_database($B,$ib){global$f;if(!check_sqlite_name($B))return
false;$f->__construct(":memory:");$f->error='File exists.';return@rename(DB,$B);}function
auto_increment(){return" PRIMARY KEY AUTOINCREMENT";}function
alter_table($Q,$B,$o,$fd,$pb,$vc,$ib,$Da,$Zf){global$f;$Vi=($Q==""||$fd);foreach($o
as$n){if($n[0]!=""||!$n[1]||$n[2]){$Vi=true;break;}}$c=array();$Nf=array();foreach($o
as$n){if($n[1]){$c[]=($Vi?$n[1]:"ADD ".implode($n[1]));if($n[0]!="")$Nf[$n[0]]=$n[1][0];}}if(!$Vi){foreach($c
as$X){if(!queries("ALTER TABLE ".table($Q)." $X"))return
false;}if($Q!=$B&&!queries("ALTER TABLE ".table($Q)." RENAME TO ".table($B)))return
false;}elseif(!recreate_table($Q,$B,$c,$Nf,$fd,$Da))return
false;if($Da){queries("BEGIN");queries("UPDATE sqlite_sequence SET seq = $Da WHERE name = ".q($B));if(!$f->affected_rows)queries("INSERT INTO sqlite_sequence (name, seq) VALUES (".q($B).", $Da)");queries("COMMIT");}return
true;}function
recreate_table($Q,$B,$o,$Nf,$fd,$Da=0,$x=array(),$gc="",$pa=""){global$l;if($Q!=""){if(!$o){foreach(fields($Q)as$y=>$n){if($x)$n["auto_increment"]=0;$o[]=process_field($n,$n);$Nf[$y]=idf_escape($y);}}$pg=false;foreach($o
as$n){if($n[6])$pg=true;}$ic=array();foreach($x
as$y=>$X){if($X[2]=="DROP"){$ic[$X[1]]=true;unset($x[$y]);}}foreach(indexes($Q)as$je=>$w){$e=array();foreach($w["columns"]as$y=>$d){if(!$Nf[$d])continue
2;$e[]=$Nf[$d].($w["descs"][$y]?" DESC":"");}if(!$ic[$je]){if($w["type"]!="PRIMARY"||!$pg)$x[]=array($w["type"],$je,$e);}}foreach($x
as$y=>$X){if($X[0]=="PRIMARY"){unset($x[$y]);$fd[]="  PRIMARY KEY (".implode(", ",$X[2]).")";}}foreach(foreign_keys($Q)as$je=>$q){foreach($q["source"]as$y=>$d){if(!$Nf[$d])continue
2;$q["source"][$y]=idf_unescape($Nf[$d]);}if(!isset($fd[" $je"]))$fd[]=" ".format_foreign_key($q);}queries("BEGIN");}foreach($o
as$y=>$n){if(preg_match('~GENERATED~',$n[3]))unset($Nf[array_search($n[0],$Nf)]);$o[$y]="  ".implode($n);}$o=array_merge($o,array_filter($fd));foreach($l->checkConstraints($Q)as$Wa){if($Wa!=$gc)$o[]="  CHECK ($Wa)";}if($pa)$o[]="  CHECK ($pa)";$gi=($Q==$B?"adminer_$B":$B);if(!queries("CREATE TABLE ".table($gi)." (\n".implode(",\n",$o)."\n)"))return
false;if($Q!=""){if($Nf&&!queries("INSERT INTO ".table($gi)." (".implode(", ",$Nf).") SELECT ".implode(", ",array_map('Adminer\idf_escape',array_keys($Nf)))." FROM ".table($Q)))return
false;$Fi=array();foreach(triggers($Q)as$Di=>$ni){$Ci=trigger($Di);$Fi[]="CREATE TRIGGER ".idf_escape($Di)." ".implode(" ",$ni)." ON ".table($B)."\n$Ci[Statement]";}$Da=$Da?0:get_val("SELECT seq FROM sqlite_sequence WHERE name = ".q($Q));if(!queries("DROP TABLE ".table($Q))||($Q==$B&&!queries("ALTER TABLE ".table($gi)." RENAME TO ".table($B)))||!alter_indexes($B,$x))return
false;if($Da)queries("UPDATE sqlite_sequence SET seq = $Da WHERE name = ".q($B));foreach($Fi
as$Ci){if(!queries($Ci))return
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
drop_views($hj){return
apply_queries("DROP VIEW",$hj);}function
drop_tables($S){return
apply_queries("DROP TABLE",$S);}function
move_tables($S,$hj,$ei){return
false;}function
trigger($B){if($B=="")return
array("Statement"=>"BEGIN\n\t;\nEND");$v='(?:[^`"\s]+|`[^`]*`|"[^"]*")+';$Ei=trigger_options();preg_match("~^CREATE\\s+TRIGGER\\s*$v\\s*(".implode("|",$Ei["Timing"]).")\\s+([a-z]+)(?:\\s+OF\\s+($v))?\\s+ON\\s*$v\\s*(?:FOR\\s+EACH\\s+ROW\\s)?(.*)~is",get_val("SELECT sql FROM sqlite_master WHERE type = 'trigger' AND name = ".q($B)),$A);$kf=$A[3];return
array("Timing"=>strtoupper($A[1]),"Event"=>strtoupper($A[2]).($kf?" OF":""),"Of"=>idf_unescape($kf),"Trigger"=>$B,"Statement"=>$A[4],);}function
triggers($Q){$I=array();$Ei=trigger_options();foreach(get_rows("SELECT * FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($Q))as$J){preg_match('~^CREATE\s+TRIGGER\s*(?:[^`"\s]+|`[^`]*`|"[^"]*")+\s*('.implode("|",$Ei["Timing"]).')\s*(.*?)\s+ON\b~i',$J["sql"],$A);$I[$J["name"]]=array($A[1],$A[2]);}return$I;}function
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
create_sql($Q,$Da,$Oh){$I=get_val("SELECT sql FROM sqlite_master WHERE type IN ('table', 'view') AND name = ".q($Q));foreach(indexes($Q)as$B=>$w){if($B=='')continue;$I.=";\n\n".index_sql($Q,$w['type'],$B,"(".implode(", ",array_map('Adminer\idf_escape',$w['columns'])).")");}return$I;}function
truncate_sql($Q){return"DELETE FROM ".table($Q);}function
use_sql($Mb){}function
trigger_sql($Q){return
implode(get_vals("SELECT sql || ';;\n' FROM sqlite_master WHERE type = 'trigger' AND tbl_name = ".q($Q)));}function
show_variables(){$I=array();foreach(get_rows("PRAGMA pragma_list")as$J){$B=$J["name"];if($B!="pragma_list"&&$B!="compile_options"){foreach(get_rows("PRAGMA $B")as$J)$I[$B].=implode(", ",$J)."\n";}}return$I;}function
show_status(){$I=array();foreach(get_vals("PRAGMA compile_options")as$_f){list($y,$X)=explode("=",$_f,2);$I[$y]=$X;}return$I;}function
convert_field($n){}function
unconvert_field($n,$I){return$I;}function
support($Tc){return
preg_match('~^(check|columns|database|drop_col|dump|indexes|descidx|move_col|sql|status|table|trigger|variables|view|view_trigger)$~',$Tc);}}$ec["pgsql"]="PostgreSQL";if(isset($_GET["pgsql"])){define('Adminer\DRIVER',"pgsql");if(extension_loaded("pgsql")){class
Db{var$extension="PgSQL",$server_info,$affected_rows,$error,$timeout;private$link,$result,$string,$database=true;function
_error($Ac,$m){if(ini_bool("html_errors"))$m=html_entity_decode(strip_tags($m));$m=preg_replace('~^[^:]*: ~','',$m);$this->error=$m;}function
connect($M,$V,$E){global$b;$j=$b->database();set_error_handler(array($this,'_error'));$this->string="host='".str_replace(":","' port='",addcslashes($M,"'\\"))."' user='".addcslashes($V,"'\\")."' password='".addcslashes($E,"'\\")."'";$Jh=$b->connectSsl();if(isset($Jh["mode"]))$this->string.=" sslmode='".$Jh["mode"]."'";$this->link=@pg_connect("$this->string dbname='".($j!=""?addcslashes($j,"'\\"):"postgres")."'",PGSQL_CONNECT_FORCE_NEW);if(!$this->link&&$j!=""){$this->database=false;$this->link=@pg_connect("$this->string dbname='postgres'",PGSQL_CONNECT_FORCE_NEW);}restore_error_handler();if($this->link){$fj=pg_version($this->link);$this->server_info=$fj["server"];pg_set_client_encoding($this->link,"UTF8");}return(bool)$this->link;}function
quote($P){return
pg_escape_literal($this->link,$P);}function
value($X,$n){return($n["type"]=="bytea"&&$X!==null?pg_unescape_bytea($X):$X);}function
quoteBinary($P){return"'".pg_escape_bytea($this->link,$P)."'";}function
select_db($Mb){global$b;if($Mb==$b->database())return$this->database;$I=@pg_connect("$this->string dbname='".addcslashes($Mb,"'\\")."'",PGSQL_CONNECT_FORCE_NEW);if($I)$this->link=$I;return$I;}function
close(){$this->link=@pg_connect("$this->string dbname='postgres'");}function
query($G,$Ji=false){$H=@pg_query($this->link,$G);$this->error="";if(!$H){$this->error=pg_last_error($this->link);$I=false;}elseif(!pg_num_fields($H)){$this->affected_rows=pg_affected_rows($H);$I=true;}else$I=new
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
connect($M,$V,$E){global$b;$j=$b->database();$kc="pgsql:host='".str_replace(":","' port='",addcslashes($M,"'\\"))."' client_encoding=utf8 dbname='".($j!=""?addcslashes($j,"'\\"):"postgres")."'";$Jh=$b->connectSsl();if(isset($Jh["mode"]))$kc.=" sslmode='".$Jh["mode"]."'";$this->dsn($kc,$V,$E);return
true;}function
select_db($Mb){global$b;return($b->database()==$Mb);}function
quoteBinary($Zg){return
q($Zg);}function
query($G,$Ji=false){$I=parent::query($G,$Ji);if($this->timeout){$this->timeout=0;parent::query("RESET statement_timeout");}return$I;}function
warnings(){return'';}function
close(){}}}class
Driver
extends
SqlDriver{static$lg=array("PgSQL","PDO_PgSQL");static$he="pgsql";var$operators=array("=","<",">","<=",">=","!=","~","!~","LIKE","LIKE %%","ILIKE","ILIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL");var$functions=array("char_length","lower","round","to_hex","to_timestamp","upper");var$grouping=array("avg","count","count distinct","max","min","sum");function
__construct($f){parent::__construct($f);$this->types=array('Numbers'=>array("smallint"=>5,"integer"=>10,"bigint"=>19,"boolean"=>1,"numeric"=>0,"real"=>7,"double precision"=>16,"money"=>20),'Date and time'=>array("date"=>13,"time"=>17,"timestamp"=>20,"timestamptz"=>21,"interval"=>0),'Strings'=>array("character"=>0,"character varying"=>0,"text"=>0,"tsquery"=>0,"tsvector"=>0,"uuid"=>0,"xml"=>0),'Binary'=>array("bit"=>0,"bit varying"=>0,"bytea"=>0),'Network'=>array("cidr"=>43,"inet"=>43,"macaddr"=>17,"macaddr8"=>23,"txid_snapshot"=>0),'Geometry'=>array("box"=>0,"circle"=>0,"line"=>0,"lseg"=>0,"path"=>0,"point"=>0,"polygon"=>0),);if(min_version(9.2,0,$f)){$this->types['Strings']["json"]=4294967295;if(min_version(9.4,0,$f))$this->types['Strings']["jsonb"]=4294967295;}$this->editFunctions=array(array("char"=>"md5","date|time"=>"now",),array(number_type()=>"+/-","date|time"=>"+ interval/- interval","char|text"=>"||",));if(min_version(12,0,$f))$this->generated=array("STORED");}function
enumLength($n){$xc=$this->types['User types'][$n["type"]];return($xc?type_values($xc):"");}function
setUserTypes($Ii){$this->types['User types']=array_flip($Ii);}function
insertUpdate($Q,$K,$F){global$f;foreach($K
as$N){$Ri=array();$Z=array();foreach($N
as$y=>$X){$Ri[]="$y = $X";if(isset($F[idf_unescape($y)]))$Z[]="$y = $X";}if(!(($Z&&queries("UPDATE ".table($Q)." SET ".implode(", ",$Ri)." WHERE ".implode(" AND ",$Z))&&$f->affected_rows)||queries("INSERT INTO ".table($Q)." (".implode(", ",array_keys($N)).") VALUES (".implode(", ",$N).")")))return
false;}return
true;}function
slowQuery($G,$mi){$this->conn->query("SET statement_timeout = ".(1000*$mi));$this->conn->timeout=1000*$mi;return$G;}function
convertSearch($v,$X,$n){$ji="char|text";if(strpos($X["op"],"LIKE")===false)$ji.="|date|time(stamp)?|boolean|uuid|inet|cidr|macaddr|".number_type();return(preg_match("~$ji~",$n["type"])?$v:"CAST($v AS text)");}function
quoteBinary($Zg){return$this->conn->quoteBinary($Zg);}function
warnings(){return$this->conn->warnings();}function
tableHelp($B,$ee=false){$ze=array("information_schema"=>"infoschema","pg_catalog"=>($ee?"view":"catalog"),);$_=$ze[$_GET["ns"]];if($_)return"$_-".str_replace("_","-",$B).".html";}function
supportsIndex($R){return$R["Engine"]!="view";}function
hasCStyleEscapes(){static$Ra;if($Ra===null)$Ra=($this->conn->result("SHOW standard_conforming_strings")=="off");return$Ra;}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect($Fb){$f=new
Db;if($f->connect($Fb[0],$Fb[1],$Fb[2])){if(min_version(9,0,$f))$f->query("SET application_name = 'Adminer'");return$f;}return$f->error;}function
get_databases(){return
get_vals("SELECT datname FROM pg_database
WHERE datallowconn = TRUE AND has_database_privilege(datname, 'CONNECT')
ORDER BY datname");}function
limit($G,$Z,$z,$C=0,$lh=" "){return" $G$Z".($z!==null?$lh."LIMIT $z".($C?" OFFSET $C":""):"");}function
limit1($Q,$G,$Z,$lh="\n"){return(preg_match('~^INTO~',$G)?limit($G,$Z,1,0,$lh):" $G".(is_view(table_status1($Q))?$Z:$lh."WHERE ctid = (SELECT ctid FROM ".table($Q).$Z.$lh."LIMIT 1)"));}function
db_collation($j,$jb){return
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
table_status($B=""){static$_d;if($_d===null)$_d=get_val("SELECT 'pg_table_size'::regproc");$I=array();foreach(get_rows("SELECT
	c.relname AS \"Name\",
	CASE c.relkind WHEN 'r' THEN 'table' WHEN 'm' THEN 'materialized view' ELSE 'view' END AS \"Engine\"".($_d?",
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
fields($Q){$I=array();$wa=array('timestamp without time zone'=>'timestamp','timestamp with time zone'=>'timestamptz',);foreach(get_rows("SELECT a.attname AS field, format_type(a.atttypid, a.atttypmod) AS full_type, pg_get_expr(d.adbin, d.adrelid) AS default, a.attnotnull::int, col_description(c.oid, a.attnum) AS comment".(min_version(10)?", a.attidentity".(min_version(12)?", a.attgenerated":""):"")."
FROM pg_class c
JOIN pg_namespace n ON c.relnamespace = n.oid
JOIN pg_attribute a ON c.oid = a.attrelid
LEFT JOIN pg_attrdef d ON c.oid = d.adrelid AND a.attnum = d.adnum
WHERE c.relname = ".q($Q)."
AND n.nspname = current_schema()
AND NOT a.attisdropped
AND a.attnum > 0
ORDER BY a.attnum")as$J){preg_match('~([^([]+)(\((.*)\))?([a-z ]+)?((\[[0-9]*])*)$~',$J["full_type"],$A);list(,$U,$we,$J["length"],$qa,$ya)=$A;$J["length"].=$ya;$Ya=$U.$qa;if(isset($wa[$Ya])){$J["type"]=$wa[$Ya];$J["full_type"]=$J["type"].$we.$ya;}else{$J["type"]=$U;$J["full_type"]=$J["type"].$we.$qa.$ya;}if(in_array($J['attidentity'],array('a','d')))$J['default']='GENERATED '.($J['attidentity']=='d'?'BY DEFAULT':'ALWAYS').' AS IDENTITY';$J["generated"]=($J["attgenerated"]=="s"?"STORED":"");$J["null"]=!$J["attnotnull"];$J["auto_increment"]=$J['attidentity']||preg_match('~^nextval\(~i',$J["default"]);$J["privileges"]=array("insert"=>1,"select"=>1,"update"=>1,"where"=>1,"order"=>1);if(preg_match('~(.+)::[^,)]+(.*)~',$J["default"],$A))$J["default"]=($A[1]=="NULL"?null:idf_unescape($A[1]).$A[2]);$I[$J["field"]]=$J;}return$I;}function
indexes($Q,$g=null){global$f;if(!is_object($g))$g=$f;$I=array();$Xh=$g->result("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = ".q($Q));$e=get_key_vals("SELECT attnum, attname FROM pg_attribute WHERE attrelid = $Xh AND attnum > 0",$g);foreach(get_rows("SELECT relname, indisunique::int, indisprimary::int, indkey, indoption, (indpred IS NOT NULL)::int as indispartial FROM pg_index i, pg_class ci WHERE i.indrelid = $Xh AND ci.oid = i.indexrelid ORDER BY indisprimary DESC, indisunique DESC",$g)as$J){$Jg=$J["relname"];$I[$Jg]["type"]=($J["indispartial"]?"INDEX":($J["indisprimary"]?"PRIMARY":($J["indisunique"]?"UNIQUE":"INDEX")));$I[$Jg]["columns"]=array();$I[$Jg]["descs"]=array();if($J["indkey"]){foreach(explode(" ",$J["indkey"])as$Qd)$I[$Jg]["columns"][]=$e[$Qd];foreach(explode(" ",$J["indoption"])as$Rd)$I[$Jg]["descs"][]=($Rd&1?'1':null);}$I[$Jg]["lengths"]=array();}return$I;}function
foreign_keys($Q){global$l;$I=array();foreach(get_rows("SELECT conname, condeferrable::int AS deferrable, pg_get_constraintdef(oid) AS definition
FROM pg_constraint
WHERE conrelid = (SELECT pc.oid FROM pg_class AS pc INNER JOIN pg_namespace AS pn ON (pn.oid = pc.relnamespace) WHERE pc.relname = ".q($Q)." AND pn.nspname = current_schema())
AND contype = 'f'::char
ORDER BY conkey, conname")as$J){if(preg_match('~FOREIGN KEY\s*\((.+)\)\s*REFERENCES (.+)\((.+)\)(.*)$~iA',$J['definition'],$A)){$J['source']=array_map('Adminer\idf_unescape',array_map('trim',explode(',',$A[1])));if(preg_match('~^(("([^"]|"")+"|[^"]+)\.)?"?("([^"]|"")+"|[^"]+)$~',$A[2],$Ee)){$J['ns']=idf_unescape($Ee[2]);$J['table']=idf_unescape($Ee[4]);}$J['target']=array_map('Adminer\idf_unescape',array_map('trim',explode(',',$A[3])));$J['on_delete']=(preg_match("~ON DELETE ($l->onActions)~",$A[4],$Ee)?$Ee[1]:'NO ACTION');$J['on_update']=(preg_match("~ON UPDATE ($l->onActions)~",$A[4],$Ee)?$Ee[1]:'NO ACTION');$I[$J['conname']]=$J;}}return$I;}function
view($B){return
array("select"=>trim(get_val("SELECT pg_get_viewdef(".get_val("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = ".q($B)).")")));}function
collations(){return
array();}function
information_schema($j){return
get_schema()=="information_schema";}function
error(){global$f;$I=h($f->error);if(preg_match('~^(.*\n)?([^\n]*)\n( *)\^(\n.*)?$~s',$I,$A))$I=$A[1].preg_replace('~((?:[^&]|&[^;]*;){'.strlen($A[3]).'})(.*)~','\1<b>\2</b>',$A[2]).$A[4];return
nl_br($I);}function
create_database($j,$ib){return
queries("CREATE DATABASE ".idf_escape($j).($ib?" ENCODING ".idf_escape($ib):""));}function
drop_databases($i){global$f;$f->close();return
apply_queries("DROP DATABASE",$i,'Adminer\idf_escape');}function
rename_database($B,$ib){global$f;$f->close();return
queries("ALTER DATABASE ".idf_escape(DB)." RENAME TO ".idf_escape($B));}function
auto_increment(){return"";}function
alter_table($Q,$B,$o,$fd,$pb,$vc,$ib,$Da,$Zf){$c=array();$yg=array();if($Q!=""&&$Q!=$B)$yg[]="ALTER TABLE ".table($Q)." RENAME TO ".table($B);$mh="";foreach($o
as$n){$d=idf_escape($n[0]);$X=$n[1];if(!$X)$c[]="DROP $d";else{$bj=$X[5];unset($X[5]);if($n[0]==""){if(isset($X[6]))$X[1]=($X[1]==" bigint"?" big":($X[1]==" smallint"?" small":" "))."serial";$c[]=($Q!=""?"ADD ":"  ").implode($X);if(isset($X[6]))$c[]=($Q!=""?"ADD":" ")." PRIMARY KEY ($X[0])";}else{if($d!=$X[0])$yg[]="ALTER TABLE ".table($B)." RENAME $d TO $X[0]";$c[]="ALTER $d TYPE$X[1]";$nh=$Q."_".idf_unescape($X[0])."_seq";$c[]="ALTER $d ".($X[3]?"SET".preg_replace('~GENERATED ALWAYS(.*) STORED~','EXPRESSION\1',$X[3]):(isset($X[6])?"SET DEFAULT nextval(".q($nh).")":"DROP DEFAULT"));if(isset($X[6]))$mh="CREATE SEQUENCE IF NOT EXISTS ".idf_escape($nh)." OWNED BY ".idf_escape($Q).".$X[0]";$c[]="ALTER $d ".($X[2]==" NULL"?"DROP NOT":"SET").$X[2];}if($n[0]!=""||$bj!="")$yg[]="COMMENT ON COLUMN ".table($B).".$X[0] IS ".($bj!=""?substr($bj,9):"''");}}$c=array_merge($c,$fd);if($Q=="")array_unshift($yg,"CREATE TABLE ".table($B)." (\n".implode(",\n",$c)."\n)");elseif($c)array_unshift($yg,"ALTER TABLE ".table($Q)."\n".implode(",\n",$c));if($mh)array_unshift($yg,$mh);if($pb!==null)$yg[]="COMMENT ON TABLE ".table($B)." IS ".q($pb);foreach($yg
as$G){if(!queries($G))return
false;}return
true;}function
alter_indexes($Q,$c){$h=array();$fc=array();$yg=array();foreach($c
as$X){if($X[0]!="INDEX")$h[]=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");elseif($X[2]=="DROP")$fc[]=idf_escape($X[1]);else$yg[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($Q."_"))." ON ".table($Q)." (".implode(", ",$X[2]).")";}if($h)array_unshift($yg,"ALTER TABLE ".table($Q).implode(",",$h));if($fc)array_unshift($yg,"DROP INDEX ".implode(", ",$fc));foreach($yg
as$G){if(!queries($G))return
false;}return
true;}function
truncate_tables($S){return
queries("TRUNCATE ".implode(", ",array_map('Adminer\table',$S)));}function
drop_views($hj){return
drop_tables($hj);}function
drop_tables($S){foreach($S
as$Q){$O=table_status($Q);if(!queries("DROP ".strtoupper($O["Engine"])." ".table($Q)))return
false;}return
true;}function
move_tables($S,$hj,$ei){foreach(array_merge($S,$hj)as$Q){$O=table_status($Q);if(!queries("ALTER ".strtoupper($O["Engine"])." ".table($Q)." SET SCHEMA ".idf_escape($ei)))return
false;}return
true;}function
trigger($B,$Q){if($B=="")return
array("Statement"=>"EXECUTE PROCEDURE ()");$e=array();$Z="WHERE trigger_schema = current_schema() AND event_object_table = ".q($Q)." AND trigger_name = ".q($B);foreach(get_rows("SELECT * FROM information_schema.triggered_update_columns $Z")as$J)$e[]=$J["event_object_column"];$I=array();foreach(get_rows('SELECT trigger_name AS "Trigger", action_timing AS "Timing", event_manipulation AS "Event", \'FOR EACH \' || action_orientation AS "Type", action_statement AS "Statement" FROM information_schema.triggers '."$Z ORDER BY event_manipulation DESC")as$J){if($e&&$J["Event"]=="UPDATE")$J["Event"].=" OF";$J["Of"]=implode(", ",$e);if($I)$J["Event"].=" OR $I[Event]";$I=$J;}return$I;}function
triggers($Q){$I=array();foreach(get_rows("SELECT * FROM information_schema.triggers WHERE trigger_schema = current_schema() AND event_object_table = ".q($Q))as$J){$Ci=trigger($J["trigger_name"],$Q);$I[$Ci["Trigger"]]=array($Ci["Timing"],$Ci["Event"]);}return$I;}function
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
found_rows($R,$Z){if(preg_match("~ rows=([0-9]+)~",get_val("EXPLAIN SELECT * FROM ".idf_escape($R["Name"]).($Z?" WHERE ".implode(" AND ",$Z):"")),$Ig))return$Ig[1];return
false;}function
types(){return
get_key_vals("SELECT oid, typname
FROM pg_type
WHERE typnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema())
AND typtype IN ('b','d','e')
AND typelem = 0");}function
type_values($u){$_c=get_vals("SELECT enumlabel FROM pg_enum WHERE enumtypid = $u ORDER BY enumsortorder");return($_c?"'".implode("', '",array_map('addslashes',$_c))."'":"");}function
schemas(){return
get_vals("SELECT nspname FROM pg_namespace ORDER BY nspname");}function
get_schema(){return
get_val("SELECT current_schema()");}function
set_schema($bh,$g=null){global$f,$l;if(!$g)$g=$f;$I=$g->query("SET search_path TO ".idf_escape($bh));$l->setUserTypes(types());return$I;}function
foreign_keys_sql($Q){$I="";$O=table_status($Q);$cd=foreign_keys($Q);ksort($cd);foreach($cd
as$bd=>$ad)$I.="ALTER TABLE ONLY ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." ADD CONSTRAINT ".idf_escape($bd)." $ad[definition] ".($ad['deferrable']?'DEFERRABLE':'NOT DEFERRABLE').";\n";return($I?"$I\n":$I);}function
create_sql($Q,$Da,$Oh){global$l;$Rg=array();$oh=array();$O=table_status($Q);if(is_view($O)){$gj=view($Q);return
rtrim("CREATE VIEW ".idf_escape($Q)." AS $gj[select]",";");}$o=fields($Q);if(!$O||empty($o))return
false;$I="CREATE TABLE ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." (\n    ";foreach($o
as$n){$Wf=idf_escape($n['field']).' '.$n['full_type'].default_value($n).($n['attnotnull']?" NOT NULL":"");$Rg[]=$Wf;if(preg_match('~nextval\(\'([^\']+)\'\)~',$n['default'],$Fe)){$nh=$Fe[1];$Dh=reset(get_rows((min_version(10)?"SELECT *, cache_size AS cache_value FROM pg_sequences WHERE schemaname = current_schema() AND sequencename = ".q(idf_unescape($nh)):"SELECT * FROM $nh"),null,"-- "));$oh[]=($Oh=="DROP+CREATE"?"DROP SEQUENCE IF EXISTS $nh;\n":"")."CREATE SEQUENCE $nh INCREMENT $Dh[increment_by] MINVALUE $Dh[min_value] MAXVALUE $Dh[max_value]".($Da&&$Dh['last_value']?" START ".($Dh["last_value"]+1):"")." CACHE $Dh[cache_value];";}}if(!empty($oh))$I=implode("\n\n",$oh)."\n\n$I";$F="";foreach(indexes($Q)as$Od=>$w){if($w['type']=='PRIMARY'){$F=$Od;$Rg[]="CONSTRAINT ".idf_escape($Od)." PRIMARY KEY (".implode(', ',array_map('Adminer\idf_escape',$w['columns'])).")";}}foreach($l->checkConstraints($Q)as$ub=>$wb)$Rg[]="CONSTRAINT ".idf_escape($ub)." CHECK $wb";$I.=implode(",\n    ",$Rg)."\n) WITH (oids = ".($O['Oid']?'true':'false').");";if($O['Comment'])$I.="\n\nCOMMENT ON TABLE ".idf_escape($O['nspname']).".".idf_escape($O['Name'])." IS ".q($O['Comment']).";";foreach($o
as$Vc=>$n){if($n['comment'])$I.="\n\nCOMMENT ON COLUMN ".idf_escape($O['nspname']).".".idf_escape($O['Name']).".".idf_escape($Vc)." IS ".q($n['comment']).";";}foreach(get_rows("SELECT indexdef FROM pg_catalog.pg_indexes WHERE schemaname = current_schema() AND tablename = ".q($Q).($F?" AND indexname != ".q($F):""),null,"-- ")as$J)$I.="\n\n$J[indexdef];";return
rtrim($I,';');}function
truncate_sql($Q){return"TRUNCATE ".table($Q);}function
trigger_sql($Q){$O=table_status($Q);$I="";foreach(triggers($Q)as$Bi=>$Ai){$Ci=trigger($Bi,$O['Name']);$I.="\nCREATE TRIGGER ".idf_escape($Ci['Trigger'])." $Ci[Timing] $Ci[Event] ON ".idf_escape($O["nspname"]).".".idf_escape($O['Name'])." $Ci[Type] $Ci[Statement];;\n";}return$I;}function
use_sql($Mb){return"\connect ".idf_escape($Mb);}function
show_variables(){return
get_key_vals("SHOW ALL");}function
process_list(){return
get_rows("SELECT * FROM pg_stat_activity ORDER BY ".(min_version(9.2)?"pid":"procpid"));}function
convert_field($n){}function
unconvert_field($n,$I){return$I;}function
support($Tc){return
preg_match('~^(check|database|table|columns|sql|indexes|descidx|comment|view|'.(min_version(9.3)?'materializedview|':'').'scheme|routine|processlist|sequence|trigger|type|variables|drop_col|kill|dump)$~',$Tc);}function
kill_process($X){return
queries("SELECT pg_terminate_backend(".number($X).")");}function
connection_id(){return"SELECT pg_backend_pid()";}function
max_connections(){return
get_val("SHOW max_connections");}}$ec["oracle"]="Oracle (beta)";if(isset($_GET["oracle"])){define('Adminer\DRIVER',"oracle");if(extension_loaded("oci8")){class
Db{var$extension="oci8",$server_info,$affected_rows,$errno,$error;var$_current_db;private$link,$result;function
_error($Ac,$m){if(ini_bool("html_errors"))$m=html_entity_decode(strip_tags($m));$m=preg_replace('~^[^:]*: ~','',$m);$this->error=$m;}function
connect($M,$V,$E){$this->link=@oci_new_connect($V,$E,$M,"AL32UTF8");if($this->link){$this->server_info=oci_server_version($this->link);return
true;}$m=oci_error();$this->error=$m["message"];return
false;}function
quote($P){return"'".str_replace("'","''",$P)."'";}function
select_db($Mb){$this->_current_db=$Mb;return
true;}function
query($G,$Ji=false){$H=oci_parse($this->link,$G);$this->error="";if(!$H){$m=oci_error($this->link);$this->errno=$m["code"];$this->error=$m["message"];return
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
select_db($Mb){$this->_current_db=$Mb;return
true;}}}class
Driver
extends
SqlDriver{static$lg=array("OCI8","PDO_OCI");static$he="oracle";var$editFunctions=array(array("date"=>"current_date","timestamp"=>"current_timestamp",),array("number|float|double"=>"+/-","date|timestamp"=>"+ interval/- interval","char|clob"=>"||",));var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL","SQL");var$functions=array("length","lower","round","upper");var$grouping=array("avg","count","count distinct","max","min","sum");function
__construct($f){parent::__construct($f);$this->types=array('Numbers'=>array("number"=>38,"binary_float"=>12,"binary_double"=>21),'Date and time'=>array("date"=>10,"timestamp"=>29,"interval year"=>12,"interval day"=>28),'Strings'=>array("char"=>2000,"varchar2"=>4000,"nchar"=>2000,"nvarchar2"=>4000,"clob"=>4294967295,"nclob"=>4294967295),'Binary'=>array("raw"=>2000,"long raw"=>2147483648,"blob"=>4294967295,"bfile"=>4294967296),);}function
begin(){return
true;}function
insertUpdate($Q,$K,$F){global$f;foreach($K
as$N){$Ri=array();$Z=array();foreach($N
as$y=>$X){$Ri[]="$y = $X";if(isset($F[idf_unescape($y)]))$Z[]="$y = $X";}if(!(($Z&&queries("UPDATE ".table($Q)." SET ".implode(", ",$Ri)." WHERE ".implode(" AND ",$Z))&&$f->affected_rows)||queries("INSERT INTO ".table($Q)." (".implode(", ",array_keys($N)).") VALUES (".implode(", ",$N).")")))return
false;}return
true;}function
hasCStyleEscapes(){return
true;}}function
idf_escape($v){return'"'.str_replace('"','""',$v).'"';}function
table($v){return
idf_escape($v);}function
connect($Fb){$f=new
Db;if($f->connect($Fb[0],$Fb[1],$Fb[2]))return$f;return$f->error;}function
get_databases(){return
get_vals("SELECT DISTINCT tablespace_name FROM (
SELECT tablespace_name FROM user_tablespaces
UNION SELECT tablespace_name FROM all_tables WHERE tablespace_name IS NOT NULL
)
ORDER BY 1");}function
limit($G,$Z,$z,$C=0,$lh=" "){return($C?" * FROM (SELECT t.*, rownum AS rnum FROM (SELECT $G$Z) t WHERE rownum <= ".($z+$C).") WHERE rnum > $C":($z!==null?" * FROM (SELECT $G$Z) WHERE rownum <= ".($z+$C):" $G$Z"));}function
limit1($Q,$G,$Z,$lh="\n"){return" $G$Z";}function
db_collation($j,$jb){return
get_val("SELECT value FROM nls_database_parameters WHERE parameter = 'NLS_CHARACTERSET'");}function
engines(){return
array();}function
logged_user(){return
get_val("SELECT USER FROM DUAL");}function
get_current_db(){global$f;$j=$f->_current_db?:DB;unset($f->_current_db);return$j;}function
where_owner($ng,$Qf="owner"){if(!$_GET["ns"])return'';return"$ng$Qf = sys_context('USERENV', 'CURRENT_SCHEMA')";}function
views_table($e){$Qf=where_owner('');return"(SELECT $e FROM all_views WHERE ".($Qf?:"rownum < 0").")";}function
tables_list(){$gj=views_table("view_name");$Qf=where_owner(" AND ");return
get_key_vals("SELECT table_name, 'table' FROM all_tables WHERE tablespace_name = ".q(DB)."$Qf
UNION SELECT view_name, 'view' FROM $gj
ORDER BY 1");}function
count_tables($i){$I=array();foreach($i
as$j)$I[$j]=get_val("SELECT COUNT(*) FROM all_tables WHERE tablespace_name = ".q($j));return$I;}function
table_status($B=""){$I=array();$eh=q($B);$j=get_current_db();$gj=views_table("view_name");$Qf=where_owner(" AND ");foreach(get_rows('SELECT table_name "Name", \'table\' "Engine", avg_row_len * num_rows "Data_length", num_rows "Rows" FROM all_tables WHERE tablespace_name = '.q($j).$Qf.($B!=""?" AND table_name = $eh":"")."
UNION SELECT view_name, 'view', 0, 0 FROM $gj".($B!=""?" WHERE view_name = $eh":"")."
ORDER BY 1")as$J){if($B!="")return$J;$I[$J["Name"]]=$J;}return$I;}function
is_view($R){return$R["Engine"]=="view";}function
fk_support($R){return
true;}function
fields($Q){$I=array();$Qf=where_owner(" AND ");foreach(get_rows("SELECT * FROM all_tab_columns WHERE table_name = ".q($Q)."$Qf ORDER BY column_id")as$J){$U=$J["DATA_TYPE"];$we="$J[DATA_PRECISION],$J[DATA_SCALE]";if($we==",")$we=$J["CHAR_COL_DECL_LENGTH"];$I[$J["COLUMN_NAME"]]=array("field"=>$J["COLUMN_NAME"],"full_type"=>$U.($we?"($we)":""),"type"=>strtolower($U),"length"=>$we,"default"=>$J["DATA_DEFAULT"],"null"=>($J["NULLABLE"]=="Y"),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1,"where"=>1,"order"=>1),);}return$I;}function
indexes($Q,$g=null){$I=array();$Qf=where_owner(" AND ","aic.table_owner");foreach(get_rows("SELECT aic.*, ac.constraint_type, atc.data_default
FROM all_ind_columns aic
LEFT JOIN all_constraints ac ON aic.index_name = ac.constraint_name AND aic.table_name = ac.table_name AND aic.index_owner = ac.owner
LEFT JOIN all_tab_cols atc ON aic.column_name = atc.column_name AND aic.table_name = atc.table_name AND aic.index_owner = atc.owner
WHERE aic.table_name = ".q($Q)."$Qf
ORDER BY ac.constraint_type, aic.column_position",$g)as$J){$Od=$J["INDEX_NAME"];$mb=$J["DATA_DEFAULT"];$mb=($mb?trim($mb,'"'):$J["COLUMN_NAME"]);$I[$Od]["type"]=($J["CONSTRAINT_TYPE"]=="P"?"PRIMARY":($J["CONSTRAINT_TYPE"]=="U"?"UNIQUE":"INDEX"));$I[$Od]["columns"][]=$mb;$I[$Od]["lengths"][]=($J["CHAR_LENGTH"]&&$J["CHAR_LENGTH"]!=$J["COLUMN_LENGTH"]?$J["CHAR_LENGTH"]:null);$I[$Od]["descs"][]=($J["DESCEND"]&&$J["DESCEND"]=="DESC"?'1':null);}return$I;}function
view($B){$gj=views_table("view_name, text");$K=get_rows('SELECT text "select" FROM '.$gj.' WHERE view_name = '.q($B));return
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
alter_table($Q,$B,$o,$fd,$pb,$vc,$ib,$Da,$Zf){$c=$fc=array();$Jf=($Q?fields($Q):array());foreach($o
as$n){$X=$n[1];if($X&&$n[0]!=""&&idf_escape($n[0])!=$X[0])queries("ALTER TABLE ".table($Q)." RENAME COLUMN ".idf_escape($n[0])." TO $X[0]");$If=$Jf[$n[0]];if($X&&$If){$mf=process_field($If,$If);if($X[2]==$mf[2])$X[2]="";}if($X)$c[]=($Q!=""?($n[0]!=""?"MODIFY (":"ADD ("):"  ").implode($X).($Q!=""?")":"");else$fc[]=idf_escape($n[0]);}if($Q=="")return
queries("CREATE TABLE ".table($B)." (\n".implode(",\n",$c)."\n)");return(!$c||queries("ALTER TABLE ".table($Q)."\n".implode("\n",$c)))&&(!$fc||queries("ALTER TABLE ".table($Q)." DROP (".implode(", ",$fc).")"))&&($Q==$B||queries("ALTER TABLE ".table($Q)." RENAME TO ".table($B)));}function
alter_indexes($Q,$c){$fc=array();$yg=array();foreach($c
as$X){if($X[0]!="INDEX"){$X[2]=preg_replace('~ DESC$~','',$X[2]);$h=($X[2]=="DROP"?"\nDROP CONSTRAINT ".idf_escape($X[1]):"\nADD".($X[1]!=""?" CONSTRAINT ".idf_escape($X[1]):"")." $X[0] ".($X[0]=="PRIMARY"?"KEY ":"")."(".implode(", ",$X[2]).")");array_unshift($yg,"ALTER TABLE ".table($Q).$h);}elseif($X[2]=="DROP")$fc[]=idf_escape($X[1]);else$yg[]="CREATE INDEX ".idf_escape($X[1]!=""?$X[1]:uniqid($Q."_"))." ON ".table($Q)." (".implode(", ",$X[2]).")";}if($fc)array_unshift($yg,"DROP INDEX ".implode(", ",$fc));foreach($yg
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
drop_views($hj){return
apply_queries("DROP VIEW",$hj);}function
drop_tables($S){return
apply_queries("DROP TABLE",$S);}function
last_id(){return
0;}function
schemas(){$I=get_vals("SELECT DISTINCT owner FROM dba_segments WHERE owner IN (SELECT username FROM dba_users WHERE default_tablespace NOT IN ('SYSTEM','SYSAUX')) ORDER BY 1");return($I?:get_vals("SELECT DISTINCT owner FROM all_tables WHERE tablespace_name = ".q(DB)." ORDER BY 1"));}function
get_schema(){return
get_val("SELECT sys_context('USERENV', 'SESSION_USER') FROM dual");}function
set_schema($dh,$g=null){global$f;if(!$g)$g=$f;return$g->query("ALTER SESSION SET CURRENT_SCHEMA = ".idf_escape($dh));}function
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
support($Tc){return
preg_match('~^(columns|database|drop_col|indexes|descidx|processlist|scheme|sql|status|table|variables|view)$~',$Tc);}}$ec["mssql"]="MS SQL";if(isset($_GET["mssql"])){define('Adminer\DRIVER',"mssql");if(extension_loaded("sqlsrv")){class
Db{var$extension="sqlsrv",$server_info,$affected_rows,$errno,$error;private$link,$result;private
function
get_error(){$this->error="";foreach(sqlsrv_errors()as$m){$this->errno=$m["code"];$this->error.="$m[message]\n";}$this->error=rtrim($this->error);}function
connect($M,$V,$E){global$b;$vb=array("UID"=>$V,"PWD"=>$E,"CharacterSet"=>"UTF-8");$Jh=$b->connectSsl();if(isset($Jh["Encrypt"]))$vb["Encrypt"]=$Jh["Encrypt"];if(isset($Jh["TrustServerCertificate"]))$vb["TrustServerCertificate"]=$Jh["TrustServerCertificate"];$j=$b->database();if($j!="")$vb["Database"]=$j;$this->link=@sqlsrv_connect(preg_replace('~:~',',',$M),$vb);if($this->link){$Sd=sqlsrv_server_info($this->link);$this->server_info=$Sd['SQLServerVersion'];}else$this->get_error();return(bool)$this->link;}function
quote($P){$Ki=strlen($P)!=strlen(utf8_decode($P));return($Ki?"N":"")."'".str_replace("'","''",$P)."'";}function
select_db($Mb){return$this->query(use_sql($Mb));}function
query($G,$Ji=false){$H=sqlsrv_query($this->link,$G);$this->error="";if(!$H){$this->get_error();return
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
select_db($Mb){return$this->query(use_sql($Mb));}}}elseif(extension_loaded("pdo_dblib")){class
Db
extends
PdoDb{var$extension="PDO_DBLIB";function
connect($M,$V,$E){$this->dsn("dblib:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\d)~',';port=\1',$M)),$V,$E);return
true;}function
select_db($Mb){return$this->query(use_sql($Mb));}}}class
Driver
extends
SqlDriver{static$lg=array("SQLSRV","PDO_SQLSRV","PDO_DBLIB");static$he="mssql";var$editFunctions=array(array("date|time"=>"getdate",),array("int|decimal|real|float|money|datetime"=>"+/-","char|text"=>"+",));var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","IN","IS NULL","NOT LIKE","NOT IN","IS NOT NULL");var$functions=array("len","lower","round","upper");var$grouping=array("avg","count","count distinct","max","min","sum");var$onActions="NO ACTION|CASCADE|SET NULL|SET DEFAULT";var$generated=array("PERSISTED","VIRTUAL");function
__construct($f){parent::__construct($f);$this->types=array('Numbers'=>array("tinyint"=>3,"smallint"=>5,"int"=>10,"bigint"=>20,"bit"=>1,"decimal"=>0,"real"=>12,"float"=>53,"smallmoney"=>10,"money"=>20),'Date and time'=>array("date"=>10,"smalldatetime"=>19,"datetime"=>19,"datetime2"=>19,"time"=>8,"datetimeoffset"=>10),'Strings'=>array("char"=>8000,"varchar"=>8000,"text"=>2147483647,"nchar"=>4000,"nvarchar"=>4000,"ntext"=>1073741823),'Binary'=>array("binary"=>8000,"varbinary"=>8000,"image"=>2147483647),);}function
insertUpdate($Q,$K,$F){$o=fields($Q);$Ri=array();$Z=array();$N=reset($K);$e="c".implode(", c",range(1,count($N)));$Qa=0;$Wd=array();foreach($N
as$y=>$X){$Qa++;$B=idf_unescape($y);if(!$o[$B]["auto_increment"])$Wd[$y]="c$Qa";if(isset($F[$B]))$Z[]="$y = c$Qa";else$Ri[]="$y = c$Qa";}$cj=array();foreach($K
as$N)$cj[]="(".implode(", ",$N).")";if($Z){$Id=queries("SET IDENTITY_INSERT ".table($Q)." ON");$I=queries("MERGE ".table($Q)." USING (VALUES\n\t".implode(",\n\t",$cj)."\n) AS source ($e) ON ".implode(" AND ",$Z).($Ri?"\nWHEN MATCHED THEN UPDATE SET ".implode(", ",$Ri):"")."\nWHEN NOT MATCHED THEN INSERT (".implode(", ",array_keys($Id?$N:$Wd)).") VALUES (".($Id?$e:implode(", ",$Wd)).");");if($Id)queries("SET IDENTITY_INSERT ".table($Q)." OFF");}else$I=queries("INSERT INTO ".table($Q)." (".implode(", ",array_keys($N)).") VALUES\n".implode(",\n",$cj));return$I;}function
begin(){return
queries("BEGIN TRANSACTION");}function
tableHelp($B,$ee=false){$ze=array("sys"=>"catalog-views/sys-","INFORMATION_SCHEMA"=>"information-schema-views/",);$_=$ze[get_schema()];if($_)return"relational-databases/system-$_".preg_replace('~_~','-',strtolower($B))."-transact-sql";}}function
idf_escape($v){return"[".str_replace("]","]]",$v)."]";}function
table($v){return($_GET["ns"]!=""?idf_escape($_GET["ns"]).".":"").idf_escape($v);}function
connect($Fb){$f=new
Db;if($Fb[0]=="")$Fb[0]="localhost:1433";if($f->connect($Fb[0],$Fb[1],$Fb[2]))return$f;return$f->error;}function
get_databases(){return
get_vals("SELECT name FROM sys.databases WHERE name NOT IN ('master', 'tempdb', 'model', 'msdb')");}function
limit($G,$Z,$z,$C=0,$lh=" "){return($z!==null?" TOP (".($z+$C).")":"")." $G$Z";}function
limit1($Q,$G,$Z,$lh="\n"){return
limit($G,$Z,1,0,$lh);}function
db_collation($j,$jb){return
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
fields($Q){$rb=get_key_vals("SELECT objname, cast(value as varchar(max)) FROM fn_listextendedproperty('MS_DESCRIPTION', 'schema', ".q(get_schema()).", 'table', ".q($Q).", 'column', NULL)");$I=array();$Vh=get_val("SELECT object_id FROM sys.all_objects WHERE schema_id = SCHEMA_ID(".q(get_schema()).") AND type IN ('S', 'U', 'V') AND name = ".q($Q));foreach(get_rows("SELECT c.max_length, c.precision, c.scale, c.name, c.is_nullable, c.is_identity, c.collation_name, t.name type, CAST(d.definition as text) [default], d.name default_constraint, i.is_primary_key
FROM sys.all_columns c
JOIN sys.types t ON c.user_type_id = t.user_type_id
LEFT JOIN sys.default_constraints d ON c.default_object_id = d.object_id
LEFT JOIN sys.index_columns ic ON c.object_id = ic.object_id AND c.column_id = ic.column_id
LEFT JOIN sys.indexes i ON ic.object_id = i.object_id AND ic.index_id = i.index_id
WHERE c.object_id = ".q($Vh))as$J){$U=$J["type"];$we=(preg_match("~char|binary~",$U)?$J["max_length"]/($U[0]=='n'?2:1):($U=="decimal"?"$J[precision],$J[scale]":""));$I[$J["name"]]=array("field"=>$J["name"],"full_type"=>$U.($we?"($we)":""),"type"=>$U,"length"=>$we,"default"=>(preg_match("~^\('(.*)'\)$~",$J["default"],$A)?str_replace("''","'",$A[1]):$J["default"]),"default_constraint"=>$J["default_constraint"],"null"=>$J["is_nullable"],"auto_increment"=>$J["is_identity"],"collation"=>$J["collation_name"],"privileges"=>array("insert"=>1,"select"=>1,"update"=>1,"where"=>1,"order"=>1),"primary"=>$J["is_primary_key"],"comment"=>$rb[$J["name"]],);}foreach(get_rows("SELECT * FROM sys.computed_columns WHERE object_id = ".q($Vh))as$J){$I[$J["name"]]["generated"]=($J["is_persisted"]?"PERSISTED":"VIRTUAL");$I[$J["name"]]["default"]=$J["definition"];}return$I;}function
indexes($Q,$g=null){$I=array();foreach(get_rows("SELECT i.name, key_ordinal, is_unique, is_primary_key, c.name AS column_name, is_descending_key
FROM sys.indexes i
INNER JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
INNER JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
WHERE OBJECT_NAME(i.object_id) = ".q($Q),$g)as$J){$B=$J["name"];$I[$B]["type"]=($J["is_primary_key"]?"PRIMARY":($J["is_unique"]?"UNIQUE":"INDEX"));$I[$B]["lengths"]=array();$I[$B]["columns"][$J["key_ordinal"]]=$J["column_name"];$I[$B]["descs"][$J["key_ordinal"]]=($J["is_descending_key"]?'1':null);}return$I;}function
view($B){return
array("select"=>preg_replace('~^(?:[^[]|\[[^]]*])*\s+AS\s+~isU','',get_val("SELECT VIEW_DEFINITION FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = SCHEMA_NAME() AND TABLE_NAME = ".q($B))));}function
collations(){$I=array();foreach(get_vals("SELECT name FROM fn_helpcollations()")as$ib)$I[preg_replace('~_.*~','',$ib)][]=$ib;return$I;}function
information_schema($j){return
get_schema()=="INFORMATION_SCHEMA";}function
error(){global$f;return
nl_br(h(preg_replace('~^(\[[^]]*])+~m','',$f->error)));}function
create_database($j,$ib){return
queries("CREATE DATABASE ".idf_escape($j).(preg_match('~^[a-z0-9_]+$~i',$ib)?" COLLATE $ib":""));}function
drop_databases($i){return
queries("DROP DATABASE ".implode(", ",array_map('Adminer\idf_escape',$i)));}function
rename_database($B,$ib){if(preg_match('~^[a-z0-9_]+$~i',$ib))queries("ALTER DATABASE ".idf_escape(DB)." COLLATE $ib");queries("ALTER DATABASE ".idf_escape(DB)." MODIFY NAME = ".idf_escape($B));return
true;}function
auto_increment(){return" IDENTITY".($_POST["Auto_increment"]!=""?"(".number($_POST["Auto_increment"]).",1)":"")." PRIMARY KEY";}function
alter_table($Q,$B,$o,$fd,$pb,$vc,$ib,$Da,$Zf){$c=array();$rb=array();$Jf=fields($Q);foreach($o
as$n){$d=idf_escape($n[0]);$X=$n[1];if(!$X)$c["DROP"][]=" COLUMN $d";else{$X[1]=preg_replace("~( COLLATE )'(\\w+)'~",'\1\2',$X[1]);$rb[$n[0]]=$X[5];unset($X[5]);if(preg_match('~ AS ~',$X[3]))unset($X[1],$X[2]);if($n[0]=="")$c["ADD"][]="\n  ".implode("",$X).($Q==""?substr($fd[$X[0]],16+strlen($X[0])):"");else{$k=$X[3];unset($X[3]);unset($X[6]);if($d!=$X[0])queries("EXEC sp_rename ".q(table($Q).".$d").", ".q(idf_unescape($X[0])).", 'COLUMN'");$c["ALTER COLUMN ".implode("",$X)][]="";$If=$Jf[$n[0]];if(default_value($If)!=$k){if($If["default"]!==null)$c["DROP"][]=" ".idf_escape($If["default_constraint"]);if($k)$c["ADD"][]="\n $k FOR $d";}}}}if($Q=="")return
queries("CREATE TABLE ".table($B)." (".implode(",",(array)$c["ADD"])."\n)");if($Q!=$B)queries("EXEC sp_rename ".q(table($Q)).", ".q($B));if($fd)$c[""]=$fd;foreach($c
as$y=>$X){if(!queries("ALTER TABLE ".table($B)." $y".implode(",",$X)))return
false;}foreach($rb
as$y=>$X){$pb=substr($X,9);queries("EXEC sp_dropextendedproperty @name = N'MS_Description', @level0type = N'Schema', @level0name = ".q(get_schema()).", @level1type = N'Table', @level1name = ".q($B).", @level2type = N'Column', @level2name = ".q($y));queries("EXEC sp_addextendedproperty @name = N'MS_Description', @value = ".$pb.", @level0type = N'Schema', @level0name = ".q(get_schema()).", @level1type = N'Table', @level1name = ".q($B).", @level2type = N'Column', @level2name = ".q($y));}return
true;}function
alter_indexes($Q,$c){$w=array();$fc=array();foreach($c
as$X){if($X[2]=="DROP"){if($X[0]=="PRIMARY")$fc[]=idf_escape($X[1]);else$w[]=idf_escape($X[1])." ON ".table($Q);}elseif(!queries(($X[0]!="PRIMARY"?"CREATE $X[0] ".($X[0]!="INDEX"?"INDEX ":"").idf_escape($X[1]!=""?$X[1]:uniqid($Q."_"))." ON ".table($Q):"ALTER TABLE ".table($Q)." ADD PRIMARY KEY")." (".implode(", ",$X[2]).")"))return
false;}return(!$w||queries("DROP INDEX ".implode(", ",$w)))&&(!$fc||queries("ALTER TABLE ".table($Q)." DROP ".implode(", ",$fc)));}function
last_id(){return
get_val("SELECT SCOPE_IDENTITY()");}function
explain($f,$G){$f->query("SET SHOWPLAN_ALL ON");$I=$f->query($G);$f->query("SET SHOWPLAN_ALL OFF");return$I;}function
found_rows($R,$Z){}function
foreign_keys($Q){$I=array();$tf=array("CASCADE","NO ACTION","SET NULL","SET DEFAULT");foreach(get_rows("EXEC sp_fkeys @fktable_name = ".q($Q).", @fktable_owner = ".q(get_schema()))as$J){$q=&$I[$J["FK_NAME"]];$q["db"]=$J["PKTABLE_QUALIFIER"];$q["ns"]=$J["PKTABLE_OWNER"];$q["table"]=$J["PKTABLE_NAME"];$q["on_update"]=$tf[$J["UPDATE_RULE"]];$q["on_delete"]=$tf[$J["DELETE_RULE"]];$q["source"][]=$J["FKCOLUMN_NAME"];$q["target"][]=$J["PKCOLUMN_NAME"];}return$I;}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($hj){return
queries("DROP VIEW ".implode(", ",array_map('Adminer\table',$hj)));}function
drop_tables($S){return
queries("DROP TABLE ".implode(", ",array_map('Adminer\table',$S)));}function
move_tables($S,$hj,$ei){return
apply_queries("ALTER SCHEMA ".idf_escape($ei)." TRANSFER",array_merge($S,$hj));}function
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
set_schema($bh){$_GET["ns"]=$bh;return
true;}function
create_sql($Q,$Da,$Oh){global$l;if(is_view(table_status($Q))){$gj=view($Q);return"CREATE VIEW ".table($Q)." AS $gj[select]";}$o=array();$F=false;foreach(fields($Q)as$B=>$n){$X=process_field($n,$n);if($X[6])$F=true;$o[]=implode("",$X);}foreach(indexes($Q)as$B=>$w){if(!$F||$w["type"]!="PRIMARY"){$e=array();foreach($w["columns"]as$y=>$X)$e[]=idf_escape($X).($w["descs"][$y]?" DESC":"");$B=idf_escape($B);$o[]=($w["type"]=="INDEX"?"INDEX $B":"CONSTRAINT $B ".($w["type"]=="UNIQUE"?"UNIQUE":"PRIMARY KEY"))." (".implode(", ",$e).")";}}foreach($l->checkConstraints($Q)as$B=>$Wa)$o[]="CONSTRAINT ".idf_escape($B)." CHECK ($Wa)";return"CREATE TABLE ".table($Q)." (\n\t".implode(",\n\t",$o)."\n)";}function
foreign_keys_sql($Q){$o=array();foreach(foreign_keys($Q)as$fd)$o[]=ltrim(format_foreign_key($fd));return($o?"ALTER TABLE ".table($Q)." ADD\n\t".implode(",\n\t",$o).";\n\n":"");}function
truncate_sql($Q){return"TRUNCATE TABLE ".table($Q);}function
use_sql($Mb){return"USE ".idf_escape($Mb);}function
trigger_sql($Q){$I="";foreach(triggers($Q)as$B=>$Ci)$I.=create_trigger(" ON ".table($Q),trigger($B)).";";return$I;}function
convert_field($n){}function
unconvert_field($n,$I){return$I;}function
support($Tc){return
preg_match('~^(check|comment|columns|database|drop_col|dump|indexes|descidx|scheme|sql|table|trigger|view|view_trigger)$~',$Tc);}}$ec["mongo"]="MongoDB (alpha)";if(isset($_GET["mongo"])){define('Adminer\DRIVER',"mongo");if(class_exists('MongoDB\Driver\Manager')){class
Db{var$extension="MongoDB",$server_info=MONGODB_VERSION,$affected_rows,$error,$last_id;var$_link;var$_db,$_db_name;function
connect($Si,$Af){$this->_link=new
\MongoDB\Driver\Manager($Si,$Af);$this->executeDbCommand($Af["db"],array('ping'=>1));}function
executeCommand($nb){return$this->executeDbCommand($this->_db_name);}function
executeDbCommand($j,$nb){try{return$this->_link->executeCommand($j,new
\MongoDB\Driver\Command($nb));}catch(Exception$mc){$this->error=$mc->getMessage();return
array();}}function
executeBulkWrite($af,$Pa,$Cb){try{$Qg=$this->_link->executeBulkWrite($af,$Pa);$this->affected_rows=$Qg->$Cb();return
true;}catch(Exception$mc){$this->error=$mc->getMessage();return
false;}}function
query($G){return
false;}function
select_db($Mb){$this->_db_name=$Mb;return
true;}function
quote($P){return$P;}}class
Result{var$num_rows;private$rows=array(),$offset=0,$charset=array();function
__construct($H){foreach($H
as$fe){$J=array();foreach($fe
as$y=>$X){if(is_a($X,'MongoDB\BSON\Binary'))$this->charset[$y]=63;$J[$y]=(is_a($X,'MongoDB\BSON\ObjectID')?'MongoDB\BSON\ObjectID("'."$X\")":(is_a($X,'MongoDB\BSON\UTCDatetime')?$X->toDateTime()->format('Y-m-d H:i:s'):(is_a($X,'MongoDB\BSON\Binary')?$X->getData():(is_a($X,'MongoDB\BSON\Regex')?"$X":(is_object($X)||is_array($X)?json_encode($X,256):$X)))));}$this->rows[]=$J;foreach($J
as$y=>$X){if(!isset($this->rows[0][$y]))$this->rows[0][$y]=null;}}$this->num_rows=count($this->rows);}function
fetch_assoc(){$J=current($this->rows);if(!$J)return$J;$I=array();foreach($this->rows[0]as$y=>$X)$I[$y]=$J[$y];next($this->rows);return$I;}function
fetch_row(){$I=$this->fetch_assoc();if(!$I)return$I;return
array_values($I);}function
fetch_field(){$ke=array_keys($this->rows[0]);$B=$ke[$this->offset++];return(object)array('name'=>$B,'charsetnr'=>$this->charset[$B],);}}function
get_databases($dd){global$f;$I=array();foreach($f->executeCommand(array('listDatabases'=>1))as$Qb){foreach($Qb->databases
as$j)$I[]=$j->name;}return$I;}function
count_tables($i){$I=array();return$I;}function
tables_list(){global$f;$kb=array();foreach($f->executeCommand(array('listCollections'=>1))as$H)$kb[$H->name]='table';return$kb;}function
drop_databases($i){return
false;}function
indexes($Q,$g=null){global$f;$I=array();foreach($f->executeCommand(array('listIndexes'=>$Q))as$w){$Xb=array();$e=array();foreach(get_object_vars($w->key)as$d=>$U){$Xb[]=($U==-1?'1':null);$e[]=$d;}$I[$w->name]=array("type"=>($w->name=="_id_"?"PRIMARY":(isset($w->unique)?"UNIQUE":"INDEX")),"columns"=>$e,"lengths"=>array(),"descs"=>$Xb,);}return$I;}function
fields($Q){global$l;$o=fields_from_edit();if(!$o){$H=$l->select($Q,array("*"),null,null,array(),10);if($H){while($J=$H->fetch_assoc()){foreach($J
as$y=>$X){$J[$y]=null;$o[$y]=array("field"=>$y,"type"=>"string","null"=>($y!=$l->primary),"auto_increment"=>($y==$l->primary),"privileges"=>array("insert"=>1,"select"=>1,"update"=>1,"where"=>1,"order"=>1,),);}}}}return$o;}function
found_rows($R,$Z){global$f;$Z=where_to_query($Z);$ui=$f->executeCommand(array('count'=>$R['Name'],'query'=>$Z))->toArray();return$ui[0]->n;}function
sql_query_where_parser($zg){$zg=preg_replace('~^\s*WHERE\s*~',"",$zg);while($zg[0]=="(")$zg=preg_replace('~^\((.*)\)$~',"$1",$zg);$rj=explode(' AND ',$zg);$sj=explode(') OR (',$zg);$Z=array();foreach($rj
as$pj)$Z[]=trim($pj);if(count($sj)==1)$sj=array();elseif(count($sj)>1)$Z=array();return
where_to_query($Z,$sj);}function
where_to_query($nj=array(),$oj=array()){global$b;$Kb=array();foreach(array('and'=>$nj,'or'=>$oj)as$U=>$Z){if(is_array($Z)){foreach($Z
as$Lc){list($gb,$wf,$X)=explode(" ",$Lc,3);if($gb=="_id"&&preg_match('~^(MongoDB\\\\BSON\\\\ObjectID)\("(.+)"\)$~',$X,$A)){list(,$db,$X)=$A;$X=new$db($X);}if(!in_array($wf,$b->operators))continue;if(preg_match('~^\(f\)(.+)~',$wf,$A)){$X=(float)$X;$wf=$A[1];}elseif(preg_match('~^\(date\)(.+)~',$wf,$A)){$Nb=new
\DateTime($X);$X=new
\MongoDB\BSON\UTCDatetime($Nb->getTimestamp()*1000);$wf=$A[1];}switch($wf){case'=':$wf='$eq';break;case'!=':$wf='$ne';break;case'>':$wf='$gt';break;case'<':$wf='$lt';break;case'>=':$wf='$gte';break;case'<=':$wf='$lte';break;case'regex':$wf='$regex';break;default:continue
2;}if($U=='and')$Kb['$and'][]=array($gb=>array($wf=>$X));elseif($U=='or')$Kb['$or'][]=array($gb=>array($wf=>$X));}}}return$Kb;}}class
Driver
extends
SqlDriver{static$lg=array("mongodb");static$he="mongo";var$editFunctions=array(array("json"));var$operators=array("=","!=",">","<",">=","<=","regex","(f)=","(f)!=","(f)>","(f)<","(f)>=","(f)<=","(date)=","(date)!=","(date)>","(date)<","(date)>=","(date)<=",);var$primary="_id";function
select($Q,$L,$Z,$sd,$Cf=array(),$z=1,$D=0,$qg=false){$L=($L==array("*")?array():array_fill_keys($L,1));if(count($L)&&!isset($L['_id']))$L['_id']=0;$Z=where_to_query($Z);$_h=array();foreach($Cf
as$X){$X=preg_replace('~ DESC$~','',$X,1,$Bb);$_h[$X]=($Bb?-1:1);}if(isset($_GET['limit'])&&is_numeric($_GET['limit'])&&$_GET['limit']>0)$z=$_GET['limit'];$z=min(200,max(1,(int)$z));$xh=$D*$z;try{return
new
Result($this->conn->_link->executeQuery($this->conn->_db_name.".$Q",new
\MongoDB\Driver\Query($Z,array('projection'=>$L,'limit'=>$z,'skip'=>$xh,'sort'=>$_h))));}catch(Exception$mc){$this->conn->error=$mc->getMessage();return
false;}}function
update($Q,$N,$zg,$z=0,$lh="\n"){$j=$this->conn->_db_name;$Z=sql_query_where_parser($zg);$Pa=new
\MongoDB\Driver\BulkWrite(array());if(isset($N['_id']))unset($N['_id']);$Kg=array();foreach($N
as$y=>$Y){if($Y=='NULL'){$Kg[$y]=1;unset($N[$y]);}}$Ri=array('$set'=>$N);if(count($Kg))$Ri['$unset']=$Kg;$Pa->update($Z,$Ri,array('upsert'=>false));return$this->conn->executeBulkWrite("$j.$Q",$Pa,'getModifiedCount');}function
delete($Q,$zg,$z=0){$j=$this->conn->_db_name;$Z=sql_query_where_parser($zg);$Pa=new
\MongoDB\Driver\BulkWrite(array());$Pa->delete($Z,array('limit'=>$z));return$this->conn->executeBulkWrite("$j.$Q",$Pa,'getDeletedCount');}function
insert($Q,$N){$j=$this->conn->_db_name;$Pa=new
\MongoDB\Driver\BulkWrite(array());if($N['_id']=='')unset($N['_id']);$Pa->insert($N);return$this->conn->executeBulkWrite("$j.$Q",$Pa,'getInsertedCount');}}function
table($v){return$v;}function
idf_escape($v){return$v;}function
table_status($B="",$Sc=false){$I=array();foreach(tables_list()as$Q=>$U){$I[$Q]=array("Name"=>$Q);if($B==$Q)return$I[$Q];}return$I;}function
create_database($j,$ib){return
true;}function
last_id(){global$f;return$f->last_id;}function
error(){global$f;return
h($f->error);}function
collations(){return
array();}function
logged_user(){global$b;$Fb=$b->credentials();return$Fb[1];}function
connect($Fb){global$b;$f=new
Db;list($M,$V,$E)=$Fb;if($M=="")$M="localhost:27017";$Af=array();if($V.$E!=""){$Af["username"]=$V;$Af["password"]=$E;}$j=$b->database();if($j!="")$Af["db"]=$j;if(($Ca=getenv("MONGO_AUTH_SOURCE")))$Af["authSource"]=$Ca;$f->connect("mongodb://$M",$Af);if($f->error)return$f->error;return$f;}function
alter_indexes($Q,$c){global$f;foreach($c
as$X){list($U,$B,$N)=$X;if($N=="DROP")$I=$f->_db->command(array("deleteIndexes"=>$Q,"index"=>$B));else{$e=array();foreach($N
as$d){$d=preg_replace('~ DESC$~','',$d,1,$Bb);$e[$d]=($Bb?-1:1);}$I=$f->_db->selectCollection($Q)->ensureIndex($e,array("unique"=>($U=="UNIQUE"),"name"=>$B,));}if($I['errmsg']){$f->error=$I['errmsg'];return
false;}}return
true;}function
support($Tc){return
preg_match("~database|indexes|descidx~",$Tc);}function
db_collation($j,$jb){}function
information_schema(){}function
is_view($R){}function
convert_field($n){}function
unconvert_field($n,$I){return$I;}function
foreign_keys($Q){return
array();}function
fk_support($R){}function
engines(){return
array();}function
alter_table($Q,$B,$o,$fd,$pb,$vc,$ib,$Da,$Zf){global$f;if($Q==""){$f->_db->createCollection($B);return
true;}}function
drop_tables($S){global$f;foreach($S
as$Q){$Ng=$f->_db->selectCollection($Q)->drop();if(!$Ng['ok'])return
false;}return
true;}function
truncate_tables($S){global$f;foreach($S
as$Q){$Ng=$f->_db->selectCollection($Q)->remove();if(!$Ng['ok'])return
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
databases($dd=true){return
get_databases($dd);}function
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
loginForm(){global$ec;echo"<table class='layout'>\n",$this->loginFormField('driver','<tr><th>'.'System'.'<td>',html_select("auth[driver]",$ec,DRIVER,"loginDriver(this);")),$this->loginFormField('server','<tr><th>'.'Server'.'<td>','<input name="auth[server]" value="'.h(SERVER).'" title="hostname[:port]" placeholder="localhost" autocapitalize="off">'),$this->loginFormField('username','<tr><th>'.'Username'.'<td>','<input name="auth[username]" id="username" autofocus value="'.h($_GET["username"]).'" autocomplete="username" autocapitalize="off">'.script("qs('#username').form['auth[driver]'].onchange();")),$this->loginFormField('password','<tr><th>'.'Password'.'<td>','<input type="password" name="auth[password]" autocomplete="current-password">'),$this->loginFormField('db','<tr><th>'.'Database'.'<td>','<input name="auth[db]" value="'.h($_GET["db"]).'" autocapitalize="off">'),"</table>\n","<p><input type='submit' value='".'Login'."'>\n",checkbox("auth[permanent]",1,$_COOKIE["adminer_permanent"],'Permanent login')."\n";}function
loginFormField($B,$Cd,$Y){return$Cd.$Y."\n";}function
login($Ae,$E){if($E=="")return
sprintf('Adminer does not support accessing a database without a password, <a href="https://www.adminer.org/en/password/"%s>more information</a>.',target_blank());return
true;}function
tableName($Uh){return
h($Uh["Name"]);}function
fieldName($n,$Cf=0){return'<span title="'.h($n["full_type"]).'">'.h($n["field"]).'</span>';}function
selectLinks($Uh,$N=""){global$l;echo'<p class="links">';$ze=array("select"=>'Select data');if(support("table")||support("indexes"))$ze["table"]='Show structure';$ee=false;if(support("table")){$ee=is_view($Uh);if($ee)$ze["view"]='Alter view';else$ze["create"]='Alter table';}if($N!==null)$ze["edit"]='New item';$B=$Uh["Name"];foreach($ze
as$y=>$X)echo" <a href='".h(ME)."$y=".urlencode($B).($y=="edit"?$N:"")."'".bold(isset($_GET[$y])).">$X</a>";echo
doc_link(array(JUSH=>$l->tableHelp($B,$ee)),"?"),"\n";}function
foreignKeys($Q){return
foreign_keys($Q);}function
backwardKeys($Q,$Th){return
array();}function
backwardKeysPrint($Ga,$J){}function
selectQuery($G,$Kh,$Rc=false){global$l;$I="</p>\n";if(!$Rc&&($kj=$l->warnings())){$u="warnings";$I=", <a href='#$u'>".'Warnings'."</a>".script("qsl('a').onclick = partial(toggle, '$u');","")."$I<div id='$u' class='hidden'>\n$kj</div>\n";}return"<p><code class='jush-".JUSH."'>".h(str_replace("\n"," ",$G))."</code> <span class='time'>(".format_time($Kh).")</span>".(support("sql")?" <a href='".h(ME)."sql=".urlencode($G)."'>".'Edit'."</a>":"").$I;}function
sqlCommandQuery($G){return
shorten_utf8(trim($G),1000);}function
rowDescription($Q){return"";}function
rowDescriptions($K,$gd){return$K;}function
selectLink($X,$n){}function
selectVal($X,$_,$n,$Mf){$I=($X===null?"<i>NULL</i>":(preg_match("~char|binary|boolean~",$n["type"])&&!preg_match("~var~",$n["type"])?"<code>$X</code>":$X));if(preg_match('~blob|bytea|raw|file~',$n["type"])&&!is_utf8($X))$I="<i>".lang(array('%d byte','%d bytes'),strlen($Mf))."</i>";if(preg_match('~json~',$n["type"]))$I="<code class='jush-js'>$I</code>";return($_?"<a href='".h($_)."'".(is_url($_)?target_blank():"").">$I</a>":$I);}function
editVal($X,$n){return$X;}function
tableStructurePrint($o){global$l;echo"<div class='scrollable'>\n","<table class='nowrap odds'>\n","<thead><tr><th>".'Column'."<td>".'Type'.(support("comment")?"<td>".'Comment':"")."</thead>\n";$Nh=$l->structuredTypes();foreach($o
as$n){echo"<tr><th>".h($n["field"]);$U=h($n["full_type"]);echo"<td><span title='".h($n["collation"])."'>".(in_array($U,(array)$Nh['User types'])?"<a href='".h(ME.'type='.urlencode($U))."'>$U</a>":$U)."</span>",($n["null"]?" <i>NULL</i>":""),($n["auto_increment"]?" <i>".'Auto Increment'."</i>":"");$k=h($n["default"]);echo(isset($n["default"])?" <span title='".'Default value'."'>[<b>".($n["generated"]?"<code class='jush-".JUSH."'>$k</code>":$k)."</b>]</span>":""),(support("comment")?"<td>".h($n["comment"]):""),"\n";}echo"</table>\n","</div>\n";}function
tableIndexesPrint($x){echo"<table>\n";foreach($x
as$B=>$w){ksort($w["columns"]);$qg=array();foreach($w["columns"]as$y=>$X)$qg[]="<i>".h($X)."</i>".($w["lengths"][$y]?"(".$w["lengths"][$y].")":"").($w["descs"][$y]?" DESC":"");echo"<tr title='".h($B)."'><th>$w[type]<td>".implode(", ",$qg)."\n";}echo"</table>\n";}function
selectColumnsPrint($L,$e){global$l;print_fieldset("select",'Select',$L);$t=0;$L[""]=array();foreach($L
as$y=>$X){$X=$_GET["columns"][$y];$d=select_input(" name='columns[$t][col]'",$e,$X["col"],($y!==""?"selectFieldChange":"selectAddRow"));echo"<div>".($l->functions||$l->grouping?html_select("columns[$t][fun]",array(-1=>"")+array_filter(array('Functions'=>$l->functions,'Aggregation'=>$l->grouping)),$X["fun"]).on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'",1).script("qsl('select').onchange = function () { helpClose();".($y!==""?"":" qsl('select, input', this.parentNode).onchange();")." };","")."($d)":$d)."</div>\n";$t++;}echo"</div></fieldset>\n";}function
selectSearchPrint($Z,$e,$x){print_fieldset("search",'Search',$Z);foreach($x
as$t=>$w){if($w["type"]=="FULLTEXT"){echo"<div>(<i>".implode("</i>, <i>",array_map('Adminer\h',$w["columns"]))."</i>) AGAINST"," <input type='search' name='fulltext[$t]' value='".h($_GET["fulltext"][$t])."'>",script("qsl('input').oninput = selectFieldChange;",""),checkbox("boolean[$t]",1,isset($_GET["boolean"][$t]),"BOOL"),"</div>\n";}}$Ua="this.parentNode.firstChild.onchange();";foreach(array_merge((array)$_GET["where"],array(array()))as$t=>$X){if(!$X||("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators))){echo"<div>".select_input(" name='where[$t][col]'",$e,$X["col"],($X?"selectFieldChange":"selectAddRow"),"(".'anywhere'.")"),html_select("where[$t][op]",$this->operators,$X["op"],$Ua),"<input type='search' name='where[$t][val]' value='".h($X["val"])."'>",script("mixin(qsl('input'), {oninput: function () { $Ua }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});",""),"</div>\n";}}echo"</div></fieldset>\n";}function
selectOrderPrint($Cf,$e,$x){print_fieldset("sort",'Sort',$Cf);$t=0;foreach((array)$_GET["order"]as$y=>$X){if($X!=""){echo"<div>".select_input(" name='order[$t]'",$e,$X,"selectFieldChange"),checkbox("desc[$t]",1,isset($_GET["desc"][$y]),'descending')."</div>\n";$t++;}}echo"<div>".select_input(" name='order[$t]'",$e,"","selectAddRow"),checkbox("desc[$t]",1,false,'descending')."</div>\n","</div></fieldset>\n";}function
selectLimitPrint($z){echo"<fieldset><legend>".'Limit'."</legend><div>";echo"<input type='number' name='limit' class='size' value='".h($z)."'>",script("qsl('input').oninput = selectFieldChange;",""),"</div></fieldset>\n";}function
selectLengthPrint($ki){if($ki!==null){echo"<fieldset><legend>".'Text length'."</legend><div>","<input type='number' name='text_length' class='size' value='".h($ki)."'>","</div></fieldset>\n";}}function
selectActionPrint($x){echo"<fieldset><legend>".'Action'."</legend><div>","<input type='submit' value='".'Select'."'>"," <span id='noindex' title='".'Full table scan'."'></span>","<script".nonce().">\n","var indexColumns = ";$e=array();foreach($x
as$w){$Jb=reset($w["columns"]);if($w["type"]!="FULLTEXT"&&$Jb)$e[$Jb]=1;}$e[""]=1;foreach($e
as$y=>$X)json_row($y);echo";\n","selectFieldChange.call(qs('#form')['select']);\n","</script>\n","</div></fieldset>\n";}function
selectCommandPrint(){return!information_schema(DB);}function
selectImportPrint(){return!information_schema(DB);}function
selectEmailPrint($sc,$e){}function
selectColumnsProcess($e,$x){global$l;$L=array();$sd=array();foreach((array)$_GET["columns"]as$y=>$X){if($X["fun"]=="count"||($X["col"]!=""&&(!$X["fun"]||in_array($X["fun"],$l->functions)||in_array($X["fun"],$l->grouping)))){$L[$y]=apply_sql_function($X["fun"],($X["col"]!=""?idf_escape($X["col"]):"*"));if(!in_array($X["fun"],$l->grouping))$sd[]=$L[$y];}}return
array($L,$sd);}function
selectSearchProcess($o,$x){global$f,$l;$I=array();foreach($x
as$t=>$w){if($w["type"]=="FULLTEXT"&&$_GET["fulltext"][$t]!="")$I[]="MATCH (".implode(", ",array_map('Adminer\idf_escape',$w["columns"])).") AGAINST (".q($_GET["fulltext"][$t]).(isset($_GET["boolean"][$t])?" IN BOOLEAN MODE":"").")";}foreach((array)$_GET["where"]as$y=>$X){if("$X[col]$X[val]"!=""&&in_array($X["op"],$this->operators)){$ng="";$sb=" $X[op]";if(preg_match('~IN$~',$X["op"])){$Md=process_length($X["val"]);$sb.=" ".($Md!=""?$Md:"(NULL)");}elseif($X["op"]=="SQL")$sb=" $X[val]";elseif($X["op"]=="LIKE %%")$sb=" LIKE ".$this->processInput($o[$X["col"]],"%$X[val]%");elseif($X["op"]=="ILIKE %%")$sb=" ILIKE ".$this->processInput($o[$X["col"]],"%$X[val]%");elseif($X["op"]=="FIND_IN_SET"){$ng="$X[op](".q($X["val"]).", ";$sb=")";}elseif(!preg_match('~NULL$~',$X["op"]))$sb.=" ".$this->processInput($o[$X["col"]],$X["val"]);if($X["col"]!="")$I[]=$ng.$l->convertSearch(idf_escape($X["col"]),$X,$o[$X["col"]]).$sb;else{$lb=array();foreach($o
as$B=>$n){if(isset($n["privileges"]["where"])&&(preg_match('~^[-\d.'.(preg_match('~IN$~',$X["op"])?',':'').']+$~',$X["val"])||!preg_match('~'.number_type().'|bit~',$n["type"]))&&(!preg_match("~[\x80-\xFF]~",$X["val"])||preg_match('~char|text|enum|set~',$n["type"]))&&(!preg_match('~date|timestamp~',$n["type"])||preg_match('~^\d+-\d+-\d+~',$X["val"])))$lb[]=$ng.$l->convertSearch(idf_escape($B),$X,$n).$sb;}$I[]=($lb?"(".implode(" OR ",$lb).")":"1 = 0");}}}return$I;}function
selectOrderProcess($o,$x){$I=array();foreach((array)$_GET["order"]as$y=>$X){if($X!="")$I[]=(preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~',$X)?$X:idf_escape($X)).(isset($_GET["desc"][$y])?" DESC":"");}return$I;}function
selectLimitProcess(){return(isset($_GET["limit"])?$_GET["limit"]:"50");}function
selectLengthProcess(){return(isset($_GET["text_length"])?$_GET["text_length"]:"100");}function
selectEmailProcess($Z,$gd){return
false;}function
selectQueryBuild($L,$Z,$sd,$Cf,$z,$D){return"";}function
messageQuery($G,$li,$Rc=false){global$l;restart_session();$Dd=&get_session("queries");if(!$Dd[$_GET["db"]])$Dd[$_GET["db"]]=array();if(strlen($G)>1e6)$G=preg_replace('~[\x80-\xFF]+$~','',substr($G,0,1e6))."\nâ€¦";$Dd[$_GET["db"]][]=array($G,time(),$li);$Gh="sql-".count($Dd[$_GET["db"]]);$I="<a href='#$Gh' class='toggle'>".'SQL command'."</a>\n";if(!$Rc&&($kj=$l->warnings())){$u="warnings-".count($Dd[$_GET["db"]]);$I="<a href='#$u' class='toggle'>".'Warnings'."</a>, $I<div id='$u' class='hidden'>\n$kj</div>\n";}return" <span class='time'>".@date("H:i:s")."</span>"." $I<div id='$Gh' class='hidden'><pre><code class='jush-".JUSH."'>".shorten_utf8($G,1000)."</code></pre>".($li?" <span class='time'>($li)</span>":'').(support("sql")?'<p><a href="'.h(str_replace("db=".urlencode(DB),"db=".urlencode($_GET["db"]),ME).'sql=&history='.(count($Dd[$_GET["db"]])-1)).'">'.'Edit'.'</a>':'').'</div>';}function
editRowPrint($Q,$o,$J,$Ri){}function
editFunctions($n){global$l;$I=($n["null"]?"NULL/":"");$Ri=isset($_GET["select"])||where($_GET);foreach($l->editFunctions
as$y=>$nd){if(!$y||(!isset($_GET["call"])&&$Ri)){foreach($nd
as$dg=>$X){if(!$dg||preg_match("~$dg~",$n["type"]))$I.="/$X";}}if($y&&!preg_match('~set|blob|bytea|raw|file|bool~',$n["type"]))$I.="/SQL";}if($n["auto_increment"]&&!$Ri)$I='Auto Increment';return
explode("/",$I);}function
editInput($Q,$n,$Aa,$Y){if($n["type"]=="enum")return(isset($_GET["select"])?"<label><input type='radio'$Aa value='-1' checked><i>".'original'."</i></label> ":"").($n["null"]?"<label><input type='radio'$Aa value=''".($Y!==null||isset($_GET["select"])?"":" checked")."><i>NULL</i></label> ":"").enum_input("radio",$Aa,$n,$Y,$Y===0?0:null);return"";}function
editHint($Q,$n,$Y){return"";}function
processInput($n,$Y,$s=""){if($s=="SQL")return$Y;$B=$n["field"];$I=q($Y);if(preg_match('~^(now|getdate|uuid)$~',$s))$I="$s()";elseif(preg_match('~^current_(date|timestamp)$~',$s))$I=$s;elseif(preg_match('~^([+-]|\|\|)$~',$s))$I=idf_escape($B)." $s $I";elseif(preg_match('~^[+-] interval$~',$s))$I=idf_escape($B)." $s ".(preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i",$Y)?$Y:$I);elseif(preg_match('~^(addtime|subtime|concat)$~',$s))$I="$s(".idf_escape($B).", $I)";elseif(preg_match('~^(md5|sha1|password|encrypt)$~',$s))$I="$s($I)";return
unconvert_field($n,$I);}function
dumpOutput(){$I=array('text'=>'open','file'=>'save');if(function_exists('gzencode'))$I['gz']='gzip';return$I;}function
dumpFormat(){return(support("dump")?array('sql'=>'SQL'):array())+array('csv'=>'CSV,','csv;'=>'CSV;','tsv'=>'TSV');}function
dumpDatabase($j){}function
dumpTable($Q,$Oh,$ee=0){if($_POST["format"]!="sql"){echo"\xef\xbb\xbf";if($Oh)dump_csv(array_keys(fields($Q)));}else{if($ee==2){$o=array();foreach(fields($Q)as$B=>$n)$o[]=idf_escape($B)." $n[full_type]";$h="CREATE TABLE ".table($Q)." (".implode(", ",$o).")";}else$h=create_sql($Q,$_POST["auto_increment"],$Oh);set_utf8mb4($h);if($Oh&&$h){if($Oh=="DROP+CREATE"||$ee==1)echo"DROP ".($ee==2?"VIEW":"TABLE")." IF EXISTS ".table($Q).";\n";if($ee==1)$h=remove_definer($h);echo"$h;\n\n";}}}function
dumpData($Q,$Oh,$G){global$f;if($Oh){$He=(JUSH=="sqlite"?0:1048576);$o=array();$Jd=false;if($_POST["format"]=="sql"){if($Oh=="TRUNCATE+INSERT")echo
truncate_sql($Q).";\n";$o=fields($Q);if(JUSH=="mssql"){foreach($o
as$n){if($n["auto_increment"]){echo"SET IDENTITY_INSERT ".table($Q)." ON;\n";$Jd=true;break;}}}}$H=$f->query($G,1);if($H){$Wd="";$Oa="";$ke=array();$od=array();$Qh="";$Uc=($Q!=''?'fetch_assoc':'fetch_row');while($J=$H->$Uc()){if(!$ke){$cj=array();foreach($J
as$X){$n=$H->fetch_field();if($o[$n->name]['generated']){$od[$n->name]=true;continue;}$ke[]=$n->name;$y=idf_escape($n->name);$cj[]="$y = VALUES($y)";}$Qh=($Oh=="INSERT+UPDATE"?"\nON DUPLICATE KEY UPDATE ".implode(", ",$cj):"").";\n";}if($_POST["format"]!="sql"){if($Oh=="table"){dump_csv($ke);$Oh="INSERT";}dump_csv($J);}else{if(!$Wd)$Wd="INSERT INTO ".table($Q)." (".implode(", ",array_map('Adminer\idf_escape',$ke)).") VALUES";foreach($J
as$y=>$X){if($od[$y]){unset($J[$y]);continue;}$n=$o[$y];$J[$y]=($X!==null?unconvert_field($n,preg_match(number_type(),$n["type"])&&!preg_match('~\[~',$n["full_type"])&&is_numeric($X)?$X:q(($X===false?0:$X))):"NULL");}$Zg=($He?"\n":" ")."(".implode(",\t",$J).")";if(!$Oa)$Oa=$Wd.$Zg;elseif(strlen($Oa)+4+strlen($Zg)+strlen($Qh)<$He)$Oa.=",$Zg";else{echo$Oa.$Qh;$Oa=$Wd.$Zg;}}}if($Oa)echo$Oa.$Qh;}elseif($_POST["format"]=="sql")echo"-- ".str_replace("\n"," ",$f->error)."\n";if($Jd)echo"SET IDENTITY_INSERT ".table($Q)." OFF;\n";}}function
dumpFilename($Hd){return
friendly_url($Hd!=""?$Hd:(SERVER!=""?SERVER:"localhost"));}function
dumpHeaders($Hd,$Ve=false){$Pf=$_POST["output"];$Mc=(preg_match('~sql~',$_POST["format"])?"sql":($Ve?"tar":"csv"));header("Content-Type: ".($Pf=="gz"?"application/x-gzip":($Mc=="tar"?"application/x-tar":($Mc=="sql"||$Pf!="file"?"text/plain":"text/csv")."; charset=utf-8")));if($Pf=="gz"){ob_start(function($P){return
gzencode($P);},1e6);}return$Mc;}function
dumpFooter(){if($_POST["format"]=="sql")echo"-- ".gmdate("Y-m-d H:i:s e")."\n";}function
importServerPath(){return"adminer.sql";}function
homepage(){echo'<p class="links">'.($_GET["ns"]==""&&support("database")?'<a href="'.h(ME).'database=">'.'Alter database'."</a>\n":""),(support("scheme")?"<a href='".h(ME)."scheme='>".($_GET["ns"]!=""?'Alter schema':'Create schema')."</a>\n":""),($_GET["ns"]!==""?'<a href="'.h(ME).'schema=">'.'Database schema'."</a>\n":""),(support("privileges")?"<a href='".h(ME)."privileges='>".'Privileges'."</a>\n":"");return
true;}function
navigation($Ue){global$ia,$ec,$f;echo'<h1>
',$this->name(),'<span class="version">
',$ia,' <a href="https://www.adminer.org/#download"',target_blank(),' id="version">',(version_compare($ia,$_COOKIE["adminer_version"])<0?h($_COOKIE["adminer_version"]):""),'</a>
</span>
</h1>
';if($Ue=="auth"){$Pf="";foreach((array)$_SESSION["pwds"]as$ej=>$qh){foreach($qh
as$M=>$Zi){foreach($Zi
as$V=>$E){if($E!==null){$Qb=$_SESSION["db"][$ej][$M][$V];foreach(($Qb?array_keys($Qb):array(""))as$j)$Pf.="<li><a href='".h(auth_url($ej,$M,$V,$j))."'>($ec[$ej]) ".h($V.($M!=""?"@".$this->serverName($M):"").($j!=""?" - $j":""))."</a>\n";}}}}if($Pf)echo"<ul id='logins'>\n$Pf</ul>\n".script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");}else{$S=array();if($_GET["ns"]!==""&&!$Ue&&DB!=""){$f->select_db(DB);$S=table_status('',true);}echo
script_src(preg_replace("~\\?.*~","",ME)."?file=jush.js&version=5.0.4");if(support("sql")){echo'<script',nonce(),'>
';if($S){$ze=array();foreach($S
as$Q=>$U)$ze[]=preg_quote($Q,'/');echo"var jushLinks = { ".JUSH.": [ '".js_escape(ME).(support("table")?"table=":"select=")."\$&', /\\b(".implode("|",$ze).")\\b/g ] };\n";foreach(array("bac","bra","sqlite_quo","mssql_bra")as$X)echo"jushLinks.$X = jushLinks.".JUSH.";\n";}$ph=$f->server_info;echo'bodyLoad(\'',(is_object($f)?preg_replace('~^(\d\.?\d).*~s','\1',$ph):""),'\'',(preg_match('~MariaDB~',$ph)?", true":""),');
</script>
';}$this->databasesPrint($Ue);$oa=array();if(DB==""||!$Ue){if(support("sql")){$oa[]="<a href='".h(ME)."sql='".bold(isset($_GET["sql"])&&!isset($_GET["import"])).">".'SQL command'."</a>";$oa[]="<a href='".h(ME)."import='".bold(isset($_GET["import"])).">".'Import'."</a>";}$oa[]="<a href='".h(ME)."dump=".urlencode(isset($_GET["table"])?$_GET["table"]:$_GET["select"])."' id='dump'".bold(isset($_GET["dump"])).">".'Export'."</a>";}$Nd=$_GET["ns"]!==""&&!$Ue&&DB!="";if($Nd)$oa[]='<a href="'.h(ME).'create="'.bold($_GET["create"]==="").">".'Create table'."</a>";echo($oa?"<p class='links'>\n".implode("\n",$oa)."\n":"");if($Nd){if($S)$this->tablesPrint($S);else
echo"<p class='message'>".'No tables.'."</p>\n";}}}function
databasesPrint($Ue){global$b,$f;$i=$this->databases();if(DB&&$i&&!in_array(DB,$i))array_unshift($i,DB);echo'<form action="">
<p id="dbs">
';hidden_fields_get();$Ob=script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");echo"<span title='".'Database'."'>".'DB'."</span>: ".($i?html_select("db",array(""=>"")+$i,DB).$Ob:"<input name='db' value='".h(DB)."' autocapitalize='off' size='19'>\n"),"<input type='submit' value='".'Use'."'".($i?" class='hidden'":"").">\n";if(support("scheme")){if($Ue!="db"&&DB!=""&&$f->select_db(DB)){echo"<br>".'Schema'.": ".html_select("ns",array(""=>"")+$b->schemas(),$_GET["ns"]).$Ob;if($_GET["ns"]!="")set_schema($_GET["ns"]);}}foreach(array("import","sql","schema","dump","privileges")as$X){if(isset($_GET[$X])){echo"<input type='hidden' name='$X' value=''>";break;}}echo"</p></form>\n";}function
tablesPrint($S){echo"<ul id='tables'>".script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");foreach($S
as$Q=>$O){$B=$this->tableName($O);if($B!=""){echo'<li><a href="'.h(ME).'select='.urlencode($Q).'"'.bold($_GET["select"]==$Q||$_GET["edit"]==$Q,"select")." title='".'Select data'."'>".'select'."</a> ",(support("table")||support("indexes")?'<a href="'.h(ME).'table='.urlencode($Q).'"'.bold(in_array($Q,array($_GET["table"],$_GET["create"],$_GET["indexes"],$_GET["foreign"],$_GET["trigger"])),(is_view($O)?"view":"structure"))." title='".'Show structure'."'>$B</a>":"<span>$B</span>")."\n";}}echo"</ul>\n";}}$b=(function_exists('adminer_object')?adminer_object():new
Adminer);$ec=array("server"=>"MySQL")+$ec;if(!defined('Adminer\DRIVER')){define('Adminer\DRIVER',"server");if(extension_loaded("mysqli")){class
Db
extends
\MySQLi{var$extension="MySQLi";function
__construct(){parent::init();}function
connect($M="",$V="",$E="",$Mb=null,$hg=null,$zh=null){global$b;mysqli_report(MYSQLI_REPORT_OFF);list($Fd,$hg)=explode(":",$M,2);$Jh=$b->connectSsl();if($Jh)$this->ssl_set($Jh['key'],$Jh['cert'],$Jh['ca'],'','');$I=@$this->real_connect(($M!=""?$Fd:ini_get("mysqli.default_host")),($M.$V!=""?$V:ini_get("mysqli.default_user")),($M.$V.$E!=""?$E:ini_get("mysqli.default_pw")),$Mb,(is_numeric($hg)?$hg:ini_get("mysqli.default_port")),(!is_numeric($hg)?$hg:$zh),($Jh?($Jh['verify']!==false?2048:64):0));$this->options(MYSQLI_OPT_LOCAL_INFILE,false);return$I;}function
set_charset($Va){if(parent::set_charset($Va))return
true;parent::set_charset('utf8');return$this->query("SET NAMES $Va");}function
result($G,$n=0){$H=$this->query($G);if(!$H)return
false;$J=$H->fetch_array();return$J[$n];}function
quote($P){return"'".$this->escape_string($P)."'";}}}elseif(extension_loaded("mysql")&&!((ini_bool("sql.safe_mode")||ini_bool("mysql.allow_local_infile"))&&extension_loaded("pdo_mysql"))){class
Db{var$extension="MySQL",$server_info,$affected_rows,$errno,$error;private$link,$result;function
connect($M,$V,$E){if(ini_bool("mysql.allow_local_infile")){$this->error=sprintf('Disable %s or enable %s or %s extensions.',"'mysql.allow_local_infile'","MySQLi","PDO_MySQL");return
false;}$this->link=@mysql_connect(($M!=""?$M:ini_get("mysql.default_host")),("$M$V"!=""?$V:ini_get("mysql.default_user")),("$M$V$E"!=""?$E:ini_get("mysql.default_password")),true,131072);if($this->link)$this->server_info=mysql_get_server_info($this->link);else$this->error=mysql_error();return(bool)$this->link;}function
set_charset($Va){if(function_exists('mysql_set_charset')){if(mysql_set_charset($Va,$this->link))return
true;mysql_set_charset('utf8',$this->link);}return$this->query("SET NAMES $Va");}function
quote($P){return"'".mysql_real_escape_string($P,$this->link)."'";}function
select_db($Mb){return
mysql_select_db($Mb,$this->link);}function
query($G,$Ji=false){$H=@($Ji?mysql_unbuffered_query($G,$this->link):mysql_query($G,$this->link));$this->error="";if(!$H){$this->errno=mysql_errno($this->link);$this->error=mysql_error($this->link);return
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
connect($M,$V,$E){global$b;$Af=array(\PDO::MYSQL_ATTR_LOCAL_INFILE=>false);$Jh=$b->connectSsl();if($Jh){if($Jh['key'])$Af[\PDO::MYSQL_ATTR_SSL_KEY]=$Jh['key'];if($Jh['cert'])$Af[\PDO::MYSQL_ATTR_SSL_CERT]=$Jh['cert'];if($Jh['ca'])$Af[\PDO::MYSQL_ATTR_SSL_CA]=$Jh['ca'];if(isset($Jh['verify']))$Af[\PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT]=$Jh['verify'];}$this->dsn("mysql:charset=utf8;host=".str_replace(":",";unix_socket=",preg_replace('~:(\d)~',';port=\1',$M)),$V,$E,$Af);return
true;}function
set_charset($Va){$this->query("SET NAMES $Va");}function
select_db($Mb){return$this->query("USE ".idf_escape($Mb));}function
query($G,$Ji=false){$this->pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,!$Ji);return
parent::query($G,$Ji);}}}class
Driver
extends
SqlDriver{static$lg=array("MySQLi","MySQL","PDO_MySQL");static$he="sql";var$unsigned=array("unsigned","zerofill","unsigned zerofill");var$operators=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","REGEXP","IN","FIND_IN_SET","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL");var$functions=array("char_length","date","from_unixtime","lower","round","floor","ceil","sec_to_time","time_to_sec","upper");var$grouping=array("avg","count","count distinct","group_concat","max","min","sum");function
__construct($f){parent::__construct($f);$this->types=array('Numbers'=>array("tinyint"=>3,"smallint"=>5,"mediumint"=>8,"int"=>10,"bigint"=>20,"decimal"=>66,"float"=>12,"double"=>21),'Date and time'=>array("date"=>10,"datetime"=>19,"timestamp"=>19,"time"=>10,"year"=>4),'Strings'=>array("char"=>255,"varchar"=>65535,"tinytext"=>255,"text"=>65535,"mediumtext"=>16777215,"longtext"=>4294967295),'Lists'=>array("enum"=>65535,"set"=>64),'Binary'=>array("bit"=>20,"binary"=>255,"varbinary"=>65535,"tinyblob"=>255,"blob"=>65535,"mediumblob"=>16777215,"longblob"=>4294967295),'Geometry'=>array("geometry"=>0,"point"=>0,"linestring"=>0,"polygon"=>0,"multipoint"=>0,"multilinestring"=>0,"multipolygon"=>0,"geometrycollection"=>0),);$this->editFunctions=array(array("char"=>"md5/sha1/password/encrypt/uuid","binary"=>"md5/sha1","date|time"=>"now",),array(number_type()=>"+/-","date"=>"+ interval/- interval","time"=>"addtime/subtime","char|text"=>"concat",));if(min_version('5.7.8',10.2,$f))$this->types['Strings']["json"]=4294967295;if(min_version('',10.7,$f)){$this->types['Strings']["uuid"]=128;$this->editFunctions[0]['uuid']='uuid';}if(min_version(9,'',$f)){$this->types['Numbers']["vector"]=16383;$this->editFunctions[0]['vector']='string_to_vector';}if(min_version(5.7,10.2,$f))$this->generated=array("STORED","VIRTUAL");}function
insert($Q,$N){return($N?parent::insert($Q,$N):queries("INSERT INTO ".table($Q)." ()\nVALUES ()"));}function
insertUpdate($Q,$K,$F){$e=array_keys(reset($K));$ng="INSERT INTO ".table($Q)." (".implode(", ",$e).") VALUES\n";$cj=array();foreach($e
as$y)$cj[$y]="$y = VALUES($y)";$Qh="\nON DUPLICATE KEY UPDATE ".implode(", ",$cj);$cj=array();$we=0;foreach($K
as$N){$Y="(".implode(", ",$N).")";if($cj&&(strlen($ng)+$we+strlen($Y)+strlen($Qh)>1e6)){if(!queries($ng.implode(",\n",$cj).$Qh))return
false;$cj=array();$we=0;}$cj[]=$Y;$we+=strlen($Y)+2;}return
queries($ng.implode(",\n",$cj).$Qh);}function
slowQuery($G,$mi){if(min_version('5.7.8','10.1.2')){if(preg_match('~MariaDB~',$this->conn->server_info))return"SET STATEMENT max_statement_time=$mi FOR $G";elseif(preg_match('~^(SELECT\b)(.+)~is',$G,$A))return"$A[1] /*+ MAX_EXECUTION_TIME(".($mi*1000).") */ $A[2]";}}function
convertSearch($v,$X,$n){return(preg_match('~char|text|enum|set~',$n["type"])&&!preg_match("~^utf8~",$n["collation"])&&preg_match('~[\x80-\xFF]~',$X['val'])?"CONVERT($v USING ".charset($this->conn).")":$v);}function
warnings(){$H=$this->conn->query("SHOW WARNINGS");if($H&&$H->num_rows){ob_start();select($H);return
ob_get_clean();}}function
tableHelp($B,$ee=false){$Ce=preg_match('~MariaDB~',$this->conn->server_info);if(information_schema(DB))return
strtolower("information-schema-".($Ce?"$B-table/":str_replace("_","-",$B)."-table.html"));if(DB=="mysql")return($Ce?"mysql$B-table/":"system-schema.html");}function
hasCStyleEscapes(){static$Ra;if($Ra===null){$Hh=$this->conn->result("SHOW VARIABLES LIKE 'sql_mode'",1);$Ra=(strpos($Hh,'NO_BACKSLASH_ESCAPES')===false);}return$Ra;}}function
idf_escape($v){return"`".str_replace("`","``",$v)."`";}function
table($v){return
idf_escape($v);}function
connect($Fb){$f=new
Db;if($f->connect($Fb[0],$Fb[1],$Fb[2])){$f->set_charset(charset($f));$f->query("SET sql_quote_show_create = 1, autocommit = 1");return$f;}$I=$f->error;if(function_exists('iconv')&&!is_utf8($I)&&strlen($Zg=iconv("windows-1250","utf-8",$I))>strlen($I))$I=$Zg;return$I;}function
get_databases($dd){$I=get_session("dbs");if($I===null){$G="SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME";$I=($dd?slow_query($G):get_vals($G));restart_session();set_session("dbs",$I);stop_session();}return$I;}function
limit($G,$Z,$z,$C=0,$lh=" "){return" $G$Z".($z!==null?$lh."LIMIT $z".($C?" OFFSET $C":""):"");}function
limit1($Q,$G,$Z,$lh="\n"){return
limit($G,$Z,1,0,$lh);}function
db_collation($j,$jb){$I=null;$h=get_val("SHOW CREATE DATABASE ".idf_escape($j),1);if(preg_match('~ COLLATE ([^ ]+)~',$h,$A))$I=$A[1];elseif(preg_match('~ CHARACTER SET ([^ ]+)~',$h,$A))$I=$jb[$A[1]][-1];return$I;}function
engines(){$I=array();foreach(get_rows("SHOW ENGINES")as$J){if(preg_match("~YES|DEFAULT~",$J["Support"]))$I[]=$J["Engine"];}return$I;}function
logged_user(){return
get_val("SELECT USER()");}function
tables_list(){return
get_key_vals("SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME");}function
count_tables($i){$I=array();foreach($i
as$j)$I[$j]=count(get_vals("SHOW TABLES IN ".idf_escape($j)));return$I;}function
table_status($B="",$Sc=false){$I=array();foreach(get_rows($Sc?"SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ".($B!=""?"AND TABLE_NAME = ".q($B):"ORDER BY Name"):"SHOW TABLE STATUS".($B!=""?" LIKE ".q(addcslashes($B,"%_\\")):""))as$J){if($J["Engine"]=="InnoDB")$J["Comment"]=preg_replace('~(?:(.+); )?InnoDB free: .*~','\1',$J["Comment"]);if(!isset($J["Engine"]))$J["Comment"]="";if($B!=""){$J["Name"]=$B;return$J;}$I[$J["Name"]]=$J;}return$I;}function
is_view($R){return$R["Engine"]===null;}function
fk_support($R){return
preg_match('~InnoDB|IBMDB2I~i',$R["Engine"])||(preg_match('~NDB~i',$R["Engine"])&&min_version(5.6));}function
fields($Q){global$f;$Ce=preg_match('~MariaDB~',$f->server_info);$I=array();foreach(get_rows("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ".q($Q)." ORDER BY ORDINAL_POSITION")as$J){$n=$J["COLUMN_NAME"];$U=$J["COLUMN_TYPE"];$pd=$J["GENERATION_EXPRESSION"];$Pc=$J["EXTRA"];preg_match('~^(VIRTUAL|PERSISTENT|STORED)~',$Pc,$od);preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~',$U,$A);$k=$J["COLUMN_DEFAULT"];$de=preg_match('~text~',$A[1]);if(!$Ce&&$de)$k=preg_replace("~^(_\w+)?('.*')$~",'\2',stripslashes($k));if($Ce||$de){$k=preg_replace_callback("~^'(.*)'$~",function($A){return
stripslashes(str_replace("''","'",$A[1]));},$k);}$I[$n]=array("field"=>$n,"full_type"=>$U,"type"=>$A[1],"length"=>$A[2],"unsigned"=>ltrim($A[3].$A[4]),"default"=>($od?($Ce?$pd:stripslashes($pd)):($k!=""||preg_match("~char|set~",$A[1])?$k:null)),"null"=>($J["IS_NULLABLE"]=="YES"),"auto_increment"=>($Pc=="auto_increment"),"on_update"=>(preg_match('~\bon update (\w+)~i',$Pc,$A)?$A[1]:""),"collation"=>$J["COLLATION_NAME"],"privileges"=>array_flip(explode(",","$J[PRIVILEGES],where,order")),"comment"=>$J["COLUMN_COMMENT"],"primary"=>($J["COLUMN_KEY"]=="PRI"),"generated"=>($od[1]=="PERSISTENT"?"STORED":$od[1]),);}return$I;}function
indexes($Q,$g=null){$I=array();foreach(get_rows("SHOW INDEX FROM ".table($Q),$g)as$J){$B=$J["Key_name"];$I[$B]["type"]=($B=="PRIMARY"?"PRIMARY":($J["Index_type"]=="FULLTEXT"?"FULLTEXT":($J["Non_unique"]?($J["Index_type"]=="SPATIAL"?"SPATIAL":"INDEX"):"UNIQUE")));$I[$B]["columns"][]=$J["Column_name"];$I[$B]["lengths"][]=($J["Index_type"]=="SPATIAL"?null:$J["Sub_part"]);$I[$B]["descs"][]=null;}return$I;}function
foreign_keys($Q){global$l;static$dg='(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';$I=array();$Db=get_val("SHOW CREATE TABLE ".table($Q),1);if($Db){preg_match_all("~CONSTRAINT ($dg) FOREIGN KEY ?\\(((?:$dg,? ?)+)\\) REFERENCES ($dg)(?:\\.($dg))? \\(((?:$dg,? ?)+)\\)(?: ON DELETE ($l->onActions))?(?: ON UPDATE ($l->onActions))?~",$Db,$Fe,PREG_SET_ORDER);foreach($Fe
as$A){preg_match_all("~$dg~",$A[2],$Bh);preg_match_all("~$dg~",$A[5],$ei);$I[idf_unescape($A[1])]=array("db"=>idf_unescape($A[4]!=""?$A[3]:$A[4]),"table"=>idf_unescape($A[4]!=""?$A[4]:$A[3]),"source"=>array_map('Adminer\idf_unescape',$Bh[0]),"target"=>array_map('Adminer\idf_unescape',$ei[0]),"on_delete"=>($A[6]?:"RESTRICT"),"on_update"=>($A[7]?:"RESTRICT"),);}}return$I;}function
view($B){return
array("select"=>preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU','',get_val("SHOW CREATE VIEW ".table($B),1)));}function
collations(){$I=array();foreach(get_rows("SHOW COLLATION")as$J){if($J["Default"])$I[$J["Charset"]][-1]=$J["Collation"];else$I[$J["Charset"]][]=$J["Collation"];}ksort($I);foreach($I
as$y=>$X)asort($I[$y]);return$I;}function
information_schema($j){return($j=="information_schema")||(min_version(5.5)&&$j=="performance_schema");}function
error(){global$f;return
h(preg_replace('~^You have an error.*syntax to use~U',"Syntax error",$f->error));}function
create_database($j,$ib){return
queries("CREATE DATABASE ".idf_escape($j).($ib?" COLLATE ".q($ib):""));}function
drop_databases($i){$I=apply_queries("DROP DATABASE",$i,'Adminer\idf_escape');restart_session();set_session("dbs",null);return$I;}function
rename_database($B,$ib){$I=false;if(create_database($B,$ib)){$S=array();$hj=array();foreach(tables_list()as$Q=>$U){if($U=='VIEW')$hj[]=$Q;else$S[]=$Q;}$I=(!$S&&!$hj)||move_tables($S,$hj,$B);drop_databases($I?array(DB):array());}return$I;}function
auto_increment(){$Ea=" PRIMARY KEY";if($_GET["create"]!=""&&$_POST["auto_increment_col"]){foreach(indexes($_GET["create"])as$w){if(in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"],$w["columns"],true)){$Ea="";break;}if($w["type"]=="PRIMARY")$Ea=" UNIQUE";}}return" AUTO_INCREMENT$Ea";}function
alter_table($Q,$B,$o,$fd,$pb,$vc,$ib,$Da,$Zf){global$f;$c=array();foreach($o
as$n){if($n[1]){$k=$n[1][3];if(preg_match('~ GENERATED~',$k)){$n[1][3]=(preg_match('~MariaDB~',$f->server_info)?"":$n[1][2]);$n[1][2]=$k;}$c[]=($Q!=""?($n[0]!=""?"CHANGE ".idf_escape($n[0]):"ADD"):" ")." ".implode($n[1]).($Q!=""?$n[2]:"");}else$c[]="DROP ".idf_escape($n[0]);}$c=array_merge($c,$fd);$O=($pb!==null?" COMMENT=".q($pb):"").($vc?" ENGINE=".q($vc):"").($ib?" COLLATE ".q($ib):"").($Da!=""?" AUTO_INCREMENT=$Da":"");if($Q=="")return
queries("CREATE TABLE ".table($B)." (\n".implode(",\n",$c)."\n)$O$Zf");if($Q!=$B)$c[]="RENAME TO ".table($B);if($O)$c[]=ltrim($O);return($c||$Zf?queries("ALTER TABLE ".table($Q)."\n".implode(",\n",$c).$Zf):true);}function
alter_indexes($Q,$c){foreach($c
as$y=>$X)$c[$y]=($X[2]=="DROP"?"\nDROP INDEX ".idf_escape($X[1]):"\nADD $X[0] ".($X[0]=="PRIMARY"?"KEY ":"").($X[1]!=""?idf_escape($X[1])." ":"")."(".implode(", ",$X[2]).")");return
queries("ALTER TABLE ".table($Q).implode(",",$c));}function
truncate_tables($S){return
apply_queries("TRUNCATE TABLE",$S);}function
drop_views($hj){return
queries("DROP VIEW ".implode(", ",array_map('Adminer\table',$hj)));}function
drop_tables($S){return
queries("DROP TABLE ".implode(", ",array_map('Adminer\table',$S)));}function
move_tables($S,$hj,$ei){global$f;$Lg=array();foreach($S
as$Q)$Lg[]=table($Q)." TO ".idf_escape($ei).".".table($Q);if(!$Lg||queries("RENAME TABLE ".implode(", ",$Lg))){$Ub=array();foreach($hj
as$Q)$Ub[table($Q)]=view($Q);$f->select_db($ei);$j=idf_escape(DB);foreach($Ub
as$B=>$gj){if(!queries("CREATE VIEW $B AS ".str_replace(" $j."," ",$gj["select"]))||!queries("DROP VIEW $j.$B"))return
false;}return
true;}return
false;}function
copy_tables($S,$hj,$ei){queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");foreach($S
as$Q){$B=($ei==DB?table("copy_$Q"):idf_escape($ei).".".table($Q));if(($_POST["overwrite"]&&!queries("\nDROP TABLE IF EXISTS $B"))||!queries("CREATE TABLE $B LIKE ".table($Q))||!queries("INSERT INTO $B SELECT * FROM ".table($Q)))return
false;foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")))as$J){$Ci=$J["Trigger"];if(!queries("CREATE TRIGGER ".($ei==DB?idf_escape("copy_$Ci"):idf_escape($ei).".".idf_escape($Ci))." $J[Timing] $J[Event] ON $B FOR EACH ROW\n$J[Statement];"))return
false;}}foreach($hj
as$Q){$B=($ei==DB?table("copy_$Q"):idf_escape($ei).".".table($Q));$gj=view($Q);if(($_POST["overwrite"]&&!queries("DROP VIEW IF EXISTS $B"))||!queries("CREATE VIEW $B AS $gj[select]"))return
false;}return
true;}function
trigger($B){if($B=="")return
array();$K=get_rows("SHOW TRIGGERS WHERE `Trigger` = ".q($B));return
reset($K);}function
triggers($Q){$I=array();foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")))as$J)$I[$J["Trigger"]]=array($J["Timing"],$J["Event"]);return$I;}function
trigger_options(){return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("FOR EACH ROW"),);}function
routine($B,$U){global$l;$wa=array("bool","boolean","integer","double precision","real","dec","numeric","fixed","national char","national varchar");$Ch="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$Hi="((".implode("|",array_merge(array_keys($l->types()),$wa)).")\\b(?:\\s*\\(((?:[^'\")]|$l->enumLength)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";$dg="$Ch*(".($U=="FUNCTION"?"":$l->inout).")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$Hi";$h=get_val("SHOW CREATE $U ".idf_escape($B),2);preg_match("~\\(((?:$dg\\s*,?)*)\\)\\s*".($U=="FUNCTION"?"RETURNS\\s+$Hi\\s+":"")."(.*)~is",$h,$A);$o=array();preg_match_all("~$dg\\s*,?~is",$A[1],$Fe,PREG_SET_ORDER);foreach($Fe
as$Tf)$o[]=array("field"=>str_replace("``","`",$Tf[2]).$Tf[3],"type"=>strtolower($Tf[5]),"length"=>preg_replace_callback("~$l->enumLength~s",'Adminer\normalize_enum',$Tf[6]),"unsigned"=>strtolower(preg_replace('~\s+~',' ',trim("$Tf[8] $Tf[7]"))),"null"=>1,"full_type"=>$Tf[4],"inout"=>strtoupper($Tf[1]),"collation"=>strtolower($Tf[9]),);return
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
create_sql($Q,$Da,$Oh){$I=get_val("SHOW CREATE TABLE ".table($Q),1);if(!$Da)$I=preg_replace('~ AUTO_INCREMENT=\d+~','',$I);return$I;}function
truncate_sql($Q){return"TRUNCATE ".table($Q);}function
use_sql($Mb){return"USE ".idf_escape($Mb);}function
trigger_sql($Q){$I="";foreach(get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q,"%_\\")),null,"-- ")as$J)$I.="\nCREATE TRIGGER ".idf_escape($J["Trigger"])." $J[Timing] $J[Event] ON ".table($J["Table"])." FOR EACH ROW\n$J[Statement];;\n";return$I;}function
show_variables(){return
get_key_vals("SHOW VARIABLES");}function
process_list(){return
get_rows("SHOW FULL PROCESSLIST");}function
show_status(){return
get_key_vals("SHOW STATUS");}function
convert_field($n){if(preg_match("~binary~",$n["type"]))return"HEX(".idf_escape($n["field"]).")";if($n["type"]=="bit")return"BIN(".idf_escape($n["field"])." + 0)";if(preg_match("~geometry|point|linestring|polygon~",$n["type"]))return(min_version(8)?"ST_":"")."AsWKT(".idf_escape($n["field"]).")";}function
unconvert_field($n,$I){if(preg_match("~binary~",$n["type"]))$I="UNHEX($I)";if($n["type"]=="bit")$I="CONVERT(b$I, UNSIGNED)";if(preg_match("~geometry|point|linestring|polygon~",$n["type"])){$ng=(min_version(8)?"ST_":"");$I=$ng."GeomFromText($I, $ng"."SRID($n[field]))";}return$I;}function
support($Tc){return!preg_match("~scheme|sequence|type|view_trigger|materializedview".(min_version(8)?"":"|descidx".(min_version(5.1)?"":"|event|partitioning")).(min_version('8.0.16','10.2.1')?"":"|check")."~",$Tc);}function
kill_process($X){return
queries("KILL ".number($X));}function
connection_id(){return"SELECT CONNECTION_ID()";}function
max_connections(){return
get_val("SELECT @@max_connections");}}define('Adminer\JUSH',Driver::$he);define('Adminer\SERVER',$_GET[DRIVER]);define('Adminer\DB',$_GET["db"]);define('Adminer\ME',preg_replace('~\?.*~','',relative_uri()).'?'.(sid()?SID.'&':'').(SERVER!==null?DRIVER."=".urlencode(SERVER).'&':'').(isset($_GET["username"])?"username=".urlencode($_GET["username"]).'&':'').(DB!=""?'db='.urlencode(DB).'&'.(isset($_GET["ns"])?"ns=".urlencode($_GET["ns"])."&":""):''));if(!ob_get_level())ob_start(null,4096);function
page_header($oi,$m="",$Na=array(),$pi=""){global$ca,$ia,$b,$ec;page_headers();if(is_ajax()&&$m){page_messages($m);exit;}$qi=$oi.($pi!=""?": $pi":"");$ri=strip_tags($qi.(SERVER!=""&&SERVER!="localhost"?h(" - ".SERVER):"")." - ".$b->name());echo'<!DOCTYPE html>
<html lang="en" dir="ltr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width">
<title>',$ri,'</title>
<link rel="stylesheet" type="text/css" href="',h(preg_replace("~\\?.*~","",ME)."?file=default.css&version=5.0.4"),'">
',script_src(preg_replace("~\\?.*~","",ME)."?file=functions.js&version=5.0.4");if($b->head()){echo'<link rel="shortcut icon" type="image/x-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=5.0.4"),'">
<link rel="apple-touch-icon" href="',h(preg_replace("~\\?.*~","",ME)."?file=favicon.ico&version=5.0.4"),'">
';foreach($b->css()as$Hb){echo'<link rel="stylesheet" type="text/css" href="',h($Hb),'">
';}}echo'
<body class="ltr nojs">
';$p=get_temp_dir()."/adminer.version";if(!$_COOKIE["adminer_version"]&&function_exists('openssl_verify')&&file_exists($p)&&filemtime($p)+86400>time()){$fj=unserialize(file_get_contents($p));$wg="-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";if(openssl_verify($fj["version"],base64_decode($fj["signature"]),$wg)==1)$_COOKIE["adminer_version"]=$fj["version"];}echo'<script',nonce(),'>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick',(isset($_COOKIE["adminer_version"])?"":", onload: partial(verifyVersion, '$ia', '".js_escape(ME)."', '".get_token()."')");?>});
document.body.className = document.body.className.replace(/ nojs/, ' js');
var offlineMessage = '<?php echo
js_escape('You are offline.'),'\';
var thousandsSeparator = \'',js_escape(','),'\';
</script>

<div id="help" class="jush-',JUSH,' jsonly hidden"></div>
',script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"),'
<div id="content">
';if($Na!==null){$_=substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1);echo'<p id="breadcrumb"><a href="'.h($_?:".").'">'.$ec[DRIVER].'</a> Â» ';$_=substr(preg_replace('~\b(db|ns)=[^&]*&~','',ME),0,-1);$M=$b->serverName(SERVER);$M=($M!=""?$M:'Server');if($Na===false)echo"$M\n";else{echo"<a href='".h($_)."' accesskey='1' title='Alt+Shift+1'>$M</a> Â» ";if($_GET["ns"]!=""||(DB!=""&&is_array($Na)))echo'<a href="'.h($_."&db=".urlencode(DB).(support("scheme")?"&ns=":"")).'">'.h(DB).'</a> Â» ';if(is_array($Na)){if($_GET["ns"]!="")echo'<a href="'.h(substr(ME,0,-1)).'">'.h($_GET["ns"]).'</a> Â» ';foreach($Na
as$y=>$X){$Wb=(is_array($X)?$X[1]:h($X));if($Wb!="")echo"<a href='".h(ME."$y=").urlencode(is_array($X)?$X[0]:$X)."'>$Wb</a> Â» ";}}echo"$oi\n";}}echo"<h2>$qi</h2>\n","<div id='ajaxstatus' class='jsonly hidden'></div>\n";restart_session();page_messages($m);$i=&get_session("dbs");if(DB!=""&&$i&&!in_array(DB,$i,true))$i=null;stop_session();define('Adminer\PAGE_HEADER',1);}function
page_headers(){global$b;header("Content-Type: text/html; charset=utf-8");header("Cache-Control: no-cache");header("X-Frame-Options: deny");header("X-XSS-Protection: 0");header("X-Content-Type-Options: nosniff");header("Referrer-Policy: origin-when-cross-origin");foreach($b->csp()as$Gb){$Bd=array();foreach($Gb
as$y=>$X)$Bd[]="$y $X";header("Content-Security-Policy: ".implode("; ",$Bd));}$b->headers();}function
csp(){return
array(array("script-src"=>"'self' 'unsafe-inline' 'nonce-".get_nonce()."' 'strict-dynamic'","connect-src"=>"'self'","frame-src"=>"https://www.adminer.org","object-src"=>"'none'","base-uri"=>"'none'","form-action"=>"'self'",),);}function
get_nonce(){static$ff;if(!$ff)$ff=base64_encode(rand_string());return$ff;}function
page_messages($m){$Si=preg_replace('~^[^?]*~','',$_SERVER["REQUEST_URI"]);$Se=$_SESSION["messages"][$Si];if($Se){echo"<div class='message'>".implode("</div>\n<div class='message'>",$Se)."</div>".script("messagesPrint();");unset($_SESSION["messages"][$Si]);}if($m)echo"<div class='error'>$m</div>\n";}function
page_footer($Ue=""){global$b,$T;echo'</div>

<div id="menu">
';$b->navigation($Ue);echo'</div>

';if($Ue!="auth"){echo'<form action="" method="post">
<p class="logout">
<span>',h($_GET["username"])."\n",'</span>
<input type="submit" name="logout" value="Logout" id="logout">
<input type="hidden" name="token" value="',$T,'">
</p>
</form>
';}echo
script("setupSubmitHighlight(document);");}function
int32($Xe){while($Xe>=2147483648)$Xe-=4294967296;while($Xe<=-2147483649)$Xe+=4294967296;return(int)$Xe;}function
long2str($W,$jj){$Zg='';foreach($W
as$X)$Zg.=pack('V',$X);if($jj)return
substr($Zg,0,end($W));return$Zg;}function
str2long($Zg,$jj){$W=array_values(unpack('V*',str_pad($Zg,4*ceil(strlen($Zg)/4),"\0")));if($jj)$W[]=strlen($Zg);return$W;}function
xxtea_mx($vj,$uj,$Rh,$ie){return
int32((($vj>>5&0x7FFFFFF)^$uj<<2)+(($uj>>3&0x1FFFFFFF)^$vj<<4))^int32(($Rh^$uj)+($ie^$vj));}function
encrypt_string($Mh,$y){if($Mh=="")return"";$y=array_values(unpack("V*",pack("H*",md5($y))));$W=str2long($Mh,true);$Xe=count($W)-1;$vj=$W[$Xe];$uj=$W[0];$xg=floor(6+52/($Xe+1));$Rh=0;while($xg-->0){$Rh=int32($Rh+0x9E3779B9);$mc=$Rh>>2&3;for($Rf=0;$Rf<$Xe;$Rf++){$uj=$W[$Rf+1];$We=xxtea_mx($vj,$uj,$Rh,$y[$Rf&3^$mc]);$vj=int32($W[$Rf]+$We);$W[$Rf]=$vj;}$uj=$W[0];$We=xxtea_mx($vj,$uj,$Rh,$y[$Rf&3^$mc]);$vj=int32($W[$Xe]+$We);$W[$Xe]=$vj;}return
long2str($W,false);}function
decrypt_string($Mh,$y){if($Mh=="")return"";if(!$y)return
false;$y=array_values(unpack("V*",pack("H*",md5($y))));$W=str2long($Mh,false);$Xe=count($W)-1;$vj=$W[$Xe];$uj=$W[0];$xg=floor(6+52/($Xe+1));$Rh=int32($xg*0x9E3779B9);while($Rh){$mc=$Rh>>2&3;for($Rf=$Xe;$Rf>0;$Rf--){$vj=$W[$Rf-1];$We=xxtea_mx($vj,$uj,$Rh,$y[$Rf&3^$mc]);$uj=int32($W[$Rf]-$We);$W[$Rf]=$uj;}$vj=$W[$Xe];$We=xxtea_mx($vj,$uj,$Rh,$y[$Rf&3^$mc]);$uj=int32($W[0]-$We);$W[0]=$uj;$Rh=int32($Rh-0x9E3779B9);}return
long2str($W,true);}$f='';$Ad=$_SESSION["token"];if(!$Ad)$_SESSION["token"]=rand(1,1e6);$T=get_token();$fg=array();if($_COOKIE["adminer_permanent"]){foreach(explode(" ",$_COOKIE["adminer_permanent"])as$X){list($y)=explode(":",$X);$fg[$y]=$X;}}function
add_invalid_login(){global$b;$r=file_open_lock(get_temp_dir()."/adminer.invalid");if(!$r)return;$Zd=unserialize(stream_get_contents($r));$li=time();if($Zd){foreach($Zd
as$ae=>$X){if($X[0]<$li)unset($Zd[$ae]);}}$Yd=&$Zd[$b->bruteForceKey()];if(!$Yd)$Yd=array($li+30*60,0);$Yd[1]++;file_write_unlock($r,serialize($Zd));}function
check_invalid_login(){global$b;$Zd=unserialize(@file_get_contents(get_temp_dir()."/adminer.invalid"));$Yd=($Zd?$Zd[$b->bruteForceKey()]:array());$ef=($Yd[1]>29?$Yd[0]-time():0);if($ef>0)auth_error(lang(array('Too many unsuccessful logins, try again in %d minute.','Too many unsuccessful logins, try again in %d minutes.'),ceil($ef/60)));}$Ba=$_POST["auth"];if($Ba){session_regenerate_id();$ej=$Ba["driver"];$M=$Ba["server"];$V=$Ba["username"];$E=(string)$Ba["password"];$j=$Ba["db"];set_password($ej,$M,$V,$E);$_SESSION["db"][$ej][$M][$V][$j]=true;if($Ba["permanent"]){$y=base64_encode($ej)."-".base64_encode($M)."-".base64_encode($V)."-".base64_encode($j);$rg=$b->permanentLogin(true);$fg[$y]="$y:".base64_encode($rg?encrypt_string($E,$rg):"");cookie("adminer_permanent",implode(" ",$fg));}if(count($_POST)==1||DRIVER!=$ej||SERVER!=$M||$_GET["username"]!==$V||DB!=$j)redirect(auth_url($ej,$M,$V,$j));}elseif($_POST["logout"]&&(!$Ad||verify_token())){foreach(array("pwds","db","dbs","queries")as$y)set_session($y,null);unset_permanent();redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~','',ME),0,-1),'Logout successful.'.' '.'Thanks for using Adminer, consider <a href="https://www.adminer.org/en/donation/">donating</a>.');}elseif($fg&&!$_SESSION["pwds"]){session_regenerate_id();$rg=$b->permanentLogin();foreach($fg
as$y=>$X){list(,$cb)=explode(":",$X);list($ej,$M,$V,$j)=array_map('base64_decode',explode("-",$y));set_password($ej,$M,$V,decrypt_string(base64_decode($cb),$rg));$_SESSION["db"][$ej][$M][$V][$j]=true;}}function
unset_permanent(){global$fg;foreach($fg
as$y=>$X){list($ej,$M,$V,$j)=array_map('base64_decode',explode("-",$y));if($ej==DRIVER&&$M==SERVER&&$V==$_GET["username"]&&$j==DB)unset($fg[$y]);}cookie("adminer_permanent",implode(" ",$fg));}function
auth_error($m){global$b,$Ad;$rh=session_name();if(isset($_GET["username"])){header("HTTP/1.1 403 Forbidden");if(($_COOKIE[$rh]||$_GET[$rh])&&!$Ad)$m='Session expired, please login again.';else{restart_session();add_invalid_login();$E=get_password();if($E!==null){if($E===false)$m.=($m?'<br>':'').sprintf('Master password expired. <a href="https://www.adminer.org/en/extension/"%s>Implement</a> %s method to make it permanent.',target_blank(),'<code>permanentLogin()</code>');set_password(DRIVER,SERVER,$_GET["username"],null);}unset_permanent();}}if(!$_COOKIE[$rh]&&$_GET[$rh]&&ini_bool("session.use_only_cookies"))$m='Session support must be enabled.';$Uf=session_get_cookie_params();cookie("adminer_key",($_COOKIE["adminer_key"]?:rand_string()),$Uf["lifetime"]);page_header('Login',$m,null);echo"<form action='' method='post'>\n","<div>";if(hidden_fields($_POST,array("auth")))echo"<p class='message'>".'The action will be performed after successful login with the same credentials.'."\n";echo"</div>\n";$b->loginForm();echo"</form>\n";page_footer("auth");exit;}if(isset($_GET["username"])&&!class_exists('Adminer\Db')){unset($_SESSION["pwds"][DRIVER]);unset_permanent();page_header('No extension',sprintf('None of the supported PHP extensions (%s) are available.',implode(", ",Driver::$lg)),false);page_footer("auth");exit;}stop_session(true);if(isset($_GET["username"])&&is_string(get_password())){list($Fd,$hg)=explode(":",SERVER,2);if(preg_match('~^\s*([-+]?\d+)~',$hg,$A)&&($A[1]<1024||$A[1]>65535))auth_error('Connecting to privileged ports is not allowed.');check_invalid_login();$f=connect($b->credentials());if(is_object($f)){$l=new
Driver($f);if($b->operators===null)$b->operators=$l->operators;}}$Ae=null;if(!is_object($f)||($Ae=$b->login($_GET["username"],get_password()))!==true){$m=(is_string($f)?nl_br(h($f)):(is_string($Ae)?$Ae:'Invalid credentials.'));auth_error($m.(preg_match('~^ | $~',get_password())?'<br>'.'There is a space in the input password which might be the cause.':''));}if($_POST["logout"]&&$Ad&&!verify_token()){page_header('Logout','Invalid CSRF token. Send the form again.');page_footer("db");exit;}if($Ba&&$_POST["token"])$_POST["token"]=$T;$m='';if($_POST){if(!verify_token()){$Td="max_input_vars";$Le=ini_get($Td);if(extension_loaded("suhosin")){foreach(array("suhosin.request.max_vars","suhosin.post.max_vars")as$y){$X=ini_get($y);if($X&&(!$Le||$X<$Le)){$Td=$y;$Le=$X;}}}$m=(!$_POST["token"]&&$Le?sprintf('Maximum number of allowed fields exceeded. Please increase %s.',"'$Td'"):'Invalid CSRF token. Send the form again.'.' '.'If you did not send this request from Adminer then close this page.');}}elseif($_SERVER["REQUEST_METHOD"]=="POST"){$m=sprintf('Too big POST data. Reduce the data or increase the %s configuration directive.',"'post_max_size'");if(isset($_GET["sql"]))$m.=' '.'You can upload a big SQL file via FTP and import it from server.';}function
select($H,$g=null,$Gf=array(),$z=0){$ze=array();$x=array();$e=array();$La=array();$Ii=array();$I=array();for($t=0;(!$z||$t<$z)&&($J=$H->fetch_row());$t++){if(!$t){echo"<div class='scrollable'>\n","<table class='nowrap odds'>\n","<thead><tr>";for($ge=0;$ge<count($J);$ge++){$n=$H->fetch_field();$B=$n->name;$Ff=$n->orgtable;$Ef=$n->orgname;$I[$n->table]=$Ff;if($Gf&&JUSH=="sql")$ze[$ge]=($B=="table"?"table=":($B=="possible_keys"?"indexes=":null));elseif($Ff!=""){if(!isset($x[$Ff])){$x[$Ff]=array();foreach(indexes($Ff,$g)as$w){if($w["type"]=="PRIMARY"){$x[$Ff]=array_flip($w["columns"]);break;}}$e[$Ff]=$x[$Ff];}if(isset($e[$Ff][$Ef])){unset($e[$Ff][$Ef]);$x[$Ff][$Ef]=$ge;$ze[$ge]=$Ff;}}if($n->charsetnr==63)$La[$ge]=true;$Ii[$ge]=$n->type;echo"<th".($Ff!=""||$n->name!=$Ef?" title='".h(($Ff!=""?"$Ff.":"").$Ef)."'":"").">".h($B).($Gf?doc_link(array('sql'=>"explain-output.html#explain_".strtolower($B),'mariadb'=>"explain/#the-columns-in-explain-select",)):"");}echo"</thead>\n";}echo"<tr>";foreach($J
as$y=>$X){$_="";if(isset($ze[$y])&&!$e[$ze[$y]]){if($Gf&&JUSH=="sql"){$Q=$J[array_search("table=",$ze)];$_=ME.$ze[$y].urlencode($Gf[$Q]!=""?$Gf[$Q]:$Q);}else{$_=ME."edit=".urlencode($ze[$y]);foreach($x[$ze[$y]]as$gb=>$ge)$_.="&where".urlencode("[".bracket_escape($gb)."]")."=".urlencode($J[$ge]);}}elseif(is_url($X))$_=$X;if($X===null)$X="<i>NULL</i>";elseif($La[$y]&&!is_utf8($X))$X="<i>".lang(array('%d byte','%d bytes'),strlen($X))."</i>";else{$X=h($X);if($Ii[$y]==254)$X="<code>$X</code>";}if($_)$X="<a href='".h($_)."'".(is_url($_)?target_blank():'').">$X</a>";echo"<td>$X";}}echo($t?"</table>\n</div>":"<p class='message'>".'No rows.')."\n";return$I;}function
referencable_primary($jh){$I=array();foreach(table_status('',true)as$Wh=>$Q){if($Wh!=$jh&&fk_support($Q)){foreach(fields($Wh)as$n){if($n["primary"]){if($I[$Wh]){unset($I[$Wh]);break;}$I[$Wh]=$n;}}}}return$I;}function
adminer_settings(){parse_str($_COOKIE["adminer_settings"],$th);return$th;}function
adminer_setting($y){$th=adminer_settings();return$th[$y];}function
set_adminer_settings($th){return
cookie("adminer_settings",http_build_query($th+adminer_settings()));}function
textarea($B,$Y,$K=10,$lb=80){echo"<textarea name='".h($B)."' rows='$K' cols='$lb' class='sqlarea jush-".JUSH."' spellcheck='false' wrap='off'>";if(is_array($Y)){foreach($Y
as$X)echo
h($X[0])."\n\n\n";}else
echo
h($Y);echo"</textarea>";}function
select_input($Aa,$Af,$Y="",$uf="",$gg=""){$di=($Af?"select":"input");return"<$di$Aa".($Af?"><option value=''>$gg".optionlist($Af,$Y,true)."</select>":" size='10' value='".h($Y)."' placeholder='$gg'>").($uf?script("qsl('$di').onchange = $uf;",""):"");}function
json_row($y,$X=null){static$Yc=true;if($Yc)echo"{";if($y!=""){echo($Yc?"":",")."\n\t\"".addcslashes($y,"\r\n\t\"\\/").'": '.($X!==null?'"'.addcslashes($X,"\r\n\"\\/").'"':'null');$Yc=false;}else{echo"\n}\n";$Yc=true;}}function
edit_type($y,$n,$jb,$hd=array(),$Qc=array()){global$l;$U=$n["type"];echo'<td><select name="',h($y),'[type]" class="type" aria-labelledby="label-type">';if($U&&!array_key_exists($U,$l->types())&&!isset($hd[$U])&&!in_array($U,$Qc))$Qc[]=$U;$Nh=$l->structuredTypes();if($hd)$Nh['Foreign keys']=$hd;echo
optionlist(array_merge($Qc,$Nh),$U),'</select><td><input
	name="',h($y),'[length]"
	value="',h($n["length"]),'"
	size="3"
	',(!$n["length"]&&preg_match('~var(char|binary)$~',$U)?" class='required'":"");echo'	aria-labelledby="label-length"><td class="options">',($jb?"<input list='collations' name='".h($y)."[collation]'".(preg_match('~(char|text|enum|set)$~',$U)?"":" class='hidden'")." value='".h($n["collation"])."' placeholder='(".'collation'.")'>":''),($l->unsigned?"<select name='".h($y)."[unsigned]'".(!$U||preg_match(number_type(),$U)?"":" class='hidden'").'><option>'.optionlist($l->unsigned,$n["unsigned"]).'</select>':''),(isset($n['on_update'])?"<select name='".h($y)."[on_update]'".(preg_match('~timestamp|datetime~',$U)?"":" class='hidden'").'>'.optionlist(array(""=>"(".'ON UPDATE'.")","CURRENT_TIMESTAMP"),(preg_match('~^CURRENT_TIMESTAMP~i',$n["on_update"])?"CURRENT_TIMESTAMP":$n["on_update"])).'</select>':''),($hd?"<select name='".h($y)."[on_delete]'".(preg_match("~`~",$U)?"":" class='hidden'")."><option value=''>(".'ON DELETE'.")".optionlist(explode("|",$l->onActions),$n["on_delete"])."</select> ":" ");}function
get_partitions_info($Q){global$f;$ld="FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = ".q(DB)." AND TABLE_NAME = ".q($Q);$H=$f->query("SELECT PARTITION_METHOD, PARTITION_EXPRESSION, PARTITION_ORDINAL_POSITION $ld ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");$I=array();list($I["partition_by"],$I["partition"],$I["partitions"])=$H->fetch_row();$ag=get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $ld AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");$I["partition_names"]=array_keys($ag);$I["partition_values"]=array_values($ag);return$I;}function
process_length($we){global$l;$zc=$l->enumLength;return(preg_match("~^\\s*\\(?\\s*$zc(?:\\s*,\\s*$zc)*+\\s*\\)?\\s*\$~",$we)&&preg_match_all("~$zc~",$we,$Fe)?"(".implode(",",$Fe[0]).")":preg_replace('~^[0-9].*~','(\0)',preg_replace('~[^-0-9,+()[\]]~','',$we)));}function
process_type($n,$hb="COLLATE"){global$l;return" $n[type]".process_length($n["length"]).(preg_match(number_type(),$n["type"])&&in_array($n["unsigned"],$l->unsigned)?" $n[unsigned]":"").(preg_match('~char|text|enum|set~',$n["type"])&&$n["collation"]?" $hb ".(JUSH=="mssql"?$n["collation"]:q($n["collation"])):"");}function
process_field($n,$Gi){if($n["on_update"])$n["on_update"]=str_ireplace("current_timestamp()","CURRENT_TIMESTAMP",$n["on_update"]);return
array(idf_escape(trim($n["field"])),process_type($Gi),($n["null"]?" NULL":" NOT NULL"),default_value($n),(preg_match('~timestamp|datetime~',$n["type"])&&$n["on_update"]?" ON UPDATE $n[on_update]":""),(support("comment")&&$n["comment"]!=""?" COMMENT ".q($n["comment"]):""),($n["auto_increment"]?auto_increment():null),);}function
default_value($n){global$l;$k=$n["default"];$od=$n["generated"];return($k===null?"":(in_array($od,$l->generated)?(JUSH=="mssql"?" AS ($k)".($od=="VIRTUAL"?"":" $od")."":" GENERATED ALWAYS AS ($k) $od"):" DEFAULT ".(!preg_match('~^GENERATED ~i',$k)&&(preg_match('~char|binary|text|enum|set~',$n["type"])||preg_match('~^(?![a-z])~i',$k))?(JUSH=="sql"&&preg_match('~text~',$n["type"])?"(".q($k).")":q($k)):str_ireplace("current_timestamp()","CURRENT_TIMESTAMP",(JUSH=="sqlite"?"($k)":$k)))));}function
type_class($U){foreach(array('char'=>'text','date'=>'time|year','binary'=>'blob','enum'=>'set',)as$y=>$X){if(preg_match("~$y|$X~",$U))return" class='$y'";}}function
edit_fields($o,$jb,$U="TABLE",$hd=array()){global$l;$o=array_values($o);$Sb=(($_POST?$_POST["defaults"]:adminer_setting("defaults"))?"":" class='hidden'");$qb=(($_POST?$_POST["comments"]:adminer_setting("comments"))?"":" class='hidden'");echo'<thead><tr>
',($U=="PROCEDURE"?"<td>":""),'<th id="label-name">',($U=="TABLE"?'Column name':'Parameter name'),'<td id="label-type">Type<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>',script("qs('#enum-edit').onblur = editingLengthBlur;"),'<td id="label-length">Length
<td>','Options';if($U=="TABLE"){echo'<td id="label-null">NULL
<td><input type="radio" name="auto_increment_col" value=""><abbr id="label-ai" title="Auto Increment">AI</abbr>',doc_link(array('sql'=>"example-auto-increment.html",'mariadb'=>"auto_increment/",'sqlite'=>"autoinc.html",'pgsql'=>"datatype-numeric.html#DATATYPE-SERIAL",'mssql'=>"t-sql/statements/create-table-transact-sql-identity-property",)),'<td id="label-default"',$Sb,'>Default value
',(support("comment")?"<td id='label-comment'$qb>".'Comment':"");}echo'<td>',"<input type='image' class='icon' name='add[".(support("move_col")?0:count($o))."]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=5.0.4")."' alt='+' title='".'Add next'."'>".script("row_count = ".count($o).";"),'</thead>
<tbody>
',script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");foreach($o
as$t=>$n){$t++;$Hf=$n[($_POST?"orig":"field")];$bc=(isset($_POST["add"][$t-1])||(isset($n["field"])&&!$_POST["drop_col"][$t]))&&(support("drop_col")||$Hf=="");echo'<tr',($bc?"":" style='display: none;'"),'>
',($U=="PROCEDURE"?"<td>".html_select("fields[$t][inout]",explode("|",$l->inout),$n["inout"]):"")."<th>";if($bc){echo'<input name="fields[',$t,'][field]" value="',h($n["field"]),'" data-maxlength="64" autocapitalize="off" aria-labelledby="label-name">
';}echo'<input type="hidden" name="fields[',$t,'][orig]" value="',h($Hf),'">';edit_type("fields[$t]",$n,$jb,$hd);if($U=="TABLE"){echo'<td>',checkbox("fields[$t][null]",1,$n["null"],"","","block","label-null"),'<td><label class="block"><input type="radio" name="auto_increment_col" value="',$t,'"',($n["auto_increment"]?" checked":""),' aria-labelledby="label-ai"></label><td',$Sb,'>',($l->generated?html_select("fields[$t][generated]",array_merge(array("","DEFAULT"),$l->generated),$n["generated"])." ":checkbox("fields[$t][generated]",1,$n["generated"],"","","","label-default")),'<input name="fields[',$t,'][default]" value="',h($n["default"]),'" aria-labelledby="label-default">',(support("comment")?"<td$qb><input name='fields[$t][comment]' value='".h($n["comment"])."' data-maxlength='".(min_version(5.5)?1024:255)."' aria-labelledby='label-comment'>":"");}echo"<td>",(support("move_col")?"<input type='image' class='icon' name='add[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=5.0.4")."' alt='+' title='".'Add next'."'> "."<input type='image' class='icon' name='up[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=up.gif&version=5.0.4")."' alt='â†‘' title='".'Move up'."'> "."<input type='image' class='icon' name='down[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=down.gif&version=5.0.4")."' alt='â†“' title='".'Move down'."'> ":""),($Hf==""||support("drop_col")?"<input type='image' class='icon' name='drop_col[$t]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=5.0.4")."' alt='x' title='".'Remove'."'>":"");}}function
process_fields(&$o){$C=0;if($_POST["up"]){$qe=0;foreach($o
as$y=>$n){if(key($_POST["up"])==$y){unset($o[$y]);array_splice($o,$qe,0,array($n));break;}if(isset($n["field"]))$qe=$C;$C++;}}elseif($_POST["down"]){$jd=false;foreach($o
as$y=>$n){if(isset($n["field"])&&$jd){unset($o[key($_POST["down"])]);array_splice($o,$C,0,array($jd));break;}if(key($_POST["down"])==$y)$jd=$n;$C++;}}elseif($_POST["add"]){$o=array_values($o);array_splice($o,key($_POST["add"]),0,array(array()));}elseif(!$_POST["drop_col"])return
false;return
true;}function
normalize_enum($A){return"'".str_replace("'","''",addcslashes(stripcslashes(str_replace($A[0][0].$A[0][0],$A[0][0],substr($A[0],1,-1))),'\\'))."'";}function
grant($qd,$tg,$e,$rf){if(!$tg)return
true;if($tg==array("ALL PRIVILEGES","GRANT OPTION"))return($qd=="GRANT"?queries("$qd ALL PRIVILEGES$rf WITH GRANT OPTION"):queries("$qd ALL PRIVILEGES$rf")&&queries("$qd GRANT OPTION$rf"));return
queries("$qd ".preg_replace('~(GRANT OPTION)\([^)]*\)~','\1',implode("$e, ",$tg).$e).$rf);}function
drop_create($fc,$h,$hc,$hi,$jc,$_e,$Re,$Pe,$Qe,$of,$cf){if($_POST["drop"])query_redirect($fc,$_e,$Re);elseif($of=="")query_redirect($h,$_e,$Qe);elseif($of!=$cf){$Eb=queries($h);queries_redirect($_e,$Pe,$Eb&&queries($fc));if($Eb)queries($hc);}else
queries_redirect($_e,$Pe,queries($hi)&&queries($jc)&&queries($fc)&&queries($h));}function
create_trigger($rf,$J){$ni=" $J[Timing] $J[Event]".(preg_match('~ OF~',$J["Event"])?" $J[Of]":"");return"CREATE TRIGGER ".idf_escape($J["Trigger"]).(JUSH=="mssql"?$rf.$ni:$ni.$rf).rtrim(" $J[Type]\n$J[Statement]",";").";";}function
create_routine($Vg,$J){global$l;$N=array();$o=(array)$J["fields"];ksort($o);foreach($o
as$n){if($n["field"]!="")$N[]=(preg_match("~^($l->inout)\$~",$n["inout"])?"$n[inout] ":"").idf_escape($n["field"]).process_type($n,"CHARACTER SET");}$Tb=rtrim($J["definition"],";");return"CREATE $Vg ".idf_escape(trim($J["name"]))." (".implode(", ",$N).")".($Vg=="FUNCTION"?" RETURNS".process_type($J["returns"],"CHARACTER SET"):"").($J["language"]?" LANGUAGE $J[language]":"").(JUSH=="pgsql"?" AS ".q($Tb):"\n$Tb;");}function
remove_definer($G){return
preg_replace('~^([A-Z =]+) DEFINER=`'.preg_replace('~@(.*)~','`@`(%|\1)',logged_user()).'`~','\1',$G);}function
format_foreign_key($q){global$l;$j=$q["db"];$gf=$q["ns"];return" FOREIGN KEY (".implode(", ",array_map('Adminer\idf_escape',$q["source"])).") REFERENCES ".($j!=""&&$j!=$_GET["db"]?idf_escape($j).".":"").($gf!=""&&$gf!=$_GET["ns"]?idf_escape($gf).".":"").idf_escape($q["table"])." (".implode(", ",array_map('Adminer\idf_escape',$q["target"])).")".(preg_match("~^($l->onActions)\$~",$q["on_delete"])?" ON DELETE $q[on_delete]":"").(preg_match("~^($l->onActions)\$~",$q["on_update"])?" ON UPDATE $q[on_update]":"");}function
tar_file($p,$si){$I=pack("a100a8a8a8a12a12",$p,644,0,0,decoct($si->size),decoct(time()));$bb=8*32;for($t=0;$t<strlen($I);$t++)$bb+=ord($I[$t]);$I.=sprintf("%06o",$bb)."\0 ";echo$I,str_repeat("\0",512-strlen($I));$si->send();echo
str_repeat("\0",511-($si->size+511)%512);}function
ini_bytes($Td){$X=ini_get($Td);switch(strtolower(substr($X,-1))){case'g':$X=(int)$X*1024;case'm':$X=(int)$X*1024;case'k':$X=(int)$X*1024;}return$X;}function
doc_link($cg,$ii="<sup>?</sup>"){global$f;$ph=$f->server_info;$fj=preg_replace('~^(\d\.?\d).*~s','\1',$ph);$Ui=array('sql'=>"https://dev.mysql.com/doc/refman/$fj/en/",'sqlite'=>"https://www.sqlite.org/",'pgsql'=>"https://www.postgresql.org/docs/$fj/",'mssql'=>"https://learn.microsoft.com/en-us/sql/",'oracle'=>"https://www.oracle.com/pls/topic/lookup?ctx=db".preg_replace('~^.* (\d+)\.(\d+)\.\d+\.\d+\.\d+.*~s','\1\2',$ph)."&id=",);if(preg_match('~MariaDB~',$ph)){$Ui['sql']="https://mariadb.com/kb/en/";$cg['sql']=(isset($cg['mariadb'])?$cg['mariadb']:str_replace(".html","/",$cg['sql']));}return($cg[JUSH]?"<a href='".h($Ui[JUSH].$cg[JUSH].(JUSH=='mssql'?"?view=sql-server-ver$fj":""))."'".target_blank().">$ii</a>":"");}function
db_size($j){global$f;if(!$f->select_db($j))return"?";$I=0;foreach(table_status()as$R)$I+=$R["Data_length"]+$R["Index_length"];return
format_number($I);}function
set_utf8mb4($h){global$f;static$N=false;if(!$N&&preg_match('~\butf8mb4~i',$h)){$N=true;echo"SET NAMES ".charset($f).";\n\n";}}if(isset($_GET["status"]))$_GET["variables"]=$_GET["status"];if(isset($_GET["import"]))$_GET["sql"]=$_GET["import"];if(!(DB!=""?$f->select_db(DB):isset($_GET["sql"])||isset($_GET["dump"])||isset($_GET["database"])||isset($_GET["processlist"])||isset($_GET["privileges"])||isset($_GET["user"])||isset($_GET["variables"])||$_GET["script"]=="connect"||$_GET["script"]=="kill")){if(DB!=""||$_GET["refresh"]){restart_session();set_session("dbs",null);}if(DB!=""){header("HTTP/1.1 404 Not Found");page_header('Database'.": ".h(DB),'Invalid database.',true);}else{if($_POST["db"]&&!$m)queries_redirect(substr(ME,0,-1),'Databases have been dropped.',drop_databases($_POST["db"]));page_header('Select database',$m,false);echo"<p class='links'>\n";foreach(array('database'=>'Create database','privileges'=>'Privileges','processlist'=>'Process list','variables'=>'Variables','status'=>'Status',)as$y=>$X){if(support($y))echo"<a href='".h(ME)."$y='>$X</a>\n";}echo"<p>".sprintf('%s version: %s through PHP extension %s',$ec[DRIVER],"<b>".h($f->server_info)."</b>","<b>$f->extension</b>")."\n","<p>".sprintf('Logged as: %s',"<b>".h(logged_user())."</b>")."\n";$i=$b->databases();if($i){$dh=support("scheme");$jb=collations();echo"<form action='' method='post'>\n","<table class='checkable odds'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),"<thead><tr>".(support("database")?"<td>":"")."<th>".'Database'.(get_session("dbs")!==null?" - <a href='".h(ME)."refresh=1'>".'Refresh'."</a>":"")."<td>".'Collation'."<td>".'Tables'."<td>".'Size'." - <a href='".h(ME)."dbsize=1'>".'Compute'."</a>".script("qsl('a').onclick = partial(ajaxSetHtml, '".js_escape(ME)."script=connect');","")."</thead>\n";$i=($_GET["dbsize"]?count_tables($i):array_flip($i));foreach($i
as$j=>$S){$Ug=h(ME)."db=".urlencode($j);$u=h("Db-".$j);echo"<tr>".(support("database")?"<td>".checkbox("db[]",$j,in_array($j,(array)$_POST["db"]),"","","",$u):""),"<th><a href='$Ug' id='$u'>".h($j)."</a>";$ib=h(db_collation($j,$jb));echo"<td>".(support("database")?"<a href='$Ug".($dh?"&amp;ns=":"")."&amp;database=' title='".'Alter database'."'>$ib</a>":$ib),"<td align='right'><a href='$Ug&amp;schema=' id='tables-".h($j)."' title='".'Database schema'."'>".($_GET["dbsize"]?$S:"?")."</a>","<td align='right' id='size-".h($j)."'>".($_GET["dbsize"]?db_size($j):"?"),"\n";}echo"</table>\n",(support("database")?"<div class='footer'><div>\n"."<fieldset><legend>".'Selected'." <span id='selected'></span></legend><div>\n"."<input type='hidden' name='all' value=''>".script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };")."<input type='submit' name='drop' value='".'Drop'."'>".confirm()."\n"."</div></fieldset>\n"."</div></div>\n":""),"<input type='hidden' name='token' value='$T'>\n","</form>\n",script("tableCheck();");}}page_footer("db");exit;}if(support("scheme")){if(DB!=""&&$_GET["ns"]!==""){if(!isset($_GET["ns"]))redirect(preg_replace('~ns=[^&]*&~','',ME)."ns=".get_schema());if(!set_schema($_GET["ns"])){header("HTTP/1.1 404 Not Found");page_header('Schema'.": ".h($_GET["ns"]),'Invalid schema.',true);page_footer("ns");exit;}}}class
TmpFile{private$handler,$size;function
__construct(){$this->handler=tmpfile();}function
write($yb){$this->size+=strlen($yb);fwrite($this->handler,$yb);}function
send(){fseek($this->handler,0);fpassthru($this->handler);fclose($this->handler);}}if(isset($_GET["select"])&&($_POST["edit"]||$_POST["clone"])&&!$_POST["save"])$_GET["edit"]=$_GET["select"];if(isset($_GET["callf"]))$_GET["call"]=$_GET["callf"];if(isset($_GET["function"]))$_GET["procedure"]=$_GET["function"];if(isset($_GET["download"])){$a=$_GET["download"];$o=fields($a);header("Content-Type: application/octet-stream");header("Content-Disposition: attachment; filename=".friendly_url("$a-".implode("_",$_GET["where"])).".".friendly_url($_GET["field"]));$L=array(idf_escape($_GET["field"]));$H=$l->select($a,$L,array(where($_GET,$o)),$L);$J=($H?$H->fetch_row():array());echo$l->value($J[0],$o[$_GET["field"]]);exit;}elseif(isset($_GET["table"])){$a=$_GET["table"];$o=fields($a);if(!$o)$m=error();$R=table_status1($a,true);$B=$b->tableName($R);page_header(($o&&is_view($R)?$R['Engine']=='materialized view'?'Materialized view':'View':'Table').": ".($B!=""?$B:h($a)),$m);$Tg=array();foreach($o
as$y=>$n)$Tg+=$n["privileges"];$b->selectLinks($R,(isset($Tg["insert"])||!support("table")?"":null));$pb=$R["Comment"];if($pb!="")echo"<p class='nowrap'>".'Comment'.": ".h($pb)."\n";if($o)$b->tableStructurePrint($o);if(support("indexes")&&$l->supportsIndex($R)){echo"<h3 id='indexes'>".'Indexes'."</h3>\n";$x=indexes($a);if($x)$b->tableIndexesPrint($x);echo'<p class="links"><a href="'.h(ME).'indexes='.urlencode($a).'">'.'Alter indexes'."</a>\n";}if(!is_view($R)){if(fk_support($R)){echo"<h3 id='foreign-keys'>".'Foreign keys'."</h3>\n";$hd=foreign_keys($a);if($hd){echo"<table>\n","<thead><tr><th>".'Source'."<td>".'Target'."<td>".'ON DELETE'."<td>".'ON UPDATE'."<td></thead>\n";foreach($hd
as$B=>$q){echo"<tr title='".h($B)."'>","<th><i>".implode("</i>, <i>",array_map('Adminer\h',$q["source"]))."</i>","<td><a href='".h($q["db"]!=""?preg_replace('~db=[^&]*~',"db=".urlencode($q["db"]),ME):($q["ns"]!=""?preg_replace('~ns=[^&]*~',"ns=".urlencode($q["ns"]),ME):ME))."table=".urlencode($q["table"])."'>".($q["db"]!=""&&$q["db"]!=DB?"<b>".h($q["db"])."</b>.":"").($q["ns"]!=""&&$q["ns"]!=$_GET["ns"]?"<b>".h($q["ns"])."</b>.":"").h($q["table"])."</a>","(<i>".implode("</i>, <i>",array_map('Adminer\h',$q["target"]))."</i>)","<td>".h($q["on_delete"]),"<td>".h($q["on_update"]),'<td><a href="'.h(ME.'foreign='.urlencode($a).'&name='.urlencode($B)).'">'.'Alter'.'</a>',"\n";}echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'foreign='.urlencode($a).'">'.'Add foreign key'."</a>\n";}if(support("check")){echo"<h3 id='checks'>".'Checks'."</h3>\n";$Xa=$l->checkConstraints($a);if($Xa){echo"<table>\n";foreach($Xa
as$y=>$X){echo"<tr title='".h($y)."'>","<td><code class='jush-".JUSH."'>".h($X),"<td><a href='".h(ME.'check='.urlencode($a).'&name='.urlencode($y))."'>".'Alter'."</a>","\n";}echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'check='.urlencode($a).'">'.'Create check'."</a>\n";}}if(support(is_view($R)?"view_trigger":"trigger")){echo"<h3 id='triggers'>".'Triggers'."</h3>\n";$Fi=triggers($a);if($Fi){echo"<table>\n";foreach($Fi
as$y=>$X)echo"<tr valign='top'><td>".h($X[0])."<td>".h($X[1])."<th>".h($y)."<td><a href='".h(ME.'trigger='.urlencode($a).'&name='.urlencode($y))."'>".'Alter'."</a>\n";echo"</table>\n";}echo'<p class="links"><a href="'.h(ME).'trigger='.urlencode($a).'">'.'Add trigger'."</a>\n";}}elseif(isset($_GET["schema"])){page_header('Database schema',"",array(),h(DB.($_GET["ns"]?".$_GET[ns]":"")));$Yh=array();$Zh=array();$ea=($_GET["schema"]?:$_COOKIE["adminer_schema-".str_replace(".","_",DB)]);preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~',$ea,$Fe,PREG_SET_ORDER);foreach($Fe
as$t=>$A){$Yh[$A[1]]=array($A[2],$A[3]);$Zh[]="\n\t'".js_escape($A[1])."': [ $A[2], $A[3] ]";}$vi=0;$Ia=-1;$bh=array();$Gg=array();$ue=array();foreach(table_status('',true)as$Q=>$R){if(is_view($R))continue;$ig=0;$bh[$Q]["fields"]=array();foreach(fields($Q)as$B=>$n){$ig+=1.25;$n["pos"]=$ig;$bh[$Q]["fields"][$B]=$n;}$bh[$Q]["pos"]=($Yh[$Q]?:array($vi,0));foreach($b->foreignKeys($Q)as$X){if(!$X["db"]){$se=$Ia;if($Yh[$Q][1]||$Yh[$X["table"]][1])$se=min(floatval($Yh[$Q][1]),floatval($Yh[$X["table"]][1]))-1;else$Ia-=.1;while($ue[(string)$se])$se-=.0001;$bh[$Q]["references"][$X["table"]][(string)$se]=array($X["source"],$X["target"]);$Gg[$X["table"]][$Q][(string)$se]=$X["target"];$ue[(string)$se]=true;}}$vi=max($vi,$bh[$Q]["pos"][0]+2.5+$ig);}echo'<div id="schema" style="height: ',$vi,'em;">
<script',nonce(),'>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {',implode(",",$Zh)."\n",'};
var em = qs(\'#schema\').offsetHeight / ',$vi,';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'',js_escape(DB),'\');
</script>
';foreach($bh
as$B=>$Q){echo"<div class='table' style='top: ".$Q["pos"][0]."em; left: ".$Q["pos"][1]."em;'>",'<a href="'.h(ME).'table='.urlencode($B).'"><b>'.h($B)."</b></a>",script("qsl('div').onmousedown = schemaMousedown;");foreach($Q["fields"]as$n){$X='<span'.type_class($n["type"]).' title="'.h($n["full_type"].($n["null"]?" NULL":'')).'">'.h($n["field"]).'</span>';echo"<br>".($n["primary"]?"<i>$X</i>":$X);}foreach((array)$Q["references"]as$fi=>$Hg){foreach($Hg
as$se=>$Dg){$te=$se-$Yh[$B][1];$t=0;foreach($Dg[0]as$Bh)echo"\n<div class='references' title='".h($fi)."' id='refs$se-".($t++)."' style='left: $te"."em; top: ".$Q["fields"][$Bh]["pos"]."em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: ".(-$te)."em;'></div></div>";}}foreach((array)$Gg[$B]as$fi=>$Hg){foreach($Hg
as$se=>$e){$te=$se-$Yh[$B][1];$t=0;foreach($e
as$ei)echo"\n<div class='references' title='".h($fi)."' id='refd$se-".($t++)."' style='left: $te"."em; top: ".$Q["fields"][$ei]["pos"]."em; height: 1.25em; background: url(".h(preg_replace("~\\?.*~","",ME)."?file=arrow.gif) no-repeat right center;&version=5.0.4")."'>"."<div style='height: .5em; border-bottom: 1px solid Gray; width: ".(-$te)."em;'></div>"."</div>";}}echo"\n</div>\n";}foreach($bh
as$B=>$Q){foreach((array)$Q["references"]as$fi=>$Hg){foreach($Hg
as$se=>$Dg){$Te=$vi;$Je=-10;foreach($Dg[0]as$y=>$Bh){$jg=$Q["pos"][0]+$Q["fields"][$Bh]["pos"];$kg=$bh[$fi]["pos"][0]+$bh[$fi]["fields"][$Dg[1][$y]]["pos"];$Te=min($Te,$jg,$kg);$Je=max($Je,$jg,$kg);}echo"<div class='references' id='refl$se' style='left: $se"."em; top: $Te"."em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: ".($Je-$Te)."em;'></div></div>\n";}}}echo'</div>
<p class="links"><a href="',h(ME."schema=".urlencode($ea)),'" id="schema-link">Permanent link</a>
';}elseif(isset($_GET["dump"])){$a=$_GET["dump"];if($_POST&&!$m){$Ab="";foreach(array("output","format","db_style","types","routines","events","table_style","auto_increment","triggers","data_style")as$y)$Ab.="&$y=".urlencode($_POST[$y]);cookie("adminer_export",substr($Ab,1));$S=array_flip((array)$_POST["tables"])+array_flip((array)$_POST["data"]);$Mc=dump_headers((count($S)==1?key($S):DB),(DB==""||count($S)>1));$ce=preg_match('~sql~',$_POST["format"]);if($ce){echo"-- Adminer $ia ".$ec[DRIVER]." ".str_replace("\n"," ",$f->server_info)." dump\n\n";if(JUSH=="sql"){echo"SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
".($_POST["data_style"]?"SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
":"")."
";$f->query("SET time_zone = '+00:00'");$f->query("SET sql_mode = ''");}}$Oh=$_POST["db_style"];$i=array(DB);if(DB==""){$i=$_POST["databases"];if(is_string($i))$i=explode("\n",rtrim(str_replace("\r","",$i),"\n"));}foreach((array)$i
as$j){$b->dumpDatabase($j);if($f->select_db($j)){if($ce&&preg_match('~CREATE~',$Oh)&&($h=get_val("SHOW CREATE DATABASE ".idf_escape($j),1))){set_utf8mb4($h);if($Oh=="DROP+CREATE")echo"DROP DATABASE IF EXISTS ".idf_escape($j).";\n";echo"$h;\n";}if($ce){if($Oh)echo
use_sql($j).";\n\n";$Of="";if($_POST["types"]){foreach(types()as$u=>$U){$_c=type_values($u);if($_c)$Of.=($Oh!='DROP+CREATE'?"DROP TYPE IF EXISTS ".idf_escape($U).";;\n":"")."CREATE TYPE ".idf_escape($U)." AS ENUM ($_c);\n\n";else$Of.="-- Could not export type $U\n\n";}}if($_POST["routines"]){foreach(routines()as$J){$B=$J["ROUTINE_NAME"];$Vg=$J["ROUTINE_TYPE"];$h=create_routine($Vg,array("name"=>$B)+routine($J["SPECIFIC_NAME"],$Vg));set_utf8mb4($h);$Of.=($Oh!='DROP+CREATE'?"DROP $Vg IF EXISTS ".idf_escape($B).";;\n":"")."$h;\n\n";}}if($_POST["events"]){foreach(get_rows("SHOW EVENTS",null,"-- ")as$J){$h=remove_definer(get_val("SHOW CREATE EVENT ".idf_escape($J["Name"]),3));set_utf8mb4($h);$Of.=($Oh!='DROP+CREATE'?"DROP EVENT IF EXISTS ".idf_escape($J["Name"]).";;\n":"")."$h;;\n\n";}}echo($Of&&JUSH=='sql'?"DELIMITER ;;\n\n$Of"."DELIMITER ;\n\n":$Of);}if($_POST["table_style"]||$_POST["data_style"]){$hj=array();foreach(table_status('',true)as$B=>$R){$Q=(DB==""||in_array($B,(array)$_POST["tables"]));$Kb=(DB==""||in_array($B,(array)$_POST["data"]));if($Q||$Kb){if($Mc=="tar"){$si=new
TmpFile;ob_start(array($si,'write'),1e5);}$b->dumpTable($B,($Q?$_POST["table_style"]:""),(is_view($R)?2:0));if(is_view($R))$hj[]=$B;elseif($Kb){$o=fields($B);$b->dumpData($B,$_POST["data_style"],"SELECT *".convert_fields($o,$o)." FROM ".table($B));}if($ce&&$_POST["triggers"]&&$Q&&($Fi=trigger_sql($B)))echo"\nDELIMITER ;;\n$Fi\nDELIMITER ;\n";if($Mc=="tar"){ob_end_flush();tar_file((DB!=""?"":"$j/")."$B.csv",$si);}elseif($ce)echo"\n";}}if(function_exists('Adminer\foreign_keys_sql')){foreach(table_status('',true)as$B=>$R){$Q=(DB==""||in_array($B,(array)$_POST["tables"]));if($Q&&!is_view($R))echo
foreign_keys_sql($B);}}foreach($hj
as$gj)$b->dumpTable($gj,$_POST["table_style"],1);if($Mc=="tar")echo
pack("x512");}}}$b->dumpFooter();exit;}page_header('Export',$m,($_GET["export"]!=""?array("table"=>$_GET["export"]):array()),h(DB));echo'
<form action="" method="post">
<table class="layout">
';$Pb=array('','USE','DROP+CREATE','CREATE');$ai=array('','DROP+CREATE','CREATE');$Lb=array('','TRUNCATE+INSERT','INSERT');if(JUSH=="sql")$Lb[]='INSERT+UPDATE';parse_str($_COOKIE["adminer_export"],$J);if(!$J)$J=array("output"=>"text","format"=>"sql","db_style"=>(DB!=""?"":"CREATE"),"table_style"=>"DROP+CREATE","data_style"=>"INSERT");if(!isset($J["events"])){$J["routines"]=$J["events"]=($_GET["dump"]=="");$J["triggers"]=$J["table_style"];}echo"<tr><th>".'Output'."<td>".html_radios("output",$b->dumpOutput(),$J["output"])."\n","<tr><th>".'Format'."<td>".html_radios("format",$b->dumpFormat(),$J["format"])."\n",(JUSH=="sqlite"?"":"<tr><th>".'Database'."<td>".html_select('db_style',$Pb,$J["db_style"]).(support("type")?checkbox("types",1,$J["types"],'User types'):"").(support("routine")?checkbox("routines",1,$J["routines"],'Routines'):"").(support("event")?checkbox("events",1,$J["events"],'Events'):"")),"<tr><th>".'Tables'."<td>".html_select('table_style',$ai,$J["table_style"]).checkbox("auto_increment",1,$J["auto_increment"],'Auto Increment').(support("trigger")?checkbox("triggers",1,$J["triggers"],'Triggers'):""),"<tr><th>".'Data'."<td>".html_select('data_style',$Lb,$J["data_style"]),'</table>
<p><input type="submit" value="Export">
<input type="hidden" name="token" value="',$T,'">

<table>
',script("qsl('table').onclick = dumpClick;");$og=array();if(DB!=""){$Za=($a!=""?"":" checked");echo"<thead><tr>","<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$Za>".'Tables'."</label>".script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);",""),"<th style='text-align: right;'><label class='block'>".'Data'."<input type='checkbox' id='check-data'$Za></label>".script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);",""),"</thead>\n";$hj="";$bi=tables_list();foreach($bi
as$B=>$U){$ng=preg_replace('~_.*~','',$B);$Za=($a==""||$a==(substr($a,-1)=="%"?"$ng%":$B));$qg="<tr><td>".checkbox("tables[]",$B,$Za,$B,"","block");if($U!==null&&!preg_match('~table~i',$U))$hj.="$qg\n";else
echo"$qg<td align='right'><label class='block'><span id='Rows-".h($B)."'></span>".checkbox("data[]",$B,$Za)."</label>\n";$og[$ng]++;}echo$hj;if($bi)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}else{echo"<thead><tr><th style='text-align: left;'>","<label class='block'><input type='checkbox' id='check-databases'".($a==""?" checked":"").">".'Database'."</label>",script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);",""),"</thead>\n";$i=$b->databases();if($i){foreach($i
as$j){if(!information_schema($j)){$ng=preg_replace('~_.*~','',$j);echo"<tr><td>".checkbox("databases[]",$j,$a==""||$a=="$ng%",$j,"","block")."\n";$og[$ng]++;}}}else
echo"<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";}echo'</table>
</form>
';$Yc=true;foreach($og
as$y=>$X){if($y!=""&&$X>1){echo($Yc?"<p>":" ")."<a href='".h(ME)."dump=".urlencode("$y%")."'>".h($y)."</a>";$Yc=false;}}}elseif(isset($_GET["privileges"])){page_header('Privileges');echo'<p class="links"><a href="'.h(ME).'user=">'.'Create user'."</a>";$H=$f->query("SELECT User, Host FROM mysql.".(DB==""?"user":"db WHERE ".q(DB)." LIKE Db")." ORDER BY Host, User");$qd=$H;if(!$H)$H=$f->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");echo"<form action=''><p>\n";hidden_fields_get();echo"<input type='hidden' name='db' value='".h(DB)."'>\n",($qd?"":"<input type='hidden' name='grant' value=''>\n"),"<table class='odds'>\n","<thead><tr><th>".'Username'."<th>".'Server'."<th></thead>\n";while($J=$H->fetch_assoc())echo'<tr><td>'.h($J["User"])."<td>".h($J["Host"]).'<td><a href="'.h(ME.'user='.urlencode($J["User"]).'&host='.urlencode($J["Host"])).'">'.'Edit'."</a>\n";if(!$qd||DB!="")echo"<tr><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='".'Edit'."'>\n";echo"</table>\n","</form>\n";}elseif(isset($_GET["sql"])){if(!$m&&$_POST["export"]){dump_headers("sql");$b->dumpTable("","");$b->dumpData("","table",$_POST["query"]);$b->dumpFooter();exit;}restart_session();$Ed=&get_session("queries");$Dd=&$Ed[DB];if(!$m&&$_POST["clear"]){$Dd=array();redirect(remove_from_uri("history"));}page_header((isset($_GET["import"])?'Import':'SQL command'),$m);if(!$m&&$_POST){$r=false;if(!isset($_GET["import"]))$G=$_POST["query"];elseif($_POST["webfile"]){$Fh=$b->importServerPath();$r=@fopen((file_exists($Fh)?$Fh:"compress.zlib://$Fh.gz"),"rb");$G=($r?fread($r,1e6):false);}else$G=get_file("sql_file",true,";");if(is_string($G)){if(function_exists('memory_get_usage')&&($Ne=ini_bytes("memory_limit"))!="-1")@ini_set("memory_limit",max($Ne,2*strlen($G)+memory_get_usage()+8e6));if($G!=""&&strlen($G)<1e6){$xg=$G.(preg_match("~;[ \t\r\n]*\$~",$G)?"":";");if(!$Dd||reset(end($Dd))!=$xg){restart_session();$Dd[]=array($xg,time());set_session("queries",$Ed);stop_session();}}$Ch="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";$Vb=";";$C=0;$uc=true;$g=connect($b->credentials());if(is_object($g)&&DB!=""){$g->select_db(DB);if($_GET["ns"]!="")set_schema($_GET["ns"],$g);}$ob=0;$Bc=array();$Vf='[\'"'.(JUSH=="sql"?'`#':(JUSH=="sqlite"?'`[':(JUSH=="mssql"?'[':''))).']|/\*|-- |$'.(JUSH=="pgsql"?'|\$[^$]*\$':'');$wi=microtime(true);parse_str($_COOKIE["adminer_export"],$ra);$lc=$b->dumpFormat();unset($lc["sql"]);while($G!=""){if(!$C&&preg_match("~^$Ch*+DELIMITER\\s+(\\S+)~i",$G,$A)){$Vb=$A[1];$G=substr($G,strlen($A[0]));}else{preg_match('('.preg_quote($Vb)."\\s*|$Vf)",$G,$A,PREG_OFFSET_CAPTURE,$C);list($jd,$ig)=$A[0];if(!$jd&&$r&&!feof($r))$G.=fread($r,1e5);else{if(!$jd&&rtrim($G)=="")break;$C=$ig+strlen($jd);if($jd&&rtrim($jd)!=$Vb){$Sa=$l->hasCStyleEscapes()||(JUSH=="pgsql"&&($ig>0&&strtolower($G[$ig-1])=="e"));$dg=($jd=='/*'?'\*/':($jd=='['?']':(preg_match('~^-- |^#~',$jd)?"\n":preg_quote($jd).($Sa?"|\\\\.":""))));while(preg_match("($dg|\$)s",$G,$A,PREG_OFFSET_CAPTURE,$C)){$Zg=$A[0][0];if(!$Zg&&$r&&!feof($r))$G.=fread($r,1e5);else{$C=$A[0][1]+strlen($Zg);if(!$Zg||$Zg[0]!="\\")break;}}}else{$uc=false;$xg=substr($G,0,$ig);$ob++;$qg="<pre id='sql-$ob'><code class='jush-".JUSH."'>".$b->sqlCommandQuery($xg)."</code></pre>\n";if(JUSH=="sqlite"&&preg_match("~^$Ch*+ATTACH\\b~i",$xg,$A)){echo$qg,"<p class='error'>".'ATTACH queries are not supported.'."\n";$Bc[]=" <a href='#sql-$ob'>$ob</a>";if($_POST["error_stops"])break;}else{if(!$_POST["only_errors"]){echo$qg;ob_flush();flush();}$Kh=microtime(true);if($f->multi_query($xg)&&is_object($g)&&preg_match("~^$Ch*+USE\\b~i",$xg))$g->query($xg);do{$H=$f->store_result();if($f->error){echo($_POST["only_errors"]?$qg:""),"<p class='error'>".'Error in query'.($f->errno?" ($f->errno)":"").": ".error()."\n";$Bc[]=" <a href='#sql-$ob'>$ob</a>";if($_POST["error_stops"])break
2;}else{$li=" <span class='time'>(".format_time($Kh).")</span>".(strlen($xg)<1000?" <a href='".h(ME)."sql=".urlencode(trim($xg))."'>".'Edit'."</a>":"");$ta=$f->affected_rows;$kj=($_POST["only_errors"]?"":$l->warnings());$lj="warnings-$ob";if($kj)$li.=", <a href='#$lj'>".'Warnings'."</a>".script("qsl('a').onclick = partial(toggle, '$lj');","");$Jc=null;$Kc="explain-$ob";if(is_object($H)){$z=$_POST["limit"];$Gf=select($H,$g,array(),$z);if(!$_POST["only_errors"]){echo"<form action='' method='post'>\n";$hf=$H->num_rows;echo"<p>".($hf?($z&&$hf>$z?sprintf('%d / ',$z):"").lang(array('%d row','%d rows'),$hf):""),$li;if($g&&preg_match("~^($Ch|\\()*+SELECT\\b~i",$xg)&&($Jc=explain($g,$xg)))echo", <a href='#$Kc'>Explain</a>".script("qsl('a').onclick = partial(toggle, '$Kc');","");$u="export-$ob";echo", <a href='#$u'>".'Export'."</a>".script("qsl('a').onclick = partial(toggle, '$u');","")."<span id='$u' class='hidden'>: ".html_select("output",$b->dumpOutput(),$ra["output"])." ".html_select("format",$lc,$ra["format"])."<input type='hidden' name='query' value='".h($xg)."'>"." <input type='submit' name='export' value='".'Export'."'><input type='hidden' name='token' value='$T'></span>\n"."</form>\n";}}else{if(preg_match("~^$Ch*+(CREATE|DROP|ALTER)$Ch++(DATABASE|SCHEMA)\\b~i",$xg)){restart_session();set_session("dbs",null);stop_session();}if(!$_POST["only_errors"])echo"<p class='message' title='".h($f->info)."'>".lang(array('Query executed OK, %d row affected.','Query executed OK, %d rows affected.'),$ta)."$li\n";}echo($kj?"<div id='$lj' class='hidden'>\n$kj</div>\n":"");if($Jc){echo"<div id='$Kc' class='hidden explain'>\n";select($Jc,$g,$Gf);echo"</div>\n";}}$Kh=microtime(true);}while($f->next_result());}$G=substr($G,$C);$C=0;}}}}if($uc)echo"<p class='message'>".'No commands to execute.'."\n";elseif($_POST["only_errors"]){echo"<p class='message'>".lang(array('%d query executed OK.','%d queries executed OK.'),$ob-count($Bc))," <span class='time'>(".format_time($wi).")</span>\n";}elseif($Bc&&$ob>1)echo"<p class='error'>".'Error in query'.": ".implode("",$Bc)."\n";}else
echo"<p class='error'>".upload_error($G)."\n";}echo'
<form action="" method="post" enctype="multipart/form-data" id="form">
';$Hc="<input type='submit' value='".'Execute'."' title='Ctrl+Enter'>";if(!isset($_GET["import"])){$xg=$_GET["sql"];if($_POST)$xg=$_POST["query"];elseif($_GET["history"]=="all")$xg=$Dd;elseif($_GET["history"]!="")$xg=$Dd[$_GET["history"]][0];echo"<p>";textarea("query",$xg,20);echo
script(($_POST?"":"qs('textarea').focus();\n")."qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '".js_escape(remove_from_uri("sql|limit|error_stops|only_errors|history"))."');"),"<p>$Hc\n",'Limit rows'.": <input type='number' name='limit' class='size' value='".h($_POST?$_POST["limit"]:$_GET["limit"])."'>\n";}else{echo"<fieldset><legend>".'File upload'."</legend><div>";$wd=(extension_loaded("zlib")?"[.gz]":"");echo(ini_bool("file_uploads")?"SQL$wd (&lt; ".ini_get("upload_max_filesize")."B): <input type='file' name='sql_file[]' multiple>\n$Hc":'File uploads are disabled.'),"</div></fieldset>\n";$Ld=$b->importServerPath();if($Ld){echo"<fieldset><legend>".'From server'."</legend><div>",sprintf('Webserver file %s',"<code>".h($Ld)."$wd</code>"),' <input type="submit" name="webfile" value="'.'Run file'.'">',"</div></fieldset>\n";}echo"<p>";}echo
checkbox("error_stops",1,($_POST?$_POST["error_stops"]:isset($_GET["import"])||$_GET["error_stops"]),'Stop on error')."\n",checkbox("only_errors",1,($_POST?$_POST["only_errors"]:isset($_GET["import"])||$_GET["only_errors"]),'Show only errors')."\n","<input type='hidden' name='token' value='$T'>\n";if(!isset($_GET["import"])&&$Dd){print_fieldset("history",'History',$_GET["history"]!="");for($X=end($Dd);$X;$X=prev($Dd)){$y=key($Dd);list($xg,$li,$pc)=$X;echo'<a href="'.h(ME."sql=&history=$y").'">'.'Edit'."</a>"." <span class='time' title='".@date('Y-m-d',$li)."'>".@date("H:i:s",$li)."</span>"." <code class='jush-".JUSH."'>".shorten_utf8(ltrim(str_replace("\n"," ",str_replace("\r","",preg_replace('~^(#|-- ).*~m','',$xg)))),80,"</code>").($pc?" <span class='time'>($pc)</span>":"")."<br>\n";}echo"<input type='submit' name='clear' value='".'Clear'."'>\n","<a href='".h(ME."sql=&history=all")."'>".'Edit all'."</a>\n","</div></fieldset>\n";}echo'</form>
';}elseif(isset($_GET["edit"])){$a=$_GET["edit"];$o=fields($a);$Z=(isset($_GET["select"])?($_POST["check"]&&count($_POST["check"])==1?where_check($_POST["check"][0],$o):""):where($_GET,$o));$Ri=(isset($_GET["select"])?$_POST["edit"]:$Z);foreach($o
as$B=>$n){if(!isset($n["privileges"][$Ri?"update":"insert"])||$b->fieldName($n)==""||$n["generated"])unset($o[$B]);}if($_POST&&!$m&&!isset($_GET["select"])){$_e=$_POST["referer"];if($_POST["insert"])$_e=($Ri?null:$_SERVER["REQUEST_URI"]);elseif(!preg_match('~^.+&select=.+$~',$_e))$_e=ME."select=".urlencode($a);$x=indexes($a);$Mi=unique_array($_GET["where"],$x);$_g="\nWHERE $Z";if(isset($_POST["delete"]))queries_redirect($_e,'Item has been deleted.',$l->delete($a,$_g,!$Mi));else{$N=array();foreach($o
as$B=>$n){$X=process_input($n);if($X!==false&&$X!==null)$N[idf_escape($B)]=$X;}if($Ri){if(!$N)redirect($_e);queries_redirect($_e,'Item has been updated.',$l->update($a,$N,$_g,!$Mi));if(is_ajax()){page_headers();page_messages($m);exit;}}else{$H=$l->insert($a,$N);$re=($H?last_id():0);queries_redirect($_e,sprintf('Item%s has been inserted.',($re?" $re":"")),$H);}}}$J=null;if($_POST["save"])$J=(array)$_POST["fields"];elseif($Z){$L=array();foreach($o
as$B=>$n){if(isset($n["privileges"]["select"])){$za=($_POST["clone"]&&$n["auto_increment"]?"''":convert_field($n));$L[]=($za?"$za AS ":"").idf_escape($B);}}$J=array();if(!support("table"))$L=array("*");if($L){$H=$l->select($a,$L,array($Z),$L,array(),(isset($_GET["select"])?2:1));if(!$H)$m=error();else{$J=$H->fetch_assoc();if(!$J)$J=false;}if(isset($_GET["select"])&&(!$J||$H->fetch_assoc()))$J=null;}}if(!support("table")&&!$o){if(!$Z){$H=$l->select($a,array("*"),$Z,array("*"));$J=($H?$H->fetch_assoc():false);if(!$J)$J=array($l->primary=>"");}if($J){foreach($J
as$y=>$X){if(!$Z)$J[$y]=null;$o[$y]=array("field"=>$y,"null"=>($y!=$l->primary),"auto_increment"=>($y==$l->primary));}}}edit_form($a,$o,$J,$Ri);}elseif(isset($_GET["create"])){$a=$_GET["create"];$Xf=array();foreach(array('HASH','LINEAR HASH','KEY','LINEAR KEY','RANGE','LIST')as$y)$Xf[$y]=$y;$Fg=referencable_primary($a);$hd=array();foreach($Fg
as$Wh=>$n)$hd[str_replace("`","``",$Wh)."`".str_replace("`","``",$n["field"])]=$Wh;$Jf=array();$R=array();if($a!=""){$Jf=fields($a);$R=table_status($a);if(!$R)$m='No tables.';}$J=$_POST;$J["fields"]=(array)$J["fields"];if($J["auto_increment_col"])$J["fields"][$J["auto_increment_col"]]["auto_increment"]=true;if($_POST)set_adminer_settings(array("comments"=>$_POST["comments"],"defaults"=>$_POST["defaults"]));if($_POST&&!process_fields($J["fields"])&&!$m){if($_POST["drop"])queries_redirect(substr(ME,0,-1),'Table has been dropped.',drop_tables(array($a)));else{$o=array();$xa=array();$Vi=false;$fd=array();$If=reset($Jf);$va=" FIRST";foreach($J["fields"]as$y=>$n){$q=$hd[$n["type"]];$Gi=($q!==null?$Fg[$q]:$n);if($n["field"]!=""){if(!$n["generated"])$n["default"]=null;$vg=process_field($n,$Gi);$xa[]=array($n["orig"],$vg,$va);if(!$If||$vg!==process_field($If,$If)){$o[]=array($n["orig"],$vg,$va);if($n["orig"]!=""||$va)$Vi=true;}if($q!==null)$fd[idf_escape($n["field"])]=($a!=""&&JUSH!="sqlite"?"ADD":" ").format_foreign_key(array('table'=>$hd[$n["type"]],'source'=>array($n["field"]),'target'=>array($Gi["field"]),'on_delete'=>$n["on_delete"],));$va=" AFTER ".idf_escape($n["field"]);}elseif($n["orig"]!=""){$Vi=true;$o[]=array($n["orig"]);}if($n["orig"]!=""){$If=next($Jf);if(!$If)$va="";}}$Zf="";if(support("partitioning")){if(isset($Xf[$J["partition_by"]])){$Uf=array_filter($J,function($y){return
preg_match('~^partition~',$y);},ARRAY_FILTER_USE_KEY);foreach($Uf["partition_names"]as$y=>$B){if($B==""){unset($Uf["partition_names"][$y]);unset($Uf["partition_values"][$y]);}}if($Uf!=get_partitions_info($a)){$ag=array();if($Uf["partition_by"]=='RANGE'||$Uf["partition_by"]=='LIST'){foreach($Uf["partition_names"]as$y=>$B){$Y=$Uf["partition_values"][$y];$ag[]="\n  PARTITION ".idf_escape($B)." VALUES ".($Uf["partition_by"]=='RANGE'?"LESS THAN":"IN").($Y!=""?" ($Y)":" MAXVALUE");}}$Zf.="\nPARTITION BY $Uf[partition_by]($Uf[partition])";if($ag)$Zf.=" (".implode(",",$ag)."\n)";elseif($Uf["partitions"])$Zf.=" PARTITIONS ".(+$Uf["partitions"]);}}elseif(preg_match("~partitioned~",$R["Create_options"]))$Zf.="\nREMOVE PARTITIONING";}$Oe='Table has been altered.';if($a==""){cookie("adminer_engine",$J["Engine"]);$Oe='Table has been created.';}$B=trim($J["name"]);queries_redirect(ME.(support("table")?"table=":"select=").urlencode($B),$Oe,alter_table($a,$B,(JUSH=="sqlite"&&($Vi||$fd)?$xa:$o),$fd,($J["Comment"]!=$R["Comment"]?$J["Comment"]:null),($J["Engine"]&&$J["Engine"]!=$R["Engine"]?$J["Engine"]:""),($J["Collation"]&&$J["Collation"]!=$R["Collation"]?$J["Collation"]:""),($J["Auto_increment"]!=""?number($J["Auto_increment"]):""),$Zf));}}page_header(($a!=""?'Alter table':'Create table'),$m,array("table"=>$a),h($a));if(!$_POST){$Ii=$l->types();$J=array("Engine"=>$_COOKIE["adminer_engine"],"fields"=>array(array("field"=>"","type"=>(isset($Ii["int"])?"int":(isset($Ii["integer"])?"integer":"")),"on_update"=>"")),"partition_names"=>array(""),);if($a!=""){$J=$R;$J["name"]=$a;$J["fields"]=array();if(!$_GET["auto_increment"])$J["Auto_increment"]="";foreach($Jf
as$n){$n["generated"]=$n["generated"]?:(isset($n["default"])?"DEFAULT":"");$J["fields"][]=$n;}if(support("partitioning")){$J+=get_partitions_info($a);$J["partition_names"][]="";$J["partition_values"][]="";}}}$jb=collations();$wc=engines();foreach($wc
as$vc){if(!strcasecmp($vc,$J["Engine"])){$J["Engine"]=$vc;break;}}echo'
<form action="" method="post" id="form">
<p>
';if(support("columns")||$a==""){echo'Table name: <input name="name"',($a==""&&!$_POST?" autofocus":""),' data-maxlength="64" value="',h($J["name"]),'" autocapitalize="off">
',($wc?html_select("Engine",array(""=>"(".'engine'.")")+$wc,$J["Engine"]).on_help("getTarget(event).value",1).script("qsl('select').onchange = helpClose;"):""),' ';if($jb){echo"<datalist id='collations'>".optionlist($jb)."</datalist>",(preg_match("~sqlite|mssql~",JUSH)?"":"<input list='collations' name='Collation' value='".h($J["Collation"])."' placeholder='(".'collation'.")'>");}echo' <input type="submit" value="Save">
';}echo'
';if(support("columns")){echo'<div class="scrollable">
<table id="edit-fields" class="nowrap">
';edit_fields($J["fields"],$jb,"TABLE",$hd);echo'</table>
',script("editFields();"),'</div>
<p>
Auto Increment: <input type="number" name="Auto_increment" class="size" value="',h($J["Auto_increment"]),'">
',checkbox("defaults",1,($_POST?$_POST["defaults"]:adminer_setting("defaults")),'Default values',"columnShow(this.checked, 5)","jsonly");$rb=($_POST?$_POST["comments"]:adminer_setting("comments"));echo(support("comment")?checkbox("comments",1,$rb,'Comment',"editingCommentsClick(this, true);","jsonly").' '.(preg_match('~\n~',$J["Comment"])?"<textarea name='Comment' rows='2' cols='20'".($rb?"":" class='hidden'").">".h($J["Comment"])."</textarea>":'<input name="Comment" value="'.h($J["Comment"]).'" data-maxlength="'.(min_version(5.5)?2048:60).'"'.($rb?"":" class='hidden'").'>'):''),'<p>
<input type="submit" value="Save">
';}echo'
';if($a!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$a));}if(support("partitioning")){$Yf=preg_match('~RANGE|LIST~',$J["partition_by"]);print_fieldset("partition",'Partition by',$J["partition_by"]);echo'<p>
',html_select("partition_by",array(""=>"")+$Xf,$J["partition_by"]).on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')",1).script("qsl('select').onchange = partitionByChange;"),'(<input name="partition" value="',h($J["partition"]),'">)
Partitions: <input type="number" name="partitions" class="size',($Yf||!$J["partition_by"]?" hidden":""),'" value="',h($J["partitions"]),'">
<table id="partition-table"',($Yf?"":" class='hidden'"),'>
<thead><tr><th>Partition name<th>Values</thead>
';foreach($J["partition_names"]as$y=>$X){echo'<tr>','<td><input name="partition_names[]" value="'.h($X).'" autocapitalize="off">',($y==count($J["partition_names"])-1?script("qsl('input').oninput = partitionNameChange;"):''),'<td><input name="partition_values[]" value="'.h($J["partition_values"][$y]).'">';}echo'</table>
</div></fieldset>
';}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["indexes"])){$a=$_GET["indexes"];$Pd=array("PRIMARY","UNIQUE","INDEX");$R=table_status($a,true);if(preg_match('~MyISAM|M?aria'.(min_version(5.6,'10.0.5')?'|InnoDB':'').'~i',$R["Engine"]))$Pd[]="FULLTEXT";if(preg_match('~MyISAM|M?aria'.(min_version(5.7,'10.2.2')?'|InnoDB':'').'~i',$R["Engine"]))$Pd[]="SPATIAL";$x=indexes($a);$F=array();if(JUSH=="mongo"){$F=$x["_id_"];unset($Pd[0]);unset($x["_id_"]);}$J=$_POST;if($J)set_adminer_settings(array("index_options"=>$J["options"]));if($_POST&&!$m&&!$_POST["add"]&&!$_POST["drop_col"]){$c=array();foreach($J["indexes"]as$w){$B=$w["name"];if(in_array($w["type"],$Pd)){$e=array();$xe=array();$Xb=array();$N=array();ksort($w["columns"]);foreach($w["columns"]as$y=>$d){if($d!=""){$we=$w["lengths"][$y];$Wb=$w["descs"][$y];$N[]=idf_escape($d).($we?"(".(+$we).")":"").($Wb?" DESC":"");$e[]=$d;$xe[]=($we?:null);$Xb[]=$Wb;}}$Ic=$x[$B];if($Ic){ksort($Ic["columns"]);ksort($Ic["lengths"]);ksort($Ic["descs"]);if($w["type"]==$Ic["type"]&&array_values($Ic["columns"])===$e&&(!$Ic["lengths"]||array_values($Ic["lengths"])===$xe)&&array_values($Ic["descs"])===$Xb){unset($x[$B]);continue;}}if($e)$c[]=array($w["type"],$B,$N);}}foreach($x
as$B=>$Ic)$c[]=array($Ic["type"],$B,"DROP");if(!$c)redirect(ME."table=".urlencode($a));queries_redirect(ME."table=".urlencode($a),'Indexes have been altered.',alter_indexes($a,$c));}page_header('Indexes',$m,array("table"=>$a),h($a));$o=array_keys(fields($a));if($_POST["add"]){foreach($J["indexes"]as$y=>$w){if($w["columns"][count($w["columns"])]!="")$J["indexes"][$y]["columns"][]="";}$w=end($J["indexes"]);if($w["type"]||array_filter($w["columns"],'strlen'))$J["indexes"][]=array("columns"=>array(1=>""));}if(!$J){foreach($x
as$y=>$w){$x[$y]["name"]=$y;$x[$y]["columns"][]="";}$x[]=array("columns"=>array(1=>""));$J["indexes"]=$x;}$xe=(JUSH=="sql"||JUSH=="mssql");$uh=($_POST?$_POST["options"]:adminer_setting("index_options"));echo'
<form action="" method="post">
<div class="scrollable">
<table class="nowrap">
<thead><tr>
<th id="label-type">Index Type
<th><input type="submit" class="wayoff">','Column'.($xe?"<span class='idxopts".($uh?"":" hidden")."'> (".'length'.")</span>":"");if($xe||support("descidx"))echo
checkbox("options",1,$uh,'Options',"indexOptionsShow(this.checked)","jsonly")."\n";echo'<th id="label-name">Name
<th><noscript>',"<input type='image' class='icon' name='add[0]' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=5.0.4")."' alt='+' title='".'Add next'."'>",'</noscript>
</thead>
';if($F){echo"<tr><td>PRIMARY<td>";foreach($F["columns"]as$y=>$d){echo
select_input(" disabled",$o,$d),"<label><input disabled type='checkbox'>".'descending'."</label> ";}echo"<td><td>\n";}$ge=1;foreach($J["indexes"]as$w){if(!$_POST["drop_col"]||$ge!=key($_POST["drop_col"])){echo"<tr><td>".html_select("indexes[$ge][type]",array(-1=>"")+$Pd,$w["type"],($ge==count($J["indexes"])?"indexesAddRow.call(this);":""),"label-type"),"<td>";ksort($w["columns"]);$t=1;foreach($w["columns"]as$y=>$d){echo"<span>".select_input(" name='indexes[$ge][columns][$t]' title='".'Column'."'",($o?array_combine($o,$o):$o),$d,"partial(".($t==count($w["columns"])?"indexesAddColumn":"indexesChangeColumn").", '".js_escape(JUSH=="sql"?"":$_GET["indexes"]."_")."')"),"<span class='idxopts".($uh?"":" hidden")."'>",($xe?"<input type='number' name='indexes[$ge][lengths][$t]' class='size' value='".h($w["lengths"][$y])."' title='".'Length'."'>":""),(support("descidx")?checkbox("indexes[$ge][descs][$t]",1,$w["descs"][$y],'descending'):""),"</span> </span>";$t++;}echo"<td><input name='indexes[$ge][name]' value='".h($w["name"])."' autocapitalize='off' aria-labelledby='label-name'>\n","<td><input type='image' class='icon' name='drop_col[$ge]' src='".h(preg_replace("~\\?.*~","",ME)."?file=cross.gif&version=5.0.4")."' alt='x' title='".'Remove'."'>".script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");}$ge++;}echo'</table>
</div>
<p>
<input type="submit" value="Save">
<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["database"])){$J=$_POST;if($_POST&&!$m&&!isset($_POST["add_x"])){$B=trim($J["name"]);if($_POST["drop"]){$_GET["db"]="";queries_redirect(remove_from_uri("db|database"),'Database has been dropped.',drop_databases(array(DB)));}elseif(DB!==$B){if(DB!=""){$_GET["db"]=$B;queries_redirect(preg_replace('~\bdb=[^&]*&~','',ME)."db=".urlencode($B),'Database has been renamed.',rename_database($B,$J["collation"]));}else{$i=explode("\n",str_replace("\r","",$B));$Ph=true;$qe="";foreach($i
as$j){if(count($i)==1||$j!=""){if(!create_database($j,$J["collation"]))$Ph=false;$qe=$j;}}restart_session();set_session("dbs",null);queries_redirect(ME."db=".urlencode($qe),'Database has been created.',$Ph);}}else{if(!$J["collation"])redirect(substr(ME,0,-1));query_redirect("ALTER DATABASE ".idf_escape($B).(preg_match('~^[a-z0-9_]+$~i',$J["collation"])?" COLLATE $J[collation]":""),substr(ME,0,-1),'Database has been altered.');}}page_header(DB!=""?'Alter database':'Create database',$m,array(),h(DB));$jb=collations();$B=DB;if($_POST)$B=$J["name"];elseif(DB!="")$J["collation"]=db_collation(DB,$jb);elseif(JUSH=="sql"){foreach(get_vals("SHOW GRANTS")as$qd){if(preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~',$qd,$A)&&$A[1]){$B=stripcslashes(idf_unescape("`$A[2]`"));break;}}}echo'
<form action="" method="post">
<p>
',($_POST["add_x"]||strpos($B,"\n")?'<textarea autofocus name="name" rows="10" cols="40">'.h($B).'</textarea><br>':'<input name="name" autofocus value="'.h($B).'" data-maxlength="64" autocapitalize="off">')."\n".($jb?html_select("collation",array(""=>"(".'collation'.")")+$jb,$J["collation"]).doc_link(array('sql'=>"charset-charsets.html",'mariadb'=>"supported-character-sets-and-collations/",'mssql'=>"relational-databases/system-functions/sys-fn-helpcollations-transact-sql",)):""),'<input type="submit" value="Save">
';if(DB!="")echo"<input type='submit' name='drop' value='".'Drop'."'>".confirm(sprintf('Drop %s?',DB))."\n";elseif(!$_POST["add_x"]&&$_GET["db"]=="")echo"<input type='image' class='icon' name='add' src='".h(preg_replace("~\\?.*~","",ME)."?file=plus.gif&version=5.0.4")."' alt='+' title='".'Add next'."'>\n";echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["scheme"])){$J=$_POST;if($_POST&&!$m){$_=preg_replace('~ns=[^&]*&~','',ME)."ns=";if($_POST["drop"])query_redirect("DROP SCHEMA ".idf_escape($_GET["ns"]),$_,'Schema has been dropped.');else{$B=trim($J["name"]);$_.=urlencode($B);if($_GET["ns"]=="")query_redirect("CREATE SCHEMA ".idf_escape($B),$_,'Schema has been created.');elseif($_GET["ns"]!=$B)query_redirect("ALTER SCHEMA ".idf_escape($_GET["ns"])." RENAME TO ".idf_escape($B),$_,'Schema has been altered.');else
redirect($_);}}page_header($_GET["ns"]!=""?'Alter schema':'Create schema',$m);if(!$J)$J["name"]=$_GET["ns"];echo'
<form action="" method="post">
<p><input name="name" autofocus value="',h($J["name"]),'" autocapitalize="off">
<input type="submit" value="Save">
';if($_GET["ns"]!="")echo"<input type='submit' name='drop' value='".'Drop'."'>".confirm(sprintf('Drop %s?',$_GET["ns"]))."\n";echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["call"])){$da=($_GET["name"]?:$_GET["call"]);page_header('Call'.": ".h($da),$m);$Vg=routine($_GET["call"],(isset($_GET["callf"])?"FUNCTION":"PROCEDURE"));$Md=array();$Of=array();foreach($Vg["fields"]as$t=>$n){if(substr($n["inout"],-3)=="OUT")$Of[$t]="@".idf_escape($n["field"])." AS ".idf_escape($n["field"]);if(!$n["inout"]||substr($n["inout"],0,2)=="IN")$Md[]=$t;}if(!$m&&$_POST){$Ta=array();foreach($Vg["fields"]as$y=>$n){if(in_array($y,$Md)){$X=process_input($n);if($X===false)$X="''";if(isset($Of[$y]))$f->query("SET @".idf_escape($n["field"])." = $X");}$Ta[]=(isset($Of[$y])?"@".idf_escape($n["field"]):$X);}$G=(isset($_GET["callf"])?"SELECT":"CALL")." ".table($da)."(".implode(", ",$Ta).")";$Kh=microtime(true);$H=$f->multi_query($G);$ta=$f->affected_rows;echo$b->selectQuery($G,$Kh,!$H);if(!$H)echo"<p class='error'>".error()."\n";else{$g=connect($b->credentials());if(is_object($g))$g->select_db(DB);do{$H=$f->store_result();if(is_object($H))select($H,$g);else
echo"<p class='message'>".lang(array('Routine has been called, %d row affected.','Routine has been called, %d rows affected.'),$ta)." <span class='time'>".@date("H:i:s")."</span>\n";}while($f->next_result());if($Of)select($f->query("SELECT ".implode(", ",$Of)));}}echo'
<form action="" method="post">
';if($Md){echo"<table class='layout'>\n";foreach($Md
as$y){$n=$Vg["fields"][$y];$B=$n["field"];echo"<tr><th>".$b->fieldName($n);$Y=$_POST["fields"][$B];if($Y!=""){if($n["type"]=="set")$Y=implode(",",$Y);}input($n,$Y,(string)$_POST["function"][$B]);echo"\n";}echo"</table>\n";}echo'<p>
<input type="submit" value="Call">
<input type="hidden" name="token" value="',$T,'">
</form>

<pre>
';function
pre_tr($Zg){return
preg_replace('~^~m','<tr>',preg_replace('~\|~','<td>',preg_replace('~\|$~m',"",rtrim($Zg))));}$Q='(\+--[-+]+\+\n)';$J='(\| .* \|\n)';echo
preg_replace_callback("~^$Q?$J$Q?($J*)$Q?~m",function($A){$Zc=pre_tr($A[2]);return"<table>\n".($A[1]?"<thead>$Zc</thead>\n":$Zc).pre_tr($A[4])."\n</table>";},preg_replace('~(\n(    -|mysql)&gt; )(.+)~',"\\1<code class='jush-sql'>\\3</code>",preg_replace('~(.+)\n---+\n~',"<b>\\1</b>\n",h($Vg['comment']))));echo'</pre>
';}elseif(isset($_GET["foreign"])){$a=$_GET["foreign"];$B=$_GET["name"];$J=$_POST;if($_POST&&!$m&&!$_POST["add"]&&!$_POST["change"]&&!$_POST["change-js"]){if(!$_POST["drop"]){$J["source"]=array_filter($J["source"],'strlen');ksort($J["source"]);$ei=array();foreach($J["source"]as$y=>$X)$ei[$y]=$J["target"][$y];$J["target"]=$ei;}if(JUSH=="sqlite")$H=recreate_table($a,$a,array(),array(),array(" $B"=>($J["drop"]?"":" ".format_foreign_key($J))));else{$c="ALTER TABLE ".table($a);$H=($B==""||queries("$c DROP ".(JUSH=="sql"?"FOREIGN KEY ":"CONSTRAINT ").idf_escape($B)));if(!$J["drop"])$H=queries("$c ADD".format_foreign_key($J));}queries_redirect(ME."table=".urlencode($a),($J["drop"]?'Foreign key has been dropped.':($B!=""?'Foreign key has been altered.':'Foreign key has been created.')),$H);if(!$J["drop"])$m="$m<br>".'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.';}page_header('Foreign key',$m,array("table"=>$a),h($a));if($_POST){ksort($J["source"]);if($_POST["add"])$J["source"][]="";elseif($_POST["change"]||$_POST["change-js"])$J["target"]=array();}elseif($B!=""){$hd=foreign_keys($a);$J=$hd[$B];$J["source"][]="";}else{$J["table"]=$a;$J["source"]=array("");}echo'
<form action="" method="post">
';$Bh=array_keys(fields($a));if($J["db"]!="")$f->select_db($J["db"]);if($J["ns"]!=""){$Kf=get_schema();set_schema($J["ns"]);}$Eg=array_keys(array_filter(table_status('',true),'Adminer\fk_support'));$ei=array_keys(fields(in_array($J["table"],$Eg)?$J["table"]:reset($Eg)));$uf="this.form['change-js'].value = '1'; this.form.submit();";echo"<p>".'Target table'.": ".html_select("table",$Eg,$J["table"],$uf)."\n";if(support("scheme")){$ch=array_filter($b->schemas(),function($bh){return!preg_match('~^information_schema$~i',$bh);});echo'Schema'.": ".html_select("ns",$ch,$J["ns"]!=""?$J["ns"]:$_GET["ns"],$uf);if($J["ns"]!="")set_schema($Kf);}elseif(JUSH!="sqlite"){$Qb=array();foreach($b->databases()as$j){if(!information_schema($j))$Qb[]=$j;}echo'DB'.": ".html_select("db",$Qb,$J["db"]!=""?$J["db"]:$_GET["db"],$uf);}echo'<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="Change"></noscript>
<table>
<thead><tr><th id="label-source">Source<th id="label-target">Target</thead>
';$ge=0;foreach($J["source"]as$y=>$X){echo"<tr>","<td>".html_select("source[".(+$y)."]",array(-1=>"")+$Bh,$X,($ge==count($J["source"])-1?"foreignAddRow.call(this);":""),"label-source"),"<td>".html_select("target[".(+$y)."]",$ei,$J["target"][$y],"","label-target");$ge++;}echo'</table>
<p>
ON DELETE: ',html_select("on_delete",array(-1=>"")+explode("|",$l->onActions),$J["on_delete"]),' ON UPDATE: ',html_select("on_update",array(-1=>"")+explode("|",$l->onActions),$J["on_update"]),doc_link(array('sql'=>"innodb-foreign-key-constraints.html",'mariadb'=>"foreign-keys/",'pgsql'=>"sql-createtable.html#SQL-CREATETABLE-REFERENCES",'mssql'=>"t-sql/statements/create-table-transact-sql",'oracle'=>"SQLRF01111",)),'<p>
<input type="submit" value="Save">
<noscript><p><input type="submit" name="add" value="Add column"></noscript>
';if($B!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$B));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["view"])){$a=$_GET["view"];$J=$_POST;$Lf="VIEW";if(JUSH=="pgsql"&&$a!=""){$O=table_status($a);$Lf=strtoupper($O["Engine"]);}if($_POST&&!$m){$B=trim($J["name"]);$za=" AS\n$J[select]";$_e=ME."table=".urlencode($B);$Oe='View has been altered.';$U=($_POST["materialized"]?"MATERIALIZED VIEW":"VIEW");if(!$_POST["drop"]&&$a==$B&&JUSH!="sqlite"&&$U=="VIEW"&&$Lf=="VIEW")query_redirect((JUSH=="mssql"?"ALTER":"CREATE OR REPLACE")." VIEW ".table($B).$za,$_e,$Oe);else{$gi=$B."_adminer_".uniqid();drop_create("DROP $Lf ".table($a),"CREATE $U ".table($B).$za,"DROP $U ".table($B),"CREATE $U ".table($gi).$za,"DROP $U ".table($gi),($_POST["drop"]?substr(ME,0,-1):$_e),'View has been dropped.',$Oe,'View has been created.',$a,$B);}}if(!$_POST&&$a!=""){$J=view($a);$J["name"]=$a;$J["materialized"]=($Lf!="VIEW");if(!$m)$m=error();}page_header(($a!=""?'Alter view':'Create view'),$m,array("table"=>$a),h($a));echo'
<form action="" method="post">
<p>Name: <input name="name" value="',h($J["name"]),'" data-maxlength="64" autocapitalize="off">
',(support("materializedview")?" ".checkbox("materialized",1,$J["materialized"],'Materialized view'):""),'<p>';textarea("select",$J["select"]);echo'<p>
<input type="submit" value="Save">
';if($a!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$a));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["event"])){$aa=$_GET["event"];$Xd=array("YEAR","QUARTER","MONTH","DAY","HOUR","MINUTE","WEEK","SECOND","YEAR_MONTH","DAY_HOUR","DAY_MINUTE","DAY_SECOND","HOUR_MINUTE","HOUR_SECOND","MINUTE_SECOND");$Lh=array("ENABLED"=>"ENABLE","DISABLED"=>"DISABLE","SLAVESIDE_DISABLED"=>"DISABLE ON SLAVE");$J=$_POST;if($_POST&&!$m){if($_POST["drop"])query_redirect("DROP EVENT ".idf_escape($aa),substr(ME,0,-1),'Event has been dropped.');elseif(in_array($J["INTERVAL_FIELD"],$Xd)&&isset($Lh[$J["STATUS"]])){$ah="\nON SCHEDULE ".($J["INTERVAL_VALUE"]?"EVERY ".q($J["INTERVAL_VALUE"])." $J[INTERVAL_FIELD]".($J["STARTS"]?" STARTS ".q($J["STARTS"]):"").($J["ENDS"]?" ENDS ".q($J["ENDS"]):""):"AT ".q($J["STARTS"]))." ON COMPLETION".($J["ON_COMPLETION"]?"":" NOT")." PRESERVE";queries_redirect(substr(ME,0,-1),($aa!=""?'Event has been altered.':'Event has been created.'),queries(($aa!=""?"ALTER EVENT ".idf_escape($aa).$ah.($aa!=$J["EVENT_NAME"]?"\nRENAME TO ".idf_escape($J["EVENT_NAME"]):""):"CREATE EVENT ".idf_escape($J["EVENT_NAME"]).$ah)."\n".$Lh[$J["STATUS"]]." COMMENT ".q($J["EVENT_COMMENT"]).rtrim(" DO\n$J[EVENT_DEFINITION]",";").";"));}}page_header(($aa!=""?'Alter event'.": ".h($aa):'Create event'),$m);if(!$J&&$aa!=""){$K=get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = ".q(DB)." AND EVENT_NAME = ".q($aa));$J=reset($K);}echo'
<form action="" method="post">
<table class="layout">
<tr><th>Name<td><input name="EVENT_NAME" value="',h($J["EVENT_NAME"]),'" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">Start<td><input name="STARTS" value="',h("$J[EXECUTE_AT]$J[STARTS]"),'">
<tr><th title="datetime">End<td><input name="ENDS" value="',h($J["ENDS"]),'">
<tr><th>Every<td><input type="number" name="INTERVAL_VALUE" value="',h($J["INTERVAL_VALUE"]),'" class="size"> ',html_select("INTERVAL_FIELD",$Xd,$J["INTERVAL_FIELD"]),'<tr><th>Status<td>',html_select("STATUS",$Lh,$J["STATUS"]),'<tr><th>Comment<td><input name="EVENT_COMMENT" value="',h($J["EVENT_COMMENT"]),'" data-maxlength="64">
<tr><th><td>',checkbox("ON_COMPLETION","PRESERVE",$J["ON_COMPLETION"]=="PRESERVE",'On completion preserve'),'</table>
<p>';textarea("EVENT_DEFINITION",$J["EVENT_DEFINITION"]);echo'<p>
<input type="submit" value="Save">
';if($aa!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$aa));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["procedure"])){$da=($_GET["name"]?:$_GET["procedure"]);$Vg=(isset($_GET["function"])?"FUNCTION":"PROCEDURE");$J=$_POST;$J["fields"]=(array)$J["fields"];if($_POST&&!process_fields($J["fields"])&&!$m){$Hf=routine($_GET["procedure"],$Vg);$gi="$J[name]_adminer_".uniqid();drop_create("DROP $Vg ".routine_id($da,$Hf),create_routine($Vg,$J),"DROP $Vg ".routine_id($J["name"],$J),create_routine($Vg,array("name"=>$gi)+$J),"DROP $Vg ".routine_id($gi,$J),substr(ME,0,-1),'Routine has been dropped.','Routine has been altered.','Routine has been created.',$da,$J["name"]);}page_header(($da!=""?(isset($_GET["function"])?'Alter function':'Alter procedure').": ".h($da):(isset($_GET["function"])?'Create function':'Create procedure')),$m);if(!$_POST&&$da!=""){$J=routine($_GET["procedure"],$Vg);$J["name"]=$da;}$jb=get_vals("SHOW CHARACTER SET");sort($jb);$Wg=routine_languages();echo($jb?"<datalist id='collations'>".optionlist($jb)."</datalist>":""),'
<form action="" method="post" id="form">
<p>Name: <input name="name" value="',h($J["name"]),'" data-maxlength="64" autocapitalize="off">
',($Wg?'Language'.": ".html_select("language",$Wg,$J["language"])."\n":""),'<input type="submit" value="Save">
<div class="scrollable">
<table class="nowrap">
';edit_fields($J["fields"],$jb,$Vg);if(isset($_GET["function"])){echo"<tr><td>".'Return type';edit_type("returns",$J["returns"],$jb,array(),(JUSH=="pgsql"?array("void","trigger"):array()));}echo'</table>
',script("editFields();"),'</div>
<p>';textarea("definition",$J["definition"]);echo'<p>
<input type="submit" value="Save">
';if($da!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$da));}echo'<input type="hidden" name="token" value="',$T,'">
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
';if($ga!=""){$Ii=$l->types();$_c=type_values($Ii[$ga]);if($_c)echo"<code class='jush-".JUSH."'>ENUM (".h($_c).")</code>\n<p>";echo"<input type='submit' name='drop' value='".'Drop'."'>".confirm(sprintf('Drop %s?',$ga))."\n";}else{echo'Name'.": <input name='name' value='".h($J['name'])."' autocapitalize='off'>\n",doc_link(array('pgsql'=>"datatype-enum.html",),"?");textarea("as",$J["as"]);echo"<p><input type='submit' value='".'Save'."'>\n";}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["check"])){$a=$_GET["check"];$B=$_GET["name"];$J=$_POST;if($J&&!$m){if(JUSH=="sqlite")$H=recreate_table($a,$a,array(),array(),array(),0,array(),$B,($J["drop"]?"":$J["clause"]));else{$H=($B==""||queries("ALTER TABLE ".table($a)." DROP CONSTRAINT ".idf_escape($B)));if(!$J["drop"])$H=queries("ALTER TABLE ".table($a)." ADD".($J["name"]!=""?" CONSTRAINT ".idf_escape($J["name"]):"")." CHECK ($J[clause])");}queries_redirect(ME."table=".urlencode($a),($J["drop"]?'Check has been dropped.':($B!=""?'Check has been altered.':'Check has been created.')),$H);}page_header(($B!=""?'Alter check'.": ".h($B):'Create check'),$m,array("table"=>$a));if(!$J){$ab=$l->checkConstraints($a);$J=array("name"=>$B,"clause"=>$ab[$B]);}echo'
<form action="" method="post">
<p>';if(JUSH!="sqlite")echo'Name'.': <input name="name" value="'.h($J["name"]).'" data-maxlength="64" autocapitalize="off"> ';echo
doc_link(array('sql'=>"create-table-check-constraints.html",'mariadb'=>"constraint/",'pgsql'=>"ddl-constraints.html#DDL-CONSTRAINTS-CHECK-CONSTRAINTS",'mssql'=>"relational-databases/tables/create-check-constraints",'sqlite'=>"lang_createtable.html#check_constraints",),"?"),'<p>';textarea("clause",$J["clause"]);echo'<p><input type="submit" value="Save">
';if($B!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$B));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["trigger"])){$a=$_GET["trigger"];$B=$_GET["name"];$Ei=trigger_options();$J=(array)trigger($B,$a)+array("Trigger"=>$a."_bi");if($_POST){if(!$m&&in_array($_POST["Timing"],$Ei["Timing"])&&in_array($_POST["Event"],$Ei["Event"])&&in_array($_POST["Type"],$Ei["Type"])){$rf=" ON ".table($a);$fc="DROP TRIGGER ".idf_escape($B).(JUSH=="pgsql"?$rf:"");$_e=ME."table=".urlencode($a);if($_POST["drop"])query_redirect($fc,$_e,'Trigger has been dropped.');else{if($B!="")queries($fc);queries_redirect($_e,($B!=""?'Trigger has been altered.':'Trigger has been created.'),queries(create_trigger($rf,$_POST)));if($B!="")queries(create_trigger($rf,$J+array("Type"=>reset($Ei["Type"]))));}}$J=$_POST;}page_header(($B!=""?'Alter trigger'.": ".h($B):'Create trigger'),$m,array("table"=>$a));echo'
<form action="" method="post" id="form">
<table class="layout">
<tr><th>Time<td>',html_select("Timing",$Ei["Timing"],$J["Timing"],"triggerChange(/^".preg_quote($a,"/")."_[ba][iud]$/, '".js_escape($a)."', this.form);"),'<tr><th>Event<td>',html_select("Event",$Ei["Event"],$J["Event"],"this.form['Timing'].onchange();"),(in_array("UPDATE OF",$Ei["Event"])?" <input name='Of' value='".h($J["Of"])."' class='hidden'>":""),'<tr><th>Type<td>',html_select("Type",$Ei["Type"],$J["Type"]),'</table>
<p>Name: <input name="Trigger" value="',h($J["Trigger"]),'" data-maxlength="64" autocapitalize="off">
',script("qs('#form')['Timing'].onchange();"),'<p>';textarea("Statement",$J["Statement"]);echo'<p>
<input type="submit" value="Save">
';if($B!=""){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',$B));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["user"])){$ha=$_GET["user"];$tg=array(""=>array("All privileges"=>""));foreach(get_rows("SHOW PRIVILEGES")as$J){foreach(explode(",",($J["Privilege"]=="Grant option"?"":$J["Context"]))as$zb)$tg[$zb][$J["Privilege"]]=$J["Comment"];}$tg["Server Admin"]+=$tg["File access on server"];$tg["Databases"]["Create routine"]=$tg["Procedures"]["Create routine"];unset($tg["Procedures"]["Create routine"]);$tg["Columns"]=array();foreach(array("Select","Insert","Update","References")as$X)$tg["Columns"][$X]=$tg["Tables"][$X];unset($tg["Server Admin"]["Usage"]);foreach($tg["Tables"]as$y=>$X)unset($tg["Databases"][$y]);$bf=array();if($_POST){foreach($_POST["objects"]as$y=>$X)$bf[$X]=(array)$bf[$X]+(array)$_POST["grants"][$y];}$rd=array();$pf="";if(isset($_GET["host"])&&($H=$f->query("SHOW GRANTS FOR ".q($ha)."@".q($_GET["host"])))){while($J=$H->fetch_row()){if(preg_match('~GRANT (.*) ON (.*) TO ~',$J[0],$A)&&preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~',$A[1],$Fe,PREG_SET_ORDER)){foreach($Fe
as$X){if($X[1]!="USAGE")$rd["$A[2]$X[2]"][$X[1]]=true;if(preg_match('~ WITH GRANT OPTION~',$J[0]))$rd["$A[2]$X[2]"]["GRANT OPTION"]=true;}}if(preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~",$J[0],$A))$pf=$A[1];}}if($_POST&&!$m){$qf=(isset($_GET["host"])?q($ha)."@".q($_GET["host"]):"''");if($_POST["drop"])query_redirect("DROP USER $qf",ME."privileges=",'User has been dropped.');else{$df=q($_POST["user"])."@".q($_POST["host"]);$bg=$_POST["pass"];if($bg!=''&&!$_POST["hashed"]&&!min_version(8)){$bg=get_val("SELECT PASSWORD(".q($bg).")");$m=!$bg;}$Eb=false;if(!$m){if($qf!=$df){$Eb=queries((min_version(5)?"CREATE USER":"GRANT USAGE ON *.* TO")." $df IDENTIFIED BY ".(min_version(8)?"":"PASSWORD ").q($bg));$m=!$Eb;}elseif($bg!=$pf)queries("SET PASSWORD FOR $df = ".q($bg));}if(!$m){$Sg=array();foreach($bf
as$jf=>$qd){if(isset($_GET["grant"]))$qd=array_filter($qd);$qd=array_keys($qd);if(isset($_GET["grant"]))$Sg=array_diff(array_keys(array_filter($bf[$jf],'strlen')),$qd);elseif($qf==$df){$nf=array_keys((array)$rd[$jf]);$Sg=array_diff($nf,$qd);$qd=array_diff($qd,$nf);unset($rd[$jf]);}if(preg_match('~^(.+)\s*(\(.*\))?$~U',$jf,$A)&&(!grant("REVOKE",$Sg,$A[2]," ON $A[1] FROM $df")||!grant("GRANT",$qd,$A[2]," ON $A[1] TO $df"))){$m=true;break;}}}if(!$m&&isset($_GET["host"])){if($qf!=$df)queries("DROP USER $qf");elseif(!isset($_GET["grant"])){foreach($rd
as$jf=>$Sg){if(preg_match('~^(.+)(\(.*\))?$~U',$jf,$A))grant("REVOKE",array_keys($Sg),$A[2]," ON $A[1] FROM $df");}}}queries_redirect(ME."privileges=",(isset($_GET["host"])?'User has been altered.':'User has been created.'),!$m);if($Eb)$f->query("DROP USER $df");}}page_header((isset($_GET["host"])?'Username'.": ".h("$ha@$_GET[host]"):'Create user'),$m,array("privileges"=>array('','Privileges')));$J=$_POST;if($J)$rd=$bf;else{$J=$_GET+array("host"=>get_val("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)"));$J["pass"]=$pf;if($pf!="")$J["hashed"]=true;$rd[(DB==""||$rd?"":idf_escape(addcslashes(DB,"%_\\"))).".*"]=array();}echo'<form action="" method="post">
<table class="layout">
<tr><th>Server<td><input name="host" data-maxlength="60" value="',h($J["host"]),'" autocapitalize="off">
<tr><th>Username<td><input name="user" data-maxlength="80" value="',h($J["user"]),'" autocapitalize="off">
<tr><th>Password<td><input name="pass" id="pass" value="',h($J["pass"]),'" autocomplete="new-password">
',($J["hashed"]?"":script("typePassword(qs('#pass'));")),(min_version(8)?"":checkbox("hashed",1,$J["hashed"],'Hashed',"typePassword(this.form['pass'], this.checked);")),'</table>

';echo"<table class='odds'>\n","<thead><tr><th colspan='2'>".'Privileges'.doc_link(array('sql'=>"grant.html#priv_level"));$t=0;foreach($rd
as$jf=>$qd){echo'<th>'.($jf!="*.*"?"<input name='objects[$t]' value='".h($jf)."' size='10' autocapitalize='off'>":"<input type='hidden' name='objects[$t]' value='*.*' size='10'>*.*");$t++;}echo"</thead>\n";foreach(array(""=>"","Server Admin"=>'Server',"Databases"=>'Database',"Tables"=>'Table',"Columns"=>'Column',"Procedures"=>'Routine',)as$zb=>$Wb){foreach((array)$tg[$zb]as$sg=>$pb){echo"<tr><td".($Wb?">$Wb<td":" colspan='2'").' lang="en" title="'.h($pb).'">'.h($sg);$t=0;foreach($rd
as$jf=>$qd){$B="'grants[$t][".h(strtoupper($sg))."]'";$Y=$qd[strtoupper($sg)];if($zb=="Server Admin"&&$jf!=(isset($rd["*.*"])?"*.*":".*"))echo"<td>";elseif(isset($_GET["grant"]))echo"<td><select name=$B><option><option value='1'".($Y?" selected":"").">".'Grant'."<option value='0'".($Y=="0"?" selected":"").">".'Revoke'."</select>";else{echo"<td align='center'><label class='block'>","<input type='checkbox' name=$B value='1'".($Y?" checked":"").($sg=="All privileges"?" id='grants-$t-all'>":">".($sg=="Grant option"?"":script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$t-all'); };"))),"</label>";}$t++;}}}echo"</table>\n",'<p>
<input type="submit" value="Save">
';if(isset($_GET["host"])){echo'<input type="submit" name="drop" value="Drop">',confirm(sprintf('Drop %s?',"$ha@$_GET[host]"));}echo'<input type="hidden" name="token" value="',$T,'">
</form>
';}elseif(isset($_GET["processlist"])){if(support("kill")){if($_POST&&!$m){$me=0;foreach((array)$_POST["kill"]as$X){if(kill_process($X))$me++;}queries_redirect(ME."processlist=",lang(array('%d process has been killed.','%d processes have been killed.'),$me),$me||!$_POST["kill"]);}}page_header('Process list',$m);echo'
<form action="" method="post">
<div class="scrollable">
<table class="nowrap checkable odds">
',script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");$t=-1;foreach(process_list()as$t=>$J){if(!$t){echo"<thead><tr lang='en'>".(support("kill")?"<th>":"");foreach($J
as$y=>$X)echo"<th>$y".doc_link(array('sql'=>"show-processlist.html#processlist_".strtolower($y),'pgsql'=>"monitoring-stats.html#PG-STAT-ACTIVITY-VIEW",'oracle'=>"REFRN30223",));echo"</thead>\n";}echo"<tr>".(support("kill")?"<td>".checkbox("kill[]",$J[JUSH=="sql"?"Id":"pid"],0):"");foreach($J
as$y=>$X)echo"<td>".((JUSH=="sql"&&$y=="Info"&&preg_match("~Query|Killed~",$J["Command"])&&$X!="")||(JUSH=="pgsql"&&$y=="current_query"&&$X!="<IDLE>")||(JUSH=="oracle"&&$y=="sql_text"&&$X!="")?"<code class='jush-".JUSH."'>".shorten_utf8($X,100,"</code>").' <a href="'.h(ME.($J["db"]!=""?"db=".urlencode($J["db"])."&":"")."sql=".urlencode($X)).'">'.'Clone'.'</a>':h($X));echo"\n";}echo'</table>
</div>
<p>
';if(support("kill")){echo($t+1)."/".sprintf('%d in total',max_connections()),"<p><input type='submit' value='".'Kill'."'>\n";}echo'<input type="hidden" name="token" value="',$T,'">
</form>
',script("tableCheck();");}elseif(isset($_GET["select"])){$a=$_GET["select"];$R=table_status1($a);$x=indexes($a);$o=fields($a);$hd=column_foreign_keys($a);$lf=$R["Oid"];parse_str($_COOKIE["adminer_import"],$sa);$Tg=array();$e=array();$fh=array();$Df=array();$ki=null;foreach($o
as$y=>$n){$B=$b->fieldName($n);$Ye=html_entity_decode(strip_tags($B),ENT_QUOTES);if(isset($n["privileges"]["select"])&&$B!=""){$e[$y]=$Ye;if(is_shortable($n))$ki=$b->selectLengthProcess();}if(isset($n["privileges"]["where"])&&$B!="")$fh[$y]=$Ye;if(isset($n["privileges"]["order"])&&$B!="")$Df[$y]=$Ye;$Tg+=$n["privileges"];}list($L,$sd)=$b->selectColumnsProcess($e,$x);$L=array_unique($L);$sd=array_unique($sd);$be=count($sd)<count($L);$Z=$b->selectSearchProcess($o,$x);$Cf=$b->selectOrderProcess($o,$x);$z=$b->selectLimitProcess();if($_GET["val"]&&is_ajax()){header("Content-Type: text/plain; charset=utf-8");foreach($_GET["val"]as$Ni=>$J){$za=convert_field($o[key($J)]);$L=array($za?:idf_escape(key($J)));$Z[]=where_check($Ni,$o);$I=$l->select($a,$L,$Z,$L);if($I)echo
reset($I->fetch_row());}exit;}$F=$Pi=null;foreach($x
as$w){if($w["type"]=="PRIMARY"){$F=array_flip($w["columns"]);$Pi=($L?$F:array());foreach($Pi
as$y=>$X){if(in_array(idf_escape($y),$L))unset($Pi[$y]);}break;}}if($lf&&!$F){$F=$Pi=array($lf=>0);$x[]=array("type"=>"PRIMARY","columns"=>array($lf));}if($_POST&&!$m){$qj=$Z;if(!$_POST["all"]&&is_array($_POST["check"])){$ab=array();foreach($_POST["check"]as$Wa)$ab[]=where_check($Wa,$o);$qj[]="((".implode(") OR (",$ab)."))";}$qj=($qj?"\nWHERE ".implode(" AND ",$qj):"");if($_POST["export"]){cookie("adminer_import","output=".urlencode($_POST["output"])."&format=".urlencode($_POST["format"]));dump_headers($a);$b->dumpTable($a,"");$ld=($L?implode(", ",$L):"*").convert_fields($e,$o,$L)."\nFROM ".table($a);$ud=($sd&&$be?"\nGROUP BY ".implode(", ",$sd):"").($Cf?"\nORDER BY ".implode(", ",$Cf):"");$G="SELECT $ld$qj$ud";if(is_array($_POST["check"])&&!$F){$Li=array();foreach($_POST["check"]as$X)$Li[]="(SELECT".limit($ld,"\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$o).$ud,1).")";$G=implode(" UNION ALL ",$Li);}$b->dumpData($a,"table",$G);$b->dumpFooter();exit;}if(!$b->selectEmailProcess($Z,$hd)){if($_POST["save"]||$_POST["delete"]){$H=true;$ta=0;$N=array();if(!$_POST["delete"]){foreach($_POST["fields"]as$B=>$X){$X=process_input($o[$B]);if($X!==null&&($_POST["clone"]||$X!==false))$N[idf_escape($B)]=($X!==false?$X:idf_escape($B));}}if($_POST["delete"]||$N){if($_POST["clone"])$G="INTO ".table($a)." (".implode(", ",array_keys($N)).")\nSELECT ".implode(", ",$N)."\nFROM ".table($a);if($_POST["all"]||($F&&is_array($_POST["check"]))||$be){$H=($_POST["delete"]?$l->delete($a,$qj):($_POST["clone"]?queries("INSERT $G$qj"):$l->update($a,$N,$qj)));$ta=$f->affected_rows;}else{foreach((array)$_POST["check"]as$X){$mj="\nWHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($X,$o);$H=($_POST["delete"]?$l->delete($a,$mj,1):($_POST["clone"]?queries("INSERT".limit1($a,$G,$mj)):$l->update($a,$N,$mj,1)));if(!$H)break;$ta+=$f->affected_rows;}}}$Oe=lang(array('%d item has been affected.','%d items have been affected.'),$ta);if($_POST["clone"]&&$H&&$ta==1){$re=last_id();if($re)$Oe=sprintf('Item%s has been inserted.'," $re");}queries_redirect(remove_from_uri($_POST["all"]&&$_POST["delete"]?"page":""),$Oe,$H);if(!$_POST["delete"]){$mg=(array)$_POST["fields"];edit_form($a,array_intersect_key($o,$mg),$mg,!$_POST["clone"]);page_footer();exit;}}elseif(!$_POST["import"]){if(!$_POST["val"])$m='Ctrl+click on a value to modify it.';else{$H=true;$ta=0;foreach($_POST["val"]as$Ni=>$J){$N=array();foreach($J
as$y=>$X){$y=bracket_escape($y,1);$N[idf_escape($y)]=(preg_match('~char|text~',$o[$y]["type"])||$X!=""?$b->processInput($o[$y],$X):"NULL");}$H=$l->update($a,$N," WHERE ".($Z?implode(" AND ",$Z)." AND ":"").where_check($Ni,$o),!$be&&!$F," ");if(!$H)break;$ta+=$f->affected_rows;}queries_redirect(remove_from_uri(),lang(array('%d item has been affected.','%d items have been affected.'),$ta),$H);}}elseif(!is_string($Wc=get_file("csv_file",true)))$m=upload_error($Wc);elseif(!preg_match('~~u',$Wc))$m='File must be in UTF-8 encoding.';else{cookie("adminer_import","output=".urlencode($sa["output"])."&format=".urlencode($_POST["separator"]));$H=true;$lb=array_keys($o);preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~',$Wc,$Fe);$ta=count($Fe[0]);$l->begin();$lh=($_POST["separator"]=="csv"?",":($_POST["separator"]=="tsv"?"\t":";"));$K=array();foreach($Fe[0]as$y=>$X){preg_match_all("~((?>\"[^\"]*\")+|[^$lh]*)$lh~",$X.$lh,$Ge);if(!$y&&!array_diff($Ge[1],$lb)){$lb=$Ge[1];$ta--;}else{$N=array();foreach($Ge[1]as$t=>$gb)$N[idf_escape($lb[$t])]=($gb==""&&$o[$lb[$t]]["null"]?"NULL":q(preg_match('~^".*"$~s',$gb)?str_replace('""','"',substr($gb,1,-1)):$gb));$K[]=$N;}}$H=(!$K||$l->insertUpdate($a,$K,$F));if($H)$l->commit();queries_redirect(remove_from_uri("page"),lang(array('%d row has been imported.','%d rows have been imported.'),$ta),$H);$l->rollback();}}}$Wh=$b->tableName($R);if(is_ajax()){page_headers();ob_start();}else
page_header('Select'.": $Wh",$m);$N=null;if(isset($Tg["insert"])||!support("table")){$Uf=array();foreach((array)$_GET["where"]as$X){if(isset($hd[$X["col"]])&&count($hd[$X["col"]])==1&&($X["op"]=="="||(!$X["op"]&&(is_array($X["val"])||!preg_match('~[_%]~',$X["val"])))))$Uf["set"."[".bracket_escape($X["col"])."]"]=$X["val"];}$N=$Uf?"&".http_build_query($Uf):"";}$b->selectLinks($R,$N);if(!$e&&support("table"))echo"<p class='error'>".'Unable to select the table'.($o?".":": ".error())."\n";else{echo"<form action='' id='form'>\n","<div style='display: none;'>";hidden_fields_get();echo(DB!=""?'<input type="hidden" name="db" value="'.h(DB).'">'.(isset($_GET["ns"])?'<input type="hidden" name="ns" value="'.h($_GET["ns"]).'">':""):"");echo'<input type="hidden" name="select" value="'.h($a).'">',"</div>\n";$b->selectColumnsPrint($L,$e);$b->selectSearchPrint($Z,$fh,$x);$b->selectOrderPrint($Cf,$Df,$x);$b->selectLimitPrint($z);$b->selectLengthPrint($ki);$b->selectActionPrint($x);echo"</form>\n";$D=$_GET["page"];if($D=="last"){$kd=get_val(count_rows($a,$Z,$be,$sd));$D=floor(max(0,$kd-1)/$z);}$gh=$L;$td=$sd;if(!$gh){$gh[]="*";$_b=convert_fields($e,$o,$L);if($_b)$gh[]=substr($_b,2);}foreach($L
as$y=>$X){$n=$o[idf_unescape($X)];if($n&&($za=convert_field($n)))$gh[$y]="$za AS $X";}if(!$be&&$Pi){foreach($Pi
as$y=>$X){$gh[]=idf_escape($y);if($td)$td[]=idf_escape($y);}}$H=$l->select($a,$gh,$Z,$td,$Cf,$z,$D,true);if(!$H)echo"<p class='error'>".error()."\n";else{if(JUSH=="mssql"&&$D)$H->seek($z*$D);$tc=array();echo"<form action='' method='post' enctype='multipart/form-data'>\n";$K=array();while($J=$H->fetch_assoc()){if($D&&JUSH=="oracle")unset($J["RNUM"]);$K[]=$J;}if($_GET["page"]!="last"&&$z!=""&&$sd&&$be&&JUSH=="sql")$kd=get_val(" SELECT FOUND_ROWS()");if(!$K)echo"<p class='message'>".'No rows.'."\n";else{$Ha=$b->backwardKeys($a,$Wh);echo"<div class='scrollable'>","<table id='table' class='nowrap checkable odds'>",script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"),"<thead><tr>".(!$sd&&$L?"":"<td><input type='checkbox' id='all-page' class='jsonly'>".script("qs('#all-page').onclick = partial(formCheck, /check/);","")." <a href='".h($_GET["modify"]?remove_from_uri("modify"):$_SERVER["REQUEST_URI"]."&modify=1")."'>".'Modify'."</a>");$Ze=array();$nd=array();reset($L);$Bg=1;foreach($K[0]as$y=>$X){if(!isset($Pi[$y])){$X=$_GET["columns"][key($L)];$n=$o[$L?($X?$X["col"]:current($L)):$y];$B=($n?$b->fieldName($n,$Bg):($X["fun"]?"*":h($y)));if($B!=""){$Bg++;$Ze[$y]=$B;$d=idf_escape($y);$Gd=remove_from_uri('(order|desc)[^=]*|page').'&order%5B0%5D='.urlencode($y);$Wb="&desc%5B0%5D=1";$Ah=isset($n["privileges"]["order"]);echo"<th id='th[".h(bracket_escape($y))."]'>".script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});","");$md=apply_sql_function($X["fun"],$B);echo($Ah?'<a href="'.h($Gd.($Cf[0]==$d||$Cf[0]==$y||(!$Cf&&$be&&$sd[0]==$d)?$Wb:'')).'">'."$md</a>":$md);echo"<span class='column hidden'>";if($Ah)echo"<a href='".h($Gd.$Wb)."' title='".'descending'."' class='text'> â†“</a>";if(!$X["fun"]&&isset($n["privileges"]["where"])){echo'<a href="#fieldset-search" title="'.'Search'.'" class="text jsonly"> =</a>',script("qsl('a').onclick = partial(selectSearch, '".js_escape($y)."');");}echo"</span>";}$nd[$y]=$X["fun"];next($L);}}$xe=array();if($_GET["modify"]){foreach($K
as$J){foreach($J
as$y=>$X)$xe[$y]=max($xe[$y],min(40,strlen(utf8_decode($X))));}}echo($Ha?"<th>".'Relations':"")."</thead>\n";if(is_ajax())ob_end_clean();foreach($b->rowDescriptions($K,$hd)as$Xe=>$J){$Mi=unique_array($K[$Xe],$x);if(!$Mi){$Mi=array();foreach($K[$Xe]as$y=>$X){if(!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~',$y))$Mi[$y]=$X;}}$Ni="";foreach($Mi
as$y=>$X){if((JUSH=="sql"||JUSH=="pgsql")&&preg_match('~char|text|enum|set~',$o[$y]["type"])&&strlen($X)>64){$y=(strpos($y,'(')?$y:idf_escape($y));$y="MD5(".(JUSH!='sql'||preg_match("~^utf8~",$o[$y]["collation"])?$y:"CONVERT($y USING ".charset($f).")").")";$X=md5($X);}$Ni.="&".($X!==null?urlencode("where[".bracket_escape($y)."]")."=".urlencode($X===false?"f":$X):"null%5B%5D=".urlencode($y));}echo"<tr>".(!$sd&&$L?"":"<td>".checkbox("check[]",substr($Ni,1),in_array(substr($Ni,1),(array)$_POST["check"])).($be||information_schema(DB)?"":" <a href='".h(ME."edit=".urlencode($a).$Ni)."' class='edit'>".'edit'."</a>"));foreach($J
as$y=>$X){if(isset($Ze[$y])){$n=$o[$y];$X=$l->value($X,$n);if($X!=""&&(!isset($tc[$y])||$tc[$y]!=""))$tc[$y]=(is_mail($X)?$Ze[$y]:"");$_="";if(preg_match('~blob|bytea|raw|file~',$n["type"])&&$X!="")$_=ME.'download='.urlencode($a).'&field='.urlencode($y).$Ni;if(!$_&&$X!==null){foreach((array)$hd[$y]as$q){if(count($hd[$y])==1||end($q["source"])==$y){$_="";foreach($q["source"]as$t=>$Bh)$_.=where_link($t,$q["target"][$t],$K[$Xe][$Bh]);$_=($q["db"]!=""?preg_replace('~([?&]db=)[^&]+~','\1'.urlencode($q["db"]),ME):ME).'select='.urlencode($q["table"]).$_;if($q["ns"])$_=preg_replace('~([?&]ns=)[^&]+~','\1'.urlencode($q["ns"]),$_);if(count($q["source"])==1)break;}}}if($y=="COUNT(*)"){$_=ME."select=".urlencode($a);$t=0;foreach((array)$_GET["where"]as$W){if(!array_key_exists($W["col"],$Mi))$_.=where_link($t++,$W["col"],$W["val"],$W["op"]);}foreach($Mi
as$ie=>$W)$_.=where_link($t++,$ie,$W);}$X=select_value($X,$_,$n,$ki);$u=h("val[$Ni][".bracket_escape($y)."]");$Y=$_POST["val"][$Ni][bracket_escape($y)];$oc=!is_array($J[$y])&&is_utf8($X)&&$K[$Xe][$y]==$J[$y]&&!$nd[$y]&&!$n["generated"];$ii=preg_match('~text|lob~',$n["type"]);echo"<td id='$u'";if(($_GET["modify"]&&$oc)||$Y!==null){$xd=h($Y!==null?$Y:$J[$y]);echo">".($ii?"<textarea name='$u' cols='30' rows='".(substr_count($J[$y],"\n")+1)."'>$xd</textarea>":"<input name='$u' value='$xd' size='$xe[$y]'>");}else{$Be=strpos($X,"<i>â€¦</i>");echo" data-text='".($Be?2:($ii?1:0))."'".($oc?"":" data-warning='".h('Use edit link to modify this value.')."'").">$X";}}}if($Ha)echo"<td>";$b->backwardKeysPrint($Ha,$K[$Xe]);echo"</tr>\n";}if(is_ajax())exit;echo"</table>\n","</div>\n";}if(!is_ajax()){if($K||$D){$Gc=true;if($_GET["page"]!="last"){if($z==""||(count($K)<$z&&($K||!$D)))$kd=($D?$D*$z:0)+count($K);elseif(JUSH!="sql"||!$be){$kd=($be?false:found_rows($R,$Z));if($kd<max(1e4,2*($D+1)*$z))$kd=reset(slow_query(count_rows($a,$Z,$be,$sd)));else$Gc=false;}}$Sf=($z!=""&&($kd===false||$kd>$z||$D));if($Sf){echo(($kd===false?count($K)+1:$kd-$D*$z)>$z?'<p><a href="'.h(remove_from_uri("page")."&page=".($D+1)).'" class="loadmore">'.'Load more data'.'</a>'.script("qsl('a').onclick = partial(selectLoadMore, ".(+$z).", '".'Loading'."â€¦');",""):''),"\n";}}echo"<div class='footer'><div>\n";if($K||$D){if($Sf){$Ie=($kd===false?$D+(count($K)>=$z?2:1):floor(($kd-1)/$z));echo"<fieldset>";if(JUSH!="simpledb"){echo"<legend><a href='".h(remove_from_uri("page"))."'>".'Page'."</a></legend>",script("qsl('a').onclick = function () { pageClick(this.href, +prompt('".'Page'."', '".($D+1)."')); return false; };"),pagination(0,$D).($D>5?" â€¦":"");for($t=max(1,$D-4);$t<min($Ie,$D+5);$t++)echo
pagination($t,$D);if($Ie>0){echo($D+5<$Ie?" â€¦":""),($Gc&&$kd!==false?pagination($Ie,$D):" <a href='".h(remove_from_uri("page")."&page=last")."' title='~$Ie'>".'last'."</a>");}}else{echo"<legend>".'Page'."</legend>",pagination(0,$D).($D>1?" â€¦":""),($D?pagination($D,$D):""),($Ie>$D?pagination($D+1,$D).($Ie>$D+1?" â€¦":""):"");}echo"</fieldset>\n";}echo"<fieldset>","<legend>".'Whole result'."</legend>";$cc=($Gc?"":"~ ").$kd;$vf="var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$cc' : checked); selectCount('selected2', this.checked || !checked ? '$cc' : checked);";echo
checkbox("all",1,0,($kd!==false?($Gc?"":"~ ").lang(array('%d row','%d rows'),$kd):""),$vf)."\n","</fieldset>\n";if($b->selectCommandPrint()){echo'<fieldset',($_GET["modify"]?'':' class="jsonly"'),'><legend>Modify</legend><div>
<input type="submit" value="Save"',($_GET["modify"]?'':' title="'.'Ctrl+click on a value to modify it.'.'"'),'>
</div></fieldset>
<fieldset><legend>Selected <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="Edit">
<input type="submit" name="clone" value="Clone">
<input type="submit" name="delete" value="Delete">',confirm(),'</div></fieldset>
';}$id=$b->dumpFormat();foreach((array)$_GET["columns"]as$d){if($d["fun"]){unset($id['sql']);break;}}if($id){print_fieldset("export",'Export'." <span id='selected2'></span>");$Pf=$b->dumpOutput();echo($Pf?html_select("output",$Pf,$sa["output"])." ":""),html_select("format",$id,$sa["format"])," <input type='submit' name='export' value='".'Export'."'>\n","</div></fieldset>\n";}$b->selectEmailPrint(array_filter($tc,'strlen'),$e);}echo"</div></div>\n";if($b->selectImportPrint()){echo"<div>","<a href='#import'>".'Import'."</a>",script("qsl('a').onclick = partial(toggle, 'import');",""),"<span id='import'".($_POST["import"]?"":" class='hidden'").">: ","<input type='file' name='csv_file'> ",html_select("separator",array("csv"=>"CSV,","csv;"=>"CSV;","tsv"=>"TSV"),$sa["format"])," <input type='submit' name='import' value='".'Import'."'>","</span>","</div>";}echo"<input type='hidden' name='token' value='$T'>\n","</form>\n",(!$sd&&$L?"":script("tableCheck();"));}}}if(is_ajax()){ob_end_clean();exit;}}elseif(isset($_GET["variables"])){$O=isset($_GET["status"]);page_header($O?'Status':'Variables');$dj=($O?show_status():show_variables());if(!$dj)echo"<p class='message'>".'No rows.'."\n";else{echo"<table>\n";foreach($dj
as$y=>$X){echo"<tr>","<th><code class='jush-".JUSH.($O?"status":"set")."'>".h($y)."</code>","<td>".nl_br(h($X));}echo"</table>\n";}}elseif(isset($_GET["script"])){header("Content-Type: text/javascript; charset=utf-8");if($_GET["script"]=="db"){$Sh=array("Data_length"=>0,"Index_length"=>0,"Data_free"=>0);foreach(table_status()as$B=>$R){json_row("Comment-$B",h($R["Comment"]));if(!is_view($R)){foreach(array("Engine","Collation")as$y)json_row("$y-$B",h($R[$y]));foreach($Sh+array("Auto_increment"=>0,"Rows"=>0)as$y=>$X){if($R[$y]!=""){$X=format_number($R[$y]);if($X>=0)json_row("$y-$B",($y=="Rows"&&$X&&$R["Engine"]==(JUSH=="pgsql"?"table":"InnoDB")?"~ $X":$X));if(isset($Sh[$y]))$Sh[$y]+=($R["Engine"]!="InnoDB"||$y!="Data_free"?$R[$y]:0);}elseif(array_key_exists($y,$R))json_row("$y-$B");}}}foreach($Sh
as$y=>$X)json_row("sum-$y",format_number($X));json_row("");}elseif($_GET["script"]=="kill")$f->query("KILL ".number($_POST["kill"]));else{foreach(count_tables($b->databases())as$j=>$X){json_row("tables-$j",$X);json_row("size-$j",db_size($j));}json_row("");}exit;}else{$ci=array_merge((array)$_POST["tables"],(array)$_POST["views"]);if($ci&&!$m&&!$_POST["search"]){$H=true;$Oe="";if(JUSH=="sql"&&$_POST["tables"]&&count($_POST["tables"])>1&&($_POST["drop"]||$_POST["truncate"]||$_POST["copy"]))queries("SET foreign_key_checks = 0");if($_POST["truncate"]){if($_POST["tables"])$H=truncate_tables($_POST["tables"]);$Oe='Tables have been truncated.';}elseif($_POST["move"]){$H=move_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Oe='Tables have been moved.';}elseif($_POST["copy"]){$H=copy_tables((array)$_POST["tables"],(array)$_POST["views"],$_POST["target"]);$Oe='Tables have been copied.';}elseif($_POST["drop"]){if($_POST["views"])$H=drop_views($_POST["views"]);if($H&&$_POST["tables"])$H=drop_tables($_POST["tables"]);$Oe='Tables have been dropped.';}elseif(JUSH=="sqlite"&&$_POST["check"]){foreach((array)$_POST["tables"]as$Q){foreach(get_rows("PRAGMA integrity_check(".q($Q).")")as$J)$Oe.="<b>".h($Q)."</b>: ".h($J["integrity_check"])."<br>";}}elseif(JUSH!="sql"){$H=(JUSH=="sqlite"?queries("VACUUM"):apply_queries("VACUUM".($_POST["optimize"]?"":" ANALYZE"),$_POST["tables"]));$Oe='Tables have been optimized.';}elseif(!$_POST["tables"])$Oe='No tables.';elseif($H=queries(($_POST["optimize"]?"OPTIMIZE":($_POST["check"]?"CHECK":($_POST["repair"]?"REPAIR":"ANALYZE")))." TABLE ".implode(", ",array_map('Adminer\idf_escape',$_POST["tables"])))){while($J=$H->fetch_assoc())$Oe.="<b>".h($J["Table"])."</b>: ".h($J["Msg_text"])."<br>";}queries_redirect(substr(ME,0,-1),$Oe,$H);}page_header(($_GET["ns"]==""?'Database'.": ".h(DB):'Schema'.": ".h($_GET["ns"])),$m,true);if($b->homepage()){if($_GET["ns"]!==""){echo"<h3 id='tables-views'>".'Tables and views'."</h3>\n";$bi=tables_list();if(!$bi)echo"<p class='message'>".'No tables.'."\n";else{echo"<form action='' method='post'>\n";if(support("table")){echo"<fieldset><legend>".'Search data in tables'." <span id='selected2'></span></legend><div>","<input type='search' name='query' value='".h($_POST["query"])."'>",script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');","")," <input type='submit' name='search' value='".'Search'."'>\n","</div></fieldset>\n";if($_POST["search"]&&$_POST["query"]!=""){$_GET["where"][0]["op"]=$l->convertOperator("LIKE %%");search_tables();}}echo"<div class='scrollable'>\n","<table class='nowrap checkable odds'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),'<thead><tr class="wrap">','<td><input id="check-all" type="checkbox" class="jsonly">'.script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);",""),'<th>'.'Table','<td>'.'Engine'.doc_link(array('sql'=>'storage-engines.html')),'<td>'.'Collation'.doc_link(array('sql'=>'charset-charsets.html','mariadb'=>'supported-character-sets-and-collations/')),'<td>'.'Data Length'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT','oracle'=>'REFRN20286')),'<td>'.'Index Length'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT')),'<td>'.'Data Free'.doc_link(array('sql'=>'show-table-status.html')),'<td>'.'Auto Increment'.doc_link(array('sql'=>'example-auto-increment.html','mariadb'=>'auto_increment/')),'<td>'.'Rows'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'catalog-pg-class.html#CATALOG-PG-CLASS','oracle'=>'REFRN20286')),(support("comment")?'<td>'.'Comment'.doc_link(array('sql'=>'show-table-status.html','pgsql'=>'functions-info.html#FUNCTIONS-INFO-COMMENT-TABLE')):''),"</thead>\n";$S=0;foreach($bi
as$B=>$U){$gj=($U!==null&&!preg_match('~table|sequence~i',$U));$u=h("Table-".$B);echo'<tr><td>'.checkbox(($gj?"views[]":"tables[]"),$B,in_array($B,$ci,true),"","","",$u),'<th>'.(support("table")||support("indexes")?"<a href='".h(ME)."table=".urlencode($B)."' title='".'Show structure'."' id='$u'>".h($B).'</a>':h($B));if($gj){echo'<td colspan="6"><a href="'.h(ME)."view=".urlencode($B).'" title="'.'Alter view'.'">'.(preg_match('~materialized~i',$U)?'Materialized view':'View').'</a>','<td align="right"><a href="'.h(ME)."select=".urlencode($B).'" title="'.'Select data'.'">?</a>';}else{foreach(array("Engine"=>array(),"Collation"=>array(),"Data_length"=>array("create",'Alter table'),"Index_length"=>array("indexes",'Alter indexes'),"Data_free"=>array("edit",'New item'),"Auto_increment"=>array("auto_increment=1&create",'Alter table'),"Rows"=>array("select",'Select data'),)as$y=>$_){$u=" id='$y-".h($B)."'";echo($_?"<td align='right'>".(support("table")||$y=="Rows"||(support("indexes")&&$y!="Data_length")?"<a href='".h(ME."$_[0]=").urlencode($B)."'$u title='$_[1]'>?</a>":"<span$u>?</span>"):"<td id='$y-".h($B)."'>");}$S++;}echo(support("comment")?"<td id='Comment-".h($B)."'>":""),"\n";}echo"<tr><td><th>".sprintf('%d in total',count($bi)),"<td>".h(JUSH=="sql"?get_val("SELECT @@default_storage_engine"):""),"<td>".h(db_collation(DB,collations()));foreach(array("Data_length","Index_length","Data_free")as$y)echo"<td align='right' id='sum-$y'>";echo"\n","</table>\n","</div>\n";if(!information_schema(DB)){echo"<div class='footer'><div>\n";$aj="<input type='submit' value='".'Vacuum'."'> ".on_help("'VACUUM'");$zf="<input type='submit' name='optimize' value='".'Optimize'."'> ".on_help(JUSH=="sql"?"'OPTIMIZE TABLE'":"'VACUUM OPTIMIZE'");echo"<fieldset><legend>".'Selected'." <span id='selected'></span></legend><div>".(JUSH=="sqlite"?$aj."<input type='submit' name='check' value='".'Check'."'> ".on_help("'PRAGMA integrity_check'"):(JUSH=="pgsql"?$aj.$zf:(JUSH=="sql"?"<input type='submit' value='".'Analyze'."'> ".on_help("'ANALYZE TABLE'").$zf."<input type='submit' name='check' value='".'Check'."'> ".on_help("'CHECK TABLE'")."<input type='submit' name='repair' value='".'Repair'."'> ".on_help("'REPAIR TABLE'"):"")))."<input type='submit' name='truncate' value='".'Truncate'."'> ".on_help(JUSH=="sqlite"?"'DELETE'":"'TRUNCATE".(JUSH=="pgsql"?"'":" TABLE'")).confirm()."<input type='submit' name='drop' value='".'Drop'."'>".on_help("'DROP TABLE'").confirm()."\n";$i=(support("scheme")?$b->schemas():$b->databases());if(count($i)!=1&&JUSH!="sqlite"){$j=(isset($_POST["target"])?$_POST["target"]:(support("scheme")?$_GET["ns"]:DB));echo"<p>".'Move to other database'.": ",($i?html_select("target",$i,$j):'<input name="target" value="'.h($j).'" autocapitalize="off">')," <input type='submit' name='move' value='".'Move'."'>",(support("copy")?" <input type='submit' name='copy' value='".'Copy'."'> ".checkbox("overwrite",1,$_POST["overwrite"],'overwrite'):""),"\n";}echo"<input type='hidden' name='all' value=''>";echo
script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));".(support("table")?" selectCount('selected2', formChecked(this, /^tables\[/) || $S);":"")." }"),"<input type='hidden' name='token' value='$T'>\n","</div></fieldset>\n","</div></div>\n";}echo"</form>\n",script("tableCheck();");}echo'<p class="links"><a href="'.h(ME).'create=">'.'Create table'."</a>\n",(support("view")?'<a href="'.h(ME).'view=">'.'Create view'."</a>\n":"");if(support("routine")){echo"<h3 id='routines'>".'Routines'."</h3>\n";$Xg=routines();if($Xg){echo"<table class='odds'>\n",'<thead><tr><th>'.'Name'.'<td>'.'Type'.'<td>'.'Return type'."<td></thead>\n";foreach($Xg
as$J){$B=($J["SPECIFIC_NAME"]==$J["ROUTINE_NAME"]?"":"&name=".urlencode($J["ROUTINE_NAME"]));echo'<tr>','<th><a href="'.h(ME.($J["ROUTINE_TYPE"]!="PROCEDURE"?'callf=':'call=').urlencode($J["SPECIFIC_NAME"]).$B).'">'.h($J["ROUTINE_NAME"]).'</a>','<td>'.h($J["ROUTINE_TYPE"]),'<td>'.h($J["DTD_IDENTIFIER"]),'<td><a href="'.h(ME.($J["ROUTINE_TYPE"]!="PROCEDURE"?'function=':'procedure=').urlencode($J["SPECIFIC_NAME"]).$B).'">'.'Alter'."</a>";}echo"</table>\n";}echo'<p class="links">'.(support("procedure")?'<a href="'.h(ME).'procedure=">'.'Create procedure'.'</a>':'').'<a href="'.h(ME).'function=">'.'Create function'."</a>\n";}if(support("sequence")){echo"<h3 id='sequences'>".'Sequences'."</h3>\n";$oh=get_vals("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = current_schema() ORDER BY sequence_name");if($oh){echo"<table class='odds'>\n","<thead><tr><th>".'Name'."</thead>\n";foreach($oh
as$X)echo"<tr><th><a href='".h(ME)."sequence=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."sequence='>".'Create sequence'."</a>\n";}if(support("type")){echo"<h3 id='user-types'>".'User types'."</h3>\n";$Yi=types();if($Yi){echo"<table class='odds'>\n","<thead><tr><th>".'Name'."</thead>\n";foreach($Yi
as$X)echo"<tr><th><a href='".h(ME)."type=".urlencode($X)."'>".h($X)."</a>\n";echo"</table>\n";}echo"<p class='links'><a href='".h(ME)."type='>".'Create type'."</a>\n";}if(support("event")){echo"<h3 id='events'>".'Events'."</h3>\n";$K=get_rows("SHOW EVENTS");if($K){echo"<table>\n","<thead><tr><th>".'Name'."<td>".'Schedule'."<td>".'Start'."<td>".'End'."<td></thead>\n";foreach($K
as$J){echo"<tr>","<th>".h($J["Name"]),"<td>".($J["Execute at"]?'At given time'."<td>".$J["Execute at"]:'Every'." ".$J["Interval value"]." ".$J["Interval field"]."<td>$J[Starts]"),"<td>$J[Ends]",'<td><a href="'.h(ME).'event='.urlencode($J["Name"]).'">'.'Alter'.'</a>';}echo"</table>\n";$Ec=get_val("SELECT @@event_scheduler");if($Ec&&$Ec!="ON")echo"<p class='error'><code class='jush-sqlset'>event_scheduler</code>: ".h($Ec)."\n";}echo'<p class="links"><a href="'.h(ME).'event=">'.'Create event'."</a>\n";}if($bi)echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");}}}page_footer();