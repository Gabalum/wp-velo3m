
# Vélo3m

Ce plugin a pour but de proposer des outils Wordpress avec des données associées au vélo dans la Métropole Montpellier Méditerrannée.




## Shortcodes

Le shortcode [arceaux3m] permet d'afficher une carte (Leaflet) avec l'ensemble des arceaux disponibles sur le territoire 3M.

Ces données sont issues de la plateforme Open-Data 3M : https://data.montpellier3m.fr/dataset/arceaux-velo-de-montpellier-mediterranee-metropole

Le shortcode accepte 3 paramètres : 
* width : la largeur de la carte exprimée en % ou px
* height : la hauteur de la carte exprimée en % ou px
* map : le type de fond de carte entre : 
    * osm : Un fond OpenStreetMap classique
    * cyclosm : Un fond CyclOSM
    * default : Un fond de carte gris (CartoDB)

Par défaut, c'est le fond gris qui est en place, avec une largeur de 100% et une hauteur de 350px.