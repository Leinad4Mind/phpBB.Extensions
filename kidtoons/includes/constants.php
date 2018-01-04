<?php
/**
* This file is part of the KidToons package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\kidtoons\includes;

class constants
{
	// Movie types
	const MOVIE_TYPE_2D = '2d';
	const MOVIE_TYPE_3D = '3d';
	const MOVIE_TYPE_HYBRID = 'f';

	// HDR formats
	const HDR_FORMAT_NONE = 0;
	const HDR_FORMAT_HDR = 1;
	const HDR_FORMAT_DV = 2;
	const HDR_FORMAT_HLG = 3;

	// Scanning types
	const SCAN_TYPE_I = 'i';
	const SCAN_TYPE_P = 'p';

	// Matching types
	const MATCH_TYPE_NONE = 0;
	const MATCH_TYPE_WELL = 1;
	const MATCH_TYPE_LOW = 2;

	// Bonus types
	const BONUS_TYPE_NONE = 0;
	const BONUS_TYPE_MOVIE = 1;
	const BONUS_TYPE_SERIES = 2;
	const BONUS_TYPE_GROUP = 3;
}
