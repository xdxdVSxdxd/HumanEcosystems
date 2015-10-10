<!DOCTYPE html>
<html lang="it" dir="ltr"
  xmlns:fb="http://ogp.me/ns/fb#"
  xmlns:og="http://ogp.me/ns#"
  xmlns:article="http://ogp.me/ns/article#"
  xmlns:book="http://ogp.me/ns/book#"
  xmlns:profile="http://ogp.me/ns/profile#"
  xmlns:video="http://ogp.me/ns/video#">
<head profile="http://www.w3.org/1999/xhtml/vocab">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="shortcut icon" href="img/favicon.ico" type="image/vnd.microsoft.icon" />
  <link href='http://fonts.googleapis.com/css?family=Bad+Script' rel='stylesheet' type='text/css'>
  <link type="text/css" rel="stylesheet" href="css/bootstrap.css" />
  <link type="text/css" rel="stylesheet" href="css/iperbole-header.css" />
  <script type="text/javascript"src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=visualization&sensor=false"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="js/d3.min.js"></script>
  <script src="js/respond.min.js"></script>
  <script src="js/header.js"></script>
<title>HUB - Human Ecosystems Bologna</title>
</head>

<body class="html front not-logged-in no-sidebars page-node navbar-is-static-top" >
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable" tabindex="99">Salta al contenuto principale</a>
  </div>

	<div id="header" class="header">
    <div class="container-fluid">
        <div class="row header-social">
          <div class="container">
            <div class="row">
              <div class="col-search">
                <form action="http://comune.bo.it/trova" class="navbar-form" role="search">
                    <div class="input-group">
                        <div class="input-group-btn btn-search">
                            <button class="btn btn-default glyphicon glyphicon-search" type="submit"><span class="btn-label">Cerca nel sito</span></button>
                        </div>
                        <label for="srch-term">Cerca nel sito</label>
                        <input type="text" class="form-control" placeholder="Cerca" name="trova" id="srch-term">
                    </div>
                </form>
              </div>
              <div class="col-social">
                <div class="social">
                    <a target="_blank" class="tw" href="http://twitter.com/Twiperbole"><span>Twiperbole</span></a>
                    <a target="_blank" class="fb" href="http://www.facebook.com/pages/Comune-di-Bologna-Iperbole-Rete-Civica/98223087991?ref=ts"><span>Facebook</span></a>
                    <a target="_blank" class="fl" href="http://www.flickr.com/photos/iperbole-bologna/"><span>Flickr</span></a>
                    <a target="_blank" class="pt" href="http://pinterest.com/iperbole"><span>Pinterest</span></a>
                    <a target="_blank" class="yt" href="http://www.youtube.com/ComuneDiBologna"><span>YouTube</span></a>
                    <a target="_blank" class="instagram" href="http://instagram.com/twiperbole"><span>Instagram</span></a>
                    <a target="_blank" class="rss" href="http://www.comune.bologna.it/news/all/feed"><span>RSS</span></a>
                </div>
              </div>
              <div class="col-contact">
                <div class="iperbole-newsletter">
                  <a class="" href="http://www.comune.bologna.it/node/1000">newsletter</a>
                </div>
                <div class="iperbole-mail">
                  <a class="" href="http://webmail.iperbole.bologna.it/horde/login.php">@<strong>iperbole</strong> mail</a>
                </div>
                <div class="iperbole-contact">
                  <a href="http://www.comune.bologna.it/comune/luoghi/17:3773"><strong>call</strong> center</a> <span class="callcenter">051203040</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row header-logos">
          <div class="container">
            <div class="row">
                <div class="col-sm-2 col-md-2">
                    <img src="img/comune-di-bologna.png" class="logo-comune" alt="Comune di Bologna" />
                </div>
              <div class="col-sm-8 col-md-8 logo-iperbole">
                <a href="http://www.comune.bologna.it"><img src="img/retecivica_info.png" class="logo iperbole" alt="Rete civica Iperbole" /></a>
              </div>
              <div class="col-sm-2 col-md-2 logo-ebologna">
                <img src="img/ebologna/eBologna_1.png" class="pull-right" alt="&Egrave; Bologna - City brand" />
              </div>
            </div>
          </div>
        </div>
      <div class="row header-logos-mobile">
        <div class="container">
          <a href="http://www.comune.bologna.it"><img src="img/logo-mobile.png" class="logo-mobile"/></a>
        </div>
      </div>

    </div>
</div>
<div class="outer-container">
  <div class="main-container container">
<div class="row"> <!-- page-content -->
      <section class="col-sm-12">
        <h1>HUB - La città della Collaborazione in Tempo Reale</h1>
        <p>Chi parla di collaborazione a Bologna sui social network? E come? Quali sono i quartieri più collaborativi? Quali i temi su cui ci si esprime di più? Quali emozioni esprimono i cittadini? Chi sono gli hub, gli influencer, i ponti tra le comunità e gli esperti della collaborazione? Quali le lingue della collaborazione?</p>
        <p>Con progetto <a href="http://human-ecosystems.com/home/hub-human-ecosystems-bologna-opening-and-press-conference-7-october/" title="Human Ecosystems a Bologna con HUB" target="_blank"><strong>HUB – Human Ecosystems Bologna</strong></a> il <a href="http://www.comune.bologna.it/" title="Comune di Bologna">Comune di Bologna</a> inaugura una inedita sperimentazione a cavallo fra arte, tecnologia, ricerca e open data per supportare le proprie politiche.</p>
      </section>
      <section class="col-sm-12" id="main-content">
      
          <div class="viz-holder" id="viz1">
            <div id='wordgraph'>
              <div id='wordgraphcontainer'></div>
            </div>
            <div id='tagcloud'><div id='tagcloudcontainer'></div></div>
            <div id='wordgraphtitle'></div>
          </div>
          <div class="viz-caption">
            <strong>I temi della collaborazione in città.</strong><br />
            <em>Di cosa parlano i Bolognesi quando si esprimono sulla collaborazione? Quali le conversazioni? Quali i temi più discussi? Quali quelli che invitano alla collaborazione? E quali le relazioni fra i temi? Nella schermata a destra, la concept-cloud consente velocemente di comprendere di quali temi conversano più frequentemente i cittadini di Bologna: più sono grandi sono i cerchi che racchiudono il tema, più il tema è discusso. Nella schermata a sinistra si evidenziano le relazioni fra temi.</em>
          </div>
      </section>
      <section class="col-sm-12" id="main-content-relations">
          <div class="viz-holder" id="viz2">
            <div id="results"></div>
          </div>
          <div class="viz-caption">
            <strong>Le relazioni della collaborazione in città.</strong><br />
            <em>La visualizzazione mostra i 500 attori i della città maggiormente attive, presenti e connesse intorno al tema della collaborazione sui social network.  Ogni cubo rappresenta una identità: la configurazione delle loro connessioni consente di comprenderne la centralità e la loro capacità di interconnettere soggetti ed organizzazioni.</em>
          </div>
      </section>
      <section class="col-sm-12" id="main-content-emotions">
          <div class='emotionalmaptotalholder'>
            <div id='mapholder'></div>
            <div class='emotionalmapinterfaceholder'>
              <div id='legend'>
                <div id="legend-head">Legend</div>
                <div id="legend-body"></div>
              </div>
              <div id="emotinsposts">
                  <div id="emotinspostscontainer"></div>
              </div>
            </div>
            <div id="bottom-diagrams">
                <div id="emo-timeline-contained">
                </div>
            </div>
          </div>
          <div class="viz-caption">
          <strong>Il territorio della collaborazione.</strong><br />
          <em>Dove parlano le persone di collaborazione, usando i social network? E come ne parlano? In questa visualizzazione si può apprezzare la spazializzazione territoriale delle conversazioni sulla collaborazione in nella Città di Bologna, assieme al tipo di emozioni che le persone esprimono, anche visualizzato nel tempo (tramite il grafico in basso).</em>
        </div>
      </section>
 </div> 
 <div class="row">
  <div class="col-sm-3" id="HUB-Logo">
    <img src="img/HUB-logo-small.png" width="250" height="auto" border="0" />
  </div>
  <div class="col-sm-9">
      <h2 class="hub-lead">La città della Collaborazione in Tempo Reale</h2>
  </div>
</div>
<div class="row">
  <div class="col-sm-3" id="HUB-Logo">
    
  </div>
  <div class="col-sm-9 HUB-content">
<p>
Patrocinato dall'<a href="http://www.anci.it/" target="_blank" title="ANCI">ANCI – Associazione Nazionale Comuni Italiani</a> e sostenuto da <a href="http://www.labgov.it/" target="_blank" title="LabGov">LabGov</a> per il progetto di <a href="http://www.labgov.it/wordpress/co/co-bologna/co-bologna.html" target="_blank" title="Co-Bologna">Co-Bologna</a>, il progetto mostra l'ecosistema relazionale della partecipazione e della cooperazione della Città di Bologna nella sua dimensione digitale, realizzando un percorso parallelo e complementare al processo di “Collaborare è Bologna”, le politiche collaborative del Comune di Bologna.
</p>
<p>
I dati saranno disponibili in una mostra interattiva che animerà gli spazi dell'<a href="http://www.urbancenterbologna.it/" target="_blank" title="Bologna Urban Center">Urban Center</a> dal <em>7 ottobre al 7 dicembre 2015</em> e on-line per consentire a cittadini e visitatori di osservare i temi, i luoghi, le emozioni e le opinioni della Bologna della collaborazione, per come questi sono affrontati ed espressi pubblicamente sui principali social network.
</p>
<p>
Al termine della mostra dati raccolti verranno rilasciati sotto forma di <strong>Open Data</strong>. Un nuovo <em>bene comune immateriale</em> a disposizione di cittadini, ricercatori, società civile e amministrazione, che apre una sperimentazione inedita nell'ambito delle politiche Open Data, in cui “i sensori” sono i cittadini, le loro interazioni ed espressioni quotidiane nel nuovo e controverso spazio pubblico costituito dai social network.
</p>
<h3>
Per saperne di più
</h3>
<p>
<em>Cos'è Human Ecosystems</em><br />
<a href="http://www.human-ecosystems.com" title="Human Ecosystems" target="_blank">www.human-ecosystems.com</a>
</p>
<p>
<em>"Collaborare è Bologna", le politiche partecipative del Comune di Bologna</em><br />
<a href="http://www.comune.bologna.it/collaborarebologna" title="Comune di Bologna, collaborazione" target="_blank">http://www.comune.bologna.it/collaborarebologna</a><br />
<a href="http://www.comune.bologna.it/comunita/node" title="Comune di Bologna, comunità" target="_blank">http://www.comune.bologna.it/comunita/node</a><br />
<a href="http://www.comune.bologna.it/comunita/beni-comuni" title="Comune di Bologna, beni comuni" target="_blank">http://www.comune.bologna.it/comunita/beni-comuni</a><br />
<a href="http://www.urbancenterbologna.it/collaborare-bologna" title="Comune di Bologna, collaborare è Bologna" target="_blank">http://www.urbancenterbologna.it/collaborare-bologna</a><br />
</p>
<h3>
Credits
</h3>
<p>
<em>HUB – Human Ecosystems Bologna è un progetto promosso da:</em><br />
<a href="http://www.comune.bologna.it" title="Comune di Bologna" target="_blank">Comune di Bologna</a><br />
<em>In collaborazione con:</em><br />
<a href="http://www.labgov.it/" title="LabGov" target="_blank">LABoratorio per la GOVernance dei beni comuni</a><br />
<em>con il patrocinio di:</em><br />
<a href="http://www.anci.it/" title="ANCI" target="_blank">ANCI - Associazione Nazionale Comuni Italiani</a><br />
<em>Ideazione e realizzazione:</em><br />
<a href="http://www.human-ecosystems.com" title="Human Ecosystems" target="_blank">HE - Human Ecosystems</a> / <a href="http://artisopensource.net/" title="Art is Open Source" target="_blank">AOS - Art is Open Source</a> (S. Iaconesi; O. Persico)
</p>
  </div>
</div> 


<div class="row">
  <div class="noticebox">
    <h3>NOTA:</h3>
    <p><strong>HUB, Human Ecosystems Bologna</strong>, è un nuvo modo di osservare quello che avviene in città sui social network. È paragonabile ad altri servizi fruibili dal web, come <strong>Webstagram</strong>, <strong>Banjo</strong>, <strong>Bluenod</strong>, <strong>Topsy</strong> e tanti altri, che permettono di avere una visione di insieme su quello che accade sui maggiori social network, ma andando un po' più in là, permettendo di comprendere i <strong>luoghi</strong>, i <strong>modi</strong> e le <strong>relazioni</strong> che si formano nella città di Bologna parlando di collaborazione.</p>
    <p><em>In HUB non conserviamo dati personali</em>, ma semplicemente link a contenuti "pubblici" sui social network <em>(quelli che gli utenti stessi hanno contrassegnato come "visibili a tutti")</em> che menzionano attività collaborative a Bologna, annotandoli, per comodità e ad uso della comunità dei cittadini, del tema trattato dal contenuto stesso, per una migliore accessibilità.</p>
    <p>Le visualizzazioni sono costruite in pieno rispetto sia delle policy e dei termini di accesso ai servizi dei maggiori social network (utilizziamo Facebook, Twitter e Instagram), sia delle impostazioni sulla privacy dei singoli utenti (visualizziamo solo i contenuti che gli utenti stessi hanno marcato come "visibili a tutti").</p>
    <p><em>Ciò non evita che, guardando le visualizzazioni o la pagina web di HUB, possiate trovare qualcosa (una immagine, un testo o altro) che secondo voi non dovrebbe comparirvi.</em></p>
    <p>Questo può avvenire per tanti motivi, <strong>fuori dal nostro controllo</strong> (potreste, ad esempio, aver sbagliato una impostazione della vostra privacy sui social network, o qualcuno potrebbe avere pubblicato un contenuto che vi riguarda senza aver prima ottenuto il vostro consenso, o i tanti altri casi simili che si verificano continuamente sui social network).</p>
    <p><strong>Anche in questo caso, niente paura</strong>: è possibile ovviare a queso tipo di problemi in completa semplicità e tranquillità.</p>
    <p><strong>Se vedete qualcosa che secondo voi non dovrebbe comparire su HUB</strong> (perché, ad esempio pensate che violi la vostra privacy o un vostro diritto d'autore, o per qualsiasi altro motivo) <strong>segnalatecelo all'indirizzo email <a href="mailto:info@human-ecosystems.com"><em>info@human-ecosystems.com</em></a></strong> descrivendoci l'elemento che secondo voi non dovrebbe apparire nelle visualizzazioni e il motivo per cui pensate che non dovrebbe comparirvi (basta anche una sola riga: i motivi son sempre molto semplici, solitamente) e noi, verificata la legittimità della vostra affermazione, provvederemo immediatamente a cancellarlo (con solo i tempi tecnici: al massimo una giornata piena di un giorno lavorativo) e a far sì che non compaia più.</p>
    <p>Potete anche utilizzare questo indirizzo per richiedere ulteriori informazioni, o per sapere come utilizzare HUB o Human Ecosystems per una vostra idea.</p>
    <p>Invece, da un altro punto di vista: se vi sembra che, nonostante utilizziate i social network per discutere di collaborazione a Bologna, i vostri contenuti non vadano a contribuire alle visualizzazioni come vorreste, assicuratevi di pubblicarli come "visibili a tutti" (utilizzando le impostazioni di privacy dei social network) e, in caso di dubbi, non esitate a contattarci alla stessa mail.</p>
  </div>
</div>


 </div>
 </div>



<!-- footer -->
<div class="footer">
  <div class="footercol">
    <ul class="navmenufooter">
      <li class="expanded"><a href="http://www.comune.bologna.it/comunita" title="" class="active">Informazioni</a>
      <li class="itemfooter"><a href="http://www.comune.bologna.it/comunita/about" title="">Cosa è</a></li>
      <li class="itemfooter"><a href="http://www.comune.bologna.it/comunita/cosa-puoi-fare" title="">Cosa puoi fare</a></li>
      <li class="itemfooter"><a href="http://www.comune.bologna.it/comunita/come-accedere" title="">Come accedere</a></li>
    </ul>
  </div>
  <div class="footercol">
    <ul class="navmenufooter">
      <li class="expanded"><a href="http://www.comune.bologna.it/comunita/" title="" class="active">Supporto</a></li>
      <li class="itemfooter"><a href="http://www.comune.bologna.it/comunita/faq" title="">Domande frequenti</a></li>
      <li class="itemfooter"><a href="http://www.comune.bologna.it/comunita/guida" title="">Guida</a></li>
      <li class="itemfooter"><a href="http://www.comune.bologna.it/comunita/contattaci" title="">Contattaci</a></li>
    </ul>
  </div>
  <div class="footercol">
    <ul class="navmenufooter">
      <li class="expanded"><a href="http://www.comune.bologna.it/comunita/" title="" class="active">Norme</a></li>
      <li class="itemfooter"><a href="http://www.comune.bologna.it/comunita/note-legali" title="">Note legali</a></li>
      <li class="itemfooter"><a href="http://www.comune.bologna.it/comunita/la-carta-di-comunit%C3%A0" title="">Carta di Comunità</a></li>
      <li class="itemfooter"><a href="http://www.comune.bologna.it/comunita/informativa-trattamento-dati-personali" title="">Informativa sul trattamento dei dati</a></li>
    </ul>
  </div>
  <div class="footercredits">
    <p>Comune di Bologna, Piazza Maggiore, 6 - 40124 Bologna P.Iva 01232710374 Centralino 051 2193111 – Cod. IBAN: IT 88 R 02008 02435 000020067156</p>
  </div>
</div>
<!-- footer -->

</body>
</html>
