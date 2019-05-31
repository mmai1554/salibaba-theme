<?php

/*
 * *********************************************
 * Copyright (c) 2006
 * Mai-Internet
 * Michael Mai <mm@mai-internet.de>
 * D-24768 Rendsburg
 * Germany
 * www.mai-internet.de
 * *********************************************
 */


/*
 * MIHTML.class.php
 * Copyright 2006 by Mai-Internet
 * Statische Klasse für MIHTML-Output
 * 
 */

abstract class MIHTML {

	public static function getHTML( $strHTML ) {
		return '<html>' . $strHTML . '</html>';
	}

	public static function getHead( $strHTML ) {
		return '<head>' . $strHTML . '</head>';
	}

	public static function getStrong( $html ) {
		return '<strong>' . $html . '</strong>';
	}

	public static function getBody( $strHTML ) {
		return '<body>' . $strHTML . '</body>';
	}

	public static function getEM( $html ) {
		return '<em>' . $html . '</em>';
	}

	public static function getAnchor( $strHTML, $strURL ) {
		$tag = '<a href="';
		$tag .= $strURL . '" >';
		$tag .= $strHTML . '</a>';

		return $tag;
	}

	/**
	 * @param string $for
	 * @param string $content
	 *
	 * @return string
	 */
	public static function getLabel( $for, $content ) {
		return '<label for="' . $for . '">' . $content . '</label>';
	}

	public static function wrapA( $strHTML, $strURL ) {
		return MIHTML::getAnchor( $strHTML, $strURL );
	}

	/**
	 * @param $strHTML
	 * @param $strURL
	 * @param bool $new_tab
	 *
	 * @return string
	 */
	public static function getLink( $strHTML, $strURL, $new_tab = false ) {
		$target = $new_tab ? 'target="_blank"' : '';
		return '<a href="' . $strURL . '" '.$target.'>' . $strHTML . '</a>';
	}

	/**
	 * Liefert IFrame-Tag
	 *
	 * @param string $url URL
	 * @param string $width Style-Angabe, z.B. 100% oder 400px
	 * @param string $height wie width
	 * @param string $name Name-Attribut
	 *
	 * @return string IFrame-Tag mit Alternativ-Anzeige für Browser ohne IFrames
	 */
	public static function getIFrame( $url, $width = "100%", $height = "400", $name = 'iframe' ) {
		return '<iframe src="' . $url . '" width="' . $width . '" height="' . $height . '", name="' . $name . '"><p>Ihr Browser kann leider keine IFrames anzeigen</p></iframe>';
	}

	/**
	 * Liefert SPAN-Tag zurück
	 *
	 * @param string $strHTML InnerHTML
	 * @param string $class Class-Angaben
	 * @param string $style
	 * @param string $title
	 *
	 * @return string
	 */
	public static function getSPAN( $strHTML, $class = '', $style = '', $title = '' ) {
		if ( $class ) {
			$class = 'class="' . $class . '"';
		}
		if ( $title ) {
			$title = ' title="' . $title . '"';
		}
		if ( $style ) {
			$style = ' style="' . $style . '"';
		}

		return '<span ' . $class . $style . $title . '>' . $strHTML . '</span>';
	}

	public static function getLI( $strHTML, $class = '', $role = '' ) {
		if ( $class ) {
			$class = 'class="' . $class . '"';
		}
		if ( $role ) {
			$role = ' role="' . $role . '"';
		}

		return '<li ' . $class . $role . '>' . $strHTML . '</li>';
	}

	public static function getUL( $arrList, $class = '', $role = '') {
		if ( $class ) {
			$class = 'class="' . $class . '"';
		}
		if ( $role ) {
			$role = ' role="' . $role . '"';
		}
		if ( is_string( $arrList ) ) {
			$arrList = array( $arrList );
		}
		if (count($arrList) == 0) {
			return '';
		} else {
			$s = '<ul ' . $class . $role . '>';
			foreach ( $arrList as $el ) {
				$s .= "<li>$el</li>";
			}
			return $s . "</ul>";
		}
	}

	public static function BR( $count = 1 ) {
		return str_repeat( '<br>', $count );
	}

	/**
	 * @param string $src
	 * @param string $alt
	 *
	 * @return string
	 */
	public static function getImage( $src, $alt = '' ) {
		return '<img src="' . $src . '" alt="' . $alt . '" title="' . $alt . '" >';
	}

	/**
	 * Liefert DIV-Tag zurück
	 *
	 * @param string $strHTML InnerHTML
	 * @param string $class Class-Angaben
	 * @param string $style Style-Angaben
	 * @param string $strId DOM-Id
	 *
	 * @return string HTML div
	 */
	public static function getDIV( $strHTML, $class = '', $style = '', $strId = '' ) {
		$strId = MIHTML::getIdAttribute( $strId );
		$style = self::getStyle( $style );
		$class = self::getClass( $class );

		return sprintf( '<div%s%s%s>%s</div>', $strId, $style, $class, $strHTML );
	}

	public static function getH1( $strHTML ) {
		return '<h1>' . $strHTML . '</h1>';
	}

	public static function getH2( $strHTML ) {
		return '<h2>' . $strHTML . '</h2>';
	}

	public static function getH3( $strHTML ) {
		return '<h3>' . $strHTML . '</h3>';
	}

	public static function getP( $strHTML ) {
		return '<p>' . $strHTML . '</p>';
	}

	/**
	 * Liefert eine <table></table> Anweisung zurück
	 *
	 * @param string $strHTML
	 * @param string $style
	 * @param string $class
	 * @param string $id
	 *
	 * @return string
	 */
	public static function getTable( $strHTML, $style = '', $class = '', $id = '' ) {
		$id    = self::getIdAttribute( $id );
		$class = self::getClass( $class );
		$style = self::getStyle( $style );

		return "<table $id$class$style>" . $strHTML . "</table>";
	}

	/**
	 * @param $arrList
	 * @param bool $show_empty_rows
	 *
	 * @return string
	 */
	public static function getTableAssoc( $arrList, $show_empty_rows = true ) {
		$html = '<div class="object_info"><table>';
		foreach ( $arrList as $key => $value ) {
			if ( MITools::isNullOrEmpty( $value ) && ! $show_empty_rows ) {
				continue;
			} else {
				$html .= self::getTableRow( array( array( 'html' => $key, 'class' => 'col_0' ), array( 'html' => $value, 'class' => 'col_1' ) ) );
			}
		}
		$html .= '</table></div>';

		return $html;
	}

	public static function getTR( $strHTML = '<td>&nbsp;</td>', $class = '' ) {
		$class = self::getClass( $class );

		return "<tr$class>$strHTML</tr>";
	}

	/**
	 * @param string $strHTML
	 * @param string $class
	 * @param string $style
	 *
	 * @return string
	 */
	public static function getTD( $strHTML = '&nbsp;', $class = '', $style = '' ) {
		$class = self::getClass( $class );
		// we need styles for eg PDF Tables!!
		$style = self::getStyle( $style );

		return "<td$class$style>$strHTML</td>";
//        return sprintf('<td%s%s>%s</td>', self::getClass($class), self::getStyle($style), $strHTML);
	}

	/**
	 * @param $strHTML
	 *
	 * @return string
	 */
	public static function getTH( $strHTML, $class = '' ) {
		$class = self::getClass( $class );

		return "<th$class>$strHTML</th>";
	}

	public static function getStyle( $style = '' ) {
		if ( $style != '' ) {
			return sprintf( ' style="%s"', $style );
		} else {
			return '';
		}
	}

	public static function getClass( $class = '' ) {
		if ( $class != '' ) {
			return sprintf( ' class="%s"', trim( $class ) );
		} else {
			return '';
		}
	}

	// Erzeugt einen String der Form PARAMETERNAME="PARAMETERWERT"
	public static function getPar( $strParname, $strValue = '' ) {
		return $strValue != '' ? $strParname . '="' . $strValue . '" ' : '';
	}

	public static function insertPar( $strHTML, $strPar, $strTag = '' ) {
		if ( $strTag == '' ) {
			$intPos = 1 + 2; // + 2 -> (Spitze Klammer auf und Leerzeichen)
		} elseif ( strpos( $strHTML, '<' . $strTag . '>' ) == 0 && strpos( $strHTML, '<' . $strTag . '>' ) !== false ) {
			$strPar = ' ' . $strPar;
			$intPos = strlen( $strTag ) + 1;
		} else {
			$intPos = strlen( $strTag ) + 2;
		}

		return substr( $strHTML, 0, $intPos ) . $strPar . substr( $strHTML, $intPos );
	}

	public static function getIdAttribute( $strId ) {
		if ( $strId == '' ) {
			return '';
		} else {
			return ' id="' . $strId . '" ';
		}
	}

	/**
	 * rendert ein Input-Textfeld
	 *
	 * @param string $strName
	 * @param string $strValue
	 * @param string $intWidth
	 * @param string $intMaxchar
	 * @param string $id
	 * @param string $class
	 * @param string $style
	 *
	 * @return string
	 */
	public static function getTextfield( $strName, $strValue, $intWidth = '', $intMaxchar = '', $id = '', $class = '', $style = '' ) {
		return sprintf(
			'<input type="text" id="%s" class="%s" name="%s" value="%s" size="%s" maxlength="%s" style="%s" >',
			$id,
			$class,
			$strName,
			str_replace( '"', '&quot;', $strValue ),
			$intWidth,
			$intMaxchar,
			$style
		);
	}


	/**
	 * Liefert ein Passwortfeld zurück
	 */
	public static function getPassword( $strName, $strValue, $intWidth, $intMaxchar, $id = '', $class = '' ) {
		// $strId = MIHTML::getIdAttribute($strId);
		$strValue = str_replace( '"', '&quot;', $strValue );
		$html     = '<input type="password" id="%s" class="%s" name="%s" value="%s" size="%s" maxlength="%s" >';

		return sprintf( $html, $id, $class, $strName, $strValue, $intWidth, $intMaxchar );
		// return '<input type="password" '.$strId.'name="'.$strName.'" value="'.$strValue.'" size="'.$intWidth.'" maxlength="'.$intMaxchar.'" />';
	}

	/**
	 * @param string $strName
	 * @param string $strValue
	 * @param int $cols
	 * @param int $rows
	 * @param string $id
	 * @param string $class
	 * @param string $style
	 *
	 * @return string
	 */
	public static function getTextarea( $strName, $strValue, $cols = 40, $rows = 5, $id = '', $class = '', $style = '' ) {
		return sprintf( '<textarea id="%s" class="%s" style="%s" name="%s" cols="%s" rows="%s" >%s</textarea>',
			$id,
			$class,
			$style,
			$strName,
			$cols,
			$rows,
			str_replace( '"', '&quot;', $strValue )
		);
	}

	/**
	 * Liefert ein Feld für Fileupload zurück
	 */
	public static function getFileupload( $strName, $intWidth, $strId = '' ) {
		$strId = MIHTML::getIdAttribute( $strId );

		return '<input ' . $strId . 'type="file" name="' . $strName . '" size="' . $intWidth . '" >';
	}

	/**
	 * Liefert eine Checkbox zurück
	 */
	public static function getCheckbox( $strName, $strValue, $boolChecked, $strId = '', $class = '', $style = '' ) {
		return sprintf(
			'<input id="%s" type="checkbox" name="%s" value="%s" %s class="%s" style="%s" >',
			$strId,
			$strName,
			$strValue,
			$boolChecked ? 'checked' : '',
			$class,
			$style
		);
	}

	/**
	 * Rendert einen Input type = radio
	 *
	 * @param string $strName
	 * @param string $strValue
	 * @param boolean $boolChecked
	 * @param string $strId
	 * @param string $class
	 * @param string $style
	 *
	 * @return string HTML
	 */
	public static function getRadiobutton( $strName, $strValue, $boolChecked, $strId = '', $class = '', $style = '' ) {
		return sprintf(
			'<input id="%s" type="radio" name="%s" value="%s" %s class="%s" style="%s" >',
			$strId,
			$strName,
			$strValue,
			$boolChecked ? 'checked="checked"' : '',
			$class,
			$style
		);
	}

	/** Ein sehr häufiger Fall füts Zeichnen einer Tabellenzeile mit 2 Zellen:
	 *
	 * @param string $left
	 * @param string $right
	 * @param string $style_left
	 * @param string $style_right
	 * @param string $class_left
	 * @param string $class_right
	 *
	 * @return string
	 */
	public static function getTR2( $left, $right, $style_left = '', $style_right = '', $class_left = '', $class_right = '' ) {
		return MIHTML::getTableRow( array(
			array( 'html' => $left, 'style' => $style_left, 'class' => $class_left ),
			array( 'html' => $right, 'style' => $style_right, 'class' => $class_right ),
		) );
	}

	/**
	 * Liefert eine Tabellenzeile mit Anzahl Spalten gemäß dem Parameterarray
	 * Das Parameterarray ist dabei so aufgebaut:
	 * MIHTML::getZeile(array('html' => 'foo', 'style' => $style, 'class' => $class), ... array('html' => 'bar'));
	 * style und class sind optional ,html ist Pflicht.
	 *
	 * @param array $arrPar
	 *
	 * @throws Exception
	 * @return string MIHTML-Tabellenzeile
	 */
	public static function getTableRow( $arrPar = array() ) {
		foreach ( $arrPar as $i => $arrDef ) {
			if ( ! array_key_exists( 'html', $arrDef ) ) {
				$arrDef['html'] = "&nbsp;";
			}
			$arrPar[ $i ]['style'] = ( ! array_key_exists( 'style', $arrDef ) || $arrDef['style'] == '' ) ? '' : ' style="' . $arrDef['style'] . '"';
			$arrPar[ $i ]['class'] = ( ! array_key_exists( 'class', $arrDef ) || $arrDef['class'] == '' ) ? '' : ' class="' . $arrDef['class'] . '"';
		}
		$html = '<tr>' . "\n";
		foreach ( $arrPar as $arrDef ) {
			$style = $arrDef['style'];
			$class = $arrDef['class'];
			$html .= "<td$style$class>" . $arrDef['html'] . '</td>' . "\n";
		}

		return $html . '</tr>' . "\n";
	}

	// MIHTML::getZeile(array('html' => $html, 'style' => $style, 'class' => $class), ... array(...));

	/**
	 * Liefert eine Option für Selectliste zurück
	 */
	public static function getOption( $strBezeichnung, $strValue, $boolChecked, $strId = '' ) {
		$strId = MIHTML::getIdAttribute( $strId );
		if ( $boolChecked ) {
			$strChecked = 'selected';
		} else {
			$strChecked = '';
		}
//		if (!is_string($strValue)) {
//			throw new Exception('String für Optionlist benötigt');
//		}
		$strValue       = htmlentities( $strValue );
		$strBezeichnung = htmlentities( $strBezeichnung );

		return '<option ' . $strId . 'value="' . $strValue . '" ' . $strChecked . '>' . $strBezeichnung . '</option>';
	}


	/**
	 * @param string $strName
	 * @param string $strHTML
	 * @param string $strId
	 * @param int $intSize
	 * @param string $style
	 *
	 * @return string
	 */
	public static function getSelect( $strName, $strHTML, $strId = '', $intSize = 1, $style = '' ) {
		return sprintf(
			'<select id="%s" name="%s" size="%s" style="%s">%s</select>',
			$strId,
			$strName,
			$intSize,
			$style,
			$strHTML
		);
	}

	/**
	 * @param string $strName
	 * @param string $strValue
	 * @param string $strId
	 *
	 * @return string
	 */
	public static function getHidden( $strName, $strValue, $strId = '' ) {
		$strId    = MIHTML::getIdAttribute( $strId );
		$strValue = str_replace( '"', '&quot;', $strValue );
		$tag      = '<input ' . $strId . 'type="hidden" name="' . $strName . '" value="' . $strValue . '" >';

		return $tag;
	}

	/**
	 * @param string $strName
	 * @param string $strValue
	 * @param string $strId
	 * @param string $strclass
	 *
	 * @return string
	 */
	public static function getSubmitbutton( $strName, $strValue, $strId = '', $strclass = '' ) {
		$strId    = MIHTML::getIdAttribute( $strId );
		$strValue = str_replace( '"', '&quot;', $strValue );
		if ( $strclass != '' ) {
			$strclass = 'class="' . $strclass . '"';
		}
		$tag = '<input ' . $strId . 'type="submit" name="' . $strName . '" value="' . $strValue . '" ' . $strclass . ' >';

		return $tag;
	}

	public static function getKlickbutton( $strName, $strValue, $strId = '' ) {
		$strId = MIHTML::getIdAttribute( $strId );
		$tag   = '<input ' . $strId . 'type="button" name="' . $strName . '" value="' . $strValue . '" >';

		return $tag;
	}

	public static function getFormHead( $strId, $strName, $strAction, $strMethod, $strEnctype, $strCharset, $strTarget, $class = '' ) {
		if ( $strName == '' ) {
			$strName = $strId;
		}
		$strId = MIHTML::getIdAttribute( $strId );

		if ( $strAction == '' ) {
			$strAction = Registry::getSettings()->getURI();
		}
		if ( $strEnctype == 'upload' ) {
			$strEnctype = 'multipart/form-data';
		}
		if ( $class != '' ) {
			$class = 'class="' . $class . '"';
		}
		if ( $strTarget != '' ) {
			$strTarget = 'target="' . $strTarget . '"';
		}
		$tag = '<form ' . $strId . 'name="' . $strName . '" action="' . $strAction . '" method="' . $strMethod . '" enctype="' . $strEnctype . '" charset="' . $strCharset . '" ' . $strTarget . $class . ' >';

		return $tag;
	}

	public static function wrapScript( $strCode ) {
		return '<script type="text/javascript">' . "\n" . $strCode . "\n" . '</script>' . "\n";
	}


	/**
	 * @param string $strImage
	 * @param string $strAlt
	 *
	 * @return string
	 */
	public static function getIcon( $strImage, $strAlt ) {
		if ( $strImage != '' ) {
			if ( substr( $strImage, 0, 1 ) != '/' && substr( $strImage, 0, 4 ) != 'http' && substr( $strImage, 0, 5 ) != 'https' ) {
				$strImage = Registry::getSettings()->getURLPathIcons() . $strImage;
			}
			$strHTML = self::getImage( $strImage, $strAlt );
		} else {
			$strHTML = $strAlt;
		}

		return $strHTML;
	}

	public static function getIconAlert() {
		return '<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>';
	}

	public static function getIconInfo() {
		return '<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-info"></span>';
	}

	public static function getFieldset( $titel, $html, $style = '', $class = '' ) {
		$style = self::getStyle( $style );
		$class = self::getClass( $class );

		return sprintf( "<fieldset%s%s><legend>%s</legend>%s</fieldset>", $style, $class, $titel, $html );
	}

	/**
	 * 1 Zeile 1 Spalte
	 *
	 * @param string $html
	 * @param string $style
	 * @param string $class
	 *
	 * @return string
	 */
	public static function get1x1Table( $html, $style = '', $class = '' ) {
		$style = self::getStyle( $style );
		$class = self::getClass( $class );

		return sprintf( "<table%s%s><tr><td>%s</td></tr></table>", $style, $class, $html );
	}

	/**
	 *
	 * @param string $html1
	 * @param string $html2
	 * @param string $class_table
	 * @param string $style_table
	 * @param string $class_td0
	 * @param string $style_td0
	 * @param string $class_td1
	 * @param string $style_td1
	 *
	 * @return string
	 */
	public static function get1x2Table( $html1, $html2, $class_table = '', $style_table = '', $class_td0 = '', $style_td0 = '', $class_td1 = '', $style_td1 = '' ) {
		return sprintf( "<table%s%s><tr><td%s%s>%s</td><td%s%s>%s</td></tr></table>",
			self::getClass( $class_table ),
			self::getClass( $style_table ),
			self::getClass( $class_td0 ),
			self::getStyle( $style_td0 ),
			$html1,
			self::getClass( $class_td1 ),
			self::getStyle( $style_td1 ),
			$html2
		);
	}

	public static function get1x3Table( $html1, $html2, $html3, $class_table = '', $style_table = '', $class_td0 = '', $style_td0 = '', $class_td1 = '', $style_td1 = '', $class_td2 = '', $style_td2 = '' ) {
		return sprintf( "<table%s%s><tr><td%s%s>%s</td><td%s%s>%s</td><td%s%s>%s</td></tr></table>",
			self::getClass( $class_table ),
			self::getClass( $style_table ),
			self::getClass( $class_td0 ),
			self::getStyle( $style_td0 ),
			$html1,
			self::getClass( $class_td1 ),
			self::getStyle( $style_td1 ),
			$html2,
			self::getClass( $class_td2 ),
			self::getStyle( $style_td2 ),
			$html3
		);
	}

	public static function getArrayJS( $arrPHP ) {
		foreach ( $arrPHP as $i => $value ) {
			if ( is_string( $value ) ) {
				$arrPHP[ $i ] = "'$value'";
			} elseif ( MITools::isNullOrEmpty( $value ) ) {
				$arrPHP[ $i ] = "''";
			}
		}
		$strPHP = implode( ',', $arrPHP );

		return '[' . $strPHP . ']';
	}

	public static function getPopupParameterAsString( $arrPopup ) {
		$width      = MITools::getValue( 'width', $arrPopup );
		$height     = MITools::getValue( 'height', $arrPopup );
		$top        = MITools::getValue( 'top', $arrPopup );
		$left       = MITools::getValue( 'left', $arrPopup );
		$scrollbars = MITools::getValue( 'scrollbars', $arrPopup );
		$resizeable = MITools::getValue( 'resizable', $arrPopup );
		if ( ! $width ) {
			$width = 700;
		}
		if ( ! $height ) {
			$height = 600;
		}
		if ( ! $top ) {
			$top = 10;
		}
		if ( ! $left ) {
			$left = 10;
		}
		if ( ! $resizeable ) {
			$resizeable = 'yes';
		}
		if ( ! $scrollbars ) {
			$scrollbars = 'no';
		}

		return sprintf( "width=%s,height=%s,left=%s,top=%s,scrollbars=%s,resizable=%s,location=no,toolbar=no,status=no",
			$width,
			$height,
			$left,
			$top,
			$scrollbars,
			$resizeable
		);
	}

	/**
	 * @param string $mixedTitel
	 * @param string $mixedInhalt
	 *
	 * @return string
	 */
	public static function getAccordion( $mixedTitel, $mixedInhalt ) {
		return MIHTML::getDIV( '<h3>' . $mixedTitel . '</h3>' . "\n" . MIHTML::getDIV( $mixedInhalt ), 'sc_accordion' );
	}

	public static function getURLAsLink( $url, $desc = '', $new_tab = true ) {
		if ( $desc == '' ) {
			$desc = $url;
		}
		$len = strlen( 'http' );
		if ( substr( $url, 0, $len ) != 'http' ) {
			$url = 'http://'.$url;
		}
		return MIHTML::getLink( $desc, $url , $new_tab);
	}

}
