import java.util.ArrayList;
import java.util.List;
import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);

        List<Szotar> dictionary = new ArrayList<>();
        for (int i = 0; i < 26; i++) {
            dictionary.add(new Szotar(String.valueOf((char) ('A' + i)), i + 1));
        }

        System.out.println("Enter a string: ");
        String input = scanner.nextLine();
        char[] inputToCharArr = input.toCharArray();

        String currentSequence = "";
        List<Integer> outputCodes = new ArrayList<>();

        for (int i = 0; i < inputToCharArr.length; i++) {
            String nextChar = String.valueOf(inputToCharArr[i]);
            String combinedSequence = currentSequence + nextChar;

            boolean existsInDictionary = false;

            for (Szotar entry : dictionary) {
                if (entry.getElement().equals(combinedSequence)) {
                    existsInDictionary = true;
                    break;
                }
            }

            if (existsInDictionary) {
                currentSequence = combinedSequence;
            } else {
                for (Szotar entry : dictionary) {
                    if (entry.getElement().equals(currentSequence)) {
                        outputCodes.add(entry.getCode());
                        break;
                    }
                }
                dictionary.add(new Szotar(combinedSequence, dictionary.size() + 1));
                currentSequence = nextChar;
            }
        }

        for (Szotar entry : dictionary) {
            if (entry.getElement().equals(currentSequence)) {
                outputCodes.add(entry.getCode());
                break;
            }
        }

        System.out.println("\nDictionary:");
        for (Szotar d : dictionary) {
            System.out.println("Element: " + d.getElement() + " Code: " + d.getCode());
        }

        System.out.println("\nLZW Output Codes:");
        for (int code : outputCodes) {
            System.out.print(code + "|");
        }
        scanner.close();
    }

}