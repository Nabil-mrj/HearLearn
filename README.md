# HEARlearn — Audio Augmentation Platform for Academic Material

HEARlearn est une plateforme web permettant de transformer des supports de cours (PDF) en pistes audio et d’analyser l’usage de ces contenus.  
Le projet démontre un pipeline complet d’ingestion, traitement et visualisation de données autour de contenus pédagogiques.

## Objectifs techniques

- Développer une interface web pour l’import de documents (PDF, audio).
- Offrir une consultation synchronisée support visuel / lecture audio.
- Implémenter un système de suivi d’usage (interactions, écoutes, complétions).
- Construire une base technique extensible vers des modèles de synthèse vocale ou d’analyse comportementale.

## Fonctionnalités

### Ingestion & gestion de documents
- Upload de fichiers PDF et audio.
- Stockage serveur et gestion des métadonnées via scripts PHP.

### Visualisation et lecture
- Affichage simultané PDF + lecteur audio dans une interface responsive.
- Navigation simple dans les pistes audio.

### Tracking & analyse
- Collecte des interactions utilisateurs.
- Enregistrement des statistiques via scripts dédiés.
- Dashboard permettant une première exploration analytique.

### Prototype Java (Proof of Concept)
- Lecture audio via console.
- Gestion d’erreurs et démonstration minimale d’un module hors web.
- Présent dans le dossier `Java_example/`.

## Architecture du projet

### Front-end
- HTML5 / CSS3
- JavaScript minimal
- Pages principales :
  - `index.html` : entrée du projet, liens vers livrables.
  - `presentation.html` : description textuelle du concept.

### Back-end
- PHP pour :
  - ingestion (`upload.php`),
  - visualisation (`home.php`),
  - statistiques (`dashboard.php`),
  - collecte d’activité (`updateStats.php`, `statsFunctions.php`).

### Organisation générale
- Séparation nette entre ingestion, visualisation et tracking.
- Scripts autonomes pour opérations serveur et manipulation des fichiers.
- Slides et documents intégrés via l’interface web.

## Données et suivi analytique

Le module de tracking constitue un socle exploitable pour des travaux data/ML :

- journalisation de l’engagement (écoutes, durées, récurrence),
- extraction exploitable pour analyses exploratoires,
- potentiel d’évolution vers :
  - modèles prédictifs d’abandon,
  - segmentation utilisateur,
  - systèmes de recommandation,
  - intégration d’API TTS (HuggingFace, Coqui, OpenAI).

## Contenu du dépôt

- `home.php` : interface principale PDF + audio.
- `dashboard.php` : tableau de bord analytique.
- `upload.php` : ingestion des documents.
- `updateStats.php` / `statsFunctions.php` : suivi des interactions.
- `index.html` : page centrale listant les livrables.
- `presentation.pdf` : slides du projet.
- `presentation.html` : description du concept.
- `Java_example/` : prototype Java.

## Axes d’amélioration

- Intégration d’un pipeline TTS basé sur modèles neuronaux.
- Alignement automatique texte/audio (forced alignment).
- Extraction d’embeddings pour recherche sémantique.
- Migration du module analytique vers API REST + base SQL.
- Génération automatique de segments, résumés et chapitres.
