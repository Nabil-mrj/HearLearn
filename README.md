# HEARlearn — Audio augmentation platform for academic material

HEARlearn is a web platform designed to transform course materials (PDF) into audio tracks and analyze user interaction with the content.  
The project demonstrates a complete pipeline for ingestion, processing, and visualization of data derived from educational materials.

## Technical Objectives

- Develop a web interface for importing documents (PDF, audio).
- Provide synchronized visualization between text-based material and audio playback.
- Implement a usage-tracking system (interactions, listening behavior, completion rates).
- Build a technical foundation extensible to speech synthesis models or behavioral analysis components.

## Features

### Document ingestion & management
- Upload of PDF and audio files.
- Server-side storage and metadata handling through PHP scripts.

### Visualization and playback
- Unified display of PDF documents and audio player within a responsive interface.
- Basic navigation within audio tracks.

### Tracking & analytics
- Collection of user interactions.
- Logging of statistics through dedicated scripts.
- Dashboard providing initial analytical insights.

### Java Prototype (Proof of Concept)
- Console-based audio playback.
- Basic error handling and demonstration of an offline module.
- Included in the `Java_example/` directory.

## Project Architecture

### Front-end
- HTML5 / CSS3
- JavaScript
- Main pages:
  - `index.html`: project entry point, links to all deliverables.
  - `presentation.html`: concept description.

### Back-end
- PHP for:
  - document ingestion (`upload.php`),
  - content visualization (`home.php`),
  - statistics (`dashboard.php`),
  - activity logging (`updateStats.php`, `statsFunctions.php`).

### General organization
- Clear separation between ingestion, visualization, and tracking layers.
- Standalone scripts for server operations and file manipulation.
- Slides and documentation accessible through the web interface.

## Data and Analytical Tracking

The tracking module provides a foundation for data/ML work:

- logging of engagement metrics (listens, durations, recurrence),
- analyzable data extraction for exploratory analysis,
- potential extensions such as:
  - churn prediction models,
  - user segmentation,
  - recommendation systems,
  - integration of TTS APIs (HuggingFace, Coqui, OpenAI).

## Repository Structure

```text
.
├── README.md
│
├── index.html                                  # Entry point of the project, links to all deliverables
├── presentation.html                            # Concept description page
├── presentation.pdf                             # Project slides
│
├── home.php                                     # Main interface: PDF viewer + audio player
├── upload.php                                   # Document ingestion (PDF/audio)
├── dashboard.php                                # User activity analytics dashboard
├── updateStats.php                              # Logging of user interactions
├── statsFunctions.php                            # Utility functions for tracking and stats processing
│
└── Java_example/
    └── code_java.html                           # Java prototype: minimal audio playback demo

```

## Future Improvements

- Integration of a neural TTS pipeline.
- Automatic text/audio alignment (forced alignment).
- Embedding extraction for semantic search.
- Migration of analytics to a REST API + SQL-based backend.
- Automatic generation of chapters, segments, and summaries.
