<?php
$str = "SELECT v.id, v.titre, v.description, v.bandeAnnonce, 
        v.notePresse, v.noteSpectateur, v.noteZUP, 
        g.label AS 'genre', 
        n.label AS 'nationalite', 
        s.dateDebut, s.statut, f.label
        FROM video v
        LEFT JOIN serie s       ON v.id = s.idVideo
        LEFT JOIN genre g       ON v.genre = g.id
        LEFT JOIN nationalite n ON v.nationalite = n.id
        LEFT JOIN formatserie f ON s.format = f.id";
?>