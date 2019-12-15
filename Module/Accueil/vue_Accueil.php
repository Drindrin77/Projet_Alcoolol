<?php
if (!defined('CONST_INCLUDE'))
    die('Acces   direct interdit !');

class VueAccueil extends VueGenerique
{
    function __construct()
    {
        parent::__construct();
    }
    
    public function propos(){
        $this -> titre = "A propos";
        $this->contenu = '
		
	<div class="propos">
      <div class="ui stackable grid">
         <div class="four wide column">
            <div class="personne">
               <div class="developpeur debut">
                  <img  src="images\developpeurs\D\0.jpg" alt="dorian" onmouseover="this.src=\'http://leanna.dcal.me/images/developpeurs/D/1.jpg\'" onmouseout="this.src=\'http://leanna.dcal.me/images/developpeurs/D/0.jpg\'">
               </div>
               <div class="description">
                  <span class="nom">CASSAGNE Dorian</span>
                  <span>Administrateur Serveur/Services</span>
                  <span>Developpeur Back-End</span>
               </div>
            </div>
         </div>
         <div class="four wide column">
            <div class="personne">
               <div class="developpeur">
                  <img id="dorian" src="images\developpeurs\L\0.jpg" alt="leanna" onmouseover="this.src=\'http://leanna.dcal.me/images/developpeurs/L/1.jpg\'" onmouseout="this.src=\'http://leanna.dcal.me/images/developpeurs/L/0.jpg\'">
               </div>
               <div class="description">
                  <span class="nom">JI Leanna</span>
                  <span>Chef de Projet</span>
                  <span>Developpeur Full-Stack</span>
               </div>
            </div>
         </div>
         <div class="four wide column">
            <div class="personne">
               <div class="developpeur">
                  <img id="dorian" src="images\developpeurs\M\0.jpg" alt="melanie" onmouseover="this.src=\'http://leanna.dcal.me/images/developpeurs/M/1.jpg\'" onmouseout="this.src=\'http://leanna.dcal.me/images/developpeurs/M/0.jpg\'">
               </div>
               <div class="description">
                  <span class="nom">SEAN MELANIE</span>
                  <span>Administrateur base de données</span>
                  <span>Developpeur Front-End</span>
               </div>
            </div>
         </div>
         <div class="four wide column">
            <div class="personne">
               <div class="developpeur fin">
                  <img src="images\developpeurs\W\0.jpg" alt="abdel" onmouseover="this.src=\'http://leanna.dcal.me/images/developpeurs/W/1.jpg\'" onmouseout="this.src=\'http://leanna.dcal.me/images/developpeurs/W/0.jpg\'">
               </div>
               <div class="description">
                  <span class="nom">ABERKANE Abdel</span>
                  <span>Designer</span>
                  <span>Developpeur Front-End</span>
               </div>
            </div>
         </div>
      <div class="sixteen wide column">
         <p class="explication">
            Ce site internet a été effectué dans le cadre d\'un projet au sein de l\'Institue Universitaire et Technologique de Montreuil. Il a pour but de montrer l\'acquisition de compétences en programmation web. Ici il s\'agit d\'un site type wiki, regroupant des fonctionnalités de communication sociale avec le partage de savoir dans le monde de la boisson. 
         </p>
      </div>
   </div>
</div>
	<link rel="stylesheet" type="text/css" href="Module/Accueil/styleAccueil.css?t='.time().'">';
    }
    
        public function accueil(){
        $this -> titre = "Accueil";
        $this-> contenu = '
<div class="two column stackable centered ui grid">
   <div class="column">
      <div class="ui centered" style="border:none;">
         
        <h1 id="bienvenu">Bienvenue</h1>

         <div class="ajax_loader">
            <div class="whiskey-loader">
               <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                  viewBox="0 0 134 172.2" style="enable-background:new 0 0 134 172.2;" xml:space="preserve" class="tiki">
                  <g id="Layer_3">
                     <polygon fill="#1A1A1A" points="34,13.8 34,13.6 32.9,14.2 66,75.6 66.1,75.7 67.2,75.1  "/>
                     <path fill="#FFC107" d="M15.5,38.2l15.8-27.1L60.7,11c0,0-1.4,3.2-4.4,4.4s-5.3,1.8-6,4.2s-3,5.1-4.9,4.9c-2-0.2-3,0.6-4.7,2.8
                        S35.3,31.1,33,31s-5.2,2.4-7,3.8c-1.7,1.4-2,0-3.7,0.4S15.5,38.2,15.5,38.2z"/>
                     <path fill="#1A1A1A" d="M30.4,10.2c0.4-0.3,1-0.6,1.4-0.1c0.4,0.6,0.9,1.1,0.9,1.1s-0.1,0.5-1,1c-0.8,0.5-1.3,0.4-1.3,0.4
                        s-0.3-0.4-0.7-1.1C29.4,11,29.9,10.6,30.4,10.2z"/>
                     <path fill="#1A1A1A" d="M60.2,154.4l-3.9-0.8c1.1-5,26.3-121.5,29.1-129.6c0.6-1.7,1.5-2.8,2.9-3.4c2.8-1.2,6.2,0.2,9.8,1.8
                        c4.9,2.1,7.2,2.8,8.2,1.2c0.4-0.6,0.3-0.9,0.3-1c-0.3-1.1-3-2.6-5.2-3.7c-4.1-2.1-9.8-5.1-7.7-10.6c3.3-8.7,29.1-4.1,37-2.5
                        l-0.8,3.9c-14.5-3-31-3.7-32.4,0c-0.7,1.9,1.1,3.2,5.8,5.6c3.3,1.7,6.5,3.4,7.2,6.2c0.4,1.4,0.1,2.8-0.7,4.2
                        c-3,4.9-8.9,2.3-13.2,0.4c-2.4-1.1-5.4-2.4-6.6-1.8c-0.1,0-0.4,0.2-0.7,1C86.5,33.2,60.5,153.2,60.2,154.4z"/>
                  </g>
                  <g id="Layer_6">
                     <path fill="#E8103A" opacity="0.85" d="M91.2,133.1v-26.4c0,0,2-0.6,2-3.1s-2-3.4-2-3.4v-34c0,0-6.7-3.8-15.7-4s-14,4.8-20.8,5s-13.2-1-13.2-1v33.7
                        v0.6c0,0-2,0.9-2,3.3c0,2.4,2,3.4,2,3.4v27c0,0-2,0.1-2,3.3s2,3.2,2,3.2v22.2c0,4.4,11.1,8,24.8,8s24.8-3.6,24.8-8v-23
                        c0,0,2-0.6,2-3.2S91.2,133.1,91.2,133.1z">
                        <animate attributeName="d" calcMode="spline" keySplines="0.45 0.03 0.5 0.95; 0.45 0.03 0.5 0.95" values="M91.2,133.1v-26.4c0,0,2-0.6,2-3.1s-2-3.4-2-3.4v-34c0,0-6.7-3.8-15.7-4s-14,4.8-20.8,5s-13.2-1-13.2-1v33.7
                           v0.6c0,0-2,0.9-2,3.3c0,2.4,2,3.4,2,3.4v27c0,0-2,0.1-2,3.3s2,3.2,2,3.2v22.2c0,4.4,11.1,8,24.8,8s24.8-3.6,24.8-8v-23
                           c0,0,2-0.6,2-3.2S91.2,133.1,91.2,133.1z;
                           M91.2,133.1v-26.4c0,0,2-0.6,2-3.1s-2-3.4-2-3.4v-28c0,0-6.7-3.8-15.7-4s-14,4.8-20.8,5s-13.2-1-13.2-1v27.7
                           v0.6c0,0-2,0.9-2,3.3c0,2.4,2,3.4,2,3.4v27c0,0-2,0.1-2,3.3s2,3.2,2,3.2v22.2c0,4.4,11.1,8,24.8,8s24.8-3.6,24.8-8v-23
                           c0,0,2-0.6,2-3.2S91.2,133.1,91.2,133.1z;
                           M91.2,133.1v-26.4c0,0,2-0.6,2-3.1s-2-3.4-2-3.4v-34c0,0-6.7-3.8-15.7-4s-14,4.8-20.8,5s-13.2-1-13.2-1v33.7
                           v0.6c0,0-2,0.9-2,3.3c0,2.4,2,3.4,2,3.4v27c0,0-2,0.1-2,3.3s2,3.2,2,3.2v22.2c0,4.4,11.1,8,24.8,8s24.8-3.6,24.8-8v-23
                           c0,0,2-0.6,2-3.2S91.2,133.1,91.2,133.1z" dur="3s" repeatCount="indefinite" />
                     </path>
                  </g>
                  <g id="Layer_1">
                     <path fill="#BEBEBE" d="M66.4,171.4c-14.2,0-25.3-3.7-25.3-8.5V141c-0.7-0.3-2-1.1-2-3.6s1.3-3.4,2-3.6v-26.3c-0.6-0.4-2-1.5-2-3.7
                        c0-2.1,1.4-3.2,2-3.5v-53h1v53.6l-0.3,0.1c-0.1,0-1.7,0.8-1.7,2.8c0,2,1.7,2.9,1.7,2.9l0.3,0.1l0,0.3v27.5l-0.5,0
                        c-0.1,0-1.5,0.2-1.5,2.8c0,2.6,1.5,2.7,1.5,2.8l0,0.1h0.5v22.6c0,3.6,9.8,7.5,24.3,7.5s24.3-3.9,24.3-7.5v-23.3l0.4-0.1
                        c0.1,0,1.6-0.6,1.6-2.8c0-2.2-1.6-3-1.7-3l-0.3-0.1l0-0.3v-26.7l0.4-0.1c0.1,0,1.6-0.6,1.6-2.6c0-2.1-1.6-2.9-1.7-2.9l-0.3-0.1
                        l0-0.3v-53h1V100c0.6,0.4,2,1.5,2,3.7c0,2-1.2,3-2,3.5v25.7c0.6,0.4,2,1.5,2,3.8c0,2.3-1.3,3.2-2,3.6v22.6
                        C91.7,167.6,80.6,171.4,66.4,171.4z"/>
                     <g>
                        <path fill="#BEBEBE" d="M50,43.4c4.2-0.9,9.8-1.4,16.3-1.4c5.5,0,10.4,0.4,14.3,1.1c0.1-0.3,0.2-0.7,0.2-1c-4.3-0.7-9.5-1.1-14.6-1.1
                           c-6,0-12.1,0.5-16.8,1.5L50,43.4z"/>
                        <path fill="#BEBEBE" d="M84.9,42.8c-0.1,0.3-0.1,0.7-0.2,1c3.8,1,6.1,2.2,6.1,3.4c0,2.5-10,5.3-24.3,5.3c-14.3,0-24.3-2.8-24.3-5.3
                           c0-1.2,2.5-2.6,6.7-3.6l-0.5-0.9c-4.3,1.1-7.2,2.6-7.2,4.5c0,4.1,13,6.3,25.3,6.3s25.3-2.2,25.3-6.3C91.7,45.3,89,43.9,84.9,42.8z
                           "/>
                     </g>
                  </g>
                  <g id="Layer_5">
                     <path fill="#EDC9B8" d="M66.4,110.4c-8.8,0-17.1-0.6-21.5-1.7l0.1-0.5c4.4,1,12.6,1.6,21.4,1.6c9.4,0,18.1-0.7,22.2-1.8l0.1,0.5
                        C84.5,109.7,75.9,110.4,66.4,110.4z"/>
                     <path fill="#EDC9B8" d="M66.4,142.8c-8.8,0-17.1-0.6-21.5-1.7l0.1-0.5c4.4,1,12.6,1.6,21.4,1.6c9.5,0,18-0.7,22.2-1.8l0.1,0.5
                        C84.5,142.1,75.9,142.8,66.4,142.8z"/>
                  </g>
               </svg>
            </div>
         </div>
      </div>
      <div class="hello-parent">
         <svg class="hello-word" width="100%" height="100%" viewBox="0 0 500 500">
            <g id="H-letter">
               <line class="H-left-stroke" x1="17" y1="0" x2="17" y2="124" stroke="#000" fill="none" stroke-width="34" />
               <line class="H-mid-stroke" x1="33" y1="62" x2="68" y2="62" stroke="#000" fill="none" stroke-width="34" />
               <line class="H-right-stroke" x1="84" y1="0" x2="84" y2="124" stroke="#000" fill="none" stroke-width="34" />
            </g>
            <g id="E-letter">
               <line class="E-left-stroke" x1="138" y1="0" x2="138" y2="124" stroke="#000" fill="none" stroke-width="34" />
               <line class="E-top-stroke" x1="154" y1="17" x2="201" y2="17" stroke="#000" fill="none" stroke-width="34" />
               <line class="E-mid-stroke" x1="154" y1="62" x2="196" y2="62" stroke="#000" fill="none" stroke-width="34" />
               <line class="E-bottom-stroke" x1="154" y1="107" x2="201" y2="107" stroke="#000" fill="none" stroke-width="34" />
            </g>
            <g id="L-one-letter">
               <line class="L-one-long-stroke" x1="17" y1="153" x2="17" y2="277" stroke="#000" fill="none" stroke-width="34" />
               <line class="L-one-short-stroke" x1="33" y1="260" x2="77" y2="260" stroke="#000" fill="none" stroke-width="34" />
            </g>
            <g id="L-two-letter">
               <line class="L-two-long-stroke" x1="104" y1="153" x2="104" y2="277" stroke="#000" fill="none" stroke-width="34" />
               <line class="L-two-short-stroke" x1="120" y1="260" x2="164" y2="260" stroke="#000" fill="none" stroke-width="34" />
            </g>
            <g id="O-letter">
               <circle class="O-stroke" cx="231" cy="215" r="48" stroke="#000" fill="none" stroke-width="31" />
            </g>
            <g id="red-dot">
               <!-- Initially I tried creating a circle but it was harder to manipulate it how I wanted to in CSS so I resorted to using a line trick to make it look like a circle ....
                  <circle class="red-dot" cx="325" cy="260" r="20" fill="#FF5851" stroke="none" />
                  
                  -->
               <line x1="325" y1="260" x2="325" y2="260" stroke="#FFC107" class="red-dot" />
            </g>
         </svg>
      </div>
   </div>
   <div class="column">
      <div class="ui centered" style="border:none;">
         <div class="ads">
            <h1 id="Attention">Attention</h1>
            <p class="avertissement">
               L\'abus d\'alcool est dangereux pour la santé, surtout pour la conduite ! Veuillez tester votre taux d\'alcoolemie avant de conduire. Si vous n\'êtes pas en état de conduire, vous pouvez toujours consulter l\'incroyable site de covoiturage réalisé par Antoine DABILLY, Bastian PADIGLIONE et William LIN! Vous pourrez rentrer en tout sécurité et en bonne compagnie. <span style="font-style: italic ">Cliquer sur la voiture pour en savoir plus!</span>
            </p>
            <a href="http://pageperso.iut.univ-paris8.fr/~adabilly/takeU/">
               <div id="voiture" class="car">
                  <div class="body">
                     <div class="mirror-wrap">
                        <div class="mirror-inner">
                           <div class="mirror">
                              <div class="shine"></div>
                           </div>
                        </div>
                     </div>
                     <div class="middle">
                        <div class="top">
                           <div class="line"></div>
                        </div>
                        <div class="bottom">
                           <div class="lights">
                              <div class="line"></div>
                           </div>
                        </div>
                     </div>
                     <div class="bumper">
                        <div class="top"></div>
                        <div class="middle" data-numb="Alcoolol"></div>
                        <div class="bottom"></div>
                     </div>
                  </div>
                  <div class="tyres">
                     <div class="tyre back"></div>
                     <div class="tyre front"></div>
                  </div>
                  <div class="road-wrap">
                     <div class="road">
                        <div class="lane-wrap">
                           <div class="lane">
                              <div></div>
                              <div></div>
                              <div></div>
                              <div></div>
                              <div></div>
                              <div></div>
                              <div></div>
                              <div></div>
                              <div></div>
                              <div></div>
                              <div></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
      </div>
      </a>
   </div>
</div>

  <link rel="stylesheet" type="text/css" href="Module/Accueil/styleAccueil.css?t='.time().'">';

    }
    
}
?>




