<?php
/**
* This file is part of the KidToons package.
*
* @copyright (c) VinaBB <vinabb.vn>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace vinabb\kidtoons\migrations\v10x;

use phpbb\db\migration\migration;

/**
* Default data for video/audio codecs
*/
class codecs_data extends migration
{
	/**
	* List of required migrations
	*
	* @return array
	*/
	static public function depends_on()
	{
		return ['\vinabb\kidtoons\migrations\v10x\codecs_schema'];
	}

	/**
	* Update data
	*
	* @return array
	*/
	public function update_data()
	{
		return [['custom', [[$this, 'insert_data']]]];
	}

	/**
	* Insert default data
	*/
	public function insert_data()
	{
		// Load the insert buffer class to perform a buffered multi insert
		$insert_buffer = new \phpbb\db\sql_insert_buffer($this->db, $this->table_prefix . 'kt_codecs');

		// Prepare data
		$data = array_merge($this->get_video_codecs(), $this->get_audio_codecs());

		// Insert data
		foreach ($data as $row)
		{
			$insert_buffer->insert($row);
		}

		// Flush the buffer
		$insert_buffer->flush();
	}

	/**
	* List of video codecs
	*
	* @return array
	*/
	public function get_video_codecs()
	{
		return [
			[
				'codec'				=> 'MPG',
				'codec_name'		=> 'MPEG-1/2',
				'codec_fullname'	=> 'MPEG Video Layer 1/2',
				'codec_video'		=> true,
			],
			[
				'codec'				=> 'VC1',
				'codec_name'		=> 'VC-1',
				'codec_fullname'	=> 'SMPTE 421M Video Coding',
				'codec_video'		=> true,
			],
			[
				'codec'				=> 'AVC',
				'codec_name'		=> 'MPEG-4p10/AVC/h.264',
				'codec_fullname'	=> 'MPEG-4 Part 10 / Advanced Video Coding / H.264',
				'codec_video'		=> true,
			],
			[
				'codec'				=> 'HVC',
				'codec_name'		=> 'MPEG-H/HEVC/h.265',
				'codec_fullname'	=> 'MPEG-H Part 2 / High Efficiency Video Coding / H.265',
				'codec_video'		=> true,
			]
		];
	}

	/**
	* List of video codecs
	*
	* @return array
	*/
	public function get_audio_codecs()
	{
		return [
			[
				'codec'				=> 'MP3',
				'codec_name'		=> 'MP3',
				'codec_fullname'	=> 'MPEG-1/2 Audio Layer 3',
				'codec_video'		=> false,
			],
			[
				'codec'				=> 'AAC',
				'codec_name'		=> 'AAC',
				'codec_fullname'	=> 'Advanced Audio Coding',
				'codec_video'		=> false,
			],
			[
				'codec'				=> 'FLC',
				'codec_name'		=> 'FLAC',
				'codec_fullname'	=> 'Free Lossless Audio Codec',
				'codec_video'		=> false,
			],
			[
				'codec'				=> 'PCM',
				'codec_name'		=> 'LPCM',
				'codec_fullname'	=> 'Linear Pulse Code Modulation',
				'codec_video'		=> false,
			],
			[
				'codec'				=> 'AC3',
				'codec_name'		=> 'AC-3/E-AC-3',
				'codec_fullname'	=> 'Dolby Digital / Dolby Digital EX / Dolby Digital Plus',
				'codec_video'		=> false,
			],
			[
				'codec'				=> 'DDT',
				'codec_name'		=> 'TrueHD',
				'codec_fullname'	=> 'Dolby TrueHD',
				'codec_video'		=> false,
			],
			[
				'codec'				=> 'DDA',
				'codec_name'		=> 'TrueHD Atmos',
				'codec_fullname'	=> 'Dolby Atmos',
				'codec_video'		=> false,
			],
			[
				'codec'				=> 'DTS',
				'codec_name'		=> 'DTS',
				'codec_fullname'	=> 'DTS Audio Codec',
				'codec_video'		=> false,
			],
			[
				'codec'				=> 'DEX',
				'codec_name'		=> 'DTS Express',
				'codec_fullname'	=> 'DTS Express',
				'codec_video'		=> false,
			],
			[
				'codec'				=> 'DES',
				'codec_name'		=> 'DTS-ES',
				'codec_fullname'	=> 'DTS Extended Surround',
				'codec_video'		=> false,
			],
			[
				'codec'				=> 'DHR',
				'codec_name'		=> 'DTS-HD High Resolution',
				'codec_fullname'	=> 'DTS-HD High Resolution Audio',
				'codec_video'		=> false,
			],
			[
				'codec'				=> 'DMA',
				'codec_name'		=> 'DTS-HD Master Audio',
				'codec_fullname'	=> 'DTS-HD Master Audio',
				'codec_video'		=> false,
			],
			[
				'codec'				=> 'DTX',
				'codec_name'		=> 'DTS:X',
				'codec_fullname'	=> 'DTS Experience',
				'codec_video'		=> false,
			]
		];
	}
}
