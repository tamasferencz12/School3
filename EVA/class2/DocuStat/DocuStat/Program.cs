using DocuStat.Model;

namespace DocuStat
{
    internal class Program
    {
        static int Main(string[] args)
        {
            string path;
            do
            {
                Console.WriteLine("please enter a valid text file path: ");
                path = Console.ReadLine() ?? "";
            }
            while (System.IO.Path.GetExtension(path) != ".txt" || !System.IO.File.Exists(path));

            DocumentumStatistics stat = new DocumentumStatistics(path);

            try
            {
                stat.Load();
            }
            catch (System.IO.IOException e)
            {
                Console.WriteLine("The file could not be read!");
                Console.WriteLine(e.Message);
                return -1;
            }

            Console.WriteLine($"CharacterCount: {stat.CharacterCount}");
            Console.WriteLine($"NonWhiteSpaceCharacterCount: {stat.NonWhiteSpaceCharacterCount}");
            Console.WriteLine($"SentenceCount: {stat.SentenceCount}");

            Console.WriteLine();
            Console.WriteLine("Parameters for word counting");
            int minLength = ReadPositive("Minimum word length: ");
            int minOccurance = ReadPositive("Minimum word occurance: ");

            Console.WriteLine();
            Console.WriteLine("Ignored words (separated by comma):");
            List<string> ignoredWords = new List<string>();
            bool success = false;
            do
            {
                try { 
                    string line = Console.ReadLine() ?? string.Empty;
                    ignoredWords = line.Split(',').Select(x => x.Trim().ToLower()).ToList();
                    success = true;
                }
                catch (Exception)
                {
                    Console.WriteLine("Incorrect format!");
                }
            }
            while (!success);

            var pairs = stat.DistinctWordCount
                .Where(x => x.Value >= minOccurance)
                .Where(x => x.Key.Length >= minLength)
                .Where(x => !ignoredWords.Contains(x.Key))
                .OrderByDescending(x => x.Value);


            foreach (var pair in pairs)
            {
                Console.WriteLine($"{pair.Key}: {pair.Value}");
            }


            return 0;
        }

        static int ReadPositive(string text)
        {
            int number;
            bool success;
            do
            {
                Console.WriteLine(text);
                success = int.TryParse(Console.ReadLine(), out number) && number > 0;
            }
            while (!success);
            return number;
        }
    }
}
