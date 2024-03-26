<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
date_default_timezone_set("Asia/Bangkok");

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://dookeela.live/api/fixture/'.$_GET['id'],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
   ),
));

$resilt = curl_exec($curl);

curl_close($curl);

$responseData = json_decode($resilt, true);

//print_r($responseData);

?>
<div id="div">
	<div class="row d-flex justify-content-center">
<div class="col-10">
	<header class="page-header page-header-sitebrand-topbar">
<div class="row d-flex justify-content-center">
<div class="col-sm-12" style="margin: 0;padding: 0;">
<nav class="navbar navbar-expand-lg navbar-light">
<a class="navbar-brand bg-secondary" href="https://livesodball.com" title="livesodball.com" rel="home">
<img src="https://livesodball.com/wp-content/webp-express/webp-images/doc-root/wp-content/uploads/2024/03/Logo-Livesodball-3-NonBG.png.webp" height="35" class="d-inline-block align-top mx-4" alt="livesodball.com" heigt="50">
</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bootstrap-basic4-topnavbar" aria-controls="bootstrap-basic4-topnavbar" aria-expanded="false" aria-label="Toggle navigation" style="float: right;">
<span class="navbar-toggler-icon"></span>
</button>
<div id="bootstrap-basic4-topnavbar" class="collapse navbar-collapse">
<ul id="bb4-primary-menu" class="navbar-nav ml-auto"><li id="menu-item-637" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-637 nav-item active"><a href="https://livesodball.com" class="nav-link  menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home">ดูบอลสด</a></li>
<li id="menu-item-935" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-935 nav-item"><a href="https://livesodball.com/matchLiving/" class="nav-link  menu-item menu-item-type-post_type menu-item-object-page">ตารางบอลวันนี้ โปรแกรมบอล</a></li>
<li id="menu-item-636" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-636 nav-item"><a href="https://livesodball.com/channels/" class="nav-link  menu-item menu-item-type-post_type menu-item-object-page">ดูทีวีออนไลน์</a></li>
</ul>  
	
<div class="float-lg-right">
</div>
<div class="clearfix"></div>
</div><!--.navbar-collapse-->
</nav>
</div>
</div>
</header>
</div>
<div class="col-12 col-md-6 col-lg-6 px-4">
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
<li class="breadcrumb-item d-none d-lg-block"><a href="https://livesodball.com">livesodball.com ดูบอลสด</a></li>
<li class="breadcrumb-item d-none d-lg-block"><a href="https://livesodball.com/category/division-1/"><?php print_r($responseData['league']['name']); ?></a></li>
<li class="breadcrumb-item active" aria-current="page"><a href="#"><?php print_r($responseData['teamhome']['name']); ?> VS <?php print_r($responseData['teamaway']['name']); ?></a></li>
</ol>
</nav>
<div>
<?php
$today = gmdate('n/j/Y g:i:s A');
$ip = $_SERVER['REMOTE_ADDR'];
if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
    $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
} elseif (!empty($_SERVER['HTTP_X_REAL_IP'])) {
    $ip = $_SERVER['HTTP_X_REAL_IP'];
} elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    $commapos = strrpos($ip, ',');
    $ip = trim(substr($ip, $commapos ? $commapos + 1 : 0));
}

$key = "K<dMh;8aWV)!U1A94l?";
$validminutes = 20;
$str2hash = $ip . $key . $today . $validminutes;
$md5raw = md5($str2hash, true);
$base64hash = base64_encode($md5raw);
$urlsignature = 'server_time=' . $today . '&hash_value=' . $base64hash . "&validminutes=$validminutes";
$base64urlsignature = base64_encode($urlsignature);

$srcUrl = "https://dkl-c33es.cdn.akamaiz.com/livesodball/" . $responseData['channel'] . "/playlist.m3u8?wmsAuthSign=" . $base64urlsignature;
?>
	<div id="player"></div>
</div>
	<script src="https://content.jwplatform.com/libraries/U4CTA3JQ.js"></script>
	<script>
		var player = jwplayer('player');
        player.setup({
            sources: [{
                "file": "<?php echo $srcUrl; ?>"
            }],
            controls: true,
            width: "100%",
            height: "100%",
            aspectratio: "16:9",
            fullscreen: "true",
            primary: 'html5',
            autostart: true,
            cast: {}
        });
	</script>
	<div class="match-info" style="margin-top:6px;margin-bottom:6px;">
		<div class="match">
			<div class="detail">
				<div class="team-name-left">
					<div class="name "><?php print_r($responseData['teamhome']['name_th']); ?></div>
					<div>
						<img src="<?php print_r($responseData['teamhome']['logo']); ?>" alt="<?php print_r($responseData['teamhome']['name_th']); ?>" title="<?php print_r($responseData['teamhome']['name_th']); ?>">
					</div>
				</div>
				<div class="text-center">
					<!-- __BLOCK__ -->                        
					<small class="mobile text-white time_match"><?php print_r($responseData['status_long']); ?></small>
					<!-- __ENDBLOCK__ -->
					<div class="vs">
						<span class="goals_home"><?php print_r($responseData['goals_home']); ?></span> - <span class="goals_away"><?php print_r($responseData['goals_away']); ?></span>
					</div>
				</div>
				<div class="team-name-right">
					<div>
						<img src="<?php print_r($responseData['teamaway']['logo']); ?>" alt="<?php print_r($responseData['teamaway']['name_th']); ?>" title="<?php print_r($responseData['teamaway']['name_th']); ?>">
					</div>
					<div class="name text-light"><?php print_r($responseData['teamaway']['name_th']); ?></div>
				</div>
			</div>
		</div>
	</div>
	
</div>
<div class="col-12 col-lg-4 mt-4 mt-lg-0" style="background-color:#F0F5FF;"><br>

<div class="row chs">
	
	

	<?php
	$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://dookeela.live/api/fixtures',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
   ),
));

$data = curl_exec($curl);

curl_close($curl);
//echo $response;
$response = json_decode($data, true);

	foreach ($response as $data) {
		foreach ($data['fixtures'] as $fixture) {
			if ($fixture['status'] == "First Half" || $fixture['status'] == "Halftime"
				|| $fixture['status'] == "Second Half" || $fixture['status'] == "Extra Time"
				|| $fixture['status'] == "Break Time" ) {
?>
	<div class="col col-3">
           <div class="ch text-center">
			<a href="https://livesodball.com/tvonline/?ch=<?php  echo $fixture['channel']; ?>">
				<img src="https://dookeela.live/uploads/<?php  echo $fixture['channel_logo']; ?>" alt="3 HD" title="3 HD" class="img-responsive" style="width:100%;">
				<small><?php  echo $fixture['channel']; ?></small>
			</a>
		</div>
</div>
        <?php 
        }
    }
}
	?>

</div>
<span style="float:right;">
<a href="https://livesodball.com/channels/" style="font-weight:bold;">ช่องทีวีทั้งหมด</a>
</span>

            
</div>

</div>
<script>
!function(){var B=4,V={pro:1,premium:2,ads:3,invalid:B,enterprise:6,trial:7,platinum:8,starter:9,business:10,developer:11},M={viewable:2},e="DATA_EVENT_PLAY",a="DATA_EVENT_META",t="DATA_EVENT_LEVELS",n="DATA_EVENT_FIRST_FRAME",y=128,r=["auto","initial choice"],o=["playlistItem","playAttempt","time","adBreakEnd"],L=0,b=20;var G=Object.assign||function(e){for(var a=arguments.length,t=Array(1<a?a-1:0),n=1;n<a;n++)t[n-1]=arguments[n];return t.reduce(function(e,a){return t=e,(n=a)&&Object.keys(n).forEach(function(e){t[e]=n[e]}),t;var t,n},e)};function O(e){if(e){if(/vast/.test(e))return 0;if(/googima/.test(e))return 1;if(/freewheel/.test(e))return 2;if(/dai/.test(e))return 3}return-1}function i(e){return/^[a-zA-Z0-9]{8}$/.test(e)}function d(e){var a=!(1<arguments.length&&void 0!==arguments[1])||arguments[1];if("number"!=typeof e)return null;var t=e/1e3;return a?Math.round(t):t}function c(e,a){return e+"-"+a}function p(e,a){return a.split(".").reduce(function(e,a){return e?e[a]:void 0},e)}function l(e){var a={};for(var t in e)if("object"==typeof e[t]){var n=l(e[t]);for(var r in n)n.hasOwnProperty(r)&&(a[t+"."+r]=n[r])}else a[t]=e[t];return a}function u(e){if(e)return e.version}function A(e){for(var a=e.length,t=0;t<e.length;t++){var n=e.charCodeAt(t),r=n;55296<=n&&n<=56319&&t<e.length-1&&(r=1024*(n-55296)+e.charCodeAt(t+1)-56320+65536,t++),128<=r&&r<=2047?a+=1:2048<=r&&r<=65535?a+=2:65536<=r&&r<=1114111&&(a+=2)}return a}var s=a;function h(e){var a=e.getContainer().querySelector("video");return a&&a.currentTime?a.currentTime:e.getPosition()}function f(a){try{return a.getPlaylistItem()}catch(e){var t=a.getPlaylistIndex();return a.getConfig().playlist[t]||null}}function m(e){if("function"!=typeof e.getProvider)return"";var a=e.getProvider();return a?a.name:""}var k=void 0;function N(e){var a=1<arguments.length&&void 0!==arguments[1]&&arguments[1],t=e.getVisualQuality(),n=void 0;if(t&&t.level){var r="string"==typeof t.mode?"auto"===t.mode:null;n={width:t.level.width,height:t.level.height,bitrate:d(t.level.bitrate),reason:t.reason,adaptiveBitrateMode:r}}else n={width:null,height:null,bitrate:null,reason:null,adaptiveBitrateMode:null};return k&&!a||(k=n),n}function D(e){var a=e.external.playerAPI,t=e.meta.playbackEvents,n=a.getDuration();if(n<=0){var r=t[s];r&&(n=r.duration)}return 0|n}function v(e,a){var t=e.playerData.startup;null===t.startupTime&&null!==t.initialTime&&(t.startupTime=10*Math.round((Date.now()-t.initialTime)/10),t.dispatchEvent=a)}function q(e){var a=e.getConfig().setupConfig;if(a){var i,o,d,l,t=window.jwplayer.defaults,n=G({},t,a);return delete n.advertising,JSON.stringify(n,(i=n,o=[],d=[],l=0,function(e,a){if("object"!=typeof a)return"function"==typeof a?"__FUNCTION__":a;if(null===a||a instanceof Date||a instanceof RegExp)return a;if(Uint8Array&&a instanceof Uint8Array){var t=""+a;return t=40<t.length?t.substr(0,40):t,"Uint8Array("+a.length+") ["+t+"]"}if(Array.isArray(a)&&100<a.length)return"Array("+a.length+")";if(a===i&&0<l)return"<parent object>";var n=o.indexOf(a);if(-1!==n){var r=d[n];if(r)return r;try{JSON.stringify(a)}catch(e){return d[n]="__CIRCULAR__"}d[n]=a}return 1e4<l++?"<complexity exceeded>":(o.push(a),a)}))}}var g={UNKNOWN:999,IAB:0},w={noBid:0,bid:1,timeout:2,invalid:3,abort:4,error:5},F={numCompanions:-1,podCount:0,podIndex:0,linear:-1,vastVersion:-1,adSystem:null,adCreativeType:null,adposition:-1,tagdomain:null,position:void 0,previousQuartile:0,duration:void 0,witem:1,wcount:1,preload:void 0,adMediaFileURL:void 0,description:null,creativeAdId:null,creativeId:null,adTitle:null,adVastId:null,jwpseg:void 0,placement:void 0,timeForVPBCache:null,advertiser:null,advertiserId:null},I={consecutiveVisibleSeconds:0,maxConsecutiveVisibleSeconds:0,totalVisibleSeconds:0},S=/^IAB(\d+(?:-\d+)?)$/,T={adRequest:"ar",adImpression:"i",adSkipped:"s",adError:"ae",adBidResponse:"abr",adClick:"c",adLoaded:"al",adViewableImpression:"vi",adBidRequest:"abq"},P=["adStarted","adMeta"],E=["adTime","adClick"],C=["adBreakStart","adMeta","adImpression","adViewableImpression","adPlay","adPause","adTime","adCompanions","adClick","adSkipped","adComplete","adError"],x={dfp:0,jwp:1,jwpdfp:2,jwpspotx:3},j=["id","type","pubid","pubId","member","invCode","nid","placementId","networkId","siteId","pageId","formatId","result","code","winner","priceInCents","grossPriceInCents","timeForBidResponse","requestId","cacheKey","dealId","tagid","delDomain","publisherId","zoneId"],R=/[?&]iu=([^&]+)/,U="error",_="s",Q="ana",z="t",K="prp",W="vsh",H="paf",$="bs",J="fs",X="fc",Y="aa",Z="gab",ee="xapi",ae="cpt",te="ia",ne="ph",re="n",ie="e",oe="i",de="as",le="ar",ce="avp",ue="avg",se="ers",pe="err",fe={events:{"aa-jwplayer6":{code:"aa",bucket:"jwplayer6",parameterGroups:["global"],pingSpecificParameters:["fct","fed","fid","fin","fns","fsid","fsr","ft","mu","os","ovta","psd"],filters:["missingFeedID"],pingDestination:"main"},"abr-clienta":{code:"abr",bucket:"clienta",parameterGroups:["global","adGlobal","headerBidding"],pingSpecificParameters:["apr","tfvc"],pingDestination:"main"},"abq-clienta":{code:"abq",bucket:"clienta",parameterGroups:["global","adGlobal","headerBidding"],pingSpecificParameters:["apr","bpv","ipv","rtp","tpi","vsrid"],pingDestination:"main"},"ae-clienta":{code:"ae",bucket:"clienta",parameterGroups:["global","adGlobal","headerBidding"],pingSpecificParameters:["ad","add","adid","adt","adv","advi","aec","aem","amu","apr","apt","ato","atu","caid","cid","ct","did","du","ec","fed","iu","mfc","tal","tpi","uav"],pingDestination:"main"},"al-clienta":{code:"al",bucket:"clienta",parameterGroups:["global","adGlobal"],pingSpecificParameters:["apr","tal"],filters:["missingAdScheduleID"],pingDestination:"main"},"ana-jwplayer6":{code:"ana",bucket:"jwplayer6",parameterGroups:["sessionParamsOnly"],filters:["missingMediaOrExternalID"],pingDestination:"main"},"ar-clienta":{code:"ar",bucket:"clienta",parameterGroups:["global","adGlobal"],pingSpecificParameters:["apr","apt","fed","ipv","rtp","tpi","vsrid"],pingDestination:"main"},"avg-clienta":{code:"avg",bucket:"clienta",parameterGroups:["global","adGlobal"],pingDestination:"main"},"avp-clienta":{code:"avp",bucket:"clienta",parameterGroups:["global","adGlobal"],pingDestination:"main"},"bi-clienta":{code:"bi",bucket:"clienta",parameterGroups:[],pingSpecificParameters:["aid"],pingDestination:"main"},"bs-jwplayer6":{code:"bs",bucket:"jwplayer6",parameterGroups:["global"],pingSpecificParameters:["fed","fid","ft","mu","os"],filters:["missingFeedID"],pingDestination:"main"},"c-clienta":{code:"c",bucket:"clienta",parameterGroups:["global","adGlobal"],pingSpecificParameters:["ad","adc","al","ct","du","qt","srf","tw","vv","uav"],pingDestination:"main"},"cpe-jwplayer6":{code:"cpe",bucket:"jwplayer6",parameterGroups:[],pingSpecificParameters:["aid","id","fed","mu","pss"],pingDestination:"external"},"cpt-jwplayer6":{code:"cpt",bucket:"jwplayer6",parameterGroups:["global"],pingDestination:"main"},"e-jwplayer6":{code:"e",bucket:"jwplayer6",parameterGroups:["global"],pingSpecificParameters:["ab","bpv","cae","cb","cdid","cme","dd","dnt","dpl","fed","flc","fv","ga","ipv","lng","mk","mu","opu","pad","pbc","pd","pdr","plng","plt","pni","po","pogt","ptid","pvt","rf","sn","sp","srf","st","vrt"],filters:["missingMediaOrExternalID"],pingDestination:"main"},"err-error":{code:"err",bucket:"error",parameterGroups:["global"],pingSpecificParameters:["cme","erc","mu","pogt","strt"],pingDestination:"main"},"ers-error":{code:"ers",bucket:"error",parameterGroups:["global"],pingSpecificParameters:["cme","erc","flc","pogt"],pingDestination:"main"},"fc-jwplayer6":{code:"fc",bucket:"jwplayer6",parameterGroups:["global"],pingSpecificParameters:["fct","fed","fid","fin","fns","fpg","fsid","fsr","ft","mu","oc","os","ovta","psd","srf","stid"],filters:["missingFeedID"],pingDestination:"main"},"fs-jwplayer6":{code:"fs",bucket:"jwplayer6",parameterGroups:["global"],pingSpecificParameters:["fed","fid","fin","fis","fns","fpc","fpg","fsid","fsr","ft","mu","os","ovt","rat","srf","tis","vfi"],filters:["missingFeedID"],pingDestination:"main"},"gab-jwplayer6":{code:"gab",bucket:"jwplayer6",parameterGroups:["global"],pingSpecificParameters:["abid","abpr","apid","ati","cst","erc","fls","lae","ovta","pbs","pcp","pdt","prs","prsd","pvta","srf","strt","ti","tps","ubc","vti"],filters:["missingMediaOrExternalID"],pingDestination:"main"},"i-clienta":{code:"i",bucket:"clienta",parameterGroups:["global","adGlobal","headerBidding"],pingSpecificParameters:["ad","adc","add","adid","adv","advi","apr","apt","adt","al","amu","atu","caid","cid","ct","did","du","fed","fid","fsm","iu","mfc","psd","strt","tal","vv","uav"],pingDestination:"main"},"ia-jwplayer6":{code:"ia",bucket:"jwplayer6",parameterGroups:["global"],pingSpecificParameters:["fid","iacid","iae","iaeid","iaelid","iaeln","iapid","iapn","iapv","iat"],pingDestination:"main"},"pa-jwplayer6":{code:"pa",bucket:"jwplayer6",parameterGroups:["global"],pingSpecificParameters:["ab","abid","abm","apid","bwe","cme","dnt","dpl","fed","fid","flc","lng","mu","opu","pd","pdr","plng","pni","pogt","pr","psd","pvta","sbr","tb","vd","vh","vw"],filters:["missingMediaOrExternalID"],pingDestination:"main"},"paf-error":{code:"paf",bucket:"error",parameterGroups:["global"],pingSpecificParameters:["abm","bwe","erc","fed","fid","mu","pd","pr","psd","sbr","tb","vd","vh","vw"],filters:["missingMediaOrExternalID"],pingDestination:"main"},"pe-placement":{code:"pe",bucket:"placement",parameterGroups:["placement"],pingSpecificParameters:["i","idp","pei"],pingDestination:"placement"},"pea-placement":{code:"pea",bucket:"placement",parameterGroups:["placement"],pingSpecificParameters:["i","idp","pei"],pingDestination:"placement"},"pef-placement":{code:"pef",bucket:"placement",parameterGroups:["placement"],pingSpecificParameters:["eid","idp","pei"],pingDestination:"placement"},"pes-placement":{code:"pes",bucket:"placement",parameterGroups:["placement"],pingSpecificParameters:["eid","idp","pei","so"],pingDestination:"placement"},"pll-placement":{code:"pll",bucket:"placement",parameterGroups:["placement"],pingDestination:"placement"},"pt-placement":{code:"pt",bucket:"placement",parameterGroups:["placement"],pingSpecificParameters:["eid","idp","pei","tid"],pingDestination:"placement"},"prp-jwplayer6":{code:"prp",bucket:"jwplayer6",parameterGroups:["global"],pingSpecificParameters:["tc"],filters:["missingMediaOrExternalID"],pingDestination:"main"},"pru-jwplayer6":{code:"pru",bucket:"jwplayer6",parameterGroups:["global"],pingSpecificParameters:["ppr"],filters:["missingMediaOrExternalID"],pingDestination:"main"},"ret-jwplayer6":{code:"ret",bucket:"jwplayer6",parameterGroups:["global"],pingSpecificParameters:["abm","ati","avc","bwe","cst","etw","fed","fid","fls","fsm","mu","pbs","pdt","pr","q","sbr","srf","ubc","vh","vr","vti","vw"],filters:["missingMediaOrExternalID"],pingDestination:"main"},"s-jwplayer6":{code:"s",bucket:"jwplayer6",parameterGroups:["global"],pingSpecificParameters:["abid","abm","apid","bpv","bwe","cae","cct","ch","cst","cdid","dnt","dpl","drm","fed","ff","fid","fsm","l","lng","mk","mu","opu","pcp","pd","pdr","pdt","plng","pni","pr","psd","q","qcr","sbr","sp","srf","strt","tb","tt","vd","vh","vs","vrt","vr","vw"],pingDestination:"main"},"s-clienta":{code:"s",bucket:"clienta",parameterGroups:["global","adGlobal"],pingSpecificParameters:["ad","adc","al","atps","ct","du","qt","tw","vv","uav"],pingDestination:"main"},"t-jwplayer6":{code:"t",bucket:"jwplayer6",parameterGroups:["global"],pingSpecificParameters:["abm","ati","avc","bwe","cst","dle","fed","fid","fls","fsm","ltc","mu","pbs","pcp","pdt","pw","q","sbr","ti","ubi","vh","vr","vti","vw"],filters:["missingMediaOrExternalID"],pingDestination:"main"},"v-clienta":{code:"v",bucket:"clienta",parameterGroups:["global","adGlobal"],pingSpecificParameters:["ad","adc","adti","adati","advti","al","ct","du","fsm","qt","vv","uav"],pingDestination:"main"},"vcae-clienta":{code:"vcae",bucket:"clienta",parameterGroups:["adSessionParamsOnly","sessionParamsOnly"],pingSpecificParameters:["abt","aml","ask","c","ed","flpc","ph","pu","sdk","vcb","vck","vpb"],pingDestination:"main"},"vci-clienta":{code:"vci",bucket:"clienta",parameterGroups:["adSessionParamsOnly","sessionParamsOnly"],pingSpecificParameters:["abt","aml","ask","c","ed","flpc","ph","pu","sdk","vcb","vck","vpb"],pingDestination:"main"},"vi-clienta":{code:"vi",bucket:"clienta",parameterGroups:["global","adGlobal"],pingSpecificParameters:["fed"],pingDestination:"main"},"vqc-jwplayer6":{code:"vqc",bucket:"jwplayer6",parameterGroups:["global"],pingSpecificParameters:["abm","avc","bwe","qcr","sbr","tb","vw","vh"],filters:["missingMediaOrExternalID"],pingDestination:"main"},"vs-jwplayer6":{code:"vs",bucket:"jwplayer6",parameterGroups:["global"],pingSpecificParameters:["cvl","sdt","tvl","vso"],filters:["missingMediaOrExternalID"],pingDestination:"main"},"vsh-jwplayer6":{code:"vsh",bucket:"jwplayer6",parameterGroups:["global"],pingSpecificParameters:["pcp","srf","stg"],filters:["missingMediaOrExternalID"],pingDestination:"main"},"xapi-jwplayer6":{code:"xapi",bucket:"jwplayer6",parameterGroups:["sessionParamsOnly"],pingSpecificParameters:["ed","prs","pid","ph","sdk","sv","xam","xfmp"],filters:["missingMediaOrExternalID"],pingDestination:"meta"}},paramGroups:{global:{members:["abc","abt","aid","amp","ask","at","bun","c","ccp","cp","d","eb","ed","eid","emi","i","id","idp","jwac","lid","lsa","mt","om","pbd","pbr","pei","pgi","ph","pid","pii","pl","plc","pli","pp","ppm","prc","ps","pss","pt","pu","pv","pyc","s","sdk","so","ss","stc","stpe","sv","t","tul","tv","vb","vi","vl","wd","xav","xid"],groupName:"global"},adGlobal:{members:["ab","abid","abo","adi","apid","awi","awc","p","pc","pi","pr","sko","tmid","vu"],groupName:"adGlobal"},adSessionParamsOnly:{members:["abid","apid"],groupName:"adSessionParamsOnly"},sessionParamsOnly:{members:["aid","emi","id","pli","pv","tv","xav","xid"],groupName:"sessionParamsOnly"},headerBidding:{members:["afbb","afbi","afbp","afbt","afbw","aml","asxb","asxi","asxp","asxt","asxw","flpc","flpy","frid","hbec","vpb","vto"],groupName:"headerBidding"},placement:{members:["aid","lid","om","pgi","plv","pt","pu","tv"],groupName:"placement"}},parameters:{ad:{priority:1},add:{priority:2},adid:{priority:1},adt:{priority:1},adv:{priority:1},advi:{priority:1},aem:{priority:1},amu:{priority:2},atu:{priority:1},caid:{priority:1},cdid:{priority:1},cid:{priority:1},mu:{priority:1},opu:{priority:1},pt:{priority:1},pu:{priority:1},rf:{priority:1},srf:{priority:1},t:{priority:1},tpi:{priority:1},tul:{priority:1},uav:{priority:1},vu:{priority:2}}},me={sgB1CN8sEeW9HgpVuA4vVw:!1,"QHh6WglVEeWjwQp+lcGdIw":!0,"4lTGrhE9EeWepAp+lcGdIw":!0,"98DmWsGzEeSdAQ4AfQhyIQ":!0,"xNaEVFs+Eea6EAY3v_uBow":!0,KvvTdq_lEeSqTw4AfQhyIQ:!1},ve=1;function ge(e,a){var t,n,r,i,o,d,l,c;for(t=3&e.length,n=e.length-t,r=a,o=3432918353,d=461845907,c=0;c<n;)l=255&e.charCodeAt(c)|(255&e.charCodeAt(++c))<<8|(255&e.charCodeAt(++c))<<16|(255&e.charCodeAt(++c))<<24,++c,r=27492+(65535&(i=5*(65535&(r=(r^=l=(65535&(l=(l=(65535&l)*o+(((l>>>16)*o&65535)<<16)&4294967295)<<15|l>>>17))*d+(((l>>>16)*d&65535)<<16)&4294967295)<<13|r>>>19))+((5*(r>>>16)&65535)<<16)&4294967295))+((58964+(i>>>16)&65535)<<16);switch(l=0,t){case 3:l^=(255&e.charCodeAt(c+2))<<16;case 2:l^=(255&e.charCodeAt(c+1))<<8;case 1:r^=l=(65535&(l=(l=(65535&(l^=255&e.charCodeAt(c)))*o+(((l>>>16)*o&65535)<<16)&4294967295)<<15|l>>>17))*d+(((l>>>16)*d&65535)<<16)&4294967295}return r^=e.length,r=2246822507*(65535&(r^=r>>>16))+((2246822507*(r>>>16)&65535)<<16)&4294967295,r=3266489909*(65535&(r^=r>>>13))+((3266489909*(r>>>16)&65535)<<16)&4294967295,(r^=r>>>16)>>>0}function ye(e){return ke(e,"feedid")}function be(e){return ke(e,"feed_instance_id")}function he(e){return e?e.pin_set_id:null}function ke(e,a){return e?(e.feedData||{})[a]||e[a]:null}function De(e){if(!e)return null;var a,t,n=e.mediaid;return i(n)?n:(a=e.file,i(n=(t=/.*\/(?:manifests|videos)\/([a-zA-Z0-9]{8})[\.-].*/.exec(a))&&2===t.length?t[1]:null)?n:null)}function we(e){return e?e.title:null}function Ie(e){return e?!(!e.images||!e.images.length)&&!!e.images.filter(function(e){return e.type&&e.type.match(/video/)}).length:null}function Se(e,a){var t=void 0;me[e.accountData.analyticsID]&&(t=function(e,a){var t=we(a);if(t)return function(e,a){e.meta.xidAlgorithmVersion=1;var t=ge(a,ve),n=ge(a+a,ve);return"01_"+t+n}(e,t)}(e,a));var n=t||a.externalId;(e.playlistItemData.externalId=n)&&!e.meta.xidAlgorithmVersion&&(e.meta.xidAlgorithmVersion=0)}var Te="hidden"in document?function(){return!document.hidden}:"webkitHidden"in document?function(){return!document.webkitHidden}:function(){return!0};function Pe(e,a){var t=" "+a+" ";return 1===e.nodeType&&0<=(" "+e.className+" ").replace(/[\t\r\n\f]/g," ").indexOf(t)}var Ee=1,Ce=2,Ae=3,xe=4,je=5,Re=0;var Be=[$,Z];function Ve(e,a,t){var n=e.external&&e.external.playerAPI;if(n){var r=n.getConfig();e.playerData.playerConfig={visibility:r.visibility,bandwidthEstimate:r.bandwidthEstimate,floatingState:!!r.isFloating};var i,o,d,l=f(n)||{};e.playlistItemData.item=l,e.playlistItemData.mediaId=De(l),e.playerData.playerSize=function(e){var a=e.getConfig(),t=a.containerWidth||e.getWidth(),n=a.containerHeight||e.getHeight();if(/\d+%/.test(t)){var r=e.utils.bounds(e.getContainer());t=r.width,n=r.height}return t=0|Math.round(t),n=0|Math.round(n),/\d+%/.test(a.width||t)&&a.aspectratio?{bucket:xe,width:t,height:n}:Pe(e.getContainer(),"jw-flag-audio-player")?{bucket:je,width:t,height:n}:0===t?{bucket:Re,width:t,height:n}:t<=320?{bucket:Ee,width:t,height:n}:t<=640?{bucket:Ce,width:t,height:n}:{bucket:Ae,width:t,height:n}}(n),e.playlistItemData.duration=D(e),e.meta.lastEvent=a,e.meta.lastBucket=t,e.playerData.visualQuality=N(n,"s"===a&&"jwplayer6"===t),e.playerData.defaultPlaybackRate=r.defaultPlaybackRate,e.playerData.playbackMode=r.streamType,Se(e,l),i=e,o=a,d=t,-1===Be.indexOf(o)&&(i.meta.eventPreAbandonment=c(o,d))}}var Me={prs:function(e){return e.meta.playerState},lae:function(e){return e.meta.eventPreAbandonment},abpr:function(e){return e.meta.playerRemoved},prsd:function(e){var a=Date.now()-e.meta.playerStateDuration;return a<=216e5?a:-1}},Le={ab:function(e){return e.configData.advertisingBlockType},abo:function(e){return e.ads.adEventData.offset},adi:function(e){return e.ads.adEventData.adId},apid:function(e){return e.ads.adEventData.adPlayId},abid:function(e){return e.ads.adEventData.adBreakId},awi:function(e){return e.ads.adEventData.witem},awc:function(e){return e.ads.adEventData.wcount},p:function(e){return e.ads.adEventData.adposition},sko:function(e){return e.ads.adEventData.skipoffset},vu:function(e){return e.ads.adEventData.tagdomain},tmid:function(e){return e.ads.adEventData.targetMediaId}},Ge={cae:function(e){return!!e.ads.advertisingConfig.companiondiv},ad:function(e){return e.ads.adEventData.adSystem},adc:function(e){var a=e.ads.adEventData,t=null;return Array.isArray(a.categories)&&(t=a.categories.map(function(e){var a=e.match(S);return a?[g.IAB,a[1]].join("-"):g.UNKNOWN}).filter(function(e,a,t){return t.indexOf(e)===a}).slice(0,10).join(",")||null),t},al:function(e){return e.ads.adEventData.linear},ct:function(e){return e.ads.adEventData.adCreativeType},mfc:function(e){return e.ads.adEventData.mediaFileCompliance},pc:function(e){return e.ads.adEventData.podCount},pi:function(e){return e.ads.adEventData.podIndex},tal:function(e){return e.ads.adEventData.timeAdLoading},vv:function(e){return e.ads.adEventData.vastVersion},uav:function(e){return e.ads.adEventData.universalAdId},advti:function(e){return e.ads.adPlaybackTracking.viewablePlayedSeconds},adati:function(e){return e.ads.adPlaybackTracking.audiblePlayedSeconds},adti:function(e){return e.ads.adPlaybackTracking.playedSeconds},atps:function(e){return e.ads.watchedPastSkipPoint},du:function(e){return e.ads.adEventData.duration},qt:function(e){var a=e.meta.lastEvent;return"s"===a||"c"===a?e.ads.adEventData.previousQuartile:e.ads.currentQuartile},tw:function(e){return e.ads.adEventData.position},aec:function(e){return e.ads.jwAdErrorCode},aem:function(e){return e.ads.errorMessage},ato:function(e){return e.ads.timeout},ec:function(e){return e.playerData.lastErrorCode[e.meta.lastEvent]},atu:function(e){var a=e.ads.adEventData.tagURL;return"string"==typeof a?a.substr(0,100):void 0},tpi:function(e){var a=e.ads.adEventData.jwpseg;return Array.isArray(a)?a.join(","):void 0},cid:function(e){return e.ads.adEventData.creativeId},adt:function(e){return e.ads.adEventData.adTitle},apr:function(e){return e.ads.adEventData.preload},amu:function(e){return e.ads.adEventData.adMediaFileURL},add:function(e){return e.ads.adEventData.description},adid:function(e){return e.ads.adEventData.adVastId},caid:function(e){return e.ads.adEventData.creativeAdId},apt:function(e){return e.ads.adEventData.placement},tfvc:function(e){return e.ads.adEventData.timeForVPBCache},adv:function(e){return e.ads.adEventData.advertiser},advi:function(e){return e.ads.adEventData.advertiserId},afbb:function(e){return p(e.ads.headerBiddingData.bidders,"fan.result")},afbi:function(e){return p(e.ads.headerBiddingData.bidders,"fan.id")},afbp:function(e){return p(e.ads.headerBiddingData.bidders,"fan.priceInCents")},afbt:function(e){return p(e.ads.headerBiddingData.bidders,"fan.timeForBidResponse")},afbw:function(e){return p(e.ads.headerBiddingData.bidders,"fan.winner")},frid:function(e){return p(e.ads.headerBiddingData.bidders,"fan.requestId")},asxb:function(e){return p(e.ads.headerBiddingData.bidders,"spotx.result")},asxi:function(e){return p(e.ads.headerBiddingData.bidders,"spotx.id")},asxp:function(e){return p(e.ads.headerBiddingData.bidders,"spotx.priceInCents")},asxt:function(e){return p(e.ads.headerBiddingData.bidders,"spotx.timeForBidResponse")},asxw:function(e){return p(e.ads.headerBiddingData.bidders,"spotx.winner")},aml:function(e){return e.ads.headerBiddingData.mediationLayer},flpc:function(e){return e.ads.headerBiddingData.floorPriceCents},flpy:function(e){return e.ads.headerBiddingData.floorPriceCurrency},hbec:function(e){return e.ads.headerBiddingData.errorCode},vto:function(e){return e.ads.headerBiddingData.bidTimeout},vpb:function(e){if("object"==typeof e.ads.headerBiddingData.bidders)return l(e.ads.headerBiddingData.bidders)},vcb:function(e){return e.ads.headerBiddingCacheData.bidder},vck:function(e){return e.ads.headerBiddingCacheData.cacheKey},rtp:function(n){if("object"==typeof n.inference.result){var e=l(["predictions","segments"].reduce(function(e,a){var t=p(n.inference.result,a);return void 0!==t&&(e[a]=t),e},{})),a=p(n.inference.result,"decisionThresholds");return"object"==typeof a&&(Object.keys(a).forEach(function(e){var t=a[e]||{};Object.keys(t).forEach(function(a){var e=t[a]||{};Object.keys(e).forEach(function(e){t[a][e]=Number(t[a][e].toFixed(2))})}),a[e]=t}),e.decisionThresholds=a),e}},did:function(e){return e.ads.adEventData.dealId},iu:function(e){var a=e.ads.adEventData.tagURL;if(a){var t=a.match(R);if(t)return t[1]}}};Ge.vsrid=function(e){return(ke(e.playlistItemData.item,"jwpseg")||{}).request_id||null};var Oe={dnt:function(e){return e.browser.storage.doNotTrackProperty},fv:function(e){return e.browser.pageData.flashVersion},lng:function(e){return e.browser.langAttr},pdr:function(e){return e.browser.docReferrer}};Oe.plt=function(e){return function(){var e=((0<arguments.length&&void 0!==arguments[0]?arguments[0]:window).performance||{}).timing;if(e){var a=(e.loadEventEnd||(new Date).getTime())-e.navigationStart;if(0<a)return 50*Math.round(a/50)|0}return null}()},Oe.sp=function(e){return e.browser.isPageStandalone};var Ne={cb:function(e){return e.configData.castingBlockPresent},dd:function(e){return e.configData.displayDescription},ga:function(e){return e.configData.gaBlockPresent},pad:function(e){return e.configData.abTestConfig},pbc:function(e){return e.configData.playbackRateControlsSet},po:function(e){return e.configData.posterImagePresent},rf:function(e){return e.configData.relatedPluginFeedFile},sn:function(e){return e.configData.skinName}},qe=[Y,$,X,J],Fe={fed:function(e){return-1!==qe.indexOf(e.meta.lastEvent)?e.related.feedId:ye(e.playlistItemData.item)},fid:function(e){return-1!==qe.indexOf(e.meta.lastEvent)?e.related.feedInstanceId:be(e.playlistItemData.item)},ft:function(e){return e.related.feedType},os:function(e){return e.related.onClickSetting},fin:function(e){return e.related.feedInterface},fis:function(e){return e.related.idsShown.join(",")},fns:function(e){return e.related.idsShown.length},fpc:function(e){return e.related.pinnedCount},fpg:function(e){return e.related.page},fsr:function(e){return e.related.shownReason},rat:function(e){return e.related.autotimerLength},fct:function(e){return e.related.advanceTarget},oc:function(e){return e.related.ordinalClicked},stid:function(e){return e.related.targetThumbID},tis:function(e){return e.related.thumbnailIdsShown.join(",")||void 0},fsid:function(e){return e.related.feedShownId},vfi:function(e){return e.related.feedWasViewable},ovt:function(e){return e.related.overlayVideoThumbs},cme:function(e){return e.playerData.contextualEmbed},pogt:function(e){return e.browser.pageData.pageOGTitle}},Ue={abc:function(e){var a=e.ads.adBreakTracking;if(a)return a.adBreakCount},abt:function(e){var a=e.external.playerAPI.getConfig(),t=a.ab;if(t&&t.tests)return Object.keys(t.tests).map(function(e){return t.getSelected(e,a).join(",")}).filter(function(e){return e}).join(",")},aid:function(e){return e.accountData.analyticsID},ask:function(e){return e.ads.adScheduleId},at:function(e){return Te()},c:function(e){return e.ads.adClient},ccp:function(e){return e.casting},cp:function(e){return!e.external.playerAPI.getControls()},d:function(e){return e.configData.autostartConfig},eb:function(e){return(a=e.external.playerAPI).getAdBlock?a.getAdBlock():-1;var a},ed:function(e){return e.accountData.edition},emi:function(e){return e.staticPlayerData.embedID},i:function(e){return e.browser.pageData.inIframe},id:function(e){return e.playlistItemData.mediaId},lid:function(e){return e.meta.doNotPingBackIDs?void 0:e.browser.storage.localID},lsa:function(e){return e.browser.storage.storageAvailable},mt:function(e){return e.external.playerAPI.getMute()},mu:function(e){return function(e,a){var t=void 0;if(!e)return null;var n=e.sources;if(n){for(var r=[],i=n.length;i--;)n[i].file&&r.push(n[i].file);r.sort(),t=r[0]}else t=e.file;return a.getAbsolutePath(t)}(e.playlistItemData.item,e.external.utils)},pbd:function(e){return e.playerData.defaultPlaybackRate}};Ue.pbr=function(e){return(a=e.external.playerAPI).getPlaybackRate?Math.round(100*a.getPlaybackRate())/100:1;var a},Ue.pgi=function(e){return e.browser.pageData.pageViewId},Ue[ne]=function(e){return e.configData.playerHosting},Ue.pid=function(e){return e.configData.playerConfigKey},Ue.pii=function(e){return e.playlistItemData.index},Ue.pl=function(e){return e.playerData.playerSize.height},Ue.plc=function(e){return e.external.playerAPI.getPlaylist().length},Ue.pli=function(e){return e.playlistItemData.itemId},Ue.pp=function(e){return m(e.external.playerAPI)},Ue.prc=function(e){return function(){var e=window.jwplayer,a=0;if("function"==typeof e)for(a=0;a<1e3;a++)if(!e(a).uniqueId)return a;return a}()},Ue.ps=function(e){return e.playerData.playerSize.bucket},Ue.pss=function(e){return e.meta.playbackTracking.playSessionSequence},Ue.pt=function(e){return e.browser.pageData.pageTitle},Ue.pu=function(e){return e.browser.pageData.pageURL},Ue.pv=function(e){return e.staticPlayerData.playerVersion},Ue.pyc=function(e){return e.meta.playbackTracking.playItemCount},Ue.s=function(e){return e.configData.sharingEnabled},Ue.sdk=function(e){return e.staticPlayerData.sdkPlatform},Ue.stc=function(e){return e.meta.setupCount},Ue.sv=function(e){return e.staticPlayerData.sdkVersion},Ue.bun=function(e){return e.staticPlayerData.bundleId},Ue.ifa=function(e){return e.meta.doNotPingBackIDs?void 0:e.staticPlayerData.advertisingId},Ue.om=function(e){return e.staticPlayerData?e.staticPlayerData.deviceModel:void 0},Ue.t=function(e){return we(e.playlistItemData.item)},Ue.tul=function(e){return e.playlistItemData.item.thumbnailUrl},Ue.tv=function(e){return"4.0.3"},Ue.vb=function(e){return e.playerData.viewable},Ue.vi=function(e){var a=e.playerData.playerConfig.visibility;return void 0===a?a:Math.round(100*a)/100},Ue.vl=function(e){return e.external.playerAPI.getVolume()},Ue.wd=function(e){return e.playerData.playerSize.width},Ue.xid=function(e){return e.playlistItemData.externalId},Ue.xav=function(e){return e.meta.xidAlgorithmVersion},Ue.stpe=function(e){return!!e.meta.playbackTracking.sendSetTimeEvents},Ue.ppm=function(e){return e.playerData.playbackMode},Ue.strt=function(e){var a=e.playerData.startup;return e.meta.lastEvent===a.dispatchEvent?a.startupTime:void 0},Ue.tstc=function(e){return e.browser.pageData.testCaseId},Ue.fsm=function(e){return e.external.playerAPI.getFullscreen()},Ue.dpl=function(e){},Ue.ss=function(e){return e.meta.sessionSampled||void 0},Ue.amp=function(e){return e.browser.pageData.amp},Ue.jwac=function(e){return e.browser.pageData.jwAmpComponent||void 0},Ue.opu=function(e){return e.browser.pageData.origPageURL};var _e={};_e.pei=function(e){return e.placementData.embedId},_e.eid=function(e){return e.placementData.evaluationId},_e.idp=function(e){return e.placementData.placementId},_e.so=function(e){return e.placementData.strategyId},_e.tid=function(e){return e.placementData.triggerId},_e.plv=function(e){return e.placementData.version};var Qe={aes:1,widevine:2,playready:3,fairplay:4};var ze={interaction:1,autostart:2,repeat:3,external:4,"related-interaction":1,"related-auto":5,playlist:6,viewable:7};var Ke={none:1,metadata:2,auto:3};function We(e){return e===1/0?1/0:(e|=0)<=0?0:e<30?1:e<60?4:e<180?8:e<300?16:32}function He(e){try{return e.external.playerAPI.qoe().item.sums.stalled||0}catch(e){return 0}}var $e=Math.round,Je={};Je.st=function(e){return e.playerData.setupTime},Je.bwe=function(e){return d(e.playerData.playerConfig.bandwidthEstimate)},Je.cct=function(e){return a=e.playlistItemData.item,t=e.external.playerAPI,Array.prototype.some.call(a.tracks||0,function(e){var a=e.kind;return"captions"===a||"subtitles"===a})?1:1<t.getCaptionsList().length?2:0;var a,t},Je.ch=function(e){return function(e){if(e.chapters)return 2;var a=e.tracks;return a&&a.length&&Array.prototype.some.call(a,function(e){return"chapters"===e.kind})?1:0}(e.playlistItemData.item)},Je.drm=function(e){return((a=e.playlistItemData.drm)?Qe[a]||999:0)||e.meta.playbackTracking.segmentsEncrypted;var a},Je.ff=function(e){return"function"==typeof(a=e.external.playerAPI).qoe?10*Math.round(a.qoe().firstFrame/10)|0:-1;var a},Je.l=function(e){return a=e.playlistItemData.duration,(a|=0)<=0||a===1/0?0:a<15?1:a<=300?2:a<=1200?3:4;var a},Je.vr=function(e){return function(e){if(e.getPlugin){var a=e.getPlugin("vr");if(a)switch(a.getMode()){case"magic-window":return 0;case"cardboard":return 1;case"gear-vr":return 2;default:return null}}return null}(e.external.playerAPI)},Je.etw=function(e){return e.meta.playbackTracking.retTimeWatched},Je.ubc=function(e){return $e(He(e))},Je.ltc=function(e){return $e(function(e){try{return e.external.playerAPI.qoe().item.sums.loading||0}catch(e){return 0}}(e))},Je.ubi=function(e){return $e(function(e,a){void 0===a&&(a=e.meta.lastEvent);var t=He(e),n=e.meta.previousBufferTimes[a];void 0===e.meta.previousBufferTimes[a]&&(n=e.meta.previousBufferTimes[a]=t);var r=Math.round(t-n);return e.meta.previousBufferTimes[a]=t,r}(e))},Je.pw=function(e){return 0|e.meta.playbackTracking.normalizedTime},Je.ti=function(e){return e.meta.playbackTracking.elapsedSeconds},Je.vti=function(e){return e.meta.playbackTracking.viewableElapsedSeconds},Je.ati=function(e){return e.meta.playbackTracking.audibleElapsedSeconds},Je.cvl=function(e){return Math.floor(e.meta.seekTracking.videoStartDragTime)},Je.tvl=function(e){return Math.floor(e.meta.seekTracking.lastTargetTime)},Je.sdt=function(e){return 1===e.meta.seekTracking.numTrackedSeeks?0:Date.now()-e.meta.seekTracking.dragStartTime},Je.vso=function(e){return Math.floor(e.meta.seekTracking.lastTargetTime)-Math.floor(e.meta.seekTracking.videoStartDragTime)},Je.qcr=function(e){return e.playerData.visualQuality.reason},Je.abm=function(e){return e.playerData.visualQuality.adaptiveBitrateMode},Je.avc=function(e){return e.playerData.numAutoVisualQualityChange},Je.ppr=function(e){return e.meta.playbackTracking.prevPlaybackRate},Je.erc=function(e){return e.playerData.lastErrorCode[e.meta.lastEvent]},Je.pcp=function(e){return $e(e.meta.playbackTracking.currentPosition)},Je.stg=function(e){return e.sharing.shareMethod},Je.tps=function(e){return $e(e.meta.playbackTracking.playedSecondsTotal)},Je.srf=function(e){return e.sharing.shareReferrer},Je.plng=function(e){return e.playerData.localization.language},Je.pni=function(e){return e.playerData.localization.numIntlKeys},Je.pnl=function(e){return e.playerData.localization.numLocalKeys},Je.pbs=function(e){try{return e.external.playerAPI.qoe().item.counts.stalled||0}catch(e){return null}},Je.tc=function(e){return e.meta.playbackTracking.thresholdCrossed},Je.flc=function(e){return e.playerData.floatingConfigured},Je.fls=function(e){return e.playerData.playerConfig.floatingState},Je.xam=function(e){return e.playerData.apiTracking.methodCalled},Je.xfmp=function(e){return e.playerData.apiTracking.firstMeaningfulParam},Je.dle=function(e){return e.meta.playbackTracking.latency},Je.cdid=function(e){return e.external.playerAPI.id},Je.pcfg=function(e){return e.playerData.stringifiedSetupConfig},Je.pvta=function(e){return e.meta.playbackTracking.posterVideoThumbAnimated},Je.ovta=function(e){return e.meta.playbackTracking.overlayVideoThumbAnimated},Je.pvt=function(e){return e.meta.playbackTracking.posterVideoThumbnail||void 0},Je.ipv=function(e){return e.playerData.inferencePluginVersion},Je.bpv=function(e){return e.playerData.biddingPluginVersion},Je.pdt=function(e){var a=e.meta.playbackTracking.programDateTime;return e.meta.playbackTracking.programDateTime=void 0,a},Je.cst=function(e){var a=e.meta.playbackTracking.cueStartTime;return e.meta.playbackTracking.cueStartTime=void 0,a},Je.iacid=function(e){return e.interactive.cueId},Je.iaelid=function(e){return e.interactive.elementId},Je.iaeln=function(e){return e.interactive.elementName},Je.iaeid=function(e){return e.interactive.eventId},Je.iae=function(e){return e.interactive.eventName},Je.iapid=function(e){return e.interactive.projectId},Je.iapn=function(e){return e.interactive.projectName},Je.iat=function(e){return e.interactive.interactionType},Je.iapv=function(e){return e.interactive.projectVersion};var Xe=t,Ye=a,Ze={mk:function(e){return function(e,a){if(!e)return null;var t=e.sources[0],n=t.type;if(!n){var r=t.file;n=a.extension(r)}return n}(e.playlistItemData.item,e.external.utils)}};Ze.pd=function(e){return a=e.playlistItemData.item,t=a.preload,Ke[t]||0;var a,t},Ze.vrt=function(e){return function(e){if(!e||!e.stereomode)return null;switch(e.stereomode){case"monoscopic":return 0;case"stereoscopicTopBottom":return 1;case"stereoscopicLeftRight":return 2;default:return null}}(e.playlistItemData.item)},Ze.pr=function(e){return a=e.playlistItemData.playReason,ze[a]||0;var a},Ze.psd=function(e){return-1!==qe.indexOf(e.meta.lastEvent)?e.related.pinSetId:he(e.playlistItemData.item)},Ze.vh=function(e){return e.playerData.visualQuality.height},Ze.vw=function(e){return e.playerData.visualQuality.width},Ze.sbr=function(e){return e.playerData.visualQuality.bitrate},Ze.tb=function(e){return function(e){var a=e.getContainer().querySelector("video"),t=0;if(a&&(t=a.duration,a.buffered&&a.buffered.length)){var n=a.buffered.end(a.buffered.length-1)||0;return Math.round(10*n)/10}return t||(t=Math.abs(e.getDuration())),Math.round(t*e.getBuffer()/10)/10}(e.external.playerAPI)},Ze.vd=function(e){return e.playlistItemData.duration},Ze.q=function(e){return We(e.playlistItemData.duration)},Ze.tt=function(e){return a=e.playlistItemData.item,t=a.tracks,Array.prototype.some.call(t||0,function(e){return"thumbnails"===e.kind});var a,t},Ze.vs=function(e){var a=e.meta.playbackEvents;return function(e,a,t){var n=3<arguments.length&&void 0!==arguments[3]?arguments[3]:{};if(!a)return null;if(t&&t.levels&&t.levels.length){var r=t.levels[0];if(r&&"auto"===(""+r.label).toLowerCase())return 5}if(Pe(e.getContainer(),"jw-flag-audio-player"))return 6;var i=0|n.width,o=0|n.height;return 0!==i||0!==o?i<=320?1:i<=640?2:i<=1280?3:4:"rtmp"===a.sources[0].type?6:0}(e.external.playerAPI,e.playlistItemData.item,a[Xe],a[Ye])},Ze.ptid=function(e){return p(e.playlistItemData.item,"variations.selected.images.id")};var ea=G({},Ue,Ne,Oe,Ze,Je,Fe,Le,Ge,Me,_e);function aa(e,i){var a=fe.events[e],t=a.parameterGroups.reduce(function(e,a){return e.concat(fe.paramGroups[a].members)},[]).concat(a.pingSpecificParameters?a.pingSpecificParameters:[]).reduce(function(e,a){var t,n,r;return e[a]=(n=i,r=ea[t=a]?ea[t]:function(){n.meta.debug&&console.log("No parameter generation function for param "+t)},{code:t,value:r(n)}),e},{});return{event:a.code,bucket:a.bucket,parameters:t,pingDestination:a.pingDestination}}var ta={missingMediaOrExternalID:function(e){return!e.meta.sessionSampled&&(!e.playlistItemData.mediaId&&!e.playlistItemData.externalId)},missingAdScheduleID:function(e){return!e.meta.sessionSampled&&!e.ads.adScheduleId},missingFeedID:function(e){return!e.related.feedId}};var na=function(e,a){if(!(e instanceof a))throw new TypeError("Cannot call a class as a function")},ra=function(){function n(e,a){for(var t=0;t<a.length;t++){var n=a[t];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(e,a,t){return a&&n(e.prototype,a),t&&n(e,t),e}}(),ia={main:"prd.jwpltx.com/v1",main_fallback:"ping-origin-prd.jwpltx.com/v1",meta:"ping-meta-prd.jwpltx.com/v1",placement:"placement-prd.jwpltx.com/v1"},oa=function(){function r(e,a,t,n){na(this,r),this.event=e,this.bucket=a,this.host=n,this.paramData=G({},t),ie in this.paramData||(this.paramData[ie]={code:ie,value:e}),re in this.paramData||(this.paramData[re]={code:re,value:Math.random().toFixed(16).substr(2,16)})}return ra(r,[{key:"path",get:function(){return this.host+"/"+this.bucket+"/ping.gif"}},{key:"url",get:function(){return this.protocol+"//"+this.path+"?"+this.queryString}},{key:"encodedParameters",get:function(){var r=this;return Object.keys(this.paramData).reduce(function(e,a){var t=r.paramData[a],n=da(t);return null!==n&&(e[t.code]=n),e},{})}},{key:"trackingArgs",get:function(){var a=this.encodedParameters,t=Object.keys(a);return[re,ie].forEach(function(e){var a=t.indexOf(e);-1!==a&&(t.splice(a,1),t.unshift(e))}),t.map(function(e){return a[e]})}},{key:"protocol",get:function(){return"file:"===window.location.protocol?"https:":""}},{key:"queryString",get:function(){var e=this.trackingArgs.join("&"),a="h="+function(e){var a=0;if(!(e=decodeURIComponent(e)).length)return a;for(var t=0;t<e.length;t++)a=(a<<5)-a+e.charCodeAt(t),a&=a;return a}(e)+"&"+e,t=void 0;try{t=Date.now()}catch(e){}return a+"&sa="+t}}]),r}(),da=function(e){var a=e.value;return!0!==a&&!1!==a||(a=a?"1":"0"),a&&"object"==typeof a&&(a=JSON.stringify(a)),null!=a?e.code+"="+encodeURIComponent(a):null},la=["rtp"],ca=function(e){return e.paramData.tp={code:"tp",value:1},A(e.url)},ua=function(e,a,t,n){var r=A("&tp=1"),i=new oa(e,a,t,ia[n]),o=A(i.url);if(o<=8192)return i.url;var d=fe.parameters,l=Object.keys(d).filter(function(e){var a=d[e].priority;return 0<a||a<0}).filter(function(e){return e in i.paramData}).filter(function(e){return"string"==typeof i.paramData[e].value}).sort(function(e,a){return d[a].priority-d[e].priority}),c=la,u=Array.isArray(c),s=0;for(c=u?c:c[Symbol.iterator]();;){var p;if(u){if(s>=c.length)break;p=c[s++]}else{if((s=c.next()).done)break;p=s.value}if("rtp"===p&&p in i.paramData&&(delete i.paramData.rtp.value.decisionThresholds,(o=ca(i))<=8192))return i.url}var f=l,m=Array.isArray(f),v=0;for(f=m?f:f[Symbol.iterator]();;){var g;if(m){if(v>=f.length)break;g=f[v++]}else{if((v=f.next()).done)break;g=v.value}var y=g;if(i.paramData[y]){var b=o-8192+("tp"in i.paramData?0:r),h=i.paramData[y],k=da(h),D=k?A(k):0;if(delete i.paramData[y],D<=b)o=ca(i);else{for(var w={code:y,value:h.value},I=D-b,S=Math.max(20,Math.floor(w.value.length/10)),T=Math.ceil(w.value.length/S),P=1;P<=T;P++){var E=-S*P;w.value=w.value.slice(0,E);var C=A(da(w));if(0<w.value.length&&C<I){i.paramData[y]=w;break}}if((o=ca(i))<=8192)return i.url}}}return"main"===n&&(i.host=ia.main_fallback),i.url},sa=function(e){e.trackingState.pageLoaded=!0;for(var a=e.trackingState.queue.length;a--;)ma(e,e.trackingState.queue.shift());window.removeEventListener("load",e.trackingState.boundFlushQueue)};function pa(e){var a,t,n=e.external&&e.external.playerAPI,r="complete"===((t=(a=n)&&a.getContainer&&a.getContainer())&&t.ownerDocument||window.document).readyState;(e.trackingState.pageLoaded=r)||(e.trackingState.boundFlushQueue=sa.bind(null,e),window.addEventListener&&window.addEventListener("load",e.trackingState.boundFlushQueue),setTimeout(e.trackingState.boundFlushQueue,5e3))}function fa(e,a){var t=a.event,n=a.bucket,r=a.parameters,i=a.pingDestination,o=ua(t,n,r,i),d=!e.trackingState.pageLoaded;if(d&&(t===oe||t===le||t===de))sa(e);else if(d)return void e.trackingState.queue.push(o);ma(e,o)}function ma(e,a){var t=new Image;t.src=a;for(var n=e.trackingState.images,r=n.length;r--&&(n[r].width||n[r].complete);)n.length=r;if(n.push(t),e.meta.debug&&e.trackingState.onping)try{e.trackingState.onping.call(null,a)}catch(e){}}var va={delaySend:!1,returnURL:!1};function ga(t,e){var a=2<arguments.length&&void 0!==arguments[2]?arguments[2]:"jwplayer6",n=3<arguments.length&&void 0!==arguments[3]?arguments[3]:{};n=G({},va,n),Ve(t,e,a);var r=c(e,a),i=fe.events[r];if(i&&!(i.filters||[]).map(function(e){return a=t,ta[e](a);var a}).some(function(e){return!!e})){var o=aa(r,t);return n.delaySend?fa.bind(null,t,o):n.returnURL?ua(o.event,o.bucket,o.parameters,o.pingDestination):void fa(t,o)}}function ya(e){if(!e.bidders)return{};var r={},i=void 0;e.bidders.forEach(function(e){var t,n,a=e.name;r[a.toLowerCase()]=(t=e,n={},j.forEach(function(e){var a;"result"===e?n.result=w[t[e]]:G(n,void 0!==t[e]?((a={})[e]=t[e],a):void 0),t.code&&-1!==["error","invalid"].indexOf(t.result)&&(n.errorCode=t.code)}),n),e.errorCode&&!i&&(i=e.errorCode)});var a=e.floorPriceCurrency;return G({mediationLayer:x[e.mediationLayerAdServer],floorPriceCents:e.floorPriceCents,bidders:r,bidTimeout:e.bidTimeout},void 0!==i?{errorCode:i}:void 0,a?{floorPriceCurrency:a}:void 0)}function ba(t,e){var n=t.ads.adEventData;-1===t.ads.adClient&&e&&(t.ads.adClient=O(e.client)),e.sequence!==n.podIndex&&(delete n.timeAdLoading,delete n.adCreativeType),ha(n,e,"offset"),ha(n,e,"witem"),ha(n,e,"wcount"),ha(n,e,"skipoffset"),ha(n,e,"linear",function(e,a){return a===e}),ha(n,e,"adposition",function(e,a){return{pre:0,mid:1,post:2,api:3}[a]}),ha(n,e,"creativetype",function(e,a){var t="";switch(a){case"static":t="image/unknown";break;case"video":t="video/unknown";break;case"vpaid":case"vpaid-swf":t="application/x-shockwave-flash";break;case"vpaid-js":t="application/javascript";break;default:t=a||t}return n.adCreativeType=t}),ha(n,e,"tag",function(e,a){return n.tagdomain=function(e){if(e){var a=e.match(new RegExp(/^[^/]*:\/\/\/?([^\/]*)/));if(a&&1<a.length)return a[1]}return""}(t.external.playerAPI.utils.getAbsolutePath(a)),a}),ha(n,e,"description"),ha(n,e,"creativeAdId"),ha(n,e,"placement"),ha(n,e,"advertiser"),ha(n,e,"advertiserId"),e.timeLoading&&(n.timeAdLoading=10*Math.round(e.timeLoading/10)),e.universalAdId?n.universalAdId=e.universalAdId.map(function(e){if("unknown"!==e.universalAdIdRegistry)return e.universalAdIdRegistry+"."+e.universalAdIdValue}).filter(function(e){return!!e}).join(","):delete n.universalAdId,n.mediaFileCompliance=e.mediaFileCompliance,n.categories=e.categories,n.adSystem=e.adsystem||n.adSystem,n.vastVersion=e.vastversion||n.vastVersion,n.podIndex=e.sequence||n.podIndex,n.podCount=e.podcount||n.podCount,n.tagURL=e.tag||n.tagURL||e.vmap,n.preload="boolean"==typeof e.preloadAds?e.preloadAds:n.preload,n.adPlayId=e.adPlayId||n.adPlayId,n.adBreakId=e.adBreakId||n.adBreakId,n.adVastId=e.adId||n.adVastId,n.duration=e.duration||n.duration,n.adTitle=e.adtitle||n.adTitle,n.jwpseg=e.jwpseg,n.timeForVPBCache=e.timeForVPBCache||n.timeForVPBCache,n.dealId=e.dealId||n.dealId;var a=void 0;if(a="googima"===e.client?(n.creativeId=p(e,"ima.ad.g.creativeId"),p(e,"ima.ad.g.mediaUrl")):(n.creativeId=p(e,"creativeId"),p(e,"mediafile.file")),n.adMediaFileURL="string"==typeof a?a.substring(0,2500):a,e.item){var r=De(e.item);n.targetMediaId=r!==t.playlistItemData.mediaId?r:null}t.ads.headerBiddingData=ya(e)}function ha(e,a,t){var n=3<arguments.length&&void 0!==arguments[3]?arguments[3]:ka;if(a.hasOwnProperty(t)){var r=n;e[t]=r(t,a[t])}}function ka(e,a){return a}function Da(e,a){e.meta.playerState!==a&&(e.meta.playerStateDuration=Date.now()),e.meta.playerState=a}function wa(e,a){null===e.previousTime&&(e.previousTime=a);var t=a-e.previousTime;return e.previousTime=a,t=Math.min(Math.max(0,t),4),e.playedSeconds=e.playedSeconds+t,t}function Ia(e,a){var t=e.ads.adEventData,n=e.ads.currentQuartile;n>t.previousQuartile&&(ba(e,a),ga(e,"v","clienta"),t.previousQuartile=n)}var Sa={adComplete:function(e,a){e.ads.currentQuartile=4,Ia(e,a)},adError:function(e,a){"object"==typeof a&&a&&(e.playerData.lastErrorCode.ae=a.code||1,e.ads.jwAdErrorCode=a.adErrorCode,51901===a.adErrorCode?e.ads.errorMessage="string"==typeof a.message?a.message.substring(0,100):void 0:e.ads.errorMessage=void 0,e.ads.timeout=a.timeout),ga(e,"ae","clienta")},adTime:function(e,a){var t=e.ads.adEventData,n=t.position=a.position;t.duration=t.duration||a.duration;var r=e.ads.adPlaybackTracking,i=e.ads.pingLimiters;!n||t.position>t.duration||(!function(e,a,t){var n=wa(a,t),r=e.ads.pingLimiters.visibleEvent.canSendPing(ue)||e.ads.pingLimiters.visibleEvent.canSendPing(ce);e.playerData.viewable&&(r&&(1===e.external.playerAPI.getConfig().visibility?(a.consecutiveVisibleSeconds+=n,a.totalVisibleSeconds+=n,a.maxConsecutiveVisibleSeconds=Math.max(a.maxConsecutiveVisibleSeconds,a.consecutiveVisibleSeconds)):(a.maxConsecutiveVisibleSeconds=Math.max(a.maxConsecutiveVisibleSeconds,a.consecutiveVisibleSeconds),a.consecutiveVisibleSeconds=0)),a.viewablePlayedSeconds=a.viewablePlayedSeconds+n);!e.playerData.muted&&0<e.playerData.volume&&(a.audiblePlayedSeconds=a.audiblePlayedSeconds+n)}(e,r,n),i.visibleEvent.canSendPing(ue)&&r.totalVisibleSeconds>=Math.floor(t.duration/2)&&(ga(e,ue,"clienta"),i.visibleEvent.setPingSent(ue)),i.visibleEvent.canSendPing(ce)&&2<=r.maxConsecutiveVisibleSeconds&&(ga(e,ce,"clienta"),i.visibleEvent.setPingSent(ce)),e.ads.currentQuartile=Math.min(3,Math.floor((4*t.position+.05)/t.duration)),Ia(e,a))},adSkipped:function(e,a){e.ads.watchedPastSkipPoint=a.watchedPastSkipPoint,ga(e,"s","clienta")},adImpression:function(e,a){v(e,oe);var t=e.ads.adPlaybackTracking;t.audiblePlayedSeconds=0,t.viewablePlayedSeconds=0,t.playedSeconds=0,t.previousTime=null,ga(e,oe,"clienta")},adBreakEnd:function(e,a){e.ads.adEventData=G({},F)}};function Ta(i){var e=i.external.playerAPI;e.on(C.join(" "),function(){Da(i,"ad-break"),i.ads.adBreakTracking&&i.ads.adBreakTracking.shouldTrack&&(i.ads.adBreakTracking.shouldTrack=!1,i.ads.adBreakTracking.adBreakCount++)}),e.on("adClick adRequest adMeta adImpression adComplete adSkipped adError adTime adBidRequest adBidResponse adStarted adLoaded adViewableImpression adBreakEnd",function(e){var a,t,n,r=i.ads.adEventData;a=r,"adClick"===(t=e).type||a&&a.adId===t.id&&-1!==t.id||(i.ads.adEventData=G({adId:e.id},F),i.ads.pingLimiters.visibleEvent.resetAll(),i.ads.adPlaybackTracking=G({},I)),n=e,-1===E.indexOf(n.type)&&ba(i,e),e.type in Sa?Sa[e.type](i,e):-1===P.indexOf(e.type)&&ga(i,T[e.type],"clienta")})}function Pa(e){var a,t;"function"==typeof navigator.sendBeacon&&(a=e,t=function(){v(a,Z);var e=ga(a,Z,"jwplayer6",{returnURL:!0});void 0!==e&&navigator.sendBeacon(e)},window.addEventListener("unload",t),a.external.playerAPI.on("remove",function(){v(a,Z),window.removeEventListener("unload",t),a.meta.playerRemoved=!0,ga(a,Z,"jwplayer6")}))}function Ea(){try{var e=window.crypto||window.msCrypto;if(e&&e.getRandomValues)return e.getRandomValues(new Uint32Array(1))[0].toString(36)}catch(e){}return Math.random().toString(36).slice(2,9)}function Ca(e){for(var a="";a.length<e;)a+=Ea();return a.slice(0,e)}var Aa="clickCard",xa="createCard",ja="hideCard",Ra="removeCard",Ba="showCard",Va="time",Ma={showCard:"sh",hideCard:"hd",clickCard:"cl"},La={time:"t",nonTime:"nt"};function Ga(f,m){return function(e){var a,t,n,r,i,o,d,l,c,u,s,p=(a=f,t=e.cardVisible,a===xa&&t?Ba:a===Ra&&t?ja:a===xa||a===Ra?null:a);p&&(n=p,i=m,o=(r=e).cueId,d=r.cardId,l=r.name,c=r.projectId,u=r.projectName,s=r.projectVersion,i.interactive.eventId=Ca(12),i.interactive.eventName=Ma[n],i.interactive.interactionType=La[Va],i.interactive.cueId=o,i.interactive.elementId=d,i.interactive.elementName=l,i.interactive.projectId=c,i.interactive.projectName=u,i.interactive.projectVersion=s,ga(i,te))}}function Oa(t){t.external.playerAPI.on("ready",function(){var e,a;(a=(e=t).external.playerAPI.getPlugin("interactive"))&&a.on&&(a.on(Ba,Ga(Ba,e)),a.on(ja,Ga(ja,e)),a.on(Aa,Ga(Aa,e)),a.on(xa,Ga(xa,e)),a.on(Ra,Ga(Ra,e)))})}var Na=["predictions","segments","decisionThresholds"];var qa=1e3;function Fa(e){return 0<e.numTrackedSeeks}var Ua=a,_a=e,Qa=n;function za(e){e.meta.playbackTracking.playItemCount++,ga(e,"s")}function Ka(u,s){return function(e){var a=u.meta.playbackEvents,t=u.playlistItemData,n=u.meta.playbackTracking,r=u.external.playerAPI,i=a[s];if(s===Ua){var o=e.segment;o&&(n.segmentReceived=!0,n.segmentsEncrypted=o.encryption),t.drm=e.drm||t.drm||"";var d=p(e,"metadata.programDateTime");d&&(u.meta.playbackTracking.programDateTime=d);var l=p(e,"metadata.start");l&&(u.meta.playbackTracking.cueStartTime=l)}if(a[s]=e,s===_a){i||(n.playedSeconds=0,n.viewablePlayedSeconds=0,n.audiblePlayedSeconds=0,n.playedSecondsTotal=0);var c=h(r);n.previousTime=c,n.currentPosition=c}s===Qa&&(v(u,_),"flash_adaptive"===m(r)?!u.meta.playbackSent&&n.segmentReceived&&(u.meta.playbackSent=!0,n.segmentReceived=!1,za(u)):u.meta.playbackSent||(u.meta.playbackSent=!0,za(u)))}}function Wa(e){var a=e.meta.playbackTracking,t=a.playedSeconds,n=a.viewablePlayedSeconds,r=a.audiblePlayedSeconds;a.playedSeconds=0,a.viewablePlayedSeconds=0;var i=t+.5|(a.audiblePlayedSeconds=0);a.elapsedSeconds=i;var o=n+.5|0;a.viewableElapsedSeconds=o;var d=r+.5|0;a.audibleElapsedSeconds=d,0<i&&ga(e,z)}function Ha(e,a,t,n){a<n&&n<=a+t&&(e.meta.playbackTracking.retTimeWatched=n,ga(e,"ret"))}function $a(e,a,t){var n,r,i,o=K+"-"+t;n=a,r=t,i=o,e.meta.pingLimiters.playlistItem.canSendPing(i)&&Math.floor(n)===r&&(e.meta.playbackTracking.thresholdCrossed=t,ga(e,K),e.meta.pingLimiters.playlistItem.setPingSent(o))}function Ja(e,a){var t,n,r,i=2<arguments.length&&void 0!==arguments[2]&&arguments[2],o=arguments[3];i?function(e){var a=e.meta.seekTracking;if(Fa(a)){clearTimeout(a.seekDebounceTimeout);var t=ga(e,"vs","jwplayer6",{delaySend:!0});a.seekDebounceTimeout=setTimeout(function(){var e;t&&t(),(e=a).videoStartDragTime=0,e.dragStartTime=0,e.seekDebounceTimeout=null,e.lastTargetTime=0,e.numTrackedSeeks=0},qa)}}(e):(t=e.meta.seekTracking,n=a,r=o,Fa(t)||(t.videoStartDragTime=r,t.dragStartTime=Date.now()),t.numTrackedSeeks++,t.lastTargetTime=n.offset)}function Xa(e,a,t){var n,r;e.playerData.lastErrorCode[a]=t.code,v(e,pe),e.meta.eventPreAbandonment=c(a,"error"),e.errors.numberEventsSent<e.errors.NUM_ERRORS_PER_SESSION&&(r=a,"number"==typeof(n=e).playerData.lastErrorCode[r]||Math.random()<n.errors.SAMPLE_RATE)&&(e.errors.numberEventsSent+=1,ga(e,a,U))}var Ya=n,Za=t,et=a,at=e;function tt(e){var a=e.meta;a.playbackEvents={},a.playbackSent=!1,a.playbackTracking.trackingSegment=0,a.pingLimiters.playlistItem.resetAll(),a.playbackTracking.posterVideoThumbAnimated=void 0,a.playbackTracking.overlayVideoThumbAnimated=void 0,e.playerData.numAutoVisualQualityChange=0;var t=e.playerData.startup;t.initialTime=null,t.startupTime=null,t.dispatchEvent=null}function nt(v){var e,a,g=v.external.playerAPI,i=function(e,a){e.playlistItemData.playReason=a.playReason||"",e.playerData.startup.initialTime=Date.now(),ga(e,"pa")}.bind(null,v),t=function(e,a){var t=e.playlistItemData.mediaId;t&&t===De(a.item)&&(e.playerData.lastErrorCode[H]=a.code,ga(e,"paf","error"))}.bind(null,v);g.on("idle buffer play pause complete error",function(e){Da(v,e.type)}),g.on("idle",tt.bind(null,v)),g.on("ready",function(e){var a=v.playlistItemData,t=v.playerData;a.ready=G({},e),t.viewable=g.getViewable(),t.muted=g.getMute(),t.volume=g.getVolume(),t.inferencePluginVersion=u(g.getPlugin("inference")),t.biddingPluginVersion=u(g.getPlugin("bidding"))}),g.on("playlistItem",function(e){var a=v.playlistItemData;a.drm="",0!==v.meta.playbackTracking.playSessionSequence&&(a.itemId=Ca(12)),v.meta.playbackTracking.playSessionSequence++,a.index=e.index;var t,n,r=e.item||f(g);r&&(a.mediaId=De(r),Se(v,r)),a.ready&&(v.meta.playbackTracking.posterVideoThumbnail=Ie(e.item),t=v,n=a.ready,t.playerData.setupTime=-1,n&&n.setupTime&&(t.playerData.setupTime=10*Math.round(n.setupTime/10)|0),ga(t,"e"),a.item=null,a.ready=null),g.off("beforePlay",i),g.once("beforePlay",i),tt(v),v.meta.playbackTracking.segmentReceived=v.meta.playbackTracking.segmentsEncrypted=!1}),g.on("playAttemptFailed",t),g.on("meta",Ka(v,et)),g.on("levels",Ka(v,Za)),g.on("play",Ka(v,at)),g.on("firstFrame",Ka(v,Ya)),g.on("time",function(e){var a=v.meta.playbackEvents,t=v.meta.playbackTracking,n="number"==typeof e.currentTime?e.currentTime:h(g);t.currentPosition=n;var r=e.duration;if(n)if(v.meta.seekTracking.dragStartTime)t.previousTime=n;else{1<n&&(a[Za]||Ka(v,Za)({}));var i,o,d,l=We(r),c=(i=n,d=l,(o=r)===1/0?null:i/(o/d)+1|0);0===t.trackingSegment&&(t.trackingSegment=c);var u,s,p,f=(u=v,p=wa(s=t,n),u.playerData.viewable&&(s.viewablePlayedSeconds=s.viewablePlayedSeconds+p),!u.playerData.muted&&0<u.playerData.volume&&(s.audiblePlayedSeconds=s.audiblePlayedSeconds+p),p);if(Ha(v,t.playedSecondsTotal,f,10),Ha(v,t.playedSecondsTotal,f,30),Ha(v,t.playedSecondsTotal,f,60),t.playedSecondsTotal=t.playedSecondsTotal+f,!0===t.sendSetTimeEvents&&($a(v,n,3),$a(v,n,10),$a(v,n,30)),r<=0||r===1/0)t.playedSeconds>=b&&(t.latency=e.latency,Wa(v));else if(c===t.trackingSegment+1){var m=y*t.trackingSegment/l;if(l<c)return;t.normalizedTime=m,Wa(v),t.trackingSegment=0}}}),g.on("seek",function(e){v.meta.playbackTracking.previousTime=h(g),v.meta.playbackTracking.trackingSegment=0;var a=v.meta.playbackTracking.currentPosition;Ja(v,e,!1,a)}),g.on("seeked",function(e){Ja(v,e,!0)}),g.on("complete",function(){var e=v.meta.playbackTracking,a=D(v);if(!(a<=0||a===1/0)){We(a);e.normalizedTime=y,Wa(v),e.playedSecondsTotal=0}}),g.on("cast",function(e){v.casting=!!e.active}),g.on("playbackRateChanged",function(e){ga(v,"pru"),v.meta.playbackTracking.prevPlaybackRate=e.playbackRate}),g.on("visualQuality",function(e){"auto"===e.reason&&(v.playerData.numAutoVisualQualityChange+=1);var a,t,n=N(g);a=n,t=!1,k.width===a.width&&k.height===a.height||(t=!0),k=a,t&&-1===r.indexOf(n.reason)&&ga(v,"vqc")}),g.on(o.join(" "),function(){v.ads.adBreakTracking&&(v.ads.adBreakTracking.shouldTrack=!0)}),g.on("error",Xa.bind(null,v,pe)),g.on("setupError",Xa.bind(null,v,se)),g.on("autostartNotAllowed",function(){ga(v,Q)}),g.on("viewable",function(e){v.playerData.viewable=e.viewable}),g.on("mute",function(e){v.playerData.muted=e.mute}),g.on("volume",function(e){v.playerData.volume=e.volume}),g.on("captionsChanged",function(e){0!==e.track&&0===v.playerData.captionsIndex&&ga(v,ae),v.playerData.captionsIndex=e.track}),g.on("videoThumbFirstFrame",function(e){v.meta.playbackTracking.posterVideoThumbAnimated=!0}),g.on("inference",function(e){var t;t=e,v.inference.result=Na.reduce(function(e,a){return t[a]&&(e[a]=t[a]),e},{})}),tt(v),a=z,(e=v).meta.previousBufferTimes[a]=He(e)}function rt(e,a){e.related.feedId=ye(a),e.related.feedInstanceId=be(a),e.related.feedType=ke(a,"kind"),e.related.feedShownId=a.feedShownId,e.related.onClickSetting="onclick"in a?"play"===a.onclick?1:0:void 0,e.related.feedInterface=a.ui;var t=a.itemsShown||[],n=0,r=[],i=[],o=[],d=!0,l=!1;t.forEach(function(e){he(e)&&n++,r.push(De(e));var a=Ie(e)?"1":"0";l||"1"!==a||(l=!0),o.push(a);var t=p(e,"variations.selected.images.id");t&&(d=!1),i.push(t||"null")}),e.related.thumbnailIdsShown=d?[]:i,e.related.idsShown=r,e.related.pinnedCount=n,e.related.page=a.page,e.related.autotimerLength=a.autoTimer,e.related.pinSetId=he(a.target),e.related.advanceTarget=De(a.target),e.related.targetThumbID=p(a.target,"variations.selected.images.id"),e.related.overlayVideoThumbs=l?o.join(","):void 0,e.related.ordinalClicked="position"in a?a.position+1:a.index}function it(e,a,t){rt(e,a),ga(e,t)}function ot(a){var e=a.external.playerAPI.getPlugin("related");e&&(e.on("playlist",function(e){null!==e.playlist&&it(a,e,$)}),e.on("feedShown",function(e){Da(a,"recs-overlay"),a.related.shownReason=e.reason,a.related.feedWasViewable=e.viewable,it(a,e,J)}),e.on("feedClick",function(e){it(a,e,X)}),e.on("feedAutoAdvance",function(e){it(a,e,Y)}),e.on("videoThumbFirstFrame",function(e){a.meta.playbackTracking.overlayVideoThumbAnimated=!0}),a.related.relatedSetUp=!0)}function dt(t){t.external.playerAPI.getPlugin&&(t.external.playerAPI.on("ready",function(){var a,e;ot(t),(e=(a=t).external.playerAPI).on("playlistItem",function(){a.related.sendHoverPing=!0,a.related.nextShownReason=null,a.related.shownReason=null}),e.on("nextShown",function(e){a.related.nextShownReason=e.reason,a.related.shownReason=e.reason,Da(a,"recs-overlay"),("hover"!==e.reason||a.related.sendHoverPing)&&(a.related.sendHoverPing=!1,it(a,e,J))}),e.on("nextClick",function(e){a.related.nextShownReason&&it(a,e,X)}),e.on("nextAutoAdvance",function(e){it(a,e,Y)})}),t.external.playerAPI.on("relatedReady",function(){t.related.relatedSetUp||ot(t)}))}var lt={facebook:"fb",twitter:"twi",email:"em",link:"cl",embed:"ceb",pinterest:"pin",tumblr:"tbr",googleplus:"gps",reddit:"rdt",linkedin:"lkn",custom:"cus"};function ct(e){e.external.playerAPI.on("ready",function(){!function(a){var e=a.external.playerAPI;if(e.getPlugin){var t=e.getPlugin("sharing");t&&t.on("click",function(e){a.sharing.shareMethod=lt[e.method]||lt.custom,ga(a,W)})}}(e)})}var ut=.01;function st(e){return function(){var e=(0<arguments.length&&void 0!==arguments[0]?arguments[0]:window).navigator.plugins;if(e&&"object"==typeof e["Shockwave Flash"]){var a=e["Shockwave Flash"].description;if(a)return a}if(void 0!==window.ActiveXObject)try{var t=new window.ActiveXObject("ShockwaveFlash.ShockwaveFlash");if(t){var n=t.GetVariable("$version");if(n)return n}}catch(e){}return""}(e).replace(/\D+(\d+\.?\d*).*/,"$1")}st(window);var pt=Ca(12);function ft(e,a){var t=2<arguments.length&&void 0!==arguments[2]?arguments[2]:window;if(e)return{pageViewId:pt};var n,r,i=t.document,o=t.top,d=t.location,l=i.referrer,c=(n=t).top!==n.self,u=function(e,a,t){var n="",r="",i="",o=!1;if(e){if(n=function(e){var a=e.match(/^(https?:\/\/).*\.(?:ampproject\.org|bing-amp\.com)\/(?:.\/)?(?:.\/)?(.*)$/);if(a&&1<a.length)return""+a[1]+a[2];var t=e.match(/^(https?:\/\/.*)\.(?:cdn\.ampproject\.org|bing-amp\.com)$/);if(t&&1<t.length)return(""+t[1]).replace(/([^-])(\-)([^-])/g,"$1.$3").replace(/\-\-/g,"-");return e}(r=a),o=n!==a,!t)return{pageURL:n,origPageURL:r,amp:o,pageTitle:i};try{i=t.document.title;var d=t.location.href;r=r||d,n=n||d}catch(e){}}return{pageURL:n,origPageURL:r,amp:o,pageTitle:i}}(c,l,o),s=i.querySelector('meta[property="og:title"]'),p=void 0;return s&&(p=s.getAttribute("content")),{pageURL:u.pageURL||d.href,origPageURL:u.amp?u.origPageURL:void 0,pageTitle:u.pageTitle||i.title,inIframe:c,flashVersion:st(t),pageViewId:pt,pageOGTitle:p,testCaseId:a?function(e){var a=1<arguments.length&&void 0!==arguments[1]?arguments[1]:window;e=e.replace(/[\[]/,"\\[").replace(/[\]]/,"\\]");var t=new RegExp("[\\?&]"+e+"=([^&#]*)").exec(a.location.search);return null===t?void 0:decodeURIComponent(t[1].replace(/\+/g," "))}("test_case_id",t):void 0,amp:u.amp,jwAmpComponent:(r=i.location.search,/isAMP/.test(r))}}var mt=void 0;try{mt=window.localStorage}catch(e){}var vt=function(){function e(){na(this,e),this.pingTracker={}}return e.prototype.canSendPing=function(e){return!this.pingTracker[e]},e.prototype.setPingSent=function(e){this.pingTracker[e]=!0},e.prototype.resetAll=function(){this.pingTracker={}},e.prototype.resetKey=function(e){delete this.pingTracker[e]},e}();var gt=["1","yes","true"];function yt(e,a){return!0===e||!!(t=a)&&0<=gt.indexOf(t.toString());var t}var bt=0;function ht(e,a,t){var n,r,i=a.sdkplatform?parseInt(a.sdkplatform,10):L,o=e.getConfig(),d=(o||{}).advertising||{},l=bt+=1,c=function(){var e=0<arguments.length&&void 0!==arguments[0]?arguments[0]:window,a=e.navigator;return"doNotTrack"in a||"doNotTrack"in e||"msDoNotTrack"in a?a.doNotTrack||e.doNotTrack||a.msDoNotTrack:"unsupported"}(),u=yt(c,o.doNotSaveCookies),s=void 0,p=void 0;if(u)mt&&mt.removeItem("jwplayerLocalId");else{var f=function(){if(!mt)return{localID:null,storageAvailable:"fail"};var e=mt.jwplayerLocalId;if(e)return{localID:e,storageAvailable:"read"};try{return mt.jwplayerLocalId=Ca(12),{localID:mt.jwplayerLocalId,storageAvailable:"set"}}catch(e){return{localID:null,storageAvailable:"fail"}}}();s=f.localID,p=f.storageAvailable}var m=function(){var e=(0<arguments.length&&void 0!==arguments[0]?arguments[0]:document).querySelector("html");return e?e.getAttribute("lang"):null}(),v=function(){var e=0<arguments.length&&void 0!==arguments[0]?arguments[0]:window;return e.matchMedia&&e.matchMedia("(display-mode: standalone)").matches||!0===e.navigator.standalone}(),g=function(){var e=0<arguments.length&&void 0!==arguments[0]?arguments[0]:window;try{if(e.top!==e.self)return e.top.document.referrer}catch(e){return null}return e.document.referrer}(),y=o.defaultPlaybackRate||1,b=O(d.client);e.getPlugin&&e.getPlugin("related");var h,k,D,w,I,S,T,P,E,C,A,x,j,R=Math.random()<=ut;return{external:{playerAPI:e,div:t,utils:e.utils},playerData:{setupTime:-1,startup:{initialTime:null,startupTime:null,dispatchEvent:null},visualQuality:N(e),numAutoVisualQualityChange:0,lastErrorCode:{},defaultPlaybackRate:y,playerConfig:{visibility:-1,bandwidthEstimate:-1,floatingState:!1},floatingConfigured:!(null===(n=o.setupConfig)||void 0===n||!n.floating||(null===(r=o.setupConfig)||void 0===r?void 0:r.floating.disabled)),playerSize:{width:0,height:0,bucket:0},localization:{language:o.language,numIntlKeys:"object"==typeof o.intl?Object.keys(o.intl).length:null,numLocalKeys:"object"==typeof o.localization?Object.keys(o.localization).length:null},contextualEmbed:!!o.contextual,playbackMode:null,stringifiedSetupConfig:q(e),captionsIndex:0},staticPlayerData:(E=e,C=a,A=i,j={playerVersion:(x=E.version,x.split("+")[0]),sdkPlatform:C.sdkplatform||L,embedID:Ca(12)},A&&(j.sdkVersion=C.iossdkversion,j.bundleId=C.bundleId,j.advertisingId=C.advertisingId,j.deviceModel=C.deviceModel),j),casting:!1,accountData:function(e,a){var t=0,n=void 0;if(e){var r=new a(e),i=r.edition();(t=V[i]||0)!==B&&(n=r.token())}return n||(n="_"),{analyticsID:n,edition:t}}(o.key,e.utils.key),configData:(w=o,S=window.jwplayer&&window.jwplayer.defaults||{},T=w.related,P={playerHosting:w[ne]||S[ne]||0,playerConfigKey:w.pid,abTestConfig:w.pad,skinName:w.skin,advertisingBlockType:(I=w,I.advertising?I.advertising.outstream?2:1:0),sharingEnabled:!!w.sharing,castingBlockPresent:!!w.cast,gaBlockPresent:!!w.ga,autostartConfig:!!w.autostart,displayDescription:!1!==w.displaydescription,posterImagePresent:!!w.image,playbackRateControlsSet:!!w.playbackRateControls},w.autostart in M&&(P.autostartConfig=M[w.autostart]),T&&(P.relatedPluginFeedFile=T.recommendations||T.file),P),placementData:(k=a.placement,D={},["analyticsId","embedId","placementId","evaluationId","triggerId","strategyId","version"].forEach(function(e){k&&k.hasOwnProperty(e)&&(D[e]=k[e])}),D),browser:{langAttr:m,isPageStandalone:v,docReferrer:g,storage:{localID:s,storageAvailable:p,doNotTrackProperty:c},pageData:ft(i,!1),doNotTrackUser:u},meta:{debug:!0===a.debug,doNotPingBackIDs:(h=o,!0===h.doNotTrackCookies),setupCount:bt,nthPlayer:l,playbackEvents:{},playbackSent:void 0,playbackTracking:{trackingSegment:void 0,playedSeconds:0,viewablePlayedSeconds:0,audiblePlayedSeconds:0,playedSecondsTotal:0,previousTime:null,segmentReceived:!1,segmentsEncrypted:!1,playItemCount:0,playSessionSequence:0,prevPlaybackRate:y,retTimeWatched:0,normalizedTime:-1,elapsedSeconds:0,viewableElapsedSeconds:0,audibleElapsedSeconds:0,currentPosition:0,thresholdCrossed:0,sendSetTimeEvents:o.setTimeEvents||!1,cueStartTime:void 0,programDateTime:void 0},bufferedPings:[],seekTracking:{numTrackedSeeks:0,videoStartDragTime:0,dragStartTime:0,seekDebounceTimeout:null,lastTargetTime:0},previousBufferTimes:{},lastEvent:"",lastBucket:"",eventPreAbandonment:void 0,playerState:"idle",playerStateDuration:0,playerRemoved:!1,pingLimiters:{playlistItem:new vt},sessionSampled:R},playlistItemData:{ready:void 0,item:{},drm:"",index:0,itemId:Ca(12),mediaId:"",playReason:"",duration:0},interactive:{eventId:null,eventName:null,interactionType:null,cueId:null,elementId:null,elementName:null,projectId:null,projectName:null,projectVersion:null},related:{shownReason:null,nextShownReason:null,sendHoverPing:null,feedId:null,feedInstanceId:null,feedType:null,onClickSetting:-1,feedInterface:null,idsShown:[],thumbnailIdsShown:[],pinnedCount:-1,page:-1,autotimerLength:-1,pinSetId:-1,advanceTarget:null,ordinalClicked:-1,relatedSetUp:!1},sharing:{shareMethod:null,shareReferrer:function(e){if(!e)return null;var a=e.match(/[?&]jwsource=([^&]+)/);return a?decodeURIComponent(a[1]):null}(window.location.search)},ads:{adEventData:G({},F),advertisingConfig:d,adClient:b,adScheduleId:d.adscheduleid,adBreakTracking:-1!==b?{shouldTrack:!1,adBreakCount:0}:null,adPlaybackTracking:{consecutiveVisibleSeconds:0,maxConsecutiveVisibleSeconds:0,totalVisibleSeconds:0},headerBiddingData:{},headerBiddingCacheData:{bidder:null,cacheKey:null},watchedPastSkipPoint:null,jwAdErrorCode:null,currentQuartile:null,pingLimiters:{visibleEvent:new vt}},errors:{SAMPLE_RATE:.02,NUM_ERRORS_PER_SESSION:1,numberEventsSent:0},trackingState:{pageLoaded:null,queue:[],onping:"function"==typeof a.onping?a.onping:null,images:[],boundFlushQueue:null},inference:{result:null}}}var kt=0;(window.jwplayerPluginJsonp||window.jwplayer().registerPlugin)("jwpsrv","7.0",function(e,a,t){var n,r,i=ht(e,a,t);Pa(n=i),nt(n),Ta(n),dt(n),ct(n),Oa(n),pa(i),this.getTrackingPixelURLs=(r=i,function(e,a){r.ads.headerBiddingCacheData.bidder=e,r.ads.headerBiddingCacheData.cacheKey=a;var t=ga(r,"vci","clienta",{returnURL:!0}),n=ga(r,"vcae","clienta",{returnURL:!0});return r.ads.headerBiddingCacheData.bidder=void 0,r.ads.headerBiddingCacheData.cacheKey=void 0,{impression:t,error:n}}),this.doNotTrackUser=function(e){return e.meta.doNotPingBackIDs}.bind(null,i),this.trackExternalAPIUsage=function(e,a){var t,n,r;if(!(25<=kt||.005<Math.random()))return kt++,n=e,r=a,(t=i).playerData.apiTracking={methodCalled:n,firstMeaningfulParam:r},ga(t,ee,"jwplayer6"),void delete t.playerData.apiTracking}})}();
</script>
<style>
	.jwplayer.jw-stretch-uniform .jw-media video {
    object-fit: contain;
}


.jwplayer .jw-media video {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    margin: auto;
    background: 0 0;
    -webkit-tap-highlight-color: transparent;
    -webkit-focus-ring-color: transparent;
    outline: 0;
}

.jwplayer * {
    box-sizing: inherit;
}

.jw-reset, .jw-reset-text {
    color: inherit;
    background-color: transparent;
    padding: 0;
    margin: 0;
    float: none;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 1em;
    line-height: 1em;
    list-style: none;
    text-transform: none;
    vertical-align: baseline;
    border: 0;
    font-variant: inherit;
    font-stretch: inherit;
    -webkit-tap-highlight-color: rgba(255, 255, 255, 0);
}
	.aligncenter {
    display: block;
    margin-right: auto;
    margin-left: auto;
}

.alignleft {
    display: inline;
    float: left;
    margin-right: 1.5em;
}

.alignright {
    display: inline;
    float: right;
    margin-left: 1.5em;
}

.bypostauthor {
}

.gallery-caption {
}

.gallery {
    margin-bottom: 1.6em;
}

.gallery-item {
    display: inline-block;
    padding: 1.79104477%;
    text-align: center;
    vertical-align: top;
    width: 100%;
}

.gallery-columns-2 .gallery-item {
    max-width: 50%;
}

.gallery-columns-3 .gallery-item {
    max-width: 33.33%;
}

.gallery-columns-4 .gallery-item {
    max-width: 25%;
}

.gallery-columns-5 .gallery-item {
    max-width: 20%;
}

.gallery-columns-6 .gallery-item {
    max-width: 16.66%;
}

.gallery-columns-7 .gallery-item {
    max-width: 14.28%;
}

.gallery-columns-8 .gallery-item {
    max-width: 12.5%;
}

.gallery-columns-9 .gallery-item {
    max-width: 11.11%;
}

.gallery-icon img {
    margin: 0 auto;
}

.gallery-caption {
    color: #707070;
    color: rgba(51, 51, 51, 0.7);
    display: block;
    font-family: "Noto Sans", sans-serif;
    font-size: 12px;
    font-size: 1.2rem;
    line-height: 1.5;
    padding: 0.5em 0;
}

.gallery-columns-6 .gallery-caption, .gallery-columns-7 .gallery-caption, .gallery-columns-8 .gallery-caption, .gallery-columns-9 .gallery-caption {
    display: none;
}

.sticky {
}

.wp-caption {
    border: 1px solid #ccc;
    margin-bottom: 1.5em;
    max-width: 100%;
}

.wp-caption img[class*="wp-image-"] {
    display: block;
    margin: 1.2% auto 0;
    max-width: 98%;
}

.wp-caption-text {
    text-align: center;
}

.wp-caption .wp-caption-text {
    margin: 0.8075em 0;
}

.screen-reader-text {
    clip: rect(1px, 1px, 1px, 1px);
    position: absolute !important;
    height: 1px;
    width: 1px;
    overflow: hidden;
}

.screen-reader-text:focus {
    background-color: #f1f1f1;
    border-radius: 3px;
    box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.6);
    clip: auto !important;
    color: #21759b;
    display: block;
    font-size: 14px;
    font-size: 0.875rem;
    font-weight: bold;
    height: auto;
    left: 5px;
    line-height: normal;
    padding: 15px 23px 14px;
    text-decoration: none;
    top: 5px;
    width: auto;
    z-index: 100000;
}

.timeline {
    list-style: none;
    padding: 10px 0;
    position: relative
}

.timeline:before {
    top: 0;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 3px;
    background-color: #d60000;
    left: 50%;
    margin-left: -1.5px
}

.timeline>li {
    margin-bottom: 0x;
    position: relative
}

.timeline>li:before,.timeline>li:after {
    content: " ";
    display: table
}

.timeline>li:after {
    clear: both
}

.timeline>li>.timeline-panel:before {
    display: none
}

.timeline>li>.timeline-panel:after {
    display: none
}

.timeline>li>.timeline-badge {
    color: #fff;
    width: 50px;
    height: 50px;
    line-height: 50px;
    font-size: 1em;
    font-weight: lighter;
    text-align: center;
    position: absolute;
    top: 16px;
    left: 50%;
    margin-left: -25px;
    background-color: #999;
    z-index: 100;
    border-top-right-radius: 50%;
    border-top-left-radius: 50%;
    border-bottom-right-radius: 50%;
    border-bottom-left-radius: 50%;
    border: 1px solid grey
}

.timeline>li.timeline-inverted>.timeline-panel {
    float: right;
    text-align: start
}

.timeline>li.timeline-inverted>.timeline-panel {
    justify-content: start
}

.timeline>li.timeline-inverted>.timeline-panel:before {
    border-left-width: 0;
    border-right-width: 15px;
    left: -15px;
    right: auto
}

.timeline>li.timeline-inverted>.timeline-panel:after {
    border-left-width: 0;
    border-right-width: 14px;
    left: -14px;
    right: auto
}

.timeline>li>.timeline-panel {
    width: 50%;
    float: left;
    border-radius: 20px;
    padding: 20px;
    position: relative;
    text-align: end;
    display: flex;
    flex-direction: row;
    justify-content: end
}
}

@media(min-width: 768px) and (max-width:1024px) {
    .match-info .match .detail .live.mobile {
        display:block;
        font-size: larger
    }

    .match-info .match {
        background: linear-gradient(to top,#990000,#cb0000);
        border-radius: 20px
    }

    .match .detail .live {
        animation: flash 2s infinite;
        color: orange
    }

    .detail-icon {
        display: none
    }

    .timeline {
        list-style: none;
        padding: 10px 0;
        position: relative
    }

    .timeline:before {
        top: 0;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #d60000;
        left: 50%;
        margin-left: -1.5px
    }

    .timeline>li {
        margin-bottom: 0x;
        position: relative
    }

    .timeline>li:before,.timeline>li:after {
        content: " ";
        display: table
    }

    .timeline>li:after {
        clear: both
    }

    .timeline>li>.timeline-panel:before {
        position: absolute;
        top: 26px;
        right: -15px;
        display: inline-block;
        border-top: 15px solid transparent;
        border-left: 15px solid #ccc;
        border-right: 0 solid #ccc;
        border-bottom: 15px solid transparent;
        content: " "
    }

    .timeline>li>.timeline-panel:after {
        position: absolute;
        top: 27px;
        right: -14px;
        display: inline-block;
        border-top: 14px solid transparent;
        border-left: 14px solid #fff;
        border-right: 0 solid #fff;
        border-bottom: 14px solid transparent;
        content: " "
    }

    .timeline>li>.timeline-badge {
        color: #fff;
        width: 50px;
        height: 50px;
        line-height: 50px;
        font-size: 1em;
        font-weight: lighter;
        text-align: center;
        position: absolute;
        top: 16px;
        left: 50%;
        margin-left: -25px;
        background-color: #999;
        z-index: 100;
        border-top-right-radius: 50%;
        border-top-left-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
        border: 1px solid grey
    }

    .timeline>li.timeline-inverted>.timeline-panel {
        float: right;
        text-align: start
    }

    .timeline>li.timeline-inverted>.timeline-panel {
        justify-content: start
    }

    .timeline>li.timeline-inverted>.timeline-panel:before {
        border-left-width: 0;
        border-right-width: 15px;
        left: -15px;
        right: auto
    }

    .timeline>li.timeline-inverted>.timeline-panel:after {
        border-left-width: 0;
        border-right-width: 14px;
        left: -14px;
        right: auto
    }

    .timeline>li>.timeline-panel {
        width: 40%;
        float: left;
        border-radius: 20px;
        padding: 10px;
        position: relative;
        text-align: end;
        display: flex;
        flex-direction: row;
        justify-content: end
    }
}

@media(min-width: 1025px) and (max-width:1280px) {
    .match .detail .live {
        animation:flash 2s infinite;
        color: orange
    }

    .timeline {
        list-style: none;
        padding: 10px 0;
        position: relative
    }

    .timeline:before {
        top: 0;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #d60000;
        left: 50%;
        margin-left: -1.5px
    }

    .timeline>li {
        margin-bottom: 0x;
        position: relative
    }

    .timeline>li:before,.timeline>li:after {
        content: " ";
        display: table
    }

    .timeline>li:after {
        clear: both
    }

    .timeline>li>.timeline-panel:before {
        position: absolute;
        top: 26px;
        right: -15px;
        display: inline-block;
        border-top: 15px solid transparent;
        border-left: 15px solid #ccc;
        border-right: 0 solid #ccc;
        border-bottom: 15px solid transparent;
        content: " "
    }

    .timeline>li>.timeline-panel:after {
        position: absolute;
        top: 27px;
        right: -14px;
        display: inline-block;
        border-top: 14px solid transparent;
        border-left: 14px solid #fff;
        border-right: 0 solid #fff;
        border-bottom: 14px solid transparent;
        content: " "
    }

    .timeline>li>.timeline-badge {
        color: #fff;
        width: 50px;
        height: 50px;
        line-height: 50px;
        font-size: 1em;
        font-weight: lighter;
        text-align: center;
        position: absolute;
        top: 16px;
        left: 50%;
        margin-left: -25px;
        background-color: #999;
        z-index: 100;
        border-top-right-radius: 50%;
        border-top-left-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
        border: 1px solid grey
    }

    .timeline>li.timeline-inverted>.timeline-panel {
        float: right;
        text-align: start
    }

    .timeline>li.timeline-inverted>.timeline-panel {
        justify-content: start
    }

    .timeline>li.timeline-inverted>.timeline-panel:before {
        border-left-width: 0;
        border-right-width: 15px;
        left: -15px;
        right: auto
    }

    .timeline>li.timeline-inverted>.timeline-panel:after {
        border-left-width: 0;
        border-right-width: 14px;
        left: -14px;
        right: auto
    }

    .timeline>li>.timeline-panel {
        width: 40%;
        float: left;
        border-radius: 20px;
        padding: 10px;
        position: relative;
        text-align: end;
        display: flex;
        flex-direction: row;
        justify-content: end
    }
}

@media(min-width: 1281px) {
    .match .detail .live {
        animation:flash 2s infinite;
        color: orange
    }

    .detail-icon {
        font-size: 40px
    }

    .timeline {
        list-style: none;
        padding: 10px 0;
        position: relative
    }

    .timeline:before {
        top: 0;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #d60000;
        left: 50%;
        margin-left: -1.5px
    }

    .timeline>li {
        margin-bottom: 0x;
        position: relative
    }

    .timeline>li:before,.timeline>li:after {
        content: " ";
        display: table
    }

    .timeline>li:after {
        clear: both
    }

    .timeline>li>.timeline-panel:before {
        position: absolute;
        top: 26px;
        right: -15px;
        display: inline-block;
        border-top: 15px solid transparent;
        border-left: 15px solid #ccc;
        border-right: 0 solid #ccc;
        border-bottom: 15px solid transparent;
        content: " "
    }

    .timeline>li>.timeline-panel:after {
        position: absolute;
        top: 27px;
        right: -14px;
        display: inline-block;
        border-top: 14px solid transparent;
        border-left: 14px solid #fff;
        border-right: 0 solid #fff;
        border-bottom: 14px solid transparent;
        content: " "
    }

    .timeline>li>.timeline-badge {
        color: #fff;
        width: 50px;
        height: 50px;
        line-height: 50px;
        font-size: 1em;
        font-weight: lighter;
        text-align: center;
        position: absolute;
        top: 16px;
        left: 50%;
        margin-left: -25px;
        background-color: #999;
        z-index: 100;
        border-top-right-radius: 50%;
        border-top-left-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
        border: 1px solid grey
    }

    .timeline>li.timeline-inverted>.timeline-panel {
        float: right;
        text-align: start
    }

    .timeline>li.timeline-inverted>.timeline-panel {
        justify-content: start
    }

    .timeline>li.timeline-inverted>.timeline-panel:before {
        border-left-width: 0;
        border-right-width: 15px;
        left: -15px;
        right: auto
    }

    .timeline>li.timeline-inverted>.timeline-panel:after {
        border-left-width: 0;
        border-right-width: 14px;
        left: -14px;
        right: auto
    }

    .timeline>li>.timeline-panel {
        width: 40%;
        float: left;
        border-radius: 20px;
        padding: 10px;
        position: relative;
        text-align: end;
        display: flex;
        flex-direction: row;
        justify-content: end
    }
}

.timeline-badge.primary {
    background-color: #008cba!important
}

.timeline-badge.success {
    background-color: #43ac6a!important
}

.timeline-badge.warning {
    background-color: #e99002!important
}

.timeline-badge.danger {
    background-color: #d60000 !important;
}

.timeline-badge.info {
    background-color: #5bc0de!important
}

.player-photo {
    border-radius: 50%;
    width: 80px;
    height: 80px
}

.timeline-title {
    margin-top: 0;
    color: inherit
}

.timeline-body>p,.timeline-body>ul {
    margin-bottom: 0
}

.timeline-body>p+p {
    margin-top: 5px
}

.jsclass body .randomordercontentsubscriber {
    display: none;
}

.square {
    background-color: white;
    width: 95%;
    margin: 0 auto;
    max-width: 130rem;
}

.timedatecss {
    font-size: 12px;
    color: #3c763d;
    font-weight: bold;
}

hr {
    margin-top: 0px;
    margin-bottom: 0px;
    border: 0;
    border-top: 1px solid #eee;
}

.panel-default>.panel-heading {
    color: #333;
    border-color: #ddd;
}

.panel-default {
    border-color: #d4d4d4;
}

.panel-title {
    margin-top: 0;
    margin-bottom: 0;
    font-size: 15px;
    color: black;
}

a:hover, a:focus {
    text-decoration: none;
}

a {
    color: #d83939;
    text-decoration: none;
}

a:visited {
    color: #ff5858;
    text-decoration: none;
}

.panel-default>.panel-heading+.panel-collapse>.panel-body {
    border-top-color: #fff;
}

.panel-body {
    padding: 3px 15px 3px 15px;
}

.panel-heading {
}

img.bannerimg {
    display: block;
    width: inherit;
    max-width: 85%;
    height: auto;
    margin: auto;
}

.center_div {
    margin: auto;
    width: 100%;
    text-align: center;
    display: inline-block;
}

.bs-calltoaction.bs-calltoaction-success {
    color: #fff;
    background-color: #5cb85c;
    border-color: #4cae4c;
}

.bs-calltoaction {
    position: relative;
    width: auto;
    padding: 15px 25px;
    border: 1px solid black;
    margin-top: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
}

h1.cta-title {
    font-size: 20px;
}

.black-ribbon {
    position: fixed;
    z-index: 9999;
    width: 70px;
}

@media only all and (min-width: 768px) {
    .black-ribbon {
        width: auto;
    }
}

.stick-left {
    left: 0;
}

.stick-right {
    right: 0;
}

.stick-top {
    top: 0;
}

.stick-bottom {
    bottom: 0;
}

.panel-group .panel {
    margin-bottom: 0;
    border-radius: 4px;
}

.panel-default {
    border-color: #d4d4d4 !important;
}

.panel {
    margin-bottom: 20px;
    background-color: #fff;
    border: 1px solid transparent;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
}

.panel-default>.panel-heading {
    color: #333;
    border-color: #ddd;
}

.panel-default>.panel-heading {
    color: #333;
    background-color: #f5f5f5;
    border-color: #ddd;
}

.panel-group .panel-heading {
    border-bottom: 0;
}

.panel-heading {
}

.panel-heading {
    padding: 5px 15px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
}

.panel-title {
    margin-top: 0;
    margin-bottom: 0;
    font-size: 15px;
    color: black;
}

.panel-group {
    margin-top: 5px;
}

.match {
    padding: 10px;
    border-radius: 5px;
    display: flex;
    flex-direction: column;
    transition: transform .5s;
}

.match .detail {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
}

.match-info .match .detail {
    justify-content: center;
    min-height: 80px;
}

.match .detail .team-name-left {
    display: flex;
    flex-direction: row;
    justify-content: end;
    align-items: center;
    width: 35%;
}

.match .detail .team-name-left img {
    height: 40px;
    width: 40px;
    margin: 0 20px;
}

.match-info .match .detail .team-name-left img {
    height: 60px;
    width: 60px;
    margin: 0 20px;
}

.match .detail .team-name-right {
    display: flex;
    flex-direction: row;
    justify-content: start;
    align-items: center;
    width: 35%;
}

.match .detail .team-name-right img {
    height: 40px;
    width: 40px;
    margin: 0 20px;
}

.match-info .match .detail .team-name-right img {
    height: 60px;
    width: 60px;
    margin: 0 20px;
}

.match .detail .vs {
    padding: 0 20px;
    border-radius: 15px;
    color: #b91313;
    font-weight: 600;
    font-size: 19px;
    margin: 0 20px;
}

.match-info .match .detail .vs {
    font-size: 30px;
}

.match .detail .vs {
    background-color: #fff;
}

.team-name-left .name {
    color: #fff;
}

.match-info .match {
    background: linear-gradient(to top,#5A328B,#815AB1);
    border-radius: 20px;
}

.ch {
    padding: 3px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
    transition: transform .2s;
}

.ch img {
    border-radius: 5px;
}

.chs .col {
    padding: 0;
    padding-bottom: 4px;
}

.chs {
    padding-right: 15px;
    padding-left: 15px;
}

@media (min-width: 576px) {
    .row-with-vspace {
        margin-right:0px !important;
    }
}

.match_detail {
    padding-top: 6px;
    padding-bottom: 6px;
}

.row-match-detail div {
}

.row-match-detail div.main-color {
    font-weight: bold;
}

.btn-primary, .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    background: #5A328B !important;
    border-color: #5A328B !important;
    color: #fff !important;
}

.container a {
    color: #5A328B;
}

.yellow_card {
    background: #FFCE00;
    width: 11px;
    height: 14px;
    display: inline-block;
}

.timeline li .timeline-heading {
    margin-right: 0.5rem!important;
    margin-top: 0.5rem!important;
}

.timeline li.timeline-inverted .timeline-heading {
    margin-left: 0.5rem!important;
    margin-top: 0.5rem!important;
}

h1.title {
    font-weight: bold !important;
    font-size: 2rem !important;
}

@media only screen and (max-width: 780px) {
    .live .fa-circle {
        display:none
    }

    .match .detail .view-btn {
        display: none
    }

    .match .detail .team-name-left {
        flex-direction: column-reverse;
        font-size: 12px
    }

    .match .detail .team-name-right {
        flex-direction: column;
        font-size: 12px
    }

    .match .detail .team-name-right .name,.match .detail .team-name-left .name {
        margin-top: 5px;
        text-align: center
    }

    .match .detail .team-name-left img,.match .detail .team-name-right img {
        height: 30px;
        width: 30px
    }

    .match .detail {
        justify-content: space-evenly
    }

    .match .detail .live.mobile {
        display: block;
        font-size: 20px;
        margin-bottom: 2px
    }

    .match .detail .vs {
        font-size: 14px !important;
        padding: 0 10px;
    }

    .match .detail .view-btn {
        margin-top: 10px;
    }

    .breadcrumb-item::before {
        content: "" !important;
    }
}

:root {
    --blue: #007bff;
    --indigo: #6610f2;
    --purple: #6f42c1;
    --pink: #e83e8c;
    --red: #dc3545;
    --orange: #fd7e14;
    --yellow: #ffc107;
    --green: #28a745;
    --teal: #20c997;
    --cyan: #17a2b8;
    --white: #fff;
    --gray: #6c757d;
    --gray-dark: #343a40;
    --primary: #007bff;
    --secondary: #6c757d;
    --success: #28a745;
    --info: #17a2b8;
    --warning: #ffc107;
    --danger: #dc3545;
    --light: #f8f9fa;
    --dark: #343a40;
    --breakpoint-xs: 0;
    --breakpoint-sm: 576px;
    --breakpoint-md: 768px;
    --breakpoint-lg: 992px;
    --breakpoint-xl: 1200px;
    --font-family-sans-serif: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans","Liberation Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    --font-family-monospace: SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace
}

*,::after,::before {
    box-sizing: border-box
}

html {
    font-family: sans-serif;
    line-height: 1.15;
    -webkit-text-size-adjust: 100%;
    -webkit-tap-highlight-color: transparent
}

article,aside,figcaption,figure,footer,header,hgroup,main,nav,section {
    display: block
}

body {
    margin: 0;
    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans","Liberation Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: left;
    background-color: #fff
}

[tabindex="-1"]:focus:not(:focus-visible) {
    outline: 0!important
}

hr {
    box-sizing: content-box;
    height: 0;
    overflow: visible
}

h1,h2,h3,h4,h5,h6 {
    margin-top: 0;
    margin-bottom: .5rem
}

p {
    margin-top: 0;
    margin-bottom: 1rem
}

abbr[data-original-title],abbr[title] {
    text-decoration: underline;
    -webkit-text-decoration: underline dotted;
    text-decoration: underline dotted;
    cursor: help;
    border-bottom: 0;
    -webkit-text-decoration-skip-ink: none;
    text-decoration-skip-ink: none
}

address {
    margin-bottom: 1rem;
    font-style: normal;
    line-height: inherit
}

dl,ol,ul {
    margin-top: 0;
    margin-bottom: 1rem
}

ol ol,ol ul,ul ol,ul ul {
    margin-bottom: 0
}

dt {
    font-weight: 700
}

dd {
    margin-bottom: .5rem;
    margin-left: 0
}

blockquote {
    margin: 0 0 1rem
}

b,strong {
    font-weight: bolder
}

small {
    font-size: 80%
}

sub,sup {
    position: relative;
    font-size: 75%;
    line-height: 0;
    vertical-align: baseline
}

sub {
    bottom: -.25em
}

sup {
    top: -.5em
}

a {
    color: #007bff;
    text-decoration: none;
    background-color: transparent
}

a:hover {
    color: #0056b3;
    text-decoration: underline
}

a:not([href]):not([class]) {
    color: inherit;
    text-decoration: none
}

a:not([href]):not([class]):hover {
    color: inherit;
    text-decoration: none
}

code,kbd,pre,samp {
    font-family: SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;
    font-size: 1em
}

pre {
    margin-top: 0;
    margin-bottom: 1rem;
    overflow: auto;
    -ms-overflow-style: scrollbar
}

figure {
    margin: 0 0 1rem
}

img {
    vertical-align: middle;
    border-style: none
}

svg {
    overflow: hidden;
    vertical-align: middle
}

table {
    border-collapse: collapse
}

caption {
    padding-top: .75rem;
    padding-bottom: .75rem;
    color: #6c757d;
    text-align: left;
    caption-side: bottom
}

th {
    text-align: inherit;
    text-align: -webkit-match-parent
}

label {
    display: inline-block;
    margin-bottom: .5rem
}

button {
    border-radius: 0
}

button:focus:not(:focus-visible) {
    outline: 0
}

button,input,optgroup,select,textarea {
    margin: 0;
    font-family: inherit;
    font-size: inherit;
    line-height: inherit
}

button,input {
    overflow: visible
}

button,select {
    text-transform: none
}

[role=button] {
    cursor: pointer
}

select {
    word-wrap: normal
}

[type=button],[type=reset],[type=submit],button {
    -webkit-appearance: button
}

[type=button]:not(:disabled),[type=reset]:not(:disabled),[type=submit]:not(:disabled),button:not(:disabled) {
    cursor: pointer
}

[type=button]::-moz-focus-inner,[type=reset]::-moz-focus-inner,[type=submit]::-moz-focus-inner,button::-moz-focus-inner {
    padding: 0;
    border-style: none
}

input[type=checkbox],input[type=radio] {
    box-sizing: border-box;
    padding: 0
}

textarea {
    overflow: auto;
    resize: vertical
}

fieldset {
    min-width: 0;
    padding: 0;
    margin: 0;
    border: 0
}

legend {
    display: block;
    width: 100%;
    max-width: 100%;
    padding: 0;
    margin-bottom: .5rem;
    font-size: 1.5rem;
    line-height: inherit;
    color: inherit;
    white-space: normal
}

progress {
    vertical-align: baseline
}

[type=number]::-webkit-inner-spin-button,[type=number]::-webkit-outer-spin-button {
    height: auto
}

[type=search] {
    outline-offset: -2px;
    -webkit-appearance: none
}

[type=search]::-webkit-search-decoration {
    -webkit-appearance: none
}

::-webkit-file-upload-button {
    font: inherit;
    -webkit-appearance: button
}

output {
    display: inline-block
}

summary {
    display: list-item;
    cursor: pointer
}

template {
    display: none
}

[hidden] {
    display: none!important
}

.h1,.h2,.h3,.h4,.h5,.h6,h1,h2,h3,h4,h5,h6 {
    margin-bottom: .5rem;
    font-weight: 500;
    line-height: 1.2
}

.h1,h1 {
    font-size: 2.5rem
}

.h2,h2 {
    font-size: 2rem
}

.h3,h3 {
    font-size: 1.75rem
}

.h4,h4 {
    font-size: 1.5rem
}

.h5,h5 {
    font-size: 1.25rem
}

.h6,h6 {
    font-size: 1rem
}

.lead {
    font-size: 1.25rem;
    font-weight: 300
}

.display-1 {
    font-size: 6rem;
    font-weight: 300;
    line-height: 1.2
}

.display-2 {
    font-size: 5.5rem;
    font-weight: 300;
    line-height: 1.2
}

.display-3 {
    font-size: 4.5rem;
    font-weight: 300;
    line-height: 1.2
}

.display-4 {
    font-size: 3.5rem;
    font-weight: 300;
    line-height: 1.2
}

hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0,0,0,.1)
}

.small,small {
    font-size: .875em;
    font-weight: 400
}

.mark,mark {
    padding: .2em;
    background-color: #fcf8e3
}

.list-unstyled {
    padding-left: 0;
    list-style: none
}

.list-inline {
    padding-left: 0;
    list-style: none
}

.list-inline-item {
    display: inline-block
}

.list-inline-item:not(:last-child) {
    margin-right: .5rem
}

.initialism {
    font-size: 90%;
    text-transform: uppercase
}

.blockquote {
    margin-bottom: 1rem;
    font-size: 1.25rem
}

.blockquote-footer {
    display: block;
    font-size: .875em;
    color: #6c757d
}

.blockquote-footer::before {
    content: "\2014\00A0"
}

.img-fluid {
    max-width: 100%;
    height: auto
}

.img-thumbnail {
    padding: .25rem;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: .25rem;
    max-width: 100%;
    height: auto
}

.figure {
    display: inline-block
}

.figure-img {
    margin-bottom: .5rem;
    line-height: 1
}

.figure-caption {
    font-size: 90%;
    color: #6c757d
}

code {
    font-size: 87.5%;
    color: #e83e8c;
    word-wrap: break-word
}

a>code {
    color: inherit
}

kbd {
    padding: .2rem .4rem;
    font-size: 87.5%;
    color: #fff;
    background-color: #212529;
    border-radius: .2rem
}

kbd kbd {
    padding: 0;
    font-size: 100%;
    font-weight: 700
}

pre {
    display: block;
    font-size: 87.5%;
    color: #212529
}

pre code {
    font-size: inherit;
    color: inherit;
    word-break: normal
}

.pre-scrollable {
    max-height: 340px;
    overflow-y: scroll
}

.container,.container-fluid,.container-lg,.container-md,.container-sm,.container-xl {
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto
}

@media (min-width: 576px) {
    .container,.container-sm {
        max-width:540px
    }
}

@media (min-width: 768px) {
    .container,.container-md,.container-sm {
        max-width:720px
    }
}

@media (min-width: 992px) {
    .container,.container-lg,.container-md,.container-sm {
        max-width:960px
    }
}

@media (min-width: 1200px) {
    .container,.container-lg,.container-md,.container-sm,.container-xl {
        max-width:1140px
    }
}

.row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px
}

.no-gutters {
    margin-right: 0;
    margin-left: 0
}

.no-gutters>.col,.no-gutters>[class*=col-] {
    padding-right: 0;
    padding-left: 0
}

.col,.col-1,.col-10,.col-11,.col-12,.col-2,.col-3,.col-4,.col-5,.col-6,.col-7,.col-8,.col-9,.col-auto,.col-lg,.col-lg-1,.col-lg-10,.col-lg-11,.col-lg-12,.col-lg-2,.col-lg-3,.col-lg-4,.col-lg-5,.col-lg-6,.col-lg-7,.col-lg-8,.col-lg-9,.col-lg-auto,.col-md,.col-md-1,.col-md-10,.col-md-11,.col-md-12,.col-md-2,.col-md-3,.col-md-4,.col-md-5,.col-md-6,.col-md-7,.col-md-8,.col-md-9,.col-md-auto,.col-sm,.col-sm-1,.col-sm-10,.col-sm-11,.col-sm-12,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9,.col-sm-auto,.col-xl,.col-xl-1,.col-xl-10,.col-xl-11,.col-xl-12,.col-xl-2,.col-xl-3,.col-xl-4,.col-xl-5,.col-xl-6,.col-xl-7,.col-xl-8,.col-xl-9,.col-xl-auto {
    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px
}

.col {
    -ms-flex-preferred-size: 0;
    flex-basis: 0;
    -ms-flex-positive: 1;
    flex-grow: 1;
    max-width: 100%
}

.row-cols-1>* {
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%
}

.row-cols-2>* {
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%
}

.row-cols-3>* {
    -ms-flex: 0 0 33.333333%;
    flex: 0 0 33.333333%;
    max-width: 33.333333%
}

.row-cols-4>* {
    -ms-flex: 0 0 25%;
    flex: 0 0 25%;
    max-width: 25%
}

.row-cols-5>* {
    -ms-flex: 0 0 20%;
    flex: 0 0 20%;
    max-width: 20%
}

.row-cols-6>* {
    -ms-flex: 0 0 16.666667%;
    flex: 0 0 16.666667%;
    max-width: 16.666667%
}

.col-auto {
    -ms-flex: 0 0 auto;
    flex: 0 0 auto;
    width: auto;
    max-width: 100%
}

.col-1 {
    -ms-flex: 0 0 8.333333%;
    flex: 0 0 8.333333%;
    max-width: 8.333333%
}

.col-2 {
    -ms-flex: 0 0 16.666667%;
    flex: 0 0 16.666667%;
    max-width: 16.666667%
}

.col-3 {
    -ms-flex: 0 0 25%;
    flex: 0 0 25%;
    max-width: 25%
}

.col-4 {
    -ms-flex: 0 0 33.333333%;
    flex: 0 0 33.333333%;
    max-width: 33.333333%
}

.col-5 {
    -ms-flex: 0 0 41.666667%;
    flex: 0 0 41.666667%;
    max-width: 41.666667%
}

.col-6 {
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%
}

.col-7 {
    -ms-flex: 0 0 58.333333%;
    flex: 0 0 58.333333%;
    max-width: 58.333333%
}

.col-8 {
    -ms-flex: 0 0 66.666667%;
    flex: 0 0 66.666667%;
    max-width: 66.666667%
}

.col-9 {
    -ms-flex: 0 0 75%;
    flex: 0 0 75%;
    max-width: 75%
}

.col-10 {
    -ms-flex: 0 0 83.333333%;
    flex: 0 0 83.333333%;
    max-width: 83.333333%
}

.col-11 {
    -ms-flex: 0 0 91.666667%;
    flex: 0 0 91.666667%;
    max-width: 91.666667%
}

.col-12 {
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%
}

.order-first {
    -ms-flex-order: -1;
    order: -1
}

.order-last {
    -ms-flex-order: 13;
    order: 13
}

.order-0 {
    -ms-flex-order: 0;
    order: 0
}

.order-1 {
    -ms-flex-order: 1;
    order: 1
}

.order-2 {
    -ms-flex-order: 2;
    order: 2
}

.order-3 {
    -ms-flex-order: 3;
    order: 3
}

.order-4 {
    -ms-flex-order: 4;
    order: 4
}

.order-5 {
    -ms-flex-order: 5;
    order: 5
}

.order-6 {
    -ms-flex-order: 6;
    order: 6
}

.order-7 {
    -ms-flex-order: 7;
    order: 7
}

.order-8 {
    -ms-flex-order: 8;
    order: 8
}

.order-9 {
    -ms-flex-order: 9;
    order: 9
}

.order-10 {
    -ms-flex-order: 10;
    order: 10
}

.order-11 {
    -ms-flex-order: 11;
    order: 11
}

.order-12 {
    -ms-flex-order: 12;
    order: 12
}

.offset-1 {
    margin-left: 8.333333%
}

.offset-2 {
    margin-left: 16.666667%
}

.offset-3 {
    margin-left: 25%
}

.offset-4 {
    margin-left: 33.333333%
}

.offset-5 {
    margin-left: 41.666667%
}

.offset-6 {
    margin-left: 50%
}

.offset-7 {
    margin-left: 58.333333%
}

.offset-8 {
    margin-left: 66.666667%
}

.offset-9 {
    margin-left: 75%
}

.offset-10 {
    margin-left: 83.333333%
}

.offset-11 {
    margin-left: 91.666667%
}

@media (min-width: 576px) {
    .col-sm {
        -ms-flex-preferred-size:0;
        flex-basis: 0;
        -ms-flex-positive: 1;
        flex-grow: 1;
        max-width: 100%
    }

    .row-cols-sm-1>* {
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%
    }

    .row-cols-sm-2>* {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%
    }

    .row-cols-sm-3>* {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%
    }

    .row-cols-sm-4>* {
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%
    }

    .row-cols-sm-5>* {
        -ms-flex: 0 0 20%;
        flex: 0 0 20%;
        max-width: 20%
    }

    .row-cols-sm-6>* {
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667%
    }

    .col-sm-auto {
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        width: auto;
        max-width: 100%
    }

    .col-sm-1 {
        -ms-flex: 0 0 8.333333%;
        flex: 0 0 8.333333%;
        max-width: 8.333333%
    }

    .col-sm-2 {
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667%
    }

    .col-sm-3 {
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%
    }

    .col-sm-4 {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%
    }

    .col-sm-5 {
        -ms-flex: 0 0 41.666667%;
        flex: 0 0 41.666667%;
        max-width: 41.666667%
    }

    .col-sm-6 {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%
    }

    .col-sm-7 {
        -ms-flex: 0 0 58.333333%;
        flex: 0 0 58.333333%;
        max-width: 58.333333%
    }

    .col-sm-8 {
        -ms-flex: 0 0 66.666667%;
        flex: 0 0 66.666667%;
        max-width: 66.666667%
    }

    .col-sm-9 {
        -ms-flex: 0 0 75%;
        flex: 0 0 75%;
        max-width: 75%
    }

    .col-sm-10 {
        -ms-flex: 0 0 83.333333%;
        flex: 0 0 83.333333%;
        max-width: 83.333333%
    }

    .col-sm-11 {
        -ms-flex: 0 0 91.666667%;
        flex: 0 0 91.666667%;
        max-width: 91.666667%
    }

    .col-sm-12 {
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%
    }

    .order-sm-first {
        -ms-flex-order: -1;
        order: -1
    }

    .order-sm-last {
        -ms-flex-order: 13;
        order: 13
    }

    .order-sm-0 {
        -ms-flex-order: 0;
        order: 0
    }

    .order-sm-1 {
        -ms-flex-order: 1;
        order: 1
    }

    .order-sm-2 {
        -ms-flex-order: 2;
        order: 2
    }

    .order-sm-3 {
        -ms-flex-order: 3;
        order: 3
    }

    .order-sm-4 {
        -ms-flex-order: 4;
        order: 4
    }

    .order-sm-5 {
        -ms-flex-order: 5;
        order: 5
    }

    .order-sm-6 {
        -ms-flex-order: 6;
        order: 6
    }

    .order-sm-7 {
        -ms-flex-order: 7;
        order: 7
    }

    .order-sm-8 {
        -ms-flex-order: 8;
        order: 8
    }

    .order-sm-9 {
        -ms-flex-order: 9;
        order: 9
    }

    .order-sm-10 {
        -ms-flex-order: 10;
        order: 10
    }

    .order-sm-11 {
        -ms-flex-order: 11;
        order: 11
    }

    .order-sm-12 {
        -ms-flex-order: 12;
        order: 12
    }

    .offset-sm-0 {
        margin-left: 0
    }

    .offset-sm-1 {
        margin-left: 8.333333%
    }

    .offset-sm-2 {
        margin-left: 16.666667%
    }

    .offset-sm-3 {
        margin-left: 25%
    }

    .offset-sm-4 {
        margin-left: 33.333333%
    }

    .offset-sm-5 {
        margin-left: 41.666667%
    }

    .offset-sm-6 {
        margin-left: 50%
    }

    .offset-sm-7 {
        margin-left: 58.333333%
    }

    .offset-sm-8 {
        margin-left: 66.666667%
    }

    .offset-sm-9 {
        margin-left: 75%
    }

    .offset-sm-10 {
        margin-left: 83.333333%
    }

    .offset-sm-11 {
        margin-left: 91.666667%
    }
}

@media (min-width: 768px) {
    .col-md {
        -ms-flex-preferred-size:0;
        flex-basis: 0;
        -ms-flex-positive: 1;
        flex-grow: 1;
        max-width: 100%
    }

    .row-cols-md-1>* {
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%
    }

    .row-cols-md-2>* {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%
    }

    .row-cols-md-3>* {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%
    }

    .row-cols-md-4>* {
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%
    }

    .row-cols-md-5>* {
        -ms-flex: 0 0 20%;
        flex: 0 0 20%;
        max-width: 20%
    }

    .row-cols-md-6>* {
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667%
    }

    .col-md-auto {
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        width: auto;
        max-width: 100%
    }

    .col-md-1 {
        -ms-flex: 0 0 8.333333%;
        flex: 0 0 8.333333%;
        max-width: 8.333333%
    }

    .col-md-2 {
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667%
    }

    .col-md-3 {
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%
    }

    .col-md-4 {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%
    }

    .col-md-5 {
        -ms-flex: 0 0 41.666667%;
        flex: 0 0 41.666667%;
        max-width: 41.666667%
    }

    .col-md-6 {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%
    }

    .col-md-7 {
        -ms-flex: 0 0 58.333333%;
        flex: 0 0 58.333333%;
        max-width: 58.333333%
    }

    .col-md-8 {
        -ms-flex: 0 0 66.666667%;
        flex: 0 0 66.666667%;
        max-width: 66.666667%
    }

    .col-md-9 {
        -ms-flex: 0 0 75%;
        flex: 0 0 75%;
        max-width: 75%
    }

    .col-md-10 {
        -ms-flex: 0 0 83.333333%;
        flex: 0 0 83.333333%;
        max-width: 83.333333%
    }

    .col-md-11 {
        -ms-flex: 0 0 91.666667%;
        flex: 0 0 91.666667%;
        max-width: 91.666667%
    }

    .col-md-12 {
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%
    }

    .order-md-first {
        -ms-flex-order: -1;
        order: -1
    }

    .order-md-last {
        -ms-flex-order: 13;
        order: 13
    }

    .order-md-0 {
        -ms-flex-order: 0;
        order: 0
    }

    .order-md-1 {
        -ms-flex-order: 1;
        order: 1
    }

    .order-md-2 {
        -ms-flex-order: 2;
        order: 2
    }

    .order-md-3 {
        -ms-flex-order: 3;
        order: 3
    }

    .order-md-4 {
        -ms-flex-order: 4;
        order: 4
    }

    .order-md-5 {
        -ms-flex-order: 5;
        order: 5
    }

    .order-md-6 {
        -ms-flex-order: 6;
        order: 6
    }

    .order-md-7 {
        -ms-flex-order: 7;
        order: 7
    }

    .order-md-8 {
        -ms-flex-order: 8;
        order: 8
    }

    .order-md-9 {
        -ms-flex-order: 9;
        order: 9
    }

    .order-md-10 {
        -ms-flex-order: 10;
        order: 10
    }

    .order-md-11 {
        -ms-flex-order: 11;
        order: 11
    }

    .order-md-12 {
        -ms-flex-order: 12;
        order: 12
    }

    .offset-md-0 {
        margin-left: 0
    }

    .offset-md-1 {
        margin-left: 8.333333%
    }

    .offset-md-2 {
        margin-left: 16.666667%
    }

    .offset-md-3 {
        margin-left: 25%
    }

    .offset-md-4 {
        margin-left: 33.333333%
    }

    .offset-md-5 {
        margin-left: 41.666667%
    }

    .offset-md-6 {
        margin-left: 50%
    }

    .offset-md-7 {
        margin-left: 58.333333%
    }

    .offset-md-8 {
        margin-left: 66.666667%
    }

    .offset-md-9 {
        margin-left: 75%
    }

    .offset-md-10 {
        margin-left: 83.333333%
    }

    .offset-md-11 {
        margin-left: 91.666667%
    }
}

@media (min-width: 992px) {
    .col-lg {
        -ms-flex-preferred-size:0;
        flex-basis: 0;
        -ms-flex-positive: 1;
        flex-grow: 1;
        max-width: 100%
    }

    .row-cols-lg-1>* {
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%
    }

    .row-cols-lg-2>* {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%
    }

    .row-cols-lg-3>* {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%
    }

    .row-cols-lg-4>* {
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%
    }

    .row-cols-lg-5>* {
        -ms-flex: 0 0 20%;
        flex: 0 0 20%;
        max-width: 20%
    }

    .row-cols-lg-6>* {
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667%
    }

    .col-lg-auto {
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        width: auto;
        max-width: 100%
    }

    .col-lg-1 {
        -ms-flex: 0 0 8.333333%;
        flex: 0 0 8.333333%;
        max-width: 8.333333%
    }

    .col-lg-2 {
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667%
    }

    .col-lg-3 {
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%
    }

    .col-lg-4 {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%
    }

    .col-lg-5 {
        -ms-flex: 0 0 41.666667%;
        flex: 0 0 41.666667%;
        max-width: 41.666667%
    }

    .col-lg-6 {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%
    }

    .col-lg-7 {
        -ms-flex: 0 0 58.333333%;
        flex: 0 0 58.333333%;
        max-width: 58.333333%
    }

    .col-lg-8 {
        -ms-flex: 0 0 66.666667%;
        flex: 0 0 66.666667%;
        max-width: 66.666667%
    }

    .col-lg-9 {
        -ms-flex: 0 0 75%;
        flex: 0 0 75%;
        max-width: 75%
    }

    .col-lg-10 {
        -ms-flex: 0 0 83.333333%;
        flex: 0 0 83.333333%;
        max-width: 83.333333%
    }

    .col-lg-11 {
        -ms-flex: 0 0 91.666667%;
        flex: 0 0 91.666667%;
        max-width: 91.666667%
    }

    .col-lg-12 {
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%
    }

    .order-lg-first {
        -ms-flex-order: -1;
        order: -1
    }

    .order-lg-last {
        -ms-flex-order: 13;
        order: 13
    }

    .order-lg-0 {
        -ms-flex-order: 0;
        order: 0
    }

    .order-lg-1 {
        -ms-flex-order: 1;
        order: 1
    }

    .order-lg-2 {
        -ms-flex-order: 2;
        order: 2
    }

    .order-lg-3 {
        -ms-flex-order: 3;
        order: 3
    }

    .order-lg-4 {
        -ms-flex-order: 4;
        order: 4
    }

    .order-lg-5 {
        -ms-flex-order: 5;
        order: 5
    }

    .order-lg-6 {
        -ms-flex-order: 6;
        order: 6
    }

    .order-lg-7 {
        -ms-flex-order: 7;
        order: 7
    }

    .order-lg-8 {
        -ms-flex-order: 8;
        order: 8
    }

    .order-lg-9 {
        -ms-flex-order: 9;
        order: 9
    }

    .order-lg-10 {
        -ms-flex-order: 10;
        order: 10
    }

    .order-lg-11 {
        -ms-flex-order: 11;
        order: 11
    }

    .order-lg-12 {
        -ms-flex-order: 12;
        order: 12
    }

    .offset-lg-0 {
        margin-left: 0
    }

    .offset-lg-1 {
        margin-left: 8.333333%
    }

    .offset-lg-2 {
        margin-left: 16.666667%
    }

    .offset-lg-3 {
        margin-left: 25%
    }

    .offset-lg-4 {
        margin-left: 33.333333%
    }

    .offset-lg-5 {
        margin-left: 41.666667%
    }

    .offset-lg-6 {
        margin-left: 50%
    }

    .offset-lg-7 {
        margin-left: 58.333333%
    }

    .offset-lg-8 {
        margin-left: 66.666667%
    }

    .offset-lg-9 {
        margin-left: 75%
    }

    .offset-lg-10 {
        margin-left: 83.333333%
    }

    .offset-lg-11 {
        margin-left: 91.666667%
    }
}

@media (min-width: 1200px) {
    .col-xl {
        -ms-flex-preferred-size:0;
        flex-basis: 0;
        -ms-flex-positive: 1;
        flex-grow: 1;
        max-width: 100%
    }

    .row-cols-xl-1>* {
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%
    }

    .row-cols-xl-2>* {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%
    }

    .row-cols-xl-3>* {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%
    }

    .row-cols-xl-4>* {
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%
    }

    .row-cols-xl-5>* {
        -ms-flex: 0 0 20%;
        flex: 0 0 20%;
        max-width: 20%
    }

    .row-cols-xl-6>* {
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667%
    }

    .col-xl-auto {
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        width: auto;
        max-width: 100%
    }

    .col-xl-1 {
        -ms-flex: 0 0 8.333333%;
        flex: 0 0 8.333333%;
        max-width: 8.333333%
    }

    .col-xl-2 {
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667%
    }

    .col-xl-3 {
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%
    }

    .col-xl-4 {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%
    }

    .col-xl-5 {
        -ms-flex: 0 0 41.666667%;
        flex: 0 0 41.666667%;
        max-width: 41.666667%
    }

    .col-xl-6 {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%
    }

    .col-xl-7 {
        -ms-flex: 0 0 58.333333%;
        flex: 0 0 58.333333%;
        max-width: 58.333333%
    }

    .col-xl-8 {
        -ms-flex: 0 0 66.666667%;
        flex: 0 0 66.666667%;
        max-width: 66.666667%
    }

    .col-xl-9 {
        -ms-flex: 0 0 75%;
        flex: 0 0 75%;
        max-width: 75%
    }

    .col-xl-10 {
        -ms-flex: 0 0 83.333333%;
        flex: 0 0 83.333333%;
        max-width: 83.333333%
    }

    .col-xl-11 {
        -ms-flex: 0 0 91.666667%;
        flex: 0 0 91.666667%;
        max-width: 91.666667%
    }

    .col-xl-12 {
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%
    }

    .order-xl-first {
        -ms-flex-order: -1;
        order: -1
    }

    .order-xl-last {
        -ms-flex-order: 13;
        order: 13
    }

    .order-xl-0 {
        -ms-flex-order: 0;
        order: 0
    }

    .order-xl-1 {
        -ms-flex-order: 1;
        order: 1
    }

    .order-xl-2 {
        -ms-flex-order: 2;
        order: 2
    }

    .order-xl-3 {
        -ms-flex-order: 3;
        order: 3
    }

    .order-xl-4 {
        -ms-flex-order: 4;
        order: 4
    }

    .order-xl-5 {
        -ms-flex-order: 5;
        order: 5
    }

    .order-xl-6 {
        -ms-flex-order: 6;
        order: 6
    }

    .order-xl-7 {
        -ms-flex-order: 7;
        order: 7
    }

    .order-xl-8 {
        -ms-flex-order: 8;
        order: 8
    }

    .order-xl-9 {
        -ms-flex-order: 9;
        order: 9
    }

    .order-xl-10 {
        -ms-flex-order: 10;
        order: 10
    }

    .order-xl-11 {
        -ms-flex-order: 11;
        order: 11
    }

    .order-xl-12 {
        -ms-flex-order: 12;
        order: 12
    }

    .offset-xl-0 {
        margin-left: 0
    }

    .offset-xl-1 {
        margin-left: 8.333333%
    }

    .offset-xl-2 {
        margin-left: 16.666667%
    }

    .offset-xl-3 {
        margin-left: 25%
    }

    .offset-xl-4 {
        margin-left: 33.333333%
    }

    .offset-xl-5 {
        margin-left: 41.666667%
    }

    .offset-xl-6 {
        margin-left: 50%
    }

    .offset-xl-7 {
        margin-left: 58.333333%
    }

    .offset-xl-8 {
        margin-left: 66.666667%
    }

    .offset-xl-9 {
        margin-left: 75%
    }

    .offset-xl-10 {
        margin-left: 83.333333%
    }

    .offset-xl-11 {
        margin-left: 91.666667%
    }
}

.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #212529
}

.table td,.table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6
}

.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6
}

.table tbody+tbody {
    border-top: 2px solid #dee2e6
}

.table-sm td,.table-sm th {
    padding: .3rem
}

.table-bordered {
    border: 1px solid #dee2e6
}

.table-bordered td,.table-bordered th {
    border: 1px solid #dee2e6
}

.table-bordered thead td,.table-bordered thead th {
    border-bottom-width: 2px
}

.table-borderless tbody+tbody,.table-borderless td,.table-borderless th,.table-borderless thead th {
    border: 0
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0,0,0,.05)
}

.table-hover tbody tr:hover {
    color: #212529;
    background-color: rgba(0,0,0,.075)
}

.table-primary,.table-primary>td,.table-primary>th {
    background-color: #b8daff
}

.table-primary tbody+tbody,.table-primary td,.table-primary th,.table-primary thead th {
    border-color: #7abaff
}

.table-hover .table-primary:hover {
    background-color: #9fcdff
}

.table-hover .table-primary:hover>td,.table-hover .table-primary:hover>th {
    background-color: #9fcdff
}

.table-secondary,.table-secondary>td,.table-secondary>th {
    background-color: #d6d8db
}

.table-secondary tbody+tbody,.table-secondary td,.table-secondary th,.table-secondary thead th {
    border-color: #b3b7bb
}

.table-hover .table-secondary:hover {
    background-color: #c8cbcf
}

.table-hover .table-secondary:hover>td,.table-hover .table-secondary:hover>th {
    background-color: #c8cbcf
}

.table-success,.table-success>td,.table-success>th {
    background-color: #c3e6cb
}

.table-success tbody+tbody,.table-success td,.table-success th,.table-success thead th {
    border-color: #8fd19e
}

.table-hover .table-success:hover {
    background-color: #b1dfbb
}

.table-hover .table-success:hover>td,.table-hover .table-success:hover>th {
    background-color: #b1dfbb
}

.table-info,.table-info>td,.table-info>th {
    background-color: #bee5eb
}

.table-info tbody+tbody,.table-info td,.table-info th,.table-info thead th {
    border-color: #86cfda
}

.table-hover .table-info:hover {
    background-color: #abdde5
}

.table-hover .table-info:hover>td,.table-hover .table-info:hover>th {
    background-color: #abdde5
}

.table-warning,.table-warning>td,.table-warning>th {
    background-color: #ffeeba
}

.table-warning tbody+tbody,.table-warning td,.table-warning th,.table-warning thead th {
    border-color: #ffdf7e
}

.table-hover .table-warning:hover {
    background-color: #ffe8a1
}

.table-hover .table-warning:hover>td,.table-hover .table-warning:hover>th {
    background-color: #ffe8a1
}

.table-danger,.table-danger>td,.table-danger>th {
    background-color: #f5c6cb
}

.table-danger tbody+tbody,.table-danger td,.table-danger th,.table-danger thead th {
    border-color: #ed969e
}

.table-hover .table-danger:hover {
    background-color: #f1b0b7
}

.table-hover .table-danger:hover>td,.table-hover .table-danger:hover>th {
    background-color: #f1b0b7
}

.table-light,.table-light>td,.table-light>th {
    background-color: #fdfdfe
}

.table-light tbody+tbody,.table-light td,.table-light th,.table-light thead th {
    border-color: #fbfcfc
}

.table-hover .table-light:hover {
    background-color: #ececf6
}

.table-hover .table-light:hover>td,.table-hover .table-light:hover>th {
    background-color: #ececf6
}

.table-dark,.table-dark>td,.table-dark>th {
    background-color: #c6c8ca
}

.table-dark tbody+tbody,.table-dark td,.table-dark th,.table-dark thead th {
    border-color: #95999c
}

.table-hover .table-dark:hover {
    background-color: #b9bbbe
}

.table-hover .table-dark:hover>td,.table-hover .table-dark:hover>th {
    background-color: #b9bbbe
}

.table-active,.table-active>td,.table-active>th {
    background-color: rgba(0,0,0,.075)
}

.table-hover .table-active:hover {
    background-color: rgba(0,0,0,.075)
}

.table-hover .table-active:hover>td,.table-hover .table-active:hover>th {
    background-color: rgba(0,0,0,.075)
}

.table .thead-dark th {
    color: #fff;
    background-color: #343a40;
    border-color: #454d55
}

.table .thead-light th {
    color: #495057;
    background-color: #e9ecef;
    border-color: #dee2e6
}

.table-dark {
    color: #fff;
    background-color: #343a40
}

.table-dark td,.table-dark th,.table-dark thead th {
    border-color: #454d55
}

.table-dark.table-bordered {
    border: 0
}

.table-dark.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(255,255,255,.05)
}

.table-dark.table-hover tbody tr:hover {
    color: #fff;
    background-color: rgba(255,255,255,.075)
}

@media (max-width: 575.98px) {
    .table-responsive-sm {
        display:block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch
    }

    .table-responsive-sm>.table-bordered {
        border: 0
    }
}

@media (max-width: 767.98px) {
    .table-responsive-md {
        display:block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch
    }

    .table-responsive-md>.table-bordered {
        border: 0
    }
}

@media (max-width: 991.98px) {
    .table-responsive-lg {
        display:block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch
    }

    .table-responsive-lg>.table-bordered {
        border: 0
    }
}

@media (max-width: 1199.98px) {
    .table-responsive-xl {
        display:block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch
    }

    .table-responsive-xl>.table-bordered {
        border: 0
    }
}

.table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch
}

.table-responsive>.table-bordered {
    border: 0
}

.form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out
}

@media (prefers-reduced-motion:reduce) {
    .form-control {
        transition: none
    }
}

.form-control::-ms-expand {
    background-color: transparent;
    border: 0
}

.form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 .2rem rgba(0,123,255,.25)
}

.form-control::-webkit-input-placeholder {
    color: #6c757d;
    opacity: 1
}

.form-control::-moz-placeholder {
    color: #6c757d;
    opacity: 1
}

.form-control:-ms-input-placeholder {
    color: #6c757d;
    opacity: 1
}

.form-control::-ms-input-placeholder {
    color: #6c757d;
    opacity: 1
}

.form-control::placeholder {
    color: #6c757d;
    opacity: 1
}

.form-control:disabled,.form-control[readonly] {
    background-color: #e9ecef;
    opacity: 1
}

input[type=date].form-control,input[type=datetime-local].form-control,input[type=month].form-control,input[type=time].form-control {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none
}

select.form-control:-moz-focusring {
    color: transparent;
    text-shadow: 0 0 0 #495057
}

select.form-control:focus::-ms-value {
    color: #495057;
    background-color: #fff
}

.form-control-file,.form-control-range {
    display: block;
    width: 100%
}

.col-form-label {
    padding-top: calc(.375rem + 1px);
    padding-bottom: calc(.375rem + 1px);
    margin-bottom: 0;
    font-size: inherit;
    line-height: 1.5
}

.col-form-label-lg {
    padding-top: calc(.5rem + 1px);
    padding-bottom: calc(.5rem + 1px);
    font-size: 1.25rem;
    line-height: 1.5
}

.col-form-label-sm {
    padding-top: calc(.25rem + 1px);
    padding-bottom: calc(.25rem + 1px);
    font-size: .875rem;
    line-height: 1.5
}

.form-control-plaintext {
    display: block;
    width: 100%;
    padding: .375rem 0;
    margin-bottom: 0;
    font-size: 1rem;
    line-height: 1.5;
    color: #212529;
    background-color: transparent;
    border: solid transparent;
    border-width: 1px 0
}

.form-control-plaintext.form-control-lg,.form-control-plaintext.form-control-sm {
    padding-right: 0;
    padding-left: 0
}

.form-control-sm {
    height: calc(1.5em + .5rem + 2px);
    padding: .25rem .5rem;
    font-size: .875rem;
    line-height: 1.5;
    border-radius: .2rem
}

.form-control-lg {
    height: calc(1.5em + 1rem + 2px);
    padding: .5rem 1rem;
    font-size: 1.25rem;
    line-height: 1.5;
    border-radius: .3rem
}

select.form-control[multiple],select.form-control[size] {
    height: auto
}

textarea.form-control {
    height: auto
}

.form-group {
    margin-bottom: 1rem
}

.form-text {
    display: block;
    margin-top: .25rem
}

.form-row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -5px;
    margin-left: -5px
}

.form-row>.col,.form-row>[class*=col-] {
    padding-right: 5px;
    padding-left: 5px
}

.form-check {
    position: relative;
    display: block;
    padding-left: 1.25rem
}

.form-check-input {
    position: absolute;
    margin-top: .3rem;
    margin-left: -1.25rem
}

.form-check-input:disabled~.form-check-label,.form-check-input[disabled]~.form-check-label {
    color: #6c757d
}

.form-check-label {
    margin-bottom: 0
}

.form-check-inline {
    display: -ms-inline-flexbox;
    display: inline-flex;
    -ms-flex-align: center;
    align-items: center;
    padding-left: 0;
    margin-right: .75rem
}

.form-check-inline .form-check-input {
    position: static;
    margin-top: 0;
    margin-right: .3125rem;
    margin-left: 0
}

.valid-feedback {
    display: none;
    width: 100%;
    margin-top: .25rem;
    font-size: .875em;
    color: #28a745
}

.valid-tooltip {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 5;
    display: none;
    max-width: 100%;
    padding: .25rem .5rem;
    margin-top: .1rem;
    font-size: .875rem;
    line-height: 1.5;
    color: #fff;
    background-color: rgba(40,167,69,.9);
    border-radius: .25rem
}

.form-row>.col>.valid-tooltip,.form-row>[class*=col-]>.valid-tooltip {
    left: 5px
}

.is-valid~.valid-feedback,.is-valid~.valid-tooltip,.was-validated :valid~.valid-feedback,.was-validated :valid~.valid-tooltip {
    display: block
}

.form-control.is-valid,.was-validated .form-control:valid {
    border-color: #28a745;
    padding-right: calc(1.5em + .75rem)!important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(.375em + .1875rem) center;
    background-size: calc(.75em + .375rem) calc(.75em + .375rem)
}

.form-control.is-valid:focus,.was-validated .form-control:valid:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 .2rem rgba(40,167,69,.25)
}

.was-validated select.form-control:valid,select.form-control.is-valid {
    padding-right: 3rem!important;
    background-position: right 1.5rem center
}

.was-validated textarea.form-control:valid,textarea.form-control.is-valid {
    padding-right: calc(1.5em + .75rem);
    background-position: top calc(.375em + .1875rem) right calc(.375em + .1875rem)
}

.custom-select.is-valid,.was-validated .custom-select:valid {
    border-color: #28a745;
    padding-right: calc(.75em + 2.3125rem)!important;
    background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") right .75rem center/8px 10px no-repeat,#fff url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e") center right 1.75rem/calc(.75em + .375rem) calc(.75em + .375rem) no-repeat
}

.custom-select.is-valid:focus,.was-validated .custom-select:valid:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 .2rem rgba(40,167,69,.25)
}

.form-check-input.is-valid~.form-check-label,.was-validated .form-check-input:valid~.form-check-label {
    color: #28a745
}

.form-check-input.is-valid~.valid-feedback,.form-check-input.is-valid~.valid-tooltip,.was-validated .form-check-input:valid~.valid-feedback,.was-validated .form-check-input:valid~.valid-tooltip {
    display: block
}

.custom-control-input.is-valid~.custom-control-label,.was-validated .custom-control-input:valid~.custom-control-label {
    color: #28a745
}

.custom-control-input.is-valid~.custom-control-label::before,.was-validated .custom-control-input:valid~.custom-control-label::before {
    border-color: #28a745
}

.custom-control-input.is-valid:checked~.custom-control-label::before,.was-validated .custom-control-input:valid:checked~.custom-control-label::before {
    border-color: #34ce57;
    background-color: #34ce57
}

.custom-control-input.is-valid:focus~.custom-control-label::before,.was-validated .custom-control-input:valid:focus~.custom-control-label::before {
    box-shadow: 0 0 0 .2rem rgba(40,167,69,.25)
}

.custom-control-input.is-valid:focus:not(:checked)~.custom-control-label::before,.was-validated .custom-control-input:valid:focus:not(:checked)~.custom-control-label::before {
    border-color: #28a745
}

.custom-file-input.is-valid~.custom-file-label,.was-validated .custom-file-input:valid~.custom-file-label {
    border-color: #28a745
}

.custom-file-input.is-valid:focus~.custom-file-label,.was-validated .custom-file-input:valid:focus~.custom-file-label {
    border-color: #28a745;
    box-shadow: 0 0 0 .2rem rgba(40,167,69,.25)
}

.invalid-feedback {
    display: none;
    width: 100%;
    margin-top: .25rem;
    font-size: .875em;
    color: #dc3545
}

.invalid-tooltip {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 5;
    display: none;
    max-width: 100%;
    padding: .25rem .5rem;
    margin-top: .1rem;
    font-size: .875rem;
    line-height: 1.5;
    color: #fff;
    background-color: rgba(220,53,69,.9);
    border-radius: .25rem
}

.form-row>.col>.invalid-tooltip,.form-row>[class*=col-]>.invalid-tooltip {
    left: 5px
}

.is-invalid~.invalid-feedback,.is-invalid~.invalid-tooltip,.was-validated :invalid~.invalid-feedback,.was-validated :invalid~.invalid-tooltip {
    display: block
}

.form-control.is-invalid,.was-validated .form-control:invalid {
    border-color: #dc3545;
    padding-right: calc(1.5em + .75rem)!important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(.375em + .1875rem) center;
    background-size: calc(.75em + .375rem) calc(.75em + .375rem)
}

.form-control.is-invalid:focus,.was-validated .form-control:invalid:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 .2rem rgba(220,53,69,.25)
}

.was-validated select.form-control:invalid,select.form-control.is-invalid {
    padding-right: 3rem!important;
    background-position: right 1.5rem center
}

.was-validated textarea.form-control:invalid,textarea.form-control.is-invalid {
    padding-right: calc(1.5em + .75rem);
    background-position: top calc(.375em + .1875rem) right calc(.375em + .1875rem)
}

.custom-select.is-invalid,.was-validated .custom-select:invalid {
    border-color: #dc3545;
    padding-right: calc(.75em + 2.3125rem)!important;
    background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") right .75rem center/8px 10px no-repeat,#fff url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e") center right 1.75rem/calc(.75em + .375rem) calc(.75em + .375rem) no-repeat
}

.custom-select.is-invalid:focus,.was-validated .custom-select:invalid:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 .2rem rgba(220,53,69,.25)
}

.form-check-input.is-invalid~.form-check-label,.was-validated .form-check-input:invalid~.form-check-label {
    color: #dc3545
}

.form-check-input.is-invalid~.invalid-feedback,.form-check-input.is-invalid~.invalid-tooltip,.was-validated .form-check-input:invalid~.invalid-feedback,.was-validated .form-check-input:invalid~.invalid-tooltip {
    display: block
}

.custom-control-input.is-invalid~.custom-control-label,.was-validated .custom-control-input:invalid~.custom-control-label {
    color: #dc3545
}

.custom-control-input.is-invalid~.custom-control-label::before,.was-validated .custom-control-input:invalid~.custom-control-label::before {
    border-color: #dc3545
}

.custom-control-input.is-invalid:checked~.custom-control-label::before,.was-validated .custom-control-input:invalid:checked~.custom-control-label::before {
    border-color: #e4606d;
    background-color: #e4606d
}

.custom-control-input.is-invalid:focus~.custom-control-label::before,.was-validated .custom-control-input:invalid:focus~.custom-control-label::before {
    box-shadow: 0 0 0 .2rem rgba(220,53,69,.25)
}

.custom-control-input.is-invalid:focus:not(:checked)~.custom-control-label::before,.was-validated .custom-control-input:invalid:focus:not(:checked)~.custom-control-label::before {
    border-color: #dc3545
}

.custom-file-input.is-invalid~.custom-file-label,.was-validated .custom-file-input:invalid~.custom-file-label {
    border-color: #dc3545
}

.custom-file-input.is-invalid:focus~.custom-file-label,.was-validated .custom-file-input:invalid:focus~.custom-file-label {
    border-color: #dc3545;
    box-shadow: 0 0 0 .2rem rgba(220,53,69,.25)
}

.form-inline {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-flow: row wrap;
    flex-flow: row wrap;
    -ms-flex-align: center;
    align-items: center
}

.form-inline .form-check {
    width: 100%
}

@media (min-width: 576px) {
    .form-inline label {
        display:-ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-pack: center;
        justify-content: center;
        margin-bottom: 0
    }

    .form-inline .form-group {
        display: -ms-flexbox;
        display: flex;
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        -ms-flex-flow: row wrap;
        flex-flow: row wrap;
        -ms-flex-align: center;
        align-items: center;
        margin-bottom: 0
    }

    .form-inline .form-control {
        display: inline-block;
        width: auto;
        vertical-align: middle
    }

    .form-inline .form-control-plaintext {
        display: inline-block
    }

    .form-inline .custom-select,.form-inline .input-group {
        width: auto
    }

    .form-inline .form-check {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-pack: center;
        justify-content: center;
        width: auto;
        padding-left: 0
    }

    .form-inline .form-check-input {
        position: relative;
        -ms-flex-negative: 0;
        flex-shrink: 0;
        margin-top: 0;
        margin-right: .25rem;
        margin-left: 0
    }

    .form-inline .custom-control {
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-pack: center;
        justify-content: center
    }

    .form-inline .custom-control-label {
        margin-bottom: 0
    }
}

.btn {
    display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out
}

@media (prefers-reduced-motion:reduce) {
    .btn {
        transition: none
    }
}

.btn:hover {
    color: #212529;
    text-decoration: none
}

.btn.focus,.btn:focus {
    outline: 0;
    box-shadow: 0 0 0 .2rem rgba(0,123,255,.25)
}

.btn.disabled,.btn:disabled {
    opacity: .65
}

.btn:not(:disabled):not(.disabled) {
    cursor: pointer
}

a.btn.disabled,fieldset:disabled a.btn {
    pointer-events: none
}

.btn-primary {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff
}

.btn-primary:hover {
    color: #fff;
    background-color: #0069d9;
    border-color: #0062cc
}

.btn-primary.focus,.btn-primary:focus {
    color: #fff;
    background-color: #0069d9;
    border-color: #0062cc;
    box-shadow: 0 0 0 .2rem rgba(38,143,255,.5)
}

.btn-primary.disabled,.btn-primary:disabled {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff
}

.btn-primary:not(:disabled):not(.disabled).active,.btn-primary:not(:disabled):not(.disabled):active,.show>.btn-primary.dropdown-toggle {
    color: #fff;
    background-color: #0062cc;
    border-color: #005cbf
}

.btn-primary:not(:disabled):not(.disabled).active:focus,.btn-primary:not(:disabled):not(.disabled):active:focus,.show>.btn-primary.dropdown-toggle:focus {
    box-shadow: 0 0 0 .2rem rgba(38,143,255,.5)
}

.btn-secondary {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d
}

.btn-secondary:hover {
    color: #fff;
    background-color: #5a6268;
    border-color: #545b62
}

.btn-secondary.focus,.btn-secondary:focus {
    color: #fff;
    background-color: #5a6268;
    border-color: #545b62;
    box-shadow: 0 0 0 .2rem rgba(130,138,145,.5)
}

.btn-secondary.disabled,.btn-secondary:disabled {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d
}

.btn-secondary:not(:disabled):not(.disabled).active,.btn-secondary:not(:disabled):not(.disabled):active,.show>.btn-secondary.dropdown-toggle {
    color: #fff;
    background-color: #545b62;
    border-color: #4e555b
}

.btn-secondary:not(:disabled):not(.disabled).active:focus,.btn-secondary:not(:disabled):not(.disabled):active:focus,.show>.btn-secondary.dropdown-toggle:focus {
    box-shadow: 0 0 0 .2rem rgba(130,138,145,.5)
}

.btn-success {
    color: #fff;
    background-color: #28a745;
    border-color: #28a745
}

.btn-success:hover {
    color: #fff;
    background-color: #218838;
    border-color: #1e7e34
}

.btn-success.focus,.btn-success:focus {
    color: #fff;
    background-color: #218838;
    border-color: #1e7e34;
    box-shadow: 0 0 0 .2rem rgba(72,180,97,.5)
}

.btn-success.disabled,.btn-success:disabled {
    color: #fff;
    background-color: #28a745;
    border-color: #28a745
}

.btn-success:not(:disabled):not(.disabled).active,.btn-success:not(:disabled):not(.disabled):active,.show>.btn-success.dropdown-toggle {
    color: #fff;
    background-color: #1e7e34;
    border-color: #1c7430
}

.btn-success:not(:disabled):not(.disabled).active:focus,.btn-success:not(:disabled):not(.disabled):active:focus,.show>.btn-success.dropdown-toggle:focus {
    box-shadow: 0 0 0 .2rem rgba(72,180,97,.5)
}

.btn-info {
    color: #fff;
    background-color: #17a2b8;
    border-color: #17a2b8
}

.btn-info:hover {
    color: #fff;
    background-color: #138496;
    border-color: #117a8b
}

.btn-info.focus,.btn-info:focus {
    color: #fff;
    background-color: #138496;
    border-color: #117a8b;
    box-shadow: 0 0 0 .2rem rgba(58,176,195,.5)
}

.btn-info.disabled,.btn-info:disabled {
    color: #fff;
    background-color: #17a2b8;
    border-color: #17a2b8
}

.btn-info:not(:disabled):not(.disabled).active,.btn-info:not(:disabled):not(.disabled):active,.show>.btn-info.dropdown-toggle {
    color: #fff;
    background-color: #117a8b;
    border-color: #10707f
}

.btn-info:not(:disabled):not(.disabled).active:focus,.btn-info:not(:disabled):not(.disabled):active:focus,.show>.btn-info.dropdown-toggle:focus {
    box-shadow: 0 0 0 .2rem rgba(58,176,195,.5)
}

.btn-warning {
    color: #212529;
    background-color: #ffc107;
    border-color: #ffc107
}

.btn-warning:hover {
    color: #212529;
    background-color: #e0a800;
    border-color: #d39e00
}

.btn-warning.focus,.btn-warning:focus {
    color: #212529;
    background-color: #e0a800;
    border-color: #d39e00;
    box-shadow: 0 0 0 .2rem rgba(222,170,12,.5)
}

.btn-warning.disabled,.btn-warning:disabled {
    color: #212529;
    background-color: #ffc107;
    border-color: #ffc107
}

.btn-warning:not(:disabled):not(.disabled).active,.btn-warning:not(:disabled):not(.disabled):active,.show>.btn-warning.dropdown-toggle {
    color: #212529;
    background-color: #d39e00;
    border-color: #c69500
}

.btn-warning:not(:disabled):not(.disabled).active:focus,.btn-warning:not(:disabled):not(.disabled):active:focus,.show>.btn-warning.dropdown-toggle:focus {
    box-shadow: 0 0 0 .2rem rgba(222,170,12,.5)
}

.btn-danger {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545
}

.btn-danger:hover {
    color: #fff;
    background-color: #c82333;
    border-color: #bd2130
}

.btn-danger.focus,.btn-danger:focus {
    color: #fff;
    background-color: #c82333;
    border-color: #bd2130;
    box-shadow: 0 0 0 .2rem rgba(225,83,97,.5)
}

.btn-danger.disabled,.btn-danger:disabled {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545
}

.btn-danger:not(:disabled):not(.disabled).active,.btn-danger:not(:disabled):not(.disabled):active,.show>.btn-danger.dropdown-toggle {
    color: #fff;
    background-color: #bd2130;
    border-color: #b21f2d
}

.btn-danger:not(:disabled):not(.disabled).active:focus,.btn-danger:not(:disabled):not(.disabled):active:focus,.show>.btn-danger.dropdown-toggle:focus {
    box-shadow: 0 0 0 .2rem rgba(225,83,97,.5)
}

.btn-light {
    color: #212529;
    background-color: #f8f9fa;
    border-color: #f8f9fa
}

.btn-light:hover {
    color: #212529;
    background-color: #e2e6ea;
    border-color: #dae0e5
}

.btn-light.focus,.btn-light:focus {
    color: #212529;
    background-color: #e2e6ea;
    border-color: #dae0e5;
    box-shadow: 0 0 0 .2rem rgba(216,217,219,.5)
}

.btn-light.disabled,.btn-light:disabled {
    color: #212529;
    background-color: #f8f9fa;
    border-color: #f8f9fa
}

.btn-light:not(:disabled):not(.disabled).active,.btn-light:not(:disabled):not(.disabled):active,.show>.btn-light.dropdown-toggle {
    color: #212529;
    background-color: #dae0e5;
    border-color: #d3d9df
}

.btn-light:not(:disabled):not(.disabled).active:focus,.btn-light:not(:disabled):not(.disabled):active:focus,.show>.btn-light.dropdown-toggle:focus {
    box-shadow: 0 0 0 .2rem rgba(216,217,219,.5)
}

.btn-dark {
    color: #fff;
    background-color: #343a40;
    border-color: #343a40
}

.btn-dark:hover {
    color: #fff;
    background-color: #23272b;
    border-color: #1d2124
}

.btn-dark.focus,.btn-dark:focus {
    color: #fff;
    background-color: #23272b;
    border-color: #1d2124;
    box-shadow: 0 0 0 .2rem rgba(82,88,93,.5)
}

.btn-dark.disabled,.btn-dark:disabled {
    color: #fff;
    background-color: #343a40;
    border-color: #343a40
}

.btn-dark:not(:disabled):not(.disabled).active,.btn-dark:not(:disabled):not(.disabled):active,.show>.btn-dark.dropdown-toggle {
    color: #fff;
    background-color: #1d2124;
    border-color: #171a1d
}

.btn-dark:not(:disabled):not(.disabled).active:focus,.btn-dark:not(:disabled):not(.disabled):active:focus,.show>.btn-dark.dropdown-toggle:focus {
    box-shadow: 0 0 0 .2rem rgba(82,88,93,.5)
}

.btn-outline-primary {
    color: #007bff;
    border-color: #007bff
}

.btn-outline-primary:hover {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff
}

.btn-outline-primary.focus,.btn-outline-primary:focus {
    box-shadow: 0 0 0 .2rem rgba(0,123,255,.5)
}

.btn-outline-primary.disabled,.btn-outline-primary:disabled {
    color: #007bff;
    background-color: transparent
}

.btn-outline-primary:not(:disabled):not(.disabled).active,.btn-outline-primary:not(:disabled):not(.disabled):active,.show>.btn-outline-primary.dropdown-toggle {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff
}

.btn-outline-primary:not(:disabled):not(.disabled).active:focus,.btn-outline-primary:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-primary.dropdown-toggle:focus {
    box-shadow: 0 0 0 .2rem rgba(0,123,255,.5)
}

.btn-outline-secondary {
    color: #6c757d;
    border-color: #6c757d
}

.btn-outline-secondary:hover {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d
}

.btn-outline-secondary.focus,.btn-outline-secondary:focus {
    box-shadow: 0 0 0 .2rem rgba(108,117,125,.5)
}

.btn-outline-secondary.disabled,.btn-outline-secondary:disabled {
    color: #6c757d;
    background-color: transparent
}

.btn-outline-secondary:not(:disabled):not(.disabled).active,.btn-outline-secondary:not(:disabled):not(.disabled):active,.show>.btn-outline-secondary.dropdown-toggle {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d
}

.btn-outline-secondary:not(:disabled):not(.disabled).active:focus,.btn-outline-secondary:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-secondary.dropdown-toggle:focus {
    box-shadow: 0 0 0 .2rem rgba(108,117,125,.5)
}

.btn-outline-success {
    color: #28a745;
    border-color: #28a745
}

.btn-outline-success:hover {
    color: #fff;
    background-color: #28a745;
    border-color: #28a745
}

.btn-outline-success.focus,.btn-outline-success:focus {
    box-shadow: 0 0 0 .2rem rgba(40,167,69,.5)
}

.btn-outline-success.disabled,.btn-outline-success:disabled {
    color: #28a745;
    background-color: transparent
}

.btn-outline-success:not(:disabled):not(.disabled).active,.btn-outline-success:not(:disabled):not(.disabled):active,.show>.btn-outline-success.dropdown-toggle {
    color: #fff;
    background-color: #28a745;
    border-color: #28a745
}

.btn-outline-success:not(:disabled):not(.disabled).active:focus,.btn-outline-success:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-success.dropdown-toggle:focus {
    box-shadow: 0 0 0 .2rem rgba(40,167,69,.5)
}

.btn-outline-info {
    color: #17a2b8;
    border-color: #17a2b8
}

.btn-outline-info:hover {
    color: #fff;
    background-color: #17a2b8;
    border-color: #17a2b8
}

.btn-outline-info.focus,.btn-outline-info:focus {
    box-shadow: 0 0 0 .2rem rgba(23,162,184,.5)
}

.btn-outline-info.disabled,.btn-outline-info:disabled {
    color: #17a2b8;
    background-color: transparent
}

.btn-outline-info:not(:disabled):not(.disabled).active,.btn-outline-info:not(:disabled):not(.disabled):active,.show>.btn-outline-info.dropdown-toggle {
    color: #fff;
    background-color: #17a2b8;
    border-color: #17a2b8
}

.btn-outline-info:not(:disabled):not(.disabled).active:focus,.btn-outline-info:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-info.dropdown-toggle:focus {
    box-shadow: 0 0 0 .2rem rgba(23,162,184,.5)
}

.btn-outline-warning {
    color: #ffc107;
    border-color: #ffc107
}

.btn-outline-warning:hover {
    color: #212529;
    background-color: #ffc107;
    border-color: #ffc107
}

.btn-outline-warning.focus,.btn-outline-warning:focus {
    box-shadow: 0 0 0 .2rem rgba(255,193,7,.5)
}

.btn-outline-warning.disabled,.btn-outline-warning:disabled {
    color: #ffc107;
    background-color: transparent
}

.btn-outline-warning:not(:disabled):not(.disabled).active,.btn-outline-warning:not(:disabled):not(.disabled):active,.show>.btn-outline-warning.dropdown-toggle {
    color: #212529;
    background-color: #ffc107;
    border-color: #ffc107
}

.btn-outline-warning:not(:disabled):not(.disabled).active:focus,.btn-outline-warning:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-warning.dropdown-toggle:focus {
    box-shadow: 0 0 0 .2rem rgba(255,193,7,.5)
}

.btn-outline-danger {
    color: #dc3545;
    border-color: #dc3545
}

.btn-outline-danger:hover {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545
}

.btn-outline-danger.focus,.btn-outline-danger:focus {
    box-shadow: 0 0 0 .2rem rgba(220,53,69,.5)
}

.btn-outline-danger.disabled,.btn-outline-danger:disabled {
    color: #dc3545;
    background-color: transparent
}

.btn-outline-danger:not(:disabled):not(.disabled).active,.btn-outline-danger:not(:disabled):not(.disabled):active,.show>.btn-outline-danger.dropdown-toggle {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545
}

.btn-outline-danger:not(:disabled):not(.disabled).active:focus,.btn-outline-danger:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-danger.dropdown-toggle:focus {
    box-shadow: 0 0 0 .2rem rgba(220,53,69,.5)
}

.btn-outline-light {
    color: #f8f9fa;
    border-color: #f8f9fa
}

.btn-outline-light:hover {
    color: #212529;
    background-color: #f8f9fa;
    border-color: #f8f9fa
}

.btn-outline-light.focus,.btn-outline-light:focus {
    box-shadow: 0 0 0 .2rem rgba(248,249,250,.5)
}

.btn-outline-light.disabled,.btn-outline-light:disabled {
    color: #f8f9fa;
    background-color: transparent
}

.btn-outline-light:not(:disabled):not(.disabled).active,.btn-outline-light:not(:disabled):not(.disabled):active,.show>.btn-outline-light.dropdown-toggle {
    color: #212529;
    background-color: #f8f9fa;
    border-color: #f8f9fa
}

.btn-outline-light:not(:disabled):not(.disabled).active:focus,.btn-outline-light:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-light.dropdown-toggle:focus {
    box-shadow: 0 0 0 .2rem rgba(248,249,250,.5)
}

.btn-outline-dark {
    color: #343a40;
    border-color: #343a40
}

.btn-outline-dark:hover {
    color: #fff;
    background-color: #343a40;
    border-color: #343a40
}

.btn-outline-dark.focus,.btn-outline-dark:focus {
    box-shadow: 0 0 0 .2rem rgba(52,58,64,.5)
}

.btn-outline-dark.disabled,.btn-outline-dark:disabled {
    color: #343a40;
    background-color: transparent
}

.btn-outline-dark:not(:disabled):not(.disabled).active,.btn-outline-dark:not(:disabled):not(.disabled):active,.show>.btn-outline-dark.dropdown-toggle {
    color: #fff;
    background-color: #343a40;
    border-color: #343a40
}

.btn-outline-dark:not(:disabled):not(.disabled).active:focus,.btn-outline-dark:not(:disabled):not(.disabled):active:focus,.show>.btn-outline-dark.dropdown-toggle:focus {
    box-shadow: 0 0 0 .2rem rgba(52,58,64,.5)
}

.btn-link {
    font-weight: 400;
    color: #007bff;
    text-decoration: none
}

.btn-link:hover {
    color: #0056b3;
    text-decoration: underline
}

.btn-link.focus,.btn-link:focus {
    text-decoration: underline
}

.btn-link.disabled,.btn-link:disabled {
    color: #6c757d;
    pointer-events: none
}

.btn-group-lg>.btn,.btn-lg {
    padding: .5rem 1rem;
    font-size: 1.25rem;
    line-height: 1.5;
    border-radius: .3rem
}

.btn-group-sm>.btn,.btn-sm {
    padding: .25rem .5rem;
    font-size: .875rem;
    line-height: 1.5;
    border-radius: .2rem
}

.btn-block {
    display: block;
    width: 100%
}

.btn-block+.btn-block {
    margin-top: .5rem
}

input[type=button].btn-block,input[type=reset].btn-block,input[type=submit].btn-block {
    width: 100%
}

.fade {
    transition: opacity .15s linear
}

@media (prefers-reduced-motion:reduce) {
    .fade {
        transition: none
    }
}

.fade:not(.show) {
    opacity: 0
}

.collapse:not(.show) {
    display: none
}

.collapsing {
    position: relative;
    height: 0;
    overflow: hidden;
    transition: height .35s ease
}

@media (prefers-reduced-motion:reduce) {
    .collapsing {
        transition: none
    }
}

.collapsing.width {
    width: 0;
    height: auto;
    transition: width .35s ease
}

@media (prefers-reduced-motion:reduce) {
    .collapsing.width {
        transition: none
    }
}

.dropdown,.dropleft,.dropright,.dropup {
    position: relative
}

.dropdown-toggle {
    white-space: nowrap
}

.dropdown-toggle::after {
    display: inline-block;
    margin-left: .255em;
    vertical-align: .255em;
    content: "";
    border-top: .3em solid;
    border-right: .3em solid transparent;
    border-bottom: 0;
    border-left: .3em solid transparent
}

.dropdown-toggle:empty::after {
    margin-left: 0
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    float: left;
    min-width: 10rem;
    padding: .5rem 0;
    margin: .125rem 0 0;
    font-size: 1rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: .25rem
}

.dropdown-menu-left {
    right: auto;
    left: 0
}

.dropdown-menu-right {
    right: 0;
    left: auto
}

@media (min-width: 576px) {
    .dropdown-menu-sm-left {
        right:auto;
        left: 0
    }

    .dropdown-menu-sm-right {
        right: 0;
        left: auto
    }
}

@media (min-width: 768px) {
    .dropdown-menu-md-left {
        right:auto;
        left: 0
    }

    .dropdown-menu-md-right {
        right: 0;
        left: auto
    }
}

@media (min-width: 992px) {
    .dropdown-menu-lg-left {
        right:auto;
        left: 0
    }

    .dropdown-menu-lg-right {
        right: 0;
        left: auto
    }
}

@media (min-width: 1200px) {
    .dropdown-menu-xl-left {
        right:auto;
        left: 0
    }

    .dropdown-menu-xl-right {
        right: 0;
        left: auto
    }
}

.dropup .dropdown-menu {
    top: auto;
    bottom: 100%;
    margin-top: 0;
    margin-bottom: .125rem
}

.dropup .dropdown-toggle::after {
    display: inline-block;
    margin-left: .255em;
    vertical-align: .255em;
    content: "";
    border-top: 0;
    border-right: .3em solid transparent;
    border-bottom: .3em solid;
    border-left: .3em solid transparent
}

.dropup .dropdown-toggle:empty::after {
    margin-left: 0
}

.dropright .dropdown-menu {
    top: 0;
    right: auto;
    left: 100%;
    margin-top: 0;
    margin-left: .125rem
}

.dropright .dropdown-toggle::after {
    display: inline-block;
    margin-left: .255em;
    vertical-align: .255em;
    content: "";
    border-top: .3em solid transparent;
    border-right: 0;
    border-bottom: .3em solid transparent;
    border-left: .3em solid
}

.dropright .dropdown-toggle:empty::after {
    margin-left: 0
}

.dropright .dropdown-toggle::after {
    vertical-align: 0
}

.dropleft .dropdown-menu {
    top: 0;
    right: 100%;
    left: auto;
    margin-top: 0;
    margin-right: .125rem
}

.dropleft .dropdown-toggle::after {
    display: inline-block;
    margin-left: .255em;
    vertical-align: .255em;
    content: ""
}

.dropleft .dropdown-toggle::after {
    display: none
}

.dropleft .dropdown-toggle::before {
    display: inline-block;
    margin-right: .255em;
    vertical-align: .255em;
    content: "";
    border-top: .3em solid transparent;
    border-right: .3em solid;
    border-bottom: .3em solid transparent
}

.dropleft .dropdown-toggle:empty::after {
    margin-left: 0
}

.dropleft .dropdown-toggle::before {
    vertical-align: 0
}

.dropdown-menu[x-placement^=bottom],.dropdown-menu[x-placement^=left],.dropdown-menu[x-placement^=right],.dropdown-menu[x-placement^=top] {
    right: auto;
    bottom: auto
}

.dropdown-divider {
    height: 0;
    margin: .5rem 0;
    overflow: hidden;
    border-top: 1px solid #e9ecef
}

.dropdown-item {
    display: block;
    width: 100%;
    padding: .25rem 1.5rem;
    clear: both;
    font-weight: 400;
    color: #212529;
    text-align: inherit;
    white-space: nowrap;
    background-color: transparent;
    border: 0
}

.dropdown-item:focus,.dropdown-item:hover {
    color: #16181b;
    text-decoration: none;
    background-color: #e9ecef
}

.dropdown-item.active,.dropdown-item:active {
    color: #fff;
    text-decoration: none;
    background-color: #007bff
}

.dropdown-item.disabled,.dropdown-item:disabled {
    color: #adb5bd;
    pointer-events: none;
    background-color: transparent
}

.dropdown-menu.show {
    display: block
}

.dropdown-header {
    display: block;
    padding: .5rem 1.5rem;
    margin-bottom: 0;
    font-size: .875rem;
    color: #6c757d;
    white-space: nowrap
}

.dropdown-item-text {
    display: block;
    padding: .25rem 1.5rem;
    color: #212529
}

.btn-group,.btn-group-vertical {
    position: relative;
    display: -ms-inline-flexbox;
    display: inline-flex;
    vertical-align: middle
}

.btn-group-vertical>.btn,.btn-group>.btn {
    position: relative;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto
}

.btn-group-vertical>.btn:hover,.btn-group>.btn:hover {
    z-index: 1
}

.btn-group-vertical>.btn.active,.btn-group-vertical>.btn:active,.btn-group-vertical>.btn:focus,.btn-group>.btn.active,.btn-group>.btn:active,.btn-group>.btn:focus {
    z-index: 1
}

.btn-toolbar {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -ms-flex-pack: start;
    justify-content: flex-start
}

.btn-toolbar .input-group {
    width: auto
}

.btn-group>.btn-group:not(:first-child),.btn-group>.btn:not(:first-child) {
    margin-left: -1px
}

.btn-group>.btn-group:not(:last-child)>.btn,.btn-group>.btn:not(:last-child):not(.dropdown-toggle) {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0
}

.btn-group>.btn-group:not(:first-child)>.btn,.btn-group>.btn:not(:first-child) {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0
}

.dropdown-toggle-split {
    padding-right: .5625rem;
    padding-left: .5625rem
}

.dropdown-toggle-split::after,.dropright .dropdown-toggle-split::after,.dropup .dropdown-toggle-split::after {
    margin-left: 0
}

.dropleft .dropdown-toggle-split::before {
    margin-right: 0
}

.btn-group-sm>.btn+.dropdown-toggle-split,.btn-sm+.dropdown-toggle-split {
    padding-right: .375rem;
    padding-left: .375rem
}

.btn-group-lg>.btn+.dropdown-toggle-split,.btn-lg+.dropdown-toggle-split {
    padding-right: .75rem;
    padding-left: .75rem
}

.btn-group-vertical {
    -ms-flex-direction: column;
    flex-direction: column;
    -ms-flex-align: start;
    align-items: flex-start;
    -ms-flex-pack: center;
    justify-content: center
}

.btn-group-vertical>.btn,.btn-group-vertical>.btn-group {
    width: 100%
}

.btn-group-vertical>.btn-group:not(:first-child),.btn-group-vertical>.btn:not(:first-child) {
    margin-top: -1px
}

.btn-group-vertical>.btn-group:not(:last-child)>.btn,.btn-group-vertical>.btn:not(:last-child):not(.dropdown-toggle) {
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0
}

.btn-group-vertical>.btn-group:not(:first-child)>.btn,.btn-group-vertical>.btn:not(:first-child) {
    border-top-left-radius: 0;
    border-top-right-radius: 0
}

.btn-group-toggle>.btn,.btn-group-toggle>.btn-group>.btn {
    margin-bottom: 0
}

.btn-group-toggle>.btn input[type=checkbox],.btn-group-toggle>.btn input[type=radio],.btn-group-toggle>.btn-group>.btn input[type=checkbox],.btn-group-toggle>.btn-group>.btn input[type=radio] {
    position: absolute;
    clip: rect(0,0,0,0);
    pointer-events: none
}

.input-group {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -ms-flex-align: stretch;
    align-items: stretch;
    width: 100%
}

.input-group>.custom-file,.input-group>.custom-select,.input-group>.form-control,.input-group>.form-control-plaintext {
    position: relative;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    width: 1%;
    min-width: 0;
    margin-bottom: 0
}

.input-group>.custom-file+.custom-file,.input-group>.custom-file+.custom-select,.input-group>.custom-file+.form-control,.input-group>.custom-select+.custom-file,.input-group>.custom-select+.custom-select,.input-group>.custom-select+.form-control,.input-group>.form-control+.custom-file,.input-group>.form-control+.custom-select,.input-group>.form-control+.form-control,.input-group>.form-control-plaintext+.custom-file,.input-group>.form-control-plaintext+.custom-select,.input-group>.form-control-plaintext+.form-control {
    margin-left: -1px
}

.input-group>.custom-file .custom-file-input:focus~.custom-file-label,.input-group>.custom-select:focus,.input-group>.form-control:focus {
    z-index: 3
}

.input-group>.custom-file .custom-file-input:focus {
    z-index: 4
}

.input-group>.custom-select:not(:first-child),.input-group>.form-control:not(:first-child) {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0
}

.input-group>.custom-file {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center
}

.input-group>.custom-file:not(:last-child) .custom-file-label,.input-group>.custom-file:not(:last-child) .custom-file-label::after {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0
}

.input-group>.custom-file:not(:first-child) .custom-file-label {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0
}

.input-group:not(.has-validation)>.custom-file:not(:last-child) .custom-file-label,.input-group:not(.has-validation)>.custom-file:not(:last-child) .custom-file-label::after,.input-group:not(.has-validation)>.custom-select:not(:last-child),.input-group:not(.has-validation)>.form-control:not(:last-child) {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0
}

.input-group.has-validation>.custom-file:nth-last-child(n+3) .custom-file-label,.input-group.has-validation>.custom-file:nth-last-child(n+3) .custom-file-label::after,.input-group.has-validation>.custom-select:nth-last-child(n+3),.input-group.has-validation>.form-control:nth-last-child(n+3) {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0
}

.input-group-append,.input-group-prepend {
    display: -ms-flexbox;
    display: flex
}

.input-group-append .btn,.input-group-prepend .btn {
    position: relative;
    z-index: 2
}

.input-group-append .btn:focus,.input-group-prepend .btn:focus {
    z-index: 3
}

.input-group-append .btn+.btn,.input-group-append .btn+.input-group-text,.input-group-append .input-group-text+.btn,.input-group-append .input-group-text+.input-group-text,.input-group-prepend .btn+.btn,.input-group-prepend .btn+.input-group-text,.input-group-prepend .input-group-text+.btn,.input-group-prepend .input-group-text+.input-group-text {
    margin-left: -1px
}

.input-group-prepend {
    margin-right: -1px
}

.input-group-append {
    margin-left: -1px
}

.input-group-text {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    padding: .375rem .75rem;
    margin-bottom: 0;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    text-align: center;
    white-space: nowrap;
    background-color: #e9ecef;
    border: 1px solid #ced4da;
    border-radius: .25rem
}

.input-group-text input[type=checkbox],.input-group-text input[type=radio] {
    margin-top: 0
}

.input-group-lg>.custom-select,.input-group-lg>.form-control:not(textarea) {
    height: calc(1.5em + 1rem + 2px)
}

.input-group-lg>.custom-select,.input-group-lg>.form-control,.input-group-lg>.input-group-append>.btn,.input-group-lg>.input-group-append>.input-group-text,.input-group-lg>.input-group-prepend>.btn,.input-group-lg>.input-group-prepend>.input-group-text {
    padding: .5rem 1rem;
    font-size: 1.25rem;
    line-height: 1.5;
    border-radius: .3rem
}

.input-group-sm>.custom-select,.input-group-sm>.form-control:not(textarea) {
    height: calc(1.5em + .5rem + 2px)
}

.input-group-sm>.custom-select,.input-group-sm>.form-control,.input-group-sm>.input-group-append>.btn,.input-group-sm>.input-group-append>.input-group-text,.input-group-sm>.input-group-prepend>.btn,.input-group-sm>.input-group-prepend>.input-group-text {
    padding: .25rem .5rem;
    font-size: .875rem;
    line-height: 1.5;
    border-radius: .2rem
}

.input-group-lg>.custom-select,.input-group-sm>.custom-select {
    padding-right: 1.75rem
}

.input-group.has-validation>.input-group-append:nth-last-child(n+3)>.btn,.input-group.has-validation>.input-group-append:nth-last-child(n+3)>.input-group-text,.input-group:not(.has-validation)>.input-group-append:not(:last-child)>.btn,.input-group:not(.has-validation)>.input-group-append:not(:last-child)>.input-group-text,.input-group>.input-group-append:last-child>.btn:not(:last-child):not(.dropdown-toggle),.input-group>.input-group-append:last-child>.input-group-text:not(:last-child),.input-group>.input-group-prepend>.btn,.input-group>.input-group-prepend>.input-group-text {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0
}

.input-group>.input-group-append>.btn,.input-group>.input-group-append>.input-group-text,.input-group>.input-group-prepend:first-child>.btn:not(:first-child),.input-group>.input-group-prepend:first-child>.input-group-text:not(:first-child),.input-group>.input-group-prepend:not(:first-child)>.btn,.input-group>.input-group-prepend:not(:first-child)>.input-group-text {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0
}

.custom-control {
    position: relative;
    z-index: 1;
    display: block;
    min-height: 1.5rem;
    padding-left: 1.5rem;
    -webkit-print-color-adjust: exact;
    color-adjust: exact;
    print-color-adjust: exact
}

.custom-control-inline {
    display: -ms-inline-flexbox;
    display: inline-flex;
    margin-right: 1rem
}

.custom-control-input {
    position: absolute;
    left: 0;
    z-index: -1;
    width: 1rem;
    height: 1.25rem;
    opacity: 0
}

.custom-control-input:checked~.custom-control-label::before {
    color: #fff;
    border-color: #007bff;
    background-color: #007bff
}

.custom-control-input:focus~.custom-control-label::before {
    box-shadow: 0 0 0 .2rem rgba(0,123,255,.25)
}

.custom-control-input:focus:not(:checked)~.custom-control-label::before {
    border-color: #80bdff
}

.custom-control-input:not(:disabled):active~.custom-control-label::before {
    color: #fff;
    background-color: #b3d7ff;
    border-color: #b3d7ff
}

.custom-control-input:disabled~.custom-control-label,.custom-control-input[disabled]~.custom-control-label {
    color: #6c757d
}

.custom-control-input:disabled~.custom-control-label::before,.custom-control-input[disabled]~.custom-control-label::before {
    background-color: #e9ecef
}

.custom-control-label {
    position: relative;
    margin-bottom: 0;
    vertical-align: top
}

.custom-control-label::before {
    position: absolute;
    top: .25rem;
    left: -1.5rem;
    display: block;
    width: 1rem;
    height: 1rem;
    pointer-events: none;
    content: "";
    background-color: #fff;
    border: 1px solid #adb5bd
}

.custom-control-label::after {
    position: absolute;
    top: .25rem;
    left: -1.5rem;
    display: block;
    width: 1rem;
    height: 1rem;
    content: "";
    background: 50%/50% 50% no-repeat
}

.custom-checkbox .custom-control-label::before {
    border-radius: .25rem
}

.custom-checkbox .custom-control-input:checked~.custom-control-label::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26l2.974 2.99L8 2.193z'/%3e%3c/svg%3e")
}

.custom-checkbox .custom-control-input:indeterminate~.custom-control-label::before {
    border-color: #007bff;
    background-color: #007bff
}

.custom-checkbox .custom-control-input:indeterminate~.custom-control-label::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4' viewBox='0 0 4 4'%3e%3cpath stroke='%23fff' d='M0 2h4'/%3e%3c/svg%3e")
}

.custom-checkbox .custom-control-input:disabled:checked~.custom-control-label::before {
    background-color: rgba(0,123,255,.5)
}

.custom-checkbox .custom-control-input:disabled:indeterminate~.custom-control-label::before {
    background-color: rgba(0,123,255,.5)
}

.custom-radio .custom-control-label::before {
    border-radius: 50%
}

.custom-radio .custom-control-input:checked~.custom-control-label::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e")
}

.custom-radio .custom-control-input:disabled:checked~.custom-control-label::before {
    background-color: rgba(0,123,255,.5)
}

.custom-switch {
    padding-left: 2.25rem
}

.custom-switch .custom-control-label::before {
    left: -2.25rem;
    width: 1.75rem;
    pointer-events: all;
    border-radius: .5rem
}

.custom-switch .custom-control-label::after {
    top: calc(.25rem + 2px);
    left: calc(-2.25rem + 2px);
    width: calc(1rem - 4px);
    height: calc(1rem - 4px);
    background-color: #adb5bd;
    border-radius: .5rem;
    transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-transform .15s ease-in-out;
    transition: transform .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    transition: transform .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-transform .15s ease-in-out
}

@media (prefers-reduced-motion:reduce) {
    .custom-switch .custom-control-label::after {
        transition: none
    }
}

.custom-switch .custom-control-input:checked~.custom-control-label::after {
    background-color: #fff;
    -webkit-transform: translateX(.75rem);
    transform: translateX(.75rem)
}

.custom-switch .custom-control-input:disabled:checked~.custom-control-label::before {
    background-color: rgba(0,123,255,.5)
}

.custom-select {
    display: inline-block;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem 1.75rem .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    vertical-align: middle;
    background: #fff url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") right .75rem center/8px 10px no-repeat;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none
}

.custom-select:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 .2rem rgba(0,123,255,.25)
}

.custom-select:focus::-ms-value {
    color: #495057;
    background-color: #fff
}

.custom-select[multiple],.custom-select[size]:not([size="1"]) {
    height: auto;
    padding-right: .75rem;
    background-image: none
}

.custom-select:disabled {
    color: #6c757d;
    background-color: #e9ecef
}

.custom-select::-ms-expand {
    display: none
}

.custom-select:-moz-focusring {
    color: transparent;
    text-shadow: 0 0 0 #495057
}

.custom-select-sm {
    height: calc(1.5em + .5rem + 2px);
    padding-top: .25rem;
    padding-bottom: .25rem;
    padding-left: .5rem;
    font-size: .875rem
}

.custom-select-lg {
    height: calc(1.5em + 1rem + 2px);
    padding-top: .5rem;
    padding-bottom: .5rem;
    padding-left: 1rem;
    font-size: 1.25rem
}

.custom-file {
    position: relative;
    display: inline-block;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    margin-bottom: 0
}

.custom-file-input {
    position: relative;
    z-index: 2;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    margin: 0;
    overflow: hidden;
    opacity: 0
}

.custom-file-input:focus~.custom-file-label {
    border-color: #80bdff;
    box-shadow: 0 0 0 .2rem rgba(0,123,255,.25)
}

.custom-file-input:disabled~.custom-file-label,.custom-file-input[disabled]~.custom-file-label {
    background-color: #e9ecef
}

.custom-file-input:lang(en)~.custom-file-label::after {
    content: "Browse"
}

.custom-file-input~.custom-file-label[data-browse]::after {
    content: attr(data-browse)
}

.custom-file-label {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 1;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    overflow: hidden;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: .25rem
}

.custom-file-label::after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 3;
    display: block;
    height: calc(1.5em + .75rem);
    padding: .375rem .75rem;
    line-height: 1.5;
    color: #495057;
    content: "Browse";
    background-color: #e9ecef;
    border-left: inherit;
    border-radius: 0 .25rem .25rem 0
}

.custom-range {
    width: 100%;
    height: 1.4rem;
    padding: 0;
    background-color: transparent;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none
}

.custom-range:focus {
    outline: 0
}

.custom-range:focus::-webkit-slider-thumb {
    box-shadow: 0 0 0 1px #fff,0 0 0 .2rem rgba(0,123,255,.25)
}

.custom-range:focus::-moz-range-thumb {
    box-shadow: 0 0 0 1px #fff,0 0 0 .2rem rgba(0,123,255,.25)
}

.custom-range:focus::-ms-thumb {
    box-shadow: 0 0 0 1px #fff,0 0 0 .2rem rgba(0,123,255,.25)
}

.custom-range::-moz-focus-outer {
    border: 0
}

.custom-range::-webkit-slider-thumb {
    width: 1rem;
    height: 1rem;
    margin-top: -.25rem;
    background-color: #007bff;
    border: 0;
    border-radius: 1rem;
    -webkit-transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    -webkit-appearance: none;
    appearance: none
}

@media (prefers-reduced-motion:reduce) {
    .custom-range::-webkit-slider-thumb {
        -webkit-transition: none;
        transition: none
    }
}

.custom-range::-webkit-slider-thumb:active {
    background-color: #b3d7ff
}

.custom-range::-webkit-slider-runnable-track {
    width: 100%;
    height: .5rem;
    color: transparent;
    cursor: pointer;
    background-color: #dee2e6;
    border-color: transparent;
    border-radius: 1rem
}

.custom-range::-moz-range-thumb {
    width: 1rem;
    height: 1rem;
    background-color: #007bff;
    border: 0;
    border-radius: 1rem;
    -moz-transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    -moz-appearance: none;
    appearance: none
}

@media (prefers-reduced-motion:reduce) {
    .custom-range::-moz-range-thumb {
        -moz-transition: none;
        transition: none
    }
}

.custom-range::-moz-range-thumb:active {
    background-color: #b3d7ff
}

.custom-range::-moz-range-track {
    width: 100%;
    height: .5rem;
    color: transparent;
    cursor: pointer;
    background-color: #dee2e6;
    border-color: transparent;
    border-radius: 1rem
}

.custom-range::-ms-thumb {
    width: 1rem;
    height: 1rem;
    margin-top: 0;
    margin-right: .2rem;
    margin-left: .2rem;
    background-color: #007bff;
    border: 0;
    border-radius: 1rem;
    -ms-transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    appearance: none
}

@media (prefers-reduced-motion:reduce) {
    .custom-range::-ms-thumb {
        -ms-transition: none;
        transition: none
    }
}

.custom-range::-ms-thumb:active {
    background-color: #b3d7ff
}

.custom-range::-ms-track {
    width: 100%;
    height: .5rem;
    color: transparent;
    cursor: pointer;
    background-color: transparent;
    border-color: transparent;
    border-width: .5rem
}

.custom-range::-ms-fill-lower {
    background-color: #dee2e6;
    border-radius: 1rem
}

.custom-range::-ms-fill-upper {
    margin-right: 15px;
    background-color: #dee2e6;
    border-radius: 1rem
}

.custom-range:disabled::-webkit-slider-thumb {
    background-color: #adb5bd
}

.custom-range:disabled::-webkit-slider-runnable-track {
    cursor: default
}

.custom-range:disabled::-moz-range-thumb {
    background-color: #adb5bd
}

.custom-range:disabled::-moz-range-track {
    cursor: default
}

.custom-range:disabled::-ms-thumb {
    background-color: #adb5bd
}

.custom-control-label::before,.custom-file-label,.custom-select {
    transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out
}

@media (prefers-reduced-motion:reduce) {
    .custom-control-label::before,.custom-file-label,.custom-select {
        transition: none
    }
}

.nav {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    padding-left: 0;
    margin-bottom: 0;
    list-style: none
}

.nav-link {
    display: block;
    padding: .5rem 1rem
}

.nav-link:focus,.nav-link:hover {
    text-decoration: none
}

.nav-link.disabled {
    color: #6c757d;
    pointer-events: none;
    cursor: default
}

.nav-tabs {
    border-bottom: 1px solid #dee2e6
}

.nav-tabs .nav-link {
    margin-bottom: -1px;
    background-color: transparent;
    border: 1px solid transparent;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem
}

.nav-tabs .nav-link:focus,.nav-tabs .nav-link:hover {
    isolation: isolate;
    border-color: #e9ecef #e9ecef #dee2e6
}

.nav-tabs .nav-link.disabled {
    color: #6c757d;
    background-color: transparent;
    border-color: transparent
}

.nav-tabs .nav-item.show .nav-link,.nav-tabs .nav-link.active {
    color: #495057;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff
}

.nav-tabs .dropdown-menu {
    margin-top: -1px;
    border-top-left-radius: 0;
    border-top-right-radius: 0
}

.nav-pills .nav-link {
    background: 0 0;
    border: 0;
    border-radius: .25rem
}

.nav-pills .nav-link.active,.nav-pills .show>.nav-link {
    color: #fff;
    background-color: #007bff
}

.nav-fill .nav-item,.nav-fill>.nav-link {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    text-align: center
}

.nav-justified .nav-item,.nav-justified>.nav-link {
    -ms-flex-preferred-size: 0;
    flex-basis: 0;
    -ms-flex-positive: 1;
    flex-grow: 1;
    text-align: center
}

.tab-content>.tab-pane {
    display: none
}

.tab-content>.active {
    display: block
}

.navbar {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-pack: justify;
    justify-content: space-between;
    padding: .5rem 1rem
}

.navbar .container,.navbar .container-fluid,.navbar .container-lg,.navbar .container-md,.navbar .container-sm,.navbar .container-xl {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-pack: justify;
    justify-content: space-between
}

.navbar-brand {
    display: inline-block;
    padding-top: .3125rem;
    padding-bottom: .3125rem;
    margin-right: 1rem;
    font-size: 1.25rem;
    line-height: inherit;
    white-space: nowrap
}

.navbar-brand:focus,.navbar-brand:hover {
    text-decoration: none
}

.navbar-nav {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    padding-left: 0;
    margin-bottom: 0;
    list-style: none
}

.navbar-nav .nav-link {
    padding-right: 0;
    padding-left: 0
}

.navbar-nav .dropdown-menu {
    position: static;
    float: none
}

.navbar-text {
    display: inline-block;
    padding-top: .5rem;
    padding-bottom: .5rem
}

.navbar-collapse {
    -ms-flex-preferred-size: 100%;
    flex-basis: 100%;
    -ms-flex-positive: 1;
    flex-grow: 1;
    -ms-flex-align: center;
    align-items: center
}

.navbar-toggler {
    padding: .25rem .75rem;
    font-size: 1.25rem;
    line-height: 1;
    background-color: transparent;
    border: 1px solid transparent;
    border-radius: .25rem
}

.navbar-toggler:focus,.navbar-toggler:hover {
    text-decoration: none
}

.navbar-toggler-icon {
    display: inline-block;
    width: 1.5em;
    height: 1.5em;
    vertical-align: middle;
    content: "";
    background: 50%/100% 100% no-repeat
}

.navbar-nav-scroll {
    max-height: 75vh;
    overflow-y: auto
}

@media (max-width: 575.98px) {
    .navbar-expand-sm>.container,.navbar-expand-sm>.container-fluid,.navbar-expand-sm>.container-lg,.navbar-expand-sm>.container-md,.navbar-expand-sm>.container-sm,.navbar-expand-sm>.container-xl {
        padding-right:0;
        padding-left: 0
    }
}

@media (min-width: 576px) {
    .navbar-expand-sm {
        -ms-flex-flow:row nowrap;
        flex-flow: row nowrap;
        -ms-flex-pack: start;
        justify-content: flex-start
    }

    .navbar-expand-sm .navbar-nav {
        -ms-flex-direction: row;
        flex-direction: row
    }

    .navbar-expand-sm .navbar-nav .dropdown-menu {
        position: absolute
    }

    .navbar-expand-sm .navbar-nav .nav-link {
        padding-right: .5rem;
        padding-left: .5rem
    }

    .navbar-expand-sm>.container,.navbar-expand-sm>.container-fluid,.navbar-expand-sm>.container-lg,.navbar-expand-sm>.container-md,.navbar-expand-sm>.container-sm,.navbar-expand-sm>.container-xl {
        -ms-flex-wrap: nowrap;
        flex-wrap: nowrap
    }

    .navbar-expand-sm .navbar-nav-scroll {
        overflow: visible
    }

    .navbar-expand-sm .navbar-collapse {
        display: -ms-flexbox!important;
        display: flex!important;
        -ms-flex-preferred-size: auto;
        flex-basis: auto
    }

    .navbar-expand-sm .navbar-toggler {
        display: none
    }
}

@media (max-width: 767.98px) {
    .navbar-expand-md>.container,.navbar-expand-md>.container-fluid,.navbar-expand-md>.container-lg,.navbar-expand-md>.container-md,.navbar-expand-md>.container-sm,.navbar-expand-md>.container-xl {
        padding-right:0;
        padding-left: 0
    }
}

@media (min-width: 768px) {
    .navbar-expand-md {
        -ms-flex-flow:row nowrap;
        flex-flow: row nowrap;
        -ms-flex-pack: start;
        justify-content: flex-start
    }

    .navbar-expand-md .navbar-nav {
        -ms-flex-direction: row;
        flex-direction: row
    }

    .navbar-expand-md .navbar-nav .dropdown-menu {
        position: absolute
    }

    .navbar-expand-md .navbar-nav .nav-link {
        padding-right: .5rem;
        padding-left: .5rem
    }

    .navbar-expand-md>.container,.navbar-expand-md>.container-fluid,.navbar-expand-md>.container-lg,.navbar-expand-md>.container-md,.navbar-expand-md>.container-sm,.navbar-expand-md>.container-xl {
        -ms-flex-wrap: nowrap;
        flex-wrap: nowrap
    }

    .navbar-expand-md .navbar-nav-scroll {
        overflow: visible
    }

    .navbar-expand-md .navbar-collapse {
        display: -ms-flexbox!important;
        display: flex!important;
        -ms-flex-preferred-size: auto;
        flex-basis: auto
    }

    .navbar-expand-md .navbar-toggler {
        display: none
    }
}

@media (max-width: 991.98px) {
    .navbar-expand-lg>.container,.navbar-expand-lg>.container-fluid,.navbar-expand-lg>.container-lg,.navbar-expand-lg>.container-md,.navbar-expand-lg>.container-sm,.navbar-expand-lg>.container-xl {
        padding-right:0;
        padding-left: 0
    }
}

@media (min-width: 992px) {
    .navbar-expand-lg {
        -ms-flex-flow:row nowrap;
        flex-flow: row nowrap;
        -ms-flex-pack: start;
        justify-content: flex-start
    }

    .navbar-expand-lg .navbar-nav {
        -ms-flex-direction: row;
        flex-direction: row
    }

    .navbar-expand-lg .navbar-nav .dropdown-menu {
        position: absolute
    }

    .navbar-expand-lg .navbar-nav .nav-link {
        padding-right: .5rem;
        padding-left: .5rem
    }

    .navbar-expand-lg>.container,.navbar-expand-lg>.container-fluid,.navbar-expand-lg>.container-lg,.navbar-expand-lg>.container-md,.navbar-expand-lg>.container-sm,.navbar-expand-lg>.container-xl {
        -ms-flex-wrap: nowrap;
        flex-wrap: nowrap
    }

    .navbar-expand-lg .navbar-nav-scroll {
        overflow: visible
    }

    .navbar-expand-lg .navbar-collapse {
        display: -ms-flexbox!important;
        display: flex!important;
        -ms-flex-preferred-size: auto;
        flex-basis: auto
    }

    .navbar-expand-lg .navbar-toggler {
        display: none
    }
}

@media (max-width: 1199.98px) {
    .navbar-expand-xl>.container,.navbar-expand-xl>.container-fluid,.navbar-expand-xl>.container-lg,.navbar-expand-xl>.container-md,.navbar-expand-xl>.container-sm,.navbar-expand-xl>.container-xl {
        padding-right:0;
        padding-left: 0
    }
}

@media (min-width: 1200px) {
    .navbar-expand-xl {
        -ms-flex-flow:row nowrap;
        flex-flow: row nowrap;
        -ms-flex-pack: start;
        justify-content: flex-start
    }

    .navbar-expand-xl .navbar-nav {
        -ms-flex-direction: row;
        flex-direction: row
    }

    .navbar-expand-xl .navbar-nav .dropdown-menu {
        position: absolute
    }

    .navbar-expand-xl .navbar-nav .nav-link {
        padding-right: .5rem;
        padding-left: .5rem
    }

    .navbar-expand-xl>.container,.navbar-expand-xl>.container-fluid,.navbar-expand-xl>.container-lg,.navbar-expand-xl>.container-md,.navbar-expand-xl>.container-sm,.navbar-expand-xl>.container-xl {
        -ms-flex-wrap: nowrap;
        flex-wrap: nowrap
    }

    .navbar-expand-xl .navbar-nav-scroll {
        overflow: visible
    }

    .navbar-expand-xl .navbar-collapse {
        display: -ms-flexbox!important;
        display: flex!important;
        -ms-flex-preferred-size: auto;
        flex-basis: auto
    }

    .navbar-expand-xl .navbar-toggler {
        display: none
    }
}

.navbar-expand {
    -ms-flex-flow: row nowrap;
    flex-flow: row nowrap;
    -ms-flex-pack: start;
    justify-content: flex-start
}

.navbar-expand>.container,.navbar-expand>.container-fluid,.navbar-expand>.container-lg,.navbar-expand>.container-md,.navbar-expand>.container-sm,.navbar-expand>.container-xl {
    padding-right: 0;
    padding-left: 0
}

.navbar-expand .navbar-nav {
    -ms-flex-direction: row;
    flex-direction: row
}

.navbar-expand .navbar-nav .dropdown-menu {
    position: absolute
}

.navbar-expand .navbar-nav .nav-link {
    padding-right: .5rem;
    padding-left: .5rem
}

.navbar-expand>.container,.navbar-expand>.container-fluid,.navbar-expand>.container-lg,.navbar-expand>.container-md,.navbar-expand>.container-sm,.navbar-expand>.container-xl {
    -ms-flex-wrap: nowrap;
    flex-wrap: nowrap
}

.navbar-expand .navbar-nav-scroll {
    overflow: visible
}

.navbar-expand .navbar-collapse {
    display: -ms-flexbox!important;
    display: flex!important;
    -ms-flex-preferred-size: auto;
    flex-basis: auto
}

.navbar-expand .navbar-toggler {
    display: none
}

.navbar-light .navbar-brand {
    color: rgba(0,0,0,.9)
}

.navbar-light .navbar-brand:focus,.navbar-light .navbar-brand:hover {
    color: rgba(0,0,0,.9)
}

.navbar-light .navbar-nav .nav-link {
    color: rgba(0,0,0,.5)
}

.navbar-light .navbar-nav .nav-link:focus,.navbar-light .navbar-nav .nav-link:hover {
    color: rgba(0,0,0,.7)
}

.navbar-light .navbar-nav .nav-link.disabled {
    color: rgba(0,0,0,.3)
}

.navbar-light .navbar-nav .active>.nav-link,.navbar-light .navbar-nav .nav-link.active,.navbar-light .navbar-nav .nav-link.show,.navbar-light .navbar-nav .show>.nav-link {
    color: rgba(0,0,0,.9)
}

.navbar-light .navbar-toggler {
    color: rgba(0,0,0,.5);
    border-color: rgba(0,0,0,.1)
}

.navbar-light .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%280, 0, 0, 0.5%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e")
}

.navbar-light .navbar-text {
    color: rgba(0,0,0,.5)
}

.navbar-light .navbar-text a {
    color: rgba(0,0,0,.9)
}

.navbar-light .navbar-text a:focus,.navbar-light .navbar-text a:hover {
    color: rgba(0,0,0,.9)
}

.navbar-dark .navbar-brand {
    color: #fff
}

.navbar-dark .navbar-brand:focus,.navbar-dark .navbar-brand:hover {
    color: #fff
}

.navbar-dark .navbar-nav .nav-link {
    color: rgba(255,255,255,.5)
}

.navbar-dark .navbar-nav .nav-link:focus,.navbar-dark .navbar-nav .nav-link:hover {
    color: rgba(255,255,255,.75)
}

.navbar-dark .navbar-nav .nav-link.disabled {
    color: rgba(255,255,255,.25)
}

.navbar-dark .navbar-nav .active>.nav-link,.navbar-dark .navbar-nav .nav-link.active,.navbar-dark .navbar-nav .nav-link.show,.navbar-dark .navbar-nav .show>.nav-link {
    color: #fff
}

.navbar-dark .navbar-toggler {
    color: rgba(255,255,255,.5);
    border-color: rgba(255,255,255,.1)
}

.navbar-dark .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.5%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e")
}

.navbar-dark .navbar-text {
    color: rgba(255,255,255,.5)
}

.navbar-dark .navbar-text a {
    color: #fff
}

.navbar-dark .navbar-text a:focus,.navbar-dark .navbar-text a:hover {
    color: #fff
}

.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: .25rem
}

.card>hr {
    margin-right: 0;
    margin-left: 0
}

.card>.list-group {
    border-top: inherit;
    border-bottom: inherit
}

.card>.list-group:first-child {
    border-top-width: 0;
    border-top-left-radius: calc(.25rem - 1px);
    border-top-right-radius: calc(.25rem - 1px)
}

.card>.list-group:last-child {
    border-bottom-width: 0;
    border-bottom-right-radius: calc(.25rem - 1px);
    border-bottom-left-radius: calc(.25rem - 1px)
}

.card>.card-header+.list-group,.card>.list-group+.card-footer {
    border-top: 0
}

.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1.25rem
}

.card-title {
    margin-bottom: .75rem
}

.card-subtitle {
    margin-top: -.375rem;
    margin-bottom: 0
}

.card-text:last-child {
    margin-bottom: 0
}

.card-link:hover {
    text-decoration: none
}

.card-link+.card-link {
    margin-left: 1.25rem
}

.card-header {
    padding: .75rem 1.25rem;
    margin-bottom: 0;
    background-color: rgba(0,0,0,.03);
    border-bottom: 1px solid rgba(0,0,0,.125)
}

.card-header:first-child {
    border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0
}

.card-footer {
    padding: .75rem 1.25rem;
    background-color: rgba(0,0,0,.03);
    border-top: 1px solid rgba(0,0,0,.125)
}

.card-footer:last-child {
    border-radius: 0 0 calc(.25rem - 1px) calc(.25rem - 1px)
}

.card-header-tabs {
    margin-right: -.625rem;
    margin-bottom: -.75rem;
    margin-left: -.625rem;
    border-bottom: 0
}

.card-header-pills {
    margin-right: -.625rem;
    margin-left: -.625rem
}

.card-img-overlay {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    padding: 1.25rem;
    border-radius: calc(.25rem - 1px)
}

.card-img,.card-img-bottom,.card-img-top {
    -ms-flex-negative: 0;
    flex-shrink: 0;
    width: 100%
}

.card-img,.card-img-top {
    border-top-left-radius: calc(.25rem - 1px);
    border-top-right-radius: calc(.25rem - 1px)
}

.card-img,.card-img-bottom {
    border-bottom-right-radius: calc(.25rem - 1px);
    border-bottom-left-radius: calc(.25rem - 1px)
}

.card-deck .card {
    margin-bottom: 15px
}

@media (min-width: 576px) {
    .card-deck {
        display:-ms-flexbox;
        display: flex;
        -ms-flex-flow: row wrap;
        flex-flow: row wrap;
        margin-right: -15px;
        margin-left: -15px
    }

    .card-deck .card {
        -ms-flex: 1 0 0%;
        flex: 1 0 0%;
        margin-right: 15px;
        margin-bottom: 0;
        margin-left: 15px
    }
}

.card-group>.card {
    margin-bottom: 15px
}

@media (min-width: 576px) {
    .card-group {
        display:-ms-flexbox;
        display: flex;
        -ms-flex-flow: row wrap;
        flex-flow: row wrap
    }

    .card-group>.card {
        -ms-flex: 1 0 0%;
        flex: 1 0 0%;
        margin-bottom: 0
    }

    .card-group>.card+.card {
        margin-left: 0;
        border-left: 0
    }

    .card-group>.card:not(:last-child) {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0
    }

    .card-group>.card:not(:last-child) .card-header,.card-group>.card:not(:last-child) .card-img-top {
        border-top-right-radius: 0
    }

    .card-group>.card:not(:last-child) .card-footer,.card-group>.card:not(:last-child) .card-img-bottom {
        border-bottom-right-radius: 0
    }

    .card-group>.card:not(:first-child) {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0
    }

    .card-group>.card:not(:first-child) .card-header,.card-group>.card:not(:first-child) .card-img-top {
        border-top-left-radius: 0
    }

    .card-group>.card:not(:first-child) .card-footer,.card-group>.card:not(:first-child) .card-img-bottom {
        border-bottom-left-radius: 0
    }
}

.card-columns .card {
    margin-bottom: .75rem
}

@media (min-width: 576px) {
    .card-columns {
        -webkit-column-count:3;
        -moz-column-count: 3;
        column-count: 3;
        -webkit-column-gap: 1.25rem;
        -moz-column-gap: 1.25rem;
        column-gap: 1.25rem;
        orphans: 1;
        widows: 1
    }

    .card-columns .card {
        display: inline-block;
        width: 100%
    }
}

.accordion {
    overflow-anchor: none
}

.accordion>.card {
    overflow: hidden
}

.accordion>.card:not(:last-of-type) {
    border-bottom: 0;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0
}

.accordion>.card:not(:first-of-type) {
    border-top-left-radius: 0;
    border-top-right-radius: 0
}

.accordion>.card>.card-header {
    border-radius: 0;
    margin-bottom: -1px
}

.breadcrumb {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    padding: .75rem 1rem;
    margin-bottom: 1rem;
    list-style: none;
    background-color: #e9ecef;
    border-radius: .25rem
}

.breadcrumb-item+.breadcrumb-item {
    padding-left: .5rem
}

.breadcrumb-item+.breadcrumb-item::before {
    float: left;
    padding-right: .5rem;
    color: #6c757d;
    content: "/"
}

.breadcrumb-item+.breadcrumb-item:hover::before {
    text-decoration: underline
}

.breadcrumb-item+.breadcrumb-item:hover::before {
    text-decoration: none
}

.breadcrumb-item.active {
    color: #6c757d
}

.pagination {
    display: -ms-flexbox;
    display: flex;
    padding-left: 0;
    list-style: none;
    border-radius: .25rem
}

.page-link {
    position: relative;
    display: block;
    padding: .5rem .75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #007bff;
    background-color: #fff;
    border: 1px solid #dee2e6
}

.page-link:hover {
    z-index: 2;
    color: #0056b3;
    text-decoration: none;
    background-color: #e9ecef;
    border-color: #dee2e6
}

.page-link:focus {
    z-index: 3;
    outline: 0;
    box-shadow: 0 0 0 .2rem rgba(0,123,255,.25)
}

.page-item:first-child .page-link {
    margin-left: 0;
    border-top-left-radius: .25rem;
    border-bottom-left-radius: .25rem
}

.page-item:last-child .page-link {
    border-top-right-radius: .25rem;
    border-bottom-right-radius: .25rem
}

.page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff
}

.page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    cursor: auto;
    background-color: #fff;
    border-color: #dee2e6
}

.pagination-lg .page-link {
    padding: .75rem 1.5rem;
    font-size: 1.25rem;
    line-height: 1.5
}

.pagination-lg .page-item:first-child .page-link {
    border-top-left-radius: .3rem;
    border-bottom-left-radius: .3rem
}

.pagination-lg .page-item:last-child .page-link {
    border-top-right-radius: .3rem;
    border-bottom-right-radius: .3rem
}

.pagination-sm .page-link {
    padding: .25rem .5rem;
    font-size: .875rem;
    line-height: 1.5
}

.pagination-sm .page-item:first-child .page-link {
    border-top-left-radius: .2rem;
    border-bottom-left-radius: .2rem
}

.pagination-sm .page-item:last-child .page-link {
    border-top-right-radius: .2rem;
    border-bottom-right-radius: .2rem
}

.badge {
    display: inline-block;
    padding: .25em .4em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out
}

@media (prefers-reduced-motion:reduce) {
    .badge {
        transition: none
    }
}

a.badge:focus,a.badge:hover {
    text-decoration: none
}

.badge:empty {
    display: none
}

.btn .badge {
    position: relative;
    top: -1px
}

.badge-pill {
    padding-right: .6em;
    padding-left: .6em;
    border-radius: 10rem
}

.badge-primary {
    color: #fff;
    background-color: #007bff
}

a.badge-primary:focus,a.badge-primary:hover {
    color: #fff;
    background-color: #0062cc
}

a.badge-primary.focus,a.badge-primary:focus {
    outline: 0;
    box-shadow: 0 0 0 .2rem rgba(0,123,255,.5)
}

.badge-secondary {
    color: #fff;
    background-color: #6c757d
}

a.badge-secondary:focus,a.badge-secondary:hover {
    color: #fff;
    background-color: #545b62
}

a.badge-secondary.focus,a.badge-secondary:focus {
    outline: 0;
    box-shadow: 0 0 0 .2rem rgba(108,117,125,.5)
}

.badge-success {
    color: #fff;
    background-color: #28a745
}

a.badge-success:focus,a.badge-success:hover {
    color: #fff;
    background-color: #1e7e34
}

a.badge-success.focus,a.badge-success:focus {
    outline: 0;
    box-shadow: 0 0 0 .2rem rgba(40,167,69,.5)
}

.badge-info {
    color: #fff;
    background-color: #17a2b8
}

a.badge-info:focus,a.badge-info:hover {
    color: #fff;
    background-color: #117a8b
}

a.badge-info.focus,a.badge-info:focus {
    outline: 0;
    box-shadow: 0 0 0 .2rem rgba(23,162,184,.5)
}

.badge-warning {
    color: #212529;
    background-color: #ffc107
}

a.badge-warning:focus,a.badge-warning:hover {
    color: #212529;
    background-color: #d39e00
}

a.badge-warning.focus,a.badge-warning:focus {
    outline: 0;
    box-shadow: 0 0 0 .2rem rgba(255,193,7,.5)
}

.badge-danger {
    color: #fff;
    background-color: #dc3545
}

a.badge-danger:focus,a.badge-danger:hover {
    color: #fff;
    background-color: #bd2130
}

a.badge-danger.focus,a.badge-danger:focus {
    outline: 0;
    box-shadow: 0 0 0 .2rem rgba(220,53,69,.5)
}

.badge-light {
    color: #212529;
    background-color: #f8f9fa
}

a.badge-light:focus,a.badge-light:hover {
    color: #212529;
    background-color: #dae0e5
}

a.badge-light.focus,a.badge-light:focus {
    outline: 0;
    box-shadow: 0 0 0 .2rem rgba(248,249,250,.5)
}

.badge-dark {
    color: #fff;
    background-color: #343a40
}

a.badge-dark:focus,a.badge-dark:hover {
    color: #fff;
    background-color: #1d2124
}

a.badge-dark.focus,a.badge-dark:focus {
    outline: 0;
    box-shadow: 0 0 0 .2rem rgba(52,58,64,.5)
}

.jumbotron {
    padding: 2rem 1rem;
    margin-bottom: 2rem;
    background-color: #e9ecef;
    border-radius: .3rem
}

@media (min-width: 576px) {
    .jumbotron {
        padding:4rem 2rem
    }
}

.jumbotron-fluid {
    padding-right: 0;
    padding-left: 0;
    border-radius: 0
}

.alert {
    position: relative;
    padding: .75rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: .25rem
}

.alert-heading {
    color: inherit
}

.alert-link {
    font-weight: 700
}

.alert-dismissible {
    padding-right: 4rem
}

.alert-dismissible .close {
    position: absolute;
    top: 0;
    right: 0;
    z-index: 2;
    padding: .75rem 1.25rem;
    color: inherit
}

.alert-primary {
    color: #004085;
    background-color: #cce5ff;
    border-color: #b8daff
}

.alert-primary hr {
    border-top-color: #9fcdff
}

.alert-primary .alert-link {
    color: #002752
}

.alert-secondary {
    color: #383d41;
    background-color: #e2e3e5;
    border-color: #d6d8db
}

.alert-secondary hr {
    border-top-color: #c8cbcf
}

.alert-secondary .alert-link {
    color: #202326
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb
}

.alert-success hr {
    border-top-color: #b1dfbb
}

.alert-success .alert-link {
    color: #0b2e13
}

.alert-info {
    color: #0c5460;
    background-color: #d1ecf1;
    border-color: #bee5eb
}

.alert-info hr {
    border-top-color: #abdde5
}

.alert-info .alert-link {
    color: #062c33
}

.alert-warning {
    color: #856404;
    background-color: #fff3cd;
    border-color: #ffeeba
}

.alert-warning hr {
    border-top-color: #ffe8a1
}

.alert-warning .alert-link {
    color: #533f03
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb
}

.alert-danger hr {
    border-top-color: #f1b0b7
}

.alert-danger .alert-link {
    color: #491217
}

.alert-light {
    color: #818182;
    background-color: #fefefe;
    border-color: #fdfdfe
}

.alert-light hr {
    border-top-color: #ececf6
}

.alert-light .alert-link {
    color: #686868
}

.alert-dark {
    color: #1b1e21;
    background-color: #d6d8d9;
    border-color: #c6c8ca
}

.alert-dark hr {
    border-top-color: #b9bbbe
}

.alert-dark .alert-link {
    color: #040505
}

@-webkit-keyframes progress-bar-stripes {
    from {
        background-position: 1rem 0
    }

    to {
        background-position: 0 0
    }
}

@keyframes progress-bar-stripes {
    from {
        background-position: 1rem 0
    }

    to {
        background-position: 0 0
    }
}

.progress {
    display: -ms-flexbox;
    display: flex;
    height: 1rem;
    overflow: hidden;
    line-height: 0;
    font-size: .75rem;
    background-color: #e9ecef;
    border-radius: .25rem
}

.progress-bar {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    -ms-flex-pack: center;
    justify-content: center;
    overflow: hidden;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    background-color: #007bff;
    transition: width .6s ease
}

@media (prefers-reduced-motion:reduce) {
    .progress-bar {
        transition: none
    }
}

.progress-bar-striped {
    background-image: linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent);
    background-size: 1rem 1rem
}

.progress-bar-animated {
    -webkit-animation: 1s linear infinite progress-bar-stripes;
    animation: 1s linear infinite progress-bar-stripes
}

@media (prefers-reduced-motion:reduce) {
    .progress-bar-animated {
        -webkit-animation: none;
        animation: none
    }
}

.media {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: start;
    align-items: flex-start
}

.media-body {
    -ms-flex: 1;
    flex: 1
}

.list-group {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    padding-left: 0;
    margin-bottom: 0;
    border-radius: .25rem
}

.list-group-item-action {
    width: 100%;
    color: #495057;
    text-align: inherit
}

.list-group-item-action:focus,.list-group-item-action:hover {
    z-index: 1;
    color: #495057;
    text-decoration: none;
    background-color: #f8f9fa
}

.list-group-item-action:active {
    color: #212529;
    background-color: #e9ecef
}

.list-group-item {
    position: relative;
    display: block;
    padding: .75rem 1.25rem;
    background-color: #fff;
    border: 1px solid rgba(0,0,0,.125)
}

.list-group-item:first-child {
    border-top-left-radius: inherit;
    border-top-right-radius: inherit
}

.list-group-item:last-child {
    border-bottom-right-radius: inherit;
    border-bottom-left-radius: inherit
}

.list-group-item.disabled,.list-group-item:disabled {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff
}

.list-group-item.active {
    z-index: 2;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff
}

.list-group-item+.list-group-item {
    border-top-width: 0
}

.list-group-item+.list-group-item.active {
    margin-top: -1px;
    border-top-width: 1px
}

.list-group-horizontal {
    -ms-flex-direction: row;
    flex-direction: row
}

.list-group-horizontal>.list-group-item:first-child {
    border-bottom-left-radius: .25rem;
    border-top-right-radius: 0
}

.list-group-horizontal>.list-group-item:last-child {
    border-top-right-radius: .25rem;
    border-bottom-left-radius: 0
}

.list-group-horizontal>.list-group-item.active {
    margin-top: 0
}

.list-group-horizontal>.list-group-item+.list-group-item {
    border-top-width: 1px;
    border-left-width: 0
}

.list-group-horizontal>.list-group-item+.list-group-item.active {
    margin-left: -1px;
    border-left-width: 1px
}

@media (min-width: 576px) {
    .list-group-horizontal-sm {
        -ms-flex-direction:row;
        flex-direction: row
    }

    .list-group-horizontal-sm>.list-group-item:first-child {
        border-bottom-left-radius: .25rem;
        border-top-right-radius: 0
    }

    .list-group-horizontal-sm>.list-group-item:last-child {
        border-top-right-radius: .25rem;
        border-bottom-left-radius: 0
    }

    .list-group-horizontal-sm>.list-group-item.active {
        margin-top: 0
    }

    .list-group-horizontal-sm>.list-group-item+.list-group-item {
        border-top-width: 1px;
        border-left-width: 0
    }

    .list-group-horizontal-sm>.list-group-item+.list-group-item.active {
        margin-left: -1px;
        border-left-width: 1px
    }
}

@media (min-width: 768px) {
    .list-group-horizontal-md {
        -ms-flex-direction:row;
        flex-direction: row
    }

    .list-group-horizontal-md>.list-group-item:first-child {
        border-bottom-left-radius: .25rem;
        border-top-right-radius: 0
    }

    .list-group-horizontal-md>.list-group-item:last-child {
        border-top-right-radius: .25rem;
        border-bottom-left-radius: 0
    }

    .list-group-horizontal-md>.list-group-item.active {
        margin-top: 0
    }

    .list-group-horizontal-md>.list-group-item+.list-group-item {
        border-top-width: 1px;
        border-left-width: 0
    }

    .list-group-horizontal-md>.list-group-item+.list-group-item.active {
        margin-left: -1px;
        border-left-width: 1px
    }
}

@media (min-width: 992px) {
    .list-group-horizontal-lg {
        -ms-flex-direction:row;
        flex-direction: row
    }

    .list-group-horizontal-lg>.list-group-item:first-child {
        border-bottom-left-radius: .25rem;
        border-top-right-radius: 0
    }

    .list-group-horizontal-lg>.list-group-item:last-child {
        border-top-right-radius: .25rem;
        border-bottom-left-radius: 0
    }

    .list-group-horizontal-lg>.list-group-item.active {
        margin-top: 0
    }

    .list-group-horizontal-lg>.list-group-item+.list-group-item {
        border-top-width: 1px;
        border-left-width: 0
    }

    .list-group-horizontal-lg>.list-group-item+.list-group-item.active {
        margin-left: -1px;
        border-left-width: 1px
    }
}

@media (min-width: 1200px) {
    .list-group-horizontal-xl {
        -ms-flex-direction:row;
        flex-direction: row
    }

    .list-group-horizontal-xl>.list-group-item:first-child {
        border-bottom-left-radius: .25rem;
        border-top-right-radius: 0
    }

    .list-group-horizontal-xl>.list-group-item:last-child {
        border-top-right-radius: .25rem;
        border-bottom-left-radius: 0
    }

    .list-group-horizontal-xl>.list-group-item.active {
        margin-top: 0
    }

    .list-group-horizontal-xl>.list-group-item+.list-group-item {
        border-top-width: 1px;
        border-left-width: 0
    }

    .list-group-horizontal-xl>.list-group-item+.list-group-item.active {
        margin-left: -1px;
        border-left-width: 1px
    }
}

.list-group-flush {
    border-radius: 0
}

.list-group-flush>.list-group-item {
    border-width: 0 0 1px
}

.list-group-flush>.list-group-item:last-child {
    border-bottom-width: 0
}

.list-group-item-primary {
    color: #004085;
    background-color: #b8daff
}

.list-group-item-primary.list-group-item-action:focus,.list-group-item-primary.list-group-item-action:hover {
    color: #004085;
    background-color: #9fcdff
}

.list-group-item-primary.list-group-item-action.active {
    color: #fff;
    background-color: #004085;
    border-color: #004085
}

.list-group-item-secondary {
    color: #383d41;
    background-color: #d6d8db
}

.list-group-item-secondary.list-group-item-action:focus,.list-group-item-secondary.list-group-item-action:hover {
    color: #383d41;
    background-color: #c8cbcf
}

.list-group-item-secondary.list-group-item-action.active {
    color: #fff;
    background-color: #383d41;
    border-color: #383d41
}

.list-group-item-success {
    color: #155724;
    background-color: #c3e6cb
}

.list-group-item-success.list-group-item-action:focus,.list-group-item-success.list-group-item-action:hover {
    color: #155724;
    background-color: #b1dfbb
}

.list-group-item-success.list-group-item-action.active {
    color: #fff;
    background-color: #155724;
    border-color: #155724
}

.list-group-item-info {
    color: #0c5460;
    background-color: #bee5eb
}

.list-group-item-info.list-group-item-action:focus,.list-group-item-info.list-group-item-action:hover {
    color: #0c5460;
    background-color: #abdde5
}

.list-group-item-info.list-group-item-action.active {
    color: #fff;
    background-color: #0c5460;
    border-color: #0c5460
}

.list-group-item-warning {
    color: #856404;
    background-color: #ffeeba
}

.list-group-item-warning.list-group-item-action:focus,.list-group-item-warning.list-group-item-action:hover {
    color: #856404;
    background-color: #ffe8a1
}

.list-group-item-warning.list-group-item-action.active {
    color: #fff;
    background-color: #856404;
    border-color: #856404
}

.list-group-item-danger {
    color: #721c24;
    background-color: #f5c6cb
}

.list-group-item-danger.list-group-item-action:focus,.list-group-item-danger.list-group-item-action:hover {
    color: #721c24;
    background-color: #f1b0b7
}

.list-group-item-danger.list-group-item-action.active {
    color: #fff;
    background-color: #721c24;
    border-color: #721c24
}

.list-group-item-light {
    color: #818182;
    background-color: #fdfdfe
}

.list-group-item-light.list-group-item-action:focus,.list-group-item-light.list-group-item-action:hover {
    color: #818182;
    background-color: #ececf6
}

.list-group-item-light.list-group-item-action.active {
    color: #fff;
    background-color: #818182;
    border-color: #818182
}

.list-group-item-dark {
    color: #1b1e21;
    background-color: #c6c8ca
}

.list-group-item-dark.list-group-item-action:focus,.list-group-item-dark.list-group-item-action:hover {
    color: #1b1e21;
    background-color: #b9bbbe
}

.list-group-item-dark.list-group-item-action.active {
    color: #fff;
    background-color: #1b1e21;
    border-color: #1b1e21
}

.close {
    float: right;
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    opacity: .5
}

.close:hover {
    color: #000;
    text-decoration: none
}

.close:not(:disabled):not(.disabled):focus,.close:not(:disabled):not(.disabled):hover {
    opacity: .75
}

button.close {
    padding: 0;
    background-color: transparent;
    border: 0
}

a.close.disabled {
    pointer-events: none
}

.toast {
    -ms-flex-preferred-size: 350px;
    flex-basis: 350px;
    max-width: 350px;
    font-size: .875rem;
    background-color: rgba(255,255,255,.85);
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.1);
    box-shadow: 0 .25rem .75rem rgba(0,0,0,.1);
    opacity: 0;
    border-radius: .25rem
}

.toast:not(:last-child) {
    margin-bottom: .75rem
}

.toast.showing {
    opacity: 1
}

.toast.show {
    display: block;
    opacity: 1
}

.toast.hide {
    display: none
}

.toast-header {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    padding: .25rem .75rem;
    color: #6c757d;
    background-color: rgba(255,255,255,.85);
    background-clip: padding-box;
    border-bottom: 1px solid rgba(0,0,0,.05);
    border-top-left-radius: calc(.25rem - 1px);
    border-top-right-radius: calc(.25rem - 1px)
}

.toast-body {
    padding: .75rem
}

.modal-open {
    overflow: hidden
}

.modal-open .modal {
    overflow-x: hidden;
    overflow-y: auto
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1050;
    display: none;
    width: 100%;
    height: 100%;
    overflow: hidden;
    outline: 0
}

.modal-dialog {
    position: relative;
    width: auto;
    margin: .5rem;
    pointer-events: none
}

.modal.fade .modal-dialog {
    transition: -webkit-transform .3s ease-out;
    transition: transform .3s ease-out;
    transition: transform .3s ease-out,-webkit-transform .3s ease-out;
    -webkit-transform: translate(0,-50px);
    transform: translate(0,-50px)
}

@media (prefers-reduced-motion:reduce) {
    .modal.fade .modal-dialog {
        transition: none
    }
}

.modal.show .modal-dialog {
    -webkit-transform: none;
    transform: none
}

.modal.modal-static .modal-dialog {
    -webkit-transform: scale(1.02);
    transform: scale(1.02)
}

.modal-dialog-scrollable {
    display: -ms-flexbox;
    display: flex;
    max-height: calc(100% - 1rem)
}

.modal-dialog-scrollable .modal-content {
    max-height: calc(100vh - 1rem);
    overflow: hidden
}

.modal-dialog-scrollable .modal-footer,.modal-dialog-scrollable .modal-header {
    -ms-flex-negative: 0;
    flex-shrink: 0
}

.modal-dialog-scrollable .modal-body {
    overflow-y: auto
}

.modal-dialog-centered {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    min-height: calc(100% - 1rem)
}

.modal-dialog-centered::before {
    display: block;
    height: calc(100vh - 1rem);
    height: -webkit-min-content;
    height: -moz-min-content;
    height: min-content;
    content: ""
}

.modal-dialog-centered.modal-dialog-scrollable {
    -ms-flex-direction: column;
    flex-direction: column;
    -ms-flex-pack: center;
    justify-content: center;
    height: 100%
}

.modal-dialog-centered.modal-dialog-scrollable .modal-content {
    max-height: none
}

.modal-dialog-centered.modal-dialog-scrollable::before {
    content: none
}

.modal-content {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    width: 100%;
    pointer-events: auto;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: .3rem;
    outline: 0
}

.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1040;
    width: 100vw;
    height: 100vh;
    background-color: #000
}

.modal-backdrop.fade {
    opacity: 0
}

.modal-backdrop.show {
    opacity: .5
}

.modal-header {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: start;
    align-items: flex-start;
    -ms-flex-pack: justify;
    justify-content: space-between;
    padding: 1rem 1rem;
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: calc(.3rem - 1px);
    border-top-right-radius: calc(.3rem - 1px)
}

.modal-header .close {
    padding: 1rem 1rem;
    margin: -1rem -1rem -1rem auto
}

.modal-title {
    margin-bottom: 0;
    line-height: 1.5
}

.modal-body {
    position: relative;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1rem
}

.modal-footer {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-pack: end;
    justify-content: flex-end;
    padding: .75rem;
    border-top: 1px solid #dee2e6;
    border-bottom-right-radius: calc(.3rem - 1px);
    border-bottom-left-radius: calc(.3rem - 1px)
}

.modal-footer>* {
    margin: .25rem
}

.modal-scrollbar-measure {
    position: absolute;
    top: -9999px;
    width: 50px;
    height: 50px;
    overflow: scroll
}

@media (min-width: 576px) {
    .modal-dialog {
        max-width:500px;
        margin: 1.75rem auto
    }

    .modal-dialog-scrollable {
        max-height: calc(100% - 3.5rem)
    }

    .modal-dialog-scrollable .modal-content {
        max-height: calc(100vh - 3.5rem)
    }

    .modal-dialog-centered {
        min-height: calc(100% - 3.5rem)
    }

    .modal-dialog-centered::before {
        height: calc(100vh - 3.5rem);
        height: -webkit-min-content;
        height: -moz-min-content;
        height: min-content
    }

    .modal-sm {
        max-width: 300px
    }
}

@media (min-width: 992px) {
    .modal-lg,.modal-xl {
        max-width:800px
    }
}

@media (min-width: 1200px) {
    .modal-xl {
        max-width:1140px
    }
}

.tooltip {
    position: absolute;
    z-index: 1070;
    display: block;
    margin: 0;
    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans","Liberation Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    font-style: normal;
    font-weight: 400;
    line-height: 1.5;
    text-align: left;
    text-align: start;
    text-decoration: none;
    text-shadow: none;
    text-transform: none;
    letter-spacing: normal;
    word-break: normal;
    white-space: normal;
    word-spacing: normal;
    line-break: auto;
    font-size: .875rem;
    word-wrap: break-word;
    opacity: 0
}

.tooltip.show {
    opacity: .9
}

.tooltip .arrow {
    position: absolute;
    display: block;
    width: .8rem;
    height: .4rem
}

.tooltip .arrow::before {
    position: absolute;
    content: "";
    border-color: transparent;
    border-style: solid
}

.bs-tooltip-auto[x-placement^=top],.bs-tooltip-top {
    padding: .4rem 0
}

.bs-tooltip-auto[x-placement^=top] .arrow,.bs-tooltip-top .arrow {
    bottom: 0
}

.bs-tooltip-auto[x-placement^=top] .arrow::before,.bs-tooltip-top .arrow::before {
    top: 0;
    border-width: .4rem .4rem 0;
    border-top-color: #000
}

.bs-tooltip-auto[x-placement^=right],.bs-tooltip-right {
    padding: 0 .4rem
}

.bs-tooltip-auto[x-placement^=right] .arrow,.bs-tooltip-right .arrow {
    left: 0;
    width: .4rem;
    height: .8rem
}

.bs-tooltip-auto[x-placement^=right] .arrow::before,.bs-tooltip-right .arrow::before {
    right: 0;
    border-width: .4rem .4rem .4rem 0;
    border-right-color: #000
}

.bs-tooltip-auto[x-placement^=bottom],.bs-tooltip-bottom {
    padding: .4rem 0
}

.bs-tooltip-auto[x-placement^=bottom] .arrow,.bs-tooltip-bottom .arrow {
    top: 0
}

.bs-tooltip-auto[x-placement^=bottom] .arrow::before,.bs-tooltip-bottom .arrow::before {
    bottom: 0;
    border-width: 0 .4rem .4rem;
    border-bottom-color: #000
}

.bs-tooltip-auto[x-placement^=left],.bs-tooltip-left {
    padding: 0 .4rem
}

.bs-tooltip-auto[x-placement^=left] .arrow,.bs-tooltip-left .arrow {
    right: 0;
    width: .4rem;
    height: .8rem
}

.bs-tooltip-auto[x-placement^=left] .arrow::before,.bs-tooltip-left .arrow::before {
    left: 0;
    border-width: .4rem 0 .4rem .4rem;
    border-left-color: #000
}

.tooltip-inner {
    max-width: 200px;
    padding: .25rem .5rem;
    color: #fff;
    text-align: center;
    background-color: #000;
    border-radius: .25rem
}

.popover {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1060;
    display: block;
    max-width: 276px;
    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans","Liberation Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    font-style: normal;
    font-weight: 400;
    line-height: 1.5;
    text-align: left;
    text-align: start;
    text-decoration: none;
    text-shadow: none;
    text-transform: none;
    letter-spacing: normal;
    word-break: normal;
    white-space: normal;
    word-spacing: normal;
    line-break: auto;
    font-size: .875rem;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: .3rem
}

.popover .arrow {
    position: absolute;
    display: block;
    width: 1rem;
    height: .5rem;
    margin: 0 .3rem
}

.popover .arrow::after,.popover .arrow::before {
    position: absolute;
    display: block;
    content: "";
    border-color: transparent;
    border-style: solid
}

.bs-popover-auto[x-placement^=top],.bs-popover-top {
    margin-bottom: .5rem
}

.bs-popover-auto[x-placement^=top]>.arrow,.bs-popover-top>.arrow {
    bottom: calc(-.5rem - 1px)
}

.bs-popover-auto[x-placement^=top]>.arrow::before,.bs-popover-top>.arrow::before {
    bottom: 0;
    border-width: .5rem .5rem 0;
    border-top-color: rgba(0,0,0,.25)
}

.bs-popover-auto[x-placement^=top]>.arrow::after,.bs-popover-top>.arrow::after {
    bottom: 1px;
    border-width: .5rem .5rem 0;
    border-top-color: #fff
}

.bs-popover-auto[x-placement^=right],.bs-popover-right {
    margin-left: .5rem
}

.bs-popover-auto[x-placement^=right]>.arrow,.bs-popover-right>.arrow {
    left: calc(-.5rem - 1px);
    width: .5rem;
    height: 1rem;
    margin: .3rem 0
}

.bs-popover-auto[x-placement^=right]>.arrow::before,.bs-popover-right>.arrow::before {
    left: 0;
    border-width: .5rem .5rem .5rem 0;
    border-right-color: rgba(0,0,0,.25)
}

.bs-popover-auto[x-placement^=right]>.arrow::after,.bs-popover-right>.arrow::after {
    left: 1px;
    border-width: .5rem .5rem .5rem 0;
    border-right-color: #fff
}

.bs-popover-auto[x-placement^=bottom],.bs-popover-bottom {
    margin-top: .5rem
}

.bs-popover-auto[x-placement^=bottom]>.arrow,.bs-popover-bottom>.arrow {
    top: calc(-.5rem - 1px)
}

.bs-popover-auto[x-placement^=bottom]>.arrow::before,.bs-popover-bottom>.arrow::before {
    top: 0;
    border-width: 0 .5rem .5rem .5rem;
    border-bottom-color: rgba(0,0,0,.25)
}

.bs-popover-auto[x-placement^=bottom]>.arrow::after,.bs-popover-bottom>.arrow::after {
    top: 1px;
    border-width: 0 .5rem .5rem .5rem;
    border-bottom-color: #fff
}

.bs-popover-auto[x-placement^=bottom] .popover-header::before,.bs-popover-bottom .popover-header::before {
    position: absolute;
    top: 0;
    left: 50%;
    display: block;
    width: 1rem;
    margin-left: -.5rem;
    content: "";
    border-bottom: 1px solid #f7f7f7
}

.bs-popover-auto[x-placement^=left],.bs-popover-left {
    margin-right: .5rem
}

.bs-popover-auto[x-placement^=left]>.arrow,.bs-popover-left>.arrow {
    right: calc(-.5rem - 1px);
    width: .5rem;
    height: 1rem;
    margin: .3rem 0
}

.bs-popover-auto[x-placement^=left]>.arrow::before,.bs-popover-left>.arrow::before {
    right: 0;
    border-width: .5rem 0 .5rem .5rem;
    border-left-color: rgba(0,0,0,.25)
}

.bs-popover-auto[x-placement^=left]>.arrow::after,.bs-popover-left>.arrow::after {
    right: 1px;
    border-width: .5rem 0 .5rem .5rem;
    border-left-color: #fff
}

.popover-header {
    padding: .5rem .75rem;
    margin-bottom: 0;
    font-size: 1rem;
    background-color: #f7f7f7;
    border-bottom: 1px solid #ebebeb;
    border-top-left-radius: calc(.3rem - 1px);
    border-top-right-radius: calc(.3rem - 1px)
}

.popover-header:empty {
    display: none
}

.popover-body {
    padding: .5rem .75rem;
    color: #212529
}

.carousel {
    position: relative
}

.carousel.pointer-event {
    -ms-touch-action: pan-y;
    touch-action: pan-y
}

.carousel-inner {
    position: relative;
    width: 100%;
    overflow: hidden
}

.carousel-inner::after {
    display: block;
    clear: both;
    content: ""
}

.carousel-item {
    position: relative;
    display: none;
    float: left;
    width: 100%;
    margin-right: -100%;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    transition: -webkit-transform .6s ease-in-out;
    transition: transform .6s ease-in-out;
    transition: transform .6s ease-in-out,-webkit-transform .6s ease-in-out
}

@media (prefers-reduced-motion:reduce) {
    .carousel-item {
        transition: none
    }
}

.carousel-item-next,.carousel-item-prev,.carousel-item.active {
    display: block
}

.active.carousel-item-right,.carousel-item-next:not(.carousel-item-left) {
    -webkit-transform: translateX(100%);
    transform: translateX(100%)
}

.active.carousel-item-left,.carousel-item-prev:not(.carousel-item-right) {
    -webkit-transform: translateX(-100%);
    transform: translateX(-100%)
}

.carousel-fade .carousel-item {
    opacity: 0;
    transition-property: opacity;
    -webkit-transform: none;
    transform: none
}

.carousel-fade .carousel-item-next.carousel-item-left,.carousel-fade .carousel-item-prev.carousel-item-right,.carousel-fade .carousel-item.active {
    z-index: 1;
    opacity: 1
}

.carousel-fade .active.carousel-item-left,.carousel-fade .active.carousel-item-right {
    z-index: 0;
    opacity: 0;
    transition: opacity 0s .6s
}

@media (prefers-reduced-motion:reduce) {
    .carousel-fade .active.carousel-item-left,.carousel-fade .active.carousel-item-right {
        transition: none
    }
}

.carousel-control-next,.carousel-control-prev {
    position: absolute;
    top: 0;
    bottom: 0;
    z-index: 1;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-pack: center;
    justify-content: center;
    width: 15%;
    padding: 0;
    color: #fff;
    text-align: center;
    background: 0 0;
    border: 0;
    opacity: .5;
    transition: opacity .15s ease
}

@media (prefers-reduced-motion:reduce) {
    .carousel-control-next,.carousel-control-prev {
        transition: none
    }
}

.carousel-control-next:focus,.carousel-control-next:hover,.carousel-control-prev:focus,.carousel-control-prev:hover {
    color: #fff;
    text-decoration: none;
    outline: 0;
    opacity: .9
}

.carousel-control-prev {
    left: 0
}

.carousel-control-next {
    right: 0
}

.carousel-control-next-icon,.carousel-control-prev-icon {
    display: inline-block;
    width: 20px;
    height: 20px;
    background: 50%/100% 100% no-repeat
}

.carousel-control-prev-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath d='M5.25 0l-4 4 4 4 1.5-1.5L4.25 4l2.5-2.5L5.25 0z'/%3e%3c/svg%3e")
}

.carousel-control-next-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath d='M2.75 0l-1.5 1.5L3.75 4l-2.5 2.5L2.75 8l4-4-4-4z'/%3e%3c/svg%3e")
}

.carousel-indicators {
    position: absolute;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 15;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-pack: center;
    justify-content: center;
    padding-left: 0;
    margin-right: 15%;
    margin-left: 15%;
    list-style: none
}

.carousel-indicators li {
    box-sizing: content-box;
    -ms-flex: 0 1 auto;
    flex: 0 1 auto;
    width: 30px;
    height: 3px;
    margin-right: 3px;
    margin-left: 3px;
    text-indent: -999px;
    cursor: pointer;
    background-color: #fff;
    background-clip: padding-box;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    opacity: .5;
    transition: opacity .6s ease
}

@media (prefers-reduced-motion:reduce) {
    .carousel-indicators li {
        transition: none
    }
}

.carousel-indicators .active {
    opacity: 1
}

.carousel-caption {
    position: absolute;
    right: 15%;
    bottom: 20px;
    left: 15%;
    z-index: 10;
    padding-top: 20px;
    padding-bottom: 20px;
    color: #fff;
    text-align: center
}

@-webkit-keyframes spinner-border {
    to {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg)
    }
}

@keyframes spinner-border {
    to {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg)
    }
}

.spinner-border {
    display: inline-block;
    width: 2rem;
    height: 2rem;
    vertical-align: -.125em;
    border: .25em solid currentcolor;
    border-right-color: transparent;
    border-radius: 50%;
    -webkit-animation: .75s linear infinite spinner-border;
    animation: .75s linear infinite spinner-border
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
    border-width: .2em
}

@-webkit-keyframes spinner-grow {
    0% {
        -webkit-transform: scale(0);
        transform: scale(0)
    }

    50% {
        opacity: 1;
        -webkit-transform: none;
        transform: none
    }
}

@keyframes spinner-grow {
    0% {
        -webkit-transform: scale(0);
        transform: scale(0)
    }

    50% {
        opacity: 1;
        -webkit-transform: none;
        transform: none
    }
}

.spinner-grow {
    display: inline-block;
    width: 2rem;
    height: 2rem;
    vertical-align: -.125em;
    background-color: currentcolor;
    border-radius: 50%;
    opacity: 0;
    -webkit-animation: .75s linear infinite spinner-grow;
    animation: .75s linear infinite spinner-grow
}

.spinner-grow-sm {
    width: 1rem;
    height: 1rem
}

@media (prefers-reduced-motion:reduce) {
    .spinner-border,.spinner-grow {
        -webkit-animation-duration: 1.5s;
        animation-duration: 1.5s
    }
}

.align-baseline {
    vertical-align: baseline!important
}

.align-top {
    vertical-align: top!important
}

.align-middle {
    vertical-align: middle!important
}

.align-bottom {
    vertical-align: bottom!important
}

.align-text-bottom {
    vertical-align: text-bottom!important
}

.align-text-top {
    vertical-align: text-top!important
}

.bg-primary {
    background-color: #007bff!important
}

a.bg-primary:focus,a.bg-primary:hover,button.bg-primary:focus,button.bg-primary:hover {
    background-color: #0062cc!important
}

.bg-secondary {
    background-color: #6c757d!important
}

a.bg-secondary:focus,a.bg-secondary:hover,button.bg-secondary:focus,button.bg-secondary:hover {
    background-color: #545b62!important
}

.bg-success {
    background-color: #28a745!important
}

a.bg-success:focus,a.bg-success:hover,button.bg-success:focus,button.bg-success:hover {
    background-color: #1e7e34!important
}

.bg-info {
    background-color: #17a2b8!important
}

a.bg-info:focus,a.bg-info:hover,button.bg-info:focus,button.bg-info:hover {
    background-color: #117a8b!important
}

.bg-warning {
    background-color: #ffc107!important
}

a.bg-warning:focus,a.bg-warning:hover,button.bg-warning:focus,button.bg-warning:hover {
    background-color: #d39e00!important
}

.bg-danger {
    background-color: #dc3545!important
}

a.bg-danger:focus,a.bg-danger:hover,button.bg-danger:focus,button.bg-danger:hover {
    background-color: #bd2130!important
}

.bg-light {
    background-color: #f8f9fa!important
}

a.bg-light:focus,a.bg-light:hover,button.bg-light:focus,button.bg-light:hover {
    background-color: #dae0e5!important
}

.bg-dark {
    background-color: #343a40!important
}

a.bg-dark:focus,a.bg-dark:hover,button.bg-dark:focus,button.bg-dark:hover {
    background-color: #1d2124!important
}

.bg-white {
    background-color: #fff!important
}

.bg-transparent {
    background-color: transparent!important
}

.border {
    border: 1px solid #dee2e6!important
}

.border-top {
    border-top: 1px solid #dee2e6!important
}

.border-right {
    border-right: 1px solid #dee2e6!important
}

.border-bottom {
    border-bottom: 1px solid #dee2e6!important
}

.border-left {
    border-left: 1px solid #dee2e6!important
}

.border-0 {
    border: 0!important
}

.border-top-0 {
    border-top: 0!important
}

.border-right-0 {
    border-right: 0!important
}

.border-bottom-0 {
    border-bottom: 0!important
}

.border-left-0 {
    border-left: 0!important
}

.border-primary {
    border-color: #007bff!important
}

.border-secondary {
    border-color: #6c757d!important
}

.border-success {
    border-color: #28a745!important
}

.border-info {
    border-color: #17a2b8!important
}

.border-warning {
    border-color: #ffc107!important
}

.border-danger {
    border-color: #dc3545!important
}

.border-light {
    border-color: #f8f9fa!important
}

.border-dark {
    border-color: #343a40!important
}

.border-white {
    border-color: #fff!important
}

.rounded-sm {
    border-radius: .2rem!important
}

.rounded {
    border-radius: .25rem!important
}

.rounded-top {
    border-top-left-radius: .25rem!important;
    border-top-right-radius: .25rem!important
}

.rounded-right {
    border-top-right-radius: .25rem!important;
    border-bottom-right-radius: .25rem!important
}

.rounded-bottom {
    border-bottom-right-radius: .25rem!important;
    border-bottom-left-radius: .25rem!important
}

.rounded-left {
    border-top-left-radius: .25rem!important;
    border-bottom-left-radius: .25rem!important
}

.rounded-lg {
    border-radius: .3rem!important
}

.rounded-circle {
    border-radius: 50%!important
}

.rounded-pill {
    border-radius: 50rem!important
}

.rounded-0 {
    border-radius: 0!important
}

.clearfix::after {
    display: block;
    clear: both;
    content: ""
}

.d-none {
    display: none!important
}

.d-inline {
    display: inline!important
}

.d-inline-block {
    display: inline-block!important
}

.d-block {
    display: block!important
}

.d-table {
    display: table!important
}

.d-table-row {
    display: table-row!important
}

.d-table-cell {
    display: table-cell!important
}

.d-flex {
    display: -ms-flexbox!important;
    display: flex!important
}

.d-inline-flex {
    display: -ms-inline-flexbox!important;
    display: inline-flex!important
}

@media (min-width: 576px) {
    .d-sm-none {
        display:none!important
    }

    .d-sm-inline {
        display: inline!important
    }

    .d-sm-inline-block {
        display: inline-block!important
    }

    .d-sm-block {
        display: block!important
    }

    .d-sm-table {
        display: table!important
    }

    .d-sm-table-row {
        display: table-row!important
    }

    .d-sm-table-cell {
        display: table-cell!important
    }

    .d-sm-flex {
        display: -ms-flexbox!important;
        display: flex!important
    }

    .d-sm-inline-flex {
        display: -ms-inline-flexbox!important;
        display: inline-flex!important
    }
}

@media (min-width: 768px) {
    .d-md-none {
        display:none!important
    }

    .d-md-inline {
        display: inline!important
    }

    .d-md-inline-block {
        display: inline-block!important
    }

    .d-md-block {
        display: block!important
    }

    .d-md-table {
        display: table!important
    }

    .d-md-table-row {
        display: table-row!important
    }

    .d-md-table-cell {
        display: table-cell!important
    }

    .d-md-flex {
        display: -ms-flexbox!important;
        display: flex!important
    }

    .d-md-inline-flex {
        display: -ms-inline-flexbox!important;
        display: inline-flex!important
    }
}

@media (min-width: 992px) {
    .d-lg-none {
        display:none!important
    }

    .d-lg-inline {
        display: inline!important
    }

    .d-lg-inline-block {
        display: inline-block!important
    }

    .d-lg-block {
        display: block!important
    }

    .d-lg-table {
        display: table!important
    }

    .d-lg-table-row {
        display: table-row!important
    }

    .d-lg-table-cell {
        display: table-cell!important
    }

    .d-lg-flex {
        display: -ms-flexbox!important;
        display: flex!important
    }

    .d-lg-inline-flex {
        display: -ms-inline-flexbox!important;
        display: inline-flex!important
    }
}

@media (min-width: 1200px) {
    .d-xl-none {
        display:none!important
    }

    .d-xl-inline {
        display: inline!important
    }

    .d-xl-inline-block {
        display: inline-block!important
    }

    .d-xl-block {
        display: block!important
    }

    .d-xl-table {
        display: table!important
    }

    .d-xl-table-row {
        display: table-row!important
    }

    .d-xl-table-cell {
        display: table-cell!important
    }

    .d-xl-flex {
        display: -ms-flexbox!important;
        display: flex!important
    }

    .d-xl-inline-flex {
        display: -ms-inline-flexbox!important;
        display: inline-flex!important
    }
}

@media print {
    .d-print-none {
        display: none!important
    }

    .d-print-inline {
        display: inline!important
    }

    .d-print-inline-block {
        display: inline-block!important
    }

    .d-print-block {
        display: block!important
    }

    .d-print-table {
        display: table!important
    }

    .d-print-table-row {
        display: table-row!important
    }

    .d-print-table-cell {
        display: table-cell!important
    }

    .d-print-flex {
        display: -ms-flexbox!important;
        display: flex!important
    }

    .d-print-inline-flex {
        display: -ms-inline-flexbox!important;
        display: inline-flex!important
    }
}

.embed-responsive {
    position: relative;
    display: block;
    width: 100%;
    padding: 0;
    overflow: hidden
}

.embed-responsive::before {
    display: block;
    content: ""
}

.embed-responsive .embed-responsive-item,.embed-responsive embed,.embed-responsive iframe,.embed-responsive object,.embed-responsive video {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0
}

.embed-responsive-21by9::before {
    padding-top: 42.857143%
}

.embed-responsive-16by9::before {
    padding-top: 56.25%
}

.embed-responsive-4by3::before {
    padding-top: 75%
}

.embed-responsive-1by1::before {
    padding-top: 100%
}

.flex-row {
    -ms-flex-direction: row!important;
    flex-direction: row!important
}

.flex-column {
    -ms-flex-direction: column!important;
    flex-direction: column!important
}

.flex-row-reverse {
    -ms-flex-direction: row-reverse!important;
    flex-direction: row-reverse!important
}

.flex-column-reverse {
    -ms-flex-direction: column-reverse!important;
    flex-direction: column-reverse!important
}

.flex-wrap {
    -ms-flex-wrap: wrap!important;
    flex-wrap: wrap!important
}

.flex-nowrap {
    -ms-flex-wrap: nowrap!important;
    flex-wrap: nowrap!important
}

.flex-wrap-reverse {
    -ms-flex-wrap: wrap-reverse!important;
    flex-wrap: wrap-reverse!important
}

.flex-fill {
    -ms-flex: 1 1 auto!important;
    flex: 1 1 auto!important
}

.flex-grow-0 {
    -ms-flex-positive: 0!important;
    flex-grow: 0!important
}

.flex-grow-1 {
    -ms-flex-positive: 1!important;
    flex-grow: 1!important
}

.flex-shrink-0 {
    -ms-flex-negative: 0!important;
    flex-shrink: 0!important
}

.flex-shrink-1 {
    -ms-flex-negative: 1!important;
    flex-shrink: 1!important
}

.justify-content-start {
    -ms-flex-pack: start!important;
    justify-content: flex-start!important
}

.justify-content-end {
    -ms-flex-pack: end!important;
    justify-content: flex-end!important
}

.justify-content-center {
    -ms-flex-pack: center!important;
    justify-content: center!important
}

.justify-content-between {
    -ms-flex-pack: justify!important;
    justify-content: space-between!important
}

.justify-content-around {
    -ms-flex-pack: distribute!important;
    justify-content: space-around!important
}

.align-items-start {
    -ms-flex-align: start!important;
    align-items: flex-start!important
}

.align-items-end {
    -ms-flex-align: end!important;
    align-items: flex-end!important
}

.align-items-center {
    -ms-flex-align: center!important;
    align-items: center!important
}

.align-items-baseline {
    -ms-flex-align: baseline!important;
    align-items: baseline!important
}

.align-items-stretch {
    -ms-flex-align: stretch!important;
    align-items: stretch!important
}

.align-content-start {
    -ms-flex-line-pack: start!important;
    align-content: flex-start!important
}

.align-content-end {
    -ms-flex-line-pack: end!important;
    align-content: flex-end!important
}

.align-content-center {
    -ms-flex-line-pack: center!important;
    align-content: center!important
}

.align-content-between {
    -ms-flex-line-pack: justify!important;
    align-content: space-between!important
}

.align-content-around {
    -ms-flex-line-pack: distribute!important;
    align-content: space-around!important
}

.align-content-stretch {
    -ms-flex-line-pack: stretch!important;
    align-content: stretch!important
}

.align-self-auto {
    -ms-flex-item-align: auto!important;
    align-self: auto!important
}

.align-self-start {
    -ms-flex-item-align: start!important;
    align-self: flex-start!important
}

.align-self-end {
    -ms-flex-item-align: end!important;
    align-self: flex-end!important
}

.align-self-center {
    -ms-flex-item-align: center!important;
    align-self: center!important
}

.align-self-baseline {
    -ms-flex-item-align: baseline!important;
    align-self: baseline!important
}

.align-self-stretch {
    -ms-flex-item-align: stretch!important;
    align-self: stretch!important
}

@media (min-width: 576px) {
    .flex-sm-row {
        -ms-flex-direction:row!important;
        flex-direction: row!important
    }

    .flex-sm-column {
        -ms-flex-direction: column!important;
        flex-direction: column!important
    }

    .flex-sm-row-reverse {
        -ms-flex-direction: row-reverse!important;
        flex-direction: row-reverse!important
    }

    .flex-sm-column-reverse {
        -ms-flex-direction: column-reverse!important;
        flex-direction: column-reverse!important
    }

    .flex-sm-wrap {
        -ms-flex-wrap: wrap!important;
        flex-wrap: wrap!important
    }

    .flex-sm-nowrap {
        -ms-flex-wrap: nowrap!important;
        flex-wrap: nowrap!important
    }

    .flex-sm-wrap-reverse {
        -ms-flex-wrap: wrap-reverse!important;
        flex-wrap: wrap-reverse!important
    }

    .flex-sm-fill {
        -ms-flex: 1 1 auto!important;
        flex: 1 1 auto!important
    }

    .flex-sm-grow-0 {
        -ms-flex-positive: 0!important;
        flex-grow: 0!important
    }

    .flex-sm-grow-1 {
        -ms-flex-positive: 1!important;
        flex-grow: 1!important
    }

    .flex-sm-shrink-0 {
        -ms-flex-negative: 0!important;
        flex-shrink: 0!important
    }

    .flex-sm-shrink-1 {
        -ms-flex-negative: 1!important;
        flex-shrink: 1!important
    }

    .justify-content-sm-start {
        -ms-flex-pack: start!important;
        justify-content: flex-start!important
    }

    .justify-content-sm-end {
        -ms-flex-pack: end!important;
        justify-content: flex-end!important
    }

    .justify-content-sm-center {
        -ms-flex-pack: center!important;
        justify-content: center!important
    }

    .justify-content-sm-between {
        -ms-flex-pack: justify!important;
        justify-content: space-between!important
    }

    .justify-content-sm-around {
        -ms-flex-pack: distribute!important;
        justify-content: space-around!important
    }

    .align-items-sm-start {
        -ms-flex-align: start!important;
        align-items: flex-start!important
    }

    .align-items-sm-end {
        -ms-flex-align: end!important;
        align-items: flex-end!important
    }

    .align-items-sm-center {
        -ms-flex-align: center!important;
        align-items: center!important
    }

    .align-items-sm-baseline {
        -ms-flex-align: baseline!important;
        align-items: baseline!important
    }

    .align-items-sm-stretch {
        -ms-flex-align: stretch!important;
        align-items: stretch!important
    }

    .align-content-sm-start {
        -ms-flex-line-pack: start!important;
        align-content: flex-start!important
    }

    .align-content-sm-end {
        -ms-flex-line-pack: end!important;
        align-content: flex-end!important
    }

    .align-content-sm-center {
        -ms-flex-line-pack: center!important;
        align-content: center!important
    }

    .align-content-sm-between {
        -ms-flex-line-pack: justify!important;
        align-content: space-between!important
    }

    .align-content-sm-around {
        -ms-flex-line-pack: distribute!important;
        align-content: space-around!important
    }

    .align-content-sm-stretch {
        -ms-flex-line-pack: stretch!important;
        align-content: stretch!important
    }

    .align-self-sm-auto {
        -ms-flex-item-align: auto!important;
        align-self: auto!important
    }

    .align-self-sm-start {
        -ms-flex-item-align: start!important;
        align-self: flex-start!important
    }

    .align-self-sm-end {
        -ms-flex-item-align: end!important;
        align-self: flex-end!important
    }

    .align-self-sm-center {
        -ms-flex-item-align: center!important;
        align-self: center!important
    }

    .align-self-sm-baseline {
        -ms-flex-item-align: baseline!important;
        align-self: baseline!important
    }

    .align-self-sm-stretch {
        -ms-flex-item-align: stretch!important;
        align-self: stretch!important
    }
}

@media (min-width: 768px) {
    .flex-md-row {
        -ms-flex-direction:row!important;
        flex-direction: row!important
    }

    .flex-md-column {
        -ms-flex-direction: column!important;
        flex-direction: column!important
    }

    .flex-md-row-reverse {
        -ms-flex-direction: row-reverse!important;
        flex-direction: row-reverse!important
    }

    .flex-md-column-reverse {
        -ms-flex-direction: column-reverse!important;
        flex-direction: column-reverse!important
    }

    .flex-md-wrap {
        -ms-flex-wrap: wrap!important;
        flex-wrap: wrap!important
    }

    .flex-md-nowrap {
        -ms-flex-wrap: nowrap!important;
        flex-wrap: nowrap!important
    }

    .flex-md-wrap-reverse {
        -ms-flex-wrap: wrap-reverse!important;
        flex-wrap: wrap-reverse!important
    }

    .flex-md-fill {
        -ms-flex: 1 1 auto!important;
        flex: 1 1 auto!important
    }

    .flex-md-grow-0 {
        -ms-flex-positive: 0!important;
        flex-grow: 0!important
    }

    .flex-md-grow-1 {
        -ms-flex-positive: 1!important;
        flex-grow: 1!important
    }

    .flex-md-shrink-0 {
        -ms-flex-negative: 0!important;
        flex-shrink: 0!important
    }

    .flex-md-shrink-1 {
        -ms-flex-negative: 1!important;
        flex-shrink: 1!important
    }

    .justify-content-md-start {
        -ms-flex-pack: start!important;
        justify-content: flex-start!important
    }

    .justify-content-md-end {
        -ms-flex-pack: end!important;
        justify-content: flex-end!important
    }

    .justify-content-md-center {
        -ms-flex-pack: center!important;
        justify-content: center!important
    }

    .justify-content-md-between {
        -ms-flex-pack: justify!important;
        justify-content: space-between!important
    }

    .justify-content-md-around {
        -ms-flex-pack: distribute!important;
        justify-content: space-around!important
    }

    .align-items-md-start {
        -ms-flex-align: start!important;
        align-items: flex-start!important
    }

    .align-items-md-end {
        -ms-flex-align: end!important;
        align-items: flex-end!important
    }

    .align-items-md-center {
        -ms-flex-align: center!important;
        align-items: center!important
    }

    .align-items-md-baseline {
        -ms-flex-align: baseline!important;
        align-items: baseline!important
    }

    .align-items-md-stretch {
        -ms-flex-align: stretch!important;
        align-items: stretch!important
    }

    .align-content-md-start {
        -ms-flex-line-pack: start!important;
        align-content: flex-start!important
    }

    .align-content-md-end {
        -ms-flex-line-pack: end!important;
        align-content: flex-end!important
    }

    .align-content-md-center {
        -ms-flex-line-pack: center!important;
        align-content: center!important
    }

    .align-content-md-between {
        -ms-flex-line-pack: justify!important;
        align-content: space-between!important
    }

    .align-content-md-around {
        -ms-flex-line-pack: distribute!important;
        align-content: space-around!important
    }

    .align-content-md-stretch {
        -ms-flex-line-pack: stretch!important;
        align-content: stretch!important
    }

    .align-self-md-auto {
        -ms-flex-item-align: auto!important;
        align-self: auto!important
    }

    .align-self-md-start {
        -ms-flex-item-align: start!important;
        align-self: flex-start!important
    }

    .align-self-md-end {
        -ms-flex-item-align: end!important;
        align-self: flex-end!important
    }

    .align-self-md-center {
        -ms-flex-item-align: center!important;
        align-self: center!important
    }

    .align-self-md-baseline {
        -ms-flex-item-align: baseline!important;
        align-self: baseline!important
    }

    .align-self-md-stretch {
        -ms-flex-item-align: stretch!important;
        align-self: stretch!important
    }
}

@media (min-width: 992px) {
    .flex-lg-row {
        -ms-flex-direction:row!important;
        flex-direction: row!important
    }

    .flex-lg-column {
        -ms-flex-direction: column!important;
        flex-direction: column!important
    }

    .flex-lg-row-reverse {
        -ms-flex-direction: row-reverse!important;
        flex-direction: row-reverse!important
    }

    .flex-lg-column-reverse {
        -ms-flex-direction: column-reverse!important;
        flex-direction: column-reverse!important
    }

    .flex-lg-wrap {
        -ms-flex-wrap: wrap!important;
        flex-wrap: wrap!important
    }

    .flex-lg-nowrap {
        -ms-flex-wrap: nowrap!important;
        flex-wrap: nowrap!important
    }

    .flex-lg-wrap-reverse {
        -ms-flex-wrap: wrap-reverse!important;
        flex-wrap: wrap-reverse!important
    }

    .flex-lg-fill {
        -ms-flex: 1 1 auto!important;
        flex: 1 1 auto!important
    }

    .flex-lg-grow-0 {
        -ms-flex-positive: 0!important;
        flex-grow: 0!important
    }

    .flex-lg-grow-1 {
        -ms-flex-positive: 1!important;
        flex-grow: 1!important
    }

    .flex-lg-shrink-0 {
        -ms-flex-negative: 0!important;
        flex-shrink: 0!important
    }

    .flex-lg-shrink-1 {
        -ms-flex-negative: 1!important;
        flex-shrink: 1!important
    }

    .justify-content-lg-start {
        -ms-flex-pack: start!important;
        justify-content: flex-start!important
    }

    .justify-content-lg-end {
        -ms-flex-pack: end!important;
        justify-content: flex-end!important
    }

    .justify-content-lg-center {
        -ms-flex-pack: center!important;
        justify-content: center!important
    }

    .justify-content-lg-between {
        -ms-flex-pack: justify!important;
        justify-content: space-between!important
    }

    .justify-content-lg-around {
        -ms-flex-pack: distribute!important;
        justify-content: space-around!important
    }

    .align-items-lg-start {
        -ms-flex-align: start!important;
        align-items: flex-start!important
    }

    .align-items-lg-end {
        -ms-flex-align: end!important;
        align-items: flex-end!important
    }

    .align-items-lg-center {
        -ms-flex-align: center!important;
        align-items: center!important
    }

    .align-items-lg-baseline {
        -ms-flex-align: baseline!important;
        align-items: baseline!important
    }

    .align-items-lg-stretch {
        -ms-flex-align: stretch!important;
        align-items: stretch!important
    }

    .align-content-lg-start {
        -ms-flex-line-pack: start!important;
        align-content: flex-start!important
    }

    .align-content-lg-end {
        -ms-flex-line-pack: end!important;
        align-content: flex-end!important
    }

    .align-content-lg-center {
        -ms-flex-line-pack: center!important;
        align-content: center!important
    }

    .align-content-lg-between {
        -ms-flex-line-pack: justify!important;
        align-content: space-between!important
    }

    .align-content-lg-around {
        -ms-flex-line-pack: distribute!important;
        align-content: space-around!important
    }

    .align-content-lg-stretch {
        -ms-flex-line-pack: stretch!important;
        align-content: stretch!important
    }

    .align-self-lg-auto {
        -ms-flex-item-align: auto!important;
        align-self: auto!important
    }

    .align-self-lg-start {
        -ms-flex-item-align: start!important;
        align-self: flex-start!important
    }

    .align-self-lg-end {
        -ms-flex-item-align: end!important;
        align-self: flex-end!important
    }

    .align-self-lg-center {
        -ms-flex-item-align: center!important;
        align-self: center!important
    }

    .align-self-lg-baseline {
        -ms-flex-item-align: baseline!important;
        align-self: baseline!important
    }

    .align-self-lg-stretch {
        -ms-flex-item-align: stretch!important;
        align-self: stretch!important
    }
}

@media (min-width: 1200px) {
    .flex-xl-row {
        -ms-flex-direction:row!important;
        flex-direction: row!important
    }

    .flex-xl-column {
        -ms-flex-direction: column!important;
        flex-direction: column!important
    }

    .flex-xl-row-reverse {
        -ms-flex-direction: row-reverse!important;
        flex-direction: row-reverse!important
    }

    .flex-xl-column-reverse {
        -ms-flex-direction: column-reverse!important;
        flex-direction: column-reverse!important
    }

    .flex-xl-wrap {
        -ms-flex-wrap: wrap!important;
        flex-wrap: wrap!important
    }

    .flex-xl-nowrap {
        -ms-flex-wrap: nowrap!important;
        flex-wrap: nowrap!important
    }

    .flex-xl-wrap-reverse {
        -ms-flex-wrap: wrap-reverse!important;
        flex-wrap: wrap-reverse!important
    }

    .flex-xl-fill {
        -ms-flex: 1 1 auto!important;
        flex: 1 1 auto!important
    }

    .flex-xl-grow-0 {
        -ms-flex-positive: 0!important;
        flex-grow: 0!important
    }

    .flex-xl-grow-1 {
        -ms-flex-positive: 1!important;
        flex-grow: 1!important
    }

    .flex-xl-shrink-0 {
        -ms-flex-negative: 0!important;
        flex-shrink: 0!important
    }

    .flex-xl-shrink-1 {
        -ms-flex-negative: 1!important;
        flex-shrink: 1!important
    }

    .justify-content-xl-start {
        -ms-flex-pack: start!important;
        justify-content: flex-start!important
    }

    .justify-content-xl-end {
        -ms-flex-pack: end!important;
        justify-content: flex-end!important
    }

    .justify-content-xl-center {
        -ms-flex-pack: center!important;
        justify-content: center!important
    }

    .justify-content-xl-between {
        -ms-flex-pack: justify!important;
        justify-content: space-between!important
    }

    .justify-content-xl-around {
        -ms-flex-pack: distribute!important;
        justify-content: space-around!important
    }

    .align-items-xl-start {
        -ms-flex-align: start!important;
        align-items: flex-start!important
    }

    .align-items-xl-end {
        -ms-flex-align: end!important;
        align-items: flex-end!important
    }

    .align-items-xl-center {
        -ms-flex-align: center!important;
        align-items: center!important
    }

    .align-items-xl-baseline {
        -ms-flex-align: baseline!important;
        align-items: baseline!important
    }

    .align-items-xl-stretch {
        -ms-flex-align: stretch!important;
        align-items: stretch!important
    }

    .align-content-xl-start {
        -ms-flex-line-pack: start!important;
        align-content: flex-start!important
    }

    .align-content-xl-end {
        -ms-flex-line-pack: end!important;
        align-content: flex-end!important
    }

    .align-content-xl-center {
        -ms-flex-line-pack: center!important;
        align-content: center!important
    }

    .align-content-xl-between {
        -ms-flex-line-pack: justify!important;
        align-content: space-between!important
    }

    .align-content-xl-around {
        -ms-flex-line-pack: distribute!important;
        align-content: space-around!important
    }

    .align-content-xl-stretch {
        -ms-flex-line-pack: stretch!important;
        align-content: stretch!important
    }

    .align-self-xl-auto {
        -ms-flex-item-align: auto!important;
        align-self: auto!important
    }

    .align-self-xl-start {
        -ms-flex-item-align: start!important;
        align-self: flex-start!important
    }

    .align-self-xl-end {
        -ms-flex-item-align: end!important;
        align-self: flex-end!important
    }

    .align-self-xl-center {
        -ms-flex-item-align: center!important;
        align-self: center!important
    }

    .align-self-xl-baseline {
        -ms-flex-item-align: baseline!important;
        align-self: baseline!important
    }

    .align-self-xl-stretch {
        -ms-flex-item-align: stretch!important;
        align-self: stretch!important
    }
}

.float-left {
    float: left!important
}

.float-right {
    float: right!important
}

.float-none {
    float: none!important
}

@media (min-width: 576px) {
    .float-sm-left {
        float:left!important
    }

    .float-sm-right {
        float: right!important
    }

    .float-sm-none {
        float: none!important
    }
}

@media (min-width: 768px) {
    .float-md-left {
        float:left!important
    }

    .float-md-right {
        float: right!important
    }

    .float-md-none {
        float: none!important
    }
}

@media (min-width: 992px) {
    .float-lg-left {
        float:left!important
    }

    .float-lg-right {
        float: right!important
    }

    .float-lg-none {
        float: none!important
    }
}

@media (min-width: 1200px) {
    .float-xl-left {
        float:left!important
    }

    .float-xl-right {
        float: right!important
    }

    .float-xl-none {
        float: none!important
    }
}

.user-select-all {
    -webkit-user-select: all!important;
    -moz-user-select: all!important;
    user-select: all!important
}

.user-select-auto {
    -webkit-user-select: auto!important;
    -moz-user-select: auto!important;
    -ms-user-select: auto!important;
    user-select: auto!important
}

.user-select-none {
    -webkit-user-select: none!important;
    -moz-user-select: none!important;
    -ms-user-select: none!important;
    user-select: none!important
}

.overflow-auto {
    overflow: auto!important
}

.overflow-hidden {
    overflow: hidden!important
}

.position-static {
    position: static!important
}

.position-relative {
    position: relative!important
}

.position-absolute {
    position: absolute!important
}

.position-fixed {
    position: fixed!important
}

.position-sticky {
    position: -webkit-sticky!important;
    position: sticky!important
}

.fixed-top {
    position: fixed;
    top: 0;
    right: 0;
    left: 0;
    z-index: 1030
}

.fixed-bottom {
    position: fixed;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1030
}

@supports ((position: -webkit-sticky) or (position:sticky)) {
    .sticky-top {
        position:-webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 1020
    }
}

.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0,0,0,0);
    white-space: nowrap;
    border: 0
}

.sr-only-focusable:active,.sr-only-focusable:focus {
    position: static;
    width: auto;
    height: auto;
    overflow: visible;
    clip: auto;
    white-space: normal
}

.shadow-sm {
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important
}

.shadow {
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important
}

.shadow-lg {
    box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important
}

.shadow-none {
    box-shadow: none!important
}

.w-25 {
    width: 25%!important
}

.w-50 {
    width: 50%!important
}

.w-75 {
    width: 75%!important
}

.w-100 {
    width: 100%!important
}

.w-auto {
    width: auto!important
}

.h-25 {
    height: 25%!important
}

.h-50 {
    height: 50%!important
}

.h-75 {
    height: 75%!important
}

.h-100 {
    height: 100%!important
}

.h-auto {
    height: auto!important
}

.mw-100 {
    max-width: 100%!important
}

.mh-100 {
    max-height: 100%!important
}

.min-vw-100 {
    min-width: 100vw!important
}

.min-vh-100 {
    min-height: 100vh!important
}

.vw-100 {
    width: 100vw!important
}

.vh-100 {
    height: 100vh!important
}

.m-0 {
    margin: 0!important
}

.mt-0,.my-0 {
    margin-top: 0!important
}

.mr-0,.mx-0 {
    margin-right: 0!important
}

.mb-0,.my-0 {
    margin-bottom: 0!important
}

.ml-0,.mx-0 {
    margin-left: 0!important
}

.m-1 {
    margin: .25rem!important
}

.mt-1,.my-1 {
    margin-top: .25rem!important
}

.mr-1,.mx-1 {
    margin-right: .25rem!important
}

.mb-1,.my-1 {
    margin-bottom: .25rem!important
}

.ml-1,.mx-1 {
    margin-left: .25rem!important
}

.m-2 {
    margin: .5rem!important
}

.mt-2,.my-2 {
    margin-top: .5rem!important
}

.mr-2,.mx-2 {
    margin-right: .5rem!important
}

.mb-2,.my-2 {
    margin-bottom: .5rem!important
}

.ml-2,.mx-2 {
    margin-left: .5rem!important
}

.m-3 {
    margin: 1rem!important
}

.mt-3,.my-3 {
    margin-top: 1rem!important
}

.mr-3,.mx-3 {
    margin-right: 1rem!important
}

.mb-3,.my-3 {
    margin-bottom: 1rem!important
}

.ml-3,.mx-3 {
    margin-left: 1rem!important
}

.m-4 {
    margin: 1.5rem!important
}

.mt-4,.my-4 {
    margin-top: 1.5rem!important
}

.mr-4,.mx-4 {
    margin-right: 1.5rem!important
}

.mb-4,.my-4 {
    margin-bottom: 1.5rem!important
}

.ml-4,.mx-4 {
    margin-left: 1.5rem!important
}

.m-5 {
    margin: 3rem!important
}

.mt-5,.my-5 {
    margin-top: 3rem!important
}

.mr-5,.mx-5 {
    margin-right: 3rem!important
}

.mb-5,.my-5 {
    margin-bottom: 3rem!important
}

.ml-5,.mx-5 {
    margin-left: 3rem!important
}

.p-0 {
    padding: 0!important
}

.pt-0,.py-0 {
    padding-top: 0!important
}

.pr-0,.px-0 {
    padding-right: 0!important
}

.pb-0,.py-0 {
    padding-bottom: 0!important
}

.pl-0,.px-0 {
    padding-left: 0!important
}

.p-1 {
    padding: .25rem!important
}

.pt-1,.py-1 {
    padding-top: .25rem!important
}

.pr-1,.px-1 {
    padding-right: .25rem!important
}

.pb-1,.py-1 {
    padding-bottom: .25rem!important
}

.pl-1,.px-1 {
    padding-left: .25rem!important
}

.p-2 {
    padding: .5rem!important
}

.pt-2,.py-2 {
    padding-top: .5rem!important
}

.pr-2,.px-2 {
    padding-right: .5rem!important
}

.pb-2,.py-2 {
    padding-bottom: .5rem!important
}

.pl-2,.px-2 {
    padding-left: .5rem!important
}

.p-3 {
    padding: 1rem!important
}

.pt-3,.py-3 {
    padding-top: 1rem!important
}

.pr-3,.px-3 {
    padding-right: 1rem!important
}

.pb-3,.py-3 {
    padding-bottom: 1rem!important
}

.pl-3,.px-3 {
    padding-left: 1rem!important
}

.p-4 {
    padding: 1.5rem!important
}

.pt-4,.py-4 {
    padding-top: 1.5rem!important
}

.pr-4,.px-4 {
    padding-right: 1.5rem!important
}

.pb-4,.py-4 {
    padding-bottom: 1.5rem!important
}

.pl-4,.px-4 {
    padding-left: 1.5rem!important
}

.p-5 {
    padding: 3rem!important
}

.pt-5,.py-5 {
    padding-top: 3rem!important
}

.pr-5,.px-5 {
    padding-right: 3rem!important
}

.pb-5,.py-5 {
    padding-bottom: 3rem!important
}

.pl-5,.px-5 {
    padding-left: 3rem!important
}

.m-n1 {
    margin: -.25rem!important
}

.mt-n1,.my-n1 {
    margin-top: -.25rem!important
}

.mr-n1,.mx-n1 {
    margin-right: -.25rem!important
}

.mb-n1,.my-n1 {
    margin-bottom: -.25rem!important
}

.ml-n1,.mx-n1 {
    margin-left: -.25rem!important
}

.m-n2 {
    margin: -.5rem!important
}

.mt-n2,.my-n2 {
    margin-top: -.5rem!important
}

.mr-n2,.mx-n2 {
    margin-right: -.5rem!important
}

.mb-n2,.my-n2 {
    margin-bottom: -.5rem!important
}

.ml-n2,.mx-n2 {
    margin-left: -.5rem!important
}

.m-n3 {
    margin: -1rem!important
}

.mt-n3,.my-n3 {
    margin-top: -1rem!important
}

.mr-n3,.mx-n3 {
    margin-right: -1rem!important
}

.mb-n3,.my-n3 {
    margin-bottom: -1rem!important
}

.ml-n3,.mx-n3 {
    margin-left: -1rem!important
}

.m-n4 {
    margin: -1.5rem!important
}

.mt-n4,.my-n4 {
    margin-top: -1.5rem!important
}

.mr-n4,.mx-n4 {
    margin-right: -1.5rem!important
}

.mb-n4,.my-n4 {
    margin-bottom: -1.5rem!important
}

.ml-n4,.mx-n4 {
    margin-left: -1.5rem!important
}

.m-n5 {
    margin: -3rem!important
}

.mt-n5,.my-n5 {
    margin-top: -3rem!important
}

.mr-n5,.mx-n5 {
    margin-right: -3rem!important
}

.mb-n5,.my-n5 {
    margin-bottom: -3rem!important
}

.ml-n5,.mx-n5 {
    margin-left: -3rem!important
}

.m-auto {
    margin: auto!important
}

.mt-auto,.my-auto {
    margin-top: auto!important
}

.mr-auto,.mx-auto {
    margin-right: auto!important
}

.mb-auto,.my-auto {
    margin-bottom: auto!important
}

.ml-auto,.mx-auto {
    margin-left: auto!important
}

@media (min-width: 576px) {
    .m-sm-0 {
        margin:0!important
    }

    .mt-sm-0,.my-sm-0 {
        margin-top: 0!important
    }

    .mr-sm-0,.mx-sm-0 {
        margin-right: 0!important
    }

    .mb-sm-0,.my-sm-0 {
        margin-bottom: 0!important
    }

    .ml-sm-0,.mx-sm-0 {
        margin-left: 0!important
    }

    .m-sm-1 {
        margin: .25rem!important
    }

    .mt-sm-1,.my-sm-1 {
        margin-top: .25rem!important
    }

    .mr-sm-1,.mx-sm-1 {
        margin-right: .25rem!important
    }

    .mb-sm-1,.my-sm-1 {
        margin-bottom: .25rem!important
    }

    .ml-sm-1,.mx-sm-1 {
        margin-left: .25rem!important
    }

    .m-sm-2 {
        margin: .5rem!important
    }

    .mt-sm-2,.my-sm-2 {
        margin-top: .5rem!important
    }

    .mr-sm-2,.mx-sm-2 {
        margin-right: .5rem!important
    }

    .mb-sm-2,.my-sm-2 {
        margin-bottom: .5rem!important
    }

    .ml-sm-2,.mx-sm-2 {
        margin-left: .5rem!important
    }

    .m-sm-3 {
        margin: 1rem!important
    }

    .mt-sm-3,.my-sm-3 {
        margin-top: 1rem!important
    }

    .mr-sm-3,.mx-sm-3 {
        margin-right: 1rem!important
    }

    .mb-sm-3,.my-sm-3 {
        margin-bottom: 1rem!important
    }

    .ml-sm-3,.mx-sm-3 {
        margin-left: 1rem!important
    }

    .m-sm-4 {
        margin: 1.5rem!important
    }

    .mt-sm-4,.my-sm-4 {
        margin-top: 1.5rem!important
    }

    .mr-sm-4,.mx-sm-4 {
        margin-right: 1.5rem!important
    }

    .mb-sm-4,.my-sm-4 {
        margin-bottom: 1.5rem!important
    }

    .ml-sm-4,.mx-sm-4 {
        margin-left: 1.5rem!important
    }

    .m-sm-5 {
        margin: 3rem!important
    }

    .mt-sm-5,.my-sm-5 {
        margin-top: 3rem!important
    }

    .mr-sm-5,.mx-sm-5 {
        margin-right: 3rem!important
    }

    .mb-sm-5,.my-sm-5 {
        margin-bottom: 3rem!important
    }

    .ml-sm-5,.mx-sm-5 {
        margin-left: 3rem!important
    }

    .p-sm-0 {
        padding: 0!important
    }

    .pt-sm-0,.py-sm-0 {
        padding-top: 0!important
    }

    .pr-sm-0,.px-sm-0 {
        padding-right: 0!important
    }

    .pb-sm-0,.py-sm-0 {
        padding-bottom: 0!important
    }

    .pl-sm-0,.px-sm-0 {
        padding-left: 0!important
    }

    .p-sm-1 {
        padding: .25rem!important
    }

    .pt-sm-1,.py-sm-1 {
        padding-top: .25rem!important
    }

    .pr-sm-1,.px-sm-1 {
        padding-right: .25rem!important
    }

    .pb-sm-1,.py-sm-1 {
        padding-bottom: .25rem!important
    }

    .pl-sm-1,.px-sm-1 {
        padding-left: .25rem!important
    }

    .p-sm-2 {
        padding: .5rem!important
    }

    .pt-sm-2,.py-sm-2 {
        padding-top: .5rem!important
    }

    .pr-sm-2,.px-sm-2 {
        padding-right: .5rem!important
    }

    .pb-sm-2,.py-sm-2 {
        padding-bottom: .5rem!important
    }

    .pl-sm-2,.px-sm-2 {
        padding-left: .5rem!important
    }

    .p-sm-3 {
        padding: 1rem!important
    }

    .pt-sm-3,.py-sm-3 {
        padding-top: 1rem!important
    }

    .pr-sm-3,.px-sm-3 {
        padding-right: 1rem!important
    }

    .pb-sm-3,.py-sm-3 {
        padding-bottom: 1rem!important
    }

    .pl-sm-3,.px-sm-3 {
        padding-left: 1rem!important
    }

    .p-sm-4 {
        padding: 1.5rem!important
    }

    .pt-sm-4,.py-sm-4 {
        padding-top: 1.5rem!important
    }

    .pr-sm-4,.px-sm-4 {
        padding-right: 1.5rem!important
    }

    .pb-sm-4,.py-sm-4 {
        padding-bottom: 1.5rem!important
    }

    .pl-sm-4,.px-sm-4 {
        padding-left: 1.5rem!important
    }

    .p-sm-5 {
        padding: 3rem!important
    }

    .pt-sm-5,.py-sm-5 {
        padding-top: 3rem!important
    }

    .pr-sm-5,.px-sm-5 {
        padding-right: 3rem!important
    }

    .pb-sm-5,.py-sm-5 {
        padding-bottom: 3rem!important
    }

    .pl-sm-5,.px-sm-5 {
        padding-left: 3rem!important
    }

    .m-sm-n1 {
        margin: -.25rem!important
    }

    .mt-sm-n1,.my-sm-n1 {
        margin-top: -.25rem!important
    }

    .mr-sm-n1,.mx-sm-n1 {
        margin-right: -.25rem!important
    }

    .mb-sm-n1,.my-sm-n1 {
        margin-bottom: -.25rem!important
    }

    .ml-sm-n1,.mx-sm-n1 {
        margin-left: -.25rem!important
    }

    .m-sm-n2 {
        margin: -.5rem!important
    }

    .mt-sm-n2,.my-sm-n2 {
        margin-top: -.5rem!important
    }

    .mr-sm-n2,.mx-sm-n2 {
        margin-right: -.5rem!important
    }

    .mb-sm-n2,.my-sm-n2 {
        margin-bottom: -.5rem!important
    }

    .ml-sm-n2,.mx-sm-n2 {
        margin-left: -.5rem!important
    }

    .m-sm-n3 {
        margin: -1rem!important
    }

    .mt-sm-n3,.my-sm-n3 {
        margin-top: -1rem!important
    }

    .mr-sm-n3,.mx-sm-n3 {
        margin-right: -1rem!important
    }

    .mb-sm-n3,.my-sm-n3 {
        margin-bottom: -1rem!important
    }

    .ml-sm-n3,.mx-sm-n3 {
        margin-left: -1rem!important
    }

    .m-sm-n4 {
        margin: -1.5rem!important
    }

    .mt-sm-n4,.my-sm-n4 {
        margin-top: -1.5rem!important
    }

    .mr-sm-n4,.mx-sm-n4 {
        margin-right: -1.5rem!important
    }

    .mb-sm-n4,.my-sm-n4 {
        margin-bottom: -1.5rem!important
    }

    .ml-sm-n4,.mx-sm-n4 {
        margin-left: -1.5rem!important
    }

    .m-sm-n5 {
        margin: -3rem!important
    }

    .mt-sm-n5,.my-sm-n5 {
        margin-top: -3rem!important
    }

    .mr-sm-n5,.mx-sm-n5 {
        margin-right: -3rem!important
    }

    .mb-sm-n5,.my-sm-n5 {
        margin-bottom: -3rem!important
    }

    .ml-sm-n5,.mx-sm-n5 {
        margin-left: -3rem!important
    }

    .m-sm-auto {
        margin: auto!important
    }

    .mt-sm-auto,.my-sm-auto {
        margin-top: auto!important
    }

    .mr-sm-auto,.mx-sm-auto {
        margin-right: auto!important
    }

    .mb-sm-auto,.my-sm-auto {
        margin-bottom: auto!important
    }

    .ml-sm-auto,.mx-sm-auto {
        margin-left: auto!important
    }
}

@media (min-width: 768px) {
    .m-md-0 {
        margin:0!important
    }

    .mt-md-0,.my-md-0 {
        margin-top: 0!important
    }

    .mr-md-0,.mx-md-0 {
        margin-right: 0!important
    }

    .mb-md-0,.my-md-0 {
        margin-bottom: 0!important
    }

    .ml-md-0,.mx-md-0 {
        margin-left: 0!important
    }

    .m-md-1 {
        margin: .25rem!important
    }

    .mt-md-1,.my-md-1 {
        margin-top: .25rem!important
    }

    .mr-md-1,.mx-md-1 {
        margin-right: .25rem!important
    }

    .mb-md-1,.my-md-1 {
        margin-bottom: .25rem!important
    }

    .ml-md-1,.mx-md-1 {
        margin-left: .25rem!important
    }

    .m-md-2 {
        margin: .5rem!important
    }

    .mt-md-2,.my-md-2 {
        margin-top: .5rem!important
    }

    .mr-md-2,.mx-md-2 {
        margin-right: .5rem!important
    }

    .mb-md-2,.my-md-2 {
        margin-bottom: .5rem!important
    }

    .ml-md-2,.mx-md-2 {
        margin-left: .5rem!important
    }

    .m-md-3 {
        margin: 1rem!important
    }

    .mt-md-3,.my-md-3 {
        margin-top: 1rem!important
    }

    .mr-md-3,.mx-md-3 {
        margin-right: 1rem!important
    }

    .mb-md-3,.my-md-3 {
        margin-bottom: 1rem!important
    }

    .ml-md-3,.mx-md-3 {
        margin-left: 1rem!important
    }

    .m-md-4 {
        margin: 1.5rem!important
    }

    .mt-md-4,.my-md-4 {
        margin-top: 1.5rem!important
    }

    .mr-md-4,.mx-md-4 {
        margin-right: 1.5rem!important
    }

    .mb-md-4,.my-md-4 {
        margin-bottom: 1.5rem!important
    }

    .ml-md-4,.mx-md-4 {
        margin-left: 1.5rem!important
    }

    .m-md-5 {
        margin: 3rem!important
    }

    .mt-md-5,.my-md-5 {
        margin-top: 3rem!important
    }

    .mr-md-5,.mx-md-5 {
        margin-right: 3rem!important
    }

    .mb-md-5,.my-md-5 {
        margin-bottom: 3rem!important
    }

    .ml-md-5,.mx-md-5 {
        margin-left: 3rem!important
    }

    .p-md-0 {
        padding: 0!important
    }

    .pt-md-0,.py-md-0 {
        padding-top: 0!important
    }

    .pr-md-0,.px-md-0 {
        padding-right: 0!important
    }

    .pb-md-0,.py-md-0 {
        padding-bottom: 0!important
    }

    .pl-md-0,.px-md-0 {
        padding-left: 0!important
    }

    .p-md-1 {
        padding: .25rem!important
    }

    .pt-md-1,.py-md-1 {
        padding-top: .25rem!important
    }

    .pr-md-1,.px-md-1 {
        padding-right: .25rem!important
    }

    .pb-md-1,.py-md-1 {
        padding-bottom: .25rem!important
    }

    .pl-md-1,.px-md-1 {
        padding-left: .25rem!important
    }

    .p-md-2 {
        padding: .5rem!important
    }

    .pt-md-2,.py-md-2 {
        padding-top: .5rem!important
    }

    .pr-md-2,.px-md-2 {
        padding-right: .5rem!important
    }

    .pb-md-2,.py-md-2 {
        padding-bottom: .5rem!important
    }

    .pl-md-2,.px-md-2 {
        padding-left: .5rem!important
    }

    .p-md-3 {
        padding: 1rem!important
    }

    .pt-md-3,.py-md-3 {
        padding-top: 1rem!important
    }

    .pr-md-3,.px-md-3 {
        padding-right: 1rem!important
    }

    .pb-md-3,.py-md-3 {
        padding-bottom: 1rem!important
    }

    .pl-md-3,.px-md-3 {
        padding-left: 1rem!important
    }

    .p-md-4 {
        padding: 1.5rem!important
    }

    .pt-md-4,.py-md-4 {
        padding-top: 1.5rem!important
    }

    .pr-md-4,.px-md-4 {
        padding-right: 1.5rem!important
    }

    .pb-md-4,.py-md-4 {
        padding-bottom: 1.5rem!important
    }

    .pl-md-4,.px-md-4 {
        padding-left: 1.5rem!important
    }

    .p-md-5 {
        padding: 3rem!important
    }

    .pt-md-5,.py-md-5 {
        padding-top: 3rem!important
    }

    .pr-md-5,.px-md-5 {
        padding-right: 3rem!important
    }

    .pb-md-5,.py-md-5 {
        padding-bottom: 3rem!important
    }

    .pl-md-5,.px-md-5 {
        padding-left: 3rem!important
    }

    .m-md-n1 {
        margin: -.25rem!important
    }

    .mt-md-n1,.my-md-n1 {
        margin-top: -.25rem!important
    }

    .mr-md-n1,.mx-md-n1 {
        margin-right: -.25rem!important
    }

    .mb-md-n1,.my-md-n1 {
        margin-bottom: -.25rem!important
    }

    .ml-md-n1,.mx-md-n1 {
        margin-left: -.25rem!important
    }

    .m-md-n2 {
        margin: -.5rem!important
    }

    .mt-md-n2,.my-md-n2 {
        margin-top: -.5rem!important
    }

    .mr-md-n2,.mx-md-n2 {
        margin-right: -.5rem!important
    }

    .mb-md-n2,.my-md-n2 {
        margin-bottom: -.5rem!important
    }

    .ml-md-n2,.mx-md-n2 {
        margin-left: -.5rem!important
    }

    .m-md-n3 {
        margin: -1rem!important
    }

    .mt-md-n3,.my-md-n3 {
        margin-top: -1rem!important
    }

    .mr-md-n3,.mx-md-n3 {
        margin-right: -1rem!important
    }

    .mb-md-n3,.my-md-n3 {
        margin-bottom: -1rem!important
    }

    .ml-md-n3,.mx-md-n3 {
        margin-left: -1rem!important
    }

    .m-md-n4 {
        margin: -1.5rem!important
    }

    .mt-md-n4,.my-md-n4 {
        margin-top: -1.5rem!important
    }

    .mr-md-n4,.mx-md-n4 {
        margin-right: -1.5rem!important
    }

    .mb-md-n4,.my-md-n4 {
        margin-bottom: -1.5rem!important
    }

    .ml-md-n4,.mx-md-n4 {
        margin-left: -1.5rem!important
    }

    .m-md-n5 {
        margin: -3rem!important
    }

    .mt-md-n5,.my-md-n5 {
        margin-top: -3rem!important
    }

    .mr-md-n5,.mx-md-n5 {
        margin-right: -3rem!important
    }

    .mb-md-n5,.my-md-n5 {
        margin-bottom: -3rem!important
    }

    .ml-md-n5,.mx-md-n5 {
        margin-left: -3rem!important
    }

    .m-md-auto {
        margin: auto!important
    }

    .mt-md-auto,.my-md-auto {
        margin-top: auto!important
    }

    .mr-md-auto,.mx-md-auto {
        margin-right: auto!important
    }

    .mb-md-auto,.my-md-auto {
        margin-bottom: auto!important
    }

    .ml-md-auto,.mx-md-auto {
        margin-left: auto!important
    }
}

@media (min-width: 992px) {
    .m-lg-0 {
        margin:0!important
    }

    .mt-lg-0,.my-lg-0 {
        margin-top: 0!important
    }

    .mr-lg-0,.mx-lg-0 {
        margin-right: 0!important
    }

    .mb-lg-0,.my-lg-0 {
        margin-bottom: 0!important
    }

    .ml-lg-0,.mx-lg-0 {
        margin-left: 0!important
    }

    .m-lg-1 {
        margin: .25rem!important
    }

    .mt-lg-1,.my-lg-1 {
        margin-top: .25rem!important
    }

    .mr-lg-1,.mx-lg-1 {
        margin-right: .25rem!important
    }

    .mb-lg-1,.my-lg-1 {
        margin-bottom: .25rem!important
    }

    .ml-lg-1,.mx-lg-1 {
        margin-left: .25rem!important
    }

    .m-lg-2 {
        margin: .5rem!important
    }

    .mt-lg-2,.my-lg-2 {
        margin-top: .5rem!important
    }

    .mr-lg-2,.mx-lg-2 {
        margin-right: .5rem!important
    }

    .mb-lg-2,.my-lg-2 {
        margin-bottom: .5rem!important
    }

    .ml-lg-2,.mx-lg-2 {
        margin-left: .5rem!important
    }

    .m-lg-3 {
        margin: 1rem!important
    }

    .mt-lg-3,.my-lg-3 {
        margin-top: 1rem!important
    }

    .mr-lg-3,.mx-lg-3 {
        margin-right: 1rem!important
    }

    .mb-lg-3,.my-lg-3 {
        margin-bottom: 1rem!important
    }

    .ml-lg-3,.mx-lg-3 {
        margin-left: 1rem!important
    }

    .m-lg-4 {
        margin: 1.5rem!important
    }

    .mt-lg-4,.my-lg-4 {
        margin-top: 1.5rem!important
    }

    .mr-lg-4,.mx-lg-4 {
        margin-right: 1.5rem!important
    }

    .mb-lg-4,.my-lg-4 {
        margin-bottom: 1.5rem!important
    }

    .ml-lg-4,.mx-lg-4 {
        margin-left: 1.5rem!important
    }

    .m-lg-5 {
        margin: 3rem!important
    }

    .mt-lg-5,.my-lg-5 {
        margin-top: 3rem!important
    }

    .mr-lg-5,.mx-lg-5 {
        margin-right: 3rem!important
    }

    .mb-lg-5,.my-lg-5 {
        margin-bottom: 3rem!important
    }

    .ml-lg-5,.mx-lg-5 {
        margin-left: 3rem!important
    }

    .p-lg-0 {
        padding: 0!important
    }

    .pt-lg-0,.py-lg-0 {
        padding-top: 0!important
    }

    .pr-lg-0,.px-lg-0 {
        padding-right: 0!important
    }

    .pb-lg-0,.py-lg-0 {
        padding-bottom: 0!important
    }

    .pl-lg-0,.px-lg-0 {
        padding-left: 0!important
    }

    .p-lg-1 {
        padding: .25rem!important
    }

    .pt-lg-1,.py-lg-1 {
        padding-top: .25rem!important
    }

    .pr-lg-1,.px-lg-1 {
        padding-right: .25rem!important
    }

    .pb-lg-1,.py-lg-1 {
        padding-bottom: .25rem!important
    }

    .pl-lg-1,.px-lg-1 {
        padding-left: .25rem!important
    }

    .p-lg-2 {
        padding: .5rem!important
    }

    .pt-lg-2,.py-lg-2 {
        padding-top: .5rem!important
    }

    .pr-lg-2,.px-lg-2 {
        padding-right: .5rem!important
    }

    .pb-lg-2,.py-lg-2 {
        padding-bottom: .5rem!important
    }

    .pl-lg-2,.px-lg-2 {
        padding-left: .5rem!important
    }

    .p-lg-3 {
        padding: 1rem!important
    }

    .pt-lg-3,.py-lg-3 {
        padding-top: 1rem!important
    }

    .pr-lg-3,.px-lg-3 {
        padding-right: 1rem!important
    }

    .pb-lg-3,.py-lg-3 {
        padding-bottom: 1rem!important
    }

    .pl-lg-3,.px-lg-3 {
        padding-left: 1rem!important
    }

    .p-lg-4 {
        padding: 1.5rem!important
    }

    .pt-lg-4,.py-lg-4 {
        padding-top: 1.5rem!important
    }

    .pr-lg-4,.px-lg-4 {
        padding-right: 1.5rem!important
    }

    .pb-lg-4,.py-lg-4 {
        padding-bottom: 1.5rem!important
    }

    .pl-lg-4,.px-lg-4 {
        padding-left: 1.5rem!important
    }

    .p-lg-5 {
        padding: 3rem!important
    }

    .pt-lg-5,.py-lg-5 {
        padding-top: 3rem!important
    }

    .pr-lg-5,.px-lg-5 {
        padding-right: 3rem!important
    }

    .pb-lg-5,.py-lg-5 {
        padding-bottom: 3rem!important
    }

    .pl-lg-5,.px-lg-5 {
        padding-left: 3rem!important
    }

    .m-lg-n1 {
        margin: -.25rem!important
    }

    .mt-lg-n1,.my-lg-n1 {
        margin-top: -.25rem!important
    }

    .mr-lg-n1,.mx-lg-n1 {
        margin-right: -.25rem!important
    }

    .mb-lg-n1,.my-lg-n1 {
        margin-bottom: -.25rem!important
    }

    .ml-lg-n1,.mx-lg-n1 {
        margin-left: -.25rem!important
    }

    .m-lg-n2 {
        margin: -.5rem!important
    }

    .mt-lg-n2,.my-lg-n2 {
        margin-top: -.5rem!important
    }

    .mr-lg-n2,.mx-lg-n2 {
        margin-right: -.5rem!important
    }

    .mb-lg-n2,.my-lg-n2 {
        margin-bottom: -.5rem!important
    }

    .ml-lg-n2,.mx-lg-n2 {
        margin-left: -.5rem!important
    }

    .m-lg-n3 {
        margin: -1rem!important
    }

    .mt-lg-n3,.my-lg-n3 {
        margin-top: -1rem!important
    }

    .mr-lg-n3,.mx-lg-n3 {
        margin-right: -1rem!important
    }

    .mb-lg-n3,.my-lg-n3 {
        margin-bottom: -1rem!important
    }

    .ml-lg-n3,.mx-lg-n3 {
        margin-left: -1rem!important
    }

    .m-lg-n4 {
        margin: -1.5rem!important
    }

    .mt-lg-n4,.my-lg-n4 {
        margin-top: -1.5rem!important
    }

    .mr-lg-n4,.mx-lg-n4 {
        margin-right: -1.5rem!important
    }

    .mb-lg-n4,.my-lg-n4 {
        margin-bottom: -1.5rem!important
    }

    .ml-lg-n4,.mx-lg-n4 {
        margin-left: -1.5rem!important
    }

    .m-lg-n5 {
        margin: -3rem!important
    }

    .mt-lg-n5,.my-lg-n5 {
        margin-top: -3rem!important
    }

    .mr-lg-n5,.mx-lg-n5 {
        margin-right: -3rem!important
    }

    .mb-lg-n5,.my-lg-n5 {
        margin-bottom: -3rem!important
    }

    .ml-lg-n5,.mx-lg-n5 {
        margin-left: -3rem!important
    }

    .m-lg-auto {
        margin: auto!important
    }

    .mt-lg-auto,.my-lg-auto {
        margin-top: auto!important
    }

    .mr-lg-auto,.mx-lg-auto {
        margin-right: auto!important
    }

    .mb-lg-auto,.my-lg-auto {
        margin-bottom: auto!important
    }

    .ml-lg-auto,.mx-lg-auto {
        margin-left: auto!important
    }
}

@media (min-width: 1200px) {
    .m-xl-0 {
        margin:0!important
    }

    .mt-xl-0,.my-xl-0 {
        margin-top: 0!important
    }

    .mr-xl-0,.mx-xl-0 {
        margin-right: 0!important
    }

    .mb-xl-0,.my-xl-0 {
        margin-bottom: 0!important
    }

    .ml-xl-0,.mx-xl-0 {
        margin-left: 0!important
    }

    .m-xl-1 {
        margin: .25rem!important
    }

    .mt-xl-1,.my-xl-1 {
        margin-top: .25rem!important
    }

    .mr-xl-1,.mx-xl-1 {
        margin-right: .25rem!important
    }

    .mb-xl-1,.my-xl-1 {
        margin-bottom: .25rem!important
    }

    .ml-xl-1,.mx-xl-1 {
        margin-left: .25rem!important
    }

    .m-xl-2 {
        margin: .5rem!important
    }

    .mt-xl-2,.my-xl-2 {
        margin-top: .5rem!important
    }

    .mr-xl-2,.mx-xl-2 {
        margin-right: .5rem!important
    }

    .mb-xl-2,.my-xl-2 {
        margin-bottom: .5rem!important
    }

    .ml-xl-2,.mx-xl-2 {
        margin-left: .5rem!important
    }

    .m-xl-3 {
        margin: 1rem!important
    }

    .mt-xl-3,.my-xl-3 {
        margin-top: 1rem!important
    }

    .mr-xl-3,.mx-xl-3 {
        margin-right: 1rem!important
    }

    .mb-xl-3,.my-xl-3 {
        margin-bottom: 1rem!important
    }

    .ml-xl-3,.mx-xl-3 {
        margin-left: 1rem!important
    }

    .m-xl-4 {
        margin: 1.5rem!important
    }

    .mt-xl-4,.my-xl-4 {
        margin-top: 1.5rem!important
    }

    .mr-xl-4,.mx-xl-4 {
        margin-right: 1.5rem!important
    }

    .mb-xl-4,.my-xl-4 {
        margin-bottom: 1.5rem!important
    }

    .ml-xl-4,.mx-xl-4 {
        margin-left: 1.5rem!important
    }

    .m-xl-5 {
        margin: 3rem!important
    }

    .mt-xl-5,.my-xl-5 {
        margin-top: 3rem!important
    }

    .mr-xl-5,.mx-xl-5 {
        margin-right: 3rem!important
    }

    .mb-xl-5,.my-xl-5 {
        margin-bottom: 3rem!important
    }

    .ml-xl-5,.mx-xl-5 {
        margin-left: 3rem!important
    }

    .p-xl-0 {
        padding: 0!important
    }

    .pt-xl-0,.py-xl-0 {
        padding-top: 0!important
    }

    .pr-xl-0,.px-xl-0 {
        padding-right: 0!important
    }

    .pb-xl-0,.py-xl-0 {
        padding-bottom: 0!important
    }

    .pl-xl-0,.px-xl-0 {
        padding-left: 0!important
    }

    .p-xl-1 {
        padding: .25rem!important
    }

    .pt-xl-1,.py-xl-1 {
        padding-top: .25rem!important
    }

    .pr-xl-1,.px-xl-1 {
        padding-right: .25rem!important
    }

    .pb-xl-1,.py-xl-1 {
        padding-bottom: .25rem!important
    }

    .pl-xl-1,.px-xl-1 {
        padding-left: .25rem!important
    }

    .p-xl-2 {
        padding: .5rem!important
    }

    .pt-xl-2,.py-xl-2 {
        padding-top: .5rem!important
    }

    .pr-xl-2,.px-xl-2 {
        padding-right: .5rem!important
    }

    .pb-xl-2,.py-xl-2 {
        padding-bottom: .5rem!important
    }

    .pl-xl-2,.px-xl-2 {
        padding-left: .5rem!important
    }

    .p-xl-3 {
        padding: 1rem!important
    }

    .pt-xl-3,.py-xl-3 {
        padding-top: 1rem!important
    }

    .pr-xl-3,.px-xl-3 {
        padding-right: 1rem!important
    }

    .pb-xl-3,.py-xl-3 {
        padding-bottom: 1rem!important
    }

    .pl-xl-3,.px-xl-3 {
        padding-left: 1rem!important
    }

    .p-xl-4 {
        padding: 1.5rem!important
    }

    .pt-xl-4,.py-xl-4 {
        padding-top: 1.5rem!important
    }

    .pr-xl-4,.px-xl-4 {
        padding-right: 1.5rem!important
    }

    .pb-xl-4,.py-xl-4 {
        padding-bottom: 1.5rem!important
    }

    .pl-xl-4,.px-xl-4 {
        padding-left: 1.5rem!important
    }

    .p-xl-5 {
        padding: 3rem!important
    }

    .pt-xl-5,.py-xl-5 {
        padding-top: 3rem!important
    }

    .pr-xl-5,.px-xl-5 {
        padding-right: 3rem!important
    }

    .pb-xl-5,.py-xl-5 {
        padding-bottom: 3rem!important
    }

    .pl-xl-5,.px-xl-5 {
        padding-left: 3rem!important
    }

    .m-xl-n1 {
        margin: -.25rem!important
    }

    .mt-xl-n1,.my-xl-n1 {
        margin-top: -.25rem!important
    }

    .mr-xl-n1,.mx-xl-n1 {
        margin-right: -.25rem!important
    }

    .mb-xl-n1,.my-xl-n1 {
        margin-bottom: -.25rem!important
    }

    .ml-xl-n1,.mx-xl-n1 {
        margin-left: -.25rem!important
    }

    .m-xl-n2 {
        margin: -.5rem!important
    }

    .mt-xl-n2,.my-xl-n2 {
        margin-top: -.5rem!important
    }

    .mr-xl-n2,.mx-xl-n2 {
        margin-right: -.5rem!important
    }

    .mb-xl-n2,.my-xl-n2 {
        margin-bottom: -.5rem!important
    }

    .ml-xl-n2,.mx-xl-n2 {
        margin-left: -.5rem!important
    }

    .m-xl-n3 {
        margin: -1rem!important
    }

    .mt-xl-n3,.my-xl-n3 {
        margin-top: -1rem!important
    }

    .mr-xl-n3,.mx-xl-n3 {
        margin-right: -1rem!important
    }

    .mb-xl-n3,.my-xl-n3 {
        margin-bottom: -1rem!important
    }

    .ml-xl-n3,.mx-xl-n3 {
        margin-left: -1rem!important
    }

    .m-xl-n4 {
        margin: -1.5rem!important
    }

    .mt-xl-n4,.my-xl-n4 {
        margin-top: -1.5rem!important
    }

    .mr-xl-n4,.mx-xl-n4 {
        margin-right: -1.5rem!important
    }

    .mb-xl-n4,.my-xl-n4 {
        margin-bottom: -1.5rem!important
    }

    .ml-xl-n4,.mx-xl-n4 {
        margin-left: -1.5rem!important
    }

    .m-xl-n5 {
        margin: -3rem!important
    }

    .mt-xl-n5,.my-xl-n5 {
        margin-top: -3rem!important
    }

    .mr-xl-n5,.mx-xl-n5 {
        margin-right: -3rem!important
    }

    .mb-xl-n5,.my-xl-n5 {
        margin-bottom: -3rem!important
    }

    .ml-xl-n5,.mx-xl-n5 {
        margin-left: -3rem!important
    }

    .m-xl-auto {
        margin: auto!important
    }

    .mt-xl-auto,.my-xl-auto {
        margin-top: auto!important
    }

    .mr-xl-auto,.mx-xl-auto {
        margin-right: auto!important
    }

    .mb-xl-auto,.my-xl-auto {
        margin-bottom: auto!important
    }

    .ml-xl-auto,.mx-xl-auto {
        margin-left: auto!important
    }
}

.stretched-link::after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1;
    pointer-events: auto;
    content: "";
    background-color: rgba(0,0,0,0)
}

.text-monospace {
    font-family: SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace!important
}

.text-justify {
    text-align: justify!important
}

.text-wrap {
    white-space: normal!important
}

.text-nowrap {
    white-space: nowrap!important
}

.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap
}

.text-left {
    text-align: left!important
}

.text-right {
    text-align: right!important
}

.text-center {
    text-align: center!important
}

@media (min-width: 576px) {
    .text-sm-left {
        text-align:left!important
    }

    .text-sm-right {
        text-align: right!important
    }

    .text-sm-center {
        text-align: center!important
    }
}

@media (min-width: 768px) {
    .text-md-left {
        text-align:left!important
    }

    .text-md-right {
        text-align: right!important
    }

    .text-md-center {
        text-align: center!important
    }
}

@media (min-width: 992px) {
    .text-lg-left {
        text-align:left!important
    }

    .text-lg-right {
        text-align: right!important
    }

    .text-lg-center {
        text-align: center!important
    }
}

@media (min-width: 1200px) {
    .text-xl-left {
        text-align:left!important
    }

    .text-xl-right {
        text-align: right!important
    }

    .text-xl-center {
        text-align: center!important
    }
}

.text-lowercase {
    text-transform: lowercase!important
}

.text-uppercase {
    text-transform: uppercase!important
}

.text-capitalize {
    text-transform: capitalize!important
}

.font-weight-light {
    font-weight: 300!important
}

.font-weight-lighter {
    font-weight: lighter!important
}

.font-weight-normal {
    font-weight: 400!important
}

.font-weight-bold {
    font-weight: 700!important
}

.font-weight-bolder {
    font-weight: bolder!important
}

.font-italic {
    font-style: italic!important
}

.text-white {
    color: #fff!important
}

.text-primary {
    color: #007bff!important
}

a.text-primary:focus,a.text-primary:hover {
    color: #0056b3!important
}

.text-secondary {
    color: #6c757d!important
}

a.text-secondary:focus,a.text-secondary:hover {
    color: #494f54!important
}

.text-success {
    color: #28a745!important
}

a.text-success:focus,a.text-success:hover {
    color: #19692c!important
}

.text-info {
    color: #17a2b8!important
}

a.text-info:focus,a.text-info:hover {
    color: #0f6674!important
}

.text-warning {
    color: #ffc107!important
}

a.text-warning:focus,a.text-warning:hover {
    color: #ba8b00!important
}

.text-danger {
    color: #dc3545!important
}

a.text-danger:focus,a.text-danger:hover {
    color: #a71d2a!important
}

.text-light {
    color: #f8f9fa!important
}

a.text-light:focus,a.text-light:hover {
    color: #cbd3da!important
}

.text-dark {
    color: #343a40!important
}

a.text-dark:focus,a.text-dark:hover {
    color: #121416!important
}

.text-body {
    color: #212529!important
}

.text-muted {
    color: #6c757d!important
}

.text-black-50 {
    color: rgba(0,0,0,.5)!important
}

.text-white-50 {
    color: rgba(255,255,255,.5)!important
}

.text-hide {
    font: 0/0 a;
    color: transparent;
    text-shadow: none;
    background-color: transparent;
    border: 0
}

.text-decoration-none {
    text-decoration: none!important
}

.text-break {
    word-break: break-word!important;
    word-wrap: break-word!important
}

.text-reset {
    color: inherit!important
}

.visible {
    visibility: visible!important
}

.invisible {
    visibility: hidden!important
}

@media print {
    *,::after,::before {
        text-shadow: none!important;
        box-shadow: none!important
    }

    a:not(.btn) {
        text-decoration: underline
    }

    abbr[title]::after {
        content: " (" attr(title) ")"
    }

    pre {
        white-space: pre-wrap!important
    }

    blockquote,pre {
        border: 1px solid #adb5bd;
        page-break-inside: avoid
    }

    img,tr {
        page-break-inside: avoid
    }

    h2,h3,p {
        orphans: 3;
        widows: 3
    }

    h2,h3 {
        page-break-after: avoid
    }

    @page {
        size: a3
    }

    body {
        min-width: 992px!important
    }

    .container {
        min-width: 992px!important
    }

    .navbar {
        display: none
    }

    .badge {
        border: 1px solid #000
    }

    .table {
        border-collapse: collapse!important
    }

    .table td,.table th {
        background-color: #fff!important
    }

    .table-bordered td,.table-bordered th {
        border: 1px solid #dee2e6!important
    }

    .table-dark {
        color: inherit
    }

    .table-dark tbody+tbody,.table-dark td,.table-dark th,.table-dark thead th {
        border-color: #dee2e6
    }

    .table .thead-dark th {
        color: inherit;
        border-color: #dee2e6
    }
}

.fa,.fab,.fad,.fal,.far,.fas {
    -moz-osx-font-smoothing: grayscale;
    -webkit-font-smoothing: antialiased;
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    line-height: 1
}

.fa-lg {
    font-size: 1.33333em;
    line-height: .75em;
    vertical-align: -.0667em
}

.fa-xs {
    font-size: .75em
}

.fa-sm {
    font-size: .875em
}

.fa-1x {
    font-size: 1em
}

.fa-2x {
    font-size: 2em
}

.fa-3x {
    font-size: 3em
}

.fa-4x {
    font-size: 4em
}

.fa-5x {
    font-size: 5em
}

.fa-6x {
    font-size: 6em
}

.fa-7x {
    font-size: 7em
}

.fa-8x {
    font-size: 8em
}

.fa-9x {
    font-size: 9em
}

.fa-10x {
    font-size: 10em
}

.fa-fw {
    text-align: center;
    width: 1.25em
}

.fa-ul {
    list-style-type: none;
    margin-left: 2.5em;
    padding-left: 0
}

.fa-ul>li {
    position: relative
}

.fa-li {
    left: -2em;
    position: absolute;
    text-align: center;
    width: 2em;
    line-height: inherit
}

.fa-border {
    border: .08em solid #eee;
    border-radius: .1em;
    padding: .2em .25em .15em
}

.fa-pull-left {
    float: left
}

.fa-pull-right {
    float: right
}

.fa.fa-pull-left,.fab.fa-pull-left,.fal.fa-pull-left,.far.fa-pull-left,.fas.fa-pull-left {
    margin-right: .3em
}

.fa.fa-pull-right,.fab.fa-pull-right,.fal.fa-pull-right,.far.fa-pull-right,.fas.fa-pull-right {
    margin-left: .3em
}

.fa-spin {
    -webkit-animation: fa-spin 2s linear infinite;
    animation: fa-spin 2s linear infinite
}

.fa-pulse {
    -webkit-animation: fa-spin 1s steps(8) infinite;
    animation: fa-spin 1s steps(8) infinite
}

@-webkit-keyframes fa-spin {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg)
    }

    to {
        -webkit-transform: rotate(1turn);
        transform: rotate(1turn)
    }
}

@keyframes fa-spin {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg)
    }

    to {
        -webkit-transform: rotate(1turn);
        transform: rotate(1turn)
    }
}

.fa-rotate-90 {
    -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=1)";
    -webkit-transform: rotate(90deg);
    transform: rotate(90deg)
}

.fa-rotate-180 {
    -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=2)";
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg)
}

.fa-rotate-270 {
    -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=3)";
    -webkit-transform: rotate(270deg);
    transform: rotate(270deg)
}

.fa-flip-horizontal {
    -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0, mirror=1)";
    -webkit-transform: scaleX(-1);
    transform: scaleX(-1)
}

.fa-flip-vertical {
    -webkit-transform: scaleY(-1);
    transform: scaleY(-1)
}

.fa-flip-both,.fa-flip-horizontal.fa-flip-vertical,.fa-flip-vertical {
    -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=2, mirror=1)"
}

.fa-flip-both,.fa-flip-horizontal.fa-flip-vertical {
    -webkit-transform: scale(-1);
    transform: scale(-1)
}

:root .fa-flip-both,:root .fa-flip-horizontal,:root .fa-flip-vertical,:root .fa-rotate-90,:root .fa-rotate-180,:root .fa-rotate-270 {
    -webkit-filter: none;
    filter: none
}

.fa-stack {
    display: inline-block;
    height: 2em;
    line-height: 2em;
    position: relative;
    vertical-align: middle;
    width: 2.5em
}

.fa-stack-1x,.fa-stack-2x {
    left: 0;
    position: absolute;
    text-align: center;
    width: 100%
}

.fa-stack-1x {
    line-height: inherit
}

.fa-stack-2x {
    font-size: 2em
}

.fa-inverse {
    color: #fff
}

.fa-500px:before {
    content: "\f26e"
}

.fa-accessible-icon:before {
    content: "\f368"
}

.fa-accusoft:before {
    content: "\f369"
}

.fa-acquisitions-incorporated:before {
    content: "\f6af"
}

.fa-ad:before {
    content: "\f641"
}

.fa-address-book:before {
    content: "\f2b9"
}

.fa-address-card:before {
    content: "\f2bb"
}

.fa-adjust:before {
    content: "\f042"
}

.fa-adn:before {
    content: "\f170"
}

.fa-adversal:before {
    content: "\f36a"
}

.fa-affiliatetheme:before {
    content: "\f36b"
}

.fa-air-freshener:before {
    content: "\f5d0"
}

.fa-airbnb:before {
    content: "\f834"
}

.fa-algolia:before {
    content: "\f36c"
}

.fa-align-center:before {
    content: "\f037"
}

.fa-align-justify:before {
    content: "\f039"
}

.fa-align-left:before {
    content: "\f036"
}

.fa-align-right:before {
    content: "\f038"
}

.fa-alipay:before {
    content: "\f642"
}

.fa-allergies:before {
    content: "\f461"
}

.fa-amazon:before {
    content: "\f270"
}

.fa-amazon-pay:before {
    content: "\f42c"
}

.fa-ambulance:before {
    content: "\f0f9"
}

.fa-american-sign-language-interpreting:before {
    content: "\f2a3"
}

.fa-amilia:before {
    content: "\f36d"
}

.fa-anchor:before {
    content: "\f13d"
}

.fa-android:before {
    content: "\f17b"
}

.fa-angellist:before {
    content: "\f209"
}

.fa-angle-double-down:before {
    content: "\f103"
}

.fa-angle-double-left:before {
    content: "\f100"
}

.fa-angle-double-right:before {
    content: "\f101"
}

.fa-angle-double-up:before {
    content: "\f102"
}

.fa-angle-down:before {
    content: "\f107"
}

.fa-angle-left:before {
    content: "\f104"
}

.fa-angle-right:before {
    content: "\f105"
}

.fa-angle-up:before {
    content: "\f106"
}

.fa-angry:before {
    content: "\f556"
}

.fa-angrycreative:before {
    content: "\f36e"
}

.fa-angular:before {
    content: "\f420"
}

.fa-ankh:before {
    content: "\f644"
}

.fa-app-store:before {
    content: "\f36f"
}

.fa-app-store-ios:before {
    content: "\f370"
}

.fa-apper:before {
    content: "\f371"
}

.fa-apple:before {
    content: "\f179"
}

.fa-apple-alt:before {
    content: "\f5d1"
}

.fa-apple-pay:before {
    content: "\f415"
}

.fa-archive:before {
    content: "\f187"
}

.fa-archway:before {
    content: "\f557"
}

.fa-arrow-alt-circle-down:before {
    content: "\f358"
}

.fa-arrow-alt-circle-left:before {
    content: "\f359"
}

.fa-arrow-alt-circle-right:before {
    content: "\f35a"
}

.fa-arrow-alt-circle-up:before {
    content: "\f35b"
}

.fa-arrow-circle-down:before {
    content: "\f0ab"
}

.fa-arrow-circle-left:before {
    content: "\f0a8"
}

.fa-arrow-circle-right:before {
    content: "\f0a9"
}

.fa-arrow-circle-up:before {
    content: "\f0aa"
}

.fa-arrow-down:before {
    content: "\f063"
}

.fa-arrow-left:before {
    content: "\f060"
}

.fa-arrow-right:before {
    content: "\f061"
}

.fa-arrow-up:before {
    content: "\f062"
}

.fa-arrows-alt:before {
    content: "\f0b2"
}

.fa-arrows-alt-h:before {
    content: "\f337"
}

.fa-arrows-alt-v:before {
    content: "\f338"
}

.fa-artstation:before {
    content: "\f77a"
}

.fa-assistive-listening-systems:before {
    content: "\f2a2"
}

.fa-asterisk:before {
    content: "\f069"
}

.fa-asymmetrik:before {
    content: "\f372"
}

.fa-at:before {
    content: "\f1fa"
}

.fa-atlas:before {
    content: "\f558"
}

.fa-atlassian:before {
    content: "\f77b"
}

.fa-atom:before {
    content: "\f5d2"
}

.fa-audible:before {
    content: "\f373"
}

.fa-audio-description:before {
    content: "\f29e"
}

.fa-autoprefixer:before {
    content: "\f41c"
}

.fa-avianex:before {
    content: "\f374"
}

.fa-aviato:before {
    content: "\f421"
}

.fa-award:before {
    content: "\f559"
}

.fa-aws:before {
    content: "\f375"
}

.fa-baby:before {
    content: "\f77c"
}

.fa-baby-carriage:before {
    content: "\f77d"
}

.fa-backspace:before {
    content: "\f55a"
}

.fa-backward:before {
    content: "\f04a"
}

.fa-bacon:before {
    content: "\f7e5"
}

.fa-bacteria:before {
    content: "\e059"
}

.fa-bacterium:before {
    content: "\e05a"
}

.fa-bahai:before {
    content: "\f666"
}

.fa-balance-scale:before {
    content: "\f24e"
}

.fa-balance-scale-left:before {
    content: "\f515"
}

.fa-balance-scale-right:before {
    content: "\f516"
}

.fa-ban:before {
    content: "\f05e"
}

.fa-band-aid:before {
    content: "\f462"
}

.fa-bandcamp:before {
    content: "\f2d5"
}

.fa-barcode:before {
    content: "\f02a"
}

.fa-bars:before {
    content: "\f0c9"
}

.fa-baseball-ball:before {
    content: "\f433"
}

.fa-basketball-ball:before {
    content: "\f434"
}

.fa-bath:before {
    content: "\f2cd"
}

.fa-battery-empty:before {
    content: "\f244"
}

.fa-battery-full:before {
    content: "\f240"
}

.fa-battery-half:before {
    content: "\f242"
}

.fa-battery-quarter:before {
    content: "\f243"
}

.fa-battery-three-quarters:before {
    content: "\f241"
}

.fa-battle-net:before {
    content: "\f835"
}

.fa-bed:before {
    content: "\f236"
}

.fa-beer:before {
    content: "\f0fc"
}

.fa-behance:before {
    content: "\f1b4"
}

.fa-behance-square:before {
    content: "\f1b5"
}

.fa-bell:before {
    content: "\f0f3"
}

.fa-bell-slash:before {
    content: "\f1f6"
}

.fa-bezier-curve:before {
    content: "\f55b"
}

.fa-bible:before {
    content: "\f647"
}

.fa-bicycle:before {
    content: "\f206"
}

.fa-biking:before {
    content: "\f84a"
}

.fa-bimobject:before {
    content: "\f378"
}

.fa-binoculars:before {
    content: "\f1e5"
}

.fa-biohazard:before {
    content: "\f780"
}

.fa-birthday-cake:before {
    content: "\f1fd"
}

.fa-bitbucket:before {
    content: "\f171"
}

.fa-bitcoin:before {
    content: "\f379"
}

.fa-bity:before {
    content: "\f37a"
}

.fa-black-tie:before {
    content: "\f27e"
}

.fa-blackberry:before {
    content: "\f37b"
}

.fa-blender:before {
    content: "\f517"
}

.fa-blender-phone:before {
    content: "\f6b6"
}

.fa-blind:before {
    content: "\f29d"
}

.fa-blog:before {
    content: "\f781"
}

.fa-blogger:before {
    content: "\f37c"
}

.fa-blogger-b:before {
    content: "\f37d"
}

.fa-bluetooth:before {
    content: "\f293"
}

.fa-bluetooth-b:before {
    content: "\f294"
}

.fa-bold:before {
    content: "\f032"
}

.fa-bolt:before {
    content: "\f0e7"
}

.fa-bomb:before {
    content: "\f1e2"
}

.fa-bone:before {
    content: "\f5d7"
}

.fa-bong:before {
    content: "\f55c"
}

.fa-book:before {
    content: "\f02d"
}

.fa-book-dead:before {
    content: "\f6b7"
}

.fa-book-medical:before {
    content: "\f7e6"
}

.fa-book-open:before {
    content: "\f518"
}

.fa-book-reader:before {
    content: "\f5da"
}

.fa-bookmark:before {
    content: "\f02e"
}

.fa-bootstrap:before {
    content: "\f836"
}

.fa-border-all:before {
    content: "\f84c"
}

.fa-border-none:before {
    content: "\f850"
}

.fa-border-style:before {
    content: "\f853"
}

.fa-bowling-ball:before {
    content: "\f436"
}

.fa-box:before {
    content: "\f466"
}

.fa-box-open:before {
    content: "\f49e"
}

.fa-box-tissue:before {
    content: "\e05b"
}

.fa-boxes:before {
    content: "\f468"
}

.fa-braille:before {
    content: "\f2a1"
}

.fa-brain:before {
    content: "\f5dc"
}

.fa-bread-slice:before {
    content: "\f7ec"
}

.fa-briefcase:before {
    content: "\f0b1"
}

.fa-briefcase-medical:before {
    content: "\f469"
}

.fa-broadcast-tower:before {
    content: "\f519"
}

.fa-broom:before {
    content: "\f51a"
}

.fa-brush:before {
    content: "\f55d"
}

.fa-btc:before {
    content: "\f15a"
}

.fa-buffer:before {
    content: "\f837"
}

.fa-bug:before {
    content: "\f188"
}

.fa-building:before {
    content: "\f1ad"
}

.fa-bullhorn:before {
    content: "\f0a1"
}

.fa-bullseye:before {
    content: "\f140"
}

.fa-burn:before {
    content: "\f46a"
}

.fa-buromobelexperte:before {
    content: "\f37f"
}

.fa-bus:before {
    content: "\f207"
}

.fa-bus-alt:before {
    content: "\f55e"
}

.fa-business-time:before {
    content: "\f64a"
}

.fa-buy-n-large:before {
    content: "\f8a6"
}

.fa-buysellads:before {
    content: "\f20d"
}

.fa-calculator:before {
    content: "\f1ec"
}

.fa-calendar:before {
    content: "\f133"
}

.fa-calendar-alt:before {
    content: "\f073"
}

.fa-calendar-check:before {
    content: "\f274"
}

.fa-calendar-day:before {
    content: "\f783"
}

.fa-calendar-minus:before {
    content: "\f272"
}

.fa-calendar-plus:before {
    content: "\f271"
}

.fa-calendar-times:before {
    content: "\f273"
}

.fa-calendar-week:before {
    content: "\f784"
}

.fa-camera:before {
    content: "\f030"
}

.fa-camera-retro:before {
    content: "\f083"
}

.fa-campground:before {
    content: "\f6bb"
}

.fa-canadian-maple-leaf:before {
    content: "\f785"
}

.fa-candy-cane:before {
    content: "\f786"
}

.fa-cannabis:before {
    content: "\f55f"
}

.fa-capsules:before {
    content: "\f46b"
}

.fa-car:before {
    content: "\f1b9"
}

.fa-car-alt:before {
    content: "\f5de"
}

.fa-car-battery:before {
    content: "\f5df"
}

.fa-car-crash:before {
    content: "\f5e1"
}

.fa-car-side:before {
    content: "\f5e4"
}

.fa-caravan:before {
    content: "\f8ff"
}

.fa-caret-down:before {
    content: "\f0d7"
}

.fa-caret-left:before {
    content: "\f0d9"
}

.fa-caret-right:before {
    content: "\f0da"
}

.fa-caret-square-down:before {
    content: "\f150"
}

.fa-caret-square-left:before {
    content: "\f191"
}

.fa-caret-square-right:before {
    content: "\f152"
}

.fa-caret-square-up:before {
    content: "\f151"
}

.fa-caret-up:before {
    content: "\f0d8"
}

.fa-carrot:before {
    content: "\f787"
}

.fa-cart-arrow-down:before {
    content: "\f218"
}

.fa-cart-plus:before {
    content: "\f217"
}

.fa-cash-register:before {
    content: "\f788"
}

.fa-cat:before {
    content: "\f6be"
}

.fa-cc-amazon-pay:before {
    content: "\f42d"
}

.fa-cc-amex:before {
    content: "\f1f3"
}

.fa-cc-apple-pay:before {
    content: "\f416"
}

.fa-cc-diners-club:before {
    content: "\f24c"
}

.fa-cc-discover:before {
    content: "\f1f2"
}

.fa-cc-jcb:before {
    content: "\f24b"
}

.fa-cc-mastercard:before {
    content: "\f1f1"
}

.fa-cc-paypal:before {
    content: "\f1f4"
}

.fa-cc-stripe:before {
    content: "\f1f5"
}

.fa-cc-visa:before {
    content: "\f1f0"
}

.fa-centercode:before {
    content: "\f380"
}

.fa-centos:before {
    content: "\f789"
}

.fa-certificate:before {
    content: "\f0a3"
}

.fa-chair:before {
    content: "\f6c0"
}

.fa-chalkboard:before {
    content: "\f51b"
}

.fa-chalkboard-teacher:before {
    content: "\f51c"
}

.fa-charging-station:before {
    content: "\f5e7"
}

.fa-chart-area:before {
    content: "\f1fe"
}

.fa-chart-bar:before {
    content: "\f080"
}

.fa-chart-line:before {
    content: "\f201"
}

.fa-chart-pie:before {
    content: "\f200"
}

.fa-check:before {
    content: "\f00c"
}

.fa-check-circle:before {
    content: "\f058"
}

.fa-check-double:before {
    content: "\f560"
}

.fa-check-square:before {
    content: "\f14a"
}

.fa-cheese:before {
    content: "\f7ef"
}

.fa-chess:before {
    content: "\f439"
}

.fa-chess-bishop:before {
    content: "\f43a"
}

.fa-chess-board:before {
    content: "\f43c"
}

.fa-chess-king:before {
    content: "\f43f"
}

.fa-chess-knight:before {
    content: "\f441"
}

.fa-chess-pawn:before {
    content: "\f443"
}

.fa-chess-queen:before {
    content: "\f445"
}

.fa-chess-rook:before {
    content: "\f447"
}

.fa-chevron-circle-down:before {
    content: "\f13a"
}

.fa-chevron-circle-left:before {
    content: "\f137"
}

.fa-chevron-circle-right:before {
    content: "\f138"
}

.fa-chevron-circle-up:before {
    content: "\f139"
}

.fa-chevron-down:before {
    content: "\f078"
}

.fa-chevron-left:before {
    content: "\f053"
}

.fa-chevron-right:before {
    content: "\f054"
}

.fa-chevron-up:before {
    content: "\f077"
}

.fa-child:before {
    content: "\f1ae"
}

.fa-chrome:before {
    content: "\f268"
}

.fa-chromecast:before {
    content: "\f838"
}

.fa-church:before {
    content: "\f51d"
}

.fa-circle:before {
    content: "\f111"
}

.fa-circle-notch:before {
    content: "\f1ce"
}

.fa-city:before {
    content: "\f64f"
}

.fa-clinic-medical:before {
    content: "\f7f2"
}

.fa-clipboard:before {
    content: "\f328"
}

.fa-clipboard-check:before {
    content: "\f46c"
}

.fa-clipboard-list:before {
    content: "\f46d"
}

.fa-clock:before {
    content: "\f017"
}

.fa-clone:before {
    content: "\f24d"
}

.fa-closed-captioning:before {
    content: "\f20a"
}

.fa-cloud:before {
    content: "\f0c2"
}

.fa-cloud-download-alt:before {
    content: "\f381"
}

.fa-cloud-meatball:before {
    content: "\f73b"
}

.fa-cloud-moon:before {
    content: "\f6c3"
}

.fa-cloud-moon-rain:before {
    content: "\f73c"
}

.fa-cloud-rain:before {
    content: "\f73d"
}

.fa-cloud-showers-heavy:before {
    content: "\f740"
}

.fa-cloud-sun:before {
    content: "\f6c4"
}

.fa-cloud-sun-rain:before {
    content: "\f743"
}

.fa-cloud-upload-alt:before {
    content: "\f382"
}

.fa-cloudflare:before {
    content: "\e07d"
}

.fa-cloudscale:before {
    content: "\f383"
}

.fa-cloudsmith:before {
    content: "\f384"
}

.fa-cloudversify:before {
    content: "\f385"
}

.fa-cocktail:before {
    content: "\f561"
}

.fa-code:before {
    content: "\f121"
}

.fa-code-branch:before {
    content: "\f126"
}

.fa-codepen:before {
    content: "\f1cb"
}

.fa-codiepie:before {
    content: "\f284"
}

.fa-coffee:before {
    content: "\f0f4"
}

.fa-cog:before {
    content: "\f013"
}

.fa-cogs:before {
    content: "\f085"
}

.fa-coins:before {
    content: "\f51e"
}

.fa-columns:before {
    content: "\f0db"
}

.fa-comment:before {
    content: "\f075"
}

.fa-comment-alt:before {
    content: "\f27a"
}

.fa-comment-dollar:before {
    content: "\f651"
}

.fa-comment-dots:before {
    content: "\f4ad"
}

.fa-comment-medical:before {
    content: "\f7f5"
}

.fa-comment-slash:before {
    content: "\f4b3"
}

.fa-comments:before {
    content: "\f086"
}

.fa-comments-dollar:before {
    content: "\f653"
}

.fa-compact-disc:before {
    content: "\f51f"
}

.fa-compass:before {
    content: "\f14e"
}

.fa-compress:before {
    content: "\f066"
}

.fa-compress-alt:before {
    content: "\f422"
}

.fa-compress-arrows-alt:before {
    content: "\f78c"
}

.fa-concierge-bell:before {
    content: "\f562"
}

.fa-confluence:before {
    content: "\f78d"
}

.fa-connectdevelop:before {
    content: "\f20e"
}

.fa-contao:before {
    content: "\f26d"
}

.fa-cookie:before {
    content: "\f563"
}

.fa-cookie-bite:before {
    content: "\f564"
}

.fa-copy:before {
    content: "\f0c5"
}

.fa-copyright:before {
    content: "\f1f9"
}

.fa-cotton-bureau:before {
    content: "\f89e"
}

.fa-couch:before {
    content: "\f4b8"
}

.fa-cpanel:before {
    content: "\f388"
}

.fa-creative-commons:before {
    content: "\f25e"
}

.fa-creative-commons-by:before {
    content: "\f4e7"
}

.fa-creative-commons-nc:before {
    content: "\f4e8"
}

.fa-creative-commons-nc-eu:before {
    content: "\f4e9"
}

.fa-creative-commons-nc-jp:before {
    content: "\f4ea"
}

.fa-creative-commons-nd:before {
    content: "\f4eb"
}

.fa-creative-commons-pd:before {
    content: "\f4ec"
}

.fa-creative-commons-pd-alt:before {
    content: "\f4ed"
}

.fa-creative-commons-remix:before {
    content: "\f4ee"
}

.fa-creative-commons-sa:before {
    content: "\f4ef"
}

.fa-creative-commons-sampling:before {
    content: "\f4f0"
}

.fa-creative-commons-sampling-plus:before {
    content: "\f4f1"
}

.fa-creative-commons-share:before {
    content: "\f4f2"
}

.fa-creative-commons-zero:before {
    content: "\f4f3"
}

.fa-credit-card:before {
    content: "\f09d"
}

.fa-critical-role:before {
    content: "\f6c9"
}

.fa-crop:before {
    content: "\f125"
}

.fa-crop-alt:before {
    content: "\f565"
}

.fa-cross:before {
    content: "\f654"
}

.fa-crosshairs:before {
    content: "\f05b"
}

.fa-crow:before {
    content: "\f520"
}

.fa-crown:before {
    content: "\f521"
}

.fa-crutch:before {
    content: "\f7f7"
}

.fa-css3:before {
    content: "\f13c"
}

.fa-css3-alt:before {
    content: "\f38b"
}

.fa-cube:before {
    content: "\f1b2"
}

.fa-cubes:before {
    content: "\f1b3"
}

.fa-cut:before {
    content: "\f0c4"
}

.fa-cuttlefish:before {
    content: "\f38c"
}

.fa-d-and-d:before {
    content: "\f38d"
}

.fa-d-and-d-beyond:before {
    content: "\f6ca"
}

.fa-dailymotion:before {
    content: "\e052"
}

.fa-dashcube:before {
    content: "\f210"
}

.fa-database:before {
    content: "\f1c0"
}

.fa-deaf:before {
    content: "\f2a4"
}

.fa-deezer:before {
    content: "\e077"
}

.fa-delicious:before {
    content: "\f1a5"
}

.fa-democrat:before {
    content: "\f747"
}

.fa-deploydog:before {
    content: "\f38e"
}

.fa-deskpro:before {
    content: "\f38f"
}

.fa-desktop:before {
    content: "\f108"
}

.fa-dev:before {
    content: "\f6cc"
}

.fa-deviantart:before {
    content: "\f1bd"
}

.fa-dharmachakra:before {
    content: "\f655"
}

.fa-dhl:before {
    content: "\f790"
}

.fa-diagnoses:before {
    content: "\f470"
}

.fa-diaspora:before {
    content: "\f791"
}

.fa-dice:before {
    content: "\f522"
}

.fa-dice-d20:before {
    content: "\f6cf"
}

.fa-dice-d6:before {
    content: "\f6d1"
}

.fa-dice-five:before {
    content: "\f523"
}

.fa-dice-four:before {
    content: "\f524"
}

.fa-dice-one:before {
    content: "\f525"
}

.fa-dice-six:before {
    content: "\f526"
}

.fa-dice-three:before {
    content: "\f527"
}

.fa-dice-two:before {
    content: "\f528"
}

.fa-digg:before {
    content: "\f1a6"
}

.fa-digital-ocean:before {
    content: "\f391"
}

.fa-digital-tachograph:before {
    content: "\f566"
}

.fa-directions:before {
    content: "\f5eb"
}

.fa-discord:before {
    content: "\f392"
}

.fa-discourse:before {
    content: "\f393"
}

.fa-disease:before {
    content: "\f7fa"
}

.fa-divide:before {
    content: "\f529"
}

.fa-dizzy:before {
    content: "\f567"
}

.fa-dna:before {
    content: "\f471"
}

.fa-dochub:before {
    content: "\f394"
}

.fa-docker:before {
    content: "\f395"
}

.fa-dog:before {
    content: "\f6d3"
}

.fa-dollar-sign:before {
    content: "\f155"
}

.fa-dolly:before {
    content: "\f472"
}

.fa-dolly-flatbed:before {
    content: "\f474"
}

.fa-donate:before {
    content: "\f4b9"
}

.fa-door-closed:before {
    content: "\f52a"
}

.fa-door-open:before {
    content: "\f52b"
}

.fa-dot-circle:before {
    content: "\f192"
}

.fa-dove:before {
    content: "\f4ba"
}

.fa-download:before {
    content: "\f019"
}

.fa-draft2digital:before {
    content: "\f396"
}

.fa-drafting-compass:before {
    content: "\f568"
}

.fa-dragon:before {
    content: "\f6d5"
}

.fa-draw-polygon:before {
    content: "\f5ee"
}

.fa-dribbble:before {
    content: "\f17d"
}

.fa-dribbble-square:before {
    content: "\f397"
}

.fa-dropbox:before {
    content: "\f16b"
}

.fa-drum:before {
    content: "\f569"
}

.fa-drum-steelpan:before {
    content: "\f56a"
}

.fa-drumstick-bite:before {
    content: "\f6d7"
}

.fa-drupal:before {
    content: "\f1a9"
}

.fa-dumbbell:before {
    content: "\f44b"
}

.fa-dumpster:before {
    content: "\f793"
}

.fa-dumpster-fire:before {
    content: "\f794"
}

.fa-dungeon:before {
    content: "\f6d9"
}

.fa-dyalog:before {
    content: "\f399"
}

.fa-earlybirds:before {
    content: "\f39a"
}

.fa-ebay:before {
    content: "\f4f4"
}

.fa-edge:before {
    content: "\f282"
}

.fa-edge-legacy:before {
    content: "\e078"
}

.fa-edit:before {
    content: "\f044"
}

.fa-egg:before {
    content: "\f7fb"
}

.fa-eject:before {
    content: "\f052"
}

.fa-elementor:before {
    content: "\f430"
}

.fa-ellipsis-h:before {
    content: "\f141"
}

.fa-ellipsis-v:before {
    content: "\f142"
}

.fa-ello:before {
    content: "\f5f1"
}

.fa-ember:before {
    content: "\f423"
}

.fa-empire:before {
    content: "\f1d1"
}

.fa-envelope:before {
    content: "\f0e0"
}

.fa-envelope-open:before {
    content: "\f2b6"
}

.fa-envelope-open-text:before {
    content: "\f658"
}

.fa-envelope-square:before {
    content: "\f199"
}

.fa-envira:before {
    content: "\f299"
}

.fa-equals:before {
    content: "\f52c"
}

.fa-eraser:before {
    content: "\f12d"
}

.fa-erlang:before {
    content: "\f39d"
}

.fa-ethereum:before {
    content: "\f42e"
}

.fa-ethernet:before {
    content: "\f796"
}

.fa-etsy:before {
    content: "\f2d7"
}

.fa-euro-sign:before {
    content: "\f153"
}

.fa-evernote:before {
    content: "\f839"
}

.fa-exchange-alt:before {
    content: "\f362"
}

.fa-exclamation:before {
    content: "\f12a"
}

.fa-exclamation-circle:before {
    content: "\f06a"
}

.fa-exclamation-triangle:before {
    content: "\f071"
}

.fa-expand:before {
    content: "\f065"
}

.fa-expand-alt:before {
    content: "\f424"
}

.fa-expand-arrows-alt:before {
    content: "\f31e"
}

.fa-expeditedssl:before {
    content: "\f23e"
}

.fa-external-link-alt:before {
    content: "\f35d"
}

.fa-external-link-square-alt:before {
    content: "\f360"
}

.fa-eye:before {
    content: "\f06e"
}

.fa-eye-dropper:before {
    content: "\f1fb"
}

.fa-eye-slash:before {
    content: "\f070"
}

.fa-facebook:before {
    content: "\f09a"
}

.fa-facebook-f:before {
    content: "\f39e"
}

.fa-facebook-messenger:before {
    content: "\f39f"
}

.fa-facebook-square:before {
    content: "\f082"
}

.fa-fan:before {
    content: "\f863"
}

.fa-fantasy-flight-games:before {
    content: "\f6dc"
}

.fa-fast-backward:before {
    content: "\f049"
}

.fa-fast-forward:before {
    content: "\f050"
}

.fa-faucet:before {
    content: "\e005"
}

.fa-fax:before {
    content: "\f1ac"
}

.fa-feather:before {
    content: "\f52d"
}

.fa-feather-alt:before {
    content: "\f56b"
}

.fa-fedex:before {
    content: "\f797"
}

.fa-fedora:before {
    content: "\f798"
}

.fa-female:before {
    content: "\f182"
}

.fa-fighter-jet:before {
    content: "\f0fb"
}

.fa-figma:before {
    content: "\f799"
}

.fa-file:before {
    content: "\f15b"
}

.fa-file-alt:before {
    content: "\f15c"
}

.fa-file-archive:before {
    content: "\f1c6"
}

.fa-file-audio:before {
    content: "\f1c7"
}

.fa-file-code:before {
    content: "\f1c9"
}

.fa-file-contract:before {
    content: "\f56c"
}

.fa-file-csv:before {
    content: "\f6dd"
}

.fa-file-download:before {
    content: "\f56d"
}

.fa-file-excel:before {
    content: "\f1c3"
}

.fa-file-export:before {
    content: "\f56e"
}

.fa-file-image:before {
    content: "\f1c5"
}

.fa-file-import:before {
    content: "\f56f"
}

.fa-file-invoice:before {
    content: "\f570"
}

.fa-file-invoice-dollar:before {
    content: "\f571"
}

.fa-file-medical:before {
    content: "\f477"
}

.fa-file-medical-alt:before {
    content: "\f478"
}

.fa-file-pdf:before {
    content: "\f1c1"
}

.fa-file-powerpoint:before {
    content: "\f1c4"
}

.fa-file-prescription:before {
    content: "\f572"
}

.fa-file-signature:before {
    content: "\f573"
}

.fa-file-upload:before {
    content: "\f574"
}

.fa-file-video:before {
    content: "\f1c8"
}

.fa-file-word:before {
    content: "\f1c2"
}

.fa-fill:before {
    content: "\f575"
}

.fa-fill-drip:before {
    content: "\f576"
}

.fa-film:before {
    content: "\f008"
}

.fa-filter:before {
    content: "\f0b0"
}

.fa-fingerprint:before {
    content: "\f577"
}

.fa-fire:before {
    content: "\f06d"
}

.fa-fire-alt:before {
    content: "\f7e4"
}

.fa-fire-extinguisher:before {
    content: "\f134"
}

.fa-firefox:before {
    content: "\f269"
}

.fa-firefox-browser:before {
    content: "\e007"
}

.fa-first-aid:before {
    content: "\f479"
}

.fa-first-order:before {
    content: "\f2b0"
}

.fa-first-order-alt:before {
    content: "\f50a"
}

.fa-firstdraft:before {
    content: "\f3a1"
}

.fa-fish:before {
    content: "\f578"
}

.fa-fist-raised:before {
    content: "\f6de"
}

.fa-flag:before {
    content: "\f024"
}

.fa-flag-checkered:before {
    content: "\f11e"
}

.fa-flag-usa:before {
    content: "\f74d"
}

.fa-flask:before {
    content: "\f0c3"
}

.fa-flickr:before {
    content: "\f16e"
}

.fa-flipboard:before {
    content: "\f44d"
}

.fa-flushed:before {
    content: "\f579"
}

.fa-fly:before {
    content: "\f417"
}

.fa-folder:before {
    content: "\f07b"
}

.fa-folder-minus:before {
    content: "\f65d"
}

.fa-folder-open:before {
    content: "\f07c"
}

.fa-folder-plus:before {
    content: "\f65e"
}

.fa-font:before {
    content: "\f031"
}

.fa-font-awesome:before {
    content: "\f2b4"
}

.fa-font-awesome-alt:before {
    content: "\f35c"
}

.fa-font-awesome-flag:before {
    content: "\f425"
}

.fa-font-awesome-logo-full:before {
    content: "\f4e6"
}

.fa-fonticons:before {
    content: "\f280"
}

.fa-fonticons-fi:before {
    content: "\f3a2"
}

.fa-football-ball:before {
    content: "\f44e"
}

.fa-fort-awesome:before {
    content: "\f286"
}

.fa-fort-awesome-alt:before {
    content: "\f3a3"
}

.fa-forumbee:before {
    content: "\f211"
}

.fa-forward:before {
    content: "\f04e"
}

.fa-foursquare:before {
    content: "\f180"
}

.fa-free-code-camp:before {
    content: "\f2c5"
}

.fa-freebsd:before {
    content: "\f3a4"
}

.fa-frog:before {
    content: "\f52e"
}

.fa-frown:before {
    content: "\f119"
}

.fa-frown-open:before {
    content: "\f57a"
}

.fa-fulcrum:before {
    content: "\f50b"
}

.fa-funnel-dollar:before {
    content: "\f662"
}

.fa-futbol:before {
    content: "\f1e3"
}

.fa-galactic-republic:before {
    content: "\f50c"
}

.fa-galactic-senate:before {
    content: "\f50d"
}

.fa-gamepad:before {
    content: "\f11b"
}

.fa-gas-pump:before {
    content: "\f52f"
}

.fa-gavel:before {
    content: "\f0e3"
}

.fa-gem:before {
    content: "\f3a5"
}

.fa-genderless:before {
    content: "\f22d"
}

.fa-get-pocket:before {
    content: "\f265"
}

.fa-gg:before {
    content: "\f260"
}

.fa-gg-circle:before {
    content: "\f261"
}

.fa-ghost:before {
    content: "\f6e2"
}

.fa-gift:before {
    content: "\f06b"
}

.fa-gifts:before {
    content: "\f79c"
}

.fa-git:before {
    content: "\f1d3"
}

.fa-git-alt:before {
    content: "\f841"
}

.fa-git-square:before {
    content: "\f1d2"
}

.fa-github:before {
    content: "\f09b"
}

.fa-github-alt:before {
    content: "\f113"
}

.fa-github-square:before {
    content: "\f092"
}

.fa-gitkraken:before {
    content: "\f3a6"
}

.fa-gitlab:before {
    content: "\f296"
}

.fa-gitter:before {
    content: "\f426"
}

.fa-glass-cheers:before {
    content: "\f79f"
}

.fa-glass-martini:before {
    content: "\f000"
}

.fa-glass-martini-alt:before {
    content: "\f57b"
}

.fa-glass-whiskey:before {
    content: "\f7a0"
}

.fa-glasses:before {
    content: "\f530"
}

.fa-glide:before {
    content: "\f2a5"
}

.fa-glide-g:before {
    content: "\f2a6"
}

.fa-globe:before {
    content: "\f0ac"
}

.fa-globe-africa:before {
    content: "\f57c"
}

.fa-globe-americas:before {
    content: "\f57d"
}

.fa-globe-asia:before {
    content: "\f57e"
}

.fa-globe-europe:before {
    content: "\f7a2"
}

.fa-gofore:before {
    content: "\f3a7"
}

.fa-golf-ball:before {
    content: "\f450"
}

.fa-goodreads:before {
    content: "\f3a8"
}

.fa-goodreads-g:before {
    content: "\f3a9"
}

.fa-google:before {
    content: "\f1a0"
}

.fa-google-drive:before {
    content: "\f3aa"
}

.fa-google-pay:before {
    content: "\e079"
}

.fa-google-play:before {
    content: "\f3ab"
}

.fa-google-plus:before {
    content: "\f2b3"
}

.fa-google-plus-g:before {
    content: "\f0d5"
}

.fa-google-plus-square:before {
    content: "\f0d4"
}

.fa-google-wallet:before {
    content: "\f1ee"
}

.fa-gopuram:before {
    content: "\f664"
}

.fa-graduation-cap:before {
    content: "\f19d"
}

.fa-gratipay:before {
    content: "\f184"
}

.fa-grav:before {
    content: "\f2d6"
}

.fa-greater-than:before {
    content: "\f531"
}

.fa-greater-than-equal:before {
    content: "\f532"
}

.fa-grimace:before {
    content: "\f57f"
}

.fa-grin:before {
    content: "\f580"
}

.fa-grin-alt:before {
    content: "\f581"
}

.fa-grin-beam:before {
    content: "\f582"
}

.fa-grin-beam-sweat:before {
    content: "\f583"
}

.fa-grin-hearts:before {
    content: "\f584"
}

.fa-grin-squint:before {
    content: "\f585"
}

.fa-grin-squint-tears:before {
    content: "\f586"
}

.fa-grin-stars:before {
    content: "\f587"
}

.fa-grin-tears:before {
    content: "\f588"
}

.fa-grin-tongue:before {
    content: "\f589"
}

.fa-grin-tongue-squint:before {
    content: "\f58a"
}

.fa-grin-tongue-wink:before {
    content: "\f58b"
}

.fa-grin-wink:before {
    content: "\f58c"
}

.fa-grip-horizontal:before {
    content: "\f58d"
}

.fa-grip-lines:before {
    content: "\f7a4"
}

.fa-grip-lines-vertical:before {
    content: "\f7a5"
}

.fa-grip-vertical:before {
    content: "\f58e"
}

.fa-gripfire:before {
    content: "\f3ac"
}

.fa-grunt:before {
    content: "\f3ad"
}

.fa-guilded:before {
    content: "\e07e"
}

.fa-guitar:before {
    content: "\f7a6"
}

.fa-gulp:before {
    content: "\f3ae"
}

.fa-h-square:before {
    content: "\f0fd"
}

.fa-hacker-news:before {
    content: "\f1d4"
}

.fa-hacker-news-square:before {
    content: "\f3af"
}

.fa-hackerrank:before {
    content: "\f5f7"
}

.fa-hamburger:before {
    content: "\f805"
}

.fa-hammer:before {
    content: "\f6e3"
}

.fa-hamsa:before {
    content: "\f665"
}

.fa-hand-holding:before {
    content: "\f4bd"
}

.fa-hand-holding-heart:before {
    content: "\f4be"
}

.fa-hand-holding-medical:before {
    content: "\e05c"
}

.fa-hand-holding-usd:before {
    content: "\f4c0"
}

.fa-hand-holding-water:before {
    content: "\f4c1"
}

.fa-hand-lizard:before {
    content: "\f258"
}

.fa-hand-middle-finger:before {
    content: "\f806"
}

.fa-hand-paper:before {
    content: "\f256"
}

.fa-hand-peace:before {
    content: "\f25b"
}

.fa-hand-point-down:before {
    content: "\f0a7"
}

.fa-hand-point-left:before {
    content: "\f0a5"
}

.fa-hand-point-right:before {
    content: "\f0a4"
}

.fa-hand-point-up:before {
    content: "\f0a6"
}

.fa-hand-pointer:before {
    content: "\f25a"
}

.fa-hand-rock:before {
    content: "\f255"
}

.fa-hand-scissors:before {
    content: "\f257"
}

.fa-hand-sparkles:before {
    content: "\e05d"
}

.fa-hand-spock:before {
    content: "\f259"
}

.fa-hands:before {
    content: "\f4c2"
}

.fa-hands-helping:before {
    content: "\f4c4"
}

.fa-hands-wash:before {
    content: "\e05e"
}

.fa-handshake:before {
    content: "\f2b5"
}

.fa-handshake-alt-slash:before {
    content: "\e05f"
}

.fa-handshake-slash:before {
    content: "\e060"
}

.fa-hanukiah:before {
    content: "\f6e6"
}

.fa-hard-hat:before {
    content: "\f807"
}

.fa-hashtag:before {
    content: "\f292"
}

.fa-hat-cowboy:before {
    content: "\f8c0"
}

.fa-hat-cowboy-side:before {
    content: "\f8c1"
}

.fa-hat-wizard:before {
    content: "\f6e8"
}

.fa-hdd:before {
    content: "\f0a0"
}

.fa-head-side-cough:before {
    content: "\e061"
}

.fa-head-side-cough-slash:before {
    content: "\e062"
}

.fa-head-side-mask:before {
    content: "\e063"
}

.fa-head-side-virus:before {
    content: "\e064"
}

.fa-heading:before {
    content: "\f1dc"
}

.fa-headphones:before {
    content: "\f025"
}

.fa-headphones-alt:before {
    content: "\f58f"
}

.fa-headset:before {
    content: "\f590"
}

.fa-heart:before {
    content: "\f004"
}

.fa-heart-broken:before {
    content: "\f7a9"
}

.fa-heartbeat:before {
    content: "\f21e"
}

.fa-helicopter:before {
    content: "\f533"
}

.fa-highlighter:before {
    content: "\f591"
}

.fa-hiking:before {
    content: "\f6ec"
}

.fa-hippo:before {
    content: "\f6ed"
}

.fa-hips:before {
    content: "\f452"
}

.fa-hire-a-helper:before {
    content: "\f3b0"
}

.fa-history:before {
    content: "\f1da"
}

.fa-hive:before {
    content: "\e07f"
}

.fa-hockey-puck:before {
    content: "\f453"
}

.fa-holly-berry:before {
    content: "\f7aa"
}

.fa-home:before {
    content: "\f015"
}

.fa-hooli:before {
    content: "\f427"
}

.fa-hornbill:before {
    content: "\f592"
}

.fa-horse:before {
    content: "\f6f0"
}

.fa-horse-head:before {
    content: "\f7ab"
}

.fa-hospital:before {
    content: "\f0f8"
}

.fa-hospital-alt:before {
    content: "\f47d"
}

.fa-hospital-symbol:before {
    content: "\f47e"
}

.fa-hospital-user:before {
    content: "\f80d"
}

.fa-hot-tub:before {
    content: "\f593"
}

.fa-hotdog:before {
    content: "\f80f"
}

.fa-hotel:before {
    content: "\f594"
}

.fa-hotjar:before {
    content: "\f3b1"
}

.fa-hourglass:before {
    content: "\f254"
}

.fa-hourglass-end:before {
    content: "\f253"
}

.fa-hourglass-half:before {
    content: "\f252"
}

.fa-hourglass-start:before {
    content: "\f251"
}

.fa-house-damage:before {
    content: "\f6f1"
}

.fa-house-user:before {
    content: "\e065"
}

.fa-houzz:before {
    content: "\f27c"
}

.fa-hryvnia:before {
    content: "\f6f2"
}

.fa-html5:before {
    content: "\f13b"
}

.fa-hubspot:before {
    content: "\f3b2"
}

.fa-i-cursor:before {
    content: "\f246"
}

.fa-ice-cream:before {
    content: "\f810"
}

.fa-icicles:before {
    content: "\f7ad"
}

.fa-icons:before {
    content: "\f86d"
}

.fa-id-badge:before {
    content: "\f2c1"
}

.fa-id-card:before {
    content: "\f2c2"
}

.fa-id-card-alt:before {
    content: "\f47f"
}

.fa-ideal:before {
    content: "\e013"
}

.fa-igloo:before {
    content: "\f7ae"
}

.fa-image:before {
    content: "\f03e"
}

.fa-images:before {
    content: "\f302"
}

.fa-imdb:before {
    content: "\f2d8"
}

.fa-inbox:before {
    content: "\f01c"
}

.fa-indent:before {
    content: "\f03c"
}

.fa-industry:before {
    content: "\f275"
}

.fa-infinity:before {
    content: "\f534"
}

.fa-info:before {
    content: "\f129"
}

.fa-info-circle:before {
    content: "\f05a"
}

.fa-innosoft:before {
    content: "\e080"
}

.fa-instagram:before {
    content: "\f16d"
}

.fa-instagram-square:before {
    content: "\e055"
}

.fa-instalod:before {
    content: "\e081"
}

.fa-intercom:before {
    content: "\f7af"
}

.fa-internet-explorer:before {
    content: "\f26b"
}

.fa-invision:before {
    content: "\f7b0"
}

.fa-ioxhost:before {
    content: "\f208"
}

.fa-italic:before {
    content: "\f033"
}

.fa-itch-io:before {
    content: "\f83a"
}

.fa-itunes:before {
    content: "\f3b4"
}

.fa-itunes-note:before {
    content: "\f3b5"
}

.fa-java:before {
    content: "\f4e4"
}

.fa-jedi:before {
    content: "\f669"
}

.fa-jedi-order:before {
    content: "\f50e"
}

.fa-jenkins:before {
    content: "\f3b6"
}

.fa-jira:before {
    content: "\f7b1"
}

.fa-joget:before {
    content: "\f3b7"
}

.fa-joint:before {
    content: "\f595"
}

.fa-joomla:before {
    content: "\f1aa"
}

.fa-journal-whills:before {
    content: "\f66a"
}

.fa-js:before {
    content: "\f3b8"
}

.fa-js-square:before {
    content: "\f3b9"
}

.fa-jsfiddle:before {
    content: "\f1cc"
}

.fa-kaaba:before {
    content: "\f66b"
}

.fa-kaggle:before {
    content: "\f5fa"
}

.fa-key:before {
    content: "\f084"
}

.fa-keybase:before {
    content: "\f4f5"
}

.fa-keyboard:before {
    content: "\f11c"
}

.fa-keycdn:before {
    content: "\f3ba"
}

.fa-khanda:before {
    content: "\f66d"
}

.fa-kickstarter:before {
    content: "\f3bb"
}

.fa-kickstarter-k:before {
    content: "\f3bc"
}

.fa-kiss:before {
    content: "\f596"
}

.fa-kiss-beam:before {
    content: "\f597"
}

.fa-kiss-wink-heart:before {
    content: "\f598"
}

.fa-kiwi-bird:before {
    content: "\f535"
}

.fa-korvue:before {
    content: "\f42f"
}

.fa-landmark:before {
    content: "\f66f"
}

.fa-language:before {
    content: "\f1ab"
}

.fa-laptop:before {
    content: "\f109"
}

.fa-laptop-code:before {
    content: "\f5fc"
}

.fa-laptop-house:before {
    content: "\e066"
}

.fa-laptop-medical:before {
    content: "\f812"
}

.fa-laravel:before {
    content: "\f3bd"
}

.fa-lastfm:before {
    content: "\f202"
}

.fa-lastfm-square:before {
    content: "\f203"
}

.fa-laugh:before {
    content: "\f599"
}

.fa-laugh-beam:before {
    content: "\f59a"
}

.fa-laugh-squint:before {
    content: "\f59b"
}

.fa-laugh-wink:before {
    content: "\f59c"
}

.fa-layer-group:before {
    content: "\f5fd"
}

.fa-leaf:before {
    content: "\f06c"
}

.fa-leanpub:before {
    content: "\f212"
}

.fa-lemon:before {
    content: "\f094"
}

.fa-less:before {
    content: "\f41d"
}

.fa-less-than:before {
    content: "\f536"
}

.fa-less-than-equal:before {
    content: "\f537"
}

.fa-level-down-alt:before {
    content: "\f3be"
}

.fa-level-up-alt:before {
    content: "\f3bf"
}

.fa-life-ring:before {
    content: "\f1cd"
}

.fa-lightbulb:before {
    content: "\f0eb"
}

.fa-line:before {
    content: "\f3c0"
}

.fa-link:before {
    content: "\f0c1"
}

.fa-linkedin:before {
    content: "\f08c"
}

.fa-linkedin-in:before {
    content: "\f0e1"
}

.fa-linode:before {
    content: "\f2b8"
}

.fa-linux:before {
    content: "\f17c"
}

.fa-lira-sign:before {
    content: "\f195"
}

.fa-list:before {
    content: "\f03a"
}

.fa-list-alt:before {
    content: "\f022"
}

.fa-list-ol:before {
    content: "\f0cb"
}

.fa-list-ul:before {
    content: "\f0ca"
}

.fa-location-arrow:before {
    content: "\f124"
}

.fa-lock:before {
    content: "\f023"
}

.fa-lock-open:before {
    content: "\f3c1"
}

.fa-long-arrow-alt-down:before {
    content: "\f309"
}

.fa-long-arrow-alt-left:before {
    content: "\f30a"
}

.fa-long-arrow-alt-right:before {
    content: "\f30b"
}

.fa-long-arrow-alt-up:before {
    content: "\f30c"
}

.fa-low-vision:before {
    content: "\f2a8"
}

.fa-luggage-cart:before {
    content: "\f59d"
}

.fa-lungs:before {
    content: "\f604"
}

.fa-lungs-virus:before {
    content: "\e067"
}

.fa-lyft:before {
    content: "\f3c3"
}

.fa-magento:before {
    content: "\f3c4"
}

.fa-magic:before {
    content: "\f0d0"
}

.fa-magnet:before {
    content: "\f076"
}

.fa-mail-bulk:before {
    content: "\f674"
}

.fa-mailchimp:before {
    content: "\f59e"
}

.fa-male:before {
    content: "\f183"
}

.fa-mandalorian:before {
    content: "\f50f"
}

.fa-map:before {
    content: "\f279"
}

.fa-map-marked:before {
    content: "\f59f"
}

.fa-map-marked-alt:before {
    content: "\f5a0"
}

.fa-map-marker:before {
    content: "\f041"
}

.fa-map-marker-alt:before {
    content: "\f3c5"
}

.fa-map-pin:before {
    content: "\f276"
}

.fa-map-signs:before {
    content: "\f277"
}

.fa-markdown:before {
    content: "\f60f"
}

.fa-marker:before {
    content: "\f5a1"
}

.fa-mars:before {
    content: "\f222"
}

.fa-mars-double:before {
    content: "\f227"
}

.fa-mars-stroke:before {
    content: "\f229"
}

.fa-mars-stroke-h:before {
    content: "\f22b"
}

.fa-mars-stroke-v:before {
    content: "\f22a"
}

.fa-mask:before {
    content: "\f6fa"
}

.fa-mastodon:before {
    content: "\f4f6"
}

.fa-maxcdn:before {
    content: "\f136"
}

.fa-mdb:before {
    content: "\f8ca"
}

.fa-medal:before {
    content: "\f5a2"
}

.fa-medapps:before {
    content: "\f3c6"
}

.fa-medium:before {
    content: "\f23a"
}

.fa-medium-m:before {
    content: "\f3c7"
}

.fa-medkit:before {
    content: "\f0fa"
}

.fa-medrt:before {
    content: "\f3c8"
}

.fa-meetup:before {
    content: "\f2e0"
}

.fa-megaport:before {
    content: "\f5a3"
}

.fa-meh:before {
    content: "\f11a"
}

.fa-meh-blank:before {
    content: "\f5a4"
}

.fa-meh-rolling-eyes:before {
    content: "\f5a5"
}

.fa-memory:before {
    content: "\f538"
}

.fa-mendeley:before {
    content: "\f7b3"
}

.fa-menorah:before {
    content: "\f676"
}

.fa-mercury:before {
    content: "\f223"
}

.fa-meteor:before {
    content: "\f753"
}

.fa-microblog:before {
    content: "\e01a"
}

.fa-microchip:before {
    content: "\f2db"
}

.fa-microphone:before {
    content: "\f130"
}

.fa-microphone-alt:before {
    content: "\f3c9"
}

.fa-microphone-alt-slash:before {
    content: "\f539"
}

.fa-microphone-slash:before {
    content: "\f131"
}

.fa-microscope:before {
    content: "\f610"
}

.fa-microsoft:before {
    content: "\f3ca"
}

.fa-minus:before {
    content: "\f068"
}

.fa-minus-circle:before {
    content: "\f056"
}

.fa-minus-square:before {
    content: "\f146"
}

.fa-mitten:before {
    content: "\f7b5"
}

.fa-mix:before {
    content: "\f3cb"
}

.fa-mixcloud:before {
    content: "\f289"
}

.fa-mixer:before {
    content: "\e056"
}

.fa-mizuni:before {
    content: "\f3cc"
}

.fa-mobile:before {
    content: "\f10b"
}

.fa-mobile-alt:before {
    content: "\f3cd"
}

.fa-modx:before {
    content: "\f285"
}

.fa-monero:before {
    content: "\f3d0"
}

.fa-money-bill:before {
    content: "\f0d6"
}

.fa-money-bill-alt:before {
    content: "\f3d1"
}

.fa-money-bill-wave:before {
    content: "\f53a"
}

.fa-money-bill-wave-alt:before {
    content: "\f53b"
}

.fa-money-check:before {
    content: "\f53c"
}

.fa-money-check-alt:before {
    content: "\f53d"
}

.fa-monument:before {
    content: "\f5a6"
}

.fa-moon:before {
    content: "\f186"
}

.fa-mortar-pestle:before {
    content: "\f5a7"
}

.fa-mosque:before {
    content: "\f678"
}

.fa-motorcycle:before {
    content: "\f21c"
}

.fa-mountain:before {
    content: "\f6fc"
}

.fa-mouse:before {
    content: "\f8cc"
}

.fa-mouse-pointer:before {
    content: "\f245"
}

.fa-mug-hot:before {
    content: "\f7b6"
}

.fa-music:before {
    content: "\f001"
}

.fa-napster:before {
    content: "\f3d2"
}

.fa-neos:before {
    content: "\f612"
}

.fa-network-wired:before {
    content: "\f6ff"
}

.fa-neuter:before {
    content: "\f22c"
}

.fa-newspaper:before {
    content: "\f1ea"
}

.fa-nimblr:before {
    content: "\f5a8"
}

.fa-node:before {
    content: "\f419"
}

.fa-node-js:before {
    content: "\f3d3"
}

.fa-not-equal:before {
    content: "\f53e"
}

.fa-notes-medical:before {
    content: "\f481"
}

.fa-npm:before {
    content: "\f3d4"
}

.fa-ns8:before {
    content: "\f3d5"
}

.fa-nutritionix:before {
    content: "\f3d6"
}

.fa-object-group:before {
    content: "\f247"
}

.fa-object-ungroup:before {
    content: "\f248"
}

.fa-octopus-deploy:before {
    content: "\e082"
}

.fa-odnoklassniki:before {
    content: "\f263"
}

.fa-odnoklassniki-square:before {
    content: "\f264"
}

.fa-oil-can:before {
    content: "\f613"
}

.fa-old-republic:before {
    content: "\f510"
}

.fa-om:before {
    content: "\f679"
}

.fa-opencart:before {
    content: "\f23d"
}

.fa-openid:before {
    content: "\f19b"
}

.fa-opera:before {
    content: "\f26a"
}

.fa-optin-monster:before {
    content: "\f23c"
}

.fa-orcid:before {
    content: "\f8d2"
}

.fa-osi:before {
    content: "\f41a"
}

.fa-otter:before {
    content: "\f700"
}

.fa-outdent:before {
    content: "\f03b"
}

.fa-page4:before {
    content: "\f3d7"
}

.fa-pagelines:before {
    content: "\f18c"
}

.fa-pager:before {
    content: "\f815"
}

.fa-paint-brush:before {
    content: "\f1fc"
}

.fa-paint-roller:before {
    content: "\f5aa"
}

.fa-palette:before {
    content: "\f53f"
}

.fa-palfed:before {
    content: "\f3d8"
}

.fa-pallet:before {
    content: "\f482"
}

.fa-paper-plane:before {
    content: "\f1d8"
}

.fa-paperclip:before {
    content: "\f0c6"
}

.fa-parachute-box:before {
    content: "\f4cd"
}

.fa-paragraph:before {
    content: "\f1dd"
}

.fa-parking:before {
    content: "\f540"
}

.fa-passport:before {
    content: "\f5ab"
}

.fa-pastafarianism:before {
    content: "\f67b"
}

.fa-paste:before {
    content: "\f0ea"
}

.fa-patreon:before {
    content: "\f3d9"
}

.fa-pause:before {
    content: "\f04c"
}

.fa-pause-circle:before {
    content: "\f28b"
}

.fa-paw:before {
    content: "\f1b0"
}

.fa-paypal:before {
    content: "\f1ed"
}

.fa-peace:before {
    content: "\f67c"
}

.fa-pen:before {
    content: "\f304"
}

.fa-pen-alt:before {
    content: "\f305"
}

.fa-pen-fancy:before {
    content: "\f5ac"
}

.fa-pen-nib:before {
    content: "\f5ad"
}

.fa-pen-square:before {
    content: "\f14b"
}

.fa-pencil-alt:before {
    content: "\f303"
}

.fa-pencil-ruler:before {
    content: "\f5ae"
}

.fa-penny-arcade:before {
    content: "\f704"
}

.fa-people-arrows:before {
    content: "\e068"
}

.fa-people-carry:before {
    content: "\f4ce"
}

.fa-pepper-hot:before {
    content: "\f816"
}

.fa-perbyte:before {
    content: "\e083"
}

.fa-percent:before {
    content: "\f295"
}

.fa-percentage:before {
    content: "\f541"
}

.fa-periscope:before {
    content: "\f3da"
}

.fa-person-booth:before {
    content: "\f756"
}

.fa-phabricator:before {
    content: "\f3db"
}

.fa-phoenix-framework:before {
    content: "\f3dc"
}

.fa-phoenix-squadron:before {
    content: "\f511"
}

.fa-phone:before {
    content: "\f095"
}

.fa-phone-alt:before {
    content: "\f879"
}

.fa-phone-slash:before {
    content: "\f3dd"
}

.fa-phone-square:before {
    content: "\f098"
}

.fa-phone-square-alt:before {
    content: "\f87b"
}

.fa-phone-volume:before {
    content: "\f2a0"
}

.fa-photo-video:before {
    content: "\f87c"
}

.fa-php:before {
    content: "\f457"
}

.fa-pied-piper:before {
    content: "\f2ae"
}

.fa-pied-piper-alt:before {
    content: "\f1a8"
}

.fa-pied-piper-hat:before {
    content: "\f4e5"
}

.fa-pied-piper-pp:before {
    content: "\f1a7"
}

.fa-pied-piper-square:before {
    content: "\e01e"
}

.fa-piggy-bank:before {
    content: "\f4d3"
}

.fa-pills:before {
    content: "\f484"
}

.fa-pinterest:before {
    content: "\f0d2"
}

.fa-pinterest-p:before {
    content: "\f231"
}

.fa-pinterest-square:before {
    content: "\f0d3"
}

.fa-pizza-slice:before {
    content: "\f818"
}

.fa-place-of-worship:before {
    content: "\f67f"
}

.fa-plane:before {
    content: "\f072"
}

.fa-plane-arrival:before {
    content: "\f5af"
}

.fa-plane-departure:before {
    content: "\f5b0"
}

.fa-plane-slash:before {
    content: "\e069"
}

.fa-play:before {
    content: "\f04b"
}

.fa-play-circle:before {
    content: "\f144"
}

.fa-playstation:before {
    content: "\f3df"
}

.fa-plug:before {
    content: "\f1e6"
}

.fa-plus:before {
    content: "\f067"
}

.fa-plus-circle:before {
    content: "\f055"
}

.fa-plus-square:before {
    content: "\f0fe"
}

.fa-podcast:before {
    content: "\f2ce"
}

.fa-poll:before {
    content: "\f681"
}

.fa-poll-h:before {
    content: "\f682"
}

.fa-poo:before {
    content: "\f2fe"
}

.fa-poo-storm:before {
    content: "\f75a"
}

.fa-poop:before {
    content: "\f619"
}

.fa-portrait:before {
    content: "\f3e0"
}

.fa-pound-sign:before {
    content: "\f154"
}

.fa-power-off:before {
    content: "\f011"
}

.fa-pray:before {
    content: "\f683"
}

.fa-praying-hands:before {
    content: "\f684"
}

.fa-prescription:before {
    content: "\f5b1"
}

.fa-prescription-bottle:before {
    content: "\f485"
}

.fa-prescription-bottle-alt:before {
    content: "\f486"
}

.fa-print:before {
    content: "\f02f"
}

.fa-procedures:before {
    content: "\f487"
}

.fa-product-hunt:before {
    content: "\f288"
}

.fa-project-diagram:before {
    content: "\f542"
}

.fa-pump-medical:before {
    content: "\e06a"
}

.fa-pump-soap:before {
    content: "\e06b"
}

.fa-pushed:before {
    content: "\f3e1"
}

.fa-puzzle-piece:before {
    content: "\f12e"
}

.fa-python:before {
    content: "\f3e2"
}

.fa-qq:before {
    content: "\f1d6"
}

.fa-qrcode:before {
    content: "\f029"
}

.fa-question:before {
    content: "\f128"
}

.fa-question-circle:before {
    content: "\f059"
}

.fa-quidditch:before {
    content: "\f458"
}

.fa-quinscape:before {
    content: "\f459"
}

.fa-quora:before {
    content: "\f2c4"
}

.fa-quote-left:before {
    content: "\f10d"
}

.fa-quote-right:before {
    content: "\f10e"
}

.fa-quran:before {
    content: "\f687"
}

.fa-r-project:before {
    content: "\f4f7"
}

.fa-radiation:before {
    content: "\f7b9"
}

.fa-radiation-alt:before {
    content: "\f7ba"
}

.fa-rainbow:before {
    content: "\f75b"
}

.fa-random:before {
    content: "\f074"
}

.fa-raspberry-pi:before {
    content: "\f7bb"
}

.fa-ravelry:before {
    content: "\f2d9"
}

.fa-react:before {
    content: "\f41b"
}

.fa-reacteurope:before {
    content: "\f75d"
}

.fa-readme:before {
    content: "\f4d5"
}

.fa-rebel:before {
    content: "\f1d0"
}

.fa-receipt:before {
    content: "\f543"
}

.fa-record-vinyl:before {
    content: "\f8d9"
}

.fa-recycle:before {
    content: "\f1b8"
}

.fa-red-river:before {
    content: "\f3e3"
}

.fa-reddit:before {
    content: "\f1a1"
}

.fa-reddit-alien:before {
    content: "\f281"
}

.fa-reddit-square:before {
    content: "\f1a2"
}

.fa-redhat:before {
    content: "\f7bc"
}

.fa-redo:before {
    content: "\f01e"
}

.fa-redo-alt:before {
    content: "\f2f9"
}

.fa-registered:before {
    content: "\f25d"
}

.fa-remove-format:before {
    content: "\f87d"
}

.fa-renren:before {
    content: "\f18b"
}

.fa-reply:before {
    content: "\f3e5"
}

.fa-reply-all:before {
    content: "\f122"
}

.fa-replyd:before {
    content: "\f3e6"
}

.fa-republican:before {
    content: "\f75e"
}

.fa-researchgate:before {
    content: "\f4f8"
}

.fa-resolving:before {
    content: "\f3e7"
}

.fa-restroom:before {
    content: "\f7bd"
}

.fa-retweet:before {
    content: "\f079"
}

.fa-rev:before {
    content: "\f5b2"
}

.fa-ribbon:before {
    content: "\f4d6"
}

.fa-ring:before {
    content: "\f70b"
}

.fa-road:before {
    content: "\f018"
}

.fa-robot:before {
    content: "\f544"
}

.fa-rocket:before {
    content: "\f135"
}

.fa-rocketchat:before {
    content: "\f3e8"
}

.fa-rockrms:before {
    content: "\f3e9"
}

.fa-route:before {
    content: "\f4d7"
}

.fa-rss:before {
    content: "\f09e"
}

.fa-rss-square:before {
    content: "\f143"
}

.fa-ruble-sign:before {
    content: "\f158"
}

.fa-ruler:before {
    content: "\f545"
}

.fa-ruler-combined:before {
    content: "\f546"
}

.fa-ruler-horizontal:before {
    content: "\f547"
}

.fa-ruler-vertical:before {
    content: "\f548"
}

.fa-running:before {
    content: "\f70c"
}

.fa-rupee-sign:before {
    content: "\f156"
}

.fa-rust:before {
    content: "\e07a"
}

.fa-sad-cry:before {
    content: "\f5b3"
}

.fa-sad-tear:before {
    content: "\f5b4"
}

.fa-safari:before {
    content: "\f267"
}

.fa-salesforce:before {
    content: "\f83b"
}

.fa-sass:before {
    content: "\f41e"
}

.fa-satellite:before {
    content: "\f7bf"
}

.fa-satellite-dish:before {
    content: "\f7c0"
}

.fa-save:before {
    content: "\f0c7"
}

.fa-schlix:before {
    content: "\f3ea"
}

.fa-school:before {
    content: "\f549"
}

.fa-screwdriver:before {
    content: "\f54a"
}

.fa-scribd:before {
    content: "\f28a"
}

.fa-scroll:before {
    content: "\f70e"
}

.fa-sd-card:before {
    content: "\f7c2"
}

.fa-search:before {
    content: "\f002"
}

.fa-search-dollar:before {
    content: "\f688"
}

.fa-search-location:before {
    content: "\f689"
}

.fa-search-minus:before {
    content: "\f010"
}

.fa-search-plus:before {
    content: "\f00e"
}

.fa-searchengin:before {
    content: "\f3eb"
}

.fa-seedling:before {
    content: "\f4d8"
}

.fa-sellcast:before {
    content: "\f2da"
}

.fa-sellsy:before {
    content: "\f213"
}

.fa-server:before {
    content: "\f233"
}

.fa-servicestack:before {
    content: "\f3ec"
}

.fa-shapes:before {
    content: "\f61f"
}

.fa-share:before {
    content: "\f064"
}

.fa-share-alt:before {
    content: "\f1e0"
}

.fa-share-alt-square:before {
    content: "\f1e1"
}

.fa-share-square:before {
    content: "\f14d"
}

.fa-shekel-sign:before {
    content: "\f20b"
}

.fa-shield-alt:before {
    content: "\f3ed"
}

.fa-shield-virus:before {
    content: "\e06c"
}

.fa-ship:before {
    content: "\f21a"
}

.fa-shipping-fast:before {
    content: "\f48b"
}

.fa-shirtsinbulk:before {
    content: "\f214"
}

.fa-shoe-prints:before {
    content: "\f54b"
}

.fa-shopify:before {
    content: "\e057"
}

.fa-shopping-bag:before {
    content: "\f290"
}

.fa-shopping-basket:before {
    content: "\f291"
}

.fa-shopping-cart:before {
    content: "\f07a"
}

.fa-shopware:before {
    content: "\f5b5"
}

.fa-shower:before {
    content: "\f2cc"
}

.fa-shuttle-van:before {
    content: "\f5b6"
}

.fa-sign:before {
    content: "\f4d9"
}

.fa-sign-in-alt:before {
    content: "\f2f6"
}

.fa-sign-language:before {
    content: "\f2a7"
}

.fa-sign-out-alt:before {
    content: "\f2f5"
}

.fa-signal:before {
    content: "\f012"
}

.fa-signature:before {
    content: "\f5b7"
}

.fa-sim-card:before {
    content: "\f7c4"
}

.fa-simplybuilt:before {
    content: "\f215"
}

.fa-sink:before {
    content: "\e06d"
}

.fa-sistrix:before {
    content: "\f3ee"
}

.fa-sitemap:before {
    content: "\f0e8"
}

.fa-sith:before {
    content: "\f512"
}

.fa-skating:before {
    content: "\f7c5"
}

.fa-sketch:before {
    content: "\f7c6"
}

.fa-skiing:before {
    content: "\f7c9"
}

.fa-skiing-nordic:before {
    content: "\f7ca"
}

.fa-skull:before {
    content: "\f54c"
}

.fa-skull-crossbones:before {
    content: "\f714"
}

.fa-skyatlas:before {
    content: "\f216"
}

.fa-skype:before {
    content: "\f17e"
}

.fa-slack:before {
    content: "\f198"
}

.fa-slack-hash:before {
    content: "\f3ef"
}

.fa-slash:before {
    content: "\f715"
}

.fa-sleigh:before {
    content: "\f7cc"
}

.fa-sliders-h:before {
    content: "\f1de"
}

.fa-slideshare:before {
    content: "\f1e7"
}

.fa-smile:before {
    content: "\f118"
}

.fa-smile-beam:before {
    content: "\f5b8"
}

.fa-smile-wink:before {
    content: "\f4da"
}

.fa-smog:before {
    content: "\f75f"
}

.fa-smoking:before {
    content: "\f48d"
}

.fa-smoking-ban:before {
    content: "\f54d"
}

.fa-sms:before {
    content: "\f7cd"
}

.fa-snapchat:before {
    content: "\f2ab"
}

.fa-snapchat-ghost:before {
    content: "\f2ac"
}

.fa-snapchat-square:before {
    content: "\f2ad"
}

.fa-snowboarding:before {
    content: "\f7ce"
}

.fa-snowflake:before {
    content: "\f2dc"
}

.fa-snowman:before {
    content: "\f7d0"
}

.fa-snowplow:before {
    content: "\f7d2"
}

.fa-soap:before {
    content: "\e06e"
}

.fa-socks:before {
    content: "\f696"
}

.fa-solar-panel:before {
    content: "\f5ba"
}

.fa-sort:before {
    content: "\f0dc"
}

.fa-sort-alpha-down:before {
    content: "\f15d"
}

.fa-sort-alpha-down-alt:before {
    content: "\f881"
}

.fa-sort-alpha-up:before {
    content: "\f15e"
}

.fa-sort-alpha-up-alt:before {
    content: "\f882"
}

.fa-sort-amount-down:before {
    content: "\f160"
}

.fa-sort-amount-down-alt:before {
    content: "\f884"
}

.fa-sort-amount-up:before {
    content: "\f161"
}

.fa-sort-amount-up-alt:before {
    content: "\f885"
}

.fa-sort-down:before {
    content: "\f0dd"
}

.fa-sort-numeric-down:before {
    content: "\f162"
}

.fa-sort-numeric-down-alt:before {
    content: "\f886"
}

.fa-sort-numeric-up:before {
    content: "\f163"
}

.fa-sort-numeric-up-alt:before {
    content: "\f887"
}

.fa-sort-up:before {
    content: "\f0de"
}

.fa-soundcloud:before {
    content: "\f1be"
}

.fa-sourcetree:before {
    content: "\f7d3"
}

.fa-spa:before {
    content: "\f5bb"
}

.fa-space-shuttle:before {
    content: "\f197"
}

.fa-speakap:before {
    content: "\f3f3"
}

.fa-speaker-deck:before {
    content: "\f83c"
}

.fa-spell-check:before {
    content: "\f891"
}

.fa-spider:before {
    content: "\f717"
}

.fa-spinner:before {
    content: "\f110"
}

.fa-splotch:before {
    content: "\f5bc"
}

.fa-spotify:before {
    content: "\f1bc"
}

.fa-spray-can:before {
    content: "\f5bd"
}

.fa-square:before {
    content: "\f0c8"
}

.fa-square-full:before {
    content: "\f45c"
}

.fa-square-root-alt:before {
    content: "\f698"
}

.fa-squarespace:before {
    content: "\f5be"
}

.fa-stack-exchange:before {
    content: "\f18d"
}

.fa-stack-overflow:before {
    content: "\f16c"
}

.fa-stackpath:before {
    content: "\f842"
}

.fa-stamp:before {
    content: "\f5bf"
}

.fa-star:before {
    content: "\f005"
}

.fa-star-and-crescent:before {
    content: "\f699"
}

.fa-star-half:before {
    content: "\f089"
}

.fa-star-half-alt:before {
    content: "\f5c0"
}

.fa-star-of-david:before {
    content: "\f69a"
}

.fa-star-of-life:before {
    content: "\f621"
}

.fa-staylinked:before {
    content: "\f3f5"
}

.fa-steam:before {
    content: "\f1b6"
}

.fa-steam-square:before {
    content: "\f1b7"
}

.fa-steam-symbol:before {
    content: "\f3f6"
}

.fa-step-backward:before {
    content: "\f048"
}

.fa-step-forward:before {
    content: "\f051"
}

.fa-stethoscope:before {
    content: "\f0f1"
}

.fa-sticker-mule:before {
    content: "\f3f7"
}

.fa-sticky-note:before {
    content: "\f249"
}

.fa-stop:before {
    content: "\f04d"
}

.fa-stop-circle:before {
    content: "\f28d"
}

.fa-stopwatch:before {
    content: "\f2f2"
}

.fa-stopwatch-20:before {
    content: "\e06f"
}

.fa-store:before {
    content: "\f54e"
}

.fa-store-alt:before {
    content: "\f54f"
}

.fa-store-alt-slash:before {
    content: "\e070"
}

.fa-store-slash:before {
    content: "\e071"
}

.fa-strava:before {
    content: "\f428"
}

.fa-stream:before {
    content: "\f550"
}

.fa-street-view:before {
    content: "\f21d"
}

.fa-strikethrough:before {
    content: "\f0cc"
}

.fa-stripe:before {
    content: "\f429"
}

.fa-stripe-s:before {
    content: "\f42a"
}

.fa-stroopwafel:before {
    content: "\f551"
}

.fa-studiovinari:before {
    content: "\f3f8"
}

.fa-stumbleupon:before {
    content: "\f1a4"
}

.fa-stumbleupon-circle:before {
    content: "\f1a3"
}

.fa-subscript:before {
    content: "\f12c"
}

.fa-subway:before {
    content: "\f239"
}

.fa-suitcase:before {
    content: "\f0f2"
}

.fa-suitcase-rolling:before {
    content: "\f5c1"
}

.fa-sun:before {
    content: "\f185"
}

.fa-superpowers:before {
    content: "\f2dd"
}

.fa-superscript:before {
    content: "\f12b"
}

.fa-supple:before {
    content: "\f3f9"
}

.fa-surprise:before {
    content: "\f5c2"
}

.fa-suse:before {
    content: "\f7d6"
}

.fa-swatchbook:before {
    content: "\f5c3"
}

.fa-swift:before {
    content: "\f8e1"
}

.fa-swimmer:before {
    content: "\f5c4"
}

.fa-swimming-pool:before {
    content: "\f5c5"
}

.fa-symfony:before {
    content: "\f83d"
}

.fa-synagogue:before {
    content: "\f69b"
}

.fa-sync:before {
    content: "\f021"
}

.fa-sync-alt:before {
    content: "\f2f1"
}

.fa-syringe:before {
    content: "\f48e"
}

.fa-table:before {
    content: "\f0ce"
}

.fa-table-tennis:before {
    content: "\f45d"
}

.fa-tablet:before {
    content: "\f10a"
}

.fa-tablet-alt:before {
    content: "\f3fa"
}

.fa-tablets:before {
    content: "\f490"
}

.fa-tachometer-alt:before {
    content: "\f3fd"
}

.fa-tag:before {
    content: "\f02b"
}

.fa-tags:before {
    content: "\f02c"
}

.fa-tape:before {
    content: "\f4db"
}

.fa-tasks:before {
    content: "\f0ae"
}

.fa-taxi:before {
    content: "\f1ba"
}

.fa-teamspeak:before {
    content: "\f4f9"
}

.fa-teeth:before {
    content: "\f62e"
}

.fa-teeth-open:before {
    content: "\f62f"
}

.fa-telegram:before {
    content: "\f2c6"
}

.fa-telegram-plane:before {
    content: "\f3fe"
}

.fa-temperature-high:before {
    content: "\f769"
}

.fa-temperature-low:before {
    content: "\f76b"
}

.fa-tencent-weibo:before {
    content: "\f1d5"
}

.fa-tenge:before {
    content: "\f7d7"
}

.fa-terminal:before {
    content: "\f120"
}

.fa-text-height:before {
    content: "\f034"
}

.fa-text-width:before {
    content: "\f035"
}

.fa-th:before {
    content: "\f00a"
}

.fa-th-large:before {
    content: "\f009"
}

.fa-th-list:before {
    content: "\f00b"
}

.fa-the-red-yeti:before {
    content: "\f69d"
}

.fa-theater-masks:before {
    content: "\f630"
}

.fa-themeco:before {
    content: "\f5c6"
}

.fa-themeisle:before {
    content: "\f2b2"
}

.fa-thermometer:before {
    content: "\f491"
}

.fa-thermometer-empty:before {
    content: "\f2cb"
}

.fa-thermometer-full:before {
    content: "\f2c7"
}

.fa-thermometer-half:before {
    content: "\f2c9"
}

.fa-thermometer-quarter:before {
    content: "\f2ca"
}

.fa-thermometer-three-quarters:before {
    content: "\f2c8"
}

.fa-think-peaks:before {
    content: "\f731"
}

.fa-thumbs-down:before {
    content: "\f165"
}

.fa-thumbs-up:before {
    content: "\f164"
}

.fa-thumbtack:before {
    content: "\f08d"
}

.fa-ticket-alt:before {
    content: "\f3ff"
}

.fa-tiktok:before {
    content: "\e07b"
}

.fa-times:before {
    content: "\f00d"
}

.fa-times-circle:before {
    content: "\f057"
}

.fa-tint:before {
    content: "\f043"
}

.fa-tint-slash:before {
    content: "\f5c7"
}

.fa-tired:before {
    content: "\f5c8"
}

.fa-toggle-off:before {
    content: "\f204"
}

.fa-toggle-on:before {
    content: "\f205"
}

.fa-toilet:before {
    content: "\f7d8"
}

.fa-toilet-paper:before {
    content: "\f71e"
}

.fa-toilet-paper-slash:before {
    content: "\e072"
}

.fa-toolbox:before {
    content: "\f552"
}

.fa-tools:before {
    content: "\f7d9"
}

.fa-tooth:before {
    content: "\f5c9"
}

.fa-torah:before {
    content: "\f6a0"
}

.fa-torii-gate:before {
    content: "\f6a1"
}

.fa-tractor:before {
    content: "\f722"
}

.fa-trade-federation:before {
    content: "\f513"
}

.fa-trademark:before {
    content: "\f25c"
}

.fa-traffic-light:before {
    content: "\f637"
}

.fa-trailer:before {
    content: "\e041"
}

.fa-train:before {
    content: "\f238"
}

.fa-tram:before {
    content: "\f7da"
}

.fa-transgender:before {
    content: "\f224"
}

.fa-transgender-alt:before {
    content: "\f225"
}

.fa-trash:before {
    content: "\f1f8"
}

.fa-trash-alt:before {
    content: "\f2ed"
}

.fa-trash-restore:before {
    content: "\f829"
}

.fa-trash-restore-alt:before {
    content: "\f82a"
}

.fa-tree:before {
    content: "\f1bb"
}

.fa-trello:before {
    content: "\f181"
}

.fa-trophy:before {
    content: "\f091"
}

.fa-truck:before {
    content: "\f0d1"
}

.fa-truck-loading:before {
    content: "\f4de"
}

.fa-truck-monster:before {
    content: "\f63b"
}

.fa-truck-moving:before {
    content: "\f4df"
}

.fa-truck-pickup:before {
    content: "\f63c"
}

.fa-tshirt:before {
    content: "\f553"
}

.fa-tty:before {
    content: "\f1e4"
}

.fa-tumblr:before {
    content: "\f173"
}

.fa-tumblr-square:before {
    content: "\f174"
}

.fa-tv:before {
    content: "\f26c"
}

.fa-twitch:before {
    content: "\f1e8"
}

.fa-twitter:before {
    content: "\f099"
}

.fa-twitter-square:before {
    content: "\f081"
}

.fa-typo3:before {
    content: "\f42b"
}

.fa-uber:before {
    content: "\f402"
}

.fa-ubuntu:before {
    content: "\f7df"
}

.fa-uikit:before {
    content: "\f403"
}

.fa-umbraco:before {
    content: "\f8e8"
}

.fa-umbrella:before {
    content: "\f0e9"
}

.fa-umbrella-beach:before {
    content: "\f5ca"
}

.fa-uncharted:before {
    content: "\e084"
}

.fa-underline:before {
    content: "\f0cd"
}

.fa-undo:before {
    content: "\f0e2"
}

.fa-undo-alt:before {
    content: "\f2ea"
}

.fa-uniregistry:before {
    content: "\f404"
}

.fa-unity:before {
    content: "\e049"
}

.fa-universal-access:before {
    content: "\f29a"
}

.fa-university:before {
    content: "\f19c"
}

.fa-unlink:before {
    content: "\f127"
}

.fa-unlock:before {
    content: "\f09c"
}

.fa-unlock-alt:before {
    content: "\f13e"
}

.fa-unsplash:before {
    content: "\e07c"
}

.fa-untappd:before {
    content: "\f405"
}

.fa-upload:before {
    content: "\f093"
}

.fa-ups:before {
    content: "\f7e0"
}

.fa-usb:before {
    content: "\f287"
}

.fa-user:before {
    content: "\f007"
}

.fa-user-alt:before {
    content: "\f406"
}

.fa-user-alt-slash:before {
    content: "\f4fa"
}

.fa-user-astronaut:before {
    content: "\f4fb"
}

.fa-user-check:before {
    content: "\f4fc"
}

.fa-user-circle:before {
    content: "\f2bd"
}

.fa-user-clock:before {
    content: "\f4fd"
}

.fa-user-cog:before {
    content: "\f4fe"
}

.fa-user-edit:before {
    content: "\f4ff"
}

.fa-user-friends:before {
    content: "\f500"
}

.fa-user-graduate:before {
    content: "\f501"
}

.fa-user-injured:before {
    content: "\f728"
}

.fa-user-lock:before {
    content: "\f502"
}

.fa-user-md:before {
    content: "\f0f0"
}

.fa-user-minus:before {
    content: "\f503"
}

.fa-user-ninja:before {
    content: "\f504"
}

.fa-user-nurse:before {
    content: "\f82f"
}

.fa-user-plus:before {
    content: "\f234"
}

.fa-user-secret:before {
    content: "\f21b"
}

.fa-user-shield:before {
    content: "\f505"
}

.fa-user-slash:before {
    content: "\f506"
}

.fa-user-tag:before {
    content: "\f507"
}

.fa-user-tie:before {
    content: "\f508"
}

.fa-user-times:before {
    content: "\f235"
}

.fa-users:before {
    content: "\f0c0"
}

.fa-users-cog:before {
    content: "\f509"
}

.fa-users-slash:before {
    content: "\e073"
}

.fa-usps:before {
    content: "\f7e1"
}

.fa-ussunnah:before {
    content: "\f407"
}

.fa-utensil-spoon:before {
    content: "\f2e5"
}

.fa-utensils:before {
    content: "\f2e7"
}

.fa-vaadin:before {
    content: "\f408"
}

.fa-vector-square:before {
    content: "\f5cb"
}

.fa-venus:before {
    content: "\f221"
}

.fa-venus-double:before {
    content: "\f226"
}

.fa-venus-mars:before {
    content: "\f228"
}

.fa-vest:before {
    content: "\e085"
}

.fa-vest-patches:before {
    content: "\e086"
}

.fa-viacoin:before {
    content: "\f237"
}

.fa-viadeo:before {
    content: "\f2a9"
}

.fa-viadeo-square:before {
    content: "\f2aa"
}

.fa-vial:before {
    content: "\f492"
}

.fa-vials:before {
    content: "\f493"
}

.fa-viber:before {
    content: "\f409"
}

.fa-video:before {
    content: "\f03d"
}

.fa-video-slash:before {
    content: "\f4e2"
}

.fa-vihara:before {
    content: "\f6a7"
}

.fa-vimeo:before {
    content: "\f40a"
}

.fa-vimeo-square:before {
    content: "\f194"
}

.fa-vimeo-v:before {
    content: "\f27d"
}

.fa-vine:before {
    content: "\f1ca"
}

.fa-virus:before {
    content: "\e074"
}

.fa-virus-slash:before {
    content: "\e075"
}

.fa-viruses:before {
    content: "\e076"
}

.fa-vk:before {
    content: "\f189"
}

.fa-vnv:before {
    content: "\f40b"
}

.fa-voicemail:before {
    content: "\f897"
}

.fa-volleyball-ball:before {
    content: "\f45f"
}

.fa-volume-down:before {
    content: "\f027"
}

.fa-volume-mute:before {
    content: "\f6a9"
}

.fa-volume-off:before {
    content: "\f026"
}

.fa-volume-up:before {
    content: "\f028"
}

.fa-vote-yea:before {
    content: "\f772"
}

.fa-vr-cardboard:before {
    content: "\f729"
}

.fa-vuejs:before {
    content: "\f41f"
}

.fa-walking:before {
    content: "\f554"
}

.fa-wallet:before {
    content: "\f555"
}

.fa-warehouse:before {
    content: "\f494"
}

.fa-watchman-monitoring:before {
    content: "\e087"
}

.fa-water:before {
    content: "\f773"
}

.fa-wave-square:before {
    content: "\f83e"
}

.fa-waze:before {
    content: "\f83f"
}

.fa-weebly:before {
    content: "\f5cc"
}

.fa-weibo:before {
    content: "\f18a"
}

.fa-weight:before {
    content: "\f496"
}

.fa-weight-hanging:before {
    content: "\f5cd"
}

.fa-weixin:before {
    content: "\f1d7"
}

.fa-whatsapp:before {
    content: "\f232"
}

.fa-whatsapp-square:before {
    content: "\f40c"
}

.fa-wheelchair:before {
    content: "\f193"
}

.fa-whmcs:before {
    content: "\f40d"
}

.fa-wifi:before {
    content: "\f1eb"
}

.fa-wikipedia-w:before {
    content: "\f266"
}

.fa-wind:before {
    content: "\f72e"
}

.fa-window-close:before {
    content: "\f410"
}

.fa-window-maximize:before {
    content: "\f2d0"
}

.fa-window-minimize:before {
    content: "\f2d1"
}

.fa-window-restore:before {
    content: "\f2d2"
}

.fa-windows:before {
    content: "\f17a"
}

.fa-wine-bottle:before {
    content: "\f72f"
}

.fa-wine-glass:before {
    content: "\f4e3"
}

.fa-wine-glass-alt:before {
    content: "\f5ce"
}

.fa-wix:before {
    content: "\f5cf"
}

.fa-wizards-of-the-coast:before {
    content: "\f730"
}

.fa-wodu:before {
    content: "\e088"
}

.fa-wolf-pack-battalion:before {
    content: "\f514"
}

.fa-won-sign:before {
    content: "\f159"
}

.fa-wordpress:before {
    content: "\f19a"
}

.fa-wordpress-simple:before {
    content: "\f411"
}

.fa-wpbeginner:before {
    content: "\f297"
}

.fa-wpexplorer:before {
    content: "\f2de"
}

.fa-wpforms:before {
    content: "\f298"
}

.fa-wpressr:before {
    content: "\f3e4"
}

.fa-wrench:before {
    content: "\f0ad"
}

.fa-x-ray:before {
    content: "\f497"
}

.fa-xbox:before {
    content: "\f412"
}

.fa-xing:before {
    content: "\f168"
}

.fa-xing-square:before {
    content: "\f169"
}

.fa-y-combinator:before {
    content: "\f23b"
}

.fa-yahoo:before {
    content: "\f19e"
}

.fa-yammer:before {
    content: "\f840"
}

.fa-yandex:before {
    content: "\f413"
}

.fa-yandex-international:before {
    content: "\f414"
}

.fa-yarn:before {
    content: "\f7e3"
}

.fa-yelp:before {
    content: "\f1e9"
}

.fa-yen-sign:before {
    content: "\f157"
}

.fa-yin-yang:before {
    content: "\f6ad"
}

.fa-yoast:before {
    content: "\f2b1"
}

.fa-youtube:before {
    content: "\f167"
}

.fa-youtube-square:before {
    content: "\f431"
}

.fa-zhihu:before {
    content: "\f63f"
}

.sr-only {
    border: 0;
    clip: rect(0,0,0,0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px
}

.sr-only-focusable:active,.sr-only-focusable:focus {
    clip: auto;
    height: auto;
    margin: 0;
    overflow: visible;
    position: static;
    width: auto
}

@font-face {
    font-family: "Font Awesome 5 Brands";
    font-style: normal;
    font-weight: 400;
    font-display: block;
    src: url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-brands-400.eot);
    src: url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-brands-400.eot?#iefix) format("embedded-opentype"),url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-brands-400.woff2) format("woff2"),url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-brands-400.woff) format("woff"),url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-brands-400.ttf) format("truetype"),url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-brands-400.svg#fontawesome) format("svg")
}

.fab {
    font-family: "Font Awesome 5 Brands"
}

@font-face {
    font-family: "Font Awesome 5 Free";
    font-style: normal;
    font-weight: 400;
    font-display: block;
    src: url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-regular-400.eot);
    src: url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-regular-400.eot?#iefix) format("embedded-opentype"),url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-regular-400.woff2) format("woff2"),url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-regular-400.woff) format("woff"),url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-regular-400.ttf) format("truetype"),url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-regular-400.svg#fontawesome) format("svg")
}

.fab,.far {
    font-weight: 400
}

@font-face {
    font-family: "Font Awesome 5 Free";
    font-style: normal;
    font-weight: 900;
    font-display: block;
    src: url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-solid-900.eot);
    src: url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-solid-900.eot?#iefix) format("embedded-opentype"),url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-solid-900.woff2) format("woff2"),url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-solid-900.woff) format("woff"),url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-solid-900.ttf) format("truetype"),url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/fontawesome/webfonts/fa-solid-900.svg#fontawesome) format("svg")
}

.fa,.far,.fas {
    font-family: "Font Awesome 5 Free"
}

.fa,.fas {
    font-weight: 900
}

.flex-video {
    position: relative;
    padding-top: 25px;
    padding-bottom: 67.5%;
    height: 0;
    margin-bottom: 16px;
    overflow: hidden;
}

.flex-video.widescreen {
    padding-bottom: 57.25%;
}

.flex-video.vimeo {
    padding-top: 0;
}

.flex-video iframe, .flex-video object, .flex-video embed {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

@media only screen and (max-device-width: 800px), only screen and (device-width: 1024px) and (device-height: 600px), only screen and (width: 1280px) and (orientation: landscape), only screen and (device-width: 800px), only screen and (max-width: 767px) {
    .flex-video {
        padding-top: 0;
    }
}

.wp-block-embed embed, .wp-block-embed iframe, .wp-block-embed object {
    max-width: 100%;
}

.pagination {
    margin: 0;
}

.pagination-center {
    text-align: center;
}

.pagination-row {
    margin-bottom: 20px;
}

.page-header {
    margin-bottom: 20px;
}

.page-header-top-right {
    margin-top: 10px;
}

.post-view-attachment .entry-attachment .attachment {
    text-align: center;
}

.post-view-attachment .entry-attachment .attachment .card {
    margin: 0 auto;
    width: 400px;
}

.post-view-attachment .entry-attachment .attachment .wp-video {
    margin: 0 auto;
}

.row-with-vspace {
    margin-bottom: 20px;
}

.site-footer {
    background-color: #f5f5f5;
    border-top: 3px solid #ddd;
    font-size: 12px;
    padding: 10px;
}

.site-main .format-aside {
    background: #f5f5f5;
}

.site-main .format-image {
    background: url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/img/content-post-format-image.png) left top no-repeat;
}

.site-main .format-link {
    background: url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/img/content-post-format-link.png) left top no-repeat;
}

.site-main .format-quote {
    background: url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/img/content-post-format-quote.png) left top no-repeat;
}

.site-main .format-video {
    background: url(//beinsport.biz/wp-content/themes/bootstrap-basic4/assets/img/content-post-format-video.png) left top no-repeat;
}

.site-title {
    margin-bottom: 0;
    margin-top: 10px;
}

.site-title > a {
    text-decoration: none;
}

.site-title > div {
    height: auto;
    line-height: 18px;
}

.site-title .site-description {
    color: #999;
    font-size: 16px;
}

.site-title .site-title-heading {
    margin: 0;
}

.widget_calendar .calendar_wrap table {
    font-size: 14px;
    margin: 0;
}

.widget_calendar .calendar_wrap table caption {
    caption-side: top;
}

.widget_calendar .calendar_wrap .table td, .widget_calendar .calendar_wrap .table th {
    padding: 8px;
}

.widget_calendar .calendar_wrap .table #next {
    text-align: right;
}

#comments .comment-navigation, #comments .comment-navigation-below {
    margin-bottom: 20px;
    margin-top: 15px;
}

#comments .comment-navigation {
    list-style: none;
    margin-top: 0;
    padding: 0;
}

#comments .comment-respond {
    margin-top: 20px;
}

#comments .media-list li .media {
    margin-top: 15px;
}

#comments .media-list li .media .media-body {
    border: 1px solid #eee;
    padding: 10px;
}

#comments .media-list li .media .media-body .comment-author {
    font-size: 12px;
    margin-bottom: 10px;
}

#comments .media-list ul.children {
    list-style: none;
    margin-left: 4em;
    padding-left: 0;
}

#main .wp-video-shortcode {
    display: block;
    height: auto;
    max-width: 100%;
}

#main .attachment .entry-content {
    margin-bottom: 20px;
}

#main .attachment .entry-content .attachment {
    text-align: center;
}

#main .attachment .entry-meta {
    margin-bottom: 20px;
}

#main .post .entry-content img {
    height: auto;
    max-width: 100%;
}

#main .post, #main .page {
    border: 1px solid #eee;
    margin-bottom: 20px;
    overflow-x: auto;
    padding: 10px;
}

#main .post .entry-header .entry-meta {
    color: #999;
    font-size: 0.8rem;
}

#main .post .entry-header .entry-meta a {
    color: inherit;
}

#main .post .entry-header .entry-meta .posted-on .updated {
    display: none;
}

#main .post .entry-meta .categories-icon {
    cursor: default;
}

#main .post .entry-meta .comments-link a {
    color: #333;
}

#main .post .entry-meta .comments-link a .comment-total, #main .page .entry-meta .comments-link a .comment-total {
    color: #555;
}

#main .attachment .edit-post-link a, #main .attachment .entry-meta .edit-post-link a, #main .post .entry-meta .edit-post-link a, #main .page .entry-meta .edit-post-link a {
    color: #333;
}

#main .post .entry-meta .tags-icon {
    cursor: default;
}

#main .attachment .entry-title, #main .post .entry-title, #main .page .entry-title {
    margin-top: 0;
    word-wrap: break-word;
}

#sidebar-left .widget, #sidebar-right .widget {
    border: 1px solid #eee;
    margin-bottom: 20px;
    overflow: hidden;
    padding: 10px;
}

#sidebar-left .widget ul, #sidebar-right .widget ul {
    padding-left: 20px;
}

#sidebar-left .widget .widget-title, #sidebar-right .widget .widget-title {
    font-size: 18px;
    margin-top: 0;
}

.navbar {
    min-height: 54px;
}

@font-face {
    font-family: dashicons;
    src: url(//beinsport.biz/wp-includes/fonts/dashicons.eot?99ac726223c749443b642ce33df8b800);
    src: url(//beinsport.biz/wp-includes/fonts/dashicons.eot?99ac726223c749443b642ce33df8b800#iefix) format("embedded-opentype"),url("data:application/x-font-woff;charset=utf-8;base64,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") format("woff"),url(//beinsport.biz/wp-includes/fonts/dashicons.ttf?99ac726223c749443b642ce33df8b800) format("truetype");
    font-weight: 400;
    font-style: normal
}

.dashicons,.dashicons-before:before {
    font-family: dashicons;
    display: inline-block;
    line-height: 1;
    font-weight: 400;
    font-style: normal;
    speak: never;
    text-decoration: inherit;
    text-transform: none;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    width: 20px;
    height: 20px;
    font-size: 20px;
    vertical-align: top;
    text-align: center;
    transition: color .1s ease-in
}

.dashicons-admin-appearance:before {
    content: "\f100"
}

.dashicons-admin-collapse:before {
    content: "\f148"
}

.dashicons-admin-comments:before {
    content: "\f101"
}

.dashicons-admin-customizer:before {
    content: "\f540"
}

.dashicons-admin-generic:before {
    content: "\f111"
}

.dashicons-admin-home:before {
    content: "\f102"
}

.dashicons-admin-links:before {
    content: "\f103"
}

.dashicons-admin-media:before {
    content: "\f104"
}

.dashicons-admin-multisite:before {
    content: "\f541"
}

.dashicons-admin-network:before {
    content: "\f112"
}

.dashicons-admin-page:before {
    content: "\f105"
}

.dashicons-admin-plugins:before {
    content: "\f106"
}

.dashicons-admin-post:before {
    content: "\f109"
}

.dashicons-admin-settings:before {
    content: "\f108"
}

.dashicons-admin-site-alt:before {
    content: "\f11d"
}

.dashicons-admin-site-alt2:before {
    content: "\f11e"
}

.dashicons-admin-site-alt3:before {
    content: "\f11f"
}

.dashicons-admin-site:before {
    content: "\f319"
}

.dashicons-admin-tools:before {
    content: "\f107"
}

.dashicons-admin-users:before {
    content: "\f110"
}

.dashicons-airplane:before {
    content: "\f15f"
}

.dashicons-album:before {
    content: "\f514"
}

.dashicons-align-center:before {
    content: "\f134"
}

.dashicons-align-full-width:before {
    content: "\f114"
}

.dashicons-align-left:before {
    content: "\f135"
}

.dashicons-align-none:before {
    content: "\f138"
}

.dashicons-align-pull-left:before {
    content: "\f10a"
}

.dashicons-align-pull-right:before {
    content: "\f10b"
}

.dashicons-align-right:before {
    content: "\f136"
}

.dashicons-align-wide:before {
    content: "\f11b"
}

.dashicons-amazon:before {
    content: "\f162"
}

.dashicons-analytics:before {
    content: "\f183"
}

.dashicons-archive:before {
    content: "\f480"
}

.dashicons-arrow-down-alt:before {
    content: "\f346"
}

.dashicons-arrow-down-alt2:before {
    content: "\f347"
}

.dashicons-arrow-down:before {
    content: "\f140"
}

.dashicons-arrow-left-alt:before {
    content: "\f340"
}

.dashicons-arrow-left-alt2:before {
    content: "\f341"
}

.dashicons-arrow-left:before {
    content: "\f141"
}

.dashicons-arrow-right-alt:before {
    content: "\f344"
}

.dashicons-arrow-right-alt2:before {
    content: "\f345"
}

.dashicons-arrow-right:before {
    content: "\f139"
}

.dashicons-arrow-up-alt:before {
    content: "\f342"
}

.dashicons-arrow-up-alt2:before {
    content: "\f343"
}

.dashicons-arrow-up-duplicate:before {
    content: "\f143"
}

.dashicons-arrow-up:before {
    content: "\f142"
}

.dashicons-art:before {
    content: "\f309"
}

.dashicons-awards:before {
    content: "\f313"
}

.dashicons-backup:before {
    content: "\f321"
}

.dashicons-bank:before {
    content: "\f16a"
}

.dashicons-beer:before {
    content: "\f16c"
}

.dashicons-bell:before {
    content: "\f16d"
}

.dashicons-block-default:before {
    content: "\f12b"
}

.dashicons-book-alt:before {
    content: "\f331"
}

.dashicons-book:before {
    content: "\f330"
}

.dashicons-buddicons-activity:before {
    content: "\f452"
}

.dashicons-buddicons-bbpress-logo:before {
    content: "\f477"
}

.dashicons-buddicons-buddypress-logo:before {
    content: "\f448"
}

.dashicons-buddicons-community:before {
    content: "\f453"
}

.dashicons-buddicons-forums:before {
    content: "\f449"
}

.dashicons-buddicons-friends:before {
    content: "\f454"
}

.dashicons-buddicons-groups:before {
    content: "\f456"
}

.dashicons-buddicons-pm:before {
    content: "\f457"
}

.dashicons-buddicons-replies:before {
    content: "\f451"
}

.dashicons-buddicons-topics:before {
    content: "\f450"
}

.dashicons-buddicons-tracking:before {
    content: "\f455"
}

.dashicons-building:before {
    content: "\f512"
}

.dashicons-businessman:before {
    content: "\f338"
}

.dashicons-businessperson:before {
    content: "\f12e"
}

.dashicons-businesswoman:before {
    content: "\f12f"
}

.dashicons-button:before {
    content: "\f11a"
}

.dashicons-calculator:before {
    content: "\f16e"
}

.dashicons-calendar-alt:before {
    content: "\f508"
}

.dashicons-calendar:before {
    content: "\f145"
}

.dashicons-camera-alt:before {
    content: "\f129"
}

.dashicons-camera:before {
    content: "\f306"
}

.dashicons-car:before {
    content: "\f16b"
}

.dashicons-carrot:before {
    content: "\f511"
}

.dashicons-cart:before {
    content: "\f174"
}

.dashicons-category:before {
    content: "\f318"
}

.dashicons-chart-area:before {
    content: "\f239"
}

.dashicons-chart-bar:before {
    content: "\f185"
}

.dashicons-chart-line:before {
    content: "\f238"
}

.dashicons-chart-pie:before {
    content: "\f184"
}

.dashicons-clipboard:before {
    content: "\f481"
}

.dashicons-clock:before {
    content: "\f469"
}

.dashicons-cloud-saved:before {
    content: "\f137"
}

.dashicons-cloud-upload:before {
    content: "\f13b"
}

.dashicons-cloud:before {
    content: "\f176"
}

.dashicons-code-standards:before {
    content: "\f13a"
}

.dashicons-coffee:before {
    content: "\f16f"
}

.dashicons-color-picker:before {
    content: "\f131"
}

.dashicons-columns:before {
    content: "\f13c"
}

.dashicons-controls-back:before {
    content: "\f518"
}

.dashicons-controls-forward:before {
    content: "\f519"
}

.dashicons-controls-pause:before {
    content: "\f523"
}

.dashicons-controls-play:before {
    content: "\f522"
}

.dashicons-controls-repeat:before {
    content: "\f515"
}

.dashicons-controls-skipback:before {
    content: "\f516"
}

.dashicons-controls-skipforward:before {
    content: "\f517"
}

.dashicons-controls-volumeoff:before {
    content: "\f520"
}

.dashicons-controls-volumeon:before {
    content: "\f521"
}

.dashicons-cover-image:before {
    content: "\f13d"
}

.dashicons-dashboard:before {
    content: "\f226"
}

.dashicons-database-add:before {
    content: "\f170"
}

.dashicons-database-export:before {
    content: "\f17a"
}

.dashicons-database-import:before {
    content: "\f17b"
}

.dashicons-database-remove:before {
    content: "\f17c"
}

.dashicons-database-view:before {
    content: "\f17d"
}

.dashicons-database:before {
    content: "\f17e"
}

.dashicons-desktop:before {
    content: "\f472"
}

.dashicons-dismiss:before {
    content: "\f153"
}

.dashicons-download:before {
    content: "\f316"
}

.dashicons-drumstick:before {
    content: "\f17f"
}

.dashicons-edit-large:before {
    content: "\f327"
}

.dashicons-edit-page:before {
    content: "\f186"
}

.dashicons-edit:before {
    content: "\f464"
}

.dashicons-editor-aligncenter:before {
    content: "\f207"
}

.dashicons-editor-alignleft:before {
    content: "\f206"
}

.dashicons-editor-alignright:before {
    content: "\f208"
}

.dashicons-editor-bold:before {
    content: "\f200"
}

.dashicons-editor-break:before {
    content: "\f474"
}

.dashicons-editor-code-duplicate:before {
    content: "\f494"
}

.dashicons-editor-code:before {
    content: "\f475"
}

.dashicons-editor-contract:before {
    content: "\f506"
}

.dashicons-editor-customchar:before {
    content: "\f220"
}

.dashicons-editor-expand:before {
    content: "\f211"
}

.dashicons-editor-help:before {
    content: "\f223"
}

.dashicons-editor-indent:before {
    content: "\f222"
}

.dashicons-editor-insertmore:before {
    content: "\f209"
}

.dashicons-editor-italic:before {
    content: "\f201"
}

.dashicons-editor-justify:before {
    content: "\f214"
}

.dashicons-editor-kitchensink:before {
    content: "\f212"
}

.dashicons-editor-ltr:before {
    content: "\f10c"
}

.dashicons-editor-ol-rtl:before {
    content: "\f12c"
}

.dashicons-editor-ol:before {
    content: "\f204"
}

.dashicons-editor-outdent:before {
    content: "\f221"
}

.dashicons-editor-paragraph:before {
    content: "\f476"
}

.dashicons-editor-paste-text:before {
    content: "\f217"
}

.dashicons-editor-paste-word:before {
    content: "\f216"
}

.dashicons-editor-quote:before {
    content: "\f205"
}

.dashicons-editor-removeformatting:before {
    content: "\f218"
}

.dashicons-editor-rtl:before {
    content: "\f320"
}

.dashicons-editor-spellcheck:before {
    content: "\f210"
}

.dashicons-editor-strikethrough:before {
    content: "\f224"
}

.dashicons-editor-table:before {
    content: "\f535"
}

.dashicons-editor-textcolor:before {
    content: "\f215"
}

.dashicons-editor-ul:before {
    content: "\f203"
}

.dashicons-editor-underline:before {
    content: "\f213"
}

.dashicons-editor-unlink:before {
    content: "\f225"
}

.dashicons-editor-video:before {
    content: "\f219"
}

.dashicons-ellipsis:before {
    content: "\f11c"
}

.dashicons-email-alt:before {
    content: "\f466"
}

.dashicons-email-alt2:before {
    content: "\f467"
}

.dashicons-email:before {
    content: "\f465"
}

.dashicons-embed-audio:before {
    content: "\f13e"
}

.dashicons-embed-generic:before {
    content: "\f13f"
}

.dashicons-embed-photo:before {
    content: "\f144"
}

.dashicons-embed-post:before {
    content: "\f146"
}

.dashicons-embed-video:before {
    content: "\f149"
}

.dashicons-excerpt-view:before {
    content: "\f164"
}

.dashicons-exit:before {
    content: "\f14a"
}

.dashicons-external:before {
    content: "\f504"
}

.dashicons-facebook-alt:before {
    content: "\f305"
}

.dashicons-facebook:before {
    content: "\f304"
}

.dashicons-feedback:before {
    content: "\f175"
}

.dashicons-filter:before {
    content: "\f536"
}

.dashicons-flag:before {
    content: "\f227"
}

.dashicons-food:before {
    content: "\f187"
}

.dashicons-format-aside:before {
    content: "\f123"
}

.dashicons-format-audio:before {
    content: "\f127"
}

.dashicons-format-chat:before {
    content: "\f125"
}

.dashicons-format-gallery:before {
    content: "\f161"
}

.dashicons-format-image:before {
    content: "\f128"
}

.dashicons-format-quote:before {
    content: "\f122"
}

.dashicons-format-status:before {
    content: "\f130"
}

.dashicons-format-video:before {
    content: "\f126"
}

.dashicons-forms:before {
    content: "\f314"
}

.dashicons-fullscreen-alt:before {
    content: "\f188"
}

.dashicons-fullscreen-exit-alt:before {
    content: "\f189"
}

.dashicons-games:before {
    content: "\f18a"
}

.dashicons-google:before {
    content: "\f18b"
}

.dashicons-googleplus:before {
    content: "\f462"
}

.dashicons-grid-view:before {
    content: "\f509"
}

.dashicons-groups:before {
    content: "\f307"
}

.dashicons-hammer:before {
    content: "\f308"
}

.dashicons-heading:before {
    content: "\f10e"
}

.dashicons-heart:before {
    content: "\f487"
}

.dashicons-hidden:before {
    content: "\f530"
}

.dashicons-hourglass:before {
    content: "\f18c"
}

.dashicons-html:before {
    content: "\f14b"
}

.dashicons-id-alt:before {
    content: "\f337"
}

.dashicons-id:before {
    content: "\f336"
}

.dashicons-image-crop:before {
    content: "\f165"
}

.dashicons-image-filter:before {
    content: "\f533"
}

.dashicons-image-flip-horizontal:before {
    content: "\f169"
}

.dashicons-image-flip-vertical:before {
    content: "\f168"
}

.dashicons-image-rotate-left:before {
    content: "\f166"
}

.dashicons-image-rotate-right:before {
    content: "\f167"
}

.dashicons-image-rotate:before {
    content: "\f531"
}

.dashicons-images-alt:before {
    content: "\f232"
}

.dashicons-images-alt2:before {
    content: "\f233"
}

.dashicons-index-card:before {
    content: "\f510"
}

.dashicons-info-outline:before {
    content: "\f14c"
}

.dashicons-info:before {
    content: "\f348"
}

.dashicons-insert-after:before {
    content: "\f14d"
}

.dashicons-insert-before:before {
    content: "\f14e"
}

.dashicons-insert:before {
    content: "\f10f"
}

.dashicons-instagram:before {
    content: "\f12d"
}

.dashicons-laptop:before {
    content: "\f547"
}

.dashicons-layout:before {
    content: "\f538"
}

.dashicons-leftright:before {
    content: "\f229"
}

.dashicons-lightbulb:before {
    content: "\f339"
}

.dashicons-linkedin:before {
    content: "\f18d"
}

.dashicons-list-view:before {
    content: "\f163"
}

.dashicons-location-alt:before {
    content: "\f231"
}

.dashicons-location:before {
    content: "\f230"
}

.dashicons-lock-duplicate:before {
    content: "\f315"
}

.dashicons-lock:before {
    content: "\f160"
}

.dashicons-marker:before {
    content: "\f159"
}

.dashicons-media-archive:before {
    content: "\f501"
}

.dashicons-media-audio:before {
    content: "\f500"
}

.dashicons-media-code:before {
    content: "\f499"
}

.dashicons-media-default:before {
    content: "\f498"
}

.dashicons-media-document:before {
    content: "\f497"
}

.dashicons-media-interactive:before {
    content: "\f496"
}

.dashicons-media-spreadsheet:before {
    content: "\f495"
}

.dashicons-media-text:before {
    content: "\f491"
}

.dashicons-media-video:before {
    content: "\f490"
}

.dashicons-megaphone:before {
    content: "\f488"
}

.dashicons-menu-alt:before {
    content: "\f228"
}

.dashicons-menu-alt2:before {
    content: "\f329"
}

.dashicons-menu-alt3:before {
    content: "\f349"
}

.dashicons-menu:before {
    content: "\f333"
}

.dashicons-microphone:before {
    content: "\f482"
}

.dashicons-migrate:before {
    content: "\f310"
}

.dashicons-minus:before {
    content: "\f460"
}

.dashicons-money-alt:before {
    content: "\f18e"
}

.dashicons-money:before {
    content: "\f526"
}

.dashicons-move:before {
    content: "\f545"
}

.dashicons-nametag:before {
    content: "\f484"
}

.dashicons-networking:before {
    content: "\f325"
}

.dashicons-no-alt:before {
    content: "\f335"
}

.dashicons-no:before {
    content: "\f158"
}

.dashicons-open-folder:before {
    content: "\f18f"
}

.dashicons-palmtree:before {
    content: "\f527"
}

.dashicons-paperclip:before {
    content: "\f546"
}

.dashicons-pdf:before {
    content: "\f190"
}

.dashicons-performance:before {
    content: "\f311"
}

.dashicons-pets:before {
    content: "\f191"
}

.dashicons-phone:before {
    content: "\f525"
}

.dashicons-pinterest:before {
    content: "\f192"
}

.dashicons-playlist-audio:before {
    content: "\f492"
}

.dashicons-playlist-video:before {
    content: "\f493"
}

.dashicons-plugins-checked:before {
    content: "\f485"
}

.dashicons-plus-alt:before {
    content: "\f502"
}

.dashicons-plus-alt2:before {
    content: "\f543"
}

.dashicons-plus:before {
    content: "\f132"
}

.dashicons-podio:before {
    content: "\f19c"
}

.dashicons-portfolio:before {
    content: "\f322"
}

.dashicons-post-status:before {
    content: "\f173"
}

.dashicons-pressthis:before {
    content: "\f157"
}

.dashicons-printer:before {
    content: "\f193"
}

.dashicons-privacy:before {
    content: "\f194"
}

.dashicons-products:before {
    content: "\f312"
}

.dashicons-randomize:before {
    content: "\f503"
}

.dashicons-reddit:before {
    content: "\f195"
}

.dashicons-redo:before {
    content: "\f172"
}

.dashicons-remove:before {
    content: "\f14f"
}

.dashicons-rest-api:before {
    content: "\f124"
}

.dashicons-rss:before {
    content: "\f303"
}

.dashicons-saved:before {
    content: "\f15e"
}

.dashicons-schedule:before {
    content: "\f489"
}

.dashicons-screenoptions:before {
    content: "\f180"
}

.dashicons-search:before {
    content: "\f179"
}

.dashicons-share-alt:before {
    content: "\f240"
}

.dashicons-share-alt2:before {
    content: "\f242"
}

.dashicons-share:before {
    content: "\f237"
}

.dashicons-shield-alt:before {
    content: "\f334"
}

.dashicons-shield:before {
    content: "\f332"
}

.dashicons-shortcode:before {
    content: "\f150"
}

.dashicons-slides:before {
    content: "\f181"
}

.dashicons-smartphone:before {
    content: "\f470"
}

.dashicons-smiley:before {
    content: "\f328"
}

.dashicons-sort:before {
    content: "\f156"
}

.dashicons-sos:before {
    content: "\f468"
}

.dashicons-spotify:before {
    content: "\f196"
}

.dashicons-star-empty:before {
    content: "\f154"
}

.dashicons-star-filled:before {
    content: "\f155"
}

.dashicons-star-half:before {
    content: "\f459"
}

.dashicons-sticky:before {
    content: "\f537"
}

.dashicons-store:before {
    content: "\f513"
}

.dashicons-superhero-alt:before {
    content: "\f197"
}

.dashicons-superhero:before {
    content: "\f198"
}

.dashicons-table-col-after:before {
    content: "\f151"
}

.dashicons-table-col-before:before {
    content: "\f152"
}

.dashicons-table-col-delete:before {
    content: "\f15a"
}

.dashicons-table-row-after:before {
    content: "\f15b"
}

.dashicons-table-row-before:before {
    content: "\f15c"
}

.dashicons-table-row-delete:before {
    content: "\f15d"
}

.dashicons-tablet:before {
    content: "\f471"
}

.dashicons-tag:before {
    content: "\f323"
}

.dashicons-tagcloud:before {
    content: "\f479"
}

.dashicons-testimonial:before {
    content: "\f473"
}

.dashicons-text-page:before {
    content: "\f121"
}

.dashicons-text:before {
    content: "\f478"
}

.dashicons-thumbs-down:before {
    content: "\f542"
}

.dashicons-thumbs-up:before {
    content: "\f529"
}

.dashicons-tickets-alt:before {
    content: "\f524"
}

.dashicons-tickets:before {
    content: "\f486"
}

.dashicons-tide:before {
    content: "\f10d"
}

.dashicons-translation:before {
    content: "\f326"
}

.dashicons-trash:before {
    content: "\f182"
}

.dashicons-twitch:before {
    content: "\f199"
}

.dashicons-twitter-alt:before {
    content: "\f302"
}

.dashicons-twitter:before {
    content: "\f301"
}

.dashicons-undo:before {
    content: "\f171"
}

.dashicons-universal-access-alt:before {
    content: "\f507"
}

.dashicons-universal-access:before {
    content: "\f483"
}

.dashicons-unlock:before {
    content: "\f528"
}

.dashicons-update-alt:before {
    content: "\f113"
}

.dashicons-update:before {
    content: "\f463"
}

.dashicons-upload:before {
    content: "\f317"
}

.dashicons-vault:before {
    content: "\f178"
}

.dashicons-video-alt:before {
    content: "\f234"
}

.dashicons-video-alt2:before {
    content: "\f235"
}

.dashicons-video-alt3:before {
    content: "\f236"
}

.dashicons-visibility:before {
    content: "\f177"
}

.dashicons-warning:before {
    content: "\f534"
}

.dashicons-welcome-add-page:before {
    content: "\f133"
}

.dashicons-welcome-comments:before {
    content: "\f117"
}

.dashicons-welcome-learn-more:before {
    content: "\f118"
}

.dashicons-welcome-view-site:before {
    content: "\f115"
}

.dashicons-welcome-widgets-menus:before {
    content: "\f116"
}

.dashicons-welcome-write-blog:before {
    content: "\f119"
}

.dashicons-whatsapp:before {
    content: "\f19a"
}

.dashicons-wordpress-alt:before {
    content: "\f324"
}

.dashicons-wordpress:before {
    content: "\f120"
}

.dashicons-xing:before {
    content: "\f19d"
}

.dashicons-yes-alt:before {
    content: "\f12a"
}

.dashicons-yes:before {
    content: "\f147"
}

.dashicons-youtube:before {
    content: "\f19b"
}

.dashicons-editor-distractionfree:before {
    content: "\f211"
}

.dashicons-exerpt-view:before {
    content: "\f164"
}

.dashicons-format-links:before {
    content: "\f103"
}

.dashicons-format-standard:before {
    content: "\f109"
}

.dashicons-post-trash:before {
    content: "\f182"
}

.dashicons-share1:before {
    content: "\f237"
}

.dashicons-welcome-edit-page:before {
    content: "\f119"
}
</style>