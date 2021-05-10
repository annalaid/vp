import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;


public class Main {
    public static void main(String[] args) throws IOException {
        File loremIpsum = new File("loremipsum.txt");

        FileReader readFile = new FileReader(loremIpsum);
        BufferedReader readText = new BufferedReader(readFile);
        
        String[] lineDatas = null;
        String line = readText.readLine();
        List<String> formattedStrings = new ArrayList<>();
        List<String> lastLetters= new ArrayList<>();
        Map<String, Integer> letterCount = new HashMap<>();
        
        while (line != null){
            lineDatas = line.split(" ");
            line = readText.readLine();
        }

        readFile.close();
        readText.close();

        if(lineDatas!=null) {
            for (String string : lineDatas) {
                formattedStrings.add(string.replaceAll("[\\-\\+\\.\\^:,]", ""));
            }
        }
        System.out.println("Kõik sõnad: " + formattedStrings);

        for (String string : formattedStrings) {
            lastLetters.add(string.substring(string.length() - 1));
        }
        System.out.println("Kõik viimased tähed: " + lastLetters);

        for (String string : lastLetters) {
            int CountInList = 0;
            for(int i = 0; i < string.length(); i++){
                if(string.toUpperCase().charAt(i) == "A".charAt(0)){
                    CountInList++;
                }
                if(string.toUpperCase().charAt(i) == "C".charAt(0)){
                    CountInList++;
                }
                if(string.toUpperCase().charAt(i) == "D".charAt(0)){
                    CountInList++;
                }
                if(string.toUpperCase().charAt(i) == "E".charAt(0)){
                    CountInList++;
                }
                if(string.toUpperCase().charAt(i) == "G".charAt(0)){
                    CountInList++;
                }
                if(string.toUpperCase().charAt(i) == "T".charAt(0)){
                    CountInList++;
                }
            }
                letterCount.put(string, CountInList);
        }

        System.out.println(letterCount);
    }
}