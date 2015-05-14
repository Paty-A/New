<?
function validateEmail($email,$required){
	$email = trim($email);
	$valid=true;
	$domain = substr(strstr(trim($email),"@"),1);
	if (strlen($email)==0 && $required === 0){
		return true;
	}
	if (strlen($email)==0 && $required === 1){
		return false;
	}
	//in order of most likely events
	//1 "@" and at least one "."
	if(substr_count($email, "@")!=1 || substr_count($email, ".")==0){
		return false;
	}
	//at least 1 char before "@"
	$parts_at = explode("@",$email);
	if (strlen($parts_at[0])<1){
		return false;
	}
	//at least 4 chars after "@"
	if (strlen($parts_at[1])<4){
		return false;
	}			
	elseif(!getmxrr($domain,$mx_hosts)){
		return false;
	}
	//end in one of the extensions
	$parts_dot = explode(".",$parts_at[1]);
	$exts = array(".com", ".net", ".org", ".edu", ".us", ".int", ".mil", ".gov", ".arpa", ".biz", ".aero", ".name", ".coop", ".info", ".pro", ".museum", ".tv", ".ac", ".ad", ".ae", ".af", ".ag", ".ai", ".al", ".am", ".an", ".ao", ".aq", ".ar", ".as", ".at", ".au", ".aw", ".ax", ".az", ".ba", ".bb", ".bd", ".be", ".bf", ".bg", ".bh", ".bi", ".bj", ".bm", ".bn", ".bo", ".br", ".bs", ".bt", ".bv", ".bw", ".by", ".bz", ".ca", ".cc", ".cd", ".cf", ".cg", ".ch", ".ci", ".ck", ".cl", ".cm", ".cn", ".co", ".cr", ".cu", ".cv", ".cx", ".cy", ".cz", ".de", ".dj", ".dk", ".dm", ".do", ".dz", ".ec", ".ee", ".eg", ".eh", ".er", ".es", ".et", ".eu", ".fi", ".fj", ".fk", ".fm", ".fo", ".fr", ".ga", ".gb", ".gd", ".ge", ".gf", ".gg", ".gh", ".gi", ".gl", ".gm", ".gn", ".gp", ".gq", ".gr", ".gs", ".gt", ".gu", ".gw", ".gy", ".hk", ".hm", ".hn", ".hr", ".ht", ".hu", ".id", ".ie", ".il", ".im", ".in", ".io", ".iq", ".ir", ".is", ".it", ".je", ".jm", ".jo", ".jp", ".ke", ".kg", ".kh", ".ki", ".km", ".kn", ".kp", ".kr", ".kw", ".ky", ".kz", ".la", ".lb", ".lc", ".li", ".lk", ".lr", ".ls", ".lt", ".lu", ".lv", ".ly", ".ma", ".mc", ".md", ".me", ".mg", ".mh", ".mk", ".ml", ".mm", ".mn", ".mo", ".mp", ".mq", ".mr", ".ms", ".mt", ".mu", ".mv", ".mw", ".mx", ".my", ".mz", ".na", ".nc", ".ne", ".nf", ".ng", ".ni", ".nl", ".no", ".np", ".nr", ".nu", ".nz", ".om", ".pa", ".pe", ".pf", ".pg", ".ph", ".pk", ".pl", ".pm", ".pn", ".pr", ".ps", ".pt", ".pw", ".py", ".qa", ".re", ".ro", ".rs", ".ru", ".rw", ".sa", ".sb", ".sc", ".sd", ".se", ".sg", ".sh", ".si", ".sj", ".sk", ".sl", ".sm", ".sn", ".so", ".sr", ".st", ".su", ".sv", ".sy", ".sz", ".tc", ".td", ".tf", ".tg", ".th", ".tj", ".tk", ".tl", ".tm", ".tn", ".to", ".tp", ".tr", ".tt", ".tv", ".tw", ".tz", ".ua", ".ug", ".uk", ".um", ".us", ".uy", ".uz", ".va", ".vc", ".ve", ".vg", ".vi", ".vn", ".vu", ".wf", ".ws", ".ye", ".yt", ".yu", ".za", ".zm", ".zw");
	$extfound=false;
	for($i=0;$i<count($exts);$i++){
		if(strtoupper(".".$parts_dot[count($parts_dot)-1])==strtoupper($exts[$i])){
			$extfound=true;
			break;
		}
	}
	if(!$extfound){
		return false;
	}
	//no junk, only "_",number,letters, and "." (consider preg_match)
	$junk=array("!","#","$","%","^","&","*","(",")","<",">",",","?","/",",","{","}","[","]","`","~","'","=","+",'"',":",";"," ");
	for ($i=0;$i<count($junk);$i++){
		if(stristr($email,$junk[$i])!==FALSE){
			return false;
		}
	}
	//not be too long
	if(strlen($email)>50){
		return false;
	}
	return $valid;
}
?>