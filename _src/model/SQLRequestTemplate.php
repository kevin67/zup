<?php
	// Requête MovieManager
	define(
		"MOVIE_BASIC_REQUEST",
		"SELECT v.id, v.titre, v.titreOriginal, v.description, v.image, v.bandeAnnonce, 
			FORMAT(v.notePresse,1) AS 'notePresse', 
			FORMAT(v.noteSpectateur,1) AS 'noteSpec', 
			f.anneeProd AS 'dateSortie', 
			
			(
				SELECT FORMAT(AVG(uzn.note),1) FROM userznote uzn WHERE uzn.idVideo = v.id
			) AS 'noteZUP', 
			
			(
				SELECT GROUP_CONCAT(DISTINCT g.label ORDER BY g.label ASC SEPARATOR ', ')
				FROM genre g
				LEFT OUTER JOIN genrevideo gv
				ON g.id = gv.idGenre
				WHERE gv.idVideo = v.id
			) AS 'genre', 
			
			(
				SELECT GROUP_CONCAT(DISTINCT n.label ORDER BY n.label ASC SEPARATOR ', ')
				FROM nationalite n
				LEFT OUTER JOIN nationalitevideo nv
				ON n.id = nv.idNationalite
				WHERE nv.idVideo = v.id
			) AS 'nationalite', 
			
			(
				SELECT GROUP_CONCAT(DISTINCT a.nom ORDER BY av.prior ASC SEPARATOR ', ')
				FROM personne a
				LEFT OUTER JOIN role av
				ON a.id = av.idPersonne
				WHERE av.idVideo = v.id
                AND av.fonction = 8001
			) AS 'acteurs', 
			
			(
				SELECT GROUP_CONCAT(DISTINCT a.nom ORDER BY av.prior ASC SEPARATOR ', ')
				FROM personne a
				LEFT OUTER JOIN role av
				ON a.id = av.idPersonne
				WHERE av.idVideo = v.id
                AND av.fonction = 8002
			) AS 'real' 
			
			FROM video v
			RIGHT JOIN film f 
			ON v.id = f.idVideo "
	);
	
	// Requête GenreManager
	define(
		"GENRE_BASIC_REQUEST",
		"SELECT `id`, `label` FROM `genre`"
	);
	
	// Requête NationManager
	define(
		"NATIO_BASIC_REQUEST",
		"SELECT `id`, `label` FROM `nationalite`"
	);
	
	// Requête PersonManager
	define(
		"PERS_BASIC_REQUEST",
		"SELECT `id`, `nom` FROM `personne`"
	);
	
	// Requête HostManager
	define(
		"HOST_BASIC_REQUEST",
		"SELECT `id`, 
		`nom`, 
		`url` 
		FROM `hebergeur`"
	);
	
	// Requête HostManager - Liens
	define(
		"LINK_BASIC_REQUEST",
		"SELECT h.id, 
		h.nom, h.url, 
		l.url AS 'link' 
		FROM hebergeur h 
		RIGHT JOIN lienfilm l 
		ON h.id = l.idHebergeur "
	);
	
	// Requête RightManager
	define(
		"RIGHT_BASIC_REQUEST",
		"SELECT `id`, 
		`label`, 
		`panelAdmin`, 
		`requestManager`, 
		`dataExaminer`, 
		`recruitmentManager`, 
		`rightsManager` 
		FROM `droitsite`"
	);

	
	// Requête RequestManager
	define(
		"REQUEST_BASIC_REQUEST",
		'SELECT r.idAllocine, r.nom, u.login, 
		DATE_FORMAT(r.dateDemande, "%d/%m/%Y") AS "date", 
		r.url, r.completer 
		FROM requete r 
		LEFT JOIN user u 
		ON r.demandeur = u.id '
	);
?>