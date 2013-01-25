<?php

return array(
    array(
        'label' => "accueil",
        'uri' => '/'
    ),
    array(
        'label' => "client",
        'uri' => '/client',
        'pages' => array(
            array(
                'label' => "rechercher",
                'uri' => '/client/rechercher'
            ), array(
                'label' => "lister",
                'uri' => '/client/lister'
            )
        )
    ),
    array(
        'label' => "Fiche de commande",
        'uri' => '/fiche-commande',
        'pages' => array(
            array(
                'label' => "rechercher",
                'uri' => '/fiche-commande/rechercher'
            ), array(
                'label' => "lister",
                'uri' => '/fiche-commande/lister'
            )
        )
    ),
    array(
        'label' => "S.A.V.",
        'uri' => '/sav',
        'pages' => array(
            array(
                'label' => "rechercher",
                'uri' => '/sav/rechercher'
            ), array(
                'label' => "lister",
                'uri' => '/sav/lister'
            )
        )
    )
);
/*
$menu2 = array(
    array(
        'label' => 'ACCUEIL',
        'action' => 'index',
        'controller' => 'index'
    ),
    array(
        'label' => 'Delete',
        'action' => 'delete'
    )
);
*/
?>