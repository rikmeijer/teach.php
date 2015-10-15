<?php

/* 
 * application specific bootstrapper
 */
return function() {
	require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

	define("MI_VERBAAL_LINGUISTISCH", "verbaal-linguistisch");
	define("MI_LOGISCH_MATHEMATISCH", "logisch-mathematisch");
	define("MI_VISUEEL_RUIMTELIJK", "visueel-ruimtelijk");
	define("MI_MUZIKAAL_RITMISCH", "muzikaal-ritmisch");
	define("MI_LICHAMELIJK_KINESTHETISCH", "lichamelijk-kinesthetisch");
	define("MI_NATURALISTISCH", "naturalistisch");
	define("MI_INTERPERSOONLIJK", "interpersoonlijk");
	define("MI_INTRAPERSOONLIJK", "intrapersoonlijk");
};