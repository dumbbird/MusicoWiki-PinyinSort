<?php
namespace PinyinSort;

class Converter {

	public static function zh2pinyin($string) {
		$len = mb_strlen($string, 'UTF-8');
		$builder = '';
		
		for ($i = 0; $i < $len; $i++) {
			$char = mb_substr($string, $i, 1, 'UTF-8');

			// ASCII characters: keep as is
			if (ord($char[0]) < 128) {
				$builder .= $char;
				continue;
			}

			// Preserve circled number symbols (①–㊿, ⑴–⒇, ⒈–⒛, ❶–❿)
			$code = self::uniord($char);
			if (
				($code >= 0x2460 && $code <= 0x2473) || // ①–⑳
				($code >= 0x2474 && $code <= 0x249B) || // ⑴–⒇
				($code >= 0x249C && $code <= 0x24B5) || // ⒈–⒛
				($code >= 0x2776 && $code <= 0x277F) || // ❶–❿
				($code >= 0x3200 && $code <= 0x32FF) || // (Japanese circled numbers)

				// Emoji ranges
				($code >= 0x1F000 && $code <= 0x1F5FF) || // Misc Symbols and Pictographs
				($code >= 0x1F600 && $code <= 0x1F64F) || // Emoticons (smileys)
				($code >= 0x1F680 && $code <= 0x1F6FF) || // Transport & Map Symbols
				($code >= 0x1F700 && $code <= 0x1F77F) || // Alchemical Symbols
				($code >= 0x1F780 && $code <= 0x1F7FF) || // Geometric Shapes Extended
				($code >= 0x1F800 && $code <= 0x1F8FF) || // Supplemental Arrows-C
				($code >= 0x1F900 && $code <= 0x1F9FF) || // Supplemental Symbols and Pictographs
				($code >= 0x1FA00 && $code <= 0x1FA6F) || // Chess, symbols, hands, etc.
				($code >= 0x1FA70 && $code <= 0x1FAFF) || // Symbols and pictographs extended-A
				($code >= 0x2600 && $code <= 0x26FF) ||   // Misc symbols (☀️, ⚽, ♻️)
				($code >= 0x2700 && $code <= 0x27BF) ||   // Dingbats (✈️, ✉️, ❤️)
				($code >= 0x1F1E6 && $code <= 0x1F1FF)    // Regional indicator symbols (flags 🇨🇳🇺🇸)
			) {
				$builder .= $char;
				continue;
			}

			// Chinese character → Pinyin (using lookup table)
			if (isset(ConversionTable::$zh2pinyin[$char])) {
				$builder .= ucfirst(ConversionTable::$zh2pinyin[$char]);
			} else {
				$builder .= '?';
			}
		}
		
		return $builder;
	}

	// Helper: get Unicode codepoint of multibyte character
	private static function uniord($char) {
		$k = mb_convert_encoding($char, 'UCS-4BE', 'UTF-8');
		$k1 = unpack('N', $k);
		return $k1[1];
	}
}
