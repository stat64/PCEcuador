#!/bin/sh
# This script was generated using Makeself 2.1.3
INSTALLER_VERSION=v00069
REVISION=23dda2f3a6e8313a582077db3c329006a911ae3b

CRCsum="679518682"
MD5="e185123917caea9c27cf547a42e96520"
TMPROOT=${TMPDIR:=/home/cPanelInstall}

label="cPanel & WHM Installer"
script="./bootstrap"
scriptargs=""
targetdir="installd"
filesizes="18706"
keep=n

print_cmd_arg=""
if type printf > /dev/null; then
    print_cmd="printf"
elif test -x /usr/ucb/echo; then
    print_cmd="/usr/ucb/echo"
else
    print_cmd="echo"
fi

MS_Printf()
{
    $print_cmd $print_cmd_arg "$1"
}

MS_Progress()
{
    while read a; do
	MS_Printf .
    done
}

MS_dd()
{
    blocks=`expr $3 / 1024`
    bytes=`expr $3 % 1024`
    dd if="$1" ibs=$2 skip=1 obs=1024 conv=sync 2> /dev/null | \
    { test $blocks -gt 0 && dd ibs=1024 obs=1024 count=$blocks ; \
      test $bytes  -gt 0 && dd ibs=1 obs=1024 count=$bytes ; } 2> /dev/null
}

MS_Help()
{
    cat << EOH >&2
Makeself version 2.1.3
 1) Getting help or info about $0 :
  $0 --help    Print this message
  $0 --info    Print embedded info : title, default target directory, embedded script ...
  $0 --version Display the installer version
  $0 --lsm     Print embedded lsm entry (or no LSM)
  $0 --list    Print the list of files in the archive
  $0 --check   Checks integrity of the archive
 
 2) Running $0 :
  $0 [options] [--] [additional arguments to embedded script]
  with following options (in that order)
  --confirm             Ask before running embedded script
  --noexec              Do not run embedded script
  --keep                Do not erase target directory after running
			the embedded script
  --nox11               Do not spawn an xterm
  --nochown             Do not give the extracted files to the current user
  --target NewDirectory Extract in NewDirectory
  --tar arg1 [arg2 ...] Access the contents of the archive through the tar command
  --force               Force to install cPanel on a non recommended configuration
  --skip-cloudlinux     Skip the automatic convert to CloudLinux even if licensed
  --                    Following arguments will be passed to the embedded script
EOH
}

MS_Check()
{
    OLD_PATH=$PATH
    PATH=${GUESS_MD5_PATH:-"$OLD_PATH:/bin:/usr/bin:/sbin:/usr/local/ssl/bin:/usr/local/bin:/opt/openssl/bin"}
    MD5_PATH=`exec 2>&-; which md5sum || type md5sum`
    MD5_PATH=${MD5_PATH:-`exec 2>&-; which md5 || type md5`}
    PATH=$OLD_PATH
    MS_Printf "Verifying archive integrity..."
    offset=`head -n 388 "$1" | wc -c | tr -d " "`
    verb=$2
    i=1
    for s in $filesizes
    do
	crc=`echo $CRCsum | cut -d" " -f$i`
	if test -x "$MD5_PATH"; then
	    md5=`echo $MD5 | cut -d" " -f$i`
	    if test $md5 = "00000000000000000000000000000000"; then
		test x$verb = xy && echo " $1 does not contain an embedded MD5 checksum." >&2
	    else
		md5sum=`MS_dd "$1" $offset $s | "$MD5_PATH" | cut -b-32`;
		if test "$md5sum" != "$md5"; then
		    echo "Error in MD5 checksums: $md5sum is different from $md5" >&2
		    exit 2
		else
		    test x$verb = xy && MS_Printf " MD5 checksums are OK." >&2
		fi
		crc="0000000000"; verb=n
	    fi
	fi
	if test $crc = "0000000000"; then
	    test x$verb = xy && echo " $1 does not contain a CRC checksum." >&2
	else
	    sum1=`MS_dd "$1" $offset $s | cksum | awk '{print $1}'`
	    if test "$sum1" = "$crc"; then
		test x$verb = xy && MS_Printf " CRC checksums are OK." >&2
	    else
		echo "Error in checksums: $sum1 is different from $crc"
		exit 2;
	    fi
	fi
	i=`expr $i + 1`
	offset=`expr $offset + $s`
    done
    echo " All good."
}

UnTAR()
{
    tar $1vf - 2>&1 || { echo Extraction failed. > /dev/tty; kill -15 $$; }
}

finish=true
xterm_loop=
nox11=n
copy=none
ownership=y
verbose=n

initargs="$@"

while true
do
    case "$1" in
    -h | --help)
	MS_Help
	exit 0
	;;
    --version)
    echo "$INSTALLER_VERSION"
    exit 0
    ;;
    --info)
    echo Installer Version: "$INSTALLER_VERSION"
    echo Installer Revision: "$REVISION"
	echo Identification: "$label"
	echo Target directory: "$targetdir"
	echo Uncompressed size: 84 KB
	echo Compression: gzip
	echo Date of packaging: Tue Nov 14 08:30:10 CST 2017
	echo Built with Makeself version 2.1.3 on linux-gnu
	echo Build command was: "utils/makeself installd latest cPanel & WHM Installer ./bootstrap"
	if test x$script != x; then
	    echo Script run after extraction:
	    echo "    " $script $scriptargs
	fi
	if test x"" = xcopy; then
		echo "Archive will copy itself to a temporary location"
	fi
	if test x"n" = xy; then
	    echo "directory $targetdir is permanent"
	else
	    echo "$targetdir will be removed after extraction"
	fi
	exit 0
	;;
    --dumpconf)
	echo LABEL=\"$label\"
	echo SCRIPT=\"$script\"
	echo SCRIPTARGS=\"$scriptargs\"
	echo archdirname=\"installd\"
	echo KEEP=n
	echo COMPRESS=gzip
	echo filesizes=\"$filesizes\"
	echo CRCsum=\"$CRCsum\"
	echo MD5sum=\"$MD5\"
	echo OLDUSIZE=84
	echo OLDSKIP=389
	exit 0
	;;
    --lsm)
cat << EOLSM
No LSM.
EOLSM
	exit 0
	;;
    --list)
	echo Target directory: $targetdir
	offset=`head -n 388 "$0" | wc -c | tr -d " "`
	for s in $filesizes
	do
	    MS_dd "$0" $offset $s | eval "gzip -cd" | UnTAR t
	    offset=`expr $offset + $s`
	done
	exit 0
	;;
	--tar)
	offset=`head -n 388 "$0" | wc -c | tr -d " "`
	arg1="$2"
	if ! shift 2; then
	    MS_Help
	    exit 1
	fi
	for s in $filesizes
	do
	    MS_dd "$0" $offset $s | eval "gzip -cd" | tar "$arg1" - $*
	    offset=`expr $offset + $s`
	done
	exit 0
	;;
    --check)
	MS_Check "$0" y
	exit 0
	;;
    --confirm)
	verbose=y
	shift
	;;
	--noexec)
	script=""
	shift
	;;
    --keep)
	keep=y
	shift
	;;
    --target)
	keep=y
	targetdir=${2:-.}
	if ! shift 2; then
	    MS_Help
	    exit 1
	fi
	;;
    --nox11)
	nox11=y
	shift
	;;
    --nochown)
	ownership=n
	shift
	;;
    --xwin)
	finish="echo Press Return to close this window...; read junk"
	xterm_loop=1
	shift
	;;
    --phase2)
	copy=phase2
	shift
	;;
	--force)
	scriptargs=" --force"
	shift
	;;
    --skip-cloudlinux)
	scriptargs=" --skip-cloudlinux"
	shift
	;;
    --)
	shift
	break ;;
    -*)
	echo Unrecognized flag : "$1" >&2
	MS_Help
	exit 1
	;;
    *)
	break ;;
    esac
done

case "$copy" in
copy)
    SCRIPT_COPY="$TMPROOT/makeself$$"
    echo "Copying to a temporary location..." >&2
    cp "$0" "$SCRIPT_COPY"
    chmod +x "$SCRIPT_COPY"
    cd "$TMPROOT"
    exec "$SCRIPT_COPY" --phase2
    ;;
phase2)
    finish="$finish ; rm -f $0"
    ;;
esac

if test "$nox11" = "n"; then
    if tty -s; then                 # Do we have a terminal?
	:
    else
        if test x"$DISPLAY" != x -a x"$xterm_loop" = x; then  # No, but do we have X?
            if xset q > /dev/null 2>&1; then # Check for valid DISPLAY variable
                GUESS_XTERMS="xterm rxvt dtterm eterm Eterm kvt konsole aterm"
                for a in $GUESS_XTERMS; do
                    if type $a >/dev/null 2>&1; then
                        XTERM=$a
                        break
                    fi
                done
                chmod a+x $0 || echo Please add execution rights on $0
                if test `echo "$0" | cut -c1` = "/"; then # Spawn a terminal!
                    exec $XTERM -title "$label" -e "$0" --xwin "$initargs"
                else
                    exec $XTERM -title "$label" -e "./$0" --xwin "$initargs"
                fi
            fi
        fi
    fi
fi

if test "$targetdir" = "."; then
    tmpdir="."
else
    if test "$keep" = y; then
	echo "Creating directory $targetdir" >&2
	tmpdir="$targetdir"
    else
	tmpdir="$TMPROOT/selfgz$$"
    fi
    mkdir -p $tmpdir || {
	echo 'Cannot create target directory' $tmpdir >&2
	echo 'You should try option --target OtherDirectory' >&2
	eval $finish
	exit 1
    }
fi

location="`pwd`"
if test x$SETUP_NOCHECK != x1; then
    MS_Check "$0"
fi
offset=`head -n 388 "$0" | wc -c | tr -d " "`

if test x"$verbose" = xy; then
	MS_Printf "About to extract 84 KB in $tmpdir ... Proceed ? [Y/n] "
	read yn
	if test x"$yn" = xn; then
		eval $finish; exit 1
	fi
fi

MS_Printf "Uncompressing $label"
res=3
if test "$keep" = n; then
    trap 'echo Signal caught, cleaning up >&2; cd $TMPROOT; /bin/rm -rf $tmpdir; eval $finish; exit 15' 1 2 3 15
fi

for s in $filesizes
do
    if MS_dd "$0" $offset $s | eval "gzip -cd" | ( cd "$tmpdir"; UnTAR x ) | MS_Progress; then
		if test x"$ownership" = xy; then
			(PATH=/usr/xpg4/bin:$PATH; cd "$tmpdir"; chown -R `id -u` .;  chgrp -R `id -g` .)
		fi
    else
		echo
		echo "Unable to decompress $0" >&2
		eval $finish; exit 1
    fi
    offset=`expr $offset + $s`
done
echo

cd "$tmpdir"
res=0
if test x"$script" != x; then
    if test x"$verbose" = xy; then
		MS_Printf "OK to execute: $script $scriptargs $* ? [Y/n] "
		read yn
		if test x"$yn" = x -o x"$yn" = xy -o x"$yn" = xY; then
			eval $script $scriptargs $*; res=$?;
		fi
    else
		eval $script $scriptargs $*; res=$?
    fi
    if test $res -ne 0; then
		test x"$verbose" = xy && echo "The program '$script' returned an error code ($res)" >&2
    fi
fi
if test "$keep" = n; then
    cd $TMPROOT
    /bin/rm -rf $tmpdir
fi
eval $finish; exit $res

� ��
Z�;kS�Ȗ��_�8ޑ=��IB�kB��*,0�M%EHm��,9z�����ytK-[p3�u��n�+L?N�>�Gs�Y�%�����Ӈ���&������[�O667�<}���񠿱��x��?�>y��� �}�������õ�E��q�a��~xzvp|�h#�I����޵����ɰ��{J�u2�L��/�$m�/�"˨!�㹙" o��eܐa*�&���(h4p�����kXt��2�e�q$ZGg织��SG!)�������{�w�Ng��F�Fi�Hq"�P�p�� D�+W�ӄ�?�UM�u��0��И3o&�q,��AtD��f��bQ�M��Ht�����D���\�V�
��m�O��ѝkJ����_���'}�ƙ�]�w�7�R_B���(�N�ؓ҇KW�����db��Z�1�Z	��i?��������cO��[�����E<������4	�L4���@Mѿ�e�\X_�k-G���Կ	��VtU'�2�.�T�D~˃��M��{��n4��������h�QKP)����Bjuj��L� E���w�hP�6�8�#�KX~t,���O�7��U*�q��>8�6��P�<
e���Q���4 ���؍|X�gHv������~��Q8�����tk��?y���������B"���}�~�����q��o<��o>}�*�xs���3��7�������WBχ�C{����/\ޝ��x:O��q&�7��w��!�������.JpSq*S�\Kz��W����a��l:��ʝ �=��]w�_�Cz���_�2"<�����<�I�5�	���qpd�oL]�ʽ,�V0P߶�<��k�e��}�&q��M��!0A$q��L)VB K�q���� �x�9��fc�#6`�5,tF�m��w|x|����;�Ɇ9�qxxx����V���.�\���P��ۢE3�pvz):��[p:�Y�D<��/G���v��[�s��|���&���vGXV�$o��ou�-�O��TG���~ŝve]{PH���_^��11S��?���7�VG���wgo�¢	k]4��!fFbq��=|��� �������B�F�8�OeڡÇ��ǧu��^aO���z�P���<������r8N��w�2�r��<����q��8������_��2�թ4���~ I�稹M����I�O����f�,���2	g�t0x�Y�N�hwx��9쇏9z&C�W����`p<��sto��ңodO���0;F�d&���2��>0F��.�&*0k�zÈR�u6Yz�w��q9:R�Rdb�Z�^S�%�9�q~0<u�v���w`��Rf8�u��M.S`m��^���@�dmP���Q������a�U���
Aks�[ �0"��$&NO3�P�.���֫�Dծq<��֫�b�3���}P�ʄR�YT�l��`L�仐�R֗Dkx����;�=:?�UE��5�����V4ضg�b�-���w��E���x>q�+��X�@��D��9��9��!#&�T�|`:O39��3v�'	:xL�M�� �_��f.�z�^�S�I�R��fUH��1�v�D��eݳ�9���1�19M�ki$�0�E�2b���,Aw���9@r��b�]-�,#��@-#��>��9�E9A2
3&�I����8�������f���_˕�����@+�}�hg �zT�;A���8���L�}�����v妋;5�~<{T�R����8��m<�b-��J7ʧխ��7'o�ir�@M����}/�Ia�ma�w�J�Vw"k�B3>a�n�t���S�l�pKt���0�Ate,�.Y��R��4܀�B�;+� �p������o/����PCp����~��=q�`䫇٢�����'%�k�_>�7�=��U�L�v��PD_�$���ڢ*���I$ujΖ�w��b9�8A�R����R��%��R�nг$&WEl[�v���Gi>��I&��y˺��}倛xc�(�pX���)�+"���ܩ���1/y�ē�$q��D��	��kh�E!�e`��a�}�P���Rq��hH�7
��.�^<� �����+I����X�z`�_��������5��d6���wnY��x4"��Q�01�E�������5G�� /�svm)�)�:!$S&p�5��M��L�H�2Oy}Qa��\�N� ��i�����|̽9���h\	�&!�E���Z�H�bH�/�|h7��H} ��o%�Wh�-#_UA�7�ľ��z�4�.��ZFj)�Usp�U�����{���r'3:�:P6�e�R�CA�9�n�G�v�����<�*J�ݝ���Sk![>���9mk�,E�0���
�:?`[B��P"@�@��i��)X�'A�11lkE���Q�ZR� ߿��X����;���H�.x`�@�X�a6֍#p�X��v��m 	�`^��q�	����RKy<93,)E�TY�`�,��0��gRi$��w����4��@I�
�t�3��D�3���B�%�Ĭ����$��p�����^Z���3G������h�i��52E�����`�< !��o�ɘ�{�S�l^t�b����T-j�Y��g*Xe�I�%�<q���	���1x�|K�j�"s4Q�����mz��������G4#d�.�1ff7lS���_�]��޺x��4*v��l�+@'�K�!XPw9?�?��	ēlVS�]�Al�a|"f�p��-&Mdf��Ro ّ��3�8�.�d�:j�RЈ!��Q2 w�6k���k���Op3-�:�*��4-��g�%��Q�dK���	�w��uz�Y��^�	��[�v�WXT�O���\�J�"%��k�>�w#����$���^ ��V��3��Q6�@ -�f�S9E$8hd��E����:i0�|�4:,�М��^�������Q��ɻ3�2�.�ǟ�jfG����">S�a�j<�Q����w����x�Ѻ������x8�t�:Ž�+�9��d�!�ϊj*�B�Ģj�ȥ�f'8���tϐ�e+S}�Ra���8	@������������@4��3�K��!���ו��%��\�Ju�_��&P!�7e���
 �pƐ%��` *D��H�d*�� ��m�n��Y�����
�zp)H��o�eM�j���¦��x�0�4kfY8_ɺ*Q��-#`C�sx�kE�CU���v�ZQ�$���)$w%O������^+~����\l��
 6pZ�C�g����wĦᆣ8C���8�@�//ŷo7fl�I��:(9
`*1�Km]l��X0>FH�B�H����(��$K���eQ ��L���]��q��0�w}2�;�����h�E�0d�*̻Q�MAp��5�a��|�֐���R���If�����!U�Q��ħ��B,�_?���%��0�2�0�`�2^��j�Pl�@>����C!x�c�QG5X�D
|���FC1�T�����/jk1�ۚ���"�7
�\ʫ�Ql$�4uf.���/L*�C��B�W0�4��?����>��8�S������g�s������ 4pXڝ���~MU�BWw� �x��ETLP��7�j���Ru�`�C�2n�����{j�l��f[Ma����Ʒ�X,hX^/�6
�N� ZF��i�+�j�����e���|D���Md7K�Q_z��"�U+��_�͕z$����)�ml e�ɻ�V��S>�d����1�2���R���G5	�g�P%t��������n$�	����[L�4�2��^�,5r�xnP?�8_Ƴ<%xʗ6�y��?��ĉ:��"#�%:,����W������ї��(�q�?�p��JD��ɕ�$��j�Vϗ�=�8���힋A)U���h�5�D2�ۖ���H��Y�ї��� �=i��~���#t_P� ��hʭ���Kg�a��{�W��%:�hD�i�Yˋ�-���YRf���c㬊.�lc��w�J����<'y:&W�p�̐�л���(��%�� �W�"u��/�Ib��j�B/(iTӦ(a���H{��^o�^jQ� ����Z�g̢���YF��K5j7V�1��c(���m��{*�e�yt٫��\a��jˎ���N<^�@o#����I��f<�6[se��f7�N���K�m��5m m���z�F:]L5�8�:w��~����@-�� �G�VZ�����i*i?������@��s�Tݭd�]�;ڦ�O��
�z��	L�;��x����@OA($?�W�=d蓇�o��N~���qal�H�#B�cDK�LЊa�5/ŋ�o����X���<6&T�VO�Q���UNK�5�2'کv����{_zs�\6|�����������ȑ��XD 0�Tժ\�͕�CL�L���iόAh��R<��e����6x\��U	Q���GsUgQ� c���Z\���MF 1�W�\��i ����)ڍ"�)z�����n`ˢ�D���xy�`��i�zZ����T: \���PYT�Q����j��*K�
�r]Ո��j����Ǔ��XLUp-[���E���F[G=ѹ��=⃢�������O�t����cqMu��;��lLx'�U��+&�T�jQ^6#[�ŁK���jR1M�j9�R��̀�*,q� W�/�$���̭�^e,��.�/^4�y5ǀ�2/Ȫ�	^����z� g�q-L�o/=��s��]4�l���Oe�	X(,�%Ӊ�v����@&�Uyf�/����M�E�:$J�2��1����ő ��U�zRQ׮�d	3�bo>��F�ytE������kM
��/��~/���%����kly�"t��Z�2~{�*��n��Sm�k��"��m�
;=�Qى���t����� t�
��WVJj^U�tOdٗ�V>����Gy
��G_`���-��3y-�5HΪCPs1q�(b�m����Yp}*���Z�]������;F�c~LI3E���O尢��O�l��k H�2��?O�~՚��Z�S���b��.�$␺,�(��ІtUҟ���e�Ų��7��=�}�����$��ƒ��Z�*�/q�z��JiUc�*G���򺃭��%�e*M)�\y�W�z;R�U��r���2�J�A(��B�"��&����# �I*^F�o������J�>;${1v���.�8��t2�0�PB��{X�c�A�C�!gA��ZR~B-W']a��Տ%?�"/�}.�b��6�X�����*فA7��?�?�t۟>���/�:��/�/���'��[����u^����r�hge䑙+,O�0��)�s��-^:�b�of-{�4�������M"c�=/���; �k	J%��%©�c��}�QjfnD	%�q�P�� �a��6v��F�)��Sm�P�V�a�����F��Ծ���n�\���Y`��,��Q��,GT���^zkY�5���j~���@}��uGnV�)q/X��K��
�wJ���SxF�WK�b�C�Oݻ�o���ar��y���b���]Q�6)F��3k͊���`�*1ԍ�T�1���ju�5�@}|�O.�

���nUs�6�p��F<�[T�Z���8t^�|� �_���W�"X,��nE��z����������%@j����@�*_)�=V\�s�ix� ��&�L�������6�-���-�K��;	H �Hڠ)��h[mM-J�w[��� Q�$$ ��XO��Z@-��R+�8CD����<�[݄?�@f�Ég���蝡�^.M'0��D1��h5o:��t����;� �n����fR�u�me��u1�i]������O��0ףa6V������.�d�ɚ}�<�a���tN���(w�^�:�{���W=��T=;��k;�W�鞏��F`���N��Z�~/j��w+N����Ŗ�~�]�w������ܣ��p 8����ҧ�${���Y|�+V���+�(��w� f���V�=|J�p�ܒ���BM�?ų�s���1�T��t�T*���?������Lw�j�o���p_|�_�&����e��ry��PJS���A�Bag�;�,�ghD��,Y-��-X��ľ(��%zE��̊�Ɗ؂!A����n?j$�mk*�_B����;Z�M�aT�'Yb�L�Z<sXP=E+�����O�?���Go�)�u�?JU��o����d�7E�~�]y�*fֻCu�Dw�j����zՂ�,?5U�;��f�ۋ"]2.V�W��I�x���V3�mc.�#k�.�&�vm GVĄu�ҡ��e��$�I�k(�6^�@�Z�'�ї�}"0����:2胧6���L�q~��Z]|Խ�8�����~P���X�g�Ո`������Xw!��[g��$�����k��ξ�p�nky8���x���ؓ��P�y�x����Rd����(����>Avp'�V�*�jq���������{��ۿ�W�J2�}N�0E%�|9�i]�1��Ѿ���lJO��'
��u���U�M�`���h�@k�V��Q�������ի�H,4�0�J��`0>G�|�[��(�36�6�=����33�:�n�#���Mk��5uto:M��&>~r;���w�"�O�Ǻ~��2�c�h����X��L�<�"z7Wyz}�c�ِ����&�4�`i��00�Ao��z9˩��i����o&j��&N��>�D�Ip��?�Lj�2E��wqtbB��Yهt8dIg<<�h���s	��l����0��?���n��Ż��.+K{=-x2�L���X`�<�6s��+;��x�^���[l��t�	�D}a��H;�@�Q$��-(B��5�,E��^zj��qh��.��_�2��U6{�]:*.�`��܂u6�-��C#|�⋋��2�w(u����!%���4�t]y#ߚfpjM�T
�G��[m6ru���E�gѳR�k~��LoL��ي/��\l��D�= c�+A���)Y�ss�%�*��\�
��و<�B�Ғ�q�z��A$����%5<��Ă?i@���*wJL�9A>�m�[ĝK���x��g�dBJ�71H�9^t��7H�vG�k�w��*���
ގ���	���c��U3�5[h���H	o�M2%`;��u�5�Sm�3f�'��E�Uĭߪ��Ҟ����%���A+��ig0��+�9�� iBSo6g՝��MY��� O�I�MM����>�9霽���T���F�Ey��b�|�-~�=3�b�(E�V�-M$�E��9՜~-=V9�����%�3tf5�h�X����\'����WU�G����?����.-*0�=m~�!�߿��nF~G���i+X��zS>�r^���Q�%�w�,�A�Aʡ�ψXu��~Vv⺩"V#P���{�R;$�l�UQ��i�S�X`r�n�O]=U�-W^B����H^D���6��f�}�3����_��G���RԈ���:�p+N�=�Dn��xΤ+M��b0�N�A�ru�g5=!����730�3��Ve�c�a��
(�s��.3���O�����e��Q"\i�����FGֱz7K�}�P(�8w@_ڃ7f���ZE�����3�i�$�����(^v�0��=R��h$��|�ɽ��C��VO�|pS���m���k';;f	��<��h���.���ƃ�=�
����۝� �d_����z�!j��4*�J��j'>x0RK�Z�l>������˝JT�P���sJO��3��7��Y�p,��G-T�~r���O���/A	S��4�ޗ���H�������j�G]Q���Pɐ���B��|ӄN;�^�D{jXp�Ǜ��+
�	}� ���\z�P�n�v:���w�l3��N�/�Y��(|�� ��x}U�N�v�$�qW-�v�tk����`48ُJ.V:\͍V��%t���8`+|�)��GK�������q~��G����m���~'��8����o|��y�6�*�F]��a����Y�wO�YK\�)�� ��L���w4&L��E��Q\n�x�b2�	=,��X�!���0H��kA��]X��A�lFY��Q�"e�k��̀��N?x,+rˊ"�ð!:�鋸*O��|͘���5Y[[�^�m<����Wh�+�E�6���8���'QD�q��k�����/��y��L<�@��QU�j��.��Q����`Z4UC��ɚ}H�(M�F|!U���@s���ښ/cM��j_����rĀQ�'w���<�p�����$V˘j�Xl����o���w�r90��j|6��d��~�
J������y>W�j����A�����4�X�^)B�z��Ѭ�^� ����!�#`�e���m�;W5j�\#�XX0V��΋�9����h��g����_\�Mo�Km�$�=ѢO�!C\?��_*=)"09Bi�a���K"���Վ|�20pgt�֭��~��飧?��w����}�2������(�{��얓�7��γv�Th

�	�	�$�0����,���U���|'��Y�`6�y=}�K�i�x@S)�޸l+Ϧ��?bj!WDqRx�'�n\�ey�u	�z���A�"[(�:3K���zY�@ c���v=D����?�=�$�[!�������y�6vpL3V�L���쇣�?gO'��V1�w������P�ѱ8_,��`����oi\�b����Kh�Ee�x�A�8vu۵n>�6�/Y;:§�Cv�%Z�+*w�E�w�Gg9!����tD\����8�
��o�$�
nn<�T�K^:����+��m2р���.�z�=��6��f�'�]�Ś�K���]2�h	M��{к�LQɩ�6IJ�\�f/-�<W�X�&1p�urψh#����aU3Z�6
ᑂ�X|F��a�PO����$5����Q -�@�A.�ť�3�A
N��'�'G��1�IO�!��w�Y�8-k^-g�AF��k���VW�"���**�֩܈��dQ�+m��s� ө�3>>@��4���ͳ�;���ǿ�1�*C�,�T�
!GQ��c���Ֆ*V$���m߂��F	�,/f )��Z�]��R��|�|_���Z������좮�Sg2��!��j�L����K��Y0T�B+�I���/j�{�`�L/��\d>���30��uD�7ꞯsl�c���,'�&?��'[�'w��Nԝ|:��l3�R��|/���;�yg�-���s5@?���#�}+ݏ6����IA��1�a���?t]��w�U���(�H�!��`�8R[�п���� �|l�ł�ǊV,?7�>�<ǋy-] �O�Zy�Zչ���?p���2
�n0��`R���ٞ�m��O�V�tO��(����S��j���ZE��MgOf�����|l4r�]VD )��ҹ�/�r��	��q"� �5���o��5�ڏ�"R~�Xuq�P�|,��cN�Y��FGAڳ���3H�C�.)� ��om��ǭ�0�;�;`#�J�߳]C��������^l�e���mv%��������ad���R��@X�4 B�����pa~�p6	^���q��q["j���/� N�%|�����=���6�SjR�e-G|י*�(r	@��\
�#� v��t�,(�B��J!0�8�^:��{u��Zp�xH�����-�N��9�btcՊK��+W��RH���]{�l֫�u􆙁Գ�!/�6�˞��. ���c��Yc3��A-k�`:�	�*�'�j�2��]6��@��gIt/vR^(�����-+��j7Z�Ә0�4G갏��`Z	�>G6�]9H�ɉ[����(%Kqn�N��[H�}:�T�Y�_̇����8��$Ջ�cG�^U�&�(^�x"�.��vF�9��l�I�t=��^�S�������3�G���Ԥ[s�JѸh+�-</�H
�G�0�Da~O�@� �bHBt���t���x�Y]Z>�ީm\6���p���0��j/�̆�m�Ca�*&o��0*)�0�5�l܉2,�`j��(i���q>2�� ��@ �]dl�� ��̗P8vd2�<�3�� Va��֬���@7��}2ٰ�TI��Nƹ�&�Ʒ�-���%��o�Feč=|tt��c���ba
0s�����kJ�ZczU�6R�A�����S�W�%��]�h���"�+��?�tqD�<b�|�䄖����_P�"+�����k���/����v�'c"�j<Az�LĲ����c��
+��SDi����bɣA���/e��+�M߾WGu�4W_d�9����	j��ߡf�t��o�~����:�vk�Ρ;�CCp��Y�AwX�fV�1o���!��lu4&�����=R�,*H�xQ��PD�pw�N�j8��Yjk�LG��`!�[��!v&���j,�8������"-�Y��(}K��ř�(���b�ٶ�Oi�i2� Ƿ�<�ȟ�U�3��.�A�����` \����'4�ά�	������fAC�5'�Uh�݅��b����]��Pz�b���D�k�t ��pM3A��G��|^U<�|W}b~�{�N
���t}�$�9�(ըۮ��<R��IZ|nӓ���/=��暍ǃ��A>�i��iZH+�R��,�n�:��R)Z�V,P�v6�O:�|�u����K>:�W{����:�`��^_�c���?��I:TLP
.���"�T���p�m�?A���Hv��,�:��á���ڔ���.�58�̘ O��[�VDf�1��-��J�̨��x!(B|��s�e�;C�Es]��������_*��'Ż�/����.o�6���f�]���<�ޖ�Eu4��R�iu:hҌ�β� M£ Ϊ7���A�C�":�!������$i�/B��o����BCۖ��p���-��_�M�ltZ��s�����pfd�u�f��K�ŊA�h�Lm��� �ұ�E�|i�%�AQW��ZZ`������-�3O�" 1�`���w�lzA��Q��%��_�bW��X�F�7�%8�V'ۓ���x
��j)_� �VR�E�!��^(�_��R�jd
&������"Є�KqD�]��H���EF���}���l������ӝ�]G����c�p�P?>k�~g�1<r��"��@q�(�ƕ�W�fwL5	pF�N�`�������W�b �<bT����-,]�2�=���έ�@>)��o�)S��8���<d��2��v0%	0���@��ďK`�S]���Tw]]�U%Z�ߓq���^ӷD�n1�Mu�ֹiun�ݵ�u)�/�����NtUg�;j�ag�*���{��cT�����x�R����V�9��\�^j���z�\:%3�C�o��-]�6g}r�V V^�q�5~�ܸ���]G�X/�9�c��\1�G`
N��t���&B�!7ۙQpM8G��-)�;�,�j�#p�bSj����]�/F��_���IM��ms�%7/�ٴ��3��!�Sc��Lz�E;+�r 4s��Ɉ9:z���wG�%���E_�:�d@��C`!�hE`^&)aqp<m^�*�k�	S�d�JDJ!)Q|�*0�p'MN|!8e���c�*�¤��6��&/f����^�����J΅�����0��4�vQ�2T�����;���I�8W���NZS%Ԅש
��4n����:�Q�`�Mǣ�o����S�$�'�-[=��D��<�_F���d����+"D��~�.5�������;۰��V�� $Q�`CMT�	�!1ȑ4)�V�C��,AR�ŵx�~�"��cP��*�QL��*_/��F#	�0�Ht�"r�hojX+����:�N����GO�Pin�_a3��l��F������-O�F�X������W����q8�[|�P7���6B������!��Pcs7���5��W�_+��U��Y@����ƣ*�?V2rXژ��#asL�B͙���0�p�I��3��Y��xiʓi�	(��������-�F��I�!m���"���t���l���y#	�|:�<�#�q�j@ZIwG�7�/3���.�k��u��#c�d�٢�V���m '>�]�t&V<O)���scL`���%�.��Źdg�����M6 
�:xq� �Ev@|�b%�{E�	�1������Ȁ� ����UU��րl�^�����} 
�(����f�܈M��L����O�GR�a�Y��nփu���H�*��*.��_�\�ڗ�����ol.ӷ۩s�z�s��9bp���n�,��9�Rw8 ����	�/ � �޻}�"��il�^q>I�&��ꫮ~H�fC�=�k^Ovi2�<��o����Y��\m2o�@Z��O
��T4t�J}4d�1ga������'6��'��!u5�Gy�����Xҟb�S��1�s\�]^�0rY�y ���� Rd�BZgh�ߋ���L݋�M�v>o�N��]o���O�'gr����������1��������Q�1F���A�ݑV���Ԁ?��7�#k7���C��H�!�s����0����Ի˿����~.o�Vw�+E�߽�,���ʟ���1@B.��Z��Æ�����A� |����t��)��P[��*8�8�+��x���/���d>}Ln����,<m�.�����F�^<�N��BRDX��˅��kT;Y�Gf�\o�����o�ɦ=̊p���#�y���=�9��"�R��Sqk�-r�:D*ǃ��j
LҼ#M<ZF@)t;�Z���	�M��f�z�L�D�yUBk!����Z��q��HL����`X3�=SI{7�g�J�@���c�Pp�Z/X�f�M�+u��7�YE�vY�tZG�GP�Ic�}�l%S1����%=��=���w4p�х����2L����O�Ԉ}�!���h_;z��-S�^�S7�:e����H�&����p��EvI�ē�<�[�`m����0���]��duj�����)�|���خo4�A��J&v��:���Ag���j,�t�i�����d�W�:v��.��7��0�T0�H���S��M/����RxvN�.�O?�ñ,m��%:�(�|}��ӗ������p��Π��Λ/�w��/��O�4�?їw���v^nF_����Gw����:�	~�N�.c�i,���
�&����W��{���a�@�p���b�y����,�M�	��H�d�~�����L�hX�YJaֶ�&�&�N����� |/h������W	Fʠ�<��Z��q��?�IP���g+�:���rU'+�x�X��P��A�vqx�j�R;������E�8��Y:C�C�YkS�� =5``���|>q�o;p�e���Vh��V�AW�'����d�~�6T���T�з����Q��I�(�J�GM�(�)��X7d3��.|l�g���M�p�@q'�.�r�/��j^��рXe�k$���;Yv����>s��]b��J4�"�kռРG�r�"8JЕ�}A�و�@!|�����׾ŞSp�6�PA+��� �I�<C�'��!4�:O�<�"Fz�W�#S�õ4��ս}��t�4��!!X���Mr��������O�뷗�Tn���#߹�Cn&� b��.�R+�`�A�
�,}�Ml�64�E�!9�jC� ��G{���Zo����:V����{m���[��|g�U�����ۣp�ײ/�Cz㱟|K���������q��>Xd�s��ӴsY|F�~�g�ص�ȂThbM)��A��k2���@�M��5���~yJX����
�bM�
�f�D|�]��X�8�	V�
)�ʟ�*���㕩ɵ:G#ښ�ڋ�O�*S��ÿ��S��W-#�>U�
�ee||�Aܧq�݄c�!���Sr��ڗE_o.��3T^1������g0���e��K
.p����B��dC���Ra�G�3TQ���)|}y��	�^��a[\詜lJ��0�!��� @b�4r��ŘD1��-6E��� ���H�E�r]Øw �	=�ޠ!��PZ��9A
�X3@ �o9�T�D(SՕE���n�����!���0�Ţ_�I���"���ض�x.�0��Я[�E�D�p���+FC��,[�.7�sJ�u;C���68]R�DW���F+��+�b��^0X;�&�k0�m����Z!��F�����2YEH��H�h��#c���a�o����6:i�Θ���ݔI*��E�fF�e&��u�Bd>E��3�#�f]�ɞ87��NTD;m��$l_i��ӈ�6�_����g�߸�2���TK�ݏ�'���?�C�l�ω��d�LLna��l�:u�8�a�W��|}K��M��u��;��TE��gQ�M5s�vYR�P^�c�|�uؕ��R��_�v�.ѵ�M�n��k?�����n�UG�ѿ��u���6�������zs��ۭ���y��q~\{s'��Q�;ADti��xC�O)�
$ȂT�����1��jܩ��G�P >�G'��e��B�"�� �FZ�g�P�iO��x�^��*ą,�P��#�ry�c"id���n��/��}:瓔
��d3�L�l����?�
�qf&���B��
!u�EedsY|��)�y��d�=!r՝�<���R��]�ÿ�Kɫ홺��а�8x@�ʊՋNWu��t6R�2�����`XV���R��U��PL�# ���)/3��=fi��?���X$gi ޯ(9��X�3��챋�({㚹l���u�r˦j�, �"zԓ���	�2� }8��Rg�@���}��ꚊfX�	���|rJ��Z!�����잊�y=��~�X�0j�{p�U Z����f��d/ؚx!�6{�u�N�a<���c8Q�O*�<ش`�ڑT��(��qߑ���ց��a�ǚ�b���4�C{V� qB�
'3\U� �X-�r-R�|�GtW�r��w�%$��v鷿H����Zc��m��<���Q+���������w�;ʫp�T?�#�߂o�a�(��N]��$��3�r�M�Vy0NH���W���_T��ŏ' ���l�����ϡ�i��$�sS{$�s7�v�[b�Kk�.�LH͜�v�ԣ�hƠ��;lЁ�3j�4�}Br?��X�E��d L�pgCB+C�o��0ׂ%d�>�	�j˳�\�v�������0�Mi\$����6��ͰF欟ے�y-;T���f�¦Z'��Ĉ� �v�L�4��ܖq���2��^�Nq֧$h��b�2ܭ΋�)�eP|��w�N���E�2Qd�D�7��P��i4:s穮agӷ]t�He�y�5~3<��BT��z[��
��+t�C��0.t��m����"�h�n�ݟ9C����T^+��?�503V��_�����I��s֢�M�Xפw���b�~���1��v+q�5�f���G���P	&F��� *��-#/f� !�+JK�pV��-���ȖP_xX�+��J+$C�����u���
���,ߠ/k`)+bP� 䌚6��E�"ن�?럂� -�8;��A�taro��������q��IA��(6a��|��@����}�����#5|�-�O� �c�"��%�ɘ��ۂaM	��?��W�/�*@U�Sߐ3�⩦-�2�[����9E�l��\��j�����d�G,= �B�S+� T"8%܏Ѯ��!(��HB䟛y6s��a�h�ë
8�a}�y��m�P���!���k��Ƕ]�Q���(�v�cdE�K 0�B�q8�����(k5��P?8$~M�I赏�,��XۤF�14Ӑ��WR��A��Ѻ�L�}h�F���p���w�u⽐�W�b���\����0�<�u�z����%�<�a/1s��nX8d��������eq�U��G�/Z�xx�Y���M_G
���͌�&�y�H2�\.n"������(�)x�Z�O��M��U����Xo@MGZ��=��v���������	_c���tʠ&ZN���XWx.j�=�JG�� c�^���²�?TrS�ޕ��I �n�c�!W�U-\h�]}��?��%���N_XGIt��b�3
�)p0��"ʒ�$ʺ�Y��H6�N�Q�H�g�cջ�P#-���pSm�o�oj��H����K;T1��8I�;�MGi#�(׿[�$E>07<�Osc�)�h��S��Sr,���yf��R1��%���Ҷ-
�D0-+�b�OYv]n�)�%�P>���Q_1��u�,���"���|uBr��%�m%�� �;��PTd)��`y7VV�IH�X��8�%vYe��>~p����y�q-<?ԁ����6��>����@,?-S��l���0Ot�eP����)�[�ӒsJ�{]<&��\&v�DB�>�KXNٸ`�g�|tkro��r��PLܣ�i�]X#�@yh�AP3�#�v}�O|6­���}�Ċ�*���� ���F�s�˦�A�'��(h�"�aV�KX'�U��q�1
��X��T
܀�&�)����5_h�"�W�@*��l�<�Mk�͕B�����n��1ff���������;jP1���(��ƶ���c�M��&�hT�3��I~�!0�/�7Ϛ�Ϣ��E�][D}�^�6��+���"\0E2"Z�@T�ȚH�VB�ThI�̽V���Tdz6ª ~)��t�x�X�/�L��o�|XL����l�0�m����"���ms�x|���<J��M�w���ۤ��	���vJ���3%EGl)8o!���:�K�B��kԾ��1�N�i��k�!���; ����w��h�G�$�ߥ����A3��v�+����+�S��Xi���5��G4ktĠ��!U��F�Q�NuN��q��������G�I����'@?����� ��낯�$Z�%��/L�jTЩQ��@�I��=�l>S���f�[���T>ډ�ô禤*�MR�:^�������o��?zx�臨����}���b�#0��������c�Pi����1Z�9G����s+ѣ��4V��q�鳗/={�zz��0*%�f��w��(L-,�K�M���ь��\����mϪ�}wP��d�|�C,���&Dbì����W��t��Wľ�����ɼ=�w�h:g ��Ym�Q�̆��~��a�"�*8J�]�����%C+^}MV����d��Y�,�΃��i7�n)��%�7RKx�0�-�0�x���l3�������A���K*��L*А��a%��Jt��L$d��6	K�h�ĺl���.U���WE�|\�-��W/ɿ��b }�ǩJ����~�l��ɪS�sH5��ZM�t���)���b��I�MX�r�����B)�>oN��9�����$iɷ�(00-=+������T��K*�I�LJ��Ʀ� �4n����g���]D�W`�-u�֯Ϗ�!p�{]eFA:o~Q[0"����=��}73.���f)��r��%��5m���U��$Kĝ��E�I4��!$�wH#��g���q��=Y�MT\���&�T����>E\0t����Л�{�k�T�-p�QT�����~F�}"M=�7�}u�4��r`��MW���h�Y]UO�ނ6������Z}|ρ�����\'��t���>N������jB�}�m��ςc8��E�tٳqي"����r���j�y���v���63��m#?j9����z�b�g�
����������JT��p�S�\ŉ�洱7�ҊI"����J�����b��LW§�=l�΀H7o�j�̤�x��c�i�̪]{m��Yҡ�6c�{��y}Z�M���a�È�;�r��n.��̥��xǒ+Ո��|����TƧ�?�����ܽ����[����[���۸����Q������E��b �`<E��t׽�o����񺾷��w�>dhJ�)<����G�ot��E�_K?�	j~m���I�1�!ms@��Q�Jh��7����X�1I�[������vxC����_m�����]���ۍ��w�����n�����f���������}~>|q����?���������f}s{wgw�}g����K>���<x���E�W��{����^��onu��fo+�ɾ�jl��_m�ww������*i�u��f[�]z���|n>7������s���|n>7������s����}�/���  