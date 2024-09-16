using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace DocuStat.Model
{
    public class DocumentumStatistics
    {
        #region
        private readonly string filePath;
        #endregion

        public string FileContent { get; private set; }
        public Dictionary<string, int> DistinctWordCount { get; private set; }

        public int CharacterCount { get; private set; }
        public int NonWhiteSpaceCharacterCount { get; private set; }
        public int SentenceCount { get; private set; }
        public int ProperNounCount { get; private set; }

        public DocumentumStatistics(string filepath)
        {
            this.filePath = filepath;
            FileContent = string.Empty;
            DistinctWordCount = new Dictionary<string, int>();
            CharacterCount = 0;
            NonWhiteSpaceCharacterCount = 0;
            SentenceCount = 0;
            ProperNounCount = 0;
        }

        public void Load()
        {
            FileContent = File.ReadAllText(filePath);

            CharacterCount = FileContent.Length;
            NonWhiteSpaceCharacterCount = FileContent.Count(x => !char.IsWhiteSpace(x));

            ComputeDistinctWords();
            SentenceCount = ComputeSentenceCount();
            ProperNounCount = ComputeProperNounCount();

        }

        private int ComputeProperNounCount()
        {
            int nounCount = 0;
            var marks = new char[] { '.', '?', '!' };
            
            for (int i = 1; i < FileContent.Length; i++)
            {
                char currentChar = FileContent[i];
                char previousChar = FileContent[i - 1];

                if ( char.IsUpper(currentChar) && !marks.Contains(previousChar))
                {
                    nounCount++;
                }
            }
            return nounCount;
        }

        private int ComputeSentenceCount()
        {
            int sentenceCount = 0;
            var marks = new char[] {'.',  '?', '!'};
            for (int i = 1; i < FileContent.Length; i++)
            {
                if (marks.Contains(FileContent[i]) && !marks.Contains(FileContent[i - 1])){
                    sentenceCount++;
                }
            }
            return sentenceCount;
        }

        private void ComputeDistinctWords()
        {
            DistinctWordCount.Clear();
            string[] words = FileContent.Split().Where(x => x.Length > 0).ToArray();
            for (int i = 0; i < words.Length; i++)
            {
                words[i] = string.Concat(words[i].SkipWhile(x => !char.IsLetter(x)).Reverse().SkipWhile(x => !char.IsLetter(x)).Reverse());
                if (string.IsNullOrEmpty(words[i]))
                {
                    continue;
                }
                words[i] = words[i].ToLower();
                if (DistinctWordCount.ContainsKey(words[i]))
                {
                    DistinctWordCount[words[i]]++;
                }
                else
                {
                    DistinctWordCount.Add(words[i], 1);
                }
            }
        }
    }
}
