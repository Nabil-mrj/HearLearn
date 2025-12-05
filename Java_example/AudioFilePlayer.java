import javax.sound.sampled.*;
import java.io.File;
import java.io.IOException;
import java.util.Scanner;

public class AudioFilePlayer {

    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);

        System.out.println("\n=== Bienvenue dans le lecteur audio de cours ! ===\n");

        while (true) {
            System.out.println("Veuillez entrer le chemin du dossier contenant vos fichiers audio (WAV) :");
            String folderPath = scanner.nextLine();

            File folder = new File(folderPath);

            if (!folder.exists() || !folder.isDirectory()) {
                System.out.println("Le chemin fourni n'est pas un dossier valide. Veuillez réessayer.\n");
                continue;
            }

            // Liste les fichiers WAV dans le dossier
            File[] audioFiles = folder.listFiles((dir, name) -> name.toLowerCase().endsWith(".wav"));

            if (audioFiles == null || audioFiles.length == 0) {
                System.out.println("Aucun fichier WAV trouvé dans le dossier. Veuillez réessayer.\n");
                continue;
            }

            System.out.println("\nFichiers audio disponibles :\n");
            for (int i = 0; i < audioFiles.length; i++) {
                System.out.printf("[%d] %s\n", i + 1, audioFiles[i].getName());
            }

            System.out.println("\nEntrez le numéro du fichier que vous souhaitez lire (ou 0 pour quitter) :");
            int choice;

            try {
                choice = Integer.parseInt(scanner.nextLine());
            } catch (NumberFormatException e) {
                System.out.println("Entrée invalide. Veuillez entrer un numéro valide.\n");
                continue;
            }

            if (choice == 0) {
                System.out.println("Merci d'avoir utilisé le lecteur audio. Au revoir !");
                break;
            }

            if (choice < 1 || choice > audioFiles.length) {
                System.out.println("Numéro invalide. Veuillez choisir un numéro dans la liste.\n");
                continue;
            }

            File selectedFile = audioFiles[choice - 1];
            System.out.println("\nLecture du fichier : " + selectedFile.getName() + "\n");

            playAudio(selectedFile);
        }

        scanner.close();
    }

    private static void playAudio(File audioFile) {
        try (AudioInputStream audioStream = AudioSystem.getAudioInputStream(audioFile)) {
            Clip clip = AudioSystem.getClip();
            clip.open(audioStream);
            clip.start();

            System.out.println("Appuyez sur Entrée pour arrêter la lecture.");
            new Scanner(System.in).nextLine();

            clip.stop();
            clip.close();
        } catch (UnsupportedAudioFileException e) {
            System.out.println("Le format du fichier audio n'est pas pris en charge : " + e.getMessage());
        } catch (IOException e) {
            System.out.println("Erreur lors de la lecture du fichier audio : " + e.getMessage());
        } catch (LineUnavailableException e) {
            System.out.println("Ressources audio non disponibles : " + e.getMessage());
        }
    }
}
